<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\integration;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

use mod_diplomasafe\cron_tasks;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\tests\api\mock_curl;
use mod_diplomasafe\tests\integration_testcase;

/**
 * Class
 * TESTS IN THIS CLASS IS DEPENDING OF REAL DATA FROM THE SETTINGS IN YOUR
 * REAL MOODLE TO BE ABLE TO CONNECT TO DIPLOMASAFE. PLEASE MAKE SURE YOU
 * HAVE ENTERED ALL DATA FOR THE TEST API.
 * @testdox Testcase for the API features
 * @package mod_diplomasafe\tests
 */
class api_test extends integration_testcase
{
    private mock_curl $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->curl();
    }

    /**
     * Issuing a diploma requires at least one template is
     * synced. Therefore, we need to sync the templates and
     * use the first valid template to issue the diploma
     * in the same test.
     * @test
     */
    public function can_sync_templates_and_issue_diploma(): void
    {
        /**
         * 'idnumber' => "test-template"
         * 'organization_id' => "1234"
         * 'default_language' => "da-DK"
         * 'diploma_fields' => []
         * 'extra_name' => "Test template"
         */

        $template_data = [
            "pagination" => [
                "total" => 1,
                "per_page" => 50,
                "current_page" => 1,
                "last_page" => 1,
                "first_page_url" => "https://localhost/api/v1/templates?page=1&limit=50",
                "last_page_url" => "https://localhost/api/v1/templates?page=1&limit=50",
                "next_page_url" => null,
                "prev_page_url" => null,
                "path" => "https://localhost/api/v1/templates",
                "from" => 1,
                "to" => 1
            ],
            'templates' => [
                [
                    'id' => '1',
                    'idnumber' => 'test-template',
                    'organization_id' => '1234',
                    'default_language' => 'da-DK',
                    'diploma_fields' => [],
                    'name' => [
                        'da-DK' => 'Test skabelon',
                        'en-US' => 'Test template',
                    ],
                    'extra_name' => [
                        'da-DK' => 'Test ekstra skabelon',
                        'en-US' => 'Test extra template',
                    ],
                    'description' => [
                        'da-DK' => null,
                        'en-US' => null,
                    ],
                    'description_short' => [
                        'da-DK' => null,
                        'en-US' => null,
                    ]
                ]
            ],
        ];

        $template_data = $this->get_example_templates();

        $this->client->add_incoming_request(
            $this->get_base_url() . '/templates',
            null,
            json_encode($template_data),
            200
        );

        $response = [
            'countIssued' => 1
        ];

        $this->client->add_incoming_request(
            $this->get_base_url() . '/diplomas',
            null,
            json_encode($response),
            200
        );

        cron_tasks::create_templates(
            false,
            $this->config,
            $this->client
        );

        $template_repo = template_factory::get_repository();
        $template = $template_repo->get_first_valid();

        self::assertTrue($template->is_valid());

        $diploma_fields_repo = diploma_factory::get_fields_repository(
            $this->config
        );
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

        $content = json_decode(
            $this->client->post($this->config->get_base_url() . '/diplomas', json_encode($payload)),
            true
        );

        $info = $this->client->get_info();

        self::assertSame(200, (int)$info['http_code']);
        self::assertSame(1, (int)$content['countIssued']);
    }
}
