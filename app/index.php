<?php


require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate(\Slim\Route $route){
	$app = \Slim\Slim::getInstance();
	$headers = $app->request->headers;
	$username =  $headers['username'];
	$password =  $headers['password'];
	$parameters = array("username"=>$username, "password"=>$password);
	$result = new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", ACTION_AUTHENTICATE_USER, $app, $parameters );
	$auth = $result->model->apiResponse;
	if ($auth != true){
		$app->halt(401);
	}
	return true;
}


$app->map ( "/users(/:id)", "authenticate", function ($userID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($userID != null)
					$action = ACTION_GET_USER;
				else
					$action = ACTION_GET_USERS;
				break;
			case "POST" :
				$action = ACTION_CREATE_USER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_USER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_USER;
				break;
			default :
		}
	}
	//return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
	$run = new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Artists
$app->map ( "/artists(/:id)", "authenticate", function ($artistID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $artistID; // prepare parameters to be passed to the controller (example: ID)
	if (!empty($app->request()->get('format')))
	{
		$viewParam = $app->request()->get('format');
		if($viewParam === "xml"){
			$view = "xmlView";
		}
		else{
			$view = "jsonView";
		}		
		echo $view;
	}

	if (($artistID == null) or is_numeric ( $artistID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($artistID != null)
					$action = ACTION_GET_ARTIST;
					else
						$action = ACTION_GET_ARTISTS;
						break;
			case "POST" :
				$action = ACTION_CREATE_ARTIST;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_ARTIST;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_ARTIST;
				break;
			default :
		}
	}
	//return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
	$run = new loadRunMVCComponents ( "ArtistModel", "ArtistController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Artists
$app->map ( "/artists/search/:str", "authenticate", function ($str = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = ACTION_SEARCH_ARTIST;
	$parameters ["SearchStr"] = $str; // prepare parameters to be passed to the controller (example: ID)
	//return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
	$run = new loadRunMVCComponents ( "ArtistModel", "ArtistController", "jsonView", $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );


$app->run ();
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$this->model = new $modelName (); // common model
		$this->controller = new $controllerName ( $this->model, $action, $app, $parameters );
		$this->view = new $viewName ( $this->controller, $this->model, $app, $app->headers ); // common view
	}
	public function output(){
		$this->view->output (); // this returns the response to the requesting client
	}
}

?>