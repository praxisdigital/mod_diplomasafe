<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\contracts;

defined('MOODLE_INTERNAL') || die();

/**
 * Interface
 *
 * @package mod_diplomasafe\contracts
 */
interface mapping_interface
{
    /**
     * @return string
     */
    public function get_data() : string;

    /**
     * @return string
     */
    public function get_remote_id() : string;
}
