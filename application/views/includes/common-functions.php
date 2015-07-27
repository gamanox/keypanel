<?php

    function date_to_humans( $create_at, $format = 'Y/m/d' ){
        return date($format, strtotime($create_at));
    }
?>