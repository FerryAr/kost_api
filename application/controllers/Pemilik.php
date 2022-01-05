<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemilik extends CI_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
    }
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            show_error('You must be an administrator to view this page.');
        } else {
            $this->data['title'] = $this->lang->line('index_heading');

            // set the flash data error message if there is one
            //$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            //$this->data['user'] = $this->ion_auth->users()->result();

            $this->data['users'] = $this->db->select('users.id, users.first_name, users.last_name, users.email, users.no_wa, users.alamat, users.avatar')
                ->from('users')
                ->join('users_groups', 'users.id = users_groups.user_id')
                //->join('groups', 'users_groups.group_id = groups.id')
                ->where('users_groups.group_id', 3)
                ->get()
                ->result();

            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            // echo '<pre>';
            // print_r($this->data['users']);
            // echo '</pre>';
            $this->load->view('_template/header', $this->data);
            $this->load->view('admin/daftar_pemilik');
            $this->load->view('_template/footer');
        }
    }
}
/* End of file Pemilik.php and path \application\controllers\Pemilik.php */
