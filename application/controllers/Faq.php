<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 */
class Faq extends CI_Controller {

    /**
     * __construct
     * @ignore
     * @copyright KeyPanel 2015
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * help
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
     *
     * @return void
     */
    public function help(){
        $this->load->model('Member_model','member');
        $this->lang->load('panel');

        $param_header['title'] = lang('help-title') .' | KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info']    = $this->member->find_me();
        $param['dynamic_view'] = 'panel/help';
        $param['vars_to_load'] = array('user_info');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }
}
/* End of file Faq.php */
/* Location: ./application/controllers/Faq.php */