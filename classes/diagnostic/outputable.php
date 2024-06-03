<?php

namespace mod_diplomasafe\diagnostic;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();
// @codeCoverageIgnoreEnd

interface outputable
{
    public function output(string $message): void;
}
