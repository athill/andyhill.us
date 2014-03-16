<html><head><title>A Guessing Game</title></head>
<body bgcolor="black" text="white">
<center>
<h1>A Guessing Game</h1>

<h3>Try to guess a number between 1 and 100 in ten or less tries.</h3>
<?
  if ($reset) {
    $count = 0;
    $answer = rand(0,100);
  }
  if ($answer) {
  }
  else {
    $answer=rand(0, 100);
  }
  if ($guess) {
    if ($guess > $answer) {
      echo "$guess is too high\n";
    }
    else if ($guess < $answer) {
      echo "$guess is too low\n";
    }
    else { 
      echo "You win!!!\n"; 
    }
  }
  else {
    echo " \n";
  }
  if ($count) {
    if ($count < 10) {
	$count += 1;
    }
  }
  else {
    $count = 1;
  }
  if ($count > 9) {
    echo "Sorry, you lost. The number was $answer";
  }
?>

<form method="POST" action="<?=$SCRIPT_NAME?>">
Try number <?=$count?><p>
What is your guess?<input type="text" name="guess"><p>

Submit your guess:<input type="submit" value="proceed"><p>
or, start a new game:<input type="submit" name="reset" value = "reset">


<input type="hidden" name="count" value="<?=$count?>">
<input type="hidden" name="answer" value="<?=$answer?>">
</form>
</body>
</html>

 
        

