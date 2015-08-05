<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
class Panel extends CI_Controller {

    /**
     * __construct
     *
     * @ignore
     * @copyright KeyPanel - 2015
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model','member');
    }

    public function index(){
        $param_header['title'] = 'KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info']    = $this->member->find_me();
        $param['dynamic_view'] = 'panel/home';
        $param['vars_to_load'] = array('user_info');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }

    /**
     * updates
     * @return void
     */
    public function updates(){
        $param_header['title'] = lang('card-updates-title') .' | KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info'] = $this->member->find_me();
        $param['updates']   = NULL;

        $param['dynamic_view'] = 'panel/updates';
        $param['vars_to_load'] = array('user_info','updates');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }

     /**
     * history
     *
     * Esta funcion se encarga de mostrar el historial de navegacion del usuario loggeado.
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel - 2015
     *
     * @return void
     */
    public function history(){
        $param_header['title'] = lang('card-history-title') .' | KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info'] = $this->member->find_me();

        $param['dynamic_view'] = 'panel/history';
        $param['vars_to_load'] = array('user_info');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }
}
/* End of file Panel.php */
/* Location: ./application/controllers/Panel.php */