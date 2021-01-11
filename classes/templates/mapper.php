<?php
namespace mod_diplomasafe\templates;

use mod_diplomasafe\entities\template;
use mod_diplomasafe\collections\template_default_field_values;
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

        $transaction = $this->db->start_delegated_transaction();

        try {
            // Store template
            if (!$this->db->record_exists(self::TABLE, [
                'idnumber' => $template->idnumber
            ])) {
                $template->id = $this->create($template);
            } else {
                $this->update($template);
                $template->id = template_factory::get_repository()
                    ->get_by_idnumber($template->idnumber)->id;
            }

            /** @var template_default_field_values $default_fieldss */
            $language_keys = $template->default_fields->get_available_language_keys();

            // Make sure all language keys are stored
            foreach ($language_keys as $language_key) {
                if (!$this->db->record_exists('diplomasafe_languages', [
                    'name' => $language_key
                ])) {
                    $this->db->insert_record('diplomasafe_languages', (object)[
                        'name' => $language_key
                    ]);
                }
            }

            // Store default fields
            foreach ($template->default_fields as $default_field) {
                $default_fields_mapper = template_factory::get_default_fields_mapper();
                $default_fields_mapper->store($template->id, $default_field);
            }

            $transaction->allow_commit();

        } catch (\Exception $e) {
            $transaction->rollback($e);
            throw new \RuntimeException($e->getMessage());
        }

        return true;
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
