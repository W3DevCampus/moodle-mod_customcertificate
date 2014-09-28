<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');


class validation_form extends moodleform {
    /**
     * Prepares creating the form with the addition of fields such as using a checkbox
     *
     * @return void
     */
    public function definition() {
        global $CFG, $COURSE, $DB;

        $id   = required_param('id', PARAM_INT);

        $mform =& $this->_form;

        //General options
        $mform->addElement('header', 'general', get_string('general', 'form'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }


        if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
            print_error('Course Module ID was incorrect');
        }

        if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
            print_error('course module is incorrect');
        }

        $groupmode = groups_get_activity_groupmode($cm);
        $users = customcertificate_get_userphoto($certificate->id, $groupmode, $cm);
        foreach ($users as $user) {
        
            if(!$issueuserphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $user->id, 'certificateid' => $certificate->id)))
            {
                print_error("userphoto pas dans la bdd");
            }

            if($issueuserphoto->validationphoto == "pending")
            {
                $racine = "./pix/userphoto/".$issueuserphoto->id;
                $fullfilepath = $racine . '/' . $issueuserphoto->userphoto;
                $mform->addElement('html', '<img src="'.$fullfilepath.'"/>');
                $mform->addElement('checkbox', 'validationphoto'.$user->id, $user->firstname.' '.$user->lastname);
            }
            
        
        }
        
        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }



}