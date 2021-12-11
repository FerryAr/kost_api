<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Api extends CI_Controller
{

    private $apiKey = "691ACB";

    public function __construct()
    {
        parent::__construct();
    }
    public function get_all_kost()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, jenis_kost.jenis, kost.area_terdekat, kost.foto_unggulan')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->get()
                ->result();
            foreach ($query as $q) {
                $arr[] = [
                    'id_kost' => $q->id,
                    'nama_kost' => $q->nama_kost,
                    'pemilik' => $q->pemilik,
                    'alamat' => $q->alamat,
                    'no_hp' => $q->no_hp,
                    'jenis' => $q->jenis,
                    'area_terdekat' => $q->area_terdekat,
                    'foto_unggulan' => $q->foto_unggulan
                ];
            }
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => $arr
                ]
            );
        }
    }
    public function get_kost()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $id = $this->input->post('id');
            $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.fasilitas, kost.area_terdekat')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->join('kost_type', 'kost.type_kost = kost_type.id')
                ->join('kost_foto', 'kost.id = kost_foto.kost_id')
                ->where('kost.id', $id)
                ->get()
                ->row();
            header('Content-Type: application/json');
            $foto = explode(',', $query->foto);
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => [
                        'id_kost' => $query->id,
                        'nama_kost' => $query->nama_kost,
                        'pemilik' => $query->pemilik,
                        'alamat' => $query->alamat,
                        'no_hp' => $query->no_hp,
                        'jenis' => $query->jenis,
                        'type' => $query->type,
                        'harga' => $query->harga,
                        'foto' => $foto,
                        'fasilitas' => $query->fasilitas,
                        'area_terdekat' => $query->area_terdekat
                    ]
                ]
            );
        }
    }
    public function get_kost_by_jenis()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $jenis = $this->input->post('jenis');
            $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.fasilitas, kost.area_terdekat')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->join('kost_type', 'kost.type_kost = kost_type.id')
                ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                ->where('kost.jenis_kost', $jenis)
                ->get()
                ->result();
            foreach ($query as $q) {
                $foto = explode(',', $q->foto);
                $arr[] = [
                    'id_kost' => $q->id,
                    'nama_kost' => $q->nama_kost,
                    'pemilik' => $q->pemilik,
                    'alamat' => $q->alamat,
                    'no_hp' => $q->no_hp,
                    'jenis' => $q->jenis,
                    'type' => $q->type,
                    'harga' => $q->harga,
                    'area_terdekat' => $q->area_terdekat,
                    'foto' => reset($foto),
                ];
            }
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => $arr
                ]
            );
        } else {
            $this->output->set_status_header(403);
        }
    }
    public function get_kost_detail()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $id_kost = $this->input->post('id_kost');
            $query = $this->db->select('kost_detail.id, kost_detail.nama_kamar, kost_detail.deskripsi_kamar, kost_detail.harga, kost_detail.fasilitas, GROUP_CONCAT(kost_foto.foto) AS foto')
                ->from('kost_detail')
                ->join('kost_foto', 'kost_detail.id = kost_foto.kost_detail_id')
                ->where('kost_detail.id_kost', $id_kost)
                ->group_by('kost_detail.id')
                ->get()
                ->result();
            if (count($query) == 0) {
                $this->output->set_status_header(404);
            } else {
                foreach ($query as $q) {
                    $arr[] = [
                        'nama_kamar' => $q->nama_kamar,
                        'deskripsi_kamar' => $q->deskripsi_kamar,
                        'harga' => $q->harga,
                        'fasilitas' => $q->fasilitas,
                        'foto' => $q->foto
                    ];
                }
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'data' => $query
                    ]
                );
            }
        }
    }
    public function get_kost_by_nama()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $arr = [];
            if ($this->input->post('apiKey') == $this->apiKey) {
                $nama_kost = $this->input->post('nama_kost');
                $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, jenis_kost.jenis, kost.area_terdekat, kost.foto_unggulan')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->where('kost.nama_kost', $nama_kost)
                    ->get()
                    ->result();
                foreach ($query as $q) {
                    $arr[] = [
                        'id_kost' => $q->id,
                        'nama_kost' => $q->nama_kost,
                        'pemilik' => $q->pemilik,
                        'alamat' => $q->alamat,
                        'no_hp' => $q->no_hp,
                        'jenis' => $q->jenis,
                        'area_terdekat' => $q->area_terdekat,
                        'foto_unggulan' => $q->foto_unggulan
                    ];
                }
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'data' => $arr
                    ]
                );
            }
        }
    }

    public function get_jenis()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $query = $this->db->select('id, jenis')
                ->from('jenis_kost')
                ->get()
                ->result();
            foreach ($query as $q) {
                $arr[] = [
                    'id' => $q->id,
                    'jenis' => $q->jenis
                ];
            }
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => $arr
                ]
            );
        } else {
            $this->output->set_status_header(403);
        }
    }
}

/* End of file Api.php and path /application/controllers/Api.php */
