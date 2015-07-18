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
define('PASS', '??????????????????'); 


//define('LANG', 'EN');
define('LANG', 'RU');

define('REPORT_MASK_PHPSIGN', 1);
define('REPORT_MASK_SPAMLINKS', 2);
define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_SUSP', 8);
define('REPORT_MASK_CANDI', 16);
define('REPORT_MASK_WRIT', 32);
define('REPORT_MASK_FULL', REPORT_MASK_PHPSIGN | REPORT_MASK_DOORWAYS | REPORT_MASK_SUSP
/* <-- remove this line to enable "recommendations"  

| REPORT_MASK_SPAMLINKS 

 remove this line to enable "recommendations" --> */
);

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '600K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
        'skip_ext' => '',
	'report_mask' =>  REPORT_MASK_FULL // full-featured report
);


define('DEBUG_MODE', 0);

define('DIR_SEPARATOR', '/');

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');
define('QUEUE_FILENAME', 'AI-BOLIT-QUEUE.txt');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)/* && stripos('CygWin', $_SERVER['OS']) === false)*/) {
   define('DIR_SEPARATOR', '\\');
}


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
define('AI_STR_015', '<div class="title">Критические замечания</div>');
define('AI_STR_016', 'Эти файлы могут быть вредоносными или хакерскими скриптами');
define('AI_STR_017', 'Вредоносные скрипты не найдены. Попробуйте сканер в режиме "Параноидальный".');
define('AI_STR_018', 'Эти файлы могут быть javascript вирусами');
define('AI_STR_019', 'Обнаружены сигнатуры исполняемых файлов unix и нехарактерных скриптов. Они могут быть вредоносными файлами');
define('AI_STR_020', 'Двойное расширение, зашифрованный контент или подозрение на вредоносный скрипт. Требуется дополнительный анализ');
define('AI_STR_021', 'Подозрение на вредоносный скрипт');
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

define('AI_STR_059', 'Мобильных редиректов');
define('AI_STR_060', 'Вредоносных скриптов');
define('AI_STR_061', 'JS Вирусов');
define('AI_STR_062', 'Фишинговых страниц');
define('AI_STR_063', 'Исполняемых файлов');
define('AI_STR_064', 'IFRAME вставок');
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

