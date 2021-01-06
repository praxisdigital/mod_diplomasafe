<?php

namespace mod_diplomasafe\client\adapters;

use curl;
use mod_diplomasafe\client\exceptions\base_url_missing_exception;
use mod_diplomasafe\client\exceptions\invalid_argument_exception;
use mod_diplomasafe\client\interfaces\request_interface;
use mod_diplomasafe\client\mocks\moodle_curl_mock;

/**
 * Class moodle_curl_adapter
 * @package mod_diplomasafe\adapters
 */
class moodle_curl_request_adapter implements request_interface{

    /** @var curl */
    protected $curl;

    /** @var string */
    protected $base_url = '';

    /** @var array */
    protected $payload = [];

    /** @var array */
    protected $options = [];

    /** @var array */
    protected $info = [];

    /**
     * Sadly we can not force an interface, since Moodle don't use that
     * moodle_curl_adapter constructor.
     * @param $moodle_curl
     * @throws invalid_argument_exception
     */
    public function __construct($moodle_curl){

        if(!is_a($moodle_curl, '\curl') && !is_a($moodle_curl, moodle_curl_mock::class)){
            throw new invalid_argument_exception(
                'Class '.get_class($moodle_curl).' is not supported for moodle_curl_connection_adapter'
            );
        }

        $this->curl = $moodle_curl;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function set_headers(array $headers): request_interface {
        $this->curl->setHeader($headers);
        return $this;
    }

    /**
     * Sets any curl options like: $options['CURLOPT_CUSTOMREQUEST'] = 'OPTIONS';
     * @param array $options
     * @return $this
     */
    public function set_options(array $options): request_interface {
        $this->options = $options;
        return $this;
    }

    /**
     * @param $url
     * @return request_interface
     */
    public function set_base_url($url): request_interface{
        $this->base_url = $url;
        return $this;
    }

    /**
     * @param array $payload
     * @return $this
     */
    public function set_payload(array $payload): request_interface {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Returns an array with all response info
     * @return array
     */
    public function get_info(): array {
        return $this->info;
    }

    /**
     * Fire a get request - retrieves a whole entity
     * @param string $url
     * @return array
     * @throws base_url_missing_exception
     */
    public function get(string $url = ''): array {
        $this->basic_validation();
        $content = $this->curl->get($this->base_url.$url, $this->payload, $this->options);
        $this->info = $this->curl->getResponse();
        return $this->json($content);

    }

    /**
     * Fire a post request - inserts a new entity
     * @param string $url
     * @return array
     * @throws base_url_missing_exception
     */
    public function post(string $url = ''): ?array {
        $this->basic_validation();
        $content = $this->curl->post($this->base_url.$url, json_encode($this->payload), $this->options);
        $this->info = $this->curl->getResponse();
        return $this->json($content);
    }

    /**
     * Fire a patch request - used when only updating parts of the data
     * @param string $url
     * @return array
     * @throws base_url_missing_exception
     */
    public function patch(string $url = ''): array {
        $this->basic_validation();
        $content = $this->curl->patch($this->base_url.$url, $this->payload, $this->options);
        $this->info = $this->curl->getResponse();
        return $this->json($content);
    }

    /**
     * Fire a put request - update the whole entity
     * @param string $url
     * @param array $options
     * @return array
     * @throws base_url_missing_exception
     */
    public function put(string $url = ''): array {
        $this->basic_validation();
        $content = $this->curl->put($this->base_url.$url, $this->payload, $this->options);
        $this->info = $this->curl->getResponse();
        return $this->json($content);
    }

    /**
     * Fire a delete request - deletes a whole entity
     * @param string $url
     * @return array
     * @throws base_url_missing_exception
     */
    public function delete(string $url = ''): array {
        $this->basic_validation();
        $content = $this->curl->delete($this->base_url.$url, $this->payload, $this->options);
        $this->info = $this->curl->getResponse();
        return $this->json($content);
    }

    /**
     * Validates all necessary values needed to make the request
     * @throws base_url_missing_exception
     */
    protected function basic_validation(): void {
        if(empty($this->base_url)){
            throw new base_url_missing_exception('No base url set for diplomasafe client');
        }

        if(substr($this->base_url, -1) === '/'){
            $this->base_url = substr($this->base_url, 0, -1);
        }
    }

    /**
     * Converts json to array
     * @param $string
     * @return array
     */
    protected function json($string){
        return json_decode($string, true);
    }
}