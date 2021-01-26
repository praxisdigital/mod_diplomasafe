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
     * @param bool $only_available
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_all_records(bool $only_available = false) : array {

        $sql = /** @lang mysql */ '
            SELECT *
            FROM {' . self::TABLE . '}
            WHERE 1';

        $sql_params = [];
        if ($only_available) {
            $available_language_ids = $this->config->get_available_language_ids();
            if (empty($available_language_ids)) {
                return [];
            }
            [$sql_in, $sql_params] = $this->db->get_in_or_equal($available_language_ids, SQL_PARAMS_NAMED);
            $sql .= ' AND id ' . $sql_in;
        }

        return array_values($this->db->get_records_sql($sql, $sql_params));
    }

    /**
     * @param bool $only_available
     *
     * @return languages
     * @throws \dml_exception
     */
    public function get_all(bool $only_available = false) : languages {
        return new languages($only_available);
    }

    /**
     * @param int $id
     *
     * @return language
     * @throws \dml_exception
     */
    public function get_by_id(int $id) : language {
        return new language((array)$this->db->get_record(self::TABLE, [
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
        return new language((array)$this->db->get_record(self::TABLE, [
            'name' => $key
        ]));
    }
}