// This is signatures wrapped into base64. 
$g_DBShe = unserialize(base64_decode("YTo0MDg6e2k6MDtzOjg6IlpPQlVHVEVMIjtpOjE7czoxMzoiTWFnZWxhbmdDeWJlciI7aToyO3M6MTM6InByb2ZleG9yLmhlbGwiO2k6MztzOjIwOiI8IS0tQ09PS0lFIFVQREFURS0tPiI7aTo0O3M6OToiLy9yYXN0YS8vIjtpOjU7czo1NzoiJHBhcmFtMm1hc2suIilcPVtcPHFxPlwiXSguKj8pKD89W1w8cXE+XCJdIClbXDxxcT5cIl0vc2llIjtpOjY7czoxOToiKTsgJGkrKykkcmV0Lj1jaHIoJCI7aTo3O3M6Mjc6ImVyZWdfcmVwbGFjZSg8cT4mZW1haWwmPHE+LCI7aTo4O3M6MTM6Il1dKSk7fX1ldmFsKCQiO2k6OTtzOjMwOiJmd3JpdGUoZm9wZW4oZGlybmFtZShfX0ZJTEVfXykiO2k6MTA7czoxMToiQmFieV9EcmFrb24iO2k6MTE7czoyNDoiJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjEyO3M6MTU6Ik5ldEBkZHJlc3MgTWFpbCI7aToxMztzOjM0OiJQYXNzd29yZDo8cz4iLiRfUE9TVFs8cT5wYXNzd2Q8cT5dIjtpOjE0O3M6MTU6IkNyZWF0ZWQgQnkgRU1NQSI7aToxNTtzOjEyOiJHSUY4OUE7PD9waHAiO2k6MTY7czoyODoib1RhdDhEM0RzRTgnJn5oVTA2Q0NINTskZ1lTcSI7aToxNztzOjIwOiIkbWQ1PW1kNSgiJHJhbmRvbSIpOyI7aToxODtzOjY6IjN4cDFyMyI7aToxOTtzOjMyOiIkaW09c3Vic3RyKCR0eCwkcCsyLCRwMi0oJHArMikpOyI7aToyMDtzOjE1OiJOaW5qYVZpcnVzIEhlcmUiO2k6MjE7czoyMToiN1AxdGQrTldsaWFJL2hXa1o0Vlg5IjtpOjIyO3M6MTA6Ijxkb3Q+SXJJc1QiO2k6MjM7czoxMDoibmRyb2l8aHRjXyI7aToyNDtzOjEwOiJhbmRleHxvb2dsIjtpOjI1O3M6MTc6IkhhY2tlZCBCeSBFbkRMZVNzIjtpOjI2O3M6MTc6IigkX1BPU1RbImRpciJdKSk7IjtpOjI3O3M6NTU6IigkaW5kYXRhLCRiNjQ9MSl7aWYoJGI2ND09MSl7JGNkPWJhc2U2NF9kZWNvZGUoJGluZGF0YSkiO2k6Mjg7czo3NToiJGltPXN1YnN0cigkaW0sMCwkaSkuc3Vic3RyKCRpbSwkaTIrMSwkaTQtKCRpMisxKSkuc3Vic3RyKCRpbSwkaTQrMTIsc3RybGVuIjtpOjI5O3M6MTg6Ijw/cGhwIGVjaG8gIiMhISMiOyI7aTozMDtzOjEwOiJQdW5rZXIyQm90IjtpOjMxO3M6MTE6IiRzaDNsbENvbG9yIjtpOjMyO3M6NDc6IkBjaHIoKCRoWyRlWyRvXV08PDQpKygkaFskZVsrKyRvXV0pKTt9fWV2YWwoJGQpIjtpOjMzO3M6MzY6InBwY3xtaWRwfHdpbmRvd3MgY2V8bXRrfGoybWV8c3ltYmlhbiI7aTozNDtzOjQwOiJhYmFjaG98YWJpemRpcmVjdG9yeXxhYm91dHxhY29vbnxhbGV4YW5hIjtpOjM1O3M6NToiWmVkMHgiO2k6MzY7czo4OiJkYXJrbWlueiI7aTozNztzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM4O3M6NzoiT29OX0JveSI7aTozOTtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTo0MDtzOjY6Ik00bGwzciI7aTo0MTtzOjI1OiJjcmVhdGVGaWxlc0ZvcklucHV0T3V0cHV0IjtpOjQyO3M6ODoiUGFzaGtlbGEiO2k6NDM7czoyMjoiXmNeYV5sXnBeZV5yXl9eZ15lXnJecCI7aTo0NDtzOjE0OiI9PSAiYmluZHNoZWxsIiI7aTo0NTtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6NDY7czoyNToiaXNzZXQoJF9QT1NUWydleGVjZ2F0ZSddKSI7aTo0NztzOjM3OiJmd3JpdGUoJGZwc2V0diwgZ2V0ZW52KCJIVFRQX0NPT0tJRSIpIjtpOjQ4O3M6MjA6Ii1JL3Vzci9sb2NhbC9iYW5kbWluIjtpOjQ5O3M6MjE6IiRPT08wMDAwMDA9dXJsZGVjb2RlKCI7aTo1MDtzOjg6IllFTkkzRVJJIjtpOjUxO3M6MTU6ImxldGFrc2VrYXJhbmcoKSI7aTo1MjtzOjY6ImQzbGV0ZSI7aTo1MztzOjQzOiJmdW5jdGlvbiB1cmxHZXRDb250ZW50cygkdXJsLCAkdGltZW91dCA9IDUpIjtpOjU0O3M6NDY6Im92ZXJmbG93LXk6c2Nyb2xsO1wiPiIuJGxpbmtzLiRodG1sX21mWydib2R5J10iO2k6NTU7czoxNjoiTWFkZSBieSBEZWxvcmVhbiI7aTo1NjtzOjc1OiJpZihlbXB0eSgkX0dFVFsnemlwJ10pIGFuZCBlbXB0eSgkX0dFVFsnZG93bmxvYWQnXSkgJiBlbXB0eSgkX0dFVFsnaW1nJ10pKXsiO2k6NTc7czo2NToic3RyX3JvdDEzKCRiYXNlYVsoJGRpbWVuc2lvbiokZGltZW5zaW9uLTEpIC0gKCRpKiRkaW1lbnNpb24rJGopXSkiO2k6NTg7czo2MDoiUjBsR09EbGhFd0FRQUxNQUFBQUFBUC8vLzV5Y0FNN09ZLy8vblAvL3p2L09uUGYzOS8vLy93QUFBQUFBIjtpOjU5O3M6NDU6InByZWdfbWF0Y2goJyFNSURQfFdBUHxXaW5kb3dzLkNFfFBQQ3xTZXJpZXM2MCI7aTo2MDtzOjQ3OiJwcmVnX21hdGNoKCcvKD88PVJld3JpdGVSdWxlKS4qKD89XFtMXCxSXD0zMDJcXSI7aTo2MTtzOjM3OiIkdXJsID0gJHVybHNbcmFuZCgwLCBjb3VudCgkdXJscyktMSldIjtpOjYyO3M6ODA6IndwX3Bvc3RzIFdIRVJFIHBvc3RfdHlwZSA9ICdwb3N0JyBBTkQgcG9zdF9zdGF0dXMgPSAncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjYzO3M6NjU6Imh0dHA6Ly8nLiRfU0VSVkVSWydIVFRQX0hPU1QnXS51cmxkZWNvZGUoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjY0O3M6MzY6ImZ3cml0ZSgkZixnZXRfZG93bmxvYWQoJF9HRVRbJ3VybCddKSI7aTo2NTtzOjc0OiIkcGFyYW0geCAkbi5zdWJzdHIgKCRwYXJhbSwgbGVuZ3RoKCRwYXJhbSkgLSBsZW5ndGgoJGNvZGUpJWxlbmd0aCgkcGFyYW0pKSI7aTo2NjtzOjQ3OiIkdGltZV9zdGFydGVkLiRzZWN1cmVfc2Vzc2lvbl91c2VyLnNlc3Npb25faWQoKSI7aTo2NztzOjQ4OiIkdGhpcy0+Ri0+R2V0Q29udHJvbGxlcigkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6Njg7czoyMToibHVjaWZmZXJAbHVjaWZmZXIub3JnIjtpOjY5O3M6Mjc6ImJhc2U2NF9kZWNvZGUoJGNvZGVfc2NyaXB0KSI7aTo3MDtzOjIxOiJ1bmxpbmsoJHdyaXRhYmxlX2RpcnMiO2k6NzE7czo0MToiZmlsZV9nZXRfY29udGVudHModHJpbSgkZlskX0dFVFsnaWQnXV0pKTsiO2k6NzI7czoxMDoiQ3liZXN0ZXI5MCI7aTo3MztzOjI3OiIvaG9tZS9teWRpci9lZ2dkcm9wL2ZpbGVzeXMiO2k6NzQ7czoyOToiLS1EQ0NESVIgW2xpbmRleCAkVXNlcigkaSkgMl0iO2k6NzU7czoxMjoidW5iaW5kIFJBVyAtIjtpOjc2O3M6MTE6InB1dGJvdCAkYm90IjtpOjc3O3M6MTM6InByaXZtc2cgJG5pY2siO2k6Nzg7czoyNjoicHJvYyBodHRwOjpDb25uZWN0IHt0b2tlbn0iO2k6Nzk7czo0Mzoic2V0IGdvb2dsZShkYXRhKSBbaHR0cDo6ZGF0YSAkZ29vZ2xlKHBhZ2UpXSI7aTo4MDtzOjIyOiJiaW5kIGpvaW4gLSAqIGdvcF9qb2luIjtpOjgxO3M6MTM6InByaXZtc2cgJGNoYW4iO2k6ODI7czoyNDoicjRhVGMuZFBudEUvZnp0U0YxYkgzUkgwIjtpOjgzO3M6MTA6ImJpbmQgZGNjIC0iO2k6ODQ7czozNToia2lsbCAtQ0hMRCBcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6ODU7czo1MDoicmVnc3ViIC1hbGwgLS0gLCBbc3RyaW5nIHRvbG93ZXIgJG93bmVyXSAiIiBvd25lcnMiO2k6ODY7czozMDoiYmluZCBmaWx0IC0gIlwwMDFBQ1RJT04gKlwwMDEiIjtpOjg3O3M6Mjc6ImF5dSBwcjEgcHIyIHByMyBwcjQgcHI1IHByNiI7aTo4ODtzOjIwOiJzZXQgcHJvdGVjdC10ZWxuZXQgMCI7aTo4OTtzOjMzOiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGQgLURTU0wiO2k6OTA7czo3NjoiJHRzdTJbcmFuZCgwLGNvdW50KCR0c3UyKSAtIDEpXS4kdHN1MVtyYW5kKDAsY291bnQoJHRzdTEpIC0gMSldLiR0c3UyW3JhbmQoMCI7aTo5MTtzOjE5OiJmb3BlbignL2V0Yy9wYXNzd2QnIjtpOjkyO3M6MzU6IjBkMGEwZDBhNjc2YzZmNjI2MTZjMjAyNDZkNzk1ZjczNmQ3IjtpOjkzO3M6Mzc6IkpIWnBjMmwwWTI5MWJuUWdQU0FrU0ZSVVVGOURUMDlMU1VWZlYiO2k6OTQ7czo1OiJlLyouLyI7aTo5NTtzOjI4OiJAc2V0Y29va2llKCJoaXQiLCAxLCB0aW1lKCkrIjtpOjk2O3M6NDY6ImZpbmRfZGlycygkZ3JhbmRwYXJlbnRfZGlyLCAkbGV2ZWwsIDEsICRkaXJzKTsiO2k6OTc7czo2OToiQGNvcHkoJF9GSUxFU1tmaWxlTWFzc11bdG1wX25hbWVdLCRfUE9TVFtwYXRoXS4kX0ZJTEVTW2ZpbGVNYXNzXVtuYW1lIjtpOjk4O3M6NzY6ImludDMyKCgoJHogPj4gNSAmIDB4MDdmZmZmZmYpIF4gJHkgPDwgMikgKyAoKCR5ID4+IDMgJiAweDFmZmZmZmZmKSBeICR6IDw8IDQiO2k6OTk7czoxMToiVk9CUkEgR0FOR08iO2k6MTAwO3M6NTk6ImVjaG8geSA7IHNsZWVwIDEgOyB9IHwgeyB3aGlsZSByZWFkIDsgZG8gZWNobyB6JFJFUExZOyBkb25lIjtpOjEwMTtzOjk6IjxzdGRsaWIuaCI7aToxMDI7czo0NToiYWRkX2ZpbHRlcigndGhlX2NvbnRlbnQnLCAnX2Jsb2dpbmZvJywgMTAwMDEpIjtpOjEwMztzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aToxMDQ7czoyODoiaWYgc2VsZi5oYXNoX3R5cGUgPT0gJ3B3ZHVtcCI7aToxMDU7czo1OToiJGZyYW1ld29yay5wbHVnaW5zLmxvYWQoIiN7cnBjdHlwZS5kb3duY2FzZX1ycGMiLCBvcHRzKS5ydW4iO2k6MTA2O3M6NTc6InN1YnByb2Nlc3MuUG9wZW4oJyVzZ2RiIC1wICVkIC1iYXRjaCAlcycgJSAoZ2RiX3ByZWZpeCwgcCI7aToxMDc7czo1NzoiYXJncGFyc2UuQXJndW1lbnRQYXJzZXIoZGVzY3JpcHRpb249aGVscCwgcHJvZz0ic2N0dW5uZWwiIjtpOjEwODtzOjMyOiJydWxlX3JlcSA9IHJhd19pbnB1dCgiU291cmNlRmlyZSI7aToxMDk7czo1MDoib3Muc3lzdGVtKCdlY2hvIGFsaWFzIGxzPSIubHMuYmFzaCIgPj4gfi8uYmFzaHJjJykiO2k6MTEwO3M6NDI6ImNvbm5lY3Rpb24uc2VuZCgic2hlbGwgIitzdHIob3MuZ2V0Y3dkKCkpKyI7aToxMTE7czo2NzoicHJpbnQoIlshXSBIb3N0OiAiICsgaG9zdG5hbWUgKyAiIG1pZ2h0IGJlIGRvd24hXG5bIV0gUmVzcG9uc2UgQ29kZSI7aToxMTI7czo2OToiZGVmIGRhZW1vbihzdGRpbj0nL2Rldi9udWxsJywgc3Rkb3V0PScvZGV2L251bGwnLCBzdGRlcnI9Jy9kZXYvbnVsbCcpIjtpOjExMztzOjgzOiJzdWJwcm9jZXNzLlBvcGVuKGNtZCwgc2hlbGwgPSBUcnVlLCBzdGRvdXQ9c3VicHJvY2Vzcy5QSVBFLCBzdGRlcnI9c3VicHJvY2Vzcy5TVERPVSI7aToxMTQ7czo0NzoiaWYoaXNzZXQoJF9HRVRbJ2hvc3QnXSkmJmlzc2V0KCRfR0VUWyd0aW1lJ10pKXsiO2k6MTE1O3M6MTU6Ik5JR0dFUlMuTklHR0VSUyI7aToxMTY7czoyNToiSFRUUCBmbG9vZCBjb21wbGV0ZSBhZnRlciI7aToxMTc7czoyMToiODAgLWIgJDEgLWkgZXRoMCAtcyA4IjtpOjExODtzOjEzOiJleHBsb2l0Y29va2llIjtpOjExOTtzOjI2OiJzeXN0ZW0oInBocCAtZiB4cGwgJGhvc3QiKSI7aToxMjA7czoxMToic2ggZ28gJDEuJHgiO2k6MTIxO3M6MTI6ImF6ODhwaXgwMHE5OCI7aToxMjI7czozMDoidW5sZXNzKG9wZW4oUEZELCRnX3VwbG9hZF9kYikpIjtpOjEyMztzOjExOiJ3d3cudDBzLm9yZyI7aToxMjQ7czozOToiJHZhbHVlID1+IHMvJSguLikvcGFjaygnYycsaGV4KCQxKSkvZWc7IjtpOjEyNTtzOjE0OiJUaGUgRGFyayBSYXZlciI7aToxMjY7czoyOToifWVsc2VpZigkX0dFVFsncGFnZSddPT0nZGRvcyciO2k6MTI3O3M6MTY6InskX1BPU1RbJ3Jvb3QnXX0iO2k6MTI4O3M6Mzk6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kKzMrOHF2cXFTMUswK0FYWSI7aToxMjk7czo2NDoiRkozRmt1UEtGa1UvNTNXRUJtSWFpcGt0bkx3UVc4ejQ5ZGMxcmJiTHFzdzhlNjlsNnZKTSszLzEyNHhWbis3bCI7aToxMzA7czoxMDI6Ilx1MDAzY1x1MDA2OVx1MDA2ZFx1MDA2N1x1MDAyMFx1MDA3M1x1MDA3Mlx1MDA2M1x1MDAzZFx1MDAyMlx1MDA2OFx1MDA3NFx1MDA3NFx1MDA3MFx1MDAzYVx1MDAyZlx1MDAyZiI7aToxMzE7czozMDoiZnJlYWQoJGZwLCBmaWxlc2l6ZSgkZmljaGVybykpIjtpOjEzMjtzOjI0OiIkYmFzbGlrPSRfUE9TVFsnYmFzbGlrJ10iO2k6MTMzO3M6MTg6InByb2Nfb3BlbignSUhTdGVhbSI7aToxMzQ7czo1NjoiXHgzMVx4ZGJceGY3XHhlM1x4NTNceDQzXHg1M1x4NmFceDAyXHg4OVx4ZTFceGIwXHg2Nlx4Y2QiO2k6MTM1O3M6NTg6IkFBQUFBQUFBTUFBd0FCQUFBQWVBVUFBRFFBQUFEc0NRQUFBQUFBQURRQUlBQURBQ2dBRndBVUFBRUEiO2k6MTM2O3M6MzE6IiRpbmlbJ3VzZXJzJ10gPSBhcnJheSgncm9vdCcgPT4iO2k6MTM3O3M6NTg6IkhKM0hqdXRja29SZnBYZjlBMXpRTzJBd0RSclJleTl1R3ZUZWV6NzlxQWFvMWEwcmd1ZGtaa1I4UmEiO2k6MTM4O3M6NTA6ImN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICJodHRwOi8vJGhvc3Q6MjA4MiIpIjtpOjEzOTtzOjY0OiI8JT0gIlwiICYgb1NjcmlwdE5ldC5Db21wdXRlck5hbWUgJiAiXCIgJiBvU2NyaXB0TmV0LlVzZXJOYW1lICU+IjtpOjE0MDtzOjEwNDoic3FsQ29tbWFuZC5QYXJhbWV0ZXJzLkFkZCgoKFRhYmxlQ2VsbClkYXRhR3JpZEl0ZW0uQ29udHJvbHNbMF0pLlRleHQsIFNxbERiVHlwZS5EZWNpbWFsKS5WYWx1ZSA9IGRlY2ltYWwiO2k6MTQxO3M6OTA6IlJlc3BvbnNlLldyaXRlKCI8YnI+KCApIDxhIGhyZWY9P3R5cGU9MSZmaWxlPSIgJiBzZXJ2ZXIuVVJMZW5jb2RlKGl0ZW0ucGF0aCkgJiAiXD4iICYgaXRlbSI7aToxNDI7czoxMTE6Im5ldyBGaWxlU3RyZWFtKFBhdGguQ29tYmluZShmaWxlSW5mby5EaXJlY3RvcnlOYW1lLCBQYXRoLkdldEZpbGVOYW1lKGh0dHBQb3N0ZWRGaWxlLkZpbGVOYW1lKSksIEZpbGVNb2RlLkNyZWF0ZSI7aToxNDM7czo3MToiUmVzcG9uc2UuV3JpdGUoU2VydmVyLkh0bWxFbmNvZGUodGhpcy5FeGVjdXRlQ29tbWFuZCh0eHRDb21tYW5kLlRleHQpKSkiO2k6MTQ0O3M6ODM6IjwlPVJlcXVlc3QuU2VydmVydmFyaWFibGVzKCJTQ1JJUFRfTkFNRSIpJT4/dHh0cGF0aD08JT1SZXF1ZXN0LlF1ZXJ5U3RyaW5nKCJ0eHRwYXRoIjtpOjE0NTtzOjYwOiJvdXRzdHIgKz0gc3RyaW5nLkZvcm1hdCgiPGEgaHJlZj0nP2ZkaXI9ezB9Jz57MX0vPC9hPiZuYnNwOyIiO2k6MTQ2O3M6MzM6InJlLmZpbmRhbGwoZGlydCsnKC4qKScscHJvZ25tKVswXSI7aToxNDc7czo0MDoiZmluZCAvIC1uYW1lIC5zc2ggPiAkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToxNDg7czo2MDoiRlNfY2hrX2Z1bmNfbGliYz0oICQocmVhZGVsZiAtcyAkRlNfbGliYyB8IGdyZXAgX2Noa0BAIHwgYXdrIjtpOjE0OTtzOjQ5OiJMeTgzTVRnM09XUXlNVEprWXpoalltWTBaRFJtWkRBME5HRXpaREUzWmprM1ptSTJOIjtpOjE1MDtzOjk1OiIkZmlsZSA9ICRfRklMRVNbImZpbGVuYW1lIl1bIm5hbWUiXTsgZWNobyAiPGEgaHJlZj1cIiRmaWxlXCI+JGZpbGU8L2E+Ijt9IGVsc2Uge2VjaG8oImVtcHR5Iik7fSI7aToxNTE7czo0ODoiREo3VklVN1JJQ1hyNnNFRVYyY0J0SERTT2U5blZkcEVHaEVtdlJWUk5VUmZ3MXdRIjtpOjE1MjtzOjUxOiJMejhfTHk4dkR4OGVfdjctN3U3dTNzN3V6czdPenE2dW5xN2VycTZ1dnE1LWpvNnVqbjUiO2k6MTUzO3M6ODM6ImlWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFBb0FBQUFJQ0FZQUFBREEtbTYyQUFBQUFYTlNSMElBcnM0YzZRQUFBQVJuUVUxQkFBQ3hqd3Y4WVFVIjtpOjE1NDtzOjUxOiJzZXJ2ZXIuPC9wPlxyXG48L2JvZHk+PC9odG1sPiI7ZXhpdDt9aWYocHJlZ19tYXRjaCgiO2k6MTU1O3M6Nzc6IiRGY2htb2QsJEZkYXRhLCRPcHRpb25zLCRBY3Rpb24sJGhkZGFsbCwkaGRkZnJlZSwkaGRkcHJvYywkdW5hbWUsJGlkZCk6c2hhcmVkIjtpOjE1NjtzOjE1OiJwaHAgIi4kd3NvX3BhdGgiO2k6MTU3O3M6NjE6IiRwcm9kPSJzeSIuInMiLiJ0ZW0iOyRpZD0kcHJvZCgkX1JFUVVFU1RbJ3Byb2R1Y3QnXSk7JHsnaWQnfTsiO2k6MTU4O3M6MzA6IkBhc3NlcnQoJF9SRVFVRVNUWydQSFBTRVNTSUQnXSI7aToxNTk7czo2ODoiUE9TVCB7JHBhdGh9eyRjb25uZWN0b3J9P0NvbW1hbmQ9RmlsZVVwbG9hZCZUeXBlPUZpbGUmQ3VycmVudEZvbGRlcj0iO2k6MTYwO3M6ODc6IiJhZG1pbjEucGhwIiwgImFkbWluMS5odG1sIiwgImFkbWluMi5waHAiLCAiYWRtaW4yLmh0bWwiLCAieW9uZXRpbS5waHAiLCAieW9uZXRpbS5odG1sIiI7aToxNjE7czo5NzoiQHBhdGgxPSgnYWRtaW4vJywnYWRtaW5pc3RyYXRvci8nLCdtb2RlcmF0b3IvJywnd2ViYWRtaW4vJywnYWRtaW5hcmVhLycsJ2JiLWFkbWluLycsJ2FkbWluTG9naW4vJyI7aToxNjI7czozNjoiY2F0ICR7YmxrbG9nWzJdfSB8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjE2MztzOjQ2OiI/dXJsPScuJF9TRVJWRVJbJ0hUVFBfSE9TVCddKS51bmxpbmsoUk9PVF9ESVIuIjtpOjE2NDtzOjQ2OiJsb25nIGludDp0KDAsMyk9cigwLDMpOy0yMTQ3NDgzNjQ4OzIxNDc0ODM2NDc7IjtpOjE2NTtzOjc1OiJjcmVhdGVfZnVuY3Rpb24oIiYkIi4iZnVuY3Rpb24iLCIkIi4iZnVuY3Rpb24gPSBjaHIob3JkKCQiLiJmdW5jdGlvbiktMyk7IikiO2k6MTY2O3M6ODY6ImZ1bmN0aW9uIGdvb2dsZV9ib3QoKSB7JHNVc2VyQWdlbnQgPSBzdHJ0b2xvd2VyKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSk7aWYoIShzdHJwIjtpOjE2NztzOjc0OiJjb3B5KCRfRklMRVNbJ3Vwa2snXVsndG1wX25hbWUnXSwia2svIi5iYXNlbmFtZSgkX0ZJTEVTWyd1cGtrJ11bJ25hbWUnXSkpOyI7aToxNjg7czo2NzoiZm9yICgkdmFsdWUpIHsgcy8mLyZhbXA7L2c7IHMvPC8mbHQ7L2c7IHMvPi8mZ3Q7L2c7IHMvIi8mcXVvdDsvZzsgfSI7aToxNjk7czo0MjoiJGRiX2QgPSBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSwkY29uMSk7IjtpOjE3MDtzOjUxOiJTZW5kIHRoaXMgZmlsZTogPElOUFVUIE5BTUU9InVzZXJmaWxlIiBUWVBFPSJmaWxlIj4iO2k6MTcxO3M6MjI6ImZ3cml0ZSAoJGZwLCAiJHlhemkiKTsiO2k6MTcyO3M6NTI6Im1hcCB7IHJlYWRfc2hlbGwoJF8pIH0gKCRzZWxfc2hlbGwtPmNhbl9yZWFkKDAuMDEpKTsiO2k6MTczO3M6Mjc6IjI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOyI7aToxNzQ7czo1OToiZ2xvYmFsICRteXNxbEhhbmRsZSwgJGRibmFtZSwgJHRhYmxlbmFtZSwgJG9sZF9uYW1lLCAkbmFtZSwiO2k6MTc1O3M6Njk6Il9fYWxsX18gPSBbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXSI7aToxNzY7czoyOToiaWYgKGlzX2ZpbGUoIi90bXAvJGVraW5jaSIpKXsiO2k6MTc3O3M6Mzg6ImlmKCRjbWQgIT0gIiIpIHByaW50IFNoZWxsX0V4ZWMoJGNtZCk7IjtpOjE3ODtzOjI2OiIkY21kID0gKCRfUkVRVUVTVFsnY21kJ10pOyI7aToxNzk7czo1NToiJHVwbG9hZGZpbGUgPSAkcnBhdGguIi8iIC4gJF9GSUxFU1sndXNlcmZpbGUnXVsnbmFtZSddOyI7aToxODA7czozMzoiaWYgKCRmdW5jYXJnID1+IC9ecG9ydHNjYW4gKC4qKS8pIjtpOjE4MTtzOjQ2OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3QuU2VydmVyVmFyaWFibGVzICU+IjtpOjE4MjtzOjQ4OiJpZignJz09KCRkZj1AaW5pX2dldCgnZGlzYWJsZV9mdW5jdGlvbnMnKSkpe2VjaG8iO2k6MTgzO3M6Mzg6IiRmaWxlbmFtZSA9ICRiYWNrdXBzdHJpbmcuIiRmaWxlbmFtZSI7IjtpOjE4NDtzOjI0OiIkZnVuY3Rpb24oJF9QT1NUWydjbWQnXSkiO2k6MTg1O3M6Mjk6ImVjaG8gIkZJTEUgVVBMT0FERUQgVE8gJGRleiI7IjtpOjE4NjtzOjY4OiJpZiAoIUBpc19saW5rKCRmaWxlKSAmJiAoJHIgPSByZWFscGF0aCgkZmlsZSkpICE9IEZBTFNFKSAkZmlsZSA9ICRyOyI7aToxODc7czo4NzoiVU5JT04gU0VMRUNUICcwJyAsICc8PyBzeXN0ZW0oXCRfR0VUW2NwY10pO2V4aXQ7ID8+JyAsMCAsMCAsMCAsMCBJTlRPIE9VVEZJTEUgJyRvdXRmaWxlIjtpOjE4ODtzOjg5OiJpZihtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1siZmljIl1bInRtcF9uYW1lIl0sZ29vZF9saW5rKCIuLyIuJF9GSUxFU1siZmljIl1bIm5hbWUiXSkpKSI7aToxODk7czo3MjoiY29ubmVjdChTT0NLRVQsIHNvY2thZGRyX2luKCRBUkdWWzFdLCBpbmV0X2F0b24oJEFSR1ZbMF0pKSkgb3IgZGllIHByaW50IjtpOjE5MDtzOjUyOiJlbHNlaWYoQGlzX3dyaXRhYmxlKCRGTikgJiYgQGlzX2ZpbGUoJEZOKSkgJHRtcE91dE1GIjtpOjE5MTtzOjY4OiJ3aGlsZSAoJHJvdyA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXN1bHQsTVlTUUxfQVNTT0MpKSBwcmludF9yKCRyb3cpOyI7aToxOTI7czoxODoiJGZlKCIkY21kICAyPiYxIik7IjtpOjE5MztzOjY5OiJzZW5kKFNPQ0s1LCAkbXNnLCAwLCBzb2NrYWRkcl9pbigkcG9ydGEsICRpYWRkcikpIGFuZCAkcGFjb3Rlc3tvfSsrOzsiO2k6MTk0O3M6Njk6In0gZWxzaWYgKCRzZXJ2YXJnID1+IC9eXDooLis/KVwhKC4rPylcQCguKz8pIFBSSVZNU0cgKC4rPykgXDooLispLykgeyI7aToxOTU7czozNzoiZWxzZWlmKGZ1bmN0aW9uX2V4aXN0cygic2hlbGxfZXhlYyIpKSI7aToxOTY7czo3MToic3lzdGVtKCIkY21kIDE+IC90bXAvY21kdGVtcCAyPiYxOyBjYXQgL3RtcC9jbWR0ZW1wOyBybSAvdG1wL2NtZHRlbXAiKTsiO2k6MTk3O3M6NTI6IiRfRklMRVNbJ3Byb2JlJ11bJ3NpemUnXSwgJF9GSUxFU1sncHJvYmUnXVsndHlwZSddKTsiO2k6MTk4O3M6ODc6IiRyYTQ0ICA9IHJhbmQoMSw5OTk5OSk7JHNqOTggPSAic2gtJHJhNDQiOyRtbCA9ICIkc2Q5OCI7JGE1ID0gJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOyI7aToxOTk7czo2NjoibXlzcWxfcXVlcnkoIkNSRUFURSBUQUJMRSBgeHBsb2l0YCAoYHhwbG9pdGAgTE9OR0JMT0IgTk9UIE5VTEwpIik7IjtpOjIwMDtzOjY2OiJwYXNzdGhydSggJGJpbmRpci4ibXlzcWxkdW1wIC0tdXNlcj0kVVNFUk5BTUUgLS1wYXNzd29yZD0kUEFTU1dPUkQiO2k6MjAxO3M6ODQ6IjxhIGhyZWY9JyRQSFBfU0VMRj9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9JGRibmFtZSZ0YWJsZW5hbWU9JHRhYmxlbmFtZSc+U2NoZW1hPC9hPiI7aToyMDI7czo2MDoiaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkkc2hlbGxPdXQ9c3RyaXBzbGFzaGVzKCRzaGVsbE91dCk7IjtpOjIwMztzOjQ3OiJpZiAoIWRlZmluZWQkcGFyYW17Y21kfSl7JHBhcmFte2NtZH09ImxzIC1sYSJ9OyI7aToyMDQ7czoyMzoic2hlbGxfZXhlYygndW5hbWUgLWEnKTsiO2k6MjA1O3M6OTE6ImlmIChtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1snZmlsYSddWyd0bXBfbmFtZSddLCAkY3VyZGlyLiIvIi4kX0ZJTEVTWydmaWxhJ11bJ25hbWUnXSkpIHsiO2k6MjA2O3M6ODM6ImlmIChlbXB0eSgkX1BPU1RbJ3dzZXInXSkpIHskd3NlciA9ICJ3aG9pcy5yaXBlLm5ldCI7fSBlbHNlICR3c2VyID0gJF9QT1NUWyd3c2VyJ107IjtpOjIwNztzOjM2OiI8JT1lbnYucXVlcnlIYXNodGFibGUoInVzZXIubmFtZSIpJT4iO2k6MjA4O3M6NjE6IlB5U3lzdGVtU3RhdGUuaW5pdGlhbGl6ZShTeXN0ZW0uZ2V0UHJvcGVydGllcygpLCBudWxsLCBhcmd2KTsiO2k6MjA5O3M6MzU6ImlmKCEkd2hvYW1pKSR3aG9hbWk9ZXhlYygid2hvYW1pIik7IjtpOjIxMDtzOjM2OiJzaGVsbF9leGVjKCRfUE9TVFsnY21kJ10gLiAiIDI+JjEiKTsiO2k6MjExO3M6NTM6IlBuVmxrV002MyFAI0AmZEt4fm5NRFdNfkR/L0Vzbn54fzZEQCNAJlB+fiw/blksV1B7UG9qIjtpOjIxMjtzOjI1OiIhJF9SRVFVRVNUWyJjOTlzaF9zdXJsIl0pIjtpOjIxMztzOjYwOiIoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0qJCcsICRfUkVRVUVTVFsnY29tbWFuZCddKSkiO2k6MjE0O3M6MjM6IiRsb2dpbj1AcG9zaXhfZ2V0dWlkKCk7IjtpOjIxNTtzOjM4OiJzeXN0ZW0oInVuc2V0IEhJU1RGSUxFOyB1bnNldCBTQVZFSElTVCI7aToyMTY7czozMToiPEhUTUw+PEhFQUQ+PFRJVExFPmNnaS1zaGVsbC5weSI7aToyMTc7czozNjoiZXhlY2woIi9iaW4vc2giLCJzaCIsIi1pIiwoY2hhciopMCk7IjtpOjIxODtzOjI2OiJuY2Z0cHB1dCAtdSAkZnRwX3VzZXJfbmFtZSI7aToyMTk7czoyOToiJGFbaGl0c10nKTsgXHJcbiNlbmRxdWVyeVxyXG4iO2k6MjIwO3M6MjM6Inske3Bhc3N0aHJ1KCRjbWQpfX08YnI+IjtpOjIyMTtzOjQyOiIkYmFja2Rvb3ItPmNjb3B5KCRjZmljaGllciwkY2Rlc3RpbmF0aW9uKTsiO2k6MjIyO3M6NTk6IiRpemlubGVyMj1zdWJzdHIoYmFzZV9jb252ZXJ0KEBmaWxlcGVybXMoJGZuYW1lKSwxMCw4KSwtNCk7IjtpOjIyMztzOjUwOiJmb3IoOyRwYWRkcj1hY2NlcHQoQ0xJRU5ULCBTRVJWRVIpO2Nsb3NlIENMSUVOVCkgeyI7aToyMjQ7czo4OiJBc21vZGV1cyI7aToyMjU7czozNzoicGFzc3RocnUoZ2V0ZW52KCJIVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyMjY7czozOToiJF9fX189QGd6aW5mbGF0ZSgkX19fXykpe2lmKGlzc2V0KCRfUE9TIjtpOjIyNztzOjg1OiIkc3Viaj11cmxkZWNvZGUoJF9HRVRbJ3N1J10pOyRib2R5PXVybGRlY29kZSgkX0dFVFsnYm8nXSk7JHNkcz11cmxkZWNvZGUoJF9HRVRbJ3NkJ10pIjtpOjIyODtzOjMyOiIka2E9Jzw/Ly9CUkUnOyRrYWthPSRrYS4nQUNLLy8/PiI7aToyMjk7czozMToiQ2F1dGFtIGZpc2llcmVsZSBkZSBjb25maWd1cmFyZSI7aToyMzA7czoxMjoiQlJVVEVGT1JDSU5HIjtpOjIzMTtzOjE4OiJwd2QgPiBHZW5lcmFzaS5kaXIiO2k6MjMyO3M6NTY6InhoIC1zICIvdXNyL2xvY2FsL2FwYWNoZS9zYmluL2h0dHBkIC1EU1NMIiAuL2h0dHBkIC1tICQxIjtpOjIzMztzOjQ4OiIkYT0oc3Vic3RyKHVybGVuY29kZShwcmludF9yKGFycmF5KCksMSkpLDUsMSkuYykiO2k6MjM0O3M6MjE6IiFAJF9DT09LSUVbJHNlc3NkdF9rXSI7aToyMzU7czo1ODoiU0VMRUNUIDEgRlJPTSBteXNxbC51c2VyIFdIRVJFIGNvbmNhdChgdXNlcmAsICdAJywgYGhvc3RgKSI7aToyMzY7czo0NDoiY29weSgkX0ZJTEVTW3hdW3RtcF9uYW1lXSwkX0ZJTEVTW3hdW25hbWVdKSkiO2k6MjM3O3M6NTQ6IiRNZXNzYWdlU3ViamVjdCA9IGJhc2U2NF9kZWNvZGUoJF9QT1NUWyJtc2dzdWJqZWN0Il0pOyI7aToyMzg7czoxNzoicmVuYW1lKCJ3c28ucGhwIiwiO2k6MjM5O3M6ODg6IiRyZWRpcmVjdFVSTD0naHR0cDovLycuJHJTaXRlLiRfU0VSVkVSWydSRVFVRVNUX1VSSSddO2lmKGlzc2V0KCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSkiO2k6MjQwO3M6NDA6IiRmaWxlcGF0aD1AcmVhbHBhdGgoJF9QT1NUWydmaWxlcGF0aCddKTsiO2k6MjQxO3M6NDI6Ildvcmtlcl9HZXRSZXBseUNvZGUoJG9wRGF0YVsncmVjdkJ1ZmZlciddKSI7aToyNDI7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjI0MztzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjI0NDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjI0NTtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToyNDY7czoxMjoiUEhQU0hFTEwuUEhQIjtpOjI0NztzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjI0ODtzOjExMDoidnp2NmQraU92dGtkMzhUbEh1OG1RYXZYZG5KQ2JwUWNwWGhOYmJMbVpPcU1vcERaZU5hbGIrVktsZWRoQ2pwVkFNUVNRbnhWSUVDUUFmTHU1S2dMbXdCNmVoUVFHTlNCWWpwZzlnNUdkQmloWG8iO2k6MjQ5O3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjI1MDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjI1MTtzOjE0MjoiNWpiMjBpS1c5eUlITjBjbWx6ZEhJb0pISmxabVZ5WlhJc0ltRndiM0owSWlrZ2IzSWdjM1J5YVhOMGNpZ2tjbVZtWlhKbGNpd2libWxuYldFaUtTQnZjaUJ6ZEhKcGMzUnlLQ1J5WldabGNtVnlMQ0ozWldKaGJIUmhJaWtnYjNJZ2MzUnlhWE4wY2lnayI7aToyNTI7czo0ODoid3NvRXgoJ3RhciBjZnp2ICcgLiBlc2NhcGVzaGVsbGFyZygkX1BPU1RbJ3AyJ10pIjtpOjI1MztzOjg2OiI8bm9icj48Yj4kY2RpciRjZmlsZTwvYj4gKCIuJGZpbGVbInNpemVfc3RyIl0uIik8L25vYnI+PC90ZD48L3RyPjxmb3JtIG5hbWU9Y3Vycl9maWxlPiI7aToyNTQ7czoxNjoiQ29udGVudC1UeXBlOiAkXyI7aToyNTU7czoxNDE6IjwvdGQ+PHRkIGlkPWZhPlsgPGEgdGl0bGU9XCJIb21lOiAnIi5odG1sc3BlY2lhbGNoYXJzKHN0cl9yZXBsYWNlKCJcIiwgJHNlcCwgZ2V0Y3dkKCkpKS4iJy5cIiBpZD1mYSBocmVmPVwiamF2YXNjcmlwdDpWaWV3RGlyKCciLnJhd3VybGVuY29kZSI7aToyNTY7czoxMDc6IkNRYm9HbDdmK3hjQXlVeXN4YjVtS1M2a0FXc25STGRTK3NLZ0dvWldkc3dMRkpaVjh0VnpYc3ErbWVTUEhNeFRJM25TVUI0ZkoydlIzcjNPbnZYdE5BcU42d24vRHRUVGkrQ3UxVU9Kd05MIjtpOjI1NztzOjM5OiJXU09zZXRjb29raWUobWQ1KCRfU0VSVkVSWydIVFRQX0hPU1QnXSkiO2k6MjU4O3M6MTI2OiJYMU5GVTFOSlQwNWJKM1I0ZEdGMWRHaHBiaWRkSUQwZ2RISjFaVHNOQ2lBZ0lDQnBaaUFvSkY5UVQxTlVXeWR5YlNkZEtTQjdEUW9nSUNBZ0lDQnpaWFJqYjI5cmFXVW9KM1I0ZEdGMWRHaGZKeTRrY20xbmNtOTFjQ3dnYlciO2k6MjU5O3M6Mzk6IkpAIVZyQComUkhSd35KTHcuR3x4bGhuTEp+PzEuYndPYnhiUHwhViI7aToyNjA7czoxMToiemVoaXJoYWNrZXIiO2k6MjYxO3M6MTYxOiIoJyInLCcmcXVvdDsnLCRmbikpLiciO2RvY3VtZW50Lmxpc3Quc3VibWl0KCk7XCc+Jy5odG1sc3BlY2lhbGNoYXJzKHN0cmxlbigkZm4pPmZvcm1hdD9zdWJzdHIoJGZuLDAsZm9ybWF0LTMpLicuLi4nOiRmbikuJzwvYT4nLnN0cl9yZXBlYXQoJyAnLGZvcm1hdC1zdHJsZW4oJGZuKSI7aToyNjI7czoxNjA6InByaW50KChpc19yZWFkYWJsZSgkZikgJiYgaXNfd3JpdGVhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiLncoMSkuZm9udCgncmVkJywnUlcnLDMpKS53KDEpOigoKGlzX3JlYWRhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiKS53KDQpOiIiKS4oKGlzX3dyaXRhYmwiO2k6MjYzO3M6NzM6IlIwbEdPRGxoRkFBVUFLSUFBQUFBQVAvLy85M2QzY0RBd0lhR2hnUUVCUC8vL3dBQUFDSDVCQUVBQUFZQUxBQUFBQUFVQUJRQUEiO2k6MjY0O3M6OTA6IjwlPVJlcXVlc3QuU2VydmVyVmFyaWFibGVzKCJzY3JpcHRfbmFtZSIpJT4/Rm9sZGVyUGF0aD08JT1TZXJ2ZXIuVVJMUGF0aEVuY29kZShGb2xkZXIuRHJpdiI7aToyNjU7czoxMTM6Im05MWRDd2dKR1Z2ZFhRcE93MEtjMlZzWldOMEtDUnliM1YwSUQwZ0pISnBiaXdnZFc1a1pXWXNJQ1JsYjNWMElEMGdKSEpwYml3Z01USXdLVHNOQ21sbUlDZ2hKSEp2ZFhRZ0lDWW1JQ0FoSkdWdmRYIjtpOjI2NjtzOjM4OiJSb290U2hlbGwhJyk7c2VsZi5sb2NhdGlvbi5ocmVmPSdodHRwOiI7aToyNjc7czo3NjoiYSBocmVmPSI8P2VjaG8gIiRmaXN0aWsucGhwP2RpemluPSRkaXppbi8uLi8iPz4iIHN0eWxlPSJ0ZXh0LWRlY29yYXRpb246IG5vbiI7aToyNjg7czoxMjc6IkNCMmFUWnBJREV3TWpRdERRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSTNKbGNYVnAiO2k6MjY5O3M6MTIyOiJudCkoZGlza190b3RhbF9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iICIgLiAiRnJlZSBzcGFjZSAiIC4gKGludCkoZGlza19mcmVlX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgPCI7aToyNzA7czozNzoia2xhc3ZheXYuYXNwP3llbmlkb3N5YT08JT1ha3RpZmtsYXMlPiI7aToyNzE7czo0NDoiV1QrUHt+RVcwRXJQT3RuVUAjQCZebF5zUDFsZG55QCNAJm5zaytyMCxHVCsiO2k6MjcyO3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjI3MztzOjEwNToiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrK2pZRFU5MkM5NGpkdERpZit4T1lqRzZDTGh4MzFVbzl4OS9lQVdnc0JLNjBrSzJtTHdxenFkIjtpOjI3NDtzOjg2OiJjcmxmLid1bmxpbmsoJG5hbWUpOycuJGNybGYuJ3JlbmFtZSgifiIuJG5hbWUsICRuYW1lKTsnLiRjcmxmLid1bmxpbmsoImdycF9yZXBhaXIucGhwIiI7aToyNzU7czoxNToiRFhfSGVhZGVyX2RyYXduIjtpOjI3NjtzOjMwOiJbQXY0YmZDWUNTLHhLV2skK1RrVVMseG5HZEF4W08iO2k6Mjc3O3M6MTE6ImN0c2hlbGwucGhwIjtpOjI3ODtzOjQ3OiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj0jZGNkY2RjPlskY21kXSI7aToyNzk7czoxMzoiV1NDUklQVC5TSEVMTCI7aToyODA7czo3OiJjYXN1czE1IjtpOjI4MTtzOjE3OiJhZG1pbkBzcHlncnVwLm9yZyI7aToyODI7czoxNDoidGVtcF9yNTdfdGFibGUiO2k6MjgzO3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjI4NDtzOjk6IkJ5IFBzeWNoMCI7aToyODU7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToyODY7czo4NDoiPHRleHRhcmVhIG5hbWU9XCJwaHBldlwiIHJvd3M9XCI1XCIgY29scz1cIjE1MFwiPiIuQCRfUE9TVFsncGhwZXYnXS4iPC90ZXh0YXJlYT48YnI+IjtpOjI4NztzOjMwOiIkcmFuZF93cml0YWJsZV9mb2xkZXJfZnVsbHBhdGgiO2k6Mjg4O3M6MTA6IkRyLmFib2xhbGgiO2k6Mjg5O3M6NjoiSyFMTDNyIjtpOjI5MDtzOjc6Ik1ySGF6ZW0iO2k6MjkxO3M6MTA6IkMwZGVyei5jb20iO2k6MjkyO3M6MjY6Ik9MQjpQUk9EVUNUOk9OTElORV9CQU5LSU5HIjtpOjI5MztzOjEwOiJCWSBNTU5CT0JaIjtpOjI5NDtzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjI5NTtzOjg6IkhhY2tlYWRvIjtpOjI5NjtzOjU6ImQzYn5YIjtpOjI5NztzOjU6InJhaHVpIjtpOjI5ODtzOjk6Ik1yLkhpVG1hbiI7aToyOTk7czoxMzoiU0VvRE9SLUNsaWVudCI7aTozMDA7czoxMDoiTXJsb29sLmV4ZSI7aTozMDE7czoyNzoiU21hbGwgUEhQIFdlYiBTaGVsbCBieSBaYUNvIjtpOjMwMjtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MzAzO3M6MTM6IldTTzIgV2Vic2hlbGwiO2k6MzA0O3M6MTI6IldlYiBTaGVsbCBieSI7aTozMDU7czozMjoiV2F0Y2ggWW91ciBzeXN0ZW0gU2hhbnkgd2FzIGhlcmUiO2k6MzA2O3M6Mjg6ImRldmVsb3BlZCBieSBEaWdpdGFsIE91dGNhc3QiO2k6MzA3O3M6MTE6IldlYkNvbnRyb2xzIjtpOjMwODtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjMwOTtzOjk6IlczRCBTaGVsbCI7aTozMTA7czo5OiJUaGVfQmVLaVIiO2k6MzExO3M6MTE6IlN0b3JtN1NoZWxsIjtpOjMxMjtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjMxMztzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aTozMTQ7czoyNToiU2ltb3JnaCBTZWN1cml0eSBNYWdhemluZSI7aTozMTU7czoxOToiRy1TZWN1cml0eSBXZWJzaGVsbCI7aTozMTY7czoyNToiU2ltcGxlIFBIUCBiYWNrZG9vciBieSBESyI7aTozMTc7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MzE4O3M6MjA6IlNhZmVfTW9kZSBCeXBhc3MgUEhQIjtpOjMxOTtzOjEwOiJDckB6eV9LaW5nIjtpOjMyMDtzOjIxOiJLQWRvdCBVbml2ZXJzYWwgU2hlbGwiO2k6MzIxO3M6MTY6IlJ1MjRQb3N0V2ViU2hlbGwiO2k6MzIyO3M6MjA6InJlYWxhdXRoPVN2QkQ4NWRJTnUzIjtpOjMyMztzOjE1OiJyZ29kYHMgd2Vic2hlbGwiO2k6MzI0O3M6MTM6InI1N3NoZWxsXC5waHAiO2k6MzI1O3M6NjoiUjU3U3FsIjtpOjMyNjtzOjU6InIwbmluIjtpOjMyNztzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjMyODtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjMyOTtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTozMzA7czo2OiJQSFZheXYiO2k6MzMxO3M6MzU6IlBIUCBTaGVsbCBpcyBhbmludGVyYWN0aXZlIFBIUC1wYWdlIjtpOjMzMjtzOjEzOiJwaHBSZW1vdGVWaWV3IjtpOjMzMztzOjIwOiJQSFAgSFZBIFNoZWxsIFNjcmlwdCI7aTozMzQ7czo5OiJQSFBKYWNrYWwiO2k6MzM1O3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6MzM2O3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjMzNztzOjIxOiJhIHNpbXBsZSBwaHAgYmFja2Rvb3IiO2k6MzM4O3M6MjE6IlBJUkFURVMgQ1JFVyBXQVMgSEVSRSI7aTozMzk7czoxODoiUEhBTlRBU01BLSBOZVcgQ21EIjtpOjM0MDtzOjI2OiJPIEJpUiBLUkFMIFRBS0xpVCBFRGlsRU1FWiI7aTozNDE7czoyMDoiTklYIFJFTU9URSBXRUItU0hFTEwiO2k6MzQyO3M6MjE6Ik5ldHdvcmtGaWxlTWFuYWdlclBIUCI7aTozNDM7czo3OiJOZW9IYWNrIjtpOjM0NDtzOjE2OiJIYWNrZWQgYnkgU2lsdmVyIjtpOjM0NTtzOjg6Ik4zdHNoZWxsIjtpOjM0NjtzOjE0OiJNeVNRTCBXZWJzaGVsbCI7aTozNDc7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjM0ODtzOjE5OiJNeVNRTCBXZWIgSW50ZXJmYWNlIjtpOjM0OTtzOjk6Ik15U1FMIFJTVCI7aTozNTA7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjM1MTtzOjE2OiJNb3JvY2NhbiBTcGFtZXJzIjtpOjM1MjtzOjEwOiJNYXRhbXUgTWF0IjtpOjM1MztzOjU6Im0waHplIjtpOjM1NDtzOjY6Im0wcnRpeCI7aTozNTU7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6MzU2O3M6MTA6Ik1hdGFtdSBNYXQiO2k6MzU3O3M6MzY6Ik1vcm9jY2FuIFNwYW1lcnMgTWEtRWRpdGlvTiBCeSBHaE9zVCI7aTozNTg7czoxMToiTG9jdXM3U2hlbGwiO2k6MzU5O3M6NzoiTGl6MHppTSI7aTozNjA7czo5OiJLQV91U2hlbGwiO2k6MzYxO3M6MTE6ImlNSGFCaVJMaUdpIjtpOjM2MjtzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTozNjM7czoxNzoiSEFDS0VEIEJZIFJFQUxXQVIiO2k6MzY0O3M6MjU6IkhhY2tlZCBCeSBEZXZyLWkgTWVmc2VkZXQiO2k6MzY1O3M6Mjk6Img0bnR1IHNoZWxsIFtwb3dlcmVkIGJ5IHRzb2ldIjtpOjM2NjtzOjEzOiJHcmluYXkgR28wbyRFIjtpOjM2NztzOjE0OiJHb29nMWVfYW5hbGlzdCI7aTozNjg7czoxMToiR0hDIE1hbmFnZXIiO2k6MzY5O3M6MTM6IkdGUyBXZWItU2hlbGwiO2k6MzcwO3M6MjI6InRoaXMgaXMgYSBwcml2MyBzZXJ2ZXIiO2k6MzcxO3M6Mjc6Ikx1dGZlbiBEb3N5YXlpIEFkbGFuZGlyaW5peiI7aTozNzI7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjM3MztzOjIwOiJGaXhlZCBieSBBcnQgT2YgSGFjayI7aTozNzQ7czoyMDoiRW1wZXJvciBIYWNraW5nIFRFQU0iO2k6Mzc1O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjM3NjtzOjE1OiJEZXZyLWkgTWVmc2VkZXQiO2k6Mzc3O3M6MzM6IkRpdmUgU2hlbGwgLSBFbXBlcm9yIEhhY2tpbmcgVGVhbSI7aTozNzg7czoyNDoiU2hlbGwgd3JpdHRlbiBieSBCbDBvZDNyIjtpOjM3OTtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjM4MDtzOjc6ImQwbWFpbnMiO2k6MzgxO3M6MTE6IkN5YmVyIFNoZWxsIjtpOjM4MjtzOjIzOiJURUFNIFNDUklQVElORyAtIFJPRE5PQyI7aTozODM7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjM4NDtzOjM4OiJDb2RlZCBieSA6IFN1cGVyLUNyeXN0YWwgYW5kIE1vaGFqZXIyMiI7aTozODU7czoyMjoiY29va2llbmFtZSA9ICJ3aWVlZWVlIiI7aTozODY7czo5OiJDOTkgU2hlbGwiO2k6Mzg3O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjM4ODtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjM4OTtzOjk6ImMyMDA3LnBocCI7aTozOTA7czozMDoiV3JpdHRlbiBieSBDYXB0YWluIENydW5jaCBUZWFtIjtpOjM5MTtzOjExOiJkZXZpbHpTaGVsbCI7aTozOTI7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjM5MztzOjc6IkJsMG9kM3IiO2k6Mzk0O3M6MjI6IkNvZGVkIEJ5IENoYXJsaWNoYXBsaW4iO2k6Mzk1O3M6OToiYVpSYWlMUGhQIjtpOjM5NjtzOjE2OiJBU1BYIFNoZWxsIGJ5IExUIjtpOjM5NztzOjEyOiJBTEVNaU4gS1JBTGkiO2k6Mzk4O3M6MTQ6IkFudGljaGF0IHNoZWxsIjtpOjM5OTtzOjY6IjB4ZGQ4MiI7aTo0MDA7czo5OiJ+IFNoZWxsIEkiO2k6NDAxO3M6MTQ6Il9zaGVsbF9hdGlsZGlfIjtpOjQwMjtzOjExOiJQLmgucC5TLnAueSI7aTo0MDM7czoxMDoiMS4xNzkuMjQ5LiI7aTo0MDQ7czoxMToiNjQuMjMzLjE2MC4iO2k6NDA1O3M6OToiNjQuNjguODAuIjtpOjQwNjtzOjExOiIyMTYuMjM5LjMyLiI7aTo0MDc7czo4OiJORzY4OVNrdyI7fQ=="));
$gX_DBShe = unserialize(base64_decode("YTo2Mzp7aTowO3M6MjI6InJvb3Q6eDowOjA6cm9vdDovcm9vdDoiO2k6MTtzOjk6IkNlbmdpekhhbiI7aToyO3M6MTA6IkppbnBhbnRvbXoiO2k6MztzOjE0OiJLaW5nU2tydXBlbGxvcyI7aTo0O3M6OToiMW43M2N0MTBuIjtpOjU7czoxMDoiSmlucGFudG9teiI7aTo2O3M6OToiRGVpZGFyYX5YIjtpOjc7czoxNToiTXIuU2hpbmNoYW5YMTk2IjtpOjg7czoxNDoiTWV4aWNhbkhhY2tlcnMiO2k6OTtzOjE1OiJIQUNLRUQgQlkgU1RPUk0iO2k6MTA7czo3OiJLa0sxMzM3IjtpOjExO3M6NzoiazJsbDMzZCI7aToxMjtzOjE1OiJEYXJrQ3Jld0ZyaWVuZHMiO2k6MTM7czoxMToiU2ltQXR0YWNrZXIiO2k6MTQ7czoxMjoiXVtyb3VuZCgwKV0oIjtpOjE1O3M6MzI6IjwhLS0jZXhlYyBjbWQ9IiRIVFRQX0FDQ0VQVCIgLS0+IjtpOjE2O3M6NDoiQW0hciI7aToxNztzOjg6Iltjb2RlcnpdIjtpOjE4O3M6MTE6IlsgUGhwcm94eSBdIjtpOjE5O3M6NzoiRGVmYWNlciI7aToyMDtzOjExOiJEZXZpbEhhY2tlciI7aToyMTtzOjc6IndlYnIwMHQiO2k6MjI7czo2OiJrMGQuY2MiO2k6MjM7czo1NToiaXNfY2FsbGFibGUoJ2V4ZWMnKSBhbmQgIWluX2FycmF5KCdleGVjJywgJGRpc2FibGVmdW5jcyI7aToyNDtzOjE0OiIkR0xPQkFMU1snX19fXyI7aToyNTtzOjE4OiJpc193cml0YWJsZSgiL3Zhci8iO2k6MjY7czoyMzoiZXZhbChmaWxlX2dldF9jb250ZW50cygiO2k6Mjc7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aToyODtzOjQ5OiInaHR0cGQuY29uZicsJ3Zob3N0cy5jb25mJywnY2ZnLnBocCcsJ2NvbmZpZy5waHAnIjtpOjI5O3M6NzoiYnIwd3MzciI7aTozMDtzOjc6Im1pbHcwcm0iO2k6MzE7czozNjoiaW5jbHVkZSgkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pIjtpOjMyO3M6MTA6ImRpciAvT0cgL1giO2k6MzM7czozNDoiaWYgKCgkcGVybXMgJiAweEMwMDApID09IDB4QzAwMCkgeyI7aTozNDtzOjU5OiJpZiAoaXNfY2FsbGFibGUoImV4ZWMiKSBhbmQgIWluX2FycmF5KCJleGVjIiwkZGlzYWJsZWZ1bmMpKSI7aTozNTtzOjQwOiJzZXRjb29raWUoICJteXNxbF93ZWJfYWRtaW5fdXNlcm5hbWUiICk7IjtpOjM2O3M6MTk6InByaW50ICJTcGFtZWQnPjxicj4iO2k6Mzc7czo1MToiJG1lc3NhZ2UgPSBlcmVnX3JlcGxhY2UoIiU1QyUyMiIsICIlMjIiLCAkbWVzc2FnZSk7IjtpOjM4O3M6MTU6Ii9ldGMvbmFtZWQuY29uZiI7aTozOTtzOjEwOiIvZXRjL2h0dHBkIjtpOjQwO3M6MTE6Ii92YXIvY3BhbmVsIjtpOjQxO3M6MTg6Ik5lIHVkYWxvcyB6YWdydXppdCI7aTo0MjtzOjE0OiJleGVjKCJybSAtciAtZiI7aTo0MztzOjg6IlNoZWxsIE9rIjtpOjQ0O3M6MTE6Im15c2hlbGxleGVjIjtpOjQ1O3M6OToicm9vdHNoZWxsIjtpOjQ2O3M6OToiYW50aXNoZWxsIjtpOjQ3O3M6MTI6InI1N3NoZWxsLnBocCI7aTo0ODtzOjExOiJMb2N1czdTaGVsbCI7aTo0OTtzOjExOiJTdG9ybTdTaGVsbCI7aTo1MDtzOjg6Ik4zdHNoZWxsIjtpOjUxO3M6MTE6ImRldmlselNoZWxsIjtpOjUyO3M6MTI6IldlYiBTaGVsbCBieSI7aTo1MztzOjc6IkZ4Yzk5c2giO2k6NTQ7czo4OiJjaWhzaGVsbCI7aTo1NTtzOjc6Ik5URGFkZHkiO2k6NTY7czo4OiJyNTdzaGVsbCI7aTo1NztzOjg6ImM5OXNoZWxsIjtpOjU4O3M6NjI6IjxkaXYgY2xhc3M9ImJsb2NrIGJ0eXBlMSI+PGRpdiBjbGFzcz0iZHRvcCI+PGRpdiBjbGFzcz0iZGJ0bSI+IjtpOjU5O3M6OToiUm9vdFNoZWxsIjtpOjYwO3M6ODoicGhwc2hlbGwiO2k6NjE7czoyNDoiWW91IGNhbiBwdXQgYSBtZDUgc3RyaW5nIjtpOjYyO3M6NzoiZGVmYWNlciI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNzY6e2k6MDtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjE7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aToyO3M6NTg6ImZ1bmN0aW9uXHMrcmVhZF9waWNcKFxzKlwkQVxzKlwpXHMqe1xzKlwkYVxzKj1ccypcJF9TRVJWRVIiO2k6MztzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjQ7czo2MjoibGlzdFxzKlwoXHMqXCRob3N0XHMqLFxzKlwkcG9ydFxzKixccypcJHNpemVccyosXHMqXCRleGVjX3RpbWUiO2k6NTtzOjQxOiJsaXN0aW5nX3BhZ2VcKFxzKm5vdGljZVwoXHMqWyciXXN5bWxpbmtlZCI7aTo2O3M6MzU6Im1ha2VfZGlyX2FuZF9maWxlXChccypcJHBhdGhfam9vbWxhIjtpOjc7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjg7czo0MToiJiZccyohZW1wdHlcKFxzKlwkX0NPT0tJRVxbWyciXWZpbGxbJyJdXF0iO2k6OTtzOjMzOiJmaWxlX2V4aXN0c1xzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6MTA7czo1OToic3RyX3JlcGxhY2VcKFwkZmluZFxzKixccypcJGZpbmRccypcLlxzKlwkaHRtbFxzKixccypcJHRleHQiO2k6MTE7czozNjoiXCRkYXRhbWFzaWk9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjEyO3M6MzQ6IlwkYWRkZGF0ZT1kYXRlXCgiRCBNIGQsIFkgZzppIGEiXCkiO2k6MTM7czoxODoiZnVja1xzK3lvdXJccyttYW1hIjtpOjE0O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE1O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MTY7czoyODoiYXJyYXlcKFwkZW4sXCRlcyxcJGVmLFwkZWxcKSI7aToxNztzOjQ2OiJsb2Nccyo9XHMqWyciXXswLDF9PFw/ZWNob1xzK1wkcmVkaXJlY3Q7XHMqXD8+IjtpOjE4O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjE5O3M6MTg6Ij09MFwpe2pzb25RdWl0XChcJCI7aToyMDtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIxO3M6MzA6Ijo6WyciXVwucGhwdmVyc2lvblwoXClcLlsnIl06OiI7aToyMjtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMztzOjEzOiIiPT5cJHtcJHsiXFx4IjtpOjI0O3M6NDI6ImZzb2Nrb3BlblwoXCRtXFswXF0sXCRtXFsxMFxdLFwkXyxcJF9fLFwkbSI7aToyNTtzOjMzOiJlVmFMXChccyp0cmltXChccypiYVNlNjRfZGVDb0RlXCgiO2k6MjY7czo0NjoiZWNob1xzKm1kNVwoXCRfUE9TVFxbWyciXXswLDF9Y2hlY2tbJyJdezAsMX1cXSI7aToyNztzOjI1OiJpbWcgc3JjPVsnIl1vcGVyYTAwMFwucG5nIjtpOjI4O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6Mjk7czo0MDoic3Vic3RyX2NvdW50XChnZXRlbnZcKFxcWyciXUhUVFBfUkVGRVJFUiI7aTozMDtzOjMxOiJ3ZWJpXC5ydS93ZWJpX2ZpbGVzL3BocF9saWJtYWlsIjtpOjMxO3M6NjU6ImNocjI9XChcKGVuYzImMTVcKTw8NFwpXHxcKGVuYzM+PjJcKTtjaHIzPVwoXChlbmMzJjNcKTw8NlwpXHxlbmM0IjtpOjMyO3M6MTI6IlJFUkVGRVJfUFRUSCI7aTozMztzOjk6InRzb2hfcHR0aCI7aTozNDtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MzU7czo0NzoibW1jcnlwdFwoXCRkYXRhLCBcJGtleSwgXCRpdiwgXCRkZWNyeXB0ID0gRkFMU0UiO2k6MzY7czoxMzoiZm9wb1wuY29tXC5hciI7aTozNztzOjIwOiJzcHJhdm9jaG5pay1ub21lcm92LSI7aTozODtzOjE4OiJpY3EtZGx5YS10ZWxlZm9uYS0iO2k6Mzk7czoxNzoidGVsZWZvbm5heWEtYmF6YS0iO2k6NDA7czoyNjoic2xlc2hcK3NsZXNoXCtkb21lblwrcG9pbnQiO2k6NDE7czoyMjoic3JjPSJmaWxlc19zaXRlL2pzXC5qcyI7aTo0MjtzOjk1OiJcJHQ9XCRzO1xzKlwkb1xzKj1ccypbJyJdWyciXTtccypmb3JcKFwkaT0wO1wkaTxzdHJsZW5cKFwkdFwpO1wkaVwrXCtcKXtccypcJG9ccypcLj1ccypcJHR7XCRpfSI7aTo0MztzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo0NDtzOjUxOiJAKm1haWxcKFwkbW9zQ29uZmlnX21haWxmcm9tLCBcJG1vc0NvbmZpZ19saXZlX3NpdGUiO2k6NDU7czo2NjoiXCRbYS16QS1aMC05X10rPy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8vXCouezEsMTB9XCovIjtpOjQ2O3M6MTc6IkBcJF9QT1NUXFtcKGNoclwoIjtpOjQ3O3M6MzM6IjxcP3BocFxzK3JlbmFtZVwoWyciXXdzb1wucGhwWyciXSI7aTo0ODtzOjUyOiJcJHN0cj1bJyJdezAsMX08aDE+NDAzXHMrRm9yYmlkZGVuPC9oMT48IS0tXHMqdG9rZW46IjtpOjQ5O3M6NTA6ImNodW5rX3NwbGl0XChiYXNlNjRfZW5jb2RlXChmcmVhZFwoXCR7XCR7WyciXXswLDF9IjtpOjUwO3M6NjA6ImluaV9nZXRcKFsnIl17MCwxfWZpbHRlclwuZGVmYXVsdF9mbGFnc1snIl17MCwxfVwpXCl7Zm9yZWFjaCI7aTo1MTtzOjM4OiJmaWxlX2dldF9jb250ZW50c1wodHJpbVwoXCRmXFtcJF9HRVRcWyI7aTo1MjtzOjEzMzoibWFpbFwoXCRhcnJcW1snIl17MCwxfXRvWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfXN1YmpbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9bXNnWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfWhlYWRbJyJdezAsMX1cXVwpOyI7aTo1MztzOjU0OiJpZlwoaXNzZXRcKFwkX1BPU1RcW1snIl17MCwxfW1zZ3N1YmplY3RbJyJdezAsMX1cXVwpXCkiO2k6NTQ7czozNToiYmFzZTY0X2RlY29kZVwoXCRfUE9TVFxbWyciXXswLDF9Xy0iO2k6NTU7czo1MzoicmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25cKFxzKlsnIl17MCwxfXJlYWRfYW5zX2NvZGUiO2k6NTY7czo3NToiXCRwYXJhbVxzKj1ccypcJHBhcmFtXHMqeFxzKlwkblwuc3Vic3RyXHMqXChcJHBhcmFtXHMqLFxzKmxlbmd0aFwoXCRwYXJhbVwpIjtpOjU3O3M6MjQ6ImJhc2VbJyJdezAsMX1cLlwoMzJcKjJcKSI7aTo1ODtzOjY2OiJpZlwoQFwkdmFyc1woZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXHMqXD9ccypzdHJpcHNsYXNoZXNcKFwkdXJpXCkiO2k6NTk7czoyOToiXClcXTt9aWZcKGlzc2V0XChcJF9TRVJWRVJcW18iO2k6NjA7czo0MjoiaWZcKGVtcHR5XChcJF9DT09LSUVcW1snIl14WyciXVxdXClcKXtlY2hvIjtpOjYxO3M6NTI6ImlzX3dyaXRhYmxlXChcJGRpclwuWyciXXdwLWluY2x1ZGVzL3ZlcnNpb25cLnBocFsnIl0iO2k6NjI7czoyMToiQXBwbGVccytTcEFtXHMrUmVadWxUIjtpOjYzO3M6MTc6IiNccypzdGVhbHRoXHMqYm90IjtpOjY0O3M6MjI6IiNccypzZWN1cml0eXNwYWNlXC5jb20iO2k6NjU7czoyODoiVVJMPTxcP2VjaG9ccytcJGluZGV4O1xzK1w/PiI7aTo2NjtzOjk1OiI8c2NyaXB0XHMrdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccytzcmM9WyciXXswLDF9anF1ZXJ5LXVcLmpzWyciXXswLDF9Pjwvc2NyaXB0PiI7aTo2NztzOjU3OiJjcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFxzKlwkb3B0XFsxXF1ccypcLlxzKlwkb3B0XFs0XF0iO2k6Njg7czo1MDoiZmlsZV9wdXRfY29udGVudHNcKFNWQ19TRUxGXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6Njk7czo1MToiXCRhbGxlbWFpbHNccyo9XHMqQHNwbGl0XCgiXFxuIlxzKixccypcJGVtYWlsbGlzdFwpIjtpOjcwO3M6MTg6Ikpvb21sYV9icnV0ZV9Gb3JjZSI7aTo3MTtzOjM4OiJcJHN5c19wYXJhbXNccyo9XHMqQCpmaWxlX2dldF9jb250ZW50cyI7aTo3MjtzOjM1OiJmd3JpdGVccypcKFxzKlwkZmx3XHMqLFxzKlwkZmxccypcKSI7aTo3MztzOjg2OiJmaWxlX3B1dF9jb250ZW50c1xzKlwoWyciXXswLDF9MVwudHh0WyciXXswLDF9XHMqLFxzKnByaW50X3JccypcKFxzKlwkX1BPU1RccyosXHMqdHJ1ZSI7aTo3NDtzOjgwOiJcJGhlYWRlcnNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWhlYWRlcnNbJyJdezAsMX1cXSI7aTo3NTtzOjQ0OiJjcmVhdGVfZnVuY3Rpb25ccypcKFsnIl1bJyJdXHMqLFxzKnN0cl9yb3QxMyI7aTo3NjtzOjMzOiJkaWVccypcKFxzKlBIUF9PU1xzKlwuXHMqY2hyXHMqXCgiO2k6Nzc7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo3ODtzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aTo3OTtzOjQxOiJjb250ZW50PVsnIl17MCwxfTE7VVJMPWNnaS1iaW5cLmh0bWxcP2NtZCI7aTo4MDtzOjYzOiJcJHVybFsnIl17MCwxfVxzKlwuXHMqXCRzZXNzaW9uX2lkXHMqXC5ccypbJyJdezAsMX0vbG9naW5cLmh0bWwiO2k6ODE7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aTo4MjtzOjQyOiJmc29ja29wZW5ccypcKFxzKlwkQ29ubmVjdEFkZHJlc3NccyosXHMqMjUiO2k6ODM7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6ODQ7czo3NzoicHJlZ19tYXRjaFwoWyciXS9cKHlhbmRleFx8Z29vZ2xlXHxib3RcKS9pWyciXSxccypnZXRlbnZcKFsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6ODU7czo1MjoiXCRtYWlsZXJccyo9XHMqXCRfUE9TVFxbWyciXXswLDF9eF9tYWlsZXJbJyJdezAsMX1cXSI7aTo4NjtzOjU3OiJcJE9PTzBPME8wMD1fX0ZJTEVfXztccypcJE9PMDBPMDAwMFxzKj1ccyoweDFiNTQwO1xzKmV2YWwiO2k6ODc7czoxMjoiQnlccytXZWJSb29UIjtpOjg4O3M6ODA6ImhlYWRlclwoWyciXXswLDF9czpccypbJyJdezAsMX1ccypcLlxzKnBocF91bmFtZVxzKlwoXHMqWyciXXswLDF9blsnIl17MCwxfVxzKlwpIjtpOjg5O3M6NzM6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcW1snIl17MCwxfWVsaWZbJyJdezAsMX1cXVxbWyciXXswLDF9dG1wX25hbWUiO2k6OTA7czo2MjoiXCRnemlwXHMqPVxzKkAqZ3ppbmZsYXRlXHMqXChccypAKnN1YnN0clxzKlwoXHMqXCRnemVuY29kZV9hcmciO2k6OTE7czo4MzoiaWZccypcKFxzKm1haWxccypcKFxzKlwkbWFpbHNcW1wkaVxdXHMqLFxzKlwkdGVtYVxzKixccypiYXNlNjRfZW5jb2RlXHMqXChccypcJHRleHQiO2k6OTI7czo4NDoiZndyaXRlXHMqXChccypcJGZoXHMqLFxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjkzO3M6OTQ6ImVjaG9ccytmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqYmFzZTY0X3VybF9kZWNvZGVccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6OTQ7czo2MDoiaWZccypcKFxzKkAqbWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjk1O3M6OTk6ImNoclxzKlwoXHMqMTAxXHMqXClccypcLlxzKmNoclxzKlwoXHMqMTE4XHMqXClccypcLlxzKmNoclxzKlwoXHMqOTdccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMDhccypcKSI7aTo5NjtzOjE1MjoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXHMqXCkiO2k6OTc7czo3NToiXCRyZXN1bHRGVUxccyo9XHMqc3RyaXBjc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9cmVzdWx0RlVMWyciXXswLDF9IjtpOjk4O3M6MTU6Ii91c3Ivc2Jpbi9odHRwZCI7aTo5OTtzOjMyOiJQUklWTVNHXC5cKjpcLm93bmVyXFxzXCtcKFwuXCpcKSI7aToxMDA7czo4MzoicHJpbnRccytcJHNvY2tccytbJyJdezAsMX1OSUNLIFsnIl17MCwxfVxzK1wuXHMrXCRuaWNrXHMrXC5ccytbJyJdezAsMX1cXG5bJyJdezAsMX0iO2k6MTAxO3M6ODA6IlwkdXJsXHMqPVxzKlwkdXJsXHMqXC5ccypbJyJdezAsMX1cP1snIl17MCwxfVxzKlwuXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRxdWVyeVwpIjtpOjEwMjtzOjEyMzoicHJlZ19tYXRjaF9hbGxcKFsnIl17MCwxfS88YSBocmVmPSJcXC91cmxcXFw/cT1cKFwuXCtcP1wpXFsmXHwiXF1cKy9pc1snIl17MCwxfSwgXCRwYWdlXFtbJyJdezAsMX1leGVbJyJdezAsMX1cXSwgXCRsaW5rc1wpIjtpOjEwMztzOjEwMToiPHNjcmlwdFxzK2xhbmd1YWdlPVsnIl17MCwxfUphdmFTY3JpcHRbJyJdezAsMX0+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly8iO2k6MTA0O3M6Nzc6IlwkcFxzKj1ccypzdHJwb3NccypcKFxzKlwkdHhccyosXHMqWyciXXswLDF9eyNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjEwNTtzOjE1OiJcKG1zaWVcfG9wZXJhXCkiO2k6MTA2O3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6MTA3O3M6OTk6ImlmXHMqXChccyppc19kaXJccypcKFxzKlwkRnVsbFBhdGhccypcKVxzKlwpXHMqQWxsRGlyXHMqXChccypcJEZ1bGxQYXRoXHMqLFxzKlwkRmlsZXNccypcKTtccyp9XHMqfSI7aToxMDg7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjEwOTtzOjUzOiI8IS0tI2V4ZWNccytjbWQ9WyciXXswLDF9XCRIVFRQX0FDQ0VQVFsnIl17MCwxfVxzKi0tPiI7aToxMTA7czoyNjoiXFstXF1ccytDb25uZWN0aW9uXHMrZmFpbGQiO2k6MTExO3M6NjM6ImlmXCgvXF5cXDpcJG93bmVyIVwuXCpcXEBcLlwqUFJJVk1TR1wuXCo6XC5tc2dmbG9vZFwoXC5cKlwpL1wpeyI7aToxMTI7czozNDoicHJpbnRccypcJHNvY2sgIlBSSVZNU0cgIlwuXCRvd25lciI7aToxMTM7czo2NDoiXF09WyciXXswLDF9aXBbJyJdezAsMX1ccyo7XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJF9TRVJWRVJcWyI7aToxMTQ7czo1MToiXF1ccyp9XHMqPVxzKnRyaW1ccypcKFxzKmFycmF5X3BvcFxzKlwoXHMqXCR7XHMqXCR7IjtpOjExNTtzOjMwOiJwcmludFwoIiNccytpbmZvXHMrT0tcXG5cXG4iXCkiO2k6MTE2O3M6MTEyOiJcJHVzZXJfYWdlbnRccyo9XHMqcHJlZ19yZXBsYWNlXHMqXChccypbJyJdXHxVc2VyXFxcLkFnZW50XFw6XFtcXHMgXF1cP1x8aVsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCR1c2VyX2FnZW50IjtpOjExNztzOjcxOiJcJHBccyo9XHMqc3RycG9zXChcJHR4XHMqLFxzKlsnIl17MCwxfXsjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxMTg7czo5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChccypbJyJdXCRtWyciXVxzKixccypbJyJdaWZccypcKFxzKlwkbVxzKlxbXHMqMHgwMVxzKlxdXHMqPT1ccypbJyJdTFsnIl0iO2k6MTE5O3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjEyMDtzOjk6IklySXNUXC5JciI7aToxMjE7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMjI7czozMjoiXCRwb3N0XHMqPVxzKlsnIl1cXHg3N1xceDY3XFx4NjUiO2k6MTIzO3M6Mjc6ImVjaG9ccypbJyJdYW5zd2VyPWVycm9yWyciXSI7aToxMjQ7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMjU7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEyNjtzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMjc7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEyODtzOjUyOiJlY2hvWyciXXswLDF9PGNlbnRlcj48Yj5Eb25lXHMqPT0+XHMqXCR1c2VyZmlsZV9uYW1lIjtpOjEyOTtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTMwO3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTMxO3M6NTE6IlwpXHMqXC5ccypzdWJzdHJccypcKFxzKm1kNVxzKlwoXHMqc3RycmV2XHMqXChccypcJCI7aToxMzI7czo2NToiXCRmbFxzKj1ccyoiPG1ldGEgaHR0cC1lcXVpdj1cXCJSZWZyZXNoXFwiXHMrY29udGVudD1cXCIwO1xzKlVSTD0iO2k6MTMzO3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMzQ7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTM1O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjEzNjtzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTM3O3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjEzODtzOjY1OiJ1cmxlbmNvZGVcKHByaW50X3JcKGFycmF5XChcKSwxXClcKSw1LDFcKVwuY1wpLFwkY1wpO31ldmFsXChcJGRcKSI7aToxMzk7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTQwO3M6NDM6ImZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDQwMDBccystbHMiO2k6MTQxO3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjE0MjtzOjQxOiJmdW5jdGlvblxzK2luamVjdFwoXCRmaWxlLFxzKlwkaW5qZWN0aW9uPSI7aToxNDM7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTQ0O3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjE0NTtzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTQ2O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxNDc7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aToxNDg7czozOToiZXZhbFxzKlwoKlxzKnN0cnJldlxzKlwoKlxzKnN0cl9yZXBsYWNlIjtpOjE0OTtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjE1MDtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjE1MTtzOjIzMjoiaXNzZXRccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccyppc191cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqY29weVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXSI7aToxNTI7czo4NzoiaWZccypcKFxzKlwkaVxzKjxccypcKFxzKmNvdW50XHMqXChccypcJF9QT1NUXFtccypbJyJdezAsMX1xWyciXXswLDF9XHMqXF1ccypcKVxzKi1ccyoxIjtpOjE1MztzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjE1NDtzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTU1O3M6OTc6ImNvbnRlbnQ9WyciXXswLDF9bm8tY2FjaGVbJyJdezAsMX07XHMqXCRjb25maWdcW1snIl17MCwxfWRlc2NyaXB0aW9uWyciXXswLDF9XF1ccypcLj1ccypbJyJdezAsMX0iO2k6MTU2O3M6NzQ6ImNsZWFyc3RhdGNhY2hlXChccypcKTtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRmbGRccypcKVxzKlwpXHMqcmV0dXJuIjtpOjE1NztzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjE1ODtzOjk6IklyU2VjVGVhbSI7aToxNTk7czo3MzoiQGhlYWRlclwoWyciXUxvY2F0aW9uOlxzKlsnIl1cLlsnIl1oWyciXVwuWyciXXRbJyJdXC5bJyJddFsnIl1cLlsnIl1wWyciXSI7aToxNjA7czo2Nzoic2V0X3RpbWVfbGltaXRccypcKFxzKjBccypcKTtccyppZlxzKlwoIVNlY3JldFBhZ2VIYW5kbGVyOjpjaGVja0tleSI7aToxNjE7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTYyO3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxNjM7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6MTY0O3M6NDc6InN0cl9yb3QxM1xzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE2NTtzOjUwOiJnenVuY29tcHJlc3NccypcKFxzKnN0cl9yb3QxM1xzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToxNjY7czo1MDoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJfcm90MTMiO2k6MTY3O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzXHMqXChccypzdHJyZXYiO2k6MTY4O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2XHMqXChccypzdHJfcm90MTMiO2k6MTY5O3M6NDQ6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2IjtpOjE3MDtzOjY4OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzE7czo1NDoiYmFzZTY0X2RlY29kZVxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE3MjtzOjQ3OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzM7czo0NzoiZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTc0O3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjE3NTtzOjYwOiJcJHRsZFxzKj1ccyphcnJheVxzKlwoXHMqWyciXWNvbVsnIl0sWyciXW9yZ1snIl0sWyciXW5ldFsnIl0iO2k6MTc2O3M6NDU6ImRlZmluZVxzKlwoKlxzKlsnIl1TQkNJRF9SRVFVRVNUX0ZJTEVbJyJdXHMqLCI7aToxNzc7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aToxNzg7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6MTc5O3M6MzM6ImRlZmluZVxzKlwoXHMqWyciXURFRkNBTExCQUNLTUFJTCI7aToxODA7czo0NzoiZGVmYXVsdF9hY3Rpb25ccyo9XHMqWyciXXswLDF9RmlsZXNNYW5bJyJdezAsMX0iO2k6MTgxO3M6Mzg6ImVjaG9ccytAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkZ2V0IjtpOjE4MjtzOjE1NjoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyosXHMqWyciXXswLDF9QW5kcm9pZFsnIl17MCwxfVwpXHMqIT09ZmFsc2VccyomJlxzKiFcJF9DT09LSUVcW1snIl17MCwxfWRsZV91c2VyX2lkIjtpOjE4MztzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6MTg0O3M6MTA6IkRjMFJIYVsnIl0iO2k6MTg1O3M6MzY6IiF0b3VjaFwoWyciXXswLDF9XC5cLi9cLlwuL2xhbmd1YWdlLyI7aToxODY7czozODoiZXZhbFwoXHMqc3RyaXBzbGFzaGVzXChccypcXFwkX1JFUVVFU1QiO2k6MTg3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aToxODg7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aToxODk7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aToxOTA7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6MTkxO3M6ODc6IiYmXHMqZnVuY3Rpb25fZXhpc3RzXHMqXCgqXHMqWyciXXswLDF9Z2V0bXhyclsnIl17MCwxfVwpXHMqXClccyp7XHMqQGdldG14cnJccypcKCpccypcJCI7aToxOTI7czo1NzoiaXNfX3dyaXRhYmxlXHMqXCgqXHMqXCRwYXRoXHMqXC5ccyp1bmlxaWRccypcKCpccyptdF9yYW5kIjtpOjE5MztzOjI4OiJmaWxlX3B1dF9jb250ZW50elxzKlwoKlxzKlwkIjtpOjE5NDtzOjU1OiJAKmd6aW5mbGF0ZVxzKlwoXHMqQCpiYXNlNjRfZGVjb2RlXHMqXChccypAKnN0cl9yZXBsYWNlIjtpOjE5NTtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjE5NjtzOjQzOiJAXCRfQ09PS0lFXFtbJyJdezAsMX1zdGF0Q291bnRlclsnIl17MCwxfVxdIjtpOjE5NztzOjM1OiJpZlxzKlwoKlxzKkAqcHJlZ19tYXRjaFxzKlwoKlxzKnN0ciI7aToxOTg7czo5NDoiYXJyYXlfcG9wXHMqXCgqXHMqXCR3b3JrUmVwbGFjZVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKixccypcJGNvdW50S2V5c05ldyI7aToxOTk7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjIwMDtzOjIzOiJcKFxzKlsnIl1JTlNIRUxMWyciXVxzKiI7aToyMDE7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6MjAyO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6MjAzO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aToyMDQ7czoxMjM6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cXlwod3d3XHxmdHBcKVxcXC4vaVsnIl1ccyosXHMqWyciXVsnIl0sXHMqQFwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XHMqXF1ccypcKSI7aToyMDU7czoyNjE6ImlmXHMqXCgqXHMqaXNzZXRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9W2EtekEtWl8wLTldK1snIl17MCwxfVxzKlxdXHMqXCkqXHMqXClccyp7XHMqXCRbYS16QS1aXzAtOV0rXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF07XHMqZXZhbFxzKlwoKlxzKlwkW2EtekEtWl8wLTldK1xzKlwpKiI7aToyMDY7czo4MToiZXZhbFxzKlwoKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFwoKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjIwNztzOjEzOToiaWZccytcKFxzKnN0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL21vb3Rvb2xzXC5qc1snIl1ccypcKVxzKj09PVxzKmZhbHNlXHMrJiZccytzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9jYXB0aW9uXC5qc1snIl17MCwxfSI7aToyMDg7czo2ODoiaWZccytcKCpccyptYWlsXHMqXChccypcJHJlY3BccyosXHMqXCRzdWJqXHMqLFxzKlwkc3R1bnRccyosXHMqXCRmcm0iO2k6MjA5O3M6NDM6IjxcP3BocFxzK1wkX0Zccyo9XHMqX19GSUxFX19ccyo7XHMqXCRfWFxzKj0iO2k6MjEwO3M6Nzk6IlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0iO2k6MjExO3M6MTE1OiJcJGJlZWNvZGVccyo9QCpmaWxlX2dldF9jb250ZW50c1xzKlwoKlsnIl17MCwxfVxzKlwkdXJscHVyc1xzKlsnIl17MCwxfVwpKlxzKjtccyplY2hvXHMrWyciXXswLDF9XCRiZWVjb2RlWyciXXswLDF9IjtpOjIxMjtzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6MjEzO3M6NzM6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqXFsuKz9cXVw/L2VbJyJdezAsMX1ccyosXHMqc3RyX3JlcGxhY2UiO2k6MjE0O3M6MTQ5OiJcJEdMT0JBTFNcW1snIl17MCwxfS4rP1snIl17MCwxfVxdPUFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKSI7aToyMTU7czoyMDA6IlVOSU9OXHMrU0VMRUNUXHMrWyciXXswLDF9MFsnIl17MCwxfVxzKixccypbJyJdezAsMX08XD8gc3lzdGVtXChcXFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtjcGNcXVwpO2V4aXQ7XHMqXD8+WyciXXswLDF9XHMqLFxzKjBccyosMFxzKixccyowXHMqLFxzKjBccytJTlRPXHMrT1VURklMRVxzK1snIl17MCwxfVwkWyciXXswLDF9IjtpOjIxNjtzOjY2OiJpc3NldFxzKlwoKlxzKlwkX1BPU1RccypcW1xzKlsnIl17MCwxfWV4ZWNnYXRlWyciXXswLDF9XHMqXF1ccypcKSoiO2k6MjE3O3M6NzE6ImZ3cml0ZVxzKlwoKlxzKlwkZnBzZXR2XHMqLFxzKmdldGVudlxzKlwoXHMqWyciXUhUVFBfQ09PS0lFWyciXVxzKlwpXHMqIjtpOjIxODtzOjI2OiJzeW1saW5rXHMqXCgqXHMqWyciXS9ob21lLyI7aToyMTk7czo3MDoiZnVuY3Rpb25ccyt1cmxHZXRDb250ZW50c1xzKlwoKlxzKlwkdXJsXHMqLFxzKlwkdGltZW91dFxzKj1ccypcZCtccypcKSI7aToyMjA7czo0OToic3RycmV2XCgqXHMqWyciXXswLDF9ZWRvY2VkXzQ2ZXNhYlsnIl17MCwxfVxzKlwpKiI7aToyMjE7czo0Mjoic3RycmV2XCgqXHMqWyciXXswLDF9dHJlc3NhWyciXXswLDF9XHMqXCkqIjtpOjIyMjtzOjIwOiJleGVjXHMqXChccypbJyJdaXBmdyI7aToyMjM7czoxMzY6IndwX3Bvc3RzXHMrV0hFUkVccytwb3N0X3R5cGVccyo9XHMqWyciXXswLDF9cG9zdFsnIl17MCwxfVxzK0FORFxzK3Bvc3Rfc3RhdHVzXHMqPVxzKlsnIl17MCwxfXB1Ymxpc2hbJyJdezAsMX1ccytPUkRFUlxzK0JZXHMrYElEYFxzK0RFU0MiO2k6MjI0O3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjIyNTtzOjIxMzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjIyNjtzOjI0OiJcJEdMT0JBTFNcW1snIl17MCwxfV9fX18iO2k6MjI3O3M6NDM6ImZvcGVuXHMqXCgqXHMqWyciXXswLDF9L2V0Yy9wYXNzd2RbJyJdezAsMX0iO2k6MjI4O3M6NTk6ImV2YWxccypcKCpAKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFxzKlwoKlxzKkAqXCRfIjtpOjIyOTtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aToyMzA7czo3NDoiQCpzZXRjb29raWVccypcKCpccypbJyJdezAsMX1oaXRbJyJdezAsMX0sXHMqMVxzKixccyp0aW1lXHMqXCgqXHMqXCkqXHMqXCsiO2k6MjMxO3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aToyMzI7czo0NjoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCovZVsnIl17MCwxfSI7aToyMzM7czo4MToiXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqXF1ccyp9IjtpOjIzNDtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjIzNTtzOjMzOiJwcm9jX29wZW5ccypcKFxzKlsnIl17MCwxfUlIU3RlYW0iO2k6MjM2O3M6ODg6IlwkaW5pXHMqXFtccypbJyJdezAsMX11c2Vyc1snIl17MCwxfVxzKlxdXHMqPVxzKmFycmF5XHMqXChccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqPT4iO2k6MjM3O3M6ODg6ImN1cmxfc2V0b3B0XHMqXChccypcJGNoXHMqLFxzKkNVUkxPUFRfVVJMXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly9cJGhvc3Q6XGQrWyciXXswLDF9XHMqXCkiO2k6MjM4O3M6NDU6InN5c3RlbVxzKlwoKlxzKlsnIl17MCwxfXdob2FtaVsnIl17MCwxfVxzKlwpKiI7aToyMzk7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyNDA7czo1MjoiYXNzZXJ0XHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNDE7czo1MDoiZXZhbFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjQyO3M6MjU6InBocFxzKyJccypcLlxzKlwkd3NvX3BhdGgiO2k6MjQzO3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjI0NDtzOjIxOiJldmExW2EtekEtWjAtOV9dKz9TaXIiO2k6MjQ1O3M6OTM6IlwkY21kXHMqPVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccypcKSI7aToyNDY7czo5NjoiXCRmdW5jdGlvblxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfWNtZFsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjI0NztzOjIzOiJcJGZlXCgiXCRjbWRccysyPiYxIlwpOyI7aToyNDg7czoxNDE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyNDk7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6MjUwO3M6ODY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXVuYW1lXHMrLWFbJyJdXHMqXCkqIjtpOjI1MTtzOjEyNDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkX1BPU1RccypcW1xzKlsnIl0uKz9bJyJdXHMqXF1ccypcLlxzKiJccyoyXHMqPlxzKiYxXHMqWyciXSI7aToyNTI7czo0OToiIUAqXCRfUkVRVUVTVFxzKlxbXHMqWyciXWM5OXNoX3N1cmxbJyJdXHMqXF1ccypcKSI7aToyNTM7czozNzoiXCRsb2dpblxzKj1ccypAKnBvc2l4X2dldHVpZFwoKlxzKlwpKiI7aToyNTQ7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyNTU7czo4MjoicnVuY29tbWFuZFxzKlwoXHMqWyciXXNoZWxsaGVscFsnIl1ccyosXHMqWyciXShHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXSI7aToyNTY7czo1NToie1xzKlwkXHMqe1xzKnBhc3N0aHJ1XHMqXCgqXHMqXCRjbWRccypcKVxzKn1ccyp9XHMqPGJyPiI7aToyNTc7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyNTg7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MjU5O3M6ODc6IlNFTEVDVFxzKzFccytGUk9NXHMrbXlzcWxcLnVzZXJccytXSEVSRVxzK2NvbmNhdFwoXHMqYHVzZXJgXHMqLFxzKidAJ1xzKixccypgaG9zdGBccypcKSI7aToyNjA7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToyNjE7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MjYyO3M6NzQ6ImZpbGVwYXRoXHMqPVxzKkAqcmVhbHBhdGhccypcKFxzKlwkX1BPU1RccypcW1xzKlsnIl1maWxlcGF0aFsnIl1ccypcXVxzKlwpIjtpOjI2MztzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MjY0O3M6NDA6ImV2YWxccypcKCpccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8iO2k6MjY1O3M6MTA3OiJ3c29FeFxzKlwoXHMqXFxbJyJdXHMqdGFyXHMqY2Z6dlxzKlxcWyciXVxzKlwuXHMqZXNjYXBlc2hlbGxhcmdccypcKFxzKlwkX1BPU1RcW1xzKlxcWyciXXAyXFxbJyJdXHMqXF1ccypcKSI7aToyNjY7czo3NDoiV1NPc2V0Y29va2llXHMqXChccyptZDVccypcKFxzKkAqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9IT1NUWyciXVxzKlxdXHMqXCkiO2k6MjY3O3M6Nzg6IldTT3NldGNvb2tpZVxzKlwoXHMqbWQ1XHMqXChccypAKlwkX1NFUlZFUlxbXHMqXFxbJyJdSFRUUF9IT1NUXFxbJyJdXHMqXF1ccypcKSI7aToyNjg7czoxNzA6IlwkaW5mbyBcLj0gXChcKFwkcGVybXNccyomXHMqMHgwMDQwXClccypcP1woXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccypcXFsnIl1zXFxbJyJdXHMqOlxzKlxcWyciXXhcXFsnIl1ccypcKVxzKjpcKFwoXCRwZXJtc1xzKiZccyoweDA4MDBcKVxzKlw/XHMqJ1MnXHMqOlxzKictJ1xzKlwpIjtpOjI2OTtzOjM1OiJkZWZhdWx0X2FjdGlvblxzKj1ccypcXFsnIl1GaWxlc01hbiI7aToyNzA7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjI3MTtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjI3MjtzOjExOiJieVxzK0dyaW5heSI7aToyNzM7czoyMzoiQ2FwdGFpblxzK0NydW5jaFxzK1RlYW0iO2k6Mjc0O3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyNzU7czoxMDA6IklPOjpTb2NrZXQ6OklORVQtPm5ld1woUHJvdG9ccyo9PlxzKiJ0Y3AiXHMqLFxzKkxvY2FsUG9ydFxzKj0+XHMqMzYwMDBccyosXHMqTGlzdGVuXHMqPT5ccypTT01BWENPTk4iO30="));
$gX_FlexDBShe = unserialize(base64_decode("YToyODY6e2k6MDtzOjEwODoiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJGpxXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjE7czo5OiJhcnRpY2tsZUAiO2k6MjtzOjM5OiJbJyJdd3AtWyciXVxzKlwuXHMqZ2VuZXJhdGVSYW5kb21TdHJpbmciO2k6MztzOjQwOiJoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vXCRwcFwub3JnIjtpOjQ7czo4OiJGaWxlc01hbiI7aTo1O3M6OTk6IkBcJF9DT09LSUVcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVwoXHMqQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXHMqXClccypcKSI7aTo2O3M6NDA6IlwkY3VyX2NhdF9pZFxzKj1ccypcKFxzKmlzc2V0XChccypcJF9HRVQiO2k6NztzOjM0OiJFZGl0SHRhY2Nlc3NcKFxzKlsnIl1SZXdyaXRlRW5naW5lIjtpOjg7czoxMToiXCRwYXRoVG9Eb3IiO2k6OTtzOjIyOiJmdW5jdGlvblxzK21haWxlcl9zcGFtIjtpOjEwO3M6Mzg6ImVjaG9ccytzaG93X3F1ZXJ5X2Zvcm1cKFxzKlwkc3Fsc3RyaW5nIjtpOjExO3M6NDM6Ilwkc3RhdHVzX2NyZWF0ZV9nbG9iX2ZpbGVccyo9XHMqY3JlYXRlX2ZpbGUiO2k6MTI7czo0MzoiZnVuY3Rpb25ccytmaW5kSGVhZGVyTGluZVxzKlwoXHMqXCR0ZW1wbGF0ZSI7aToxMztzOjYwOiJhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdezAsMX1tZXNbJyJdXF0iO2k6MTQ7czoyNjoiZmlsZXNpemVcKFxzKlwkcHV0X2tfZmFpbHUiO2k6MTU7czo1OToiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGlyXHMqXC5ccypcJGZpbGVccypcLlxzKlsnIl0vaW5kZXgiO2k6MTY7czo0MzoiaWZccypcKFxzKkBmaWxldHlwZVwoXCRsZWFkb25ccypcLlxzKlwkZmlsZSI7aToxNztzOjM3OiJldmFsXChccypcJHtccypcJFthLXpBLVowLTlfXSs/XHMqfVxbIjtpOjE4O3M6Mjg6InRvdWNoXChccypcJHRoaXMtPmNvbmYtPnJvb3QiO2k6MTk7czo1NjoicHJlZ19tYXRjaFwoXHMqWyciXXswLDF9fkxvY2F0aW9uOlwoXC5cKlw/XClcKFw/Olxcblx8XCQiO2k6MjA7czo0OToiZmx1c2hfZW5kX2ZpbGVcKFxzKlwkZmlsZW5hbWVccyosXHMqXCRmaWxlY29udGVudCI7aToyMTtzOjMzOiJpZlwoXHMqc3RyaXBvc1woXHMqWyciXVwqXCpcKlwkdWEiO2k6MjI7czo2NjoiXCR0YWJsZVxbXCRzdHJpbmdcW1wkaVxdXF1ccypcKlxzKnBvd1woNjRccyosXHMqMlwpXHMqXCtccypcJHRhYmxlIjtpOjIzO3M6NDg6ImdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXW1lcyI7aToyNDtzOjQ4OiJcJFBPU1RfU1RSXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgicGhwOi8vaW5wdXQiO2k6MjU7czozMzoiXCRzdGF0dXNfbG9jX3NoXHMqPVxzKmZpbGVfZXhpc3RzIjtpOjI2O3M6OTk6IlwkaW5kZXhccyo9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl08XD9waHBccypvYl9lbmRfZmx1c2hcKFwpO1xzKlw/PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRpbmRleCI7aToyNztzOjEwNzoiaXNzZXRcKFxzKlwkX1NFUlZFUlxbXHMqX1xkK1woXHMqXGQrXHMqXClccypcXVxzKlwpXHMqXD9ccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxkK1wpXHMqXF1ccyo6XHMqX1xkK1woXGQrXCkiO2k6Mjg7czozODoiPT1ccyowXClccyp7XHMqZWNob1xzKlBIUF9PU1xzKlwuXHMqXCQiO2k6Mjk7czo0OToiaWZcKFxzKnRydWVccyomXHMqQHByZWdfbWF0Y2hcKFxzKnN0cnRyXChccypbJyJdLyI7aTozMDtzOjg0OiJpZlwoXHMqIWVtcHR5XChccypcJF9QT1NUXFtccypbJyJdezAsMX10cDJbJyJdezAsMX1ccypcXVwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MzE7czo0NzoiZ3p1bmNvbXByZXNzXChccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXWh0dHAiO2k6MzI7czoxOTg6IlxiKHBlcmNvY2V0fGFkZGVyYWxsfHZpYWdyYXxjaWFsaXN8bGV2aXRyYXxrYXVmZW58YW1iaWVufGJsdWVccytwaWxsfGNvY2FpbmV8bWFyaWp1YW5hfGxpcGl0b3J8cGhlbnRlcm1pbnxwcm9bc3pdYWN8c2FuZHlhdWVyfHRyYW1hZG9sfHRyb3loYW1ieXVsdHJhbXx1bmljYXVjYXx2YWxpdW18dmljb2Rpbnx4YW5heHx5cHhhaWVvKVxzK29ubGluZSI7aTozMztzOjIyOiJkaXNhYmxlX2Z1bmN0aW9ucz1OT05FIjtpOjM0O3M6MjE6IiZfU0VTU0lPTlxbcGF5bG9hZFxdPSI7aTozNTtzOjI2OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXSs/YCI7aTozNjtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjM3O3M6Njk6InRvdWNoXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aTozODtzOjgxOiJmaWxlX2dldF9jb250ZW50c1woXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6Mzk7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6NDA7czo3MToidHJpbVwoXHMqXCRoZWFkZXJzXHMqXClccypcKVxzKmFzXHMqXCRoZWFkZXJccypcKVxzKmhlYWRlclwoXHMqXCRoZWFkZXIiO2k6NDE7czoxNjoiQ29kZWRccytieVxzK0VYRSI7aTo0MjtzOjEyOiJCeVxzK1dlYlJvb1QiO2k6NDM7czoyMDoiaGVhZGVyXHMqXChccypfXGQrXCgiO2k6NDQ7czo0MToiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6NDU7czoyOToiZG9fd29ya1woXHMqXCRpbmRleF9maWxlXHMqXCkiO2k6NDY7czo4MzoiXCRpZFxzKlwuXHMqWyciXVw/ZD1bJyJdXHMqXC5ccypiYXNlNjRfZW5jb2RlXChccypcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6NDc7czoyNToibmV3XHMrY29uZWN0QmFzZVwoWyciXWFIUiI7aTo0ODtzOjkwOiJmaWxlX2dldF9jb250ZW50c1woUk9PVF9ESVJcLlsnIl0vdGVtcGxhdGVzL1snIl1cLlwkY29uZmlnXFtbJyJdc2tpblsnIl1cXVwuWyciXS9tYWluXC50cGwiO2k6NDk7czo1OToiJTwhLS1cXHNcKlwkbWFya2VyXFxzXCotLT5cLlwrXD88IS0tXFxzXCovXCRtYXJrZXJcXHNcKi0tPiUiO2k6NTA7czoyNDoiZnVuY3Rpb25ccytnZXRmaXJzdHNodGFnIjtpOjUxO3M6MTg6InJlc3VsdHNpZ25fd2FybmluZyI7aTo1MjtzOjI5OiJmaWxlX2V4aXN0c1woXHMqXCRGaWxlQmF6YVRYVCI7aTo1MztzOjE5OiI9PVxzKlsnIl1jc2hlbGxbJyJdIjtpOjU0O3M6NjE6IlwkX1NFUlZFUlxbWyciXXswLDF9UkVNT1RFX0FERFJbJyJdezAsMX1cXTtpZlwoXChwcmVnX21hdGNoXCgiO2k6NTU7czo2NzoiXCRmaWxlX2Zvcl90b3VjaFxzKj1ccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXSI7aTo1NjtzOjIzOiJcJGluZGV4X3BhdGhccyosXHMqMDQwNCI7aTo1NztzOjMwOiJyZWFkX2ZpbGVfbmV3XzJcKFwkcmVzdWx0X3BhdGgiO2k6NTg7czozODoiY2hyXChccypoZXhkZWNcKFxzKnN1YnN0clwoXHMqXCRtYWtldXAiO2k6NTk7czoyNzoiXGQrJkBwcmVnX21hdGNoXChccypzdHJ0clwoIjtpOjYwO3M6NzU6InZhbHVlPVsnIl08XD9ccysoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXSI7aTo2MTtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6NjI7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjYzO3M6NDE6ImdfZGVsZXRlX29uX2V4aXRccyo9XHMqbmV3XHMrRGVsZXRlT25FeGl0IjtpOjY0O3M6NTI6ImlmXChwcmVnX21hdGNoXChbJyJdI3dvcmRwcmVzc19sb2dnZWRfaW5cfGFkbWluXHxwd2QiO2k6NjU7czo1MDoiWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl0iO2k6NjY7czoyODoiXCk7ZnVuY3Rpb25ccytzdHJpbmdfY3B0XChcJCI7aTo2NztzOjI4OiJcJHNldGNvb2tcKTtzZXRjb29raWVcKFwkc2V0IjtpOjY4O3M6MzU6Ijxsb2M+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmw7IjtpOjY5O3M6NDA6IlwkYmFubmVkSVBccyo9XHMqYXJyYXlcKFxzKlsnIl1cXjY2XC4xMDIiO2k6NzA7czo2MjoiXCRyZXN1bHQ9c21hcnRDb3B5XChccypcJHNvdXJjZVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGZpbGUiO2k6NzE7czozODoiXCRmaWxsID0gXCRfQ09PS0lFXFtcXFsnIl1maWxsXFxbJyJdXF0iO2k6NzI7czo4MzoiaWZcKFsnIl1zdWJzdHJfY291bnRcKFsnIl1cJF9TRVJWRVJcW1snIl1SRVFVRVNUX1VSSVsnIl1cXVxzKixccypbJyJdcXVlcnlcLnBocFsnIl0iO2k6NzM7czo4NToiaWZcKFxzKlwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIT1ccypbJyJdWyciXVxzKlwpXHMqXCRpZD1cJF9HRVRcW1xzKlsnIl1pZFsnIl1ccypcXSI7aTo3NDtzOjIyOiI8YVxzK2hyZWY9WyciXW9zaGlia2EtIjtpOjc1O3M6NzY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdY2RccysvdG1wO3dnZXQiO2k6NzY7czo1NToiZ2V0cHJvdG9ieW5hbWVcKFxzKlsnIl10Y3BbJyJdXHMqXClccytcfFx8XHMrZGllXHMrc2hpdCI7aTo3NztzOjQ3OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aTo3ODtzOjY2OiIsXHMqWyciXS9pbmRleFxcXC5cKHBocFx8aHRtbFwpL2lbJyJdXHMqLFxzKlJlY3Vyc2l2ZVJlZ2V4SXRlcmF0b3IiO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjIwOiJ0SEFOS3Nccyt0T1xzK1Nub3BweSI7aTo4MTtzOjIwOiJNYXNyMVxzK0N5YjNyXHMrVGU0bSI7aTo4MjtzOjE4OiJVczNccytZMHVyXHMrYnI0MW4iO2k6ODM7czoyMDoiTWFzcmlccytDeWJlclxzK1RlYW0iO2k6ODQ7czo0OToiZndyaXRlXChcJGZwXHMqLFxzKnN0cnJldlwoXHMqXCRjb250ZXh0XHMqXClccypcKSI7aTo4NTtzOjk6Ii9wbXQvcmF2LyI7aTo4NjtzOjM0OiJmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS92YXIvdG1wIjtpOjg3O3M6MjM6IlwkaW5fUGVybXNccysmXHMrMHg0MDAwIjtpOjg4O3M6NDM6ImZvcGVuXChccypcJHJvb3RfZGlyXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6ODk7czo2MjoiaW50MzJcKFwoXChcJHpccyo+PlxzKjVccyomXHMqMHgwN2ZmZmZmZlwpXHMqXF5ccypcJHlccyo8PFxzKjIiO2k6OTA7czozNToiPGd1aWQ+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmwiO2k6OTE7czoxOToiLWtseWNoLWstaWdyZVwuaHRtbCI7aTo5MjtzOjY2OiI8ZGl2XHMraWQ9WyciXWxpbmsxWyciXT48YnV0dG9uIG9uY2xpY2s9WyciXXByb2Nlc3NUaW1lclwoXCk7WyciXT4iO2k6OTM7czoxMToic2NvcGJpblsnIl0iO2k6OTQ7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6OTU7czo0NzoidGFyXHMrLWN6ZlxzKyJccypcLlxzKlwkRk9STXt0YXJ9XHMqXC5ccyoiXC50YXIiO2k6OTY7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6OTc7czo2MzoiXCRDVlYyQ1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXUNWVjJDIjtpOjk4O3M6NzU6ImZ3cml0ZVwoXHMqXCRmXHMqLFxzKmdldF9kb3dubG9hZFwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo5OTtzOjMzOiJcW1xdXHMqPVxzKlsnIl1SZXdyaXRlRW5naW5lXHMrb24iO2k6MTAwO3M6OTg6InN1YnN0clwoXHMqXCRzdHJpbmcyXHMqLFxzKnN0cmxlblwoXHMqXCRzdHJpbmcyXHMqXClccyotXHMqOVxzKixccyo5XClccyo9PVxzKlsnIl17MCwxfVxbbCxyPTMwMlxdIjtpOjEwMTtzOjEzOiI9YnlccytEUkFHT049IjtpOjEwMjtzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjEwMztzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjEwNDtzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjEwNTtzOjc4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXWFjdGlvblsnIl1ccypcLlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTA2O3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjEwNztzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTA4O3M6NTI6InRvdWNoXChccypbJyJdezAsMX1cJGJhc2VwYXRoL2NvbXBvbmVudHMvY29tX2NvbnRlbnQiO2k6MTA5O3M6NDY6Ij1cJGZpbGVcKEAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTEwO3M6NzI6InNlbmRfc210cFwoXHMqXCRlbWFpbFxbWyciXXswLDF9YWRyWyciXXswLDF9XF1ccyosXHMqXCRzdWJqXHMqLFxzKlwkdGV4dCI7aToxMTE7czozNDoiX19MSU5LX188YVxzK2hyZWY9WyciXXswLDF9aHR0cDovLyI7aToxMTI7czo0NDoic2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTEzO3M6Nzg6IiFmaWxlX3B1dF9jb250ZW50c1woXHMqXCRkYm5hbWVccyosXHMqXCR0aGlzLT5nZXRJbWFnZUVuY29kZWRUZXh0XChccypcJGRibmFtZSI7aToxMTQ7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxMTU7czo2MDoibWFpbFwoXHMqXCRNYWlsVG9ccyosXHMqXCRNZXNzYWdlU3ViamVjdFxzKixccypcJE1lc3NhZ2VCb2R5IjtpOjExNjtzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTE3O3M6NzA6Im1haWxcKFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF0iO2k6MTE4O3M6MjM6ImlzX3dyaXRhYmxlPWlzX3dyaXRhYmxlIjtpOjExOTtzOjIzOiJleHBsb2l0LWRiXC5jb20vc2VhcmNoLyI7aToxMjA7czoxNDoiRGF2aWRccypCbGFpbmUiO2k6MTIxO3M6MzM6ImNyb250YWJccystbFx8Z3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMjI7czo4MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl17MCwxfWF0XHMrbm93XHMrLWYiO2k6MTIzO3M6NjM6IiMhL2Jpbi9zaG5jZFxzK1snIl17MCwxfVsnIl17MCwxfVwuXCRTQ1BcLlsnIl17MCwxfVsnIl17MCwxfW5pZiI7aToxMjQ7czo0NDoiZmlsZV9wdXRfY29udGVudHNcKFsnIl17MCwxfVwuL2xpYndvcmtlclwuc28iO2k6MTI1O3M6MzY6IlwkdXNlcl9hZ2VudF90b19maWx0ZXJccyo9XHMqYXJyYXlcKCI7aToxMjY7czoyMDoiZm9wZW5cKFxzKlsnIl0vaG9tZS8iO2k6MTI3O3M6MjA6Im1rZGlyXChccypbJyJdL2hvbWUvIjtpOjEyODtzOjM5OiIjVXNlWyciXXswLDF9XHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTI5O3M6Mjk6ImVyZWdpXChccypzcWxfcmVnY2FzZVwoXHMqXCRfIjtpOjEzMDtzOjcxOiJcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkK1xzKlxdXChcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkKyI7aToxMzE7czozNjoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCQ8YW1jIjtpOjEzMjtzOjMzOiJAXCRmdW5jXChcJGNmaWxlLCBcJGNkaXJcLlwkY25hbWUiO2k6MTMzO3M6NjI6InVuYW1lXF1bJyJdezAsMX1ccypcLlxzKnBocF91bmFtZVwoXClccypcLlxzKlsnIl17MCwxfVxbL3VuYW1lIjtpOjEzNDtzOjU0OiJcJEdMT0JBTFNcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFxzKk5VTEwiO2k6MTM1O3M6MjM6Il9fdXJsX2dldF9jb250ZW50c1woXCRsIjtpOjEzNjtzOjI2OiJcJGRvcl9jb250ZW50PXByZWdfcmVwbGFjZSI7aToxMzc7czo3MzoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1sc1xzKy92YXIvbWFpbCI7aToxMzg7czozMDoiaGVhZGVyXChbJyJdezAsMX1yOlxzKm5vXHMrY29tIjtpOjEzOTtzOjQ4OiJwcmVnX21hdGNoX2FsbFwoXHMqWyciXVx8XChcLlwqXCk8XFwhLS0ganMtdG9vbHMiO2k6MTQwO3M6NDk6IkAqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkdGhpcy0+ZmlsZVxzKixccypzdHJyZXYiO2k6MTQxO3M6NDE6Ii9wbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwIjtpOjE0MjtzOjkxOiJtYWlsXChccypzdHJpcHNsYXNoZXNcKFwkdG9cKVxzKixccypzdHJpcHNsYXNoZXNcKFwkc3ViamVjdFwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRtZXNzYWdlIjtpOjE0MztzOjg1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9dXJbJyJdezAsMX1cXVwpXClccypcJG1vZGVccypcfD1ccyowNDAwIjtpOjE0NDtzOjgyOiJlcmVnX3JlcGxhY2VcKFsnIl17MCwxfSU1QyUyMlsnIl17MCwxfVxzKixccypbJyJdezAsMX0lMjJbJyJdezAsMX1ccyosXHMqXCRtZXNzYWdlIjtpOjE0NTtzOjg4OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRuYW1lXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE0NjtzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6MTQ3O3M6ODk6Ilwkc2FwZV9vcHRpb25cW1xzKlsnIl17MCwxfWZldGNoX3JlbW90ZV90eXBlWyciXXswLDF9XHMqXF1ccyo9XHMqWyciXXswLDF9c29ja2V0WyciXXswLDF9IjtpOjE0ODtzOjEwNToiXCRwYXRoXHMqPVxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdXHMqXC5ccypbJyJdezAsMX0vaW1hZ2VzL3N0b3JpZXMvWyciXXswLDF9IjtpOjE0OTtzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1MDtzOjIwOiJldmFsXHMqXChccypUUExfRklMRSI7aToxNTE7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6MTUyO3M6NDg6IlxzKlsnIl17MCwxfXNsdXJwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfW1zbmJvdCI7aToxNTM7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjE1NDtzOjExOiJDb3VwZGVncmFjZSI7aToxNTU7czoxMjoiU3VsdGFuSGFpa2FsIjtpOjE1NjtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6MTU3O3M6Mjc6Imh0dHBzOi8vYXBwbGVpZFwuYXBwbGVcLmNvbSI7aToxNTg7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aToxNTk7czozNDoiY3JjMzJcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfWNtZCI7aToxNjA7czoxOToiZ3JlcFxzKy12XHMrY3JvbnRhYiI7aToxNjE7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aToxNjI7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6MTYzO3M6MzI6ImV2YWxcKFsnIl1cPz5bJyJdXC5iYXNlNjRfZGVjb2RlIjtpOjE2NDtzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTY1O3M6MTI6Im1pbHcwcm1cLmNvbSI7aToxNjY7czo0NToiXCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE2NztzOjM2OiJyZXR1cm5ccytiYXNlNjRfZGVjb2RlXChcJGFcW1wkaVxdXCkiO2k6MTY4O3M6ODoiSGFyY2hhTGkiO2k6MTY5O3M6NjA6InBsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAlM0ElMkYlMkZ3d3dcLmdvb2dsZSI7aToxNzA7czozNjoiY3JlYXRlX2Z1bmN0aW9uXChzdWJzdHJcKDIsMVwpLFwkc1wpIjtpOjE3MTtzOjgxOiJ0eXBlb2ZccypcKGRsZV9hZG1pblwpXHMqPT1ccypbJyJdezAsMX11bmRlZmluZWRbJyJdezAsMX1ccypcfFx8XHMqZGxlX2FkbWluXHMqPT0iO2k6MTcyO3M6MzI6IlxbXCRvXF1cKTtcJG9cK1wrXCl7aWZcKFwkbzwxNlwpIjtpOjE3MztzOjMyOiJcJFNcW1wkaVwrXCtcXVwoXCRTXFtcJGlcK1wrXF1cKCI7aToxNzQ7czozNzoic2V0Y29va2llXChccypcJHpcWzBcXVxzKixccypcJHpcWzFcXSI7aToxNzU7czo4NjoiL2luZGV4XC5waHBcP29wdGlvbj1jb21famNlJnRhc2s9cGx1Z2luJnBsdWdpbj1pbWdtYW5hZ2VyJmZpbGU9aW1nbWFuYWdlciZ2ZXJzaW9uPTE1NzYiO2k6MTc2O3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aToxNzc7czo0MToiaWZcKFxzKmlzc2V0XChccypcJF9SRVFVRVNUXFtbJyJdezAsMX1jaWQiO2k6MTc4O3M6NDA6InN0cl9yZXBsYWNlXHMqXChccypbJyJdezAsMX0vcHVibGljX2h0bWwiO2k6MTc5O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aToxODA7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjE4MTtzOjk0OiJpZlwoaXNfZGlyXChcJHBhdGhcLlsnIl17MCwxfS93cC1jb250ZW50WyciXXswLDF9XClccytBTkRccytpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWFkbWluIjtpOjE4MjtzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjE4MztzOjk6ImJ5XHMrZzAwbiI7aToxODQ7czoxNToiQXV0b1xzKlhwbG9pdGVyIjtpOjE4NTtzOjEwMjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiIjtpOjE4NjtzOjcyOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9Y21kXC5leGUiO2k6MTg3O3M6OToiQnlccytEWjI3IjtpOjE4ODtzOjI3OiJFdGhuaWNccytBbGJhbmlhblxzK0hhY2tlcnMiO2k6MTg5O3M6MjA6IlZvbGdvZ3JhZGluZGV4XC5odG1sIjtpOjE5MDtzOjMyOiJcJF9Qb3N0XFtbJyJdezAsMX1TU05bJyJdezAsMX1cXSI7aToxOTE7czoxNToicGFja1xzKyJTbkE0eDgiIjtpOjE5MjtzOjE0OiJbJyJdezAsMX1EWmUxciI7aToxOTM7czoxMjoiVGVhTVxzK01vc1RhIjtpOjE5NDtzOjYzOiJpZlwobWFpbFwoXCRlbWFpbFxbXCRpXF0sXHMqXCRzdWJqZWN0LFxzKlwkbWVzc2FnZSxccypcJGhlYWRlcnMiO2k6MTk1O3M6MzY6InByaW50XHMrWyciXXswLDF9ZGxlX251bGxlZFsnIl17MCwxfSI7aToxOTY7czozOToiaWZccypcKGNoZWNrX2FjY1woXCRsb2dpbixcJHBhc3MsXCRzZXJ2IjtpOjE5NztzOjM4OiJwcmVnX3JlcGxhY2VcKFwpe3JldHVyblxzK19fRlVOQ1RJT05fXyI7aToxOTg7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAKlwkX0NPT0tJRVxbIjtpOjE5OTtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6MjAwO3M6MTA4OiJmb3JcKFwkW2EtekEtWjAtOV9dKz89XGQrO1wkW2EtekEtWjAtOV9dKz88XGQrO1wkW2EtekEtWjAtOV9dKz8tPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSs/IT1cZCtcKVxzKmJyZWFrO30iO2k6MjAxO3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjIwMjtzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjIwMztzOjQyOiJpZlxzKlwoZnVuY3Rpb25fZXhpc3RzXChbJyJdc2Nhbl9kaXJlY3RvcnkiO2k6MjA0O3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjIwNTtzOjM4OiJaZW5kXHMrT3B0aW1pemF0aW9uXHMrdmVyXHMrMVwuMFwuMFwuMSI7aToyMDY7czoyNjoiaW5kZXhcLnBocFw/aWQ9XCQxJiV7UVVFUlkiO2k6MjA3O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjIwODtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjIwOTtzOjI4OiJcJF9QT1NUXFtbJyJdezAsMX1zbXRwX2xvZ2luIjtpOjIxMDtzOjM3OiJfWyciXXswLDF9XF1cWzJcXVwoWyciXXswLDF9TG9jYXRpb246IjtpOjIxMTtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjIxMjtzOjE1OiI8IS0tXHMranMtdG9vbHMiO2k6MjEzO3M6NzoidWdnYzovLyI7aToyMTQ7czo0NzoiaWYgXChkYXRlXChbJyJdezAsMX1qWyciXXswLDF9XClccyotXHMqXCRuZXdzaWQiO2k6MjE1O3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjIxNjtzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjIxNztzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aToyMTg7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aToyMTk7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6MjIwO3M6MTA0OiJzaXRlX2Zyb209WyciXXswLDF9XC5cJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxdXC5bJyJdezAsMX0mc2l0ZV9mb2xkZXI9WyciXXswLDF9XC5cJGZcWzFcXSI7aToyMjE7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aToyMjI7czozMzoicG9ydGxldHMvZnJhbWV3b3JrL3NlY3VyaXR5L2xvZ2luIjtpOjIyMztzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aToyMjQ7czo1MToiXCRkYXRhXHMqPVxzKmFycmF5XChbJyJdezAsMX10ZXJtaW5hbFsnIl17MCwxfVxzKj0+IjtpOjIyNTtzOjcwOiJzdHJwb3NcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XF0sXHMqWyciXXswLDF9Z29vZ2xlIjtpOjIyNjtzOjcwOiJzdHJwb3NcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XF0sXHMqWyciXXswLDF9eWFuZGV4IjtpOjIyNztzOjc3OiJzdHJpc3RyXChcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdLFxzKlsnIl17MCwxfVlhbmRleEJvdCI7aToyMjg7czo1MzoiZm9wZW5cKFsnIl17MCwxfVwuXC4vXC5cLi9cLlwuL1snIl17MCwxfVwuXCRmaWxlcGF0aHMiO2k6MjI5O3M6MzY6InByZWdfcmVwbGFjZVwoXHMqWyciXWVbJyJdLFsnIl17MCwxfSI7aToyMzA7czo0MDoiKFteXD9cc10pXCh7MCwxfVwuW1wrXCpdXCl7MCwxfVwyW2Etel0qZSI7aToyMzE7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MjMyO3M6MzU6InBocF9bJyJdXC5cJGV4dFwuWyciXVwuZGxsWyciXXswLDF9IjtpOjIzMztzOjIwOiIvZVsnIl1ccyosXHMqWyciXVxceCI7aToyMzQ7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6MjM1O3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjtpOjIzNjtzOjQ0OiJhcnJheVwoXHMqWyciXUdvb2dsZVsnIl1ccyosXHMqWyciXVNsdXJwWyciXSI7aToyMzc7czoxMjoiYW5kZXhcfG9vZ2xlIjtpOjIzODtzOjI0OiJwYWdlX2ZpbGVzL3N0eWxlMDAwXC5jc3MiO2k6MjM5O3M6MjE6Ij09WyciXVwpXCk7cmV0dXJuO1w/PiI7aToyNDA7czoxNjoiU3BhbVxzK2NvbXBsZXRlZCI7aToyNDE7czozNToiZWNob1xzK1snIl17MCwxfWluc3RhbGxfb2tbJyJdezAsMX0iO2k6MjQyO3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aToyNDM7czoxMToiQ1ZWOlxzKlwkY3YiO2k6MjQ0O3M6MzA6ImN1cmxcLmhheHhcLnNlL3JmYy9jb29raWVfc3BlYyI7aToyNDU7czoxMjoia2lsbGFsbFxzKy05IjtpOjI0NjtzOjU3OiJwcmVnX3JlcGxhY2VccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjQ3O3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjQ4O3M6MzA6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cLlwqLyI7aToyNDk7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly8iO2k6MjUwO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDBccytodHRwOi8vIjtpOjI1MTtzOjI5OiJFcnJvckRvY3VtZW50XHMrNTAwXHMraHR0cDovLyI7aToyNTI7czoyODoiZ29vZ2xlXHx5YW5kZXhcfGJvdFx8cmFtYmxlciI7aToyNTM7czoyMToiZXZhbFxzKlwoXHMqc3RyX3JvdDEzIjtpOjI1NDtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyNTU7czo0ODoiZnVuY3Rpb25ccypjaG1vZF9SXHMqXChccypcJHBhdGhccyosXHMqXCRwZXJtXHMqIjtpOjI1NjtzOjMzOiJzeW1iaWFuXHxtaWRwXHx3YXBcfHBob25lXHxwb2NrZXQiO2k6MjU3O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MjU4O3M6NzI6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdLFxzKnRpbWVcKFwpXHMqXCtccyo4NjQwMCI7aToyNTk7czo3MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJdd2dldCI7aToyNjA7czozMzoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjI2MTtzOjMwOiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MjYyO3M6MjU6ImV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MjYzO3M6MzI6InN0cl9pcmVwbGFjZVxzKlwoKlxzKlsnIl08L2hlYWQ+IjtpOjI2NDtzOjM5OiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXSN5YW5kZXgiO2k6MjY1O3M6MzE6Ij1ccyphcnJheV9tYXBccypcKCpccypzdHJyZXZccyoiO2k6MjY2O3M6OToiXCRfX19ccyo9IjtpOjI2NztzOjQ5OiJnenVuY29tcHJlc3NccypcKCpccypzdWJzdHJccypcKCpccypiYXNlNjRfZGVjb2RlIjtpOjI2ODtzOjIzOiJBZGRIYW5kbGVyXHMrY2dpLXNjcmlwdCI7aToyNjk7czoyMzoiQWRkSGFuZGxlclxzK3BocC1zY3JpcHQiO2k6MjcwO3M6MTQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpIjtpOjI3MTtzOjM4OiJzdHJlYW1fc29ja2V0X2NsaWVudFxzKlwoXHMqWyciXXRjcDovLyI7aToyNzI7czo5NToiaXNzZXRcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqb3JccypkaWVcKCouKj9cKSoiO2k6MjczO3M6NTc6Ik9wdGlvbnNccytGb2xsb3dTeW1MaW5rc1xzK011bHRpVmlld3NccytJbmRleGVzXHMrRXhlY0NHSSI7aToyNzQ7czozMjoiaXNfd3JpdGFibGVccypcKCpccypbJyJdL3Zhci90bXAiO2k6Mjc1O3M6OTU6ImFkZF9maWx0ZXJccypcKCpccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCkqIjtpOjI3NjtzOjI5OiJldmFsXHMqXCgqXHMqZ2V0X29wdGlvblxzKlwoKiI7aToyNzc7czoxMDQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbIjtpOjI3ODtzOjEwNzoiaWZccypcKFxzKmlzX2NhbGxhYmxlXHMqXCgqXHMqWyciXXswLDF9KGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKSoiO2k6Mjc5O3M6MTE0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKlwpXHMqXCkiO2k6MjgwO3M6NzQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXJtXHMqLWZyIjtpOjI4MTtzOjc0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl1ybVxzKi1yZiI7aToyODI7czo3ODoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJdcm1ccyotclxzKi1mIjtpOjI4MztzOjQwOiJldmFsXHMqXCgqXHMqZ3ppbmZsYXRlXHMqXCgqXHMqc3RyX3JvdDEzIjtpOjI4NDtzOjE5OiJyb3VuZFxzKlwoXHMqMFxzKlwrIjtpOjI4NTtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NTM6e2k6MDtzOjY3OiJcLlwkX1JFUVVFU1RcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVxzKixccyp0cnVlXHMqLFxzKjMwMlwpIjtpOjE7czoxNDA6IiNbYS16QS1aMC05X10rPyNccyppZlwoZW1wdHlcKFwkW2EtekEtWjAtOV9dKz9cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXTxzY3JpcHQuKz9lY2hvIFwkW2EtekEtWjAtOV9dKz87XHMqfVxzKiMvW2EtekEtWjAtOV9dKz8jIjtpOjI7czoxODY6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvaHRtbD5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cKSI7aTozO3M6Mzc6IlwkdGV4dFxzKj1ccypodHRwX2dldFwoXHMqWyciXWh0dHA6Ly8iO2k6NDtzOjE1OiI9PT06OjptYWQ6Ojo9PT0iO2k6NTtzOjEwNzoiQGluaV9zZXRcKFsnIl1lcnJvcl9sb2dbJyJdLE5VTExcKTtccypAaW5pX3NldFwoWyciXWxvZ19lcnJvcnNbJyJdLDBcKTtccypmdW5jdGlvblxzK3JlYWRfZmlsZVwoXCRmaWxlX25hbWUiO2k6NjtzOjIyOiJleHBsb2l0XHMqOjpcLjwvdGl0bGU+IjtpOjc7czo5NToiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKTtccypoZWFkZXIiO2k6ODtzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTo5O3M6MTA3OiI9XHMqbWFpbFwoXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRbYS16QS1aMC05X10rP1xbXGQrXF1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXSs/XFtcZCtcXSI7aToxMDtzOjgzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKmRlY3J5cHRfU09cKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVthLXpBLVowLTlfXSs/WyciXSI7aToxMTtzOjU2OiJcJFthLXpBLVowLTlfXSs/PXVybGRlY29kZVwoWyciXS4rP1snIl1cKTtpZlwocHJlZ19tYXRjaCI7aToxMjtzOjY4OiJcJFthLXpBLVowLTlfXSs/PT1bJyJdZmVhdHVyZWRbJyJdXHMqXClccypcKXtccyplY2hvXHMrYmFzZTY0X2RlY29kZSI7aToxMztzOjExOiI9PVsnIl1cKVwpOyI7aToxNDtzOjExMDoiaWZccypcKFxzKmZpbGVfZXhpc3RzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKVxzKntccypjaG1vZFwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccyowXGQrXCk7XHMqfVxzKmVjaG8iO2k6MTU7czozNzoiZXZhbFwoXHMqWyciXXtccypcJFthLXpBLVowLTlfXSs/XHMqfSI7aToxNjtzOjEyNjoiKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSlcKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkIjtpOjE3O3M6MzA6InJlYWRfZmlsZVwoXHMqWyciXWRvbWFpbnNcLnR4dCI7aToxODtzOjM5OiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVFxbXHMqWyciXXBpbmciO2k6MTk7czo5OToiXF1cKFsnIl1cJF9bJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdIjtpOjIwO3M6NTY6IkAqY3JlYXRlX2Z1bmN0aW9uXChccypbJyJdWyciXVxzKixccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjIxO3M6NDE6ImZ3cml0ZVwoXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdPFw/cGhwIjtpOjIyO3M6MTQ1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHMqW2EtekEtWjAtOV9dKz9ccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSs/IjtpOjIzO3M6MTc6IkdhbnRlbmdlcnNccytDcmV3IjtpOjI0O3M6ODU6InJlY3Vyc2VfY29weVwoXHMqXCRzcmNccyosXHMqXCRkc3RccypcKTtccypoZWFkZXJcKFxzKlsnIl1sb2NhdGlvbjpccypcJGRzdFsnIl1ccypcKTsiO2k6MjU7czozNToiXC5cLi9cLlwuL2VuZ2luZS9kYXRhL2RiY29uZmlnXC5waHAiO2k6MjY7czo0MjoiPVxzKkAqZnNvY2tvcGVuXChccypcJGFyZ3ZcW1xkK1xdXHMqLFxzKjgwIjtpOjI3O3M6MjY6IihcLmNoclwoXHMqXGQrXHMqXClcLil7NCx9IjtpOjI4O3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjI5O3M6MzE1OiJAKihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDUpXHMqXChAKihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDUpXHMqXChAKihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDUpXHMqXCgiO2k6MzA7czo2NzoiPCEtLWNoZWNrOlsnIl1ccypcLlxzKm1kNVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTozMTtzOjI4OiJcJHNldGNvb2tccypcKTtzZXRjb29raWVcKFwkIjtpOjMyO3M6Njg6ImNvcHlcKFxzKlsnIl1odHRwOi8vLio/XC50eHRbJyJdXHMqLFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVwpIjtpOjMzO3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aTozNDtzOjEzOiJ3c29TZWNQYXJhbVwoIjtpOjM1O3M6NTc6IlwkW2EtekEtWjAtOV9dKz9cKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkW2EtekEtWjAtOV9dKz9cKSI7aTozNjtzOjYwOiJzdWJzdHJcKHNwcmludGZcKFsnIl0lb1snIl0sXHMqZmlsZXBlcm1zXChcJGZpbGVcKVwpLFxzKi00XCkiO2k6Mzc7czoyNjoiXCR7W2EtekEtWjAtOV9dKz99XChccypcKTsiO2k6Mzg7czo0OToiQCpmaWxlX2dldF9jb250ZW50c1woQCpiYXNlNjRfZGVjb2RlXChAKnVybGRlY29kZSI7aTozOTtzOjg6Ii9rcnlha2kvIjtpOjQwO3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTo0MTtzOjE1NjoiXCRfU0VSVkVSXFtbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8sIjtpOjQyO3M6MTA1OiJpZlxzKlwoXHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cnJwb3NcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6NDM7czoxMzoiPT1bJyJdXClccypcLiI7aTo0NDtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTo0NTtzOjEwOiJkZWtjYWhbJyJdIjtpOjQ2O3M6MzA6IlwkZGVmYXVsdF91c2VfYWpheFxzKj1ccyp0cnVlOyI7aTo0NztzOjUxOiJSZXdyaXRlUnVsZVxzK1xeXChcLlwqXClcJFxzK2h0dHA6Ly9cZCtcLlxkK1wuXGQrXC4iO2k6NDg7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6NDk7czo1MzoiUmV3cml0ZUVuZ2luZVxzK09uXHMqUmV3cml0ZUJhc2VccysvXD9bYS16QS1aMC05X10rPz0iO2k6NTA7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTo1MTtzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6NTI7czo4MzoiaW5jbHVkZVwoXHMqWyciXWRhdGE6dGV4dC9wbGFpbjtiYXNlNjRccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWzsiO2k6NTM7czoyMjoicnVua2l0X2Z1bmN0aW9uX3JlbmFtZSI7aTo1NDtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6NTU7czoxMTY6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rP1wpIjtpOjU2O3M6NDc6ImV4cGxvZGVcKFsnIl1cXG5bJyJdLFxzKlwkX1BPU1RcW1snIl11cmxzWyciXVxdIjtpOjU3O3M6NTU6ImlmXHMqXChccypcJHRoaXMtPml0ZW0tPmhpdHNccyo+PVsnIl1cZCtbJyJdXClccyp7XHMqXCQiO2k6NTg7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjU5O3M6Mjg6InN0cl9yZXBsYWNlXChbJyJdL1w/YW5kclsnIl0iO2k6NjA7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTo2MTtzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTo2MjtzOjEzMzoiXCRbYS16QS1aMC05X10rP1xzKlwuPVxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfSI7aTo2MztzOjMzOiJcJFthLXpBLVowLTlfXSs/XChccypAXCRfQ09PS0lFXFsiO2k6NjQ7czoxMTc6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcKSI7aTo2NTtzOjIyOiJnXChccypbJyJdRmlsZXNNYW5bJyJdIjtpOjY2O3M6NTQ6IlwkW2EtekEtWjAtOV9dKz89Ii9ob21lL1thLXpBLVowLTlfXSs/L1thLXpBLVowLTlfXSs/LyI7aTo2NztzOjMzOiI9XHMqQCpnemluZmxhdGVcKFxzKnN0cnJldlwoXHMqXCQiO2k6Njg7czo0MDoic3RyX3JlcGxhY2VcKFsnIl1cLmh0YWNjZXNzWyciXVxzKixccypcJCI7aTo2OTtzOjM0OiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjcwO3M6Njc6ImV2YWxcKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz8iO2k6NzE7czoxNToiTXVzdEBmQFxzK1NoZWxsIjtpOjcyO3M6NDE6ImFzc2VydF9vcHRpb25zXChccypBU1NFUlRfV0FSTklOR1xzKixccyowIjtpOjczO3M6MzE6IlwkaW5zZXJ0X2NvZGVccyo9XHMqWyciXTxpZnJhbWUiO2k6NzQ7czozNDoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqWyciXSI7aTo3NTtzOjYzOiJcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6NzY7czo2NjoiYXJyYXlfZmxpcFwoXHMqYXJyYXlfbWVyZ2VcKFxzKnJhbmdlXChccypbJyJdQVsnIl1ccyosXHMqWyciXVpbJyJdIjtpOjc3O3M6MjI6Ij5ccyo8L2lmcmFtZT5ccyo8XD9waHAiO2k6Nzg7czoxMjY6InN1YnN0clwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcZCtccyosXHMqXGQrXHMqXCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypwcmVnX3JlcGxhY2VcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqc3RydHJcKCI7aTo3OTtzOjIxOiJleHBsb2RlXChcXFsnIl07dGV4dDsiO2k6ODA7czo0NDoiZnVuY3Rpb25ccytfXGQrXChccypcJFthLXpBLVowLTlfXSs/XHMqXCl7XCQiO2k6ODE7czozMDoic3RyX3JlcGxhY2VcKFxzKlsnIl1cLmh0YWNjZXNzIjtpOjgyO3M6MTY6InRhZ3MvXCQ2L1wkNC9cJDciO2k6ODM7czoxOTI6IlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLiI7aTo4NDtzOjIwOToiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlcKFxzKlwkX1JFUVVFU1RcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1ccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmFycmF5X2ZpbHRlclwoXHMqXCQiO2k6ODU7czoyMjoicmV0dXJuXHMqWyciXS92YXIvd3d3LyI7aTo4NjtzOjQ3OiJmb3BlblwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS93cC1hZG1pbiI7aTo4NztzOjM1OiJpZlxzKlwoXHMqaXNfd3JpdGFibGVcKFxzKlwkd3d3UGF0aCI7aTo4ODtzOjM3OiI9XHMqWyciXXBocF92YWx1ZVxzK2F1dG9fcHJlcGVuZF9maWxlIjtpOjg5O3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aTo5MDtzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6OTE7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjkyO3M6MTI6ImBjaGVja3N1ZXhlYyI7aTo5MztzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6OTQ7czozNToiZWNobyBbYS16QS1aMC05X10rP1xzKlwoWyciXWh0dHA6Ly8iO2k6OTU7czo5OiJtYWFmXHMreWEiO2k6OTY7czo0NjoiQGVycm9yX3JlcG9ydGluZ1woMFwpO1xzKkBzZXRfdGltZV9saW1pdFwoMFwpOyI7aTo5NztzOjE0OiJMaWJYbWwySXNCdWdneSI7aTo5ODtzOjE1NjoiPVxzKm1haWxcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjk5O3M6MjExOiI9XHMqbWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjEwMDtzOjkyOiJtYWlsXChccypzdHJpcHNsYXNoZXNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKixccypzdHJpcHNsYXNoZXNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKSI7aToxMDE7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aToxMDI7czo2Mzoic3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXSxbYS16QS1aMC05X10rP1wuWyciXTwvYm9keT5bJyJdLFwkIjtpOjEwMztzOjE0OiIhL3Vzci9iaW4vcGVybCI7aToxMDQ7czoyMToiXHxib3RcfHNwaWRlclx8d2dldC9pIjtpOjEwNTtzOjE1OiJbJyJdXClcKVwpOyJcKTsiO2k6MTA2O3M6MzA6InRvdWNoXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aToxMDc7czozNzoiZmlsZV9nZXRfY29udGVudHNcKF9fRklMRV9fXCksXCRtYXRjaCI7aToxMDg7czo4OToic3RyX3JlcGxhY2VcKGFycmF5XChbJyJdZmlsdGVyU3RhcnRbJyJdLFsnIl1maWx0ZXJFbmRbJyJdXCksXHMqYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCoiO2k6MTA5O3M6Mjc6IndwLW9wdGlvbnNcLnBocFxzKj5ccypFcnJvciI7aToxMTA7czo2MzoiJTYzJTcyJTY5JTcwJTc0JTJFJTczJTcyJTYzJTNEJTI3JTY4JTc0JTc0JTcwJTNBJTJGJTJGJTczJTZGJTYxIjtpOjExMTtzOjEyOiJcLnd3dy8vOnB0dGgiO2k6MTEyO3M6MTIyOiJpZlwoaXNzZXRcKFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqJiZccyptZDVcKFwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKVxzKj09XHMqWyciXSI7aToxMTM7czo2ODoiXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlxeXHMqXCRbYS16QS1aMC05X10rP1xzKjsiO2k6MTE0O3M6MzI6IlsnIl1ccypcXlxzKlwkW2EtekEtWjAtOV9dKz9ccyo7IjtpOjExNTtzOjYzOiJcJFthLXpBLVowLTlfXSs/LT5fc2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTE2O3M6OTM6IlwkW2EtekEtWjAtOV9dKz89WyciXVthLXpBLVowLTlcK1w9X10rWyciXTtccyplY2hvXHMrYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rP1wpO1xzKlw/PiI7aToxMTc7czozNToiYmVnaW5ccyttb2Q6XHMrVGhhbmtzXHMrZm9yXHMrcG9zdHMiO2k6MTE4O3M6MzQ6ImV2YWxcKFxzKlsnIl1cPz5bJyJdXHMqXC5ccypqb2luXCgiO2k6MTE5O3M6NTg6IlwkW2EtekEtWjAtOV9dKz9cW1xzKl9bYS16QS1aMC05X10rP1woXHMqXGQrXHMqXClccypcXVxzKj0iO2k6MTIwO3M6MTk6ImltYXBfaGVhZGVyaW5mb1woXCQiO2k6MTIxO3M6NjU6IlwkdG9ccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl10b19hZGRyZXNzIjtpOjEyMjtzOjYxOiJnZXRfdXNlcnNcKFxzKmFycmF5XChccypbJyJdcm9sZVsnIl1ccyo9PlxzKlsnIl1hZG1pbmlzdHJhdG9yIjtpOjEyMztzOjYzOiJeXHMqPFw/cGhwXHMqaGVhZGVyXChbJyJdTG9jYXRpb246XHMqaHR0cDovLy4rP1snIl1ccypcKTtccypcPz4iO2k6MTI0O3M6MTQ6Ijx0aXRsZT5ccyppdm56IjtpOjEyNTtzOjg1OiJeXHMqPFw/cGhwXHMqaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqWyciXVxzKlwuXHMqWyciXVxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjEyNjtzOjMzOiI9XHMqZXNjX3VybFwoXHMqc2l0ZV91cmxcKFxzKlsnIl0iO2k6MTI3O3M6MzU6ImhyZWY9WyciXTxcP3BocFxzK2VjaG9ccytcJGN1cl9wYXRoIjtpOjEyODtzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjEyOTtzOjQxOiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1mXCRbYS16QS1aMC05X10rPyI7aToxMzA7czo4MzoiZWNob1xzK3N0cl9yZXBsYWNlXChccypbJyJdXFtQSFBfU0VMRlxdWyciXVxzKixccypiYXNlbmFtZVwoXCRfU0VSVkVSXFtbJyJdUEhQX1NFTEYiO2k6MTMxO3M6Mjk6ImdtYWlsLXNtdHAtaW5cLmxcLmdvb2dsZVwuY29tIjtpOjEzMjtzOjEwOiJ0YXJccystemNDIjtpOjEzMztzOjMxOiJcJF9bYS16QS1aMC05X10rP1woXHMqXCk7XHMqXD8+IjtpOjEzNDtzOjE5OiI9XHMqeGRpclwoXHMqXCRwYXRoIjtpOjEzNTtzOjYxOiJcJGZyb21ccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1mcm9tIjtpOjEzNjtzOjc5OiJlY2hvXHMrXCRbYS16QS1aMC05X10rPztta2RpclwoXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlwpO2ZpbGVfcHV0X2NvbnRlbnRzIjtpOjEzNztzOjgzOiJcJFthLXpBLVowLTlfXSs/PVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZG9bJyJdXHMqXF07XHMqaW5jbHVkZSI7aToxMzg7czoxNjoiQGFzc2VydFwoXHMqWyciXSI7aToxMzk7czo3MjoiXCRbYS16QS1aMC05X10rP1xzKj1ccypmb3BlblwoXHMqWyciXVthLXpBLVowLTlfXSs/XC5waHBbJyJdXHMqLFxzKlsnIl13IjtpOjE0MDtzOjc3OiI8aGVhZD5ccyo8c2NyaXB0PlxzKndpbmRvd1wudG9wXC5sb2NhdGlvblwuaHJlZj1bJyJdLis/XHMqPC9zY3JpcHQ+XHMqPC9oZWFkPiI7aToxNDE7czoyOToiQ1VSTE9QVF9VUkxccyosXHMqWyciXXNtdHA6Ly8iO2k6MTQyO3M6MzI6ImV2YWxcKFwkY29udGVudFwpO1xzKmVjaG9ccypbJyJdIjtpOjE0MztzOjU1OiJcJGZccyo9XHMqXCRmXGQrXChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/IjtpOjE0NDtzOjI3OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XCgiO2k6MTQ1O3M6MzQ6ImZ1bmN0aW9uXHMrX19maWxlX2dldF91cmxfY29udGVudHMiO2k6MTQ2O3M6MzY6IiNbYS16QS1aMC05X10rPyMuKz8jL1thLXpBLVowLTlfXSs/IyI7aToxNDc7czoyNDoiZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkIjtpOjE0ODtzOjE5OiI9WyciXVwpXHMqXCk7XHMqXD8+IjtpOjE0OTtzOjM1OiI9PVxzKkZBTFNFXHMqXD9ccypcZCtccyo6XHMqaXAybG9uZyI7aToxNTA7czozODoiZWxzZWlmXChccypcJHNxbHR5cGVccyo9PVxzKlsnIl1zcWxpdGUiO2k6MTUxO3M6MTc6Ijx0aXRsZT5ccypWYVJWYVJhIjtpOjE1MjtzOjUxOiJpZlxzKlwoXHMqIWZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXN5c19nZXRfdGVtcF9kaXIiO2k6MTUzO3M6NDA6Im1haWxcKFwkdG9ccyosXHMqWyciXS4rP1snIl1ccyosXHMqXCR1cmwiO2k6MTU0O3M6NTg6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTU1O3M6NDM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8iO2k6MTU2O3M6Njk6ImVjaG9cKFsnIl08Zm9ybSBtZXRob2Q9WyciXXBvc3RbJyJdXHMqZW5jdHlwZT1bJyJdbXVsdGlwYXJ0L2Zvcm0tZGF0YSI7aToxNTc7czoxNDoid3NvSGVhZGVyXHMqXCgiO2k6MTU4O3M6NzU6ImFycmF5XChccypbJyJdPCEtLVsnIl1ccypcLlxzKm1kNVwoXHMqXCRyZXF1ZXN0X3VybFxzKlwuXHMqcmFuZFwoXGQrLFxzKlxkKyI7aToxNTk7czoxMjQ6IlwkW2EtekEtWjAtOV9dKz89WyciXWh0dHA6Ly8uKz9bJyJdO1xzKlwkW2EtekEtWjAtOV9dKz89Zm9wZW5cKFwkW2EtekEtWjAtOV9dKz8sWyciXXJbJyJdXCk7XHMqcmVhZGZpbGVcKFwkW2EtekEtWjAtOV9dKz9cKTsiO2k6MTYwO3M6NjA6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKi5ccypcZCtccypcXVwoXHMqW2EtekEtWjAtOV9dKz9cKCI7aToxNjE7czo1MzoiZXJyb3JfcmVwb3J0aW5nXChccyowXHMqXCk7XHMqXCR1cmxccyo9XHMqWyciXWh0dHA6Ly8iO2k6MTYyO3M6OTU6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xdIjtpOjE2MztzOjkwOiJAXCR7XHMqW2EtekEtWjAtOV9dKz9ccyp9XChccypbJyJdWyciXVxzKixccypcJHtccypbYS16QS1aMC05X10rP1xzKn1cKFxzKlwkW2EtekEtWjAtOV9dKz8iO2k6MTY0O3M6MTM6IkRldmFydFxzK0hUVFAiO2k6MTY1O3M6MTA6IlwucGhwXD9cJDAiO2k6MTY2O3M6NTU6IjxpbnB1dFxzKnR5cGU9WyciXWZpbGVbJyJdXHMqbmFtZT1bJyJddXNlcmZpbGVbJyJdXHMqLz4iO2k6MTY3O3M6MTEwOiJcJG1lc3NhZ2VzXFtcXVxzKj1ccypcJF9GSUxFU1xbXHMqWyciXXswLDF9dXNlcmZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdXFtccypcJGlccypcXSI7aToxNjg7czo1MDoiPGlucHV0XHMqdHlwZT0iZmlsZSJccypzaXplPSJcZCsiXHMqbmFtZT0idXBsb2FkIj4iO2k6MTY5O3M6MTI6IjxcPz1cJGNsYXNzOyI7aToxNzA7czo0MToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeMjE3XC4xMTgiO2k6MTcxO3M6Mzk6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjg1XC4yNiI7aToxNzI7czoxMDI6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChbJyJdaHR0cDovLy4rP1wuanBnWyciXVwpO1xzKmV4aXRcKFwpOyI7aToxNzM7czo1MToiZm9yZWFjaFwoXHMqXCR0b3Nccyphc1xzKlwkdG9cKVxzKntccyptYWlsXChccypcJHRvIjtpOjE3NDtzOjE2OiJmdW5jdGlvblxzK3dzb0V4IjtpOjE3NTtzOjE1MDoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdXCRbYS16QS1aMC05X10rPz1AW2EtekEtWjAtOV9dKz9cKFsnIl0uKz9bJyJdXCk7W2EtekEtWjAtOV9dKz9cKCFcJFthLXpBLVowLTlfXSs/XCl7XCRbYS16QS1aMC05X10rPz1AW2EtekEtWjAtOV9dKz9cKFxzKlwpIjtpOjE3NjtzOjUwOiJSZXdyaXRlUnVsZVxzKlwuXCovXC5cKlxzKlthLXpBLVowLTlfXSs/XC5waHBcP1wkMCI7aToxNzc7czo0NjoiaHR0cDovLy4rPy8uKz9cLnBocFw/YT1cZCsmYz1bYS16QS1aMC05X10rPyZzPSI7aToxNzg7czoxODoidGNwOi8vMTI3XC4wXC4wXC4xIjtpOjE3OTtzOjI3OiIhPVxzKlsnIl1pbmZvcm1hdGlvbl9zY2hlbWEiO2k6MTgwO3M6Mzk6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkX0dFVFxbXHMqWyciXWNweSI7aToxODE7czo3NDoiaWZccypcKGlzc2V0XChcJF9HRVRcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXClccyp7XHMqZWNob1xzKlsnIl1va1snIl0iO2k6MTgyO3M6Njg6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcHl0aG9uIjtpOjE4MztzOjY2OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXXBlcmwiO2k6MTg0O3M6MjU6ImZ1bmN0aW9uXHMrZXJyb3JfNDA0XChcKXsiO2k6MTg1O3M6OTc6IlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcJEdMT0JBTFNcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbXGQrXF1cKHJvdW5kXChcZCtcKVwpXF0iO2k6MTg2O3M6ODE6IkAoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqQHVybGVuY29kZVwoXHMqXCRfUE9TVCI7aToxODc7czozNToiZmlsZV9nZXRfY29udGVudHNcKFxzKl9fRklMRV9fXHMqXCkiO2k6MTg4O3M6NDg6IlwkZWNob18xXC5cJGVjaG9fMlwuXCRlY2hvXzNcLlwkZWNob180XC5cJGVjaG9fNSI7aToxODk7czozNzoiaWZccypcKFxzKmlzX2NyYXdsZXIxXChccypcKVxzKlwpXHMqeyI7aToxOTA7czo4NDoiZXZhbFwoXHMqW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCk7XHMqXD8+IjtpOjE5MTtzOjMxOiI9PlxzKkBcJGYyXChfX0ZJTEVfX1xzKixccypcJGYxIjtpOjE5MjtzOjExMDoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcKTtccypleGl0XChccypcKTsiO2k6MTkzO3M6MjQ1OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkW2EtekEtWjAtOV9dKz9cKFsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXClccypcKSI7aToxOTQ7czo2MzoiXCRfUE9TVFxbWyciXXswLDF9dHAyWyciXXswLDF9XF1ccypcKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjE5NTtzOjQxOiJjaG1vZFwoXCRmaWxlLT5nZXRQYXRobmFtZVwoXClccyosXHMqMDc3NyI7aToxOTY7czozODoiPVxzKmd6aW5mbGF0ZVwoXHMqYmFzZTY0X2RlY29kZVwoXHMqXCQiO2k6MTk3O3M6NjQ6IlwkX1BPU1RcW1snIl17MCwxfWFjdGlvblsnIl17MCwxfVxdXHMqPT1ccypbJyJdZ2V0X2FsbF9saW5rc1snIl0iO2k6MTk4O3M6NzU6ImZ1bmN0aW9uPHNzPnNtdHBfbWFpbFwoXCR0b1xzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aToxOTk7czo2NzoiXCRnenBccyo9XHMqXCRiZ3pFeGlzdFxzKlw/XHMqQGd6b3BlblwoXCR0bXBmaWxlLFxzKlsnIl1yYlsnIl1ccypcKSI7aToyMDA7czo0MzoiXF1ccypcKVxzKlwuXHMqWyciXVxcblw/PlsnIl1ccypcKVxzKlwpXHMqeyI7aToyMDE7czo0MDoiQ29kZU1pcnJvclwuZGVmaW5lTUlNRVwoXHMqWyciXXRleHQvbWlyYyI7aToyMDI7czoyODoiY2htb2RcKFxzKl9fRElSX19ccyosXHMqMDQwMCI7aToyMDM7czo0MDoiZnB1dHNcKFwkZnAsXHMqWyciXUlQOlxzKlwkaXBccyotXHMqREFURSI7aToyMDQ7czo0NDoiXCRmaWxlX2RhdGFccyo9XHMqWyciXTxzY3JpcHRccypzcmM9WyciXWh0dHAiO2k6MjA1O3M6MTI6Im5ld1xzKk1DdXJsOyI7aToyMDY7czoyNDoibnNsb29rdXBcLmV4ZVxzKi10eXBlPU1YIjtpOjIwNztzOjM0OiJmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl1nZXRteHJyIjtpOjIwODtzOjMyOiJkbnNfZ2V0X3JlY29yZFwoXHMqXCRkb21haW5ccypcLiI7aToyMDk7czoxMTY6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1cW1snIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XF1cW1xzKlwkaVxzKlxdIjtpOjIxMDtzOjEwOToiY29weVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRfUE9TVCI7aToyMTE7czo4NjoiXCR1cmxccypcLj1ccypbJyJdXD9bYS16QS1aMC05X10rPz1bJyJdXHMqXC5ccypcJF9HRVRcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXTsiO2k6MjEyO3M6MjY6IjxcP1xzKmVjaG9ccypcJGNvbnRlbnQ7XD8+IjtpOjIxMztzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKmdvb2dsZSI7aToyMTQ7czozODoiUmV3cml0ZUNvbmRccyole0hUVFBfUkVGRVJFUn1ccyp5YW5kZXgiO2k6MjE1O3M6MzY6ImlmXHMqXChccypcJF9QT1NUXFtbJyJdezAsMX1jaG1vZDc3NyI7aToyMTY7czo0MjoiY29ublxzKj1ccypodHRwbGliXC5IVFRQQ29ubmVjdGlvblwoXHMqdXJpIjtpOjIxNztzOjMzOiJlY2hvXHMqXCRwcmV3dWVcLlwkbG9nXC5cJHBvc3R3dWUiO2k6MjE4O3M6NDQ6ImhlYWRlclwoXHMqWyciXVJlZnJlc2g6XHMqXGQrO1xzKlVSTD1odHRwOi8vIjtpOjIxOTtzOjM2OiJzZXRfdGltZV9saW1pdFwoXHMqaW50dmFsXChccypcJGFyZ3YiO2k6MjIwO3M6Mzc6ImRpZVwoWyciXTxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC4iO2k6MjIxO3M6Mzg6ImV4aXRcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjIyMjtzOjk6IkdBR0FMPC9iPiI7aToyMjM7czo5MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKFxzKlsnIl1cJFthLXpBLVowLTlfXSs/WyciXVxzKlwpIjtpOjIyNDtzOjE5OiJidWRha1xzKi1ccypleHBsb2l0IjtpOjIyNTtzOjIyOiJhcnJheVwoXHMqWyciXSUxaHRtbCUzIjtpOjIyNjtzOjU2OiJcJGNvZGU9WyciXSUxc2NyaXB0XHMqdHlwZT1cXFsnIl10ZXh0L2phdmFzY3JpcHRcXFsnIl0lMyI7aToyMjc7czoyMzoiZWNob1woXHMqaHRtbFwoXHMqYXJyYXkiO2k6MjI4O3M6MTU6IkBzeXN0ZW1cKFxzKiJcJCI7aToyMjk7czoyMToiZnVuY3Rpb25ccypDdXJsQXR0YWNrIjtpOjIzMDtzOjQ0OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9tPVwkMSI7aToyMzE7czo0NToiUmV3cml0ZVJ1bGVccypcXlwoXC5cKlwpXHMqaW5kZXhcLnBocFw/aWQ9XCQxIjtpOjIzMjtzOjE1OiJIVFRQX0FDQ0VQVF9BU0UiO2k6MjMzO3M6MjQ6IlwpXHMqe1xzKnBhc3N0aHJ1XChccypcJCI7aToyMzQ7czoxODoiUmVkaXJlY3RccypodHRwOi8vIjtpOjIzNTtzOjQyOiJSZXdyaXRlUnVsZVxzKlwoXC5cK1wpXHMqaW5kZXhcLnBocFw/cz1cJDAiO2k6MjM2O3M6MzE6ImV2YWxccypcKFxzKm1iX2NvbnZlcnRfZW5jb2RpbmciO2k6MjM3O3M6NDg6InBhcnNlX3F1ZXJ5X3N0cmluZ1woXHMqXCRFTlZ7XHMqWyciXVFVRVJZX1NUUklORyI7aToyMzg7czo0NDoiQFwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKTsiO2k6MjM5O3M6Mzk6IlthLXpBLVowLTlfXSs/XChccypbYS16QS1aMC05X10rPz1ccypcKSI7aToyNDA7czoxMjoiWyciXXJpbnlbJyJdIjtpOjI0MTtzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToyNDI7czoxNToiWyciXW9mbmlwaHBbJyJdIjtpOjI0MztzOjE3OiJbJyJdMzF0b3JfcnRzWyciXSI7aToyNDQ7czoxNDoiWyciXXRyZXNzYVsnIl0iO2k6MjQ1O3M6MTM6ImVkb2NlZF80NmVzYWIiO2k6MjQ2O3M6MTI6InNzZXJwbW9jbnV6ZyI7aToyNDc7czo5OiJldGFsZm5pemciO2k6MjQ4O3M6MTI6IlsnIl1yaW55WyciXSI7aToyNDk7czoxNDoiWyciXWZsZmdyelsnIl0iO2k6MjUwO3M6NzoiY3VjdmFzYiI7aToyNTE7czo5OiJmZ2VfZWJnMTMiO2k6MjUyO3M6MTQ6IlsnIl1uZmZyZWdbJyJdIjtpOjI1MztzOjEzOiJvbmZyNjRfcXJwYnFyIjtpOjI1NDtzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MjU1O3M6OToidG12YXN5bmdyIjtpOjI1NjtzOjQ4OiI8XD9ccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XHMqXCkiO2k6MjU3O3M6MjE6ImRhdGE6dGV4dC9odG1sO2Jhc2U2NCI7aToyNTg7czoxMzoibnVsbF9leHBsb2l0cyI7aToyNTk7czoxMzA6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXTtccypleGl0XChcKTsiO2k6MjYwO3M6NTY6Im1haWxcKFxzKlwkYXJyXFtbJyJddG9bJyJdXF1ccyosXHMqXCRhcnJcW1snIl1zdWJqWyciXVxdIjtpOjI2MTtzOjI0OiJ1bmxpbmtcKFxzKl9fRklMRV9fXHMqXCkiO2k6MjYyO3M6MjE6Ii1JL3Vzci9sb2NhbC9iYW5kbWFpbiI7aToyNjM7czo0MzoibmFtZT1bJyJddXBsb2FkZXJbJyJdXHMraWQ9WyciXXVwbG9hZGVyWyciXSI7aToyNjQ7czozMToiZWNob1xzKlsnIl08Yj5VcGxvYWQ8c3M+U3VjY2VzcyI7aToyNjU7czozNzoiaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqXCRsaW5rWyciXSI7aToyNjY7czo1MToidHlwZT1bJyJdc3VibWl0WyciXVxzKnZhbHVlPVsnIl1VcGxvYWQgZmlsZVsnIl1ccyo+IjtpOjI2NztzOjMwOiJlbHNlXHMqe1xzKmVjaG9ccypbJyJdZmFpbFsnIl0iO2k6MjY4O3M6NDQ6IlxzKj1ccyppbmlfZ2V0XChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnNbJyJdIjtpOjI2OTtzOjU3OiJAZXJyb3JfcmVwb3J0aW5nXChccyowXHMqXCk7XHMqaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCQiO2k6MjcwO3M6NTg6InJvdW5kXHMqXChccypcKFxzKlwkcGFja2V0c1xzKlwqXHMqNjVcKVxzKi9ccyoxMDI0XHMqLFxzKjIiO2k6MjcxO3M6MTI6Ilplcm9EYXlFeGlsZSI7aToyNzI7czoxMToiU19cXUBfXF5VXF4iO2k6MjczO3M6NTA6IjxpbnB1dFxzK3R5cGU9c3VibWl0XHMrdmFsdWU9VXBsb2FkXHMqLz5ccyo8L2Zvcm0+IjtpOjI3NDtzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjI3NTtzOjU0OiJzdWJzdHJcKFxzKlwkcmVzcG9uc2VccyosXHMqXCRpbmZvXFtccypbJyJdaGVhZGVyX3NpemUiO2k6Mjc2O3M6MTk6ImRpZVwoXHMqWyciXW5vIGN1cmwiO2k6Mjc3O3M6NzQ6IlwkcmV0ID0gXCR0aGlzLT5fZGItPnVwZGF0ZU9iamVjdFwoIFwkdGhpcy0+X3RibCwgXCR0aGlzLCBcJHRoaXMtPl90Ymxfa2V5IjtpOjI3ODtzOjQ0OiJvcGVuXHMqXChccypNWUZJTEVccyosXHMqWyciXVxzKj5ccyp0YXJcLnRtcCI7aToyNzk7czoxODoiLVwqLVxzKmNvbmZccyotXCotIjtpOjI4MDtzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjI4MTtzOjMzOiJ0b3VjaFxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MjgyO3M6Mjc6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcyI7aToyODM7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6Mjg0O3M6MTU6Ii90bXAvXC5JQ0UtdW5peCI7aToyODU7czoxNToiL3RtcC90bXAtc2VydmVyIjtpOjI4NjtzOjI2OiI9XHMqWyciXXNlbmRtYWlsXHMqLXRccyotZiI7aToyODc7czoyNDoicHJvY19jbG9zZVwoXHMqXCRwcm9jZXNzIjtpOjI4ODtzOjE2OiI7XHMqL2Jpbi9zaFxzKi1pIjtpOjI4OTtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aToyOTA7czo0MjoiQHVtYXNrXChccyowNzc3XHMqJlxzKn5ccypcJGZpbGVwZXJtaXNzaW9uIjtpOjI5MTtzOjUyOiJjaG1vZFwoXHMqXCRbXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1xzKixccyowNzU1IjtpOjI5MjtzOjUyOiJjaG1vZFwoXHMqXCRbXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1xzKixccyowNDA0IjtpOjI5MztzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aToyOTQ7czo5OiJMM1poY2k5M2QiO2k6Mjk1O3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6Mjk2O3M6ODQ6Ii9pbmRleFwucGhwXD9vcHRpb249Y29tX2NvbnRlbnQmdmlldz1hcnRpY2xlJmlkPVsnIl1cLlwkcG9zdFxbWyciXXswLDF9aWRbJyJdezAsMX1cXSI7aToyOTc7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjI5ODtzOjY0OiJpc3NldFwoXHMqXCRfQ09PS0lFXFtccyptZDVcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9IT1NUIjtpOjI5OTtzOjI3OiJzdHJsZW5cKFxzKlwkcGF0aFRvRG9yXHMqXCkiO2k6MzAwO3M6Mjk6ImZvcGVuXChccypbJyJdXC5cLi9cLmh0YWNjZXNzIjtpOjMwMTtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjMwMjtzOjc2OiJcYm1haWxcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqIjtpOjMwMztzOjQzOiJjb250ZW50PSJcZCs7VVJMPWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vIjtpOjMwNDtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MzA1O3M6MTk6Ii9pbnN0cnVrdHNpeWEtZGx5YS0iO2k6MzA2O3M6MTQ6Ii9cP2RvPW9zaGlia2EtIjtpOjMwNztzOjE3OiIvXD9kbz1rYWstdWRhbGl0LSI7aTozMDg7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjMwOTtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aTozMTA7czoyMDoiXCRfUkVRVUVTVFxbWyciXWxhbGEiO2k6MzExO3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MzEyO3M6NjM6Imh0dHA6Ly93d3dcLmdvb2dsZVwuY29tL3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5XC5bJyJdJmhsPVwkbGFuZyI7aTozMTM7czo0MzoiaHR0cDovL2dvXC5tYWlsXC5ydS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeSI7aTozMTQ7czo1MDoiaHR0cDovL3d3d1wuYmluZ1wuY29tL3NlYXJjaFw/cT1cJHF1ZXJ5JnBxPVwkcXVlcnkiO2k6MzE1O3M6Mzg6InNldFRpbWVvdXRcKFxzKlsnIl1sb2NhdGlvblwucmVwbGFjZVwoIjtpOjMxNjtzOjEwNjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aTozMTc7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmljbyI7aTozMTg7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmdpZiI7aTozMTk7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aTozMjA7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLnBuZyI7aTozMjE7czoxNDI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5wbmciO2k6MzIyO3M6MTQyOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuZ2lmIjtpOjMyMztzOjE0MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aTozMjQ7czoxMDY6InVubGlua1woXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl17MCwxfS9hc3NldHMvY2FjaGUvdGVtcC9GaWxlU2V0dGluZ3MiO2k6MzI1O3M6NDg6ImlmXChccypzdHJwb3NcKFxzKlwkdmFsdWVccyosXHMqXCRtYXNrXHMqXClccypcKSI7aTozMjY7czo4OiJhYmFrby9BTyI7aTozMjc7czo1NToiXCovXHMqKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aTozMjg7czozNDoiZ3JvdXBfY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSI7aTozMjk7czozNzoiY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSx1c2VybmFtZSI7aTozMzA7czoyMzoiXCt1bmlvblwrc2VsZWN0XCswLDAsMCwiO2k6MzMxO3M6OToic2V4c2V4c2V4IjtpOjMzMjtzOjM1OiJcJGJhc2VfZG9tYWluXHMqPVxzKmdldF9iYXNlX2RvbWFpbiI7aTozMzM7czozMToiIWVyZWdcKFsnIl1cXlwodW5zYWZlX3Jhd1wpXD9cJCI7aTozMzQ7czoxMDk6IlwkW2EtekEtWjAtOV9dKz9ccyo9XCRbYS16QS1aMC05X10rP1xzKlwoXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqXChbJyJdXHMqe1wkW2EtekEtWjAtOV9dKz8iO2k6MzM1O3M6MTk6ImxtcF9jbGllbnRcKHN0cmNvZGUiO2k6MzM2O3M6MTY6ImV2YWxcKFsnIl1ccyovXCoiO2k6MzM3O3M6MTU6ImV2YWxcKFsnIl1ccyovLyI7aTozMzg7czozNDoiXCRxdWVyeVxzKyxccytbJyJdZnJvbSUyMGpvc191c2VycyI7aTozMzk7czo3OToiXCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xdXFtcJFthLXpBLVowLTlfXSs/XFtcZCtcXVwuXCRbYS16QS1aMC05X10rPyI7aTozNDA7czoyOToiXClcKSxQSFBfVkVSU0lPTixtZDVfZmlsZVwoXCQiO2k6MzQxO3M6ODM6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jdXJsXHMrLU9ccytodHRwOi8vIjtpOjM0MjtzOjM2OiJjaG1vZFwoZGlybmFtZVwoX19GSUxFX19cKSxccyowNTExXCkiO2k6MzQzO3M6Mzk6ImxvY2F0aW9uXC5yZXBsYWNlXChcXFsnIl1cJHVybF9yZWRpcmVjdCI7aTozNDQ7czoyODoiTW90aGVyWyciXXNccytNYWlkZW5ccytOYW1lOiI7aTozNDU7czo5MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjM0NjtzOjc3OiJhcnJheV9tZXJnZVwoXCRleHRccyosXHMqYXJyYXlcKFsnIl13ZWJzdGF0WyciXSxbJyJdYXdzdGF0c1snIl0sWyciXXRlbXBvcmFyeSI7aTozNDc7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjM0ODtzOjIyOiJ4cnVtZXJfc3BhbV9saW5rc1wudHh0IjtpOjM0OTtzOjY6IlNFb0RPUiI7aTozNTA7czo3MDoiPFw/cGhwXHMrKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqWyciXS9ob21lLyI7aTozNTE7czoyMjoiLFsnIl08XD9waHBcXG5bJyJdXC5cJCI7aTozNTI7czo1MDoiPGlmcmFtZVxzK3NyYz1bJyJdaHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS9mb3Jtcy8iO2k6MzUzO3M6MzY6ImV4ZWNccyt7WyciXS9iaW4vc2hbJyJdfVxzK1snIl0tYmFzaCI7aTozNTQ7czo0NToiaWZcKGZpbGVfcHV0X2NvbnRlbnRzXChcJGluZGV4X3BhdGgsXHMqXCRjb2RlIjtpOjM1NTtzOjUzOiJcJFthLXpBLVowLTlfXSs/ID0gXCRbYS16QS1aMC05X10rP1woWyciXXswLDF9aHR0cDovLyI7aTozNTY7czo1MjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlxcWyciXVxcWyciXTt9aWZcKCFnZXRDb29raWVcKCI7aTozNTc7czoxMjoiI3TRikk30YbQr9CgIjtpOjM1ODtzOjMxOiJzZWxlY3QgbGFuZ3VhZ2VzX2lkLCBuYW1lLCBjb2RlIjtpOjM1OTtzOjQ0OiJ1cGRhdGUgY29uZmlndXJhdGlvbiBzZXQgY29uZmlndXJhdGlvbl92YWx1ZSI7aTozNjA7czo2NToic2VsZWN0IGNvbmZpZ3VyYXRpb25faWQsIGNvbmZpZ3VyYXRpb25fdGl0bGUsIGNvbmZpZ3VyYXRpb25fdmFsdWUiO2k6MzYxO3M6MzY6Ii9hZG1pbi9jb25maWd1cmF0aW9uXC5waHAvbG9naW5cLnBocCI7aTozNjI7czoxMDE6InN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlIjtpOjM2MztzOjEyOiJkbWxsZDBSaGRHRT0iO2k6MzY0O3M6ODE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTozNjU7czo3MToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6MzY2O3M6NzM6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKiwiO2k6MzY3O3M6NTI6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlsnIl0iO2k6MzY4O3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cWyI7aTozNjk7czo0NToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlxbIjtpOjM3MDtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTozNzE7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6MzcyO3M6NjU6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci90bXAvIjtpOjM3MztzOjI2OiJleGl0XChcKTpleGl0XChcKTpleGl0XChcKSI7aTozNzQ7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6Mzc1O3M6Mzg6IkBtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkdXNlcmZpbGVfdG1wIjtpOjM3NjtzOjIyOiJkaXNhYmxlX2Z1bmN0aW9ucz1ub25lIjtpOjM3NztzOjE1NToiXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xzKlxdXFtccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC4iO2k6Mzc4O3M6MjIyOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6Mzc5O3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cKCI7aTozODA7czo0MjoiPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXXswLDF9XCRhWyciXXswLDF9IjtpOjM4MTtzOjM3OiJpZlxzKlwoXHMqaW5pX2dldFwoWyciXXswLDF9c2FmZV9tb2RlIjtpOjM4MjtzOjk6IlwkYlwoWyciXSI7aTozODM7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aTozODQ7czozNjoiWC1NYWlsZXI6XHMqTWljcm9zb2Z0IE9mZmljZSBPdXRsb29rIjtpOjM4NTtzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozODY7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTozODc7czo2NDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKCI7aTozODg7czoxMzoiQGV4dHJhY3RccypcJCI7aTozODk7czoxMzoiQGV4dHJhY3RccypcKCI7aTozOTA7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6MzkxO3M6ODE6Im1haWxcKFwkX1BPU1RcW1snIl17MCwxfWVtYWlsWyciXXswLDF9XF0sXHMqXCRfUE9TVFxbWyciXXswLDF9c3ViamVjdFsnIl17MCwxfVxdLCI7aTozOTI7czo4NDoibW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtbJyJddG1wX25hbWVbJyJdXF1ccyosIjtpOjM5MztzOjQ1OiJNb3ppbGxhLzVcLjBccypcKGNvbXBhdGlibGU7XHMqR29vZ2xlYm90LzJcLjEiO2k6Mzk0O3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6Mzk1O3M6MTc6IjwvYm9keT5ccyo8c2NyaXB0IjtpOjM5NjtzOjQzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1wcmVnX3JlcGxhY2VbJyJdIjtpOjM5NztzOjM3OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1hc3NlcnRbJyJdIjtpOjM5ODtzOjQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1jcmVhdGVfZnVuY3Rpb25bJyJdIjtpOjM5OTtzOjQ0OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1iYXNlNjRfZGVjb2RlWyciXSI7aTo0MDA7czozNToiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdZXZhbFsnIl0iO2k6NDAxO3M6Mjg6IkNyZWRpdFxzKkNhcmRccypWZXJpZmljYXRpb24iO2k6NDAyO3M6NjY6IlJld3JpdGVDb25kXHMqJXtIVFRQOkFjY2VwdC1MYW5ndWFnZX1ccypcKHJ1XHxydS1ydVx8dWtcKVxzKlxbTkNcXSI7aTo0MDM7czo0MjoiUmV3cml0ZUNvbmRccyole0hUVFA6eC1vcGVyYW1pbmktcGhvbmUtdWF9IjtpOjQwNDtzOjM0OiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LXdhcC1wcm9maWxlIjtpOjQwNTtzOjIyOiJldmFsXHMqXChccypnZXRfb3B0aW9uIjtpOjQwNjtzOjI5OiJlY2hvXHMrWyciXXswLDF9Z29vZFsnIl17MCwxfSI7aTo0MDc7czo1MToiQ1VSTE9QVF9SRUZFUkVSLFxzKlsnIl17MCwxfWh0dHBzOi8vd3d3XC5nb29nbGVcLmNvIjtpOjQwODtzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6NDA5O3M6NjQ6Ij1ccypcJEdMT0JBTFNcW1xzKlsnIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdXHMqXF0iO2k6NDEwO3M6NjQ6ImVjaG9ccytzdHJpcHNsYXNoZXNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDExO3M6MjI6IjxoMT5Mb2FkaW5nXC5cLlwuPC9oMT4iO2k6NDEyO3M6MTI6InBocGluZm9cKFwpOyI7aTo0MTM7czozMTA6IihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDUpXHMqXChccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1KVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSkiO2k6NDE0O3M6MTU6IlsnIl0vXC5cKi9lWyciXSI7aTo0MTU7czoyODoiZWNob1xzKlwoKlxzKlsnIl1OTyBGSUxFWyciXSI7aTo0MTY7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoKlxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6NDE3O3M6MjM6ImNvcHlccypcKFxzKlsnIl1odHRwOi8vIjtpOjQxODtzOjgyOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9UmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKlVSTD1odHRwOi8vIjtpOjQxOTtzOjgxOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9cmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKnVybD08XD9waHAiO2k6NDIwO3M6MTA6IlsnIl1hSFIwY0QiO2k6NDIxO3M6Njc6InN0cmNoclxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDIyO3M6Njc6InN0cnN0clxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDIzO3M6Njc6InN0cnBvc1xzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDI0O3M6MzM6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aTo0MjU7czoxMDoicGNudGxfZXhlYyI7aTo0MjY7czo2OToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKCpbJyJdY2RccysvdG1wIjtpOjQyNztzOjI3OiJcJE9PTy4rPz1ccyp1cmxkZWNvZGVccypcKCoiO2k6NDI4O3M6MTI6InJtXHMrLWZccystciI7aTo0Mjk7czoxMjoicm1ccystclxzKy1mIjtpOjQzMDtzOjg6InJtXHMrLWZyIjtpOjQzMTtzOjg6InJtXHMrLXJmIjtpOjQzMjtzOjY5OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQCp1cmxlbmNvZGUiO2k6NDMzO3M6NjM6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdaW1hZ2VzLyI7aTo0MzQ7czo4OToiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDM1O3M6NTk6ImJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQzNjtzOjUxOiJkb2N1bWVudFwud3JpdGVccypcKFxzKnVuZXNjYXBlXHMqXChccypbJyJdezAsMX0lM0MiO2k6NDM3O3M6ODoiLy9OT25hTUUiO2k6NDM4O3M6ODoibHNccystbGEiO2k6NDM5O3M6Mzc6ImluaV9zZXRcKFxzKlsnIl17MCwxfW1hZ2ljX3F1b3Rlc19ncGMiO2k6NDQwO3M6Mjg6ImFuZHJvaWRcfGF2YW50Z29cfGJsYWNrYmVycnkiO2k6NDQxO3M6NDE6ImZpbmRccysvXHMrLXR5cGVccytmXHMrLW5hbWVccytcLmh0cGFzc3dkIjtpOjQ0MjtzOjM3OiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTAyMDAwIjtpOjQ0MztzOjM3OiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjQ0NDtzOjU6InhDZWR6IjtpOjQ0NTtzOjk6IlwkcGFzc191cCI7aTo0NDY7czo1OiJPbmV0NyI7aTo0NDc7czo1OiJKVGVybSI7aTo0NDg7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjQ0OTtzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6NDUwO3M6MTU6IjEwOVwuMjM4XC4yNDJcLiI7aTo0NTE7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0NTI7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdSFRUUF9SRUZFUkVSWyciXVxzKlxdXHMqLFxzKlsnIl10cnVzdGxpbmtcLnJ1Ijt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxMTM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjQ6IlwkeDEgPSBcJHRoaXMtPncgLSBcJHgxOyI7aToxODtzOjMxOiJhc29ydFwoXCRDYWNoZURpck9sZEZpbGVzQWdlXCk7IjtpOjE5O3M6MTM6IlwoJ3I1N3NoZWxsJywiO2k6MjA7czoyNToiZXZhbFwoImxpc3RlbmVyID0gIlwrbGlzdCI7aToyMTtzOjg6ImV2YWxcKFwpIjtpOjIyO3M6MzM6InByZWdfcmVwbGFjZV9jYWxsYmFja1woJy9cXHtcKGltYSI7aToyMztzOjIxOiJldmFsIFwoX2N0TWVudUluaXRTdHIiO2k6MjQ7czoyOToiYmFzZTY0X2RlY29kZVwoXCRhY2NvdW50S2V5XCkiO2k6MjU7czozOToiYmFzZTY0X2RlY29kZVwoXCRkYXRhXClcKTsgXCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY1OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpOyBpZlwoQ2hlY2tTZXJpYWxpemVkRCI7aToyODtzOjYzOiJwY250bF9leGVjJyA9PiBBcnJheVwoQXJyYXlcKDFcKSwgXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6Njg6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTsgaWYgXChzdHJsZW5cKFwkIjtpOjMxO3M6NTE6ImV2YWxcKCdcJGhleGR0aW1lID0gIicgXC4gXCRoZXhkdGltZSBcLiAnIjsnXCk7IFwkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czo0MToiaWZcKDFcKSB7IFwkdl9ob3VyID0gXChcJHBfaGVhZGVyXFsnbXRpbWUiO2k6MzU7czo3MDoiZG9jdW1lbnRcLndyaXRlXCh1bmVzY2FwZVwoIiUzQ3NjcmlwdCUyMHNyYz0lMjJodHRwIiBcKyBcKFwoImh0dHBzOiIgPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNToiJ2ZpbGVuYW1lJ1wpLCBcKCdyNTdzaGVsbCI7aTozOTtzOjQzOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnIiBcLiBcJGVyck1zZyBcLiAiJ1wpIjtpOjQwO3M6NDI6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKFxcIkVycm9yIHdoZW4gbG9hZGluZyI7aTo0MTtzOjQzOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnIlwuSlRleHQ6Ol9cKCdWQUxJRF9FIjtpOjQyO3M6ODoiZXZhbFwoXCkiO2k6NDM7czo4OiInc3lzdGVtJyI7aTo0NDtzOjY6IidldmFsJyI7aTo0NTtzOjY6IiJldmFsIiI7aTo0NjtzOjc6Il9zeXN0ZW0iO2k6NDc7czo5OiJzYXZlMmNvcHkiO2k6NDg7czoxMDoiZmlsZXN5c3RlbSI7aTo0OTtzOjg6InNlbmRtYWlsIjtpOjUwO3M6ODoiY2FuQ2htb2QiO2k6NTE7czoxMzoiL2V0Yy9wYXNzd2RcKSI7aTo1MjtzOjI0OiJ1ZHA6Ly8nXC5zZWxmOjpcJF9jX2FkZHIiO2k6NTM7czozNDoiZWRvY2VkXzQ2ZXNhYlwoJydcfCJcKVxcXCknLCAncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyMToid2l0aCAwLzAvMCBpZiBcKDFcKSB7IjtpOjU4O3M6NDg6IlwkeDIgPSBcJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo1OTtzOjk6InNwZWNpYWxpcyI7aTo2MDtzOjg6ImNvcHlcKFwpIjtpOjYxO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjI7czo3OiItPmNobW9kIjtpOjYzO3M6NzoiX21haWxcKCI7aTo2NDtzOjc6Il9jb3B5XCgiO2k6NjU7czo0Njoic3RycG9zXChcJF9TRVJWRVJcWydIVFRQX1VTRVJfQUdFTlQnXF0sICdEcnVwYSI7aTo2NjtzOjQ1OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwgJ01TSUUiO2k6Njc7czo0NToic3RycG9zXChcJF9TRVJWRVJcWyJIVFRQX1VTRVJfQUdFTlQiXF0sICdNU0lFIjtpOjY4O3M6MTc6ImV2YWwgXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo1MjoiXCR4MSA9IFwkbWluX3g7IFwkeDIgPSBcJG1heF94OyBcJHkxID0gXCRtaW5feTsgXCR5MiI7aTo3MjtzOjU1OiJcJGN0bVxbJ2EnXF1cKVwpIHsgXCR4ID0gXCR4IFwqIFwkdGhpcy0+azsgXCR5ID0gXChcJHRoIjtpOjczO3M6NjA6IlsnIl17MCwxfWNyZWF0ZV9mdW5jdGlvblsnIl17MCwxfSwgWyciXXswLDF9Z2V0X3Jlc291cmNlX3R5cCI7aTo3NDtzOjQ5OiJbJyJdezAsMX1jcmVhdGVfZnVuY3Rpb25bJyJdezAsMX0sIFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njk6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSwgWyciXXswLDF9THlueCI7aTo3NjtzOjY4OiJzdHJzdHJcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF0sIFsnIl17MCwxfU1TSSI7aTo3NztzOjI1OiJzb3J0XChcJERpc3RyaWJ1dGlvblxbXCRrIjtpOjc4O3M6MjU6InNvcnRcKGZ1bmN0aW9uXChhLGJcKXtyZXQiO2k6Nzk7czoyNToiaHR0cDovL3d3d1wuZmFjZWJvb2tcLmNvbSI7aTo4MDtzOjI1OiJodHRwOi8vbWFwc1wuZ29vZ2xlXC5jb20vIjtpOjgxO3M6NTI6InVkcDovLydcLnNlbGY6OlwkY19hZGRyLCA4MCwgXCRlcnJubywgXCRlcnJzdHIsIDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NzoibW92ZV91cGxvYWRlZF9maWxlXCggXCRfRklMRVNcWyd1cGxvYWRlZF9wYWNrYWdlJ1xdXFsndG1wX25hbWUnXF0sIFwkbW9zQ29uZmkiO2k6ODY7czoxMjoiZmFsc2VcKSBcKTsjIjtpOjg3O3M6MTU6Im5jeV9uYW1lYCcgXCk7IyI7aTo4ODtzOjQ3OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwgJ01hYyBPUyI7aTo4OTtzOjIwOiIvL25vbmFtZTogJzxcPz1DVXRpbCI7aTo5MDtzOjUwOiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nL2JpdHJpeCI7aTo5MTtzOjI1OiJcJF9TRVJWRVIgXFsiUkVNT1RFX0FERFIiIjtpOjkyO3M6MTc6ImFIUjBjRG92TDJOeWJETXVaIjtpOjkzO3M6NTU6IkpSZXNwb25zZTo6c2V0Qm9keVwocHJlZ19yZXBsYWNlXChcJHBhdHRlcm5zLCBcJHJlcGxhY2UiO2k6OTQ7czo0MDoiXFx4MWZcXHg4YlxceDA4XFx4MDBcXHgwMFxceDAwXFx4MDBcXHgwMCI7aTo5NTtzOjQwOiJcXHg1MFxceDRiXFx4MDVcXHgwNlxceDAwXFx4MDBcXHgwMFxceDAwIjtpOjk2O3M6NDY6IlxceDA5XFx4MEFcXHgwQlxceDBDXFx4MERcXHgyMFxceDJGXFx4M0VcXVxbXF4iO2k6OTc7czo0MDoiXFx4ODlcXHg1MFxceDRFXFx4NDdcXHgwRFxceDBBXFx4MUFcXHgwQSI7aTo5ODtzOjEwOiJcKTsjaScsICcmIjtpOjk5O3M6MTc6IlwpOyNtaXMnLCAnICcsIFwkIjtpOjEwMDtzOjIwOiJcKTsjaScsIFwkZGF0YSwgXCRtYSI7aToxMDE7czozNToiXCRmdW5jXCggXCRwYXJhbXNcW1wkdHlwZVxdLT5wYXJhbXMiO2k6MTAyO3M6NDA6IlxceDFmXFx4OGJcXHgwOFxceDAwXFx4MDBcXHgwMFxceDAwXFx4MDAiO2k6MTAzO3M6NDU6IlxceDAwXFx4MDFcXHgwMlxceDAzXFx4MDRcXHgwNVxceDA2XFx4MDdcXHgwOCI7aToxMDQ7czo0MDoiXFx4MjFcXHgyM1xceDI0XFx4MjVcXHgyNlxceDI3XFx4MmFcXHgyYiI7aToxMDU7czozNToiXFx4ODNcXHg4QlxceDhEXFx4OUJcXHg5RVxceDlGXFx4QTEiO2k6MTA2O3M6MzA6IlxceDA5XFx4MEFcXHgwQlxceDBDXFx4MERcXHgyMCI7aToxMDc7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwODtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA5O3M6MjI6IlwkZGVjb2RlZnVuY1woIFwkZFxbXCQiO2k6MTEwO3M6MTc6Il9cLlwrX2FiYnJldmlhdGlvIjtpOjExMTtzOjQ4OiJzdHJlYW1fc29ja2V0X2NsaWVudFwoICd0Y3A6Ly8nIFwuIFwkcHJveHktPmhvc3QiO2k6MTEyO3M6Mjc6ImV2YWxcKGZ1bmN0aW9uXChwLGEsYyxrLGUsZCI7fQ=="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlsnIlwoXCRdIjtpOjEyMjtzOjExOiJcYm1haWxccypcKCI7aToxMjM7czo0NjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccypbJyJdezAsMX1waHA6Ly9pbnB1dCI7aToxMjQ7czoxMTg6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1Db250ZW50LXR5cGVbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfXRleHQvaHRtbDtccypjaGFyc2V0PXdpbmRvd3MtMTI1MVsnIl17MCwxfT48Ym9keT4iO2k6MTI1O3M6NjI6Ij1ccypkb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoXHMqWyciXXswLDF9c2NyaXB0WyciXXswLDF9XHMqXCk7IjtpOjEyNjtzOjY5OiJkb2N1bWVudFwuYm9keVwuaW5zZXJ0QmVmb3JlXChkaXYsXHMqZG9jdW1lbnRcLmJvZHlcLmNoaWxkcmVuXFswXF1cKTsiO2k6MTI3O3M6Nzc6IjxzY3JpcHRccyt0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vW2EtekEtWjAtOV9dKz9cLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YTo0NDp7aTowO3M6MjU6InNsaW5rc1wuc3UvZ2V0X2xpbmtzXC5waHAiO2k6MTtzOjEzOiJNTF9sY29kZVwucGhwIjtpOjI7czoxMzoiTUxfJWNvZGVcLnBocCI7aTozO3M6MTk6ImNvZGVzXC5tYWlubGlua1wucnUiO2k6NDtzOjE5OiJfX2xpbmtmZWVkX3JvYm90c19fIjtpOjU7czoxMzoiTElOS0ZFRURfVVNFUiI7aTo2O3M6MTQ6IkxpbmtmZWVkQ2xpZW50IjtpOjc7czoxODoiX19zYXBlX2RlbGltaXRlcl9fIjtpOjg7czoyOToiZGlzcGVuc2VyXC5hcnRpY2xlc1wuc2FwZVwucnUiO2k6OTtzOjExOiJMRU5LX2NsaWVudCI7aToxMDtzOjExOiJTQVBFX2NsaWVudCI7aToxMTtzOjE2OiJfX2xpbmtmZWVkX2VuZF9fIjtpOjEyO3M6MTY6IlNMQXJ0aWNsZXNDbGllbnQiO2k6MTM7czoxNzoiLT5HZXRMaW5rc1xzKlwoXCkiO2k6MTQ7czoxNzoiZGJcLnRydXN0bGlua1wucnUiO2k6MTU7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxNjtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE3O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MTg7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MTk7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIwO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjE7czoxNjY6Imlzc2V0XHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjI7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCgqXHMqXCRsaWJfcGF0aCI7aToyMztzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoKlxzKiI7aToyNDtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKSpccyo7XHMqXD8+IjtpOjI1O3M6NzoibGV2aXRyYSI7aToyNjtzOjEwOiJkYXBveGV0aW5lIjtpOjI3O3M6NjoidmlhZ3JhIjtpOjI4O3M6NjoiY2lhbGlzIjtpOjI5O3M6ODoicHJvdmlnaWwiO2k6MzA7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMTtzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzI7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjMzO3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzQ7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM1O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM2O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM3O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTozODtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTozOTtzOjEwOiJfX0xJTktfXzxhIjtpOjQwO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MTtzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQyO3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDM7czoxNToiX19MSU5LX19fX0VORF9fIjt9"));
$g_JSVirSig = unserialize(base64_decode("YToxMTg6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czo0MToiZj0nZidcKydyJ1wrJ28nXCsnbSdcKydDaCdcKydhckMnXCsnb2RlJzsiO2k6NTtzOjIyOiJcLnByb3RvdHlwZVwuYX1jYXRjaFwoIjtpOjY7czozNzoidHJ5e0Jvb2xlYW5cKFwpXC5wcm90b3R5cGVcLnF9Y2F0Y2hcKCI7aTo3O3M6MzQ6ImlmXChSZWZcLmluZGV4T2ZcKCdcLmdvb2dsZVwuJ1wpIT0iO2k6ODtzOjg2OiJpbmRleE9mXHxpZlx8cmNcfGxlbmd0aFx8bXNuXHx5YWhvb1x8cmVmZXJyZXJcfGFsdGF2aXN0YVx8b2dvXHxiaVx8aHBcfHZhclx8YW9sXHxxdWVyeSI7aTo5O3M6NTQ6IkFycmF5XC5wcm90b3R5cGVcLnNsaWNlXC5jYWxsXChhcmd1bWVudHNcKVwuam9pblwoIiJcKSI7aToxMDtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjExO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTI7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTM7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxNDtzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNTtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE2O3M6MTc6IjwvaHRtbD5ccyo8c2NyaXB0IjtpOjE3O3M6MTc6IjwvaHRtbD5ccyo8aWZyYW1lIjtpOjE4O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxOTtzOjc6IlxceDY1QXQiO2k6MjA7czo5OiJcXHg2MXJDb2QiO2k6MjE7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToyMjtzOjExOiI9ImV2IlwrImFsIiI7aToyMztzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjQ7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjI1O3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjI2O3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI3O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI4O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6Mjk7czo5OiJ2YXJccytfMHgiO2k6MzA7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6MzE7czo3OiJwaW5nbm93IjtpOjMyO3M6ODoic2VyY2hib3QiO2k6MzM7czoxMDoia20wYWU5Z3I2bSI7aTozNDtzOjY6ImMzMjg0ZCI7aTozNTtzOjg6IlxceDY4YXJDIjtpOjM2O3M6ODoiXFx4NmRDaGEiO2k6Mzc7czo3OiJcXHg2ZmRlIjtpOjM4O3M6NzoiXFx4NmZkZSI7aTozOTtzOjg6IlxceDQzb2RlIjtpOjQwO3M6NzoiXFx4NzJvbSI7aTo0MTtzOjc6IlxceDQzaGEiO2k6NDI7czo3OiJcXHg3MkNvIjtpOjQzO3M6ODoiXFx4NDNvZGUiO2k6NDQ7czoxMDoiXC5keW5kbnNcLiI7aTo0NTtzOjk6IlwuZHluZG5zLSI7aTo0NjtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ3O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0ODtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDk7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NTA7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NTE7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjUyO3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTM7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjU0O3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1NTtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjU2O3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NztzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU4O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1OTtzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo2MDtzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo2MTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjYyO3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYzO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjY0O3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjU7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjY7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NztzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2ODtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2OTtzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo3MDtzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjcxO3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjcyO3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MztzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3NDtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjc1O3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3NjtzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6Nzc7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3ODtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3OTtzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjgwO3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo4MTtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6ODI7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MztzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjg0O3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjg1O3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4NjtzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg3O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg4O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg5O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo5MDtzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo5MTtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo5MjtzOjU1OiJzdHJpcG9zXHMqXChccypmX2hheXN0YWNrXHMqLFxzKmZfbmVlZGxlXHMqLFxzKmZfb2Zmc2V0IjtpOjkzO3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjk0O3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6OTU7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5NjtzOjE3OiJzZXhmcm9taW5kaWFcLmNvbSI7aTo5NztzOjExOiJmaWxla3hcLmNvbSI7aTo5ODtzOjEzOiJzdHVtbWFublwubmV0IjtpOjk5O3M6MTQ6Imh0dHA6Ly94enhcLnBtIjtpOjEwMDtzOjE4OiJcLmhvcHRvXC5tZS9qcXVlcnkiO2k6MTAxO3M6MTE6Im1vYmktZ29cLmluIjtpOjEwMjtzOjE4OiJiYW5rb2ZhbWVyaWNhXC5jb20iO2k6MTAzO3M6MTY6Im15ZmlsZXN0b3JlXC5jb20iO2k6MTA0O3M6MTc6ImZpbGVzdG9yZTcyXC5pbmZvIjtpOjEwNTtzOjE2OiJmaWxlMnN0b3JlXC5pbmZvIjtpOjEwNjtzOjE1OiJ1cmwyc2hvcnRcLmluZm8iO2k6MTA3O3M6MTg6ImZpbGVzdG9yZTEyM1wuaW5mbyI7aToxMDg7czoxMjoidXJsMTIzXC5pbmZvIjtpOjEwOTtzOjE0OiJkb2xsYXJhZGVcLmNvbSI7aToxMTA7czoxMToic2VjY2xpa1wucnUiO2k6MTExO3M6MTE6Im1vYnktYWFcLnJ1IjtpOjExMjtzOjEyOiJzZXJ2bG9hZFwucnUiO2k6MTEzO3M6NDg6InN0cmlwb3NcKG5hdmlnYXRvclwudXNlckFnZW50XHMqLFxzKmxpc3RfZGF0YVxbaSI7aToxMTQ7czoyNjoiaWZccypcKCFzZWVfdXNlcl9hZ2VudFwoXCkiO2k6MTE1O3M6NDY6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypbJyJdWyciXTt9aWZcKCFnZXRDb29raWUiO2k6MTE2O3M6NzA6IjxzY3JpcHRccyp0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzKnNyYz1bJyJdezAsMX1mdHA6Ly8iO2k6MTE3O3M6NDg6ImlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXChbJyJdezAsMX1zYWJyaSI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTozODp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjQwOiJwb3NpdGlvbjphYnNvbHV0ZTtsZWZ0Oi1cZCtweDt0b3A6LVxkK3B4IjtpOjU7czozMDoiY29tcGFsXHxlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyMjoiZWxhaW5lXHxmZW5uZWNcfGhpcHRvcCI7aTo3O3M6Mjk6IlwoZnVuY3Rpb25cKGEsYlwpe2lmXCgvXChhbmRyIjtpOjg7czozNzoiZG9jdW1lbnRcLndyaXRlXChbJyJdPHNjclsnIl1cK1snIl1pcCI7aTo5O3M6NDk6ImlmcmFtZVwuc3R5bGVcLndpZHRoXHMqPVxzKlsnIl17MCwxfTBweFsnIl17MCwxfTsiO2k6MTA7czoxMDE6ImRvY3VtZW50XC5jYXB0aW9uPW51bGw7d2luZG93XC5hZGRFdmVudFwoWyciXXswLDF9bG9hZFsnIl17MCwxfSxmdW5jdGlvblwoXCl7dmFyIGNhcHRpb249bmV3IEpDYXB0aW9uIjtpOjExO3M6MTI6Imh0dHA6Ly9mdHBcLiI7aToxMjtzOjc6Im5ublwucG0iO2k6MTM7czo3OiJubm1cLnBtIjtpOjE0O3M6MTY6InRvcC13ZWJwaWxsXC5jb20iO2k6MTU7czoxOToiZ29vZHBpbGxzZXJ2aWNlXC5ydSI7aToxNjtzOjc4OiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9aHR0cDovL2dvb1wuZ2wiO2k6MTc7czo2NzoiIlxzKlwrXHMqbmV3IERhdGVcKFwpXC5nZXRUaW1lXChcKTtccypkb2N1bWVudFwuYm9keVwuYXBwZW5kQ2hpbGRcKCI7aToxODtzOjM0OiJcLmluZGV4T2ZcKFxzKlsnIl1JQnJvd3NlWyciXVxzKlwpIjtpOjE5O3M6ODc6Ij1kb2N1bWVudFwucmVmZXJyZXI7XHMqW2EtekEtWjAtOV9dKz89dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXSs/XHMqXCk7XHMqdmFyXHMrRXhwRGF0ZSI7aToyMDtzOjc0OiI8IS0tXHMqW2EtekEtWjAtOV9dKz9ccyotLT48c2NyaXB0Lis/PC9zY3JpcHQ+PCEtLS9ccypbYS16QS1aMC05X10rP1xzKi0tPiI7aToyMTtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToyMjtzOjcyOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rP1wrWyciXXRlWyciXVxzKlxdXChTdHJpbmciO2k6MjM7czo4MToic2V0Q29va2llXChccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1wpIjtpOjI0O3M6Mjk6IlxdXChccyp2XCtcK1xzKlwpLTFccypcKVxzKlwpIjtpOjI1O3M6NDQ6ImRvY3VtZW50XFtccypfMHhbYS16QS1aMC05X10rP1xbXGQrXF1ccypcXVwoIjtpOjI2O3M6Mjg6Ii9nLFsnIl1bJyJdXClcLnNwbGl0XChbJyJdXF0iO2k6Mjc7czo0Mzoid2luZG93XC5sb2NhdGlvbj1ifVwpXChuYXZpZ2F0b3JcLnVzZXJBZ2VudCI7aToyODtzOjIyOiJbJyJdcmVwbGFjZVsnIl1cXVwoL1xbIjtpOjI5O3M6MTI3OiJpXFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dKz9cW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdXChcZCssXGQrXClcKVwpe3dpbmRvd1xbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF09bG9jIjtpOjMwO3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MzE7czo1MToiWyciXVxdXChbYS16QS1aMC05X10rP1wrXCtcKS1cZCtcKX1cKEZ1bmN0aW9uXChbJyJdIjtpOjMyO3M6NjU6Ijt3aGlsZVwoW2EtekEtWjAtOV9dKz88XGQrXClkb2N1bWVudFxbLis/XF1cKFN0cmluZ1xbWyciXWZyb21DaGFyIjtpOjMzO3M6MTA5OiJpZlxzKlwoW2EtekEtWjAtOV9dKz9cLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjM0O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzU7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzY7czoyNzoiY29va2llXHxzdWJzdHJpbmdcfHlhXHxodHRwIjtpOjM3O3M6MTM3OiJmYWxzZX07W2EtekEtWjAtOV9dKz89W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKVx8W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKTtbYS16QS1aMC05X10rP1x8PVthLXpBLVowLTlfXSs/OyI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YTo2MDp7aTowO3M6MTM6IkludmFsaWRccytUVk4iO2k6MTtzOjExOiJJbnZhbGlkIFJWTiI7aToyO3M6NDA6ImRlZmF1bHRTdGF0dXNccyo9XHMqWyciXUludGVybmV0IEJhbmtpbmciO2k6MztzOjI4OiI8dGl0bGU+XHMqQ2FwaXRlY1xzK0ludGVybmV0IjtpOjQ7czoyNzoiPHRpdGxlPlxzKkludmVzdGVjXHMrT25saW5lIjtpOjU7czozOToiaW50ZXJuZXRccytQSU5ccytudW1iZXJccytpc1xzK3JlcXVpcmVkIjtpOjY7czoxMToiPHRpdGxlPlNhcnMiO2k6NztzOjEzOiI8YnI+QVRNXHMrUElOIjtpOjg7czoxODoiQ29uZmlybWF0aW9uXHMrT1RQIjtpOjk7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMDtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTE7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMjtzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjEzO3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTQ7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNTtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE2O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE3O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxODtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MTk7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIwO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMTtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIyO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjM7czoxMToiQkFOQ09MT01CSUEiO2k6MjQ7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNTtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6MjY7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI3O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjg7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aToyOTtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMwO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMxO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMjtzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjMzO3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNDtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzU7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM2O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozNztzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozODtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjM5O3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDA7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDE7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MjtzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0MztzOjE4OiJcLmh0bWxcP2NtZD1sb2dpbj0iO2k6NDQ7czoxODoiV2VibWFpbFxzKjwvdGl0bGU+IjtpOjQ1O3M6MjM6Ijx0aXRsZT5ccypVUENccytXZWJtYWlsIjtpOjQ2O3M6MTc6IlwucGhwXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTc6IlwuaHRtXD9jbWQ9bG9naW49IjtpOjQ4O3M6MjM6Ilwuc3dlZGJhbmtcLnNlL21kcGF5YWNzIjtpOjQ5O3M6MjQ6IlwuXHMqXCRfUE9TVFxbXHMqWyciXWN2diI7aTo1MDtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1MTtzOjEwOiJCWS1TUDFOMFpBIjtpOjUyO3M6NDU6IlNlY3VyaXR5XHMrcXVlc3Rpb25ccys6XHMrWyciXVxzKlwuXHMqXCRfUE9TVCI7aTo1MztzOjQwOiJpZlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkc2NhbVxzKlwuXHMqXCRpIjtpOjU0O3M6MjA6Ijx0aXRsZT5ccypCZXN0LnRpZ2VuIjtpOjU1O3M6MjA6Ijx0aXRsZT5ccypMQU5ERVNCQU5LIjtpOjU2O3M6NTI6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwucGhwXD9jbWQ9bG9naW4iO2k6NTc7czo1NDoid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaW5kZXhcZCsqXC5odG1sKlw/Y21kPWxvZ2luIjtpOjU4O3M6MjU6Ijx0aXRsZT5ccypNYWlsXHMqPC90aXRsZT4iO2k6NTk7czoyODoiU2llXHMrSWhyXHMrS29udG9ccyo8L3RpdGxlPiI7fQ=="));

$g_DBShe  = array_map('strtolower', $g_DBShe);
$gX_DBShe = array_map('strtolower', $gX_DBShe);

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

define('AI_VERSION', '20150718');

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
	$stat = '';
	if ($elapsed_time >= 1)
	{
		$elapsed_seconds = round($elapsed_time, 0);
		$fs = floor($num / $elapsed_seconds);
		$left_files = $total_files - $num;
		if ($fs > 0) 
		{
		   $left_time = ($left_files / $fs); //ceil($left_files / $fs);
		   $stat = '. [Avg: ' . round($fs,2) . ' files/s' . ($left_time > 0  ? ' Left: ' . seconds2Human($left_time) : '') . '] [Mlw:' . (count($g_CriticalPHP) + count($g_Base64))  . '|' . (count($g_CriticalJS) + count($g_Iframer) + count($g_Phishing)) . ']';
        }
	}

	$l_FN = substr($par_File, -60);

	$text = "[$l_FN] $num of {$total_files}" . $stat;
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
		'one-pass',
		'quarantine'
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

	if (
		(isset($options['report']) AND ($report = $options['report']) !== false)
		OR (isset($options['r']) AND ($report = $options['r']) !== false)
	)
	{
		define('REPORT', $report);
	}

	defined('REPORT') OR define('REPORT', 'AI-BOLIT-REPORT-' . date('d-m-Y_H-i') . '-' . rand(1, 999999) . '.html');

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
	
	
	$l_SpecifiedPath = false;
	if (
		(isset($options['path']) AND !empty($options['path']) AND ($path = $options['path']) !== false)
		OR (isset($options['p']) AND !empty($options['p']) AND ($path = $options['p']) !== false)
	)
	{
		$defaults['path'] = $path;
		$l_SpecifiedPath = true;
	}

	define('ONE_PASS', isset($options['one-pass']));
    
} else {
   define('AI_EXPERT', AI_EXPERT_MODE); 
   define('ONE_PASS', true);
}

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
$l_Template = str_replace("@@MODE@@", AI_EXPERT, $l_Template);

if (AI_EXPERT == 0) {
   $l_Result .= '<div class="rep">' . AI_STR_057 . '</div>'; 
} else {
}

$l_Template = str_replace('@@HEAD_TITLE@@', AI_STR_051 .  realpath('.'), $l_Template);

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
  global $g_Structure;
  
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
        $l_WithMarker = preg_replace('|@AI_MARKER@|smi', '<span class="marker">&nbsp;</span>', $par_Details[$i]);
        $l_WithMarker = preg_replace('|@AI_LINE1@|smi', '<span class="line_no">', $l_WithMarker);
        $l_WithMarker = preg_replace('|@AI_LINE2@|smi', '</span>', $l_WithMarker);
		
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
		$l_Result .= '<td><div class="it"><a class="it" target="_blank" href="'. $defaults['site_url'] . 'ai-bolit.php?fn=' .
	              $g_Structure['n'][$l_Pos] . '&ph=' . realCRC(PASS) . '&c=' . $g_Structure['crc'][$l_Pos] . '">' . $g_Structure['n'][$l_Pos] . '</a></div>' . $l_Body . '</td>';
	 } else {
		$l_Result .= '<td><div class="it">' . $g_Structure['n'][$par_List[$i]] . '</div></td>';
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
  global $g_Structure;
  
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
        $l_Body = preg_replace('|(L\d+).+@AI_MARKER@|smi', '$1: ...', $par_Details[$i]);
        $l_Body = preg_replace('/[^\x21-\x7F]/', '.', $l_Body);
        $l_Body = str_replace($l_Src, $l_Dst, $l_Body);

     } else {
        $l_Body = '';
     }

	 if (is_file($g_Structure['n'][$l_Pos])) {
		$l_Result .= $g_Structure['n'][$l_Pos] . "\t\t\t" . $l_Body . "\n";
	 } else {
		$l_Result .= $g_Structure['n'][$par_List[$i]] . "\n";
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
function QCR_Debug($par_Str) {
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
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt;

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

                        if (is_link($l_FileName)) 
                        {
                            $g_SymLinks[] = $l_FileName;
                            continue;
                        }

			$l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);
			$l_IsDir = is_dir($l_FileName);

			if (in_array($l_Ext, array('o', 'so', 'pl', 'cgi', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml'))) 
			{
                $g_UnixExec[] = $l_FileName;
            }


			// which files should be scanned
			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, array(
				'js', 'php', 'php3', 'phtml', 'shtml', 'khtml',
				'php4', 'php5', 'tpl', 'inc', 'htaccess', 'html', 'htm'
			)));
			
			if (in_array($l_Ext, $g_IgnoredExt)) {
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
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".QUEUE_FILENAME);
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

  $l_Res = '@AI_LINE1@' . $l_LineNo . "@AI_LINE2@  " . ($l_MinPos > 0 ? '...' : '') . substr($par_Content, $l_MinPos, $par_Pos - $l_MinPos) . 
           '@AI_MARKER@' . 
           substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);

  return htmlspecialchars($l_Res);
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

  $par_Content = preg_replace_callback('/\\\\x([a-fA-F0-9]{1,2})/i','escapedHexToHex', $par_Content);
  $par_Content = preg_replace_callback('/\\\\([0-9]{1,3})/i','escapedOctDec', $par_Content);
//  $par_Content = preg_replace_callback('/\\\\([0-9]{2})/i','escapedDec', $par_Content);

//  $par_Content = preg_replace('/(\w+)\s+(/smi', '$1(', $par_Content);
//  $par_Content = preg_replace('/@(\w+)/smi', '$1', $par_Content);
//  $par_Content = preg_replace('/\s+,\s+/smi', ',', $par_Content);

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
	foreach (new SplFileObject(QUEUE_FILENAME)as $l_Filename) {
		QCR_ScanFile(trim($l_Filename), $i++);
	}

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
				return;
			}

			QCR_Debug('Scan file ' . $l_Filename);

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
                $l_Content = @file_get_contents($l_Filename);
                if (($l_Content == '') && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult($l_Filename, $i);
                }

				// ignore itself
				if (strpos($l_Content, 'HLKHLKJHKLHJGJG6789869869GGHJ') !== false) {
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
	        		   printProgress(++$_files_and_ignored, $l_Filename);
                                   return;
                                }

				$l_UnicodeContent = detect_utf_encoding($l_Content);
				$l_Unwrapped = $l_Content;
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

				//$l_Unwrapped = preg_replace('|/\*.*?\*/|smi', '', $l_Unwrapped);
				$l_Unwrapped = RemoveCommentsPHP($l_Unwrapped);
				
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
			
			printProgress(++$_files_and_ignored, $l_Filename);

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
      if (preg_match('#(' . $l_ExceptItem . ')#smi', $l_FoundStrPlus, $l_Detected)) {
         $l_Exception = true;
         return true;
      }
   }

   return false;
}

