<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['hostname'] The hostname of your database server.
|   ['username'] The username used to connect to the database
|   ['password'] The password used to connect to the database
|   ['database'] The name of the database you want to connect to
|   ['dbdriver'] The database type. ie: mysql.  Currently supported:
                 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|   ['dbprefix'] You can add an optional prefix, which will be added
|                to the table name when using the  Active Record class
|   ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|   ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|   ['cache_on'] TRUE/FALSE - Enables/disables query caching
|   ['cachedir'] The path to the folder where cache files should be stored
|   ['char_set'] The character set used in communicating with the database
|   ['dbcollat'] The character collation used in communicating with the database
|                NOTE: For MySQL and MySQLi databases, this setting is only used
|                as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                (and in table creation queries made with DB Forge).
|                There is an incompatibility in PHP with mysql_real_escape_string() which
|                can make your site vulnerable to SQL injection if you are using a
|                multi-byte character set and are running versions lower than these.
|                Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|   ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|   ['autoinit'] Whether or not to automatically initialize the database.
|   ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                           - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

/* ========================================================================
 * Inicio Seleciona Servidor BD Intranet
 * ======================================================================== */

switch (SERVIDOR) {
    
case 'LOCALHOST':
	
    //Ativa Banco Painel
    $active_group = "local";

    // Conexão Oracle	
    $tnsname = '  (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS005)(PORT = 1521))
                    (ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS024)(PORT = 1521))(LOAD_BALANCE= yes ))(CONNECT_DATA =
                    (SERVICE_NAME = davoprd)(SERVER = DEDICATED)(FAILOVER_MODE =  (TYPE = SELECT) (METHOD = BASIC) 
                    (RETRIES = 180) (DELAY = 5))))';

    $db['oracle']['hostname'] = $tnsname;
    $db['oracle']['username'] = 'davo';
    $db['oracle']['password'] = 'd4v0';
    $db['oracle']['database'] = '';
    $db['oracle']['dbdriver'] = 'oci8';
    $db['oracle']['dbprefix'] = '';
    $db['oracle']['pconnect'] = TRUE;
    $db['oracle']['db_debug'] = FALSE;
    $db['oracle']['cache_on'] = FALSE;
    $db['oracle']['cachedir'] = '';
    $db['oracle']['char_set'] = 'utf8';
    $db['oracle']['dbcollat'] = 'utf8_general_ci';
    $db['oracle']['swap_pre'] = '';
    $db['oracle']['autoinit'] = TRUE;
    $db['oracle']['stricton'] = FALSE;	
	
    // Conexão Emporium    
    $db['emporium']['hostname'] = '10.2.1.110';
    $db['emporium']['username'] = 'root';
    $db['emporium']['password'] = 'emporium';
    $db['emporium']['database'] = 'emporium';
    $db['emporium']['dbdriver'] = 'mysql';
    $db['emporium']['dbprefix'] = '';
    $db['emporium']['pconnect'] = TRUE;
    $db['emporium']['db_debug'] = FALSE;
    $db['emporium']['cache_on'] = FALSE;
    $db['emporium']['cachedir'] = '';
    $db['emporium']['char_set'] = 'utf8';
    $db['emporium']['dbcollat'] = 'utf8_general_ci';
    $db['emporium']['swap_pre'] = '';
    $db['emporium']['autoinit'] = TRUE;
    $db['emporium']['stricton'] = FALSE;   	

  break;
  
