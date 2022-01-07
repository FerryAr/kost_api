<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        if (!$this->ion_auth->is_admin()) {
            redirect('/', 'refresh');
        }
    }
    public function index()
    {
        $kategori_blog = $this->db->get('kategori_blog')->result();
        $data['kategori_blog'] = $kategori_blog;
        $this->load->view('_template/header', $data);
        $this->load->view('kategori/kategori_list');
        $this->load->view('_template/footer');
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kategori/create_action'),
            'id' => set_value('id'),
            'nama_kategori' => set_value('nama_kategori'),
        );
        $this->load->view('_template/header', $data);
        $this->load->view('kategori/kategori_form');
        $this->load->view('_template/footer');
    }

    public function create_action()
    {
        if ($this->input->post()) {
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori'),
            );
            $this->db->insert('kategori_blog', $data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kategori'));
        }
    }

    public function update($id)
    {
        $row = $this->db->get_where('kategori_blog', array('id' => $id))->row();
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kategori/update_action'),
                'id' => set_value('id', $row->id),
                'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
            );
            $this->load->view('_template/header', $data);
            $this->load->view('kategori/kategori_form');
            $this->load->view('_template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori'));
        }
    }
    
    public function update_action()
    {
        if ($this->input->post()) {
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori'),
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('kategori_blog', $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kategori'));
        }
    }
    public function delete($id)
    {
        $row = $this->db->get_where('kategori_blog', array('id' => $id))->row();
        if ($row) {
            $this->db->where('id', $id);
            $this->db->delete('kategori_blog');
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kategori'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori'));
        }
    }
}

/* End of file Kategori.php and path \application\controllers\Kategori.php */
