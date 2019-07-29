<?php

namespace App\Repository;

use App\Entity\EasterEgg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EasterEgg|null find($id, $lockMode = null, $lockVersion = null)
 * @method EasterEgg|null findOneBy(array $criteria, array $orderBy = null)
 * @method EasterEgg[]    findAll()
 * @method EasterEgg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EasterEggRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EasterEgg::class);
    }

    public function findLastEasterEgg()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.addDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
