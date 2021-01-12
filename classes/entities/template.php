<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\entities;

use mod_diplomasafe\collections\template_default_field_values;
use mod_diplomasafe\entity;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\entities
 *
 * @property $id
 * @property $organisation_id
 * @property $default_language_id
 * @property $idnumber
 * @property $name
 * @property $is_valid
 * @property template_default_field_values $default_fields
 */
class template extends entity
{
    public const TEMPLATE_BASE_TITLE_FIELD = 1;
    public const TEMPLATE_BASE_DESCRIPTION_FIELD = 2;
    public const TEMPLATE_BASE_SHORT_DESCRIPTION_FIELD = 3;

    /**
     * Each field is an array in the following format.
     *
     * Example:
     * name = [
     *   [en-US] =>
     *   [da-DK] => KURSUSTITEL
     * ]
     *
     * They are parsed separately from the regular fields.
     *
     * @const
     */
    public const TEMPLATE_BASE_LANGUAGE_FIELDS = [
        'name' => self::TEMPLATE_BASE_TITLE_FIELD, // This is the title. Huh!?!
        'description' => self::TEMPLATE_BASE_DESCRIPTION_FIELD,
        'description_short' => self::TEMPLATE_BASE_SHORT_DESCRIPTION_FIELD
    ];

    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'id' => null,
            'organisation_id' => '',
            'default_language_id' => null,
            'idnumber' => '',
            'name' => '',
            'is_valid' => false,
            'template_texts' => []
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = ['organisation_id', 'default_language_id', 'idnumber', 'name', 'is_valid'];
        $this->process_params($params, $required_params);
    }

    /**
     * @return bool
     */
    public function exists() : bool {
        return $this->id !== null;
    }

    /**
     * @param array $template_payload
     *
     * @return template_default_field_values
     */
    public static function extract_default_fields(array $template_payload) : template_default_field_values {
        return new template_default_field_values(self::TEMPLATE_BASE_LANGUAGE_FIELDS, $template_payload);
    }

    /**
     * @param string $base_field_key
     *
     * @return null
     */
    public static function get_field_type_id_by_key(string $base_field_key) : ?int {
        return self::TEMPLATE_BASE_LANGUAGE_FIELDS[$base_field_key] ?? null;
    }
}
