# sleepCal

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

## TODO - DEVELOPERS WANTED!

if you would like to develop this further, patches are welcome and I could set up gitHub if you want to work through there.
* add a real calendar view such as http://arshaw.com/fullcalendar/
* store user input in a cookie or with a user ID (facebook/google login?) so that users can return to calendar to see their up-to-date calendar even without having the bookmark with them
* there seems to be a bug in the past date dimming sometimes such that even the current day gets dimmed
* allow setting the calendar starting time (use progressive disclosure in the UI)
* use hours and minutes instead of decimals
* use HTML5 time/date element for form controls and perhaps jQuery UI for the UI for non-HTML5 compliant browsers- http://www.w3.org/TR/2012/WD-html-markup-20120329/input.time.html  http://www.javascriptkit.com/javatutors/createelementcheck2.shtml
* as options increase, use progressive disclosure with html5 details element http://webcloud.se/code/jQuery-Collapse/
* use html5 date controls backed by
* instead of the number of hours the rhythm moves each day, allow giving length of sleep period, length of awake period to determine calendar 
* iCal etc. export
* visualize when the hour cycle starts repeating itself
* host an SSL-enabled version on a separate server, symlink the source so both update at the same time
*** 
CHANGES
* 2014-01-09: fixed issue in Chrome/Chromium where input type="number" without step attribute would not allow entering decimal numbers
* 2019-10-22: added viewport meta tag and some line breaks to make it responsive on mobile devices
... but then, I guess could've just taught them to use a spreadsheet program ...
