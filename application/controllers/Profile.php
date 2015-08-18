<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
class Profile extends CI_Controller {

    /**
     * __construct
     *
     * @ignore
     * @copyright KeyPanel - 2015
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Profile_model','profile');
        $this->load->language("organigrama");
    }

    /**
     * show
     *
     * Carga la vista html del perfil
     * @author Luis E. Salazar <luis.830424@gmail.com>
     * @access public
     * @param int $id_profile Id del perfil
     * @return void
     */
    public function show($id_profile){

        $profile= $this->profile->find($id_profile);

        if(!isset($profile->id)){
            show_404();
        }

        $this->lang->load('panel');

        $param_header['title'] = lang('profile_show');
        $this->load->view('includes/header', $param_header);

        $this->load->view('includes/menu-extended-'. strtolower($this->session->type));

        $param['profile']= $profile;
        $this->load->view("organization/profiles/show", $param);

        $this->load->view('includes/footer');

    }
}
/* End of file profile.php */
/* Location: ./application/controllers/profile.php */