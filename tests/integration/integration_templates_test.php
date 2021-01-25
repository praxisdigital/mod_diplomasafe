<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

use mod_diplomasafe\entities\template;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\templates\mapper;
use mod_diplomasafe\templates\repository;

/**
 * Class
 *
 * @package mod_diplomasafe\tests
 */
class mod_diplomasafe_integration_templates_testcase extends advanced_testcase
{
    /**
     * @var mapper
     */
    private $templates_mapper;

    /**
     * @var repository
     */
    private $templates_repo;

    /**
     * @return void
     */
    public function setUp(): void {
        $this->templates_mapper = template_factory::get_mapper();
        $this->templates_repo = template_factory::get_repository();
    }

    /**
     * @return int
     * @throws dml_exception
     */
    private function add_template() : int {
        return $this->templates_mapper->create(new template([
            'organisation_id' => 'o343e4d01a6f83d76d3818453637b3227417e10ba',
            'default_language_id' => 2,
            'idnumber' => 't498c1434976b8b05659ff5654b3403d3af4672bd',
            'name' => 'Test template',
            'is_valid' => true
        ]));
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function can_add_template() : void {

        $this->resetAfterTest();

        $insert_id = $this->add_template();

        $created_template = $this->templates_repo->get_by_id($insert_id);

        self::assertTrue($created_template->exists());
    }

    /**
     * @test
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function can_update_template() : void {

        $this->resetAfterTest();

        $insert_id = $this->add_template();

        $template = $this->templates_repo->get_by_id($insert_id);
        $other_template_name = 'Other template name';
        $template->name = $other_template_name;
        $this->templates_mapper->update($template);

        $template = $this->templates_repo->get_by_id($insert_id);

        self::assertEquals($other_template_name, $template->name);
    }

    /**
     * @test
     *
     * @throws dml_exception
     */
    public function can_get_templates_list() : void {

        $this->resetAfterTest();

        $this->add_template();
        $this->add_template();

        $templates = $this->templates_repo->get_all();

        self::assertCount(2, $templates);
    }
}
