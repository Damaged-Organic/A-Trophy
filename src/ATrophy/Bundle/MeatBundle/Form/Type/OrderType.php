<?php
// ATrophy/Bundle/MeatBundle/Form/Type/OrderType.php
namespace ATrophy\Bundle\MeatBundle\Form\Type;

use ATrophy\Entity\Order\Order;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientName', 'text', [
                'required' => FALSE
            ])
            ->add('clientEmail', 'email', [
                'required' => FALSE
            ])
            ->add('clientPhone', 'tel', [
                'required' => FALSE
            ])
            ->add('deliveryType', 'choice', [
                'choices' => [
                    'selfDelivery' => 'Самовывоз',
                    'shopDelivery' => 'Доставка'
                ],
                'data'     => 'selfDelivery',
                'expanded' => TRUE,
                'required' => FALSE
            ])
            ->add('deliveryRegion', 'text', [
                'required' => FALSE
            ])
            ->add('deliveryCity', 'text', [
                'required' => FALSE
            ])
            ->add('deliveryAddress', 'text', [
                'required' => FALSE
            ])
            ->add('deliveryService', 'choice', [
                'choices' => [
                    'newPost' => 'Новая Почта',
                    'gunsel'  => 'Гюнсел',
                    'inTime'  => 'Интайм'
                ],
                'data'     => 'newPost',
                'expanded' => TRUE,
                'required' => FALSE
            ])
            ->add('serviceOffice', 'text', [
                'required' => FALSE
            ]);
    }

    public function getName()
    {
        return 'order';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => ['shopDelivery', 'Default'],
        ]);
    }

}