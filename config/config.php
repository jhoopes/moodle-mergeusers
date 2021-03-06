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
 * @package tool
 * @subpackage mergeusers
 * @author Jordi Pujol-Ahulló <jordi.pujol@urv.cat>
 * @copyright 2013 Servei de Recursos Educatius (http://www.sre.urv.cat)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined("MOODLE_INTERNAL") || die();

/**
 * This is the default settings for the correct behaviour of the plugin, given the knowledge base
 * of our experience.
 *
 * Your local Moodle instance may need additional adjusts. Please, do not modify this file.
 * Instead, create or edit in the same directory than this "config.php" a file named
 * "config.local.php" to add/replace elements of the default configuration.
 */
return array(

    // gathering tool
    'gathering' => 'CLIGathering',

    // Database tables to be excluded from normal processing.
    // You normally will add tables. Be very cautious if you delete any of them.
    'exceptions' => array(
        'user_preferences',
        'user_private_key',
        'user_info_data',
        'my_pages',
        'quiz_grades',         // this is handled by custom processing of quiz attempts
        'quiz_grades_history', // this is handled by custom processing of quiz attempts
    ),

    // List of compound indexes.
    // This list may vary from Moodle instance to another, given that the Moodle version,
    // local changes and non-core plugins may add new special cases to be processed.
    // When 'both' field is set, this means that user.id values may appear in the list of 'otherfields' too.
    // See README.txt for details on special cases.
    // Table names must be without $CFG->prefix.
    'compoundindexes' => array(
        'grade_grades' => array(
            'userfield' => 'userid',
            'otherfields' => array('itemid'),
        ),
        'groups_members' => array(
            'userfield' => 'userid',
            'otherfields' => array('groupid'),
        ),
        'journal_entries' => array(
            'userfield' => 'userid',
            'otherfields' => array('journal'),
        ),
        'course_completions' => array(
            'userfield' => 'userid',
            'otherfields' => array('course'),
        ),
        'message_contacts' => array(//both fields are user.id values
            'userfield' => 'userid',
            'otherfields' => array('contactid'),
            'both' => true,
        ),
        'role_assignments' => array(
            'userfield' => 'userid',
            'otherfields' => array('contextid', 'roleid'),
        ),
        'user_lastaccess' => array(
            'userfield' => 'userid',
            'otherfields' => array('courseid'),
        ),
        'quiz_attempts' => array(
            'userfield' => 'userid',
            'otherfields' => array('quiz'),
            'customprocessing' => true,
        ),
    ),

    // List of column names per table, where their content is a user.id.
    // These are necessary for matching passed by userids in these column names.
    // In other words, only column names given below will be search for matching user ids.
    // The key 'default' will be applied for any non matching table name.
    'userfieldnames' => array(
        'message_contacts' => array('userid', 'contactid'), //compound index
        'message' => array('useridfrom', 'useridto'),
        'message_read' => array('useridfrom', 'useridto'),
        'question' => array('createdby', 'modifiedby'),
        'default' => array('userid', 'user_id', 'id_user', 'user'), //may appear compound index
    ),
);
