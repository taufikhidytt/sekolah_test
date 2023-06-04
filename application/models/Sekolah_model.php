<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah_model extends CI_Model
{
    var $table = 'sekolah';
    var $column_order = array('id_sekolah', 'nama_sekolah', 'alamat_sekolah', 'jml_kelas');
    var $order = array('id_sekolah', 'nama_sekolah', 'alamat_sekolah', 'jml_kelas');

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
        $this->db->from($this->table);

        // untuk mencari data
        if(isset($_POST['search']['value'])){
            $this->db->like('nama_sekolah', $_POST['search']['value']);
            $this->db->or_like('alamat_sekolah', $_POST['search']['value']);
            $this->db->or_like('jml_kelas', $_POST['search']['value']);
        }

        // untuk oreder data
        if(isset($_POST['order'])){
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id_sekolah', 'DESC');
        }
    }

    public function add($data)
    {
        $this->db->insert('sekolah', $data);

        return $this->db->affected_rows();
    }

    public function getDataById($id_sekolah)
    {
        $this->db->where('id_sekolah', $id_sekolah);
        return $this->db->get('sekolah')->row();
    }

    public function update($data)
    {
        $params = [
            "nama_sekolah" => $data['nama_sekolah'],
            "alamat_sekolah" => $data['alamat_sekolah'],
            "jml_kelas" => $data['jml_kelas'],
        ];

        $where = [
            "id_sekolah" => $data['id_sekolah']
        ];

        $this->db->update('sekolah', $params, $where);
        return $this->db->affected_rows();
    }

    public function delete($id_sekolah)
    {
        $this->db->delete('sekolah', ['id_sekolah' => $id_sekolah]);
        return $this->db->affected_rows();
        
        
    }
}
?>