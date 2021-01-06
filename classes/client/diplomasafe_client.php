<?php

namespace mod_diplomasafe\client;

use mod_diplomasafe\client\interfaces\request_interface;

/**
 * PTODO: This should in time implement PSR-18 (https://www.php-fig.org/psr/psr-18/)
 * Class diplomasafe_client
 * @package mod_diplomasafe
 */
class diplomasafe_client implements request_interface{

    /** @var request_interface */
    protected $request;

    /**
     * diplomasafe_client constructor.
     * @param request_interface $request
     */
    public function __construct(request_interface $request){
        $this->request = $request;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function set_headers(array $headers): request_interface {
        $this->request->set_headers($headers);
        return $this;
    }

    /**
     * Sets any curl options like: $options['CURLOPT_CUSTOMREQUEST'] = 'OPTIONS';
     * @param array $options
     * @return $this
     */
    public function set_options(array $options): request_interface {
        $this->request->set_options($options);
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function set_base_url($url): request_interface {
        $this->request->set_base_url($url);
        return $this;
    }

    /**
     * @param array $payload
     * @return $this
     */
    public function set_payload(array $payload): request_interface {
        $this->request->set_payload($payload);
        return $this;
    }

    /**
     * Returns an array with all response info
     * @return array
     */
    public function get_info(): array {
        return $this->request->get_info();
    }

    /**
     * Fire a get request - retrieves a whole entity
     * @param string $url
     * @return array
     */
    public function get(string $url = ''): array {
        return $this->request->get($url);
    }

    /**
     * Fire a post request - inserts a new entity
     * @param string $url
     * @return ?array
     */
    public function post(string $url = ''): ?array {
        return $this->request->post($url);
    }

    /**
     * Fire a patch request - used when only updating parts of the data
     * @param string $url
     * @return array
     */
    public function patch(string $url = ''): array {
        return $this->request->patch($url);
    }

    /**
     * Fire a put request - update the whole entity
     * @param string $url
     * @return array
     */
    public function put(string $url = ''): array {
        return $this->request->put($url);
    }

    /**
     * Fire a delete request - deletes a whole entity
     * @param string $url
     * @return array
     */
    public function delete(string $url = ''): array {
        return $this->request->delete($url);
    }
}