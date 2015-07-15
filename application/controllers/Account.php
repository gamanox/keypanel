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

                // Obtenemos la info del miembro para guardarlo en sesion
                $member_info = $this->member->find($member_access->id);                
                switch ($member_info->type) {
                    case 'SUPERADMIN':
                        // Es superadmin, lo mandamos a administracion
                        $response['redirect_url'] = base_url('administration');
                        break;
                    default:
                        // Es miembro, redirigimos a pantalla de su cuenta
                        $response['redirect_url'] = base_url('account');
                        break;
                }

                // checamos membresia y guardamos en sesion
                $member_valid = $this->member->is_membership_valid();
                if( $member_valid )
                    $member_info->membership_valid = TRUE;
                else 
                    $member_info->membership_valid = FALSE;

                // Armamos la sesion                
                $member_access->is_loggedin = TRUE;
                $this->session->set_userdata( $member_info );
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