<?php
// a comment
class csvView {
	private $model, $controller, $slimApp;
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	public function output() {
		// prepare json responseresponse
		$resultSet = $this->model->apiResponse;
		$cols = $resultSet [0];
		$csv = "";
		
		// Print column names
		foreach ( $cols as $key => $value ) {
			if (end ( $cols ) == $value) {
				$csv .= "$key\r";
			} else {
				$csv .= "$key,";
			}
		}
		// Print all values
		foreach ( $resultSet as $row ) {
			foreach ( $row as $key => $value ) {
				// If last value on a line, append a \r, otherwise append a comma.
				if (end ( $row ) == $value) {
					$csv .= "$value\r";
				} else {
					$csv .= "$value,";
				}
			}
		}
		$this->slimApp->response->write ( $csv );
	}
}
?>