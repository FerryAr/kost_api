<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Api extends CI_Controller
{

    private $apiKey = "691ACB";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ion_auth_model');
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
            if (empty($this->input->post('id'))) {
                $this->output->set_status_header(400);
            } else {
                $id = $this->input->post('id');
                $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, users.first_name, users.avatar,  users.no_wa, users.last_logout, users.login_status ,kost.area_terdekat')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->join('kost_type', 'kost.type_kost = kost_type.id')
                    ->join('kost_foto', 'kost.id = kost_foto.kost_id')
                    ->join('users', 'kost.operator=users.id')
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
                            'no_hp' => $query->no_wa,
                            'jenis_id' => $query->jenis_kost,
                            'jenis' => $query->jenis,
                            'operator' => $query->first_name,
                            'operator_last_logout' => $query->last_logout,
                            'operator_login_status' => $query->login_status,
                            'operator_avatar' => $query->avatar,
                            'type' => $query->type,
                            'harga' => $query->harga,
                            'foto' => $foto,
                            'area_terdekat' => $query->area_terdekat
                        ]
                    ]
                );
            }
        } else {
            $this->output->set_status_header(403);
        }
    }
    public function get_kost_by_jenis()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $jenis = $this->input->post('jenis');
            $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->join('kost_type', 'kost.type_kost = kost_type.id')
                ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                ->where('kost.jenis_kost', $jenis)
                ->group_by('kost.id')
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
                    'jenis_id' => $q->jenis_kost,
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
            $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, users.first_name, kost.area_terdekat')
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
    public function get_kost_by_input()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            if ($this->input->post('input') == '') {
                $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp,  kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->join('kost_type', 'kost.type_kost = kost_type.id')
                    ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                    ->group_by('kost.id')
                    ->order_by('rand()')
                    ->limit(5)
                    ->get()
                    ->result();
            } else {
                $input = $this->input->post('input');
                $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, kost.hp AS no_hp,  kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->join('kost_type', 'kost.type_kost = kost_type.id')
                    ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                    ->like('kost.nama_kost', $input)
                    ->or_like('kost.pemilik', $input)
                    ->or_like('kost.alamat', $input)
                    ->group_by('kost.id')
                    ->get()
                    ->result();
            }
            foreach ($query as $q) {
                $foto = explode(',', $q->foto);
                $arr[] = [
                    'id_kost' => $q->id,
                    'nama_kost' => $q->nama_kost,
                    'pemilik' => $q->pemilik,
                    'alamat' => $q->alamat,
                    'no_hp' => $q->no_hp,
                    'jenis_id' => $q->jenis_kost,
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
    public function get_fasilitas()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            if ($this->input->post('id_kost') == '') {
                $this->output->set_status_header(400);
            } else {
                $query = $this->db->select('GROUP_CONCAT(kost_fasilitas.fasilitas) as fasilitas, GROUP_CONCAT(kost_fasilitas.icon) AS icon')
                    ->from('kost_fasilitas')
                    ->join('fasilitas_kost', 'kost_fasilitas.id = fasilitas_kost.fasilitas_id')
                    ->join('kost', 'kost.id = fasilitas_kost.kost_id')
                    ->where('kost.id', $this->input->post('id_kost'))
                    ->get()
                    ->row();
                header('Content-Type: application/json');
                $fasilitas = explode(',', $query->fasilitas);
                echo json_encode(
                    [
                        'status' => 'success',
                        'data' => array(
                            'fasilitas' => $fasilitas,
                            'icon' => explode(',', $query->icon)
                        )
                    ]
                );
            }
        } else {
            $this->output->set_status_header(403);
        }
    }

    public function get_slider()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            $query = $this->db->select('GROUP_CONCAT(carousel_iklan.foto_iklan) AS foto_iklan')
                ->from('carousel_iklan')
                ->order_by('level', 'asc')
                ->get()
                ->row();
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => array(
                        'foto_iklan' => explode(',', $query->foto_iklan)
                    )
                ]
            );
        } else {
            $this->output->set_status_header(403);
        }
    }

    public function login()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            if (empty($this->input->post('email')) || empty($this->input->post('password'))) {
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'Email / Password tidak boleh kosong!',
                        'data' => [],
                    ]
                );
            } else {
                $query = $this->db->select('email, first_name, no_wa, avatar, id, password, active, last_login')
                    ->where('email', $this->input->post('email'))
                    ->limit(1)
                    ->order_by('id', 'desc')
                    ->get('users');
                if ($query->num_rows() === 1) {
                    $user = $query->row();
                    if ($this->ion_auth_model->verify_password($this->input->post('password'), $user->password, $this->input->post('email'))) {
                        if ($user->active == 0) {
                            header('Content-Type: application/json');
                            echo json_encode(
                                [
                                    'status' => 'error',
                                    'message' => 'Akun tidak aktif',
                                    'data' => [],
                                ]
                            );
                        }
                        $this->ion_auth_model->update_last_login($user->id);
                        $this->ion_auth_model->clear_login_attempts($this->input->post('email'));
                        $this->ion_auth_model->clear_forgotten_password_code($this->input->post('email'));

                        header('Content-Type: application/json');
                        echo json_encode(
                            [
                                'status' => 'success',
                                'message' => 'Login Sukses',
                                'data' => [
                                    'user_id' => $user->id,
                                    'user_email' => $user->email,
                                    'user_first_name' => $user->first_name,
                                    'user_no_wa' => $user->no_wa,
                                    'user_avatar' => $user->avatar,
                                ],
                            ]
                        );
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(
                            [
                                'status' => 'error',
                                'message' => 'Password yang anda masukkan salah',
                                'data' => [],
                            ]
                        );
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(
                        [
                            'status' => 'error',
                            'message' => 'Email tidak terdaftar',
                            // 'data' => [],
                        ]
                    );
                }
            }
        } else {
            $this->output->set_status_header(403);
        }
    }
    
}

/* End of file Api.php and path /application/controllers/Api.php */
