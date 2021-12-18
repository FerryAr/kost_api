<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Carousel_iklan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Carousel_iklan_model');
        $this->load->model('Upload_model');
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('datatables');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
        );
        $this->load->view('_template/header', $data);
        $this->load->view('carousel_iklan/carousel_iklan_list');
        $this->load->view('_template/footer');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Carousel_iklan_model->json();
    }

    public function read($id)
    {
        $row = $this->Carousel_iklan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'foto_iklan' => $row->foto_iklan,
                'level' => $row->level,
                'keterangan' => $row->keterangan,
                'first_name' => $this->ion_auth->user()->row()->first_name,
            );
            $this->load->view('_template/header', $data);
            $this->load->view('carousel_iklan/carousel_iklan_read');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('carousel_iklan'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('carousel_iklan/create_action'),
            'level' => set_value('level'),
            'keterangan' => set_value('keterangan'),
            'id' => '',
            'first_name' => $this->ion_auth->user()->row()->first_name,
        );
        $this->load->view('_template/header', $data);
        $this->load->view('carousel_iklan/carousel_iklan_form');
        $this->load->view('_template/footer');
    }

    public function create_action()
    {
        // echo '<pre>';
        // print_r($_FILES);
        // echo '</pre>';
        if ($this->input->post()) {
            $config['upload_path']          = realpath(APPPATH . '../assets/img/sliders');
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);

            if (!isset($_FILES['foto_iklan'])) {
                $this->session->set_flashdata('message', 'Gambar Iklan Tidak Boleh Kosong');
                redirect(site_url('carousel_iklan'));
            } else {
                $foto_iklan = $this->Upload_model->images('assets/img/sliders', '', $_FILES['foto_iklan']);
                $data = array(
                    'foto_iklan' => $foto_iklan,
                    'level' => $this->input->post('level', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                );
                $this->Carousel_iklan_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('carousel_iklan'));
            }
        }
    }

    public function update($id)
    {
        $row = $this->Carousel_iklan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('carousel_iklan/update_action'),
                'id' => set_value('id', $row->id),
                'foto_iklan' => $row->foto_iklan,
                'level' => set_value('level', $row->level),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'first_name' => $this->ion_auth->user()->row()->first_name,
            );
            $this->load->view('_template/header', $data);
            $this->load->view('carousel_iklan/carousel_iklan_form');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('carousel_iklan'));
        }
    }

    public function update_action()
    {
        $row = $this->Carousel_iklan_model->get_by_id($this->input->post('id', TRUE));
        $data_foto_lama = $row->foto_iklan;
        // $this->_rules();

        // if ($this->form_validation->run() == FALSE) {
        //     $this->update($this->input->post('id', TRUE));
        // } else {
        //     $data = array(
        //         'foto_iklan' => $this->input->post('foto_iklan', TRUE),
        //         'level' => $this->input->post('level', TRUE),
        //         'keterangan' => $this->input->post('keterangan', TRUE),
        //     );

        //     $this->Carousel_iklan_model->update($this->input->post('id', TRUE), $data);
        //     $this->session->set_flashdata('message', 'Update Record Success');
        //     redirect(site_url('carousel_iklan'));
        // }
        if ($this->input->post()) {
            if (empty($_FILES['foto_iklan']['name'])) {
                $data = array(
                    'level' => $this->input->post('level', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                );
                $this->db->where('id', $this->input->post('id', TRUE));
                $this->db->update('carousel_iklan', $data);
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('carousel_iklan'));
            } else {
                $config['upload_path']          = realpath(APPPATH . '../assets/img/sliders');
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $this->load->library('upload', $config);
                unlink(realpath(APPPATH . '../assets/img/sliders/' . $data_foto_lama));
                $foto_iklan = $this->Upload_model->images('assets/img/sliders', '', $_FILES['foto_iklan']);
                $data = array(
                    'foto_iklan' => $foto_iklan,
                    'level' => $this->input->post('level', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                );
                $this->db->where('id', $this->input->post('id', TRUE));
                $this->db->update('carousel_iklan', $data);
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('carousel_iklan'));
            }
        }
    }

    public function delete($id)
    {
        $row = $this->Carousel_iklan_model->get_by_id($id);

        if ($row) {
            $this->Carousel_iklan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('carousel_iklan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('carousel_iklan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('foto_iklan', 'foto iklan', 'trim|required');
        $this->form_validation->set_rules('level', 'level', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Carousel_iklan.php */
/* Location: ./application/controllers/Carousel_iklan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-12-17 07:24:14 */
/* http://harviacode.com */