<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horses extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Horse');
	}

	public function index()
	{
		$data['horses'] = $this->Horse->get_all();
		$this->load->view('header/header');
		$this->load->view('class_list', $data);
		$this->load->view('footer/footer');
	}

	public function reorder()
	{
		$ids = $this->input->get('item');
		//$ids = $_GET['item'];
		$display_order = 1;

		foreach ($ids as $id) 
		{
	        $new_data['display_order'] = $display_order;
	        $this->Horse->update($id, $new_data);

			$display_order++;
		}

		echo json_encode("Complete");
	}

	public function ajax_edit($id)
	{
		$data = $this->Horse->get($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->validate();
		$data = array(
				'name' => $this->input->post('name'),
			);
		$this->Horse->update($this->input->post('id'), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_delete($id)
	{
		$this->Horse->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_add()
	{
		$this->validate();
		$data = array(
				'name' => $this->input->post('name'),
			);
		$insert = $this->Horse->add($data);
		echo json_encode(array("status" => TRUE));
	}

	public function validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
