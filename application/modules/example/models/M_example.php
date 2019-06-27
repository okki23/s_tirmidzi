<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_example extends Parent_Model { 

  var $nama_tabel = 'm_struktur';
  var $daftar_field = array('id','kode_menu','nama_menu','link','kode_parent');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
 
  /* function getMenu($parent,$hasil){*/ 
  function getMenu($parent,$hasil){
        // echo "<pre>";
        $sql = $this->db->where('kode_parent',$parent)->get($this->nama_tabel);

        if(($sql->num_rows())>0)
        {
            $hasil .= "<ul>";
        }
        foreach($sql->result() as $h)
        {
            $hasil .= "<li> <a href='javascript::void(0);'>".$h->nama_menu." </a>";
            $hasil = $this->getMenu($h->kode_menu,$hasil);
            $hasil .= "</li>";
        }
        if(($sql->num_rows())>0)
        {
            $hasil .= "</ul>";
        }
        return $hasil;

        // var_dump($sql);
        // echo "</pre>";
        // exit();

        // $w = $this->db->query("SELECT * from tbl_menu where id_parent='".$parent."'");
        // if(($sql->num_rows())>0)
        // {
        //     $hasil .= "<ul>";
        // }
        // foreach($w->result() as $h)
        // {
        //     $hasil .= "<li><span>".$h->menu."</span>";
        //     $hasil = $this->getMenu($h->id_menu,$hasil);
        //     $hasil .= "</li>";
        // }
        // if(($w->num_rows)>0)
        // {
        //     $hasil .= "</ul>";
        // }
        // return $hasil;
    } 
  
	 
 
}
