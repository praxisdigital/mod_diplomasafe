<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\mappings;

use mod_diplomasafe\contracts\mapping_interface;
use mod_diplomasafe\factories\custom_field_factory;
use mod_diplomasafe\factory;
use mod_diplomasafe\mapping;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * Get the custom field selected in the settings for the duration.
 *
 * @package mappings
 */
class moodle_duration extends mapping implements mapping_interface
{
    /**
     * @return string
     * @throws \dml_exception
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
     */
    public function get_value(): string {
        $config = factory::get_config();

        $duration_field_code = $config->get_duration_custom_field_code();
        $repository = custom_field_factory::get_customfield_repository($this->course->id);

        return $repository->get_field_data($duration_field_code);
    }
}
