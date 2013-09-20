<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 function is_premium($id) {
    if(is_agree_premium($id)) {
        $data = get_premium_detail($id);
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

function get_premium_detail($id) {
    $ci =& get_instance();
    $ci->db->where('id_member',$id);
    $q = $ci->db->get('tb_premium');

    if($q->num_rows() > 0){
        return $q->row();
        //var_dump($q->row());
    } else {
        return false;
    }
}

function is_agree_premium($id) {
    $ci =& get_instance();
    $ci->db->where('id_member',$id);
    $q = $ci->db->get('tb_premium');
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