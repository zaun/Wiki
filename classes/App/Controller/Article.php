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
            
            // Grab the article image
            if ($this->imageName != "") {
                $this->view->pageImage = "/" . $this->id . "/media/" . $this->imageName . "/250";
            }
            
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
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $value = "";
                $rawValue = "";
                if ($articleAttribute->loaded()) {
                    $value = $articleAttribute->html;
                }
    		        $object = (object)array('id' => $s->id,
    		                                'type' => $s->type, 
    		                                'title' => $s->title,
    		                                'value' => $value);
    		        
                 if ($s->type == "hdr" || $value != "") {
    		            $pageHasContent = true;
        		        array_push($attributeListTemp, $object);
    		        }
            }
            
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
            
            // Grab the article image
            $this->view->pageImage = "/images/no_image.png";
            if ($this->imageName != "") {
                $this->view->pageImage = "/" . $this->id . "/media/" . $this->imageName . "/250";
            }
    	    
    	    
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
            
            // grab the article references
            $objRef = new \App\Sections\ReferenceList($this->request);
            $this->view->articleSectionTemplates .= $objRef->editOnce();
            $this->view->articleSectionJavascript .= $objRef->jsEdit();
            $raw = "";
            $this->view->referenceSection = $objRef->edit("Refs", "References", $raw);
            
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
    
            // Grab the article image
            if ($this->imageName != "") {
                $this->view->pageImage = "/" . $this->id . "/media/" . $this->imageName . "/250";
            }
    
            // grab the article attributes
            $attributeList = array();
            $attributeListTemp = array();
            $articleAttributes = $this->template->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $value = "";
                if ($articleAttribute->loaded()) {
                    $value = $articleAttribute->html;
                }
                $object = (object)array('id' => $s->id,
                                        'type' => $s->type, 
                                        'title' => $s->title,
                                        'value' => $value);
    		        
                if ($s->type == "hdr" || $value != "") {
                    $pageHasContent = true;
                    array_push($attributeListTemp, $object);
                }
            }
            
            
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
	
	
	public function action_media() {
	    $this->init_article();

	    $mediaTitle = $this->request->param('title', '');
	    $mediaSize = intval(strtolower($this->request->param('size', '450')));
	    $mediaSize = ceil($mediaSize/50) * 50;
	    $media = $this->articleORM->media->where('url', $mediaTitle)->find();
	    $fileHash = "UNKNOWN HASH";
	    if (isset($media->hash)) {
            $fileHash = $media->hash;
	    }
	    $filename = $fileHash;
	    if ($mediaSize != "0") {
	        $filename .= "-" . $mediaSize;
	    }
	    
	    $found = FALSE;
        $scriptPath = dirname(__FILE__);
        $mediaPath = dirname(dirname(dirname($scriptPath))) . "/assets/media/";
        if ($handle = opendir($mediaPath)) {
            while (false !== ($entry = readdir($handle))) {
                if (strtolower(pathinfo($entry, PATHINFO_FILENAME)) == strtolower($filename)) {
                    $filename = $entry;
                	   $found = TRUE;
                }
            }
            closedir($handle);
        }
        
        $orig = FALSE;
        if ($found == FALSE) {
            $filename = $fileHash;
            if ($handle = opendir($mediaPath)) {
                while (false !== ($entry = readdir($handle))) {
                    if (strtolower(pathinfo($entry, PATHINFO_FILENAME)) == strtolower($filename)) {
                        $filename = $entry;
                    	   $found = TRUE;
                        $orig = TRUE;
                    }
                }
                closedir($handle);
            }
        }
        $filename = $mediaPath . $filename;
        
        // If we can't find the file load up the no_image
        if (!file_exists($filename)) {
            $filename = dirname(dirname(dirname($scriptPath))). "/web/images/no_image.png";
        }
        
        // Scale image
        if($found && $orig && file_exists($filename)) {
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (class_exists('Imagick')) {
                $im = new Imagick($filename);
                $im->thumbnailImage($mediaSize, 99999, TRUE);
                $filename = $mediaPath . "/" . $fileHash . "-" . $mediaSize . "." . $ext;
                $im->writeImage($filename);
            } else if (extension_loaded('gd')) {
                ini_set("memory_limit","256M");
                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($filename);
                switch ($source_image_type) {
                    case IMAGETYPE_GIF:
                        $source_gd_image = imagecreatefromgif($filename);
                        break;
                    case IMAGETYPE_JPEG:
                        $source_gd_image = imagecreatefromjpeg($filename);
                        break;
                    case IMAGETYPE_PNG:
                        $source_gd_image = imagecreatefrompng($filename);
                        break;
                }
                if ($source_gd_image !== false) {
                    $source_aspect_ratio = $source_image_width / $source_image_height;
                    $thumbnail_aspect_ratio = $mediaSize / 99999;
                    if ($source_image_width <= $mediaSize && $source_image_height <= 99999) {
                        $thumbnail_image_width = $source_image_width;
                        $thumbnail_image_height = $source_image_height;
                    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                        $thumbnail_image_width = (int) (99999 * $source_aspect_ratio);
                        $thumbnail_image_height = 99999;
                    } else {
                        $thumbnail_image_width = $mediaSize;
                        $thumbnail_image_height = (int) ($mediaSize / $source_aspect_ratio);
                    }
                    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
                    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
                    switch ($source_image_type) {
                        case IMAGETYPE_GIF:
                            $filename = $mediaPath . "/" . $fileHash . "-" . $mediaSize . "." . $ext;
                            imagegif($thumbnail_gd_image, $filename, 90);
                            break;
                        case IMAGETYPE_JPEG:
                            $filename = $mediaPath . "/" . $fileHash . "-" . $mediaSize . "." . $ext;
                            imagejpeg($thumbnail_gd_image, $filename, 90);
                            break;
                        case IMAGETYPE_PNG:
                            $filename = $mediaPath . "/" . $fileHash . "-" . $mediaSize . "." . $ext;
                            imagepng($thumbnail_gd_image, $filename, 90);
                            break;
                    }
                    imagedestroy($thumbnail_gd_image);
                    imagedestroy($source_gd_image);
                }
            }
        }
        
        // Figure the mime type
        $mimetypes = array(
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif'
        );
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mime = "application/octet-stream";
        if(array_key_exists($ext, $mimetypes)) {
            $mime = $mimetypes[$ext];
        }
        
        header('Content-Type: ' . $mime);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
//        print $mediaSize . "<br />";
//        print $found . "<br />";
//        print $orig . "<br />";
//        print $filename;
        exit;
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
	protected function init_article() {
        // Find the article in the database
		$this->articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('url', $this->id)->find();
		if (! $this->articleORM->loaded()) {
		    $this->articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('url', str_replace("_", " ", $this->id))->find();
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
	protected function save_article() {
	    // Setup some article basics
        $this->articleORM->title = $this->request->post('articleTitle', $this->id);
        $this->articleORM->url = $this->request->post('articleTitle', $this->id);
        $this->articleORM->url = str_replace(' ','_', $this->articleORM->url);
        $this->articleORM->url = str_replace("'",'', $this->articleORM->url);
        $this->articleORM->url = strtolower($this->articleORM->url);
        $this->articleORM->image_name = $this->request->post('imageName', $this->imageName);
        $this->articleORM->image_title = $this->request->post('imageTitle', $this->imageTitle);
        $this->articleORM->template_id = $this->request->post('articleTemplate', $this->templateID);
        $this->articleORM->lastEditIP = $_SERVER['REMOTE_ADDR'];
        $this->articleORM->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
	    
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
    		        
    		        // Setup the attributes for filling in the template
                $tempKey = str_replace("(s)", "", trim(mb_strtolower($s->title)));
                $tempValues = $this->attributeTypeObjects[$s->type]->templateValues($articleAttribute->raw);
                $kvAttr[$tempKey] = $tempValues;
            }
        }

        // Save the article
        $this->articleORM->summary = $this->request->post('articleSummary', $this->summary);
        $this->articleORM->summary_html = $this->sectionTypeObjects['txt']->convertRawToHtml($this->pixie->util->replaceValues($kvAttr, $this->articleORM->summary));
        $this->articleORM->save();

        // Loop through the sections and save them
        foreach ($sectionList as $s) {
            $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
            $articleSection->article_id = $this->articleORM->id;
            $articleSection->section_id = $s->id;
            $articleSection->raw = trim($this->sectionTypeObjects[$s->type]->rawValue($this->request, $s->id));
            $html = trim($this->sectionTypeObjects[$s->type]->htmlValue($this->request, $s->id));
            $html = $this->pixie->util->replaceValues($kvAttr, $html);
            $articleSection->html = $this->pixie->util->replaceValues($kvAttr, $html);
            
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
