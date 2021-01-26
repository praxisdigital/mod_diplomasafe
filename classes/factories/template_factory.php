<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\templates\mapper;
use mod_diplomasafe\templates\api\repository as api_repository;
use mod_diplomasafe\factory;
use mod_diplomasafe\templates\repository;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class template_factory extends factory
{
    /**
     * @return mapper
     */
    public static function get_mapper() : mapper {
        return new mapper(self::get_db());
    }

    public static function get_repository() : repository {
        return new repository(self::get_db(), self::get_config());
    }

    /**
     * @return api_repository
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_api_repository() : api_repository {
        return new api_repository(self::get_api_client(), self::get_config());
    }
}
