<?php
// ATrophy/Bundle/MeatBundle/Form/Type/FeedbackType.php
namespace ATrophy\Bundle\MeatBundle\Form\Type;

use ATrophy\Entity\Meat\Feedback;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'required' => FALSE
            ])
            ->add('email', 'email', [
                'required' => FALSE
            ])
            ->add('phone', 'tel', [
                'required' => FALSE
            ])
            ->add('subject', 'text', [
                'required' => FALSE
            ])
            ->add('message', 'textarea', [
                'required' => FALSE
            ]);
    }

    public function getName()
    {
        return 'feedback';
    }
}