<?php

include_once 'database.php';
class Reservation
{
        private $RESERVATION_ID;
        private $RESERVATION_CODE;
        private $START_DATE;
        private $CAR_ID;
        private $END_DATE;
        private $INVOICE_ID;
        private $USER_ID;
        private $BILLING_ADDRESS;

        public function __construct()
        {
                //set the default value of the variables
                $this->RESERVATION_ID = null;
                $this->RESERVATION_CODE = null;
                $this->START_DATE = null;
                $this->CAR_ID = null;
                $this->END_DATE = null;
                $this->INVOICE_ID = null;
                $this->USER_ID = null;
                $this->BILLING_ADDRESS = null;


                //get and store the connection of mysqli
                $this->connection = Database::getInstance()->getConnection();
        }



        /**
         * Get the value of RESERVATION_ID
         */
        public function getRESERVATION_ID()
        {
                return $this->RESERVATION_ID;
        }

        /**
         * Set the value of RESERVATION_ID
         *
         * @return  self
         */
        public function setRESERVATION_ID($RESERVATION_ID)
        {
                $this->RESERVATION_ID = $RESERVATION_ID;

                return $this;
        }

        /**
         * Get the value of RESERVATION_CODE
         */
        public function getRESERVATION_CODE()
        {
                return $this->RESERVATION_CODE;
        }

        /**
         * Set the value of RESERVATION_CODE
         *
         * @return  self
         */
        public function setRESERVATION_CODE($RESERVATION_CODE)
        {
                $this->RESERVATION_CODE = $RESERVATION_CODE;

                return $this;
        }

        /**
         * Get the value of START_DATE
         */
        public function getSTART_DATE()
        {
                return $this->START_DATE;
        }

        /**
         * Set the value of START_DATE
         *
         * @return  self
         */
        public function setSTART_DATE($START_DATE)
        {
                $this->START_DATE = $START_DATE;

                return $this;
        }

        /**
         * Get the value of CAR_ID
         */
        public function getCAR_ID()
        {
                return $this->CAR_ID;
        }

        /**
         * Set the value of CAR_ID
         *
         * @return  self
         */
        public function setCAR_ID($CAR_ID)
        {
                $this->CAR_ID = $CAR_ID;

                return $this;
        }

        /**
         * Get the value of END_DATE
         */
        public function getEND_DATE()
        {
                return $this->END_DATE;
        }

        /**
         * Set the value of END_DATE
         *
         * @return  self
         */
        public function setEND_DATE($END_DATE)
        {
                $this->END_DATE = $END_DATE;

                return $this;
        }

        /**
         * Get the value of INVOICE_ID
         */
        public function getINVOICE_ID()
        {
                return $this->INVOICE_ID;
        }

        /**
         * Set the value of INVOICE_ID
         *
         * @return  self
         */
        public function setINVOICE_ID($INVOICE_ID)
        {
                $this->INVOICE_ID = $INVOICE_ID;

                return $this;
        }

        /**
         * Get the value of USER_ID
         */
        public function getUSER_ID()
        {
                return $this->USER_ID;
        }

        /**
         * Set the value of USER_ID
         *
         * @return  self
         */
        public function setUSER_ID($USER_ID)
        {
                $this->USER_ID = $USER_ID;

                return $this;
        }


        /**
         * Get the value of RESERVATION_ID
         */
        public function getBILLING_ADDRESS()
        {
                return $this->BILLING_ADDRESS;
        }

        /**
         * Set the value of RESERVATION_ID
         *
         * @return  self
         */
        public function setBILLING_ADDRESS($BILLING_ADDRESS)
        {
                $this->BILLING_ADDRESS = $BILLING_ADDRESS;

                return $this;
        }


        public function Search($endDate, $startDate, $minimumPrice, $maximumPrice, $carType, $carModel)
        {
                $result = [];
                //retrieve cars
                //construct the statement based on the parameters
                if (!empty($carModel)) {
                        $query = "SELECT c.* from dbproj_car c 
                    LEFT JOIN dbproj_reservation r 
                    on (c.CAR_ID = r.CAR_ID 
                    and r.START_DATE >= ? 
                    and r.END_DATE <= ?) 
                    WHERE r.RESERVATION_ID is null
                    and c.CAR_PRICE_PER_DAY >= ?
                    and c.CAR_PRICE_PER_DAY <= ?
                    AND c.CAR_TYPE_ID = ?
                    AND match(c.CAR_MODEL) against(?)";

                        $stmt = $this->connection->prepare($query);
                        $stmt->bind_param("ssddis", $startDate, $endDate, $minimumPrice, $maximumPrice, $carType, $carModel);
                        //retrieve cars that are in that date range
                } else {
                        $query = "SELECT c.* from dbproj_car c 
                    LEFT JOIN dbproj_reservation r 
                    on (c.CAR_ID = r.CAR_ID 
                    and r.START_DATE >= ? 
                    and r.END_DATE <= ?) 
                    WHERE r.RESERVATION_ID is null
                    and c.CAR_PRICE_PER_DAY >= ?
                    and c.CAR_PRICE_PER_DAY <= ?
                    AND c.CAR_TYPE_ID = ?";

                        $stmt = $this->connection->prepare($query);
                        $stmt->bind_param("ssddi", $startDate, $endDate, $minimumPrice, $maximumPrice, $carType);
                }
                //execute the quary

                $stmt->execute();
                $queryResult = $stmt->get_result();
                while ($row = $queryResult->fetch_assoc()) {
                        array_push($result, $row);
                }
                return $result;
        }

