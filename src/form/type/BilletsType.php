<?php
namespace projet3\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class BilletsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre') )
            ->add('content', TextareaType::class,array('label' => 'Contenu'), array("attr"=>array("required"=>false)));
    }
    public function getName()
    {
        return 'billets';
    }
}