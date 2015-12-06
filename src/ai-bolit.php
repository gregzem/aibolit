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

$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY0OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlsnIlwoXCRdIjtpOjEyMjtzOjExOiJcYm1haWxccypcKCI7aToxMjM7czo0NjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccypbJyJdezAsMX1waHA6Ly9pbnB1dCI7aToxMjQ7czoxMTg6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1Db250ZW50LXR5cGVbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfXRleHQvaHRtbDtccypjaGFyc2V0PXdpbmRvd3MtMTI1MVsnIl17MCwxfT48Ym9keT4iO2k6MTI1O3M6NjI6Ij1ccypkb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoXHMqWyciXXswLDF9c2NyaXB0WyciXXswLDF9XHMqXCk7IjtpOjEyNjtzOjY5OiJkb2N1bWVudFwuYm9keVwuaW5zZXJ0QmVmb3JlXChkaXYsXHMqZG9jdW1lbnRcLmJvZHlcLmNoaWxkcmVuXFswXF1cKTsiO2k6MTI3O3M6Nzc6IjxzY3JpcHRccyt0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vW2EtekEtWjAtOV9dKz9cLnBocCI+PC9zY3JpcHQ+IjtpOjEyODtzOjI3OiJlY2hvXHMrWyciXXswLDF9b2tbJyJdezAsMX0iO2k6MTI5O3M6MTg6Ii91c3Ivc2Jpbi9zZW5kbWFpbCI7aToxMzA7czoyMzoiL3Zhci9xbWFpbC9iaW4vc2VuZG1haWwiO30="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));
$g_DBShe = unserialize(base64_decode("YTo0MTg6e2k6MDtzOjU6InJhaHVpIjtpOjE7czozNToibW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbPHFxPkYxbDMiO2k6MjtzOjQ2OiIkdXNlckFnZW50cyA9IGFycmF5KCJHb29nbGUiLCAiU2x1cnAiLCAiTVNOQm90IjtpOjM7czo2OiJbM3Jhbl0iO2k6NDtzOjEwOiJEYXduX2FuZ2VsIjtpOjU7czo4OiJSM0RUVVhFUyI7aTo2O3M6MjA6InZpc2l0b3JUcmFja2VyX2lzTW9iIjtpOjc7czoyNDoiY29tX2NvbnRlbnQvYXJ0aWNsZWQucGhwIjtpOjg7czoxNzoiPHRpdGxlPkVtc1Byb3h5IHYiO2k6OTtzOjEzOiJhbmRyb2lkLWlncmEtIjtpOjEwO3M6MTU6Ij09PTo6Om1hZDo6Oj09PSI7aToxMTtzOjU6Ikg0eE9yIjtpOjEyO3M6ODoiUjRwSDR4MHIiO2k6MTM7czo4OiJORzY4OVNrdyI7aToxNDtzOjExOiJmb3BvLmNvbS5hciI7aToxNTtzOjk6IjY0LjY4LjgwLiI7aToxNjtzOjg6IkhhcmNoYUxpIjtpOjE3O3M6MTU6Inh4Ujk5bXVzdmllaTB4MCI7aToxODtzOjExOiJQLmgucC5TLnAueSI7aToxOTtzOjE0OiJfc2hlbGxfYXRpbGRpXyI7aToyMDtzOjk6In4gU2hlbGwgSSI7aToyMTtzOjY6IjB4ZGQ4MiI7aToyMjtzOjE0OiJBbnRpY2hhdCBzaGVsbCI7aToyMztzOjEyOiJBTEVNaU4gS1JBTGkiO2k6MjQ7czoxNjoiQVNQWCBTaGVsbCBieSBMVCI7aToyNTtzOjk6ImFaUmFpTFBoUCI7aToyNjtzOjIyOiJDb2RlZCBCeSBDaGFybGljaGFwbGluIjtpOjI3O3M6NzoiQmwwb2QzciI7aToyODtzOjEyOiJCWSBpU0tPUlBpVFgiO2k6Mjk7czoxMToiZGV2aWx6U2hlbGwiO2k6MzA7czozMDoiV3JpdHRlbiBieSBDYXB0YWluIENydW5jaCBUZWFtIjtpOjMxO3M6OToiYzIwMDcucGhwIjtpOjMyO3M6MjI6IkM5OSBNb2RpZmllZCBCeSBQc3ljaDAiO2k6MzM7czoxNzoiJGM5OXNoX3VwZGF0ZWZ1cmwiO2k6MzQ7czo5OiJDOTkgU2hlbGwiO2k6MzU7czoyMjoiY29va2llbmFtZSA9ICJ3aWVlZWVlIiI7aTozNjtzOjM4OiJDb2RlZCBieSA6IFN1cGVyLUNyeXN0YWwgYW5kIE1vaGFqZXIyMiI7aTozNztzOjEyOiJDcnlzdGFsU2hlbGwiO2k6Mzg7czoyMzoiVEVBTSBTQ1JJUFRJTkcgLSBST0ROT0MiO2k6Mzk7czoxMToiQ3liZXIgU2hlbGwiO2k6NDA7czo3OiJkMG1haW5zIjtpOjQxO3M6MTM6IkRhcmtEZXZpbHouaU4iO2k6NDI7czoyNDoiU2hlbGwgd3JpdHRlbiBieSBCbDBvZDNyIjtpOjQzO3M6MzM6IkRpdmUgU2hlbGwgLSBFbXBlcm9yIEhhY2tpbmcgVGVhbSI7aTo0NDtzOjE1OiJEZXZyLWkgTWVmc2VkZXQiO2k6NDU7czozMjoiQ29tYW5kb3MgRXhjbHVzaXZvcyBkbyBEVG9vbCBQcm8iO2k6NDY7czoyMDoiRW1wZXJvciBIYWNraW5nIFRFQU0iO2k6NDc7czoyMDoiRml4ZWQgYnkgQXJ0IE9mIEhhY2siO2k6NDg7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjQ5O3M6Mjc6Ikx1dGZlbiBEb3N5YXlpIEFkbGFuZGlyaW5peiI7aTo1MDtzOjIyOiJ0aGlzIGlzIGEgcHJpdjMgc2VydmVyIjtpOjUxO3M6MTM6IkdGUyBXZWItU2hlbGwiO2k6NTI7czoxMToiR0hDIE1hbmFnZXIiO2k6NTM7czoxNDoiR29vZzFlX2FuYWxpc3QiO2k6NTQ7czoxMzoiR3JpbmF5IEdvMG8kRSI7aTo1NTtzOjI5OiJoNG50dSBzaGVsbCBbcG93ZXJlZCBieSB0c29pXSI7aTo1NjtzOjI1OiJIYWNrZWQgQnkgRGV2ci1pIE1lZnNlZGV0IjtpOjU3O3M6MTc6IkhBQ0tFRCBCWSBSRUFMV0FSIjtpOjU4O3M6MzI6IkhhY2tlcmxlciBWdXJ1ciBMYW1lcmxlciBTdXJ1bnVyIjtpOjU5O3M6MTE6ImlNSGFCaVJMaUdpIjtpOjYwO3M6OToiS0FfdVNoZWxsIjtpOjYxO3M6NzoiTGl6MHppTSI7aTo2MjtzOjExOiJMb2N1czdTaGVsbCI7aTo2MztzOjM2OiJNb3JvY2NhbiBTcGFtZXJzIE1hLUVkaXRpb04gQnkgR2hPc1QiO2k6NjQ7czoxMDoiTWF0YW11IE1hdCI7aTo2NTtzOjUwOiJPcGVuIHRoZSBmaWxlIGF0dGFjaG1lbnQgaWYgYW55LCBhbmQgYmFzZTY0X2VuY29kZSI7aTo2NjtzOjY6Im0wcnRpeCI7aTo2NztzOjU6Im0waHplIjtpOjY4O3M6MTA6Ik1hdGFtdSBNYXQiO2k6Njk7czoxNjoiTW9yb2NjYW4gU3BhbWVycyI7aTo3MDtzOjE1OiIkTXlTaGVsbFZlcnNpb24iO2k6NzE7czo5OiJNeVNRTCBSU1QiO2k6NzI7czoxOToiTXlTUUwgV2ViIEludGVyZmFjZSI7aTo3MztzOjI3OiJNeVNRTCBXZWIgSW50ZXJmYWNlIFZlcnNpb24iO2k6NzQ7czoxNDoiTXlTUUwgV2Vic2hlbGwiO2k6NzU7czo4OiJOM3RzaGVsbCI7aTo3NjtzOjE2OiJIYWNrZWQgYnkgU2lsdmVyIjtpOjc3O3M6NzoiTmVvSGFjayI7aTo3ODtzOjIxOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAiO2k6Nzk7czoyMDoiTklYIFJFTU9URSBXRUItU0hFTEwiO2k6ODA7czoyNjoiTyBCaVIgS1JBTCBUQUtMaVQgRURpbEVNRVoiO2k6ODE7czoxODoiUEhBTlRBU01BLSBOZVcgQ21EIjtpOjgyO3M6MjE6IlBJUkFURVMgQ1JFVyBXQVMgSEVSRSI7aTo4MztzOjIxOiJhIHNpbXBsZSBwaHAgYmFja2Rvb3IiO2k6ODQ7czoyMDoiTE9URlJFRSBQSFAgQmFja2Rvb3IiO2k6ODU7czozMToiTmV3cyBSZW1vdGUgUEhQIFNoZWxsIEluamVjdGlvbiI7aTo4NjtzOjk6IlBIUEphY2thbCI7aTo4NztzOjIwOiJQSFAgSFZBIFNoZWxsIFNjcmlwdCI7aTo4ODtzOjEzOiJwaHBSZW1vdGVWaWV3IjtpOjg5O3M6MzU6IlBIUCBTaGVsbCBpcyBhbmludGVyYWN0aXZlIFBIUC1wYWdlIjtpOjkwO3M6NjoiUEhWYXl2IjtpOjkxO3M6MjY6IlBQUyAxLjAgcGVybC1jZ2kgd2ViIHNoZWxsIjtpOjkyO3M6MjI6IlByZXNzIE9LIHRvIGVudGVyIHNpdGUiO2k6OTM7czoyMjoicHJpdmF0ZSBTaGVsbCBieSBtNHJjbyI7aTo5NDtzOjU6InIwbmluIjtpOjk1O3M6NjoiUjU3U3FsIjtpOjk2O3M6MTM6InI1N3NoZWxsXC5waHAiO2k6OTc7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjk4O3M6MjA6InJlYWxhdXRoPVN2QkQ4NWRJTnUzIjtpOjk5O3M6MTY6IlJ1MjRQb3N0V2ViU2hlbGwiO2k6MTAwO3M6MjE6IktBZG90IFVuaXZlcnNhbCBTaGVsbCI7aToxMDE7czoxMDoiQ3JAenlfS2luZyI7aToxMDI7czoyMDoiU2FmZV9Nb2RlIEJ5cGFzcyBQSFAiO2k6MTAzO3M6MTc6IlNhcmFzYU9uIFNlcnZpY2VzIjtpOjEwNDtzOjI1OiJTaW1wbGUgUEhQIGJhY2tkb29yIGJ5IERLIjtpOjEwNTtzOjE5OiJHLVNlY3VyaXR5IFdlYnNoZWxsIjtpOjEwNjtzOjI1OiJTaW1vcmdoIFNlY3VyaXR5IE1hZ2F6aW5lIjtpOjEwNztzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToxMDg7czoxMzoiU1NJIHdlYi1zaGVsbCI7aToxMDk7czoxMToiU3Rvcm03U2hlbGwiO2k6MTEwO3M6OToiVGhlX0JlS2lSIjtpOjExMTtzOjk6IlczRCBTaGVsbCI7aToxMTI7czoxMzoidzRjazFuZyBzaGVsbCI7aToxMTM7czoxMToiV2ViQ29udHJvbHMiO2k6MTE0O3M6Mjg6ImRldmVsb3BlZCBieSBEaWdpdGFsIE91dGNhc3QiO2k6MTE1O3M6MzI6IldhdGNoIFlvdXIgc3lzdGVtIFNoYW55IHdhcyBoZXJlIjtpOjExNjtzOjEyOiJXZWIgU2hlbGwgYnkiO2k6MTE3O3M6MTM6IldTTzIgV2Vic2hlbGwiO2k6MTE4O3M6MzM6Ik5ldHdvcmtGaWxlTWFuYWdlclBIUCBmb3IgY2hhbm5lbCI7aToxMTk7czoyNzoiU21hbGwgUEhQIFdlYiBTaGVsbCBieSBaYUNvIjtpOjEyMDtzOjEwOiJNcmxvb2wuZXhlIjtpOjEyMTtzOjY6IlNFb0RPUiI7aToxMjI7czo5OiJNci5IaVRtYW4iO2k6MTIzO3M6NToiZDNiflgiO2k6MTI0O3M6MTY6IkNvbm5lY3RCYWNrU2hlbGwiO2k6MTI1O3M6MTA6IkJZIE1NTkJPQloiO2k6MTI2O3M6MjY6Ik9MQjpQUk9EVUNUOk9OTElORV9CQU5LSU5HIjtpOjEyNztzOjEwOiJDMGRlcnouY29tIjtpOjEyODtzOjc6Ik1ySGF6ZW0iO2k6MTI5O3M6OToidjBsZDNtMHJ0IjtpOjEzMDtzOjY6IkshTEwzciI7aToxMzE7czoxMDoiRHIuYWJvbGFsaCI7aToxMzI7czozMDoiJHJhbmRfd3JpdGFibGVfZm9sZGVyX2Z1bGxwYXRoIjtpOjEzMztzOjg0OiI8dGV4dGFyZWEgbmFtZT1cInBocGV2XCIgcm93cz1cIjVcIiBjb2xzPVwiMTUwXCI+Ii5AJF9QT1NUWydwaHBldiddLiI8L3RleHRhcmVhPjxicj4iO2k6MTM0O3M6MTY6ImM5OWZ0cGJydXRlY2hlY2siO2k6MTM1O3M6OToiQnkgUHN5Y2gwIjtpOjEzNjtzOjE3OiIkYzk5c2hfdXBkYXRlZnVybCI7aToxMzc7czoxNDoidGVtcF9yNTdfdGFibGUiO2k6MTM4O3M6MTc6ImFkbWluQHNweWdydXAub3JnIjtpOjEzOTtzOjc6ImNhc3VzMTUiO2k6MTQwO3M6MTM6IldTQ1JJUFQuU0hFTEwiO2k6MTQxO3M6NDc6IkV4ZWN1dGVkIGNvbW1hbmQ6IDxiPjxmb250IGNvbG9yPSNkY2RjZGM+WyRjbWRdIjtpOjE0MjtzOjExOiJjdHNoZWxsLnBocCI7aToxNDM7czoxNToiRFhfSGVhZGVyX2RyYXduIjtpOjE0NDtzOjg2OiJjcmxmLid1bmxpbmsoJG5hbWUpOycuJGNybGYuJ3JlbmFtZSgifiIuJG5hbWUsICRuYW1lKTsnLiRjcmxmLid1bmxpbmsoImdycF9yZXBhaXIucGhwIiI7aToxNDU7czoxMDU6Ii8wdFZTRy9TdXYwVXIvaGFVWUFkbjNqTVF3YmJvY0dmZkFlQzI5Qk45dG1CaUpkVjFsaytqWURVOTJDOTRqZHREaWYreE9Zakc2Q0xoeDMxVW85eDkvZUFXZ3NCSzYwa0sybUx3cXpxZCI7aToxNDY7czoxMTU6Im1wdHkoJF9QT1NUWyd1ciddKSkgJG1vZGUgfD0gMDQwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V3J10pKSAkbW9kZSB8PSAwMjAwOyBpZiAoIWVtcHR5KCRfUE9TVFsndXgnXSkpICRtb2RlIHw9IDAxMDAiO2k6MTQ3O3M6Mzc6ImtsYXN2YXl2LmFzcD95ZW5pZG9zeWE9PCU9YWt0aWZrbGFzJT4iO2k6MTQ4O3M6MTIyOiJudCkoZGlza190b3RhbF9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iICIgLiAiRnJlZSBzcGFjZSAiIC4gKGludCkoZGlza19mcmVlX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgPCI7aToxNDk7czo3NjoiYSBocmVmPSI8P2VjaG8gIiRmaXN0aWsucGhwP2RpemluPSRkaXppbi8uLi8iPz4iIHN0eWxlPSJ0ZXh0LWRlY29yYXRpb246IG5vbiI7aToxNTA7czozODoiUm9vdFNoZWxsIScpO3NlbGYubG9jYXRpb24uaHJlZj0naHR0cDoiO2k6MTUxO3M6OTA6IjwlPVJlcXVlc3QuU2VydmVyVmFyaWFibGVzKCJzY3JpcHRfbmFtZSIpJT4/Rm9sZGVyUGF0aD08JT1TZXJ2ZXIuVVJMUGF0aEVuY29kZShGb2xkZXIuRHJpdiI7aToxNTI7czoxNjA6InByaW50KChpc19yZWFkYWJsZSgkZikgJiYgaXNfd3JpdGVhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiLncoMSkuZm9udCgncmVkJywnUlcnLDMpKS53KDEpOigoKGlzX3JlYWRhYmxlKCRmKSk/Ijx0cj48dGQ+Ii53KDEpLmIoIlIiKS53KDQpOiIiKS4oKGlzX3dyaXRhYmwiO2k6MTUzO3M6MTYxOiIoJyInLCcmcXVvdDsnLCRmbikpLiciO2RvY3VtZW50Lmxpc3Quc3VibWl0KCk7XCc+Jy5odG1sc3BlY2lhbGNoYXJzKHN0cmxlbigkZm4pPmZvcm1hdD9zdWJzdHIoJGZuLDAsZm9ybWF0LTMpLicuLi4nOiRmbikuJzwvYT4nLnN0cl9yZXBlYXQoJyAnLGZvcm1hdC1zdHJsZW4oJGZuKSI7aToxNTQ7czoxMToiemVoaXJoYWNrZXIiO2k6MTU1O3M6Mzk6IkpAIVZyQComUkhSd35KTHcuR3x4bGhuTEp+PzEuYndPYnhiUHwhViI7aToxNTY7czozOToiV1NPc2V0Y29va2llKG1kNSgkX1NFUlZFUlsnSFRUUF9IT1NUJ10pIjtpOjE1NztzOjE0MToiPC90ZD48dGQgaWQ9ZmE+WyA8YSB0aXRsZT1cIkhvbWU6ICciLmh0bWxzcGVjaWFsY2hhcnMoc3RyX3JlcGxhY2UoIlwiLCAkc2VwLCBnZXRjd2QoKSkpLiInLlwiIGlkPWZhIGhyZWY9XCJqYXZhc2NyaXB0OlZpZXdEaXIoJyIucmF3dXJsZW5jb2RlIjtpOjE1ODtzOjE2OiJDb250ZW50LVR5cGU6ICRfIjtpOjE1OTtzOjg2OiI8bm9icj48Yj4kY2RpciRjZmlsZTwvYj4gKCIuJGZpbGVbInNpemVfc3RyIl0uIik8L25vYnI+PC90ZD48L3RyPjxmb3JtIG5hbWU9Y3Vycl9maWxlPiI7aToxNjA7czo0ODoid3NvRXgoJ3RhciBjZnp2ICcgLiBlc2NhcGVzaGVsbGFyZygkX1BPU1RbJ3AyJ10pIjtpOjE2MTtzOjE0MjoiNWpiMjBpS1c5eUlITjBjbWx6ZEhJb0pISmxabVZ5WlhJc0ltRndiM0owSWlrZ2IzSWdjM1J5YVhOMGNpZ2tjbVZtWlhKbGNpd2libWxuYldFaUtTQnZjaUJ6ZEhKcGMzUnlLQ1J5WldabGNtVnlMQ0ozWldKaGJIUmhJaWtnYjNJZ2MzUnlhWE4wY2lnayI7aToxNjI7czo3NjoiTFMwZ1JIVnRjRE5rSUdKNUlGQnBjblZzYVc0dVVFaFFJRmRsWW5Ob00yeHNJSFl4TGpBZ1l6QmtaV1FnWW5rZ2NqQmtjakVnT2t3PSI7aToxNjM7czo2NToiaWYgKGVyZWcoJ15bWzpibGFuazpdXSpjZFtbOmJsYW5rOl1dKyhbXjtdKykkJywgJGNvbW1hbmQsICRyZWdzKSkiO2k6MTY0O3M6NDY6InJvdW5kKDArOTgzMC40Kzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCkpPT0iO2k6MTY1O3M6MTI6IlBIUFNIRUxMLlBIUCI7aToxNjY7czoyMDoiU2hlbGwgYnkgTWF3YXJfSGl0YW0iO2k6MTY3O3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6MTY4O3M6MTM6Inc0Y2sxbmcgc2hlbGwiO2k6MTY5O3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aToxNzA7czo0MjoiV29ya2VyX0dldFJlcGx5Q29kZSgkb3BEYXRhWydyZWN2QnVmZmVyJ10pIjtpOjE3MTtzOjQwOiIkZmlsZXBhdGg9QHJlYWxwYXRoKCRfUE9TVFsnZmlsZXBhdGgnXSk7IjtpOjE3MjtzOjg4OiIkcmVkaXJlY3RVUkw9J2h0dHA6Ly8nLiRyU2l0ZS4kX1NFUlZFUlsnUkVRVUVTVF9VUkknXTtpZihpc3NldCgkX1NFUlZFUlsnSFRUUF9SRUZFUkVSJ10pIjtpOjE3MztzOjE3OiJyZW5hbWUoIndzby5waHAiLCI7aToxNzQ7czo1NDoiJE1lc3NhZ2VTdWJqZWN0ID0gYmFzZTY0X2RlY29kZSgkX1BPU1RbIm1zZ3N1YmplY3QiXSk7IjtpOjE3NTtzOjQ0OiJjb3B5KCRfRklMRVNbeF1bdG1wX25hbWVdLCRfRklMRVNbeF1bbmFtZV0pKSI7aToxNzY7czo1ODoiU0VMRUNUIDEgRlJPTSBteXNxbC51c2VyIFdIRVJFIGNvbmNhdChgdXNlcmAsICdAJywgYGhvc3RgKSI7aToxNzc7czoyMToiIUAkX0NPT0tJRVskc2Vzc2R0X2tdIjtpOjE3ODtzOjQ4OiIkYT0oc3Vic3RyKHVybGVuY29kZShwcmludF9yKGFycmF5KCksMSkpLDUsMSkuYykiO2k6MTc5O3M6NTY6InhoIC1zICIvdXNyL2xvY2FsL2FwYWNoZS9zYmluL2h0dHBkIC1EU1NMIiAuL2h0dHBkIC1tICQxIjtpOjE4MDtzOjE4OiJwd2QgPiBHZW5lcmFzaS5kaXIiO2k6MTgxO3M6MTI6IkJSVVRFRk9SQ0lORyI7aToxODI7czozMToiQ2F1dGFtIGZpc2llcmVsZSBkZSBjb25maWd1cmFyZSI7aToxODM7czozMjoiJGthPSc8Py8vQlJFJzska2FrYT0ka2EuJ0FDSy8vPz4iO2k6MTg0O3M6ODU6IiRzdWJqPXVybGRlY29kZSgkX0dFVFsnc3UnXSk7JGJvZHk9dXJsZGVjb2RlKCRfR0VUWydibyddKTskc2RzPXVybGRlY29kZSgkX0dFVFsnc2QnXSkiO2k6MTg1O3M6Mzk6IiRfX19fPUBnemluZmxhdGUoJF9fX18pKXtpZihpc3NldCgkX1BPUyI7aToxODY7czozNzoicGFzc3RocnUoZ2V0ZW52KCJIVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxODc7czo4OiJBc21vZGV1cyI7aToxODg7czo1MDoiZm9yKDskcGFkZHI9YWNjZXB0KENMSUVOVCwgU0VSVkVSKTtjbG9zZSBDTElFTlQpIHsiO2k6MTg5O3M6NTk6IiRpemlubGVyMj1zdWJzdHIoYmFzZV9jb252ZXJ0KEBmaWxlcGVybXMoJGZuYW1lKSwxMCw4KSwtNCk7IjtpOjE5MDtzOjQyOiIkYmFja2Rvb3ItPmNjb3B5KCRjZmljaGllciwkY2Rlc3RpbmF0aW9uKTsiO2k6MTkxO3M6MjM6Inske3Bhc3N0aHJ1KCRjbWQpfX08YnI+IjtpOjE5MjtzOjI5OiIkYVtoaXRzXScpOyBcclxuI2VuZHF1ZXJ5XHJcbiI7aToxOTM7czoyNjoibmNmdHBwdXQgLXUgJGZ0cF91c2VyX25hbWUiO2k6MTk0O3M6MzY6ImV4ZWNsKCIvYmluL3NoIiwic2giLCItaSIsKGNoYXIqKTApOyI7aToxOTU7czozMToiPEhUTUw+PEhFQUQ+PFRJVExFPmNnaS1zaGVsbC5weSI7aToxOTY7czozODoic3lzdGVtKCJ1bnNldCBISVNURklMRTsgdW5zZXQgU0FWRUhJU1QiO2k6MTk3O3M6MjM6IiRsb2dpbj1AcG9zaXhfZ2V0dWlkKCk7IjtpOjE5ODtzOjYwOiIoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0qJCcsICRfUkVRVUVTVFsnY29tbWFuZCddKSkiO2k6MTk5O3M6MjU6IiEkX1JFUVVFU1RbImM5OXNoX3N1cmwiXSkiO2k6MjAwO3M6NTM6IlBuVmxrV002MyFAI0AmZEt4fm5NRFdNfkR/L0Vzbn54fzZEQCNAJlB+fiw/blksV1B7UG9qIjtpOjIwMTtzOjM2OiJzaGVsbF9leGVjKCRfUE9TVFsnY21kJ10gLiAiIDI+JjEiKTsiO2k6MjAyO3M6MzU6ImlmKCEkd2hvYW1pKSR3aG9hbWk9ZXhlYygid2hvYW1pIik7IjtpOjIwMztzOjYxOiJQeVN5c3RlbVN0YXRlLmluaXRpYWxpemUoU3lzdGVtLmdldFByb3BlcnRpZXMoKSwgbnVsbCwgYXJndik7IjtpOjIwNDtzOjM2OiI8JT1lbnYucXVlcnlIYXNodGFibGUoInVzZXIubmFtZSIpJT4iO2k6MjA1O3M6ODM6ImlmIChlbXB0eSgkX1BPU1RbJ3dzZXInXSkpIHskd3NlciA9ICJ3aG9pcy5yaXBlLm5ldCI7fSBlbHNlICR3c2VyID0gJF9QT1NUWyd3c2VyJ107IjtpOjIwNjtzOjkxOiJpZiAobW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbJ2ZpbGEnXVsndG1wX25hbWUnXSwgJGN1cmRpci4iLyIuJF9GSUxFU1snZmlsYSddWyduYW1lJ10pKSB7IjtpOjIwNztzOjIzOiJzaGVsbF9leGVjKCd1bmFtZSAtYScpOyI7aToyMDg7czo0NzoiaWYgKCFkZWZpbmVkJHBhcmFte2NtZH0peyRwYXJhbXtjbWR9PSJscyAtbGEifTsiO2k6MjA5O3M6NjA6ImlmKGdldF9tYWdpY19xdW90ZXNfZ3BjKCkpJHNoZWxsT3V0PXN0cmlwc2xhc2hlcygkc2hlbGxPdXQpOyI7aToyMTA7czo4NDoiPGEgaHJlZj0nJFBIUF9TRUxGP2FjdGlvbj12aWV3U2NoZW1hJmRibmFtZT0kZGJuYW1lJnRhYmxlbmFtZT0kdGFibGVuYW1lJz5TY2hlbWE8L2E+IjtpOjIxMTtzOjY2OiJwYXNzdGhydSggJGJpbmRpci4ibXlzcWxkdW1wIC0tdXNlcj0kVVNFUk5BTUUgLS1wYXNzd29yZD0kUEFTU1dPUkQiO2k6MjEyO3M6NjY6Im15c3FsX3F1ZXJ5KCJDUkVBVEUgVEFCTEUgYHhwbG9pdGAgKGB4cGxvaXRgIExPTkdCTE9CIE5PVCBOVUxMKSIpOyI7aToyMTM7czo4NzoiJHJhNDQgID0gcmFuZCgxLDk5OTk5KTskc2o5OCA9ICJzaC0kcmE0NCI7JG1sID0gIiRzZDk4IjskYTUgPSAkX1NFUlZFUlsnSFRUUF9SRUZFUkVSJ107IjtpOjIxNDtzOjUyOiIkX0ZJTEVTWydwcm9iZSddWydzaXplJ10sICRfRklMRVNbJ3Byb2JlJ11bJ3R5cGUnXSk7IjtpOjIxNTtzOjcxOiJzeXN0ZW0oIiRjbWQgMT4gL3RtcC9jbWR0ZW1wIDI+JjE7IGNhdCAvdG1wL2NtZHRlbXA7IHJtIC90bXAvY21kdGVtcCIpOyI7aToyMTY7czo2OToifSBlbHNpZiAoJHNlcnZhcmcgPX4gL15cOiguKz8pXCEoLis/KVxAKC4rPykgUFJJVk1TRyAoLis/KSBcOiguKykvKSB7IjtpOjIxNztzOjY5OiJzZW5kKFNPQ0s1LCAkbXNnLCAwLCBzb2NrYWRkcl9pbigkcG9ydGEsICRpYWRkcikpIGFuZCAkcGFjb3Rlc3tvfSsrOzsiO2k6MjE4O3M6MTg6IiRmZSgiJGNtZCAgMj4mMSIpOyI7aToyMTk7czo2ODoid2hpbGUgKCRyb3cgPSBteXNxbF9mZXRjaF9hcnJheSgkcmVzdWx0LE1ZU1FMX0FTU09DKSkgcHJpbnRfcigkcm93KTsiO2k6MjIwO3M6NTI6ImVsc2VpZihAaXNfd3JpdGFibGUoJEZOKSAmJiBAaXNfZmlsZSgkRk4pKSAkdG1wT3V0TUYiO2k6MjIxO3M6NzI6ImNvbm5lY3QoU09DS0VULCBzb2NrYWRkcl9pbigkQVJHVlsxXSwgaW5ldF9hdG9uKCRBUkdWWzBdKSkpIG9yIGRpZSBwcmludCI7aToyMjI7czo4OToiaWYobW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbImZpYyJdWyJ0bXBfbmFtZSJdLGdvb2RfbGluaygiLi8iLiRfRklMRVNbImZpYyJdWyJuYW1lIl0pKSkiO2k6MjIzO3M6ODc6IlVOSU9OIFNFTEVDVCAnMCcgLCAnPD8gc3lzdGVtKFwkX0dFVFtjcGNdKTtleGl0OyA/PicgLDAgLDAgLDAgLDAgSU5UTyBPVVRGSUxFICckb3V0ZmlsZSI7aToyMjQ7czo2ODoiaWYgKCFAaXNfbGluaygkZmlsZSkgJiYgKCRyID0gcmVhbHBhdGgoJGZpbGUpKSAhPSBGQUxTRSkgJGZpbGUgPSAkcjsiO2k6MjI1O3M6Mjk6ImVjaG8gIkZJTEUgVVBMT0FERUQgVE8gJGRleiI7IjtpOjIyNjtzOjI0OiIkZnVuY3Rpb24oJF9QT1NUWydjbWQnXSkiO2k6MjI3O3M6Mzg6IiRmaWxlbmFtZSA9ICRiYWNrdXBzdHJpbmcuIiRmaWxlbmFtZSI7IjtpOjIyODtzOjQ4OiJpZignJz09KCRkZj1AaW5pX2dldCgnZGlzYWJsZV9mdW5jdGlvbnMnKSkpe2VjaG8iO2k6MjI5O3M6NDY6IjwlIEZvciBFYWNoIFZhcnMgSW4gUmVxdWVzdC5TZXJ2ZXJWYXJpYWJsZXMgJT4iO2k6MjMwO3M6MzM6ImlmICgkZnVuY2FyZyA9fiAvXnBvcnRzY2FuICguKikvKSI7aToyMzE7czo1NToiJHVwbG9hZGZpbGUgPSAkcnBhdGguIi8iIC4gJF9GSUxFU1sndXNlcmZpbGUnXVsnbmFtZSddOyI7aToyMzI7czoyNjoiJGNtZCA9ICgkX1JFUVVFU1RbJ2NtZCddKTsiO2k6MjMzO3M6Mzg6ImlmKCRjbWQgIT0gIiIpIHByaW50IFNoZWxsX0V4ZWMoJGNtZCk7IjtpOjIzNDtzOjI5OiJpZiAoaXNfZmlsZSgiL3RtcC8kZWtpbmNpIikpeyI7aToyMzU7czo2OToiX19hbGxfXyA9IFsiU01UUFNlcnZlciIsIkRlYnVnZ2luZ1NlcnZlciIsIlB1cmVQcm94eSIsIk1haWxtYW5Qcm94eSJdIjtpOjIzNjtzOjU5OiJnbG9iYWwgJG15c3FsSGFuZGxlLCAkZGJuYW1lLCAkdGFibGVuYW1lLCAkb2xkX25hbWUsICRuYW1lLCI7aToyMzc7czoyNzoiMj4mMSAxPiYyIiA6ICIgMT4mMSAyPiYxIik7IjtpOjIzODtzOjUyOiJtYXAgeyByZWFkX3NoZWxsKCRfKSB9ICgkc2VsX3NoZWxsLT5jYW5fcmVhZCgwLjAxKSk7IjtpOjIzOTtzOjIyOiJmd3JpdGUgKCRmcCwgIiR5YXppIik7IjtpOjI0MDtzOjUxOiJTZW5kIHRoaXMgZmlsZTogPElOUFVUIE5BTUU9InVzZXJmaWxlIiBUWVBFPSJmaWxlIj4iO2k6MjQxO3M6NDI6IiRkYl9kID0gQG15c3FsX3NlbGVjdF9kYigkZGF0YWJhc2UsJGNvbjEpOyI7aToyNDI7czo2NzoiZm9yICgkdmFsdWUpIHsgcy8mLyZhbXA7L2c7IHMvPC8mbHQ7L2c7IHMvPi8mZ3Q7L2c7IHMvIi8mcXVvdDsvZzsgfSI7aToyNDM7czo3NDoiY29weSgkX0ZJTEVTWyd1cGtrJ11bJ3RtcF9uYW1lJ10sImtrLyIuYmFzZW5hbWUoJF9GSUxFU1sndXBrayddWyduYW1lJ10pKTsiO2k6MjQ0O3M6ODY6ImZ1bmN0aW9uIGdvb2dsZV9ib3QoKSB7JHNVc2VyQWdlbnQgPSBzdHJ0b2xvd2VyKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSk7aWYoIShzdHJwIjtpOjI0NTtzOjc1OiJjcmVhdGVfZnVuY3Rpb24oIiYkIi4iZnVuY3Rpb24iLCIkIi4iZnVuY3Rpb24gPSBjaHIob3JkKCQiLiJmdW5jdGlvbiktMyk7IikiO2k6MjQ2O3M6NDY6ImxvbmcgaW50OnQoMCwzKT1yKDAsMyk7LTIxNDc0ODM2NDg7MjE0NzQ4MzY0NzsiO2k6MjQ3O3M6NDY6Ij91cmw9Jy4kX1NFUlZFUlsnSFRUUF9IT1NUJ10pLnVubGluayhST09UX0RJUi4iO2k6MjQ4O3M6MzY6ImNhdCAke2Jsa2xvZ1syXX0gfCBncmVwICJyb290Ong6MDowIiI7aToyNDk7czo5NzoiQHBhdGgxPSgnYWRtaW4vJywnYWRtaW5pc3RyYXRvci8nLCdtb2RlcmF0b3IvJywnd2ViYWRtaW4vJywnYWRtaW5hcmVhLycsJ2JiLWFkbWluLycsJ2FkbWluTG9naW4vJyI7aToyNTA7czo4NzoiImFkbWluMS5waHAiLCAiYWRtaW4xLmh0bWwiLCAiYWRtaW4yLnBocCIsICJhZG1pbjIuaHRtbCIsICJ5b25ldGltLnBocCIsICJ5b25ldGltLmh0bWwiIjtpOjI1MTtzOjY4OiJQT1NUIHskcGF0aH17JGNvbm5lY3Rvcn0/Q29tbWFuZD1GaWxlVXBsb2FkJlR5cGU9RmlsZSZDdXJyZW50Rm9sZGVyPSI7aToyNTI7czozMDoiQGFzc2VydCgkX1JFUVVFU1RbJ1BIUFNFU1NJRCddIjtpOjI1MztzOjYxOiIkcHJvZD0ic3kiLiJzIi4idGVtIjskaWQ9JHByb2QoJF9SRVFVRVNUWydwcm9kdWN0J10pOyR7J2lkJ307IjtpOjI1NDtzOjE1OiJwaHAgIi4kd3NvX3BhdGgiO2k6MjU1O3M6Nzc6IiRGY2htb2QsJEZkYXRhLCRPcHRpb25zLCRBY3Rpb24sJGhkZGFsbCwkaGRkZnJlZSwkaGRkcHJvYywkdW5hbWUsJGlkZCk6c2hhcmVkIjtpOjI1NjtzOjUxOiJzZXJ2ZXIuPC9wPlxyXG48L2JvZHk+PC9odG1sPiI7ZXhpdDt9aWYocHJlZ19tYXRjaCgiO2k6MjU3O3M6OTU6IiRmaWxlID0gJF9GSUxFU1siZmlsZW5hbWUiXVsibmFtZSJdOyBlY2hvICI8YSBocmVmPVwiJGZpbGVcIj4kZmlsZTwvYT4iO30gZWxzZSB7ZWNobygiZW1wdHkiKTt9IjtpOjI1ODtzOjYwOiJGU19jaGtfZnVuY19saWJjPSggJChyZWFkZWxmIC1zICRGU19saWJjIHwgZ3JlcCBfY2hrQEAgfCBhd2siO2k6MjU5O3M6NDA6ImZpbmQgLyAtbmFtZSAuc3NoID4gJGRpci9zc2hrZXlzL3NzaGtleXMiO2k6MjYwO3M6MzM6InJlLmZpbmRhbGwoZGlydCsnKC4qKScscHJvZ25tKVswXSI7aToyNjE7czo2MDoib3V0c3RyICs9IHN0cmluZy5Gb3JtYXQoIjxhIGhyZWY9Jz9mZGlyPXswfSc+ezF9LzwvYT4mbmJzcDsiIjtpOjI2MjtzOjgzOiI8JT1SZXF1ZXN0LlNlcnZlcnZhcmlhYmxlcygiU0NSSVBUX05BTUUiKSU+P3R4dHBhdGg9PCU9UmVxdWVzdC5RdWVyeVN0cmluZygidHh0cGF0aCI7aToyNjM7czo3MToiUmVzcG9uc2UuV3JpdGUoU2VydmVyLkh0bWxFbmNvZGUodGhpcy5FeGVjdXRlQ29tbWFuZCh0eHRDb21tYW5kLlRleHQpKSkiO2k6MjY0O3M6MTExOiJuZXcgRmlsZVN0cmVhbShQYXRoLkNvbWJpbmUoZmlsZUluZm8uRGlyZWN0b3J5TmFtZSwgUGF0aC5HZXRGaWxlTmFtZShodHRwUG9zdGVkRmlsZS5GaWxlTmFtZSkpLCBGaWxlTW9kZS5DcmVhdGUiO2k6MjY1O3M6OTA6IlJlc3BvbnNlLldyaXRlKCI8YnI+KCApIDxhIGhyZWY9P3R5cGU9MSZmaWxlPSIgJiBzZXJ2ZXIuVVJMZW5jb2RlKGl0ZW0ucGF0aCkgJiAiXD4iICYgaXRlbSI7aToyNjY7czoxMDQ6InNxbENvbW1hbmQuUGFyYW1ldGVycy5BZGQoKChUYWJsZUNlbGwpZGF0YUdyaWRJdGVtLkNvbnRyb2xzWzBdKS5UZXh0LCBTcWxEYlR5cGUuRGVjaW1hbCkuVmFsdWUgPSBkZWNpbWFsIjtpOjI2NztzOjY0OiI8JT0gIlwiICYgb1NjcmlwdE5ldC5Db21wdXRlck5hbWUgJiAiXCIgJiBvU2NyaXB0TmV0LlVzZXJOYW1lICU+IjtpOjI2ODtzOjUwOiJjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfVVJMLCAiaHR0cDovLyRob3N0OjIwODIiKSI7aToyNjk7czo1ODoiSEozSGp1dGNrb1JmcFhmOUExelFPMkF3RFJyUmV5OXVHdlRlZXo3OXFBYW8xYTByZ3Vka1prUjhSYSI7aToyNzA7czozMToiJGluaVsndXNlcnMnXSA9IGFycmF5KCdyb290JyA9PiI7aToyNzE7czoxODoicHJvY19vcGVuKCdJSFN0ZWFtIjtpOjI3MjtzOjI0OiIkYmFzbGlrPSRfUE9TVFsnYmFzbGlrJ10iO2k6MjczO3M6MzA6ImZyZWFkKCRmcCwgZmlsZXNpemUoJGZpY2hlcm8pKSI7aToyNzQ7czozOToiSS9nY1ovdlgwQTEwRERSRGc3RXprL2QrMys4cXZxcVMxSzArQVhZIjtpOjI3NTtzOjE2OiJ7JF9QT1NUWydyb290J119IjtpOjI3NjtzOjI5OiJ9ZWxzZWlmKCRfR0VUWydwYWdlJ109PSdkZG9zJyI7aToyNzc7czoxNDoiVGhlIERhcmsgUmF2ZXIiO2k6Mjc4O3M6Mzk6IiR2YWx1ZSA9fiBzLyUoLi4pL3BhY2soJ2MnLGhleCgkMSkpL2VnOyI7aToyNzk7czoxMToid3d3LnQwcy5vcmciO2k6MjgwO3M6MzA6InVubGVzcyhvcGVuKFBGRCwkZ191cGxvYWRfZGIpKSI7aToyODE7czoxMjoiYXo4OHBpeDAwcTk4IjtpOjI4MjtzOjExOiJzaCBnbyAkMS4keCI7aToyODM7czoyNjoic3lzdGVtKCJwaHAgLWYgeHBsICRob3N0IikiO2k6Mjg0O3M6MTM6ImV4cGxvaXRjb29raWUiO2k6Mjg1O3M6MjE6IjgwIC1iICQxIC1pIGV0aDAgLXMgOCI7aToyODY7czoyNToiSFRUUCBmbG9vZCBjb21wbGV0ZSBhZnRlciI7aToyODc7czoxNToiTklHR0VSUy5OSUdHRVJTIjtpOjI4ODtzOjQ3OiJpZihpc3NldCgkX0dFVFsnaG9zdCddKSYmaXNzZXQoJF9HRVRbJ3RpbWUnXSkpeyI7aToyODk7czo4Mzoic3VicHJvY2Vzcy5Qb3BlbihjbWQsIHNoZWxsID0gVHJ1ZSwgc3Rkb3V0PXN1YnByb2Nlc3MuUElQRSwgc3RkZXJyPXN1YnByb2Nlc3MuU1RET1UiO2k6MjkwO3M6Njk6ImRlZiBkYWVtb24oc3RkaW49Jy9kZXYvbnVsbCcsIHN0ZG91dD0nL2Rldi9udWxsJywgc3RkZXJyPScvZGV2L251bGwnKSI7aToyOTE7czo2NzoicHJpbnQoIlshXSBIb3N0OiAiICsgaG9zdG5hbWUgKyAiIG1pZ2h0IGJlIGRvd24hXG5bIV0gUmVzcG9uc2UgQ29kZSI7aToyOTI7czo0MjoiY29ubmVjdGlvbi5zZW5kKCJzaGVsbCAiK3N0cihvcy5nZXRjd2QoKSkrIjtpOjI5MztzOjUwOiJvcy5zeXN0ZW0oJ2VjaG8gYWxpYXMgbHM9Ii5scy5iYXNoIiA+PiB+Ly5iYXNocmMnKSI7aToyOTQ7czozMjoicnVsZV9yZXEgPSByYXdfaW5wdXQoIlNvdXJjZUZpcmUiO2k6Mjk1O3M6NTc6ImFyZ3BhcnNlLkFyZ3VtZW50UGFyc2VyKGRlc2NyaXB0aW9uPWhlbHAsIHByb2c9InNjdHVubmVsIiI7aToyOTY7czo1Nzoic3VicHJvY2Vzcy5Qb3BlbignJXNnZGIgLXAgJWQgLWJhdGNoICVzJyAlIChnZGJfcHJlZml4LCBwIjtpOjI5NztzOjU5OiIkZnJhbWV3b3JrLnBsdWdpbnMubG9hZCgiI3tycGN0eXBlLmRvd25jYXNlfXJwYyIsIG9wdHMpLnJ1biI7aToyOTg7czoyODoiaWYgc2VsZi5oYXNoX3R5cGUgPT0gJ3B3ZHVtcCI7aToyOTk7czoxNzoiaXRzb2tub3Byb2JsZW1icm8iO2k6MzAwO3M6NDU6ImFkZF9maWx0ZXIoJ3RoZV9jb250ZW50JywgJ19ibG9naW5mbycsIDEwMDAxKSI7aTozMDE7czo5OiI8c3RkbGliLmgiO2k6MzAyO3M6NTk6ImVjaG8geSA7IHNsZWVwIDEgOyB9IHwgeyB3aGlsZSByZWFkIDsgZG8gZWNobyB6JFJFUExZOyBkb25lIjtpOjMwMztzOjExOiJWT0JSQSBHQU5HTyI7aTozMDQ7czo3NjoiaW50MzIoKCgkeiA+PiA1ICYgMHgwN2ZmZmZmZikgXiAkeSA8PCAyKSArICgoJHkgPj4gMyAmIDB4MWZmZmZmZmYpIF4gJHogPDwgNCI7aTozMDU7czo2OToiQGNvcHkoJF9GSUxFU1tmaWxlTWFzc11bdG1wX25hbWVdLCRfUE9TVFtwYXRoXS4kX0ZJTEVTW2ZpbGVNYXNzXVtuYW1lIjtpOjMwNjtzOjQ2OiJmaW5kX2RpcnMoJGdyYW5kcGFyZW50X2RpciwgJGxldmVsLCAxLCAkZGlycyk7IjtpOjMwNztzOjI4OiJAc2V0Y29va2llKCJoaXQiLCAxLCB0aW1lKCkrIjtpOjMwODtzOjU6ImUvKi4vIjtpOjMwOTtzOjM3OiJKSFpwYzJsMFkyOTFiblFnUFNBa1NGUlVVRjlEVDA5TFNVVmZWIjtpOjMxMDtzOjM1OiIwZDBhMGQwYTY3NmM2ZjYyNjE2YzIwMjQ2ZDc5NWY3MzZkNyI7aTozMTE7czoxOToiZm9wZW4oJy9ldGMvcGFzc3dkJyI7aTozMTI7czo3NjoiJHRzdTJbcmFuZCgwLGNvdW50KCR0c3UyKSAtIDEpXS4kdHN1MVtyYW5kKDAsY291bnQoJHRzdTEpIC0gMSldLiR0c3UyW3JhbmQoMCI7aTozMTM7czozMzoiL3Vzci9sb2NhbC9hcGFjaGUvYmluL2h0dHBkIC1EU1NMIjtpOjMxNDtzOjIwOiJzZXQgcHJvdGVjdC10ZWxuZXQgMCI7aTozMTU7czoyNzoiYXl1IHByMSBwcjIgcHIzIHByNCBwcjUgcHI2IjtpOjMxNjtzOjMwOiJiaW5kIGZpbHQgLSAiXDAwMUFDVElPTiAqXDAwMSIiO2k6MzE3O3M6NTA6InJlZ3N1YiAtYWxsIC0tICwgW3N0cmluZyB0b2xvd2VyICRvd25lcl0gIiIgb3duZXJzIjtpOjMxODtzOjM1OiJraWxsIC1DSExEIFwkYm90cGlkID4vZGV2L251bGwgMj4mMSI7aTozMTk7czoxMDoiYmluZCBkY2MgLSI7aTozMjA7czoyNDoicjRhVGMuZFBudEUvZnp0U0YxYkgzUkgwIjtpOjMyMTtzOjEzOiJwcml2bXNnICRjaGFuIjtpOjMyMjtzOjIyOiJiaW5kIGpvaW4gLSAqIGdvcF9qb2luIjtpOjMyMztzOjQzOiJzZXQgZ29vZ2xlKGRhdGEpIFtodHRwOjpkYXRhICRnb29nbGUocGFnZSldIjtpOjMyNDtzOjI2OiJwcm9jIGh0dHA6OkNvbm5lY3Qge3Rva2VufSI7aTozMjU7czoxMzoicHJpdm1zZyAkbmljayI7aTozMjY7czoxMToicHV0Ym90ICRib3QiO2k6MzI3O3M6MTI6InVuYmluZCBSQVcgLSI7aTozMjg7czoyOToiLS1EQ0NESVIgW2xpbmRleCAkVXNlcigkaSkgMl0iO2k6MzI5O3M6MTA6IkN5YmVzdGVyOTAiO2k6MzMwO3M6NDE6ImZpbGVfZ2V0X2NvbnRlbnRzKHRyaW0oJGZbJF9HRVRbJ2lkJ11dKSk7IjtpOjMzMTtzOjIxOiJ1bmxpbmsoJHdyaXRhYmxlX2RpcnMiO2k6MzMyO3M6Mjc6ImJhc2U2NF9kZWNvZGUoJGNvZGVfc2NyaXB0KSI7aTozMzM7czoyMToibHVjaWZmZXJAbHVjaWZmZXIub3JnIjtpOjMzNDtzOjQ4OiIkdGhpcy0+Ri0+R2V0Q29udHJvbGxlcigkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6MzM1O3M6NDc6IiR0aW1lX3N0YXJ0ZWQuJHNlY3VyZV9zZXNzaW9uX3VzZXIuc2Vzc2lvbl9pZCgpIjtpOjMzNjtzOjc0OiIkcGFyYW0geCAkbi5zdWJzdHIgKCRwYXJhbSwgbGVuZ3RoKCRwYXJhbSkgLSBsZW5ndGgoJGNvZGUpJWxlbmd0aCgkcGFyYW0pKSI7aTozMzc7czozNjoiZndyaXRlKCRmLGdldF9kb3dubG9hZCgkX0dFVFsndXJsJ10pIjtpOjMzODtzOjY1OiJodHRwOi8vJy4kX1NFUlZFUlsnSFRUUF9IT1NUJ10udXJsZGVjb2RlKCRfU0VSVkVSWydSRVFVRVNUX1VSSSddKSI7aTozMzk7czo4MDoid3BfcG9zdHMgV0hFUkUgcG9zdF90eXBlID0gJ3Bvc3QnIEFORCBwb3N0X3N0YXR1cyA9ICdwdWJsaXNoJyBPUkRFUiBCWSBgSURgIERFU0MiO2k6MzQwO3M6Mzc6IiR1cmwgPSAkdXJsc1tyYW5kKDAsIGNvdW50KCR1cmxzKS0xKV0iO2k6MzQxO3M6NDc6InByZWdfbWF0Y2goJy8oPzw9UmV3cml0ZVJ1bGUpLiooPz1cW0xcLFJcPTMwMlxdIjtpOjM0MjtzOjQ1OiJwcmVnX21hdGNoKCchTUlEUHxXQVB8V2luZG93cy5DRXxQUEN8U2VyaWVzNjAiO2k6MzQzO3M6NjA6IlIwbEdPRGxoRXdBUUFMTUFBQUFBQVAvLy81eWNBTTdPWS8vL25QLy96di9PblBmMzkvLy8vd0FBQUFBQSI7aTozNDQ7czo2NToic3RyX3JvdDEzKCRiYXNlYVsoJGRpbWVuc2lvbiokZGltZW5zaW9uLTEpIC0gKCRpKiRkaW1lbnNpb24rJGopXSkiO2k6MzQ1O3M6NzU6ImlmKGVtcHR5KCRfR0VUWyd6aXAnXSkgYW5kIGVtcHR5KCRfR0VUWydkb3dubG9hZCddKSAmIGVtcHR5KCRfR0VUWydpbWcnXSkpeyI7aTozNDY7czoxNjoiTWFkZSBieSBEZWxvcmVhbiI7aTozNDc7czo0Njoib3ZlcmZsb3cteTpzY3JvbGw7XCI+Ii4kbGlua3MuJGh0bWxfbWZbJ2JvZHknXSI7aTozNDg7czo0MzoiZnVuY3Rpb24gdXJsR2V0Q29udGVudHMoJHVybCwgJHRpbWVvdXQgPSA1KSI7aTozNDk7czo2OiJkM2xldGUiO2k6MzUwO3M6MTU6ImxldGFrc2VrYXJhbmcoKSI7aTozNTE7czo4OiJZRU5JM0VSSSI7aTozNTI7czoyMToiJE9PTzAwMDAwMD11cmxkZWNvZGUoIjtpOjM1MztzOjIwOiItSS91c3IvbG9jYWwvYmFuZG1pbiI7aTozNTQ7czozNzoiZndyaXRlKCRmcHNldHYsIGdldGVudigiSFRUUF9DT09LSUUiKSI7aTozNTU7czoyNToiaXNzZXQoJF9QT1NUWydleGVjZ2F0ZSddKSI7aTozNTY7czoxNToiV2ViY29tbWFuZGVyIGF0IjtpOjM1NztzOjE0OiI9PSAiYmluZHNoZWxsIiI7aTozNTg7czo4OiJQYXNoa2VsYSI7aTozNTk7czoyNToiY3JlYXRlRmlsZXNGb3JJbnB1dE91dHB1dCI7aTozNjA7czo2OiJNNGxsM3IiO2k6MzYxO3M6MjA6Il9fVklFV1NUQVRFRU5DUllQVEVEIjtpOjM2MjtzOjc6Ik9vTl9Cb3kiO2k6MzYzO3M6MTM6IlJlYUxfUHVOaVNoRXIiO2k6MzY0O3M6ODoiZGFya21pbnoiO2k6MzY1O3M6NToiWmVkMHgiO2k6MzY2O3M6NDA6ImFiYWNob3xhYml6ZGlyZWN0b3J5fGFib3V0fGFjb29ufGFsZXhhbmEiO2k6MzY3O3M6MzY6InBwY3xtaWRwfHdpbmRvd3MgY2V8bXRrfGoybWV8c3ltYmlhbiI7aTozNjg7czo0NzoiQGNocigoJGhbJGVbJG9dXTw8NCkrKCRoWyRlWysrJG9dXSkpO319ZXZhbCgkZCkiO2k6MzY5O3M6MTE6IiRzaDNsbENvbG9yIjtpOjM3MDtzOjEwOiJQdW5rZXIyQm90IjtpOjM3MTtzOjE4OiI8P3BocCBlY2hvICIjISEjIjsiO2k6MzcyO3M6NzU6IiRpbT1zdWJzdHIoJGltLDAsJGkpLnN1YnN0cigkaW0sJGkyKzEsJGk0LSgkaTIrMSkpLnN1YnN0cigkaW0sJGk0KzEyLHN0cmxlbiI7aTozNzM7czo1NToiKCRpbmRhdGEsJGI2ND0xKXtpZigkYjY0PT0xKXskY2Q9YmFzZTY0X2RlY29kZSgkaW5kYXRhKSI7aTozNzQ7czoxNzoiKCRfUE9TVFsiZGlyIl0pKTsiO2k6Mzc1O3M6MTc6IkhhY2tlZCBCeSBFbkRMZVNzIjtpOjM3NjtzOjEwOiJhbmRleHxvb2dsIjtpOjM3NztzOjEwOiJuZHJvaXxodGNfIjtpOjM3ODtzOjEwOiI8ZG90PklySXNUIjtpOjM3OTtzOjIxOiI3UDF0ZCtOV2xpYUkvaFdrWjRWWDkiO2k6MzgwO3M6MTU6Ik5pbmphVmlydXMgSGVyZSI7aTozODE7czozMjoiJGltPXN1YnN0cigkdHgsJHArMiwkcDItKCRwKzIpKTsiO2k6MzgyO3M6NjoiM3hwMXIzIjtpOjM4MztzOjIwOiIkbWQ1PW1kNSgiJHJhbmRvbSIpOyI7aTozODQ7czoyODoib1RhdDhEM0RzRTgnJn5oVTA2Q0NINTskZ1lTcSI7aTozODU7czoxMjoiR0lGODlBOzw/cGhwIjtpOjM4NjtzOjE1OiJDcmVhdGVkIEJ5IEVNTUEiO2k6Mzg3O3M6MzQ6IlBhc3N3b3JkOjxzPiIuJF9QT1NUWzxxPnBhc3N3ZDxxPl0iO2k6Mzg4O3M6MTU6Ik5ldEBkZHJlc3MgTWFpbCI7aTozODk7czoyNDoiJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjM5MDtzOjExOiJCYWJ5X0RyYWtvbiI7aTozOTE7czozMDoiZndyaXRlKGZvcGVuKGRpcm5hbWUoX19GSUxFX18pIjtpOjM5MjtzOjEzOiJdXSkpO319ZXZhbCgkIjtpOjM5MztzOjI3OiJlcmVnX3JlcGxhY2UoPHE+JmVtYWlsJjxxPiwiO2k6Mzk0O3M6MTk6Iik7ICRpKyspJHJldC49Y2hyKCQiO2k6Mzk1O3M6NTc6IiRwYXJhbTJtYXNrLiIpXD1bXDxxcT5cIl0oLio/KSg/PVtcPHFxPlwiXSApW1w8cXE+XCJdL3NpZSI7aTozOTY7czo5OiIvL3Jhc3RhLy8iO2k6Mzk3O3M6MjA6IjwhLS1DT09LSUUgVVBEQVRFLS0+IjtpOjM5ODtzOjEzOiJwcm9mZXhvci5oZWxsIjtpOjM5OTtzOjEzOiJNYWdlbGFuZ0N5YmVyIjtpOjQwMDtzOjg6IlpPQlVHVEVMIjtpOjQwMTtzOjIxOiJkYXRhOnRleHQvaHRtbDtiYXNlNjQiO2k6NDAyO3M6ODoiU19dQF9eVV4iO2k6NDAzO3M6MTM6IkAkX1BPU1RbKGNocigiO2k6NDA0O3M6MTI6Ilplcm9EYXlFeGlsZSI7aTo0MDU7czoxMjoiU3VsdGFuSGFpa2FsIjtpOjQwNjtzOjExOiJDb3VwZGVncmFjZSI7aTo0MDc7czo5OiJhcnRpY2tsZUAiO2k6NDA4O3M6MTU6ImduaXRyb3Blcl9yb3JyZSI7aTo0MDk7czoyMzoiY3V0dGVyW2F0XXJlYWwueGFrZXAucnUiO2k6NDEwO3M6Mjk6ImlmKCR3cF9fd3A9QGd6aW5mbGF0ZSgkd3BfX3dwIjtpOjQxMTtzOjY6InIwMG5peCI7aTo0MTI7czoyMToiJGZ1bGxfcGF0aF90b19kb29yd2F5IjtpOjQxMztzOjMwOiI8Yj5Eb25lID09PiAkdXNlcmZpbGVfbmFtZTwvYj4iO2k6NDE0O3M6MTI6Ij5EYXJrIFNoZWxsPCI7aTo0MTU7czoxNToiLy4uLyovaW5kZXgucGhwIjtpOjQxNjtzOjMyOiJpZihpc191cGxvYWRlZF9maWxlLyo7Ki8oJF9GSUxFUyI7aTo0MTc7czoyMzoiZXhlYygkY29tbWFuZCwgJG91dHB1dCkiO30="));
$gX_DBShe = unserialize(base64_decode("YTo2Mjp7aTowO3M6NzoiZGVmYWNlciI7aToxO3M6MjQ6IllvdSBjYW4gcHV0IGEgbWQ1IHN0cmluZyI7aToyO3M6ODoicGhwc2hlbGwiO2k6MztzOjYyOiI8ZGl2IGNsYXNzPSJibG9jayBidHlwZTEiPjxkaXYgY2xhc3M9ImR0b3AiPjxkaXYgY2xhc3M9ImRidG0iPiI7aTo0O3M6ODoiYzk5c2hlbGwiO2k6NTtzOjg6InI1N3NoZWxsIjtpOjY7czo3OiJOVERhZGR5IjtpOjc7czo4OiJjaWhzaGVsbCI7aTo4O3M6NzoiRnhjOTlzaCI7aTo5O3M6MTI6IldlYiBTaGVsbCBieSI7aToxMDtzOjExOiJkZXZpbHpTaGVsbCI7aToxMTtzOjg6Ik4zdHNoZWxsIjtpOjEyO3M6MTE6IlN0b3JtN1NoZWxsIjtpOjEzO3M6MTE6IkxvY3VzN1NoZWxsIjtpOjE0O3M6MTI6InI1N3NoZWxsLnBocCI7aToxNTtzOjk6ImFudGlzaGVsbCI7aToxNjtzOjk6InJvb3RzaGVsbCI7aToxNztzOjExOiJteXNoZWxsZXhlYyI7aToxODtzOjg6IlNoZWxsIE9rIjtpOjE5O3M6MTQ6ImV4ZWMoInJtIC1yIC1mIjtpOjIwO3M6MTg6Ik5lIHVkYWxvcyB6YWdydXppdCI7aToyMTtzOjUxOiIkbWVzc2FnZSA9IGVyZWdfcmVwbGFjZSgiJTVDJTIyIiwgIiUyMiIsICRtZXNzYWdlKTsiO2k6MjI7czoxOToicHJpbnQgIlNwYW1lZCc+PGJyPiI7aToyMztzOjQwOiJzZXRjb29raWUoICJteXNxbF93ZWJfYWRtaW5fdXNlcm5hbWUiICk7IjtpOjI0O3M6Mzc6ImVsc2VpZihmdW5jdGlvbl9leGlzdHMoInNoZWxsX2V4ZWMiKSkiO2k6MjU7czo1OToiaWYgKGlzX2NhbGxhYmxlKCJleGVjIikgYW5kICFpbl9hcnJheSgiZXhlYyIsJGRpc2FibGVmdW5jKSkiO2k6MjY7czozNDoiaWYgKCgkcGVybXMgJiAweEMwMDApID09IDB4QzAwMCkgeyI7aToyNztzOjEwOiJkaXIgL09HIC9YIjtpOjI4O3M6MzY6ImluY2x1ZGUoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKSI7aToyOTtzOjc6ImJyMHdzM3IiO2k6MzA7czo0OToiJ2h0dHBkLmNvbmYnLCd2aG9zdHMuY29uZicsJ2NmZy5waHAnLCdjb25maWcucGhwJyI7aTozMTtzOjM0OiIvcHJvYy9zeXMva2VybmVsL3lhbWEvcHRyYWNlX3Njb3BlIjtpOjMyO3M6MjM6ImV2YWwoZmlsZV9nZXRfY29udGVudHMoIjtpOjMzO3M6MTg6ImlzX3dyaXRhYmxlKCIvdmFyLyI7aTozNDtzOjE0OiIkR0xPQkFMU1snX19fXyI7aTozNTtzOjU1OiJpc19jYWxsYWJsZSgnZXhlYycpIGFuZCAhaW5fYXJyYXkoJ2V4ZWMnLCAkZGlzYWJsZWZ1bmNzIjtpOjM2O3M6NjoiazBkLmNjIjtpOjM3O3M6MjY6ImdtYWlsLXNtdHAtaW4ubC5nb29nbGUuY29tIjtpOjM4O3M6Nzoid2VicjAwdCI7aTozOTtzOjExOiJEZXZpbEhhY2tlciI7aTo0MDtzOjc6IkRlZmFjZXIiO2k6NDE7czoxMToiWyBQaHByb3h5IF0iO2k6NDI7czo4OiJbY29kZXJ6XSI7aTo0MztzOjMyOiI8IS0tI2V4ZWMgY21kPSIkSFRUUF9BQ0NFUFQiIC0tPiI7aTo0NDtzOjEyOiJdW3JvdW5kKDApXSgiO2k6NDU7czoxMToiU2ltQXR0YWNrZXIiO2k6NDY7czoxNToiRGFya0NyZXdGcmllbmRzIjtpOjQ3O3M6NzoiazJsbDMzZCI7aTo0ODtzOjc6IktrSzEzMzciO2k6NDk7czoxNToiSEFDS0VEIEJZIFNUT1JNIjtpOjUwO3M6MTQ6Ik1leGljYW5IYWNrZXJzIjtpOjUxO3M6MTU6Ik1yLlNoaW5jaGFuWDE5NiI7aTo1MjtzOjk6IkRlaWRhcmF+WCI7aTo1MztzOjEwOiJKaW5wYW50b216IjtpOjU0O3M6OToiMW43M2N0MTBuIjtpOjU1O3M6MTQ6IktpbmdTa3J1cGVsbG9zIjtpOjU2O3M6MTA6IkppbnBhbnRvbXoiO2k6NTc7czo5OiJDZW5naXpIYW4iO2k6NTg7czo5OiJyM3Yzbmc0bnMiO2k6NTk7czo5OiJCTEFDS1VOSVgiO2k6NjA7czo4OiJGaWxlc01hbiI7aTo2MTtzOjk6ImFydGlja2xlQCI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNzA6e2k6MDtzOjEwMDoiSU86OlNvY2tldDo6SU5FVC0+bmV3XChQcm90b1xzKj0+XHMqInRjcCJccyosXHMqTG9jYWxQb3J0XHMqPT5ccyozNjAwMFxzKixccypMaXN0ZW5ccyo9PlxzKlNPTUFYQ09OTiI7aToxO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjM7czoxMToiYnlccytHcmluYXkiO2k6NDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjU7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjY7czozNToiZGVmYXVsdF9hY3Rpb25ccyo9XHMqXFxbJyJdRmlsZXNNYW4iO2k6NztzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6ODtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6OTtzOjc0OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX0hPU1RbJyJdXHMqXF1ccypcKSI7aToxMDtzOjEwNzoid3NvRXhccypcKFxzKlxcWyciXVxzKnRhclxzKmNmenZccypcXFsnIl1ccypcLlxzKmVzY2FwZXNoZWxsYXJnXHMqXChccypcJF9QT1NUXFtccypcXFsnIl1wMlxcWyciXVxzKlxdXHMqXCkiO2k6MTE7czo0MDoiZXZhbFxzKlwoKlxzKmJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyI7aToxMjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MTM7czo3NDoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXWZpbGVwYXRoWyciXVxzKlxdXHMqXCkiO2k6MTQ7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MTU7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToxNjtzOjg3OiJTRUxFQ1RccysxXHMrRlJPTVxzK215c3FsXC51c2VyXHMrV0hFUkVccytjb25jYXRcKFxzKmB1c2VyYFxzKixccyonQCdccyosXHMqYGhvc3RgXHMqXCkiO2k6MTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTg7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxOTtzOjU1OiJ7XHMqXCRccyp7XHMqcGFzc3RocnVccypcKCpccypcJGNtZFxzKlwpXHMqfVxzKn1ccyo8YnI+IjtpOjIwO3M6ODI6InJ1bmNvbW1hbmRccypcKFxzKlsnIl1zaGVsbGhlbHBbJyJdXHMqLFxzKlsnIl0oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl0iO2k6MjE7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyMjtzOjM3OiJcJGxvZ2luXHMqPVxzKkAqcG9zaXhfZ2V0dWlkXCgqXHMqXCkqIjtpOjIzO3M6NDk6IiFAKlwkX1JFUVVFU1RccypcW1xzKlsnIl1jOTlzaF9zdXJsWyciXVxzKlxdXHMqXCkiO2k6MjQ7czoxMjQ6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF9QT1NUXHMqXFtccypbJyJdLis/WyciXVxzKlxdXHMqXC5ccyoiXHMqMlxzKj5ccyomMVxzKlsnIl0iO2k6MjU7czo4NjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJddW5hbWVccystYVsnIl1ccypcKSoiO2k6MjY7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6Mjc7czoxNDE6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyODtzOjI4OiJcJGZlXChbJyJdXCRjbWRccysyPiYxWyciXVwpIjtpOjI5O3M6OTY6IlwkZnVuY3Rpb25ccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1jbWRbJyJdezAsMX1ccypcXVxzKlwpKiI7aTozMDtzOjkzOiJcJGNtZFxzKj1ccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqXCkiO2k6MzE7czoyMToiZXZhMVthLXpBLVowLTlfXSs/U2lyIjtpOjMyO3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjMzO3M6Mjg6InBocFxzK1snIl1ccypcLlxzKlwkd3NvX3BhdGgiO2k6MzQ7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aTozNTtzOjQ1OiJzeXN0ZW1ccypcKCpccypbJyJdezAsMX13aG9hbWlbJyJdezAsMX1ccypcKSoiO2k6MzY7czo4ODoiY3VybF9zZXRvcHRccypcKFxzKlwkY2hccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqWyciXXswLDF9aHR0cDovL1wkaG9zdDpcZCtbJyJdezAsMX1ccypcKSI7aTozNztzOjg4OiJcJGluaVxzKlxbXHMqWyciXXswLDF9dXNlcnNbJyJdezAsMX1ccypcXVxzKj1ccyphcnJheVxzKlwoXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKj0+IjtpOjM4O3M6MzM6InByb2Nfb3BlblxzKlwoXHMqWyciXXswLDF9SUhTdGVhbSI7aTozOTtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjQwO3M6ODE6IlxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKlxdXHMqfSI7aTo0MTtzOjQ2OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdezAsMX0vXC5cKi9lWyciXXswLDF9IjtpOjQyO3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aTo0MztzOjc0OiJAKnNldGNvb2tpZVxzKlwoKlxzKlsnIl17MCwxfWhpdFsnIl17MCwxfSxccyoxXHMqLFxzKnRpbWVccypcKCpccypcKSpccypcKyI7aTo0NDtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aTo0NTtzOjU5OiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BccypcKCpccypAKlwkXyI7aTo0NjtzOjQzOiJmb3BlblxzKlwoKlxzKlsnIl17MCwxfS9ldGMvcGFzc3dkWyciXXswLDF9IjtpOjQ3O3M6MjQ6IlwkR0xPQkFMU1xbWyciXXswLDF9X19fXyI7aTo0ODtzOjIxMzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX0oZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqLFxzKlwkZGlzYWJsZWZ1bmNzIjtpOjQ5O3M6MTEyOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKnRyaW1ccypcKFxzKlwkLis/XFtcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Lis/WyciXXswLDF9XF1cXVwpXCk7IjtpOjUwO3M6MTM2OiJ3cF9wb3N0c1xzK1dIRVJFXHMrcG9zdF90eXBlXHMqPVxzKlsnIl17MCwxfXBvc3RbJyJdezAsMX1ccytBTkRccytwb3N0X3N0YXR1c1xzKj1ccypbJyJdezAsMX1wdWJsaXNoWyciXXswLDF9XHMrT1JERVJccytCWVxzK2BJRGBccytERVNDIjtpOjUxO3M6MjA6ImV4ZWNccypcKFxzKlsnIl1pcGZ3IjtpOjUyO3M6NDI6InN0cnJldlwoKlxzKlsnIl17MCwxfXRyZXNzYVsnIl17MCwxfVxzKlwpKiI7aTo1MztzOjQ5OiJzdHJyZXZcKCpccypbJyJdezAsMX1lZG9jZWRfNDZlc2FiWyciXXswLDF9XHMqXCkqIjtpOjU0O3M6NzA6ImZ1bmN0aW9uXHMrdXJsR2V0Q29udGVudHNccypcKCpccypcJHVybFxzKixccypcJHRpbWVvdXRccyo9XHMqXGQrXHMqXCkiO2k6NTU7czoyNjoic3ltbGlua1xzKlwoKlxzKlsnIl0vaG9tZS8iO2k6NTY7czo3MToiZndyaXRlXHMqXCgqXHMqXCRmcHNldHZccyosXHMqZ2V0ZW52XHMqXChccypbJyJdSFRUUF9DT09LSUVbJyJdXHMqXClccyoiO2k6NTc7czo2NjoiaXNzZXRccypcKCpccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1leGVjZ2F0ZVsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjU4O3M6MjAwOiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX1ccyosXHMqWyciXXswLDF9PFw/IHN5c3RlbVwoXFxcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbY3BjXF1cKTtleGl0O1xzKlw/PlsnIl17MCwxfVxzKixccyowXHMqLDBccyosXHMqMFxzKixccyowXHMrSU5UT1xzK09VVEZJTEVccytbJyJdezAsMX1cJFsnIl17MCwxfSI7aTo1OTtzOjE0OToiXCRHTE9CQUxTXFtbJyJdezAsMX0uKz9bJyJdezAsMX1cXT1BcnJheVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXClccyosXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXCkiO2k6NjA7czo3MzoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCpcWy4rP1xdXD8vZVsnIl17MCwxfVxzKixccypzdHJfcmVwbGFjZSI7aTo2MTtzOjEwMToiXCRHTE9CQUxTXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxbXHMqXGQrXHMqXF1cKFxzKlwkX1xkK1xzKixccypfXGQrXHMqXChccypcZCtccypcKVxzKlwpXHMqXCkiO2k6NjI7czoxMTU6IlwkYmVlY29kZVxzKj1AKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqWyciXXswLDF9XHMqXCR1cmxwdXJzXHMqWyciXXswLDF9XCkqXHMqO1xzKmVjaG9ccytbJyJdezAsMX1cJGJlZWNvZGVbJyJdezAsMX0iO2k6NjM7czo3OToiXCR4XGQrXHMqPVxzKlsnIl0uKz9bJyJdXHMqO1xzKlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXSI7aTo2NDtzOjQzOiI8XD9waHBccytcJF9GXHMqPVxzKl9fRklMRV9fXHMqO1xzKlwkX1hccyo9IjtpOjY1O3M6Njg6ImlmXHMrXCgqXHMqbWFpbFxzKlwoXHMqXCRyZWNwXHMqLFxzKlwkc3VialxzKixccypcJHN0dW50XHMqLFxzKlwkZnJtIjtpOjY2O3M6MTM5OiJpZlxzK1woXHMqc3RycG9zXHMqXChccypcJHVybFxzKixccypbJyJdanMvbW9vdG9vbHNcLmpzWyciXVxzKlwpXHMqPT09XHMqZmFsc2VccysmJlxzK3N0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL2NhcHRpb25cLmpzWyciXXswLDF9IjtpOjY3O3M6ODE6ImV2YWxccypcKCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BcKCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo2ODtzOjI2MToiaWZccypcKCpccyppc3NldFxzKlwoKlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF1ccypcKSpccypcKVxzKntccypcJFthLXpBLVpfMC05XStccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVthLXpBLVpfMC05XStbJyJdezAsMX1ccypcXTtccypldmFsXHMqXCgqXHMqXCRbYS16QS1aXzAtOV0rXHMqXCkqIjtpOjY5O3M6MTIzOiJwcmVnX3JlcGxhY2VccypcKFxzKlsnIl0vXF5cKHd3d1x8ZnRwXClcXFwuL2lbJyJdXHMqLFxzKlsnIl1bJyJdLFxzKkBcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxzKlxdXHMqXCkiO2k6NzA7czoxMDE6ImlmXHMqXCghZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdcG9zaXhfZ2V0cHd1aWRbJyJdXHMqXClccyomJlxzKiFpbl9hcnJheVxzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkIjtpOjcxO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6NzI7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6NzM7czoyMzoiXChccypbJyJdSU5TSEVMTFsnIl1ccyoiO2k6NzQ7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjc1O3M6OTQ6ImFycmF5X3BvcFxzKlwoKlxzKlwkd29ya1JlcGxhY2VccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccyosXHMqXCRjb3VudEtleXNOZXciO2k6NzY7czozNToiaWZccypcKCpccypAKnByZWdfbWF0Y2hccypcKCpccypzdHIiO2k6Nzc7czo0MzoiQFwkX0NPT0tJRVxbWyciXXswLDF9c3RhdENvdW50ZXJbJyJdezAsMX1cXSI7aTo3ODtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjc5O3M6NTU6IkAqZ3ppbmZsYXRlXHMqXChccypAKmJhc2U2NF9kZWNvZGVccypcKFxzKkAqc3RyX3JlcGxhY2UiO2k6ODA7czoyODoiZmlsZV9wdXRfY29udGVudHpccypcKCpccypcJCI7aTo4MTtzOjg3OiImJlxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoKlxzKlsnIl17MCwxfWdldG14cnJbJyJdezAsMX1cKVxzKlwpXHMqe1xzKkBnZXRteHJyXHMqXCgqXHMqXCQiO2k6ODI7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6ODM7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aTo4NDtzOjg1OiJleGl0XHMqXChccypbJyJdezAsMX08c2NyaXB0PlxzKnNldFRpbWVvdXRccypcKFxzKlxcWyciXXswLDF9ZG9jdW1lbnRcLmxvY2F0aW9uXC5ocmVmIjtpOjg1O3M6Mzg6ImV2YWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXFxcJF9SRVFVRVNUIjtpOjg2O3M6MzY6IiF0b3VjaFwoWyciXXswLDF9XC5cLi9cLlwuL2xhbmd1YWdlLyI7aTo4NztzOjEwOiJEYzBSSGFbJyJdIjtpOjg4O3M6NjA6ImhlYWRlclxzKlwoWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlwkdG9ccypcLlxzKnVybGRlY29kZSI7aTo4OTtzOjE1NjoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyosXHMqWyciXXswLDF9QW5kcm9pZFsnIl17MCwxfVwpXHMqIT09ZmFsc2VccyomJlxzKiFcJF9DT09LSUVcW1snIl17MCwxfWRsZV91c2VyX2lkIjtpOjkwO3M6Mzg6ImVjaG9ccytAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkZ2V0IjtpOjkxO3M6NDc6ImRlZmF1bHRfYWN0aW9uXHMqPVxzKlsnIl17MCwxfUZpbGVzTWFuWyciXXswLDF9IjtpOjkyO3M6MzM6ImRlZmluZVxzKlwoXHMqWyciXURFRkNBTExCQUNLTUFJTCI7aTo5MztzOjE3OiJNeXN0ZXJpb3VzXHMrV2lyZSI7aTo5NDtzOjM0OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdL1wuXCsvZXNpIjtpOjk1O3M6NDU6ImRlZmluZVxzKlwoKlxzKlsnIl1TQkNJRF9SRVFVRVNUX0ZJTEVbJyJdXHMqLCI7aTo5NjtzOjYwOiJcJHRsZFxzKj1ccyphcnJheVxzKlwoXHMqWyciXWNvbVsnIl0sWyciXW9yZ1snIl0sWyciXW5ldFsnIl0iO2k6OTc7czoxNzoiQnJhemlsXHMrSGFja1RlYW0iO2k6OTg7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6OTk7czo3NToidGltZVwoXClccypcK1xzKjEwMDAwXHMqLFxzKlsnIl0vWyciXVwpO1xzKmVjaG9ccytcJG1feno7XHMqZXZhbFxzKlwoXCRtX3p6IjtpOjEwMDtzOjEwNjoicmV0dXJuXHMqXChccypzdHJzdHJccypcKFxzKlwkc1xzKixccyonZWNobydccypcKVxzKj09XHMqZmFsc2VccypcP1xzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ3ByaW50JyI7aToxMDE7czo2Nzoic2V0X3RpbWVfbGltaXRccypcKFxzKjBccypcKTtccyppZlxzKlwoIVNlY3JldFBhZ2VIYW5kbGVyOjpjaGVja0tleSI7aToxMDI7czo3MzoiQGhlYWRlclwoWyciXUxvY2F0aW9uOlxzKlsnIl1cLlsnIl1oWyciXVwuWyciXXRbJyJdXC5bJyJddFsnIl1cLlsnIl1wWyciXSI7aToxMDM7czo5OiJJclNlY1RlYW0iO2k6MTA0O3M6OTc6IlwkckJ1ZmZMZW5ccyo9XHMqb3JkXHMqXChccypWQ19EZWNyeXB0XHMqXChccypmcmVhZFxzKlwoXHMqXCRpbnB1dCxccyoxXHMqXClccypcKVxzKlwpXHMqXCpccyoyNTYiO2k6MTA1O3M6NzQ6ImNsZWFyc3RhdGNhY2hlXChccypcKTtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRmbGRccypcKVxzKlwpXHMqcmV0dXJuIjtpOjEwNjtzOjk3OiJjb250ZW50PVsnIl17MCwxfW5vLWNhY2hlWyciXXswLDF9O1xzKlwkY29uZmlnXFtbJyJdezAsMX1kZXNjcmlwdGlvblsnIl17MCwxfVxdXHMqXC49XHMqWyciXXswLDF9IjtpOjEwNztzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTA4O3M6NzA6ImZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqXHMqQURNSU5fUkVESVJfVVJMXHMqLFxzKmZhbHNlXHMqLFxzKlwkY3R4XHMqXCkiO2k6MTA5O3M6ODc6ImlmXHMqXChccypcJGlccyo8XHMqXChccypjb3VudFxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cVsnIl17MCwxfVxzKlxdXHMqXClccyotXHMqMSI7aToxMTA7czoyMzI6Imlzc2V0XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqaXNfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmNvcHlccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF0iO2k6MTExO3M6ODI6IlwkVVJMXHMqPVxzKlwkdXJsc1xbXHMqcmFuZFwoXHMqMFxzKixccypjb3VudFxzKlwoXHMqXCR1cmxzXHMqXClccyotXHMqMVxzKlwpXHMqXF0iO2k6MTEyO3M6MjEzOiJAKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJHNlY3VyaXR5X2NvZGVccypcLlxzKiIvIlxzKlwuXHMqXCRfRklMRVNcW1snIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1cXVxbWyciXXswLDF9bmFtZVsnIl17MCwxfVxdXCkiO2k6MTEzO3M6Mzk6ImV2YWxccypcKCpccypzdHJyZXZccypcKCpccypzdHJfcmVwbGFjZSI7aToxMTQ7czo4MToiXCRyZXM9bXlzcWxfcXVlcnlcKFsnIl17MCwxfVNFTEVDVFxzK1wqXHMrRlJPTVxzK2B3YXRjaGRvZ19vbGRfMDVgXHMrV0hFUkVccytwYWdlIjtpOjExNTtzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTE2O3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjExNztzOjM4OiJmY2xvc2VcKFwkZlwpO1xzKmVjaG9ccypbJyJdb1wua1wuWyciXSI7aToxMTg7czo0MToiZnVuY3Rpb25ccytpbmplY3RcKFwkZmlsZSxccypcJGluamVjdGlvbj0iO2k6MTE5O3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjEyMDtzOjQzOiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwXHMrLWxzIjtpOjEyMTtzOjQ0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccyoncGNudGxfZm9yayI7aToxMjI7czo2NToidXJsZW5jb2RlXChwcmludF9yXChhcnJheVwoXCksMVwpXCksNSwxXClcLmNcKSxcJGNcKTt9ZXZhbFwoXCRkXCkiO2k6MTIzO3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjEyNDtzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTI1O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjEyNjtzOjgzOiJpZlxzKlwoXHMqXCRkYXRhU2l6ZVxzKjxccypCT1RDUllQVF9NQVhfU0laRVxzKlwpXHMqcmM0XHMqXChccypcJGRhdGEsXHMqXCRjcnlwdGtleSI7aToxMjc7czo5MDoiLFxzKmFycmF5XHMqXCgnXC4nLCdcLlwuJywnVGh1bWJzXC5kYidcKVxzKlwpXHMqXClccyp7XHMqY29udGludWU7XHMqfVxzKmlmXHMqXChccyppc19maWxlIjtpOjEyODtzOjUxOiJcKVxzKlwuXHMqc3Vic3RyXHMqXChccyptZDVccypcKFxzKnN0cnJldlxzKlwoXHMqXCQiO2k6MTI5O3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTMwO3M6MTU6IlsnIl1lL1wqXC4vWyciXSI7aToxMzE7czo1MjoiZWNob1snIl17MCwxfTxjZW50ZXI+PGI+RG9uZVxzKj09PlxzKlwkdXNlcmZpbGVfbmFtZSI7aToxMzI7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEzMztzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMzQ7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEzNTtzOjM0OiJ1cmw9PFw/cGhwXHMqZWNob1xzKlwkcmFuZF91cmw7XD8+IjtpOjEzNjtzOjI3OiJlY2hvXHMqWyciXWFuc3dlcj1lcnJvclsnIl0iO2k6MTM3O3M6MzI6IlwkcG9zdFxzKj1ccypbJyJdXFx4NzdcXHg2N1xceDY1IjtpOjEzODtzOjQ2OiJpZlxzKlwoZGV0ZWN0X21vYmlsZV9kZXZpY2VcKFwpXClccyp7XHMqaGVhZGVyIjtpOjEzOTtzOjk6IklySXNUXC5JciI7aToxNDA7czo4OToiXCRsZXR0ZXJccyo9XHMqc3RyX3JlcGxhY2VccypcKFxzKlwkQVJSQVlcWzBcXVxbXCRqXF1ccyosXHMqXCRhcnJcW1wkaW5kXF1ccyosXHMqXCRsZXR0ZXIiO2k6MTQxO3M6OTI6ImNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqWyciXVwkbVsnIl1ccyosXHMqWyciXWlmXHMqXChccypcJG1ccypcW1xzKjB4MDFccypcXVxzKj09XHMqWyciXUxbJyJdIjtpOjE0MjtzOjcyOiJcJHBccyo9XHMqc3RycG9zXChcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTQzO3M6MTEyOiJcJHVzZXJfYWdlbnRccyo9XHMqcHJlZ19yZXBsYWNlXHMqXChccypbJyJdXHxVc2VyXFxcLkFnZW50XFw6XFtcXHMgXF1cP1x8aVsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCR1c2VyX2FnZW50IjtpOjE0NDtzOjMxOiJwcmludFwoIlwjXHMraW5mb1xzK09LXFxuXFxuIlwpIjtpOjE0NTtzOjUxOiJcXVxzKn1ccyo9XHMqdHJpbVxzKlwoXHMqYXJyYXlfcG9wXHMqXChccypcJHtccypcJHsiO2k6MTQ2O3M6NjQ6IlxdPVsnIl17MCwxfWlwWyciXXswLDF9XHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfU0VSVkVSXFsiO2k6MTQ3O3M6MzQ6InByaW50XHMqXCRzb2NrICJQUklWTVNHICJcLlwkb3duZXIiO2k6MTQ4O3M6NjM6ImlmXCgvXF5cXDpcJG93bmVyIVwuXCpcXEBcLlwqUFJJVk1TR1wuXCo6XC5tc2dmbG9vZFwoXC5cKlwpL1wpeyI7aToxNDk7czoyNjoiXFstXF1ccytDb25uZWN0aW9uXHMrZmFpbGQiO2k6MTUwO3M6NTQ6IjwhLS1cI2V4ZWNccytjbWQ9WyciXXswLDF9XCRIVFRQX0FDQ0VQVFsnIl17MCwxfVxzKi0tPiI7aToxNTE7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjE1MjtzOjk5OiJpZlxzKlwoXHMqaXNfZGlyXHMqXChccypcJEZ1bGxQYXRoXHMqXClccypcKVxzKkFsbERpclxzKlwoXHMqXCRGdWxsUGF0aFxzKixccypcJEZpbGVzXHMqXCk7XHMqfVxzKn0iO2k6MTUzO3M6Nzg6IlwkcFxzKj1ccypzdHJwb3NccypcKFxzKlwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxNTQ7czoxMjM6InByZWdfbWF0Y2hfYWxsXChbJyJdezAsMX0vPGEgaHJlZj0iXFwvdXJsXFxcP3E9XChcLlwrXD9cKVxbJlx8IlxdXCsvaXNbJyJdezAsMX0sIFwkcGFnZVxbWyciXXswLDF9ZXhlWyciXXswLDF9XF0sIFwkbGlua3NcKSI7aToxNTU7czo4MDoiXCR1cmxccyo9XHMqXCR1cmxccypcLlxzKlsnIl17MCwxfVw/WyciXXswLDF9XHMqXC5ccypodHRwX2J1aWxkX3F1ZXJ5XChcJHF1ZXJ5XCkiO2k6MTU2O3M6ODM6InByaW50XHMrXCRzb2NrXHMrWyciXXswLDF9TklDSyBbJyJdezAsMX1ccytcLlxzK1wkbmlja1xzK1wuXHMrWyciXXswLDF9XFxuWyciXXswLDF9IjtpOjE1NztzOjMyOiJQUklWTVNHXC5cKjpcLm93bmVyXFxzXCtcKFwuXCpcKSI7aToxNTg7czoxNToiL3Vzci9zYmluL2h0dHBkIjtpOjE1OTtzOjc1OiJcJHJlc3VsdEZVTFxzKj1ccypzdHJpcGNzbGFzaGVzXHMqXChccypcJF9QT1NUXFtbJyJdezAsMX1yZXN1bHRGVUxbJyJdezAsMX0iO2k6MTYwO3M6MTUyOiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccypcKSI7aToxNjE7czo2MDoiaWZccypcKFxzKkAqbWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE2MjtzOjk0OiJlY2hvXHMrZmlsZV9nZXRfY29udGVudHNccypcKFxzKmJhc2U2NF91cmxfZGVjb2RlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE2MztzOjg0OiJmd3JpdGVccypcKFxzKlwkZmhccyosXHMqc3RyaXBzbGFzaGVzXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTY0O3M6ODM6ImlmXHMqXChccyptYWlsXHMqXChccypcJG1haWxzXFtcJGlcXVxzKixccypcJHRlbWFccyosXHMqYmFzZTY0X2VuY29kZVxzKlwoXHMqXCR0ZXh0IjtpOjE2NTtzOjYyOiJcJGd6aXBccyo9XHMqQCpnemluZmxhdGVccypcKFxzKkAqc3Vic3RyXHMqXChccypcJGd6ZW5jb2RlX2FyZyI7aToxNjY7czo3MzoibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyciXXswLDF9ZWxpZlsnIl17MCwxfVxdXFtbJyJdezAsMX10bXBfbmFtZSI7aToxNjc7czo4MDoiaGVhZGVyXChbJyJdezAsMX1zOlxzKlsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXHMqXChccypbJyJdezAsMX1uWyciXXswLDF9XHMqXCkiO2k6MTY4O3M6MTI6IkJ5XHMrV2ViUm9vVCI7aToxNjk7czo1NzoiXCRPT08wTzBPMDA9X19GSUxFX187XHMqXCRPTzAwTzAwMDBccyo9XHMqMHgxYjU0MDtccypldmFsIjtpOjE3MDtzOjUyOiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxdIjtpOjE3MTtzOjc3OiJwcmVnX21hdGNoXChbJyJdL1woeWFuZGV4XHxnb29nbGVcfGJvdFwpL2lbJyJdLFxzKmdldGVudlwoWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxNzI7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6MTczO3M6NDI6ImZzb2Nrb3BlblxzKlwoXHMqXCRDb25uZWN0QWRkcmVzc1xzKixccyoyNSI7aToxNzQ7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aToxNzU7czo2MzoiXCR1cmxbJyJdezAsMX1ccypcLlxzKlwkc2Vzc2lvbl9pZFxzKlwuXHMqWyciXXswLDF9L2xvZ2luXC5odG1sIjtpOjE3NjtzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aToxNzc7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNzg7czozMzoiZGllXHMqXChccypQSFBfT1NccypcLlxzKmNoclxzKlwoIjtpOjE3OTtzOjE4MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChbJyJdWyciXVxzKixccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6MTgwO3M6ODA6IlwkaGVhZGVyc1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9aGVhZGVyc1snIl17MCwxfVxdIjtpOjE4MTtzOjg2OiJmaWxlX3B1dF9jb250ZW50c1xzKlwoWyciXXswLDF9MVwudHh0WyciXXswLDF9XHMqLFxzKnByaW50X3JccypcKFxzKlwkX1BPU1RccyosXHMqdHJ1ZSI7aToxODI7czozNToiZndyaXRlXHMqXChccypcJGZsd1xzKixccypcJGZsXHMqXCkiO2k6MTgzO3M6Mzg6Ilwkc3lzX3BhcmFtc1xzKj1ccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE4NDtzOjUxOiJcJGFsbGVtYWlsc1xzKj1ccypAc3BsaXRcKCJcXG4iXHMqLFxzKlwkZW1haWxsaXN0XCkiO2k6MTg1O3M6NTA6ImZpbGVfcHV0X2NvbnRlbnRzXChTVkNfU0VMRlxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE4NjtzOjU3OiJjcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFxzKlwkb3B0XFsxXF1ccypcLlxzKlwkb3B0XFs0XF0iO2k6MTg3O3M6OTU6IjxzY3JpcHRccyt0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzK3NyYz1bJyJdezAsMX1qcXVlcnktdVwuanNbJyJdezAsMX0+PC9zY3JpcHQ+IjtpOjE4ODtzOjI4OiJVUkw9PFw/ZWNob1xzK1wkaW5kZXg7XHMrXD8+IjtpOjE4OTtzOjIzOiJcI1xzKnNlY3VyaXR5c3BhY2VcLmNvbSI7aToxOTA7czoxODoiXCNccypzdGVhbHRoXHMqYm90IjtpOjE5MTtzOjIxOiJBcHBsZVxzK1NwQW1ccytSZVp1bFQiO2k6MTkyO3M6NTI6ImlzX3dyaXRhYmxlXChcJGRpclwuWyciXXdwLWluY2x1ZGVzL3ZlcnNpb25cLnBocFsnIl0iO2k6MTkzO3M6NDI6ImlmXChlbXB0eVwoXCRfQ09PS0lFXFtbJyJdeFsnIl1cXVwpXCl7ZWNobyI7aToxOTQ7czoyOToiXClcXTt9aWZcKGlzc2V0XChcJF9TRVJWRVJcW18iO2k6MTk1O3M6NjY6ImlmXChAXCR2YXJzXChnZXRfbWFnaWNfcXVvdGVzX2dwY1woXClccypcP1xzKnN0cmlwc2xhc2hlc1woXCR1cmlcKSI7aToxOTY7czozMDoiYmFzZVsnIl17MCwxfVwuXCgzMlxzKlwqXHMqMlwpIjtpOjE5NztzOjc1OiJcJHBhcmFtXHMqPVxzKlwkcGFyYW1ccyp4XHMqXCRuXC5zdWJzdHJccypcKFwkcGFyYW1ccyosXHMqbGVuZ3RoXChcJHBhcmFtXCkiO2k6MTk4O3M6NTM6InJlZ2lzdGVyX3NodXRkb3duX2Z1bmN0aW9uXChccypbJyJdezAsMX1yZWFkX2Fuc19jb2RlIjtpOjE5OTtzOjM1OiJiYXNlNjRfZGVjb2RlXChcJF9QT1NUXFtbJyJdezAsMX1fLSI7aToyMDA7czo1NDoiaWZcKGlzc2V0XChcJF9QT1NUXFtbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XF1cKVwpIjtpOjIwMTtzOjEzMzoibWFpbFwoXCRhcnJcW1snIl17MCwxfXRvWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfXN1YmpbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9bXNnWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfWhlYWRbJyJdezAsMX1cXVwpOyI7aToyMDI7czozODoiZmlsZV9nZXRfY29udGVudHNcKHRyaW1cKFwkZlxbXCRfR0VUXFsiO2k6MjAzO3M6NjA6ImluaV9nZXRcKFsnIl17MCwxfWZpbHRlclwuZGVmYXVsdF9mbGFnc1snIl17MCwxfVwpXCl7Zm9yZWFjaCI7aToyMDQ7czo1MDoiY2h1bmtfc3BsaXRcKGJhc2U2NF9lbmNvZGVcKGZyZWFkXChcJHtcJHtbJyJdezAsMX0iO2k6MjA1O3M6NTI6Ilwkc3RyPVsnIl17MCwxfTxoMT40MDNccytGb3JiaWRkZW48L2gxPjwhLS1ccyp0b2tlbjoiO2k6MjA2O3M6MzM6IjxcP3BocFxzK3JlbmFtZVwoWyciXXdzb1wucGhwWyciXSI7aToyMDc7czo2NjoiXCRbYS16QS1aMC05X10rPy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz8vXCouezEsMTB9XCovIjtpOjIwODtzOjUxOiJAKm1haWxcKFwkbW9zQ29uZmlnX21haWxmcm9tLCBcJG1vc0NvbmZpZ19saXZlX3NpdGUiO2k6MjA5O3M6OTU6IlwkdD1cJHM7XHMqXCRvXHMqPVxzKlsnIl1bJyJdO1xzKmZvclwoXCRpPTA7XCRpPHN0cmxlblwoXCR0XCk7XCRpXCtcK1wpe1xzKlwkb1xzKlwuPVxzKlwkdHtcJGl9IjtpOjIxMDtzOjQ3OiJtbWNyeXB0XChcJGRhdGEsIFwka2V5LCBcJGl2LCBcJGRlY3J5cHQgPSBGQUxTRSI7aToyMTE7czoxNToidG5lZ2FfcmVzdV9wdHRoIjtpOjIxMjtzOjk6InRzb2hfcHR0aCI7aToyMTM7czoxMjoiUkVSRUZFUl9QVFRIIjtpOjIxNDtzOjMxOiJ3ZWJpXC5ydS93ZWJpX2ZpbGVzL3BocF9saWJtYWlsIjtpOjIxNTtzOjQwOiJzdWJzdHJfY291bnRcKGdldGVudlwoXFxbJyJdSFRUUF9SRUZFUkVSIjtpOjIxNjtzOjM3OiJmdW5jdGlvbiByZWxvYWRcKFwpe2hlYWRlclwoIkxvY2F0aW9uIjtpOjIxNztzOjI1OiJpbWcgc3JjPVsnIl1vcGVyYTAwMFwucG5nIjtpOjIxODtzOjQ2OiJlY2hvXHMqbWQ1XChcJF9QT1NUXFtbJyJdezAsMX1jaGVja1snIl17MCwxfVxdIjtpOjIxOTtzOjMzOiJlVmFMXChccyp0cmltXChccypiYVNlNjRfZGVDb0RlXCgiO2k6MjIwO3M6NDI6ImZzb2Nrb3BlblwoXCRtXFswXF0sXCRtXFsxMFxdLFwkXyxcJF9fLFwkbSI7aToyMjE7czoxOToiWyciXT0+XCR7XCR7WyciXVxceCI7aToyMjI7czozODoicHJlZ19yZXBsYWNlXChbJyJdLlVURlxcLTg6XCguXCpcKS5Vc2UiO2k6MjIzO3M6MzA6Ijo6WyciXVwucGhwdmVyc2lvblwoXClcLlsnIl06OiI7aToyMjQ7czo0MDoiQHN0cmVhbV9zb2NrZXRfY2xpZW50XChbJyJdezAsMX10Y3A6Ly9cJCI7aToyMjU7czoxODoiPT0wXCl7anNvblF1aXRcKFwkIjtpOjIyNjtzOjQ2OiJsb2Nccyo9XHMqWyciXXswLDF9PFw/ZWNob1xzK1wkcmVkaXJlY3Q7XHMqXD8+IjtpOjIyNztzOjI4OiJhcnJheVwoXCRlbixcJGVzLFwkZWYsXCRlbFwpIjtpOjIyODtzOjM3OiJbJyJdezAsMX0uYy5bJyJdezAsMX1cLnN1YnN0clwoXCR2YmcsIjtpOjIyOTtzOjE4OiJmdWNrXHMreW91clxzK21hbWEiO2k6MjMwO3M6Nzg6ImNhbGxfdXNlcl9mdW5jXChccypbJyJdYWN0aW9uWyciXVxzKlwuXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyMzE7czo1OToic3RyX3JlcGxhY2VcKFwkZmluZFxzKixccypcJGZpbmRccypcLlxzKlwkaHRtbFxzKixccypcJHRleHQiO2k6MjMyO3M6MzM6ImZpbGVfZXhpc3RzXHMqXCgqXHMqWyciXS92YXIvdG1wLyI7aToyMzM7czo0MToiJiZccyohZW1wdHlcKFxzKlwkX0NPT0tJRVxbWyciXWZpbGxbJyJdXF0iO2k6MjM0O3M6MjE6ImZ1bmN0aW9uXHMraW5EaWFwYXNvbiI7aToyMzU7czozNToibWFrZV9kaXJfYW5kX2ZpbGVcKFxzKlwkcGF0aF9qb29tbGEiO2k6MjM2O3M6NDE6Imxpc3RpbmdfcGFnZVwoXHMqbm90aWNlXChccypbJyJdc3ltbGlua2VkIjtpOjIzNztzOjYyOiJsaXN0XHMqXChccypcJGhvc3RccyosXHMqXCRwb3J0XHMqLFxzKlwkc2l6ZVxzKixccypcJGV4ZWNfdGltZSI7aToyMzg7czo1MjoiZmlsZW10aW1lXChcJGJhc2VwYXRoXHMqXC5ccypbJyJdL2NvbmZpZ3VyYXRpb25cLnBocCI7aToyMzk7czo1ODoiZnVuY3Rpb25ccytyZWFkX3BpY1woXHMqXCRBXHMqXClccyp7XHMqXCRhXHMqPVxzKlwkX1NFUlZFUiI7aToyNDA7czo2NDoiY2hyXChccypcJHRhYmxlXFtccypcJHN0cmluZ1xbXHMqXCRpXHMqXF1ccypcKlxzKnBvd1woNjRccyosXHMqMSI7aToyNDE7czo0MDoiXF1ccypcKXtldmFsXChccypcJFthLXpBLVowLTlfXSs/XFtccypcJCI7aToyNDI7czo1NDoiTG9jYXRpb246OmlzRmlsZVdyaXRhYmxlXChccypFbmNvZGVFeHBsb3Jlcjo6Z2V0Q29uZmlnIjtpOjI0MztzOjEzOiJieVxzK1NodW5jZW5nIjtpOjI0NDtzOjE0OiJ7ZXZhbFwoXCR7XCRzMiI7aToyNDU7czoxODoiZXZhbFwoXCRzMjFcKFwke1wkIjtpOjI0NjtzOjIxOiJSYW1aa2lFXHMrLVxzK2V4cGxvaXQiO2k6MjQ3O3M6NDc6IlsnIl1yZW1vdmVfc2NyaXB0c1snIl1ccyo9PlxzKmFycmF5XChbJyJdUmVtb3ZlIjtpOjI0ODtzOjI4OiJcJGJhY2tfY29ubmVjdF9wbFxzKj1ccypbJyJdIjtpOjI0OTtzOjQwOiJcJHNpdGVfcm9vdFwuXCRmaWxldW5wX2RpclwuXCRmaWxldW5wX2ZuIjtpOjI1MDtzOjI0OiJAcHJlZ19yZXBsYWNlXChbJyJdL2FkL2UiO2k6MjUxO3M6MjY6IjxiPlwkdWlkXHMqXChcJHVuYW1lXCk8L2I+IjtpOjI1MjtzOjExOiJGeDI5R29vZ2xlciI7aToyNTM7czo4OiJlbnZpcjBubiI7aToyNTQ7czo0NjoiYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCpbJyJdXCksYmFzZTY0X2RlY29kZSI7aToyNTU7czoyODoiPFw/PVxzKkBwaHBfdW5hbWVcKFwpO1xzKlw/PiI7aToyNTY7czoxMToic1V4Q3Jld1xzK1YiO2k6MjU3O3M6MTY6IldhckJvdFxzK3NVeENyZXciO2k6MjU4O3M6NDM6ImV4ZWNcKFsnIl1jZFxzKy90bXA7Y3VybFxzKy1PXHMrWyciXVwuXCR1cmwiO2k6MjU5O3M6MTU6IkJhdGF2aTRccytTaGVsbCI7aToyNjA7czozNjoiQGV4dHJhY3RcKFwkX1JFUVVFU1RcW1snIl1meDI5c2hjb29rIjtpOjI2MTtzOjEwOiJUdVhfU2hhZG93IjtpOjI2MjtzOjQwOiI9QGZvcGVuXHMqXChbJyJdcGhwXC5pbmlbJyJdXHMqLFxzKlsnIl13IjtpOjI2MztzOjk6IkxlYmF5Q3JldyI7aToyNjQ7czo3OToiXCRoZWFkZXJzXHMqXC49XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1lTWFpbEFkZFsnIl1ccypcXSI7aToyNjU7czoxOToiYm9nZWxccyotXHMqZXhwbG9pdCI7aToyNjY7czo1OToiXFt1bmFtZVxdWyciXVxzKlwuXHMqcGhwX3VuYW1lXChccypcKVxzKlwuXHMqWyciXVxbL3VuYW1lXF0iO2k6MjY3O3M6MzI6IlxdXChcJF8xLFwkXzFcKVwpO2Vsc2V7XCRHTE9CQUxTIjtpOjI2ODtzOjE0OiJmaWxlOmZpbGU6Ly8vLyI7aToyNjk7czozMjoiZnVuY3Rpb25ccytNQ0xvZ2luXChcKVxzKntccypkaWUiO30="));
$gX_FlexDBShe = unserialize(base64_decode("YToyOTg6e2k6MDtzOjQ4OiJcJFthLXpBLVowLTlfXSs/XFtjaHJcKFxkK1wpXF1cKFthLXpBLVowLTlfXSs/XCgiO2k6MTtzOjQwOiJpZlwoIXByZWdfbWF0Y2hcKFsnIl0vSGFja2VkIGJ5L2lbJyJdLFwkIjtpOjI7czoxMDg6IlwkW2EtekEtWjAtOV9dKz9cW1wkW2EtekEtWjAtOV9dKz9cXT1jaHJcKFwkW2EtekEtWjAtOV9dKz9cW29yZFwoXCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xdXClcXVwpOyI7aTozO3M6OToiQnlccytBbSFyIjtpOjQ7czoxOToiQ29udGVudC1UeXBlOlxzKlwkXyI7aTo1O3M6NDA6ImV2YWxccypcKCpccypnemluZmxhdGVccypcKCpccypzdHJfcm90MTMiO2k6NjtzOjEwNzoiaWZccypcKFxzKmlzX2NhbGxhYmxlXHMqXCgqXHMqWyciXXswLDF9KGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKSoiO2k6NztzOjUwOiJldmFsXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo4O3M6NTI6ImFzc2VydFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6OTtzOjEwNDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFsiO2k6MTA7czoyOToiZXZhbFxzKlwoKlxzKmdldF9vcHRpb25ccypcKCoiO2k6MTE7czo5NToiYWRkX2ZpbHRlclxzKlwoKlxzKlsnIl17MCwxfXRoZV9jb250ZW50WyciXXswLDF9XHMqLFxzKlsnIl17MCwxfV9ibG9naW5mb1snIl17MCwxfVxzKixccyouKz9cKSoiO2k6MTI7czozMjoiaXNfd3JpdGFibGVccypcKCpccypbJyJdL3Zhci90bXAiO2k6MTM7czo5NToiaXNzZXRcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqb3JccypkaWVcKCouKz9cKSoiO2k6MTQ7czoxNDU6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXClccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXClccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXCkiO2k6MTU7czo0OToiZ3p1bmNvbXByZXNzXHMqXCgqXHMqc3Vic3RyXHMqXCgqXHMqYmFzZTY0X2RlY29kZSI7aToxNjtzOjk6IlwkX19fXHMqPSI7aToxNztzOjMxOiI9XHMqYXJyYXlfbWFwXHMqXCgqXHMqc3RycmV2XHMqIjtpOjE4O3M6NDA6ImlmXHMqXChccypwcmVnX21hdGNoXHMqXChccypbJyJdXCN5YW5kZXgiO2k6MTk7czoxNjc6IjxiPmV2YWxccypcKFxzKihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjIwO3M6NzA6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXdnZXQiO2k6MjE7czo3MjoiQHNldGNvb2tpZVwoWyciXW1bJyJdLFxzKlsnIl1bYS16QS1aMC05X10rP1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjIyO3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MjM7czozMzoic3ltYmlhblx8bWlkcFx8d2FwXHxwaG9uZVx8cG9ja2V0IjtpOjI0O3M6NDg6ImZ1bmN0aW9uXHMqY2htb2RfUlxzKlwoXHMqXCRwYXRoXHMqLFxzKlwkcGVybVxzKiI7aToyNTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyNjtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6Mjc7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjI4O3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6Mjk7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjMwO3M6MzU6ImVjaG9ccytbJyJdezAsMX1pbnN0YWxsX29rWyciXXswLDF9IjtpOjMxO3M6MTY6IlNwYW1ccytjb21wbGV0ZWQiO2k6MzI7czoyMToiPT1bJyJdXClcKTtyZXR1cm47XD8+IjtpOjMzO3M6NDQ6ImFycmF5XChccypbJyJdR29vZ2xlWyciXVxzKixccypbJyJdU2x1cnBbJyJdIjtpOjM0O3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjtpOjM1O3M6MzI6IjxoMT40MDMgRm9yYmlkZGVuPC9oMT48IS0tIHRva2VuIjtpOjM2O3M6MjA6Ii9lWyciXVxzKixccypbJyJdXFx4IjtpOjM3O3M6MzU6InBocF9bJyJdXC5cJGV4dFwuWyciXVwuZGxsWyciXXswLDF9IjtpOjM4O3M6MTc6Im14MlwuaG90bWFpbFwuY29tIjtpOjM5O3M6MzY6InByZWdfcmVwbGFjZVwoXHMqWyciXWVbJyJdLFsnIl17MCwxfSI7aTo0MDtzOjUzOiJmb3BlblwoWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vWyciXXswLDF9XC5cJGZpbGVwYXRocyI7aTo0MTtzOjUxOiJcJGRhdGFccyo9XHMqYXJyYXlcKFsnIl17MCwxfXRlcm1pbmFsWyciXXswLDF9XHMqPT4iO2k6NDI7czoyOToiXCRiXHMqPVxzKm1kNV9maWxlXChcJGZpbGViXCkiO2k6NDM7czozMzoicG9ydGxldHMvZnJhbWV3b3JrL3NlY3VyaXR5L2xvZ2luIjtpOjQ0O3M6MzE6IlwkZmlsZWJccyo9XHMqZmlsZV9nZXRfY29udGVudHMiO2k6NDU7czoxMDQ6InNpdGVfZnJvbT1bJyJdezAsMX1cLlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9IT1NUWyciXXswLDF9XF1cLlsnIl17MCwxfSZzaXRlX2ZvbGRlcj1bJyJdezAsMX1cLlwkZlxbMVxdIjtpOjQ2O3M6NTY6IndoaWxlXChjb3VudFwoXCRsaW5lc1wpPlwkY29sX3phcFwpIGFycmF5X3BvcFwoXCRsaW5lc1wpIjtpOjQ3O3M6ODU6Ilwkc3RyaW5nXHMqPVxzKlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtbJyJdezAsMX1udXR6ZXJuYW1lWyciXXswLDF9XF0iO2k6NDg7czo0MToiaWYgXCghc3RycG9zXChcJHN0cnNcWzBcXSxbJyJdezAsMX08XD9waHAiO2k6NDk7czoyNToiXCRpc2V2YWxmdW5jdGlvbmF2YWlsYWJsZSI7aTo1MDtzOjE0OiJEYXZpZFxzK0JsYWluZSI7aTo1MTtzOjQ3OiJpZiBcKGRhdGVcKFsnIl17MCwxfWpbJyJdezAsMX1cKVxzKi1ccypcJG5ld3NpZCI7aTo1MjtzOjc6InVnZ2M6Ly8iO2k6NTM7czoxNToiPCEtLVxzK2pzLXRvb2xzIjtpOjU0O3M6MzQ6ImlmXChAcHJlZ19tYXRjaFwoc3RydHJcKFsnIl17MCwxfS8iO2k6NTU7czozNzoiX1snIl17MCwxfVxdXFsyXF1cKFsnIl17MCwxfUxvY2F0aW9uOiI7aTo1NjtzOjI4OiJcJF9QT1NUXFtbJyJdezAsMX1zbXRwX2xvZ2luIjtpOjU3O3M6Mjg6ImlmXHMqXChAaXNfd3JpdGFibGVcKFwkaW5kZXgiO2k6NTg7czo4NjoiQGluaV9zZXRccypcKFsnIl17MCwxfWluY2x1ZGVfcGF0aFsnIl17MCwxfSxbJyJdezAsMX1pbmlfZ2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGgiO2k6NTk7czozODoiWmVuZFxzK09wdGltaXphdGlvblxzK3ZlclxzKzFcLjBcLjBcLjEiO2k6NjA7czo2MjoiXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1wkbmFtZVxdXHMqPVxzKlwkdmFsdWUiO2k6NjE7czo0MjoiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woWyciXXNjYW5fZGlyZWN0b3J5IjtpOjYyO3M6Njc6ImFycmF5XChccypbJyJdaFsnIl1ccyosXHMqWyciXXRbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJdcFsnIl0iO2k6NjM7czozNToiXCRjb3VudGVyVXJsXHMqPVxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6NjQ7czoxMDg6ImZvclwoXCRbYS16QS1aMC05X10rPz1cZCs7XCRbYS16QS1aMC05X10rPzxcZCs7XCRbYS16QS1aMC05X10rPy09XGQrXCl7aWZcKFwkW2EtekEtWjAtOV9dKz8hPVxkK1wpXHMqYnJlYWs7fSI7aTo2NTtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6NjY7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAKlwkX0NPT0tJRVxbIjtpOjY3O3M6Mzg6InByZWdfcmVwbGFjZVwoXCl7cmV0dXJuXHMrX19GVU5DVElPTl9fIjtpOjY4O3M6Mzk6ImlmXHMqXChjaGVja19hY2NcKFwkbG9naW4sXCRwYXNzLFwkc2VydiI7aTo2OTtzOjM2OiJwcmludFxzK1snIl17MCwxfWRsZV9udWxsZWRbJyJdezAsMX0iO2k6NzA7czo2MzoiaWZcKG1haWxcKFwkZW1haWxcW1wkaVxdLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjcxO3M6MTI6IlRlYU1ccytNb3NUYSI7aTo3MjtzOjE0OiJbJyJdezAsMX1EWmUxciI7aTo3MztzOjE1OiJwYWNrXHMrIlNuQTR4OCIiO2k6NzQ7czozMjoiXCRfUG9zdFxbWyciXXswLDF9U1NOWyciXXswLDF9XF0iO2k6NzU7czoyNzoiRXRobmljXHMrQWxiYW5pYW5ccytIYWNrZXJzIjtpOjc2O3M6OToiQnlccytEWjI3IjtpOjc3O3M6NzI6IihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jbWRcLmV4ZSI7aTo3ODtzOjEwMjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiIjtpOjc5O3M6MTU6IkF1dG9ccypYcGxvaXRlciI7aTo4MDtzOjk6ImJ5XHMrZzAwbiI7aTo4MTtzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjgyO3M6OTQ6ImlmXChpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWNvbnRlbnRbJyJdezAsMX1cKVxzK0FORFxzK2lzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtYWRtaW4iO2k6ODM7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjg0O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aTo4NTtzOjQwOiJzdHJfcmVwbGFjZVxzKlwoXHMqWyciXXswLDF9L3B1YmxpY19odG1sIjtpOjg2O3M6NDE6ImlmXChccyppc3NldFwoXHMqXCRfUkVRVUVTVFxbWyciXXswLDF9Y2lkIjtpOjg3O3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aTo4ODtzOjg1OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9qY2UmdGFzaz1wbHVnaW4mcGx1Z2luPWltZ21hbmFnZXImZmlsZT1pbWdtYW5hZ2VyJnZlcnNpb249XGQrIjtpOjg5O3M6Mzc6InNldGNvb2tpZVwoXHMqXCR6XFswXF1ccyosXHMqXCR6XFsxXF0iO2k6OTA7czozMjoiXCRTXFtcJGlcK1wrXF1cKFwkU1xbXCRpXCtcK1xdXCgiO2k6OTE7czozMjoiXFtcJG9cXVwpO1wkb1wrXCtcKXtpZlwoXCRvPDE2XCkiO2k6OTI7czo4MToidHlwZW9mXHMqXChkbGVfYWRtaW5cKVxzKj09XHMqWyciXXswLDF9dW5kZWZpbmVkWyciXXswLDF9XHMqXHxcfFxzKmRsZV9hZG1pblxzKj09IjtpOjkzO3M6MzY6ImNyZWF0ZV9mdW5jdGlvblwoc3Vic3RyXCgyLDFcKSxcJHNcKSI7aTo5NDtzOjYwOiJwbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwJTNBJTJGJTJGd3d3XC5nb29nbGUiO2k6OTU7czozNjoicmV0dXJuXHMrYmFzZTY0X2RlY29kZVwoXCRhXFtcJGlcXVwpIjtpOjk2O3M6NDU6IlwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo5NztzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6OTg7czozMjoiZXZhbFwoWyciXVw/PlsnIl1cLmJhc2U2NF9kZWNvZGUiO2k6OTk7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6MTAwO3M6Mjg6IlsnIl1bJyJdXHMqXC5ccypnelVuY29NcHJlU3MiO2k6MTAxO3M6MTk6ImdyZXBccystdlxzK2Nyb250YWIiO2k6MTAyO3M6MzQ6ImNyYzMyXChccypcJF9QT1NUXFtccypbJyJdezAsMX1jbWQiO2k6MTAzO3M6MTk6IlwkYmtleXdvcmRfYmV6PVsnIl0iO2k6MTA0O3M6NjA6ImZpbGVfZ2V0X2NvbnRlbnRzXChiYXNlbmFtZVwoXCRfU0VSVkVSXFtbJyJdezAsMX1TQ1JJUFRfTkFNRSI7aToxMDU7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjEwNjtzOjQ4OiJccypbJyJdezAsMX1zbHVycFsnIl17MCwxfVxzKixccypbJyJdezAsMX1tc25ib3QiO2k6MTA3O3M6MjA6ImV2YWxccypcKFxzKlRQTF9GSUxFIjtpOjEwODtzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEwOTtzOjEwNToiXCRwYXRoXHMqPVxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdXHMqXC5ccypbJyJdezAsMX0vaW1hZ2VzL3N0b3JpZXMvWyciXXswLDF9IjtpOjExMDtzOjg5OiJcJHNhcGVfb3B0aW9uXFtccypbJyJdezAsMX1mZXRjaF9yZW1vdGVfdHlwZVsnIl17MCwxfVxzKlxdXHMqPVxzKlsnIl17MCwxfXNvY2tldFsnIl17MCwxfSI7aToxMTE7czo4ODoiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkbmFtZVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMTI7czo4MjoiZXJlZ19yZXBsYWNlXChbJyJdezAsMX0lNUMlMjJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9JTIyWyciXXswLDF9XHMqLFxzKlwkbWVzc2FnZSI7aToxMTM7czo4NToiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfXVyWyciXXswLDF9XF1cKVwpXHMqXCRtb2RlXHMqXHw9XHMqMDQwMCI7aToxMTQ7czo0MToiL3BsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAiO2k6MTE1O3M6NDk6IkAqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkdGhpcy0+ZmlsZVxzKixccypzdHJyZXYiO2k6MTE2O3M6NDg6InByZWdfbWF0Y2hfYWxsXChccypbJyJdXHxcKFwuXCpcKTxcXCEtLSBqcy10b29scyI7aToxMTc7czozMDoiaGVhZGVyXChbJyJdezAsMX1yOlxzKm5vXHMrY29tIjtpOjExODtzOjczOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWxzXHMrL3Zhci9tYWlsIjtpOjExOTtzOjI2OiJcJGRvcl9jb250ZW50PXByZWdfcmVwbGFjZSI7aToxMjA7czoyMzoiX191cmxfZ2V0X2NvbnRlbnRzXChcJGwiO2k6MTIxO3M6NTQ6IlwkR0xPQkFMU1xbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwoXHMqTlVMTCI7aToxMjI7czo2MjoidW5hbWVcXVsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXChcKVxzKlwuXHMqWyciXXswLDF9XFsvdW5hbWUiO2k6MTIzO3M6MzM6IkBcJGZ1bmNcKFwkY2ZpbGUsIFwkY2RpclwuXCRjbmFtZSI7aToxMjQ7czozNjoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCQ8YW1jIjtpOjEyNTtzOjcxOiJcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkK1xzKlxdXChcJF9cW1xzKlxkK1xzKlxdXChccypcJF9cW1xzKlxkKyI7aToxMjY7czoyOToiZXJlZ2lcKFxzKnNxbF9yZWdjYXNlXChccypcJF8iO2k6MTI3O3M6NDA6IlwjVXNlWyciXXswLDF9XHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTI4O3M6MjA6Im1rZGlyXChccypbJyJdL2hvbWUvIjtpOjEyOTtzOjIwOiJmb3BlblwoXHMqWyciXS9ob21lLyI7aToxMzA7czozNjoiXCR1c2VyX2FnZW50X3RvX2ZpbHRlclxzKj1ccyphcnJheVwoIjtpOjEzMTtzOjQ0OiJmaWxlX3B1dF9jb250ZW50c1woWyciXXswLDF9XC4vbGlid29ya2VyXC5zbyI7aToxMzI7czo2NDoiXCMhL2Jpbi9zaG5jZFxzK1snIl17MCwxfVsnIl17MCwxfVwuXCRTQ1BcLlsnIl17MCwxfVsnIl17MCwxfW5pZiI7aToxMzM7czo4MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl17MCwxfWF0XHMrbm93XHMrLWYiO2k6MTM0O3M6MzM6ImNyb250YWJccystbFx8Z3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMzU7czoxNDoiRGF2aWRccypCbGFpbmUiO2k6MTM2O3M6MjM6ImV4cGxvaXQtZGJcLmNvbS9zZWFyY2gvIjtpOjEzNztzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTM4O3M6NjA6Im1haWxcKFxzKlwkTWFpbFRvXHMqLFxzKlwkTWVzc2FnZVN1YmplY3RccyosXHMqXCRNZXNzYWdlQm9keSI7aToxMzk7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxNDA7czo3ODoiIWZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRibmFtZVxzKixccypcJHRoaXMtPmdldEltYWdlRW5jb2RlZFRleHRcKFxzKlwkZGJuYW1lIjtpOjE0MTtzOjQ0OiJzY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aToxNDI7czo3Mjoic2VuZF9zbXRwXChccypcJGVtYWlsXFtbJyJdezAsMX1hZHJbJyJdezAsMX1cXVxzKixccypcJHN1YmpccyosXHMqXCR0ZXh0IjtpOjE0MztzOjQ2OiI9XCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE0NDtzOjUyOiJ0b3VjaFwoXHMqWyciXXswLDF9XCRiYXNlcGF0aC9jb21wb25lbnRzL2NvbV9jb250ZW50IjtpOjE0NTtzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTQ2O3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjE0NztzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjE0ODtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjE0OTtzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjE1MDtzOjEzOiI9YnlccytEUkFHT049IjtpOjE1MTtzOjk4OiJzdWJzdHJcKFxzKlwkc3RyaW5nMlxzKixccypzdHJsZW5cKFxzKlwkc3RyaW5nMlxzKlwpXHMqLVxzKjlccyosXHMqOVwpXHMqPT1ccypbJyJdezAsMX1cW2wscj0zMDJcXSI7aToxNTI7czozMzoiXFtcXVxzKj1ccypbJyJdUmV3cml0ZUVuZ2luZVxzK29uIjtpOjE1MztzOjc1OiJmd3JpdGVcKFxzKlwkZlxzKixccypnZXRfZG93bmxvYWRcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTU0O3M6NDc6InRhclxzKy1jemZccysiXHMqXC5ccypcJEZPUk17dGFyfVxzKlwuXHMqIlwudGFyIjtpOjE1NTtzOjExOiJzY29wYmluWyciXSI7aToxNTY7czo2NjoiPGRpdlxzK2lkPVsnIl1saW5rMVsnIl0+PGJ1dHRvbiBvbmNsaWNrPVsnIl1wcm9jZXNzVGltZXJcKFwpO1snIl0+IjtpOjE1NztzOjM1OiI8Z3VpZD48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybCI7aToxNTg7czo2MjoiaW50MzJcKFwoXChcJHpccyo+PlxzKjVccyomXHMqMHgwN2ZmZmZmZlwpXHMqXF5ccypcJHlccyo8PFxzKjIiO2k6MTU5O3M6NDM6ImZvcGVuXChccypcJHJvb3RfZGlyXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6MTYwO3M6MjM6IlwkaW5fUGVybXNccysmXHMrMHg0MDAwIjtpOjE2MTtzOjM0OiJmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS92YXIvdG1wIjtpOjE2MjtzOjk6Ii9wbXQvcmF2LyI7aToxNjM7czo0OToiZndyaXRlXChcJGZwXHMqLFxzKnN0cnJldlwoXHMqXCRjb250ZXh0XHMqXClccypcKSI7aToxNjQ7czoyMDoiTWFzcmlccytDeWJlclxzK1RlYW0iO2k6MTY1O3M6MTg6IlVzM1xzK1kwdXJccyticjQxbiI7aToxNjY7czoyMDoiTWFzcjFccytDeWIzclxzK1RlNG0iO2k6MTY3O3M6MjA6InRIQU5Lc1xzK3RPXHMrU25vcHB5IjtpOjE2ODtzOjY2OiIsXHMqWyciXS9pbmRleFxcXC5cKHBocFx8aHRtbFwpL2lbJyJdXHMqLFxzKlJlY3Vyc2l2ZVJlZ2V4SXRlcmF0b3IiO2k6MTY5O3M6NDc6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjE3MDtzOjU1OiJnZXRwcm90b2J5bmFtZVwoXHMqWyciXXRjcFsnIl1ccypcKVxzK1x8XHxccytkaWVccytzaGl0IjtpOjE3MTtzOjc2OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXWNkXHMrL3RtcDt3Z2V0IjtpOjE3MjtzOjIyOiI8YVxzK2hyZWY9WyciXW9zaGlia2EtIjtpOjE3MztzOjg1OiJpZlwoXHMqXCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0hPVxzKlsnIl1bJyJdXHMqXClccypcJGlkPVwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIjtpOjE3NDtzOjgzOiJpZlwoWyciXXN1YnN0cl9jb3VudFwoWyciXVwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXHMqLFxzKlsnIl1xdWVyeVwucGhwWyciXSI7aToxNzU7czozODoiXCRmaWxsID0gXCRfQ09PS0lFXFtcXFsnIl1maWxsXFxbJyJdXF0iO2k6MTc2O3M6NjI6IlwkcmVzdWx0PXNtYXJ0Q29weVwoXHMqXCRzb3VyY2VccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRmaWxlIjtpOjE3NztzOjQwOiJcJGJhbm5lZElQXHMqPVxzKmFycmF5XChccypbJyJdXF42NlwuMTAyIjtpOjE3ODtzOjM1OiI8bG9jPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsOyI7aToxNzk7czoyODoiXCRzZXRjb29rXCk7c2V0Y29va2llXChcJHNldCI7aToxODA7czoyODoiXCk7ZnVuY3Rpb25ccytzdHJpbmdfY3B0XChcJCI7aToxODE7czo1MDoiWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl0iO2k6MTgyO3M6NTM6ImlmXChwcmVnX21hdGNoXChbJyJdXCN3b3JkcHJlc3NfbG9nZ2VkX2luXHxhZG1pblx8cHdkIjtpOjE4MztzOjQxOiJnX2RlbGV0ZV9vbl9leGl0XHMqPVxzKm5ld1xzK0RlbGV0ZU9uRXhpdCI7aToxODQ7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjE4NTtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6MTg2O3M6NzU6InZhbHVlPVsnIl08XD9ccysoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXSI7aToxODc7czoyNzoiXGQrJkBwcmVnX21hdGNoXChccypzdHJ0clwoIjtpOjE4ODtzOjM4OiJjaHJcKFxzKmhleGRlY1woXHMqc3Vic3RyXChccypcJG1ha2V1cCI7aToxODk7czozMDoicmVhZF9maWxlX25ld18yXChcJHJlc3VsdF9wYXRoIjtpOjE5MDtzOjIzOiJcJGluZGV4X3BhdGhccyosXHMqMDQwNCI7aToxOTE7czo2NzoiXCRmaWxlX2Zvcl90b3VjaFxzKj1ccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXSI7aToxOTI7czo2MToiXCRfU0VSVkVSXFtbJyJdezAsMX1SRU1PVEVfQUREUlsnIl17MCwxfVxdO2lmXChcKHByZWdfbWF0Y2hcKCI7aToxOTM7czoxOToiPT1ccypbJyJdY3NoZWxsWyciXSI7aToxOTQ7czoyOToiZmlsZV9leGlzdHNcKFxzKlwkRmlsZUJhemFUWFQiO2k6MTk1O3M6MTg6InJlc3VsdHNpZ25fd2FybmluZyI7aToxOTY7czoyNDoiZnVuY3Rpb25ccytnZXRmaXJzdHNodGFnIjtpOjE5NztzOjkwOiJmaWxlX2dldF9jb250ZW50c1woUk9PVF9ESVJcLlsnIl0vdGVtcGxhdGVzL1snIl1cLlwkY29uZmlnXFtbJyJdc2tpblsnIl1cXVwuWyciXS9tYWluXC50cGwiO2k6MTk4O3M6MjU6Im5ld1xzK2NvbmVjdEJhc2VcKFsnIl1hSFIiO2k6MTk5O3M6ODM6IlwkaWRccypcLlxzKlsnIl1cP2Q9WyciXVxzKlwuXHMqYmFzZTY0X2VuY29kZVwoXHMqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9VU0VSX0FHRU5UIjtpOjIwMDtzOjI5OiJkb193b3JrXChccypcJGluZGV4X2ZpbGVccypcKSI7aToyMDE7czoyMDoiaGVhZGVyXHMqXChccypfXGQrXCgiO2k6MjAyO3M6MTI6IkJ5XHMrV2ViUm9vVCI7aToyMDM7czoxNjoiQ29kZWRccytieVxzK0VYRSI7aToyMDQ7czo3MToidHJpbVwoXHMqXCRoZWFkZXJzXHMqXClccypcKVxzKmFzXHMqXCRoZWFkZXJccypcKVxzKmhlYWRlclwoXHMqXCRoZWFkZXIiO2k6MjA1O3M6NTY6IkBcJF9TRVJWRVJcW1xzKkhUVFBfSE9TVFxzKlxdPlsnIl1ccypcLlxzKlsnIl1cXHJcXG5bJyJdIjtpOjIwNjtzOjgxOiJmaWxlX2dldF9jb250ZW50c1woXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6MjA3O3M6Njk6InRvdWNoXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aToyMDg7czoxNjoiUEhQU0hFTExfVkVSU0lPTiI7aToyMDk7czoyNjoiPFw/XHMqPUBgXCRbYS16QS1aMC05X10rP2AiO2k6MjEwO3M6MjE6IiZfU0VTU0lPTlxbcGF5bG9hZFxdPSI7aToyMTE7czo0NzoiZ3p1bmNvbXByZXNzXChccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXWh0dHAiO2k6MjEyO3M6ODQ6ImlmXChccyohZW1wdHlcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXRwMlsnIl17MCwxfVxzKlxdXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToyMTM7czo0OToiaWZcKFxzKnRydWVccyomXHMqQHByZWdfbWF0Y2hcKFxzKnN0cnRyXChccypbJyJdLyI7aToyMTQ7czozODoiPT1ccyowXClccyp7XHMqZWNob1xzKlBIUF9PU1xzKlwuXHMqXCQiO2k6MjE1O3M6MTA3OiJpc3NldFwoXHMqXCRfU0VSVkVSXFtccypfXGQrXChccypcZCtccypcKVxzKlxdXHMqXClccypcP1xzKlwkX1NFUlZFUlxbXHMqX1xkK1woXGQrXClccypcXVxzKjpccypfXGQrXChcZCtcKSI7aToyMTY7czo5OToiXCRpbmRleFxzKj1ccypzdHJfcmVwbGFjZVwoXHMqWyciXTxcP3BocFxzKm9iX2VuZF9mbHVzaFwoXCk7XHMqXD8+WyciXVxzKixccypbJyJdWyciXVxzKixccypcJGluZGV4IjtpOjIxNztzOjMzOiJcJHN0YXR1c19sb2Nfc2hccyo9XHMqZmlsZV9leGlzdHMiO2k6MjE4O3M6NDg6IlwkUE9TVF9TVFJccyo9XHMqZmlsZV9nZXRfY29udGVudHNcKCJwaHA6Ly9pbnB1dCI7aToyMTk7czo0ODoiZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdbWVzIjtpOjIyMDtzOjY2OiJcJHRhYmxlXFtcJHN0cmluZ1xbXCRpXF1cXVxzKlwqXHMqcG93XCg2NFxzKixccyoyXClccypcK1xzKlwkdGFibGUiO2k6MjIxO3M6MzM6ImlmXChccypzdHJpcG9zXChccypbJyJdXCpcKlwqXCR1YSI7aToyMjI7czo0OToiZmx1c2hfZW5kX2ZpbGVcKFxzKlwkZmlsZW5hbWVccyosXHMqXCRmaWxlY29udGVudCI7aToyMjM7czo1NjoicHJlZ19tYXRjaFwoXHMqWyciXXswLDF9fkxvY2F0aW9uOlwoXC5cKlw/XClcKFw/Olxcblx8XCQiO2k6MjI0O3M6Mjg6InRvdWNoXChccypcJHRoaXMtPmNvbmYtPnJvb3QiO2k6MjI1O3M6Mzc6ImV2YWxcKFxzKlwke1xzKlwkW2EtekEtWjAtOV9dKz9ccyp9XFsiO2k6MjI2O3M6NDM6ImlmXHMqXChccypAZmlsZXR5cGVcKFwkbGVhZG9uXHMqXC5ccypcJGZpbGUiO2k6MjI3O3M6NTk6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRpclxzKlwuXHMqXCRmaWxlXHMqXC5ccypbJyJdL2luZGV4IjtpOjIyODtzOjI2OiJmaWxlc2l6ZVwoXHMqXCRwdXRfa19mYWlsdSI7aToyMjk7czo2MDoiYWdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXXswLDF9bWVzWyciXVxdIjtpOjIzMDtzOjQzOiJmdW5jdGlvblxzK2ZpbmRIZWFkZXJMaW5lXHMqXChccypcJHRlbXBsYXRlIjtpOjIzMTtzOjQzOiJcJHN0YXR1c19jcmVhdGVfZ2xvYl9maWxlXHMqPVxzKmNyZWF0ZV9maWxlIjtpOjIzMjtzOjM4OiJlY2hvXHMrc2hvd19xdWVyeV9mb3JtXChccypcJHNxbHN0cmluZyI7aToyMzM7czozNToiPT1ccypGQUxTRVxzKlw/XHMqXGQrXHMqOlxzKmlwMmxvbmciO2k6MjM0O3M6MjI6ImZ1bmN0aW9uXHMrbWFpbGVyX3NwYW0iO2k6MjM1O3M6MzQ6IkVkaXRIdGFjY2Vzc1woXHMqWyciXVJld3JpdGVFbmdpbmUiO2k6MjM2O3M6MTE6IlwkcGF0aFRvRG9yIjtpOjIzNztzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjIzODtzOjk5OiJAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF1cKFxzKkBcJF9DT09LSUVcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVxzKlwpXHMqXCkiO2k6MjM5O3M6NDA6ImhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly9cJHBwXC5vcmciO2k6MjQwO3M6NDk6InJldHVyblxzK1snIl0vaG9tZS9bYS16QS1aMC05X10rPy9bYS16QS1aMC05X10rPy8iO2k6MjQxO3M6Mzk6IlsnIl13cC1bJyJdXHMqXC5ccypnZW5lcmF0ZVJhbmRvbVN0cmluZyI7aToyNDI7czo2ODoiXCRbYS16QS1aMC05X10rPz09WyciXWZlYXR1cmVkWyciXVxzKlwpXHMqXCl7XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGUiO2k6MjQzO3M6MTA4OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkanFccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF0iO2k6MjQ0O3M6MjI6ImV4cGxvaXRccyo6OlwuPC90aXRsZT4iO2k6MjQ1O3M6NDE6IlwkW2EtekEtWjAtOV9dKz89c3RyX3JlcGxhY2VcKFsnIl1cKmFcJFwqIjtpOjI0NjtzOjYyOiJjaHJcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKTtccyp9XHMqZXZhbFwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyNDc7czo0ODoiaWZcKFxzKmlzSW5TdHJpbmcxKlwoXCRbYS16QS1aMC05X10rPyxbJyJdZ29vZ2xlIjtpOjI0ODtzOjkzOiJcJHBwXHMqPVxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF0iO2k6MjQ5O3M6NDk6ImZpbGVfcHV0X2NvbnRlbnRzXChESVJcLlsnIl0vWyciXVwuWyciXWluZGV4XC5waHAiO2k6MjUwO3M6Mjk6IkBnZXRfaGVhZGVyc1woXHMqXCRmdWxscGF0aFwpIjtpOjI1MTtzOjIxOiJAXCRfR0VUXFtbJyJdcHdbJyJdXF0iO2k6MjUyO3M6MjU6Impzb25fZW5jb2RlXChhbGV4dXNNYWlsZXIiO2k6MjUzO3M6MTU4OiJldmFsXChccyooZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aToyNTQ7czoxOToiPVsnIl1cKVwpO1snIl1cKVwpOyI7aToyNTU7czoxNzE6Ij1ccypcJFthLXpBLVowLTlfXSs/XCgoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aToyNTY7czo1NToiXF1ccyp9XHMqXChccyp7XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyNTc7czo3NzoicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChccypbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxzKlwpXHMqLFxzKlsnIl1Hb29nbGVib3QiO2k6MjU4O3M6NDg6ImV2YWxcKFsnIl1cPz5bJyJdXHMqXC5ccypqb2luXChbJyJdWyciXSxmaWxlXChcJCI7aToyNTk7czo2ODoic2V0b3B0XChcJGNoXHMqLFxzKkNVUkxPUFRfUE9TVEZJRUxEU1xzKixccypodHRwX2J1aWxkX3F1ZXJ5XChcJGRhdGEiO2k6MjYwO3M6MTE4OiJteXNxbF9jb25uZWN0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI2MTtzOjY0OiJyZXF1ZXN0XC5zZXJ2ZXJ2YXJpYWJsZXNcKFsnIl1IVFRQX1VTRVJfQUdFTlRbJyJdXCksWyciXWFpZHVbJyJdIjtpOjI2MjtzOjM2OiJcXVxzKlwpXHMqXClccyp7XHMqZXZhbFxzKlwoXHMqXCR7XCQiO2k6MjYzO3M6MTY6ImJ5XHMrRXJyb3Jccys3ckIiO2k6MjY0O3M6MzM6IkBpcmNzZXJ2ZXJzXFtyYW5kXHMrQGlyY3NlcnZlcnNcXSI7aToyNjU7czo1OToic2V0X3RpbWVfbGltaXRcKGludHZhbFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjY2O3M6MjQ6Im5pY2tccytbJyJdY2hhbnNlcnZbJyJdOyI7aToyNjc7czoyMzoiTWFnaWNccytJbmNsdWRlXHMrU2hlbGwiO2k6MjY4O3M6MTAxOiJcJFthLXpBLVowLTlfXSs/XCk7XCRbYS16QS1aMC05X10rPz1jcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFwkW2EtekEtWjAtOV9dKz9cKTtcJFthLXpBLVowLTlfXSs/XChcKSI7aToyNjk7czozODoiY3VybE9wZW5cKFwkcmVtb3RlX3BhdGhcLlwkcGFyYW1fdmFsdWUiO2k6MjcwO3M6NDc6ImZ3cml0ZVwoXCRmcCxbJyJdXFx4RUZcXHhCQlxceEJGWyciXVwuXCRib2R5XCk7IjtpOjI3MTtzOjEzODoiXCRbYS16QS1aMC05X10rP1wrXCtcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmFycmF5X3VuaXF1ZVwoYXJyYXlfbWVyZ2VcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqW2EtekEtWjAtOV9dKz9cKFsnIl1cJFthLXpBLVowLTlfXSs/IjtpOjI3MjtzOjQyOiJhbmRccypcKCFccypzdHJzdHJcKFwkdWEsWyciXXJ2OjExWyciXVwpXCkiO2k6MjczO3M6MzU6ImVjaG9ccytcJG9rXHMrXD9ccytbJyJdU0hFTExfT0tbJyJdIjtpOjI3NDtzOjI3OiI7ZXZhbFwoXCR0b2RvY29udGVudFxbMFxdXCkiO2k6Mjc1O3M6NDA6Im9yXHMrc3RydG9sb3dlclwoQGluaV9nZXRcKFsnIl1zYWZlX21vZGUiO2k6Mjc2O3M6Mjk6ImlmXCghaXNzZXRcKFwkX1JFUVVFU1RcW2NoclwoIjtpOjI3NztzOjQ0OiJcJHByb2Nlc3NvXHMqPVxzKlwkcHNcW3JhbmRccytzY2FsYXJccytAcHNcXSI7aToyNzg7czozMjoiZWNob1xzK1snIl11bmFtZVxzKy1hO1xzKlwkdW5hbWUiO2k6Mjc5O3M6MjE6IlwudGNwZmxvb2Rccys8dGFyZ2V0PiI7aToyODA7czo1MDoiXCRib3RcW1snIl1zZXJ2ZXJbJyJdXF09XCRzZXJ2YmFuXFtyYW5kXCgwLGNvdW50XCgiO2k6MjgxO3M6MTY6IlwuOlxzK3czM2Rccys6XC4iO2k6MjgyO3M6MTY6IkJMQUNLVU5JWFxzK0NSRVciO2k6MjgzO3M6MTIzOiI7XCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwuXCRbYS16QS1aMC05X10rP1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwuXCQiO2k6Mjg0O3M6MzA6ImNhc2VccypbJyJdY3JlYXRlX3N5bWxpbmtbJyJdOiI7aToyODU7czo5ODoiXCRbYS16QS1aMC05X10rPz1hcnJheVwoWyciXVwkW2EtekEtWjAtOV9dKz9cW1xzKlxdPWFycmF5X3BvcFwoXCRbYS16QS1aMC05X10rP1wpO1wkW2EtekEtWjAtOV9dKz8iO2k6Mjg2O3M6MTEwOiJcJFthLXpBLVowLTlfXSs/PXBhY2tcKFsnIl1IXCpbJyJdLHN1YnN0clwoXCRbYS16QS1aMC05X10rPyxccyotXGQrXClcKTtccypyZXR1cm5ccytcJFthLXpBLVowLTlfXSs/XChzdWJzdHJcKCI7aToyODc7czo5Nzoic29ja2V0X2Nvbm5lY3RcKFwkW2EtekEtWjAtOV9dKz8sXHMqWyciXWdtYWlsLXNtdHAtaW5cLmxcLmdvb2dsZVwuY29tWyciXVxzKixccyoyNVwpXHMqPT1ccypGQUxTRSI7aToyODg7czoxNDI6IlwkW2EtekEtWjAtOV9dKz9cW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFwkW2EtekEtWjAtOV9dKz8sXCRbYS16QS1aMC05X10rPyxcJFthLXpBLVowLTlfXSs/XFsiO2k6Mjg5O3M6NDc6ImNhbGxfdXNlcl9mdW5jXChAdW5oZXhcKDB4W2EtekEtWjAtOV9dKz9cKVwoXCRfIjtpOjI5MDtzOjYzOiJcJF89QFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXC5AXCRfXChcJF9SRVFVRVNUXFsiO2k6MjkxO3M6NjY6IlwkR0xPQkFMU1xbXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1xkK1xdXC5cJEdMT0JBTFNcWyI7aToyOTI7czo2NToiXC5cJFthLXpBLVowLTlfXSs/XFtcJFthLXpBLVowLTlfXSs/XF1cLlsnIl17WyciXVwpXCk7fTt1bnNldFwoXCQiO2k6MjkzO3M6ODY6Imh0dHBfYnVpbGRfcXVlcnlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXClcLlsnIl0maXA9WyciXVxzKlwuXHMqXCRfU0VSVkVSIjtpOjI5NDtzOjgwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXS9zYmluL2lmY29uZmlnWyciXSI7aToyOTU7czo4OToiPFw/cGhwXHMraWZccypcKGlzc2V0XHMqXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWltYWdlc1snIl1cXVwpXClccyp7XCQiO2k6Mjk2O3M6MTc6Ijx0aXRsZT5HT1JET1xzKzIwIjtpOjI5NztzOjE0MDoiY29weVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXCkiO30="));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NzI6e2k6MDtzOjQ0OiJccyo9XHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXSI7aToxO3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjI7czo0MToiWyciXWZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDIwMDAiO2k6MztzOjQ1OiJbJyJdZmluZFxzKy9ccystdHlwZVxzK2ZccystbmFtZVxzK1wuaHRwYXNzd2QiO2k6NDtzOjI4OiJhbmRyb2lkXHxhdmFudGdvXHxibGFja2JlcnJ5IjtpOjU7czozNzoiaW5pX3NldFwoXHMqWyciXXswLDF9bWFnaWNfcXVvdGVzX2dwYyI7aTo2O3M6MTI6IlsnIl1sc1xzKy1sYSI7aTo3O3M6MTk6InJvdW5kXHMqXChccyowXHMqXCsiO2k6ODtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo5O3M6MTI6IlsnIl1ybVxzKy1yZiI7aToxMDtzOjEyOiJbJyJdcm1ccystZnIiO2k6MTE7czoxNjoiWyciXXJtXHMrLXJccystZiI7aToxMjtzOjE2OiJbJyJdcm1ccystZlxzKy1yIjtpOjEzO3M6MTA6IlsnIl1hSFIwY0QiO2k6MTQ7czo5OiJraWxsXHMrLTkiO2k6MTU7czo1MToiQ1VSTE9QVF9SRUZFUkVSLFxzKlsnIl17MCwxfWh0dHBzOi8vd3d3XC5nb29nbGVcLmNvIjtpOjE2O3M6NDM6IihcXFswLTldWzAtOV1bMC05XXxcXHhbMC05YS1mXVswLTlhLWZdKXs3LH0iO2k6MTc7czo0MDoiKFteXD9cc10pXCh7MCwxfVwuW1wrXCpdXCl7MCwxfVwyW2Etel0qZSI7aToxODtzOjEzOiJAZXh0cmFjdFxzKlwoIjtpOjE5O3M6MTM6IkBleHRyYWN0XHMqXCQiO2k6MjA7czozMToiXCRiXHMqPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXSI7aToyMTtzOjQyOiI9XHMqY3JlYXRlX2Z1bmN0aW9uXChbJyJdezAsMX1cJGFbJyJdezAsMX0iO2k6MjI7czo3MDoibWFpbFwoXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXSI7aToyMztzOjIxOiJkaXNhYmxlX2Z1bmN0aW9uc1xzKj0iO2k6MjQ7czo3NjoiXGJtYWlsXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKiI7aToyNTtzOjI5OiJmb3BlblwoXHMqWyciXVwuXC4vXC5odGFjY2VzcyI7aToyNjtzOjE0OiIhL3Vzci9iaW4vcGVybCI7aToyNztzOjQ2OiJAZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqQHNldF90aW1lX2xpbWl0XCgwXCk7IjtpOjI4O3M6MjI6InJ1bmtpdF9mdW5jdGlvbl9yZW5hbWUiO2k6Mjk7czoxNzU6IihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCQiO2k6MzA7czo3NToiJFthLXpBLVowLTlfXVx7XGQrXH1ccypcLiRbYS16QS1aMC05X11ce1xkK1x9XHMqXC4kW2EtekEtWjAtOV9dXHtcZCtcfVxzKlwuIjtpOjMxO3M6MjQ6IlxiZXZhbFwoW2EtekEtWjAtOV9dKz9cKCI7aTozMjtzOjI4OiJkaXNrX2ZyZWVfc3BhY2VcKFxzKlsnIl0vdG1wIjtpOjMzO3M6OToiUm9vdFNoZWxsIjtpOjM0O3M6MTQ6IkJPVE5FVFxzK1BBTkVMIjtpOjM1O3M6MTU6IlsnIl0vZXRjL3Bhc3N3ZCI7aTozNjtzOjE1OiJbJyJdL3Zhci9jcGFuZWwiO2k6Mzc7czoxNDoiWyciXS9ldGMvaHR0cGQiO2k6Mzg7czoyMDoiWyciXS9ldGMvbmFtZWRcLmNvbmYiO2k6Mzk7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdSFRUUF9SRUZFUkVSWyciXVxzKlxdXHMqLFxzKlsnIl10cnVzdGxpbmtcLnJ1IjtpOjQwO3M6MTM6Ijg5XC4yNDlcLjIxXC4iO2k6NDE7czoxNToiMTA5XC4yMzhcLjI0MlwuIjtpOjQyO3M6MTg6Ij09XHMqWyciXTQ2XC4yMjlcLiI7aTo0MztzOjE4OiI9PVxzKlsnIl05MVwuMjQzXC4iO2k6NDQ7czo1OiJKVGVybSI7aTo0NTtzOjU6Ik9uZXQ3IjtpOjQ2O3M6OToiXCRwYXNzX3VwIjtpOjQ3O3M6NToieENlZHoiO2k6NDg7czoxMTQ6ImlmXHMqXChccypmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl17MCwxfShmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXClccypcKSI7aTo0OTtzOjg5OiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo1MDtzOjYzOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXWltYWdlcy8iO2k6NTE7czo2OToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKEAqdXJsZW5jb2RlIjtpOjUyO3M6Mjc6IlwkT09PLis/PVxzKnVybGRlY29kZVxzKlwoKiI7aTo1MztzOjY5OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoKlsnIl1jZFxzKy90bXAiO2k6NTQ7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6NTU7czoxNToicGNudGxfZXhlY1xzKlwoIjtpOjU2O3M6MzI6InN0cl9pcmVwbGFjZVxzKlwoKlxzKlsnIl08L2hlYWQ+IjtpOjU3O3M6MzA3OiIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjU4O3M6MjM6ImNvcHlccypcKFxzKlsnIl1odHRwOi8vIjtpOjU5O3M6MTkwOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCpccypcJF9GSUxFU1xbXHMqWyciXXswLDF9ZmlsZW5hbWVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9GSUxFU1xbXHMqWyciXXswLDF9ZmlsZW5hbWVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjYwO3M6Mjg6ImVjaG9ccypcKCpccypbJyJdTk8gRklMRVsnIl0iO2k6NjE7czoxNToiWyciXS9cLlwqL2VbJyJdIjtpOjYyO3M6NDU3OiIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpIjtpOjYzO3M6NjQ6ImVjaG9ccytzdHJpcHNsYXNoZXNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NjQ7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aTo2NTtzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6NjY7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6Njc7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aTo2ODtzOjM1OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1ldmFsWyciXSI7aTo2OTtzOjQ0OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1iYXNlNjRfZGVjb2RlWyciXSI7aTo3MDtzOjQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1jcmVhdGVfZnVuY3Rpb25bJyJdIjtpOjcxO3M6Mzc6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWFzc2VydFsnIl0iO2k6NzI7czo0MzoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdcHJlZ19yZXBsYWNlWyciXSI7aTo3MztzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo3NDtzOjg0OiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1snIl10bXBfbmFtZVsnIl1cXVxzKiwiO2k6NzU7czo4MToibWFpbFwoXCRfUE9TVFxbWyciXXswLDF9ZW1haWxbJyJdezAsMX1cXSxccypcJF9QT1NUXFtbJyJdezAsMX1zdWJqZWN0WyciXXswLDF9XF0sIjtpOjc2O3M6Nzc6Im1haWxccypcKFwkZW1haWxccyosXHMqWyciXXswLDF9PVw/VVRGLThcP0JcP1snIl17MCwxfVwuYmFzZTY0X2VuY29kZVwoXCRmcm9tIjtpOjc3O3M6NjQ6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbYS16QS1aMC05X10rP1xzKlxdXCgiO2k6Nzg7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTo3OTtzOjM4OiJKUmVzcG9uc2U6OnNldEJvZHlccypcKFxzKnByZWdfcmVwbGFjZSI7aTo4MDtzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo4MTtzOjM2OiJYLU1haWxlcjpccypNaWNyb3NvZnQgT2ZmaWNlIE91dGxvb2siO2k6ODI7czo5MToibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChcJHRvXClccyosXHMqc3RyaXBzbGFzaGVzXChcJHN1YmplY3RcKVxzKixccypzdHJpcHNsYXNoZXNcKFwkbWVzc2FnZSI7aTo4MztzOjY2OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XCgiO2k6ODQ7czoyMjI6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKiI7aTo4NTtzOjE1NToiXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xzKlxdXFtccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC4iO2k6ODY7czoyMzoiaXNfd3JpdGFibGU9aXNfd3JpdGFibGUiO2k6ODc7czozODoiQG1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCR1c2VyZmlsZV90bXAiO2k6ODg7czoyNjoiZXhpdFwoXCk6ZXhpdFwoXCk6ZXhpdFwoXCkiO2k6ODk7czo2NToiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6OTA7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6OTE7czo1OToiXChccypcJHNlbmRccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZVxzKixccypcJGhlYWRlcnMiO2k6OTI7czo0NToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlxbIjtpOjkzO3M6NjY6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9cWyI7aTo5NDtzOjUyOiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqXChccypbJyJdIjtpOjk1O3M6NzM6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKiwiO2k6OTY7czo3MToiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXCkiO2k6OTc7czo4MToiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1sd3AtZG93bmxvYWRccytodHRwOi8vIjtpOjk4O3M6MTAxOiJzdHJfcmVwbGFjZVwoWyciXS5bJyJdXHMqLFxzKlsnIl0uWyciXVxzKixccypzdHJfcmVwbGFjZVwoWyciXS5bJyJdXHMqLFxzKlsnIl0uWyciXVxzKixccypzdHJfcmVwbGFjZSI7aTo5OTtzOjM2OiIvYWRtaW4vY29uZmlndXJhdGlvblwucGhwL2xvZ2luXC5waHAiO2k6MTAwO3M6NzE6InNlbGVjdFxzKmNvbmZpZ3VyYXRpb25faWQsXHMrY29uZmlndXJhdGlvbl90aXRsZSxccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjEwMTtzOjUwOiJ1cGRhdGVccypjb25maWd1cmF0aW9uXHMrc2V0XHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aToxMDI7czozNzoic2VsZWN0XHMqbGFuZ3VhZ2VzX2lkLFxzK25hbWUsXHMrY29kZSI7aToxMDM7czo1MjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlxcWyciXVxcWyciXTt9aWZcKCFnZXRDb29raWVcKCI7aToxMDQ7czo1MzoiXCRbYS16QS1aMC05X10rPyA9IFwkW2EtekEtWjAtOV9dKz9cKFsnIl17MCwxfWh0dHA6Ly8iO2k6MTA1O3M6NDU6ImlmXChmaWxlX3B1dF9jb250ZW50c1woXCRpbmRleF9wYXRoLFxzKlwkY29kZSI7aToxMDY7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjEwNztzOjUwOiI8aWZyYW1lXHMrc3JjPVsnIl1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tL2Zvcm1zLyI7aToxMDg7czoyMjoiLFsnIl08XD9waHBcXG5bJyJdXC5cJCI7aToxMDk7czo3MDoiPFw/cGhwXHMrKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqWyciXS9ob21lLyI7aToxMTA7czoyMjoieHJ1bWVyX3NwYW1fbGlua3NcLnR4dCI7aToxMTE7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjExMjtzOjc3OiJhcnJheV9tZXJnZVwoXCRleHRccyosXHMqYXJyYXlcKFsnIl13ZWJzdGF0WyciXSxbJyJdYXdzdGF0c1snIl0sWyciXXRlbXBvcmFyeSI7aToxMTM7czo5MDoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjExNDtzOjI4OiJNb3RoZXJbJyJdc1xzK01haWRlblxzK05hbWU6IjtpOjExNTtzOjM5OiJsb2NhdGlvblwucmVwbGFjZVwoXFxbJyJdXCR1cmxfcmVkaXJlY3QiO2k6MTE2O3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aToxMTc7czo4MzoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWN1cmxccystT1xzK2h0dHA6Ly8iO2k6MTE4O3M6Mjk6IlwpXCksUEhQX1ZFUlNJT04sbWQ1X2ZpbGVcKFwkIjtpOjExOTtzOjc5OiJcJFthLXpBLVowLTlfXSs/XFtcJFthLXpBLVowLTlfXSs/XF1cW1wkW2EtekEtWjAtOV9dKz9cW1xkK1xdXC5cJFthLXpBLVowLTlfXSs/IjtpOjEyMDtzOjM0OiJcJHF1ZXJ5XHMrLFxzK1snIl1mcm9tJTIwam9zX3VzZXJzIjtpOjEyMTtzOjE1OiJldmFsXChbJyJdXHMqLy8iO2k6MTIyO3M6MTY6ImV2YWxcKFsnIl1ccyovXCoiO2k6MTIzO3M6MTA5OiJcJFthLXpBLVowLTlfXSs/XHMqPVwkW2EtekEtWjAtOV9dKz9ccypcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwoWyciXVxzKntcJFthLXpBLVowLTlfXSs/IjtpOjEyNDtzOjMxOiIhZXJlZ1woWyciXVxeXCh1bnNhZmVfcmF3XClcP1wkIjtpOjEyNTtzOjM1OiJcJGJhc2VfZG9tYWluXHMqPVxzKmdldF9iYXNlX2RvbWFpbiI7aToxMjY7czo5OiJzZXhzZXhzZXgiO2k6MTI3O3M6MjM6IlwrdW5pb25cK3NlbGVjdFwrMCwwLDAsIjtpOjEyODtzOjM3OiJjb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhLHVzZXJuYW1lIjtpOjEyOTtzOjM0OiJncm91cF9jb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhIjtpOjEzMDtzOjU1OiJcKi9ccyooaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqL1wqIjtpOjEzMTtzOjg6ImFiYWtvL0FPIjtpOjEzMjtzOjQ4OiJpZlwoXHMqc3RycG9zXChccypcJHZhbHVlXHMqLFxzKlwkbWFza1xzKlwpXHMqXCkiO2k6MTMzO3M6MTA2OiJ1bmxpbmtcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdezAsMX0vYXNzZXRzL2NhY2hlL3RlbXAvRmlsZVNldHRpbmdzIjtpOjEzNDtzOjE0MjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmpwZyI7aToxMzU7czoxNDI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5naWYiO2k6MTM2O3M6MTQyOiIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wucG5nIjtpOjEzNztzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wucG5nIjtpOjEzODtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuanBnIjtpOjEzOTtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuZ2lmIjtpOjE0MDtzOjEyMDoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuaWNvIjtpOjE0MTtzOjEwNjoiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aToxNDI7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MTQzO3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MTQ0O3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjE0NTtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aToxNDY7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjE0NztzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MTQ4O3M6Mjc6InN0cmxlblwoXHMqXCRwYXRoVG9Eb3JccypcKSI7aToxNDk7czo2NDoiaXNzZXRcKFxzKlwkX0NPT0tJRVxbXHMqbWQ1XChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfSE9TVCI7aToxNTA7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjE1MTtzOjg0OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD1bJyJdXC5cJHBvc3RcW1snIl17MCwxfWlkWyciXXswLDF9XF0iO2k6MTUyO3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6MTUzO3M6OToiTDNaaGNpOTNkIjtpOjE1NDtzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aToxNTU7czo1MjoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9ccyosXHMqMDQwNCI7aToxNTY7czo1MjoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9ccyosXHMqMDc1NSI7aToxNTc7czo0MjoiQHVtYXNrXChccyowNzc3XHMqJlxzKn5ccypcJGZpbGVwZXJtaXNzaW9uIjtpOjE1ODtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aToxNTk7czoxNjoiO1xzKi9iaW4vc2hccyotaSI7aToxNjA7czo0MToiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6MTYxO3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjE2MjtzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6MTYzO3M6MTU6Ii90bXAvXC5JQ0UtdW5peCI7aToxNjQ7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6MTY1O3M6Mjc6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcyI7aToxNjY7czozMzoidG91Y2hccypcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fIjtpOjE2NztzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjE2ODtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MTY5O3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjE3MDtzOjc0OiJcJHJldCA9IFwkdGhpcy0+X2RiLT51cGRhdGVPYmplY3RcKCBcJHRoaXMtPl90YmwsIFwkdGhpcywgXCR0aGlzLT5fdGJsX2tleSI7aToxNzE7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToxNzI7czo1NDoic3Vic3RyXChccypcJHJlc3BvbnNlXHMqLFxzKlwkaW5mb1xbXHMqWyciXWhlYWRlcl9zaXplIjtpOjE3MztzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjE3NDtzOjUwOiI8aW5wdXRccyt0eXBlPXN1Ym1pdFxzK3ZhbHVlPVVwbG9hZFxzKi8+XHMqPC9mb3JtPiI7aToxNzU7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToxNzY7czo1NzoiQGVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKmlmXHMqXChccyohaXNzZXRccypcKFxzKlwkIjtpOjE3NztzOjMwOiJlbHNlXHMqe1xzKmVjaG9ccypbJyJdZmFpbFsnIl0iO2k6MTc4O3M6NTE6InR5cGU9WyciXXN1Ym1pdFsnIl1ccyp2YWx1ZT1bJyJdVXBsb2FkIGZpbGVbJyJdXHMqPiI7aToxNzk7czozNzoiaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqXCRsaW5rWyciXSI7aToxODA7czozMToiZWNob1xzKlsnIl08Yj5VcGxvYWQ8c3M+U3VjY2VzcyI7aToxODE7czo0MzoibmFtZT1bJyJddXBsb2FkZXJbJyJdXHMraWQ9WyciXXVwbG9hZGVyWyciXSI7aToxODI7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjE4MztzOjI0OiJ1bmxpbmtcKFxzKl9fRklMRV9fXHMqXCkiO2k6MTg0O3M6NTY6Im1haWxcKFxzKlwkYXJyXFtbJyJddG9bJyJdXF1ccyosXHMqXCRhcnJcW1snIl1zdWJqWyciXVxdIjtpOjE4NTtzOjEzMDoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKmV4aXRcKFwpOyI7aToxODY7czoxMzoibnVsbF9leHBsb2l0cyI7aToxODc7czo0ODoiPFw/XHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpIjtpOjE4ODtzOjk6InRtdmFzeW5nciI7aToxODk7czoxMjoidG1oYXBiemNlcmZmIjtpOjE5MDtzOjEzOiJvbmZyNjRfcXJwYnFyIjtpOjE5MTtzOjE0OiJbJyJdbmZmcmVnWyciXSI7aToxOTI7czo5OiJmZ2VfZWJnMTMiO2k6MTkzO3M6NzoiY3VjdmFzYiI7aToxOTQ7czoxNDoiWyciXWZsZmdyelsnIl0iO2k6MTk1O3M6MTI6IlsnIl1yaW55WyciXSI7aToxOTY7czo5OiJldGFsZm5pemciO2k6MTk3O3M6MTI6InNzZXJwbW9jbnV6ZyI7aToxOTg7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToxOTk7czoxNDoiWyciXXRyZXNzYVsnIl0iO2k6MjAwO3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjIwMTtzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MjAyO3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjIwMztzOjEyOiJbJyJdcmlueVsnIl0iO2k6MjA0O3M6NDQ6IkBcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XHMqXCk7IjtpOjIwNTtzOjQ4OiJwYXJzZV9xdWVyeV9zdHJpbmdcKFxzKlwkRU5We1xzKlsnIl1RVUVSWV9TVFJJTkciO2k6MjA2O3M6MzE6ImV2YWxccypcKFxzKm1iX2NvbnZlcnRfZW5jb2RpbmciO2k6MjA3O3M6MjQ6IlwpXHMqe1xzKnBhc3N0aHJ1XChccypcJCI7aToyMDg7czoxNToiSFRUUF9BQ0NFUFRfQVNFIjtpOjIwOTtzOjIxOiJmdW5jdGlvblxzKkN1cmxBdHRhY2siO2k6MjEwO3M6MTg6IkBzeXN0ZW1cKFxzKlsnIl1cJCI7aToyMTE7czoyMzoiZWNob1woXHMqaHRtbFwoXHMqYXJyYXkiO2k6MjEyO3M6NTY6IlwkY29kZT1bJyJdJTFzY3JpcHRccyp0eXBlPVxcWyciXXRleHQvamF2YXNjcmlwdFxcWyciXSUzIjtpOjIxMztzOjIyOiJhcnJheVwoXHMqWyciXSUxaHRtbCUzIjtpOjIxNDtzOjE5OiJidWRha1xzKi1ccypleHBsb2l0IjtpOjIxNTtzOjkwOiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoXHMqWyciXVwkW2EtekEtWjAtOV9dKz9bJyJdXHMqXCkiO2k6MjE2O3M6OToiR0FHQUw8L2I+IjtpOjIxNztzOjM4OiJleGl0XChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToyMTg7czozNzoiZGllXChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToyMTk7czozNjoic2V0X3RpbWVfbGltaXRcKFxzKmludHZhbFwoXHMqXCRhcmd2IjtpOjIyMDtzOjMzOiJlY2hvXHMqXCRwcmV3dWVcLlwkbG9nXC5cJHBvc3R3dWUiO2k6MjIxO3M6NDI6ImNvbm5ccyo9XHMqaHR0cGxpYlwuSFRUUENvbm5lY3Rpb25cKFxzKnVyaSI7aToyMjI7czozNjoiaWZccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfWNobW9kNzc3IjtpOjIyMztzOjI2OiI8XD9ccyplY2hvXHMqXCRjb250ZW50O1w/PiI7aToyMjQ7czo4NjoiXCR1cmxccypcLj1ccypbJyJdXD9bYS16QS1aMC05X10rPz1bJyJdXHMqXC5ccypcJF9HRVRcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXTsiO2k6MjI1O3M6MTA5OiJjb3B5XChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9QT1NUIjtpOjIyNjtzOjExNjoibW92ZV91cGxvYWRlZF9maWxlXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXVxbWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1cXVxbXHMqXCRpXHMqXF0iO2k6MjI3O3M6MzI6ImRuc19nZXRfcmVjb3JkXChccypcJGRvbWFpblxzKlwuIjtpOjIyODtzOjM0OiJmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl1nZXRteHJyIjtpOjIyOTtzOjI0OiJuc2xvb2t1cFwuZXhlXHMqLXR5cGU9TVgiO2k6MjMwO3M6MTI6Im5ld1xzKk1DdXJsOyI7aToyMzE7czo0NDoiXCRmaWxlX2RhdGFccyo9XHMqWyciXTxzY3JpcHRccypzcmM9WyciXWh0dHAiO2k6MjMyO3M6NDA6ImZwdXRzXChcJGZwLFxzKlsnIl1JUDpccypcJGlwXHMqLVxzKkRBVEUiO2k6MjMzO3M6Mjg6ImNobW9kXChccypfX0RJUl9fXHMqLFxzKjA0MDAiO2k6MjM0O3M6NDA6IkNvZGVNaXJyb3JcLmRlZmluZU1JTUVcKFxzKlsnIl10ZXh0L21pcmMiO2k6MjM1O3M6NDM6IlxdXHMqXClccypcLlxzKlsnIl1cXG5cPz5bJyJdXHMqXClccypcKVxzKnsiO2k6MjM2O3M6Njc6IlwkZ3pwXHMqPVxzKlwkYmd6RXhpc3RccypcP1xzKkBnem9wZW5cKFwkdG1wZmlsZSxccypbJyJdcmJbJyJdXHMqXCkiO2k6MjM3O3M6NzU6ImZ1bmN0aW9uPHNzPnNtdHBfbWFpbFwoXCR0b1xzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aToyMzg7czo2NDoiXCRfUE9TVFxbWyciXXswLDF9YWN0aW9uWyciXXswLDF9XF1ccyo9PVxzKlsnIl1nZXRfYWxsX2xpbmtzWyciXSI7aToyMzk7czozODoiPVxzKmd6aW5mbGF0ZVwoXHMqYmFzZTY0X2RlY29kZVwoXHMqXCQiO2k6MjQwO3M6NDE6ImNobW9kXChcJGZpbGUtPmdldFBhdGhuYW1lXChcKVxzKixccyowNzc3IjtpOjI0MTtzOjYzOiJcJF9QT1NUXFtbJyJdezAsMX10cDJbJyJdezAsMX1cXVxzKlwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MjQyO3M6MjQ1OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlwkW2EtekEtWjAtOV9dKz9cKFsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqXClccypcKSI7aToyNDM7czoxMTA6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXCk7XHMqZXhpdFwoXHMqXCk7IjtpOjI0NDtzOjMxOiI9PlxzKkBcJGYyXChfX0ZJTEVfX1xzKixccypcJGYxIjtpOjI0NTtzOjg0OiJldmFsXChccypbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKTtccypcPz4iO2k6MjQ2O3M6Mzc6ImlmXHMqXChccyppc19jcmF3bGVyMVwoXHMqXClccypcKVxzKnsiO2k6MjQ3O3M6NDg6IlwkZWNob18xXC5cJGVjaG9fMlwuXCRlY2hvXzNcLlwkZWNob180XC5cJGVjaG9fNSI7aToyNDg7czozNToiZmlsZV9nZXRfY29udGVudHNcKFxzKl9fRklMRV9fXHMqXCkiO2k6MjQ5O3M6ODE6IkAoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqQHVybGVuY29kZVwoXHMqXCRfUE9TVCI7aToyNTA7czo5NzoiXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwocm91bmRcKFxkK1wpXClcXSI7aToyNTE7czoyNToiZnVuY3Rpb25ccytlcnJvcl80MDRcKFwpeyI7aToyNTI7czo2NjoiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1wZXJsIjtpOjI1MztzOjY4OiIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXXB5dGhvbiI7aToyNTQ7czo3NDoiaWZccypcKGlzc2V0XChcJF9HRVRcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXClccyp7XHMqZWNob1xzKlsnIl1va1snIl0iO2k6MjU1O3M6Mzk6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkX0dFVFxbXHMqWyciXWNweSI7aToyNTY7czo0NjoiaHR0cDovLy4rPy8uKz9cLnBocFw/YT1cZCsmYz1bYS16QS1aMC05X10rPyZzPSI7aToyNTc7czoxNTA6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXVwkW2EtekEtWjAtOV9dKz89QFthLXpBLVowLTlfXSs/XChbJyJdLis/WyciXVwpO1thLXpBLVowLTlfXSs/XCghXCRbYS16QS1aMC05X10rP1wpe1wkW2EtekEtWjAtOV9dKz89QFthLXpBLVowLTlfXSs/XChccypcKSI7aToyNTg7czoxNjoiZnVuY3Rpb25ccyt3c29FeCI7aToyNTk7czo1MToiZm9yZWFjaFwoXHMqXCR0b3Nccyphc1xzKlwkdG9cKVxzKntccyptYWlsXChccypcJHRvIjtpOjI2MDtzOjEwMjoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFsnIl1odHRwOi8vLis/XC5qcGdbJyJdXCk7XHMqZXhpdFwoXCk7IjtpOjI2MTtzOjEyOiI8XD89XCRjbGFzczsiO2k6MjYyO3M6NTA6IjxpbnB1dFxzKnR5cGU9ImZpbGUiXHMqc2l6ZT0iXGQrIlxzKm5hbWU9InVwbG9hZCI+IjtpOjI2MztzOjExMDoiXCRtZXNzYWdlc1xbXF1ccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXVzZXJmaWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXVxbXHMqXCRpXHMqXF0iO2k6MjY0O3M6NTU6IjxpbnB1dFxzKnR5cGU9WyciXWZpbGVbJyJdXHMqbmFtZT1bJyJddXNlcmZpbGVbJyJdXHMqLz4iO2k6MjY1O3M6MTM6IkRldmFydFxzK0hUVFAiO2k6MjY2O3M6OTA6IkBcJHtccypbYS16QS1aMC05X10rP1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXSs/XHMqfVwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyNjc7czo5NToiXCRHTE9CQUxTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXSs/XFtccypcJFthLXpBLVowLTlfXSs/XF0iO2k6MjY4O3M6NTM6ImVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjI2OTtzOjYwOiJcJFthLXpBLVowLTlfXSs/XFtccypcZCtccyouXHMqXGQrXHMqXF1cKFxzKlthLXpBLVowLTlfXSs/XCgiO2k6MjcwO3M6MTI0OiJcJFthLXpBLVowLTlfXSs/PVsnIl1odHRwOi8vLis/WyciXTtccypcJFthLXpBLVowLTlfXSs/PWZvcGVuXChcJFthLXpBLVowLTlfXSs/LFsnIl1yWyciXVwpO1xzKnJlYWRmaWxlXChcJFthLXpBLVowLTlfXSs/XCk7IjtpOjI3MTtzOjc1OiJhcnJheVwoXHMqWyciXTwhLS1bJyJdXHMqXC5ccyptZDVcKFxzKlwkcmVxdWVzdF91cmxccypcLlxzKnJhbmRcKFxkKyxccypcZCsiO2k6MjcyO3M6MTQ6Indzb0hlYWRlclxzKlwoIjtpOjI3MztzOjY5OiJlY2hvXChbJyJdPGZvcm0gbWV0aG9kPVsnIl1wb3N0WyciXVxzKmVuY3R5cGU9WyciXW11bHRpcGFydC9mb3JtLWRhdGEiO2k6Mjc0O3M6NDM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8iO2k6Mjc1O3M6NTg6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6Mjc2O3M6NDA6Im1haWxcKFwkdG9ccyosXHMqWyciXS4rP1snIl1ccyosXHMqXCR1cmwiO2k6Mjc3O3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToyNzg7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6Mjc5O3M6Mzg6ImVsc2VpZlwoXHMqXCRzcWx0eXBlXHMqPT1ccypbJyJdc3FsaXRlIjtpOjI4MDtzOjE5OiI9WyciXVwpXHMqXCk7XHMqXD8+IjtpOjI4MTtzOjI0OiJlY2hvXHMrYmFzZTY0X2RlY29kZVwoXCQiO2k6MjgyO3M6NTI6IlwjW2EtekEtWjAtOV9dKz9cIy4rPzwvc2NyaXB0Pi4rP1wjL1thLXpBLVowLTlfXSs/XCMiO2k6MjgzO3M6MzQ6ImZ1bmN0aW9uXHMrX19maWxlX2dldF91cmxfY29udGVudHMiO2k6Mjg0O3M6MjU6ImV2YWxcKFxzKlwkW2EtekEtWjAtOV9dKz8iO2k6Mjg1O3M6NTU6IlwkZlxzKj1ccypcJGZcZCtcKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkW2EtekEtWjAtOV9dKz8iO2k6Mjg2O3M6MzI6ImV2YWxcKFwkY29udGVudFwpO1xzKmVjaG9ccypbJyJdIjtpOjI4NztzOjI5OiJDVVJMT1BUX1VSTFxzKixccypbJyJdc210cDovLyI7aToyODg7czo3NzoiPGhlYWQ+XHMqPHNjcmlwdD5ccyp3aW5kb3dcLnRvcFwubG9jYXRpb25cLmhyZWY9WyciXS4rP1xzKjwvc2NyaXB0PlxzKjwvaGVhZD4iO2k6Mjg5O3M6NzI6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZm9wZW5cKFxzKlsnIl1bYS16QS1aMC05X10rP1wucGhwWyciXVxzKixccypbJyJddyI7aToyOTA7czoxNjoiQGFzc2VydFwoXHMqWyciXSI7aToyOTE7czo4MzoiXCRbYS16QS1aMC05X10rPz1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWRvWyciXVxzKlxdO1xzKmluY2x1ZGUiO2k6MjkyO3M6Nzk6ImVjaG9ccytcJFthLXpBLVowLTlfXSs/O21rZGlyXChccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXCk7ZmlsZV9wdXRfY29udGVudHMiO2k6MjkzO3M6NjE6IlwkZnJvbVxzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWZyb20iO2k6Mjk0O3M6MTk6Ij1ccyp4ZGlyXChccypcJHBhdGgiO2k6Mjk1O3M6MzE6IlwkX1thLXpBLVowLTlfXSs/XChccypcKTtccypcPz4iO2k6Mjk2O3M6MTA6InRhclxzKy16Y0MiO2k6Mjk3O3M6ODM6ImVjaG9ccytzdHJfcmVwbGFjZVwoXHMqWyciXVxbUEhQX1NFTEZcXVsnIl1ccyosXHMqYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXVBIUF9TRUxGIjtpOjI5ODtzOjQxOiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1mXCRbYS16QS1aMC05X10rPyI7aToyOTk7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aTozMDA7czozNToiaHJlZj1bJyJdPFw/cGhwXHMrZWNob1xzK1wkY3VyX3BhdGgiO2k6MzAxO3M6MzM6Ij1ccyplc2NfdXJsXChccypzaXRlX3VybFwoXHMqWyciXSI7aTozMDI7czo4NToiXlxzKjxcP3BocFxzKmhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlsnIl1ccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aTozMDM7czoxNDoiPHRpdGxlPlxzKml2bnoiO2k6MzA0O3M6NjM6Il5ccyo8XD9waHBccypoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aTozMDU7czo2MToiZ2V0X3VzZXJzXChccyphcnJheVwoXHMqWyciXXJvbGVbJyJdXHMqPT5ccypbJyJdYWRtaW5pc3RyYXRvciI7aTozMDY7czo2NToiXCR0b1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXRvX2FkZHJlc3MiO2k6MzA3O3M6MTk6ImltYXBfaGVhZGVyaW5mb1woXCQiO2k6MzA4O3M6NTg6IlwkW2EtekEtWjAtOV9dKz9cW1xzKl9bYS16QS1aMC05X10rP1woXHMqXGQrXHMqXClccypcXVxzKj0iO2k6MzA5O3M6MzQ6ImV2YWxcKFxzKlsnIl1cPz5bJyJdXHMqXC5ccypqb2luXCgiO2k6MzEwO3M6MzU6ImJlZ2luXHMrbW9kOlxzK1RoYW5rc1xzK2ZvclxzK3Bvc3RzIjtpOjMxMTtzOjkzOiJcJFthLXpBLVowLTlfXSs/PVsnIl1bYS16QS1aMC05XCtcPV9dK1snIl07XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkW2EtekEtWjAtOV9dKz9cKTtccypcPz4iO2k6MzEyO3M6NjM6IlwkW2EtekEtWjAtOV9dKz8tPl9zY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aTozMTM7czozMjoiWyciXVxzKlxeXHMqXCRbYS16QS1aMC05X10rP1xzKjsiO2k6MzE0O3M6Njg6IlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcXlxzKlwkW2EtekEtWjAtOV9dKz9ccyo7IjtpOjMxNTtzOjEyMjoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyo9PVxzKlsnIl0iO2k6MzE2O3M6MTI6Ilwud3d3Ly86cHR0aCI7aTozMTc7czo2MzoiJTYzJTcyJTY5JTcwJTc0JTJFJTczJTcyJTYzJTNEJTI3JTY4JTc0JTc0JTcwJTNBJTJGJTJGJTczJTZGJTYxIjtpOjMxODtzOjI3OiJ3cC1vcHRpb25zXC5waHBccyo+XHMqRXJyb3IiO2k6MzE5O3M6ODk6InN0cl9yZXBsYWNlXChhcnJheVwoWyciXWZpbHRlclN0YXJ0WyciXSxbJyJdZmlsdGVyRW5kWyciXVwpLFxzKmFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqIjtpOjMyMDtzOjM3OiJmaWxlX2dldF9jb250ZW50c1woX19GSUxFX19cKSxcJG1hdGNoIjtpOjMyMTtzOjMwOiJ0b3VjaFwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MzIyO3M6MTU6IlsnIl1cKVwpXCk7IlwpOyI7aTozMjM7czoyMToiXHxib3RcfHNwaWRlclx8d2dldC9pIjtpOjMyNDtzOjYzOiJzdHJfcmVwbGFjZVwoWyciXTwvYm9keT5bJyJdLFthLXpBLVowLTlfXSs/XC5bJyJdPC9ib2R5PlsnIl0sXCQiO2k6MzI1O3M6MzQ6ImV4cGxvZGVcKFsnIl07dGV4dDtbJyJdLFwkcm93XFswXF0iO2k6MzI2O3M6OTI6Im1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpIjtpOjMyNztzOjIxMToiPVxzKm1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXSI7aTozMjg7czoxNTY6Ij1ccyptYWlsXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXHMqLFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXSI7aTozMjk7czoxNDoiTGliWG1sMklzQnVnZ3kiO2k6MzMwO3M6OToibWFhZlxzK3lhIjtpOjMzMTtzOjM1OiJlY2hvIFthLXpBLVowLTlfXSs/XHMqXChbJyJdaHR0cDovLyI7aTozMzI7czo0ODoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1hc3N1bnRvIjtpOjMzMztzOjEyOiJgY2hlY2tzdWV4ZWMiO2k6MzM0O3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aTozMzU7czo0NToicm1kaXJzXChcJGRpclxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGNoaWxkIjtpOjMzNjtzOjQyOiJleHBsb2RlXChccypcXFsnIl07dGV4dDtcXFsnIl1ccyosXHMqXCRyb3ciO2k6MzM3O3M6Mzc6Ij1ccypbJyJdcGhwX3ZhbHVlXHMrYXV0b19wcmVwZW5kX2ZpbGUiO2k6MzM4O3M6MzU6ImlmXHMqXChccyppc193cml0YWJsZVwoXHMqXCR3d3dQYXRoIjtpOjMzOTtzOjQ3OiJmb3BlblwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS93cC1hZG1pbiI7aTozNDA7czoyMjoicmV0dXJuXHMqWyciXS92YXIvd3d3LyI7aTozNDE7czo2NToiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vdmFyL3d3dy8iO2k6MzQyO3M6NjI6IihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL2hvbWUvIjtpOjM0MztzOjE5MjoiXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuIjtpOjM0NDtzOjE2OiJ0YWdzL1wkNi9cJDQvXCQ3IjtpOjM0NTtzOjMwOiJzdHJfcmVwbGFjZVwoXHMqWyciXVwuaHRhY2Nlc3MiO2k6MzQ2O3M6NDQ6ImZ1bmN0aW9uXHMrX1xkK1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpe1wkIjtpOjM0NztzOjIxOiJleHBsb2RlXChcXFsnIl07dGV4dDsiO2k6MzQ4O3M6MTI2OiJzdWJzdHJcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXGQrXHMqLFxzKlxkK1xzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqcHJlZ19yZXBsYWNlXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKnN0cnRyXCgiO2k6MzQ5O3M6NjY6ImFycmF5X2ZsaXBcKFxzKmFycmF5X21lcmdlXChccypyYW5nZVwoXHMqWyciXUFbJyJdXHMqLFxzKlsnIl1aWyciXSI7aTozNTA7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjM1MTtzOjMxOiJcJGluc2VydF9jb2RlXHMqPVxzKlsnIl08aWZyYW1lIjtpOjM1MjtzOjQxOiJhc3NlcnRfb3B0aW9uc1woXHMqQVNTRVJUX1dBUk5JTkdccyosXHMqMCI7aTozNTM7czoxNToiTXVzdEBmQFxzK1NoZWxsIjtpOjM1NDtzOjY3OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/IjtpOjM1NTtzOjM0OiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjM1NjtzOjQwOiJzdHJfcmVwbGFjZVwoWyciXVwuaHRhY2Nlc3NbJyJdXHMqLFxzKlwkIjtpOjM1NztzOjMzOiI9XHMqQCpnemluZmxhdGVcKFxzKnN0cnJldlwoXHMqXCQiO2k6MzU4O3M6NTc6IlwkW2EtekEtWjAtOV9dKz89WyciXS9ob21lL1thLXpBLVowLTlfXSs/L1thLXpBLVowLTlfXSs/LyI7aTozNTk7czoyMjoiZ1woXHMqWyciXUZpbGVzTWFuWyciXSI7aTozNjA7czoxMTc6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcKSI7aTozNjE7czozMzoiXCRbYS16QS1aMC05X10rP1woXHMqQFwkX0NPT0tJRVxbIjtpOjM2MjtzOjI4OiJzdHJfcmVwbGFjZVwoWyciXS9cP2FuZHJbJyJdIjtpOjM2MztzOjIwOToiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlcKFxzKlwkX1JFUVVFU1RcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1ccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmFycmF5X2ZpbHRlclwoXHMqXCQiO2k6MzY0O3M6MTMzOiJcJFthLXpBLVowLTlfXSs/XHMqXC49XHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9IjtpOjM2NTtzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTozNjY7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTozNjc7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjM2ODtzOjU1OiJpZlxzKlwoXHMqXCR0aGlzLT5pdGVtLT5oaXRzXHMqPj1bJyJdXGQrWyciXVwpXHMqe1xzKlwkIjtpOjM2OTtzOjQ3OiJleHBsb2RlXChbJyJdXFxuWyciXSxccypcJF9QT1NUXFtbJyJddXJsc1snIl1cXSI7aTozNzA7czoxMTY6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rP1wpIjtpOjM3MTtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6MzcyO3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjM3MztzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6Mzc0O3M6MjE6ImluY2x1ZGVcKFxzKlsnIl0vdG1wLyI7aTozNzU7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTozNzY7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjM3NztzOjEwOiJkZWtjYWhbJyJdIjtpOjM3ODtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTozNzk7czoxMzoiPT1bJyJdXClccypcLiI7aTozODA7czoxMDU6ImlmXHMqXChccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RycnBvc1woXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdXD8+WyciXVxzKlwpXHMqXClccyo9PT1ccypmYWxzZSI7aTozODE7czoxNTY6IlwkX1NFUlZFUlxbWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/LCI7aTozODI7czozMDoiZm9wZW5ccypcKFxzKlsnIl1iYWRfbGlzdFwudHh0IjtpOjM4MztzOjQ5OiJAKmZpbGVfZ2V0X2NvbnRlbnRzXChAKmJhc2U2NF9kZWNvZGVcKEAqdXJsZGVjb2RlIjtpOjM4NDtzOjI2OiJcJHtbYS16QS1aMC05X10rP31cKFxzKlwpOyI7aTozODU7czo2MDoic3Vic3RyXChzcHJpbnRmXChbJyJdJW9bJyJdLFxzKmZpbGVwZXJtc1woXCRmaWxlXClcKSxccyotNFwpIjtpOjM4NjtzOjU3OiJcJFthLXpBLVowLTlfXSs/XChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/XCkiO2k6Mzg3O3M6MTY6Indzb1NlY1BhcmFtXHMqXCgiO2k6Mzg4O3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aTozODk7czo2ODoiY29weVwoXHMqWyciXWh0dHA6Ly8uKz9cLnR4dFsnIl1ccyosXHMqWyciXVthLXpBLVowLTlfXSs/XC5waHBbJyJdXCkiO2k6MzkwO3M6Mjg6Ilwkc2V0Y29va1xzKlwpO3NldGNvb2tpZVwoXCQiO2k6MzkxO3M6NDYyOiJAKihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoQCooZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEAqKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6MzkyO3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjM5MztzOjQ3OiIoY2hyXChbXHMwLTlBLVphLXpfXCRcXlwrXC1cKi9dK1wpXHMqXC5ccyopezQsfSI7aTozOTQ7czo0MjoiPVxzKkAqZnNvY2tvcGVuXChccypcJGFyZ3ZcW1xkK1xdXHMqLFxzKjgwIjtpOjM5NTtzOjM1OiJcLlwuL1wuXC4vZW5naW5lL2RhdGEvZGJjb25maWdcLnBocCI7aTozOTY7czo4NToicmVjdXJzZV9jb3B5XChccypcJHNyY1xzKixccypcJGRzdFxzKlwpO1xzKmhlYWRlclwoXHMqWyciXWxvY2F0aW9uOlxzKlwkZHN0WyciXVxzKlwpOyI7aTozOTc7czoxNzoiR2FudGVuZ2Vyc1xzK0NyZXciO2k6Mzk4O3M6MTQ1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHMqW2EtekEtWjAtOV9dKz9ccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSs/IjtpOjM5OTtzOjQxOiJmd3JpdGVcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXTxcP3BocCI7aTo0MDA7czo1NjoiQCpjcmVhdGVfZnVuY3Rpb25cKFxzKlsnIl1bJyJdXHMqLFxzKkAqZmlsZV9nZXRfY29udGVudHMiO2k6NDAxO3M6OTk6IlxdXChbJyJdXCRfWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXSI7aTo0MDI7czozOToiaWZccypcKFxzKmlzc2V0XChccypcJF9HRVRcW1xzKlsnIl1waW5nIjtpOjQwMztzOjMwOiJyZWFkX2ZpbGVcKFxzKlsnIl1kb21haW5zXC50eHQiO2k6NDA0O3M6Mzc6ImV2YWxcKFxzKlsnIl17XHMqXCRbYS16QS1aMC05X10rP1xzKn0iO2k6NDA1O3M6MTEwOiJpZlxzKlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpXHMqe1xzKmNobW9kXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aTo0MDY7czoxMToiPT1bJyJdXClcKTsiO2k6NDA3O3M6NTY6IlwkW2EtekEtWjAtOV9dKz89dXJsZGVjb2RlXChbJyJdLis/WyciXVwpO2lmXChwcmVnX21hdGNoIjtpOjQwODtzOjgzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKmRlY3J5cHRfU09cKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVthLXpBLVowLTlfXSs/WyciXSI7aTo0MDk7czoxMDc6Ij1ccyptYWlsXChccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXSs/XFtcZCtcXVxzKlwpXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xkK1xdIjtpOjQxMDtzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTo0MTE7czo5NToiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKTtccypoZWFkZXIiO2k6NDEyO3M6MTA3OiJAaW5pX3NldFwoWyciXWVycm9yX2xvZ1snIl0sTlVMTFwpO1xzKkBpbmlfc2V0XChbJyJdbG9nX2Vycm9yc1snIl0sMFwpO1xzKmZ1bmN0aW9uXHMrcmVhZF9maWxlXChcJGZpbGVfbmFtZSI7aTo0MTM7czozNzoiXCR0ZXh0XHMqPVxzKmh0dHBfZ2V0XChccypbJyJdaHR0cDovLyI7aTo0MTQ7czoxNDY6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvaHRtbD5bJyJdIjtpOjQxNTtzOjE2MzoiXCNbYS16QS1aMC05X10rP1wjXHMqaWZcKGVtcHR5XChcJFthLXpBLVowLTlfXSs/XClcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl08c2NyaXB0Lis/PC9zY3JpcHQ+WyciXTtccyplY2hvXHMrXCRbYS16QS1aMC05X10rPztccyp9XHMqXCMvW2EtekEtWjAtOV9dKz9cIyI7aTo0MTY7czo2NzoiXC5cJF9SRVFVRVNUXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF1ccyosXHMqdHJ1ZVxzKixccyozMDJcKSI7aTo0MTc7czoxMDc6Ij1ccypjcmVhdGVfZnVuY3Rpb25ccypcKFxzKm51bGxccyosXHMqW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9cKFwpIjtpOjQxODtzOjU0OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwcyo6Ly9cZCtcLlxkK1wuXGQrXC5cZCsiO2k6NDE5O3M6NTc6IkNvbnRlbnQtdHlwZTpccyphcHBsaWNhdGlvbi92bmRcLmFuZHJvaWRcLnBhY2thZ2UtYXJjaGl2ZSI7aTo0MjA7czoyMDoic2x1cnBcfG1zbmJvdFx8dGVvbWEiO2k6NDIxO3M6Mjc6IlwkR0xPQkFMU1xbbmV4dFxdXFtbJyJdbmV4dCI7aTo0MjI7czoxNzA6IjtAKlwkW2EtekEtWjAtOV9dKz9cKChldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjQyMztzOjMwOiJoZWFkZXJcKF9bYS16QS1aMC05X10rP1woXGQrXCkiO2k6NDI0O3M6MTg2OiJpZlxzKlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClccyo9PT1ccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXCkiO2k6NDI1O3M6OTI6IlwuPVxzKmNoclwoXCRbYS16QS1aMC05X10rP1xzKj4+XHMqXChcZCtccypcKlxzKlwoXGQrXHMqLVxzKlwkW2EtekEtWjAtOV9dKz9cKVwpXHMqJlxzKlxkK1wpIjtpOjQyNjtzOjMxOiItPnByZXBhcmVcKFsnIl1TSE9XXHMrREFUQUJBU0VTIjtpOjQyNztzOjIzOiJzb2Nrc19zeXNyZWFkXChcJGNsaWVudCI7aTo0Mjg7czoyNDoiPCVldmFsXChccypSZXF1ZXN0XC5JdGVtIjtpOjQyOTtzOjEwMjoiXCRfUE9TVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZm9wZW5cKFxzKlwkX0dFVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdIjtpOjQzMDtzOjQwOiJ1cmw9WyciXWh0dHA6Ly9zY2FuNHlvdVwubmV0L3JlbW90ZVwucGhwIjtpOjQzMTtzOjYyOiJjYWxsX3VzZXJfZnVuY1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypcJFthLXpBLVowLTlfXSs/XCk7fSI7aTo0MzI7czo3MzoicHJlZ19yZXBsYWNlXChccypbJyJdLy4rPy9lWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0MzM7czoxMDg6Ij1ccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS4rP1snIl1cKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZvcGVuXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlsnIl13WyciXSI7aTo0MzQ7czo2MToiaWZcKFxzKlwkW2EtekEtWjAtOV9dKz9cKVxzKntccypldmFsXChcJFthLXpBLVowLTlfXSs/XCk7XHMqfSI7aTo0MzU7czoxNjk6ImFycmF5X21hcFwoXHMqWyciXShldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl0iO2k6NDM2O3M6MTg1OiI9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZpbGVfcHV0X2NvbnRlbnRzXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKSI7aTo0Mzc7czozOToiW2EtekEtWjAtOV9dKz9cKFxzKlthLXpBLVowLTlfXSs/PVxzKlwpIjtpOjQzODtzOjYyOiI8XD9ccypcJFthLXpBLVowLTlfXSs/PVsnIl0uKz9bJyJdO1xzKmhlYWRlclxzKlwoWyciXUxvY2F0aW9uOiI7aTo0Mzk7czoyNToiPCEtLVwjZXhlY1xzK2NtZFxzKj1ccypcJCI7aTo0NDA7czo4MjoiaWZcKFxzKnN0cmlwb3NcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXWFuZHJvaWRbJyJdXHMqXClccyohPT1ccypmYWxzZVwpXHMqeyI7aTo0NDE7czo5MToiXC49XHMqWyciXTxkaXZccytzdHlsZT1bJyJdZGlzcGxheTpub25lO1snIl0+WyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXTwvZGl2PiI7aTo0NDI7czoxMTg6Ij1maWxlX2V4aXN0c1woXCRbYS16QS1aMC05X10rP1wpXD9AZmlsZW10aW1lXChcJFthLXpBLVowLTlfXSs/XCk6XCRbYS16QS1aMC05X10rPztAZmlsZV9wdXRfY29udGVudHNcKFwkW2EtekEtWjAtOV9dKz8iO2k6NDQzO3M6OTM6IlwkW2EtekEtWjAtOV9dKz9ccypcW1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlthLXpBLVowLTlfXSs/XHMqXF1ccypcKSI7aTo0NDQ7czo5ODoiXCRbYS16QS1aMC05X10rPyxbJyJdc2x1cnBbJyJdXClccyohPT1ccypmYWxzZVxzKlx8XHxccypzdHJwb3NcKFxzKlwkW2EtekEtWjAtOV9dKz8sWyciXXNlYXJjaFsnIl0iO2k6NDQ1O3M6NjY6IlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9cKVxzKlwpOyI7aTo0NDY7czoxNzoiY2xhc3NccytNQ3VybFxzKnsiO2k6NDQ3O3M6NTY6IkBpbmlfc2V0XChbJyJdZGlzcGxheV9lcnJvcnNbJyJdLDBcKTtccypAZXJyb3JfcmVwb3J0aW5nIjtpOjQ0ODtzOjY5OiJpZlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkZmlsZXBhdGhccypcKVxzKlwpXHMqe1xzKmVjaG9ccytbJyJddXBsb2FkZWQiO2k6NDQ5O3M6MzA6InJldHVyblxzK1JDNDo6RW5jcnlwdFwoXCRhLFwkYiI7aTo0NTA7czozMjoiZnVuY3Rpb25ccytnZXRIVFRQUGFnZVwoXHMqXCR1cmwiO2k6NDUxO3M6MjE6Ij1ccypyZXF1ZXN0XChccypjaHJcKCI7aTo0NTI7czo1NjoiO1xzKmFycmF5X2ZpbHRlclwoXCRbYS16QS1aMC05X10rP1xzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6NDUzO3M6MjE4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXShldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0NTQ7czoyMzE6ImNhbGxfdXNlcl9mdW5jX2FycmF5XChccypbJyJdKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXVxzKixccyphcnJheVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0NTU7czo4NzoiaWYgXCghKlwkX1NFUlZFUlxbWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cXVxzKk9SXHMqXChzdWJzdHJcKFwkX1NFUlZFUlxbWyciXVJFTU9URV9BRERSIjtpOjQ1NjtzOjUzOiJyZWxwYXRodG9hYnNwYXRoXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0NTc7czo2ODoiXCRkYXRhXFtbJyJdY2NfZXhwX21vbnRoWyciXVxdXHMqLFxzKnN1YnN0clwoXCRkYXRhXFtbJyJdY2NfZXhwX3llYXIiO2k6NDU4O3M6NDE6IlwkW2EtekEtWjAtOV9dKz9ccyooXFsuezEsNDB9XF0pezEsfVxzKlwoIjtpOjQ1OTtzOjMzOiJjYWxsX3VzZXJfZnVuY1woXHMqQCp1bmhleFwoXHMqMHgiO2k6NDYwO3M6Mjk6IlwuXC46OlxbXHMqcGhwcm94eVxzKlxdOjpcLlwuIjtpOjQ2MTtzOjQ0OiJbJyJdXHMqXC5ccypjaHJcKFxzKlxkKy5cZCtccypcKVxzKlwuXHMqWyciXSI7aTo0NjI7czozMjoicHJlZ19yZXBsYWNlLio/L2VbJyJdXHMqLFxzKlsnIl0iO2k6NDYzO3M6OTA6IlwkW2EtekEtWjAtOV9dKz9cKFwkW2EtekEtWjAtOV9dKz9cKFwkW2EtekEtWjAtOV9dKz9cKFwkW2EtekEtWjAtOV9dKz9cKFwkW2EtekEtWjAtOV9dKz9cKSI7aTo0NjQ7czoyMzoifWV2YWxcKGJ6ZGVjb21wcmVzc1woXCQiO2k6NDY1O3M6NTg6Ii91c3IvbG9jYWwvcHNhL2FwYWNoZS9iaW4vaHR0cGRccystREZST05UUEFHRVxzKy1ESEFWRV9TU0wiO2k6NDY2O3M6NTc6Imljb252XChiYXNlNjRfZGVjb2RlXChbJyJdLis/WyciXVwpXHMqLFxzKmJhc2U2NF9kZWNvZGVcKCI7aTo0Njc7czozMDoiXCRbYS16QS1aMC05X10rP1woWyciXS4uZVsnIl0sIjtpOjQ2ODtzOjc0OiJAXCRbYS16QS1aMC05X10rPyYmQFwkW2EtekEtWjAtOV9dKz9cKFwkW2EtekEtWjAtOV9dKz8sXCRbYS16QS1aMC05X10rP1wpOyI7aTo0Njk7czozMzoiPGJyPlsnIl1cLnBocF91bmFtZVwoXClcLlsnIl08YnI+IjtpOjQ3MDtzOjY4OiJcKTtAXCRbYS16QS1aMC05X10rP1xbY2hyXChcZCtcKVxdXChcJFthLXpBLVowLTlfXSs/XFtjaHJcKFxkK1wpXF1cKCI7aTo0NzE7czoxMDc6Iihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxNDM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7aToxMjE7czozNjoiXCRlbGVtZW50XFtiXF1cKDBcKSx0aGlzXC50cmFuc2l0aW9uIjtpOjEyMjtzOjMxOiJcJG1ldGhvZFwoXCRyZWxhdGlvblxbJ2l0ZW1OYW1lIjtpOjEyMztzOjM2OiJcJHZlcnNpb25cWzFcXVwpO31lbHNlaWZcKHByZWdfbWF0Y2giO2k6MTI0O3M6MzQ6IlwkY29tbWFuZFwoXCRjb21tYW5kc1xbXCRpZGVudGlmaWUiO2k6MTI1O3M6NDI6IlwkY2FsbGFibGVcKFwkcmF3XFsnY2FsbGJhY2snXF1cKFwkY1wpLFwkYyI7aToxMjY7czo0MjoiXCRlbFxbdmFsXF1cKFwpXCkgXCRlbFxbdmFsXF1cKGRhdGFcW3N0YXRlIjtpOjEyNztzOjQ3OiJcJGVsZW1lbnRcW3RcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb25cKCJhZGRDbGFzcyI7aToxMjg7czozMToiXCk7XCNtaXMnLCcgJyxcJGlucHV0XCk7XCRpbnB1dCI7aToxMjk7czozMToia2lsbCAtOSAnXC5cJHBpZFwpO1wkdGhpcy0+Y2xvcyI7aToxMzA7czozMjoiY2FsbF91c2VyX2Z1bmNcKFwkZmlsdGVyLFwkdmFsdWUiO2k6MTMxO3M6MzM6ImNhbGxfdXNlcl9mdW5jXChcJG9wdGlvbnMsXCRlcnJvciI7aToxMzI7czozNjoiY2FsbF91c2VyX2Z1bmNcKFwkbGlzdGVuZXIsXCRldmVudFwpIjtpOjEzMztzOjY2OiJpZlwoc3RyaXBvc1woXCR1c2VyQWdlbnQsJ0FuZHJvaWQnXCkgIT09ZmFsc2VcKXtcJHRoaXMtPm1vYmlsZT10cnUiO2k6MTM0O3M6NTM6ImJhc2U2NF9kZWNvZGVcKHVybGRlY29kZVwoXCRmaWxlXClcKT09J2luZGV4XC5waHAnXCl7IjtpOjEzNTtzOjYwOiJ1cmxkZWNvZGVcKGJhc2U2NF9kZWNvZGVcKFwkaW5wdXRcKVwpO1wkZXhwbG9kZUFycmF5PWV4cGxvZGUiO2k6MTM2O3M6Mzc6ImJhc2U2NF9kZWNvZGVcKHVybGRlY29kZVwoXCRyZXR1cm5VcmkiO2k6MTM3O3M6NDc6InVybGRlY29kZVwodXJsZGVjb2RlXChzdHJpcGNzbGFzaGVzXChcJHNlZ21lbnRzIjtpOjEzODtzOjUzOiJtYWlsXChcJHRvLFwkc3ViamVjdCxcJGJvZHksXCRoZWFkZXJcKTt9ZWxzZXtcJHJlc3VsdCI7aToxMzk7czozODoiPWluaV9nZXRcKCdkaXNhYmxlX2Z1bmN0aW9ucydcKTtcJHRoaXMiO2k6MTQwO3M6NDI6Ij1pbmlfZ2V0XCgnZGlzYWJsZV9mdW5jdGlvbnMnXCk7aWZcKCFlbXB0eSI7aToxNDE7czozOToiZXZhbFwoXCRwaHBDb2RlXCk7fWVsc2V7Y2xhc3NfYWxpYXNcKFwkIjtpOjE0MjtzOjQ4OiJldmFsXChcJHN0clwpO31wdWJsaWMgZnVuY3Rpb24gY291bnRNZW51Q2hpbGRyZW4iO30="));
$g_AdwareSig = unserialize(base64_decode("YToxNDM6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6Mzc6ImNsYXNzXHMrQ01fY2xpZW50XHMrZXh0ZW5kc1xzKkNNX2Jhc2UiO2k6MTY7czoxOToibmV3XHMrQ01fY2xpZW50XChcKSI7aToxNztzOjE2OiJ0bF9saW5rc19kYl9maWxlIjtpOjE4O3M6MjA6ImNsYXNzXHMrbG1wX2Jhc2Vccyt7IjtpOjE5O3M6MTU6IlRydXN0bGlua0NsaWVudCI7aToyMDtzOjEzOiItPlxzKlNMQ2xpZW50IjtpOjIxO3M6MTY2OiJpc3NldFxzKlwoKlxzKlwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF1ccypcKVxzKiYmXHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXVxzKj09XHMqWyciXXswLDF9TE1QX1JvYm90IjtpOjIyO3M6NDM6IlwkbGlua3MtPlxzKnJldHVybl9saW5rc1xzKlwoKlxzKlwkbGliX3BhdGgiO2k6MjM7czo0NDoiXCRsaW5rc19jbGFzc1xzKj1ccypuZXdccytHZXRfbGlua3NccypcKCpccyoiO2k6MjQ7czo1MjoiWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfVwuWyciXXswLDF9XHMqXCkqXHMqO1xzKlw/PiI7aToyNTtzOjc6Imxldml0cmEiO2k6MjY7czoxMDoiZGFwb3hldGluZSI7aToyNztzOjY6InZpYWdyYSI7aToyODtzOjY6ImNpYWxpcyI7aToyOTtzOjg6InByb3ZpZ2lsIjtpOjMwO3M6MTk6ImNsYXNzXHMrVFdlZmZDbGllbnQiO2k6MzE7czoxODoibmV3XHMrU0xDbGllbnRcKFwpIjtpOjMyO3M6MjQ6Il9fbGlua2ZlZWRfYmVmb3JlX3RleHRfXyI7aTozMztzOjE2OiJfX3Rlc3RfdGxfbGlua19fIjtpOjM0O3M6MTg6InM6MTE6ImxtcF9jaGFyc2V0IiI7aTozNTtzOjIwOiI9XHMrbmV3XHMrTUxDbGllbnRcKCI7aTozNjtzOjQ3OiJlbHNlXHMraWZccypcKFxzKlwoXHMqc3RycG9zXChccypcJGxpbmtzX2lwXHMqLCI7aTozNztzOjMzOiJmdW5jdGlvblxzK3Bvd2VyX2xpbmtzX2Jsb2NrX3ZpZXciO2k6Mzg7czoyMDoiY2xhc3NccytJTkdPVFNDbGllbnQiO2k6Mzk7czoxMDoiX19MSU5LX188YSI7aTo0MDtzOjIxOiJjbGFzc1xzK0xpbmtwYWRfc3RhcnQiO2k6NDE7czoxMzoiY2xhc3NccytUTlhfbCI7aTo0MjtzOjIyOiJjbGFzc1xzK01FR0FJTkRFWF9iYXNlIjtpOjQzO3M6MTU6Il9fTElOS19fX19FTkRfXyI7aTo0NDtzOjIyOiJuZXdccytUUlVTVExJTktfY2xpZW50IjtpOjQ1O3M6NzU6InJcLnBocFw/aWQ9W2EtekEtWjAtOV9dKz8mcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX1ccytcW1I9MzAyLExcXSI7aTo0NjtzOjM5OiJVc2VyLWFnZW50OlxzKkdvb2dsZWJvdFxzKkRpc2FsbG93OlxzKi8iO2k6NDc7czoxODoibmV3XHMrTExNX2NsaWVudFwoIjtpOjQ4O3M6MzY6IiZyZWZlcmVyPSV7SFRUUF9IT1NUfS8le1JFUVVFU1RfVVJJfSI7aTo0OTtzOjI5OiJcLnBocFw/aWQ9XCQxJiV7UVVFUllfU1RSSU5HfSI7aTo1MDtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6NTE7czoyMzoiQWRkSGFuZGxlclxzK3BocC1zY3JpcHQiO2k6NTI7czoyMzoiQWRkSGFuZGxlclxzK2NnaS1zY3JpcHQiO2k6NTM7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aTo1NDtzOjEyOiJwaHBpbmZvXChcKTsiO2k6NTU7czoxNToiXChtc2llXHxvcGVyYVwpIjtpOjU2O3M6MjI6IjxoMT5Mb2FkaW5nXC5cLlwuPC9oMT4iO2k6NTc7czoyOToiRXJyb3JEb2N1bWVudFxzKzUwMFxzK2h0dHA6Ly8iO2k6NTg7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwMFxzK2h0dHA6Ly8iO2k6NTk7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly8iO2k6NjA7czo0OToiUmV3cml0ZUNvbmRccyole0hUVFBfVVNFUl9BR0VOVH1ccypcLlwqbmRyb2lkXC5cKiI7aTo2MTtzOjEwMToiPHNjcmlwdFxzK2xhbmd1YWdlPVsnIl17MCwxfUphdmFTY3JpcHRbJyJdezAsMX0+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly8iO2k6NjI7czo5OToiY2hyXHMqXChccyoxMDFccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMThccypcKVxzKlwuXHMqY2hyXHMqXChccyo5N1xzKlwpXHMqXC5ccypjaHJccypcKFxzKjEwOFxzKlwpIjtpOjYzO3M6MzA6ImN1cmxcLmhheHhcLnNlL3JmYy9jb29raWVfc3BlYyI7aTo2NDtzOjE4OiJKb29tbGFfYnJ1dGVfRm9yY2UiO2k6NjU7czozNDoiUmV3cml0ZUNvbmRccyole0hUVFA6eC13YXAtcHJvZmlsZSI7aTo2NjtzOjQyOiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LW9wZXJhbWluaS1waG9uZS11YX0iO2k6Njc7czo2NjoiUmV3cml0ZUNvbmRccyole0hUVFA6QWNjZXB0LUxhbmd1YWdlfVxzKlwocnVcfHJ1LXJ1XHx1a1wpXHMqXFtOQ1xdIjtpOjY4O3M6MjY6InNsZXNoXCtzbGVzaFwrZG9tZW5cK3BvaW50IjtpOjY5O3M6MTc6InRlbGVmb25uYXlhLWJhemEtIjtpOjcwO3M6MTg6ImljcS1kbHlhLXRlbGVmb25hLSI7aTo3MTtzOjI0OiJwYWdlX2ZpbGVzL3N0eWxlMDAwXC5jc3MiO2k6NzI7czoyMDoic3ByYXZvY2huaWstbm9tZXJvdi0iO2k6NzM7czoxNzoiS2F6YW4vaW5kZXhcLmh0bWwiO2k6NzQ7czo1MDoiR29vZ2xlYm90WyciXXswLDF9XHMqXClcKXtlY2hvXHMrZmlsZV9nZXRfY29udGVudHMiO2k6NzU7czoyNjoiaW5kZXhcLnBocFw/aWQ9XCQxJiV7UVVFUlkiO2k6NzY7czoyMDoiVm9sZ29ncmFkaW5kZXhcLmh0bWwiO2k6Nzc7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6Nzg7czoxOToiLWtseWNoLWstaWdyZVwuaHRtbCI7aTo3OTtzOjE5OiJsbXBfY2xpZW50XChzdHJjb2RlIjtpOjgwO3M6MTc6Ii9cP2RvPWthay11ZGFsaXQtIjtpOjgxO3M6MTQ6Ii9cP2RvPW9zaGlia2EtIjtpOjgyO3M6MTk6Ii9pbnN0cnVrdHNpeWEtZGx5YS0iO2k6ODM7czo0MzoiY29udGVudD0iXGQrO1VSTD1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tLyI7aTo4NDtzOjU5OiIlPCEtLVxcc1wqXCRtYXJrZXJcXHNcKi0tPlwuXCtcPzwhLS1cXHNcKi9cJG1hcmtlclxcc1wqLS0+JSI7aTo4NTtzOjc5OiJSZXdyaXRlUnVsZVxzK1xeXChcLlwqXCksXChcLlwqXClcJFxzK1wkMlwucGhwXD9yZXdyaXRlX3BhcmFtcz1cJDEmcGFnZV91cmw9XCQyIjtpOjg2O3M6NDI6IlJld3JpdGVSdWxlXHMqXChcLlwrXClccyppbmRleFwucGhwXD9zPVwkMCI7aTo4NztzOjE4OiJSZWRpcmVjdFxzKmh0dHA6Ly8iO2k6ODg7czo0NToiUmV3cml0ZVJ1bGVccypcXlwoXC5cKlwpXHMqaW5kZXhcLnBocFw/aWQ9XCQxIjtpOjg5O3M6NDQ6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP209XCQxIjtpOjkwO3M6MTk4OiJcYihwZXJjb2NldHxhZGRlcmFsbHx2aWFncmF8Y2lhbGlzfGxldml0cmF8a2F1ZmVufGFtYmllbnxibHVlXHMrcGlsbHxjb2NhaW5lfG1hcmlqdWFuYXxsaXBpdG9yfHBoZW50ZXJtaW58cHJvW3N6XWFjfHNhbmR5YXVlcnx0cmFtYWRvbHx0cm95aGFtYnl1bHRyYW18dW5pY2F1Y2F8dmFsaXVtfHZpY29kaW58eGFuYXh8eXB4YWllbylccytvbmxpbmUiO2k6OTE7czo1MDoiUmV3cml0ZVJ1bGVccypcLlwqL1wuXCpccypbYS16QS1aMC05X10rP1wucGhwXD9cJDAiO2k6OTI7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjkzO3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk0O3M6NTM6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/W2EtekEtWjAtOV9dKz89IjtpOjk1O3M6MzI6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwOi8vdGRzIjtpOjk2O3M6NTE6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVwkXHMraHR0cDovL1xkK1wuXGQrXC5cZCtcLiI7aTo5NztzOjY3OiI8IS0tY2hlY2s6WyciXVxzKlwuXHMqbWQ1XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjk4O3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aTo5OTtzOjM2OiJTZXRIYW5kbGVyXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6MTAwO3M6NDI6IiV7SFRUUF9VU0VSX0FHRU5UfVxzKyF3aW5kb3dzLW1lZGlhLXBsYXllciI7aToxMDE7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDI7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDM7czo1ODoiXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXSI7aToxMDQ7czo4MjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfVlhbmRleEJvdCI7aToxMDU7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfXlhbmRleCI7aToxMDY7czo3NjoiXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfUkVGRVJFUlsnIl17MCwxfVxzKlxdXHMqLFxzKlsnIl17MCwxfWdvb2dsZSI7aToxMDc7czo4OiIva3J5YWtpLyI7aToxMDg7czoxMDoiXC5waHBcP1wkMCI7aToxMDk7czo3MToicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpXHMqLFxzKlsnIl1Hb29nbGVib3QiO2k6MTEwO3M6ODA6ImluZGV4XC5waHBcP21haW5fcGFnZT1wcm9kdWN0X2luZm8mcHJvZHVjdHNfaWQ9WyciXVxzKlwuXHMqc3RyX3JlcGxhY2VcKFsnIl1saXN0IjtpOjExMTtzOjMxOiJmc29ja29wZW5cKFxzKlsnIl1zaGFkeWtpdFwuY29tIjtpOjExMjtzOjEwOiJlb2ppZXVcLmNuIjtpOjExMztzOjIyOiI+XHMqPC9pZnJhbWU+XHMqPFw/cGhwIjtpOjExNDtzOjgxOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9cmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKnVybD08XD9waHAiO2k6MTE1O3M6ODI6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1SZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MTE2O3M6Njc6IlwkZmxccyo9XHMqIjxtZXRhIGh0dHAtZXF1aXY9XFwiUmVmcmVzaFxcIlxzK2NvbnRlbnQ9XFwiXGQrO1xzKlVSTD0iO2k6MTE3O3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqeWFuZGV4IjtpOjExODtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKmdvb2dsZSI7aToxMTk7czo1NzoiT3B0aW9uc1xzK0ZvbGxvd1N5bUxpbmtzXHMrTXVsdGlWaWV3c1xzK0luZGV4ZXNccytFeGVjQ0dJIjtpOjEyMDtzOjI4OiJnb29nbGVcfHlhbmRleFx8Ym90XHxyYW1ibGVyIjtpOjEyMTtzOjQxOiJjb250ZW50PVsnIl17MCwxfTE7VVJMPWNnaS1iaW5cLmh0bWxcP2NtZCI7aToxMjI7czoxMjoiYW5kZXhcfG9vZ2xlIjtpOjEyMztzOjQ0OiJoZWFkZXJcKFxzKlsnIl1SZWZyZXNoOlxzKlxkKztccypVUkw9aHR0cDovLyI7aToxMjQ7czo0NToiTW96aWxsYS81XC4wXHMqXChjb21wYXRpYmxlO1xzKkdvb2dsZWJvdC8yXC4xIjtpOjEyNTtzOjUwOiJodHRwOi8vd3d3XC5iaW5nXC5jb20vc2VhcmNoXD9xPVwkcXVlcnkmcHE9XCRxdWVyeSI7aToxMjY7czo0MzoiaHR0cDovL2dvXC5tYWlsXC5ydS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeSI7aToxMjc7czo2MzoiaHR0cDovL3d3d1wuZ29vZ2xlXC5jb20vc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnlcLlsnIl0maGw9XCRsYW5nIjtpOjEyODtzOjM2OiJTZXRIYW5kbGVyXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6MTI5O3M6NDk6ImlmXChzdHJpcG9zXChcJHVhLFsnIl1hbmRyb2lkWyciXVwpXHMqIT09XHMqZmFsc2UiO2k6MTMwO3M6MTUyOiIoc2V4eVxzK2xlc2JpYW5zfGN1bVxzK3ZpZGVvfHNleFxzK3ZpZGVvfEFuYWxccytGdWNrfHRlZW5ccytzZXh8ZnVja1xzK3ZpZGVvfEJlYWNoXHMrTnVkZXx3b21hblxzK3B1c3N5fHNleFxzK3Bob3RvfG5ha2VkXHMrdGVlbnx4eHhccyt2aWRlb3x0ZWVuXHMrcGljKSI7aToxMzE7czo1NjoiaHR0cC1lcXVpdj1bJyJdQ29udGVudC1MYW5ndWFnZVsnIl1ccytjb250ZW50PVsnIl1qYVsnIl0iO2k6MTMyO3M6NTY6Imh0dHAtZXF1aXY9WyciXUNvbnRlbnQtTGFuZ3VhZ2VbJyJdXHMrY29udGVudD1bJyJdY2hbJyJdIjtpOjEzMztzOjExOiJLQVBQVVNUT0JPVCI7aToxMzQ7czozODoiY2xhc3NccytsVHJhbnNtaXRlcntccyp2YXJccypcJHZlcnNpb24iO2k6MTM1O3M6Mzg6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXS90bXAvc3Nlc3NfIjtpOjEzNjtzOjkyOiJmaWxlX2dldF9jb250ZW50c1woYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rP1wpXC5bJyJdXD9bJyJdXC5odHRwX2J1aWxkX3F1ZXJ5XChcJF9HRVRcKSI7aToxMzc7czo1MDoiaW5pX3NldFwoWyciXXswLDF9dXNlcl9hZ2VudFsnIl1ccyosXHMqWyciXUpTTElOS1MiO2k6MTM4O3M6NjM6IlwkZGItPnF1ZXJ5XChbJyJdU0VMRUNUIFwqIEZST00gYXJ0aWNsZSBXSEVSRSB1cmw9WyciXVwkcmVxdWVzdCI7aToxMzk7czoyNDoiPGh0bWxccytsYW5nPVsnIl1qYVsnIl0+IjtpOjE0MDtzOjM3OiJ4bWw6bGFuZz1bJyJdamFbJyJdXHMrbGFuZz1bJyJdamFbJyJdIjtpOjE0MTtzOjE2OiJsYW5nPVsnIl1qYVsnIl0+IjtpOjE0MjtzOjMzOiJzdHJwb3NcKFwkaW0sWyciXVxbL1VQRF9DT05URU5UXF0iO30="));
$g_PhishingSig = unserialize(base64_decode("YTo4ODp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6NTk6IkxvY2F0aW9uOlxzKmh0dHBzOi8vc2VjdXJpdHlcLmdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5IjtpOjcyO3M6NjU6IlwkaXBccyo9XHMqZ2V0ZW52XChccypbJyJdUkVNT1RFX0FERFJbJyJdXHMqXCk7XHMqXCRtZXNzYWdlXHMqXC49IjtpOjczO3M6MTc6ImxvZ2luXC5lYzIxXC5jb20vIjtpOjc0O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTo3NTtzOjM0OiJcJGFkZGRhdGU9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjc2O3M6MzY6IlwkZGF0YW1hc2lpPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NztzOjI3OiJodHRwczovL2FwcGxlaWRcLmFwcGxlXC5jb20iO2k6Nzg7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjgxO3M6NDA6ImJhc2VccytocmVmPVsnIl1odHRwczovL2xvZ2luXC5saXZlXC5jb20iO2k6ODI7czoyNDoiPHRpdGxlPkhvdG1haWxccytBY2NvdW50IjtpOjgzO3M6NDE6IjwhLS1ccytzYXZlZFxzK2Zyb21ccyt1cmw9XChcZCtcKWh0dHBzOi8vIjtpOjg0O3M6MjA6IkJhbmtccytvZlxzK01vbnRyZWFsIjtpOjg1O3M6MjE6InNlY3VyZVwudGFuZ2VyaW5lXC5jYSI7aTo4NjtzOjIyOiJibW9cLmNvbS9vbmxpbmViYW5raW5nIjtpOjg3O3M6NDE6InBtX2ZwPXZlcnNpb24mc3RhdGU9MSZzYXZlRkJDPSZGQkNfTnVtYmVyIjt9"));
$g_JSVirSig = unserialize(base64_decode("YToxMjk6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czoyMjoiXC5wcm90b3R5cGVcLmF9Y2F0Y2hcKCI7aTo1O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6NjtzOjM0OiJpZlwoUmVmXC5pbmRleE9mXCgnXC5nb29nbGVcLidcKSE9IjtpOjc7czo4NjoiaW5kZXhPZlx8aWZcfHJjXHxsZW5ndGhcfG1zblx8eWFob29cfHJlZmVycmVyXHxhbHRhdmlzdGFcfG9nb1x8YmlcfGhwXHx2YXJcfGFvbFx8cXVlcnkiO2k6ODtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6OTtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjEwO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTE7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTI7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxMztzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNDtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE1O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNjtzOjc6IlxceDY1QXQiO2k6MTc7czo5OiJcXHg2MXJDb2QiO2k6MTg7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToxOTtzOjExOiI9ImV2IlwrImFsIiI7aToyMDtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjE7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIyO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjIzO3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI0O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI1O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MjY7czo5OiJ2YXJccytfMHgiO2k6Mjc7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjg7czo3OiJwaW5nbm93IjtpOjI5O3M6ODoic2VyY2hib3QiO2k6MzA7czoxMDoia20wYWU5Z3I2bSI7aTozMTtzOjY6ImMzMjg0ZCI7aTozMjtzOjg6IlxceDY4YXJDIjtpOjMzO3M6ODoiXFx4NmRDaGEiO2k6MzQ7czo3OiJcXHg2ZmRlIjtpOjM1O3M6NzoiXFx4NmZkZSI7aTozNjtzOjg6IlxceDQzb2RlIjtpOjM3O3M6NzoiXFx4NzJvbSI7aTozODtzOjc6IlxceDQzaGEiO2k6Mzk7czo3OiJcXHg3MkNvIjtpOjQwO3M6ODoiXFx4NDNvZGUiO2k6NDE7czoxMDoiXC5keW5kbnNcLiI7aTo0MjtzOjk6IlwuZHluZG5zLSI7aTo0MztzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ0O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0NTtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDY7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDc7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDg7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjQ5O3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTA7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjUxO3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MjtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjUzO3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NDtzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU1O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1NjtzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo1NztzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo1ODtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjU5O3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYwO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjYxO3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjI7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjM7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NDtzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2NTtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2NjtzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo2NztzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjY4O3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjY5O3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MDtzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3MTtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjcyO3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3MztzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6NzQ7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3NTtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3NjtzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjc3O3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo3ODtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6Nzk7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MDtzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjgxO3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjgyO3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4MztzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg0O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg1O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg2O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo4NztzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo4ODtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo4OTtzOjMyOiJ3aW5kb3dcLm9uZXJyb3Jccyo9XHMqa2lsbGVycm9ycyI7aTo5MDtzOjEwNToiY2hlY2tfdXNlcl9hZ2VudD1cW1xzKlsnIl17MCwxfUx1bmFzY2FwZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1pUGhvbmVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9TWFjaW50b3NoIjtpOjkxO3M6MTUzOiJkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxbJyJdezAsMX1cK1snIl17MCwxfWlbJyJdezAsMX1cK1snIl17MCwxfWZbJyJdezAsMX1cK1snIl17MCwxfXJbJyJdezAsMX1cK1snIl17MCwxfWFbJyJdezAsMX1cK1snIl17MCwxfW1bJyJdezAsMX1cK1snIl17MCwxfWUiO2k6OTI7czo0ODoic3RyaXBvc1wobmF2aWdhdG9yXC51c2VyQWdlbnRccyosXHMqbGlzdF9kYXRhXFtpIjtpOjkzO3M6MjY6ImlmXHMqXCghc2VlX3VzZXJfYWdlbnRcKFwpIjtpOjk0O3M6NDY6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypbJyJdWyciXTt9aWZcKCFnZXRDb29raWUiO2k6OTU7czo3MDoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWZ0cDovLyI7aTo5NjtzOjQ4OiJpZlxzKlwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoWyciXXswLDF9c2FicmkiO2k6OTc7czoxMjI6IndpbmRvd1wubG9jYXRpb249Yn1ccypcKVwoXHMqbmF2aWdhdG9yXC51c2VyQWdlbnRccypcfFx8XHMqbmF2aWdhdG9yXC52ZW5kb3JccypcfFx8XHMqd2luZG93XC5vcGVyYVxzKixccypbJyJdezAsMX1odHRwOi8vIjtpOjk4O3M6MTE2OiJcKTtccyppZlwoXHMqW2EtekEtWjAtOV9dKz9cLnRlc3RcKFxzKmRvY3VtZW50XC5yZWZlcnJlclxzKlwpXHMqJiZccypbYS16QS1aMC05X10rP1wpXHMqe1xzKmRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo5OTtzOjUzOiJpZlwoL0FuZHJvaWQvaVxbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF1cKG5hdmlnYXRvciI7aToxMDA7czo2OToiZnVuY3Rpb25cKGFcKXtpZlwoYSYmWyciXWRhdGFbJyJdaW5cZCthJiZhXC5kYXRhXC5hXGQrJiZhXC5kYXRhXC5hXGQrIjtpOjEwMTtzOjU4OiJzXChvXCl9XCl9LGY9ZnVuY3Rpb25cKFwpe3ZhciB0LGk9SlNPTlwuc3RyaW5naWZ5XChlXCk7b1woIjtpOjEwMjtzOjE3OiJzZXhmcm9taW5kaWFcLmNvbSI7aToxMDM7czoxMToiZmlsZWt4XC5jb20iO2k6MTA0O3M6MTM6InN0dW1tYW5uXC5uZXQiO2k6MTA1O3M6MTQ6InRvcGxheWdhbWVcLnJ1IjtpOjEwNjtzOjE0OiJodHRwOi8veHp4XC5wbSI7aToxMDc7czoxODoiXC5ob3B0b1wubWUvanF1ZXJ5IjtpOjEwODtzOjExOiJtb2JpLWdvXC5pbiI7aToxMDk7czoxODoiYmFua29mYW1lcmljYVwuY29tIjtpOjExMDtzOjE2OiJteWZpbGVzdG9yZVwuY29tIjtpOjExMTtzOjE3OiJmaWxlc3RvcmU3MlwuaW5mbyI7aToxMTI7czoxNjoiZmlsZTJzdG9yZVwuaW5mbyI7aToxMTM7czoxNToidXJsMnNob3J0XC5pbmZvIjtpOjExNDtzOjE4OiJmaWxlc3RvcmUxMjNcLmluZm8iO2k6MTE1O3M6MTI6InVybDEyM1wuaW5mbyI7aToxMTY7czoxNDoiZG9sbGFyYWRlXC5jb20iO2k6MTE3O3M6MTE6InNlY2NsaWtcLnJ1IjtpOjExODtzOjExOiJtb2J5LWFhXC5ydSI7aToxMTk7czoxMjoic2VydmxvYWRcLnJ1IjtpOjEyMDtzOjc6Im5ublwucG0iO2k6MTIxO3M6Nzoibm5tXC5wbSI7aToxMjI7czoxNjoibW9iLXJlZGlyZWN0XC5ydSI7aToxMjM7czoxNjoid2ViLXJlZGlyZWN0XC5ydSI7aToxMjQ7czoxNjoidG9wLXdlYnBpbGxcLmNvbSI7aToxMjU7czoxOToiZ29vZHBpbGxzZXJ2aWNlXC5ydSI7aToxMjY7czoxNDoieW91dHVpYmVzXC5jb20iO2k6MTI3O3M6MTQ6InVuc2NyZXdpbmdcLnJ1IjtpOjEyODtzOjI2OiJsb2FkbWVcLmNoaWNrZW5raWxsZXJcLmNvbSI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTo2Njp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjg3OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs/PXVuZXNjYXBlXChccypbYS16QS1aMC05X10rP1xzKlwpO1xzKnZhclxzK0V4cERhdGUiO2k6MTU7czo3NDoiPCEtLVxzKlthLXpBLVowLTlfXSs/XHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqW2EtekEtWjAtOV9dKz9ccyotLT4iO2k6MTY7czozNToiZXZhbFxzKlwoXHMqZGVjb2RlVVJJQ29tcG9uZW50XHMqXCgiO2k6MTc7czo3Mjoid2hpbGVcKFxzKmY8XGQrXHMqXClkb2N1bWVudFxbXHMqW2EtekEtWjAtOV9dKz9cK1snIl10ZVsnIl1ccypcXVwoU3RyaW5nIjtpOjE4O3M6ODE6InNldENvb2tpZVwoXHMqXzB4W2EtekEtWjAtOV9dKz9ccyosXHMqXzB4W2EtekEtWjAtOV9dKz9ccyosXHMqXzB4W2EtekEtWjAtOV9dKz9cKSI7aToxOTtzOjI5OiJcXVwoXHMqdlwrXCtccypcKS0xXHMqXClccypcKSI7aToyMDtzOjQ0OiJkb2N1bWVudFxbXHMqXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjEyNzoiaVxbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF1cKFthLXpBLVowLTlfXSs/XFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXVwoXGQrLFxkK1wpXClcKXt3aW5kb3dcW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdPWxvYyI7aToyNTtzOjQ5OiJkb2N1bWVudFwud3JpdGVcKFxzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseVwoIjtpOjI2O3M6NTE6IlsnIl1cXVwoW2EtekEtWjAtOV9dKz9cK1wrXCktXGQrXCl9XChGdW5jdGlvblwoWyciXSI7aToyNztzOjY1OiI7d2hpbGVcKFthLXpBLVowLTlfXSs/PFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aToyODtzOjEwOToiaWZccypcKFthLXpBLVowLTlfXSs/XC5pbmRleE9mXChkb2N1bWVudFwucmVmZXJyZXJcLnNwbGl0XChbJyJdL1snIl1cKVxbWyciXTJbJyJdXF1cKVxzKiE9XHMqWyciXS0xWyciXVwpXHMqeyI7aToyOTtzOjExNDoiZG9jdW1lbnRcLndyaXRlXChccypbJyJdPHNjcmlwdFxzK3R5cGU9WyciXXRleHQvamF2YXNjcmlwdFsnIl1ccypzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjMwO3M6Mzg6InByZWdfbWF0Y2hcKFsnIl1AXCh5YW5kZXhcfGdvb2dsZVx8Ym90IjtpOjMxO3M6MTM3OiJmYWxzZX07W2EtekEtWjAtOV9dKz89W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKVx8W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKTtbYS16QS1aMC05X10rP1x8PVthLXpBLVowLTlfXSs/OyI7aTozMjtzOjY1OiJTdHJpbmdcLmZyb21DaGFyQ29kZVwoXHMqW2EtekEtWjAtOV9dKz9cLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NTg6IlxbWyciXWNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rP1xzKlwrXHMqWyciXUF0WyciXVxdXCgiO2k6MzU7czo0OToic3JjPVsnIl0vL1snIl1ccypcK1xzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseSI7aTozNjtzOjU2OiJTdHJpbmdcW1xzKlsnIl1mcm9tQ2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKCI7aTozNztzOjI4OiIuPVsnIl0uOi8vLlwuLlwuLlwuLi8uXC4uXC4uIjtpOjM4O3M6NDA6Ijwvc2NyaXB0PlsnIl1cKTtccyovXCovW2EtekEtWjAtOV9dKz9cKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo5ODoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChbYS16QS1aMC05X10rP1wpO1xzKnNcLnNyY1xzKj0iO2k6NDM7czoxOToiLjovLy5cLi5cLi4vLlwuLlw/LyI7aTo0NDtzOjM5OiJcZCtccyo+XHMqXGQrXHMqXD9ccypbJyJdXFx4XGQrWyciXVxzKjoiO2k6NDU7czo0NToiWyciXVxbXHMqWyciXWNoYXJDb2RlQXRbJyJdXHMqXF1cKFxzKlxkK1xzKlwpIjtpOjQ2O3M6MTc6IjwvYm9keT5ccyo8c2NyaXB0IjtpOjQ3O3M6MTc6IjwvaHRtbD5ccyo8c2NyaXB0IjtpOjQ4O3M6MTc6IjwvaHRtbD5ccyo8aWZyYW1lIjtpOjQ5O3M6NDI6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcKCI7aTo1MDtzOjIyOiJzcmM9ImZpbGVzX3NpdGUvanNcLmpzIjtpOjUxO3M6OTQ6IndpbmRvd1wucG9zdE1lc3NhZ2VcKHtccyp6b3JzeXN0ZW06XHMqMSxccyp0eXBlOlxzKlsnIl11cGRhdGVbJyJdLFxzKnBhcmFtczpccyp7XHMqWyciXXVybFsnIl0iO2k6NTI7czoxMTM6IlthLXpBLVowLTlfXSs/XC5hdHRhY2hFdmVudFwoWyciXW9ubG9hZFsnIl0sYVwpOlthLXpBLVowLTlfXSs/XC5hZGRFdmVudExpc3RlbmVyXChbJyJdbG9hZFsnIl0sYSwhMVwpO2xvYWRNYXRjaGVyIjtpOjUzO3M6Nzg6ImlmXChcKGE9ZVwuZ2V0RWxlbWVudHNCeVRhZ05hbWVcKFsnIl1hWyciXVwpXCkmJmFcWzBcXSYmYVxbMFxdXC5ocmVmXClmb3JcKHZhciI7aTo1NDtzOjgxOiI7XHMqZWxlbWVudFwuaW5uZXJIVE1MXHMqPVxzKlsnIl08aWZyYW1lXHMrc3JjPVsnIl1ccypcK1xzKnhoclwucmVzcG9uc2VUZXh0XHMqXCsiO2k6NTU7czoxOToiWEhGRVIxXHMqPVxzKlhIRkVSMSI7aTo1NjtzOjUxOiJkb2N1bWVudFwud3JpdGVccypcKFxzKnVuZXNjYXBlXHMqXChccypbJyJdezAsMX0lM0MiO2k6NTc7czo3ODoiZG9jdW1lbnRcLndyaXRlXHMqXChccypbJyJdezAsMX08c2NyaXB0XHMrc3JjPVsnIl17MCwxfWh0dHA6Ly88XD89XCRkb21haW5cPz4vIjtpOjU4O3M6NTU6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly9cZCtcLlxkK1wuXGQrXC5cZCsvXD8iO2k6NTk7czo2Njoic2V0VGltZW91dFwoZnVuY3Rpb25cKFwpe3ZhclxzK3BhdHRlcm5ccyo9XHMqbmV3XHMqUmVnRXhwXCgvZ29vZ2xlIjtpOjYwO3M6NjY6IndvPVsnIl1cKyEhXChbJyJdb250b3VjaHN0YXJ0WyciXVxzK2luXHMrd2luZG93XClcK1snIl0mc3Q9MSZ0aXRsZSI7aTo2MTtzOjU2OiJyZWZlcnJlclxzKiE9PVxzKlsnIl1bJyJdXCl7ZG9jdW1lbnRcLndyaXRlXChbJyJdPHNjcmlwdCI7aTo2MjtzOjM3OiJpZlwoYSYmWyciXWRhdGFbJyJdaW5ccyphJiZhXC5kYXRhXC5hIjtpOjYzO3M6NjA6ImpxdWVyeVwubWluXC5waHBbJyJdOyB2YXIgbl91cmwgPSBiYXNlIFwrICJcP2RlZmF1bHRfa2V5d29yZCI7aTo2NDtzOjE1OiJcLnRyeW15ZmluZ2VyXC4iO2k6NjU7czoxOToiXC5vbmVzdGVwdG93aW5cLmNvbSI7fQ=="));

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

