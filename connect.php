<?php

/*
 * This script takes GET parameters from the web request and 
 * sends them to an instance of our database wrapper. 
 *
 */

//include dbwrapper class that encapsulates required database access methods
include 'dbwrapper.php';

//we return our results JSON encoded
header( 'Content-Type', 'application/json' );

try {
	$table = null;
	
	//check if table names are supported
	if ( $_GET['table'] == 'books' || $_GET['table'] == 'authors' ) {
			//save it for eventual use
			$table = $_GET['table'];
	}
	else {
			//throw error in case of unsupported table name
			throw new Exception( 'Invalid table name.' );
	}
	
	//get database location and specify database file name
	$dbName = $_SERVER["DOCUMENT_ROOT"] . '\dbex\booksexample.mdb';
	
	//if database does not exist, display error message and exit
	if (!file_exists($dbName)) {		
		die("Can't find database.");		
	}
	
	//use odbc and pdo to connect to access database (without userid or password)
	//relay database connection and table name to database wrapper
	$dw = new DbWrapper(new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;"), $table);	
	
	//check for additional parameters and store them
	$additional = array();	
	foreach( array_keys( $_GET ) as $k ) {
		if ( $k != 'table' && $k != 'method' && $k != 'id' ) {
			$additional[$k] = $_GET[$k];
		}
	}
		
	switch( $_GET['method'] ) {
		case 'get':
			//get single dataset from database specified by its id
			//encode and display as json
			print json_encode( $dw->get( $_GET['id'] ) );
			break;
		case 'getAll':
			//get all datasets from database, pass along all additional parameters
			//encode and display as json
			print json_encode( $dw->getAll( $additional ) );
			break;
		default:
			//unknown or unsupported method
			throw new Exception( 'Undefined method.' );
			break;
	}
}
catch ( Exception $e ) {
	//catch all errors and display them to user(s)
	print json_encode( array( 'error' => $e->getMessage() ) );
}

?>