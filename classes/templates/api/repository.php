<?php
namespace mod_diplomasafe\templates\api;

use mod_diplomasafe\api_pagination;
use mod_diplomasafe\config;
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
    public const ENDPOINT = '/templates';

    /**
     * @var \curl
     */
    private $client;

    /**
     * @var array
     */
    private $templates = [];

    /**
     * @var config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \curl $client
     * @param config $config
     */
    public function __construct(\curl $client, config $config) {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param string $url
     * @param int $page
     *
     * @return array
     * @throws \dml_exception
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
     */
    public function get_all(string $url = '', int $page = 0) : array {

        if ($url === '') {
            $url = $this->config->get_base_url() . self::ENDPOINT;
        }

        $response = json_decode($this->client->get($url), true);
        $templates = $response['templates'];

        $languages_repo = language_factory::get_repository();
        $language_mapper = language_factory::get_mapper();

        foreach ($templates as $template) {

            $diploma_fields = $template['diploma_fields'] ?? [];
            $default_language_key = $template['default_language'];

            if (!$languages_repo->exists($default_language_key)) {
                $language_id = $language_mapper->create($default_language_key);
            } else {
                $language = $languages_repo->get_by_key($default_language_key);
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
                'is_valid' => !$this->has_other_diploma_fields_than_mapped($remote_field_ids)
            ]);
        }

        $api_pagination = new api_pagination($response['pagination']);
        if ($api_pagination->more_pages_exist()) {
            $this->get_all($api_pagination->next_url(), ++$page);
        }

        return $this->templates;
    }

    /**
     * @param template $template
     *
     * @return mixed
     */
    public function get_one(template $template) {
        $template_endpoint = self::ENDPOINT . '/' . $template->idnumber;
        return json_decode($this->client->get($this->config->get_base_url() . $template_endpoint), true);
    }

    /**
     * @param array $remote_field_ids
     *
     * @return array
     * @throws \dml_exception
     */
    public function other_diploma_fields_than_mapped(array $remote_field_ids) : array {

        $diploma_fields_repo = diploma_factory::get_fields_repository();
        $mapped_field_ids = $diploma_fields_repo->get_field_ids();

        $remote_fields_without_local_mapping = [];
        foreach ($remote_field_ids as $remote_field_id) {
            if (!in_array($remote_field_id, $mapped_field_ids, true)) {
                $remote_fields_without_local_mapping[$remote_field_id] = $remote_field_id;
            }
        }
        return array_values($remote_fields_without_local_mapping);
    }

    /**
     * @param $remote_field_ids
     *
     * @return bool
     * @throws \dml_exception
     */
    public function has_other_diploma_fields_than_mapped($remote_field_ids) : bool {
        return !empty($this->other_diploma_fields_than_mapped($remote_field_ids));
    }
}
