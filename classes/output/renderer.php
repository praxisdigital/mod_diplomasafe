<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class renderer extends plugin_renderer_base
{
    /**
     * @param default_output $view
     * @return string HTML string
     * @throws \moodle_exception
     */
    public function render_default_output(default_output $view){
        return $this->render_from_template('mod_diplomasafe/default', $view->export_for_template($this));
    }

    /**
     * @param templates_list_output $view
     * @return string HTML string
     * @throws \moodle_exception
     */
    public function render_templates_list_output(templates_list_output $view){
        return $this->render_from_template('mod_diplomasafe/templates_list', $view->export_for_template($this));
    }
}
