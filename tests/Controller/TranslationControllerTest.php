<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use App\Entity\Language;
use App\Tests\AbstractTestCase;

class TranslationControllerTest extends AbstractTestCase
{
	private static int $langId;

	public static function setUpBeforeClass(): void
	{
		$manager = self::getContainer()->get('doctrine')->getManager();

		$language = (new Language())
			->setName('rus');

		$manager->persist($language);
		$manager->flush();

		self::$langId = $language->getId();

		parent::setUpBeforeClass();
	}

	public function testAdd()
	{
		$langId = self::$langId;
		$response = $this->apiCall('POST', "/translation/{$langId}", ['body' => '{"key": "asd", "value": "dsa"}']);

		$this->assertArraySubset(['key' => 'asd', 'value' => 'dsa'], $response);
		$this->assertArrayHasKey('id', $response);
		$this->assertIsNumeric($response['id']);

		return $response['id'];
	}

	/**
	 * @depends testAdd
	 */
	public function testIndex($id)
	{
		$langId = self::$langId;
		$response = $this->apiCall('GET', "/translation/{$langId}");

		$this->assertCount(1, $response);

		$lang = reset($response);
		$this->assertArraySubset(['key' => 'asd', 'value' => 'dsa'], $lang);
	}

	/**
	 * @depends testAdd
	 */
	public function testGetTranslation()
	{
		$langId = self::$langId;
		$response = $this->apiCall('GET', "/translation/{$langId}/asd");

		$this->assertArraySubset(['key' => 'asd', 'value' => 'dsa'], $response);
	}

	/**
	 * @depends testAdd
	 */
	public function testDelete($id)
	{
		$langId = self::$langId;
		$response = static::createClient()->request('DELETE', "/translation/{$langId}/{$id}");
		$this->assertResponseStatusCodeSame(204);

		$response = $this->apiCall('GET', "/translation/{$langId}");
		$this->assertEquals([], $response);
	}
}
