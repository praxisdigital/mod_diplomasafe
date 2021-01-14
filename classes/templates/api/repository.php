<?php
namespace mod_diplomasafe\templates\api;

use mod_diplomasafe\api_pagination;
use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\language_factory;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\templates
 */
class repository
{
    /**
     * @var \curl
     */
    private $client;

    /**
     * @var array
     */
    private $templates = [];

    /**
     * Constructor
     *
     * @param \curl $client
     */
    public function __construct(\curl $client) {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param int $page
     *
     * @return array
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function get_all(string $url = '', int $page = 0) : array {

        if ($url === '') {
            $config = new diplomasafe_config(get_config('mod_diplomasafe'));
            $url = $config->get_base_url() . '/templates';
        }

        $response = json_decode($this->client->get($url), true);
        $templates = $response['templates'];

        $languages_repository = language_factory::get_repository();
        $languages = $languages_repository->get_all();

        $language_mapper = language_factory::get_mapper();

        foreach ($templates as $template) {

            $diploma_fields = $template['diploma_fields'] ?? [];

            $default_language_key = $template['default_language'];
            if (!$languages->key_exists($default_language_key)) {
                $language_id = $language_mapper->create($default_language_key);
            } else {
                $language = $languages_repository->get_by_key($default_language_key);
                $language_id = $language->id;
            }

            $remote_field_ids = [];
            foreach ($diploma_fields as $diploma_field) {
                $remote_field_ids[] = $diploma_field['id'];
            }

            $this->templates[] = new template([
                'organisation_id' => $template['organization_id'],
                'default_language_id' => $language_id,
                'idnumber' => $template['id'],
                'name' => $template['extra_name'],
                'default_fields' => template::extract_default_fields($template),
                'diploma_fields' => $remote_field_ids
            ]);
        }

        $api_pagination = new api_pagination($response['pagination']);
        if ($api_pagination->more_pages_exist()) {
            $this->get_all($api_pagination->next_url(), ++$page);
        }

        return $this->templates;
    }
}
