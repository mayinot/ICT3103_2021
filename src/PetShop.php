<?php 
	session_start();
	class Pet {

		private $pet;
		
		public function getPet() {
			return $this->pet;
		}
		
		public function setPet($val) {
			$this->pet = $val;
		}
		
		public function changeName() {
			$this->setPet($this->getPet()-1);
		}
	}
?>