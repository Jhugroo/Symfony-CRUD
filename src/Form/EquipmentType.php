<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use  Symfony\Component\Form\AbstractType;
use App\Entity\Category;
use App\Entity\Equipment;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;

class EquipmentType extends AbstractType {
    private $doctrine;
    public function __construct(PersistenceManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }
    public function buildForm(FormBuilderInterface $builder, array $options,) {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('number', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('equipment');
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Equipment::class
        ));
    }
}
