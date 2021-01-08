<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\client\diplomasafe_client;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\messenger;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

require_once $CFG->dirroot . '/user/lib.php';

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
     * @throws \coding_exception
     */
    public function create(diploma $diploma) : array {
        try {
            // Todo: Issue the diploma here
            //return $this->client->post('/diplomas');
        } catch (\Exception $e) {
            messenger::send_api_error_mail($diploma->course_id, $diploma->user_id, $e->getMessage());
            throw new \RuntimeException($e->getMessage());
        }
    }
}
