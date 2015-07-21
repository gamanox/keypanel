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



}