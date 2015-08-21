<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package keypanel
 * @version 1.0
 * @copyright KeyPanel 2015
 */
require_once APPPATH.'controllers/admin/Base.php';
class Panel extends Base {

    /**
     * __construct
     *
     * @ignore
     * @copyright KeyPanel - 2015
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index(){
        redirect('admin/member/show_list');
    }
}
/* End of file Panel.php */
/* Location: ./application/controllers/Panel.php */