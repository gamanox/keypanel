<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
/**
 * @package keypanel
 * @version 1.0
 */
class Administration extends CI_Controller {

    /**
     * __construct
     * 
     * @ignore
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     * 
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Entity_model','entity',TRUE);
        $this->load->model('Member_model','member',TRUE);
        $this->load->model('Profile_model','profile',TRUE);
    }
    
    /**
     * [loadAdmin]
     * @return void
     */
    public function loadAdmin(){
        // Armamos sesion de admin, en lo que quedan las vistas del micrositio
        if( !$this->session->is_loggedin ){

            $member_data = array(
                    'username' => 'admin',
                    'password' => md5('admin')
                );

            $member_access = $this->member->validate_credentials($member_data);

            if( isset($member_access) and $member_access['status'] ){
                $member_session_data = $member_access['user_data'];

                // checamos membresia y guardamos en sesion
                $member_valid = $this->member->is_membership_valid();
                if( $member_valid )
                    $member_session_data['membership_valid'] = TRUE;
                else 
                    $member_session_data['membership_valid'] = FALSE;

                // Armamos la sesion
                $member_session_data['is_loggedin'] = TRUE;
                $this->session->set_userdata( $member_session_data );
            }
        }
        else {
            redirect('administration');
        }
    }

    /**
     * index
     * Dashboard para superadmin
     * 
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
     * 
     * @return void
     */
    public function index(){
        if( $this->session->type != SUPERADMIN ){
            redirect('account');
        }

        $param_header['title'] = lang('dashboard_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-'. strtolower(SUPERADMIN));

        $this->load->view('users/'. strtolower(SUPERADMIN) .'/dashboard');

        $this->load->view('includes/footer');
    }    

    /**
     * [members]
     * Devuelve el listado de miembros registrados en el sistema
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     * 
     * @return void
     */    
    public function members(){
        if( !$this->auth->is_auth('Auth-Members', READ) ){
            redirect('account');
        }
        
        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-'. strtolower(SUPERADMIN));

        // Cargamos la lista de miembros
        $param_view['members'] = array();
        $this->load->view('users/member/list');

        $this->load->view('includes/footer');
    }

    /**
     * [add_member]
     * Funcion para agregar miembros a la plataforma - Formulario
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     * 
     * @return void
     */
    public function add_member(){
        if( !$this->auth->is_auth('Auth-Members', CREATE) ){
            redirect('account');
        }

        if( $_POST ){
            $member             = $this->input->post('member');
            
            $member['username'] = 'johndoe';
            $member['password'] = md5('johndoe');
            
            $member['type']     = MEMBER;

            $success = $this->entity->save( $member );
            if( isset($success) and $success ){
                redirect('administration/members');
            }
        }

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-'. strtolower(SUPERADMIN));

        // Cargamos la lista de miembros
        $param_view['members'] = array();
        $this->load->view('users/member/new');

        $this->load->view('includes/footer');
    }
}
/* End of file Administration.php */
/* Location: ./application/controllers/Administration.php */