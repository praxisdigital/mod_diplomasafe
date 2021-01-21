<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\mappings;

use mod_diplomasafe\contracts\mapping_interface;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\mapping;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * Get the course start date:
 * [Course startdate]
 *
 * @package mappings
 */
class moodle_course_date extends mapping implements mapping_interface
{
    /**
     * @return string
     * @throws \dml_exception
     */
    public function get_value(): string {
        if ((int)$this->course->startdate === 0) {
            return '';
        }

        $template_repo = template_factory::get_repository();

        try
        {
            $template = $template_repo->get_by_course_id($this->course->id);
        } catch (\Exception $e) {
            return '';
        }

        $language_repo = language_factory::get_repository();
        $language = $language_repo->get_by_id($template->default_language_id);
        language::set_locale(str_replace('-', '_', $language->name));

        return str_replace(', 00:00', '', userdate($this->course->startdate));
    }
}
