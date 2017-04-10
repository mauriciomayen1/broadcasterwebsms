<?php

class Ns_Paging_Solicitudservicio extends Ns_Paging
{
	public $db;
	public $select;
	public $smarty;
	public $template;
	
	public function __construct($db, $select) {
		$this->db		= $db;
		$this->select	= $select;
		$this->smarty 	= Zend_Registry::get('smarty');
		$this->data		= array();
	}

	private function _pagerData() {
		
		if (!isset($_REQUEST['page']) || $_REQUEST['page'] == null || !ereg('[0-9]', $_REQUEST['page'])) {
			$_REQUEST['page'] ='1';
		}
		
		if (!isset($_REQUEST['itemsPage']) || $_REQUEST['itemsPage'] == null || !ereg('[0-9]', $_REQUEST['itemsPage'])) {
			$_REQUEST['itemsPage'] ='10';
		}
		
		$pageableData = new Ns_PageableZend_DB($this->db, $this->select);
		$pager = new Ns_Pager($pageableData);
		$pager->currentPage	= $_REQUEST['page'];
		$pager->itemsPage 	= $_REQUEST['itemsPage'];

		$pageWriter = new Ns_PageSmartyWriter($pager);
		$paginator = new Ns_Paginator($pageWriter);
		$paginator->run();
		$pageWriter->setParameters(array(
				$pageWriter->getPageParam() => $pageWriter->pager->getCurrentPage(),
				$pageWriter->getItemsPerPageParam() => $pageWriter->pager->getItemsPerPage()
		));

		return $paginator->output();
	}

	public function setTemplate($template) {
		$config = Zend_Registry::get('config');
		$this->template = $template;
		$pagerData = $this->_pagerData();

		$puerto = new Ns_QueryTool($config->application['db'][0]['dburl'], 'puerto');

		foreach ($pagerData['items'] as $k => $v) {
			foreach ($v as $k2 => $v2) {
				$pagerDataStrip['items'][$k][$k2] = stripslashes($v2);
				// ----
				if ($k2 =='solicitudservicio_pol') {
					$puerto->reset();
					$pagerDataStrip['items'][$k][$k2] = $puerto->get($v2); 
				}	

				if ($k2 =='solicitudservicio_pod') {
					$puerto->reset();
					$pagerDataStrip['items'][$k][$k2] = $puerto->get($v2); 
				}	

				//----
			}
		}


		//Zend_Debug::dump($pagerDataStrip['items']);

		$this->smarty->assign('rows', $pagerDataStrip['items']);
		$this->smarty->assign('pager', $pagerData['pager']);
		$this->smarty->assign('script', $_SERVER['PHP_SELF']);
		$this->smarty->assign($_REQUEST);
		return true;
	}
	
	public function display() {
		$this->smarty->display($this->template);
	}
}

?>