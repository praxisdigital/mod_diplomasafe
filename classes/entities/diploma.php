<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\entities;

use mod_diplomasafe\entity;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\template_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\entities
 *
 * @property int $id
 * @property template $template
 * @property int $course_id
 * @property int $user_id
 * @property string $issue_date
 * @property language $language
 * @property array $fields
 *
 */
class diploma extends entity
{
    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'id' => null,
            'template' => null,
            'course_id' => null,
            'user_id' => null,
            'issue_date' => null,
            'language' => null,
            'fields' => []
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     *
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function __construct($params) {
        $required_params = ['template', 'course_id', 'user_id'];
        $this->process_params($params, $required_params);

        if (!empty($this->template->id) && !empty($this->language->id)) {
            $this->load_fields();
        }
    }

    /**
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    private function load_fields() : void {
        $diploma_fields_repo = diploma_factory::get_fields_repository();
        $this->fields = $diploma_fields_repo->get_field_data($this);
    }
}
