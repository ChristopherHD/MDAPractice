<?php
namespace App\Controller;


use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use App\Services\AppointmentsGenerator;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PatientController extends Controller
{

	public function index(AppointmentsRepository $ur)
	{
		
        $appointments = $ur->findByPatientId($this->getUser()->getId());
        return $this->render('appointments_patient.html.twig', array(
            'appointments' => $appointments));
	}
    public function addAppointment(Request $request, AppointmentsRepository $ar, AppointmentsGenerator $ag, UsersRepository $ur)
    {
		$userId = $this->getUser();
		$doctor  = $ur->findById(25);
        $date=$ag->generate();
        if(isset($date)){
			$date = $date;
			$appointment=new Appointments($userId,$doctor,$date);
            $ar->addAppointment($appointment);
            return $this->redirectToRoute('index');
        }else{
            //generate appointment (Especialidad, Rango)
            
			return $this->render('addAppointment.html.twig', array('date' => $date->format('Y-m-d H')));
        }

    }
}