<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kost_detail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kost_detail_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Upload_model');
        $this->load->library('ion_auth');
    }

    public function index()
    {
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
        );
        $this->load->view('_template/header', $data);
        $this->load->view('kost_detail/kost_detail_list');
        $this->load->view('_template/footer');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kost_detail_model->json();
    }

    public function read($id)
    {
        $row = $this->Kost_detail_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'nama_kost' => $row->nama_kost,
                'nama_kamar' => $row->nama_kamar,
                'deskripsi_kamar' => $row->deskripsi_kamar,
                'harga' => $row->harga,
                'foto' => $row->foto,
                'fasilitas' => $row->fasilitas,
            );
            $this->load->view('kost_detail/kost_detail_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kost_detail'));
        }
    }

    public function create()
    {
        $nama_kost = $this->db->select('*')->from('kost')->get()->result();
        $data = array(
            'button' => 'Create',
            'action' => site_url('kost_detail/create_action'),
            'id' => set_value('id'),
            'id_kost' => '',
            'nama_kost' => $nama_kost,
            //'id_kost' => set_value('id_kost'),
            'nama_kamar' => set_value('nama_kamar'),
            'deskripsi_kamar' => set_value('deskripsi_kamar'),
            'harga' => set_value('harga'),
            'fasilitas' => set_value('fasilitas'),
            'first_name' => $this->ion_auth->user()->row()->first_name,
        );
        $this->load->view('_template/header', $data);
        $this->load->view('kost_detail/kost_detail_form');
        $this->load->view('_template/footer');
    }

    public function create_action()
    {
        if ($this->input->post()) {
            $config['upload_path']          = realpath(APPPATH . '../assets/img');
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);

            if ($this->input->post('fasilitas') == '') {
                $this->session->set_flashdata('message', 'Fasilitas belum dipilih');
                redirect(site_url('kost_detail'));
            } else {
                $data = array(
                    'id_kost' => $this->input->post('id_kost'),
                    'nama_kamar' => $this->input->post('nama_kamar'),
                    'deskripsi_kamar' => $this->input->post('deskripsi_kamar'),
                    'harga' => $this->input->post('harga'),
                    'fasilitas' => implode(',', $this->input->post('fasilitas')),
                );
                $this->Kost_detail_model->insert($data);
                echo '<pre>';
                print_r($_FILES['foto_kamar']);
                echo '</pre>';
                $gambars = $this->Upload_model->mupload_files('assets/img', '', $_FILES['foto_kamar']);
                $id = $this->db->insert_id();

                foreach ($gambars as $gambar) {
                    $this->db->insert('kost_foto', array('foto' => $gambar, 'kost_detail_id' => $id));
                }
                return $this->db->error();
            }
        }
    }

    public function update($id)
    {
        $row = $this->Kost_detail_model->get_by_id($id);



        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kost_detail/update_action'),
                'id' => set_value('id', $row->id),
                'id_kost' => set_value('id_kost', $row->id_kost),
                'nama_kamar' => set_value('nama_kamar', $row->nama_kamar),
                'nama_kost' => $this->db->select('*')->from('kost')->get()->result(),
                'deskripsi_kamar' => set_value('deskripsi_kamar', $row->deskripsi_kamar),
                'harga' => set_value('harga', $row->harga),
                'foto' => $row->foto,
                'fasilitas' => set_value('fasilitas', $row->fasilitas),
                'first_name' => $this->ion_auth->user()->row()->first_name,
            );
            $this->load->view('_template/header', $data);
            $this->load->view('kost_detail/kost_detail_form');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kost_detail'));
        }
    }

    public function update_action()
    {
        $id = $this->input->post('id', TRUE);
        $row = $this->Kost_detail_model->get_by_id($id);
        $data_foto_lama = $row->foto;

        if ($this->input->post()) {
            if ($this->input->post('fasilitas') == '') {
                $this->session->set_flashdata('message', 'Fasilitas belum dipilih');
                redirect(site_url('kost_detail'));
            } else {
                $data = array(
                    'id_kost' => $this->input->post('id_kost'),
                    'nama_kamar' => $this->input->post('nama_kamar'),
                    'deskripsi_kamar' => $this->input->post('deskripsi_kamar'),
                    'harga' => $this->input->post('harga'),
                    'fasilitas' => implode(',', $this->input->post('fasilitas')),
                );
                $this->db->where('id', $id);
                $this->db->update('kost_detail', $data);
                $foto_lama = explode(',', $data_foto_lama);
                foreach ($foto_lama as $fl) {
                    unlink('assets/img/' . $fl);
                }
                $gambars = $this->Upload_model->mupload_files('assets/img', '', $_FILES['foto_kamar']);
                foreach ($gambars as $gambar) {
                    $this->db->update('kost_foto', array('foto' => $gambar), array('kost_detail_id' => $id));
                }

                redirect(site_url('kost_detail'));
            }
        }
    }

    public function delete($id)
    {

        if (!empty($id)) {
            $row = $this->Kost_detail_model->get_by_id($id);
            $data_foto_lama = $row->foto;
            $foto_lama = explode(',', $data_foto_lama);
            foreach ($foto_lama as $fl) {
                unlink('assets/img/' . $fl);
            }
            $this->db->where('id', $id);
            $this->db->delete('kost_detail');
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kost_detail'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('id_kost', 'id kost', 'trim|required');
        $this->form_validation->set_rules('nama_kamar', 'nama kamar', 'trim|required');
        $this->form_validation->set_rules('deskripsi_kamar', 'deskripsi kamar', 'trim|required');
        $this->form_validation->set_rules('harga', 'harga', 'trim|required');
        $this->form_validation->set_rules('fasilitas', 'fasilitas', 'trim|required');

        $this->form_validation->set_rules('', '', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Kost_detail.php */
/* Location: ./application/controllers/Kost_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-11-17 06:09:31 */
/* http://harviacode.com */