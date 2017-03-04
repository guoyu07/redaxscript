<?php
namespace Redaxscript;

error_reporting(E_ERROR || E_PARSE);

/* bootstrap */

include_once('includes/bootstrap.php');

/* header */

header_remove('x-powered-by');

/* get instance */

$config = Config::getInstance();

/* restrict access */

if ($config->get('env') !== 'production')
{
	include_once('templates/install/index.phtml');
}
else
{
	header('http/1.0 403 forbidden');
	exit;
}