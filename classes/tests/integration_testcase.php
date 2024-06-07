<?php

namespace mod_diplomasafe\tests;

use advanced_testcase;
use mod_diplomasafe\tests\api\mock_config;
use mod_diplomasafe\tests\api\mock_curl;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

abstract class integration_testcase extends advanced_testcase
{
    protected mock_config $config;

    protected function setUp(): void
    {
        $this->resetAfterTest();

        $this->config = new mock_config((object)get_config('mod_diplomasafe'));
        $this->config['environment'] = 'test';
        $this->config['test_base_url'] = $this->get_base_url();
        $this->config['test_personal_access_token'] = $this->get_default_test_token();
    }

    protected function get_base_url(): string
    {
        return 'https://localhost/api/v1';
    }

    protected function get_default_test_token(): string
    {
        $token_header = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9';
        $token_payload = 'eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ';
        $token_signature = 'SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        return $token_header . '.' . $token_payload . '.' . $token_signature;
    }

    protected function curl(): mock_curl
    {
        return new mock_curl();
    }

    protected function get_example_templates(): array
    {
        return [
            "pagination" => [
                "total" => 4,
                "per_page" => 50,
                "current_page" => 1,
                "last_page" => 1,
                "first_page_url" => "{$this->get_base_url()}/templates?page=1&limit=50",
                "last_page_url" => "{$this->get_base_url()}/templates?page=1&limit=50",
                "next_page_url" => null,
                "prev_page_url" => null,
                "path" => "{$this->get_base_url()}/templates",
                "from" => 1,
                "to" => 4
            ],
            "templates" => [
                [
                    "id" => "t498c1434976b8b05659ff5654b3403d3af4672bd",
                    "extra_name" => "Sample template with wrong diploma field (should be invalid)",
                    "default_language" => "da-DK",
                    "organization_id" => "o343e4d01a6f83d76d3818453637b3227417e10ba",
                    "name" => [
                        "da-DK" => "KURSUSTITEL",
                        "en-US" => "",
                    ],
                    "template_type" => "Kursusbevis",
                    "presentation_view" => 2,
                    "personal_identifier" => null,
                    "external_link" => null,
                    "public" => true,
                    "is_test" => false,
                    "description" => [
                        "da-DK" => "Dette er en beskrivelse af kurset. Det kan fx indeholde emner:<br />\r\n<ul>\r\n<li>Emne 1</li>\r\n<li>Emne 2</li>\r\n<li>Emne 3</li>\r\n</ul>",
                        "en-US" => null,
                    ],
                    "description_short" => [
                        "da-DK" => null,
                        "en-US" => null,
                    ],
                    "custom_designs" => [],
                    "badge" => [
                        "id" => 689,
                        "image_url" => "https://localhost/uploads/template_badges/f0d6f9c0c63995cd5468b6e0006ce077.png",
                        "name" => "Praxis badge",
                        "description" => null
                    ],
                    "blockcerts" => false,
                    "template_fields" => [],
                    "diploma_fields" => [
                        [
                            "id" => 5,
                            "name" => [
                                "da-DK" => "Kursusnummer",
                                "en-US" => "Course number",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ]
                    ],
                    "created_at" => "2020-10-14",
                    "updated_at" => "2023-04-27"
                ],
                [
                    "id" => "tc91e5dbff186177cc22a161dc7a2fb63f2063ccb",
                    "extra_name" => "Sample template without diploma field (should be valid)",
                    "default_language" => "da-DK",
                    "organization_id" => "o343e4d01a6f83d76d3818453637b3227417e10ba",
                    "name" => [
                        "da-DK" => "KURSUSTITEL",
                        "en-US" => "",
                    ],
                    "template_type" => "Kursusbevis",
                    "presentation_view" => 2,
                    "personal_identifier" => null,
                    "external_link" => null,
                    "public" => true,
                    "is_test" => false,
                    "description" => [
                        "da-DK" => "Dette er en beskrivelse af kurset. Det kan fx indeholde emner:<br />\r\n<ul>\r\n<li>Emne 1</li>\r\n<li>Emne 2</li>\r\n<li>Emne 3</li>\r\n</ul>",
                        "en-US" => null,
                    ],
                    "description_short" => [
                        "da-DK" => null,
                        "en-US" => null,
                    ],
                    "custom_designs" => [],
                    "badge" => [
                        "id" => 689,
                        "image_url" => "https://localhost/uploads/template_badges/f0d6f9c0c63995cd5468b6e0006ce077.png",
                        "name" => "Praxis badge",
                        "description" => null
                    ],
                    "blockcerts" => false,
                    "template_fields" => [],
                    "diploma_fields" => [],
                    "created_at" => "2020-10-14",
                    "updated_at" => "2023-04-27"
                ],
                [
                    "id" => "t4ab241160738670c7f4daaea97f33794e80567c9",
                    "extra_name" => "Template (should be invalid)",
                    "default_language" => "en-US",
                    "organization_id" => "o343e4d01a6f83d76d3818453637b3227417e10ba",
                    "name" => [
                        "da-DK" => "Test template DK",
                        "en-US" => "Test template",
                    ],
                    "template_type" => "Unspecified",
                    "presentation_view" => 2,
                    "personal_identifier" => null,
                    "external_link" => null,
                    "public" => true,
                    "is_test" => false,
                    "description" => [
                        "da-DK" => null,
                        "en-US" => null,
                    ],
                    "description_short" => [
                        "da-DK" => null,
                        "en-US" => null,
                    ],
                    "custom_designs" => [],
                    "badge" => [
                        "id" => 689,
                        "image_url" => "https://localhost/uploads/template_badges/f0d6f9c0c63995cd5468b6e0006ce077.png",
                        "name" => "Praxis badge",
                        "description" => null
                    ],
                    "blockcerts" => false,
                    "template_fields" => [],
                    "diploma_fields" => [
                        [
                            "id" => 5,
                            "name" => [
                                "da-DK" => "Kursusnummer",
                                "en-US" => "Course number",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ]
                    ],
                    "created_at" => "2020-12-15",
                    "updated_at" => "2023-04-27"
                ],
                [
                    "id" => "t236612ef24d8f9817536cebbd703335b9942c63f",
                    "extra_name" => "Template with the right fields for prod (should be valid)",
                    "default_language" => "da-DK",
                    "organization_id" => "o343e4d01a6f83d76d3818453637b3227417e10ba",
                    "name" => [
                        "da-DK" => "Test titel",
                        "en-US" => "Test title",
                    ],
                    "template_type" => "Uspecificeret",
                    "presentation_view" => 2,
                    "personal_identifier" => null,
                    "external_link" => null,
                    "public" => true,
                    "is_test" => false,
                    "description" => [
                        "da-DK" => "Test beskrivelse",
                        "en-US" => "Test description",
                    ],
                    "description_short" => [
                        "da-DK" => null,
                        "en-US" => null,
                    ],
                    "custom_designs" => [],
                    "badge" => [
                        "id" => 689,
                        "image_url" => "https://localhost/uploads/template_badges/f0d6f9c0c63995cd5468b6e0006ce077.png",
                        "name" => "Praxis badge",
                        "description" => null
                    ],
                    "blockcerts" => false,
                    "template_fields" => [],
                    "diploma_fields" => [
                        [
                            "id" => 305,
                            "name" => [
                                "da-DK" => "Kursusdato",
                                "en-US" => "Course date",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ],
                        [
                            "id" => 306,
                            "name" => [
                                "da-DK" => "Kursusperiode",
                                "en-US" => "Course period",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ],
                        [
                            "id" => 302,
                            "name" => [
                                "da-DK" => "Varighed",
                                "en-US" => "Duration",

                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ],
                        [
                            "id" => 304,
                            "name" => [
                                "da-DK" => "Underviser",
                                "en-US" => "Instructor",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ],
                        [
                            "id" => 303,
                            "name" => [
                                "da-DK" => "Sted",
                                "en-US" => "Location",
                            ],
                            "type" => "text",
                            "description" => [
                                "da-DK" => null,
                                "en-US" => null,
                            ]
                        ]
                    ],
                    "created_at" => "2021-01-21",
                    "updated_at" => "2023-04-27"
                ]
            ]
        ];
    }
}
