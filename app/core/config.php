<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	/** database config **/
	define('DBNAME', 'manninglist');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define("ROOT", "http://localhost/manninglist");
	define("ROOT_CSS", "/manninglist/public/assets/css/");
	define("ROOT_JS", "/manninglist/public/assets/js/");


}