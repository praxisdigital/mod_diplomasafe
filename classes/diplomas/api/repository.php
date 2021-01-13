<?php
/**
 * @developer   Johnny Drud
 * @date        12-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\client\diplomasafe_config;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\diplomas\api
 */
class repository
{
    /**
     * @var \curl
     */
    private $client;

    /**
     * @var diplomasafe_config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \curl $client
     */
    public function __construct(\curl $client, diplomasafe_config $config) {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @return array
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function get_one() : array {

        // Todo: Change the hardcoded diploma ID

        // The ID of an existing diploma
        $diploma_id = 'da83a7249d47673da4924037cc9d7ea70dde44f19';
        return json_decode($this->client->get($this->config->get_base_url() . '/diplomas/' . $diploma_id), true);
    }
}
