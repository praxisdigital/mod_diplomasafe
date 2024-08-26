<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\config;
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
    public static function get_mapper(
        ?\moodle_database $db = null
    ) : mapper {
        return new mapper($db ?? self::get_db());
    }

    public static function get_repository(
        ?\moodle_database $db = null
    ) : repository {
        return new repository($db ?? self::get_db());
    }

    public static function get_api_repository(
        ?\curl $client = null,
        ?config $config = null
    ) : api_repository {
        return new api_repository(
            $client ?? self::get_api_client(),
                $config ?? self::get_config()
        );
    }
}
