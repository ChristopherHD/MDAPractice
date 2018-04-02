<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Users[]    findByMedicList(id $id)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

//    /**
//     * @return Users[] Returns an array of Users objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByDni($value): ?Users
    {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.dni = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

	 public function findByMedicList($id): array
    {
		$conn = $this->getEntityManager()->getConnection();
		$sql = '
			SELECT * FROM `users` 
			JOIN `appointments` 
			ON users.id = appointments.doctor 
			WHERE appointments.patient = :id
			';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':id' => $id]);
		return $stmt->fetchAll();
		
		/*$em = $this->getEntityManager();
		$query = $em->createQuery("SELECT a FROM App\Entity\Users u, App\Entity\Appointments a WHERE u.id = ?1 and a.patient = ?1")->setParameter('1', $id);
		return $query->execute();*/
    }
	
    public function findByApiKey($value): ?Users
    {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.key = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
    public function addUser(?Users $user)
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
}
