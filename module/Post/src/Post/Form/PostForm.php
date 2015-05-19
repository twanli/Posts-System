<?php
    namespace Post\Form;
    
    use Zend\Form\Form;
    
    class PostForm extends Form
    {
        const TEXT_AREA_ROWS = 5;
        
        public function __construct($name = null)
        {
            // we want to ignore the name passed
            parent::__construct('post');

            $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
            ));

            $this->add(array(
                'name' => 'post_message',
                'type' => 'Textarea',
                'attributes' => array(
                    'id' => 'post_message',
                    'class' => 'form-control',
                    'rows' => self::TEXT_AREA_ROWS,
                    'placeholder' => 'Enter a post ...',
                    
                ),
            ));

            $this->add(array(
                'name' => 'fileselect',
                'type' => 'File',
                'options' => array(
                    'label' => 'Attach files:',
                ),
                'attributes' => array(
                    'id' => 'fileselect',
                    'multiple' => true,
                    //'class' => 'form-control',                                       
                ),
            ));

            $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
            ));
        }    
    
    }    
?>
