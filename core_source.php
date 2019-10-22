<!DOCTYPE html><html lang="en-us"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!--
SleepCal - http://www.pilpi.net/software/sleepcal/
Sleeping calendar for circadian rhythm disorder/non-24 patients (G47.2)
Written as a single source file due to the simplicity of the app, to make code maintenance simple.
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
* use hours and minutes instead of decimals
* use HTML5 time/date element for form controls and perhaps jQuery UI for the UI for non-HTML5 compliant browsers- http://www.w3.org/TR/2012/WD-html-markup-20120329/input.time.html  http://www.javascriptkit.com/javatutors/createelementcheck2.shtml
* as options increase, use progressive disclosure with html5 details element http://webcloud.se/code/jQuery-Collapse/
* use html5 date controls backed by
* instead of the number of hours the rhythm moves each day, allow giving length of sleep period, length of awake period to determine calendar 
* iCal etc. export
* visualize when the hour cycle starts repeating itself
* host an SSL-enabled version on a separate server, symlink the source so both update at the same time

*** 

CHANGES
* 2014-01-09: fixed issue in Chrome/Chromium where input type="number" without step attribute would not allow entering decimal numbers
* 2019-10-22: added viewport meta tag and some line breaks to make it responsive on mobile devices

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
#footer{clear:both;}

#content{padding:1em;background-color:#eee;color:black;}
table{width:10em;}
tr{border-bottom:thin solid grey;}
tr.past td{color:#999;}
th{font-weight:bold;}
.help{background-color:#d0e0ff; padding:0.2em;margin-bottom:0.3em;}
.notification{clear:both;background-color:#ffe0d0; padding:0.2em;margin-bottom:0.3em;}
q{font-style:italic;line-height:1em;}
#header,#footer{padding:0.5em;}
#sidehelp{background-color:#d0e0ff; padding:0.2em;margin-bottom:0.3em;}

@media only screen and (min-width: 954px){
#sidehelp{
float:right;width:30%
}
}
input[type="submit"],input[type="submit"]:hover {
clear:both;
margin-top:0.3em;
background-color:#e6eaff;
}
hr{margin:1px 0 1px 0;padding:0 0 0 0 !important;line-height:1px;width:30em;}
form{
display:block;
float:left;}
table{clear:both;}
html body  blockquote.style1 {
  font: 14px/20px italic Times, serif;
  padding: 8px;
  color:#ccc;
  border: 1px solid #555566;
  border-bottom: 1px solid #666688;
  margin: 5px;
  background-image: url(openquote1.gif);
  background-position: top left;
  background-repeat: no-repeat;
  text-indent: 23px;
  }
 html body blockquote.style1 span {
     display: block;
     background-image: url(closequote1.gif);
     background-repeat: no-repeat;
     background-position: bottom right;
   }
<?php if(contains('yes',$_GET['calendar_only'])){ ?>
#header,form,#footer,#sidehelp{display:none;}
body{background-color:white;}
#content{background-color:white;}
blockquote{display:none;}
<?php } ?>
</style></head><body><?php

$minute=60;
$hour=$minute*60;
$day=$hour*24;
$currentday=date('d');
$currentmonth=date('m');
$currentyear=date('Y');
if(is_numeric($_GET['interval']) )
{
$interval=abs($_GET['interval']);
}else{
$interval=1;
}
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
<q>sleeping calendar for <a href='http://en.wikipedia.org/wiki/Non-24-hour_sleep-wake_syndrome'>circadian rhythm disorder/non-24</a> patients (G47.2)</q> - see also: <a href='http://www.circadiansleepdisorders.org/'>Circadian Sleep Disorders Network</a></div><div id='content'><!--<div style=''>do you have an unusual, but regularly changing sleeping rhythm? want to know if you will be awake next time the world cup or the eurovision contest is on? sleepCal is your answer.</div>-->";

if(is_numeric($_GET['todayhour']) && $_GET['calendar_only']!=='yes')
{
echo "<div id='sidehelp'>Note! You can bookmark or save the address of this page to later check the same calendar again.</div>";
}
echo "<form method='GET'><div class='help'>(decimals allowed for hours. use . as separator)</div>
the hour to go to sleep  today: <br><input name='todayhour' type='number' step='0.1' min='0'  style='width:4em;' value='$todayhour'/> <hr />
number of hours sleeping rhythm<br>moves forward in one day: <br>
<input name='interval' type='number' step='0.1' min='0' style='width:4em;' value='$interval'/> <hr />
show <br><input name='viewmonths' type='number' step='0.1' min='0'  style='width:4em;' value='$viewmonths'/>  months +<br>
<input name='viewweeks' type='number' step='0.1' min='0'  style='width:4em;' value='$viewweeks'/> weeks + <br>
<input name='viewdays' type='number' step='0.1' min='0' style='width:4em;' value='$viewdays'/> days
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
    echo '<table><tr><th>Date</th><th>Bedtime</th></tr>';
	$i=$todayhour;
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


		// truncate the string to five characters so it does not mess up the table's layout
		$thishour=mb_substr($thishour,0,5);

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
	echo '<div class="notification">please enter a single number to represent the time of day you should sleep today.</div>';
}else{
echo '<div style="clear:both;">&nbsp;</div>';
}
function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}
?></div>
<div id='footer'>developers wanted, see <a href="source.php">source code</a> for info | 
2012 <a href="http://www.pilpi.net/software/">olli savolainen</a>/<a href="/journal/contact-olli/#FSContact1">contact</a> <br /> 
open source, bsd 2-clause license | hobby project, built for a friend | eye icon courtesy of <a href="http://www.fotocommunity.com/pc/pc/display/18276395">Wilody</a>
<blockquote class="style1"><span>works like a german propeller &mdash;user</span></blockquote></div>


