<?php
/**
 * @developer   Johnny Drud
 * @date        08-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

defined('MOODLE_INTERNAL') || die();

class api_pagination
{
    /**
     * @var string
     */
    private $next_page_url;

    /**
     * Constructor
     *
     * @param array $payload
     */
    public function __construct(array $payload) {
        $this->next_page_url = trim($payload['next_page_url']);
    }

    /**
     * @return bool
     */
    public function more_pages_exist() : bool {
        return $this->next_page_url !== '';
    }

    /**
     * @return string
     */
    public function next_url() : string {
        return $this->next_page_url;
    }
}
