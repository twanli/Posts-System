<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\File\Size; 
use Zend\Validator\File\Extension;

class SelectExportForm extends Form
{
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('selectexport');

        $this->add(array(
         'name' => 'exportformat',
         'type' => 'Select',
          'options' => array(
            'label' => 'Export To',
            'options' => array(
                'CSV' => 'CSV',
                'XML' => 'XML',
            ),
          ),
        ));
        $this->add(array(
         'name' => 'exportform',
         'type' => 'Hidden',
         'attributes' => array(
             'value' => '1',
         ),
        ));
        

        $this->add(array(
         'name' => 'submit',
         'type' => 'Submit',
         'attributes' => array(
             'value' => 'Confirm',             
         ),
        ));
    }
    


}    
?>
