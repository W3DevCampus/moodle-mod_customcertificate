<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package moodlecore
 * @subpackage backup-moodle2
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the restore steps that will be used by the restore_customcertificate_activity_task
 */

/**
 * Structure step to restore one customcertificate activity
 */
class restore_customcertificate_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('customcertificate', '/activity/customcertificate');

        if ($userinfo) {
            $paths[] = new restore_path_element('customcertificate_issue', '/activity/customcertificate/issues/issue');
            $paths[] = new restore_path_element('customcertificate_userphoto', '/activity/customcertificate/issues/issue');
        }

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_customcertificate($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // insert the customcertificate record
        $newitemid = $DB->insert_record('customcertificate', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function process_customcertificate_issue($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->certificateid = $this->get_new_parentid('customcertificate');
        $data->timecreated = $this->apply_date_offset($data->timecreated);

        $newitemid = $DB->insert_record('customcertificate_issues', $data);
        $this->set_mapping('customcertificate_issue', $oldid, $newitemid);
    }

    protected function process_customcertificate_userphoto($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->certificateid = $this->get_new_parentid('customcertificate');
        $data->timecreated = $this->apply_date_offset($data->timecreated);

        $newitemid = $DB->insert_record('customcertificate_userphoto', $data);
        $this->set_mapping('customcertificate_userphoto', $oldid, $newitemid);
    }

    protected function after_execute() {
        global $CFG;
        require_once("$CFG->dirroot/mod/customcertificate/locallib.php");

        // Add customcertificate related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_customcertificate', customcertificate::CERTIFICATE_IMAGE_FILE_AREA, 0);
        $this->add_related_files('mod_customcertificate', customcertificate::CERTIFICATE_ISSUES_FILE_AREA, 'customcertificate_issue');
        $this->add_related_files('mod_customcertificate', customcertificate::CERTIFICATE_ISSUES_FILE_AREA, 'customcertificate_userphoto');
    }
}