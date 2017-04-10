<?php
// +---------------------------------------------------------------------------
// | Author: Tim Van Wassenhove <timvw@users.sourceforge.net>
// | Update: 2006-02-16 18:37
// |
// | This file contains a flexible solution for the pagination problem
// | Documentation is available at: http://timvw.madoka.be/?p=525
// +--------------------------------------------------------------------------- 
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', TRUE);

/**
 * This represents an ordered collection that is accessible in chunks
 */
class Ns_Pageable {
	public $numitems;
	public $begin;
	public $end;
	public $items;

	/**
	 * Default constructor
	 */
	function Ns_Pageable() {
		$this->numitems = null;
		$this->begin = null;
		$this->end = null;
		$this->items = null;
	}
	
	/**
	 * Returns the number of available items in the ordered collection
	 * @return <b>int</b> the number of available items
	 */
	function getNumItems() { 
		if (is_null($this->numitems)) {
			$this->numitems = $this->getNumItemsExtended();
		}
		return $this->numitems;
	}

	/**
	 * Extension point for counting the number of availabe items in the ordered collection
	 * @return <b>int</b> the number of available items
	 */
	function getNumItemsExtended() {
		return 0;
	}
	
	/**
	 * Returns the items between $begin and $end in the ordered collection
	 * @param $begin the order position of the first item in the collection
	 * @param $end the order position of the last item in the collection
	 * @return <b>resource</b> the items in the ordered collection between $begin and $end
	 */
	function getItems($begin, $end) { 
		if ($this->begin != $begin || $this->end != $end || !$this->items) {
			$this->begin = $begin;
			$this->end = $end;
			$this->items = $this->getItemsExtended($begin, $end);
		}
		return $this->items;
	}

	/**
	 * Extension point for retrieving the items between $begin and $end in the ordered collection
	 * @param $begin the order position of the first item in the collection
	 * @param $end the order position of the last item in the collection
	 * @return <b>resoruce</b> the items in the ordered collection between $begin and $end
	 */
	function &getItemsExtended($begin, $end) {
		return array();
	}
}


class Ns_PageableZend_DB extends Ns_Pageable {
	public $db;
	public $select;
	public $result;

	/**
	 * Default constructor
	 * @param $query the query
	 * @param $dblink the database resource
	 */
	function Ns_PageableZend_DB($db, $select) {
		$this->db 		= $db;
		$this->select	= $select;
		$this->sqlc		= $select->__toString();
	}

	/**
	 * @see Ns_Pageable#getNumItemsExtended
	 */
	function getNumItemsExtended() {

		$sql = $this->sqlc;
		$sql = preg_replace('/(\n|\r)/', ' ', $sql);
		$sql = preg_replace('#SELECT\s+(.*?)\s+FROM#i', 'SELECT COUNT(*) AS total FROM', $sql);
		$this->result = $this->db->fetchAll($sql);
		return $this->result[0]['total'];
		
	}

	/**
	 * @see Ns_Pageable#getItemsExtended
	 */
	
	
	function &getItemsExtended($begin, $end) {
		
		$rowcount = $end - $begin;

		$this->select->limit($rowcount, $begin);
		$sql = $this->select->__toString();
		$this->result	= $this->db->fetchAll($sql);
		$this->select->reset();
		return $this->result;
	}
}

/**
 * This class represents a Pager for Ns_Pageable collections. 
 * It is a solution for the pagination problem where you don't want to show all
 * items at once, but only chunks of the collection.
 */
class Ns_Pager {
	public $pageabledata;
	public $currentPage;
	public $itemsPage;

	/**
	 * Default constructor
	 * @param $pageabledata the pageable collection
	 */
	function Ns_Pager(&$pageabledata) {
		$this->current_page = 1;
		$this->itemsPage = 20;
		$this->pageabledata =& $pageabledata;
	}

	/**
	 * Set the current page number
	 * @param $currentPage the number of the current page
	 */
	function setCurrentPage($currentPage) {
		if ($currentPage > 0 && $currentPage <= $this->getLastPage()) {
			$this->current_page = $currentPage;
		} else {
			$this->current_page = 1;
		}
	}

