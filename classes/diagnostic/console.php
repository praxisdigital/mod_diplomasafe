<?php

namespace mod_diplomasafe\diagnostic;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();
// @codeCoverageIgnoreEnd

class console implements outputable
{
    public function output(string $message): void
    {
        mtrace($message);
    }
}
