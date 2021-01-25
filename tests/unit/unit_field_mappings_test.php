<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

use mod_diplomasafe\mapping;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_unit_field_mapping_testcase extends advanced_testcase
{
    /**
     * @const
     */
    public const REQUIRED_MAPPING_FIELDS = [
        'moodle_course_date',
        'moodle_course_period',
        'moodle_duration',
        'moodle_instructor',
        'moodle_location'
    ];

    /**
     * @test
     */
    public function required_mappings_exists_locally() : void {

        $this->resetAfterTest();

        $mapping_fields = array_keys(mapping::MAPPING_FIELDS);

        $this->assertEquals(self::REQUIRED_MAPPING_FIELDS, $mapping_fields);
    }
}
