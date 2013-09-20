<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_member');
    }

    public function unscribe() {
        $id_mail = $this->input->get('id');
        $this->db->where('id',$id_mail);
        if($this->db->delete('subscriber')) {
            $data['sukses'] = true;
        }else {
            $data['sukses'] = false;
        }

        $this->load->view('v_unscribe',$data);

    }

    public function GfSQ0nG5L21ulGvujmmvEXEwZoiE0B69() {
        $this->load->helper('premium_helper');
        $this->db->where('sisa',0);
        $q = $this->db->get('tb_premium');
        if($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                if(is_premium($data->id_member)) {
                    $this->db->where('id',$data->id);
                    $this->db->delete('tb_premium');
                }
            }
            echo "data yang dihapus berjumlah ". $q->num_rows();
        } else {
            echo "tidak ada data yang dihapus";
        }
    }

    public function Z84w8ah1Q7gE017k0lKJjJGC32FGaa4K() {
        $this->db->query('UPDATE tb_premium SET sisa = TIMESTAMPDIFF(DAY,NOW(),DATE(tgl_berakhir)) where disetujui=1');
        echo "jumlah data yang terupdate ".$this->db->affected_rows();
    }

    public function view_caradaftar() {
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_caradaftar',$data);
    }

    public function view_caraupgrade() {
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_caraupgrade',$data);
    }

    public function view_tipjubel() {
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_tipjubel',$data);
    }

    public function view_cs() {
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_cs',$data);
    }

    public function view_terms() {
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_terms',$data);
    }

    public function get_all_premium_iklan() {
        //SELECT * FROM iklan_premium LEFT JOIN tb_premium ON tb_premium.`id_member`=iklan_premium.`id_member`
        //WHERE tb_premium.`disetujui` = 1
        $this->db->select('*');
        $this->db->from('iklan');
        $this->db->join('tb_premium','tb_premium.id_member=iklan.id_member','left');
        $this->db->where('tb_premium.disetujui',1);
        $q = $this->db->get();
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                //var_dump($q);
                return $q;
            }
        }
    }

    public function view_iklan_premium() {
        $kategori = $this->input->get('kategori_iklan',true);
        $lokasi = $this->input->get('lokasi_iklan',true);
        $data['provinsi'] = $this->get_provinsi();
        $data['kategori'] = $this->get_kategori();
        $data['iklan_premium'] = $this->get_all_premium_iklan();
        $this->load->view('v_iklanpremium',$data);
    }

    public function cari_kategori($nama_kategori) {

        $this->db->select('id_member,nama_iklan,foto,alamat_web,deskripsi');
        $this->db->from('iklan');
        $this->db->join('tb_member','tb_member.id=iklan.id_member');
        $this->db->join('tb_kategori','tb_kategori.id=iklan.kategori');
        $this->db->where('nama_kategori',$nama_kategori);
        $q = $this->db->get();

        if($q->num_rows() > 0) {
            //echo $q->num_rows();
            return $q;
        }

    }

    public function cari_iklan($keyword='',$kategori='',$lokasi='') {
        $this->db->select('id_member,nama_iklan,foto,alamat_web,deskripsi');
        $this->db->from('iklan');
        $this->db->join('tb_member','tb_member.id=iklan.id_member');
        $this->db->join('tb_provinsi','tb_provinsi.id=tb_member.provinsi');
        $this->db->join('tb_kategori','tb_kategori.id=iklan.kategori');

        if(!empty($lokasi) && $lokasi != 'semua') {
            $lokasi_clean = str_ireplace('%20',' ',$lokasi);
            $this->db->where('nama_provinsi',$lokasi_clean);
        }

        if(!empty($kategori) && $kategori != 'semua') {
            $this->db->where('nama_kategori',$kategori);
        }

        if(!empty($keyword)) {
            //split keyword
            $keyword_arr = explode("%20",$keyword);
            $i = 1;
            foreach($keyword_arr as $val) {
                if($i == 1) {
                    $this->db->like('keyword',$val,'both');
                } else {
                    $this->db->or_like('keyword',$val,'both');
                }
                $i++;
            }
        }

        $q = $this->db->get();

        if($q->num_rows() > 0) {
            //echo $q->num_rows();
            return $q;
        }
    }

    public function search_iklan() {
        $keyword = $this->input->get('keyword',true);
        $kategori = $this->input->get('kategori_iklan',true);
        $lokasi = $this->input->get('lokasi_iklan',true);

        //var_dump($this->cari_iklan($keyword,$kategori,$lokasi));
        $data['provinsi'] = $this->get_provinsi();
        $data['kategori'] = $this->get_kategori();
        $data['search_result'] = $this->cari_iklan($keyword,$kategori,$lokasi);
        $this->load->view('v_cariiklan',$data);
    }

    public function search_by_category() {
        $kunci = $this->input->get('s',true);
        $data['search_result'] = $this->cari_kategori($kunci);
        $data['kategori_pencarian'] = $kunci;
        $data['provinsi'] = $this->get_provinsi();
        $data['kategori'] = $this->get_kategori();
        $this->load->view('v_carikat',$data);
    }

    public function get_kategori() {
        $q = $this->db->get('tb_kategori');
        if($q->num_rows() > 0) {
            return $q;
        }
    }

    public function get_provinsi() {
        $q = $this->db->get('tb_provinsi');
        if($q->num_rows() > 0) {
            return $q;
        }
    }

    public function index()
    {
        $data['iklan_slider'] = $this->get_iklan_by_pos('slider');
        $data['iklan_kanan'] = $this->get_iklan_by_pos('kanan');
        $data['iklan_kiri'] = $this->get_iklan_by_pos('kiri');
        $data['iklan'] = $this->get_iklan_all();
        $data['kategori'] = $this->get_kategori();
        $data['provinsi'] = $this->get_provinsi();
        $this->load->view('v_home',$data);
    }

    public function confirm() {
        $key = $this->input->get('key',true);
        if($this->m_member->aktivasi_member($key)) {
            $data['is_confirmated'] = true;
        } else {
            $data['is_confirmated'] = false;
        }

        $this->load->view('v_confirm',$data);

    }

    public function is_valid_email() {
        $email = $this->input->post('email');
        $this->db->where('email',$email);
        $q = $this->db->get('tb_member');

        if($q->num_rows() > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function member_baru() {

        if($this->m_member->simpan_member_baru()) {
            echo "ok";
        }

    }

    public function go_member() {
        redirect(base_url().'dashboard_admin.html');
    }

    public function login_page() {
        if($this->session->userdata('is_login') != true) {
            $this->load->view('v_login');
        } else {
            redirect(base_url().'member');
        }
    }

    public function act_login() {

        if($this->m_member->can_login()) {
            echo "true";
        } else {
            redirect(base_url().'member/login');
        }
    }

    public function get_iklan_all() {
        $this->db->limit(10);
        $this->db->where('aktif',1);
        $this->db->where('posisi','kosong');
        $q = $this->db->get('iklan');
            if($q->num_rows() > 0) {
                return $q;
                //print_r($q->result());
            }
    }

    public function get_iklan_by_pos($posisi) {

        $this->db->select('iklan.id_member,iklan.foto,iklan.alamat_web,tb_premium.disetujui,deskripsi');
        $this->db->from('iklan');
        $this->db->join('tb_premium','tb_premium.id_member=iklan.id_member');
        $this->db->where('aktif',1);
        $this->db->where('posisi',$posisi);
        $q = $this->db->get();
        if($posisi == 'slider') {
            if($q->num_rows() > 0) {
                return $q;
            }
        } else {
            if($q->num_rows() > 0) {
                $data_arr = $q->result();
                $rand_keys = array_rand($data_arr,1);
                $data_iklan = $data_arr[$rand_keys];
                return $data_iklan;
                //echo $data_iklan->alamat_web;

            }
        }
    }

    public function cek_email_subscriber($email,$id) {
        $this->db->where('email',$email);
        $this->db->where('id_member',$id);
        $q =$this->db->get('subscriber');

        if($q->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function delete_subscriber($email,$id) {
        $this->db->where('email',$email);
        $this->db->where('id_member',$id);
        $this->db->delete('subscriber');
    }

    public function add_subscriber(){
        sleep(3);
        $id_member = $this->input->post('id_member');
        $email = $this->input->post('email');

        if($this->cek_email_subscriber($email,$id_member) == true) {
            $data = array(
                'id_member' => $id_member,
                'email' => $email
            );
            if($this->db->insert('subscriber',$data)) {
                echo "ok";
            }
            //$this->delete_subscriber($email,$id_member);
        } else {
            echo "ok";
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */