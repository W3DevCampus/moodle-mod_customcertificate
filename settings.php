<?php

/**
 * Provides some custom settings for the certificate module
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->dirroot/mod/customcertificate/lib.php");

    //--- general settings -----------------------------------------------------------------------------------




    $settings->add(new admin_setting_configtext('customcertificate/width', get_string('defaultwidth', 'customcertificate'),
        get_string('size_help', 'customcertificate'), 297, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/height', get_string('defaultheight', 'customcertificate'),
        get_string('size_help', 'customcertificate'), 210, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/certificatetextx', get_string('defaultcertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 10, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/certificatetexty', get_string('defaultcertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 70, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/introcertificatetextx', get_string('defaultintrocertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 20, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/introcertificatetexty', get_string('defaultintrocertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 20, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/conclucertificatetextx', get_string('defaultconclucertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/conclucertificatetexty', get_string('defaultconclucertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 100, PARAM_INT));

    $settings->add(new admin_setting_configcheckbox('customcertificate/addphoto',
        get_string('addphoto', 'customcertificate'), get_string('addphoto_help', 'customcertificate'), 1));

    $settings->add(new admin_setting_configtext('customcertificate/addphotox', get_string('defaultaddphotox', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 220, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/addphotoy', get_string('defaultaddphotoy', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 30, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/addphotowidth', get_string('defaultaddphotowidth', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 30, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/addphotoheight', get_string('defaultaddphotoheight', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 30, PARAM_INT));

    $settings->add(new admin_setting_configselect('customcertificate/certdate', get_string('printdate', 'customcertificate'),
        get_string('printdate_help', 'customcertificate'), 2, customcertificate_get_date_options()));


    $settings->add(new admin_setting_configtext('customcertificate/certlifetime', get_string('certlifetime', 'customcertificate'),
        get_string('certlifetime_help', 'customcertificate'), 60, PARAM_INT));
    
}

?>
