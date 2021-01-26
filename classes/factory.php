<?php
namespace mod_diplomasafe;

use mod_diplomasafe\config;

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
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_api_client() : \curl {

        $config = self::get_config();

        $curl = new \curl();
        $curl->setHeader([
            'Authorization: Bearer ' . $config->get_private_token(),
            'Content-type: application/json',
            'Accept: application/json',
        ]);

        $curl->setopt([
            'CURLOPT_TIMEOUT' => $config->get_timeout(),
            'CURLOPT_CONNECTTIMEOUT' => $config->get_timeout()
        ]);

        return $curl;
    }

    /**
     * @return config
     * @throws \dml_exception
     * @throws exceptions\base_url_not_set
     * @throws exceptions\current_environment_invalid
     * @throws exceptions\current_environment_not_set
     * @throws exceptions\personal_access_token_not_set
     */
    public static function get_config() : config {
        return new config(get_config('mod_diplomasafe'));
    }
}
