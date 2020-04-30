# sleepCal

SleepCal - https://savolai.net/software/sleepcal/

Sleeping calendar for circadian rhythm disorder/non-24 patients (G47.2)

Written as a single source file due to the simplicity of the app, to make code maintenance simple.

Copyright (c) 2012, Olli Savolainen 
All rights reserved. 
open source, bsd 2-clause license

***

## This app is a strange loop

Pardon the reference to the lovely book.
https://en.wikipedia.org/wiki/I_Am_a_Strange_Loop

And no, I don't think this is actually not a strange loop in terms of the official definition.
https://en.wikipedia.org/wiki/Strange_loop

With sleepCal, I decided to allow myself to go the easiest scripting route possible. In a way, this is not far from what scripting in Excel is like. No architecture, just very immediate goal centered coding. Definitely not software engineering, just easy coding.

So the entire app is a single PHP file. (Okay, behind the scenes there’s another one that acts as an include wrapper, but has no actual domain functionality.)

How does it work? Well, it takes advantage of PHP’s very simple way of passing parameters to the page to the program using the $_GET array. You enter any of the numerical parameters into the form and press submit. They get sent to the server and immediately passed back to the script itself, to produce a new page. 

(These are HTTP GET parameters, so you may want to check what those mean. 
Also, caveat: Always check user input from that $_GET array, it may be insecure and try to hack you.) 

Basically what happens is that if all of the numerical parameters are entered in an acceptable way, the table of sleeping times gets generated. If not, an error message is shown. This is what I mean by strange loop above: The script produces the same page from itself over and over again, just modified according to the parameter values. 

There is no client side logic. There are no pages for showing the results, separate from the form page itself. Even the CSS is inlined, because why not? There's only a single page to show it anyway. (Don't come whining to me about wasting bandwidth. The page is tiny anyway.) It's a kind of a strange loop.

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
* 2019-10-22: added viewport meta tag and some line breaks to make it responsive on mobile devices, fixed show only calendar, added to github


... but then, I guess could've just taught them to use a spreadsheet program ...


BSD 2-Clause License

Copyright (c) 2012, Olli Savolainen
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
