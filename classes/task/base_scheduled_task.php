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
use core\task\manager;
use core\task\scheduled_task;
use mod_diplomasafe\diagnostic\console;
use mod_diplomasafe\diagnostic\outputable;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();
// @codeCoverageIgnoreEnd

abstract class base_scheduled_task extends scheduled_task
{
    protected ?outputable $output_emitter = null;

    protected function emitter(): outputable
    {
        return $this->output_emitter ??= new console();
    }

    protected function output(string $message): void
    {
        $this->emitter()->output($message);
    }

    protected function enqueue_adhoc_task(adhoc_task $task, bool $no_duplicate = true): void
    {
        manager::queue_adhoc_task($task, $no_duplicate);
    }
}
