<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Post_model extends CI_Model {

        /**
         *
         */
        public function __construct() {
                parent::__construct();
        }

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
         * @var \\Comment
         */
        public $comments;



        /**
         * Guarda un post
         * @param void $post
         * @return Integer
         */
        public function save($post ) {
                // TODO implement here
                return null;
        }

        /**
         * Actualiza datos de  un post
         * @param void $post
         * @return Integer
         */
        public function update($post) {
                // TODO implement here
                return null;
        }

        /**
         * Elimina un post lógicamente, es decir actualiza  el campo __status_row__ a __DELETED__
         * @param void $id
         * @return Integer
         */
        public function delete($id ) {
                // TODO implement here
                return null;
        }

        /**
         * Devuelve los posts de una entidad
         * @param void $id_entity
         * @return Post[]
         */
        public function find($id_entity) {
                // TODO implement here
                return null;
        }

}