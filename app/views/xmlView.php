<?php
// a comment
class xmlView {
	private $model, $controller, $slimApp;
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	public function output() {
		// prepare json responseresponse
		$resultSet = $this->model->apiResponse;
		
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		
		foreach ( $resultSet as $row ) {
			$xml .= "<result>";
			foreach ( $row as $key => $value ) {
				$xml .= "<$key>";
				$xml .= "$value";
				$xml .= "</$key>";
			}
			$xml .= "</result>";
		}
		$this->slimApp->response->write ( $xml );
	}
}
?>