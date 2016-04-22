<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/UsersDAO.php";
require_once "Validation.php";
class UserModel {
	private $UsersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->UsersDAO = new UsersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getUsers() {
		return ($this->UsersDAO->get ());
	}
	public function getUser($albumID) {
		if (is_numeric ( $albumID ))
			return ($this->UsersDAO->get (null, $albumID ));
		
		return false;
	}
	
	/**
	 *
	 * @param array $UserRepresentation:
	 *        	an associative array containing the detail of the new album
	 */
	public function createNewUser($newUser) {
		// validation of the values of the new album
		
		// compulsory values
		if (! empty ( $newUser ["name"] ) && ! empty ( $newUser ["surname"] ) && ! empty ( $newUser ["email"] ) && ! empty ( $newUser ["password"] )) {
			/*
			 * the model knows the representation of a album in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newUser ["name"], TABLE_USER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newUser ["surname"], TABLE_USER_SURNAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newUser ["email"], TABLE_USER_EMAIL_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newUser ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
				if ($newId = $this->UsersDAO->insert ( $newUser ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function searchUsers($string) {
		if (! empty ( $string )) {
			$resultSet = $this->UsersDAO->search ( $string );
			return $resultSet;
		}
		
		return false;
	}
	public function deleteUser($albumID) {
		if (is_numeric ( $albumID )) {
			$deletedRows = $this->UsersDAO->delete ( $albumID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateUser($albumID, $albumNewRepresentation) {
		if (! empty ( $albumID ) && is_numeric ( $albumID )) {
			// compulsory values
			if (! empty ( $albumNewRepresentation ["album_name"] ) && 
				! empty ( $albumNewRepresentation ["album_year"] ) && 
				! empty ( $albumNewRepresentation ["artist"] )) {
				/*
				 * the model knows the representation of an album in the database and this is: 
				 * album_name: varchar(255) album_year: varchar(25) artist: int(4) 
				 */
				if (($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["name"], TABLE_USER_NAME_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["surname"], TABLE_USER_SURNAME_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) 
					&& ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["password"], TABLE_USER_PASSWORD_LENGTH ))) 
				{
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