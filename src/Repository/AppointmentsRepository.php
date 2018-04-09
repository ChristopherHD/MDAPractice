<?php

namespace App\Repository;

use App\Entity\Appointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
		
	public function findByMedicId($id): array
    {
		return $this->createQueryBuilder('a')
				->join("a.patient", "u")
				->addSelect("u")
				->where("a.doctor = :id")
				->setParameter('id', $id)
                ->getQuery()
                ->getArrayResult();
    }
	
}