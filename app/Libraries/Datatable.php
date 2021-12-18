<?php namespace App\Libraries;

use CodeIgniter\Model;

class Datatable extends Model {
  protected $request;
	protected $dt;
	protected $dtc;
	protected $table_datatables;
	protected $column_order = array();
	protected $column_search = array();
	protected $order = array();
	protected $select = array();

  function __construct(){
		parent::__construct();
		$this->request = \Config\Services::request();
		$this->dtc = $this->db->table($this->table_datatables);
	}

  protected function _get_datatables_query(){
		$this->extra_datatables();
		$i = 0;
		foreach ($this->column_search as $item){
			if($this->request->getPost('search')['value']){ 
				if($i===0){
					$this->dt->groupStart();
					$this->dt->like($item, $this->request->getPost('search')['value']);
				} else{
					$this->dt->orLike($item, $this->request->getPost('search')['value']);
				}
				if(count($this->column_search) - 1 == $i)
					$this->dt->groupEnd();
			}
			$i++;
		}

		$order_post = $this->request->getPost('order');
		if($order_post && $this->column_order[$order_post['0']['column']]){
			$this->dt->orderBy($this->column_order[$order_post['0']['column']], $order_post['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->dt->orderBy(key($order), $order[key($order)]);
		}
	}

	public function get_datatables(){
		$this->dt = $this->db->table($this->table_datatables);
		$this->_get_datatables_query();
		if($this->select) $this->dt->select($this->select);
		if($this->request->getPost('length') != -1)
			$this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
		$query = $this->dt->get();
		return $query->getResult();
	}

	public function count_filtered_datatables(){
		$this->dt = $this->db->table($this->table_datatables);
		$this->_get_datatables_query();
		return $this->dt->countAllResults();
	}

	public function count_all_datatables(){
		return $this->dtc->countAllResults();
	}

	public function extra_datatables(){}
}