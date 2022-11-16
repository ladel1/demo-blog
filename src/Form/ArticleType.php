<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,["label"=>"Nom"])
            ->add('description')
            ->add('price',IntegerType::class,[
                "label"=>"Prix",
                
                "attr"=>[
                    "min"=>20,
                    "placeholder"=>"ex. 500€",
                    "max"=>1000,
                    "step"=>0.1
                ]
            ])
            ->add("category",EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>"name",
                'label'=>'Catégorie'
                
            ])
            //->add('dateCreated',HiddenType::class,[])
            //->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}