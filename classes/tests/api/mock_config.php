<?php

namespace mod_diplomasafe\tests\api;

use ArrayAccess;
use mod_diplomasafe\config;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class mock_config extends config implements ArrayAccess
{
    protected function validate_config(object $config): object
    {
        return $config;
    }

    protected function has_environment(object $config): void
    {
    }

    protected function has_base_url(object $config, string $environment): void
    {
    }

    protected function has_personal_access_token(object $config, string $environment): void
    {
    }

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this->config, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->config->{$offset} ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->config->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->config->{$offset});
    }
}
