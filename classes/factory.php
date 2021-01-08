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

require_once $CFG->libdir . '/filelib.php';

/**
 * Class
 *
 * @package mod_diplomasafe
 */
abstract class factory {
    /**
     * @return \moodle_database|null
     */
    public static function get_db(): \moodle_database {
        global $DB;
        return $DB;
    }

    /**
     * @return \curl
     * @throws \dml_exception
     * @throws client\exceptions\base_url_not_set
     * @throws client\exceptions\current_environment_invalid
     * @throws client\exceptions\current_environment_not_set
     * @throws client\exceptions\personal_access_token_not_set
     */
    public static function get_api_client() : \curl {

        $config = new diplomasafe_config(get_config('mod_diplomasafe'));

        $curl = new \curl();
        $curl->setHeader([
            'Authorization: Bearer ' . $config->get_private_token(),
            'Content-type: application/json',
            'Accept: application/json',
            'Expect:'
        ]);

        return $curl;
    }
}
