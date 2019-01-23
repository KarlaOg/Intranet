<?php

namespace App\Form;

use App\Entity\Grades;
use App\Repository\CoursesRepository;
use App\Repository\GradesRepository;
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

        dump($_GET);
        $builder
            ->add('grade')
            ->add('comment')
            ->add('course')
            ->add('student', ChoiceType::class, [
                'choices'  => [
                    'users'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'users' => function(CoursesRepository $coursesRepository) {
                $coursesRepository->find($_GET["id"]);
                $users = [];
                foreach ($course->getUsers() as $value) {
                    $users[] = $value->getUsername();
                }
            },
            'data_class' => Grades::class,
        ]);
    }
}
