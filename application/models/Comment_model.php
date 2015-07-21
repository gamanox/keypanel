<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Comment_model
 * Comentario de un post
 */
class Comment_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "news_comments";

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
        public $content;

        /**
         * @var String
         */
        public $approved;

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
         * save
         *
         * Guarda un comentario
         *
         * @param Array $comment
         * @return Integer
         */
        public function save($comment) {
            $comment['create_at']= date('Y-m-d H:i:s');
            $success= $this->db->insert($this->table, $comment);
            return ($success ? $this->db->insert_id() : 0);
        }

        /**
         * update
         *
         * Actualiza datos de  un comentario
         *
         * @param Array $comment
         * @return Integer
         */
        public function update($comment) {
            $comment['update_at']= date('Y-m-d H:i:s');
            $success= $this->db->update($this->table, $comment, array("id" => $comment['id']));
            return ($success ? 1 : 0);
        }

        /**
         * delete
         *
         * Elimina un comentario lógicamente, es decir actualiza  el campo <b>status_row a <i>DELETED</i></b>
         *
         * @param Integer $id
         * @return Integer
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
         * Devuelve un objeto comment
         *
         * @param Integer $id
         * @return Object
         */
        public function find($id) {
            $this->db->where("id", $id);
            $comment= $this->db->get($this->table)->row(0,"Comment_model");

            return $comment;
        }

        /**
         * find_by_entity
         *
         * Devuelve un objeto de resultado de bases de datos que contiene a los objetos comment de una entidad especificada
         *
         * @param Integer $id_entity
         * @return Object
         */
        public function find_by_entity($id_entity) {
                $this->db->where("id_entity", $id_entity);
                $comments= $this->db->get($this->table);

                return $comments;
        }

        /**
         * find_children
         *
         * Devuelve un objeto de resultado de bases de datos que contiene objetos comment hijos de un comment padre
         *
         * @param Integer $id
         * @return Object
         */
        public function find_children($id) {
                $this->db->where("id_parent", $id);
                $comments= $this->db->get($this->table);

                return $comments;
        }


}