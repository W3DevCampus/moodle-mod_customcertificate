<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');


class addphoto_form extends moodleform {
    /**
     * Prepares creating the form with the addition of fields such as using a FilePicker
     *
     * @return void
     */
    public function definition() {
        global $CFG, $COURSE;


        $mform =& $this->_form;

        //General options
        $mform->addElement('header', 'general', get_string('general', 'form'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }

        //User photo image file
        $mform->addElement('filepicker', 'userphoto', get_string('userphoto','customcertificate'), null,
            array('maxbytes' => 102400, 'accepted_types' =>  array('image')));
        $mform->addHelpButton('userphoto', 'userphoto', 'customcertificate');
        $mform->addRule('userphoto', get_string('error'), 'required', null, 'client');
        $mform->addRule('userphoto', get_string('error'), 'alphanumeric', null, 'client');
        $this->add_action_buttons();
    }

    /**
     * Prepares the form before data are set
     *
     * Additional wysiwyg editor are prepared here, the introeditor is prepared automatically by core.
     * Grade items are set here because the core modedit supports single grade item only.
     *
     * @param array $data to be set
     * @return void
     */
    public function data_preprocessing(&$data) {
        global $CFG;
        require_once(dirname(__FILE__) . '/locallib.php');
        if ($this->current->instance) {
            // editing an existing certificate - let us prepare the added editor elements (intro done automatically), and files
            $imagedraftitemid = file_get_submitted_draft_itemid('userphoto');
            $imagefileinfo = customcertificate::get_certificate_image_fileinfo($this->context);
            file_prepare_draft_area($imagedraftitemid, $imagefileinfo['contextid'], $imagefileinfo['component'], $imagefileinfo['filearea'], $imagefileinfo['itemid']);
            $data['userphoto'] = $imagedraftitemid;
        }
    }

    //Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }



}