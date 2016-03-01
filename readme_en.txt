AI-BOLIT scanner is designed to scan the site for viruses and malware. It can be used as a preventive measure to regularly check the site for the viruses, and to find the hacker shells, backdoors, phishing pages, malware insertions, doorway pages, link spam and other malware pieces in the files.

Scanner can run scanning directly on the hosting (recommended start the scanner from the command line via SSH), as well as on the local computer under any operating system (Windows, MacOS X, *nix). AI-BOLIT Scanner using proprietary malware database as well as a special heuristic detection algorith to detect new (not yet known) malicious fragments. In case of detection of dangerous files it generates a report with a list of files in html or text format.

The scanner has two operational modes: "common" and "paranoid".

For the diagnosis of the website infection it is enough to check the files in the "common" mode. He gives few false positives and is suitable for assessing the infection site or fact of compromise. In order to thoroughly check out the site for viruses and hacker scripts, as well as generate a report for the treatment site, you need to check the files in the "paranoid" mode. This report does not just known malware fragments or hacker's scripts, but also suspicious fragments that should be analyzed carefully, as they could potentially be harmful.

Sometimes, the same sections of code can be used as a hacker scripts and script of legitimate CMS. Since it is impossible to automatically determine whether the malicious snippet is for 100%. This file will be listed on the report, and you should manually check if the file is dangerous.

If you have any questions regarding the report, you can always send it for analysis to ai@revisium.com (in .zip archive with the password).


Full scan (recommended):
--------------------------------

1. copy all content of /ai-bolit/ folder into the root folder of web site

2. run server command line though ssh

3. execute the following command

   php ai-bolit.php

   In order to run scanner in "paranoid" mode use arguments

   php ai-bolit.php --mode=2 

4. wait until the report is generated

5. copy file AI-BOLIT-REPORT-<date>-<time>.html from server to your local PC and open it in a browser

---

If you don't know how to analyze the report, or you need to remove malicious code or protect your website from hackers, email us ai@revisium.com. 

---

Revisium - website cured and secured
https://revisium.com/en/home/
ai@revisium.com
