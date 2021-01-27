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

// Basic
$string['pluginname'] = 'Diplomasafe';
$string['modulename'] = $string['pluginname'];
$string['modulenameplural'] = $string['pluginname'];
$string['modulename_help'] = 'Diplomasafe is an integration between Moodle and Diplomasafe.';
$string['diplomasafename_help'] = '';
$string['diplomasafename'] = 'Name';
$string['pluginadministration'] = 'Diplomasafe Administration';

// Settings
$string['settings_views_header'] = 'Views';
$string['settings_views_information'] = '';
$string['settings_settings'] = 'Settings';
$string['settings_templates'] = 'Environment';
$string['settings_templates_desc'] = 'Determines if you are testing or in production.';
$string['settings_templates'] = 'Templates';
$string['settings_queue'] = 'Diploma queue';
$string['settings_setup_guide'] = 'Setup guide';
$string['settings_api_client_header'] = 'API Client settings';
$string['settings_api_client_information'] = 'Settings are provided by Diplomasafe here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://demo-admin.diplomasafe.net/en-US/auth-user</a>';
$string['settings_environment'] = 'Environment';
$string['settings_environment_desc'] = 'Determines if you are testing or in production.';
$string['settings_test_base_url'] = 'Base url (test site)';
$string['settings_test_base_url_desc'] = 'The url for the API incl. the version number.';
$string['settings_prod_base_url'] = 'Base url (production site)';
$string['settings_prod_base_url_desc'] = 'The url for the API incl. the version number.';
$string['settings_test_personal_access_token'] = 'Personal Access Token (test site)';
$string['settings_test_personal_access_token_desc'] = 'Create token here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://demo-admin.diplomasafe.net/en-US/auth-user</a>.';
$string['settings_prod_personal_access_token'] = 'Personal Access Token (production site)';
$string['settings_prod_personal_access_token_desc'] = 'Create token here: <a href="https://demo-admin.diplomasafe.net/en-US/auth-user">https://live-admin.diplomasafe.net/en-US/auth-user</a>.';
$string['settings_api_timeout'] = 'API timeout';
$string['settings_api_timeout_desc'] = 'The timeout in seconds.';
$string['settings_queue_amount_to_process'] = 'Queue items to process.';
$string['settings_queue_amount_to_process_desc'] = 'The number of queue items to process each time the queue is triggered by the cron job.';
$string['settings_moodle_duration_field'] = 'Moodle duration field';
$string['settings_moodle_duration_field_desc'] = 'Select the field to use for duration.';
$string['settings_moodle_location_field'] = 'Moodle location field';
$string['settings_moodle_location_field_desc'] = 'Select the field to use for location.';
$string['settings_select_custom_field'] = 'Select custom field';
$string['settings_item_count_per_page'] = 'Items per page';
$string['settings_item_count_per_page_desc'] = 'The number of items to show on each page in the admin views. Set to 0 for no limit.';
$string['settings_available_language_ids'] = 'Available languages';
$string['settings_available_language_ids_desc'] = 'Select the languages to make available in the course module.';
$string['settings_available_template_ids'] = 'Available templates';
$string['settings_available_template_ids_desc'] = 'Select the templates to make available in the course module.';

// Single view
$string['course_completed_message'] = 'You will receive a link for your certificate via mail when the course is completed.';

// Default form
$string['select_default_option_language'] = '- Select language -';
$string['select_default_option_template'] = '- Select template -';
$string['label_template'] = 'Template';
$string['template_help'] = 'Select a template';
$string['label_language'] = 'Language';
$string['ajax_error_occurred'] = 'An error occurred. Could not fetch data';

// Capabilities
$string['diplomasafe:addinstance'] = 'Add instance';
$string['diplomasafe:receive_api_error_mail'] = 'Receive API mail with error messages';
$string['diplomasafe:diplomasafeinstructor'] = 'Diplomasafe instructor';
$string['diplomasafe:access_admin_views'] = 'Access admin views';

// Privacy
$string['privacy:metadata:diplomasafe_queue'] = 'The table with the queue items for creating diplomas';
$string['privacy:metadata:mod_diplomasafe:course_id'] = 'The ID of the course';
$string['privacy:metadata:mod_diplomasafe:user_id'] = 'The ID of the user';
$string['privacy:metadata:mod_diplomasafe:status'] = 'The queue status (pending, running, successful, failed)';
$string['privacy:metadata:mod_diplomasafe:message'] = 'The queue message';
$string['privacy:metadata:mod_diplomasafe:time_created'] = 'The time of creation';
$string['privacy:metadata:mod_diplomasafe:time_modified'] = 'The time of modification';
$string['privacy:metadata:mod_diplomasafe:last_run'] = 'The last time this queue item has been run';
$string['privacy:metadata:mod_diplomasafe:last_mail_sent'] = 'The time the last mail were sent to the manager';

