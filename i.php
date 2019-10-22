<!DOCTYPE html><html lang="en-us"><head><meta charset="utf-8">
<!--
Copyright (c) 2012, Olli Savolainen 
All rights reserved. 

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

***

TODO - DEVELOPERS WANTED!
if you would like to develop this further, patches are welcome and I could set up gitHub if you want to work through there.
* add a real calendar view such as http://arshaw.com/fullcalendar/
* store user input in a cookie or with a user ID (facebook/google login?) so that users can return to calendar to see their up-to-date calendar even without having the bookmark with them
* there seems to be a bug in the past date dimming sometimes such that even the current day gets dimmed
* allow setting the calendar starting time (use progressive disclosure in the UI)
* use hours and minutes instead of decimals; current i.php needs to not convert to decimals in between but calculate separate hours and minutes all the time
* use HTML5 time element for form controls and perhaps jQuery UI for the UI for non-HTML5 compliant browsers- http://www.w3.org/TR/2012/WD-html-markup-20120329/input.time.html
* iCal etc. export
* visualize when the hour cycle starts repeating itself

... but then, I guess could've just taught them to use a spreadsheet program ...
-->
<title>sleepCal - sleeping calendar for circadian rhythm disorder/non-24 patients (G47.2)</title>
	<link rel="stylesheet" href="skeleton/stylesheets/base.css">
	<link rel="stylesheet" href="skeleton/stylesheets/skeleton.css">
	<link rel="stylesheet" href="skeleton/stylesheets/layout.css">
