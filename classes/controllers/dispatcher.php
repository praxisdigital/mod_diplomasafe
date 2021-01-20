<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\controllers;

use mod_diplomasafe\requests\single_request;
use mod_diplomasafe\requests\queue_list_request;
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
     * @var object
     */
    private $output;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     * @param object $output
     */
    public function __construct(\moodle_page $page, object $output)
    {
        $this->page = $page;
        $this->output = $output;
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
                $request = new templates_list_request($this->page, $this->output);
                break;
            case 'queue_list':
                $request = new queue_list_request($this->page, $this->output);
                break;
            case 'default':
            default: {
                $request = new single_request($this->page, $this->output);
                break;
            }
        }

        return $request->process();
    }
}
