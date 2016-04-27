<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/SongDAO.php";
require_once "Validation.php";
class SongModel {
	private $SongDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->SongDAO = new SongDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getSongs() {
		return ($this->SongDAO->get ());
	}
	public function getSong($artistID) {
		if (is_numeric ( $artistID ))
			return ($this->SongDAO->get ($artistID));
		return false;
	}
	
	public function createNewSong($newSong) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newSong ["song_name"] ) 
				&& ! empty ( $newSong ["duration"] )
				&& ! empty ( $newSong ["artist"] )
				&& ! empty ( $newSong ["album"] )
				&& ! empty ( $newSong ["track_no"] ) ) {
			/*
			 * the model knows the representation of a user in the database and this is: 
			 * song_name varchar(255), duration float(10,2), artist int(11), album int(11), track_no int (11)
			 */		
			if (($this->validationSuite->isLengthStringValid ( $newSong ["song_name"], TABLE_ARTIST_NAME_LENGTH )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $newSong ["duration"], 0.00, 90.00 )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $newSong ["artist"], 1, 100000 ))
					&& ($this->validationSuite->isNumberInRangeValid ( $newSong ["album"], 1, 100000 ))
					&& ($this->validationSuite->isNumberInRangeValid ( $newSong ["track_no"], 1, 100 )) ){
				if ($newId = $this->SongDAO->insert ( $newSong ))
					return ($newId);
			}
		}
		// if validation fails or insertion fails
		return (false);
	}
	public function searchSongs($searchString) {
		if (! empty ( $searchString )) {
			$resultSet = $this->SongDAO->search ( $searchString );
			return $resultSet;
		}
		return false;
	}
	public function deleteSong($songID) {
		if (is_numeric ( $songID )) {
			$deletedRows = $this->SongDAO->delete ( $songID );
			
			if ($deletedRows > 0)
				return (true);
		}
		return (false);
	}
	public function updateSong($songID, $songData) {
		if (! empty ( $songID ) && is_numeric ( $songID )) {
			// compulsory values
			if (! empty ( $songData ["song_name"] ) 
				&& ! empty ( $songData ["duration"] )
				&& ! empty ( $songData ["artist"] )
				&& ! empty ( $songData ["album"] )
				&& ! empty ( $songData ["track_no"] ) ) {
			/*
			 * the model knows the representation of a user in the database and this is: 
			 * song_name varchar(255), duration float(10,2), artist int(11), album int(11), track_no int (11)
			 */		
			if (($this->validationSuite->isLengthStringValid ( $songData ["song_name"], TABLE_SONG_NAME_LENGTH )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $songData ["duration"], 0, 90 )) 
					&& ($this->validationSuite->isNumberInRangeValid ( $songData ["artist"], 1, 100000 ))
					&& ($this->validationSuite->isNumberInRangeValid ( $songData ["album"], 1, 100000 ))
					&& ($this->validationSuite->isNumberInRangeValid ( $songData ["track_no"], 1, 100 )) ){
					$updatedRows = $this->SongDAO->update ( $songData, $songID );
					if ($updatedRows > 0)
						return (true);
				}
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->SongDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>