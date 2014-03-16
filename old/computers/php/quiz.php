<html><head><title>Addition Quiz</title></head>
<body bgcolor="black" text = "white">

<center>
<h1>Addition Quiz</h1>
<h2>Ten questions.</h2>
<?
  if ($reset) {
    $count=0;
    $correct=0;
  }
  if ($count) {
    $count +=1;
  } else {
    $count =1;
  }
  if ($correct) {
  } else {
    $correct = 0;
  }
  if ($answer) {
    if ($answer == $one + $two) {
      echo "That is correct!";
      $correct +=1;
    }
    else {
      echo "Sorry, the answer was ", $one + $two;
    }
  }
  else {
    ?> <br> <?
  }
  $one = rand(0,100) - 50;
  $two = rand(0,100) - 50;
?>
<form method="POST" action="<?=$SCRIPT_NAME?>">
<?
  if ($count > 10) {
    echo "End of quiz. Thank you for your interest.\n";
    echo "Your score is $correct out of ", $count-1,".";
  }
  else {
?>

Question <?=$count?>: What is <?=$one?> + <?=$two?>?<br>

Answer: <input type="text" name="answer"><br>

<input type = "submit" value="Proceed">

<input type="hidden" name="count" value="<?=$count?>">
<input type="hidden" name="correct" value="<?=$correct?>">
<input type="hidden" name="one" value="<?=$one?>">
<input type="hidden" name="two" value="<?=$two?>">

<? } ?>
<input type="submit" name="reset" value="Reset">
</form>

</body>

</html>
