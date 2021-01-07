<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The main mod_diplomasafe configuration form.
 *
 * @package     mod_diplomasafe
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\output\fieldset_template_field;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package    mod_diplomasafe
 * @copyright  2020 Diplomasafe <info@diplomasafe.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_diplomasafe_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        global $CFG, $PAGE;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Language field
        $languages = language_factory::get_repository()
            ->get_all();
        $languages->sort_asc('name');
        $options = [];
        $options[''] = get_string('select_default_option_language', 'mod_diplomasafe');
        foreach ($languages as $language) {
            $options[$language->id] = $language->name;
        }
        $mform->addElement('select', 'language_id', get_string('language', 'mod_diplomasafe'),  $options);
        $mform->addRule('language_id', get_string('message_language_please_select_error', 'mod_diplomasafe'), 'required', null, 'client');

        // Template field
        $renderer = $PAGE->get_renderer('mod_diplomasafe');
        $page = new fieldset_template_field((int)$this->_customdata["language_id"]);
        $html = $renderer->render($page);
        $mform->addElement('html', $html);

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('diplomasafename', 'mod_diplomasafe'), array('size' => '64'));
        $mform->setDefault('name', 'Diplomasafe');

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'diplomasafename', 'mod_diplomasafe');

        // Adding the standard "intro" and "introformat" fields.
        $this->standard_intro_elements();

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }
}
