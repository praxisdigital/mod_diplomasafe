<?php
/**
 * @developer   Johnny Drud
 * @date        05-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

$messageproviders = [
    'api_error' => [
        'defaults' => [
            'popup' => MESSAGE_DISALLOWED,
            'email' => MESSAGE_FORCED
        ]
    ],
];
