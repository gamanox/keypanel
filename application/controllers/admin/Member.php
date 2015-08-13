<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 */
require_once APPPATH.'controllers/admin/Base.php';
class Member extends Base {

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
        redirect('admin/member/show_list');
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
    public function show_list(){
        if( !$this->auth->is_auth($this->router->class, READ) ){
            redirect('account');
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN));

        // Cargamos la lista de miembros
        $param['members']      = $this->member->find_all( MEMBER );
        $param['dynamic_view'] = 'users/member/list';
        $param['vars_to_load'] = array('members');

        $this->load->view('panel/template', $param);

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
    public function add(){
        if( !$this->auth->is_auth( $this->router->class, CREATE) ){
            redirect('account');
        }

        $this->load->library('form_validation');
        $param_view = array();
        $errors     = array();

        if( $_POST ){
            $member         = $this->input->post('member');
            $member['type'] = MEMBER;

            $validate_empty_fields = array('first_name', 'last_name');
            foreach ($validate_empty_fields as $field) {
                if( !$this->form_validation->required( trim($member[$field]) ) ){
                    $errors[] = lang($field .'-empty');
                }
            }


            // Validamos correo electronico
            $is_unique_email = $this->form_validation->is_unique( trim($member['email']), 'entities.email');
            $is_valid_email  = $this->form_validation->valid_email( trim($member['email']) );

            if( $is_unique_email and $is_valid_email ){
                $member['email'] = trim( $member['email'] );
            }
            else {
                // El correo ya existe, mandamos error
                $errors[] = ( !$is_valid_email ? lang('email-not-valid') : lang('email-not-unique'));
            }

            // Validamos el nombre de usuario
            $username = $member['username'];
            if( $username != '' )
                $username_unique = $this->form_validation->is_unique($username, 'entities.username');
            else
                $username_unique = false;

            if( $username_unique ){
                $member['username'] = $username;
            }
            else {
                // El nombre de usuario ya existe en nuestra base de datos
                $errors[] = ( $username != '' ? lang('username-not-unique') : lang('username-empty'));
            }

            // Verificamos que la clave y la confirmacion de la clave sean iguales
            $password              = $member['password'];
            $password_confirmation = $this->input->post('password_confirmation');
            if( isset($password) and $password != '' and $password == $password_confirmation ){
                $member['password'] = md5( $password );
            }
            else {
                if( $password == '' )
                    $errors[] = lang('password-empty');
                else
                    $errors[] = lang('password-confirmation-not-match');
            }

            if( count($errors) == 0 ){
                $success = $this->entity->save( $member );
                if( isset($success) and $success ){
                    redirect('administration/members');
                }
            }

            // echo '<pre>'. print_r($errors, true) .'</pre>';
            $param_view['errors'] = $errors;
        }

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN));
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
    public function edit( $id_member = NULL ){
        if( !$this->auth->is_auth( $this->router->class, UPDATE) ){
            redirect('account');
        }

        if( !isset($id_member) ){
            redirect('administration/members');
        }

        $param_header['title'] = lang('members_title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN));

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
    public function update(){
        if( !$this->auth->is_auth( $this->router->class, UPDATE) ){
            redirect('account');
        }

        if( $_POST ){
            // Validamos el signature
            $validation_signature = md5('KeyPanel#'. $this->input->post('id'));
            $signature            = $this->input->post('signature');

            if( $signature == $validation_signature ){
                $member_data       = $this->input->post('member');
                $member_data['id'] = $this->input->post('id');

                // Validar datos

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
    public function delete( $id_member = NULL ){
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