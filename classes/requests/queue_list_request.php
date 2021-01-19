<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\requests;

use mod_diplomasafe\contracts\request_interface;
use mod_diplomasafe\output\queue_list;
use mod_diplomasafe\request;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\requests
 */
class queue_list_request extends request implements request_interface
{
    /**
     * @return \renderable
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public function process(): \renderable {

        $view = required_param('view', PARAM_TEXT);

        $page_url = new \moodle_url('/mod/diplomasafe/view.php', [
            'view' => $view,
        ]);

        $this->page_setup($page_url);

        return new queue_list();
    }
}
