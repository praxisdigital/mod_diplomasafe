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

defined('MOODLE_INTERNAL') || die();
if ($ADMIN->fulltree) {
    // https://docs.moodle.org/dev/Admin_settings

    $name = 'mod_diplomasafe/settings';
    $heading = get_string('settings_api_client_header', 'mod_diplomasafe');
    $information = get_string('settings_api_client_information', 'mod_diplomasafe');
    $settings->add(new admin_setting_heading($name, $heading, $information));

    $name = 'mod_diplomasafe/environment';
    $title = get_string('environment', 'mod_diplomasafe');
    $description = get_string('environment_desc', 'mod_diplomasafe');
    $default = 0;
    $options = ['test', 'prod'];
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $name = 'mod_diplomasafe/test_base_url';
    $title = get_string('test_base_url', 'mod_diplomasafe');
    $description = get_string('test_base_url_desc', 'mod_diplomasafe');
    $default = 'https://demo-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = 'mod_diplomasafe/prod_base_url';
    $title = get_string('prod_base_url', 'mod_diplomasafe');
    $description = get_string('prod_base_url_desc', 'mod_diplomasafe');
    $default = 'https://live-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = 'mod_diplomasafe/test_personal_access_token';
    $title = get_string('test_personal_access_token', 'mod_diplomasafe');
    $description = get_string('test_personal_access_token_desc', 'mod_diplomasafe');
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $name = 'mod_diplomasafe/prod_personal_access_token';
    $title = get_string('prod_personal_access_token', 'mod_diplomasafe');
    $description = get_string('prod_personal_access_token_desc', 'mod_diplomasafe');
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));
}