case 'QAS':
	
    //Ativa Banco Painel
    $active_group = "qas";

    // Conexão Oracle
    $tnsname = '  (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS005)(PORT = 1521))
                    (ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS024)(PORT = 1521))(LOAD_BALANCE= yes ))(CONNECT_DATA =
                    (SERVICE_NAME = davoprd)(SERVER = DEDICATED)(FAILOVER_MODE =  (TYPE = SELECT) (METHOD = BASIC) 
                    (RETRIES = 180) (DELAY = 5))))';

    $db['oracle']['hostname'] = $tnsname;
    $db['oracle']['username'] = 'davo';
    $db['oracle']['password'] = 'd4v0';
    $db['oracle']['database'] = '';
    $db['oracle']['dbdriver'] = 'oci8';
    $db['oracle']['dbprefix'] = '';
    $db['oracle']['pconnect'] = TRUE;
    $db['oracle']['db_debug'] = FALSE;
    $db['oracle']['cache_on'] = FALSE;
    $db['oracle']['cachedir'] = '';
    $db['oracle']['char_set'] = 'utf8';
    $db['oracle']['dbcollat'] = 'utf8_general_ci';
    $db['oracle']['swap_pre'] = '';
    $db['oracle']['autoinit'] = TRUE;
    $db['oracle']['stricton'] = FALSE;	
	
    // Conexão Emporium    
    $db['emporium']['hostname'] = '10.2.1.110';
    $db['emporium']['username'] = 'root';
    $db['emporium']['password'] = 'emporium';
    $db['emporium']['database'] = 'emporium';
    $db['emporium']['dbdriver'] = 'mysql';
    $db['emporium']['dbprefix'] = '';
    $db['emporium']['pconnect'] = TRUE;
    $db['emporium']['db_debug'] = FALSE;
    $db['emporium']['cache_on'] = FALSE;
    $db['emporium']['cachedir'] = '';
    $db['emporium']['char_set'] = 'utf8';
    $db['emporium']['dbcollat'] = 'utf8_general_ci';
    $db['emporium']['swap_pre'] = '';
    $db['emporium']['autoinit'] = TRUE;
    $db['emporium']['stricton'] = FALSE;   	
	
    // Conexão SQL Server    
    $db['mssql']['hostname'] = '10.2.1.121';
    $db['mssql']['username'] = 'admin';
    $db['mssql']['password'] = '@dminDAVO';
    $db['mssql']['database'] = 'dbo_cre';
    $db['mssql']['dbdriver'] = 'mssql';
    $db['mssql']['dbprefix'] = '';
    $db['mssql']['pconnect'] = TRUE;
    $db['mssql']['db_debug'] = FALSE;
    $db['mssql']['cache_on'] = FALSE;
    $db['mssql']['cachedir'] = '';
    $db['mssql']['char_set'] = 'utf8';
    $db['mssql']['dbcollat'] = 'utf8_general_ci';
    $db['mssql']['swap_pre'] = '';
    $db['mssql']['autoinit'] = TRUE;
    $db['mssql']['stricton'] = FALSE;   	

  break;
  