// Messages
$string['messageprovider:api_error'] = 'API error notification';
$string['message_api_error_subject'] = 'API error';
$string['message_api_error_body'] = 'The following error occurred in the API: {$a}';
$string['message_language_please_select_error'] = 'Please select a language';
$string['message_template_please_select_error'] = 'Please select a template';
$string['message_template_id_unavailable_error'] = 'Template ID unavailable. Template could not be stored';
$string['message_language_id_unavailable_error'] = 'Language ID unavailable. Template could not be stored';
$string['message_invalid_response_from_endpoint'] = 'Error: Invalid response from webservice. Endpoint: {$a->endpoint}. Response: {$a->response}';
$string['message_user_could_not_be_found'] = 'The user with ID "{$a}" could not be found. Can\'t create the diploma';
$string['message_template_invalid'] = 'The selected template "{$a}" is not valid.';
$string['message_can_not_find_template'] = 'Can not find the template. Did you remember the following? 1) Run the cron job to import the templates. 2) Select one of the imported templates for the module in the course?';
$string['message_item_created'] = 'New item added to the queue';
$string['message_item_deleted'] = 'Item deleted from the queue';
$string['message_invalid_action'] = 'Invalid action: {$a}';
$string['message_diploma_created_successfully'] = 'Issuing diploma for course ID: {$a->course_id}, module instance ID: {$a->module_instance_id} and user ID: {$a->user_id}. Diploma created successfully.';
$string['message_processing_queue_items'] = 'Processing queue items ...';
$string['message_total_queue_items_processed'] = 'Total queue items processed: {$a}';
$string['message_item_number'] = 'Item {$a}) ';
$string['message_remote_diploma_fields_missing_local_mapping'] = 'The following remote diploma field(s) are missing local mapping(s): {$a}';
$string['message_template_stored_successfully'] = 'Template stored successfully';
$string['message_remote_templates_to_store'] = 'Remote templates to store: {$a}';
$string['message_remote_templates_stored'] = 'Remote templates stored: {$a->stored_count}/{$a->total_count}';
$string['message_marked_as_valid'] = 'Marked as valid';
$string['message_marked_as_invalid'] = 'Marked as invalid';
$string['message_could_not_push_to_queue'] = 'Could not push to the queue. Course ID: {$a->course_id}, Module instance ID: {$a->module_instance_id}, User ID: {$a->user_id}. Error: {$a->error}';

// Cron
$string['cron_store_diploma_templates'] = 'Store diploma templates';
$string['cron_process_queue'] = 'Process the queue for issuing diplomas';

// Statuses
$string['status_pending'] = 'Pending';
$string['status_running'] = 'Running';
$string['status_successful'] = 'Successful';
$string['status_failed'] = 'Failed';
$string['missing_or_invalid_status'] = 'Missing or invalid status';

// Setup guide view
$string['view_setup_guide_header'] = 'Setup guide';
$string['view_setup_guide_description'] = '<p>The Diplomasafe activity allows storing templates and issuing diplomas for Diplomasafe.com.</p>
    <ol>
        <li>
            <strong>Add required settings</strong><br>
            Go to the <a href="/admin/settings.php?section=modsettingdiplomasafe" target="_blank">settings</a> view to select environment (live/prod) and add an API token.</li>
        <li>
            <strong>Store templates and languages</strong><br>
            Run the <a href="/admin/tool/task/schedule_task.php?task=mod_diplomasafe%5Ctask%5Cstore_diploma_templates" target="_blank">scheduled task for storing diploma templates and languages</a> from the API.<br>
            <i>The scheduled task is executed automatically after a period of time.</i>
        </li>
        <li>
            <strong>Select the templates and languages to enable</strong><br>
            Go to the <a href="/admin/settings.php?section=modsettingdiplomasafe" target="_blank">settings</a> view to select the templates and languages to enable in courses.
        </li>
        <li>
            <strong>Add course activities</strong><br>
            Add the Diplomasafe activity module to a course and select language and template for the diplomas in the settings of the module.<br>
        </li>
        <li>
            <strong>Wait for students to complete courses</strong><br>
            A job will be added to the queue every time a course is completed by a student.<br>
            <i>Completion data is calculated when an event is triggered by the <a href="/admin/tool/task/schedule_task.php?task=core%5Ctask%5Ccompletion_regular_task" target="_blank">scheduled task for calculating completion data</a>.</i>
        </li>
        <li>
            <strong>Process queue to generate diplomas</strong><br>
            The queue is processed by the <a href="/admin/tool/task/schedule_task.php?task=mod_diplomasafe%5Ctask%5Cprocess_queue" target="_blank">scheduled task for processing the queue</a>. Go to <a href="/mod/diplomasafe/view.php?view=queue_list" target="_blank">the queue</a> to get an overview.<br>
            <i>The scheduled task is executed automatically after a period of time.</i>
        </li>
    </ol>';

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
$string['view_queue_list_th_course_fullname'] = 'Course';
$string['view_queue_list_th_user'] = 'User';
$string['view_queue_list_th_status'] = 'Status';
$string['view_queue_list_th_message'] = 'Message';
$string['view_queue_list_th_time_created'] = 'Time created';
$string['view_queue_list_th_last_run'] = 'Last run';
$string['view_queue_list_th_last_mail_sent'] = 'Last mail sent';
$string['view_queue_list_th_delete'] = 'Delete';
$string['view_queue_add_again'] = 'Add again';
$string['view_queue_list_back'] = 'Back to settings';
$string['view_queue_list_course_text'] = 'Course: {$a}';
$string['view_queue_list_activity_text'] = 'Activity: {$a}';

// Other
$string['show_description'] = 'Show description';
$string['confirm_deletion'] = 'Please confirm deletion';
