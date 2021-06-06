<?php

namespace App\Controller;

use App\Entity\Language;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

abstract class AbstractCrudController extends AbstractController
{
	/**
	 * Entity FQCN
	 *
	 * @return string
	 */
	abstract protected function getEntityNamespace(): string;

	/**
	 * @param Request $request
	 * @Route("", methods={"GET"})
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$result = $this->getDoctrine()->getRepository($this->getEntityNamespace())->findAll();

		return $this->serilalizeResponse($result);
	}

	/**
	 * @Route("", methods={"POST"})
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function add(Request $request)
	{
		$entity = $this->deserialize($request);

		$manager = $this->getDoctrine()->getManager();
		$manager->persist($entity);
		$manager->flush();

		return $this->serilalizeResponse($entity);
	}

	/**
	 * @Route("/{id<\d+>}", methods={"DELETE"})
	 *
	 * @param int $id
	 * @return Response
	 */
	public function delete(int $id)
	{
		$language = $this->getDoctrine()->getRepository($this->getEntityNamespace())->find($id);

		if (!$language) {
			throw new NotFoundHttpException();
		}

		$manager = $this->getDoctrine()->getManager();
		$manager->remove($language);
		$manager->flush();

		return new Response(null, 204);
	}

	protected function deserialize(Request $request)
	{
		return $this->serializer->deserialize($request->getContent(), $this->getEntityNamespace(), 'json');
	}
}
