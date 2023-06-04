<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sekolah_model', 'sekolah');
	}

	public function index()
	{
		$this->load->view('sekolah/index');
	}

	public function getData()
	{
		$result = $this->sekolah->getData();
		$data = [];
		$no = $_POST['start'];

		foreach($result as $result){
			$row = array();
			$row[] = ++$no;
			$row[] = $result->nama_sekolah;
			$row[] = $result->alamat_sekolah;
			$row[] = $result->jml_kelas;
			$row[] = '
			<a href="#" class="btn btn-primary" onclick="byid('."'".$result->id_sekolah."','edit'".')">Edit</a> |
			<a href="#" class="btn btn-danger" onclick="byid('."'".$result->id_sekolah."','hapus'".')">Hapus</a>
			';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->sekolah->count_all_data(),
			"recordsFiltered" => $this->sekolah->count_filtered_data(),
			"data" => $data
		);

		$this->output->set_content_type('aplication/json')->set_output(json_encode($output));
	}

	public function add()
	{
		$this->_validation();

		$data = [
			'nama_sekolah' => htmlspecialchars($this->input->post('nama_sekolah')),
			'alamat_sekolah' => htmlspecialchars($this->input->post('alamat_sekolah')),
			'jml_kelas' => htmlspecialchars($this->input->post('jml_kelas')),
		];

		if($this->sekolah->add($data) > 0){
			$massage['status'] = 'success';
		}else{
			$massage['status'] = 'failed';
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($massage));
	}

	public function byid($id_sekolah)
	{
		$data = $this->sekolah->getDataById($id_sekolah);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function update()
	{
		$this->_validation();
		$data = $this->input->post(null, true);
		
		if($this->sekolah->update($data) >= 0){
			$massage['status'] = 'success';
		}else{
			$massage['status'] = 'failed';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($massage));
	}

	public function delete($id_sekolah)
	{
		if($this->sekolah->delete($id_sekolah) > 0){
			$massage['status'] = 'success';
		}else{
			$massage['status'] = 'failed';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($massage));
	}

	private function _validation()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = true;

		if($this->input->post('nama_sekolah') == ''){
			$data['inputerror'][] = 'nama_sekolah';
			$data['error_string'][] = 'Nama Sekolah Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('alamat_sekolah') == ''){
			$data['inputerror'][] = 'alamat_sekolah';
			$data['error_string'][] = 'Alamat Sekolah Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('jml_kelas') == ''){
			$data['inputerror'][] = 'jml_kelas';
			$data['error_string'][] = 'Jumlah Kelas Wajib Di Isi';
		}

		if($data['status'] === false){
			echo json_encode($data);
			exit();
		}
	}

}
