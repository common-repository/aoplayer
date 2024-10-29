<?php 

function aopp_autoloader($class_name) {
	if (strpos($class_name, 'Aoplayer')!==false) {
		$path = realpath(AOPP_AOPLAYER_DIR) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $class_name . '.php';
		if (file_exists($path) && !class_exists($class_name)) {	
			require_once $path;
		}
	}
}

spl_autoload_register('aopp_autoloader');