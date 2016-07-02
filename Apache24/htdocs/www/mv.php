<?php
    require_once './php/conf.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>MV Player</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="src/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="src/jplayer/lib/jquery.min.js"></script>
<script type="text/javascript" src="src/jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="src/jplayer/dist/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript">
var myPlaylist;
function mv_getlist() {
    $.get("./php/get.php",
    {
        type:"mv_list",
    },
    function(data,status){
        console.log("Data: " + data + "\nStatus: " + status);
        myPlaylist.setPlaylist(eval('(' + data + ')'));
    });
}

//<![CDATA[
$(document).ready(function(){
	myPlaylist= new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	},[],
	 {
		playlistOptions: {
			enableRemoveControls: true
		},
		swfPath: "src/jplayer/dist/jplayer",
		supplied: "webmv, ogv, m4v",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});
	$(jquery_jplayer_1).jPlayer({size:{width:"960px",height: "540px",cssClass: "jp-video-mi"}});
	// $("#playlist-setPlaylist-media-mix").click(function() {
		setTimeout("mv_getlist()",100);
		// });
});
//]]>
</script>
</head>
<body>
<a href="javascript:;" id="playlist-setPlaylist-media-mix">[Media Mix]</a>
<div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player">
	<div class="jp-type-playlist">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-previous" role="button" tabindex="0">previous</button>
						<button class="jp-play" role="button" tabindex="0">play</button>
						<button class="jp-next" role="button" tabindex="0">next</button>
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
						<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<!-- The method Playlist.displayPlaylist() uses this unordered list -->
				<li>&nbsp;</li>
			</ul>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>
</body>

</html>
