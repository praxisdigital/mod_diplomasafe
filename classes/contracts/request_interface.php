<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\contracts;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\contracts
 */
interface request_interface
{
    public function process() : \renderable;
}
