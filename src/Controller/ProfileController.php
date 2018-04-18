<?php
namespace App\Controller;


use App\Entity\Animals;
use App\Form\AnimalType;
use App\Form\DoctorType;

use App\Repository\AnimalsRepository;

use App\Repository\DoctorsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class ProfileController extends Controller
{
    public function addAnimal(Request $request, AnimalsRepository $anr)
    {
        $error = null;
        $animal= new Animals();
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $animal->setOwner($this->getUser());
            $error = $anr->addAnimal($animal);

            if($error==null){
                return $this->redirectToRoute('userProfile');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('addAnimal.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function getPatient(Request $request, UsersRepository $ur)
    {
        $userID=$request->get('id');
        if(isset($userID)){
            $user = $ur->findByDni($userID);
        }else{
            return $this->redirectToRoute('index');
        }
        return $this->render('userProfile.html.twig', array(
            'user' => $user,
        ));
    }
    public function getDoctor(Request $request, DoctorsRepository $dr)
    {
        $userID=$request->get('id');
        if(isset($userID)){
            $user = $dr->findByDni($userID);
        }else{
            return $this->redirectToRoute('index');
        }
        return $this->render('doctorProfile.html.twig', array(
            'doctor' => $user,
        ));
    }
    public function myProfile(){
        $user = $this->getUser();
        if($this->isGranted('ROLE_DOCTOR')){
            return $this->render('myDoctorProfile.html.twig', array(
                'doctor' => $user,
            ));
        }elseif($this->isGranted('ROLE_USER')){
            return $this->render('myUserProfile.html.twig', array(
                'user' => $user,
            ));
        }
        return $this->redirectToRoute('index');
    }


}