<?php
/* database constants */
define("DB_HOST", "localhost" ); 		// set database host
define("DB_USER", "root" ); 			// set database user
define("DB_PASS", "" ); 				// set database password
define("DB_PORT", 3306);				// set database port
define("DB_NAME", "dit" ); 			// set database name
define("DB_CHARSET", "utf8" ); 			// set database charset
define("DB_DEBUGMODE", true ); 			// set database charset

/* actions for the USERS REST resource */
define("ACTION_GET_USER", 33);
define("ACTION_GET_USERS", 44);
define("ACTION_CREATE_USER", 55);
define("ACTION_UPDATE_USER", 66);
define("ACTION_DELETE_USER", 77);
define("ACTION_SEARCH_USERS", 88);
define("ACTION_AUTHENTICATE_USER", 99);

/* actions for the ALBUMS REST resource */
define("ACTION_GET_ALBUM", 101);
define("ACTION_GET_ALBUMS", 102);
define("ACTION_CREATE_ALBUM", 103);
define("ACTION_UPDATE_ALBUM", 104);
define("ACTION_DELETE_ALBUM", 105);
define("ACTION_SEARCH_ALBUMS", 106);

define("ACTION_GET_ARTIST", 32);
define("ACTION_GET_ARTISTS", 42);
define("ACTION_CREATE_ARTIST", 52);
define("ACTION_UPDATE_ARTIST", 62);
define("ACTION_DELETE_ARTIST", 72);
define("ACTION_SEARCH_ARTIST", 82);

/* actions for the SONGS REST resource */
define("ACTION_GET_SONG", 111);
define("ACTION_GET_SONGS", 112);
define("ACTION_CREATE_SONG", 113);
define("ACTION_UPDATE_SONG", 114);
define("ACTION_DELETE_SONG", 115);
define("ACTION_SEARCH_SONGS", 116);


/* HTTP status codes 2xx*/
define("HTTPSTATUS_OK", 200);
define("HTTPSTATUS_CREATED", 201);
define("HTTPSTATUS_NOCONTENT", 204);

/* HTTP status codes 3xx (with slim the output is not produced i.e. echo statements are not processed) */
define("HTTPSTATUS_NOTMODIFIED", 304);

/* HTTP status codes 4xx */
define("HTTPSTATUS_BADREQUEST", 400);
define("HTTPSTATUS_UNAUTHORIZED", 401);
define("HTTPSTATUS_FORBIDDEN", 403);
define("HTTPSTATUS_NOTFOUND", 404);
define("HTTPSTATUS_REQUESTTIMEOUT", 408);
define("HTTPSTATUS_TOKENREQUIRED", 499);

/* HTTP status codes 5xx */
define("HTTPSTATUS_INTSERVERERR", 500);

define("TIMEOUT_PERIOD", 120);

/* general message */
define("GENERAL_MESSAGE_LABEL", "message");
define("GENERAL_SUCCESS_MESSAGE", "success");
define("GENERAL_ERROR_MESSAGE", "error");
define("GENERAL_NOCONTENT_MESSAGE", "no-content");
define("GENERAL_NOTMODIFIED_MESSAGE", "not modified");
define("GENERAL_INTERNALAPPERROR_MESSAGE", "internal app error");
define("GENERAL_CLIENT_ERROR", "client error: modify the request");
define("GENERAL_INVALIDTOKEN_ERROR", "Invalid token");
define("GENERAL_APINOTEXISTING_ERROR", "Api is not existing");
define("GENERAL_RESOURCE_CREATED", "Resource has been created");
define("GENERAL_RESOURCE_UPDATED", "Resource has been updated");
define("GENERAL_RESOURCE_DELETED", "Resource has been deleted");

define("GENERAL_FORBIDDEN", "Request is ok but action is forbidden");
define("GENERAL_INVALIDBODY", "Request is ok but transmitted body is invalid");

define("GENERAL_WELCOME_MESSAGE", "Welcome to DIT web-services");
define("GENERAL_INVALIDROUTE", "Requested route does not exist");


/* representation of a new user in the DB */
define("TABLE_USER_NAME_LENGTH", 25);
define("TABLE_USER_SURNAME_LENGTH", 25);
define("TABLE_USER_EMAIL_LENGTH", 50);
define("TABLE_USER_PASSWORD_LENGTH", 40);

define("TABLE_ARTIST_NAME_LENGTH", 255);
define("TABLE_ARTIST_COUNTRY_LENGTH", 255);

/* representation of a new album in the DB */
define("TABLE_ALBUM_NAME_LENGTH", 255);

define("TABLE_SONG_NAME_LENGTH", 255);

?>