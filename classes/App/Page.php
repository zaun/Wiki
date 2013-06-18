<?php
namespace App;

class Page extends \PHPixie\Controller {

    protected $id;
    protected $template;
    protected $pageView;
    protected $view;
    protected $sectionTypeObjects;
    protected $attributeTypeObjects;
    
    private $runStart;
    private $runTime;
    
    public function before() {
        $this->runStart = microtime();
        
        // Make sure the application has been configured
        if (get_class($this) != "App\Controller\Installer" &&
            $this->pixie->config->get('application.initilized', false) === false) {
            $this->redirect('/~installer');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }

        // Set the base view
        $this->view = $this->pixie->view("temp_" . $this->template);

        // Grab the application configuration
        $this->appTitle = $this->pixie->config->get('application.name', 'Wiki Title');
        $this->view->appLicense = $this->pixie->config->get('application.license', '');
        
        // Set the page default rites
        $this->view->canEdit = true;
        $this->view->canTalk = true;
        $this->view->mode = "view";
        $this->id = strtolower($this->request->param('id', 'Welcome'));
        $this->view->id = $this->id;
        $this->attributeView = "";
        $this->view->pageImage = "/defaultPageImage.jpg";
        $this->view->pageTitle = "Undefined Title";
        $this->view->username = $this->pixie->session->get('username', false);
        $this->view->imageName = "";
        $this->view->imageTitle = "";
        $this->view->cssLayout = "layoutLeft";
        
        $this->loadPlugins();
    }
    
    
    public function after() {
        // If no attribute view set to full width page
        if ($this->attributeView === '') {
            $this->view->cssLayout = "layoutFull";
        }
        
        // Fixup the layout css
        $this->view->cssLayout .= '.css';
        
        // Update the title
        $this->view->browserTitle = $this->appTitle . ': ' . $this->view->pageTitle;
        $this->view->appTitle = $this->appTitle;
        
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->view->pageView = $this->pixie->find_file('views', $this->pageView);
        $this->view->attributeView = $this->pixie->find_file('views', $this->attributeView);
        $this->view->pageFooter = $this->pixie->find_file('views', 'pageFooter');

        // Calculate time
        $this->runTime = microtime() - $this->runStart;
        
        // Render the page and done
        $this->view->runTime = $this->runTime;
        $this->response->body = $this->view->render();
    }
    
    
    protected function isPost() {
        return $this->request->method == 'POST';
    }
    
    
    private function loadPlugins() {
        $this->sectionTypeObjects = array();
        $this->attributeTypeObjects = array();
        
        // Load up default sections
        $obj = new Sections\Text($this->request);
        $this->sectionTypeObjects[$obj->abbr] = $obj;
        $obj = new Sections\Markup($this->request);
        $this->sectionTypeObjects[$obj->abbr] = $obj;
        
        // Load up additional sections
        $plugins = $this->pixie->config->get('application.sections', array());
        foreach($plugins as $plugin) {
            $class = 'Plugins\\Sections\\' . $plugin;
            $obj = new $class($this->request);
            $this->sectionTypeObjects[$obj->abbr] = $obj;
        }
        uasort($this->sectionTypeObjects, array($this, 'cmp')); 
        

        // Load up default attributes
        $obj = new Attributes\Header($this->request);
        $this->attributeTypeObjects[$obj->abbr] = $obj;
        $obj = new Attributes\Text($this->request);
        $this->attributeTypeObjects[$obj->abbr] = $obj;
        $obj = new Attributes\Date($this->request);
        $this->attributeTypeObjects[$obj->abbr] = $obj;

        // Load up additional attributes
        $plugins = $this->pixie->config->get('application.attributes', array());
        foreach($plugins as $plugin) {
            $class = 'Plugins\\Attributes\\' . $plugin;
            $obj = new $class($this->request);
            $this->attributeTypeObjects[$obj->abbr] = $obj;
        }
        uasort($this->attributeTypeObjects, array($this, 'cmp')); 
    }
    
    
    function cmp($a, $b) {
        if ($a->name == $b->name) {
            return 0;
        }
        return ($a->name < $b->name) ? -1 : 1;
    }
}
