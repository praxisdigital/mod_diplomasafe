<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\factory;
use renderer_base;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class queue_list implements \renderable, \templatable
{
    /**
     * @var \moodle_page
     */
    private $page;

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
     * @param \moodle_page $page
     * @param object $output
     * @param int $page_number
     */
    public function __construct(\moodle_page $page, object $output, int $page_number) {
        $this->page = $page;
        $this->output = $output;
        $this->page_number = $page_number;
    }

    /**
     * @param renderer_base $output
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function export_for_template(renderer_base $output) : array {

        $this->page->requires->js_call_amd('mod_diplomasafe/delete_confirmation', 'init');

        $queue_repo = queue_factory::get_queue_repository();
        $queue_items = $queue_repo->get_all();
        $total_count = $queue_items->count();

        $per_page = factory::get_config()->get_item_count_per_page();
        $base_url = new \moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'queue_list'
        ]);

        $pagination = '';
        if ($per_page !== 0) {
            $queue_items = $queue_items->limit(
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
            'queue_items' => $queue_items,
            'pagination' =>$pagination
        ];
    }
}
