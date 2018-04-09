<?php
namespace App\Controller;


use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PatientController extends Controller
{

	public function index(UsersRepository $ur)
	{
		
        $appointments = $ur->findByMedicList($this->getUser()->getId());
        return $this->render('appointments_patient.html.twig', array(
            'appointments' => $appointments));
	}
    public function addAppointment(Request $request, AppointmentsRepository $ar)
    {
        $date = $request->get('date');
        $doctor = $request->get('doctor');
        $userId = $this->getUser()->getId();

        if(isset($date)){
            $ar->addAppointment(new Appointments($userId,$doctor,$date));
            return $this->redirectToRoute('index');
        }else{

            //generate appointment (Especialidad, Rango)
            return $this->render('addAppointment.html.twig');
        }

    }
}