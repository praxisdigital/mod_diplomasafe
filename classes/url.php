<?php
/**
 * @developer   Johnny Drud
 * @date        05-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class url
{
    /**
     * @var string
     */
    private $url;

    /**
     * Constructor
     *
     * @param string $url
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public static function make($url) : self {
        return new static($url);
    }

    /**
     * @return mixed|string|void
     * @throws \moodle_exception
     */
    public function extract_base_host() : string {
        $moodle_url = new \moodle_url($this->url);
        preg_match('/[^\.]*\.[^\.]*$/', $moodle_url->get_host(), $out);
        return $out[0] ?: '';
    }
}
