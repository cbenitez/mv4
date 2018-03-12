<?php

class Database extends PDO
{
	protected $DB_TYPE;
	protected $DSN;
	var $DB_HOST; 
	var $DB_NAME; 
	var $DB_USER; 
	var $DB_PASS; 
	
	public function __construct()
	{
		$this->DB_TYPE  = config()['database']['type'];
		$this->DB_HOST  = config()['database']['host']; 
		$this->DB_NAME  = config()['database']['name']; 
		$this->DB_USER  = config()['database']['user']; 
		$this->DB_PASS  = config()['database']['pass']; 
		$this->DSN      = $this->DB_TYPE.':host='.$this->DB_HOST.';dbname='.$this->DB_NAME;
		try {
			parent::__construct($this->DSN, $this->DB_USER, $this->DB_PASS);
			//parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
		}catch ( \PDOException $e ){
			hule( $e->getMessage() );
		}
	}
	
	/**
	 * select
	 * @param string $sql An SQL string
	 * @param array $array Paramters to bind
	 * @param constant $fetchMode A PDO Fetch mode
	 * @return mixed
	 */
	public function select( $sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC ){
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value) {
			$sth->bindValue("$key", $value);
		}
		
		$sth->execute();
		return $sth->fetchAll($fetchMode);
	}
	
	/**
	 * insert
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 */
	public function insert( $table, $data ){
		ksort($data);
		
		$fieldNames = implode('`, `', array_keys($data));
		$fieldValues = ':' . implode(', :', array_keys($data));
		
		$sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
		
		foreach ($data as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
		
		$r = $sth->execute();
		if( $this->lastInsertId() > 0 ):
			return $this->lastInsertId();
		else:
			return 'Error: ' . $sth->errorInfo()[2] ;
		endif;
	}
	
	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 * @param string $where the WHERE query part
	 */
	public function update( $table, $data, $where ){
		ksort($data);
		
		$fieldDetails = NULL;
		foreach($data as $key=> $value) {
			$fieldDetails .= "`$key`=:$key,";
		}
		$fieldDetails = rtrim($fieldDetails, ',');
		
		$sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
		
		foreach ($data as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
		
		return $sth->execute();
	}
	
	/**
	 * delete
	 * 
	 * @param string $table
	 * @param string $where
	 * @param integer $limit
	 * @return integer Affected Rows
	 */
	public function delete( $table, $where, $limit = 1 ){
		return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
	}
	
}