<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
class Account extends CI_Controller {

    /**
     * [__construct]
     * @ignore
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model','member',TRUE);
        $this->load->model('Profile_model','profile',TRUE);
    }

    /**
     * index
     *
     * Funcion que carga tu informacion de la cuenta
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
     *
     * @return void
     */
    public function index(){
        if( $this->session->isloggedin ){

            if( $this->session->type == SUPERADMIN )
                $this->lang->load('Administration');

            $param_header['title'] = lang('my-account-title');
            $this->load->view('includes/header', $param_header);

            $param_menu['show_secundary_nav'] = true;
            $this->load->view('includes/menu-'. strtolower($this->session->type));

            // $this->load->view('users/'. strtolower($this->session->type) .'/my_account');
            $param_view['path_view'] = 'users/'. strtolower($this->session->type) .'/my_account';
            $this->load->view('includes/template', $param_view);

            $this->load->view('includes/footer');
        }
        else {
            redirect('main');
        }
    }

    /**
     * login
     *
     * Funcion para validar credenciales y armar sesion de usuario
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
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
            $member_data             = $this->input->post('member');
            $member_data['password'] = md5($member_data['password']);

            $member_access  = $this->member->validate_credentials($member_data);
            if( isset($member_access) and $member_access['status'] ){
                $member_session_data = $member_access['user_data'];
                $response['status']  = true;

                switch ($member_session_data['type']) {
                    case 'SUPERADMIN':
                        // Es superadmin, lo mandamos a administracion
                        $response['redirect_url'] = base_url('administration');
                        break;
                    default:
                        // Es miembro, redirigimos a pantalla de su cuenta
                        $response['redirect_url'] = base_url('panel');
                        break;
                }

                // checamos membresia y guardamos en sesion
                $member_valid = $this->member->is_membership_valid();
                if( $member_valid )
                    $member_session_data['membership_valid'] = TRUE;
                else
                    $member_session_data['membership_valid'] = FALSE;

                // Armamos la sesion
                $member_session_data['isloggedin'] = TRUE;
                $this->session->set_userdata( $member_session_data );

                // Guardamos el ultimo login
                $this->member->update_access_log();
            }

            //Regresamos el status del evento
            $json = json_encode($response);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * logout
     *
     * Funcion para cerrar sesion del usuario
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
     *
     * @return void
     */
    public function logout(){
        session_destroy();
        redirect('main');
    }
}
/* End of file Account.php */
/* Location: ./application/controllers/Account.php */