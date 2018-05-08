<?php

namespace App\Repository;

use App\Entity\Appointments;
use App\Entity\Doctors;
use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recipes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipes[]    findAll()
 * @method Recipes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipes::class);
    }
    /**
     * @return Recipes[]
     */
	public function findByPatientId($id): array
    {
		return $this->createQueryBuilder('r')
				->join("r.doctor", "u")
				->addSelect("u")
				->where("r.patient = :id")
				->setParameter('id', $id)
                ->getQuery()
                ->getResult();
    }
    /**
     * @return Recipes[]
     */
	public function findByDoctorId($id): array
    {
		return $this->createQueryBuilder('r')
				->join("r.patient", "u")
				->addSelect("u")
				->where("r.doctor = :id")
				->setParameter('id', $id)
                ->getQuery()
                ->getResult();
    }
	public function remove($id)
	{
		return $this->createQueryBuilder('r')
				->delete()
				->where("r.id = :id")
				->setParameter('id', $id)
                ->getQuery()
				->execute();
	}
	public function findByDate($date)
	{
		
		return $this->createQueryBuilder('r')
				->addSelect("r")
				->where("r.date = :date")
				->setParameter('date', $date)
                ->getQuery()
                ->getArrayResult();
	}
    public function findByDateAndDoctor($date,?Doctors $doctor)
    {

        return $this->createQueryBuilder('r')
            ->addSelect("r")
            ->where("r.doctor = :doctor")
            ->andWhere("r.date = :date")
            ->setParameter('date', $date)
            ->setParameter('doctor', $doctor->getDni())
            ->getQuery()
            ->getArrayResult();
    }

    public function addRecipe(?Recipes $recipe)
    {
        $em = $this->getEntityManager();
        try {
            $em->persist($recipe);
            $em->flush();
        } catch (OptimisticLockException $e) {
            return $e;

        } catch(UniqueConstraintViolationException $e){
            return 'Duplicated Recipe';
        } catch (ORMException $e) {
            return $e;
        } catch( \PDOException $e )
        {
        return $e;
        }
        return null;
    }
	
}