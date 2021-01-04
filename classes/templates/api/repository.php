<?php
namespace mod_diplomasafe\templates\api;

use mod_diplomasafe\client\diplomasafe_client;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates
 */
class repository
{
    /**
     * @var diplomasafe_client
     */
    private $client;

    /**
     * Constructor
     *
     * @param diplomasafe_client $client
     */
    public function __construct(diplomasafe_client $client) {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function get_all() {
        return $this->client->get('/templates');
    }
}
