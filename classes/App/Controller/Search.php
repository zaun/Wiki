<?php
namespace App\Controller;

class Search extends \App\Page {    

    protected $template = "article";

    public function action_view() {
        if (isset($_POST['searchItem'])) {
            return $this->response->redirect('/~search/' . $_POST['searchItem']);
            $this->execute=false;
            return;
        }

        // Set the mode to view
        $this->view->canEdit = false;
        $this->view->canTalk = false;
        $this->pageView = 'Search/View';
        
        $query = "SELECT
  sum(score * multiplier) score,
  max(locTitle) locTitle,
  max(locSummary) locSummary,
  max(locContent) locContent,
  id,
  title,
  summary_html
FROM
(
  SELECT
    MATCH(title) AGAINST (? IN NATURAL LANGUAGE MODE) score,
    1 multiplier,
    1 locTitle,
    0 locSummary,
    0 locContent,
    id,
    title,
    summary_html
  FROM articles
  WHERE MATCH(title) AGAINST (? IN BOOLEAN MODE)
  UNION ALL
  SELECT
    MATCH(summary_html) AGAINST (? IN NATURAL LANGUAGE MODE) score,
    1.2 multiplier,
    0 locTitle,
    1 locSummary,
    0 locContent,
    id,
    title,
    summary_html
  FROM articles
  WHERE MATCH(summary_html) AGAINST (? IN BOOLEAN MODE)
  UNION ALL
  SELECT
    MATCH(html) AGAINST (? IN NATURAL LANGUAGE MODE) score,
    1.5 multiplier,
    0 locTitle,
    0 locSummary,
    1 locContent,
    a.id,
    title,
    summary_html
  FROM articleSections
  INNER JOIN articles a ON a.id = article_id
  WHERE MATCH(html) AGAINST (? IN BOOLEAN MODE)
) t
WHERE score > 0
GROUP BY id, title
ORDER BY score DESC, title;";

        $search = str_replace("_", " ", $this->request->param('term', ''));
        $this->view->searchItem = $search;
        $params = array($search, $search, $search, $search, $search, $search);
        
        $this->view->results = $this->pixie->db->get()->execute($query, $params)->as_array();
    }
    
}
