<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class Organization_model extends CI_Model {

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
         * @var \\Organization
         */
        public $parent;

        /**
         * @var String
         */
        public $breadcrumb;

        /**
         * @var String
         */
        public $name;

        /**
         * @var String
         */
        public $description;

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
         * Guarda un nodo en el organigrama
         * @param void $organization
         * @return Integer
         */
        public function save($organization ) {
                // TODO implement here
                return null;
        }

        /**
         * Actualiza un nodo en el organigrama
         * @param void $id
         * @return Integer
         */
        public function update($id ) {
                // TODO implement here
                return null;
        }

        /**
         * Elimina a un nodo del organigrama lógicamente, es decir actualiza  el campo __status_row__ a __DELETED__
         * @param void $id
         * @return Integer
         */
        public function delete($id ) {
                // TODO implement here
                return null;
        }

        /**
         * Devuelve un objeto Organization
         * @param void $id
         * @return \\Organization
         */
        public function find($id) {
                // TODO implement here
                return null;
        }

        /**
         * @param void $id
         * @return Organization[]
         */
        public function find_children($id) {
                // TODO implement here
                return null;
        }

}