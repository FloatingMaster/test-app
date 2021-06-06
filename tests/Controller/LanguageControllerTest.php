<?php

namespace App\Tests\Controller;

use App\Tests\AbstractTestCase;

class LanguageControllerTest extends AbstractTestCase
{
	public function testAdd()
	{
		$response = $this->apiCall('POST', '/language', ['body' => '{"name":"en"}']);
		
		$this->assertArraySubset(['name' => 'en'], $response);
		$this->assertArrayHasKey('id', $response);
		$this->assertIsNumeric($response['id']);

		return $response['id'];
	}

	/**
	 * @depends testAdd
	 */
	public function testIndex($id)
	{
		$response = $this->apiCall('GET', '/language');

		$this->assertCount(1, $response);

		$lang = reset($response);
		$this->assertArraySubset(['id' => $id, 'name' => 'en'], $lang);
	}

	/**
	 * @depends testAdd
	 */
	public function testDelete($id)
	{
		$response = static::createClient()->request('DELETE', "/language/{$id}");
		$this->assertResponseStatusCodeSame(204);

		$response = $this->apiCall('GET', "/language");
		$this->assertEquals([], $response);
	}
}
