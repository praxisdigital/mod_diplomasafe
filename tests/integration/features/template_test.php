<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\integration\features;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();
// @codeCoverageIgnoreEnd

use mod_diplomasafe\tests\api\mock_curl;
use mod_diplomasafe\tests\integration_testcase;


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
class template_test extends integration_testcase
{
    private mock_curl $client;

    protected function setUp() : void {
        parent::setUp();
        $this->client = $this->curl();
    }

    /**
     * @test
     */
    public function can_fetch_templates(): void {
        $response = [
            'pagination' => 2
        ];

        $this->client->add_incoming_request(
            $this->get_base_url() . '/templates',
            null,
            json_encode($response),
            200
        );

        $content = json_decode($this->client->get($this->get_base_url() . '/templates'), true);
        $info = $this->client->get_info();

        self::assertEquals(200, $info['http_code']);
        self::assertArrayHasKey('pagination', $content);
    }
}
