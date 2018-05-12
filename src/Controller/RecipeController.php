<?php
namespace App\Controller;



use App\Entity\Recipes;
use App\Repository\AnimalsRepository;
use App\Repository\AppointmentsRepository;
use App\Repository\DoctorsRepository;
use App\Repository\RecipesRepository;
use App\Repository\UsersRepository;
use App\Services\AppointmentsGenerator;
use App\Services\GeneralService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Recipe;


class RecipeController extends Controller
{
    private $rr;
    private $logger;
	public function __construct(RecipesRepository $rr, LoggerInterface $logger)
    {
        $this->rr= $rr;
        $this->logger=$logger;

    }

    public function addRecipe(Request $request)
    {
        $patientId = $request->get('patient');
        $appointment = $request->get('appointment');
        return $this->render('addRecipes.html.twig',array('patient' => $patientId,'appointment' =>$appointment));

    }
	public function getRecipes(Request $request, GeneralService $gs)
	{
        $good=$request->get('good');
        $recipes = $this->rr->findByPatientId($this->getUser()->getId());
		$recipes= $gs->sort($recipes);
        return $this->render('getRecipes.html.twig', array(
            'recipes' => $recipes,
            'good' => $good,
            ));
	}

    public function persistRecipe(Request $request, RecipesRepository $rr, UsersRepository $ur)
    {
        $name=$request->get('name');
        $patientId=$request->get('patient');
        $patient = $ur->findByDni($patientId);
        $doctor = $this->getUser();
        $appointment= $request->get('appointment');
        $date=new \DateTime();
        $recipe= new Recipes($patient,$doctor,$date,$name);
        $rr->addRecipe($recipe);
        return $this->redirectToRoute('appointments');
    }


}