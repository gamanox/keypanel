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

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index(){
        $this->load->model('Post_model','post');
        $this->load->model('Tag_model','tag');

        $param_header['title'] = 'KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info'] = $this->member->find_me();
        $param['updates']   = $this->member->updates(6);
        $param['news']      = $this->post->find_all();
        $param['trends']    = $this->tag->find_trends( 15 );

        $param['dynamic_view'] = 'panel/home';
        $param['vars_to_load'] = array('user_info','updates','news','trends');

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
        $param['updates']   = $this->member->updates(10);

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

    /**
     * [history description]
     * @return [type] [description]
     */
    public function history(){
        $param_header['title'] = lang('card-history-title') .' | KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info']    = $this->member->find_me();
        $param['dynamic_view'] = 'panel/history';
        $param['vars_to_load'] = array('user_info');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }

    /**
     * [news description]
     * @return [type] [description]
     */
    public function news(){
        $this->load->model('Post_model','post');

        $param_header['title'] = lang('card-noticias-title') .' | KeyPanel';
        $this->load->view('includes/header', $param_header);
        $this->load->view('includes/menu-'. strtolower($this->session->type));

        $param['user_info'] = $this->member->find_me();
        $param['news']      = $this->post->find_all();
        $param['dynamic_view'] = 'panel/news';
        $param['vars_to_load'] = array('news');

        $this->load->view('panel/template', $param);

        $this->load->view('includes/footer');
    }
}
/* End of file Panel.php */
/* Location: ./application/controllers/Panel.php */