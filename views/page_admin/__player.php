<?php
$templates = self::getTemplates();
require_once __DIR__ . '/__js.php';
aoplayer_page($this->settings); 
?>

<div class="row message_output">
	<?php if (!empty($this->settings['error'])) : ?>
					
		<p class="alert alert-danger">
			<?=$this->settings['error']?>
		</p>
									
	<?php elseif (!empty($this->settings['success'])) : ?>
								
		<p class="alert alert-success">
			<?=$this->settings['success']?>
		</p>
								
	<?php endif; ?>
</div>

<div class="container-fluid">
	<div class="col-sm-6"></div>
	<div class="col-sm-6">
		<select name="Template[name]" id="Template_name" class="form-control">
			<option value=""><?=__('Choose template ...', 'aoplayer')?>
			<?php foreach ($templates as $template) : ?>
				<option <?=(!empty($this->settings['template_id']) && $template->ID==$this->settings['template_id']) ? 'selected' : ''?> value="<?=$template->ID?>"><?=$template->post_title?></option>
			<?php endforeach; ?>
		</select>		
	</div>
	<div class="clearfix" style="padding:20px"></div>
</div>

<div class="container-fluid" style="overflow:hidden">
	<div id="test_video" class="alert alert-default" style="overflow-y:auto"></div>
</div>
<div class="clearfix"></div>

<div class="notice notice-info">
	<p>
		<b><?=__('To output the player, you must add the generated shortcode to the page or to the entry', 'aoplayer')?></b> 
<pre id="aopp-shortcode" class="click_copy" style="white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;">
[aopp-player-0 contenttype="" showplaylist="" width="" height="" controls="" preload="" playlistposition="" autoplay="" autoplaysound="" orderbutton="" orderbuttonposition="" orderbuttonlink="" orderbuttontitle="" orderbuttoncolor="" orderbuttontime="" orderbuttonfontsize="" orderbuttonleft="" orderbuttonright="" positionplayer="" controls_navigation="true"] [aopp-source link="" poster="" title="" type=""] [/aopp-player-0]
</pre>
		<i class="fa fa-info-circle" aria-hidden="true" style="color:#37799f;font-size:16px"></i>
		<i><small><?=__('When you click on the shortcode, it will be selected and copied to the buffer', 'aoplayer')?></small></i>
	</p>
</div>
		
<div class="row">
	<div class="col-sm-12">
		<h4 class="text-center"><?=__('Shortcode Attributes', 'aoplayer')?></h4>
	</div>
</div>

