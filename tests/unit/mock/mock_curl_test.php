<?php

namespace mod_diplomasafe\unit\mock;

use mod_diplomasafe\tests\api\mock_curl;
use mod_diplomasafe\tests\unit_testcase;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class mock_curl_test extends unit_testcase
{
    public function test_send_with_match_url_and_no_parameter_returns_ok(): void
    {
        $url = 'https://diplomasafe.localhost';
        $params = null;
        $status = 200;
        $body = '{"message": "ok"}';

        $curl = new mock_curl();
        $curl->add_incoming_request(
            $url,
            $params,
            $body,
            $status
        );

        $actual_body = $curl->send('https://diplomasafe.localhost');

        self::assertEquals($body, $actual_body);

        $info = $curl->get_info();

        self::assertEquals($status, $info['http_code']);
    }

    public function test_send_with_match_url_and_parameters_returns_ok(): void
    {
        $url = 'https://diplomasafe.localhost';
        $params = [
            'id' => 1,
        ];
        $status = 200;
        $body = '{"message": "ok"}';

        $curl = new mock_curl();
        $curl->add_incoming_request(
            $url,
            $params,
            $body,
            $status
        );

        $actual_body = $curl->send('https://diplomasafe.localhost', $params);

        self::assertEquals($body, $actual_body);

        $info = $curl->get_info();

        self::assertEquals($status, $info['http_code']);
    }

    public function test_send_with_match_url_but_not_match_parameter_returns_bad_request(): void
    {
        $url = 'https://diplomasafe.localhost';
        $params = [
            'id' => 1,
        ];
        $status = 200;
        $body = '{"message": "ok"}';

        $curl = new mock_curl();
        $curl->add_incoming_request(
            $url,
            $params,
            $body,
            $status
        );

        $actual_body = $curl->send('https://diplomasafe.localhost', [
            'unknown' => 'test'
        ]);

        self::assertNotEquals($body, $actual_body);
        self::assertEmpty($actual_body);

        $info = $curl->get_info();

        self::assertNotEquals($status, $info['http_code']);
        self::assertEquals(400, $info['http_code']);
    }
}
