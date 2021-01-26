<?php
/**
 * @developer   Johnny Drud
 * @date        26-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use mod_diplomasafe\exceptions\base_url_not_set;
use mod_diplomasafe\exceptions\current_environment_invalid;
use mod_diplomasafe\exceptions\current_environment_not_set;
use mod_diplomasafe\exceptions\personal_access_token_not_set;

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class config
{
    /** @var object|\stdClass */
    protected $config;

    /** @var string */
    protected $environment;

    /**
     * We only want to hold the config for diplomasafe
     * config constructor.
     *
     * @param \stdClass $config_data
     *
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    public function __construct(\stdClass $config_data){
        $this->config = $this->validate_config($config_data);
        $this->environment = $this->config->environment;
    }

    /**
     * @return string
     */
    public function get_environment(): string {
        return $this->environment;
    }

    /**
     * @return bool
     */
    public function is_test_environment() : bool {
        return $this->get_environment() === 'test';
    }

    /**
     * The personal access token generated here: https://demo-admin.diplomasafe.net/en-US/auth-user
     * @return string
     */
    public function get_private_token(): string {
        return $this->config->{$this->get_environment().'_personal_access_token'};
    }

    /**
     * The base url typically https://demo-api.diplomasafe.net/api/v1 - see README.md
     * @return string
     */
    public function get_base_url(): string {
        return $this->config->{$this->get_environment().'_base_url'};
    }

    /**
     * @param \stdClass $config
     * @return \stdClass
     * @throws base_url_not_set
     * @throws current_environment_invalid
     * @throws current_environment_not_set
     * @throws personal_access_token_not_set
     */
    protected function validate_config(\stdClass $config): \stdClass{
        $this->has_environment($config);

        if($config->environment === 'test'){
            $this->has_base_url($config, 'test');
            $this->has_personal_access_token($config, 'test');
        }

        if($config->environment === 'prod'){
            $this->has_base_url($config, 'prod');
            $this->has_personal_access_token($config, 'prod');
        }

        return $config;
    }

    /**
     * @param $config
     * @throws current_environment_not_set
     * @throws current_environment_invalid
     */
    protected function has_environment(&$config): void{
        if (empty($config->environment)) {
            // PTODO: Add to README.md
            $message = 'environment not set in global settings - see README.md';
            throw new current_environment_not_set($message);
        }

        if(!in_array($config->environment, ['test', 'prod'])){
            // PTODO: Add to README.md
            $message = 'Invalid environment in global settings - see README.md';
            throw new current_environment_invalid($message);
        }
    }

    /**
     * @param $config
     * @param $environment
     * @throws base_url_not_set
     */
    protected function has_base_url(&$config, $environment): void{
        if (
            ($environment === 'prod' && empty($config->prod_base_url)) ||
            ($environment === 'test' && empty($config->test_base_url))
        ) {
            // PTODO: Add to README.md
            $message = $environment.'_base_url not set in global settings - see README.md';
            throw new base_url_not_set($message);
        }
    }

    /**
     * @param $config
     * @param $environment
     * @throws personal_access_token_not_set
     */
    protected function has_personal_access_token(&$config, $environment): void{
        if (
            ($environment === 'prod' && empty($config->prod_personal_access_token)) ||
            ($environment === 'test' && empty($config->test_personal_access_token))
        ) {
            // PTODO: Add to README.md
            $message = $environment.'personal_access_token not set in global settings - see README.md';
            throw new personal_access_token_not_set($message);
        }
    }

    /**
     * @return int
     */
    public function get_timeout() : int {
        return $this->config->api_timeout;
    }

    /**
     * @return int
     */
    public function get_queue_amount_to_process() : int {
        return $this->config->queue_amount_to_process;
    }

    /**
     * @return string
     */
    public function get_duration_custom_field_code() : string {
        return $this->config->moodle_duration_field;
    }

    /**
     * @return string
     */
    public function get_location_custom_field_code() : string {
        return $this->config->moodle_location_field;
    }

    /**
     * @return int
     */
    public function get_item_count_per_page() : int {
        return $this->config->item_count_per_page;
    }

    /**
     * @return array
     */
    public function get_available_language_ids() : array {
        return array_filter(explode(',', $this->config->available_language_ids));
    }

    /**
     * @return array
     */
    public function get_available_template_ids() : array {
        return array_filter(explode(',', $this->config->available_template_ids));
    }
}