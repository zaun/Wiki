<?php
namespace App\Controller;

class Template extends \App\Page {

    protected $template = "template";

    public function action_view() {
        // Find the template in the database
		$this->templateData = $this->pixie->orm->get('template')->where('name', $this->id)->find();

        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->templateData->loaded()) {
        		$this->pageView = 'template/View';
        		$this->view->pageTitle = 'Template: ' . $this->templateData->name;
        		$this->view->pageSummary = $this->templateData->description;
        		$this->view->templateSections = $this->templateData->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        		$this->view->templateAttributes = $this->templateData->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
        		$this->view->templateArticles = $this->templateData->articles->find_all()->as_array(true);
        } else {
        		$this->pageView = 'template/New';
        		$this->view->pageTitle = 'Create template ' . $this->id . '?';
        		$this->view->pageSummary = '';
        		$this->view->templateSections = [];
        		$this->view->templateArticles = [];
        }
    }


	public function action_edit() {
        // Find the template in the database
		$this->templateData = $this->pixie->orm->get('template')->where('name', $this->id)->find();
	    
	    // If this is a post save the form
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
	        // Set the easy stuff
            $this->templateData->name = $this->request->post('templateName', '');
            $this->templateData->description = $this->request->post('templateDescription', '');
            $this->templateData->lastEditIP = $_SERVER['REMOTE_ADDR'];
            $this->templateData->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
            $this->templateData->save();
             
             // Set the sections
             $sections = json_decode($this->request->post('templateSections', '[]'));
             // Add/Update sections
             foreach ($sections as $s) {
                 $order = $s[0];
                 $orig = $s[1];
                 $title = $s[2];
                 $type = $s[3];
                 
                 $sectionData = $this->templateData->sections->where('title', $orig)->find();
                 $sectionData->template = $this->templateData;
                 $sectionData->title = $title;
                 $sectionData->order = $order;
                 $sectionData->type = $type;
                 $sectionData->save();
             }
             $currentSections = $this->templateData->sections->find_all();
             foreach ($currentSections as $cs) {
                 $found = false;
                 foreach ($sections as $s) {
                     $title = $s[2];
                     if ($cs->title == $title) {
                         $found = true;
                     }
                 }
                 
                 // Remove old
                 if ($found === false && $cs->sections->count_all() == 0) {
                     $cs->delete();
                 }
             }
                          
             // Set the attributes
             $attributes = json_decode($this->request->post('templateAttributes', '[]'));
             // Add/Update attributes
             foreach ($attributes as $a) {
                 $order = $a[0];
                 $orig  = $a[1];
                 $title = $a[2];
                 $type  = $a[3];
                 
                 $attributeData = $this->templateData->attributes->where('title', $orig)->find();
                 $attributeData->template = $this->templateData;
                 $attributeData->title = $title;
                 $attributeData->order = $order;
                 $attributeData->type = $type;
                 $attributeData->save();
             }
             $currentAttributes = $this->templateData->attributes->find_all();
             foreach ($currentAttributes as $ca) {
                 $found = false;
                 foreach ($attributes as $a) {
                     $title = $a[2];
                     if ($ca->title == $title) {
                         $found = true;
                     }
                 }
                 
                 // Remove old
                 if ($found === false) {
                     $ca->delete();
                 }
             }
        		
        		// Redirect to prevent browser reload issues
        		$this->response->redirect('/!' . $this->templateData->name);
    		}


        // Set page variables
		$this->pageView = 'template/Edit';
		$this->view->mode = 'edit';
		
		// Setup the template sections
        $this->view->sectionTypeObjects = $this->sectionTypeObjects;
        $this->view->attributeTypeObjects = $this->attributeTypeObjects;
        
	    if ($this->templateData->loaded()) {
        		$this->view->pageTitle = 'Editing template ' . $this->templateData->name;
        		$this->view->templateName = $this->templateData->name;
        		$this->view->templateDescription = $this->templateData->description;
        		
        		// Load template sections
        		$tempSections = $this->templateData->sections->order_by('order', 'ASC')->find_all();
        		if (count($tempSections) == 0) {
            		$this->view->templateSections = array(
            		    (object)array('title' => 'Content', 'type' => 'mu', 'inuse' => 0)
            		);
        		} else {
        		    $sectionList= array();
        		    foreach($tempSections as $tempSection) {
        		        $inuse = 0;
        		        if ($tempSection->sections->count_all() != 0) {
        		            $inuse = 1;
        		        }
        		        $object = (object)array('title' => $tempSection->title,
        		                                'type' => $tempSection->type,
        		                                'inuse' => $inuse);
        		        array_push($sectionList, $object);
        		    }
        		    $this->view->templateSections = $sectionList;
        		}
        		
        		// Load template attributes
        		$tempAttributes = $this->templateData->attributes->order_by('order', 'ASC')->find_all();
        		if (count($tempAttributes) == 0) {
            		$this->view->templateAttributes = array();
        		} else {
        		    $attributeList= array();
        		    foreach($tempAttributes as $tempAttribute) {
        		        $inuse = 0;
        		        if ($tempAttribute->attributes->count_all() != 0) {
        		            $inuse = 1;
        		        }
        		        $object = (object)array('title' => $tempAttribute->title,
        		                                'type' => $tempAttribute->type,
        		                                'inuse' => $inuse);
        		        array_push($attributeList, $object);
        		    }
        		    $this->view->templateAttributes = $attributeList;
        		}
	    } else {
        		$this->view->pageTitle = 'Editing template ' . $this->id;
        		$this->view->templateName = $this->id;
        		$this->view->templateDescription = "";
        		$this->view->templateSections = array(
        		    (object)array('title' => 'Content', 'type' => 'mu', 'inuse'=>0)
        		);
        		$this->view->templateAttributes = array();
	    }
	}


	public function action_talk() {
	    
	}
}