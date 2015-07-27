<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 */
class Administration extends CI_Controller {

    /**
     * $charset_pass
     * Charset para generar passwords
     *
     * @var string
     */
    public $charset_pass = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789@#$%';

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
     * randString
     *
     * @access private
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return string
     */
    private function randString($length = 8, $charset = 'ABCDEFGHJKMNPQRSTUVWXYZ123456789'){
        $str = '';
        $count = strlen($charset);
        while($length--){
            $str .= $charset[mt_rand(0, $count-1)];
        }

        return $str;
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

        $param_view = array();

        if( $_POST ){
            $this->load->library('form_validation');

            $member         = $this->input->post('member');
            $member['type'] = MEMBER;

            // Validamos correo electronico
            $is_unique_email = $this->form_validation->is_unique( trim($member['email']), 'entities.email');
            $is_valid_email  = $this->form_validation->valid_email( trim($member['email']) );

            if( $is_unique_email and $is_valid_email ){
                $member['email'] = trim( $member['email'] );

                // Generamos un usuario y contraseña
                $username = $this->randString();
                $username_exists = $this->form_validation->is_unique($username, 'entities.username');

                while (!$username_exists) {
                    //Mientras el usuario ya exista en la base de datos
                    $username = $this->randString();
                    $username_exists = $this->form_validation->is_unique($username, 'entities.username');
                }

                $member['username'] = $username;
                $member['password'] = md5( $this->randString(8, $this->charset_pass) );

                $success = $this->entity->save( $member );
                if( isset($success) and $success ){
                    redirect('administration/members');
                }
            }
            else {
                // El correo ya existe, mandamos error
                $param_view['errors'] = ( !$is_valid_email ? lang('email-not-valid') : lang('email-not-unique'));
            }
        }

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-'. strtolower(SUPERADMIN));

        $this->load->view('users/member/new', $param_view);

        $this->load->view('includes/footer');
    }

    /**
     * edit_member
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function edit_member( $id_member = NULL ){
        if( !$this->auth->is_auth('Auth-Members', CREATE) ){
            redirect('account');
        }

        if( !isset($id_member) ){
            redirect('administration/members');
        }

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-'. strtolower(SUPERADMIN));

        $param_view['member'] = $this->entity->find( $id_member );
        $this->load->view('users/member/edit', $param_view);

        $this->load->view('includes/footer');
    }

    /**
     * update_member
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function update_member(){
        if( !$this->auth->is_auth('Auth-Members', CREATE) ){
            redirect('account');
        }

        if( $_POST ){
            // Validamos el signature
            $validation_signature = md5('KeyPanel#'. $this->input->post('id'));
            $signature            = $this->input->post('signature');

            if( $signature == $validation_signature ){
                $member_data       = $this->input->post('member');
                $member_data['id'] = $this->input->post('id');

                $success = $this->entity->update( $member_data );
                if( $success ){
                    redirect('administration/members');
                }
            }
            else {
                // Signature y validacion no coinciden
                $_SESSION['errors'] = lang('signature-validation');
                $this->session->mark_as_temp('errors', 5);

                redirect('administration/members');
            }
        }
        else {
            redirect('administration/members');
        }
    }

    /**
     * delete_member
     *
     * Función que se usa para eliminar miembros del sistema [borrado logico]
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @param int $id_member ID del miembro a borrar
     *
     * @return void
     */
    public function delete_member( $id_member = NULL ){
        if( !$this->auth->is_auth('Auth-Members', CREATE) ){
            redirect('account');
        }

        if( !isset($id_member) ){
            redirect('administration/members');
        }

        $success = $this->entity->delete( $id_member );
        if( $success > 0){
            redirect('administration/members');
        }
    }
}
/* End of file Administration.php */
/* Location: ./application/controllers/Administration.php */