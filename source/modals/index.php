
<?php

include 'location.php';
include 'constants.php';

class Route extends Location{
    
    function __construct() {
        parent::__construct();
            $data = json_decode(file_get_contents("php://input"));
            $this->type = $data->type;
            $this->redirect();
    }
    
    public function redirect(){
       if( $this->type == DISTRICTS ) {
           $districts = $this->getAllDistricts();
		   $this->convertToJSON($districts);
       }
    }
	
	public function convertToJSON( $inputArray ){
		echo  json_encode($inputArray);
	}
}
$route = new Route();