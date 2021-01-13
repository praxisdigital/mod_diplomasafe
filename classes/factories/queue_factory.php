<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\factory;
use mod_diplomasafe\queue\mapper;
use mod_diplomasafe\queue\repository;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class queue_factory extends factory
{
    /**
     * @return mapper
     */
    public static function get_queue_mapper() : mapper {
        return new mapper(self::get_db());
    }

    /**
     * @return repository
     */
    public static function get_queue_repository() : repository {
        return new repository(self::get_db());
    }
}
