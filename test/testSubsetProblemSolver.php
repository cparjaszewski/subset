<?php

require_once('../controller/SubsetProblemSolver.php');


class TestSubsetProblemSolver {
	/*
	 * Constructor
	 */
	public function __construct() {
		
	}
	
	/*
	 * Main test runner
	 */
	public function runTests() {
		$fail = false;
		$fail = $fail | $this->_test1();
		$fail = $fail | $this->_test2();
		$fail = $fail | $this->_test3();
		$fail = $fail | $this->_test4();
		$fail = $fail | $this->_test5();
		if (!$fail) {
			echo "Tests OK";
		}
	}
	
	/*
	 * Example case
	*/
	protected function _test1() {
		$array = array (1, 5, 4, 8, -1, 3);
		$sum = 7;
		
		return $this->_testAny($array, $sum, "1");
	}
	
	protected function _test2() {
		$array = array (1, -1, 2, -2, 3, 4);
		$sum = 2;
		
		return $this->_testAny($array, $sum, "2");
	}
	
	protected function _test3() {
		$array = array (1, -1, 2, -2, 3, 4, 5, 6, 7, -8, 9, -10);
		$sum = -3;
		
		return $this->_testAny($array, $sum, "3");
	}
	
	protected function _test4() {
		$array = array (1, -1, 2, -2);
		$sum = 2;
		
		return $this->_testAny($array, $sum, "4");
	}
	
	protected function _test5() {
		$array = array (1, -2, -1, -3, -4, -5, 2, 3);
		$sum = 2;
	
		return $this->_testAny($array, $sum, "5");
	}
	
	protected function _testAny( $array, $sum, $name) {
		$spSolver = new SubsetProblemSolver($array, $sum);
		$paths = $spSolver->solve();   // solve the subset sum problem
		
		foreach($paths as $path) {
			$pathSum = 0;
			foreach($path as $value) {
				$pathSum += $value;
			}
			if ($pathSum != $sum) {
				echo "<strong>Test" . $name . " failed - </strong> for sum = " . $sum;
				echo "<br /> wrong path: ";
				foreach($path as $el) {
					echo $el . ', ';
				}
				echo "<br />";
				echo "<br />";
				echo "Paths: <br /><pre>";
				echo print_r($paths)."</pre>";
				return false;
			}
		}
		echo "<strong>Test " . $name . "</strong> OK <br />";
		return true;
	}
}