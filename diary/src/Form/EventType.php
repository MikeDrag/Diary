<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label_attr' => array('class' => 'event_name'),
	            'attr' => ['class' => 'form-control']])
            ->add('description', TextType::class,
                ['required' => false,
                'attr' => ['class' => 'form-control']])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name', 'attr' => ['class' => 'form form-control']])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary p-2 mt-2']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
