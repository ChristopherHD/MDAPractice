<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 21/03/2018
 * Time: 9:17
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dni',TextType::class)
            ->add('plainPassword', PasswordType::class,array('label'=>'Password',))
            ->add('log in', SubmitType::class, array("attr" => array("class" => "button")));
    }
}