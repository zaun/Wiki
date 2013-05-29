<?php
namespace App\Controller;

class Article extends \App\Page {

    protected $template = "article";

    public function action_view() {
        $this->init_article();


        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->loaded) {
            $this->pageView = 'Article/View';
            $this->attributeView = 'Attribute/View';

            $this->view->pageTitle = $this->title;
            $this->view->articleTitle = $this->title;
            $this->view->articleSummary = $this->summaryHtml;
            $this->view->imageName = $this->imageName;
            $this->view->imageTitle = $this->imageTitle;
            $this->view->articleTemplate = $this->templateName;
            $this->view->lastUpdated = $this->lastUpdated;
            
            
            // Load in sections
            $sectionList = array();
            $articleSections = $this->template->sections->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleSections as $s) {
                $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
                if ($articleSection->loaded()) {
                    $object = (object)array('title' => $s->title,
                                            'html' => $articleSection->html);
        		        array_push($sectionList, $object);
                }
            }
            $this->view->articleSections = $sectionList;
    
    
            // grab the article attributes
            $attributeList = array();
            $attributeListTemp = array();
            $articleAttributes = $this->template->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
            $kvAttr = array();
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $value = "";
                if ($articleAttribute->loaded()) {
                    $value = $articleAttribute->html;
                }
                $kvAttr[trim(strtolower($s->title))] = $value;
    		        $object = (object)array('id' => $s->id,
    		                                'type' => $s->type, 
    		                                'title' => $s->title,
    		                                'value' => $value);
    		        
