<?php
namespace mod_diplomasafe\templates;

use mod_diplomasafe\collections\default_template_fields;
use mod_diplomasafe\entities\template;
use mod_diplomasafe\collections\template_default_field_values;
use mod_diplomasafe\factories\language_factory;
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
     * @const string
     */
    private const TABLE_LANGUAGES = 'diplomasafe_languages';

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

        $languages_mapper = language_factory::get_mapper();
        $languages_repo = language_factory::get_repository();

        try {
            // Store template
            if (!template_factory::get_repository()->exists([
                'idnumber' => $template->idnumber
            ])) {
                $template->id = $this->create($template);
            } else {
                $template->id = template_factory::get_repository()
                    ->get_by_idnumber($template->idnumber)->id;
                $this->update($template);
            }

            if (empty($template->id)) {
                throw new \RuntimeException(get_string('message_template_id_unavailable_error', 'mod_diplomasafe'));
            }

            $language_keys = $template->default_fields->get_available_language_keys();

            // Store language keys
            foreach ($language_keys as $language_key) {
                if (!$languages_repo->exists($language_key)) {
                    $languages_mapper->create($language_key);
                }
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
    public function create(template $template) : int {
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
    public function update(template $template) : bool {
        if (!$this->db->record_exists(self::TABLE, [
            'id' => $template->id
        ])) {
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