	/**
	 * Return the current page number
	 * @return <b>int</b> the current page number
	 */
	function getCurrentPage() {
		return $this->current_page;
	}

	/**
	 * Set the items per page
	 * @param $itemsPage the number of items per page
	 */
	function setItemsPerPage($itemsPage) {
		if ($itemsPage > 0) {
			$this->itemsPage = $itemsPage;
			$this->setCurrentPage($this->getCurrentPage());
		}
	}

	/**
	 * Return the number of items per page
	 * @return <b>int</b> the number of items per page
	 */
	function getItemsPerPage() {
		return $this->itemsPage;
	}

	/**
	 * Return the number of the last page
	 * @return <b>int</b> the number of the last page
	 */
	function getLastPage() {
		$total = $this->pageabledata->getNumItems();
		$last = ceil($total / $this->itemsPage);
		return $last;
	}

	/**
	 * Return the items in the current page
	 * @return <b>resource</b> the items in the current page
	 */
	function &getItems() {
		$begin = ($this->current_page - 1) * $this->itemsPage;
		$end = $begin + $this->itemsPage;
		$items = $this->pageabledata->getItems($begin, $end);
		return $items;
	}
}

/**
 * This class represents a writer of paged collections
 */
class Ns_PageWriter {
	public $pager;
	public $baseUrl;
	public $pageParam;
	public $itemsPageParam;
	public $params;

	/**
	 * Default constructor
	 * @param $pager the pager
	 * @param $baseUrl the baseurl for the pager
	 * @param $pageParam the name of the page parameter
	 * @param $itemsPageParam the name of the items per page parameter
	 * @param $params additional url parameters in the form of a name=>value array
	 */
	function Ns_PageWriter(&$pager, $baseUrl = '', $pageParam = 'page', $itemsPageParam = 'itemsPage', $params = null) {
		$this->pager =& $pager;
		$this->baseUrl = $baseUrl;
		$this->pageParam = $pageParam;
		$this->itemsPageParam = $itemsPageParam;
		if (is_null($params)) {
			$this->params = array();
		} else {
			$this->params = $params;
		}
	}

	/**
	 * Return the pager
	 * @return <b>Pager</b> the pager
	 */
	function &getPager() {
		return $this->pager;
	}

	/**
	 * Set the additional url parameters
	 * @param $params the parameters
	 */
	function setParameters($params) {
		$this->params = $params;
	}
	
	/**
	 * Set the base url
	 * @param $baseUrl the url
	 */
	function setBaseURL($baseUrl) {
		$this->baseUrl = $baseUrl;
	}
	
	/**
	 * Return the name of the page parameter
	 * @return <b>string</b> the name of the paramter
	 */
	function getPageParam() {
		return $this->pageParam;
	}

	/**
	 * Return the name of the items per page parameter
	 * @return <b>string</b> the name of the parameter
	 */
	function getItemsPerPageParam() {
		return $this->itemsPageParam;
	}
	
	/**
	 * Return an URL
	 * @param $params an array with key->value options that need to be appended to the url
	 * @return <b>string</b> the URL
	 */
	function makeURL($params) {
		$url = $this->baseUrl;

		if (strpos($url, '?') === FALSE) {
			$url .= '?';
		} else {
			$url .= '&';
		}

		foreach($this->params as $name => $value) {
			$url .= $name. '=' . urlencode($value) . '&';
		}
		
		foreach($params as $name => $value) {
			$url .= $name . '=' . urlencode($value) . '&';
		}

		$url = substr($url, 0, -1);
		
		return $url;
	}

