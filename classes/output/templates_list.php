<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\config;
use mod_diplomasafe\collections\templates;
use mod_diplomasafe\factory;
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
     * @var object
     */
    private $output;

    /**
     * @var int
     */
    private $page_number;

    /**
     * Constructor
     *
     * @param object $output
     * @param int $page_number
     */
    public function __construct(object $output, int $page_number) {
        $this->output = $output;
        $this->page_number = $page_number;
    }

    /**
     * @param renderer_base $output
     *
     * @return array
     * @throws \moodle_exception
     */
    public function export_for_template(renderer_base $output) : array {

        $templates = new templates();
        $total_count = $templates->count();

        $per_page = factory::get_config()->get_item_count_per_page();
        $base_url = new \moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'templates_list'
        ]);

        $pagination = '';
        if ($per_page !== 0) {
            $templates = $templates->limit(
                ($this->page_number * $per_page),
                $per_page
            );
            $pagination = $this->output->paging_bar(
                $total_count,
                $this->page_number,
                $per_page,
                $base_url
            );
        }

        return [
            'templates' => $templates,
            'pagination' => $pagination
        ];
    }
}
