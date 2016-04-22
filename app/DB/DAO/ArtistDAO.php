<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
class ArtistDAO {
	private $dbManager;
	function ArtistDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($artistName = null, $artistID = null) {
		$sql = "SELECT * ";
		$sql .= "FROM artist ";
		if ($artistName != null && $artistID === null)
			$sql .= "WHERE artist.name=? ";
		if ($artistID != null && $artistName === null)
			$sql .= "WHERE artist.id=? ";
		$sql .= "ORDER BY artist.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		if ($artistName != null && $artistID === null)
			$this->dbManager->bindValue ( $stmt, 1, $artistName, $this->dbManager->INT_TYPE );
		if ($artistID != null && $artistName === null)
			$this->dbManager->bindValue ( $stmt, 1, $artistID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO artist (name, country) ";
		$sql .= "VALUES (?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["country"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $artistID) {
		// /create an UPDATE sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "UPDATE users SET name = ?, country = ? WHERE id = ?";
		
		$this->dbManager->openConnection ();
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["country"], PDO::PARAM_STR );
		$this->dbManager->bindValue ( $stmt, 3, $artistID, PDO::PARAM_INT );
		$this->dbManager->executeQuery ( $stmt );
		
		//check for number of affected rows
		$rowCount = $this->dbManager->getNumberOfAffectedRows($stmt);
		return ($rowCount);
	}
	public function delete($artistID) {
		$sql = "DELETE FROM artist ";
		$sql .= "WHERE artist.id = ?";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $artistID, $this->dbManager->INT_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rowCount = $this->dbManager->getNumberOfAffectedRows ( $stmt );
		return ($rowCount);
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM artist ";
		$sql .= "WHERE artist.name LIKE CONCAT('%', ?, '%') or artist.country LIKE CONCAT('%', ?, '%')  ";
		$sql .= "ORDER BY users.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $str, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $str, $this->dbManager->STRING_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
}
?>
