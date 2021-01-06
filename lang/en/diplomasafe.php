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
 * Plugin strings are defined here.
 *
 * @package     mod_diplomasafe
 * @category    string
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Diplomasafe';
$string['modulename'] = $string['pluginname'];
$string['modulenameplural'] = $string['pluginname'];
$string['modulename_help'] = 'Diplomasafe is an integration between Moodle and Diplomasafe';
$string['diplomasafename_help'] = '';
$string['diplomasafename'] = 'Name';
$string['pluginadministration'] = 'Diplomasafe Administration';
$string['show_description'] = 'Show description';

// Settings
$string['settings_templates_header'] = 'Overview';
$string['settings_templates_information'] = '';
$string['settings_templates'] = 'Environment';
$string['settings_templates_desc'] = 'Determines if you are testing or in production';
$string['settings_show_templates'] = 'Show templates';
$string['settings_api_client_header'] = 'API Client settings';
$string['settings_api_client_information'] = 'Setting are provided by Diplomasafe here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://demo-admin.diplomasafe.net/en-US/auth-user</a>';
$string['settings_environment'] = 'Environment';
$string['settings_environment_desc'] = 'Determines if you are testing or in production';
$string['settings_test_base_url'] = 'Base url (test site)';
$string['settings_test_base_url_desc'] = 'The url for the API incl. the version number';
$string['settings_prod_base_url'] = 'Base url (production site)';
$string['settings_prod_base_url_desc'] = 'The url for the API incl. the version number';
$string['settings_test_personal_access_token'] = 'Personal Access Token (test site)';
$string['settings_test_personal_access_token_desc'] = 'Create token here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://demo-admin.diplomasafe.net/en-US/auth-user</a>';
$string['settings_prod_personal_access_token'] = 'Personal Access Token (production site)';
$string['settings_prod_personal_access_token_desc'] = 'Create token here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://live-admin.diplomasafe.net/en-US/auth-user</a>';

// Capabilities
$string['diplomasafe:addinstance'] = 'Add instance';
$string['diplomasafe:receive_api_error_mail'] = 'Receive API mail with error messages';

// Messages
$string['messageprovider:api_error'] = 'API error notification';
$string['message_api_error_subject'] = 'API error';
$string['message_api_error_body'] = 'The following error occurred in the API: {$a}';

// Cron
$string['cron_store_diploma_templates'] = 'Store diploma templates';
$string['cron_courses_completed_create_diplomas'] = 'Create diplomas when courses are completed';

// Templates view
$string['view_templates_list_title'] = 'Templates';
$string['view_templates_list_header'] = $string['view_templates_list_title'];
$string['view_templates_list_th_name'] = 'Navn';
$string['view_templates_list_th_organisation_id'] = 'Organization ID';
$string['view_templates_list_th_default_language_id'] = 'Default language';
$string['view_templates_list_th_idnumber'] = 'ID number';
$string['view_templates_list_th_is_valid'] = 'Valid';
$string['view_templates_list_back'] = 'Back to settings';
