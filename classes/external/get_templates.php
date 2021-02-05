<?php
/**
 * @developer   Johnny Drud
 * @date        29-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\external;

use dml_exception;
use external_value;
use external_single_structure;
use external_multiple_structure;
use external_function_parameters;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\factory;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once("$CFG->libdir/externallib.php");

/**
 * Class
 *
 * @package mod_diplomasafe\external
 */
class get_templates extends \external_api
{
    /**
     * @return external_function_parameters
     */
    public static function get_templates_parameters(): external_function_parameters {
        return new external_function_parameters([
            'language_id' => new external_value(PARAM_TEXT, 'The ID of the template language', VALUE_REQUIRED),
        ]);
    }

    /**
     * @param int $language_id
     *
     * @return array
     * @throws \coding_exception
     * @throws \invalid_parameter_exception
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
     * @throws dml_exception
     */
    public static function get_templates(int $language_id): array{

        self::validate_parameters(self::get_templates_parameters(), ['language_id' => $language_id]);

        $config = factory::get_config();

        $template_repo = template_factory::get_repository();
        $templates = $template_repo->get_all($language_id, $config->get_available_template_ids());

        return [
            'language_id' => $language_id,
            'count' => $templates->count(),
            'templates' => $templates->to_array(),
        ];
    }

    /**
     * @return external_single_structure
     */
    public static function get_templates_returns(): external_single_structure {
        return new external_single_structure([
            'language_id' => new external_value(PARAM_INT, 'The ID of the language'),
            'count' => new external_value(PARAM_INT, 'The total number of found templates'),
            'templates' => new external_multiple_structure(
                new external_single_structure([
                    'id' => new external_value(PARAM_INT, 'The ID of the template'),
                    'name' => new external_value(PARAM_TEXT, 'The name of the template'),
                ], 'A template object', VALUE_OPTIONAL, null)
            )
        ]);
    }
}
