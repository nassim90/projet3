<?php
namespace projet3\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                  ->add('parent', HiddenType::class,array("attr"=>array("class"=>"champCache")))
          		  ->add('author', TextareaType::class, array('label' => 'Nom'))
           		  ->add('content', TextareaType::class,array('label' => 'Contenu'));
                  
    }
    public function getName()
    {
        return 'comment';
    }
}