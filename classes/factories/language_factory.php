<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\config;
use mod_diplomasafe\factory;
use mod_diplomasafe\languages\mapper;
use mod_diplomasafe\languages\repository;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class language_factory extends factory
{
    /**
     * @return repository
     */
    public static function get_repository() : repository {
        return new repository(self::get_db());
    }

    /**
     * @return mapper
     */
    public static function get_mapper() : mapper {
        return new mapper(self::get_db());
    }
}
