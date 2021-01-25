<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\queue;
use mod_diplomasafe\queue\mapper;
use mod_diplomasafe\queue\repository;

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_integration_queue_testcase extends advanced_testcase
{
    /**
     * @var mapper
     */
    private $queue_mapper;

    /**
     * @var repository
     */
    private $queue_repo;

    /**
     * @var diplomasafe_config
     */
    private $config;

    /**
     * @return void
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     * @throws dml_exception
     */
    public function setUp() : void {

        global $DB;

        $this->queue_mapper = queue_factory::get_queue_mapper();
        $this->queue_repo = queue_factory::get_queue_repository();

        // THIS SQL NEEDS THE mdl_ PREFIX - DO NOT REMOVE
        $REAL_DATA = $DB->get_records_sql_menu(
        /** @lang mysql */ 'SELECT name, value FROM mdl_config_plugins WHERE `plugin` = "mod_diplomasafe"'
        );

        if(empty($REAL_DATA['test_base_url']) || empty($REAL_DATA['test_personal_access_token'])){
            throw new \coding_exception('You must insert the test base url and test private access token under global settings');
        }

        /**
         * Create the settings in the phpu_ table
         */
        set_config('environment', 'test', 'mod_diplomasafe'); // Should always run against the test API
        set_config('test_base_url', $REAL_DATA['test_base_url'], 'mod_diplomasafe');
        set_config('test_personal_access_token', $REAL_DATA['test_personal_access_token'], 'mod_diplomasafe');

        $this->config = new diplomasafe_config(get_config('mod_diplomasafe'));
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function can_push_item_to_queue() : void {

        $this->resetAfterTest();

        $queue = new queue($this->config);
        $queue->push(new queue_item([
            'course_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $pending_queue_items = $this->queue_repo->get_all(queue_item::QUEUE_ITEM_STATUS_PENDING);

        self::assertCount(1, $pending_queue_items);
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function can_delete_item_from_queue() : void {

        $this->resetAfterTest();

        $queue = new queue($this->config);
        $insert_id = $queue->push(new queue_item([
            'course_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $added_queue_item = $this->queue_repo->get_by_id($insert_id);
        $this->queue_mapper->delete($added_queue_item);

        $this->expectException(RuntimeException::class);
        $this->queue_repo->get_by_id($added_queue_item->id);
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function can_not_push_to_queue_if_duplicates() : void {

        $this->resetAfterTest();

        $queue = new queue($this->config);
        $queue->push(new queue_item([
            'course_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $queue->push(new queue_item([
            'course_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $pending_queue_items = $this->queue_repo->get_all(queue_item::QUEUE_ITEM_STATUS_PENDING);

        self::assertCount(1, $pending_queue_items);
    }
}
