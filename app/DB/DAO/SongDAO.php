<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
class SongDAO {
	private $dbManager;
	function SongDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}

	public function get($songID = null) {
		$sql = "SELECT * ";
		$sql .= "FROM song ";
		if ($songID != null)
			$sql .= "WHERE song.id=? ";
		$sql .= "ORDER BY song.song_name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		if ($songID != null)
			$this->dbManager->bindValue ( $stmt, 1, $songID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO song (song_name, duration, artist, album, track_no) ";
		$sql .= "VALUES (?,?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["song_name"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["duration"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["artist"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["album"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["track_no"], PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $songID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE Song SET song_name=?, duration=?, artist=?, album=?, track_no=? WHERE id = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["song_name"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["duration"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["artist"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["album"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["track_no"], PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 6, $songID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );

		// check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function delete($songID) {
		$sql = "DELETE FROM song ";
		$sql .= "WHERE song.id = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $songID, $this->dbManager->INT_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM song WHERE ";
		$sql .= "song.song_name LIKE CONCAT('%', ?, '%') or ";
		$sql .= "song.duration LIKE CONCAT('%', ?, '%') or ";
		$sql .= "song.artist LIKE CONCAT('%', ?, '%') or ";
		$sql .= "song.album LIKE CONCAT('%', ?, '%') or ";
		$sql .= "song.track_no LIKE CONCAT('%', ?, '%') ";
		$sql .= "ORDER BY song.song_name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $str, PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $str, PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 4, $str, PDO::PARAM_INT );
		$this->dbManager->bindValue ( $stmt, 5, $str, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
}
?>
