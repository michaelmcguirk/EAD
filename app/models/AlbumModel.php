<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/AlbumDAO.php";
require_once "Validation.php";
class AlbumModel {
	private $AlbumDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->AlbumDAO = new AlbumDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getAlbums() {
		return ($this->AlbumDAO->get ());
	}
	public function getAlbum($albumID) {
		if (is_numeric ( $albumID ))
			return ($this->AlbumDAO->get (null, $albumID ));
		
		return false;
	}
	
	/**
	 *
	 * @param array $AlbumRepresentation:
	 *        	an associative array containing the detail of the new album
	 */
	public function createNewAlbum($newAlbum) {
		// validation of the values of the new album
		
		// compulsory values
		if (! empty ( $newAlbum ["album_name"] ) && 
			! empty ( $newAlbum ["album_year"] ) && 
			! empty ( $newAlbum ["artist"] )) {
			/*
			 * the model knows the representation of a album in the database and this is: 
			 * album_name: varchar(255) album_year: varchar(255) artist: int(11)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newAlbum ["album_name"], TABLE_ALBUM_NAME_LENGTH )) 
			 && ($this->validationSuite->isNumberInRangeValid ( $newAlbum ["album_year"], 1900, 2020 )) 
			 && ($this->validationSuite->isNumberInRangeValid ( $newAlbum ["artist"], 1, 10000 ))) {
				if ($newId = $this->AlbumDAO->insert ( $newAlbum ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function searchAlbums($string) {
		if (! empty ( $string )) {
			$resultSet = $this->AlbumDAO->search ( $string );
			return $resultSet;
		}
		
		return false;
	}
	public function deleteAlbum($albumID) {
		if (is_numeric ( $albumID )) {
			$deletedRows = $this->AlbumDAO->delete ( $albumID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateAlbum($albumID, $albumNewRepresentation) {
		if (! empty ( $albumID ) && is_numeric ( $albumID )) {
			// compulsory values
			if (! empty ( $albumNewRepresentation ["album_name"] ) && 
				! empty ( $albumNewRepresentation ["album_year"] ) && 
				! empty ( $albumNewRepresentation ["artist"] )) {
				/*
				 * the model knows the representation of an album in the database and this is: 
				 * album_name: varchar(255) album_year: varchar(25) artist: int(4) 
				 */
				if (($this->validationSuite->isLengthStringValid ( $albumNewRepresentation ["album_name"], TABLE_USER_NAME_LENGTH )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $albumNewRepresentation ["album_year"], 1900, 2020 )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $albumNewRepresentation ["artist"], 1, 20000 ))) 
				{
					$updatedRows = $this->AlbumDAO->update ( $albumNewRepresentation, $albumID );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->AlbumDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>