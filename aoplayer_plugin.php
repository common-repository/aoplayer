<?php
/*
Plugin Name: Aoplayer
Plugin URI: https://www.autooffice24.ru/vse-zapisi/avtoofis-video-plagin-dlya-wordpress-dlya-vstavki-videopleera-alternativa-pleeru-youtube.html
Description: Плагин для вставки проигрывателя видеофайлов через shortcode. Тонкая настройка, поддержка плейлистов, возможность добавить кнопку (например, для заказа товара) прямо на видео. Отличная альтернатива стандартному плееру YouTube. Видео можно размещать на своём хостинге или Amazon S3, поддерживается формат mp4 
Author: Autooffice
Version: 1.0.15
Author URI: https://profiles.wordpress.org/autooffice#content-plugins
*/

define('AOPP_AOPLAYER_DIR', plugin_dir_path(__FILE__));
define('AOPP_AOPLAYER_URL', plugin_dir_url(__FILE__));
define('AOPP_DEBUG', false);

require_once __DIR__ . '/autoload.php';

load_plugin_textdomain('aoplayer', false, dirname(plugin_basename(__FILE__)) . '/lang/');

register_activation_hook(__FILE__, ['AoplayerAdmin', 'install']);
register_uninstall_hook(__FILE__, ['AoplayerAdmin', 'uninstall']);
register_deactivation_hook(__FILE__, ['AoplayerAdmin', 'deactivation']);

function aopp_aoplayer_load() {

	if (is_admin()) {
		
		$is_admin_page = false;
		if (!empty($_GET['page']) && preg_match('/aoplayer/i', $_GET['page'])) {
			$is_admin_page = true;
		}

		AoplayerAdmin::aopp($is_admin_page)->wpAdmin();
		
	} else {

		AoplayerCore::aopp()->wpPlayer();
		add_filter('the_content', 'do_shortcode', 11);
	}
}

add_action('plugins_loaded', 'aopp_aoplayer_load');