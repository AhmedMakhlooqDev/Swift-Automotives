<?php
class Invoice
{

    private $INVOICE_ID;
    private $INVOICE_TOTAL;
    private $INVOICE_DATE_CREATED;
    private $AMENDED;

    /**
     * Get the value of RESERVATION_ID
     */
    public function getINVOICE_ID()
    {
        return $this->INVOICE_ID;
    }

    /**
     * Set the value of RESERVATION_ID
     *
     * @return  self
     */
    public function setINVOICE_ID($INVOICE_ID)
    {
        $this->INVOICE_ID = $INVOICE_ID;

        return $this;
    }

    public function getINVOICE_TOTAL()
    {
        return $this->INVOICE_TOTAL;
    }

    public function setINVOICE_TOTAL($INVOICE_TOTAL)
    {
        $this->INVOICE_TOTAL = $INVOICE_TOTAL;
    }

    public function getINVOICE_DATE_CREATED()
    {
        return $this->INVOICE_DATE_CREATED;
    }

    public function setINVOICE_DATE_CREATED($INVOICE_DATE_CREATED)
    {
        $this->INVOICE_DATE_CREATED = $INVOICE_DATE_CREATED;
    }

    public function getAMENDED()
    {
        return $this->AMENDED;
    }

    public function setAMENDED($AMENDED)
    {
        $this->AMENDED = $AMENDED;
    }

    

    public function __construct()
    {
        //set the default value of the variables
        $this->INVOICE_ID = null;
        $this->INVOICE_TOTAL = null;
        $this->INVOICE_DATE_CREATED = null;
        $this->AMENDED = null;


        //get and store the connection of mysqli
        $this->connection = Database::getInstance()->getConnection();
    }

    public function initWith($invoice_id,$invoice_total, $invoice_date_created, $amended)
    {
        $this->INVOICE_ID = $invoice_id;
        $this->INVOICE_TOTAL = $invoice_total;
        $this->INVOICE_DATE_CREATED = $invoice_date_created;
        $this->AMENDED = $amended;
        
        
    }


    public function createInvoice()
    {
        $sql = "INSERT INTO `dbproj_invoice`(`INVOICE_TOTAL`, `INVOICE_DATE_CREATED`, `AMENDED`) VALUES (?,?,0)";

        $stmt = $this->connection->prepare($sql);
        //bind values to parameters based on type to avoid sql injection
        $stmt->bind_param("ss", $this->INVOICE_TOTAL,  $this->INVOICE_DATE_CREATED);
        //execute the sql query
        $stmt->execute();
        //set the reservation id based on insert id
        $this->INVOICE_ID = $stmt->insert_id;
        if ($this->INVOICE_ID != null) {
            return true;
        } else {
            return false;
        }
    }
}
