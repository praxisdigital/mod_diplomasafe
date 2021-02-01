<?php
/**
 * @developer   Johnny Drud
 * @date        29-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\form_fields;

defined('MOODLE_INTERNAL') || die();

/**
 * Drop down form element to select visibility in an activity mod update form
 *
 * Contains HTML class for a drop down element to select visibility in an activity mod update form
 *
 * @package   core_form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG;
require_once "$CFG->libdir/form/select.php";

/**
 * Drop down form element to select visibility in an activity mod update form
 *
 * HTML class for a drop down element to select visibility in an activity mod update form
 *
 * @package   core_form
 * @category  form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class template_select extends \MoodleQuickForm_select {
    /**
     * Class constructor
     *
     * @param string $elementName Select name attribute
     * @param mixed $elementLabel Label(s) for the select
     * @param mixed $attributes Either a typical HTML attribute string or an associative array
     * @param array $options ignored
     */
    public function __construct($elementName=null, $elementLabel=null, $attributes=null, $options=null) {
        parent::__construct($elementName, $elementLabel, $options, $attributes);
        $this->_type = 'template_id';
    }
}
