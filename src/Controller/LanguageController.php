<?php

namespace App\Controller;

use App\Entity\Language;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/language")
 */
class LanguageController extends AbstractCrudController
{
	protected function getEntityNamespace(): string
	{
		return Language::class;
	}
}
