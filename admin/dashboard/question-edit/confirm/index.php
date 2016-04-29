<?php
session_start();
if(!isset($_SESSION["loggedin"]))
{
  header('Location: ../../../');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Text Edit</title>
  <link rel="stylesheet" href="../../../../style.css">
</head>
<body>
<section>
  <img src='../../../../images/einerlei_publishing_site001005.png'>
</section>
<div id="container">
<div id="content">
<h1>Changes Saved</h1>
<?php
  $mysqli = new mysqli("", "jhartma0", "jhartma0", "Quiz");
  if($mysqli)
  {
    $p1 = $_POST["questionText"];
    $p1 = $mysqli->real_escape_string($p1);
    $p1 = stripslashes($p1);
    $p1 = htmlentities($p1);
    $p1 = strip_tags($p1);
    $query = "update ".$_POST["tableName"]."Question set question = \"".$p1."\" where id = ".$_POST['id'].";";
    $mysqli->query($query);
    echo "<p>".$_POST["questionText"]."</p>";
  }
  else
  {
    exit();
  }

  $table = $_POST["tableName"];
  if($table == "Demographic")
  {
    $handle = fopen("../../../../demographics/demographicQuestions.json", "w");
    if(!$handle)
    {
      exit();
    }
    $query = "select question from ".$_POST["tableName"]."Question order by question_order;";
  }else if($table == "Likert")
  {
    $handle = fopen("../../../../likert/likertQuestions.json", "w");
    if(!$handle)
    {
      exit();
    }
    $query = "select question from ".$_POST["tableName"]."Question order by id;";
  }
  
  fwrite($handle, "{\n");
  $result = $mysqli->query($query);
  $max = $result->num_rows;
  $row = $result->fetch_array(MYSQLI_NUM);
  for($i = 1; $i < $max; $i++)
  {
    fwrite($handle, "\"question$i\":\"$row[0]\",\n");
    $row = $result->fetch_array();
  }
  fwrite($handle, "\"question$i\":\"$row[0]\"\n");
  fwrite($handle, "}");

    $mysqli->close();
?>
<ol>
  <li><a href="../">Select Another Question</a></li>
  <li><a href="../../">Dashboard</a></li>
</ol>
</div>
</div>
</body>
</html>
