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
     * @param int|null $language_id
     *
     * @return array
     * @throws \dml_exception
     */
    public function get_all_records(int $language_id = null) : array {
        $sql = /** @lang mysql */'
        SELECT t.id, t.organisation_id, l.name default_language, 
        t.idnumber, t.name, t.is_valid
        FROM {' . self::TABLE . '} t
        LEFT JOIN {diplomasafe_languages} l ON l.id = t.default_language_id
        WHERE 1
        ';
        $sql_params = [];
        if ($language_id !== null) {
            $sql .= ' AND t.default_language_id = :language_id';
            $sql_params['language_id'] = $language_id;
        }
        return array_values($this->db->get_records_sql($sql, $sql_params));
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
     * @param $language_id
     *
     * @return templates
     * @throws \dml_exception
     */
    public function get_by_language($language_id) : templates {
        return new templates($language_id);
    }

    /**
     * @param string $template_idnumber
     *
     * @return template
     * @throws \dml_exception
     */
    public function get_by_idnumber(string $template_idnumber) : template {
        return new template((array)$this->db->get_record(self::TABLE, [
            'idnumber' => $template_idnumber
        ], '*'));
    }
}
