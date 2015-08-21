<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 */
require_once APPPATH.'controllers/admin/Base.php';
class Category extends Base {

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
        $this->load->model('Category_model','category');
    }

    /**
     * index
     *
     * Carga la vista html de categorias
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
     * Carga la vista html de categorias
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function explore($id=null) {
        if (!$this->auth->is_auth($this->router->class, READ)) {
            redirect("errores/no_authorized");
        }

        if( is_null($id) ){
            //buscamos las categorias
            $param['nodes']= $this->category->find_parents();
            $param['title']= lang('cat_list');
        }else{
            //buscamos la categoria enviada
            $param['parent']= $this->category->find( $id );

            //si no existe page 404
            if(!isset($param['parent']->id)){
                show_404();
            }
            //buscamos los nodos hijos del nodo padre
            $param['nodes']= $this->category->find_children($id);

            $param['title']= $param['parent']->name;

        }

        $param_header['title'] = lang('org_title');
        $this->load->view('includes/header', $param_header);

        $param_menu= array();
        if(isset($param['parent'])){
            $param_menu['back_btn']      = base_url("admin/category/explore/".$param['parent']->id_parent);
        }

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $this->load->view('categories/list', $param);
        $this->load->view('includes/footer');
    }

    /**
     * add
     *
     * Carga el modal html para crear una categoría
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function add() {
        if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else {
	    $param['title'] = lang('cat_add');
	    $param['category']= $this->category->find($this->input->post('id_category'));
	    //cargamos la vista en variable para mostrarla en modal por ajax.
	    $form = $this->load->view("categories/new",$param,TRUE);
	    $response = $form;

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    /**
     * create
     *
     * Crea un categoria
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function create() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
            $this->load->library('form_validation');
            $category= $this->input->post('category');

            if(!is_array($category)){
                $response["msg"]= lang('msg_operacion_fallida');
            }elseif(!isset ($category['id_parent'])){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
                $parent= $this->category->find($category['id_parent']);

                if($category['id_parent']!=0 and !isset($parent->id)){
                    $response["msg"]= lang('msg_operacion_fallida');
                }else{
                    if(isset($parent->id)){
                        $category['breadcrumb']= (isset($parent->breadcrumb) ? $parent->breadcrumb."|".$parent->id : $parent->id);
                    }else{
                        $category['id_parent']=null;
                    }

                    $category['slug']= join('-',explode(" ", $category['name']));
                    $i=1;
                    while(!$this->form_validation->is_unique( trim($category['slug']), 'categories.slug')){
                        $category['slug']= join('-',explode(" ", $category['name']))."-".$i;
                        $i++;
                    }

                    $id_category= $this->category->save($category);

                    if ($id_category){
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
     * edit
     *
     * Carga la vista html para editar un categoria
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function edit() {
        if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, UPDATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else {
	    $param['title'] = lang('cat_edit');
	    $param['category']= $this->category->find($this->input->post('id_category'));
            $param['categories']= $this->category->find_all();
	    //cargamos la vista en variable para mostrarla en modal por ajax.
	    $form = $this->load->view("categories/edit",$param,TRUE);
	    $response = $form;

	    //Regresamos el form ...Cocinado!!
	    $json = json_encode($response);
	    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
	}
    }

    /**
     * save
     *
     * Actualiza un categoria
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
            $this->load->library('form_validation');
            $category= $this->input->post('category');

            if(!is_array($category)){
                $response["msg"]= lang('msg_operacion_fallida');
            }elseif(!isset ($category['id_parent'])){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
                $parent= $this->category->find($category['id_parent']);
                $category_exists= $this->category->find($category['id']);

                if($category['id_parent']!=0 and !isset($parent->id)){
                    $response["msg"]= lang('msg_operacion_fallida');
                }else{
                    if(isset($parent->id)){
                        $category['breadcrumb']= (isset($parent->breadcrumb) ? $parent->breadcrumb."|".$parent->id : $parent->id);
                    }else{
                        $category['id_parent']=null;
                        $category['breadcrumb']=null;
                    }

                    if($category_exists->name != $category['name']){
                        $category['slug']= join('-',explode(" ", $category['name']));
                        $i=1;
                        while(!$this->form_validation->is_unique( trim($category['slug']), 'categories.slug')){
                            $category['slug']= join('-',explode(" ", $category['name']))."-".$i;
                            $i++;
                        }
                    }
//                    dd($category);
                    $id_category= $this->category->update($category);

                    if ($id_category){
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
     * Petición por ajax que elimina logicamente a una o varias categorias enviadas y sus descendientes
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
	    $categories_ids=$this->input->post('categories');
	    $row_affected= $this->category->delete($categories_ids);


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