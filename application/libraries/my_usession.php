<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Usession extends CI_Session {

    public $logged_in = FALSE;

    public function  __construct() {
        parent::__construct();
        $this->is_logged_in();
    }

    public function is_logged_in()
    {
        $logged = $this->userdata('iduser_zs_simpeg');
        $this->logged_in = ($logged) ? TRUE : FALSE;
    }
}
