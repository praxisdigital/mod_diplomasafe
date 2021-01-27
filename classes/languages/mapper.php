<?php
/**
 * @developer   Johnny Drud
 * @date        12-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\languages;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\languages
 */
class mapper
{
    public const TABLE = 'diplomasafe_languages';

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
     * @param $language_key
     *
     * @return int
     * @throws \dml_exception
     */
    public function create(string $language_key) : int {
        return $this->db->insert_record(self::TABLE, (object)[
            'name' => trim($language_key)
        ]);
    }


}
