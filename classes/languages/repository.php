<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\languages;

use mod_diplomasafe\collections\languages;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\factories\diploma_factory;

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
     * @return array
     * @throws \dml_exception
     */
    public function get_all_records() : array {
        return array_values($this->db->get_records(self::TABLE));
    }

    /**
     * @return languages
     */
    public function get_all() : languages {
        return new languages();
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
