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
 * Define all the backup steps that will be used by the backup_certificate_activity_task
 */

/**
 * Define the complete certificate structure for backup, with file and id annotations
 */
class backup_customcertificate_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {
        global $CFG;
        require_once("$CFG->dirroot/mod/customcertificate/locallib.php");

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated

       
        $certificate = new backup_nested_element('customcertificate', array('id'), array(
                'name', 'intro', 'introformat', 'width', 'height', 'certificateimage', 'certificatetext',
                'certificatetextformat', 'certificatetextx', 'certificatetexty','introcertificatetext',
                'introcertificatetextformat', 'introcertificatetextx', 'introcertificatetexty', 'conclucertificatetext',
                'conclucertificatetextformat', 'conclucertificatetextx', 'conclucertificatetexty','certdate', 'certdatefmt',
                'certgrade', 'gradefmt', 'addphoto', 'addphotox', 'addphotoy', 'addphotowidth', 'addphotoheight',
                'requiredtime', 'coursehours', 'outcome', 'coursename', 'timemodified'));



        $issues = new backup_nested_element('issues');

        $issue = new backup_nested_element('issue', array('id'), array(
                'certificateid', 'userid','username', 'coursename', 'code', 'timecreated','timedeleted'));

        $userphotos = new backup_nested_element('userphotos');

        $userphoto = new backup_nested_element('userphoto', array('id'), array(
                'certificateid', 'userid','userphoto', 'validationphoto'));

        // Build the tree
        $certificate->add_child($issues);
        $certificate->add_child($userphotos);
        $issues->add_child($issue);
        $userphotos->add_child($userphoto);

        // Define sources
        $certificate->set_source_table('customcertificate', array('id' => backup::VAR_ACTIVITYID));

        // All the rest of elements only happen if we are including user info
        if ($userinfo) {
            $issue->set_source_table('customcertificate_issues', array('certificateid' => backup::VAR_PARENTID));
            $issue->set_source_table('customcertificate_userphoto', array('certificateid' => backup::VAR_PARENTID));
        }

        // Annotate the user id's where required.
        $issue->annotate_ids('user', 'userid');
        $userphoto->annotate_ids('user', 'userid');

        // Define file annotations
        $certificate->annotate_files('mod_customcertificate', customcertificate::CERTIFICATE_IMAGE_FILE_AREA, 'id');
        $issue->annotate_files('mod_customcertificate', customcertificate::CERTIFICATE_ISSUES_FILE_AREA, 'id'); // This file area hasn't itemid
        $userphoto->annotate_files('mod_customcertificate', customcertificate::CERTIFICATE_ISSUES_FILE_AREA, 'id'); // This file area hasn't itemid
        
        // Return the root element (certificate), wrapped into standard activity structure
        return $this->prepare_activity_structure($certificate);
    }
}