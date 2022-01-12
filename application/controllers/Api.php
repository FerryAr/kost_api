<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Api extends CI_Controller
{

    private $apiKey = "691ACB";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ion_auth_model');
        $this->load->library('ion_auth');
    }
    // public function get_all_kost()
    // {
    //     $arr = [];
    //     if ($this->input->post('apiKey') == $this->apiKey) {
    //         $query = $this->db->select('kost.id, kost.nama_kost, kost.pemilik, kost.alamat, jenis_kost.jenis, kost.area_terdekat, kost.foto_unggulan')
    //             ->from('kost')
    //             ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
    //             ->get()
    //             ->result();
    //         foreach ($query as $q) {
    //             $arr[] = [
    //                 'id_kost' => $q->id,
    //                 'nama_kost' => $q->nama_kost,
    //                 'pemilik' => $q->pemilik,
    //                 'alamat' => $q->alamat,
    //                 'no_hp' => $q->no_hp,
    //                 'jenis' => $q->jenis,
    //                 'area_terdekat' => $q->area_terdekat,
    //                 'foto_unggulan' => $q->foto_unggulan
    //             ];
    //         }
    //         header('Content-Type: application/json');
    //         echo json_encode(
    //             [
    //                 'status' => 'success',
    //                 'data' => $arr
    //             ]
    //         );
    //     }
    // }
    public function get_kost()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            if (empty($this->input->post('id'))) {
                $this->output->set_status_header(400);
            } else {
                $id = $this->input->post('id');
                $query = $this->db->select('kost.id, kost.nama_kost, operator.no_wa, operator.last_login, operator.last_logout, operator.avatar, pemilik.first_name as pemilik, kost.alamat, jenis_kost.id as jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(DISTINCT kost_fasilitas.fasilitas) AS fasilitas, GROUP_CONCAT(DISTINCT kost_foto.foto) AS foto, operator.first_name, kost.area_terdekat, kost_unggulan')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->join('kost_type', 'kost.type_kost = kost_type.id')
                    ->join('kost_foto', 'kost.id = kost_foto.kost_id')
                    ->join('fasilitas_kost', 'kost.id = fasilitas_kost.kost_id')
                    ->join('kost_fasilitas', 'fasilitas_kost.fasilitas_id = kost_fasilitas.id')
                    ->join('kost_pemilik', 'kost.id=kost_pemilik.kost_id')
                    ->join('users pemilik', 'kost_pemilik.pemilik_id=pemilik.id')
                    ->join('users operator', 'kost.operator=operator.id')
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
                            'operator_last_login' => $query->last_login,
                            'operator_last_logout' => $query->last_logout,
                            //'operator_login_status' => $query->login_status,
                            'operator_avatar' => $query->avatar,
                            'type' => $query->type,
                            'harga' => $query->harga,
                            'foto' => $foto,
                            'area_terdekat' => $query->area_terdekat,
                            'unggulan' => $query->kost_unggulan
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
            $query = $this->db->select('kost.id, kost.nama_kost, kost.alamat, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat, kost.unggulan')
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
                    'alamat' => $q->alamat,
                    'jenis_id' => $q->jenis_kost,
                    'jenis' => $q->jenis,
                    'type' => $q->type,
                    'harga' => $q->harga,
                    'area_terdekat' => $q->area_terdekat,
                    'unggulan' => $q->unggulan,
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

    public function get_kost_unggulan()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $query = $this->db->select('kost.id, kost.nama_kost, kost.alamat, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat, kost.unggulan')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->join('kost_type', 'kost.type_kost = kost_type.id')
                ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                ->where('kost.unggulan', 1)
                ->limit(10)
                ->group_by('kost.id')
                ->get()
                ->result();
            foreach ($query as $q) {
                $foto = explode(',', $q->foto);
                $arr[] = [
                    'id_kost' => $q->id,
                    'nama_kost' => $q->nama_kost,
                    'alamat' => $q->alamat,
                    'jenis_id' => $q->jenis_kost,
                    'jenis' => $q->jenis,
                    'type' => $q->type,
                    'harga' => $q->harga,
                    'area_terdekat' => $q->area_terdekat,
                    'unggulan' => $q->unggulan,
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
    public function get_kost_terbaru()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            $query = $this->db->select('kost.id, kost.nama_kost, kost.alamat, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat, kost.unggulan')
                ->from('kost')
                ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                ->join('kost_type', 'kost.type_kost = kost_type.id')
                ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                ->limit(10)
                ->where('kost.update_time > UNIX_TIMESTAMP(NOW() - INTERVAL 1 WEEK)')
                ->order_by('kost.update_time', 'DESC')
                ->group_by('kost.id')
                ->get()
                ->result();
            foreach ($query as $q) {
                $foto = explode(',', $q->foto);
                $arr[] = [
                    'id_kost' => $q->id,
                    'nama_kost' => $q->nama_kost,
                    'alamat' => $q->alamat,
                    'jenis_id' => $q->jenis_kost,
                    'jenis' => $q->jenis,
                    'type' => $q->type,
                    'harga' => $q->harga,
                    'area_terdekat' => $q->area_terdekat,
                    'unggulan' => $q->unggulan,
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

    public function get_kost_by_input()
    {
        $arr = [];
        if ($this->input->post('apiKey') == $this->apiKey) {
            if ($this->input->post('input') == '') {
                $query = $this->db->select('kost.id, kost.nama_kost, kost.alamat,  kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat, kost.unggulan')
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
                $query = $this->db->select('kost.id, kost.nama_kost, kost.alamat, kost.jenis_kost, jenis_kost.jenis, kost_type.type, kost.harga, GROUP_CONCAT(kost_foto.foto) AS foto, kost.area_terdekat, kost.unggulan')
                    ->from('kost')
                    ->join('jenis_kost', 'kost.jenis_kost = jenis_kost.id')
                    ->join('kost_type', 'kost.type_kost = kost_type.id')
                    ->join('kost_foto', 'kost_foto.kost_id=kost.id')
                    ->like('kost.nama_kost', $input)
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
                    'alamat' => $q->alamat,
                    'jenis_id' => $q->jenis_kost,
                    'jenis' => $q->jenis,
                    'type' => $q->type,
                    'harga' => $q->harga,
                    'area_terdekat' => $q->area_terdekat,
                    'unggulan' => $q->unggulan,
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

    public function register()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            if (empty($this->input->post('first_name')) || empty($this->input->post('last_name')) || empty($this->input->post('email')) || empty($this->input->post('password'))) {
                $this->output->set_status_header(400);
            } else {
                $config['upload_path']          = realpath(APPPATH . '../assets/img/avatars');
                $config['file_ext_tolower']     = TRUE;
                $config['allowed_types']        = 'gif|jpg|png';
                // $config['max_size']             = 500;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('avatar')) {
                    header('Content-Type: application/json');
                    echo json_encode(
                        [
                            'status' => 'error',
                            'message' => $this->upload->display_errors()
                        ]
                    );
                } else {
                    $file_name = $this->upload->data('file_name');
                }
                $additional_data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    //'alamat' => $this->input->post('alamat'),
                    'no_wa' => $this->input->post('no_wa'),
                    'avatar' => $file_name
                ];
                if ($this->ion_auth_model->identity_check($this->input->post('email'))) {
                    echo json_encode(
                        [
                            'status' => 'error',
                            'message' => 'Registrasi gagal, email sudah digunakan'
                        ]
                    );
                } else {
                    if ($this->ion_auth->register($this->input->post('email'), $this->input->post('password'), $this->input->post('email'), $additional_data, array(2))) {
                        header('Content-Type: application/json');
                        echo json_encode(
                            [
                                'status' => 'success',
                                'message' => 'Registrasi berhasil, silahkan Login'
                            ]
                        );
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(
                            [
                                'status' => 'error',
                                'message' => 'Registrasi gagal'
                            ]
                        );
                    }
                }
            }
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

                        $this->db->update('users', ['login_status' => 1, 'last_logout' => 0], ['id' => $user->id]);

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
    public function logout()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            if (empty($this->input->post('user_id'))) {
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'User ID tidak boleh kosong!',
                    ]
                );
            } else {
                $this->db->update('users', ['login_status' => 0, 'last_logout' => time()], ['id' => $this->input->post('user_id')]);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'message' => 'Logout Sukses',
                    ]
                );
            }
        } else {
            $this->output->set_status_header(403);
        }
    }

    public function add_cart()
    {
        if ($this->input->post('apiKey') == $this->apiKey) {
            if (empty($this->input->post('user_id')) || empty($this->input->post('kost_id'))) {
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'User ID / Kost ID tidak boleh kosong!',
                    ]
                );
            } else {
                $this->db->insert('cart', [
                    'user_id' => $this->input->post('user_id'),
                    'kost_id' => $this->input->post('kost_id'),
                    'created_at' => time(),
                ]);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'message' => 'Kost berhasil ditambahkan ke cart',
                    ]
                );
            }
        } else {
            $this->output->set_status_header(403);
        }
    }

    public function get_all_blog()
    {
        if ($this->input->post("apiKey") == $this->apiKey) {
            $arr = [];
            $query = $this->db->select('blog.id, blog.thumbnail, kategori_blog.nama_kategori, blog.judul, blog.isi, blog.dibuat_pada')
                ->from('blog')
                ->join('kategori_blog', 'kategori_blog.id = blog.kategori_id')
                ->order_by('blog.id', 'desc')
                ->get()
                ->result();
            foreach ($query as $q) {
                $arr[] = [
                    'id' => $q->id,
                    'thumbnail' => $q->thumbnail,
                    'kategori' => $q->nama_kategori,
                    'judul' => $q->judul,
                    'isi' => $q->isi,
                    'dibuat_pada' => $q->dibuat_pada,
                ];
            }
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'success',
                    'data' => $arr,
                ]
            );
        } else {
            $this->output->set_status_header(403);
        }
    }
}

/* End of file Api.php and path /application/controllers/Api.php */
