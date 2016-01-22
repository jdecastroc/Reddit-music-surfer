<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">

<?php

	function main_page($data, $json_url){
	?>
		&nbsp;&nbsp;<h1>Reddit music Surfer (Alpha version)</h1>
		<p>Welcome to Reddit music Surfer!</p>
		<ul>
			<li> 1.- Select how many songs do you wanna surf from each music Reddit! </li>
			<li> 2.- Select wheter you wanna mix the songs in the playlist </li>
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

			<h2>Music Reddit's (got from /r/Music)</h2>


			<div id="reddits">
				<fieldset class="form-group">
					<div class="checkbox">
						<?php
						for ($main_row = 0; $main_row < count($data); $main_row++) {
						 	echo "<h2>".$data["$main_row"]["name"]."</h2>";
						 	echo "<ul>";
						 	for ($col = 0; $col < count($data["$main_row"]['redditList']); $col++) {
						 		?>
						 		<label>
						   			<input type="checkbox" name="reddits[]" value="<?php echo $data["$main_row"]['redditList']["$col"]["name"]; ?>">
						    		<?php echo $data["$main_row"]['redditList']["$col"]["name"]; ?>
						  		</label>
						  		<br /> 
						 	<?php //   echo "<li>".$data["$main_row"]['redditList']["$col"]["name"];

						  	}
						echo "</ul>";
						}
				    	?>
		    		</div>
		    	</fieldset>
		    </div>
    	</form>
    	<?php
    }

    function video_page($data, $json_url){

    	static $api_key = "AIzaSyDnTgE16CbFl6gXSeEvKzx1rLdsVCW2tq0";
    ?>
		<div class="row">
        	<div class="col-md-8">
            	<div class="well">
                	<div class="text-center">
                    	&nbsp;&nbsp;<h1>Reddit music Surfer (Alpha version)</h1>
		  				<h3>URL: <h3><?php echo $json_url;?>;
		  				<?php
	                 	$delete = array("https://www.youtube.com/watch?v=", "https://youtu.be/", "http://youtu.be/", "http://www.youtube.com/watch?v=",
	                 				 "https://m.youtube.com/watch?v=", "http://m.youtube.com/watch?v=");
	                	for($counter = 0; $counter < count($data); $counter++)
	                	{
	            			$link = str_replace($delete,"",$data[$counter]);
	            			$data[$counter] = $link;
	                	}
	                	?>

		  				<!--Sidebar content-->
		      			<!-- YOUTUBE PLAYER CODE STARTS -->
						<div id="player"></div> 
			
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
						        	//videoId: jArray[song_counter],
						        	events: {
						        		'onReady': onPlayerReady,
						            	'onStateChange': onPlayerStateChange
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
		    			<button type="button" onclick = 'previousVideo()' class="btn btn-primary">Previous video</button>
		    			<button type="button" onclick = 'nextVideo()' class="btn btn-primary">Next video</button>
               		</div>
            	</div>
        	</div>
        <div class="col-md-3">
            <div class="well">
                <button type="button" class="btn btn-info" onclick="location.href = 'http://localhost/redditMusic/index.php';">New playlist</button> 
                <br /><br /><br /><br /><br /><br /><br />
            </div>
            <div class="well">
                <strong>Playlist</strong><hr class="hr-tags"/>
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
	            <button type="button" onclick = "playThisVideo('<?php echo $data[$counter]?>')" class="btn btn-primary"><?php echo $vName?></button><br />
	            <?php


	            }
	            ?>
	            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>
        </div>
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
	<?php
    }

    function main_page_error() {
    	?>
    	&nbsp;&nbsp;<h1>Reddit music Surfer (Alpha version)</h1>
		<p>Welcome to Reddit music Surfer!</p>
		<p>There is a problem retrieving the data from the server, please try again later</p>
		<?php
    }
    ?>
