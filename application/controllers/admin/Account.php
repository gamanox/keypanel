<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
require_once APPPATH.'controllers/admin/Base.php';
class Account extends Base {

    /**
     * [__construct]
     * @ignore
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Super_admin_model','super_admin',TRUE);
    }

    /**
     * index
     *
     * Funcion que carga tu informacion de la cuenta
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright KeyPanel 2015
     *
     * @return void
     */
    public function index(){
        if( $this->session->isloggedin ){

            if( $this->session->type == SUPERADMIN )
                $this->lang->load('member');

            $param_header['title'] = lang('my-account-title');
            $this->load->view('includes/header', $param_header);

            $this->load->view('includes/menu-'. strtolower($this->session->type));

            // $this->load->view('users/'. strtolower($this->session->type) .'/my_account');
            $param_view['user_info']    = $this->super_admin->find_me();
            $param_view['dynamic_view'] = 'users/'. strtolower($this->session->type) .'/my_account';
            $param_view['vars_to_load'] = array('user_info');

            $this->load->view('panel/template', $param_view);

            $this->load->view('includes/footer');
        }
        else {
            redirect('main');
        }
    }
}
/* End of file Account.php */
/* Location: ./application/controllers/Account.php */