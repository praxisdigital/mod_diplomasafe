<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\output\create_diploma_payload;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

require_once $CFG->dirroot . '/user/lib.php';

/**
 * Class
 *
 * @package mod_diplomasafe\diplomas
 */
class mapper
{
    /**
     * @var \curl
     */
    private $client;

    /**
     * @var diplomasafe_config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \curl $client
     * @param diplomasafe_config $config
     */
    public function __construct(\curl $client, diplomasafe_config $config) {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param diploma $diploma
     *
     * @return bool
     * @throws \coding_exception
     */
    public function create(diploma $diploma) : bool {

        $endpoint = '/diplomas';

        $users = user_get_users_by_id([$diploma->user_id]);

        if (empty($users[$diploma->user_id])) {
            throw new \RuntimeException(
                get_string(
                    'message_user_could_not_be_found',
                    'mod_diplomasafe',
                    $diploma->user_id
                )
            );
        }

        $user = $users[$diploma->user_id];

        $payload = (object)[
            'template_id' => $diploma->template->idnumber,
            'organization_id' => $diploma->template->organisation_id,
            'diplomas' => [
                (object)[
                    'recipient_email' => $user->email,
                    'recipient_name' => $user->firstname . ' ' . $user->lastname,
                    'language_code' => $diploma->language->name,
                    'issue_date' => $diploma->issue_date,
                    'no_claim_mail' => 0,
                    'diploma_fields' => $diploma->fields
                ]
            ]
        ];

        $response = json_decode(
            $this->client->post($this->config->get_base_url() . $endpoint, json_encode($payload)
        ), true);

        if (!isset($response['countIssued'])) {
            throw new \RuntimeException(
                get_string(
                    'message_invalid_response_from_endpoint',
                    'mod_diplomasafe',
                    (object)[
                        'endpoint' => $endpoint,
                        'response' => json_encode($response)
                    ]
                )
            );
        }

        return (int)$response['countIssued'] === 1;
    }
}
