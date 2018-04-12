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
        $day = 'Monday';

        if($option == "AM"){
            $initHour=9;
            $endHour=13;
        }else{
            $initHour=14;
            $endHour=19;
        }

        if(isset($previousDate)){
            $date = new \DateTime($previousDate);

        }else if(isset($day)){
            $date = new \DateTime($day);
        }else{
            $date = new \DateTime();
        }
        while(true){
            if(isset($day)&&$date->format('l')!=$day){          //Si Dia de la semana es diferente y la opción está seleccionada
                $interval = \DateInterval::createFromDateString($day); //Calculamos el intervalo relativalo al siguiente lunes
                $date->add($interval);                                  //Se aplica el intervalo relativo a la fecha actual
                $date->setTime($initHour, 0, 0);        //Reiniciamos la hora.
            }
            $bounds = $this->checkBounds($date,$initHour,$endHour);     //Calculamos extremos [-1,0,1]
            if($bounds<0) {                                             //Si estamos por debajo del horario
                $date->setTime($initHour, 0, 0);        //Reiniciamos la hora
            }else if($bounds>0){                                        //Si estamos por encima
                if(isset($day)) {                                       //Y la opción de día está activa
                    $date->modify("+7 day");                    //Avanzamos 7 días
                }else{
                    $date->modify("+1 day");                    //Si no avanzamos 1 día
                }
                $date->setTime($initHour, 0, 0);        //Reiniciamos hora
            }else{                                                     //Si estamos dentro de las opciones horarias/límites
                $date->modify("+1 hour");                       //Avanzamos 1 hora
            }
            if(empty($this->ar->findByDate($date))){                    //Si la fecha no está ocupada
                return $date;                                           //Salimos y Devolvemos la fecha.
            }
        }
        return null;                                                    //Nunca debería ejecutarse
    }

    private function checkBounds(\DateTime $date,$inf,$sup){
        $date = $date->format('H');
        if($date>=$sup) return 1;
        if($date<$inf) return -1;
        return 0;
    }

    public function persist($user,$date){
        $doctor  = $this->dr->findByDni('doctor');
        $date = new \DateTime($date) ;

        $appointment=new Appointments($user,$doctor,$date);
        $this->ar->addAppointment($appointment);
    }
}