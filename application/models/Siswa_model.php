<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model
{
    var $table = 'siswa';
    var $column_order = array('id_siswa', 'nama_siswa', 'alamat_siswa', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'nama_sekolah');
    var $order = array('id_siswa', 'nama_siswa', 'alamat_siswa', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'nama_sekolah');

    public function getData()
    {
        $this->get_data_query();

        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered_data()
    {
        $this->get_data_query();

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }

    private function get_data_query()
    {
        // $this->db->from($this->table);
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id_sekolah = siswa.id_sekolah');

        // untuk mencari data
        if(isset($_POST['search']['value'])){
            $this->db->like('siswa.nama_siswa', $_POST['search']['value']);
            $this->db->or_like('siswa.alamat_siswa', $_POST['search']['value']);
            $this->db->or_like('siswa.tempat_lahir', $_POST['search']['value']);
            $this->db->or_like('siswa.tgl_lahir', $_POST['search']['value']);
            $this->db->or_like('siswa.jenis_kelamin', $_POST['search']['value']);
            $this->db->or_like('sekolah.nama_sekolah', $_POST['search']['value']);
        }

        // untuk oreder data
        if(isset($_POST['order'])){
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id_siswa', 'DESC');
        }
    }

    public function add($data)
    {
        $this->db->insert('siswa', $data);

        return $this->db->affected_rows();
    }

    public function getDataById($id)
    {
        // return $this->db->get_where('karyawan', ['id' => $id])->row();
        $this->db->where('id_siswa', $id);
        return $this->db->get('siswa')->row();
    }

    public function update($data)
    {
        $params = [
            "nama_siswa" => $data['nama_siswa'],
            "alamat_siswa" => $data['alamat_siswa'],
            "tempat_lahir" => $data['tempat_lahir'],
            "tgl_lahir" => $data['tgl_lahir'],
            "jenis_kelamin" => $data['jenis_kelamin'],
            "id_sekolah" => $data['id_sekolah'],
        ];

        $where = [
            "id_siswa" => $data['id_siswa']
        ];

        $this->db->update('siswa', $params, $where);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->delete('siswa', ['id_siswa' => $id]);
        return $this->db->affected_rows();
        
        
    }
}
?>