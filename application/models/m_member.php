<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_member extends CI_Model {

    public function is_user_validated($email) {

        $member_detail = $this->get_member_detail("",$email);
        $this->db->where('user_id',$member_detail->id);
        $q = $this->db->get('tmp_member');

        if($q->num_rows() > 0 ) {
            $r = $q->row();
            if($r->is_aktif == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function can_login() {
//        $email = "andika@sharklasers.com";
//        $password = "andika";
        $email = $this->input->post('email',true);
        $password = $this->input->post('password',true);
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $query = $this->db->get('tb_member');

        if ($query->num_rows() == 1 && $this->is_user_validated($email)) {
            $row = $query->row();
            $nama_lengkap = $row->nama_depan." ".$row->nama_belakang;
            $data = array(
                'user_id'   => $row->id,
                'email'     => $row->email,
                'nama'      => $nama_lengkap,
                'nama_toko' => $row->nama_toko,
                'is_login'      =>  true

            );
            $this->session->set_userdata($data);
            return true;
        } else {
            return false;
        }
    }

    private function is_valid_key($key) {
        $this->db->where('kode_aktivasi',$key);
        $q = $this->db->get('tmp_member');

        if($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function aktivasi_member($key) {

        if($this->is_valid_key($key)) {
            $this->db->where('kode_aktivasi',$key);
            $data = array(
                'is_aktif' => 1
            );
            if($this->db->update('tmp_member',$data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function get_member_detail($user_id="",$email = "") {
        if($email != "") {
            $this->db->where('email', $email);
        } else {
            $this->db->where('id', $user_id);
        }
        $q = $this->db->get('tb_member');
        if($q->num_rows() == 1) {
            $row = $q->row();
            return $row;
        } else {
            return false;
        }
    }

    private function get_tmpmember_detail($user_id) {
        $this->db->where('user_id', $user_id);
        $q = $this->db->get('tmp_member');
        if($q->num_rows() == 1) {
            $row = $q->row();
            return $row;
        } else {
            return false;
        }
    }

    public function simpan_member_baru() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $namadepan = $this->input->post('namadepan');
        $namabelakang = $this->input->post('namabelakang');
        $jkel = $this->input->post('jkel');
        $provinsi = $this->input->post('provinsi');
        $kota = $this->input->post('kota');
        $alamat = $this->input->post('alamat');
        $nohp = $this->input->post('nohp');
        $namatoko = $this->input->post('namatoko');

        if(empty($nohp)) {
            $nohp = 0;
        }
        $data = array(
            'email' => $email,
            'password' => md5($password),
            'nama_depan' => $namadepan,
            'nama_belakang' => $namabelakang,
            'jkel' => $jkel,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'alamat' => $alamat,
            'no_hp' => $nohp,
            'nama_toko' => $namatoko
        );

        if ($this->db->insert('tb_member', $data)) {
            $this->db->where('email', $email);
            $q = $this->db->get('tb_member');

            if($q->num_rows() == 1) {

                $row = $q->row();

                if($this->create_new_activation($row->id)) {

                    $tmpmember = $this->get_tmpmember_detail($row->id);

                    if($this->send_activation_email($row->id,$password,$tmpmember->kode_aktivasi)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //masukkan data aktivasi ke database activation_member
    private function create_new_activation($user_id) {
        if(!empty($user_id)) {
            //$activation_code = base64_encode(random_string('unique'));
            $kode_aktivasi = sha1(uniqid(mt_rand(), true));
            //simpan aktivasi baru
            $data = array(
                'user_id' => $user_id,
                'kode_aktivasi' => $kode_aktivasi,
                'is_aktif' => 0
            );

            if ($this->db->insert('tmp_member', $data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    //kirim email aktivasi ke member baru
    public function send_activation_email($user_id,$password,$activation_code) {
        $confirmation_link = "http://www.omahiklan.com/confirmation_id?key=".$activation_code;
        $member = $this->get_member_detail($user_id);

        $config = array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.googlemail.com',
            'smtp_port'     => 465,
            'smtp_user'     => 'spt.omahiklan@gmail.com',
            'smtp_pass'     => 'omahiklan8080',
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'priority'      => 1,
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            'useragent'     => 'omahiklan.com'
        );

        $this->load->library('email',$config);

        $template = "Dear ".$member->nama_depan." ".$member->nama_belakang.",<br><br>Your Registration".
            " with omahiklan.com has been successfully completed, but you need to confirm your registration".
            " first by clicking the below link. If you cannot access the confirmation page by clicking at this link,".
            " then kindly copy paste this link into your browser's address bar and press enter. After you will confirm your registration,".
            " You can login to omahiklan.com by using the following access information;<br><br>Email Address: ".$member->email."<br>".
            "Password: ".$password."<br><br><br>click below to confirm your registration:<br><br>".
            "<a href=".$confirmation_link.">".$confirmation_link."</a>";

        $this->email->from('support@admin.omahiklan.com','omahiklan.com');
        $this->email->to($member->email);
        $this->email->subject('omahiklan.com Registration Confirmation');
        $this->email->message($template);
        if($this->email->send()) {
            return true;
        } else {
            return false;
        }

    }

}

/* End of file m_member.php */
/* Location: ./application/models/m_member.php */