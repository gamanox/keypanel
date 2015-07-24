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
     * index
     *
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
     * members
     *
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
        $param_view['members'] = $this->member->find_all( MEMBER );
        $this->load->view('users/member/list', $param_view);

        $this->load->view('includes/footer');
    }

    /**
     * add_member
     *
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