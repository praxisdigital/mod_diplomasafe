<?php
namespace mod_diplomasafe\templates;

use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\template_factory;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates
 */
class mapper
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
     * @param template $template
     *
     * @return bool
     * @throws \dml_exception
     */
    public function store(template $template) : bool {
        if (!$this->db->record_exists(self::TABLE, [
            'idnumber' => $template->idnumber
        ])) {
            return $this->create($template);
        }
        return $this->update($template);
    }

    /**
     * @param template $template
     *
     * @return int
     * @throws \dml_exception
     */
    private function create(template $template) : int {
        return $this->db->insert_record(self::TABLE, (object)[
            'organisation_id' => $template->organisation_id,
            'default_language_id' => $template->default_language_id,
            'idnumber' => $template->idnumber,
            'name' => $template->name,
            'is_valid' => $template->is_valid
        ]);
    }

    /**
     * @param template $template
     *
     * @return bool
     * @throws \dml_exception
     */
    private function update(template $template) : bool {
        $repo = template_factory::get_repository();
        $template = $repo->get_by_idnumber($template->idnumber);
        if (!$template->exists()) {
            throw new \RuntimeException('The template does not exist. Can\'t update!');
        }
        return $this->db->update_record(self::TABLE, (object)[
            'id' => $template->id,
            'organisation_id' => $template->organisation_id,
            'default_language_id' => $template->default_language_id,
            'idnumber' => $template->idnumber,
            'name' => $template->name,
            'is_valid' => $template->is_valid
        ]);
    }
}
