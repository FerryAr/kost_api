<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kost extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kost_model');
        $this->load->model('Upload_model');
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('datatables');
        // if (!$this->ion_auth->logged_in()) {
        //     redirect('kost/list');
        // }
    }

    public function list() {
        $data = array(
            'url' => base_url('kost/json_list'),
        );
        $this->load->view('_template/header', $data);
        $this->load->view('kost/kost_list');
        $this->load->view('_template/footer');
    }

    public function json_list() {
        header('Content-Type: application/json');
        echo $this->Kost_model->json_list();
    }

    function json_foto()
    {
        header('Content-Type: application/json');
        $this->db->select('GROUP_CONCAT(kost_foto.foto) as foto');
        $this->db->from('kost');
        $this->db->join('kost_foto', 'kost.id = kost_foto.kost_id');
        echo json_encode($this->db->get()->result());
    }

    public function admin()
    {
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
            'url' => base_url('kost/json'),
        );
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } else {
            if ($this->ion_auth->is_admin()) {
                $this->load->view('_template/header', $data);
                $this->load->view('kost/kost_list');
                $this->load->view('_template/footer');
            }
        }
    }

    public function pemilik()
    {
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
            'url' =>  base_url('kost/json_pemilik'),
        );
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } else {
            if ($this->ion_auth->in_group('pemilik')) {
                $this->load->view('_template/header', $data);
                $this->load->view('kost/kost_list');
                $this->load->view('_template/footer');
            }
        }
    }

    public function operator()
    {
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
            'url' =>  base_url('kost/json_operator'),
        );
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        } else {
            if ($this->ion_auth->in_group('operator')) {
                $this->load->view('_template/header', $data);
                $this->load->view('kost/kost_list');
                $this->load->view('_template/footer');
            }
        }
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kost_model->json();
    }

    public function json_pemilik()
    {
        header('Content-Type: application/json');
        $pemilik = $this->ion_auth->user()->row()->first_name;
        echo $this->Kost_model->json_pemilik($pemilik);
    }

    public function json_operator()
    {
        header('Content-Type: application/json');
        $operator = $this->ion_auth->user()->row()->id;
        echo $this->Kost_model->json_operator($operator);
    }

    public function read($id)
    {
        $row = $this->Kost_model->get_by_id($id);
        if ($row) {
            $fasilitas = explode(',', $row->fasilitas);
            $foto = explode(',', $row->foto);
            $data = array(
                'id' => $row->id,
                'nama_kost' => $row->nama_kost,
                'pemilik' => $row->pemilik,
                'alamat' => $row->alamat,
                'jenis_kost' => $row->jenis,
                'type_kost' => $row->type,
                'harga' => $row->harga,
                'fasilitas' => $fasilitas,
                'foto' => $foto,
                'operator' => $row->first_name,
                'area_terdekat' => $row->area_terdekat,
            );
            $this->load->view('_template/header', $data);
            $this->load->view('kost/kost_read');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('/'));
        }
    }

    public function create()
    {
        $jenis_kost = $this->db->select('*')->from('jenis_kost')->get()->result();
        $type_kost = $this->db->select('*')->from('kost_type')->get()->result();
        $fasilitas = $this->db->select('*')->from('kost_fasilitas')->get()->result();
        $operator = $this->db->select('users.id, users.first_name')->from('users')->join('users_groups', 'users.id = users_groups.user_id')->where('users_groups.group_id', '4')->get()->result();
        $pemilik_list = $this->db->select('users.id, users.first_name')->from('users')->join('users_groups', 'users.id = users_groups.user_id')->where('users_groups.group_id', '3')->get()->result();
        $data = array(
            'first_name' => $this->ion_auth->user()->row()->first_name,
            'button' => 'Create',
            'action' => site_url('kost/create_action'),
            'id' => set_value('id'),
            'nama_kost' => set_value('nama_kost'),
            'alamat' => set_value('alamat'),
            'jenis_kost' => $jenis_kost,
            'type_kost' => $type_kost,
            'fasilitas' => $fasilitas,
            'pemilik_list' => $pemilik_list,
            'operator' => $operator,
            'jenis_selected' => '',
            'type_selected' => '',
            'fasilitas_selected' => [],
            'pemilik_selected' => '',
            'operator_selected' => '',
            'unggulan_checked' => '',
            'harga' => set_value('harga'),
            'area_terdekat' => set_value('area_terdekat'),
            'first_name' => $this->ion_auth->user()->row()->first_name,
        );
        $this->load->view('_template/header', $data);
        $this->load->view('kost/kost_form');
        $this->load->view('_template/footer');
    }

    public function create_action()
    {

        if ($this->input->post()) {
            if ($this->input->post('fasilitas') == '') {
                $this->session->set_flashdata('message', 'Fasilitas belum dipilih');
                redirect(site_url('kost'));
            } else {
                $data = array(
                    'nama_kost' => $this->input->post('nama_kost', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'jenis_kost' => $this->input->post('jenis_kost', TRUE),
                    'type_kost' => $this->input->post('type_kost', TRUE),
                    'harga' => $this->input->post('harga'),
                    'area_terdekat' => $this->input->post('area_terdekat', TRUE),
                    'unggulan' => $this->input->post('unggulan', TRUE),
                    'update_time' => time()
                );
                if($this->ion_auth->is_admin() || $this->ion_auth->in_group('operator')){
                    $pemilik = $this->input->post('pemilik', TRUE);
                } else {
                    $pemilik = $this->ion_auth->user()->row()->id;
                }
                if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('pemilik')) {
                    $data['operator'] = $this->input->post('operator', TRUE);
                } else {
                    $data['operator'] = $this->ion_auth->user()->row()->id;
                }
                $this->Kost_model->insert($data);

                $gambars = $this->Upload_model->mupload_files(realpath(APPPATH . '../assets/img/foto_kost'), '', $_FILES['foto_kost']);
                $id = $this->db->insert_id();

                $fasilitas = $this->input->post('fasilitas');
                foreach ($fasilitas as $f) {
                    $this->db->insert('fasilitas_kost', array('kost_id' => $id, 'fasilitas_id' => $f));
                }

                foreach ($gambars as $gambar) {
                    $this->db->insert('kost_foto', array('kost_id' => $id, 'foto' => $gambar));
                }

                $this->db->insert('kost_pemilik', array('kost_id' => $id, 'pemilik_id' => $pemilik));
                // return $this->db->error();
                $this->session->set_flashdata('message', 'Create Record Success');
                if ($this->ion_auth->is_admin()) {
                    redirect(site_url('kost/admin'));
                } else if ($this->ion_auth->in_group('pemilik')) {
                    redirect(site_url('kost/pemilik'));
                } else if ($this->ion_auth->in_group('operator')) {
                    redirect(site_url('kost/operator'));
                }
            }
        } else {
            if ($this->ion_auth->is_admin()) {
                redirect(site_url('kost/admin'));
            } else if ($this->ion_auth->in_group('pemilik')) {
                redirect(site_url('kost/pemilik'));
            } else if ($this->ion_auth->in_group('operator')) {
                redirect(site_url('kost/operator'));
            }
        }
    }

    public function update($id)
    {
        $row = $this->Kost_model->get_by_id($id);
        $jenis_kost = $this->db->select('*')->from('jenis_kost')->get()->result();
        $type_kost = $this->db->select('*')->from('kost_type')->get()->result();
        $pemilik_list = $this->db->select('users.id, users.first_name')->from('users')->join('users_groups', 'users.id = users_groups.user_id')->where('users_groups.group_id', '3')->get()->result();
        $fasilitas = $this->db->select('*')->from('kost_fasilitas')->get()->result();
        $fasilitas_selected = $this->db->select('fasilitas_id')->from('fasilitas_kost')->where('kost_id', $id)->get()->result();
        $operator = $this->db->select('users.id, users.first_name')->from('users')->join('users_groups', 'users.id = users_groups.user_id')->where('users_groups.group_id', '4')->get()->result();
        if ($row) {
            $data = array(
                'first_name' => $this->ion_auth->user()->row()->first_name,
                'button' => 'Update',
                'action' => site_url('kost/update_action'),
                'id' => set_value('id', $row->id),
                'nama_kost' => set_value('nama_kost', $row->nama_kost),
                'pemilik_list' => $pemilik_list,
                'pemilik_selected' => $row->pemilik,
                'alamat' => set_value('alamat', $row->alamat),
                'jenis_kost' => $jenis_kost,
                'type_kost' => $type_kost,
                'jenis_selected' => $row->jenis_kost,
                'type_selected' => $row->type_kost,
                'harga' => set_value('harga', $row->harga),
                'operator' => $operator,
                'operator_selected' => $row->operator,
                'unggulan_checked' => $row->unggulan,
                'fasilitas' => $fasilitas,
                'foto' => $row->foto,
                'area_terdekat' => set_value('area_terdekat', $row->area_terdekat),
            );
            foreach ($fasilitas_selected as $fs) {
                $data['fasilitas_selected'][] = $fs->fasilitas_id;
            }
            $this->load->view('_template/header', $data);
            $this->load->view('kost/kost_form');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kost'));
        }
    }

    public function update_action()
    {
        $id = $this->input->post('id', TRUE);
        $row = $this->Kost_model->get_by_id($id);
        $data_foto_lama = $row->foto;

        if ($this->input->post()) {
            if ($this->input->post('fasilitas') == '') {
                $this->session->set_flashdata('message', 'Fasilitas belum dipilih');
                redirect(site_url('kost_detail'));
            } else {
                $data = array(
                    'nama_kost' => $this->input->post('nama_kost', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'jenis_kost' => $this->input->post('jenis_kost', TRUE),
                    'type_kost' => $this->input->post('type_kost', TRUE),
                    'harga' => $this->input->post('harga'),
                    'area_terdekat' => $this->input->post('area_terdekat', TRUE),
                    'unggulan' => $this->input->post('unggulan', TRUE),
                    'update_time' => time()
                );
                if($this->ion_auth->is_admin() || $this->ion_auth->in_group('operator')){
                    $pemilik = $this->input->post('pemilik', TRUE);
                } else {
                    $pemilik = $this->ion_auth->user()->row()->id;
                }
                if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('pemilik')) {
                    $data['operator'] = $this->input->post('operator', TRUE);
                } else {
                    $data['operator'] = $this->ion_auth->user()->row()->id;
                }
                $this->db->where('id', $id);
                $this->db->update('kost', $data);


                $fasilitas = $this->input->post('fasilitas');
                $this->db->where('kost_id', $id);
                $this->db->delete('fasilitas_kost');


                foreach ($fasilitas as $f) {
                    $this->db->insert('fasilitas_kost', array('kost_id' => $id, 'fasilitas_id' => $f));
                }

                $this->db->where('kost_id', $id);
                $this->db->delete('kost_pemilik');

                $this->db->insert('kost_pemilik', array('kost_id' => $id, 'pemilik_id' => $pemilik));

                foreach ($_FILES['foto_kost']['name'] as $f) {
                    if ($f != '') {
                        $foto_lama = explode(',', $data_foto_lama);
                        foreach ($foto_lama as $fl) {
                            unlink(realpath(APPPATH . '../assets/img/foto_kost/' . $fl));
                            $this->db->where('kost_id', $this->input->post('id'));
                            $this->db->delete('kost_foto');
                        }
                        $gambars = $this->Upload_model->mupload_files(realpath(APPPATH . '../assets/img/foto_kost'), '', $_FILES['foto_kost']);
                        foreach ($gambars as $gambar) {
                            $this->db->insert('kost_foto', array('foto' => $gambar, 'kost_id' => $id));
                        }
                    }
                }
                $this->session->set_flashdata('message', 'Update Record Success');
                if ($this->ion_auth->is_admin()) {
                    redirect(site_url('kost/admin'));
                } else if ($this->ion_auth->in_group('pemilik')) {
                    redirect(site_url('kost/pemilik'));
                } else if ($this->ion_auth->in_group('operator')) {
                    redirect(site_url('kost/operator'));
                }
            }
        }
    }

    public function delete($id)
    {
        $row = $this->Kost_model->get_by_id($id);

        if ($row) {
            $this->Kost_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            if ($this->ion_auth->is_admin()) {
                redirect(site_url('kost/admin'));
            } else if ($this->ion_auth->in_group('pemilik')) {
                redirect(site_url('kost/pemilik'));
            } else if ($this->ion_auth->in_group('operator')) {
                redirect(site_url('kost/operator'));
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            if ($this->ion_auth->is_admin()) {
                redirect(site_url('kost/admin'));
            } else if ($this->ion_auth->in_group('pemilik')) {
                redirect(site_url('kost/pemilik'));
            } else if ($this->ion_auth->in_group('operator')) {
                redirect(site_url('kost/operator'));
            }
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_kost', 'nama kost', 'trim|required');
        $this->form_validation->set_rules('pemilik', 'pemilik', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('hp', 'hp', 'trim|required');
        $this->form_validation->set_rules('jenis_kost', 'jenis kost', 'trim|required');
        $this->form_validation->set_rules('type_kost', 'type kost', 'trim|required');
        $this->form_validation->set_rules('harga', 'harga', 'trim|required');
        $this->form_validation->set_rules('area_terdekat', 'area terdekat', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Kost.php */
/* Location: ./application/controllers/Kost.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-11-17 06:09:27 */
/* http://harviacode.com */