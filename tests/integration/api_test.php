<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\client\exceptions\base_url_not_set;
use mod_diplomasafe\client\exceptions\current_environment_invalid;
use mod_diplomasafe\client\exceptions\current_environment_not_set;
use mod_diplomasafe\client\exceptions\personal_access_token_not_set;
use mod_diplomasafe\cron_tasks;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\template_factory;

defined('MOODLE_INTERNAL') || die();

class api_testcase extends advanced_testcase
{
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
     * Issuing a diploma requires at least one template is
     * synced. Therefore we need to sync the templates and
     * use the first valid template to issue the diploma
     * in the same test.
     *
     * @test
     */
    public function can_sync_templates_and_issue_diploma(): void {

        $this->resetAfterTest();

        cron_tasks::create_templates(false);

        $template_repo = template_factory::get_repository();
        $template = $template_repo->get_first_valid();

        self::assertTrue($template->is_valid());

        $diploma_fields_repo = diploma_factory::get_fields_repository();
        $diploma_field_ids = $diploma_fields_repo->get_field_ids();

        $diploma_fields = [];
        foreach ($diploma_field_ids as $diploma_field_id) {
            $diploma_fields[$diploma_field_id] = '';
        }

        $payload = (object)[
            'template_id' => $template->idnumber,
            'organization_id' => $template->organisation_id,
            'diplomas' => [
                (object)[
                    'recipient_email' => 'test@email.com',
                    'recipient_name' => 'Test user',
                    'language_code' => 'en-US',
                    'issue_date' => date('Y-m-d'),
                    'diploma_fields' => $diploma_fields
                ]
            ]
        ];

        $content = json_decode($this->client->post($this->config->get_base_url() . '/diplomas', json_encode($payload)), true);

        $info = $this->client->get_info();

        self::assertSame(200, (int)$info['http_code']);
        self::assertSame(1, (int)$content['countIssued']);
    }
}
