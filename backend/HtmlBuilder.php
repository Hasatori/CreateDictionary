<?php
function buildHeader($title){
 ?><!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>ZK-API | <?= $title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
     <link href="css/main.css" rel="stylesheet">
     <base href="<?php echo BASE ?>"/>
</head>
<body>
<?php
}

function buildNavBar($heading){
   ?> 
    <nav class="navbar navbar-collapse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">API zkoušení slovíček</a>
    </div>
    <ul class="nav navbar-nav">
         <li id="index"><a href="<?= BASE ?>index.php">Yandex API</a></li>
         <li id="local"><a href="<?= BASE ?>local.php">Ze souboru</a></li>
         <li id="upload"><a href="<?= BASE ?>upload.php">Náhrávání</a></li>
         <li id="oxfordDicApi"><a href="<?= BASE ?>oxfordDicApi.php">Oxford API</a></li>
        <li id="translationApi"><a href="<?= BASE ?>translationApi.php">Překladač API</a></li>
        <li id="datamuseApi"><a href="<?= BASE ?>datamuseApi.php">Datamuse API</a></li>
        <li id="glosbeApi"><a href="<?= BASE ?>glosbeApi.php">Glosbe API</a></li>
        <!--<li id="categories"><a href="<?= BASE ?>categories.php">Categories</a></li>-->
        <li id="slovnikCZ"><a href="<?= BASE ?>slovnikCZ.php">Slovník.cz API</a></li>
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