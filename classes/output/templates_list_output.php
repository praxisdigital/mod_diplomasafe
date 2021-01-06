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
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class templates_list_output implements \renderable, \templatable
{
    /**
     * @param renderer_base $output
     *
     * @return array|stdClass|void
     */
    public function export_for_template(renderer_base $output) {
        return [
            'templates' => new templates()
        ];
    }
}
