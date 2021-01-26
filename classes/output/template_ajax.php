<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\output;

use mod_diplomasafe\collections\templates;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\factory;
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
     * @var int
     */
    private $selected_template_id;

    /**
     * Constructor
     *
     * @param int $language_id
     * @param int $selected_template_id
     */
    public function __construct(int $language_id, int $selected_template_id) {
        $this->language_id = $language_id;
        $this->selected_template_id = $selected_template_id;
    }

    /**
     * @param renderer_base $output
     *
     * @return array|\stdClass|void
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public function export_for_template(renderer_base $output) {

        $config = factory::get_config();

        $templates = template_factory::get_repository()
            ->get_by_language($this->language_id, $config->get_available_template_ids());
        $is_disabled = $this->language_id === 0;

        $this->set_selected($templates);

        return [
            'templates' => $templates,
            'is_disabled' => $is_disabled,
        ];
    }

    /**
     * @param $templates
     *
     * @return templates
     */
    private function set_selected($templates) : templates {
        foreach ($templates as $i => $template) {
            $template->selected = false;
            if ((int)$template->id === $this->selected_template_id) {
                $template->selected = true;
            }
            $templates[$i] = $template;
        }
        return $templates;
    }
}
