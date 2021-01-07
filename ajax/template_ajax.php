<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

require_once __DIR__.'/../../../config.php';

use mod_diplomasafe\output\template_ajax;

defined('MOODLE_INTERNAL') || die();

global $PAGE, $USER;

require_login();
require_sesskey();

$PAGE->set_context(context_user::instance($USER->id));

$language_id = required_param('language_id', PARAM_INT);
$selected_template_id = required_param('selected_template_id', PARAM_INT);

try {
    $view = new template_ajax($language_id, $selected_template_id);

    $renderer = $PAGE->get_renderer('mod_diplomasafe');
    echo $renderer->render($view);
} catch (Exception $e) {
    echo get_string('ajax_error_occurred', 'mod_diplomasafe');
}
