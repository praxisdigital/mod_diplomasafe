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
 * Plugin administration pages are defined here.
 *
 * @package     mod_diplomasafe
 * @category    admin
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_diplomasafe\settings\admin_setting_link;

defined('MOODLE_INTERNAL') || die();

global $DB;

if ($ADMIN->fulltree) {
    // https://docs.moodle.org/dev/Admin_settings

    $component = 'mod_diplomasafe';

    $name = $component . '/settings_templates';
    $heading = get_string('settings_templates_header', $component);
    $information = get_string('settings_templates_information', $component);
    $settings->add(new admin_setting_heading($name, $heading, $information));
    $name = $component . '/templates';
    $heading = get_string('settings_templates', $component);
    $setting = new admin_setting_link($name, $heading,
        new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'templates_list'
        ])
    );
    $settings->add($setting);

    $name = $component . '/queue';
    $heading = get_string('settings_queue', $component);
    $setting = new admin_setting_link($name, $heading,
        new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'queue_list'
        ])
    );
    $settings->add($setting);

    $name = $component . '/settings';
    $heading = get_string('settings_templates', $component);
    $information = get_string('settings_api_client_information', $component);
    $settings->add(new admin_setting_heading($name, $heading, $information));

    $name = $component . '/environment';
    $title = get_string('settings_environment', $component);
    $description = get_string('settings_environment_desc', $component);
    $default = 'test';
    $options = ['test' => 'test', 'prod' => 'prod'];
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $name = $component . '/test_base_url';
    $title = get_string('settings_test_base_url', $component);
    $description = get_string('settings_test_base_url_desc', $component);
    $default = 'https://demo-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/prod_base_url';
    $title = get_string('settings_prod_base_url', $component);
    $description = get_string('settings_prod_base_url_desc', $component);
    $default = 'https://live-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/test_personal_access_token';
    $title = get_string('settings_test_personal_access_token', $component);
    $description = get_string('settings_test_personal_access_token_desc', $component);
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/prod_personal_access_token';
    $title = get_string('settings_prod_personal_access_token', $component);
    $description = get_string('settings_prod_personal_access_token_desc', $component);
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/api_timeout';
    $title = get_string('settings_api_timeout', $component);
    $description = get_string('settings_api_timeout_desc', $component);
    $default = 10;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/queue_amount_to_process';
    $title = get_string('settings_queue_amount_to_process', $component);
    $description = get_string('settings_queue_amount_to_process_desc', $component);
    $default = 20;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = $component . '/moodle_duration_field';
    $title = get_string('settings_moodle_duration_field', $component);
    $description = get_string('settings_moodle_duration_field_desc', $component);
    $custom_fields = $DB->get_records('customfield_field', null, 'shortname', 'id, shortname');
    $default = '';
    $options = [
        '' => get_string('settings_select_custom_field', 'mod_diplomasafe')
    ];
    foreach ($custom_fields as $custom_field) {
         $options[$custom_field->shortname] = $custom_field->shortname;
    }
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $name = $component . '/moodle_location_field';
    $title = get_string('settings_moodle_location_field', $component);
    $description = get_string('settings_moodle_location_field_desc', $component);
    $default = '';
    $options = [
        '' => get_string('settings_select_custom_field', 'mod_diplomasafe')
    ];
    foreach ($custom_fields as $custom_field) {
        $options[$custom_field->shortname] = $custom_field->shortname;
    }
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $name = $component . '/item_count_per_page';
    $title = get_string('settings_item_count_per_page', $component);
    $description = get_string('settings_item_count_per_page_desc', $component);
    $default = 10;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));
}
