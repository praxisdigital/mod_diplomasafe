<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\tests\feature;

defined('MOODLE_INTERNAL') || die();

use curl;
use dml_exception;
use advanced_testcase;
use mod_diplomasafe\config;
use mod_diplomasafe\exceptions\base_url_not_set;
use mod_diplomasafe\exceptions\current_environment_invalid;
use mod_diplomasafe\exceptions\current_environment_not_set;
use mod_diplomasafe\exceptions\personal_access_token_not_set;

global $CFG;
require_once("$CFG->libdir/externallib.php");

/**
 * Class
 *
 * TESTS IN THIS CLASS IS DEPENDING OF REAL DATA FROM THE SETTINGS IN YOUR
 * REAL MOODLE TO BE ABLE TO CONNECT TO DIPLOMASAFE. PLEASE MAKE SURE YOU
 * HAVE ENTERED ALL DATA FOR THE TEST API.
 *
 * @testdox Testcase for the API features
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_feature_api_testcase extends advanced_testcase
{
    /**
     * @var curl
     */
    private $client;

    /**
     * @var config
     */
    private $config;

    /**
     * @return \moodle_database
     */
    private function get_db() : \moodle_database {
        global $DB;
        return $DB;
    }

    /**
     * @throws \coding_exception
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws dml_exception
     * @throws personal_access_token_not_set
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

        /**
         * Create the settings in the phpu_ table
         */
        set_config('environment', 'test', 'mod_diplomasafe'); // Should always run against the test API
        set_config('test_base_url', $REAL_DATA['test_base_url'], 'mod_diplomasafe');
        set_config('test_personal_access_token', $REAL_DATA['test_personal_access_token'], 'mod_diplomasafe');

        $this->config = new config(get_config('mod_diplomasafe'));

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
