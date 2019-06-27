<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_login extends Parent_Model { 
 
  
  var $nama_tabel = 'm_user';
  var $daftar_field = array('id', 'username', 'password', 'user_insert', 'date_insert', 'user_update', 'date_update');
  
  var $primary_key = 'id';

	  
	public function __construct(){
        parent::__construct();
        $this->load->database();
	}
 
	public function autentikasi($username,$password){
        $sql = $this->db->get_where($this->nama_tabel,array('username'=>$username,'password'=>$password));
		return $sql;
	}
 
 
}
