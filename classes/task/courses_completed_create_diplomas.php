<?php
namespace mod_diplomasafe\task;

use coding_exception;
use core\task\scheduled_task;
use lang_string;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\entities\user_completion_course;
use mod_diplomasafe\factories\completion_factory;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\template_factory;

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
 * @package mod_diplomasafe\task
 */
class courses_completed_create_diplomas extends scheduled_task
{
    /**
     * @return lang_string|string
     * @throws coding_exception
     */
    public function get_name() {
        return get_string('cron_courses_completed_create_diplomas', 'mod_diplomasafe');
    }

    /**
     * @return void
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\invalid_argument_exception
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function execute() {
        $completion_repo = completion_factory::get_repository();
        $diploma_api_mapper = diploma_factory::get_api_mapper();

        foreach ($completion_repo->get_user_completion_status_courses() as $user_completion_course) {
            /** @var user_completion_course $user_completion_course */
            if ($user_completion_course->is_completed()) {

                // Todo: Change hardcoded template ID
                $template = template_factory::get_repository()
                    ->get_by_id(123);

                // Todo: Create diploma for the user in the course via the API
                $diploma_api_mapper->create(new diploma(
                        $template,
                        $user_completion_course->course_id,
                        $user_completion_course->user_id
                    )
                );
            }
        }
    }
}
