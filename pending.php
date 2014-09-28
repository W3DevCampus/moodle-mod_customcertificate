<?php

/**
 * Pending the validation of a user's photo for a certificate
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/pending.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pendingcertificate', 'customcertificate'));
echo html_writer::tag('p', get_string('pending', 'customcertificate'), array('style' => 'text-align:center'));


if(!$issueuserphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $id)))
{
	print_error('course module is incorrect');
}
else
{	
	$DB->set_field('customcertificate_userphoto', 'validationphoto', "pending", array('userid' => $USER->id, 'certificateid' => $id));
}

echo $OUTPUT->footer();
