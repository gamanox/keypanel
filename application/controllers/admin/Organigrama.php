<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 */
require_once APPPATH.'controllers/admin/Base.php';
class Organigrama extends Base {

    /**
     * __construct
     * Carga los modelos a utilizar en las funciones
     *
     * @ignore
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @copyright KeyPanel - 2015
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Organization_model','organization');
//        $this->load->model('Usuario_model','entity');
    }

    /**
     * index
     *
     * Carga la vista html de organigramas
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    public function index(){
        $this->explore();
    }

    /**
     * explore
     *
     * Carga la vista html de organigramas
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function explore($id=null) {
        if (!$this->auth->is_auth($this->router->class, READ)) {
            redirect("errores/no_authorized");
        }

        if( is_null($id) ){
            //buscamos los organigramas
            $param['nodes']= $this->organization->find_parents();
        }else{
            //buscamos el organigrama enviado
            $param['parent']= $this->organization->find( $id );
            //si no existe page 404
            if(!isset($param['parent']->id)){
                show_404();
            }
            //buscamos los nodos hijos del nodo padre
            $param['nodes']= $this->organization->find_children($id);

        }

        $this->lang->load('panel');

        $param_header['title'] = lang('org_title');
        $this->load->view('includes/header', $param_header);

        $param_menu= array();
        if(isset($param['parent'])){
            $param_menu['back_btn']      = base_url("admin/organigrama/explore/".$param['parent']->id_parent);
        }

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['dynamic_view']= 'organization/list';
        $param['vars_to_load']= array("nodes",'parent');

        $this->load->view('panel/template', $param);
        $this->load->view('includes/footer');
    }

    function add() {
        if (!$this->auth->is_auth($this->router->class, CREATE)) {
            redirect("errores/no_authorized");
        }

        $this->lang->load('panel');
        $this->load->library("form_validation");

        $param_header['title'] = lang('org_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore");


        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $this->load->view('organization/new');
        $this->load->view('includes/footer');
    }

    /**
     * create
     *
     * Carga
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access access
     * @param type var varDesc
     * @return type var returnDesc
     */
    public function create(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $info_entity = $this->entity->find_me();
            $colonia_cve  = $info_entity->colonia_cve;

            $the_post                 = $this->input->post('post');
            $the_post['post_content'] = $this->input->post('post_content');
            $the_post['post_date']    = date('Y-m-d H:i:s');
            $the_post['cve_colonia']  = $colonia_cve;
            $the_post['cve_user']     = $this->session->cve;

            if( $this->session->type == NORMAL ){
                $the_post['post_status'] = 'draft';
            }

            $succedd = $this->post->save($the_post);
            if( $succedd ){
                $data['status'] = true;
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * delete
     *
     * Petición por ajax que elimina logicamente a una o varias entidades enviadas y sus descendientes
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return array $response
     */
    function delete() {
	$response["status"]=0;
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, DELETE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{

	    //variables post
	    $entities_ids=$this->input->post('entities');
	    $row_affected= $this->organization->delete($entities_ids);


	    if ($row_affected){
		$response["status"]=1;
		$response["msg"]=  lang('msg_operacion_exitosa'). " ".sprintf(lang('msg_registros_afectados'),$row_affected);
	    }else{
		$response["msg"]=  lang('msg_operacion_fallida');
	    }
	}
	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

}