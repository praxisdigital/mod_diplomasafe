<?php
namespace mod_diplomasafe\diplomas\api;

use core\message\message;
use mod_diplomasafe\client\diplomasafe_client;
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
            $course_context = \context_course::instance($diploma->course_id);
            if (has_capability('mod/diplomasafe:receive_api_error_mail', $course_context, null, false)) {
                $receiver = array_values(user_get_users_by_id($diploma->user_id))[0];
                $message = new message('api_error');
                $message->component = 'mod_diplomasafe';
                $message->name = 'api_error';
                $message->userfrom = \core_user::get_noreply_user();
                $message->userto = $receiver;
                $message->subject = get_string('message_api_error_subject', 'mod_diplomasafe');
                $message->fullmessage = get_string('message_api_error_body', 'mod_diplomasafe', $e->getMessage());
                $message->fullmessageformat = FORMAT_MARKDOWN;
                $message->fullmessagehtml = $message->fullmessage;
                message_send($message);
            }
            throw new \RuntimeException($e->getMessage());
        }
    }
}
