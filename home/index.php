<img src="/home/images/andy.jpg" align="right" height="267" width="300" />


<p>
I live in  in <?php $h->a("http://bloomington.in.gov/", "Bloomington, IN"); ?>, which I think 
is a darn cool town overall. There's a lot to do for a town of its size.</p>
<p>
I went to <a href="http://www.iub.edu">Indiana University</a> from 1989-92, majoring in Anthropology,  
went back in 2000, and graduated in May of 2003 with a Bachelor of Science in Computer Science. I'm currently working at IU's 
<a href="http://ses.iu.edu">Student Enrollment Services</a>, primarily as a web programmer.</p>
<?php	
if ($_SESSION['admin']) {
?>
Favorite Links: <br />
Common:
&bull;<a href="http://www.theonion.com">The Onion </a>
&bull;<a href="http://www.fark.com">fark.com</a>
&bull;<a href="http://www.somethingawful.com">Something Awful </a> 
&bull;<a href="http://www.thesuperficial.com">The Superficial </a> 
&bull;<a href="http://www.idontlikeyouinthatway.com">I Don't Like You in that Way </a> 
&bull;<a href="http://www.worth1000.com">Worth1000</a>
&bull;<a href="http://www.drudgereport.com">Drudge Report.com</a>
<br />

Bloomington:
&bull;<a href="http://musicalfamilytree.com">musicalfamilytree.com</a>
&bull;<a href="http://bloomingtonalternative.com">Bloomington Alternative</a> 
&bull;<a href="http://www.secondstorynightclub.com">2nd Story </a> 
&bull;<a href="http://www.monroe.lib.in.us/home.html">MCPL</a>
&bull;<a href="http://www.theryder.com">The Ryder </a>

&bull;<a href="http://www.artlives.org">BAAC </a>

&bull;<a href="http://landlockedmusic.com">Landlocked Music</a>
&bull;<a href="http://arthospital.net/home.php">Art Hospital</a> 
&bull;<a href="http://www.bloomingfoods.org/">Bloomingfoods</a>
<br />

Radio: 
&bull;<a href="http://www.kexp.org">KEXP </a>
&bull;<a href="http://wiux.org">WIUX </a>
&bull;<a href="http://wfhb.org">WFHB </a>
<br />

<?php
function doSites($header, $sites) {
	print("$header: \n");
	for ($i = 0; $i < count($sites); $i++) {
		print("&bull;<a href=\"" . $sites[$i][0] . "\">" . $sites[$i][1] . "</a>\n");	
	}
	print("<br />");
}


//Computers
$sites = array();
$sites[] = array("http://slashdot.org", "slashdot.org");
$sites[] = array("http://www.cs.indiana.edu/csg/links/jdk1.2.2/docs/api/index.html", "Java APIs");
$sites[] = array("http://www.mysql.com", "mysql.com");
doSites("Computers", $sites);

////Right
$sites = array();
$sites[] = array("http://biggovernment.com/", "Big Government");
$sites[] = array("http://bighollywood.breitbart.com/", "Big Hollywood");
$sites[] = array("http://breitbart.tv/", "Breitbart.tv");
$sites[] = array("http://newsbusters.org", "News Busters");
$sites[] = array("", "");
doSites("Right", $sites);
}
?>

