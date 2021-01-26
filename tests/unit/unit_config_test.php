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
     * @return \moodle_database
     */
    private function get_db() : \moodle_database {
        global $DB;
        return $DB;
    }

    /**
     * @void
     */
    public function setUp() : void {

        $db = $this->get_db();

        // THIS SQL NEEDS THE mdl_ PREFIX - DO NOT REMOVE
        $REAL_DATA = $db->get_records_sql_menu(
        /** @lang mysql */ 'SELECT name, value FROM mdl_config_plugins WHERE `plugin` = "mod_diplomasafe"'
        );

        if(empty($REAL_DATA['test_base_url']) || empty($REAL_DATA['test_personal_access_token'])){
            throw new \coding_exception('You must insert the test base url and test private access token under global settings');
        }

        $environment = 'test';

        /**
         * Create the settings in the phpu_ table
         */
        set_config('environment', $environment, 'mod_diplomasafe'); // Should always run against the test API
        set_config('test_base_url', $REAL_DATA['test_base_url'], 'mod_diplomasafe');
        set_config('test_personal_access_token', $REAL_DATA['test_personal_access_token'], 'mod_diplomasafe');

        $this->required_config_data = (object)[
            'environment' => $environment,
            'test_base_url' => $REAL_DATA['test_base_url'],
            'test_personal_access_token' => $REAL_DATA['test_personal_access_token']
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
    public function can_get_queue_amount_to_process() : void {

        $this->resetAfterTest();

        $this->required_config_data->queue_amount_to_process = 20;
        $config = new config($this->required_config_data);

        self::assertEquals($this->required_config_data->queue_amount_to_process, $config->get_queue_amount_to_process());
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_available_language_ids_as_array() : void {

        $this->resetAfterTest();

        $this->required_config_data->available_language_ids = '1,2';
        $config = new config($this->required_config_data);

        self::assertEquals(explode(
            ',', $this->required_config_data->available_language_ids
            ),
            $config->get_available_language_ids()
        );
    }

    /**
     * @test
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function can_get_available_template_ids_as_array() : void {

        $this->resetAfterTest();

        $this->required_config_data->available_template_ids = '1,2';
        $config = new config($this->required_config_data);

        self::assertEquals(explode(
            ',', $this->required_config_data->available_template_ids
        ),
            $config->get_available_template_ids()
        );
    }
}
