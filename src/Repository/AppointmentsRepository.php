<?php

namespace App\Repository;

use App\Entity\Appointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Appointments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointments[]    findAll()
 * @method Appointments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Appointments::class);
    }

	public function findByPatientId($id): array
    {
		return $this->createQueryBuilder('a')
				->join("a.doctor", "u")
				->addSelect("u")
				->where("a.patient = :id")
				->setParameter('id', $id)
                ->getQuery()
                ->getArrayResult();
    }
		
	public function findByDoctorId($id): array
    {
		return $this->createQueryBuilder('a')
				->join("a.patient", "u")
				->addSelect("u")
				->where("a.doctor = :id")
				->setParameter('id', $id)
                ->getQuery()
                ->getArrayResult();
    }
	public function remove($id)
	{
		return $this->createQueryBuilder('a')
				->delete()
				->where("a.id = :id")
				->setParameter('id', $id)
                ->getQuery()
				->execute();
	}
	public function findByDate($date)
	{
		
		return $this->createQueryBuilder('a')
				->addSelect("a")
				->where("a.date = :date")
				->setParameter('date', $date)
                ->getQuery()
                ->getArrayResult();
	}
    public function addAppointment(?Appointments $appointment)
    {
        $em = $this->getEntityManager();
        try {
            $em->persist($appointment);
            $em->flush();
        } catch (OptimisticLockException $e) {
            return $e;

        } catch(UniqueConstraintViolationException $e){
            return 'Duplicated Appointment';
        } catch (ORMException $e) {
            return $e;
        } catch( \PDOException $e )
        {
        return $e;
        }
        return null;
    }
	
}