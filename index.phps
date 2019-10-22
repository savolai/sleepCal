<?php 
addMissingTrailingSlash();


// emulate apache behaviour that is broken by .htaccess on savolai.net
function addMissingTrailingSlash(){
	$currentFile=basename($_SERVER['PHP_SELF']);
	if($currentFile==="index.php"){
		$currentURL=curPageURL();
		if(substr($currentURL,-1) != '/'){
			 header("HTTP/1.1 301 Moved Permanently"); 
			 header("Location:${currentURL}/");
		 
		}
	} 

}

 function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>
<?php include("core_source.php");?>


<!-- visitor tracking, remove the below if you use this outside pilpi.net -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://pilpi.net/!res/piwik/" : "http://pilpi.net/!res/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://pilpi.net/!res/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- end: visitor tracking -->


</body></html>
