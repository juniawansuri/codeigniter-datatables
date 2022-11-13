<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MJoin extends MY_Model {

    public function __construct(){
        parent::__construct();
        //Do your magic here
        $this->table = "customers";
        $this->order = array('customerNumber');
        $this->column_order = array('customers.customerNumber', 'customers.customerName', 'customers.phone', 'customers.addressLine1', 'numberOfOrder');
        $this->column_search = array('customers.customerNumber', 'customers.customerName', 'customers.phone', 'customers.addressLine1');
    }

    /**
     * override
     */
    public function datatable_query(){
        $this->db->select("customers.customerNumber
                            , customers.customerName
                            , customers.phone
                            , customers.addressLine1
                            , SUM(IF(orders.customerNumber IS NOT NULL, 1, 0)) as numberOfOrder");
        $this->db->from($this->table);
        $this->db->join('orders', 'orders.customerNumber = customers.customerNumber');
        $this->db->group_by('customers.customerNumber');
    }

}

/* End of file MJoin.php */