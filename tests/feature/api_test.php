<?php

namespace mod_diplomasafe\tests\feature;

use curl;
use dml_exception;
use advanced_testcase;
use mod_diplomasafe\client\diplomasafe_client;
use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\client\exceptions\base_url_not_set;
use mod_diplomasafe\client\adapters\moodle_curl_request_adapter;
use mod_diplomasafe\client\exceptions\invalid_argument_exception;
use mod_diplomasafe\client\exceptions\current_environment_invalid;
use mod_diplomasafe\client\exceptions\current_environment_not_set;
use mod_diplomasafe\client\exceptions\personal_access_token_not_set;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once("$CFG->libdir/externallib.php");

/**
 *
 * TESTS IN THIS CLASS IS DEPENDING OF REAL DATA FROM THE SETTINGS IN YOUR REAL MOODLE TO BE ABLE TO CONNECT TO
 * DIPLOMASAFE. PLEASE MAKE SURE YOU HAVE ENTERED ALL DATA FOR THE TEST API
 *
 * Class mod_diplomasafe_api_testcase
 * @testdox Testcase for the API features
 */
class mod_diplomasafe_api_testcase extends advanced_testcase {

    /** @var diplomasafe_client */
    private $client;

    /**
     * @throws \coding_exception
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws dml_exception
     * @throws invalid_argument_exception
     * @throws personal_access_token_not_set
     */
    public function setUp(): void{

        global $DB;

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

        $config = new diplomasafe_config(get_config('mod_diplomasafe'));

        $this->client = new diplomasafe_client(new moodle_curl_request_adapter(new curl()));
        $this->client->set_base_url($config->get_base_url());
        $this->client->set_headers([
            "Authorization: Bearer ".$config->get_private_token(),
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8'
        ]);
    }

    /**
     * @test
     */
    public function it_fetches_all_templates_for_organization(): void {
        $this->resetAfterTest();

        $content = $this->client->get('/templates');
        $info = $this->client->get_info();

        self::assertSame('200 OK', reset($info));
        self::assertArrayHasKey('pagination', $content);
    }
}
