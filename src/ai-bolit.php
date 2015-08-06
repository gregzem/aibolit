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
define('INTEGRITY_DB_FILE', 'AI-INTEGRITY-DB.php');

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
define('AI_STR_082', "Добавленные файлы");
define('AI_STR_083', "Измененные файлы");
define('AI_STR_084', "Удаленные файлы");
define('AI_STR_085', "Добавленные каталоги");
define('AI_STR_086', "Удаленные каталоги");

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
define('AI_STR_082', "Added files");
define('AI_STR_083', "Modified files");
define('AI_STR_084', "Deleted files");
define('AI_STR_085', "Added directories");
define('AI_STR_086', "Deleted directories");

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
$g_DBShe = unserialize(base64_decode("YTo0MTI6e2k6MDtzOjg6IlpPQlVHVEVMIjtpOjE7czoxMzoiTWFnZWxhbmdDeWJlciI7aToyO3M6MTM6InByb2ZleG9yLmhlbGwiO2k6MztzOjIwOiI8IS0tQ09PS0lFIFVQREFURS0tPiI7aTo0O3M6OToiLy9yYXN0YS8vIjtpOjU7czo1NzoiJHBhcmFtMm1hc2suIilcPVtcPHFxPlwiXSguKj8pKD89W1w8cXE+XCJdIClbXDxxcT5cIl0vc2llIjtpOjY7czoxOToiKTsgJGkrKykkcmV0Lj1jaHIoJCI7aTo3O3M6Mjc6ImVyZWdfcmVwbGFjZSg8cT4mZW1haWwmPHE+LCI7aTo4O3M6MTM6Il1dKSk7fX1ldmFsKCQiO2k6OTtzOjMwOiJmd3JpdGUoZm9wZW4oZGlybmFtZShfX0ZJTEVfXykiO2k6MTA7czoxMToiQmFieV9EcmFrb24iO2k6MTE7czoyNDoiJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjEyO3M6MTU6Ik5ldEBkZHJlc3MgTWFpbCI7aToxMztzOjM0OiJQYXNzd29yZDo8cz4iLiRfUE9TVFs8cT5wYXNzd2Q8cT5dIjtpOjE0O3M6MTU6IkNyZWF0ZWQgQnkgRU1NQSI7aToxNTtzOjEyOiJHSUY4OUE7PD9waHAiO2k6MTY7czoyODoib1RhdDhEM0RzRTgnJn5oVTA2Q0NINTskZ1lTcSI7aToxNztzOjIwOiIkbWQ1PW1kNSgiJHJhbmRvbSIpOyI7aToxODtzOjY6IjN4cDFyMyI7aToxOTtzOjMyOiIkaW09c3Vic3RyKCR0eCwkcCsyLCRwMi0oJHArMikpOyI7aToyMDtzOjE1OiJOaW5qYVZpcnVzIEhlcmUiO2k6MjE7czoyMToiN1AxdGQrTldsaWFJL2hXa1o0Vlg5IjtpOjIyO3M6MTA6Ijxkb3Q+SXJJc1QiO2k6MjM7czoxMDoibmRyb2l8aHRjXyI7aToyNDtzOjEwOiJhbmRleHxvb2dsIjtpOjI1O3M6MTc6IkhhY2tlZCBCeSBFbkRMZVNzIjtpOjI2O3M6MTc6IigkX1BPU1RbImRpciJdKSk7IjtpOjI3O3M6NTU6IigkaW5kYXRhLCRiNjQ9MSl7aWYoJGI2ND09MSl7JGNkPWJhc2U2NF9kZWNvZGUoJGluZGF0YSkiO2k6Mjg7czo3NToiJGltPXN1YnN0cigkaW0sMCwkaSkuc3Vic3RyKCRpbSwkaTIrMSwkaTQtKCRpMisxKSkuc3Vic3RyKCRpbSwkaTQrMTIsc3RybGVuIjtpOjI5O3M6MTg6Ijw/cGhwIGVjaG8gIiMhISMiOyI7aTozMDtzOjEwOiJQdW5rZXIyQm90IjtpOjMxO3M6MTE6IiRzaDNsbENvbG9yIjtpOjMyO3M6NDc6IkBjaHIoKCRoWyRlWyRvXV08PDQpKygkaFskZVsrKyRvXV0pKTt9fWV2YWwoJGQpIjtpOjMzO3M6MzY6InBwY3xtaWRwfHdpbmRvd3MgY2V8bXRrfGoybWV8c3ltYmlhbiI7aTozNDtzOjQwOiJhYmFjaG98YWJpemRpcmVjdG9yeXxhYm91dHxhY29vbnxhbGV4YW5hIjtpOjM1O3M6NToiWmVkMHgiO2k6MzY7czo4OiJkYXJrbWlueiI7aTozNztzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM4O3M6NzoiT29OX0JveSI7aTozOTtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTo0MDtzOjY6Ik00bGwzciI7aTo0MTtzOjI1OiJjcmVhdGVGaWxlc0ZvcklucHV0T3V0cHV0IjtpOjQyO3M6ODoiUGFzaGtlbGEiO2k6NDM7czoyMjoiXmNeYV5sXnBeZV5yXl9eZ15lXnJecCI7aTo0NDtzOjE0OiI9PSAiYmluZHNoZWxsIiI7aTo0NTtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6NDY7czoyNToiaXNzZXQoJF9QT1NUWydleGVjZ2F0ZSddKSI7aTo0NztzOjM3OiJmd3JpdGUoJGZwc2V0diwgZ2V0ZW52KCJIVFRQX0NPT0tJRSIpIjtpOjQ4O3M6MjA6Ii1JL3Vzci9sb2NhbC9iYW5kbWluIjtpOjQ5O3M6MjE6IiRPT08wMDAwMDA9dXJsZGVjb2RlKCI7aTo1MDtzOjg6IllFTkkzRVJJIjtpOjUxO3M6MTU6ImxldGFrc2VrYXJhbmcoKSI7aTo1MjtzOjY6ImQzbGV0ZSI7aTo1MztzOjQzOiJmdW5jdGlvbiB1cmxHZXRDb250ZW50cygkdXJsLCAkdGltZW91dCA9IDUpIjtpOjU0O3M6NDY6Im92ZXJmbG93LXk6c2Nyb2xsO1wiPiIuJGxpbmtzLiRodG1sX21mWydib2R5J10iO2k6NTU7czoxNjoiTWFkZSBieSBEZWxvcmVhbiI7aTo1NjtzOjc1OiJpZihlbXB0eSgkX0dFVFsnemlwJ10pIGFuZCBlbXB0eSgkX0dFVFsnZG93bmxvYWQnXSkgJiBlbXB0eSgkX0dFVFsnaW1nJ10pKXsiO2k6NTc7czo2NToic3RyX3JvdDEzKCRiYXNlYVsoJGRpbWVuc2lvbiokZGltZW5zaW9uLTEpIC0gKCRpKiRkaW1lbnNpb24rJGopXSkiO2k6NTg7czo2MDoiUjBsR09EbGhFd0FRQUxNQUFBQUFBUC8vLzV5Y0FNN09ZLy8vblAvL3p2L09uUGYzOS8vLy93QUFBQUFBIjtpOjU5O3M6NDU6InByZWdfbWF0Y2goJyFNSURQfFdBUHxXaW5kb3dzLkNFfFBQQ3xTZXJpZXM2MCI7aTo2MDtzOjQ3OiJwcmVnX21hdGNoKCcvKD88PVJld3JpdGVSdWxlKS4qKD89XFtMXCxSXD0zMDJcXSI7aTo2MTtzOjM3OiIkdXJsID0gJHVybHNbcmFuZCgwLCBjb3VudCgkdXJscyktMSldIjtpOjYyO3M6ODA6IndwX3Bvc3RzIFdIRVJFIHBvc3RfdHlwZSA9ICdwb3N0JyBBTkQgcG9zdF9zdGF0dXMgPSAncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjYzO3M6NjU6Imh0dHA6Ly8nLiRfU0VSVkVSWydIVFRQX0hPU1QnXS51cmxkZWNvZGUoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjY0O3M6MzY6ImZ3cml0ZSgkZixnZXRfZG93bmxvYWQoJF9HRVRbJ3VybCddKSI7aTo2NTtzOjc0OiIkcGFyYW0geCAkbi5zdWJzdHIgKCRwYXJhbSwgbGVuZ3RoKCRwYXJhbSkgLSBsZW5ndGgoJGNvZGUpJWxlbmd0aCgkcGFyYW0pKSI7aTo2NjtzOjQ3OiIkdGltZV9zdGFydGVkLiRzZWN1cmVfc2Vzc2lvbl91c2VyLnNlc3Npb25faWQoKSI7aTo2NztzOjQ4OiIkdGhpcy0+Ri0+R2V0Q29udHJvbGxlcigkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6Njg7czoyMToibHVjaWZmZXJAbHVjaWZmZXIub3JnIjtpOjY5O3M6Mjc6ImJhc2U2NF9kZWNvZGUoJGNvZGVfc2NyaXB0KSI7aTo3MDtzOjIxOiJ1bmxpbmsoJHdyaXRhYmxlX2RpcnMiO2k6NzE7czo0MToiZmlsZV9nZXRfY29udGVudHModHJpbSgkZlskX0dFVFsnaWQnXV0pKTsiO2k6NzI7czoxMDoiQ3liZXN0ZXI5MCI7aTo3MztzOjI3OiIvaG9tZS9teWRpci9lZ2dkcm9wL2ZpbGVzeXMiO2k6NzQ7czoyOToiLS1EQ0NESVIgW2xpbmRleCAkVXNlcigkaSkgMl0iO2k6NzU7czoxMjoidW5iaW5kIFJBVyAtIjtpOjc2O3M6MTE6InB1dGJvdCAkYm90IjtpOjc3O3M6MTM6InByaXZtc2cgJG5pY2siO2k6Nzg7czoyNjoicHJvYyBodHRwOjpDb25uZWN0IHt0b2tlbn0iO2k6Nzk7czo0Mzoic2V0IGdvb2dsZShkYXRhKSBbaHR0cDo6ZGF0YSAkZ29vZ2xlKHBhZ2UpXSI7aTo4MDtzOjIyOiJiaW5kIGpvaW4gLSAqIGdvcF9qb2luIjtpOjgxO3M6MTM6InByaXZtc2cgJGNoYW4iO2k6ODI7czoyNDoicjRhVGMuZFBudEUvZnp0U0YxYkgzUkgwIjtpOjgzO3M6MTA6ImJpbmQgZGNjIC0iO2k6ODQ7czozNToia2lsbCAtQ0hMRCBcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6ODU7czo1MDoicmVnc3ViIC1hbGwgLS0gLCBbc3RyaW5nIHRvbG93ZXIgJG93bmVyXSAiIiBvd25lcnMiO2k6ODY7czozMDoiYmluZCBmaWx0IC0gIlwwMDFBQ1RJT04gKlwwMDEiIjtpOjg3O3M6Mjc6ImF5dSBwcjEgcHIyIHByMyBwcjQgcHI1IHByNiI7aTo4ODtzOjIwOiJzZXQgcHJvdGVjdC10ZWxuZXQgMCI7aTo4OTtzOjMzOiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGQgLURTU0wiO2k6OTA7czo3NjoiJHRzdTJbcmFuZCgwLGNvdW50KCR0c3UyKSAtIDEpXS4kdHN1MVtyYW5kKDAsY291bnQoJHRzdTEpIC0gMSldLiR0c3UyW3JhbmQoMCI7aTo5MTtzOjE5OiJmb3BlbignL2V0Yy9wYXNzd2QnIjtpOjkyO3M6MzU6IjBkMGEwZDBhNjc2YzZmNjI2MTZjMjAyNDZkNzk1ZjczNmQ3IjtpOjkzO3M6Mzc6IkpIWnBjMmwwWTI5MWJuUWdQU0FrU0ZSVVVGOURUMDlMU1VWZlYiO2k6OTQ7czo1OiJlLyouLyI7aTo5NTtzOjI4OiJAc2V0Y29va2llKCJoaXQiLCAxLCB0aW1lKCkrIjtpOjk2O3M6NDY6ImZpbmRfZGlycygkZ3JhbmRwYXJlbnRfZGlyLCAkbGV2ZWwsIDEsICRkaXJzKTsiO2k6OTc7czo2OToiQGNvcHkoJF9GSUxFU1tmaWxlTWFzc11bdG1wX25hbWVdLCRfUE9TVFtwYXRoXS4kX0ZJTEVTW2ZpbGVNYXNzXVtuYW1lIjtpOjk4O3M6NzY6ImludDMyKCgoJHogPj4gNSAmIDB4MDdmZmZmZmYpIF4gJHkgPDwgMikgKyAoKCR5ID4+IDMgJiAweDFmZmZmZmZmKSBeICR6IDw8IDQiO2k6OTk7czoxMToiVk9CUkEgR0FOR08iO2k6MTAwO3M6NTk6ImVjaG8geSA7IHNsZWVwIDEgOyB9IHwgeyB3aGlsZSByZWFkIDsgZG8gZWNobyB6JFJFUExZOyBkb25lIjtpOjEwMTtzOjk6IjxzdGRsaWIuaCI7aToxMDI7czo0NToiYWRkX2ZpbHRlcigndGhlX2NvbnRlbnQnLCAnX2Jsb2dpbmZvJywgMTAwMDEpIjtpOjEwMztzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aToxMDQ7czoyODoiaWYgc2VsZi5oYXNoX3R5cGUgPT0gJ3B3ZHVtcCI7aToxMDU7czo1OToiJGZyYW1ld29yay5wbHVnaW5zLmxvYWQoIiN7cnBjdHlwZS5kb3duY2FzZX1ycGMiLCBvcHRzKS5ydW4iO2k6MTA2O3M6NTc6InN1YnByb2Nlc3MuUG9wZW4oJyVzZ2RiIC1wICVkIC1iYXRjaCAlcycgJSAoZ2RiX3ByZWZpeCwgcCI7aToxMDc7czo1NzoiYXJncGFyc2UuQXJndW1lbnRQYXJzZXIoZGVzY3JpcHRpb249aGVscCwgcHJvZz0ic2N0dW5uZWwiIjtpOjEwODtzOjMyOiJydWxlX3JlcSA9IHJhd19pbnB1dCgiU291cmNlRmlyZSI7aToxMDk7czo1MDoib3Muc3lzdGVtKCdlY2hvIGFsaWFzIGxzPSIubHMuYmFzaCIgPj4gfi8uYmFzaHJjJykiO2k6MTEwO3M6NDI6ImNvbm5lY3Rpb24uc2VuZCgic2hlbGwgIitzdHIob3MuZ2V0Y3dkKCkpKyI7aToxMTE7czo2NzoicHJpbnQoIlshXSBIb3N0OiAiICsgaG9zdG5hbWUgKyAiIG1pZ2h0IGJlIGRvd24hXG5bIV0gUmVzcG9uc2UgQ29kZSI7aToxMTI7czo2OToiZGVmIGRhZW1vbihzdGRpbj0nL2Rldi9udWxsJywgc3Rkb3V0PScvZGV2L251bGwnLCBzdGRlcnI9Jy9kZXYvbnVsbCcpIjtpOjExMztzOjgzOiJzdWJwcm9jZXNzLlBvcGVuKGNtZCwgc2hlbGwgPSBUcnVlLCBzdGRvdXQ9c3VicHJvY2Vzcy5QSVBFLCBzdGRlcnI9c3VicHJvY2Vzcy5TVERPVSI7aToxMTQ7czo0NzoiaWYoaXNzZXQoJF9HRVRbJ2hvc3QnXSkmJmlzc2V0KCRfR0VUWyd0aW1lJ10pKXsiO2k6MTE1O3M6MTU6Ik5JR0dFUlMuTklHR0VSUyI7aToxMTY7czoyNToiSFRUUCBmbG9vZCBjb21wbGV0ZSBhZnRlciI7aToxMTc7czoyMToiODAgLWIgJDEgLWkgZXRoMCAtcyA4IjtpOjExODtzOjEzOiJleHBsb2l0Y29va2llIjtpOjExOTtzOjI2OiJzeXN0ZW0oInBocCAtZiB4cGwgJGhvc3QiKSI7aToxMjA7czoxMToic2ggZ28gJDEuJHgiO2k6MTIxO3M6MTI6ImF6ODhwaXgwMHE5OCI7aToxMjI7czozMDoidW5sZXNzKG9wZW4oUEZELCRnX3VwbG9hZF9kYikpIjtpOjEyMztzOjExOiJ3d3cudDBzLm9yZyI7aToxMjQ7czozOToiJHZhbHVlID1+IHMvJSguLikvcGFjaygnYycsaGV4KCQxKSkvZWc7IjtpOjEyNTtzOjE0OiJUaGUgRGFyayBSYXZlciI7aToxMjY7czoyOToifWVsc2VpZigkX0dFVFsncGFnZSddPT0nZGRvcyciO2k6MTI3O3M6MTY6InskX1BPU1RbJ3Jvb3QnXX0iO2k6MTI4O3M6Mzk6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kKzMrOHF2cXFTMUswK0FYWSI7aToxMjk7czo2NDoiRkozRmt1UEtGa1UvNTNXRUJtSWFpcGt0bkx3UVc4ejQ5ZGMxcmJiTHFzdzhlNjlsNnZKTSszLzEyNHhWbis3bCI7aToxMzA7czoxMDI6Ilx1MDAzY1x1MDA2OVx1MDA2ZFx1MDA2N1x1MDAyMFx1MDA3M1x1MDA3Mlx1MDA2M1x1MDAzZFx1MDAyMlx1MDA2OFx1MDA3NFx1MDA3NFx1MDA3MFx1MDAzYVx1MDAyZlx1MDAyZiI7aToxMzE7czozMDoiZnJlYWQoJGZwLCBmaWxlc2l6ZSgkZmljaGVybykpIjtpOjEzMjtzOjI0OiIkYmFzbGlrPSRfUE9TVFsnYmFzbGlrJ10iO2k6MTMzO3M6MTg6InByb2Nfb3BlbignSUhTdGVhbSI7aToxMzQ7czo1NjoiXHgzMVx4ZGJceGY3XHhlM1x4NTNceDQzXHg1M1x4NmFceDAyXHg4OVx4ZTFceGIwXHg2Nlx4Y2QiO2k6MTM1O3M6NTg6IkFBQUFBQUFBTUFBd0FCQUFBQWVBVUFBRFFBQUFEc0NRQUFBQUFBQURRQUlBQURBQ2dBRndBVUFBRUEiO2k6MTM2O3M6MzE6IiRpbmlbJ3VzZXJzJ10gPSBhcnJheSgncm9vdCcgPT4iO2k6MTM3O3M6NTg6IkhKM0hqdXRja29SZnBYZjlBMXpRTzJBd0RSclJleTl1R3ZUZWV6NzlxQWFvMWEwcmd1ZGtaa1I4UmEiO2k6MTM4O3M6NTA6ImN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICJodHRwOi8vJGhvc3Q6MjA4MiIpIjtpOjEzOTtzOjY0OiI8JT0gIlwiICYgb1NjcmlwdE5ldC5Db21wdXRlck5hbWUgJiAiXCIgJiBvU2NyaXB0TmV0LlVzZXJOYW1lICU+IjtpOjE0MDtzOjEwNDoic3FsQ29tbWFuZC5QYXJhbWV0ZXJzLkFkZCgoKFRhYmxlQ2VsbClkYXRhR3JpZEl0ZW0uQ29udHJvbHNbMF0pLlRleHQsIFNxbERiVHlwZS5EZWNpbWFsKS5WYWx1ZSA9IGRlY2ltYWwiO2k6MTQxO3M6OTA6IlJlc3BvbnNlLldyaXRlKCI8YnI+KCApIDxhIGhyZWY9P3R5cGU9MSZmaWxlPSIgJiBzZXJ2ZXIuVVJMZW5jb2RlKGl0ZW0ucGF0aCkgJiAiXD4iICYgaXRlbSI7aToxNDI7czoxMTE6Im5ldyBGaWxlU3RyZWFtKFBhdGguQ29tYmluZShmaWxlSW5mby5EaXJlY3RvcnlOYW1lLCBQYXRoLkdldEZpbGVOYW1lKGh0dHBQb3N0ZWRGaWxlLkZpbGVOYW1lKSksIEZpbGVNb2RlLkNyZWF0ZSI7aToxNDM7czo3MToiUmVzcG9uc2UuV3JpdGUoU2VydmVyLkh0bWxFbmNvZGUodGhpcy5FeGVjdXRlQ29tbWFuZCh0eHRDb21tYW5kLlRleHQpKSkiO2k6MTQ0O3M6ODM6IjwlPVJlcXVlc3QuU2VydmVydmFyaWFibGVzKCJTQ1JJUFRfTkFNRSIpJT4/dHh0cGF0aD08JT1SZXF1ZXN0LlF1ZXJ5U3RyaW5nKCJ0eHRwYXRoIjtpOjE0NTtzOjYwOiJvdXRzdHIgKz0gc3RyaW5nLkZvcm1hdCgiPGEgaHJlZj0nP2ZkaXI9ezB9Jz57MX0vPC9hPiZuYnNwOyIiO2k6MTQ2O3M6MzM6InJlLmZpbmRhbGwoZGlydCsnKC4qKScscHJvZ25tKVswXSI7aToxNDc7czo0MDoiZmluZCAvIC1uYW1lIC5zc2ggPiAkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToxNDg7czo2MDoiRlNfY2hrX2Z1bmNfbGliYz0oICQocmVhZGVsZiAtcyAkRlNfbGliYyB8IGdyZXAgX2Noa0BAIHwgYXdrIjtpOjE0OTtzOjQ5OiJMeTgzTVRnM09XUXlNVEprWXpoalltWTBaRFJtWkRBME5HRXpaREUzWmprM1ptSTJOIjtpOjE1MDtzOjk1OiIkZmlsZSA9ICRfRklMRVNbImZpbGVuYW1lIl1bIm5hbWUiXTsgZWNobyAiPGEgaHJlZj1cIiRmaWxlXCI+JGZpbGU8L2E+Ijt9IGVsc2Uge2VjaG8oImVtcHR5Iik7fSI7aToxNTE7czo0ODoiREo3VklVN1JJQ1hyNnNFRVYyY0J0SERTT2U5blZkcEVHaEVtdlJWUk5VUmZ3MXdRIjtpOjE1MjtzOjUxOiJMejhfTHk4dkR4OGVfdjctN3U3dTNzN3V6czdPenE2dW5xN2VycTZ1dnE1LWpvNnVqbjUiO2k6MTUzO3M6ODM6ImlWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFBb0FBQUFJQ0FZQUFBREEtbTYyQUFBQUFYTlNSMElBcnM0YzZRQUFBQVJuUVUxQkFBQ3hqd3Y4WVFVIjtpOjE1NDtzOjUxOiJzZXJ2ZXIuPC9wPlxyXG48L2JvZHk+PC9odG1sPiI7ZXhpdDt9aWYocHJlZ19tYXRjaCgiO2k6MTU1O3M6Nzc6IiRGY2htb2QsJEZkYXRhLCRPcHRpb25zLCRBY3Rpb24sJGhkZGFsbCwkaGRkZnJlZSwkaGRkcHJvYywkdW5hbWUsJGlkZCk6c2hhcmVkIjtpOjE1NjtzOjE1OiJwaHAgIi4kd3NvX3BhdGgiO2k6MTU3O3M6NjE6IiRwcm9kPSJzeSIuInMiLiJ0ZW0iOyRpZD0kcHJvZCgkX1JFUVVFU1RbJ3Byb2R1Y3QnXSk7JHsnaWQnfTsiO2k6MTU4O3M6MzA6IkBhc3NlcnQoJF9SRVFVRVNUWydQSFBTRVNTSUQnXSI7aToxNTk7czo2ODoiUE9TVCB7JHBhdGh9eyRjb25uZWN0b3J9P0NvbW1hbmQ9RmlsZVVwbG9hZCZUeXBlPUZpbGUmQ3VycmVudEZvbGRlcj0iO2k6MTYwO3M6ODc6IiJhZG1pbjEucGhwIiwgImFkbWluMS5odG1sIiwgImFkbWluMi5waHAiLCAiYWRtaW4yLmh0bWwiLCAieW9uZXRpbS5waHAiLCAieW9uZXRpbS5odG1sIiI7aToxNjE7czo5NzoiQHBhdGgxPSgnYWRtaW4vJywnYWRtaW5pc3RyYXRvci8nLCdtb2RlcmF0b3IvJywnd2ViYWRtaW4vJywnYWRtaW5hcmVhLycsJ2JiLWFkbWluLycsJ2FkbWluTG9naW4vJyI7aToxNjI7czozNjoiY2F0ICR7YmxrbG9nWzJdfSB8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjE2MztzOjQ2OiI/dXJsPScuJF9TRVJWRVJbJ0hUVFBfSE9TVCddKS51bmxpbmsoUk9PVF9ESVIuIjtpOjE2NDtzOjQ2OiJsb25nIGludDp0KDAsMyk9cigwLDMpOy0yMTQ3NDgzNjQ4OzIxNDc0ODM2NDc7IjtpOjE2NTtzOjc1OiJjcmVhdGVfZnVuY3Rpb24oIiYkIi4iZnVuY3Rpb24iLCIkIi4iZnVuY3Rpb24gPSBjaHIob3JkKCQiLiJmdW5jdGlvbiktMyk7IikiO2k6MTY2O3M6ODY6ImZ1bmN0aW9uIGdvb2dsZV9ib3QoKSB7JHNVc2VyQWdlbnQgPSBzdHJ0b2xvd2VyKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSk7aWYoIShzdHJwIjtpOjE2NztzOjc0OiJjb3B5KCRfRklMRVNbJ3Vwa2snXVsndG1wX25hbWUnXSwia2svIi5iYXNlbmFtZSgkX0ZJTEVTWyd1cGtrJ11bJ25hbWUnXSkpOyI7aToxNjg7czo2NzoiZm9yICgkdmFsdWUpIHsgcy8mLyZhbXA7L2c7IHMvPC8mbHQ7L2c7IHMvPi8mZ3Q7L2c7IHMvIi8mcXVvdDsvZzsgfSI7aToxNjk7czo0MjoiJGRiX2QgPSBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSwkY29uMSk7IjtpOjE3MDtzOjUxOiJTZW5kIHRoaXMgZmlsZTogPElOUFVUIE5BTUU9InVzZXJmaWxlIiBUWVBFPSJmaWxlIj4iO2k6MTcxO3M6MjI6ImZ3cml0ZSAoJGZwLCAiJHlhemkiKTsiO2k6MTcyO3M6NTI6Im1hcCB7IHJlYWRfc2hlbGwoJF8pIH0gKCRzZWxfc2hlbGwtPmNhbl9yZWFkKDAuMDEpKTsiO2k6MTczO3M6Mjc6IjI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOyI7aToxNzQ7czo1OToiZ2xvYmFsICRteXNxbEhhbmRsZSwgJGRibmFtZSwgJHRhYmxlbmFtZSwgJG9sZF9uYW1lLCAkbmFtZSwiO2k6MTc1O3M6Njk6Il9fYWxsX18gPSBbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXSI7aToxNzY7czoyOToiaWYgKGlzX2ZpbGUoIi90bXAvJGVraW5jaSIpKXsiO2k6MTc3O3M6Mzg6ImlmKCRjbWQgIT0gIiIpIHByaW50IFNoZWxsX0V4ZWMoJGNtZCk7IjtpOjE3ODtzOjI2OiIkY21kID0gKCRfUkVRVUVTVFsnY21kJ10pOyI7aToxNzk7czo1NToiJHVwbG9hZGZpbGUgPSAkcnBhdGguIi8iIC4gJF9GSUxFU1sndXNlcmZpbGUnXVsnbmFtZSddOyI7aToxODA7czozMzoiaWYgKCRmdW5jYXJnID1+IC9ecG9ydHNjYW4gKC4qKS8pIjtpOjE4MTtzOjQ2OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3QuU2VydmVyVmFyaWFibGVzICU+IjtpOjE4MjtzOjQ4OiJpZignJz09KCRkZj1AaW5pX2dldCgnZGlzYWJsZV9mdW5jdGlvbnMnKSkpe2VjaG8iO2k6MTgzO3M6Mzg6IiRmaWxlbmFtZSA9ICRiYWNrdXBzdHJpbmcuIiRmaWxlbmFtZSI7IjtpOjE4NDtzOjI0OiIkZnVuY3Rpb24oJF9QT1NUWydjbWQnXSkiO2k6MTg1O3M6Mjk6ImVjaG8gIkZJTEUgVVBMT0FERUQgVE8gJGRleiI7IjtpOjE4NjtzOjY4OiJpZiAoIUBpc19saW5rKCRmaWxlKSAmJiAoJHIgPSByZWFscGF0aCgkZmlsZSkpICE9IEZBTFNFKSAkZmlsZSA9ICRyOyI7aToxODc7czo4NzoiVU5JT04gU0VMRUNUICcwJyAsICc8PyBzeXN0ZW0oXCRfR0VUW2NwY10pO2V4aXQ7ID8+JyAsMCAsMCAsMCAsMCBJTlRPIE9VVEZJTEUgJyRvdXRmaWxlIjtpOjE4ODtzOjg5OiJpZihtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1siZmljIl1bInRtcF9uYW1lIl0sZ29vZF9saW5rKCIuLyIuJF9GSUxFU1siZmljIl1bIm5hbWUiXSkpKSI7aToxODk7czo3MjoiY29ubmVjdChTT0NLRVQsIHNvY2thZGRyX2luKCRBUkdWWzFdLCBpbmV0X2F0b24oJEFSR1ZbMF0pKSkgb3IgZGllIHByaW50IjtpOjE5MDtzOjUyOiJlbHNlaWYoQGlzX3dyaXRhYmxlKCRGTikgJiYgQGlzX2ZpbGUoJEZOKSkgJHRtcE91dE1GIjtpOjE5MTtzOjY4OiJ3aGlsZSAoJHJvdyA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXN1bHQsTVlTUUxfQVNTT0MpKSBwcmludF9yKCRyb3cpOyI7aToxOTI7czoxODoiJGZlKCIkY21kICAyPiYxIik7IjtpOjE5MztzOjY5OiJzZW5kKFNPQ0s1LCAkbXNnLCAwLCBzb2NrYWRkcl9pbigkcG9ydGEsICRpYWRkcikpIGFuZCAkcGFjb3Rlc3tvfSsrOzsiO2k6MTk0O3M6Njk6In0gZWxzaWYgKCRzZXJ2YXJnID1+IC9eXDooLis/KVwhKC4rPylcQCguKz8pIFBSSVZNU0cgKC4rPykgXDooLispLykgeyI7aToxOTU7czozNzoiZWxzZWlmKGZ1bmN0aW9uX2V4aXN0cygic2hlbGxfZXhlYyIpKSI7aToxOTY7czo3MToic3lzdGVtKCIkY21kIDE+IC90bXAvY21kdGVtcCAyPiYxOyBjYXQgL3RtcC9jbWR0ZW1wOyBybSAvdG1wL2NtZHRlbXAiKTsiO2k6MTk3O3M6NTI6IiRfRklMRVNbJ3Byb2JlJ11bJ3NpemUnXSwgJF9GSUxFU1sncHJvYmUnXVsndHlwZSddKTsiO2k6MTk4O3M6ODc6IiRyYTQ0ICA9IHJhbmQoMSw5OTk5OSk7JHNqOTggPSAic2gtJHJhNDQiOyRtbCA9ICIkc2Q5OCI7JGE1ID0gJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOyI7aToxOTk7czo2NjoibXlzcWxfcXVlcnkoIkNSRUFURSBUQUJMRSBgeHBsb2l0YCAoYHhwbG9pdGAgTE9OR0JMT0IgTk9UIE5VTEwpIik7IjtpOjIwMDtzOjY2OiJwYXNzdGhydSggJGJpbmRpci4ibXlzcWxkdW1wIC0tdXNlcj0kVVNFUk5BTUUgLS1wYXNzd29yZD0kUEFTU1dPUkQiO2k6MjAxO3M6ODQ6IjxhIGhyZWY9JyRQSFBfU0VMRj9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9JGRibmFtZSZ0YWJsZW5hbWU9JHRhYmxlbmFtZSc+U2NoZW1hPC9hPiI7aToyMDI7czo2MDoiaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkkc2hlbGxPdXQ9c3RyaXBzbGFzaGVzKCRzaGVsbE91dCk7IjtpOjIwMztzOjQ3OiJpZiAoIWRlZmluZWQkcGFyYW17Y21kfSl7JHBhcmFte2NtZH09ImxzIC1sYSJ9OyI7aToyMDQ7czoyMzoic2hlbGxfZXhlYygndW5hbWUgLWEnKTsiO2k6MjA1O3M6OTE6ImlmIChtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1snZmlsYSddWyd0bXBfbmFtZSddLCAkY3VyZGlyLiIvIi4kX0ZJTEVTWydmaWxhJ11bJ25hbWUnXSkpIHsiO2k6MjA2O3M6ODM6ImlmIChlbXB0eSgkX1BPU1RbJ3dzZXInXSkpIHskd3NlciA9ICJ3aG9pcy5yaXBlLm5ldCI7fSBlbHNlICR3c2VyID0gJF9QT1NUWyd3c2VyJ107IjtpOjIwNztzOjM2OiI8JT1lbnYucXVlcnlIYXNodGFibGUoInVzZXIubmFtZSIpJT4iO2k6MjA4O3M6NjE6IlB5U3lzdGVtU3RhdGUuaW5pdGlhbGl6ZShTeXN0ZW0uZ2V0UHJvcGVydGllcygpLCBudWxsLCBhcmd2KTsiO2k6MjA5O3M6MzU6ImlmKCEkd2hvYW1pKSR3aG9hbWk9ZXhlYygid2hvYW1pIik7IjtpOjIxMDtzOjM2OiJzaGVsbF9leGVjKCRfUE9TVFsnY21kJ10gLiAiIDI+JjEiKTsiO2k6MjExO3M6NTM6IlBuVmxrV002MyFAI0AmZEt4fm5NRFdNfkR/L0Vzbn54fzZEQCNAJlB+fiw/blksV1B7UG9qIjtpOjIxMjtzOjI1OiIhJF9SRVFVRVNUWyJjOTlzaF9zdXJsIl0pIjtpOjIxMztzOjYwOiIoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0qJCcsICRfUkVRVUVTVFsnY29tbWFuZCddKSkiO2k6MjE0O3M6MjM6IiRsb2dpbj1AcG9zaXhfZ2V0dWlkKCk7IjtpOjIxNTtzOjM4OiJzeXN0ZW0oInVuc2V0IEhJU1RGSUxFOyB1bnNldCBTQVZFSElTVCI7aToyMTY7czozMToiPEhUTUw+PEhFQUQ+PFRJVExFPmNnaS1zaGVsbC5weSI7aToyMTc7czozNjoiZXhlY2woIi9iaW4vc2giLCJzaCIsIi1pIiwoY2hhciopMCk7IjtpOjIxODtzOjI2OiJuY2Z0cHB1dCAtdSAkZnRwX3VzZXJfbmFtZSI7aToyMTk7czoyOToiJGFbaGl0c10nKTsgXHJcbiNlbmRxdWVyeVxyXG4iO2k6MjIwO3M6MjM6Inske3Bhc3N0aHJ1KCRjbWQpfX08YnI+IjtpOjIyMTtzOjQyOiIkYmFja2Rvb3ItPmNjb3B5KCRjZmljaGllciwkY2Rlc3RpbmF0aW9uKTsiO2k6MjIyO3M6NTk6IiRpemlubGVyMj1zdWJzdHIoYmFzZV9jb252ZXJ0KEBmaWxlcGVybXMoJGZuYW1lKSwxMCw4KSwtNCk7IjtpOjIyMztzOjUwOiJmb3IoOyRwYWRkcj1hY2NlcHQoQ0xJRU5ULCBTRVJWRVIpO2Nsb3NlIENMSUVOVCkgeyI7aToyMjQ7czo4OiJBc21vZGV1cyI7aToyMjU7czozNzoicGFzc3RocnUoZ2V0ZW52KCJIVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyMjY7czozOToiJF9fX189QGd6aW5mbGF0ZSgkX19fXykpe2lmKGlzc2V0KCRfUE9TIjtpOjIyNztzOjg1OiIkc3Viaj11cmxkZWNvZGUoJF9HRVRbJ3N1J10pOyRib2R5PXVybGRlY29kZSgkX0dFVFsnYm8nXSk7JHNkcz11cmxkZWNvZGUoJF9HRVRbJ3NkJ10pIjtpOjIyODtzOjMyOiIka2E9Jzw/Ly9CUkUnOyRrYWthPSRrYS4nQUNLLy8/PiI7aToyMjk7czozMToiQ2F1dGFtIGZpc2llcmVsZSBkZSBjb25maWd1cmFyZSI7aToyMzA7czoxMjoiQlJVVEVGT1JDSU5HIjtpOjIzMTtzOjE4OiJwd2QgPiBHZW5lcmFzaS5kaXIiO2k6MjMyO3M6NTY6InhoIC1zICIvdXNyL2xvY2FsL2FwYWNoZS9zYmluL2h0dHBkIC1EU1NMIiAuL2h0dHBkIC1tICQxIjtpOjIzMztzOjQ4OiIkYT0oc3Vic3RyKHVybGVuY29kZShwcmludF9yKGFycmF5KCksMSkpLDUsMSkuYykiO2k6MjM0O3M6MjE6IiFAJF9DT09LSUVbJHNlc3NkdF9rXSI7aToyMzU7czo1ODoiU0VMRUNUIDEgRlJPTSBteXNxbC51c2VyIFdIRVJFIGNvbmNhdChgdXNlcmAsICdAJywgYGhvc3RgKSI7aToyMzY7czo0NDoiY29weSgkX0ZJTEVTW3hdW3RtcF9uYW1lXSwkX0ZJTEVTW3hdW25hbWVdKSkiO2k6MjM3O3M6NTQ6IiRNZXNzYWdlU3ViamVjdCA9IGJhc2U2NF9kZWNvZGUoJF9QT1NUWyJtc2dzdWJqZWN0Il0pOyI7aToyMzg7czoxNzoicmVuYW1lKCJ3c28ucGhwIiwiO2k6MjM5O3M6ODg6IiRyZWRpcmVjdFVSTD0naHR0cDovLycuJHJTaXRlLiRfU0VSVkVSWydSRVFVRVNUX1VSSSddO2lmKGlzc2V0KCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSkiO2k6MjQwO3M6NDA6IiRmaWxlcGF0aD1AcmVhbHBhdGgoJF9QT1NUWydmaWxlcGF0aCddKTsiO2k6MjQxO3M6NDI6Ildvcmtlcl9HZXRSZXBseUNvZGUoJG9wRGF0YVsncmVjdkJ1ZmZlciddKSI7aToyNDI7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjI0MztzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjI0NDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjI0NTtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToyNDY7czoxMjoiUEhQU0hFTEwuUEhQIjtpOjI0NztzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjI0ODtzOjExMDoidnp2NmQraU92dGtkMzhUbEh1OG1RYXZYZG5KQ2JwUWNwWGhOYmJMbVpPcU1vcERaZU5hbGIrVktsZWRoQ2pwVkFNUVNRbnhWSUVDUUFmTHU1S2dMbXdCNmVoUVFHTlNCWWpwZzlnNUdkQmloWG8iO2k6MjQ5O3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjI1MDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjI1MTtzOjE0MjoiNWpiMjBpS1c5eUlITjBjbWx6ZEhJb0pISmxabVZ5WlhJc0ltRndiM0owSWlrZ2IzSWdjM1J5YVhOMGNpZ2tjbVZtWlhKbGNpd2libWxuYldFaUtTQnZjaUJ6ZEhKcGMzUnlLQ1J5WldabGNtVnlMQ0ozWldKaGJIUmhJaWtnYjNJZ2MzUnlhWE4wY2lnayI7aToyNTI7czo0ODoid3NvRXgoJ3RhciBjZnp2ICcgLiBlc2NhcGVzaGVsbGFyZygkX1BPU1RbJ3AyJ10pIjtpOjI1MztzOjg2OiI8bm9icj48Yj4kY2RpciRjZmlsZTwvYj4gKCIuJGZpbGVbInNpemVfc3RyIl0uIik8L25vYnI+PC90ZD48L3RyPjxmb3JtIG5hbWU9Y3Vycl9maWxlPiI7aToyNTQ7czoxNjoiQ29udGVudC1UeXBlOiAkXyI7aToyNTU7czoxNDE6IjwvdGQ+PHRkIGlkPWZhPlsgPGEgdGl0bGU9XCJIb21lOiAnIi5odG1sc3BlY2lhbGNoYXJzKHN0cl9yZXBsYWNlKCJcIiwgJHNlcCwgZ2V0Y3dkKCkpKS4iJy5cIiBpZD1mYSBocmVmPVwiamF2YXNjcmlwdDpWaWV3RGlyKCciLnJhd3VybGVuY29kZSI7aToyNTY7czoxMDc6IkNRYm9HbDdmK3hjQXlVeXN4YjVtS1M2a0FXc25STGRTK3NLZ0dvWldkc3dMRkpaVjh0VnpYc3ErbWVTUEhNeFRJM25TVUI0ZkoydlIzcjNPbnZYdE5BcU42d24vRHRUVGkrQ3UxVU9Kd05MIjtpOjI1NztzOjM5OiJXU09zZXRjb29raWUobWQ1KCRfU0VSVkVSWydIVFRQX0hPU1QnXSkiO2k6MjU4O3M6MTI2OiJYMU5GVTFOSlQwNWJKM1I0ZEdGMWRHaHBiaWRkSUQwZ2RISjFaVHNOQ2lBZ0lDQnBaaUFvSkY5UVQxTlVXeWR5YlNkZEtTQjdEUW9nSUNBZ0lDQnpaWFJqYjI5cmFXVW9KM1I0ZEdGMWRHaGZKeTRrY20xbmNtOTFjQ3dnYlciO2k6MjU5O3M6Mzk6IkpAIVZyQComUkhSd35KTHcuR3x4bGhuTEp+PzEuYndPYnhiUHwhViI7aToyNjA7czoxMToiemVoaXJoYWNrZXIiO2k6MjYxO3M6MTYxOiIoJyInLCcmcXVvdDsnLCRmbikpLiciO2RvY3VtZW50Lmxpc3Quc3VibWl0KCk7XCc+Jy5odG1sc3BlY2lhbGNoYXJzKHN0cmxlbigkZm4pPmZvcm1hdD9zdWJzdHIoJGZuLDAsZm9ybWF0LTMpLicuLi4nOiRmbikuJzwvYT4nLnN0cl9yZXBlYXQoJyAnLGZvcm1hdC1zdHJsZW4oJGZuKSI7aToyNjI7czoxNjA6InByaW50KChpc19yZWFkYWJsZSgkZikgJiYgaXNfd3JpdGVhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiLncoMSkuZm9udCgncmVkJywnUlcnLDMpKS53KDEpOigoKGlzX3JlYWRhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiKS53KDQpOiIiKS4oKGlzX3dyaXRhYmwiO2k6MjYzO3M6NzM6IlIwbEdPRGxoRkFBVUFLSUFBQUFBQVAvLy85M2QzY0RBd0lhR2hnUUVCUC8vL3dBQUFDSDVCQUVBQUFZQUxBQUFBQUFVQUJRQUEiO2k6MjY0O3M6OTA6IjwlPVJlcXVlc3QuU2VydmVyVmFyaWFibGVzKCJzY3JpcHRfbmFtZSIpJT4/Rm9sZGVyUGF0aD08JT1TZXJ2ZXIuVVJMUGF0aEVuY29kZShGb2xkZXIuRHJpdiI7aToyNjU7czoxMTM6Im05MWRDd2dKR1Z2ZFhRcE93MEtjMlZzWldOMEtDUnliM1YwSUQwZ0pISnBiaXdnZFc1a1pXWXNJQ1JsYjNWMElEMGdKSEpwYml3Z01USXdLVHNOQ21sbUlDZ2hKSEp2ZFhRZ0lDWW1JQ0FoSkdWdmRYIjtpOjI2NjtzOjM4OiJSb290U2hlbGwhJyk7c2VsZi5sb2NhdGlvbi5ocmVmPSdodHRwOiI7aToyNjc7czo3NjoiYSBocmVmPSI8P2VjaG8gIiRmaXN0aWsucGhwP2RpemluPSRkaXppbi8uLi8iPz4iIHN0eWxlPSJ0ZXh0LWRlY29yYXRpb246IG5vbiI7aToyNjg7czoxMjc6IkNCMmFUWnBJREV3TWpRdERRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSTNKbGNYVnAiO2k6MjY5O3M6MTIyOiJudCkoZGlza190b3RhbF9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iICIgLiAiRnJlZSBzcGFjZSAiIC4gKGludCkoZGlza19mcmVlX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgPCI7aToyNzA7czozNzoia2xhc3ZheXYuYXNwP3llbmlkb3N5YT08JT1ha3RpZmtsYXMlPiI7aToyNzE7czo0NDoiV1QrUHt+RVcwRXJQT3RuVUAjQCZebF5zUDFsZG55QCNAJm5zaytyMCxHVCsiO2k6MjcyO3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjI3MztzOjEwNToiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrK2pZRFU5MkM5NGpkdERpZit4T1lqRzZDTGh4MzFVbzl4OS9lQVdnc0JLNjBrSzJtTHdxenFkIjtpOjI3NDtzOjg2OiJjcmxmLid1bmxpbmsoJG5hbWUpOycuJGNybGYuJ3JlbmFtZSgifiIuJG5hbWUsICRuYW1lKTsnLiRjcmxmLid1bmxpbmsoImdycF9yZXBhaXIucGhwIiI7aToyNzU7czoxNToiRFhfSGVhZGVyX2RyYXduIjtpOjI3NjtzOjMwOiJbQXY0YmZDWUNTLHhLV2skK1RrVVMseG5HZEF4W08iO2k6Mjc3O3M6MTE6ImN0c2hlbGwucGhwIjtpOjI3ODtzOjQ3OiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj0jZGNkY2RjPlskY21kXSI7aToyNzk7czoxMzoiV1NDUklQVC5TSEVMTCI7aToyODA7czo3OiJjYXN1czE1IjtpOjI4MTtzOjE3OiJhZG1pbkBzcHlncnVwLm9yZyI7aToyODI7czoxNDoidGVtcF9yNTdfdGFibGUiO2k6MjgzO3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjI4NDtzOjk6IkJ5IFBzeWNoMCI7aToyODU7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToyODY7czo4NDoiPHRleHRhcmVhIG5hbWU9XCJwaHBldlwiIHJvd3M9XCI1XCIgY29scz1cIjE1MFwiPiIuQCRfUE9TVFsncGhwZXYnXS4iPC90ZXh0YXJlYT48YnI+IjtpOjI4NztzOjMwOiIkcmFuZF93cml0YWJsZV9mb2xkZXJfZnVsbHBhdGgiO2k6Mjg4O3M6MTA6IkRyLmFib2xhbGgiO2k6Mjg5O3M6NjoiSyFMTDNyIjtpOjI5MDtzOjc6Ik1ySGF6ZW0iO2k6MjkxO3M6MTA6IkMwZGVyei5jb20iO2k6MjkyO3M6MjY6Ik9MQjpQUk9EVUNUOk9OTElORV9CQU5LSU5HIjtpOjI5MztzOjEwOiJCWSBNTU5CT0JaIjtpOjI5NDtzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjI5NTtzOjg6IkhhY2tlYWRvIjtpOjI5NjtzOjU6ImQzYn5YIjtpOjI5NztzOjU6InJhaHVpIjtpOjI5ODtzOjk6Ik1yLkhpVG1hbiI7aToyOTk7czoxMzoiU0VvRE9SLUNsaWVudCI7aTozMDA7czoxMDoiTXJsb29sLmV4ZSI7aTozMDE7czoyNzoiU21hbGwgUEhQIFdlYiBTaGVsbCBieSBaYUNvIjtpOjMwMjtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MzAzO3M6MTM6IldTTzIgV2Vic2hlbGwiO2k6MzA0O3M6MTI6IldlYiBTaGVsbCBieSI7aTozMDU7czozMjoiV2F0Y2ggWW91ciBzeXN0ZW0gU2hhbnkgd2FzIGhlcmUiO2k6MzA2O3M6Mjg6ImRldmVsb3BlZCBieSBEaWdpdGFsIE91dGNhc3QiO2k6MzA3O3M6MTE6IldlYkNvbnRyb2xzIjtpOjMwODtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjMwOTtzOjk6IlczRCBTaGVsbCI7aTozMTA7czo5OiJUaGVfQmVLaVIiO2k6MzExO3M6MTE6IlN0b3JtN1NoZWxsIjtpOjMxMjtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjMxMztzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aTozMTQ7czoyNToiU2ltb3JnaCBTZWN1cml0eSBNYWdhemluZSI7aTozMTU7czoxOToiRy1TZWN1cml0eSBXZWJzaGVsbCI7aTozMTY7czoyNToiU2ltcGxlIFBIUCBiYWNrZG9vciBieSBESyI7aTozMTc7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MzE4O3M6MjA6IlNhZmVfTW9kZSBCeXBhc3MgUEhQIjtpOjMxOTtzOjEwOiJDckB6eV9LaW5nIjtpOjMyMDtzOjIxOiJLQWRvdCBVbml2ZXJzYWwgU2hlbGwiO2k6MzIxO3M6MTY6IlJ1MjRQb3N0V2ViU2hlbGwiO2k6MzIyO3M6MjA6InJlYWxhdXRoPVN2QkQ4NWRJTnUzIjtpOjMyMztzOjE1OiJyZ29kYHMgd2Vic2hlbGwiO2k6MzI0O3M6MTM6InI1N3NoZWxsXC5waHAiO2k6MzI1O3M6NjoiUjU3U3FsIjtpOjMyNjtzOjU6InIwbmluIjtpOjMyNztzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjMyODtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjMyOTtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTozMzA7czo2OiJQSFZheXYiO2k6MzMxO3M6MzU6IlBIUCBTaGVsbCBpcyBhbmludGVyYWN0aXZlIFBIUC1wYWdlIjtpOjMzMjtzOjEzOiJwaHBSZW1vdGVWaWV3IjtpOjMzMztzOjIwOiJQSFAgSFZBIFNoZWxsIFNjcmlwdCI7aTozMzQ7czo5OiJQSFBKYWNrYWwiO2k6MzM1O3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6MzM2O3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjMzNztzOjIxOiJhIHNpbXBsZSBwaHAgYmFja2Rvb3IiO2k6MzM4O3M6MjE6IlBJUkFURVMgQ1JFVyBXQVMgSEVSRSI7aTozMzk7czoxODoiUEhBTlRBU01BLSBOZVcgQ21EIjtpOjM0MDtzOjI2OiJPIEJpUiBLUkFMIFRBS0xpVCBFRGlsRU1FWiI7aTozNDE7czoyMDoiTklYIFJFTU9URSBXRUItU0hFTEwiO2k6MzQyO3M6MjE6Ik5ldHdvcmtGaWxlTWFuYWdlclBIUCI7aTozNDM7czo3OiJOZW9IYWNrIjtpOjM0NDtzOjE2OiJIYWNrZWQgYnkgU2lsdmVyIjtpOjM0NTtzOjg6Ik4zdHNoZWxsIjtpOjM0NjtzOjE0OiJNeVNRTCBXZWJzaGVsbCI7aTozNDc7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjM0ODtzOjE5OiJNeVNRTCBXZWIgSW50ZXJmYWNlIjtpOjM0OTtzOjk6Ik15U1FMIFJTVCI7aTozNTA7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjM1MTtzOjE2OiJNb3JvY2NhbiBTcGFtZXJzIjtpOjM1MjtzOjEwOiJNYXRhbXUgTWF0IjtpOjM1MztzOjU6Im0waHplIjtpOjM1NDtzOjY6Im0wcnRpeCI7aTozNTU7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6MzU2O3M6MTA6Ik1hdGFtdSBNYXQiO2k6MzU3O3M6MzY6Ik1vcm9jY2FuIFNwYW1lcnMgTWEtRWRpdGlvTiBCeSBHaE9zVCI7aTozNTg7czoxMToiTG9jdXM3U2hlbGwiO2k6MzU5O3M6NzoiTGl6MHppTSI7aTozNjA7czo5OiJLQV91U2hlbGwiO2k6MzYxO3M6MTE6ImlNSGFCaVJMaUdpIjtpOjM2MjtzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTozNjM7czoxNzoiSEFDS0VEIEJZIFJFQUxXQVIiO2k6MzY0O3M6MjU6IkhhY2tlZCBCeSBEZXZyLWkgTWVmc2VkZXQiO2k6MzY1O3M6Mjk6Img0bnR1IHNoZWxsIFtwb3dlcmVkIGJ5IHRzb2ldIjtpOjM2NjtzOjEzOiJHcmluYXkgR28wbyRFIjtpOjM2NztzOjE0OiJHb29nMWVfYW5hbGlzdCI7aTozNjg7czoxMToiR0hDIE1hbmFnZXIiO2k6MzY5O3M6MTM6IkdGUyBXZWItU2hlbGwiO2k6MzcwO3M6MjI6InRoaXMgaXMgYSBwcml2MyBzZXJ2ZXIiO2k6MzcxO3M6Mjc6Ikx1dGZlbiBEb3N5YXlpIEFkbGFuZGlyaW5peiI7aTozNzI7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjM3MztzOjIwOiJGaXhlZCBieSBBcnQgT2YgSGFjayI7aTozNzQ7czoyMDoiRW1wZXJvciBIYWNraW5nIFRFQU0iO2k6Mzc1O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjM3NjtzOjE1OiJEZXZyLWkgTWVmc2VkZXQiO2k6Mzc3O3M6MzM6IkRpdmUgU2hlbGwgLSBFbXBlcm9yIEhhY2tpbmcgVGVhbSI7aTozNzg7czoyNDoiU2hlbGwgd3JpdHRlbiBieSBCbDBvZDNyIjtpOjM3OTtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjM4MDtzOjc6ImQwbWFpbnMiO2k6MzgxO3M6MTE6IkN5YmVyIFNoZWxsIjtpOjM4MjtzOjIzOiJURUFNIFNDUklQVElORyAtIFJPRE5PQyI7aTozODM7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjM4NDtzOjM4OiJDb2RlZCBieSA6IFN1cGVyLUNyeXN0YWwgYW5kIE1vaGFqZXIyMiI7aTozODU7czoyMjoiY29va2llbmFtZSA9ICJ3aWVlZWVlIiI7aTozODY7czo5OiJDOTkgU2hlbGwiO2k6Mzg3O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjM4ODtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjM4OTtzOjk6ImMyMDA3LnBocCI7aTozOTA7czozMDoiV3JpdHRlbiBieSBDYXB0YWluIENydW5jaCBUZWFtIjtpOjM5MTtzOjExOiJkZXZpbHpTaGVsbCI7aTozOTI7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjM5MztzOjc6IkJsMG9kM3IiO2k6Mzk0O3M6MjI6IkNvZGVkIEJ5IENoYXJsaWNoYXBsaW4iO2k6Mzk1O3M6OToiYVpSYWlMUGhQIjtpOjM5NjtzOjE2OiJBU1BYIFNoZWxsIGJ5IExUIjtpOjM5NztzOjEyOiJBTEVNaU4gS1JBTGkiO2k6Mzk4O3M6MTQ6IkFudGljaGF0IHNoZWxsIjtpOjM5OTtzOjY6IjB4ZGQ4MiI7aTo0MDA7czo5OiJ+IFNoZWxsIEkiO2k6NDAxO3M6MTQ6Il9zaGVsbF9hdGlsZGlfIjtpOjQwMjtzOjExOiJQLmgucC5TLnAueSI7aTo0MDM7czoxMDoiMS4xNzkuMjQ5LiI7aTo0MDQ7czoxMToiNjQuMjMzLjE2MC4iO2k6NDA1O3M6OToiNjQuNjguODAuIjtpOjQwNjtzOjExOiIyMTYuMjM5LjMyLiI7aTo0MDc7czo4OiJORzY4OVNrdyI7aTo0MDg7czo4OiJSNHBINHgwciI7aTo0MDk7czo1OiJINHhPciI7aTo0MTA7czoxNToiPT09Ojo6bWFkOjo6PT09IjtpOjQxMTtzOjIzOiIkR0xPQkFMU1tuZXh0XVs8cXE+bmV4dCI7fQ=="));
$gX_DBShe = unserialize(base64_decode("YTo2NTp7aTowO3M6OToiQkxBQ0tVTklYIjtpOjE7czo5OiJyM3Yzbmc0bnMiO2k6MjtzOjIyOiJyb290Ong6MDowOnJvb3Q6L3Jvb3Q6IjtpOjM7czo5OiJDZW5naXpIYW4iO2k6NDtzOjEwOiJKaW5wYW50b216IjtpOjU7czoxNDoiS2luZ1NrcnVwZWxsb3MiO2k6NjtzOjk6IjFuNzNjdDEwbiI7aTo3O3M6MTA6IkppbnBhbnRvbXoiO2k6ODtzOjk6IkRlaWRhcmF+WCI7aTo5O3M6MTU6Ik1yLlNoaW5jaGFuWDE5NiI7aToxMDtzOjE0OiJNZXhpY2FuSGFja2VycyI7aToxMTtzOjE1OiJIQUNLRUQgQlkgU1RPUk0iO2k6MTI7czo3OiJLa0sxMzM3IjtpOjEzO3M6NzoiazJsbDMzZCI7aToxNDtzOjE1OiJEYXJrQ3Jld0ZyaWVuZHMiO2k6MTU7czoxMToiU2ltQXR0YWNrZXIiO2k6MTY7czoxMjoiXVtyb3VuZCgwKV0oIjtpOjE3O3M6MzI6IjwhLS0jZXhlYyBjbWQ9IiRIVFRQX0FDQ0VQVCIgLS0+IjtpOjE4O3M6NDoiQW0hciI7aToxOTtzOjg6Iltjb2RlcnpdIjtpOjIwO3M6MTE6IlsgUGhwcm94eSBdIjtpOjIxO3M6NzoiRGVmYWNlciI7aToyMjtzOjExOiJEZXZpbEhhY2tlciI7aToyMztzOjc6IndlYnIwMHQiO2k6MjQ7czo2OiJrMGQuY2MiO2k6MjU7czo1NToiaXNfY2FsbGFibGUoJ2V4ZWMnKSBhbmQgIWluX2FycmF5KCdleGVjJywgJGRpc2FibGVmdW5jcyI7aToyNjtzOjE0OiIkR0xPQkFMU1snX19fXyI7aToyNztzOjE4OiJpc193cml0YWJsZSgiL3Zhci8iO2k6Mjg7czoyMzoiZXZhbChmaWxlX2dldF9jb250ZW50cygiO2k6Mjk7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aTozMDtzOjQ5OiInaHR0cGQuY29uZicsJ3Zob3N0cy5jb25mJywnY2ZnLnBocCcsJ2NvbmZpZy5waHAnIjtpOjMxO3M6NzoiYnIwd3MzciI7aTozMjtzOjc6Im1pbHcwcm0iO2k6MzM7czozNjoiaW5jbHVkZSgkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pIjtpOjM0O3M6MTA6ImRpciAvT0cgL1giO2k6MzU7czozNDoiaWYgKCgkcGVybXMgJiAweEMwMDApID09IDB4QzAwMCkgeyI7aTozNjtzOjU5OiJpZiAoaXNfY2FsbGFibGUoImV4ZWMiKSBhbmQgIWluX2FycmF5KCJleGVjIiwkZGlzYWJsZWZ1bmMpKSI7aTozNztzOjQwOiJzZXRjb29raWUoICJteXNxbF93ZWJfYWRtaW5fdXNlcm5hbWUiICk7IjtpOjM4O3M6MTk6InByaW50ICJTcGFtZWQnPjxicj4iO2k6Mzk7czo1MToiJG1lc3NhZ2UgPSBlcmVnX3JlcGxhY2UoIiU1QyUyMiIsICIlMjIiLCAkbWVzc2FnZSk7IjtpOjQwO3M6MTU6Ii9ldGMvbmFtZWQuY29uZiI7aTo0MTtzOjEwOiIvZXRjL2h0dHBkIjtpOjQyO3M6MTE6Ii92YXIvY3BhbmVsIjtpOjQzO3M6MTg6Ik5lIHVkYWxvcyB6YWdydXppdCI7aTo0NDtzOjE0OiJleGVjKCJybSAtciAtZiI7aTo0NTtzOjg6IlNoZWxsIE9rIjtpOjQ2O3M6MTE6Im15c2hlbGxleGVjIjtpOjQ3O3M6OToicm9vdHNoZWxsIjtpOjQ4O3M6OToiYW50aXNoZWxsIjtpOjQ5O3M6MTI6InI1N3NoZWxsLnBocCI7aTo1MDtzOjExOiJMb2N1czdTaGVsbCI7aTo1MTtzOjExOiJTdG9ybTdTaGVsbCI7aTo1MjtzOjg6Ik4zdHNoZWxsIjtpOjUzO3M6MTE6ImRldmlselNoZWxsIjtpOjU0O3M6MTI6IldlYiBTaGVsbCBieSI7aTo1NTtzOjc6IkZ4Yzk5c2giO2k6NTY7czo4OiJjaWhzaGVsbCI7aTo1NztzOjc6Ik5URGFkZHkiO2k6NTg7czo4OiJyNTdzaGVsbCI7aTo1OTtzOjg6ImM5OXNoZWxsIjtpOjYwO3M6NjI6IjxkaXYgY2xhc3M9ImJsb2NrIGJ0eXBlMSI+PGRpdiBjbGFzcz0iZHRvcCI+PGRpdiBjbGFzcz0iZGJ0bSI+IjtpOjYxO3M6OToiUm9vdFNoZWxsIjtpOjYyO3M6ODoicGhwc2hlbGwiO2k6NjM7czoyNDoiWW91IGNhbiBwdXQgYSBtZDUgc3RyaW5nIjtpOjY0O3M6NzoiZGVmYWNlciI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNzY6e2k6MDtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjE7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aToyO3M6NTg6ImZ1bmN0aW9uXHMrcmVhZF9waWNcKFxzKlwkQVxzKlwpXHMqe1xzKlwkYVxzKj1ccypcJF9TRVJWRVIiO2k6MztzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjQ7czo2MjoibGlzdFxzKlwoXHMqXCRob3N0XHMqLFxzKlwkcG9ydFxzKixccypcJHNpemVccyosXHMqXCRleGVjX3RpbWUiO2k6NTtzOjQxOiJsaXN0aW5nX3BhZ2VcKFxzKm5vdGljZVwoXHMqWyciXXN5bWxpbmtlZCI7aTo2O3M6MzU6Im1ha2VfZGlyX2FuZF9maWxlXChccypcJHBhdGhfam9vbWxhIjtpOjc7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjg7czo0MToiJiZccyohZW1wdHlcKFxzKlwkX0NPT0tJRVxbWyciXWZpbGxbJyJdXF0iO2k6OTtzOjMzOiJmaWxlX2V4aXN0c1xzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6MTA7czo1OToic3RyX3JlcGxhY2VcKFwkZmluZFxzKixccypcJGZpbmRccypcLlxzKlwkaHRtbFxzKixccypcJHRleHQiO2k6MTE7czozNjoiXCRkYXRhbWFzaWk9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjEyO3M6MzQ6IlwkYWRkZGF0ZT1kYXRlXCgiRCBNIGQsIFkgZzppIGEiXCkiO2k6MTM7czoxODoiZnVja1xzK3lvdXJccyttYW1hIjtpOjE0O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE1O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MTY7czoyODoiYXJyYXlcKFwkZW4sXCRlcyxcJGVmLFwkZWxcKSI7aToxNztzOjQ2OiJsb2Nccyo9XHMqWyciXXswLDF9PFw/ZWNob1xzK1wkcmVkaXJlY3Q7XHMqXD8+IjtpOjE4O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjE5O3M6MTg6Ij09MFwpe2pzb25RdWl0XChcJCI7aToyMDtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIxO3M6MzA6Ijo6WyciXVwucGhwdmVyc2lvblwoXClcLlsnIl06OiI7aToyMjtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMztzOjEzOiIiPT5cJHtcJHsiXFx4IjtpOjI0O3M6NDI6ImZzb2Nrb3BlblwoXCRtXFswXF0sXCRtXFsxMFxdLFwkXyxcJF9fLFwkbSI7aToyNTtzOjMzOiJlVmFMXChccyp0cmltXChccypiYVNlNjRfZGVDb0RlXCgiO2k6MjY7czo0NjoiZWNob1xzKm1kNVwoXCRfUE9TVFxbWyciXXswLDF9Y2hlY2tbJyJdezAsMX1cXSI7aToyNztzOjI1OiJpbWcgc3JjPVsnIl1vcGVyYTAwMFwucG5nIjtpOjI4O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6Mjk7czo0MDoic3Vic3RyX2NvdW50XChnZXRlbnZcKFxcWyciXUhUVFBfUkVGRVJFUiI7aTozMDtzOjMxOiJ3ZWJpXC5ydS93ZWJpX2ZpbGVzL3BocF9saWJtYWlsIjtpOjMxO3M6NjU6ImNocjI9XChcKGVuYzImMTVcKTw8NFwpXHxcKGVuYzM+PjJcKTtjaHIzPVwoXChlbmMzJjNcKTw8NlwpXHxlbmM0IjtpOjMyO3M6MTI6IlJFUkVGRVJfUFRUSCI7aTozMztzOjk6InRzb2hfcHR0aCI7aTozNDtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MzU7czo0NzoibW1jcnlwdFwoXCRkYXRhLCBcJGtleSwgXCRpdiwgXCRkZWNyeXB0ID0gRkFMU0UiO2k6MzY7czoxMzoiZm9wb1wuY29tXC5hciI7aTozNztzOjIwOiJzcHJhdm9jaG5pay1ub21lcm92LSI7aTozODtzOjE4OiJpY3EtZGx5YS10ZWxlZm9uYS0iO2k6Mzk7czoxNzoidGVsZWZvbm5heWEtYmF6YS0iO2k6NDA7czoyNjoic2xlc2hcK3NsZXNoXCtkb21lblwrcG9pbnQiO2k6NDE7czoyMjoic3JjPSJmaWxlc19zaXRlL2pzXC5qcyI7aTo0MjtzOjk1OiJcJHQ9XCRzO1xzKlwkb1xzKj1ccypbJyJdWyciXTtccypmb3JcKFwkaT0wO1wkaTxzdHJsZW5cKFwkdFwpO1wkaVwrXCtcKXtccypcJG9ccypcLj1ccypcJHR7XCRpfSI7aTo0MztzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo0NDtzOjUxOiJAKm1haWxcKFwkbW9zQ29uZmlnX21haWxmcm9tLCBcJG1vc0NvbmZpZ19saXZlX3NpdGUiO2k6NDU7czo2NjoiXCRbYS16QS1aMC05X10rPy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8vXCouezEsMTB9XCovIjtpOjQ2O3M6MTc6IkBcJF9QT1NUXFtcKGNoclwoIjtpOjQ3O3M6MzM6IjxcP3BocFxzK3JlbmFtZVwoWyciXXdzb1wucGhwWyciXSI7aTo0ODtzOjUyOiJcJHN0cj1bJyJdezAsMX08aDE+NDAzXHMrRm9yYmlkZGVuPC9oMT48IS0tXHMqdG9rZW46IjtpOjQ5O3M6NTA6ImNodW5rX3NwbGl0XChiYXNlNjRfZW5jb2RlXChmcmVhZFwoXCR7XCR7WyciXXswLDF9IjtpOjUwO3M6NjA6ImluaV9nZXRcKFsnIl17MCwxfWZpbHRlclwuZGVmYXVsdF9mbGFnc1snIl17MCwxfVwpXCl7Zm9yZWFjaCI7aTo1MTtzOjM4OiJmaWxlX2dldF9jb250ZW50c1wodHJpbVwoXCRmXFtcJF9HRVRcWyI7aTo1MjtzOjEzMzoibWFpbFwoXCRhcnJcW1snIl17MCwxfXRvWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfXN1YmpbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9bXNnWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfWhlYWRbJyJdezAsMX1cXVwpOyI7aTo1MztzOjU0OiJpZlwoaXNzZXRcKFwkX1BPU1RcW1snIl17MCwxfW1zZ3N1YmplY3RbJyJdezAsMX1cXVwpXCkiO2k6NTQ7czozNToiYmFzZTY0X2RlY29kZVwoXCRfUE9TVFxbWyciXXswLDF9Xy0iO2k6NTU7czo1MzoicmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25cKFxzKlsnIl17MCwxfXJlYWRfYW5zX2NvZGUiO2k6NTY7czo3NToiXCRwYXJhbVxzKj1ccypcJHBhcmFtXHMqeFxzKlwkblwuc3Vic3RyXHMqXChcJHBhcmFtXHMqLFxzKmxlbmd0aFwoXCRwYXJhbVwpIjtpOjU3O3M6MjQ6ImJhc2VbJyJdezAsMX1cLlwoMzJcKjJcKSI7aTo1ODtzOjY2OiJpZlwoQFwkdmFyc1woZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXHMqXD9ccypzdHJpcHNsYXNoZXNcKFwkdXJpXCkiO2k6NTk7czoyOToiXClcXTt9aWZcKGlzc2V0XChcJF9TRVJWRVJcW18iO2k6NjA7czo0MjoiaWZcKGVtcHR5XChcJF9DT09LSUVcW1snIl14WyciXVxdXClcKXtlY2hvIjtpOjYxO3M6NTI6ImlzX3dyaXRhYmxlXChcJGRpclwuWyciXXdwLWluY2x1ZGVzL3ZlcnNpb25cLnBocFsnIl0iO2k6NjI7czoyMToiQXBwbGVccytTcEFtXHMrUmVadWxUIjtpOjYzO3M6MTg6IlwjXHMqc3RlYWx0aFxzKmJvdCI7aTo2NDtzOjIzOiJcI1xzKnNlY3VyaXR5c3BhY2VcLmNvbSI7aTo2NTtzOjI4OiJVUkw9PFw/ZWNob1xzK1wkaW5kZXg7XHMrXD8+IjtpOjY2O3M6OTU6IjxzY3JpcHRccyt0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzK3NyYz1bJyJdezAsMX1qcXVlcnktdVwuanNbJyJdezAsMX0+PC9zY3JpcHQ+IjtpOjY3O3M6NTc6ImNyZWF0ZV9mdW5jdGlvblwoWyciXVsnIl0sXHMqXCRvcHRcWzFcXVxzKlwuXHMqXCRvcHRcWzRcXSI7aTo2ODtzOjUwOiJmaWxlX3B1dF9jb250ZW50c1woU1ZDX1NFTEZccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTo2OTtzOjUxOiJcJGFsbGVtYWlsc1xzKj1ccypAc3BsaXRcKCJcXG4iXHMqLFxzKlwkZW1haWxsaXN0XCkiO2k6NzA7czoxODoiSm9vbWxhX2JydXRlX0ZvcmNlIjtpOjcxO3M6Mzg6Ilwkc3lzX3BhcmFtc1xzKj1ccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjcyO3M6MzU6ImZ3cml0ZVxzKlwoXHMqXCRmbHdccyosXHMqXCRmbFxzKlwpIjtpOjczO3M6ODY6ImZpbGVfcHV0X2NvbnRlbnRzXHMqXChbJyJdezAsMX0xXC50eHRbJyJdezAsMX1ccyosXHMqcHJpbnRfclxzKlwoXHMqXCRfUE9TVFxzKixccyp0cnVlIjtpOjc0O3M6ODA6IlwkaGVhZGVyc1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9aGVhZGVyc1snIl17MCwxfVxdIjtpOjc1O3M6NDQ6ImNyZWF0ZV9mdW5jdGlvblxzKlwoWyciXVsnIl1ccyosXHMqc3RyX3JvdDEzIjtpOjc2O3M6MzM6ImRpZVxzKlwoXHMqUEhQX09TXHMqXC5ccypjaHJccypcKCI7aTo3NztzOjU1OiJpZlxzKlwobWQ1XCh0cmltXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjc4O3M6NDQ6ImZccyo9XHMqXCRxXHMqXC5ccypcJGFccypcLlxzKlwkYlxzKlwuXHMqXCR4IjtpOjc5O3M6NDE6ImNvbnRlbnQ9WyciXXswLDF9MTtVUkw9Y2dpLWJpblwuaHRtbFw/Y21kIjtpOjgwO3M6NjM6IlwkdXJsWyciXXswLDF9XHMqXC5ccypcJHNlc3Npb25faWRccypcLlxzKlsnIl17MCwxfS9sb2dpblwuaHRtbCI7aTo4MTtzOjY0OiJcJF9TRVNTSU9OXFtbJyJdezAsMX1zZXNzaW9uX3BpblsnIl17MCwxfVxdXHMqPVxzKlsnIl17MCwxfVwkUElOIjtpOjgyO3M6NDI6ImZzb2Nrb3BlblxzKlwoXHMqXCRDb25uZWN0QWRkcmVzc1xzKixccyoyNSI7aTo4MztzOjQ3OiJlY2hvXHMrXCRpZnVwbG9hZD1bJyJdezAsMX1ccypJdHNPa1xzKlsnIl17MCwxfSI7aTo4NDtzOjc3OiJwcmVnX21hdGNoXChbJyJdL1woeWFuZGV4XHxnb29nbGVcfGJvdFwpL2lbJyJdLFxzKmdldGVudlwoWyciXUhUVFBfVVNFUl9BR0VOVCI7aTo4NTtzOjUyOiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxdIjtpOjg2O3M6NTc6IlwkT09PME8wTzAwPV9fRklMRV9fO1xzKlwkT08wME8wMDAwXHMqPVxzKjB4MWI1NDA7XHMqZXZhbCI7aTo4NztzOjEyOiJCeVxzK1dlYlJvb1QiO2k6ODg7czo4MDoiaGVhZGVyXChbJyJdezAsMX1zOlxzKlsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXHMqXChccypbJyJdezAsMX1uWyciXXswLDF9XHMqXCkiO2k6ODk7czo3MzoibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyciXXswLDF9ZWxpZlsnIl17MCwxfVxdXFtbJyJdezAsMX10bXBfbmFtZSI7aTo5MDtzOjYyOiJcJGd6aXBccyo9XHMqQCpnemluZmxhdGVccypcKFxzKkAqc3Vic3RyXHMqXChccypcJGd6ZW5jb2RlX2FyZyI7aTo5MTtzOjgzOiJpZlxzKlwoXHMqbWFpbFxzKlwoXHMqXCRtYWlsc1xbXCRpXF1ccyosXHMqXCR0ZW1hXHMqLFxzKmJhc2U2NF9lbmNvZGVccypcKFxzKlwkdGV4dCI7aTo5MjtzOjg0OiJmd3JpdGVccypcKFxzKlwkZmhccyosXHMqc3RyaXBzbGFzaGVzXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6OTM7czo5NDoiZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypiYXNlNjRfdXJsX2RlY29kZVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo5NDtzOjYwOiJpZlxzKlwoXHMqQCptZDVccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6OTU7czo5OToiY2hyXHMqXChccyoxMDFccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMThccypcKVxzKlwuXHMqY2hyXHMqXChccyo5N1xzKlwpXHMqXC5ccypjaHJccypcKFxzKjEwOFxzKlwpIjtpOjk2O3M6MTUyOiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccypcKSI7aTo5NztzOjc1OiJcJHJlc3VsdEZVTFxzKj1ccypzdHJpcGNzbGFzaGVzXHMqXChccypcJF9QT1NUXFtbJyJdezAsMX1yZXN1bHRGVUxbJyJdezAsMX0iO2k6OTg7czoxNToiL3Vzci9zYmluL2h0dHBkIjtpOjk5O3M6MzI6IlBSSVZNU0dcLlwqOlwub3duZXJcXHNcK1woXC5cKlwpIjtpOjEwMDtzOjgzOiJwcmludFxzK1wkc29ja1xzK1snIl17MCwxfU5JQ0sgWyciXXswLDF9XHMrXC5ccytcJG5pY2tccytcLlxzK1snIl17MCwxfVxcblsnIl17MCwxfSI7aToxMDE7czo4MDoiXCR1cmxccyo9XHMqXCR1cmxccypcLlxzKlsnIl17MCwxfVw/WyciXXswLDF9XHMqXC5ccypodHRwX2J1aWxkX3F1ZXJ5XChcJHF1ZXJ5XCkiO2k6MTAyO3M6MTIzOiJwcmVnX21hdGNoX2FsbFwoWyciXXswLDF9LzxhIGhyZWY9IlxcL3VybFxcXD9xPVwoXC5cK1w/XClcWyZcfCJcXVwrL2lzWyciXXswLDF9LCBcJHBhZ2VcW1snIl17MCwxfWV4ZVsnIl17MCwxfVxdLCBcJGxpbmtzXCkiO2k6MTAzO3M6MTAxOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9WyciXXswLDF9SmF2YVNjcmlwdFsnIl17MCwxfT5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovLyI7aToxMDQ7czo3ODoiXCRwXHMqPVxzKnN0cnBvc1xzKlwoXHMqXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjEwNTtzOjE1OiJcKG1zaWVcfG9wZXJhXCkiO2k6MTA2O3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6MTA3O3M6OTk6ImlmXHMqXChccyppc19kaXJccypcKFxzKlwkRnVsbFBhdGhccypcKVxzKlwpXHMqQWxsRGlyXHMqXChccypcJEZ1bGxQYXRoXHMqLFxzKlwkRmlsZXNccypcKTtccyp9XHMqfSI7aToxMDg7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjEwOTtzOjU0OiI8IS0tXCNleGVjXHMrY21kPVsnIl17MCwxfVwkSFRUUF9BQ0NFUFRbJyJdezAsMX1ccyotLT4iO2k6MTEwO3M6MjY6IlxbLVxdXHMrQ29ubmVjdGlvblxzK2ZhaWxkIjtpOjExMTtzOjYzOiJpZlwoL1xeXFw6XCRvd25lciFcLlwqXFxAXC5cKlBSSVZNU0dcLlwqOlwubXNnZmxvb2RcKFwuXCpcKS9cKXsiO2k6MTEyO3M6MzQ6InByaW50XHMqXCRzb2NrICJQUklWTVNHICJcLlwkb3duZXIiO2k6MTEzO3M6NjQ6IlxdPVsnIl17MCwxfWlwWyciXXswLDF9XHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfU0VSVkVSXFsiO2k6MTE0O3M6NTE6IlxdXHMqfVxzKj1ccyp0cmltXHMqXChccyphcnJheV9wb3BccypcKFxzKlwke1xzKlwkeyI7aToxMTU7czozMToicHJpbnRcKCJcI1xzK2luZm9ccytPS1xcblxcbiJcKSI7aToxMTY7czoxMTI6IlwkdXNlcl9hZ2VudFxzKj1ccypwcmVnX3JlcGxhY2VccypcKFxzKlsnIl1cfFVzZXJcXFwuQWdlbnRcXDpcW1xccyBcXVw/XHxpWyciXVxzKixccypbJyJdWyciXVxzKixccypcJHVzZXJfYWdlbnQiO2k6MTE3O3M6NzI6IlwkcFxzKj1ccypzdHJwb3NcKFwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxMTg7czo5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChccypbJyJdXCRtWyciXVxzKixccypbJyJdaWZccypcKFxzKlwkbVxzKlxbXHMqMHgwMVxzKlxdXHMqPT1ccypbJyJdTFsnIl0iO2k6MTE5O3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjEyMDtzOjk6IklySXNUXC5JciI7aToxMjE7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMjI7czozMjoiXCRwb3N0XHMqPVxzKlsnIl1cXHg3N1xceDY3XFx4NjUiO2k6MTIzO3M6Mjc6ImVjaG9ccypbJyJdYW5zd2VyPWVycm9yWyciXSI7aToxMjQ7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMjU7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEyNjtzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMjc7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEyODtzOjUyOiJlY2hvWyciXXswLDF9PGNlbnRlcj48Yj5Eb25lXHMqPT0+XHMqXCR1c2VyZmlsZV9uYW1lIjtpOjEyOTtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTMwO3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTMxO3M6NTE6IlwpXHMqXC5ccypzdWJzdHJccypcKFxzKm1kNVxzKlwoXHMqc3RycmV2XHMqXChccypcJCI7aToxMzI7czo2NToiXCRmbFxzKj1ccyoiPG1ldGEgaHR0cC1lcXVpdj1cXCJSZWZyZXNoXFwiXHMrY29udGVudD1cXCIwO1xzKlVSTD0iO2k6MTMzO3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMzQ7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTM1O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjEzNjtzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTM3O3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjEzODtzOjY1OiJ1cmxlbmNvZGVcKHByaW50X3JcKGFycmF5XChcKSwxXClcKSw1LDFcKVwuY1wpLFwkY1wpO31ldmFsXChcJGRcKSI7aToxMzk7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTQwO3M6NDM6ImZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDQwMDBccystbHMiO2k6MTQxO3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjE0MjtzOjQxOiJmdW5jdGlvblxzK2luamVjdFwoXCRmaWxlLFxzKlwkaW5qZWN0aW9uPSI7aToxNDM7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTQ0O3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjE0NTtzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTQ2O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxNDc7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aToxNDg7czozOToiZXZhbFxzKlwoKlxzKnN0cnJldlxzKlwoKlxzKnN0cl9yZXBsYWNlIjtpOjE0OTtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjE1MDtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjE1MTtzOjIzMjoiaXNzZXRccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccyppc191cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqY29weVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXSI7aToxNTI7czo4NzoiaWZccypcKFxzKlwkaVxzKjxccypcKFxzKmNvdW50XHMqXChccypcJF9QT1NUXFtccypbJyJdezAsMX1xWyciXXswLDF9XHMqXF1ccypcKVxzKi1ccyoxIjtpOjE1MztzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjE1NDtzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTU1O3M6OTc6ImNvbnRlbnQ9WyciXXswLDF9bm8tY2FjaGVbJyJdezAsMX07XHMqXCRjb25maWdcW1snIl17MCwxfWRlc2NyaXB0aW9uWyciXXswLDF9XF1ccypcLj1ccypbJyJdezAsMX0iO2k6MTU2O3M6NzQ6ImNsZWFyc3RhdGNhY2hlXChccypcKTtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRmbGRccypcKVxzKlwpXHMqcmV0dXJuIjtpOjE1NztzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjE1ODtzOjk6IklyU2VjVGVhbSI7aToxNTk7czo3MzoiQGhlYWRlclwoWyciXUxvY2F0aW9uOlxzKlsnIl1cLlsnIl1oWyciXVwuWyciXXRbJyJdXC5bJyJddFsnIl1cLlsnIl1wWyciXSI7aToxNjA7czo2Nzoic2V0X3RpbWVfbGltaXRccypcKFxzKjBccypcKTtccyppZlxzKlwoIVNlY3JldFBhZ2VIYW5kbGVyOjpjaGVja0tleSI7aToxNjE7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTYyO3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxNjM7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6MTY0O3M6NDc6InN0cl9yb3QxM1xzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE2NTtzOjUwOiJnenVuY29tcHJlc3NccypcKFxzKnN0cl9yb3QxM1xzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToxNjY7czo1MDoiZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypzdHJfcm90MTMiO2k6MTY3O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzXHMqXChccypzdHJyZXYiO2k6MTY4O3M6NjE6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2XHMqXChccypzdHJfcm90MTMiO2k6MTY5O3M6NDQ6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RycmV2IjtpOjE3MDtzOjY4OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzE7czo1NDoiYmFzZTY0X2RlY29kZVxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlIjtpOjE3MjtzOjQ3OiJnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKnN0cl9yb3QxMyI7aToxNzM7czo0NzoiZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MTc0O3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjE3NTtzOjYwOiJcJHRsZFxzKj1ccyphcnJheVxzKlwoXHMqWyciXWNvbVsnIl0sWyciXW9yZ1snIl0sWyciXW5ldFsnIl0iO2k6MTc2O3M6NDU6ImRlZmluZVxzKlwoKlxzKlsnIl1TQkNJRF9SRVFVRVNUX0ZJTEVbJyJdXHMqLCI7aToxNzc7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aToxNzg7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6MTc5O3M6MzM6ImRlZmluZVxzKlwoXHMqWyciXURFRkNBTExCQUNLTUFJTCI7aToxODA7czo0NzoiZGVmYXVsdF9hY3Rpb25ccyo9XHMqWyciXXswLDF9RmlsZXNNYW5bJyJdezAsMX0iO2k6MTgxO3M6Mzg6ImVjaG9ccytAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkZ2V0IjtpOjE4MjtzOjE1NjoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyosXHMqWyciXXswLDF9QW5kcm9pZFsnIl17MCwxfVwpXHMqIT09ZmFsc2VccyomJlxzKiFcJF9DT09LSUVcW1snIl17MCwxfWRsZV91c2VyX2lkIjtpOjE4MztzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6MTg0O3M6MTA6IkRjMFJIYVsnIl0iO2k6MTg1O3M6MzY6IiF0b3VjaFwoWyciXXswLDF9XC5cLi9cLlwuL2xhbmd1YWdlLyI7aToxODY7czozODoiZXZhbFwoXHMqc3RyaXBzbGFzaGVzXChccypcXFwkX1JFUVVFU1QiO2k6MTg3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aToxODg7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aToxODk7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aToxOTA7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6MTkxO3M6ODc6IiYmXHMqZnVuY3Rpb25fZXhpc3RzXHMqXCgqXHMqWyciXXswLDF9Z2V0bXhyclsnIl17MCwxfVwpXHMqXClccyp7XHMqQGdldG14cnJccypcKCpccypcJCI7aToxOTI7czo1NzoiaXNfX3dyaXRhYmxlXHMqXCgqXHMqXCRwYXRoXHMqXC5ccyp1bmlxaWRccypcKCpccyptdF9yYW5kIjtpOjE5MztzOjI4OiJmaWxlX3B1dF9jb250ZW50elxzKlwoKlxzKlwkIjtpOjE5NDtzOjU1OiJAKmd6aW5mbGF0ZVxzKlwoXHMqQCpiYXNlNjRfZGVjb2RlXHMqXChccypAKnN0cl9yZXBsYWNlIjtpOjE5NTtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjE5NjtzOjQzOiJAXCRfQ09PS0lFXFtbJyJdezAsMX1zdGF0Q291bnRlclsnIl17MCwxfVxdIjtpOjE5NztzOjM1OiJpZlxzKlwoKlxzKkAqcHJlZ19tYXRjaFxzKlwoKlxzKnN0ciI7aToxOTg7czo5NDoiYXJyYXlfcG9wXHMqXCgqXHMqXCR3b3JrUmVwbGFjZVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKixccypcJGNvdW50S2V5c05ldyI7aToxOTk7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjIwMDtzOjIzOiJcKFxzKlsnIl1JTlNIRUxMWyciXVxzKiI7aToyMDE7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6MjAyO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6MjAzO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aToyMDQ7czoxMjM6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cXlwod3d3XHxmdHBcKVxcXC4vaVsnIl1ccyosXHMqWyciXVsnIl0sXHMqQFwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XHMqXF1ccypcKSI7aToyMDU7czoyNjE6ImlmXHMqXCgqXHMqaXNzZXRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9W2EtekEtWl8wLTldK1snIl17MCwxfVxzKlxdXHMqXCkqXHMqXClccyp7XHMqXCRbYS16QS1aXzAtOV0rXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF07XHMqZXZhbFxzKlwoKlxzKlwkW2EtekEtWl8wLTldK1xzKlwpKiI7aToyMDY7czo4MToiZXZhbFxzKlwoKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFwoKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjIwNztzOjEzOToiaWZccytcKFxzKnN0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL21vb3Rvb2xzXC5qc1snIl1ccypcKVxzKj09PVxzKmZhbHNlXHMrJiZccytzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9jYXB0aW9uXC5qc1snIl17MCwxfSI7aToyMDg7czo2ODoiaWZccytcKCpccyptYWlsXHMqXChccypcJHJlY3BccyosXHMqXCRzdWJqXHMqLFxzKlwkc3R1bnRccyosXHMqXCRmcm0iO2k6MjA5O3M6NDM6IjxcP3BocFxzK1wkX0Zccyo9XHMqX19GSUxFX19ccyo7XHMqXCRfWFxzKj0iO2k6MjEwO3M6Nzk6IlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0iO2k6MjExO3M6MTE1OiJcJGJlZWNvZGVccyo9QCpmaWxlX2dldF9jb250ZW50c1xzKlwoKlsnIl17MCwxfVxzKlwkdXJscHVyc1xzKlsnIl17MCwxfVwpKlxzKjtccyplY2hvXHMrWyciXXswLDF9XCRiZWVjb2RlWyciXXswLDF9IjtpOjIxMjtzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6MjEzO3M6NzM6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqXFsuKz9cXVw/L2VbJyJdezAsMX1ccyosXHMqc3RyX3JlcGxhY2UiO2k6MjE0O3M6MTQ5OiJcJEdMT0JBTFNcW1snIl17MCwxfS4rP1snIl17MCwxfVxdPUFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKSI7aToyMTU7czoyMDA6IlVOSU9OXHMrU0VMRUNUXHMrWyciXXswLDF9MFsnIl17MCwxfVxzKixccypbJyJdezAsMX08XD8gc3lzdGVtXChcXFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtjcGNcXVwpO2V4aXQ7XHMqXD8+WyciXXswLDF9XHMqLFxzKjBccyosMFxzKixccyowXHMqLFxzKjBccytJTlRPXHMrT1VURklMRVxzK1snIl17MCwxfVwkWyciXXswLDF9IjtpOjIxNjtzOjY2OiJpc3NldFxzKlwoKlxzKlwkX1BPU1RccypcW1xzKlsnIl17MCwxfWV4ZWNnYXRlWyciXXswLDF9XHMqXF1ccypcKSoiO2k6MjE3O3M6NzE6ImZ3cml0ZVxzKlwoKlxzKlwkZnBzZXR2XHMqLFxzKmdldGVudlxzKlwoXHMqWyciXUhUVFBfQ09PS0lFWyciXVxzKlwpXHMqIjtpOjIxODtzOjI2OiJzeW1saW5rXHMqXCgqXHMqWyciXS9ob21lLyI7aToyMTk7czo3MDoiZnVuY3Rpb25ccyt1cmxHZXRDb250ZW50c1xzKlwoKlxzKlwkdXJsXHMqLFxzKlwkdGltZW91dFxzKj1ccypcZCtccypcKSI7aToyMjA7czo0OToic3RycmV2XCgqXHMqWyciXXswLDF9ZWRvY2VkXzQ2ZXNhYlsnIl17MCwxfVxzKlwpKiI7aToyMjE7czo0Mjoic3RycmV2XCgqXHMqWyciXXswLDF9dHJlc3NhWyciXXswLDF9XHMqXCkqIjtpOjIyMjtzOjIwOiJleGVjXHMqXChccypbJyJdaXBmdyI7aToyMjM7czoxMzY6IndwX3Bvc3RzXHMrV0hFUkVccytwb3N0X3R5cGVccyo9XHMqWyciXXswLDF9cG9zdFsnIl17MCwxfVxzK0FORFxzK3Bvc3Rfc3RhdHVzXHMqPVxzKlsnIl17MCwxfXB1Ymxpc2hbJyJdezAsMX1ccytPUkRFUlxzK0JZXHMrYElEYFxzK0RFU0MiO2k6MjI0O3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjIyNTtzOjIxMzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjIyNjtzOjI0OiJcJEdMT0JBTFNcW1snIl17MCwxfV9fX18iO2k6MjI3O3M6NDM6ImZvcGVuXHMqXCgqXHMqWyciXXswLDF9L2V0Yy9wYXNzd2RbJyJdezAsMX0iO2k6MjI4O3M6NTk6ImV2YWxccypcKCpAKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFxzKlwoKlxzKkAqXCRfIjtpOjIyOTtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aToyMzA7czo3NDoiQCpzZXRjb29raWVccypcKCpccypbJyJdezAsMX1oaXRbJyJdezAsMX0sXHMqMVxzKixccyp0aW1lXHMqXCgqXHMqXCkqXHMqXCsiO2k6MjMxO3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aToyMzI7czo0NjoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCovZVsnIl17MCwxfSI7aToyMzM7czo4MToiXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqXF1ccyp9IjtpOjIzNDtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjIzNTtzOjMzOiJwcm9jX29wZW5ccypcKFxzKlsnIl17MCwxfUlIU3RlYW0iO2k6MjM2O3M6ODg6IlwkaW5pXHMqXFtccypbJyJdezAsMX11c2Vyc1snIl17MCwxfVxzKlxdXHMqPVxzKmFycmF5XHMqXChccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqPT4iO2k6MjM3O3M6ODg6ImN1cmxfc2V0b3B0XHMqXChccypcJGNoXHMqLFxzKkNVUkxPUFRfVVJMXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly9cJGhvc3Q6XGQrWyciXXswLDF9XHMqXCkiO2k6MjM4O3M6NDU6InN5c3RlbVxzKlwoKlxzKlsnIl17MCwxfXdob2FtaVsnIl17MCwxfVxzKlwpKiI7aToyMzk7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyNDA7czo1MjoiYXNzZXJ0XHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNDE7czo1MDoiZXZhbFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjQyO3M6MjU6InBocFxzKyJccypcLlxzKlwkd3NvX3BhdGgiO2k6MjQzO3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjI0NDtzOjIxOiJldmExW2EtekEtWjAtOV9dKz9TaXIiO2k6MjQ1O3M6OTM6IlwkY21kXHMqPVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccypcKSI7aToyNDY7czo5NjoiXCRmdW5jdGlvblxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfWNtZFsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjI0NztzOjIzOiJcJGZlXCgiXCRjbWRccysyPiYxIlwpOyI7aToyNDg7czoxNDE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyNDk7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6MjUwO3M6ODY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXVuYW1lXHMrLWFbJyJdXHMqXCkqIjtpOjI1MTtzOjEyNDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkX1BPU1RccypcW1xzKlsnIl0uKz9bJyJdXHMqXF1ccypcLlxzKiJccyoyXHMqPlxzKiYxXHMqWyciXSI7aToyNTI7czo0OToiIUAqXCRfUkVRVUVTVFxzKlxbXHMqWyciXWM5OXNoX3N1cmxbJyJdXHMqXF1ccypcKSI7aToyNTM7czozNzoiXCRsb2dpblxzKj1ccypAKnBvc2l4X2dldHVpZFwoKlxzKlwpKiI7aToyNTQ7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyNTU7czo4MjoicnVuY29tbWFuZFxzKlwoXHMqWyciXXNoZWxsaGVscFsnIl1ccyosXHMqWyciXShHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXSI7aToyNTY7czo1NToie1xzKlwkXHMqe1xzKnBhc3N0aHJ1XHMqXCgqXHMqXCRjbWRccypcKVxzKn1ccyp9XHMqPGJyPiI7aToyNTc7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToyNTg7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MjU5O3M6ODc6IlNFTEVDVFxzKzFccytGUk9NXHMrbXlzcWxcLnVzZXJccytXSEVSRVxzK2NvbmNhdFwoXHMqYHVzZXJgXHMqLFxzKidAJ1xzKixccypgaG9zdGBccypcKSI7aToyNjA7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToyNjE7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MjYyO3M6NzQ6ImZpbGVwYXRoXHMqPVxzKkAqcmVhbHBhdGhccypcKFxzKlwkX1BPU1RccypcW1xzKlsnIl1maWxlcGF0aFsnIl1ccypcXVxzKlwpIjtpOjI2MztzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MjY0O3M6NDA6ImV2YWxccypcKCpccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8iO2k6MjY1O3M6MTA3OiJ3c29FeFxzKlwoXHMqXFxbJyJdXHMqdGFyXHMqY2Z6dlxzKlxcWyciXVxzKlwuXHMqZXNjYXBlc2hlbGxhcmdccypcKFxzKlwkX1BPU1RcW1xzKlxcWyciXXAyXFxbJyJdXHMqXF1ccypcKSI7aToyNjY7czo3NDoiV1NPc2V0Y29va2llXHMqXChccyptZDVccypcKFxzKkAqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9IT1NUWyciXVxzKlxdXHMqXCkiO2k6MjY3O3M6Nzg6IldTT3NldGNvb2tpZVxzKlwoXHMqbWQ1XHMqXChccypAKlwkX1NFUlZFUlxbXHMqXFxbJyJdSFRUUF9IT1NUXFxbJyJdXHMqXF1ccypcKSI7aToyNjg7czoxNzA6IlwkaW5mbyBcLj0gXChcKFwkcGVybXNccyomXHMqMHgwMDQwXClccypcP1woXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccypcXFsnIl1zXFxbJyJdXHMqOlxzKlxcWyciXXhcXFsnIl1ccypcKVxzKjpcKFwoXCRwZXJtc1xzKiZccyoweDA4MDBcKVxzKlw/XHMqJ1MnXHMqOlxzKictJ1xzKlwpIjtpOjI2OTtzOjM1OiJkZWZhdWx0X2FjdGlvblxzKj1ccypcXFsnIl1GaWxlc01hbiI7aToyNzA7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjI3MTtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjI3MjtzOjExOiJieVxzK0dyaW5heSI7aToyNzM7czoyMzoiQ2FwdGFpblxzK0NydW5jaFxzK1RlYW0iO2k6Mjc0O3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyNzU7czoxMDA6IklPOjpTb2NrZXQ6OklORVQtPm5ld1woUHJvdG9ccyo9PlxzKiJ0Y3AiXHMqLFxzKkxvY2FsUG9ydFxzKj0+XHMqMzYwMDBccyosXHMqTGlzdGVuXHMqPT5ccypTT01BWENPTk4iO30="));
$gX_FlexDBShe = unserialize(base64_decode("YToyOTE6e2k6MDtzOjQ4OiJpZlwoXHMqaXNJblN0cmluZzEqXChcJFthLXpBLVowLTlfXSs/LFsnIl1nb29nbGUiO2k6MTtzOjYyOiJjaHJcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKTtccyp9XHMqZXZhbFwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyO3M6NDE6IlwkW2EtekEtWjAtOV9dKz89c3RyX3JlcGxhY2VcKFsnIl1cKmFcJFwqIjtpOjM7czoyMjoiZXhwbG9pdFxzKjo6XC48L3RpdGxlPiI7aTo0O3M6MTA4OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkanFccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF0iO2k6NTtzOjY4OiJcJFthLXpBLVowLTlfXSs/PT1bJyJdZmVhdHVyZWRbJyJdXHMqXClccypcKXtccyplY2hvXHMrYmFzZTY0X2RlY29kZSI7aTo2O3M6OToiYXJ0aWNrbGVAIjtpOjc7czozOToiWyciXXdwLVsnIl1ccypcLlxzKmdlbmVyYXRlUmFuZG9tU3RyaW5nIjtpOjg7czo0MDoiaGVhZGVyXChbJyJdTG9jYXRpb246XHMqaHR0cDovL1wkcHBcLm9yZyI7aTo5O3M6ODoiRmlsZXNNYW4iO2k6MTA7czo5OToiQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXChccypAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF1ccypcKVxzKlwpIjtpOjExO3M6NDA6IlwkY3VyX2NhdF9pZFxzKj1ccypcKFxzKmlzc2V0XChccypcJF9HRVQiO2k6MTI7czozNDoiRWRpdEh0YWNjZXNzXChccypbJyJdUmV3cml0ZUVuZ2luZSI7aToxMztzOjExOiJcJHBhdGhUb0RvciI7aToxNDtzOjIyOiJmdW5jdGlvblxzK21haWxlcl9zcGFtIjtpOjE1O3M6Mzg6ImVjaG9ccytzaG93X3F1ZXJ5X2Zvcm1cKFxzKlwkc3Fsc3RyaW5nIjtpOjE2O3M6NDM6Ilwkc3RhdHVzX2NyZWF0ZV9nbG9iX2ZpbGVccyo9XHMqY3JlYXRlX2ZpbGUiO2k6MTc7czo0MzoiZnVuY3Rpb25ccytmaW5kSGVhZGVyTGluZVxzKlwoXHMqXCR0ZW1wbGF0ZSI7aToxODtzOjYwOiJhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdezAsMX1tZXNbJyJdXF0iO2k6MTk7czoyNjoiZmlsZXNpemVcKFxzKlwkcHV0X2tfZmFpbHUiO2k6MjA7czo1OToiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGlyXHMqXC5ccypcJGZpbGVccypcLlxzKlsnIl0vaW5kZXgiO2k6MjE7czo0MzoiaWZccypcKFxzKkBmaWxldHlwZVwoXCRsZWFkb25ccypcLlxzKlwkZmlsZSI7aToyMjtzOjM3OiJldmFsXChccypcJHtccypcJFthLXpBLVowLTlfXSs/XHMqfVxbIjtpOjIzO3M6Mjg6InRvdWNoXChccypcJHRoaXMtPmNvbmYtPnJvb3QiO2k6MjQ7czo1NjoicHJlZ19tYXRjaFwoXHMqWyciXXswLDF9fkxvY2F0aW9uOlwoXC5cKlw/XClcKFw/Olxcblx8XCQiO2k6MjU7czo0OToiZmx1c2hfZW5kX2ZpbGVcKFxzKlwkZmlsZW5hbWVccyosXHMqXCRmaWxlY29udGVudCI7aToyNjtzOjMzOiJpZlwoXHMqc3RyaXBvc1woXHMqWyciXVwqXCpcKlwkdWEiO2k6Mjc7czo2NjoiXCR0YWJsZVxbXCRzdHJpbmdcW1wkaVxdXF1ccypcKlxzKnBvd1woNjRccyosXHMqMlwpXHMqXCtccypcJHRhYmxlIjtpOjI4O3M6NDg6ImdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXW1lcyI7aToyOTtzOjQ4OiJcJFBPU1RfU1RSXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgicGhwOi8vaW5wdXQiO2k6MzA7czozMzoiXCRzdGF0dXNfbG9jX3NoXHMqPVxzKmZpbGVfZXhpc3RzIjtpOjMxO3M6OTk6IlwkaW5kZXhccyo9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl08XD9waHBccypvYl9lbmRfZmx1c2hcKFwpO1xzKlw/PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRpbmRleCI7aTozMjtzOjEwNzoiaXNzZXRcKFxzKlwkX1NFUlZFUlxbXHMqX1xkK1woXHMqXGQrXHMqXClccypcXVxzKlwpXHMqXD9ccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxkK1wpXHMqXF1ccyo6XHMqX1xkK1woXGQrXCkiO2k6MzM7czozODoiPT1ccyowXClccyp7XHMqZWNob1xzKlBIUF9PU1xzKlwuXHMqXCQiO2k6MzQ7czo0OToiaWZcKFxzKnRydWVccyomXHMqQHByZWdfbWF0Y2hcKFxzKnN0cnRyXChccypbJyJdLyI7aTozNTtzOjg0OiJpZlwoXHMqIWVtcHR5XChccypcJF9QT1NUXFtccypbJyJdezAsMX10cDJbJyJdezAsMX1ccypcXVwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MzY7czo0NzoiZ3p1bmNvbXByZXNzXChccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXWh0dHAiO2k6Mzc7czoxOTg6IlxiKHBlcmNvY2V0fGFkZGVyYWxsfHZpYWdyYXxjaWFsaXN8bGV2aXRyYXxrYXVmZW58YW1iaWVufGJsdWVccytwaWxsfGNvY2FpbmV8bWFyaWp1YW5hfGxpcGl0b3J8cGhlbnRlcm1pbnxwcm9bc3pdYWN8c2FuZHlhdWVyfHRyYW1hZG9sfHRyb3loYW1ieXVsdHJhbXx1bmljYXVjYXx2YWxpdW18dmljb2Rpbnx4YW5heHx5cHhhaWVvKVxzK29ubGluZSI7aTozODtzOjIyOiJkaXNhYmxlX2Z1bmN0aW9ucz1OT05FIjtpOjM5O3M6MjE6IiZfU0VTU0lPTlxbcGF5bG9hZFxdPSI7aTo0MDtzOjI2OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXSs/YCI7aTo0MTtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjQyO3M6Njk6InRvdWNoXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aTo0MztzOjgxOiJmaWxlX2dldF9jb250ZW50c1woXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6NDQ7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6NDU7czo3MToidHJpbVwoXHMqXCRoZWFkZXJzXHMqXClccypcKVxzKmFzXHMqXCRoZWFkZXJccypcKVxzKmhlYWRlclwoXHMqXCRoZWFkZXIiO2k6NDY7czoxNjoiQ29kZWRccytieVxzK0VYRSI7aTo0NztzOjEyOiJCeVxzK1dlYlJvb1QiO2k6NDg7czoyMDoiaGVhZGVyXHMqXChccypfXGQrXCgiO2k6NDk7czo0MToiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6NTA7czoyOToiZG9fd29ya1woXHMqXCRpbmRleF9maWxlXHMqXCkiO2k6NTE7czo4MzoiXCRpZFxzKlwuXHMqWyciXVw/ZD1bJyJdXHMqXC5ccypiYXNlNjRfZW5jb2RlXChccypcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6NTI7czoyNToibmV3XHMrY29uZWN0QmFzZVwoWyciXWFIUiI7aTo1MztzOjkwOiJmaWxlX2dldF9jb250ZW50c1woUk9PVF9ESVJcLlsnIl0vdGVtcGxhdGVzL1snIl1cLlwkY29uZmlnXFtbJyJdc2tpblsnIl1cXVwuWyciXS9tYWluXC50cGwiO2k6NTQ7czo1OToiJTwhLS1cXHNcKlwkbWFya2VyXFxzXCotLT5cLlwrXD88IS0tXFxzXCovXCRtYXJrZXJcXHNcKi0tPiUiO2k6NTU7czoyNDoiZnVuY3Rpb25ccytnZXRmaXJzdHNodGFnIjtpOjU2O3M6MTg6InJlc3VsdHNpZ25fd2FybmluZyI7aTo1NztzOjI5OiJmaWxlX2V4aXN0c1woXHMqXCRGaWxlQmF6YVRYVCI7aTo1ODtzOjE5OiI9PVxzKlsnIl1jc2hlbGxbJyJdIjtpOjU5O3M6NjE6IlwkX1NFUlZFUlxbWyciXXswLDF9UkVNT1RFX0FERFJbJyJdezAsMX1cXTtpZlwoXChwcmVnX21hdGNoXCgiO2k6NjA7czo2NzoiXCRmaWxlX2Zvcl90b3VjaFxzKj1ccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXSI7aTo2MTtzOjIzOiJcJGluZGV4X3BhdGhccyosXHMqMDQwNCI7aTo2MjtzOjMwOiJyZWFkX2ZpbGVfbmV3XzJcKFwkcmVzdWx0X3BhdGgiO2k6NjM7czozODoiY2hyXChccypoZXhkZWNcKFxzKnN1YnN0clwoXHMqXCRtYWtldXAiO2k6NjQ7czoyNzoiXGQrJkBwcmVnX21hdGNoXChccypzdHJ0clwoIjtpOjY1O3M6NzU6InZhbHVlPVsnIl08XD9ccysoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXSI7aTo2NjtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6Njc7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjY4O3M6NDE6ImdfZGVsZXRlX29uX2V4aXRccyo9XHMqbmV3XHMrRGVsZXRlT25FeGl0IjtpOjY5O3M6NTM6ImlmXChwcmVnX21hdGNoXChbJyJdXCN3b3JkcHJlc3NfbG9nZ2VkX2luXHxhZG1pblx8cHdkIjtpOjcwO3M6NTA6IlsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdIjtpOjcxO3M6Mjg6IlwpO2Z1bmN0aW9uXHMrc3RyaW5nX2NwdFwoXCQiO2k6NzI7czoyODoiXCRzZXRjb29rXCk7c2V0Y29va2llXChcJHNldCI7aTo3MztzOjM1OiI8bG9jPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsOyI7aTo3NDtzOjQwOiJcJGJhbm5lZElQXHMqPVxzKmFycmF5XChccypbJyJdXF42NlwuMTAyIjtpOjc1O3M6NjI6IlwkcmVzdWx0PXNtYXJ0Q29weVwoXHMqXCRzb3VyY2VccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRmaWxlIjtpOjc2O3M6Mzg6IlwkZmlsbCA9IFwkX0NPT0tJRVxbXFxbJyJdZmlsbFxcWyciXVxdIjtpOjc3O3M6ODM6ImlmXChbJyJdc3Vic3RyX2NvdW50XChbJyJdXCRfU0VSVkVSXFtbJyJdUkVRVUVTVF9VUklbJyJdXF1ccyosXHMqWyciXXF1ZXJ5XC5waHBbJyJdIjtpOjc4O3M6ODU6ImlmXChccypcJF9HRVRcW1xzKlsnIl1pZFsnIl1ccypcXSE9XHMqWyciXVsnIl1ccypcKVxzKlwkaWQ9XCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0iO2k6Nzk7czoyMjoiPGFccytocmVmPVsnIl1vc2hpYmthLSI7aTo4MDtzOjc2OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXWNkXHMrL3RtcDt3Z2V0IjtpOjgxO3M6NTU6ImdldHByb3RvYnluYW1lXChccypbJyJddGNwWyciXVxzKlwpXHMrXHxcfFxzK2RpZVxzK3NoaXQiO2k6ODI7czo0NzoiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkaW5kZXhfcGF0aFxzKixccypcJGNvZGUiO2k6ODM7czo2NjoiLFxzKlsnIl0vaW5kZXhcXFwuXChwaHBcfGh0bWxcKS9pWyciXVxzKixccypSZWN1cnNpdmVSZWdleEl0ZXJhdG9yIjtpOjg0O3M6MTM6IkFPTFxzK0RldGFpbHMiO2k6ODU7czoyMDoidEhBTktzXHMrdE9ccytTbm9wcHkiO2k6ODY7czoyMDoiTWFzcjFccytDeWIzclxzK1RlNG0iO2k6ODc7czoxODoiVXMzXHMrWTB1clxzK2JyNDFuIjtpOjg4O3M6MjA6Ik1hc3JpXHMrQ3liZXJccytUZWFtIjtpOjg5O3M6NDk6ImZ3cml0ZVwoXCRmcFxzKixccypzdHJyZXZcKFxzKlwkY29udGV4dFxzKlwpXHMqXCkiO2k6OTA7czo5OiIvcG10L3Jhdi8iO2k6OTE7czozNDoiZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0vdmFyL3RtcCI7aTo5MjtzOjIzOiJcJGluX1Blcm1zXHMrJlxzKzB4NDAwMCI7aTo5MztzOjQzOiJmb3BlblwoXHMqXCRyb290X2RpclxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjk0O3M6NjI6ImludDMyXChcKFwoXCR6XHMqPj5ccyo1XHMqJlxzKjB4MDdmZmZmZmZcKVxzKlxeXHMqXCR5XHMqPDxccyoyIjtpOjk1O3M6MzU6IjxndWlkPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsIjtpOjk2O3M6MTk6Ii1rbHljaC1rLWlncmVcLmh0bWwiO2k6OTc7czo2NjoiPGRpdlxzK2lkPVsnIl1saW5rMVsnIl0+PGJ1dHRvbiBvbmNsaWNrPVsnIl1wcm9jZXNzVGltZXJcKFwpO1snIl0+IjtpOjk4O3M6MTE6InNjb3BiaW5bJyJdIjtpOjk5O3M6MTQ6Ii1BcHBsZV9SZXN1bHQtIjtpOjEwMDtzOjQ3OiJ0YXJccystY3pmXHMrIlxzKlwuXHMqXCRGT1JNe3Rhcn1ccypcLlxzKiJcLnRhciI7aToxMDE7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6MTAyO3M6NjM6IlwkQ1ZWMkNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1DVlYyQyI7aToxMDM7czo3NToiZndyaXRlXChccypcJGZccyosXHMqZ2V0X2Rvd25sb2FkXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjEwNDtzOjMzOiJcW1xdXHMqPVxzKlsnIl1SZXdyaXRlRW5naW5lXHMrb24iO2k6MTA1O3M6OTg6InN1YnN0clwoXHMqXCRzdHJpbmcyXHMqLFxzKnN0cmxlblwoXHMqXCRzdHJpbmcyXHMqXClccyotXHMqOVxzKixccyo5XClccyo9PVxzKlsnIl17MCwxfVxbbCxyPTMwMlxdIjtpOjEwNjtzOjEzOiI9YnlccytEUkFHT049IjtpOjEwNztzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjEwODtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjEwOTtzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjExMDtzOjc4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXWFjdGlvblsnIl1ccypcLlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTExO3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjExMjtzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTEzO3M6NTI6InRvdWNoXChccypbJyJdezAsMX1cJGJhc2VwYXRoL2NvbXBvbmVudHMvY29tX2NvbnRlbnQiO2k6MTE0O3M6NDY6Ij1cJGZpbGVcKEAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTE1O3M6NzI6InNlbmRfc210cFwoXHMqXCRlbWFpbFxbWyciXXswLDF9YWRyWyciXXswLDF9XF1ccyosXHMqXCRzdWJqXHMqLFxzKlwkdGV4dCI7aToxMTY7czozNDoiX19MSU5LX188YVxzK2hyZWY9WyciXXswLDF9aHR0cDovLyI7aToxMTc7czo0NDoic2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTE4O3M6Nzg6IiFmaWxlX3B1dF9jb250ZW50c1woXHMqXCRkYm5hbWVccyosXHMqXCR0aGlzLT5nZXRJbWFnZUVuY29kZWRUZXh0XChccypcJGRibmFtZSI7aToxMTk7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxMjA7czo2MDoibWFpbFwoXHMqXCRNYWlsVG9ccyosXHMqXCRNZXNzYWdlU3ViamVjdFxzKixccypcJE1lc3NhZ2VCb2R5IjtpOjEyMTtzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTIyO3M6NzA6Im1haWxcKFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF0iO2k6MTIzO3M6MjM6ImlzX3dyaXRhYmxlPWlzX3dyaXRhYmxlIjtpOjEyNDtzOjIzOiJleHBsb2l0LWRiXC5jb20vc2VhcmNoLyI7aToxMjU7czoxNDoiRGF2aWRccypCbGFpbmUiO2k6MTI2O3M6MzM6ImNyb250YWJccystbFx8Z3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMjc7czo4MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl17MCwxfWF0XHMrbm93XHMrLWYiO2k6MTI4O3M6NjQ6IlwjIS9iaW4vc2huY2RccytbJyJdezAsMX1bJyJdezAsMX1cLlwkU0NQXC5bJyJdezAsMX1bJyJdezAsMX1uaWYiO2k6MTI5O3M6NDQ6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdezAsMX1cLi9saWJ3b3JrZXJcLnNvIjtpOjEzMDtzOjM2OiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XCgiO2k6MTMxO3M6MjA6ImZvcGVuXChccypbJyJdL2hvbWUvIjtpOjEzMjtzOjIwOiJta2RpclwoXHMqWyciXS9ob21lLyI7aToxMzM7czo0MDoiXCNVc2VbJyJdezAsMX1ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKCI7aToxMzQ7czoyOToiZXJlZ2lcKFxzKnNxbF9yZWdjYXNlXChccypcJF8iO2k6MTM1O3M6NzE6IlwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrXHMqXF1cKFwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrIjtpOjEzNjtzOjM2OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypcJDxhbWMiO2k6MTM3O3M6MzM6IkBcJGZ1bmNcKFwkY2ZpbGUsIFwkY2RpclwuXCRjbmFtZSI7aToxMzg7czo2MjoidW5hbWVcXVsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXChcKVxzKlwuXHMqWyciXXswLDF9XFsvdW5hbWUiO2k6MTM5O3M6NTQ6IlwkR0xPQkFMU1xbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwoXHMqTlVMTCI7aToxNDA7czoyMzoiX191cmxfZ2V0X2NvbnRlbnRzXChcJGwiO2k6MTQxO3M6MjY6IlwkZG9yX2NvbnRlbnQ9cHJlZ19yZXBsYWNlIjtpOjE0MjtzOjczOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWxzXHMrL3Zhci9tYWlsIjtpOjE0MztzOjMwOiJoZWFkZXJcKFsnIl17MCwxfXI6XHMqbm9ccytjb20iO2k6MTQ0O3M6NDg6InByZWdfbWF0Y2hfYWxsXChccypbJyJdXHxcKFwuXCpcKTxcXCEtLSBqcy10b29scyI7aToxNDU7czo0OToiQCpmaWxlX3B1dF9jb250ZW50c1woXHMqXCR0aGlzLT5maWxlXHMqLFxzKnN0cnJldiI7aToxNDY7czo0MToiL3BsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAiO2k6MTQ3O3M6OTE6Im1haWxcKFxzKnN0cmlwc2xhc2hlc1woXCR0b1wpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRzdWJqZWN0XClccyosXHMqc3RyaXBzbGFzaGVzXChcJG1lc3NhZ2UiO2k6MTQ4O3M6ODU6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX11clsnIl17MCwxfVxdXClcKVxzKlwkbW9kZVxzKlx8PVxzKjA0MDAiO2k6MTQ5O3M6ODI6ImVyZWdfcmVwbGFjZVwoWyciXXswLDF9JTVDJTIyWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfSUyMlsnIl17MCwxfVxzKixccypcJG1lc3NhZ2UiO2k6MTUwO3M6ODg6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJG5hbWVccyosXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTUxO3M6MTIyOiJ3aW5kb3dcLmxvY2F0aW9uPWJ9XHMqXClcKFxzKm5hdmlnYXRvclwudXNlckFnZW50XHMqXHxcfFxzKm5hdmlnYXRvclwudmVuZG9yXHMqXHxcfFxzKndpbmRvd1wub3BlcmFccyosXHMqWyciXXswLDF9aHR0cDovLyI7aToxNTI7czo4OToiXCRzYXBlX29wdGlvblxbXHMqWyciXXswLDF9ZmV0Y2hfcmVtb3RlX3R5cGVbJyJdezAsMX1ccypcXVxzKj1ccypbJyJdezAsMX1zb2NrZXRbJyJdezAsMX0iO2k6MTUzO3M6MTA1OiJcJHBhdGhccyo9XHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF1ccypcLlxzKlsnIl17MCwxfS9pbWFnZXMvc3Rvcmllcy9bJyJdezAsMX0iO2k6MTU0O3M6ODI6IkAqYXJyYXlfZGlmZl91a2V5XChccypAKmFycmF5XChccypcKHN0cmluZ1wpXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTU1O3M6MjA6ImV2YWxccypcKFxzKlRQTF9GSUxFIjtpOjE1NjtzOjM4OiJKUmVzcG9uc2U6OnNldEJvZHlccypcKFxzKnByZWdfcmVwbGFjZSI7aToxNTc7czo0ODoiXHMqWyciXXswLDF9c2x1cnBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9bXNuYm90IjtpOjE1ODtzOjU0OiJccypbJyJdezAsMX1yb29rZWVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9d2ViZWZmZWN0b3IiO2k6MTU5O3M6MTE6IkNvdXBkZWdyYWNlIjtpOjE2MDtzOjEyOiJTdWx0YW5IYWlrYWwiO2k6MTYxO3M6NjA6ImZpbGVfZ2V0X2NvbnRlbnRzXChiYXNlbmFtZVwoXCRfU0VSVkVSXFtbJyJdezAsMX1TQ1JJUFRfTkFNRSI7aToxNjI7czoyNzoiaHR0cHM6Ly9hcHBsZWlkXC5hcHBsZVwuY29tIjtpOjE2MztzOjE5OiJcJGJrZXl3b3JkX2Jlej1bJyJdIjtpOjE2NDtzOjM0OiJjcmMzMlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9Y21kIjtpOjE2NTtzOjE5OiJncmVwXHMrLXZccytjcm9udGFiIjtpOjE2NjtzOjI4OiJbJyJdWyciXVxzKlwuXHMqZ3pVbmNvTXByZVNzIjtpOjE2NztzOjI5OiJbJyJdWyciXVxzKlwuXHMqQkFzZTY0X2RlQ29EZSI7aToxNjg7czozMjoiZXZhbFwoWyciXVw/PlsnIl1cLmJhc2U2NF9kZWNvZGUiO2k6MTY5O3M6Mjc6ImN1cmxfaW5pdFwoXHMqYmFzZTY0X2RlY29kZSI7aToxNzA7czoxMjoibWlsdzBybVwuY29tIjtpOjE3MTtzOjQ1OiJcJGZpbGVcKEAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTcyO3M6MzY6InJldHVyblxzK2Jhc2U2NF9kZWNvZGVcKFwkYVxbXCRpXF1cKSI7aToxNzM7czo4OiJIYXJjaGFMaSI7aToxNzQ7czo2MDoicGx1Z2lucy9zZWFyY2gvcXVlcnlcLnBocFw/X19fX3BnZmE9aHR0cCUzQSUyRiUyRnd3d1wuZ29vZ2xlIjtpOjE3NTtzOjM2OiJjcmVhdGVfZnVuY3Rpb25cKHN1YnN0clwoMiwxXCksXCRzXCkiO2k6MTc2O3M6ODE6InR5cGVvZlxzKlwoZGxlX2FkbWluXClccyo9PVxzKlsnIl17MCwxfXVuZGVmaW5lZFsnIl17MCwxfVxzKlx8XHxccypkbGVfYWRtaW5ccyo9PSI7aToxNzc7czozMjoiXFtcJG9cXVwpO1wkb1wrXCtcKXtpZlwoXCRvPDE2XCkiO2k6MTc4O3M6MzI6IlwkU1xbXCRpXCtcK1xdXChcJFNcW1wkaVwrXCtcXVwoIjtpOjE3OTtzOjM3OiJzZXRjb29raWVcKFxzKlwkelxbMFxdXHMqLFxzKlwkelxbMVxdIjtpOjE4MDtzOjg2OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9qY2UmdGFzaz1wbHVnaW4mcGx1Z2luPWltZ21hbmFnZXImZmlsZT1pbWdtYW5hZ2VyJnZlcnNpb249MTU3NiI7aToxODE7czoxNToiY2F0YXRhblxzK3NpdHVzIjtpOjE4MjtzOjQxOiJpZlwoXHMqaXNzZXRcKFxzKlwkX1JFUVVFU1RcW1snIl17MCwxfWNpZCI7aToxODM7czo0MDoic3RyX3JlcGxhY2VccypcKFxzKlsnIl17MCwxfS9wdWJsaWNfaHRtbCI7aToxODQ7czo1MToiQGFycmF5XChccypcKHN0cmluZ1wpXHMqc3RyaXBzbGFzaGVzXChccypcJF9SRVFVRVNUIjtpOjE4NTtzOjYwOiJpZlxzKlwoXHMqZmlsZV9wdXRfY29udGVudHNccypcKFxzKlwkaW5kZXhfcGF0aFxzKixccypcJGNvZGUiO2k6MTg2O3M6OTQ6ImlmXChpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWNvbnRlbnRbJyJdezAsMX1cKVxzK0FORFxzK2lzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtYWRtaW4iO2k6MTg3O3M6Mjg6ImlmXChcJG88MTZcKXtcJGhcW1wkZVxbXCRvXF0iO2k6MTg4O3M6OToiYnlccytnMDBuIjtpOjE4OTtzOjE1OiJBdXRvXHMqWHBsb2l0ZXIiO2k6MTkwO3M6MTAyOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyIiO2k6MTkxO3M6NzI6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jbWRcLmV4ZSI7aToxOTI7czo5OiJCeVxzK0RaMjciO2k6MTkzO3M6Mjc6IkV0aG5pY1xzK0FsYmFuaWFuXHMrSGFja2VycyI7aToxOTQ7czoyMDoiVm9sZ29ncmFkaW5kZXhcLmh0bWwiO2k6MTk1O3M6MzI6IlwkX1Bvc3RcW1snIl17MCwxfVNTTlsnIl17MCwxfVxdIjtpOjE5NjtzOjE1OiJwYWNrXHMrIlNuQTR4OCIiO2k6MTk3O3M6MTQ6IlsnIl17MCwxfURaZTFyIjtpOjE5ODtzOjEyOiJUZWFNXHMrTW9zVGEiO2k6MTk5O3M6NjM6ImlmXChtYWlsXChcJGVtYWlsXFtcJGlcXSxccypcJHN1YmplY3QsXHMqXCRtZXNzYWdlLFxzKlwkaGVhZGVycyI7aToyMDA7czozNjoicHJpbnRccytbJyJdezAsMX1kbGVfbnVsbGVkWyciXXswLDF9IjtpOjIwMTtzOjM5OiJpZlxzKlwoY2hlY2tfYWNjXChcJGxvZ2luLFwkcGFzcyxcJHNlcnYiO2k6MjAyO3M6Mzg6InByZWdfcmVwbGFjZVwoXCl7cmV0dXJuXHMrX19GVU5DVElPTl9fIjtpOjIwMztzOjMzOiJcJG9wdFxzKj1ccypcJGZpbGVcKEAqXCRfQ09PS0lFXFsiO2k6MjA0O3M6MzY6ImlmXChAZnVuY3Rpb25fZXhpc3RzXChbJyJdezAsMX1mcmVhZCI7aToyMDU7czoxMDg6ImZvclwoXCRbYS16QS1aMC05X10rPz1cZCs7XCRbYS16QS1aMC05X10rPzxcZCs7XCRbYS16QS1aMC05X10rPy09XGQrXCl7aWZcKFwkW2EtekEtWjAtOV9dKz8hPVxkK1wpXHMqYnJlYWs7fSI7aToyMDY7czozNToiXCRjb3VudGVyVXJsXHMqPVxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6MjA3O3M6Njc6ImFycmF5XChccypbJyJdaFsnIl1ccyosXHMqWyciXXRbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJdcFsnIl0iO2k6MjA4O3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aToyMDk7czo2MjoiXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1wkbmFtZVxdXHMqPVxzKlwkdmFsdWUiO2k6MjEwO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjIxMTtzOjI2OiJpbmRleFwucGhwXD9pZD1cJDEmJXtRVUVSWSI7aToyMTI7czo4NjoiQGluaV9zZXRccypcKFsnIl17MCwxfWluY2x1ZGVfcGF0aFsnIl17MCwxfSxbJyJdezAsMX1pbmlfZ2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGgiO2k6MjEzO3M6Mjg6ImlmXHMqXChAaXNfd3JpdGFibGVcKFwkaW5kZXgiO2k6MjE0O3M6Mjg6IlwkX1BPU1RcW1snIl17MCwxfXNtdHBfbG9naW4iO2k6MjE1O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6MjE2O3M6MzQ6ImlmXChAcHJlZ19tYXRjaFwoc3RydHJcKFsnIl17MCwxfS8iO2k6MjE3O3M6MTU6IjwhLS1ccytqcy10b29scyI7aToyMTg7czo3OiJ1Z2djOi8vIjtpOjIxOTtzOjQ3OiJpZiBcKGRhdGVcKFsnIl17MCwxfWpbJyJdezAsMX1cKVxzKi1ccypcJG5ld3NpZCI7aToyMjA7czoxNDoiRGF2aWRccytCbGFpbmUiO2k6MjIxO3M6MjU6IlwkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6MjIyO3M6NDE6ImlmIFwoIXN0cnBvc1woXCRzdHJzXFswXF0sWyciXXswLDF9PFw/cGhwIjtpOjIyMztzOjg1OiJcJHN0cmluZ1xzKj1ccypcJF9TRVNTSU9OXFtbJyJdezAsMX1kYXRhX2FbJyJdezAsMX1cXVxbWyciXXswLDF9bnV0emVybmFtZVsnIl17MCwxfVxdIjtpOjIyNDtzOjU2OiJ3aGlsZVwoY291bnRcKFwkbGluZXNcKT5cJGNvbF96YXBcKSBhcnJheV9wb3BcKFwkbGluZXNcKSI7aToyMjU7czoxMDQ6InNpdGVfZnJvbT1bJyJdezAsMX1cLlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XF1cLlsnIl17MCwxfSZzaXRlX2ZvbGRlcj1bJyJdezAsMX1cLlwkZlxbMVxdIjtpOjIyNjtzOjMxOiJcJGZpbGViXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjIyNztzOjMzOiJwb3J0bGV0cy9mcmFtZXdvcmsvc2VjdXJpdHkvbG9naW4iO2k6MjI4O3M6Mjk6IlwkYlxzKj1ccyptZDVfZmlsZVwoXCRmaWxlYlwpIjtpOjIyOTtzOjUxOiJcJGRhdGFccyo9XHMqYXJyYXlcKFsnIl17MCwxfXRlcm1pbmFsWyciXXswLDF9XHMqPT4iO2k6MjMwO3M6NzA6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1cXSxccypbJyJdezAsMX1nb29nbGUiO2k6MjMxO3M6NzA6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1cXSxccypbJyJdezAsMX15YW5kZXgiO2k6MjMyO3M6Nzc6InN0cmlzdHJcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF0sXHMqWyciXXswLDF9WWFuZGV4Qm90IjtpOjIzMztzOjUzOiJmb3BlblwoWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vWyciXXswLDF9XC5cJGZpbGVwYXRocyI7aToyMzQ7czozNjoicHJlZ19yZXBsYWNlXChccypbJyJdZVsnIl0sWyciXXswLDF9IjtpOjIzNTtzOjQwOiIoW15cP1xzXSlcKHswLDF9XC5bXCtcKl1cKXswLDF9XDJbYS16XSplIjtpOjIzNjtzOjE3OiJteDJcLmhvdG1haWxcLmNvbSI7aToyMzc7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6MjM4O3M6MjA6Ii9lWyciXVxzKixccypbJyJdXFx4IjtpOjIzOTtzOjMyOiI8aDE+NDAzIEZvcmJpZGRlbjwvaDE+PCEtLSB0b2tlbiI7aToyNDA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO2k6MjQxO3M6NDQ6ImFycmF5XChccypbJyJdR29vZ2xlWyciXVxzKixccypbJyJdU2x1cnBbJyJdIjtpOjI0MjtzOjEyOiJhbmRleFx8b29nbGUiO2k6MjQzO3M6MjQ6InBhZ2VfZmlsZXMvc3R5bGUwMDBcLmNzcyI7aToyNDQ7czoyMToiPT1bJyJdXClcKTtyZXR1cm47XD8+IjtpOjI0NTtzOjE2OiJTcGFtXHMrY29tcGxldGVkIjtpOjI0NjtzOjM1OiJlY2hvXHMrWyciXXswLDF9aW5zdGFsbF9va1snIl17MCwxfSI7aToyNDc7czo2MDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWN2dlsnIl17MCwxfVxdIjtpOjI0ODtzOjExOiJDVlY6XHMqXCRjdiI7aToyNDk7czozMDoiY3VybFwuaGF4eFwuc2UvcmZjL2Nvb2tpZV9zcGVjIjtpOjI1MDtzOjEyOiJraWxsYWxsXHMrLTkiO2k6MjUxO3M6NTc6InByZWdfcmVwbGFjZVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNTI7czo1ODoiXCRtYWlsZXJccyo9XHMqXCRfUE9TVFxbXHMqWyciXXswLDF9eF9tYWlsZXJbJyJdezAsMX1ccypcXSI7aToyNTM7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjI1NDtzOjI5OiJFcnJvckRvY3VtZW50XHMrNDA0XHMraHR0cDovLyI7aToyNTU7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwMFxzK2h0dHA6Ly8iO2k6MjU2O3M6Mjk6IkVycm9yRG9jdW1lbnRccys1MDBccytodHRwOi8vIjtpOjI1NztzOjI4OiJnb29nbGVcfHlhbmRleFx8Ym90XHxyYW1ibGVyIjtpOjI1ODtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6MjU5O3M6Mzg6ImV2YWxccypcKFxzKmd6aW5mbGF0ZVxzKlwoXHMqc3RyX3JvdDEzIjtpOjI2MDtzOjQ4OiJmdW5jdGlvblxzKmNobW9kX1JccypcKFxzKlwkcGF0aFxzKixccypcJHBlcm1ccyoiO2k6MjYxO3M6MzM6InN5bWJpYW5cfG1pZHBcfHdhcFx8cGhvbmVcfHBvY2tldCI7aToyNjI7czoyODoiZWNob1xzK1snIl1vXC5rXC5bJyJdO1xzKlw/PiI7aToyNjM7czo3MjoiQHNldGNvb2tpZVwoWyciXW1bJyJdLFxzKlsnIl1bYS16QS1aMC05X10rP1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjI2NDtzOjcwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl13Z2V0IjtpOjI2NTtzOjMzOiJnenVuY29tcHJlc3NccypcKFxzKmJhc2U2NF9kZWNvZGUiO2k6MjY2O3M6MzA6Imd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToyNjc7czoyNToiZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZSI7aToyNjg7czozMjoic3RyX2lyZXBsYWNlXHMqXCgqXHMqWyciXTwvaGVhZD4iO2k6MjY5O3M6NDA6ImlmXHMqXChccypwcmVnX21hdGNoXHMqXChccypbJyJdXCN5YW5kZXgiO2k6MjcwO3M6MzE6Ij1ccyphcnJheV9tYXBccypcKCpccypzdHJyZXZccyoiO2k6MjcxO3M6OToiXCRfX19ccyo9IjtpOjI3MjtzOjQ5OiJnenVuY29tcHJlc3NccypcKCpccypzdWJzdHJccypcKCpccypiYXNlNjRfZGVjb2RlIjtpOjI3MztzOjIzOiJBZGRIYW5kbGVyXHMrY2dpLXNjcmlwdCI7aToyNzQ7czoyMzoiQWRkSGFuZGxlclxzK3BocC1zY3JpcHQiO2k6Mjc1O3M6MTQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpIjtpOjI3NjtzOjM4OiJzdHJlYW1fc29ja2V0X2NsaWVudFxzKlwoXHMqWyciXXRjcDovLyI7aToyNzc7czo5NToiaXNzZXRcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqb3JccypkaWVcKCouKj9cKSoiO2k6Mjc4O3M6NTc6Ik9wdGlvbnNccytGb2xsb3dTeW1MaW5rc1xzK011bHRpVmlld3NccytJbmRleGVzXHMrRXhlY0NHSSI7aToyNzk7czozMjoiaXNfd3JpdGFibGVccypcKCpccypbJyJdL3Zhci90bXAiO2k6MjgwO3M6OTU6ImFkZF9maWx0ZXJccypcKCpccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCkqIjtpOjI4MTtzOjI5OiJldmFsXHMqXCgqXHMqZ2V0X29wdGlvblxzKlwoKiI7aToyODI7czoxMDQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbIjtpOjI4MztzOjEwNzoiaWZccypcKFxzKmlzX2NhbGxhYmxlXHMqXCgqXHMqWyciXXswLDF9KGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKSoiO2k6Mjg0O3M6MTE0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKlwpXHMqXCkiO2k6Mjg1O3M6NzQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXJtXHMqLWZyIjtpOjI4NjtzOjc0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl1ybVxzKi1yZiI7aToyODc7czo3ODoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJdcm1ccyotclxzKi1mIjtpOjI4ODtzOjQwOiJldmFsXHMqXCgqXHMqZ3ppbmZsYXRlXHMqXCgqXHMqc3RyX3JvdDEzIjtpOjI4OTtzOjE5OiJyb3VuZFxzKlwoXHMqMFxzKlwrIjtpOjI5MDtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NTU6e2k6MDtzOjIwOiJzbHVycFx8bXNuYm90XHx0ZW9tYSI7aToxO3M6NTc6IkNvbnRlbnQtdHlwZTpccyphcHBsaWNhdGlvbi92bmRcLmFuZHJvaWRcLnBhY2thZ2UtYXJjaGl2ZSI7aToyO3M6NTQ6Ij1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHBzKjovL1xkK1wuXGQrXC5cZCtcLlxkKyI7aTozO3M6MTA3OiI9XHMqY3JlYXRlX2Z1bmN0aW9uXHMqXChccypudWxsXHMqLFxzKlthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKTtccypcJFthLXpBLVowLTlfXSs/XChcKSI7aTo0O3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aTo1O3M6Njc6IlwuXCRfUkVRVUVTVFxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXHMqLFxzKnRydWVccyosXHMqMzAyXCkiO2k6NjtzOjE2MzoiXCNbYS16QS1aMC05X10rP1wjXHMqaWZcKGVtcHR5XChcJFthLXpBLVowLTlfXSs/XClcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl08c2NyaXB0Lis/PC9zY3JpcHQ+WyciXTtccyplY2hvXHMrXCRbYS16QS1aMC05X10rPztccyp9XHMqXCMvW2EtekEtWjAtOV9dKz9cIyI7aTo3O3M6MTQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1wpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08L2h0bWw+WyciXSI7aTo4O3M6Mzc6IlwkdGV4dFxzKj1ccypodHRwX2dldFwoXHMqWyciXWh0dHA6Ly8iO2k6OTtzOjEwNzoiQGluaV9zZXRcKFsnIl1lcnJvcl9sb2dbJyJdLE5VTExcKTtccypAaW5pX3NldFwoWyciXWxvZ19lcnJvcnNbJyJdLDBcKTtccypmdW5jdGlvblxzK3JlYWRfZmlsZVwoXCRmaWxlX25hbWUiO2k6MTA7czo5NToiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKTtccypoZWFkZXIiO2k6MTE7czoyNjoiZXZhbFwoXHMqWyciXXJldHVyblxzK2V2YWwiO2k6MTI7czoxMDc6Ij1ccyptYWlsXChccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXSs/XFtcZCtcXVxzKlwpXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xkK1xdIjtpOjEzO3M6ODM6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZGVjcnlwdF9TT1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdIjtpOjE0O3M6NTY6IlwkW2EtekEtWjAtOV9dKz89dXJsZGVjb2RlXChbJyJdLis/WyciXVwpO2lmXChwcmVnX21hdGNoIjtpOjE1O3M6MTE6Ij09WyciXVwpXCk7IjtpOjE2O3M6MTEwOiJpZlxzKlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpXHMqe1xzKmNobW9kXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aToxNztzOjM3OiJldmFsXChccypbJyJde1xzKlwkW2EtekEtWjAtOV9dKz9ccyp9IjtpOjE4O3M6MTI2OiIoZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1KVwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCQiO2k6MTk7czozMDoicmVhZF9maWxlXChccypbJyJdZG9tYWluc1wudHh0IjtpOjIwO3M6Mzk6ImlmXHMqXChccyppc3NldFwoXHMqXCRfR0VUXFtccypbJyJdcGluZyI7aToyMTtzOjk5OiJcXVwoWyciXVwkX1snIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF0iO2k6MjI7czo1NjoiQCpjcmVhdGVfZnVuY3Rpb25cKFxzKlsnIl1bJyJdXHMqLFxzKkAqZmlsZV9nZXRfY29udGVudHMiO2k6MjM7czo0MToiZndyaXRlXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl08XD9waHAiO2k6MjQ7czoxNDU6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1ccypbYS16QS1aMC05X10rP1xzKlsnIl17MCwxfVxdXChccypbJyJdezAsMX1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqW2EtekEtWjAtOV9dKz8iO2k6MjU7czoxNzoiR2FudGVuZ2Vyc1xzK0NyZXciO2k6MjY7czo4NToicmVjdXJzZV9jb3B5XChccypcJHNyY1xzKixccypcJGRzdFxzKlwpO1xzKmhlYWRlclwoXHMqWyciXWxvY2F0aW9uOlxzKlwkZHN0WyciXVxzKlwpOyI7aToyNztzOjM1OiJcLlwuL1wuXC4vZW5naW5lL2RhdGEvZGJjb25maWdcLnBocCI7aToyODtzOjQyOiI9XHMqQCpmc29ja29wZW5cKFxzKlwkYXJndlxbXGQrXF1ccyosXHMqODAiO2k6Mjk7czoyNjoiKFwuY2hyXChccypcZCtccypcKVwuKXs0LH0iO2k6MzA7czo0MToiXC5ccypiYXNlNjRfZGVjb2RlXChccypcJGluamVjdFxzKlwpXHMqXC4iO2k6MzE7czozMTU6IkAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSlccypcKEAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSlccypcKEAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSlccypcKCI7aTozMjtzOjY3OiI8IS0tY2hlY2s6WyciXVxzKlwuXHMqbWQ1XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjMzO3M6Mjg6Ilwkc2V0Y29va1xzKlwpO3NldGNvb2tpZVwoXCQiO2k6MzQ7czo2ODoiY29weVwoXHMqWyciXWh0dHA6Ly8uKj9cLnR4dFsnIl1ccyosXHMqWyciXVthLXpBLVowLTlfXSs/XC5waHBbJyJdXCkiO2k6MzU7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjM2O3M6MTM6Indzb1NlY1BhcmFtXCgiO2k6Mzc7czo1NzoiXCRbYS16QS1aMC05X10rP1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1wpIjtpOjM4O3M6NjA6InN1YnN0clwoc3ByaW50ZlwoWyciXSVvWyciXSxccypmaWxlcGVybXNcKFwkZmlsZVwpXCksXHMqLTRcKSI7aTozOTtzOjI2OiJcJHtbYS16QS1aMC05X10rP31cKFxzKlwpOyI7aTo0MDtzOjQ5OiJAKmZpbGVfZ2V0X2NvbnRlbnRzXChAKmJhc2U2NF9kZWNvZGVcKEAqdXJsZGVjb2RlIjtpOjQxO3M6ODoiL2tyeWFraS8iO2k6NDI7czozMDoiZm9wZW5ccypcKFxzKlsnIl1iYWRfbGlzdFwudHh0IjtpOjQzO3M6MTU2OiJcJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rPywiO2k6NDQ7czoxMDU6ImlmXHMqXChccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RycnBvc1woXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdXD8+WyciXVxzKlwpXHMqXClccyo9PT1ccypmYWxzZSI7aTo0NTtzOjEzOiI9PVsnIl1cKVxzKlwuIjtpOjQ2O3M6MjM6InN1YnN0clwobWQ1XChzdHJyZXZcKFwkIjtpOjQ3O3M6MTA6ImRla2NhaFsnIl0iO2k6NDg7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjQ5O3M6NTE6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVwkXHMraHR0cDovL1xkK1wuXGQrXC5cZCtcLiI7aTo1MDtzOjMyOiJFcnJvckRvY3VtZW50XHMrNDA0XHMraHR0cDovL3RkcyI7aTo1MTtzOjUzOiJSZXdyaXRlRW5naW5lXHMrT25ccypSZXdyaXRlQmFzZVxzKy9cP1thLXpBLVowLTlfXSs/PSI7aTo1MjtzOjcwOiJcJGRvY1xzKj1ccypKRmFjdG9yeTo6Z2V0RG9jdW1lbnRcKFwpO1xzKlwkZG9jLT5hZGRTY3JpcHRcKFsnIl1odHRwOi8vIjtpOjUzO3M6MjE6ImluY2x1ZGVcKFxzKlsnIl16bGliOiI7aTo1NDtzOjgzOiJpbmNsdWRlXChccypbJyJdZGF0YTp0ZXh0L3BsYWluO2Jhc2U2NFxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbOyI7aTo1NTtzOjIyOiJydW5raXRfZnVuY3Rpb25fcmVuYW1lIjtpOjU2O3M6MTIyOiJpZlwoXHMqXCRmcFxzKj1ccypmc29ja29wZW5cKFwkdVxbWyciXWhvc3RbJyJdXF0sIWVtcHR5XChcJHVcW1snIl1wb3J0WyciXVxdXClccypcP1xzKlwkdVxbWyciXXBvcnRbJyJdXF1ccyo6XHMqODBccypcKVwpeyI7aTo1NztzOjExNjoiaWZcKGluaV9nZXRcKFsnIl1hbGxvd191cmxfZm9wZW5bJyJdXClccyo9PVxzKjFcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChcJFthLXpBLVowLTlfXSs/XCkiO2k6NTg7czo0NzoiZXhwbG9kZVwoWyciXVxcblsnIl0sXHMqXCRfUE9TVFxbWyciXXVybHNbJyJdXF0iO2k6NTk7czo1NToiaWZccypcKFxzKlwkdGhpcy0+aXRlbS0+aGl0c1xzKj49WyciXVxkK1snIl1cKVxzKntccypcJCI7aTo2MDtzOjE1OiJbJyJdY2hlY2tzdWV4ZWMiO2k6NjE7czoyODoic3RyX3JlcGxhY2VcKFsnIl0vXD9hbmRyWyciXSI7aTo2MjtzOjk3OiJhZG1pbi9bJyJdLFsnIl1hZG1pbmlzdHJhdG9yL1snIl0sWyciXWFkbWluMS9bJyJdLFsnIl1hZG1pbjIvWyciXSxbJyJdYWRtaW4zL1snIl0sWyciXWFkbWluNC9bJyJdIjtpOjYzO3M6NzQ6InN0cnBvc1woXCRsLFsnIl1Mb2NhdGlvblsnIl1cKSE9PWZhbHNlXHxcfHN0cnBvc1woXCRsLFsnIl1TZXQtQ29va2llWyciXVwpIjtpOjY0O3M6MTMzOiJcJFthLXpBLVowLTlfXSs/XHMqXC49XHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9IjtpOjY1O3M6MzM6IlwkW2EtekEtWjAtOV9dKz9cKFxzKkBcJF9DT09LSUVcWyI7aTo2NjtzOjExNzoiXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1cKFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwpIjtpOjY3O3M6MjI6ImdcKFxzKlsnIl1GaWxlc01hblsnIl0iO2k6Njg7czo1NDoiXCRbYS16QS1aMC05X10rPz0iL2hvbWUvW2EtekEtWjAtOV9dKz8vW2EtekEtWjAtOV9dKz8vIjtpOjY5O3M6MzM6Ij1ccypAKmd6aW5mbGF0ZVwoXHMqc3RycmV2XChccypcJCI7aTo3MDtzOjQwOiJzdHJfcmVwbGFjZVwoWyciXVwuaHRhY2Nlc3NbJyJdXHMqLFxzKlwkIjtpOjcxO3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6NzI7czo2NzoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rPyI7aTo3MztzOjE1OiJNdXN0QGZAXHMrU2hlbGwiO2k6NzQ7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6NzU7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aTo3NjtzOjM0OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypbJyJdIjtpOjc3O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTo3ODtzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6Nzk7czoyMjoiPlxzKjwvaWZyYW1lPlxzKjxcP3BocCI7aTo4MDtzOjEyNjoic3Vic3RyXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlxkK1xzKixccypcZCtccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKnByZWdfcmVwbGFjZVwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypzdHJ0clwoIjtpOjgxO3M6MjE6ImV4cGxvZGVcKFxcWyciXTt0ZXh0OyI7aTo4MjtzOjQ0OiJmdW5jdGlvblxzK19cZCtcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKXtcJCI7aTo4MztzOjMwOiJzdHJfcmVwbGFjZVwoXHMqWyciXVwuaHRhY2Nlc3MiO2k6ODQ7czoxNjoidGFncy9cJDYvXCQ0L1wkNyI7aTo4NTtzOjE5MjoiXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuIjtpOjg2O3M6MjA5OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF07XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccyphcnJheVwoXHMqXCRfUkVRVUVTVFxbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlfZmlsdGVyXChccypcJCI7aTo4NztzOjIyOiJyZXR1cm5ccypbJyJdL3Zhci93d3cvIjtpOjg4O3M6NDc6ImZvcGVuXChccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL3dwLWFkbWluIjtpOjg5O3M6MzU6ImlmXHMqXChccyppc193cml0YWJsZVwoXHMqXCR3d3dQYXRoIjtpOjkwO3M6Mzc6Ij1ccypbJyJdcGhwX3ZhbHVlXHMrYXV0b19wcmVwZW5kX2ZpbGUiO2k6OTE7czo0MjoiZXhwbG9kZVwoXHMqXFxbJyJdO3RleHQ7XFxbJyJdXHMqLFxzKlwkcm93IjtpOjkyO3M6NDU6InJtZGlyc1woXCRkaXJccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRjaGlsZCI7aTo5MztzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6OTQ7czoxMjoiYGNoZWNrc3VleGVjIjtpOjk1O3M6NDg6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdYXNzdW50byI7aTo5NjtzOjM1OiJlY2hvIFthLXpBLVowLTlfXSs/XHMqXChbJyJdaHR0cDovLyI7aTo5NztzOjk6Im1hYWZccyt5YSI7aTo5ODtzOjQ2OiJAZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqQHNldF90aW1lX2xpbWl0XCgwXCk7IjtpOjk5O3M6MTQ6IkxpYlhtbDJJc0J1Z2d5IjtpOjEwMDtzOjE1NjoiPVxzKm1haWxcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjEwMTtzOjIxMToiPVxzKm1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXSI7aToxMDI7czo5MjoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXCkiO2k6MTAzO3M6MzQ6ImV4cGxvZGVcKFsnIl07dGV4dDtbJyJdLFwkcm93XFswXF0iO2k6MTA0O3M6NjM6InN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl0sW2EtekEtWjAtOV9dKz9cLlsnIl08L2JvZHk+WyciXSxcJCI7aToxMDU7czoxNDoiIS91c3IvYmluL3BlcmwiO2k6MTA2O3M6MjE6Ilx8Ym90XHxzcGlkZXJcfHdnZXQvaSI7aToxMDc7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjEwODtzOjMwOiJ0b3VjaFwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MTA5O3M6Mzc6ImZpbGVfZ2V0X2NvbnRlbnRzXChfX0ZJTEVfX1wpLFwkbWF0Y2giO2k6MTEwO3M6ODk6InN0cl9yZXBsYWNlXChhcnJheVwoWyciXWZpbHRlclN0YXJ0WyciXSxbJyJdZmlsdGVyRW5kWyciXVwpLFxzKmFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqIjtpOjExMTtzOjI3OiJ3cC1vcHRpb25zXC5waHBccyo+XHMqRXJyb3IiO2k6MTEyO3M6NjM6IiU2MyU3MiU2OSU3MCU3NCUyRSU3MyU3MiU2MyUzRCUyNyU2OCU3NCU3NCU3MCUzQSUyRiUyRiU3MyU2RiU2MSI7aToxMTM7czoxMjoiXC53d3cvLzpwdHRoIjtpOjExNDtzOjEyMjoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyo9PVxzKlsnIl0iO2k6MTE1O3M6Njg6IlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcXlxzKlwkW2EtekEtWjAtOV9dKz9ccyo7IjtpOjExNjtzOjMyOiJbJyJdXHMqXF5ccypcJFthLXpBLVowLTlfXSs/XHMqOyI7aToxMTc7czo2MzoiXCRbYS16QS1aMC05X10rPy0+X3NjcmlwdHNcW1xzKmd6dW5jb21wcmVzc1woXHMqYmFzZTY0X2RlY29kZVwoIjtpOjExODtzOjkzOiJcJFthLXpBLVowLTlfXSs/PVsnIl1bYS16QS1aMC05XCtcPV9dK1snIl07XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkW2EtekEtWjAtOV9dKz9cKTtccypcPz4iO2k6MTE5O3M6MzU6ImJlZ2luXHMrbW9kOlxzK1RoYW5rc1xzK2ZvclxzK3Bvc3RzIjtpOjEyMDtzOjM0OiJldmFsXChccypbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoIjtpOjEyMTtzOjU4OiJcJFthLXpBLVowLTlfXSs/XFtccypfW2EtekEtWjAtOV9dKz9cKFxzKlxkK1xzKlwpXHMqXF1ccyo9IjtpOjEyMjtzOjE5OiJpbWFwX2hlYWRlcmluZm9cKFwkIjtpOjEyMztzOjY1OiJcJHRvXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJddG9fYWRkcmVzcyI7aToxMjQ7czo2MToiZ2V0X3VzZXJzXChccyphcnJheVwoXHMqWyciXXJvbGVbJyJdXHMqPT5ccypbJyJdYWRtaW5pc3RyYXRvciI7aToxMjU7czo2MzoiXlxzKjxcP3BocFxzKmhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjEyNjtzOjE0OiI8dGl0bGU+XHMqaXZueiI7aToxMjc7czo4NToiXlxzKjxcP3BocFxzKmhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlsnIl1ccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToxMjg7czozMzoiPVxzKmVzY191cmxcKFxzKnNpdGVfdXJsXChccypbJyJdIjtpOjEyOTtzOjM1OiJocmVmPVsnIl08XD9waHBccytlY2hvXHMrXCRjdXJfcGF0aCI7aToxMzA7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aToxMzE7czo0MToiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkW2EtekEtWjAtOV9dKz8iO2k6MTMyO3M6ODM6ImVjaG9ccytzdHJfcmVwbGFjZVwoXHMqWyciXVxbUEhQX1NFTEZcXVsnIl1ccyosXHMqYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXVBIUF9TRUxGIjtpOjEzMztzOjI5OiJnbWFpbC1zbXRwLWluXC5sXC5nb29nbGVcLmNvbSI7aToxMzQ7czoxMDoidGFyXHMrLXpjQyI7aToxMzU7czozMToiXCRfW2EtekEtWjAtOV9dKz9cKFxzKlwpO1xzKlw/PiI7aToxMzY7czoxOToiPVxzKnhkaXJcKFxzKlwkcGF0aCI7aToxMzc7czo2MToiXCRmcm9tXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZnJvbSI7aToxMzg7czo3OToiZWNob1xzK1wkW2EtekEtWjAtOV9dKz87bWtkaXJcKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcKTtmaWxlX3B1dF9jb250ZW50cyI7aToxMzk7czo4MzoiXCRbYS16QS1aMC05X10rPz1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWRvWyciXVxzKlxdO1xzKmluY2x1ZGUiO2k6MTQwO3M6MTY6IkBhc3NlcnRcKFxzKlsnIl0iO2k6MTQxO3M6NzI6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZm9wZW5cKFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVxzKixccypbJyJddyI7aToxNDI7czo3NzoiPGhlYWQ+XHMqPHNjcmlwdD5ccyp3aW5kb3dcLnRvcFwubG9jYXRpb25cLmhyZWY9WyciXS4rP1xzKjwvc2NyaXB0PlxzKjwvaGVhZD4iO2k6MTQzO3M6Mjk6IkNVUkxPUFRfVVJMXHMqLFxzKlsnIl1zbXRwOi8vIjtpOjE0NDtzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToxNDU7czo1NToiXCRmXHMqPVxzKlwkZlxkK1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rPyI7aToxNDY7czoyNzoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woIjtpOjE0NztzOjM0OiJmdW5jdGlvblxzK19fZmlsZV9nZXRfdXJsX2NvbnRlbnRzIjtpOjE0ODtzOjQwOiJcI1thLXpBLVowLTlfXSs/XCMuKz9cIy9bYS16QS1aMC05X10rP1wjIjtpOjE0OTtzOjI0OiJlY2hvXHMrYmFzZTY0X2RlY29kZVwoXCQiO2k6MTUwO3M6MTk6Ij1bJyJdXClccypcKTtccypcPz4iO2k6MTUxO3M6MzU6Ij09XHMqRkFMU0VccypcP1xzKlxkK1xzKjpccyppcDJsb25nIjtpOjE1MjtzOjM4OiJlbHNlaWZcKFxzKlwkc3FsdHlwZVxzKj09XHMqWyciXXNxbGl0ZSI7aToxNTM7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6MTU0O3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToxNTU7czo0MDoibWFpbFwoXCR0b1xzKixccypbJyJdLis/WyciXVxzKixccypcJHVybCI7aToxNTY7czo1ODoicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNTc7czo0MzoiZmlsZV9nZXRfY29udGVudHNcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyI7aToxNTg7czo2OToiZWNob1woWyciXTxmb3JtIG1ldGhvZD1bJyJdcG9zdFsnIl1ccyplbmN0eXBlPVsnIl1tdWx0aXBhcnQvZm9ybS1kYXRhIjtpOjE1OTtzOjE0OiJ3c29IZWFkZXJccypcKCI7aToxNjA7czo3NToiYXJyYXlcKFxzKlsnIl08IS0tWyciXVxzKlwuXHMqbWQ1XChccypcJHJlcXVlc3RfdXJsXHMqXC5ccypyYW5kXChcZCssXHMqXGQrIjtpOjE2MTtzOjEyNDoiXCRbYS16QS1aMC05X10rPz1bJyJdaHR0cDovLy4rP1snIl07XHMqXCRbYS16QS1aMC05X10rPz1mb3BlblwoXCRbYS16QS1aMC05X10rPyxbJyJdclsnIl1cKTtccypyZWFkZmlsZVwoXCRbYS16QS1aMC05X10rP1wpOyI7aToxNjI7czo2MDoiXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqLlxzKlxkK1xzKlxdXChccypbYS16QS1aMC05X10rP1woIjtpOjE2MztzOjUzOiJlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccypcJHVybFxzKj1ccypbJyJdaHR0cDovLyI7aToxNjQ7czo5NToiXCRHTE9CQUxTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcJFthLXpBLVowLTlfXSs/XF0iO2k6MTY1O3M6OTA6IkBcJHtccypbYS16QS1aMC05X10rP1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXSs/XHMqfVwoXHMqXCRbYS16QS1aMC05X10rPyI7aToxNjY7czoxMzoiRGV2YXJ0XHMrSFRUUCI7aToxNjc7czoxMDoiXC5waHBcP1wkMCI7aToxNjg7czo1NToiPGlucHV0XHMqdHlwZT1bJyJdZmlsZVsnIl1ccypuYW1lPVsnIl11c2VyZmlsZVsnIl1ccyovPiI7aToxNjk7czoxMTA6IlwkbWVzc2FnZXNcW1xdXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX11c2VyZmlsZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF1cW1xzKlwkaVxzKlxdIjtpOjE3MDtzOjUwOiI8aW5wdXRccyp0eXBlPSJmaWxlIlxzKnNpemU9IlxkKyJccypuYW1lPSJ1cGxvYWQiPiI7aToxNzE7czoxMjoiPFw/PVwkY2xhc3M7IjtpOjE3MjtzOjQxOiJSZXdyaXRlQ29uZFxzKyV7UkVNT1RFX0FERFJ9XHMrXF4yMTdcLjExOCI7aToxNzM7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjE3NDtzOjEwMjoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFsnIl1odHRwOi8vLis/XC5qcGdbJyJdXCk7XHMqZXhpdFwoXCk7IjtpOjE3NTtzOjUxOiJmb3JlYWNoXChccypcJHRvc1xzKmFzXHMqXCR0b1wpXHMqe1xzKm1haWxcKFxzKlwkdG8iO2k6MTc2O3M6MTY6ImZ1bmN0aW9uXHMrd3NvRXgiO2k6MTc3O3M6MTUwOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1cJFthLXpBLVowLTlfXSs/PUBbYS16QS1aMC05X10rP1woWyciXS4rP1snIl1cKTtbYS16QS1aMC05X10rP1woIVwkW2EtekEtWjAtOV9dKz9cKXtcJFthLXpBLVowLTlfXSs/PUBbYS16QS1aMC05X10rP1woXHMqXCkiO2k6MTc4O3M6NTA6IlJld3JpdGVSdWxlXHMqXC5cKi9cLlwqXHMqW2EtekEtWjAtOV9dKz9cLnBocFw/XCQwIjtpOjE3OTtzOjQ2OiJodHRwOi8vLis/Ly4rP1wucGhwXD9hPVxkKyZjPVthLXpBLVowLTlfXSs/JnM9IjtpOjE4MDtzOjE4OiJ0Y3A6Ly8xMjdcLjBcLjBcLjEiO2k6MTgxO3M6Mjc6IiE9XHMqWyciXWluZm9ybWF0aW9uX3NjaGVtYSI7aToxODI7czozOToicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfR0VUXFtccypbJyJdY3B5IjtpOjE4MztzOjc0OiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClcKVxzKntccyplY2hvXHMqWyciXW9rWyciXSI7aToxODQ7czo2ODoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1weXRob24iO2k6MTg1O3M6NjY6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcGVybCI7aToxODY7czoyNToiZnVuY3Rpb25ccytlcnJvcl80MDRcKFwpeyI7aToxODc7czo5NzoiXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwocm91bmRcKFxkK1wpXClcXSI7aToxODg7czo4MToiQChmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypAdXJsZW5jb2RlXChccypcJF9QT1NUIjtpOjE4OTtzOjM1OiJmaWxlX2dldF9jb250ZW50c1woXHMqX19GSUxFX19ccypcKSI7aToxOTA7czo0ODoiXCRlY2hvXzFcLlwkZWNob18yXC5cJGVjaG9fM1wuXCRlY2hvXzRcLlwkZWNob181IjtpOjE5MTtzOjM3OiJpZlxzKlwoXHMqaXNfY3Jhd2xlcjFcKFxzKlwpXHMqXClccyp7IjtpOjE5MjtzOjg0OiJldmFsXChccypbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKTtccypcPz4iO2k6MTkzO3M6MzE6Ij0+XHMqQFwkZjJcKF9fRklMRV9fXHMqLFxzKlwkZjEiO2k6MTk0O3M6MTEwOiJoZWFkZXJcKFxzKlsnIl1Db250ZW50LVR5cGU6XHMqaW1hZ2UvanBlZ1snIl1ccypcKTtccypyZWFkZmlsZVwoXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlwpO1xzKmV4aXRcKFxzKlwpOyI7aToxOTU7czoyNDU6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRbYS16QS1aMC05X10rP1woWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKVxzKlwpIjtpOjE5NjtzOjYzOiJcJF9QT1NUXFtbJyJdezAsMX10cDJbJyJdezAsMX1cXVxzKlwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MTk3O3M6NDE6ImNobW9kXChcJGZpbGUtPmdldFBhdGhuYW1lXChcKVxzKixccyowNzc3IjtpOjE5ODtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToxOTk7czo2NDoiXCRfUE9TVFxbWyciXXswLDF9YWN0aW9uWyciXXswLDF9XF1ccyo9PVxzKlsnIl1nZXRfYWxsX2xpbmtzWyciXSI7aToyMDA7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjIwMTtzOjY3OiJcJGd6cFxzKj1ccypcJGJnekV4aXN0XHMqXD9ccypAZ3pvcGVuXChcJHRtcGZpbGUsXHMqWyciXXJiWyciXVxzKlwpIjtpOjIwMjtzOjQzOiJcXVxzKlwpXHMqXC5ccypbJyJdXFxuXD8+WyciXVxzKlwpXHMqXClccyp7IjtpOjIwMztzOjQwOiJDb2RlTWlycm9yXC5kZWZpbmVNSU1FXChccypbJyJddGV4dC9taXJjIjtpOjIwNDtzOjI4OiJjaG1vZFwoXHMqX19ESVJfX1xzKixccyowNDAwIjtpOjIwNTtzOjQwOiJmcHV0c1woXCRmcCxccypbJyJdSVA6XHMqXCRpcFxzKi1ccypEQVRFIjtpOjIwNjtzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToyMDc7czoxMjoibmV3XHMqTUN1cmw7IjtpOjIwODtzOjI0OiJuc2xvb2t1cFwuZXhlXHMqLXR5cGU9TVgiO2k6MjA5O3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MjEwO3M6MzI6ImRuc19nZXRfcmVjb3JkXChccypcJGRvbWFpblxzKlwuIjtpOjIxMTtzOjExNjoibW92ZV91cGxvYWRlZF9maWxlXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1cXVxbXHMqXCRpXHMqXF0iO2k6MjEyO3M6MTA5OiJjb3B5XChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9QT1NUIjtpOjIxMztzOjg2OiJcJHVybFxzKlwuPVxzKlsnIl1cP1thLXpBLVowLTlfXSs/PVsnIl1ccypcLlxzKlwkX0dFVFxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdOyI7aToyMTQ7czoyNjoiPFw/XHMqZWNob1xzKlwkY29udGVudDtcPz4iO2k6MjE1O3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqZ29vZ2xlIjtpOjIxNjtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKnlhbmRleCI7aToyMTc7czozNjoiaWZccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfWNobW9kNzc3IjtpOjIxODtzOjQyOiJjb25uXHMqPVxzKmh0dHBsaWJcLkhUVFBDb25uZWN0aW9uXChccyp1cmkiO2k6MjE5O3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToyMjA7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MjIxO3M6MzY6InNldF90aW1lX2xpbWl0XChccyppbnR2YWxcKFxzKlwkYXJndiI7aToyMjI7czozNzoiZGllXChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToyMjM7czozODoiZXhpdFwoWyciXTxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC4iO2k6MjI0O3M6OToiR0FHQUw8L2I+IjtpOjIyNTtzOjkwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoXHMqWyciXVwkW2EtekEtWjAtOV9dKz9bJyJdXHMqXCkiO2k6MjI2O3M6MTk6ImJ1ZGFrXHMqLVxzKmV4cGxvaXQiO2k6MjI3O3M6MjI6ImFycmF5XChccypbJyJdJTFodG1sJTMiO2k6MjI4O3M6NTY6IlwkY29kZT1bJyJdJTFzY3JpcHRccyp0eXBlPVxcWyciXXRleHQvamF2YXNjcmlwdFxcWyciXSUzIjtpOjIyOTtzOjIzOiJlY2hvXChccypodG1sXChccyphcnJheSI7aToyMzA7czoxNToiQHN5c3RlbVwoXHMqIlwkIjtpOjIzMTtzOjIxOiJmdW5jdGlvblxzKkN1cmxBdHRhY2siO2k6MjMyO3M6NDQ6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP209XCQxIjtpOjIzMztzOjQ1OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9pZD1cJDEiO2k6MjM0O3M6MTU6IkhUVFBfQUNDRVBUX0FTRSI7aToyMzU7czoyNDoiXClccyp7XHMqcGFzc3RocnVcKFxzKlwkIjtpOjIzNjtzOjE4OiJSZWRpcmVjdFxzKmh0dHA6Ly8iO2k6MjM3O3M6NDI6IlJld3JpdGVSdWxlXHMqXChcLlwrXClccyppbmRleFwucGhwXD9zPVwkMCI7aToyMzg7czozMToiZXZhbFxzKlwoXHMqbWJfY29udmVydF9lbmNvZGluZyI7aToyMzk7czo0ODoicGFyc2VfcXVlcnlfc3RyaW5nXChccypcJEVOVntccypbJyJdUVVFUllfU1RSSU5HIjtpOjI0MDtzOjQ0OiJAXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpOyI7aToyNDE7czozOToiW2EtekEtWjAtOV9dKz9cKFxzKlthLXpBLVowLTlfXSs/PVxzKlwpIjtpOjI0MjtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MjQzO3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjI0NDtzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MjQ1O3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjI0NjtzOjE0OiJbJyJddHJlc3NhWyciXSI7aToyNDc7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToyNDg7czoxMjoic3NlcnBtb2NudXpnIjtpOjI0OTtzOjk6ImV0YWxmbml6ZyI7aToyNTA7czoxMjoiWyciXXJpbnlbJyJdIjtpOjI1MTtzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToyNTI7czo3OiJjdWN2YXNiIjtpOjI1MztzOjk6ImZnZV9lYmcxMyI7aToyNTQ7czoxNDoiWyciXW5mZnJlZ1snIl0iO2k6MjU1O3M6MTM6Im9uZnI2NF9xcnBicXIiO2k6MjU2O3M6MTI6InRtaGFwYnpjZXJmZiI7aToyNTc7czo5OiJ0bXZhc3luZ3IiO2k6MjU4O3M6NDg6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKSI7aToyNTk7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjI2MDtzOjEzOiJudWxsX2V4cGxvaXRzIjtpOjI2MTtzOjEzMDoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKmV4aXRcKFwpOyI7aToyNjI7czo1NjoibWFpbFwoXHMqXCRhcnJcW1snIl10b1snIl1cXVxzKixccypcJGFyclxbWyciXXN1YmpbJyJdXF0iO2k6MjYzO3M6MjQ6InVubGlua1woXHMqX19GSUxFX19ccypcKSI7aToyNjQ7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjI2NTtzOjQzOiJuYW1lPVsnIl11cGxvYWRlclsnIl1ccytpZD1bJyJddXBsb2FkZXJbJyJdIjtpOjI2NjtzOjMxOiJlY2hvXHMqWyciXTxiPlVwbG9hZDxzcz5TdWNjZXNzIjtpOjI2NztzOjM3OiJoZWFkZXJcKFxzKlsnIl1Mb2NhdGlvbjpccypcJGxpbmtbJyJdIjtpOjI2ODtzOjUxOiJ0eXBlPVsnIl1zdWJtaXRbJyJdXHMqdmFsdWU9WyciXVVwbG9hZCBmaWxlWyciXVxzKj4iO2k6MjY5O3M6MzA6ImVsc2Vccyp7XHMqZWNob1xzKlsnIl1mYWlsWyciXSI7aToyNzA7czo0NDoiXHMqPVxzKmluaV9nZXRcKFxzKlsnIl1kaXNhYmxlX2Z1bmN0aW9uc1snIl0iO2k6MjcxO3M6NTc6IkBlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccyppZlxzKlwoXHMqIWlzc2V0XHMqXChccypcJCI7aToyNzI7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToyNzM7czoxMjoiWmVyb0RheUV4aWxlIjtpOjI3NDtzOjExOiJTX1xdQF9cXlVcXiI7aToyNzU7czo1MDoiPGlucHV0XHMrdHlwZT1zdWJtaXRccyt2YWx1ZT1VcGxvYWRccyovPlxzKjwvZm9ybT4iO2k6Mjc2O3M6MTA4OiJpZlwoXHMqIXNvY2tldF9zZW5kdG9cKFxzKlwkc29ja2V0XHMqLFxzKlwkZGF0YVxzKixccypzdHJsZW5cKFxzKlwkZGF0YVxzKlwpXHMqLFxzKjBccyosXHMqXCRpcFxzKixccypcJHBvcnQiO2k6Mjc3O3M6NTQ6InN1YnN0clwoXHMqXCRyZXNwb25zZVxzKixccypcJGluZm9cW1xzKlsnIl1oZWFkZXJfc2l6ZSI7aToyNzg7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToyNzk7czo3NDoiXCRyZXQgPSBcJHRoaXMtPl9kYi0+dXBkYXRlT2JqZWN0XCggXCR0aGlzLT5fdGJsLCBcJHRoaXMsIFwkdGhpcy0+X3RibF9rZXkiO2k6MjgwO3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjI4MTtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MjgyO3M6NDk6IkB0b3VjaFxzKlwoXHMqXCRjdXJmaWxlXHMqLFxzKlwkdGltZVxzKixccypcJHRpbWUiO2k6MjgzO3M6MzM6InRvdWNoXHMqXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aToyODQ7czoyNzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzIjtpOjI4NTtzOjI5OiJleGVjXChccypbJyJdL2Jpbi9zaFsnIl1ccypcKSI7aToyODY7czoxNToiL3RtcC9cLklDRS11bml4IjtpOjI4NztzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6Mjg4O3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjI4OTtzOjI0OiJwcm9jX2Nsb3NlXChccypcJHByb2Nlc3MiO2k6MjkwO3M6MTY6IjtccyovYmluL3NoXHMqLWkiO2k6MjkxO3M6MjM6IlsnIl1ccypcfFxzKi9iaW4vc2hbJyJdIjtpOjI5MjtzOjQyOiJAdW1hc2tcKFxzKjA3NzdccyomXHMqflxzKlwkZmlsZXBlcm1pc3Npb24iO2k6MjkzO3M6NTI6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XHMqLFxzKjA3NTUiO2k6Mjk0O3M6NTI6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XHMqLFxzKjA0MDQiO2k6Mjk1O3M6NDc6InN0cnRvbG93ZXJcKFxzKnN1YnN0clwoXHMqXCR1c2VyX2FnZW50XHMqLFxzKjAsIjtpOjI5NjtzOjk6IkwzWmhjaTkzZCI7aToyOTc7czo1NToiXCRvdXRccypcLj1ccypcJHRleHR7XHMqXCRpXHMqfVxzKlxeXHMqXCRrZXl7XHMqXCRqXHMqfSI7aToyOTg7czo4NDoiL2luZGV4XC5waHBcP29wdGlvbj1jb21fY29udGVudCZ2aWV3PWFydGljbGUmaWQ9WyciXVwuXCRwb3N0XFtbJyJdezAsMX1pZFsnIl17MCwxfVxdIjtpOjI5OTtzOjI3OiJAY2hkaXJcKFxzKlwkX1BPU1RcW1xzKlsnIl0iO2k6MzAwO3M6NjQ6Imlzc2V0XChccypcJF9DT09LSUVcW1xzKm1kNVwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX0hPU1QiO2k6MzAxO3M6Mjc6InN0cmxlblwoXHMqXCRwYXRoVG9Eb3JccypcKSI7aTozMDI7czoyOToiZm9wZW5cKFxzKlsnIl1cLlwuL1wuaHRhY2Nlc3MiO2k6MzAzO3M6NDM6IlwkX1BPU1RcW1xzKlsnIl17MCwxfWVNYWlsQWRkWyciXXswLDF9XHMqXF0iO2k6MzA0O3M6NzY6IlxibWFpbFwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccyoiO2k6MzA1O3M6NDM6ImNvbnRlbnQ9IlxkKztVUkw9aHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS8iO2k6MzA2O3M6NDI6Ilwka2V5XHMqPVxzKlwkX0dFVFxbWyciXXswLDF9cVsnIl17MCwxfVxdOyI7aTozMDc7czoxOToiL2luc3RydWt0c2l5YS1kbHlhLSI7aTozMDg7czoxNDoiL1w/ZG89b3NoaWJrYS0iO2k6MzA5O3M6MTc6Ii9cP2RvPWthay11ZGFsaXQtIjtpOjMxMDtzOjE1OiJnemluZmxhdGVcKFwoXCgiO2k6MzExO3M6MjM6IjBccypcKFxzKmd6dW5jb21wcmVzc1woIjtpOjMxMjtzOjIwOiJcJF9SRVFVRVNUXFtbJyJdbGFsYSI7aTozMTM7czo0Mzoic3RycG9zXChcJGltXHMqLFxzKlsnIl08XD9bJyJdXHMqLFxzKlwkaVwrMSI7aTozMTQ7czo2MzoiaHR0cDovL3d3d1wuZ29vZ2xlXC5jb20vc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnlcLlsnIl0maGw9XCRsYW5nIjtpOjMxNTtzOjQzOiJodHRwOi8vZ29cLm1haWxcLnJ1L3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5IjtpOjMxNjtzOjUwOiJodHRwOi8vd3d3XC5iaW5nXC5jb20vc2VhcmNoXD9xPVwkcXVlcnkmcHE9XCRxdWVyeSI7aTozMTc7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MzE4O3M6MTA2OiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypkaXJuYW1lXChccypfX0ZJTEVfX1xzKlwpXHMqXC5ccypbJyJdL3dwLWNvbnRlbnQvdXBsb2FkIjtpOjMxOTtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuaWNvIjtpOjMyMDtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuZ2lmIjtpOjMyMTtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuanBnIjtpOjMyMjtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wucG5nIjtpOjMyMztzOjE0MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLnBuZyI7aTozMjQ7czoxNDI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5naWYiO2k6MzI1O3M6MTQyOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuanBnIjtpOjMyNjtzOjEwNjoidW5saW5rXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXXswLDF9L2Fzc2V0cy9jYWNoZS90ZW1wL0ZpbGVTZXR0aW5ncyI7aTozMjc7czo0ODoiaWZcKFxzKnN0cnBvc1woXHMqXCR2YWx1ZVxzKixccypcJG1hc2tccypcKVxzKlwpIjtpOjMyODtzOjg6ImFiYWtvL0FPIjtpOjMyOTtzOjU1OiJcKi9ccyooaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqL1wqIjtpOjMzMDtzOjM0OiJncm91cF9jb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhIjtpOjMzMTtzOjM3OiJjb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhLHVzZXJuYW1lIjtpOjMzMjtzOjIzOiJcK3VuaW9uXCtzZWxlY3RcKzAsMCwwLCI7aTozMzM7czo5OiJzZXhzZXhzZXgiO2k6MzM0O3M6MzU6IlwkYmFzZV9kb21haW5ccyo9XHMqZ2V0X2Jhc2VfZG9tYWluIjtpOjMzNTtzOjMxOiIhZXJlZ1woWyciXVxeXCh1bnNhZmVfcmF3XClcP1wkIjtpOjMzNjtzOjEwOToiXCRbYS16QS1aMC05X10rP1xzKj1cJFthLXpBLVowLTlfXSs/XHMqXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFsnIl1ccyp7XCRbYS16QS1aMC05X10rPyI7aTozMzc7czoxOToibG1wX2NsaWVudFwoc3RyY29kZSI7aTozMzg7czoxNjoiZXZhbFwoWyciXVxzKi9cKiI7aTozMzk7czoxNToiZXZhbFwoWyciXVxzKi8vIjtpOjM0MDtzOjM0OiJcJHF1ZXJ5XHMrLFxzK1snIl1mcm9tJTIwam9zX3VzZXJzIjtpOjM0MTtzOjc5OiJcJFthLXpBLVowLTlfXSs/XFtcJFthLXpBLVowLTlfXSs/XF1cW1wkW2EtekEtWjAtOV9dKz9cW1xkK1xdXC5cJFthLXpBLVowLTlfXSs/IjtpOjM0MjtzOjI5OiJcKVwpLFBIUF9WRVJTSU9OLG1kNV9maWxlXChcJCI7aTozNDM7czo4MzoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWN1cmxccystT1xzK2h0dHA6Ly8iO2k6MzQ0O3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aTozNDU7czozOToibG9jYXRpb25cLnJlcGxhY2VcKFxcWyciXVwkdXJsX3JlZGlyZWN0IjtpOjM0NjtzOjI4OiJNb3RoZXJbJyJdc1xzK01haWRlblxzK05hbWU6IjtpOjM0NztzOjkwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXW15c3FsZHVtcFxzKy1oXHMrbG9jYWxob3N0XHMrLXUiO2k6MzQ4O3M6Nzc6ImFycmF5X21lcmdlXChcJGV4dFxzKixccyphcnJheVwoWyciXXdlYnN0YXRbJyJdLFsnIl1hd3N0YXRzWyciXSxbJyJddGVtcG9yYXJ5IjtpOjM0OTtzOjMzOiJDb21maXJtXHMrVHJhbnNhY3Rpb25ccytQYXNzd29yZDoiO2k6MzUwO3M6MjI6InhydW1lcl9zcGFtX2xpbmtzXC50eHQiO2k6MzUxO3M6NjoiU0VvRE9SIjtpOjM1MjtzOjcwOiI8XD9waHBccysoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjM1MztzOjIyOiIsWyciXTxcP3BocFxcblsnIl1cLlwkIjtpOjM1NDtzOjUwOiI8aWZyYW1lXHMrc3JjPVsnIl1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tL2Zvcm1zLyI7aTozNTU7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjM1NjtzOjQ1OiJpZlwoZmlsZV9wdXRfY29udGVudHNcKFwkaW5kZXhfcGF0aCxccypcJGNvZGUiO2k6MzU3O3M6NTM6IlwkW2EtekEtWjAtOV9dKz8gPSBcJFthLXpBLVowLTlfXSs/XChbJyJdezAsMX1odHRwOi8vIjtpOjM1ODtzOjUyOiJjXC5sZW5ndGhcKTt9cmV0dXJuXHMqXFxbJyJdXFxbJyJdO31pZlwoIWdldENvb2tpZVwoIjtpOjM1OTtzOjEzOiJcI3TRikk30YbQr9CgIjtpOjM2MDtzOjMxOiJzZWxlY3QgbGFuZ3VhZ2VzX2lkLCBuYW1lLCBjb2RlIjtpOjM2MTtzOjQ0OiJ1cGRhdGUgY29uZmlndXJhdGlvbiBzZXQgY29uZmlndXJhdGlvbl92YWx1ZSI7aTozNjI7czo2NToic2VsZWN0IGNvbmZpZ3VyYXRpb25faWQsIGNvbmZpZ3VyYXRpb25fdGl0bGUsIGNvbmZpZ3VyYXRpb25fdmFsdWUiO2k6MzYzO3M6MzY6Ii9hZG1pbi9jb25maWd1cmF0aW9uXC5waHAvbG9naW5cLnBocCI7aTozNjQ7czoxMDE6InN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlIjtpOjM2NTtzOjEyOiJkbWxsZDBSaGRHRT0iO2k6MzY2O3M6ODE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTozNjc7czo3MToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6MzY4O3M6NzM6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKiwiO2k6MzY5O3M6NTI6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlsnIl0iO2k6MzcwO3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cWyI7aTozNzE7czo0NToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlxbIjtpOjM3MjtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTozNzM7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6Mzc0O3M6NjU6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci90bXAvIjtpOjM3NTtzOjI2OiJleGl0XChcKTpleGl0XChcKTpleGl0XChcKSI7aTozNzY7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6Mzc3O3M6Mzg6IkBtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkdXNlcmZpbGVfdG1wIjtpOjM3ODtzOjIyOiJkaXNhYmxlX2Z1bmN0aW9ucz1ub25lIjtpOjM3OTtzOjE1NToiXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xzKlxdXFtccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC4iO2k6MzgwO3M6MjIyOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6MzgxO3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cKCI7aTozODI7czo0MjoiPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXXswLDF9XCRhWyciXXswLDF9IjtpOjM4MztzOjM3OiJpZlxzKlwoXHMqaW5pX2dldFwoWyciXXswLDF9c2FmZV9tb2RlIjtpOjM4NDtzOjk6IlwkYlwoWyciXSI7aTozODU7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aTozODY7czozNjoiWC1NYWlsZXI6XHMqTWljcm9zb2Z0IE9mZmljZSBPdXRsb29rIjtpOjM4NztzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozODg7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTozODk7czo2NDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKCI7aTozOTA7czoxMzoiQGV4dHJhY3RccypcJCI7aTozOTE7czoxMzoiQGV4dHJhY3RccypcKCI7aTozOTI7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6MzkzO3M6ODE6Im1haWxcKFwkX1BPU1RcW1snIl17MCwxfWVtYWlsWyciXXswLDF9XF0sXHMqXCRfUE9TVFxbWyciXXswLDF9c3ViamVjdFsnIl17MCwxfVxdLCI7aTozOTQ7czo4NDoibW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJF9GSUxFU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtbJyJddG1wX25hbWVbJyJdXF1ccyosIjtpOjM5NTtzOjQ1OiJNb3ppbGxhLzVcLjBccypcKGNvbXBhdGlibGU7XHMqR29vZ2xlYm90LzJcLjEiO2k6Mzk2O3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6Mzk3O3M6MTc6IjwvYm9keT5ccyo8c2NyaXB0IjtpOjM5ODtzOjQzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1wcmVnX3JlcGxhY2VbJyJdIjtpOjM5OTtzOjM3OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1hc3NlcnRbJyJdIjtpOjQwMDtzOjQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1jcmVhdGVfZnVuY3Rpb25bJyJdIjtpOjQwMTtzOjQ0OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1iYXNlNjRfZGVjb2RlWyciXSI7aTo0MDI7czozNToiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdZXZhbFsnIl0iO2k6NDAzO3M6Mjg6IkNyZWRpdFxzKkNhcmRccypWZXJpZmljYXRpb24iO2k6NDA0O3M6NjY6IlJld3JpdGVDb25kXHMqJXtIVFRQOkFjY2VwdC1MYW5ndWFnZX1ccypcKHJ1XHxydS1ydVx8dWtcKVxzKlxbTkNcXSI7aTo0MDU7czo0MjoiUmV3cml0ZUNvbmRccyole0hUVFA6eC1vcGVyYW1pbmktcGhvbmUtdWF9IjtpOjQwNjtzOjM0OiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LXdhcC1wcm9maWxlIjtpOjQwNztzOjIyOiJldmFsXHMqXChccypnZXRfb3B0aW9uIjtpOjQwODtzOjI5OiJlY2hvXHMrWyciXXswLDF9Z29vZFsnIl17MCwxfSI7aTo0MDk7czo1MToiQ1VSTE9QVF9SRUZFUkVSLFxzKlsnIl17MCwxfWh0dHBzOi8vd3d3XC5nb29nbGVcLmNvIjtpOjQxMDtzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6NDExO3M6NjQ6Ij1ccypcJEdMT0JBTFNcW1xzKlsnIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdXHMqXF0iO2k6NDEyO3M6NjQ6ImVjaG9ccytzdHJpcHNsYXNoZXNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDEzO3M6MjI6IjxoMT5Mb2FkaW5nXC5cLlwuPC9oMT4iO2k6NDE0O3M6MTI6InBocGluZm9cKFwpOyI7aTo0MTU7czozMTA6IihldmFsfGJhc2U2NF9kZWNvZGV8c3Vic3RyfHN0cnJldnxwcmVnX3JlcGxhY2V8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDUpXHMqXChccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN1YnN0cnxzdHJyZXZ8cHJlZ19yZXBsYWNlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1KVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdWJzdHJ8c3RycmV2fHByZWdfcmVwbGFjZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNSkiO2k6NDE2O3M6MTU6IlsnIl0vXC5cKi9lWyciXSI7aTo0MTc7czoyODoiZWNob1xzKlwoKlxzKlsnIl1OTyBGSUxFWyciXSI7aTo0MTg7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoKlxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6NDE5O3M6MjM6ImNvcHlccypcKFxzKlsnIl1odHRwOi8vIjtpOjQyMDtzOjgyOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9UmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKlVSTD1odHRwOi8vIjtpOjQyMTtzOjgxOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9cmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKnVybD08XD9waHAiO2k6NDIyO3M6MTA6IlsnIl1hSFIwY0QiO2k6NDIzO3M6Njc6InN0cmNoclxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDI0O3M6Njc6InN0cnN0clxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDI1O3M6Njc6InN0cnBvc1xzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF0iO2k6NDI2O3M6MzM6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aTo0Mjc7czoxMDoicGNudGxfZXhlYyI7aTo0Mjg7czo2OToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKCpbJyJdY2RccysvdG1wIjtpOjQyOTtzOjI3OiJcJE9PTy4rPz1ccyp1cmxkZWNvZGVccypcKCoiO2k6NDMwO3M6MTI6InJtXHMrLWZccystciI7aTo0MzE7czoxMjoicm1ccystclxzKy1mIjtpOjQzMjtzOjg6InJtXHMrLWZyIjtpOjQzMztzOjg6InJtXHMrLXJmIjtpOjQzNDtzOjY5OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQCp1cmxlbmNvZGUiO2k6NDM1O3M6NjM6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdaW1hZ2VzLyI7aTo0MzY7czo4OToiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDM3O3M6NTk6ImJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQzODtzOjUxOiJkb2N1bWVudFwud3JpdGVccypcKFxzKnVuZXNjYXBlXHMqXChccypbJyJdezAsMX0lM0MiO2k6NDM5O3M6ODoiLy9OT25hTUUiO2k6NDQwO3M6ODoibHNccystbGEiO2k6NDQxO3M6Mzc6ImluaV9zZXRcKFxzKlsnIl17MCwxfW1hZ2ljX3F1b3Rlc19ncGMiO2k6NDQyO3M6Mjg6ImFuZHJvaWRcfGF2YW50Z29cfGJsYWNrYmVycnkiO2k6NDQzO3M6NDE6ImZpbmRccysvXHMrLXR5cGVccytmXHMrLW5hbWVccytcLmh0cGFzc3dkIjtpOjQ0NDtzOjM3OiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTAyMDAwIjtpOjQ0NTtzOjM3OiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjQ0NjtzOjU6InhDZWR6IjtpOjQ0NztzOjk6IlwkcGFzc191cCI7aTo0NDg7czo1OiJPbmV0NyI7aTo0NDk7czo1OiJKVGVybSI7aTo0NTA7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjQ1MTtzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6NDUyO3M6MTU6IjEwOVwuMjM4XC4yNDJcLiI7aTo0NTM7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0NTQ7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdSFRUUF9SRUZFUkVSWyciXVxzKlxdXHMqLFxzKlsnIl10cnVzdGxpbmtcLnJ1Ijt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxMTM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjQ6IlwkeDEgPSBcJHRoaXMtPncgLSBcJHgxOyI7aToxODtzOjMxOiJhc29ydFwoXCRDYWNoZURpck9sZEZpbGVzQWdlXCk7IjtpOjE5O3M6MTM6IlwoJ3I1N3NoZWxsJywiO2k6MjA7czoyNToiZXZhbFwoImxpc3RlbmVyID0gIlwrbGlzdCI7aToyMTtzOjg6ImV2YWxcKFwpIjtpOjIyO3M6MzM6InByZWdfcmVwbGFjZV9jYWxsYmFja1woJy9cXHtcKGltYSI7aToyMztzOjIxOiJldmFsIFwoX2N0TWVudUluaXRTdHIiO2k6MjQ7czoyOToiYmFzZTY0X2RlY29kZVwoXCRhY2NvdW50S2V5XCkiO2k6MjU7czozOToiYmFzZTY0X2RlY29kZVwoXCRkYXRhXClcKTsgXCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY1OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpOyBpZlwoQ2hlY2tTZXJpYWxpemVkRCI7aToyODtzOjYzOiJwY250bF9leGVjJyA9PiBBcnJheVwoQXJyYXlcKDFcKSwgXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6Njg6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTsgaWYgXChzdHJsZW5cKFwkIjtpOjMxO3M6NTE6ImV2YWxcKCdcJGhleGR0aW1lID0gIicgXC4gXCRoZXhkdGltZSBcLiAnIjsnXCk7IFwkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czo0MToiaWZcKDFcKSB7IFwkdl9ob3VyID0gXChcJHBfaGVhZGVyXFsnbXRpbWUiO2k6MzU7czo3MDoiZG9jdW1lbnRcLndyaXRlXCh1bmVzY2FwZVwoIiUzQ3NjcmlwdCUyMHNyYz0lMjJodHRwIiBcKyBcKFwoImh0dHBzOiIgPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNToiJ2ZpbGVuYW1lJ1wpLCBcKCdyNTdzaGVsbCI7aTozOTtzOjQzOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnIiBcLiBcJGVyck1zZyBcLiAiJ1wpIjtpOjQwO3M6NDI6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKFxcIkVycm9yIHdoZW4gbG9hZGluZyI7aTo0MTtzOjQzOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnIlwuSlRleHQ6Ol9cKCdWQUxJRF9FIjtpOjQyO3M6ODoiZXZhbFwoXCkiO2k6NDM7czo4OiInc3lzdGVtJyI7aTo0NDtzOjY6IidldmFsJyI7aTo0NTtzOjY6IiJldmFsIiI7aTo0NjtzOjc6Il9zeXN0ZW0iO2k6NDc7czo5OiJzYXZlMmNvcHkiO2k6NDg7czoxMDoiZmlsZXN5c3RlbSI7aTo0OTtzOjg6InNlbmRtYWlsIjtpOjUwO3M6ODoiY2FuQ2htb2QiO2k6NTE7czoxMzoiL2V0Yy9wYXNzd2RcKSI7aTo1MjtzOjI0OiJ1ZHA6Ly8nXC5zZWxmOjpcJF9jX2FkZHIiO2k6NTM7czozNDoiZWRvY2VkXzQ2ZXNhYlwoJydcfCJcKVxcXCknLCAncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyMToid2l0aCAwLzAvMCBpZiBcKDFcKSB7IjtpOjU4O3M6NDg6IlwkeDIgPSBcJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo1OTtzOjk6InNwZWNpYWxpcyI7aTo2MDtzOjg6ImNvcHlcKFwpIjtpOjYxO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjI7czo3OiItPmNobW9kIjtpOjYzO3M6NzoiX21haWxcKCI7aTo2NDtzOjc6Il9jb3B5XCgiO2k6NjU7czo0Njoic3RycG9zXChcJF9TRVJWRVJcWydIVFRQX1VTRVJfQUdFTlQnXF0sICdEcnVwYSI7aTo2NjtzOjQ1OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwgJ01TSUUiO2k6Njc7czo0NToic3RycG9zXChcJF9TRVJWRVJcWyJIVFRQX1VTRVJfQUdFTlQiXF0sICdNU0lFIjtpOjY4O3M6MTc6ImV2YWwgXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo1MjoiXCR4MSA9IFwkbWluX3g7IFwkeDIgPSBcJG1heF94OyBcJHkxID0gXCRtaW5feTsgXCR5MiI7aTo3MjtzOjU1OiJcJGN0bVxbJ2EnXF1cKVwpIHsgXCR4ID0gXCR4IFwqIFwkdGhpcy0+azsgXCR5ID0gXChcJHRoIjtpOjczO3M6NjA6IlsnIl17MCwxfWNyZWF0ZV9mdW5jdGlvblsnIl17MCwxfSwgWyciXXswLDF9Z2V0X3Jlc291cmNlX3R5cCI7aTo3NDtzOjQ5OiJbJyJdezAsMX1jcmVhdGVfZnVuY3Rpb25bJyJdezAsMX0sIFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njk6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSwgWyciXXswLDF9THlueCI7aTo3NjtzOjY4OiJzdHJzdHJcKFwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF0sIFsnIl17MCwxfU1TSSI7aTo3NztzOjI1OiJzb3J0XChcJERpc3RyaWJ1dGlvblxbXCRrIjtpOjc4O3M6MjU6InNvcnRcKGZ1bmN0aW9uXChhLGJcKXtyZXQiO2k6Nzk7czoyNToiaHR0cDovL3d3d1wuZmFjZWJvb2tcLmNvbSI7aTo4MDtzOjI1OiJodHRwOi8vbWFwc1wuZ29vZ2xlXC5jb20vIjtpOjgxO3M6NTI6InVkcDovLydcLnNlbGY6OlwkY19hZGRyLCA4MCwgXCRlcnJubywgXCRlcnJzdHIsIDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NzoibW92ZV91cGxvYWRlZF9maWxlXCggXCRfRklMRVNcWyd1cGxvYWRlZF9wYWNrYWdlJ1xdXFsndG1wX25hbWUnXF0sIFwkbW9zQ29uZmkiO2k6ODY7czoxMzoiZmFsc2VcKSBcKTtcIyI7aTo4NztzOjE2OiJuY3lfbmFtZWAnIFwpO1wjIjtpOjg4O3M6NDc6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCAnTWFjIE9TIjtpOjg5O3M6MjA6Ii8vbm9uYW1lOiAnPFw/PUNVdGlsIjtpOjkwO3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjkxO3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTI7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTM7czo1NToiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsIFwkcmVwbGFjZSI7aTo5NDtzOjQwOiJcXHgxZlxceDhiXFx4MDhcXHgwMFxceDAwXFx4MDBcXHgwMFxceDAwIjtpOjk1O3M6NDA6IlxceDUwXFx4NGJcXHgwNVxceDA2XFx4MDBcXHgwMFxceDAwXFx4MDAiO2k6OTY7czo0NjoiXFx4MDlcXHgwQVxceDBCXFx4MENcXHgwRFxceDIwXFx4MkZcXHgzRVxdXFtcXiI7aTo5NztzOjQwOiJcXHg4OVxceDUwXFx4NEVcXHg0N1xceDBEXFx4MEFcXHgxQVxceDBBIjtpOjk4O3M6MTE6IlwpO1wjaScsICcmIjtpOjk5O3M6MTg6IlwpO1wjbWlzJywgJyAnLCBcJCI7aToxMDA7czoyMToiXCk7XCNpJywgXCRkYXRhLCBcJG1hIjtpOjEwMTtzOjM1OiJcJGZ1bmNcKCBcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDI7czo0MDoiXFx4MWZcXHg4YlxceDA4XFx4MDBcXHgwMFxceDAwXFx4MDBcXHgwMCI7aToxMDM7czo0NToiXFx4MDBcXHgwMVxceDAyXFx4MDNcXHgwNFxceDA1XFx4MDZcXHgwN1xceDA4IjtpOjEwNDtzOjQwOiJcXHgyMVxceDIzXFx4MjRcXHgyNVxceDI2XFx4MjdcXHgyYVxceDJiIjtpOjEwNTtzOjM1OiJcXHg4M1xceDhCXFx4OERcXHg5QlxceDlFXFx4OUZcXHhBMSI7aToxMDY7czozMDoiXFx4MDlcXHgwQVxceDBCXFx4MENcXHgwRFxceDIwIjtpOjEwNztzOjMzOiJcLlwuL1wuXC4vXC5cLi9cLlwuL21vZHVsZXMvbW9kX20iO2k6MTA4O3M6MzA6IlwkZGVjb3JhdG9yXChcJG1hdGNoZXNcWzFcXVxbMCI7aToxMDk7czoyMjoiXCRkZWNvZGVmdW5jXCggXCRkXFtcJCI7aToxMTA7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTExO3M6NDg6InN0cmVhbV9zb2NrZXRfY2xpZW50XCggJ3RjcDovLycgXC4gXCRwcm94eS0+aG9zdCI7aToxMTI7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjt9"));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlsnIlwoXCRdIjtpOjEyMjtzOjExOiJcYm1haWxccypcKCI7aToxMjM7czo0NjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccypbJyJdezAsMX1waHA6Ly9pbnB1dCI7aToxMjQ7czoxMTg6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1Db250ZW50LXR5cGVbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfXRleHQvaHRtbDtccypjaGFyc2V0PXdpbmRvd3MtMTI1MVsnIl17MCwxfT48Ym9keT4iO2k6MTI1O3M6NjI6Ij1ccypkb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoXHMqWyciXXswLDF9c2NyaXB0WyciXXswLDF9XHMqXCk7IjtpOjEyNjtzOjY5OiJkb2N1bWVudFwuYm9keVwuaW5zZXJ0QmVmb3JlXChkaXYsXHMqZG9jdW1lbnRcLmJvZHlcLmNoaWxkcmVuXFswXF1cKTsiO2k6MTI3O3M6Nzc6IjxzY3JpcHRccyt0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vW2EtekEtWjAtOV9dKz9cLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YTo0NTp7aTowO3M6MjU6InNsaW5rc1wuc3UvZ2V0X2xpbmtzXC5waHAiO2k6MTtzOjEzOiJNTF9sY29kZVwucGhwIjtpOjI7czoxMzoiTUxfJWNvZGVcLnBocCI7aTozO3M6MTk6ImNvZGVzXC5tYWlubGlua1wucnUiO2k6NDtzOjE5OiJfX2xpbmtmZWVkX3JvYm90c19fIjtpOjU7czoxMzoiTElOS0ZFRURfVVNFUiI7aTo2O3M6MTQ6IkxpbmtmZWVkQ2xpZW50IjtpOjc7czoxODoiX19zYXBlX2RlbGltaXRlcl9fIjtpOjg7czoyOToiZGlzcGVuc2VyXC5hcnRpY2xlc1wuc2FwZVwucnUiO2k6OTtzOjExOiJMRU5LX2NsaWVudCI7aToxMDtzOjExOiJTQVBFX2NsaWVudCI7aToxMTtzOjE2OiJfX2xpbmtmZWVkX2VuZF9fIjtpOjEyO3M6MTY6IlNMQXJ0aWNsZXNDbGllbnQiO2k6MTM7czoxNzoiLT5HZXRMaW5rc1xzKlwoXCkiO2k6MTQ7czoxNzoiZGJcLnRydXN0bGlua1wucnUiO2k6MTU7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxNjtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE3O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MTg7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MTk7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIwO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjE7czoxNjY6Imlzc2V0XHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjI7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCgqXHMqXCRsaWJfcGF0aCI7aToyMztzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoKlxzKiI7aToyNDtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKSpccyo7XHMqXD8+IjtpOjI1O3M6NzoibGV2aXRyYSI7aToyNjtzOjEwOiJkYXBveGV0aW5lIjtpOjI3O3M6NjoidmlhZ3JhIjtpOjI4O3M6NjoiY2lhbGlzIjtpOjI5O3M6ODoicHJvdmlnaWwiO2k6MzA7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMTtzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzI7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjMzO3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzQ7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM1O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM2O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM3O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTozODtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTozOTtzOjEwOiJfX0xJTktfXzxhIjtpOjQwO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MTtzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQyO3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDM7czoxNToiX19MSU5LX19fX0VORF9fIjtpOjQ0O3M6MjI6Im5ld1xzK1RSVVNUTElOS19jbGllbnQiO30="));
$g_JSVirSig = unserialize(base64_decode("YToxMTg6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czo0MToiZj0nZidcKydyJ1wrJ28nXCsnbSdcKydDaCdcKydhckMnXCsnb2RlJzsiO2k6NTtzOjIyOiJcLnByb3RvdHlwZVwuYX1jYXRjaFwoIjtpOjY7czozNzoidHJ5e0Jvb2xlYW5cKFwpXC5wcm90b3R5cGVcLnF9Y2F0Y2hcKCI7aTo3O3M6MzQ6ImlmXChSZWZcLmluZGV4T2ZcKCdcLmdvb2dsZVwuJ1wpIT0iO2k6ODtzOjg2OiJpbmRleE9mXHxpZlx8cmNcfGxlbmd0aFx8bXNuXHx5YWhvb1x8cmVmZXJyZXJcfGFsdGF2aXN0YVx8b2dvXHxiaVx8aHBcfHZhclx8YW9sXHxxdWVyeSI7aTo5O3M6NTQ6IkFycmF5XC5wcm90b3R5cGVcLnNsaWNlXC5jYWxsXChhcmd1bWVudHNcKVwuam9pblwoIiJcKSI7aToxMDtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjExO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTI7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTM7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxNDtzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNTtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE2O3M6MTc6IjwvaHRtbD5ccyo8c2NyaXB0IjtpOjE3O3M6MTc6IjwvaHRtbD5ccyo8aWZyYW1lIjtpOjE4O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxOTtzOjc6IlxceDY1QXQiO2k6MjA7czo5OiJcXHg2MXJDb2QiO2k6MjE7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToyMjtzOjExOiI9ImV2IlwrImFsIiI7aToyMztzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjQ7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjI1O3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjI2O3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI3O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI4O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6Mjk7czo5OiJ2YXJccytfMHgiO2k6MzA7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6MzE7czo3OiJwaW5nbm93IjtpOjMyO3M6ODoic2VyY2hib3QiO2k6MzM7czoxMDoia20wYWU5Z3I2bSI7aTozNDtzOjY6ImMzMjg0ZCI7aTozNTtzOjg6IlxceDY4YXJDIjtpOjM2O3M6ODoiXFx4NmRDaGEiO2k6Mzc7czo3OiJcXHg2ZmRlIjtpOjM4O3M6NzoiXFx4NmZkZSI7aTozOTtzOjg6IlxceDQzb2RlIjtpOjQwO3M6NzoiXFx4NzJvbSI7aTo0MTtzOjc6IlxceDQzaGEiO2k6NDI7czo3OiJcXHg3MkNvIjtpOjQzO3M6ODoiXFx4NDNvZGUiO2k6NDQ7czoxMDoiXC5keW5kbnNcLiI7aTo0NTtzOjk6IlwuZHluZG5zLSI7aTo0NjtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ3O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0ODtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDk7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NTA7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NTE7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjUyO3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTM7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjU0O3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1NTtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjU2O3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NztzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU4O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1OTtzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo2MDtzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo2MTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjYyO3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYzO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjY0O3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjU7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjY7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NztzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2ODtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2OTtzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo3MDtzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjcxO3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjcyO3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MztzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3NDtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjc1O3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3NjtzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6Nzc7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3ODtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3OTtzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjgwO3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo4MTtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6ODI7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MztzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjg0O3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjg1O3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4NjtzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg3O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg4O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg5O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo5MDtzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo5MTtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo5MjtzOjU1OiJzdHJpcG9zXHMqXChccypmX2hheXN0YWNrXHMqLFxzKmZfbmVlZGxlXHMqLFxzKmZfb2Zmc2V0IjtpOjkzO3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjk0O3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6OTU7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5NjtzOjE3OiJzZXhmcm9taW5kaWFcLmNvbSI7aTo5NztzOjExOiJmaWxla3hcLmNvbSI7aTo5ODtzOjEzOiJzdHVtbWFublwubmV0IjtpOjk5O3M6MTQ6Imh0dHA6Ly94enhcLnBtIjtpOjEwMDtzOjE4OiJcLmhvcHRvXC5tZS9qcXVlcnkiO2k6MTAxO3M6MTE6Im1vYmktZ29cLmluIjtpOjEwMjtzOjE4OiJiYW5rb2ZhbWVyaWNhXC5jb20iO2k6MTAzO3M6MTY6Im15ZmlsZXN0b3JlXC5jb20iO2k6MTA0O3M6MTc6ImZpbGVzdG9yZTcyXC5pbmZvIjtpOjEwNTtzOjE2OiJmaWxlMnN0b3JlXC5pbmZvIjtpOjEwNjtzOjE1OiJ1cmwyc2hvcnRcLmluZm8iO2k6MTA3O3M6MTg6ImZpbGVzdG9yZTEyM1wuaW5mbyI7aToxMDg7czoxMjoidXJsMTIzXC5pbmZvIjtpOjEwOTtzOjE0OiJkb2xsYXJhZGVcLmNvbSI7aToxMTA7czoxMToic2VjY2xpa1wucnUiO2k6MTExO3M6MTE6Im1vYnktYWFcLnJ1IjtpOjExMjtzOjEyOiJzZXJ2bG9hZFwucnUiO2k6MTEzO3M6NDg6InN0cmlwb3NcKG5hdmlnYXRvclwudXNlckFnZW50XHMqLFxzKmxpc3RfZGF0YVxbaSI7aToxMTQ7czoyNjoiaWZccypcKCFzZWVfdXNlcl9hZ2VudFwoXCkiO2k6MTE1O3M6NDY6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypbJyJdWyciXTt9aWZcKCFnZXRDb29raWUiO2k6MTE2O3M6NzA6IjxzY3JpcHRccyp0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzKnNyYz1bJyJdezAsMX1mdHA6Ly8iO2k6MTE3O3M6NDg6ImlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXChbJyJdezAsMX1zYWJyaSI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTo0NDp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjQwOiJwb3NpdGlvbjphYnNvbHV0ZTtsZWZ0Oi1cZCtweDt0b3A6LVxkK3B4IjtpOjU7czozMDoiY29tcGFsXHxlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyMjoiZWxhaW5lXHxmZW5uZWNcfGhpcHRvcCI7aTo3O3M6Mjk6IlwoZnVuY3Rpb25cKGEsYlwpe2lmXCgvXChhbmRyIjtpOjg7czozNzoiZG9jdW1lbnRcLndyaXRlXChbJyJdPHNjclsnIl1cK1snIl1pcCI7aTo5O3M6NDk6ImlmcmFtZVwuc3R5bGVcLndpZHRoXHMqPVxzKlsnIl17MCwxfTBweFsnIl17MCwxfTsiO2k6MTA7czoxMDE6ImRvY3VtZW50XC5jYXB0aW9uPW51bGw7d2luZG93XC5hZGRFdmVudFwoWyciXXswLDF9bG9hZFsnIl17MCwxfSxmdW5jdGlvblwoXCl7dmFyIGNhcHRpb249bmV3IEpDYXB0aW9uIjtpOjExO3M6MTI6Imh0dHA6Ly9mdHBcLiI7aToxMjtzOjc6Im5ublwucG0iO2k6MTM7czo3OiJubm1cLnBtIjtpOjE0O3M6MTY6InRvcC13ZWJwaWxsXC5jb20iO2k6MTU7czoxOToiZ29vZHBpbGxzZXJ2aWNlXC5ydSI7aToxNjtzOjc4OiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9aHR0cDovL2dvb1wuZ2wiO2k6MTc7czo2NzoiIlxzKlwrXHMqbmV3IERhdGVcKFwpXC5nZXRUaW1lXChcKTtccypkb2N1bWVudFwuYm9keVwuYXBwZW5kQ2hpbGRcKCI7aToxODtzOjM0OiJcLmluZGV4T2ZcKFxzKlsnIl1JQnJvd3NlWyciXVxzKlwpIjtpOjE5O3M6ODc6Ij1kb2N1bWVudFwucmVmZXJyZXI7XHMqW2EtekEtWjAtOV9dKz89dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXSs/XHMqXCk7XHMqdmFyXHMrRXhwRGF0ZSI7aToyMDtzOjc0OiI8IS0tXHMqW2EtekEtWjAtOV9dKz9ccyotLT48c2NyaXB0Lis/PC9zY3JpcHQ+PCEtLS9ccypbYS16QS1aMC05X10rP1xzKi0tPiI7aToyMTtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToyMjtzOjcyOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rP1wrWyciXXRlWyciXVxzKlxdXChTdHJpbmciO2k6MjM7czo4MToic2V0Q29va2llXChccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1xzKixccypfMHhbYS16QS1aMC05X10rP1wpIjtpOjI0O3M6Mjk6IlxdXChccyp2XCtcK1xzKlwpLTFccypcKVxzKlwpIjtpOjI1O3M6NDQ6ImRvY3VtZW50XFtccypfMHhbYS16QS1aMC05X10rP1xbXGQrXF1ccypcXVwoIjtpOjI2O3M6Mjg6Ii9nLFsnIl1bJyJdXClcLnNwbGl0XChbJyJdXF0iO2k6Mjc7czo0Mzoid2luZG93XC5sb2NhdGlvbj1ifVwpXChuYXZpZ2F0b3JcLnVzZXJBZ2VudCI7aToyODtzOjIyOiJbJyJdcmVwbGFjZVsnIl1cXVwoL1xbIjtpOjI5O3M6MTI3OiJpXFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dKz9cW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdXChcZCssXGQrXClcKVwpe3dpbmRvd1xbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF09bG9jIjtpOjMwO3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MzE7czo1MToiWyciXVxdXChbYS16QS1aMC05X10rP1wrXCtcKS1cZCtcKX1cKEZ1bmN0aW9uXChbJyJdIjtpOjMyO3M6NjU6Ijt3aGlsZVwoW2EtekEtWjAtOV9dKz88XGQrXClkb2N1bWVudFxbLis/XF1cKFN0cmluZ1xbWyciXWZyb21DaGFyIjtpOjMzO3M6MTA5OiJpZlxzKlwoW2EtekEtWjAtOV9dKz9cLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjM0O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzU7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzY7czoxMzc6ImZhbHNlfTtbYS16QS1aMC05X10rPz1bYS16QS1aMC05X10rP1woWyciXVthLXpBLVowLTlfXSs/WyciXVwpXHxbYS16QS1aMC05X10rP1woWyciXVthLXpBLVowLTlfXSs/WyciXVwpO1thLXpBLVowLTlfXSs/XHw9W2EtekEtWjAtOV9dKz87IjtpOjM3O3M6NjU6IlN0cmluZ1wuZnJvbUNoYXJDb2RlXChccypbYS16QS1aMC05X10rP1wuY2hhckNvZGVBdFwoaVwpXHMqXF5ccyoyIjtpOjM4O3M6MTY6Ii49WyciXS46Ly8uXC4uLy4iO2k6Mzk7czo1ODoiXFtbJyJdY2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXSs/XHMqXCtccypbJyJdQXRbJyJdXF1cKCI7aTo0MDtzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjQxO3M6NTY6IlN0cmluZ1xbXHMqWyciXWZyb21DaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dKz9ccypcXVwoIjtpOjQyO3M6Mjg6Ii49WyciXS46Ly8uXC4uXC4uXC4uLy5cLi5cLi4iO2k6NDM7czo0MDoiPC9zY3JpcHQ+WyciXVwpO1xzKi9cKi9bYS16QS1aMC05X10rP1wqLyI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YTo2Mjp7aTowO3M6MTM6IkludmFsaWRccytUVk4iO2k6MTtzOjExOiJJbnZhbGlkIFJWTiI7aToyO3M6NDA6ImRlZmF1bHRTdGF0dXNccyo9XHMqWyciXUludGVybmV0IEJhbmtpbmciO2k6MztzOjI4OiI8dGl0bGU+XHMqQ2FwaXRlY1xzK0ludGVybmV0IjtpOjQ7czoyNzoiPHRpdGxlPlxzKkludmVzdGVjXHMrT25saW5lIjtpOjU7czozOToiaW50ZXJuZXRccytQSU5ccytudW1iZXJccytpc1xzK3JlcXVpcmVkIjtpOjY7czoxMToiPHRpdGxlPlNhcnMiO2k6NztzOjEzOiI8YnI+QVRNXHMrUElOIjtpOjg7czoxODoiQ29uZmlybWF0aW9uXHMrT1RQIjtpOjk7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMDtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTE7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMjtzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjEzO3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTQ7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNTtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE2O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE3O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxODtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MTk7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIwO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMTtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIyO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjM7czoxMToiQkFOQ09MT01CSUEiO2k6MjQ7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNTtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6MjY7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI3O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjg7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aToyOTtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMwO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMxO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMjtzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjMzO3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNDtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzU7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM2O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozNztzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozODtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjM5O3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDA7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDE7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MjtzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0MztzOjE4OiJcLmh0bWxcP2NtZD1sb2dpbj0iO2k6NDQ7czoxODoiV2VibWFpbFxzKjwvdGl0bGU+IjtpOjQ1O3M6MjM6Ijx0aXRsZT5ccypVUENccytXZWJtYWlsIjtpOjQ2O3M6MTc6IlwucGhwXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTc6IlwuaHRtXD9jbWQ9bG9naW49IjtpOjQ4O3M6MjM6Ilwuc3dlZGJhbmtcLnNlL21kcGF5YWNzIjtpOjQ5O3M6MjQ6IlwuXHMqXCRfUE9TVFxbXHMqWyciXWN2diI7aTo1MDtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1MTtzOjEwOiJCWS1TUDFOMFpBIjtpOjUyO3M6NDU6IlNlY3VyaXR5XHMrcXVlc3Rpb25ccys6XHMrWyciXVxzKlwuXHMqXCRfUE9TVCI7aTo1MztzOjQwOiJpZlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkc2NhbVxzKlwuXHMqXCRpIjtpOjU0O3M6MjA6Ijx0aXRsZT5ccypCZXN0LnRpZ2VuIjtpOjU1O3M6MjA6Ijx0aXRsZT5ccypMQU5ERVNCQU5LIjtpOjU2O3M6NTI6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwucGhwXD9jbWQ9bG9naW4iO2k6NTc7czo1NDoid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaW5kZXhcZCsqXC5odG1sKlw/Y21kPWxvZ2luIjtpOjU4O3M6MjU6Ijx0aXRsZT5ccypNYWlsXHMqPC90aXRsZT4iO2k6NTk7czoyODoiU2llXHMrSWhyXHMrS29udG9ccyo8L3RpdGxlPiI7aTo2MDtzOjI5OiJQYXlwYWxccytLb250b1xzK3ZlcmlmaXppZXJlbiI7aTo2MTtzOjMwOiJcJF9HRVRcW1xzKlsnIl1jY19jb3VudHJ5X2NvZGUiO30="));

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