define('AI_VERSION', '20151205');

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

function makeSafeFn($par_Str) {
  return htmlspecialchars($par_Str, ENT_SUBSTITUTE | ENT_QUOTES);
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
				$g_UnixExec[] = $l_FileName;
				continue;
			}	
						
			$l_Ext = strtolower(pathinfo($l_FileName, PATHINFO_EXTENSION));
			$l_IsDir = is_dir($l_FileName);

			if (in_array($l_Ext, $g_SuspiciousFiles)) 
			{
                $g_UnixExec[] = $l_FileName;
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
  
  $search  = array( ' ;', ' =', ' ,', ' .', ' (', ' )', ' {', ' }', '; ', '= ', ', ', '. ', '( ', '( ', '{ ', '} ', ' !', ' >', ' <', ' _', '_ ', '< ',  '> ', ' $', ' %',   '% ', '# ', ' #', '^ ', ' ^', ' &', '& ');
  $replace = array(  ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}', ';',  '=',  ',',  '.',  '(',   ')', '{',  '}',   '!',  '>',  '<',  '_', '_',  '<',   '>',   '$',  '%',   '%',  '#',   '#', '^',   '^',  '&', '&');
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

	if ((stripos($par_Filename, 'elfinder/php/connector.php') !== false) ||
	    (stripos($par_Filename, 'elfinder/elfinder.') !== false)) {
			$l_Vuln['id'] = 'AFU : elFinder';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
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
	if (stripos($par_Filename, 'cherry-plugin/admin/import-export/upload.php') !== false) {
		if (strpos($par_Content, 'verify nonce') === false) {
			$l_Vuln['id'] = 'AFU : Cherry Plugin';
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

	if (stripos($par_Filename, 'com_adsmanager/controller.php') !== false) {		
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
                   AddResult($l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, 'H24LKHLK657HGKJHGKJHGGGHJ') !== false) {
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

  // H24LKHLK657HGKJHGKJHGGGHJ

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

// detect version CMS
$l_CmsListDetector = new CmsVersionDetector('.');
$l_CmsDetectedNum = $l_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $l_CmsListDetector->getCmsName($tt) . ' v' . makeSafeFn($l_CmsListDetector->getCmsVersion($tt));
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

$l_PlainResult = "# Malware list detected by AI-Bolit (http://revisium.com/ai/) on " . date("d/m/Y H:i:s", time()) . " " . $l_HostName .  "\n\n";

stdOut("Building list of vulnerable scripts " . count($g_Vulnerable));

if (count($g_Vulnerable) > 0) {
    $l_Result .= '<div class="note_vir">' . AI_STR_081 . ' (' . count($g_Vulnerable) . ')</div><div class="crit">';
 	foreach ($g_Vulnerable as $l_Item) {
	    $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$l_Item['ndx']]) . ' - ' . $l_Item['id'] . '</li>';
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
  $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
  $l_Result .= printList($g_NotRead);
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
}

stdOut("Building list of symlinks " . count($g_SymLinks));

if (count($g_SymLinks) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SymLinks)));
  $l_Result .= "</div><div class=\"spacer\"></div>";
}

stdOut("Building list of unix executables and odd scripts " . count($g_UnixExec));

if (count($g_UnixExec) > 0) {
  $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_019 . ' (' . count($g_UnixExec) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_UnixExec)));
  $l_PlainResult .= implode("\n", $g_UnixExec);
  $l_Result .= "</div>" . PHP_EOL;

  if (AI_EXPERT > 1) $l_ShowOffer = true;
}

////////////////////////////////////
$l_WarningsNum = count($g_HeuristicDetected) + count($g_HiddenFiles) + count($g_BigFiles) + count($g_PHPCodeInside) + count($g_AdwareList) + count($g_EmptyLink) + count($g_Doorway) + (count($g_WarningPHP[0]) + count($g_WarningPHP[1]) + count($g_SkippedFolders) + count(g_CMS));

if ($l_WarningsNum > 0) {
	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
}

stdOut("Building list of links/adware " . count($g_AdwareList));

if (count($g_AdwareList) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
  $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of heuristics " . count($g_HeuristicDetected));

if (count($g_HeuristicDetected) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
  for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
	   $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$g_HeuristicDetected[$i]]) . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
  }
  
  $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;
}

stdOut("Building list of hidden files " . count($g_HiddenFiles));
if (count($g_HiddenFiles) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_023 . ' (' . count($g_HiddenFiles) . ')</div><div class="warn">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_HiddenFiles)));
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
      $l_Result .= '<span class="details">' . makeSafeFn($g_Structure['n'][$g_EmptyLink[$i]]) . ' &rarr; ' . htmlspecialchars($g_EmptyLinkSrc[$l_Idx][$j]) . '</span><br/>';
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
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SkippedFolders)));   
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
