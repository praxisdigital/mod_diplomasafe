<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\controllers;

use mod_diplomasafe\requests\default_request;
use mod_diplomasafe\requests\templates_list_request;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\controller
 */
class dispatcher
{
    /**
     * @var \moodle_page
     */
    private $page;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     */
    public function __construct(\moodle_page $page)
    {
        $this->page = $page;
    }

    /**
     * @param string $dispatch_request
     *
     * @return \renderable
     * @throws \coding_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public function dispatch(string $dispatch_request): \renderable
    {
        switch ($dispatch_request) {
            case 'templates_list':
                $request = new templates_list_request($this->page);
                break;
            case 'default':
            default: {
                $request = new default_request($this->page);
                break;
            }
        }

        return $request->process();
    }
}
