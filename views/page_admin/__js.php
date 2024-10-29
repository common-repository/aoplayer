<?php function aoplayer_page($settings) { ?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var id_template = 0;
			var player = {
				id: <?=$settings['player']['id']?>,
				contenttype: '<?=$settings['player']['contenttype']?>',
				showplaylist: '<?=$settings['player']['showplaylist']?>',
				width: '<?=$settings['player']['width']?>',
				height: '<?=$settings['player']['height']?>',
				controls: '<?=$settings['player']['controls']?>',
				preload: '<?=$settings['player']['preload']?>',
				playlistposition: '<?=$settings['player']['playlistposition']?>',
				positionplayer: '<?=$settings['player']['positionplayer']?>',
				autoplay: '<?=$settings['player']['autoplay']?>',
				autoplaysound: '<?=$settings['player']['autoplaysound']?>',
				orderbutton: '<?=$settings['player']['orderbutton']?>',
				orderbuttonposition: '<?=$settings['player']['orderbuttonposition']?>',
				orderbuttonlink: '<?=$settings['player']['orderbuttonlink']?>',
				orderbuttontitle: '<?=$settings['player']['orderbuttontitle']?>',
				orderbuttoncolor: '<?=$settings['player']['orderbuttoncolor']?>',
				orderbuttontime: '<?=$settings['player']['orderbuttontime']?>',
				orderbuttonfontsize: '<?=$settings['player']['orderbuttonfontsize']?>',
				orderbuttonleft: '<?=$settings['player']['orderbuttonleft']?>',
				orderbuttonright: '<?=$settings['player']['orderbuttonright']?>',
				controls_navigation: '<?=$settings['player']['controls_navigation']?>',
				settings: {
					id: '<?=__('Indicate which copy of the player on the page', 'aoplayer')?>',
					contenttype: '<?=__('Specify the type of player', 'aoplayer')?>',
					warningbutton: '<?=__('Sound on', 'aoplayer')?>',
					path: '<?=AOPP_AOPLAYER_URL?>',
				}
			};

			var source = {};
			
			<?php if (!empty($settings['source']) && is_array($settings['source'])) : ?>
			
				<?php foreach ($settings['source'] as $key=>$value) : ?>
					
					source[<?=$key?>] = {
						link: '<?=$value['link']?>',
						poster: '<?=$value['poster']?>',
						title: '<?=$value['title']?>',
						type: '<?=$value['type']?>',
					};
					
				<?php endforeach; ?>
			
			<?php endif; ?>

			var style = {
				default: '<?=$settings['style']['default']?>',
				info: '<?=$settings['style']['info']?>',
				primary: '<?=$settings['style']['primary']?>',
				warning: '<?=$settings['style']['warning']?>',
				danger: '<?=$settings['style']['danger']?>',
				success: '<?=$settings['style']['success']?>',
			}
			
			getTestPlayer(player, source);

			jQuery('#Constructor_id').on("keyup", function(e){
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.id = value;
					getTestPlayer(player, source);
					
				}
			});
			
			jQuery('#Constructor_contenttype').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.contenttype = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_showplaylist').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.showplaylist = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_width').on("keyup", function(e){
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.width = value;
				} else {
					player.width = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_height').on("keyup", function(e){
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.height = value;
				} else {
					player.height = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_controls').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.controls = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_controls_navigation').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.controls_navigation = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_preload').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.preload = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_playlistposition').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.playlistposition = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_positionplayer').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.positionplayer = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_autoplay').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.autoplay = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_autoplaysound').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.autoplaysound = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_orderbutton').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.orderbutton = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_orderbuttonposition').on("change", function(e){
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.orderbuttonposition = value;
					getTestPlayer(player, source);
				}
			});
			
			jQuery('#Constructor_orderbuttonlink').on('keyup', function() {
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.orderbuttonlink = value;
				} else {
					player.orderbuttonlink = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_orderbuttontitle').on('keyup', function() {
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.orderbuttontitle = value;
				} else {
					player.orderbuttontitle = '';
				}
				getTestPlayer(player, source);
			});

			jQuery('#Constructor_orderbuttoncolor').on('change', function() {
				var value = jQuery(this).val();
				if (value && typeof value !== "undefined") {
					player.orderbuttoncolor = value;
					getTestPlayer(player, source);
					jQuery('#Constructor_orderbuttoncolor').css('color', '#' + style[value]);
				}
			});
			
			jQuery('#Constructor_orderbuttontime').on('keyup', function() {
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.orderbuttontime = value;
				} else {
					player.orderbuttontime = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_orderbuttonfontsize').on('keyup', function() {
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.orderbuttonfontsize = value;
				} else {
					player.orderbuttonfontsize = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_orderbuttonleft').on('keyup', function() {
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.orderbuttonleft = value;
				} else {
					player.orderbuttonleft = '';
				}
				getTestPlayer(player, source);
			});
			
			jQuery('#Constructor_orderbuttonright').on('keyup', function() {
				var value = parseInt(jQuery(this).val(), 10);
				if (value && !isNaN(value)) {
					player.orderbuttonright = value;
				} else {
					player.orderbuttonright = '';
				}
				getTestPlayer(player, source);
			});

			jQuery(document).delegate('input[name*="Source"]', 'keyup', function(e){
				var name = jQuery(this).attr('name');
				if (name && typeof name !== "undefined") {
					name = name.replace(/(Source|\[|\])/g, '');
					var key = parseInt(jQuery(this).parents('.aopp_clone_block').attr('data-id'), 10);
					var value = jQuery(this).val();
					if (value && typeof value !== "undefined" && !isNaN(key)) {
					
						if (!source[key] || typeof source[key] === "undefined") {
							source[key] = {
								link: '',
								poster: '',
								title: '',
							}
						}
						
						source[key][name] = value;
						getTestPlayer(player, source);
					}
				}
			});
			
			jQuery(document).delegate('select[name*="Source"]', 'change', function(e){
				var name = jQuery(this).attr('name');				
				if (name && typeof name !== "undefined") {
					name = name.replace(/(Source|\[|\])/g, '');
					var key = parseInt(jQuery(this).parents('.aopp_clone_block').attr('data-id'), 10);
					var value = jQuery(this).val();
					
					console.log(value)
					
					
					
					if (value && typeof value !== "undefined" && !isNaN(key)) {
					
						if (!source[key] || typeof source[key] === "undefined") {
							source[key] = {
								type: '',
							}
						}
						
						source[key][name] = value;
						getTestPlayer(player, source);
					}
				}
			})

			jQuery('#aopp-save-template').on("click", function(e){
				var id = jQuery('#Template_name option:selected').val()
				if (id && !isNaN(id)) {
					id_template = id;
				}
				
				var template_name = jQuery('#Template_change_name').val();
				var new_template = 0;
				if (jQuery('#Template_new').prop('checked')) {
					new_template = 1;
				}

				if (template_name && typeof template_name !== "undefined") {
					var template = {
						name: template_name,
						player: player,
						source: source,
						new_template: new_template,
					}

					reloadForm('aopp_save_template', '<?=wp_get_session_token()?>', template, '<?=admin_url()?>', id_template);
					jQuery('html, body').animate({scrollTop: 0}, 500);
				} else {
					jQuery(this).parents('.aopp_inside').find('.speech_wrap').show().fadeOut(5000);
				}
			});

			jQuery('#Template_name').on('change', function() {
				var value = parseInt(jQuery(this).val(), 10);
				reloadForm('aopp_select_template', '<?=wp_get_session_token()?>', '', '<?=admin_url()?>', value);
				return false;
			});

			jQuery('#aopp-delete-template').on("click", function(e){
				$('#aopp-modal').modal('toggle');
			});
			
			jQuery('#aopp-delete-template-confirm').on("click", function(e){
				$('#aopp-modal').modal('hide');
				var id = jQuery('#Template_name option:selected').val();
				if (id && !isNaN(id)) {
					id_template = id;
				}
				
				reloadForm('aopp_delete_template', '<?=wp_get_session_token()?>', '', '<?=admin_url()?>', id_template);
				jQuery('html, body').animate({scrollTop: 0}, 500);
			});
			
			jQuery(document).delegate('.aopp-delete-block', "click", function(e){
				var value = parseInt(jQuery(this).parents('.aopp_clone_block').attr('data-id'), 10);
				if (value && !isNaN(value)) {
					delete source[value];
					jQuery(this).parents('.aopp_clone_block').remove();
				}
			});
		});
	</script>	
	
<?php } ?>