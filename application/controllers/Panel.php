<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Panel extends CI_Controller {
    
    //Constructor del Controlador
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->load->view('includes/header');
        $this->load->view('includes/menu-superadmin');
        $this->load->view('users/superadmin/dashboard');
        $this->load->view('includes/footer');
    }
}
/* End of file Panel.php */
/* Location: ./application/controllers/Panel.php */