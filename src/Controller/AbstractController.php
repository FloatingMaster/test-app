<?php

namespace App\Controller;

use JMS\Serializer\Serializer;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractController extends BaseController
{
	protected Serializer $serializer;

	public function __construct(Serializer $serializer)
	{
		$this->serializer = $serializer;
	}

	protected function serilalizeResponse($data)
	{
		return JsonResponse::fromJsonString($this->serializer->serialize($data, 'json'));
	}
}
