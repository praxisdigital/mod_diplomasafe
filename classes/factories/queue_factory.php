<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\config;
use mod_diplomasafe\factory;
use mod_diplomasafe\queue\mapper;
use mod_diplomasafe\queue\repository;
use moodle_database;

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
    public static function get_queue_mapper(
        ?moodle_database $db = null,
        ?config $config = null
    ) : mapper {
        return new mapper(self::get_db());
    }

    public static function get_queue_repository(
        ?moodle_database $db = null,
        ?config $config = null
    ) : repository {
        return new repository(
            $db ?? self::get_db(),
            $config ?? self::get_config()
        );
    }
}
