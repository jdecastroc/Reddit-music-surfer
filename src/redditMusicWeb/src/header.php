   <?php
   function showHeader($lang) {
    ?>
   <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Music surfer for Reddit</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo "http://localhost/index.php"?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
            <li><a href="<?php echo "http://localhost/about.php"?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>About</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class ="pull-right"><p class="navbar-btn"><a href="http://localhost/index.php" class="btn-info btn"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>New playlist!</a></p></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  <?php
}
function showFooter($lang) {
  ?>
  <div class="panel panel-default">
    <div class="panel-footer" style="height: 120;">
      <div class="row-fluid">
        <div class="span12">
          <div class="row-fluid">
            <div class="col-md-4">
              <p>Languages</p>
              <ul>
                <li><a href="index.php">English</li></a>
                <li><a href="es/index.php">Spanish</li></a>
                <li><a href="jp/index.php">Japanese</li></a>
              </ul>
            </div>
            <div class="col-md-4 text-center">
              <p style="font-size:80%;">Music surfer is a web crawler application made for enjoy the music from reddit</p>
              <p style="font-size:80%;">Copyright (C) 2015 <a href="https://github.com/jdecastroc">@jdecastroc</p></a>
              <p style="font-size:80%;">Reddit is a trademark of Reddit Inc.</p>
            </div>
            <div class="col-md-4 text-center">
              <a href="https://github.com/jdecastroc/Reddit-music-surfer"><img src="img/Octocat.png" height="100" width="100"></img></a>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<?php }


?>