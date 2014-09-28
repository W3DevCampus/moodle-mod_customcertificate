<?php

/**
 * Validation of user's photos
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__).'/lib.php');
require_once('validation_form.php');

$id   = required_param('id', PARAM_INT); // Course module ID
$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/validation.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$coursenode = $PAGE->settingsnav->add(get_string('pluginadministration', 'customcertificate'));
if ($coursenode) {
    $coursenode->add(get_string('validationlink', 'customcertificate'), './validation.php?id='.$id)->make_active();
    $coursenode->add(get_string('verificationlink', 'customcertificate'), './verify.php')->make_active();
    $coursenode->add(get_string('archivelink', 'customcertificate'), './save.php?id='.$id)->make_active();
}

$mform = new validation_form($CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$id);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('validationcertificate', 'customcertificate'));

if (!$data = $mform->get_data()) {
   if (has_capability('mod/customcertificate:manage', $context)) {
      $mform->display();
      add_to_log($context->instanceid, 'customcertificate', 'verify', 'validation.php?id='.$id);
      $mform->set_data(array('id'=>$id));
   }else {
      print_error(get_string('permissiondenied', 'customcertificate'));
   }
}
else
{
   if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
      print_error('Course Module ID was incorrect');
   }

   if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
      print_error('course module is incorrect');
   }

   $groupmode = groups_get_activity_groupmode($cm);
   $users = customcertificate_get_userphoto($certificate->id, $groupmode, $cm);
   echo get_string('photovalidated', 'customcertificate');
   foreach ($users as $user) {
      $check = 'validationphoto'.$user->id;
      if(isset($data->{$check}))
      {
        echo html_writer::tag('p', $user->firstname.' '.$user->lastname, array('style' => 'text-align:center'));
        $DB->set_field('customcertificate_userphoto', 'validationphoto', "validated", array('userid' => $user->id, 'certificateid' => $certificate->id));
        email_to_user($user, format_string($user->email, true), get_string('emailvalidatedphotosubject', 'customcertificate'), get_string('emailvalidatedphotolink', 'customcertificate').$CFG->wwwroot.'/mod/customcertificate/view.php?id='.$id, '<font face="sans-serif"><p> '.get_string('emailvalidatedphotolink', 'customcertificate').'<a href="'.$CFG->wwwroot.'/mod/customcertificate/view.php?id='.$id.'">'.get_string('link', 'customcertificate').'</a></p></font>');
      }
   }
   echo html_writer::tag('p', get_string('refresh', 'customcertificate'), array('style' => 'text-align:center'));
}

echo $OUTPUT->footer();
