<?php
wp_enqueue_style('aopp_bootstrap_min_css', plugins_url('assets/css/bootstrap-3.3.7.min.css', dirname(__FILE__)));
wp_enqueue_style('aopp_fontawesom_min_css', plugins_url('assets/css/font-awesome-4.7.0.min.css', dirname(__FILE__)));
			
if (AOPP_DEBUG) {
	wp_enqueue_style('aopp_plugin_css', plugins_url('assets/mediaelement/player/mediaelementplayer.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_plugin_playlist_css', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_plugin_speed_css', plugins_url('assets/mediaelement/plugins/speed/speed.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_css', plugins_url('assets/css/style.css', dirname(__FILE__)));
} else {
	wp_enqueue_style('aopp_plugin_css', plugins_url('assets/mediaelement/player/mediaelementplayer.min.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_plugin_playlist_css', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.min.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_plugin_speed_css', plugins_url('assets/mediaelement/plugins/speed/speed.min.css', dirname(__FILE__)));
	wp_enqueue_style('aopp_css', plugins_url('assets/css/style.min.css', dirname(__FILE__)));
}

wp_enqueue_script('jquery');
wp_enqueue_script('aopp_bootstrap_min_js', plugins_url('assets/js/bootstrap3.3.7.min.js', dirname(__FILE__)));

if (AOPP_DEBUG) {
	wp_enqueue_script('aopp_plugin_js', plugins_url('assets/mediaelement/player/mediaelement-and-player.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_localize_js', plugins_url('assets/mediaelement/player/lang/ru.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_playlist_js', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_speed_js', plugins_url('assets/mediaelement/plugins/speed/speed.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_script_js', plugins_url('assets/js/script.js',dirname(__FILE__)));
} else {
	wp_enqueue_script('aopp_plugin_js', plugins_url('assets/mediaelement/player/mediaelement-and-player.min.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_localize_js', plugins_url('assets/mediaelement/player/lang/min.ru.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_playlist_js', plugins_url('assets/mediaelement/plugins/playlist-rocco/mediaelement-playlist-plugin.min.js', dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_speed_js', plugins_url('assets/mediaelement/plugins/speed/speed.min.js',dirname(__FILE__)));
	wp_enqueue_script('aopp_plugin_script_js', plugins_url('assets/js/script.min.js', dirname(__FILE__)));
}
?>

<div id="aopp-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="color:red"><?=__('Warning', 'aoplayer')?></h4>
			</div>
			<div class="modal-body">
				<p><?=__('Warning Deleted Template', 'aoplayer')?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-xs-block" data-dismiss="modal"><?=__('No', 'aoplayer')?></button>
				<button id="aopp-delete-template-confirm" type="button" class="btn btn-danger btn-xs-block"><?=__('Yes', 'aoplayer')?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="aopp-page-player" class="container-fluid">

	<div id="aopp-overlay"></div>
	<i id="aopp-loader" class="fa fa-cog fa-spin fa-fw"></i>
	
	<div class="masthead">
		
		<h3 class="text-muted">
			<img src="<?=$this->settings['logo']?>" alt="logo" class="" width="50"><br><br>
			<?=__('Player AvtoOfis.Video', 'aoplayer')?>
		</h3>
		
    </div>
	
	<div class="row">
		<div class="col-sm-12">
			
			<ul class="nav nav-tabs" id="settings-tab">
				<li class="active">
					<a href="#aopp-player" data-toggle="tab">
						<i class="fa fa-cogs" aria-hidden="true"></i> <?=__('Constructor', 'aoplayer')?>
					</a>
				</li>
			</ul>
			
		</div>
	</div>
	
	<p class="clearfix"></p>

	<div class="tab-content">
		<div class="tab-pane fade in active" id="aopp-player">
		
			<?php require_once __DIR__ . '/page_admin/__player.php'; ?>
			
		</div>
	</div>
	
</div>