        public function initWith($reservation_id, $reservation_code, $start_date, $car_id, $end_date, $invoice_id, $user_id, $billing_address)
        {
                $this->RESERVATION_ID = $reservation_id;
                $this->RESERVATION_CODE = $reservation_code;
                $this->START_DATE = $start_date;
                $this->CAR_ID = $car_id;
                $this->END_DATE = $end_date;
                $this->INVOICE_ID = $invoice_id;
                $this->USER_ID = $user_id;
                $this->BILLING_ADDRESS = $billing_address;
        }

        public function addReservation(array $listAccessories = null)
        {
                $sql = "INSERT INTO dbproj_reservation(RESERVATION_CODE,`START_DATE`,CAR_ID,END_DATE,INVOICE_ID,`USER_ID`,BILLING_ADDRESS) VALUES (?,?,?,?,?,?,?)";

                $stmt = $this->connection->prepare($sql);
                //bind values to parameters based on type to avoid sql injection
                $stmt->bind_param("sssssss", $this->RESERVATION_CODE, $this->START_DATE,  $this->CAR_ID,  $this->END_DATE, $this->INVOICE_ID, $this->USER_ID, $this->BILLING_ADDRESS);
                //execute the sql query
                $stmt->execute();
                //set the reservation id based on insert id
                $this->RESERVATION_ID = $stmt->insert_id;
                //loop through the list of added accessories and add them to an array 
                if ($listAccessories != null) {

                        foreach ($listAccessories as $accessory) {
                                $sql = "INSERT INTO `dbproj_car_accessories_reservations`(`RESERVATION_ID`, `CAR_ACCESSORIES_ID`) VALUES (?,?)";

                                $stmt = $this->connection->prepare($sql);
                                //bind values to parameters based on type to avoid sql injection
                                $stmt->bind_param("ss", $this->RESERVATION_ID, $accessory);
                                //execute the sql query
                                $stmt->execute();
                                echo $stmt->error;
                        }
                }



                if ($this->RESERVATION_ID != null) {
                        return true;
                } else {
                        return false;
                }
        }

        //retrieve reservation details
        public function getResevationDetails($reservation_code, $user_id)
        {
                $connection = Database::getInstance()->getConnection();
                $SQLquery = "select * from dbproj_reservation r , dbproj_invoice i , dbproj_car c 
                where r.INVOICE_ID = i.INVOICE_ID
                and r.CAR_ID = c.CAR_ID
                and r.INVOICE_ID = i.INVOICE_ID
                and r.RESERVATION_CODE = ?
                and r.USER_ID = ?";
                $query = $connection->prepare($SQLquery);
                $query->bind_param("si", $reservation_code, $user_id);

                $query->execute();
                $query->error;
                
                $result = $query->get_result();
               
                $row = $result->fetch_object();
                
                return $row;
        }

       
        //checks if the reservation has been amended or not
        public function isAmended($reservation_code){
                $connection = Database::getInstance()->getConnection();
                $query = "SELECT * FROM dbproj_reservation r , dbproj_invoice i 
                WHERE r.INVOICE_ID = i.INVOICE_ID
                AND r.RESERVATION_CODE = ?
                AND r.START_DATE > DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY)
                AND i.AMENDED = 0";
                $query = $connection->prepare($query);
                $query->bind_param("s", $reservation_code);
                $query->execute();
                $query->error;
                $result = $query->get_result();
                $row = $result->fetch_object();
                return $row;
        }


        //edit reservation 
        public function amendReservation($START_DATE,$END_DATE,$CAR_ID, $RESERVATION_CODE)
        {
                $connection = Database::getInstance()->getConnection();
                $reserved = "SELECT * FROM dbproj_reservation 
                WHERE dbproj_reservation.CAR_ID = ?
                AND dbproj_reservation.START_DATE >= ?
                AND dbproj_reservation.END_DATE <= ?";
                $query = $connection->prepare($reserved);
                $query->bind_param("sss", $CAR_ID,$START_DATE,$END_DATE);
                $query->execute();
                $query->error;
                $result = $query->get_result();
                $row = $result->fetch_object();
                if (empty($row)) {
                        $stmt = 'UPDATE `dbproj_reservation` SET `START_DATE`=?,`END_DATE`=? WHERE dbproj_reservation.RESERVATION_CODE = ?';
                        $query = $connection->prepare($stmt);
                        $query->bind_param("sss", $START_DATE,$END_DATE,$RESERVATION_CODE);
                        $query->execute();
                        return true;

                }else {
                        return false;
                }
        }

        public function deleteResevation($reservation_id, $invoice_id)
        {        
                $connection = Database::getInstance()->getConnection();
                $stmt = 'call DELETE_RESERVATION(?,?)';
                $query = $connection->prepare($stmt);
                $query->bind_param("ii", $reservation_id,$invoice_id);
                $query->execute();

                
        }


}
