<?php

// Add reference to Slim library. We are using v. 2.4.2.
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

// Middleware function (http://docs.slimframework.com/routing/middleware/) called for each route
function authenticate(\Slim\Route $route){
	// username and password headers are extracted and passed to controller.
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

// If format attribute is appended to url and = xml, use xml view. Default view is JSON.
function viewFormat($format){
	if (!empty($format) && $format === "xml")
	{
		return "xmlView";
	}
	else if (!empty($format) && $format === "csv")
	{
		return "csvView";
	}
	else{
		return "jsonView";
	}
}

// Albums Endpoint
$app->map ( "/albums(/:id)", "authenticate", function ($albumID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $albumID;

	// albums/<album-id>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);


	if (($albumID == null) or is_numeric ( $albumID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($albumID != null)
					$action = ACTION_GET_ALBUM;
					else
						$action = ACTION_GET_ALBUMS;
						break;
			case "POST" :
				$action = ACTION_CREATE_ALBUM;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_ALBUM;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_ALBUM;
				break;
			default :
		}
	}
	$run = new loadRunMVCComponents ( "AlbumModel", "AlbumController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Album Search Endpoint
$app->map ( "/albums/search/:str", "authenticate", function ($albumSearchStr = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = ACTION_SEARCH_ALBUMS;
	$parameters ["albumSearchStr"] = $albumSearchStr; // prepare parameters to be passed to the controller (example: ID)

	// artists/search/<search-string>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);

	$run = new loadRunMVCComponents ( "AlbumModel", "AlbumController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET");

// User endpoint.
// Multiple HTTP methods use the same route (Custom Routes - http://docs.slimframework.com/routing/custom/)
$app->map ( "/users(/:id)", "authenticate", function ($userID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID;
	
	$format = $app->request()->get('format');
	$view = viewFormat($format);
	
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
	$run = new loadRunMVCComponents ( "UserModel", "UserController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Artists Endpoint
$app->map ( "/artists(/:id)", "authenticate", function ($artistID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $artistID;
	
	// artists/<artist-id>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);
	

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
	$run = new loadRunMVCComponents ( "ArtistModel", "ArtistController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Artists Search Endpoint
$app->map ( "/artists/search/:str", "authenticate", function ($str = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = ACTION_SEARCH_ARTIST;
	$parameters ["SearchStr"] = $str; // prepare parameters to be passed to the controller (example: ID)
	
	// artists/search/<search-string>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);
	
	$run = new loadRunMVCComponents ( "ArtistModel", "ArtistController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET" );


// Songs Endpoint
$app->map ( "/songs(/:id)", "authenticate", function ($songID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $songID;

	// albums/<album-id>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);


	if (($songID == null) or is_numeric ( $songID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($songID != null)
					$action = ACTION_GET_SONG;
					else
						$action = ACTION_GET_SONGS;
						break;
			case "POST" :
				$action = ACTION_CREATE_SONG;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_SONG;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_SONG;
				break;
			default :
		}
	}
	$run = new loadRunMVCComponents ( "SongModel", "SongController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET", "POST", "PUT", "DELETE" );

// Song Search Endpoint
$app->map ( "/songs/search/:str", "authenticate", function ($songSearchStr = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = ACTION_SEARCH_SONGS;
	$parameters ["songSearchStr"] = $songSearchStr; // prepare parameters to be passed to the controller (example: ID)

	// artists/search/<search-string>?format=<xml/json>
	$format = $app->request()->get('format');
	$view = viewFormat($format);

	$run = new loadRunMVCComponents ( "SongModel", "SongController", $view, $action, $app, $parameters );
	return $run -> output();
} )->via ( "GET");


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