                 if ($s->type == "hdr" || $value != "") {
    		            $pageHasContent = true;
        		        array_push($attributeListTemp, $object);
    		        }
            }
            
            $this->view->articleSummary = $this->pixie->util->replaceValues($kvAttr, $this->view->articleSummary);
            
            // Remove unneeded headers
            for ($i=0; $i < count($attributeListTemp) - 1; $i++) {
                $current = $attributeListTemp[$i];
                $next = $attributeListTemp[$i+1];
                
                if ($current->type == "hdr" && $next->type != "hdr") {
        		        array_push($attributeList, $current);
                } else if ($current->value != "") {
        		        array_push($attributeList, $current);
                }
            }
            
            // Setup the attribute list
            if (count($attributeListTemp)) {
                if ($attributeListTemp[count($attributeListTemp) - 1]->value != "") {
        		        array_push($attributeList, $attributeListTemp[count($attributeListTemp) - 1]);
                }
            }
            $this->view->articleAttributes = $attributeList;

	    } else {
            $this->pageView = 'Article/New';
            $this->view->pageTitle = 'Create article ' . $this->id . '?';
	    }
    }


	public function action_edit() {
        $this->init_article();
        
        // If the article does not exist offer to create a new one
        // if we can't create a new one, bounce over to the template
        // because its missing
	    if (!$this->loaded) {
	        if($this->create_article() === false) {
                return $this->response->redirect('/!Default');
             }
	    } else {
    
        	    // Setup basic article items
            $this->view->pageTitle = "Edit page " . $this->title;
            $this->view->articleTitle = $this->title;
            $this->view->articleSummary = $this->summary;
            $this->view->imageName = $this->imageName;
            $this->view->imageTitle = $this->imageTitle;
            $this->view->articleTemplate = $this->templateName;
            $this->view->lastUpdated = $this->lastUpdated;
    	    
        	    // If this is a post save the form just save it
        	    // and move along
        	    if($this->isPost()) {
        	        $this->save_article();
                 return $this->response->redirect('/' . $this->title);
        	    }
        	    
        	    // Setup the article for editing
            $this->pageView = 'Article/Edit';
            $this->attributeView = 'Attribute/Edit';
            $this->view->mode = 'edit';
    
            $pageHasContent = false;
    
            // grab the article attributes
            $attributeList = array();
            $this->view->articleAttributeTemplates = "";
            $this->view->articleAttributeJavascript = "";
            $attributeTypeSeen = array();
            $articleAttributes = $this->template->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $raw = "";
                if ($articleAttribute->loaded()) {
                    $raw = $articleAttribute->raw;
                }

                $html = "Unknown type " . $s->type;
                if (isset($this->attributeTypeObjects[$s->type])) {
                    $html = $this->attributeTypeObjects[$s->type]->edit($s->id, $s->title, $raw);
                    if (!isset($attributeTypeSeen[$s->type])) {
                        $this->view->articleAttributeTemplates .= $this->attributeTypeObjects[$s->type]->editOnce();
                        $this->view->articleAttributeJavascript .= $this->attributeTypeObjects[$s->type]->jsEdit();
                        $attributeTypeSeen[$s->type] = true;
                    }
                }
                array_push($attributeList, $html);
    		        
    		        if ($raw != "") {
    		            $pageHasContent = true;
    		        }
            }
            $this->view->articleAttributes = $attributeList;
    	    
    	    
            // grab the article sections
            $sectionList = array();
            $this->view->articleSectionTemplates = "";
            $this->view->articleSectionJavascript = "";
            $sectionTypeSeen = array();
            $articleSections = $this->template->sections->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleSections as $s) {
                $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
                $raw = "";
                if ($articleSection->loaded()) {
                    $raw = $articleSection->raw;
                }
                
                $html = "<strong>Unknown type " . $s->type . "</strong>";
                if (isset($this->sectionTypeObjects[$s->type])) {
                    $html = $this->sectionTypeObjects[$s->type]->edit($s->id, $s->title, $raw);
                    if (!isset($sectionTypeSeen[$s->type])) {
                        $this->view->articleSectionTemplates .= $this->sectionTypeObjects[$s->type]->editOnce();
                        $this->view->articleSectionJavascript .= $this->sectionTypeObjects[$s->type]->jsEdit();
                        $sectionTypeSeen[$s->type] = true;
                    }
                }
                array_push($sectionList, $html);
    		        
    		        if ($raw != "") {
    		            $pageHasContent = true;
    		        }
            }
            $this->view->articleSections = $sectionList;
            
            // grab all templates
            if (!$pageHasContent) {
                $this->view->selectedTemplateID = $this->templateID;
                $this->view->templateList = $this->pixie->orm->get('template')->find_all()->as_array();
            } else {
                $this->view->selectedTemplateID = -1;
                $this->view->templateList = array();
            }
	    }
	}

	public function action_talk() {
        $this->init_article();

	    if (!$this->loaded) {
	        if($this->create_article() === false) {
                return $this->response->redirect('/!Default');
             }
	    } else {
            $this->pageView = 'Article/Talk';
            $this->attributeView = 'Attribute/View';
            $this->view->mode = 'talk';
            
            // Save a new post
        	    if($this->isPost()) {
        	        $title = $this->request->post('newTitle', '');
        	        $body = $this->request->post('newBody', '');
        	        
        	        if (!empty($title) && !empty($body)) {
                    $newPost = $this->pixie->orm->get('post');
                    $newPost->title = $title;
                    $newPost->content = $this->sectionTypeObjects['mu']-> rawToHtml($body);
                    $newPost->article = $this->articleORM;
                    $newPost->postDate = gmdate("Y-m-d\TH:i:s\Z");
                    $newPost->parent_id = -1;
                    $newPost->owner_id = -1;
                    $newPost->save();
                    $this->response->redirect('/talk/' . $this->title);
                    $this->execute=false;
                    return;
        	        }
        	    }
        	    
        	    // Setup basic article items
            $this->view->pageTitle = "Talk page " . $this->title;
            $this->view->articleTitle = $this->title;
            $this->view->articleSummary = $this->summary;
            $this->view->imageName = $this->imageName;
            $this->view->imageTitle = $this->imageTitle;
            $this->view->articleTemplate = $this->template->name;
            $this->view->lastUpdated = $this->lastUpdated;
    
    
            // grab the article attributes
            $attributeList = array();
            $attributeListTemp = array();
            $articleAttributes = $this->template->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
            $kvAttr = array();
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $value = "";
                if ($articleAttribute->loaded()) {
                    $value = $articleAttribute->html;
                }
                $kvAttr[trim(strtolower($s->title))] = $value;
    		        $object = (object)array('id' => $s->id,
    		                                'type' => $s->type, 
    		                                'title' => $s->title,
    		                                'value' => $value);
    		        
                 if ($s->type == "hdr" || $value != "") {
    		            $pageHasContent = true;
        		        array_push($attributeListTemp, $object);
    		        }
            }
            $this->view->articleSummary = $this->pixie->util->replaceValues($kvAttr, $this->view->articleSummary);
            
            
            // Remove unneeded headers
            for ($i=0; $i < count($attributeListTemp) - 1; $i++) {
                $current = $attributeListTemp[$i];
                $next = $attributeListTemp[$i+1];
                
                if ($current->type == "hdr" && $next->type != "hdr") {
        		        array_push($attributeList, $current);
                } else if ($current->value != "") {
        		        array_push($attributeList, $current);
                }
            }
            // Setup the attribute list
            if (count($attributeListTemp)) {
                if ($attributeListTemp[count($attributeListTemp) - 1]->value != "") {
        		        array_push($attributeList, $attributeListTemp[count($attributeListTemp) - 1]);
                }
            }
            $this->view->articleAttributes = $attributeList;
            

            $this->view->posts = $this->pixie->orm->get('post')->where('article_id', $this->articleORM->id)->where('parent_id', -1)->find_all()->as_array(true);

	    }
	}
	
	
	/**
	 * Load the article's data from the databsae and setup
	 * the class variables for access elsewhere. This is done
	 * here so there is no need to check for the loaded state
	 * all over the place.
	 *
	 * @return void
	 * @access private
	 */
	private function init_article() {
        // Find the article in the database
		$this->articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('title', $this->id)->find();
		if (! $this->articleORM->loaded()) {
		    $this->articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('title', str_replace("_", " ", $this->id))->find();
		}
		
		// Initilize article variable
	    if ($this->articleORM->loaded()) {
	        $this->loaded = true;
	        $this->title = $this->articleORM->title;
	        $this->summary = $this->articleORM->summary;
	        $this->summaryHtml = $this->articleORM->summary_html;
	        $this->imageName = $this->articleORM->image_name;
	        $this->imageTitle = $this->articleORM->image_title;
	        $this->template = $this->articleORM->template;
	        $this->templateID = $this->articleORM->template_id;
	        $this->templateName = $this->template->name;
	        $this->lastUpdated = $this->articleORM->lastEditDate;
	    } else {
	        $this->loaded = false;
	        $this->title = "Article Not Loaded";
	        $this->summary = "";
	        $this->summaryHtml = "";
	        $this->imageName = "";
	        $this->imageTitle = "";
	        $this->template = null;
	        $this->templateID = -1;
	        $this->templateName = "";
	        $this->lastUpdated = "";
	    }
    }
	
	
	/**
	 * Save the current article
	 *
	 * @return void
	 * @access private
	 */
	private function save_article() {
        // Save the article
        $this->articleORM->title = $this->request->post('articleTitle', $this->id);
        $this->articleORM->summary = $this->request->post('articleSummary', $this->summary);
        $this->articleORM->summary_html = $this->sectionTypeObjects['txt']->convertRawToHtml($this->articleORM->summary);
        $this->articleORM->image_title = $this->request->post('imageTitle', $this->imageTitle);
        $this->articleORM->template_id = $this->request->post('articleTemplate', $this->templateID);
        $this->articleORM->lastEditIP = $_SERVER['REMOTE_ADDR'];
        $this->articleORM->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
	    $this->articleORM->save();
	    
        // grab the selected template's sections and attributes
        $selectedTemplate = $this->pixie->orm->get('template', $this->articleORM->template_id);
        $sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        $attributeList = $selectedTemplate->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
                
        // Loop through the attributes and save them
        $kvAttr = array();
        foreach ($attributeList as $s) {
            if ($s->type != "hdr") {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $articleAttribute->article_id = $this->articleORM->id;
                $articleAttribute->attribute_id = $s->id;
                $articleAttribute->raw = trim($this->attributeTypeObjects[$s->type]->rawValue($this->request, $s->id));
                $articleAttribute->html = trim($this->attributeTypeObjects[$s->type]->htmlValue($this->request, $s->id));
            
                // Do a little cleanup
                if ($articleAttribute->raw == "") {
                    $articleAttribute->html = "";
                }

                $articleAttribute->lastEditIP = $_SERVER['REMOTE_ADDR'];
                $articleAttribute->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
                if (empty($articleAttribute->raw) && empty($articleAttribute->html)) {
                    if ($articleAttribute->loaded()) {
                        $articleAttribute->delete();
                    }
                } else {
                    $articleAttribute->save();
                }
                $kvAttr[trim(strtolower($s->title))] = $articleAttribute->html;
            }
        }

        // Loop through the sections and save them
        foreach ($sectionList as $s) {
            $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
            $articleSection->article_id = $this->articleORM->id;
            $articleSection->section_id = $s->id;
            $articleSection->raw = trim($this->sectionTypeObjects[$s->type]->rawValue($this->request, $s->id));
            $html = trim($this->sectionTypeObjects[$s->type]->htmlValue($this->request, $s->id));
            $html = $this->pixie->util->replaceValues($kvAttr, $html);
            $articleSection->html = $html;
            
            // Do a little cleanup
            if ($articleSection->raw == "") {
                $articleSection->html = "";
            }
            
            $articleSection->lastEditIP = $_SERVER['REMOTE_ADDR'];
            $articleSection->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
            if (empty($articleSection->raw) && empty($articleSection->html)) {
                if ($articleSection->loaded()) {
                    $articleSection->delete();
                }
            } else {
                $articleSection->save();
            }
        }
	}
	
	
	/**
	 * Deal with creating a new article. This is only dealing with
	 * setting up the title and template, no attributes or sections are created
	 *
	 * @return void
	 * @access private
	 */
	private function create_article() {
        $this->view->pageTitle = "Create page  " . $this->id;
        $this->view->articleTitle = ucwords(str_replace("_", " ", $this->id));
        $this->view->articleSummary = "";
        $this->view->articleTemplate = "";
        $this->view->lastUpdated = "";

    	    if($this->isPost()) {
    	        $this->save_article();
    	        $this->init_article();
            $this->response->redirect('/' . $this->title);
            return true;
    	    }
        
        // Grab templates
        $this->view->templateList = $this->pixie->orm->get('template')->find_all()->as_array();
        if (count($this->view->templateList) == 0) {
            // There are no templates
            return false;
        }
        
        // Setup the view for creating a new article
        $this->pageView = 'Article/Create';
        $this->attributeView = 'Attribute/Edit';
        $this->view->mode = 'edit';
        $this->view->articleAttributeTemplates = "";
        $this->view->articleAttributeJavascript = "";

        $selectedTemplate = $this->view->templateList[0];
        $this->view->selectedTemplateID = $selectedTemplate->id;
        
        // grab the template sections
        $this->view->sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        return true;
	}
}
