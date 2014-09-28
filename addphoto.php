<?php

/**
 * Adding a user's photo by a form with a filepicker
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once('addphoto_form.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);
$retry = optional_param('retry', 0, PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
// Add the form
$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/addphoto.php?id='.$id);


if (!$data = $mform->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('certificateaddphoto', 'customcertificate'));
    //try if the filename have a special char
    if($retry == 1)
    {
        echo html_writer::tag('p', get_string('unknowchar', 'customcertificate'), array('style' => 'text-align:center'));
        $retry = 0;
    }
    $mform->display();
    add_to_log($context->instanceid, 'customcertificate', 'addphoto', 'addphoto.php?id='.$id);
    $mform->set_data(array('id'=>$id));
    echo $OUTPUT->footer();
} else {
    //Adding the user photo
    $fs = get_file_storage();
    $fileinfo=customcertificate::get_certificate_image_fileinfo($context->id);
    $fs->delete_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],$fileinfo['itemid']);
    
    $mform->save_stored_file('userphoto', $fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));

    if (!$certificate = $DB->get_record('customcertificate', array('id'=> $id))) {
        print_error('certificate module is incorrect');
    }

    if(!$cm = get_coursemodule_from_instance('customcertificate', $certificate->id))
    {
        print_error('Course Module ID was incorrect');
    }
    
    if (!$userphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $id))) {
        print_error(get_string('invalidcode','customcertificate'));
    }
    else
    {
        $imagefileuser = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));
        //Creation of the dir for save the users photo
        $racine = "./pix/userphoto/";
        if(!is_dir($racine)){
            mkdir($racine, 0700);
        }

        if(!is_dir($racine.'/'.$userphoto->id)){
            mkdir($racine.'/'.$userphoto->id, 0700);
        }
                        
        $dir = $CFG->tempdir;
        $prefix = "mod_customcertificate";

        $filename =  $mform->get_new_filename('userphoto');

        $pattern = "#^[a-zA-Z0-9_.]+$#i";
        if (!(preg_match($pattern , $filename)))
        {
            //refresh if the filename contains special char
            header("Refresh: 0; url=addphoto.php?id=".$id."&retry=1");
        }
        else
        {
            //store the photo
            $fullfilepath = $racine.'/'.$userphoto->id . '/' . $filename;
            $imagefileuser->copy_content_to($fullfilepath);

            $DB->set_field('customcertificate_userphoto', 'userphoto', $filename, array('userid' => $USER->id, 'certificateid' => $id));

            $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
            $context = get_context_instance(CONTEXT_COURSE, $certificate->course);
            $teachers = get_role_users($role->id, $context);
            foreach ($teachers as $teacher) {
                email_to_user($teacher, format_string($teacher->email, true), get_string('emailvalidationphotosubject','customcertificate'), get_string('emailvalidationphotolink','customcertificate').$CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$cm->id, '<font face="sans-serif"><p>'.get_string('emailvalidationphotolinkhtml','customcertificate').'<a href="'.$CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$cm->id.'">'.get_string('link','customcertificate').'</a></p></font>');
            }
            
            redirect($CFG->wwwroot.'/mod/customcertificate/pending.php?id=' . $id); 
        }
    }
}
