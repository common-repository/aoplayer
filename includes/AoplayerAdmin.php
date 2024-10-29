<?php
class AoplayerAdmin
{
	protected $page;
	protected $capability;
	protected $url;
	protected $functions_page;
	protected $view_path;
	protected $icons;
	protected $settings = [];
	protected $is_plugin_page;
	protected $position;

	public function __construct($is_plugin_page)
	{
		$this->page = __('Aoplayer', 'aoplayer');
		$this->capability = 'edit_others_pages';
		$this->url = 'aoplayer';
		$this->functions_page = 'aoplayer_page';
		$this->icons = AOPP_AOPLAYER_URL . 'assets/img/icon.png';
		$this->is_plugin_page = $is_plugin_page;
		$this->view_path =  realpath(AOPP_AOPLAYER_DIR) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
	}
	
	/**
	 * wpAdmin()
	 */
	public function wpAdmin()
	{
		add_action('admin_menu', [$this, 'aoplayer_menu']);
		add_action('wp_ajax_aopp_save_template', [$this, 'aopp_save_template']);
		add_action('wp_ajax_aopp_select_template', [$this, 'aopp_select_template']);
		add_action('wp_ajax_aopp_delete_template', [$this, 'aopp_delete_template']);
	}

	/**
	 * aomailer_settings_menu()
	 */
	public function aoplayer_menu()
	{
		add_menu_page( 
			$this->page, 
			$this->page,
			$this->capability, 
			$this->url, 
			[$this, $this->functions_page], 
			$this->icons, 
			$this->position 
		);
	}

	/**
	 * settings_page_sms()
	 */
	public function aoplayer_page()
	{
		if (!empty($this->is_plugin_page)) {
			$this->settings = self::loadSettings();
		}

		$this->settings['player']['width'] = 360;
		if (file_exists($this->view_path.'admin_page_player.php')) {
			require_once $this->view_path.'admin_page_player.php';
		}
	}
	
	/** 
	 * aoph_load_form_mailing()
	 */
	public function aopp_save_template()
	{
		$this->settings = self::loadSettings();
		
		// Validation token
		if (empty($_POST['token']) || $_POST['token']!==wp_get_session_token()) {
			$this->settings['error'] = __('Missing or expired token', 'aoplayer');
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}

		if (
			empty($_POST['data']) || 
			empty($_POST['data']['player']) || 
			!is_array($_POST['data']['player']) || 
			empty($_POST['data']['source']) || 
			!is_array($_POST['data']['source']) || 
			empty($_POST['data']['name']) 
		) {
			$this->settings['error'] = __('Missing required data', 'aoplayer');
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}
		
		$name = self::validate('name', $_POST['data']['name']);
		if (empty($name)) {
			$this->settings['error'] =__('Incorrect or missing template name', 'aoplayer');
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}
		
		$this->settings['template_name'] = $name;

		$id_template = self::validate('id', $_POST['id']);
		
		foreach ($_POST['data']['player'] as $key=>$value) {
			$this->settings['player'][$key] = self::validate($key, $value);
		}
		
		foreach ($_POST['data']['source'] as $index=>$source) {
			if (empty($source) || !is_array($source)) {
				continue;
			}
			
			foreach ($source as $key=>$value) {
				$this->settings['source'][$index][$key] = self::validate($key, $value);
			}
		}
		
		$post_data = [
			'post_content' => serialize(['player'=>$this->settings['player'], 'source'=>$this->settings['source']]),
			'post_title' => $name,
			'post_status' => 'draft',
			'post_type' => 'player_template',
			'post_author' => get_current_user_id(),
		];

		if (!empty($id_template) && empty($_POST['data']['new_template'])) {
			$post_data['ID'] = $id_template;
			$this->settings['template_id'] = $id_template;
			wp_update_post($post_data, $wp_error);
			if (!empty($wp_error)) {
				$this->settings['error'] =__('Error saving data', 'aoplayer');
				require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
				wp_die();
			} else {
				$this->settings['success'] =__('Success Save Data', 'aoplayer');
				require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
				wp_die();
			}
		} else {
			$old_posts = self::getQuery('title', $name);
			if (!empty($old_posts) && is_array($old_posts)) {	
				$old_post = $old_posts[0];
				if (!empty($old_post) && is_object($old_post) && !empty($old_post->ID)) {
					
					if (!empty($id_template)) {
						$this->settings['template_id'] = $old_post->ID;
					}

					$this->settings['error'] =__('A template with this name already exists', 'aoplayer');
					require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
					wp_die();
				}
			} 
			
			if (empty($old_post) && empty($old_post->ID)) {
				$this->settings['template_id'] = wp_insert_post($post_data, $wp_error);
				if (!empty($wp_error)) {
					$this->settings['error'] =__('Error saving data', 'aoplayer');
					require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
					wp_die();
				} else {
					$this->settings['success'] =__('Success Save Data', 'aoplayer');
					require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
					wp_die();
				}
			}	
		}

		$this->settings['error'] =__('Error saving data', 'aoplayer');
		require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
		wp_die();
	}
	
