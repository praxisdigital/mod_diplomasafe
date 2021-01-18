<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
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
class diplomasafe implements \renderable, \templatable
{
    /**
     * @var string
     */
    private $error_message;

    /**
     * Constructor
     *
     * @param string $error_message
     */
    public function __construct(string $error_message) {
        $this->error_message = $error_message;
    }

    /**
     * @param renderer_base $output
     *
     * @return array
     */
    public function export_for_template(renderer_base $output) : array {
        return [
            'error_message' => $this->error_message
        ];
    }
}
