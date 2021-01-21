<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\factories\template_factory;
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
    public const ENDPOINT = '/diplomas';

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
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     * @throws \moodle_exception
     */
    public function create(diploma $diploma) : bool {
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

        $templates_repository = template_factory::get_api_repository();
        $response = $templates_repository->get_one($diploma->template);

        $remote_field_ids = [];
        foreach ($response['diploma_fields'] as $diploma_field) {
            $remote_field_ids[] = $diploma_field['id'];
        }

        $remote_fields_without_local_mapping = $templates_repository->other_diploma_fields_than_mapped(
            $remote_field_ids
        );

        // Check if any of the remote fields are missing local mapping
        if (!empty($remote_fields_without_local_mapping)) {
            throw new \RuntimeException(
                get_string('message_remote_diploma_fields_missing_local_mapping',
                'mod_diplomasafe', implode($remote_fields_without_local_mapping)
                )
            );
        }

        $response = json_decode(
            $this->client->post($this->config->get_base_url() . self::ENDPOINT, json_encode($payload)
        ), true);

        if (!isset($response['countIssued'])) {
            throw new \RuntimeException(
                get_string(
                    'message_invalid_response_from_endpoint',
                    'mod_diplomasafe',
                    (object)[
                        'endpoint' => self::ENDPOINT,
                        'response' => json_encode($response)
                    ]
                )
            );
        }

        return (int)$response['countIssued'] === 1;
    }
}
