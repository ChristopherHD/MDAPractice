<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function index()
    {
        $number = mt_rand(0, 100);

        return $this->render('index.html.twig', array(
            'number' => $number,

            ));
    }
}