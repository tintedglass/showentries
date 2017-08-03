<?php
class Horse extends CI_Model
{
	// The table to pull from the database
	public $parent_table = 'horses';

	public function __construct()
	{
		parent::__construct();
		// Connect to the default database
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($id)
	{
		// Get from the table where id = $id
    	$where['id'] = $id;
   		$result_set = $this->db->get_where($this->parent_table, $where);
   		// Convert results to an array
    	$result_arr = $result_set->result_array();

    	// Return only the first result
    	return $result_arr[0];
	}
	
	public function get_all()
	{
		$this->db->from($this->parent_table);
		$this->db->order_by("display_order", "asc");
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function add($data)
	{
		$this->db->insert($this->parent_table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $new_data)
	{
		$where['id'] = $id;
		$this->db->update($this->parent_table, $new_data, $where);
	}

	public function delete($id)
	{
 		$this->db->where('id', $id);
   		$this->db->delete($this->parent_table); 
	}
}