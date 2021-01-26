<?php
/**
 * @developer   Johnny Drud
 * @date        14-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\diplomas\fields;

use mod_diplomasafe\factories\mapping_factory;
use mod_diplomasafe\factory;
use mod_diplomasafe\mapping;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\diplomas
 */
class repository
{
    /**
     * @var array
     */
    private $diploma_fields;

    /**
     * @var array
     */
    private $diploma_key_value = [];

    /**
     * Constructor
     */
    public function __construct() {
        $this->diploma_fields = mapping::MAPPING_FIELDS;
    }

    /**
     * @param int $course_id
     *
     * @throws \dml_exception
     */
    private function extract_field_data(int $course_id): void {
        foreach ($this->diploma_fields as $diploma_field) {
            $mapping = mapping_factory::make($diploma_field['field_code'], $course_id);
            $this->diploma_key_value[$mapping->get_remote_id()] = $mapping->get_value();
        }
    }

    /**
     * @return array
     * @throws \dml_exception
     */
    public function get_field_ids() : array {
        $config = factory::get_config();
        $field_ids = [];
        foreach ($this->diploma_fields as $diploma_field) {
            if ($config->is_test_environment()) {
                $field_ids[] = $diploma_field['test_idnumber'] ?? '';
                continue;
            }
            $field_ids[] = $diploma_field['prod_idnumber'] ?? '';
        }
        return $field_ids;
    }

    /**
     * @return array|array[]
     */
    public function get_fields() : array {
        return $this->diploma_fields;
    }

    /**
     * @param int $course_id
     *
     * @return array
     * @throws \dml_exception
     */
    public function get_fields_key_value(int $course_id) : array {
        if (empty($this->diploma_key_value)) {
            $this->extract_field_data($course_id);
        }
        return $this->diploma_key_value;
    }
}
