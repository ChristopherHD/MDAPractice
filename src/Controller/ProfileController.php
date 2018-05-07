<?php
namespace App\Controller;
use App\Repository\AnimalsRepository;
use App\Repository\DoctorsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class ProfileController extends Controller
{

    public function getAnimal(Request $request,AnimalsRepository $anr){
        $idAnimal= $request->get('id');

        if(isset($idAnimal)){
            $pet = $anr->findById($idAnimal);
        }else{
            return $this->redirectToRoute('getAnimal');
        }
        return $this->render('profiles/petProfile.html.twig', array(
            'pet' => $pet[0],
        ));
    }
    public function getPatient(Request $request, UsersRepository $ur, AnimalsRepository $anr)
    {
        $userID=$request->get('id');
        if(isset($userID)){
            $user = $ur->findByDni($userID);
            $pets = $anr->findByOwner($user);
        }else{
            return $this->redirectToRoute('index');
        }
        return $this->render('profiles/userProfile.html.twig', array(
            'user' => $user,
            'pets' => $pets,
        ));
    }
    public function searchDoctor()
    {
        return $this->render('profiles/searchDoctor.html.twig');
    }

    public function getDoctor(Request $request, DoctorsRepository $dr, \Swift_Mailer $mailer)
    {
        $error = null;
        $good= null;
        $doctorID=$request->get('id');
        $userID=$request->get('user');
        if(isset($doctorID)){
            $doctor = $dr->findByDni($doctorID);
        }else{
            return $this->redirectToRoute('index');
        }
        if(isset($userID)){
            $msg=$request->get('msg');
            $email = $doctor->getEmail();
            $from = "gmedservice101@gmail.com";
            $subject='Patient '.$userID;

            $message = (new \Swift_Message($subject))
                ->setFrom($from)
                ->setTo('eliolistillo@gmail.com')
                ->setBody(
                    $msg
                );
            $mailer->send($message);
            $good = 'Email sent!';
        }
        return $this->render('profiles/doctorProfile.html.twig', array(
            'doctor' => $doctor,
            'error'=> $error,
            'good'=> $good
        ));
    }


}