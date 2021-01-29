<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\config;
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
     * @var config
     */
    private $config;

    /**
     * @return void
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
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

        $this->config = new config(get_config('mod_diplomasafe'));
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
            'module_instance_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $pending_queue_items = $this->queue_repo->get_all([queue_item::QUEUE_ITEM_STATUS_PENDING]);

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
            'module_instance_id' => 7,
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
            'module_instance_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $queue->push(new queue_item([
            'module_instance_id' => 7,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => time()
        ]));

        $pending_queue_items = $this->queue_repo->get_all([queue_item::QUEUE_ITEM_STATUS_PENDING]);

        self::assertCount(1, $pending_queue_items);
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function correct_number_of_expired_items_fetched() : void {

        $this->resetAfterTest();

        $queue = new queue($this->config);

        // Set limit to 30 days
        set_config('delete_from_queue_after_days', 30, 'mod_diplomasafe');

        $queue->push(new queue_item([
            'module_instance_id' => 1,
            'user_id' => 2,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => (new DateTime())->sub(new DateInterval('P2M'))->getTimestamp()
        ]));

        $queue->push(new queue_item([
            'module_instance_id' => 3,
            'user_id' => 4,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => (new DateTime())->sub(new DateInterval('P15D'))->getTimestamp()
        ]));

        $queue->push(new queue_item([
            'module_instance_id' => 5,
            'user_id' => 6,
            'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'time_modified' => (new DateTime())->sub(new DateInterval('P1D'))->getTimestamp()
        ]));

        // We expect the first item to be expired
        $queue_repo = queue_factory::get_queue_repository();
        self::assertCount(1, $queue_repo->get_expired_items());

        // Set limit to 0 days (which means do not delete items from the queue)
        set_config('delete_from_queue_after_days', 0, 'mod_diplomasafe');
        $queue_repo = queue_factory::get_queue_repository();

        // We expect no items to be expired
        self::assertCount(0, $queue_repo->get_expired_items());
    }
}
