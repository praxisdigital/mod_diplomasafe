<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\templates;

use mod_diplomasafe\collections\templates;
use mod_diplomasafe\config;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\diploma_factory;

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
     * @var config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \moodle_database $db
     * @param config $config
     */
    public function __construct(\moodle_database $db, config $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * @param int|null $language_id
     * @param bool $only_available
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_all_records(int $language_id = null, bool $only_available = false) : array {
        $sql = /** @lang mysql */'
        SELECT t.id, t.organisation_id, l.name default_language, 
        t.idnumber, t.name, t.is_valid
        FROM {' . self::TABLE . '} t
        LEFT JOIN {diplomasafe_languages} l ON l.id = t.default_language_id
        WHERE 1
        ';
        $sql_params = [];
        if ($only_available) {
            $available_template_ids = $this->config->get_available_template_ids();
            if (empty($available_template_ids)) {
                return [];
            }
            [$sql_in, $sql_params] = $this->db->get_in_or_equal($available_template_ids, SQL_PARAMS_NAMED);
            $sql .= ' AND t.id ' . $sql_in;
        }
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
     * @return template
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_first_valid() : template {

        $sql = /** @lang mysql */'
        SELECT * FROM {' . self::TABLE . '} WHERE is_valid = 1 LIMIT 1';

        $record = (array)$this->db->get_record_sql($sql);

        $this->validate_record($record);

        return new template($record);
    }

    /**
     * @param int $template_id
     *
     * @return template
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_by_id(int $template_id) : template {

        $record = (array)$this->db->get_record(self::TABLE, [
            'id' => $template_id
        ]);

        $this->validate_record($record);

        return new template($record);
    }

    /**
     * @param $language_id
     * @param bool $only_available
     *
     * @return templates
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_by_language($language_id, bool $only_available = false) : templates {
        return new templates($language_id, $only_available);
    }

    /**
     * @param string $template_idnumber
     *
     * @return template
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_by_idnumber(string $template_idnumber) : template {

        $record = (array)$this->db->get_record(self::TABLE, [
            'idnumber' => $template_idnumber
        ]);

        $this->validate_record($record);

        return new template($record);
    }

    /**
     * @param $params
     *
     * @return bool
     * @throws \dml_exception
     */
    public function exists($params) : bool {
        return $this->db->record_exists(self::TABLE, $params);
    }

    /**
     * @param int $course_id
     *
     * @return template
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_by_course_id(int $course_id) : template {
        $template_id = $this->db->get_field('diplomasafe', 'template_id', [
            'course' => $course_id
        ]);

        return $this->get_by_id($template_id);
    }

    /**
     * @param int $module_id
     *
     * @return template
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_by_module_id(int $module_id) : template {
        $template_id = $this->db->get_field('diplomasafe', 'template_id', [
            'id' => $module_id
        ]);

        return $this->get_by_id($template_id);
    }

    /**
     * @param array $record
     *
     * @throws \coding_exception
     */
    private function validate_record(array $record) : void {
        if ((isset($record[0]) && $record[0] === false) || empty($record)) {
            throw new \RuntimeException(
                get_string('message_can_not_find_template', 'mod_diplomasafe')
            );
        }
    }
}
