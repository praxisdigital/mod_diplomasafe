<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

use mod_diplomasafe\output\template_ajax;

defined('MOODLE_INTERNAL') || die();

require_once __DIR__.'/../../../config.php';

global $PAGE;

try {
    require_login();
    require_sesskey();

    $language_id = required_param('language_id', PARAM_INT);
    $view = new template_ajax($language_id);

    $renderer = $PAGE->get_renderer('mod_diplomasafe');
    $renderer->render($view);
} catch (Exception $e) {
    echo get_string('ajax_error_occurred', 'mod_diplomasafe');
}
