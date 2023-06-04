<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Siswa_model', 'siswa');
	}

	public function index()
	{
		$this->load->view('siswa/index');
	}

	public function load_sekolah()
	{
        $sekolah['sekolah'] = $this->db->query("SELECT * FROM sekolah")->result_array();
        $this->output->set_content_type('aplication/json')->set_output(json_encode($sekolah));
	}

	public function getData()
	{
		$result = $this->siswa->getData();
		$data = [];
		$no = $_POST['start'];

		foreach($result as $result){
			$row = array();
			$row[] = ++$no;
			$row[] = $result->nama_siswa;
			$row[] = $result->alamat_siswa;
			$row[] = $result->tempat_lahir;
			$row[] = $result->tgl_lahir;
			$row[] = $result->jenis_kelamin;
			$row[] = $result->nama_sekolah;
			$row[] = '
			<a href="#" class="btn btn-primary" onclick="byid('."'".$result->id_siswa."','edit'".')">Edit</a> |
			<a href="#" class="btn btn-danger" onclick="byid('."'".$result->id_siswa."','hapus'".')">Hapus</a>
			';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->siswa->count_all_data(),
			"recordsFiltered" => $this->siswa->count_filtered_data(),
			"data" => $data
		);

		$this->output->set_content_type('aplication/json')->set_output(json_encode($output));
	}

	public function add()
	{
		$this->_validation();

		$data = [
			'nama_siswa' => htmlspecialchars($this->input->post('nama_siswa')),
			'alamat_siswa' => htmlspecialchars($this->input->post('alamat_siswa')),
			'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir')),
			'tgl_lahir' => htmlspecialchars($this->input->post('tgl_lahir')),
			'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
			'id_sekolah' => htmlspecialchars($this->input->post('id_sekolah')),
		];

		if($this->siswa->add($data) > 0){
			$massage['status'] = 'success';
		}else{
			$massage['status'] = 'failed';
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($massage));
	}

	public function byid($id)
	{
		$data = $this->siswa->getDataById($id);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function update()
	{
		$this->_validation();
		$data = $this->input->post(null, true);
		
		if($this->siswa->update($data) >= 0){
			$massage['status'] = 'success';
		}else{
			$massage['status'] = 'failed';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($massage));
	}

	public function delete($id)
	{
		if($this->siswa->delete($id) > 0){
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

		if($this->input->post('nama_siswa') == ''){
			$data['inputerror'][] = 'nama_siswa';
			$data['error_string'][] = 'Nama Siswa Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('alamat_siswa') == ''){
			$data['inputerror'][] = 'alamat_siswa';
			$data['error_string'][] = 'Alamat Siswa Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('tempat_lahir') == ''){
			$data['inputerror'][] = 'tempat_lahir';
			$data['error_string'][] = 'Tempat Lahir Wajib Di Isi';
		}

		if($this->input->post('tgl_lahir') == ''){
			$data['inputerror'][] = 'tgl_lahir';
			$data['error_string'][] = 'Tanggal Lahir Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('jenis_kelamin') == ''){
			$data['inputerror'][] = 'jenis_kelamin';
			$data['error_string'][] = 'Jenis Kelamin Wajib Di Isi';
			$data['status'] = false;
		}

		if($this->input->post('id_sekolah') == '-'){
			$data['inputerror'][] = 'id_sekolah';
			$data['error_string'][] = 'Sekolah Wajib Di Isi';
			$data['status'] = false;
		}

		if($data['status'] === false){
			echo json_encode($data);
			exit();
		}
	}

}
