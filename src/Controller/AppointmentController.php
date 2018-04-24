<?php
namespace App\Controller;



use App\Repository\AnimalsRepository;
use App\Repository\AppointmentsRepository;
use App\Services\AppointmentsGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AppointmentController extends Controller
{
    private $ar;
    private $logger;
	public function __construct(AppointmentsRepository $ar, LoggerInterface $logger)
    {
        $this->ar= $ar;
        $this->logger=$logger;

    }
	public function getAppointments()
	{
		if($this->isGranted('ROLE_USER')){
            $appointments = $this->ar->findByPatientId($this->getUser()->getId());
        }else if ($this->isGranted('ROLE_DOCTOR')){
			$appointments = $this->ar->findByDoctorId($this->getUser()->getId());
		}
        return $this->render('getAppointments.html.twig', array(
            'appointments' => $appointments));
	}

	public function generateAppointment(Request $request,  AppointmentsGenerator $ag)
    {
        $previousDate= $request->get('date');
        $options=$request->get('selector');
        $day=$request->get('daySelector');
        $specialty=$request->get('specialty');
        $this->logger->info($specialty);
        $appointmentInfo=$ag->generate($previousDate, $options, $day,$specialty);
        $date=$appointmentInfo[0];
        $doctor=$appointmentInfo[1];

        if(isset($date)){
            return $this->render('addAppointment.html.twig',
                array('date' => $date,'cond'=>$options, 'day'=>$day, 'specialty' =>$specialty,'doctor'=>$doctor));
        }else{
            //generate appointment (Especialidad, Rango)

			return $this->redirectToRoute('index');
        }
    }
    public function generateVetAppointment(Request $request, AnimalsRepository $anr, AppointmentsGenerator $ag)
    {
        $previousDate= $request->get('date');
        $options=$request->get('selector');
        $day=$request->get('daySelector');

        $appointmentInfo=$ag->generate($previousDate, $options, $day,'veterinary');
        $date=$appointmentInfo[0];
        $doctor=$appointmentInfo[1];

        if(isset($date)){
            $pets = $anr->findByOwner($this->getUser());
            return $this->render('addVetAppointment.html.twig',
                array('date' => $date,'cond'=>$options, 'pets'=>$pets, 'day'=>$day, 'doctor'=>$doctor));
        }else{
            //generate appointment (Especialidad, Rango)

            return $this->redirectToRoute('index');
        }
    }
	public function persistAppointment(Request $request, AnimalsRepository $anr, AppointmentsGenerator $ag)
	{
		$user = $this->getUser();
		$date = $request->get('date') ;
        $doctor= $request->get('doctor') ;
        $pet=$request->get('petSelector');
        if(isset($pet)){
            $pet = $anr->find($pet);
        }
		$description = $request->get('description');
		$ag->persist($user,$date,$doctor,$description,$pet);
		return $this->redirectToRoute('appointments');
	}
	
	public function removeAppointment(Request $request)
	{
		$appointmentId = $request->get('id');
		$this ->ar->remove($appointmentId);
		return $this->redirectToRoute('appointments');
	}
	public function selectSpecialty()
    {
        return $this->render('selectSpecialty.html.twig');
    }
	
}