	/**
	 * Generate html for the items per page links
	 * @return <b>string</b> the html
	 */
	function makeItemsPerPageLinks() {
		$currentPage = $this->pager->getCurrentPage();
		$html = "<div class='itemsperpage'>";
                $url = $this->makeURL(array($this->pageParam => $currentPage, $this->itemsPageParam => 10));
                $html .= "<a href='{$url}'>show 10</a> |";
                $url = $this->makeURL(array($this->pageParam => $currentPage, $this->itemsPageParam => 25));
                $html .= "<a href='{$url}'>show 25</a> |";
                $url = $this->makeURL(array($this->pageParam => $currentPage, $this->itemsPageParam => 50));
                $html .= "<a href='{$url}'>show 50</a> |";
                $url = $this->makeURL(array($this->pageParam => $currentPage, $this->itemsPageParam => 100));
                $html .= "<a href='{$url}'>show 100</a>";
                $html .= "</div>";
		return $html;
	}

	/**
	 * Generate html for the subcollection of items
	 * @return <b>string</b> the html
	 */
	function makeItemsTable() {
		$items = $this->pager->getItems();
		$html = "<div class='itemstable'>";
		$html .= "<table>";
                foreach($items as $item) {
                        $html .= "<tr>";

                        foreach($item as $name => $val) {
                                $html .= "<td>" . htmlentities($val, ENT_QUOTES, 'UTF-8') . "</td>";
                        }

                        $html .= "</tr>";
                }
                $html .= "</table>";
		$html .= "</div>";
		return $html;
	}

	/**
	 * Generate html for the pager
	 * @return <b>string</b> the html
	 */
	function makeItemsPager() {
                $currentPage = $this->pager->getCurrentPage();
                $lastPage = $this->pager->getLastPage();
                $prevPage = $currentPage - 1;
                $nextPage = $currentPage + 1;
                $itemsPage = $this->pager->getItemsPerPage();
		$html = "<div class='itemspager'>";

                if ($currentPage != 1) {
                        $url = $this->makeURL(array($this->pageParam => 1, $this->itemsPageParam => $itemsPage));
                        $html .= "<a href='{$url}'> &lt;&lt;FIRST </a>";
                        $url = $this->makeURL(array($this->pageParam => $prevPage, $this->itemsPageParam => $itemsPage));
                        $html .= "<a href='{$url}'> &lt;PREV </a>";
                }

                $html .= " (Page {$currentPage} of {$lastPage}) ";

                if ($currentPage != $lastPage) {
                        $url = $this->makeURL(array($this->pageParam => $nextPage, $this->itemsPageParam => $itemsPage));
                        $html .= "<a href='{$url}'> NEXT&gt; </a>";
                        $url = $this->makeURL(array($this->pageParam => $lastPage, $this->itemsPageParam => $itemsPage));
                        $html .= "<a href='{$url}'> LAST&gt;&gt; </a>";
                }

		$html .= "</div>";
		return $html;
	}
		
	/**
	 * Generate html for the paged collection
	 * @return <b>string</b> the html
	 */	
	function render() {
		$html = "<div class='paginator'>";
		$html .= $this->makeItemsPerPageLinks();
		$html .= $this->makeItemsTable();
		$html .= $this->makeItemsPager();
		$html .= "</div>";
		
		return $html;
	}
}

/**
 * This class represents a writer of paged collections
 */
class Ns_PageSmartyWriter {
	public $pager;
	public $baseUrl;
	public $pageParam;
	public $itemsPageParam;
	public $params;

	/**
	 * Default constructor
	 * @param $pager the pager
	 * @param $baseUrl the baseurl for the pager
	 * @param $pageParam the name of the page parameter
	 * @param $itemsPageParam the name of the items per page parameter
	 * @param $params additional url parameters in the form of a name=>value array
	 */
	function Ns_PageSmartyWriter(&$pager, $baseUrl = '', $pageParam = 'page', $itemsPageParam = 'itemsPage', $params = null) {
		$this->pager =& $pager;
		$this->baseUrl = $baseUrl;
		$this->pageParam = $pageParam;
		$this->itemsPageParam = $itemsPageParam;
		if (is_null($params)) {
			$this->params = array();
		} else {
			$this->params = $params;
		}
	}

	/**
	 * Return the pager
	 * @return <b>Pager</b> the pager
	 */
	function &getPager() {
		return $this->pager;
	}

	/**
	 * Set the additional url parameters
	 * @param $params the parameters
	 */
	function setParameters($params) {
		$this->params = $params;
	}
	
