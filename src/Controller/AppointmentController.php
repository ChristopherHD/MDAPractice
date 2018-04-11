<?php
namespace App\Controller;


use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use App\Services\AppointmentsGenerator;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppointmentController extends Controller
{
	public function __construct(AppointmentsRepository $ar)
    {
        $this->ar= $ar;

    }
	public function getAppointments()
	{
		if($this->isGranted('ROLE_USER')){
            $appointments = $this->ar->findByPatientId($this->getUser()->getId());
        }else if ($this->isGranted('ROLE_DOC')){
			$appointments = $this->ar->findByDoctorId($this->getUser()->getId());
		}
        return $this->render('getAppointments.html.twig', array(
            'appointments' => $appointments));
	}
	
	public function generateAppointment(Request $request,  AppointmentsGenerator $ag)
    {
        $date=$ag->generate();
        if(isset($date)){
			$date = $date;
            return $this->render('addAppointment.html.twig', array('date' => $date));
        }else{
            //generate appointment (Especialidad, Rango)
            
			return $this->redirectToRoute('index');
        }
    }
	public function persistAppointment(Request $request, UsersRepository $ur)
	{
		$userId = $this->getUser();
		$doctor  = $ur->findById(25);
		$date = new \DateTime($request->get('date')) ;	
		
		$appointment=new Appointments($userId,$doctor,$date);
		$this->ar->addAppointment($appointment);
		return $this->redirectToRoute('index');
	}
	
	public function removeAppointment(Request $request)
	{
		$appointmentId = $request->get('id');
		$this ->ar->remove($appointmentId);
		return $this->redirectToRoute('appointments');
	}
	
	
}