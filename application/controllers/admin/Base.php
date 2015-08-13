<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Base extends CI_Controller {

    /**
     * __construct
     * @ignore
     * @copyright KeyPanel - 2015
     *
     */
    function __construct()
    {
        parent::__construct();

        if( $this->session->type != SUPERADMIN ){
            show_404();
        }
    }
}
/* End of file Base.php */
/* Location: ./application/controllers/admin/Base.php */