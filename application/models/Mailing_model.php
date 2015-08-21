<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailing_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->library('email');
    }

    /**
    * send
    *
    * Envia un email
    *
    * @param Array $param
    * @return Boolean
    */
    function send($param) {
        $this->email->initialize(array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => SENDGRID_USERNAME,
            'smtp_pass' => SENDGRID_PASSWORD,
            'smtp_port' => 587,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        ));


        $this->email->from($param['from']);
        $this->email->to($param['to']);
        $this->email->subject($param['subject']);
        $this->email->message($param['msg']);

        if( ENVIRONMENT == 'development' ){
            return TRUE;
        }
        else {
            return $this->email->send();
        }
        // $this->email->print_debugger();
    }
}

/* End of file Mailing_model.php */
/* Location: ./application/models/Mailing_model.php */

/* Desarrollado por: Guillermo Lucio */
/* guillermo.lucio@gmail.com */