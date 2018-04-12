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
    public function generate($previousDate, $option)
    {
        if($option == "AM"){
            $initHour=9;
            $endHour=13;
        }else{
            $initHour=14;
            $endHour=19;
        }

        if(isset($previousDate)){
            $date = new \DateTime($previousDate);

        }else{
            $date = new \DateTime();
    }
        while(true){
            if($date->format('H')<$initHour){
                $date->setTime($initHour,0,0);
            }
                if($date->format('H')>$endHour){
                    $date->modify("+1 day");
                    $date->setTime($initHour,0,0);
                }else{
                    $date->modify("+1 hour");
                }
            if(empty($this->ar->findByDate($date))){
                return $date;
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