<?php
defined('BASEPATH') || exit('No direct script access allowed');

/*
 * Modular Extensions - HMVC version 5.4
 * https://expressionengine.com/forums/archive/topic/179560/modular-extensions-hmvc-version-5.4/P240
 */

if (defined('CI_VERSION') && substr(CI_VERSION, 0, 1) != '2') {
    // ERP SQL Server connection database for Codeigniter 3
    $query_builder = true;
    $config['erplnDB'] = array(
        'dsn' => 'ERP_Report',
        'hostname' => '192.168.0.45',
        'port' => '1433',
        'username' => 'appl',
        'password' => 'admin',
        'database' => 'erplndb',
        'dbdriver' => 'sqlsrv',
        'dbprefix' => 'dbo_',
        'pconnect' => false, // not supported with the database session driver
        'db_debug' => (ENVIRONMENT != 'production'),
        'cache_on' => false,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt'  => false,
        'compress' => false,
        'autoinit' => true,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE,
    );
} else {
    // ERP SQL Server connection database for Codeigniter 2
    $active_record = true;
    $config['erplnDB']['dsn'] = 'ERP_Report';
    $config['erplnDB']['hostname'] = '192.168.0.45';
    $config['erplnDB']['username'] = 'appl';
    $config['erplnDB']['password'] = 'admin';
    $config['erplnDB']['database'] = 'erplndb';
    $config['erplnDB']['port'] = '1433';
    $config['erplnDB']['dbdriver'] = 'sqlsrv';
    $config['erplnDB']['dbprefix'] = 'dbo_';
    $config['erplnDB']['pconnect'] = FALSE;
    $config['erplnDB']['db_debug'] = true;
    $config['erplnDB']['cache_on'] = false;
    $config['erplnDB']['cachedir'] = '';
    $config['erplnDB']['char_set'] = 'utf8';
    $config['erplnDB']['dbcollat'] = 'utf8_general_ci';
    $config['erplnDB']['swap_pre'] = '';
    $config['erplnDB']['autoinit'] = true;
    $config['erplnDB']['stricton'] = FALSE;
}