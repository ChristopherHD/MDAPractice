<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 09/04/2018
 * Time: 19:35
 */

namespace App\Services;


use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use App\Repository\DoctorsRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AppointmentsGenerator
{
    private $logger;
    private $session;
    private $ar;
    private $dr;

    public function __construct(LoggerInterface $logger,SessionInterface $session, AppointmentsRepository $ar, DoctorsRepository $dr)
    {
        $this->session=$session;
        $this->logger = $logger;
        $this->ar = $ar;
        $this->dr = $dr;
    }
    public function generate($previousDate)
    {
        if(isset($previousDate)){
            $date = new \DateTime($previousDate);
            $date->modify("+1 hour");
        }else{
            $date = new \DateTime();
            $date->modify("+1 day");
            $date->setTime(9,0,0);
    }
        while(true){
            if(empty($this->ar->findByDate($date))){
                return $date;
            }else{
                if($date->format('H')>18){
                    $date->modify("+1 day");
                    $date->setTime(9,0,0);
                }else{
                    $date->modify("+1 hour");
                }

            }
        }
        return null;
    }
    public function persist($user,$date){
        $doctor  = $this->dr->findByDni('doctor');
        $date = new \DateTime($date) ;

        $appointment=new Appointments($user,$doctor,$date);
        $this->ar->addAppointment($appointment);
    }
}