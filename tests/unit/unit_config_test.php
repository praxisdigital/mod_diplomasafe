<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

use mod_diplomasafe\config;
use mod_diplomasafe\exceptions\base_url_not_set;
use mod_diplomasafe\exceptions\current_environment_invalid;
use mod_diplomasafe\exceptions\current_environment_not_set;
use mod_diplomasafe\exceptions\personal_access_token_not_set;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_unit_config_testcase extends advanced_testcase
{
    /**
     * @var object
     */
    private $required_config_data;

    /**
     * @void
     */
    public function setUp() : void {
        $this->required_config_data = (object)[
            // Default data to allow test
            'environment' => 'test',
            'test_base_url' => 'https://demo-api.diplomasafe.net/api/v1',
            'test_personal_access_token' => 'dummy_token'
        ];
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_check_if_test_environment() : void {

        $this->resetAfterTest();

        $this->required_config_data->is_test_environment = 1;
        $config = new config($this->required_config_data);

        self::assertEquals(1, $config->is_test_environment());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_environment() : void {

        $this->resetAfterTest();

        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->environment, $config->get_environment());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_api_timeout() : void {

        $this->resetAfterTest();

        $this->required_config_data->api_timeout = 10;
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->api_timeout, $config->get_timeout());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_base_url() : void {

        $this->resetAfterTest();

        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->test_base_url, $config->get_base_url());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_private_token() : void {

        $this->resetAfterTest();

        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->test_personal_access_token, $config->get_private_token());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_duration_custom_field_code() : void {

        $this->resetAfterTest();

        $this->required_config_data->moodle_duration_field = 'custom_field_a';
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->moodle_duration_field, $config->get_duration_custom_field_code());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_location_custom_field_code() : void {

        $this->resetAfterTest();

        $this->required_config_data->moodle_location_field = 'custom_field_b';
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->moodle_location_field, $config->get_location_custom_field_code());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_item_count_per_page() : void {

        $this->resetAfterTest();

        $this->required_config_data->item_count_per_page = 20;
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->item_count_per_page, $config->get_item_count_per_page());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_queue_amount_to_process() : void {

        $this->resetAfterTest();

        $this->required_config_data->queue_amount_to_process = 20;
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->queue_amount_to_process, $config->get_queue_amount_to_process());
    }
}
