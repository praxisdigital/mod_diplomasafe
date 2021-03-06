<?php
/**
 * @developer   Johnny Drud
 * @date        25-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\config;
use mod_diplomasafe\exceptions\base_url_not_set;
use mod_diplomasafe\exceptions\current_environment_invalid;
use mod_diplomasafe\exceptions\current_environment_not_set;
use mod_diplomasafe\exceptions\personal_access_token_not_set;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\languages\mapper;
use mod_diplomasafe\languages\repository;

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_integration_languages_testcase extends advanced_testcase
{
    /**
     * @var mapper
     */
    private $languages_mapper;

    /**
     * @var repository
     */
    private $languages_repo;

    /**
     * @return void
     */
    public function setUp(): void {
        $this->languages_mapper = language_factory::get_mapper();
        $this->languages_repo = language_factory::get_repository();
    }

    /**
     * @test
     *
     * @throws dml_exception
     */
    public function can_add_language() : void {

        $this->resetAfterTest();

        $insert_id = $this->languages_mapper->create('en-US');
        $created_language = $this->languages_repo->get_by_id($insert_id);

        self::assertEquals('en-US', $created_language->name);
    }
}
