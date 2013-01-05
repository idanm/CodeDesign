<?php require_once('codedesign/init.php'); ?><!DOCTYPE HTML><html><head>
  
  <title>{...} CodeDesign - deploying easily stylesheet, javascript and markdown files in php environment.</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <?php Code::Stylesheet(array('123.js')); ?>

</head><body id="top">
  
  <!-- Page -->
  <section id="page" class="container">
    <header class="clearfix">
      <?php // Code::Content('header'); ?>
      
      <div class="btn-group">
        <a class="btn btn-success btn-large dropdown-toggle" data-toggle="dropdown" href="#">
          Github
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="https://github.com/idanm/CodeDesign/zipball/master">הורדת קובץ Zip</a></li>
          <li><a href="https://github.com/idanm/CodeDesign/">עמוד Github</a></li>
        </ul>
      </div>
    </header>
    
    <article class="well">
      <?php // Code::Content('content'); ?>
      
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bit.ly/PvVSB7" data-counturl="http://bit.ly/PvVSB7" data-lang="en" data-count="vertical">Tweet</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </article>
      
    <footer>
      <?php // Code::Content('footer'); ?>
    </footer>
  </section>

  <?php // Code::Javascript(); ?>
</body></html>