<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\settings;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\settings
 */
class admin_setting_link extends \admin_setting {
    /**
     * @var \moodle_url
     */
    private $url;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $title
     * @param $url
     *
     * @throws \moodle_exception
     */
    public function __construct(string $name, string $title, $url){
        $this->nosave = true;
        $this->url = $url instanceof \moodle_url ? $url : new \moodle_url($url);
        parent::__construct($name, $title, '', '');
    }

    /**
     * Always returns true
     * @return bool Always returns true
     */
    public function get_setting() {
        return true;
    }

    /**
     * Always returns true
     * @return bool Always returns true
     */
    public function get_defaultsetting() {
        return true;
    }

    /**
     * Never write settings
     * @return string Always returns an empty string
     */
    public function write_setting($data) {
        return '';
    }

    /**
     * @param mixed $data
     * @param string $query
     *
     * @return string
     */
    public function output_html($data, $query='') : string {
        global $OUTPUT;

        $context = new class(){
            public $title;
            public $url;
        };

        $context->title = $this->visiblename;
        $context->url = $this->url;
        return $OUTPUT->render_from_template('mod_diplomasafe/mod_setting_link', $context);
    }
}
