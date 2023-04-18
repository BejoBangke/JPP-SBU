<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_photo_produk extends CI_Model 
{
    public function all_photo()
    {
        $query = $this->db->query("SELECT * FROM tbl_photo_produk ORDER BY photo_id ASC");
        return $query->result_array();
    }
}