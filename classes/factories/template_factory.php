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
use mod_diplomasafe\templates\default_fields\mapper as default_fields_mapper;
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
        return new repository(self::get_db());
    }

    /**
     * @return api_repository
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     * @throws \moodle_exception
     */
    public static function get_api_repository() : api_repository {
        return new api_repository(self::get_api_client());
    }

    /**
     * @return default_fields_mapper
     */
    public static function get_default_fields_mapper() : default_fields_mapper {
        return new default_fields_mapper(self::get_db());
    }
}