	/** 
	 * aopp_select_template()
	 */
	public function aopp_select_template()
	{
		$this->settings = self::loadSettings();
		
		// Validation token
		if (empty($_POST['token']) || $_POST['token']!==wp_get_session_token()) {
			$this->settings['error'] = __('Missing or expired token', 'aoplayer');
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}

		$id_template = self::validate('id', $_POST['id']);
		if (!empty($id_template)) {
			$template = self::getTemplate($id_template);
			$this->settings['template_name'] = $template['post_title'];
			$this->settings['template_id'] = $template['ID'];
			$data = unserialize($template['post_content']);
			if (empty($data) || !is_array($data)) {
				$this->settings['error'] = __('Missing data', 'aoplayer');
				require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
				wp_die();
			}
			
			$this->settings['player'] = $data['player'];
			$this->settings['source'] = $data['source'];
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		} else {
			$this->settings['player']['width'] = 360;
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}	
	}
	
	
	/** 
	 * aopp_delete_template()
	 */
	public function aopp_delete_template()
	{
		$this->settings = self::loadSettings();
		
		// Validation token
		if (empty($_POST['token']) || $_POST['token']!==wp_get_session_token()) {
			$this->settings['error'] = __('Missing or expired token', 'aoplayer');
			require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
			wp_die();
		}

		$id_template = self::validate('id', $_POST['id']);
		if (!empty($id_template)) {
			$post_data = [
				'post_status' => 'cancelled',
				'ID' => $id_template,
			];
		
			wp_update_post($post_data, $wp_error);
		
			if (!empty($wp_error)) {
				$this->settings['error'] =__('Error saving data', 'aoplayer');
				require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
				wp_die();
			} else {
				$this->settings['success'] =__('Success Save Data', 'aoplayer');
				$this->settings['player']['width'] = 360;
				require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
				wp_die();
			}
		}
		
		$this->settings['error'] =__('Missing data', 'aoplayer');
		require_once realpath(AOPP_AOPLAYER_DIR) . '/views/page_admin/__player.php'; 
		wp_die();
	}
	
	/*
	 * getTemplate()
	 */
	public function getTemplate($id=0)
	{
		if (empty($id)) {
			return [];
		}
		
		$template = get_post($id, ARRAY_A);
		
		if (empty($template) || !is_array($template)) {
			return [];
		}
		
		return $template;
	}
	
	/*
	 * getTemplate()
	 */
	public function getQuery($key=false, $value=false)
	{
		if (empty($key) || empty($value)) {
			return [];
		}
		
		$result = get_posts([
			$key => $value,
			'post_type'        => 'player_template',
			'suppress_filters' => true,
			'post_status'      => ['draft'],
			'numberposts'      => 1,
			'orderby'          => 'ID',
			'order'            => 'ASC',
		]);
		
		if (empty($result) || !is_array($result)) {
			return [];
		}
		
		return $result;
	}
	
	/*
	 * getTemplates()
	 */
	public function getTemplates()
	{
		$templates = get_posts([
			'post_type'        => 'player_template',
			'suppress_filters' => true,
			'post_status'      => ['draft'],
			'numberposts'      => -1,
		]);

		if (empty($templates) || !is_array($templates)) {
			return [];
		}
		
		return $templates;
	}

	/**
	 * validate() 
	 */
	public function validate($key, $str) 
	{
		if (!$this->validateStr($key) || empty($this->settings['rule'][$key])) {
			return false;
		}

		$method = 'validate'.ucfirst($this->settings['rule'][$key]);
		if (!method_exists($this, $method)) {
			return false;
		}

		return $this->$method($str);
	}
	
	/**
	 * loadSettings()
	 */
	private function loadSettings()
	{
		$config_path = realpath(AOPP_AOPLAYER_DIR) . '/config.php';
		if (file_exists($config_path)) {
			$settings = require($config_path);
		}
		
		$settings['logo'] = AOPP_AOPLAYER_URL . 'assets/img/logo.png';
		return $settings;
	}

	/**
	 * validateEmail()
	 */
	private function validateEmail($str='')
	{
		if (empty($str)) {
			return false;
		}
		
		if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
			return $str;
		}
		
		return false;
	}
	
	/**
	 * validateInt()
	 */
	private function validateInt($int=0)
	{
		return (int) $int;
	}
	
	/**
	 * validateBoolean()
	 */
	private function validateBoolean($boolean=false)
	{
		if ($boolean==='true' || $boolean===true) {
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	 * validateUrl()
	 */
	private function validateUrl($str='')
	{
		if (empty($str)) {
			return false;
		}
		
		if (filter_var($str, FILTER_VALIDATE_URL)) {
			return $str;
		}
		
		return false;
	}
	
	
	/**
	 * validateText()
	 */
	private function validateText($str='')
	{
		$str = strip_tags($str);
		$str = htmlentities($str);
		return $str;
	}
	
	/**
	 * validateStr()
	 */
	private function validateStr($str='')
	{
		$pattern = '/[a-z]/i';
		if (preg_match($pattern, $str)) {
			return $str;
		}

		return false;
	}
	
	/**
	 * validateStr()
	 */
	private function validateIntstr($str='')
	{
		$pattern = '/[a-z 0-9 \%\/]/i';
		if (preg_match($pattern, $str)) {
			return $str;
		}

		return false;
	}
	
	/**
	 * validateDate()
	 */
	private function validateDate($date='')
	{
		$pattern = '/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/i';
		if (preg_match($pattern, $date)) {
			return $date;
		}

		return false;
	}

	/**
	 * install()
	 */
	public static function install()
	{
		return true;
	}
	
	/**
	 * uninstall()
	 */
	public static function uninstall()
	{
		return true;
	}
	
	/**
	 * deactivation()
	 */
	public static function deactivation()
	{
		return true;
	}
	
	/**
	 * aomailer($className=__CLASS__)
	 */ 
	public static function aopp($is_plugin_page, $className=__CLASS__)
	{
		return new $className($is_plugin_page);
	}
}
