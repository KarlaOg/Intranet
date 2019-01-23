<?php

namespace App\Form;

use App\Entity\Grades;
use App\Repository\CoursesRepository;
use App\Repository\GradesRepository;
use App\Service\CourseService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $grades = new Grades();
        $builder
            ->add('grade')
            ->add('comment');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grades::class,
        ]);
    }
}
