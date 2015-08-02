<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

    //Constructor del Controlador
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $param_header['title'] = 'keypanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $this->load->view('includes/template');
        // $this->load->view('panel/home');

        $this->load->view('includes/footer');
    }
}
/* End of file Panel.php */
/* Location: ./application/controllers/Panel.php */