<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\client\diplomasafe_client;
use mod_diplomasafe\entities\diploma;

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
 * @package mod_diplomasafe\diplomas
 */
class mapper
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
     * @param diploma $diploma
     *
     * @return array
     */
    public function create(diploma $diploma) : array {
        // Todo: Issue the diploma here
        //return $this->client->post('/issue');
    }
}
