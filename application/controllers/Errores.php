<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package  KeyPanel
 * @author Luis
 */
class Errores extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    //sesion expirada
    public function session_expired(){
        $this->load->view('errors/session_expired');
    }

    // vista no autorizada
    public function no_authorized(){
        $this->load->view('errors/no_authorized');
    }
}