	/**
	 * Set the base url
	 * @param $baseUrl the url
	 */
	function setBaseURL($baseUrl) {
		$this->baseUrl = $baseUrl;
	}
	
	/**
	 * Return the name of the page parameter
	 * @return <b>string</b> the name of the paramter
	 */
	function getPageParam() {
		return $this->pageParam;
	}

	/**
	 * Return the name of the items per page parameter
	 * @return <b>string</b> the name of the parameter
	 */
	function getItemsPerPageParam() {
		return $this->itemsPageParam;
	}
	
	/**
	 * Return an URL
	 * @param $params an array with key->value options that need to be appended to the url
	 * @return <b>string</b> the URL
	 */
	function makeURL($params) {
		$url = $this->baseUrl;

		if (strpos($url, '?') === FALSE) {
			$url .= '?';
		} else {
			$url .= '&';
		}

		foreach($this->params as $name => $value) {
			$url .= $name. '=' . urlencode($value) . '&';
		}
		
		foreach($params as $name => $value) {
			$url .= $name . '=' . urlencode($value) . '&';
		}

		$url = substr($url, 0, -1);
		
		return $url;
	}

	/**
	 * Generate html for the items per page links
	 * @return <b>string</b> the html
	 */
	function makeItemsPerPageLinks() {
		$currentPage = $this->pager->getCurrentPage();
		$html = "";
		$data['links'] = $html;
		
		return $data;
	}

	/**
	 * Generate html for the subcollection of items
	 * @return <b>string</b> the html
	 */
	function makeItemsTable() {
			$items = $this->pager->getItems();
		return $items;
	}

	/**
	 * Generate html for the pager
	 * @return <b>string</b> the html
	 */
	function makeItemsPager() {
                $currentPage = $this->pager->getCurrentPage();
                $lastPage = $this->pager->getLastPage();
                $prevPage = $currentPage - 1;
                $nextPage = $currentPage + 1;
                $itemsPage = $this->pager->getItemsPerPage();
                
                $html ='
				<table border="0" align="right" cellpadding="0" cellspacing="2">
				<tr>
					<td align="right">%s %s</td>
					<td align="center">&nbsp;%s&nbsp;</td>
					<td align="left">%s %s</td>
				</tr>
				<tr>
					<td colspan="3" align="center"> %s </td>
				</tr>
				</table>';

                
                if ($currentPage != 1) {
                        $url = $this->makeURL(array($this->pageParam => 1, $this->itemsPageParam => $itemsPage));
                        $backward = "<input type=\"button\" name=\"Submit\" value=\"&lt;\"  style=\"cursor: pointer;\" onClick=\"irPagina('1');\"/>";
                         
                        //$html .= "<a href='{$url}'> &lt;&lt;FIRST </a>";
                        //$url = $this->makeURL(array($this->pageParam => $prevPage, $this->itemsPageParam => $itemsPage));
                        $allbackward = "<input type=\"button\" name=\"Submit\" value=\"&lt;&lt;\"  style=\"cursor: pointer;\" onClick=\"irPagina('" . $prevPage . "');\"/>";
                        //$html .= "<a href='{$url}'> &lt;PREV </a>";
                }
				
                
                $currentPageInputText = "<input name=\"currentPage\" type=\"text\" value=\"" . $currentPage . "\" size=\"" . strlen($currentPage) . "\"" . "onChange=\"irPagina(this.value);\" />";
                
                
                //$html .= " (Page {$currentPage} of {$lastPage}) ";

                if ($currentPage != $lastPage) {
                        //$url = $this->makeURL(array($this->pageParam => $nextPage, $this->itemsPageParam => $itemsPage));
                        $forward = "<input type=\"button\" name=\"Submit\" value=\"&gt;&gt;\"  style=\"cursor: pointer;\" onClick=\"irPagina('" . $nextPage . "');\"/>";
                       // $html .= "<a href='{$url}'> NEXT&gt; </a>";
                        //$url = $this->makeURL(array($this->pageParam => $lastPage, $this->itemsPageParam => $itemsPage));
                        $allforward = "<input type=\"button\" name=\"Submit\" value=\"&gt;\"  style=\"cursor: pointer;\" onClick=\"irPagina('" . $lastPage . "');\"/>";
                        //$html .= "<a href='{$url}'> LAST&gt;&gt; </a>";
                }
				
                $overview = '<span style="font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif; color:#666666;">'; 
                $overview .= $currentPage.'/'. $lastPage .' pags, '. $this->pager->pageabledata->numitems .' objs  	';
				$overview .= '</span>';
				
                $html = sprintf($html, $backward, $allbackward, $currentPageInputText, $forward, $allforward, $overview);
		return $html;
	}
		
