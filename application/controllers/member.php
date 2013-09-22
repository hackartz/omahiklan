<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
    protected $img_iklan_path;
    protected $img_produk_path;

    function __construct () {

        parent::__construct();

        $this->img_iklan_path = realpath(APPPATH . '../img_iklan');
        $this->img_produk_path = realpath(APPPATH . '../img_produk');
        if ($this->session->userdata('is_login') != true){
            redirect(base_url()."member/login");
        }
    }

    public function tes() {
        //echo  realpath(APPPATH);
        //print_r($_POST);
        //print_r($_FILES);
        $ids = array(33, 34, 45);
        print_r($ids);
        echo $this->session->userdata('user_id');
    }

    public function load_pesan_by_ticket(){
        $sess_id = $this->session->userdata('user_id');
        $data_premi = $this->get_premium_detail($sess_id);
        $this->db->where('to',$data_premi->ticket);
        $q = $this->db->get('inbox_member');
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q;
            }
        }
    }

    public function pesan_dibaca() {
        $id = $this->input->post('id_pesan');
        $this->db->where('id',$id);
        $data = array(
            'status' => 'R'
        );
        if($this->db->update('inbox_member',$data)) {
            echo $this->count_pending_message();
        }
    }

    public function count_pending_message() {
        $sess_id = $this->session->userdata('user_id');
        $data_premi = $this->get_premium_detail($sess_id);
        $this->db->where('to',$data_premi->ticket);
        $this->db->where('status','P');
        $q = $this->db->get('inbox_member');
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q->num_rows();
            }
        }
    }

    public function kirim_pesan() {
        $ticket = $this->input->post('ticket');
        $isi  = $this->input->post('isi_pesan');
        $data = array(
            'from' => $ticket,
            'isi' => $isi
        );
        if($this->db->insert('inbox_admin',$data)) {
            echo "ok";
        }
    }


    public function view_pesan() {
        $sess_id = $this->session->userdata('user_id');
        $data['subscriber'] = $this->get_subscriber($sess_id);
        $data['data_premium'] = $this->get_premium_detail($sess_id);
        $data['data_pesan'] = $this->load_pesan_by_ticket();
        $this->load->view('member/v_pesan',$data);
    }

    public function get_member_data_lengkap($id) {
        //SELECT * FROM tb_member LEFT JOIN tb_provinsi ON tb_provinsi.`id`=tb_member.`provinsi`
        $this->db->select('tb_member.id,email,nama_depan,nama_belakang,jkel,tb_provinsi.nama_provinsi,kota,alamat,no_hp,nama_toko');
        $this->db->from('tb_member');
        $this->db->join('tb_provinsi','tb_provinsi.id=tb_member.provinsi','left');
        $this->db->where('tb_member.id',$id);
        $q = $this->db->get();
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q->row();
            }
        }
    }

    public function ubah_data() {
        $password = $this->input->post('password');
        $namadepan = $this->input->post('namadepan');
        $namabelakang = $this->input->post('namabelakang');
        $jkel = $this->input->post('jkel');
        $provinsi = $this->input->post('provinsi');
        $kota = $this->input->post('kota');
        $alamat = $this->input->post('alamat');
        $nohp = $this->input->post('nohp');
        $namatoko = $this->input->post('namatoko');

        $data = array(
            'nama_depan' => $namadepan,
            'nama_belakang' => $namabelakang,
            'jkel' => $jkel,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'alamat' => $alamat,
            'nama_toko' => $namatoko
        );

        if($password != 'false') {
            $data['password'] = md5($password);
        }

        if(!empty($nohp)) {
            $data['no_hp'] = $nohp;
        }

        $this->db->where('id',$this->session->userdata('user_id'));
        if($this->db->update('tb_member',$data)) {
            echo "ok";
        }
    }

    public function index() {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id)) {
            if($this->is_premium($sess_id)) {
                $data['count_pending_message'] = $this->count_pending_message();
                $data['data_premium'] = $this->get_premium_detail($sess_id);
            }
            $data['is_premium'] = $this->is_premium($sess_id);
            $data['data_member'] = $this->get_member_data_lengkap($sess_id);
            $data['provinsi'] = $this->show_provinsi();
        }
        //var_dump($data);
        $this->load->view('member/v_home',$data);
    }

    public function cetak_faktur() {
        $sess_id = $this->session->userdata('user_id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $this->load->library('fpdf');
        $data['data_member'] = $this->get_member_detail($sess_id);
        $data['data_premium'] = $this->get_premium_detail($sess_id);
        $this->load->view('member/v_cetak_faktur',$data);
    }

    public function gen_ticket() {

        //sleep(3);
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id)) {
            if($this->is_agree_premium($sess_id)) {

                $premium_data = $this->get_premium_detail($sess_id);
                $data['ticket'] = $premium_data->ticket;

            } else {

                $ticket = random_string('numeric',7);
                $ticket = $ticket;
                $data['ticket'] = $ticket;

            }

            $data['is_agree_premium'] = $this->is_agree_premium($sess_id);
        }
        $this->load->view('member/v_ticket',$data);
    }

    public function show_kategori() {
        return $this->db->get('tb_kategori');
    }

    public function show_provinsi() {
        return $this->db->get('tb_provinsi');
    }

    public function cek_kuota_pos($pos) {
        $this->db->where('posisi',$pos);
        $q = $this->db->get('iklan');
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q->num_rows();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function cek_all_kuota() {
        $max_kuota = 15;
        $kuota_kanan = $this->cek_kuota_pos('kanan');
        $kuota_kiri = $this->cek_kuota_pos('kiri');
        $kuota_slider = $this->cek_kuota_pos('slider');
        $tot_kuota = $kuota_kanan + $kuota_kiri + $kuota_slider;
        return $tot_kuota;

    }

    public function is_iklan_aktif($id) {

        $this->db->where('id',$id);
        $q = $this->db->get('iklan');
        if(!empty($q)) {
            if($q->num_rows() > 0) {
                $data = $q->row();
                if($data->aktif == 1) {
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

    public function pasang_iklan() {
        //sleep(3);
        $data['kuota_kanan'] = $this->cek_kuota_pos('kanan');
        $data['kuota_kiri'] = $this->cek_kuota_pos('kiri');
        $data['kuota_slider'] = $this->cek_kuota_pos('slider');
        $data['all_kuota'] = $this->cek_all_kuota();
        $data['is_aktif'] = $this->is_iklan_aktif($this->session->userdata('user_id'));
        $data['is_premium'] = $this->is_premium($this->session->userdata('user_id'));
        $data['kategori'] = $this->show_kategori();
        $this->load->view('member/v_pasang_iklan',$data);
    }

    public function get_all_produk($id) {
        $this->db->where('id_member',$id);
        $q = $this->db->get('produk');

        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q;
            } else {
                return false;
            }
        } else {
            return false;
        }


    }

    public function kelola_produk(){
        //sleep(3);
        $produk =$this->get_all_produk($this->session->userdata('user_id'));
        if($produk != false ) {
            $data['catalog_item'] = $produk;
            $this->load->view('member/v_kelola_produk',$data);
        } else {
            $this->load->view('member/v_kelola_produk');
        }
    }

    public function st_iklan() {
        //sleep(3);
        $this->load->view('member/v_st_iklan');
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'member/login');
    }


    public function simpan_premium() {
        $ticket = $this->input->post('ticket');
        $data = array (
          'id_member' => $this->session->userdata('user_id'),
          'ticket' => $ticket,
        );

        if($this->db->insert('tb_premium',$data)) {
            echo "true";
        } else {
            echo "false";
        }

    }

    /**
     * @param $id
     * @return bool
     */
    public function get_premium_detail($id) {
        $this->db->where('id_member',$id);
        $q = $this->db->get('tb_premium');

        if($q->num_rows() > 0){
            return $q->row();
            //var_dump($q->row());
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function is_premium($id) {
        if($this->is_agree_premium($id)) {
            $data = $this->get_premium_detail($id);
            //print_r($data);
            if(!empty($data)){
                if($data->disetujui != 0 ) {
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

    /**
     * @param $id
     * @return bool
     */
    public function is_agree_premium($id) {

        $this->db->where('id_member',$id);
        $q = $this->db->get('tb_premium');
        //var_dump($q);
        if(!empty($q)){
            if($q->num_rows() > 0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function upload_image($upload_path) {
        $konfigurasi = array(
            'allowed_types' =>'jpg|jpeg',
            'upload_path' => $upload_path,
            'overwrite' => false,
            'remove_spaces' => true,
            'encrypt_name' => true
        );

        $this->load->library('upload', $konfigurasi);
        $this->upload->do_upload('foto');
        $datafile = $this->upload->data();

        return $datafile;
        //$namafile = $datafile['file_name'];
        //$this->proses_image($datafile['full_path'],$upload_path);
    }

    public function sudah_pasang_iklan($user_id) {

        $this->db->where('id_member',$user_id);
        $q = $this->db->get('iklan');

        if(!empty($q)){
            if($q->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function sudah_pasang_iklan_free($user_id) {

        $this->db->where('id_member',$user_id);
        $q = $this->db->get('iklan_free');
        //var_dump($q);
        if(!empty($q)){
            if($q->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function simpan_iklan() {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id)) {
            $data_foto = $this->upload_image($this->img_iklan_path);
            $data = array(
                'id_member' => $this->session->userdata('user_id'),
                'nama_iklan' => $this->input->post('namaiklan'),
                'alamat_web' => $this->input->post('alamatweb'),
                'deskripsi' => $this->input->post('deskripsi'),
                'keyword' => $this->input->post('keywords'),
                'foto' => $data_foto['file_name'],
                'kategori' => $this->input->post('kategori')
            );
            if($this->is_premium($sess_id)) {
                //premium member
                $data['posisi'] = $this->input->post('posiklan');
            }

            if($this->sudah_pasang_iklan($sess_id)) {
                $data['aktif'] = 0;
                $this->db->where('id_member',$sess_id);
                if($this->db->update('iklan',$data)){
                    echo "updated";
                } else {
                    echo "errorupdate";
                }
            } else {
                if($this->db->insert('iklan',$data)){
                    echo "saved";
                } else {
                    echo "errorsave";
                }
            }

        }

    }

    public function simpan_produk() {
        $sess_id = $this->session->userdata('user_id');
        $data_foto = $this->upload_image($this->img_produk_path);
        $data = array(
          'id_member' => $sess_id,
          'nama_produk' => $this->input->post('namaproduk'),
          'harga' => $this->input->post('harga'),
          'foto' => $data_foto['file_name']
        );

        if($this->db->insert('produk',$data)) {
            echo "saved";
        } else {
            echo "errorsave";
        }
    }

    public function delete_produk() {
        $this->db->where('id',$this->input->post('id_produk'));
        $this->delete_image_file($this->img_produk_path,$this->input->post('foto_name'));
        if($this->db->delete('produk')) {
            echo "deleted";
        } else {
            echo "deleteerror";
        }

    }

    public function get_all_produk_by_id($id = array()) {
        //$id = array(26,27);
        $this->db->where_in('id',$id);
        $q = $this->db->get('produk');

        if(!empty($q)) {
            if($q->num_rows() > 0) {
                //print_r($q->result());
                return $q;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete_selected_product() {
        $data_id = $this->input->post('produk_id');
        $arr_id = explode(',',$data_id);
        //$arr_id = array(40,39);
        $produk = $this->get_all_produk_by_id($arr_id);
        $this->db->where_in('id',$arr_id);
        if($this->db->delete('produk')) {
//            $this->db->where_in('id',$arr_id);
//            $q = $this->db->get('produk');
            foreach($produk->result() as $prod) {
                $this->delete_image_file($this->img_produk_path,$prod->foto);
            }
            echo "deleted";
        } else {
            echo "deleteerror";
        }
    }

    private function delete_image_file($path,$image) {
        if(file_exists($path."/".$image)) {
            unlink($path."/".$image);
        }
    }

    public function get_iklan_detail($id) {
        $this->db->where('id_member',$id);
        $q = $this->db->get('iklan');

        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q->row();
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function get_subscriber($id) {
        $this->db->where('id_member',$id);
        $q = $this->db->get('subscriber');

        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_member_detail($id) {
        $this->db->where('id',$id);
        $q = $this->db->get('tb_member');

        if(!empty($q)) {
            if($q->num_rows() > 0) {
                return $q->row();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //kirim email
    public function send_produk_email() {
        $data_member = $this->get_member_detail($this->session->userdata('user_id'));
        $config = array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.googlemail.com',
            'smtp_port'     => 465,
            'smtp_user'     => 'iklan.omahiklan@gmail.com',
            'smtp_pass'     => 'omahiklan2828',
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'priority'      => 1,
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            'useragent'     => 'omahiklan.com'
        );

        $this->load->library('email',$config);

        $template = '';

        $data_id = $this->input->post('produk_id');
        $arr_id = explode(',',$data_id);

        //$arr_id = array(22,23);
        $this->db->where_in('id',$arr_id);
        $q = $this->db->get('produk');
        $tmp1 = "";
        $tmp2 = "";
        $tmp3 = "";
        $tmp4 = "";

        $premium_iklan_detail = $this->get_iklan_detail($this->session->userdata('user_id'));

        foreach($q->result() as $produk) {
            //td nama produk
            $tmp1 .= '<td style="background:#8DB907; font-weight:bold; padding:5px;" align="center">'.$produk->nama_produk.'</td>';
            $tmp2 .= '<td style="padding:10px;"><img width="120px" height="120px" src="http://omahiklan.com/img_produk/'.$produk->foto.'"></td>';
            $tmp3 .= '<td align="center" style="font-size:12px;"> Rp'.$produk->harga.'</td>';
            $tmp4 .= '<td align="center"><a href="'.$premium_iklan_detail->alamat_web.'">view detail</a></td>';
        }

        $template = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Omah iklan</title>
<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1">
<style type="text/css" media="screen">
table { background: #373737; color: #fff;}
img { border: 1px solid #ccc; }
a { color: #fff; text-decoration: none; }
</style>
</head>
<body>
<table cellpadding="1" cellspacing="5">
    <tr>
        <td align="center" colspan="3">'.$data_member->nama_toko.'</td>
    </tr>
    <tr>
        '.$tmp1.'
    </tr>
    <tr>
        '.$tmp2.'
    </tr>
    <tr>
        '.$tmp3.'
    </tr>
    <tr>
        '.$tmp4.'
    </tr>
  </table>
  ';
//<p>berhenti langganan</p>
//        </body>
//</html>
        $sbs = $this->get_subscriber($this->session->userdata('user_id'));
        $i=0;
        foreach ($sbs->result() as $sb) {
            $tmp_template[$i] = $template;
            $tmp_template[$i] .= "<p><a href='".base_url()."unscribe?id=".$sb->id."'>berhenti langganan</a></p>
</body>
</html>";
            $this->email->clear();
            $this->email->from('support@admin.omahiklan.com','omahiklan.com');
            //$this->email->to('hackartz.temp@gmail.com');
            $this->email->to($sb->email);
            $this->email->subject('omahiklan.com Promotion');
            $this->email->message($tmp_template[$i]);
            $this->email->send();
            $i++;
            sleep(5);
        }

        echo "send";


//        $this->email->from('support@admin.omahiklan.com','omahiklan.com');
//        //$this->email->to('hackartz.temp@gmail.com');
//        $this->email->to('aji03782@gmail.com');
//        $this->email->subject('omahiklan.com Promotion');
//        $this->email->message($template);
//        $this->email->send();
//        if($this->email->send()) {
//            return true;
//        } else {
//            return false;
//        }

        //echo $this->email->print_debugger();

    }
}
