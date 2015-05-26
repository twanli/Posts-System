<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\File\Size; 
use Zend\Validator\File\Extension;

class ImportForm extends Form
{
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('import');

        $this->add(array(
            'name' => 'zipupload',
            'required' => true,
            'type' => 'file',
            'options' => array(
                'label' => 'Upload Zip',
            ),
            'validators' => array(
              
              new Extension(array(
                        'extension' => array('zip'),
                    )
              ),

              )
        )); 
        $this->add(array(
         'name' => 'importform',
         'type' => 'Hidden',
         'attributes' => array(
             'value' => '1',
         ),
        ));

        $this->add(array(
         'name' => 'submit',
         'type' => 'Submit',
         'attributes' => array(
             'value' => 'Confirm Import',             
         ),
        ));
    }
}    
?>
