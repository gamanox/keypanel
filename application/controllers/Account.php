<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Account extends CI_Controller {
    
    //Constructor del Controlador
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        // Editar mi cuenta
        
    }

    public function login(){
        // validacion para login
    }

    public function logout(){
        $this->session->destroy();
        redirect('Main');
    }
}
/* End of file Account.php */
/* Location: ./application/controllers/Account.php */