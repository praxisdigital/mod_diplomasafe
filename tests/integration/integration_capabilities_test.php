<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\admin_task_mailer;

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_integration_capabilities_testcase extends advanced_testcase
{
    /**
     * @param $receiver_role
     *
     * @return array $courses
     */
    private function enrol_test_users_with_role($receiver_role) : array {

        $data_generator = $this->getDataGenerator();

        $course1 = $data_generator->create_course();
        $user1 = $data_generator->create_user();
        $user2 = $data_generator->create_user();
        $user3 = $data_generator->create_user();

        // Enrol three users into the first course
        $data_generator->enrol_user($user1->id, $course1->id, $receiver_role);
        $data_generator->enrol_user($user2->id, $course1->id, $receiver_role);
        $data_generator->enrol_user($user3->id, $course1->id, $receiver_role);

        $course2 = $data_generator->create_course();

        // Enrol one user into the second course
        $data_generator->enrol_user($user3->id, $course2->id, $receiver_role);

        return [
            1 => $course1,
            2 => $course2
        ];
    }

    /**
     * @test
     */
    public function admin_mail_receivers_correct() : void {

        $this->resetAfterTest();

        $courses = $this->enrol_test_users_with_role('editingteacher');

        // We expect 3 recipients to be found in the first course
        $admin_task_mailer = new admin_task_mailer($courses[1]->id);
        $recipients_to_receive_mail = $admin_task_mailer->load_recipients_with_course_capability('mod/diplomasafe:receive_api_error_mail');
        self::assertCount(3, $recipients_to_receive_mail);

        // We expect 1 recipients to be found in the second course
        $admin_task_mailer = new admin_task_mailer($courses[2]->id);
        $recipients_to_receive_mail = $admin_task_mailer->load_recipients_with_course_capability('mod/diplomasafe:receive_api_error_mail');
        self::assertCount(1, $recipients_to_receive_mail);
    }

    /**
     * @test
     */
    public function admin_mail_receivers_not_students() : void {

        $this->resetAfterTest();

        $courses = $this->enrol_test_users_with_role('student');

        // We expect 0 recipients to be found in the first course since students should not receive admin mails
        $admin_task_mailer = new admin_task_mailer($courses[1]->id);
        $recipients_to_receive_mail = $admin_task_mailer->load_recipients_with_course_capability('mod/diplomasafe:receive_api_error_mail');
        self::assertCount(0, $recipients_to_receive_mail);

        // We expect 0 recipients to be found in the second course since students should not receive admin mails
        $admin_task_mailer = new admin_task_mailer($courses[2]->id);
        $recipients_to_receive_mail = $admin_task_mailer->load_recipients_with_course_capability('mod/diplomasafe:receive_api_error_mail');
        self::assertCount(0, $recipients_to_receive_mail);
    }
}
