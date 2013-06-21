<?php
namespace App\Controller;

class Special extends \PHPixie\Controller {    
    
    function action_random() {
        $count = $this->pixie->orm->get('article')->count_all();
        $article = $this->pixie->orm->get('article')->offset(rand(0, $count - 1))->limit(1)->find();
        return $this->response->redirect('/' . $article->title);
    }
}
