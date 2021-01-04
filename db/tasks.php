<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

$tasks = [
    [
        'classname' => 'mod_diplomasafe\task\courses_completed_create_diplomas',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '0',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*',
        'disabled' => 0
    ],
    [
        'classname' => 'mod_diplomasafe\task\store_diploma_templates',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '0',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*',
        'disabled' => 0
    ]
];
