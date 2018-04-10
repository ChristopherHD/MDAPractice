<?php
namespace App\Controller;


use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use App\Services\AppointmentsGenerator;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppointmentController extends Controller
{
	public function persistAppointment(AppointmentsRepository $ar)
	{

	}
}