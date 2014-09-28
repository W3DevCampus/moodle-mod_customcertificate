<?php
/**
 * Custom Certificate module core interaction API
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/mod/customcertificate/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->dirroot . '/grade/querylib.php');
require_once($CFG->libdir . '/pdflib.php');
require_once($CFG->dirroot . '/user/profile/lib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class customcertificate {

    const CERTIFICATE_IMAGE_FILE_AREA = 'image';
    const CERTIFICATE_ISSUES_FILE_AREA = 'issues';
    const CERTIFICATE_COMPONENT_NAME = 'mod_customcertificate';
    const OUTPUT_OPEN_IN_BROWSER = 0;
    const OUTPUT_FORCE_DOWNLOAD = 1;
    const OUTPUT_SEND_EMAIL = 2;

    public $id;
    public $name;
    public $intro;
    public $introformat;
    public $timecreated;
    public $timemodified;
    public $width;
    public $height;
    public $certificateimage;
    public $addphotox;
    public $addphotoy;
    public $addphotowidth;
    public $addphotoheight;
    public $certificatetext;
    public $certificatetextformat;
    public $certificatetextx;
    public $certificatetexty;
    public $introcertificatetext;
    public $introcertificatetextformat;
    public $introcertificatetextx;
    public $introcertificatetexty;
    public $conclucertificatetext;
    public $conclucertificatetextformat;
    public $conclucertificatetextx;
    public $conclucertificatetexty;
    public $coursehours;
    public $outcome;
    public $coursename;
    public $certdate;
    public $certdatefmt;
    public $addphoto;
    public $userphoto;
    public $requiredtime;
    public $certgrade;
    public $gradefmt;
    public $course;
    public $coursemodule;
    public $context;
    private $orientation = '';
    private $cm;

    public function __construct(stdclass $dbrecord, stdclass $context = null) {
        global $DB;

        foreach ($dbrecord as $field => $value) {
            if (property_exists('customcertificate', $field)) {
                $this->{$field} = $value;
            }
        }

        if (empty($this->coursemodule)) {
            $this->cm = get_coursemodule_from_instance('customcertificate', $this->id);
            $this->coursemodule = $this->cm->id;
        } else {
            $this->cm = get_coursemodule_from_id('customcertificate', $this->coursemodule);
        }

        if (is_null($context)) {
            $this->context = get_context_instance(CONTEXT_MODULE, $this->coursemodule);
        } else {
            $this->context = $context;
        }

        if (empty($this->coursename)) {
            $course = $DB->get_record('course', array('id' => $this->course));
            $this->coursename = $course->fullname;
        }

        if ($this->height > $this->width) {
            $this->orientation = 'P';
        } else {
            $this->orientation = 'L';
        }
    }

    /**
     * Get the file info of certificate image
     *
     * @param $context as context of certificate
     * @return void
     */
    public static function get_certificate_image_fileinfo($context) {
        if (is_object($context)) {
            $contextid = $context->id;
        } else {
            $contextid = $context;
        }

        $fileinfo = array(
                'contextid' => $contextid, // ID of context
                'component' => self::CERTIFICATE_COMPONENT_NAME, // usually = table name
                'filearea' => self::CERTIFICATE_IMAGE_FILE_AREA, // usually = table name
                'itemid' => 1, // usually = ID of row in table
                'filepath' => '/'           // any path beginning and ending in /
        );
        return $fileinfo;
    }

    /**
     * Get the file info of certificate issue
     *
     * @param $userid as id of user
     * @param $issueid as id of certificate issue
     * @param $context as context of certificate
     * @return void
     */
    public static function get_certificate_issue_fileinfo($userid, $issueid, $context) {

        if (is_object($context)) {
            $contextid = $context->id;
        } else {
            $contextid = $context;
        }

        $fileinfo = array(
                'contextid' => $contextid, // ID of context
                'component' => self::CERTIFICATE_COMPONENT_NAME, // usually = table name
                'filearea' => self::CERTIFICATE_ISSUES_FILE_AREA, // usually = table name
                'itemid' => $issueid, // usually = ID of row in table
                'filepath' => '/', // any path beginning and ending in /
                'mimetype' => 'application/pdf', // any filename
                'userid' => $userid
        );


        return $fileinfo;
    }

    /**
     * Get the certificate issue of a user
     *
     * @param stdClass $user as the user
     * @return stdClass the newly created certificate issue
     */
    function get_issue($user) {
        global $DB;
        // Check if there is an issue already, should only ever be one, timedeleted must be null
        if (!$certissue = $DB->get_record('customcertificate_issues', array('userid' => $user->id, 'certificateid' => $this->id, 'timedeleted' => null))) {
            // Create new certificate issue record
            $certissue = new stdClass();
            $certissue->certificateid = $this->id;
            $certissue->userid = $user->id;
            $certissue->username = fullname($user);
            $certissue->coursename = format_string($this->coursename, true);
            $certissue->timecreated = time();
            $certissue->code = $this->get_issue_uuid();

            if (!has_capability('mod/customcertificate:manage', $this->context)) {
                $certissue->id = $DB->insert_record('customcertificate_issues', $certissue);
            } else {
                $certissue->id = rand(0, 4);
            }
        }
        return $certissue;
    }

    /**
     * Get the user's photo
     *
     * @param stdClass $user as the user
     * @return void
     */
    function get_user_photo($user) {
        global $DB;
        if(!$userphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $user->id, 'certificateid' => $this->id)))
        {
            $userphoto = new stdClass();
            $userphoto->certificateid = $this->id;
            $userphoto->userid = $user->id;
            $userphoto->userphoto = null;
            $userphoto->validationphoto = "notvalidated";
            $userphoto->id = $DB->insert_record('customcertificate_userphoto', $userphoto);
        }
        return $userphoto;
    }

    /**
     * Returns a list of previously issued certificates--used for reissue.
     *
     * @param int $certificateid
     * @return stdClass the attempts else false if none found
     */
    public function get_attempts() {
        global $DB, $USER;

        $sql = "SELECT *
                FROM {customcertificate_issues} i
                WHERE certificateid = :certificateid
                AND userid = :userid AND timedeleted IS NULL";
        if ($issues = $DB->get_records_sql($sql, array('certificateid' => $this->id, 'userid' => $USER->id))) {
            return $issues;
        }

        return false;
    }

    /**
     * Prints a table of previously issued certificates--used for reissue.
     *
     * @param stdClass $course
     * @param stdClass $certificate
     * @param stdClass $attempts
     * @return string the attempt table
     */
    public function print_attempts($attempts) {
        global $OUTPUT, $DB;

        echo $OUTPUT->heading(get_string('summaryofpreviouscertificate', 'customcertificate'));

        // Prepare table header
        $table = new html_table();
        $table->class = 'generaltable';
        $table->head = array(get_string('issued', 'customcertificate'));
        $table->align = array('left');
        $table->attributes = array("style" => "width:20%; margin:auto");
        $gradecolumn = $this->certgrade;
        if ($gradecolumn) {
            $table->head[] = get_string('grade');
            $table->align[] = 'center';
            $table->size[] = '';
        }
        // One row for each attempt
        foreach ($attempts as $attempt) {
            $row = array();

            // prepare strings for time taken and date completed
            $datecompleted = userdate($attempt->timecreated);
            $row[] = $datecompleted;

            if ($gradecolumn) {
                $attemptgrade = $this->get_grade();
                $row[] = $attemptgrade;
            }

            $table->data[$attempt->id] = $row;
        }

        echo html_writer::table($table);
    }

    /**
     * Returns the grade to display for the certificate.
     *
     * @param int $userid
     * @return string the grade result
     */
    public function get_grade($userid = null) {
        global $USER, $DB;

        if (empty($this->certgrade))
            return '';

        if (empty($userid)) {
            $userid = $USER->id;
        }

        switch ($this->certgrade) {
            case 1 :  //Course grade
                if ($course_item = grade_item::fetch_course_item($this->course)) {
                    $grade = new grade_grade(array('itemid' => $course_item->id, 'userid' => $userid));
                    $course_item->gradetype = GRADE_TYPE_VALUE;
                    $coursegrade = new stdClass;
                    // String used
                    $coursegrade->points = grade_format_gradevalue($grade->finalgrade, $course_item, true, GRADE_DISPLAY_TYPE_REAL, $decimals = 2);
                    $coursegrade->percentage = grade_format_gradevalue($grade->finalgrade, $course_item, true, GRADE_DISPLAY_TYPE_PERCENTAGE, $decimals = 2);
                    $coursegrade->letter = grade_format_gradevalue($grade->finalgrade, $course_item, true, GRADE_DISPLAY_TYPE_LETTER, $decimals = 0);
                }
                break;

            default : //Module grade
                if ($modinfo = $this->get_mod_grade($this->certgrade, $userid)) {
                    // String used
                    $coursegrade = new stdClass;
                    $coursegrade->points = $modinfo->points;
                    $coursegrade->percentage = $modinfo->percentage;
                    $coursegrade->letter = $modinfo->letter;
                    break;
                }
        }

        if (!is_null($coursegrade)) {
            switch ($this->gradefmt) {
                case 1 :
                    return $coursegrade->percentage;
                    break;
                case 2 :
                    return $coursegrade->points;
                    break;
                case 3 :
                    return $coursegrade->letter;
                    break;
            }
        }

        return '';
    }

    /**
     * Prepare to print an activity grade.
     *
     * @param int $moduleid
     * @param int $userid
     * @return stdClass|bool return the mod object if it exists, false otherwise
     */
    private function get_mod_grade($moduleid, $userid) {
        global $DB;

        $cm = $DB->get_record('course_modules', array('id' => $moduleid));
        $module = $DB->get_record('modules', array('id' => $cm->module));

        if ($grade_item = grade_get_grades($this->course, 'mod', $module->name, $cm->instance, $userid)) {
            $item = new grade_item();
            $itemproperties = reset($grade_item->items);
            foreach ($itemproperties as $key => $value) {
                $item->$key = $value;
            }
            $modinfo = new stdClass;
            $modinfo->name = utf8_decode($DB->get_field($module->name, 'name', array('id' => $cm->instance)));
            $grade = $item->grades[$userid]->grade;
            $item->gradetype = GRADE_TYPE_VALUE;
            $item->courseid = $this->course;

            $modinfo->points = grade_format_gradevalue($grade, $item, true, GRADE_DISPLAY_TYPE_REAL, $decimals = 2);
            $modinfo->percentage = grade_format_gradevalue($grade, $item, true, GRADE_DISPLAY_TYPE_PERCENTAGE, $decimals = 2);
            $modinfo->letter = grade_format_gradevalue($grade, $item, true, GRADE_DISPLAY_TYPE_LETTER, $decimals = 0);

            if ($grade) {
                $modinfo->dategraded = $item->grades[$userid]->dategraded;
            } else {
                $modinfo->dategraded = time();
            }
            return $modinfo;
        }

        return false;
    }

    /**
     * Generate a version 1 UUID (time based)
     * you can verify the generated code in:
     * http://www.famkruithof.net/uuid/uuidgen?typeReq=-1
     *
     * @return string UUID_v1
     */
    private function get_issue_uuid() {
        global $CFG;
        require_once (dirname(__FILE__) . '/lib.uuid.php');
        $UUID = UUID::mint(UUID::VERSION_1, self::CERTIFICATE_COMPONENT_NAME);
        return $UUID->__toString();
    }

    /**
     * Returns a list of teachers by group
     * for sending email alerts to teachers
     *
     * @return array the teacher array
     */
    private function get_teachers() {
        global $CFG, $USER, $DB;
        $teachers = array();

        if (!empty($CFG->coursecontact)) {
            $coursecontactroles = explode(',', $CFG->coursecontact);

            foreach ($coursecontactroles as $roleid) {
                $role = $DB->get_record('role', array('id' => $roleid));
                $roleid = (int) $roleid;
                if ($users = get_role_users($roleid, $this->context, true)) {
                    foreach ($users as $teacher) {
                        if ($teacher->id == $USER->id) {
                            continue; // do not send self
                        }
                        $teachers[$teacher->id] = $teacher;
                    }
                }
            }
        } else {
            $users = get_users_by_capability($this->context, 'mod/customcertificate:manage', '', '', '', '', '', '', false, false);

            foreach ($users as $teacher) {
                if ($teacher->id == $USER->id) {
                    continue; // do not send self
                }
                $teachers[$teacher->id] = $teacher;
            }
        }

        return $teachers;
    }

    /**
     * Create the pdf
     *
     * @param $issuecert as the certificate issue of a user
     * @return void
     */
    private function create_pdf($issuecert) {
        global $DB, $USER, $CFG;

        $idCourse = $issuecert->certificateid;
        while(strlen($idCourse)<6)
        {
            $idCourse = '0'.$idCourse;
        }
        $idCode = $issuecert->id;
        $racine = "./save";
        if(!is_dir($racine)){
            mkdir($racine, 0700);
        }
        $structure = $racine."/".$idCourse;
        if(!is_dir($structure)){
            mkdir($structure, 0700);
        }

        if(is_file($structure.'/'.$issuecert->userid.'.pdf'))
        {
            return $structure.'/'.$issuecert->userid.'.pdf';
        }

        //Getting certificare image
        $fs = get_file_storage();

        // Prepare file record object
        $imagefileinfo = self::get_certificate_image_fileinfo($this->context->id);
        // Get file
        $imagefile = $fs->get_file($imagefileinfo['contextid'], $imagefileinfo['component'], $imagefileinfo['filearea'], $imagefileinfo['itemid'], $imagefileinfo['filepath'], $this->certificateimage);
        
        if(!$issueuserphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $this->id)))
        {
            print_error("userphoto pas dans la bdd");
        }
        
        // Read contents
        if ($imagefile) {
            $temp_manager = $this->move_temp_dir($imagefile);
        } else {
            print_error(get_string('filenotfound', 'customcertificate', $this->certificateimage));
        }

        $pdf = new TCPDF($this->orientation, 'mm', array($this->width, $this->height), true, 'UTF-8', true, false);
        $pdf->SetTitle($this->name);
        $pdf->SetSubject($this->name . ' - ' . $this->coursename);
        $pdf->SetKeywords(get_string('keywords', 'customcertificate') . ',' . $this->coursename);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false, 0);
        //Issue #5

        $pdf->setFontSubsetting(true);
        $pdf->AddPage();

        $pdf->Image($temp_manager->absolutefilepath, 0, 0, $this->width, $this->height);

        $racine = "./pix/userphoto/".$issueuserphoto->id;
        $fullfilepath = $racine . '/' . $issueuserphoto->userphoto;

        if(is_file($fullfilepath))
        {
            $pdf->Image($fullfilepath, $this->addphotox, $this->addphotoy, $this->addphotowidth, $this->addphotoheight);
        }

	    $pdf->SetXY($this->introcertificatetextx, $this->introcertificatetexty);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_certificate_text($issuecert, $this->introcertificatetext), 0, 0, 0, true, 'L');

        $pdf->SetXY($this->certificatetextx, $this->certificatetexty);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_certificate_text($issuecert, $this->certificatetext), 0, 0, 0, true, 'L');
         
	    $pdf->SetXY($this->conclucertificatetextx, $this->conclucertificatetexty);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_certificate_text($issuecert, $this->conclucertificatetext), 0, 0, 0, true, 'L');

        $pdf->SetXY(110, 195);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_certificate_text($issuecert, $issuecert->code), 0, 0, 0, true, 'L');

        $pdf->SetXY(100, 205);
        $pdf->SetFontSize(8);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_certificate_text($issuecert, $CFG->wwwroot.'/mod/customcertificate/verify.php'), 0, 0, 0, true, 'L');

        $pdf->Output($structure.'/'.$issuecert->userid.'.pdf', 'F');

        if(is_file($fullfilepath))
        {
            unlink($fullfilepath);
        }

        if (is_dir($racine))
        { 
            if(count(scandir($racine)) == 2) {
                rmdir($racine);
            }
        }

        if (is_dir("./pix/userphoto/"))
        { 
            if(count(scandir("./pix/userphoto/")) == 2) {
                rmdir("./pix/userphoto/");
            }
        }

        @remove_dir($temp_manager->path);

        return $structure.'/'.$issuecert->userid.'.pdf';
    }

    

    /**
     * This function returns success or failure of file save
     *
     * @param string $pdf is the string contents of the pdf
     * @param string $filename pdf filename
     * @param int $issueid the certificate issue record id
     * @return bool return true if successful, false otherwise
     */
    private function save_pdf($pdf, $filename, $issueid) {
        global $DB, $USER;

        if (empty($issueid)) {
            return false;
        }

        if (empty($pdf)) {
            return false;
        }

        $fs = get_file_storage();

        // Prepare file record object
        $fileinfo = self::get_certificate_issue_fileinfo($USER->id, $issueid, $this->context->id);
        $fileinfo['filename'] = $filename;

        // Check for file first
        if (!$fs->file_exists($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename'])) {
            $fs->create_file_from_string($fileinfo, $pdf->Output('', 'S'));
        }

        return true;
    }


    /**
     * Get the time the user has spent in the course
     *
     * @param int $courseid
     * @return int the total time spent in seconds
     */
    public function get_course_time() {
        global $CFG, $USER;

        set_time_limit(0);

        $totaltime = 0;
        $sql = "l.course = :courseid AND l.userid = :userid";
        if ($logs = get_logs($sql, array('courseid' => $this->course, 'userid' => $USER->id), 'l.time ASC', '', '', $totalcount)) {
            foreach ($logs as $log) {
                if (!isset($login)) {
                    // For the first time $login is not set so the first log is also the first login
                    $login = $log->time;
                    $lasthit = $log->time;
                    $totaltime = 0;
                }
                $delay = $log->time - $lasthit;
                if ($delay > ($CFG->sessiontimeout * 60)) {
                    // The difference between the last log and the current log is more than
                    // the timeout Register session value so that we have found a session!
                    $login = $log->time;
                } else {
                    $totaltime += $delay;
                }
                // Now the actual log became the previous log for the next cycle
                $lasthit = $log->time;
            }
            return $totaltime;
        }
        return 0;
    }

    /**
     * Get the link of the certificate issue
     *
     * @param $issuecert as the certificate issue of a user
     * @return string as the link of pdf
     */
    public function output_pdf($issuecert) {
        $linkpdf = $this->create_pdf($issuecert);
        return $linkpdf;
    }

    /**
     * Get the pdf of the certificate issue
     *
     * @param $issuecert as the certificate issue of a user
     * @return TCPDF as the pdf
     */
    public function get_pdf($issuecert)
    {
        $pdf = $this->create_pdf($issuecert);
        return $pdf;
    }

     /**
     * Get the pdf of the certificate issue
     *
     * @param $certissue as the certificate issue of a user
     * @param $string as the string search in the file language
     * @return string as text corresponding at $string param
     */
    private function get_certificate_text($certissue, $string) {
        global $USER, $DB;

        $a = new stdClass;
        $a->username = fullname($USER);
        $a->idnumber = $USER->idnumber;
        $a->firstname = $USER->firstname;
        $a->lastname = $USER->lastname;
        $a->email = $USER->email;
        $a->icq = $USER->icq;
        $a->skype = $USER->skype;
        $a->yahoo = $USER->yahoo;
        $a->aim = $USER->aim;
        $a->msn = $USER->msn;
        $a->phone1 = $USER->phone1;
        $a->phone2 = $USER->phone2;
        $a->institution = $USER->institution;
        $a->department = $USER->department;
        $a->address = $USER->address;
        $a->city = $USER->city;
        $a->country =  get_string($USER->country, 'countries');
        //Formatting URL, if needed
        $url = $USER->url;;
        if (strpos($url, '://') === false) {
            $url = 'http://'. $url;
        }
        $a->url = $url;

        //Getting user custom profiles fields
        $userprofilefields=$this->get_user_profile_fields($USER->id);
        foreach ($userprofilefields as $key => $value) {
            $key = 'profile_'.$key;
            $a->$key=$value;
        }


        $a->coursename = format_string($this->coursename, true);
        $a->grade = $this->get_grade();
        $a->date = $this->get_date($certissue,$USER->id);
        $a->outcome = $this->get_outcome();

        if (!empty($this->coursehours))
            $a->hours = format_string($this->coursehours . ' ' . get_string('hours', 'customcertificate'), true);
        else
            $a->hours = '';

        if ($teachers = $this->get_teachers()) {
            $t = array();
            foreach ($teachers as $teacher) {
                $t[] = fullname($teacher);
            }
            $a->teachers = implode("<br>", $t);
        } else {
            $a->teachers = '';
        }

        $a = (array) $a;
        $search = array();
        $replace = array();
        foreach ($a as $key => $value) {
            $search[] = '{' . strtoupper($key) . '}';
            $replace[] = (string) $value;
        }
        if ($search) {
            $string = str_replace($search, $replace, $string);
        }

        return $string;
    }

    /**
     * Returns the date to display for the certificate.
     *
     * @param stdClass $certificate
     * @param stdClass $certrecord
     * @param stdClass $course
     * @param int $userid
     * @return string the date
     */
    private function get_date($certissue, $userid = null) {
        global $DB, $USER;

        if (empty($userid)) 
        {
            $userid = $USER->id;
        }

        // Set certificate date to current time, can be overwritten later
        $date = 0;//$certissue->timecreated;

        // Get the enrolment end date
        $sql = "SELECT MAX(c.timecompleted) as timecompleted
                FROM {course_completions} c
                WHERE c.userid = :userid
                AND c.course = :courseid";
        if ($timecompleted = $DB->get_record_sql($sql, array('userid' => $userid, 'courseid' => $this->course))) 
        {
            if (!empty($timecompleted->timecompleted)) 
            {
                $date = $timecompleted->timecompleted;
            }
        }
       $format = get_string('strftimedate', 'langconfig');
            
        return userdate($date, $format);
    }

    /**
     * Get the course outcomes for for mod_form print outcome.
     *
     * @return array
     */
    private function get_outcomes() {
        global $COURSE, $DB;

        // get all outcomes in course
        $grade_seq = new grade_tree($COURSE->id, false, true, '', false);
        if ($grade_items = $grade_seq->items) {
            // list of item for menu
            $printoutcome = array();
            foreach ($grade_items as $grade_item) {
                if (isset($grade_item->outcomeid)) {
                    $itemmodule = $grade_item->itemmodule;
                    $printoutcome[$grade_item->id] = $itemmodule . ': ' . $grade_item->get_name();
                }
            }
        }
        if (isset($printoutcome)) {
            $outcomeoptions['0'] = get_string('no');
            foreach ($printoutcome as $key => $value) {
                $outcomeoptions[$key] = $value;
            }
        } else {
            $outcomeoptions['0'] = get_string('nooutcomes', 'customcertificate');
        }

        return $outcomeoptions;
    }

    /**
     * Returns the outcome to display on the certificate
     *
     * @return string the outcome
     */
    private function get_outcome() {
        global $USER, $DB;

        if ($this->outcome > 0) {
            if ($grade_item = new grade_item(array('id' => $this->outcome))) {
                $outcomeinfo = new stdClass;
                $outcomeinfo->name = $grade_item->get_name();
                $outcome = new grade_grade(array('itemid' => $grade_item->id, 'userid' => $USER->id));
                $outcomeinfo->grade = grade_format_gradevalue($outcome->finalgrade, $grade_item, true, GRADE_DISPLAY_TYPE_REAL);

                return $outcomeinfo->name . ': ' . $outcomeinfo->grade;
            }
        }

        return '';
    }

    /**
     * Move a file at a temporary directory
     *
     * @param $file as the file to move
     * @return stdClass with the path of this file
     */
    private function move_temp_dir($file) {
        global $CFG;

        $dir = $CFG->tempdir;
        $prefix = self::CERTIFICATE_COMPONENT_NAME;

        if (substr($dir, -1) != '/') {
            $dir .= '/';
        }

        do {
            $path = $dir . $prefix . mt_rand(0, 9999999);
        } while (file_exists($path));

        check_dir_exists($path);

        $fullfilepath = $path . '/' . $file->get_filename();
        $file->copy_content_to($fullfilepath);

        $obj = new stdClass();
        $obj->path = $path;
        $obj->absolutefilepath = $fullfilepath;
        $obj->relativefilepath = str_replace($CFG->dataroot . '/', "", $fullfilepath);

        if (strpos($obj->relativefilepath, '/', 1) === 0)
            $obj->relativefilepath = substr($obj->relativefilepath, 1);

        return $obj;
    }

    /**
     * Get the differents fields of a user profile
     *
     * @param $userid as the id of a user
     * @return stdClass contains the fields of user
     */
    private function get_user_profile_fields($userid) {
        global $CFG, $DB;

        $usercustomfields = new stdClass();
        if ($categories = $DB->get_records('user_info_category', null, 'sortorder ASC')) {
            foreach ($categories as $category) {
                if ($fields = $DB->get_records('user_info_field', array('categoryid'=>$category->id), 'sortorder ASC')) {
                    foreach ($fields as $field) {
                        require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
                        $newfield = 'profile_field_'.$field->datatype;
                        $formfield = new $newfield($field->id, $userid);
                        if ($formfield->is_visible() and !$formfield->is_empty()) {
                            if ($field->datatype == 'checkbox'){
                                $usercustomfields->{$field->shortname} = ( $formfield->data == 1 ? get_string('yes') : get_string('no'));
                            } else {
                                $usercustomfields->{$field->shortname} = $formfield->display_data();
                            }
                        } else {
                            $usercustomfields->{$field->shortname} = '';
                        }
                    }
                }
            }
        }
        return $usercustomfields;
    }

}


