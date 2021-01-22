<?php

namespace mod_diplomasafe\tests\feature;

use curl;
use dml_exception;
use advanced_testcase;
use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\client\exceptions\base_url_not_set;
use mod_diplomasafe\client\exceptions\current_environment_invalid;
use mod_diplomasafe\client\exceptions\current_environment_not_set;
use mod_diplomasafe\client\exceptions\personal_access_token_not_set;
use mod_diplomasafe\cron_tasks;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\template_factory;

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

    /**
     * @var curl
     */
    private $client;

    /**
     * @var diplomasafe_config
     */
    private $config;

    /**
     * @throws \coding_exception
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws dml_exception
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

        $this->config = new diplomasafe_config(get_config('mod_diplomasafe'));

        $this->client = new curl();
        $this->client->setHeader([
            'Authorization: Bearer ' . $this->config->get_private_token(),
            'Content-type: application/json',
            'Accept: application/json',
        ]);

        $this->client->setopt([
            'CURLOPT_TIMEOUT' => $this->config->get_timeout(),
            'CURLOPT_CONNECTTIMEOUT' => $this->config->get_timeout()
        ]);
    }

    /**
     * @test
     */
    public function can_fetch_templates(): void {

        $this->resetAfterTest();

        $content = json_decode($this->client->get($this->config->get_base_url() . '/templates'), true);
        $info = $this->client->get_info();

        self::assertSame(200, (int)$info['http_code']);
        self::assertArrayHasKey('pagination', $content);
    }
}
