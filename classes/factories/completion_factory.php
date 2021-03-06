<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\completion\repository;
use mod_diplomasafe\factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class completion_factory extends factory
{
    /**
     * @return repository
     */
    public static function get_repository() : repository {
        return new repository();
    }
}
