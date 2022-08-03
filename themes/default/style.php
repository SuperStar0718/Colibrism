<?php
header("Content-type: text/css; charset: UTF-8");
$brandColor = $_POST['base'];
//$linkColor = $cl["display_set"]["color_scheme"];
$CDNURL = "http://cdn.blahblah.net";
?>


div {
color: <?php echo $brandColor; ?>;
}
<?php header('Location:index.php'); ?>