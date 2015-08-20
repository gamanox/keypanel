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
        $this->show_list();
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

        $param_header['title'] = lang('member_list');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN));

        // Cargamos la lista de miembros
        $param['members']      = $this->member->find_list();
        $this->load->view('users/member/list', $param);

        $this->load->view('includes/footer');
    }

    /**
     * add
     *
     * Carga la vista html para capturar y crear un miembro
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function add(){
        if( !$this->auth->is_auth( $this->router->class, CREATE) ){
            redirect("errores/no_authorized");
        }

        $this->load->library('form_validation');
        $param_view = array();
        $errors     = array();

        if( $_POST ){
            $member= $this->input->post('member');
            $contact= $this->input->post('contact');
            $address= $this->input->post('address');

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
                //guardamos contacto
                $id_contact= $this->contact->save($contact);
                $member['id_contact']= $id_contact;
                $member['breadcrumb']= $this->session->id;
                //guardamos miembro
                $id_member = $this->entity->save( $member );
                $address['id_entity']=$id_member;
                //guardamos direccion
                $this->address->save($address);

                if($id_member){
                    redirect('admin/member/show_list');
                }
            }

            // echo '<pre>'. print_r($errors, true) .'</pre>';
            $param_view['errors'] = $errors;
        }

        $param_header['title'] = lang('member_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/member");
        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);
        $this->load->view('users/member/new', $param_view);

        $this->load->view('includes/footer');
    }

    /**
     * edit
     *
     * Carga la vista html para editar un miembro
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function edit( $id_member = NULL ){
        if (!$this->auth->is_auth($this->router->class, UPDATE)) {
            redirect("errores/no_authorized");
        }

        $member= $this->member->find($id_member);

        if(!isset($member->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('member_edit');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/member");
        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['member']= $member;
        $this->load->view('users/member/edit', $param);
        $this->load->view('includes/footer');
    }

    /**
     * save
     *
     * Guarda cambios de un miembro
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function save() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, UPDATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
//            dd($this->input->post());
            $member= $this->input->post('member');
            $address= $this->input->post('address');

            $current_password= $this->input->post('current_password');
            $new_password= $this->input->post('new_password');

            // Validamos el signature
            $validation_signature = md5('KeyPanel#'. $this->input->post('id'));
            $signature            = $this->input->post('signature');

            $success=0;

            if( $signature != $validation_signature ){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
                $member['id']= $this->input->post('id');
                $member_exists= $this->member->find($member['id']);

                if( (isset($new_password) and $new_password!="") and md5($current_password) != $member_exists->password ){
                    $response["msg"]= lang('current-password-empty');
                }else{

                    if(isset($new_password) and $new_password!=""){
                        $member['password']= $new_password;
                    }

//                    dd($member);

                    //actualizamos el organigrama
                    $success+= $this->member->update($member);
                    //actualizamos direccion
                    $success+= $this->address->update($address);

                    if ($success){
                        $response["status"] = 1;
                        $response["msg"]    = lang('msg_operacion_exitosa');
                    }
                    else {
                        $response["msg"] = lang('msg_operacion_fallida');
                    }
                }

            }
        }

	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

    /**
     * delete
     *
     * Petición por ajax que elimina logicamente a una o varios miembros enviados
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return array $response
     */
    function delete() {
	$response["status"]=0;
        $response["msg"]=  lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, DELETE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{

	    //variables post
	    $member_id=$this->input->post('member_id');

            $member_exists= $this->member->find($member_id);

            if(!isset($member_exists->id)){
                $response["msg"]=  lang('msg_operacion_fallida');
            }else{
                $row_affected= $this->member->delete($member_id);

                if ($row_affected){
                    $response["status"]=1;
                    $response["msg"]=  lang('msg_operacion_exitosa'). " ".sprintf(lang('msg_registros_afectados'),$row_affected);
                }else{
                    $response["msg"]=  lang('msg_operacion_fallida');
                }
            }
	}
	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

    /**
     * update_membership_status
     *
     * actualiza el estatus de la membresia
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access access
     * @return void
     */
    function update_membership_status() {
        $response["status"] = 0;
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        elseif( !$this->auth->is_auth($this->router->class, UPDATE) ){
            $response['msg']= lang('error_sin_permisos');
        }else {
            //variables post
            $datos_post        = $this->input->post();
            $member['status_row'] = ($datos_post['status_row'] ? ENABLED : DISABLED);
            $member['id']     = $datos_post['id'];

            $member_exists = $this->member->find($member['id']);

            if(!isset($member_exists->id)){
                $response['msg']= lang('msg_operacion_fallida');
            }else {
                $succeed = $this->member->update($member);

                if ($succeed){
                    $response["status"] = 1;
                    $response["msg"]    = lang('msg_operacion_exitosa');
                }else {
                    $response["msg"] = lang('msg_operacion_fallida');
                }
            }
        }

        //cocinado!!
        $json = json_encode($response);
        echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

}
/* End of file Administration.php */
/* Location: ./application/controllers/Administration.php */