<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Band;
use App\Entity\Picture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('created_at', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy'
            ])
            ->add('picture', EntityType::class, [
                'class' => Picture::class,
                'choice_label' => 'alternative_name'
            ])
            ->add('members', EntityType::class, [
                'class' => Member::class,
                'choice_label' => function (Member $member) {
                    return $member->getFirstname() . ' ' . $member->getLastname();
                },
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
