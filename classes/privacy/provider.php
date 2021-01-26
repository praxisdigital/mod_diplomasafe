<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\core_user_data_provider;
use core_privacy\local\request\core_userlist_provider;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;
use mod_diplomasafe\factories\queue_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\privacy
 */
class provider implements
    \core_privacy\local\metadata\provider,
    core_user_data_provider,
    core_userlist_provider
{
    /**
     * @param collection $collection
     *
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'diplomasafe_queue',[
                'course_id' => 'privacy:metadata:mod_diplomasafe:course_id',
                'user_id' => 'privacy:metadata:mod_diplomasafe:user_id',
                'status' => 'privacy:metadata:mod_diplomasafe:status',
                'message' => 'privacy:metadata:mod_diplomasafe:message',
                'time_created' => 'privacy:metadata:mod_diplomasafe:time_created',
                'time_modified' => 'privacy:metadata:mod_diplomasafe:time_modified',
                'last_run' => 'privacy:metadata:mod_diplomasafe:last_run',
                'last_mail_sent' => 'privacy:metadata:mod_diplomasafe:last_mail_sent',
            ],
            'privacy:metadata:diplomasafe_queue'
        );
        return $collection;
    }

    /**
     * @param int $userid
     *
     * @return contextlist
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
    }

    /**
     * @param approved_contextlist $contextlist
     *
     * @throws \dml_exception
     */
    public static function export_user_data(approved_contextlist $contextlist) {

        $user = $contextlist->get_user();

        if (empty($user->id)) {
            return;
        }

        $user_context = \context_user::instance($user->id);

        $queue_repo = queue_factory::get_queue_repository();
        $queue_items = $queue_repo->get_by_id($user->id);

        $queue_items_for_moodle = [];
        foreach ($queue_items as $queue_item) {
            $queue_items_for_moodle[] = (object)$queue_item;
        }

        writer::with_context($user_context)->export_data([
            'mod_diploasafe'
        ], (object)$queue_items_for_moodle);
    }

    /**
     * @param \context $context
     *
     * @throws \dml_exception
     */
    public static function delete_data_for_all_users_in_context(\context $context) {

        global $DB;

        if ((int)$context->contextlevel === CONTEXT_COURSE) {
            $DB->delete_records('diplomasafe_queue', [
                'course_id' => $context->instanceid
            ]);
        }

        if ((int)$context->contextlevel === CONTEXT_USER) {
            $DB->delete_records('diplomasafe_queue', [
                'user_id' => $context->instanceid
            ]);
        }
    }

    /**
     * @param approved_contextlist $contextlist
     *
     * @throws \dml_exception
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {

        global $DB;

        $user = $contextlist->get_user();

        if (empty($user->id)) {
            return;
        }

        $DB->delete_records('diplomasafe_queue', [
            'user_id' => $user->id
        ]);
    }

    /**
     * @param approved_userlist $userlist
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function delete_data_for_users(approved_userlist $userlist) {

        global $DB;

        $user_ids = $userlist->get_userids();

        if (empty($user_ids)) {
            return;
        }

        [$sql_in, $sql_params] = $DB->get_in_or_equal($user_ids);

        $DB->delete_records_select('diplomasafe_queue', 'user_id ' . $sql_in, $sql_params);
    }

    /**
     * @param userlist $userlist
     */
    public static function get_users_in_context(userlist $userlist) {

        $context = $userlist->get_context();

        if (!$context instanceof \context_course) {
            return;
        }

        $sql = /** @lang mysql */"
        SELECT DISTINCT user_id 
        FROM {diplomasafe_queue} 
        WHERE course_id = :course_id";
        $userlist->add_from_sql('user_id', $sql, [
            'course_id' => $context->instanceid
        ]);
    }
}
