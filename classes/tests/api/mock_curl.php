<?php

namespace mod_diplomasafe\tests\api;

use curl;
use Exception;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class mock_curl extends curl
{
    private int $current_case = -1;
    private array $cases = [];
    private array $case_info = [];

    public function __construct()
    {
        parent::__construct([]);
    }

    public function add_incoming_request(
        string $url,
        mixed $params = null,
        mixed $response = null,
        int $status = 200
    ): void {
        $this->cases[] = [
            'url' => $url,
            'params' => $params,
            'status' => $status,
            'response' => $response
        ];
    }

    public function get(
        mixed $url,
        mixed $params = [],
        array $options = []
    ): mixed {
        $data = (array)$params;
        try {
            $query_data = [];
            $query = parse_url($url, PHP_URL_QUERY);
            if (!empty($query)) {
                parse_str($query, $query_data);
            }

            if (!empty($query_data)) {
                $data = $query_data + $data;
            }
        } catch (Exception) {
            // Do nothing
        }
        return $this->send(
            $url,
            $data
        );
    }

    public function post(mixed $url, mixed $params = '', array $options = []): mixed
    {
        return $this->send(
            $url,
            $params
        );
    }

    public function send(
        string $url,
        mixed $data = null
    ): string {
        $match_url = false;

        foreach ($this->cases as $index => $case) {
            if ($case['url'] !== $url) {
                continue;
            }

            $match_url = true;
            $this->current_case = $index;

            if (!empty($case['params'])
                && !empty(array_diff($case['params'], (array)$data))) {
                $this->case_info[$index] = [
                    'http_code' => 400,
                ];

                continue;
            }

            $this->case_info[$index] = [
                'referer' => $url,
                'http_code' => $case['status'],
            ];

            return $case['response'] ?? '';
        }

        if (!isset($this->case_info[$this->current_case])) {
            $this->case_info[$this->current_case] = [];
        }

        $this->case_info[$this->current_case]['referer'] = $url;
        $this->case_info[$this->current_case]['http_code'] ??= 500;

        if (!$match_url) {
            $this->case_info[$this->current_case]['http_code'] ??= 404;
        }

        return '';
    }

    public function get_info(): array
    {
        $info = $this->case_info[$this->current_case] ?? [
            'http_code' => 0,
        ];
        if ($this->current_case === -1) {
            $this->case_info[$this->current_case] = [];
        }
        return $info;
    }
}
