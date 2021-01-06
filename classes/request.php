<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
abstract class request
{
    /**
     * @var \moodle_page
     */
    protected $page;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     */
    public function __construct(\moodle_page $page) {
        $this->page = $page;
    }

    /**
     * @param $url
     * @param string $title
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public function page_setup($url, $title = '') : void {

        $this->page->set_context(\context_system::instance());

        require_login();
        if (isguestuser()) {
            die();
        }

        if ($title) {
            $this->page->set_heading($title);
            $this->page->set_title($title);
        }
        $this->page->set_url($url);

    }
}
