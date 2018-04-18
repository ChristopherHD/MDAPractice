<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 09/04/2018
 * Time: 19:35
 */

namespace App\Services;


use App\Entity\Incidents;

use App\Repository\DoctorsRepository;
use App\Repository\IncidentsRepository;
use App\Repository\UsersRepository;
use Psr\Log\LoggerInterface;


class IncidentsService
{
    private $logger;
    private $ur;
    private $dr;
    private $ir;

    public function __construct(LoggerInterface $logger, UsersRepository $ur, DoctorsRepository $dr, IncidentsRepository $ir)
    {
        $this->logger = $logger;
        $this->ur = $ur;
        $this->dr = $dr;
        $this->ir = $ir;
    }
    public function newIncident($email,$userType,$user,$description){
        $date = new \DateTime();
        $incident = new Incidents($date, $description, false, $email);
        if($userType==0){
            $incident->setPatient($user);
        }elseif ($userType==1){
            $incident->setDoctor($user);
        }
        return $this->ir->addIncident($incident);
    }
}