<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    //Constructor del Controlador
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        // $this->load->view('micrositio/main');
        if($this->session->isloggedin){
            redirect("panel");
        }
        $this->load->view('micrositio/micro');
    }
}
/* End of file Main.php */
/* Location: ./application/controllers/Main.php */