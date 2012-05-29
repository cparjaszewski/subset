<?php

require_once('FormController.php');
require_once('SubsetProblemSolver.php');


class MainController {
	
	/*
	 * input parameters
	*/
	protected $_inputParameters;
	
	/*
	 * @ Constructor
	 */
	public function __construct() {
		
	}
	
	/*
	 * @ Main input handler
	 */
	protected function _readInput() {
		// Array init
		if (!$this->_inputParameters) {
			$this->_inputParameters = array();
		}

		// Read _POST variables
		foreach($_POST as $postKey => $post) {
			if(!in_array($post,$this->_inputParameters)) {
				$this->_inputParameters[$postKey] = $post;
			}
		}
		
		// Read _GET variables
		foreach($_GET as $getKey => $get) {
			if(!in_array($get,$this->_inputParameters)) {
				$this->_inputParameters[$getKey] = $get;
			}
		}
	}
	
	/*
	 * @ Main starting point
	 */
	public function startForm() {
		$this->_readInput();
		$formController = new FormController(); 
		$formController->handleInputArray( $this->_inputParameters );
	}

	
	
}