define('AI_VERSION', '20150801');

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

	$text = "[$l_FN] $num of {$total_files}. $percent%" . $stat;
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
		'quarantine',
		'imake',
		'icheck'
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
      --imake
      --icheck
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

	define('IMAKE', isset($options['imake']));
	define('ICHECK', isset($options['icheck']));

	if (IMAKE && ICHECK) die('One of the following options must be used --imake or --icheck.');

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
  
  $search  = array( ' ;', ' =', ' ,', ' .', ' (', ' )', ' {', ' }', '; ', '= ', ', ', '. ', '( ', '( ', '{ ', '} ');
  $replace = array(  ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}', ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}');
  $par_Content = str_replace('@', '', $par_Content);
  $par_Content = preg_replace('~\s+~', ' ', $par_Content);
  $par_Content = str_replace($search, $replace, $par_Content);
  $par_Content = preg_replace_callback('~\bchr\(\s*([0-9a-fA-FxX]+)\s*\)~', function ($m) { return "'".chr(intval($m[1], 0))."'"; }, $par_Content );

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
                $l_Content = @file_get_contents($l_Filename);
                $l_Unwrapped = @php_strip_whitespace($l_Filename);
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

				//$l_Unwrapped = preg_replace('|/\*.*?\*/|smi', '', $l_Unwrapped);
				//$l_Unwrapped = RemoveCommentsPHP($l_Unwrapped);
				
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
   if (!(ICHECK || IMAKE) && !$l_SpecifiedPath && file_exists(DOUBLECHECK_FILE)) {
      stdOut("Start scanning the list from '" . DOUBLECHECK_FILE . "'.");
      $s_file = new SplFileObject(DOUBLECHECK_FILE);
      $s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
      // force to seek to last line
      $s_file->seek(PHP_INT_MAX);
      // get number of lines
      $g_FoundTotalFiles = $g_Counter = $s_file->key();
      stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
      stdOut(str_repeat(' ', 160),false);
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
      if (ICHECK || IMAKE) {
      // INTEGRITY CHECK
        IMAKE and unlink(INTEGRITY_DB_FILE);
        ICHECK and load_integrity_db();
        QCR_IntegrityCheck(ROOT_PATH);
        stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
        if (ICHECK) {
            $i = $g_Counter;
            $g_CRC = 0;
            $changes = array();
            foreach ($g_IntegrityDB as $l_FileName => $type) {
                $type = in_array($type, array('added', 'modified')) ? $type : 'deleted';
                $type .= substr($l_FileName, -1) == '/' ? 'Dirs' : 'Files';
                $changes[$type][] = ++$i;
                AddResult($l_FileName, $i);
            }
            $g_FoundTotalFiles = count($changes['addedFiles']) + count($changes['modifiedFiles']);
            stdOut("Found changes " . count($changes['modifiedFiles']) . " files and added " . count($changes['addedFiles']) . " files.");
        }
        
      } else {
      QCR_ScanDirectories(ROOT_PATH);
      stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
      }

      QCR_Debug();
      stdOut(str_repeat(' ', 160),false);
      QCR_GoScan(0);
      unlink(QUEUE_FILENAME);
   }
}

