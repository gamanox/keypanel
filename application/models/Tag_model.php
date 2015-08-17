<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Tag_model
 * Etiquetas del sistema
 */
class Tag_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
                $this->load->model('Entity_tag_model','entity_tag');
        }

        /**
         * @var String
         */
        public $table= "tags";

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
         * Guarda una etiqueta
         *
         * @param Array $tag
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($tag ) {
            $tag['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $tag);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza una etiqueta
         *
         * @param Array $tag
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($tag ) {
            //actualizo el breadcrumb de los nodos hijos si se movio el id_parent
            if(key_exists("breadcrumb", $tag)){
                $this->move_r($tag['id'], $tag['breadcrumb']);
            }

            //actualizo al nodo raiz
            $tag['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $tag, array("id" => $tag['id']));

            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una etiqueta lógicamente, es decir actualiza  el campo <b>status_row  a <i>DELETED</i></b>
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
         * find
         *
         * Devuelve un objeto etiqueta
         *
         * @param void $id id de la etiqueta
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $this->db->where('status_row', ENABLED);
            $q= $this->db->get($this->table);

            $node= ($q->num_rows() > 0 ? $q->row(0,"Tag_model") : $q->row());

            if(isset($node->id)){
                $node->entities= $this->entity_tag->find_entities_by_tag($node->id);
            }

            return $node;
        }

        /**
         * find_by_slug
         *
         * Devuelve un objeto etiqueta
         *
         * @param void $slug slug de la etiqueta
         * @return Object
         */
        public function find_by_slug($slug) {
            $this->db->where("slug", $slug);
            $this->db->where('status_row', ENABLED);
            $q= $this->db->get($this->table);

            $node= ($q->num_rows() > 0 ? $q->row(0,"Tag_model") : $q->row());

            if(isset($node->id)){
                $node->entities= $this->entity_tag->find_entities_by_tag($node->id);
            }

            return $node;
        }

        /**
         * find_children
         *
         * Devuelve un objeto de resultado de bases de datos que contiene nodos etiquetas hijos que tienen como antecesor a una etiqueta nodo padre
         *
         * @param Integer $id
         * @return Object
         */
        public function find_children($id) {
            $this->db->where("id_parent", $id);
            $this->db->where('status_row', ENABLED);
            $tags= $this->db->get($this->table);

            return $tags;
        }

        /**
         * find_parents
         *
         * Devuelve un objeto de resultado de bases de datos que contiene etiquetas nodos padres que no tienen un nodo padre asignado
         *
         * @return Object
         */
        public function find_parents() {
            $this->db->where("id_parent is null");
            $this->db->where('status_row', ENABLED);
            $tags= $this->db->get($this->table);

            return $tags;
        }

        /**
         * find_trends
         *
         * Devuelve un objeto de resultado de bases de datos que contiene las etiquetas nodos más buscadas
         *
         * @return Object
         */
        public function find_trends($limit=null) {
            $this->db->where('status_row', ENABLED);
            $this->db->order_by('count_search', 'desc');

            if((isset($limit) and is_numeric($limit))){
                $this->db->limit($limit);
            }

            $tags= $this->db->get($this->table);

            return $tags;
        }

    /**
     * find_all
     *
     * Devuelve un objeto de resultado de bases de datos que contiene nodos tags
     *
     * @return Object
     */
    public function find_all() {
        $this->db->where('status_row', ENABLED);
        $tags= $this->db->get($this->table);

        return $tags;
    }

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

}