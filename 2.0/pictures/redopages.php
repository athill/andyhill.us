<?php
//Recreates assoc.txt and web pages based on current hash array

function redo($hash) {
  $writer = fopen("assoc.txt", "w") or die("Couldn't open assoc");

  //Update assoc.txt
  foreach ($hash as $pic => $desc) {
    if (preg_match("/.*\..*/", $pic)) {
      fwrite ($writer, "$pic:$hash[$pic]\n");
    } else {
      unset($hash[$pic]);
    }
  }
  fclose($writer);

  //determine number of pages to be created
  $length = count($hash);
  $pagecount = ceil($length/8);

  $count = 0;
  $page = 0;


  //Write html pages
  foreach ($hash as $pic => $desc) {
     $count++;
  //8 pictures to a page. If one more move to next page.
  //Create new page if necessary 
     if (($count%8) == 1) {
       $page++;
       $file = "${path}fam${page}.html";
       print "file: $file<br />\n";
       if (!(file_exists($file))) {
         if (touch($file)) {
           print "success";
         } else {
           print "fail";
         }
         chmod($file, 0755);
         print("file exists.");
       }
       $html = fopen($file, "w") or die("Couldn't open file");
	fwrite($html, "<!DOCTYPE html PUBLIC");
	fwrite($html, " '-//W3C//DTD XHTML 1.0 Transitional//EN'\n");
	fwrite($html, "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>"); 
	fwrite($html, "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>\n");
	fwrite($html, "<head>\n");
	fwrite($html, "<meta http-equiv='Content-Type' content='text/html;charset=UTF-8' />\n");
       fwrite($html, "<title>Andy's Pics $page</title>\n");
       fwrite($html, "<link rel='stylesheet' type='text/css'");
       fwrite($html, " href='famstyle.css' />\n\n");
       fwrite($html, "\n\n</head>\n\n");
       fwrite($html, "<body bgcolor='blue' alink='white' vlink='white'>");
       fwrite($html, "<table width='900' align='center' cellspacing='10'>\n");
       fwrite($html, "<tr>\n\t<td>\n");
       fwrite($html, "\t<h1 align='center'>Andy's Pictures, page $page</h1>");
       fwrite($html, "\tThese pages were auto-generated using PHP and a \n");
       fwrite($html, "\ttext file mapping images to comments.\n");
  //Create links to other pages
       fwrite($html, "\t</td>\n</tr>\n<tr>\n\t<td>\n");
       for ($i = 1; $i <= $pagecount; $i++) {
         if ($i != $page) {
           fwrite($html, "&bull;<a href='fam${i}.html'>Page $i</a>\n");
         } else {
           fwrite($html, "&bull;Page $i\n");
         }
       }
       fwrite($html, "\t</td>\n</tr>\n</table>\n");
       fwrite($html, "<table width='900' cellspacing='10' align='center'>\n");
    }
    if (($count%2) == 1) {
      fwrite($html, "<tr>\n");
    }
    if ($pic == "" or $pic == " ") {
      unset($hash[$pic]);
    } else {
      $hash[$pic] = preg_replace("/[\n\r]/", "", $hash[$pic]);
      $alt = preg_replace("/<[^>]*>/", "", $hash[$pic]);
      $alt = preg_replace("/[\'\"]/", "", $alt);
      fwrite($html, "\t<td valign='top'>\n");
      fwrite($html, "\t<img src='images/$pic' width='400' height='300'\n" 
.
	"\talt='$alt' />\n\t<br />\n");
      $text = preg_replace('/\\\"/', '"', $hash[$pic]);
      $text = preg_replace("/\\\'/","'", $text);
      fwrite($html, "\t$text\n\t</td>\n");
    }
    if (($count%2) == 0) {
      fwrite($html, "</tr>\n");
    }
    if (($count%8) == 0) {
      fwrite($html, "</table>\n</body>\n\n</html>");
      fclose($html);
    }
  }
  $length = count($hash);
  if (($length%8) != 0) {
    if (($length%2) !=0) {
      fwrite($html, "</tr>\n");
    } 
    fwrite($html, "</table>\n</body>\n\n</html>");
    fclose($html);
  }
}
?>

