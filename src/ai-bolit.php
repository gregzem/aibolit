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

$g_DBShe = unserialize(base64_decode("YTozOTg6e2k6MDtzOjg6IlpPQlVHVEVMIjtpOjE7czoxMzoiTWFnZWxhbmdDeWJlciI7aToyO3M6MTQ6InByb2ZleG9yXC5oZWxsIjtpOjM7czoyMDoiPCEtLUNPT0tJRSBVUERBVEUtLT4iO2k6NDtzOjk6Ii8vcmFzdGEvLyI7aTo1O3M6ODA6IlwkcGFyYW0ybWFza1wuIlwpXFw9XFtcXFsnIl1cXCJcXVwoXC5cKlw/XClcKFw/PVxbXFxbJyJdXFwiXF1cKVxbXFxbJyJdXFwiXF0vc2llIjtpOjY7czoyNzoiXCk7XCRpXCtcK1wpXCRyZXRcLj1jaHJcKFwkIjtpOjc7czo0MDoiZXJlZ19yZXBsYWNlXChbJyJdezAsMX0mZW1haWwmWyciXXswLDF9LCI7aTo4O3M6MTk6IlxdXF1cKVwpO319ZXZhbFwoXCQiO2k6OTtzOjM0OiJmd3JpdGVcKGZvcGVuXChkaXJuYW1lXChfX0ZJTEVfX1wpIjtpOjEwO3M6MTE6IkJhYnlfRHJha29uIjtpOjExO3M6MjU6IlwkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6MTI7czoxNDoiTmV0ZGRyZXNzIE1haWwiO2k6MTM7czo1MDoiUGFzc3dvcmQ6XHMqIlwuXCRfUE9TVFxbWyciXXswLDF9cGFzc3dkWyciXXswLDF9XF0iO2k6MTQ7czoxNToiQ3JlYXRlZCBCeSBFTU1BIjtpOjE1O3M6MTM6IkdJRjg5QTs8XD9waHAiO2k6MTY7czoyOToib1RhdDhEM0RzRTgnJn5oVTA2Q0NINTtcJGdZU3EiO2k6MTc7czoyNDoiXCRtZDU9bWQ1XCgiXCRyYW5kb20iXCk7IjtpOjE4O3M6NjoiM3hwMXIzIjtpOjE5O3M6NDM6IlwkaW09c3Vic3RyXChcJHR4LFwkcFwrMixcJHAyLVwoXCRwXCsyXClcKTsiO2k6MjA7czoxNToiTmluamFWaXJ1cyBIZXJlIjtpOjIxO3M6MjI6IjdQMXRkXCtOV2xpYUkvaFdrWjRWWDkiO2k6MjI7czo2OiIuSXJJc1QiO2k6MjM7czoxMToibmRyb2lcfGh0Y18iO2k6MjQ7czoxMToiYW5kZXhcfG9vZ2wiO2k6MjU7czoxNzoiSGFja2VkIEJ5IEVuRExlU3MiO2k6MjY7czoyMzoiXChcJF9QT1NUXFsiZGlyIlxdXClcKTsiO2k6Mjc7czo2NjoiXChcJGluZGF0YSxcJGI2ND0xXCl7aWZcKFwkYjY0PT0xXCl7XCRjZD1iYXNlNjRfZGVjb2RlXChcJGluZGF0YVwpIjtpOjI4O3M6OTY6IlwkaW09c3Vic3RyXChcJGltLDAsXCRpXClcLnN1YnN0clwoXCRpbSxcJGkyXCsxLFwkaTQtXChcJGkyXCsxXClcKVwuc3Vic3RyXChcJGltLFwkaTRcKzEyLHN0cmxlbiI7aToyOTtzOjIxOiI8XD9waHAgZWNobyAiXCMhIVwjIjsiO2k6MzA7czoxMDoiUHVua2VyMkJvdCI7aTozMTtzOjEyOiJcJHNoM2xsQ29sb3IiO2k6MzI7czo3MjoiY2hyXChcKFwkaFxbXCRlXFtcJG9cXVxdPDw0XClcK1woXCRoXFtcJGVcW1wrXCtcJG9cXVxdXClcKTt9fWV2YWxcKFwkZFwpIjtpOjMzO3M6NDE6InBwY1x8bWlkcFx8d2luZG93cyBjZVx8bXRrXHxqMm1lXHxzeW1iaWFuIjtpOjM0O3M6NDQ6ImFiYWNob1x8YWJpemRpcmVjdG9yeVx8YWJvdXRcfGFjb29uXHxhbGV4YW5hIjtpOjM1O3M6NToiWmVkMHgiO2k6MzY7czo4OiJkYXJrbWlueiI7aTozNztzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM4O3M6NzoiT29OX0JveSI7aTozOTtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTo0MDtzOjY6Ik00bGwzciI7aTo0MTtzOjI1OiJjcmVhdGVGaWxlc0ZvcklucHV0T3V0cHV0IjtpOjQyO3M6ODoiUGFzaGtlbGEiO2k6NDM7czoxMzoiPT0iYmluZHNoZWxsIiI7aTo0NDtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6NDU7czozMDoiaXNzZXRcKFwkX1BPU1RcWydleGVjZ2F0ZSdcXVwpIjtpOjQ2O3M6NDA6ImZ3cml0ZVwoXCRmcHNldHYsZ2V0ZW52XCgiSFRUUF9DT09LSUUiXCkiO2k6NDc7czoyMDoiLUkvdXNyL2xvY2FsL2JhbmRtaW4iO2k6NDg7czoyMzoiXCRPT08wMDAwMDA9dXJsZGVjb2RlXCgiO2k6NDk7czo4OiJZRU5JM0VSSSI7aTo1MDtzOjE3OiJsZXRha3Nla2FyYW5nXChcKSI7aTo1MTtzOjY6ImQzbGV0ZSI7aTo1MjtzOjQ0OiJmdW5jdGlvbiB1cmxHZXRDb250ZW50c1woXCR1cmwsXCR0aW1lb3V0PTVcKSI7aTo1MztzOjUzOiJvdmVyZmxvdy15OnNjcm9sbDtcXCI+IlwuXCRsaW5rc1wuXCRodG1sX21mXFsnYm9keSdcXSI7aTo1NDtzOjE2OiJNYWRlIGJ5IERlbG9yZWFuIjtpOjU1O3M6OTI6ImlmXChlbXB0eVwoXCRfR0VUXFsnemlwJ1xdXCkgYW5kIGVtcHR5XChcJF9HRVRcWydkb3dubG9hZCdcXVwpICYgZW1wdHlcKFwkX0dFVFxbJ2ltZydcXVwpXCl7IjtpOjU2O3M6ODE6InN0cl9yb3QxM1woXCRiYXNlYVxbXChcJGRpbWVuc2lvblwqXCRkaW1lbnNpb24tMVwpIC1cKFwkaVwqXCRkaW1lbnNpb25cK1wkalwpXF1cKSI7aTo1NztzOjYwOiJSMGxHT0RsaEV3QVFBTE1BQUFBQUFQLy8vNXljQU03T1kvLy9uUC8venYvT25QZjM5Ly8vL3dBQUFBQUEiO2k6NTg7czo1MToicHJlZ19tYXRjaFwoJyFNSURQXHxXQVBcfFdpbmRvd3NcLkNFXHxQUENcfFNlcmllczYwIjtpOjU5O3M6NjE6InByZWdfbWF0Y2hcKCcvXChcPzw9UmV3cml0ZVJ1bGVcKVwuXCpcKFw/PVxcXFtMXFwsUlxcPTMwMlxcXF0iO2k6NjA7czo0MzoiXCR1cmw9XCR1cmxzXFtyYW5kXCgwLGNvdW50XChcJHVybHNcKS0xXClcXSI7aTo2MTtzOjc2OiJ3cF9wb3N0cyBXSEVSRSBwb3N0X3R5cGU9J3Bvc3QnIEFORCBwb3N0X3N0YXR1cz0ncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjYyO3M6NzU6Imh0dHA6Ly8nXC5cJF9TRVJWRVJcWydIVFRQX0hPU1QnXF1cLnVybGRlY29kZVwoXCRfU0VSVkVSXFsnUkVRVUVTVF9VUkknXF1cKSI7aTo2MztzOjQzOiJmd3JpdGVcKFwkZixnZXRfZG93bmxvYWRcKFwkX0dFVFxbJ3VybCdcXVwpIjtpOjY0O3M6ODc6IlwkcGFyYW0geCBcJG5cLnN1YnN0clwoXCRwYXJhbSxsZW5ndGhcKFwkcGFyYW1cKSAtIGxlbmd0aFwoXCRjb2RlXCklbGVuZ3RoXChcJHBhcmFtXClcKSI7aTo2NTtzOjUzOiJcJHRpbWVfc3RhcnRlZFwuXCRzZWN1cmVfc2Vzc2lvbl91c2VyXC5zZXNzaW9uX2lkXChcKSI7aTo2NjtzOjU0OiJcJHRoaXMtPkYtPkdldENvbnRyb2xsZXJcKFwkX1NFUlZFUlxbJ1JFUVVFU1RfVVJJJ1xdXCkiO2k6Njc7czoyMToibHVjaWZmZXJsdWNpZmZlclwub3JnIjtpOjY4O3M6MzA6ImJhc2U2NF9kZWNvZGVcKFwkY29kZV9zY3JpcHRcKSI7aTo2OTtzOjIzOiJ1bmxpbmtcKFwkd3JpdGFibGVfZGlycyI7aTo3MDtzOjUxOiJmaWxlX2dldF9jb250ZW50c1wodHJpbVwoXCRmXFtcJF9HRVRcWydpZCdcXVxdXClcKTsiO2k6NzE7czoxMDoiQ3liZXN0ZXI5MCI7aTo3MjtzOjM1OiItLURDQ0RJUiBcW2xpbmRleCBcJFVzZXJcKFwkaVwpIDJcXSI7aTo3MztzOjEyOiJ1bmJpbmQgUkFXIC0iO2k6NzQ7czoxMjoicHV0Ym90IFwkYm90IjtpOjc1O3M6MTQ6InByaXZtc2cgXCRuaWNrIjtpOjc2O3M6MjU6InByb2MgaHR0cDo6Q29ubmVjdHt0b2tlbn0iO2k6Nzc7czo1MDoic2V0IGdvb2dsZVwoZGF0YVwpIFxbaHR0cDo6ZGF0YSBcJGdvb2dsZVwocGFnZVwpXF0iO2k6Nzg7czoyMzoiYmluZCBqb2luIC0gXCogZ29wX2pvaW4iO2k6Nzk7czoxNDoicHJpdm1zZyBcJGNoYW4iO2k6ODA7czoyNToicjRhVGNcLmRQbnRFL2Z6dFNGMWJIM1JIMCI7aTo4MTtzOjEwOiJiaW5kIGRjYyAtIjtpOjgyO3M6Mzc6ImtpbGwgLUNITEQgXFxcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6ODM7czo1MToicmVnc3ViIC1hbGwgLS0sXFtzdHJpbmcgdG9sb3dlciBcJG93bmVyXF0gIiIgb3duZXJzIjtpOjg0O3M6MjU6ImJpbmQgZmlsdCAtICIBQUNUSU9OIFwqASIiO2k6ODU7czoyNzoiYXl1IHByMSBwcjIgcHIzIHByNCBwcjUgcHI2IjtpOjg2O3M6MjA6InNldCBwcm90ZWN0LXRlbG5ldCAwIjtpOjg3O3M6MzM6Ii91c3IvbG9jYWwvYXBhY2hlL2Jpbi9odHRwZCAtRFNTTCI7aTo4ODtzOjk3OiJcJHRzdTJcW3JhbmRcKDAsY291bnRcKFwkdHN1MlwpIC0gMVwpXF1cLlwkdHN1MVxbcmFuZFwoMCxjb3VudFwoXCR0c3UxXCkgLSAxXClcXVwuXCR0c3UyXFtyYW5kXCgwIjtpOjg5O3M6MjA6ImZvcGVuXCgnL2V0Yy9wYXNzd2QnIjtpOjkwO3M6MzU6IjBkMGEwZDBhNjc2YzZmNjI2MTZjMjAyNDZkNzk1ZjczNmQ3IjtpOjkxO3M6Mzc6IkpIWnBjMmwwWTI5MWJuUWdQU0FrU0ZSVVVGOURUMDlMU1VWZlYiO2k6OTI7czo3OiJlL1wqXC4vIjtpOjkzO3M6Mjk6InNldGNvb2tpZVwoImhpdCIsMSx0aW1lXChcKVwrIjtpOjk0O3M6NDg6ImZpbmRfZGlyc1woXCRncmFuZHBhcmVudF9kaXIsXCRsZXZlbCwxLFwkZGlyc1wpOyI7aTo5NTtzOjgyOiJjb3B5XChcJF9GSUxFU1xbZmlsZU1hc3NcXVxbdG1wX25hbWVcXSxcJF9QT1NUXFtwYXRoXF1cLlwkX0ZJTEVTXFtmaWxlTWFzc1xdXFtuYW1lIjtpOjk2O3M6OTA6ImludDMyXChcKFwoXCR6ID4+IDUgJiAweDA3ZmZmZmZmXCkgXF4gXCR5IDw8IDJcKSBcK1woXChcJHkgPj4gMyAmIDB4MWZmZmZmZmZcKSBcXiBcJHogPDwgNCI7aTo5NztzOjExOiJWT0JSQSBHQU5HTyI7aTo5ODtzOjUxOiJlY2hvIHk7c2xlZXAgMTt9XHx7d2hpbGUgcmVhZDtkbyBlY2hvIHpcJFJFUExZO2RvbmUiO2k6OTk7czoxMDoiPHN0ZGxpYlwuaCI7aToxMDA7czo0NToiYWRkX2ZpbHRlclwoJ3RoZV9jb250ZW50JywnX2Jsb2dpbmZvJywxMDAwMVwpIjtpOjEwMTtzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aToxMDI7czoyNzoiaWYgc2VsZlwuaGFzaF90eXBlPT0ncHdkdW1wIjtpOjEwMztzOjY2OiJcJGZyYW1ld29ya1wucGx1Z2luc1wubG9hZFwoIlwje3JwY3R5cGVcLmRvd25jYXNlfXJwYyIsb3B0c1wpXC5ydW4iO2k6MTA0O3M6NTg6InN1YnByb2Nlc3NcLlBvcGVuXCgnJXNnZGIgLXAgJWQgLWJhdGNoICVzJyAlXChnZGJfcHJlZml4LHAiO2k6MTA1O3M6NTg6ImFyZ3BhcnNlXC5Bcmd1bWVudFBhcnNlclwoZGVzY3JpcHRpb249aGVscCxwcm9nPSJzY3R1bm5lbCIiO2k6MTA2O3M6MzE6InJ1bGVfcmVxPXJhd19pbnB1dFwoIlNvdXJjZUZpcmUiO2k6MTA3O3M6NTY6Im9zXC5zeXN0ZW1cKCdlY2hvIGFsaWFzIGxzPSJcLmxzXC5iYXNoIiA+PiB+L1wuYmFzaHJjJ1wpIjtpOjEwODtzOjUxOiJjb25uZWN0aW9uXC5zZW5kXCgic2hlbGwgIlwrc3RyXChvc1wuZ2V0Y3dkXChcKVwpXCsiO2k6MTA5O3M6NzU6InByaW50XCgiXFshXF0gSG9zdDogIiBcKyBob3N0bmFtZSBcKyAiIG1pZ2h0IGJlIGRvd24hXFxuXFshXF0gUmVzcG9uc2UgQ29kZSI7aToxMTA7czo2OToiZGVmIGRhZW1vblwoc3RkaW49Jy9kZXYvbnVsbCcsc3Rkb3V0PScvZGV2L251bGwnLHN0ZGVycj0nL2Rldi9udWxsJ1wpIjtpOjExMTtzOjgyOiJzdWJwcm9jZXNzXC5Qb3BlblwoY21kLHNoZWxsPVRydWUsc3Rkb3V0PXN1YnByb2Nlc3NcLlBJUEUsc3RkZXJyPXN1YnByb2Nlc3NcLlNURE9VIjtpOjExMjtzOjU5OiJpZlwoaXNzZXRcKFwkX0dFVFxbJ2hvc3QnXF1cKSYmaXNzZXRcKFwkX0dFVFxbJ3RpbWUnXF1cKVwpeyI7aToxMTM7czoxNjoiTklHR0VSU1wuTklHR0VSUyI7aToxMTQ7czoyNToiSFRUUCBmbG9vZCBjb21wbGV0ZSBhZnRlciI7aToxMTU7czoyMjoiODAgLWIgXCQxIC1pIGV0aDAgLXMgOCI7aToxMTY7czoxMzoiZXhwbG9pdGNvb2tpZSI7aToxMTc7czoyOToic3lzdGVtXCgicGhwIC1mIHhwbCBcJGhvc3QiXCkiO2k6MTE4O3M6MTQ6InNoIGdvIFwkMVwuXCR4IjtpOjExOTtzOjEyOiJhejg4cGl4MDBxOTgiO2k6MTIwO3M6MzU6InVubGVzc1wob3BlblwoUEZELFwkZ191cGxvYWRfZGJcKVwpIjtpOjEyMTtzOjEzOiJ3d3dcLnQwc1wub3JnIjtpOjEyMjtzOjQ4OiJcJHZhbHVlPX4gcy8lXChcLlwuXCkvcGFja1woJ2MnLGhleFwoXCQxXClcKS9lZzsiO2k6MTIzO3M6MTQ6IlRoZSBEYXJrIFJhdmVyIjtpOjEyNDtzOjMzOiJ9ZWxzZWlmXChcJF9HRVRcWydwYWdlJ1xdPT0nZGRvcyciO2k6MTI1O3M6MTk6IntcJF9QT1NUXFsncm9vdCdcXX0iO2k6MTI2O3M6NDI6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kXCszXCs4cXZxcVMxSzBcK0FYWSI7aToxMjc7czozNToiZnJlYWRcKFwkZnAsZmlsZXNpemVcKFwkZmljaGVyb1wpXCkiO2k6MTI4O3M6Mjg6IlwkYmFzbGlrPVwkX1BPU1RcWydiYXNsaWsnXF0iO2k6MTI5O3M6MTk6InByb2Nfb3BlblwoJ0lIU3RlYW0iO2k6MTMwO3M6MzI6IlwkaW5pXFsndXNlcnMnXF09YXJyYXlcKCdyb290Jz0+IjtpOjEzMTtzOjU4OiJISjNIanV0Y2tvUmZwWGY5QTF6UU8yQXdEUnJSZXk5dUd2VGVlejc5cUFhbzFhMHJndWRrWmtSOFJhIjtpOjEzMjtzOjUyOiJjdXJsX3NldG9wdFwoXCRjaCxDVVJMT1BUX1VSTCwiaHR0cDovL1wkaG9zdDoyMDgyIlwpIjtpOjEzMztzOjY3OiI8JT0iXFwiICYgb1NjcmlwdE5ldFwuQ29tcHV0ZXJOYW1lICYgIlxcIiAmIG9TY3JpcHROZXRcLlVzZXJOYW1lICU+IjtpOjEzNDtzOjExNToic3FsQ29tbWFuZFwuUGFyYW1ldGVyc1wuQWRkXChcKFwoVGFibGVDZWxsXClkYXRhR3JpZEl0ZW1cLkNvbnRyb2xzXFswXF1cKVwuVGV4dCxTcWxEYlR5cGVcLkRlY2ltYWxcKVwuVmFsdWU9ZGVjaW1hbCI7aToxMzU7czo5OToiUmVzcG9uc2VcLldyaXRlXCgiPGJyPlwoXCkgPGEgaHJlZj1cP3R5cGU9MSZmaWxlPSIgJiBzZXJ2ZXJcLlVSTGVuY29kZVwoaXRlbVwucGF0aFwpICYgIlxcPiIgJiBpdGVtIjtpOjEzNjtzOjExOToibmV3IEZpbGVTdHJlYW1cKFBhdGhcLkNvbWJpbmVcKGZpbGVJbmZvXC5EaXJlY3RvcnlOYW1lLFBhdGhcLkdldEZpbGVOYW1lXChodHRwUG9zdGVkRmlsZVwuRmlsZU5hbWVcKVwpLEZpbGVNb2RlXC5DcmVhdGUiO2k6MTM3O3M6ODE6IlJlc3BvbnNlXC5Xcml0ZVwoU2VydmVyXC5IdG1sRW5jb2RlXCh0aGlzXC5FeGVjdXRlQ29tbWFuZFwodHh0Q29tbWFuZFwuVGV4dFwpXClcKSI7aToxMzg7czo4OToiPCU9UmVxdWVzdFwuU2VydmVydmFyaWFibGVzXCgiU0NSSVBUX05BTUUiXCklPlw/dHh0cGF0aD08JT1SZXF1ZXN0XC5RdWVyeVN0cmluZ1woInR4dHBhdGgiO2k6MTM5O3M6NjM6Im91dHN0ciBcKz1zdHJpbmdcLkZvcm1hdFwoIjxhIGhyZWY9J1w/ZmRpcj17MH0nPnsxfS88L2E+Jm5ic3A7IiI7aToxNDA7czo0MzoicmVcLmZpbmRhbGxcKGRpcnRcKydcKFwuXCpcKScscHJvZ25tXClcWzBcXSI7aToxNDE7czo0MToiZmluZCAvIC1uYW1lXC5zc2ggPiBcJGRpci9zc2hrZXlzL3NzaGtleXMiO2k6MTQyO3M6NjM6IkZTX2Noa19mdW5jX2xpYmM9XChcJFwocmVhZGVsZiAtcyBcJEZTX2xpYmMgXHwgZ3JlcCBfY2hrIFx8IGF3ayI7aToxNDM7czoxMDI6IlwkZmlsZT1cJF9GSUxFU1xbImZpbGVuYW1lIlxdXFsibmFtZSJcXTtlY2hvICI8YSBocmVmPVxcIlwkZmlsZVxcIj5cJGZpbGU8L2E+Ijt9ZWxzZXtlY2hvXCgiZW1wdHkiXCk7fSI7aToxNDQ7czo1Njoic2VydmVyXC48L3A+XFxyXFxuPC9ib2R5PjwvaHRtbD4iO2V4aXQ7fWlmXChwcmVnX21hdGNoXCgiO2k6MTQ1O3M6ODc6IlwkRmNobW9kLFwkRmRhdGEsXCRPcHRpb25zLFwkQWN0aW9uLFwkaGRkYWxsLFwkaGRkZnJlZSxcJGhkZHByb2MsXCR1bmFtZSxcJGlkZFwpOnNoYXJlZCI7aToxNDY7czoxNzoicGhwICJcLlwkd3NvX3BhdGgiO2k6MTQ3O3M6NjQ6IlwkcHJvZD0ic3lzdGVtIjtcJGlkPVwkcHJvZFwoXCRfUkVRVUVTVFxbJ3Byb2R1Y3QnXF1cKTtcJHsnaWQnfTsiO2k6MTQ4O3M6MzM6ImFzc2VydFwoXCRfUkVRVUVTVFxbJ1BIUFNFU1NJRCdcXSI7aToxNDk7czo3MDoiUE9TVHtcJHBhdGh9e1wkY29ubmVjdG9yfVw/Q29tbWFuZD1GaWxlVXBsb2FkJlR5cGU9RmlsZSZDdXJyZW50Rm9sZGVyPSI7aToxNTA7czo4ODoiImFkbWluMVwucGhwIiwiYWRtaW4xXC5odG1sIiwiYWRtaW4yXC5waHAiLCJhZG1pbjJcLmh0bWwiLCJ5b25ldGltXC5waHAiLCJ5b25ldGltXC5odG1sIiI7aToxNTE7czo5NzoicGF0aDE9XCgnYWRtaW4vJywnYWRtaW5pc3RyYXRvci8nLCdtb2RlcmF0b3IvJywnd2ViYWRtaW4vJywnYWRtaW5hcmVhLycsJ2JiLWFkbWluLycsJ2FkbWluTG9naW4vJyI7aToxNTI7czozOToiY2F0IFwke2Jsa2xvZ1xbMlxdfVx8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjE1MztzOjU1OiJcP3VybD0nXC5cJF9TRVJWRVJcWydIVFRQX0hPU1QnXF1cKVwudW5saW5rXChST09UX0RJUlwuIjtpOjE1NDtzOjUwOiJsb25nIGludDp0XCgwLDNcKT1yXCgwLDNcKTstMjE0NzQ4MzY0ODsyMTQ3NDgzNjQ3OyI7aToxNTU7czo3MzoiY3JlYXRlX2Z1bmN0aW9uXCgiJlwkZnVuY3Rpb24iLCJcJGZ1bmN0aW9uPWNoclwob3JkXChcJGZ1bmN0aW9uXCktM1wpOyJcKSI7aToxNTY7czo5MzoiZnVuY3Rpb24gZ29vZ2xlX2JvdFwoXCl7XCRzVXNlckFnZW50PXN0cnRvbG93ZXJcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXVwpO2lmXCghXChzdHJwIjtpOjE1NztzOjg5OiJjb3B5XChcJF9GSUxFU1xbJ3Vwa2snXF1cWyd0bXBfbmFtZSdcXSwia2svIlwuYmFzZW5hbWVcKFwkX0ZJTEVTXFsndXBraydcXVxbJ25hbWUnXF1cKVwpOyI7aToxNTg7czo2MzoiZm9yXChcJHZhbHVlXCl7cy8mLyZhbXA7L2c7cy88LyZsdDsvZztzLz4vJmd0Oy9nO3MvIi8mcXVvdDsvZzt9IjtpOjE1OTtzOjQ0OiJcJGRiX2Q9bXlzcWxfc2VsZWN0X2RiXChcJGRhdGFiYXNlLFwkY29uMVwpOyI7aToxNjA7czo1MToiU2VuZCB0aGlzIGZpbGU6IDxJTlBVVCBOQU1FPSJ1c2VyZmlsZSIgVFlQRT0iZmlsZSI+IjtpOjE2MTtzOjI0OiJmd3JpdGVcKFwkZnAsIlwkeWF6aSJcKTsiO2k6MTYyO3M6NTc6Im1hcHtyZWFkX3NoZWxsXChcJF9cKX1cKFwkc2VsX3NoZWxsLT5jYW5fcmVhZFwoMFwuMDFcKVwpOyI7aToxNjM7czoyODoiMj4mMSAxPiYyIiA6ICIgMT4mMSAyPiYxIlwpOyI7aToxNjQ7czo2MDoiZ2xvYmFsIFwkbXlzcWxIYW5kbGUsXCRkYm5hbWUsXCR0YWJsZW5hbWUsXCRvbGRfbmFtZSxcJG5hbWUsIjtpOjE2NTtzOjY5OiJfX2FsbF9fPVxbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXF0iO2k6MTY2O3M6MzM6ImlmXChpc19maWxlXCgiL3RtcC9cJGVraW5jaSJcKVwpeyI7aToxNjc7czo0MzoiaWZcKFwkY21kICE9IiJcKSBwcmludCBTaGVsbF9FeGVjXChcJGNtZFwpOyI7aToxNjg7czozMDoiXCRjbWQ9XChcJF9SRVFVRVNUXFsnY21kJ1xdXCk7IjtpOjE2OTtzOjYwOiJcJHVwbG9hZGZpbGU9XCRycGF0aFwuIi8iXC5cJF9GSUxFU1xbJ3VzZXJmaWxlJ1xdXFsnbmFtZSdcXTsiO2k6MTcwO3M6Mzg6ImlmXChcJGZ1bmNhcmc9fiAvXF5wb3J0c2NhblwoXC5cKlwpL1wpIjtpOjE3MTtzOjQ3OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3RcLlNlcnZlclZhcmlhYmxlcyAlPiI7aToxNzI7czo1NDoiaWZcKCcnPT1cKFwkZGY9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpXClcKXtlY2hvIjtpOjE3MztzOjQwOiJcJGZpbGVuYW1lPVwkYmFja3Vwc3RyaW5nXC4iXCRmaWxlbmFtZSI7IjtpOjE3NDtzOjMwOiJcJGZ1bmN0aW9uXChcJF9QT1NUXFsnY21kJ1xdXCkiO2k6MTc1O3M6MzA6ImVjaG8gIkZJTEUgVVBMT0FERUQgVE8gXCRkZXoiOyI7aToxNzY7czo3MzoiaWZcKCFpc19saW5rXChcJGZpbGVcKSAmJlwoXCRyPXJlYWxwYXRoXChcJGZpbGVcKVwpICE9RkFMU0VcKSBcJGZpbGU9XCRyOyI7aToxNzc7czo4OToiVU5JT04gU0VMRUNUICcwJywnPFw/IHN5c3RlbVwoXFxcJF9HRVRcW2NwY1xdXCk7ZXhpdDtcPz4nLDAsMCwwLDAgSU5UTyBPVVRGSUxFICdcJG91dGZpbGUiO2k6MTc4O3M6MTA3OiJpZlwobW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbImZpYyJcXVxbInRtcF9uYW1lIlxdLGdvb2RfbGlua1woIlwuLyJcLlwkX0ZJTEVTXFsiZmljIlxdXFsibmFtZSJcXVwpXClcKSI7aToxNzk7czo4MjoiY29ubmVjdFwoU09DS0VULHNvY2thZGRyX2luXChcJEFSR1ZcWzFcXSxpbmV0X2F0b25cKFwkQVJHVlxbMFxdXClcKVwpIG9yIGRpZSBwcmludCI7aToxODA7czo1OToiZWxzZWlmXChpc193cml0YWJsZVwoXCRGTlwpICYmIGlzX2ZpbGVcKFwkRk5cKVwpIFwkdG1wT3V0TUYiO2k6MTgxO3M6NzQ6IndoaWxlXChcJHJvdz1teXNxbF9mZXRjaF9hcnJheVwoXCRyZXN1bHQsTVlTUUxfQVNTT0NcKVwpIHByaW50X3JcKFwkcm93XCk7IjtpOjE4MjtzOjIxOiJcJGZlXCgiXCRjbWQgMj4mMSJcKTsiO2k6MTgzO3M6NzU6InNlbmRcKFNPQ0s1LFwkbXNnLDAsc29ja2FkZHJfaW5cKFwkcG9ydGEsXCRpYWRkclwpXCkgYW5kIFwkcGFjb3Rlc3tvfVwrXCs7OyI7aToxODQ7czo5NToifWVsc2lmXChcJHNlcnZhcmc9fiAvXF5cXDpcKFwuXCtcP1wpXFwhXChcLlwrXD9cKVxcXChcLlwrXD9cKSBQUklWTVNHXChcLlwrXD9cKSBcXDpcKFwuXCtcKS9cKXsiO2k6MTg1O3M6NDE6ImVsc2VpZlwoZnVuY3Rpb25fZXhpc3RzXCgic2hlbGxfZXhlYyJcKVwpIjtpOjE4NjtzOjcyOiJzeXN0ZW1cKCJcJGNtZCAxPiAvdG1wL2NtZHRlbXAgMj4mMTtjYXQgL3RtcC9jbWR0ZW1wO3JtIC90bXAvY21kdGVtcCJcKTsiO2k6MTg3O3M6NjI6IlwkX0ZJTEVTXFsncHJvYmUnXF1cWydzaXplJ1xdLFwkX0ZJTEVTXFsncHJvYmUnXF1cWyd0eXBlJ1xdXCk7IjtpOjE4ODtzOjg5OiJcJHJhNDQ9cmFuZFwoMSw5OTk5OVwpO1wkc2o5OD0ic2gtXCRyYTQ0IjtcJG1sPSJcJHNkOTgiO1wkYTU9XCRfU0VSVkVSXFsnSFRUUF9SRUZFUkVSJ1xdOyI7aToxODk7czo2OToibXlzcWxfcXVlcnlcKCJDUkVBVEUgVEFCTEUgYHhwbG9pdGBcKGB4cGxvaXRgIExPTkdCTE9CIE5PVCBOVUxMXCkiXCk7IjtpOjE5MDtzOjcwOiJwYXNzdGhydVwoXCRiaW5kaXJcLiJteXNxbGR1bXAgLS11c2VyPVwkVVNFUk5BTUUgLS1wYXNzd29yZD1cJFBBU1NXT1JEIjtpOjE5MTtzOjg4OiI8YSBocmVmPSdcJFBIUF9TRUxGXD9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9XCRkYm5hbWUmdGFibGVuYW1lPVwkdGFibGVuYW1lJz5TY2hlbWE8L2E+IjtpOjE5MjtzOjY4OiJpZlwoZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXClcJHNoZWxsT3V0PXN0cmlwc2xhc2hlc1woXCRzaGVsbE91dFwpOyI7aToxOTM7czo1MDoiaWZcKCFkZWZpbmVkXCRwYXJhbXtjbWR9XCl7XCRwYXJhbXtjbWR9PSJscyAtbGEifTsiO2k6MTk0O3M6MjU6InNoZWxsX2V4ZWNcKCd1bmFtZSAtYSdcKTsiO2k6MTk1O3M6MTA1OiJpZlwobW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ2ZpbGEnXF1cWyd0bXBfbmFtZSdcXSxcJGN1cmRpclwuIi8iXC5cJF9GSUxFU1xbJ2ZpbGEnXF1cWyduYW1lJ1xdXClcKXsiO2k6MTk2O3M6OTA6ImlmXChlbXB0eVwoXCRfUE9TVFxbJ3dzZXInXF1cKVwpe1wkd3Nlcj0id2hvaXNcLnJpcGVcLm5ldCI7fWVsc2UgXCR3c2VyPVwkX1BPU1RcWyd3c2VyJ1xdOyI7aToxOTc7czo0MDoiPCU9ZW52XC5xdWVyeUhhc2h0YWJsZVwoInVzZXJcLm5hbWUiXCklPiI7aToxOTg7czo2NToiUHlTeXN0ZW1TdGF0ZVwuaW5pdGlhbGl6ZVwoU3lzdGVtXC5nZXRQcm9wZXJ0aWVzXChcKSxudWxsLGFyZ3ZcKTsiO2k6MTk5O3M6NDE6ImlmXCghXCR3aG9hbWlcKVwkd2hvYW1pPWV4ZWNcKCJ3aG9hbWkiXCk7IjtpOjIwMDtzOjQwOiJzaGVsbF9leGVjXChcJF9QT1NUXFsnY21kJ1xdXC4iIDI+JjEiXCk7IjtpOjIwMTtzOjUyOiJQblZsa1dNNjMhXCMmZEt4fm5NRFdNfkR/L0Vzbn54fzZEXCMmUH5+LFw/blksV1B7UG9qIjtpOjIwMjtzOjI5OiIhXCRfUkVRVUVTVFxbImM5OXNoX3N1cmwiXF1cKSI7aToyMDM7czo3ODoiXChlcmVnXCgnXF5cW1xbOmJsYW5rOlxdXF1cKmNkXFtcWzpibGFuazpcXVxdXCpcJCcsXCRfUkVRVUVTVFxbJ2NvbW1hbmQnXF1cKVwpIjtpOjIwNDtzOjI1OiJcJGxvZ2luPXBvc2l4X2dldHVpZFwoXCk7IjtpOjIwNTtzOjM4OiJzeXN0ZW1cKCJ1bnNldCBISVNURklMRTt1bnNldCBTQVZFSElTVCI7aToyMDY7czozMjoiPEhUTUw+PEhFQUQ+PFRJVExFPmNnaS1zaGVsbFwucHkiO2k6MjA3O3M6NDE6ImV4ZWNsXCgiL2Jpbi9zaCIsInNoIiwiLWkiLFwoY2hhclwqXCkwXCk7IjtpOjIwODtzOjI3OiJuY2Z0cHB1dCAtdSBcJGZ0cF91c2VyX25hbWUiO2k6MjA5O3M6Mzc6IlwkYVxbaGl0c1xdJ1wpO1xcclxcblwjZW5kcXVlcnlcXHJcXG4iO2k6MjEwO3M6Mjc6IntcJHtwYXNzdGhydVwoXCRjbWRcKX19PGJyPiI7aToyMTE7czo0NzoiXCRiYWNrZG9vci0+Y2NvcHlcKFwkY2ZpY2hpZXIsXCRjZGVzdGluYXRpb25cKTsiO2k6MjEyO3M6NjY6IlwkaXppbmxlcjI9c3Vic3RyXChiYXNlX2NvbnZlcnRcKGZpbGVwZXJtc1woXCRmbmFtZVwpLDEwLDhcKSwtNFwpOyI7aToyMTM7czo1MzoiZm9yXCg7XCRwYWRkcj1hY2NlcHRcKENMSUVOVCxTRVJWRVJcKTtjbG9zZSBDTElFTlRcKXsiO2k6MjE0O3M6ODoiQXNtb2RldXMiO2k6MjE1O3M6Mzk6InBhc3N0aHJ1XChnZXRlbnZcKCJIVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyMTY7czo0NjoiXCRfX19fPWd6aW5mbGF0ZVwoXCRfX19fXClcKXtpZlwoaXNzZXRcKFwkX1BPUyI7aToyMTc7czoxMDM6Ilwkc3Viaj11cmxkZWNvZGVcKFwkX0dFVFxbJ3N1J1xdXCk7XCRib2R5PXVybGRlY29kZVwoXCRfR0VUXFsnYm8nXF1cKTtcJHNkcz11cmxkZWNvZGVcKFwkX0dFVFxbJ3NkJ1xdXCkiO2k6MjE4O3M6Mzg6Ilwka2E9JzxcPy8vQlJFJztcJGtha2E9XCRrYVwuJ0FDSy8vXD8+IjtpOjIxOTtzOjMxOiJDYXV0YW0gZmlzaWVyZWxlIGRlIGNvbmZpZ3VyYXJlIjtpOjIyMDtzOjEyOiJCUlVURUZPUkNJTkciO2k6MjIxO3M6MTk6InB3ZCA+IEdlbmVyYXNpXC5kaXIiO2k6MjIyO3M6NTc6InhoIC1zICIvdXNyL2xvY2FsL2FwYWNoZS9zYmluL2h0dHBkIC1EU1NMIlwuL2h0dHBkIC1tIFwkMSI7aToyMjM7czo2MDoiXCRhPVwoc3Vic3RyXCh1cmxlbmNvZGVcKHByaW50X3JcKGFycmF5XChcKSwxXClcKSw1LDFcKVwuY1wpIjtpOjIyNDtzOjI0OiIhXCRfQ09PS0lFXFtcJHNlc3NkdF9rXF0iO2k6MjI1O3M6NTg6IlNFTEVDVCAxIEZST00gbXlzcWxcLnVzZXIgV0hFUkUgY29uY2F0XChgdXNlcmAsJycsYGhvc3RgXCkiO2k6MjI2O3M6NTc6ImNvcHlcKFwkX0ZJTEVTXFt4XF1cW3RtcF9uYW1lXF0sXCRfRklMRVNcW3hcXVxbbmFtZVxdXClcKSI7aToyMjc7czo1ODoiXCRNZXNzYWdlU3ViamVjdD1iYXNlNjRfZGVjb2RlXChcJF9QT1NUXFsibXNnc3ViamVjdCJcXVwpOyI7aToyMjg7czoxOToicmVuYW1lXCgid3NvXC5waHAiLCI7aToyMjk7czoxMDE6IlwkcmVkaXJlY3RVUkw9J2h0dHA6Ly8nXC5cJHJTaXRlXC5cJF9TRVJWRVJcWydSRVFVRVNUX1VSSSdcXTtpZlwoaXNzZXRcKFwkX1NFUlZFUlxbJ0hUVFBfUkVGRVJFUidcXVwpIjtpOjIzMDtzOjQ1OiJcJGZpbGVwYXRoPXJlYWxwYXRoXChcJF9QT1NUXFsnZmlsZXBhdGgnXF1cKTsiO2k6MjMxO3M6NDc6Ildvcmtlcl9HZXRSZXBseUNvZGVcKFwkb3BEYXRhXFsncmVjdkJ1ZmZlcidcXVwpIjtpOjIzMjtzOjIxOiJGYVRhTGlzVGlDel9GeCBGeDI5U2giO2k6MjMzO3M6MTM6Inc0Y2sxbmcgc2hlbGwiO2k6MjM0O3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6MjM1O3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjIzNjtzOjEzOiJQSFBTSEVMTFwuUEhQIjtpOjIzNztzOjU5OiJyb3VuZFwoMFwrOTgzMFwuNFwrOTgzMFwuNFwrOTgzMFwuNFwrOTgzMFwuNFwrOTgzMFwuNFwpXCk9PSI7aToyMzg7czo4NjoiaWZcKGVyZWdcKCdcXlxbXFs6Ymxhbms6XF1cXVwqY2RcW1xbOmJsYW5rOlxdXF1cK1woXFtcXjtcXVwrXClcJCcsXCRjb21tYW5kLFwkcmVnc1wpXCkiO2k6MjM5O3M6NzY6IkxTMGdSSFZ0Y0ROa0lHSjVJRkJwY25Wc2FXNHVVRWhRSUZkbFluTm9NMnhzSUhZeExqQWdZekJrWldRZ1lua2djakJrY2pFZ09rdz0iO2k6MjQwO3M6MTQyOiI1amIyMGlLVzl5SUhOMGNtbHpkSElvSkhKbFptVnlaWElzSW1Gd2IzSjBJaWtnYjNJZ2MzUnlhWE4wY2lna2NtVm1aWEpsY2l3aWJtbG5iV0VpS1NCdmNpQnpkSEpwYzNSeUtDUnlaV1psY21WeUxDSjNaV0poYkhSaElpa2diM0lnYzNSeWFYTjBjaWdrIjtpOjI0MTtzOjUzOiJ3c29FeFwoJ3RhciBjZnp2ICdcLmVzY2FwZXNoZWxsYXJnXChcJF9QT1NUXFsncDInXF1cKSI7aToyNDI7czo5NDoiPG5vYnI+PGI+XCRjZGlyXCRjZmlsZTwvYj5cKCJcLlwkZmlsZVxbInNpemVfc3RyIlxdXC4iXCk8L25vYnI+PC90ZD48L3RyPjxmb3JtIG5hbWU9Y3Vycl9maWxlPiI7aToyNDM7czoxNzoiQ29udGVudC1UeXBlOiBcJF8iO2k6MjQ0O3M6MTU2OiI8L3RkPjx0ZCBpZD1mYT5cWyA8YSB0aXRsZT1cXCJIb21lOiAnIlwuaHRtbHNwZWNpYWxjaGFyc1woc3RyX3JlcGxhY2VcKCJcXCIsXCRzZXAsZ2V0Y3dkXChcKVwpXClcLiInXC5cXCIgaWQ9ZmEgaHJlZj1cXCJqYXZhc2NyaXB0OlZpZXdEaXJcKCciXC5yYXd1cmxlbmNvZGUiO2k6MjQ1O3M6NDU6IldTT3NldGNvb2tpZVwobWQ1XChcJF9TRVJWRVJcWydIVFRQX0hPU1QnXF1cKSI7aToyNDY7czo0MzoiSiFWclwqJlJIUnd+Skx3XC5HXHx4bGhuTEp+XD8xXC5id09ieGJQXHwhViI7aToyNDc7czoxMToiemVoaXJoYWNrZXIiO2k6MjQ4O3M6MTg0OiJcKCciJywnJnF1b3Q7JyxcJGZuXClcKVwuJyI7ZG9jdW1lbnRcLmxpc3RcLnN1Ym1pdFwoXCk7XFwnPidcLmh0bWxzcGVjaWFsY2hhcnNcKHN0cmxlblwoXCRmblwpPmZvcm1hdFw/c3Vic3RyXChcJGZuLDAsZm9ybWF0LTNcKVwuOlwkZm5cKVwuJzwvYT4nXC5zdHJfcmVwZWF0XCgnICcsZm9ybWF0LXN0cmxlblwoXCRmblwpIjtpOjI0OTtzOjIwNjoicHJpbnRcKFwoaXNfcmVhZGFibGVcKFwkZlwpICYmIGlzX3dyaXRlYWJsZVwoXCRmXClcKVw/Ijx0cj48dGQ+Ilwud1woMVwpXC5iXCgiUiJcLndcKDFcKVwuZm9udFwoJ3JlZCcsJ1JXJywzXClcKVwud1woMVwpOlwoXChcKGlzX3JlYWRhYmxlXChcJGZcKVwpXD8iPHRyPjx0ZD4iXC53XCgxXClcLmJcKCJSIlwpXC53XCg0XCk6IiJcKVwuXChcKGlzX3dyaXRhYmwiO2k6MjUwO3M6OTc6IjwlPVJlcXVlc3RcLlNlcnZlclZhcmlhYmxlc1woInNjcmlwdF9uYW1lIlwpJT5cP0ZvbGRlclBhdGg9PCU9U2VydmVyXC5VUkxQYXRoRW5jb2RlXChGb2xkZXJcLkRyaXYiO2k6MjUxO3M6NDE6IlJvb3RTaGVsbCEnXCk7c2VsZlwubG9jYXRpb25cLmhyZWY9J2h0dHA6IjtpOjI1MjtzOjg0OiJhIGhyZWY9IjxcP2VjaG8gIlwkZmlzdGlrXC5waHBcP2RpemluPVwkZGl6aW4vXC5cLi8iXD8+IiBzdHlsZT0idGV4dC1kZWNvcmF0aW9uOiBub24iO2k6MjUzO3M6MTM1OiJudFwpXChkaXNrX3RvdGFsX3NwYWNlXChnZXRjd2RcKFwpXCkvXCgxMDI0XCoxMDI0XClcKVwuIk1iIEZyZWUgc3BhY2UgIlwuXChpbnRcKVwoZGlza19mcmVlX3NwYWNlXChnZXRjd2RcKFwpXCkvXCgxMDI0XCoxMDI0XClcKVwuIk1iIDwiO2k6MjU0O3M6Mzk6ImtsYXN2YXl2XC5hc3BcP3llbmlkb3N5YT08JT1ha3RpZmtsYXMlPiI7aToyNTU7czoxMzQ6Im1wdHlcKFwkX1BPU1RcWyd1cidcXVwpXCkgXCRtb2RlIFx8PTA0MDA7aWZcKCFlbXB0eVwoXCRfUE9TVFxbJ3V3J1xdXClcKSBcJG1vZGUgXHw9MDIwMDtpZlwoIWVtcHR5XChcJF9QT1NUXFsndXgnXF1cKVwpIFwkbW9kZSBcfD0wMTAwIjtpOjI1NjtzOjEwNzoiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrXCtqWURVOTJDOTRqZHREaWZcK3hPWWpHNkNMaHgzMVVvOXg5L2VBV2dzQks2MGtLMm1Md3F6cWQiO2k6MjU3O3M6MTAyOiJjcmxmXC4ndW5saW5rXChcJG5hbWVcKTsnXC5cJGNybGZcLidyZW5hbWVcKCJ+IlwuXCRuYW1lLFwkbmFtZVwpOydcLlwkY3JsZlwuJ3VubGlua1woImdycF9yZXBhaXJcLnBocCIiO2k6MjU4O3M6MTU6IkRYX0hlYWRlcl9kcmF3biI7aToyNTk7czoxMjoiY3RzaGVsbFwucGhwIjtpOjI2MDtzOjUxOiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj1cI2RjZGNkYz5cW1wkY21kXF0iO2k6MjYxO3M6MTQ6IldTQ1JJUFRcLlNIRUxMIjtpOjI2MjtzOjc6ImNhc3VzMTUiO2k6MjYzO3M6MTc6ImFkbWluc3B5Z3J1cFwub3JnIjtpOjI2NDtzOjE0OiJ0ZW1wX3I1N190YWJsZSI7aToyNjU7czoxODoiXCRjOTlzaF91cGRhdGVmdXJsIjtpOjI2NjtzOjk6IkJ5IFBzeWNoMCI7aToyNjc7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToyNjg7czo5NDoiPHRleHRhcmVhIG5hbWU9XFwicGhwZXZcXCIgcm93cz1cXCI1XFwiIGNvbHM9XFwiMTUwXFwiPiJcLlwkX1BPU1RcWydwaHBldidcXVwuIjwvdGV4dGFyZWE+PGJyPiI7aToyNjk7czozMToiXCRyYW5kX3dyaXRhYmxlX2ZvbGRlcl9mdWxscGF0aCI7aToyNzA7czoxMToiRHJcLmFib2xhbGgiO2k6MjcxO3M6NjoiSyFMTDNyIjtpOjI3MjtzOjk6InYwbGQzbTBydCI7aToyNzM7czo3OiJNckhhemVtIjtpOjI3NDtzOjExOiJDMGRlcnpcLmNvbSI7aToyNzU7czoyNjoiT0xCOlBST0RVQ1Q6T05MSU5FX0JBTktJTkciO2k6Mjc2O3M6MTA6IkJZIE1NTkJPQloiO2k6Mjc3O3M6MTY6IkNvbm5lY3RCYWNrU2hlbGwiO2k6Mjc4O3M6ODoiSGFja2VhZG8iO2k6Mjc5O3M6NToiZDNiflgiO2k6MjgwO3M6NToicmFodWkiO2k6MjgxO3M6MTA6Ik1yXC5IaVRtYW4iO2k6MjgyO3M6NjoiU0VvRE9SIjtpOjI4MztzOjExOiJNcmxvb2xcLmV4ZSI7aToyODQ7czoyNzoiU21hbGwgUEhQIFdlYiBTaGVsbCBieSBaYUNvIjtpOjI4NTtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6Mjg2O3M6MTM6IldTTzIgV2Vic2hlbGwiO2k6Mjg3O3M6MTI6IldlYiBTaGVsbCBieSI7aToyODg7czozMjoiV2F0Y2ggWW91ciBzeXN0ZW0gU2hhbnkgd2FzIGhlcmUiO2k6Mjg5O3M6Mjg6ImRldmVsb3BlZCBieSBEaWdpdGFsIE91dGNhc3QiO2k6MjkwO3M6MTE6IldlYkNvbnRyb2xzIjtpOjI5MTtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjI5MjtzOjk6IlczRCBTaGVsbCI7aToyOTM7czo5OiJUaGVfQmVLaVIiO2k6Mjk0O3M6MTE6IlN0b3JtN1NoZWxsIjtpOjI5NTtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjI5NjtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToyOTc7czoyNToiU2ltb3JnaCBTZWN1cml0eSBNYWdhemluZSI7aToyOTg7czoxOToiRy1TZWN1cml0eSBXZWJzaGVsbCI7aToyOTk7czoyNToiU2ltcGxlIFBIUCBiYWNrZG9vciBieSBESyI7aTozMDA7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MzAxO3M6MjA6IlNhZmVfTW9kZSBCeXBhc3MgUEhQIjtpOjMwMjtzOjk6IkNyenlfS2luZyI7aTozMDM7czoyMToiS0Fkb3QgVW5pdmVyc2FsIFNoZWxsIjtpOjMwNDtzOjE2OiJSdTI0UG9zdFdlYlNoZWxsIjtpOjMwNTtzOjIwOiJyZWFsYXV0aD1TdkJEODVkSU51MyI7aTozMDY7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjMwNztzOjE1OiJyNTdzaGVsbFxcXC5waHAiO2k6MzA4O3M6NjoiUjU3U3FsIjtpOjMwOTtzOjU6InIwbmluIjtpOjMxMDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjMxMTtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjMxMjtzOjI3OiJQUFMgMVwuMCBwZXJsLWNnaSB3ZWIgc2hlbGwiO2k6MzEzO3M6NjoiUEhWYXl2IjtpOjMxNDtzOjM1OiJQSFAgU2hlbGwgaXMgYW5pbnRlcmFjdGl2ZSBQSFAtcGFnZSI7aTozMTU7czoxMzoicGhwUmVtb3RlVmlldyI7aTozMTY7czoyMDoiUEhQIEhWQSBTaGVsbCBTY3JpcHQiO2k6MzE3O3M6OToiUEhQSmFja2FsIjtpOjMxODtzOjMxOiJOZXdzIFJlbW90ZSBQSFAgU2hlbGwgSW5qZWN0aW9uIjtpOjMxOTtzOjIwOiJMT1RGUkVFIFBIUCBCYWNrZG9vciI7aTozMjA7czoyMToiYSBzaW1wbGUgcGhwIGJhY2tkb29yIjtpOjMyMTtzOjIxOiJQSVJBVEVTIENSRVcgV0FTIEhFUkUiO2k6MzIyO3M6MTg6IlBIQU5UQVNNQS0gTmVXIENtRCI7aTozMjM7czoyNjoiTyBCaVIgS1JBTCBUQUtMaVQgRURpbEVNRVoiO2k6MzI0O3M6MjA6Ik5JWCBSRU1PVEUgV0VCLVNIRUxMIjtpOjMyNTtzOjIxOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAiO2k6MzI2O3M6NzoiTmVvSGFjayI7aTozMjc7czoxNjoiSGFja2VkIGJ5IFNpbHZlciI7aTozMjg7czo4OiJOM3RzaGVsbCI7aTozMjk7czoxNDoiTXlTUUwgV2Vic2hlbGwiO2k6MzMwO3M6Mjc6Ik15U1FMIFdlYiBJbnRlcmZhY2UgVmVyc2lvbiI7aTozMzE7czoxOToiTXlTUUwgV2ViIEludGVyZmFjZSI7aTozMzI7czo5OiJNeVNRTCBSU1QiO2k6MzMzO3M6MTY6IlwkTXlTaGVsbFZlcnNpb24iO2k6MzM0O3M6MTY6Ik1vcm9jY2FuIFNwYW1lcnMiO2k6MzM1O3M6MTA6Ik1hdGFtdSBNYXQiO2k6MzM2O3M6NToibTBoemUiO2k6MzM3O3M6NjoibTBydGl4IjtpOjMzODtzOjQ5OiJPcGVuIHRoZSBmaWxlIGF0dGFjaG1lbnQgaWYgYW55LGFuZCBiYXNlNjRfZW5jb2RlIjtpOjMzOTtzOjEwOiJNYXRhbXUgTWF0IjtpOjM0MDtzOjM2OiJNb3JvY2NhbiBTcGFtZXJzIE1hLUVkaXRpb04gQnkgR2hPc1QiO2k6MzQxO3M6MTE6IkxvY3VzN1NoZWxsIjtpOjM0MjtzOjc6IkxpejB6aU0iO2k6MzQzO3M6OToiS0FfdVNoZWxsIjtpOjM0NDtzOjExOiJpTUhhQmlSTGlHaSI7aTozNDU7czozMjoiSGFja2VybGVyIFZ1cnVyIExhbWVybGVyIFN1cnVudXIiO2k6MzQ2O3M6MTc6IkhBQ0tFRCBCWSBSRUFMV0FSIjtpOjM0NztzOjI1OiJIYWNrZWQgQnkgRGV2ci1pIE1lZnNlZGV0IjtpOjM0ODtzOjMxOiJoNG50dSBzaGVsbCBcW3Bvd2VyZWQgYnkgdHNvaVxdIjtpOjM0OTtzOjE0OiJHcmluYXkgR28wb1wkRSI7aTozNTA7czoxNDoiR29vZzFlX2FuYWxpc3QiO2k6MzUxO3M6MTE6IkdIQyBNYW5hZ2VyIjtpOjM1MjtzOjEzOiJHRlMgV2ViLVNoZWxsIjtpOjM1MztzOjIyOiJ0aGlzIGlzIGEgcHJpdjMgc2VydmVyIjtpOjM1NDtzOjI3OiJMdXRmZW4gRG9zeWF5aSBBZGxhbmRpcmluaXoiO2k6MzU1O3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aTozNTY7czoyMDoiRml4ZWQgYnkgQXJ0IE9mIEhhY2siO2k6MzU3O3M6MjA6IkVtcGVyb3IgSGFja2luZyBURUFNIjtpOjM1ODtzOjMyOiJDb21hbmRvcyBFeGNsdXNpdm9zIGRvIERUb29sIFBybyI7aTozNTk7czoxNToiRGV2ci1pIE1lZnNlZGV0IjtpOjM2MDtzOjMzOiJEaXZlIFNoZWxsIC0gRW1wZXJvciBIYWNraW5nIFRlYW0iO2k6MzYxO3M6MjQ6IlNoZWxsIHdyaXR0ZW4gYnkgQmwwb2QzciI7aTozNjI7czoxNDoiRGFya0RldmlselwuaU4iO2k6MzYzO3M6NzoiZDBtYWlucyI7aTozNjQ7czoxMToiQ3liZXIgU2hlbGwiO2k6MzY1O3M6MjM6IlRFQU0gU0NSSVBUSU5HIC0gUk9ETk9DIjtpOjM2NjtzOjEyOiJDcnlzdGFsU2hlbGwiO2k6MzY3O3M6Mzg6IkNvZGVkIGJ5IDogU3VwZXItQ3J5c3RhbCBhbmQgTW9oYWplcjIyIjtpOjM2ODtzOjIwOiJjb29raWVuYW1lPSJ3aWVlZWVlIiI7aTozNjk7czo5OiJDOTkgU2hlbGwiO2k6MzcwO3M6MTg6IlwkYzk5c2hfdXBkYXRlZnVybCI7aTozNzE7czoyMjoiQzk5IE1vZGlmaWVkIEJ5IFBzeWNoMCI7aTozNzI7czoxMDoiYzIwMDdcLnBocCI7aTozNzM7czozMDoiV3JpdHRlbiBieSBDYXB0YWluIENydW5jaCBUZWFtIjtpOjM3NDtzOjExOiJkZXZpbHpTaGVsbCI7aTozNzU7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjM3NjtzOjc6IkJsMG9kM3IiO2k6Mzc3O3M6MjI6IkNvZGVkIEJ5IENoYXJsaWNoYXBsaW4iO2k6Mzc4O3M6OToiYVpSYWlMUGhQIjtpOjM3OTtzOjE2OiJBU1BYIFNoZWxsIGJ5IExUIjtpOjM4MDtzOjEyOiJBTEVNaU4gS1JBTGkiO2k6MzgxO3M6MTQ6IkFudGljaGF0IHNoZWxsIjtpOjM4MjtzOjY6IjB4ZGQ4MiI7aTozODM7czo5OiJ+IFNoZWxsIEkiO2k6Mzg0O3M6MTQ6Il9zaGVsbF9hdGlsZGlfIjtpOjM4NTtzOjE2OiJQXC5oXC5wXC5TXC5wXC55IjtpOjM4NjtzOjEzOiIxXC4xNzlcLjI0OVwuIjtpOjM4NztzOjE0OiI2NFwuMjMzXC4xNjBcLiI7aTozODg7czo4OiJIYXJjaGFMaSI7aTozODk7czoxMjoiNjRcLjY4XC44MFwuIjtpOjM5MDtzOjEzOiJmb3BvXC5jb21cLmFyIjtpOjM5MTtzOjE0OiIyMTZcLjIzOVwuMzJcLiI7aTozOTI7czo4OiJORzY4OVNrdyI7aTozOTM7czo4OiJSNHBINHgwciI7aTozOTQ7czo1OiJINHhPciI7aTozOTU7czoxNToiPT09Ojo6bWFkOjo6PT09IjtpOjM5NjtzOjEzOiJhbmRyb2lkLWlncmEtIjtpOjM5NztzOjE3OiI8dGl0bGU+RW1zUHJveHkgdiI7fQ=="));
$gX_DBShe = unserialize(base64_decode("YTo2NDp7aTowO3M6ODoiYXJ0aWNrbGUiO2k6MTtzOjg6IkZpbGVzTWFuIjtpOjI7czo5OiJCTEFDS1VOSVgiO2k6MztzOjk6InIzdjNuZzRucyI7aTo0O3M6MjI6InJvb3Q6eDowOjA6cm9vdDovcm9vdDoiO2k6NTtzOjk6IkNlbmdpekhhbiI7aTo2O3M6MTA6IkppbnBhbnRvbXoiO2k6NztzOjE0OiJLaW5nU2tydXBlbGxvcyI7aTo4O3M6OToiMW43M2N0MTBuIjtpOjk7czoxMDoiSmlucGFudG9teiI7aToxMDtzOjk6IkRlaWRhcmF+WCI7aToxMTtzOjE2OiJNclwuU2hpbmNoYW5YMTk2IjtpOjEyO3M6MTQ6Ik1leGljYW5IYWNrZXJzIjtpOjEzO3M6MTU6IkhBQ0tFRCBCWSBTVE9STSI7aToxNDtzOjc6IktrSzEzMzciO2k6MTU7czo3OiJrMmxsMzNkIjtpOjE2O3M6MTU6IkRhcmtDcmV3RnJpZW5kcyI7aToxNztzOjExOiJTaW1BdHRhY2tlciI7aToxODtzOjE4OiJcXVxbcm91bmRcKDBcKVxdXCgiO2k6MTk7czozNDoiPCEtLVwjZXhlYyBjbWQ9IlwkSFRUUF9BQ0NFUFQiIC0tPiI7aToyMDtzOjQ6IkFtIXIiO2k6MjE7czoxMDoiXFtjb2RlcnpcXSI7aToyMjtzOjEzOiJcWyBQaHByb3h5IFxdIjtpOjIzO3M6NzoiRGVmYWNlciI7aToyNDtzOjExOiJEZXZpbEhhY2tlciI7aToyNTtzOjc6IndlYnIwMHQiO2k6MjY7czo3OiJrMGRcLmNjIjtpOjI3O3M6NTg6ImlzX2NhbGxhYmxlXCgnZXhlYydcKSBhbmQgIWluX2FycmF5XCgnZXhlYycsXCRkaXNhYmxlZnVuY3MiO2k6Mjg7czoxNjoiXCRHTE9CQUxTXFsnX19fXyI7aToyOTtzOjE5OiJpc193cml0YWJsZVwoIi92YXIvIjtpOjMwO3M6MjU6ImV2YWxcKGZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MzE7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aTozMjtzOjUzOiInaHR0cGRcLmNvbmYnLCd2aG9zdHNcLmNvbmYnLCdjZmdcLnBocCcsJ2NvbmZpZ1wucGhwJyI7aTozMztzOjc6ImJyMHdzM3IiO2k6MzQ7czo3OiJtaWx3MHJtIjtpOjM1O3M6NDE6ImluY2x1ZGVcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXVwpIjtpOjM2O3M6MTA6ImRpciAvT0cgL1giO2k6Mzc7czozNToiaWZcKFwoXCRwZXJtcyAmIDB4QzAwMFwpPT0weEMwMDBcKXsiO2k6Mzg7czo2NToiaWZcKGlzX2NhbGxhYmxlXCgiZXhlYyJcKSBhbmQgIWluX2FycmF5XCgiZXhlYyIsXCRkaXNhYmxlZnVuY1wpXCkiO2k6Mzk7czo0MDoic2V0Y29va2llXCgibXlzcWxfd2ViX2FkbWluX3VzZXJuYW1lIlwpOyI7aTo0MDtzOjE5OiJwcmludCAiU3BhbWVkJz48YnI+IjtpOjQxO3M6NTE6IlwkbWVzc2FnZT1lcmVnX3JlcGxhY2VcKCIlNUMlMjIiLCIlMjIiLFwkbWVzc2FnZVwpOyI7aTo0MjtzOjE4OiJOZSB1ZGFsb3MgemFncnV6aXQiO2k6NDM7czoxNToiZXhlY1woInJtIC1yIC1mIjtpOjQ0O3M6ODoiU2hlbGwgT2siO2k6NDU7czoxMToibXlzaGVsbGV4ZWMiO2k6NDY7czo5OiJyb290c2hlbGwiO2k6NDc7czo5OiJhbnRpc2hlbGwiO2k6NDg7czoxMzoicjU3c2hlbGxcLnBocCI7aTo0OTtzOjExOiJMb2N1czdTaGVsbCI7aTo1MDtzOjExOiJTdG9ybTdTaGVsbCI7aTo1MTtzOjg6Ik4zdHNoZWxsIjtpOjUyO3M6MTE6ImRldmlselNoZWxsIjtpOjUzO3M6MTI6IldlYiBTaGVsbCBieSI7aTo1NDtzOjc6IkZ4Yzk5c2giO2k6NTU7czo4OiJjaWhzaGVsbCI7aTo1NjtzOjc6Ik5URGFkZHkiO2k6NTc7czo4OiJyNTdzaGVsbCI7aTo1ODtzOjg6ImM5OXNoZWxsIjtpOjU5O3M6NjI6IjxkaXYgY2xhc3M9ImJsb2NrIGJ0eXBlMSI+PGRpdiBjbGFzcz0iZHRvcCI+PGRpdiBjbGFzcz0iZGJ0bSI+IjtpOjYwO3M6OToiUm9vdFNoZWxsIjtpOjYxO3M6ODoicGhwc2hlbGwiO2k6NjI7czoyNDoiWW91IGNhbiBwdXQgYSBtZDUgc3RyaW5nIjtpOjYzO3M6NzoiZGVmYWNlciI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNzU6e2k6MDtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjE7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aToyO3M6NTg6ImZ1bmN0aW9uXHMrcmVhZF9waWNcKFxzKlwkQVxzKlwpXHMqe1xzKlwkYVxzKj1ccypcJF9TRVJWRVIiO2k6MztzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjQ7czo2MjoibGlzdFxzKlwoXHMqXCRob3N0XHMqLFxzKlwkcG9ydFxzKixccypcJHNpemVccyosXHMqXCRleGVjX3RpbWUiO2k6NTtzOjQxOiJsaXN0aW5nX3BhZ2VcKFxzKm5vdGljZVwoXHMqWyciXXN5bWxpbmtlZCI7aTo2O3M6MzU6Im1ha2VfZGlyX2FuZF9maWxlXChccypcJHBhdGhfam9vbWxhIjtpOjc7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjg7czo0MToiJiZccyohZW1wdHlcKFxzKlwkX0NPT0tJRVxbWyciXWZpbGxbJyJdXF0iO2k6OTtzOjMzOiJmaWxlX2V4aXN0c1xzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6MTA7czo1OToic3RyX3JlcGxhY2VcKFwkZmluZFxzKixccypcJGZpbmRccypcLlxzKlwkaHRtbFxzKixccypcJHRleHQiO2k6MTE7czozNjoiXCRkYXRhbWFzaWk9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjEyO3M6MzQ6IlwkYWRkZGF0ZT1kYXRlXCgiRCBNIGQsIFkgZzppIGEiXCkiO2k6MTM7czoxODoiZnVja1xzK3lvdXJccyttYW1hIjtpOjE0O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE1O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MTY7czoyODoiYXJyYXlcKFwkZW4sXCRlcyxcJGVmLFwkZWxcKSI7aToxNztzOjQ2OiJsb2Nccyo9XHMqWyciXXswLDF9PFw/ZWNob1xzK1wkcmVkaXJlY3Q7XHMqXD8+IjtpOjE4O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjE5O3M6MTg6Ij09MFwpe2pzb25RdWl0XChcJCI7aToyMDtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIxO3M6MzA6Ijo6WyciXVwucGhwdmVyc2lvblwoXClcLlsnIl06OiI7aToyMjtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMztzOjEzOiIiPT5cJHtcJHsiXFx4IjtpOjI0O3M6NDI6ImZzb2Nrb3BlblwoXCRtXFswXF0sXCRtXFsxMFxdLFwkXyxcJF9fLFwkbSI7aToyNTtzOjMzOiJlVmFMXChccyp0cmltXChccypiYVNlNjRfZGVDb0RlXCgiO2k6MjY7czo0NjoiZWNob1xzKm1kNVwoXCRfUE9TVFxbWyciXXswLDF9Y2hlY2tbJyJdezAsMX1cXSI7aToyNztzOjI1OiJpbWcgc3JjPVsnIl1vcGVyYTAwMFwucG5nIjtpOjI4O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6Mjk7czo0MDoic3Vic3RyX2NvdW50XChnZXRlbnZcKFxcWyciXUhUVFBfUkVGRVJFUiI7aTozMDtzOjMxOiJ3ZWJpXC5ydS93ZWJpX2ZpbGVzL3BocF9saWJtYWlsIjtpOjMxO3M6NjU6ImNocjI9XChcKGVuYzImMTVcKTw8NFwpXHxcKGVuYzM+PjJcKTtjaHIzPVwoXChlbmMzJjNcKTw8NlwpXHxlbmM0IjtpOjMyO3M6MTI6IlJFUkVGRVJfUFRUSCI7aTozMztzOjk6InRzb2hfcHR0aCI7aTozNDtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MzU7czo0NzoibW1jcnlwdFwoXCRkYXRhLCBcJGtleSwgXCRpdiwgXCRkZWNyeXB0ID0gRkFMU0UiO2k6MzY7czoyMDoic3ByYXZvY2huaWstbm9tZXJvdi0iO2k6Mzc7czoxODoiaWNxLWRseWEtdGVsZWZvbmEtIjtpOjM4O3M6MTc6InRlbGVmb25uYXlhLWJhemEtIjtpOjM5O3M6MjY6InNsZXNoXCtzbGVzaFwrZG9tZW5cK3BvaW50IjtpOjQwO3M6MjI6InNyYz0iZmlsZXNfc2l0ZS9qc1wuanMiO2k6NDE7czo5NToiXCR0PVwkcztccypcJG9ccyo9XHMqWyciXVsnIl07XHMqZm9yXChcJGk9MDtcJGk8c3RybGVuXChcJHRcKTtcJGlcK1wrXCl7XHMqXCRvXHMqXC49XHMqXCR0e1wkaX0iO2k6NDI7czo4MDoiV0JTX0RJUlxzKlwuXHMqWyciXXswLDF9dGVtcC9bJyJdezAsMX1ccypcLlxzKlwkYWN0aXZlRmlsZVxzKlwuXHMqWyciXXswLDF9XC50bXAiO2k6NDM7czo1MToiQCptYWlsXChcJG1vc0NvbmZpZ19tYWlsZnJvbSwgXCRtb3NDb25maWdfbGl2ZV9zaXRlIjtpOjQ0O3M6NjY6IlwkW2EtekEtWjAtOV9dKz8vXCouezEsMTB9XCovXHMqXC5ccypcJFthLXpBLVowLTlfXSs/L1wqLnsxLDEwfVwqLyI7aTo0NTtzOjE3OiJAXCRfUE9TVFxbXChjaHJcKCI7aTo0NjtzOjMzOiI8XD9waHBccytyZW5hbWVcKFsnIl13c29cLnBocFsnIl0iO2k6NDc7czo1MjoiXCRzdHI9WyciXXswLDF9PGgxPjQwM1xzK0ZvcmJpZGRlbjwvaDE+PCEtLVxzKnRva2VuOiI7aTo0ODtzOjUwOiJjaHVua19zcGxpdFwoYmFzZTY0X2VuY29kZVwoZnJlYWRcKFwke1wke1snIl17MCwxfSI7aTo0OTtzOjYwOiJpbmlfZ2V0XChbJyJdezAsMX1maWx0ZXJcLmRlZmF1bHRfZmxhZ3NbJyJdezAsMX1cKVwpe2ZvcmVhY2giO2k6NTA7czozODoiZmlsZV9nZXRfY29udGVudHNcKHRyaW1cKFwkZlxbXCRfR0VUXFsiO2k6NTE7czoxMzM6Im1haWxcKFwkYXJyXFtbJyJdezAsMX10b1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1zdWJqWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfW1zZ1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1oZWFkWyciXXswLDF9XF1cKTsiO2k6NTI7czo1NDoiaWZcKGlzc2V0XChcJF9QT1NUXFtbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XF1cKVwpIjtpOjUzO3M6MzU6ImJhc2U2NF9kZWNvZGVcKFwkX1BPU1RcW1snIl17MCwxfV8tIjtpOjU0O3M6NTM6InJlZ2lzdGVyX3NodXRkb3duX2Z1bmN0aW9uXChccypbJyJdezAsMX1yZWFkX2Fuc19jb2RlIjtpOjU1O3M6NzU6IlwkcGFyYW1ccyo9XHMqXCRwYXJhbVxzKnhccypcJG5cLnN1YnN0clxzKlwoXCRwYXJhbVxzKixccypsZW5ndGhcKFwkcGFyYW1cKSI7aTo1NjtzOjI0OiJiYXNlWyciXXswLDF9XC5cKDMyXCoyXCkiO2k6NTc7czo2NjoiaWZcKEBcJHZhcnNcKGdldF9tYWdpY19xdW90ZXNfZ3BjXChcKVxzKlw/XHMqc3RyaXBzbGFzaGVzXChcJHVyaVwpIjtpOjU4O3M6Mjk6IlwpXF07fWlmXChpc3NldFwoXCRfU0VSVkVSXFtfIjtpOjU5O3M6NDI6ImlmXChlbXB0eVwoXCRfQ09PS0lFXFtbJyJdeFsnIl1cXVwpXCl7ZWNobyI7aTo2MDtzOjUyOiJpc193cml0YWJsZVwoXCRkaXJcLlsnIl13cC1pbmNsdWRlcy92ZXJzaW9uXC5waHBbJyJdIjtpOjYxO3M6MjE6IkFwcGxlXHMrU3BBbVxzK1JlWnVsVCI7aTo2MjtzOjE4OiJcI1xzKnN0ZWFsdGhccypib3QiO2k6NjM7czoyMzoiXCNccypzZWN1cml0eXNwYWNlXC5jb20iO2k6NjQ7czoyODoiVVJMPTxcP2VjaG9ccytcJGluZGV4O1xzK1w/PiI7aTo2NTtzOjk1OiI8c2NyaXB0XHMrdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccytzcmM9WyciXXswLDF9anF1ZXJ5LXVcLmpzWyciXXswLDF9Pjwvc2NyaXB0PiI7aTo2NjtzOjU3OiJjcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFxzKlwkb3B0XFsxXF1ccypcLlxzKlwkb3B0XFs0XF0iO2k6Njc7czo1MDoiZmlsZV9wdXRfY29udGVudHNcKFNWQ19TRUxGXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6Njg7czo1MToiXCRhbGxlbWFpbHNccyo9XHMqQHNwbGl0XCgiXFxuIlxzKixccypcJGVtYWlsbGlzdFwpIjtpOjY5O3M6MTg6Ikpvb21sYV9icnV0ZV9Gb3JjZSI7aTo3MDtzOjM4OiJcJHN5c19wYXJhbXNccyo9XHMqQCpmaWxlX2dldF9jb250ZW50cyI7aTo3MTtzOjM1OiJmd3JpdGVccypcKFxzKlwkZmx3XHMqLFxzKlwkZmxccypcKSI7aTo3MjtzOjg2OiJmaWxlX3B1dF9jb250ZW50c1xzKlwoWyciXXswLDF9MVwudHh0WyciXXswLDF9XHMqLFxzKnByaW50X3JccypcKFxzKlwkX1BPU1RccyosXHMqdHJ1ZSI7aTo3MztzOjgwOiJcJGhlYWRlcnNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWhlYWRlcnNbJyJdezAsMX1cXSI7aTo3NDtzOjQ0OiJjcmVhdGVfZnVuY3Rpb25ccypcKFsnIl1bJyJdXHMqLFxzKnN0cl9yb3QxMyI7aTo3NTtzOjMzOiJkaWVccypcKFxzKlBIUF9PU1xzKlwuXHMqY2hyXHMqXCgiO2k6NzY7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo3NztzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aTo3ODtzOjQxOiJjb250ZW50PVsnIl17MCwxfTE7VVJMPWNnaS1iaW5cLmh0bWxcP2NtZCI7aTo3OTtzOjYzOiJcJHVybFsnIl17MCwxfVxzKlwuXHMqXCRzZXNzaW9uX2lkXHMqXC5ccypbJyJdezAsMX0vbG9naW5cLmh0bWwiO2k6ODA7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aTo4MTtzOjQyOiJmc29ja29wZW5ccypcKFxzKlwkQ29ubmVjdEFkZHJlc3NccyosXHMqMjUiO2k6ODI7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6ODM7czo3NzoicHJlZ19tYXRjaFwoWyciXS9cKHlhbmRleFx8Z29vZ2xlXHxib3RcKS9pWyciXSxccypnZXRlbnZcKFsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6ODQ7czo1MjoiXCRtYWlsZXJccyo9XHMqXCRfUE9TVFxbWyciXXswLDF9eF9tYWlsZXJbJyJdezAsMX1cXSI7aTo4NTtzOjU3OiJcJE9PTzBPME8wMD1fX0ZJTEVfXztccypcJE9PMDBPMDAwMFxzKj1ccyoweDFiNTQwO1xzKmV2YWwiO2k6ODY7czoxMjoiQnlccytXZWJSb29UIjtpOjg3O3M6ODA6ImhlYWRlclwoWyciXXswLDF9czpccypbJyJdezAsMX1ccypcLlxzKnBocF91bmFtZVxzKlwoXHMqWyciXXswLDF9blsnIl17MCwxfVxzKlwpIjtpOjg4O3M6NzM6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcW1snIl17MCwxfWVsaWZbJyJdezAsMX1cXVxbWyciXXswLDF9dG1wX25hbWUiO2k6ODk7czo2MjoiXCRnemlwXHMqPVxzKkAqZ3ppbmZsYXRlXHMqXChccypAKnN1YnN0clxzKlwoXHMqXCRnemVuY29kZV9hcmciO2k6OTA7czo4MzoiaWZccypcKFxzKm1haWxccypcKFxzKlwkbWFpbHNcW1wkaVxdXHMqLFxzKlwkdGVtYVxzKixccypiYXNlNjRfZW5jb2RlXHMqXChccypcJHRleHQiO2k6OTE7czo4NDoiZndyaXRlXHMqXChccypcJGZoXHMqLFxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjkyO3M6OTQ6ImVjaG9ccytmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqYmFzZTY0X3VybF9kZWNvZGVccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6OTM7czo2MDoiaWZccypcKFxzKkAqbWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjk0O3M6OTk6ImNoclxzKlwoXHMqMTAxXHMqXClccypcLlxzKmNoclxzKlwoXHMqMTE4XHMqXClccypcLlxzKmNoclxzKlwoXHMqOTdccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMDhccypcKSI7aTo5NTtzOjE1MjoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXHMqXCkiO2k6OTY7czo3NToiXCRyZXN1bHRGVUxccyo9XHMqc3RyaXBjc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9cmVzdWx0RlVMWyciXXswLDF9IjtpOjk3O3M6MTU6Ii91c3Ivc2Jpbi9odHRwZCI7aTo5ODtzOjMyOiJQUklWTVNHXC5cKjpcLm93bmVyXFxzXCtcKFwuXCpcKSI7aTo5OTtzOjgzOiJwcmludFxzK1wkc29ja1xzK1snIl17MCwxfU5JQ0sgWyciXXswLDF9XHMrXC5ccytcJG5pY2tccytcLlxzK1snIl17MCwxfVxcblsnIl17MCwxfSI7aToxMDA7czo4MDoiXCR1cmxccyo9XHMqXCR1cmxccypcLlxzKlsnIl17MCwxfVw/WyciXXswLDF9XHMqXC5ccypodHRwX2J1aWxkX3F1ZXJ5XChcJHF1ZXJ5XCkiO2k6MTAxO3M6MTIzOiJwcmVnX21hdGNoX2FsbFwoWyciXXswLDF9LzxhIGhyZWY9IlxcL3VybFxcXD9xPVwoXC5cK1w/XClcWyZcfCJcXVwrL2lzWyciXXswLDF9LCBcJHBhZ2VcW1snIl17MCwxfWV4ZVsnIl17MCwxfVxdLCBcJGxpbmtzXCkiO2k6MTAyO3M6MTAxOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9WyciXXswLDF9SmF2YVNjcmlwdFsnIl17MCwxfT5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovLyI7aToxMDM7czo3ODoiXCRwXHMqPVxzKnN0cnBvc1xzKlwoXHMqXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjEwNDtzOjE1OiJcKG1zaWVcfG9wZXJhXCkiO2k6MTA1O3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6MTA2O3M6OTk6ImlmXHMqXChccyppc19kaXJccypcKFxzKlwkRnVsbFBhdGhccypcKVxzKlwpXHMqQWxsRGlyXHMqXChccypcJEZ1bGxQYXRoXHMqLFxzKlwkRmlsZXNccypcKTtccyp9XHMqfSI7aToxMDc7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjEwODtzOjU0OiI8IS0tXCNleGVjXHMrY21kPVsnIl17MCwxfVwkSFRUUF9BQ0NFUFRbJyJdezAsMX1ccyotLT4iO2k6MTA5O3M6MjY6IlxbLVxdXHMrQ29ubmVjdGlvblxzK2ZhaWxkIjtpOjExMDtzOjYzOiJpZlwoL1xeXFw6XCRvd25lciFcLlwqXFxAXC5cKlBSSVZNU0dcLlwqOlwubXNnZmxvb2RcKFwuXCpcKS9cKXsiO2k6MTExO3M6MzQ6InByaW50XHMqXCRzb2NrICJQUklWTVNHICJcLlwkb3duZXIiO2k6MTEyO3M6NjQ6IlxdPVsnIl17MCwxfWlwWyciXXswLDF9XHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfU0VSVkVSXFsiO2k6MTEzO3M6NTE6IlxdXHMqfVxzKj1ccyp0cmltXHMqXChccyphcnJheV9wb3BccypcKFxzKlwke1xzKlwkeyI7aToxMTQ7czozMToicHJpbnRcKCJcI1xzK2luZm9ccytPS1xcblxcbiJcKSI7aToxMTU7czoxMTI6IlwkdXNlcl9hZ2VudFxzKj1ccypwcmVnX3JlcGxhY2VccypcKFxzKlsnIl1cfFVzZXJcXFwuQWdlbnRcXDpcW1xccyBcXVw/XHxpWyciXVxzKixccypbJyJdWyciXVxzKixccypcJHVzZXJfYWdlbnQiO2k6MTE2O3M6NzI6IlwkcFxzKj1ccypzdHJwb3NcKFwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxMTc7czo5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChccypbJyJdXCRtWyciXVxzKixccypbJyJdaWZccypcKFxzKlwkbVxzKlxbXHMqMHgwMVxzKlxdXHMqPT1ccypbJyJdTFsnIl0iO2k6MTE4O3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjExOTtzOjk6IklySXNUXC5JciI7aToxMjA7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMjE7czozMjoiXCRwb3N0XHMqPVxzKlsnIl1cXHg3N1xceDY3XFx4NjUiO2k6MTIyO3M6Mjc6ImVjaG9ccypbJyJdYW5zd2VyPWVycm9yWyciXSI7aToxMjM7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMjQ7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEyNTtzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMjY7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEyNztzOjUyOiJlY2hvWyciXXswLDF9PGNlbnRlcj48Yj5Eb25lXHMqPT0+XHMqXCR1c2VyZmlsZV9uYW1lIjtpOjEyODtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTI5O3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTMwO3M6NTE6IlwpXHMqXC5ccypzdWJzdHJccypcKFxzKm1kNVxzKlwoXHMqc3RycmV2XHMqXChccypcJCI7aToxMzE7czo2NToiXCRmbFxzKj1ccyoiPG1ldGEgaHR0cC1lcXVpdj1cXCJSZWZyZXNoXFwiXHMrY29udGVudD1cXCIwO1xzKlVSTD0iO2k6MTMyO3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMzM7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTM0O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjEzNTtzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTM2O3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjEzNztzOjY1OiJ1cmxlbmNvZGVcKHByaW50X3JcKGFycmF5XChcKSwxXClcKSw1LDFcKVwuY1wpLFwkY1wpO31ldmFsXChcJGRcKSI7aToxMzg7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTM5O3M6NDM6ImZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDQwMDBccystbHMiO2k6MTQwO3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjE0MTtzOjQxOiJmdW5jdGlvblxzK2luamVjdFwoXCRmaWxlLFxzKlwkaW5qZWN0aW9uPSI7aToxNDI7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTQzO3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjE0NDtzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTQ1O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxNDY7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aToxNDc7czozOToiZXZhbFxzKlwoKlxzKnN0cnJldlxzKlwoKlxzKnN0cl9yZXBsYWNlIjtpOjE0ODtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjE0OTtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjE1MDtzOjIzMjoiaXNzZXRccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccyppc191cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqY29weVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXSI7aToxNTE7czo4NzoiaWZccypcKFxzKlwkaVxzKjxccypcKFxzKmNvdW50XHMqXChccypcJF9QT1NUXFtccypbJyJdezAsMX1xWyciXXswLDF9XHMqXF1ccypcKVxzKi1ccyoxIjtpOjE1MjtzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjE1MztzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTU0O3M6OTc6ImNvbnRlbnQ9WyciXXswLDF9bm8tY2FjaGVbJyJdezAsMX07XHMqXCRjb25maWdcW1snIl17MCwxfWRlc2NyaXB0aW9uWyciXXswLDF9XF1ccypcLj1ccypbJyJdezAsMX0iO2k6MTU1O3M6NzQ6ImNsZWFyc3RhdGNhY2hlXChccypcKTtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRmbGRccypcKVxzKlwpXHMqcmV0dXJuIjtpOjE1NjtzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjE1NztzOjk6IklyU2VjVGVhbSI7aToxNTg7czo3MzoiQGhlYWRlclwoWyciXUxvY2F0aW9uOlxzKlsnIl1cLlsnIl1oWyciXVwuWyciXXRbJyJdXC5bJyJddFsnIl1cLlsnIl1wWyciXSI7aToxNTk7czo2Nzoic2V0X3RpbWVfbGltaXRccypcKFxzKjBccypcKTtccyppZlxzKlwoIVNlY3JldFBhZ2VIYW5kbGVyOjpjaGVja0tleSI7aToxNjA7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTYxO3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxNjI7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6MTYzO3M6NDc6InN0cl9yb3QxM1xzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE2NDtzOjUwOiJnenVuY29tcHJlc3NccypcKFxzKnN0cl9yb3QxM1xzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToxNjU7czo1MDoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJfcm90MTMiO2k6MTY2O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzXHMqXChccypzdHJyZXYiO2k6MTY3O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2XHMqXChccypzdHJfcm90MTMiO2k6MTY4O3M6NDQ6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2IjtpOjE2OTtzOjY4OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzA7czo1NDoiYmFzZTY0X2RlY29kZVxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE3MTtzOjQ3OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzI7czo0NzoiZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTczO3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjE3NDtzOjYwOiJcJHRsZFxzKj1ccyphcnJheVxzKlwoXHMqWyciXWNvbVsnIl0sWyciXW9yZ1snIl0sWyciXW5ldFsnIl0iO2k6MTc1O3M6NDU6ImRlZmluZVxzKlwoKlxzKlsnIl1TQkNJRF9SRVFVRVNUX0ZJTEVbJyJdXHMqLCI7aToxNzY7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aToxNzc7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6MTc4O3M6MzM6ImRlZmluZVxzKlwoXHMqWyciXURFRkNBTExCQUNLTUFJTCI7aToxNzk7czo0NzoiZGVmYXVsdF9hY3Rpb25ccyo9XHMqWyciXXswLDF9RmlsZXNNYW5bJyJdezAsMX0iO2k6MTgwO3M6Mzg6ImVjaG9ccytAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkZ2V0IjtpOjE4MTtzOjE1NjoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyosXHMqWyciXXswLDF9QW5kcm9pZFsnIl17MCwxfVwpXHMqIT09ZmFsc2VccyomJlxzKiFcJF9DT09LSUVcW1snIl17MCwxfWRsZV91c2VyX2lkIjtpOjE4MjtzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6MTgzO3M6MTA6IkRjMFJIYVsnIl0iO2k6MTg0O3M6MzY6IiF0b3VjaFwoWyciXXswLDF9XC5cLi9cLlwuL2xhbmd1YWdlLyI7aToxODU7czozODoiZXZhbFwoXHMqc3RyaXBzbGFzaGVzXChccypcXFwkX1JFUVVFU1QiO2k6MTg2O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aToxODc7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aToxODg7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aToxODk7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6MTkwO3M6ODc6IiYmXHMqZnVuY3Rpb25fZXhpc3RzXHMqXCgqXHMqWyciXXswLDF9Z2V0bXhyclsnIl17MCwxfVwpXHMqXClccyp7XHMqQGdldG14cnJccypcKCpccypcJCI7aToxOTE7czo1NzoiaXNfX3dyaXRhYmxlXHMqXCgqXHMqXCRwYXRoXHMqXC5ccyp1bmlxaWRccypcKCpccyptdF9yYW5kIjtpOjE5MjtzOjI4OiJmaWxlX3B1dF9jb250ZW50elxzKlwoKlxzKlwkIjtpOjE5MztzOjU1OiJAKmd6aW5mbGF0ZVxzKlwoXHMqQCpiYXNlNjRfZGVjb2RlXHMqXChccypAKnN0cl9yZXBsYWNlIjtpOjE5NDtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjE5NTtzOjQzOiJAXCRfQ09PS0lFXFtbJyJdezAsMX1zdGF0Q291bnRlclsnIl17MCwxfVxdIjtpOjE5NjtzOjM1OiJpZlxzKlwoKlxzKkAqcHJlZ19tYXRjaFxzKlwoKlxzKnN0ciI7aToxOTc7czo5NDoiYXJyYXlfcG9wXHMqXCgqXHMqXCR3b3JrUmVwbGFjZVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKixccypcJGNvdW50S2V5c05ldyI7aToxOTg7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjE5OTtzOjIzOiJcKFxzKlsnIl1JTlNIRUxMWyciXVxzKiI7aToyMDA7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6MjAxO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6MjAyO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aToyMDM7czoxMjM6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cXlwod3d3XHxmdHBcKVxcXC4vaVsnIl1ccyosXHMqWyciXVsnIl0sXHMqQFwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XHMqXF1ccypcKSI7aToyMDQ7czoyNjE6ImlmXHMqXCgqXHMqaXNzZXRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9W2EtekEtWl8wLTldK1snIl17MCwxfVxzKlxdXHMqXCkqXHMqXClccyp7XHMqXCRbYS16QS1aXzAtOV0rXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF07XHMqZXZhbFxzKlwoKlxzKlwkW2EtekEtWl8wLTldK1xzKlwpKiI7aToyMDU7czo4MToiZXZhbFxzKlwoKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFwoKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjIwNjtzOjEzOToiaWZccytcKFxzKnN0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL21vb3Rvb2xzXC5qc1snIl1ccypcKVxzKj09PVxzKmZhbHNlXHMrJiZccytzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9jYXB0aW9uXC5qc1snIl17MCwxfSI7aToyMDc7czo2ODoiaWZccytcKCpccyptYWlsXHMqXChccypcJHJlY3BccyosXHMqXCRzdWJqXHMqLFxzKlwkc3R1bnRccyosXHMqXCRmcm0iO2k6MjA4O3M6NDM6IjxcP3BocFxzK1wkX0Zccyo9XHMqX19GSUxFX19ccyo7XHMqXCRfWFxzKj0iO2k6MjA5O3M6Nzk6IlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0iO2k6MjEwO3M6MTE1OiJcJGJlZWNvZGVccyo9QCpmaWxlX2dldF9jb250ZW50c1xzKlwoKlsnIl17MCwxfVxzKlwkdXJscHVyc1xzKlsnIl17MCwxfVwpKlxzKjtccyplY2hvXHMrWyciXXswLDF9XCRiZWVjb2RlWyciXXswLDF9IjtpOjIxMTtzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6MjEyO3M6NzM6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqXFsuKz9cXVw/L2VbJyJdezAsMX1ccyosXHMqc3RyX3JlcGxhY2UiO2k6MjEzO3M6MTQ5OiJcJEdMT0JBTFNcW1snIl17MCwxfS4rP1snIl17MCwxfVxdPUFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKSI7aToyMTQ7czoyMDA6IlVOSU9OXHMrU0VMRUNUXHMrWyciXXswLDF9MFsnIl17MCwxfVxzKixccypbJyJdezAsMX08XD8gc3lzdGVtXChcXFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtjcGNcXVwpO2V4aXQ7XHMqXD8+WyciXXswLDF9XHMqLFxzKjBccyosMFxzKixccyowXHMqLFxzKjBccytJTlRPXHMrT1VURklMRVxzK1snIl17MCwxfVwkWyciXXswLDF9IjtpOjIxNTtzOjY2OiJpc3NldFxzKlwoKlxzKlwkX1BPU1RccypcW1xzKlsnIl17MCwxfWV4ZWNnYXRlWyciXXswLDF9XHMqXF1ccypcKSoiO2k6MjE2O3M6NzE6ImZ3cml0ZVxzKlwoKlxzKlwkZnBzZXR2XHMqLFxzKmdldGVudlxzKlwoXHMqWyciXUhUVFBfQ09PS0lFWyciXVxzKlwpXHMqIjtpOjIxNztzOjI2OiJzeW1saW5rXHMqXCgqXHMqWyciXS9ob21lLyI7aToyMTg7czo3MDoiZnVuY3Rpb25ccyt1cmxHZXRDb250ZW50c1xzKlwoKlxzKlwkdXJsXHMqLFxzKlwkdGltZW91dFxzKj1ccypcZCtccypcKSI7aToyMTk7czo0OToic3RycmV2XCgqXHMqWyciXXswLDF9ZWRvY2VkXzQ2ZXNhYlsnIl17MCwxfVxzKlwpKiI7aToyMjA7czo0Mjoic3RycmV2XCgqXHMqWyciXXswLDF9dHJlc3NhWyciXXswLDF9XHMqXCkqIjtpOjIyMTtzOjIwOiJleGVjXHMqXChccypbJyJdaXBmdyI7aToyMjI7czoxMzY6IndwX3Bvc3RzXHMrV0hFUkVccytwb3N0X3R5cGVccyo9XHMqWyciXXswLDF9cG9zdFsnIl17MCwxfVxzK0FORFxzK3Bvc3Rfc3RhdHVzXHMqPVxzKlsnIl17MCwxfXB1Ymxpc2hbJyJdezAsMX1ccytPUkRFUlxzK0JZXHMrYElEYFxzK0RFU0MiO2k6MjIzO3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjIyNDtzOjIxMzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjIyNTtzOjI0OiJcJEdMT0JBTFNcW1snIl17MCwxfV9fX18iO2k6MjI2O3M6NDM6ImZvcGVuXHMqXCgqXHMqWyciXXswLDF9L2V0Yy9wYXNzd2RbJyJdezAsMX0iO2k6MjI3O3M6NTk6ImV2YWxccypcKCpAKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFxzKlwoKlxzKkAqXCRfIjtpOjIyODtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aToyMjk7czo3NDoiQCpzZXRjb29raWVccypcKCpccypbJyJdezAsMX1oaXRbJyJdezAsMX0sXHMqMVxzKixccyp0aW1lXHMqXCgqXHMqXCkqXHMqXCsiO2k6MjMwO3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aToyMzE7czo0NjoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCovZVsnIl17MCwxfSI7aToyMzI7czo4MToiXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqXF1ccyp9IjtpOjIzMztzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjIzNDtzOjMzOiJwcm9jX29wZW5ccypcKFxzKlsnIl17MCwxfUlIU3RlYW0iO2k6MjM1O3M6ODg6IlwkaW5pXHMqXFtccypbJyJdezAsMX11c2Vyc1snIl17MCwxfVxzKlxdXHMqPVxzKmFycmF5XHMqXChccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqPT4iO2k6MjM2O3M6ODg6ImN1cmxfc2V0b3B0XHMqXChccypcJGNoXHMqLFxzKkNVUkxPUFRfVVJMXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly9cJGhvc3Q6XGQrWyciXXswLDF9XHMqXCkiO2k6MjM3O3M6NDU6InN5c3RlbVxzKlwoKlxzKlsnIl17MCwxfXdob2FtaVsnIl17MCwxfVxzKlwpKiI7aToyMzg7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyMzk7czo1MjoiYXNzZXJ0XHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNDA7czo1MDoiZXZhbFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjQxO3M6MjU6InBocFxzKyJccypcLlxzKlwkd3NvX3BhdGgiO2k6MjQyO3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjI0MztzOjIxOiJldmExW2EtekEtWjAtOV9dKz9TaXIiO2k6MjQ0O3M6OTM6IlwkY21kXHMqPVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccypcKSI7aToyNDU7czo5NjoiXCRmdW5jdGlvblxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfWNtZFsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjI0NjtzOjIzOiJcJGZlXCgiXCRjbWRccysyPiYxIlwpOyI7aToyNDc7czoxNDE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyNDg7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6MjQ5O3M6ODY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXVuYW1lXHMrLWFbJyJdXHMqXCkqIjtpOjI1MDtzOjEyNDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkX1BPU1RccypcW1xzKlsnIl0uKz9bJyJdXHMqXF1ccypcLlxzKiJccyoyXHMqPlxzKiYxXHMqWyciXSI7aToyNTE7czo0OToiIUAqXCRfUkVRVUVTVFxzKlxbXHMqWyciXWM5OXNoX3N1cmxbJyJdXHMqXF1ccypcKSI7aToyNTI7czozNzoiXCRsb2dpblxzKj1ccypAKnBvc2l4X2dldHVpZFwoKlxzKlwpKiI7aToyNTM7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyNTQ7czo4MjoicnVuY29tbWFuZFxzKlwoXHMqWyciXXNoZWxsaGVscFsnIl1ccyosXHMqWyciXShHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXSI7aToyNTU7czo1NToie1xzKlwkXHMqe1xzKnBhc3N0aHJ1XHMqXCgqXHMqXCRjbWRccypcKVxzKn1ccyp9XHMqPGJyPiI7aToyNTY7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyNTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MjU4O3M6ODc6IlNFTEVDVFxzKzFccytGUk9NXHMrbXlzcWxcLnVzZXJccytXSEVSRVxzK2NvbmNhdFwoXHMqYHVzZXJgXHMqLFxzKidAJ1xzKixccypgaG9zdGBccypcKSI7aToyNTk7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToyNjA7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MjYxO3M6NzQ6ImZpbGVwYXRoXHMqPVxzKkAqcmVhbHBhdGhccypcKFxzKlwkX1BPU1RccypcW1xzKlsnIl1maWxlcGF0aFsnIl1ccypcXVxzKlwpIjtpOjI2MjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MjYzO3M6NDA6ImV2YWxccypcKCpccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8iO2k6MjY0O3M6MTA3OiJ3c29FeFxzKlwoXHMqXFxbJyJdXHMqdGFyXHMqY2Z6dlxzKlxcWyciXVxzKlwuXHMqZXNjYXBlc2hlbGxhcmdccypcKFxzKlwkX1BPU1RcW1xzKlxcWyciXXAyXFxbJyJdXHMqXF1ccypcKSI7aToyNjU7czo3NDoiV1NPc2V0Y29va2llXHMqXChccyptZDVccypcKFxzKkAqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9IT1NUWyciXVxzKlxdXHMqXCkiO2k6MjY2O3M6Nzg6IldTT3NldGNvb2tpZVxzKlwoXHMqbWQ1XHMqXChccypAKlwkX1NFUlZFUlxbXHMqXFxbJyJdSFRUUF9IT1NUXFxbJyJdXHMqXF1ccypcKSI7aToyNjc7czoxNzA6IlwkaW5mbyBcLj0gXChcKFwkcGVybXNccyomXHMqMHgwMDQwXClccypcP1woXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccypcXFsnIl1zXFxbJyJdXHMqOlxzKlxcWyciXXhcXFsnIl1ccypcKVxzKjpcKFwoXCRwZXJtc1xzKiZccyoweDA4MDBcKVxzKlw/XHMqJ1MnXHMqOlxzKictJ1xzKlwpIjtpOjI2ODtzOjM1OiJkZWZhdWx0X2FjdGlvblxzKj1ccypcXFsnIl1GaWxlc01hbiI7aToyNjk7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjI3MDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjI3MTtzOjExOiJieVxzK0dyaW5heSI7aToyNzI7czoyMzoiQ2FwdGFpblxzK0NydW5jaFxzK1RlYW0iO2k6MjczO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyNzQ7czoxMDA6IklPOjpTb2NrZXQ6OklORVQtPm5ld1woUHJvdG9ccyo9PlxzKiJ0Y3AiXHMqLFxzKkxvY2FsUG9ydFxzKj0+XHMqMzYwMDBccyosXHMqTGlzdGVuXHMqPT5ccypTT01BWENPTk4iO30="));
$gX_FlexDBShe = unserialize(base64_decode("YToyOTA6e2k6MDtzOjQ5OiJmaWxlX3B1dF9jb250ZW50c1woRElSXC5bJyJdL1snIl1cLlsnIl1pbmRleFwucGhwIjtpOjE7czo5MzoiXCRwcFxzKj1ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdIjtpOjI7czo0ODoiaWZcKFxzKmlzSW5TdHJpbmcxKlwoXCRbYS16QS1aMC05X10rPyxbJyJdZ29vZ2xlIjtpOjM7czo2MjoiY2hyXChccypcJFthLXpBLVowLTlfXSs/XHMqXCk7XHMqfVxzKmV2YWxcKFxzKlwkW2EtekEtWjAtOV9dKz8iO2k6NDtzOjQxOiJcJFthLXpBLVowLTlfXSs/PXN0cl9yZXBsYWNlXChbJyJdXCphXCRcKiI7aTo1O3M6MjI6ImV4cGxvaXRccyo6OlwuPC90aXRsZT4iO2k6NjtzOjEwODoiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJGpxXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjc7czo2ODoiXCRbYS16QS1aMC05X10rPz09WyciXWZlYXR1cmVkWyciXVxzKlwpXHMqXCl7XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGUiO2k6ODtzOjk6ImFydGlja2xlQCI7aTo5O3M6Mzk6IlsnIl13cC1bJyJdXHMqXC5ccypnZW5lcmF0ZVJhbmRvbVN0cmluZyI7aToxMDtzOjQ5OiJyZXR1cm5ccytbJyJdL2hvbWUvW2EtekEtWjAtOV9dKz8vW2EtekEtWjAtOV9dKz8vIjtpOjExO3M6NTc6IlwkW2EtekEtWjAtOV9dKz89WyciXS9ob21lL1thLXpBLVowLTlfXSs/L1thLXpBLVowLTlfXSs/LyI7aToxMjtzOjQwOiJoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vXCRwcFwub3JnIjtpOjEzO3M6OTk6IkBcJF9DT09LSUVcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVwoXHMqQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXHMqXClccypcKSI7aToxNDtzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjE1O3M6MzQ6IkVkaXRIdGFjY2Vzc1woXHMqWyciXVJld3JpdGVFbmdpbmUiO2k6MTY7czoxMToiXCRwYXRoVG9Eb3IiO2k6MTc7czoyMjoiZnVuY3Rpb25ccyttYWlsZXJfc3BhbSI7aToxODtzOjM4OiJlY2hvXHMrc2hvd19xdWVyeV9mb3JtXChccypcJHNxbHN0cmluZyI7aToxOTtzOjQzOiJcJHN0YXR1c19jcmVhdGVfZ2xvYl9maWxlXHMqPVxzKmNyZWF0ZV9maWxlIjtpOjIwO3M6NDM6ImZ1bmN0aW9uXHMrZmluZEhlYWRlckxpbmVccypcKFxzKlwkdGVtcGxhdGUiO2k6MjE7czo2MDoiYWdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXXswLDF9bWVzWyciXVxdIjtpOjIyO3M6MjY6ImZpbGVzaXplXChccypcJHB1dF9rX2ZhaWx1IjtpOjIzO3M6NTk6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRpclxzKlwuXHMqXCRmaWxlXHMqXC5ccypbJyJdL2luZGV4IjtpOjI0O3M6NDM6ImlmXHMqXChccypAZmlsZXR5cGVcKFwkbGVhZG9uXHMqXC5ccypcJGZpbGUiO2k6MjU7czozNzoiZXZhbFwoXHMqXCR7XHMqXCRbYS16QS1aMC05X10rP1xzKn1cWyI7aToyNjtzOjI4OiJ0b3VjaFwoXHMqXCR0aGlzLT5jb25mLT5yb290IjtpOjI3O3M6NTY6InByZWdfbWF0Y2hcKFxzKlsnIl17MCwxfX5Mb2NhdGlvbjpcKFwuXCpcP1wpXChcPzpcXG5cfFwkIjtpOjI4O3M6NDk6ImZsdXNoX2VuZF9maWxlXChccypcJGZpbGVuYW1lXHMqLFxzKlwkZmlsZWNvbnRlbnQiO2k6Mjk7czozMzoiaWZcKFxzKnN0cmlwb3NcKFxzKlsnIl1cKlwqXCpcJHVhIjtpOjMwO3M6NjY6IlwkdGFibGVcW1wkc3RyaW5nXFtcJGlcXVxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjJcKVxzKlwrXHMqXCR0YWJsZSI7aTozMTtzOjQ4OiJnZVxzKj1ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkX1BPU1RccypcW1snIl1tZXMiO2k6MzI7czo0ODoiXCRQT1NUX1NUUlxzKj1ccypmaWxlX2dldF9jb250ZW50c1woInBocDovL2lucHV0IjtpOjMzO3M6MzM6Ilwkc3RhdHVzX2xvY19zaFxzKj1ccypmaWxlX2V4aXN0cyI7aTozNDtzOjk5OiJcJGluZGV4XHMqPVxzKnN0cl9yZXBsYWNlXChccypbJyJdPFw/cGhwXHMqb2JfZW5kX2ZsdXNoXChcKTtccypcPz5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkaW5kZXgiO2k6MzU7czoxMDc6Imlzc2V0XChccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxzKlxkK1xzKlwpXHMqXF1ccypcKVxzKlw/XHMqXCRfU0VSVkVSXFtccypfXGQrXChcZCtcKVxzKlxdXHMqOlxzKl9cZCtcKFxkK1wpIjtpOjM2O3M6Mzg6Ij09XHMqMFwpXHMqe1xzKmVjaG9ccypQSFBfT1NccypcLlxzKlwkIjtpOjM3O3M6NDk6ImlmXChccyp0cnVlXHMqJlxzKkBwcmVnX21hdGNoXChccypzdHJ0clwoXHMqWyciXS8iO2k6Mzg7czo4NDoiaWZcKFxzKiFlbXB0eVwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9dHAyWyciXXswLDF9XHMqXF1cKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjM5O3M6NDc6Imd6dW5jb21wcmVzc1woXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl1odHRwIjtpOjQwO3M6MTk4OiJcYihwZXJjb2NldHxhZGRlcmFsbHx2aWFncmF8Y2lhbGlzfGxldml0cmF8a2F1ZmVufGFtYmllbnxibHVlXHMrcGlsbHxjb2NhaW5lfG1hcmlqdWFuYXxsaXBpdG9yfHBoZW50ZXJtaW58cHJvW3N6XWFjfHNhbmR5YXVlcnx0cmFtYWRvbHx0cm95aGFtYnl1bHRyYW18dW5pY2F1Y2F8dmFsaXVtfHZpY29kaW58eGFuYXh8eXB4YWllbylccytvbmxpbmUiO2k6NDE7czoyMjoiZGlzYWJsZV9mdW5jdGlvbnM9Tk9ORSI7aTo0MjtzOjIxOiImX1NFU1NJT05cW3BheWxvYWRcXT0iO2k6NDM7czoyNjoiPFw/XHMqPUBgXCRbYS16QS1aMC05X10rP2AiO2k6NDQ7czoxNjoiUEhQU0hFTExfVkVSU0lPTiI7aTo0NTtzOjY5OiJ0b3VjaFwoXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6NDY7czo4MToiZmlsZV9nZXRfY29udGVudHNcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjQ3O3M6NTY6IkBcJF9TRVJWRVJcW1xzKkhUVFBfSE9TVFxzKlxdPlsnIl1ccypcLlxzKlsnIl1cXHJcXG5bJyJdIjtpOjQ4O3M6NzE6InRyaW1cKFxzKlwkaGVhZGVyc1xzKlwpXHMqXClccyphc1xzKlwkaGVhZGVyXHMqXClccypoZWFkZXJcKFxzKlwkaGVhZGVyIjtpOjQ5O3M6MTY6IkNvZGVkXHMrYnlccytFWEUiO2k6NTA7czoxMjoiQnlccytXZWJSb29UIjtpOjUxO3M6MjA6ImhlYWRlclxzKlwoXHMqX1xkK1woIjtpOjUyO3M6NDE6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjUzO3M6Mjk6ImRvX3dvcmtcKFxzKlwkaW5kZXhfZmlsZVxzKlwpIjtpOjU0O3M6ODM6IlwkaWRccypcLlxzKlsnIl1cP2Q9WyciXVxzKlwuXHMqYmFzZTY0X2VuY29kZVwoXHMqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9VU0VSX0FHRU5UIjtpOjU1O3M6MjU6Im5ld1xzK2NvbmVjdEJhc2VcKFsnIl1hSFIiO2k6NTY7czo5MDoiZmlsZV9nZXRfY29udGVudHNcKFJPT1RfRElSXC5bJyJdL3RlbXBsYXRlcy9bJyJdXC5cJGNvbmZpZ1xbWyciXXNraW5bJyJdXF1cLlsnIl0vbWFpblwudHBsIjtpOjU3O3M6NTk6IiU8IS0tXFxzXCpcJG1hcmtlclxcc1wqLS0+XC5cK1w/PCEtLVxcc1wqL1wkbWFya2VyXFxzXCotLT4lIjtpOjU4O3M6MjQ6ImZ1bmN0aW9uXHMrZ2V0Zmlyc3RzaHRhZyI7aTo1OTtzOjE4OiJyZXN1bHRzaWduX3dhcm5pbmciO2k6NjA7czoyOToiZmlsZV9leGlzdHNcKFxzKlwkRmlsZUJhemFUWFQiO2k6NjE7czoxOToiPT1ccypbJyJdY3NoZWxsWyciXSI7aTo2MjtzOjYxOiJcJF9TRVJWRVJcW1snIl17MCwxfVJFTU9URV9BRERSWyciXXswLDF9XF07aWZcKFwocHJlZ19tYXRjaFwoIjtpOjYzO3M6Njc6IlwkZmlsZV9mb3JfdG91Y2hccyo9XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NjQ7czoyMzoiXCRpbmRleF9wYXRoXHMqLFxzKjA0MDQiO2k6NjU7czozMDoicmVhZF9maWxlX25ld18yXChcJHJlc3VsdF9wYXRoIjtpOjY2O3M6Mzg6ImNoclwoXHMqaGV4ZGVjXChccypzdWJzdHJcKFxzKlwkbWFrZXVwIjtpOjY3O3M6Mjc6IlxkKyZAcHJlZ19tYXRjaFwoXHMqc3RydHJcKCI7aTo2ODtzOjc1OiJ2YWx1ZT1bJyJdPFw/XHMrKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl0iO2k6Njk7czoxODoiQWNhZGVtaWNvXHMrUmVzdWx0IjtpOjcwO3M6MzA6IlNFTEVDVFxzK1wqXHMrRlJPTVxzK2Rvcl9wYWdlcyI7aTo3MTtzOjQxOiJnX2RlbGV0ZV9vbl9leGl0XHMqPVxzKm5ld1xzK0RlbGV0ZU9uRXhpdCI7aTo3MjtzOjUzOiJpZlwocHJlZ19tYXRjaFwoWyciXVwjd29yZHByZXNzX2xvZ2dlZF9pblx8YWRtaW5cfHB3ZCI7aTo3MztzOjUwOiJbJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXSI7aTo3NDtzOjI4OiJcKTtmdW5jdGlvblxzK3N0cmluZ19jcHRcKFwkIjtpOjc1O3M6Mjg6Ilwkc2V0Y29va1wpO3NldGNvb2tpZVwoXCRzZXQiO2k6NzY7czozNToiPGxvYz48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybDsiO2k6Nzc7czo0MDoiXCRiYW5uZWRJUFxzKj1ccyphcnJheVwoXHMqWyciXVxeNjZcLjEwMiI7aTo3ODtzOjYyOiJcJHJlc3VsdD1zbWFydENvcHlcKFxzKlwkc291cmNlXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkZmlsZSI7aTo3OTtzOjM4OiJcJGZpbGwgPSBcJF9DT09LSUVcW1xcWyciXWZpbGxcXFsnIl1cXSI7aTo4MDtzOjgzOiJpZlwoWyciXXN1YnN0cl9jb3VudFwoWyciXVwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXHMqLFxzKlsnIl1xdWVyeVwucGhwWyciXSI7aTo4MTtzOjg1OiJpZlwoXHMqXCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0hPVxzKlsnIl1bJyJdXHMqXClccypcJGlkPVwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIjtpOjgyO3M6MjI6IjxhXHMraHJlZj1bJyJdb3NoaWJrYS0iO2k6ODM7czo3NjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1jZFxzKy90bXA7d2dldCI7aTo4NDtzOjU1OiJnZXRwcm90b2J5bmFtZVwoXHMqWyciXXRjcFsnIl1ccypcKVxzK1x8XHxccytkaWVccytzaGl0IjtpOjg1O3M6NDc6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjg2O3M6NjY6IixccypbJyJdL2luZGV4XFxcLlwocGhwXHxodG1sXCkvaVsnIl1ccyosXHMqUmVjdXJzaXZlUmVnZXhJdGVyYXRvciI7aTo4NztzOjEzOiJBT0xccytEZXRhaWxzIjtpOjg4O3M6MjA6InRIQU5Lc1xzK3RPXHMrU25vcHB5IjtpOjg5O3M6MjA6Ik1hc3IxXHMrQ3liM3JccytUZTRtIjtpOjkwO3M6MTg6IlVzM1xzK1kwdXJccyticjQxbiI7aTo5MTtzOjIwOiJNYXNyaVxzK0N5YmVyXHMrVGVhbSI7aTo5MjtzOjQ5OiJmd3JpdGVcKFwkZnBccyosXHMqc3RycmV2XChccypcJGNvbnRleHRccypcKVxzKlwpIjtpOjkzO3M6OToiL3BtdC9yYXYvIjtpOjk0O3M6MzQ6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdL3Zhci90bXAiO2k6OTU7czoyMzoiXCRpbl9QZXJtc1xzKyZccysweDQwMDAiO2k6OTY7czo0MzoiZm9wZW5cKFxzKlwkcm9vdF9kaXJccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTo5NztzOjYyOiJpbnQzMlwoXChcKFwkelxzKj4+XHMqNVxzKiZccyoweDA3ZmZmZmZmXClccypcXlxzKlwkeVxzKjw8XHMqMiI7aTo5ODtzOjM1OiI8Z3VpZD48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybCI7aTo5OTtzOjE5OiIta2x5Y2gtay1pZ3JlXC5odG1sIjtpOjEwMDtzOjY2OiI8ZGl2XHMraWQ9WyciXWxpbmsxWyciXT48YnV0dG9uIG9uY2xpY2s9WyciXXByb2Nlc3NUaW1lclwoXCk7WyciXT4iO2k6MTAxO3M6MTE6InNjb3BiaW5bJyJdIjtpOjEwMjtzOjE0OiItQXBwbGVfUmVzdWx0LSI7aToxMDM7czo0NzoidGFyXHMrLWN6ZlxzKyJccypcLlxzKlwkRk9STXt0YXJ9XHMqXC5ccyoiXC50YXIiO2k6MTA0O3M6MTQ6IkNWVjI6XHMqXCRDVlYyIjtpOjEwNTtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6MTA2O3M6NzU6ImZ3cml0ZVwoXHMqXCRmXHMqLFxzKmdldF9kb3dubG9hZFwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxMDc7czozMzoiXFtcXVxzKj1ccypbJyJdUmV3cml0ZUVuZ2luZVxzK29uIjtpOjEwODtzOjk4OiJzdWJzdHJcKFxzKlwkc3RyaW5nMlxzKixccypzdHJsZW5cKFxzKlwkc3RyaW5nMlxzKlwpXHMqLVxzKjlccyosXHMqOVwpXHMqPT1ccypbJyJdezAsMX1cW2wscj0zMDJcXSI7aToxMDk7czoxMzoiPWJ5XHMrRFJBR09OPSI7aToxMTA7czo0MDoiX19maWxlX2dldF91cmxfY29udGVudHNcKFxzKlwkcmVtb3RlX3VybCI7aToxMTE7czo4MjoiXCRVUkxccyo9XHMqXCR1cmxzXFtccypyYW5kXChccyowXHMqLFxzKmNvdW50XChccypcJHVybHNccypcKVxzKi1ccyoxXClccypcXVwucmFuZCI7aToxMTI7czo0OToibWFpbFwoXHMqXCRyZXRvcm5vXHMqLFxzKlwkYXN1bnRvXHMqLFxzKlwkbWVuc2FqZSI7aToxMTM7czo3ODoiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl1hY3Rpb25bJyJdXHMqXC5ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjExNDtzOjM1OiJmaWxlX2V4aXN0c1woXHMqWyciXS90bXAvdG1wLXNlcnZlciI7aToxMTU7czoyNzoiXChbJyJdXCR0bXBkaXIvc2Vzc19mY1wubG9nIjtpOjExNjtzOjUyOiJ0b3VjaFwoXHMqWyciXXswLDF9XCRiYXNlcGF0aC9jb21wb25lbnRzL2NvbV9jb250ZW50IjtpOjExNztzOjQ2OiI9XCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjExODtzOjcyOiJzZW5kX3NtdHBcKFxzKlwkZW1haWxcW1snIl17MCwxfWFkclsnIl17MCwxfVxdXHMqLFxzKlwkc3VialxzKixccypcJHRleHQiO2k6MTE5O3M6MzQ6Il9fTElOS19fPGFccytocmVmPVsnIl17MCwxfWh0dHA6Ly8iO2k6MTIwO3M6NDQ6InNjcmlwdHNcW1xzKmd6dW5jb21wcmVzc1woXHMqYmFzZTY0X2RlY29kZVwoIjtpOjEyMTtzOjc4OiIhZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGJuYW1lXHMqLFxzKlwkdGhpcy0+Z2V0SW1hZ2VFbmNvZGVkVGV4dFwoXHMqXCRkYm5hbWUiO2k6MTIyO3M6MTE3OiJcJGNvbnRlbnRccyo9XHMqaHR0cF9yZXF1ZXN0XChbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XHMqXC5ccypcJF9TRVJWRVJcW1snIl17MCwxfVNFUlZFUl9OQU1FWyciXXswLDF9XF1cLlsnIl17MCwxfS8iO2k6MTIzO3M6NjA6Im1haWxcKFxzKlwkTWFpbFRvXHMqLFxzKlwkTWVzc2FnZVN1YmplY3RccyosXHMqXCRNZXNzYWdlQm9keSI7aToxMjQ7czozNjoiZmlsZV9wdXRfY29udGVudHNcKFxzKlsnIl17MCwxfS9ob21lIjtpOjEyNTtzOjcwOiJtYWlsXChccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdIjtpOjEyNjtzOjIzOiJpc193cml0YWJsZT1pc193cml0YWJsZSI7aToxMjc7czoyMzoiZXhwbG9pdC1kYlwuY29tL3NlYXJjaC8iO2k6MTI4O3M6MTQ6IkRhdmlkXHMqQmxhaW5lIjtpOjEyOTtzOjMzOiJjcm9udGFiXHMrLWxcfGdyZXBccystdlxzK2Nyb250YWIiO2k6MTMwO3M6ODA6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdezAsMX1hdFxzK25vd1xzKy1mIjtpOjEzMTtzOjY0OiJcIyEvYmluL3NobmNkXHMrWyciXXswLDF9WyciXXswLDF9XC5cJFNDUFwuWyciXXswLDF9WyciXXswLDF9bmlmIjtpOjEzMjtzOjQ0OiJmaWxlX3B1dF9jb250ZW50c1woWyciXXswLDF9XC4vbGlid29ya2VyXC5zbyI7aToxMzM7czozNjoiXCR1c2VyX2FnZW50X3RvX2ZpbHRlclxzKj1ccyphcnJheVwoIjtpOjEzNDtzOjIwOiJmb3BlblwoXHMqWyciXS9ob21lLyI7aToxMzU7czoyMDoibWtkaXJcKFxzKlsnIl0vaG9tZS8iO2k6MTM2O3M6NDA6IlwjVXNlWyciXXswLDF9XHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTM3O3M6Mjk6ImVyZWdpXChccypzcWxfcmVnY2FzZVwoXHMqXCRfIjtpOjEzODtzOjcxOiJcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkK1xzKlxdXChcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkKyI7aToxMzk7czozNjoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCQ8YW1jIjtpOjE0MDtzOjMzOiJAXCRmdW5jXChcJGNmaWxlLCBcJGNkaXJcLlwkY25hbWUiO2k6MTQxO3M6NjI6InVuYW1lXF1bJyJdezAsMX1ccypcLlxzKnBocF91bmFtZVwoXClccypcLlxzKlsnIl17MCwxfVxbL3VuYW1lIjtpOjE0MjtzOjU0OiJcJEdMT0JBTFNcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFxzKk5VTEwiO2k6MTQzO3M6MjM6Il9fdXJsX2dldF9jb250ZW50c1woXCRsIjtpOjE0NDtzOjI2OiJcJGRvcl9jb250ZW50PXByZWdfcmVwbGFjZSI7aToxNDU7czo3MzoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1sc1xzKy92YXIvbWFpbCI7aToxNDY7czozMDoiaGVhZGVyXChbJyJdezAsMX1yOlxzKm5vXHMrY29tIjtpOjE0NztzOjQ4OiJwcmVnX21hdGNoX2FsbFwoXHMqWyciXVx8XChcLlwqXCk8XFwhLS0ganMtdG9vbHMiO2k6MTQ4O3M6NDk6IkAqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkdGhpcy0+ZmlsZVxzKixccypzdHJyZXYiO2k6MTQ5O3M6NDE6Ii9wbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwIjtpOjE1MDtzOjkxOiJtYWlsXChccypzdHJpcHNsYXNoZXNcKFwkdG9cKVxzKixccypzdHJpcHNsYXNoZXNcKFwkc3ViamVjdFwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRtZXNzYWdlIjtpOjE1MTtzOjg1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9dXJbJyJdezAsMX1cXVwpXClccypcJG1vZGVccypcfD1ccyowNDAwIjtpOjE1MjtzOjgyOiJlcmVnX3JlcGxhY2VcKFsnIl17MCwxfSU1QyUyMlsnIl17MCwxfVxzKixccypbJyJdezAsMX0lMjJbJyJdezAsMX1ccyosXHMqXCRtZXNzYWdlIjtpOjE1MztzOjg4OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRuYW1lXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1NDtzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6MTU1O3M6ODk6Ilwkc2FwZV9vcHRpb25cW1xzKlsnIl17MCwxfWZldGNoX3JlbW90ZV90eXBlWyciXXswLDF9XHMqXF1ccyo9XHMqWyciXXswLDF9c29ja2V0WyciXXswLDF9IjtpOjE1NjtzOjEwNToiXCRwYXRoXHMqPVxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdXHMqXC5ccypbJyJdezAsMX0vaW1hZ2VzL3N0b3JpZXMvWyciXXswLDF9IjtpOjE1NztzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1ODtzOjIwOiJldmFsXHMqXChccypUUExfRklMRSI7aToxNTk7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6MTYwO3M6NDg6IlxzKlsnIl17MCwxfXNsdXJwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfW1zbmJvdCI7aToxNjE7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjE2MjtzOjExOiJDb3VwZGVncmFjZSI7aToxNjM7czoxMjoiU3VsdGFuSGFpa2FsIjtpOjE2NDtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6MTY1O3M6Mjc6Imh0dHBzOi8vYXBwbGVpZFwuYXBwbGVcLmNvbSI7aToxNjY7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aToxNjc7czozNDoiY3JjMzJcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfWNtZCI7aToxNjg7czoxOToiZ3JlcFxzKy12XHMrY3JvbnRhYiI7aToxNjk7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aToxNzA7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6MTcxO3M6MzI6ImV2YWxcKFsnIl1cPz5bJyJdXC5iYXNlNjRfZGVjb2RlIjtpOjE3MjtzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTczO3M6MTI6Im1pbHcwcm1cLmNvbSI7aToxNzQ7czo0NToiXCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE3NTtzOjM2OiJyZXR1cm5ccytiYXNlNjRfZGVjb2RlXChcJGFcW1wkaVxdXCkiO2k6MTc2O3M6NjA6InBsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAlM0ElMkYlMkZ3d3dcLmdvb2dsZSI7aToxNzc7czozNjoiY3JlYXRlX2Z1bmN0aW9uXChzdWJzdHJcKDIsMVwpLFwkc1wpIjtpOjE3ODtzOjgxOiJ0eXBlb2ZccypcKGRsZV9hZG1pblwpXHMqPT1ccypbJyJdezAsMX11bmRlZmluZWRbJyJdezAsMX1ccypcfFx8XHMqZGxlX2FkbWluXHMqPT0iO2k6MTc5O3M6MzI6IlxbXCRvXF1cKTtcJG9cK1wrXCl7aWZcKFwkbzwxNlwpIjtpOjE4MDtzOjMyOiJcJFNcW1wkaVwrXCtcXVwoXCRTXFtcJGlcK1wrXF1cKCI7aToxODE7czozNzoic2V0Y29va2llXChccypcJHpcWzBcXVxzKixccypcJHpcWzFcXSI7aToxODI7czo4NjoiL2luZGV4XC5waHBcP29wdGlvbj1jb21famNlJnRhc2s9cGx1Z2luJnBsdWdpbj1pbWdtYW5hZ2VyJmZpbGU9aW1nbWFuYWdlciZ2ZXJzaW9uPTE1NzYiO2k6MTgzO3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aToxODQ7czo0MToiaWZcKFxzKmlzc2V0XChccypcJF9SRVFVRVNUXFtbJyJdezAsMX1jaWQiO2k6MTg1O3M6NDA6InN0cl9yZXBsYWNlXHMqXChccypbJyJdezAsMX0vcHVibGljX2h0bWwiO2k6MTg2O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aToxODc7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjE4ODtzOjk0OiJpZlwoaXNfZGlyXChcJHBhdGhcLlsnIl17MCwxfS93cC1jb250ZW50WyciXXswLDF9XClccytBTkRccytpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWFkbWluIjtpOjE4OTtzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjE5MDtzOjk6ImJ5XHMrZzAwbiI7aToxOTE7czoxNToiQXV0b1xzKlhwbG9pdGVyIjtpOjE5MjtzOjEwMjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiIjtpOjE5MztzOjcyOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9Y21kXC5leGUiO2k6MTk0O3M6OToiQnlccytEWjI3IjtpOjE5NTtzOjI3OiJFdGhuaWNccytBbGJhbmlhblxzK0hhY2tlcnMiO2k6MTk2O3M6MjA6IlZvbGdvZ3JhZGluZGV4XC5odG1sIjtpOjE5NztzOjMyOiJcJF9Qb3N0XFtbJyJdezAsMX1TU05bJyJdezAsMX1cXSI7aToxOTg7czoxNToicGFja1xzKyJTbkE0eDgiIjtpOjE5OTtzOjE0OiJbJyJdezAsMX1EWmUxciI7aToyMDA7czoxMjoiVGVhTVxzK01vc1RhIjtpOjIwMTtzOjYzOiJpZlwobWFpbFwoXCRlbWFpbFxbXCRpXF0sXHMqXCRzdWJqZWN0LFxzKlwkbWVzc2FnZSxccypcJGhlYWRlcnMiO2k6MjAyO3M6MzY6InByaW50XHMrWyciXXswLDF9ZGxlX251bGxlZFsnIl17MCwxfSI7aToyMDM7czozOToiaWZccypcKGNoZWNrX2FjY1woXCRsb2dpbixcJHBhc3MsXCRzZXJ2IjtpOjIwNDtzOjM4OiJwcmVnX3JlcGxhY2VcKFwpe3JldHVyblxzK19fRlVOQ1RJT05fXyI7aToyMDU7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAKlwkX0NPT0tJRVxbIjtpOjIwNjtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6MjA3O3M6MTA4OiJmb3JcKFwkW2EtekEtWjAtOV9dKz89XGQrO1wkW2EtekEtWjAtOV9dKz88XGQrO1wkW2EtekEtWjAtOV9dKz8tPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSs/IT1cZCtcKVxzKmJyZWFrO30iO2k6MjA4O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjIwOTtzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjIxMDtzOjQyOiJpZlxzKlwoZnVuY3Rpb25fZXhpc3RzXChbJyJdc2Nhbl9kaXJlY3RvcnkiO2k6MjExO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjIxMjtzOjM4OiJaZW5kXHMrT3B0aW1pemF0aW9uXHMrdmVyXHMrMVwuMFwuMFwuMSI7aToyMTM7czoyNjoiaW5kZXhcLnBocFw/aWQ9XCQxJiV7UVVFUlkiO2k6MjE0O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjIxNTtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjIxNjtzOjI4OiJcJF9QT1NUXFtbJyJdezAsMX1zbXRwX2xvZ2luIjtpOjIxNztzOjM3OiJfWyciXXswLDF9XF1cWzJcXVwoWyciXXswLDF9TG9jYXRpb246IjtpOjIxODtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjIxOTtzOjE1OiI8IS0tXHMranMtdG9vbHMiO2k6MjIwO3M6NzoidWdnYzovLyI7aToyMjE7czo0NzoiaWYgXChkYXRlXChbJyJdezAsMX1qWyciXXswLDF9XClccyotXHMqXCRuZXdzaWQiO2k6MjIyO3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjIyMztzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjIyNDtzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aToyMjU7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aToyMjY7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6MjI3O3M6MTA0OiJzaXRlX2Zyb209WyciXXswLDF9XC5cJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxdXC5bJyJdezAsMX0mc2l0ZV9mb2xkZXI9WyciXXswLDF9XC5cJGZcWzFcXSI7aToyMjg7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aToyMjk7czozMzoicG9ydGxldHMvZnJhbWV3b3JrL3NlY3VyaXR5L2xvZ2luIjtpOjIzMDtzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aToyMzE7czo1MToiXCRkYXRhXHMqPVxzKmFycmF5XChbJyJdezAsMX10ZXJtaW5hbFsnIl17MCwxfVxzKj0+IjtpOjIzMjtzOjcwOiJzdHJwb3NcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XF0sXHMqWyciXXswLDF9Z29vZ2xlIjtpOjIzMztzOjcwOiJzdHJwb3NcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XF0sXHMqWyciXXswLDF9eWFuZGV4IjtpOjIzNDtzOjc3OiJzdHJpc3RyXChcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdLFxzKlsnIl17MCwxfVlhbmRleEJvdCI7aToyMzU7czo1MzoiZm9wZW5cKFsnIl17MCwxfVwuXC4vXC5cLi9cLlwuL1snIl17MCwxfVwuXCRmaWxlcGF0aHMiO2k6MjM2O3M6MzY6InByZWdfcmVwbGFjZVwoXHMqWyciXWVbJyJdLFsnIl17MCwxfSI7aToyMzc7czo0MDoiKFteXD9cc10pXCh7MCwxfVwuW1wrXCpdXCl7MCwxfVwyW2Etel0qZSI7aToyMzg7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MjM5O3M6MzU6InBocF9bJyJdXC5cJGV4dFwuWyciXVwuZGxsWyciXXswLDF9IjtpOjI0MDtzOjIwOiIvZVsnIl1ccyosXHMqWyciXVxceCI7aToyNDE7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6MjQyO3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjtpOjI0MztzOjQ0OiJhcnJheVwoXHMqWyciXUdvb2dsZVsnIl1ccyosXHMqWyciXVNsdXJwWyciXSI7aToyNDQ7czoxMjoiYW5kZXhcfG9vZ2xlIjtpOjI0NTtzOjI0OiJwYWdlX2ZpbGVzL3N0eWxlMDAwXC5jc3MiO2k6MjQ2O3M6MjE6Ij09WyciXVwpXCk7cmV0dXJuO1w/PiI7aToyNDc7czoxNjoiU3BhbVxzK2NvbXBsZXRlZCI7aToyNDg7czozNToiZWNob1xzK1snIl17MCwxfWluc3RhbGxfb2tbJyJdezAsMX0iO2k6MjQ5O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aToyNTA7czoxMToiQ1ZWOlxzKlwkY3YiO2k6MjUxO3M6MzA6ImN1cmxcLmhheHhcLnNlL3JmYy9jb29raWVfc3BlYyI7aToyNTI7czoxMjoia2lsbGFsbFxzKy05IjtpOjI1MztzOjU3OiJwcmVnX3JlcGxhY2VccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjU0O3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjU1O3M6MzA6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cLlwqLyI7aToyNTY7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly8iO2k6MjU3O3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDBccytodHRwOi8vIjtpOjI1ODtzOjI5OiJFcnJvckRvY3VtZW50XHMrNTAwXHMraHR0cDovLyI7aToyNTk7czoyODoiZ29vZ2xlXHx5YW5kZXhcfGJvdFx8cmFtYmxlciI7aToyNjA7czoyMToiZXZhbFxzKlwoXHMqc3RyX3JvdDEzIjtpOjI2MTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyNjI7czo0ODoiZnVuY3Rpb25ccypjaG1vZF9SXHMqXChccypcJHBhdGhccyosXHMqXCRwZXJtXHMqIjtpOjI2MztzOjMzOiJzeW1iaWFuXHxtaWRwXHx3YXBcfHBob25lXHxwb2NrZXQiO2k6MjY0O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MjY1O3M6NzI6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdLFxzKnRpbWVcKFwpXHMqXCtccyo4NjQwMCI7aToyNjY7czo3MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJdd2dldCI7aToyNjc7czozMzoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjI2ODtzOjMwOiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MjY5O3M6MjU6ImV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MjcwO3M6MzI6InN0cl9pcmVwbGFjZVxzKlwoKlxzKlsnIl08L2hlYWQ+IjtpOjI3MTtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjI3MjtzOjMxOiI9XHMqYXJyYXlfbWFwXHMqXCgqXHMqc3RycmV2XHMqIjtpOjI3MztzOjk6IlwkX19fXHMqPSI7aToyNzQ7czo0OToiZ3p1bmNvbXByZXNzXHMqXCgqXHMqc3Vic3RyXHMqXCgqXHMqYmFzZTY0X2RlY29kZSI7aToyNzU7czoyMzoiQWRkSGFuZGxlclxzK2NnaS1zY3JpcHQiO2k6Mjc2O3M6MjM6IkFkZEhhbmRsZXJccytwaHAtc2NyaXB0IjtpOjI3NztzOjE0NToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKSI7aToyNzg7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6Mjc5O3M6OTU6Imlzc2V0XChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKm9yXHMqZGllXCgqLis/XCkqIjtpOjI4MDtzOjU3OiJPcHRpb25zXHMrRm9sbG93U3ltTGlua3NccytNdWx0aVZpZXdzXHMrSW5kZXhlc1xzK0V4ZWNDR0kiO2k6MjgxO3M6MzI6ImlzX3dyaXRhYmxlXHMqXCgqXHMqWyciXS92YXIvdG1wIjtpOjI4MjtzOjk1OiJhZGRfZmlsdGVyXHMqXCgqXHMqWyciXXswLDF9dGhlX2NvbnRlbnRbJyJdezAsMX1ccyosXHMqWyciXXswLDF9X2Jsb2dpbmZvWyciXXswLDF9XHMqLFxzKi4rP1wpKiI7aToyODM7czoyOToiZXZhbFxzKlwoKlxzKmdldF9vcHRpb25ccypcKCoiO2k6Mjg0O3M6MTA0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcWyI7aToyODU7czoxMDc6ImlmXHMqXChccyppc19jYWxsYWJsZVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXCkqIjtpOjI4NjtzOjExNDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXswLDF9KGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKVxzKlwpIjtpOjI4NztzOjQwOiJldmFsXHMqXCgqXHMqZ3ppbmZsYXRlXHMqXCgqXHMqc3RyX3JvdDEzIjtpOjI4ODtzOjE5OiJyb3VuZFxzKlwoXHMqMFxzKlwrIjtpOjI4OTtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NzU6e2k6MDtzOjE4NToiPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF07XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX3B1dF9jb250ZW50c1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypmaWxlX2dldF9jb250ZW50c1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6MTtzOjE1MjoiYXJyYXlfbWFwXChccypbJyJdKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfbWFwKVsnIl0iO2k6MjtzOjYxOiJpZlwoXHMqXCRbYS16QS1aMC05X10rP1wpXHMqe1xzKmV2YWxcKFwkW2EtekEtWjAtOV9dKz9cKTtccyp9IjtpOjM7czoxMDg6Ij1ccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS4rP1snIl1cKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZvcGVuXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl13WyciXSI7aTo0O3M6NzM6InByZWdfcmVwbGFjZVwoXHMqWyciXS8uKz8vZVsnIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NTtzOjYyOiJjYWxsX3VzZXJfZnVuY1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XCk7fSI7aTo2O3M6NDA6InVybD1bJyJdaHR0cDovL3NjYW40eW91XC5uZXQvcmVtb3RlXC5waHAiO2k6NztzOjEwMjoiXCRfUE9TVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZm9wZW5cKFxzKlwkX0dFVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdIjtpOjg7czo0MjoiJXtIVFRQX1VTRVJfQUdFTlR9XHMrIXdpbmRvd3MtbWVkaWEtcGxheWVyIjtpOjk7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEwO3M6MjQ6IjwlZXZhbFwoXHMqUmVxdWVzdFwuSXRlbSI7aToxMTtzOjIzOiJzb2Nrc19zeXNyZWFkXChcJGNsaWVudCI7aToxMjtzOjMxOiItPnByZXBhcmVcKFsnIl1TSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6OTI6IlwuPVxzKmNoclwoXCRbYS16QS1aMC05X10rP1xzKj4+XHMqXChcZCtccypcKlxzKlwoXGQrXHMqLVxzKlwkW2EtekEtWjAtOV9dKz9cKVwpXHMqJlxzKlxkK1wpIjtpOjE0O3M6MTg2OiJpZlxzKlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClccyo9PT1ccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXCkiO2k6MTU7czozMDoiaGVhZGVyXChfW2EtekEtWjAtOV9dKz9cKFxkK1wpIjtpOjE2O3M6MTUzOiI7QCpcJFthLXpBLVowLTlfXSs/XCgoZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV9tYXApXCgiO2k6MTc7czoyMjoiZXZhbFwoW2EtekEtWjAtOV9dKz9cKCI7aToxODtzOjc1OiIkW2EtekEtWjAtOV9dXHtcZCtcfVxzKlwuJFthLXpBLVowLTlfXVx7XGQrXH1ccypcLiRbYS16QS1aMC05X11ce1xkK1x9XHMqXC4iO2k6MTk7czoyNzoiXCRHTE9CQUxTXFtuZXh0XF1cW1snIl1uZXh0IjtpOjIwO3M6MjA6InNsdXJwXHxtc25ib3RcfHRlb21hIjtpOjIxO3M6NTc6IkNvbnRlbnQtdHlwZTpccyphcHBsaWNhdGlvbi92bmRcLmFuZHJvaWRcLnBhY2thZ2UtYXJjaGl2ZSI7aToyMjtzOjU0OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwcyo6Ly9cZCtcLlxkK1wuXGQrXC5cZCsiO2k6MjM7czoxMDc6Ij1ccypjcmVhdGVfZnVuY3Rpb25ccypcKFxzKm51bGxccyosXHMqW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9cKFwpIjtpOjI0O3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aToyNTtzOjY3OiJcLlwkX1JFUVVFU1RcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVxzKixccyp0cnVlXHMqLFxzKjMwMlwpIjtpOjI2O3M6MTYzOiJcI1thLXpBLVowLTlfXSs/XCNccyppZlwoZW1wdHlcKFwkW2EtekEtWjAtOV9dKz9cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXTxzY3JpcHQuKz88L3NjcmlwdD5bJyJdO1xzKmVjaG9ccytcJFthLXpBLVowLTlfXSs/O1xzKn1ccypcIy9bYS16QS1aMC05X10rP1wjIjtpOjI3O3M6MTQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1wpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08L2h0bWw+WyciXSI7aToyODtzOjM3OiJcJHRleHRccyo9XHMqaHR0cF9nZXRcKFxzKlsnIl1odHRwOi8vIjtpOjI5O3M6MTA3OiJAaW5pX3NldFwoWyciXWVycm9yX2xvZ1snIl0sTlVMTFwpO1xzKkBpbmlfc2V0XChbJyJdbG9nX2Vycm9yc1snIl0sMFwpO1xzKmZ1bmN0aW9uXHMrcmVhZF9maWxlXChcJGZpbGVfbmFtZSI7aTozMDtzOjk1OiI9XHMqYmFzZTY0X2VuY29kZVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpO1xzKmhlYWRlciI7aTozMTtzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTozMjtzOjEwNzoiPVxzKm1haWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xkK1xdXHMqXClccyosXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRbYS16QS1aMC05X10rP1xbXGQrXF0iO2k6MzM7czo4MzoiXCRbYS16QS1aMC05X10rP1xzKj1ccypkZWNyeXB0X1NPXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl1bYS16QS1aMC05X10rP1snIl0iO2k6MzQ7czo1NjoiXCRbYS16QS1aMC05X10rPz11cmxkZWNvZGVcKFsnIl0uKz9bJyJdXCk7aWZcKHByZWdfbWF0Y2giO2k6MzU7czoxMToiPT1bJyJdXClcKTsiO2k6MzY7czoxMTA6ImlmXHMqXChccypmaWxlX2V4aXN0c1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXClccyp7XHMqY2htb2RcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqMFxkK1wpO1xzKn1ccyplY2hvIjtpOjM3O3M6Mzc6ImV2YWxcKFxzKlsnIl17XHMqXCRbYS16QS1aMC05X10rP1xzKn0iO2k6Mzg7czoxNTg6IihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X21hcClcKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkIjtpOjM5O3M6MzA6InJlYWRfZmlsZVwoXHMqWyciXWRvbWFpbnNcLnR4dCI7aTo0MDtzOjM5OiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVFxbXHMqWyciXXBpbmciO2k6NDE7czo5OToiXF1cKFsnIl1cJF9bJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdIjtpOjQyO3M6NTY6IkAqY3JlYXRlX2Z1bmN0aW9uXChccypbJyJdWyciXVxzKixccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjQzO3M6NDE6ImZ3cml0ZVwoXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdPFw/cGhwIjtpOjQ0O3M6MTQ1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHMqW2EtekEtWjAtOV9dKz9ccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSs/IjtpOjQ1O3M6MTc6IkdhbnRlbmdlcnNccytDcmV3IjtpOjQ2O3M6ODU6InJlY3Vyc2VfY29weVwoXHMqXCRzcmNccyosXHMqXCRkc3RccypcKTtccypoZWFkZXJcKFxzKlsnIl1sb2NhdGlvbjpccypcJGRzdFsnIl1ccypcKTsiO2k6NDc7czozNToiXC5cLi9cLlwuL2VuZ2luZS9kYXRhL2RiY29uZmlnXC5waHAiO2k6NDg7czo0MjoiPVxzKkAqZnNvY2tvcGVuXChccypcJGFyZ3ZcW1xkK1xdXHMqLFxzKjgwIjtpOjQ5O3M6MjY6IihcLmNoclwoXHMqXGQrXHMqXClcLil7NCx9IjtpOjUwO3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjUxO3M6NDExOiJAKihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X21hcClccypcKEAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfbWFwKVxzKlwoQCooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3xzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV9tYXApXHMqXCgiO2k6NTI7czo2NzoiPCEtLWNoZWNrOlsnIl1ccypcLlxzKm1kNVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo1MztzOjI4OiJcJHNldGNvb2tccypcKTtzZXRjb29raWVcKFwkIjtpOjU0O3M6Njg6ImNvcHlcKFxzKlsnIl1odHRwOi8vLis/XC50eHRbJyJdXHMqLFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVwpIjtpOjU1O3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aTo1NjtzOjEzOiJ3c29TZWNQYXJhbVwoIjtpOjU3O3M6NTc6IlwkW2EtekEtWjAtOV9dKz9cKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkW2EtekEtWjAtOV9dKz9cKSI7aTo1ODtzOjYwOiJzdWJzdHJcKHNwcmludGZcKFsnIl0lb1snIl0sXHMqZmlsZXBlcm1zXChcJGZpbGVcKVwpLFxzKi00XCkiO2k6NTk7czoyNjoiXCR7W2EtekEtWjAtOV9dKz99XChccypcKTsiO2k6NjA7czo0OToiQCpmaWxlX2dldF9jb250ZW50c1woQCpiYXNlNjRfZGVjb2RlXChAKnVybGRlY29kZSI7aTo2MTtzOjg6Ii9rcnlha2kvIjtpOjYyO3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTo2MztzOjE1NjoiXCRfU0VSVkVSXFtbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8sIjtpOjY0O3M6MTA1OiJpZlxzKlwoXHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cnJwb3NcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6NjU7czoxMzoiPT1bJyJdXClccypcLiI7aTo2NjtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTo2NztzOjEwOiJkZWtjYWhbJyJdIjtpOjY4O3M6MzA6IlwkZGVmYXVsdF91c2VfYWpheFxzKj1ccyp0cnVlOyI7aTo2OTtzOjUxOiJSZXdyaXRlUnVsZVxzK1xeXChcLlwqXClcJFxzK2h0dHA6Ly9cZCtcLlxkK1wuXGQrXC4iO2k6NzA7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6NzE7czo1MzoiUmV3cml0ZUVuZ2luZVxzK09uXHMqUmV3cml0ZUJhc2VccysvXD9bYS16QS1aMC05X10rPz0iO2k6NzI7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTo3MztzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6NzQ7czo4MzoiaW5jbHVkZVwoXHMqWyciXWRhdGE6dGV4dC9wbGFpbjtiYXNlNjRccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWzsiO2k6NzU7czoyMjoicnVua2l0X2Z1bmN0aW9uX3JlbmFtZSI7aTo3NjtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6Nzc7czoxMTY6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rP1wpIjtpOjc4O3M6NDc6ImV4cGxvZGVcKFsnIl1cXG5bJyJdLFxzKlwkX1BPU1RcW1snIl11cmxzWyciXVxdIjtpOjc5O3M6NTU6ImlmXHMqXChccypcJHRoaXMtPml0ZW0tPmhpdHNccyo+PVsnIl1cZCtbJyJdXClccyp7XHMqXCQiO2k6ODA7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjgxO3M6Mjg6InN0cl9yZXBsYWNlXChbJyJdL1w/YW5kclsnIl0iO2k6ODI7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTo4MztzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTo4NDtzOjEzMzoiXCRbYS16QS1aMC05X10rP1xzKlwuPVxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfSI7aTo4NTtzOjMzOiJcJFthLXpBLVowLTlfXSs/XChccypAXCRfQ09PS0lFXFsiO2k6ODY7czoxMTc6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcKSI7aTo4NztzOjIyOiJnXChccypbJyJdRmlsZXNNYW5bJyJdIjtpOjg4O3M6MzM6Ij1ccypAKmd6aW5mbGF0ZVwoXHMqc3RycmV2XChccypcJCI7aTo4OTtzOjQwOiJzdHJfcmVwbGFjZVwoWyciXVwuaHRhY2Nlc3NbJyJdXHMqLFxzKlwkIjtpOjkwO3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6OTE7czo2NzoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rPyI7aTo5MjtzOjE1OiJNdXN0QGZAXHMrU2hlbGwiO2k6OTM7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6OTQ7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aTo5NTtzOjM0OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypbJyJdIjtpOjk2O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTo5NztzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6OTg7czoyMjoiPlxzKjwvaWZyYW1lPlxzKjxcP3BocCI7aTo5OTtzOjEyNjoic3Vic3RyXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlxkK1xzKixccypcZCtccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnByZWdfcmVwbGFjZVwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypzdHJ0clwoIjtpOjEwMDtzOjIxOiJleHBsb2RlXChcXFsnIl07dGV4dDsiO2k6MTAxO3M6NDQ6ImZ1bmN0aW9uXHMrX1xkK1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpe1wkIjtpOjEwMjtzOjMwOiJzdHJfcmVwbGFjZVwoXHMqWyciXVwuaHRhY2Nlc3MiO2k6MTAzO3M6MTY6InRhZ3MvXCQ2L1wkNC9cJDciO2k6MTA0O3M6MTkyOiJcJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC4iO2k6MTA1O3M6MjA5OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF07XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccyphcnJheVwoXHMqXCRfUkVRVUVTVFxbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlfZmlsdGVyXChccypcJCI7aToxMDY7czo2MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vaG9tZS8iO2k6MTA3O3M6NjU6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci93d3cvIjtpOjEwODtzOjIyOiJyZXR1cm5ccypbJyJdL3Zhci93d3cvIjtpOjEwOTtzOjQ3OiJmb3BlblwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS93cC1hZG1pbiI7aToxMTA7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MTExO3M6Mzc6Ij1ccypbJyJdcGhwX3ZhbHVlXHMrYXV0b19wcmVwZW5kX2ZpbGUiO2k6MTEyO3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aToxMTM7czo0NToicm1kaXJzXChcJGRpclxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGNoaWxkIjtpOjExNDtzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6MTE1O3M6MTI6ImBjaGVja3N1ZXhlYyI7aToxMTY7czo0ODoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1hc3N1bnRvIjtpOjExNztzOjM1OiJlY2hvIFthLXpBLVowLTlfXSs/XHMqXChbJyJdaHR0cDovLyI7aToxMTg7czo5OiJtYWFmXHMreWEiO2k6MTE5O3M6NDY6IkBlcnJvcl9yZXBvcnRpbmdcKDBcKTtccypAc2V0X3RpbWVfbGltaXRcKDBcKTsiO2k6MTIwO3M6MTQ6IkxpYlhtbDJJc0J1Z2d5IjtpOjEyMTtzOjE1NjoiPVxzKm1haWxcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjEyMjtzOjIxMToiPVxzKm1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXSI7aToxMjM7czo5MjoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXCkiO2k6MTI0O3M6MzQ6ImV4cGxvZGVcKFsnIl07dGV4dDtbJyJdLFwkcm93XFswXF0iO2k6MTI1O3M6NjM6InN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl0sW2EtekEtWjAtOV9dKz9cLlsnIl08L2JvZHk+WyciXSxcJCI7aToxMjY7czoxNDoiIS91c3IvYmluL3BlcmwiO2k6MTI3O3M6MjE6Ilx8Ym90XHxzcGlkZXJcfHdnZXQvaSI7aToxMjg7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjEyOTtzOjMwOiJ0b3VjaFwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MTMwO3M6Mzc6ImZpbGVfZ2V0X2NvbnRlbnRzXChfX0ZJTEVfX1wpLFwkbWF0Y2giO2k6MTMxO3M6ODk6InN0cl9yZXBsYWNlXChhcnJheVwoWyciXWZpbHRlclN0YXJ0WyciXSxbJyJdZmlsdGVyRW5kWyciXVwpLFxzKmFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqIjtpOjEzMjtzOjI3OiJ3cC1vcHRpb25zXC5waHBccyo+XHMqRXJyb3IiO2k6MTMzO3M6NjM6IiU2MyU3MiU2OSU3MCU3NCUyRSU3MyU3MiU2MyUzRCUyNyU2OCU3NCU3NCU3MCUzQSUyRiUyRiU3MyU2RiU2MSI7aToxMzQ7czoxMjoiXC53d3cvLzpwdHRoIjtpOjEzNTtzOjEyMjoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyo9PVxzKlsnIl0iO2k6MTM2O3M6Njg6IlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcXlxzKlwkW2EtekEtWjAtOV9dKz9ccyo7IjtpOjEzNztzOjMyOiJbJyJdXHMqXF5ccypcJFthLXpBLVowLTlfXSs/XHMqOyI7aToxMzg7czo2MzoiXCRbYS16QS1aMC05X10rPy0+X3NjcmlwdHNcW1xzKmd6dW5jb21wcmVzc1woXHMqYmFzZTY0X2RlY29kZVwoIjtpOjEzOTtzOjkzOiJcJFthLXpBLVowLTlfXSs/PVsnIl1bYS16QS1aMC05XCtcPV9dK1snIl07XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkW2EtekEtWjAtOV9dKz9cKTtccypcPz4iO2k6MTQwO3M6MzU6ImJlZ2luXHMrbW9kOlxzK1RoYW5rc1xzK2ZvclxzK3Bvc3RzIjtpOjE0MTtzOjM0OiJldmFsXChccypbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoIjtpOjE0MjtzOjU4OiJcJFthLXpBLVowLTlfXSs/XFtccypfW2EtekEtWjAtOV9dKz9cKFxzKlxkK1xzKlwpXHMqXF1ccyo9IjtpOjE0MztzOjE5OiJpbWFwX2hlYWRlcmluZm9cKFwkIjtpOjE0NDtzOjY1OiJcJHRvXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJddG9fYWRkcmVzcyI7aToxNDU7czo2MToiZ2V0X3VzZXJzXChccyphcnJheVwoXHMqWyciXXJvbGVbJyJdXHMqPT5ccypbJyJdYWRtaW5pc3RyYXRvciI7aToxNDY7czo2MzoiXlxzKjxcP3BocFxzKmhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjE0NztzOjE0OiI8dGl0bGU+XHMqaXZueiI7aToxNDg7czo4NToiXlxzKjxcP3BocFxzKmhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlsnIl1ccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToxNDk7czozMzoiPVxzKmVzY191cmxcKFxzKnNpdGVfdXJsXChccypbJyJdIjtpOjE1MDtzOjM1OiJocmVmPVsnIl08XD9waHBccytlY2hvXHMrXCRjdXJfcGF0aCI7aToxNTE7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aToxNTI7czo0MToiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkW2EtekEtWjAtOV9dKz8iO2k6MTUzO3M6ODM6ImVjaG9ccytzdHJfcmVwbGFjZVwoXHMqWyciXVxbUEhQX1NFTEZcXVsnIl1ccyosXHMqYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXVBIUF9TRUxGIjtpOjE1NDtzOjI5OiJnbWFpbC1zbXRwLWluXC5sXC5nb29nbGVcLmNvbSI7aToxNTU7czoxMDoidGFyXHMrLXpjQyI7aToxNTY7czozMToiXCRfW2EtekEtWjAtOV9dKz9cKFxzKlwpO1xzKlw/PiI7aToxNTc7czoxOToiPVxzKnhkaXJcKFxzKlwkcGF0aCI7aToxNTg7czo2MToiXCRmcm9tXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZnJvbSI7aToxNTk7czo3OToiZWNob1xzK1wkW2EtekEtWjAtOV9dKz87bWtkaXJcKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcKTtmaWxlX3B1dF9jb250ZW50cyI7aToxNjA7czo4MzoiXCRbYS16QS1aMC05X10rPz1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWRvWyciXVxzKlxdO1xzKmluY2x1ZGUiO2k6MTYxO3M6MTY6IkBhc3NlcnRcKFxzKlsnIl0iO2k6MTYyO3M6NzI6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZm9wZW5cKFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVxzKixccypbJyJddyI7aToxNjM7czo3NzoiPGhlYWQ+XHMqPHNjcmlwdD5ccyp3aW5kb3dcLnRvcFwubG9jYXRpb25cLmhyZWY9WyciXS4rP1xzKjwvc2NyaXB0PlxzKjwvaGVhZD4iO2k6MTY0O3M6Mjk6IkNVUkxPUFRfVVJMXHMqLFxzKlsnIl1zbXRwOi8vIjtpOjE2NTtzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToxNjY7czo1NToiXCRmXHMqPVxzKlwkZlxkK1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rPyI7aToxNjc7czoyNzoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woIjtpOjE2ODtzOjM0OiJmdW5jdGlvblxzK19fZmlsZV9nZXRfdXJsX2NvbnRlbnRzIjtpOjE2OTtzOjUyOiJcI1thLXpBLVowLTlfXSs/XCMuKz88L3NjcmlwdD4uKz9cIy9bYS16QS1aMC05X10rP1wjIjtpOjE3MDtzOjI0OiJlY2hvXHMrYmFzZTY0X2RlY29kZVwoXCQiO2k6MTcxO3M6MTk6Ij1bJyJdXClccypcKTtccypcPz4iO2k6MTcyO3M6MzU6Ij09XHMqRkFMU0VccypcP1xzKlxkK1xzKjpccyppcDJsb25nIjtpOjE3MztzOjM4OiJlbHNlaWZcKFxzKlwkc3FsdHlwZVxzKj09XHMqWyciXXNxbGl0ZSI7aToxNzQ7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6MTc1O3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToxNzY7czo0MDoibWFpbFwoXCR0b1xzKixccypbJyJdLis/WyciXVxzKixccypcJHVybCI7aToxNzc7czo1ODoicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNzg7czo0MzoiZmlsZV9nZXRfY29udGVudHNcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyI7aToxNzk7czo2OToiZWNob1woWyciXTxmb3JtIG1ldGhvZD1bJyJdcG9zdFsnIl1ccyplbmN0eXBlPVsnIl1tdWx0aXBhcnQvZm9ybS1kYXRhIjtpOjE4MDtzOjE0OiJ3c29IZWFkZXJccypcKCI7aToxODE7czo3NToiYXJyYXlcKFxzKlsnIl08IS0tWyciXVxzKlwuXHMqbWQ1XChccypcJHJlcXVlc3RfdXJsXHMqXC5ccypyYW5kXChcZCssXHMqXGQrIjtpOjE4MjtzOjEyNDoiXCRbYS16QS1aMC05X10rPz1bJyJdaHR0cDovLy4rP1snIl07XHMqXCRbYS16QS1aMC05X10rPz1mb3BlblwoXCRbYS16QS1aMC05X10rPyxbJyJdclsnIl1cKTtccypyZWFkZmlsZVwoXCRbYS16QS1aMC05X10rP1wpOyI7aToxODM7czo2MDoiXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqLlxzKlxkK1xzKlxdXChccypbYS16QS1aMC05X10rP1woIjtpOjE4NDtzOjUzOiJlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccypcJHVybFxzKj1ccypbJyJdaHR0cDovLyI7aToxODU7czo5NToiXCRHTE9CQUxTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcJFthLXpBLVowLTlfXSs/XF0iO2k6MTg2O3M6OTA6IkBcJHtccypbYS16QS1aMC05X10rP1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXSs/XHMqfVwoXHMqXCRbYS16QS1aMC05X10rPyI7aToxODc7czoxMzoiRGV2YXJ0XHMrSFRUUCI7aToxODg7czoxMDoiXC5waHBcP1wkMCI7aToxODk7czo1NToiPGlucHV0XHMqdHlwZT1bJyJdZmlsZVsnIl1ccypuYW1lPVsnIl11c2VyZmlsZVsnIl1ccyovPiI7aToxOTA7czoxMTA6IlwkbWVzc2FnZXNcW1xdXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX11c2VyZmlsZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF1cW1xzKlwkaVxzKlxdIjtpOjE5MTtzOjUwOiI8aW5wdXRccyp0eXBlPSJmaWxlIlxzKnNpemU9IlxkKyJccypuYW1lPSJ1cGxvYWQiPiI7aToxOTI7czoxMjoiPFw/PVwkY2xhc3M7IjtpOjE5MztzOjQxOiJSZXdyaXRlQ29uZFxzKyV7UkVNT1RFX0FERFJ9XHMrXF4yMTdcLjExOCI7aToxOTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjE5NTtzOjEwMjoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFsnIl1odHRwOi8vLis/XC5qcGdbJyJdXCk7XHMqZXhpdFwoXCk7IjtpOjE5NjtzOjUxOiJmb3JlYWNoXChccypcJHRvc1xzKmFzXHMqXCR0b1wpXHMqe1xzKm1haWxcKFxzKlwkdG8iO2k6MTk3O3M6MTY6ImZ1bmN0aW9uXHMrd3NvRXgiO2k6MTk4O3M6MTUwOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1cJFthLXpBLVowLTlfXSs/PUBbYS16QS1aMC05X10rP1woWyciXS4rP1snIl1cKTtbYS16QS1aMC05X10rP1woIVwkW2EtekEtWjAtOV9dKz9cKXtcJFthLXpBLVowLTlfXSs/PUBbYS16QS1aMC05X10rP1woXHMqXCkiO2k6MTk5O3M6NTA6IlJld3JpdGVSdWxlXHMqXC5cKi9cLlwqXHMqW2EtekEtWjAtOV9dKz9cLnBocFw/XCQwIjtpOjIwMDtzOjQ2OiJodHRwOi8vLis/Ly4rP1wucGhwXD9hPVxkKyZjPVthLXpBLVowLTlfXSs/JnM9IjtpOjIwMTtzOjE4OiJ0Y3A6Ly8xMjdcLjBcLjBcLjEiO2k6MjAyO3M6Mjc6IiE9XHMqWyciXWluZm9ybWF0aW9uX3NjaGVtYSI7aToyMDM7czozOToicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfR0VUXFtccypbJyJdY3B5IjtpOjIwNDtzOjc0OiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClcKVxzKntccyplY2hvXHMqWyciXW9rWyciXSI7aToyMDU7czo2ODoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1weXRob24iO2k6MjA2O3M6NjY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcGVybCI7aToyMDc7czoyNToiZnVuY3Rpb25ccytlcnJvcl80MDRcKFwpeyI7aToyMDg7czo5NzoiXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwocm91bmRcKFxkK1wpXClcXSI7aToyMDk7czo4MToiQChmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypAdXJsZW5jb2RlXChccypcJF9QT1NUIjtpOjIxMDtzOjM1OiJmaWxlX2dldF9jb250ZW50c1woXHMqX19GSUxFX19ccypcKSI7aToyMTE7czo0ODoiXCRlY2hvXzFcLlwkZWNob18yXC5cJGVjaG9fM1wuXCRlY2hvXzRcLlwkZWNob181IjtpOjIxMjtzOjM3OiJpZlxzKlwoXHMqaXNfY3Jhd2xlcjFcKFxzKlwpXHMqXClccyp7IjtpOjIxMztzOjg0OiJldmFsXChccypbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKTtccypcPz4iO2k6MjE0O3M6MzE6Ij0+XHMqQFwkZjJcKF9fRklMRV9fXHMqLFxzKlwkZjEiO2k6MjE1O3M6MTEwOiJoZWFkZXJcKFxzKlsnIl1Db250ZW50LVR5cGU6XHMqaW1hZ2UvanBlZ1snIl1ccypcKTtccypyZWFkZmlsZVwoXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlwpO1xzKmV4aXRcKFxzKlwpOyI7aToyMTY7czoyNDU6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRbYS16QS1aMC05X10rP1woWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKVxzKlwpIjtpOjIxNztzOjYzOiJcJF9QT1NUXFtbJyJdezAsMX10cDJbJyJdezAsMX1cXVxzKlwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MjE4O3M6NDE6ImNobW9kXChcJGZpbGUtPmdldFBhdGhuYW1lXChcKVxzKixccyowNzc3IjtpOjIxOTtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToyMjA7czo2NDoiXCRfUE9TVFxbWyciXXswLDF9YWN0aW9uWyciXXswLDF9XF1ccyo9PVxzKlsnIl1nZXRfYWxsX2xpbmtzWyciXSI7aToyMjE7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjIyMjtzOjY3OiJcJGd6cFxzKj1ccypcJGJnekV4aXN0XHMqXD9ccypAZ3pvcGVuXChcJHRtcGZpbGUsXHMqWyciXXJiWyciXVxzKlwpIjtpOjIyMztzOjQzOiJcXVxzKlwpXHMqXC5ccypbJyJdXFxuXD8+WyciXVxzKlwpXHMqXClccyp7IjtpOjIyNDtzOjQwOiJDb2RlTWlycm9yXC5kZWZpbmVNSU1FXChccypbJyJddGV4dC9taXJjIjtpOjIyNTtzOjI4OiJjaG1vZFwoXHMqX19ESVJfX1xzKixccyowNDAwIjtpOjIyNjtzOjQwOiJmcHV0c1woXCRmcCxccypbJyJdSVA6XHMqXCRpcFxzKi1ccypEQVRFIjtpOjIyNztzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToyMjg7czoxMjoibmV3XHMqTUN1cmw7IjtpOjIyOTtzOjI0OiJuc2xvb2t1cFwuZXhlXHMqLXR5cGU9TVgiO2k6MjMwO3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MjMxO3M6MzI6ImRuc19nZXRfcmVjb3JkXChccypcJGRvbWFpblxzKlwuIjtpOjIzMjtzOjExNjoibW92ZV91cGxvYWRlZF9maWxlXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1cXVxbXHMqXCRpXHMqXF0iO2k6MjMzO3M6MTA5OiJjb3B5XChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9QT1NUIjtpOjIzNDtzOjg2OiJcJHVybFxzKlwuPVxzKlsnIl1cP1thLXpBLVowLTlfXSs/PVsnIl1ccypcLlxzKlwkX0dFVFxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdOyI7aToyMzU7czoyNjoiPFw/XHMqZWNob1xzKlwkY29udGVudDtcPz4iO2k6MjM2O3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqZ29vZ2xlIjtpOjIzNztzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKnlhbmRleCI7aToyMzg7czozNjoiaWZccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfWNobW9kNzc3IjtpOjIzOTtzOjQyOiJjb25uXHMqPVxzKmh0dHBsaWJcLkhUVFBDb25uZWN0aW9uXChccyp1cmkiO2k6MjQwO3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToyNDE7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MjQyO3M6MzY6InNldF90aW1lX2xpbWl0XChccyppbnR2YWxcKFxzKlwkYXJndiI7aToyNDM7czozNzoiZGllXChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToyNDQ7czozODoiZXhpdFwoWyciXTxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC4iO2k6MjQ1O3M6OToiR0FHQUw8L2I+IjtpOjI0NjtzOjkwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoXHMqWyciXVwkW2EtekEtWjAtOV9dKz9bJyJdXHMqXCkiO2k6MjQ3O3M6MTk6ImJ1ZGFrXHMqLVxzKmV4cGxvaXQiO2k6MjQ4O3M6MjI6ImFycmF5XChccypbJyJdJTFodG1sJTMiO2k6MjQ5O3M6NTY6IlwkY29kZT1bJyJdJTFzY3JpcHRccyp0eXBlPVxcWyciXXRleHQvamF2YXNjcmlwdFxcWyciXSUzIjtpOjI1MDtzOjIzOiJlY2hvXChccypodG1sXChccyphcnJheSI7aToyNTE7czoxNToiQHN5c3RlbVwoXHMqIlwkIjtpOjI1MjtzOjIxOiJmdW5jdGlvblxzKkN1cmxBdHRhY2siO2k6MjUzO3M6NDQ6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP209XCQxIjtpOjI1NDtzOjQ1OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9pZD1cJDEiO2k6MjU1O3M6MTU6IkhUVFBfQUNDRVBUX0FTRSI7aToyNTY7czoyNDoiXClccyp7XHMqcGFzc3RocnVcKFxzKlwkIjtpOjI1NztzOjE4OiJSZWRpcmVjdFxzKmh0dHA6Ly8iO2k6MjU4O3M6NDI6IlJld3JpdGVSdWxlXHMqXChcLlwrXClccyppbmRleFwucGhwXD9zPVwkMCI7aToyNTk7czozMToiZXZhbFxzKlwoXHMqbWJfY29udmVydF9lbmNvZGluZyI7aToyNjA7czo0ODoicGFyc2VfcXVlcnlfc3RyaW5nXChccypcJEVOVntccypbJyJdUVVFUllfU1RSSU5HIjtpOjI2MTtzOjQ0OiJAXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpOyI7aToyNjI7czozOToiW2EtekEtWjAtOV9dKz9cKFxzKlthLXpBLVowLTlfXSs/PVxzKlwpIjtpOjI2MztzOjEyOiJbJyJdcmlueVsnIl0iO2k6MjY0O3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjI2NTtzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MjY2O3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjI2NztzOjE0OiJbJyJddHJlc3NhWyciXSI7aToyNjg7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToyNjk7czoxMjoic3NlcnBtb2NudXpnIjtpOjI3MDtzOjk6ImV0YWxmbml6ZyI7aToyNzE7czoxMjoiWyciXXJpbnlbJyJdIjtpOjI3MjtzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToyNzM7czo3OiJjdWN2YXNiIjtpOjI3NDtzOjk6ImZnZV9lYmcxMyI7aToyNzU7czoxNDoiWyciXW5mZnJlZ1snIl0iO2k6Mjc2O3M6MTM6Im9uZnI2NF9xcnBicXIiO2k6Mjc3O3M6MTI6InRtaGFwYnpjZXJmZiI7aToyNzg7czo5OiJ0bXZhc3luZ3IiO2k6Mjc5O3M6NDg6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKSI7aToyODA7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjI4MTtzOjEzOiJudWxsX2V4cGxvaXRzIjtpOjI4MjtzOjEzMDoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKmV4aXRcKFwpOyI7aToyODM7czo1NjoibWFpbFwoXHMqXCRhcnJcW1snIl10b1snIl1cXVxzKixccypcJGFyclxbWyciXXN1YmpbJyJdXF0iO2k6Mjg0O3M6MjQ6InVubGlua1woXHMqX19GSUxFX19ccypcKSI7aToyODU7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjI4NjtzOjQzOiJuYW1lPVsnIl11cGxvYWRlclsnIl1ccytpZD1bJyJddXBsb2FkZXJbJyJdIjtpOjI4NztzOjMxOiJlY2hvXHMqWyciXTxiPlVwbG9hZDxzcz5TdWNjZXNzIjtpOjI4ODtzOjM3OiJoZWFkZXJcKFxzKlsnIl1Mb2NhdGlvbjpccypcJGxpbmtbJyJdIjtpOjI4OTtzOjUxOiJ0eXBlPVsnIl1zdWJtaXRbJyJdXHMqdmFsdWU9WyciXVVwbG9hZCBmaWxlWyciXVxzKj4iO2k6MjkwO3M6MzA6ImVsc2Vccyp7XHMqZWNob1xzKlsnIl1mYWlsWyciXSI7aToyOTE7czo0NDoiXHMqPVxzKmluaV9nZXRcKFxzKlsnIl1kaXNhYmxlX2Z1bmN0aW9uc1snIl0iO2k6MjkyO3M6NTc6IkBlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccyppZlxzKlwoXHMqIWlzc2V0XHMqXChccypcJCI7aToyOTM7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToyOTQ7czoxMjoiWmVyb0RheUV4aWxlIjtpOjI5NTtzOjExOiJTX1xdQF9cXlVcXiI7aToyOTY7czo1MDoiPGlucHV0XHMrdHlwZT1zdWJtaXRccyt2YWx1ZT1VcGxvYWRccyovPlxzKjwvZm9ybT4iO2k6Mjk3O3M6MTA4OiJpZlwoXHMqIXNvY2tldF9zZW5kdG9cKFxzKlwkc29ja2V0XHMqLFxzKlwkZGF0YVxzKixccypzdHJsZW5cKFxzKlwkZGF0YVxzKlwpXHMqLFxzKjBccyosXHMqXCRpcFxzKixccypcJHBvcnQiO2k6Mjk4O3M6NTQ6InN1YnN0clwoXHMqXCRyZXNwb25zZVxzKixccypcJGluZm9cW1xzKlsnIl1oZWFkZXJfc2l6ZSI7aToyOTk7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aTozMDA7czo3NDoiXCRyZXQgPSBcJHRoaXMtPl9kYi0+dXBkYXRlT2JqZWN0XCggXCR0aGlzLT5fdGJsLCBcJHRoaXMsIFwkdGhpcy0+X3RibF9rZXkiO2k6MzAxO3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjMwMjtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MzAzO3M6NDk6IkB0b3VjaFxzKlwoXHMqXCRjdXJmaWxlXHMqLFxzKlwkdGltZVxzKixccypcJHRpbWUiO2k6MzA0O3M6MzM6InRvdWNoXHMqXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aTozMDU7czoyNzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzIjtpOjMwNjtzOjI5OiJleGVjXChccypbJyJdL2Jpbi9zaFsnIl1ccypcKSI7aTozMDc7czoxNToiL3RtcC9cLklDRS11bml4IjtpOjMwODtzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6MzA5O3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjMxMDtzOjE2OiI7XHMqL2Jpbi9zaFxzKi1pIjtpOjMxMTtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aTozMTI7czo0MjoiQHVtYXNrXChccyowNzc3XHMqJlxzKn5ccypcJGZpbGVwZXJtaXNzaW9uIjtpOjMxMztzOjUyOiJjaG1vZFwoXHMqXCRbXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1xzKixccyowNzU1IjtpOjMxNDtzOjUyOiJjaG1vZFwoXHMqXCRbXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1xzKixccyowNDA0IjtpOjMxNTtzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aTozMTY7czo5OiJMM1poY2k5M2QiO2k6MzE3O3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6MzE4O3M6ODQ6Ii9pbmRleFwucGhwXD9vcHRpb249Y29tX2NvbnRlbnQmdmlldz1hcnRpY2xlJmlkPVsnIl1cLlwkcG9zdFxbWyciXXswLDF9aWRbJyJdezAsMX1cXSI7aTozMTk7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjMyMDtzOjY0OiJpc3NldFwoXHMqXCRfQ09PS0lFXFtccyptZDVcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9IT1NUIjtpOjMyMTtzOjI3OiJzdHJsZW5cKFxzKlwkcGF0aFRvRG9yXHMqXCkiO2k6MzIyO3M6Mjk6ImZvcGVuXChccypbJyJdXC5cLi9cLmh0YWNjZXNzIjtpOjMyMztzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjMyNDtzOjc2OiJcYm1haWxcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqIjtpOjMyNTtzOjQzOiJjb250ZW50PSJcZCs7VVJMPWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vIjtpOjMyNjtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MzI3O3M6MTk6Ii9pbnN0cnVrdHNpeWEtZGx5YS0iO2k6MzI4O3M6MTQ6Ii9cP2RvPW9zaGlia2EtIjtpOjMyOTtzOjE3OiIvXD9kbz1rYWstdWRhbGl0LSI7aTozMzA7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjMzMTtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aTozMzI7czoyMDoiXCRfUkVRVUVTVFxbWyciXWxhbGEiO2k6MzMzO3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MzM0O3M6NjM6Imh0dHA6Ly93d3dcLmdvb2dsZVwuY29tL3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5XC5bJyJdJmhsPVwkbGFuZyI7aTozMzU7czo0MzoiaHR0cDovL2dvXC5tYWlsXC5ydS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeSI7aTozMzY7czo1MDoiaHR0cDovL3d3d1wuYmluZ1wuY29tL3NlYXJjaFw/cT1cJHF1ZXJ5JnBxPVwkcXVlcnkiO2k6MzM3O3M6Mzg6InNldFRpbWVvdXRcKFxzKlsnIl1sb2NhdGlvblwucmVwbGFjZVwoIjtpOjMzODtzOjEwNjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aTozMzk7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmljbyI7aTozNDA7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmdpZiI7aTozNDE7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aTozNDI7czoxMjA6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLnBuZyI7aTozNDM7czoxNDI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5wbmciO2k6MzQ0O3M6MTQyOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuZ2lmIjtpOjM0NTtzOjE0MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aTozNDY7czoxMDY6InVubGlua1woXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl17MCwxfS9hc3NldHMvY2FjaGUvdGVtcC9GaWxlU2V0dGluZ3MiO2k6MzQ3O3M6NDg6ImlmXChccypzdHJwb3NcKFxzKlwkdmFsdWVccyosXHMqXCRtYXNrXHMqXClccypcKSI7aTozNDg7czo4OiJhYmFrby9BTyI7aTozNDk7czo1NToiXCovXHMqKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aTozNTA7czozNDoiZ3JvdXBfY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSI7aTozNTE7czozNzoiY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSx1c2VybmFtZSI7aTozNTI7czoyMzoiXCt1bmlvblwrc2VsZWN0XCswLDAsMCwiO2k6MzUzO3M6OToic2V4c2V4c2V4IjtpOjM1NDtzOjM1OiJcJGJhc2VfZG9tYWluXHMqPVxzKmdldF9iYXNlX2RvbWFpbiI7aTozNTU7czozMToiIWVyZWdcKFsnIl1cXlwodW5zYWZlX3Jhd1wpXD9cJCI7aTozNTY7czoxMDk6IlwkW2EtekEtWjAtOV9dKz9ccyo9XCRbYS16QS1aMC05X10rP1xzKlwoXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqXChbJyJdXHMqe1wkW2EtekEtWjAtOV9dKz8iO2k6MzU3O3M6MTk6ImxtcF9jbGllbnRcKHN0cmNvZGUiO2k6MzU4O3M6MTY6ImV2YWxcKFsnIl1ccyovXCoiO2k6MzU5O3M6MTU6ImV2YWxcKFsnIl1ccyovLyI7aTozNjA7czozNDoiXCRxdWVyeVxzKyxccytbJyJdZnJvbSUyMGpvc191c2VycyI7aTozNjE7czo3OToiXCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xdXFtcJFthLXpBLVowLTlfXSs/XFtcZCtcXVwuXCRbYS16QS1aMC05X10rPyI7aTozNjI7czoyOToiXClcKSxQSFBfVkVSU0lPTixtZDVfZmlsZVwoXCQiO2k6MzYzO3M6ODM6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jdXJsXHMrLU9ccytodHRwOi8vIjtpOjM2NDtzOjM2OiJjaG1vZFwoZGlybmFtZVwoX19GSUxFX19cKSxccyowNTExXCkiO2k6MzY1O3M6Mzk6ImxvY2F0aW9uXC5yZXBsYWNlXChcXFsnIl1cJHVybF9yZWRpcmVjdCI7aTozNjY7czoyODoiTW90aGVyWyciXXNccytNYWlkZW5ccytOYW1lOiI7aTozNjc7czo5MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjM2ODtzOjc3OiJhcnJheV9tZXJnZVwoXCRleHRccyosXHMqYXJyYXlcKFsnIl13ZWJzdGF0WyciXSxbJyJdYXdzdGF0c1snIl0sWyciXXRlbXBvcmFyeSI7aTozNjk7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjM3MDtzOjIyOiJ4cnVtZXJfc3BhbV9saW5rc1wudHh0IjtpOjM3MTtzOjcwOiI8XD9waHBccysoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjM3MjtzOjIyOiIsWyciXTxcP3BocFxcblsnIl1cLlwkIjtpOjM3MztzOjUwOiI8aWZyYW1lXHMrc3JjPVsnIl1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tL2Zvcm1zLyI7aTozNzQ7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjM3NTtzOjQ1OiJpZlwoZmlsZV9wdXRfY29udGVudHNcKFwkaW5kZXhfcGF0aCxccypcJGNvZGUiO2k6Mzc2O3M6NTM6IlwkW2EtekEtWjAtOV9dKz8gPSBcJFthLXpBLVowLTlfXSs/XChbJyJdezAsMX1odHRwOi8vIjtpOjM3NztzOjUyOiJjXC5sZW5ndGhcKTt9cmV0dXJuXHMqXFxbJyJdXFxbJyJdO31pZlwoIWdldENvb2tpZVwoIjtpOjM3ODtzOjM3OiJzZWxlY3RccypsYW5ndWFnZXNfaWQsXHMrbmFtZSxccytjb2RlIjtpOjM3OTtzOjUwOiJ1cGRhdGVccypjb25maWd1cmF0aW9uXHMrc2V0XHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aTozODA7czo3MToic2VsZWN0XHMqY29uZmlndXJhdGlvbl9pZCxccytjb25maWd1cmF0aW9uX3RpdGxlLFxzK2NvbmZpZ3VyYXRpb25fdmFsdWUiO2k6MzgxO3M6MzY6Ii9hZG1pbi9jb25maWd1cmF0aW9uXC5waHAvbG9naW5cLnBocCI7aTozODI7czoxMDE6InN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlIjtpOjM4MztzOjEyOiJkbWxsZDBSaGRHRT0iO2k6Mzg0O3M6ODE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTozODU7czo3MToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6Mzg2O3M6NzM6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKiwiO2k6Mzg3O3M6NTI6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlsnIl0iO2k6Mzg4O3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cWyI7aTozODk7czo0NToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlxbIjtpOjM5MDtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTozOTE7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6MzkyO3M6NjU6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci90bXAvIjtpOjM5MztzOjI2OiJleGl0XChcKTpleGl0XChcKTpleGl0XChcKSI7aTozOTQ7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6Mzk1O3M6Mzg6IkBtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkdXNlcmZpbGVfdG1wIjtpOjM5NjtzOjIyOiJkaXNhYmxlX2Z1bmN0aW9ucz1ub25lIjtpOjM5NztzOjE1NToiXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xzKlxdXFtccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC4iO2k6Mzk4O3M6MjIyOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6Mzk5O3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cKCI7aTo0MDA7czo0MjoiPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXXswLDF9XCRhWyciXXswLDF9IjtpOjQwMTtzOjM3OiJpZlxzKlwoXHMqaW5pX2dldFwoWyciXXswLDF9c2FmZV9tb2RlIjtpOjQwMjtzOjk6IlwkYlwoWyciXSI7aTo0MDM7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aTo0MDQ7czozNjoiWC1NYWlsZXI6XHMqTWljcm9zb2Z0IE9mZmljZSBPdXRsb29rIjtpOjQwNTtzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0MDY7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTo0MDc7czo2NDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKCI7aTo0MDg7czoxMzoiQGV4dHJhY3RccypcJCI7aTo0MDk7czoxMzoiQGV4dHJhY3RccypcKCI7aTo0MTA7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6NDExO3M6ODE6Im1haWxcKFwkX1BPU1RcW1snIl17MCwxfWVtYWlsWyciXXswLDF9XF0sXHMqXCRfUE9TVFxbWyciXXswLDF9c3ViamVjdFsnIl17MCwxfVxdLCI7aTo0MTI7czo4NDoibW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtbJyJddG1wX25hbWVbJyJdXF1ccyosIjtpOjQxMztzOjQ1OiJNb3ppbGxhLzVcLjBccypcKGNvbXBhdGlibGU7XHMqR29vZ2xlYm90LzJcLjEiO2k6NDE0O3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6NDE1O3M6NDM6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXXByZWdfcmVwbGFjZVsnIl0iO2k6NDE2O3M6Mzc6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWFzc2VydFsnIl0iO2k6NDE3O3M6NDY6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NDE4O3M6NDQ6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQxOTtzOjM1OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1ldmFsWyciXSI7aTo0MjA7czoyODoiQ3JlZGl0XHMqQ2FyZFxzKlZlcmlmaWNhdGlvbiI7aTo0MjE7czo2NjoiUmV3cml0ZUNvbmRccyole0hUVFA6QWNjZXB0LUxhbmd1YWdlfVxzKlwocnVcfHJ1LXJ1XHx1a1wpXHMqXFtOQ1xdIjtpOjQyMjtzOjQyOiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LW9wZXJhbWluaS1waG9uZS11YX0iO2k6NDIzO3M6MzQ6IlJld3JpdGVDb25kXHMqJXtIVFRQOngtd2FwLXByb2ZpbGUiO2k6NDI0O3M6MjI6ImV2YWxccypcKFxzKmdldF9vcHRpb24iO2k6NDI1O3M6Mjk6ImVjaG9ccytbJyJdezAsMX1nb29kWyciXXswLDF9IjtpOjQyNjtzOjUxOiJDVVJMT1BUX1JFRkVSRVIsXHMqWyciXXswLDF9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY28iO2k6NDI3O3M6MTU6IlwkYXV0aF9wYXNzXHMqPSI7aTo0Mjg7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aTo0Mjk7czo2NDoiZWNob1xzK3N0cmlwc2xhc2hlc1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0MzA7czoyMjoiPGgxPkxvYWRpbmdcLlwuXC48L2gxPiI7aTo0MzE7czoxMjoicGhwaW5mb1woXCk7IjtpOjQzMjtzOjQwNjoiKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfbWFwKVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfbWFwKVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfbWFwKSI7aTo0MzM7czoxNToiWyciXS9cLlwqL2VbJyJdIjtpOjQzNDtzOjI4OiJlY2hvXHMqXCgqXHMqWyciXU5PIEZJTEVbJyJdIjtpOjQzNTtzOjE5MDoibW92ZV91cGxvYWRlZF9maWxlXHMqXCgqXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVuYW1lWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVuYW1lWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aTo0MzY7czoyMzoiY29weVxzKlwoXHMqWyciXWh0dHA6Ly8iO2k6NDM3O3M6ODI6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1SZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqVVJMPWh0dHA6Ly8iO2k6NDM4O3M6ODE6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1yZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqdXJsPTxcP3BocCI7aTo0Mzk7czoxMDoiWyciXWFIUjBjRCI7aTo0NDA7czo2Nzoic3RyY2hyXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aTo0NDE7czo2Nzoic3Ryc3RyXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aTo0NDI7czo2Nzoic3RycG9zXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aTo0NDM7czozMzoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjQ0NDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6NDQ1O3M6Njk6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXCgqWyciXWNkXHMrL3RtcCI7aTo0NDY7czoyNzoiXCRPT08uKz89XHMqdXJsZGVjb2RlXHMqXCgqIjtpOjQ0NztzOjE2OiJbJyJdcm1ccystZlxzKy1yIjtpOjQ0ODtzOjE2OiJbJyJdcm1ccystclxzKy1mIjtpOjQ0OTtzOjEyOiJbJyJdcm1ccystZnIiO2k6NDUwO3M6MTI6IlsnIl1ybVxzKy1yZiI7aTo0NTE7czo2OToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKEAqdXJsZW5jb2RlIjtpOjQ1MjtzOjYzOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXWltYWdlcy8iO2k6NDUzO3M6ODk6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQ1NDtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0NTU7czo1MToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZVxzKlwoXHMqWyciXXswLDF9JTNDIjtpOjQ1NjtzOjEyOiJbJyJdbHNccystbGEiO2k6NDU3O3M6Mzc6ImluaV9zZXRcKFxzKlsnIl17MCwxfW1hZ2ljX3F1b3Rlc19ncGMiO2k6NDU4O3M6Mjg6ImFuZHJvaWRcfGF2YW50Z29cfGJsYWNrYmVycnkiO2k6NDU5O3M6NDU6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1uYW1lXHMrXC5odHBhc3N3ZCI7aTo0NjA7czo0MToiWyciXWZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDIwMDAiO2k6NDYxO3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjQ2MjtzOjU6InhDZWR6IjtpOjQ2MztzOjk6IlwkcGFzc191cCI7aTo0NjQ7czo1OiJPbmV0NyI7aTo0NjU7czo1OiJKVGVybSI7aTo0NjY7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjQ2NztzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6NDY4O3M6MTU6IjEwOVwuMjM4XC4yNDJcLiI7aTo0Njk7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0NzA7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdSFRUUF9SRUZFUkVSWyciXVxzKlxdXHMqLFxzKlsnIl10cnVzdGxpbmtcLnJ1IjtpOjQ3MTtzOjIwOiJbJyJdL2V0Yy9uYW1lZFwuY29uZiI7aTo0NzI7czoxNDoiWyciXS9ldGMvaHR0cGQiO2k6NDczO3M6MTU6IlsnIl0vdmFyL2NwYW5lbCI7aTo0NzQ7czoxNToiWyciXS9ldGMvcGFzc3dkIjt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxMTk6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjt9"));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlsnIlwoXCRdIjtpOjEyMjtzOjExOiJcYm1haWxccypcKCI7aToxMjM7czo0NjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccypbJyJdezAsMX1waHA6Ly9pbnB1dCI7aToxMjQ7czoxMTg6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1Db250ZW50LXR5cGVbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfXRleHQvaHRtbDtccypjaGFyc2V0PXdpbmRvd3MtMTI1MVsnIl17MCwxfT48Ym9keT4iO2k6MTI1O3M6NjI6Ij1ccypkb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoXHMqWyciXXswLDF9c2NyaXB0WyciXXswLDF9XHMqXCk7IjtpOjEyNjtzOjY5OiJkb2N1bWVudFwuYm9keVwuaW5zZXJ0QmVmb3JlXChkaXYsXHMqZG9jdW1lbnRcLmJvZHlcLmNoaWxkcmVuXFswXF1cKTsiO2k6MTI3O3M6Nzc6IjxzY3JpcHRccyt0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vW2EtekEtWjAtOV9dKz9cLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YTo0ODp7aTowO3M6MjU6InNsaW5rc1wuc3UvZ2V0X2xpbmtzXC5waHAiO2k6MTtzOjEzOiJNTF9sY29kZVwucGhwIjtpOjI7czoxMzoiTUxfJWNvZGVcLnBocCI7aTozO3M6MTk6ImNvZGVzXC5tYWlubGlua1wucnUiO2k6NDtzOjE5OiJfX2xpbmtmZWVkX3JvYm90c19fIjtpOjU7czoxMzoiTElOS0ZFRURfVVNFUiI7aTo2O3M6MTQ6IkxpbmtmZWVkQ2xpZW50IjtpOjc7czoxODoiX19zYXBlX2RlbGltaXRlcl9fIjtpOjg7czoyOToiZGlzcGVuc2VyXC5hcnRpY2xlc1wuc2FwZVwucnUiO2k6OTtzOjExOiJMRU5LX2NsaWVudCI7aToxMDtzOjExOiJTQVBFX2NsaWVudCI7aToxMTtzOjE2OiJfX2xpbmtmZWVkX2VuZF9fIjtpOjEyO3M6MTY6IlNMQXJ0aWNsZXNDbGllbnQiO2k6MTM7czoxNzoiLT5HZXRMaW5rc1xzKlwoXCkiO2k6MTQ7czoxNzoiZGJcLnRydXN0bGlua1wucnUiO2k6MTU7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxNjtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE3O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MTg7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MTk7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIwO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjE7czoxNjY6Imlzc2V0XHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjI7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCgqXHMqXCRsaWJfcGF0aCI7aToyMztzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoKlxzKiI7aToyNDtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKSpccyo7XHMqXD8+IjtpOjI1O3M6NzoibGV2aXRyYSI7aToyNjtzOjEwOiJkYXBveGV0aW5lIjtpOjI3O3M6NjoidmlhZ3JhIjtpOjI4O3M6NjoiY2lhbGlzIjtpOjI5O3M6ODoicHJvdmlnaWwiO2k6MzA7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMTtzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzI7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjMzO3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzQ7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM1O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM2O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM3O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTozODtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTozOTtzOjEwOiJfX0xJTktfXzxhIjtpOjQwO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MTtzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQyO3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDM7czoxNToiX19MSU5LX19fX0VORF9fIjtpOjQ0O3M6MjI6Im5ld1xzK1RSVVNUTElOS19jbGllbnQiO2k6NDU7czo3NToiclwucGhwXD9pZD1bYS16QS1aMC05X10rPyZyZWZlcmVyPSV7SFRUUF9IT1NUfS8le1JFUVVFU1RfVVJJfVxzK1xbUj0zMDIsTFxdIjtpOjQ2O3M6Mzk6IlVzZXItYWdlbnQ6XHMqR29vZ2xlYm90XHMqRGlzYWxsb3c6XHMqLyI7aTo0NztzOjE4OiJuZXdccytMTE1fY2xpZW50XCgiO30="));
$g_JSVirSig = unserialize(base64_decode("YToxMTY6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czo0MToiZj0nZidcKydyJ1wrJ28nXCsnbSdcKydDaCdcKydhckMnXCsnb2RlJzsiO2k6NTtzOjIyOiJcLnByb3RvdHlwZVwuYX1jYXRjaFwoIjtpOjY7czozNzoidHJ5e0Jvb2xlYW5cKFwpXC5wcm90b3R5cGVcLnF9Y2F0Y2hcKCI7aTo3O3M6MzQ6ImlmXChSZWZcLmluZGV4T2ZcKCdcLmdvb2dsZVwuJ1wpIT0iO2k6ODtzOjg2OiJpbmRleE9mXHxpZlx8cmNcfGxlbmd0aFx8bXNuXHx5YWhvb1x8cmVmZXJyZXJcfGFsdGF2aXN0YVx8b2dvXHxiaVx8aHBcfHZhclx8YW9sXHxxdWVyeSI7aTo5O3M6NTQ6IkFycmF5XC5wcm90b3R5cGVcLnNsaWNlXC5jYWxsXChhcmd1bWVudHNcKVwuam9pblwoIiJcKSI7aToxMDtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjExO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTI7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTM7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxNDtzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNTtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE2O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNztzOjc6IlxceDY1QXQiO2k6MTg7czo5OiJcXHg2MXJDb2QiO2k6MTk7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToyMDtzOjExOiI9ImV2IlwrImFsIiI7aToyMTtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjI7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIzO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjI0O3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI1O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI2O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6Mjc7czo5OiJ2YXJccytfMHgiO2k6Mjg7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjk7czo3OiJwaW5nbm93IjtpOjMwO3M6ODoic2VyY2hib3QiO2k6MzE7czoxMDoia20wYWU5Z3I2bSI7aTozMjtzOjY6ImMzMjg0ZCI7aTozMztzOjg6IlxceDY4YXJDIjtpOjM0O3M6ODoiXFx4NmRDaGEiO2k6MzU7czo3OiJcXHg2ZmRlIjtpOjM2O3M6NzoiXFx4NmZkZSI7aTozNztzOjg6IlxceDQzb2RlIjtpOjM4O3M6NzoiXFx4NzJvbSI7aTozOTtzOjc6IlxceDQzaGEiO2k6NDA7czo3OiJcXHg3MkNvIjtpOjQxO3M6ODoiXFx4NDNvZGUiO2k6NDI7czoxMDoiXC5keW5kbnNcLiI7aTo0MztzOjk6IlwuZHluZG5zLSI7aTo0NDtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ1O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0NjtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDc7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDg7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDk7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjUwO3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTE7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjUyO3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MztzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjU0O3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NTtzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU2O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1NztzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo1ODtzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo1OTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjYwO3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYxO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjYyO3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjM7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjQ7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NTtzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2NjtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2NztzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo2ODtzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjY5O3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjcwO3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MTtzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3MjtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjczO3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3NDtzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6NzU7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3NjtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3NztzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjc4O3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo3OTtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6ODA7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MTtzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjgyO3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjgzO3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4NDtzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg1O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg2O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg3O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo4ODtzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo4OTtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo5MDtzOjU1OiJzdHJpcG9zXHMqXChccypmX2hheXN0YWNrXHMqLFxzKmZfbmVlZGxlXHMqLFxzKmZfb2Zmc2V0IjtpOjkxO3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjkyO3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6OTM7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5NDtzOjE3OiJzZXhmcm9taW5kaWFcLmNvbSI7aTo5NTtzOjExOiJmaWxla3hcLmNvbSI7aTo5NjtzOjEzOiJzdHVtbWFublwubmV0IjtpOjk3O3M6MTQ6Imh0dHA6Ly94enhcLnBtIjtpOjk4O3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aTo5OTtzOjExOiJtb2JpLWdvXC5pbiI7aToxMDA7czoxODoiYmFua29mYW1lcmljYVwuY29tIjtpOjEwMTtzOjE2OiJteWZpbGVzdG9yZVwuY29tIjtpOjEwMjtzOjE3OiJmaWxlc3RvcmU3MlwuaW5mbyI7aToxMDM7czoxNjoiZmlsZTJzdG9yZVwuaW5mbyI7aToxMDQ7czoxNToidXJsMnNob3J0XC5pbmZvIjtpOjEwNTtzOjE4OiJmaWxlc3RvcmUxMjNcLmluZm8iO2k6MTA2O3M6MTI6InVybDEyM1wuaW5mbyI7aToxMDc7czoxNDoiZG9sbGFyYWRlXC5jb20iO2k6MTA4O3M6MTE6InNlY2NsaWtcLnJ1IjtpOjEwOTtzOjExOiJtb2J5LWFhXC5ydSI7aToxMTA7czoxMjoic2VydmxvYWRcLnJ1IjtpOjExMTtzOjQ4OiJzdHJpcG9zXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKixccypsaXN0X2RhdGFcW2kiO2k6MTEyO3M6MjY6ImlmXHMqXCghc2VlX3VzZXJfYWdlbnRcKFwpIjtpOjExMztzOjQ2OiJjXC5sZW5ndGhcKTt9cmV0dXJuXHMqWyciXVsnIl07fWlmXCghZ2V0Q29va2llIjtpOjExNDtzOjcwOiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9ZnRwOi8vIjtpOjExNTtzOjQ4OiJpZlxzKlwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoWyciXXswLDF9c2FicmkiO30="));
$gX_JSVirSig = unserialize(base64_decode("YTo1Mjp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czoxMDE6ImRvY3VtZW50XC5jYXB0aW9uPW51bGw7d2luZG93XC5hZGRFdmVudFwoWyciXXswLDF9bG9hZFsnIl17MCwxfSxmdW5jdGlvblwoXCl7dmFyIGNhcHRpb249bmV3IEpDYXB0aW9uIjtpOjk7czoxMjoiaHR0cDovL2Z0cFwuIjtpOjEwO3M6Nzoibm5uXC5wbSI7aToxMTtzOjc6Im5ubVwucG0iO2k6MTI7czoxNjoidG9wLXdlYnBpbGxcLmNvbSI7aToxMztzOjE5OiJnb29kcGlsbHNlcnZpY2VcLnJ1IjtpOjE0O3M6Nzg6IjxzY3JpcHRccyp0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzKnNyYz1bJyJdezAsMX1odHRwOi8vZ29vXC5nbCI7aToxNTtzOjY3OiIiXHMqXCtccypuZXcgRGF0ZVwoXClcLmdldFRpbWVcKFwpO1xzKmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoIjtpOjE2O3M6MzQ6IlwuaW5kZXhPZlwoXHMqWyciXUlCcm93c2VbJyJdXHMqXCkiO2k6MTc7czo4NzoiPWRvY3VtZW50XC5yZWZlcnJlcjtccypbYS16QS1aMC05X10rPz11bmVzY2FwZVwoXHMqW2EtekEtWjAtOV9dKz9ccypcKTtccyp2YXJccytFeHBEYXRlIjtpOjE4O3M6NzQ6IjwhLS1ccypbYS16QS1aMC05X10rP1xzKi0tPjxzY3JpcHQuKz88L3NjcmlwdD48IS0tL1xzKlthLXpBLVowLTlfXSs/XHMqLS0+IjtpOjE5O3M6MzU6ImV2YWxccypcKFxzKmRlY29kZVVSSUNvbXBvbmVudFxzKlwoIjtpOjIwO3M6NzI6IndoaWxlXChccypmPFxkK1xzKlwpZG9jdW1lbnRcW1xzKlthLXpBLVowLTlfXSs/XCtbJyJddGVbJyJdXHMqXF1cKFN0cmluZyI7aToyMTtzOjgxOiJzZXRDb29raWVcKFxzKl8weFthLXpBLVowLTlfXSs/XHMqLFxzKl8weFthLXpBLVowLTlfXSs/XHMqLFxzKl8weFthLXpBLVowLTlfXSs/XCkiO2k6MjI7czoyOToiXF1cKFxzKnZcK1wrXHMqXCktMVxzKlwpXHMqXCkiO2k6MjM7czo0NDoiZG9jdW1lbnRcW1xzKl8weFthLXpBLVowLTlfXSs/XFtcZCtcXVxzKlxdXCgiO2k6MjQ7czoyODoiL2csWyciXVsnIl1cKVwuc3BsaXRcKFsnIl1cXSI7aToyNTtzOjQzOiJ3aW5kb3dcLmxvY2F0aW9uPWJ9XClcKG5hdmlnYXRvclwudXNlckFnZW50IjtpOjI2O3M6MjI6IlsnIl1yZXBsYWNlWyciXVxdXCgvXFsiO2k6Mjc7czoxMjc6ImlcW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdXChbYS16QS1aMC05X10rP1xbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF1cKFxkKyxcZCtcKVwpXCl7d2luZG93XFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXT1sb2MiO2k6Mjg7czo0OToiZG9jdW1lbnRcLndyaXRlXChccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHlcKCI7aToyOTtzOjUxOiJbJyJdXF1cKFthLXpBLVowLTlfXSs/XCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6MzA7czo2NToiO3doaWxlXChbYS16QS1aMC05X10rPzxcZCtcKWRvY3VtZW50XFsuKz9cXVwoU3RyaW5nXFtbJyJdZnJvbUNoYXIiO2k6MzE7czoxMDk6ImlmXHMqXChbYS16QS1aMC05X10rP1wuaW5kZXhPZlwoZG9jdW1lbnRcLnJlZmVycmVyXC5zcGxpdFwoWyciXS9bJyJdXClcW1snIl0yWyciXVxdXClccyohPVxzKlsnIl0tMVsnIl1cKVxzKnsiO2k6MzI7czoxMTQ6ImRvY3VtZW50XC53cml0ZVwoXHMqWyciXTxzY3JpcHRccyt0eXBlPVsnIl10ZXh0L2phdmFzY3JpcHRbJyJdXHMqc3JjPVsnIl0vL1snIl1ccypcK1xzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseSI7aTozMztzOjM4OiJwcmVnX21hdGNoXChbJyJdQFwoeWFuZGV4XHxnb29nbGVcfGJvdCI7aTozNDtzOjEzNzoiZmFsc2V9O1thLXpBLVowLTlfXSs/PVthLXpBLVowLTlfXSs/XChbJyJdW2EtekEtWjAtOV9dKz9bJyJdXClcfFthLXpBLVowLTlfXSs/XChbJyJdW2EtekEtWjAtOV9dKz9bJyJdXCk7W2EtekEtWjAtOV9dKz9cfD1bYS16QS1aMC05X10rPzsiO2k6MzU7czo2NToiU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKlthLXpBLVowLTlfXSs/XC5jaGFyQ29kZUF0XChpXClccypcXlxzKjIiO2k6MzY7czoxNjoiLj1bJyJdLjovLy5cLi4vLiI7aTozNztzOjU4OiJcW1snIl1jaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dKz9ccypcK1xzKlsnIl1BdFsnIl1cXVwoIjtpOjM4O3M6NDk6InNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6Mzk7czo1NjoiU3RyaW5nXFtccypbJyJdZnJvbUNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rP1xzKlxdXCgiO2k6NDA7czoyODoiLj1bJyJdLjovLy5cLi5cLi5cLi4vLlwuLlwuLiI7aTo0MTtzOjQwOiI8L3NjcmlwdD5bJyJdXCk7XHMqL1wqL1thLXpBLVowLTlfXSs/XCovIjtpOjQyO3M6NzM6ImRvY3VtZW50XFtfMHhcZCtcW1xkK1xdXF1cKF8weFxkK1xbXGQrXF1cK18weFxkK1xbXGQrXF1cK18weFxkK1xbXGQrXF1cKTsiO2k6NDM7czo1MToiXChzZWxmPT09dG9wXD8wOjFcKVwrWyciXVwuanNbJyJdLGFcKGYsZnVuY3Rpb25cKFwpIjtpOjQ0O3M6OToiJmFkdWx0PTEmIjtpOjQ1O3M6OTg6ImRvY3VtZW50XC5yZWFkeVN0YXRlXHMrPT1ccytbJyJdY29tcGxldGVbJyJdXClccyp7XHMqY2xlYXJJbnRlcnZhbFwoW2EtekEtWjAtOV9dKz9cKTtccypzXC5zcmNccyo9IjtpOjQ2O3M6MTk6Ii46Ly8uXC4uXC4uLy5cLi5cPy8iO2k6NDc7czozOToiXGQrXHMqPlxzKlxkK1xzKlw/XHMqWyciXVxceFxkK1snIl1ccyo6IjtpOjQ4O3M6NDU6IlsnIl1cW1xzKlsnIl1jaGFyQ29kZUF0WyciXVxzKlxdXChccypcZCtccypcKSI7aTo0OTtzOjE3OiI8L2JvZHk+XHMqPHNjcmlwdCI7aTo1MDtzOjE3OiI8L2h0bWw+XHMqPHNjcmlwdCI7aTo1MTtzOjE3OiI8L2h0bWw+XHMqPGlmcmFtZSI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YTo2Mzp7aTowO3M6MTM6IkludmFsaWRccytUVk4iO2k6MTtzOjExOiJJbnZhbGlkIFJWTiI7aToyO3M6NDA6ImRlZmF1bHRTdGF0dXNccyo9XHMqWyciXUludGVybmV0IEJhbmtpbmciO2k6MztzOjI4OiI8dGl0bGU+XHMqQ2FwaXRlY1xzK0ludGVybmV0IjtpOjQ7czoyNzoiPHRpdGxlPlxzKkludmVzdGVjXHMrT25saW5lIjtpOjU7czozOToiaW50ZXJuZXRccytQSU5ccytudW1iZXJccytpc1xzK3JlcXVpcmVkIjtpOjY7czoxMToiPHRpdGxlPlNhcnMiO2k6NztzOjEzOiI8YnI+QVRNXHMrUElOIjtpOjg7czoxODoiQ29uZmlybWF0aW9uXHMrT1RQIjtpOjk7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMDtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTE7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMjtzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjEzO3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTQ7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNTtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE2O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE3O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxODtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MTk7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIwO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMTtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIyO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjM7czoxMToiQkFOQ09MT01CSUEiO2k6MjQ7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNTtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6MjY7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI3O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjg7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aToyOTtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMwO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMxO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMjtzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjMzO3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNDtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzU7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM2O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozNztzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozODtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjM5O3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDA7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDE7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MjtzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0MztzOjE4OiJcLmh0bWxcP2NtZD1sb2dpbj0iO2k6NDQ7czoxODoiV2VibWFpbFxzKjwvdGl0bGU+IjtpOjQ1O3M6MjM6Ijx0aXRsZT5ccypVUENccytXZWJtYWlsIjtpOjQ2O3M6MTc6IlwucGhwXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTc6IlwuaHRtXD9jbWQ9bG9naW49IjtpOjQ4O3M6MjM6Ilwuc3dlZGJhbmtcLnNlL21kcGF5YWNzIjtpOjQ5O3M6MjQ6IlwuXHMqXCRfUE9TVFxbXHMqWyciXWN2diI7aTo1MDtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1MTtzOjEwOiJCWS1TUDFOMFpBIjtpOjUyO3M6NDU6IlNlY3VyaXR5XHMrcXVlc3Rpb25ccys6XHMrWyciXVxzKlwuXHMqXCRfUE9TVCI7aTo1MztzOjQwOiJpZlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkc2NhbVxzKlwuXHMqXCRpIjtpOjU0O3M6MjA6Ijx0aXRsZT5ccypCZXN0LnRpZ2VuIjtpOjU1O3M6MjA6Ijx0aXRsZT5ccypMQU5ERVNCQU5LIjtpOjU2O3M6NTI6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwucGhwXD9jbWQ9bG9naW4iO2k6NTc7czo1NDoid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaW5kZXhcZCsqXC5odG1sKlw/Y21kPWxvZ2luIjtpOjU4O3M6MjU6Ijx0aXRsZT5ccypNYWlsXHMqPC90aXRsZT4iO2k6NTk7czoyODoiU2llXHMrSWhyXHMrS29udG9ccyo8L3RpdGxlPiI7aTo2MDtzOjI5OiJQYXlwYWxccytLb250b1xzK3ZlcmlmaXppZXJlbiI7aTo2MTtzOjMwOiJcJF9HRVRcW1xzKlsnIl1jY19jb3VudHJ5X2NvZGUiO2k6NjI7czoyOToiPHRpdGxlPk91dGxvb2tccytXZWJccytBY2Nlc3MiO30="));

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

define('AI_VERSION', '20150826');

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

			if (in_array($l_Ext, array('o', 'so', 'pl', 'cgi', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'suspicious'))) 
			{
                $g_UnixExec[] = $l_FileName;
            }


			// which files should be scanned
			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, array(
				'suspicious', 'cgi', 'pl', 'js', 'php', 'php3', 'phtml', 'shtml', 'khtml',
				'php4', 'php5', 'tpl', 'inc', 'htaccess', 'html', 'htm'
			)));
			
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
				if (strpos($l_Content, 'HLKHLKJHKLHJGJG4567869869GGHJ') !== false) {
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

  // HLKHLKJHKLHJGJG4567869869GGHJ

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

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : realpath('.')), $l_Template);

$time_tacked = seconds2Human(microtime(true) - START_TIME);

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