///////////////////////////////////////////////////////////////////////////
function Phishing($l_FN, $l_Index, $l_Content, &$l_SigId)
{
  global $g_PhishingSig;

  $l_Res = false;

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
  global $g_JSVirSig, $gX_JSVirSig;

  $l_Res = false;

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
  global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;

  // HLKHLKJHKLHJGJG6789869869GGHJ

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

  if (strpos($l_FN, '.php.') !== false ) {
     $g_Base64[] = $l_Index;
     $g_Base64Fragment[] = '".php."';
     $l_Pos = 0;

     if (DEBUG_MODE) {
          echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     AddResult($l_FN, $l_Index);

     return false;
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

if ($l_DIRH = opendir($g_AiBolitAbsolutePathKnownFiles))
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

	$defaults['skip_ext'] = trim($defaults['skip_ext']);
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
   // scan list of files from file
   if (!$l_SpecifiedPath && file_exists(DOUBLECHECK_FILE)) {
      stdOut("Start scanning the list from '" . DOUBLECHECK_FILE . "'.");
      $s_file = new SplFileObject(DOUBLECHECK_FILE);
      $s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
      // force to seek to last line
      $s_file->seek(PHP_INT_MAX);
      // get number of lines
      $g_FoundTotalFiles = $g_Counter = $s_file->key();
      $i = 0;
      foreach ($s_file as $l_FN) {
         if (file_exists($l_FN)) {
            QCR_ScanFile($l_FN, $i++); 
         }
      }

      $s_file = null;

   } else {
      // scan whole file system
      stdOut("Start scanning '" . ROOT_PATH . "'.");
      
      file_exists(QUEUE_FILENAME) && unlink(QUEUE_FILENAME);
      QCR_ScanDirectories(ROOT_PATH);

   }
}

//$g_FoundTotalFiles = count($g_Structure['n']);
$g_FoundTotalFiles = $g_Counter;

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

if (!(ONE_PASS || defined('SCAN_FILE') || file_exists(DOUBLECHECK_FILE))) {
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

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : realpath('.')), $l_Template);

$time_tacked = seconds2Human(microtime(true) - START_TIME);

$l_Template = str_replace("@@SCANNED@@", sprintf(AI_STR_013, $g_TotalFolder, $g_TotalFiles), $l_Template);

$l_ShowOffer = false;

stdOut("\nBuilding report [ mode = " . AI_EXPERT . " ]\n");

////////////////////////////////////////////////////////////////////////////
// save 
if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR 
   (count($g_Iframer) > 0) OR  (count($g_UnixExec))) 
{

  if (!$l_SpecifiedPath && !file_exists(DOUBLECHECK_FILE)) {
      if ($l_FH = fopen(DOUBLECHECK_FILE, 'w')) {
         fputs($l_FH, '<?php die("Forbidden"); ?>' . "\n");

         $l_CurrPath = dirname(__FILE__);

         for ($i = 0; $i < count($g_CriticalPHP); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_CriticalPHP[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_Structure['n'][$g_CriticalPHP[$i]]));  
         }

         for ($i = 0; $i < count($g_Base64); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_Base64[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_Structure['n'][$g_Base64[$i]]));
         }

         for ($i = 0; $i < count($g_CriticalJS); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_CriticalJS[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_Structure['n'][$g_CriticalJS[$i]]));
         }

         for ($i = 0; $i < count($g_Iframer); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_Iframer[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_Structure['n'][$g_Iframer[$i]]));
         }

         for ($i = 0; $i < count($g_UnixExec); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_UnixExec[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_UnixExec[$i]));
         }

         for ($i = 0; $i < count($g_Phishing); $i++) {
             fputs($l_FH, str_replace($l_CurrPath, '.', $g_Structure['n'][$g_Phishing[$i]]) . "\n");
             //unlink(str_replace($l_CurrPath, '.', $g_Phishing[$i]));
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

stdOut("Building list of heuristics " . count($g_HeuristicDetected));

if (count($g_HeuristicDetected) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
  for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
	   $l_Result .= '<li>' . $g_Structure['n'][$g_HeuristicDetected[$i]] . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
  }
  
  $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;

  $l_ShowOffer = true;
}

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

