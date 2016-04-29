<?php
/* 
 This class requires methods to get and set the bank account's balance 
 as well methods to deposit and withdraw money. 
*/

require_once ('../SimpleTest/autorun.php');
require_once ('../SimpleTest/web_tester.php');

 
class Tester extends WebTestCase {
	
	private $route, $testUserID, $testArtistID, $testSongID, $testAlbumID;
	public function setUp() {
		$this->addHeader("username: carl");
		$this->addHeader("password: carl");
		$this->route = "http://localhost/ca/app";
		// $this->route = "http://localhost/ead/ca/app";
	}
	
	public function tearDown() {}
	
	function testAlbum() {
	
		// Good test data
		$goodAlbum1 = 	'{"album_name":"Album 1",	"album_year":"2001",	"artist":"1"}';
		$goodAlbum2 = 	'{"album_name":"Album 2",	"album_year":"2001",	"artist":"2"}';
	
		// bad test data - field names
		$badAlbum1 = 	'{"album_name_X":"Album 1",	"album_year":"2001",	"artist":"1"}';
		$badAlbum2 = 	'{"album_name":"Album 1",	"album_year_X":"2001",	"artist":"1"}';
		$badAlbum3 = 	'{"album_name":"Album 1",	"album_year_X":"2001",	"artist_X":"1"}';
	
		// bad test data - field values
		$badAlbum4 = 	'{"album_name":"",	"album_year":"2001",	"artist":"1"}';
		$badAlbum5 = 	'{"album_name":"Album 1",	"album_year":"20 X",	"artist":"1"}';
		$badAlbum6 = 	'{"album_name":"Album 1",	"album_year":"2001",	"artist":"X"}';
	
	
		// POST
		// invalid new albums
		$this->post($this->route . '/index.php/albums', $badAlbum1);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->post($this->route . '/index.php/albums', $badAlbum2);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->post($this->route . '/index.php/albums', $badAlbum3);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->post($this->route . '/index.php/albums', $badAlbum4);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->post($this->route . '/index.php/albums', $badAlbum5);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->post($this->route . '/index.php/albums', $badAlbum6);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		// valid new album
		$raw = $this->post($this->route . '/index.php/albums', $goodAlbum1);
		$this->assertResponse(201); // HTTPSTATUS_CREATED
	
		// Get id from raw response, e.g. '{"message":"Resource has been created","id":"13"}'
		$resp = json_decode($raw, true);
		$id = $resp['id'];
	
	
		// GET
		$this->get($this->route . '/index.php/albums');
		$this->assertResponse(200); // HTTPSTATUS_OK
	
		// PUT
		// invalid changes
		$this->put($this->route . '/index.php/albums/' . $id, $badAlbum1);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->put($this->route . '/index.php/albums/' . $id, $badAlbum2);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->put($this->route . '/index.php/albums/' . $id, $badAlbum3);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->put($this->route . '/index.php/albums/' . $id, $badAlbum4);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		$this->put($this->route . '/index.php/albums/' . $id, $badAlbum5);
		$this->assertResponse(400); // HTTPSTATUS_BADREQUEST
	
		// valid change
		$this->put($this->route . '/index.php/albums/' . $id, $goodAlbum2);
		$this->assertResponse(200); // HTTPSTATUS_OK
	
	
		// DELETE
		$this->delete($this->route . '/index.php/albums/' . $id);
		$this->assertResponse(200); // HTTPSTATUS_OK
	
	
		// Attempt1: using a custom 'ID' header didn't work - headers is a string
		// 		$hdrs = $this->getBrowser()->getHeaders();
		// 		print_r('$hdrs: '.$hdrs);
		// 		$id = $hdrs["id"]; //Illegal string offset 'id'
		// 		print_r('$id: '.$id);
	
	}
	
	function testPost() {
		$raw = $this->post($this->route . '/index.php/albums',
				'{"album_name":"Mickey","album_year":"1965","artist":"1"}');
		$this->assertResponse(201);
		
		$resp = json_decode($raw, true);
		$this->testAlbumID = $resp['id'];
	
		$raw = $this->post($this->route . '/index.php/artists',
				'{"name":"Jimi Hendrix","country":"US"}');
		$this->assertResponse(201);
		
		$resp = json_decode($raw, true);
		$this->testArtistID = $resp['id'];
	
		$raw = $this->post($this->route . '/index.php/users',
				'{"name":"Testy", "surname":"Test","email":"mail@mail.com","password":"password","username":"test"}');
		$this->assertResponse(201);
		
		$resp = json_decode($raw, true);
		$this->testUserID = $resp['id'];
	
		$raw = $this->post($this->route . '/index.php/songs',
				'{"song_name":"A Song","duration":"2.45","artist":"1","album":"1","track_no":"1"}');
		$this->assertResponse(201);
		
		$resp = json_decode($raw, true);
		$this->testSongID = $resp['id'];
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
	


	function testPut() {
		// n.b. PUTs fail if data is identical
		$this->put($this->route . '/index.php/albums/'.$this->testAlbumID,
				'{"album_name":"Mickey","album_year":"1966","artist":"1"}');
		$this->assertResponse(200);
		
		$this->put($this->route . '/index.php/users/' . $this->testUserID,
				'{"name":"Testy", "surname":"Testerson","email":"mail0@mail.com","password":"password","username":"test"}');
		$this->assertResponse(200);
		
		$this->put($this->route . '/index.php/songs/' . $this->testSongID,
				'{"song_name":"A Song","duration":"2.50","artist":"1","album":"1","track_no":"1"}');
		$this->assertResponse(200);
		
		/* $this->put($this->route . '/index.php/artists/' . $this->testArtistID,
				'{"name":"Jimi Hendrix","country":"USA"}');
		$this->assertResponse(200); */
	
	}
	
	function testDelete(){
		
		$this->delete($this->route . '/index.php/users/' . $this->testUserID);
		$this->assertResponse(200);
		
		$this->delete($this->route . '/index.php/artists/' . $this->testArtistID);
		$this->assertResponse(200);
		
		$this->delete($this->route . '/index.php/albums/' . $this->testAlbumID);
		$this->assertResponse(200);
		
		$this->delete($this->route . '/index.php/songs/' . $this->testSongID);
		$this->assertResponse(200);
	}

}
?>