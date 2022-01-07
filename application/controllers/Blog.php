<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
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
        $blog = $this->db->select('blog.id, kategori_blog.nama_kategori, blog.thumbnail, blog.judul, blog.dibuat_oleh, blog.dibuat_pada')
            ->from('blog')
            ->join('kategori_blog', 'kategori_blog.id = blog.kategori_id')
            ->order_by('blog.id', 'DESC')
            ->get()
            ->result();
        $data['blog'] = $blog;

        $this->load->view('_template/header', $data);
        $this->load->view('blog/blog_list');
        $this->load->view('_template/footer');
    }

    public function create()
    {
        $kategori = $this->db->get('kategori_blog')->result();
        $data = array(
            'kategori' => $kategori,
            'button' => 'Create',
            'action' => site_url('blog/create_action'),
            'id' => set_value('id'),
            'kategori_selected' => '',
            'judul' => set_value('judul'),
            'isi' => set_value('isi'),
            'thumbnail' => '',

        );
        $this->load->view('_template/header', $data);
        $this->load->view('blog/blog_form');
        $this->load->view('_template/footer');
    }

    public function create_action()
    {
        if ($this->input->post()) {
            $config['upload_path']          = realpath(FCPATH . 'assets/img/blog_thumb');
            $config['allowed_types']        = 'jpg|png';
            //$config['max_size']             = 1000;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_thumbnail')) {
                $this->session->set_flashdata('message', 'File gagal diupload. ' . $this->upload->display_errors());
                redirect('blog');
            } else {
                $file_data = $this->upload->data();
                $query_data = array(
                    'judul' => $this->input->post('judul'),
                    'thumbnail' => $file_data['file_name'],
                    'kategori_id' => $this->input->post('kategori'),
                    'isi' => $this->input->post('isi'),
                    'dibuat_pada' => date('Y-m-d H:i:s'),
                );
                if (!$this->db->insert('blog', $query_data)) {
                    unlink(realpath(FCPATH . 'assets/img/blog_thumb/' . $query_data['nama_file']));
                    $this->session->set_flashdata('message', 'Data gagal ditambahkan. ' . $this->db->error());
                    redirect('blog');
                } else {
                    $this->session->set_flashdata('message', 'Data berhasil ditambahkan');
                    redirect('blog');
                }
            }
        }
    }

    public function update($id)
    {
        $kategori = $this->db->select('*')->from('kategori_blog')->get()->result();
        $blog = $this->db->select('blog.id, blog.kategori_id, kategori_blog.nama_kategori, blog.thumbnail, blog.judul, blog.isi')
            ->from('blog')
            ->join('kategori_blog', 'kategori_blog.id=blog.kategori_id')
            ->where('blog.id', $id)
            ->get()->row();
        $data = array(
            'kategori' => $kategori,
            'button' => 'Update',
            'action' => site_url('blog/update_action'),
            'id' => set_value('id', $blog->id),
            'thumbnail' => $blog->thumbnail,
            'kategori_selected' => $blog->kategori_id,
            'judul' => set_value('judul', $blog->judul),
            'isi' => set_value('isi_postingan', $blog->isi),
        );
        $this->load->view('_template/header', $data);
        $this->load->view('blog/blog_form');
        $this->load->view('_template/footer');
    }

    public function update_action()
    {
        if ($this->input->post()) {
            if ($_FILES['file_thumbnail']['name'] == '') {
                $query_data = array(
                    'judul' => $this->input->post('judul'),
                    'kategori_id' => $this->input->post('kategori'),
                    'isi' => $this->input->post('isi'),
                );
                $this->db->where('id', $this->input->post('id'));
                if (!$this->db->update('blog', $query_data)) {
                    $this->session->set_flashdata('message', 'Data gagal diupdate. ' . $this->db->error());
                    redirect('blog');
                } else {
                    $this->session->set_flashdata('message', 'Data berhasil diupdate');
                    redirect('blog');
                }
            } else {
                $data_foto_lama = $this->db->select('thumbnail')->from('blog')->where('id', $this->input->post('id'))->get()->row();
                $config['upload_path']          = realpath(FCPATH . 'assets/img/blog_thumb');
                $config['allowed_types']        = 'jpg|png';
                //$config['max_size']             = 1000;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file_thumbnail')) {
                    $this->session->set_flashdata('message', 'File gagal diupload. ' . $this->upload->display_errors());
                    redirect('blog');
                } else {
                    unlink(realpath(FCPATH . 'assets/img/blog_thumb/' . $data_foto_lama->thumbnail));
                    $file_data = $this->upload->data();
                    $query_data = array(
                        'judul' => $this->input->post('judul'),
                        'thumbnail' => $file_data['file_name'],
                        'kategori_id' => $this->input->post('kategori'),
                        'isi' => $this->input->post('isi'),
                        'dibuat_pada' => date('Y-m-d H:i:s'),
                    );
                    $this->db->where('id', $this->input->post('id'));
                    if (!$this->db->update('blog', $query_data)) {
                        unlink(realpath(FCPATH . 'assets/img/blog_thumb/' . $query_data['nama_file']));
                        $this->session->set_flashdata('message', 'Data gagal diupdate. ' . $this->db->error());
                        redirect('blog');
                    } else {
                        $this->session->set_flashdata('message', 'Data berhasil diupdate');
                        redirect('blog');
                    }
                }
            }
        }
    }

    public function delete($id)
    {
        $data_foto_lama = $this->db->select('thumbnail')->from('blog')->where('id', $id)->get()->row();
        unlink(realpath(FCPATH . 'assets/img/blog_thumb/' . $data_foto_lama->thumbnail));
        $this->db->where('id', $id);
        if (!$this->db->delete('blog')) {
            $this->session->set_flashdata('message', 'Data gagal dihapus. ' . $this->db->error());
            redirect('blog');
        } else {
            $this->session->set_flashdata('message', 'Data berhasil dihapus');
            redirect('blog');
        }
    }

    function tinymce_upload()
    {
        $config['upload_path']  = realpath(FCPATH . 'assets/img/blog/');
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $this->output->set_header('HTTP/1.0 500 Server Error');
            exit;
        } else {
            $file = $this->upload->data();
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['location' => base_url('assets/img/blog/') . $file['file_name']]))
                ->_display();
            exit;
        }
    }
}

/* End of file Blog.php and path \application\controllers\Blog.php */
