<?php
namespace App\Controller;


use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PatientController extends Controller
{

	public function index(UsersRepository $ur)
	{
		
        $appointments = $ur->findByMedicList($this->getUser()->getId());
        return $this->render('appointments_patient.html.twig', array(
            'appointments' => $appointments));
	}
	


}