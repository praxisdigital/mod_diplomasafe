<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\diplomas\api\mapper as api_mapper;
use mod_diplomasafe\diplomas\api\repository as api_repository;
use mod_diplomasafe\factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class diploma_factory extends factory
{
    /**
     * @return api_mapper
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public static function get_api_mapper() : api_mapper {
        return new api_mapper(self::get_api_client(), self::get_api_config());
    }

    /**
     * @return api_repository
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public static function get_api_repository() : api_repository {
        return new api_repository(self::get_api_client(), self::get_api_config());
    }
}
