<?php

namespace MediaRemoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;

class RemoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('remoteName', TextType::class, [
            "label" => "name.self",
            "constraints" => [
                new Regex([
                    "pattern" => "/^[A-Z]{1}[a-z]{2,15}$/"
                    ])
            ],
            "attr"=>[
                "pattern" => "^[A-Z]{1}[a-z]{2,15}$"
            ],
                                   
        ])
        ->add('remoteDuration', IntegerType::class, [
            "label" => "\\s",
            "constraints" => [
                new Range([
                    "min" => 1,
                    "max" => 24
                ])
            ],
            "attr"=>[
                "min" => "1",
                "max" => "24",
            ],
            
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MediaRemoteBundle\Entity\Remote'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mediaremotebundle_remote';
    }


}
