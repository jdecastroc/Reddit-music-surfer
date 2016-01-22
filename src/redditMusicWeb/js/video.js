
							// 2. This code loads the IFrame Player API code asynchronously.
		      				var tag = document.createElement('script');
		      				var song_counter = 0;
		      				var js_array = <?php echo json_encode($data)?>;
    						alert(js_array[0]);
		      				//alert(<?php echo $data[0];?>);
		      				//var jArray = <?php echo json_encode($data); ?>;
		      				//alert(jArray[0]);

						    //for(var i=0;i<jArray.length;i++){
						    //    alert(jArray[i]);
						    //}

		      				tag.src = "https://www.youtube.com/iframe_api";
		      				player.loadVideoById(videoId:String);

		     				var firstScriptTag = document.getElementsByTagName('script')[0];
						    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

						    // 3. This function creates an <iframe> (and YouTube player)
						    //    after the API code downloads.
						    var player;
						    function onYouTubeIframeAPIReady() {
						      	player = new YT.Player('player', {
						      		height: '390',
						        	width: '640',
						        	videoId: 'ldsil7KfaLE',
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
						    		//loadVideoById(jArray[song_counter]);
						        }
						    }

						    function stopVideo() {
						    	player.stopVideo();
						    }
