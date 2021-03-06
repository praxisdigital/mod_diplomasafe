<?php
/**
 * @developer   Johnny Drud
 * @date        27-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\requests;

use mod_diplomasafe\contracts\request_interface;
use mod_diplomasafe\output\setup_guide;
use mod_diplomasafe\request;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\requests
 */
class setup_guide_request extends request implements request_interface
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
        $page_url = new \moodle_url('/mod/diplomasafe/view.php', [
            'view' => $view,
        ]);

        $this->page_setup($page_url);

        return new setup_guide();
    }
}
