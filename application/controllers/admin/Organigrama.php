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


    public function show($ID){
        if(!$this->permiso->is_auth('P-posts', R)){
            redirect("errores/no_authorized");
        }

        if ( $this->session->type == 'superadmin' ){
            redirect('dashboard');
        }

        $info_entity = $this->entity->find_me();
        $colonia_cve  = $info_entity->colonia_cve;
        $post         = $this->post->find( $ID );

        if( count($post) > 0 ){
            // Validamos si pertenece a la misma colonia
            if( $post->cve_colonia != $colonia_cve ){
                redirect('blog');
            }

            $param_header['the_title'] = lang('menu_foro');
            $this->load->view('includes/header', $param_header);

            $this->load->view('includes/menu_'. $this->session->type);
            $footer_scripts = array(
                    'datatables/jquery.dataTables.js','number/jquery.counterup.min.js','circle-progress/jquery.circliful.js',
                    'footable/js/footable.js?v=2-0-1','footable/js/footable.sort.js?v=2-0-1','footable/js/footable.filter.js?v=2-0-1',
                    'footable/js/footable.paginate.js?v=2-0-1','footable/js/footable.paginate.js?v=2-0-1'
                );

            $param['breadcrumb'] = array(
                    lang('menu_dashboard') => base_url(),
                    lang('menu_foro')      => base_url('blog'),
                );

            $param['post']     = $post;
            $param['comments'] = $this->comments->find_by_post_id( $ID );

            $this->load->view('blog/single', $param);

            $param_footer['scripts'] = $footer_scripts;
            $this->load->view('includes/footer', $param_footer);
        }
        else {
            redirect('dashboard');
        }
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
     * trash
     *
     * Elimina logicamente a una entidad enviada y sus descendientes
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @param type var varDesc
     * @return type var returnDesc
     */
    function delete() {
	$response["status"]=0;
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif(!$this->permiso->is_auth('P-sectores', D)){
	    $response['msg']= lang('error_sin_permisos');
	}else{

	    //variables post
	    $sectores=$this->input->get_post('sectores');
	    $row_affected= $this->sector->delete($sectores);


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

    /**
     * [publish]
     * @return json
     */
    public function publish(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $cve_post     = $this->input->post('cve_post');
            $info_post    = $this->post->find( $cve_post );
            $info_entity = $this->entity->find_me();

            if( count($info_post) > 0 and $info_post->cve_colonia == $info_entity->colonia_cve ){
                $update_post = array('ID' => $cve_post, 'post_status' => 'publish');
                $succedd = $this->post->update( $update_post );
                if( $succedd ){
                    $data['status'] = true;
                }
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }

    /**
     * [comment]
     * @return void
     */
    public function comment(){
        if(!$this->input->is_ajax_request()){
            show_404();
        }
        else {
            $data = array('status' => false);

            $the_post = $this->input->post('post');

            $info_post    = $this->post->find( $the_post['ID'] );
            $info_entity = $this->entity->find_me();

            if( count($info_post) > 0 and $info_post->cve_colonia == $info_entity->colonia_cve ){
                $comment = array(
                        'id_post'   => $the_post['ID'],
                        'cve_user'  => $this->session->cve,
                        'content'   => $this->input->post('post_content'),
                        'approved'  => 1,
                        'create_at' => date('Y-m-d H:i:s')
                    );

                $succedd = $this->comments->save($comment);
                if( $succedd ){
                    $data['status'] = true;

                    $post_update = array(
                            'ID'            => $info_post->ID,
                            'comment_count' => $info_post->comment_count + 1
                        );

                    $this->post->update($post_update);
                }
            }

            //Regresamos el status del evento
            $json = json_encode($data);
            echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
        }
    }
}