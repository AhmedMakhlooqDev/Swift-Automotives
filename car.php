<?php

class Car{

    private $CAR_ID;
    private $CAR_MAKE;
    private $CAR_MODEL;
    private $CAR_YEAR;
    private $CAR_IMAGE;
    private $CAR_TYPE_ID;
    private $CAR_PRICE_PER_DAY;


    public function getCAR_ID(){
		return $this->CAR_ID;
	}

	public function setCAR_ID($CAR_ID){
		$this->CAR_ID = $CAR_ID;
	}

	public function getCAR_MAKE(){
		return $this->CAR_MAKE;
	}

	public function setCAR_MAKE($CAR_MAKE){
		$this->CAR_MAKE = $CAR_MAKE;
	}

	public function getCAR_MODEL(){
		return $this->CAR_MODEL;
	}

	public function setCAR_MODEL($CAR_MODEL){
		$this->CAR_MODEL = $CAR_MODEL;
	}

	public function getCAR_YEAR(){
		return $this->CAR_YEAR;
	}

	public function setCAR_YEAR($CAR_YEAR){
		$this->CAR_YEAR = $CAR_YEAR;
	}

	public function getCAR_IMAGE(){
		return $this->CAR_IMAGE;
	}

	public function setCAR_IMAGE($CAR_IMAGE){
		$this->CAR_IMAGE = $CAR_IMAGE;
	}

	public function getCAR_TYPE_ID(){
		return $this->CAR_TYPE_ID;
	}

	public function setCAR_TYPE_ID($CAR_TYPE_ID){
		$this->CAR_TYPE_ID = $CAR_TYPE_ID;
	}

	public function getCAR_PRICE_PER_DAY(){
		return $this->CAR_PRICE_PER_DAY;
	}

	public function setCAR_PRICE_PER_DAY($CAR_PRICE_PER_DAY){
		$this->CAR_PRICE_PER_DAY = $CAR_PRICE_PER_DAY;
	}
    

    public function __construct()
    {
        //set the default value of the variables
        $this->CAR_ID = null;
        $this->CAR_MAKE = null;
        $this->CAR_MODEL = null;
        $this->CAR_YEAR = null;
        $this->CAR_IMAGE = null;
        $this->CAR_TYPE_ID = null;
        $this->CAR_PRICE_PER_DAY = null;


        //get and store the connection of mysqli
        $this->connection = Database::getInstance()->getConnection();
    }

    public function initWith($car_id,$car_make, $car_model, $car_year, $car_image,$car_typ_id,$car_price_per_day)
    {
        $this->CAR_ID = $car_id;
        $this->CAR_MAKE = $car_make;
        $this->CAR_MODEL = $car_model;
        $this->CAR_YEAR = $car_year;
        $this->CAR_IMAGE = $car_image;
        $this->CAR_TYPE_ID = $car_typ_id;
        $this->CAR_PRICE_PER_DAY = $car_price_per_day;
               
    }


    public function addCar()
    {
        $sql = "INSERT INTO `dbproj_car`(`CAR_MAKE`, `CAR_MODEL`, `CAR_YEAR`, `CAR_IMAGE`, `CAR_TYPE_ID`, `CAR_PRICE_PER_DAY`) VALUES (?,?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        //bind values to parameters based on type to avoid sql injection
        $stmt->bind_param("ssssss", $this->CAR_MAKE,  $this->CAR_MODEL, $this->CAR_YEAR, $this->CAR_IMAGE,$this->CAR_TYPE_ID, $this->CAR_PRICE_PER_DAY);
        //execute the sql query
        $stmt->execute();
        //set the reservation id based on insert id
        $this->CAR_ID = $stmt->insert_id;
        if ($this->CAR_ID != null) {
            return true;
        } else {
            return false;
        }
    }


    public function updateCar()
    {
        $sql = "UPDATE `dbproj_car` SET `CAR_MAKE`=?,`CAR_MODEL`=?,`CAR_YEAR`=?,`CAR_IMAGE`=?,`CAR_TYPE_ID`=?,`CAR_PRICE_PER_DAY`=? WHERE `CAR_ID` = ?";

        $stmt = $this->connection->prepare($sql);
        //bind values to parameters based on type to avoid sql injection
        $stmt->bind_param("sssssss", $this->CAR_MAKE,  $this->CAR_MODEL, $this->CAR_YEAR, $this->CAR_IMAGE,$this->CAR_TYPE_ID, $this->CAR_PRICE_PER_DAY, $this->CAR_ID);
        //execute the sql query
        $stmt->execute();
        echo $stmt->error;
        //set the reservation id based on insert id
        $this->CAR_ID = $stmt->insert_id;
        if ($this->CAR_ID != null) {
            return true;
        } else {
            return false;
        }
    }


    public function retrieveCar()
    {
        $sql = "SELECT * FROM `dbproj_car` WHERE `CAR_ID`=?";

        $stmt = $this->connection->prepare($sql);
        //bind values to parameters based on type to avoid sql injection
        $stmt->bind_param("s", $this->CAR_ID);
        //execute the sql query
        $stmt->execute();
        //set the reservation id based on insert id
        $c=$stmt->get_result();

        $row = $c->fetch_object();


        $this->initWith($row->CAR_ID, $row->CAR_MAKE, $row->CAR_MODEL, $row->CAR_YEAR, $row->CAR_IMAGE, $row->CAR_TYPE_ID, $row->CAR_PRICE_PER_DAY);

        
    }




}