<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\entities;

use mod_diplomasafe\collections\default_template_fields;
use mod_diplomasafe\collections\template_field_values;
use mod_diplomasafe\entity;
use mod_diplomasafe\factories\diploma_factory;

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
 * @property bool $is_valid
 * @property default_template_fields $default_fields
 */
class template extends entity
{
    public const TEMPLATE_BASE_TITLE_FIELD = 'title';
    public const TEMPLATE_BASE_DESCRIPTION_FIELD = 'description';
    public const TEMPLATE_BASE_SHORT_DESCRIPTION_FIELD = 'description_short';

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
        $required_params = ['organisation_id', 'default_language_id', 'idnumber', 'name'];
        $this->process_params($params, $required_params);
    }

    /**
     * @return bool
     */
    public function exists() : bool {
        return $this->id !== null;
    }

    /**
     * @return mixed
     */
    public function is_valid() : bool {
        return $this->data['is_valid'];
    }

    /**
     * @param array $template_payload
     *
     * @return default_template_fields
     */
    public static function extract_default_fields(array $template_payload) : default_template_fields {
        return new default_template_fields(self::TEMPLATE_BASE_LANGUAGE_FIELDS, $template_payload);
    }

    /**
     * @param string $field_foreign_key
     *
     * @return null|string
     */
    public static function get_field_code_by_foreign_key(string $field_foreign_key) : ?string {
        return self::TEMPLATE_BASE_LANGUAGE_FIELDS[$field_foreign_key] ?? null;
    }
}
