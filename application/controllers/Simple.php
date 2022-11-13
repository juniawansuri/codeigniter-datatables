<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        //Do your magic here
        $this->load->model('MSimple', 'simple');
    }

    public function index() {
        $this->load->view('simple');
    }

    public function fetch_data(){
        $this->simple->set_param($this->input->get());
        $data = $this->simple->get_datatables();

        echo json_encode($data);
    }
        
}

/* End of file Simple.php */