<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

abstract class AbstractTestCase extends ApiTestCase
{
	protected function apiCall(string $method, string $url, array $options = [])
	{
		$response = static::createClient()->request($method, $url, $options);

		$this->assertResponseIsSuccessful();
		$this->assertJson($response->getContent());

		return json_decode($response->getContent(), true);
	}
}
