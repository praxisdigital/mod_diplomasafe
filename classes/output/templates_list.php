<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\collections\templates;
use renderer_base;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class templates_list implements \renderable, \templatable
{
    /**
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output) : array {
        return [
            'templates' => new templates()
        ];
    }
}
