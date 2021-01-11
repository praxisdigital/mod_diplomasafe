<?php
/**
 * @developer   Johnny Drud
 * @date        11-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\templates\default_fields;

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
     * @param array $default_field
     *
     * @throws \dml_exception
     */
    public function store(int $template_id, array $default_field) : void {

        $field_type_id = Template::get_field_type_id_by_key($default_field['key']);

        // Store default template fields
        if (!$this->db->record_exists(self::TABLE, [
            'template_id' => $template_id
        ])) {
            /*
            // Todo: Store template fields in the DB. FIX ERROR WHEN ENABLED !!!
            $this->db->insert_record(self::TABLE, (object)[
                'language_id' => '', // Todo: Insert language ID here
                'type' => $field_type_id,
                'value' => $default_field['value']
            ]);
            */
        }
        $this->db->update_record(self::TABLE, (object)[
            'id' => $template_id,
            'language_id' => '', // Todo: Insert language ID here
            'type' => $field_type_id,
            'value' => $default_field['value']
        ]);
    }
}
