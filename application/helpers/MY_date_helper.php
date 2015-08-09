<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * add_days_to_date
 *
 * Devuelve la fecha futura de la fecha y dias especificados
 *
 * @access	public
 * @param date $date un fecha
 * @param int $number_of_days Numero de dias para agregar a la fecha
 * @return	date
 */
if ( ! function_exists('add_days_to_date'))
{
	function add_days_to_date($date = null, $number_of_days = 0, $output='Y-m-d H:i:s')
	{
		$date = (is_null($date) ? date( 'Y-m-d H:i:s'): $date);

		$new_date = strtotime ( '+'.$number_of_days.' day' , strtotime ( $date ) ) ;
		$new_date = date ( $output , $new_date );

		return $new_date;

	}
}

/**
 * add_months_to_date
 *
 * Devuelve la fecha futura de la fecha y meses especificados
 *
 * @access	public
 * @param date $date un fecha
 * @param int $number_of_months Numero de meses para agregar a la fecha
 * @return	date
 */

if ( ! function_exists('add_months_to_date'))
{
	function add_months_to_date($date = null, $number_of_months, $format='Y-m-d H:i:s')
	{
                $date = (is_null($date) ? date( $format) : $date);

		$new_date = strtotime ( '+'.$number_of_months.' month' , strtotime ( $date ) ) ;
		$new_date = date ( $format , $new_date );

		return $new_date;

	}
}

/**
 * my_date_diff
 *
 * Devuelve la fecha futura de la fecha y meses especificados
 *
 * @access  public
 * @param date $date una fecha menor
 * @param date $date una fecha mayor
 * @return  int
 */

if ( ! function_exists('my_date_diff'))
{
	function my_date_diff($olddate, $newdate, $medida="m")
	{
	    $datetime1 = date_create($olddate);
	    $datetime2 = date_create($newdate);
	    $interval = date_diff($datetime1, $datetime2);
	    $diff_en_anios = $interval->format('%y');
	    $diff_en_meses = $interval->format('%m');
	    $diff_en_dias = $interval->format('%a');

	    switch ($medida) {
		case "y":
		    $diff = $diff_en_anios;
		    break;
		case "m":
		    $diff = ($diff_en_anios * 12) + $diff_en_meses;
		    break;
		case "a":
		    $diff = $diff_en_dias;
		    break;

		default:
		    break;
	    }

	    return $diff;

	}
}

/**
 * date_to_humans
 *
 * Devuelve la fecha con el formato que se le especifique
 *
 * @access  public
 * @param date $date una fecha
 * @param date $format formato de fecha requerido
 * @return  String  Fecha con el formato especificado
 */

if ( ! function_exists('date_to_humans'))
{
    function date_to_humans( $create_at, $format = 'Y/m/d' ){
        return date($format, strtotime($create_at));
    }
}


/* End of file MY_date_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */