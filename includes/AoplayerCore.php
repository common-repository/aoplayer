<?php 
class AoplayerCore
{	
	public $settings;
	
	public function __construct()
	{
		$config_path = realpath(AOPP_AOPLAYER_DIR) . DIRECTORY_SEPARATOR . 'config.php';
		if (file_exists($config_path)) {
			$this->settings = require($config_path);
		}
		
		$this->settings['view_path'] =  realpath(AOPP_AOPLAYER_DIR) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
	}
	
	/**
	 * getAdmin()
	 */
	public function wpPlayer()
	{
		for ($i=1; $i<=10; $i++){
			add_shortcode('aopp-player-'.$i, [$this, 'aopp_player']);
		}
	}
	
	/**
	 * aopp_player()
	 */
	public function aopp_player($player, $source = null, $tag)
	{
		self::resourceRegistration();
		
		$player = shortcode_atts([
			'showplaylist' => $this->settings['player']['showplaylist'], 
			'width' => $this->settings['player']['width'], 
			'height' => $this->settings['player']['height'], 
			'controls' => $this->settings['player']['controls'],
			'preload' => $this->settings['player']['preload'],
			'contenttype' => $this->settings['player']['contenttype'],
			'playlistposition' => $this->settings['player']['playlistposition'],
			'autoplay' => $this->settings['player']['autoplay'],
			'orderbutton' => $this->settings['player']['orderbutton'],
			'orderbuttonposition' => $this->settings['player']['orderbuttonposition'],
			'orderbuttonlink' => $this->settings['player']['orderbuttonlink'],
			'orderbuttontitle' => $this->settings['player']['orderbuttontitle'],
			'orderbuttoncolor' => $this->settings['player']['orderbuttoncolor'],
			'orderbuttontime' => $this->settings['player']['orderbuttontime'],
			'autoplaysound' => $this->settings['player']['autoplaysound'],
			'orderbuttonfontsize' => $this->settings['player']['orderbuttonfontsize'],
			'orderbuttonleft' => $this->settings['player']['orderbuttonleft'],
			'orderbuttonright' => $this->settings['player']['orderbuttonright'],
			'positionplayer' => $this->settings['player']['positionplayer'],
			'controls_navigation' => $this->settings['player']['controls_navigation'],
		], $player);

		$source = self::parseSource($source);
		
		wp_enqueue_style('aopp_plugin_css');
		wp_enqueue_style('aopp_plugin_playlist_css');
		wp_enqueue_style('aopp_plugin_speed_css');
		wp_enqueue_style('aopp_css');	

		$css = '';
		
		if ($player['width']=='100%') {
			$css .= '
				position: relative;
				width:100%;
				max-width:'.$player['width'].';
			';
		} else {
			$player['width'] = (int) $player['width'];
			$css .= '
				position: relative;
				width:100%;
				max-width:'.$player['width'].'px;
			';
		}

		if ($player['positionplayer']=='center') {
			$css .= '
				margin:0 auto 0 auto;
			';
		} elseif ($player['positionplayer']=='left') {
			$css .= '
				margin:0 auto 0 0;
			';
		} elseif ($player['positionplayer']=='right') {
			$css .= '
				margin:0 0 0 auto;
			';
		}
		
		$css = '
			.aopp_wrap_video{
				'.$css.'
			}
			.'.$tag.' iframe{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		';

		$css .= '
			@media (max-width: 767px) {
				.aopp_wrap_video{
					min-width:280px;
				}
				.'.$tag.' iframe{
					min-width:280px;
				}
			}
		';
	
		if ($player['width']>768 || $player['width']=='100%') {
			$css .= '
				@media (min-width: 768px)  and (max-width: 1024px) {
					.aopp_wrap_video{
						min-width:640px;
					}
					.'.$tag.' iframe{
						min-width:640px;
					}
				}	
			';
		}

		wp_register_style('responsive-player', false);
		wp_enqueue_style('responsive-player');
		wp_add_inline_style('responsive-player', $css);
		
		wp_enqueue_script('aopp_plugin_js');
		wp_enqueue_script('aopp_plugin_localize_js');
		wp_enqueue_script('aopp_plugin_playlist_js');
		wp_enqueue_script('aopp_plugin_speed_js');
		
		$showplaylist = 'data-showplaylist="false"';
		$class_playlist = '';
		$class_pl_position = '';
		if ($player['showplaylist']=='true') {
			$class_playlist = 'mep-playlist';
			$showplaylist = 'data-showplaylist="true"';

			if ($player['playlistposition']=='top') {
				$class_pl_position = '';
			} elseif ($player['playlistposition']=='left') {
				$class_pl_position = '';
			} elseif ($player['playlistposition']=='right') {
				$class_pl_position = '';
			} elseif ($player['playlistposition']=='bottom') {
				$class_pl_position = 'video_bottom';
			}
		} 

		/*
		$width = ' width="'.$this->settings['player']['width'].'" ';
		if (!empty($player['width'])) {
			$width = 'width="'.$player['width'].'"';
		} 
		
		$height = '';
		if (!empty($player['height'])) {
			$height = 'height="'.$player['height'].'"';
		}
		*/
		
		$controls = 'controls="'.$this->settings['player']['controls'].'"';
		if ($player['controls']=='controls') {
			$controls = 'controls="controls"';
		}
	
		$autoplay = '';
		if ($player['autoplay']=='true') {
			$autoplay = ' autoplay muted ';
		}
		
		$preload = 'preload="'.$this->settings['player']['preload'].'"';
		if (!empty($player['preload'])) {
			$preload = 'preload="'.$player['preload'].'"';
		}
		
		$poster = '';
		if (!empty($player['poster'])) {
			$poster = 'poster="'.$player['poster'].'"';
		}

		if (empty($player['autoplaysound'])) {
			$player['autoplaysound'] = $this->settings['player']['autoplaysound'];
		}
		
		if (empty($player['orderbutton'])) {
			$player['orderbutton'] = $this->settings['player']['orderbutton'];
		}
		
		if (empty($player['orderbuttonposition'])) {
			$player['orderbuttonposition'] = $this->settings['player']['orderbuttonposition'];
		}
		
		if (empty($player['orderbuttonlink'])) {
			$player['orderbuttonlink'] = $this->settings['player']['orderbuttonlink'];
		}
		
		if (empty($player['orderbuttontitle'])) {
			$player['orderbuttontitle'] = $this->settings['player']['orderbuttontitle'];
		}
		
		if (empty($player['orderbuttoncolor'])) {
			$player['orderbuttoncolor'] = $this->settings['player']['orderbuttoncolor'];
		}
		
		if (empty($player['orderbuttontime'])) {
			$player['orderbuttontime'] = $this->settings['player']['orderbuttontime'];
		}
		
		if (empty($player['orderbuttonfontsize'])) {
			$player['orderbuttonfontsize'] = $this->settings['player']['orderbuttonfontsize'];
		}
		
		if (empty($player['orderbuttonleft'])) {
			$player['orderbuttonleft'] = $this->settings['player']['orderbuttonleft'];
		}

		if (empty($player['orderbuttonright'])) {
			$player['orderbuttonright'] = $this->settings['player']['orderbuttonright'];
		}
		
		if (empty($player['controls_navigation']) && $player['controls_navigation']!=0) {
			$player['controls_navigation'] = $this->settings['player']['controls_navigation'];
		}

		add_action('print_footer_scripts', 
			function() use ($player, $tag) { 
				self::aoplayer_script($player, $tag); 
			}
		);

		if ($player['contenttype'] == 'video') {

			$html = '<video class="'.$tag.' '.$class_playlist.' '.$class_pl_position.'" '.$autoplay.' width="100%" height="auto" '.$showplaylist.' '.$controls.' '.$preload.' '.$poster.'>';

				if (!empty($source) && is_array($source)) {
					foreach ($source as $data) { 
						
						if (empty($data['link'])) {
							continue;
						} else {
							$src = 'src="'.$data['link'].'" data-src="'.$data['link'].'"';
						}
						
						$poster = '';
						if (!empty($data['poster'])) {
							$poster = 'data-poster="'.$data['poster'].'" data-aopp-im="'.$data['poster'].'"';
						}
						
						$type = '';
						if (empty($data['type'])) {
							continue;
						} else {
							$type = 'type="'.$data['type'].'"';
						}
						
						$title = '';
						if (!empty($data['title'])) {
							$title = 'title="'.$data['title'].'"';
						}

						$html .= '<source '.$src.' '.$poster.' '.$type.' '.$title.'>';
					}
				} 

			$html .= '</video>';

		} elseif ($player['contenttype'] == 'audio') {

			$html = '<audio  class="'.$tag.' '.$class_playlist.' '.$class_pl_position.'" '.$autoplay.' width="100%" height="auto" '.$showplaylist.' '.$controls.' '.$preload.'>';
 
			if (!empty($source) && is_array($source)) {
				foreach ($source as $data) {	
					if (empty($data['link'])) {
						continue;
					} else {
						$src = 'src="'.$data['link'].'" data-src="'.$data['link'].'"';
					}
						
					$poster = '';
					if (!empty($data['poster'])) {
						$poster = 'data-poster="'.$data['poster'].'" data-aopp-im="'.$data['poster'].'"';
					}
						
					$type = '';
					if (empty($data['type'])) {
						continue;
					} else {
						$type = 'type="'.$data['type'].'"';
					}
						
					$title = '';
					if (!empty($data['title'])) {
						$title = 'title="'.$data['title'].'"';
					}

					$html .= '<source '.$src.' '.$poster.' '.$type.' '.$title.'>';
				}
			}

			$html .= '</audio>';
			
		} else {
			$html = '';
		}
		
		return '<div class="aopp_wrap_video">'.$html.'</div>';
	}
	
	/**
	 * parseSource($source)
	 */
	protected function parseSource($source='')
	{
		if (empty($source)) {
			return $source;
		}
		
		$source = strip_tags($source);
		$source = preg_replace('/(\&#187;|\&#8243;|\&#148;|\&#147;|\&#8221;|amp;)/i', '"', $source);
		$source = preg_replace('/[\r\n\s]{1,}/i', ' ', $source);
		$source = preg_replace('/[\s\]]+\]/i', ']', $source);
		preg_match_all('/([aopp-source[\s]{1,}(link=\"(.*?)\"[\s]{1,}poster=\"(.*?)\"[\s]{1,}title=\"(.*?)\"[\s]{1,}type=\"(.*?)\")\])/i', $source, $src);
		$new_source = [];
		for ($i=0; $i<count($src[3]); $i++) {
			$new_source[] = [
				'link' => $src[3][$i],
				'poster' => $src[4][$i],
				'title' => $src[5][$i],
				'type' => $src[6][$i],
			];
		}

		return $new_source;	
	}
	
	public function aoplayer_script($player, $tag) 
	{
		$order_html = '';
		if (
			$player['orderbutton']=='true' && 
			!empty($player['orderbuttonlink']) && 
			filter_var($player['orderbuttonlink'], FILTER_VALIDATE_URL)
		) { 
			$position_ext = ['topleft','topright','topcenter','bottomleft','bottomright','bottomcenter','leftcenter','rightcenter','center'];
			if (empty($player['orderbuttonposition']) || !in_array($player['orderbuttonposition'], $position_ext)) {
				$player['orderbuttonposition'] = 'center';
			}
			
			$color_ext = ['default','info','primary','warning','danger','success'];
			if (empty($player['orderbuttoncolor']) || !in_array($player['orderbuttoncolor'], $color_ext)) {
				$player['orderbuttoncolor'] = 'default';
			}
			
			$len = (iconv_strlen($player['orderbuttontitle'], 'UTF-8')*8)/2;

			if ($player['orderbuttonposition']=='topleft') {
				$style = 'position:absolute;z-index:9990;left:'.$player['orderbuttonleft'].'px;top:4px';
			} elseif ($player['orderbuttonposition']=='topright') {
				$style = 'position:absolute;z-index:9990;right:'.$player['orderbuttonright'].'px;top:4px';
			} elseif ($player['orderbuttonposition']=='topcenter') {
				$style = 'position:absolute;z-index:9990;left:50%;margin-left:-'.$len.'px;top:4px';
			} elseif ($player['orderbuttonposition']=='bottomleft') {
				$style = 'position:absolute;z-index:9990;left:'.$player['orderbuttonleft'].'px;bottom:30px';
			} elseif ($player['orderbuttonposition']=='bottomright') {
				$style = 'position:absolute;z-index:9990;right:'.$player['orderbuttonright'].'px;bottom:30px';
			} elseif ($player['orderbuttonposition']=='bottomcenter') {
				$style = 'position:absolute;z-index:9990;left:50%;margin-left:-'.$len.'px;bottom:30px';
			} elseif ($player['orderbuttonposition']=='leftcenter') {
				$style = 'position:absolute;z-index:9990;left:'.$player['orderbuttonleft'].'px';
			} elseif ($player['orderbuttonposition']=='rightcenter') {
				$style = 'position:absolute;z-index:9990;right:'.$player['orderbuttonright'].'px';
			} else {
				$style = '';
			}
				
			$order_html .= '<div class="mejs__overlay-order" style="display:none;width: 100%; height: 100%;">';
			$order_html .= '<a style="font-size:'.$player['orderbuttonfontsize'].'px;'.$style.'" class="aopp-btn aopp-btn-'.$player['orderbuttoncolor'].'" href="'.$player['orderbuttonlink'].'" target="_blank">'.$player['orderbuttontitle'].'</a>';
			$order_html .= '</div>';
		}

		$warning_html = '';
		if ($player['autoplay']=='true' && $player['autoplaysound']=='true') { 
			$warning_html .= '<div class="mejs__overlay-warning" style="width: 100%; height: 100%;">';
			$warning_html .= '<div style="position:absolute;left:4px;top:4px" class="aopp-warning aopp-btn aopp-btn-danger">'.__('Sound on', 'aoplayer').'</div>';
			$warning_html .= '</div>';
		}
		
		if ($player['controls']=='controls') {
			
			$features = "[";
			$features .= "'playlistfeature', ";

			if ($player['controls_navigation']===true || $player['controls_navigation']=='true' || $player['controls_navigation']==1) {
				$features .= "'nexttrack', ";
			}
			
			$features .= "'playpause', ";
			
			if ($player['controls_navigation']===true || $player['controls_navigation']=='true' || $player['controls_navigation']==1) {
				$features .= "'prevtrack', ";
			}
			
			$features .= "'loop', 'current', 'progress', 'duration', 'volume', 'fullscreen', 'speed'";
			$features .= "]";
		} else {
			$features = "[]";
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				console.log(<?=$player['controls_navigation']?>)
				
				
				mejs.i18n.language('ru');
				$('.<?=$tag?>').mediaelementplayer({
					features: <?=$features?>,
					shuffle: false,
					loop: false,
					loopplaylist: true,
					speeds: ['0.50', '0.75', '1.00',  '1.25', '1.50', '2.00'],
					pluginPath: "<?=AOPP_AOPLAYER_URL?>assets/mediaelement/player/",
					id: '<?=$tag?>',
					clickToPlayPause: true,
					
					<?php if ($player['width']=='100%') : ?>
					videoWidth: '<?=$player['width']?>',
					videoHeight: '<?=$player['width']?>',
					enableAutosize: true,
					<?php endif; ?>
					
					success: function(mediaElement, domObject) {
						var control = $('.mejs__controls');
						control.find('.mejs__prevtrack-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.prevText']);
						control.find('.mejs__nexttrack-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.nextText']);
						control.find('.mejs__loop-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.loopText']);
						control.find('.mejs__fullscreen-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.fullscreenText']);
						control.find('.mejs__shuffle-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.shuffleText']);
						control.find('.mejs__playlist-button>button').attr('title', mejs.i18n[mejs.i18n.language()]['mejs.playlistText']);

						var vid = jQuery('video.<?=$tag?>');
						var mejs_container = vid.parents('.mejs__container');
						
						var mejs__layers = mejs_container.find('.mejs__inner>.mejs__layers');
						if (mejs__layers && typeof mejs__layers !== "undefined") {
							mejs__layers.append('<?=$order_html?><?=$warning_html?>');
							mediaElement.addEventListener('timeupdate', function() {
								setTimeout(function() {
									if (mediaElement.currentTime==0) {
										mejs_container.find('.mejs__overlay-warning').remove();
										mediaElement.setVolume(1);
										mediaElement.muted = false;
									}
								}, 1000);
							}, false);
						}
						
						var time = <?=$player['orderbuttontime']?>;
						mediaElement.addEventListener('timeupdate', function() {
							if (mediaElement.currentTime>time) {
								mejs_container.find('.mejs__overlay-order').fadeIn(500);
							}
						}, false);
						
						mejs_container.find('.aopp-warning').on('click', function(){
							mejs_container.find(".mejs__overlay-warning").fadeOut(500, function(){
								mejs_container.find(".mejs__overlay-warning").remove();
							});
							mediaElement.setVolume(1);
							mediaElement.muted = false;
							
						});

						mejs_container.find(".mejs__overlay-order").on("click", function(e){
							mejs_container.find(".mejs__overlay-order").remove();
							domObject.pause();
						});
						
						mejs_container.find(".mejs__overlay-warning").on("click", function(e){
							domObject.play();
						});

						mediaElement.addEventListener('play', function() {
							
						}, false);

						mediaElement.addEventListener('pause', function() {            
							
						}, false);
		
						var ratio = 640/360;
						var container = vid.parents('.mejs__container').width();
						if (container && typeof container !== "undefined") {
							if (ratio < 1) {
								var newheight = container * ratio;
							} else {
								var newheight = container / ratio;
							}
						}

						if (newheight && typeof newheight !== "undefined") {
							vid.parents('.mejs__container').height(Math.round(newheight) + 'px');
							var overlay_height = Math.round(newheight);
							vid.parents('.mejs__container').find('.mejs__overlay').height(Math.round(newheight) + 'px');
							vid.parents('.mejs__container').find('.mejs__layers').height(Math.round(newheight) + 'px');
						} else {
							var overlay_height = vid.parents('.mejs__container').find('.mejs__poster.mejs__layer').height();
						}
			
						if (overlay_height && typeof overlay_height !== "undefined") {
							vid.parents('.mejs__container').find('.mejs__playlist.mejs__layer').css('top', overlay_height+'px');
						}
									
						var height = vid.parents('.mejs__container').find('ul.mejs').height();
						if (height && typeof height !== "undefined") {
							vid.parents('.mejs__container').find('.mep-playlist.video_bottom').css('margin-bottom', height+'px');
						}

						var video_poster = vid.find('source:nth-child(1)').attr('data-aopp-im');
						if (video_poster && typeof video_poster !== "undefined") {
							vid.parents('.mejs__container').find('video.<?=$tag?>').attr('poster',video_poster);
							vid.parents('.mejs__container').find('video.<?=$tag?>').attr('data-poster',video_poster);
						}	
					},
				
