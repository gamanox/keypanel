<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package KeyPanel
 * @author Luis
 */
class Errores extends CI_Controller {

    /**
     * __construct
     *
     * @ignore
     * @copyright KeyPanel
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * session_expired
     *
     * Funcion que informa al usuario que su sesion ha expirado
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function session_expired(){
        $param_header['title'] = lang('session-expired-title');
        $this->load->view('includes/header', $param_header);

        $this->load->view('errors/session_expired');

        $this->load->view('includes/footer');
    }

    /**
     * no_authorized
     *
     * Funcion que informa que no esta autorizado para ver el contenido solicitado
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function no_authorized(){
        $this->load->view('errors/no_authorized');
    }

    /**
     * payment_required
     *
     * Funcion que informa que se requiere de pago para usar el servicio
     *
     * @access public
     * @author Guillermo Lucio <guillermo.lucio@gmail.com>
     * @copyright
     *
     * @return void
     */
    public function payment_required(){
        $param_header['title'] = lang('payment-required-title');
        $this->load->view('includes/header');
    }
}
