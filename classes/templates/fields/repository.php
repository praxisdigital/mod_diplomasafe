<?php
/**
 * @developer   Johnny Drud
 * @date        14-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\templates\fields;

use mod_diplomasafe\entities\language;
use mod_diplomasafe\entities\template;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates\default_fields
 */
class repository
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
     * @param template $template
     * @param language $language
     *
     * @return array
     * @throws \dml_exception
     */
    public function get_data_by_language(template $template, language $language) : array {
        $records = $this->db->get_records(self::TABLE, [
            'template_id' => $template->id,
            'language_id' => $language->id
        ]);

        $diploma_fields = [];
        foreach ($records as $record) {
            $diploma_fields[$record->field_code] = $record->value;
        }

        return $diploma_fields;
    }
}
