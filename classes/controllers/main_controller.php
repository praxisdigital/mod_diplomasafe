<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\controllers;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\controllers
 */
class main_controller
{
    /**
     * @var \moodle_page
     */
    private $page;

    /**
     * @var \bootstrap_renderer
     */
    private $output;

    /**
     * Constructor
     *
     * @param \moodle_page $page
     * @param \bootstrap_renderer $output
     * @param $config
     */
    public function __construct(\moodle_page $page, \bootstrap_renderer $output) {
        $this->page = $page;
        $this->output = $output;
    }

    /**
     * @param string $view
     *
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function dispatch(string $view): void {
        $dispatcer = new dispatcher($this->page);

        $template = $dispatcer->dispatch($view);
        $renderer = $this->page->get_renderer('mod_diplomasafe');

        echo $this->output->header();
        echo $renderer->render($template);
        echo $this->output->footer();
    }
}
