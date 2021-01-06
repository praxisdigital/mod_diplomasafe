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
    public function get_mapper() : mapper {
        return new mapper(self::get_db());
    }

    public function get_repository() : repository {
        return new repository(self::get_db());
    }

    /**
     * @return api_repository
     * @throws \mod_diplomasafe\client\exceptions\invalid_argument_exception
     */
    public function get_api_repository() : api_repository {
        return new api_repository(self::get_api_client());
    }
}
