<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
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
class mock_payload
{
    /**
     * @return array
     */
    public static function create_diploma() : array
    {
        return [
            'organization_id' => 'o343e4d01a6f83d76d3818453637b3227417e10ba',
            'template_id' => 't4ab241160738670c7f4daaea97f33794e80567c9',
            'diplomas' => [
                [
                    'recipient_email' => 'jdr@praxis.dk',
                    'recipient_name' => 'Testbruger',
                    'language_code' => 'da-DK',
                    'issue_date' => '2021-01-06',
                    'no_claim_mail' => 0,
                    'diploma_fields' => [
                        //'course_num' => 'Kursusnummer her'
                    ]
                ]
            ]
        ];
    }
}
