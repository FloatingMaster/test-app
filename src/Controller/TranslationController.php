<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Translation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/translation/{langId}")
 */
class TranslationController extends AbstractCrudController
{
	protected function getEntityNamespace(): string
	{
		return Translation::class;
	}

	/**
	 * @param Request $request
	 * @Route("", methods={"GET"})
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$result = $this->getDoctrine()->getRepository($this->getEntityNamespace())->findBy(['language' => $request->attributes->get('langId')]);

		return $this->serilalizeResponse($result);
	}

	/**
	 * @Route("/{key}", methods={"GET"})
	 */
	public function getTranslation(Request $request)
	{
		$translation = $this->getDoctrine()->getRepository(Translation::class)->findByLangIdAndKey(
			$request->attributes->get('langId'),
			$request->attributes->get('key'),
		);

		if (!$translation) {
			throw new NotFoundHttpException();
		}

		return $this->serilalizeResponse($translation);
	}

	protected function deserialize(Request $request)
	{
		/**
		 * @var Translation $entity
		 */
		$entity = parent::deserialize($request);
		$entity->setLanguage($this->getDoctrine()->getManager()->getReference(Language::class, $request->attributes->get('langId')));

		return $entity;
	}
}
