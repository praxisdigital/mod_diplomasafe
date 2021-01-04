<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\templates;

use mod_diplomasafe\collections\templates;
use mod_diplomasafe\entities\null_template;
use mod_diplomasafe\entities\template;

defined('MOODLE_INTERNAL') || die();

class repository
{
    /**
     * @const string
     */
    private const TABLE = 'diplomasafe_templates';

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
     * @return array
     * @throws \dml_exception
     */
    public function get_all_records() : array {
        return array_values($this->db->get_records(
            self::TABLE,
            [],
            '',
            'organisation_id, default_language_id, idnumber, name, is_valid'
        ));
    }

    /**
     * @return templates
     */
    public function get_all() : templates {
        return new templates();
    }

    /**
     * @param int $template_id
     *
     * @return template
     * @throws \dml_exception
     */
    public function get_by_id(int $template_id) : template {
        return new template($this->db->get_record(self::TABLE, [
            'id' => $template_id
        ], '*', MUST_EXIST));
    }

    /**
     * @param string $template_idnumber
     *
     * @return template
     * @throws \dml_exception
     */
    public function get_by_idnumber(string $template_idnumber) : template {
        return new template($this->db->get_record(self::TABLE, [
            'idnumber' => $template_idnumber
        ], '*', MUST_EXIST));
    }
}
