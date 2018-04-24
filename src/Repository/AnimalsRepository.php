<?php

namespace App\Repository;

use App\Entity\Animals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Animals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animals[]    findAll()
 * @method Animals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Animals::class);
    }

    public function addAnimal($animal)
    {
        $em = $this->getEntityManager();
        try {
            $em->persist($animal);
            $em->flush();
        } catch (OptimisticLockException $e) {
            return $e;

        } catch( \PDOException $e ) {
            return $e;

        } catch (ORMException $e) {
            return $e;
        }
        return null;
    }

    public function findByOwner($user): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.owner = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult();
    }

    public function remove($id)
    {
        try{
            $this->createQueryBuilder('a')
                ->delete()
                ->where("a.id = :id")
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
        }catch (ForeignKeyConstraintViolationException  $exception){
            return 'Animal has appointments arranged';
        }
    }

    public function findById($idAnimal)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $idAnimal)
            ->getQuery()
            ->getResult();
    }
}