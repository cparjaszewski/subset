<?php
/*
 * @ The 
*/
class FormController {
	
	/*
	 * Constructor
	 */
	public function __construct() {
		
	}
	
	/*
	 * @ Main starting point
	*/
	public function _displayForm() {
		include('theme/form.php');
	}
	
	/*
	 * Depending on the input - we are displaying the input form or solving the subset sum problem.
	*/
	public function handleInputArray( $params ) {
		$array = isset($params['array']) ? explode(",",$params['array']) : null;
		$sum = isset($params['sum']) ? $params['sum'] : null;
		
		// We are displaying header
		$this->_displayHeader();
		
		if (!($sum && $array)) {
			$this->_displayForm();
		} else {
			$spSolver = new SubsetProblemSolver($array, $sum);
			$paths = $spSolver->solve();   // solve the subset sum problem
			$this->_displayPaths($array, $paths, $sum);
		}
		
		// We are displaying footer file
		$this->_displayFooter();
	}
	/*
	 * Displaying the header file:
	*/
	protected function _displayHeader()  {
		include('theme/_header.php');
	}
	
	/*
	 * Displaying the footer file:
	*/
	protected function _displayFooter()  {
		include('theme/_footer.php');
	}
	
	/*
	 * Displaying the path response:
	 */
	public function _displayPaths( $array, $paths, $sum) {
		if (!isset($paths) || !count($paths)) {
			return false;
		}
		echo '<h3> Given array: ';
		foreach($array as $el) {
			echo $el . ', ';
		}
		echo '<h3> for requested sum = '. $sum . ' we have found: '. count($paths) . ' results:</h3>';
		echo '<article id="resultPaths">';
		
		for($p = 0; $p < count($paths); $p++) {
			echo '<strong>(OPTION ' . ( $p + 1 ) . '):</strong>  ';
			$path = $paths[$p];
			for($i=0; $i < count($path); $i++) {
				echo $path[$i];
				if ($i != count($path) - 1) {
					echo ' + '; 
				}
			}
			echo ' = '. $sum . ' <br />';
		}
		
		echo '</article>
		<a href="index.php" title="Once More">
			<img class="button" src="theme/img/once_more.png" title="Once More" alt = "Once More" />
		</a>';
	}
}