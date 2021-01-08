<?php
/**
 * @developer   Johnny Drud
 * @date        08-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * This class contains values for the default
 * fields in all the available languages.
 *
 * @package mod_diplomasafe\collections
 */
class template_default_field_values extends collection
{
    /**
     * @var array
     */
    private $language_keys = [];

    /**
     * Constructor
     *
     * @param array $base_language_fields
     * @param array $template_payload
     */
    public function __construct(array $base_language_fields, array $template_payload) {
        $this->set($this->extract($base_language_fields, $template_payload));
    }

    /**
     * @param $base_language_fields
     * @param $template_payload
     *
     * @return array
     */
    private function extract($base_language_fields, $template_payload) : array {
        $default_fields = [];
        foreach ($base_language_fields as $field_key => $internal_field_id) {
            $template_languages = $template_payload[$field_key];
            foreach ($template_languages as $language_key => $value) {
                if (empty($value)) {
                    continue;
                }
                $default_fields[$field_key]['lang'] = $language_key;
                $this->language_keys[$language_key] = $language_key;
                $default_fields[$field_key]['key'] = $field_key;
                $default_fields[$field_key]['value'] = $value;
            }
        }
        $this->language_keys = array_values($this->language_keys);
        return array_values($default_fields);
    }

    /**
     * @return array
     */
    public function get_available_language_keys() : array {
        return $this->language_keys;
    }
}
