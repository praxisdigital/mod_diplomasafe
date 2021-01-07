<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\factories\template_factory;
use renderer_base;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\output
 */
class template_ajax implements \renderable, \templatable
{
    /**
     * @var int
     */
    private $language_id;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     * @param int $language_id
     */
    public function __construct(int $language_id) {
        $this->language_id = $language_id;
    }

    /**
     * @param renderer_base $output
     *
     * @return array|\stdClass|void
     * @throws \dml_exception
     */
    public function export_for_template(renderer_base $output) {
        $templates = template_factory::get_repository()
            ->get_by_language($this->language_id);
        $is_disabled = $this->language_id === 0;
        return [
            'templates' => $templates,
            'is_disabled' => $is_disabled
        ];
    }
}
