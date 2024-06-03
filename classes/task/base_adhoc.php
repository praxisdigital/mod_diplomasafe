<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     mod_diplomasafe
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_diplomasafe\task;

use core\task\adhoc_task;
use mod_diplomasafe\diagnostic\console;
use mod_diplomasafe\diagnostic\outputable;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

abstract class base_adhoc extends adhoc_task
{
    private ?array $data_array = null;
    protected ?outputable $output_emitter = null;

    protected function emitter(): outputable
    {
        return $this->output_emitter ??= new console();
    }

    protected function output(string $message): void
    {
        if (!$this->can_output()) {
            return;
        }
        $this->emitter()->output($message);
    }

    protected function can_output(): bool
    {
        return $this->get_custom_data_array()['output'] ?? true;
    }

    protected function get_custom_data_array(): array
    {
        if ($this->data_array === null) {
            try {
                $this->data_array = json_decode(
                    $this->get_custom_data_as_string(),
                    true
                );
            } catch (\Exception) {
                $this->data_array = [];
            }
        }

        return $this->data_array;
    }


    public function set_output_emitter(outputable $emitter): void
    {
        $this->output_emitter = $emitter;
    }
}
