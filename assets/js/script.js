function getTestPlayer(player, source) {
	if (typeof player !== 'object' || typeof source !== 'object') {
		return false;
	}

	player.id = parseInt(player.id, 10);
	if (!player.id || isNaN(player.id) || player.id<=0) {
		player.id = 1;
	} else if (player.id>10) {
		player.id = 10;
	}

	var tag = 'aopp-player-';
	if (player.id) {
		tag += player.id;
	}
			
	if (!player.contenttype || typeof player.contenttype === "undefined") {
		player.contenttype = 'video';
	}

	var showplaylist = 'data-showplaylist="false"';
	var class_playlist = '';
	var class_pl_position = '';
	if (player.showplaylist=='true' || player.showplaylist==1) {
		class_playlist = 'mep-playlist';
		showplaylist = 'data-showplaylist="true"';

		if (player.playlistposition=='top') {
			class_pl_position = '';
		} else if (player.playlistposition=='left') {
			class_pl_position = '';
		} else if (player.playlistposition=='right') {
			class_pl_position = '';
		} else if (player.playlistposition=='bottom') {
			class_pl_position = 'video_bottom';
		}
	} 

	var width = 'width=""';
	if (player.width) {
		width = 'width="' + player.width + '"';
	} 

	var height = 'height=""';
	if (player.height) {
		height = 'height="' + player.height + '"';
	}
			
	var controls = 'controls=""';
	if (player.controls=='controls') {
		controls = 'controls="controls"';
	}
	
	var autoplay = '';
	if (player.autoplay=='true') {
		autoplay = 'autoplay muted';
	}
					
	var preload = 'preload=""';
	if (player.preload) {
		preload = 'preload="' + player.preload + '"';
	}
					
	var positionplayer = 'positionplayer=""';
	if (player.positionplayer) {
		positionplayer = 'positionplayer="' + player.positionplayer + '"';
	}
					
	var poster = '';
	if (player.poster) {
		poster = 'poster="' + player.poster + '"';
	}

	var autoplaysound = false;
	if (player.autoplaysound) {
		autoplaysound = true;
	}

	var shortcode = '[aopp-player-' + player.id + ' contenttype="' + player.contenttype + '" showplaylist="' + player.showplaylist + '" width="' + player.width + '" height="' + player.height + '" controls="' + player.controls + '" preload="' + player.preload + '" playlistposition="' + player.playlistposition + '" autoplay="' + player.autoplay + '" autoplaysound="' + player.autoplaysound + '" orderbutton="' + player.orderbutton + '" orderbuttonposition="' + player.orderbuttonposition + '" orderbuttonlink="' + player.orderbuttonlink + '" orderbuttontitle="' + player.orderbuttontitle + '" orderbuttoncolor="' + player.orderbuttoncolor + '" orderbuttontime="' + player.orderbuttontime + '" orderbuttonfontsize="' + player.orderbuttonfontsize + '" orderbuttonleft="' + player.orderbuttonleft + '" orderbuttonright="' + player.orderbuttonright + '" positionplayer="' + player.positionplayer + '" controls_navigation="' + player.controls_navigation + '"]';

	var html = '';
			
	if (!player.id) {
		html = '<div class="alert alert-warning" style="margin-bottom:0">' + player.settings.id + '</div>';
	} else if (!player.contenttype) {
		html = '<div class="alert alert-warning" style="margin-bottom:0">' + player.settings.contenttype + '</div>';
	}
	
	var css = '';
	if (player.width=='100%') {
		css += 'width:' + player.width + ';';
	} else {
		css += 'width:' + player.width + 'px;';
	}

	if (player.positionplayer=='center') {
		css += 'margin:0 auto 0 auto;';
	} else if (player.positionplayer=='left') {
		css += 'margin:0 auto 0 0;';
	} else if (player.positionplayer=='right') {
		css += 'margin:0 0 0 auto;';
	}

	if (!html) {	
		if (player.contenttype == 'video') {

			html = '<video class="' + tag + ' ' + class_playlist + ' ' + class_pl_position + '" ' + autoplay + ' ' + width + ' ' + height + ' ' + showplaylist + ' ' + controls + ' ' + preload + ' ' + poster + ' ' + positionplayer + '>';

			jQuery.each(source, function(key, value) {

				if (value.link) {
					var src = 'src="' + value.link + '" data-src="' + value.link + '"';
				} else {
					return;
				}
										
				if (value.poster) {
					var poster = 'data-poster="' + value.poster + '" data-aopp-im="' + value.poster + '"';
				} else {
					var poster = '';
				}
										
				if (value.type) {
					var type = 'type="' + value.type + '"';
				} else {
					return;
				}
										
				if (value.title) {
					var title = 'title="' + value.title + '"';
				} else {
					var title = '';
				}

				html += '<source ' + src + ' ' + poster + ' ' + type + ' ' + title + '>';
				shortcode += '[aopp-source link="' + value.link + '" poster="' + value.poster + '" title="' + value.title + '" type="' + value.type + '"]';
			});

			html += '</video>';

		} else if (player.contenttype == 'audio') {

			html = '<audio class="' + tag + ' ' + class_playlist + ' ' + class_pl_position + '" ' + autoplay + ' ' + width + ' ' + height + ' ' + showplaylist + ' ' + controls + ' ' + preload + ' ' + positionplayer + '>';
				 
			jQuery.each(source, function(key, value) {

				if (value.link) {
					var src = 'src="' + value.link + '" data-src="' + value.link + '"';
				} else {
					return;
				}
										
				if (value.poster) {
					var poster = 'data-poster="' + value.poster + '" data-aopp-im="' + value.poster + '"';
				} else {
					var poster = '';
				}
										
				if (value.type) {
					var type = 'type="' + value.type + '"';
				} else {
					return;
				}
										
				if (value.title) {
					var title = 'title="' + value.title + '"';
				} else {
					var title = '';
				}

				html += '<source ' + src + ' ' + poster + ' ' + type + ' ' + title + '>';
				shortcode += '[aopp-source link="' + value.link + '" poster="' + value.poster + '" title="' + value.title + '" type="' + value.type + '"]';
			});

			html += '</audio>';
							
		}
	}
			
	if (html) {
		jQuery('#test_video').html('<div style="' + css + '" class="aopp_wrap_video">' + html + '</div>');
	}

	shortcode += '[/aopp-player-' + player.id + ']';
	if (shortcode) {
		jQuery('#aopp-shortcode').html(shortcode);
	}
			
	var order_html = '';
	if (player.orderbutton=='true' && player.orderbuttonlink && player.orderbuttonlink) { 
		var style = '';
		if (player.orderbuttonposition=='topleft') {
			style = 'position:absolute;z-index:9901;left:' + player.orderbuttonleft + 'px;top:4px';
		} else if (player.orderbuttonposition=='topright') {
			style = 'position:absolute;z-index:9901;right:' + player.orderbuttonright + 'px;top:4px';
		} else if (player.orderbuttonposition=='topcenter') {
			style = 'position:absolute;z-index:9901;left:50%;margin-left:-' + player.orderbuttontitle.length + 'px;top:4px';
		} else if (player.orderbuttonposition=='bottomleft') {
			style = 'position:absolute;z-index:9901;left:' + player.orderbuttonleft + 'px;bottom:30px';
		} else if (player.orderbuttonposition=='bottomright') {
			style = 'position:absolute;z-index:9901;right:' + player.orderbuttonright + 'px;bottom:30px';
		} else if (player.orderbuttonposition=='bottomcenter') {
			style = 'position:absolute;z-index:9901;left:50%;margin-left:-' + player.orderbuttontitle.length + 'px;bottom:30px';
		} else if (player.orderbuttonposition=='leftcenter') {
			style = 'position:absolute;z-index:9901;left:' + player.orderbuttonleft + 'px';
		} else if (player.orderbuttonposition=='rightcenter') {
			style = 'position:absolute;z-index:9901;right:' + player.orderbuttonright + 'px';
		}
							
		order_html += '<div class="mejs__overlay-order" style="display:none;width:100%;height:100%;">';
		order_html += '<a style="font-size:' + player.orderbuttonfontsize + 'px;' + style + '" class="aopp-btn aopp-btn-' + player.orderbuttoncolor + '" href="' + player.orderbuttonlink + '" target="_blank">' + player.orderbuttontitle + '</a>';
		order_html += '</div>';
	}

	var warning_html = '';
	if (player.autoplay=='true' && player.autoplaysound=='true') { 
		warning_html += '<div class="mejs__overlay-warning" style="width:100%;height:100%;">';
		warning_html += '<div style="position:absolute;left:4px;top:4px" class="aopp-warning aopp-btn aopp-btn-danger">' + player.settings.warningbutton + '</div>';
		warning_html += '</div>';
	}
			
	var features = [];	
	if (player.controls=='controls') {
		
		var features = [];
		var inc = 0;
		features[inc] = 'playlistfeature';
		inc++;
		
		if (player.controls_navigation==true || player.controls_navigation=='true') {
			features[inc] = 'prevtrack';
			inc++;
		}
		
		features[inc] = 'playpause';
		inc++;
		
		if (player.controls_navigation==true || player.controls_navigation=='true') {
			features[inc] = 'nexttrack';
			inc++;
		}
		
		features[inc] = 'loop';
		inc++;
		
		features[inc] = 'current';
		inc++;
		
		features[inc] = 'progress';
		inc++;
		
		features[inc] = 'duration';
		inc++;
		
		features[inc] = 'volume';
		inc++;
		
		features[inc] = 'fullscreen';
		inc++;
		
		features[inc] = 'speed';
		inc++;
	}
			
	if (player.width=='100%') {
		var videoWidth = player.width;
		var videoHeight = player.width;
		var enableAutosize = true;
	} else {
		var videoWidth = false;
		var videoHeight = false;
		var enableAutosize = false;
	}
		
	mejs.i18n.language("ru");
	jQuery('.' + tag).mediaelementplayer({
		features: features,
		shuffle: false,
		loop: false,
		loopplaylist: true,
		speeds: ['0.50', '0.75', '1.00',  '1.25', '1.50', '2.00'],
		pluginPath: player.settings.path + "assets/mediaelement/player/",
		id: tag,
		clickToPlayPause: true,
		videoWidth: videoWidth,
		videoHeight: videoHeight,
		enableAutosize: enableAutosize,
				
		success: function(mediaElement, domObject) {
			var control = $(".mejs__controls");
			control.find(".mejs__prevtrack-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.prevText"]);
			control.find(".mejs__nexttrack-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.nextText"]);
			control.find(".mejs__loop-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.loopText"]);
			control.find(".mejs__fullscreen-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.fullscreenText"]);
			control.find(".mejs__shuffle-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.shuffleText"]);
			control.find(".mejs__playlist-button>button").attr("title", mejs.i18n[mejs.i18n.language()]["mejs.playlistText"]);

			var vid = jQuery('video.' + tag);
			var mejs_container = vid.parents(".mejs__container");
							
			var mejs__layers = mejs_container.find(".mejs__inner>.mejs__layers");
			if (mejs__layers && typeof mejs__layers !== "undefined") {
				mejs__layers.append(order_html + warning_html);
				mediaElement.addEventListener("timeupdate", function() {
					setTimeout(function() {
						if (mediaElement.currentTime==0) {
							mejs_container.find(".mejs__overlay-warning").remove();
							mediaElement.setVolume(1);
							mediaElement.muted = false;
						}
					}, 1000);
				}, false);
			}
							
			var time = player.orderbuttontime;
			mediaElement.addEventListener('timeupdate', function() {
				if (mediaElement.currentTime>time) {
					mejs_container.find('.mejs__overlay-order').fadeIn(500);
				}
			}, false);
					
			mejs_container.find(".aopp-warning").on("click", function(){
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

			mediaElement.addEventListener("play", function() {
				console.log('test1');		
			}, false);

			mediaElement.addEventListener("pause", function() {            
				console.log('test2');		
			}, false);
			
			var ratio = 640/360;
			var container = vid.parents(".mejs__container").width();
			if (container && typeof container !== "undefined") {
				if (ratio < 1) {
					var newheight = container * ratio;
				} else {
					var newheight = container / ratio;
				}
			}

			if (newheight && typeof newheight !== "undefined") {
				vid.parents(".mejs__container").height(Math.round(newheight) + "px");
				var overlay_height = Math.round(newheight);
				vid.parents(".mejs__container").find(".mejs__overlay").height(Math.round(newheight) + "px");
				vid.parents(".mejs__container").find(".mejs__layers").height(Math.round(newheight) + "px");
			} else {
				var overlay_height = vid.parents(".mejs__container").find(".mejs__poster.mejs__layer").height();
			}
				
			if (overlay_height && typeof overlay_height !== "undefined") {
				vid.parents(".mejs__container").find(".mejs__playlist.mejs__layer").css("top", overlay_height+"px");
			}
										
			var height = vid.parents(".mejs__container").find("ul.mejs").height();
			if (height && typeof height !== "undefined") {
				vid.parents(".mejs__container").find(".mep-playlist.video_bottom").css("margin-bottom", height+"px");
			}

			var video_poster = vid.find("source:nth-child(1)").attr("data-aopp-im");
			if (video_poster && typeof video_poster !== "undefined") {
				vid.parents(".mejs__container").find('video.' + tag).attr("poster",video_poster);
				vid.parents(".mejs__container").find('video.' + tag).attr("data-poster",video_poster);
			}

			if (player.contenttype=='audio' && player.id) {
				jQuery('audio.aopp-player-' + player.id).show();  
			}
					
			jQuery('.mejs__container').css('border', '1px solid #ffffff');
		},
					
		error: function() {
			console.log("Error setting media!");
		}
	});
			
	return false;
}

