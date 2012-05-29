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
		$spSolver = new SubsetProblemSolver($array, $sum);
		$paths = $spSolver->solve();   // solve the subset sum problem
		
		foreach($paths as $path) {
			$pathSum = 0;
			foreach($path as $value) {
				$pathSum += $value;
			}
			if ($pathSum != $sum) {
				echo "<strong>Test1 failed - </strong> the sum = " . $sum;
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
		echo "<strong>Test 1</strong> OK <br />";
		return true;
	}
	
	protected function _test2() {
		$array = array (1, -1, 2, -2, 3, 4);
		$sum = 2;
		$spSolver = new SubsetProblemSolver($array, $sum);
		$paths = $spSolver->solve();   // solve the subset sum problem
	
		foreach($paths as $path) {
			$pathSum = 0;
			foreach($path as $value) {
				$pathSum += $value;
			}
			if ($pathSum != $sum) {
				echo "<strong>Test2 failed - </strong> the sum = " . $sum;
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
		echo "<strong>Test 2</strong> OK <br />";
		return true;
	}
	
	protected function _test3() {
		$array = array (1, -1, 2, -2, 3, 4, 5, 6, 7, -8, 9, -10);
		$sum = -3;
		$spSolver = new SubsetProblemSolver($array, $sum);
		$paths = $spSolver->solve();   // solve the subset sum problem
	
		foreach($paths as $path) {
			$pathSum = 0;
			foreach($path as $value) {
				$pathSum += $value;
			}
			if ($pathSum != $sum) {
				echo "<strong>Test3 failed - </strong> for sum = " . $sum;
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
		echo "<strong>Test 3</strong> OK <br />";
		return true;
	}
	
	protected function _test4() {
		$array = array (1, -1, 2, -2);
		$sum = 2;
		$spSolver = new SubsetProblemSolver($array, $sum);
		$paths = $spSolver->solve();   // solve the subset sum problem
	
		foreach($paths as $path) {
			$pathSum = 0;
			foreach($path as $value) {
				$pathSum += $value;
			}
			if ($pathSum != $sum) {
				echo "<strong>Test4 failed - </strong> for sum = " . $sum;
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
		echo "<strong>Test 4</strong> OK <br />";
		return true;
	}
}