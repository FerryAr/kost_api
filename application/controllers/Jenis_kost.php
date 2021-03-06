<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_kost extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_kost_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('jenis_kost/jenis_kost_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Jenis_kost_model->json();
    }

    public function read($id) 
    {
        $row = $this->Jenis_kost_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'jenis' => $row->jenis,
	    );
            $this->load->view('jenis_kost/jenis_kost_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kost'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_kost/create_action'),
	    'id' => set_value('id'),
	    'jenis' => set_value('jenis'),
	);
        $this->load->view('jenis_kost/jenis_kost_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis' => $this->input->post('jenis',TRUE),
	    );

            $this->Jenis_kost_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_kost'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_kost_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_kost/update_action'),
		'id' => set_value('id', $row->id),
		'jenis' => set_value('jenis', $row->jenis),
	    );
            $this->load->view('jenis_kost/jenis_kost_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kost'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'jenis' => $this->input->post('jenis',TRUE),
	    );

            $this->Jenis_kost_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_kost'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_kost_model->get_by_id($id);

        if ($row) {
            $this->Jenis_kost_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_kost'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_kost'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis', 'jenis', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jenis_kost.php */
/* Location: ./application/controllers/Jenis_kost.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-11-17 06:09:34 */
/* http://harviacode.com */