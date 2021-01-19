<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\factories\queue_factory;
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
     * @param renderer_base $output
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function export_for_template(renderer_base $output) : array {
        $queue_repo = queue_factory::get_queue_repository();
        return [
            'queue_items' => $queue_repo->get_all()
        ];
    }
}
