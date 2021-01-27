<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\languages;

use mod_diplomasafe\collections\languages;
use mod_diplomasafe\config;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\languages
 */
class repository
{
    /**
     * @const string
     */
    private const TABLE = 'diplomasafe_languages';

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
     * @param array|null $available_language_ids
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_all_records(array $available_language_ids = null) : array {

        $sql = /** @lang mysql */ '
            SELECT DISTINCT *
            FROM {' . self::TABLE . '}
            WHERE 1';

        $sql_params = [];
        if ($available_language_ids !== null) {
            if (empty($available_language_ids)) {
                return [];
            }
            [$sql_in, $sql_params] = $this->db->get_in_or_equal($available_language_ids, SQL_PARAMS_NAMED);
            $sql .= ' AND id ' . $sql_in;
        }

        return array_values($this->db->get_records_sql($sql, $sql_params));
    }

    /**
     * @param array|null $available_language_ids
     *
     * @return languages
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_all(array $available_language_ids = null) : languages {
        return new languages($available_language_ids);
    }

    /**
     * @param int $id
     *
     * @return language
     * @throws \dml_exception
     */
    public function get_by_id(int $id) : language {
        $sql =  /** @lang mysql */'
        SELECT * FROM {' . self::TABLE . '} WHERE id = :id LIMIT 1';
        return new language((array)$this->db->get_record_sql($sql, [
            'id' => $id
        ]));
    }

    /**
     * @param string $key
     *
     * @return language
     * @throws \dml_exception
     */
    public function get_by_key(string $key) : language {
        $sql =  /** @lang mysql */'
        SELECT * FROM {' . self::TABLE . '} WHERE name = :name LIMIT 1';
        return new language((array)$this->db->get_record_sql($sql, [
            'name' => trim($key)
        ]));
    }

    /**
     * @param string $key
     *
     * @return bool
     * @throws \dml_exception
     */
    public function exists(string $key) : bool {
        return $this->db->record_exists(self::TABLE, [
            'name' => trim($key)
        ]);
    }
}
