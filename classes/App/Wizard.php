<?php
namespace App;

class Wizard extends \App\Page {

    protected $wizardName;
    protected $subview;
    protected $urlNext;
    protected $urlBack;
    
    public function before() {
        parent::before();
        
        $this->wizardName = "";
        $this->subview = "";
        
        // Default button states
        $this->view->btnBack     = false;
        $this->view->btnNext     = true;
        $this->view->btnFinished = false;
        $this->view->btnReturn   = false;
    }
 
 
    public function after() {        
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->pageView = $this->wizardName . '/' . $this->pageView;
         
        // button links
        $this->view->btnNextUrl = '/~' . strtolower($this->wizardName) . '/' . $this->urlNext;
        if ($this->urlBack != '') {
            $this->view->btnBackUrl = '/~' . strtolower($this->wizardName) . '/' . $this->urlBack;
        } else {
            $this->view->btnBackUrl = '/~' . strtolower($this->wizardName);
        }
        $this->view->btnFinishUrl = '/~' . strtolower($this->wizardName) . '/save';

        parent::after();
    }
}