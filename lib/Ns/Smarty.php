<?php
class Ns_Smarty extends Smarty
{
	public function __construct() {
		
		$config = Zend_Registry::get('config');
		
		$this->template_dir     = $config->application['templateDir'] . DIRECTORY_SEPARATOR . $config->application['lang'];
		$this->config_dir       = $config->application['configDir'] . DIRECTORY_SEPARATOR . $config->application['lang'];
		$this->compile_dir      = $config->application['compileDir'] . DIRECTORY_SEPARATOR . $config->application['lang'];
		$this->cache_dir        = $config->application['cacheDir'] . DIRECTORY_SEPARATOR . $config->application['lang'];
		$this->debugging        = $config->application['debuging'];
		$this->caching			= $config->application['caching'];
		$this->left_delimiter   = $config->application['leftDelimiter'];
		$this->right_delimiter	= $config->application['rightDelimiter'];
	}
	
	/**
	 * Create html options from QueryTool result
	 *
	 * @param array $resultQueryTool
	 * @param string $key
	 * @param string $value
	 * @param string $description
	 * @return string html options code
	 */
	public function createOptions ($resultQueryTool = array(), $key = '', $value = '', $description = '') {
		$result['']= '- - -';
		foreach($resultQueryTool as $values) {
			$result[$values[$key]]= strtoupper($values[$value]).' '.strtoupper($values[$description]);	
		}
		return $result;
	}
}

?>