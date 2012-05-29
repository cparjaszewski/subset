<?php
class SubsetProblemSolver {

	
	/*
	 * Required sum
	 */
	protected $_sum;
	
	/*
	 * Input array of integers
	 */
	protected $_array;
	
	/*
	 * Sum of positive integers in array
	 */
	protected $_A;
	
	/*
	 * Sum of negative integers in array
	 */
	protected $_B;
	
	/*
	 * Sum of absolute values of all integers in array
	*/
	protected $_C;
	
	/*
	 * Input array size
	 */
	protected $_n;
	
	/*
	 * Temporary array with number of solutions
	 */
	protected $_V;
	
	/*
	 * Stack for building path
	 */
	protected $_pathStack;
	
	
	/*
	 * Constructor
	 */
	public function __construct( $array, $sum) {
		$this->_array = $array;
		$this->_sum = $sum;
		$this->_V = array();
		$this->_n = count($this->_array);
		$this->_A = 0; 
		$this->_B = 0;
		$this->_C = 0;
		$this->_pathStack = array();
	}
	
	/*
	 * The pseudo-dynamic algorithm for the given input
	 * @param $array - input array of integers
	 * @param $sum - required sum, integer
	 */
	public function solve( ) {
	
		// Positive and negative elements summation:
		foreach($this->_array as $el) {
			if ($el > 0) {
				$this->_A += $el; $this->_C += $el;
			} else {
				$this->_B += $el; $this->_C -= $el;
			}
		}
	
		// Sum validation :
		if (($this->_sum > $this->_A) || ($this->_sum < $this->_B)) {
			return false; // it is impossible to get such a huge/small sum with so small elements!
		}
	
		//
		// THE PSEUDO-DYNAMIC ALGORITHM :
		//
		// first row reset:
		for($a = 0; $a <= $this->_C; $a++) {
			$this->_V[0][$a] = 0;
		}
	
		// In the first row only one element can be chosen:
		$first = $this->_array[0] - $this->_B; // we need to shift the index, while array does not accept negative indexes
		$this->_V[0][$first]++;
	
		// The subsequent rows :
		for($i = 1; $i < $this->_n; $i++) {
			$el = $this->_array[$i];  // the loop takes elements one by one
			for($a = 0, $b = $this->_B; $a <= $this->_C; $a++, $b++) {
				// 
				// Init:
				// CASE 4:
				// 
				$this->_V[$i][$a] = 0; 
				
				// 
				// CASE 1: We skip the current element
				//
				$skipCurrentEl = $this->_V[$i - 1][$a];
				if ( $skipCurrentEl ) {
					$this->_V[$i][$a] = $skipCurrentEl; // we skip the current a_k element and deduce true value from the previous subset
				}

				//
				// CASE 2: We start path using the current element
				//
				if ( $el == $b ) {
					$this->_V[$i][$a]++; // we build a one-element length subset containing only from one element that already equals p
				}
				
				//
				// CASE 3: We continue path using the current element
				//
				$minusCurrentElIndex = $a - $el;
				if ( ($minusCurrentElIndex >= 0) && ($minusCurrentElIndex <= $this->_C) ) {
					$sumWithCurrentEl = $this->_V[$i - 1][ $minusCurrentElIndex ];
					if ( $sumWithCurrentEl ) {
						// a. construct the sum from elements a_1, a_2, ..., to a_k-1 that has inside a subset which sums up to p - a_k, 
						// b. use the a_k element to sum to p
						$this->_V[$i][$a] += $sumWithCurrentEl;
					}
				}
			}
		}
		// We now must read the result from the V array:
		$paths = array();
		$this->_addToPathStack($this->_n - 1, $this->_sum, 0);
		$this->_buildPaths($paths);
		
		return $paths;
	}

	/*
	 * Paths builder
	 * @currentIndex- 2-D array of possible results
	 * @requestedSum - number of elements
	 */
	protected function _buildPaths( &$paths ) {
		while( count($this->_pathStack) ) {
			// We take the top element from the Stack:
			$stackTop = array_pop($this->_pathStack);
			
			// We read the elements from the stack top:
			$currentIndex = $stackTop['index'];
			$requestedSum = $stackTop['sum'];
			$pathIndex = $stackTop['pathIndex'];
			
			// Number of paths summing to $requestedSum starting using first $currentIndex elements of array
			$el = $this->_array[ $currentIndex ];
			$numberOfPaths = $this->_V[ $currentIndex ][ $requestedSum - $this->_B ]; // 
			
			// In case the paths were not initialized we shall add re-initialize them:
			if (count($paths) < $numberOfPaths ) {
				for($v = count($paths); $v < $numberOfPaths ; $v++ ) {
			 		$paths[$v] = array();
				}
			}
			

			if( $currentIndex < 0) {
				continue;
			}
			
			// Are there any paths with current element?
			$requestedSumMinusEl = $requestedSum - $el - $this->_B;
			$numberOfPathsWithEl = ($currentIndex && ($requestedSumMinusEl >= 0) && ($requestedSumMinusEl <= $this->_C) ) ? $this->_V[$currentIndex-1][$requestedSumMinusEl] : 0;
	
			// Are there any paths without current element?
			$numberOfPathsWithoutEl = $currentIndex ? $this->_V[$currentIndex - 1][$requestedSum - $this->_B] : 0;
			
			//
			// CASE 1: We build the with WITH current element
			//
			if ( $numberOfPathsWithEl ) {
				for($nop = $pathIndex; $nop < $pathIndex + $numberOfPathsWithEl; $nop++) {
					if (!is_array($paths[$nop])) {
						$paths[$nop] = array($paths[$nop]);
					}
					array_push($paths[$nop], $el);
				}
				$this->_addToPathStack($currentIndex - 1, $requestedSum - $el, $pathIndex);
			}
			
			//
			// CASE 2: We build the with WITHOUT current element
			//		
			if ( $numberOfPathsWithoutEl ) {
				$this->_addToPathStack($currentIndex - 1, $requestedSum, $pathIndex + $numberOfPathsWithEl );
			}
			

			//
			// CASE 3: The requested sum is equal to current el
			//
			if ( $el == $requestedSum ) {
				if ( !in_array($el, $paths[$pathIndex+$numberOfPathsWithEl]) ) {
					array_push($paths[$pathIndex+$numberOfPathsWithEl], $el);
				}
			}
		}
		
		// We must remove the empty paths:
		$tempPaths = array();
		foreach($paths as $path) {
			if($path != 0 && count($path) != 0) {
				$tempPaths[] = $path;
			}
		}
		$paths = $tempPaths;
	}
	
	/*
	 * A function that adds elements on the path-builder stack:
	 */
	protected function _addToPathStack( $currentIndex, $requestedSum, $pathIndex ) {
		array_push( 
			$this->_pathStack,
			array( 'index' => $currentIndex,
					'sum' => $requestedSum,
					'pathIndex' => $pathIndex) 
			);
	}
}