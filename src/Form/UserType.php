<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 21/03/2018
 * Time: 9:17
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class)
            ->add('dni', TextType::class)
            ->add('social_security_number', TextType::class,array('label'=>'Social Security nº',))
            ->add('password', PasswordType::class)
            ->add('birthdate', BirthdayType::class)
            ->add('phone', NumberType::class)
            ->add('create', SubmitType::class);
    }
}