<?php

namespace App\Repository;

use App\Entity\Doctors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Doctors|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctors|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctors[]    findAll()
 * @method Doctors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Doctors::class);
    }

    public function findByDni($value): ?Doctors
    {
        try {
            return $this->createQueryBuilder('d')
                ->andWhere('d.dni = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

	public function findBySpecialty($value): ?array
    {
		return $this->createQueryBuilder('d')
			->andWhere('d.specialty = :val')
			->setParameter('val', $value)
			->getQuery()
			->getResult();
    }

    public function addUser(?Doctors $user)
    {
        $em = $this->getEntityManager();
        try {
            $em->persist($user);
            $em->flush();
        } catch (OptimisticLockException $e) {
            return $e;

        } catch( \PDOException $e ) {
            return $e;

        } catch(UniqueConstraintViolationException $e){
            return 'Duplicated User';
        } catch (ORMException $e) {
            return $e;
        }
        return null;
    }

    public function findByOptions($specialty=null): ?array
    {
        if(isset($specialty)){
            return $this->findBySpecialty($specialty);
        }
        else{
            return $this->findAll();
        }
    }
//    /**
//     * @return Doctors[] Returns an array of Doctors objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

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