	/**
	 * Generate html for the paged collection
	 * @return <b>array</b> 	 
	 * */	
	function render() {
		$data['items'] 	= $this->makeItemsTable();
		$data['pager']	= $this->makeItemsPager();
		return $data;
	}
}

/**
 * This class represents a PageJumpWriter
 */
class Ns_PageJumpWriter extends Ns_PageWriter {
        /**
         * Default constructor
         * @param $pager the pager
         * @param $baseUrl the baseurl for the pager
         * @param $pageParam the name of the page parameter
	 * @param $itemsPageParam the name of the items per page parameter
	 * @param $params additional url parameters in the form of a name=>value array
         */
	function Ns_PageJumpWriter(&$pager, $baseUrl = '', $pageParam = 'page', $itemsPageParam = 'itemsPage', $params = null) {
		parent::Ns_PageWriter($pager, $baseUrl, $pageParam, $itemsPageParam, $params);
	}

	/**
	 * Generate html for the items pager 
	 * @see PageWriter#makeItemsPager
	 */
	function makeItemsPager() {
                $currentPage = $this->pager->getCurrentPage();
                $lastPage = $this->pager->getLastPage();
                $prevPage = $currentPage - 1;
                $nextPage = $currentPage + 1;
		$itemsPage = $this->pager->getItemsPerPage();
                $html = "<div class='itemspager'>\n";
		$html .= "<form method='GET' action='{$this->baseUrl}' onChange='this.submit()'>\n";
		$html .= "<select name='{$this->pageParam}'>\n";
		for ($i = 1; $i <= $lastPage; ++$i) {
			if ($i != $currentPage) {
				$html .= "<option value='{$i}'>Page {$i} of {$lastPage}</option>\n";
			} else {
				$html .= "<option value='{$i}' selected>Page {$i} of {$lastPage}</option>\n";
			}
		}
		$html .= "</select>\n";
		$html .= "<input type='hidden' name='{$this->itemsPageParam}' value='{$itemsPage}'/>\n";
		foreach($this->params as $name => $value) {
			$html .= "<input type='hidden' name='{$name}' value='{$value}'/>\n";
		}
		$html .= "<input type='submit' value='Go'/>\n";
		$html .= "</form>\n";
                $html .= "</div>\n";
                return $html;
	}
}

/**
 * This class represents a Paginator
 */
class Ns_Paginator {
	public $pagewriter;

	/**
	 * Default constructor
	 * @param $pagewriter the pagewriter
	 */
	function Ns_Paginator(&$pagewriter) {
		$this->pagewriter =& $pagewriter;
	}

	/**
	 * Run the paginator code
	 */
	function run() {
		$pager =& $this->pagewriter->getPager();
		$pageParam = $this->pagewriter->getPageParam();
		$itemsPageParam = $this->pagewriter->getItemsPerPageParam();
		
		if (isset($_REQUEST[$pageParam]) && is_numeric($_REQUEST[$pageParam])) {
			$pager->setCurrentPage($_REQUEST[$pageParam]);
		}

		if (isset($_REQUEST[$itemsPageParam]) && is_numeric($_REQUEST[$itemsPageParam])) {
			$pager->setItemsPerPage($_REQUEST[$itemsPageParam]);
		}
	}

	/**
	 * Output the generated paginator
	 */
	function output() {
		return $this->pagewriter->render();
	}
}
?>