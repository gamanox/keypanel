<?p
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Organization_entity_model
 * Perfiles de un organigrama
 */
class Organization_entity_model extends CI_Model {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct();
        }

        /**
         * @var String
         */
        public $table= "organization_profiles";

        /**
         * @var Integer
         */
        public $id;

        /**
         * @var Object
         */
        public $organization;

        /**
         * @var Object
         */
        public $entity;



}