<?php

/*
 * This class takes a database connection handle and a table name on construction 
 * and provides methods for reading and/or manipulating database content with SQL statements.
 *
 */
class DbWrapper {
	
 private $dbh;
 private $table;
 
/*
 * Class constructor.
 *
 * @param handle $dbh PDO database connection handle.
 * @param string $table table name.
 *
 */
 public function __construct( $dbh, $table ) {
	$this->dbh = $dbh;
	$this->table = $table;
 }
 
/*
 * Returns a single row from the table given an integer ID.
 * Assumes an "id" field in the table has unique integer values.
 *
 * @param int $id ID corresponding to the table's column.
 * @return object Single row from table.
 *
 */
 public function get( $id ) {
	//create SQL statement to select a single row from the table specified by it's id
	$sql = 'SELECT * FROM '.$this->table.' WHERE id = :id';
	
	//create statement handle
	$sth = $this->dbh->prepare($sql);
	
	//run statement and pass id in an array
	$sth->execute(array(':id' => $id));
	
	return $sth->fetchObject();
 }
 
/*
 * Returns all the records from the table.  The only one implemented here is limit, which restricts the count of records returned. You can add more if you like—for example, an "order" option to return the records ordered by a specified field.
 * Assumes an "id" field in the table has unique integer values.
 *
 * @param array $options List of optional parameters.
 * @return object Multiple rows from table.
 *
 */
 public function getAll( $options = array() ) {
	//create SQL statement to select all rows from the table
	$sql = 'SELECT * FROM '.$this->table;
	
	//check if we have optional parameters
	if ( isset( $options->{'limit'} ) ) {
		//restrict the count of records returned
		$sql .= ' LIMIT '.$this->dbh->quote( $options->{'limit'}, PDO::PARAM_INT );
	}
	
	//create statement handle
	$sth = $this->dbh->prepare($sql);
	
	//run statement
	$sth->execute();
	
	return $sth->fetchAll( PDO::FETCH_CLASS );
 }
}
?>
