<?php
namespace App\Controller;


use App\Entity\Animals;
use App\Form\AnimalType;

use App\Form\UpdateUserType;
use App\Repository\AnimalsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends Controller
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
                return $this->redirectToRoute('account');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('addAnimal.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function removeAnimal(Request $request, AnimalsRepository $anr){
        $idAnimal= $request->get('id');
        $errorAnimal=$anr->remove($idAnimal);
            return $this->redirectToRoute('account',array('error'=>$errorAnimal));
    }

    public function subscribe(Request $request, UsersRepository $ur)
    {
        $creditCard=$request->get('cc');
        if(isset($creditCard)){
            $user = $this->getUser();
            $user->setCreditCard($creditCard);
            $user->setIsSubscribed(true);
            $ur->update($user);
            return $this->redirectToRoute('account');
        }
        return $this->render('accounts/subscribe.html.twig');
    }

    public function unsubscribe(UsersRepository $ur)
    {
        $user = $this->getUser();
        $user->setCreditCard(null);
        $user->setIsSubscribed(false);
        $ur->update($user);
        return $this->redirectToRoute('account');
    }

    public function getAccount(AnimalsRepository $anr, Request $request){
        $user = $this->getUser();
        $error= $request->get('error');
        if($this->isGranted('ROLE_DOCTOR')){
            return $this->render('accounts/doctorAccount.html.twig', array(
                'doctor' => $user,
                'error' => $error,
            ));
        }elseif($this->isGranted('ROLE_USER')){
            $animals = $anr->findByOwner($user);
            return $this->render('accounts/userAccount.html.twig', array(
                'user' => $user,
                'pets' => $animals,
                'error' => $error,
            ));
        }
        return $this->redirectToRoute('index');
    }
    public function update(Request $request, UsersRepository $ur, UserPasswordEncoderInterface $passwordEncoder)
    {
        $error = null;
        $user= $this->getUser();
        $uuser= clone $user;
        $form = $this->createForm(UpdateUserType::class, $uuser);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($uuser->getPlainPassword())
                $password = $uuser->getPlainPassword();
                $birth = $uuser->getBirthdate();
                $phone = $uuser->getPhone();
                $ssn = $uuser->getSocialSecurityNumber();
                $name = $uuser->getUsername();

                if(isset($password)){
                    $user->setPassword($passwordEncoder->encodePassword($uuser, $password));
                }
                if(isset($birth)){
                    $user->setBirthdate($birth);
                }
                if(isset($phone)){
                    $user->setPhone($phone);
                }
                if(isset($ssn)){
                    $user->setSocialSecurityNumber($ssn);

                }
                if(isset($name)){
                    $user->setUsername($name);

                }
            $error = $ur->update($user);

            if($error==null){
                return $this->redirectToRoute('account');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('accounts/updateUser.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}