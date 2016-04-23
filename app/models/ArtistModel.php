<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/ArtistDAO.php";
require_once "Validation.php";
class ArtistModel {
	private $ArtistDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->ArtistDAO = new ArtistDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getArtists() {
		return ($this->ArtistDAO->get ());
	}
	public function getArtist($artistID) {
		if (is_numeric ( $artistID ))
			return ($this->ArtistDAO->get ($artistID));
		return false;
	}
	
	public function createNewArtist($newArtist) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newArtist ["name"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newArtist ["name"], TABLE_ARTIST_NAME_LENGTH ))) {
				if ($newId = $this->ArtistDAO->insert ( $newArtist ))
					return ($newId);
			}
		}
		// if validation fails or insertion fails
		return (false);
	}
	public function searchArtists($searchString) {
		if (! empty ( $searchString )) {
			$resultSet = $this->ArtistDAO->search ( $searchString );
			return $resultSet;
		}
		return false;
	}
	public function deleteArtist($artistID) {
		if (is_numeric ( $artistID )) {
			$deletedRows = $this->ArtistDAO->delete ( $artistID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateArtist($artistID, $artistData) {
		if (! empty ( $artistID ) && is_numeric ( $artistID )) {
			// compulsory values
			if (! empty ( $artistData ["name"] ) && ! empty ( $artistData ["country"] )) {
				/*
				 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
				 */
				if (($this->validationSuite->isLengthStringValid ( $artistData ["name"], TABLE_ARTIST_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $artistData ["country"], TABLE_ARTIST_COUNTRY_LENGTH ))) {
					$updatedRows = $this->ArtistDAO->update ( $artistData, $artistID );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->ArtistDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>