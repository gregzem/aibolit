<?php
///////////////////////////////////////////////////////////////////////////
// Created and developed by Greg Zemskov, Revisium Company
// Email: ai@revisium.com, http://revisium.com/ai/, skype: greg_zemskov

// Commercial usage is not allowed without a license purchase or written permission of the author
// Source code and signatures usage is not allowed

// Certificated in Federal Institute of Industrial Property in 2012
// http://revisium.com/ai/i/mini_aibolit.jpg

////////////////////////////////////////////////////////////////////////////
// Запрещено использование скрипта в коммерческих целях без приобретения лицензии.
// Запрещено использование исходного кода скрипта и сигнатур.
//
// По вопросам приобретения лицензии обращайтесь в компанию "Ревизиум": http://www.revisium.com
// ai@revisium.com
// На скрипт получено авторское свидетельство в Роспатенте
// http://revisium.com/ai/i/mini_aibolit.jpg
///////////////////////////////////////////////////////////////////////////

// put 1 for expert mode, 0 for basic check and 2 for paranoic mode
// установите 1 для режима "Эксперта", 0 для быстрой проверки и 2 для параноидальной проверки (для лечения сайта) 
define('AI_EXPERT_MODE', 2); 

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 
define('PASS', '?????????????????'); 

//define('LANG', 'EN');
define('LANG', 'RU');

define('REPORT_MASK_PHPSIGN', 1);
define('REPORT_MASK_SPAMLINKS', 2);
define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_SUSP', 8);
define('REPORT_MASK_CANDI', 16);
define('REPORT_MASK_WRIT', 32);
define('REPORT_MASK_FULL', REPORT_MASK_PHPSIGN 
/* <-- remove this line to enable "recommendations"  
| REPORT_MASK_DOORWAYS | REPORT_MASK_SUSP
| REPORT_MASK_SPAMLINKS 

 remove this line to enable "recommendations" --> */
);

define('SMART_SCAN', 1);

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '400K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
    'skip_ext' => '',
	'report_mask' =>  REPORT_MASK_FULL // full-featured report
);


define('DEBUG_MODE', 0);

define('DIR_SEPARATOR', '/');

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)/* && stripos('CygWin', $_SERVER['OS']) === false)*/) {
   define('DIR_SEPARATOR', '\\');
}

$g_SuspiciousFiles = array('cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'suspicious');
$g_SensitiveFiles = array_merge(array('php', 'js', 'htaccess', 'html', 'htm', 'tpl', 'inc', 'css', 'txt', 'sql'), $g_SuspiciousFiles);
$g_CriticalFiles = array('php', 'htaccess', 'cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'suspicious');
$g_CriticalEntries = '<\?php|<\?=|#!/usr|#!/bin|eval|assert|base64_decode|system|create_function|exec|popen|fwrite|fputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|move|copy|array_|reg_replace|mysql_|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles = array('js', 'html', 'htm', 'suspicious');
$g_VirusEntries = '<\s*script|<\s*iframe|<\s*object|<\s*embed|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles = array('js', 'html', 'htm', 'suspicious', 'php');
$g_PhishEntries = '<\s*title|<\s*html|<\s*form|<\s*body';

if (LANG == 'RU') {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RUSSIAN INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('AI_STR_001', 'Отчет сканера AI-Bolit v@@VERSION@@:');
define('AI_STR_002', '<b>Компания <a href="http://revisium.com/">"Ревизиум"</a>. Лечение сайтов от вирусов и защита от взлома.</b><p>Предлагаем услуги превентивной защиты сайта от взлома с использованием процедуры cms hardening ("цементирование сайта"). Подробности на <a href="http://revisium.com/ru/clients_faq/#m4">странице услуги</a>. <p>Лучшее лечение &mdash; это профилактика.');
define('AI_STR_003', 'Не оставляйте файл отчета на сервере, и не давайте на него прямых ссылок с других сайтов. Информация из отчета может быть использована злоумышленника для взлома сайта, так как содержит информацию о файлах и настройках сервера.');
define('AI_STR_004', 'Путь');
define('AI_STR_005', 'Изменение свойств');
define('AI_STR_006', 'Изменение содержимого');
define('AI_STR_007', 'Размер');
define('AI_STR_008', 'Конфигурация PHP');
define('AI_STR_009', "Вы установили слабый пароль на скрипт AI-BOLIT. Укажите пароль не менее 8 символов, содержащий латинские буквы в верхнем и нижнем регистре, а также цифры. Например, такой <b>%s</b>");
define('AI_STR_010', "Сканер AI-Bolit запускается с паролем. Если это первый запуск сканера, вам нужно придумать сложный пароль и вписать его в файле ai-bolit.php в строке №28. <p>Например, <b>define('PASS', '%s');</b><p>
После этого откройте сканер в браузере, указав пароль в параметре \"p\". <p>Например, так <b>http://mysite.ru/ai-bolit.php?p=%s</b>. ");
define('AI_STR_011', 'Текущая директория не доступна для чтения скрипту. Пожалуйста, укажите права на доступ <b>rwxr-xr-x</b> или с помощью командной строки <b>chmod +r имя_директории</b>');
define('AI_STR_012', "Затрачено времени: <b>%s</b>. Сканирование начато %s, сканирование завершено %s");
define('AI_STR_013', 'Всего проверено %s директорий и %s файлов.');
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Внимание, скрипт выполнил быструю проверку сайта. Проверяются только наиболее критические файлы, но часть вредоносных скриптов может быть не обнаружена. Пожалуйста, запустите скрипт из командной строки для выполнения полного тестирования. Подробнее смотрите в <a href="http://revisium.com/ai/faq.php">FAQ вопрос №10</a>.</div>');
define('AI_STR_015', '<div class="title">Требуют внимания</div>');
define('AI_STR_016', 'Эти файлы могут быть вредоносными или хакерскими скриптами');
define('AI_STR_017', 'Вредоносные скрипты не обнаружены');
define('AI_STR_018', 'Эти файлы могут быть javascript вирусами');
define('AI_STR_019', 'Обнаружены сигнатуры исполняемых файлов unix и нехарактерных скриптов. Они могут оказаться вредоносными файлами');
define('AI_STR_020', 'Двойное расширение, зашифрованный контент или подозрение на вредоносный скрипт. Требуется дополнительный анализ данных файлов');
define('AI_STR_021', 'Подозрение на вредоносный скрипт.');
define('AI_STR_022', 'Символические ссылки (symlinks)');
define('AI_STR_023', 'Скрытые файлы');
define('AI_STR_024', 'Возможно, каталог с дорвеем');
define('AI_STR_025', 'Не найдено директорий c дорвеями');
define('AI_STR_026', 'Предупреждения');
define('AI_STR_027', 'Подозрение на мобильный редирект, подмену расширений или автовнедрение кода');
define('AI_STR_028', 'В не .php файле содержится стартовая сигнатура PHP кода. Возможно, там вредоносный код');
define('AI_STR_029', 'Код биржи ссылок');
define('AI_STR_030', 'Непроверенные файлы - ошибка чтения');
define('AI_STR_031', 'Невидимые ссылки. Подозрение на ссылочный спам');
define('AI_STR_032', 'Невидимые ссылки');
define('AI_STR_033', 'Отображены только первые ');
define('AI_STR_034', 'Подозрение на дорвей');
define('AI_STR_035', 'Скрипт использует код, который часто встречается во вредоносных скриптах');
define('AI_STR_036', 'Директории из файла .adirignore были пропущены при сканировании');
define('AI_STR_037', 'Версии найденных CMS');
define('AI_STR_038', 'Большие файлы (больше чем %s). Пропущено');
define('AI_STR_039', 'Не найдено файлов больше чем %s');
define('AI_STR_040', 'Временные файлы или файлы(каталоги) - кандидаты на удаление по ряду причин');
define('AI_STR_041', 'Потенциально небезопасно! Директории, доступные скрипту на запись');
define('AI_STR_042', 'Не найдено директорий, доступных на запись скриптом');
define('AI_STR_043', 'Использовано памяти при сканировании: ');
define('AI_STR_044', 'Просканированы только файлы, перечисленные в ' . DOUBLECHECK_FILE . '. Для полного сканирования удалите файл ' . DOUBLECHECK_FILE . ' и запустите сканер повторно.');
define('AI_STR_045', '<div class="rep">Внимание! Выполнена экспресс-проверка сайта. Просканированы только файлы с расширением .php, .js, .html, .htaccess. В этом режиме могут быть пропущены вирусы и хакерские скрипты в файлах с другими расширениями. Чтобы выполнить более тщательное сканирование, поменяйте значение настройки на <b>\'scan_all_files\' => 1</b> в строке 50 или откройте сканер в браузере с параметром full: <b><a href="ai-bolit.php?p=' . PASS . '&full">ai-bolit.php?p=' . PASS . '&full</a></b>. <p>Не забудьте перед повторным запуском удалить файл ' . DOUBLECHECK_FILE . '</div>');
define('AI_STR_050', 'Замечания и предложения по работе скрипта и не обнаруженные вредоносные скрипты присылайте на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<p>Также будем чрезвычайно благодарны за любые упоминания скрипта AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. Ссылочку можно поставить на <a href="http://revisium.com/ai/">http://revisium.com/ai/</a>. <p>Если будут вопросы - пишите <a href="mailto:ai@revisium.com">ai@revisium.com</a>. ');
define('AI_STR_051', 'Отчет по ');
define('AI_STR_052', 'Эвристический анализ обнаружил подозрительные файлы. Проверьте их на наличие вредоносного кода.');
define('AI_STR_053', 'Много косвенных вызовов функции');
define('AI_STR_054', 'Подозрение на обфусцированные переменные');
define('AI_STR_055', 'Подозрительное использование массива глобальных переменных');
define('AI_STR_056', 'Дробление строки на символы');
define('AI_STR_057', 'Сканирование выполнено в экспресс-режиме. Многие вредоносные скрипты могут быть не обнаружены.<br> Рекомендуем проверить сайт в режиме "Эксперт" или "Параноидальный". Подробно описано в <a href="http://revisium.com/ai/faq.php">FAQ</a> и инструкции к скрипту.');
define('AI_STR_058', 'Обнаружены фишинговые страницы');

define('AI_STR_059', 'Возможен редирект');
define('AI_STR_060', 'Подозрение на вредоносный скрипт');
define('AI_STR_061', 'Подозрение на JS вирус');
define('AI_STR_062', 'Возможно, фишинговые страниц');
define('AI_STR_063', 'Исполняемых файлы Unix');
define('AI_STR_064', 'IFRAME вставки');
define('AI_STR_065', 'Пропущенных больших файлов');
define('AI_STR_066', 'Ошибок чтения файлов');
define('AI_STR_067', 'Зашифрованных файлов');
define('AI_STR_068', 'Подозрительных (эвристика)');
define('AI_STR_069', 'Символических ссылок');
define('AI_STR_070', 'Скрытых файлов');
define('AI_STR_072', 'Рекламных ссылок и кодов');
define('AI_STR_073', 'Пустых ссылок');
define('AI_STR_074', 'Сводный отчет');
define('AI_STR_075', 'Скрипт бесплатный только для личного некоммерческого использования. Есть <a href="http://revisium.com/ai/faq.php#faq11" target=_blank>коммерческая лицензия</a> (пункт №11).');

$tmp_str = <<<HTML_FOOTER
   <div class="disclaimer"><span class="vir">[!]</span> Отказ от гарантий: невозможно гарантировать обнаружение всех вредоносных скриптов. Поэтому разработчик сканера не несет ответственности за возможные последствия работы сканера AI-Bolit или неоправданные ожидания пользователей относительно функциональности и возможностей.
   </div>
   <div class="thanx">
      Замечания и предложения по работе скрипта, а также не обнаруженные вредоносные скрипты вы можете присылать на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<br/>
      Также будем чрезвычайно благодарны за любые упоминания сканера AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. <br/>Ссылку можно поставить на страницу <a href="http://revisium.com/ai/">http://revisium.com/ai/</a>.<br/> 
     <p>Получить консультацию или задать вопросы можно по email <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
	</div>
HTML_FOOTER;

define('AI_STR_076', $tmp_str);
define('AI_STR_077', "Подозрительные параметры времени изменения файла");
define('AI_STR_078', "Подозрительные атрибуты файла");
define('AI_STR_079', "Подозрительное местоположение файла");
define('AI_STR_080', "Обращаем внимание, что обнаруженные файлы не всегда являются вирусами и хакерскими скриптами. Сканер старается минимизировать число ложных обнаружений, но это не всегда возможно, так как найденный фрагмент может встречаться как во вредоносных скриптах, так и в обычных.");
define('AI_STR_081', "Уязвимости в скриптах");

$l_Offer =<<<OFFER
    <div>
	 <div class="crit" style="font-size: 17px;"><b>Внимание! На вашем сайте обнаружен вредоносный код</b>.</div> 
	 <br/>Скорее всего, ваш сайт был взломан и заражен. Вашему сайту требуется помощь специалистов по информационной безопасности.
	</div>
	<br/>
	<div>
	   Обратитесь в <a href="http://revisium.com/" target=_blank>компанию "Ревизиум"</a> за консультацией или закажите лечение сайта и защиту от взлома.<br/>
	</div>
	<br/>
	<div>
	   <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="http://revisium.com/ru/order/">http://revisium.com</a>
	</div>
    <div class="caution">@@CAUTION@@</div>
OFFER;

} else {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ENGLISH INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('AI_STR_001', 'AI-Bolit v@@VERSION@@ Scan Report:');
define('AI_STR_002', '');
define('AI_STR_003', 'Caution! Do not leave either ai-bolit.php or report file on server and do not provide direct links to the report file. Report file contains sensitive information about your website which could be used by hackers. So keep it in safe place and don\'t leave on website!');
define('AI_STR_004', 'Path');
define('AI_STR_005', 'iNode Changed');
define('AI_STR_006', 'Modified');
define('AI_STR_007', 'Size');
define('AI_STR_008', 'PHP Info');
define('AI_STR_009', "Your password for AI-BOLIT is too weak. Password must be more than 8 character length, contain both latin letters in upper and lower case, and digits. E.g. <b>%s</b>");
define('AI_STR_010', "Open AI-BOLIT with password specified in the beggining of file in PASS variable. <br/>E.g. http://you_website.com/ai-bolit.php?p=<b>%s</b>");
define('AI_STR_011', 'Current folder is not readable. Please change permission for <b>rwxr-xr-x</b> or using command line <b>chmod +r folder_name</b>');
define('AI_STR_012', "<div class=\"rep\">%s malicious signatures known, %s virus signatures and other malicious code. Elapsed: <b>%s</b
>.<br/>Started: %s. Stopped: %s</div> ");
define('AI_STR_013', 'Scanned %s folders and %s files.');
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Attention! Script has performed quick scan. It scans only .html/.js/.php files  in quick scan mode so some of malicious scripts might not be detected. <br>Please launch script from a command line thru SSH to perform full scan.');
define('AI_STR_015', '<div class="title">Critical</div>');
define('AI_STR_016', 'Shell script signatures detected. Might be a malicious or hacker\'s scripts');
define('AI_STR_017', 'Shell scripts signatures not detected.');
define('AI_STR_018', 'Javascript virus signatures detected:');
define('AI_STR_019', 'Unix executables signatures and odd scripts detected. They might be a malicious binaries or rootkits:');
define('AI_STR_020', 'Suspicious encoded strings, extra .php extention or external includes detected in PHP files. Might be a malicious or hacker\'s script:');
define('AI_STR_021', 'Might be a malicious or hacker\'s script:');
define('AI_STR_022', 'Symlinks:');
define('AI_STR_023', 'Hidden files:');
define('AI_STR_024', 'Files might be a part of doorway:');
define('AI_STR_025', 'Doorway folders not detected');
define('AI_STR_026', 'Warnings');
define('AI_STR_027', 'Malicious code in .htaccess (redirect to external server, extention handler replacement or malicious code auto-append):');
define('AI_STR_028', 'Non-PHP file has PHP signature. Check for malicious code:');
define('AI_STR_029', 'This script has black-SEO links or linkfarm. Check if it was installed by your:');
define('AI_STR_030', 'Reading error. Skipped.');
define('AI_STR_031', 'These files have invisible links, might be black-seo stuff:');
define('AI_STR_032', 'List of invisible links:');
define('AI_STR_033', 'Displayed first ');
define('AI_STR_034', 'Folders contained too many .php or .html files. Might be a doorway:');
define('AI_STR_035', 'Suspicious code detected. It\'s usually used in malicious scrips:');
define('AI_STR_036', 'The following list of files specified in .adirignore has been skipped:');
define('AI_STR_037', 'CMS found:');
define('AI_STR_038', 'Large files (greater than %s! Skipped:');
define('AI_STR_039', 'Files greater than %s not found');
define('AI_STR_040', 'Files recommended to be remove due to security reason:');
define('AI_STR_041', 'Potentially unsafe! Folders which are writable for scripts:');
define('AI_STR_042', 'Writable folders not found');
define('AI_STR_043', 'Memory used: ');
define('AI_STR_044', 'Quick scan through the files from ' . DOUBLECHECK_FILE . '. For full scan remove ' . DOUBLECHECK_FILE . ' and launch scanner once again.');
define('AI_STR_045', '<div class="notice"><span class="vir">[!]</span> Ai-BOLIT is working in quick scan mode, only .php, .html, .htaccess files will be checked. Change the following setting \'scan_all_files\' => 1 to perform full scanning.</b>. </div>');
define('AI_STR_050', "I'm sincerely appreciate reports for any bugs you may found in the script. Please email me: <a href=\"mailto:audit@revisium.com\">audit@revisium.com</a>.<p> Also I appriciate any reference to the script in your blog or forum posts. Thank you for the link to download page: <a href=\"http://revisium.com/aibo/\">http://revisium.com/aibo/</a>");
define('AI_STR_051', 'Report for ');
define('AI_STR_052', 'Heuristic Analyzer has detected suspicious files. Check if they are malware.');
define('AI_STR_053', 'Function called by reference');
define('AI_STR_054', 'Suspected for obfuscated variables');
define('AI_STR_055', 'Suspected for $GLOBAL array usage');
define('AI_STR_056', 'Abnormal split of string');
define('AI_STR_057', 'Scanning has been done in simple mode. It is strongly recommended to perform scanning in "Expert" mode. See readme.txt for details.');
define('AI_STR_058', 'Phishing pages detected:');

define('AI_STR_059', 'Mobile redirects');
define('AI_STR_060', 'Malware');
define('AI_STR_061', 'JS viruses');
define('AI_STR_062', 'Phishing pages');
define('AI_STR_063', 'Unix executables');
define('AI_STR_064', 'IFRAME injections');
define('AI_STR_065', 'Skipped big files');
define('AI_STR_066', 'Reading errors');
define('AI_STR_067', 'Encrypted files');
define('AI_STR_068', 'Suspicious (heuristics)');
define('AI_STR_069', 'Symbolic links');
define('AI_STR_070', 'Hidden files');
define('AI_STR_072', 'Adware and spam links');
define('AI_STR_073', 'Empty links');
define('AI_STR_074', 'Summary');
define('AI_STR_075', 'For non-commercial use only. Please, purchase the license for commercial usage of the scanner. Email us: ai@revisium.com');

$tmp_str =<<<HTML_FOOTER
		   <div class="disclaimer"><span class="vir">[!]</span> Disclaimer: We're not liable to you for any damages, including general, special, incidental or consequential damages arising out of the use or inability to use the script (including but not limited to loss of data or report being rendered inaccurate or failure of the script). There's no warranty for the program. Use at your own risk. 
		   </div>
		   <div class="thanx">
		      We're greatly appreciate for any references in the social networks, forums or blogs to our scanner AI-BOLIT <a href="http://revisium.com/aibo/">http://revisium.com/aibo/</a>.<br/> 
		     <p>Write us if you have any questions regarding scannner usage or report <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
			</div>
HTML_FOOTER;
define('AI_STR_076', $tmp_str);
define('AI_STR_077', "Suspicious file mtime and ctime");
define('AI_STR_078', "Suspicious file permissions");
define('AI_STR_079', "Suspicious file location");
define('AI_STR_081', "Vulnerable Scripts");


$l_Offer =<<<HTML_OFFER_EN
<div>
 <div class="crit" style="font-size: 17px;"><b>Attention! Malicious software has been detected on the website.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="http://revisium.com/en/home/" target=_blank>contact information security specialist</a> or experienced webmaster to clean the malware.
</div>
<br/>
<div>
   <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="http://revisium.com/ru/order/">http://revisium.com</a>
</div>
<div class="caution">@@CAUTION@@</div>
HTML_OFFER_EN;

define('AI_STR_080', "Notice! Some of detected files may not contain malicious code. Scanner tries to minimize a number of false positives, but sometimes it's impossible, because same piece of code may be used either in malware or in normal scripts.");
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$l_Template =<<<MAIN_PAGE
<html>
<head>
<!-- revisium.com/ai/ -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<title>@@HEAD_TITLE@@</title>
<style type="text/css" title="currentStyle">
	@import "http://revisium.com/extra/media/css/demo_page2.css";
	@import "http://revisium.com/extra/media/css/jquery.dataTables2.css";
</style>

<script type="text/javascript" language="javascript" src="http://yandex.st/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="https://datatables.net/download/build/jquery.dataTables.js"></script>

<style type="text/css">
 body 
 {
   font-family: Tahoma;
   color: #5a5a5a;
   background: #FFFFFF;
   font-size: 14px;
   margin: 20px;
   padding: 0;
 }

.header
 {
   font-size: 34px;
   margin: 0 0 10px 0;
 }

 .hidd
 {
    display: none;
 }
 
 .ok
 {
    color: green;
 }
 
 .line_no
 {
   -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   background: #DAF2C1;
   padding: 2px 5px 2px 5px;
   margin: 0 5px 0 5px;
 }
 
 .credits_header 
 {
  -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   background: #F2F2F2;
   padding: 10px;
   font-size: 11px;
    margin: 0 0 10px 0;
 }
 
 .marker
 {
    color: #FF0090;
	font-weight: 100;
	background: #FF0090;
	padding: 2px 0px 2px 0px;
	width: 2px;
 }
 
 .title
 {
   font-size: 24px;
   margin: 20px 0 10px 0;
   color: #9CA9D1;
}

.summary 
{
  float: left;
  width: 500px;
}

.summary TD
{
  font-size: 12px;
  border-bottom: 1px solid #F0F0F0;
  font-weight: 700;
  padding: 10px 0 10px 0;
}
 
.crit, .vir
{
  color: #D84B55;
}

.spacer
{
   margin: 0 0 50px 0;
   clear:both;
}

.warn
{
  color: #F6B700;
}

.clear
{
   clear: both;
}

.offer
{
  -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   width: 500px;
   background: #ECF7DE;
   color: #747474;
   font-size: 11px;
   font-family: Arial;
   padding: 20px;
   margin: 20px 0 0 500px;
   
   font-size: 16px;
}
 
.flist
{
   font-family: Arial;
}

.flist TD
{
   font-size: 11px;
   padding: 5px;
}

.flist TH
{
   font-size: 12px;
   height: 30px;
   padding: 5px;
   background: #CEE9EF;
}


.it
{
   font-size: 14px;
   font-weight: 100;
   margin-top: 10px;
}

.crit .it A {
   color: #E50931; 
   line-height: 25px;
   text-decoration: none;
}

.warn .it A {
   color: #F2C900; 
   line-height: 25px;
   text-decoration: none;
}



.details
{
   font-family: Calibri;
   font-size: 12px;
   margin: 10px 10px 10px 0px;
}

.crit .details
{
   color: #A08080;
}

.warn .details
{
   color: #808080;
}

.details A
{
  color: #FFF;
  font-weight: 700;
  text-decoration: none;
  padding: 2px;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;
}

.details A:hover
{
   background: #A0909B;
}

.ctd
{
   margin: 10px 0px 10px 0;
   align:center;
}

.ctd A 
{
   color: #0D9922;
}

.disclaimer
{
   color: darkgreen;
   margin: 10px 10px 10px 0;
}

.note_vir
{
   margin: 10px 0 10px 0;
   //padding: 10px;
   color: #FF4F4F;
   font-size: 15px;
   font-weight: 700;
   clear:both;
  
}

.note_warn
{
   margin: 10px 0 10px 0;
   color: #F6B700;
   font-size: 15px;
   font-weight: 700;
   clear:both;
}

.updateinfo
{
  color: #FFF;
  text-decoration: none;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
}


.caution
{
  color: #EF7B75;
  text-decoration: none;
  margin: 20px 0 0px 0px;   
  font-size: 12px;
}

.footer
{
  color: #303030;
  text-decoration: none;
  background: #F4F4F4;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 80px 0 10px 0px;   
  padding: 10px;
}

.rep
{
  color: #303030;
  text-decoration: none;
  background: #94DDDB;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
  font-size: 12px;
}

</style>

</head>
<body>

<div class="header">@@MAIN_TITLE@@ @@PATH_URL@@ (@@MODE@@)</div>
<div class="credits_header">@@CREDITS@@</div>
<div class="details_header">
   @@STAT@@<br/>
   @@SCANNED@@ @@MEMORY@@.
 </div>

 @@WARN_QUICK@@
 
 <div class="summary">
@@SUMMARY@@
 </div>
 
 <div class="offer">
@@OFFER@@
 </div>
  
 <div class="clear"></div>
 
 @@MAIN_CONTENT@@
 
	<div class="footer">
	@@FOOTER@@
	</div>
	
<script language="javascript">

function hsig(id) {
  var divs = document.getElementsByTagName("tr");
  for(var i = 0; i < divs.length; i++){
     
     if (divs[i].getAttribute('o') == id) {
        divs[i].innerHTML = '';
     }
  }

  return false;
}


$(document).ready(function(){
    $('#table_crit').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
		"paging": true,
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );

});

$(document).ready(function(){
    $('#table_vir').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		},

     } );

});

if ($('#table_warn0')) {
    $('#table_warn0').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"paging": true,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );
}

if ($('#table_warn1')) {
    $('#table_warn1').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );
}


</script>
 </body>
</html>
MAIN_PAGE;

$g_AiBolitAbsolutePath = dirname(__FILE__);

if (file_exists($g_AiBolitAbsolutePath . '/ai-design.html')) {
  $l_Template = file_get_contents($g_AiBolitAbsolutePath . '/ai-design.html');
}

$l_Template = str_replace('@@MAIN_TITLE@@', AI_STR_001, $l_Template);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlsnIlwoXCRdIjtpOjEyMjtzOjExOiJcYm1haWxccypcKCI7aToxMjM7czo0NjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccypbJyJdezAsMX1waHA6Ly9pbnB1dCI7aToxMjQ7czoxMTg6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1Db250ZW50LXR5cGVbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfXRleHQvaHRtbDtccypjaGFyc2V0PXdpbmRvd3MtMTI1MVsnIl17MCwxfT48Ym9keT4iO2k6MTI1O3M6NjI6Ij1ccypkb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoXHMqWyciXXswLDF9c2NyaXB0WyciXXswLDF9XHMqXCk7IjtpOjEyNjtzOjY5OiJkb2N1bWVudFwuYm9keVwuaW5zZXJ0QmVmb3JlXChkaXYsXHMqZG9jdW1lbnRcLmJvZHlcLmNoaWxkcmVuXFswXF1cKTsiO2k6MTI3O3M6Nzc6IjxzY3JpcHRccyt0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vW2EtekEtWjAtOV9dKz9cLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));
$g_DBShe = unserialize(base64_decode("YTo0MDc6e2k6MDtzOjg6IlIzRFRVWEVTIjtpOjE7czoyMDoidmlzaXRvclRyYWNrZXJfaXNNb2IiO2k6MjtzOjI1OiJjb21fY29udGVudC9hcnRpY2xlZFwucGhwIjtpOjM7czoxNzoiPHRpdGxlPkVtc1Byb3h5IHYiO2k6NDtzOjEzOiJhbmRyb2lkLWlncmEtIjtpOjU7czoxNToiPT09Ojo6bWFkOjo6PT09IjtpOjY7czo1OiJINHhPciI7aTo3O3M6ODoiUjRwSDR4MHIiO2k6ODtzOjg6Ik5HNjg5U2t3IjtpOjk7czoxNDoiMjE2XC4yMzlcLjMyXC4iO2k6MTA7czoxMzoiZm9wb1wuY29tXC5hciI7aToxMTtzOjEyOiI2NFwuNjhcLjgwXC4iO2k6MTI7czo4OiJIYXJjaGFMaSI7aToxMztzOjE0OiI2NFwuMjMzXC4xNjBcLiI7aToxNDtzOjEzOiIxXC4xNzlcLjI0OVwuIjtpOjE1O3M6MTY6IlBcLmhcLnBcLlNcLnBcLnkiO2k6MTY7czoxNDoiX3NoZWxsX2F0aWxkaV8iO2k6MTc7czo5OiJ+IFNoZWxsIEkiO2k6MTg7czo2OiIweGRkODIiO2k6MTk7czoxNDoiQW50aWNoYXQgc2hlbGwiO2k6MjA7czoxMjoiQUxFTWlOIEtSQUxpIjtpOjIxO3M6MTY6IkFTUFggU2hlbGwgYnkgTFQiO2k6MjI7czo5OiJhWlJhaUxQaFAiO2k6MjM7czoyMjoiQ29kZWQgQnkgQ2hhcmxpY2hhcGxpbiI7aToyNDtzOjc6IkJsMG9kM3IiO2k6MjU7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjI2O3M6MTE6ImRldmlselNoZWxsIjtpOjI3O3M6MzA6IldyaXR0ZW4gYnkgQ2FwdGFpbiBDcnVuY2ggVGVhbSI7aToyODtzOjEwOiJjMjAwN1wucGhwIjtpOjI5O3M6MjI6IkM5OSBNb2RpZmllZCBCeSBQc3ljaDAiO2k6MzA7czoxODoiXCRjOTlzaF91cGRhdGVmdXJsIjtpOjMxO3M6OToiQzk5IFNoZWxsIjtpOjMyO3M6MjA6ImNvb2tpZW5hbWU9IndpZWVlZWUiIjtpOjMzO3M6Mzg6IkNvZGVkIGJ5IDogU3VwZXItQ3J5c3RhbCBhbmQgTW9oYWplcjIyIjtpOjM0O3M6MTI6IkNyeXN0YWxTaGVsbCI7aTozNTtzOjIzOiJURUFNIFNDUklQVElORyAtIFJPRE5PQyI7aTozNjtzOjExOiJDeWJlciBTaGVsbCI7aTozNztzOjc6ImQwbWFpbnMiO2k6Mzg7czoxNDoiRGFya0RldmlselwuaU4iO2k6Mzk7czoyNDoiU2hlbGwgd3JpdHRlbiBieSBCbDBvZDNyIjtpOjQwO3M6MzM6IkRpdmUgU2hlbGwgLSBFbXBlcm9yIEhhY2tpbmcgVGVhbSI7aTo0MTtzOjE1OiJEZXZyLWkgTWVmc2VkZXQiO2k6NDI7czozMjoiQ29tYW5kb3MgRXhjbHVzaXZvcyBkbyBEVG9vbCBQcm8iO2k6NDM7czoyMDoiRW1wZXJvciBIYWNraW5nIFRFQU0iO2k6NDQ7czoyMDoiRml4ZWQgYnkgQXJ0IE9mIEhhY2siO2k6NDU7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjQ2O3M6Mjc6Ikx1dGZlbiBEb3N5YXlpIEFkbGFuZGlyaW5peiI7aTo0NztzOjIyOiJ0aGlzIGlzIGEgcHJpdjMgc2VydmVyIjtpOjQ4O3M6MTM6IkdGUyBXZWItU2hlbGwiO2k6NDk7czoxMToiR0hDIE1hbmFnZXIiO2k6NTA7czoxNDoiR29vZzFlX2FuYWxpc3QiO2k6NTE7czoxNDoiR3JpbmF5IEdvMG9cJEUiO2k6NTI7czozMToiaDRudHUgc2hlbGwgXFtwb3dlcmVkIGJ5IHRzb2lcXSI7aTo1MztzOjI1OiJIYWNrZWQgQnkgRGV2ci1pIE1lZnNlZGV0IjtpOjU0O3M6MTc6IkhBQ0tFRCBCWSBSRUFMV0FSIjtpOjU1O3M6MzI6IkhhY2tlcmxlciBWdXJ1ciBMYW1lcmxlciBTdXJ1bnVyIjtpOjU2O3M6MTE6ImlNSGFCaVJMaUdpIjtpOjU3O3M6OToiS0FfdVNoZWxsIjtpOjU4O3M6NzoiTGl6MHppTSI7aTo1OTtzOjExOiJMb2N1czdTaGVsbCI7aTo2MDtzOjM2OiJNb3JvY2NhbiBTcGFtZXJzIE1hLUVkaXRpb04gQnkgR2hPc1QiO2k6NjE7czoxMDoiTWF0YW11IE1hdCI7aTo2MjtzOjQ5OiJPcGVuIHRoZSBmaWxlIGF0dGFjaG1lbnQgaWYgYW55LGFuZCBiYXNlNjRfZW5jb2RlIjtpOjYzO3M6NjoibTBydGl4IjtpOjY0O3M6NToibTBoemUiO2k6NjU7czoxMDoiTWF0YW11IE1hdCI7aTo2NjtzOjE2OiJNb3JvY2NhbiBTcGFtZXJzIjtpOjY3O3M6MTY6IlwkTXlTaGVsbFZlcnNpb24iO2k6Njg7czo5OiJNeVNRTCBSU1QiO2k6Njk7czoxOToiTXlTUUwgV2ViIEludGVyZmFjZSI7aTo3MDtzOjI3OiJNeVNRTCBXZWIgSW50ZXJmYWNlIFZlcnNpb24iO2k6NzE7czoxNDoiTXlTUUwgV2Vic2hlbGwiO2k6NzI7czo4OiJOM3RzaGVsbCI7aTo3MztzOjE2OiJIYWNrZWQgYnkgU2lsdmVyIjtpOjc0O3M6NzoiTmVvSGFjayI7aTo3NTtzOjIxOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAiO2k6NzY7czoyMDoiTklYIFJFTU9URSBXRUItU0hFTEwiO2k6Nzc7czoyNjoiTyBCaVIgS1JBTCBUQUtMaVQgRURpbEVNRVoiO2k6Nzg7czoxODoiUEhBTlRBU01BLSBOZVcgQ21EIjtpOjc5O3M6MjE6IlBJUkFURVMgQ1JFVyBXQVMgSEVSRSI7aTo4MDtzOjIxOiJhIHNpbXBsZSBwaHAgYmFja2Rvb3IiO2k6ODE7czoyMDoiTE9URlJFRSBQSFAgQmFja2Rvb3IiO2k6ODI7czozMToiTmV3cyBSZW1vdGUgUEhQIFNoZWxsIEluamVjdGlvbiI7aTo4MztzOjk6IlBIUEphY2thbCI7aTo4NDtzOjIwOiJQSFAgSFZBIFNoZWxsIFNjcmlwdCI7aTo4NTtzOjEzOiJwaHBSZW1vdGVWaWV3IjtpOjg2O3M6MzU6IlBIUCBTaGVsbCBpcyBhbmludGVyYWN0aXZlIFBIUC1wYWdlIjtpOjg3O3M6NjoiUEhWYXl2IjtpOjg4O3M6Mjc6IlBQUyAxXC4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTo4OTtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjkwO3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6OTE7czo1OiJyMG5pbiI7aTo5MjtzOjY6IlI1N1NxbCI7aTo5MztzOjE1OiJyNTdzaGVsbFxcXC5waHAiO2k6OTQ7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjk1O3M6MjA6InJlYWxhdXRoPVN2QkQ4NWRJTnUzIjtpOjk2O3M6MTY6IlJ1MjRQb3N0V2ViU2hlbGwiO2k6OTc7czoyMToiS0Fkb3QgVW5pdmVyc2FsIFNoZWxsIjtpOjk4O3M6OToiQ3J6eV9LaW5nIjtpOjk5O3M6MjA6IlNhZmVfTW9kZSBCeXBhc3MgUEhQIjtpOjEwMDtzOjE3OiJTYXJhc2FPbiBTZXJ2aWNlcyI7aToxMDE7czoyNToiU2ltcGxlIFBIUCBiYWNrZG9vciBieSBESyI7aToxMDI7czoxOToiRy1TZWN1cml0eSBXZWJzaGVsbCI7aToxMDM7czoyNToiU2ltb3JnaCBTZWN1cml0eSBNYWdhemluZSI7aToxMDQ7czoyMDoiU2hlbGwgYnkgTWF3YXJfSGl0YW0iO2k6MTA1O3M6MTM6IlNTSSB3ZWItc2hlbGwiO2k6MTA2O3M6MTE6IlN0b3JtN1NoZWxsIjtpOjEwNztzOjk6IlRoZV9CZUtpUiI7aToxMDg7czo5OiJXM0QgU2hlbGwiO2k6MTA5O3M6MTM6Inc0Y2sxbmcgc2hlbGwiO2k6MTEwO3M6MTE6IldlYkNvbnRyb2xzIjtpOjExMTtzOjI4OiJkZXZlbG9wZWQgYnkgRGlnaXRhbCBPdXRjYXN0IjtpOjExMjtzOjMyOiJXYXRjaCBZb3VyIHN5c3RlbSBTaGFueSB3YXMgaGVyZSI7aToxMTM7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjExNDtzOjEzOiJXU08yIFdlYnNoZWxsIjtpOjExNTtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MTE2O3M6Mjc6IlNtYWxsIFBIUCBXZWIgU2hlbGwgYnkgWmFDbyI7aToxMTc7czoxMToiTXJsb29sXC5leGUiO2k6MTE4O3M6NjoiU0VvRE9SIjtpOjExOTtzOjEwOiJNclwuSGlUbWFuIjtpOjEyMDtzOjU6InJhaHVpIjtpOjEyMTtzOjU6ImQzYn5YIjtpOjEyMjtzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjEyMztzOjEwOiJCWSBNTU5CT0JaIjtpOjEyNDtzOjI2OiJPTEI6UFJPRFVDVDpPTkxJTkVfQkFOS0lORyI7aToxMjU7czoxMToiQzBkZXJ6XC5jb20iO2k6MTI2O3M6NzoiTXJIYXplbSI7aToxMjc7czo5OiJ2MGxkM20wcnQiO2k6MTI4O3M6NjoiSyFMTDNyIjtpOjEyOTtzOjExOiJEclwuYWJvbGFsaCI7aToxMzA7czozMToiXCRyYW5kX3dyaXRhYmxlX2ZvbGRlcl9mdWxscGF0aCI7aToxMzE7czo5NDoiPHRleHRhcmVhIG5hbWU9XFwicGhwZXZcXCIgcm93cz1cXCI1XFwiIGNvbHM9XFwiMTUwXFwiPiJcLlwkX1BPU1RcWydwaHBldidcXVwuIjwvdGV4dGFyZWE+PGJyPiI7aToxMzI7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToxMzM7czo5OiJCeSBQc3ljaDAiO2k6MTM0O3M6MTg6IlwkYzk5c2hfdXBkYXRlZnVybCI7aToxMzU7czoxNDoidGVtcF9yNTdfdGFibGUiO2k6MTM2O3M6MTc6ImFkbWluc3B5Z3J1cFwub3JnIjtpOjEzNztzOjc6ImNhc3VzMTUiO2k6MTM4O3M6MTQ6IldTQ1JJUFRcLlNIRUxMIjtpOjEzOTtzOjUxOiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj1cI2RjZGNkYz5cW1wkY21kXF0iO2k6MTQwO3M6MTI6ImN0c2hlbGxcLnBocCI7aToxNDE7czoxNToiRFhfSGVhZGVyX2RyYXduIjtpOjE0MjtzOjEwMjoiY3JsZlwuJ3VubGlua1woXCRuYW1lXCk7J1wuXCRjcmxmXC4ncmVuYW1lXCgifiJcLlwkbmFtZSxcJG5hbWVcKTsnXC5cJGNybGZcLid1bmxpbmtcKCJncnBfcmVwYWlyXC5waHAiIjtpOjE0MztzOjEwNzoiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrXCtqWURVOTJDOTRqZHREaWZcK3hPWWpHNkNMaHgzMVVvOXg5L2VBV2dzQks2MGtLMm1Md3F6cWQiO2k6MTQ0O3M6MTM0OiJtcHR5XChcJF9QT1NUXFsndXInXF1cKVwpIFwkbW9kZSBcfD0wNDAwO2lmXCghZW1wdHlcKFwkX1BPU1RcWyd1dydcXVwpXCkgXCRtb2RlIFx8PTAyMDA7aWZcKCFlbXB0eVwoXCRfUE9TVFxbJ3V4J1xdXClcKSBcJG1vZGUgXHw9MDEwMCI7aToxNDU7czozOToia2xhc3ZheXZcLmFzcFw/eWVuaWRvc3lhPTwlPWFrdGlma2xhcyU+IjtpOjE0NjtzOjEzNToibnRcKVwoZGlza190b3RhbF9zcGFjZVwoZ2V0Y3dkXChcKVwpL1woMTAyNFwqMTAyNFwpXClcLiJNYiBGcmVlIHNwYWNlICJcLlwoaW50XClcKGRpc2tfZnJlZV9zcGFjZVwoZ2V0Y3dkXChcKVwpL1woMTAyNFwqMTAyNFwpXClcLiJNYiA8IjtpOjE0NztzOjg0OiJhIGhyZWY9IjxcP2VjaG8gIlwkZmlzdGlrXC5waHBcP2RpemluPVwkZGl6aW4vXC5cLi8iXD8+IiBzdHlsZT0idGV4dC1kZWNvcmF0aW9uOiBub24iO2k6MTQ4O3M6NDE6IlJvb3RTaGVsbCEnXCk7c2VsZlwubG9jYXRpb25cLmhyZWY9J2h0dHA6IjtpOjE0OTtzOjk3OiI8JT1SZXF1ZXN0XC5TZXJ2ZXJWYXJpYWJsZXNcKCJzY3JpcHRfbmFtZSJcKSU+XD9Gb2xkZXJQYXRoPTwlPVNlcnZlclwuVVJMUGF0aEVuY29kZVwoRm9sZGVyXC5Ecml2IjtpOjE1MDtzOjIwNjoicHJpbnRcKFwoaXNfcmVhZGFibGVcKFwkZlwpICYmIGlzX3dyaXRlYWJsZVwoXCRmXClcKVw/Ijx0cj48dGQ+Ilwud1woMVwpXC5iXCgiUiJcLndcKDFcKVwuZm9udFwoJ3JlZCcsJ1JXJywzXClcKVwud1woMVwpOlwoXChcKGlzX3JlYWRhYmxlXChcJGZcKVwpXD8iPHRyPjx0ZD4iXC53XCgxXClcLmJcKCJSIlwpXC53XCg0XCk6IiJcKVwuXChcKGlzX3dyaXRhYmwiO2k6MTUxO3M6MTg0OiJcKCciJywnJnF1b3Q7JyxcJGZuXClcKVwuJyI7ZG9jdW1lbnRcLmxpc3RcLnN1Ym1pdFwoXCk7XFwnPidcLmh0bWxzcGVjaWFsY2hhcnNcKHN0cmxlblwoXCRmblwpPmZvcm1hdFw/c3Vic3RyXChcJGZuLDAsZm9ybWF0LTNcKVwuOlwkZm5cKVwuJzwvYT4nXC5zdHJfcmVwZWF0XCgnICcsZm9ybWF0LXN0cmxlblwoXCRmblwpIjtpOjE1MjtzOjExOiJ6ZWhpcmhhY2tlciI7aToxNTM7czo0MzoiSiFWclwqJlJIUnd+Skx3XC5HXHx4bGhuTEp+XD8xXC5id09ieGJQXHwhViI7aToxNTQ7czo0NToiV1NPc2V0Y29va2llXChtZDVcKFwkX1NFUlZFUlxbJ0hUVFBfSE9TVCdcXVwpIjtpOjE1NTtzOjE1NjoiPC90ZD48dGQgaWQ9ZmE+XFsgPGEgdGl0bGU9XFwiSG9tZTogJyJcLmh0bWxzcGVjaWFsY2hhcnNcKHN0cl9yZXBsYWNlXCgiXFwiLFwkc2VwLGdldGN3ZFwoXClcKVwpXC4iJ1wuXFwiIGlkPWZhIGhyZWY9XFwiamF2YXNjcmlwdDpWaWV3RGlyXCgnIlwucmF3dXJsZW5jb2RlIjtpOjE1NjtzOjE3OiJDb250ZW50LVR5cGU6IFwkXyI7aToxNTc7czo5NDoiPG5vYnI+PGI+XCRjZGlyXCRjZmlsZTwvYj5cKCJcLlwkZmlsZVxbInNpemVfc3RyIlxdXC4iXCk8L25vYnI+PC90ZD48L3RyPjxmb3JtIG5hbWU9Y3Vycl9maWxlPiI7aToxNTg7czo1Mzoid3NvRXhcKCd0YXIgY2Z6diAnXC5lc2NhcGVzaGVsbGFyZ1woXCRfUE9TVFxbJ3AyJ1xdXCkiO2k6MTU5O3M6MTQyOiI1amIyMGlLVzl5SUhOMGNtbHpkSElvSkhKbFptVnlaWElzSW1Gd2IzSjBJaWtnYjNJZ2MzUnlhWE4wY2lna2NtVm1aWEpsY2l3aWJtbG5iV0VpS1NCdmNpQnpkSEpwYzNSeUtDUnlaV1psY21WeUxDSjNaV0poYkhSaElpa2diM0lnYzNSeWFYTjBjaWdrIjtpOjE2MDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjE2MTtzOjg2OiJpZlwoZXJlZ1woJ1xeXFtcWzpibGFuazpcXVxdXCpjZFxbXFs6Ymxhbms6XF1cXVwrXChcW1xeO1xdXCtcKVwkJyxcJGNvbW1hbmQsXCRyZWdzXClcKSI7aToxNjI7czo1OToicm91bmRcKDBcKzk4MzBcLjRcKzk4MzBcLjRcKzk4MzBcLjRcKzk4MzBcLjRcKzk4MzBcLjRcKVwpPT0iO2k6MTYzO3M6MTM6IlBIUFNIRUxMXC5QSFAiO2k6MTY0O3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjE2NTtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjE2NjtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjE2NztzOjIxOiJGYVRhTGlzVGlDel9GeCBGeDI5U2giO2k6MTY4O3M6NDc6Ildvcmtlcl9HZXRSZXBseUNvZGVcKFwkb3BEYXRhXFsncmVjdkJ1ZmZlcidcXVwpIjtpOjE2OTtzOjQ1OiJcJGZpbGVwYXRoPXJlYWxwYXRoXChcJF9QT1NUXFsnZmlsZXBhdGgnXF1cKTsiO2k6MTcwO3M6MTAxOiJcJHJlZGlyZWN0VVJMPSdodHRwOi8vJ1wuXCRyU2l0ZVwuXCRfU0VSVkVSXFsnUkVRVUVTVF9VUkknXF07aWZcKGlzc2V0XChcJF9TRVJWRVJcWydIVFRQX1JFRkVSRVInXF1cKSI7aToxNzE7czoxOToicmVuYW1lXCgid3NvXC5waHAiLCI7aToxNzI7czo1ODoiXCRNZXNzYWdlU3ViamVjdD1iYXNlNjRfZGVjb2RlXChcJF9QT1NUXFsibXNnc3ViamVjdCJcXVwpOyI7aToxNzM7czo1NzoiY29weVwoXCRfRklMRVNcW3hcXVxbdG1wX25hbWVcXSxcJF9GSUxFU1xbeFxdXFtuYW1lXF1cKVwpIjtpOjE3NDtzOjU4OiJTRUxFQ1QgMSBGUk9NIG15c3FsXC51c2VyIFdIRVJFIGNvbmNhdFwoYHVzZXJgLCcnLGBob3N0YFwpIjtpOjE3NTtzOjI0OiIhXCRfQ09PS0lFXFtcJHNlc3NkdF9rXF0iO2k6MTc2O3M6NjA6IlwkYT1cKHN1YnN0clwodXJsZW5jb2RlXChwcmludF9yXChhcnJheVwoXCksMVwpXCksNSwxXClcLmNcKSI7aToxNzc7czo1NzoieGggLXMgIi91c3IvbG9jYWwvYXBhY2hlL3NiaW4vaHR0cGQgLURTU0wiXC4vaHR0cGQgLW0gXCQxIjtpOjE3ODtzOjE5OiJwd2QgPiBHZW5lcmFzaVwuZGlyIjtpOjE3OTtzOjEyOiJCUlVURUZPUkNJTkciO2k6MTgwO3M6MzE6IkNhdXRhbSBmaXNpZXJlbGUgZGUgY29uZmlndXJhcmUiO2k6MTgxO3M6Mzg6Ilwka2E9JzxcPy8vQlJFJztcJGtha2E9XCRrYVwuJ0FDSy8vXD8+IjtpOjE4MjtzOjEwMzoiXCRzdWJqPXVybGRlY29kZVwoXCRfR0VUXFsnc3UnXF1cKTtcJGJvZHk9dXJsZGVjb2RlXChcJF9HRVRcWydibydcXVwpO1wkc2RzPXVybGRlY29kZVwoXCRfR0VUXFsnc2QnXF1cKSI7aToxODM7czo0NjoiXCRfX19fPWd6aW5mbGF0ZVwoXCRfX19fXClcKXtpZlwoaXNzZXRcKFwkX1BPUyI7aToxODQ7czozOToicGFzc3RocnVcKGdldGVudlwoIkhUVFBfQUNDRVBUX0xBTkdVQUdFIjtpOjE4NTtzOjg6IkFzbW9kZXVzIjtpOjE4NjtzOjUzOiJmb3JcKDtcJHBhZGRyPWFjY2VwdFwoQ0xJRU5ULFNFUlZFUlwpO2Nsb3NlIENMSUVOVFwpeyI7aToxODc7czo2NjoiXCRpemlubGVyMj1zdWJzdHJcKGJhc2VfY29udmVydFwoZmlsZXBlcm1zXChcJGZuYW1lXCksMTAsOFwpLC00XCk7IjtpOjE4ODtzOjQ3OiJcJGJhY2tkb29yLT5jY29weVwoXCRjZmljaGllcixcJGNkZXN0aW5hdGlvblwpOyI7aToxODk7czoyNzoie1wke3Bhc3N0aHJ1XChcJGNtZFwpfX08YnI+IjtpOjE5MDtzOjM3OiJcJGFcW2hpdHNcXSdcKTtcXHJcXG5cI2VuZHF1ZXJ5XFxyXFxuIjtpOjE5MTtzOjI3OiJuY2Z0cHB1dCAtdSBcJGZ0cF91c2VyX25hbWUiO2k6MTkyO3M6NDE6ImV4ZWNsXCgiL2Jpbi9zaCIsInNoIiwiLWkiLFwoY2hhclwqXCkwXCk7IjtpOjE5MztzOjMyOiI8SFRNTD48SEVBRD48VElUTEU+Y2dpLXNoZWxsXC5weSI7aToxOTQ7czozODoic3lzdGVtXCgidW5zZXQgSElTVEZJTEU7dW5zZXQgU0FWRUhJU1QiO2k6MTk1O3M6MjU6IlwkbG9naW49cG9zaXhfZ2V0dWlkXChcKTsiO2k6MTk2O3M6Nzg6IlwoZXJlZ1woJ1xeXFtcWzpibGFuazpcXVxdXCpjZFxbXFs6Ymxhbms6XF1cXVwqXCQnLFwkX1JFUVVFU1RcWydjb21tYW5kJ1xdXClcKSI7aToxOTc7czoyOToiIVwkX1JFUVVFU1RcWyJjOTlzaF9zdXJsIlxdXCkiO2k6MTk4O3M6NTI6IlBuVmxrV002MyFcIyZkS3h+bk1EV01+RH8vRXNufnh/NkRcIyZQfn4sXD9uWSxXUHtQb2oiO2k6MTk5O3M6NDA6InNoZWxsX2V4ZWNcKFwkX1BPU1RcWydjbWQnXF1cLiIgMj4mMSJcKTsiO2k6MjAwO3M6NDE6ImlmXCghXCR3aG9hbWlcKVwkd2hvYW1pPWV4ZWNcKCJ3aG9hbWkiXCk7IjtpOjIwMTtzOjY1OiJQeVN5c3RlbVN0YXRlXC5pbml0aWFsaXplXChTeXN0ZW1cLmdldFByb3BlcnRpZXNcKFwpLG51bGwsYXJndlwpOyI7aToyMDI7czo0MDoiPCU9ZW52XC5xdWVyeUhhc2h0YWJsZVwoInVzZXJcLm5hbWUiXCklPiI7aToyMDM7czo5MDoiaWZcKGVtcHR5XChcJF9QT1NUXFsnd3NlcidcXVwpXCl7XCR3c2VyPSJ3aG9pc1wucmlwZVwubmV0Ijt9ZWxzZSBcJHdzZXI9XCRfUE9TVFxbJ3dzZXInXF07IjtpOjIwNDtzOjEwNToiaWZcKG1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcWydmaWxhJ1xdXFsndG1wX25hbWUnXF0sXCRjdXJkaXJcLiIvIlwuXCRfRklMRVNcWydmaWxhJ1xdXFsnbmFtZSdcXVwpXCl7IjtpOjIwNTtzOjI1OiJzaGVsbF9leGVjXCgndW5hbWUgLWEnXCk7IjtpOjIwNjtzOjUwOiJpZlwoIWRlZmluZWRcJHBhcmFte2NtZH1cKXtcJHBhcmFte2NtZH09ImxzIC1sYSJ9OyI7aToyMDc7czo2ODoiaWZcKGdldF9tYWdpY19xdW90ZXNfZ3BjXChcKVwpXCRzaGVsbE91dD1zdHJpcHNsYXNoZXNcKFwkc2hlbGxPdXRcKTsiO2k6MjA4O3M6ODg6IjxhIGhyZWY9J1wkUEhQX1NFTEZcP2FjdGlvbj12aWV3U2NoZW1hJmRibmFtZT1cJGRibmFtZSZ0YWJsZW5hbWU9XCR0YWJsZW5hbWUnPlNjaGVtYTwvYT4iO2k6MjA5O3M6NzA6InBhc3N0aHJ1XChcJGJpbmRpclwuIm15c3FsZHVtcCAtLXVzZXI9XCRVU0VSTkFNRSAtLXBhc3N3b3JkPVwkUEFTU1dPUkQiO2k6MjEwO3M6Njk6Im15c3FsX3F1ZXJ5XCgiQ1JFQVRFIFRBQkxFIGB4cGxvaXRgXChgeHBsb2l0YCBMT05HQkxPQiBOT1QgTlVMTFwpIlwpOyI7aToyMTE7czo4OToiXCRyYTQ0PXJhbmRcKDEsOTk5OTlcKTtcJHNqOTg9InNoLVwkcmE0NCI7XCRtbD0iXCRzZDk4IjtcJGE1PVwkX1NFUlZFUlxbJ0hUVFBfUkVGRVJFUidcXTsiO2k6MjEyO3M6NjI6IlwkX0ZJTEVTXFsncHJvYmUnXF1cWydzaXplJ1xdLFwkX0ZJTEVTXFsncHJvYmUnXF1cWyd0eXBlJ1xdXCk7IjtpOjIxMztzOjcyOiJzeXN0ZW1cKCJcJGNtZCAxPiAvdG1wL2NtZHRlbXAgMj4mMTtjYXQgL3RtcC9jbWR0ZW1wO3JtIC90bXAvY21kdGVtcCJcKTsiO2k6MjE0O3M6OTU6In1lbHNpZlwoXCRzZXJ2YXJnPX4gL1xeXFw6XChcLlwrXD9cKVxcIVwoXC5cK1w/XClcXFwoXC5cK1w/XCkgUFJJVk1TR1woXC5cK1w/XCkgXFw6XChcLlwrXCkvXCl7IjtpOjIxNTtzOjc1OiJzZW5kXChTT0NLNSxcJG1zZywwLHNvY2thZGRyX2luXChcJHBvcnRhLFwkaWFkZHJcKVwpIGFuZCBcJHBhY290ZXN7b31cK1wrOzsiO2k6MjE2O3M6MjE6IlwkZmVcKCJcJGNtZCAyPiYxIlwpOyI7aToyMTc7czo3NDoid2hpbGVcKFwkcm93PW15c3FsX2ZldGNoX2FycmF5XChcJHJlc3VsdCxNWVNRTF9BU1NPQ1wpXCkgcHJpbnRfclwoXCRyb3dcKTsiO2k6MjE4O3M6NTk6ImVsc2VpZlwoaXNfd3JpdGFibGVcKFwkRk5cKSAmJiBpc19maWxlXChcJEZOXClcKSBcJHRtcE91dE1GIjtpOjIxOTtzOjgyOiJjb25uZWN0XChTT0NLRVQsc29ja2FkZHJfaW5cKFwkQVJHVlxbMVxdLGluZXRfYXRvblwoXCRBUkdWXFswXF1cKVwpXCkgb3IgZGllIHByaW50IjtpOjIyMDtzOjEwNzoiaWZcKG1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcWyJmaWMiXF1cWyJ0bXBfbmFtZSJcXSxnb29kX2xpbmtcKCJcLi8iXC5cJF9GSUxFU1xbImZpYyJcXVxbIm5hbWUiXF1cKVwpXCkiO2k6MjIxO3M6ODk6IlVOSU9OIFNFTEVDVCAnMCcsJzxcPyBzeXN0ZW1cKFxcXCRfR0VUXFtjcGNcXVwpO2V4aXQ7XD8+JywwLDAsMCwwIElOVE8gT1VURklMRSAnXCRvdXRmaWxlIjtpOjIyMjtzOjczOiJpZlwoIWlzX2xpbmtcKFwkZmlsZVwpICYmXChcJHI9cmVhbHBhdGhcKFwkZmlsZVwpXCkgIT1GQUxTRVwpIFwkZmlsZT1cJHI7IjtpOjIyMztzOjMwOiJlY2hvICJGSUxFIFVQTE9BREVEIFRPIFwkZGV6IjsiO2k6MjI0O3M6MzA6IlwkZnVuY3Rpb25cKFwkX1BPU1RcWydjbWQnXF1cKSI7aToyMjU7czo0MDoiXCRmaWxlbmFtZT1cJGJhY2t1cHN0cmluZ1wuIlwkZmlsZW5hbWUiOyI7aToyMjY7czo1NDoiaWZcKCcnPT1cKFwkZGY9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpXClcKXtlY2hvIjtpOjIyNztzOjQ3OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3RcLlNlcnZlclZhcmlhYmxlcyAlPiI7aToyMjg7czozODoiaWZcKFwkZnVuY2FyZz1+IC9cXnBvcnRzY2FuXChcLlwqXCkvXCkiO2k6MjI5O3M6NjA6IlwkdXBsb2FkZmlsZT1cJHJwYXRoXC4iLyJcLlwkX0ZJTEVTXFsndXNlcmZpbGUnXF1cWyduYW1lJ1xdOyI7aToyMzA7czozMDoiXCRjbWQ9XChcJF9SRVFVRVNUXFsnY21kJ1xdXCk7IjtpOjIzMTtzOjQzOiJpZlwoXCRjbWQgIT0iIlwpIHByaW50IFNoZWxsX0V4ZWNcKFwkY21kXCk7IjtpOjIzMjtzOjMzOiJpZlwoaXNfZmlsZVwoIi90bXAvXCRla2luY2kiXClcKXsiO2k6MjMzO3M6Njk6Il9fYWxsX189XFsiU01UUFNlcnZlciIsIkRlYnVnZ2luZ1NlcnZlciIsIlB1cmVQcm94eSIsIk1haWxtYW5Qcm94eSJcXSI7aToyMzQ7czo2MDoiZ2xvYmFsIFwkbXlzcWxIYW5kbGUsXCRkYm5hbWUsXCR0YWJsZW5hbWUsXCRvbGRfbmFtZSxcJG5hbWUsIjtpOjIzNTtzOjI4OiIyPiYxIDE+JjIiIDogIiAxPiYxIDI+JjEiXCk7IjtpOjIzNjtzOjU3OiJtYXB7cmVhZF9zaGVsbFwoXCRfXCl9XChcJHNlbF9zaGVsbC0+Y2FuX3JlYWRcKDBcLjAxXClcKTsiO2k6MjM3O3M6MjQ6ImZ3cml0ZVwoXCRmcCwiXCR5YXppIlwpOyI7aToyMzg7czo1MToiU2VuZCB0aGlzIGZpbGU6IDxJTlBVVCBOQU1FPSJ1c2VyZmlsZSIgVFlQRT0iZmlsZSI+IjtpOjIzOTtzOjQ0OiJcJGRiX2Q9bXlzcWxfc2VsZWN0X2RiXChcJGRhdGFiYXNlLFwkY29uMVwpOyI7aToyNDA7czo2MzoiZm9yXChcJHZhbHVlXCl7cy8mLyZhbXA7L2c7cy88LyZsdDsvZztzLz4vJmd0Oy9nO3MvIi8mcXVvdDsvZzt9IjtpOjI0MTtzOjg5OiJjb3B5XChcJF9GSUxFU1xbJ3Vwa2snXF1cWyd0bXBfbmFtZSdcXSwia2svIlwuYmFzZW5hbWVcKFwkX0ZJTEVTXFsndXBraydcXVxbJ25hbWUnXF1cKVwpOyI7aToyNDI7czo5MzoiZnVuY3Rpb24gZ29vZ2xlX2JvdFwoXCl7XCRzVXNlckFnZW50PXN0cnRvbG93ZXJcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXVwpO2lmXCghXChzdHJwIjtpOjI0MztzOjczOiJjcmVhdGVfZnVuY3Rpb25cKCImXCRmdW5jdGlvbiIsIlwkZnVuY3Rpb249Y2hyXChvcmRcKFwkZnVuY3Rpb25cKS0zXCk7IlwpIjtpOjI0NDtzOjUwOiJsb25nIGludDp0XCgwLDNcKT1yXCgwLDNcKTstMjE0NzQ4MzY0ODsyMTQ3NDgzNjQ3OyI7aToyNDU7czo1NToiXD91cmw9J1wuXCRfU0VSVkVSXFsnSFRUUF9IT1NUJ1xdXClcLnVubGlua1woUk9PVF9ESVJcLiI7aToyNDY7czozOToiY2F0IFwke2Jsa2xvZ1xbMlxdfVx8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjI0NztzOjk3OiJwYXRoMT1cKCdhZG1pbi8nLCdhZG1pbmlzdHJhdG9yLycsJ21vZGVyYXRvci8nLCd3ZWJhZG1pbi8nLCdhZG1pbmFyZWEvJywnYmItYWRtaW4vJywnYWRtaW5Mb2dpbi8nIjtpOjI0ODtzOjg4OiIiYWRtaW4xXC5waHAiLCJhZG1pbjFcLmh0bWwiLCJhZG1pbjJcLnBocCIsImFkbWluMlwuaHRtbCIsInlvbmV0aW1cLnBocCIsInlvbmV0aW1cLmh0bWwiIjtpOjI0OTtzOjcwOiJQT1NUe1wkcGF0aH17XCRjb25uZWN0b3J9XD9Db21tYW5kPUZpbGVVcGxvYWQmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9IjtpOjI1MDtzOjMzOiJhc3NlcnRcKFwkX1JFUVVFU1RcWydQSFBTRVNTSUQnXF0iO2k6MjUxO3M6NjQ6IlwkcHJvZD0ic3lzdGVtIjtcJGlkPVwkcHJvZFwoXCRfUkVRVUVTVFxbJ3Byb2R1Y3QnXF1cKTtcJHsnaWQnfTsiO2k6MjUyO3M6MTc6InBocCAiXC5cJHdzb19wYXRoIjtpOjI1MztzOjg3OiJcJEZjaG1vZCxcJEZkYXRhLFwkT3B0aW9ucyxcJEFjdGlvbixcJGhkZGFsbCxcJGhkZGZyZWUsXCRoZGRwcm9jLFwkdW5hbWUsXCRpZGRcKTpzaGFyZWQiO2k6MjU0O3M6NTY6InNlcnZlclwuPC9wPlxcclxcbjwvYm9keT48L2h0bWw+IjtleGl0O31pZlwocHJlZ19tYXRjaFwoIjtpOjI1NTtzOjEwMjoiXCRmaWxlPVwkX0ZJTEVTXFsiZmlsZW5hbWUiXF1cWyJuYW1lIlxdO2VjaG8gIjxhIGhyZWY9XFwiXCRmaWxlXFwiPlwkZmlsZTwvYT4iO31lbHNle2VjaG9cKCJlbXB0eSJcKTt9IjtpOjI1NjtzOjYzOiJGU19jaGtfZnVuY19saWJjPVwoXCRcKHJlYWRlbGYgLXMgXCRGU19saWJjIFx8IGdyZXAgX2NoayBcfCBhd2siO2k6MjU3O3M6NDE6ImZpbmQgLyAtbmFtZVwuc3NoID4gXCRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjI1ODtzOjQzOiJyZVwuZmluZGFsbFwoZGlydFwrJ1woXC5cKlwpJyxwcm9nbm1cKVxbMFxdIjtpOjI1OTtzOjYzOiJvdXRzdHIgXCs9c3RyaW5nXC5Gb3JtYXRcKCI8YSBocmVmPSdcP2ZkaXI9ezB9Jz57MX0vPC9hPiZuYnNwOyIiO2k6MjYwO3M6ODk6IjwlPVJlcXVlc3RcLlNlcnZlcnZhcmlhYmxlc1woIlNDUklQVF9OQU1FIlwpJT5cP3R4dHBhdGg9PCU9UmVxdWVzdFwuUXVlcnlTdHJpbmdcKCJ0eHRwYXRoIjtpOjI2MTtzOjgxOiJSZXNwb25zZVwuV3JpdGVcKFNlcnZlclwuSHRtbEVuY29kZVwodGhpc1wuRXhlY3V0ZUNvbW1hbmRcKHR4dENvbW1hbmRcLlRleHRcKVwpXCkiO2k6MjYyO3M6MTE5OiJuZXcgRmlsZVN0cmVhbVwoUGF0aFwuQ29tYmluZVwoZmlsZUluZm9cLkRpcmVjdG9yeU5hbWUsUGF0aFwuR2V0RmlsZU5hbWVcKGh0dHBQb3N0ZWRGaWxlXC5GaWxlTmFtZVwpXCksRmlsZU1vZGVcLkNyZWF0ZSI7aToyNjM7czo5OToiUmVzcG9uc2VcLldyaXRlXCgiPGJyPlwoXCkgPGEgaHJlZj1cP3R5cGU9MSZmaWxlPSIgJiBzZXJ2ZXJcLlVSTGVuY29kZVwoaXRlbVwucGF0aFwpICYgIlxcPiIgJiBpdGVtIjtpOjI2NDtzOjExNToic3FsQ29tbWFuZFwuUGFyYW1ldGVyc1wuQWRkXChcKFwoVGFibGVDZWxsXClkYXRhR3JpZEl0ZW1cLkNvbnRyb2xzXFswXF1cKVwuVGV4dCxTcWxEYlR5cGVcLkRlY2ltYWxcKVwuVmFsdWU9ZGVjaW1hbCI7aToyNjU7czo2NzoiPCU9IlxcIiAmIG9TY3JpcHROZXRcLkNvbXB1dGVyTmFtZSAmICJcXCIgJiBvU2NyaXB0TmV0XC5Vc2VyTmFtZSAlPiI7aToyNjY7czo1MjoiY3VybF9zZXRvcHRcKFwkY2gsQ1VSTE9QVF9VUkwsImh0dHA6Ly9cJGhvc3Q6MjA4MiJcKSI7aToyNjc7czo1ODoiSEozSGp1dGNrb1JmcFhmOUExelFPMkF3RFJyUmV5OXVHdlRlZXo3OXFBYW8xYTByZ3Vka1prUjhSYSI7aToyNjg7czozMjoiXCRpbmlcWyd1c2VycydcXT1hcnJheVwoJ3Jvb3QnPT4iO2k6MjY5O3M6MTk6InByb2Nfb3BlblwoJ0lIU3RlYW0iO2k6MjcwO3M6Mjg6IlwkYmFzbGlrPVwkX1BPU1RcWydiYXNsaWsnXF0iO2k6MjcxO3M6MzU6ImZyZWFkXChcJGZwLGZpbGVzaXplXChcJGZpY2hlcm9cKVwpIjtpOjI3MjtzOjQyOiJJL2djWi92WDBBMTBERFJEZzdFemsvZFwrM1wrOHF2cXFTMUswXCtBWFkiO2k6MjczO3M6MTk6IntcJF9QT1NUXFsncm9vdCdcXX0iO2k6Mjc0O3M6MzM6In1lbHNlaWZcKFwkX0dFVFxbJ3BhZ2UnXF09PSdkZG9zJyI7aToyNzU7czoxNDoiVGhlIERhcmsgUmF2ZXIiO2k6Mjc2O3M6NDg6IlwkdmFsdWU9fiBzLyVcKFwuXC5cKS9wYWNrXCgnYycsaGV4XChcJDFcKVwpL2VnOyI7aToyNzc7czoxMzoid3d3XC50MHNcLm9yZyI7aToyNzg7czozNToidW5sZXNzXChvcGVuXChQRkQsXCRnX3VwbG9hZF9kYlwpXCkiO2k6Mjc5O3M6MTI6ImF6ODhwaXgwMHE5OCI7aToyODA7czoxNDoic2ggZ28gXCQxXC5cJHgiO2k6MjgxO3M6Mjk6InN5c3RlbVwoInBocCAtZiB4cGwgXCRob3N0IlwpIjtpOjI4MjtzOjEzOiJleHBsb2l0Y29va2llIjtpOjI4MztzOjIyOiI4MCAtYiBcJDEgLWkgZXRoMCAtcyA4IjtpOjI4NDtzOjI1OiJIVFRQIGZsb29kIGNvbXBsZXRlIGFmdGVyIjtpOjI4NTtzOjE2OiJOSUdHRVJTXC5OSUdHRVJTIjtpOjI4NjtzOjU5OiJpZlwoaXNzZXRcKFwkX0dFVFxbJ2hvc3QnXF1cKSYmaXNzZXRcKFwkX0dFVFxbJ3RpbWUnXF1cKVwpeyI7aToyODc7czo4Mjoic3VicHJvY2Vzc1wuUG9wZW5cKGNtZCxzaGVsbD1UcnVlLHN0ZG91dD1zdWJwcm9jZXNzXC5QSVBFLHN0ZGVycj1zdWJwcm9jZXNzXC5TVERPVSI7aToyODg7czo2OToiZGVmIGRhZW1vblwoc3RkaW49Jy9kZXYvbnVsbCcsc3Rkb3V0PScvZGV2L251bGwnLHN0ZGVycj0nL2Rldi9udWxsJ1wpIjtpOjI4OTtzOjc1OiJwcmludFwoIlxbIVxdIEhvc3Q6ICIgXCsgaG9zdG5hbWUgXCsgIiBtaWdodCBiZSBkb3duIVxcblxbIVxdIFJlc3BvbnNlIENvZGUiO2k6MjkwO3M6NTE6ImNvbm5lY3Rpb25cLnNlbmRcKCJzaGVsbCAiXCtzdHJcKG9zXC5nZXRjd2RcKFwpXClcKyI7aToyOTE7czo1Njoib3NcLnN5c3RlbVwoJ2VjaG8gYWxpYXMgbHM9IlwubHNcLmJhc2giID4+IH4vXC5iYXNocmMnXCkiO2k6MjkyO3M6MzE6InJ1bGVfcmVxPXJhd19pbnB1dFwoIlNvdXJjZUZpcmUiO2k6MjkzO3M6NTg6ImFyZ3BhcnNlXC5Bcmd1bWVudFBhcnNlclwoZGVzY3JpcHRpb249aGVscCxwcm9nPSJzY3R1bm5lbCIiO2k6Mjk0O3M6NTg6InN1YnByb2Nlc3NcLlBvcGVuXCgnJXNnZGIgLXAgJWQgLWJhdGNoICVzJyAlXChnZGJfcHJlZml4LHAiO2k6Mjk1O3M6NjY6IlwkZnJhbWV3b3JrXC5wbHVnaW5zXC5sb2FkXCgiXCN7cnBjdHlwZVwuZG93bmNhc2V9cnBjIixvcHRzXClcLnJ1biI7aToyOTY7czoyNzoiaWYgc2VsZlwuaGFzaF90eXBlPT0ncHdkdW1wIjtpOjI5NztzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aToyOTg7czo0NToiYWRkX2ZpbHRlclwoJ3RoZV9jb250ZW50JywnX2Jsb2dpbmZvJywxMDAwMVwpIjtpOjI5OTtzOjEwOiI8c3RkbGliXC5oIjtpOjMwMDtzOjUxOiJlY2hvIHk7c2xlZXAgMTt9XHx7d2hpbGUgcmVhZDtkbyBlY2hvIHpcJFJFUExZO2RvbmUiO2k6MzAxO3M6MTE6IlZPQlJBIEdBTkdPIjtpOjMwMjtzOjkwOiJpbnQzMlwoXChcKFwkeiA+PiA1ICYgMHgwN2ZmZmZmZlwpIFxeIFwkeSA8PCAyXCkgXCtcKFwoXCR5ID4+IDMgJiAweDFmZmZmZmZmXCkgXF4gXCR6IDw8IDQiO2k6MzAzO3M6ODI6ImNvcHlcKFwkX0ZJTEVTXFtmaWxlTWFzc1xdXFt0bXBfbmFtZVxdLFwkX1BPU1RcW3BhdGhcXVwuXCRfRklMRVNcW2ZpbGVNYXNzXF1cW25hbWUiO2k6MzA0O3M6NDg6ImZpbmRfZGlyc1woXCRncmFuZHBhcmVudF9kaXIsXCRsZXZlbCwxLFwkZGlyc1wpOyI7aTozMDU7czoyOToic2V0Y29va2llXCgiaGl0IiwxLHRpbWVcKFwpXCsiO2k6MzA2O3M6NzoiZS9cKlwuLyI7aTozMDc7czozNzoiSkhacGMybDBZMjkxYm5RZ1BTQWtTRlJVVUY5RFQwOUxTVVZmViI7aTozMDg7czozNToiMGQwYTBkMGE2NzZjNmY2MjYxNmMyMDI0NmQ3OTVmNzM2ZDciO2k6MzA5O3M6MjA6ImZvcGVuXCgnL2V0Yy9wYXNzd2QnIjtpOjMxMDtzOjk3OiJcJHRzdTJcW3JhbmRcKDAsY291bnRcKFwkdHN1MlwpIC0gMVwpXF1cLlwkdHN1MVxbcmFuZFwoMCxjb3VudFwoXCR0c3UxXCkgLSAxXClcXVwuXCR0c3UyXFtyYW5kXCgwIjtpOjMxMTtzOjMzOiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGQgLURTU0wiO2k6MzEyO3M6MjA6InNldCBwcm90ZWN0LXRlbG5ldCAwIjtpOjMxMztzOjI3OiJheXUgcHIxIHByMiBwcjMgcHI0IHByNSBwcjYiO2k6MzE0O3M6MjU6ImJpbmQgZmlsdCAtICIBQUNUSU9OIFwqASIiO2k6MzE1O3M6NTE6InJlZ3N1YiAtYWxsIC0tLFxbc3RyaW5nIHRvbG93ZXIgXCRvd25lclxdICIiIG93bmVycyI7aTozMTY7czozNzoia2lsbCAtQ0hMRCBcXFwkYm90cGlkID4vZGV2L251bGwgMj4mMSI7aTozMTc7czoxMDoiYmluZCBkY2MgLSI7aTozMTg7czoyNToicjRhVGNcLmRQbnRFL2Z6dFNGMWJIM1JIMCI7aTozMTk7czoxNDoicHJpdm1zZyBcJGNoYW4iO2k6MzIwO3M6MjM6ImJpbmQgam9pbiAtIFwqIGdvcF9qb2luIjtpOjMyMTtzOjUwOiJzZXQgZ29vZ2xlXChkYXRhXCkgXFtodHRwOjpkYXRhIFwkZ29vZ2xlXChwYWdlXClcXSI7aTozMjI7czoyNToicHJvYyBodHRwOjpDb25uZWN0e3Rva2VufSI7aTozMjM7czoxNDoicHJpdm1zZyBcJG5pY2siO2k6MzI0O3M6MTI6InB1dGJvdCBcJGJvdCI7aTozMjU7czoxMjoidW5iaW5kIFJBVyAtIjtpOjMyNjtzOjM1OiItLURDQ0RJUiBcW2xpbmRleCBcJFVzZXJcKFwkaVwpIDJcXSI7aTozMjc7czoxMDoiQ3liZXN0ZXI5MCI7aTozMjg7czo1MToiZmlsZV9nZXRfY29udGVudHNcKHRyaW1cKFwkZlxbXCRfR0VUXFsnaWQnXF1cXVwpXCk7IjtpOjMyOTtzOjIzOiJ1bmxpbmtcKFwkd3JpdGFibGVfZGlycyI7aTozMzA7czozMDoiYmFzZTY0X2RlY29kZVwoXCRjb2RlX3NjcmlwdFwpIjtpOjMzMTtzOjIxOiJsdWNpZmZlcmx1Y2lmZmVyXC5vcmciO2k6MzMyO3M6NTQ6IlwkdGhpcy0+Ri0+R2V0Q29udHJvbGxlclwoXCRfU0VSVkVSXFsnUkVRVUVTVF9VUkknXF1cKSI7aTozMzM7czo1MzoiXCR0aW1lX3N0YXJ0ZWRcLlwkc2VjdXJlX3Nlc3Npb25fdXNlclwuc2Vzc2lvbl9pZFwoXCkiO2k6MzM0O3M6ODc6IlwkcGFyYW0geCBcJG5cLnN1YnN0clwoXCRwYXJhbSxsZW5ndGhcKFwkcGFyYW1cKSAtIGxlbmd0aFwoXCRjb2RlXCklbGVuZ3RoXChcJHBhcmFtXClcKSI7aTozMzU7czo0MzoiZndyaXRlXChcJGYsZ2V0X2Rvd25sb2FkXChcJF9HRVRcWyd1cmwnXF1cKSI7aTozMzY7czo3NToiaHR0cDovLydcLlwkX1NFUlZFUlxbJ0hUVFBfSE9TVCdcXVwudXJsZGVjb2RlXChcJF9TRVJWRVJcWydSRVFVRVNUX1VSSSdcXVwpIjtpOjMzNztzOjc2OiJ3cF9wb3N0cyBXSEVSRSBwb3N0X3R5cGU9J3Bvc3QnIEFORCBwb3N0X3N0YXR1cz0ncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjMzODtzOjQzOiJcJHVybD1cJHVybHNcW3JhbmRcKDAsY291bnRcKFwkdXJsc1wpLTFcKVxdIjtpOjMzOTtzOjYxOiJwcmVnX21hdGNoXCgnL1woXD88PVJld3JpdGVSdWxlXClcLlwqXChcPz1cXFxbTFxcLFJcXD0zMDJcXFxdIjtpOjM0MDtzOjUxOiJwcmVnX21hdGNoXCgnIU1JRFBcfFdBUFx8V2luZG93c1wuQ0VcfFBQQ1x8U2VyaWVzNjAiO2k6MzQxO3M6NjA6IlIwbEdPRGxoRXdBUUFMTUFBQUFBQVAvLy81eWNBTTdPWS8vL25QLy96di9PblBmMzkvLy8vd0FBQUFBQSI7aTozNDI7czo4MToic3RyX3JvdDEzXChcJGJhc2VhXFtcKFwkZGltZW5zaW9uXCpcJGRpbWVuc2lvbi0xXCkgLVwoXCRpXCpcJGRpbWVuc2lvblwrXCRqXClcXVwpIjtpOjM0MztzOjkyOiJpZlwoZW1wdHlcKFwkX0dFVFxbJ3ppcCdcXVwpIGFuZCBlbXB0eVwoXCRfR0VUXFsnZG93bmxvYWQnXF1cKSAmIGVtcHR5XChcJF9HRVRcWydpbWcnXF1cKVwpeyI7aTozNDQ7czoxNjoiTWFkZSBieSBEZWxvcmVhbiI7aTozNDU7czo1Mzoib3ZlcmZsb3cteTpzY3JvbGw7XFwiPiJcLlwkbGlua3NcLlwkaHRtbF9tZlxbJ2JvZHknXF0iO2k6MzQ2O3M6NDQ6ImZ1bmN0aW9uIHVybEdldENvbnRlbnRzXChcJHVybCxcJHRpbWVvdXQ9NVwpIjtpOjM0NztzOjY6ImQzbGV0ZSI7aTozNDg7czoxNzoibGV0YWtzZWthcmFuZ1woXCkiO2k6MzQ5O3M6ODoiWUVOSTNFUkkiO2k6MzUwO3M6MjM6IlwkT09PMDAwMDAwPXVybGRlY29kZVwoIjtpOjM1MTtzOjIwOiItSS91c3IvbG9jYWwvYmFuZG1pbiI7aTozNTI7czo0MDoiZndyaXRlXChcJGZwc2V0dixnZXRlbnZcKCJIVFRQX0NPT0tJRSJcKSI7aTozNTM7czozMDoiaXNzZXRcKFwkX1BPU1RcWydleGVjZ2F0ZSdcXVwpIjtpOjM1NDtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6MzU1O3M6MTM6Ij09ImJpbmRzaGVsbCIiO2k6MzU2O3M6ODoiUGFzaGtlbGEiO2k6MzU3O3M6MjU6ImNyZWF0ZUZpbGVzRm9ySW5wdXRPdXRwdXQiO2k6MzU4O3M6NjoiTTRsbDNyIjtpOjM1OTtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTozNjA7czo3OiJPb05fQm95IjtpOjM2MTtzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM2MjtzOjg6ImRhcmttaW56IjtpOjM2MztzOjU6IlplZDB4IjtpOjM2NDtzOjQ0OiJhYmFjaG9cfGFiaXpkaXJlY3RvcnlcfGFib3V0XHxhY29vblx8YWxleGFuYSI7aTozNjU7czo0MToicHBjXHxtaWRwXHx3aW5kb3dzIGNlXHxtdGtcfGoybWVcfHN5bWJpYW4iO2k6MzY2O3M6NzI6ImNoclwoXChcJGhcW1wkZVxbXCRvXF1cXTw8NFwpXCtcKFwkaFxbXCRlXFtcK1wrXCRvXF1cXVwpXCk7fX1ldmFsXChcJGRcKSI7aTozNjc7czoxMjoiXCRzaDNsbENvbG9yIjtpOjM2ODtzOjEwOiJQdW5rZXIyQm90IjtpOjM2OTtzOjIxOiI8XD9waHAgZWNobyAiXCMhIVwjIjsiO2k6MzcwO3M6OTY6IlwkaW09c3Vic3RyXChcJGltLDAsXCRpXClcLnN1YnN0clwoXCRpbSxcJGkyXCsxLFwkaTQtXChcJGkyXCsxXClcKVwuc3Vic3RyXChcJGltLFwkaTRcKzEyLHN0cmxlbiI7aTozNzE7czo2NjoiXChcJGluZGF0YSxcJGI2ND0xXCl7aWZcKFwkYjY0PT0xXCl7XCRjZD1iYXNlNjRfZGVjb2RlXChcJGluZGF0YVwpIjtpOjM3MjtzOjIzOiJcKFwkX1BPU1RcWyJkaXIiXF1cKVwpOyI7aTozNzM7czoxNzoiSGFja2VkIEJ5IEVuRExlU3MiO2k6Mzc0O3M6MTE6ImFuZGV4XHxvb2dsIjtpOjM3NTtzOjExOiJuZHJvaVx8aHRjXyI7aTozNzY7czo2OiIuSXJJc1QiO2k6Mzc3O3M6MjI6IjdQMXRkXCtOV2xpYUkvaFdrWjRWWDkiO2k6Mzc4O3M6MTU6Ik5pbmphVmlydXMgSGVyZSI7aTozNzk7czo0MzoiXCRpbT1zdWJzdHJcKFwkdHgsXCRwXCsyLFwkcDItXChcJHBcKzJcKVwpOyI7aTozODA7czo2OiIzeHAxcjMiO2k6MzgxO3M6MjQ6IlwkbWQ1PW1kNVwoIlwkcmFuZG9tIlwpOyI7aTozODI7czoyOToib1RhdDhEM0RzRTgnJn5oVTA2Q0NINTtcJGdZU3EiO2k6MzgzO3M6MTM6IkdJRjg5QTs8XD9waHAiO2k6Mzg0O3M6MTU6IkNyZWF0ZWQgQnkgRU1NQSI7aTozODU7czo1MDoiUGFzc3dvcmQ6XHMqIlwuXCRfUE9TVFxbWyciXXswLDF9cGFzc3dkWyciXXswLDF9XF0iO2k6Mzg2O3M6MTQ6Ik5ldGRkcmVzcyBNYWlsIjtpOjM4NztzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjM4ODtzOjExOiJCYWJ5X0RyYWtvbiI7aTozODk7czozNDoiZndyaXRlXChmb3BlblwoZGlybmFtZVwoX19GSUxFX19cKSI7aTozOTA7czoxOToiXF1cXVwpXCk7fX1ldmFsXChcJCI7aTozOTE7czo0MDoiZXJlZ19yZXBsYWNlXChbJyJdezAsMX0mZW1haWwmWyciXXswLDF9LCI7aTozOTI7czoyNzoiXCk7XCRpXCtcK1wpXCRyZXRcLj1jaHJcKFwkIjtpOjM5MztzOjgwOiJcJHBhcmFtMm1hc2tcLiJcKVxcPVxbXFxbJyJdXFwiXF1cKFwuXCpcP1wpXChcPz1cW1xcWyciXVxcIlxdXClcW1xcWyciXVxcIlxdL3NpZSI7aTozOTQ7czo5OiIvL3Jhc3RhLy8iO2k6Mzk1O3M6MjA6IjwhLS1DT09LSUUgVVBEQVRFLS0+IjtpOjM5NjtzOjE0OiJwcm9mZXhvclwuaGVsbCI7aTozOTc7czoxMzoiTWFnZWxhbmdDeWJlciI7aTozOTg7czo4OiJaT0JVR1RFTCI7aTozOTk7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjQwMDtzOjEwOiJTX1xdX1xeVVxeIjtpOjQwMTtzOjE2OiJcJF9QT1NUXFtcKGNoclwoIjtpOjQwMjtzOjEyOiJaZXJvRGF5RXhpbGUiO2k6NDAzO3M6MTI6IlN1bHRhbkhhaWthbCI7aTo0MDQ7czoxMToiQ291cGRlZ3JhY2UiO2k6NDA1O3M6ODoiYXJ0aWNrbGUiO2k6NDA2O3M6MTU6ImduaXRyb3Blcl9yb3JyZSI7fQ=="));
$gX_DBShe = unserialize(base64_decode("YTo2Njp7aTowO3M6NzoiZGVmYWNlciI7aToxO3M6MjQ6IllvdSBjYW4gcHV0IGEgbWQ1IHN0cmluZyI7aToyO3M6ODoicGhwc2hlbGwiO2k6MztzOjk6IlJvb3RTaGVsbCI7aTo0O3M6NjI6IjxkaXYgY2xhc3M9ImJsb2NrIGJ0eXBlMSI+PGRpdiBjbGFzcz0iZHRvcCI+PGRpdiBjbGFzcz0iZGJ0bSI+IjtpOjU7czo4OiJjOTlzaGVsbCI7aTo2O3M6ODoicjU3c2hlbGwiO2k6NztzOjc6Ik5URGFkZHkiO2k6ODtzOjg6ImNpaHNoZWxsIjtpOjk7czo3OiJGeGM5OXNoIjtpOjEwO3M6MTI6IldlYiBTaGVsbCBieSI7aToxMTtzOjExOiJkZXZpbHpTaGVsbCI7aToxMjtzOjg6Ik4zdHNoZWxsIjtpOjEzO3M6MTE6IlN0b3JtN1NoZWxsIjtpOjE0O3M6MTE6IkxvY3VzN1NoZWxsIjtpOjE1O3M6MTM6InI1N3NoZWxsXC5waHAiO2k6MTY7czo5OiJhbnRpc2hlbGwiO2k6MTc7czo5OiJyb290c2hlbGwiO2k6MTg7czoxMToibXlzaGVsbGV4ZWMiO2k6MTk7czo4OiJTaGVsbCBPayI7aToyMDtzOjE1OiJleGVjXCgicm0gLXIgLWYiO2k6MjE7czoxODoiTmUgdWRhbG9zIHphZ3J1eml0IjtpOjIyO3M6NTE6IlwkbWVzc2FnZT1lcmVnX3JlcGxhY2VcKCIlNUMlMjIiLCIlMjIiLFwkbWVzc2FnZVwpOyI7aToyMztzOjE5OiJwcmludCAiU3BhbWVkJz48YnI+IjtpOjI0O3M6NDA6InNldGNvb2tpZVwoIm15c3FsX3dlYl9hZG1pbl91c2VybmFtZSJcKTsiO2k6MjU7czo0MToiZWxzZWlmXChmdW5jdGlvbl9leGlzdHNcKCJzaGVsbF9leGVjIlwpXCkiO2k6MjY7czo2NToiaWZcKGlzX2NhbGxhYmxlXCgiZXhlYyJcKSBhbmQgIWluX2FycmF5XCgiZXhlYyIsXCRkaXNhYmxlZnVuY1wpXCkiO2k6Mjc7czozNToiaWZcKFwoXCRwZXJtcyAmIDB4QzAwMFwpPT0weEMwMDBcKXsiO2k6Mjg7czoxMDoiZGlyIC9PRyAvWCI7aToyOTtzOjQxOiJpbmNsdWRlXChcJF9TRVJWRVJcWydIVFRQX1VTRVJfQUdFTlQnXF1cKSI7aTozMDtzOjc6Im1pbHcwcm0iO2k6MzE7czo3OiJicjB3czNyIjtpOjMyO3M6NTM6IidodHRwZFwuY29uZicsJ3Zob3N0c1wuY29uZicsJ2NmZ1wucGhwJywnY29uZmlnXC5waHAnIjtpOjMzO3M6MzQ6Ii9wcm9jL3N5cy9rZXJuZWwveWFtYS9wdHJhY2Vfc2NvcGUiO2k6MzQ7czoyNToiZXZhbFwoZmlsZV9nZXRfY29udGVudHNcKCI7aTozNTtzOjE5OiJpc193cml0YWJsZVwoIi92YXIvIjtpOjM2O3M6MTY6IlwkR0xPQkFMU1xbJ19fX18iO2k6Mzc7czo1ODoiaXNfY2FsbGFibGVcKCdleGVjJ1wpIGFuZCAhaW5fYXJyYXlcKCdleGVjJyxcJGRpc2FibGVmdW5jcyI7aTozODtzOjc6ImswZFwuY2MiO2k6Mzk7czoyOToiZ21haWwtc210cC1pblwubFwuZ29vZ2xlXC5jb20iO2k6NDA7czoxMjoibWlsdzBybVwuY29tIjtpOjQxO3M6Nzoid2VicjAwdCI7aTo0MjtzOjExOiJEZXZpbEhhY2tlciI7aTo0MztzOjc6IkRlZmFjZXIiO2k6NDQ7czoxMzoiXFsgUGhwcm94eSBcXSI7aTo0NTtzOjEwOiJcW2NvZGVyelxdIjtpOjQ2O3M6MzQ6IjwhLS1cI2V4ZWMgY21kPSJcJEhUVFBfQUNDRVBUIiAtLT4iO2k6NDc7czoxODoiXF1cW3JvdW5kXCgwXClcXVwoIjtpOjQ4O3M6MTE6IlNpbUF0dGFja2VyIjtpOjQ5O3M6MTU6IkRhcmtDcmV3RnJpZW5kcyI7aTo1MDtzOjc6ImsybGwzM2QiO2k6NTE7czo3OiJLa0sxMzM3IjtpOjUyO3M6MTU6IkhBQ0tFRCBCWSBTVE9STSI7aTo1MztzOjE0OiJNZXhpY2FuSGFja2VycyI7aTo1NDtzOjE2OiJNclwuU2hpbmNoYW5YMTk2IjtpOjU1O3M6OToiRGVpZGFyYX5YIjtpOjU2O3M6MTA6IkppbnBhbnRvbXoiO2k6NTc7czo5OiIxbjczY3QxMG4iO2k6NTg7czoxNDoiS2luZ1NrcnVwZWxsb3MiO2k6NTk7czoxMDoiSmlucGFudG9teiI7aTo2MDtzOjk6IkNlbmdpekhhbiI7aTo2MTtzOjIyOiJyb290Ong6MDowOnJvb3Q6L3Jvb3Q6IjtpOjYyO3M6OToicjN2M25nNG5zIjtpOjYzO3M6OToiQkxBQ0tVTklYIjtpOjY0O3M6ODoiRmlsZXNNYW4iO2k6NjU7czo4OiJhcnRpY2tsZSI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNjM6e2k6MDtzOjEwMDoiSU86OlNvY2tldDo6SU5FVC0+bmV3XChQcm90b1xzKj0+XHMqInRjcCJccyosXHMqTG9jYWxQb3J0XHMqPT5ccyozNjAwMFxzKixccypMaXN0ZW5ccyo9PlxzKlNPTUFYQ09OTiI7aToxO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjM7czoxMToiYnlccytHcmluYXkiO2k6NDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjU7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjY7czozNToiZGVmYXVsdF9hY3Rpb25ccyo9XHMqXFxbJyJdRmlsZXNNYW4iO2k6NztzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6ODtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6OTtzOjc0OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX0hPU1RbJyJdXHMqXF1ccypcKSI7aToxMDtzOjEwNzoid3NvRXhccypcKFxzKlxcWyciXVxzKnRhclxzKmNmenZccypcXFsnIl1ccypcLlxzKmVzY2FwZXNoZWxsYXJnXHMqXChccypcJF9QT1NUXFtccypcXFsnIl1wMlxcWyciXVxzKlxdXHMqXCkiO2k6MTE7czo0MDoiZXZhbFxzKlwoKlxzKmJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyI7aToxMjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MTM7czo3NDoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXWZpbGVwYXRoWyciXVxzKlxdXHMqXCkiO2k6MTQ7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MTU7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToxNjtzOjg3OiJTRUxFQ1RccysxXHMrRlJPTVxzK215c3FsXC51c2VyXHMrV0hFUkVccytjb25jYXRcKFxzKmB1c2VyYFxzKixccyonQCdccyosXHMqYGhvc3RgXHMqXCkiO2k6MTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTg7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxOTtzOjU1OiJ7XHMqXCRccyp7XHMqcGFzc3RocnVccypcKCpccypcJGNtZFxzKlwpXHMqfVxzKn1ccyo8YnI+IjtpOjIwO3M6ODI6InJ1bmNvbW1hbmRccypcKFxzKlsnIl1zaGVsbGhlbHBbJyJdXHMqLFxzKlsnIl0oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl0iO2k6MjE7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyMjtzOjM3OiJcJGxvZ2luXHMqPVxzKkAqcG9zaXhfZ2V0dWlkXCgqXHMqXCkqIjtpOjIzO3M6NDk6IiFAKlwkX1JFUVVFU1RccypcW1xzKlsnIl1jOTlzaF9zdXJsWyciXVxzKlxdXHMqXCkiO2k6MjQ7czoxMjQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF9QT1NUXHMqXFtccypbJyJdLis/WyciXVxzKlxdXHMqXC5ccyoiXHMqMlxzKj5ccyomMVxzKlsnIl0iO2k6MjU7czo4NjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJddW5hbWVccystYVsnIl1ccypcKSoiO2k6MjY7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6Mjc7czoxNDE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyODtzOjIzOiJcJGZlXCgiXCRjbWRccysyPiYxIlwpOyI7aToyOTtzOjk2OiJcJGZ1bmN0aW9uXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Y21kWyciXXswLDF9XHMqXF1ccypcKSoiO2k6MzA7czo5MzoiXCRjbWRccyo9XHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxzKlwpIjtpOjMxO3M6MjE6ImV2YTFbYS16QS1aMC05X10rP1NpciI7aTozMjtzOjg5OiJAKmFzc2VydFxzKlwoKlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxzKiI7aTozMztzOjI1OiJwaHBccysiXHMqXC5ccypcJHdzb19wYXRoIjtpOjM0O3M6NTA6ImV2YWxccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjM1O3M6NTI6ImFzc2VydFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzY7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aTozNztzOjQ1OiJzeXN0ZW1ccypcKCpccypbJyJdezAsMX13aG9hbWlbJyJdezAsMX1ccypcKSoiO2k6Mzg7czo4ODoiY3VybF9zZXRvcHRccypcKFxzKlwkY2hccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqWyciXXswLDF9aHR0cDovL1wkaG9zdDpcZCtbJyJdezAsMX1ccypcKSI7aTozOTtzOjg4OiJcJGluaVxzKlxbXHMqWyciXXswLDF9dXNlcnNbJyJdezAsMX1ccypcXVxzKj1ccyphcnJheVxzKlwoXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKj0+IjtpOjQwO3M6MzM6InByb2Nfb3BlblxzKlwoXHMqWyciXXswLDF9SUhTdGVhbSI7aTo0MTtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjQyO3M6ODE6IlxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKlxdXHMqfSI7aTo0MztzOjQ2OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdezAsMX0vXC5cKi9lWyciXXswLDF9IjtpOjQ0O3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aTo0NTtzOjc0OiJAKnNldGNvb2tpZVxzKlwoKlxzKlsnIl17MCwxfWhpdFsnIl17MCwxfSxccyoxXHMqLFxzKnRpbWVccypcKCpccypcKSpccypcKyI7aTo0NjtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aTo0NztzOjU5OiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BccypcKCpccypAKlwkXyI7aTo0ODtzOjQzOiJmb3BlblxzKlwoKlxzKlsnIl17MCwxfS9ldGMvcGFzc3dkWyciXXswLDF9IjtpOjQ5O3M6MjQ6IlwkR0xPQkFMU1xbWyciXXswLDF9X19fXyI7aTo1MDtzOjIxMzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjUxO3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjUyO3M6MTM2OiJ3cF9wb3N0c1xzK1dIRVJFXHMrcG9zdF90eXBlXHMqPVxzKlsnIl17MCwxfXBvc3RbJyJdezAsMX1ccytBTkRccytwb3N0X3N0YXR1c1xzKj1ccypbJyJdezAsMX1wdWJsaXNoWyciXXswLDF9XHMrT1JERVJccytCWVxzK2BJRGBccytERVNDIjtpOjUzO3M6MjA6ImV4ZWNccypcKFxzKlsnIl1pcGZ3IjtpOjU0O3M6NDI6InN0cnJldlwoKlxzKlsnIl17MCwxfXRyZXNzYVsnIl17MCwxfVxzKlwpKiI7aTo1NTtzOjQ5OiJzdHJyZXZcKCpccypbJyJdezAsMX1lZG9jZWRfNDZlc2FiWyciXXswLDF9XHMqXCkqIjtpOjU2O3M6NzA6ImZ1bmN0aW9uXHMrdXJsR2V0Q29udGVudHNccypcKCpccypcJHVybFxzKixccypcJHRpbWVvdXRccyo9XHMqXGQrXHMqXCkiO2k6NTc7czoyNjoic3ltbGlua1xzKlwoKlxzKlsnIl0vaG9tZS8iO2k6NTg7czo3MToiZndyaXRlXHMqXCgqXHMqXCRmcHNldHZccyosXHMqZ2V0ZW52XHMqXChccypbJyJdSFRUUF9DT09LSUVbJyJdXHMqXClccyoiO2k6NTk7czo2NjoiaXNzZXRccypcKCpccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1leGVjZ2F0ZVsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjYwO3M6MjAwOiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9PFw/IHN5c3RlbVwoXFxcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbY3BjXF1cKTtleGl0O1xzKlw/PlsnIl17MCwxfVxzKixccyowXHMqLDBccyosXHMqMFxzKixccyowXHMrSU5UT1xzK09VVEZJTEVccytbJyJdezAsMX1cJFsnIl17MCwxfSI7aTo2MTtzOjE0OToiXCRHTE9CQUxTXFtbJyJdezAsMX0uKz9bJyJdezAsMX1cXT1BcnJheVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXClccyosXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXCkiO2k6NjI7czo3MzoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCpcWy4rP1xdXD8vZVsnIl17MCwxfVxzKixccypzdHJfcmVwbGFjZSI7aTo2MztzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6NjQ7czoxMTU6IlwkYmVlY29kZVxzKj1AKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqWyciXXswLDF9XHMqXCR1cmxwdXJzXHMqWyciXXswLDF9XCkqXHMqO1xzKmVjaG9ccytbJyJdezAsMX1cJGJlZWNvZGVbJyJdezAsMX0iO2k6NjU7czo3OToiXCR4XGQrXHMqPVxzKlsnIl0uKz9bJyJdXHMqO1xzKlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXSI7aTo2NjtzOjQzOiI8XD9waHBccytcJF9GXHMqPVxzKl9fRklMRV9fXHMqO1xzKlwkX1hccyo9IjtpOjY3O3M6Njg6ImlmXHMrXCgqXHMqbWFpbFxzKlwoXHMqXCRyZWNwXHMqLFxzKlwkc3VialxzKixccypcJHN0dW50XHMqLFxzKlwkZnJtIjtpOjY4O3M6MTM5OiJpZlxzK1woXHMqc3RycG9zXHMqXChccypcJHVybFxzKixccypbJyJdanMvbW9vdG9vbHNcLmpzWyciXVxzKlwpXHMqPT09XHMqZmFsc2VccysmJlxzK3N0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL2NhcHRpb25cLmpzWyciXXswLDF9IjtpOjY5O3M6ODE6ImV2YWxccypcKCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BcKCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo3MDtzOjI2MToiaWZccypcKCpccyppc3NldFxzKlwoKlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF1ccypcKSpccypcKVxzKntccypcJFthLXpBLVpfMC05XStccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVthLXpBLVpfMC05XStbJyJdezAsMX1ccypcXTtccypldmFsXHMqXCgqXHMqXCRbYS16QS1aXzAtOV0rXHMqXCkqIjtpOjcxO3M6MTIzOiJwcmVnX3JlcGxhY2VccypcKFxzKlsnIl0vXF5cKHd3d1x8ZnRwXClcXFwuL2lbJyJdXHMqLFxzKlsnIl1bJyJdLFxzKkBcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxzKlxdXHMqXCkiO2k6NzI7czoxMDE6ImlmXHMqXCghZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdcG9zaXhfZ2V0cHd1aWRbJyJdXHMqXClccyomJlxzKiFpbl9hcnJheVxzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkIjtpOjczO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6NzQ7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6NzU7czoyMzoiXChccypbJyJdSU5TSEVMTFsnIl1ccyoiO2k6NzY7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjc3O3M6OTQ6ImFycmF5X3BvcFxzKlwoKlxzKlwkd29ya1JlcGxhY2VccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccyosXHMqXCRjb3VudEtleXNOZXciO2k6Nzg7czozNToiaWZccypcKCpccypAKnByZWdfbWF0Y2hccypcKCpccypzdHIiO2k6Nzk7czo0MzoiQFwkX0NPT0tJRVxbWyciXXswLDF9c3RhdENvdW50ZXJbJyJdezAsMX1cXSI7aTo4MDtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjgxO3M6NTU6IkAqZ3ppbmZsYXRlXHMqXChccypAKmJhc2U2NF9kZWNvZGVccypcKFxzKkAqc3RyX3JlcGxhY2UiO2k6ODI7czoyODoiZmlsZV9wdXRfY29udGVudHpccypcKCpccypcJCI7aTo4MztzOjg3OiImJlxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoKlxzKlsnIl17MCwxfWdldG14cnJbJyJdezAsMX1cKVxzKlwpXHMqe1xzKkBnZXRteHJyXHMqXCgqXHMqXCQiO2k6ODQ7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6ODU7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aTo4NjtzOjg1OiJleGl0XHMqXChccypbJyJdezAsMX08c2NyaXB0PlxzKnNldFRpbWVvdXRccypcKFxzKlxcWyciXXswLDF9ZG9jdW1lbnRcLmxvY2F0aW9uXC5ocmVmIjtpOjg3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aTo4ODtzOjM4OiJldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlxcXCRfUkVRVUVTVCI7aTo4OTtzOjM2OiIhdG91Y2hcKFsnIl17MCwxfVwuXC4vXC5cLi9sYW5ndWFnZS8iO2k6OTA7czoxMDoiRGMwUkhhWyciXSI7aTo5MTtzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6OTI7czoxNTY6ImlmXHMqXChccypzdHJpcG9zXHMqXChccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqLFxzKlsnIl17MCwxfUFuZHJvaWRbJyJdezAsMX1cKVxzKiE9PWZhbHNlXHMqJiZccyohXCRfQ09PS0lFXFtbJyJdezAsMX1kbGVfdXNlcl9pZCI7aTo5MztzOjM4OiJlY2hvXHMrQGZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypcJGdldCI7aTo5NDtzOjQ3OiJkZWZhdWx0X2FjdGlvblxzKj1ccypbJyJdezAsMX1GaWxlc01hblsnIl17MCwxfSI7aTo5NTtzOjMzOiJkZWZpbmVccypcKFxzKlsnIl1ERUZDQUxMQkFDS01BSUwiO2k6OTY7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6OTc7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aTo5ODtzOjQ1OiJkZWZpbmVccypcKCpccypbJyJdU0JDSURfUkVRVUVTVF9GSUxFWyciXVxzKiwiO2k6OTk7czo2MDoiXCR0bGRccyo9XHMqYXJyYXlccypcKFxzKlsnIl1jb21bJyJdLFsnIl1vcmdbJyJdLFsnIl1uZXRbJyJdIjtpOjEwMDtzOjE3OiJCcmF6aWxccytIYWNrVGVhbSI7aToxMDE7czo0NzoiZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTAyO3M6NDc6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzIjtpOjEwMztzOjU0OiJiYXNlNjRfZGVjb2RlXHMqXChccypnenVuY29tcHJlc3NccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTA0O3M6Njg6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzIjtpOjEwNTtzOjQ0OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cnJldiI7aToxMDY7czo2MToiZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJyZXZccypcKFxzKnN0cl9yb3QxMyI7aToxMDc7czo2MToiZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJfcm90MTNccypcKFxzKnN0cnJldiI7aToxMDg7czo1MDoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJfcm90MTMiO2k6MTA5O3M6NTA6Imd6dW5jb21wcmVzc1xzKlwoXHMqc3RyX3JvdDEzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjExMDtzOjQ3OiJzdHJfcm90MTNccypcKFxzKmd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToxMTE7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6MTEyO3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxMTM7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTE0O3M6Njc6InNldF90aW1lX2xpbWl0XHMqXChccyowXHMqXCk7XHMqaWZccypcKCFTZWNyZXRQYWdlSGFuZGxlcjo6Y2hlY2tLZXkiO2k6MTE1O3M6NzM6IkBoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypbJyJdXC5bJyJdaFsnIl1cLlsnIl10WyciXVwuWyciXXRbJyJdXC5bJyJdcFsnIl0iO2k6MTE2O3M6OToiSXJTZWNUZWFtIjtpOjExNztzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjExODtzOjc0OiJjbGVhcnN0YXRjYWNoZVwoXHMqXCk7XHMqaWZccypcKFxzKiFpc19kaXJccypcKFxzKlwkZmxkXHMqXClccypcKVxzKnJldHVybiI7aToxMTk7czo5NzoiY29udGVudD1bJyJdezAsMX1uby1jYWNoZVsnIl17MCwxfTtccypcJGNvbmZpZ1xbWyciXXswLDF9ZGVzY3JpcHRpb25bJyJdezAsMX1cXVxzKlwuPVxzKlsnIl17MCwxfSI7aToxMjA7czoxMjoidG1oYXBiemNlcmZmIjtpOjEyMTtzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjEyMjtzOjg3OiJpZlxzKlwoXHMqXCRpXHMqPFxzKlwoXHMqY291bnRccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXFbJyJdezAsMX1ccypcXVxzKlwpXHMqLVxzKjEiO2k6MTIzO3M6MjMyOiJpc3NldFxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmlzX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccypjb3B5XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdIjtpOjEyNDtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjEyNTtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjEyNjtzOjM5OiJldmFsXHMqXCgqXHMqc3RycmV2XHMqXCgqXHMqc3RyX3JlcGxhY2UiO2k6MTI3O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxMjg7czo3MjoiXF5kb3dubG9hZHMvXChcWzAtOVxdXCpcKS9cKFxbMC05XF1cKlwpL1wkXHMrZG93bmxvYWRzXC5waHBcP2M9XCQxJnA9XCQyIjtpOjEyOTtzOjkyOiJwcmVnX3JlcGxhY2VccypcKFxzKlwkZXhpZlxbXHMqXFxbJyJdTWFrZVxcWyciXVxzKlxdXHMqLFxzKlwkZXhpZlxbXHMqXFxbJyJdTW9kZWxcXFsnIl1ccypcXSI7aToxMzA7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTMxO3M6NDE6ImZ1bmN0aW9uXHMraW5qZWN0XChcJGZpbGUsXHMqXCRpbmplY3Rpb249IjtpOjEzMjtzOjcxOiJleGVjbFwoWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0vYmluL3NoWyciXVxzKixccypbJyJdLWlbJyJdXHMqLFxzKjBcKSI7aToxMzM7czo0MzoiZmluZFxzKy9ccystdHlwZVxzK2ZccystcGVybVxzKy0wNDAwMFxzKy1scyI7aToxMzQ7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTM1O3M6NjU6InVybGVuY29kZVwocHJpbnRfclwoYXJyYXlcKFwpLDFcKVwpLDUsMVwpXC5jXCksXCRjXCk7fWV2YWxcKFwkZFwpIjtpOjEzNjtzOjg5OiJhcnJheV9rZXlfZXhpc3RzXHMqXChccypcJGZpbGVSYXNccyosXHMqXCRmaWxlVHlwZVwpXHMqXD9ccypcJGZpbGVUeXBlXFtccypcJGZpbGVSYXNccypcXSI7aToxMzc7czo5OToiaWZccypcKFxzKmZ3cml0ZVxzKlwoXHMqXCRoYW5kbGVccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEzODtzOjE3ODoiaWZccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXBhdGhbJyJdezAsMX1ccypcXVxzKj09XHMqWyciXXswLDF9WyciXXswLDF9XHMqXClccyp7XHMqXCR1cGxvYWRmaWxlXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aToxMzk7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTQwO3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxNDE7czo2NToiXCRmbFxzKj1ccyoiPG1ldGEgaHR0cC1lcXVpdj1cXCJSZWZyZXNoXFwiXHMrY29udGVudD1cXCIwO1xzKlVSTD0iO2k6MTQyO3M6NTE6IlwpXHMqXC5ccypzdWJzdHJccypcKFxzKm1kNVxzKlwoXHMqc3RycmV2XHMqXChccypcJCI7aToxNDM7czoyODoiYXNzZXJ0XHMqXChccypAKnN0cmlwc2xhc2hlcyI7aToxNDQ7czoxNToiWyciXWUvXCpcLi9bJyJdIjtpOjE0NTtzOjUyOiJlY2hvWyciXXswLDF9PGNlbnRlcj48Yj5Eb25lXHMqPT0+XHMqXCR1c2VyZmlsZV9uYW1lIjtpOjE0NjtzOjEzNDoiaWZccypcKFwka2V5XHMqIT1ccypbJyJdezAsMX1tYWlsX3RvWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9zZXJ2ZXJbJyJdezAsMX1ccyomJlxzKlwka2V5XHMqIT1ccypbJyJdezAsMX1zbXRwX3BvcnQiO2k6MTQ3O3M6NTk6InN0cnBvc1woXCR1YSxccypbJyJdezAsMX15YW5kZXhib3RbJyJdezAsMX1cKVxzKiE9PVxzKmZhbHNlIjtpOjE0ODtzOjQ1OiJpZlwoQ2hlY2tJUE9wZXJhdG9yXChcKVxzKiYmXHMqIWlzTW9kZW1cKFwpXCkiO2k6MTQ5O3M6MzQ6InVybD08XD9waHBccyplY2hvXHMqXCRyYW5kX3VybDtcPz4iO2k6MTUwO3M6Mjc6ImVjaG9ccypbJyJdYW5zd2VyPWVycm9yWyciXSI7aToxNTE7czozMjoiXCRwb3N0XHMqPVxzKlsnIl1cXHg3N1xceDY3XFx4NjUiO2k6MTUyO3M6NDY6ImlmXHMqXChkZXRlY3RfbW9iaWxlX2RldmljZVwoXClcKVxzKntccypoZWFkZXIiO2k6MTUzO3M6OToiSXJJc1RcLklyIjtpOjE1NDtzOjg5OiJcJGxldHRlclxzKj1ccypzdHJfcmVwbGFjZVxzKlwoXHMqXCRBUlJBWVxbMFxdXFtcJGpcXVxzKixccypcJGFyclxbXCRpbmRcXVxzKixccypcJGxldHRlciI7aToxNTU7czo5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChccypbJyJdXCRtWyciXVxzKixccypbJyJdaWZccypcKFxzKlwkbVxzKlxbXHMqMHgwMVxzKlxdXHMqPT1ccypbJyJdTFsnIl0iO2k6MTU2O3M6NzI6IlwkcFxzKj1ccypzdHJwb3NcKFwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxNTc7czoxMTI6IlwkdXNlcl9hZ2VudFxzKj1ccypwcmVnX3JlcGxhY2VccypcKFxzKlsnIl1cfFVzZXJcXFwuQWdlbnRcXDpcW1xccyBcXVw/XHxpWyciXVxzKixccypbJyJdWyciXVxzKixccypcJHVzZXJfYWdlbnQiO2k6MTU4O3M6MzE6InByaW50XCgiXCNccytpbmZvXHMrT0tcXG5cXG4iXCkiO2k6MTU5O3M6NTE6IlxdXHMqfVxzKj1ccyp0cmltXHMqXChccyphcnJheV9wb3BccypcKFxzKlwke1xzKlwkeyI7aToxNjA7czo2NDoiXF09WyciXXswLDF9aXBbJyJdezAsMX1ccyo7XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJF9TRVJWRVJcWyI7aToxNjE7czozNDoicHJpbnRccypcJHNvY2sgIlBSSVZNU0cgIlwuXCRvd25lciI7aToxNjI7czo2MzoiaWZcKC9cXlxcOlwkb3duZXIhXC5cKlxcQFwuXCpQUklWTVNHXC5cKjpcLm1zZ2Zsb29kXChcLlwqXCkvXCl7IjtpOjE2MztzOjI2OiJcWy1cXVxzK0Nvbm5lY3Rpb25ccytmYWlsZCI7aToxNjQ7czo1NDoiPCEtLVwjZXhlY1xzK2NtZD1bJyJdezAsMX1cJEhUVFBfQUNDRVBUWyciXXswLDF9XHMqLS0+IjtpOjE2NTtzOjE2NzoiWyciXXswLDF9RnJvbTpccypbJyJdezAsMX1cLlwkX1BPU1RcW1snIl17MCwxfXJlYWxuYW1lWyciXXswLDF9XF1cLlsnIl17MCwxfSBbJyJdezAsMX1cLlsnIl17MCwxfSA8WyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1mcm9tWyciXXswLDF9XF1cLlsnIl17MCwxfT5cXG5bJyJdezAsMX0iO2k6MTY2O3M6OTk6ImlmXHMqXChccyppc19kaXJccypcKFxzKlwkRnVsbFBhdGhccypcKVxzKlwpXHMqQWxsRGlyXHMqXChccypcJEZ1bGxQYXRoXHMqLFxzKlwkRmlsZXNccypcKTtccyp9XHMqfSI7aToxNjc7czo3ODoiXCRwXHMqPVxzKnN0cnBvc1xzKlwoXHMqXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjE2ODtzOjEyMzoicHJlZ19tYXRjaF9hbGxcKFsnIl17MCwxfS88YSBocmVmPSJcXC91cmxcXFw/cT1cKFwuXCtcP1wpXFsmXHwiXF1cKy9pc1snIl17MCwxfSwgXCRwYWdlXFtbJyJdezAsMX1leGVbJyJdezAsMX1cXSwgXCRsaW5rc1wpIjtpOjE2OTtzOjgwOiJcJHVybFxzKj1ccypcJHVybFxzKlwuXHMqWyciXXswLDF9XD9bJyJdezAsMX1ccypcLlxzKmh0dHBfYnVpbGRfcXVlcnlcKFwkcXVlcnlcKSI7aToxNzA7czo4MzoicHJpbnRccytcJHNvY2tccytbJyJdezAsMX1OSUNLIFsnIl17MCwxfVxzK1wuXHMrXCRuaWNrXHMrXC5ccytbJyJdezAsMX1cXG5bJyJdezAsMX0iO2k6MTcxO3M6MzI6IlBSSVZNU0dcLlwqOlwub3duZXJcXHNcK1woXC5cKlwpIjtpOjE3MjtzOjE1OiIvdXNyL3NiaW4vaHR0cGQiO2k6MTczO3M6NzU6IlwkcmVzdWx0RlVMXHMqPVxzKnN0cmlwY3NsYXNoZXNccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfXJlc3VsdEZVTFsnIl17MCwxfSI7aToxNzQ7czoxNTI6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKlwpIjtpOjE3NTtzOjYwOiJpZlxzKlwoXHMqQCptZDVccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTc2O3M6OTQ6ImVjaG9ccytmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqYmFzZTY0X3VybF9kZWNvZGVccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTc3O3M6ODQ6ImZ3cml0ZVxzKlwoXHMqXCRmaFxzKixccypzdHJpcHNsYXNoZXNccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNzg7czo4MzoiaWZccypcKFxzKm1haWxccypcKFxzKlwkbWFpbHNcW1wkaVxdXHMqLFxzKlwkdGVtYVxzKixccypiYXNlNjRfZW5jb2RlXHMqXChccypcJHRleHQiO2k6MTc5O3M6NjI6IlwkZ3ppcFxzKj1ccypAKmd6aW5mbGF0ZVxzKlwoXHMqQCpzdWJzdHJccypcKFxzKlwkZ3plbmNvZGVfYXJnIjtpOjE4MDtzOjczOiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFtbJyJdezAsMX1lbGlmWyciXXswLDF9XF1cW1snIl17MCwxfXRtcF9uYW1lIjtpOjE4MTtzOjgwOiJoZWFkZXJcKFsnIl17MCwxfXM6XHMqWyciXXswLDF9XHMqXC5ccypwaHBfdW5hbWVccypcKFxzKlsnIl17MCwxfW5bJyJdezAsMX1ccypcKSI7aToxODI7czoxMjoiQnlccytXZWJSb29UIjtpOjE4MztzOjU3OiJcJE9PTzBPME8wMD1fX0ZJTEVfXztccypcJE9PMDBPMDAwMFxzKj1ccyoweDFiNTQwO1xzKmV2YWwiO2k6MTg0O3M6NTI6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1snIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XF0iO2k6MTg1O3M6Nzc6InByZWdfbWF0Y2hcKFsnIl0vXCh5YW5kZXhcfGdvb2dsZVx8Ym90XCkvaVsnIl0sXHMqZ2V0ZW52XChbJyJdSFRUUF9VU0VSX0FHRU5UIjtpOjE4NjtzOjQ3OiJlY2hvXHMrXCRpZnVwbG9hZD1bJyJdezAsMX1ccypJdHNPa1xzKlsnIl17MCwxfSI7aToxODc7czo0MjoiZnNvY2tvcGVuXHMqXChccypcJENvbm5lY3RBZGRyZXNzXHMqLFxzKjI1IjtpOjE4ODtzOjY0OiJcJF9TRVNTSU9OXFtbJyJdezAsMX1zZXNzaW9uX3BpblsnIl17MCwxfVxdXHMqPVxzKlsnIl17MCwxfVwkUElOIjtpOjE4OTtzOjYzOiJcJHVybFsnIl17MCwxfVxzKlwuXHMqXCRzZXNzaW9uX2lkXHMqXC5ccypbJyJdezAsMX0vbG9naW5cLmh0bWwiO2k6MTkwO3M6NDE6ImNvbnRlbnQ9WyciXXswLDF9MTtVUkw9Y2dpLWJpblwuaHRtbFw/Y21kIjtpOjE5MTtzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aToxOTI7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxOTM7czozMzoiZGllXHMqXChccypQSFBfT1NccypcLlxzKmNoclxzKlwoIjtpOjE5NDtzOjE3OToiY3JlYXRlX2Z1bmN0aW9uXHMqXChbJyJdWyciXVxzKixccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6MTk1O3M6ODA6IlwkaGVhZGVyc1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9aGVhZGVyc1snIl17MCwxfVxdIjtpOjE5NjtzOjg2OiJmaWxlX3B1dF9jb250ZW50c1xzKlwoWyciXXswLDF9MVwudHh0WyciXXswLDF9XHMqLFxzKnByaW50X3JccypcKFxzKlwkX1BPU1RccyosXHMqdHJ1ZSI7aToxOTc7czozNToiZndyaXRlXHMqXChccypcJGZsd1xzKixccypcJGZsXHMqXCkiO2k6MTk4O3M6Mzg6Ilwkc3lzX3BhcmFtc1xzKj1ccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE5OTtzOjUxOiJcJGFsbGVtYWlsc1xzKj1ccypAc3BsaXRcKCJcXG4iXHMqLFxzKlwkZW1haWxsaXN0XCkiO2k6MjAwO3M6NTA6ImZpbGVfcHV0X2NvbnRlbnRzXChTVkNfU0VMRlxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjIwMTtzOjU3OiJjcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFxzKlwkb3B0XFsxXF1ccypcLlxzKlwkb3B0XFs0XF0iO2k6MjAyO3M6OTU6IjxzY3JpcHRccyt0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzK3NyYz1bJyJdezAsMX1qcXVlcnktdVwuanNbJyJdezAsMX0+PC9zY3JpcHQ+IjtpOjIwMztzOjI4OiJVUkw9PFw/ZWNob1xzK1wkaW5kZXg7XHMrXD8+IjtpOjIwNDtzOjIzOiJcI1xzKnNlY3VyaXR5c3BhY2VcLmNvbSI7aToyMDU7czoxODoiXCNccypzdGVhbHRoXHMqYm90IjtpOjIwNjtzOjIxOiJBcHBsZVxzK1NwQW1ccytSZVp1bFQiO2k6MjA3O3M6NTI6ImlzX3dyaXRhYmxlXChcJGRpclwuWyciXXdwLWluY2x1ZGVzL3ZlcnNpb25cLnBocFsnIl0iO2k6MjA4O3M6NDI6ImlmXChlbXB0eVwoXCRfQ09PS0lFXFtbJyJdeFsnIl1cXVwpXCl7ZWNobyI7aToyMDk7czoyOToiXClcXTt9aWZcKGlzc2V0XChcJF9TRVJWRVJcW18iO2k6MjEwO3M6NjY6ImlmXChAXCR2YXJzXChnZXRfbWFnaWNfcXVvdGVzX2dwY1woXClccypcP1xzKnN0cmlwc2xhc2hlc1woXCR1cmlcKSI7aToyMTE7czoyNDoiYmFzZVsnIl17MCwxfVwuXCgzMlwqMlwpIjtpOjIxMjtzOjc1OiJcJHBhcmFtXHMqPVxzKlwkcGFyYW1ccyp4XHMqXCRuXC5zdWJzdHJccypcKFwkcGFyYW1ccyosXHMqbGVuZ3RoXChcJHBhcmFtXCkiO2k6MjEzO3M6NTM6InJlZ2lzdGVyX3NodXRkb3duX2Z1bmN0aW9uXChccypbJyJdezAsMX1yZWFkX2Fuc19jb2RlIjtpOjIxNDtzOjM1OiJiYXNlNjRfZGVjb2RlXChcJF9QT1NUXFtbJyJdezAsMX1fLSI7aToyMTU7czo1NDoiaWZcKGlzc2V0XChcJF9QT1NUXFtbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XF1cKVwpIjtpOjIxNjtzOjEzMzoibWFpbFwoXCRhcnJcW1snIl17MCwxfXRvWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfXN1YmpbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9bXNnWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfWhlYWRbJyJdezAsMX1cXVwpOyI7aToyMTc7czozODoiZmlsZV9nZXRfY29udGVudHNcKHRyaW1cKFwkZlxbXCRfR0VUXFsiO2k6MjE4O3M6NjA6ImluaV9nZXRcKFsnIl17MCwxfWZpbHRlclwuZGVmYXVsdF9mbGFnc1snIl17MCwxfVwpXCl7Zm9yZWFjaCI7aToyMTk7czo1MDoiY2h1bmtfc3BsaXRcKGJhc2U2NF9lbmNvZGVcKGZyZWFkXChcJHtcJHtbJyJdezAsMX0iO2k6MjIwO3M6NTI6Ilwkc3RyPVsnIl17MCwxfTxoMT40MDNccytGb3JiaWRkZW48L2gxPjwhLS1ccyp0b2tlbjoiO2k6MjIxO3M6MzM6IjxcP3BocFxzK3JlbmFtZVwoWyciXXdzb1wucGhwWyciXSI7aToyMjI7czo2NjoiXCRbYS16QS1aMC05X10rPy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8vXCouezEsMTB9XCovIjtpOjIyMztzOjUxOiJAKm1haWxcKFwkbW9zQ29uZmlnX21haWxmcm9tLCBcJG1vc0NvbmZpZ19saXZlX3NpdGUiO2k6MjI0O3M6ODA6IldCU19ESVJccypcLlxzKlsnIl17MCwxfXRlbXAvWyciXXswLDF9XHMqXC5ccypcJGFjdGl2ZUZpbGVccypcLlxzKlsnIl17MCwxfVwudG1wIjtpOjIyNTtzOjk1OiJcJHQ9XCRzO1xzKlwkb1xzKj1ccypbJyJdWyciXTtccypmb3JcKFwkaT0wO1wkaTxzdHJsZW5cKFwkdFwpO1wkaVwrXCtcKXtccypcJG9ccypcLj1ccypcJHR7XCRpfSI7aToyMjY7czo0NzoibW1jcnlwdFwoXCRkYXRhLCBcJGtleSwgXCRpdiwgXCRkZWNyeXB0ID0gRkFMU0UiO2k6MjI3O3M6MTU6InRuZWdhX3Jlc3VfcHR0aCI7aToyMjg7czo5OiJ0c29oX3B0dGgiO2k6MjI5O3M6MTI6IlJFUkVGRVJfUFRUSCI7aToyMzA7czo2NToiY2hyMj1cKFwoZW5jMiYxNVwpPDw0XClcfFwoZW5jMz4+MlwpO2NocjM9XChcKGVuYzMmM1wpPDw2XClcfGVuYzQiO2k6MjMxO3M6MzE6IndlYmlcLnJ1L3dlYmlfZmlsZXMvcGhwX2xpYm1haWwiO2k6MjMyO3M6NDA6InN1YnN0cl9jb3VudFwoZ2V0ZW52XChcXFsnIl1IVFRQX1JFRkVSRVIiO2k6MjMzO3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6MjM0O3M6MjU6ImltZyBzcmM9WyciXW9wZXJhMDAwXC5wbmciO2k6MjM1O3M6NDY6ImVjaG9ccyptZDVcKFwkX1BPU1RcW1snIl17MCwxfWNoZWNrWyciXXswLDF9XF0iO2k6MjM2O3M6MzM6ImVWYUxcKFxzKnRyaW1cKFxzKmJhU2U2NF9kZUNvRGVcKCI7aToyMzc7czo0MjoiZnNvY2tvcGVuXChcJG1cWzBcXSxcJG1cWzEwXF0sXCRfLFwkX18sXCRtIjtpOjIzODtzOjEzOiIiPT5cJHtcJHsiXFx4IjtpOjIzOTtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyNDA7czozMDoiOjpbJyJdXC5waHB2ZXJzaW9uXChcKVwuWyciXTo6IjtpOjI0MTtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjI0MjtzOjE4OiI9PTBcKXtqc29uUXVpdFwoXCQiO2k6MjQzO3M6NDY6ImxvY1xzKj1ccypbJyJdezAsMX08XD9lY2hvXHMrXCRyZWRpcmVjdDtccypcPz4iO2k6MjQ0O3M6Mjg6ImFycmF5XChcJGVuLFwkZXMsXCRlZixcJGVsXCkiO2k6MjQ1O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MjQ2O3M6MTg6ImZ1Y2tccyt5b3VyXHMrbWFtYSI7aToyNDc7czozNDoiXCRhZGRkYXRlPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aToyNDg7czozNjoiXCRkYXRhbWFzaWk9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjI0OTtzOjc4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXWFjdGlvblsnIl1ccypcLlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjUwO3M6NTk6InN0cl9yZXBsYWNlXChcJGZpbmRccyosXHMqXCRmaW5kXHMqXC5ccypcJGh0bWxccyosXHMqXCR0ZXh0IjtpOjI1MTtzOjMzOiJmaWxlX2V4aXN0c1xzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6MjUyO3M6NDE6IiYmXHMqIWVtcHR5XChccypcJF9DT09LSUVcW1snIl1maWxsWyciXVxdIjtpOjI1MztzOjIxOiJmdW5jdGlvblxzK2luRGlhcGFzb24iO2k6MjU0O3M6MzU6Im1ha2VfZGlyX2FuZF9maWxlXChccypcJHBhdGhfam9vbWxhIjtpOjI1NTtzOjQxOiJsaXN0aW5nX3BhZ2VcKFxzKm5vdGljZVwoXHMqWyciXXN5bWxpbmtlZCI7aToyNTY7czo2MjoibGlzdFxzKlwoXHMqXCRob3N0XHMqLFxzKlwkcG9ydFxzKixccypcJHNpemVccyosXHMqXCRleGVjX3RpbWUiO2k6MjU3O3M6NTI6ImZpbGVtdGltZVwoXCRiYXNlcGF0aFxzKlwuXHMqWyciXS9jb25maWd1cmF0aW9uXC5waHAiO2k6MjU4O3M6NTg6ImZ1bmN0aW9uXHMrcmVhZF9waWNcKFxzKlwkQVxzKlwpXHMqe1xzKlwkYVxzKj1ccypcJF9TRVJWRVIiO2k6MjU5O3M6NjQ6ImNoclwoXHMqXCR0YWJsZVxbXHMqXCRzdHJpbmdcW1xzKlwkaVxzKlxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjEiO2k6MjYwO3M6NDA6IlxdXHMqXCl7ZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXCQiO2k6MjYxO3M6NTQ6IkxvY2F0aW9uOjppc0ZpbGVXcml0YWJsZVwoXHMqRW5jb2RlRXhwbG9yZXI6OmdldENvbmZpZyI7aToyNjI7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7fQ=="));
$gX_FlexDBShe = unserialize(base64_decode("YToyNzY6e2k6MDtzOjk6IkJ5XHMrQW0hciI7aToxO3M6MTk6IkNvbnRlbnQtVHlwZTpccypcJF8iO2k6MjtzOjE5OiJyb3VuZFxzKlwoXHMqMFxzKlwrIjtpOjM7czo0MDoiZXZhbFxzKlwoKlxzKmd6aW5mbGF0ZVxzKlwoKlxzKnN0cl9yb3QxMyI7aTo0O3M6MTE0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKlwpXHMqXCkiO2k6NTtzOjEwNzoiaWZccypcKFxzKmlzX2NhbGxhYmxlXHMqXCgqXHMqWyciXXswLDF9KGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKSoiO2k6NjtzOjEwNDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFsiO2k6NztzOjI5OiJldmFsXHMqXCgqXHMqZ2V0X29wdGlvblxzKlwoKiI7aTo4O3M6OTU6ImFkZF9maWx0ZXJccypcKCpccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCkqIjtpOjk7czozMjoiaXNfd3JpdGFibGVccypcKCpccypbJyJdL3Zhci90bXAiO2k6MTA7czo1NzoiT3B0aW9uc1xzK0ZvbGxvd1N5bUxpbmtzXHMrTXVsdGlWaWV3c1xzK0luZGV4ZXNccytFeGVjQ0dJIjtpOjExO3M6OTU6Imlzc2V0XChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKm9yXHMqZGllXCgqLis/XCkqIjtpOjEyO3M6MTQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpIjtpOjEzO3M6NDk6Imd6dW5jb21wcmVzc1xzKlwoKlxzKnN1YnN0clxzKlwoKlxzKmJhc2U2NF9kZWNvZGUiO2k6MTQ7czo5OiJcJF9fX1xzKj0iO2k6MTU7czozMToiPVxzKmFycmF5X21hcFxzKlwoKlxzKnN0cnJldlxzKiI7aToxNjtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjE3O3M6MzI6InN0cl9pcmVwbGFjZVxzKlwoKlxzKlsnIl08L2hlYWQ+IjtpOjE4O3M6MjU6ImV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTk7czozMDoiZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjIwO3M6MzM6Imd6dW5jb21wcmVzc1xzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToyMTtzOjcwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl13Z2V0IjtpOjIyO3M6NzI6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdLFxzKnRpbWVcKFwpXHMqXCtccyo4NjQwMCI7aToyMztzOjI4OiJlY2hvXHMrWyciXW9cLmtcLlsnIl07XHMqXD8+IjtpOjI0O3M6MzM6InN5bWJpYW5cfG1pZHBcfHdhcFx8cGhvbmVcfHBvY2tldCI7aToyNTtzOjQ4OiJmdW5jdGlvblxzKmNobW9kX1JccypcKFxzKlwkcGF0aFxzKixccypcJHBlcm1ccyoiO2k6MjY7czozODoiZXZhbFxzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTMiO2k6Mjc7czoyMToiZXZhbFxzKlwoXHMqc3RyX3JvdDEzIjtpOjI4O3M6Mjg6Imdvb2dsZVx8eWFuZGV4XHxib3RcfHJhbWJsZXIiO2k6Mjk7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjMwO3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MzE7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjMyO3M6OToia2lsbFxzKy05IjtpOjMzO3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTozNDtzOjM1OiJlY2hvXHMrWyciXXswLDF9aW5zdGFsbF9va1snIl17MCwxfSI7aTozNTtzOjE2OiJTcGFtXHMrY29tcGxldGVkIjtpOjM2O3M6MjE6Ij09WyciXVwpXCk7cmV0dXJuO1w/PiI7aTozNztzOjEyOiJhbmRleFx8b29nbGUiO2k6Mzg7czo0NDoiYXJyYXlcKFxzKlsnIl1Hb29nbGVbJyJdXHMqLFxzKlsnIl1TbHVycFsnIl0iO2k6Mzk7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO2k6NDA7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6NDE7czoyMDoiL2VbJyJdXHMqLFxzKlsnIl1cXHgiO2k6NDI7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6NDM7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6NDQ7czo0MDoiKFteXD9cc10pXCh7MCwxfVwuW1wrXCpdXCl7MCwxfVwyW2Etel0qZSI7aTo0NTtzOjM2OiJwcmVnX3JlcGxhY2VcKFxzKlsnIl1lWyciXSxbJyJdezAsMX0iO2k6NDY7czo1MzoiZm9wZW5cKFsnIl17MCwxfVwuXC4vXC5cLi9cLlwuL1snIl17MCwxfVwuXCRmaWxlcGF0aHMiO2k6NDc7czo1MToiXCRkYXRhXHMqPVxzKmFycmF5XChbJyJdezAsMX10ZXJtaW5hbFsnIl17MCwxfVxzKj0+IjtpOjQ4O3M6Mjk6IlwkYlxzKj1ccyptZDVfZmlsZVwoXCRmaWxlYlwpIjtpOjQ5O3M6MzM6InBvcnRsZXRzL2ZyYW1ld29yay9zZWN1cml0eS9sb2dpbiI7aTo1MDtzOjMxOiJcJGZpbGViXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjUxO3M6MTA0OiJzaXRlX2Zyb209WyciXXswLDF9XC5cJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxdXC5bJyJdezAsMX0mc2l0ZV9mb2xkZXI9WyciXXswLDF9XC5cJGZcWzFcXSI7aTo1MjtzOjU2OiJ3aGlsZVwoY291bnRcKFwkbGluZXNcKT5cJGNvbF96YXBcKSBhcnJheV9wb3BcKFwkbGluZXNcKSI7aTo1MztzOjg1OiJcJHN0cmluZ1xzKj1ccypcJF9TRVNTSU9OXFtbJyJdezAsMX1kYXRhX2FbJyJdezAsMX1cXVxbWyciXXswLDF9bnV0emVybmFtZVsnIl17MCwxfVxdIjtpOjU0O3M6NDE6ImlmIFwoIXN0cnBvc1woXCRzdHJzXFswXF0sWyciXXswLDF9PFw/cGhwIjtpOjU1O3M6MjU6IlwkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6NTY7czoxNDoiRGF2aWRccytCbGFpbmUiO2k6NTc7czo0NzoiaWYgXChkYXRlXChbJyJdezAsMX1qWyciXXswLDF9XClccyotXHMqXCRuZXdzaWQiO2k6NTg7czo3OiJ1Z2djOi8vIjtpOjU5O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo2MDtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjYxO3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NjI7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo2MztzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjY0O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjY1O3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjY2O3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjY3O3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo2ODtzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjY5O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjcwO3M6MTA4OiJmb3JcKFwkW2EtekEtWjAtOV9dKz89XGQrO1wkW2EtekEtWjAtOV9dKz88XGQrO1wkW2EtekEtWjAtOV9dKz8tPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSs/IT1cZCtcKVxzKmJyZWFrO30iO2k6NzE7czozNjoiaWZcKEBmdW5jdGlvbl9leGlzdHNcKFsnIl17MCwxfWZyZWFkIjtpOjcyO3M6MzM6Ilwkb3B0XHMqPVxzKlwkZmlsZVwoQCpcJF9DT09LSUVcWyI7aTo3MztzOjM4OiJwcmVnX3JlcGxhY2VcKFwpe3JldHVyblxzK19fRlVOQ1RJT05fXyI7aTo3NDtzOjM5OiJpZlxzKlwoY2hlY2tfYWNjXChcJGxvZ2luLFwkcGFzcyxcJHNlcnYiO2k6NzU7czozNjoicHJpbnRccytbJyJdezAsMX1kbGVfbnVsbGVkWyciXXswLDF9IjtpOjc2O3M6NjM6ImlmXChtYWlsXChcJGVtYWlsXFtcJGlcXSxccypcJHN1YmplY3QsXHMqXCRtZXNzYWdlLFxzKlwkaGVhZGVycyI7aTo3NztzOjEyOiJUZWFNXHMrTW9zVGEiO2k6Nzg7czoxNDoiWyciXXswLDF9RFplMXIiO2k6Nzk7czoxNToicGFja1xzKyJTbkE0eDgiIjtpOjgwO3M6MzI6IlwkX1Bvc3RcW1snIl17MCwxfVNTTlsnIl17MCwxfVxdIjtpOjgxO3M6Mjc6IkV0aG5pY1xzK0FsYmFuaWFuXHMrSGFja2VycyI7aTo4MjtzOjk6IkJ5XHMrRFoyNyI7aTo4MztzOjcyOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9Y21kXC5leGUiO2k6ODQ7czoxMDI6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIiI7aTo4NTtzOjE1OiJBdXRvXHMqWHBsb2l0ZXIiO2k6ODY7czo5OiJieVxzK2cwMG4iO2k6ODc7czoyODoiaWZcKFwkbzwxNlwpe1wkaFxbXCRlXFtcJG9cXSI7aTo4ODtzOjk0OiJpZlwoaXNfZGlyXChcJHBhdGhcLlsnIl17MCwxfS93cC1jb250ZW50WyciXXswLDF9XClccytBTkRccytpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWFkbWluIjtpOjg5O3M6NjA6ImlmXHMqXChccypmaWxlX3B1dF9jb250ZW50c1xzKlwoXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aTo5MDtzOjUxOiJAYXJyYXlcKFxzKlwoc3RyaW5nXClccypzdHJpcHNsYXNoZXNcKFxzKlwkX1JFUVVFU1QiO2k6OTE7czo0MDoic3RyX3JlcGxhY2VccypcKFxzKlsnIl17MCwxfS9wdWJsaWNfaHRtbCI7aTo5MjtzOjQxOiJpZlwoXHMqaXNzZXRcKFxzKlwkX1JFUVVFU1RcW1snIl17MCwxfWNpZCI7aTo5MztzOjE1OiJjYXRhdGFuXHMrc2l0dXMiO2k6OTQ7czo4NjoiL2luZGV4XC5waHBcP29wdGlvbj1jb21famNlJnRhc2s9cGx1Z2luJnBsdWdpbj1pbWdtYW5hZ2VyJmZpbGU9aW1nbWFuYWdlciZ2ZXJzaW9uPTE1NzYiO2k6OTU7czozNzoic2V0Y29va2llXChccypcJHpcWzBcXVxzKixccypcJHpcWzFcXSI7aTo5NjtzOjMyOiJcJFNcW1wkaVwrXCtcXVwoXCRTXFtcJGlcK1wrXF1cKCI7aTo5NztzOjMyOiJcW1wkb1xdXCk7XCRvXCtcK1wpe2lmXChcJG88MTZcKSI7aTo5ODtzOjgxOiJ0eXBlb2ZccypcKGRsZV9hZG1pblwpXHMqPT1ccypbJyJdezAsMX11bmRlZmluZWRbJyJdezAsMX1ccypcfFx8XHMqZGxlX2FkbWluXHMqPT0iO2k6OTk7czozNjoiY3JlYXRlX2Z1bmN0aW9uXChzdWJzdHJcKDIsMVwpLFwkc1wpIjtpOjEwMDtzOjYwOiJwbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwJTNBJTJGJTJGd3d3XC5nb29nbGUiO2k6MTAxO3M6MzY6InJldHVyblxzK2Jhc2U2NF9kZWNvZGVcKFwkYVxbXCRpXF1cKSI7aToxMDI7czo0NToiXCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEwMztzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTA0O3M6MzI6ImV2YWxcKFsnIl1cPz5bJyJdXC5iYXNlNjRfZGVjb2RlIjtpOjEwNTtzOjI5OiJbJyJdWyciXVxzKlwuXHMqQkFzZTY0X2RlQ29EZSI7aToxMDY7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aToxMDc7czoxOToiZ3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMDg7czozNDoiY3JjMzJcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfWNtZCI7aToxMDk7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aToxMTA7czoyNzoiaHR0cHM6Ly9hcHBsZWlkXC5hcHBsZVwuY29tIjtpOjExMTtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6MTEyO3M6NTQ6IlxzKlsnIl17MCwxfXJvb2tlZVsnIl17MCwxfVxzKixccypbJyJdezAsMX13ZWJlZmZlY3RvciI7aToxMTM7czo0ODoiXHMqWyciXXswLDF9c2x1cnBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9bXNuYm90IjtpOjExNDtzOjM4OiJKUmVzcG9uc2U6OnNldEJvZHlccypcKFxzKnByZWdfcmVwbGFjZSI7aToxMTU7czoyMDoiZXZhbFxzKlwoXHMqVFBMX0ZJTEUiO2k6MTE2O3M6ODI6IkAqYXJyYXlfZGlmZl91a2V5XChccypAKmFycmF5XChccypcKHN0cmluZ1wpXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTE3O3M6MTA1OiJcJHBhdGhccyo9XHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF1ccypcLlxzKlsnIl17MCwxfS9pbWFnZXMvc3Rvcmllcy9bJyJdezAsMX0iO2k6MTE4O3M6ODk6Ilwkc2FwZV9vcHRpb25cW1xzKlsnIl17MCwxfWZldGNoX3JlbW90ZV90eXBlWyciXXswLDF9XHMqXF1ccyo9XHMqWyciXXswLDF9c29ja2V0WyciXXswLDF9IjtpOjExOTtzOjg4OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRuYW1lXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEyMDtzOjgyOiJlcmVnX3JlcGxhY2VcKFsnIl17MCwxfSU1QyUyMlsnIl17MCwxfVxzKixccypbJyJdezAsMX0lMjJbJyJdezAsMX1ccyosXHMqXCRtZXNzYWdlIjtpOjEyMTtzOjg1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9dXJbJyJdezAsMX1cXVwpXClccypcJG1vZGVccypcfD1ccyowNDAwIjtpOjEyMjtzOjkxOiJtYWlsXChccypzdHJpcHNsYXNoZXNcKFwkdG9cKVxzKixccypzdHJpcHNsYXNoZXNcKFwkc3ViamVjdFwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRtZXNzYWdlIjtpOjEyMztzOjQxOiIvcGx1Z2lucy9zZWFyY2gvcXVlcnlcLnBocFw/X19fX3BnZmE9aHR0cCI7aToxMjQ7czo0OToiQCpmaWxlX3B1dF9jb250ZW50c1woXHMqXCR0aGlzLT5maWxlXHMqLFxzKnN0cnJldiI7aToxMjU7czo0ODoicHJlZ19tYXRjaF9hbGxcKFxzKlsnIl1cfFwoXC5cKlwpPFxcIS0tIGpzLXRvb2xzIjtpOjEyNjtzOjMwOiJoZWFkZXJcKFsnIl17MCwxfXI6XHMqbm9ccytjb20iO2k6MTI3O3M6NzM6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHNccysvdmFyL21haWwiO2k6MTI4O3M6MjY6IlwkZG9yX2NvbnRlbnQ9cHJlZ19yZXBsYWNlIjtpOjEyOTtzOjIzOiJfX3VybF9nZXRfY29udGVudHNcKFwkbCI7aToxMzA7czo1NDoiXCRHTE9CQUxTXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXChccypOVUxMIjtpOjEzMTtzOjYyOiJ1bmFtZVxdWyciXXswLDF9XHMqXC5ccypwaHBfdW5hbWVcKFwpXHMqXC5ccypbJyJdezAsMX1cWy91bmFtZSI7aToxMzI7czozMzoiQFwkZnVuY1woXCRjZmlsZSwgXCRjZGlyXC5cJGNuYW1lIjtpOjEzMztzOjM2OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypcJDxhbWMiO2k6MTM0O3M6NzE6IlwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrXHMqXF1cKFwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrIjtpOjEzNTtzOjI5OiJlcmVnaVwoXHMqc3FsX3JlZ2Nhc2VcKFxzKlwkXyI7aToxMzY7czo0MDoiXCNVc2VbJyJdezAsMX1ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKCI7aToxMzc7czoyMDoibWtkaXJcKFxzKlsnIl0vaG9tZS8iO2k6MTM4O3M6MjA6ImZvcGVuXChccypbJyJdL2hvbWUvIjtpOjEzOTtzOjM2OiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XCgiO2k6MTQwO3M6NDQ6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdezAsMX1cLi9saWJ3b3JrZXJcLnNvIjtpOjE0MTtzOjY0OiJcIyEvYmluL3NobmNkXHMrWyciXXswLDF9WyciXXswLDF9XC5cJFNDUFwuWyciXXswLDF9WyciXXswLDF9bmlmIjtpOjE0MjtzOjgwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXXswLDF9YXRccytub3dccystZiI7aToxNDM7czozMzoiY3JvbnRhYlxzKy1sXHxncmVwXHMrLXZccytjcm9udGFiIjtpOjE0NDtzOjE0OiJEYXZpZFxzKkJsYWluZSI7aToxNDU7czoyMzoiZXhwbG9pdC1kYlwuY29tL3NlYXJjaC8iO2k6MTQ2O3M6MjM6ImlzX3dyaXRhYmxlPWlzX3dyaXRhYmxlIjtpOjE0NztzOjcwOiJtYWlsXChccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdIjtpOjE0ODtzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTQ5O3M6NjA6Im1haWxcKFxzKlwkTWFpbFRvXHMqLFxzKlwkTWVzc2FnZVN1YmplY3RccyosXHMqXCRNZXNzYWdlQm9keSI7aToxNTA7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxNTE7czo3ODoiIWZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRibmFtZVxzKixccypcJHRoaXMtPmdldEltYWdlRW5jb2RlZFRleHRcKFxzKlwkZGJuYW1lIjtpOjE1MjtzOjQ0OiJzY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aToxNTM7czo3Mjoic2VuZF9zbXRwXChccypcJGVtYWlsXFtbJyJdezAsMX1hZHJbJyJdezAsMX1cXVxzKixccypcJHN1YmpccyosXHMqXCR0ZXh0IjtpOjE1NDtzOjQ2OiI9XCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1NTtzOjUyOiJ0b3VjaFwoXHMqWyciXXswLDF9XCRiYXNlcGF0aC9jb21wb25lbnRzL2NvbV9jb250ZW50IjtpOjE1NjtzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTU3O3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjE1ODtzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjE1OTtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjE2MDtzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjE2MTtzOjEzOiI9YnlccytEUkFHT049IjtpOjE2MjtzOjk4OiJzdWJzdHJcKFxzKlwkc3RyaW5nMlxzKixccypzdHJsZW5cKFxzKlwkc3RyaW5nMlxzKlwpXHMqLVxzKjlccyosXHMqOVwpXHMqPT1ccypbJyJdezAsMX1cW2wscj0zMDJcXSI7aToxNjM7czozMzoiXFtcXVxzKj1ccypbJyJdUmV3cml0ZUVuZ2luZVxzK29uIjtpOjE2NDtzOjc1OiJmd3JpdGVcKFxzKlwkZlxzKixccypnZXRfZG93bmxvYWRcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTY1O3M6NDc6InRhclxzKy1jemZccysiXHMqXC5ccypcJEZPUk17dGFyfVxzKlwuXHMqIlwudGFyIjtpOjE2NjtzOjE0OiItQXBwbGVfUmVzdWx0LSI7aToxNjc7czoxMToic2NvcGJpblsnIl0iO2k6MTY4O3M6NjY6IjxkaXZccytpZD1bJyJdbGluazFbJyJdPjxidXR0b24gb25jbGljaz1bJyJdcHJvY2Vzc1RpbWVyXChcKTtbJyJdPiI7aToxNjk7czozNToiPGd1aWQ+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmwiO2k6MTcwO3M6NjI6ImludDMyXChcKFwoXCR6XHMqPj5ccyo1XHMqJlxzKjB4MDdmZmZmZmZcKVxzKlxeXHMqXCR5XHMqPDxccyoyIjtpOjE3MTtzOjQzOiJmb3BlblwoXHMqXCRyb290X2RpclxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE3MjtzOjIzOiJcJGluX1Blcm1zXHMrJlxzKzB4NDAwMCI7aToxNzM7czozNDoiZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0vdmFyL3RtcCI7aToxNzQ7czo5OiIvcG10L3Jhdi8iO2k6MTc1O3M6NDk6ImZ3cml0ZVwoXCRmcFxzKixccypzdHJyZXZcKFxzKlwkY29udGV4dFxzKlwpXHMqXCkiO2k6MTc2O3M6MjA6Ik1hc3JpXHMrQ3liZXJccytUZWFtIjtpOjE3NztzOjE4OiJVczNccytZMHVyXHMrYnI0MW4iO2k6MTc4O3M6MjA6Ik1hc3IxXHMrQ3liM3JccytUZTRtIjtpOjE3OTtzOjIwOiJ0SEFOS3Nccyt0T1xzK1Nub3BweSI7aToxODA7czoxMzoiQU9MXHMrRGV0YWlscyI7aToxODE7czo2NjoiLFxzKlsnIl0vaW5kZXhcXFwuXChwaHBcfGh0bWxcKS9pWyciXVxzKixccypSZWN1cnNpdmVSZWdleEl0ZXJhdG9yIjtpOjE4MjtzOjQ3OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aToxODM7czo1NToiZ2V0cHJvdG9ieW5hbWVcKFxzKlsnIl10Y3BbJyJdXHMqXClccytcfFx8XHMrZGllXHMrc2hpdCI7aToxODQ7czo3NjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1jZFxzKy90bXA7d2dldCI7aToxODU7czoyMjoiPGFccytocmVmPVsnIl1vc2hpYmthLSI7aToxODY7czo4NToiaWZcKFxzKlwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIT1ccypbJyJdWyciXVxzKlwpXHMqXCRpZD1cJF9HRVRcW1xzKlsnIl1pZFsnIl1ccypcXSI7aToxODc7czo4MzoiaWZcKFsnIl1zdWJzdHJfY291bnRcKFsnIl1cJF9TRVJWRVJcW1snIl1SRVFVRVNUX1VSSVsnIl1cXVxzKixccypbJyJdcXVlcnlcLnBocFsnIl0iO2k6MTg4O3M6Mzg6IlwkZmlsbCA9IFwkX0NPT0tJRVxbXFxbJyJdZmlsbFxcWyciXVxdIjtpOjE4OTtzOjYyOiJcJHJlc3VsdD1zbWFydENvcHlcKFxzKlwkc291cmNlXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkZmlsZSI7aToxOTA7czo0MDoiXCRiYW5uZWRJUFxzKj1ccyphcnJheVwoXHMqWyciXVxeNjZcLjEwMiI7aToxOTE7czozNToiPGxvYz48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybDsiO2k6MTkyO3M6Mjg6Ilwkc2V0Y29va1wpO3NldGNvb2tpZVwoXCRzZXQiO2k6MTkzO3M6Mjg6IlwpO2Z1bmN0aW9uXHMrc3RyaW5nX2NwdFwoXCQiO2k6MTk0O3M6NTA6IlsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdIjtpOjE5NTtzOjUzOiJpZlwocHJlZ19tYXRjaFwoWyciXVwjd29yZHByZXNzX2xvZ2dlZF9pblx8YWRtaW5cfHB3ZCI7aToxOTY7czo0MToiZ19kZWxldGVfb25fZXhpdFxzKj1ccypuZXdccytEZWxldGVPbkV4aXQiO2k6MTk3O3M6MzA6IlNFTEVDVFxzK1wqXHMrRlJPTVxzK2Rvcl9wYWdlcyI7aToxOTg7czoxODoiQWNhZGVtaWNvXHMrUmVzdWx0IjtpOjE5OTtzOjc1OiJ2YWx1ZT1bJyJdPFw/XHMrKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl0iO2k6MjAwO3M6Mjc6IlxkKyZAcHJlZ19tYXRjaFwoXHMqc3RydHJcKCI7aToyMDE7czozODoiY2hyXChccypoZXhkZWNcKFxzKnN1YnN0clwoXHMqXCRtYWtldXAiO2k6MjAyO3M6MzA6InJlYWRfZmlsZV9uZXdfMlwoXCRyZXN1bHRfcGF0aCI7aToyMDM7czoyMzoiXCRpbmRleF9wYXRoXHMqLFxzKjA0MDQiO2k6MjA0O3M6Njc6IlwkZmlsZV9mb3JfdG91Y2hccyo9XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6MjA1O3M6NjE6IlwkX1NFUlZFUlxbWyciXXswLDF9UkVNT1RFX0FERFJbJyJdezAsMX1cXTtpZlwoXChwcmVnX21hdGNoXCgiO2k6MjA2O3M6MTk6Ij09XHMqWyciXWNzaGVsbFsnIl0iO2k6MjA3O3M6Mjk6ImZpbGVfZXhpc3RzXChccypcJEZpbGVCYXphVFhUIjtpOjIwODtzOjE4OiJyZXN1bHRzaWduX3dhcm5pbmciO2k6MjA5O3M6MjQ6ImZ1bmN0aW9uXHMrZ2V0Zmlyc3RzaHRhZyI7aToyMTA7czo5MDoiZmlsZV9nZXRfY29udGVudHNcKFJPT1RfRElSXC5bJyJdL3RlbXBsYXRlcy9bJyJdXC5cJGNvbmZpZ1xbWyciXXNraW5bJyJdXF1cLlsnIl0vbWFpblwudHBsIjtpOjIxMTtzOjI1OiJuZXdccytjb25lY3RCYXNlXChbJyJdYUhSIjtpOjIxMjtzOjgzOiJcJGlkXHMqXC5ccypbJyJdXD9kPVsnIl1ccypcLlxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfVVNFUl9BR0VOVCI7aToyMTM7czoyOToiZG9fd29ya1woXHMqXCRpbmRleF9maWxlXHMqXCkiO2k6MjE0O3M6NDE6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjIxNTtzOjIwOiJoZWFkZXJccypcKFxzKl9cZCtcKCI7aToyMTY7czoxMjoiQnlccytXZWJSb29UIjtpOjIxNztzOjE2OiJDb2RlZFxzK2J5XHMrRVhFIjtpOjIxODtzOjcxOiJ0cmltXChccypcJGhlYWRlcnNccypcKVxzKlwpXHMqYXNccypcJGhlYWRlclxzKlwpXHMqaGVhZGVyXChccypcJGhlYWRlciI7aToyMTk7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6MjIwO3M6ODE6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aToyMjE7czo2OToidG91Y2hcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjIyMjtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjIyMztzOjI2OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXSs/YCI7aToyMjQ7czoyMToiJl9TRVNTSU9OXFtwYXlsb2FkXF09IjtpOjIyNTtzOjQ3OiJnenVuY29tcHJlc3NcKFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdaHR0cCI7aToyMjY7czo4NDoiaWZcKFxzKiFlbXB0eVwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9dHAyWyciXXswLDF9XHMqXF1cKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjIyNztzOjQ5OiJpZlwoXHMqdHJ1ZVxzKiZccypAcHJlZ19tYXRjaFwoXHMqc3RydHJcKFxzKlsnIl0vIjtpOjIyODtzOjM4OiI9PVxzKjBcKVxzKntccyplY2hvXHMqUEhQX09TXHMqXC5ccypcJCI7aToyMjk7czoxMDc6Imlzc2V0XChccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxzKlxkK1xzKlwpXHMqXF1ccypcKVxzKlw/XHMqXCRfU0VSVkVSXFtccypfXGQrXChcZCtcKVxzKlxdXHMqOlxzKl9cZCtcKFxkK1wpIjtpOjIzMDtzOjk5OiJcJGluZGV4XHMqPVxzKnN0cl9yZXBsYWNlXChccypbJyJdPFw/cGhwXHMqb2JfZW5kX2ZsdXNoXChcKTtccypcPz5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkaW5kZXgiO2k6MjMxO3M6MzM6Ilwkc3RhdHVzX2xvY19zaFxzKj1ccypmaWxlX2V4aXN0cyI7aToyMzI7czo0ODoiXCRQT1NUX1NUUlxzKj1ccypmaWxlX2dldF9jb250ZW50c1woInBocDovL2lucHV0IjtpOjIzMztzOjQ4OiJnZVxzKj1ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkX1BPU1RccypcW1snIl1tZXMiO2k6MjM0O3M6NjY6IlwkdGFibGVcW1wkc3RyaW5nXFtcJGlcXVxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjJcKVxzKlwrXHMqXCR0YWJsZSI7aToyMzU7czozMzoiaWZcKFxzKnN0cmlwb3NcKFxzKlsnIl1cKlwqXCpcJHVhIjtpOjIzNjtzOjQ5OiJmbHVzaF9lbmRfZmlsZVwoXHMqXCRmaWxlbmFtZVxzKixccypcJGZpbGVjb250ZW50IjtpOjIzNztzOjU2OiJwcmVnX21hdGNoXChccypbJyJdezAsMX1+TG9jYXRpb246XChcLlwqXD9cKVwoXD86XFxuXHxcJCI7aToyMzg7czoyODoidG91Y2hcKFxzKlwkdGhpcy0+Y29uZi0+cm9vdCI7aToyMzk7czozNzoiZXZhbFwoXHMqXCR7XHMqXCRbYS16QS1aMC05X10rP1xzKn1cWyI7aToyNDA7czo0MzoiaWZccypcKFxzKkBmaWxldHlwZVwoXCRsZWFkb25ccypcLlxzKlwkZmlsZSI7aToyNDE7czo1OToiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGlyXHMqXC5ccypcJGZpbGVccypcLlxzKlsnIl0vaW5kZXgiO2k6MjQyO3M6MjY6ImZpbGVzaXplXChccypcJHB1dF9rX2ZhaWx1IjtpOjI0MztzOjYwOiJhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdezAsMX1tZXNbJyJdXF0iO2k6MjQ0O3M6NDM6ImZ1bmN0aW9uXHMrZmluZEhlYWRlckxpbmVccypcKFxzKlwkdGVtcGxhdGUiO2k6MjQ1O3M6NDM6Ilwkc3RhdHVzX2NyZWF0ZV9nbG9iX2ZpbGVccyo9XHMqY3JlYXRlX2ZpbGUiO2k6MjQ2O3M6Mzg6ImVjaG9ccytzaG93X3F1ZXJ5X2Zvcm1cKFxzKlwkc3Fsc3RyaW5nIjtpOjI0NztzOjIyOiJmdW5jdGlvblxzK21haWxlcl9zcGFtIjtpOjI0ODtzOjM0OiJFZGl0SHRhY2Nlc3NcKFxzKlsnIl1SZXdyaXRlRW5naW5lIjtpOjI0OTtzOjExOiJcJHBhdGhUb0RvciI7aToyNTA7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aToyNTE7czo5OToiQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXChccypAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF1ccypcKVxzKlwpIjtpOjI1MjtzOjQwOiJoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vXCRwcFwub3JnIjtpOjI1MztzOjU3OiJcJFthLXpBLVowLTlfXSs/PVsnIl0vaG9tZS9bYS16QS1aMC05X10rPy9bYS16QS1aMC05X10rPy8iO2k6MjU0O3M6NDk6InJldHVyblxzK1snIl0vaG9tZS9bYS16QS1aMC05X10rPy9bYS16QS1aMC05X10rPy8iO2k6MjU1O3M6Mzk6IlsnIl13cC1bJyJdXHMqXC5ccypnZW5lcmF0ZVJhbmRvbVN0cmluZyI7aToyNTY7czo2ODoiXCRbYS16QS1aMC05X10rPz09WyciXWZlYXR1cmVkWyciXVxzKlwpXHMqXCl7XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGUiO2k6MjU3O3M6MTA4OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkanFccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF0iO2k6MjU4O3M6MjI6ImV4cGxvaXRccyo6OlwuPC90aXRsZT4iO2k6MjU5O3M6NDE6IlwkW2EtekEtWjAtOV9dKz89c3RyX3JlcGxhY2VcKFsnIl1cKmFcJFwqIjtpOjI2MDtzOjYyOiJjaHJcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKTtccyp9XHMqZXZhbFwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyNjE7czo0ODoiaWZcKFxzKmlzSW5TdHJpbmcxKlwoXCRbYS16QS1aMC05X10rPyxbJyJdZ29vZ2xlIjtpOjI2MjtzOjkzOiJcJHBwXHMqPVxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF0iO2k6MjYzO3M6NDk6ImZpbGVfcHV0X2NvbnRlbnRzXChESVJcLlsnIl0vWyciXVwuWyciXWluZGV4XC5waHAiO2k6MjY0O3M6Mjk6IkBnZXRfaGVhZGVyc1woXHMqXCRmdWxscGF0aFwpIjtpOjI2NTtzOjIxOiJAXCRfR0VUXFtbJyJdcHdbJyJdXF0iO2k6MjY2O3M6MjU6Impzb25fZW5jb2RlXChhbGV4dXNNYWlsZXIiO2k6MjY3O3M6MTU1OiJldmFsXChccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aToyNjg7czoxOToiPVsnIl1cKVwpO1snIl1cKVwpOyI7aToyNjk7czoxNjg6Ij1ccypcJFthLXpBLVowLTlfXSs/XCgoZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aToyNzA7czo1NToiXF1ccyp9XHMqXChccyp7XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyNzE7czo3NzoicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChccypbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxzKlwpXHMqLFxzKlsnIl1Hb29nbGVib3QiO2k6MjcyO3M6NDg6ImV2YWxcKFsnIl1cPz5bJyJdXHMqXC5ccypqb2luXChbJyJdWyciXSxmaWxlXChcJCI7aToyNzM7czo2ODoic2V0b3B0XChcJGNoXHMqLFxzKkNVUkxPUFRfUE9TVEZJRUxEU1xzKixccypodHRwX2J1aWxkX3F1ZXJ5XChcJGRhdGEiO2k6Mjc0O3M6MTE4OiJteXNxbF9jb25uZWN0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI3NTtzOjE5ODoiXGIocGVyY29jZXR8YWRkZXJhbGx8dmlhZ3JhfGNpYWxpc3xsZXZpdHJhfGthdWZlbnxhbWJpZW58Ymx1ZVxzK3BpbGx8Y29jYWluZXxtYXJpanVhbmF8bGlwaXRvcnxwaGVudGVybWlufHByb1tzel1hY3xzYW5keWF1ZXJ8dHJhbWFkb2x8dHJveWhhbWJ5dWx0cmFtfHVuaWNhdWNhfHZhbGl1bXx2aWNvZGlufHhhbmF4fHlweGFpZW8pXHMrb25saW5lIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NTk6e2k6MDtzOjE0OiJCT1RORVRccytQQU5FTCI7aToxO3M6MTU6IlsnIl0vZXRjL3Bhc3N3ZCI7aToyO3M6MTU6IlsnIl0vdmFyL2NwYW5lbCI7aTozO3M6MTQ6IlsnIl0vZXRjL2h0dHBkIjtpOjQ7czoyMDoiWyciXS9ldGMvbmFtZWRcLmNvbmYiO2k6NTtzOjYzOiJcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1JFRkVSRVJbJyJdXHMqXF1ccyosXHMqWyciXXRydXN0bGlua1wucnUiO2k6NjtzOjEzOiI4OVwuMjQ5XC4yMVwuIjtpOjc7czoxNToiMTA5XC4yMzhcLjI0MlwuIjtpOjg7czoxODoiPT1ccypbJyJdNDZcLjIyOVwuIjtpOjk7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjEwO3M6NToiSlRlcm0iO2k6MTE7czo1OiJPbmV0NyI7aToxMjtzOjk6IlwkcGFzc191cCI7aToxMztzOjU6InhDZWR6IjtpOjE0O3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjE1O3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTAyMDAwIjtpOjE2O3M6NDU6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1uYW1lXHMrXC5odHBhc3N3ZCI7aToxNztzOjI4OiJhbmRyb2lkXHxhdmFudGdvXHxibGFja2JlcnJ5IjtpOjE4O3M6Mzc6ImluaV9zZXRcKFxzKlsnIl17MCwxfW1hZ2ljX3F1b3Rlc19ncGMiO2k6MTk7czoxMjoiWyciXWxzXHMrLWxhIjtpOjIwO3M6NTE6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFxzKlsnIl17MCwxfSUzQyI7aToyMTtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyMjtzOjg5OiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyMztzOjYzOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXWltYWdlcy8iO2k6MjQ7czo2OToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKEAqdXJsZW5jb2RlIjtpOjI1O3M6MTI6IlsnIl1ybVxzKy1yZiI7aToyNjtzOjEyOiJbJyJdcm1ccystZnIiO2k6Mjc7czoxNjoiWyciXXJtXHMrLXJccystZiI7aToyODtzOjE2OiJbJyJdcm1ccystZlxzKy1yIjtpOjI5O3M6Mjc6IlwkT09PLis/PVxzKnVybGRlY29kZVxzKlwoKiI7aTozMDtzOjY5OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoKlsnIl1jZFxzKy90bXAiO2k6MzE7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6MzI7czoxNToicGNudGxfZXhlY1xzKlwoIjtpOjMzO3M6MTA6IlsnIl1hSFIwY0QiO2k6MzQ7czo4MToiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfXJlZnJlc2hbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfVxkKztccyp1cmw9PFw/cGhwIjtpOjM1O3M6ODI6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1SZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MzY7czoyMzoiY29weVxzKlwoXHMqWyciXWh0dHA6Ly8iO2k6Mzc7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoKlxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6Mzg7czoyODoiZWNob1xzKlwoKlxzKlsnIl1OTyBGSUxFWyciXSI7aTozOTtzOjE1OiJbJyJdL1wuXCovZVsnIl0iO2k6NDA7czo0NDg6IihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6NDE7czo2NDoiZWNob1xzK3N0cmlwc2xhc2hlc1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0MjtzOjY0OiI9XHMqXCRHTE9CQUxTXFtccypbJyJdXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXVxzKlxdIjtpOjQzO3M6MTU6IlwkYXV0aF9wYXNzXHMqPSI7aTo0NDtzOjUxOiJDVVJMT1BUX1JFRkVSRVIsXHMqWyciXXswLDF9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY28iO2k6NDU7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6NDY7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aTo0NztzOjI4OiJDcmVkaXRccypDYXJkXHMqVmVyaWZpY2F0aW9uIjtpOjQ4O3M6MzU6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWV2YWxbJyJdIjtpOjQ5O3M6NDQ6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjUwO3M6NDY6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTE7czozNzoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdYXNzZXJ0WyciXSI7aTo1MjtzOjQzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1wcmVnX3JlcGxhY2VbJyJdIjtpOjUzO3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6NTQ7czo0NToiTW96aWxsYS81XC4wXHMqXChjb21wYXRpYmxlO1xzKkdvb2dsZWJvdC8yXC4xIjtpOjU1O3M6ODQ6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbWyciXXRtcF9uYW1lWyciXVxdXHMqLCI7aTo1NjtzOjgxOiJtYWlsXChcJF9QT1NUXFtbJyJdezAsMX1lbWFpbFsnIl17MCwxfVxdLFxzKlwkX1BPU1RcW1snIl17MCwxfXN1YmplY3RbJyJdezAsMX1cXSwiO2k6NTc7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6NTg7czoxMzoiQGV4dHJhY3RccypcKCI7aTo1OTtzOjEzOiJAZXh0cmFjdFxzKlwkIjtpOjYwO3M6NjQ6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbYS16QS1aMC05X10rP1xzKlxdXCgiO2k6NjE7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTo2MjtzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo2MztzOjM2OiJYLU1haWxlcjpccypNaWNyb3NvZnQgT2ZmaWNlIE91dGxvb2siO2k6NjQ7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aTo2NTtzOjk6IlwkYlwoWyciXSI7aTo2NjtzOjQyOiI9XHMqY3JlYXRlX2Z1bmN0aW9uXChbJyJdezAsMX1cJGFbJyJdezAsMX0iO2k6Njc7czo2NjoiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1woIjtpOjY4O3M6MjIyOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6Njk7czoxNTU6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlwkW2EtekEtWjAtOV9dKz9ccypcXVxbXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuIjtpOjcwO3M6MjE6ImRpc2FibGVfZnVuY3Rpb25zXHMqPSI7aTo3MTtzOjM4OiJAbW92ZV91cGxvYWRlZF9maWxlXChccypcJHVzZXJmaWxlX3RtcCI7aTo3MjtzOjI2OiJleGl0XChcKTpleGl0XChcKTpleGl0XChcKSI7aTo3MztzOjY1OiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS92YXIvdG1wLyI7aTo3NDtzOjE3OiI9XHMqWyciXS92YXIvdG1wLyI7aTo3NTtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTo3NjtzOjQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqXFsiO2k6Nzc7czo2NjoiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xbIjtpOjc4O3M6NTI6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlsnIl0iO2k6Nzk7czo3MzoiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqLCI7aTo4MDtzOjcxOiJcJFthLXpBLVowLTlfXSs/XHMqXChccypbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/XHMqXClccypcKSI7aTo4MTtzOjgxOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWx3cC1kb3dubG9hZFxzK2h0dHA6Ly8iO2k6ODI7czoxMjoiZG1sbGQwUmhkR0U9IjtpOjgzO3M6MTAxOiJzdHJfcmVwbGFjZVwoWyciXS5bJyJdXHMqLFxzKlsnIl0uWyciXVxzKixccypzdHJfcmVwbGFjZVwoWyciXS5bJyJdXHMqLFxzKlsnIl0uWyciXVxzKixccypzdHJfcmVwbGFjZSI7aTo4NDtzOjM2OiIvYWRtaW4vY29uZmlndXJhdGlvblwucGhwL2xvZ2luXC5waHAiO2k6ODU7czo3MToic2VsZWN0XHMqY29uZmlndXJhdGlvbl9pZCxccytjb25maWd1cmF0aW9uX3RpdGxlLFxzK2NvbmZpZ3VyYXRpb25fdmFsdWUiO2k6ODY7czo1MDoidXBkYXRlXHMqY29uZmlndXJhdGlvblxzK3NldFxzK2NvbmZpZ3VyYXRpb25fdmFsdWUiO2k6ODc7czozNzoic2VsZWN0XHMqbGFuZ3VhZ2VzX2lkLFxzK25hbWUsXHMrY29kZSI7aTo4ODtzOjUyOiJjXC5sZW5ndGhcKTt9cmV0dXJuXHMqXFxbJyJdXFxbJyJdO31pZlwoIWdldENvb2tpZVwoIjtpOjg5O3M6NTM6IlwkW2EtekEtWjAtOV9dKz8gPSBcJFthLXpBLVowLTlfXSs/XChbJyJdezAsMX1odHRwOi8vIjtpOjkwO3M6NDU6ImlmXChmaWxlX3B1dF9jb250ZW50c1woXCRpbmRleF9wYXRoLFxzKlwkY29kZSI7aTo5MTtzOjM2OiJleGVjXHMre1snIl0vYmluL3NoWyciXX1ccytbJyJdLWJhc2giO2k6OTI7czo1MDoiPGlmcmFtZVxzK3NyYz1bJyJdaHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS9mb3Jtcy8iO2k6OTM7czoyMjoiLFsnIl08XD9waHBcXG5bJyJdXC5cJCI7aTo5NDtzOjcwOiI8XD9waHBccysoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjk1O3M6MjI6InhydW1lcl9zcGFtX2xpbmtzXC50eHQiO2k6OTY7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjk3O3M6Nzc6ImFycmF5X21lcmdlXChcJGV4dFxzKixccyphcnJheVwoWyciXXdlYnN0YXRbJyJdLFsnIl1hd3N0YXRzWyciXSxbJyJddGVtcG9yYXJ5IjtpOjk4O3M6OTA6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbXlzcWxkdW1wXHMrLWhccytsb2NhbGhvc3RccystdSI7aTo5OTtzOjI4OiJNb3RoZXJbJyJdc1xzK01haWRlblxzK05hbWU6IjtpOjEwMDtzOjM5OiJsb2NhdGlvblwucmVwbGFjZVwoXFxbJyJdXCR1cmxfcmVkaXJlY3QiO2k6MTAxO3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aToxMDI7czo4MzoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWN1cmxccystT1xzK2h0dHA6Ly8iO2k6MTAzO3M6Mjk6IlwpXCksUEhQX1ZFUlNJT04sbWQ1X2ZpbGVcKFwkIjtpOjEwNDtzOjc5OiJcJFthLXpBLVowLTlfXSs/XFtcJFthLXpBLVowLTlfXSs/XF1cW1wkW2EtekEtWjAtOV9dKz9cW1xkK1xdXC5cJFthLXpBLVowLTlfXSs/IjtpOjEwNTtzOjM0OiJcJHF1ZXJ5XHMrLFxzK1snIl1mcm9tJTIwam9zX3VzZXJzIjtpOjEwNjtzOjE1OiJldmFsXChbJyJdXHMqLy8iO2k6MTA3O3M6MTY6ImV2YWxcKFsnIl1ccyovXCoiO2k6MTA4O3M6MTA5OiJcJFthLXpBLVowLTlfXSs/XHMqPVwkW2EtekEtWjAtOV9dKz9ccypcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwoWyciXVxzKntcJFthLXpBLVowLTlfXSs/IjtpOjEwOTtzOjMxOiIhZXJlZ1woWyciXVxeXCh1bnNhZmVfcmF3XClcP1wkIjtpOjExMDtzOjM1OiJcJGJhc2VfZG9tYWluXHMqPVxzKmdldF9iYXNlX2RvbWFpbiI7aToxMTE7czo5OiJzZXhzZXhzZXgiO2k6MTEyO3M6MjM6IlwrdW5pb25cK3NlbGVjdFwrMCwwLDAsIjtpOjExMztzOjM3OiJjb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhLHVzZXJuYW1lIjtpOjExNDtzOjM0OiJncm91cF9jb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhIjtpOjExNTtzOjU1OiJcKi9ccyooaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqL1wqIjtpOjExNjtzOjg6ImFiYWtvL0FPIjtpOjExNztzOjQ4OiJpZlwoXHMqc3RycG9zXChccypcJHZhbHVlXHMqLFxzKlwkbWFza1xzKlwpXHMqXCkiO2k6MTE4O3M6MTA2OiJ1bmxpbmtcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdezAsMX0vYXNzZXRzL2NhY2hlL3RlbXAvRmlsZVNldHRpbmdzIjtpOjExOTtzOjE0MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aToxMjA7czoxNDI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5naWYiO2k6MTIxO3M6MTQyOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wucG5nIjtpOjEyMjtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wucG5nIjtpOjEyMztzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuanBnIjtpOjEyNDtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuZ2lmIjtpOjEyNTtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuaWNvIjtpOjEyNjtzOjEwNjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aToxMjc7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MTI4O3M6NTA6Imh0dHA6Ly93d3dcLmJpbmdcLmNvbS9zZWFyY2hcP3E9XCRxdWVyeSZwcT1cJHF1ZXJ5IjtpOjEyOTtzOjQzOiJodHRwOi8vZ29cLm1haWxcLnJ1L3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5IjtpOjEzMDtzOjYzOiJodHRwOi8vd3d3XC5nb29nbGVcLmNvbS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeVwuWyciXSZobD1cJGxhbmciO2k6MTMxO3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MTMyO3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjEzMztzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aToxMzQ7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjEzNTtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MTM2O3M6NzY6IlxibWFpbFwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccyoiO2k6MTM3O3M6NDM6IlwkX1BPU1RcW1xzKlsnIl17MCwxfWVNYWlsQWRkWyciXXswLDF9XHMqXF0iO2k6MTM4O3M6Mjk6ImZvcGVuXChccypbJyJdXC5cLi9cLmh0YWNjZXNzIjtpOjEzOTtzOjI3OiJzdHJsZW5cKFxzKlwkcGF0aFRvRG9yXHMqXCkiO2k6MTQwO3M6NjQ6Imlzc2V0XChccypcJF9DT09LSUVcW1xzKm1kNVwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX0hPU1QiO2k6MTQxO3M6Mjc6IkBjaGRpclwoXHMqXCRfUE9TVFxbXHMqWyciXSI7aToxNDI7czo4NDoiL2luZGV4XC5waHBcP29wdGlvbj1jb21fY29udGVudCZ2aWV3PWFydGljbGUmaWQ9WyciXVwuXCRwb3N0XFtbJyJdezAsMX1pZFsnIl17MCwxfVxdIjtpOjE0MztzOjU1OiJcJG91dFxzKlwuPVxzKlwkdGV4dHtccypcJGlccyp9XHMqXF5ccypcJGtleXtccypcJGpccyp9IjtpOjE0NDtzOjk6IkwzWmhjaTkzZCI7aToxNDU7czo0Nzoic3RydG9sb3dlclwoXHMqc3Vic3RyXChccypcJHVzZXJfYWdlbnRccyosXHMqMCwiO2k6MTQ2O3M6NTI6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XHMqLFxzKjA0MDQiO2k6MTQ3O3M6NTI6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XHMqLFxzKjA3NTUiO2k6MTQ4O3M6NDI6IkB1bWFza1woXHMqMDc3N1xzKiZccyp+XHMqXCRmaWxlcGVybWlzc2lvbiI7aToxNDk7czoyMzoiWyciXVxzKlx8XHMqL2Jpbi9zaFsnIl0iO2k6MTUwO3M6MTY6IjtccyovYmluL3NoXHMqLWkiO2k6MTUxO3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjE1MjtzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6MTUzO3M6MTU6Ii90bXAvXC5JQ0UtdW5peCI7aToxNTQ7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6MTU1O3M6Mjc6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcyI7aToxNTY7czozMzoidG91Y2hccypcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fIjtpOjE1NztzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjE1ODtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MTU5O3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjE2MDtzOjc0OiJcJHJldCA9IFwkdGhpcy0+X2RiLT51cGRhdGVPYmplY3RcKCBcJHRoaXMtPl90YmwsIFwkdGhpcywgXCR0aGlzLT5fdGJsX2tleSI7aToxNjE7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToxNjI7czo1NDoic3Vic3RyXChccypcJHJlc3BvbnNlXHMqLFxzKlwkaW5mb1xbXHMqWyciXWhlYWRlcl9zaXplIjtpOjE2MztzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjE2NDtzOjUwOiI8aW5wdXRccyt0eXBlPXN1Ym1pdFxzK3ZhbHVlPVVwbG9hZFxzKi8+XHMqPC9mb3JtPiI7aToxNjU7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToxNjY7czo1NzoiQGVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKmlmXHMqXChccyohaXNzZXRccypcKFxzKlwkIjtpOjE2NztzOjQ0OiJccyo9XHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXSI7aToxNjg7czozMDoiZWxzZVxzKntccyplY2hvXHMqWyciXWZhaWxbJyJdIjtpOjE2OTtzOjUxOiJ0eXBlPVsnIl1zdWJtaXRbJyJdXHMqdmFsdWU9WyciXVVwbG9hZCBmaWxlWyciXVxzKj4iO2k6MTcwO3M6Mzc6ImhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlwkbGlua1snIl0iO2k6MTcxO3M6MzE6ImVjaG9ccypbJyJdPGI+VXBsb2FkPHNzPlN1Y2Nlc3MiO2k6MTcyO3M6NDM6Im5hbWU9WyciXXVwbG9hZGVyWyciXVxzK2lkPVsnIl11cGxvYWRlclsnIl0iO2k6MTczO3M6MjE6Ii1JL3Vzci9sb2NhbC9iYW5kbWFpbiI7aToxNzQ7czoyNDoidW5saW5rXChccypfX0ZJTEVfX1xzKlwpIjtpOjE3NTtzOjU2OiJtYWlsXChccypcJGFyclxbWyciXXRvWyciXVxdXHMqLFxzKlwkYXJyXFtbJyJdc3VialsnIl1cXSI7aToxNzY7czoxMzA6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXTtccypleGl0XChcKTsiO2k6MTc3O3M6MTM6Im51bGxfZXhwbG9pdHMiO2k6MTc4O3M6NDg6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKSI7aToxNzk7czo5OiJ0bXZhc3luZ3IiO2k6MTgwO3M6MTI6InRtaGFwYnpjZXJmZiI7aToxODE7czoxMzoib25mcjY0X3FycGJxciI7aToxODI7czoxNDoiWyciXW5mZnJlZ1snIl0iO2k6MTgzO3M6OToiZmdlX2ViZzEzIjtpOjE4NDtzOjc6ImN1Y3Zhc2IiO2k6MTg1O3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjE4NjtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTg3O3M6OToiZXRhbGZuaXpnIjtpOjE4ODtzOjEyOiJzc2VycG1vY251emciO2k6MTg5O3M6MTM6ImVkb2NlZF80NmVzYWIiO2k6MTkwO3M6MTQ6IlsnIl10cmVzc2FbJyJdIjtpOjE5MTtzOjE3OiJbJyJdMzF0b3JfcnRzWyciXSI7aToxOTI7czoxNToiWyciXW9mbmlwaHBbJyJdIjtpOjE5MztzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToxOTQ7czoxMjoiWyciXXJpbnlbJyJdIjtpOjE5NTtzOjQ0OiJAXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpOyI7aToxOTY7czo0ODoicGFyc2VfcXVlcnlfc3RyaW5nXChccypcJEVOVntccypbJyJdUVVFUllfU1RSSU5HIjtpOjE5NztzOjMxOiJldmFsXHMqXChccyptYl9jb252ZXJ0X2VuY29kaW5nIjtpOjE5ODtzOjI0OiJcKVxzKntccypwYXNzdGhydVwoXHMqXCQiO2k6MTk5O3M6MTU6IkhUVFBfQUNDRVBUX0FTRSI7aToyMDA7czoyMToiZnVuY3Rpb25ccypDdXJsQXR0YWNrIjtpOjIwMTtzOjE1OiJAc3lzdGVtXChccyoiXCQiO2k6MjAyO3M6MjM6ImVjaG9cKFxzKmh0bWxcKFxzKmFycmF5IjtpOjIwMztzOjU2OiJcJGNvZGU9WyciXSUxc2NyaXB0XHMqdHlwZT1cXFsnIl10ZXh0L2phdmFzY3JpcHRcXFsnIl0lMyI7aToyMDQ7czoyMjoiYXJyYXlcKFxzKlsnIl0lMWh0bWwlMyI7aToyMDU7czoxOToiYnVkYWtccyotXHMqZXhwbG9pdCI7aToyMDY7czo5MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKFxzKlsnIl1cJFthLXpBLVowLTlfXSs/WyciXVxzKlwpIjtpOjIwNztzOjk6IkdBR0FMPC9iPiI7aToyMDg7czozODoiZXhpdFwoWyciXTxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC4iO2k6MjA5O3M6Mzc6ImRpZVwoWyciXTxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC4iO2k6MjEwO3M6MzY6InNldF90aW1lX2xpbWl0XChccyppbnR2YWxcKFxzKlwkYXJndiI7aToyMTE7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MjEyO3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToyMTM7czo0MjoiY29ublxzKj1ccypodHRwbGliXC5IVFRQQ29ubmVjdGlvblwoXHMqdXJpIjtpOjIxNDtzOjM2OiJpZlxzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9Y2htb2Q3NzciO2k6MjE1O3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqeWFuZGV4IjtpOjIxNjtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKmdvb2dsZSI7aToyMTc7czoyNjoiPFw/XHMqZWNob1xzKlwkY29udGVudDtcPz4iO2k6MjE4O3M6ODY6IlwkdXJsXHMqXC49XHMqWyciXVw/W2EtekEtWjAtOV9dKz89WyciXVxzKlwuXHMqXCRfR0VUXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF07IjtpOjIxOTtzOjEwOToiY29weVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRfUE9TVCI7aToyMjA7czoxMTY6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1cW1snIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XF1cW1xzKlwkaVxzKlxdIjtpOjIyMTtzOjMyOiJkbnNfZ2V0X3JlY29yZFwoXHMqXCRkb21haW5ccypcLiI7aToyMjI7czozNDoiZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdZ2V0bXhyciI7aToyMjM7czoyNDoibnNsb29rdXBcLmV4ZVxzKi10eXBlPU1YIjtpOjIyNDtzOjEyOiJuZXdccypNQ3VybDsiO2k6MjI1O3M6NDQ6IlwkZmlsZV9kYXRhXHMqPVxzKlsnIl08c2NyaXB0XHMqc3JjPVsnIl1odHRwIjtpOjIyNjtzOjQwOiJmcHV0c1woXCRmcCxccypbJyJdSVA6XHMqXCRpcFxzKi1ccypEQVRFIjtpOjIyNztzOjI4OiJjaG1vZFwoXHMqX19ESVJfX1xzKixccyowNDAwIjtpOjIyODtzOjQwOiJDb2RlTWlycm9yXC5kZWZpbmVNSU1FXChccypbJyJddGV4dC9taXJjIjtpOjIyOTtzOjQzOiJcXVxzKlwpXHMqXC5ccypbJyJdXFxuXD8+WyciXVxzKlwpXHMqXClccyp7IjtpOjIzMDtzOjY3OiJcJGd6cFxzKj1ccypcJGJnekV4aXN0XHMqXD9ccypAZ3pvcGVuXChcJHRtcGZpbGUsXHMqWyciXXJiWyciXVxzKlwpIjtpOjIzMTtzOjc1OiJmdW5jdGlvbjxzcz5zbXRwX21haWxcKFwkdG9ccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZVxzKixccypcJGhlYWRlcnMiO2k6MjMyO3M6NjQ6IlwkX1BPU1RcW1snIl17MCwxfWFjdGlvblsnIl17MCwxfVxdXHMqPT1ccypbJyJdZ2V0X2FsbF9saW5rc1snIl0iO2k6MjMzO3M6Mzg6Ij1ccypnemluZmxhdGVcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkIjtpOjIzNDtzOjQxOiJjaG1vZFwoXCRmaWxlLT5nZXRQYXRobmFtZVwoXClccyosXHMqMDc3NyI7aToyMzU7czo2MzoiXCRfUE9TVFxbWyciXXswLDF9dHAyWyciXXswLDF9XF1ccypcKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjIzNjtzOjI0NToiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJFthLXpBLVowLTlfXSs/XChbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XChccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpXHMqXCkiO2k6MjM3O3M6MTEwOiJoZWFkZXJcKFxzKlsnIl1Db250ZW50LVR5cGU6XHMqaW1hZ2UvanBlZ1snIl1ccypcKTtccypyZWFkZmlsZVwoXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlwpO1xzKmV4aXRcKFxzKlwpOyI7aToyMzg7czozMToiPT5ccypAXCRmMlwoX19GSUxFX19ccyosXHMqXCRmMSI7aToyMzk7czo4NDoiZXZhbFwoXHMqW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCk7XHMqXD8+IjtpOjI0MDtzOjM3OiJpZlxzKlwoXHMqaXNfY3Jhd2xlcjFcKFxzKlwpXHMqXClccyp7IjtpOjI0MTtzOjQ4OiJcJGVjaG9fMVwuXCRlY2hvXzJcLlwkZWNob18zXC5cJGVjaG9fNFwuXCRlY2hvXzUiO2k6MjQyO3M6MzU6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypfX0ZJTEVfX1xzKlwpIjtpOjI0MztzOjgxOiJAKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKkB1cmxlbmNvZGVcKFxzKlwkX1BPU1QiO2k6MjQ0O3M6OTc6IlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcJEdMT0JBTFNcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbXGQrXF1cKHJvdW5kXChcZCtcKVwpXF0iO2k6MjQ1O3M6MjU6ImZ1bmN0aW9uXHMrZXJyb3JfNDA0XChcKXsiO2k6MjQ2O3M6NjY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcGVybCI7aToyNDc7czo2ODoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1weXRob24iO2k6MjQ4O3M6NzQ6ImlmXHMqXChpc3NldFwoXCRfR0VUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwpXHMqe1xzKmVjaG9ccypbJyJdb2tbJyJdIjtpOjI0OTtzOjM5OiJyZWxwYXRodG9hYnNwYXRoXChccypcJF9HRVRcW1xzKlsnIl1jcHkiO2k6MjUwO3M6Mjc6IiE9XHMqWyciXWluZm9ybWF0aW9uX3NjaGVtYSI7aToyNTE7czo0NjoiaHR0cDovLy4rPy8uKz9cLnBocFw/YT1cZCsmYz1bYS16QS1aMC05X10rPyZzPSI7aToyNTI7czoxNTA6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXVwkW2EtekEtWjAtOV9dKz89QFthLXpBLVowLTlfXSs/XChbJyJdLis/WyciXVwpO1thLXpBLVowLTlfXSs/XCghXCRbYS16QS1aMC05X10rP1wpe1wkW2EtekEtWjAtOV9dKz89QFthLXpBLVowLTlfXSs/XChccypcKSI7aToyNTM7czoxNjoiZnVuY3Rpb25ccyt3c29FeCI7aToyNTQ7czo1MToiZm9yZWFjaFwoXHMqXCR0b3Nccyphc1xzKlwkdG9cKVxzKntccyptYWlsXChccypcJHRvIjtpOjI1NTtzOjEwMjoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFsnIl1odHRwOi8vLis/XC5qcGdbJyJdXCk7XHMqZXhpdFwoXCk7IjtpOjI1NjtzOjEyOiI8XD89XCRjbGFzczsiO2k6MjU3O3M6NTA6IjxpbnB1dFxzKnR5cGU9ImZpbGUiXHMqc2l6ZT0iXGQrIlxzKm5hbWU9InVwbG9hZCI+IjtpOjI1ODtzOjExMDoiXCRtZXNzYWdlc1xbXF1ccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXVzZXJmaWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXVxbXHMqXCRpXHMqXF0iO2k6MjU5O3M6NTU6IjxpbnB1dFxzKnR5cGU9WyciXWZpbGVbJyJdXHMqbmFtZT1bJyJddXNlcmZpbGVbJyJdXHMqLz4iO2k6MjYwO3M6MTM6IkRldmFydFxzK0hUVFAiO2k6MjYxO3M6OTA6IkBcJHtccypbYS16QS1aMC05X10rP1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXSs/XHMqfVwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyNjI7czo5NToiXCRHTE9CQUxTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcJFthLXpBLVowLTlfXSs/XF0iO2k6MjYzO3M6NTM6ImVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjI2NDtzOjYwOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccyouXHMqXGQrXHMqXF1cKFxzKlthLXpBLVowLTlfXSs/XCgiO2k6MjY1O3M6MTI0OiJcJFthLXpBLVowLTlfXSs/PVsnIl1odHRwOi8vLis/WyciXTtccypcJFthLXpBLVowLTlfXSs/PWZvcGVuXChcJFthLXpBLVowLTlfXSs/LFsnIl1yWyciXVwpO1xzKnJlYWRmaWxlXChcJFthLXpBLVowLTlfXSs/XCk7IjtpOjI2NjtzOjc1OiJhcnJheVwoXHMqWyciXTwhLS1bJyJdXHMqXC5ccyptZDVcKFxzKlwkcmVxdWVzdF91cmxccypcLlxzKnJhbmRcKFxkKyxccypcZCsiO2k6MjY3O3M6MTQ6Indzb0hlYWRlclxzKlwoIjtpOjI2ODtzOjY5OiJlY2hvXChbJyJdPGZvcm0gbWV0aG9kPVsnIl1wb3N0WyciXVxzKmVuY3R5cGU9WyciXW11bHRpcGFydC9mb3JtLWRhdGEiO2k6MjY5O3M6NDM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8iO2k6MjcwO3M6NTg6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjcxO3M6NDA6Im1haWxcKFwkdG9ccyosXHMqWyciXS4rP1snIl1ccyosXHMqXCR1cmwiO2k6MjcyO3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToyNzM7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6Mjc0O3M6Mzg6ImVsc2VpZlwoXHMqXCRzcWx0eXBlXHMqPT1ccypbJyJdc3FsaXRlIjtpOjI3NTtzOjM1OiI9PVxzKkZBTFNFXHMqXD9ccypcZCtccyo6XHMqaXAybG9uZyI7aToyNzY7czoxOToiPVsnIl1cKVxzKlwpO1xzKlw/PiI7aToyNzc7czoyNDoiZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkIjtpOjI3ODtzOjUyOiJcI1thLXpBLVowLTlfXSs/XCMuKz88L3NjcmlwdD4uKz9cIy9bYS16QS1aMC05X10rP1wjIjtpOjI3OTtzOjM0OiJmdW5jdGlvblxzK19fZmlsZV9nZXRfdXJsX2NvbnRlbnRzIjtpOjI4MDtzOjI1OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/IjtpOjI4MTtzOjU1OiJcJGZccyo9XHMqXCRmXGQrXChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/IjtpOjI4MjtzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToyODM7czoyOToiQ1VSTE9QVF9VUkxccyosXHMqWyciXXNtdHA6Ly8iO2k6Mjg0O3M6Nzc6IjxoZWFkPlxzKjxzY3JpcHQ+XHMqd2luZG93XC50b3BcLmxvY2F0aW9uXC5ocmVmPVsnIl0uKz9ccyo8L3NjcmlwdD5ccyo8L2hlYWQ+IjtpOjI4NTtzOjcyOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZvcGVuXChccypbJyJdW2EtekEtWjAtOV9dKz9cLnBocFsnIl1ccyosXHMqWyciXXciO2k6Mjg2O3M6MTY6IkBhc3NlcnRcKFxzKlsnIl0iO2k6Mjg3O3M6ODM6IlwkW2EtekEtWjAtOV9dKz89XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1kb1snIl1ccypcXTtccyppbmNsdWRlIjtpOjI4ODtzOjc5OiJlY2hvXHMrXCRbYS16QS1aMC05X10rPztta2RpclwoXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlwpO2ZpbGVfcHV0X2NvbnRlbnRzIjtpOjI4OTtzOjYxOiJcJGZyb21ccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1mcm9tIjtpOjI5MDtzOjE5OiI9XHMqeGRpclwoXHMqXCRwYXRoIjtpOjI5MTtzOjMxOiJcJF9bYS16QS1aMC05X10rP1woXHMqXCk7XHMqXD8+IjtpOjI5MjtzOjEwOiJ0YXJccystemNDIjtpOjI5MztzOjgzOiJlY2hvXHMrc3RyX3JlcGxhY2VcKFxzKlsnIl1cW1BIUF9TRUxGXF1bJyJdXHMqLFxzKmJhc2VuYW1lXChcJF9TRVJWRVJcW1snIl1QSFBfU0VMRiI7aToyOTQ7czo0MToiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkW2EtekEtWjAtOV9dKz8iO2k6Mjk1O3M6NDA6IlwkY3VyX2NhdF9pZFxzKj1ccypcKFxzKmlzc2V0XChccypcJF9HRVQiO2k6Mjk2O3M6MzU6ImhyZWY9WyciXTxcP3BocFxzK2VjaG9ccytcJGN1cl9wYXRoIjtpOjI5NztzOjMzOiI9XHMqZXNjX3VybFwoXHMqc2l0ZV91cmxcKFxzKlsnIl0iO2k6Mjk4O3M6ODU6Il5ccyo8XD9waHBccypoZWFkZXJcKFxzKlsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypbJyJdXHMqaHR0cDovLy4rP1snIl1ccypcKTtccypcPz4iO2k6Mjk5O3M6MTQ6Ijx0aXRsZT5ccyppdm56IjtpOjMwMDtzOjYzOiJeXHMqPFw/cGhwXHMqaGVhZGVyXChbJyJdTG9jYXRpb246XHMqaHR0cDovLy4rP1snIl1ccypcKTtccypcPz4iO2k6MzAxO3M6NjE6ImdldF91c2Vyc1woXHMqYXJyYXlcKFxzKlsnIl1yb2xlWyciXVxzKj0+XHMqWyciXWFkbWluaXN0cmF0b3IiO2k6MzAyO3M6NjU6IlwkdG9ccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl10b19hZGRyZXNzIjtpOjMwMztzOjE5OiJpbWFwX2hlYWRlcmluZm9cKFwkIjtpOjMwNDtzOjU4OiJcJFthLXpBLVowLTlfXSs/XFtccypfW2EtekEtWjAtOV9dKz9cKFxzKlxkK1xzKlwpXHMqXF1ccyo9IjtpOjMwNTtzOjM0OiJldmFsXChccypbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoIjtpOjMwNjtzOjM1OiJiZWdpblxzK21vZDpccytUaGFua3Nccytmb3Jccytwb3N0cyI7aTozMDc7czo5MzoiXCRbYS16QS1aMC05X10rPz1bJyJdW2EtekEtWjAtOVwrXD1fXStbJyJdO1xzKmVjaG9ccytiYXNlNjRfZGVjb2RlXChcJFthLXpBLVowLTlfXSs/XCk7XHMqXD8+IjtpOjMwODtzOjYzOiJcJFthLXpBLVowLTlfXSs/LT5fc2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MzA5O3M6MzI6IlsnIl1ccypcXlxzKlwkW2EtekEtWjAtOV9dKz9ccyo7IjtpOjMxMDtzOjY4OiJcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXF5ccypcJFthLXpBLVowLTlfXSs/XHMqOyI7aTozMTE7czoxMjI6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClccyomJlxzKm1kNVwoXCRfUkVRVUVTVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdIjtpOjMxMjtzOjEyOiJcLnd3dy8vOnB0dGgiO2k6MzEzO3M6NjM6IiU2MyU3MiU2OSU3MCU3NCUyRSU3MyU3MiU2MyUzRCUyNyU2OCU3NCU3NCU3MCUzQSUyRiUyRiU3MyU2RiU2MSI7aTozMTQ7czoyNzoid3Atb3B0aW9uc1wucGhwXHMqPlxzKkVycm9yIjtpOjMxNTtzOjg5OiJzdHJfcmVwbGFjZVwoYXJyYXlcKFsnIl1maWx0ZXJTdGFydFsnIl0sWyciXWZpbHRlckVuZFsnIl1cKSxccyphcnJheVwoWyciXVwqL1snIl0sWyciXS9cKiI7aTozMTY7czozNzoiZmlsZV9nZXRfY29udGVudHNcKF9fRklMRV9fXCksXCRtYXRjaCI7aTozMTc7czozMDoidG91Y2hcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fIjtpOjMxODtzOjE1OiJbJyJdXClcKVwpOyJcKTsiO2k6MzE5O3M6MjE6Ilx8Ym90XHxzcGlkZXJcfHdnZXQvaSI7aTozMjA7czoxNDoiIS91c3IvYmluL3BlcmwiO2k6MzIxO3M6NjM6InN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl0sW2EtekEtWjAtOV9dKz9cLlsnIl08L2JvZHk+WyciXSxcJCI7aTozMjI7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aTozMjM7czo5MjoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXCkiO2k6MzI0O3M6MjExOiI9XHMqbWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjMyNTtzOjE1NjoiPVxzKm1haWxcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjMyNjtzOjE0OiJMaWJYbWwySXNCdWdneSI7aTozMjc7czo0NjoiQGVycm9yX3JlcG9ydGluZ1woMFwpO1xzKkBzZXRfdGltZV9saW1pdFwoMFwpOyI7aTozMjg7czo5OiJtYWFmXHMreWEiO2k6MzI5O3M6MzU6ImVjaG8gW2EtekEtWjAtOV9dKz9ccypcKFsnIl1odHRwOi8vIjtpOjMzMDtzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6MzMxO3M6MTI6ImBjaGVja3N1ZXhlYyI7aTozMzI7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjMzMztzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6MzM0O3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aTozMzU7czozNzoiPVxzKlsnIl1waHBfdmFsdWVccythdXRvX3ByZXBlbmRfZmlsZSI7aTozMzY7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MzM3O3M6NDc6ImZvcGVuXChccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL3dwLWFkbWluIjtpOjMzODtzOjIyOiJyZXR1cm5ccypbJyJdL3Zhci93d3cvIjtpOjMzOTtzOjY1OiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS92YXIvd3d3LyI7aTozNDA7czo2MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vaG9tZS8iO2k6MzQxO3M6MjA5OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF07XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccyphcnJheVwoXHMqXCRfUkVRVUVTVFxbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlfZmlsdGVyXChccypcJCI7aTozNDI7czoxOTI6IlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLiI7aTozNDM7czoxNjoidGFncy9cJDYvXCQ0L1wkNyI7aTozNDQ7czozMDoic3RyX3JlcGxhY2VcKFxzKlsnIl1cLmh0YWNjZXNzIjtpOjM0NTtzOjQ0OiJmdW5jdGlvblxzK19cZCtcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKXtcJCI7aTozNDY7czoyMToiZXhwbG9kZVwoXFxbJyJdO3RleHQ7IjtpOjM0NztzOjEyNjoic3Vic3RyXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlxkK1xzKixccypcZCtccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnByZWdfcmVwbGFjZVwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypzdHJ0clwoIjtpOjM0ODtzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6MzQ5O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTozNTA7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aTozNTE7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6MzUyO3M6MTU6Ik11c3RAZkBccytTaGVsbCI7aTozNTM7czo2NzoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rPyI7aTozNTQ7czozNDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aTozNTU7czo0MDoic3RyX3JlcGxhY2VcKFsnIl1cLmh0YWNjZXNzWyciXVxzKixccypcJCI7aTozNTY7czozMzoiPVxzKkAqZ3ppbmZsYXRlXChccypzdHJyZXZcKFxzKlwkIjtpOjM1NztzOjIyOiJnXChccypbJyJdRmlsZXNNYW5bJyJdIjtpOjM1ODtzOjExNzoiXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1cKFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwpIjtpOjM1OTtzOjMzOiJcJFthLXpBLVowLTlfXSs/XChccypAXCRfQ09PS0lFXFsiO2k6MzYwO3M6MTMzOiJcJFthLXpBLVowLTlfXSs/XHMqXC49XHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9IjtpOjM2MTtzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTozNjI7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTozNjM7czoyODoic3RyX3JlcGxhY2VcKFsnIl0vXD9hbmRyWyciXSI7aTozNjQ7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjM2NTtzOjU1OiJpZlxzKlwoXHMqXCR0aGlzLT5pdGVtLT5oaXRzXHMqPj1bJyJdXGQrWyciXVwpXHMqe1xzKlwkIjtpOjM2NjtzOjQ3OiJleHBsb2RlXChbJyJdXFxuWyciXSxccypcJF9QT1NUXFtbJyJddXJsc1snIl1cXSI7aTozNjc7czoxMTY6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rP1wpIjtpOjM2ODtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6MzY5O3M6MjI6InJ1bmtpdF9mdW5jdGlvbl9yZW5hbWUiO2k6MzcwO3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjM3MTtzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6MzcyO3M6NzA6IlwkZG9jXHMqPVxzKkpGYWN0b3J5OjpnZXREb2N1bWVudFwoXCk7XHMqXCRkb2MtPmFkZFNjcmlwdFwoWyciXWh0dHA6Ly8iO2k6MzczO3M6MzA6IlwkZGVmYXVsdF91c2VfYWpheFxzKj1ccyp0cnVlOyI7aTozNzQ7czoxMDoiZGVrY2FoWyciXSI7aTozNzU7czoyMzoic3Vic3RyXChtZDVcKHN0cnJldlwoXCQiO2k6Mzc2O3M6MTM6Ij09WyciXVwpXHMqXC4iO2k6Mzc3O3M6MTA1OiJpZlxzKlwoXHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cnJwb3NcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6Mzc4O3M6MTU2OiJcJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rPywiO2k6Mzc5O3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTozODA7czo0OToiQCpmaWxlX2dldF9jb250ZW50c1woQCpiYXNlNjRfZGVjb2RlXChAKnVybGRlY29kZSI7aTozODE7czoyNjoiXCR7W2EtekEtWjAtOV9dKz99XChccypcKTsiO2k6MzgyO3M6NjA6InN1YnN0clwoc3ByaW50ZlwoWyciXSVvWyciXSxccypmaWxlcGVybXNcKFwkZmlsZVwpXCksXHMqLTRcKSI7aTozODM7czo1NzoiXCRbYS16QS1aMC05X10rP1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1wpIjtpOjM4NDtzOjE2OiJ3c29TZWNQYXJhbVxzKlwoIjtpOjM4NTtzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6Mzg2O3M6Njg6ImNvcHlcKFxzKlsnIl1odHRwOi8vLis/XC50eHRbJyJdXHMqLFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVwpIjtpOjM4NztzOjI4OiJcJHNldGNvb2tccypcKTtzZXRjb29raWVcKFwkIjtpOjM4ODtzOjQ1MzoiQCooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChAKihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjM4OTtzOjQxOiJcLlxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkaW5qZWN0XHMqXClccypcLiI7aTozOTA7czoyNjoiKFwuY2hyXChccypcZCtccypcKVwuKXs0LH0iO2k6MzkxO3M6NDI6Ij1ccypAKmZzb2Nrb3BlblwoXHMqXCRhcmd2XFtcZCtcXVxzKixccyo4MCI7aTozOTI7czozNToiXC5cLi9cLlwuL2VuZ2luZS9kYXRhL2RiY29uZmlnXC5waHAiO2k6MzkzO3M6ODU6InJlY3Vyc2VfY29weVwoXHMqXCRzcmNccyosXHMqXCRkc3RccypcKTtccypoZWFkZXJcKFxzKlsnIl1sb2NhdGlvbjpccypcJGRzdFsnIl1ccypcKTsiO2k6Mzk0O3M6MTc6IkdhbnRlbmdlcnNccytDcmV3IjtpOjM5NTtzOjE0NToiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVxzKlthLXpBLVowLTlfXSs/XHMqWyciXXswLDF9XF1cKFxzKlsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbYS16QS1aMC05X10rPyI7aTozOTY7czo0MToiZndyaXRlXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl08XD9waHAiO2k6Mzk3O3M6NTY6IkAqY3JlYXRlX2Z1bmN0aW9uXChccypbJyJdWyciXVxzKixccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjM5ODtzOjk5OiJcXVwoWyciXVwkX1snIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF0iO2k6Mzk5O3M6Mzk6ImlmXHMqXChccyppc3NldFwoXHMqXCRfR0VUXFtccypbJyJdcGluZyI7aTo0MDA7czozMDoicmVhZF9maWxlXChccypbJyJdZG9tYWluc1wudHh0IjtpOjQwMTtzOjE3MjoiKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChccypcJFthLXpBLVowLTlfXSs/XChccypcJCI7aTo0MDI7czozNzoiZXZhbFwoXHMqWyciXXtccypcJFthLXpBLVowLTlfXSs/XHMqfSI7aTo0MDM7czoxMTA6ImlmXHMqXChccypmaWxlX2V4aXN0c1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXClccyp7XHMqY2htb2RcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqMFxkK1wpO1xzKn1ccyplY2hvIjtpOjQwNDtzOjExOiI9PVsnIl1cKVwpOyI7aTo0MDU7czo1NjoiXCRbYS16QS1aMC05X10rPz11cmxkZWNvZGVcKFsnIl0uKz9bJyJdXCk7aWZcKHByZWdfbWF0Y2giO2k6NDA2O3M6ODM6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZGVjcnlwdF9TT1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdIjtpOjQwNztzOjEwNzoiPVxzKm1haWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xkK1xdXHMqXClccyosXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRbYS16QS1aMC05X10rP1xbXGQrXF0iO2k6NDA4O3M6MjY6ImV2YWxcKFxzKlsnIl1yZXR1cm5ccytldmFsIjtpOjQwOTtzOjk1OiI9XHMqYmFzZTY0X2VuY29kZVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpO1xzKmhlYWRlciI7aTo0MTA7czoxMDc6IkBpbmlfc2V0XChbJyJdZXJyb3JfbG9nWyciXSxOVUxMXCk7XHMqQGluaV9zZXRcKFsnIl1sb2dfZXJyb3JzWyciXSwwXCk7XHMqZnVuY3Rpb25ccytyZWFkX2ZpbGVcKFwkZmlsZV9uYW1lIjtpOjQxMTtzOjM3OiJcJHRleHRccyo9XHMqaHR0cF9nZXRcKFxzKlsnIl1odHRwOi8vIjtpOjQxMjtzOjE0NjoiXCRbYS16QS1aMC05X10rP1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvYm9keT5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9odG1sPlsnIl0iO2k6NDEzO3M6MTYzOiJcI1thLXpBLVowLTlfXSs/XCNccyppZlwoZW1wdHlcKFwkW2EtekEtWjAtOV9dKz9cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXTxzY3JpcHQuKz88L3NjcmlwdD5bJyJdO1xzKmVjaG9ccytcJFthLXpBLVowLTlfXSs/O1xzKn1ccypcIy9bYS16QS1aMC05X10rP1wjIjtpOjQxNDtzOjY3OiJcLlwkX1JFUVVFU1RcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVxzKixccyp0cnVlXHMqLFxzKjMwMlwpIjtpOjQxNTtzOjEwNzoiPVxzKmNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqbnVsbFxzKixccypbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCk7XHMqXCRbYS16QS1aMC05X10rP1woXCkiO2k6NDE2O3M6NTQ6Ij1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHBzKjovL1xkK1wuXGQrXC5cZCtcLlxkKyI7aTo0MTc7czo1NzoiQ29udGVudC10eXBlOlxzKmFwcGxpY2F0aW9uL3ZuZFwuYW5kcm9pZFwucGFja2FnZS1hcmNoaXZlIjtpOjQxODtzOjIwOiJzbHVycFx8bXNuYm90XHx0ZW9tYSI7aTo0MTk7czoyNzoiXCRHTE9CQUxTXFtuZXh0XF1cW1snIl1uZXh0IjtpOjQyMDtzOjc1OiIkW2EtekEtWjAtOV9dXHtcZCtcfVxzKlwuJFthLXpBLVowLTlfXVx7XGQrXH1ccypcLiRbYS16QS1aMC05X11ce1xkK1x9XHMqXC4iO2k6NDIxO3M6MjI6ImV2YWxcKFthLXpBLVowLTlfXSs/XCgiO2k6NDIyO3M6MTY3OiI7QCpcJFthLXpBLVowLTlfXSs/XCgoZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aTo0MjM7czozMDoiaGVhZGVyXChfW2EtekEtWjAtOV9dKz9cKFxkK1wpIjtpOjQyNDtzOjE4NjoiaWZccypcKGlzc2V0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClccyomJlxzKm1kNVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqPT09XHMqWyciXVthLXpBLVowLTlfXSs/WyciXVwpIjtpOjQyNTtzOjkyOiJcLj1ccypjaHJcKFwkW2EtekEtWjAtOV9dKz9ccyo+PlxzKlwoXGQrXHMqXCpccypcKFxkK1xzKi1ccypcJFthLXpBLVowLTlfXSs/XClcKVxzKiZccypcZCtcKSI7aTo0MjY7czozMToiLT5wcmVwYXJlXChbJyJdU0hPV1xzK0RBVEFCQVNFUyI7aTo0Mjc7czoyMzoic29ja3Nfc3lzcmVhZFwoXCRjbGllbnQiO2k6NDI4O3M6MjQ6IjwlZXZhbFwoXHMqUmVxdWVzdFwuSXRlbSI7aTo0Mjk7czoxMDI6IlwkX1BPU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZvcGVuXChccypcJF9HRVRcW1snIl1bYS16QS1aMC05X10rP1snIl1cXSI7aTo0MzA7czo0MDoidXJsPVsnIl1odHRwOi8vc2NhbjR5b3VcLm5ldC9yZW1vdGVcLnBocCI7aTo0MzE7czo2MjoiY2FsbF91c2VyX2Z1bmNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1wpO30iO2k6NDMyO3M6NzM6InByZWdfcmVwbGFjZVwoXHMqWyciXS8uKz8vZVsnIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDMzO3M6MTA4OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0uKz9bJyJdXCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmb3BlblwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdd1snIl0iO2k6NDM0O3M6NjE6ImlmXChccypcJFthLXpBLVowLTlfXSs/XClccyp7XHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1wpO1xzKn0iO2k6NDM1O3M6MTY2OiJhcnJheV9tYXBcKFxzKlsnIl0oZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdIjtpOjQzNjtzOjE4NToiPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF07XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX3B1dF9jb250ZW50c1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypmaWxlX2dldF9jb250ZW50c1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6NDM3O3M6Mzk6IlthLXpBLVowLTlfXSs/XChccypbYS16QS1aMC05X10rPz1ccypcKSI7aTo0Mzg7czo2MjoiPFw/XHMqXCRbYS16QS1aMC05X10rPz1bJyJdLis/WyciXTtccypoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjoiO2k6NDM5O3M6MjU6IjwhLS1cI2V4ZWNccytjbWRccyo9XHMqXCQiO2k6NDQwO3M6Mjg6ImRpc2tfZnJlZV9zcGFjZVwoXHMqWyciXS90bXAiO2k6NDQxO3M6ODI6ImlmXChccypzdHJpcG9zXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl1hbmRyb2lkWyciXVxzKlwpXHMqIT09XHMqZmFsc2VcKVxzKnsiO2k6NDQyO3M6OTE6IlwuPVxzKlsnIl08ZGl2XHMrc3R5bGU9WyciXWRpc3BsYXk6bm9uZTtbJyJdPlsnIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlsnIl08L2Rpdj4iO2k6NDQzO3M6MTE4OiI9ZmlsZV9leGlzdHNcKFwkW2EtekEtWjAtOV9dKz9cKVw/QGZpbGVtdGltZVwoXCRbYS16QS1aMC05X10rP1wpOlwkW2EtekEtWjAtOV9dKz87QGZpbGVfcHV0X2NvbnRlbnRzXChcJFthLXpBLVowLTlfXSs/IjtpOjQ0NDtzOjkzOiJcJFthLXpBLVowLTlfXSs/XHMqXFtccypbYS16QS1aMC05X10rP1xzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypbYS16QS1aMC05X10rP1xzKlxdXHMqXCkiO2k6NDQ1O3M6OTg6IlwkW2EtekEtWjAtOV9dKz8sWyciXXNsdXJwWyciXVwpXHMqIT09XHMqZmFsc2VccypcfFx8XHMqc3RycG9zXChccypcJFthLXpBLVowLTlfXSs/LFsnIl1zZWFyY2hbJyJdIjtpOjQ0NjtzOjY2OiJcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XClccypcKTsiO2k6NDQ3O3M6MTc6ImNsYXNzXHMrTUN1cmxccyp7IjtpOjQ0ODtzOjU2OiJAaW5pX3NldFwoWyciXWRpc3BsYXlfZXJyb3JzWyciXSwwXCk7XHMqQGVycm9yX3JlcG9ydGluZyI7aTo0NDk7czo2OToiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJGZpbGVwYXRoXHMqXClccypcKVxzKntccyplY2hvXHMrWyciXXVwbG9hZGVkIjtpOjQ1MDtzOjMwOiJyZXR1cm5ccytSQzQ6OkVuY3J5cHRcKFwkYSxcJGIiO2k6NDUxO3M6MzI6ImZ1bmN0aW9uXHMrZ2V0SFRUUFBhZ2VcKFxzKlwkdXJsIjtpOjQ1MjtzOjIxOiI9XHMqcmVxdWVzdFwoXHMqY2hyXCgiO2k6NDUzO3M6NTY6IjtccyphcnJheV9maWx0ZXJcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqYmFzZTY0X2RlY29kZVwoIjtpOjQ1NDtzOjIxNToiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl0oZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDU1O3M6MjI4OiJjYWxsX3VzZXJfZnVuY19hcnJheVwoXHMqWyciXShldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl1ccyosXHMqYXJyYXlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDU2O3M6ODc6ImlmIFwoISpcJF9TRVJWRVJcW1snIl1IVFRQX1VTRVJfQUdFTlRbJyJdXF1ccypPUlxzKlwoc3Vic3RyXChcJF9TRVJWRVJcW1snIl1SRU1PVEVfQUREUiI7aTo0NTc7czo1MzoicmVscGF0aHRvYWJzcGF0aFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDU4O3M6Njg6IlwkZGF0YVxbWyciXWNjX2V4cF9tb250aFsnIl1cXVxzKixccypzdWJzdHJcKFwkZGF0YVxbWyciXWNjX2V4cF95ZWFyIjt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxMjE6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxMTI6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6Mzc6ImNsYXNzXHMrQ01fY2xpZW50XHMrZXh0ZW5kc1xzKkNNX2Jhc2UiO2k6MTY7czoxOToibmV3XHMrQ01fY2xpZW50XChcKSI7aToxNztzOjE2OiJ0bF9saW5rc19kYl9maWxlIjtpOjE4O3M6MjA6ImNsYXNzXHMrbG1wX2Jhc2Vccyt7IjtpOjE5O3M6MTU6IlRydXN0bGlua0NsaWVudCI7aToyMDtzOjEzOiItPlxzKlNMQ2xpZW50IjtpOjIxO3M6MTY2OiJpc3NldFxzKlwoKlxzKlwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF1ccypcKVxzKiYmXHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXVxzKj09XHMqWyciXXswLDF9TE1QX1JvYm90IjtpOjIyO3M6NDM6IlwkbGlua3MtPlxzKnJldHVybl9saW5rc1xzKlwoKlxzKlwkbGliX3BhdGgiO2k6MjM7czo0NDoiXCRsaW5rc19jbGFzc1xzKj1ccypuZXdccytHZXRfbGlua3NccypcKCpccyoiO2k6MjQ7czo1MjoiWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfVwuWyciXXswLDF9XHMqXCkqXHMqO1xzKlw/PiI7aToyNTtzOjc6Imxldml0cmEiO2k6MjY7czoxMDoiZGFwb3hldGluZSI7aToyNztzOjY6InZpYWdyYSI7aToyODtzOjY6ImNpYWxpcyI7aToyOTtzOjg6InByb3ZpZ2lsIjtpOjMwO3M6MTk6ImNsYXNzXHMrVFdlZmZDbGllbnQiO2k6MzE7czoxODoibmV3XHMrU0xDbGllbnRcKFwpIjtpOjMyO3M6MjQ6Il9fbGlua2ZlZWRfYmVmb3JlX3RleHRfXyI7aTozMztzOjE2OiJfX3Rlc3RfdGxfbGlua19fIjtpOjM0O3M6MTg6InM6MTE6ImxtcF9jaGFyc2V0IiI7aTozNTtzOjIwOiI9XHMrbmV3XHMrTUxDbGllbnRcKCI7aTozNjtzOjQ3OiJlbHNlXHMraWZccypcKFxzKlwoXHMqc3RycG9zXChccypcJGxpbmtzX2lwXHMqLCI7aTozNztzOjMzOiJmdW5jdGlvblxzK3Bvd2VyX2xpbmtzX2Jsb2NrX3ZpZXciO2k6Mzg7czoyMDoiY2xhc3NccytJTkdPVFNDbGllbnQiO2k6Mzk7czoxMDoiX19MSU5LX188YSI7aTo0MDtzOjIxOiJjbGFzc1xzK0xpbmtwYWRfc3RhcnQiO2k6NDE7czoxMzoiY2xhc3NccytUTlhfbCI7aTo0MjtzOjIyOiJjbGFzc1xzK01FR0FJTkRFWF9iYXNlIjtpOjQzO3M6MTU6Il9fTElOS19fX19FTkRfXyI7aTo0NDtzOjIyOiJuZXdccytUUlVTVExJTktfY2xpZW50IjtpOjQ1O3M6NzU6InJcLnBocFw/aWQ9W2EtekEtWjAtOV9dKz8mcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX1ccytcW1I9MzAyLExcXSI7aTo0NjtzOjM5OiJVc2VyLWFnZW50OlxzKkdvb2dsZWJvdFxzKkRpc2FsbG93OlxzKi8iO2k6NDc7czoxODoibmV3XHMrTExNX2NsaWVudFwoIjtpOjQ4O3M6MzY6IiZyZWZlcmVyPSV7SFRUUF9IT1NUfS8le1JFUVVFU1RfVVJJfSI7aTo0OTtzOjI5OiJcLnBocFw/aWQ9XCQxJiV7UVVFUllfU1RSSU5HfSI7aTo1MDtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6NTE7czoyMzoiQWRkSGFuZGxlclxzK3BocC1zY3JpcHQiO2k6NTI7czoyMzoiQWRkSGFuZGxlclxzK2NnaS1zY3JpcHQiO2k6NTM7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aTo1NDtzOjEyOiJwaHBpbmZvXChcKTsiO2k6NTU7czoxNToiXChtc2llXHxvcGVyYVwpIjtpOjU2O3M6MjI6IjxoMT5Mb2FkaW5nXC5cLlwuPC9oMT4iO2k6NTc7czoyOToiRXJyb3JEb2N1bWVudFxzKzUwMFxzK2h0dHA6Ly8iO2k6NTg7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwMFxzK2h0dHA6Ly8iO2k6NTk7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly8iO2k6NjA7czo0OToiUmV3cml0ZUNvbmRccyole0hUVFBfVVNFUl9BR0VOVH1ccypcLlwqbmRyb2lkXC5cKiI7aTo2MTtzOjEwMToiPHNjcmlwdFxzK2xhbmd1YWdlPVsnIl17MCwxfUphdmFTY3JpcHRbJyJdezAsMX0+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly8iO2k6NjI7czo5OToiY2hyXHMqXChccyoxMDFccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMThccypcKVxzKlwuXHMqY2hyXHMqXChccyo5N1xzKlwpXHMqXC5ccypjaHJccypcKFxzKjEwOFxzKlwpIjtpOjYzO3M6MzA6ImN1cmxcLmhheHhcLnNlL3JmYy9jb29raWVfc3BlYyI7aTo2NDtzOjE4OiJKb29tbGFfYnJ1dGVfRm9yY2UiO2k6NjU7czozNDoiUmV3cml0ZUNvbmRccyole0hUVFA6eC13YXAtcHJvZmlsZSI7aTo2NjtzOjQyOiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LW9wZXJhbWluaS1waG9uZS11YX0iO2k6Njc7czo2NjoiUmV3cml0ZUNvbmRccyole0hUVFA6QWNjZXB0LUxhbmd1YWdlfVxzKlwocnVcfHJ1LXJ1XHx1a1wpXHMqXFtOQ1xdIjtpOjY4O3M6MjY6InNsZXNoXCtzbGVzaFwrZG9tZW5cK3BvaW50IjtpOjY5O3M6MTc6InRlbGVmb25uYXlhLWJhemEtIjtpOjcwO3M6MTg6ImljcS1kbHlhLXRlbGVmb25hLSI7aTo3MTtzOjI0OiJwYWdlX2ZpbGVzL3N0eWxlMDAwXC5jc3MiO2k6NzI7czoyMDoic3ByYXZvY2huaWstbm9tZXJvdi0iO2k6NzM7czoxNzoiS2F6YW4vaW5kZXhcLmh0bWwiO2k6NzQ7czo1MDoiR29vZ2xlYm90WyciXXswLDF9XHMqXClcKXtlY2hvXHMrZmlsZV9nZXRfY29udGVudHMiO2k6NzU7czoyNjoiaW5kZXhcLnBocFw/aWQ9XCQxJiV7UVVFUlkiO2k6NzY7czoyMDoiVm9sZ29ncmFkaW5kZXhcLmh0bWwiO2k6Nzc7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6Nzg7czoxOToiLWtseWNoLWstaWdyZVwuaHRtbCI7aTo3OTtzOjE5OiJsbXBfY2xpZW50XChzdHJjb2RlIjtpOjgwO3M6MTc6Ii9cP2RvPWthay11ZGFsaXQtIjtpOjgxO3M6MTQ6Ii9cP2RvPW9zaGlia2EtIjtpOjgyO3M6MTk6Ii9pbnN0cnVrdHNpeWEtZGx5YS0iO2k6ODM7czo0MzoiY29udGVudD0iXGQrO1VSTD1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tLyI7aTo4NDtzOjU5OiIlPCEtLVxcc1wqXCRtYXJrZXJcXHNcKi0tPlwuXCtcPzwhLS1cXHNcKi9cJG1hcmtlclxcc1wqLS0+JSI7aTo4NTtzOjQyOiJSZXdyaXRlUnVsZVxzKlwoXC5cK1wpXHMqaW5kZXhcLnBocFw/cz1cJDAiO2k6ODY7czoxODoiUmVkaXJlY3RccypodHRwOi8vIjtpOjg3O3M6NDU6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP2lkPVwkMSI7aTo4ODtzOjQ0OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9tPVwkMSI7aTo4OTtzOjUwOiJSZXdyaXRlUnVsZVxzKlwuXCovXC5cKlxzKlthLXpBLVowLTlfXSs/XC5waHBcP1wkMCI7aTo5MDtzOjM5OiJSZXdyaXRlQ29uZFxzKyV7UkVNT1RFX0FERFJ9XHMrXF44NVwuMjYiO2k6OTE7czo0MToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeMjE3XC4xMTgiO2k6OTI7czo1MzoiUmV3cml0ZUVuZ2luZVxzK09uXHMqUmV3cml0ZUJhc2VccysvXD9bYS16QS1aMC05X10rPz0iO2k6OTM7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6OTQ7czo1MToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXCRccytodHRwOi8vXGQrXC5cZCtcLlxkK1wuIjtpOjk1O3M6Njc6IjwhLS1jaGVjazpbJyJdXHMqXC5ccyptZDVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6OTY7czoxODoiUmV3cml0ZUJhc2Vccysvd3AtIjtpOjk3O3M6MzY6IlNldEhhbmRsZXJccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aTo5ODtzOjQyOiIle0hUVFBfVVNFUl9BR0VOVH1ccyshd2luZG93cy1tZWRpYS1wbGF5ZXIiO2k6OTk7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDA7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDE7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDI7czo4MjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfVlhbmRleEJvdCI7aToxMDM7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfXlhbmRleCI7aToxMDQ7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfWdvb2dsZSI7aToxMDU7czo4OiIva3J5YWtpLyI7aToxMDY7czoxMDoiXC5waHBcP1wkMCI7aToxMDc7czo3MToicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpXHMqLFxzKlsnIl1Hb29nbGVib3QiO2k6MTA4O3M6ODA6ImluZGV4XC5waHBcP21haW5fcGFnZT1wcm9kdWN0X2luZm8mcHJvZHVjdHNfaWQ9WyciXVxzKlwuXHMqc3RyX3JlcGxhY2VcKFsnIl1saXN0IjtpOjEwOTtzOjMxOiJmc29ja29wZW5cKFxzKlsnIl1zaGFkeWtpdFwuY29tIjtpOjExMDtzOjEwOiJlb2ppZXVcLmNuIjtpOjExMTtzOjIyOiI+XHMqPC9pZnJhbWU+XHMqPFw/cGhwIjt9"));
$g_PhishingSig = unserialize(base64_decode("YTo3Mjp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6Mjk6Imdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5Ijt9"));
$g_JSVirSig = unserialize(base64_decode("YToxMTk6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czo0MToiZj0nZidcKydyJ1wrJ28nXCsnbSdcKydDaCdcKydhckMnXCsnb2RlJzsiO2k6NTtzOjIyOiJcLnByb3RvdHlwZVwuYX1jYXRjaFwoIjtpOjY7czozNzoidHJ5e0Jvb2xlYW5cKFwpXC5wcm90b3R5cGVcLnF9Y2F0Y2hcKCI7aTo3O3M6MzQ6ImlmXChSZWZcLmluZGV4T2ZcKCdcLmdvb2dsZVwuJ1wpIT0iO2k6ODtzOjg2OiJpbmRleE9mXHxpZlx8cmNcfGxlbmd0aFx8bXNuXHx5YWhvb1x8cmVmZXJyZXJcfGFsdGF2aXN0YVx8b2dvXHxiaVx8aHBcfHZhclx8YW9sXHxxdWVyeSI7aTo5O3M6NTQ6IkFycmF5XC5wcm90b3R5cGVcLnNsaWNlXC5jYWxsXChhcmd1bWVudHNcKVwuam9pblwoIiJcKSI7aToxMDtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjExO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTI7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTM7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxNDtzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNTtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE2O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNztzOjc6IlxceDY1QXQiO2k6MTg7czo5OiJcXHg2MXJDb2QiO2k6MTk7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToyMDtzOjExOiI9ImV2IlwrImFsIiI7aToyMTtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjI7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIzO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjI0O3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI1O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI2O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6Mjc7czo5OiJ2YXJccytfMHgiO2k6Mjg7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjk7czo3OiJwaW5nbm93IjtpOjMwO3M6ODoic2VyY2hib3QiO2k6MzE7czoxMDoia20wYWU5Z3I2bSI7aTozMjtzOjY6ImMzMjg0ZCI7aTozMztzOjg6IlxceDY4YXJDIjtpOjM0O3M6ODoiXFx4NmRDaGEiO2k6MzU7czo3OiJcXHg2ZmRlIjtpOjM2O3M6NzoiXFx4NmZkZSI7aTozNztzOjg6IlxceDQzb2RlIjtpOjM4O3M6NzoiXFx4NzJvbSI7aTozOTtzOjc6IlxceDQzaGEiO2k6NDA7czo3OiJcXHg3MkNvIjtpOjQxO3M6ODoiXFx4NDNvZGUiO2k6NDI7czoxMDoiXC5keW5kbnNcLiI7aTo0MztzOjk6IlwuZHluZG5zLSI7aTo0NDtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ1O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0NjtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDc7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDg7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDk7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjUwO3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTE7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjUyO3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MztzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjU0O3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NTtzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU2O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1NztzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo1ODtzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo1OTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjYwO3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYxO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjYyO3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjM7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjQ7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NTtzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2NjtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2NztzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo2ODtzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjY5O3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjcwO3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MTtzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3MjtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjczO3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3NDtzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6NzU7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3NjtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3NztzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjc4O3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo3OTtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6ODA7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MTtzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjgyO3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjgzO3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4NDtzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg1O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg2O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg3O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo4ODtzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo4OTtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo5MDtzOjU1OiJzdHJpcG9zXHMqXChccypmX2hheXN0YWNrXHMqLFxzKmZfbmVlZGxlXHMqLFxzKmZfb2Zmc2V0IjtpOjkxO3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjkyO3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6OTM7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5NDtzOjE3OiJzZXhmcm9taW5kaWFcLmNvbSI7aTo5NTtzOjExOiJmaWxla3hcLmNvbSI7aTo5NjtzOjEzOiJzdHVtbWFublwubmV0IjtpOjk3O3M6MTQ6InRvcGxheWdhbWVcLnJ1IjtpOjk4O3M6MTQ6Imh0dHA6Ly94enhcLnBtIjtpOjk5O3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aToxMDA7czoxMToibW9iaS1nb1wuaW4iO2k6MTAxO3M6MTg6ImJhbmtvZmFtZXJpY2FcLmNvbSI7aToxMDI7czoxNjoibXlmaWxlc3RvcmVcLmNvbSI7aToxMDM7czoxNzoiZmlsZXN0b3JlNzJcLmluZm8iO2k6MTA0O3M6MTY6ImZpbGUyc3RvcmVcLmluZm8iO2k6MTA1O3M6MTU6InVybDJzaG9ydFwuaW5mbyI7aToxMDY7czoxODoiZmlsZXN0b3JlMTIzXC5pbmZvIjtpOjEwNztzOjEyOiJ1cmwxMjNcLmluZm8iO2k6MTA4O3M6MTQ6ImRvbGxhcmFkZVwuY29tIjtpOjEwOTtzOjExOiJzZWNjbGlrXC5ydSI7aToxMTA7czoxMToibW9ieS1hYVwucnUiO2k6MTExO3M6MTI6InNlcnZsb2FkXC5ydSI7aToxMTI7czo0ODoic3RyaXBvc1wobmF2aWdhdG9yXC51c2VyQWdlbnRccyosXHMqbGlzdF9kYXRhXFtpIjtpOjExMztzOjI2OiJpZlxzKlwoIXNlZV91c2VyX2FnZW50XChcKSI7aToxMTQ7czo0NjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlsnIl1bJyJdO31pZlwoIWdldENvb2tpZSI7aToxMTU7czo3MDoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWZ0cDovLyI7aToxMTY7czo0ODoiaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKFsnIl17MCwxfXNhYnJpIjtpOjExNztzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6MTE4O3M6MTE2OiJcKTtccyppZlwoXHMqW2EtekEtWjAtOV9dKz9cLnRlc3RcKFxzKmRvY3VtZW50XC5yZWZlcnJlclxzKlwpXHMqJiZccypbYS16QS1aMC05X10rP1wpXHMqe1xzKmRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTo1OTp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czoxMDE6ImRvY3VtZW50XC5jYXB0aW9uPW51bGw7d2luZG93XC5hZGRFdmVudFwoWyciXXswLDF9bG9hZFsnIl17MCwxfSxmdW5jdGlvblwoXCl7dmFyIGNhcHRpb249bmV3IEpDYXB0aW9uIjtpOjk7czoxMjoiaHR0cDovL2Z0cFwuIjtpOjEwO3M6Nzoibm5uXC5wbSI7aToxMTtzOjc6Im5ubVwucG0iO2k6MTI7czoxNjoibW9iLXJlZGlyZWN0XC5ydSI7aToxMztzOjE2OiJ3ZWItcmVkaXJlY3RcLnJ1IjtpOjE0O3M6MTY6InRvcC13ZWJwaWxsXC5jb20iO2k6MTU7czoxOToiZ29vZHBpbGxzZXJ2aWNlXC5ydSI7aToxNjtzOjc4OiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9aHR0cDovL2dvb1wuZ2wiO2k6MTc7czo2NzoiIlxzKlwrXHMqbmV3IERhdGVcKFwpXC5nZXRUaW1lXChcKTtccypkb2N1bWVudFwuYm9keVwuYXBwZW5kQ2hpbGRcKCI7aToxODtzOjM0OiJcLmluZGV4T2ZcKFxzKlsnIl1JQnJvd3NlWyciXVxzKlwpIjtpOjE5O3M6ODc6Ij1kb2N1bWVudFwucmVmZXJyZXI7XHMqW2EtekEtWjAtOV9dKz89dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXSs/XHMqXCk7XHMqdmFyXHMrRXhwRGF0ZSI7aToyMDtzOjc0OiI8IS0tXHMqW2EtekEtWjAtOV9dKz9ccyotLT48c2NyaXB0Lis/PC9zY3JpcHQ+PCEtLS9ccypbYS16QS1aMC05X10rP1xzKi0tPiI7aToyMTtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToyMjtzOjcyOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rP1wrWyciXXRlWyciXVxzKlxdXChTdHJpbmciO2k6MjM7czo4MToic2V0Q29va2llXChccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1wpIjtpOjI0O3M6Mjk6IlxdXChccyp2XCtcK1xzKlwpLTFccypcKVxzKlwpIjtpOjI1O3M6NDQ6ImRvY3VtZW50XFtccypfMHhbYS16QS1aMC05X10rP1xbXGQrXF1ccypcXVwoIjtpOjI2O3M6Mjg6Ii9nLFsnIl1bJyJdXClcLnNwbGl0XChbJyJdXF0iO2k6Mjc7czo0Mzoid2luZG93XC5sb2NhdGlvbj1ifVwpXChuYXZpZ2F0b3JcLnVzZXJBZ2VudCI7aToyODtzOjIyOiJbJyJdcmVwbGFjZVsnIl1cXVwoL1xbIjtpOjI5O3M6MTI3OiJpXFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dKz9cW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdXChcZCssXGQrXClcKVwpe3dpbmRvd1xbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF09bG9jIjtpOjMwO3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MzE7czo1MToiWyciXVxdXChbYS16QS1aMC05X10rP1wrXCtcKS1cZCtcKX1cKEZ1bmN0aW9uXChbJyJdIjtpOjMyO3M6NjU6Ijt3aGlsZVwoW2EtekEtWjAtOV9dKz88XGQrXClkb2N1bWVudFxbLis/XF1cKFN0cmluZ1xbWyciXWZyb21DaGFyIjtpOjMzO3M6MTA5OiJpZlxzKlwoW2EtekEtWjAtOV9dKz9cLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjM0O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzU7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzY7czoxMzc6ImZhbHNlfTtbYS16QS1aMC05X10rPz1bYS16QS1aMC05X10rP1woWyciXVthLXpBLVowLTlfXSs/WyciXVwpXHxbYS16QS1aMC05X10rP1woWyciXVthLXpBLVowLTlfXSs/WyciXVwpO1thLXpBLVowLTlfXSs/XHw9W2EtekEtWjAtOV9dKz87IjtpOjM3O3M6NjU6IlN0cmluZ1wuZnJvbUNoYXJDb2RlXChccypbYS16QS1aMC05X10rP1wuY2hhckNvZGVBdFwoaVwpXHMqXF5ccyoyIjtpOjM4O3M6MTY6Ii49WyciXS46Ly8uXC4uLy4iO2k6Mzk7czo1ODoiXFtbJyJdY2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXSs/XHMqXCtccypbJyJdQXRbJyJdXF1cKCI7aTo0MDtzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjQxO3M6NTY6IlN0cmluZ1xbXHMqWyciXWZyb21DaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dKz9ccypcXVwoIjtpOjQyO3M6Mjg6Ii49WyciXS46Ly8uXC4uXC4uXC4uLy5cLi5cLi4iO2k6NDM7czo0MDoiPC9zY3JpcHQ+WyciXVwpO1xzKi9cKi9bYS16QS1aMC05X10rP1wqLyI7aTo0NDtzOjczOiJkb2N1bWVudFxbXzB4XGQrXFtcZCtcXVxdXChfMHhcZCtcW1xkK1xdXCtfMHhcZCtcW1xkK1xdXCtfMHhcZCtcW1xkK1xdXCk7IjtpOjQ1O3M6NTE6Ilwoc2VsZj09PXRvcFw/MDoxXClcK1snIl1cLmpzWyciXSxhXChmLGZ1bmN0aW9uXChcKSI7aTo0NjtzOjk6IiZhZHVsdD0xJiI7aTo0NztzOjk4OiJkb2N1bWVudFwucmVhZHlTdGF0ZVxzKz09XHMrWyciXWNvbXBsZXRlWyciXVwpXHMqe1xzKmNsZWFySW50ZXJ2YWxcKFthLXpBLVowLTlfXSs/XCk7XHMqc1wuc3JjXHMqPSI7aTo0ODtzOjE5OiIuOi8vLlwuLlwuLi8uXC4uXD8vIjtpOjQ5O3M6Mzk6IlxkK1xzKj5ccypcZCtccypcP1xzKlsnIl1cXHhcZCtbJyJdXHMqOiI7aTo1MDtzOjQ1OiJbJyJdXFtccypbJyJdY2hhckNvZGVBdFsnIl1ccypcXVwoXHMqXGQrXHMqXCkiO2k6NTE7czoxNzoiPC9ib2R5PlxzKjxzY3JpcHQiO2k6NTI7czoxNzoiPC9odG1sPlxzKjxzY3JpcHQiO2k6NTM7czoxNzoiPC9odG1sPlxzKjxpZnJhbWUiO2k6NTQ7czo0MjoiZG9jdW1lbnRcLndyaXRlXChccypTdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjU1O3M6MjI6InNyYz0iZmlsZXNfc2l0ZS9qc1wuanMiO2k6NTY7czo5NDoid2luZG93XC5wb3N0TWVzc2FnZVwoe1xzKnpvcnN5c3RlbTpccyoxLFxzKnR5cGU6XHMqWyciXXVwZGF0ZVsnIl0sXHMqcGFyYW1zOlxzKntccypbJyJddXJsWyciXSI7aTo1NztzOjExMzoiW2EtekEtWjAtOV9dKz9cLmF0dGFjaEV2ZW50XChbJyJdb25sb2FkWyciXSxhXCk6W2EtekEtWjAtOV9dKz9cLmFkZEV2ZW50TGlzdGVuZXJcKFsnIl1sb2FkWyciXSxhLCExXCk7bG9hZE1hdGNoZXIiO2k6NTg7czo3ODoiaWZcKFwoYT1lXC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWFbJyJdXClcKSYmYVxbMFxdJiZhXFswXF1cLmhyZWZcKWZvclwodmFyIjt9"));


////////////////////////////////////////////////////////////////////////////
if (!isCli() && !isset($_SERVER['HTTP_USER_AGENT'])) {
  echo "#####################################################\n";
  echo "# Error: cannot run on php-cgi. Requires php as cli #\n";
  echo "#                                                   #\n";
  echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
  echo "#####################################################\n";
  exit;
}


if (version_compare(phpversion(), '5.3.1', '<')) {
  echo "#####################################################\n";
  echo "# Warning: PHP Version < 5.3.1                      #\n";
  echo "# Some function might not work properly             #\n";
  echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
  echo "#####################################################\n";
}

define('AI_VERSION', '20151014_BEGET');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter = 0;

$g_NotRead = array();
$g_FileInfo = array();
$g_Iframer = array();
$g_PHPCodeInside = array();
$g_CriticalJS = array();
$g_Phishing = array();
$g_Base64 = array();
$g_HeuristicDetected = array();
$g_HeuristicType = array();
$g_UnixExec = array();
$g_SkippedFolders = array();
$g_UnsafeFilesFound = array();
$g_CMS = array();
$g_SymLinks = array();
$g_HiddenFiles = array();
$g_Vulnerable = array();

$g_TotalFolder = 0;
$g_TotalFiles = 0;

$g_FoundTotalDirs = 0;
$g_FoundTotalFiles = 0;

if (!isCli()) {
   $defaults['site_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/'; 
}

define('CRC32_LIMIT', pow(2, 31) - 1);
define('CRC32_DIFF', CRC32_LIMIT * 2 -2);

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
srand(time());

set_time_limit(0);
ini_set('max_execution_time', '90000');
ini_set('realpath_cache_size','16M');
ini_set('realpath_cache_ttl','1200');

if (!function_exists('stripos')) {
	function stripos($par_Str, $par_Entry, $Offset = 0) {
		return strpos(strtolower($par_Str), strtolower($par_Entry), $Offset);
	}
}

define('CMS_BITRIX', 'Bitrix');
define('CMS_WORDPRESS', 'Wordpress');
define('CMS_JOOMLA', 'Joomla');
define('CMS_DLE', 'Data Life Engine');
define('CMS_IPB', 'Invision Power Board');
define('CMS_WEBASYST', 'WebAsyst');
define('CMS_OSCOMMERCE', 'OsCommerce');
define('CMS_DRUPAL', 'Drupal');
define('CMS_MODX', 'MODX');
define('CMS_INSTANTCMS', 'Instant CMS');
define('CMS_PHPBB', 'PhpBB');
define('CMS_VBULLETIN', 'vBulletin');
define('CMS_SHOPSCRIPT', 'PHP ShopScript Premium');

define('CMS_VERSION_UNDEFINED', '0.0');

class CmsVersionDetector {
    private $root_path;
    private $versions;
    private $types;

    public function __construct($root_path = '.') {

        $this->root_path = $root_path;
        $this->versions = array();
        $this->types = array();

        $version = '';

        if ($this->checkBitrix($version)) {
           $this->addCms(CMS_BITRIX, $version);
        }

        if ($this->checkWordpress($version)) {
           $this->addCms(CMS_WORDPRESS, $version);
        }

        if ($this->checkJoomla($version)) {
           $this->addCms(CMS_JOOMLA, $version);
        }

        if ($this->checkDle($version)) {
           $this->addCms(CMS_DLE, $version);
        }

        if ($this->checkIpb($version)) {
           $this->addCms(CMS_IPB, $version);
        }

        if ($this->checkWebAsyst($version)) {
           $this->addCms(CMS_WEBASYST, $version);
        }

        if ($this->checkOsCommerce($version)) {
           $this->addCms(CMS_OSCOMMERCE, $version);
        }

        if ($this->checkDrupal($version)) {
           $this->addCms(CMS_DRUPAL, $version);
        }

        if ($this->checkMODX($version)) {
           $this->addCms(CMS_MODX, $version);
        }

        if ($this->checkInstantCms($version)) {
           $this->addCms(CMS_INSTANTCMS, $version);
        }

        if ($this->checkPhpBb($version)) {
           $this->addCms(CMS_PHPBB, $version);
        }

        if ($this->checkVBulletin($version)) {
           $this->addCms(CMS_VBULLETIN, $version);
        }

        if ($this->checkPhpShopScript($version)) {
           $this->addCms(CMS_SHOPSCRIPT, $version);
        }

    }

    function getCmsList() {
      return $this->types;
    }

    function getCmsVersions() {
      return $this->versions;
    }

    function getCmsNumber() {
      return count($this->types);
    }

    function getCmsName($index = 0) {
      return $this->types[$index];
    }

    function getCmsVersion($index = 0) {
      return $this->versions[$index];
    }

    private function addCms($type, $version) {
       $this->types[] = $type;
       $this->versions[] = $version;
    }

    private function checkBitrix(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/bitrix')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/bitrix/modules/main/classes/general/version.php');
          if (preg_match('|define\("SM_VERSION","(.+?)"\)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWordpress(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/wp-admin')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/wp-includes/version.php');
          if (preg_match('|\$wp_version\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }
       }

       return $res;
    }

    private function checkJoomla(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/libraries/joomla')) {
          $res = true;

          // for 1.5.x
          $tmp_content = @file_get_contents($this->root_path .'/libraries/joomla/version.php');
          if (preg_match('|var\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|var\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 1.7.x
          $tmp_content = @file_get_contents($this->root_path .'/includes/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 2.5.x and 3.x
          $tmp_content = @file_get_contents($this->root_path .'/libraries/cms/version/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

       }

       return $res;
    }

    private function checkDle(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/engine/engine.php')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/engine/data/config.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

          $tmp_content = @file_get_contents($this->root_path .'/install.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkIpb(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/ips_kernel')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/ips_kernel/class_xml.php');
          if (preg_match('|IP.Board\s+v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWebAsyst(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/wbs/installer')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/license.txt');
          if (preg_match('|v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkOsCommerce(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/includes/version.php')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/includes/version.php');
          if (preg_match('|([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkDrupal(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/sites/all')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/CHANGELOG.txt');
          if (preg_match('|Drupal\s+([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkMODX(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/manager/assets')) {
          $res = true;

          // no way to pick up version
       }

       return $res;
    }

    private function checkInstantCms(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/plugins/p_usertab')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/index.php');
          if (preg_match('|InstantCMS\s+v([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpBb(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/includes/acp')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/config.php');
          if (preg_match('|phpBB\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkVBulletin(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/core/admincp')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/core/api.php');
          if (preg_match('|vBulletin\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpShopScript(&$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($this->root_path .'/install/consts.php')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/install/consts.php');
          if (preg_match('|STRING_VERSION\',\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }
}

/**
 * Print file
*/
function printFile() {
	$l_FileName = $_GET['fn'];
	$l_CRC = isset($_GET['c']) ? (int)$_GET['c'] : 0;
	$l_Content = file_get_contents($l_FileName);
	$l_FileCRC = realCRC($l_Content);
	if ($l_FileCRC != $l_CRC) {
		echo 'Доступ запрещен.';
		exit;
	}
	
	echo '<pre>' . htmlspecialchars($l_Content) . '</pre>';
}

/**
 *
 */
function realCRC($str_in, $full = false)
{
        $in = crc32( $full ? normal($str_in) : $str_in );
        return ($in > CRC32_LIMIT) ? ($in - CRC32_DIFF) : $in;
}


/**
 * Determine php script is called from the command line interface
 * @return bool
 */
function isCli()
{
	return php_sapi_name() == 'cli';
}

function myCheckSum($str) {
  return str_replace('-', 'x', crc32($str));
}

/*
 *
 */
function shanonEntropy($par_Str)
{
    $dic = array();

    $len = strlen($par_Str);
    for ($i = 0; $i < $len; $i++) {
        $dic[$par_Str[$i]]++;
    } 

    $result = 0.0;
    $frequency = 0.0;
    foreach ($dic as $item)
    {
        $frequency = (float)$item / (float)$len;
        $result -= $frequency * (log($frequency) / log(2));
    }

    return $result;
}

 function generatePassword ($length = 9)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }

/**
 * Print to console
 * @param mixed $text
 * @param bool $add_lb Add line break
 * @return void
 */
function stdOut($text, $add_lb = true)
{
	global $BOOL_RESULT;

	if (!isCli())
		return;
		
	if (is_bool($text))
	{
		$text = $text ? 'true' : 'false';
	}
	else if (is_null($text))
	{
		$text = 'null';
	}
	if (!is_scalar($text))
	{
		$text = print_r($text, true);
	}

 	if (!$BOOL_RESULT)
 	{
 		@fwrite(STDOUT, $text . ($add_lb ? "\n" : ''));
 	}
}

/**
 * Print progress
 * @param int $num Current file
 */
function printProgress($num, &$par_File)
{
	global $g_CriticalPHP, $g_Base64, $g_Phishing, $g_CriticalJS, $g_Iframer;
	$total_files = $GLOBALS['g_FoundTotalFiles'];
	$elapsed_time = microtime(true) - START_TIME;
	$percent = number_format($total_files ? $num*100/$total_files : 0, 1);
	$stat = '';
	if ($elapsed_time >= 1)
	{
		$elapsed_seconds = round($elapsed_time, 0);
		$fs = floor($num / $elapsed_seconds);
		$left_files = $total_files - $num;
		if ($fs > 0) 
		{
		   $left_time = ($left_files / $fs); //ceil($left_files / $fs);
		   $stat = ' [Avg: ' . round($fs,2) . ' files/s' . ($left_time > 0  ? ' Left: ' . seconds2Human($left_time) : '') . '] [Mlw:' . (count($g_CriticalPHP) + count($g_Base64))  . '|' . (count($g_CriticalJS) + count($g_Iframer) + count($g_Phishing)) . ']';
        }
	}

	$l_FN = substr($par_File, -60);

	$text = "$percent% [$l_FN] $num of {$total_files}. " . $stat;
	$text = str_pad($text, 160, ' ', STR_PAD_RIGHT);
	stdOut(str_repeat(chr(8), 160) . $text, false);
}

/**
 * Seconds to human readable
 * @param int $seconds
 * @return string
 */
function seconds2Human($seconds)
{
	$r = '';
	$_seconds = floor($seconds);
	$ms = $seconds - $_seconds;
	$seconds = $_seconds;
	if ($hours = floor($seconds / 3600))
	{
		$r .= $hours . (isCli() ? ' h ' : ' час ');
		$seconds = $seconds % 3600;
	}

	if ($minutes = floor($seconds / 60))
	{
		$r .= $minutes . (isCli() ? ' m ' : ' мин ');
		$seconds = $seconds % 60;
	}

	if ($minutes < 3) $r .= ' ' . $seconds + ($ms > 0 ? round($ms) : 0) . (isCli() ? ' s' : ' сек'); 

	return $r;
}

if (isCli())
{

	$cli_options = array(
		'm:' => 'memory:',
		's:' => 'size:',
		'a' => 'all',
		'd:' => 'delay:',
		'l:' => 'list:',
		'r:' => 'report:',
		'f' => 'fast',
		'j:' => 'file:',
		'p:' => 'path:',
		'q' => 'quite',
		'e:' => 'cms:',
		'x:' => 'mode:',
		'k:' => 'skip:',
		'h' => 'help'
	);

	$cli_longopts = array(
		'cmd:',
		'noprefix:',
		'addprefix:',
		'one-pass',
		'quarantine',
		'with-2check'
	);
	$cli_longopts = array_merge($cli_longopts, array_values($cli_options));

	$options = getopt(implode('', array_keys($cli_options)), $cli_longopts);

	if (isset($options['h']) OR isset($options['help']))
	{
		$memory_limit = ini_get('memory_limit');
		echo <<<HELP
AI-Bolit - Script to search for shells and other malicious software.

Usage: php {$_SERVER['PHP_SELF']} [OPTIONS] [PATH]
Current default path is: {$defaults['path']}

  -j, --file=FILE      Full path to single file to check
  -l, --list=FILE      Full path to create plain text file with a list of found malware
  -p, --path=PATH      Directory path to scan, by default the file directory is used
                       Current path: {$defaults['path']}
  -m, --memory=SIZE    Maximum amount of memory a script may consume. Current value: $memory_limit
                       Can take shorthand byte values (1M, 1G...)
  -s, --size=SIZE      Scan files are smaller than SIZE. 0 - All files. Current value: {$defaults['max_size_to_scan']}
  -a, --all            Scan all files (by default scan. js,. php,. html,. htaccess)
  -d, --delay=INT      delay in milliseconds when scanning files to reduce load on the file system (Default: 1)
  -e, --cms=FILE       cms filename to load .aknown files from. E.g. --cms=wordpress
  -x, --mode=INT       Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
  -r, --report=PATH/EMAILS
                       Full path to create report or email address to send report to.
                       You can also specify multiple email separated by commas.
  -q, 		       Use only with -j. Quiet result check of file, 1=Infected 
      --cmd="command [args...]"
                       Run command after scanning
      --one-pass       Do not calculate remaining time
      --quarantine     Archive all malware from report
      --with-2check    Create or use AI-BOLIT-DOUBLECHECK.php file
      --help           Display this help and exit

* Mandatory arguments listed below are required for both full and short way of usage.

HELP;
		exit;
	}

	$l_FastCli = false;
	
	if (
		(isset($options['memory']) AND !empty($options['memory']) AND ($memory = $options['memory']))
		OR (isset($options['m']) AND !empty($options['m']) AND ($memory = $options['m']))
	)
	{
		$memory = getBytes($memory);
		if ($memory > 0)
		{
			$defaults['memory_limit'] = $memory;
			ini_set('memory_limit', $memory);
		}
	}

	if (
		(isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false)
		OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false)
	)
	{
		define('SCAN_FILE', $file);
	}


	if (
		(isset($options['list']) AND !empty($options['list']) AND ($file = $options['list']) !== false)
		OR (isset($options['l']) AND !empty($options['l']) AND ($file = $options['l']) !== false)
	)
	{

		define('PLAIN_FILE', $file);
	}
	if (
		(isset($options['size']) AND !empty($options['size']) AND ($size = $options['size']) !== false)
		OR (isset($options['s']) AND !empty($options['s']) AND ($size = $options['s']) !== false)
	)
	{
		$size = getBytes($size);
		$defaults['max_size_to_scan'] = $size > 0 ? $size : 0;
	}

 	if (
 		(isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false)
 		OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false)
 		AND (isset($options['q'])) 
 	
 	)
 	{
 		$BOOL_RESULT = true;
 	}
 
	if (isset($options['f'])) 
	 {
	   $l_FastCli = true;
	 }
		
	if (
		(isset($options['delay']) AND !empty($options['delay']) AND ($delay = $options['delay']) !== false)
		OR (isset($options['d']) AND !empty($options['d']) AND ($delay = $options['d']) !== false)
	)
	{
		$delay = (int) $delay;
		if (!($delay < 0))
		{
			$defaults['scan_delay'] = $delay;
		}
	}

	if (
		(isset($options['skip']) AND !empty($options['skip']) AND ($ext_list = $options['skip']) !== false)
		OR (isset($options['k']) AND !empty($options['k']) AND ($ext_list = $options['k']) !== false)
	)
	{
		$defaults['skip_ext'] = $ext_list;
	}

	if (isset($options['all']) OR isset($options['a']))
	{
		$defaults['scan_all_files'] = 1;
	}

    if (isset($options['cms'])) {
        define('CMS', $options['cms']);
    } else if (isset($options['e'])) {
        define('CMS', $options['e']);
    }

    if (isset($options['x'])) {
        define('AI_EXPERT', $options['x']);
    } else if (isset($options['mode'])) {
        define('AI_EXPERT', $options['mode']);
    } else {
		define('AI_EXPERT', AI_EXPERT_MODE); 
    }

	$l_SpecifiedPath = false;
	if (
		(isset($options['path']) AND !empty($options['path']) AND ($path = $options['path']) !== false)
		OR (isset($options['p']) AND !empty($options['p']) AND ($path = $options['p']) !== false)
	)
	{
		$defaults['path'] = $path;
		$l_SpecifiedPath = true;
	}

	if (
		isset($options['noprefix']) AND !empty($options['noprefix']) AND ($g_NoPrefix = $options['noprefix']) !== false)
		
	{
	} else {
		$g_NoPrefix = '';
	}

	if (
		isset($options['addprefix']) AND !empty($options['addprefix']) AND ($g_AddPrefix = $options['addprefix']) !== false)
		
	{
	} else {
		$g_AddPrefix = '';
	}



	$l_SuffixReport = str_replace('/var/www', '', $defaults['path']);
	$l_SuffixReport = str_replace('/home', '', $l_SuffixReport);
    $l_SuffixReport = preg_replace('#[/\\\.\s]#', '_', $l_SuffixReport);
	$l_SuffixReport .=  "-" . rand(1, 999999);
		
	if (
		(isset($options['report']) AND ($report = $options['report']) !== false)
		OR (isset($options['r']) AND ($report = $options['r']) !== false)
	)
	{
		$report = str_replace('@PATH@', $l_SuffixReport, $report);
		$report = str_replace('@RND@', rand(1, 999999), $report);
		$report = str_replace('@DATE@', date('d-m-Y-h-i'), $report);
		define('REPORT', $report);
	}

    $l_ReportDirName = dirname($report);
	define('QUEUE_FILENAME', ($l_ReportDirName != '' ? $l_ReportDirName . '/' : '') . 'AI-BOLIT-QUEUE-' . md5($defaults['path']) . '.txt');

	defined('REPORT') OR define('REPORT', 'AI-BOLIT-REPORT-' . $l_SuffixReport . '-' . date('d-m-Y_H-i') . '.html');

	$last_arg = max(1, sizeof($_SERVER['argv']) - 1);
	if (isset($_SERVER['argv'][$last_arg]))
	{
		$path = $_SERVER['argv'][$last_arg];
		if (
			substr($path, 0, 1) != '-'
			AND (substr($_SERVER['argv'][$last_arg - 1], 0, 1) != '-' OR array_key_exists(substr($_SERVER['argv'][$last_arg - 1], -1), $cli_options)))
		{
			$defaults['path'] = $path;
		}
	}	
	
	
	define('ONE_PASS', isset($options['one-pass']));
    
} else {
   define('AI_EXPERT', AI_EXPERT_MODE); 
   define('ONE_PASS', true);
}


OptimizeSignatures();

$g_DBShe  = array_map('strtolower', $g_DBShe);
$gX_DBShe = array_map('strtolower', $gX_DBShe);

if (!defined('PLAIN_FILE')) { define('PLAIN_FILE', ''); }

// Init
define('MAX_ALLOWED_PHP_HTML_IN_DIR', 600);
define('BASE64_LENGTH', 69);
define('MAX_PREVIEW_LEN', 80);
define('MAX_EXT_LINKS', 1001);

// Perform full scan when running from command line
if (isCli() || isset($_GET['full'])) {
  $defaults['scan_all_files'] = 1;
}

if ($l_FastCli) {
  $defaults['scan_all_files'] = 0; 
}

define('SCAN_ALL_FILES', (bool) $defaults['scan_all_files']);
define('SCAN_DELAY', (int) $defaults['scan_delay']);
define('MAX_SIZE_TO_SCAN', getBytes($defaults['max_size_to_scan']));

if ($defaults['memory_limit'] AND ($defaults['memory_limit'] = getBytes($defaults['memory_limit'])) > 0) {
	ini_set('memory_limit', $defaults['memory_limit']);
    stdOut("Changed memory limit to " . $defaults['memory_limit']);
}

define('START_TIME', microtime(true));

define('ROOT_PATH', realpath($defaults['path']));

if (!ROOT_PATH)
{
    if (isCli())  {
		die(stdOut("Directory '{$defaults['path']}' not found!"));
	}
}
elseif(!is_readable(ROOT_PATH))
{
        if (isCli())  {
		die(stdOut("Cannot read directory '" . ROOT_PATH . "'!"));
	}
}

define('CURRENT_DIR', getcwd());
chdir(ROOT_PATH);

// Проверяем отчет
if (isCli() AND REPORT !== '' AND !getEmails(REPORT))
{
	$report = str_replace('\\', '/', REPORT);
	$abs = strpos($report, '/') === 0 ? DIR_SEPARATOR : '';
	$report = array_values(array_filter(explode('/', $report)));
	$report_file = array_pop($report);
	$report_path = realpath($abs . implode(DIR_SEPARATOR, $report));

	define('REPORT_FILE', $report_file);
	define('REPORT_PATH', $report_path);

	if (REPORT_FILE AND REPORT_PATH AND is_file(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE))
	{
		@unlink(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE);
	}
}


if (function_exists('phpinfo')) {
   ob_start();
   phpinfo();
   $l_PhpInfo = ob_get_contents();
   ob_end_clean();

   $l_PhpInfo = str_replace('border: 1px', '', $l_PhpInfo);
   preg_match('|<body>(.*)</body>|smi', $l_PhpInfo, $l_PhpInfoBody);
}

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MODE@@", AI_EXPERT . '/' . SMART_SCAN, $l_Template);

if (AI_EXPERT == 0) {
   $l_Result .= '<div class="rep">' . AI_STR_057 . '</div>'; 
} else {
}

$l_Template = str_replace('@@HEAD_TITLE@@', AI_STR_051 .  $g_AddPrefix . str_replace($g_NoPrefix, '', realpath('.')), $l_Template);

define('QCR_INDEX_FILENAME', 'fn');
define('QCR_INDEX_TYPE', 'type');
define('QCR_INDEX_WRITABLE', 'wr');
define('QCR_SVALUE_FILE', '1');
define('QCR_SVALUE_FOLDER', '0');

/**
 * Extract emails from the string
 * @param string $email
 * @return array of strings with emails or false on error
 */
function getEmails($email)
{
	$email = preg_split('#[,\s;]#', $email, -1, PREG_SPLIT_NO_EMPTY);
	$r = array();
	for ($i = 0, $size = sizeof($email); $i < $size; $i++)
	{
	        if (function_exists('filter_var')) {
   		   if (filter_var($email[$i], FILTER_VALIDATE_EMAIL))
   		   {
   		   	$r[] = $email[$i];
    		   }
                } else {
                   // for PHP4
                   if (strpos($email[$i], '@') !== false) {
   		   	$r[] = $email[$i];
                   }
                }
	}
	return empty($r) ? false : $r;
}

/**
 * Get bytes from shorthand byte values (1M, 1G...)
 * @param int|string $val
 * @return int
 */
function getBytes($val)
{
	$val = trim($val);
	$last = strtolower($val{strlen($val) - 1});
	switch($last) {
		case 't':
			$val *= 1024;
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}
	return intval($val);
}

/**
 * Format bytes to human readable
 * @param int $bites
 * @return string
 */
function bytes2Human($bites)
{
	if ($bites < 1024)
	{
		return $bites . ' b';
	}
	elseif (($kb = $bites / 1024) < 1024)
	{
		return number_format($kb, 2) . ' Kb';
	}
	elseif (($mb = $kb / 1024) < 1024)
	{
		return number_format($mb, 2) . ' Mb';
	}
	elseif (($gb = $mb / 1024) < 1024)
	{
		return number_format($gb, 2) . ' Gb';
	}
	else
	{
		return number_format($gb / 1024, 2) . 'Tb';
	}
}

///////////////////////////////////////////////////////////////////////////
function needIgnore($par_FN, $par_CRC) {
  global $g_IgnoreList;
  
  for ($i = 0; $i < count($g_IgnoreList); $i++) {
     if (strpos($par_FN, $g_IgnoreList[$i][0]) !== false) {
		if ($par_CRC == $g_IgnoreList[$i][1]) {
			return true;
		}
	 }
  }
  
  return false;
}

///////////////////////////////////////////////////////////////////////////
function printList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
  
  if ($par_TableName == null) {
     $par_TableName = 'table_' . rand(1000000,9000000);
  }

  $l_Result = '';
  $l_Result .= "<div class=\"flist\"><table cellspacing=1 cellpadding=4 border=0 id=\"" . $par_TableName . "\">";

  $l_Result .= "<thead><tr class=\"tbgh" . ( $i % 2 ). "\">";
  $l_Result .= "<th width=50%>" . AI_STR_004 . "</th>";
  $l_Result .= "<th>" . AI_STR_005 . "</th>";
  $l_Result .= "<th>" . AI_STR_006 . "</th>";
  $l_Result .= "<th width=90>" . AI_STR_007 . "</th>";
  $l_Result .= "<th width=0 class=\"hidd\">CRC32</th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  
  $l_Result .= "</tr></thead><tbody>";

  for ($i = 0; $i < count($par_List); $i++) {
    if ($par_SigId != null) {
       $l_SigId = 'id_' . $par_SigId[$i];
    } else {
       $l_SigId = 'id_z' . rand(1000000,9000000);
    }
    
    $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
         	if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
         		continue;
         	}
        }
  
     $l_Creat = $g_Structure['c'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['c'][$l_Pos]) : '-';
     $l_Modif = $g_Structure['m'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['m'][$l_Pos]) : '-';
     $l_Size = $g_Structure['s'][$l_Pos] > 0 ? bytes2Human($g_Structure['s'][$l_Pos]) : '-';

     if ($par_Details != null) {
        $l_WithMarker = preg_replace('|__AI_MARKER__|smi', '<span class="marker">&nbsp;</span>', $par_Details[$i]);
        $l_WithMarker = preg_replace('|__AI_LINE1__|smi', '<span class="line_no">', $l_WithMarker);
        $l_WithMarker = preg_replace('|__AI_LINE2__|smi', '</span>', $l_WithMarker);
		
        $l_Body = '<div class="details">';

        if ($par_SigId != null) {
           $l_Body .= '<a href="#" onclick="return hsig(\'' . $l_SigId . '\')">[x]</a> ';
        }

        $l_Body .= $l_WithMarker . '</div>';
     } else {
        $l_Body = '';
     }

     $l_Result .= '<tr class="tbg' . ( $i % 2 ). '" o="' . $l_SigId .'">';
	 
	 if (is_file($g_Structure['n'][$l_Pos])) {
//		$l_Result .= '<td><div class="it"><a class="it" target="_blank" href="'. $defaults['site_url'] . 'ai-bolit.php?fn=' .
//	              $g_Structure['n'][$l_Pos] . '&ph=' . realCRC(PASS) . '&c=' . $g_Structure['crc'][$l_Pos] . '">' . $g_Structure['n'][$l_Pos] . '</a></div>' . $l_Body . '</td>';
		$l_Result .= '<td><div class="it"><a class="it">' . $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]) . '</a></div>' . $l_Body . '</td>';
	 } else {
		$l_Result .= '<td><div class="it"><a class="it">' . $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]]) . '</a></div></td>';
	 }
	 
     $l_Result .= '<td align=center><div class="ctd">' . $l_Creat . '</div></td>';
     $l_Result .= '<td align=center><div class="ctd">' . $l_Modif . '</div></td>';
     $l_Result .= '<td align=center><div class="ctd">' . $l_Size . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">-</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['c'][$l_Pos] . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['m'][$l_Pos] . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $l_SigId . '</div></td>';
     $l_Result .= '</tr>';

  }

  $l_Result .= "</tbody></table></div><div class=clear style=\"margin: 20px 0 0 0\"></div>";

  return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function printPlainList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
  
//  $l_Result = "\n#\n";

  $l_Src = array('&quot;', '&lt;', '&gt;', '&amp;');
  $l_Dst = array('"',      '<',    '>',    '&');

  for ($i = 0; $i < count($par_List); $i++) {
    $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
         	if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
         		continue;
         	}                      
        }
  

     if ($par_Details != null) {
        $l_Body = preg_replace('|(L\d+).+__AI_MARKER__|smi', '$1: ...', $par_Details[$i]);
        $l_Body = preg_replace('/[^\x21-\x7F]/', '.', $l_Body);
        $l_Body = str_replace($l_Src, $l_Dst, $l_Body);

     } else {
        $l_Body = '';
     }

	 if (is_file($g_Structure['n'][$l_Pos])) {
		 
		$l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]) . "\t\t\t" . $l_Body . "\n";
	 } else {
		$l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]]) . "\n";
	 }
	 
  }

  return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function extractValue(&$par_Str, $par_Name) {
  if (preg_match('|<tr><td class="e">\s*'.$par_Name.'\s*</td><td class="v">(.+?)</td>|sm', $par_Str, $l_Result)) {
     return str_replace('no value', '', strip_tags($l_Result[1]));
  }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ExtractInfo($par_Str) {
   $l_PhpInfoSystem = extractValue($par_Str, 'System');
   $l_PhpPHPAPI = extractValue($par_Str, 'Server API');
   $l_AllowUrlFOpen = extractValue($par_Str, 'allow_url_fopen');
   $l_AllowUrlInclude = extractValue($par_Str, 'allow_url_include');
   $l_DisabledFunction = extractValue($par_Str, 'disable_functions');
   $l_DisplayErrors = extractValue($par_Str, 'display_errors');
   $l_ErrorReporting = extractValue($par_Str, 'error_reporting');
   $l_ExposePHP = extractValue($par_Str, 'expose_php');
   $l_LogErrors = extractValue($par_Str, 'log_errors');
   $l_MQGPC = extractValue($par_Str, 'magic_quotes_gpc');
   $l_MQRT = extractValue($par_Str, 'magic_quotes_runtime');
   $l_OpenBaseDir = extractValue($par_Str, 'open_basedir');
   $l_RegisterGlobals = extractValue($par_Str, 'register_globals');
   $l_SafeMode = extractValue($par_Str, 'safe_mode');


   $l_DisabledFunction = ($l_DisabledFunction == '' ? '-?-' : $l_DisabledFunction);
   $l_OpenBaseDir = ($l_OpenBaseDir == '' ? '-?-' : $l_OpenBaseDir);

   $l_Result = '<div class="title">' . AI_STR_008 . ': ' . phpversion() . '</div>';
   $l_Result .= 'System Version: <span class="php_ok">' . $l_PhpInfoSystem . '</span><br/>';
   $l_Result .= 'PHP API: <span class="php_ok">' . $l_PhpPHPAPI. '</span><br/>';
   $l_Result .= 'allow_url_fopen: <span class="php_' . ($l_AllowUrlFOpen == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlFOpen. '</span><br/>';
   $l_Result .= 'allow_url_include: <span class="php_' . ($l_AllowUrlInclude == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlInclude. '</span><br/>';
   $l_Result .= 'disable_functions: <span class="php_' . ($l_DisabledFunction == '-?-' ? 'bad' : 'ok') . '">' . $l_DisabledFunction. '</span><br/>';
   $l_Result .= 'display_errors: <span class="php_' . ($l_DisplayErrors == 'On' ? 'ok' : 'bad') . '">' . $l_DisplayErrors. '</span><br/>';
   $l_Result .= 'error_reporting: <span class="php_ok">' . $l_ErrorReporting. '</span><br/>';
   $l_Result .= 'expose_php: <span class="php_' . ($l_ExposePHP == 'On' ? 'bad' : 'ok') . '">' . $l_ExposePHP. '</span><br/>';
   $l_Result .= 'log_errors: <span class="php_' . ($l_LogErrors == 'On' ? 'ok' : 'bad') . '">' . $l_LogErrors . '</span><br/>';
   $l_Result .= 'magic_quotes_gpc: <span class="php_' . ($l_MQGPC == 'On' ? 'ok' : 'bad') . '">' . $l_MQGPC. '</span><br/>';
   $l_Result .= 'magic_quotes_runtime: <span class="php_' . ($l_MQRT == 'On' ? 'bad' : 'ok') . '">' . $l_MQRT. '</span><br/>';
   $l_Result .= 'register_globals: <span class="php_' . ($l_RegisterGlobals == 'On' ? 'bad' : 'ok') . '">' . $l_RegisterGlobals . '</span><br/>';
   $l_Result .= 'open_basedir: <span class="php_' . ($l_OpenBaseDir == '-?-' ? 'bad' : 'ok') . '">' . $l_OpenBaseDir . '</span><br/>';
   
   if (phpversion() < '5.3.0') {
      $l_Result .= 'safe_mode (PHP < 5.3.0): <span class="php_' . ($l_SafeMode == 'On' ? 'ok' : 'bad') . '">' . $l_SafeMode. '</span><br/>';
   }

   return $l_Result . '<p>';
}

///////////////////////////////////////////////////////////////////////////
function QCR_Debug($par_Str = "") {
  if (!DEBUG_MODE) {
     return;
  }

  $l_MemInfo = ' ';  
  if (function_exists('memory_get_usage')) {
     $l_MemInfo .= ' curmem=' .  bytes2Human(memory_get_usage());
  }

  if (function_exists('memory_get_peak_usage')) {
     $l_MemInfo .= ' maxmem=' .  bytes2Human(memory_get_peak_usage());
  }

  stdOut("\n" . date('H:i:s') . ': ' . $par_Str . $l_MemInfo . "\n");
}


///////////////////////////////////////////////////////////////////////////
function QCR_ScanDirectories($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, 
			$defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, 
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SensitiveFiles, 
						$g_SuspiciousFiles;

	static $l_Buffer = '';

	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;

	QCR_Debug('Scan ' . $l_RootDir);

        $l_QuotedSeparator = quotemeta(DIR_SEPARATOR); 
 	if ($l_DIRH = @opendir($l_RootDir))
	{
		while (($l_FileName = readdir($l_DIRH)) !== false)
		{
			if ($l_FileName == '.' || $l_FileName == '..') continue;

			$l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;

			$l_Type = filetype($l_FileName);
            if ($l_Type == "link") 
                        {
                            $g_SymLinks[] = $l_FileName;
                            continue;
                        } else
						
						if ($l_Type != "file" && $l_Type != "dir" ) {
							//$g_UnixExec[] = $l_FileName;
							continue;
						}	
						
			$l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);
			$l_IsDir = is_dir($l_FileName);
			/*
			if (in_array($l_Ext, $g_SuspiciousFiles)) 
			{
                $g_UnixExec[] = $l_FileName;
            }
*/

			// which files should be scanned
			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, $g_SensitiveFiles));
			
			$l_Ext2 = substr(strstr($l_FileName, '.'), 1);
			if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                           $l_NeedToScan = false;
                        }


			if ($l_IsDir)
			{
				// if folder in ignore list
				$l_Skip = false;
				for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
					if (($g_DirIgnoreList[$dr] != '') &&
						preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
						$l_Skip = true;
					}
				}
			
				// skip on ignore
				if ($l_Skip) {
					$g_SkippedFolders[] = $l_FileName;
					continue;
				}
				
				$l_BaseName = basename($l_FileName);

				if ((strpos($l_BaseName, '.') === 0) && ($l_BaseName != '.htaccess')) {
	               $g_HiddenFiles[] = $l_FileName;
	            }

//				$g_Structure['d'][$g_Counter] = $l_IsDir;
//				$g_Structure['n'][$g_Counter] = $l_FileName;
				if (ONE_PASS) {
					$g_Structure['n'][$g_Counter] = $l_FileName . DIR_SEPARATOR;
				} else {
					$l_Buffer .= $l_FileName . DIR_SEPARATOR . "\n";
				}

				$l_DirCounter++;

				if ($l_DirCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
				{
					$g_Doorway[] = $l_SourceDirIndex;
					$l_DirCounter = -655360;
				}

				$g_Counter++;
				$g_FoundTotalDirs++;

				QCR_ScanDirectories($l_FileName);

			} else
			{
				if ($l_NeedToScan)
				{
					$g_FoundTotalFiles++;
					if (in_array($l_Ext, array(
						'php', 'php3',
						'php4', 'php5', 'html', 'htm', 'phtml', 'shtml', 'khtml'
					))
					)
					{
						$l_DoorwayFilesCounter++;
						
						if ($l_DoorwayFilesCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
						{
							$g_Doorway[] = $l_SourceDirIndex;
							$l_DoorwayFilesCounter = -655360;
						}
					}

					if (ONE_PASS) {
						QCR_ScanFile($l_FileName, $g_Counter++);
					} else {
						$l_Buffer .= $l_FileName."\n";
					}

					$g_Counter++;
				}
			}

			if (strlen($l_Buffer) > 32000)
			{ 
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".QUEUE_FILENAME);
				$l_Buffer = '';
			}

		}

		closedir($l_DIRH);
	}
	
	if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . QUEUE_FILENAME);
		$l_Buffer = '';                                                                            
	}

}


///////////////////////////////////////////////////////////////////////////
function getFragment($par_Content, $par_Pos) {
  $l_MaxChars = MAX_PREVIEW_LEN;
  $l_MaxLen = strlen($par_Content);
  $l_RightPos = min($par_Pos + $l_MaxChars, $l_MaxLen); 
  $l_MinPos = max(0, $par_Pos - $l_MaxChars);

  $l_FoundStart = substr($par_Content, 0, $par_Pos);
  $l_FoundStart = str_replace("\r", '', $l_FoundStart);
  $l_LineNo = strlen($l_FoundStart) - strlen(str_replace("\n", '', $l_FoundStart)) + 1;

  $par_Content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '~', $par_Content);

  $l_Res = '__AI_LINE1__' . $l_LineNo . "__AI_LINE2__  " . ($l_MinPos > 0 ? '…' : '') . substr($par_Content, $l_MinPos, $par_Pos - $l_MinPos) . 
           '__AI_MARKER__' . 
           substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);

  $l_Res = htmlspecialchars(UnwrapObfu($l_Res), ENT_COMPAT|ENT_IGNORE);
  $l_Res = str_replace('~', '·', $l_Res);

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function escapedHexToHex($escaped)
{ $GLOBALS['g_EncObfu']++; return chr(hexdec($escaped[1])); }
function escapedOctDec($escaped)
{ $GLOBALS['g_EncObfu']++; return chr(octdec($escaped[1])); }
function escapedDec($escaped)
{ $GLOBALS['g_EncObfu']++; return chr($escaped[1]); }

///////////////////////////////////////////////////////////////////////////
if (!defined('T_ML_COMMENT')) {
   define('T_ML_COMMENT', T_COMMENT);
} else {
   define('T_DOC_COMMENT', T_ML_COMMENT);
}

function UnwrapObfu($par_Content) {
  $GLOBALS['g_EncObfu'] = 0;
  
  $search  = array( ' ;', ' =', ' ,', ' .', ' (', ' )', ' {', ' }', '; ', '= ', ', ', '. ', '( ', '( ', '{ ', '} ');
  $replace = array(  ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}', ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}');
  $par_Content = str_replace('@', '', $par_Content);
  $par_Content = preg_replace('~\s+~', ' ', $par_Content);
  $par_Content = str_replace($search, $replace, $par_Content);
  $par_Content = preg_replace_callback('~\bchr\(\s*([0-9a-fA-FxX]+)\s*\)~', function ($m) { return "'".chr(intval($m[1], 0))."'"; }, $par_Content );

  $par_Content = preg_replace_callback('/\\\\x([a-fA-F0-9]{1,2})/i','escapedHexToHex', $par_Content);
  $par_Content = preg_replace_callback('/\\\\([0-9]{1,3})/i','escapedOctDec', $par_Content);

  $par_Content = preg_replace('/[\'"]\s*?\.+\s*?[\'"]/smi', '', $par_Content);

  return $par_Content;
}


///////////////////////////////////////////////////////////////////////////
// Unicode BOM is U+FEFF, but after encoded, it will look like this.
define ('UTF32_BIG_ENDIAN_BOM'   , chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));
define ('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));
define ('UTF16_BIG_ENDIAN_BOM'   , chr(0xFE) . chr(0xFF));
define ('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));
define ('UTF8_BOM'               , chr(0xEF) . chr(0xBB) . chr(0xBF));

function detect_utf_encoding($text) {
    $first2 = substr($text, 0, 2);
    $first3 = substr($text, 0, 3);
    $first4 = substr($text, 0, 3);
    
    if ($first3 == UTF8_BOM) return 'UTF-8';
    elseif ($first4 == UTF32_BIG_ENDIAN_BOM) return 'UTF-32BE';
    elseif ($first4 == UTF32_LITTLE_ENDIAN_BOM) return 'UTF-32LE';
    elseif ($first2 == UTF16_BIG_ENDIAN_BOM) return 'UTF-16BE';
    elseif ($first2 == UTF16_LITTLE_ENDIAN_BOM) return 'UTF-16LE';

    return false;
}

///////////////////////////////////////////////////////////////////////////
function QCR_SearchPHP($src)
{
  if (preg_match("/(<\?php[\w\s]{5,})/smi", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
	  return $l_Found[0][1];
  }

  if (preg_match("/(<script[^>]*language\s*=\s*)('|\"|)php('|\"|)([^>]*>)/i", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
    return $l_Found[0][1];
  }

  return false;
}


///////////////////////////////////////////////////////////////////////////
function knowUrl($par_URL) {
  global $g_UrlIgnoreList;

  for ($jk = 0; $jk < count($g_UrlIgnoreList); $jk++) {
     if  (stripos($par_URL, $g_UrlIgnoreList[$jk]) !== false) {
     	return true;
     }
  }

  return false;
}

///////////////////////////////////////////////////////////////////////////

function makeSummary($par_Str, $par_Number, $par_Style) {
   return '<tr><td class="' . $par_Style . '" width=400>' . $par_Str . '</td><td class="' . $par_Style . '">' . $par_Number . '</td></tr>';
}

///////////////////////////////////////////////////////////////////////////

function CheckVulnerability($par_Filename, $par_Index, $par_Content) {
    global $g_Vulnerable;
	
	$l_Vuln = array();
	
	if ((stripos($par_Filename, 'editor/filemanager/upload/test.html') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/browser/default/connectors/php/') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/connectors/uploadtest.html') !== false) ||
	   (stripos($par_Filename, 'editor/filemanager/browser/default/connectors/test.html') !== false)) {
		$l_Vuln['id'] = 'AFU : FCKEDITOR : http://www.exploit-db.com/exploits/17644/ & /exploit/249';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		return true;
	}

	if ((stripos($par_Filename, 'inc_php/image_view.class.php') !== false) ||
	    (stripos($par_Filename, '/inc_php/framework/image_view.class.php') !== false)) {
		if (strpos($par_Content, 'showImageByID') === false) {
			$l_Vuln['id'] = 'AFU : REVSLIDER : http://www.exploit-db.com/exploits/35385/';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (stripos($par_Filename, 'includes/database/database.inc') !== false) {
		if (strpos($par_Content, 'foreach ($data as $i => $value)') !== false) {
			$l_Vuln['id'] = 'SQLI : DRUPAL : CVE-2014-3704';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (stripos($par_Filename, 'engine/classes/min/index.php') !== false) {
		if (stripos($par_Content, 'tr_replace(chr(0)') === false) {
			$l_Vuln['id'] = 'AFD : MINIFY : CVE-2013-6619';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (( stripos($par_Filename, 'timthumb.php') !== false ) || 
	    ( stripos($par_Filename, 'thumb.php') !== false ) || 
	    ( stripos($par_Filename, 'cache.php') !== false ) || 
	    ( stripos($par_Filename, '_img.php') !== false )) {
		if (strpos($par_Content, 'code.google.com/p/timthumb') !== false && strpos($par_Content, '2.8.14') === false ) {
			$l_Vuln['id'] = 'RCE : TIMTHUMB : CVE-2011-4106,CVE-2014-4663';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (stripos($par_Filename, 'fancybox-for-wordpress/fancybox.php') !== false) {
		if (strpos($par_Content, '\'reset\' == $_REQUEST[\'action\']') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : FANCYBOX';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (stripos($par_Filename, 'tiny_mce/plugins/tinybrowser/tinybrowser.php') !== false) {	
		$l_Vuln['id'] = 'AFU : TINYMCE : http://www.exploit-db.com/exploits/9296/';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		
		return true;
	}

	if (stripos($par_Filename, 'scripts/setup.php') !== false) {		
		if (strpos($par_Content, 'PMA_Config') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : PHPMYADMIN : http://1337day.com/exploit/5334';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (stripos($par_Filename, '/uploadify.php') !== false) {		
		if (strpos($par_Content, 'move_uploaded_file($tempFile,$targetFile') !== false) {
			$l_Vuln['id'] = 'AFU : UPLOADIFY : CVE: 2012-1153';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

}

///////////////////////////////////////////////////////////////////////////
function QCR_GoScan($par_Offset)
{
	global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, 
		   $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList,
		   $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, 
		   $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, 
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList,$g_Vulnerable;

    QCR_Debug('QCR_GoScan ' . $par_Offset);

	$i = 0;
	
	try {
		$s_file = new SplFileObject(QUEUE_FILENAME);
		$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

		foreach ($s_file as $l_Filename) {
			QCR_ScanFile($l_Filename, $i++);
		}
		
		unset($s_file);	
	}
	catch (Exception $e) { QCR_Debug( $e->getMessage() ); }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ScanFile($l_Filename, $i = 0)
{
	global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, 
		   $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList,
		   $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, 
		   $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, 
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList,$g_Vulnerable;

	global $g_CRC;
	static $_files_and_ignored = 0;

			$l_CriticalDetected = false;
			$l_Stat = stat($l_Filename);

			if (substr($l_Filename, -1) == DIR_SEPARATOR) {
				// FOLDER
				$g_Structure['n'][$i] = $l_Filename;
				$g_TotalFolder++;
				printProgress($_files_and_ignored, $l_Filename);
				return;
			}

			QCR_Debug('Scan file ' . $l_Filename);
			printProgress(++$_files_and_ignored, $l_Filename);

			// FILE
			if ((MAX_SIZE_TO_SCAN > 0 AND $l_Stat['size'] > MAX_SIZE_TO_SCAN) || ($l_Stat['size'] < 0))
			{
				$g_BigFiles[] = $i;
				AddResult($l_Filename, $i);
			}
			else
			{
				$g_TotalFiles++;

			$l_TSStartScan = microtime(true);

		if (filetype($l_Filename) == 'file') {
                   $l_Content = @file_get_contents($l_Filename);
                   $l_Unwrapped = @php_strip_whitespace($l_Filename);
                }

                if (($l_Content == '') && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult($l_Filename, $i);
                }

				// ignore itself
				if (strpos($l_Content, 'H24LKHLKJHKLHJGJG4567869869GGHJ') !== false) {
					return;
				}

				// unix executables
				if (strpos($l_Content, chr(127) . 'ELF') !== false) 
				{
                    $g_UnixExec[] = $l_Filename;
					return;
                }

				$g_CRC = realCRC($l_Content);

                                $l_KnownCRC = $g_CRC + realCRC(basename($l_Filename));
                                if ( isset($g_KnownList[$l_KnownCRC]) ) {
	        		   //printProgress(++$_files_and_ignored, $l_Filename);
                                   return;
                                }

				$l_UnicodeContent = detect_utf_encoding($l_Content);
				//$l_Unwrapped = $l_Content;
				if ($l_UnicodeContent !== false) {
       				   if (function_exists('mb_convert_encoding')) {
                                      $l_Unwrapped = mb_convert_encoding($l_Unwrapped, "CP1251");
                                   } else {
                                      $g_NotRead[] = $i;
                                      AddResult($l_Filename, $i);
				   }
                                }

				$l_Unwrapped = UnwrapObfu($l_Unwrapped);
				
				// check vulnerability in files
				$l_CriticalDetected = CheckVulnerability($l_Filename, $i, $l_Content);
				
				// critical
				$g_SkipNextCheck = false;
				if (CriticalPHP($l_Filename, $i, $l_Unwrapped, $l_Pos, $l_SigId))
				{
					$g_CriticalPHP[] = $i;
					$g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
					$g_CriticalPHPSig[] = $l_SigId;
					$g_SkipNextCheck = true;
				} else {
         				if (CriticalPHP($l_Filename, $i, $l_Content, $l_Pos, $l_SigId))
         				{
         					$g_CriticalPHP[] = $i;
         					$g_CriticalPHPFragment[] = getFragment($l_Content, $l_Pos);
							$g_CriticalPHPSig[] = $l_SigId;
         					$g_SkipNextCheck = true;
         				}
				}

				$l_TypeDe = 0;
			    if ((!$g_SkipNextCheck) && HeuristicChecker($l_Content, $l_TypeDe, $l_Filename)) {
					$g_HeuristicDetected[] = $i;
					$g_HeuristicType[] = $l_TypeDe;
					$l_CriticalDetected = true;
				}

				// critical JS
				if (!$g_SkipNextCheck) {
					$l_Pos = CriticalJS($l_Filename, $i, $l_Unwrapped, $l_SigId);
					if ($l_Pos !== false)
					{
						$g_CriticalJS[] = $i;
						$g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$g_CriticalJSSig[] = $l_SigId;
						$g_SkipNextCheck = true;
					}
			    }

				// phishing
				if (!$g_SkipNextCheck) {
					$l_Pos = Phishing($l_Filename, $i, $l_Unwrapped, $l_SigId);
					if ($l_Pos !== false)
					{
						$g_Phishing[] = $i;
						$g_PhishingFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$g_PhishingSigFragment[] = $l_SigId;
						$g_SkipNextCheck = true;
					}
				}

			
			if (!$g_SkipNextCheck) {
				if (SCAN_ALL_FILES || stripos($l_Filename, 'index.'))
				{
					// check iframes
					if (preg_match_all('|<iframe[^>]+src.+?>|smi', $l_Unwrapped, $l_Found, PREG_SET_ORDER)) 
					{
						for ($kk = 0; $kk < count($l_Found); $kk++) {
						    $l_Pos = stripos($l_Found[$kk][0], 'http://');
						    $l_Pos = $l_Pos || stripos($l_Found[$kk][0], 'https://');
						    $l_Pos = $l_Pos || stripos($l_Found[$kk][0], 'ftp://');
							if  (($l_Pos !== false ) && (!knowUrl($l_Found[$kk][0]))) {
         						$g_Iframer[] = $i;
         						$g_IframerFragment[] = getFragment($l_Found[$kk][0], $l_Pos);
         						$l_CriticalDetected = true;
							}
						}
					}

					// check empty links
					if ((($defaults['report_mask'] & REPORT_MASK_SPAMLINKS) == REPORT_MASK_SPAMLINKS) &&
					   (preg_match_all('|<a[^>]+href([^>]+?)>(.*?)</a>|smi', $l_Unwrapped, $l_Found, PREG_SET_ORDER)))
					{
						for ($kk = 0; $kk < count($l_Found); $kk++) {
							if  ((stripos($l_Found[$kk][1], 'http://') !== false) &&
                                                            (trim(strip_tags($l_Found[$kk][2])) == '')) {

								$l_NeedToAdd = true;

							    if  ((stripos($l_Found[$kk][1], $default['site_url']) !== false)
                                                                 || knowUrl($l_Found[$kk][1])) {
										$l_NeedToAdd = false;
								}
								
								if ($l_NeedToAdd && (count($g_EmptyLink) < MAX_EXT_LINKS)) {
									$g_EmptyLink[] = $i;
									$g_EmptyLinkSrc[$i][] = substr($l_Found[$kk][0], 0, MAX_PREVIEW_LEN);
									$l_CriticalDetected = true;
								}
							}
						}
					}
				}

				// check for PHP code inside any type of file
				if (stripos($l_Filename, '.ph') === false)
				{
					$l_Pos = QCR_SearchPHP($l_Content);
					if ($l_Pos !== false)
					{
						$g_PHPCodeInside[] = $i;
						$g_PHPCodeInsideFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$l_CriticalDetected = true;
					}
				}

				// htaccess
				if (stripos($l_Filename, '.htaccess'))
				{
				
					if (stripos($l_Content, 'index.php?name=$1') !== false ||
						stripos($l_Content, 'index.php?m=1') !== false
					)
					{
						$g_SuspDir[] = $i;
					}

					$l_HTAContent = preg_replace('|^\s*#.+$|m', '', $l_Content);

					$l_Pos = stripos($l_Content, 'auto_prepend_file');
					if ($l_Pos !== false) {
						$g_Redirect[] = $i;
						$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}
					
					$l_Pos = stripos($l_Content, 'auto_append_file');
					if ($l_Pos !== false) {
						$g_Redirect[] = $i;
						$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}

					$l_Pos = stripos($l_Content, '^(%2d|-)[^=]+$');
					if ($l_Pos !== false)
					{
						$g_Redirect[] = $i;
                        $g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}

					if (!$l_CriticalDetected) {
						$l_Pos = stripos($l_Content, '%{HTTP_USER_AGENT}');
						if ($l_Pos !== false)
						{
							$g_Redirect[] = $i;
							$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
							$l_CriticalDetected = true;
						}
					}

					if (!$l_CriticalDetected) {
						if (
							preg_match_all('|(RewriteCond\s+%\{HTTP_HOST\}/%1 \!\^\[w\.\]\*\(\[\^/\]\+\)/\\\1\$\s+\[NC\])|smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)
						   )
						{
							$g_Redirect[] = $i;
							$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Found[0][1]);
							$l_CriticalDetected = true;
						}
					}
					
					if (!$l_CriticalDetected) {
						if (
							preg_match_all("|RewriteRule\s+.+?\s+http://(.+?)/.+\s+\[.*R=\d+.*\]|smi", $l_HTAContent, $l_Found, PREG_SET_ORDER)
						)
						{
							$l_Host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
							for ($j = 0; $j < sizeof($l_Found); $j++)
							{
								$l_Found[$j][1] = str_replace('www.', '', $l_Found[$j][1]);
								if ($l_Found[$j][1] != $l_Host)
								{
									$g_Redirect[] = $i;
									$l_CriticalDetected = true;
									break;
								}
							}
						}
					}

					unset($l_HTAContent);
			    }
			

			    // warnings
				$l_Pos = '';
				
			    if (WarningPHP($l_Filename, $l_Unwrapped, $l_Pos, $l_SigId))
				{       
					$l_Prio = 1;
					if (strpos($l_Filename, '.ph') !== false) {
					   $l_Prio = 0;
					}
					
					$g_WarningPHP[$l_Prio][] = $i;
					$g_WarningPHPFragment[$l_Prio][] = getFragment($l_Content, $l_Pos);
					$g_WarningPHPSig[] = $l_SigId;
					$l_CriticalDetected = true;
				}
				

				// adware
				if (Adware($l_Filename, $l_Unwrapped, $l_Pos))
				{
					$g_AdwareList[] = $i;
					$g_AdwareListFragment[] = getFragment($l_Unwrapped, $l_Pos);
					$l_CriticalDetected = true;
				}

				// articles
				if (stripos($l_Filename, 'article_index'))
				{
					$g_AdwareSig[] = $i;
					$l_CriticalDetected = true;
				}
			}
		} // end of if (!$g_SkipNextCheck) {
			
			unset($l_Unwrapped);
			unset($l_Content);
			
			//printProgress(++$_files_and_ignored, $l_Filename);

			$l_TSEndScan = microtime(true);
			$l_Elapsed = $l_TSEndScan - $l_TSStartScan;
                        if ($l_TSEndScan - $l_TSStartScan >= 0.5) {
			   usleep(SCAN_DELAY * 1000);
                        }

			if ($g_SkipNextCheck || $l_CriticalDetected) {
				AddResult($l_Filename, $i);
			}


}

function AddResult($l_Filename, $i)
{
	global $g_Structure, $g_CRC;
	
	$l_Stat = stat($l_Filename);
	$g_Structure['n'][$i] = $l_Filename;
	$g_Structure['s'][$i] = $l_Stat['size'];
	$g_Structure['c'][$i] = $l_Stat['ctime'];
	$g_Structure['m'][$i] = $l_Stat['mtime'];
	$g_Structure['crc'][$i] = $g_CRC;
}

///////////////////////////////////////////////////////////////////////////
function WarningPHP($l_FN, $l_Content, &$l_Pos, &$l_SigId)
{
	   global $g_SusDB,$g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;

  $l_Res = false;

  if (AI_EXTRA_WARN) {
  	foreach ($g_SusDB as $l_Item) {
    	if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       	 	if (!CheckException($l_Content, $l_Found)) {
           	 	$l_Pos = $l_Found[0][1];
           	 	$l_SigId = myCheckSum($l_Item);
           	 	return true;
       	 	}
    	}
  	}
  }

  if (AI_EXPERT < 2) {
    	foreach ($gXX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
             	$l_SigId = myCheckSum($l_Item);
        	    return true;
	  		}
    	}

	}

    if (AI_EXPERT < 1) {
    	foreach ($gX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
             	$l_SigId = myCheckSum($l_Item);
        	    return true;
	  		}
    	}

	    $l_Content_lo = strtolower($l_Content);

	    foreach ($gX_DBShe as $l_Item) {
	      $l_Pos = strpos($l_Content_lo, $l_Item);
	      if ($l_Pos !== false) {
	         $l_SigId = myCheckSum($l_Item);
	         return true;
	      }
		}
	}

}

///////////////////////////////////////////////////////////////////////////
function Adware($l_FN, $l_Content, &$l_Pos)
{
  global $g_AdwareSig;

  $l_Res = false;

  foreach ($g_AdwareSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           return true;
       }
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CheckException(&$l_Content, &$l_Found) {
  global $g_ExceptFlex, $gX_FlexDBShe, $gXX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;
   $l_FoundStrPlus = substr($l_Content, max($l_Found[0][1] - 10, 0), 70);

   foreach ($g_ExceptFlex as $l_ExceptItem) {
      if (@preg_match('#(' . $l_ExceptItem . ')#smi', $l_FoundStrPlus, $l_Detected)) {
         $l_Exception = true;
         return true;
      }
   }

   return false;
}

///////////////////////////////////////////////////////////////////////////
function Phishing($l_FN, $l_Index, $l_Content, &$l_SigId)
{
  global $g_PhishingSig, $g_PhishFiles, $g_PhishEntries;

  $l_Res = false;

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

if ($l_SkipCheck) {
  	foreach($g_PhishFiles as $l_Ext) {
  		  if (strpos($l_FN, $l_Ext) !== false) {
		  			$l_SkipCheck = false;
		  		  	break;
  	  	  }
  	  }
  }

  // need check file (by signatures) ?
  if ($l_SkipCheck && preg_match('~' . $g_PhishEntries . '~smiS', $l_Content, $l_Found)) {
	  $l_SkipCheck = false;
  }

  if ($l_SkipCheck && SMART_SCAN) {
      if (DEBUG_MODE) {
         echo "Skipped phs file, not critical.\n";
      }

	  return false;
  }


  foreach ($g_PhishingSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "Phis: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CriticalJS($l_FN, $l_Index, $l_Content, &$l_SigId)
{
  global $g_JSVirSig, $gX_JSVirSig, $g_VirusFiles, $g_VirusEntries;

  $l_Res = false;
  
    // need check file (by extension) ?
    $l_SkipCheck = SMART_SCAN;
	
	if ($l_SkipCheck) {
    	foreach($g_VirusFiles as $l_Ext) {
    		  if (strpos($l_FN, $l_Ext) !== false) {
  		  			$l_SkipCheck = false;
  		  		  	break;
    	  	  }
    	  }
	  }
  
    // need check file (by signatures) ?
    if ($l_SkipCheck && preg_match('~' . $g_VirusEntries . '~smiS', $l_Content, $l_Found)) {
  	  $l_SkipCheck = false;
    }
  
    if ($l_SkipCheck && SMART_SCAN) {
        if (DEBUG_MODE) {
           echo "Skipped js file, not critical.\n";
        }

  	  return false;
    }
  

  foreach ($g_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "JS: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }

if (AI_EXPERT > 1) {
  foreach ($gX_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "JS PARA: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }
}

  return $l_Res;
}


////////////////////////////////////////////////////////////////////////////
define('SUSP_MTIME', 1); // suspicious mtime (greater than ctime)
define('SUSP_PERM', 2); // suspicious permissions 
define('SUSP_PHP_IN_UPLOAD', 3); // suspicious .php file in upload or image folder 

  function get_descr_heur($type) {
     switch ($type) {
	     case SUSP_MTIME: return AI_STR_077; 
	     case SUSP_PERM: return AI_STR_078;  
	     case SUSP_PHP_IN_UPLOAD: return AI_STR_079; 
	 }
	 
	 return "---";
  }

  ///////////////////////////////////////////////////////////////////////////
  function HeuristicChecker($l_Content, &$l_Type, $l_Filename) {
     $res = false;
	 
	 $l_Stat = stat($l_Filename);
	 // most likely changed by touch
	 if ($l_Stat['ctime'] < $l_Stat['mtime']) {
	     $l_Type = SUSP_MTIME;
		 return true;
	 }

	 	 
	 $l_Perm = fileperms($l_Filename) & 0777;
	 if (($l_Perm & 0400 != 0400) || // not readable by owner
		($l_Perm == 0000) ||
		($l_Perm == 0404) ||
		($l_Perm == 0505))
	 {
		 $l_Type = SUSP_PERM;
		 return true;
	 }

	 
     if ((strpos($l_Filename, '.ph')) && (
	     strpos($l_Filename, '/images/stories/') ||
	     //strpos($l_Filename, '/img/') ||
		 //strpos($l_Filename, '/images/') ||
	     //strpos($l_Filename, '/uploads/') ||
		 strpos($l_Filename, '/wp-content/upload/') 
	    )	    
	 ) {
		$l_Type = SUSP_PHP_IN_UPLOAD;
	 	return true;
	 }

	 	 
	 /*
•	стартует с цифры
•	кол-во цифр в подстроке > 50%
•	паттерн <строчные символы или цифры><2+ заглавные>
•	паттерн <цифры><1-3 символов><цифра>
•	паттерн <символ><3+ цифры><символ>
•	паттерн <символ><4+ цифры>
•	нет гласных букв в строке
•	есть заглавные, строчные и цифры
•	три гласных подряд
•	две цифры не рядом
	 */
	 

     return false;
  }

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index, $l_Content, &$l_Pos, &$l_SigId)
{
  global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment,
  $g_CriticalFiles, $g_CriticalEntries;

  // H24LKHLKJHKLHJGJG4567869869GGHJ

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

  if ($l_SkipCheck) {
	  foreach($g_CriticalFiles as $l_Ext) {
  	  	if (strpos($l_FN, $l_Ext) !== false) {
			  $l_SkipCheck = false;
		  	break;
  	  		}
  		}
	}
  
  // need check file (by signatures) ?
  if ($l_SkipCheck && preg_match('~' . $g_CriticalEntries . '~smiS', $l_Content, $l_Found)) {
	  $l_SkipCheck = false;
  }
  
  
  if (strpos($l_FN, '.php.') !== false ) {
     $g_Base64[] = $l_Index;
     $g_Base64Fragment[] = '".php."';
     $l_Pos = 0;

     if (DEBUG_MODE) {
          echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     AddResult($l_FN, $l_Index);
  }

 
  // if not critical - skip it 
  if ($l_SkipCheck && SMART_SCAN) {
      if (DEBUG_MODE) {
         echo "Skipped file, not critical.\n";
      }

	  return false;
  }

  foreach ($g_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 1: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }

if (AI_EXPERT > 1) {
  foreach ($gXX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 2: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }
}

if (AI_EXPERT > 0) {
  foreach ($gX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 3: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }
}

  $l_Content_lo = strtolower($l_Content);

  foreach ($g_DBShe as $l_Item) {
    $l_Pos = strpos($l_Content_lo, $l_Item);
    if ($l_Pos !== false) {
       $l_SigId = myCheckSum($l_Item);

       if (DEBUG_MODE) {
          echo "CRIT 4: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       return true;
    }
  }

if (AI_EXPERT) {
  foreach ($gX_DBShe as $l_Item) {
    $l_Pos = strpos($l_Content_lo, $l_Item);
    if ($l_Pos !== false) {
       $l_SigId = myCheckSum($l_Item);

       if (DEBUG_MODE) {
          echo "CRIT 5: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       return true;
    }
  }

  if ((strpos($l_FN, '.ph') !== false) && (AI_EXPERT > 1)) {
     // for php only
     $g_Specials = array(');#');

     foreach ($g_Specials as $l_Item) {
       $l_Pos = stripos($l_Content, $l_Item);
       if ($l_Pos !== false) {
          $l_SigId = myCheckSum($l_Item);
          return true;
       }
     }
  }

}

  if ((strpos($l_Content, 'GIF89') === 0) && (strpos($l_FN, '.php') !== false )) {
     $l_Pos = 0;

     if (DEBUG_MODE) {
          echo "CRIT 6: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     return true;
  }

  // detect uploaders / droppers
if (AI_EXPERT > 1) {
  $l_Found = null;
  if (
     (filesize($l_FN) < 1024) &&
     (strpos($l_FN, '.ph') !== false) &&
     (
       (($l_Pos = strpos($l_Content, 'multipart/form-data')) > 0) || 
       (($l_Pos = strpos($l_Content, '$_FILE[') > 0)) ||
       (($l_Pos = strpos($l_Content, 'move_uploaded_file')) > 0) ||
       (preg_match('|\bcopy\s*\(|smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE))
     )
     ) {
       if ($l_Found != null) {
          $l_Pos = $l_Found[0][1];
       } 
     if (DEBUG_MODE) {
          echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     return true;
  }
}

  // count number of base64_decode entries
  $l_Count = substr_count($l_Content, 'base64_decode');
  if ($l_Count > 10) {
     $g_Base64[] = $l_Index;
     $g_Base64Fragment[] = getFragment($l_Content, stripos($l_Content, 'base64_decode'));

     if (DEBUG_MODE) {
        echo "CRIT 10: $l_FN matched\n";
     }

     AddResult($l_FN, $l_Index);
  }

  return false;
}

///////////////////////////////////////////////////////////////////////////
if (!isCli()) {
   header('Content-type: text/html; charset=utf-8');
}

if (!isCli()) {

  $l_PassOK = false;
  if (strlen(PASS) > 8) {
     $l_PassOK = true;   
  } 

  if ($l_PassOK && preg_match('|[0-9]|', PASS, $l_Found) && preg_match('|[A-Z]|', PASS, $l_Found) && preg_match('|[a-z]|', PASS, $l_Found) ) {
     $l_PassOK = true;   
  }
  
  if (!$l_PassOK) {  
    echo sprintf(AI_STR_009, generatePassword());
    exit;
  }

  if (isset($_GET['fn']) && ($_GET['ph'] == crc32(PASS))) {
     printFile();
     exit;
  }

  if ($_GET['p'] != PASS) {
    $generated_pass = generatePassword(); 
    echo sprintf(AI_STR_010, $generated_pass, $generated_pass);
    exit;
  }
}

if (!is_readable(ROOT_PATH)) {
  echo AI_STR_011;
  exit;
}

if (isCli()) {
	if (defined('REPORT_PATH') AND REPORT_PATH)
	{
		if (!is_writable(REPORT_PATH))
		{
			die("\nCannot write report. Report dir " . REPORT_PATH . " is not writable.");
		}

		else if (!REPORT_FILE)
		{
			die("\nCannot write report. Report filename is empty.");
		}

		else if (($file = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE) AND is_file($file) AND !is_writable($file))
		{
			die("\nCannot write report. Report file '$file' exists but is not writable.");
		}
	}
}


$g_IgnoreList = array();
$g_DirIgnoreList = array();
$g_UrlIgnoreList = array();
$g_KnownList = array();

$l_IgnoreFilename = $g_AiBolitAbsolutePath . '/.aignore';
$l_DirIgnoreFilename = $g_AiBolitAbsolutePath . '/.adirignore';
$l_UrlIgnoreFilename = $g_AiBolitAbsolutePath . '/.aurlignore';
$l_KnownFilename = '.aknown';

if (file_exists($l_IgnoreFilename)) {
    $l_IgnoreListRaw = file($l_IgnoreFilename);
    for ($i = 0; $i < count($l_IgnoreListRaw); $i++) 
    {
    	$g_IgnoreList[] = explode("\t", trim($l_IgnoreListRaw[$i]));
    }
    unset($l_IgnoreListRaw);
}

if (file_exists($l_DirIgnoreFilename)) {
    $g_DirIgnoreList = file($l_DirIgnoreFilename);
	
	for ($i = 0; $i < count($g_DirIgnoreList); $i++) {
		$g_DirIgnoreList[$i] = trim($g_DirIgnoreList[$i]);
	}
}

if (file_exists($l_UrlIgnoreFilename)) {
    $g_UrlIgnoreList = file($l_UrlIgnoreFilename);
	
	for ($i = 0; $i < count($g_UrlIgnoreList); $i++) {
		$g_UrlIgnoreList[$i] = trim($g_UrlIgnoreList[$i]);
	}
}


$g_AiBolitAbsolutePathKnownFiles = dirname($g_AiBolitAbsolutePath) . '/known_files';
$g_AiBolitKnownFilesDirs = array('.');

if ($l_DIRH = @opendir($g_AiBolitAbsolutePathKnownFiles))
{
    while (($l_FileName = readdir($l_DIRH)) !== false)
    {
	   if ($l_FileName == '.' || $l_FileName == '..') continue;
   	   if (defined('CMS') && $l_FileName != CMS) continue;
       array_push($g_AiBolitKnownFilesDirs, $l_FileName);
    }

    closedir($l_DIRH);
}


foreach ($g_AiBolitKnownFilesDirs as $l_PathKnownFiles)
{
    if ($l_PathKnownFiles != '.') {
       $l_AbsolutePathKnownFiles = $g_AiBolitAbsolutePathKnownFiles . '/' . $l_PathKnownFiles;
    } else {
      $l_AbsolutePathKnownFiles = $l_PathKnownFiles;
    }

    if ($l_DIRH = opendir($l_AbsolutePathKnownFiles))
    {
        while (($l_FileName = readdir($l_DIRH)) !== false)
        {
            if ($l_FileName == '.' || $l_FileName == '..') continue;
               if (strpos($l_FileName, $l_KnownFilename) !== false) {
                           stdOut("Loading " . $l_FileName);
                           foreach (new SplFileObject($l_AbsolutePathKnownFiles . '/' . $l_FileName) as $line) {
                               $g_KnownList[(int) $line] = 1;
                           }
                       }
        }
        closedir($l_DIRH);
    }
}

stdOut("Loaded " . count($g_KnownList) . ' known files');

try {
	$s_file = new SplFileObject($g_AiBolitAbsolutePath."/ai-bolit.sig");
	$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
	foreach ($s_file as $line) {
		$g_FlexDBShe[] = preg_replace('~\G(?:[^#\\\\]+|\\\\.)*+\K#~', '\\#', $line); // escaping #
	}
	stdOut("Loaded " . $s_file->key() . " signatures from ai-bolit.sig");
	$s_file = null; // file handler is closed
} catch (Exception $e) { QCR_Debug( "Import ai-bolit.sig " . $e->getMessage() ); }

QCR_Debug();

	$defaults['skip_ext'] = strtolower(trim($defaults['skip_ext']));
         if ($defaults['skip_ext'] != '') {
	    $g_IgnoredExt = explode(',', $defaults['skip_ext']);
	    for ($i = 0; $i < count($g_IgnoredExt); $i++) {
                $g_IgnoredExt[$i] = trim($g_IgnoredExt[$i]);
             }

	    QCR_Debug('Skip files with extensions: ' . implode(',', $g_IgnoredExt));
	    stdOut('Skip extensions: ' . implode(',', $g_IgnoredExt));
         } 

// scan single file
if (defined('SCAN_FILE')) {
   if (file_exists(SCAN_FILE) && is_file(SCAN_FILE) && is_readable(SCAN_FILE)) {
       stdOut("Start scanning file '" . SCAN_FILE . "'.");
       QCR_ScanFile(SCAN_FILE); 
   } else { 
       stdOut("Error:" . SCAN_FILE . " either is not a file or readable");
   }
} else {
	if (isset($_GET['2check'])) {
		$options['with-2check'] = 1;
	}
   
   // scan list of files from file
   if (isset($options['with-2check']) && file_exists(DOUBLECHECK_FILE)) {
      stdOut("Start scanning the list from '" . DOUBLECHECK_FILE . "'.\n");
      $lines = file(DOUBLECHECK_FILE);
      for ($i = 0, $size = count($lines); $i < $size; $i++) {
         $lines[$i] = trim($lines[$i]);
         if (empty($lines[$i])) unset($lines[$i]);
      }
      /* skip first line with <?php die("Forbidden"); ?> */
      unset($lines[0]);
      $g_FoundTotalFiles = count($lines);
      $i = 1;
      foreach ($lines as $l_FN) {
         is_dir($l_FN) && $g_TotalFolder++;
         printProgress( $i++, $l_FN);
         $BOOL_RESULT = true; // display disable
         is_file($l_FN) && QCR_ScanFile($l_FN, $i);
         $BOOL_RESULT = false; // display enable
      }

      $g_FoundTotalDirs = $g_TotalFolder;
      $g_FoundTotalFiles = $g_TotalFiles;

   } else {
      // scan whole file system
      stdOut("Start scanning '" . ROOT_PATH . "'.\n");
      
      file_exists(QUEUE_FILENAME) && unlink(QUEUE_FILENAME);
      QCR_ScanDirectories(ROOT_PATH);

   }
}

//$g_FoundTotalFiles = count($g_Structure['n']);
//$g_FoundTotalFiles = $g_Counter - $g_FoundTotalDirs;

QCR_Debug();

stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
stdOut(str_repeat(' ', 160),false);

//$g_FoundTotalFiles = count($g_Structure['n']);

// detect version CMS
$l_CmsListDetector = new CmsVersionDetector('.');
$l_CmsDetectedNum = $l_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $l_CmsListDetector->getCmsName($tt) . ' v' . $l_CmsListDetector->getCmsVersion($tt);
}

if (!(ONE_PASS || defined('SCAN_FILE') || (isset($options['with-2check']) && file_exists(DOUBLECHECK_FILE)) )) {
QCR_GoScan(0);
unlink(QUEUE_FILENAME);
}
QCR_Debug();


////////////////////////////////////////////////////////////////////////////
 if ($BOOL_RESULT) {
  if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR  (count($g_Iframer) > 0) OR  (count($g_UnixExec) > 0))
  {
  echo "1\n";
  exit(0);
  }
 }
////////////////////////////////////////////////////////////////////////////

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $g_AddPrefix . str_replace($g_NoPrefix, '', realpath('.'))), $l_Template);

$time_taken = seconds2Human(microtime(true) - START_TIME);

$l_Template = str_replace("@@SCANNED@@", sprintf(AI_STR_013, $g_TotalFolder, $g_TotalFiles), $l_Template);

$l_ShowOffer = false;

stdOut("\nBuilding report [ mode = " . AI_EXPERT . " ]\n");

////////////////////////////////////////////////////////////////////////////
// save 
if (isset($options['with-2check']) || isset($options['quarantine']))
if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR 
   (count($g_Iframer) > 0) OR  (count($g_UnixExec))) 
{
  if (!file_exists(DOUBLECHECK_FILE)) {	  
      if ($l_FH = fopen(DOUBLECHECK_FILE, 'w')) {
         fputs($l_FH, '<?php die("Forbidden"); ?>' . "\n");

         $l_CurrPath = dirname(__FILE__);
		 
		 if (!isset($g_CriticalPHP)) { $g_CriticalPHP = array(); }
		 if (!isset($g_Base64)) { $g_Base64 = array(); }
		 if (!isset($g_CriticalJS)) { $g_CriticalJS = array(); }
		 if (!isset($g_Iframer)) { $g_Iframer = array(); }
		 if (!isset($g_Phishing)) { $g_Phishing = array(); }

         $tmpIndex = array_merge($g_CriticalPHP, $g_Base64, $g_CriticalJS, $g_Iframer, $g_Phishing);
         $tmpIndex = array_values(array_unique($tmpIndex));

         for ($i = 0; $i < count($tmpIndex); $i++) {
             $tmpIndex[$i] = str_replace($l_CurrPath, '.', $g_Structure['n'][$tmpIndex[$i]]);
         }

         for ($i = 0; $i < count($g_UnixExec); $i++) {
             $tmpIndex[] = str_replace($l_CurrPath, '.', $g_UnixExec[$i]);
         }

         $tmpIndex = array_values(array_unique($tmpIndex));

         for ($i = 0; $i < count($tmpIndex); $i++) {
             fputs($l_FH, $tmpIndex[$i] . "\n");
         }

         fclose($l_FH);
      } else {
         stdOut("Error! Cannot create " . DOUBLECHECK_FILE);
      }      
  } else {
      stdOut(DOUBLECHECK_FILE . ' already exists.');
      if (AI_STR_044 != '') $l_Result .= '<div class="rep">' . AI_STR_044 . '</div>';
  }
 
}

////////////////////////////////////////////////////////////////////////////

$l_Summary = '<div class="title">' . AI_STR_074 . '</div>';
$l_Summary .= '<table cellspacing=0 border=0>';

if (count($g_Redirect) > 0) {
   $l_Summary .= makeSummary(AI_STR_059, count($g_Redirect), "crit");
}

if (count($g_CriticalPHP) > 0) {
   $l_Summary .= makeSummary(AI_STR_060, count($g_CriticalPHP), "crit");
}

if (count($g_CriticalJS) > 0) {
   $l_Summary .= makeSummary(AI_STR_061, count($g_CriticalJS), "crit");
}

if (count($g_Phishing) > 0) {
   $l_Summary .= makeSummary(AI_STR_062, count($g_Phishing), "crit");
}

if (count($g_UnixExec) > 0) {
   $l_Summary .= makeSummary(AI_STR_063, count($g_UnixExec), "crit");
}

if (count($g_Iframer) > 0) {
   $l_Summary .= makeSummary(AI_STR_064, count($g_Iframer), "crit");
}

if (count($g_NotRead) > 0) {
   $l_Summary .= makeSummary(AI_STR_066, count($g_NotRead), "crit");
}

if (count($g_Base64) > 0) {
   $l_Summary .= makeSummary(AI_STR_067, count($g_Base64), "crit");
}

if (count($g_BigFiles) > 0) {
   $l_Summary .= makeSummary(AI_STR_065, count($g_BigFiles), "warn");
}

if (count($g_HeuristicDetected) > 0) {
   $l_Summary .= makeSummary(AI_STR_068, count($g_HeuristicDetected), "warn");
}

if (count($g_SymLinks) > 0) {
   $l_Summary .= makeSummary(AI_STR_069, count($g_SymLinks), "warn");
}

if (count($g_HiddenFiles) > 0) {
   $l_Summary .= makeSummary(AI_STR_070, count($g_HiddenFiles), "warn");
}

if (count($g_AdwareList) > 0) {
   $l_Summary .= makeSummary(AI_STR_072, count($g_AdwareList), "warn");
}

if (count($g_EmptyLink) > 0) {
   $l_Summary .= makeSummary(AI_STR_073, count($g_EmptyLink), "warn");
}

 $l_Summary .= "</table><div class=details style=\"margin: 20px 20px 20px 0\">" . AI_STR_080 . "</div>\n";

 $l_Template = str_replace("@@SUMMARY@@", $l_Summary, $l_Template);


 $l_Result .= AI_STR_015;
 
 $l_Template = str_replace("@@VERSION@@", AI_VERSION, $l_Template);
 
////////////////////////////////////////////////////////////////////////////



if (function_exists("gethostname") && is_callable("gethostname")) {
  $l_HostName = gethostname();
} else {
  $l_HostName = '???';
}

$l_PlainResult = "# Malware list detected by AI-Bolit (http://revisium.com/ai/) on " . date("d/m/Y H:i:s", time()) . " " . $l_HostName .  "\n\n";

stdOut("Building list of vulnerable scripts " . count($g_Vulnerable));

if (count($g_Vulnerable) > 0) {
    $l_Result .= '<div class="note_vir">' . AI_STR_081 . ' (' . count($g_Vulnerable) . ')</div><div class="crit">';
 	foreach ($g_Vulnerable as $l_Item) {
	    $l_Result .= '<li>' . $g_Structure['n'][$l_Item['ndx']] . ' - ' . $l_Item['id'] . '</li>';
		$l_PlainResult .= 'VULNERABILITY: ' . $g_Structure['n'][$l_Item['ndx']] . ' - ' . $l_Item['id'] . "\n";
 	}
	
  $l_Result .= '</div><p>' . PHP_EOL;
}

stdOut("Building list of shells " . count($g_CriticalPHP));

if (count($g_CriticalPHP) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_016 . ' (' . count($g_CriticalPHP) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit');
  $l_PlainResult .= printPlainList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit');
  $l_Result .= '</div>' . PHP_EOL;

  $l_ShowOffer = true;
} else {
  $l_Result .= '<div class="ok"><b>' . AI_STR_017. '</b></div>';
}

stdOut("Building list of js " . count($g_CriticalJS));

if (count($g_CriticalJS) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_018 . ' (' . count($g_CriticalJS) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
  $l_PlainResult .= printPlainList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
  $l_Result .= "</div>" . PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building phishing pages " . count($g_Phishing));

if (count($g_Phishing) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_058 . ' (' . count($g_Phishing) . ')</div><div class="crit">';
  $l_Result .= printList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
  $l_PlainResult .= printPlainList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
  $l_Result .= "</div>". PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building list of unix executables and odd scripts " . count($g_UnixExec));

if (count($g_UnixExec) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_019 . ' (' . count($g_UnixExec) . ')</div><div class="crit">';
  $l_Result .= implode("<br>", $g_UnixExec);
  $l_PlainResult .= implode("\n", $g_UnixExec);
  $l_Result .= "</div>" . PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building list of iframes " . count($g_Iframer));

if (count($g_Iframer) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_021 . ' (' . count($g_Iframer) . ')</div><div class="crit">';
  $l_Result .= printList($g_Iframer, $g_IframerFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of base64s " . count($g_Base64));

if (count($g_Base64) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_020 . ' (' . count($g_Base64) . ')</div><div class="crit">';
  $l_Result .= printList($g_Base64, $g_Base64Fragment, true);
  $l_PlainResult .= printPlainList($g_Base64, $g_Base64Fragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of redirects " . count($g_Redirect));
if (count($g_Redirect) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_027 . ' (' . count($g_Redirect) . ')</div><div class="crit">';
  $l_Result .= printList($g_Redirect, $g_RedirectPHPFragment, true);
  $l_Result .= "</div>" . PHP_EOL;
}


stdOut("Building list of unread files " . count($g_NotRead));

if (count($g_NotRead) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
  $l_Result .= printList($g_NotRead);
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
}

stdOut("Building list of symlinks " . count($g_SymLinks));

if (count($g_SymLinks) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
  $l_Result .= implode("<br>", $g_SymLinks);
  $l_Result .= "</div><div class=\"spacer\"></div>";
}

////////////////////////////////////

$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
/*
stdOut("Building list of heuristics " . count($g_HeuristicDetected));

if (count($g_HeuristicDetected) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
  for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
	   $l_Result .= '<li>' . $g_Structure['n'][$g_HeuristicDetected[$i]] . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
  }
  
  $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;

  $l_ShowOffer = true;
}
*/
stdOut("Building list of hidden files " . count($g_HiddenFiles));
if (count($g_HiddenFiles) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_023 . ' (' . count($g_HiddenFiles) . ')</div><div class="warn">';
  $l_Result .= implode("<br>", $g_HiddenFiles);
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;

}

stdOut("Building list of bigfiles " . count($g_BigFiles));
$max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
$max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');

if (count($g_BigFiles) > 0) {
  $l_Result .= "<div class=\"note_warn\">" . sprintf(AI_STR_038, bytes2Human($max_size_to_scan)) . '</div><div class="warn">';
  $l_Result .= printList($g_BigFiles);
  $l_Result .= "</div>";
} 
/*
stdOut("Building list of php inj " . count($g_PHPCodeInside));

if ((count($g_PHPCodeInside) > 0) && (($defaults['report_mask'] & REPORT_MASK_PHPSIGN) == REPORT_MASK_PHPSIGN)) {

  $l_ShowOffer = true;
  $l_Result .= '<div class="note_warn">' . AI_STR_028 . '</div><div class="warn">';
  $l_Result .= printList($g_PHPCodeInside, $g_PHPCodeInsideFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}
*/
stdOut("Building list of adware " . count($g_AdwareList));

if (count($g_AdwareList) > 0) {
  $l_ShowOffer = true;

  $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
  $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

/*
stdOut("Building list of empty links " . count($g_EmptyLink));
if (count($g_EmptyLink) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_warn">' . AI_STR_031 . '</div><div class="warn">';
  $l_Result .= printList($g_EmptyLink, '', true);

  $l_Result .= AI_STR_032 . '<br/>';
  
  if (count($g_EmptyLink) == MAX_EXT_LINKS) {
      $l_Result .= '(' . AI_STR_033 . MAX_EXT_LINKS . ')<br/>';
    }
   
  for ($i = 0; $i < count($g_EmptyLink); $i++) {
	$l_Idx = $g_EmptyLink[$i];
    for ($j = 0; $j < count($g_EmptyLinkSrc[$l_Idx]); $j++) {
      $l_Result .= '<span class="details">' . $g_Structure['n'][$g_EmptyLink[$i]] . ' &rarr; ' . htmlspecialchars($g_EmptyLinkSrc[$l_Idx][$j]) . '</span><br/>';
	}
  }

  $l_Result .= "</div>";

}

stdOut("Building list of doorways " . count($g_Doorway));

if ((count($g_Doorway) > 0) && (($defaults['report_mask'] & REPORT_MASK_DOORWAYS) == REPORT_MASK_DOORWAYS)) {
  $l_ShowOffer = true;

  $l_Result .= '<div class="note_warn">' . AI_STR_034 . '</div><div class="warn">';
  $l_Result .= printList($g_Doorway);
  $l_Result .= "</div>" . PHP_EOL;

}
*/
stdOut("Building list of php warnings " . (count($g_WarningPHP[0]) + count($g_WarningPHP[1])));

if (($defaults['report_mask'] & REPORT_MASK_SUSP) == REPORT_MASK_SUSP) {
   if ((count($g_WarningPHP[0]) + count($g_WarningPHP[1])) > 0) {
     $l_ShowOffer = true;

     $l_Result .= '<div class="note_warn">' . AI_STR_035 . '</div><div class="warn">';

     for ($i = 0; $i < count($g_WarningPHP); $i++) {
         if (count($g_WarningPHP[$i]) > 0) 
            $l_Result .= printList($g_WarningPHP[$i], $g_WarningPHPFragment[$i], true, $g_WarningPHPSig, 'table_warn' . $i);
     }                                                                                                                    
     $l_Result .= "</div>" . PHP_EOL;

   } 
}
/*
stdOut("Building list of skipped dirs " . count($g_SkippedFolders));
if (count($g_SkippedFolders) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_036 . '</div><div class="warn">';
     $l_Result .= implode("<br>", $g_SkippedFolders);
     $l_Result .= "</div>" . PHP_EOL;
 }
*/
 if (count($g_CMS) > 0) {
      $l_Result .= "<div class=\"note_warn\">" . AI_STR_037 . "<br/>";
      $l_Result .= implode("<br>", $g_CMS);
      $l_Result .= "</div>";
 }

if (!isCli()) {
   $l_Result .= QCR_ExtractInfo($l_PhpInfoBody[1]);
}


if (function_exists('memory_get_peak_usage')) {
  $l_Template = str_replace("@@MEMORY@@", AI_STR_043 . bytes2Human(memory_get_peak_usage()), $l_Template);
}

$l_Template = str_replace('@@WARN_QUICK@@', (SCAN_ALL_FILES ? '' : AI_STR_045), $l_Template);

if ($l_ShowOffer) {
	$l_Template = str_replace('@@OFFER@@', $l_Offer, $l_Template);
} else {
	$l_Template = str_replace('@@OFFER@@', AI_STR_002, $l_Template);
}

$l_Template = str_replace('@@CAUTION@@', AI_STR_003, $l_Template);

$l_Template = str_replace('@@CREDITS@@', AI_STR_075, $l_Template);

$l_Template = str_replace('@@FOOTER@@', AI_STR_076, $l_Template);

$l_Template = str_replace('@@STAT@@', sprintf(AI_STR_012, $time_taken, date('d-m-Y в H:i:s', floor(START_TIME)) , date('d-m-Y в H:i:s')), $l_Template);

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MAIN_CONTENT@@", $l_Result, $l_Template);

if (!isCli())
{
    echo $l_Template;
    exit;
}

if (!defined('REPORT') OR REPORT === '')
{
	die('Report not written.');
}
 
// write plain text result
if (PLAIN_FILE != '') {
	
    $l_PlainResult = preg_replace('|__AI_LINE1__|smi', '[', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_LINE2__|smi', '] ', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_MARKER__|smi', '%>', $l_PlainResult);

   if ($l_FH = fopen(PLAIN_FILE, "w")) {
      fputs($l_FH, $l_PlainResult);
      fclose($l_FH);
   }
}

$emails = getEmails(REPORT);

if (!$emails) {
	if ($l_FH = fopen($file, "w")) {
	   fputs($l_FH, $l_Template);
	   fclose($l_FH);
	   stdOut("\nReport written to '$file'.");
	} else {
		stdOut("\nCannot create '$file'.");
	}
}	else	{
		$headers = array(
			'MIME-Version: 1.0',
			'Content-type: text/html; charset=UTF-8',
			'From: ' . ($defaults['email_from'] ? $defaults['email_from'] : 'AI-Bolit@myhost')
		);

		for ($i = 0, $size = sizeof($emails); $i < $size; $i++)
		{
			mail($emails[$i], 'AI-Bolit Report ' . date("d/m/Y H:i", time()), $l_Result, implode("\r\n", $headers));
		}

		stdOut("\nReport sended to " . implode(', ', $emails));
}


$time_taken = microtime(true) - START_TIME;
$time_taken = number_format($time_taken, 5);

stdOut("Scanning complete! Time taken: " . seconds2Human($time_taken));

stdOut("\n\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
stdOut("Attention! DO NOT LEAVE either ai-bolit.php or AI-BOLIT-REPORT-<xxxx>-<yy>.html \nfile on server. COPY it locally then REMOVE from server. ");
stdOut("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");

if (isset($options['quarantine'])) {
	Quarantine();
}

if (isset($options['cmd'])) {
	stdOut("Run \"{$options['cmd']}\" ");
	system($options['cmd']);
}

QCR_Debug();

# exit with code

$l_EC1 = count($g_CriticalPHP);
$l_EC2 = count($g_CriticalJS) + count($g_Phishing) + count($g_WarningPHP[0]) + count($g_WarningPHP[1]);

if ($l_EC1 > 0) {
	stdOut('Exit code 2');
	exit(2);
} else {
	if ($l_EC2 > 0) {
		stdOut('Exit code 1');
		exit(1);
	}
}

stdOut('Exit code 0');
exit(0);

############################################# END ###############################################

function Quarantine()
{
	if (!file_exists(DOUBLECHECK_FILE)) {
		return;
	}
	
	$g_QuarantinePass = 'aibolit';
	
	$archive = "AI-QUARANTINE-" .rand(100000, 999999) . ".zip";
	$infoFile = substr($archive, 0, -3) . "txt";
	$report = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE;
	

	foreach (file(DOUBLECHECK_FILE) as $file) {
		$file = trim($file);
		if (!is_file($file)) continue;
	
		$lStat = stat($file);
		
		// skip files over 300KB
		if ($lStat['size'] > 300*1024) continue;

		// http://www.askapache.com/security/chmod-stat.html
		$p = $lStat['mode'];
		$perm ='-';
		$perm.=(($p&0x0100)?'r':'-').(($p&0x0080)?'w':'-');
		$perm.=(($p&0x0040)?(($p&0x0800)?'s':'x'):(($p&0x0800)?'S':'-'));
		$perm.=(($p&0x0020)?'r':'-').(($p&0x0010)?'w':'-');
		$perm.=(($p&0x0008)?(($p&0x0400)?'s':'x'):(($p&0x0400)?'S':'-'));
		$perm.=(($p&0x0004)?'r':'-').(($p&0x0002)?'w':'-');
		$perm.=(($p&0x0001)?(($p&0x0200)?'t':'x'):(($p&0x0200)?'T':'-'));
		
		$owner = (function_exists('posix_getpwuid'))? @posix_getpwuid($lStat['uid']) : array('name' => $lStat['uid']);
		$group = (function_exists('posix_getgrgid'))? @posix_getgrgid($lStat['gid']) : array('name' => $lStat['uid']);

		$inf['permission'][] = $perm;
		$inf['owner'][] = $owner['name'];
		$inf['group'][] = $group['name'];
		$inf['size'][] = $lStat['size'] > 0 ? bytes2Human($lStat['size']) : '-';
		$inf['ctime'][] = $lStat['ctime'] > 0 ? date("d/m/Y H:i:s", $lStat['ctime']) : '-';
		$inf['mtime'][] = $lStat['mtime'] > 0 ? date("d/m/Y H:i:s", $lStat['mtime']) : '-';
		$files[] = strpos($file, './') === 0 ? substr($file, 2) : $file;
	}
	
	// get config files for cleaning
	$configFilesRegex = 'config(uration|\.in[ic])?\.php$|dbconn\.php$';
	$configFiles = preg_grep("~$configFilesRegex~", $files);

	// get columns width
	$width = array();
	foreach (array_keys($inf) as $k) {
		$width[$k] = strlen($k);
		for ($i = 0; $i < count($inf[$k]); ++$i) {
			$len = strlen($inf[$k][$i]);
			if ($len > $width[$k])
				$width[$k] = $len;
		}
	}

	// headings of columns
	$info = '';
	foreach (array_keys($inf) as $k) {
		$info .= str_pad($k, $width[$k], ' ', STR_PAD_LEFT). ' ';
	}
	$info .= "name\n";
	
	for ($i = 0; $i < count($files); ++$i) {
		foreach (array_keys($inf) as $k) {
			$info .= str_pad($inf[$k][$i], $width[$k], ' ', STR_PAD_LEFT). ' ';
		}
		$info .= $files[$i]."\n";
	}
	unset($inf, $width);

	exec("zip -v 2>&1", $output,$code);

	if ($code == 0) {
		$filter = '';
		if ($configFiles && exec("grep -V 2>&1", $output, $code) && $code == 0) {
			$filter = "|grep -v -E '$configFilesRegex'";
		}

		exec("cat AI-BOLIT-DOUBLECHECK.php $filter |zip -@ --password $g_QuarantinePass $archive", $output, $code);
		if ($code == 0) {
			file_put_contents($infoFile, $info);
			$m = array();
			if (!empty($filter)) {
				foreach ($configFiles as $file) {
					$tmp = file_get_contents($file);
					// remove  passwords
					$tmp = preg_replace('~^.*?pass.*~im', '', $tmp);
					// new file name
					$file = preg_replace('~.*/~', '', $file) . '-' . rand(100000, 999999);
					file_put_contents($file, $tmp);
					$m[] = $file;
				}
			}

			exec("zip -j --password $g_QuarantinePass $archive $infoFile $report " . DOUBLECHECK_FILE . ' ' . implode(' ', $m));
			stdOut("\nCreate archive '" . realpath($archive) . "'");
			stdOut("This archive have password '$g_QuarantinePass'");
			foreach ($m as $file) unlink($file);
			unlink($infoFile);
			return;
		}
	}
	
	$zip = new ZipArchive;
	
	if ($zip->open($archive, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === false) {
		stdOut("Cannot create '$archive'.");
		return;
	}

	foreach ($files as $file) {
		if (in_array($file, $configFiles)) {
			$tmp = file_get_contents($file);
			// remove  passwords
			$tmp = preg_replace('~^.*?pass.*~im', '', $tmp);
			$zip->addFromString($file, $tmp);
		} else {
			$zip->addFile($file);
		}
	}
	$zip->addFile(DOUBLECHECK_FILE, DOUBLECHECK_FILE);
	$zip->addFile($report, REPORT_FILE);
	$zip->addFromString($infoFile, $info);
	$zip->close();

	stdOut("\nCreate archive '" . realpath($archive) . "'.");
	stdOut("This archive has no password!");
}

function OptimizeSignatures()
{
	global $g_DBShe, $g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe;
	global $g_JSVirSig, $gX_JSVirSig;
	global $g_AdwareSig;
	global $g_PhishingSig;

	(AI_EXPERT == 2) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe));
	(AI_EXPERT == 1) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe));
	$gX_FlexDBShe = $gXX_FlexDBShe = array();

	(AI_EXPERT == 2) && ($g_JSVirSig = array_merge($g_JSVirSig, $gX_JSVirSig));
	$gX_JSVirSig = array();

	$count = count($g_FlexDBShe);

	for ($i = 0; $i < $count; $i++) {
		if ($g_FlexDBShe[$i] == 'http://.+?/.+?\.php\?a=\d+&c=[a-zA-Z0-9_]+?&s=') $g_FlexDBShe[$i] = 'http://[^?\s]++(?<=\.php)\?a=\d+&c=[a-zA-Z0-9_]+?&s=';
		if ($g_FlexDBShe[$i] == '[a-zA-Z0-9_]+?\(\s*[a-zA-Z0-9_]+?=\s*\)') $g_FlexDBShe[$i] = '\((?<=[a-zA-Z0-9_].)\s*[a-zA-Z0-9_]++=\s*\)';
		if ($g_FlexDBShe[$i] == '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e') $g_FlexDBShe[$i] = '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e';
		if ($g_FlexDBShe[$i] == '$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.') $g_FlexDBShe[$i] = '\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.';

		$g_FlexDBShe[$i] = preg_replace('~\[a-zA-Z0-9_\]\+\K\?~', '+', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = preg_replace('~^\\\\[d]\+&@~', '&@(?<=\d..)', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = str_replace('\s*[\'"]{0,1}.+?[\'"]{0,1}\s*', '.+?', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = str_replace('[\'"]{0,1}.+?[\'"]{0,1}', '.+?', $g_FlexDBShe[$i]);

		$g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
	}

	optSig($g_FlexDBShe);
	optSig($g_JSVirSig);
	optSig($g_AdwareSig);
	optSig($g_PhishingSig);
}


function optSig(&$sigs)
{
	optSigCheck($sigs);
	
	usort($sigs, 'strcasecmp');
	$txt = implode("\n", $sigs);

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i-=4 : --$i) {
		$txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|)){' . $i . ',}).*(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
	}

	$sigs = explode("\n", $txt);
	
	optSigCheck($sigs);
}

function optMergePrefixes($m)
{
	$prefix = $m[1];
	$prefix_len = strlen($prefix);

	$suffixes = array();
	foreach (explode("\n", $m[0]) as $line) {
		$suffixes[] = substr($line, $prefix_len);
	}
	
	return $prefix . '(?:' . implode('|', $suffixes) . ')';
}

/*
 * Checking errors in pattern
 */
function optSigCheck(&$sigs)
{
	$result = true;

	foreach ($sigs as $k => $sig) {
		if (@preg_match('#(' . $sig . ')#smiS', '') === false) {
			$error = error_get_last();
			//echo($error['message'] . "\n     pattern: " . $sig . "\n");
			unset($sigs[$k]);
			$result = false;
		}
	}
	
	return $result;
}
