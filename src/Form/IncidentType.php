<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 21/03/2018
 * Time: 9:17
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, array("attr" => array("maxlength" => "200")))
            ->add('title', TextType::class, array("attr" => array("maxlength" => "40")))
            ->add('description', TextareaType::class, array("attr" => array("maxlength" => "200")))
            ->add('create', SubmitType::class, array("attr" => array("class" => "button")));
            //->add('cancel',ResetType::class);
    }
}