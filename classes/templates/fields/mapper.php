<?php
/**
 * @developer   Johnny Drud
 * @date        11-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\templates\fields;

use mod_diplomasafe\entities\template;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates\default_fields
 */
class mapper
{
    /**
     * @const string
     */
    private const TABLE = 'diplomasafe_template_texts';

    /**
     * @var \moodle_database
     */
    private $db;

    /**
     * Constructor
     *
     * @param \moodle_database $db
     */
    public function __construct(\moodle_database $db) {
        $this->db = $db;
    }

    /**
     * @param int $template_id
     * @param int $language_id
     * @param array $default_field
     *
     * @return void
     * @throws \dml_exception
     */
    public function store(int $template_id, int $language_id, array $default_field) : void {

        $field_type_id = Template::get_field_type_id_by_key($default_field['key']);

        $field_id = $this->db->get_field(self::TABLE, 'id', [
            'template_id' => $template_id,
            'language_id' => $language_id,
            'type' => $field_type_id
        ]);

        $field_exists = $field_id ? true : false;

        if (!$field_exists) {
            $this->db->insert_record(self::TABLE, (object)[
                'template_id' => $template_id,
                'language_id' => $language_id,
                'type' => $field_type_id,
                'value' => $default_field['value']
            ]);
        } else {
            $this->db->update_record(self::TABLE, (object)[
                'id' => $field_id,
                'template_id' => $template_id,
                'language_id' => $language_id,
                'type' => $field_type_id,
                'value' => $default_field['value']
            ]);
        }
    }
}
