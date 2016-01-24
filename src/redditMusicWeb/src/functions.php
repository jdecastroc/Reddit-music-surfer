	<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php

	function main_page($data, $json_url){
	?>
		<h1>Music Surfer for Reddit!(Alpha version)</h1>
		<p>Welcome!</p>
		<ul>
			<li> 1.- Select how many songs do you wanna surf from each music Reddit! </li>
			<li> 2.- Select whether you wanna mix the songs in the playlist </li>
			<li> 3.- Select the Reddit's you wanna surf! </li>
			<li> 4.- Enjoy it ^^ </li>
		</ul>
		<form action="index.php" method="post">
			<fieldset class="form-inline">
		    	<label for="exampleSelect1">Surfer mode</label>
		    	<select class="form-control" name="mode">
		     		<option value="0">Get recent songs</option>
		      		<option value="1">Get few reddit music pages</option>
		      		<option value="2">Get lot of songs</option>
		    	</select>
		    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    	<label for="exampleSelect2">Randomize?</label>
		    	<select class="form-control" name="random">
		     		<option value="true">Yes</option>
		      		<option value="false">No</option>
		    	</select>
		    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    	<button type="submit" class="btn btn-success">Play music!</button>
		  	</fieldset>

			
		  	<h2>Music reddit's (got from /r/Music)</h2>

			<div id="reddits">
				
				<fieldset class="form-group">
					<div class="checkbox" id="checkboxes">
						<?php
						for ($main_row = 0; $main_row < count($data); $main_row++) {
						 	echo "<h2>".$data["$main_row"]["name"]."</h2>";
						 	echo "<ul>";
						 	for ($col = 0; $col < count($data["$main_row"]['redditList']); $col++) {
						 		?>
						 		<label>
						   			<input type="checkbox" class="check_class" name="reddits[]" value="<?php echo $data["$main_row"]['redditList']["$col"]["name"]; ?>" id="<?php echo $data["$main_row"]['redditList']["$col"]["name"]; ?>">
						    		<?php echo $data["$main_row"]['redditList']["$col"]["name"]; ?>
						  		</label>
						  		<br /> 
						 	<?php //   echo "<li>".$data["$main_row"]['redditList']["$col"]["name"];

						  	}
						echo "</ul>";
						}
				    	?>
				    	<script>
				    	//Block the checkboxes after 4
				    	$('input:checkbox[name="reddits[]"]').change(function(){
					    	var numberOfChecked = $('input[name="reddits[]"]:checked').length;
					    	if (numberOfChecked >= 4) {
        						$('#reddits').find('.check_class').each(function(){
							    	if ($(this).prop('checked')==false){ 
							        $(this).prop('disabled', true);
							    	}
							    });
        					} else {
        						$('input.checkbox[name="reddits[]"]').removeAttr('disabled');
        						$('#reddits').find('.check_class').each(function(){
							    	if ($(this).prop('checked')==false){ 
							        $(this).removeAttr('disabled');
							    	}
							    });
        					}
				    	});
				    	</script>

		    		</div>
		    	</fieldset>
		    </div>
    	</form>
    	<?php
    }

    function video_page($data, $json_url){
    	$show_yt = true;
    	static $api_key = "AIzaSyDnTgE16CbFl6gXSeEvKzx1rLdsVCW2tq0";
    ?>
		<div class="row">
        	<div class="col-md-8" id="player_container">
            	<div class="well">
                	<div class="text-center">
                    	<h2>Reddit music Surfer (Alpha version)</h2><hr class="hr-tags"/>
		  				<!--<h3>URL: <h3><?php echo $json_url;?>;-->
		  				<?php
	                 	$delete = array("https://www.youtube.com/watch?v=", "https://youtu.be/", "http://youtu.be/", "http://www.youtube.com/watch?v=",
	                 				 "https://m.youtube.com/watch?v=", "http://m.youtube.com/watch?v=");
	                	for($counter = 0; $counter < count($data); $counter++)
	                	{
	            			$link = str_replace($delete,"",$data[$counter]);
	            			$data[$counter] = $link;
	                	}
	                	if ($data == null){
	                		$show_yt = false;
	                	}
	                	
	                	?>
		  				<!--Sidebar content-->
		      			<!-- YOUTUBE PLAYER CODE STARTS -->

		      			<?php 
		      			if ($show_yt) { //If there are youtube links, show YT player and buttons
		      			?>
		      			<div class="videowrapper"><div id="player"></div></div>
						<button type="button" onclick = 'previousVideo()' class="btn btn-primary"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span>Previous video</button>
		    			<button type="button" onclick = 'nextVideo()' class="btn btn-primary"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span>Next video</button>
						<?php
						} else {	//If not, error message
						echo "<h3>Ooops! Seem's like there is nothing in this reddit. Try a new Playlist! :D</h3>";
						}?>

						<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
		    			<!-- https://developers.google.com/youtube/iframe_api_reference -->
		    			<!-- <script src="js/video.js"></script> -->
		    			<script>
		    			// 2. This code loads the IFrame Player API code asynchronously.
		      				var tag = document.createElement('script');
		      				var song_counter = 0;
		      				var jArray = <?php echo json_encode($data)?>;
		      				tag.src = "https://www.youtube.com/iframe_api";
		     				var firstScriptTag = document.getElementsByTagName('script')[0];
						    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

						    // 3. This function creates an <iframe> (and YouTube player)
						    //    after the API code downloads.
						    var player;
						    function onYouTubeIframeAPIReady() {
						      	player = new YT.Player('player', {
						      		height: '390',
						        	width: '640',
						        	videoId: jArray[song_counter],
						        	events: {
						        		'onReady': onPlayerReady,
						            	'onStateChange': onPlayerStateChange,
						            	'onError': onPlayerError
						        	}
						        });
						    }

		      				// 4. The API will call this function when the video player is ready.
						    function onPlayerReady(event) {
						    	event.target.playVideo();
						    }

						    // 5. The API calls this function when the player's state changes.
						    //    The function indicates that when playing a video (state=1),
						    //    the player should play for six seconds and then stop.
						    var done = false;
						    function onPlayerStateChange(event) {
						    	if (event.data == 0) { //CUANDO TERMINA PASA AL SIGUIENTE EN EL ARRAY
						    		song_counter++;
						    		player.loadVideoById(jArray[song_counter]);
						        }
						    }

						    function onPlayerError(event) {
						    		song_counter++;
						    		player.loadVideoById(jArray[song_counter]);
						    }

						    function stopVideo() {
						    	player.stopVideo();
						    }

						    function nextVideo() {
						    	song_counter++;
						    	player.loadVideoById(jArray[song_counter]);
						    }

						    function previousVideo() {
						    	song_counter--;
						    	player.loadVideoById(jArray[song_counter]);
						    }
						    function playThisVideo(video_id) {
						    	for(var i=0;i<jArray.length;i++){
						    		if (jArray[i] == video_id){
						    			song_counter = i;
						    			player.loadVideoById(video_id);
						    		}
						    	}
						    }
						</script>
		    			<!-- YOUTUBE PLAYER CODE FINISH -->
               		</div>
            	</div>
        	</div>
        	<div class="col-md-4">
	            <div class="well">
	                <h2>Playlist</h2><hr class="hr-tags"/>
	               	

	                <ul class="media-list main-list" id="links_container">
	                <?php for($counter = 0; $counter < count($data); $counter++)
		            {
			            $video_info = "https://www.googleapis.com/youtube/v3/videos?id=".$data[$counter]."&key=".$api_key."&part=snippet"."&fields=items(snippet(title))&part=snippet";
			            
			            $json_info = file_get_contents($video_info);
			            $vidName =json_decode($json_info, true);

			            if(empty($vidName['items'][0]['snippet']['title']))
			            {
		            	$vName = $data[$counter];
		            	}
		            	else {
			            $vName = $vidName['items'][0]['snippet']['title'];
			        	}

			            ?>
			            <li class="media">
						    <a class="pull-left" href="#">
						      <img class="media-object" src="<?php echo getYtImage($data[$counter])?>" alt="...">
						    </a>
						    <div class="media-body">
						      <h4 class="media-heading"><a href="#" onclick = "playThisVideo('<?php echo $data[$counter]?>')"><?php echo $vName?></a></h4>
						    </div>
						</li>
			            
			            <?php
		            }

		            ?>
		        	</ul>
	            </div>
        	</div>
    	</div>
	
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jsfunctions.js"></script>

	<?php
    }

    function main_page_error() {
    	?>
    	&nbsp;&nbsp;<h1>Reddit music Surfer (Alpha version)</h1>
		<p>Welcome to Reddit music Surfer!</p>
		<p>There is a problem retrieving the data from the server, please try again later</p>
		<?php
    }

    function getYtImage($url) {
    	$tmp = "http://img.youtube.com/vi/".$url."/default.jpg";
    	return $tmp;
    }
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
