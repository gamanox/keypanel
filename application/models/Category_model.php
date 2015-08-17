<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Category_model
 * Categorias del los organigramas
 */
class Category_model extends CI_Model {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Entity_category_model','entity_category');
    }

    /**
     * @var String
     */
    public $table= "categories";

    /**
     * @var Integer
     */
    public $id;

    /**
     * @var String
     */
    public $breadcrumb;

    /**
     * @var String
     */
    public $name;

    /**
     * @var Object
     */
    public $parent;

    /**
     * @var String
     */
    public $create_at;

    /**
     * @var String
     */
    public $update_at;

    /**
     * @var String
     */
    public $status_row;

    /**
     * save
     *
     * Guarda una categoria
     *
     * @param Array $category
     * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
     */
    public function save($category ) {
        $category['create_at']= date('Y-m-d H:i:s');
        $success= $this->db->insert($this->table, $category);
        return ($success ? $this->db->insert_id() : 0);
    }

    /**
     * update
     *
     * Actualiza una categoria
     *
     * @param Array $category
     * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
     */
    public function update($category ) {

        //actualizo el breadcrumb de los nodos hijos si se movio el id_parent
        if(key_exists("breadcrumb", $category)){
            $this->move_r($category['id'], $category['breadcrumb']);
        }

        //actualizo al nodo raiz
        $category['update_at']= date('Y-m-d H:i:s');
        $success= $this->db->update($this->table, $category, array("id" => $category['id']));

        return ($success ? 1 : 0);
    }

    /**
     * delete
     *
     * Elimina a una categoria lógicamente, es decir actualiza  el campo <b>status_row  a <i>DELETED</i></b>
     *
     * @param void $id
     * @return Integer Devuelve la cantidad de registros afectados
     */
    public function delete($id ) {
       $ids = (is_array($id) ? $id : array($id));
        $affected_rows= 0;
        if(count($ids)){
            foreach ($ids as $id_entity) {
                $entity= $this->find($id_entity);

                //elimino a los nodos hijos por su breadcrumb
                if(isset($entity->id)){
                    $this->db->like("breadcrumb",$entity->breadcrumb."|".$entity->id ,'right');
                    $success= $this->db->update($this->table, array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));

                    $affected_rows+= ((isset($success) and $success) ? $this->db->affected_rows() : 0);
                }

                //elimino al nodo raiz
                $this->db->where('id', $id_entity);
                $this->db->limit(1);
                $affected_rows+= $this->db->update($this->table, array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));
            }

        }

        return $affected_rows;
    }

    /**
     * find_all
     *
     * Devuelve un objeto de resultado de bases de datos que contiene nodos categorias
     *
     * @return Object
     */
    public function find_all() {
        $this->db->where('status_row', ENABLED);
        $categories= $this->db->get($this->table);

        return $categories;
    }

    /**
     * find
     *
     * Devuelve un objeto categoria
     *
     * @param void $id
     * @return Object
     */
    public function find($id) {
        $this->db->where("id", $id);
        $this->db->where('status_row', ENABLED);
        $q= $this->db->get($this->table);

        $node= ($q->num_rows() > 0 ? $q->row(0,"Category_model") : $q->row());

        if(isset($node->id)){
            $node->entities= $this->entity_category->find_entities_by_category($node->id);
        }

        return $node;
    }

    /**
     * find_by_slug
     *
     * Devuelve un objeto categoria
     *
     * @param void $slug slug de la categoría
     * @return Object
     */
    public function find_by_slug($slug) {
        $this->db->where("slug", $slug);
        $this->db->where('status_row', ENABLED);
        $q= $this->db->get($this->table);

        $node= ($q->num_rows() > 0 ? $q->row(0,"Category_model") : $q->row());

        if(isset($node->id)){
            $node->entities= $this->entity_category->find_entities_by_category($node->id);
        }

        return $node;
    }

    /**
     * find_children
     *
     * Devuelve un objeto de resultado de bases de datos que contiene nodos categorias hijos que tienen como antecesor a una categoria nodo padre
     *
     * @param Integer $id
     * @return Object
     */
    public function find_children($id) {
        $this->db->where("id_parent", $id);
        $this->db->where('status_row', ENABLED);
        $categories= $this->db->get($this->table);

        return $categories;
    }

    /**
     * find_children_tree
     *
     * Devuelve un objeto de resultado de bases de datos que contiene nodos categorias hijos que tienen como antecesor a una categoria nodo padre
     *
     * @param Integer $id
     * @return Object
     */
    /*public function find_children_tree($id) {
        $this->db->where("id_parent", $id);
        $this->db->where('status_row', ENABLED);
        $categories = $this->db->get($this->table);

        if( $categories->num_rows() > 0 ){
            $this->load->model('Profile_model','profile');
            $categories_tree = $this->tree();

            $categories = $categories->result();
            foreach ($categories as $key => $category) {
                // Buscamos todas las categorias debajo de la categoria dada
                $all_categories = $this->category_tree($category->id, $categories_tree, array());

                $organizations    = array();
                $id_organizations = array();
                $children         = array();
                if( count($all_categories) > 0 ){
                    // Buscamos todos los niveles que pueda tener
                    foreach ($all_categories as $sub_cat) {
                        $organizations_category = $this->entity_category->find_entities_by_category( $sub_cat );
                        if( $organizations_category->num_rows() ){
                            foreach ($organizations_category->result() as $organigrama) {
                                $organizations[$organigrama->id] = $organigrama;

                                if( !in_array($organigrama->id, $id_organizations) )
                                    $id_organizations[] = $organigrama->id;
                            }
                        }
                    }

                    // hijos directos de la categoria
                    if( key_exists($category->id, $categories_tree['parents']) ){
                        foreach ($categories_tree['parents'][$category->id] as $cat) {
                            $children[$cat] = $categories_tree['items'][$cat];
                        }
                    }
                }
                else {
                    // No tiene subcategorias, buscamos las organizaciones directo
                    // Buscamos todos los niveles que pueda tener
                    $organizations_category = $this->entity_category->find_entities_by_category( $category->id );
                    if( $organizations_category->num_rows() ){
                        foreach ($organizations_category->result() as $organigrama) {
                            $organizations[$organigrama->id] = $organigrama;

                            if( !in_array($organigrama->id, $id_organizations) )
                                $id_organizations[] = $organigrama->id;
                        }
                    }
                }

                $categories[$key]->children            = $children;
                $categories[$key]->subcategories       = $all_categories;

                $categories[$key]->total_organizations = count($organizations);
                $categories[$key]->organizations       = $organizations;

                // Buscamos todos los perfiles
                $profiles = array();
                // foreach ($id_organizations as $organization) {
                //     $breadcrumb   = '1|'. $organization .'|';
                //     $profiles_org = $this->profile->find_all_by_breadcrumb( $breadcrumb );

                //     foreach ($profiles_org->result() as $profile) {
                //         $profiles[$profile->id] = $profile;
                //     }
                // }

                $categories[$key]->total_profiles = count($profiles);
                $categories[$key]->profiles = $profiles;
            }
        }

        return $categories;
    }*/

    /**
    * move_r
    *
    * Mueve entidades de un lugar a otro. Sobrescribe el breadcrumb.
    *
    * @access public
    * @param int $id_nodo_a_mover id de entidad a mover
    * @param String $breadcrumb Nuevo breadcrumb
    * @return void
    */
    function move_r($id_nodo_a_mover, $breadcrumb) {

        $nuevo_breadcrumb= (isset($breadcrumb) ?  $breadcrumb . "|" . $id_nodo_a_mover : $id_nodo_a_mover);

        $this->db->select("id, id_parent, breadcrumb");
        $this->db->where("id_parent", $id_nodo_a_mover);
        $rst = $this->db->get($this->table);
        $children = $rst->result();
        $children_count = $rst->num_rows();
        $rst->free_result();

        $datos_update_children = array(
            "id_parent" => $id_nodo_a_mover,
            "breadcrumb" => $nuevo_breadcrumb,
            "update_at" => date('Y-m-d H:i:s')
        );

        //actualizar datos de nodos hijos si existen
        if ($children_count > 0) {
            $this->db->where("id_parent", $id_nodo_a_mover);
            $this->db->limit($children_count);
            $this->db->update($this->table, $datos_update_children);
        }

        //por cada hijo actualizar a sus hijos
        if ($children_count > 0) {
            foreach ($children as $child) {
                $this->move_r($child->id, $nuevo_breadcrumb);
            }
        }
    }

    /**
     * find_children_json
     * Devuelve un arreglo del arbol de categorias para regresarlo en json a la vista desde el controlador
     *
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @access public
     * @copyright KeyPanel - 2015
     *
     * @param int $id id de la categoria de la que se empezara
     * @return array
     */
    public function find_children_json( $id ) {
        $this->db->select('id, name, slug, 0 as value');
        $this->db->where("id_parent", $id);
        $this->db->where('status_row', ENABLED);
        $categories = $this->db->get($this->table);

        if( $categories->num_rows() > 0){
            $this->load->model('Profile_model','profile');
            $categories_tree = $this->tree();

            $temp = array();
            foreach($categories->result() as $category){
                $children = $this->category_tree($category->id, $categories_tree, array());

                $node = array(
                        'name'     => $category->name,
                        'slug'     => $category->slug,
                        'type'     => 'category',
                        'niveles'  => 0,
                        'profiles' => 0
                    );

                if(count($children) > 0){
                    $node['value']    = count($children);
                    $node['children'] = $children;
                }
                else {
                    $node['value']    = 1;
                    $node['children'] = array();
                }

                $direct_childrens = $this->all_categories_down( $category->id );
                $direct_childrens[] = (Object) array('id' => $category->id);
                $category_tree_info = $this->count_organizations_from_categories( $direct_childrens );

                $node['value']   += $category_tree_info['count_organizations'];
                $node['niveles']  = $category_tree_info['count_organizations'];
                $node['profiles'] = $category_tree_info['count_profiles'];

                // Buscamos por categoria, los organigramas que pueda tener
                $organigramas = $this->organization->find_parents_by_category( $category->id );
                if( $organigramas->num_rows() > 0 ){
                    $node['value'] += $organigramas->num_rows();
                    foreach ($organigramas->result() as $organigrama) {
                        $temp_org = array(
                                'type'  => 'organigrama',
                                'name'  => $organigrama->name,
                                'slug'  => $organigrama->id,
                                'value' => 1
                            );

                        // Buscamos los perfiles que tenga debajo
                        $profiles = $this->profile->find_all_by_breadcrumb( $organigrama->breadcrumb .'|'. $organigrama->id );
                        if( $profiles->num_rows() > 0 ){
                            $temp_org['value']   += $profiles->num_rows();
                            $temp_org['profiles'] = $profiles->num_rows();
                         }

                        $node['children'][] = $temp_org;
                    }
                }

                $temp[] = $node;
            }

            $categories = $temp;
        }
        else
            $categories = array();


        return $categories;
    }

    /**
    * count_organization_from_categories
    *
    * Devuelve el numero de organigramas y perfiles total de categorias especificadas
    * @author Luis E. Salazar <luis.830424@gmail.com>
    * @access public
    * @param array $categories object de categorias
    * @return array array("count_organizations"=>$orgs_sum,"count_profiles"=>$profiles_sum);
    */
    function count_organizations_from_categories($categories) {
        $orgs_contados = array();
        $cats_cves     = array();
        $orgs_sum      = 0;
        $profiles_sum  = 0;

        foreach ($categories as $category) {
            $cats_cves[]= $category->id;
        }

        $this->db->select("e.id, breadcrumb");
        $this->db->from('entities_categories ec');
        $this->db->join('entities e', 'ec.id_entity=e.id');
        $this->db->where('e.type', ORGANIZATION);
        $this->db->where_in('ec.id_category', $cats_cves);
        $this->db->where('e.status_row', ENABLED);
        $this->db->where('ec.status_row', ENABLED);
        $orgs= $this->db->get();


        foreach ($orgs->result() as $org) {
            if(!in_array($org->id, $orgs_contados)){
                $orgs_sum++;

                $this->db->select("count(e.id) count_profiles");
                $this->db->from("entities e");
                $this->db->like("breadcrumb",$org->breadcrumb."|".$org->id."|",'right');
                $this->db->where('e.type', PROFILE);
                $this->db->where('e.status_row', ENABLED);
                $profiles_sum += $this->db->get()->row('count_profiles');
            }

            $orgs_contados[]= $org->id;
        }

        return array("count_organizations" => $orgs_sum, "count_profiles" => $profiles_sum);
    }

    /**
     * find_parents
     *
     * Devuelve un objeto de resultado de bases de datos que contiene categorias nodos padres que no tienen un nodo padre asignado
     *
     * @return Object
     */
    public function find_parents() {
        $this->db->where("id_parent is null");
        $this->db->where('status_row', ENABLED);
        $categories= $this->db->get($this->table);

        return $categories;
    }

    /**
     * tree
     * Arma un arreglo con todas las categorias que existen en la base de datos y muestra que categorias dependen una de la otra
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return array
     */
    public function tree(){
        $this->db->where('status_row', ENABLED);
        $query      = $this->db->get('categories');
        $categories = array();

        // Builds the array lists with data from the categories table
        foreach ($query->result() as $key => $items) {
            $categories['items'][$items->id] = $items;
            if( isset($items->id_parent) )
                $categories['parents'][$items->id_parent][] = $items->id;
        }

        return $categories;
    }

    /**
     * category_tree
     * Regresa el arbol armado de categorias
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return array
     */
    public function category_tree($parent, $array, $all_categories){
        if ( isset( $array['parents'][$parent] ) ) {
            foreach ($array['parents'][$parent] as $itemId) {

                if(!isset($array['parents'][$itemId])) {
                    if( !in_array($itemId, $all_categories) ){
                        $children = $this->category_tree($itemId, $array, array());

                        $node = array(
                                'name'     => $array['items'][$itemId]->name,
                                'slug'     => $array['items'][$itemId]->slug,
                                'type'     => 'category',
                                'niveles'  => 0,
                                'profiles' => 0
                            );

                        if(count($children) > 0){
                            $node['value']    = count($children);
                            $node['children'] = $children;
                        }
                        else {
                            $node['value']    = 1;
                            $node['children'] = array();
                        }

                        $direct_childrens = $this->all_categories_down( $itemId );
                        $direct_childrens[] = (Object) array('id' => $itemId);

                        // echo $itemId .'<br>';
                        // echo var_dump($direct_childrens);
                        // echo '<hr>';
                        if( count($direct_childrens) > 0 ){
                            $category_tree_info = $this->count_organizations_from_categories( $direct_childrens );

                            $node['value']   += $category_tree_info['count_organizations'];
                            $node['niveles']  = $category_tree_info['count_organizations'];
                            $node['profiles'] = $category_tree_info['count_profiles'];
                        }

                        // Buscamos por categoria, los organigramas que pueda tener
                        $organigramas = $this->organization->find_parents_by_category( $itemId );
                        if( $organigramas->num_rows() > 0 ){
                            foreach ($organigramas->result() as $organigrama) {
                                $temp_org = array(
                                        'type'  => 'organigrama',
                                        'name'  => $organigrama->name,
                                        'slug'  => $organigrama->id,
                                        'value' => 1
                                    );

                                // Buscamos los perfiles que tenga debajo
                                $profiles = $this->profile->find_all_by_breadcrumb( $organigrama->breadcrumb .'|'. $organigrama->id );
                                if( $profiles->num_rows() > 0 ){
                                    $temp_org['value']   += $profiles->num_rows();
                                    $temp_org['profiles'] = $profiles->num_rows();
                                 }

                                $node['children'][] = $temp_org;
                            }
                        }

                        $all_categories[] = $node;
                    }
                }

                if(isset($array['parents'][$itemId])) {
                    if( !in_array($itemId, $all_categories) ){

                        $children = $this->category_tree($itemId, $array, array());

                        $node = array(
                                'name'     => $array['items'][$itemId]->name,
                                'slug'     => $array['items'][$itemId]->slug,
                                'type'     => 'category',
                                'niveles'  => 0,
                                'profiles' => 0
                            );

                        if(count($children) > 0){
                            $node['value']    = count($children);
                            $node['children'] = $children;
                        }
                        else {
                            $node['value']    = 1;
                            $node['children'] = array();
                        }

                        $direct_childrens = $this->all_categories_down( $itemId );
                        $direct_childrens[] = (Object) array('id' => $itemId);

                        // echo $itemId .'<br>';
                        // echo var_dump($direct_childrens);
                        // echo '<hr>';
                        if( count($direct_childrens) > 0 ){
                            $category_tree_info = $this->count_organizations_from_categories( $direct_childrens );

                            $node['value']   += $category_tree_info['count_organizations'];
                            $node['niveles']  = $category_tree_info['count_organizations'];
                            $node['profiles'] = $category_tree_info['count_profiles'];
                        }

                        // Buscamos por categoria, los organigramas que pueda tener
                        $organigramas = $this->organization->find_parents_by_category( $itemId );
                        if( $organigramas->num_rows() > 0 ){
                            foreach ($organigramas->result() as $organigrama) {
                                $temp_org = array(
                                        'type'  => 'organigrama',
                                        'name'  => $organigrama->name,
                                        'slug'  => $organigrama->id,
                                        'value' => 1
                                    );

                                // Buscamos los perfiles que tenga debajo
                                $profiles = $this->profile->find_all_by_breadcrumb( $organigrama->breadcrumb .'|'. $organigrama->id );
                                if( $profiles->num_rows() > 0 ){
                                    $temp_org['value']   += $profiles->num_rows();
                                    $temp_org['profiles'] = $profiles->num_rows();
                                 }

                                $node['children'][] = $temp_org;
                            }
                        }

                        $all_categories[] = $node;
                    }
                }
            }
        }

        return $all_categories;
    }

    /**
     * [function_name description]
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return [type] [description]
     */
    public function all_categories_down( $category, $categories = array() ){
        $this->db->select('id')
            ->from('categories')
            ->where('id_parent', $category)
            ->where('status_row', ENABLED);
        $children = $this->db->get();

        if( $children->num_rows() > 0 ){
            foreach ($children->result() as $cat) {
                $categories[] = (Object) array('id' => $cat->id);
                $categories = $this->all_categories_down( $cat->id, $categories );
            }
        }

        return $categories;
    }
}
