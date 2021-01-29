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

use mod_diplomasafe\config;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\settings\admin_setting_link;

defined('MOODLE_INTERNAL') || die();

global $DB;

if ($ADMIN->fulltree) {
    // https://docs.moodle.org/dev/Admin_settings

    $component = 'mod_diplomasafe';

    $name = $component . '/views';
    $heading = get_string('settings_views_header', $component);
    $information = get_string('settings_views_information', $component);
    $settings->add(new admin_setting_heading($name, $heading, $information));

    $field_identifier = 'setup_guide';
    $name = $component . '/' . $field_identifier;
    $heading = get_string('settings_' . $field_identifier, $component);
    $setting = new admin_setting_link($name, $heading,
        new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'setup_guide'
        ])
    );
    $settings->add($setting);

    $field_identifier = 'templates';
    $name = $component . '/' . $field_identifier;
    $heading = get_string('settings_' . $field_identifier, $component);
    $setting = new admin_setting_link($name, $heading,
        new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'templates_list'
        ])
    );
    $settings->add($setting);

    $field_identifier = 'queue';
    $name = $component . '/' . $field_identifier;
    $heading = get_string('settings_' . $field_identifier, $component);
    $setting = new admin_setting_link($name, $heading,
        new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'queue_list'
        ])
    );
    $settings->add($setting);

    $field_identifier = 'settings';
    $name = $component . '/' . $field_identifier;
    $heading = get_string('settings_' . $field_identifier, $component);
    $information = get_string('settings_api_client_information', $component);
    $settings->add(new admin_setting_heading($name, $heading, $information));

    $field_identifier = 'environment';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 'test';
    $options = ['test' => 'test', 'prod' => 'prod'];
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $field_identifier = 'test_base_url';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 'https://demo-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'prod_base_url';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 'https://live-api.diplomasafe.net/api/v1';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'test_personal_access_token';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'prod_personal_access_token';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = '';
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'api_timeout';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 10;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'queue_amount_to_process';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 20;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'delete_from_queue_after_days';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 30;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'moodle_duration_field';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $custom_fields = $DB->get_records('customfield_field', null, 'shortname', 'id, shortname');
    $default = '';
    $options = [
        '' => get_string('settings_select_custom_field', 'mod_diplomasafe')
    ];
    foreach ($custom_fields as $custom_field) {
         $options[$custom_field->shortname] = $custom_field->shortname;
    }
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $field_identifier = 'moodle_location_field';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = '';
    $options = [
        '' => get_string('settings_select_custom_field', 'mod_diplomasafe')
    ];
    foreach ($custom_fields as $custom_field) {
        $options[$custom_field->shortname] = $custom_field->shortname;
    }
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $options));

    $field_identifier = 'item_count_per_page';
    $name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    $default = 20;
    $settings->add(new admin_setting_configtext($name, $title, $description, $default));

    $field_identifier = 'available_language_ids';
    $languages_repo = language_factory::get_repository();
    $languages = $languages_repo->get_all();
    $default_languages = [];
    $available_languages = [];
    if ($languages->count() > 0) {
        foreach ($languages as $language) {
            /** @var language $language */
            $default_languages[] = (int)$language->id;
            $available_languages[(int)$language->id] = $language->name;
        }
    }
    $setting_name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    if (empty($available_languages) && empty($default_languages)) {
        $setting = new admin_setting_configempty(
            $setting_name,
            $title,
            $description
        );
    } else {
        $setting = new admin_setting_configmultiselect(
            $setting_name,
            $title,
            $description,
            $default_languages,
            $available_languages
        );
    }
    $settings->add($setting);

    $field_identifier = 'available_template_ids';
    $templates_repo = template_factory::get_repository();
    $templates = $templates_repo->get_all();
    $default_templates = [];
    $available_templates = [];
    if ($templates->count() > 0) {
        foreach ($templates as $template) {
            /** @var template $template */
            $default_templates[] = (int)$template->id;
            $available_templates[(int)$template->id] = $template->name;
        }
    }
    $setting_name = $component . '/' . $field_identifier;
    $title = get_string('settings_' . $field_identifier, $component);
    $description = get_string('settings_' . $field_identifier . '_desc', $component);
    if (empty($available_templates) && empty($default_templates)) {
        $setting = new admin_setting_configempty(
            $setting_name,
            $title,
            $description
        );
    } else {
        $setting = new admin_setting_configmultiselect(
            $setting_name,
            $title,
            $description,
            $default_templates,
            $available_templates
        );
    }
    $settings->add($setting);
}
