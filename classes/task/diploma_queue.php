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

use mod_diplomasafe\admin_task_mailer;
use mod_diplomasafe\diplomas\api\mapper as api_mapper;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\entities\language;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\languages\repository as language_repository;
use mod_diplomasafe\queue\mapper as queue_mapper;
use mod_diplomasafe\queue\repository as queue_repository;
use mod_diplomasafe\templates\repository as template_repository;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class diploma_queue extends base_adhoc
{
    private ?language_repository $language_repo = null;
    private ?queue_mapper $queue_mapper = null;
    private ?queue_repository $queue_repo = null;
    private ?template_repository $template_repo = null;
    private ?api_mapper $diploma_api_mapper = null;

    private function get_queue_id(): int
    {
        return $this->get_custom_data_array()['queue_id'] ?? 0;
    }

    private function get_queue(): ?queue_item
    {
        $queue_id = $this->get_queue_id();
        if ($queue_id === 0) {
            return null;
        }

        return $this->queue_repository()->get_by_id($queue_id);
    }

    private function set_status(queue_item $item, int $status, string $message = ''): void
    {
        $item->status = $status;
        $item->message = $message;
        $item->last_run = time();
        if ($status === queue_item::QUEUE_ITEM_STATUS_FAILED) {
            $item->last_mail_sent = time();
        }
        $this->queue_mapper()->update($item);
    }

    private function output_successful_queue(queue_item $queue_item): void
    {
        $message = get_string('message_diploma_created_successfully', 'mod_diplomasafe', [
            'course_id' => $queue_item->course_id,
            'module_instance_id' => $queue_item->module_instance_id,
            'user_id' => $queue_item->user_id,
        ]);
        $this->output($message);
    }

    private function handle_failed_queue(?queue_item $queue_item, \Exception $exception): void
    {
        if ($queue_item === null) {
            return;
        }

        $message = get_string('message_diploma_created_failure', 'mod_diplomasafe', [
            'course_id' => $queue_item->course_id,
            'module_instance_id' => $queue_item->module_instance_id,
            'user_id' => $queue_item->user_id,
            'error' => $exception->getMessage()
        ]);
        $this->output($message);
        $this->mailer($queue_item->course_id)->send_to_all($exception->getMessage());
        $this->set_status(
            $queue_item,
            queue_item::QUEUE_ITEM_STATUS_FAILED,
            $exception->getMessage()
        );
    }

    private function get_template_by_queue(queue_item $queue): template
    {
        return $this->template_repository()->get_by_id($queue->template_id);
    }

    private function get_template_language(template $template): language
    {
        return $this->language_repository()->get_by_id($template->default_language_id);
    }

    private function create_diploma(
        template $template,
        queue_item $queue,
        language $lang
    ): void
    {
        $diploma = new diploma([
            'template' => $template,
            'course_id' => $queue->course_id,
            'module_instance_id' => $queue->module_instance_id,
            'user_id' => $queue->user_id,
            'issue_date' => date('Y-m-d'),
            'language' => $lang
        ]);

        $diploma_mapper = diploma_factory::get_api_mapper();
        $diploma_mapper->create($diploma);

        $this->diploma_api_mapper()->create($diploma);
    }

    protected function mailer(int $course_id): admin_task_mailer
    {
        return new admin_task_mailer($course_id);
    }

    protected function queue_mapper(): queue_mapper
    {
        return $this->queue_mapper ??= queue_factory::get_queue_mapper();
    }

    protected function queue_repository(): queue_repository
    {
        return $this->queue_repo ??= queue_factory::get_queue_repository();
    }

    protected function language_repository(): language_repository
    {
        return $this->language_repo ??= language_factory::get_repository();
    }

    protected function template_repository(): template_repository
    {
        return $this->template_repo ??= template_factory::get_repository();
    }

    protected function diploma_api_mapper(): api_mapper
    {
        return $this->diploma_api_mapper ??= diploma_factory::get_api_mapper();
    }

    public function execute(): void
    {
        $queue_id = $this->get_queue_id();
        if ($queue_id === 0) {
            return;
        }

        $queue_item = null;

        try {
            $queue_item = $this->get_queue();
            $template = $this->get_template_by_queue($queue_item);
            $lang = $this->get_template_language($template);

            $this->create_diploma(
                $template,
                $queue_item,
                $lang
            );

            $this->set_status($queue_item, queue_item::QUEUE_ITEM_STATUS_SUCCESSFUL);
            $this->output_successful_queue($queue_item);

        } catch (\Exception $e) {
            $this->handle_failed_queue($queue_item, $e);
        }
    }

    public static function create_by_queue_id(
        int $id,
        bool $output = true
    ): static
    {
        $task = new static();

        $task->set_custom_data([
            'queue_id' => $id,
            'output' => $output
        ]);

        return $task;
    }
}
