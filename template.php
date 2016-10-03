<!DOCTYPE html>
<html lang="cs">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<head>
    <!--basic tags part-->
    <title>Jů, jídlo</title>
    <meta name="description" content="Použitelnější jídelníček Jihočeské Univerzity" />
    <meta name="keywords" content="Jídlo, jídelníček," />
    <meta charset="utf-8" />
    <meta name="author" content="Pavel Vosyka" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="bower_components/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="style.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <link rel="stylesheet" href="style.css" media="screen, projection" />
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-75924744-1', 'auto');
      ga('send', 'pageview');

    </script>
</head>
<body>

<div class="container-fluid">
  <header class="row">
    <?php include "header.php";?>
  </header>
  <div class="content row">
    <?php include "content.php";?>
  </div>
  <footer class="row">
    <?php include "footer.php";?>
  </footer>
</div>

<script>
$( document ).ready(function() {
  $('.den').click(function (e) {
    e.preventDefault()
    //active
    var index = $( ".den" ).index( this );
    $(".jidelnicek.show").removeClass("show");
    $(".jidelnicek:nth-child("+ parseInt(index+1) +")").addClass("show");

    $(".den.active").removeClass("active");
    $(this).addClass("active");

  });
});
function takePhoto(){
  alert(
    "Tímto zmáčknutím jste projevili zájem o naprogramování funkce focení jídla a zobrazování jeho fotek." +
    " Ještě pár takových kliknutí, a ta funkce tu bude co by dup. ;-)");
    ga('send', 'event', {   'eventCategory': 'Feauture request',   'eventAction': 'Photo.' });
}
</script>
</body>
</html>
