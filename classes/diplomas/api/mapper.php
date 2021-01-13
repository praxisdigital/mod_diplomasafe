<?php
namespace mod_diplomasafe\diplomas\api;

use mod_diplomasafe\admin_task_mailer;
use mod_diplomasafe\client\diplomasafe_config;
use mod_diplomasafe\entities\diploma;

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
     */
    public function __construct(\curl $client, diplomasafe_config $config) {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param diploma $diploma
     *
     * @return array
     * @throws \coding_exception
     */
    public function create(diploma $diploma) : array {
        // Todo: Add to mustache template or load as object list
        $payload = '
        {
            "template_id": "' . $diploma->template->idnumber . '",
            "organization_id": "' . $diploma->template->organisation_id . '",
            "diplomas": [
            {
                    "recipient_email": "sample@example.mail",
                    "recipient_name": "Sample Name",
                    "language_code": "en-US",
                    "issue_date": "2021-01-12",
                    "no_claim_mail": 0,
                    "diploma_fields": {
                        "5": "Sample Value"
                    }
            }]
        }
        ';
        // Issue diploma

        // Todo: Throw exception if the request is timed out

        return json_decode($this->client->post($this->config->get_base_url() . '/diplomas', $payload), true);
    }
}
