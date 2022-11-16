<?php
use PHPUnit\Framework\TestCase;
require 'src/PetShop.php';

class PetShopTest extends TestCase {

	public $petInstance;
	
	public function setup():void {
		
		$this->petInstance = new Pet();
	}
	
	public function testIfWheelWorks() {
		
		$this->petInstance->setPet(100);
		
		$this->petInstance->changeName();
		
		$this->assertEquals(99, $this->petInstance->getPet());
        $this->petInstance->changeName();
        $this->assertEquals(98, $this->petInstance->getPet());
	}
}