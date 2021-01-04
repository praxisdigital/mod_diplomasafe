<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

defined('MOODLE_INTERNAL') || die();

abstract class entity
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return mixed
     */
    abstract public function set_data();

    /**
     * @param array $params
     * @param array $required_params
     *
     * @return mixed
     */
    public function process_params(array $params, array $required_params) : void {
        foreach ($required_params as $i => $required_param) {
            if (!isset($params[$required_param])) {
                throw new \RuntimeException('The param "' . $required_param . '" is missing');
            }
        }

        foreach ($params as $key => $value) {
            $this->data[$key] = $params[$key];
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) : bool {
        return isset($this->data[$name]);
    }
}
