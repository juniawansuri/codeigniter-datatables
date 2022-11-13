<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Core for model
 */
class MY_Model extends CI_Model {
    /**
     * Initaial variable below here
     */

    /**
	 * [$table description]
	 * @var [type]
	 */
    protected $table;
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $column = NULL;
	/**
	 * [$column_order set column field database for datatable orderable]
	 * @var array
	 */
	protected $column_order = [];
	/**
	 * [$column_search set column field database for datatable searchable just firstname , lastname , address are searchable]
	 * @var array
	 */
	protected $column_search = [];
	/**
	 * [$order default order]
	 * @var array
	 */
    protected $order = [];
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $data = [];
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $where = [];
    /**
     * parsing parameter here, for beter security
     *
     * @var array
     */
    protected $param = [];

    /**
     * Undocumented function
     */
    public function __construct(){
        parent::__construct();
        //Do your magic here
        // $this->table="test";
        // echo "Table: ". $this->table;exit;
    }

    /**
     * [get_datatables_query description]
     * @return [type] [description]
     */
    protected function get_datatables_query(){
        $this->datatable_query();
        $this->datatable_props();
    }
    
    /**
     * if need complex query, overwrite this method
     * 
     * @return void
     */
    protected function datatable_query(){
        // for single table only
        if (!is_null($this->column))
            $this->db->select($this->column);
            
        $this->db->from($this->table);
        
        // optional
        if (count($this->where) > 0) {
            # code...
            foreach ($this->where as $column => $value) {
                # code...
                $this->db->where($column, $value);
            }
        }
    }

    /**
     * other property table for datatables like search, order, etc.
     *
     * @return void
     */
    protected function datatable_props(){
        $i = 0;
	
		foreach ($this->column_search as $item)
		{
			if($this->param['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $this->param['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $this->param['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($this->param['order']))
		{
			$this->db->order_by($this->column_order[$this->param['order']['0']['column']], $this->param['order']['0']['dir']);
		} 
		else if(isset($this->order) && count($this->order) > 0)
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
    }

	/**
	 * [get_datatables description]
	 * @return [type] [description]
	 */
	public function get_datatables(){
		$this->get_datatables_query();
		if($this->param['length'] != -1)
		    $this->db->limit($this->param['length'], $this->param['start']);
        $query = $this->db->get();
        
		return  array(
            "draw" => $this->param['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            'data' => $query->result()
        );
	}

	/**
	 * [count_filtered description]
	 * @return [type] [description]
	 */
	public function count_filtered(){
		$this->get_datatables_query();
        $query = $this->db->get();
        
		return $query->num_rows();
	}

	/**
	 * [count_all description]
	 * @return [type] [description]
	 */
	public function count_all(){
        $this->get_datatables_query();
        
		return $this->db->count_all_results();
    }

    /**
     * parameter setter
     */
    public function set_param($param = []){
        $this->param = $param;
    }

    /**
     * parameter getter
     */
    public function get_param(){
        return $this->param;
    }
}
/* End of file SYS_Model.php */