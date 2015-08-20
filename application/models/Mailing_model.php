<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailing_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->library('email');
    }

    /**
    * send
    *
    * Devuelve un objeto de resultado de bases de datos que contiene a los objetos dirección de una entidad especificada
    *
    * @param Array $param_email
    * @return Boolean
    */
    function send($param_email) {
        $this->email->from($param_email['from']);
        $this->email->to($param_email['to']);
        // $this->email->cc($param['cc']);
        // $this->email->bcc($param['bcc']);

        $this->email->subject($param_email['subject']);
        $this->email->message($param_email['msg']);

        return $this->email->send();
        // $this->email->print_debugger();
    }
}

/* End of file Mailing_model.php */
/* Location: ./application/models/Mailing_model.php */

/* Desarrollado por: Guillermo Lucio */
/* guillermo.lucio@gmail.com */