<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use renderer_base;
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class default_output implements \renderable, \templatable
{
    /**
     * @var \moodle_page
     */
    private $page;

    /**
     * @var int
     */
    private $module_id;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     * @param int $module_id
     */
    public function __construct(\moodle_page $page, int $module_id) {
        $this->page = $page;
        $this->module_id = $module_id;
    }

    /**
     * @param renderer_base $output
     *
     * @return array|stdClass|void
     */
    public function export_for_template(renderer_base $output) {
        return [];
    }
}
