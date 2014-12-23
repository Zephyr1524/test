<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laravel PHP Framework</title>
  {{HTML::script("/jquery-1.11.0.min.js")}}
  {{HTML::script("/bs/js/bootstrap.min.js")}}
  {{HTML::style("/bs/css/cerulean.css")}}
</head>
<body>


    <div class="modal" id="upld">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title">Upload File</h4>
          </div>
          <div class="modal-body">
            <form action="ups.php" method="post" enctype="multipart/form-data" id='imgupload'>
                <label for="file" class="col-lg-5 control-label">Image Filename:</label> <input type="file" class="form-control" name="img" id="img"/>
                <input type="hidden" name="folpth" value="">
                <br>
                <label for="file" class="col-lg-5 control-label">Text Filename:</label> <input type="file" class="form-control" name="file" id="file"/>
                <br>                
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="uploadbtn">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  <div class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="profile.php">Home</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li class="" id='rl1'><a href="#">Reload</a></li>
      <li id='srch11'><a>Searched</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other Users <b class="caret"></b></a>
        <ul class="dropdown-menu" id="usr1">
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left" id='srch'>
      <input type="text" class="form-control col-lg-8" name='srch' placeholder='Search Description' id='in1'>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li class="active"><a id='d81' >   <img src="<?php echo (date("H") >= 18 || date("H") <= 05)?'moon':'sun'; echo'.png'?>"></img>  <?php print date('l d F Y',  time()); ?></a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> more <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Upload</li>
          <li><a href="#upld" data-toggle="modal">Upload Image</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">Themes</li>
          <li class=""><a id="cerulean" href="#">Cerulean</a></li>
          <li><a id="slate" href="#">Slate</a></li>
          <li><a id="cyborg" href="#">Cyborg</a></li>
          <li class="divider"></li>
          <li><a id="svpref" href="#">Save Theme</a></li>
          <li><a href="js/logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Log Out</a></li>          
        </ul>
      </li>
    </ul>
  </div>
</div>


  <div class="welcome">
    <h1>You have arrived.</h1>
    @yield ('content')
  </div>
</body>
</html>