<div class="row">

	<div class="col-sm-12">

		<div class="aopp_clone_block alert alert-warning">

			<div class="form-group">
				<div class="col-sm-4">
					<input type="number" name="Constructor[id]" id="Constructor_id" class="form-control" min="1" max="10" value="<?=$this->settings['player']['id']?>">
				</div>
				<label for="Constructor_id" class="col-sm-6 small">
					<?=__('Indicate which copy of the player on the page', 'aoplayer')?>
				</label>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[contenttype]" id="Constructor_contenttype" class="form-control" disabled>
						<option value="audio" <?=($this->settings['player']['contenttype']=='audio') ? 'selected' : ''?>><?=__('Audio', 'aoplayer')?></value>
						<option value="video" <?=($this->settings['player']['contenttype']=='video') ? 'selected' : ''?>><?=__('Video', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_contenttype" class="col-sm-6 small">
					<?=__('Player type', 'aoplayer')?>
				</label>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[showplaylist]" id="Constructor_showplaylist" class="form-control">
						<option value="true" <?=($this->settings['player']['showplaylist']=='true') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="false" <?=($this->settings['player']['showplaylist']=='false') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_showplaylist" class="col-sm-6 small">
					<?=__('Player showplaylist', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[playlistposition]" id="Constructor_playlistposition" class="form-control">
						<option value="top" <?=($this->settings['player']['playlistposition']=='top') ? 'selected' : ''?>><?=__('Top', 'aoplayer')?></value>
						<option value="left" <?=($this->settings['player']['playlistposition']=='left') ? 'selected' : ''?>><?=__('Left', 'aoplayer')?></value>
						<option value="right" <?=($this->settings['player']['playlistposition']=='right') ? 'selected' : ''?>><?=__('Right', 'aoplayer')?></value>
						<option value="bottom" <?=($this->settings['player']['playlistposition']=='bottom') ? 'selected' : ''?>><?=__('Bottom', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_playlistposition" class="col-sm-6 small">
					<?=__('Player playlistposition', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="text" name="Constructor[width]" id="Constructor_width" class="form-control" value="<?=$this->settings['player']['width']?>">
				</div>
				<label for="Constructor_width" class="col-sm-6 small">
					<?=__('Player Width', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="text" name="Constructor[height]" id="Constructor_height" class="form-control" value="<?=$this->settings['player']['height']?>">
				</div>
				<label for="Constructor_height" class="col-sm-6 small">
					<?=__('Player Height', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[controls]" id="Constructor_controls" class="form-control">
						<option value="controls" <?=($this->settings['player']['controls']=='controls') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="none" <?=($this->settings['player']['controls']=='none') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_controls" class="col-sm-6 small">
					<?=__('Player controls', 'aoplayer')?>
				</label>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[controls_navigation]" id="Constructor_controls_navigation" class="form-control">
						<option value="true" <?=($this->settings['player']['controls_navigation']=='true') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="false" <?=($this->settings['player']['controls_navigation']=='false') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_controls_navigation" class="col-sm-6 small">
					<?=__('Player controls_navigation', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[preload]" id="Constructor_preload" class="form-control">
						<option value="auto" <?=($this->settings['player']['preload']=='auto') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="none" <?=($this->settings['player']['preload']=='none') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_preload" class="col-sm-6 small">
					<?=__('Player preload', 'aoplayer')?><br>
					<small style="color:#666">(<?=__('Affects the display of the poster in the player', 'aoplayer')?>)</small>
				</label>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[autoplay]" id="Constructor_autoplay" class="form-control">
						<option value="true" <?=($this->settings['player']['autoplay']=='true') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="false" <?=($this->settings['player']['autoplay']=='false') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_autoplay" class="col-sm-6 small">
					<?=__('Player autoplay', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[autoplaysound]" id="Constructor_autoplaysound" class="form-control">
						<option value="true" <?=($this->settings['player']['autoplaysound']=='true') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="false" <?=($this->settings['player']['autoplaysound']=='false') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_autoplaysound" class="col-sm-6 small">
					<?=__('Player autoplaysound', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[orderbutton]" id="Constructor_orderbutton" class="form-control">
						<option value="true" <?=($this->settings['player']['orderbutton']=='true') ? 'selected' : ''?>><?=__('Yes', 'aoplayer')?></value>
						<option value="false" <?=($this->settings['player']['orderbutton']=='false') ? 'selected' : ''?>><?=__('No', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_orderbutton" class="col-sm-6 small">
					<?=__('Player orderbutton', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[orderbuttonposition]" id="Constructor_orderbuttonposition" class="form-control">
						<option value="topleft" <?=($this->settings['player']['orderbuttonposition']=='topleft') ? 'selected' : ''?>><?=__('TopLeft', 'aoplayer')?></value>
						<option value="topright" <?=($this->settings['player']['orderbuttonposition']=='topright') ? 'selected' : ''?>><?=__('TopRight', 'aoplayer')?></value>
						<option value="topcenter" <?=($this->settings['player']['orderbuttonposition']=='topcenter') ? 'selected' : ''?>><?=__('TopCenter', 'aoplayer')?></value>
						<option value="bottomleft" <?=($this->settings['player']['orderbuttonposition']=='bottomleft') ? 'selected' : ''?>><?=__('BottomLeft', 'aoplayer')?></value>
						<option value="bottomright" <?=($this->settings['player']['orderbuttonposition']=='bottomright') ? 'selected' : ''?>><?=__('BottomRight', 'aoplayer')?></value>
						<option value="bottomcenter" <?=($this->settings['player']['orderbuttonposition']=='bottomcenter') ? 'selected' : ''?>><?=__('BottomCenter', 'aoplayer')?></value>
						<option value="leftcenter" <?=($this->settings['player']['orderbuttonposition']=='leftcenter') ? 'selected' : ''?>><?=__('LeftCenter', 'aoplayer')?></value>
						<option value="rightcenter" <?=($this->settings['player']['orderbuttonposition']=='rightcenter') ? 'selected' : ''?>><?=__('RightCenter', 'aoplayer')?></value>
						<option value="center" <?=($this->settings['player']['orderbuttonposition']=='center') ? 'selected' : ''?>><?=__('Center', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_orderbuttonposition" class="col-sm-6 small">
					<?=__('Player orderbuttonposition', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="url" name="Constructor[orderbuttonlink]" id="Constructor_orderbuttonlink" class="form-control" value="<?=$this->settings['player']['orderbuttonlink']?>">
				</div>
				<label for="Constructor_orderbuttonlink" class="col-sm-6 small">
					<?=__('Player orderbuttonlink', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="text" name="Constructor[orderbuttontitle]" id="Constructor_orderbuttontitle" class="form-control" maxlength="20" value="<?=$this->settings['player']['orderbuttontitle']?>">
				</div>
				<label for="Constructor_orderbuttontitle" class="col-sm-6 small">
					<?=__('Player orderbuttontitle', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[orderbuttoncolor]" id="Constructor_orderbuttoncolor" class="form-control" style="color:#<?=$this->settings['style'][$this->settings['player']['orderbuttoncolor']]?>">
						<option value="default" style="color:#ccc" <?=($this->settings['player']['orderbuttoncolor']=='default') ? 'selected' : ''?>><?=__('Style Default', 'aoplayer')?></value>
						<option value="info" style="color:#1b6d85" <?=($this->settings['player']['orderbuttoncolor']=='info') ? 'selected' : ''?>><?=__('Style Info', 'aoplayer')?></value>
						<option value="primary" style="color:#122b40" <?=($this->settings['player']['orderbuttoncolor']=='primary') ? 'selected' : ''?>><?=__('Style Primary', 'aoplayer')?></value>
						<option value="warning" style="color:#985f0d" <?=($this->settings['player']['orderbuttoncolor']=='warning') ? 'selected' : ''?>><?=__('Style Warning', 'aoplayer')?></value>
						<option value="danger" style="color:#761c19" <?=($this->settings['player']['orderbuttoncolor']=='danger') ? 'selected' : ''?>><?=__('Style Danger', 'aoplayer')?></value>
						<option value="success" style="color:#4cae4c" <?=($this->settings['player']['orderbuttoncolor']=='success') ? 'selected' : ''?>><?=__('Style Success', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_orderbuttoncolor" class="col-sm-6 small">
					<?=__('Player orderbuttoncolor', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="number" name="Constructor[orderbuttontime]" id="Constructor_orderbuttontime" class="form-control" value="<?=$this->settings['player']['orderbuttontime']?>">
				</div>
				<label for="Constructor_orderbuttontime" class="col-sm-6 small">
					<?=__('Player orderbuttontime', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="number" name="Constructor[orderbuttonfontsize]" id="Constructor_orderbuttonfontsize" class="form-control" value="<?=$this->settings['player']['orderbuttonfontsize']?>">
				</div>
				<label for="Constructor_orderbuttonfontsizee" class="col-sm-6 small">
					<?=__('Player orderbuttonfontsize', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="number" name="Constructor[orderbuttonleft]" id="Constructor_orderbuttonleft" class="form-control" value="<?=$this->settings['player']['orderbuttonleft']?>">
				</div>
				<label for="Constructor_orderbuttonleft" class="col-sm-6 small">
					<?=__('Player orderbuttonleft', 'aoplayer')?>
				</label>
			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
					<input type="number" name="Constructor[orderbuttonright]" id="Constructor_orderbuttonright" class="form-control" value="<?=$this->settings['player']['orderbuttonright']?>">
				</div>
				<label for="Constructor_orderbuttonright" class="col-sm-6 small">
					<?=__('Player orderbuttonright', 'aoplayer')?>
				</label>
			</div>
			
				<div class="form-group">
				<div class="col-sm-4">
					<select name="Constructor[positionplayer]" id="Constructor_positionplayer" class="form-control">
						<option value="center" <?=($this->settings['player']['positionplayer']=='center') ? 'selected' : ''?>><?=__('Center', 'aoplayer')?></value>
						<option value="left" <?=($this->settings['player']['positionplayer']=='left') ? 'selected' : ''?>><?=__('Left', 'aoplayer')?></value>
						<option value="right" <?=($this->settings['player']['positionplayer']=='right') ? 'selected' : ''?>><?=__('Right', 'aoplayer')?></value>
					</select>
				</div>
				<label for="Constructor_positionplayer" class="col-sm-6 small">
					<?=__('Player positionplayer', 'aoplayer')?>
				</label>
			</div>

		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<h4 class="text-center"><?=__('Add Source', 'aoplayer')?></h4>
			</div>
		</div>
		
		<div id="aopp-source-player">
			
			<?php if (!empty($this->settings['source']) && is_array($this->settings['source'])) : ?>
			
				<?php foreach ($this->settings['source'] as $key=>$value) : ?>
					
					<div class="aopp_clone_block alert alert-info" data-id="<?=$key?>">
						
						<i class="fa fa-times pull-right aopp-delete-block" aria-hidden="true" style="font-size:20px;color:red;cursor:pointer;<?=empty($key) ? 'display:none;' : ''?>"></i>
						
						<div class="form-group">
							<label style="width:100%">
								<div class="col-sm-4">
									<input type="url" name="Source[][link]" data-type="link" style="font-weight:normal" class="form-control" value="<?=$value['link']?>">
								</div>
								<div class="col-sm-6 small">
									<?=__('Player Source link', 'aoplayer')?>
								</div>
							</label>
						</div>
						
						<div class="form-group">
							<label style="width:100%">
								<div class="col-sm-4">
									<input type="url" name="Source[][poster]" data-type="poster" style="font-weight:normal" class="form-control" value="<?=$value['poster']?>">
								</div>
								<div class="col-sm-6 small">
									<?=__('Player Source poster', 'aoplayer')?>
								</div>
							</label>
						</div>
						
						<div class="form-group">
							<label style="width:100%">
								<div class="col-sm-4">
									
									<?php if ($this->settings['player']['contenttype']=='audio') : ?>
									
										<select name="Source[][type]" data-type="type" class="form-control" style="font-weight:normal">
											<option value="audio/mp3" <?=($value['type']=='audio/mp3') ? 'selected' : ''?>>audio/mp3</value>
											<option value="audio/ogg" <?=($value['type']=='audio/ogg') ? 'selected' : ''?>>audio/ogg</value>
											<option value="audio/oga" <?=($value['type']=='audio/oga') ? 'selected' : ''?>>audio/oga</value>
											<option value="audio/wav" <?=($value['type']=='audio/wav') ? 'selected' : ''?>>audio/wav</value>
											<option value="audio/x-wav" <?=($value['type']=='audio/x-wav') ? 'selected' : ''?>>audio/x-wav</value>
											<option value="audio/wave" <?=($value['type']=='audio/wave') ? 'selected' : ''?>>audio/wave</value>
											<option value="audio/x-pn-wav" <?=($value['type']=='audio/x-pn-wav') ? 'selected' : ''?>>audio/x-pn-wav</value>
											<option value="audio/mpeg" <?=($value['type']=='audio/mpeg') ? 'selected' : ''?>>audio/mpeg</value>
											<option value="audio/youtube" <?=($value['type']=='audio/youtube') ? 'selected' : ''?>>audio/youtube</value>
											<option value="audio/rtmp" <?=($value['type']=='audio/rtmp') ? 'selected' : ''?>>audio/rtmp</value>
											<option value="audio/hls" <?=($value['type']=='audio/hls') ? 'selected' : ''?>>audio/hls</value>
										</select>
									
									<?php else : ?>
									
										<select name="Source[][type]" data-type="type" class="form-control" style="font-weight:normal">
											<option value="video/mp4" <?=($value['type']=='video/mp4') ? 'selected' : ''?>>video/mp4</value>
											<option value="video/webm" <?=($value['type']=='video/webm') ? 'selected' : ''?>>video/webm</value>
											<option value="video/ogg" <?=($value['type']=='video/ogg') ? 'selected' : ''?>>video/ogg</value>
											<option value="video/ogv" <?=($value['type']=='video/ogv') ? 'selected' : ''?>>video/ogv</value>
											<option value="video/youtube" <?=($value['type']=='video/youtube') ? 'selected' : ''?>>video/youtube</value>
											<option value="video/rtmp" <?=($value['type']=='video/rtmp') ? 'selected' : ''?>>video/rtmp</value>
											<option value="video/hls" <?=($value['type']=='video/hls') ? 'selected' : ''?>>video/hls</value>
										</select>
									
									<?php endif; ?>
									
								</div>
								<div class="col-sm-6 small">
									<?=__('Player Source Type', 'aoplayer')?>
								</div>
							</label>
						</div>
						
						<div class="form-group">
							<label style="width:100%">
								<div class="col-sm-4">
									<input type="text" name="Source[][title]" data-type="title" style="font-weight:normal" class="form-control" value="<?=$value['title']?>">
								</div>
								<div class="col-sm-6 small">
									<?=__('Player Source title', 'aoplayer')?>
								</div>
							</label>
						</div>
					</div>

				<?php endforeach; ?>
			
			<?php endif; ?>

		</div>
		
		<div class="form-group">
			<div class="col-sm-5" style="height:100px">
				<div class="clone_button">
					<i class="fa fa-plus pull-left" aria-hidden="true"></i>
				</div>
				<div class="speech_wrap hidden-xs">
					<p class="speech">
						<i style="color:#37799f" class="fa fa-info-circle" aria-hidden="true">
						</i><small> <?=__('Warning CloneBlock', 'aoplayer')?></small>
					</p>
				</div>
			</div>
			<div class="col-sm-7" style="height:100px">
				<div class="form-group aopp_inside">
					<label style="width:100%">
						<div class="input-group">	
							<?php if (!empty($this->settings['template_id'])) : ?>
							<span class="input-group-btn">
								<button id="aopp-delete-template" class="btn btn-danger btn-xs-block">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</button>
							</span>
							<?php endif; ?>
							<input type="text" name="Template[name]" style="font-weight:normal" class="form-control" placeholder="<?=__('Placeholder Template', 'aoplayer')?>" value="<?=!empty($this->settings['template_name']) ? $this->settings['template_name'] : ''?>" id="Template_change_name" required>
							
							<?php if (!empty($this->settings['template_id'])) : ?>
							<span class="input-group-addon">
								<input type="checkbox" name="Template[new]" style="height:18px;width:18px" id="Template_new">
							</span>
							
							<?php endif; ?>
							
							<span class="input-group-btn">
								<button id="aopp-save-template" class="btn btn-primary btn-xs-block">
									<i class="fa fa-floppy-o" aria-hidden="true"></i>
								</button>
							</span>
						</div>	
						
						<?php if (!empty($this->settings['template_id'])) : ?>

						<div class="speech_wrap hidden-xs" style="top:40px">
							<p class="speech">
								<i style="color:#37799f" class="fa fa-info-circle" aria-hidden="true">
								</i><small> <?=__('Warning Delete Template', 'aoplayer')?></small>
							</p>
						</div>
						
						<div class="speech_wrap" style="top:40px;right:40px">
							<p class="speech-right">
								<i style="color:#37799f" class="fa fa-info-circle" aria-hidden="true">
								</i><small> <?=__('Warning Save New Template', 'aoplayer')?></small>
							</p>
						</div>
						
						<?php endif; ?>
						
					</label>
					<div class="speech_wrap" style="top:50px;display:none">
						<p class="speech">
							<i style="color:#e6c302" class="fa fa-exclamation-triangle" aria-hidden="true">
							</i><small> <?=__('Warning Mising Date', 'aoplayer')?></small>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>