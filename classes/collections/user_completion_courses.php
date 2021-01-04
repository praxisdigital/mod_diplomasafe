<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;
use mod_diplomasafe\entities\user_completion_course;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\collections
 */
class user_completion_courses extends collection
{
    /**
     * An array to hold the course completion state for users
     *
     * @var array
     */
    private $completion_course_users = [];

    /**
     * An array to hold the course completion state for users (flat structure)
     *
     * @var array
     */
    private $completion_course_users_flatten = [];

    /**
     * Constructor
     *
     * @throws \coding_exception
     */
    public function __construct() {
        $this->preload_all_completion();
        $this->set($this->completion_course_users_flatten);
    }

    /**
     * @throws \coding_exception
     */
    private function preload_all_completion() : void {
        $course_ids = array_keys(get_courses('', '', 'c.id, c.visible'));
        foreach ($course_ids as $course_id) {
            if ((int)$course_id === 1) {
                continue;
            }
            $this->preload_course_completion($course_id);
        }
    }

    /**
     * Preload the completion data for the course and structure it
     *
     * @param int $course_id The course where the completion data should be loaded
     *
     * @throws \coding_exception
     */
    private function preload_course_completion(int $course_id) : void {
        $course_context = \context_course::instance($course_id);
        $enrolled_users = get_enrolled_users($course_context);

        foreach ($enrolled_users as $enrolled_user) {
            $completed = null;

            if (!$course_id) {
                continue;
            }

            if (!$enrolled_user->id) {
                continue;
            }

            $is_student = !has_capability('moodle/course:viewhiddensections', $course_context, $enrolled_user->id);
            if (!$is_student) {
                continue;
            }

            try {
                $course_completion_user = \core_completion_external::get_course_completion_status(
                    $course_id,
                    $enrolled_user->id
                );

                $completed = 0;

                if (isset($course_completion_user['completionstatus']['completed'])
                    && $course_completion_user['completionstatus']['completed']) {
                    $completed = 1;
                }

                $completion_data = new user_completion_course([
                    'course_id' => $course_id,
                    'user_id' => $enrolled_user->id,
                    'completion_fetched' => true,
                    'completed' => (bool)$completed,
                    'error_message' => ''
                ]);

                $this->completion_course_users[$course_id][$enrolled_user->id] = $completion_data;
                $this->completion_course_users_flatten[$course_id . '-' . $enrolled_user->id] = $completion_data;
            } catch (\Exception $e) {
                $completion_data = new user_completion_course([
                    'course_id' => $course_id,
                    'user_id' => $enrolled_user->id,
                    'completion_fetched' => false,
                    'completed' => false,
                    'error_message' => $e->getMessage()
                ]);

                $this->completion_course_users[$course_id][$enrolled_user->id] = $completion_data;
                $this->completion_course_users_flatten[$course_id . '-' . $enrolled_user->id] = $completion_data;
            }
        }

        if (!empty($this->completion_course_users_flatten)) {
            $this->completion_course_users_flatten = array_values($this->completion_course_users_flatten);
        }
    }

    /**
     * Get the course completion
     *
     * @param bool $flatten
     *
     * @return array        The course completion data for the users
     */
    public function get_course_completion(bool $flatten = true) : array {
        $course_completion = $this->completion_course_users;
        if ($flatten) {
            $course_completion = $this->completion_course_users_flatten;
        }
        return $course_completion;
    }

    /**
     * Check if a user has a completion state in a course
     *
     * @param int $course_id
     * @param int $user_id
     *
     * @return  bool    $status     Returns true if the user has a completion state in the course, false otherwise
     */
    public function user_has_completion_state_in_course(int $course_id, int $user_id) : bool
    {
        $has_completion_state = false;

        if (isset($this->completion_course_users[$course_id][$user_id]['completion_fetched'])
            && (int)$this->completion_course_users[$course_id][$user_id]['completion_fetched'] === 1) {
            $has_completion_state = true;
        }

        return $has_completion_state;
    }
}
