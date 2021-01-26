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
     * Defines the table with user data. Is displayed in the Moodle administration in:
     * Site administration => Users => Privacy and policies => Plugin privacy registry
     *
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
     * Define the context to use for the users.
     *
     * @param int $userid
     *
     * @return contextlist
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $context_list = new contextlist();
        $context_list->add_user_context($userid);
        return $context_list;
    }

    /**
     * To allow exporting user data from the "Data requests" view in the administration.
     *
     * Notice:
     * Requires the get_contexts_for_userid method to be implemented to work.
     *
     * @param approved_contextlist $context_list
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function export_user_data(approved_contextlist $context_list) {

        global $DB;

        $user = $context_list->get_user();

        if (empty($user->id)) {
            return;
        }

        $user_context = \context_user::instance($user->id);

        $records = $DB->get_records('diplomasafe_queue', [
            'user_id' => $user->id
        ]);

        writer::with_context($user_context)
            ->export_data([get_string('view_queue_list_header', 'mod_diplomasafe')], (object)$records);
    }

    /**
     * A method for deleting user data (in different contexts).
     *
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
     * Another method for deleting user data (in different contexts).
     *
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
     * Yet another method for deleting user data.
     *
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
     * A method for extracting user data.
     *
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
