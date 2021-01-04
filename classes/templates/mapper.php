<?php
namespace mod_diplomasafe\templates;

use mod_diplomasafe\entities\template;

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
     */
    public function store(template $template) : bool {
        // Todo: Store the template
        return true;
    }

    /**
     * @param template $template
     *
     * @return bool
     */
    private function create(template $template) : bool {
        // Todo: Create the template
        return true;
    }

    /**
     * @param template $template
     *
     * @return bool
     */
    private function update(template $template) : bool {
        // Todo: Update the template
        return true;
    }
}
