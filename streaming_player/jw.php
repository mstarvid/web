<?


require_once "jw_api.php";
require_once "extra_fields.php";
require_once "source_tools.php";

$document = JFactory::getDocument();
$k2_id = JRequest::getVar('k2_id');
$user = JFactory::getUser();
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('title');
$query->from($db->quoteName('xlefz_k2_items'));
$query->where($db->quoteName('id')." = ".$db->quote($k2_id));
 
// Reset the query using our newly populated query object.
$db->setQuery($query);
$title = $db->loadResult();

$stream_key = get_extra_field($k2_id,52);

if(!in_array(30, $user->groups)){

	$api = new BotrAPI('jnpXvn03','qyQRztWpgIto2ZLzpR3Mq44J');
	$props = array(
		"player_key"			=> "iXJDhjmf",
		"custom.abouttext"		=> "testing",
		"sharing_player_key"	=> "iXJDhjmf",
		"allowscriptaccess"		=> "always",
		"displaytitle"			=> "true"

	);
	$response = $api->call("/players/update", $props);
	//print_r($response);
	//echo "hello world";

	function get_signed_player($videokey,$playerkey) {
 	 	$path = "players/".$videokey."-".$playerkey.".js";
  		$expires = round((time()+3600)/60)*60;
  		$secret = "qyQRztWpgIto2ZLzpR3Mq44J";
  		$signature = md5($path.':'.$expires.':'.$secret);
  		$url = 'http://streaming.morningstarvideo.com/'.$path.'?exp='.$expires.'&sig='.$signature;
  		return $url;
	};

?>
<div style="color:white;font-size:20px;margin-bottom:25px;">
	<? echo $title; ?>	
</div>
<?
echo "<script type='text/javascript' src='".get_signed_player($stream_key,'P80a0YXs')."'></script>";
?>

<script type="text/javascript">
	jQuery(document).keypress(function(event){
	    var keycode = (event.keyCode ? event.keyCode : event.which);
	    if(keycode == '32' || keycode == '13'){
	        jwplayer().play(); 
	    }
	});
	
	/*var started = 0;
	jwplayer().onPlay(function(){
		if(started == 0){
			//jwplayer().seek(755);
			started = 1;
		}
	});*/
		
</script>

<?

if(in_array(30, $user->groups)){?>
	
<script type="text/javascript">

		var next_call 			= 0;
		var clock 				= 0;
		var delta 				= 0;
		var report_time			= 0;
		var playbackPaused		= false;
		var playbackStopped		= false;
		var begin				= false;

	jwplayer().onPause(function(){
		
		playbackPaused = true;

	});	

	jwplayer().onIdle(function(){
		
		playbackStopped = true;

	});	

	jwplayer().onPlay(function(){
		
		if(begin && playbackPaused){

			playbackPaused = false;
			clock = 0;
			next_call = clock + 1000;

		}	

	});	

	jwplayer().onPlay(function(){

		if(!begin){

			begin = true;

			setInterval(function () {clock = clock + 10;}, 10);
			
			next_call = clock + 1000;

			(function poll(){
			   setTimeout(function(){

			   		if(clock > next_call && !playbackStopped && !playbackPaused){	

			   			delta = clock - next_call;

			   			report_time = delta + 1000;

			   			next_call = clock + 1000;

						jQuery.ajax({ url: "roku_movie_view.php?k2_id=<? echo $k2_id; ?>&time_viewed="+report_time+"&mode=k2", success: function(data){
						//alert(report_time);	
						poll();
						}, dataType: "text", cache: false}); 

				    }else{

				    	poll();

				    }  
				 
			  }, 100);
			})();

		}	

	});
	
</script>	

<?}} else {


	$document->addStyleSheet('//vjs.zencdn.net/4.12/video-js.css');
	$document->addScript('//vjs.zencdn.net/4.12/video.js');
	$document->addScript('videojs-media-sources/videojs-media-sources.js');
	$document->addScript('videojs-contrib-hls/videojs-hls.js');



?>

<video id=example-video" width=600 height=300 class="video-js vjs-default-skin" controls>
  <source
     src="https://d3o44rpd4mon6c.cloudfront.net/movies/Amazing%20Love:%20The%20Story%20of%20Hosea%20(2012)/playlist.m3u8"
     type="application/x-mpegURL">
</video>
<script src="video.js"></script>
<script src="videojs-media-sources.js"></script>
<script src="videojs-hls.min.js"></script>
<script>
var player = videojs('example-video');
player.play();
</script>

<?
}
?>