stdOut("Building list of php inj " . count($g_PHPCodeInside));

if ((count($g_PHPCodeInside) > 0) && (($defaults['report_mask'] & REPORT_MASK_PHPSIGN) == REPORT_MASK_PHPSIGN)) {

  $l_ShowOffer = true;
  $l_Result .= '<div class="note_warn">' . AI_STR_028 . '</div><div class="warn">';
  $l_Result .= printList($g_PHPCodeInside, $g_PHPCodeInsideFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of adware " . count($g_AdwareList));

if (count($g_AdwareList) > 0) {
  $l_ShowOffer = true;

  $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
  $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}


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

stdOut("Building list of skipped dirs " . count($g_SkippedFolders));
if (count($g_SkippedFolders) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_036 . '</div><div class="warn">';
     $l_Result .= implode("<br>", $g_SkippedFolders);
     $l_Result .= "</div>" . PHP_EOL;
 }

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

$l_Template = str_replace('@@STAT@@', sprintf(AI_STR_012, $time_tacked, date('d-m-Y в H:i:s', floor(START_TIME)) , date('d-m-Y в H:i:s')), $l_Template);

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
	
    $l_PlainResult = preg_replace('|@AI_LINE1@|smi', '[', $l_PlainResult);
    $l_PlainResult = preg_replace('|@AI_LINE2@|smi', '] ', $l_PlainResult);
    $l_PlainResult = preg_replace('|@AI_MARKER@|smi', '%>', $l_PlainResult);

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


function RemoveCommentsPHP($src) {
    
    return preg_replace('
~
(?(DEFINE)
  (?<next_open_tag>
    (?i:
        [^<]*+  <*+ 
        (?: [^?s] [^<]*+ <++ )*+
        (?: \? (?!xml\b) \K (*ACCEPT)
          | script\s+language\s*=\s*([\'"]?)php\g{-1}\s*> \K (*ACCEPT)
        )?
    )++ \K
  )
)
\A (?&next_open_tag)
|
\G
[^\'"`/#<?@\s]*+
(?: \'(?:[^\'\\\\]+|\\\\.)*+\'
  | "(?:[^"\\\\]+|\\\\.)*+"
  | `(?:[^`\\\\]+|\\\\.)*+`
  | /(?![/*])                  # stop for // or /*
  | # if close tag ?>
    \? (?: >(?&next_open_tag) | ) 
  | <  (?: # heredoc or nowdoc
           <<[\ \t]*([\'"]?)
                   ([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)
                   \g{-2}[\ \t]*[\r\n]
             (?-s:.*+[\r\n])*?
             \g{-1}[\r\n;]
         | (?i: /script\s*>)
           (?&next_open_tag)
         |
       )
  | \K
    (?: (?://|\#)(?:[^\n?]+|\?(?!>))*+\s* # single line comment // è #
      | /\*(?:[^*]+|\*(?!/))*+\*/\s*      # multi line comment /* */
      | \s+
      | @
    ) (*ACCEPT)
)
\K
~xs', '', $src);
}

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
		exec("cat AI-BOLIT-DOUBLECHECK.php|zip -@ --password $g_QuarantinePass $archive", $output, $code);
		if ($code == 0) {
			file_put_contents($infoFile, $info);
			exec("zip -j --password $g_QuarantinePass $archive $infoFile $report");
			stdOut("\nCreate archive '" . realpath($archive) . "'");
			stdOut("This archive have password '$g_QuarantinePass'");
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
		$zip->addFile($file);
	}
	$zip->addFile($report, REPORT_FILE);
	$zip->addFromString($infoFile, $info);
	$zip->close();

	stdOut("\nCreate archive '" . realpath($archive) . "'.");
	stdOut("This archive has no password!");
}
