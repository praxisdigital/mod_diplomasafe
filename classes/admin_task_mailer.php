<?php
/**
 * @developer   Johnny Drud
 * @date        08-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use core\message\message;

defined('MOODLE_INTERNAL') || die();

require_once $CFG->dirroot . '/user/lib.php';

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class admin_task_mailer
{
    /**
     * @var array
     */
    private $recipients = [];

    /**
     * @param string $capability
     *
     * @return array
     */
    public function load_recipients_with_course_capability($capability = 'mod/diplomasafe:receive_api_error_mail') : array {
        $mail_recipient_user_ids = [];
        $courses = get_courses();
        foreach ($courses as $course) {
            if ((int)$course->id === 1) {
                continue;
            }
            $course_context = \context_course::instance($course->id);
            $enrolled_users = get_enrolled_users($course_context, $capability);
            foreach ($enrolled_users as $enrolled_user) {
                $mail_recipient_user_ids[$enrolled_user->id] = $enrolled_user->id;
            }
        }
        return user_get_users_by_id(array_values($mail_recipient_user_ids)) ?? [];
    }

    /**
     * @param string $error_message
     *
     * @throws \coding_exception
     */
    public function send_to_all(string $error_message) : void {
        if (!$this->recipients_exists()) {
            $this->recipients = $this->load_recipients_with_course_capability();
        }
        foreach ($this->recipients as $recipient) {
            $this->send_to_one($recipient, $error_message);
        }
    }

    /**
     * @param object $recipient
     * @param string $error_message
     *
     * @throws \coding_exception
     */
    public function send_to_one(object $recipient, string $error_message) : void {
        $message = new message('api_error');
        $message->component = 'mod_diplomasafe';
        $message->name = 'api_error';
        $message->userfrom = \core_user::get_noreply_user();
        $message->userto = $recipient;
        $message->subject = get_string('message_api_error_subject', 'mod_diplomasafe');
        $message->fullmessage = get_string('message_api_error_body', 'mod_diplomasafe', $error_message);
        $message->fullmessageformat = FORMAT_MARKDOWN;
        $message->fullmessagehtml = $message->fullmessage;
        message_send($message);
    }

    /**
     * @return bool
     */
    private function recipients_exists() : bool {
        return !empty($this->recipients);
    }
}
