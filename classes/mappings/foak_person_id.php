<?php

namespace mod_diplomasafe\mappings;

use mod_diplomasafe\contracts\mapping_interface;
use mod_diplomasafe\mapping;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();
// @codeCoverageIgnoreEnd

class foak_person_id extends mapping implements mapping_interface
{
    public const FIELD_NAME = mapping::FOAK_PERSON_ID;

    public function get_value(): string
    {
        return $this->user->idnumber ?? '';
    }

    protected function get_field_name(): string
    {
        return self::FIELD_NAME;
    }
}
