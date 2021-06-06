<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

	/**
	 * @param int    $langId
	 * @param string $key
	 * @return Translation
	 */
	public function findByLangIdAndKey(int $langId, string $key)
	{
		return $this->findOneBy(['language' => $this->getEntityManager()->getReference(Language::class, $langId), 'key' => $key]);
	}
}
