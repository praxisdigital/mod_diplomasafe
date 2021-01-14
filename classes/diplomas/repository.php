<?php
/**
 * @developer   Johnny Drud
 * @date        14-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\diplomas;

use mod_diplomasafe\entities\template;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\diplomas
 */
class repository
{

    /**
     * @param template $template
     */
    public function get_by_template(template $template) {
        // Todo: Get the available diplomas for this template
    }
}
