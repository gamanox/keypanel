<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seed extends CI_Controller {
        public function __construct(){
            parent::__construct();
            // can only be called from the command line
//            if (!$this->input->is_cli_request()) {
//                exit('Direct access is not allowed');
//            }

            // can only be run in the development environment
            if (ENVIRONMENT !== 'development') {
                exit('Wowsers! You don\'t want to do that!');
            }

            // initiate faker
            $this->faker = Faker\Factory::create();
            //$this->faker->seed(4321);

            // load any required models
            $this->load->model('Member_model','member');
            $this->load->model('Profile_model','profile');
            $this->load->model('AccessLog_model','access');
            $this->load->model('History_model','history');
        }

	public function run()
	{
            // purge existing data
            $this->_truncate_db();

            // seed users
            $this->_seed_db(25);

            // call more seeds here...

            }

        function _seed_db($limit)
        {
            echo "seeding $limit users";

            // create a bunch of base buyer accounts
            for ($i = 0; $i < $limit; $i++) {
                echo ".";
                $types= array('MEMBER','PROFILE');
                $entity = array(
                    'username' => $this->faker->unique()->userName, // get a unique nickname
                    'password' => md5("demo"),
                    'type' => $this->faker->randomElement($types),
                    'first_name' => $this->faker->firstName,
                    'last_name' => $this->faker->lastName,
                    'email' => $this->faker->unique()->email,
                    'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                    //'avatar' => $this->faker->imageUrl,
                );

                $id_entity= $this->member->save($entity);

                //logs
                $random= rand(1,10);
                for($j=0; $j<=$random; $j++){
                    $data = array(
                        'id_entity' => $id_entity,
                        'ip_address' => $this->faker->ipv4,
                        'browser' => $this->faker->userAgent,
                    );

                    $this->access->save($data);
                }

                //address
                if(rand(1,0)){
                    $types= array('HOME','BUSINESS', 'POBOX');
                    $data = array(
                        'id_entity' => $id_entity,
                        'type' => $this->faker->randomElement($types),
                        'street' => $this->faker->streetName,
                        'num_ext' => $this->faker->buildingNumber,
                        'num_int' => $this->faker->buildingNumber,
                        'neighborhood' => $this->faker->realText(rand(20, 40)),
                        'zip_code' => $this->faker->randomNumber(5),
                        'city' => $this->faker->city,
                        'state' => $this->faker->realText(rand(20, 40)),
                        'country' => $this->faker->country,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                        //'avatar' => $this->faker->imageUrl,
                    );

                    $this->address->save($data);
                }

                //contacts
                if(rand(1,0)){
                    $data = array(
                        'id_entity' => $id_entity,
                        'bio' => $this->faker->realText(rand(10, 400)),
                        'description' => $this->faker->realText(rand(100, 1000)),
                        'phone_personal' => $this->faker->phoneNumber,
                        'phone_business' => $this->faker->phoneNumber,
                        'facebook' => $this->faker->url,
                        'twitter' => $this->faker->url,
                        'linkedin' => $this->faker->url,
                        'gplus' => $this->faker->url,
                        'email_personal' => $this->faker->email,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED),
                        //'avatar' => $this->faker->imageUrl,
                    );

                    $this->contact->save($data);
                }

            }

            //history
            foreach ($this->member->find_all(MEMBER)->result() as $member) {
                $random= rand(1,20);
                for($k=0; $k<=$random; $k++){
                    $profiles= $this->profile->find_all(PROFILE);

                    $data = array(
                        'id_member' => $member->id,
                        'id_profile' => $profiles->row(rand(0, $profiles->num_rows()-1))->id,
                        'status_row' => (rand(0, 1) ? ENABLED : DELETED)
                    );

                    $this->member->history_save($data);
                }
            }

            echo PHP_EOL;
        }

        private function _truncate_db(){

            foreach ($this->db->list_tables() as $table) {
                $this->db->truncate($table);
            }

        }

}
