<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\diplomas\api\mapper as api_mapper;
use mod_diplomasafe\diplomas\fields\repository as fields_repository;
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
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_api_mapper() : api_mapper {
        return new api_mapper(self::get_api_client(), self::get_config());
    }

    /**
     * @return fields_repository
     */
    public static function get_fields_repository() : fields_repository  {
        return new fields_repository();
    }
}
