<?php
/**
 * @developer   Johnny Drud
 * @date        14-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\diplomas\fields;

use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\diploma;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\diplomas
 */
class repository
{
    /**
     * @const string
     */
    private const TABLE = 'diplomasafe_map_dipl_fields';

    /**
     * @var \moodle_database
     */
    private $db;

    /**
     * @var diplomasafe_config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \moodle_database $db
     * @param diplomasafe_config $config
     */
    public function __construct(\moodle_database $db, diplomasafe_config $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * @return array
     * @throws \dml_exception
     */
    public function get_field_ids() : array {
        $field = 'prod_idnumber';
        if ($this->config->is_test_environment()) {
            $field = 'test_idnumber';
        }
        return array_keys($this->db->get_records(self::TABLE, null, '', $field));
    }

    /**
     * @return array
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function get_field_data(diploma $diploma) : array {

        $mapped_fields = $this->db->get_records(self::TABLE);

        foreach ($mapped_fields as $mapped_field) {

            $field_id = $mapped_field->prod_idnumber;
            if ($this->config->is_test_environment()) {
                $field_id = $mapped_field->test_idnumber;
            }

            // The IDs
            //$diploma->user_id
            //$diploma->course_id

            // Todo: Extract data from Moodle based on the field code

            // moodle_course_date		        [Course startdate]
            // moodle_course_period		        [Course startdate] – [Course enddate]
            // moodle_duration		            Moodle admin skal oprette et brugerkonfigureret felt (course custom field) som mappes af moodle admin i opsætningen af pluginnet.
            // moodle_location		            Moodle admin skal oprette et brugerkonfigureret felt (course custom field) som mappes af moodle admin i opsætningen af pluginnet.
            // moodle_instructor		        Der oprettes en ny rettighed med betegnelsen ”Diplomasafeinstrucor”, der default knyttes til rollearketypen ”Teacher” . Alle brugere tilmeldt kurset med denne rettighed medsendes som undervisere i en liste adskilt med komma.

            $diploma_fields[$field_id] = ''; // Todo: Add value here
        }

        return $diploma_fields;
    }
}
