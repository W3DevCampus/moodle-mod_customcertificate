<?php

/**
 * Custom Certificate module core interaction API
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/grade/lib.php');
require_once($CFG->dirroot.'/grade/querylib.php');


define('CUSTOMCERT_PER_PAGE', 30);
define('CUSTOMCERT_MAX_PER_PAGE', 200);



/**
 * Add certificate instance.
 *
 * @param stdClass $certificate
 * @return int new certificate instance id
*/
function customcertificate_add_instance(stdclass $certificate, $mform=null) {
    global $CFG, $DB;


    $certificate->timecreated          = time();
    $certificate->timemodified         = $certificate->timecreated;

    // process the wysiwyg editors
    $certificate->certificatetext = $certificate->certificatetext['text'];
    $certificate->certificatetextformat = FORMAT_HTML;
    $certificate->introcertificatetext = $certificate->introcertificatetext['text'];
    $certificate->introcertificatetextformat = FORMAT_HTML;
    $certificate->conclucertificatetext = $certificate->conclucertificatetext['text'];
    $certificate->conclucertificatetextformat = FORMAT_HTML;

    // insert the new record so we get the id
    $certificate->id = $DB->insert_record('customcertificate', $certificate);

    // we need to use context now, so we need to make sure all needed info is already in db
    $cmid = $certificate->coursemodule;
    $DB->set_field('course_modules', 'instance', $certificate->id, array('id' => $cmid));
    $context = get_context_instance(CONTEXT_MODULE, $cmid);

    //process file
    if ($mform) {
        $images = customcertificate_process_form_files($mform, $context);
    }
    $certificate->certificateimage = $images[0];
    
    // re-save the record with the replaced URLs in editor fields
    $DB->update_record('customcertificate', $certificate);

    //Send event
    customcertificate_send_event($certificate);

    return $certificate->id;
}

/**
 * Update certificate instance.
 *
 * @param stdClass $certificate
 * @return bool true
 */
