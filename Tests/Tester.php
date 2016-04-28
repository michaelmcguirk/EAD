<?php
/* 
 This class requires methods to get and set the bank account's balance 
 as well methods to deposit and withdraw money. 
*/

require_once ('../SimpleTest/autorun.php');
require_once ('../SimpleTest/web_tester.php');

 
class Tester extends WebTestCase {
	
	private $route;
	public function setUp() {
		$this->addHeader("username: carl");
		$this->addHeader("password: carl");
		$this->route = "http://localhost/ca/app";
		//$this->route = "http://localhost/ead/ca/app";
	}
	
	public function tearDown() {
		
	}
	
	// Tests for GETs (songs, artists, albums, users)
	function testGet() {
		$this->get($this->route . '/index.php/songs');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/songs/search/the');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/artists');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/artists/search/the');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/albums');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/albums/search/white');
		$this->assertResponse(200);
		
		$this->get($this->route . '/index.php/users');
		$this->assertResponse(200);
	}
	
	function testPost() {
		$this->post($this->route . '/index.php/albums', 
				'{"album_name":"Mickey","album_year":"1965","artist":"1"}');
		$this->assertResponse(201);
		
		$this->post($this->route . '/index.php/artists',
				'{"name":"Jimi Hendrix","country":"US"}');
		$this->assertResponse(201);
		
		$this->post($this->route . '/index.php/users',
				'{"name":"Testy", "surname":"Testerson","email":"mail@mail.com","password":"password","username":"test"}');
		$this->assertResponse(201);
		
		$this->post($this->route . '/index.php/songs',
				'{"song_name":"A Song","duration":"2.45","artist":"1","album":"1","track_no":"1"}');
		$this->assertResponse(201);
	}
	
	function testPut() {	
		$this->put($this->route . '/index.php/users/2',
				'{"name":"Testy", "surname":"Testrson","email":"mail@mail.com","password":"password","username":"test"}');
		$this->assertResponse(200);
		
		$this->put($this->route . '/index.php/albums/4',
				'{"album_name":"Mickey","album_year":"1965","artist":"1"}');
		$this->assertResponse(200);
		
	}

}
?>