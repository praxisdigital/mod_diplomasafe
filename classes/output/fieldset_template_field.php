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
     * @var int
     */
    private $language_id;

    /**
     * Constructor
     *
     * @param int $language_id
     */
    public function __construct(int $language_id) {
        $this->language_id = $language_id;
    }

    /**
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output) {
        return [];
    }
}
