<?php
$envArquivo = __DIR__ . './env.ini';
if (file_exists($envArquivo)) {
    $env = parse_ini_file($envArquivo); 
    define('HOSTNAME',$env['host']);
    define('USERNAME',$env['user']);
    define('PASSWORD',$env['password']);
    define('DATABASE',$env['database']);
} else {
    define('HOSTNAME',"autorack.proxy.rlwy.net");
    define('USERNAME',"root");
    define('PASSWORD',"tycqJViOKDszdZsbrvKtRevCmkQRSWiW");
    define('DATABASE',"agenda");
}
define('DB_HOST', HOSTNAME);
define('DB_USER', USERNAME);
define('DB_PASS', PASSWORD);
define('DB_NAME', DATABASE);
