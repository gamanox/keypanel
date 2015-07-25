<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Post_model
 * Clase para noticias
 */
class Post_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "news_posts";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var String
         */
        public $content;

        /**
         * @var String
         */
        public $title;

        /**
         * @var String
         */
        public $status;

        /**
         * @var String
         */
        public $comment_status;

        /**
         * @var Integer
         */
        public $comment_count;

        /**
         * @var String
         */
        public $password;

        /**
         * @var Status
         */
        public $slug;

        /**
         * @var String
         */
        public $type;

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
        public $comments= null;



        /**
         * save
         *
         * Guarda un post
         *
         * @param Array $post
         * @return Integer Devuelve el <b>id</b> del insert que se creó si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function save($post) {
            $post['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $post);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza datos de  un post
         *
         * @param Array $post
         * @return Integer Devuelve <b>1</> si hubo éxito, caso contrario devuelve <b>0</b>
         */
        public function update($post) {
            $post['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $post, array("id" => $post['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina un post lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Integer $id
         * @return Integer Devuelve la cantidad de registros afectados
         */
        public function delete($id ) {
            $id = (is_array($id) ? $id : array($id));
            if(count($id)){
                $this->db->where_in("id", $id);
                $this->db->limit(count($id));
                $success= $this->db->update($this->table, array("update_at"=>date('Y-m-d H:i:s'),"status_row"=>DELETED));
            }

            return ((isset($success) and $success) ? $this->db->affected_rows() : 0);
        }

        /**
         * find
         *
         * Devuelve un objeto post
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $post= $this->db->get($this->table)->row(0,"Post_model");

            return $post;
        }

        /**
         * find_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos post de una entidad especificada
         *
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $posts= $this->db->get($this->table);

                return $posts;
        }

}