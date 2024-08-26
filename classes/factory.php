<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 * @package     mod_diplomasafe
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_diplomasafe;

use mod_diplomasafe\config;
use mod_diplomasafe\exceptions\base_url_not_set;
use mod_diplomasafe\exceptions\current_environment_invalid;
use mod_diplomasafe\exceptions\current_environment_not_set;
use mod_diplomasafe\exceptions\personal_access_token_not_set;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once $CFG->libdir . '/filelib.php';

/**
 * Class
 * @package mod_diplomasafe
 */
abstract class factory
{
    /**
     * @return \moodle_database|null
     */
    public static function get_db(): \moodle_database
    {
        global $DB;
        return $DB;
    }

    /**
     * @param config|null $config
     * @return \curl
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public static function get_api_client(
        ?config $config = null
    ): \curl {
        $config ??= self::get_config();

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
    public static function get_config(): config
    {
        return new config(get_config('mod_diplomasafe'));
    }
}
