<?php
use PHPUnit\Framework\TestCase;
require 'src/dashboard.php';

class GumballMachineTest extends TestCase {

	public $petInstance;
	
	public function setup():void {
		
		$this->petInstance = new Pet();
	}
	
	public function testIfWheelWorks() {
		
		$this->petInstance->setPet("Lovely");
		
		$this->petInstance->changeName();
		
		$this->assertEquals("Postman Cat", $this->petInstance->getPet());
	}
}