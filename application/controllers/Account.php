<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Account extends CI_Controller {
    
    /**
     * [__construct]
     * 
     * 
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model','member',TRUE);
        $this->load->model('Profile_model','profile',TRUE);
    }

    public function index(){
        // Editar mi cuenta
        if( $this->session->is_loggedin ){

        }
        else {
            redirect('main');
        }
    }

    /**
     * [login]
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * 
     * @return json
     */
    public function login(){
        if( !$this->input->is_ajax_request() ){
            show_404();            
        }
        else {
            $response = array('status' => false);

            // Obtenemos los datos desde el formulario de login via ajax y validamos credenciales
            $member_data   = $this->input->post('member');
            $member_access = $this->member->validate_credentials($member_data);

            if( isset($member_access) ){
                $response['status'] = true;

                // Armamos la sesion                
                $member_access->is_loggedin = TRUE;
                $this->session->set_userdata( $member_access );
            }

            //Regresamos el status del evento
            $json = json_encode($response);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * [logout description]
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     *
     * @return void
     */
    public function logout(){
        $this->session->destroy();
        redirect('main');        
    }
}
/* End of file Account.php */
/* Location: ./application/controllers/Account.php */