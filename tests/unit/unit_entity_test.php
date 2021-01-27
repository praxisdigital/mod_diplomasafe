<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\entities\template;

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_unit_entity_testcase extends advanced_testcase
{
    /**
     * @test
     *
     * @throws dml_exception
     */
    public function diploma_has_magic_entity_properties_set_with_array() : void {

        $this->resetAfterTest();

        $diploma = new diploma([
            'template' => 't498c1434976b8b05659ff5654b3403d3af4672bd',
            'module_instance_id' => 6,
            'user_id' => 2,
        ]);

        self::assertEquals('t498c1434976b8b05659ff5654b3403d3af4672bd', $diploma->template);
        self::assertEquals(6, $diploma->module_instance_id);
        self::assertEquals(2, $diploma->user_id);
    }

    /**
     * @test
     *
     */
    public function language_has_magic_entity_properties_set_with_array() : void {

        $this->resetAfterTest();

        $language = new language([
            'name' => 'en-US',
        ]);

        self::assertEquals('en-US', $language->name);
    }

    /**
     * @test
     */
    public function queue_has_magic_entity_properties_set_with_array() : void {

        $this->resetAfterTest();

        $queue_item = new queue_item([
            'course_id' => 6,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => 1611576305,
        ]);

        self::assertEquals(6, $queue_item->course_id);
        self::assertEquals(2, $queue_item->user_id);
        self::assertEquals(queue_item::QUEUE_ITEM_STATUS_PENDING, $queue_item->status);
        self::assertEquals(1611576305, $queue_item->time_modified);
    }

    /**
     * @test
     */
    public function template_has_magic_entity_properties_set_with_array() : void {

        $this->resetAfterTest();

        $template = new template([
            'organisation_id' => 'o343e4d01a6f83d76d3818453637b3227417e10ba',
            'default_language_id' => 2,
            'idnumber' => 't498c1434976b8b05659ff5654b3403d3af4672bd',
            'name' => 'Test template',
            'is_valid' => true
        ]);

        self::assertEquals('o343e4d01a6f83d76d3818453637b3227417e10ba', $template->organisation_id);
        self::assertEquals(2, $template->default_language_id);
        self::assertEquals('t498c1434976b8b05659ff5654b3403d3af4672bd', $template->idnumber);
        self::assertEquals('Test template', $template->name);
        self::assertTrue($template->is_valid);
    }
}
