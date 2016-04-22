<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/ArtistDAO.php";
require_once "Validation.php";
class UserModel {
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
	public function getArtist() {
		return ($this->UsersDAO->get ());
	}
	public function getArtist($artistName) {
		return ($this->ArtistDAO->get ($artistName, null ));
	}
	
	public function createNewArtist($newArtist) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newArtist ["name"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newArtist ["name"], TABLE_ARTIST_NAME_LENGTH ))) {
				if ($newId = $this->UsersDAO->insert ( $newArtist ))
					return ($newId);
			}
		}
		// if validation fails or insertion fails
		return (false);
	}
	public function searchArtists($string) {
		if (! empty ( $string )) {
			$resultSet = $this->ArtistsDAO->search ( $string );
			return $resultSet;
		}
		
		return false;
	}
	public function deleteArtist($artistID) {
		if (is_numeric ( $artistID )) {
			$deletedRows = $this->UsersDAO->delete ( $userID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateUser($userID, $userNewRepresentation) {
		if (! empty ( $userID ) && is_numeric ( $userID )) {
			// compulsory values
			if (! empty ( $userNewRepresentation ["name"] ) && ! empty ( $userNewRepresentation ["surname"] ) && ! empty ( $userNewRepresentation ["email"] ) && ! empty ( $userNewRepresentation ["password"] )) {
				/*
				 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
				 */
				if (($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["name"], TABLE_USER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["surname"], TABLE_USER_SURNAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
					$updatedRows = $this->UsersDAO->update ( $userNewRepresentation, $userID );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->UsersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>