default:

    //Ativa Banco Painel
    $active_group = "prd";

    // Conexão Oracle
    $tnsname = '  (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS005)(PORT = 1521))
                    (ADDRESS = (PROTOCOL = TCP)(HOST = ORAAS024)(PORT = 1521))(LOAD_BALANCE= yes ))(CONNECT_DATA =
                    (SERVICE_NAME = davoprd)(SERVER = DEDICATED)(FAILOVER_MODE =  (TYPE = SELECT) (METHOD = BASIC) 
                    (RETRIES = 180) (DELAY = 5))))';
	
    $db['oracle']['hostname'] = $tnsname;
    $db['oracle']['username'] = 'davo';
    $db['oracle']['password'] = 'd4v0';
    $db['oracle']['database'] = '';
    $db['oracle']['dbdriver'] = 'oci8';
    $db['oracle']['dbprefix'] = '';
    $db['oracle']['pconnect'] = TRUE;
    $db['oracle']['db_debug'] = FALSE;
    $db['oracle']['cache_on'] = FALSE;
    $db['oracle']['cachedir'] = '';
    $db['oracle']['char_set'] = 'utf8';
    $db['oracle']['dbcollat'] = 'utf8_general_ci';
    $db['oracle']['swap_pre'] = '';
    $db['oracle']['autoinit'] = TRUE;
    $db['oracle']['stricton'] = FALSE;	
	
    // Conexão Emporium    
    $db['emporium']['hostname'] = '10.2.1.10';
    $db['emporium']['username'] = 'root';
    $db['emporium']['password'] = 'emporium';
    $db['emporium']['database'] = 'emporium';
    $db['emporium']['dbdriver'] = 'mysql';
    $db['emporium']['dbprefix'] = '';
    $db['emporium']['pconnect'] = TRUE;
    $db['emporium']['db_debug'] = FALSE;
    $db['emporium']['cache_on'] = FALSE;
    $db['emporium']['cachedir'] = '';
    $db['emporium']['char_set'] = 'utf8';
    $db['emporium']['dbcollat'] = 'utf8_general_ci';
    $db['emporium']['swap_pre'] = '';
    $db['emporium']['autoinit'] = TRUE;
    $db['emporium']['stricton'] = FALSE;   	
	
    // Conexão SQL Server    
    $db['mssql']['hostname'] = '10.2.1.21';
    $db['mssql']['username'] = 'admin';
    $db['mssql']['password'] = '@dminDAVO';
    $db['mssql']['database'] = 'dbo_cre';
    $db['mssql']['dbdriver'] = 'mssql';
    $db['mssql']['dbprefix'] = '';
    $db['mssql']['pconnect'] = TRUE;
    $db['mssql']['db_debug'] = FALSE;
    $db['mssql']['cache_on'] = FALSE;
    $db['mssql']['cachedir'] = '';
    $db['mssql']['char_set'] = 'utf8';
    $db['mssql']['dbcollat'] = 'utf8_general_ci';
    $db['mssql']['swap_pre'] = '';
    $db['mssql']['autoinit'] = TRUE;
    $db['mssql']['stricton'] = FALSE;   	

  break;
  
}

$active_record = TRUE;


//$db['local']['hostname'] = '10.2.1.141';  
//$db['local']['username'] = 'root';
$db['local']['hostname'] = 'localhost';
$db['local']['username'] = 'root';  
$db['local']['password'] = '';
$db['local']['database'] = 'satelite'; 
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = '';
$db['local']['pconnect'] = TRUE;
$db['local']['db_debug'] = FALSE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_general_ci';
$db['local']['swap_pre'] = '';
$db['local']['autoinit'] = TRUE;
$db['local']['stricton'] = FALSE;

$db['qas']['hostname'] = '10.2.1.142';  
$db['qas']['username'] = 'criare_davo';
$db['qas']['password'] = 'tCn9w8vH';
$db['qas']['database'] = 'Satelite';
$db['qas']['dbdriver'] = 'mysql';
$db['qas']['dbprefix'] = '';
$db['qas']['pconnect'] = TRUE;
$db['qas']['db_debug'] = FALSE;
$db['qas']['cache_on'] = FALSE;
$db['qas']['cachedir'] = '';
$db['qas']['char_set'] = 'utf8';
$db['qas']['dbcollat'] = 'utf8_general_ci';
$db['qas']['swap_pre'] = '';
$db['qas']['autoinit'] = TRUE;
$db['qas']['stricton'] = FALSE;

$db['prd']['hostname'] = '10.2.1.42';
$db['prd']['username'] = 'criare_davo';
$db['prd']['password'] = 'tCn9w8vH';
$db['prd']['database'] = 'Satelite';
$db['prd']['dbdriver'] = 'mysql';
$db['prd']['dbprefix'] = '';
$db['prd']['pconnect'] = TRUE;
$db['prd']['db_debug'] = FALSE;
$db['prd']['cache_on'] = FALSE;
$db['prd']['cachedir'] = '';
$db['prd']['char_set'] = 'utf8';
$db['prd']['dbcollat'] = 'utf8_general_ci';
$db['prd']['swap_pre'] = '';
$db['prd']['autoinit'] = TRUE;
$db['prd']['stricton'] = FALSE;

/* ========================================================================
 *  Fim Seleciona Servidor BD Intranet
 * ======================================================================== */


/* End of file database.php */
/* Location: ./application/config/database.php */