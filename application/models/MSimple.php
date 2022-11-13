<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MSimple extends MY_Model {

    public function __construct(){
        parent::__construct();
        //Do your magic here
        $this->table = "customers";
        $this->order = array('customerNumber');
        $this->column_order = array('customerNumber', 'customerName', 'phone', 'addressLine1');
        $this->column_search = array('customerNumber', 'customerName', 'phone', 'addressLine1');
        $this->column = "customerNumber, customerName, phone, addressLine1";
    }

}

/* End of file MSimple.php */