<style>
body{background-color:#163039;color:white;}
h1{color:white;line-height: 46px; position:relative;top:0.2em;}
#header a, #footer a{color:white;}
#content{padding:1em;background-color:#eee;color:black;}
table{width:10em;}
tr{border-bottom:thin solid grey;}
tr.past td{color:#999;}
th{font-weight:bold;}
.help{background-color:#d0e0ff; padding:0.2em;margin-bottom:0.3em;}
q{font-style:italic;line-height:1em;}
#header,#footer{padding:0.5em;}
#sidehelp{float:right;width:30%;background-color:#d0e0ff; padding:0.2em;margin-bottom:0.3em;}
<?php if($_GET['calendar_only']==='yes'){ ?>
#header,form,#footer{display:none;}
body{background-color:white;}
#content{background-color:white;}
<?php } ?>
</style></head><body><?php

$minute=60;
$hour=$minute*60;
$day=$hour*24;
$currentday=date('d');
$currentmonth=date('m');
$currentyear=date('Y');
if(is_numeric($_GET['intervalhour']) )
{
$intervalhour=abs($_GET['intervalhour']);
}else{
$intervalhour=1;
}
if(is_numeric($_GET['intervalminute']) )
{
$intervalminute=abs($_GET['intervalminute']);
}else{
$intervalminute='00';
}
$interval=$intervalhour+($intervalminute/60);
if(is_numeric($_GET['startday']) )
{
$startday=abs($_GET['startday']);
}else{
$startday=$currentday;
}
if(is_numeric($_GET['startmonth']) )
{
$startmonth=abs($_GET['startmonth']);
}else{
$startmonth=$currentmonth;
}
if(is_numeric($_GET['startyear']) )
{
$startyear=abs($_GET['startyear']);
}else{
$startyear=$currentyear;
}

if(is_numeric($_GET['todayhour']) )
{
$todayhour=abs($_GET['todayhour']);
}
if(is_numeric($_GET['todayminute']) )
{
$todayminute=abs($_GET['todayminute']);
}else{
$todayminute='00';
}
if(is_numeric($_GET['todayhour']) ){
$todaytime=$todayhour+($todayminute/60);
}

$totalviewdays=0;
if(is_numeric($_GET['viewmonths']) )
{
$viewmonths=abs($_GET['viewmonths']);
$totalviewdays+=30*$viewmonths;
}
else{
$viewmonths=0;
}
if(is_numeric($_GET['viewweeks']) )
{
$viewweeks=abs($_GET['viewweeks']);
$totalviewdays+=7*$viewweeks;
}
else{
$viewweeks=0;
}
if(is_numeric($_GET['viewdays']) )
{
$viewdays=abs($_GET['viewdays']);
$totalviewdays+=$viewdays;
}
else{
$viewdays=5;
}

echo "<div id='header'><h1><img src='eye.jpg' alt='' style='vertical-align:-10%;' /> sleepCal</h1> 
<q>sleeping calendar for <a href='http://en.wikipedia.org/wiki/Non-24-hour_sleep-wake_syndrome'>circadian rhythm disorder/non-24</a> patients (G47.2)</q></div><div id='content'>";

if(is_numeric($_GET['todayhour']) && $_GET['calendar_only']!=='yes')
{
echo "<div id='sidehelp'>Note! You can bookmark or save the address of this page to later check the same calendar again.</div>";
}
echo "<form method='GET'><div class='help'>(decimals allowed for hours. use . as separator)</div>
the hour to go to sleep  today: <input name='todayhour' style='width:3em;' value='$todayhour'/>:<input name='todayminute' style='width:3em;' value='$todayminute'/> <br />
number of hours sleeping rhythm moves forward in one day? 
<input name='intervalhour' style='width:3em;' value='$intervalhour'/><input name='intervalminute' style='width:3em;' value='$intervalminute'/> <br />
show <input name='viewmonths' style='width:3em;' value='$viewmonths'/>  months +
<input name='viewweeks' style='width:3em;' value='$viewweeks'/> weeks + 
<input name='viewdays' style='width:3em;' value='$viewdays'/> days
<br />
<input type='submit'  value='make my calendar!' />
<input type='hidden' name='startday'  value='$currentday' />
<input type='hidden' name='startmonth'  value='$currentmonth' />
<input type='hidden' name='startyear'  value='$currentyear' />";
if(is_numeric($_GET['todayhour']) && $_GET['calendar_only']!=='yes')
{
	echo " <a href='?interval=$interval&amp;todayhour=$todayhour&amp;viewmonths=$viewmonths&amp;viewweeks=$viewweeks&amp;viewdays=$viewdays&amp;startday=$startday&amp;startmonth=$startmonth&amp;startyear=$startyear&amp;calendar_only=yes'>show only calendar</a>";
}
echo "</form>";
if(is_numeric($_GET['todayhour']) )
{
    echo '<table><tr><th>Date</th><th>Time</th></tr>';
	$i=$todaytime;
	for($daynumber=0;$daynumber<$totalviewdays;$daynumber++){

		if($i<24){
			$thishour=$i;
		}else{
			$thishour=$i-24;
			while($thishour>=24){
				$thishour=$thishour-24;
			}
		}

		//calculate the minute based on the decimals of the hour
		$thishourArray=explode('.',$thishour);
        if(isset($thishourArray[1])){
		        $thishourdecimals=$thishourArray[1];
                $thisminute=round(60*($thishourdecimals/10));
				// truncate the string to two numbers to prevent effects of rounding errors
				$thisminute=mb_substr($thisminute,0,2);
                $thishour=$thishourArray[0].":".$thisminute;
        }




		//the timestamp for the  date for the hour of the current row
		$timestamp=mktime(23,59,59,$startmonth,$startday,$startyear)+$day*$daynumber;
		$currenttimestamp=time();
		if($currenttimestamp>$timestamp){
			echo "<tr class='past'>";
		}else{
			echo "<tr>";
		}
		echo "<td>";
		echo date('D j M',$timestamp)."</td><td> ".$thishour."<br>";
		echo "</td>";
		echo "</tr>";

		$i=$i+$interval;
	}
	echo '</table>';
}else if(!empty($_GET['todayhour']) OR (empty($_GET['todayhour']) AND !empty($_GET['interval']))){
	echo 'please enter a single number to represent the time of day you should sleep today.';
}

?></div>
<div id='footer'>developers wanted, see <a href="index.phps">source code</a> for info | 
2012 <a href="http://www.pilpi.net/software/">olli savolainen</a>/<a href="/journal/contact-olli/#FSContact1">contact</a><br /> 
open source, bsd 2-clause license | eye icon courtesy of <a href="http://www.fotocommunity.com/pc/pc/display/18276395">Wilody</a></div>


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
