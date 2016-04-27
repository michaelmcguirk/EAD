<?php
/* 
 This class requires methods to get and set the bank account's balance 
 as well methods to deposit and withdraw money. 
*/

require_once ('../SimpleTest/SimpleTest/autorun.php');
 
class testValidationClass extends UnitTestCase {
	
	private $validationClass;
	public function setUp() {
		require_once ('../app/ValidationClass.php');
		$this->validationClass = new ValidationClass();
	}
	
	public function tearDown() {
		$this->validationClass = NULL;
	}
	
	/* Tests for function isEmailValid */
	public function testIsEmailValid() {
		
		// Tests with valid data
		$email = "a@b.com";
		$this->assertTrue($this->validationClass->IsEmailValid($email), 'Valid email '.$email.' rejected');
		$email = "a@b.org";
		$this->assertTrue($this->validationClass->IsEmailValid($email), 'Valid email '.$email.' rejected');
		$email = "a123@bcd.me";
		$this->assertTrue($this->validationClass->IsEmailValid($email), 'Valid email '.$email.' rejected');
		
		// Tests with invalid data
		$email ="a@@b.com";
		$this->assertFalse($this->validationClass->IsEmailValid($email), 'Invalid email '.$email.' accepted');
		$email ="a.b@com";
		$this->assertFalse($this->validationClass->IsEmailValid($email), 'Invalid email '.$email.' accepted');
		$email ="@bbbb.com";
		$this->assertFalse($this->validationClass->IsEmailValid($email), 'Invalid email '.$email.' accepted');
		$email ="aaaa@.com";
		$this->assertFalse($this->validationClass->IsEmailValid($email), 'Invalid email '.$email.' accepted');
//		$email =["foo" => "bar", "bar" => "foo"];
//		$this->assertFalse($this->validationClass->IsEmailValid($email), 'Invalid email '.$email.' accepted');
		
	}

	/* Tests for function isNumberInRange */
	public function testIsNumberInRangeValid() {
		
		// Tests with valid data
		$num=5; $min=1; $max=10;
		$this->assertTrue($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." rejected for range ".$min." to ".$max);
		$num=3.1415; $min=1; $max=10.99;
		$this->assertTrue($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." rejected for range ".$min." to ".$max);
		$num="5"; $min=1; $max=10;
		$this->assertTrue($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." rejected for range ".$min." to ".$max);
		
		// Tests with invalid data
		$num=10.0000000000001; $min=1; $max=10;
		$this->assertFalse($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." accepted for range ".$min." to ".$max);
		$num=-1; $min=1; $max=1000000;
		$this->assertFalse($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." accepted for range ".$min." to ".$max);
		$num=15; $min=1; $max=10;
		$this->assertFalse($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." accepted for range ".$min." to ".$max);
		$num="Five"; $min=1; $max=10;
		$this->assertFalse($this->validationClass->IsNumberInRangeValid($num, $min, $max), $num." accepted for range ".$min." to ".$max);
		
	}
	
	/* Tests for function isLengthString*/
	public function testIsLengthStringValid() {
		
		// Tests with valid data
		$str = "A string"; $max = 8;
		$this->assertTrue($this->validationClass->IsLengthStringValid($str, $max), $str." rejected for max length ".$max);

		$str = "A string"; $max = 50;
		$this->assertTrue($this->validationClass->IsLengthStringValid($str, $max), $str." rejected for max length ".$max);
		
		$str = "-1"; $max = 50;
		$this->assertTrue($this->validationClass->IsLengthStringValid($str, $max), $str." rejected for max length ".$max);
		
		
		// Tests with invalid data
		$str = "A string"; $max = -8;
		$this->assertFalse($this->validationClass->IsLengthStringValid($str, $max), $str." accepted for max length ".$max);
		
		$str = "A string"; $max = 2;
		$this->assertFalse($this->validationClass->IsLengthStringValid($str, $max), $str." accepted for max length ".$max);
	
		$str = "A string"; $max = "";
		$this->assertFalse($this->validationClass->IsLengthStringValid($str, $max), $str." accepted for max length ".$max);
				
	}

}
?>