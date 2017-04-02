<?php
    include 'config.php';
    class DatabaseFunctions
	{
   		public $DB_SERVER;
		public $DB_USER;
		public $DB_PASS;
		public $DB_NAME;
		public $obj_identifier;
		
		/*
			* function for connect with mysql and select db
			* @return link indentifier of connection.
			* @param filename in which contains four lines in the order hostname, username,password,database name 
		*/
		function __construct($DB_SERVER = "", $DB_USER = "", $DB_PASS = "", $DB_NAME = "") {
			if($database_hostname != "") {
				$this -> str_host_name			= trim( $DB_SERVER ); // host name
				$this -> str_user_name			= trim( $DB_USER ); // user name
				$this -> str_password			= trim( $DB_PASS ); // password
				$this -> str_database_name		= trim( $DB_NAME ); // database name
			}
			else {
				$this -> str_host_name			= trim( DB_SERVER ); // host name
				$this -> str_user_name			= trim( DB_USER ); // user name
				$this -> str_password			= trim( DB_PASS ); // password
				$this -> str_database_name		= trim( DB_NAME ); // database name
			}
			
			$this -> obj_identifier = mysqli_connect( $this -> str_host_name, $this -> str_user_name, $this -> str_password, $this -> str_database_name ); // establishing connection  link identifier
			if ( mysqli_connect_errno( $this->obj_identifier ) ) {
				die( "Failed to connect to MySQL: " . mysqli_connect_error() );
			}	
                        
		}

		/*
			* function for escape string
			* @return escaped string.
			* @param string str
		*/
		function EscapeString( $str )  {
			 return mysqli_real_escape_string( $this->obj_identifier, $str );
		}
		
		/*
			* function for insert into table
			* @return number of rows inserted.
			* @param string tablename, array details(pass associative array with fieildname as key ), link identifier
		*/
		function InsertToTable( $str_table_name, $arr_details )  {
			$str_Query = 'INSERT INTO ' . $str_table_name . ' SET ';
			$int_iteration = 0;
			if ( is_array( $arr_details ) ) {
				foreach ( $arr_details as $key => $value ) {
					if ( $int_iteration != 0 ) {
						$str_Query .= ',';
					}
					$str_Query .= mysqli_real_escape_string( $this -> obj_identifier, $key ) . '=' . "'" . mysqli_real_escape_string( $this -> obj_identifier, trim( $value ) ) . "'";
					$int_iteration ++;
				}
			}	
			$int_result = mysqli_query( $this -> obj_identifier, $str_Query );
			if (!$int_result) {
				die( "Failed to run query: (" . $this->obj_identifier->errno . ") " . $this->obj_identifier->error );
			}	
					
			return mysqli_insert_id( $this -> obj_identifier );
		}
		
		/*
			* function for update table details
			* @return number of rows updated.
			* @param string tablename, array detasil(pass associative array with fieildname as key ), link identifier
		*/
		function UpdateTable( $str_table_name, $arr_details, $str_primary_key ) {
			$str_Query = 'UPDATE  ' . $str_table_name . ' SET ';
			
			$int_iteration = 0;
			if ( is_array( $arr_details ) ) {
				foreach ( $arr_details as $key => $value ) {
					if ( $int_iteration != 0 && $key != $str_primary_key) {
						$str_Query .= ',';
					}
					if($key != $str_primary_key){
					   $str_Query .= mysqli_real_escape_string( $this -> obj_identifier, $key ) . '=' . "'" . mysqli_real_escape_string( $this -> obj_identifier, trim( $value ) ) . "' ";
					}
					if($key == $str_primary_key){
				        $str_Query .= " WHERE ". mysqli_real_escape_string( $this -> obj_identifier, $key ) .  '=' ."'" . mysqli_real_escape_string( $this -> obj_identifier, trim( $value ) ) . "' ";
					}
					
					$int_iteration ++;
				}
			
			}
			$int_result = mysqli_query( $this -> obj_identifier, $str_Query );
			if (!$int_result) {
				die( "Failed to run query: (" . $this->obj_identifier->errno . ") " . $this->obj_identifier->error );
			}			
			return ( $int_result );
		}
        
		/*
			* function for delete details from table
			* @return number of rows delected.
			* @param string table name, string condition( eg: name = 'AA'), link identifier
		*/	
		function DeleteFromTable( $str_table_name, $condition ) {    
			$str_Query	 = 'DELETE FROM ' . $str_table_name . ' WHERE ' . $condition ;
			$int_result = mysqli_query( $this -> obj_identifier, $str_Query );
			if (!$int_result) {
				die( "Failed to run query: (" . $this->obj_identifier->errno . ") " . $this->obj_identifier->error );
			}			
			
			return $int_result ;
		}
		
		/*
			* function for select details from table
			* @return array with selected details.
			* @param string select query, link identifier
		*/		
		function SelectFromTable( $str_Query ) {
			$arr_Result = array();
			
			$int_result = mysqli_query( $this -> obj_identifier, $str_Query );
			if (!$int_result) {
				die( "Failed to run query: (" . $this->obj_identifier->errno . ") " . $this->obj_identifier->error );
			}
			
			if ( mysqli_num_rows( $int_result ) > 0 ) {
				$int_count = 0;
				while ( $arr_values = mysqli_fetch_assoc( $int_result ) ) {
					foreach ( $arr_values as $str_field_name => $str_value ) {
						$arr_Result[ $int_count ][ $str_field_name ] = $str_value;
					}
				$int_count++;
				}
			}				
			return $arr_Result;
		}

      	function DatabaseQuery( $str_Query ) {
			$int_result = mysqli_query( $this -> obj_identifier, $str_Query );
			if (!$int_result) {
				die( "Failed to run query: (" . $this->obj_identifier->errno . ") " . $this->obj_identifier->error );
			}
						
			return ( $int_result );
		}
    }
?>