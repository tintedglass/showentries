<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shows extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Show');
	}

	public function index()
	{
		echo "This";
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
		$this->Show->update($this->input->post('id'), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_delete($id)
	{
		$this->Show->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_add()
	{
		$this->validate();
		$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'date' => $this->input->post('date'),
				'description' => $this->input->post('description'),
			);
		$insert = $this->Show->add($data);
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
