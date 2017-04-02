<?php
include '../config/db.php';

class Location extends DatabaseFunctions{
    function __construct($DB_SERVER = "", $DB_USER = "", $DB_PASS = "", $DB_NAME = "") {
        parent::__construct($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
    }

    public function getAllDistricts(){
        try {
            $this->error = array();
            $query = 'SELECT DISTINCT clg_district FROM '.COLLEGES;
            print_r($this->SelectFromTable($query));
        }
        catch(Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}
