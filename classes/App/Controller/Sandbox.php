<?php
namespace App\Controller;

// This is basically a special case Article. There is 
// some additional logic to keep things clean and usfeful
class Sandbox extends \App\Controller\Article {    

	protected function init_article() {
	    $this->id = "~sandbox";
	    $this->init_sandbox();
	    return parent::init_article();
	}
	
	protected function save_article() {
        parent::save_article();
        $this->articleORM->title = "Sandbox";
        $this->articleORM->url = "~sandbox";
        $this->articleORM->summary = "Welcome to the Sandbox! This is a special article that should be used to practice and to carry out experiments. Content will not stay permanently; this page is automatically cleaned regularly, although it tends to be overwritten by other testing users much faster than that. Additionally this article will not save changes to the title or the summary.";
        $this->articleORM->summary_html = $this->sectionTypeObjects['txt']->convertRawToHtml($this->articleORM->summary);
        $this->articleORM->save();
        $this->title = "~sandbox";
    }
    
    public function after() {
        $this->view->id = "~sandbox";
        $this->view->pageTitle = "~sandbox";
        $this->view->articleTitle = "Sandbox";
        $this->view->selectedTemplateID = -1;
        $this->view->templateList = array();
        return parent::after();
    }
    
	private function init_sandbox() {
	    // Make sure the sandbox template exists
        $templateData = $this->pixie->orm->get('template')->where('name', 'Sandbox')->find();
        $templateData->name = "Sandbox";
        $templateData->description = "An auto maintained template used for the sandbox page";
        $templateData->save();
        $templateData = $this->pixie->orm->get('template')->where('name', 'Sandbox')->find();
        $order = 0;
        foreach ($this->sectionTypeObjects as $s) {
            $templateSection = $this->pixie->orm->get('templateSection')->where('type', $s->abbr)->where('template_id', $templateData->id)->find();
            $templateSection->template = $templateData;
            $templateSection->title = $s->name;
            $templateSection->type = $s->abbr;
            $templateSection->order = $order++;
            $templateSection->save();
        }
        $order = 0;
        $templateAttr = $this->pixie->orm->get('templateAttribute')->where('type', 'hdr')->find();
        $templateAttr->template = $templateData;
        $templateAttr->title = "Attributes";
        $templateAttr->type = "hdr";
        $templateAttr->order = $order++;
        $templateAttr->save();
        foreach ($this->attributeTypeObjects as $s) {
            if ($s->abbr != "hdr") {
                $templateAttr = $this->pixie->orm->get('templateAttribute')->where('type', $s->abbr)->where('template_id', $templateData->id)->find();
                $templateAttr->template = $templateData;
                $templateAttr->title = $s->name;
                $templateAttr->type = $s->abbr;
                $templateAttr->order = $order++;
                $templateAttr->save();
            }
        }
        
        // Make sure the article exists
        $articleORM = $this->articleORM = $this->pixie->orm->get('article')->where('url', '~sandbox')->find();
        if (!$articleORM->loaded()) {
            $articleORM->title = "Sandbox";
            $articleORM->url = "~sandbox";
            $articleORM->template = $templateData;
            $articleORM->summary = "Welcome to the Sandbox! This is a special article that should be used to practice and to carry out experiments. Content will not stay permanently; this page is automatically cleaned regularly, although it tends to be overwritten by other testing users much faster than that. Additionally this article will not save changes to the title or the summary.";
            $articleORM->summary_html = $this->sectionTypeObjects['txt']->convertRawToHtml($articleORM->summary);
            $articleORM->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
            $articleORM->save();
        }
    }
}
