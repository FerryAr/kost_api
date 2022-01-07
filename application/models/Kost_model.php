<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kost_model extends CI_Model
{

    public $table = 'kost';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    // datatables
    function json() {
        $this->datatables->select('kost.id, kost.nama_kost,  pemilik.first_name as pemilik, kost.alamat, kost.hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat');
        $this->datatables->from('kost');
        $this->datatables->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id');
        $this->datatables->join('kost_type', 'kost.type_kost = kost_type.id');
        $this->datatables->join('fasilitas_kost', 'kost.id=fasilitas_kost.kost_id');
        $this->datatables->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id=kost_fasilitas.id');
        $this->datatables->join('kost_foto', 'kost.id=kost_foto.kost_id');
        $this->datatables->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id');
        $this->datatables->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id');
        $this->datatables->join('users operator', 'kost.operator=operator.id');
        $this->datatables->group_by('kost.id');
        //$this->datatables->group_by('fasilitas_kost.kost_id');
        $this->datatables->add_column('action', anchor(site_url('kost/read/$1'),'Read')." | ".anchor(site_url('kost/update/$1'),'Update')." | ".anchor(site_url('kost/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }

    function json_pemilik($pemilik) {
        $this->datatables->select('kost.id, kost.nama_kost,  pemilik.first_name as pemilik, kost.alamat, kost.hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat');
        $this->datatables->from('kost');
        $this->datatables->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id');
        $this->datatables->join('kost_type', 'kost.type_kost = kost_type.id');
        $this->datatables->join('fasilitas_kost', 'kost.id=fasilitas_kost.kost_id');
        $this->datatables->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id=kost_fasilitas.id');
        $this->datatables->join('kost_foto', 'kost.id=kost_foto.kost_id');
        $this->datatables->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id');
        $this->datatables->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id');
        $this->datatables->join('users operator', 'kost.operator=operator.id');
        $this->datatables->where('pemilik.id', $pemilik);
        $this->datatables->group_by('kost.id');
        //$this->datatables->group_by('fasilitas_kost.kost_id');
        $this->datatables->add_column('action', anchor(site_url('kost/read/$1'),'Read')." | ".anchor(site_url('kost/update/$1'),'Update')." | ".anchor(site_url('kost/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }

    function json_operator($id) {
        $this->datatables->select('kost.id, kost.nama_kost,  pemilik.first_name as pemilik, kost.alamat, kost.hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat');
        $this->datatables->from('kost');
        $this->datatables->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id');
        $this->datatables->join('kost_type', 'kost.type_kost = kost_type.id');
        $this->datatables->join('fasilitas_kost', 'kost.id=fasilitas_kost.kost_id');
        $this->datatables->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id=kost_fasilitas.id');
        $this->datatables->join('kost_foto', 'kost.id=kost_foto.kost_id');
        $this->datatables->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id');
        $this->datatables->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id');
        $this->datatables->join('users operator', 'kost.operator=operator.id');
        $this->datatables->where('kost.operator', $id);
        $this->datatables->group_by('kost.id');
        //$this->datatables->group_by('fasilitas_kost.kost_id');
        $this->datatables->add_column('action', anchor(site_url('kost/read/$1'),'Read')." | ".anchor(site_url('kost/update/$1'),'Update')." | ".anchor(site_url('kost/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }

    function json_list() {
        $this->datatables->select('kost.id, kost.nama_kost,  pemilik.first_name as pemilik, kost.alamat, kost.hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat');
        $this->datatables->from('kost');
        $this->datatables->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id');
        $this->datatables->join('kost_type', 'kost.type_kost = kost_type.id');
        $this->datatables->join('fasilitas_kost', 'kost.id=fasilitas_kost.kost_id');
        $this->datatables->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id=kost_fasilitas.id');
        $this->datatables->join('kost_foto', 'kost.id=kost_foto.kost_id');
        $this->datatables->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id');
        $this->datatables->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id');
        $this->datatables->join('users operator', 'kost.operator=operator.id');
        $this->datatables->group_by('kost.id');
        //$this->datatables->group_by('fasilitas_kost.kost_id');
        $this->datatables->add_column('action', anchor(site_url('kost/read/$1'),'Read'), 'id');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $query = $this->db->select('kost.id, kost.nama_kost,  pemilik.first_name as pemilik, kost.alamat, kost.hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat')
            ->from('kost')
            ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
            ->join('kost_type', 'kost.type_kost = kost_type.id')
            ->join('fasilitas_kost', 'kost.id=fasilitas_kost.kost_id')
            ->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id=kost_fasilitas.id')
            ->join('kost_foto', 'kost.id=kost_foto.kost_id')
            ->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id')
            ->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id')
            ->join('users operator', 'kost.operator=operator.id')
            ->where('kost.id', $id)
            ->group_by('kost.id')
            ->get();
        return $query->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('nama_kost', $q);
	$this->db->or_like('pemilik', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('hp', $q);
	$this->db->or_like('jenis_kost', $q);
	$this->db->or_like('area_terdekat', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('nama_kost', $q);
	$this->db->or_like('pemilik', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('hp', $q);
	$this->db->or_like('jenis_kost', $q);
	$this->db->or_like('area_terdekat', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Kost_model.php */
/* Location: ./application/models/Kost_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-11-17 06:09:27 */
/* http://harviacode.com */