<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\entities;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\entities
 */
class diploma
{
    /**
     * @var template
     */
    private $template;

    /**
     * @var int
     */
    private $course_id;

    /**
     * @var int
     */
    private $user_id;

    /**
     * Constructor
     *
     * @param template $template
     * @param int $course_id
     * @param int $user_id
     */
    public function __construct(template $template, int $course_id, int $user_id) {
        $this->template = $template;
        $this->course_id = $course_id;
        $this->user_id = $user_id;
    }
}
