<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 09/04/2018
 * Time: 19:35
 */

namespace App\Services;


use App\Repository\AppointmentsRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AppointmentsGenerator
{
    private $logger;
    private $session;
    private $ar;

    public function __construct(LoggerInterface $logger,SessionInterface $session, AppointmentsRepository $ar)
    {
        $this->session=$session;
        $this->logger = $logger;
        $this->ar = $ar;
    }
    public function generate()
    {
        //$gen = $this->session->get("gen");
        $date = new \DateTime();
        $date->modify("+1 day");
        $date->setTime(9,0,0);

        while(true){
            if(empty($this->ar->findByDate($date))){
                return $date;
            }else{
                if($date->format('H')>13){
                    $date->modify("+1 day");
                    $date->setTime(9,0,0);
                }else{
                    $date->modify("+1 hour");
                }

            }
        }

        return null;
    }
}