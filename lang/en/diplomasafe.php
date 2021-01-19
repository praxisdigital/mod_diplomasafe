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
$string['settings_templates_header'] = 'Views';
$string['settings_templates_information'] = '';
$string['settings_templates'] = 'Environment';
$string['settings_templates_desc'] = 'Determines if you are testing or in production';
$string['settings_templates'] = 'Templates';
$string['settings_queue'] = 'Diploma queue';
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
$string['settings_api_timeout'] = 'API timeout';
$string['settings_api_timeout_desc'] = 'The timeout in seconds';
$string['settings_queue_amount_to_process'] = 'Queue items to process';
$string['settings_queue_amount_to_process_desc'] = 'The number of queue items to process each time the queue is triggered by the cron job.';
$string['settings_moodle_duration_field'] = 'Moodle duration field';
$string['settings_moodle_duration_field_desc'] = 'Select the field to use for duration.';
$string['settings_moodle_location_field'] = 'Moodle location field';
$string['settings_moodle_location_field_desc'] = 'Select the field to use for location';
$string['settings_select_custom_field'] = 'Select custom field';

// Default view
$string['course_completed_message'] = 'You will receive a link for your certificate via mail when the course is completed.';

// Default form
$string['select_default_option_language'] = 'Select language';
$string['select_default_option_template'] = 'Select template';
$string['label_template'] = 'Template';
$string['template_help'] = 'Select a template';
$string['label_language'] = 'Language';
$string['ajax_error_occurred'] = 'An error occurred. Could not fetch data';

// Capabilities
$string['diplomasafe:addinstance'] = 'Add instance';
$string['diplomasafe:receive_api_error_mail'] = 'Receive API mail with error messages';

// Messages
$string['messageprovider:api_error'] = 'API error notification';
$string['message_api_error_subject'] = 'API error';
$string['message_api_error_body'] = 'The following error occurred in the API: {$a}';
$string['message_language_please_select_error'] = 'Please select a language';
$string['message_template_please_select_error'] = 'Please select a template';
$string['message_template_id_unavailable_error'] = 'Template ID unavailable. Template could not be stored';
$string['message_language_id_unavailable_error'] = 'Language ID unavailable. Template could not be stored';
$string['message_invalid_response_from_endpoint'] = 'Invalid response. Endpoint: {$a->endpoint}. Response: {$a->response}';
$string['message_user_could_not_be_found'] = 'The user with ID "{$a}" could not be found. Can\'t create the diploma';
$string['message_template_not_valid'] = 'The template "{$a->template_id}" is not valid. Can\'t create the diploma for 
the user "{$a->user_id}" in the course "{$a->course_id}". This error may occur if other diploma fields than the mapped 
ones exists remotely.';
$string['message_template_invalid'] = 'The selected template "{$a}" is not valid. This error may occur if other diploma fields than the mapped 
ones exists remotely.';
$string['can_not_find_template'] = 'Can not find the template.';

// Cron
$string['cron_store_diploma_templates'] = 'Store diploma templates';
$string['cron_process_queue'] = 'Process the queue for creating diplomas';

// Statuses
$string['status_pending'] = 'Pending';
$string['status_running'] = 'Running';
$string['status_successful'] = 'Successful';
$string['status_failed'] = 'Failed';
$string['missing_or_invalid_status'] = 'Missing or invalid status';

// Templates view
$string['view_templates_list_title'] = 'Templates';
$string['view_templates_list_header'] = $string['view_templates_list_title'];
$string['view_templates_list_th_id'] = 'ID';
$string['view_templates_list_th_name'] = 'Navn';
$string['view_templates_list_th_organisation_id'] = 'Organization ID';
$string['view_templates_list_th_default_language_id'] = 'Default language';
$string['view_templates_list_th_idnumber'] = 'ID number';
$string['view_templates_list_th_is_valid'] = 'Valid';
$string['view_templates_list_back'] = 'Back to settings';

// Queue view
$string['view_queue_list_header'] = 'Diploma queue';
$string['view_queue_list_th_id'] = 'ID';
$string['view_queue_list_th_course'] = 'Course';
$string['view_queue_list_th_user'] = 'User';
$string['view_queue_list_th_status'] = 'Status';
$string['view_queue_list_th_message'] = 'Message';
$string['view_queue_list_th_time_created'] = 'Time created';
$string['view_queue_list_th_last_run'] = 'Last run';
$string['view_queue_list_th_last_mail_sent'] = 'Last mail sent';
$string['view_queue_readd'] = 'Readd';
$string['view_queue_list_back'] = 'Back to settings';

