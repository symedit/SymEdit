<?php

namespace Isometriks\Bundle\SymEditBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\FormInterface; 
use Symfony\Component\Form\FormEvents; 
use Symfony\Component\Form\FormEvent; 
use Symfony\Component\Form\FormError; 
use Symfony\Component\Form\FormView; 

class TimedSpamType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->addEventListener(FormEvents::POST_BIND, function(FormEvent $event) use ($options) {
            
            $time = base64_decode($event->getForm()->getData()); 
            
            if(!ctype_digit($time) || (time() - $time) < $options['min_time'] || time() < $time){
                $form = $event->getForm(); 
                $form->addError(new FormError('You are doing that too quickly.')); 
            }
            
        }); 
    }
    
    /**
     * Set the value here because this forces it to set the value on every submit,
     * if the bot caused an error and tried to submit again then it would still 
     * make it wait. Likewise for users, so set min_time to a good value for how
     * long your form is. 
     * 
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        
        $view->vars['value'] = base64_encode(time()); 
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false, 
            'min_time' => 7, 
        ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'symedit_timed_spam';
    }

}