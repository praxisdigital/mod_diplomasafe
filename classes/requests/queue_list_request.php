<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\requests;

use coding_exception;
use core\output\notification;
use dml_exception;
use Exception;
use mod_diplomasafe\contracts\request_interface;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\output\queue_list;
use mod_diplomasafe\request;
use moodle_exception;
use moodle_url;
use renderable;
use require_login_exception;
use RuntimeException;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\requests
 */
class queue_list_request extends request implements request_interface
{
    /**
     * @return renderable
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function process(): renderable {

        require_capability('mod/diplomasafe:access_admin_views', \context_system::instance());

        $view = required_param('view', PARAM_TEXT);
        $page_number = optional_param('page', 0, PARAM_INT);

        $action = optional_param('action', '', PARAM_TEXT);
        $id = optional_param('id' , 0, PARAM_INT);

        $queue_list_url = new moodle_url('/mod/diplomasafe/view.php', [
            'view' => 'queue_list'
        ]);

        $this->perform_action([
            'action' => $action,
            'id' => $id
        ], $queue_list_url);

        $page_url = new moodle_url('/mod/diplomasafe/view.php', [
            'view' => $view,
        ]);

        $this->page_setup($page_url);

        return new queue_list($this->get_page(), $this->get_output(), $page_number);
    }

    /**
     * @param array $params
     * @param moodle_url $return_url
     *
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    private function perform_action(array $params, moodle_url $return_url) : void {

        $message = '';
        if (empty($params['action'])) {
            return;
        }
        switch ($params['action']) {
            case 'add_again':
                $mapper = queue_factory::get_queue_mapper();
                $repo = queue_factory::get_queue_repository();
                $queue_item = $repo->get_by_id($params['id']);
                $queue_item->id = null;
                $queue_item->status = 0;
                $queue_item->message = '';
                $queue_item->time_created = time();
                $queue_item->time_modified = time();
                $queue_item->last_run = null;
                $queue_item->last_mail_sent = null;
                if ($mapper->create($queue_item)) {
                    $message = get_string('message_item_created', 'mod_diplomasafe');
                }
                redirect($return_url, $message);
                break;
            case 'delete':
                $mapper = queue_factory::get_queue_mapper();
                $repo = queue_factory::get_queue_repository();
                if ($mapper->delete($repo->get_by_id($params['id']))) {
                    $message = get_string('message_item_deleted', 'mod_diplomasafe');
                }
                redirect($return_url, $message);
                break;
            default:
                throw new RuntimeException(
                    get_string('message_invalid_action', 'mod_diplomasafe', $params['action'])
                );
        }
    }
}