function reloadForm(action, token, data, url, id) {			
	jQuery('#aopp-overlay, #aopp-loader').show();
	jQuery('#aopp-player').load(url + 'admin-ajax.php?action=' + action, {data: data, token: token, id: id}, function(){
		loadPage();
	});
};

function loadPage() {
	jQuery('#aopp-overlay, #aopp-loader').hide();
};

jQuery(document).ready(function() {	
	loadPage();
	
	jQuery(document).delegate('.clone_button .fa-plus', 'mouseleave', function(event){
		//jQuery(this).parents('div.form-group').find('.speech_wrap').hide('slow');
	});
			
	jQuery(document).delegate('.clone_button .fa-plus', 'mouseenter', function(event){
		//jQuery(this).parents('div.form-group').find('.speech_wrap').show('slow');
	});
	
	jQuery('.message_output').fadeOut(3000);
	
	jQuery('[data-toggle="tooltip"]').tooltip();

	jQuery(document).delegate('.fa-plus', 'click', function(e){
		var add_block = jQuery('#aopp-source-player');
		var last_block = add_block.children('.aopp_clone_block').last();
		var index = parseInt(last_block.attr('data-id'), 10);
		if (!isNaN(index)) {
			
			if (typeof new_index === "undefined") {
				var new_index = index+1;
			} else {
				new_index++;
			}
			
			var new_block = jQuery(last_block).clone().attr('data-id', new_index);
			new_block.find('input[data-type="link"]').val('');
			new_block.find('input[data-type="poster"]').val('');
			new_block.find('input[data-type="title"]').val('');
			new_block.find('.aopp-delete-block').show();
			add_block.append(new_block);
		}
	});
	
	jQuery(document).delegate('.click_copy', "click", function(e){
		var e = this;
		if (window.getSelection) { 
			var s=window.getSelection(); 
			if (s.setBaseAndExtent[0]) { 
				s.setBaseAndExtent(e,0,e,e.innerText.length-1); 
			} else { 
				var r=document.createRange(); 
				r.selectNodeContents(e); 
				s.removeAllRanges(); 
				s.addRange(r);
			} 
		} else if (document.getSelection) { 
			var s=document.getSelection(); 
			var r=document.createRange(); 
			r.selectNodeContents(e); 
			s.removeAllRanges(); 
			s.addRange(r); 
		} else if (document.selection) { 
			var r=document.body.createTextRange(); 
			r.moveToElementText(e); 
			r.select();
		}

		document.execCommand('copy');
	});
});