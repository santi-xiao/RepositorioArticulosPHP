<?php

namespace App\Repository;

use App\Entity\Articulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;


/**
 * @method Articulo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articulo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articulo[]    findAll()
 * @method Articulo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticuloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articulo::class);
    }

    public function findAllCategorias(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.categoria
            FROM App\Entity\Articulo p
            ORDER BY p.categoria ASC'
        );

        return $query->getResult();
    }

    public function findAllArticulosOfCategoria(string $categoria): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Articulo p
            WHERE p.categoria = :categoria
            ORDER BY p.titulo ASC'
        )->setParameter('categoria', $categoria);

        return $query->getResult();
    }
}
