<?php
/* 
 This class requires methods to get and set the bank account's balance 
 as well methods to deposit and withdraw money. 
*/

require_once ('../SimpleTest/autorun.php');
require_once ('../SimpleTest/web_tester.php');

 
class Tester extends WebTestCase {
	

	public function setUp() {
		$this->addHeader("username: carl");
		$this->addHeader("password: carl");
	}
	
	public function tearDown() {
		
	}
	
	// Tests for GETs (songs, artists, albums, users)
	function testGets() {
		$this->get('http://localhost/ead/ca/app/index.php/songs');
		$this->assertResponse(200);
		$this->get('http://localhost/ead/ca/app/index.php/artists');
		$this->assertResponse(200);
	}
	
	function testPosts() {
		$this->post('http://localhost/ead/ca/app/index.php/albums', 
				'{"album_name":"Mickey","album_year":"1965","artist":"1"}');
		$this->assertResponse(201);
	}

}
?>