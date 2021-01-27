<?php
/**
 * @developer   Johnny Drud
 * @date        27-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use renderer_base;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class setup_guide implements \renderable, \templatable
{
    /**
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output) : array {
        return [];
    }
}
