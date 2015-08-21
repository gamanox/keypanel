<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Entity_model
 * Entidades de la plataforma
 */
class Entity_model extends CI_model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
                $this->load->model("Address_model", "address");
                $this->load->model("Contact_model", "contact");
                $this->load->model("Entity_tag_model", "entity_tag");
        }

        /**
         * @var String
         */
        public $table= "entities";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $parent;

        /**
         * @var String
         */
        public $breadcrumb;

        /**
         * @var String
         */
        public $first_name;

        /**
         * @var String
         */
        public $type;

        /**
         * @var String
         */
        public $username;

        /**
         * @var String
         */
        public $password;

        /**
         * @var String
         */
        public $email;

        /**
         * @var String
         */
        public $avatar;

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
         * @var Object
         */
        public $addresses= null;

        /**
         * @var Object
         */
        public $contacts= null;

        /**
         * @var Object
         */
        public $comments= null;

        /**
         * @var Object
         */
        public $posts= null;

        /**
         * @var Array
         */
        public $user_types = array(
           SUPERADMIN  => SUPERADMIN,
           ADMIN => ADMIN,
           MEMBER => MEMBER,
           PROFILE => PROFILE,
           ORGANIZATION=>ORGANIZATION
        );


        /**
         * save
         *
         * Guarda una entidad
         *
         * @param Array $entity
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($entity) {
                $entity['create_at']= date('Y-m-d H:i:s');
                $success= $this->db->insert($this->table, $entity);
                return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza datos de una entidad
         *
         * @param Array $entity
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($entity) {
            $fields_protected= array("id",'username','type');
            $id= $entity['id'];
            //actualizo el breadcrumb de los nodos hijos si se movio el id_parent
            if(key_exists("breadcrumb", $entity)){
                $this->move_r($id, $entity['breadcrumb']);
            }

            //quitando los campos protegidos
            foreach ($entity as $field=> $value) {
                if(in_array($field, $fields_protected)){
                    unset($fields_protected[$field]);
                }
            }

            $entity['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $entity, array("id" => $id));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina a una entidad lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Integer $id
         * @return Integer Devuelve la cantidad de registros afectados
         */
        public function delete($id) {
                $ids = (is_array($id) ? $id : array($id));
                $affected_rows= 0;
                if(count($ids)){
                    foreach ($ids as $id_entity) {
                        $entity= $this->find($id_entity);

                        //elimino a los nodos hijos por su breadcrumb
                        if(isset($entity->id) and in_array($entity->type, array(ORGANIZATION, AREA))){
                            $this->db->like("breadcrumb",$entity->breadcrumb."|".$entity->id ,'both');
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
         * Devuelve un objeto entidad
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
                $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name",false);
                $this->db->where("id", $id);
                $this->db->where("status_row", ENABLED);
                $q= $this->db->get($this->table." u");
                $entity= ($q->num_rows() > 0 ? $q->row(0,"Entity_model") : $q->row());

                if(isset($entity->id)){
                        $entity->addresses= $this->address->find_by_entity($entity->id);
                        $entity->contact= $this->contact->find($entity->id_contact);

                        if(!isset($entity->contact->id)){
                            $entity->contact= $this->contact;
                        }

                }

                return $entity;
        }

        /**
         * find_all
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos entities del sistema
         *
         * @param Mixed $user_type String|Array
         * @param String $status_row    String|Array
         * @param String $order_by  Ordenar por <b>column1 asc|desc</b>
         *
         * @return Object
         */
        function find_all($user_type=null, $status_row= ENABLED, $order_by=null) {
            $user_type= (is_null($user_type) ? array_keys($this->user_types) : $user_type);
            $user_type= (is_array($user_type) ? $user_type : array($user_type));
            $status_row= (is_null($status_row)? ENABLED: $status_row);
            $status_row= (is_array($status_row) ? $status_row : array($status_row));

            $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name",false);

            if(count($user_type)){
                $this->db->where_in("type", $user_type);
            }

            if(count($status_row)){
                $this->db->where_in("status_row", $status_row);
            }

            if(!is_null($order_by)){
                $this->db->order_by($order_by);
            }

            $entities= $this->db->get($this->table. " u");

            return $entities;
        }

        /**
         * is_unique
         *
         * Determina si un valor de un campo definido es único
         *
         * @access private
         * @param Mixed $value Valor a ser comparado
         * @param String $column Nombre de la columna definida en la tabla
         * @return Boolean <b>true es único</b> | <b>false</b> no lo es.
         */
        private function is_unique($value, $column) {
            $this->db->where($column, $value);
            $entity= $this->db->get($this->table. " u");

            return ($entity->num_rows() <= 0 ? true : false);
        }

        /**
         * is_unique_email
         *
         * Determina si un email especificado es único
         *
         * @param Mixed $email Email a ser comparado
         * @return Boolean <b>true es único</b> | <b>false</b> no lo es.
         */
        public function is_unique_email($email) {
            return $this->is_unique($email, "email");
        }

        /**
         * is_unique_username
         *
         * Determina si un username especificado es único
         *
         * @param Mixed $username Username a ser comparado
         * @return Boolean <b>true es único</b> | <b>false</b> no lo es.
         */
        public function is_unique_username($username) {
            return $this->is_unique($username, "email");
        }

        /**
         * updates
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos entities del sistema que se han creado o actualizado
         * ordenados por la fecha mas reciente
         *
         * @return Object
         */
        public function updates($limit=null, $offset=null) {
                $this->db->select("u.*, trim(concat_ws(space(1),u.first_name, ifnull(u.last_name,''))) as full_name");
                $this->db->select("if(create_at > update_at, create_at, update_at)updates, if(create_at > update_at, 'CREATED', 'UPDATED')action", false);
                $this->db->where("status_row", ENABLED);
                $this->db->where_in("type", array(ORGANIZATION, PROFILE));
                $this->db->order_by("updates","desc");

                if((isset($limit) and is_numeric($limit))){
                    $this->db->limit($limit);
                }

                if((isset($offset) and is_numeric($offset))){
                    $this->db->offset($offset);
                }

                $entities= $this->db->get($this->table." u");


                return $entities;
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

    /**
     * find_container
     *
     * Devuelve un objeto organization que si puede ser padre de entidades
     *
     * @param Integer $id
     * @return Object
     */
    public function find_container($id) {
        $this->db->select("u.*, u.first_name as name");
        $this->db->where("id", $id);
        $this->db->where_in('type', array(ORGANIZATION, AREA));
        $this->db->where("status_row", ENABLED);
        $q= $this->db->get($this->table." u");
        $entity= ($q->num_rows() > 0 ? $q->row(0,"Entity_model") : $q->row());

        if(isset($entity->id)){
                $entity->addresses= $this->address->find_by_entity($entity->id);
                $entity->contact= $this->contact->find($entity->id_contact);

                if($entity->id_parent==1){
                    $entity->id_parent=null;
                }

                $entity->categories= $this->entity_category->find_categories_by_entity($entity->id);

        }

        return $entity;
    }

}