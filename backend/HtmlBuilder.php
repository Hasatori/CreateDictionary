<?php
function buildHeader($title){
 ?><!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>ZK-API | <?= $title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link href="css/font-awesome.css" rel="stylesheet">
     <link href="css/main.css" rel="stylesheet">
     <base href="<?php echo BASE ?>"/>
</head>
<body>
<?php
}

function buildNavBar($heading){
   ?> 
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">API zkoušení slovíček</a>
    </div>
    <ul class="nav navbar-nav">
         <li id="index"><a href="<?= BASE ?>index.php">Externí služba</a></li>
         <li id="local"><a href="<?= BASE ?>local.php">Ze souboru</a></li>
         <li id="upload"><a href="<?= BASE ?>upload.php">Náhávání</a></li>
         <li id="oxfordDicApi"><a href="<?= BASE ?>oxfordDicApi.php">Oxford API</a></li>
        <li id="translationApi"><a href="<?= BASE ?>translationApi.php">Překladač API</a></li>
    </ul>
  </div>
</nav>
    <div class="mainContent">
        <div class="loaderWrapper"
            <?php if (@$_SESSION['error'][0]){
                echo 'style="display:none;"';
            } ?>
        ><div class="loader"></div></div>
        <h1 class="text-center text-info mainHeading"><?= $heading ?></h1>
         <h2 class="text-center text-danger" id="error" style="display:<?php echo isset($_SESSION['error']) ? "block" : "none" ?>;">
        <?php echo isset($_SESSION['error']) ? htmlspecialchars($_SESSION['error'][1]) : "null" ?></h2>
    <?php
    if(isset($_SESSION['error'])){
    unset($_SESSION['error']);}
    ?>
    <?php
}

function buildeProgressBar(){
        ?><div class="container progressBarContainer">
        <label>
            Progress:</label>
        <h4 class="text-left text-info" id="estimatedDuration"></h4>
        <h3 class="text-center text-info" id="progressNumber">0%</h3><div class="progress">
            <div class="progress-bar" id="progressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
        <?php
}



function buildFooter(){
  ?>
    </div>
    <footer class="footer font-small cyan darken-3 mt-4">
          <!-- Copyright -->
          <div class="footer-copyright text-center py-3">© <?= date('Y') ?> Copyright: Oldřich Hradil
  </div>
  <!-- Copyright -->
        
    </footer>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
<?php
}