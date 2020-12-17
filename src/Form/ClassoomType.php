<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

use Symfony\Component\Form\Extension\Core\Type\TextType; 

use App\Entity\Classroom;


class ClassoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {//form-control
        $builder
            ->add('name', TextType::class, array(
                'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
