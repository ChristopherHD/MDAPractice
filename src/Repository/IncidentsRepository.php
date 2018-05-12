<?php

namespace App\Repository;

use App\Entity\Incidents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incidents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidents[]    findAll()
 * @method Incidents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incidents::class);
    }

    public function addIncident($incident)
    {
        $em = $this->getEntityManager();
        try {
            $em->persist($incident);
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

//    /**
//     * @return Doctors[] Returns an array of Doctors objects
//     */
    
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
	
    public function findByState(int $state): array
    {
        return $this->createQueryBuilder('i')
			->andWhere('i.isClosed = :val')
			->setParameter('val', $state)
            ->orderBy('i.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function changeState(int $id, int $state): int
    {
        return $this->createQueryBuilder('i')
			->update()
			->set('i.isClosed',':state')
			->andWhere('i.id = :val')
			->setParameter('val', $id)
			->setParameter('state', $state)
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?Doctors
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}