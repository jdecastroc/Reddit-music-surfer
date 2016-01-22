
<?php
include 'main_page.php';
//error_reporting, after manage the warnings and errors
//error_reporting(0);
  if(isset($_POST['mode']) && isset($_POST['random']) && !empty($_POST['reddits'])) 
  {
    $page = "video";
      $mode_r = $_POST['mode'];
      $random_r = $_POST['random'];
      $redditsPhpList = $_POST['reddits'];
      $N = count($redditsPhpList);
      $listaRedditFinal = "";
    
      for($i=0; $i < $N; $i++)
      {
        $redditsPhpList[$i] = str_replace("/r/","",$redditsPhpList[$i]);
        $listaRedditFinal = $listaRedditFinal.$redditsPhpList[$i];
        if ($i != $N-1){
        $listaRedditFinal = $listaRedditFinal.",";
        }
      }
      $json_url = "http://localhost:8080/playlist?redditList=".$listaRedditFinal."&mode=".$mode_r."&random=".$random_r;
      $json = file_get_contents($json_url);
      $data = json_decode($json, TRUE);
  }
  else
  {
    $page = "main";
    $json_url = "http://localhost:8080/redditList";
    if (file_get_contents($json_url) === FALSE)
    {
      $page = "main_server_error";
    }
    else
    {
    $json = file_get_contents($json_url);
    $data = json_decode($json, TRUE);
    }
  }    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Reddit music parser to enjoy music from Reddit">
    <meta name="author" content="@jdecastroc">
    <link rel="icon" href="../../favicon.ico">

    <title>Reddit Music Surfer</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    

<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Reddit Music Surfer</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">English</a></li>
                <li><a href="#">Spanish</a></li>
                <li><a href="#">Japanese</a></li>
              </ul>
            <li><p class="navbar-btn"><input type="button" class="btn btn-info" onclick="location.href='http://localhost/index.php';" value="New playlist!" /></p></li>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
        

  <div class="container" id="container_index">

    <?php
    if ($page == "main"){
      main_page($data, $json_url);
    } else if ($page == "video"){
      video_page($data, $json_url);
    } else if ($page == "main_server_error"){
      main_page_error();
    }

    ?>
    
  </div> <!-- /container_index -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

