<?php

namespace App\Form;

use App\Entity\ItemTrade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemTradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tradeDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('returnDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('isProposal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemTrade::class,
        ]);
    }
}
