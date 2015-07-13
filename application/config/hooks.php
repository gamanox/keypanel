<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
        'class'    => 'Utils',
        'function' => 'check_session',
        'filename' => 'utils.php',
        'filepath' => 'hooks'
    );

$hook['post_controller_constructor'][] = array(
        'class'    => 'Utils',
        'function' => 'translation',
        'filename' => 'utils.php',
        'filepath' => 'hooks'
    );

$hook['post_controller_constructor'][] = array(
        'class'    => 'Utils',
        'function' => 'validate_membership',
        'filename' => 'utils.php',
        'filepath' => 'hooks'
    );

$hook['post_controller'][] = array(
        'class'    => 'Utils',
        'function' => 'profiler',
        'filename' => 'utils.php',
        'filepath' => 'hooks'
    );