					error: function() {
						console.log('Error setting media!');
					}
				});	
			});
		</script>
	<?php 
	}
	
	/**
	 * resourceRegistration()
	 */
	public function resourceRegistration() 
	{
		wp_enqueue_script('jquery');
		
		if (AOPP_DEBUG) {
			wp_register_style('aopp_plugin_css', plugins_url('assets/mediaelement/player/mediaelementplayer.css', dirname(__FILE__)));
			wp_register_style('aopp_plugin_playlist_css', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.css', dirname(__FILE__)));
			wp_register_style('aopp_plugin_speed_css', plugins_url('assets/mediaelement/plugins/speed/speed.css', dirname(__FILE__)));
			wp_register_style('aopp_css', plugins_url('assets/css/style.css', dirname(__FILE__)));
				
			wp_register_script('aopp_plugin_js', plugins_url('assets/mediaelement/player/mediaelement-and-player.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_localize_js', plugins_url('assets/mediaelement/player/lang/ru.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_playlist_js', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_speed_js', plugins_url('assets/mediaelement/plugins/speed/speed.js', dirname(__FILE__)));
		} else {
			wp_register_style('aopp_plugin_css', plugins_url('assets/mediaelement/player/mediaelementplayer.min.css', dirname(__FILE__)));
			wp_register_style('aopp_plugin_playlist_css', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.min.css', dirname(__FILE__)));
			wp_register_style('aopp_plugin_speed_css', plugins_url('assets/mediaelement/plugins/speed/speed.min.css', dirname(__FILE__)));
			wp_register_style('aopp_css', plugins_url('assets/css/style.min.css', dirname(__FILE__)));

			wp_register_script('aopp_plugin_js', plugins_url('assets/mediaelement/player/mediaelement-and-player.min.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_localize_js', plugins_url('assets/mediaelement/player/lang/min.ru.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_playlist_js', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.min.js', dirname(__FILE__)));
			wp_register_script('aopp_plugin_speed_js', plugins_url('assets/mediaelement/plugins/speed/speed.min.js', dirname(__FILE__)));
		}
	}

	/**
	 * aomailer($className=__CLASS__)
	 */ 
	public static function aopp($className=__CLASS__)
	{
		return new $className();
	}
}
