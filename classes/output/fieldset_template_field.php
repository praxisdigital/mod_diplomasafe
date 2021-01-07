<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
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
class fieldset_template_field implements \renderable, \templatable
{
    /**
     * @var \moodle_page
     */
    private $page;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     */
    public function __construct(\moodle_page $page) {
        $this->page = $page;
    }

    /**
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output): array {
        $this->page->requires->js_call_amd('mod_diplomasafe/template_ajax', 'init');
        return [
            'session_key' => sesskey()
        ];
    }
}
