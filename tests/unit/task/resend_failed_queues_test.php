<?php

namespace mod_diplomasafe\unit\task;

use core\task\adhoc_task;
use mod_diplomasafe\collections\queue_items;
use mod_diplomasafe\diagnostic\outputable;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\queue\repository;
use mod_diplomasafe\task\resend_failed_queues;
use mod_diplomasafe\tests\unit_testcase;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class resend_failed_queues_test extends unit_testcase
{
    private function create_schedule_task(
        ?outputable $output = null,
        ?repository $queue_repo = null
    ): resend_failed_queues {
        $task = new class() extends resend_failed_queues {
            public function set_emitter(?outputable $emitter): void
            {
                $this->output_emitter = $emitter;
            }

            public function set_queue_repository(?repository $repo): void
            {
                $this->repo = $repo;
            }

            protected function enqueue_adhoc_task(adhoc_task $task, bool $no_duplicate = true): void
            {
            }
        };

        $task->set_emitter($output);
        $task->set_queue_repository($queue_repo);

        return $task;
    }

    private function queue_item(array $record = []): queue_item
    {
        $current_time = time();
        $record['id'] ??= 1;
        $record['template_id'] ??= 1;
        $record['language_id'] ??= 1;
        $record['course_id'] ??= 1;
        $record['module_instance_id'] ??= 1;
        $record['user_id'] ??= 1;
        $record['status'] ??= queue_item::QUEUE_ITEM_STATUS_PENDING;
        $record['message'] ??= '';
        $record['time_created'] ??= $current_time;
        $record['time_modified'] ??= $current_time;
        $record['time_modified'] ??= $current_time;
        $record['last_run'] ??= $current_time;
        $record['last_mail_sent'] ??= $current_time;


        return new queue_item($record);
    }

    public function test_execute_with_no_failed_queue_expected_not_to_run(): void
    {
        $items = [];

        $repo = $this->createMock(repository::class);
        $repo->method('get_failed_items')
            ->willReturn(new queue_items($items));

        $invoke_index = 0;
        $expected_messages = [
            'Resending failed queues',
            'Found 0 failed items',
            'Exiting, no failed items found'
        ];

        $output = $this->createMock(outputable::class);
        $output->method('output')
            ->willReturnCallback(function ($message) use (&$invoke_index, &$expected_messages) {
                $this->assertEquals($expected_messages[$invoke_index], $message);
                $invoke_index++;
            });

        $task = $this->create_schedule_task(
            output: $output,
            queue_repo: $repo
        );
        $task->execute();
    }

    public function test_execute_with_failed_queue_expected_to_run(): void
    {
        $items = [
            $this->queue_item([
                'id' => 1,
                'status' => queue_item::QUEUE_ITEM_STATUS_FAILED
            ]),
            $this->queue_item([
                'id' => 2,
                'status' => queue_item::QUEUE_ITEM_STATUS_SUCCESSFUL
            ])
        ];

        $repo = $this->createMock(repository::class);
        $repo->method('get_failed_items')
            ->willReturnCallback(function () use ($items) {
                $failed_items = array_filter(
                    $items,
                    fn($item) => $item->status === queue_item::QUEUE_ITEM_STATUS_FAILED
                );
                return new queue_items($failed_items);
            });

        $output = $this->createMock(outputable::class);
        $output->method('output')
            ->withConsecutive(
                ['Resending failed queues'],
                ['Found 1 failed items'],
                ['Done, all resend tasks has been added to the adhoc task queue']
            );

        $task = $this->create_schedule_task(
            output: $output,
            queue_repo: $repo
        );
        $task->execute();
    }
}
