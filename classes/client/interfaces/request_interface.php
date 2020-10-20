<?php

namespace mod_diplomasafe\client\interfaces;

/**
 * PTODO: This should in time implement PSR-7 (https://www.php-fig.org/psr/psr-7/)
 * Interface connection_interface
 * @package mod_diplomasafe\interfaces
 */
interface request_interface{

    /**
     * @param array $headers
     * @return $this
     */
    public function set_headers(array $headers): self;

    /**
     * Sets the key / value pairs for the params send
     * @param array $payload
     * @return $this
     */
    public function set_payload(array $payload): self;

    /**
     * Sets any curl options like: $options['CURLOPT_CUSTOMREQUEST'] = 'OPTIONS';
     * @param array $options
     * @return $this
     */
    public function set_options(array $options): self;

    /**
     * @param $url
     * @return $this
     */
    public function set_base_url($url): self;

    /**
     * Returns an array with all response info
     * @return array
     */
    public function get_info(): array;

    /**
     * Fire a get request - retrieves a whole entity
     * @param string $url
     * @param array $options
     * @return array
     */
    public function get(string $url = ''): array;

    /**
     * Fire a post request - inserts a new entity
     * @param string $url
     * @param array $options
     * @return array
     */
    public function post(string $url = ''): array;

    /**
     * Fire a patch request - used when only updating parts of the data
     * @param string $url
     * @param array $options
     * @return array
     */
    public function patch(string $url = ''): array;

    /**
     * Fire a put request - update the whole entity
     * @param string $url
     * @param array $options
     * @return array
     */
    public function put(string $url = ''): array;

    /**
     * Fire a delete request - deletes a whole entity
     * @param string $url
     * @param array $options
     * @return array
     */
    public function delete(string $url = ''): array;

}