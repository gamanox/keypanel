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
        $this->load->model('Entity_model','entity');
        $this->load->model('Organization_model','organization');
        $this->load->model('Area_model','area');
        $this->load->model('Profile_model','profile');
        $this->load->model('Category_model','category');
        $this->load->model('Entity_category_model','entity_category');
        $this->load->model('Tag_model','tag');
        $this->load->model('Entity_tag_model','entity_tag');

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
     * @param int $id (opcional) Id de la entidad a explorar
     * @return void
     */
    function explore($id=null) {
        if (!$this->auth->is_auth($this->router->class, READ)) {
            redirect("errores/no_authorized");
        }

        if( is_null($id) ){
            //buscamos los organigramas
            $param['nodes']= $this->organization->find_parents();
            $param['title']= lang('org_list');
        }else{
            //buscamos la entidad enviada
            $param['parent']= $this->entity->find_container( $id );
            //si no existe page 404
            if(!isset($param['parent']->id)){
                show_404();
            }
            //buscamos los nodos hijos del nodo padre
            $param['nodes']= $this->organization->find_children($id);

            $param['title']= $param['parent']->first_name;

        }

        $this->lang->load('panel');

        $param_header['title'] = lang('org_title');
        $this->load->view('includes/header', $param_header);

        $param_menu= array();
        if(isset($param['parent'])){
            $param_menu['back_btn']      = base_url("admin/organigrama/explore/".$param['parent']->id_parent);
        }

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $this->load->view('organization/list', $param);
        $this->load->view('includes/footer');
    }

    /**
     * add
     *
     * Carga la vista html para crear un organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function add() {
        if (!$this->auth->is_auth($this->router->class, CREATE)) {
            redirect("errores/no_authorized");
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('org_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore");


        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['tags']= $this->tag->find_all();
        $param['categories']= $this->category->find_all();
        $this->load->view('organization/new', $param);
        $this->load->view('includes/footer');
    }

    /**
     * create
     *
     * Crea un organigrama
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
            $organigrama= $this->input->post('organization');
            $contact= $this->input->post('contact');
            $address= $this->input->post('address');
            $categories= $this->input->post('categories');
            $tags= $this->input->post('tags');

            $categories= (is_array($categories)?$categories: array());
            $tags= (is_array($tags)?$tags: array());
//            dd($this->input->post());
            $id_contact= $this->contact->save($contact);
            $organigrama['id_contact']= $id_contact;
            $organigrama['breadcrumb']= $this->session->id;
            $organigrama['type']= ORGANIZATION;

            $id_organization= $this->organization->save($organigrama);
            $address['id_entity']=$id_organization;
            $this->address->save($address);

            //guardar categorias asociadas
            foreach ($categories as $id_cat) {
                $organization_category= array(
                    "id_category"=> $id_cat,
                    "id_entity"=> $id_organization
                );

                $this->entity_category->save($organization_category);
            }

            //guardar tags relacionados
            foreach ($tags as $id_tag) {
                $profile_tag= array(
                    "id_tag"=> $id_tag,
                    "id_entity"=> $id_organization
                );

                $this->entity_tag->save($profile_tag);
            }

            if ($id_organization){
                $response["status"] = 1;
                $response["msg"]    = lang('msg_operacion_exitosa');
            }
            else {
                $response["msg"] = lang('msg_operacion_fallida');
            }
        }

	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

    /**
     * edit
     *
     * Carga la vista html para editar un organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @param int $id_entity Id de la entidad
     * @return void
     */
    function edit($id_entity) {
        if (!$this->auth->is_auth($this->router->class, UPDATE)) {
            redirect("errores/no_authorized");
        }

        $entity= $this->entity->find($id_entity);

        if(!isset($entity->id)){
            show_404();
        }

        //redirigimos al metodo correspondiente si es un area o perfil
        if($entity->type==AREA){
            redirect("admin/organigrama/area_edit/".$entity->id);
        }

        if($entity->type==PROFILE){
            redirect("admin/organigrama/profile_edit/".$entity->id);
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('org_edit');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore");


        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['organization']= $this->organization->find($id_entity);
        $param['tags']= $this->tag->find_all();
        $param['categories']= $this->category->find_all();
        $this->load->view('organization/edit', $param);
        $this->load->view('includes/footer');
    }

    /**
     * save
     *
     * Guarda cambios de un organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function save() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
//            dd($this->input->post());
            $organigrama= $this->input->post('organization');
            $contact= $this->input->post('contact');
            $address= $this->input->post('address');
            $categories= $this->input->post('categories');
            $tags= $this->input->post('tags');

            $categories= (is_array($categories)?$categories: array());
            $tags= (is_array($tags)?$tags: array());

            $success=0;
            //actualizamos el organigrama
            $success+= $this->organization->update($organigrama);
            //actualizamos contacto
            $success+= $this->contact->update($contact);
            //actualizamos direccion
            $success+= $this->address->update($address);

            //actualizar categorias
            $categories_exists= $this->entity_category->find_categories_by_entity($organigrama['id']);

            foreach ($categories_exists->result() as $category) {
                //si esta en las categorias enviadas, la ponemos en enabled por si estaba eliminada
                if(in_array($category->id, $categories)){
                    $success+= $this->entity_category->update(array("id"=>$category->id_relation,"status_row"=>ENABLED));
                }else{
                    //si no esta en las enviadas, la eliminamos
                    $success+= $this->entity_category->delete($category->id_relation);
                }

                //quitamos de las enviadas la categoria en la iteracion actual
                unset($categories[ array_search($category->id, $categories)]);
            }

            //si aun qdaron categorias de las enviadas, entonces son nuevas, ay que agregarlas
            if(count($categories) > 0){
                foreach ($categories as $id_cat) {
                    $organization_category= array(
                        "id_category"=> $id_cat,
                        "id_entity"=> $organigrama['id']
                    );

                    $success+= $this->entity_category->save($organization_category);
                }
            }

            //actualizar etiquetas
            $tags_exists= $this->entity_tag->find_tags_by_entity($organigrama['id']);

            foreach ($tags_exists->result() as $tag) {
                //si esta en las etiquetas enviadas, la ponemos en enabled por si estaba eliminada
                if(in_array($tag->id, $tags)){
                    $success+= $this->entity_tag->update(array("id"=>$tag->id_relation,"status_row"=>ENABLED));
                }else{
                    //si no esta en las enviadas, la eliminamos
                    $success+= $this->entity_tag->delete($tag->id_relation);
                }

                //quitamos de las enviadas la etiqueta en la iteracion actual
                unset($tags[ array_search($tag->id, $tags)]);
            }

            //si aun qdaron etiquetas de las enviadas, entonces son nuevas, ay que agregarlas
            if(count($tags) > 0){
                foreach ($tags as $id_tag) {
                    $profile_tag= array(
                        "id_tag"=> $id_tag,
                        "id_entity"=> $organigrama['id']
                    );

                    $success+= $this->entity_tag->save($profile_tag);
                }
            }

            if ($success){
                $response["status"] = 1;
                $response["msg"]    = lang('msg_operacion_exitosa');
            }
            else {
                $response["msg"] = lang('msg_operacion_fallida');
            }
        }

	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
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
	    $row_affected= $this->entity->delete($entities_ids);


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
     * area_add
     *
     * Carga el html para crear una area dentro del organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @param int $id_parent Id de la entidad padre
     * @access public
     * @return void
     */
    function area_add($id_parent) {
        if (!$this->auth->is_auth($this->router->class, CREATE)) {
            redirect("errores/no_authorized");
        }

        $parent= $this->entity->find_container($id_parent);

        if(!isset($parent->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('area_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore/".$id_parent);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['entity']= $this->entity->find($id_parent);
        $this->load->view('organization/areas/new', $param);
        $this->load->view('includes/footer');
    }

    /**
     * area_create
     *
     * Crea una area dentro de un organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function area_create() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
            $area= $this->input->post('area');

            if(!is_array($area)){
                $response["msg"]= lang('msg_operacion_fallida');
            }elseif(!isset ($area['id_parent'])){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
                $parent= $this->entity->find_container($area['id_parent']);

                if(!isset($parent->id)){
                    $response["msg"]= lang('msg_operacion_fallida');
                }else{
                    $area['breadcrumb']= $parent->breadcrumb."|".$parent->id;
                    $area['type']= AREA;
                    $id_area= $this->area->save($area);

                    if ($id_area){
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
     * area_edit
     *
     * Carga el html para editar una area dentro del organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @param int $id_area Id de la entidad
     * @access public
     * @return void
     */
    function area_edit($id_area) {
        if (!$this->auth->is_auth($this->router->class, UPDATE)) {
            redirect("errores/no_authorized");
        }

        $area= $this->area->find($id_area);

        if(!isset($area->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('area_edit');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore/".$area->id_parent);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['area']= $area;
        $param['parents']= $this->entity->find_all(array(ORGANIZATION, AREA));
        $this->load->view('organization/areas/edit', $param);
        $this->load->view('includes/footer');
    }

    /**
     * area_save
     *
     * Guarda cambios de un area dentro de un organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function area_save() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
            $area= $this->input->post('area');

            if(!is_array($area)){
                $response["msg"]= lang('msg_operacion_fallida');
            }elseif(!isset ($area['id_parent'])){
                $response["msg"]= lang('msg_operacion_fallida');
            }elseif($area['id_parent']==0){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{
                $parent= $this->entity->find_container($area['id_parent']);
                $area_exists= $this->area->find($area['id']);

                if(!isset($parent->id)){
                    $response["msg"]= lang('msg_operacion_fallida');
                }elseif(!isset($area_exists->id)){
                    $response["msg"]= lang('msg_operacion_fallida');
                }else{

                    if($area_exists->id_parent != $area['id_parent']){
                        $area['breadcrumb']= $parent->breadcrumb."|".$parent->id;
                    }

                    $success= $this->area->update($area);

                    if ($success){
                        $response["status"] = 1;
                        $response["msg"]    = lang('msg_operacion_exitosa');
                        $response["parent"]= $area['id_parent'];
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
     * profile_add
     *
     * Carga la vista html para crear un perfil
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @param int $id_parent Id de la entidad padre
     * @access public
     * @return void
     */
    function profile_add($id_parent) {
        if (!$this->auth->is_auth($this->router->class, CREATE)) {
            redirect("errores/no_authorized");
        }

        $parent= $this->entity->find_container($id_parent);

        if(!isset($parent->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('perfil_add');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore/".$id_parent);

        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['tags']= $this->tag->find_all();
        $param['parent']= $this->entity->find($id_parent);
        $this->load->view('organization/profiles/new', $param);
        $this->load->view('includes/footer');
    }

    /**
     * profile_create
     *
     * Guarda un perfil dentro de un area/organigrama
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function profile_create() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
            $profile= $this->input->post('profile');
            $contact= $this->input->post('contact');
            $address= $this->input->post('address');
            $tags= $this->input->post('tags');

            $tags= (is_array($tags)?$tags: array());

            $parent= $this->entity->find_container($profile['id_parent']);

            if(!isset($parent->id)){
                $response["msg"]= lang('msg_operacion_fallida');
            }else{

                $id_contact= $this->contact->save($contact);
                $profile['id_contact']= $id_contact;
                $profile['breadcrumb']= $parent->breadcrumb."|".$parent->id;
                $profile['type']= PROFILE;

                $id_profile= $this->entity->save($profile);
                $address['id_entity']=$id_profile;
                $this->address->save($address);

                foreach ($tags as $id_tag) {
                    $profile_tag= array(
                        "id_tag"=> $id_tag,
                        "id_entity"=> $id_profile
                    );

                    $this->entity_tag->save($profile_tag);
                }

                if ($id_profile){
                    $response["status"] = 1;
                    $response["msg"]    = lang('msg_operacion_exitosa');
                }
                else {
                    $response["msg"] = lang('msg_operacion_fallida');
                }
            }
        }

	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }

    /**
     * profile_edit
     *
     * Carga la vista html para editar un perfil
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function profile_edit($id_profile) {
        if (!$this->auth->is_auth($this->router->class, UPDATE)) {
            redirect("errores/no_authorized");
        }

        $profile= $this->profile->find($id_profile);

        if(!isset($profile->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('profile_edit');
        $this->load->view('includes/header', $param_header);

        $param_menu['back_btn']= base_url("admin/organigrama/explore/".$profile->id_parent);


        $this->load->view('includes/menu-extended-'. strtolower(SUPERADMIN), $param_menu);

        $param['tags']= $this->tag->find_all();
        $param['profile']= $profile;
        $this->load->view('organization/profiles/edit', $param);
        $this->load->view('includes/footer');
    }

    /**
     * profile_save
     *
     * Guarda cambios de un perfil
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @return void
     */
    function profile_save() {
        $response["status"]=0;
        $response["msg"]= lang('msg_operacion_fallida');
	if(!$this->input->is_ajax_request()){
	    show_404();
	}elseif (!$this->auth->is_auth($this->router->class, CREATE)) {
	    $response['msg']= lang('error_sin_permisos');
	}else{
//            dd($this->input->post());
            $profile= $this->input->post('profile');
            $contact= $this->input->post('contact');
            $address= $this->input->post('address');
            $tags= $this->input->post('tags');

            $tags= (is_array($tags)?$tags: array());

            $success=0;
            //actualizamos el organigrama
            $success+= $this->organization->update($profile);
            //actualizamos contacto
            $success+= $this->contact->update($contact);
            //actualizamos direccion
            $success+= $this->address->update($address);

            $tags_exists= $this->entity_tag->find_tags_by_entity($profile['id']);

            foreach ($tags_exists->result() as $tag) {
                //si esta en las etiquetas enviadas, la ponemos en enabled por si estaba eliminada
                if(in_array($tag->id, $tags)){
                    $success+= $this->entity_tag->update(array("id"=>$tag->id_relation,"status_row"=>ENABLED));
                }else{
                    //si no esta en las enviadas, la eliminamos
                    $success+= $this->entity_tag->delete($tag->id_relation);
                }

                //quitamos de las enviadas la etiqueta en la iteracion actual
                unset($tags[ array_search($tag->id, $tags)]);
            }

            //si aun qdaron etiquetas de las enviadas, entonces son nuevas, ay que agregarlas
            if(count($tags) > 0){
                foreach ($tags as $id_tag) {
                    $profile_tag= array(
                        "id_tag"=> $id_tag,
                        "id_entity"=> $profile['id']
                    );

                    $success+= $this->entity_tag->save($profile_tag);
                }
            }

            if ($success){
                $response["status"] = 1;
                $response["msg"]    = lang('msg_operacion_exitosa');
            }
            else {
                $response["msg"] = lang('msg_operacion_fallida');
            }
        }

	//cocinado!!
	$json = json_encode($response);
	echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
    }
}