<?php
/**
 * Created by IntelliJ IDEA.
 * User: samue
 * Date: 06/05/2018
 * Time: 9:59
 */

namespace App\Controller;


use App\Repository\DoctorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends Controller
{
    public function searchDoctor(Request $request, DoctorsRepository $dr)
    {
        $error = null;
        $specialty=$request->get('specialty');
        $searchField=$request->get('searchField');
        if(isset($specialty, $searchField) ){
            if($specialty=="none"){
                $specialty=null;
            }
            $doctors=$dr->findByOptions($specialty);
            $resultDoctors=array();
            if($searchField!=""){
                foreach ($doctors as $doctor){
                    if(strpos(strtolower($doctor->getUsername()),strtolower($searchField)) !== false){
                        array_push($resultDoctors,$doctor);
                    }
                }
            }else{
                $resultDoctors=$doctors;
            }

        }else{
            $resultDoctors=null;
        }
        return $this->render('profiles/searchDoctor.html.twig',
            array('doctors'=>$resultDoctors,'specialty'=>$specialty,'error'=>$error));


    }
}