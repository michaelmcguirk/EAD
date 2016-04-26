<?php
class AlbumController {
	private $slimApp;
	private $model;
	private $requestBody;
	public function __construct($model, $action = null, $slimApp, $parameteres = null) {
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new album
		
		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];
			
		
		switch ($action) {
			case ACTION_GET_ALBUM :
				$this->getAlbum ( $id );
				break;
			case ACTION_GET_ALBUMS :
				$this->getAlbums ();
				break;
			case ACTION_UPDATE_ALBUM :
				$this->updateAlbum ( $id, $this->requestBody );
				break;
			case ACTION_CREATE_ALBUM :
				$this->createNewAlbum ( $this->requestBody );
				break;
			case ACTION_DELETE_ALBUM :
				$this->deleteAlbum ( $id );
				break;
			case ACTION_SEARCH_ALBUMS :
				$string = $parameteres ["albumSearchStr"];
				$this->searchAlbums ( $string );
				break;
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR 
				);
				$this->model->apiResponse = $Message;
				break;
		}
	}
	private function getAlbums() {
		$answer = $this->model->getAlbums ();
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function getAlbum($albumID) {
		$answer = $this->model->getAlbum ( $albumID );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function createNewAlbum($newAlbum) {
		if ($newID = $this->model->createNewAlbum ( $newAlbum )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
					"id" => "$newID"
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	private function deleteAlbum($albumId) {
		//$isSuccessfull = $this->model->deleteAlbum ( $albumId );
		//var_dump($isSuccessfull);
		//die($isSuccessfull);
		if ($this->model->deleteAlbum ( $albumId )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_ERROR_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	private function searchAlbums($string) {
		$answer = $this->model->searchAlbums ( $string );
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			
			$this->model->apiResponse = $Message;
		}
	}
	private function updateAlbum($albumId, $albumDetails) {
		if ($this->model->updateAlbum ( $albumId, $albumDetails )) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
					"updatedID" => "$albumId" 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY 
			);
			$this->model->apiResponse = $Message;
		}
	}
}
?>