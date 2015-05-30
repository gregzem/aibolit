For quick check (not recommended)
---------------------------------


1. open /ai-bolit/ai-bolit.php in notepad or any text editor and put any strong password into define('PASS', '....

2. copy all content of /ai-bolit/ folder into the root folder of web site

3. copy appropriate file for your cms from /know_files/ folder into root folder of web site

4. open url in browser: http://your_website/ai-bolit.php?p=specified_password and wait for report

5. once report is generated remove all ai-bolit files from web site



Full scan (recommended):
--------------------------------

1. copy all content of /ai-bolit/ folder into the root folder of web site

2. copy appropriate file for your cms from /know_files/ folder into root folder of web site

3. run server command line though ssh

4. execute the following command
   php ai-bolit.php

5. wait until the report is generated

6. copy file AI-BOLIT-REPORT-<date>-<time>.html from server to your local PC and open it in a browser


---

If you don't know how to read the report, remove malicious code or protect your website, email me audit@revisium.com. 
