<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Class
 */
class integration_queue_testcase extends advanced_testcase
{
    /**
     * @test
     */
    public function can_add_queue_item() {
        $this->resetAfterTest();

    }

    /**
     * @test
     */
    public function can_delete_queue_item() {
        $this->resetAfterTest();

    }

    /**
     * @test
     */
    public function can_not_add_if_existing_queue_item() {
        $this->resetAfterTest();

    }
}
