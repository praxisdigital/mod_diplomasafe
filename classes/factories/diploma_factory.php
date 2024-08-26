<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\config;
use mod_diplomasafe\diplomas\api\mapper as api_mapper;
use mod_diplomasafe\diplomas\fields\repository as fields_repository;
use mod_diplomasafe\factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 * @package mod_diplomasafe\factories
 */
class diploma_factory extends factory
{
    public static function get_api_mapper(
        ?\curl $client = null,
        ?config $config = null
    ): api_mapper {
        $config ??= self::get_config();
        return new api_mapper(
            $client ?? self::get_api_client($config),
            $config
        );
    }

    public static function get_fields_repository(
        ?config $config = null
    ): fields_repository {
        return new fields_repository($config ?? self::get_config());
    }
}