function customcertificate_update_instance($certificate, $mform=null) {
    global $DB, $CFG;
    require_once(dirname(__FILE__) . '/locallib.php');

    // Update the certificate
    $certificate->timemodified = time();
    $certificate->id = $certificate->instance;
    $DB->update_record('customcertificate', $certificate);

    $context = get_context_instance(CONTEXT_MODULE, $certificate->coursemodule);

    //process files
    if ($mform) {
        $images = customcertificate_process_form_files($mform, $context);
    }
    $certificate->certificateimage = $images[0];

    // process the custom wysiwyg editors
    $certificate->certificatetext = $certificate->certificatetext['text'];
    $certificate->certificatetextformat = FORMAT_HTML;
    $certificate->introcertificatetext = $certificate->introcertificatetext['text'];
    $certificate->introcertificatetextformat = FORMAT_HTML;
    $certificate->conclucertificatetext = $certificate->conclucertificatetext['text'];
    $certificate->conclucertificatetextformat = FORMAT_HTML;
    $certificate->certificateimage = $images[0];

    // re-save the record with the replaced URLs in editor fields

    $DB->update_record('customcertificate', $certificate);

    //Send event
    customcertificate_send_event($certificate);

    return true;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id
 * @return bool true if successful
 */
function customcertificate_delete_instance($id) {
    global $DB;

    // Ensure the certificate exists
    if (!$certificate = $DB->get_record('customcertificate', array('id' => $id))) {
        return false;
    }

    // Prepare file record object
    if (!$cm = get_coursemodule_from_instance('customcertificate', $id)) {
        return false;
    }

    $result = true;
    $timedeleted = time();

    $issuecertificates = $DB->get_records('customcertificate_issues', array('certificateid' => $certificate->id, 'timedeleted' => null));
    foreach ($issuecertificates as $issuecertificate) {
        $issuecertificate->timedeleted = $timedeleted;
        if (!$DB->update_record('customcertificate_issues', $issuecertificate)) {
            print_erro(get_string('cantdeleteissue','customcertificate'));
        }
    }

    if (!$DB->delete_records('customcertificate', array('id' => $id))) {
        $result = false;
    }

    // Delete any files associated with the certificate
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    $fs = get_file_storage();
    $fs->delete_area_files($context->id);

    return $result;
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * This function will remove all posts from the specified certificate
 * and clean up any related data.
 *
 * Written by Jean-Michel Vedrine
 *
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function customcertificate_reset_userdata($data) {
    global $CFG, $DB;

    $componentstr = get_string('modulenameplural', 'customcertificate');
    $status = array();

    if (!empty($data->reset_certificate)) {
        $timedeleted = time();
        $certificates = $DB->get_records('customcertificate', array('course' => $data->courseid));

        foreach ($certificates as $certificate) {
            $issuecertificates = $DB->get_records('customcertificate_issues', array('certificateid' => $certificate->id, 'timedeleted' => null));

            foreach ($issuecertificates as $issuecertificate) {
                $issuecertificate->timedeleted = $timedeleted;
                if (!$DB->update_record('customcertificate_issues', $issuecertificate)) {
                    print_erro(get_string('cantdeleteissue','customcertificate'));
                }
            }
        }
        $status[] = array('component' => $componentstr, 'item' => get_string('modulenameplural', 'customcertificate'), 'error' => false);
    }

    // Updating dates - shift may be negative too
    if ($data->timeshift) {
        shift_course_mod_dates('customcertificate', array('timeopen', 'timeclose'), $data->timeshift, $data->courseid);
        $status[] = array('component' => $componentstr, 'item' => get_string('datechanged'), 'error' => false);
    }

    return $status;
}

/**
 * Implementation of the function for printing the form elements that control
 * whether the course reset functionality affects the certificate.
 *
 * Written by Jean-Michel Vedrine
 *
 * @param $mform form passed by reference
 */
function customcertificate_reset_course_form_definition(&$mform) {
    $mform->addElement('header', 'customcertificateheader', get_string('modulenameplural', 'customcertificate'));
    $mform->addElement('advcheckbox', 'reset_customcertificate', get_string('deletissuedcertificates', 'customcertificate'));
}

/**
 * Course reset form defaults.
 *
 * Written by Jean-Michel Vedrine
 *
 * @param stdClass $course
 * @return array
 */
function customcertificate_reset_course_form_defaults($course) {
    return array('reset_customcertificate' => 1);
}

/**
 * Returns information about received certificate.
 * Used for user activity reports.
 *
 * @param stdClass $course
 * @param stdClass $user
 * @param stdClass $mod
 * @param stdClass $certificate
 * @return stdClass the user outline object
 */
function customcertificate_user_outline($course, $user, $mod, $certificate) {
    global $DB;

    $result = new stdClass;
    if ($issue = $DB->get_record('customcertificate_issues', array('certificateid' => $certificate->id, 'userid' => $user->id, 'timedeleted' => null ))) {
        $result->info = get_string('issued', 'customcertificate');
        $result->time = $issue->timecreated;
    } else {
        $result->info = get_string('notissued', 'customcertificate');
    }

    return $result;
}

/**
 * Returns information about received certificate.
 * Used for user activity reports.
 *
 * @param stdClass $course
 * @param stdClass $user
 * @param stdClass $mod
 * @param stdClass $page
 * @return string the user complete information
 */
function customcertificate_user_complete($course, $user, $mod, $certificate) {
    global $DB, $OUTPUT;

    if ($issue = $DB->get_record('customcertificate_issues', array('certificateid' => $certificate->id, 'userid' => $user->id, 'timedeleted' => null))) {
        echo $OUTPUT->box_start();
        echo get_string('issued', 'customcertificate') . ": ";
        echo userdate($issue->timecreated);
        customcertificate_print_user_files($certificate->id, $user->id);
        echo '<br />';
        echo $OUTPUT->box_end();
    } else {
        print_string('notissuedyet', 'customcertificate');
    }
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of certificate.
 *
 * @param int $certificateid
 * @return stdClass list of participants
 */
function customcertificate_get_participants($certificateid) {
    global $DB;

    $sql = "SELECT DISTINCT u.id, u.id
            FROM {user} u, {customcertificate_issues} a
            WHERE a.certificateid = :certificateid
            AND u.id = a.userid
            AND timedeleted IS NULL";
    return  $DB->get_records_sql($sql, array('certificateid' => $certificateid));
}

/**
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function customcertificate_supports($feature) {
    switch ($feature) {
        case FEATURE_GROUPS:                  return true;
        case FEATURE_GROUPINGS:               return true;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_BACKUP_MOODLE2:          return true;

        default: return null;
    }
}

/**
 * Function to be run periodically according to the moodle cron
 */
function customcertificate_cron () {
    global $CFG, $DB;
    mtrace('Removing old issed certificates... ');
    $lifetime = get_config('customcertificate', 'certlifetime');

    if ($lifetime <= 0 ) {
        return true;
    }

    $month = 2629744;
    $timenow   = time();
    $delta = $lifetime * $month;
    $timedeleted = $timenow - $delta;


    if (!$DB->delete_records_select('customcertificate_issues', 'timedeleted <= ?', array($timedeleted))) {
        return false;
    }
    mtrace('done');
    return true;
}

/**
 * Serves certificate issues and other files.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @return bool|nothing false if file not found, does not return anything if found - just send the file
 */
function customcertificate_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload) {
    global $CFG, $DB, $USER;


    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    if (!$certificate = $DB->get_record('customcertificate', array('id' => $cm->instance))) {
        return false;
    }

    require_login($course, false, $cm);

    require_once(dirname(__FILE__) . '/locallib.php');
    require_once($CFG->libdir.'/filelib.php');

    switch ($filearea) {
        case customcertificate::CERTIFICATE_IMAGE_FILE_AREA:
            $fileinfo = customcertificate::get_certificate_image_fileinfo($context);
            break;
        case customcertificate::CERTIFICATE_ISSUES_FILE_AREA:
            $certrecord = (int)array_shift($args);
            if (!$certrecord = $DB->get_record('customcertificate_issues', array('id' => $certrecord, 'timedeleted' => null))) {
                return false;
            }

            if ($USER->id != $certrecord->userid and !has_capability('mod/customcertificate:manage', $context)) {
                return false;
            }

            $fileinfo = customcertificate::get_certificate_issue_fileinfo($USER->id, $certrecord->id, $context);
            break;
        default:
            return false;
            break;
    }

    $relativepath = implode('/', $args);
    $fullpath = "/". $fileinfo['contextid']. "/" . $fileinfo['component'] . "/" . $fileinfo['filearea'] . "/" . $fileinfo['itemid'] . "/" . $relativepath;
    $fs = get_file_storage();
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }
    send_stored_file($file, 0, 0);
}

/**
 * Produces a list of links to the issued certificates.  Used for report.
 *
 * @param stdClass $certificate
 * @param int $userid
 * @param stdClass $context
 * @return string return the user files
 */
function customcertificate_print_user_files($certificate, $userid, $context) {
    global $CFG, $DB, $OUTPUT;
    require_once(dirname(__FILE__) . '/locallib.php');

    $output = '';
    $certrecord = $DB->get_record('customcertificate_issues', array('userid' => $userid, 'certificateid' => $certificate->id, 'timedeleted' => null ));
    $fs = get_file_storage();
    $browser = get_file_browser();

    $fileinfo=customcertificate::get_certificate_issue_fileinfo($userid, $certrecord->id, $context);

    $files = $fs->get_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid']);
    foreach ($files as $file) {
        $filename = $file->get_filename();
        $mimetype = $file->get_mimetype();
        $link = file_encode_url($CFG->wwwroot.'/pluginfile.php', '/'.
        $fileinfo['contextid'].'/'.$fileinfo['component'].'/'.
        $fileinfo['filearea'].'/'. $fileinfo['itemid'].'/'.$filename);

        $output = '<img src="'.$OUTPUT->pix_url(file_mimetype_icon($file->get_mimetype())).'" height="16" width="16" alt="'.$file->get_mimetype().'" />&nbsp;'.
                '<a href="'.$link.'" >'.s($filename).'</a>';

    }
    $output .= '<br />';
    $output = '<div class="files">'.$output.'</div>';

    return $output;
}

/**
 * Get the course outcomes for for mod_form print outcome.
 *
 * @return array
 */
function customcertificate_get_outcomes() {
    global $COURSE, $DB;

    // get all outcomes in course
    $grade_seq = new grade_tree($COURSE->id, false, true, '', false);
    if ($grade_items = $grade_seq->items) {
        // list of item for menu
        $printoutcome = array();
        foreach ($grade_items as $grade_item) {
            if (isset($grade_item->outcomeid)){
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
 * Used for course participation report (in case certificate is added).
 *
 * @return array
 */
function customcertificate_get_view_actions() {
    return array('view', 'view all', 'view report', 'verify');
}

/**
 * Used for course participation report (in case certificate is added).
 *
 * @return array
 */
function customcertificate_get_post_actions() {
    return array('received');
}


/**
 * Process uploaded file
 */
function customcertificate_process_form_files ($mform, stdclass $context) {
    require_once(dirname(__FILE__) . '/locallib.php');
    $certimages=array();
    $certimages[0] = $mform->get_new_filename('certificateimage');

    $fs = get_file_storage();
    if ($certimages[0] !== false) {
        $fileinfo=customcertificate::get_certificate_image_fileinfo($context->id);
        $fs->delete_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],$fileinfo['itemid']);
        $mform->save_stored_file('certificateimage', $fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $certimages[0]);
    }
    return $certimages;
}

/**
 * Update the event if it exists, else create
 */
function customcertificate_send_event($certificate){
    global $DB;
    if ($event= $DB->get_record('event', array('modulename'=>'customcertificate', 'instance'=>$certificate->id))) {
        $event->name = $certificate->name;
        update_event($event);
    } else {
        $event = new stdClass;
        $event->name = $certificate->name;
        $event->description = '';
        $event->courseid = $certificate->course;
        $event->groupid = 0;
        $event->userid = 0;
        $event->modulename  = 'customcertificate';
        $event->instance = $certificate->id;
        add_event($event);
    }
}

/**
 * Returns certificate text options
 *
 * @param module context
 * @return array
 */
function customcertificate_get_editor_options(stdclass $context) {
    return array(
                'subdirs'=>0,
                'maxbytes'=>0,
                'maxfiles'=>0,
                'changeformat'=>0,
                'context'=>$context,
                'noclean'=>0,
                'trusttext'=>0);
}


/**
 * Get all the modules
 *
 * @return array
 */
function customcertificate_get_mods (){
    global $COURSE, $CFG, $DB;

    $grademodules = array();
    $items = grade_item::fetch_all(array('courseid'=>$COURSE->id));
    $items = $items ? $items : array();

    foreach($items as $id=>$item) {
        // Do not include grades for course itens
        if ($item->itemtype != 'mod') {
            continue;
        }
        $cm = get_coursemodule_from_instance($item->itemmodule, $item->iteminstance);
        $grademodules[$cm->id] = $item->get_name();
    }
    asort($grademodules);
    return $grademodules;
}

/**
 * Search through all the modules for grade dates for mod_form.
 *
 * @return array
 */
function customcertificate_get_date_options() {
    $dateoptions['1'] = get_string('issueddate', 'customcertificate');
    $dateoptions['2'] = get_string('completiondate', 'customcertificate');
    return $dateoptions + customcertificate_get_mods();
}

/**
 * Search through all the modules for grade data for mod_form.
 *
 * @return array
 */
function customcertificate_get_grade_options() {
    $gradeoptions['0'] = get_string('nograde');
    $gradeoptions['1'] = get_string('coursegrade', 'customcertificate');

    return $gradeoptions + customcertificate_get_mods();
}

/**
 * Returns a list of issued certificates - sorted for report.
 *
 * @param int $certificateid
 * @param string $sort the sort order
 * @param bool $groupmode are we in group mode ?
 * @param stdClass $cm the course module
 * @param int $page offset
 * @param int $perpage total per page
 * @return stdClass the users
 */
function customcertificate_get_issues($certificateid, $sort="ci.timecreated ASC", $groupmode, $cm, $page = 0, $perpage = 0) {
    global $CFG, $DB;

    // get all users that can manage this certificate to exclude them from the report.
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    $certmanagers = get_users_by_capability($context, 'mod/customcertificate:manage', 'u.id');
    $limitsql = '';
    $page = (int) $page;
    $perpage = (int) $perpage;

    // Setup pagination - when both $page and $perpage = 0, get all results
    if ($page || $perpage) {
        if ($page < 0) {
            $page = 0;
        }

        if ($perpage > CUSTOMCERT_MAX_PER_PAGE) {
            $perpage = CUSTOMCERT_MAX_PER_PAGE;
        } else if ($perpage < 1) {
            $perpage = CUSTOMCERT_PER_PAGE;
        }
        $limitsql = " LIMIT $perpage" . " OFFSET " . $page * $perpage ;
    }

    // Get all the users that have certificates issued, should only be one issue per user for a certificate
    $users = $DB->get_records_sql("SELECT u.*, ci.code, ci.timecreated
                FROM {user} u
                INNER JOIN {customcertificate_issues} ci
                ON u.id = ci.userid
                WHERE u.deleted = 0
                AND ci.certificateid = :certificateid
                AND timedeleted IS NULL
                ORDER BY {$sort} {$limitsql}", array('certificateid' => $certificateid));

    // now exclude all the certmanagers.
    foreach ($users as $id => $user) {
        if (isset($certmanagers[$id])) { //exclude certmanagers.
            unset($users[$id]);
        }
    }

    // if groupmembersonly used, remove users who are not in any group
    if (!empty($users) and !empty($CFG->enablegroupings) and $cm->groupmembersonly) {
        if ($groupingusers = groups_get_grouping_members($cm->groupingid, 'u.id', 'u.id')) {
            $users = array_intersect($users, array_keys($groupingusers));
        }
    }

    if ($groupmode) {
        $currentgroup = groups_get_activity_group($cm);
        if ($currentgroup) {
            $groupusers = groups_get_members($currentgroup, 'u.*');
            if (empty($groupusers)) {
                return array();
            }
            foreach($users as $id => $unused) {
                if (!isset($groupusers[$id])) {
                    // remove this user as it isn't in the group!
                    unset($users[$id]);
                }
            }
        }
    }

    return $users;
}

/**
 * Returns a list of user's photo of a certificate
 *
 * @param int $certificateid
 * @param bool $groupmode are we in group mode ?
 * @param stdClass $cm the course module
 * @return stdClass the users
 */
function customcertificate_get_userphoto($certificateid, $groupmode, $cm) {
    global $CFG, $DB;

    // get all users that can manage this certificate to exclude them from the report.
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    $certmanagers = get_users_by_capability($context, 'mod/customcertificate:manage', 'u.id');

    // Setup pagination - when both $page and $perpage = 0, get all results
    // Get all the users that have certificates issued, should only be one issue per user for a certificate
    $users = $DB->get_records_sql("SELECT u.*
                FROM {user} u
                INNER JOIN {customcertificate_userphoto} ci
                ON u.id = ci.userid
                WHERE ci.certificateid = :certificateid", array('certificateid' => $certificateid));

    // now exclude all the certmanagers.
    foreach ($users as $id => $user) {
        if (isset($certmanagers[$id])) { //exclude certmanagers.
            unset($users[$id]);
        }
    }

    // if groupmembersonly used, remove users who are not in any group
    if (!empty($users) and !empty($CFG->enablegroupings) and $cm->groupmembersonly) {
        if ($groupingusers = groups_get_grouping_members($cm->groupingid, 'u.id', 'u.id')) {
            $users = array_intersect($users, array_keys($groupingusers));
        }
    }

    if ($groupmode) {
        $currentgroup = groups_get_activity_group($cm);
        if ($currentgroup) {
            $groupusers = groups_get_members($currentgroup, 'u.*');
            if (empty($groupusers)) {
                return array();
            }
            foreach($users as $id => $unused) {
                if (!isset($groupusers[$id])) {
                    // remove this user as it isn't in the group!
                    unset($users[$id]);
                }
            }
        }
    }

    return $users;
}