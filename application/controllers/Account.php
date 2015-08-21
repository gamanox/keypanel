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
        $this->load->model('Member_model','member');
        $this->load->model('Profile_model','profile');
        $this->load->model("Token_model","token");
        $this->load->language('member');

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
                $this->lang->load('member');

            $param_header['title'] = lang('my-account-title');
            $this->load->view('includes/header', $param_header);

            $this->load->view('includes/menu-'. strtolower($this->session->type));

            // $this->load->view('users/'. strtolower($this->session->type) .'/my_account');
            $member= $this->member->find_me();
            $member->address= $member->addresses->row();
            $param_view['user_info']    = $member;
            $param_view['dynamic_view'] = 'users/'. strtolower($this->session->type) .'/my_account';
            $param_view['vars_to_load'] = array('user_info');

            $this->load->view('panel/template', $param_view);

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
                        $response['redirect_url'] = base_url('admin/member');
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

    /**
     * save
     *
     * Guarda cambios de la cuenta
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function save() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else{
            $member_exists= $this->member->find_me();

            if(!isset($member_exists->id)){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
//            dd($this->input->post());
                $member= $this->input->post('member');
                $address= $this->input->post('address');
                $contact= $this->input->post('contact');

                $current_password= $this->input->post('current_password');
                $new_password= $this->input->post('new_password');

                // Validamos el signature
                $validation_signature = md5('KeyPanel#'. $member_exists->id);
                $signature            = $this->input->post('signature');

                $success=0;

                if( $signature != $validation_signature ){
                    $response["msg"]= lang('msg_operacion_fallida');
                }else{
                    $member['id']= $member_exists->id;


                    if( (isset($new_password) and $new_password!="") and md5($current_password) != $member_exists->password ){
                        $response["msg"]= lang('current-password-empty');
                    }else{

                        if(isset($new_password) and $new_password!=""){
                            $member['password']= md5($new_password);
                        }

//                      dd($member_exists->addresses->row());

                        //actualizamos el miembro
                        $success+= $this->member->update($member);
                        //actualizamos direccion
                        $address_exists= $member_exists->addresses->row();
                        $address['id']= $address_exists->id;

//                        dd($address);
                        $success+= $this->address->update($address);
                        //actualizamos contacto
                        $contact["id"]= $member_exists->id_contact;
                        //$success+= $this->contact->update($contact);

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
        }
	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

    /**
     * upload_profile
     *
     * Sube una imagen al server
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access access
     * @return void imprime un json
     */
    public function upload_profile() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            if($_FILES){
                /* Subimos el archivo */
                $config['upload_path'] = './assets/images/profiles';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name']= time();

                $this->load->library('upload', $config);
                $id_entity= $this->input->post('id_entity');

                if(!$this->upload->do_upload('file')){
                    //$this->lang->load('upload');
                    $response['msg']= $this->upload->display_errors('<p>','</p>');
                }else{
                    if($id_entity){
                        $this->member->update(array("id"=>$id_entity,"avatar"=>$config['file_name'].$this->upload->file_ext));
                    }
                    $response['status']=true;
                    $response['msg']=lang('msg_operacion_exitosa');
                    $response['file_name']=$config['file_name'].$this->upload->file_ext;
                }
            }

//            print_r_pre_d($_FILES);
	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    /**
     * remove_profile
     *
     * Elimina una imagen del server
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access access
     * @return void imprime un json
     */
    public function remove_profile() {
        $response = array( 'status' => false, 'msg'=>lang('msg_operacion_fallida'));
	if(!$this->input->is_ajax_request()){
	    show_404();
	}else {
            $file= $this->input->post('file');
            $id_entity= $this->input->post('id_entity');
            $path_to_file= './assets/images/profiles/'.$file;
            if(file_exists($path_to_file)){
                if(unlink($path_to_file)){

                    if($id_entity){
                        $this->member->update(array("id"=>$id_entity,"avatar"=>null));
                    }

                    $response['status']=true;
                    $response['file_name']= $file;
                    $response['msg']= lang('msg_operacion_exitosa');
                }
            }

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    /**
     * activation
     *
     * Activa una cuenta. Actualiza el <b>estatus_row a ENABLED</b> de un miembro.
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @param String $token_id Codigo de activacion de cuenta
     * @return void
     */
    function activation($token_id) {
        $token= $this->token->find($token_id);

        //si no existe 404
        if(!isset($token->id)){
            show_404();
        }

        //actualizamos el token a USED
        $token_update= array(
            "id"=> $token->id,
            "status_row"=> USED
        );

        $success= $this->token->update($token_update);

        //si paso
        if($success){
            //actualizamos al miembro a ENABLED
            $member_upadate= array(
                "id"=> $token->entity->id,
                "status_row"=> ENABLED
            );

            $this->member->update($member_upadate);

            $member_data= array(
                "username"=> $token->entity->username,
                'password'=> $token->entity->password
            );

            $member_access  = $this->member->validate_credentials($member_data);

            if( isset($member_access) and $member_access['status'] ){
                $member_session_data = $member_access['user_data'];

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
                redirect("panel");
            }

        }

        show_404();
    }
}
/* End of file Account.php */
/* Location: ./application/controllers/Account.php */