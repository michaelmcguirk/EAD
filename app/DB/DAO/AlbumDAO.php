<?php
/**
 * @author Carl / Mickey
 * definition of the Album DAO (database access object)
 */
class AlbumDAO {
	private $dbManager;
	function AlbumDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($albumName = null, $albumID = null) {
		$sql = "SELECT * ";
		$sql .= "FROM album ";
		if ($albumName != null && $albumID === null)
			$sql .= "WHERE album.album_name=? ";
			if ($albumID != null && $albumName === null)
				$sql .= "WHERE album.id=? ";
				$sql .= "ORDER BY album.album_name ";

				$stmt = $this->dbManager->prepareQuery ( $sql );
				if ($albumName != null && $albumID === null)
					$this->dbManager->bindValue ( $stmt, 1, $albumName, $this->dbManager->INT_TYPE );
					if ($albumID != null && $albumName === null)
						$this->dbManager->bindValue ( $stmt, 1, $albumID, $this->dbManager->INT_TYPE );
						$this->dbManager->executeQuery ( $stmt );
						$rows = $this->dbManager->fetchResults ( $stmt );

						return ($rows);
	}

	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO album (album_name, album_year, artist) ";
		$sql .= "VALUES (?,?,?) ";

		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["album_name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["album_year"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["artist"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );

		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $albumID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE album SET album_name = ?, album_year = ?, artist = ? WHERE id = ?";

		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["album_name"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["album_year"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["artist"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 4, $albumID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );

		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	public function delete($albumID) {
		$sql = "DELETE FROM album ";
		$sql .= "WHERE album.id = ?";

		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $albumID, $this->dbManager->INT_TYPE );

		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM album ";
		$sql .= "WHERE album.album_name LIKE CONCAT('%', ?, '%') ";
		$sql .= "or album.album_year LIKE CONCAT('%', ?, '%')  ";
		$sql .= "or album.artist LIKE CONCAT('%', ?, '%')  ";
		$sql .= "ORDER BY album.album_name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $str, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $str, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
}
?>