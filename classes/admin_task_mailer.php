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
     * @var int
     */
    private $course_id;

    /**
     * Constructor
     *
     * @param int|null $course_id
     */
    public function __construct(int $course_id = null) {
        $this->course_id = $course_id;
    }

    /**
     * @var array
     */
    private $recipients = [];

    /**
     * @param string $capability
     *
     * @return array
     */
    public function load_recipients_with_course_capability(string $capability) : array {
        if (!empty($this->course_id)) {
            $mail_recipient_user_ids = $this->get_recipients_in_course($this->course_id, $capability);
            return $this->get_users_by_id($mail_recipient_user_ids);
        }
        $courses = get_courses();
        $mail_recipient_user_ids = [];
        foreach ($courses as $course) {
            if ((int)$course->id === 1) {
                continue;
            }
            $mail_recipient_user_ids = $this->get_recipients_in_course($course->id, $capability);
        }
        return $this->get_users_by_id($mail_recipient_user_ids);
    }

    /**
     * @param array $user_ids
     *
     * @return array
     */
    private function get_users_by_id(array $user_ids) : array {
        return user_get_users_by_id(array_values($user_ids)) ?? [];
    }

    /**
     * @param int $course_id
     * @param string $capability
     *
     * @return array
     */
    private function get_recipients_in_course(int $course_id, string $capability) : array {
        $course_context = \context_course::instance($course_id);
        $enrolled_users = get_enrolled_users($course_context, $capability);
        $mail_recipient_user_ids = [];
        foreach ($enrolled_users as $enrolled_user) {
            $mail_recipient_user_ids[$enrolled_user->id] = $enrolled_user->id;
        }
        return $mail_recipient_user_ids;
    }

    /**
     * @param string $error_message
     *
     * @throws \coding_exception
     */
    public function send_to_all(string $error_message) : void {
        if (!$this->recipients_exists()) {
            $this->recipients = $this->load_recipients_with_course_capability('mod/diplomasafe:receive_api_error_mail');
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
