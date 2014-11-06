<?php

use Pingpong\Modules\Finder;
use Pingpong\Modules\Repository;

class RepositoryTest extends \PHPUnit_Framework_TestCase {

	protected $repository;

	public function setUp()
	{
		$this->repository = new Repository($this->getPath());	
	}

	public function tearDown()
	{
		$this->repository->enable('blog');
	}

	protected function getPath()
	{
		return __DIR__ . '/../fixture/Modules';
	}

	public function testGetAll()
	{
		$this->assertTrue(is_array($m = $this->repository->all()));
		$this->assertArrayHasKey(0, $m);
	}

	public function testGetEnabled()
	{
		$this->repository->enable($m = 'blog');
		$this->assertTrue(is_array($m = $this->repository->enabled()));
		$this->assertArrayHasKey(0, $m);
	}

	public function testGetDisabled()
	{
		$this->assertTrue(is_array($m = $this->repository->disabled()));
		$this->assertArrayNotHasKey(0, $m);
	}

	public function testEnableModule()
	{
		$this->repository->enable($m = 'blog');
		$this->assertTrue($this->repository->active($m));
	}

	public function testDisableModule()
	{
		$this->repository->disable($m = 'blog');
		$this->assertFalse($this->repository->active($m));	
	}

	public function innstallAndUpdateModule()
	{
		$module = 'pingpong-modules/Admin';
		$this->repository->install($module);
		$this->repository->update($module);
	}

	public function testGetAsset()
	{
		$actual = $this->repository->asset('blog:img/post.img');
		$this->assertEquals('http://localhost/modules/blog/img/post.img', $actual);
	}

	public function testGetStyle()
	{
		$actual = $this->repository->style('blog:css/main.css');
		$this->assertEquals('<link media="all" type="text/css" rel="stylesheet" href="http://localhost/modules/blog/css/main.css">' . PHP_EOL, $actual);
	}

	public function testGetScript()
	{
		$actual = $this->repository->script('blog:js/all.js');
		$this->assertEquals('<script src="http://localhost/modules/blog/js/all.js"></script>' . PHP_EOL, $actual);
	}

}