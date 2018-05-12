<?php
namespace App\Controller;

use App\Entity\Doctors;
use App\Entity\Users;
use App\Entity\Incidents;
use App\Form\DoctorType;
use App\Form\IncidentType;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\AppointmentsRepository;
use App\Repository\DoctorsRepository;
use App\Repository\IncidentsRepository;
use App\Repository\UsersRepository;
use App\Services\GeneralService;
use App\Services\IncidentsService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AppController extends Controller
{
    public function index(AppointmentsRepository $ar, GeneralService $gs)
    {
        $alert_appointments= array();
        if($this->isGranted('ROLE_USER') ){
            $appointments = $ar->findByPatientId($this->getUser()->getId());
            $current_date = new \DateTime();
            $alert_date_limit = new \DateTime('now +3 day');
            foreach ($appointments as $appointment){
                if($appointment->getDate()>$current_date && $appointment->getDate()<$alert_date_limit){
                    array_push($alert_appointments, $appointment);
                }
            }
        }
        $alert_appointments = $gs->sort($alert_appointments);
        return $this->render('index.html.twig',array('appointments'=>$alert_appointments,));
    }

    public function login(AuthenticationUtils $authenticationUtils){
        if($this->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirectToRoute('index');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, ['dni'=>$lastUsername]);
        if($error !=null){
            $form->addError(new FormError($error->getMessageKey()));
        }
        return $this->render('login.html.twig', array(
            'form' => $form->createView(),
            'error'=> $error,
        ));
    }

    public function addUser(Request $request, UsersRepository $ur, UserPasswordEncoderInterface $passwordEncoder)
    {
        $error = null;
        $user= new Users();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $error = $ur->addUser($user);

            if($error==null){
                return $this->redirectToRoute('index');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('adduser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function addDoctor(Request $request, DoctorsRepository $ur, UserPasswordEncoderInterface $passwordEncoder)
    {
        $error = null;
        $user= new Doctors();
        $form = $this->createForm(DoctorType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $error = $ur->addUser($user);

            if($error==null){
                return $this->redirectToRoute('index');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('addDoctor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function addIncident(Request $request, IncidentsService $is){
        $error = null;
        $userType=-1;
		
        if($this->isGranted('ROLE_DOCTOR')){
            $userType=1;
        }elseif($this->isGranted('ROLE_USER')){
            $userType=0;
        }
		
        $incident= new Incidents();
		
		$form = $this->createForm(IncidentType::class, $incident);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$email= $userType == 0 ? $form->get('email')->getData() : $this->getUser()->getEmail();
			$title=$form->get('title')->getData();
			$description=$form->get('description')->getData();
            $error = $is->newIncident($email,$userType,$this->getUser(),$description, $title);

            if($error==null){
                return $this->redirectToRoute('index');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('addIncident.html.twig', array(
            'form' => $form->createView(),
		));
    }
	
	public function getIncidents(Request $request, IncidentsRepository $ir)
	{
        $incidents = null;
		$state = $request->get('state');
		$idChange = $request->get('idChange');
		$changeState = $request->get('updateState');
		if(isset($state) && $state=="OPEN"){
			$incidents = $this->getDoctrine()->getEntityManager()->getRepository('App:Incidents')->findByState(0);
		} elseif(isset($state) && $state=="CLOSED"){
			$incidents = $this->getDoctrine()->getEntityManager()->getRepository('App:Incidents')->findByState(1);
		} else {
			if(isset($changeState)){
				$this->getDoctrine()->getEntityManager()->getRepository('App:Incidents')->changeState($idChange, $changeState == 0 ? 1 : 0);
			}
			$incidents = $this->getDoctrine()->getEntityManager()->getRepository('App:Incidents')->findAllOrderedByDate();
		}
		return $this->render('getIncidents.html.twig', array(
			'incidents' => $incidents,
			));
	}
	
	public function getIncident(Request $request, IncidentsRepository $ir, GeneralService $gs)
	{
        $incident = null;
		$state = $request->get('id');
		if(isset($state)){
			$incident = $this->getDoctrine()->getEntityManager()->getRepository('App:Incidents')->findOneById($state);
		}
        return $this->render('selectIncident.html.twig', array(
            'incident' => $incident,
            ));
	}
}