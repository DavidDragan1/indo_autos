<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin_review extends Fm_model
{

    public $table = 'admin_review';

    function __construct()
    {
        parent::__construct();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }


}
