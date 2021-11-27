<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Offre1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomoffre')
            ->add('dateCreation')
            ->add('dateExpiration')
            ->add('disponibilite')
            ->add('sexe')
            ->add('experience')
            ->add('niveauEtude')
            ->add('secteur')
            ->add('agemin')
            ->add('agemax')
            ->add('secteur')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
