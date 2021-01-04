<?php
namespace mod_diplomasafe;

use mod_diplomasafe\client\adapters\moodle_curl_request_adapter;
use mod_diplomasafe\client\diplomasafe_client;
use mod_diplomasafe\client\diplomasafe_config;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

abstract class factory {
    /**
     * @return \moodle_database|null
     */
    public static function get_db(): \moodle_database {
        global $DB;
        return $DB;
    }

    /**
     * @return diplomasafe_client
     * @throws \dml_exception
     * @throws client\exceptions\base_url_not_set
     * @throws client\exceptions\current_environment_invalid
     * @throws client\exceptions\current_environment_not_set
     * @throws client\exceptions\invalid_argument_exception
     * @throws client\exceptions\personal_access_token_not_set
     */
    public static function get_api_client() : diplomasafe_client {

        $config = new diplomasafe_config(get_config('mod_diplomasafe'));

        $api_client = new diplomasafe_client(new moodle_curl_request_adapter(new \curl()));
        $api_client->set_base_url($config->get_base_url());
        $api_client->set_headers([
            "Authorization: Bearer " . $config->get_private_token(),
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8'
        ]);

        return $api_client;
    }
}
