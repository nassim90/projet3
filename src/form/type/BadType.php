<?php
namespace projet3\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add( CheckboxType::class, array(
           
    'label'    => 'Show this entry publicly?',
    'required' => false,
));
    }
    public function getName()
    {
        return 'bad';
    }
}