//$g_FoundTotalFiles = count($g_Structure['n']);
//$g_FoundTotalFiles = $g_Counter - $g_FoundTotalDirs;

QCR_Debug();

//stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
//stdOut(str_repeat(' ', 160),false);

//$g_FoundTotalFiles = count($g_Structure['n']);

// detect version CMS
$l_CmsListDetector = new CmsVersionDetector('.');
$l_CmsDetectedNum = $l_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $l_CmsListDetector->getCmsName($tt) . ' v' . $l_CmsListDetector->getCmsVersion($tt);
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
if (!(ICHECK || IMAKE))
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


if (ICHECK) {
    stdOut("Building list of added files " . count($changes['addedFiles']));
    if (count($changes['addedFiles']) > 0) {
      $l_Result .= '<div class="note_vir">' . AI_STR_082 . ' (' . count($changes['addedFiles']) . ')</div><div class="crit">';
      $l_Result .= printList($changes['addedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of modified files " . count($changes['modifiedFiles']));
    if (count($changes['modifiedFiles']) > 0) {
      $l_Result .= '<div class="note_vir">' . AI_STR_083 . ' (' . count($changes['modifiedFiles']) . ')</div><div class="crit">';
      $l_Result .= printList($changes['modifiedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted files " . count($changes['deletedFiles']));
    if (count($changes['deletedFiles']) > 0) {
      $l_Result .= '<div class="note_vir">' . AI_STR_084 . ' (' . count($changes['deletedFiles']) . ')</div><div class="crit">';
      $l_Result .= printList($changes['deletedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of added dirs " . count($changes['addedDirs']));
    if (count($changes['addedDirs']) > 0) {
      $l_Result .= '<div class="note_vir">' . AI_STR_085 . ' (' . count($changes['addedDirs']) . ')</div><div class="crit">';
      $l_Result .= printList($changes['addedDirs']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted dirs " . count($changes['deletedDirs']));
    if (count($changes['deletedDirs']) > 0) {
      $l_Result .= '<div class="note_vir">' . AI_STR_086 . ' (' . count($changes['deletedDirs']) . ')</div><div class="crit">';
      $l_Result .= printList($changes['deletedDirs']);
      $l_Result .= "</div>" . PHP_EOL;
    }
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


///////////////////////////////////////////////////////////////////////////
function QCR_IntegrityCheck($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, 
			$defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, 
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt;
	global $g_IntegrityDB, $g_ICheck;
	static $l_Buffer = '';
	
	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;
	
	QCR_Debug('Scan ' . $l_RootDir);

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
			
			$l_Ext2 = substr(strstr($l_FileName, '.'), 1);
			if (in_array($l_Ext2, $g_IgnoredExt)) {
                           $l_NeedToScan = false;
                        }
			if (getRelativePath($l_FileName) == "./" . INTEGRITY_DB_FILE) $l_NeedToScan = false;

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

				$l_DirCounter++;

				if ($l_DirCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
				{
					$g_Doorway[] = $l_SourceDirIndex;
					$l_DirCounter = -655360;
				}

				$g_Counter++;
				$g_FoundTotalDirs++;

				QCR_IntegrityCheck($l_FileName);

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
					
					$g_Counter++;
				}
			}
			
			if (!$l_NeedToScan) continue;

			if (IMAKE) {
				write_integrity_db_file($l_FileName);
				continue;
			}

			// ICHECK
			// skip if known and not modified.
			if (icheck($l_FileName)) continue;
			
			$l_Buffer .= getRelativePath($l_FileName);
			$l_Buffer .= $l_IsDir ? DIR_SEPARATOR . "\n" : "\n";

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

	if (($l_RootDir == ROOT_PATH)) {
		write_integrity_db_file();
	}

}


function getRelativePath($l_FileName) {
	return "./" . substr($l_FileName, strlen(ROOT_PATH) + 1) . (is_dir($l_FileName) ? DIR_SEPARATOR : '');
}
/**
 *
 * @return true if known and not modified
 */
function icheck($l_FileName) {
	global $g_IntegrityDB, $g_ICheck;
	static $l_Buffer = '';
	static $l_status = array( 'modified' => 'modified', 'added' => 'added' );
    
	$l_RelativePath = getRelativePath($l_FileName);
	$l_known = isset($g_IntegrityDB[$l_RelativePath]);

	if (is_dir($l_FileName)) {
		if ( $l_known ) {
			unset($g_IntegrityDB[$l_RelativePath]);
		} else {
			$g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
		}
		return $l_known;
	}

	if ($l_known == false) {
		$g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
		return false;
	}

	$hash = hash_file('sha256', $l_FileName);
	
	if ($g_IntegrityDB[$l_RelativePath] != $hash) {
		$g_IntegrityDB[$l_RelativePath] =& $l_status['modified'];
		return false;
	}

	unset($g_IntegrityDB[$l_RelativePath]);
	return true;
}

function write_integrity_db_file($l_FileName = '') {
	static $l_Buffer = '';

	if (empty($l_FileName)) {
		empty($l_Buffer) or file_put_contents(INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".INTEGRITY_DB_FILE);
		$l_Buffer = '';
		return;
	}

	$l_RelativePath = getRelativePath($l_FileName);
		
	$hash = is_dir($l_FileName) ? '' : hash_file('sha256', $l_FileName);

	$l_Buffer .= "$l_RelativePath|$hash\n";
	
	if (strlen($l_Buffer) > 32000)
	{
		file_put_contents(INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".INTEGRITY_DB_FILE);
		$l_Buffer = '';
	}
}

function load_integrity_db() {
	global $g_IntegrityDB;
	file_exists(INTEGRITY_DB_FILE) or die('Not found ' . INTEGRITY_DB_FILE);

	$s_file = new SplFileObject(INTEGRITY_DB_FILE);
	$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

	foreach ($s_file as $line) {
		$i = strrpos($line, '|');
		if (!$i) continue;
		$g_IntegrityDB[substr($line, 0, $i)] = substr($line, $i+1);
	}

	$s_file = null;
}
