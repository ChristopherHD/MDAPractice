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

    public function getDoctor(Request $request, DoctorsRepository $dr)
    {
        $error = null;
        $userID=$request->get('id');
        if(isset($userID)){
            $user = $dr->findByDni($userID);
        }else{
            return $this->redirectToRoute('index');
        }
        return $this->render('profiles/doctorProfile.html.twig', array(
            'doctor' => $user,
            'error'=> $error,
        ));
    }


}