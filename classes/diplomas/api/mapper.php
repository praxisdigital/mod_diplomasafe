<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\admin_task_mailer;
use mod_diplomasafe\entities\diploma;

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
     * @var \curl
     */
    private $client;

    /**
     * Constructor
     *
     * @param \curl $client
     */
    public function __construct(\curl $client) {
        $this->client = $client;
    }

    /**
     * @param diploma $diploma
     *
     * @return array
     * @throws \coding_exception
     */
    public function create(diploma $diploma) : array {
        $admin_task_mailer = new admin_task_mailer();
        try {
            // Todo: Issue the diploma here
            //return $this->client->post('/diplomas');
        } catch (\Exception $e) {
            $admin_task_mailer->send_to_all($e->getMessage());
            throw new \RuntimeException($e->getMessage());
        }
    }
}
