<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\integration;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

use dml_exception;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\languages\mapper;
use mod_diplomasafe\languages\repository;
use mod_diplomasafe\tests\integration_testcase;

/**
 * Class
 * @package mod_diplomasafe\tests
 */
class languages_test extends integration_testcase
{
    private mapper $languages_mapper;
    private repository $languages_repo;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->languages_mapper = language_factory::get_mapper();
        $this->languages_repo = language_factory::get_repository();
    }

    /**
     * @test
     * @throws dml_exception
     */
    public function can_add_language(): void
    {
        $insert_id = $this->languages_mapper->create('en-US');
        $created_language = $this->languages_repo->get_by_id($insert_id);

        self::assertEquals('en-US', $created_language->name);
    }
}
