<?php

/**
 * Get an archive .zip of the certificate's issues 
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__).'/lib.php');

$id   = required_param('id', PARAM_INT); // Course module ID
$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/save.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$coursenode = $PAGE->settingsnav->add(get_string('pluginadministration', 'customcertificate'));
if ($coursenode) {
    $coursenode->add(get_string('validationlink', 'customcertificate'), './validation.php?id='.$id)->make_active();
    $coursenode->add(get_string('verificationlink', 'customcertificate'), './verify.php')->make_active();
    $coursenode->add(get_string('archivelink', 'customcertificate'), './save.php?id='.$id)->make_active();
}

if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
   print_error('Course Module ID was incorrect');
}

if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
   print_error('course module is incorrect');
}

$issuecertificates = $DB->get_records('customcertificate_issues', array('certificateid' => $certificate->id, 'timedeleted' => null));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('savecertificate', 'customcertificate'));

$zip = new ZipArchive(); 

if($zip->open('backup_customcertificate_'.$certificate->id.'.zip', ZipArchive::CREATE) === true)
{
   foreach ($issuecertificates as $issuecertificate) 
   {
      $idCourse = $issuecertificate->certificateid;
      while(strlen($idCourse)<6)
      {
         $idCourse = '0'.$idCourse;
      }
      $idCode = $issuecertificate->id;
      $racine = "./save";
      $structure = $racine."/".$idCourse;

      $zip->addFile($structure.'/'.$issuecertificate->userid.'.pdf', $idCode.'.pdf');
   }

     // Et on referme l'archive
   $zip->close();
   echo get_string('archivefinished', 'customcertificate').'<a href="'.$CFG->wwwroot.'/mod/customcertificate/backup_customcertificate_'.$certificate->id.'.zip">'.get_string('link', 'customcertificate').'</a>';

}
else
{
   echo get_string('archiveerror', 'customcertificate');
}


echo $OUTPUT->footer();


