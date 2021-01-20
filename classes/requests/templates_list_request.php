<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\requests;

use mod_diplomasafe\contracts\request_interface;
use mod_diplomasafe\output\templates_list;
use mod_diplomasafe\request;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates_list_request
 */
class templates_list_request extends request implements request_interface
{
    /**
     * @return \renderable
     * @throws \coding_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public function process(): \renderable {

        require_capability('mod/diplomasafe:access_admin_views', \context_system::instance());

        $view = required_param('view', PARAM_TEXT);
        $page_number = optional_param('page', 0, PARAM_INT);

        $page_url = new \moodle_url('/mod/diplomasafe/view.php', [
            'view' => $view,
        ]);

        $this->page_setup($page_url);

        return new templates_list($this->get_output(), $page_number);
    }
}
