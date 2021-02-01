<?php
/**
 * @developer   Johnny Drud
 * @date        29-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

$functions = [
    'mod_diplomasafe_get_templates' => [
        'classname'     => \mod_diplomasafe\external\get_templates::class,
        'methodname'    => 'get_templates',
        'description'   => 'Returns a list of all available templates matching the language provided',
        'type'          => 'read',
        'ajax'          => true,
    ]
];

/**
 * Here we define the services to install as pre-build services.
 * A pre-build service is not editable by administrator.
 *
 * NOTE: Services are available to all users!!!
 */
$services = [
    'Get templates' => [
        'functions' => ['mod_diplomasafe_get_templates'],
        'restrictedusers' => 0,
        'enabled' => 1,
    ]
];
