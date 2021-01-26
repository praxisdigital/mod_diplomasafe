<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

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
     * @throws \dml_exception
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
     */
    public static function get_repository() : repository {
        return new repository(self::get_db(), self::get_config());
    }

    /**
     * @return mapper
     */
    public static function get_mapper() : mapper {
        return new mapper(self::get_db());
    }
}
