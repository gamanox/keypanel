<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {
    public $controllers_sin_validar = array('errores','account','main', 'test');
    public $ci;

    public function __construct(){
        $this->ci =& get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }

    public function check_session(){
        if(!$this->ci->input->is_ajax_request() and $this->ci->session->userdata('isloggedin') == FALSE && !in_array($this->ci->router->class,$this->controllers_sin_validar)){
            redirect('errores/session_expired');
        }
    }

    public function translation(){
        !$this->ci->load->helper('language') ? $this->ci->load->helper('language') : false;

        $lang = $this->ci->config->item('language');
        $lang = empty($lang) ? 'english' : $lang;

        $basepath = APPPATH .'language/'. $lang .'/'. $this->ci->router->class .'_lang.php';
        echo var_dump($lang);
        echo '<br/>';
        echo var_dump($basepath);
        echo var_dump(file_exists($basepath));
        die();
        if (file_exists($basepath)){
            $this->ci->lang->load( $this->ci->router->class );
        }

        $this->ci->lang->load( 'General' );
    }

    public function validate_membership(){
        $member_access = $this->ci->session->membership_valid;
        if( !$member_access && !in_array($this->ci->router->class, $this->controllers_sin_validar)){
            redirect('errores/payment_required');
        }
    }

    public function profiler() {
        if (ENVIRONMENT == 'development' and !$this->ci->input->is_ajax_request())
            $this->ci->output->enable_profiler(true);
    }
}
