<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        //Do your magic here
        $this->load->model('MJoin', 'join');
    }

    public function index() {
        $this->load->view('join');
    }

    public function fetch_data(){
        $this->join->set_param($this->input->get());
        $data = $this->join->get_datatables();

        echo json_encode($data);
    }
        
}

/* End of file Join.php */