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
ini_set('memory_limit', '1G');

// put 1 for expert mode, 0 for basic check and 2 for paranoic mode
// установите 1 для режима "Эксперта", 0 для быстрой проверки и 2 для параноидальной проверки (для лечения сайта) 
define('AI_EXPERT_MODE', 2); 

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 
define('PASS', '????????????????????'); 

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

define('SMART_SCAN', 0);

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

$g_SuspiciousFiles = array('cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'susp', 'suspected');
$g_SensitiveFiles = array_merge(array('php', 'js', 'htaccess', 'html', 'htm', 'tpl', 'inc', 'css', 'txt', 'sql'), $g_SuspiciousFiles);
$g_CriticalFiles = array('php', 'htaccess', 'cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'susp', 'suspected', 'infected');
$g_CriticalEntries = '<\?php|<\?=|#!/usr|#!/bin|eval|assert|base64_decode|system|create_function|exec|popen|fwrite|fputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|move|copy|array_|reg_replace|mysql_|chr|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles = array('js', 'html', 'htm', 'suspicious');
$g_VirusEntries = '<\s*script|<\s*iframe|<\s*object|<\s*embed|fromCharCode|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles = array('js', 'html', 'htm', 'suspected', 'php');
$g_PhishEntries = '<\s*title|<\s*html|<\s*form|<\s*body|bank|account';
$g_ShortListExt = array('php', 'php3', 'php4', 'php5', 'html', 'htm', 'phtml', 'shtml', 'khtml');

if (LANG == 'RU') {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RUSSIAN INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('AI_STR_001', 'Отчет сканера <a href="https://revisium.com/ai/">AI-Bolit</a> v@@VERSION@@:');
define('AI_STR_002', 'Обращаем внимание на то, что большинство CMS <b>без дополнительной защиты</b> рано или поздно <b>взламывают</b>.<p> Компания <a href="https://revisium.com/">"Ревизиум"</a> предлагает услугу превентивной защиты сайта от взлома с использованием уникальной <b>процедуры "цементирования сайта"</b>. Подробно на <a href="https://revisium.com/ru/client_protect/">странице услуги</a>. <p>Лучшее лечение &mdash; это профилактика.');
define('AI_STR_003', 'Не оставляйте файл отчета на сервере, и не давайте на него прямых ссылок с других сайтов. Информация из отчета может быть использована злоумышленниками для взлома сайта, так как содержит информацию о настройках сервера, файлах и каталогах.');
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
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Внимание, скрипт выполнил быструю проверку сайта. Проверяются только наиболее критические файлы, но часть вредоносных скриптов может быть не обнаружена. Пожалуйста, запустите скрипт из командной строки для выполнения полного тестирования. Подробнее смотрите в <a href="https://revisium.com/ai/faq.php">FAQ вопрос №10</a>.</div>');
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
define('AI_STR_029', 'Дорвеи, реклама, спам-ссылки, редиректы');
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
define('AI_STR_050', 'Замечания и предложения по работе скрипта и не обнаруженные вредоносные скрипты присылайте на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<p>Также будем чрезвычайно благодарны за любые упоминания скрипта AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. Ссылочку можно поставить на <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>. <p>Если будут вопросы - пишите <a href="mailto:ai@revisium.com">ai@revisium.com</a>. ');
define('AI_STR_051', 'Отчет по ');
define('AI_STR_052', 'Эвристический анализ обнаружил подозрительные файлы. Проверьте их на наличие вредоносного кода.');
define('AI_STR_053', 'Много косвенных вызовов функции');
define('AI_STR_054', 'Подозрение на обфусцированные переменные');
define('AI_STR_055', 'Подозрительное использование массива глобальных переменных');
define('AI_STR_056', 'Дробление строки на символы');
define('AI_STR_057', 'Сканирование выполнено в экспресс-режиме. Многие вредоносные скрипты могут быть не обнаружены.<br> Рекомендуем проверить сайт в режиме "Эксперт" или "Параноидальный". Подробно описано в <a href="https://revisium.com/ai/faq.php">FAQ</a> и инструкции к скрипту.');
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
define('AI_STR_075', 'Скрипт бесплатный только для личного некоммерческого использования. Есть <a href="https://revisium.com/ai/faq.php#faq11" target=_blank>коммерческая лицензия</a> (пункт №11).');

$tmp_str = <<<HTML_FOOTER
   <div class="disclaimer"><span class="vir">[!]</span> Отказ от гарантий: невозможно гарантировать обнаружение всех вредоносных скриптов. Поэтому разработчик сканера не несет ответственности за возможные последствия работы сканера AI-Bolit или неоправданные ожидания пользователей относительно функциональности и возможностей.
   </div>
   <div class="thanx">
      Замечания и предложения по работе скрипта, а также не обнаруженные вредоносные скрипты вы можете присылать на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<br/>
      Также будем чрезвычайно благодарны за любые упоминания сканера AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. <br/>Ссылку можно поставить на страницу <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>.<br/> 
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
define('AI_STR_087', "Изменения в файловой структуре");

$l_Offer =<<<OFFER
    <div>
	 <div class="crit" style="font-size: 17px;"><b>Внимание! Наш сканер обнаружил подозрительный или вредоносный код</b>.</div> 
	 <br/>Скорее всего, ваш сайт был взломан и заражен. Рекомендуем срочно <a href="https://revisium.com/ru/order/" target=_blank>обратиться за консультацией</a> к специалистам по информационной безопасности.
	</div>
	<br/>
	<div>
	   Пришлите нам отчет в архиве .zip на <a href="mailto:ai@revisium.com">ai@revisium.com</a> для проверки вашего сайта на вирусы и взлом.<p>
	   Компания "<a href="https://revisium.com/">Ревизиум</a>" - лечение сайта от вирусов и защита от взлома.
	</div>
	<br/>
	
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
define('AI_STR_029', 'This script has black-SEO links or linkfarm. Check if it was installed by yourself:');
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
define('AI_STR_050', "I'm sincerely appreciate reports for any bugs you may found in the script. Please email me: <a href=\"mailto:audit@revisium.com\">audit@revisium.com</a>.<p> Also I appriciate any reference to the script in your blog or forum posts. Thank you for the link to download page: <a href=\"https://revisium.com/aibo/\">https://revisium.com/aibo/</a>");
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
		      We're greatly appreciate for any references in the social networks, forums or blogs to our scanner AI-BOLIT <a href="https://revisium.com/aibo/">https://revisium.com/aibo/</a>.<br/> 
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
define('AI_STR_087', "Integrity Check Report");

$l_Offer =<<<HTML_OFFER_EN
<div>
 <div class="crit" style="font-size: 17px;"><b>Attention! Malicious software has been detected on the website.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/home/" target=_blank>contact information security specialist</a> or experienced webmaster to clean the malware.
</div>
<br/>
<div>
   <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="https://revisium.com/ru/order/">https://revisium.com</a>
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
	@import "https://revisium.com/extra/media/css/demo_page2.css";
	@import "https://revisium.com/extra/media/css/jquery.dataTables2.css";
</style>

<script type="text/javascript" language="javascript" src="https://yandex.st/jquery/2.1.0/jquery.min.js"></script>
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

.intitem
{
  color:#4a6975;
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

.note_int
{
   margin: 10px 0 10px 0;
   color: #60b5d6;
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

//BEGIN_SIG 24/01/2016 10:13:19
$g_DBShe = unserialize(base64_decode("YTo0MjM6e2k6MDtzOjU6InJhaHVpIjtpOjE7czozNToibW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbPHFxPkYxbDMiO2k6MjtzOjEzOiJCeTxzMT5LeW1Mam5rIjtpOjM7czoxMzoiQnk8czE+U2g0TGluayI7aTo0O3M6MTY6IkJ5PHMxPkFub25Db2RlcnMiO2k6NTtzOjQ2OiIkdXNlckFnZW50cyA9IGFycmF5KCJHb29nbGUiLCAiU2x1cnAiLCAiTVNOQm90IjtpOjY7czo2OiJbM3Jhbl0iO2k6NztzOjEwOiJEYXduX2FuZ2VsIjtpOjg7czo4OiJSM0RUVVhFUyI7aTo5O3M6MjA6InZpc2l0b3JUcmFja2VyX2lzTW9iIjtpOjEwO3M6MjQ6ImNvbV9jb250ZW50L2FydGljbGVkLnBocCI7aToxMTtzOjE3OiI8dGl0bGU+RW1zUHJveHkgdiI7aToxMjtzOjEzOiJhbmRyb2lkLWlncmEtIjtpOjEzO3M6MTU6Ij09PTo6Om1hZDo6Oj09PSI7aToxNDtzOjU6Ikg0eE9yIjtpOjE1O3M6ODoiUjRwSDR4MHIiO2k6MTY7czo4OiJORzY4OVNrdyI7aToxNztzOjExOiJmb3BvLmNvbS5hciI7aToxODtzOjk6IjY0LjY4LjgwLiI7aToxOTtzOjg6IkhhcmNoYUxpIjtpOjIwO3M6MTU6Inh4Ujk5bXVzdmllaTB4MCI7aToyMTtzOjExOiJQLmgucC5TLnAueSI7aToyMjtzOjE0OiJfc2hlbGxfYXRpbGRpXyI7aToyMztzOjk6In4gU2hlbGwgSSI7aToyNDtzOjY6IjB4ZGQ4MiI7aToyNTtzOjE0OiJBbnRpY2hhdCBzaGVsbCI7aToyNjtzOjEyOiJBTEVNaU4gS1JBTGkiO2k6Mjc7czoxNjoiQVNQWCBTaGVsbCBieSBMVCI7aToyODtzOjk6ImFaUmFpTFBoUCI7aToyOTtzOjIyOiJDb2RlZCBCeSBDaGFybGljaGFwbGluIjtpOjMwO3M6NzoiQmwwb2QzciI7aTozMTtzOjEyOiJCWSBpU0tPUlBpVFgiO2k6MzI7czoxMToiZGV2aWx6U2hlbGwiO2k6MzM7czozMDoiV3JpdHRlbiBieSBDYXB0YWluIENydW5jaCBUZWFtIjtpOjM0O3M6OToiYzIwMDcucGhwIjtpOjM1O3M6MjI6IkM5OSBNb2RpZmllZCBCeSBQc3ljaDAiO2k6MzY7czoxNzoiJGM5OXNoX3VwZGF0ZWZ1cmwiO2k6Mzc7czo5OiJDOTkgU2hlbGwiO2k6Mzg7czoyMjoiY29va2llbmFtZSA9ICJ3aWVlZWVlIiI7aTozOTtzOjM4OiJDb2RlZCBieSA6IFN1cGVyLUNyeXN0YWwgYW5kIE1vaGFqZXIyMiI7aTo0MDtzOjEyOiJDcnlzdGFsU2hlbGwiO2k6NDE7czoyMzoiVEVBTSBTQ1JJUFRJTkcgLSBST0ROT0MiO2k6NDI7czoxMToiQ3liZXIgU2hlbGwiO2k6NDM7czo3OiJkMG1haW5zIjtpOjQ0O3M6MTM6IkRhcmtEZXZpbHouaU4iO2k6NDU7czoyNDoiU2hlbGwgd3JpdHRlbiBieSBCbDBvZDNyIjtpOjQ2O3M6MzM6IkRpdmUgU2hlbGwgLSBFbXBlcm9yIEhhY2tpbmcgVGVhbSI7aTo0NztzOjE1OiJEZXZyLWkgTWVmc2VkZXQiO2k6NDg7czozMjoiQ29tYW5kb3MgRXhjbHVzaXZvcyBkbyBEVG9vbCBQcm8iO2k6NDk7czoyMDoiRW1wZXJvciBIYWNraW5nIFRFQU0iO2k6NTA7czoyMDoiRml4ZWQgYnkgQXJ0IE9mIEhhY2siO2k6NTE7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjUyO3M6Mjc6Ikx1dGZlbiBEb3N5YXlpIEFkbGFuZGlyaW5peiI7aTo1MztzOjIyOiJ0aGlzIGlzIGEgcHJpdjMgc2VydmVyIjtpOjU0O3M6MTM6IkdGUyBXZWItU2hlbGwiO2k6NTU7czoxMToiR0hDIE1hbmFnZXIiO2k6NTY7czoxNDoiR29vZzFlX2FuYWxpc3QiO2k6NTc7czoxMzoiR3JpbmF5IEdvMG8kRSI7aTo1ODtzOjI5OiJoNG50dSBzaGVsbCBbcG93ZXJlZCBieSB0c29pXSI7aTo1OTtzOjI1OiJIYWNrZWQgQnkgRGV2ci1pIE1lZnNlZGV0IjtpOjYwO3M6MTc6IkhBQ0tFRCBCWSBSRUFMV0FSIjtpOjYxO3M6MzI6IkhhY2tlcmxlciBWdXJ1ciBMYW1lcmxlciBTdXJ1bnVyIjtpOjYyO3M6MTE6ImlNSGFCaVJMaUdpIjtpOjYzO3M6OToiS0FfdVNoZWxsIjtpOjY0O3M6NzoiTGl6MHppTSI7aTo2NTtzOjExOiJMb2N1czdTaGVsbCI7aTo2NjtzOjM2OiJNb3JvY2NhbiBTcGFtZXJzIE1hLUVkaXRpb04gQnkgR2hPc1QiO2k6Njc7czoxMDoiTWF0YW11IE1hdCI7aTo2ODtzOjUwOiJPcGVuIHRoZSBmaWxlIGF0dGFjaG1lbnQgaWYgYW55LCBhbmQgYmFzZTY0X2VuY29kZSI7aTo2OTtzOjY6Im0wcnRpeCI7aTo3MDtzOjU6Im0waHplIjtpOjcxO3M6MTA6Ik1hdGFtdSBNYXQiO2k6NzI7czoxNjoiTW9yb2NjYW4gU3BhbWVycyI7aTo3MztzOjE1OiIkTXlTaGVsbFZlcnNpb24iO2k6NzQ7czo5OiJNeVNRTCBSU1QiO2k6NzU7czoxOToiTXlTUUwgV2ViIEludGVyZmFjZSI7aTo3NjtzOjI3OiJNeVNRTCBXZWIgSW50ZXJmYWNlIFZlcnNpb24iO2k6Nzc7czoxNDoiTXlTUUwgV2Vic2hlbGwiO2k6Nzg7czo4OiJOM3RzaGVsbCI7aTo3OTtzOjE2OiJIYWNrZWQgYnkgU2lsdmVyIjtpOjgwO3M6NzoiTmVvSGFjayI7aTo4MTtzOjIxOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAiO2k6ODI7czoyMDoiTklYIFJFTU9URSBXRUItU0hFTEwiO2k6ODM7czoyNjoiTyBCaVIgS1JBTCBUQUtMaVQgRURpbEVNRVoiO2k6ODQ7czoxODoiUEhBTlRBU01BLSBOZVcgQ21EIjtpOjg1O3M6MjE6IlBJUkFURVMgQ1JFVyBXQVMgSEVSRSI7aTo4NjtzOjIxOiJhIHNpbXBsZSBwaHAgYmFja2Rvb3IiO2k6ODc7czoyMDoiTE9URlJFRSBQSFAgQmFja2Rvb3IiO2k6ODg7czozMToiTmV3cyBSZW1vdGUgUEhQIFNoZWxsIEluamVjdGlvbiI7aTo4OTtzOjk6IlBIUEphY2thbCI7aTo5MDtzOjIwOiJQSFAgSFZBIFNoZWxsIFNjcmlwdCI7aTo5MTtzOjEzOiJwaHBSZW1vdGVWaWV3IjtpOjkyO3M6MzU6IlBIUCBTaGVsbCBpcyBhbmludGVyYWN0aXZlIFBIUC1wYWdlIjtpOjkzO3M6NjoiUEhWYXl2IjtpOjk0O3M6MjY6IlBQUyAxLjAgcGVybC1jZ2kgd2ViIHNoZWxsIjtpOjk1O3M6MjI6IlByZXNzIE9LIHRvIGVudGVyIHNpdGUiO2k6OTY7czoyMjoicHJpdmF0ZSBTaGVsbCBieSBtNHJjbyI7aTo5NztzOjU6InIwbmluIjtpOjk4O3M6NjoiUjU3U3FsIjtpOjk5O3M6MTM6InI1N3NoZWxsXC5waHAiO2k6MTAwO3M6MTU6InJnb2RgcyB3ZWJzaGVsbCI7aToxMDE7czoyMDoicmVhbGF1dGg9U3ZCRDg1ZElOdTMiO2k6MTAyO3M6MTY6IlJ1MjRQb3N0V2ViU2hlbGwiO2k6MTAzO3M6MjE6IktBZG90IFVuaXZlcnNhbCBTaGVsbCI7aToxMDQ7czoxMDoiQ3JAenlfS2luZyI7aToxMDU7czoyMDoiU2FmZV9Nb2RlIEJ5cGFzcyBQSFAiO2k6MTA2O3M6MTc6IlNhcmFzYU9uIFNlcnZpY2VzIjtpOjEwNztzOjI1OiJTaW1wbGUgUEhQIGJhY2tkb29yIGJ5IERLIjtpOjEwODtzOjE5OiJHLVNlY3VyaXR5IFdlYnNoZWxsIjtpOjEwOTtzOjI1OiJTaW1vcmdoIFNlY3VyaXR5IE1hZ2F6aW5lIjtpOjExMDtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToxMTE7czoxMzoiU1NJIHdlYi1zaGVsbCI7aToxMTI7czoxMToiU3Rvcm03U2hlbGwiO2k6MTEzO3M6OToiVGhlX0JlS2lSIjtpOjExNDtzOjk6IlczRCBTaGVsbCI7aToxMTU7czoxMzoidzRjazFuZyBzaGVsbCI7aToxMTY7czoyODoiZGV2ZWxvcGVkIGJ5IERpZ2l0YWwgT3V0Y2FzdCI7aToxMTc7czozMjoiV2F0Y2ggWW91ciBzeXN0ZW0gU2hhbnkgd2FzIGhlcmUiO2k6MTE4O3M6MTI6IldlYiBTaGVsbCBieSI7aToxMTk7czoxMzoiV1NPMiBXZWJzaGVsbCI7aToxMjA7czozMzoiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIGZvciBjaGFubmVsIjtpOjEyMTtzOjI3OiJTbWFsbCBQSFAgV2ViIFNoZWxsIGJ5IFphQ28iO2k6MTIyO3M6MTA6Ik1ybG9vbC5leGUiO2k6MTIzO3M6NjoiU0VvRE9SIjtpOjEyNDtzOjk6Ik1yLkhpVG1hbiI7aToxMjU7czo1OiJkM2J+WCI7aToxMjY7czoxNjoiQ29ubmVjdEJhY2tTaGVsbCI7aToxMjc7czoxMDoiQlkgTU1OQk9CWiI7aToxMjg7czoyNjoiT0xCOlBST0RVQ1Q6T05MSU5FX0JBTktJTkciO2k6MTI5O3M6MTA6IkMwZGVyei5jb20iO2k6MTMwO3M6NzoiTXJIYXplbSI7aToxMzE7czo5OiJ2MGxkM20wcnQiO2k6MTMyO3M6NjoiSyFMTDNyIjtpOjEzMztzOjEwOiJEci5hYm9sYWxoIjtpOjEzNDtzOjMwOiIkcmFuZF93cml0YWJsZV9mb2xkZXJfZnVsbHBhdGgiO2k6MTM1O3M6ODQ6Ijx0ZXh0YXJlYSBuYW1lPVwicGhwZXZcIiByb3dzPVwiNVwiIGNvbHM9XCIxNTBcIj4iLkAkX1BPU1RbJ3BocGV2J10uIjwvdGV4dGFyZWE+PGJyPiI7aToxMzY7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToxMzc7czo5OiJCeSBQc3ljaDAiO2k6MTM4O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjEzOTtzOjE0OiJ0ZW1wX3I1N190YWJsZSI7aToxNDA7czoxNzoiYWRtaW5Ac3B5Z3J1cC5vcmciO2k6MTQxO3M6NzoiY2FzdXMxNSI7aToxNDI7czoxMzoiV1NDUklQVC5TSEVMTCI7aToxNDM7czo0NzoiRXhlY3V0ZWQgY29tbWFuZDogPGI+PGZvbnQgY29sb3I9I2RjZGNkYz5bJGNtZF0iO2k6MTQ0O3M6MTE6ImN0c2hlbGwucGhwIjtpOjE0NTtzOjE1OiJEWF9IZWFkZXJfZHJhd24iO2k6MTQ2O3M6ODY6ImNybGYuJ3VubGluaygkbmFtZSk7Jy4kY3JsZi4ncmVuYW1lKCJ+Ii4kbmFtZSwgJG5hbWUpOycuJGNybGYuJ3VubGluaygiZ3JwX3JlcGFpci5waHAiIjtpOjE0NztzOjEwNToiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrK2pZRFU5MkM5NGpkdERpZit4T1lqRzZDTGh4MzFVbzl4OS9lQVdnc0JLNjBrSzJtTHdxenFkIjtpOjE0ODtzOjExNToibXB0eSgkX1BPU1RbJ3VyJ10pKSAkbW9kZSB8PSAwNDAwOyBpZiAoIWVtcHR5KCRfUE9TVFsndXcnXSkpICRtb2RlIHw9IDAyMDA7IGlmICghZW1wdHkoJF9QT1NUWyd1eCddKSkgJG1vZGUgfD0gMDEwMCI7aToxNDk7czozNzoia2xhc3ZheXYuYXNwP3llbmlkb3N5YT08JT1ha3RpZmtsYXMlPiI7aToxNTA7czoxMjI6Im50KShkaXNrX3RvdGFsX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgIiAuICJGcmVlIHNwYWNlICIgLiAoaW50KShkaXNrX2ZyZWVfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiA8IjtpOjE1MTtzOjc2OiJhIGhyZWY9Ijw/ZWNobyAiJGZpc3Rpay5waHA/ZGl6aW49JGRpemluLy4uLyI/PiIgc3R5bGU9InRleHQtZGVjb3JhdGlvbjogbm9uIjtpOjE1MjtzOjM4OiJSb290U2hlbGwhJyk7c2VsZi5sb2NhdGlvbi5ocmVmPSdodHRwOiI7aToxNTM7czo5MDoiPCU9UmVxdWVzdC5TZXJ2ZXJWYXJpYWJsZXMoInNjcmlwdF9uYW1lIiklPj9Gb2xkZXJQYXRoPTwlPVNlcnZlci5VUkxQYXRoRW5jb2RlKEZvbGRlci5Ecml2IjtpOjE1NDtzOjE2MDoicHJpbnQoKGlzX3JlYWRhYmxlKCRmKSAmJiBpc193cml0ZWFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIudygxKS5mb250KCdyZWQnLCdSVycsMykpLncoMSk6KCgoaXNfcmVhZGFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIpLncoNCk6IiIpLigoaXNfd3JpdGFibCI7aToxNTU7czoxNjE6IignIicsJyZxdW90OycsJGZuKSkuJyI7ZG9jdW1lbnQubGlzdC5zdWJtaXQoKTtcJz4nLmh0bWxzcGVjaWFsY2hhcnMoc3RybGVuKCRmbik+Zm9ybWF0P3N1YnN0cigkZm4sMCxmb3JtYXQtMykuJy4uLic6JGZuKS4nPC9hPicuc3RyX3JlcGVhdCgnICcsZm9ybWF0LXN0cmxlbigkZm4pIjtpOjE1NjtzOjExOiJ6ZWhpcmhhY2tlciI7aToxNTc7czozOToiSkAhVnJAKiZSSFJ3fkpMdy5HfHhsaG5MSn4/MS5id09ieGJQfCFWIjtpOjE1ODtzOjM5OiJXU09zZXRjb29raWUobWQ1KCRfU0VSVkVSWydIVFRQX0hPU1QnXSkiO2k6MTU5O3M6MTQxOiI8L3RkPjx0ZCBpZD1mYT5bIDxhIHRpdGxlPVwiSG9tZTogJyIuaHRtbHNwZWNpYWxjaGFycyhzdHJfcmVwbGFjZSgiXCIsICRzZXAsIGdldGN3ZCgpKSkuIicuXCIgaWQ9ZmEgaHJlZj1cImphdmFzY3JpcHQ6Vmlld0RpcignIi5yYXd1cmxlbmNvZGUiO2k6MTYwO3M6MTY6IkNvbnRlbnQtVHlwZTogJF8iO2k6MTYxO3M6ODY6Ijxub2JyPjxiPiRjZGlyJGNmaWxlPC9iPiAoIi4kZmlsZVsic2l6ZV9zdHIiXS4iKTwvbm9icj48L3RkPjwvdHI+PGZvcm0gbmFtZT1jdXJyX2ZpbGU+IjtpOjE2MjtzOjQ4OiJ3c29FeCgndGFyIGNmenYgJyAuIGVzY2FwZXNoZWxsYXJnKCRfUE9TVFsncDInXSkiO2k6MTYzO3M6MTQyOiI1amIyMGlLVzl5SUhOMGNtbHpkSElvSkhKbFptVnlaWElzSW1Gd2IzSjBJaWtnYjNJZ2MzUnlhWE4wY2lna2NtVm1aWEpsY2l3aWJtbG5iV0VpS1NCdmNpQnpkSEpwYzNSeUtDUnlaV1psY21WeUxDSjNaV0poYkhSaElpa2diM0lnYzNSeWFYTjBjaWdrIjtpOjE2NDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjE2NTtzOjY1OiJpZiAoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0rKFteO10rKSQnLCAkY29tbWFuZCwgJHJlZ3MpKSI7aToxNjY7czo0Njoicm91bmQoMCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQrOTgzMC40KSk9PSI7aToxNjc7czoxMjoiUEhQU0hFTEwuUEhQIjtpOjE2ODtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToxNjk7czoyMjoicHJpdmF0ZSBTaGVsbCBieSBtNHJjbyI7aToxNzA7czoxMzoidzRjazFuZyBzaGVsbCI7aToxNzE7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjE3MjtzOjQyOiJXb3JrZXJfR2V0UmVwbHlDb2RlKCRvcERhdGFbJ3JlY3ZCdWZmZXInXSkiO2k6MTczO3M6NDA6IiRmaWxlcGF0aD1AcmVhbHBhdGgoJF9QT1NUWydmaWxlcGF0aCddKTsiO2k6MTc0O3M6ODg6IiRyZWRpcmVjdFVSTD0naHR0cDovLycuJHJTaXRlLiRfU0VSVkVSWydSRVFVRVNUX1VSSSddO2lmKGlzc2V0KCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSkiO2k6MTc1O3M6MTc6InJlbmFtZSgid3NvLnBocCIsIjtpOjE3NjtzOjU0OiIkTWVzc2FnZVN1YmplY3QgPSBiYXNlNjRfZGVjb2RlKCRfUE9TVFsibXNnc3ViamVjdCJdKTsiO2k6MTc3O3M6NDQ6ImNvcHkoJF9GSUxFU1t4XVt0bXBfbmFtZV0sJF9GSUxFU1t4XVtuYW1lXSkpIjtpOjE3ODtzOjU4OiJTRUxFQ1QgMSBGUk9NIG15c3FsLnVzZXIgV0hFUkUgY29uY2F0KGB1c2VyYCwgJ0AnLCBgaG9zdGApIjtpOjE3OTtzOjIxOiIhQCRfQ09PS0lFWyRzZXNzZHRfa10iO2k6MTgwO3M6NDg6IiRhPShzdWJzdHIodXJsZW5jb2RlKHByaW50X3IoYXJyYXkoKSwxKSksNSwxKS5jKSI7aToxODE7czo1NjoieGggLXMgIi91c3IvbG9jYWwvYXBhY2hlL3NiaW4vaHR0cGQgLURTU0wiIC4vaHR0cGQgLW0gJDEiO2k6MTgyO3M6MTg6InB3ZCA+IEdlbmVyYXNpLmRpciI7aToxODM7czoxMjoiQlJVVEVGT1JDSU5HIjtpOjE4NDtzOjMxOiJDYXV0YW0gZmlzaWVyZWxlIGRlIGNvbmZpZ3VyYXJlIjtpOjE4NTtzOjMyOiIka2E9Jzw/Ly9CUkUnOyRrYWthPSRrYS4nQUNLLy8/PiI7aToxODY7czo4NToiJHN1Ymo9dXJsZGVjb2RlKCRfR0VUWydzdSddKTskYm9keT11cmxkZWNvZGUoJF9HRVRbJ2JvJ10pOyRzZHM9dXJsZGVjb2RlKCRfR0VUWydzZCddKSI7aToxODc7czozOToiJF9fX189QGd6aW5mbGF0ZSgkX19fXykpe2lmKGlzc2V0KCRfUE9TIjtpOjE4ODtzOjM3OiJwYXNzdGhydShnZXRlbnYoIkhUVFBfQUNDRVBUX0xBTkdVQUdFIjtpOjE4OTtzOjg6IkFzbW9kZXVzIjtpOjE5MDtzOjUwOiJmb3IoOyRwYWRkcj1hY2NlcHQoQ0xJRU5ULCBTRVJWRVIpO2Nsb3NlIENMSUVOVCkgeyI7aToxOTE7czo1OToiJGl6aW5sZXIyPXN1YnN0cihiYXNlX2NvbnZlcnQoQGZpbGVwZXJtcygkZm5hbWUpLDEwLDgpLC00KTsiO2k6MTkyO3M6NDI6IiRiYWNrZG9vci0+Y2NvcHkoJGNmaWNoaWVyLCRjZGVzdGluYXRpb24pOyI7aToxOTM7czoyMzoieyR7cGFzc3RocnUoJGNtZCl9fTxicj4iO2k6MTk0O3M6Mjk6IiRhW2hpdHNdJyk7IFxyXG4jZW5kcXVlcnlcclxuIjtpOjE5NTtzOjI2OiJuY2Z0cHB1dCAtdSAkZnRwX3VzZXJfbmFtZSI7aToxOTY7czozNjoiZXhlY2woIi9iaW4vc2giLCJzaCIsIi1pIiwoY2hhciopMCk7IjtpOjE5NztzOjMxOiI8SFRNTD48SEVBRD48VElUTEU+Y2dpLXNoZWxsLnB5IjtpOjE5ODtzOjM4OiJzeXN0ZW0oInVuc2V0IEhJU1RGSUxFOyB1bnNldCBTQVZFSElTVCI7aToxOTk7czoyMzoiJGxvZ2luPUBwb3NpeF9nZXR1aWQoKTsiO2k6MjAwO3M6NjA6IihlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSokJywgJF9SRVFVRVNUWydjb21tYW5kJ10pKSI7aToyMDE7czoyNToiISRfUkVRVUVTVFsiYzk5c2hfc3VybCJdKSI7aToyMDI7czo1MzoiUG5WbGtXTTYzIUAjQCZkS3h+bk1EV01+RH8vRXNufnh/NkRAI0AmUH5+LD9uWSxXUHtQb2oiO2k6MjAzO3M6MzY6InNoZWxsX2V4ZWMoJF9QT1NUWydjbWQnXSAuICIgMj4mMSIpOyI7aToyMDQ7czozNToiaWYoISR3aG9hbWkpJHdob2FtaT1leGVjKCJ3aG9hbWkiKTsiO2k6MjA1O3M6NjE6IlB5U3lzdGVtU3RhdGUuaW5pdGlhbGl6ZShTeXN0ZW0uZ2V0UHJvcGVydGllcygpLCBudWxsLCBhcmd2KTsiO2k6MjA2O3M6MzY6IjwlPWVudi5xdWVyeUhhc2h0YWJsZSgidXNlci5uYW1lIiklPiI7aToyMDc7czo4MzoiaWYgKGVtcHR5KCRfUE9TVFsnd3NlciddKSkgeyR3c2VyID0gIndob2lzLnJpcGUubmV0Ijt9IGVsc2UgJHdzZXIgPSAkX1BPU1RbJ3dzZXInXTsiO2k6MjA4O3M6OTE6ImlmIChtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1snZmlsYSddWyd0bXBfbmFtZSddLCAkY3VyZGlyLiIvIi4kX0ZJTEVTWydmaWxhJ11bJ25hbWUnXSkpIHsiO2k6MjA5O3M6MjM6InNoZWxsX2V4ZWMoJ3VuYW1lIC1hJyk7IjtpOjIxMDtzOjQ3OiJpZiAoIWRlZmluZWQkcGFyYW17Y21kfSl7JHBhcmFte2NtZH09ImxzIC1sYSJ9OyI7aToyMTE7czo2MDoiaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkkc2hlbGxPdXQ9c3RyaXBzbGFzaGVzKCRzaGVsbE91dCk7IjtpOjIxMjtzOjg0OiI8YSBocmVmPSckUEhQX1NFTEY/YWN0aW9uPXZpZXdTY2hlbWEmZGJuYW1lPSRkYm5hbWUmdGFibGVuYW1lPSR0YWJsZW5hbWUnPlNjaGVtYTwvYT4iO2k6MjEzO3M6NjY6InBhc3N0aHJ1KCAkYmluZGlyLiJteXNxbGR1bXAgLS11c2VyPSRVU0VSTkFNRSAtLXBhc3N3b3JkPSRQQVNTV09SRCI7aToyMTQ7czo2NjoibXlzcWxfcXVlcnkoIkNSRUFURSBUQUJMRSBgeHBsb2l0YCAoYHhwbG9pdGAgTE9OR0JMT0IgTk9UIE5VTEwpIik7IjtpOjIxNTtzOjg3OiIkcmE0NCAgPSByYW5kKDEsOTk5OTkpOyRzajk4ID0gInNoLSRyYTQ0IjskbWwgPSAiJHNkOTgiOyRhNSA9ICRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsiO2k6MjE2O3M6NTI6IiRfRklMRVNbJ3Byb2JlJ11bJ3NpemUnXSwgJF9GSUxFU1sncHJvYmUnXVsndHlwZSddKTsiO2k6MjE3O3M6NzE6InN5c3RlbSgiJGNtZCAxPiAvdG1wL2NtZHRlbXAgMj4mMTsgY2F0IC90bXAvY21kdGVtcDsgcm0gL3RtcC9jbWR0ZW1wIik7IjtpOjIxODtzOjY5OiJ9IGVsc2lmICgkc2VydmFyZyA9fiAvXlw6KC4rPylcISguKz8pXEAoLis/KSBQUklWTVNHICguKz8pIFw6KC4rKS8pIHsiO2k6MjE5O3M6Njk6InNlbmQoU09DSzUsICRtc2csIDAsIHNvY2thZGRyX2luKCRwb3J0YSwgJGlhZGRyKSkgYW5kICRwYWNvdGVze299Kys7OyI7aToyMjA7czoxODoiJGZlKCIkY21kICAyPiYxIik7IjtpOjIyMTtzOjY4OiJ3aGlsZSAoJHJvdyA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXN1bHQsTVlTUUxfQVNTT0MpKSBwcmludF9yKCRyb3cpOyI7aToyMjI7czo1MjoiZWxzZWlmKEBpc193cml0YWJsZSgkRk4pICYmIEBpc19maWxlKCRGTikpICR0bXBPdXRNRiI7aToyMjM7czo3MjoiY29ubmVjdChTT0NLRVQsIHNvY2thZGRyX2luKCRBUkdWWzFdLCBpbmV0X2F0b24oJEFSR1ZbMF0pKSkgb3IgZGllIHByaW50IjtpOjIyNDtzOjg5OiJpZihtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1siZmljIl1bInRtcF9uYW1lIl0sZ29vZF9saW5rKCIuLyIuJF9GSUxFU1siZmljIl1bIm5hbWUiXSkpKSI7aToyMjU7czo4NzoiVU5JT04gU0VMRUNUICcwJyAsICc8PyBzeXN0ZW0oXCRfR0VUW2NwY10pO2V4aXQ7ID8+JyAsMCAsMCAsMCAsMCBJTlRPIE9VVEZJTEUgJyRvdXRmaWxlIjtpOjIyNjtzOjY4OiJpZiAoIUBpc19saW5rKCRmaWxlKSAmJiAoJHIgPSByZWFscGF0aCgkZmlsZSkpICE9IEZBTFNFKSAkZmlsZSA9ICRyOyI7aToyMjc7czoyOToiZWNobyAiRklMRSBVUExPQURFRCBUTyAkZGV6IjsiO2k6MjI4O3M6MjQ6IiRmdW5jdGlvbigkX1BPU1RbJ2NtZCddKSI7aToyMjk7czozODoiJGZpbGVuYW1lID0gJGJhY2t1cHN0cmluZy4iJGZpbGVuYW1lIjsiO2k6MjMwO3M6NDg6ImlmKCcnPT0oJGRmPUBpbmlfZ2V0KCdkaXNhYmxlX2Z1bmN0aW9ucycpKSl7ZWNobyI7aToyMzE7czo0NjoiPCUgRm9yIEVhY2ggVmFycyBJbiBSZXF1ZXN0LlNlcnZlclZhcmlhYmxlcyAlPiI7aToyMzI7czozMzoiaWYgKCRmdW5jYXJnID1+IC9ecG9ydHNjYW4gKC4qKS8pIjtpOjIzMztzOjU1OiIkdXBsb2FkZmlsZSA9ICRycGF0aC4iLyIgLiAkX0ZJTEVTWyd1c2VyZmlsZSddWyduYW1lJ107IjtpOjIzNDtzOjI2OiIkY21kID0gKCRfUkVRVUVTVFsnY21kJ10pOyI7aToyMzU7czozODoiaWYoJGNtZCAhPSAiIikgcHJpbnQgU2hlbGxfRXhlYygkY21kKTsiO2k6MjM2O3M6Mjk6ImlmIChpc19maWxlKCIvdG1wLyRla2luY2kiKSl7IjtpOjIzNztzOjY5OiJfX2FsbF9fID0gWyJTTVRQU2VydmVyIiwiRGVidWdnaW5nU2VydmVyIiwiUHVyZVByb3h5IiwiTWFpbG1hblByb3h5Il0iO2k6MjM4O3M6NTk6Imdsb2JhbCAkbXlzcWxIYW5kbGUsICRkYm5hbWUsICR0YWJsZW5hbWUsICRvbGRfbmFtZSwgJG5hbWUsIjtpOjIzOTtzOjI3OiIyPiYxIDE+JjIiIDogIiAxPiYxIDI+JjEiKTsiO2k6MjQwO3M6NTI6Im1hcCB7IHJlYWRfc2hlbGwoJF8pIH0gKCRzZWxfc2hlbGwtPmNhbl9yZWFkKDAuMDEpKTsiO2k6MjQxO3M6MjI6ImZ3cml0ZSAoJGZwLCAiJHlhemkiKTsiO2k6MjQyO3M6NTE6IlNlbmQgdGhpcyBmaWxlOiA8SU5QVVQgTkFNRT0idXNlcmZpbGUiIFRZUEU9ImZpbGUiPiI7aToyNDM7czo0MjoiJGRiX2QgPSBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSwkY29uMSk7IjtpOjI0NDtzOjY3OiJmb3IgKCR2YWx1ZSkgeyBzLyYvJmFtcDsvZzsgcy88LyZsdDsvZzsgcy8+LyZndDsvZzsgcy8iLyZxdW90Oy9nOyB9IjtpOjI0NTtzOjc0OiJjb3B5KCRfRklMRVNbJ3Vwa2snXVsndG1wX25hbWUnXSwia2svIi5iYXNlbmFtZSgkX0ZJTEVTWyd1cGtrJ11bJ25hbWUnXSkpOyI7aToyNDY7czo4NjoiZnVuY3Rpb24gZ29vZ2xlX2JvdCgpIHskc1VzZXJBZ2VudCA9IHN0cnRvbG93ZXIoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKTtpZighKHN0cnAiO2k6MjQ3O3M6NzU6ImNyZWF0ZV9mdW5jdGlvbigiJiQiLiJmdW5jdGlvbiIsIiQiLiJmdW5jdGlvbiA9IGNocihvcmQoJCIuImZ1bmN0aW9uKS0zKTsiKSI7aToyNDg7czo0NjoibG9uZyBpbnQ6dCgwLDMpPXIoMCwzKTstMjE0NzQ4MzY0ODsyMTQ3NDgzNjQ3OyI7aToyNDk7czo0NjoiP3VybD0nLiRfU0VSVkVSWydIVFRQX0hPU1QnXSkudW5saW5rKFJPT1RfRElSLiI7aToyNTA7czozNjoiY2F0ICR7YmxrbG9nWzJdfSB8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjI1MTtzOjk3OiJAcGF0aDE9KCdhZG1pbi8nLCdhZG1pbmlzdHJhdG9yLycsJ21vZGVyYXRvci8nLCd3ZWJhZG1pbi8nLCdhZG1pbmFyZWEvJywnYmItYWRtaW4vJywnYWRtaW5Mb2dpbi8nIjtpOjI1MjtzOjg3OiIiYWRtaW4xLnBocCIsICJhZG1pbjEuaHRtbCIsICJhZG1pbjIucGhwIiwgImFkbWluMi5odG1sIiwgInlvbmV0aW0ucGhwIiwgInlvbmV0aW0uaHRtbCIiO2k6MjUzO3M6Njg6IlBPU1QgeyRwYXRofXskY29ubmVjdG9yfT9Db21tYW5kPUZpbGVVcGxvYWQmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9IjtpOjI1NDtzOjMwOiJAYXNzZXJ0KCRfUkVRVUVTVFsnUEhQU0VTU0lEJ10iO2k6MjU1O3M6NjE6IiRwcm9kPSJzeSIuInMiLiJ0ZW0iOyRpZD0kcHJvZCgkX1JFUVVFU1RbJ3Byb2R1Y3QnXSk7JHsnaWQnfTsiO2k6MjU2O3M6MTU6InBocCAiLiR3c29fcGF0aCI7aToyNTc7czo3NzoiJEZjaG1vZCwkRmRhdGEsJE9wdGlvbnMsJEFjdGlvbiwkaGRkYWxsLCRoZGRmcmVlLCRoZGRwcm9jLCR1bmFtZSwkaWRkKTpzaGFyZWQiO2k6MjU4O3M6NTE6InNlcnZlci48L3A+XHJcbjwvYm9keT48L2h0bWw+IjtleGl0O31pZihwcmVnX21hdGNoKCI7aToyNTk7czo5NToiJGZpbGUgPSAkX0ZJTEVTWyJmaWxlbmFtZSJdWyJuYW1lIl07IGVjaG8gIjxhIGhyZWY9XCIkZmlsZVwiPiRmaWxlPC9hPiI7fSBlbHNlIHtlY2hvKCJlbXB0eSIpO30iO2k6MjYwO3M6NjA6IkZTX2Noa19mdW5jX2xpYmM9KCAkKHJlYWRlbGYgLXMgJEZTX2xpYmMgfCBncmVwIF9jaGtAQCB8IGF3ayI7aToyNjE7czo0MDoiZmluZCAvIC1uYW1lIC5zc2ggPiAkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyNjI7czozMzoicmUuZmluZGFsbChkaXJ0KycoLiopJyxwcm9nbm0pWzBdIjtpOjI2MztzOjYwOiJvdXRzdHIgKz0gc3RyaW5nLkZvcm1hdCgiPGEgaHJlZj0nP2ZkaXI9ezB9Jz57MX0vPC9hPiZuYnNwOyIiO2k6MjY0O3M6ODM6IjwlPVJlcXVlc3QuU2VydmVydmFyaWFibGVzKCJTQ1JJUFRfTkFNRSIpJT4/dHh0cGF0aD08JT1SZXF1ZXN0LlF1ZXJ5U3RyaW5nKCJ0eHRwYXRoIjtpOjI2NTtzOjcxOiJSZXNwb25zZS5Xcml0ZShTZXJ2ZXIuSHRtbEVuY29kZSh0aGlzLkV4ZWN1dGVDb21tYW5kKHR4dENvbW1hbmQuVGV4dCkpKSI7aToyNjY7czoxMTE6Im5ldyBGaWxlU3RyZWFtKFBhdGguQ29tYmluZShmaWxlSW5mby5EaXJlY3RvcnlOYW1lLCBQYXRoLkdldEZpbGVOYW1lKGh0dHBQb3N0ZWRGaWxlLkZpbGVOYW1lKSksIEZpbGVNb2RlLkNyZWF0ZSI7aToyNjc7czo5MDoiUmVzcG9uc2UuV3JpdGUoIjxicj4oICkgPGEgaHJlZj0/dHlwZT0xJmZpbGU9IiAmIHNlcnZlci5VUkxlbmNvZGUoaXRlbS5wYXRoKSAmICJcPiIgJiBpdGVtIjtpOjI2ODtzOjEwNDoic3FsQ29tbWFuZC5QYXJhbWV0ZXJzLkFkZCgoKFRhYmxlQ2VsbClkYXRhR3JpZEl0ZW0uQ29udHJvbHNbMF0pLlRleHQsIFNxbERiVHlwZS5EZWNpbWFsKS5WYWx1ZSA9IGRlY2ltYWwiO2k6MjY5O3M6NjQ6IjwlPSAiXCIgJiBvU2NyaXB0TmV0LkNvbXB1dGVyTmFtZSAmICJcIiAmIG9TY3JpcHROZXQuVXNlck5hbWUgJT4iO2k6MjcwO3M6NTA6ImN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICJodHRwOi8vJGhvc3Q6MjA4MiIpIjtpOjI3MTtzOjU4OiJISjNIanV0Y2tvUmZwWGY5QTF6UU8yQXdEUnJSZXk5dUd2VGVlejc5cUFhbzFhMHJndWRrWmtSOFJhIjtpOjI3MjtzOjMxOiIkaW5pWyd1c2VycyddID0gYXJyYXkoJ3Jvb3QnID0+IjtpOjI3MztzOjE4OiJwcm9jX29wZW4oJ0lIU3RlYW0iO2k6Mjc0O3M6MjQ6IiRiYXNsaWs9JF9QT1NUWydiYXNsaWsnXSI7aToyNzU7czozMDoiZnJlYWQoJGZwLCBmaWxlc2l6ZSgkZmljaGVybykpIjtpOjI3NjtzOjM5OiJJL2djWi92WDBBMTBERFJEZzdFemsvZCszKzhxdnFxUzFLMCtBWFkiO2k6Mjc3O3M6MTY6InskX1BPU1RbJ3Jvb3QnXX0iO2k6Mjc4O3M6Mjk6In1lbHNlaWYoJF9HRVRbJ3BhZ2UnXT09J2Rkb3MnIjtpOjI3OTtzOjE0OiJUaGUgRGFyayBSYXZlciI7aToyODA7czozOToiJHZhbHVlID1+IHMvJSguLikvcGFjaygnYycsaGV4KCQxKSkvZWc7IjtpOjI4MTtzOjExOiJ3d3cudDBzLm9yZyI7aToyODI7czozMDoidW5sZXNzKG9wZW4oUEZELCRnX3VwbG9hZF9kYikpIjtpOjI4MztzOjEyOiJhejg4cGl4MDBxOTgiO2k6Mjg0O3M6MTE6InNoIGdvICQxLiR4IjtpOjI4NTtzOjI2OiJzeXN0ZW0oInBocCAtZiB4cGwgJGhvc3QiKSI7aToyODY7czoxMzoiZXhwbG9pdGNvb2tpZSI7aToyODc7czoyMToiODAgLWIgJDEgLWkgZXRoMCAtcyA4IjtpOjI4ODtzOjI1OiJIVFRQIGZsb29kIGNvbXBsZXRlIGFmdGVyIjtpOjI4OTtzOjE1OiJOSUdHRVJTLk5JR0dFUlMiO2k6MjkwO3M6NDc6ImlmKGlzc2V0KCRfR0VUWydob3N0J10pJiZpc3NldCgkX0dFVFsndGltZSddKSl7IjtpOjI5MTtzOjgzOiJzdWJwcm9jZXNzLlBvcGVuKGNtZCwgc2hlbGwgPSBUcnVlLCBzdGRvdXQ9c3VicHJvY2Vzcy5QSVBFLCBzdGRlcnI9c3VicHJvY2Vzcy5TVERPVSI7aToyOTI7czo2OToiZGVmIGRhZW1vbihzdGRpbj0nL2Rldi9udWxsJywgc3Rkb3V0PScvZGV2L251bGwnLCBzdGRlcnI9Jy9kZXYvbnVsbCcpIjtpOjI5MztzOjY3OiJwcmludCgiWyFdIEhvc3Q6ICIgKyBob3N0bmFtZSArICIgbWlnaHQgYmUgZG93biFcblshXSBSZXNwb25zZSBDb2RlIjtpOjI5NDtzOjQyOiJjb25uZWN0aW9uLnNlbmQoInNoZWxsICIrc3RyKG9zLmdldGN3ZCgpKSsiO2k6Mjk1O3M6NTA6Im9zLnN5c3RlbSgnZWNobyBhbGlhcyBscz0iLmxzLmJhc2giID4+IH4vLmJhc2hyYycpIjtpOjI5NjtzOjMyOiJydWxlX3JlcSA9IHJhd19pbnB1dCgiU291cmNlRmlyZSI7aToyOTc7czo1NzoiYXJncGFyc2UuQXJndW1lbnRQYXJzZXIoZGVzY3JpcHRpb249aGVscCwgcHJvZz0ic2N0dW5uZWwiIjtpOjI5ODtzOjU3OiJzdWJwcm9jZXNzLlBvcGVuKCclc2dkYiAtcCAlZCAtYmF0Y2ggJXMnICUgKGdkYl9wcmVmaXgsIHAiO2k6Mjk5O3M6NTk6IiRmcmFtZXdvcmsucGx1Z2lucy5sb2FkKCIje3JwY3R5cGUuZG93bmNhc2V9cnBjIiwgb3B0cykucnVuIjtpOjMwMDtzOjI4OiJpZiBzZWxmLmhhc2hfdHlwZSA9PSAncHdkdW1wIjtpOjMwMTtzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aTozMDI7czo0NToiYWRkX2ZpbHRlcigndGhlX2NvbnRlbnQnLCAnX2Jsb2dpbmZvJywgMTAwMDEpIjtpOjMwMztzOjk6IjxzdGRsaWIuaCI7aTozMDQ7czo1OToiZWNobyB5IDsgc2xlZXAgMSA7IH0gfCB7IHdoaWxlIHJlYWQgOyBkbyBlY2hvIHokUkVQTFk7IGRvbmUiO2k6MzA1O3M6MTE6IlZPQlJBIEdBTkdPIjtpOjMwNjtzOjc2OiJpbnQzMigoKCR6ID4+IDUgJiAweDA3ZmZmZmZmKSBeICR5IDw8IDIpICsgKCgkeSA+PiAzICYgMHgxZmZmZmZmZikgXiAkeiA8PCA0IjtpOjMwNztzOjY5OiJAY29weSgkX0ZJTEVTW2ZpbGVNYXNzXVt0bXBfbmFtZV0sJF9QT1NUW3BhdGhdLiRfRklMRVNbZmlsZU1hc3NdW25hbWUiO2k6MzA4O3M6NDY6ImZpbmRfZGlycygkZ3JhbmRwYXJlbnRfZGlyLCAkbGV2ZWwsIDEsICRkaXJzKTsiO2k6MzA5O3M6Mjg6IkBzZXRjb29raWUoImhpdCIsIDEsIHRpbWUoKSsiO2k6MzEwO3M6NToiZS8qLi8iO2k6MzExO3M6Mzc6IkpIWnBjMmwwWTI5MWJuUWdQU0FrU0ZSVVVGOURUMDlMU1VWZlYiO2k6MzEyO3M6MzU6IjBkMGEwZDBhNjc2YzZmNjI2MTZjMjAyNDZkNzk1ZjczNmQ3IjtpOjMxMztzOjE5OiJmb3BlbignL2V0Yy9wYXNzd2QnIjtpOjMxNDtzOjc2OiIkdHN1MltyYW5kKDAsY291bnQoJHRzdTIpIC0gMSldLiR0c3UxW3JhbmQoMCxjb3VudCgkdHN1MSkgLSAxKV0uJHRzdTJbcmFuZCgwIjtpOjMxNTtzOjMzOiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGQgLURTU0wiO2k6MzE2O3M6MjA6InNldCBwcm90ZWN0LXRlbG5ldCAwIjtpOjMxNztzOjI3OiJheXUgcHIxIHByMiBwcjMgcHI0IHByNSBwcjYiO2k6MzE4O3M6MzA6ImJpbmQgZmlsdCAtICJcMDAxQUNUSU9OICpcMDAxIiI7aTozMTk7czo1MDoicmVnc3ViIC1hbGwgLS0gLCBbc3RyaW5nIHRvbG93ZXIgJG93bmVyXSAiIiBvd25lcnMiO2k6MzIwO3M6MzU6ImtpbGwgLUNITEQgXCRib3RwaWQgPi9kZXYvbnVsbCAyPiYxIjtpOjMyMTtzOjEwOiJiaW5kIGRjYyAtIjtpOjMyMjtzOjI0OiJyNGFUYy5kUG50RS9menRTRjFiSDNSSDAiO2k6MzIzO3M6MTM6InByaXZtc2cgJGNoYW4iO2k6MzI0O3M6MjI6ImJpbmQgam9pbiAtICogZ29wX2pvaW4iO2k6MzI1O3M6NDM6InNldCBnb29nbGUoZGF0YSkgW2h0dHA6OmRhdGEgJGdvb2dsZShwYWdlKV0iO2k6MzI2O3M6MjY6InByb2MgaHR0cDo6Q29ubmVjdCB7dG9rZW59IjtpOjMyNztzOjEzOiJwcml2bXNnICRuaWNrIjtpOjMyODtzOjExOiJwdXRib3QgJGJvdCI7aTozMjk7czoxMjoidW5iaW5kIFJBVyAtIjtpOjMzMDtzOjI5OiItLURDQ0RJUiBbbGluZGV4ICRVc2VyKCRpKSAyXSI7aTozMzE7czoxMDoiQ3liZXN0ZXI5MCI7aTozMzI7czo0MToiZmlsZV9nZXRfY29udGVudHModHJpbSgkZlskX0dFVFsnaWQnXV0pKTsiO2k6MzMzO3M6MjE6InVubGluaygkd3JpdGFibGVfZGlycyI7aTozMzQ7czoyNzoiYmFzZTY0X2RlY29kZSgkY29kZV9zY3JpcHQpIjtpOjMzNTtzOjIxOiJsdWNpZmZlckBsdWNpZmZlci5vcmciO2k6MzM2O3M6NDg6IiR0aGlzLT5GLT5HZXRDb250cm9sbGVyKCRfU0VSVkVSWydSRVFVRVNUX1VSSSddKSI7aTozMzc7czo0NzoiJHRpbWVfc3RhcnRlZC4kc2VjdXJlX3Nlc3Npb25fdXNlci5zZXNzaW9uX2lkKCkiO2k6MzM4O3M6NzQ6IiRwYXJhbSB4ICRuLnN1YnN0ciAoJHBhcmFtLCBsZW5ndGgoJHBhcmFtKSAtIGxlbmd0aCgkY29kZSklbGVuZ3RoKCRwYXJhbSkpIjtpOjMzOTtzOjM2OiJmd3JpdGUoJGYsZ2V0X2Rvd25sb2FkKCRfR0VUWyd1cmwnXSkiO2k6MzQwO3M6NjU6Imh0dHA6Ly8nLiRfU0VSVkVSWydIVFRQX0hPU1QnXS51cmxkZWNvZGUoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjM0MTtzOjgwOiJ3cF9wb3N0cyBXSEVSRSBwb3N0X3R5cGUgPSAncG9zdCcgQU5EIHBvc3Rfc3RhdHVzID0gJ3B1Ymxpc2gnIE9SREVSIEJZIGBJRGAgREVTQyI7aTozNDI7czozNzoiJHVybCA9ICR1cmxzW3JhbmQoMCwgY291bnQoJHVybHMpLTEpXSI7aTozNDM7czo0NzoicHJlZ19tYXRjaCgnLyg/PD1SZXdyaXRlUnVsZSkuKig/PVxbTFwsUlw9MzAyXF0iO2k6MzQ0O3M6NDU6InByZWdfbWF0Y2goJyFNSURQfFdBUHxXaW5kb3dzLkNFfFBQQ3xTZXJpZXM2MCI7aTozNDU7czo2MDoiUjBsR09EbGhFd0FRQUxNQUFBQUFBUC8vLzV5Y0FNN09ZLy8vblAvL3p2L09uUGYzOS8vLy93QUFBQUFBIjtpOjM0NjtzOjY1OiJzdHJfcm90MTMoJGJhc2VhWygkZGltZW5zaW9uKiRkaW1lbnNpb24tMSkgLSAoJGkqJGRpbWVuc2lvbiskaildKSI7aTozNDc7czo3NToiaWYoZW1wdHkoJF9HRVRbJ3ppcCddKSBhbmQgZW1wdHkoJF9HRVRbJ2Rvd25sb2FkJ10pICYgZW1wdHkoJF9HRVRbJ2ltZyddKSl7IjtpOjM0ODtzOjE2OiJNYWRlIGJ5IERlbG9yZWFuIjtpOjM0OTtzOjQ2OiJvdmVyZmxvdy15OnNjcm9sbDtcIj4iLiRsaW5rcy4kaHRtbF9tZlsnYm9keSddIjtpOjM1MDtzOjQzOiJmdW5jdGlvbiB1cmxHZXRDb250ZW50cygkdXJsLCAkdGltZW91dCA9IDUpIjtpOjM1MTtzOjY6ImQzbGV0ZSI7aTozNTI7czoxNToibGV0YWtzZWthcmFuZygpIjtpOjM1MztzOjg6IllFTkkzRVJJIjtpOjM1NDtzOjIxOiIkT09PMDAwMDAwPXVybGRlY29kZSgiO2k6MzU1O3M6MjA6Ii1JL3Vzci9sb2NhbC9iYW5kbWluIjtpOjM1NjtzOjM3OiJmd3JpdGUoJGZwc2V0diwgZ2V0ZW52KCJIVFRQX0NPT0tJRSIpIjtpOjM1NztzOjI1OiJpc3NldCgkX1BPU1RbJ2V4ZWNnYXRlJ10pIjtpOjM1ODtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6MzU5O3M6MTQ6Ij09ICJiaW5kc2hlbGwiIjtpOjM2MDtzOjg6IlBhc2hrZWxhIjtpOjM2MTtzOjI1OiJjcmVhdGVGaWxlc0ZvcklucHV0T3V0cHV0IjtpOjM2MjtzOjY6Ik00bGwzciI7aTozNjM7czoyMDoiX19WSUVXU1RBVEVFTkNSWVBURUQiO2k6MzY0O3M6NzoiT29OX0JveSI7aTozNjU7czoxMzoiUmVhTF9QdU5pU2hFciI7aTozNjY7czo4OiJkYXJrbWlueiI7aTozNjc7czo1OiJaZWQweCI7aTozNjg7czo0MDoiYWJhY2hvfGFiaXpkaXJlY3Rvcnl8YWJvdXR8YWNvb258YWxleGFuYSI7aTozNjk7czozNjoicHBjfG1pZHB8d2luZG93cyBjZXxtdGt8ajJtZXxzeW1iaWFuIjtpOjM3MDtzOjQ3OiJAY2hyKCgkaFskZVskb11dPDw0KSsoJGhbJGVbKyskb11dKSk7fX1ldmFsKCRkKSI7aTozNzE7czoxMToiJHNoM2xsQ29sb3IiO2k6MzcyO3M6MTA6IlB1bmtlcjJCb3QiO2k6MzczO3M6MTg6Ijw/cGhwIGVjaG8gIiMhISMiOyI7aTozNzQ7czo3NToiJGltPXN1YnN0cigkaW0sMCwkaSkuc3Vic3RyKCRpbSwkaTIrMSwkaTQtKCRpMisxKSkuc3Vic3RyKCRpbSwkaTQrMTIsc3RybGVuIjtpOjM3NTtzOjU1OiIoJGluZGF0YSwkYjY0PTEpe2lmKCRiNjQ9PTEpeyRjZD1iYXNlNjRfZGVjb2RlKCRpbmRhdGEpIjtpOjM3NjtzOjE3OiIoJF9QT1NUWyJkaXIiXSkpOyI7aTozNzc7czoxNzoiSGFja2VkIEJ5IEVuRExlU3MiO2k6Mzc4O3M6MTA6ImFuZGV4fG9vZ2wiO2k6Mzc5O3M6MTA6Im5kcm9pfGh0Y18iO2k6MzgwO3M6MTA6Ijxkb3Q+SXJJc1QiO2k6MzgxO3M6MjE6IjdQMXRkK05XbGlhSS9oV2taNFZYOSI7aTozODI7czoxNToiTmluamFWaXJ1cyBIZXJlIjtpOjM4MztzOjMyOiIkaW09c3Vic3RyKCR0eCwkcCsyLCRwMi0oJHArMikpOyI7aTozODQ7czo2OiIzeHAxcjMiO2k6Mzg1O3M6MjA6IiRtZDU9bWQ1KCIkcmFuZG9tIik7IjtpOjM4NjtzOjI4OiJvVGF0OEQzRHNFOCcmfmhVMDZDQ0g1OyRnWVNxIjtpOjM4NztzOjEyOiJHSUY4OUE7PD9waHAiO2k6Mzg4O3M6MTU6IkNyZWF0ZWQgQnkgRU1NQSI7aTozODk7czozNDoiUGFzc3dvcmQ6PHM+Ii4kX1BPU1RbPHE+cGFzc3dkPHE+XSI7aTozOTA7czoxNToiTmV0QGRkcmVzcyBNYWlsIjtpOjM5MTtzOjI0OiIkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6MzkyO3M6MTE6IkJhYnlfRHJha29uIjtpOjM5MztzOjMwOiJmd3JpdGUoZm9wZW4oZGlybmFtZShfX0ZJTEVfXykiO2k6Mzk0O3M6MTM6Il1dKSk7fX1ldmFsKCQiO2k6Mzk1O3M6Mjc6ImVyZWdfcmVwbGFjZSg8cT4mZW1haWwmPHE+LCI7aTozOTY7czoxOToiKTsgJGkrKykkcmV0Lj1jaHIoJCI7aTozOTc7czo1NzoiJHBhcmFtMm1hc2suIilcPVtcPHFxPlwiXSguKj8pKD89W1w8cXE+XCJdIClbXDxxcT5cIl0vc2llIjtpOjM5ODtzOjk6Ii8vcmFzdGEvLyI7aTozOTk7czoyMDoiPCEtLUNPT0tJRSBVUERBVEUtLT4iO2k6NDAwO3M6MTM6InByb2ZleG9yLmhlbGwiO2k6NDAxO3M6MTM6Ik1hZ2VsYW5nQ3liZXIiO2k6NDAyO3M6ODoiWk9CVUdURUwiO2k6NDAzO3M6MjE6ImRhdGE6dGV4dC9odG1sO2Jhc2U2NCI7aTo0MDQ7czo4OiJTX11AX15VXiI7aTo0MDU7czoxMzoiQCRfUE9TVFsoY2hyKCI7aTo0MDY7czoxMjoiWmVyb0RheUV4aWxlIjtpOjQwNztzOjEyOiJTdWx0YW5IYWlrYWwiO2k6NDA4O3M6MTE6IkNvdXBkZWdyYWNlIjtpOjQwOTtzOjk6ImFydGlja2xlQCI7aTo0MTA7czoxNToiZ25pdHJvcGVyX3JvcnJlIjtpOjQxMTtzOjIzOiJjdXR0ZXJbYXRdcmVhbC54YWtlcC5ydSI7aTo0MTI7czoyOToiaWYoJHdwX193cD1AZ3ppbmZsYXRlKCR3cF9fd3AiO2k6NDEzO3M6NjoicjAwbml4IjtpOjQxNDtzOjIxOiIkZnVsbF9wYXRoX3RvX2Rvb3J3YXkiO2k6NDE1O3M6MzA6IjxiPkRvbmUgPT0+ICR1c2VyZmlsZV9uYW1lPC9iPiI7aTo0MTY7czoxMjoiPkRhcmsgU2hlbGw8IjtpOjQxNztzOjE1OiIvLi4vKi9pbmRleC5waHAiO2k6NDE4O3M6MzI6ImlmKGlzX3VwbG9hZGVkX2ZpbGUvKjsqLygkX0ZJTEVTIjtpOjQxOTtzOjIzOiJleGVjKCRjb21tYW5kLCAkb3V0cHV0KSI7aTo0MjA7czoyMDoiQGluY2x1ZGVfb25jZSgnL3RtcC8iO2k6NDIxO3M6ODE6InRyaW0oJ2h0dHA6Ly8nLiRzYy48cXE+P0NvbW1hbmQ9R2V0Rm9sZGVyc0FuZEZpbGVzJlR5cGU9RmlsZSZDdXJyZW50Rm9sZGVyPSUyRiUwMCI7aTo0MjI7czo1OToiJHNjcmlwdF9maW5kID0gc3RyX3JlcGxhY2UoImxvYWRlciIsICJmaW5kIiwgJHNjcmlwdF9sb2FkZXIiO30="));
$gX_DBShe = unserialize(base64_decode("YTo2Mzp7aTowO3M6ODoiRmlsZXNNYW4iO2k6MTtzOjc6ImRlZmFjZXIiO2k6MjtzOjI0OiJZb3UgY2FuIHB1dCBhIG1kNSBzdHJpbmciO2k6MztzOjg6InBocHNoZWxsIjtpOjQ7czo2MjoiPGRpdiBjbGFzcz0iYmxvY2sgYnR5cGUxIj48ZGl2IGNsYXNzPSJkdG9wIj48ZGl2IGNsYXNzPSJkYnRtIj4iO2k6NTtzOjg6ImM5OXNoZWxsIjtpOjY7czo4OiJyNTdzaGVsbCI7aTo3O3M6NzoiTlREYWRkeSI7aTo4O3M6ODoiY2loc2hlbGwiO2k6OTtzOjc6IkZ4Yzk5c2giO2k6MTA7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjExO3M6MTE6ImRldmlselNoZWxsIjtpOjEyO3M6MjU6IkhhY2tlZCBieSBBbGZhYmV0b1ZpcnR1YWwiO2k6MTM7czo4OiJOM3RzaGVsbCI7aToxNDtzOjExOiJTdG9ybTdTaGVsbCI7aToxNTtzOjExOiJMb2N1czdTaGVsbCI7aToxNjtzOjEyOiJyNTdzaGVsbC5waHAiO2k6MTc7czo5OiJhbnRpc2hlbGwiO2k6MTg7czo5OiJyb290c2hlbGwiO2k6MTk7czoxMToibXlzaGVsbGV4ZWMiO2k6MjA7czo4OiJTaGVsbCBPayI7aToyMTtzOjE0OiJleGVjKCJybSAtciAtZiI7aToyMjtzOjE4OiJOZSB1ZGFsb3MgemFncnV6aXQiO2k6MjM7czo1MToiJG1lc3NhZ2UgPSBlcmVnX3JlcGxhY2UoIiU1QyUyMiIsICIlMjIiLCAkbWVzc2FnZSk7IjtpOjI0O3M6MTk6InByaW50ICJTcGFtZWQnPjxicj4iO2k6MjU7czo0MDoic2V0Y29va2llKCAibXlzcWxfd2ViX2FkbWluX3VzZXJuYW1lIiApOyI7aToyNjtzOjM3OiJlbHNlaWYoZnVuY3Rpb25fZXhpc3RzKCJzaGVsbF9leGVjIikpIjtpOjI3O3M6NTk6ImlmIChpc19jYWxsYWJsZSgiZXhlYyIpIGFuZCAhaW5fYXJyYXkoImV4ZWMiLCRkaXNhYmxlZnVuYykpIjtpOjI4O3M6MzQ6ImlmICgoJHBlcm1zICYgMHhDMDAwKSA9PSAweEMwMDApIHsiO2k6Mjk7czoxMDoiZGlyIC9PRyAvWCI7aTozMDtzOjM2OiJpbmNsdWRlKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSkiO2k6MzE7czo3OiJicjB3czNyIjtpOjMyO3M6NDk6IidodHRwZC5jb25mJywndmhvc3RzLmNvbmYnLCdjZmcucGhwJywnY29uZmlnLnBocCciO2k6MzM7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aTozNDtzOjIzOiJldmFsKGZpbGVfZ2V0X2NvbnRlbnRzKCI7aTozNTtzOjE4OiJpc193cml0YWJsZSgiL3Zhci8iO2k6MzY7czoxNDoiJEdMT0JBTFNbJ19fX18iO2k6Mzc7czo1NToiaXNfY2FsbGFibGUoJ2V4ZWMnKSBhbmQgIWluX2FycmF5KCdleGVjJywgJGRpc2FibGVmdW5jcyI7aTozODtzOjY6ImswZC5jYyI7aTozOTtzOjI2OiJnbWFpbC1zbXRwLWluLmwuZ29vZ2xlLmNvbSI7aTo0MDtzOjc6IndlYnIwMHQiO2k6NDE7czoxMToiRGV2aWxIYWNrZXIiO2k6NDI7czo3OiJEZWZhY2VyIjtpOjQzO3M6MTE6IlsgUGhwcm94eSBdIjtpOjQ0O3M6ODoiW2NvZGVyel0iO2k6NDU7czozMjoiPCEtLSNleGVjIGNtZD0iJEhUVFBfQUNDRVBUIiAtLT4iO2k6NDY7czoxMjoiXVtyb3VuZCgwKV0oIjtpOjQ3O3M6MTE6IlNpbUF0dGFja2VyIjtpOjQ4O3M6MTU6IkRhcmtDcmV3RnJpZW5kcyI7aTo0OTtzOjc6ImsybGwzM2QiO2k6NTA7czo3OiJLa0sxMzM3IjtpOjUxO3M6MTU6IkhBQ0tFRCBCWSBTVE9STSI7aTo1MjtzOjE0OiJNZXhpY2FuSGFja2VycyI7aTo1MztzOjE1OiJNci5TaGluY2hhblgxOTYiO2k6NTQ7czo5OiJEZWlkYXJhflgiO2k6NTU7czoxMDoiSmlucGFudG9teiI7aTo1NjtzOjk6IjFuNzNjdDEwbiI7aTo1NztzOjE0OiJLaW5nU2tydXBlbGxvcyI7aTo1ODtzOjEwOiJKaW5wYW50b216IjtpOjU5O3M6OToiQ2VuZ2l6SGFuIjtpOjYwO3M6OToicjN2M25nNG5zIjtpOjYxO3M6OToiQkxBQ0tVTklYIjtpOjYyO3M6OToiYXJ0aWNrbGVAIjt9"));
$g_FlexDBShe = unserialize(base64_decode("YToyODI6e2k6MDtzOjEwMDoiSU86OlNvY2tldDo6SU5FVC0+bmV3XChQcm90b1xzKj0+XHMqInRjcCJccyosXHMqTG9jYWxQb3J0XHMqPT5ccyozNjAwMFxzKixccypMaXN0ZW5ccyo9PlxzKlNPTUFYQ09OTiI7aToxO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjM7czoxMToiYnlccytHcmluYXkiO2k6NDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjU7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjY7czozNToiZGVmYXVsdF9hY3Rpb25ccyo9XHMqXFxbJyJdRmlsZXNNYW4iO2k6NztzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6ODtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6OTtzOjc0OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX0hPU1RbJyJdXHMqXF1ccypcKSI7aToxMDtzOjEwNzoid3NvRXhccypcKFxzKlxcWyciXVxzKnRhclxzKmNmenZccypcXFsnIl1ccypcLlxzKmVzY2FwZXNoZWxsYXJnXHMqXChccypcJF9QT1NUXFtccypcXFsnIl1wMlxcWyciXVxzKlxdXHMqXCkiO2k6MTE7czo0MDoiZXZhbFxzKlwoKlxzKmJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyI7aToxMjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MTM7czo3NDoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXWZpbGVwYXRoWyciXVxzKlxdXHMqXCkiO2k6MTQ7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MTU7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToxNjtzOjg3OiJTRUxFQ1RccysxXHMrRlJPTVxzK215c3FsXC51c2VyXHMrV0hFUkVccytjb25jYXRcKFxzKmB1c2VyYFxzKixccyonQCdccyosXHMqYGhvc3RgXHMqXCkiO2k6MTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTg7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxOTtzOjU1OiJ7XHMqXCRccyp7XHMqcGFzc3RocnVccypcKCpccypcJGNtZFxzKlwpXHMqfVxzKn1ccyo8YnI+IjtpOjIwO3M6ODI6InJ1bmNvbW1hbmRccypcKFxzKlsnIl1zaGVsbGhlbHBbJyJdXHMqLFxzKlsnIl0oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl0iO2k6MjE7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyMjtzOjM3OiJcJGxvZ2luXHMqPVxzKkAqcG9zaXhfZ2V0dWlkXCgqXHMqXCkqIjtpOjIzO3M6NDk6IiFAKlwkX1JFUVVFU1RccypcW1xzKlsnIl1jOTlzaF9zdXJsWyciXVxzKlxdXHMqXCkiO2k6MjQ7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6MjU7czoxNDM6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1cJGNtZFxzKzE+XHMqL3RtcC9jbWR0ZW1wXHMrMj4mMTtccypjYXRccysvdG1wL2NtZHRlbXA7XHMqcm1ccysvdG1wL2NtZHRlbXBbJyJdXCk7IjtpOjI2O3M6Mjg6IlwkZmVcKFsnIl1cJGNtZFxzKzI+JjFbJyJdXCkiO2k6Mjc7czo5NjoiXCRmdW5jdGlvblxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfWNtZFsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjI4O3M6OTM6IlwkY21kXHMqPVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccypcKSI7aToyOTtzOjEwOiJldmExXHcrU2lyIjtpOjMwO3M6ODg6IlwkaW5pXHMqXFtccypbJyJdezAsMX11c2Vyc1snIl17MCwxfVxzKlxdXHMqPVxzKmFycmF5XHMqXChccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqPT4iO2k6MzE7czozMzoicHJvY19vcGVuXHMqXChccypbJyJdezAsMX1JSFN0ZWFtIjtpOjMyO3M6MTM1OiJbJyJdezAsMX1odHRwZFwuY29uZlsnIl17MCwxfVxzKixccypbJyJdezAsMX12aG9zdHNcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9Y2ZnXC5waHBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9Y29uZmlnXC5waHBbJyJdezAsMX0iO2k6MzM7czo4MToiXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1yb290WyciXXswLDF9XHMqXF1ccyp9IjtpOjM0O3M6NDY6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqL2VbJyJdezAsMX0iO2k6MzU7czozNjoiZXZhbFxzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqIjtpOjM2O3M6NzQ6IkAqc2V0Y29va2llXHMqXCgqXHMqWyciXXswLDF9aGl0WyciXXswLDF9LFxzKjFccyosXHMqdGltZVxzKlwoKlxzKlwpKlxzKlwrIjtpOjM3O3M6NDE6ImV2YWxccypcKCpAKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKkAqXCRfIjtpOjM4O3M6NTk6ImV2YWxccypcKCpAKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFxzKlwoKlxzKkAqXCRfIjtpOjM5O3M6NDM6ImZvcGVuXHMqXCgqXHMqWyciXXswLDF9L2V0Yy9wYXNzd2RbJyJdezAsMX0iO2k6NDA7czoyNDoiXCRHTE9CQUxTXFtbJyJdezAsMX1fX19fIjtpOjQxO3M6MjE3OiJpc19jYWxsYWJsZVxzKlwoKlxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1cKSpccythbmRccyshaW5fYXJyYXlccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjQyO3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjQzO3M6MTM2OiJ3cF9wb3N0c1xzK1dIRVJFXHMrcG9zdF90eXBlXHMqPVxzKlsnIl17MCwxfXBvc3RbJyJdezAsMX1ccytBTkRccytwb3N0X3N0YXR1c1xzKj1ccypbJyJdezAsMX1wdWJsaXNoWyciXXswLDF9XHMrT1JERVJccytCWVxzK2BJRGBccytERVNDIjtpOjQ0O3M6MjA6ImV4ZWNccypcKFxzKlsnIl1pcGZ3IjtpOjQ1O3M6NDI6InN0cnJldlwoKlxzKlsnIl17MCwxfXRyZXNzYVsnIl17MCwxfVxzKlwpKiI7aTo0NjtzOjQ5OiJzdHJyZXZcKCpccypbJyJdezAsMX1lZG9jZWRfNDZlc2FiWyciXXswLDF9XHMqXCkqIjtpOjQ3O3M6NzA6ImZ1bmN0aW9uXHMrdXJsR2V0Q29udGVudHNccypcKCpccypcJHVybFxzKixccypcJHRpbWVvdXRccyo9XHMqXGQrXHMqXCkiO2k6NDg7czo3MToiZndyaXRlXHMqXCgqXHMqXCRmcHNldHZccyosXHMqZ2V0ZW52XHMqXChccypbJyJdSFRUUF9DT09LSUVbJyJdXHMqXClccyoiO2k6NDk7czo2NjoiaXNzZXRccypcKCpccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1leGVjZ2F0ZVsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjUwO3M6MjAwOiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9PFw/IHN5c3RlbVwoXFxcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbY3BjXF1cKTtleGl0O1xzKlw/PlsnIl17MCwxfVxzKixccyowXHMqLDBccyosXHMqMFxzKixccyowXHMrSU5UT1xzK09VVEZJTEVccytbJyJdezAsMX1cJFsnIl17MCwxfSI7aTo1MTtzOjE0OToiXCRHTE9CQUxTXFtbJyJdezAsMX0uKz9bJyJdezAsMX1cXT1BcnJheVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXClccyosXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXCkiO2k6NTI7czo3MzoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCpcWy4rP1xdXD8vZVsnIl17MCwxfVxzKixccypzdHJfcmVwbGFjZSI7aTo1MztzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6NTQ7czoxMTU6IlwkYmVlY29kZVxzKj1AKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqWyciXXswLDF9XHMqXCR1cmxwdXJzXHMqWyciXXswLDF9XCkqXHMqO1xzKmVjaG9ccytbJyJdezAsMX1cJGJlZWNvZGVbJyJdezAsMX0iO2k6NTU7czo3OToiXCR4XGQrXHMqPVxzKlsnIl0uKz9bJyJdXHMqO1xzKlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXSI7aTo1NjtzOjQzOiI8XD9waHBccytcJF9GXHMqPVxzKl9fRklMRV9fXHMqO1xzKlwkX1hccyo9IjtpOjU3O3M6Njg6ImlmXHMrXCgqXHMqbWFpbFxzKlwoXHMqXCRyZWNwXHMqLFxzKlwkc3VialxzKixccypcJHN0dW50XHMqLFxzKlwkZnJtIjtpOjU4O3M6MTM5OiJpZlxzK1woXHMqc3RycG9zXHMqXChccypcJHVybFxzKixccypbJyJdanMvbW9vdG9vbHNcLmpzWyciXVxzKlwpXHMqPT09XHMqZmFsc2VccysmJlxzK3N0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL2NhcHRpb25cLmpzWyciXXswLDF9IjtpOjU5O3M6ODE6ImV2YWxccypcKCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BcKCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo2MDtzOjIyMToiaWZccypcKCpccyppc3NldFxzKlwoKlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1cdytbJyJdezAsMX1ccypcXVxzKlwpKlxzKlwpXHMqe1xzKlwkXHcrXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1cdytbJyJdezAsMX1ccypcXTtccypldmFsXHMqXCgqXHMqXCRcdytccypcKSoiO2k6NjE7czoxMjM6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cXlwod3d3XHxmdHBcKVxcXC4vaVsnIl1ccyosXHMqWyciXVsnIl0sXHMqQFwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XHMqXF1ccypcKSI7aTo2MjtzOjEwMToiaWZccypcKCFmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZFsnIl1ccypcKVxzKiYmXHMqIWluX2FycmF5XHMqXChccypbJyJdcG9zaXhfZ2V0cHd1aWQiO2k6NjM7czo4ODoiPVxzKnByZWdfc3BsaXRccypcKFxzKlsnIl0vXFwsXChcXCBcK1wpXD8vWyciXSxccypAKmluaV9nZXRccypcKFxzKlsnIl1kaXNhYmxlX2Z1bmN0aW9ucyI7aTo2NDtzOjQ3OiJcJGJccypcLlxzKlwkcFxzKlwuXHMqXCRoXHMqXC5ccypcJGtccypcLlxzKlwkdiI7aTo2NTtzOjIzOiJcKFxzKlsnIl1JTlNIRUxMWyciXVxzKiI7aTo2NjtzOjU0OiIoR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXV9fX1snIl1ccyoiO2k6Njc7czo5NDoiYXJyYXlfcG9wXHMqXCgqXHMqXCR3b3JrUmVwbGFjZVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKixccypcJGNvdW50S2V5c05ldyI7aTo2ODtzOjM1OiJpZlxzKlwoKlxzKkAqcHJlZ19tYXRjaFxzKlwoKlxzKnN0ciI7aTo2OTtzOjQzOiJAXCRfQ09PS0lFXFtbJyJdezAsMX1zdGF0Q291bnRlclsnIl17MCwxfVxdIjtpOjcwO3M6MTA1OiJmb3BlblxzKlwoKlxzKlsnIl1odHRwOi8vWyciXVxzKlwuXHMqXCRjaGVja19kb21haW5ccypcLlxzKlsnIl06ODBbJyJdXHMqXC5ccypcJGNoZWNrX2RvY1xzKixccypbJyJdclsnIl0iO2k6NzE7czo1NToiQCpnemluZmxhdGVccypcKFxzKkAqYmFzZTY0X2RlY29kZVxzKlwoXHMqQCpzdHJfcmVwbGFjZSI7aTo3MjtzOjI4OiJmaWxlX3B1dF9jb250ZW50elxzKlwoKlxzKlwkIjtpOjczO3M6ODc6IiYmXHMqZnVuY3Rpb25fZXhpc3RzXHMqXCgqXHMqWyciXXswLDF9Z2V0bXhyclsnIl17MCwxfVwpXHMqXClccyp7XHMqQGdldG14cnJccypcKCpccypcJCI7aTo3NDtzOjQxOiJcJHBvc3RSZXN1bHRccyo9XHMqY3VybF9leGVjXHMqXCgqXHMqXCRjaCI7aTo3NTtzOjI1OiJmdW5jdGlvblxzK3NxbDJfc2FmZVxzKlwoIjtpOjc2O3M6ODU6ImV4aXRccypcKFxzKlsnIl17MCwxfTxzY3JpcHQ+XHMqc2V0VGltZW91dFxzKlwoXHMqXFxbJyJdezAsMX1kb2N1bWVudFwubG9jYXRpb25cLmhyZWYiO2k6Nzc7czozODoiZXZhbFwoXHMqc3RyaXBzbGFzaGVzXChccypcXFwkX1JFUVVFU1QiO2k6Nzg7czozNjoiIXRvdWNoXChbJyJdezAsMX1cLlwuL1wuXC4vbGFuZ3VhZ2UvIjtpOjc5O3M6MTA6IkRjMFJIYVsnIl0iO2k6ODA7czo2MDoiaGVhZGVyXHMqXChbJyJdTG9jYXRpb246XHMqWyciXVxzKlwuXHMqXCR0b1xzKlwuXHMqdXJsZGVjb2RlIjtpOjgxO3M6MTU2OiJpZlxzKlwoXHMqc3RyaXBvc1xzKlwoXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXVxzKixccypbJyJdezAsMX1BbmRyb2lkWyciXXswLDF9XClccyohPT1mYWxzZVxzKiYmXHMqIVwkX0NPT0tJRVxbWyciXXswLDF9ZGxlX3VzZXJfaWQiO2k6ODI7czozODoiZWNob1xzK0BmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRnZXQiO2k6ODM7czo0NzoiZGVmYXVsdF9hY3Rpb25ccyo9XHMqWyciXXswLDF9RmlsZXNNYW5bJyJdezAsMX0iO2k6ODQ7czozMzoiZGVmaW5lXHMqXChccypbJyJdREVGQ0FMTEJBQ0tNQUlMIjtpOjg1O3M6MTc6Ik15c3RlcmlvdXNccytXaXJlIjtpOjg2O3M6MzQ6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl0vXC5cKy9lc2kiO2k6ODc7czo0NToiZGVmaW5lXHMqXCgqXHMqWyciXVNCQ0lEX1JFUVVFU1RfRklMRVsnIl1ccyosIjtpOjg4O3M6NjA6IlwkdGxkXHMqPVxzKmFycmF5XHMqXChccypbJyJdY29tWyciXSxbJyJdb3JnWyciXSxbJyJdbmV0WyciXSI7aTo4OTtzOjE3OiJCcmF6aWxccytIYWNrVGVhbSI7aTo5MDtzOjE0NToiaWZcKCFlbXB0eVwoXCRfRklMRVNcW1snIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1cXVxbWyciXXswLDF9bmFtZVsnIl17MCwxfVxdXClccytBTkRccytcKG1kNVwoXCRfUE9TVFxbWyciXXswLDF9bmlja1snIl17MCwxfVxdXClccyo9PVxzKlsnIl17MCwxfSI7aTo5MTtzOjc1OiJ0aW1lXChcKVxzKlwrXHMqMTAwMDBccyosXHMqWyciXS9bJyJdXCk7XHMqZWNob1xzK1wkbV96ejtccypldmFsXHMqXChcJG1fenoiO2k6OTI7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6OTM7czo2Nzoic2V0X3RpbWVfbGltaXRccypcKFxzKjBccypcKTtccyppZlxzKlwoIVNlY3JldFBhZ2VIYW5kbGVyOjpjaGVja0tleSI7aTo5NDtzOjczOiJAaGVhZGVyXChbJyJdTG9jYXRpb246XHMqWyciXVwuWyciXWhbJyJdXC5bJyJddFsnIl1cLlsnIl10WyciXVwuWyciXXBbJyJdIjtpOjk1O3M6OToiSXJTZWNUZWFtIjtpOjk2O3M6OTc6IlwkckJ1ZmZMZW5ccyo9XHMqb3JkXHMqXChccypWQ19EZWNyeXB0XHMqXChccypmcmVhZFxzKlwoXHMqXCRpbnB1dCxccyoxXHMqXClccypcKVxzKlwpXHMqXCpccyoyNTYiO2k6OTc7czo3NDoiY2xlYXJzdGF0Y2FjaGVcKFxzKlwpO1xzKmlmXHMqXChccyohaXNfZGlyXHMqXChccypcJGZsZFxzKlwpXHMqXClccypyZXR1cm4iO2k6OTg7czo5NzoiY29udGVudD1bJyJdezAsMX1uby1jYWNoZVsnIl17MCwxfTtccypcJGNvbmZpZ1xbWyciXXswLDF9ZGVzY3JpcHRpb25bJyJdezAsMX1cXVxzKlwuPVxzKlsnIl17MCwxfSI7aTo5OTtzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTAwO3M6NzA6ImZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqXHMqQURNSU5fUkVESVJfVVJMXHMqLFxzKmZhbHNlXHMqLFxzKlwkY3R4XHMqXCkiO2k6MTAxO3M6ODc6ImlmXHMqXChccypcJGlccyo8XHMqXChccypjb3VudFxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cVsnIl17MCwxfVxzKlxdXHMqXClccyotXHMqMSI7aToxMDI7czoyMzI6Imlzc2V0XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqaXNfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmNvcHlccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF0iO2k6MTAzO3M6ODI6IlwkVVJMXHMqPVxzKlwkdXJsc1xbXHMqcmFuZFwoXHMqMFxzKixccypjb3VudFxzKlwoXHMqXCR1cmxzXHMqXClccyotXHMqMVxzKlwpXHMqXF0iO2k6MTA0O3M6MjEzOiJAKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJHNlY3VyaXR5X2NvZGVccypcLlxzKiIvIlxzKlwuXHMqXCRfRklMRVNcW1snIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1cXVxbWyciXXswLDF9bmFtZVsnIl17MCwxfVxdXCkiO2k6MTA1O3M6Mzk6ImV2YWxccypcKCpccypzdHJyZXZccypcKCpccypzdHJfcmVwbGFjZSI7aToxMDY7czo4MToiXCRyZXM9bXlzcWxfcXVlcnlcKFsnIl17MCwxfVNFTEVDVFxzK1wqXHMrRlJPTVxzK2B3YXRjaGRvZ19vbGRfMDVgXHMrV0hFUkVccytwYWdlIjtpOjEwNztzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTA4O3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjEwOTtzOjM4OiJmY2xvc2VcKFwkZlwpO1xzKmVjaG9ccypbJyJdb1wua1wuWyciXSI7aToxMTA7czo0MToiZnVuY3Rpb25ccytpbmplY3RcKFwkZmlsZSxccypcJGluamVjdGlvbj0iO2k6MTExO3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjExMjtzOjQzOiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwXHMrLWxzIjtpOjExMztzOjQ0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccyoncGNudGxfZm9yayI7aToxMTQ7czo2NToidXJsZW5jb2RlXChwcmludF9yXChhcnJheVwoXCksMVwpXCksNSwxXClcLmNcKSxcJGNcKTt9ZXZhbFwoXCRkXCkiO2k6MTE1O3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjExNjtzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTE3O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjExODtzOjgzOiJpZlxzKlwoXHMqXCRkYXRhU2l6ZVxzKjxccypCT1RDUllQVF9NQVhfU0laRVxzKlwpXHMqcmM0XHMqXChccypcJGRhdGEsXHMqXCRjcnlwdGtleSI7aToxMTk7czo5MDoiLFxzKmFycmF5XHMqXCgnXC4nLCdcLlwuJywnVGh1bWJzXC5kYidcKVxzKlwpXHMqXClccyp7XHMqY29udGludWU7XHMqfVxzKmlmXHMqXChccyppc19maWxlIjtpOjEyMDtzOjUxOiJcKVxzKlwuXHMqc3Vic3RyXHMqXChccyptZDVccypcKFxzKnN0cnJldlxzKlwoXHMqXCQiO2k6MTIxO3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTIyO3M6MTU6IlsnIl1lL1wqXC4vWyciXSI7aToxMjM7czo1MjoiZWNob1snIl17MCwxfTxjZW50ZXI+PGI+RG9uZVxzKj09PlxzKlwkdXNlcmZpbGVfbmFtZSI7aToxMjQ7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEyNTtzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMjY7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEyNztzOjM0OiJ1cmw9PFw/cGhwXHMqZWNob1xzKlwkcmFuZF91cmw7XD8+IjtpOjEyODtzOjI3OiJlY2hvXHMqWyciXWFuc3dlcj1lcnJvclsnIl0iO2k6MTI5O3M6MzI6IlwkcG9zdFxzKj1ccypbJyJdXFx4NzdcXHg2N1xceDY1IjtpOjEzMDtzOjQ2OiJpZlxzKlwoZGV0ZWN0X21vYmlsZV9kZXZpY2VcKFwpXClccyp7XHMqaGVhZGVyIjtpOjEzMTtzOjk6IklySXNUXC5JciI7aToxMzI7czo4OToiXCRsZXR0ZXJccyo9XHMqc3RyX3JlcGxhY2VccypcKFxzKlwkQVJSQVlcWzBcXVxbXCRqXF1ccyosXHMqXCRhcnJcW1wkaW5kXF1ccyosXHMqXCRsZXR0ZXIiO2k6MTMzO3M6OTI6ImNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqWyciXVwkbVsnIl1ccyosXHMqWyciXWlmXHMqXChccypcJG1ccypcW1xzKjB4MDFccypcXVxzKj09XHMqWyciXUxbJyJdIjtpOjEzNDtzOjcyOiJcJHBccyo9XHMqc3RycG9zXChcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTM1O3M6MTEyOiJcJHVzZXJfYWdlbnRccyo9XHMqcHJlZ19yZXBsYWNlXHMqXChccypbJyJdXHxVc2VyXFxcLkFnZW50XFw6XFtcXHMgXF1cP1x8aVsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCR1c2VyX2FnZW50IjtpOjEzNjtzOjMxOiJwcmludFwoIlwjXHMraW5mb1xzK09LXFxuXFxuIlwpIjtpOjEzNztzOjUxOiJcXVxzKn1ccyo9XHMqdHJpbVxzKlwoXHMqYXJyYXlfcG9wXHMqXChccypcJHtccypcJHsiO2k6MTM4O3M6NjQ6IlxdPVsnIl17MCwxfWlwWyciXXswLDF9XHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfU0VSVkVSXFsiO2k6MTM5O3M6MzQ6InByaW50XHMqXCRzb2NrICJQUklWTVNHICJcLlwkb3duZXIiO2k6MTQwO3M6NjM6ImlmXCgvXF5cXDpcJG93bmVyIVwuXCpcXEBcLlwqUFJJVk1TR1wuXCo6XC5tc2dmbG9vZFwoXC5cKlwpL1wpeyI7aToxNDE7czoyNjoiXFstXF1ccytDb25uZWN0aW9uXHMrZmFpbGQiO2k6MTQyO3M6NTQ6IjwhLS1cI2V4ZWNccytjbWQ9WyciXXswLDF9XCRIVFRQX0FDQ0VQVFsnIl17MCwxfVxzKi0tPiI7aToxNDM7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjE0NDtzOjk5OiJpZlxzKlwoXHMqaXNfZGlyXHMqXChccypcJEZ1bGxQYXRoXHMqXClccypcKVxzKkFsbERpclxzKlwoXHMqXCRGdWxsUGF0aFxzKixccypcJEZpbGVzXHMqXCk7XHMqfVxzKn0iO2k6MTQ1O3M6Nzg6IlwkcFxzKj1ccypzdHJwb3NccypcKFxzKlwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxNDY7czoxMjM6InByZWdfbWF0Y2hfYWxsXChbJyJdezAsMX0vPGEgaHJlZj0iXFwvdXJsXFxcP3E9XChcLlwrXD9cKVxbJlx8IlxdXCsvaXNbJyJdezAsMX0sIFwkcGFnZVxbWyciXXswLDF9ZXhlWyciXXswLDF9XF0sIFwkbGlua3NcKSI7aToxNDc7czo4MDoiXCR1cmxccyo9XHMqXCR1cmxccypcLlxzKlsnIl17MCwxfVw/WyciXXswLDF9XHMqXC5ccypodHRwX2J1aWxkX3F1ZXJ5XChcJHF1ZXJ5XCkiO2k6MTQ4O3M6ODM6InByaW50XHMrXCRzb2NrXHMrWyciXXswLDF9TklDSyBbJyJdezAsMX1ccytcLlxzK1wkbmlja1xzK1wuXHMrWyciXXswLDF9XFxuWyciXXswLDF9IjtpOjE0OTtzOjMyOiJQUklWTVNHXC5cKjpcLm93bmVyXFxzXCtcKFwuXCpcKSI7aToxNTA7czo3NToiXCRyZXN1bHRGVUxccyo9XHMqc3RyaXBjc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9cmVzdWx0RlVMWyciXXswLDF9IjtpOjE1MTtzOjEzMDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVx3K1snIl17MCwxfVxdXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHcrWyciXXswLDF9XF1ccypcKSI7aToxNTI7czo2MDoiaWZccypcKFxzKkAqbWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE1MztzOjk0OiJlY2hvXHMrZmlsZV9nZXRfY29udGVudHNccypcKFxzKmJhc2U2NF91cmxfZGVjb2RlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1NDtzOjg0OiJmd3JpdGVccypcKFxzKlwkZmhccyosXHMqc3RyaXBzbGFzaGVzXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTU1O3M6ODM6ImlmXHMqXChccyptYWlsXHMqXChccypcJG1haWxzXFtcJGlcXVxzKixccypcJHRlbWFccyosXHMqYmFzZTY0X2VuY29kZVxzKlwoXHMqXCR0ZXh0IjtpOjE1NjtzOjYyOiJcJGd6aXBccyo9XHMqQCpnemluZmxhdGVccypcKFxzKkAqc3Vic3RyXHMqXChccypcJGd6ZW5jb2RlX2FyZyI7aToxNTc7czo3MzoibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyciXXswLDF9ZWxpZlsnIl17MCwxfVxdXFtbJyJdezAsMX10bXBfbmFtZSI7aToxNTg7czo4MDoiaGVhZGVyXChbJyJdezAsMX1zOlxzKlsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXHMqXChccypbJyJdezAsMX1uWyciXXswLDF9XHMqXCkiO2k6MTU5O3M6MTI6IkJ5XHMrV2ViUm9vVCI7aToxNjA7czo1NzoiXCRPT08wTzBPMDA9X19GSUxFX187XHMqXCRPTzAwTzAwMDBccyo9XHMqMHgxYjU0MDtccypldmFsIjtpOjE2MTtzOjUyOiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxdIjtpOjE2MjtzOjc3OiJwcmVnX21hdGNoXChbJyJdL1woeWFuZGV4XHxnb29nbGVcfGJvdFwpL2lbJyJdLFxzKmdldGVudlwoWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxNjM7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6MTY0O3M6NDI6ImZzb2Nrb3BlblxzKlwoXHMqXCRDb25uZWN0QWRkcmVzc1xzKixccyoyNSI7aToxNjU7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aToxNjY7czo2MzoiXCR1cmxbJyJdezAsMX1ccypcLlxzKlwkc2Vzc2lvbl9pZFxzKlwuXHMqWyciXXswLDF9L2xvZ2luXC5odG1sIjtpOjE2NztzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aToxNjg7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNjk7czozMzoiZGllXHMqXChccypQSFBfT1NccypcLlxzKmNoclxzKlwoIjtpOjE3MDtzOjE5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChbJyJdWyciXVxzKixccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpIjtpOjE3MTtzOjgwOiJcJGhlYWRlcnNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWhlYWRlcnNbJyJdezAsMX1cXSI7aToxNzI7czo4NjoiZmlsZV9wdXRfY29udGVudHNccypcKFsnIl17MCwxfTFcLnR4dFsnIl17MCwxfVxzKixccypwcmludF9yXHMqXChccypcJF9QT1NUXHMqLFxzKnRydWUiO2k6MTczO3M6MzU6ImZ3cml0ZVxzKlwoXHMqXCRmbHdccyosXHMqXCRmbFxzKlwpIjtpOjE3NDtzOjM4OiJcJHN5c19wYXJhbXNccyo9XHMqQCpmaWxlX2dldF9jb250ZW50cyI7aToxNzU7czo1MToiXCRhbGxlbWFpbHNccyo9XHMqQHNwbGl0XCgiXFxuIlxzKixccypcJGVtYWlsbGlzdFwpIjtpOjE3NjtzOjUwOiJmaWxlX3B1dF9jb250ZW50c1woU1ZDX1NFTEZccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aToxNzc7czo1NzoiY3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxccypcJG9wdFxbMVxdXHMqXC5ccypcJG9wdFxbNFxdIjtpOjE3ODtzOjk1OiI8c2NyaXB0XHMrdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccytzcmM9WyciXXswLDF9anF1ZXJ5LXVcLmpzWyciXXswLDF9Pjwvc2NyaXB0PiI7aToxNzk7czoyODoiVVJMPTxcP2VjaG9ccytcJGluZGV4O1xzK1w/PiI7aToxODA7czoyMzoiXCNccypzZWN1cml0eXNwYWNlXC5jb20iO2k6MTgxO3M6MTg6IlwjXHMqc3RlYWx0aFxzKmJvdCI7aToxODI7czoyMToiQXBwbGVccytTcEFtXHMrUmVadWxUIjtpOjE4MztzOjUyOiJpc193cml0YWJsZVwoXCRkaXJcLlsnIl13cC1pbmNsdWRlcy92ZXJzaW9uXC5waHBbJyJdIjtpOjE4NDtzOjQyOiJpZlwoZW1wdHlcKFwkX0NPT0tJRVxbWyciXXhbJyJdXF1cKVwpe2VjaG8iO2k6MTg1O3M6Mjk6IlwpXF07fWlmXChpc3NldFwoXCRfU0VSVkVSXFtfIjtpOjE4NjtzOjY2OiJpZlwoQFwkdmFyc1woZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXHMqXD9ccypzdHJpcHNsYXNoZXNcKFwkdXJpXCkiO2k6MTg3O3M6MzM6ImJhc2VbJyJdezAsMX1cLlwoXGQrXHMqXCpccypcZCtcKSI7aToxODg7czo3NToiXCRwYXJhbVxzKj1ccypcJHBhcmFtXHMqeFxzKlwkblwuc3Vic3RyXHMqXChcJHBhcmFtXHMqLFxzKmxlbmd0aFwoXCRwYXJhbVwpIjtpOjE4OTtzOjUzOiJyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblwoXHMqWyciXXswLDF9cmVhZF9hbnNfY29kZSI7aToxOTA7czozNToiYmFzZTY0X2RlY29kZVwoXCRfUE9TVFxbWyciXXswLDF9Xy0iO2k6MTkxO3M6NTQ6ImlmXChpc3NldFwoXCRfUE9TVFxbWyciXXswLDF9bXNnc3ViamVjdFsnIl17MCwxfVxdXClcKSI7aToxOTI7czoxMzM6Im1haWxcKFwkYXJyXFtbJyJdezAsMX10b1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1zdWJqWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfW1zZ1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1oZWFkWyciXXswLDF9XF1cKTsiO2k6MTkzO3M6Mzg6ImZpbGVfZ2V0X2NvbnRlbnRzXCh0cmltXChcJGZcW1wkX0dFVFxbIjtpOjE5NDtzOjYwOiJpbmlfZ2V0XChbJyJdezAsMX1maWx0ZXJcLmRlZmF1bHRfZmxhZ3NbJyJdezAsMX1cKVwpe2ZvcmVhY2giO2k6MTk1O3M6NTA6ImNodW5rX3NwbGl0XChiYXNlNjRfZW5jb2RlXChmcmVhZFwoXCR7XCR7WyciXXswLDF9IjtpOjE5NjtzOjUyOiJcJHN0cj1bJyJdezAsMX08aDE+NDAzXHMrRm9yYmlkZGVuPC9oMT48IS0tXHMqdG9rZW46IjtpOjE5NztzOjMzOiI8XD9waHBccytyZW5hbWVcKFsnIl13c29cLnBocFsnIl0iO2k6MTk4O3M6NDQ6IlwkXHcrL1wqLnsxLDEwfVwqL1xzKlwuXHMqXCRcdysvXCouezEsMTB9XCovIjtpOjE5OTtzOjUxOiJAKm1haWxcKFwkbW9zQ29uZmlnX21haWxmcm9tLCBcJG1vc0NvbmZpZ19saXZlX3NpdGUiO2k6MjAwO3M6OTU6IlwkdD1cJHM7XHMqXCRvXHMqPVxzKlsnIl1bJyJdO1xzKmZvclwoXCRpPTA7XCRpPHN0cmxlblwoXCR0XCk7XCRpXCtcK1wpe1xzKlwkb1xzKlwuPVxzKlwkdHtcJGl9IjtpOjIwMTtzOjQ3OiJtbWNyeXB0XChcJGRhdGEsIFwka2V5LCBcJGl2LCBcJGRlY3J5cHQgPSBGQUxTRSI7aToyMDI7czoxNToidG5lZ2FfcmVzdV9wdHRoIjtpOjIwMztzOjk6InRzb2hfcHR0aCI7aToyMDQ7czoxMjoiUkVSRUZFUl9QVFRIIjtpOjIwNTtzOjMxOiJ3ZWJpXC5ydS93ZWJpX2ZpbGVzL3BocF9saWJtYWlsIjtpOjIwNjtzOjQwOiJzdWJzdHJfY291bnRcKGdldGVudlwoXFxbJyJdSFRUUF9SRUZFUkVSIjtpOjIwNztzOjM3OiJmdW5jdGlvbiByZWxvYWRcKFwpe2hlYWRlclwoIkxvY2F0aW9uIjtpOjIwODtzOjI1OiJpbWcgc3JjPVsnIl1vcGVyYTAwMFwucG5nIjtpOjIwOTtzOjQ2OiJlY2hvXHMqbWQ1XChcJF9QT1NUXFtbJyJdezAsMX1jaGVja1snIl17MCwxfVxdIjtpOjIxMDtzOjMzOiJlVmFMXChccyp0cmltXChccypiYVNlNjRfZGVDb0RlXCgiO2k6MjExO3M6NDI6ImZzb2Nrb3BlblwoXCRtXFswXF0sXCRtXFsxMFxdLFwkXyxcJF9fLFwkbSI7aToyMTI7czoxOToiWyciXT0+XCR7XCR7WyciXVxceCI7aToyMTM7czozODoicHJlZ19yZXBsYWNlXChbJyJdLlVURlxcLTg6XCguXCpcKS5Vc2UiO2k6MjE0O3M6MzA6Ijo6WyciXVwucGhwdmVyc2lvblwoXClcLlsnIl06OiI7aToyMTU7czo0MDoiQHN0cmVhbV9zb2NrZXRfY2xpZW50XChbJyJdezAsMX10Y3A6Ly9cJCI7aToyMTY7czoxODoiPT0wXCl7anNvblF1aXRcKFwkIjtpOjIxNztzOjQ2OiJsb2Nccyo9XHMqWyciXXswLDF9PFw/ZWNob1xzK1wkcmVkaXJlY3Q7XHMqXD8+IjtpOjIxODtzOjI4OiJhcnJheVwoXCRlbixcJGVzLFwkZWYsXCRlbFwpIjtpOjIxOTtzOjM3OiJbJyJdezAsMX0uYy5bJyJdezAsMX1cLnN1YnN0clwoXCR2YmcsIjtpOjIyMDtzOjE4OiJmdWNrXHMreW91clxzK21hbWEiO2k6MjIxO3M6Nzg6ImNhbGxfdXNlcl9mdW5jXChccypbJyJdYWN0aW9uWyciXVxzKlwuXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyMjI7czo1OToic3RyX3JlcGxhY2VcKFwkZmluZFxzKixccypcJGZpbmRccypcLlxzKlwkaHRtbFxzKixccypcJHRleHQiO2k6MjIzO3M6MzM6ImZpbGVfZXhpc3RzXHMqXCgqXHMqWyciXS92YXIvdG1wLyI7aToyMjQ7czo0MToiJiZccyohZW1wdHlcKFxzKlwkX0NPT0tJRVxbWyciXWZpbGxbJyJdXF0iO2k6MjI1O3M6MjE6ImZ1bmN0aW9uXHMraW5EaWFwYXNvbiI7aToyMjY7czozNToibWFrZV9kaXJfYW5kX2ZpbGVcKFxzKlwkcGF0aF9qb29tbGEiO2k6MjI3O3M6NDE6Imxpc3RpbmdfcGFnZVwoXHMqbm90aWNlXChccypbJyJdc3ltbGlua2VkIjtpOjIyODtzOjYyOiJsaXN0XHMqXChccypcJGhvc3RccyosXHMqXCRwb3J0XHMqLFxzKlwkc2l6ZVxzKixccypcJGV4ZWNfdGltZSI7aToyMjk7czo1MjoiZmlsZW10aW1lXChcJGJhc2VwYXRoXHMqXC5ccypbJyJdL2NvbmZpZ3VyYXRpb25cLnBocCI7aToyMzA7czo1ODoiZnVuY3Rpb25ccytyZWFkX3BpY1woXHMqXCRBXHMqXClccyp7XHMqXCRhXHMqPVxzKlwkX1NFUlZFUiI7aToyMzE7czo2NDoiY2hyXChccypcJHRhYmxlXFtccypcJHN0cmluZ1xbXHMqXCRpXHMqXF1ccypcKlxzKnBvd1woNjRccyosXHMqMSI7aToyMzI7czoyOToiXF1ccypcKXtldmFsXChccypcJFx3K1xbXHMqXCQiO2k6MjMzO3M6NTQ6IkxvY2F0aW9uOjppc0ZpbGVXcml0YWJsZVwoXHMqRW5jb2RlRXhwbG9yZXI6OmdldENvbmZpZyI7aToyMzQ7czoxMzoiYnlccytTaHVuY2VuZyI7aToyMzU7czoxNDoie2V2YWxcKFwke1wkczIiO2k6MjM2O3M6MTg6ImV2YWxcKFwkczIxXChcJHtcJCI7aToyMzc7czoyMToiUmFtWmtpRVxzKy1ccytleHBsb2l0IjtpOjIzODtzOjQ3OiJbJyJdcmVtb3ZlX3NjcmlwdHNbJyJdXHMqPT5ccyphcnJheVwoWyciXVJlbW92ZSI7aToyMzk7czoyODoiXCRiYWNrX2Nvbm5lY3RfcGxccyo9XHMqWyciXSI7aToyNDA7czo0MDoiXCRzaXRlX3Jvb3RcLlwkZmlsZXVucF9kaXJcLlwkZmlsZXVucF9mbiI7aToyNDE7czoyNDoiQHByZWdfcmVwbGFjZVwoWyciXS9hZC9lIjtpOjI0MjtzOjI2OiI8Yj5cJHVpZFxzKlwoXCR1bmFtZVwpPC9iPiI7aToyNDM7czoxMToiRngyOUdvb2dsZXIiO2k6MjQ0O3M6ODoiZW52aXIwbm4iO2k6MjQ1O3M6NDY6ImFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqWyciXVwpLGJhc2U2NF9kZWNvZGUiO2k6MjQ2O3M6Mjg6IjxcPz1ccypAcGhwX3VuYW1lXChcKTtccypcPz4iO2k6MjQ3O3M6MTE6InNVeENyZXdccytWIjtpOjI0ODtzOjE2OiJXYXJCb3RccytzVXhDcmV3IjtpOjI0OTtzOjQzOiJleGVjXChbJyJdY2RccysvdG1wO2N1cmxccystT1xzK1snIl1cLlwkdXJsIjtpOjI1MDtzOjE1OiJCYXRhdmk0XHMrU2hlbGwiO2k6MjUxO3M6MzY6IkBleHRyYWN0XChcJF9SRVFVRVNUXFtbJyJdZngyOXNoY29vayI7aToyNTI7czoxMDoiVHVYX1NoYWRvdyI7aToyNTM7czo0MDoiPUBmb3BlblxzKlwoWyciXXBocFwuaW5pWyciXVxzKixccypbJyJddyI7aToyNTQ7czo5OiJMZWJheUNyZXciO2k6MjU1O3M6Nzk6IlwkaGVhZGVyc1xzKlwuPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZU1haWxBZGRbJyJdXHMqXF0iO2k6MjU2O3M6MTk6ImJvZ2VsXHMqLVxzKmV4cGxvaXQiO2k6MjU3O3M6NTk6IlxbdW5hbWVcXVsnIl1ccypcLlxzKnBocF91bmFtZVwoXHMqXClccypcLlxzKlsnIl1cWy91bmFtZVxdIjtpOjI1ODtzOjMyOiJcXVwoXCRfMSxcJF8xXClcKTtlbHNle1wkR0xPQkFMUyI7aToyNTk7czoxNDoiZmlsZTpmaWxlOi8vLy8iO2k6MjYwO3M6MzI6ImZ1bmN0aW9uXHMrTUNMb2dpblwoXClccyp7XHMqZGllIjtpOjI2MTtzOjU1OiJ7ZWNobyBbJyJdeWVzWyciXTsgZXhpdDt9ZWxzZXtlY2hvIFsnIl1ub1snIl07IGV4aXQ7fX19IjtpOjI2MjtzOjM5OiI7XD8+PFw/PVwke1snIl1fWyciXVwuXCRffVxbWyciXV9bJyJdXF0iO2k6MjYzO3M6NDE6IlwkYVxbMVxdPT1bJyJdYnlwYXNzaXBbJyJdXCk7XCRjPXNlbGY6OmMxIjtpOjI2NDtzOjQyOiJcJGRpclwuWyciXS9bJyJdXC5cJGZcLlsnIl0vd3AtY29uZmlnXC5waHAiO2k6MjY1O3M6MjM6ImV2YWxcKFsnIl1yZXR1cm5ccytldmFsIjtpOjI2NjtzOjgwOiJmd3JpdGVcKFwkXHcrLCJcXHhFRlxceEJCXFx4QkYiXC5pY29udlwoWyciXWdia1snIl0sWyciXXV0Zi04Ly9JR05PUkVbJyJdLFwkYm9keSI7aToyNjc7czo3MjoiZWNob1xzK1snIl1fX3N1Y2Nlc3NfX1snIl1ccypcLlxzKlwkTm93U3ViRm9sZGVyc1xzKlwuXHMqWyciXV9fc3VjY2Vzc19fIjtpOjI2ODtzOjc3OiJvYl9zdGFydFwoXCk7XHMqdmFyX2R1bXBcKFwkX1BPU1RccyosXHMqXCRfR0VUXHMqLFxzKlwkX0NPT0tJRVxzKixccypcJF9GSUxFUyI7aToyNjk7czozNDoiZ2V0ZW52XCgiSFRUUF9IT1NUIlwpXC4nIH4gU2hlbGwgSSI7aToyNzA7czo0MzoiZXZhbC9cKlwqL1woImV2YWxcKGd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZSI7aToyNzE7czoxNToiYXNzZXJ0XChcJFx3K1woIjtpOjI3MjtzOjE4OiJcJGRlZmFjZXI9J1JlWksyTEwiO2k6MjczO3M6MTk6IjwlXHMqZXZhbFxzK3JlcXVlc3QiO2k6Mjc0O3M6MzE6Im5ld190aW1lXChcJHBhdGgyZmlsZSxcJEdMT0JBTFMiO2k6Mjc1O3M6MTI2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF9QT1NUXHMqXFtccypbJyJdLis/WyciXVxzKlxdXHMqXC5ccyoiXHMqMlxzKj5ccyomMVxzKlsnIl0iO2k6Mjc2O3M6ODg6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJddW5hbWVccystYVsnIl1ccypcKSoiO2k6Mjc3O3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjI3ODtzOjI4OiJwaHBccytbJyJdXHMqXC5ccypcJHdzb19wYXRoIjtpOjI3OTtzOjUyOiJmaW5kXHMrL1xzKy1uYW1lXHMrXC5zc2hccys+XHMrXCRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjI4MDtzOjQ1OiJzeXN0ZW1ccypcKCpccypbJyJdezAsMX13aG9hbWlbJyJdezAsMX1ccypcKSoiO2k6MjgxO3M6ODg6ImN1cmxfc2V0b3B0XHMqXChccypcJGNoXHMqLFxzKkNVUkxPUFRfVVJMXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly9cJGhvc3Q6XGQrWyciXXswLDF9XHMqXCkiO30="));
$gX_FlexDBShe = unserialize(base64_decode("YTozMDI6e2k6MDtzOjY4OiJmaWxlX2dldF9jb250ZW50c1woU1JWX05BTUVccypcLlxzKlsnIl1cP2FjdGlvbj1nZXRfc2l0ZXMmbm9kYV9uYW1lPSI7aToxO3M6MzA6IkxvY2F0aW9uOlxzKlx3K1wuZG9jdW1lbnRcLmV4ZSI7aToyO3M6NDA6ImlmXCghcHJlZ19tYXRjaFwoWyciXS9IYWNrZWQgYnkvaVsnIl0sXCQiO2k6MztzOjk6IkJ5XHMrQW0hciI7aTo0O3M6MTk6IkNvbnRlbnQtVHlwZTpccypcJF8iO2k6NTtzOjQwOiJldmFsXHMqXCgqXHMqZ3ppbmZsYXRlXHMqXCgqXHMqc3RyX3JvdDEzIjtpOjY7czoxMDk6ImlmXHMqXChccyppc19jYWxsYWJsZVxzKlwoKlxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKSoiO2k6NztzOjI5OiJldmFsXHMqXCgqXHMqZ2V0X29wdGlvblxzKlwoKiI7aTo4O3M6OTU6ImFkZF9maWx0ZXJccypcKCpccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCkqIjtpOjk7czozMjoiaXNfd3JpdGFibGVccypcKCpccypbJyJdL3Zhci90bXAiO2k6MTA7czoyNjoic3ltbGlua1xzKlwoKlxzKlsnIl0vaG9tZS8iO2k6MTE7czo4NDoiaXNzZXRcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1cdytbJyJdXF1cKVxzKm9yXHMqZGllXCgqLis/XCkqIjtpOjEyO3M6NDk6Imd6dW5jb21wcmVzc1xzKlwoKlxzKnN1YnN0clxzKlwoKlxzKmJhc2U2NF9kZWNvZGUiO2k6MTM7czo5OiJcJF9fX1xzKj0iO2k6MTQ7czo0MDoiaWZccypcKFxzKnByZWdfbWF0Y2hccypcKFxzKlsnIl1cI3lhbmRleCI7aToxNTtzOjYxOiJAc2V0Y29va2llXChbJyJdbVsnIl0sXHMqWyciXVx3K1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjE2O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MTc7czozMzoic3ltYmlhblx8bWlkcFx8d2FwXHxwaG9uZVx8cG9ja2V0IjtpOjE4O3M6NDg6ImZ1bmN0aW9uXHMqY2htb2RfUlxzKlwoXHMqXCRwYXRoXHMqLFxzKlwkcGVybVxzKiI7aToxOTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyMDtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6MjE7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjIyO3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjM7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI0O3M6MzU6ImVjaG9ccytbJyJdezAsMX1pbnN0YWxsX29rWyciXXswLDF9IjtpOjI1O3M6MTY6IlNwYW1ccytjb21wbGV0ZWQiO2k6MjY7czo0NDoiYXJyYXlcKFxzKlsnIl1Hb29nbGVbJyJdXHMqLFxzKlsnIl1TbHVycFsnIl0iO2k6Mjc7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6Mjg7czoyMDoiL2VbJyJdXHMqLFxzKlsnIl1cXHgiO2k6Mjk7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6MzA7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MzE7czozNjoicHJlZ19yZXBsYWNlXChccypbJyJdZVsnIl0sWyciXXswLDF9IjtpOjMyO3M6NTM6ImZvcGVuXChbJyJdezAsMX1cLlwuL1wuXC4vXC5cLi9bJyJdezAsMX1cLlwkZmlsZXBhdGhzIjtpOjMzO3M6NTE6IlwkZGF0YVxzKj1ccyphcnJheVwoWyciXXswLDF9dGVybWluYWxbJyJdezAsMX1ccyo9PiI7aTozNDtzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aTozNTtzOjMzOiJwb3J0bGV0cy9mcmFtZXdvcmsvc2VjdXJpdHkvbG9naW4iO2k6MzY7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aTozNztzOjEwNDoic2l0ZV9mcm9tPVsnIl17MCwxfVwuXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1cXVwuWyciXXswLDF9JnNpdGVfZm9sZGVyPVsnIl17MCwxfVwuXCRmXFsxXF0iO2k6Mzg7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6Mzk7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aTo0MDtzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aTo0MTtzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjQyO3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjQzO3M6NDc6ImlmIFwoZGF0ZVwoWyciXXswLDF9alsnIl17MCwxfVwpXHMqLVxzKlwkbmV3c2lkIjtpOjQ0O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo0NTtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjQ2O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NDc7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo0ODtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjQ5O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjUwO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjUxO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjUyO3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo1MztzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjU0O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjU1O3M6NjQ6ImZvclwoXCRcdys9XGQrO1wkXHcrPFxkKztcJFx3Ky09XGQrXCl7aWZcKFwkXHcrIT1cZCtcKVxzKmJyZWFrO30iO2k6NTY7czozNjoiaWZcKEBmdW5jdGlvbl9leGlzdHNcKFsnIl17MCwxfWZyZWFkIjtpOjU3O3M6MzM6Ilwkb3B0XHMqPVxzKlwkZmlsZVwoQCpcJF9DT09LSUVcWyI7aTo1ODtzOjM4OiJwcmVnX3JlcGxhY2VcKFwpe3JldHVyblxzK19fRlVOQ1RJT05fXyI7aTo1OTtzOjM5OiJpZlxzKlwoY2hlY2tfYWNjXChcJGxvZ2luLFwkcGFzcyxcJHNlcnYiO2k6NjA7czozNjoicHJpbnRccytbJyJdezAsMX1kbGVfbnVsbGVkWyciXXswLDF9IjtpOjYxO3M6NjM6ImlmXChtYWlsXChcJGVtYWlsXFtcJGlcXSxccypcJHN1YmplY3QsXHMqXCRtZXNzYWdlLFxzKlwkaGVhZGVycyI7aTo2MjtzOjEyOiJUZWFNXHMrTW9zVGEiO2k6NjM7czoxNDoiWyciXXswLDF9RFplMXIiO2k6NjQ7czoxNToicGFja1xzKyJTbkE0eDgiIjtpOjY1O3M6MzI6IlwkX1Bvc3RcW1snIl17MCwxfVNTTlsnIl17MCwxfVxdIjtpOjY2O3M6Mjc6IkV0aG5pY1xzK0FsYmFuaWFuXHMrSGFja2VycyI7aTo2NztzOjk6IkJ5XHMrRFoyNyI7aTo2ODtzOjc0OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jbWRcLmV4ZSI7aTo2OTtzOjE1OiJBdXRvXHMqWHBsb2l0ZXIiO2k6NzA7czo5OiJieVxzK2cwMG4iO2k6NzE7czoyODoiaWZcKFwkbzwxNlwpe1wkaFxbXCRlXFtcJG9cXSI7aTo3MjtzOjk0OiJpZlwoaXNfZGlyXChcJHBhdGhcLlsnIl17MCwxfS93cC1jb250ZW50WyciXXswLDF9XClccytBTkRccytpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWFkbWluIjtpOjczO3M6NjA6ImlmXHMqXChccypmaWxlX3B1dF9jb250ZW50c1xzKlwoXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aTo3NDtzOjUxOiJAYXJyYXlcKFxzKlwoc3RyaW5nXClccypzdHJpcHNsYXNoZXNcKFxzKlwkX1JFUVVFU1QiO2k6NzU7czo0MDoic3RyX3JlcGxhY2VccypcKFxzKlsnIl17MCwxfS9wdWJsaWNfaHRtbCI7aTo3NjtzOjQxOiJpZlwoXHMqaXNzZXRcKFxzKlwkX1JFUVVFU1RcW1snIl17MCwxfWNpZCI7aTo3NztzOjE1OiJjYXRhdGFuXHMrc2l0dXMiO2k6Nzg7czo4NToiL2luZGV4XC5waHBcP29wdGlvbj1jb21famNlJnRhc2s9cGx1Z2luJnBsdWdpbj1pbWdtYW5hZ2VyJmZpbGU9aW1nbWFuYWdlciZ2ZXJzaW9uPVxkKyI7aTo3OTtzOjM3OiJzZXRjb29raWVcKFxzKlwkelxbMFxdXHMqLFxzKlwkelxbMVxdIjtpOjgwO3M6MzI6IlwkU1xbXCRpXCtcK1xdXChcJFNcW1wkaVwrXCtcXVwoIjtpOjgxO3M6MzI6IlxbXCRvXF1cKTtcJG9cK1wrXCl7aWZcKFwkbzwxNlwpIjtpOjgyO3M6ODE6InR5cGVvZlxzKlwoZGxlX2FkbWluXClccyo9PVxzKlsnIl17MCwxfXVuZGVmaW5lZFsnIl17MCwxfVxzKlx8XHxccypkbGVfYWRtaW5ccyo9PSI7aTo4MztzOjM2OiJjcmVhdGVfZnVuY3Rpb25cKHN1YnN0clwoMiwxXCksXCRzXCkiO2k6ODQ7czo2MDoicGx1Z2lucy9zZWFyY2gvcXVlcnlcLnBocFw/X19fX3BnZmE9aHR0cCUzQSUyRiUyRnd3d1wuZ29vZ2xlIjtpOjg1O3M6MzY6InJldHVyblxzK2Jhc2U2NF9kZWNvZGVcKFwkYVxbXCRpXF1cKSI7aTo4NjtzOjQ1OiJcJGZpbGVcKEAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6ODc7czoyNzoiY3VybF9pbml0XChccypiYXNlNjRfZGVjb2RlIjtpOjg4O3M6MzI6ImV2YWxcKFsnIl1cPz5bJyJdXC5iYXNlNjRfZGVjb2RlIjtpOjg5O3M6Mjk6IlsnIl1bJyJdXHMqXC5ccypCQXNlNjRfZGVDb0RlIjtpOjkwO3M6Mjg6IlsnIl1bJyJdXHMqXC5ccypnelVuY29NcHJlU3MiO2k6OTE7czoxOToiZ3JlcFxzKy12XHMrY3JvbnRhYiI7aTo5MjtzOjM0OiJjcmMzMlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9Y21kIjtpOjkzO3M6MTk6IlwkYmtleXdvcmRfYmV6PVsnIl0iO2k6OTQ7czo2MDoiZmlsZV9nZXRfY29udGVudHNcKGJhc2VuYW1lXChcJF9TRVJWRVJcW1snIl17MCwxfVNDUklQVF9OQU1FIjtpOjk1O3M6NTQ6IlxzKlsnIl17MCwxfXJvb2tlZVsnIl17MCwxfVxzKixccypbJyJdezAsMX13ZWJlZmZlY3RvciI7aTo5NjtzOjQ4OiJccypbJyJdezAsMX1zbHVycFsnIl17MCwxfVxzKixccypbJyJdezAsMX1tc25ib3QiO2k6OTc7czoyMDoiZXZhbFxzKlwoXHMqVFBMX0ZJTEUiO2k6OTg7czo4MjoiQCphcnJheV9kaWZmX3VrZXlcKFxzKkAqYXJyYXlcKFxzKlwoc3RyaW5nXClccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo5OTtzOjEwNToiXCRwYXRoXHMqPVxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdXHMqXC5ccypbJyJdezAsMX0vaW1hZ2VzL3N0b3JpZXMvWyciXXswLDF9IjtpOjEwMDtzOjg5OiJcJHNhcGVfb3B0aW9uXFtccypbJyJdezAsMX1mZXRjaF9yZW1vdGVfdHlwZVsnIl17MCwxfVxzKlxdXHMqPVxzKlsnIl17MCwxfXNvY2tldFsnIl17MCwxfSI7aToxMDE7czo4ODoiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkbmFtZVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMDI7czo4MjoiZXJlZ19yZXBsYWNlXChbJyJdezAsMX0lNUMlMjJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9JTIyWyciXXswLDF9XHMqLFxzKlwkbWVzc2FnZSI7aToxMDM7czo4NToiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfXVyWyciXXswLDF9XF1cKVwpXHMqXCRtb2RlXHMqXHw9XHMqMDQwMCI7aToxMDQ7czo0MToiL3BsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAiO2k6MTA1O3M6NDk6IkAqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkdGhpcy0+ZmlsZVxzKixccypzdHJyZXYiO2k6MTA2O3M6NDg6InByZWdfbWF0Y2hfYWxsXChccypbJyJdXHxcKFwuXCpcKTxcXCEtLSBqcy10b29scyI7aToxMDc7czozMDoiaGVhZGVyXChbJyJdezAsMX1yOlxzKm5vXHMrY29tIjtpOjEwODtzOjc1OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHNccysvdmFyL21haWwiO2k6MTA5O3M6MjY6IlwkZG9yX2NvbnRlbnQ9cHJlZ19yZXBsYWNlIjtpOjExMDtzOjIzOiJfX3VybF9nZXRfY29udGVudHNcKFwkbCI7aToxMTE7czo0MzoiXCRHTE9CQUxTXFtbJyJdezAsMX1cdytbJyJdezAsMX1cXVwoXHMqTlVMTCI7aToxMTI7czo2MjoidW5hbWVcXVsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXChcKVxzKlwuXHMqWyciXXswLDF9XFsvdW5hbWUiO2k6MTEzO3M6MzM6IkBcJGZ1bmNcKFwkY2ZpbGUsIFwkY2RpclwuXCRjbmFtZSI7aToxMTQ7czoyNToiZXZhbFwoXHMqXCRcdytcKFxzKlwkPGFtYyI7aToxMTU7czo3MToiXCRfXFtccypcZCtccypcXVwoXHMqXCRfXFtccypcZCtccypcXVwoXCRfXFtccypcZCtccypcXVwoXHMqXCRfXFtccypcZCsiO2k6MTE2O3M6Mjk6ImVyZWdpXChccypzcWxfcmVnY2FzZVwoXHMqXCRfIjtpOjExNztzOjQwOiJcI1VzZVsnIl17MCwxfVxzKixccypmaWxlX2dldF9jb250ZW50c1woIjtpOjExODtzOjIwOiJta2RpclwoXHMqWyciXS9ob21lLyI7aToxMTk7czoyMDoiZm9wZW5cKFxzKlsnIl0vaG9tZS8iO2k6MTIwO3M6MzY6IlwkdXNlcl9hZ2VudF90b19maWx0ZXJccyo9XHMqYXJyYXlcKCI7aToxMjE7czo0NDoiZmlsZV9wdXRfY29udGVudHNcKFsnIl17MCwxfVwuL2xpYndvcmtlclwuc28iO2k6MTIyO3M6NjQ6IlwjIS9iaW4vc2huY2RccytbJyJdezAsMX1bJyJdezAsMX1cLlwkU0NQXC5bJyJdezAsMX1bJyJdezAsMX1uaWYiO2k6MTIzO3M6ODI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl17MCwxfWF0XHMrbm93XHMrLWYiO2k6MTI0O3M6MzM6ImNyb250YWJccystbFx8Z3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMjU7czoxNDoiRGF2aWRccypCbGFpbmUiO2k6MTI2O3M6MjM6ImV4cGxvaXQtZGJcLmNvbS9zZWFyY2gvIjtpOjEyNztzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTI4O3M6NjA6Im1haWxcKFxzKlwkTWFpbFRvXHMqLFxzKlwkTWVzc2FnZVN1YmplY3RccyosXHMqXCRNZXNzYWdlQm9keSI7aToxMjk7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxMzA7czo3ODoiIWZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRibmFtZVxzKixccypcJHRoaXMtPmdldEltYWdlRW5jb2RlZFRleHRcKFxzKlwkZGJuYW1lIjtpOjEzMTtzOjQ0OiJzY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aToxMzI7czo3Mjoic2VuZF9zbXRwXChccypcJGVtYWlsXFtbJyJdezAsMX1hZHJbJyJdezAsMX1cXVxzKixccypcJHN1YmpccyosXHMqXCR0ZXh0IjtpOjEzMztzOjQ2OiI9XCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEzNDtzOjUyOiJ0b3VjaFwoXHMqWyciXXswLDF9XCRiYXNlcGF0aC9jb21wb25lbnRzL2NvbV9jb250ZW50IjtpOjEzNTtzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTM2O3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjEzNztzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjEzODtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjEzOTtzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjE0MDtzOjEzOiI9YnlccytEUkFHT049IjtpOjE0MTtzOjk4OiJzdWJzdHJcKFxzKlwkc3RyaW5nMlxzKixccypzdHJsZW5cKFxzKlwkc3RyaW5nMlxzKlwpXHMqLVxzKjlccyosXHMqOVwpXHMqPT1ccypbJyJdezAsMX1cW2wscj0zMDJcXSI7aToxNDI7czozMzoiXFtcXVxzKj1ccypbJyJdUmV3cml0ZUVuZ2luZVxzK29uIjtpOjE0MztzOjc1OiJmd3JpdGVcKFxzKlwkZlxzKixccypnZXRfZG93bmxvYWRcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTQ0O3M6NDc6InRhclxzKy1jemZccysiXHMqXC5ccypcJEZPUk17dGFyfVxzKlwuXHMqIlwudGFyIjtpOjE0NTtzOjExOiJzY29wYmluWyciXSI7aToxNDY7czo2NjoiPGRpdlxzK2lkPVsnIl1saW5rMVsnIl0+PGJ1dHRvbiBvbmNsaWNrPVsnIl1wcm9jZXNzVGltZXJcKFwpO1snIl0+IjtpOjE0NztzOjM1OiI8Z3VpZD48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybCI7aToxNDg7czo2MjoiaW50MzJcKFwoXChcJHpccyo+PlxzKjVccyomXHMqMHgwN2ZmZmZmZlwpXHMqXF5ccypcJHlccyo8PFxzKjIiO2k6MTQ5O3M6NDM6ImZvcGVuXChccypcJHJvb3RfZGlyXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6MTUwO3M6MjM6IlwkaW5fUGVybXNccysmXHMrMHg0MDAwIjtpOjE1MTtzOjM0OiJmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS92YXIvdG1wIjtpOjE1MjtzOjk6Ii9wbXQvcmF2LyI7aToxNTM7czo0OToiZndyaXRlXChcJGZwXHMqLFxzKnN0cnJldlwoXHMqXCRjb250ZXh0XHMqXClccypcKSI7aToxNTQ7czoyMDoiTWFzcmlccytDeWJlclxzK1RlYW0iO2k6MTU1O3M6MTg6IlVzM1xzK1kwdXJccyticjQxbiI7aToxNTY7czoyMDoiTWFzcjFccytDeWIzclxzK1RlNG0iO2k6MTU3O3M6MjA6InRIQU5Lc1xzK3RPXHMrU25vcHB5IjtpOjE1ODtzOjY2OiIsXHMqWyciXS9pbmRleFxcXC5cKHBocFx8aHRtbFwpL2lbJyJdXHMqLFxzKlJlY3Vyc2l2ZVJlZ2V4SXRlcmF0b3IiO2k6MTU5O3M6NDc6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjE2MDtzOjU1OiJnZXRwcm90b2J5bmFtZVwoXHMqWyciXXRjcFsnIl1ccypcKVxzK1x8XHxccytkaWVccytzaGl0IjtpOjE2MTtzOjc4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdY2RccysvdG1wO3dnZXQiO2k6MTYyO3M6MjI6IjxhXHMraHJlZj1bJyJdb3NoaWJrYS0iO2k6MTYzO3M6ODU6ImlmXChccypcJF9HRVRcW1xzKlsnIl1pZFsnIl1ccypcXSE9XHMqWyciXVsnIl1ccypcKVxzKlwkaWQ9XCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0iO2k6MTY0O3M6ODM6ImlmXChbJyJdc3Vic3RyX2NvdW50XChbJyJdXCRfU0VSVkVSXFtbJyJdUkVRVUVTVF9VUklbJyJdXF1ccyosXHMqWyciXXF1ZXJ5XC5waHBbJyJdIjtpOjE2NTtzOjM4OiJcJGZpbGwgPSBcJF9DT09LSUVcW1xcWyciXWZpbGxcXFsnIl1cXSI7aToxNjY7czo2MjoiXCRyZXN1bHQ9c21hcnRDb3B5XChccypcJHNvdXJjZVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGZpbGUiO2k6MTY3O3M6NDA6IlwkYmFubmVkSVBccyo9XHMqYXJyYXlcKFxzKlsnIl1cXjY2XC4xMDIiO2k6MTY4O3M6MzU6Ijxsb2M+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmw7IjtpOjE2OTtzOjI4OiJcJHNldGNvb2tcKTtzZXRjb29raWVcKFwkc2V0IjtpOjE3MDtzOjI4OiJcKTtmdW5jdGlvblxzK3N0cmluZ19jcHRcKFwkIjtpOjE3MTtzOjUwOiJbJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXSI7aToxNzI7czo1MzoiaWZcKHByZWdfbWF0Y2hcKFsnIl1cI3dvcmRwcmVzc19sb2dnZWRfaW5cfGFkbWluXHxwd2QiO2k6MTczO3M6NDE6ImdfZGVsZXRlX29uX2V4aXRccyo9XHMqbmV3XHMrRGVsZXRlT25FeGl0IjtpOjE3NDtzOjMwOiJTRUxFQ1RccytcKlxzK0ZST01ccytkb3JfcGFnZXMiO2k6MTc1O3M6MTg6IkFjYWRlbWljb1xzK1Jlc3VsdCI7aToxNzY7czo3NzoidmFsdWU9WyciXTxcP1xzK1xiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl0iO2k6MTc3O3M6Mjc6IlxkKyZAcHJlZ19tYXRjaFwoXHMqc3RydHJcKCI7aToxNzg7czozODoiY2hyXChccypoZXhkZWNcKFxzKnN1YnN0clwoXHMqXCRtYWtldXAiO2k6MTc5O3M6MzA6InJlYWRfZmlsZV9uZXdfMlwoXCRyZXN1bHRfcGF0aCI7aToxODA7czoyMzoiXCRpbmRleF9wYXRoXHMqLFxzKjA0MDQiO2k6MTgxO3M6Njc6IlwkZmlsZV9mb3JfdG91Y2hccyo9XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6MTgyO3M6NjE6IlwkX1NFUlZFUlxbWyciXXswLDF9UkVNT1RFX0FERFJbJyJdezAsMX1cXTtpZlwoXChwcmVnX21hdGNoXCgiO2k6MTgzO3M6MTk6Ij09XHMqWyciXWNzaGVsbFsnIl0iO2k6MTg0O3M6Mjk6ImZpbGVfZXhpc3RzXChccypcJEZpbGVCYXphVFhUIjtpOjE4NTtzOjE4OiJyZXN1bHRzaWduX3dhcm5pbmciO2k6MTg2O3M6MjQ6ImZ1bmN0aW9uXHMrZ2V0Zmlyc3RzaHRhZyI7aToxODc7czo5MDoiZmlsZV9nZXRfY29udGVudHNcKFJPT1RfRElSXC5bJyJdL3RlbXBsYXRlcy9bJyJdXC5cJGNvbmZpZ1xbWyciXXNraW5bJyJdXF1cLlsnIl0vbWFpblwudHBsIjtpOjE4ODtzOjI1OiJuZXdccytjb25lY3RCYXNlXChbJyJdYUhSIjtpOjE4OTtzOjgzOiJcJGlkXHMqXC5ccypbJyJdXD9kPVsnIl1ccypcLlxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxOTA7czoyOToiZG9fd29ya1woXHMqXCRpbmRleF9maWxlXHMqXCkiO2k6MTkxO3M6MjA6ImhlYWRlclxzKlwoXHMqX1xkK1woIjtpOjE5MjtzOjEyOiJCeVxzK1dlYlJvb1QiO2k6MTkzO3M6MTY6IkNvZGVkXHMrYnlccytFWEUiO2k6MTk0O3M6NzE6InRyaW1cKFxzKlwkaGVhZGVyc1xzKlwpXHMqXClccyphc1xzKlwkaGVhZGVyXHMqXClccypoZWFkZXJcKFxzKlwkaGVhZGVyIjtpOjE5NTtzOjU2OiJAXCRfU0VSVkVSXFtccypIVFRQX0hPU1RccypcXT5bJyJdXHMqXC5ccypbJyJdXFxyXFxuWyciXSI7aToxOTY7czo4MToiZmlsZV9nZXRfY29udGVudHNcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjE5NztzOjY5OiJ0b3VjaFwoXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6MTk4O3M6MTY6IlBIUFNIRUxMX1ZFUlNJT04iO2k6MTk5O3M6MTU6IjxcP1xzKj1AYFwkXHcrYCI7aToyMDA7czoyMToiJl9TRVNTSU9OXFtwYXlsb2FkXF09IjtpOjIwMTtzOjQ3OiJnenVuY29tcHJlc3NcKFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdaHR0cCI7aToyMDI7czo4NDoiaWZcKFxzKiFlbXB0eVwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9dHAyWyciXXswLDF9XHMqXF1cKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjIwMztzOjQ5OiJpZlwoXHMqdHJ1ZVxzKiZccypAcHJlZ19tYXRjaFwoXHMqc3RydHJcKFxzKlsnIl0vIjtpOjIwNDtzOjM4OiI9PVxzKjBcKVxzKntccyplY2hvXHMqUEhQX09TXHMqXC5ccypcJCI7aToyMDU7czoxMDc6Imlzc2V0XChccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxzKlxkK1xzKlwpXHMqXF1ccypcKVxzKlw/XHMqXCRfU0VSVkVSXFtccypfXGQrXChcZCtcKVxzKlxdXHMqOlxzKl9cZCtcKFxkK1wpIjtpOjIwNjtzOjk5OiJcJGluZGV4XHMqPVxzKnN0cl9yZXBsYWNlXChccypbJyJdPFw/cGhwXHMqb2JfZW5kX2ZsdXNoXChcKTtccypcPz5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkaW5kZXgiO2k6MjA3O3M6MzM6Ilwkc3RhdHVzX2xvY19zaFxzKj1ccypmaWxlX2V4aXN0cyI7aToyMDg7czo0ODoiXCRQT1NUX1NUUlxzKj1ccypmaWxlX2dldF9jb250ZW50c1woInBocDovL2lucHV0IjtpOjIwOTtzOjQ4OiJnZVxzKj1ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkX1BPU1RccypcW1snIl1tZXMiO2k6MjEwO3M6NjY6IlwkdGFibGVcW1wkc3RyaW5nXFtcJGlcXVxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjJcKVxzKlwrXHMqXCR0YWJsZSI7aToyMTE7czozMzoiaWZcKFxzKnN0cmlwb3NcKFxzKlsnIl1cKlwqXCpcJHVhIjtpOjIxMjtzOjQ5OiJmbHVzaF9lbmRfZmlsZVwoXHMqXCRmaWxlbmFtZVxzKixccypcJGZpbGVjb250ZW50IjtpOjIxMztzOjU2OiJwcmVnX21hdGNoXChccypbJyJdezAsMX1+TG9jYXRpb246XChcLlwqXD9cKVwoXD86XFxuXHxcJCI7aToyMTQ7czoyODoidG91Y2hcKFxzKlwkdGhpcy0+Y29uZi0+cm9vdCI7aToyMTU7czoyNjoiZXZhbFwoXHMqXCR7XHMqXCRcdytccyp9XFsiO2k6MjE2O3M6NDM6ImlmXHMqXChccypAZmlsZXR5cGVcKFwkbGVhZG9uXHMqXC5ccypcJGZpbGUiO2k6MjE3O3M6NTk6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRpclxzKlwuXHMqXCRmaWxlXHMqXC5ccypbJyJdL2luZGV4IjtpOjIxODtzOjI2OiJmaWxlc2l6ZVwoXHMqXCRwdXRfa19mYWlsdSI7aToyMTk7czo2MDoiYWdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXXswLDF9bWVzWyciXVxdIjtpOjIyMDtzOjQzOiJmdW5jdGlvblxzK2ZpbmRIZWFkZXJMaW5lXHMqXChccypcJHRlbXBsYXRlIjtpOjIyMTtzOjQzOiJcJHN0YXR1c19jcmVhdGVfZ2xvYl9maWxlXHMqPVxzKmNyZWF0ZV9maWxlIjtpOjIyMjtzOjM4OiJlY2hvXHMrc2hvd19xdWVyeV9mb3JtXChccypcJHNxbHN0cmluZyI7aToyMjM7czozNToiPT1ccypGQUxTRVxzKlw/XHMqXGQrXHMqOlxzKmlwMmxvbmciO2k6MjI0O3M6MjI6ImZ1bmN0aW9uXHMrbWFpbGVyX3NwYW0iO2k6MjI1O3M6MzQ6IkVkaXRIdGFjY2Vzc1woXHMqWyciXVJld3JpdGVFbmdpbmUiO2k6MjI2O3M6MTE6IlwkcGF0aFRvRG9yIjtpOjIyNztzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjIyODtzOjc3OiJAXCRfQ09PS0lFXFtccypbJyJdXHcrWyciXVxzKlxdXChccypAXCRfQ09PS0lFXFtccypbJyJdXHcrWyciXVxzKlxdXHMqXClccypcKSI7aToyMjk7czo0MDoiaGVhZGVyXChbJyJdTG9jYXRpb246XHMqaHR0cDovL1wkcHBcLm9yZyI7aToyMzA7czoyNzoicmV0dXJuXHMrWyciXS9ob21lL1x3Ky9cdysvIjtpOjIzMTtzOjM5OiJbJyJdd3AtWyciXVxzKlwuXHMqZ2VuZXJhdGVSYW5kb21TdHJpbmciO2k6MjMyO3M6NTc6IlwkXHcrPT1bJyJdZmVhdHVyZWRbJyJdXHMqXClccypcKXtccyplY2hvXHMrYmFzZTY0X2RlY29kZSI7aToyMzM7czo4NjoiXCRcdytccyo9XHMqXCRqcVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHcrWyciXXswLDF9XF0iO2k6MjM0O3M6MjI6ImV4cGxvaXRccyo6OlwuPC90aXRsZT4iO2k6MjM1O3M6MzA6IlwkXHcrPXN0cl9yZXBsYWNlXChbJyJdXCphXCRcKiI7aToyMzY7czo0MDoiY2hyXChccypcJFx3K1xzKlwpO1xzKn1ccypldmFsXChccypcJFx3KyI7aToyMzc7czozNzoiaWZcKFxzKmlzSW5TdHJpbmcxKlwoXCRcdyssWyciXWdvb2dsZSI7aToyMzg7czo5MzoiXCRwcFxzKj1ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdIjtpOjIzOTtzOjQ5OiJmaWxlX3B1dF9jb250ZW50c1woRElSXC5bJyJdL1snIl1cLlsnIl1pbmRleFwucGhwIjtpOjI0MDtzOjI5OiJAZ2V0X2hlYWRlcnNcKFxzKlwkZnVsbHBhdGhcKSI7aToyNDE7czoyMToiQFwkX0dFVFxbWyciXXB3WyciXVxdIjtpOjI0MjtzOjI1OiJqc29uX2VuY29kZVwoYWxleHVzTWFpbGVyIjtpOjI0MztzOjE2ODoiZXZhbFwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjI0NDtzOjE5OiI9WyciXVwpXCk7WyciXVwpXCk7IjtpOjI0NTtzOjE3MDoiPVxzKlwkXHcrXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MjQ2O3M6NTU6IlxdXHMqfVxzKlwoXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjQ3O3M6Nzc6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woXHMqWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1ccypcKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjI0ODtzOjQ4OiJldmFsXChbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoWyciXVsnIl0sZmlsZVwoXCQiO2k6MjQ5O3M6Njg6InNldG9wdFwoXCRjaFxzKixccypDVVJMT1BUX1BPU1RGSUVMRFNccyosXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRkYXRhIjtpOjI1MDtzOjEwNzoibXlzcWxfY29ubmVjdFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1cdytbJyJdXF1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjUxO3M6NjQ6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cKSxbJyJdYWlkdVsnIl0iO2k6MjUyO3M6MzY6IlxdXHMqXClccypcKVxzKntccypldmFsXHMqXChccypcJHtcJCI7aToyNTM7czoxNjoiYnlccytFcnJvclxzKzdyQiI7aToyNTQ7czozMzoiQGlyY3NlcnZlcnNcW3JhbmRccytAaXJjc2VydmVyc1xdIjtpOjI1NTtzOjU5OiJzZXRfdGltZV9saW1pdFwoaW50dmFsXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNTY7czoyNDoibmlja1xzK1snIl1jaGFuc2VydlsnIl07IjtpOjI1NztzOjIzOiJNYWdpY1xzK0luY2x1ZGVccytTaGVsbCI7aToyNTg7czo1NzoiXCRcdytcKTtcJFx3Kz1jcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFwkXHcrXCk7XCRcdytcKFwpIjtpOjI1OTtzOjM4OiJjdXJsT3BlblwoXCRyZW1vdGVfcGF0aFwuXCRwYXJhbV92YWx1ZSI7aToyNjA7czo0NzoiZndyaXRlXChcJGZwLFsnIl1cXHhFRlxceEJCXFx4QkZbJyJdXC5cJGJvZHlcKTsiO2k6MjYxO3M6ODM6IlwkXHcrXCtcK1wpXHMqe1xzKlwkXHcrXHMqPVxzKmFycmF5X3VuaXF1ZVwoYXJyYXlfbWVyZ2VcKFwkXHcrXHMqLFxzKlx3K1woWyciXVwkXHcrIjtpOjI2MjtzOjQyOiJhbmRccypcKCFccypzdHJzdHJcKFwkdWEsWyciXXJ2OjExWyciXVwpXCkiO2k6MjYzO3M6MzU6ImVjaG9ccytcJG9rXHMrXD9ccytbJyJdU0hFTExfT0tbJyJdIjtpOjI2NDtzOjI3OiI7ZXZhbFwoXCR0b2RvY29udGVudFxbMFxdXCkiO2k6MjY1O3M6NDA6Im9yXHMrc3RydG9sb3dlclwoQGluaV9nZXRcKFsnIl1zYWZlX21vZGUiO2k6MjY2O3M6Mjk6ImlmXCghaXNzZXRcKFwkX1JFUVVFU1RcW2NoclwoIjtpOjI2NztzOjQ0OiJcJHByb2Nlc3NvXHMqPVxzKlwkcHNcW3JhbmRccytzY2FsYXJccytAcHNcXSI7aToyNjg7czozMjoiZWNob1xzK1snIl11bmFtZVxzKy1hO1xzKlwkdW5hbWUiO2k6MjY5O3M6MjE6IlwudGNwZmxvb2Rccys8dGFyZ2V0PiI7aToyNzA7czo1MDoiXCRib3RcW1snIl1zZXJ2ZXJbJyJdXF09XCRzZXJ2YmFuXFtyYW5kXCgwLGNvdW50XCgiO2k6MjcxO3M6MTY6IlwuOlxzK3czM2Rccys6XC4iO2k6MjcyO3M6MTY6IkJMQUNLVU5JWFxzK0NSRVciO2k6MjczO3M6Njg6IjtcJFx3K1xbXCRcdytcW1snIl1cdytbJyJdXF1cW1xkK1xdXC5cJFx3K1xbWyciXVx3K1snIl1cXVxbXGQrXF1cLlwkIjtpOjI3NDtzOjMwOiJjYXNlXHMqWyciXWNyZWF0ZV9zeW1saW5rWyciXToiO2k6Mjc1O3M6ODY6InNvY2tldF9jb25uZWN0XChcJFx3KyxccypbJyJdZ21haWwtc210cC1pblwubFwuZ29vZ2xlXC5jb21bJyJdXHMqLFxzKjI1XClccyo9PVxzKkZBTFNFIjtpOjI3NjtzOjM2OiJjYWxsX3VzZXJfZnVuY1woQHVuaGV4XCgweFx3K1wpXChcJF8iO2k6Mjc3O3M6NTI6IlwkXz1AXCRfUkVRVUVTVFxbWyciXVx3K1snIl1cXVwpXC5AXCRfXChcJF9SRVFVRVNUXFsiO2k6Mjc4O3M6NTU6IlwkR0xPQkFMU1xbXCRHTE9CQUxTXFtbJyJdXHcrWyciXVxdXFtcZCtcXVwuXCRHTE9CQUxTXFsiO2k6Mjc5O3M6NDM6IlwuXCRcdytcW1wkXHcrXF1cLlsnIl17WyciXVwpXCk7fTt1bnNldFwoXCQiO2k6MjgwO3M6ODY6Imh0dHBfYnVpbGRfcXVlcnlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXClcLlsnIl0maXA9WyciXVxzKlwuXHMqXCRfU0VSVkVSIjtpOjI4MTtzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdL3NiaW4vaWZjb25maWdbJyJdIjtpOjI4MjtzOjg5OiI8XD9waHBccytpZlxzKlwoaXNzZXRccypcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdaW1hZ2VzWyciXVxdXClcKVxzKntcJCI7aToyODM7czoxNzoiPHRpdGxlPkdPUkRPXHMrMjAiO2k6Mjg0O3M6MTE4OiJjb3B5XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVx3K1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVx3K1snIl1cXVwpIjtpOjI4NTtzOjM4OiJzcHJpbnRmXChcdytcKFwkXHcrXHMqLFxzKlwkXHcrXClccypcKSI7aToyODY7czo1ODoiPVxzKnN0cl9yZXBsYWNlXChccypbJyJdXHxcfFx8XHcrXHxcfFx8WyciXVxzKixccypbJyJdWyciXSI7aToyODc7czo5MjoiXCRcdytcWzBcXT1wYWNrXChbJyJdSFwqWyciXSxbJyJdXHcrWyciXVwpO2FycmF5X2ZpbHRlclwoXCRcdysscGFja1woWyciXUhcKlsnIl0sWyciXVx3K1snIl0iO2k6Mjg4O3M6NTA6ImV2YWxccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI4OTtzOjUyOiJhc3NlcnRccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI5MDtzOjEwNjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcWyI7aToyOTE7czoxNzc6IjxiPmV2YWxccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKCI7aToyOTI7czo3MjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl13Z2V0IjtpOjI5MztzOjIxOiI9PVsnIl1cKVwpO3JldHVybjtcPz4iO2k6Mjk0O3M6NzoidWdnYzovLyI7aToyOTU7czo1MzoiXCRcdytcW1wkXHcrXF09Y2hyXChcJFx3K1xbb3JkXChcJFx3K1xbXCRcdytcXVwpXF1cKTsiO2k6Mjk2O3M6MjY6IlwkXHcrXFtjaHJcKFxkK1wpXF1cKFx3K1woIjtpOjI5NztzOjExMjoiXCRcdytccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXClccypcLlxzKlwkXHcrXHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFx3K1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKSI7aToyOTg7czoxMDQ6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiIjtpOjI5OTtzOjU0OiJcJFx3Kz1hcnJheVwoWyciXVwkXHcrXFtccypcXT1hcnJheV9wb3BcKFwkXHcrXCk7XCRcdysiO2k6MzAwO3M6Nzc6IlwkXHcrPXBhY2tcKFsnIl1IXCpbJyJdLHN1YnN0clwoXCRcdyssXHMqLVxkK1wpXCk7XHMqcmV0dXJuXHMrXCRcdytcKHN1YnN0clwoIjtpOjMwMTtzOjc2OiJcJFx3K1xbWyciXXswLDF9XHcrWyciXXswLDF9XF1cW1snIl17MCwxfVx3K1snIl17MCwxfVxdXChcJFx3KyxcJFx3KyxcJFx3K1xbIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NzY6e2k6MDtzOjQ0OiJccyo9XHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXSI7aToxO3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjI7czo0MToiWyciXWZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDIwMDAiO2k6MztzOjQ1OiJbJyJdZmluZFxzKy9ccystdHlwZVxzK2ZccystbmFtZVxzK1wuaHRwYXNzd2QiO2k6NDtzOjI4OiJhbmRyb2lkXHxhdmFudGdvXHxibGFja2JlcnJ5IjtpOjU7czozNzoiaW5pX3NldFwoXHMqWyciXXswLDF9bWFnaWNfcXVvdGVzX2dwYyI7aTo2O3M6MTI6IlsnIl1sc1xzKy1sYSI7aTo3O3M6MTk6InJvdW5kXHMqXChccyowXHMqXCsiO2k6ODtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo5O3M6MTI6IlsnIl1ybVxzKy1yZiI7aToxMDtzOjEyOiJbJyJdcm1ccystZnIiO2k6MTE7czoxNjoiWyciXXJtXHMrLXJccystZiI7aToxMjtzOjE2OiJbJyJdcm1ccystZlxzKy1yIjtpOjEzO3M6MTA6IlsnIl1hSFIwY0QiO2k6MTQ7czo5OiJraWxsXHMrLTkiO2k6MTU7czo1MToiQ1VSTE9QVF9SRUZFUkVSLFxzKlsnIl17MCwxfWh0dHBzOi8vd3d3XC5nb29nbGVcLmNvIjtpOjE2O3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6MTc7czo0MDoiKFteXD9cc10pXCh7MCwxfVwuW1wrXCpdXCl7MCwxfVwyW2Etel0qZSI7aToxODtzOjEzOiJAZXh0cmFjdFxzKlwoIjtpOjE5O3M6MTM6IkBleHRyYWN0XHMqXCQiO2k6MjA7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aToyMTtzOjQyOiI9XHMqY3JlYXRlX2Z1bmN0aW9uXChbJyJdezAsMX1cJGFbJyJdezAsMX0iO2k6MjI7czo3MDoibWFpbFwoXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXSI7aToyMztzOjIxOiJkaXNhYmxlX2Z1bmN0aW9uc1xzKj0iO2k6MjQ7czo0MzoiXGJtYWlsXChccypcJFx3K1xzKixccypcJFx3K1xzKixccypcJFx3K1xzKiI7aToyNTtzOjI5OiJmb3BlblwoXHMqWyciXVwuXC4vXC5odGFjY2VzcyI7aToyNjtzOjE0OiIhL3Vzci9iaW4vcGVybCI7aToyNztzOjQ2OiJAZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqQHNldF90aW1lX2xpbWl0XCgwXCk7IjtpOjI4O3M6MjI6InJ1bmtpdF9mdW5jdGlvbl9yZW5hbWUiO2k6Mjk7czoxNzQ6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKFxzKlwkXHcrXChccypcJCI7aTozMDtzOjU3OiIkW2EtekEtWjAtOV9dXHtcZCtcfVxzKlwuJFx3K1x7XGQrXH1ccypcLiRcdytce1xkK1x9XHMqXC4iO2k6MzE7czoxMzoiXGJldmFsXChcdytcKCI7aTozMjtzOjI4OiJkaXNrX2ZyZWVfc3BhY2VcKFxzKlsnIl0vdG1wIjtpOjMzO3M6OToiUm9vdFNoZWxsIjtpOjM0O3M6MTQ6IkJPVE5FVFxzK1BBTkVMIjtpOjM1O3M6MTg6Ij09XHMqWyciXTQ2XC4yMjlcLiI7aTozNjtzOjE4OiI9PVxzKlsnIl05MVwuMjQzXC4iO2k6Mzc7czo1OiJKVGVybSI7aTozODtzOjU6Ik9uZXQ3IjtpOjM5O3M6OToiXCRwYXNzX3VwIjtpOjQwO3M6NToieENlZHoiO2k6NDE7czoxMTY6ImlmXHMqXChccypmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKVxzKlwpIjtpOjQyO3M6Mjc6IlwkT09PLis/PVxzKnVybGRlY29kZVxzKlwoKiI7aTo0MztzOjM4OiJzdHJlYW1fc29ja2V0X2NsaWVudFxzKlwoXHMqWyciXXRjcDovLyI7aTo0NDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6NDU7czozMToiPVxzKmFycmF5X21hcFxzKlwoKlxzKnN0cnJldlxzKiI7aTo0NjtzOjMyOiJzdHJfaXJlcGxhY2VccypcKCpccypbJyJdPC9oZWFkPiI7aTo0NztzOjIzOiJjb3B5XHMqXChccypbJyJdaHR0cDovLyI7aTo0ODtzOjE5MDoibW92ZV91cGxvYWRlZF9maWxlXHMqXCgqXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVuYW1lWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVuYW1lWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aTo0OTtzOjI4OiJlY2hvXHMqXCgqXHMqWyciXU5PIEZJTEVbJyJdIjtpOjUwO3M6MTU6IlsnIl0vXC5cKi9lWyciXSI7aTo1MTtzOjQ4NzoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKSI7aTo1MjtzOjY0OiJlY2hvXHMrc3RyaXBzbGFzaGVzXHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjUzO3M6MTU6Ii91c3Ivc2Jpbi9odHRwZCI7aTo1NDtzOjY0OiI9XHMqXCRHTE9CQUxTXFtccypbJyJdXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXVxzKlxdIjtpOjU1O3M6MTU6IlwkYXV0aF9wYXNzXHMqPSI7aTo1NjtzOjI5OiJlY2hvXHMrWyciXXswLDF9Z29vZFsnIl17MCwxfSI7aTo1NztzOjIyOiJldmFsXHMqXChccypnZXRfb3B0aW9uIjtpOjU4O3M6ODA6IldCU19ESVJccypcLlxzKlsnIl17MCwxfXRlbXAvWyciXXswLDF9XHMqXC5ccypcJGFjdGl2ZUZpbGVccypcLlxzKlsnIl17MCwxfVwudG1wIjtpOjU5O3M6NzM6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1snIl1cdytbJyJdXF1cW1snIl10bXBfbmFtZVsnIl1cXVxzKiwiO2k6NjA7czo4MToibWFpbFwoXCRfUE9TVFxbWyciXXswLDF9ZW1haWxbJyJdezAsMX1cXSxccypcJF9QT1NUXFtbJyJdezAsMX1zdWJqZWN0WyciXXswLDF9XF0sIjtpOjYxO3M6Nzc6Im1haWxccypcKFwkZW1haWxccyosXHMqWyciXXswLDF9PVw/VVRGLThcP0JcP1snIl17MCwxfVwuYmFzZTY0X2VuY29kZVwoXCRmcm9tIjtpOjYyO3M6NTM6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypcdytccypcXVwoIjtpOjYzO3M6MTk6IlsnIl0vXGQrL1xbYS16XF1cKmUiO2k6NjQ7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6NjU7czo1NjoiQCpmaWxlX3B1dF9jb250ZW50c1woXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NjY7czozNjoiWC1NYWlsZXI6XHMqTWljcm9zb2Z0IE9mZmljZSBPdXRsb29rIjtpOjY3O3M6OTE6Im1haWxcKFxzKnN0cmlwc2xhc2hlc1woXCR0b1wpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRzdWJqZWN0XClccyosXHMqc3RyaXBzbGFzaGVzXChcJG1lc3NhZ2UiO2k6Njg7czozMzoiXCRcdytccypcKFxzKlwkXHcrXHMqXChccypcJFx3K1woIjtpOjY5O3M6MjM6ImlzX3dyaXRhYmxlPWlzX3dyaXRhYmxlIjtpOjcwO3M6Mzg6IkBtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkdXNlcmZpbGVfdG1wIjtpOjcxO3M6MjY6ImV4aXRcKFwpOmV4aXRcKFwpOmV4aXRcKFwpIjtpOjcyO3M6Njc6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6NzM7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6NzQ7czo1OToiXChccypcJHNlbmRccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZVxzKixccypcJGhlYWRlcnMiO2k6NzU7czo4MzoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWx3cC1kb3dubG9hZFxzK2h0dHA6Ly8iO2k6NzY7czoxMDE6InN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlIjtpOjc3O3M6MzY6Ii9hZG1pbi9jb25maWd1cmF0aW9uXC5waHAvbG9naW5cLnBocCI7aTo3ODtzOjcxOiJzZWxlY3Rccypjb25maWd1cmF0aW9uX2lkLFxzK2NvbmZpZ3VyYXRpb25fdGl0bGUsXHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aTo3OTtzOjUwOiJ1cGRhdGVccypjb25maWd1cmF0aW9uXHMrc2V0XHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aTo4MDtzOjM3OiJzZWxlY3RccypsYW5ndWFnZXNfaWQsXHMrbmFtZSxccytjb2RlIjtpOjgxO3M6NTI6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypcXFsnIl1cXFsnIl07fWlmXCghZ2V0Q29va2llXCgiO2k6ODI7czo0NToiaWZcKGZpbGVfcHV0X2NvbnRlbnRzXChcJGluZGV4X3BhdGgsXHMqXCRjb2RlIjtpOjgzO3M6MzY6ImV4ZWNccyt7WyciXS9iaW4vc2hbJyJdfVxzK1snIl0tYmFzaCI7aTo4NDtzOjUwOiI8aWZyYW1lXHMrc3JjPVsnIl1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tL2Zvcm1zLyI7aTo4NTtzOjIyOiIsWyciXTxcP3BocFxcblsnIl1cLlwkIjtpOjg2O3M6NzI6IjxcP3BocFxzK1xiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqWyciXS9ob21lLyI7aTo4NztzOjIyOiJ4cnVtZXJfc3BhbV9saW5rc1wudHh0IjtpOjg4O3M6MzM6IkNvbWZpcm1ccytUcmFuc2FjdGlvblxzK1Bhc3N3b3JkOiI7aTo4OTtzOjc3OiJhcnJheV9tZXJnZVwoXCRleHRccyosXHMqYXJyYXlcKFsnIl13ZWJzdGF0WyciXSxbJyJdYXdzdGF0c1snIl0sWyciXXRlbXBvcmFyeSI7aTo5MDtzOjkyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbXlzcWxkdW1wXHMrLWhccytsb2NhbGhvc3RccystdSI7aTo5MTtzOjI4OiJNb3RoZXJbJyJdc1xzK01haWRlblxzK05hbWU6IjtpOjkyO3M6Mzk6ImxvY2F0aW9uXC5yZXBsYWNlXChcXFsnIl1cJHVybF9yZWRpcmVjdCI7aTo5MztzOjM2OiJjaG1vZFwoZGlybmFtZVwoX19GSUxFX19cKSxccyowNTExXCkiO2k6OTQ7czo4NToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9Y3VybFxzKy1PXHMraHR0cDovLyI7aTo5NTtzOjI5OiJcKVwpLFBIUF9WRVJTSU9OLG1kNV9maWxlXChcJCI7aTo5NjtzOjM1OiJcJFx3K1xbXCRcdytcXVxbXCRcdytcW1xkK1xdXC5cJFx3KyI7aTo5NztzOjM0OiJcJHF1ZXJ5XHMrLFxzK1snIl1mcm9tJTIwam9zX3VzZXJzIjtpOjk4O3M6MTU6ImV2YWxcKFsnIl1ccyovLyI7aTo5OTtzOjE2OiJldmFsXChbJyJdXHMqL1wqIjtpOjEwMDtzOjU0OiJcJFx3K1xzKj1cJFx3K1xzKlwoXCRcdytccyosXHMqXCRcdytccypcKFsnIl1ccyp7XCRcdysiO2k6MTAxO3M6MzE6IiFlcmVnXChbJyJdXF5cKHVuc2FmZV9yYXdcKVw/XCQiO2k6MTAyO3M6MzU6IlwkYmFzZV9kb21haW5ccyo9XHMqZ2V0X2Jhc2VfZG9tYWluIjtpOjEwMztzOjk6InNleHNleHNleCI7aToxMDQ7czoyMzoiXCt1bmlvblwrc2VsZWN0XCswLDAsMCwiO2k6MTA1O3M6Mzc6ImNvbmNhdFwoMHgyMTdlLHBhc3N3b3JkLDB4M2EsdXNlcm5hbWUiO2k6MTA2O3M6MzQ6Imdyb3VwX2NvbmNhdFwoMHgyMTdlLHBhc3N3b3JkLDB4M2EiO2k6MTA3O3M6NTc6IlwqL1xzKlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aToxMDg7czo4OiJhYmFrby9BTyI7aToxMDk7czo0ODoiaWZcKFxzKnN0cnBvc1woXHMqXCR2YWx1ZVxzKixccypcJG1hc2tccypcKVxzKlwpIjtpOjExMDtzOjEwNjoidW5saW5rXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXXswLDF9L2Fzc2V0cy9jYWNoZS90ZW1wL0ZpbGVTZXR0aW5ncyI7aToxMTE7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MTEyO3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MTEzO3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjExNDtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aToxMTU7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjExNjtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MTE3O3M6Mjc6InN0cmxlblwoXHMqXCRwYXRoVG9Eb3JccypcKSI7aToxMTg7czo2NDoiaXNzZXRcKFxzKlwkX0NPT0tJRVxbXHMqbWQ1XChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfSE9TVCI7aToxMTk7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjEyMDtzOjg0OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD1bJyJdXC5cJHBvc3RcW1snIl17MCwxfWlkWyciXXswLDF9XF0iO2k6MTIxO3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6MTIyO3M6OToiTDNaaGNpOTNkIjtpOjEyMztzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aToxMjQ7czo0NDoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL1x3XSs/XHMqLFxzKjA0MDQiO2k6MTI1O3M6NDQ6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9cd10rP1xzKixccyowNzU1IjtpOjEyNjtzOjQyOiJAdW1hc2tcKFxzKjA3NzdccyomXHMqflxzKlwkZmlsZXBlcm1pc3Npb24iO2k6MTI3O3M6MjM6IlsnIl1ccypcfFxzKi9iaW4vc2hbJyJdIjtpOjEyODtzOjE2OiI7XHMqL2Jpbi9zaFxzKi1pIjtpOjEyOTtzOjQxOiJpZlxzKlwoZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aToxMzA7czoyNjoiPVxzKlsnIl1zZW5kbWFpbFxzKi10XHMqLWYiO2k6MTMxO3M6MTU6Ii90bXAvdG1wLXNlcnZlciI7aToxMzI7czoxNToiL3RtcC9cLklDRS11bml4IjtpOjEzMztzOjI5OiJleGVjXChccypbJyJdL2Jpbi9zaFsnIl1ccypcKSI7aToxMzQ7czoyNzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzIjtpOjEzNTtzOjMzOiJ0b3VjaFxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MTM2O3M6NDk6IkB0b3VjaFxzKlwoXHMqXCRjdXJmaWxlXHMqLFxzKlwkdGltZVxzKixccypcJHRpbWUiO2k6MTM3O3M6MTg6Ii1cKi1ccypjb25mXHMqLVwqLSI7aToxMzg7czo0NDoib3BlblxzKlwoXHMqTVlGSUxFXHMqLFxzKlsnIl1ccyo+XHMqdGFyXC50bXAiO2k6MTM5O3M6NzQ6IlwkcmV0ID0gXCR0aGlzLT5fZGItPnVwZGF0ZU9iamVjdFwoIFwkdGhpcy0+X3RibCwgXCR0aGlzLCBcJHRoaXMtPl90Ymxfa2V5IjtpOjE0MDtzOjE5OiJkaWVcKFxzKlsnIl1ubyBjdXJsIjtpOjE0MTtzOjU0OiJzdWJzdHJcKFxzKlwkcmVzcG9uc2VccyosXHMqXCRpbmZvXFtccypbJyJdaGVhZGVyX3NpemUiO2k6MTQyO3M6MTA4OiJpZlwoXHMqIXNvY2tldF9zZW5kdG9cKFxzKlwkc29ja2V0XHMqLFxzKlwkZGF0YVxzKixccypzdHJsZW5cKFxzKlwkZGF0YVxzKlwpXHMqLFxzKjBccyosXHMqXCRpcFxzKixccypcJHBvcnQiO2k6MTQzO3M6NTA6IjxpbnB1dFxzK3R5cGU9c3VibWl0XHMrdmFsdWU9VXBsb2FkXHMqLz5ccyo8L2Zvcm0+IjtpOjE0NDtzOjU4OiJyb3VuZFxzKlwoXHMqXChccypcJHBhY2tldHNccypcKlxzKjY1XClccyovXHMqMTAyNFxzKixccyoyIjtpOjE0NTtzOjU3OiJAZXJyb3JfcmVwb3J0aW5nXChccyowXHMqXCk7XHMqaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCQiO2k6MTQ2O3M6MzA6ImVsc2Vccyp7XHMqZWNob1xzKlsnIl1mYWlsWyciXSI7aToxNDc7czo1MToidHlwZT1bJyJdc3VibWl0WyciXVxzKnZhbHVlPVsnIl1VcGxvYWQgZmlsZVsnIl1ccyo+IjtpOjE0ODtzOjM3OiJoZWFkZXJcKFxzKlsnIl1Mb2NhdGlvbjpccypcJGxpbmtbJyJdIjtpOjE0OTtzOjMxOiJlY2hvXHMqWyciXTxiPlVwbG9hZDxzcz5TdWNjZXNzIjtpOjE1MDtzOjQzOiJuYW1lPVsnIl11cGxvYWRlclsnIl1ccytpZD1bJyJddXBsb2FkZXJbJyJdIjtpOjE1MTtzOjIxOiItSS91c3IvbG9jYWwvYmFuZG1haW4iO2k6MTUyO3M6MjQ6InVubGlua1woXHMqX19GSUxFX19ccypcKSI7aToxNTM7czo1NjoibWFpbFwoXHMqXCRhcnJcW1snIl10b1snIl1cXVxzKixccypcJGFyclxbWyciXXN1YmpbJyJdXF0iO2k6MTU0O3M6OTc6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVx3K1snIl1cXVwpXClccyp7XHMqXCRcdytccyo9XHMqXCRfUkVRVUVTVFxbWyciXVx3K1snIl1cXTtccypleGl0XChcKTsiO2k6MTU1O3M6MTM6Im51bGxfZXhwbG9pdHMiO2k6MTU2O3M6MjY6IjxcP1xzKlwkXHcrXChccypcJFx3K1xzKlwpIjtpOjE1NztzOjk6InRtdmFzeW5nciI7aToxNTg7czoxMjoidG1oYXBiemNlcmZmIjtpOjE1OTtzOjEzOiJvbmZyNjRfcXJwYnFyIjtpOjE2MDtzOjE0OiJbJyJdbmZmcmVnWyciXSI7aToxNjE7czo5OiJmZ2VfZWJnMTMiO2k6MTYyO3M6NzoiY3VjdmFzYiI7aToxNjM7czoxNDoiWyciXWZsZmdyelsnIl0iO2k6MTY0O3M6MTI6IlsnIl1yaW55WyciXSI7aToxNjU7czo5OiJldGFsZm5pemciO2k6MTY2O3M6MTI6InNzZXJwbW9jbnV6ZyI7aToxNjc7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToxNjg7czoxNDoiWyciXXRyZXNzYVsnIl0iO2k6MTY5O3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjE3MDtzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MTcxO3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjE3MjtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTczO3M6MjI6IkBcJFx3K1woXHMqXCRcdytccypcKTsiO2k6MTc0O3M6NDg6InBhcnNlX3F1ZXJ5X3N0cmluZ1woXHMqXCRFTlZ7XHMqWyciXVFVRVJZX1NUUklORyI7aToxNzU7czozMToiZXZhbFxzKlwoXHMqbWJfY29udmVydF9lbmNvZGluZyI7aToxNzY7czoyNDoiXClccyp7XHMqcGFzc3RocnVcKFxzKlwkIjtpOjE3NztzOjE1OiJIVFRQX0FDQ0VQVF9BU0UiO2k6MTc4O3M6MjE6ImZ1bmN0aW9uXHMqQ3VybEF0dGFjayI7aToxNzk7czoxODoiQHN5c3RlbVwoXHMqWyciXVwkIjtpOjE4MDtzOjIzOiJlY2hvXChccypodG1sXChccyphcnJheSI7aToxODE7czo1NjoiXCRjb2RlPVsnIl0lMXNjcmlwdFxzKnR5cGU9XFxbJyJddGV4dC9qYXZhc2NyaXB0XFxbJyJdJTMiO2k6MTgyO3M6MjI6ImFycmF5XChccypbJyJdJTFodG1sJTMiO2k6MTgzO3M6MTk6ImJ1ZGFrXHMqLVxzKmV4cGxvaXQiO2k6MTg0O3M6ODE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKFxzKlsnIl1cJFx3K1snIl1ccypcKSI7aToxODU7czo5OiJHQUdBTDwvYj4iO2k6MTg2O3M6Mzg6ImV4aXRcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE4NztzOjM3OiJkaWVcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE4ODtzOjM2OiJzZXRfdGltZV9saW1pdFwoXHMqaW50dmFsXChccypcJGFyZ3YiO2k6MTg5O3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToxOTA7czo0MjoiY29ublxzKj1ccypodHRwbGliXC5IVFRQQ29ubmVjdGlvblwoXHMqdXJpIjtpOjE5MTtzOjM2OiJpZlxzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9Y2htb2Q3NzciO2k6MTkyO3M6MjY6IjxcP1xzKmVjaG9ccypcJGNvbnRlbnQ7XD8+IjtpOjE5MztzOjY0OiJcJHVybFxzKlwuPVxzKlsnIl1cP1x3Kz1bJyJdXHMqXC5ccypcJF9HRVRcW1xzKlsnIl1cdytbJyJdXHMqXF07IjtpOjE5NDtzOjk4OiJjb3B5XChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRfUE9TVCI7aToxOTU7czoxMDU6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVx3K1snIl17MCwxfVxzKlxdXFtbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxdXFtccypcJGlccypcXSI7aToxOTY7czozMjoiZG5zX2dldF9yZWNvcmRcKFxzKlwkZG9tYWluXHMqXC4iO2k6MTk3O3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MTk4O3M6MjQ6Im5zbG9va3VwXC5leGVccyotdHlwZT1NWCI7aToxOTk7czoxMjoibmV3XHMqTUN1cmw7IjtpOjIwMDtzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToyMDE7czo0MDoiZnB1dHNcKFwkZnAsXHMqWyciXUlQOlxzKlwkaXBccyotXHMqREFURSI7aToyMDI7czoyODoiY2htb2RcKFxzKl9fRElSX19ccyosXHMqMDQwMCI7aToyMDM7czo0MDoiQ29kZU1pcnJvclwuZGVmaW5lTUlNRVwoXHMqWyciXXRleHQvbWlyYyI7aToyMDQ7czo0MzoiXF1ccypcKVxzKlwuXHMqWyciXVxcblw/PlsnIl1ccypcKVxzKlwpXHMqeyI7aToyMDU7czo2NzoiXCRnenBccyo9XHMqXCRiZ3pFeGlzdFxzKlw/XHMqQGd6b3BlblwoXCR0bXBmaWxlLFxzKlsnIl1yYlsnIl1ccypcKSI7aToyMDY7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjIwNztzOjY0OiJcJF9QT1NUXFtbJyJdezAsMX1hY3Rpb25bJyJdezAsMX1cXVxzKj09XHMqWyciXWdldF9hbGxfbGlua3NbJyJdIjtpOjIwODtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToyMDk7czo0MToiY2htb2RcKFwkZmlsZS0+Z2V0UGF0aG5hbWVcKFwpXHMqLFxzKjA3NzciO2k6MjEwO3M6NjM6IlwkX1BPU1RcW1snIl17MCwxfXRwMlsnIl17MCwxfVxdXHMqXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToyMTE7czo5OToiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFxzKlsnIl1cdytbJyJdXHMqXCk7XHMqZXhpdFwoXHMqXCk7IjtpOjIxMjtzOjMxOiI9PlxzKkBcJGYyXChfX0ZJTEVfX1xzKixccypcJGYxIjtpOjIxMztzOjUxOiJldmFsXChccypcdytcKFxzKlwkXHcrXHMqLFxzKlwkXHcrXHMqXClccypcKTtccypcPz4iO2k6MjE0O3M6Mzc6ImlmXHMqXChccyppc19jcmF3bGVyMVwoXHMqXClccypcKVxzKnsiO2k6MjE1O3M6NDg6IlwkZWNob18xXC5cJGVjaG9fMlwuXCRlY2hvXzNcLlwkZWNob180XC5cJGVjaG9fNSI7aToyMTY7czozNToiZmlsZV9nZXRfY29udGVudHNcKFxzKl9fRklMRV9fXHMqXCkiO2k6MjE3O3M6ODM6IkBcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypAdXJsZW5jb2RlXChccypcJF9QT1NUIjtpOjIxODtzOjc1OiJcJEdMT0JBTFNcW1snIl1cdytbJyJdXF1cW1wkR0xPQkFMU1xbWyciXVx3K1snIl1cXVxbXGQrXF1cKHJvdW5kXChcZCtcKVwpXF0iO2k6MjE5O3M6MjU6ImZ1bmN0aW9uXHMrZXJyb3JfNDA0XChcKXsiO2k6MjIwO3M6Njg6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1wZXJsIjtpOjIyMTtzOjcwOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcHl0aG9uIjtpOjIyMjtzOjYzOiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbWyciXVx3K1snIl1cXVwpXClccyp7XHMqZWNob1xzKlsnIl1va1snIl0iO2k6MjIzO3M6Mzk6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkX0dFVFxbXHMqWyciXWNweSI7aToyMjQ7czozNToiaHR0cDovLy4rPy8uKz9cLnBocFw/YT1cZCsmYz1cdysmcz0iO2k6MjI1O3M6MTY6ImZ1bmN0aW9uXHMrd3NvRXgiO2k6MjI2O3M6NTE6ImZvcmVhY2hcKFxzKlwkdG9zXHMqYXNccypcJHRvXClccyp7XHMqbWFpbFwoXHMqXCR0byI7aToyMjc7czoxMDI6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChbJyJdaHR0cDovLy4rP1wuanBnWyciXVwpO1xzKmV4aXRcKFwpOyI7aToyMjg7czoxMjoiPFw/PVwkY2xhc3M7IjtpOjIyOTtzOjUwOiI8aW5wdXRccyp0eXBlPSJmaWxlIlxzKnNpemU9IlxkKyJccypuYW1lPSJ1cGxvYWQiPiI7aToyMzA7czoxMTA6IlwkbWVzc2FnZXNcW1xdXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX11c2VyZmlsZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF1cW1xzKlwkaVxzKlxdIjtpOjIzMTtzOjU1OiI8aW5wdXRccyp0eXBlPVsnIl1maWxlWyciXVxzKm5hbWU9WyciXXVzZXJmaWxlWyciXVxzKi8+IjtpOjIzMjtzOjEzOiJEZXZhcnRccytIVFRQIjtpOjIzMztzOjU3OiJAXCR7XHMqXHcrXHMqfVwoXHMqWyciXVsnIl1ccyosXHMqXCR7XHMqXHcrXHMqfVwoXHMqXCRcdysiO2k6MjM0O3M6NjI6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF1cKFxzKlwkXHcrXFtccypcJFx3K1xdIjtpOjIzNTtzOjUzOiJlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccypcJHVybFxzKj1ccypbJyJdaHR0cDovLyI7aToyMzY7czozODoiXCRcdytcW1xzKlxkK1xzKi5ccypcZCtccypcXVwoXHMqXHcrXCgiO2k6MjM3O3M6ODA6IlwkXHcrPVsnIl1odHRwOi8vLis/WyciXTtccypcJFx3Kz1mb3BlblwoXCRcdyssWyciXXJbJyJdXCk7XHMqcmVhZGZpbGVcKFwkXHcrXCk7IjtpOjIzODtzOjc1OiJhcnJheVwoXHMqWyciXTwhLS1bJyJdXHMqXC5ccyptZDVcKFxzKlwkcmVxdWVzdF91cmxccypcLlxzKnJhbmRcKFxkKyxccypcZCsiO2k6MjM5O3M6MTQ6Indzb0hlYWRlclxzKlwoIjtpOjI0MDtzOjY5OiJlY2hvXChbJyJdPGZvcm0gbWV0aG9kPVsnIl1wb3N0WyciXVxzKmVuY3R5cGU9WyciXW11bHRpcGFydC9mb3JtLWRhdGEiO2k6MjQxO3M6NDM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8iO2k6MjQyO3M6NTg6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjQzO3M6NDA6Im1haWxcKFwkdG9ccyosXHMqWyciXS4rP1snIl1ccyosXHMqXCR1cmwiO2k6MjQ0O3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToyNDU7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6MjQ2O3M6Mzg6ImVsc2VpZlwoXHMqXCRzcWx0eXBlXHMqPT1ccypbJyJdc3FsaXRlIjtpOjI0NztzOjE5OiI9WyciXVwpXHMqXCk7XHMqXD8+IjtpOjI0ODtzOjI0OiJlY2hvXHMrYmFzZTY0X2RlY29kZVwoXCQiO2k6MjQ5O3M6MzA6IlwjXHcrXCMuKz88L3NjcmlwdD4uKz9cIy9cdytcIyI7aToyNTA7czozNDoiZnVuY3Rpb25ccytfX2ZpbGVfZ2V0X3VybF9jb250ZW50cyI7aToyNTE7czoxNDoiZXZhbFwoXHMqXCRcdysiO2k6MjUyO3M6NDQ6IlwkZlxzKj1ccypcJGZcZCtcKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkXHcrIjtpOjI1MztzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToyNTQ7czoyOToiQ1VSTE9QVF9VUkxccyosXHMqWyciXXNtdHA6Ly8iO2k6MjU1O3M6Nzc6IjxoZWFkPlxzKjxzY3JpcHQ+XHMqd2luZG93XC50b3BcLmxvY2F0aW9uXC5ocmVmPVsnIl0uKz9ccyo8L3NjcmlwdD5ccyo8L2hlYWQ+IjtpOjI1NjtzOjUwOiJcJFx3K1xzKj1ccypmb3BlblwoXHMqWyciXVx3K1wucGhwWyciXVxzKixccypbJyJddyI7aToyNTc7czoxNjoiQGFzc2VydFwoXHMqWyciXSI7aToyNTg7czo3MjoiXCRcdys9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1kb1snIl1ccypcXTtccyppbmNsdWRlIjtpOjI1OTtzOjU3OiJlY2hvXHMrXCRcdys7bWtkaXJcKFxzKlsnIl1cdytbJyJdXHMqXCk7ZmlsZV9wdXRfY29udGVudHMiO2k6MjYwO3M6NjE6IlwkZnJvbVxzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWZyb20iO2k6MjYxO3M6MTk6Ij1ccyp4ZGlyXChccypcJHBhdGgiO2k6MjYyO3M6MjA6IlwkX1x3K1woXHMqXCk7XHMqXD8+IjtpOjI2MztzOjEwOiJ0YXJccystemNDIjtpOjI2NDtzOjgzOiJlY2hvXHMrc3RyX3JlcGxhY2VcKFxzKlsnIl1cW1BIUF9TRUxGXF1bJyJdXHMqLFxzKmJhc2VuYW1lXChcJF9TRVJWRVJcW1snIl1QSFBfU0VMRiI7aToyNjU7czozMDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkXHcrIjtpOjI2NjtzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjI2NztzOjM1OiJocmVmPVsnIl08XD9waHBccytlY2hvXHMrXCRjdXJfcGF0aCI7aToyNjg7czozMzoiPVxzKmVzY191cmxcKFxzKnNpdGVfdXJsXChccypbJyJdIjtpOjI2OTtzOjg1OiJeXHMqPFw/cGhwXHMqaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqWyciXVxzKlwuXHMqWyciXVxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI3MDtzOjE0OiI8dGl0bGU+XHMqaXZueiI7aToyNzE7czo2MzoiXlxzKjxcP3BocFxzKmhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI3MjtzOjYxOiJnZXRfdXNlcnNcKFxzKmFycmF5XChccypbJyJdcm9sZVsnIl1ccyo9PlxzKlsnIl1hZG1pbmlzdHJhdG9yIjtpOjI3MztzOjY1OiJcJHRvXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJddG9fYWRkcmVzcyI7aToyNzQ7czoxOToiaW1hcF9oZWFkZXJpbmZvXChcJCI7aToyNzU7czozNjoiXCRcdytcW1xzKl9cdytcKFxzKlxkK1xzKlwpXHMqXF1ccyo9IjtpOjI3NjtzOjM0OiJldmFsXChccypbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoIjtpOjI3NztzOjM1OiJiZWdpblxzK21vZDpccytUaGFua3Nccytmb3Jccytwb3N0cyI7aToyNzg7czoyMToiWyciXVxzKlxeXHMqXCRcdytccyo7IjtpOjI3OTtzOjM1OiJcJFx3K1xzKlwuXHMqXCRcdytccypcXlxzKlwkXHcrXHMqOyI7aToyODA7czoxMDA6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVx3K1snIl1cXVwpXHMqJiZccyptZDVcKFwkX1JFUVVFU1RcW1snIl17MCwxfVx3K1snIl17MCwxfVxdXClccyo9PVxzKlsnIl0iO2k6MjgxO3M6MTI6Ilwud3d3Ly86cHR0aCI7aToyODI7czo2MzoiJTYzJTcyJTY5JTcwJTc0JTJFJTczJTcyJTYzJTNEJTI3JTY4JTc0JTc0JTcwJTNBJTJGJTJGJTczJTZGJTYxIjtpOjI4MztzOjI3OiJ3cC1vcHRpb25zXC5waHBccyo+XHMqRXJyb3IiO2k6Mjg0O3M6ODk6InN0cl9yZXBsYWNlXChhcnJheVwoWyciXWZpbHRlclN0YXJ0WyciXSxbJyJdZmlsdGVyRW5kWyciXVwpLFxzKmFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqIjtpOjI4NTtzOjM3OiJmaWxlX2dldF9jb250ZW50c1woX19GSUxFX19cKSxcJG1hdGNoIjtpOjI4NjtzOjMwOiJ0b3VjaFwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6Mjg3O3M6MjE6Ilx8Ym90XHxzcGlkZXJcfHdnZXQvaSI7aToyODg7czo1Mjoic3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXSxcdytcLlsnIl08L2JvZHk+WyciXSxcJCI7aToyODk7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aToyOTA7czo3MDoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFx3K1xzKlwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRcdytccypcKSI7aToyOTE7czoxNzg6Ij1ccyptYWlsXChccypzdHJpcHNsYXNoZXNcKFxzKlwkX1BPU1RcW1snIl17MCwxfVx3K1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1cdytbJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9XHcrWyciXXswLDF9XF0iO2k6MjkyO3M6MTIzOiI9XHMqbWFpbFwoXHMqXCRfUE9TVFxbWyciXXswLDF9XHcrWyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9XHcrWyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9XHcrWyciXXswLDF9XF0iO2k6MjkzO3M6MTQ6IkxpYlhtbDJJc0J1Z2d5IjtpOjI5NDtzOjk6Im1hYWZccyt5YSI7aToyOTU7czoyNDoiZWNobyBcdytccypcKFsnIl1odHRwOi8vIjtpOjI5NjtzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6Mjk3O3M6MTI6ImBjaGVja3N1ZXhlYyI7aToyOTg7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjI5OTtzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6MzAwO3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aTozMDE7czozNzoiPVxzKlsnIl1waHBfdmFsdWVccythdXRvX3ByZXBlbmRfZmlsZSI7aTozMDI7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MzAzO3M6MzY6ImZvcGVuXChccypcJFx3K1xzKlwuXHMqWyciXS93cC1hZG1pbiI7aTozMDQ7czoyMjoicmV0dXJuXHMqWyciXS92YXIvd3d3LyI7aTozMDU7czoxMjY6IlwkXHcrXHMqe1xzKlxkK1xzKn1cLlwkXHcrXHMqe1xzKlxkK1xzKn1cLlwkXHcrXHMqe1xzKlxkK1xzKn1cLlwkXHcrXHMqe1xzKlxkK1xzKn1cLlwkXHcrXHMqe1xzKlxkK1xzKn1cLlwkXHcrXHMqe1xzKlxkK1xzKn1cLiI7aTozMDY7czoxNjoidGFncy9cJDYvXCQ0L1wkNyI7aTozMDc7czozMDoic3RyX3JlcGxhY2VcKFxzKlsnIl1cLmh0YWNjZXNzIjtpOjMwODtzOjMzOiJmdW5jdGlvblxzK19cZCtcKFxzKlwkXHcrXHMqXCl7XCQiO2k6MzA5O3M6MjE6ImV4cGxvZGVcKFxcWyciXTt0ZXh0OyI7aTozMTA7czo5Mzoic3Vic3RyXChccypcJFx3K1xzKixccypcZCtccyosXHMqXGQrXHMqXCk7XHMqXCRcdytccyo9XHMqcHJlZ19yZXBsYWNlXChccypcJFx3K1xzKixccypzdHJ0clwoIjtpOjMxMTtzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6MzEyO3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTozMTM7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aTozMTQ7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6MzE1O3M6MTU6Ik11c3RAZkBccytTaGVsbCI7aTozMTY7czozNDoiZXZhbFwoXHMqXCRcdytcKFxzKlwkXHcrXChccypcJFx3KyI7aTozMTc7czozNDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aTozMTg7czo0MDoic3RyX3JlcGxhY2VcKFsnIl1cLmh0YWNjZXNzWyciXVxzKixccypcJCI7aTozMTk7czozMzoiPVxzKkAqZ3ppbmZsYXRlXChccypzdHJyZXZcKFxzKlwkIjtpOjMyMDtzOjI0OiJcJFx3Kz1bJyJdL2hvbWUvXHcrL1x3Ky8iO2k6MzIxO3M6MjI6ImdcKFxzKlsnIl1GaWxlc01hblsnIl0iO2k6MzIyO3M6Mjg6InN0cl9yZXBsYWNlXChbJyJdL1w/YW5kclsnIl0iO2k6MzIzO3M6MTU0OiJcJFx3K1xzKj1ccypcJF9SRVFVRVNUXFtbJyJdezAsMX1cdytbJyJdezAsMX1cXTtccypcJFx3K1xzKj1ccyphcnJheVwoXHMqXCRfUkVRVUVTVFxbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF1ccypcKTtccypcJFx3K1xzKj1ccyphcnJheV9maWx0ZXJcKFxzKlwkIjtpOjMyNDtzOjc4OiJcJFx3K1xzKlwuPVxzKlwkXHcre1xkK31ccypcLlxzKlwkXHcre1xkK31ccypcLlxzKlwkXHcre1xkK31ccypcLlxzKlwkXHcre1xkK30iO2k6MzI1O3M6NzQ6InN0cnBvc1woXCRsLFsnIl1Mb2NhdGlvblsnIl1cKSE9PWZhbHNlXHxcfHN0cnBvc1woXCRsLFsnIl1TZXQtQ29va2llWyciXVwpIjtpOjMyNjtzOjk3OiJhZG1pbi9bJyJdLFsnIl1hZG1pbmlzdHJhdG9yL1snIl0sWyciXWFkbWluMS9bJyJdLFsnIl1hZG1pbjIvWyciXSxbJyJdYWRtaW4zL1snIl0sWyciXWFkbWluNC9bJyJdIjtpOjMyNztzOjE1OiJbJyJdY2hlY2tzdWV4ZWMiO2k6MzI4O3M6NTU6ImlmXHMqXChccypcJHRoaXMtPml0ZW0tPmhpdHNccyo+PVsnIl1cZCtbJyJdXClccyp7XHMqXCQiO2k6MzI5O3M6NDc6ImV4cGxvZGVcKFsnIl1cXG5bJyJdLFxzKlwkX1BPU1RcW1snIl11cmxzWyciXVxdIjtpOjMzMDtzOjk0OiJpZlwoaW5pX2dldFwoWyciXWFsbG93X3VybF9mb3BlblsnIl1cKVxzKj09XHMqMVwpXHMqe1xzKlwkXHcrXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChcJFx3K1wpIjtpOjMzMTtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6MzMyO3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjMzMztzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6MzM0O3M6MjE6ImluY2x1ZGVcKFxzKlsnIl0vdG1wLyI7aTozMzU7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTozMzY7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjMzNztzOjEwOiJkZWtjYWhbJyJdIjtpOjMzODtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTozMzk7czoxMzoiPT1bJyJdXClccypcLiI7aTozNDA7czo4MzoiaWZccypcKFxzKlwoXHMqXCRcdytccyo9XHMqc3RycnBvc1woXCRcdytccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6MzQxO3M6MTIzOiJcJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFx3K1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFx3K1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFx3KywiO2k6MzQyO3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTozNDM7czo0OToiQCpmaWxlX2dldF9jb250ZW50c1woQCpiYXNlNjRfZGVjb2RlXChAKnVybGRlY29kZSI7aTozNDQ7czoxNToiXCR7XHcrfVwoXHMqXCk7IjtpOjM0NTtzOjYwOiJzdWJzdHJcKHNwcmludGZcKFsnIl0lb1snIl0sXHMqZmlsZXBlcm1zXChcJGZpbGVcKVwpLFxzKi00XCkiO2k6MzQ2O3M6MzU6IlwkXHcrXChbJyJdWyciXVxzKixccypldmFsXChcJFx3K1wpIjtpOjM0NztzOjE2OiJ3c29TZWNQYXJhbVxzKlwoIjtpOjM0ODtzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6MzQ5O3M6NTc6ImNvcHlcKFxzKlsnIl1odHRwOi8vLis/XC50eHRbJyJdXHMqLFxzKlsnIl1cdytcLnBocFsnIl1cKSI7aTozNTA7czoyODoiXCRzZXRjb29rXHMqXCk7c2V0Y29va2llXChcJCI7aTozNTE7czo0OTI6IkAqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoQCpcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChAKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKCI7aTozNTI7czo0MToiXC5ccypiYXNlNjRfZGVjb2RlXChccypcJGluamVjdFxzKlwpXHMqXC4iO2k6MzUzO3M6Mzk6IihjaHJcKFtcc1x3XCRcXlwrXC1cKi9dK1wpXHMqXC5ccyopezQsfSI7aTozNTQ7czo0MjoiPVxzKkAqZnNvY2tvcGVuXChccypcJGFyZ3ZcW1xkK1xdXHMqLFxzKjgwIjtpOjM1NTtzOjM1OiJcLlwuL1wuXC4vZW5naW5lL2RhdGEvZGJjb25maWdcLnBocCI7aTozNTY7czo4NToicmVjdXJzZV9jb3B5XChccypcJHNyY1xzKixccypcJGRzdFxzKlwpO1xzKmhlYWRlclwoXHMqWyciXWxvY2F0aW9uOlxzKlwkZHN0WyciXVxzKlwpOyI7aTozNTc7czoxNzoiR2FudGVuZ2Vyc1xzK0NyZXciO2k6MzU4O3M6MTIzOiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHMqXHcrXHMqWyciXXswLDF9XF1cKFxzKlsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypcdysiO2k6MzU5O3M6MzA6ImZ3cml0ZVwoXCRcdytccyosXHMqWyciXTxcP3BocCI7aTozNjA7czo1NjoiQCpjcmVhdGVfZnVuY3Rpb25cKFxzKlsnIl1bJyJdXHMqLFxzKkAqZmlsZV9nZXRfY29udGVudHMiO2k6MzYxO3M6ODg6IlxdXChbJyJdXCRfWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF0iO2k6MzYyO3M6Mzk6ImlmXHMqXChccyppc3NldFwoXHMqXCRfR0VUXFtccypbJyJdcGluZyI7aTozNjM7czozMDoicmVhZF9maWxlXChccypbJyJdZG9tYWluc1wudHh0IjtpOjM2NDtzOjI2OiJldmFsXChccypbJyJde1xzKlwkXHcrXHMqfSI7aTozNjU7czo4ODoiaWZccypcKFxzKmZpbGVfZXhpc3RzXChccypcJFx3K1xzKlwpXHMqXClccyp7XHMqY2htb2RcKFxzKlwkXHcrXHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aTozNjY7czoxMToiPT1bJyJdXClcKTsiO2k6MzY3O3M6NDU6IlwkXHcrPXVybGRlY29kZVwoWyciXS4rP1snIl1cKTtpZlwocHJlZ19tYXRjaCI7aTozNjg7czo1MDoiXCRcdytccyo9XHMqZGVjcnlwdF9TT1woXHMqXCRcdytccyosXHMqWyciXVx3K1snIl0iO2k6MzY5O3M6ODU6Ij1ccyptYWlsXChccypiYXNlNjRfZGVjb2RlXChccypcJFx3K1xbXGQrXF1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJFx3K1xbXGQrXF0iO2k6MzcwO3M6MjY6ImV2YWxcKFxzKlsnIl1yZXR1cm5ccytldmFsIjtpOjM3MTtzOjg0OiI9XHMqYmFzZTY0X2VuY29kZVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1cdytbJyJdXF1cKTtccypoZWFkZXIiO2k6MzcyO3M6MTA3OiJAaW5pX3NldFwoWyciXWVycm9yX2xvZ1snIl0sTlVMTFwpO1xzKkBpbmlfc2V0XChbJyJdbG9nX2Vycm9yc1snIl0sMFwpO1xzKmZ1bmN0aW9uXHMrcmVhZF9maWxlXChcJGZpbGVfbmFtZSI7aTozNzM7czozNzoiXCR0ZXh0XHMqPVxzKmh0dHBfZ2V0XChccypbJyJdaHR0cDovLyI7aTozNzQ7czoxMTM6IlwkXHcrXHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRcdytcKTtccypcJFx3K1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvaHRtbD5bJyJdIjtpOjM3NTtzOjEwODoiXCNcdytcI1xzKmlmXChlbXB0eVwoXCRcdytcKVwpXHMqe1xzKlwkXHcrXHMqPVxzKlsnIl08c2NyaXB0Lis/PC9zY3JpcHQ+WyciXTtccyplY2hvXHMrXCRcdys7XHMqfVxzKlwjL1x3K1wjIjtpOjM3NjtzOjU2OiJcLlwkX1JFUVVFU1RcW1xzKlsnIl1cdytbJyJdXHMqXF1ccyosXHMqdHJ1ZVxzKixccyozMDJcKSI7aTozNzc7czo3NDoiPVxzKmNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqbnVsbFxzKixccypcdytcKFxzKlwkXHcrXHMqXClccypcKTtccypcJFx3K1woXCkiO2k6Mzc4O3M6NTQ6Ij1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHBzKjovL1xkK1wuXGQrXC5cZCtcLlxkKyI7aTozNzk7czo1NzoiQ29udGVudC10eXBlOlxzKmFwcGxpY2F0aW9uL3ZuZFwuYW5kcm9pZFwucGFja2FnZS1hcmNoaXZlIjtpOjM4MDtzOjIwOiJzbHVycFx8bXNuYm90XHx0ZW9tYSI7aTozODE7czoyNzoiXCRHTE9CQUxTXFtuZXh0XF1cW1snIl1uZXh0IjtpOjM4MjtzOjE2OToiO0AqXCRcdytcKFxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aTozODM7czoxOToiaGVhZGVyXChfXHcrXChcZCtcKSI7aTozODQ7czoxNTM6ImlmXHMqXChpc3NldFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1cdytbJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVx3K1snIl1cXVwpXHMqPT09XHMqWyciXVx3K1snIl1cKSI7aTozODU7czo3MDoiXC49XHMqY2hyXChcJFx3K1xzKj4+XHMqXChcZCtccypcKlxzKlwoXGQrXHMqLVxzKlwkXHcrXClcKVxzKiZccypcZCtcKSI7aTozODY7czozMToiLT5wcmVwYXJlXChbJyJdU0hPV1xzK0RBVEFCQVNFUyI7aTozODc7czoyMzoic29ja3Nfc3lzcmVhZFwoXCRjbGllbnQiO2k6Mzg4O3M6MjQ6IjwlZXZhbFwoXHMqUmVxdWVzdFwuSXRlbSI7aTozODk7czo2OToiXCRfUE9TVFxbWyciXVx3K1snIl1cXTtccypcJFx3K1xzKj1ccypmb3BlblwoXHMqXCRfR0VUXFtbJyJdXHcrWyciXVxdIjtpOjM5MDtzOjQwOiJ1cmw9WyciXWh0dHA6Ly9zY2FuNHlvdVwubmV0L3JlbW90ZVwucGhwIjtpOjM5MTtzOjQwOiJjYWxsX3VzZXJfZnVuY1woXHMqXCRcdytccyosXHMqXCRcdytcKTt9IjtpOjM5MjtzOjczOiJwcmVnX3JlcGxhY2VcKFxzKlsnIl0vLis/L2VbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjM5MztzOjg2OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0uKz9bJyJdXCk7XHMqXCRcdytccyo9XHMqZm9wZW5cKFxzKlwkXHcrXHMqLFxzKlsnIl13WyciXSI7aTozOTQ7czozOToiaWZcKFxzKlwkXHcrXClccyp7XHMqZXZhbFwoXCRcdytcKTtccyp9IjtpOjM5NTtzOjE3OToiYXJyYXlfbWFwXChccypbJyJdXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl0iO2k6Mzk2O3M6MTQxOiI9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1cdytbJyJdXF07XHMqXCRcdytccyo9XHMqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkXHcrXHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypcJFx3K1xzKlwpXHMqXCkiO2k6Mzk3O3M6NTE6IjxcP1xzKlwkXHcrPVsnIl0uKz9bJyJdO1xzKmhlYWRlclxzKlwoWyciXUxvY2F0aW9uOiI7aTozOTg7czoyNToiPCEtLVwjZXhlY1xzK2NtZFxzKj1ccypcJCI7aTozOTk7czo3MToiaWZcKFxzKnN0cmlwb3NcKFxzKlwkXHcrXHMqLFxzKlsnIl1hbmRyb2lkWyciXVxzKlwpXHMqIT09XHMqZmFsc2VcKVxzKnsiO2k6NDAwO3M6ODA6IlwuPVxzKlsnIl08ZGl2XHMrc3R5bGU9WyciXWRpc3BsYXk6bm9uZTtbJyJdPlsnIl1ccypcLlxzKlwkXHcrXHMqXC5ccypbJyJdPC9kaXY+IjtpOjQwMTtzOjc0OiI9ZmlsZV9leGlzdHNcKFwkXHcrXClcP0BmaWxlbXRpbWVcKFwkXHcrXCk6XCRcdys7QGZpbGVfcHV0X2NvbnRlbnRzXChcJFx3KyI7aTo0MDI7czo0OToiXCRcdytccypcW1xzKlx3K1xzKlxdXChccypcJFx3K1xbXHMqXHcrXHMqXF1ccypcKSI7aTo0MDM7czo3NjoiXCRcdyssWyciXXNsdXJwWyciXVwpXHMqIT09XHMqZmFsc2VccypcfFx8XHMqc3RycG9zXChccypcJFx3KyxbJyJdc2VhcmNoWyciXSI7aTo0MDQ7czozMzoiXCRcdytcKFxzKlwkXHcrXChccypcJFx3K1wpXHMqXCk7IjtpOjQwNTtzOjE3OiJjbGFzc1xzK01DdXJsXHMqeyI7aTo0MDY7czo1NjoiQGluaV9zZXRcKFsnIl1kaXNwbGF5X2Vycm9yc1snIl0sMFwpO1xzKkBlcnJvcl9yZXBvcnRpbmciO2k6NDA3O3M6Njk6ImlmXChccypmaWxlX2V4aXN0c1woXHMqXCRmaWxlcGF0aFxzKlwpXHMqXClccyp7XHMqZWNob1xzK1snIl11cGxvYWRlZCI7aTo0MDg7czozMDoicmV0dXJuXHMrUkM0OjpFbmNyeXB0XChcJGEsXCRiIjtpOjQwOTtzOjMyOiJmdW5jdGlvblxzK2dldEhUVFBQYWdlXChccypcJHVybCI7aTo0MTA7czoyMToiPVxzKnJlcXVlc3RcKFxzKmNoclwoIjtpOjQxMTtzOjQ1OiI7XHMqYXJyYXlfZmlsdGVyXChcJFx3K1xzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6NDEyO3M6MjI4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDEzO3M6MjQxOiJjYWxsX3VzZXJfZnVuY19hcnJheVwoXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKmFycmF5XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjQxNDtzOjg3OiJpZiBcKCEqXCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdXHMqT1JccypcKHN1YnN0clwoXCRfU0VSVkVSXFtbJyJdUkVNT1RFX0FERFIiO2k6NDE1O3M6NTM6InJlbHBhdGh0b2Fic3BhdGhcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQxNjtzOjY4OiJcJGRhdGFcW1snIl1jY19leHBfbW9udGhbJyJdXF1ccyosXHMqc3Vic3RyXChcJGRhdGFcW1snIl1jY19leHBfeWVhciI7aTo0MTc7czozMDoiXCRcdytccyooXFsuezEsNDB9XF0pezEsfVxzKlwoIjtpOjQxODtzOjMzOiJjYWxsX3VzZXJfZnVuY1woXHMqQCp1bmhleFwoXHMqMHgiO2k6NDE5O3M6Mjk6IlwuXC46OlxbXHMqcGhwcm94eVxzKlxdOjpcLlwuIjtpOjQyMDtzOjQ0OiJbJyJdXHMqXC5ccypjaHJcKFxzKlxkKy5cZCtccypcKVxzKlwuXHMqWyciXSI7aTo0MjE7czozMjoicHJlZ19yZXBsYWNlLio/L2VbJyJdXHMqLFxzKlsnIl0iO2k6NDIyO3M6MzU6IlwkXHcrXChcJFx3K1woXCRcdytcKFwkXHcrXChcJFx3K1wpIjtpOjQyMztzOjIzOiJ9ZXZhbFwoYnpkZWNvbXByZXNzXChcJCI7aTo0MjQ7czo1ODoiL3Vzci9sb2NhbC9wc2EvYXBhY2hlL2Jpbi9odHRwZFxzKy1ERlJPTlRQQUdFXHMrLURIQVZFX1NTTCI7aTo0MjU7czo1NzoiaWNvbnZcKGJhc2U2NF9kZWNvZGVcKFsnIl0uKz9bJyJdXClccyosXHMqYmFzZTY0X2RlY29kZVwoIjtpOjQyNjtzOjMzOiI8YnI+WyciXVwucGhwX3VuYW1lXChcKVwuWyciXTxicj4iO2k6NDI3O3M6NDY6IlwpO0BcJFx3K1xbY2hyXChcZCtcKVxdXChcJFx3K1xbY2hyXChcZCtcKVxdXCgiO2k6NDI4O3M6MTA5OiJcYihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQyOTtzOjk1OiJcYihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFsnIl1odHRwOi8vcGFzdGViaW5cLmNvbSI7aTo0MzA7czoxNToiWyciXS9ldGMvcGFzc3dkIjtpOjQzMTtzOjE1OiJbJyJdL3Zhci9jcGFuZWwiO2k6NDMyO3M6MTQ6IlsnIl0vZXRjL2h0dHBkIjtpOjQzMztzOjIwOiJbJyJdL2V0Yy9uYW1lZFwuY29uZiI7aTo0MzQ7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0MzU7czoxNToiMTA5XC4yMzhcLjI0MlwuIjtpOjQzNjtzOjkxOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQzNztzOjY1OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdaW1hZ2VzLyI7aTo0Mzg7czo3MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQCp1cmxlbmNvZGUiO2k6NDM5O3M6NzE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKCpbJyJdY2RccysvdG1wIjtpOjQ0MDtzOjMyNzoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjQ0MTtzOjIzOiIvdmFyL3FtYWlsL2Jpbi9zZW5kbWFpbCI7aTo0NDI7czozMToiXCRcdysgPSBcJFx3K1woWyciXXswLDF9aHR0cDovLyI7aTo0NDM7czoxMzY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5qcGciO2k6NDQ0O3M6MTM2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rP1wuZ2lmIjtpOjQ0NTtzOjEzNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz9cLnBuZyI7aTo0NDY7czoxMDY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz8vW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5wbmciO2k6NDQ3O3M6MTA2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/L1tccyVcLkBcLVwrXChcKS9cd10rP1wuanBnIjtpOjQ0ODtzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLmdpZiI7aTo0NDk7czoxMDY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz8vW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5pY28iO2k6NDUwO3M6MTA4OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fXHMqXClccypcLlxzKlsnIl0vd3AtY29udGVudC91cGxvYWQiO2k6NDUxO3M6Njc6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vdmFyL3d3dy8iO2k6NDUyO3M6NjQ6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vaG9tZS8iO2k6NDUzO3M6MTg5OiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHA6Ly8iO2k6NDU0O3M6MjIxOiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHcrWyciXXswLDF9XF1cKSI7aTo0NTU7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjQ1NjtzOjcyOiJcJFx3Kz1bJyJdW2EtekEtWjAtOS9cK1w9X10rWyciXTtccyplY2hvXHMrYmFzZTY0X2RlY29kZVwoXCRcdytcKTtccypcPz4iO2k6NDU3O3M6NTI6IlwkXHcrLT5fc2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6NDU4O3M6MjQ6IlwkXHcrXHMqPVxzKlsnIl1ldmFsWyciXSI7aTo0NTk7czozMzoiXCRcdytccyo9XHMqWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ2MDtzOjM1OiJcJFx3K1xzKj1ccypbJyJdY3JlYXRlX2Z1bmN0aW9uWyciXSI7aTo0NjE7czoyNjoiXCRcdytccyo9XHMqWyciXWFzc2VydFsnIl0iO2k6NDYyO3M6MzI6IlwkXHcrXHMqPVxzKlsnIl1wcmVnX3JlcGxhY2VbJyJdIjtpOjQ2MztzOjE1NjoiXCRcdytcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFx3K1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkXHcrXFtccypcZCtccypcXVxzKlwuXHMqXCRcdytcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFx3K1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkXHcrXFtccypcZCtccypcXVxzKlwuXHMqIjtpOjQ2NDtzOjEwMDoiXCRcdytcW1xzKlwkXHcrXHMqXF1cW1xzKlwkXHcrXFtccypcZCtccypcXVxzKlwuXHMqXCRcdytcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFx3K1xbXHMqXGQrXHMqXF1ccypcLiI7aTo0NjU7czoyMzoiXCRcdytccypcKFxzKlwkXHcrXHMqXFsiO2k6NDY2O3M6MzM6IlwkXHcrXHMqXChccypcJFx3K1xzKlwoXHMqXCRcdytcWyI7aTo0Njc7czozMDoiXCRcdytccypcKFxzKlwkXHcrXHMqXChccypbJyJdIjtpOjQ2ODtzOjQwOiJcJFx3K1xzKlwoXHMqXCRcdytccypcKFxzKlwkXHcrXHMqXClccyosIjtpOjQ2OTtzOjQ5OiJcJFx3K1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRcdytccypcKVxzKlwpIjtpOjQ3MDtzOjE0NjoiXCRcdytccyo9XHMqXCRcdytcKFsnIl1bJyJdXHMqLFxzKlwkXHcrXChccypcJFx3K1woXHMqWyciXVx3K1snIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRcdytccypcLlxzKlwkXHcrXHMqXC5ccypcJFx3K1xzKlwuXHMqXCRcdytccypcKVxzKlwpXHMqXCkiO2k6NDcxO3M6NzM6IlwkXHcrXHMqPVxzKlsnIl1cJFx3Kz1AXHcrXChbJyJdLis/WyciXVwpO1x3K1woIVwkXHcrXCl7XCRcdys9QFx3K1woXHMqXCkiO2k6NDcyO3M6ODQ6IlwkXHcrXFtccypcZCtccypcXVwoXHMqWyciXVsnIl1ccyosXHMqXCRcdytcW1xzKlxkK1xzKlxdXChccypcJFx3K1xbXHMqXGQrXHMqXF1ccypcKSI7aTo0NzM7czoyMjoiXCRcdytcKFxzKkBcJF9DT09LSUVcWyI7aTo0NzQ7czoxOToiXCRcdytcKFsnIl0uLmVbJyJdLCI7aTo0NzU7czozMDoiQFwkXHcrJiZAXCRcdytcKFwkXHcrLFwkXHcrXCk7Ijt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxNDM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7aToxMjE7czozNjoiXCRlbGVtZW50XFtiXF1cKDBcKSx0aGlzXC50cmFuc2l0aW9uIjtpOjEyMjtzOjMxOiJcJG1ldGhvZFwoXCRyZWxhdGlvblxbJ2l0ZW1OYW1lIjtpOjEyMztzOjM2OiJcJHZlcnNpb25cWzFcXVwpO31lbHNlaWZcKHByZWdfbWF0Y2giO2k6MTI0O3M6MzQ6IlwkY29tbWFuZFwoXCRjb21tYW5kc1xbXCRpZGVudGlmaWUiO2k6MTI1O3M6NDI6IlwkY2FsbGFibGVcKFwkcmF3XFsnY2FsbGJhY2snXF1cKFwkY1wpLFwkYyI7aToxMjY7czo0MjoiXCRlbFxbdmFsXF1cKFwpXCkgXCRlbFxbdmFsXF1cKGRhdGFcW3N0YXRlIjtpOjEyNztzOjQ3OiJcJGVsZW1lbnRcW3RcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb25cKCJhZGRDbGFzcyI7aToxMjg7czozMToiXCk7XCNtaXMnLCcgJyxcJGlucHV0XCk7XCRpbnB1dCI7aToxMjk7czozMToia2lsbCAtOSAnXC5cJHBpZFwpO1wkdGhpcy0+Y2xvcyI7aToxMzA7czozMjoiY2FsbF91c2VyX2Z1bmNcKFwkZmlsdGVyLFwkdmFsdWUiO2k6MTMxO3M6MzM6ImNhbGxfdXNlcl9mdW5jXChcJG9wdGlvbnMsXCRlcnJvciI7aToxMzI7czozNjoiY2FsbF91c2VyX2Z1bmNcKFwkbGlzdGVuZXIsXCRldmVudFwpIjtpOjEzMztzOjY1OiJpZlwoc3RyaXBvc1woXCR1c2VyQWdlbnQsJ0FuZHJvaWQnXCkhPT1mYWxzZVwpe1wkdGhpcy0+bW9iaWxlPXRydSI7aToxMzQ7czo1MzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJGZpbGVcKVwpPT0naW5kZXhcLnBocCdcKXsiO2k6MTM1O3M6NjA6InVybGRlY29kZVwoYmFzZTY0X2RlY29kZVwoXCRpbnB1dFwpXCk7XCRleHBsb2RlQXJyYXk9ZXhwbG9kZSI7aToxMzY7czozNzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJHJldHVyblVyaSI7aToxMzc7czo0NzoidXJsZGVjb2RlXCh1cmxkZWNvZGVcKHN0cmlwY3NsYXNoZXNcKFwkc2VnbWVudHMiO2k6MTM4O3M6NTM6Im1haWxcKFwkdG8sXCRzdWJqZWN0LFwkYm9keSxcJGhlYWRlclwpO31lbHNle1wkcmVzdWx0IjtpOjEzOTtzOjM4OiI9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpO1wkdGhpcyI7aToxNDA7czo0MjoiPWluaV9nZXRcKCdkaXNhYmxlX2Z1bmN0aW9ucydcKTtpZlwoIWVtcHR5IjtpOjE0MTtzOjM5OiJldmFsXChcJHBocENvZGVcKTt9ZWxzZXtjbGFzc19hbGlhc1woXCQiO2k6MTQyO3M6NDg6ImV2YWxcKFwkc3RyXCk7fXB1YmxpYyBmdW5jdGlvbiBjb3VudE1lbnVDaGlsZHJlbiI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxNDk6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfUkVGRVJFUlsnIl1ccypcXVxzKixccypbJyJddHJ1c3RsaW5rXC5ydSI7aToxNjtzOjMyOiJcJFx3K1xzKj1ccypuZXdccypCU1woXCk7XHMqZWNobyI7aToxNztzOjM3OiJjbGFzc1xzK0NNX2NsaWVudFxzK2V4dGVuZHNccypDTV9iYXNlIjtpOjE4O3M6MTk6Im5ld1xzK0NNX2NsaWVudFwoXCkiO2k6MTk7czoxNjoidGxfbGlua3NfZGJfZmlsZSI7aToyMDtzOjIwOiJjbGFzc1xzK2xtcF9iYXNlXHMreyI7aToyMTtzOjE1OiJUcnVzdGxpbmtDbGllbnQiO2k6MjI7czoxMzoiLT5ccypTTENsaWVudCI7aToyMztzOjE2NjoiaXNzZXRccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdXHMqXClccyomJlxzKlwoKlxzKlwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyo9PVxzKlsnIl17MCwxfUxNUF9Sb2JvdCI7aToyNDtzOjQzOiJcJGxpbmtzLT5ccypyZXR1cm5fbGlua3NccypcKCpccypcJGxpYl9wYXRoIjtpOjI1O3M6NDQ6IlwkbGlua3NfY2xhc3Nccyo9XHMqbmV3XHMrR2V0X2xpbmtzXHMqXCgqXHMqIjtpOjI2O3M6NTI6IlsnIl17MCwxfVxzKixccypbJyJdezAsMX1cLlsnIl17MCwxfVxzKlwpKlxzKjtccypcPz4iO2k6Mjc7czo3OiJsZXZpdHJhIjtpOjI4O3M6MTA6ImRhcG94ZXRpbmUiO2k6Mjk7czo2OiJ2aWFncmEiO2k6MzA7czo2OiJjaWFsaXMiO2k6MzE7czo4OiJwcm92aWdpbCI7aTozMjtzOjE5OiJjbGFzc1xzK1RXZWZmQ2xpZW50IjtpOjMzO3M6MTg6Im5ld1xzK1NMQ2xpZW50XChcKSI7aTozNDtzOjI0OiJfX2xpbmtmZWVkX2JlZm9yZV90ZXh0X18iO2k6MzU7czoxNjoiX190ZXN0X3RsX2xpbmtfXyI7aTozNjtzOjE4OiJzOjExOiJsbXBfY2hhcnNldCIiO2k6Mzc7czoyMDoiPVxzK25ld1xzK01MQ2xpZW50XCgiO2k6Mzg7czo0NzoiZWxzZVxzK2lmXHMqXChccypcKFxzKnN0cnBvc1woXHMqXCRsaW5rc19pcFxzKiwiO2k6Mzk7czozMzoiZnVuY3Rpb25ccytwb3dlcl9saW5rc19ibG9ja192aWV3IjtpOjQwO3M6MjA6ImNsYXNzXHMrSU5HT1RTQ2xpZW50IjtpOjQxO3M6MTA6Il9fTElOS19fPGEiO2k6NDI7czoyMToiY2xhc3NccytMaW5rcGFkX3N0YXJ0IjtpOjQzO3M6MTM6ImNsYXNzXHMrVE5YX2wiO2k6NDQ7czoyMjoiY2xhc3NccytNRUdBSU5ERVhfYmFzZSI7aTo0NTtzOjE1OiJfX0xJTktfX19fRU5EX18iO2k6NDY7czoyMjoibmV3XHMrVFJVU1RMSU5LX2NsaWVudCI7aTo0NztzOjY0OiJyXC5waHBcP2lkPVx3KyZyZWZlcmVyPSV7SFRUUF9IT1NUfS8le1JFUVVFU1RfVVJJfVxzK1xbUj0zMDIsTFxdIjtpOjQ4O3M6Mzk6IlVzZXItYWdlbnQ6XHMqR29vZ2xlYm90XHMqRGlzYWxsb3c6XHMqLyI7aTo0OTtzOjE4OiJuZXdccytMTE1fY2xpZW50XCgiO2k6NTA7czozNjoiJnJlZmVyZXI9JXtIVFRQX0hPU1R9LyV7UkVRVUVTVF9VUkl9IjtpOjUxO3M6Mjk6IlwucGhwXD9pZD1cJDEmJXtRVUVSWV9TVFJJTkd9IjtpOjUyO3M6MzM6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aTo1MztzOjIzOiJBZGRIYW5kbGVyXHMrcGhwLXNjcmlwdCI7aTo1NDtzOjIzOiJBZGRIYW5kbGVyXHMrY2dpLXNjcmlwdCI7aTo1NTtzOjUyOiJSZXdyaXRlUnVsZVxzK1wuXCpccytpbmRleFwucGhwXD91cmw9XCQwXHMrXFtMLFFTQVxdIjtpOjU2O3M6MTI6InBocGluZm9cKFwpOyI7aTo1NztzOjE1OiJcKG1zaWVcfG9wZXJhXCkiO2k6NTg7czoyMjoiPGgxPkxvYWRpbmdcLlwuXC48L2gxPiI7aTo1OTtzOjI5OiJFcnJvckRvY3VtZW50XHMrNTAwXHMraHR0cDovLyI7aTo2MDtzOjI5OiJFcnJvckRvY3VtZW50XHMrNDAwXHMraHR0cDovLyI7aTo2MTtzOjI5OiJFcnJvckRvY3VtZW50XHMrNDA0XHMraHR0cDovLyI7aTo2MjtzOjQ5OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9VU0VSX0FHRU5UfVxzKlwuXCpuZHJvaWRcLlwqIjtpOjYzO3M6MTAxOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9WyciXXswLDF9SmF2YVNjcmlwdFsnIl17MCwxfT5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovLyI7aTo2NDtzOjk5OiJjaHJccypcKFxzKjEwMVxzKlwpXHMqXC5ccypjaHJccypcKFxzKjExOFxzKlwpXHMqXC5ccypjaHJccypcKFxzKjk3XHMqXClccypcLlxzKmNoclxzKlwoXHMqMTA4XHMqXCkiO2k6NjU7czozMDoiY3VybFwuaGF4eFwuc2UvcmZjL2Nvb2tpZV9zcGVjIjtpOjY2O3M6MTg6Ikpvb21sYV9icnV0ZV9Gb3JjZSI7aTo2NztzOjM0OiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LXdhcC1wcm9maWxlIjtpOjY4O3M6NDI6IlJld3JpdGVDb25kXHMqJXtIVFRQOngtb3BlcmFtaW5pLXBob25lLXVhfSI7aTo2OTtzOjY2OiJSZXdyaXRlQ29uZFxzKiV7SFRUUDpBY2NlcHQtTGFuZ3VhZ2V9XHMqXChydVx8cnUtcnVcfHVrXClccypcW05DXF0iO2k6NzA7czoyNjoic2xlc2hcK3NsZXNoXCtkb21lblwrcG9pbnQiO2k6NzE7czoxNzoidGVsZWZvbm5heWEtYmF6YS0iO2k6NzI7czoxODoiaWNxLWRseWEtdGVsZWZvbmEtIjtpOjczO3M6MjQ6InBhZ2VfZmlsZXMvc3R5bGUwMDBcLmNzcyI7aTo3NDtzOjIwOiJzcHJhdm9jaG5pay1ub21lcm92LSI7aTo3NTtzOjE3OiJLYXphbi9pbmRleFwuaHRtbCI7aTo3NjtzOjUwOiJHb29nbGVib3RbJyJdezAsMX1ccypcKVwpe2VjaG9ccytmaWxlX2dldF9jb250ZW50cyI7aTo3NztzOjI2OiJpbmRleFwucGhwXD9pZD1cJDEmJXtRVUVSWSI7aTo3ODtzOjIwOiJWb2xnb2dyYWRpbmRleFwuaHRtbCI7aTo3OTtzOjM4OiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2lccytcLiI7aTo4MDtzOjE5OiIta2x5Y2gtay1pZ3JlXC5odG1sIjtpOjgxO3M6MTk6ImxtcF9jbGllbnRcKHN0cmNvZGUiO2k6ODI7czoxNzoiL1w/ZG89a2FrLXVkYWxpdC0iO2k6ODM7czoxNDoiL1w/ZG89b3NoaWJrYS0iO2k6ODQ7czoxOToiL2luc3RydWt0c2l5YS1kbHlhLSI7aTo4NTtzOjQzOiJjb250ZW50PSJcZCs7VVJMPWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vIjtpOjg2O3M6NTk6IiU8IS0tXFxzXCpcJG1hcmtlclxcc1wqLS0+XC5cK1w/PCEtLVxcc1wqL1wkbWFya2VyXFxzXCotLT4lIjtpOjg3O3M6Nzk6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKSxcKFwuXCpcKVwkXHMrXCQyXC5waHBcP3Jld3JpdGVfcGFyYW1zPVwkMSZwYWdlX3VybD1cJDIiO2k6ODg7czo0MjoiUmV3cml0ZVJ1bGVccypcKFwuXCtcKVxzKmluZGV4XC5waHBcP3M9XCQwIjtpOjg5O3M6MTg6IlJlZGlyZWN0XHMqaHR0cDovLyI7aTo5MDtzOjQ1OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9pZD1cJDEiO2k6OTE7czo0NDoiUmV3cml0ZVJ1bGVccypcXlwoXC5cKlwpXHMqaW5kZXhcLnBocFw/bT1cJDEiO2k6OTI7czoxOTg6IlxiKHBlcmNvY2V0fGFkZGVyYWxsfHZpYWdyYXxjaWFsaXN8bGV2aXRyYXxrYXVmZW58YW1iaWVufGJsdWVccytwaWxsfGNvY2FpbmV8bWFyaWp1YW5hfGxpcGl0b3J8cGhlbnRlcm1pbnxwcm9bc3pdYWN8c2FuZHlhdWVyfHRyYW1hZG9sfHRyb3loYW1ieXVsdHJhbXx1bmljYXVjYXx2YWxpdW18dmljb2Rpbnx4YW5heHx5cHhhaWVvKVxzK29ubGluZSI7aTo5MztzOjM5OiJSZXdyaXRlUnVsZVxzKlwuXCovXC5cKlxzKlx3K1wucGhwXD9cJDAiO2k6OTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjk1O3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk2O3M6NDI6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/XHcrPSI7aTo5NztzOjMyOiJFcnJvckRvY3VtZW50XHMrNDA0XHMraHR0cDovL3RkcyI7aTo5ODtzOjUxOiJSZXdyaXRlUnVsZVxzK1xeXChcLlwqXClcJFxzK2h0dHA6Ly9cZCtcLlxkK1wuXGQrXC4iO2k6OTk7czo2NzoiPCEtLWNoZWNrOlsnIl1ccypcLlxzKm1kNVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxMDA7czoxODoiUmV3cml0ZUJhc2Vccysvd3AtIjtpOjEwMTtzOjM2OiJTZXRIYW5kbGVyXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6MTAyO3M6NDI6IiV7SFRUUF9VU0VSX0FHRU5UfVxzKyF3aW5kb3dzLW1lZGlhLXBsYXllciI7aToxMDM7czo4MjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfVlhbmRleEJvdCI7aToxMDQ7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfXlhbmRleCI7aToxMDU7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfWdvb2dsZSI7aToxMDY7czo4OiIva3J5YWtpLyI7aToxMDc7czoxMDoiXC5waHBcP1wkMCI7aToxMDg7czo3MToicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpXHMqLFxzKlsnIl1Hb29nbGVib3QiO2k6MTA5O3M6ODA6ImluZGV4XC5waHBcP21haW5fcGFnZT1wcm9kdWN0X2luZm8mcHJvZHVjdHNfaWQ9WyciXVxzKlwuXHMqc3RyX3JlcGxhY2VcKFsnIl1saXN0IjtpOjExMDtzOjMxOiJmc29ja29wZW5cKFxzKlsnIl1zaGFkeWtpdFwuY29tIjtpOjExMTtzOjEwOiJlb2ppZXVcLmNuIjtpOjExMjtzOjIyOiI+XHMqPC9pZnJhbWU+XHMqPFw/cGhwIjtpOjExMztzOjgxOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9cmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKnVybD08XD9waHAiO2k6MTE0O3M6ODI6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1SZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MTE1O3M6Njc6IlwkZmxccyo9XHMqIjxtZXRhIGh0dHAtZXF1aXY9XFwiUmVmcmVzaFxcIlxzK2NvbnRlbnQ9XFwiXGQrO1xzKlVSTD0iO2k6MTE2O3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqeWFuZGV4IjtpOjExNztzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKmdvb2dsZSI7aToxMTg7czo1NzoiT3B0aW9uc1xzK0ZvbGxvd1N5bUxpbmtzXHMrTXVsdGlWaWV3c1xzK0luZGV4ZXNccytFeGVjQ0dJIjtpOjExOTtzOjI4OiJnb29nbGVcfHlhbmRleFx8Ym90XHxyYW1ibGVyIjtpOjEyMDtzOjQxOiJjb250ZW50PVsnIl17MCwxfTE7VVJMPWNnaS1iaW5cLmh0bWxcP2NtZCI7aToxMjE7czoxMjoiYW5kZXhcfG9vZ2xlIjtpOjEyMjtzOjQ0OiJoZWFkZXJcKFxzKlsnIl1SZWZyZXNoOlxzKlxkKztccypVUkw9aHR0cDovLyI7aToxMjM7czo0NToiTW96aWxsYS81XC4wXHMqXChjb21wYXRpYmxlO1xzKkdvb2dsZWJvdC8yXC4xIjtpOjEyNDtzOjUwOiJodHRwOi8vd3d3XC5iaW5nXC5jb20vc2VhcmNoXD9xPVwkcXVlcnkmcHE9XCRxdWVyeSI7aToxMjU7czo0MzoiaHR0cDovL2dvXC5tYWlsXC5ydS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeSI7aToxMjY7czo2MzoiaHR0cDovL3d3d1wuZ29vZ2xlXC5jb20vc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnlcLlsnIl0maGw9XCRsYW5nIjtpOjEyNztzOjM2OiJTZXRIYW5kbGVyXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6MTI4O3M6NDk6ImlmXChzdHJpcG9zXChcJHVhLFsnIl1hbmRyb2lkWyciXVwpXHMqIT09XHMqZmFsc2UiO2k6MTI5O3M6MTUyOiIoc2V4eVxzK2xlc2JpYW5zfGN1bVxzK3ZpZGVvfHNleFxzK3ZpZGVvfEFuYWxccytGdWNrfHRlZW5ccytzZXh8ZnVja1xzK3ZpZGVvfEJlYWNoXHMrTnVkZXx3b21hblxzK3B1c3N5fHNleFxzK3Bob3RvfG5ha2VkXHMrdGVlbnx4eHhccyt2aWRlb3x0ZWVuXHMrcGljKSI7aToxMzA7czo1NjoiaHR0cC1lcXVpdj1bJyJdQ29udGVudC1MYW5ndWFnZVsnIl1ccytjb250ZW50PVsnIl1qYVsnIl0iO2k6MTMxO3M6NTY6Imh0dHAtZXF1aXY9WyciXUNvbnRlbnQtTGFuZ3VhZ2VbJyJdXHMrY29udGVudD1bJyJdY2hbJyJdIjtpOjEzMjtzOjExOiJLQVBQVVNUT0JPVCI7aToxMzM7czozODoiY2xhc3NccytsVHJhbnNtaXRlcntccyp2YXJccypcJHZlcnNpb24iO2k6MTM0O3M6Mjc6IlwkXHcrXHMqPVxzKlsnIl0vdG1wL3NzZXNzXyI7aToxMzU7czo4MToiZmlsZV9nZXRfY29udGVudHNcKGJhc2U2NF9kZWNvZGVcKFwkXHcrXClcLlsnIl1cP1snIl1cLmh0dHBfYnVpbGRfcXVlcnlcKFwkX0dFVFwpIjtpOjEzNjtzOjUwOiJpbmlfc2V0XChbJyJdezAsMX11c2VyX2FnZW50WyciXVxzKixccypbJyJdSlNMSU5LUyI7aToxMzc7czo2MzoiXCRkYi0+cXVlcnlcKFsnIl1TRUxFQ1QgXCogRlJPTSBhcnRpY2xlIFdIRVJFIHVybD1bJyJdXCRyZXF1ZXN0IjtpOjEzODtzOjI0OiI8aHRtbFxzK2xhbmc9WyciXWphWyciXT4iO2k6MTM5O3M6Mzc6InhtbDpsYW5nPVsnIl1qYVsnIl1ccytsYW5nPVsnIl1qYVsnIl0iO2k6MTQwO3M6MTY6Imxhbmc9WyciXWphWyciXT4iO2k6MTQxO3M6MzM6InN0cnBvc1woXCRpbSxbJyJdXFsvVVBEX0NPTlRFTlRcXSI7aToxNDI7czo1OToiPT1ccypbJyJdaW5kZXhcLnBocFsnIl1cKVxzKntccypwcmludFxzK2ZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTQzO3M6MTU6ImNsYXNzXHMrRmF0bGluayI7aToxNDQ7czo0MDoiXCRmPWZpbGVfZ2V0X2NvbnRlbnRzXCgia2V5cy8iXC5cJGtleWZcKSI7aToxNDU7czo1NjoiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXFxcLmh0bWxcJFxzK2luZGV4XC5waHBccytcW25jXF0iO2k6MTQ2O3M6NDU6Im1rZGlyXChbJyJdcGFnZS9bJyJdXC5tYl9zdWJzdHJcKG1kNVwoXCRrZXlcKSI7aToxNDc7czo0NzoiZWxzZWlmIFwoQFwkX0dFVFxbWyciXXBbJyJdXF0gPT0gWyciXWh0bWxbJyJdXCkiO2k6MTQ4O3M6ODg6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVxcL1wkXHMraW5kZXhcLnBocFxzK1Jld3JpdGVSdWxlXHMrXF5yb2JvdHNcLnR4dFwkXHMrcm9ib3RzXC5waHAiO30="));
$g_PhishingSig = unserialize(base64_decode("YTo4OTp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6NTk6IkxvY2F0aW9uOlxzKmh0dHBzOi8vc2VjdXJpdHlcLmdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5IjtpOjcyO3M6NjU6IlwkaXBccyo9XHMqZ2V0ZW52XChccypbJyJdUkVNT1RFX0FERFJbJyJdXHMqXCk7XHMqXCRtZXNzYWdlXHMqXC49IjtpOjczO3M6MTc6ImxvZ2luXC5lYzIxXC5jb20vIjtpOjc0O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTo3NTtzOjM0OiJcJGFkZGRhdGU9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjc2O3M6MzY6IlwkZGF0YW1hc2lpPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NztzOjI3OiJodHRwczovL2FwcGxlaWRcLmFwcGxlXC5jb20iO2k6Nzg7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjgxO3M6NDA6ImJhc2VccytocmVmPVsnIl1odHRwczovL2xvZ2luXC5saXZlXC5jb20iO2k6ODI7czoyNDoiPHRpdGxlPkhvdG1haWxccytBY2NvdW50IjtpOjgzO3M6NDE6IjwhLS1ccytzYXZlZFxzK2Zyb21ccyt1cmw9XChcZCtcKWh0dHBzOi8vIjtpOjg0O3M6MjA6IkJhbmtccytvZlxzK01vbnRyZWFsIjtpOjg1O3M6MjE6InNlY3VyZVwudGFuZ2VyaW5lXC5jYSI7aTo4NjtzOjIyOiJibW9cLmNvbS9vbmxpbmViYW5raW5nIjtpOjg3O3M6NDE6InBtX2ZwPXZlcnNpb24mc3RhdGU9MSZzYXZlRkJDPSZGQkNfTnVtYmVyIjtpOjg4O3M6MjE6ImNpYmNvbmxpbmVcLmNpYmNcLmNvbSI7fQ=="));
$g_JSVirSig = unserialize(base64_decode("YToxMzA6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czoyMjoiXC5wcm90b3R5cGVcLmF9Y2F0Y2hcKCI7aTo1O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6NjtzOjM0OiJpZlwoUmVmXC5pbmRleE9mXCgnXC5nb29nbGVcLidcKSE9IjtpOjc7czo4NjoiaW5kZXhPZlx8aWZcfHJjXHxsZW5ndGhcfG1zblx8eWFob29cfHJlZmVycmVyXHxhbHRhdmlzdGFcfG9nb1x8YmlcfGhwXHx2YXJcfGFvbFx8cXVlcnkiO2k6ODtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6OTtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjEwO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTE7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTI7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxMztzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNDtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE1O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNjtzOjc6IlxceDY1QXQiO2k6MTc7czo5OiJcXHg2MXJDb2QiO2k6MTg7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToxOTtzOjExOiI9ImV2IlwrImFsIiI7aToyMDtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjE7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIyO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjIzO3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI0O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI1O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MjY7czo5OiJ2YXJccytfMHgiO2k6Mjc7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjg7czoxMDoia20wYWU5Z3I2bSI7aToyOTtzOjY6ImMzMjg0ZCI7aTozMDtzOjg6IlxceDY4YXJDIjtpOjMxO3M6ODoiXFx4NmRDaGEiO2k6MzI7czo3OiJcXHg2ZmRlIjtpOjMzO3M6NzoiXFx4NmZkZSI7aTozNDtzOjg6IlxceDQzb2RlIjtpOjM1O3M6NzoiXFx4NzJvbSI7aTozNjtzOjc6IlxceDQzaGEiO2k6Mzc7czo3OiJcXHg3MkNvIjtpOjM4O3M6ODoiXFx4NDNvZGUiO2k6Mzk7czoxMDoiXC5keW5kbnNcLiI7aTo0MDtzOjk6IlwuZHluZG5zLSI7aTo0MTtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQyO3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0MztzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDQ7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDU7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDY7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjQ3O3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NDg7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjQ5O3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MDtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjUxO3M6MTk6IjwhLS1cdytcfFx8c3RhdCAtLT4iO2k6NTI7czo4NToiJnBhcmFtZXRlcj1cJGtleXdvcmQmc2U9XCRzZSZ1cj0xJkhUVFBfUkVGRVJFUj0nXCtlbmNvZGVVUklDb21wb25lbnRcKGRvY3VtZW50XC5VUkxcKSI7aTo1MztzOjQ4OiJ3aW5kb3dzXHxzZXJpZXNcfDYwXHxzeW1ib3NcfGNlXHxtb2JpbGVcfHN5bWJpYW4iO2k6NTQ7czozNToiXFtbJyJdZXZhbFsnIl1cXVwoc1wpO319fX08L3NjcmlwdD4iO2k6NTU7czo1OToia0M3MEZNYmx5SmtGV1pvZENLbDFXWU9kV1lVbG5RelJuYmwxV1pzVkVkbGRtTDA1V1p0VjNZdlJHSTkiO2k6NTY7czo1NToie2s9aTtzPXNcLmNvbmNhdFwoc3NcKGV2YWxcKGFzcVwoXClcKS0xXClcKTt9ej1zO2V2YWxcKCI7aTo1NztzOjEzMDoiZG9jdW1lbnRcLmNvb2tpZVwubWF0Y2hcKG5ld1xzK1JlZ0V4cFwoXHMqIlwoXD86XF5cfDsgXCkiXHMqXCtccypuYW1lXC5yZXBsYWNlXCgvXChcW1xcXC5cJFw/XCpcfHt9XFxcKFxcXClcXFxbXFxcXVxcL1xcXCtcXlxdXCkvZyI7aTo1ODtzOjg2OiJzZXRDb29raWVccypcKCpccyoiYXJ4X3R0IlxzKixccyoxXHMqLFxzKmR0XC50b0dNVFN0cmluZ1woXClccyosXHMqWyciXXswLDF9L1snIl17MCwxfSI7aTo1OTtzOjE0NDoiZG9jdW1lbnRcLmNvb2tpZVwubWF0Y2hccypcKFxzKm5ld1xzK1JlZ0V4cFxzKlwoXHMqIlwoXD86XF5cfDtccypcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VccypcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYwO3M6OTg6InZhclxzK2R0XHMrPVxzK25ld1xzK0RhdGVcKFwpLFxzK2V4cGlyeVRpbWVccys9XHMrZHRcLnNldFRpbWVcKFxzK2R0XC5nZXRUaW1lXChcKVxzK1wrXHMrOTAwMDAwMDAwIjtpOjYxO3M6MTA1OiJpZlxzKlwoXHMqbnVtXHMqPT09XHMqMFxzKlwpXHMqe1xzKnJldHVyblxzKjE7XHMqfVxzKmVsc2Vccyp7XHMqcmV0dXJuXHMrbnVtXHMqXCpccypyRmFjdFwoXHMqbnVtXHMqLVxzKjEiO2k6NjI7czo0MToiXCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCgwXCsneCciO2k6NjM7czo4MzoiPHNjcmlwdFxzK2xhbmd1YWdlPSJKYXZhU2NyaXB0Ij5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj0iaHR0cDovL3ZrXC5jb20iO2k6NjQ7czo0NDoibG9jYXRpb25cLnJlcGxhY2VcKFsnIl17MCwxfWh0dHA6Ly92NWs0NVwucnUiO2k6NjU7czoxMjk6Ijt0cnl7XCtcK2RvY3VtZW50XC5ib2R5fWNhdGNoXChxXCl7YWE9ZnVuY3Rpb25cKGZmXCl7Zm9yXChpPTA7aTx6XC5sZW5ndGg7aVwrXCtcKXt6YVwrPVN0cmluZ1xbZmZcXVwoZVwodlwrXCh6XFtpXF1cKVwpLTEyXCk7fX07fSI7aTo2NjtzOjE0MjoiZG9jdW1lbnRcLndyaXRlXHMqXChbJyJdezAsMX08WyciXXswLDF9XHMqXCtccyp4XFswXF1ccypcK1xzKlsnIl17MCwxfSBbJyJdezAsMX1ccypcK1xzKnhcWzRcXVxzKlwrXHMqWyciXXswLDF9PlwuWyciXXswLDF9XHMqXCt4XHMqXFsyXF1ccypcKyI7aTo2NztzOjYwOiJpZlwodFwubGVuZ3RoPT0yXCl7elwrPVN0cmluZ1wuZnJvbUNoYXJDb2RlXChwYXJzZUludFwodFwpXCsiO2k6Njg7czo3NDoid2luZG93XC5vbmxvYWRccyo9XHMqZnVuY3Rpb25cKFwpXHMqe1xzKmlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXCgiO2k6Njk7czo5NzoiXC5zdHlsZVwuaGVpZ2h0XHMqPVxzKlsnIl17MCwxfTBweFsnIl17MCwxfTt3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7ZG9jdW1lbnRcLmNvb2tpZSI7aTo3MDtzOjEyMjoiXC5zcmM9XChbJyJdezAsMX1odHBzOlsnIl17MCwxfT09ZG9jdW1lbnRcLmxvY2F0aW9uXC5wcm90b2NvbFw/WyciXXswLDF9aHR0cHM6Ly9zc2xbJyJdezAsMX06WyciXXswLDF9aHR0cDovL1snIl17MCwxfVwpXCsiO2k6NzE7czozMDoiNDA0XC5waHBbJyJdezAsMX0+XHMqPC9zY3JpcHQ+IjtpOjcyO3M6NzY6InByZWdfbWF0Y2hcKFsnIl17MCwxfS9zYXBlL2lbJyJdezAsMX1ccyosXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1JFRkVSRVIiO2k6NzM7czo3NDoiZGl2XC5pbm5lckhUTUxccypcKz1ccypbJyJdezAsMX08ZW1iZWRccytpZD0iZHVtbXkyIlxzK25hbWU9ImR1bW15MiJccytzcmMiO2k6NzQ7czo3Mzoic2V0VGltZW91dFwoWyciXXswLDF9YWRkTmV3T2JqZWN0XChcKVsnIl17MCwxfSxcZCtcKTt9fX07YWRkTmV3T2JqZWN0XChcKSI7aTo3NTtzOjUxOiJcKGI9ZG9jdW1lbnRcKVwuaGVhZFwuYXBwZW5kQ2hpbGRcKGJcLmNyZWF0ZUVsZW1lbnQiO2k6NzY7czozMDoiQ2hyb21lXHxpUGFkXHxpUGhvbmVcfElFTW9iaWxlIjtpOjc3O3M6MTk6IlwkOlwoe31cKyIiXClcW1wkXF0iO2k6Nzg7czo0OToiPC9pZnJhbWU+WyciXVwpO1xzKnZhclxzK2o9bmV3XHMrRGF0ZVwobmV3XHMrRGF0ZSI7aTo3OTtzOjUzOiJ7cG9zaXRpb246YWJzb2x1dGU7dG9wOi05OTk5cHg7fTwvc3R5bGU+PGRpdlxzK2NsYXNzPSI7aTo4MDtzOjEyODoiaWZccypcKFwodWFcLmluZGV4T2ZcKFsnIl17MCwxfWNocm9tZVsnIl17MCwxfVwpXHMqPT1ccyotMVxzKiYmXHMqdWFcLmluZGV4T2ZcKCJ3aW4iXClccyohPVxzKi0xXClccyomJlxzKm5hdmlnYXRvclwuamF2YUVuYWJsZWQiO2k6ODE7czo1ODoicGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb249WyciXXswLDF9aHR0cDovL3ZrXC5jb21cLiI7aTo4MjtzOjQxOiJcXVwuc3Vic3RyXCgwLDFcKVwpO319cmV0dXJuIHRoaXM7fSxcXHUwMCI7aTo4MztzOjY4OiJqYXZhc2NyaXB0XHxoZWFkXHx0b0xvd2VyQ2FzZVx8Y2hyb21lXHx3aW5cfGphdmFFbmFibGVkXHxhcHBlbmRDaGlsZCI7aTo4NDtzOjIxOiJsb2FkUE5HRGF0YVwoc3RyRmlsZSwiO2k6ODU7czoyMDoiXCk7aWZcKCF+XChbJyJdezAsMX0iO2k6ODY7czoyMzoiLy9ccypTb21lXC5kZXZpY2VzXC5hcmUiO2k6ODc7czozMjoid2luZG93XC5vbmVycm9yXHMqPVxzKmtpbGxlcnJvcnMiO2k6ODg7czoxMDU6ImNoZWNrX3VzZXJfYWdlbnQ9XFtccypbJyJdezAsMX1MdW5hc2NhcGVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9aVBob25lWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfU1hY2ludG9zaCI7aTo4OTtzOjE1MzoiZG9jdW1lbnRcLndyaXRlXChbJyJdezAsMX08WyciXXswLDF9XCtbJyJdezAsMX1pWyciXXswLDF9XCtbJyJdezAsMX1mWyciXXswLDF9XCtbJyJdezAsMX1yWyciXXswLDF9XCtbJyJdezAsMX1hWyciXXswLDF9XCtbJyJdezAsMX1tWyciXXswLDF9XCtbJyJdezAsMX1lIjtpOjkwO3M6NDg6InN0cmlwb3NcKG5hdmlnYXRvclwudXNlckFnZW50XHMqLFxzKmxpc3RfZGF0YVxbaSI7aTo5MTtzOjI2OiJpZlxzKlwoIXNlZV91c2VyX2FnZW50XChcKSI7aTo5MjtzOjQ2OiJjXC5sZW5ndGhcKTt9cmV0dXJuXHMqWyciXVsnIl07fWlmXCghZ2V0Q29va2llIjtpOjkzO3M6NzA6IjxzY3JpcHRccyp0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzKnNyYz1bJyJdezAsMX1mdHA6Ly8iO2k6OTQ7czo0ODoiaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKFsnIl17MCwxfXNhYnJpIjtpOjk1O3M6MTIyOiJ3aW5kb3dcLmxvY2F0aW9uPWJ9XHMqXClcKFxzKm5hdmlnYXRvclwudXNlckFnZW50XHMqXHxcfFxzKm5hdmlnYXRvclwudmVuZG9yXHMqXHxcfFxzKndpbmRvd1wub3BlcmFccyosXHMqWyciXXswLDF9aHR0cDovLyI7aTo5NjtzOjk0OiJcKTtccyppZlwoXHMqXHcrXC50ZXN0XChccypkb2N1bWVudFwucmVmZXJyZXJccypcKVxzKiYmXHMqXHcrXClccyp7XHMqZG9jdW1lbnRcLmxvY2F0aW9uXC5ocmVmIjtpOjk3O3M6NDI6ImlmXCgvQW5kcm9pZC9pXFtfMHhcdytcW1xkK1xdXF1cKG5hdmlnYXRvciI7aTo5ODtzOjY5OiJmdW5jdGlvblwoYVwpe2lmXChhJiZbJyJdZGF0YVsnIl1pblxkK2EmJmFcLmRhdGFcLmFcZCsmJmFcLmRhdGFcLmFcZCsiO2k6OTk7czo1ODoic1wob1wpfVwpfSxmPWZ1bmN0aW9uXChcKXt2YXIgdCxpPUpTT05cLnN0cmluZ2lmeVwoZVwpO29cKCI7aToxMDA7czoxMDY6IjxcZCtccytcZCs9WyciXVxkKy9cZCtcXFsnIl1cK1xcWyciXS5cXFsnIl1cK1xcWyciXS5bJyJdXHMrLj1bJyJdLjovL1xkK1xcWyciXVwrXFxbJyJdLlwuXGQrXFxbJyJdXCtcXFsnIl0iO2k6MTAxO3M6MTA3OiJzZXRUaW1lb3V0XChcZCtcKTtccyp2YXJccytkZWZhdWx0X2tleXdvcmRccyo9XHMqZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwudGl0bGVcKTtccyp2YXJccytzZV9yZWZlcnJlciI7aToxMDI7czo5ODoiPWRvY3VtZW50XC5yZWZlcnJlcjtpZlwoUmVmXC5pbmRleE9mXChbJyJdXC5nb29nbGVcLlsnIl1cKSE9LTFcfFx8UmVmXC5pbmRleE9mXChbJyJdXC5iaW5nXC5bJyJdXCkiO2k6MTAzO3M6MTc6InNleGZyb21pbmRpYVwuY29tIjtpOjEwNDtzOjExOiJmaWxla3hcLmNvbSI7aToxMDU7czoxMzoic3R1bW1hbm5cLm5ldCI7aToxMDY7czoxNDoidG9wbGF5Z2FtZVwucnUiO2k6MTA3O3M6MTQ6Imh0dHA6Ly94enhcLnBtIjtpOjEwODtzOjE4OiJcLmhvcHRvXC5tZS9qcXVlcnkiO2k6MTA5O3M6MTE6Im1vYmktZ29cLmluIjtpOjExMDtzOjE4OiJiYW5rb2ZhbWVyaWNhXC5jb20iO2k6MTExO3M6MTY6Im15ZmlsZXN0b3JlXC5jb20iO2k6MTEyO3M6MTc6ImZpbGVzdG9yZTcyXC5pbmZvIjtpOjExMztzOjE2OiJmaWxlMnN0b3JlXC5pbmZvIjtpOjExNDtzOjE1OiJ1cmwyc2hvcnRcLmluZm8iO2k6MTE1O3M6MTg6ImZpbGVzdG9yZTEyM1wuaW5mbyI7aToxMTY7czoxMjoidXJsMTIzXC5pbmZvIjtpOjExNztzOjE0OiJkb2xsYXJhZGVcLmNvbSI7aToxMTg7czoxMToic2VjY2xpa1wucnUiO2k6MTE5O3M6MTE6Im1vYnktYWFcLnJ1IjtpOjEyMDtzOjEyOiJzZXJ2bG9hZFwucnUiO2k6MTIxO3M6Nzoibm5uXC5wbSI7aToxMjI7czo3OiJubm1cLnBtIjtpOjEyMztzOjE2OiJtb2ItcmVkaXJlY3RcLnJ1IjtpOjEyNDtzOjE2OiJ3ZWItcmVkaXJlY3RcLnJ1IjtpOjEyNTtzOjE2OiJ0b3Atd2VicGlsbFwuY29tIjtpOjEyNjtzOjE5OiJnb29kcGlsbHNlcnZpY2VcLnJ1IjtpOjEyNztzOjE0OiJ5b3V0dWliZXNcLmNvbSI7aToxMjg7czoxNDoidW5zY3Jld2luZ1wucnUiO2k6MTI5O3M6MjY6ImxvYWRtZVwuY2hpY2tlbmtpbGxlclwuY29tIjt9"));
$gX_JSVirSig = unserialize(base64_decode("YTo2ODp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjY1OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlx3Kz11bmVzY2FwZVwoXHMqXHcrXHMqXCk7XHMqdmFyXHMrRXhwRGF0ZSI7aToxNTtzOjUyOiI8IS0tXHMqXHcrXHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqXHcrXHMqLS0+IjtpOjE2O3M6MzU6ImV2YWxccypcKFxzKmRlY29kZVVSSUNvbXBvbmVudFxzKlwoIjtpOjE3O3M6NjE6IndoaWxlXChccypmPFxkK1xzKlwpZG9jdW1lbnRcW1xzKlx3K1wrWyciXXRlWyciXVxzKlxdXChTdHJpbmciO2k6MTg7czo0ODoic2V0Q29va2llXChccypfMHhcdytccyosXHMqXzB4XHcrXHMqLFxzKl8weFx3K1wpIjtpOjE5O3M6Mjk6IlxdXChccyp2XCtcK1xzKlwpLTFccypcKVxzKlwpIjtpOjIwO3M6MzM6ImRvY3VtZW50XFtccypfMHhcdytcW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjgzOiJpXFtfMHhcdytcW1xkK1xdXF1cKFx3K1xbXzB4XHcrXFtcZCtcXVxdXChcZCssXGQrXClcKVwpe3dpbmRvd1xbXzB4XHcrXFtcZCtcXVxdPWxvYyI7aToyNTtzOjQ5OiJkb2N1bWVudFwud3JpdGVcKFxzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseVwoIjtpOjI2O3M6NDA6IlsnIl1cXVwoXHcrXCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6Mjc7czo1NDoiO3doaWxlXChcdys8XGQrXClkb2N1bWVudFxbLis/XF1cKFN0cmluZ1xbWyciXWZyb21DaGFyIjtpOjI4O3M6OTg6ImlmXHMqXChcdytcLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjI5O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzA7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzE7czo2MDoiZmFsc2V9O1x3Kz1cdytcKFsnIl1cdytbJyJdXClcfFx3K1woWyciXVx3K1snIl1cKTtcdytcfD1cdys7IjtpOjMyO3M6NTQ6IlN0cmluZ1wuZnJvbUNoYXJDb2RlXChccypcdytcLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NDc6IlxbWyciXWNoYXJbJyJdXHMqXCtccypcdytccypcK1xzKlsnIl1BdFsnIl1cXVwoIjtpOjM1O3M6NDk6InNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzY7czo0NToiU3RyaW5nXFtccypbJyJdZnJvbUNoYXJbJyJdXHMqXCtccypcdytccypcXVwoIjtpOjM3O3M6Mjg6Ii49WyciXS46Ly8uXC4uXC4uXC4uLy5cLi5cLi4iO2k6Mzg7czoyOToiPC9zY3JpcHQ+WyciXVwpO1xzKi9cKi9cdytcKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo4NzoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChcdytcKTtccypzXC5zcmNccyo9IjtpOjQzO3M6MTk6Ii46Ly8uXC4uXC4uLy5cLi5cPy8iO2k6NDQ7czozOToiXGQrXHMqPlxzKlxkK1xzKlw/XHMqWyciXVxceFxkK1snIl1ccyo6IjtpOjQ1O3M6NDU6IlsnIl1cW1xzKlsnIl1jaGFyQ29kZUF0WyciXVxzKlxdXChccypcZCtccypcKSI7aTo0NjtzOjE3OiI8L2JvZHk+XHMqPHNjcmlwdCI7aTo0NztzOjE3OiI8L2h0bWw+XHMqPHNjcmlwdCI7aTo0ODtzOjE3OiI8L2h0bWw+XHMqPGlmcmFtZSI7aTo0OTtzOjQyOiJkb2N1bWVudFwud3JpdGVcKFxzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXCgiO2k6NTA7czoyMjoic3JjPSJmaWxlc19zaXRlL2pzXC5qcyI7aTo1MTtzOjk0OiJ3aW5kb3dcLnBvc3RNZXNzYWdlXCh7XHMqem9yc3lzdGVtOlxzKjEsXHMqdHlwZTpccypbJyJddXBkYXRlWyciXSxccypwYXJhbXM6XHMqe1xzKlsnIl11cmxbJyJdIjtpOjUyO3M6ODg6IlwuYXR0YWNoRXZlbnRcKFsnIl1vbmxvYWRbJyJdLGFcKTpcdytcLmFkZEV2ZW50TGlzdGVuZXJcKFsnIl1sb2FkWyciXSxhLCExXCk7bG9hZE1hdGNoZXIiO2k6NTM7czo3ODoiaWZcKFwoYT1lXC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWFbJyJdXClcKSYmYVxbMFxdJiZhXFswXF1cLmhyZWZcKWZvclwodmFyIjtpOjU0O3M6ODE6IjtccyplbGVtZW50XC5pbm5lckhUTUxccyo9XHMqWyciXTxpZnJhbWVccytzcmM9WyciXVxzKlwrXHMqeGhyXC5yZXNwb25zZVRleHRccypcKyI7aTo1NTtzOjE5OiJYSEZFUjFccyo9XHMqWEhGRVIxIjtpOjU2O3M6NTE6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFxzKlsnIl17MCwxfSUzQyI7aTo1NztzOjc4OiJkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfTxzY3JpcHRccytzcmM9WyciXXswLDF9aHR0cDovLzxcPz1cJGRvbWFpblw/Pi8iO2k6NTg7czo1NToid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovL1xkK1wuXGQrXC5cZCtcLlxkKy9cPyI7aTo1OTtzOjY2OiJzZXRUaW1lb3V0XChmdW5jdGlvblwoXCl7dmFyXHMrcGF0dGVyblxzKj1ccypuZXdccypSZWdFeHBcKC9nb29nbGUiO2k6NjA7czo2Njoid289WyciXVwrISFcKFsnIl1vbnRvdWNoc3RhcnRbJyJdXHMraW5ccyt3aW5kb3dcKVwrWyciXSZzdD0xJnRpdGxlIjtpOjYxO3M6NTY6InJlZmVycmVyXHMqIT09XHMqWyciXVsnIl1cKXtkb2N1bWVudFwud3JpdGVcKFsnIl08c2NyaXB0IjtpOjYyO3M6Mzc6ImlmXChhJiZbJyJdZGF0YVsnIl1pblxzKmEmJmFcLmRhdGFcLmEiO2k6NjM7czo2MDoianF1ZXJ5XC5taW5cLnBocFsnIl07IHZhciBuX3VybCA9IGJhc2UgXCsgIlw/ZGVmYXVsdF9rZXl3b3JkIjtpOjY0O3M6NDY6ImRvY3VtZW50XFtcdytcKFx3K1xbXGQrXF1cKVxdXChcdytcKFx3K1xbXGQrXF0iO2k6NjU7czo1ODoiaFwuZlwoXFxbJyJdPDMgNz1bJyJdOC85XFxbJyJdXCtcXFsnIl1hXFxbJyJdXCtcXFsnIl1iWyciXSI7aTo2NjtzOjE1OiJcLnRyeW15ZmluZ2VyXC4iO2k6Njc7czoxOToiXC5vbmVzdGVwdG93aW5cLmNvbSI7fQ=="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqWyciXChcJF0iO2k6MTIyO3M6MTE6IlxibWFpbFxzKlwoIjtpOjEyMztzOjQ2OiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKlsnIl17MCwxfXBocDovL2lucHV0IjtpOjEyNDtzOjExODoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfUNvbnRlbnQtdHlwZVsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9dGV4dC9odG1sO1xzKmNoYXJzZXQ9d2luZG93cy0xMjUxWyciXXswLDF9Pjxib2R5PiI7aToxMjU7czo2MjoiPVxzKmRvY3VtZW50XC5jcmVhdGVFbGVtZW50XChccypbJyJdezAsMX1zY3JpcHRbJyJdezAsMX1ccypcKTsiO2k6MTI2O3M6Njk6ImRvY3VtZW50XC5ib2R5XC5pbnNlcnRCZWZvcmVcKGRpdixccypkb2N1bWVudFwuYm9keVwuY2hpbGRyZW5cWzBcXVwpOyI7aToxMjc7czo2NjoiPHNjcmlwdFxzK3R5cGU9InRleHQvamF2YXNjcmlwdCJccytzcmM9Imh0dHA6Ly9cdytcLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));

//END_SIG
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
  exit;
}

if (!(function_exists("file_put_contents") && is_callable("file_put_contents"))) {
    echo "#####################################################\n";
	echo "file_put_contents() is disabled. Cannot proceed.\n";
    echo "#####################################################\n";	
    exit;
}
                              
define('AI_VERSION', '20160124');

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
ini_set('max_execution_time', '900000');
ini_set('realpath_cache_size','16M');
ini_set('realpath_cache_ttl','1200');
ini_set('pcre.backtrack_limit','150000');
ini_set('pcre.recursion_limit','150000');

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

        $dir_list = $this->getDirList($root_path);
        $dir_list[] = $root_path;

        foreach ($dir_list as $dir) {
            if ($this->checkBitrix($dir, $version)) {
               $this->addCms(CMS_BITRIX, $version);
            }

            if ($this->checkWordpress($dir, $version)) {
               $this->addCms(CMS_WORDPRESS, $version);
            }

            if ($this->checkJoomla($dir, $version)) {
               $this->addCms(CMS_JOOMLA, $version);
            }

            if ($this->checkDle($dir, $version)) {
               $this->addCms(CMS_DLE, $version);
            }

            if ($this->checkIpb($dir, $version)) {
               $this->addCms(CMS_IPB, $version);
            }

            if ($this->checkWebAsyst($dir, $version)) {
               $this->addCms(CMS_WEBASYST, $version);
            }

            if ($this->checkOsCommerce($dir, $version)) {
               $this->addCms(CMS_OSCOMMERCE, $version);
            }

            if ($this->checkDrupal($dir, $version)) {
               $this->addCms(CMS_DRUPAL, $version);
            }

            if ($this->checkMODX($dir, $version)) {
               $this->addCms(CMS_MODX, $version);
            }

            if ($this->checkInstantCms($dir, $version)) {
               $this->addCms(CMS_INSTANTCMS, $version);
            }

            if ($this->checkPhpBb($dir, $version)) {
               $this->addCms(CMS_PHPBB, $version);
            }

            if ($this->checkVBulletin($dir, $version)) {
               $this->addCms(CMS_VBULLETIN, $version);
            }

            if ($this->checkPhpShopScript($dir, $version)) {
               $this->addCms(CMS_SHOPSCRIPT, $version);
            }

        }
    }

    function getDirList($target) {
       $remove = array('.', '..'); 
       $directories = array_diff(scandir($target), $remove);

       $res = array();
           
       foreach($directories as $value) 
       { 
          if(is_dir($target . '/' . $value)) 
          {
             $res[] = $target . '/' . $value; 
          } 
       }

       return $res;
    }

    function isCms($name, $version) {
		for ($i = 0; $i < count($this->types); $i++) {
			if ((strpos($this->types[$i], $name) !== false) 
				&& 
			    (strpos($this->versions[$i], $version) !== false)) {
				return true;
			}
		}
    	
		return false;
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

    private function checkBitrix($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/bitrix')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/bitrix/modules/main/classes/general/version.php');
          if (preg_match('|define\("SM_VERSION","(.+?)"\)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWordpress($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/wp-admin')) {
          $res = true;

          $tmp_content = @file_get_contents($dir .'/wp-includes/version.php');
          if (preg_match('|\$wp_version\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }
       }

       return $res;
    }

    private function checkJoomla($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/libraries/joomla')) {
          $res = true;

          // for 1.5.x
          $tmp_content = @file_get_contents($dir .'/libraries/joomla/version.php');
          if (preg_match('|var\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|var\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 1.7.x
          $tmp_content = @file_get_contents($dir .'/includes/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 2.5.x and 3.x
          $tmp_content = @file_get_contents($dir .'/libraries/cms/version/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

       }

       return $res;
    }

    private function checkDle($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/engine/engine.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/engine/data/config.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

          $tmp_content = @file_get_contents($dir . '/install.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkIpb($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/ips_kernel')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/ips_kernel/class_xml.php');
          if (preg_match('|IP.Board\s+v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWebAsyst($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/wbs/installer')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/license.txt');
          if (preg_match('|v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkOsCommerce($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/includes/version.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/includes/version.php');
          if (preg_match('|([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkDrupal($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/sites/all')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/CHANGELOG.txt');
          if (preg_match('|Drupal\s+([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkMODX($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/manager/assets')) {
          $res = true;

          // no way to pick up version
       }

       return $res;
    }

    private function checkInstantCms($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/plugins/p_usertab')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/index.php');
          if (preg_match('|InstantCMS\s+v([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpBb($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/includes/acp')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/config.php');
          if (preg_match('|phpBB\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkVBulletin($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/core/admincp')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/core/api.php');
          if (preg_match('|vBulletin\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpShopScript($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/install/consts.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/install/consts.php');
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
		'i:' => 'idb:',
		'h' => 'help'
	);

	$cli_longopts = array(
		'cmd:',
		'noprefix:',
		'addprefix:',
		'one-pass',
		'quarantine',
		'with-2check',
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
      --with-2check    Create or use AI-BOLIT-DOUBLECHECK.php file
      --imake
      --icheck
      --idb=file	   Integrity Check database file

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

	if (
		(isset($options['idb']) AND ($ireport = $options['idb']) !== false)
	)
	{
		$ireport = str_replace('@PATH@', $l_SuffixReport, $ireport);
		$ireport = str_replace('@RND@', rand(1, 999999), $ireport);
		$ireport = str_replace('@DATE@', date('d-m-Y-h-i'), $ireport);
		define('INTEGRITY_DB_FILE', $ireport);
	}

  
    $l_ReportDirName = dirname($report);
	define('QUEUE_FILENAME', ($l_ReportDirName != '' ? $l_ReportDirName . '/' : '') . 'AI-BOLIT-QUEUE-' . md5($defaults['path']) . '.txt');

	defined('REPORT') OR define('REPORT', 'AI-BOLIT-REPORT-' . $l_SuffixReport . '-' . date('d-m-Y_H-i') . '.html');
	
	defined('INTEGRITY_DB_FILE') OR define('INTEGRITY_DB_FILE', 'AINTEGRITY-' . $l_SuffixReport . '-' . date('d-m-Y_H-i'));

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

	define('IMAKE', isset($options['imake']));
	define('ICHECK', isset($options['icheck']));

	if (IMAKE && ICHECK) die('One of the following options must be used --imake or --icheck.');

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

if (!isCli()) {
  	define('ICHECK', isset($_GET['icheck']));
  	define('IMAKE', isset($_GET['imake']));
	
	define('INTEGRITY_DB_FILE', 'ai-integrity-db');
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

$l_Template = str_replace('@@HEAD_TITLE@@', AI_STR_051 . $g_AddPrefix . str_replace($g_NoPrefix, '', ROOT_PATH), $l_Template);

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
function makeSafeFn($par_Str, $replace_path = false) {
  global $g_AddPrefix, $g_NoPrefix;
  if ($replace_path) {
     $lines = explode("\n", $par_Str);
     array_walk($lines, function(&$n) {
          global $g_AddPrefix, $g_NoPrefix;
          $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n); 
     }); 

     $par_Str = implode("\n", $lines);
  }
 
  return htmlspecialchars($par_Str, ENT_SUBSTITUTE | ENT_QUOTES);
}

function replacePathArray($par_Arr) {
  global $g_AddPrefix, $g_NoPrefix;
     array_walk($par_Arr, function(&$n) {
          global $g_AddPrefix, $g_NoPrefix;
          $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n); 
     }); 

  return $par_Arr;
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
  $l_Result .= "<th width=70%>" . AI_STR_004 . "</th>";
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
		$l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos])) . '</a></div>' . $l_Body . '</td>';
	 } else {
		$l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]])) . '</a></div></td>';
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

  $l_Src = array('&quot;', '&lt;', '&gt;', '&amp;', '&#039;');
  $l_Dst = array('"',      '<',    '>',    '&', '\'');

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
   function addSlash($dir) {
      return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
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
						$g_SuspiciousFiles, $g_ShortListExt;

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
			        if (!in_array($l_FileName, $g_UnixExec)) {
				   $g_UnixExec[] = $l_FileName;
				}

				continue;
			}	
						
			$l_Ext = strtolower(pathinfo($l_FileName, PATHINFO_EXTENSION));
			$l_IsDir = is_dir($l_FileName);

			if (in_array($l_Ext, $g_SuspiciousFiles)) 
			{
			        if (!in_array($l_FileName, $g_UnixExec)) {
                		   $g_UnixExec[] = $l_FileName;
                                } 
            		}

			// which files should be scanned
			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, $g_SensitiveFiles));
			
			if (in_array(strtolower($l_Ext), $g_IgnoredExt)) {    
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
					if (in_array($l_Ext, $g_ShortListExt)) 
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

  $l_Res = makeSafeFn(UnwrapObfu($l_Res));
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
  
  $search  = array( ' ;', ' =', ' ,', ' .', ' (', ' )', ' {', ' }', '; ', '= ', ', ', '. ', '( ', '( ', '{ ', '} ', ' !', ' >', ' <', ' _', '_ ', '< ',  '> ', ' $', ' %',   '% ', '# ', ' #', '^ ', ' ^', ' &', '& ', ' ?', '? ');
  $replace = array(  ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}', ';',  '=',  ',',  '.',  '(',   ')', '{',  '}',   '!',  '>',  '<',  '_', '_',  '<',   '>',   '$',  '%',   '%',  '#',   '#', '^',   '^',  '&', '&',   '?', '?');
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
    global $g_Vulnerable, $g_CmsListDetector;
	
	$l_Vuln = array();

        $par_Filename = strtolower($par_Filename);


	if (
	    (strpos($par_Filename, 'libraries/joomla/session/session.php') !== false) &&
		(strpos($par_Content, '&& filter_var($_SERVER[\'HTTP_X_FORWARDED_FOR') === false)
		) 
	{		
			$l_Vuln['id'] = 'RCE : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
	}

	if (
	    (strpos($par_Filename, 'administrator/components/com_media/helpers/media.php') !== false) &&
		(strpos($par_Content, '$format == \'\' || $format == false ||') === false)
		) 
	{		
		if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
			$l_Vuln['id'] = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (
	    (strpos($par_Filename, 'joomla/filesystem/file.php') !== false) &&
		(strpos($par_Content, '$file = rtrim($file, \'.\');') === false)
		) 
	{		
		if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
			$l_Vuln['id'] = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if ((strpos($par_Filename, 'editor/filemanager/upload/test.html') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/browser/default/connectors/php/') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/connectors/uploadtest.html') !== false) ||
	   (strpos($par_Filename, 'editor/filemanager/browser/default/connectors/test.html') !== false)) {
		$l_Vuln['id'] = 'AFU : FCKEDITOR : http://www.exploit-db.com/exploits/17644/ & /exploit/249';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		return true;
	}

	if ((strpos($par_Filename, 'inc_php/image_view.class.php') !== false) ||
	    (strpos($par_Filename, '/inc_php/framework/image_view.class.php') !== false)) {
		if (strpos($par_Content, 'showImageByID') === false) {
			$l_Vuln['id'] = 'AFU : REVSLIDER : http://www.exploit-db.com/exploits/35385/';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if ((strpos($par_Filename, 'elfinder/php/connector.php') !== false) ||
	    (strpos($par_Filename, 'elfinder/elfinder.') !== false)) {
			$l_Vuln['id'] = 'AFU : elFinder';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
	}

	if (strpos($par_Filename, 'includes/database/database.inc') !== false) {
		if (strpos($par_Content, 'foreach ($data as $i => $value)') !== false) {
			$l_Vuln['id'] = 'SQLI : DRUPAL : CVE-2014-3704';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'engine/classes/min/index.php') !== false) {
		if (strpos($par_Content, 'tr_replace(chr(0)') === false) {
			$l_Vuln['id'] = 'AFD : MINIFY : CVE-2013-6619';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (( strpos($par_Filename, 'timthumb.php') !== false ) || 
	    ( strpos($par_Filename, 'thumb.php') !== false ) || 
	    ( strpos($par_Filename, 'cache.php') !== false ) || 
	    ( strpos($par_Filename, '_img.php') !== false )) {
		if (strpos($par_Content, 'code.google.com/p/timthumb') !== false && strpos($par_Content, '2.8.14') === false ) {
			$l_Vuln['id'] = 'RCE : TIMTHUMB : CVE-2011-4106,CVE-2014-4663';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'components/com_rsform/helpers/rsform.php') !== false) {
		if (strpos($par_Content, 'eval($form->ScriptDisplay);') !== false) {
			$l_Vuln['id'] = 'RCE : RSFORM : rsform.php, LINE 1605';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'fancybox-for-wordpress/fancybox.php') !== false) {
		if (strpos($par_Content, '\'reset\' == $_REQUEST[\'action\']') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : FANCYBOX';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}


	if (strpos($par_Filename, 'cherry-plugin/admin/import-export/upload.php') !== false) {
		if (strpos($par_Content, 'verify nonce') === false) {
			$l_Vuln['id'] = 'AFU : Cherry Plugin';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}
	
	
	if (strpos($par_Filename, 'tiny_mce/plugins/tinybrowser/tinybrowser.php') !== false) {	
		$l_Vuln['id'] = 'AFU : TINYMCE : http://www.exploit-db.com/exploits/9296/';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		
		return true;
	}

	if (strpos($par_Filename, 'scripts/setup.php') !== false) {		
		if (strpos($par_Content, 'PMA_Config') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : PHPMYADMIN : http://1337day.com/exploit/5334';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, '/uploadify.php') !== false) {		
		if (strpos($par_Content, 'move_uploaded_file($tempFile,$targetFile') !== false) {
			$l_Vuln['id'] = 'AFU : UPLOADIFY : CVE: 2012-1153';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'com_adsmanager/controller.php') !== false) {		
		if (strpos($par_Content, 'move_uploaded_file($file[\'tmp_name\'], $tempPath.\'/\'.basename($file[') !== false) {
			$l_Vuln['id'] = 'AFU : https://revisium.com/ru/blog/adsmanager_afu.html';
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

		        $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
		
                if (($l_Content == '') && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult('[io] ' . $l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, '@@AIBOLIT_SIG_000000000000@@') !== false) {
					return;
				}

				// unix executables
				if (strpos($l_Content, chr(127) . 'ELF') !== false) 
				{
			        	if (!in_array($l_Filename, $g_UnixExec)) {
                    				$g_UnixExec[] = $l_Filename;
					}

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

				// check vulnerability in files
				$l_CriticalDetected = CheckVulnerability($l_Filename, $i, $l_Content);				

				if ($l_UnicodeContent !== false) {
       				   if (function_exists('iconv')) {
				      $l_Unwrapped = iconv($l_UnicodeContent, "CP1251//IGNORE", $l_Unwrapped);
//       			   if (function_exists('mb_convert_encoding')) {
//                                    $l_Unwrapped = mb_convert_encoding($l_Unwrapped, $l_UnicodeContent, "CP1251");
                                   } else {
                                      $g_NotRead[] = $i;
                                      AddResult('[ec] ' . $l_Filename, $i);
				   }
                                }

				$l_Unwrapped = UnwrapObfu($l_Unwrapped);
				
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

							    if  ((stripos($l_Found[$kk][1], $defaults['site_url']) !== false)
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
				if (stripos($l_Ext, 'ph') === false)
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
					$g_WarningPHPFragment[$l_Prio][] = getFragment($l_Unwrapped, $l_Pos);
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
					$g_AdwareList[] = $i;
					$l_CriticalDetected = true;
				}
			}
		} // end of if (!$g_SkipNextCheck) {
			
			unset($l_Unwrapped);
			unset($l_Content);
			
			//printProgress(++$_files_and_ignored, $l_Filename);

			$l_TSEndScan = microtime(true);
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
//         print("\n\nEXCEPTION FOUND\n[" . $l_ExceptItem .  "]\n" . $l_Content . "\n\n----------\n\n");
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

   if (pcre_error($l_FN, $l_Index)) {  }

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

   if (pcre_error($l_FN, $l_Index)) {  }

  }
}

  return $l_Res;
}

////////////////////////////////////////////////////////////////////////////
function pcre_error($par_FN, $par_Index) {
   global $g_NotRead, $g_Structure;
   $err = preg_last_error();
   if (($err == PREG_BACKTRACK_LIMIT_ERROR) || ($err == PREG_RECURSION_LIMIT_ERROR)) {
      if (!in_array($par_Index, $g_NotRead)) {
         $g_NotRead[] = $par_Index;
         AddResult('[re] ' . $par_FN, $par_Index);
      }
 
      return true;
   }

   return false;
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

  // @@AIBOLIT_SIG_000000000000@@ H24LKHGHCGHFHGKJHGKJHGGGHJ

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
  
  
  // if not critical - skip it 
  if ($l_SkipCheck && SMART_SCAN) {
      if (DEBUG_MODE) {
         echo "Skipped file, not critical.\n";
      }

	  return false;
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

if (AI_EXPERT > 0) {
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

  if (AI_EXPERT > 1) {
    if (strpos($l_FN, '.php.') !== false ) {
       $g_Base64[] = $l_Index;
       $g_Base64Fragment[] = '".php."';
       $l_Pos = 0;

       if (DEBUG_MODE) {
            echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       AddResult($l_FN, $l_Index);
    }
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

   if (pcre_error($l_FN, $l_Index)) {  }

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

   if (pcre_error($l_FN, $l_Index)) {  }
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

   if (pcre_error($l_FN, $l_Index)) {  }
  }
}

  if ((strpos($l_FN, '.ph') !== false) && (AI_EXPERT > 1)) {
     // for php only
     $g_Specials = ');#';

       $l_Pos = stripos($l_Content, $g_Specials);
       if (($l_Pos !== false) && ($l_Content[$l_Pos + 3] != '#')) {
          $l_SigId = myCheckSum($g_Specials);
          return true;
     }
  }

}

if (AI_EXPERT > 0) {
  if ((strpos($l_Content, 'GIF89') === 0) && (strpos($l_FN, '.php') !== false )) {
     $l_Pos = 0;

     if (DEBUG_MODE) {
          echo "CRIT 6: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     return true;
  }
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


// detect version CMS
$g_KnownCMS = array();
$tmp_cms = array();
$g_CmsListDetector = new CmsVersionDetector(ROOT_PATH);
$l_CmsDetectedNum = $g_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $g_CmsListDetector->getCmsName($tt) . ' v' . makeSafeFn($g_CmsListDetector->getCmsVersion($tt));
    $tmp_cms[strtolower($g_CmsListDetector->getCmsName($tt))] = 1;
}

if (count($tmp_cms) > 0) {
   $g_KnownCMS = array_keys($tmp_cms);
   $len = count($g_KnownCMS);
   for ($i = 0; $i < $len; $i++) {
      if ($g_KnownCMS[$i] == strtolower(CMS_WORDPRESS)) $g_KnownCMS[] = 'wp';
      if ($g_KnownCMS[$i] == strtolower(CMS_WEBASYST)) $g_KnownCMS[] = 'shopscript';
      if ($g_KnownCMS[$i] == strtolower(CMS_IPB)) $g_KnownCMS[] = 'ipb';
      if ($g_KnownCMS[$i] == strtolower(CMS_DLE)) $g_KnownCMS[] = 'dle';
      if ($g_KnownCMS[$i] == strtolower(CMS_INSTANTCMS)) $g_KnownCMS[] = 'instantcms';
      if ($g_KnownCMS[$i] == strtolower(CMS_SHOPSCRIPT)) $g_KnownCMS[] = 'shopscript';
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
//   	   if (defined('CMS') && $l_FileName != CMS) continue;

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

   	   $found = false;
   	   for ($k = 0; $k < count($g_KnownCMS); $k++) {
   	      if (strpos($l_AbsolutePathKnownFiles . "/" . $l_FileName, $g_KnownCMS[$k]) !== false) {
                 $found = true;
              }
           }

           if (defined('CMS') && (!$found)) continue;

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

QCR_Debug();

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
   if (!(ICHECK || IMAKE) && isset($options['with-2check']) && file_exists(DOUBLECHECK_FILE)) {
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
      if (ICHECK || IMAKE) {
      // INTEGRITY CHECK
        IMAKE and unlink(INTEGRITY_DB_FILE);
        ICHECK and load_integrity_db();
        QCR_IntegrityCheck(ROOT_PATH);
        stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
        if (IMAKE) exit(0);
        if (ICHECK) {
            $i = $g_Counter;
            $g_CRC = 0;
            $changes = array();
            $ref =& $g_IntegrityDB;
            foreach ($g_IntegrityDB as $l_FileName => $type) {
                unset($g_IntegrityDB[$l_FileName]);
                $l_Ext2 = substr(strstr(basename($l_FileName), '.'), 1);
                if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                    continue;
                }
                for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
                    if (($g_DirIgnoreList[$dr] != '') && preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
                        continue 2;
                    }
                }
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

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $g_AddPrefix . str_replace($g_NoPrefix, '', addSlash(ROOT_PATH))), $l_Template);

$time_taken = seconds2Human(microtime(true) - START_TIME);

$l_Template = str_replace("@@SCANNED@@", sprintf(AI_STR_013, $g_TotalFolder, $g_TotalFiles), $l_Template);

$l_ShowOffer = false;

stdOut("\nBuilding report [ mode = " . AI_EXPERT . " ]\n");

////////////////////////////////////////////////////////////////////////////
// save 
if (!(ICHECK || IMAKE))
if (isset($options['with-2check']) || isset($options['quarantine']))
if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR 
   (count($g_Iframer) > 0) OR  (count($g_UnixExec))) 
{
  if (!file_exists(DOUBLECHECK_FILE)) {	  
      if ($l_FH = fopen(DOUBLECHECK_FILE, 'w')) {
         fputs($l_FH, '<?php die("Forbidden"); ?>' . "\n");

         $l_CurrPath = dirname(__FILE__);
		 
		 if (!isset($g_CriticalPHP)) { $g_CriticalPHP = array(); }
		 if (!isset($g_CriticalJS)) { $g_CriticalJS = array(); }
		 if (!isset($g_Iframer)) { $g_Iframer = array(); }
		 if (!isset($g_Base64)) { $g_Base64 = array(); }
		 if (!isset($g_Phishing)) { $g_Phishing = array(); }
		 if (!isset($g_AdwareList)) { $g_AdwareList = array(); }
		 if (!isset($g_Redirect)) { $g_Redirect = array(); }
		 
         $tmpIndex = array_merge($g_CriticalPHP, $g_CriticalJS, $g_Phishing, $g_Base64, $g_Iframer, $g_AdwareList, $g_Redirect);
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
   $l_Summary .= makeSummary(AI_STR_063, count($g_UnixExec), (AI_EXPERT > 1 ? 'crit' : 'warn'));
}

if (count($g_Iframer) > 0) {
   $l_Summary .= makeSummary(AI_STR_064, count($g_Iframer), "crit");
}

if (count($g_NotRead) > 0) {
   $l_Summary .= makeSummary(AI_STR_066, count($g_NotRead), "crit");
}

if (count($g_Base64) > 0) {
   $l_Summary .= makeSummary(AI_STR_067, count($g_Base64), (AI_EXPERT > 1 ? 'crit' : 'warn'));
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

$l_PlainResult = "# Malware list detected by AI-Bolit (https://revisium.com/ai/) on " . date("d/m/Y H:i:s", time()) . " " . $l_HostName .  "\n\n";

stdOut("Building list of vulnerable scripts " . count($g_Vulnerable));

if (count($g_Vulnerable) > 0) {
    $l_Result .= '<div class="note_vir">' . AI_STR_081 . ' (' . count($g_Vulnerable) . ')</div><div class="crit">';
 	foreach ($g_Vulnerable as $l_Item) {
	    $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$l_Item['ndx']], true) . ' - ' . $l_Item['id'] . '</li>';
            $l_PlainResult .= '[VULNERABILITY] ' . replacePathArray($g_Structure['n'][$l_Item['ndx']]) . ' - ' . $l_Item['id'] . "\n";
 	}
	
  $l_Result .= '</div><p>' . PHP_EOL;
  $l_PlainResult .= "\n";
}


stdOut("Building list of shells " . count($g_CriticalPHP));

if (count($g_CriticalPHP) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_016 . ' (' . count($g_CriticalPHP) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit');
  $l_PlainResult .= '[SERVER MALWARE]' . "\n" . printPlainList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit') . "\n";
  $l_Result .= '</div>' . PHP_EOL;

  $l_ShowOffer = true;
} else {
  $l_Result .= '<div class="ok"><b>' . AI_STR_017. '</b></div>';
}

stdOut("Building list of js " . count($g_CriticalJS));

if (count($g_CriticalJS) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_018 . ' (' . count($g_CriticalJS) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
  $l_PlainResult .= '[CLIENT MALWARE / JS]'  . "\n" . printPlainList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir') . "\n";
  $l_Result .= "</div>" . PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building phishing pages " . count($g_Phishing));

if (count($g_Phishing) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_058 . ' (' . count($g_Phishing) . ')</div><div class="crit">';
  $l_Result .= printList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
  $l_PlainResult .= '[PHISHING]'  . "\n" . printPlainList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir') . "\n";
  $l_Result .= "</div>". PHP_EOL;

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
  if (AI_EXPERT > 1) $l_ShowOffer = true;
  
  $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_020 . ' (' . count($g_Base64) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
  $l_Result .= printList($g_Base64, $g_Base64Fragment, true);
  $l_PlainResult .= '[ENCODED / SUSP_EXT]' . "\n" . printPlainList($g_Base64, $g_Base64Fragment, true) . "\n";
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
  $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
  $l_Result .= printList($g_NotRead);
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
  $l_PlainResult .= '[SCAN ERROR / SKIPPED]' . "\n" . implode("\n", replacePathArray($g_NotRead)) . "\n\n";
}

stdOut("Building list of symlinks " . count($g_SymLinks));

if (count($g_SymLinks) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SymLinks), true));
  $l_Result .= "</div><div class=\"spacer\"></div>";
}

stdOut("Building list of unix executables and odd scripts " . count($g_UnixExec));

if (count($g_UnixExec) > 0) {
  $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_019 . ' (' . count($g_UnixExec) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_UnixExec), true));
  $l_PlainResult .= '[UNIX EXEC]' . "\n" . implode("\n", replacePathArray($g_UnixExec)) . "\n\n";
  $l_Result .= "</div>" . PHP_EOL;

  if (AI_EXPERT > 1) $l_ShowOffer = true;
}

////////////////////////////////////
$l_WarningsNum = count($g_HeuristicDetected) + count($g_HiddenFiles) + count($g_BigFiles) + count($g_PHPCodeInside) + count($g_AdwareList) + count($g_EmptyLink) + count($g_Doorway) + (count($g_WarningPHP[0]) + count($g_WarningPHP[1]) + count($g_SkippedFolders));

if ($l_WarningsNum > 0) {
	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
}

stdOut("Building list of links/adware " . count($g_AdwareList));

if (count($g_AdwareList) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
  $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
  $l_PlainResult .= '[ADWARE]' . "\n" . printPlainList($g_AdwareList, $g_AdwareListFragment, true) . "\n";
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of heuristics " . count($g_HeuristicDetected));

if (count($g_HeuristicDetected) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
  for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
	   $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$g_HeuristicDetected[$i]], true) . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
  }
  
  $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;
}

stdOut("Building list of hidden files " . count($g_HiddenFiles));
if (count($g_HiddenFiles) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_023 . ' (' . count($g_HiddenFiles) . ')</div><div class="warn">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_HiddenFiles), true));
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
  $l_PlainResult .= '[HIDDEN]' . "\n" . implode("\n", replacePathArray($g_HiddenFiles)) . "\n\n";
}

stdOut("Building list of bigfiles " . count($g_BigFiles));
$max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
$max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');

if (count($g_BigFiles) > 0) {
  $l_Result .= "<div class=\"note_warn\">" . sprintf(AI_STR_038, bytes2Human($max_size_to_scan)) . '</div><div class="warn">';
  $l_Result .= printList($g_BigFiles);
  $l_Result .= "</div>";
  $l_PlainResult .= '[BIG FILES / SKIPPED]' . "\n" . printPlainList($g_BigFiles) . "\n\n";
} 

stdOut("Building list of php inj " . count($g_PHPCodeInside));

if ((count($g_PHPCodeInside) > 0) && (($defaults['report_mask'] & REPORT_MASK_PHPSIGN) == REPORT_MASK_PHPSIGN)) {
  $l_Result .= '<div class="note_warn">' . AI_STR_028 . '</div><div class="warn">';
  $l_Result .= printList($g_PHPCodeInside, $g_PHPCodeInsideFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of empty links " . count($g_EmptyLink));
if (count($g_EmptyLink) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_031 . '</div><div class="warn">';
  $l_Result .= printList($g_EmptyLink, '', true);

  $l_Result .= AI_STR_032 . '<br/>';
  
  if (count($g_EmptyLink) == MAX_EXT_LINKS) {
      $l_Result .= '(' . AI_STR_033 . MAX_EXT_LINKS . ')<br/>';
    }
   
  for ($i = 0; $i < count($g_EmptyLink); $i++) {
	$l_Idx = $g_EmptyLink[$i];
    for ($j = 0; $j < count($g_EmptyLinkSrc[$l_Idx]); $j++) {
      $l_Result .= '<span class="details">' . makeSafeFn($g_Structure['n'][$g_EmptyLink[$i]], true) . ' &rarr; ' . htmlspecialchars($g_EmptyLinkSrc[$l_Idx][$j]) . '</span><br/>';
	}
  }

  $l_Result .= "</div>";

}

stdOut("Building list of doorways " . count($g_Doorway));

if ((count($g_Doorway) > 0) && (($defaults['report_mask'] & REPORT_MASK_DOORWAYS) == REPORT_MASK_DOORWAYS)) {
  $l_Result .= '<div class="note_warn">' . AI_STR_034 . '</div><div class="warn">';
  $l_Result .= printList($g_Doorway);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of php warnings " . (count($g_WarningPHP[0]) + count($g_WarningPHP[1])));

if (($defaults['report_mask'] & REPORT_MASK_SUSP) == REPORT_MASK_SUSP) {
   if ((count($g_WarningPHP[0]) + count($g_WarningPHP[1])) > 0) {
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
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SkippedFolders), true));   
     $l_Result .= "</div>" . PHP_EOL;
 }

 if (count($g_CMS) > 0) {
      $l_Result .= "<div class=\"note_warn\">" . AI_STR_037 . "<br/>";
      $l_Result .= nl2br(makeSafeFn(implode("\n", $g_CMS)));
      $l_Result .= "</div>";
 }


if (ICHECK) {
	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_087 . "</div>";
	
    stdOut("Building list of added files " . count($changes['addedFiles']));
    if (count($changes['addedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_082 . ' (' . count($changes['addedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['addedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of modified files " . count($changes['modifiedFiles']));
    if (count($changes['modifiedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_083 . ' (' . count($changes['modifiedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['modifiedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted files " . count($changes['deletedFiles']));
    if (count($changes['deletedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_084 . ' (' . count($changes['deletedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['deletedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of added dirs " . count($changes['addedDirs']));
    if (count($changes['addedDirs']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_085 . ' (' . count($changes['addedDirs']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['addedDirs']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted dirs " . count($changes['deletedDirs']));
    if (count($changes['deletedDirs']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_086 . ' (' . count($changes['deletedDirs']) . ')</div><div class="intitem">';
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
    $l_PlainResult = preg_replace('|__AI_MARKER__|smi', ' %> ', $l_PlainResult);

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



///////////////////////////////////////////////////////////////////////////
function QCR_IntegrityCheck($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, 
			$defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, 
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SuspiciousFiles;
	global $g_IntegrityDB, $g_ICheck;
	static $l_Buffer = '';
	
	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;
	
	QCR_Debug('Check ' . $l_RootDir);

 	if ($l_DIRH = @opendir($l_RootDir))
	{
		while (($l_FileName = readdir($l_DIRH)) !== false)
		{
			if ($l_FileName == '.' || $l_FileName == '..') continue;

			$l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;

			$l_Type = filetype($l_FileName);
			$l_IsDir = ($l_Type == "dir");
            if ($l_Type == "link") 
            {
				$g_SymLinks[] = $l_FileName;
                continue;
            } else 
			if ($l_Type != "file" && (!$l_IsDir)) {
				$g_UnixExec[] = $l_FileName;
				continue;
			}	
						
			$l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);

			$l_NeedToScan = true;
			$l_Ext2 = substr(strstr(basename($l_FileName), '.'), 1);
			if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
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

				$l_DirCounter++;

				$g_Counter++;
				$g_FoundTotalDirs++;

				QCR_IntegrityCheck($l_FileName);

			} else
			{
				if ($l_NeedToScan)
				{
					$g_FoundTotalFiles++;
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
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . QUEUE_FILENAME);
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

	$hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';
	
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
		empty($l_Buffer) or file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
		return;
	}

	$l_RelativePath = getRelativePath($l_FileName);
		
	$hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';

	$l_Buffer .= "$l_RelativePath|$hash\n";
	
	if (strlen($l_Buffer) > 32000)
	{
		file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
	}
}

function load_integrity_db() {
	global $g_IntegrityDB;
	file_exists(INTEGRITY_DB_FILE) or die('Not found ' . INTEGRITY_DB_FILE);

	$s_file = new SplFileObject('compress.zlib://'.INTEGRITY_DB_FILE);
	$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

	foreach ($s_file as $line) {
		$i = strrpos($line, '|');
		if (!$i) continue;
		$g_IntegrityDB[substr($line, 0, $i)] = substr($line, $i+1);
	}

	$s_file = null;
}


function OptimizeSignatures()
{
	global $g_DBShe, $g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe;
	global $g_JSVirSig, $gX_JSVirSig;
	global $g_AdwareSig;
	global $g_PhishingSig;
	global $g_ExceptFlex, $g_SusDBPrio, $g_SusDB;

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
        optSig($g_SusDB);
        optSig($g_SusDBPrio);
        //optSig($g_ExceptFlex);

        // convert exception rules
        $cnt = count($g_ExceptFlex);
        for ($i = 0; $i < $cnt; $i++) {                		
            $g_ExceptFlex[$i] = trim(UnwrapObfu($g_ExceptFlex[$i]));
            if (!strlen($g_ExceptFlex[$i])) unset($g_ExceptFlex[$i]);
        }

        $g_ExceptFlex = array_values($g_ExceptFlex);
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
