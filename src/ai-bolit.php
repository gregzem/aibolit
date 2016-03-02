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
//@mb_internal_encoding('');

$int_enc = @ini_get('mbstring.internal_encoding');
        
define('SHORT_PHP_TAG', strtolower(ini_get('short_open_tag')) == 'on' || strtolower(ini_get('short_open_tag')) == 1 ? true : false);

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
$msg1 = "\"Отображать по _MENU_ записей\"";
$msg2 = "\"Ничего не найдено\"";
$msg3 = "\"Отображается c _START_ по _END_ из _TOTAL_ файлов\"";
$msg4 = "\"Нет файлов\"";
$msg5 = "\"(всего записей _MAX_)\"";
$msg6 = "\"Поиск:\"";
$msg7 = "\"Первая\"";
$msg8 = "\"Предыдущая\"";
$msg9 = "\"Следующая\"";
$msg10 = "\"Последняя\"";
$msg11 = "\": активировать для сортировки столбца по возрастанию\"";
$msg12 = "\": активировать для сортировки столбцов по убыванию\"";

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
$msg1 = "\"Display _MENU_ records\"";
$msg2 = "\"Not found\"";
$msg3 = "\"Display from _START_ to _END_ of _TOTAL_ files\"";
$msg4 = "\"No files\"";
$msg5 = "\"(total _MAX_)\"";
$msg6 = "\"Filter/Search:\"";
$msg7 = "\"First\"";
$msg8 = "\"Previous\"";
$msg9 = "\"Next\"";
$msg10 = "\"Last\"";
$msg11 = "\": activate to sort row ascending order\"";
$msg12 = "\": activate to sort row descending order\"";

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
 <div class="crit" style="font-size: 17px;"><b>Danger! Malicious or suspicious files have been detected on the website.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/home/" target=_blank>contact security experts</a> or experienced webmaster immediately to clean up the website from malware.
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
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending": $msg11,
				"sSortDescending": $msg12	
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
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending":  $msg11,
				"sSortDescending": $msg12	
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
			  		"oLanguage": {
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
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
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
			  			}
		}

     } );
}


</script>
<!-- @@SERVICE_INFO@@  -->
 </body>
</html>
MAIN_PAGE;

$g_AiBolitAbsolutePath = dirname(__FILE__);

if (file_exists($g_AiBolitAbsolutePath . '/ai-design.html')) {
  $l_Template = file_get_contents($g_AiBolitAbsolutePath . '/ai-design.html');
}

$l_Template = str_replace('@@MAIN_TITLE@@', AI_STR_001, $l_Template);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//BEGIN_SIG 28/02/2016 10:23:27
$g_DBShe = unserialize(base64_decode("YTo0MjU6e2k6MDtzOjU6InJhaHVpIjtpOjE7czoxNToidzRsM1h6WTMgTWFpbGVyIjtpOjI7czozNToibW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbPHFxPkYxbDMiO2k6MztzOjEzOiJCeTxzMT5LeW1Mam5rIjtpOjQ7czoxMzoiQnk8czE+U2g0TGluayI7aTo1O3M6MTY6IkJ5PHMxPkFub25Db2RlcnMiO2k6NjtzOjQ2OiIkdXNlckFnZW50cyA9IGFycmF5KCJHb29nbGUiLCAiU2x1cnAiLCAiTVNOQm90IjtpOjc7czo2OiJbM3Jhbl0iO2k6ODtzOjEwOiJEYXduX2FuZ2VsIjtpOjk7czo4OiJSM0RUVVhFUyI7aToxMDtzOjIwOiJ2aXNpdG9yVHJhY2tlcl9pc01vYiI7aToxMTtzOjI0OiJjb21fY29udGVudC9hcnRpY2xlZC5waHAiO2k6MTI7czoxNzoiPHRpdGxlPkVtc1Byb3h5IHYiO2k6MTM7czoxMzoiYW5kcm9pZC1pZ3JhLSI7aToxNDtzOjE1OiI9PT06OjptYWQ6Ojo9PT0iO2k6MTU7czo1OiJINHhPciI7aToxNjtzOjg6IlI0cEg0eDByIjtpOjE3O3M6ODoiTkc2ODlTa3ciO2k6MTg7czoxMToiZm9wby5jb20uYXIiO2k6MTk7czo5OiI2NC42OC44MC4iO2k6MjA7czo4OiJIYXJjaGFMaSI7aToyMTtzOjE1OiJ4eFI5OW11c3ZpZWkweDAiO2k6MjI7czoxMToiUC5oLnAuUy5wLnkiO2k6MjM7czoxNDoiX3NoZWxsX2F0aWxkaV8iO2k6MjQ7czo5OiJ+IFNoZWxsIEkiO2k6MjU7czo2OiIweGRkODIiO2k6MjY7czoxNDoiQW50aWNoYXQgc2hlbGwiO2k6Mjc7czoxMjoiQUxFTWlOIEtSQUxpIjtpOjI4O3M6MTY6IkFTUFggU2hlbGwgYnkgTFQiO2k6Mjk7czo5OiJhWlJhaUxQaFAiO2k6MzA7czoyMjoiQ29kZWQgQnkgQ2hhcmxpY2hhcGxpbiI7aTozMTtzOjc6IkJsMG9kM3IiO2k6MzI7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjMzO3M6MTE6ImRldmlselNoZWxsIjtpOjM0O3M6MzA6IldyaXR0ZW4gYnkgQ2FwdGFpbiBDcnVuY2ggVGVhbSI7aTozNTtzOjk6ImMyMDA3LnBocCI7aTozNjtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjM3O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjM4O3M6OToiQzk5IFNoZWxsIjtpOjM5O3M6MjI6ImNvb2tpZW5hbWUgPSAid2llZWVlZSIiO2k6NDA7czozODoiQ29kZWQgYnkgOiBTdXBlci1DcnlzdGFsIGFuZCBNb2hhamVyMjIiO2k6NDE7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjQyO3M6MjM6IlRFQU0gU0NSSVBUSU5HIC0gUk9ETk9DIjtpOjQzO3M6MTE6IkN5YmVyIFNoZWxsIjtpOjQ0O3M6NzoiZDBtYWlucyI7aTo0NTtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjQ2O3M6MjQ6IlNoZWxsIHdyaXR0ZW4gYnkgQmwwb2QzciI7aTo0NztzOjMzOiJEaXZlIFNoZWxsIC0gRW1wZXJvciBIYWNraW5nIFRlYW0iO2k6NDg7czoxNToiRGV2ci1pIE1lZnNlZGV0IjtpOjQ5O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjUwO3M6MjA6IkVtcGVyb3IgSGFja2luZyBURUFNIjtpOjUxO3M6MjA6IkZpeGVkIGJ5IEFydCBPZiBIYWNrIjtpOjUyO3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aTo1MztzOjI3OiJMdXRmZW4gRG9zeWF5aSBBZGxhbmRpcmluaXoiO2k6NTQ7czoyMjoidGhpcyBpcyBhIHByaXYzIHNlcnZlciI7aTo1NTtzOjEzOiJHRlMgV2ViLVNoZWxsIjtpOjU2O3M6MTE6IkdIQyBNYW5hZ2VyIjtpOjU3O3M6MTQ6Ikdvb2cxZV9hbmFsaXN0IjtpOjU4O3M6MTM6IkdyaW5heSBHbzBvJEUiO2k6NTk7czoyOToiaDRudHUgc2hlbGwgW3Bvd2VyZWQgYnkgdHNvaV0iO2k6NjA7czoyNToiSGFja2VkIEJ5IERldnItaSBNZWZzZWRldCI7aTo2MTtzOjE3OiJIQUNLRUQgQlkgUkVBTFdBUiI7aTo2MjtzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTo2MztzOjExOiJpTUhhQmlSTGlHaSI7aTo2NDtzOjk6IktBX3VTaGVsbCI7aTo2NTtzOjc6IkxpejB6aU0iO2k6NjY7czoxMToiTG9jdXM3U2hlbGwiO2k6Njc7czozNjoiTW9yb2NjYW4gU3BhbWVycyBNYS1FZGl0aW9OIEJ5IEdoT3NUIjtpOjY4O3M6MTA6Ik1hdGFtdSBNYXQiO2k6Njk7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6NzA7czo2OiJtMHJ0aXgiO2k6NzE7czo1OiJtMGh6ZSI7aTo3MjtzOjEwOiJNYXRhbXUgTWF0IjtpOjczO3M6MTY6Ik1vcm9jY2FuIFNwYW1lcnMiO2k6NzQ7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjc1O3M6OToiTXlTUUwgUlNUIjtpOjc2O3M6MTk6Ik15U1FMIFdlYiBJbnRlcmZhY2UiO2k6Nzc7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjc4O3M6MTQ6Ik15U1FMIFdlYnNoZWxsIjtpOjc5O3M6ODoiTjN0c2hlbGwiO2k6ODA7czoxNjoiSGFja2VkIGJ5IFNpbHZlciI7aTo4MTtzOjc6Ik5lb0hhY2siO2k6ODI7czoyMToiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIjtpOjgzO3M6MjA6Ik5JWCBSRU1PVEUgV0VCLVNIRUxMIjtpOjg0O3M6MjY6Ik8gQmlSIEtSQUwgVEFLTGlUIEVEaWxFTUVaIjtpOjg1O3M6MTg6IlBIQU5UQVNNQS0gTmVXIENtRCI7aTo4NjtzOjIxOiJQSVJBVEVTIENSRVcgV0FTIEhFUkUiO2k6ODc7czoyMToiYSBzaW1wbGUgcGhwIGJhY2tkb29yIjtpOjg4O3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjg5O3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6OTA7czo5OiJQSFBKYWNrYWwiO2k6OTE7czoyMDoiUEhQIEhWQSBTaGVsbCBTY3JpcHQiO2k6OTI7czoxMzoicGhwUmVtb3RlVmlldyI7aTo5MztzOjM1OiJQSFAgU2hlbGwgaXMgYW5pbnRlcmFjdGl2ZSBQSFAtcGFnZSI7aTo5NDtzOjY6IlBIVmF5diI7aTo5NTtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTo5NjtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjk3O3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6OTg7czo1OiJyMG5pbiI7aTo5OTtzOjY6IlI1N1NxbCI7aToxMDA7czoxMzoicjU3c2hlbGxcLnBocCI7aToxMDE7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjEwMjtzOjIwOiJyZWFsYXV0aD1TdkJEODVkSU51MyI7aToxMDM7czoxNjoiUnUyNFBvc3RXZWJTaGVsbCI7aToxMDQ7czoyMToiS0Fkb3QgVW5pdmVyc2FsIFNoZWxsIjtpOjEwNTtzOjEwOiJDckB6eV9LaW5nIjtpOjEwNjtzOjIwOiJTYWZlX01vZGUgQnlwYXNzIFBIUCI7aToxMDc7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MTA4O3M6MjU6IlNpbXBsZSBQSFAgYmFja2Rvb3IgYnkgREsiO2k6MTA5O3M6MTk6IkctU2VjdXJpdHkgV2Vic2hlbGwiO2k6MTEwO3M6MjU6IlNpbW9yZ2ggU2VjdXJpdHkgTWFnYXppbmUiO2k6MTExO3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjExMjtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjExMztzOjExOiJTdG9ybTdTaGVsbCI7aToxMTQ7czo5OiJUaGVfQmVLaVIiO2k6MTE1O3M6OToiVzNEIFNoZWxsIjtpOjExNjtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjExNztzOjI4OiJkZXZlbG9wZWQgYnkgRGlnaXRhbCBPdXRjYXN0IjtpOjExODtzOjMyOiJXYXRjaCBZb3VyIHN5c3RlbSBTaGFueSB3YXMgaGVyZSI7aToxMTk7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjEyMDtzOjEzOiJXU08yIFdlYnNoZWxsIjtpOjEyMTtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MTIyO3M6Mjc6IlNtYWxsIFBIUCBXZWIgU2hlbGwgYnkgWmFDbyI7aToxMjM7czoxMDoiTXJsb29sLmV4ZSI7aToxMjQ7czo2OiJTRW9ET1IiO2k6MTI1O3M6OToiTXIuSGlUbWFuIjtpOjEyNjtzOjU6ImQzYn5YIjtpOjEyNztzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjEyODtzOjEwOiJCWSBNTU5CT0JaIjtpOjEyOTtzOjI2OiJPTEI6UFJPRFVDVDpPTkxJTkVfQkFOS0lORyI7aToxMzA7czoxMDoiQzBkZXJ6LmNvbSI7aToxMzE7czo3OiJNckhhemVtIjtpOjEzMjtzOjk6InYwbGQzbTBydCI7aToxMzM7czo2OiJLIUxMM3IiO2k6MTM0O3M6MTA6IkRyLmFib2xhbGgiO2k6MTM1O3M6MzA6IiRyYW5kX3dyaXRhYmxlX2ZvbGRlcl9mdWxscGF0aCI7aToxMzY7czo4NDoiPHRleHRhcmVhIG5hbWU9XCJwaHBldlwiIHJvd3M9XCI1XCIgY29scz1cIjE1MFwiPiIuQCRfUE9TVFsncGhwZXYnXS4iPC90ZXh0YXJlYT48YnI+IjtpOjEzNztzOjE2OiJjOTlmdHBicnV0ZWNoZWNrIjtpOjEzODtzOjk6IkJ5IFBzeWNoMCI7aToxMzk7czoxNzoiJGM5OXNoX3VwZGF0ZWZ1cmwiO2k6MTQwO3M6MTQ6InRlbXBfcjU3X3RhYmxlIjtpOjE0MTtzOjE3OiJhZG1pbkBzcHlncnVwLm9yZyI7aToxNDI7czo3OiJjYXN1czE1IjtpOjE0MztzOjEzOiJXU0NSSVBULlNIRUxMIjtpOjE0NDtzOjQ3OiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj0jZGNkY2RjPlskY21kXSI7aToxNDU7czoxMToiY3RzaGVsbC5waHAiO2k6MTQ2O3M6MTU6IkRYX0hlYWRlcl9kcmF3biI7aToxNDc7czo4NjoiY3JsZi4ndW5saW5rKCRuYW1lKTsnLiRjcmxmLidyZW5hbWUoIn4iLiRuYW1lLCAkbmFtZSk7Jy4kY3JsZi4ndW5saW5rKCJncnBfcmVwYWlyLnBocCIiO2k6MTQ4O3M6MTA1OiIvMHRWU0cvU3V2MFVyL2hhVVlBZG4zak1Rd2Jib2NHZmZBZUMyOUJOOXRtQmlKZFYxbGsrallEVTkyQzk0amR0RGlmK3hPWWpHNkNMaHgzMVVvOXg5L2VBV2dzQks2MGtLMm1Md3F6cWQiO2k6MTQ5O3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjE1MDtzOjM3OiJrbGFzdmF5di5hc3A/eWVuaWRvc3lhPTwlPWFrdGlma2xhcyU+IjtpOjE1MTtzOjEyMjoibnQpKGRpc2tfdG90YWxfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiAiIC4gIkZyZWUgc3BhY2UgIiAuIChpbnQpKGRpc2tfZnJlZV9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iIDwiO2k6MTUyO3M6NzY6ImEgaHJlZj0iPD9lY2hvICIkZmlzdGlrLnBocD9kaXppbj0kZGl6aW4vLi4vIj8+IiBzdHlsZT0idGV4dC1kZWNvcmF0aW9uOiBub24iO2k6MTUzO3M6Mzg6IlJvb3RTaGVsbCEnKTtzZWxmLmxvY2F0aW9uLmhyZWY9J2h0dHA6IjtpOjE1NDtzOjkwOiI8JT1SZXF1ZXN0LlNlcnZlclZhcmlhYmxlcygic2NyaXB0X25hbWUiKSU+P0ZvbGRlclBhdGg9PCU9U2VydmVyLlVSTFBhdGhFbmNvZGUoRm9sZGVyLkRyaXYiO2k6MTU1O3M6MTYwOiJwcmludCgoaXNfcmVhZGFibGUoJGYpICYmIGlzX3dyaXRlYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIi53KDEpLmZvbnQoJ3JlZCcsJ1JXJywzKSkudygxKTooKChpc19yZWFkYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIikudyg0KToiIikuKChpc193cml0YWJsIjtpOjE1NjtzOjE2MToiKCciJywnJnF1b3Q7JywkZm4pKS4nIjtkb2N1bWVudC5saXN0LnN1Ym1pdCgpO1wnPicuaHRtbHNwZWNpYWxjaGFycyhzdHJsZW4oJGZuKT5mb3JtYXQ/c3Vic3RyKCRmbiwwLGZvcm1hdC0zKS4nLi4uJzokZm4pLic8L2E+Jy5zdHJfcmVwZWF0KCcgJyxmb3JtYXQtc3RybGVuKCRmbikiO2k6MTU3O3M6MTE6InplaGlyaGFja2VyIjtpOjE1ODtzOjM5OiJKQCFWckAqJlJIUnd+Skx3Lkd8eGxobkxKfj8xLmJ3T2J4YlB8IVYiO2k6MTU5O3M6Mzk6IldTT3NldGNvb2tpZShtZDUoJF9TRVJWRVJbJ0hUVFBfSE9TVCddKSI7aToxNjA7czoxNDE6IjwvdGQ+PHRkIGlkPWZhPlsgPGEgdGl0bGU9XCJIb21lOiAnIi5odG1sc3BlY2lhbGNoYXJzKHN0cl9yZXBsYWNlKCJcIiwgJHNlcCwgZ2V0Y3dkKCkpKS4iJy5cIiBpZD1mYSBocmVmPVwiamF2YXNjcmlwdDpWaWV3RGlyKCciLnJhd3VybGVuY29kZSI7aToxNjE7czoxNjoiQ29udGVudC1UeXBlOiAkXyI7aToxNjI7czo4NjoiPG5vYnI+PGI+JGNkaXIkY2ZpbGU8L2I+ICgiLiRmaWxlWyJzaXplX3N0ciJdLiIpPC9ub2JyPjwvdGQ+PC90cj48Zm9ybSBuYW1lPWN1cnJfZmlsZT4iO2k6MTYzO3M6NDg6Indzb0V4KCd0YXIgY2Z6diAnIC4gZXNjYXBlc2hlbGxhcmcoJF9QT1NUWydwMiddKSI7aToxNjQ7czoxNDI6IjVqYjIwaUtXOXlJSE4wY21semRISW9KSEpsWm1WeVpYSXNJbUZ3YjNKMElpa2diM0lnYzNSeWFYTjBjaWdrY21WbVpYSmxjaXdpYm1sbmJXRWlLU0J2Y2lCemRISnBjM1J5S0NSeVpXWmxjbVZ5TENKM1pXSmhiSFJoSWlrZ2IzSWdjM1J5YVhOMGNpZ2siO2k6MTY1O3M6NzY6IkxTMGdSSFZ0Y0ROa0lHSjVJRkJwY25Wc2FXNHVVRWhRSUZkbFluTm9NMnhzSUhZeExqQWdZekJrWldRZ1lua2djakJrY2pFZ09rdz0iO2k6MTY2O3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjE2NztzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjE2ODtzOjEyOiJQSFBTSEVMTC5QSFAiO2k6MTY5O3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjE3MDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjE3MTtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjE3MjtzOjIxOiJGYVRhTGlzVGlDel9GeCBGeDI5U2giO2k6MTczO3M6NDI6Ildvcmtlcl9HZXRSZXBseUNvZGUoJG9wRGF0YVsncmVjdkJ1ZmZlciddKSI7aToxNzQ7czo0MDoiJGZpbGVwYXRoPUByZWFscGF0aCgkX1BPU1RbJ2ZpbGVwYXRoJ10pOyI7aToxNzU7czo4ODoiJHJlZGlyZWN0VVJMPSdodHRwOi8vJy4kclNpdGUuJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ107aWYoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddKSI7aToxNzY7czoxNzoicmVuYW1lKCJ3c28ucGhwIiwiO2k6MTc3O3M6NTQ6IiRNZXNzYWdlU3ViamVjdCA9IGJhc2U2NF9kZWNvZGUoJF9QT1NUWyJtc2dzdWJqZWN0Il0pOyI7aToxNzg7czo0NDoiY29weSgkX0ZJTEVTW3hdW3RtcF9uYW1lXSwkX0ZJTEVTW3hdW25hbWVdKSkiO2k6MTc5O3M6NTg6IlNFTEVDVCAxIEZST00gbXlzcWwudXNlciBXSEVSRSBjb25jYXQoYHVzZXJgLCAnQCcsIGBob3N0YCkiO2k6MTgwO3M6MjE6IiFAJF9DT09LSUVbJHNlc3NkdF9rXSI7aToxODE7czo0ODoiJGE9KHN1YnN0cih1cmxlbmNvZGUocHJpbnRfcihhcnJheSgpLDEpKSw1LDEpLmMpIjtpOjE4MjtzOjU2OiJ4aCAtcyAiL3Vzci9sb2NhbC9hcGFjaGUvc2Jpbi9odHRwZCAtRFNTTCIgLi9odHRwZCAtbSAkMSI7aToxODM7czoxODoicHdkID4gR2VuZXJhc2kuZGlyIjtpOjE4NDtzOjEyOiJCUlVURUZPUkNJTkciO2k6MTg1O3M6MzE6IkNhdXRhbSBmaXNpZXJlbGUgZGUgY29uZmlndXJhcmUiO2k6MTg2O3M6MzI6IiRrYT0nPD8vL0JSRSc7JGtha2E9JGthLidBQ0svLz8+IjtpOjE4NztzOjg1OiIkc3Viaj11cmxkZWNvZGUoJF9HRVRbJ3N1J10pOyRib2R5PXVybGRlY29kZSgkX0dFVFsnYm8nXSk7JHNkcz11cmxkZWNvZGUoJF9HRVRbJ3NkJ10pIjtpOjE4ODtzOjM5OiIkX19fXz1AZ3ppbmZsYXRlKCRfX19fKSl7aWYoaXNzZXQoJF9QT1MiO2k6MTg5O3M6Mzc6InBhc3N0aHJ1KGdldGVudigiSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTkwO3M6ODoiQXNtb2RldXMiO2k6MTkxO3M6NTA6ImZvcig7JHBhZGRyPWFjY2VwdChDTElFTlQsIFNFUlZFUik7Y2xvc2UgQ0xJRU5UKSB7IjtpOjE5MjtzOjU5OiIkaXppbmxlcjI9c3Vic3RyKGJhc2VfY29udmVydChAZmlsZXBlcm1zKCRmbmFtZSksMTAsOCksLTQpOyI7aToxOTM7czo0MjoiJGJhY2tkb29yLT5jY29weSgkY2ZpY2hpZXIsJGNkZXN0aW5hdGlvbik7IjtpOjE5NDtzOjIzOiJ7JHtwYXNzdGhydSgkY21kKX19PGJyPiI7aToxOTU7czoyOToiJGFbaGl0c10nKTsgXHJcbiNlbmRxdWVyeVxyXG4iO2k6MTk2O3M6MjY6Im5jZnRwcHV0IC11ICRmdHBfdXNlcl9uYW1lIjtpOjE5NztzOjM2OiJleGVjbCgiL2Jpbi9zaCIsInNoIiwiLWkiLChjaGFyKikwKTsiO2k6MTk4O3M6MzE6IjxIVE1MPjxIRUFEPjxUSVRMRT5jZ2ktc2hlbGwucHkiO2k6MTk5O3M6Mzg6InN5c3RlbSgidW5zZXQgSElTVEZJTEU7IHVuc2V0IFNBVkVISVNUIjtpOjIwMDtzOjIzOiIkbG9naW49QHBvc2l4X2dldHVpZCgpOyI7aToyMDE7czo2MDoiKGVyZWcoJ15bWzpibGFuazpdXSpjZFtbOmJsYW5rOl1dKiQnLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSkpIjtpOjIwMjtzOjI1OiIhJF9SRVFVRVNUWyJjOTlzaF9zdXJsIl0pIjtpOjIwMztzOjUzOiJQblZsa1dNNjMhQCNAJmRLeH5uTURXTX5Efy9Fc25+eH82REAjQCZQfn4sP25ZLFdQe1BvaiI7aToyMDQ7czozNjoic2hlbGxfZXhlYygkX1BPU1RbJ2NtZCddIC4gIiAyPiYxIik7IjtpOjIwNTtzOjM1OiJpZighJHdob2FtaSkkd2hvYW1pPWV4ZWMoIndob2FtaSIpOyI7aToyMDY7czo2MToiUHlTeXN0ZW1TdGF0ZS5pbml0aWFsaXplKFN5c3RlbS5nZXRQcm9wZXJ0aWVzKCksIG51bGwsIGFyZ3YpOyI7aToyMDc7czozNjoiPCU9ZW52LnF1ZXJ5SGFzaHRhYmxlKCJ1c2VyLm5hbWUiKSU+IjtpOjIwODtzOjgzOiJpZiAoZW1wdHkoJF9QT1NUWyd3c2VyJ10pKSB7JHdzZXIgPSAid2hvaXMucmlwZS5uZXQiO30gZWxzZSAkd3NlciA9ICRfUE9TVFsnd3NlciddOyI7aToyMDk7czo5MToiaWYgKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWydmaWxhJ11bJ3RtcF9uYW1lJ10sICRjdXJkaXIuIi8iLiRfRklMRVNbJ2ZpbGEnXVsnbmFtZSddKSkgeyI7aToyMTA7czoyMzoic2hlbGxfZXhlYygndW5hbWUgLWEnKTsiO2k6MjExO3M6NDc6ImlmICghZGVmaW5lZCRwYXJhbXtjbWR9KXskcGFyYW17Y21kfT0ibHMgLWxhIn07IjtpOjIxMjtzOjYwOiJpZihnZXRfbWFnaWNfcXVvdGVzX2dwYygpKSRzaGVsbE91dD1zdHJpcHNsYXNoZXMoJHNoZWxsT3V0KTsiO2k6MjEzO3M6ODQ6IjxhIGhyZWY9JyRQSFBfU0VMRj9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9JGRibmFtZSZ0YWJsZW5hbWU9JHRhYmxlbmFtZSc+U2NoZW1hPC9hPiI7aToyMTQ7czo2NjoicGFzc3RocnUoICRiaW5kaXIuIm15c3FsZHVtcCAtLXVzZXI9JFVTRVJOQU1FIC0tcGFzc3dvcmQ9JFBBU1NXT1JEIjtpOjIxNTtzOjY2OiJteXNxbF9xdWVyeSgiQ1JFQVRFIFRBQkxFIGB4cGxvaXRgIChgeHBsb2l0YCBMT05HQkxPQiBOT1QgTlVMTCkiKTsiO2k6MjE2O3M6ODc6IiRyYTQ0ICA9IHJhbmQoMSw5OTk5OSk7JHNqOTggPSAic2gtJHJhNDQiOyRtbCA9ICIkc2Q5OCI7JGE1ID0gJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOyI7aToyMTc7czo1MjoiJF9GSUxFU1sncHJvYmUnXVsnc2l6ZSddLCAkX0ZJTEVTWydwcm9iZSddWyd0eXBlJ10pOyI7aToyMTg7czo3MToic3lzdGVtKCIkY21kIDE+IC90bXAvY21kdGVtcCAyPiYxOyBjYXQgL3RtcC9jbWR0ZW1wOyBybSAvdG1wL2NtZHRlbXAiKTsiO2k6MjE5O3M6Njk6In0gZWxzaWYgKCRzZXJ2YXJnID1+IC9eXDooLis/KVwhKC4rPylcQCguKz8pIFBSSVZNU0cgKC4rPykgXDooLispLykgeyI7aToyMjA7czo2OToic2VuZChTT0NLNSwgJG1zZywgMCwgc29ja2FkZHJfaW4oJHBvcnRhLCAkaWFkZHIpKSBhbmQgJHBhY290ZXN7b30rKzs7IjtpOjIyMTtzOjE4OiIkZmUoIiRjbWQgIDI+JjEiKTsiO2k6MjIyO3M6Njg6IndoaWxlICgkcm93ID0gbXlzcWxfZmV0Y2hfYXJyYXkoJHJlc3VsdCxNWVNRTF9BU1NPQykpIHByaW50X3IoJHJvdyk7IjtpOjIyMztzOjUyOiJlbHNlaWYoQGlzX3dyaXRhYmxlKCRGTikgJiYgQGlzX2ZpbGUoJEZOKSkgJHRtcE91dE1GIjtpOjIyNDtzOjcyOiJjb25uZWN0KFNPQ0tFVCwgc29ja2FkZHJfaW4oJEFSR1ZbMV0sIGluZXRfYXRvbigkQVJHVlswXSkpKSBvciBkaWUgcHJpbnQiO2k6MjI1O3M6ODk6ImlmKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWyJmaWMiXVsidG1wX25hbWUiXSxnb29kX2xpbmsoIi4vIi4kX0ZJTEVTWyJmaWMiXVsibmFtZSJdKSkpIjtpOjIyNjtzOjg3OiJVTklPTiBTRUxFQ1QgJzAnICwgJzw/IHN5c3RlbShcJF9HRVRbY3BjXSk7ZXhpdDsgPz4nICwwICwwICwwICwwIElOVE8gT1VURklMRSAnJG91dGZpbGUiO2k6MjI3O3M6Njg6ImlmICghQGlzX2xpbmsoJGZpbGUpICYmICgkciA9IHJlYWxwYXRoKCRmaWxlKSkgIT0gRkFMU0UpICRmaWxlID0gJHI7IjtpOjIyODtzOjI5OiJlY2hvICJGSUxFIFVQTE9BREVEIFRPICRkZXoiOyI7aToyMjk7czoyNDoiJGZ1bmN0aW9uKCRfUE9TVFsnY21kJ10pIjtpOjIzMDtzOjM4OiIkZmlsZW5hbWUgPSAkYmFja3Vwc3RyaW5nLiIkZmlsZW5hbWUiOyI7aToyMzE7czo0ODoiaWYoJyc9PSgkZGY9QGluaV9nZXQoJ2Rpc2FibGVfZnVuY3Rpb25zJykpKXtlY2hvIjtpOjIzMjtzOjQ2OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3QuU2VydmVyVmFyaWFibGVzICU+IjtpOjIzMztzOjMzOiJpZiAoJGZ1bmNhcmcgPX4gL15wb3J0c2NhbiAoLiopLykiO2k6MjM0O3M6NTU6IiR1cGxvYWRmaWxlID0gJHJwYXRoLiIvIiAuICRfRklMRVNbJ3VzZXJmaWxlJ11bJ25hbWUnXTsiO2k6MjM1O3M6MjY6IiRjbWQgPSAoJF9SRVFVRVNUWydjbWQnXSk7IjtpOjIzNjtzOjM4OiJpZigkY21kICE9ICIiKSBwcmludCBTaGVsbF9FeGVjKCRjbWQpOyI7aToyMzc7czoyOToiaWYgKGlzX2ZpbGUoIi90bXAvJGVraW5jaSIpKXsiO2k6MjM4O3M6Njk6Il9fYWxsX18gPSBbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXSI7aToyMzk7czo1OToiZ2xvYmFsICRteXNxbEhhbmRsZSwgJGRibmFtZSwgJHRhYmxlbmFtZSwgJG9sZF9uYW1lLCAkbmFtZSwiO2k6MjQwO3M6Mjc6IjI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOyI7aToyNDE7czo1MjoibWFwIHsgcmVhZF9zaGVsbCgkXykgfSAoJHNlbF9zaGVsbC0+Y2FuX3JlYWQoMC4wMSkpOyI7aToyNDI7czoyMjoiZndyaXRlICgkZnAsICIkeWF6aSIpOyI7aToyNDM7czo1MToiU2VuZCB0aGlzIGZpbGU6IDxJTlBVVCBOQU1FPSJ1c2VyZmlsZSIgVFlQRT0iZmlsZSI+IjtpOjI0NDtzOjQyOiIkZGJfZCA9IEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlLCRjb24xKTsiO2k6MjQ1O3M6Njc6ImZvciAoJHZhbHVlKSB7IHMvJi8mYW1wOy9nOyBzLzwvJmx0Oy9nOyBzLz4vJmd0Oy9nOyBzLyIvJnF1b3Q7L2c7IH0iO2k6MjQ2O3M6NzQ6ImNvcHkoJF9GSUxFU1sndXBrayddWyd0bXBfbmFtZSddLCJray8iLmJhc2VuYW1lKCRfRklMRVNbJ3Vwa2snXVsnbmFtZSddKSk7IjtpOjI0NztzOjg2OiJmdW5jdGlvbiBnb29nbGVfYm90KCkgeyRzVXNlckFnZW50ID0gc3RydG9sb3dlcigkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pO2lmKCEoc3RycCI7aToyNDg7czo3NToiY3JlYXRlX2Z1bmN0aW9uKCImJCIuImZ1bmN0aW9uIiwiJCIuImZ1bmN0aW9uID0gY2hyKG9yZCgkIi4iZnVuY3Rpb24pLTMpOyIpIjtpOjI0OTtzOjQ2OiJsb25nIGludDp0KDAsMyk9cigwLDMpOy0yMTQ3NDgzNjQ4OzIxNDc0ODM2NDc7IjtpOjI1MDtzOjQ2OiI/dXJsPScuJF9TRVJWRVJbJ0hUVFBfSE9TVCddKS51bmxpbmsoUk9PVF9ESVIuIjtpOjI1MTtzOjM2OiJjYXQgJHtibGtsb2dbMl19IHwgZ3JlcCAicm9vdDp4OjA6MCIiO2k6MjUyO3M6OTc6IkBwYXRoMT0oJ2FkbWluLycsJ2FkbWluaXN0cmF0b3IvJywnbW9kZXJhdG9yLycsJ3dlYmFkbWluLycsJ2FkbWluYXJlYS8nLCdiYi1hZG1pbi8nLCdhZG1pbkxvZ2luLyciO2k6MjUzO3M6ODc6IiJhZG1pbjEucGhwIiwgImFkbWluMS5odG1sIiwgImFkbWluMi5waHAiLCAiYWRtaW4yLmh0bWwiLCAieW9uZXRpbS5waHAiLCAieW9uZXRpbS5odG1sIiI7aToyNTQ7czo2ODoiUE9TVCB7JHBhdGh9eyRjb25uZWN0b3J9P0NvbW1hbmQ9RmlsZVVwbG9hZCZUeXBlPUZpbGUmQ3VycmVudEZvbGRlcj0iO2k6MjU1O3M6MzA6IkBhc3NlcnQoJF9SRVFVRVNUWydQSFBTRVNTSUQnXSI7aToyNTY7czo2MToiJHByb2Q9InN5Ii4icyIuInRlbSI7JGlkPSRwcm9kKCRfUkVRVUVTVFsncHJvZHVjdCddKTskeydpZCd9OyI7aToyNTc7czoxNToicGhwICIuJHdzb19wYXRoIjtpOjI1ODtzOjc3OiIkRmNobW9kLCRGZGF0YSwkT3B0aW9ucywkQWN0aW9uLCRoZGRhbGwsJGhkZGZyZWUsJGhkZHByb2MsJHVuYW1lLCRpZGQpOnNoYXJlZCI7aToyNTk7czo1MToic2VydmVyLjwvcD5cclxuPC9ib2R5PjwvaHRtbD4iO2V4aXQ7fWlmKHByZWdfbWF0Y2goIjtpOjI2MDtzOjk1OiIkZmlsZSA9ICRfRklMRVNbImZpbGVuYW1lIl1bIm5hbWUiXTsgZWNobyAiPGEgaHJlZj1cIiRmaWxlXCI+JGZpbGU8L2E+Ijt9IGVsc2Uge2VjaG8oImVtcHR5Iik7fSI7aToyNjE7czo2MDoiRlNfY2hrX2Z1bmNfbGliYz0oICQocmVhZGVsZiAtcyAkRlNfbGliYyB8IGdyZXAgX2Noa0BAIHwgYXdrIjtpOjI2MjtzOjQwOiJmaW5kIC8gLW5hbWUgLnNzaCA+ICRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjI2MztzOjMzOiJyZS5maW5kYWxsKGRpcnQrJyguKiknLHByb2dubSlbMF0iO2k6MjY0O3M6NjA6Im91dHN0ciArPSBzdHJpbmcuRm9ybWF0KCI8YSBocmVmPSc/ZmRpcj17MH0nPnsxfS88L2E+Jm5ic3A7IiI7aToyNjU7czo4MzoiPCU9UmVxdWVzdC5TZXJ2ZXJ2YXJpYWJsZXMoIlNDUklQVF9OQU1FIiklPj90eHRwYXRoPTwlPVJlcXVlc3QuUXVlcnlTdHJpbmcoInR4dHBhdGgiO2k6MjY2O3M6NzE6IlJlc3BvbnNlLldyaXRlKFNlcnZlci5IdG1sRW5jb2RlKHRoaXMuRXhlY3V0ZUNvbW1hbmQodHh0Q29tbWFuZC5UZXh0KSkpIjtpOjI2NztzOjExMToibmV3IEZpbGVTdHJlYW0oUGF0aC5Db21iaW5lKGZpbGVJbmZvLkRpcmVjdG9yeU5hbWUsIFBhdGguR2V0RmlsZU5hbWUoaHR0cFBvc3RlZEZpbGUuRmlsZU5hbWUpKSwgRmlsZU1vZGUuQ3JlYXRlIjtpOjI2ODtzOjkwOiJSZXNwb25zZS5Xcml0ZSgiPGJyPiggKSA8YSBocmVmPT90eXBlPTEmZmlsZT0iICYgc2VydmVyLlVSTGVuY29kZShpdGVtLnBhdGgpICYgIlw+IiAmIGl0ZW0iO2k6MjY5O3M6MTA0OiJzcWxDb21tYW5kLlBhcmFtZXRlcnMuQWRkKCgoVGFibGVDZWxsKWRhdGFHcmlkSXRlbS5Db250cm9sc1swXSkuVGV4dCwgU3FsRGJUeXBlLkRlY2ltYWwpLlZhbHVlID0gZGVjaW1hbCI7aToyNzA7czo2NDoiPCU9ICJcIiAmIG9TY3JpcHROZXQuQ29tcHV0ZXJOYW1lICYgIlwiICYgb1NjcmlwdE5ldC5Vc2VyTmFtZSAlPiI7aToyNzE7czo1MDoiY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgImh0dHA6Ly8kaG9zdDoyMDgyIikiO2k6MjcyO3M6NTg6IkhKM0hqdXRja29SZnBYZjlBMXpRTzJBd0RSclJleTl1R3ZUZWV6NzlxQWFvMWEwcmd1ZGtaa1I4UmEiO2k6MjczO3M6MzE6IiRpbmlbJ3VzZXJzJ10gPSBhcnJheSgncm9vdCcgPT4iO2k6Mjc0O3M6MTg6InByb2Nfb3BlbignSUhTdGVhbSI7aToyNzU7czoyNDoiJGJhc2xpaz0kX1BPU1RbJ2Jhc2xpayddIjtpOjI3NjtzOjMwOiJmcmVhZCgkZnAsIGZpbGVzaXplKCRmaWNoZXJvKSkiO2k6Mjc3O3M6Mzk6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kKzMrOHF2cXFTMUswK0FYWSI7aToyNzg7czoxNjoieyRfUE9TVFsncm9vdCddfSI7aToyNzk7czoyOToifWVsc2VpZigkX0dFVFsncGFnZSddPT0nZGRvcyciO2k6MjgwO3M6MTQ6IlRoZSBEYXJrIFJhdmVyIjtpOjI4MTtzOjM5OiIkdmFsdWUgPX4gcy8lKC4uKS9wYWNrKCdjJyxoZXgoJDEpKS9lZzsiO2k6MjgyO3M6MTE6Ind3dy50MHMub3JnIjtpOjI4MztzOjMwOiJ1bmxlc3Mob3BlbihQRkQsJGdfdXBsb2FkX2RiKSkiO2k6Mjg0O3M6MTI6ImF6ODhwaXgwMHE5OCI7aToyODU7czoxMToic2ggZ28gJDEuJHgiO2k6Mjg2O3M6MjY6InN5c3RlbSgicGhwIC1mIHhwbCAkaG9zdCIpIjtpOjI4NztzOjEzOiJleHBsb2l0Y29va2llIjtpOjI4ODtzOjIxOiI4MCAtYiAkMSAtaSBldGgwIC1zIDgiO2k6Mjg5O3M6MjU6IkhUVFAgZmxvb2QgY29tcGxldGUgYWZ0ZXIiO2k6MjkwO3M6MTU6Ik5JR0dFUlMuTklHR0VSUyI7aToyOTE7czo0NzoiaWYoaXNzZXQoJF9HRVRbJ2hvc3QnXSkmJmlzc2V0KCRfR0VUWyd0aW1lJ10pKXsiO2k6MjkyO3M6ODM6InN1YnByb2Nlc3MuUG9wZW4oY21kLCBzaGVsbCA9IFRydWUsIHN0ZG91dD1zdWJwcm9jZXNzLlBJUEUsIHN0ZGVycj1zdWJwcm9jZXNzLlNURE9VIjtpOjI5MztzOjY5OiJkZWYgZGFlbW9uKHN0ZGluPScvZGV2L251bGwnLCBzdGRvdXQ9Jy9kZXYvbnVsbCcsIHN0ZGVycj0nL2Rldi9udWxsJykiO2k6Mjk0O3M6Njc6InByaW50KCJbIV0gSG9zdDogIiArIGhvc3RuYW1lICsgIiBtaWdodCBiZSBkb3duIVxuWyFdIFJlc3BvbnNlIENvZGUiO2k6Mjk1O3M6NDI6ImNvbm5lY3Rpb24uc2VuZCgic2hlbGwgIitzdHIob3MuZ2V0Y3dkKCkpKyI7aToyOTY7czo1MDoib3Muc3lzdGVtKCdlY2hvIGFsaWFzIGxzPSIubHMuYmFzaCIgPj4gfi8uYmFzaHJjJykiO2k6Mjk3O3M6MzI6InJ1bGVfcmVxID0gcmF3X2lucHV0KCJTb3VyY2VGaXJlIjtpOjI5ODtzOjU3OiJhcmdwYXJzZS5Bcmd1bWVudFBhcnNlcihkZXNjcmlwdGlvbj1oZWxwLCBwcm9nPSJzY3R1bm5lbCIiO2k6Mjk5O3M6NTc6InN1YnByb2Nlc3MuUG9wZW4oJyVzZ2RiIC1wICVkIC1iYXRjaCAlcycgJSAoZ2RiX3ByZWZpeCwgcCI7aTozMDA7czo1OToiJGZyYW1ld29yay5wbHVnaW5zLmxvYWQoIiN7cnBjdHlwZS5kb3duY2FzZX1ycGMiLCBvcHRzKS5ydW4iO2k6MzAxO3M6Mjg6ImlmIHNlbGYuaGFzaF90eXBlID09ICdwd2R1bXAiO2k6MzAyO3M6MTc6Iml0c29rbm9wcm9ibGVtYnJvIjtpOjMwMztzOjQ1OiJhZGRfZmlsdGVyKCd0aGVfY29udGVudCcsICdfYmxvZ2luZm8nLCAxMDAwMSkiO2k6MzA0O3M6OToiPHN0ZGxpYi5oIjtpOjMwNTtzOjU5OiJlY2hvIHkgOyBzbGVlcCAxIDsgfSB8IHsgd2hpbGUgcmVhZCA7IGRvIGVjaG8geiRSRVBMWTsgZG9uZSI7aTozMDY7czoxMToiVk9CUkEgR0FOR08iO2k6MzA3O3M6NzY6ImludDMyKCgoJHogPj4gNSAmIDB4MDdmZmZmZmYpIF4gJHkgPDwgMikgKyAoKCR5ID4+IDMgJiAweDFmZmZmZmZmKSBeICR6IDw8IDQiO2k6MzA4O3M6Njk6IkBjb3B5KCRfRklMRVNbZmlsZU1hc3NdW3RtcF9uYW1lXSwkX1BPU1RbcGF0aF0uJF9GSUxFU1tmaWxlTWFzc11bbmFtZSI7aTozMDk7czo0NjoiZmluZF9kaXJzKCRncmFuZHBhcmVudF9kaXIsICRsZXZlbCwgMSwgJGRpcnMpOyI7aTozMTA7czoyODoiQHNldGNvb2tpZSgiaGl0IiwgMSwgdGltZSgpKyI7aTozMTE7czo1OiJlLyouLyI7aTozMTI7czozNzoiSkhacGMybDBZMjkxYm5RZ1BTQWtTRlJVVUY5RFQwOUxTVVZmViI7aTozMTM7czozNToiMGQwYTBkMGE2NzZjNmY2MjYxNmMyMDI0NmQ3OTVmNzM2ZDciO2k6MzE0O3M6MTk6ImZvcGVuKCcvZXRjL3Bhc3N3ZCciO2k6MzE1O3M6NzY6IiR0c3UyW3JhbmQoMCxjb3VudCgkdHN1MikgLSAxKV0uJHRzdTFbcmFuZCgwLGNvdW50KCR0c3UxKSAtIDEpXS4kdHN1MltyYW5kKDAiO2k6MzE2O3M6MzM6Ii91c3IvbG9jYWwvYXBhY2hlL2Jpbi9odHRwZCAtRFNTTCI7aTozMTc7czoyMDoic2V0IHByb3RlY3QtdGVsbmV0IDAiO2k6MzE4O3M6Mjc6ImF5dSBwcjEgcHIyIHByMyBwcjQgcHI1IHByNiI7aTozMTk7czozMDoiYmluZCBmaWx0IC0gIlwwMDFBQ1RJT04gKlwwMDEiIjtpOjMyMDtzOjUwOiJyZWdzdWIgLWFsbCAtLSAsIFtzdHJpbmcgdG9sb3dlciAkb3duZXJdICIiIG93bmVycyI7aTozMjE7czozNToia2lsbCAtQ0hMRCBcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6MzIyO3M6MTA6ImJpbmQgZGNjIC0iO2k6MzIzO3M6MjQ6InI0YVRjLmRQbnRFL2Z6dFNGMWJIM1JIMCI7aTozMjQ7czoxMzoicHJpdm1zZyAkY2hhbiI7aTozMjU7czoyMjoiYmluZCBqb2luIC0gKiBnb3Bfam9pbiI7aTozMjY7czo0Mzoic2V0IGdvb2dsZShkYXRhKSBbaHR0cDo6ZGF0YSAkZ29vZ2xlKHBhZ2UpXSI7aTozMjc7czoyNjoicHJvYyBodHRwOjpDb25uZWN0IHt0b2tlbn0iO2k6MzI4O3M6MTM6InByaXZtc2cgJG5pY2siO2k6MzI5O3M6MTE6InB1dGJvdCAkYm90IjtpOjMzMDtzOjEyOiJ1bmJpbmQgUkFXIC0iO2k6MzMxO3M6Mjk6Ii0tRENDRElSIFtsaW5kZXggJFVzZXIoJGkpIDJdIjtpOjMzMjtzOjEwOiJDeWJlc3RlcjkwIjtpOjMzMztzOjQxOiJmaWxlX2dldF9jb250ZW50cyh0cmltKCRmWyRfR0VUWydpZCddXSkpOyI7aTozMzQ7czoyMToidW5saW5rKCR3cml0YWJsZV9kaXJzIjtpOjMzNTtzOjI3OiJiYXNlNjRfZGVjb2RlKCRjb2RlX3NjcmlwdCkiO2k6MzM2O3M6MjE6Imx1Y2lmZmVyQGx1Y2lmZmVyLm9yZyI7aTozMzc7czo0ODoiJHRoaXMtPkYtPkdldENvbnRyb2xsZXIoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjMzODtzOjQ3OiIkdGltZV9zdGFydGVkLiRzZWN1cmVfc2Vzc2lvbl91c2VyLnNlc3Npb25faWQoKSI7aTozMzk7czo3NDoiJHBhcmFtIHggJG4uc3Vic3RyICgkcGFyYW0sIGxlbmd0aCgkcGFyYW0pIC0gbGVuZ3RoKCRjb2RlKSVsZW5ndGgoJHBhcmFtKSkiO2k6MzQwO3M6MzY6ImZ3cml0ZSgkZixnZXRfZG93bmxvYWQoJF9HRVRbJ3VybCddKSI7aTozNDE7czo2NToiaHR0cDovLycuJF9TRVJWRVJbJ0hUVFBfSE9TVCddLnVybGRlY29kZSgkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6MzQyO3M6ODA6IndwX3Bvc3RzIFdIRVJFIHBvc3RfdHlwZSA9ICdwb3N0JyBBTkQgcG9zdF9zdGF0dXMgPSAncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjM0MztzOjM3OiIkdXJsID0gJHVybHNbcmFuZCgwLCBjb3VudCgkdXJscyktMSldIjtpOjM0NDtzOjQ3OiJwcmVnX21hdGNoKCcvKD88PVJld3JpdGVSdWxlKS4qKD89XFtMXCxSXD0zMDJcXSI7aTozNDU7czo0NToicHJlZ19tYXRjaCgnIU1JRFB8V0FQfFdpbmRvd3MuQ0V8UFBDfFNlcmllczYwIjtpOjM0NjtzOjYwOiJSMGxHT0RsaEV3QVFBTE1BQUFBQUFQLy8vNXljQU03T1kvLy9uUC8venYvT25QZjM5Ly8vL3dBQUFBQUEiO2k6MzQ3O3M6NjU6InN0cl9yb3QxMygkYmFzZWFbKCRkaW1lbnNpb24qJGRpbWVuc2lvbi0xKSAtICgkaSokZGltZW5zaW9uKyRqKV0pIjtpOjM0ODtzOjc1OiJpZihlbXB0eSgkX0dFVFsnemlwJ10pIGFuZCBlbXB0eSgkX0dFVFsnZG93bmxvYWQnXSkgJiBlbXB0eSgkX0dFVFsnaW1nJ10pKXsiO2k6MzQ5O3M6MTY6Ik1hZGUgYnkgRGVsb3JlYW4iO2k6MzUwO3M6NDY6Im92ZXJmbG93LXk6c2Nyb2xsO1wiPiIuJGxpbmtzLiRodG1sX21mWydib2R5J10iO2k6MzUxO3M6NDM6ImZ1bmN0aW9uIHVybEdldENvbnRlbnRzKCR1cmwsICR0aW1lb3V0ID0gNSkiO2k6MzUyO3M6NjoiZDNsZXRlIjtpOjM1MztzOjE1OiJsZXRha3Nla2FyYW5nKCkiO2k6MzU0O3M6ODoiWUVOSTNFUkkiO2k6MzU1O3M6MjE6IiRPT08wMDAwMDA9dXJsZGVjb2RlKCI7aTozNTY7czoyMDoiLUkvdXNyL2xvY2FsL2JhbmRtaW4iO2k6MzU3O3M6Mzc6ImZ3cml0ZSgkZnBzZXR2LCBnZXRlbnYoIkhUVFBfQ09PS0lFIikiO2k6MzU4O3M6MjU6Imlzc2V0KCRfUE9TVFsnZXhlY2dhdGUnXSkiO2k6MzU5O3M6MTU6IldlYmNvbW1hbmRlciBhdCI7aTozNjA7czoxNDoiPT0gImJpbmRzaGVsbCIiO2k6MzYxO3M6ODoiUGFzaGtlbGEiO2k6MzYyO3M6MjU6ImNyZWF0ZUZpbGVzRm9ySW5wdXRPdXRwdXQiO2k6MzYzO3M6NjoiTTRsbDNyIjtpOjM2NDtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTozNjU7czo3OiJPb05fQm95IjtpOjM2NjtzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM2NztzOjg6ImRhcmttaW56IjtpOjM2ODtzOjU6IlplZDB4IjtpOjM2OTtzOjQwOiJhYmFjaG98YWJpemRpcmVjdG9yeXxhYm91dHxhY29vbnxhbGV4YW5hIjtpOjM3MDtzOjM2OiJwcGN8bWlkcHx3aW5kb3dzIGNlfG10a3xqMm1lfHN5bWJpYW4iO2k6MzcxO3M6NDc6IkBjaHIoKCRoWyRlWyRvXV08PDQpKygkaFskZVsrKyRvXV0pKTt9fWV2YWwoJGQpIjtpOjM3MjtzOjExOiIkc2gzbGxDb2xvciI7aTozNzM7czoxMDoiUHVua2VyMkJvdCI7aTozNzQ7czoxODoiPD9waHAgZWNobyAiIyEhIyI7IjtpOjM3NTtzOjc1OiIkaW09c3Vic3RyKCRpbSwwLCRpKS5zdWJzdHIoJGltLCRpMisxLCRpNC0oJGkyKzEpKS5zdWJzdHIoJGltLCRpNCsxMixzdHJsZW4iO2k6Mzc2O3M6NTU6IigkaW5kYXRhLCRiNjQ9MSl7aWYoJGI2ND09MSl7JGNkPWJhc2U2NF9kZWNvZGUoJGluZGF0YSkiO2k6Mzc3O3M6MTc6IigkX1BPU1RbImRpciJdKSk7IjtpOjM3ODtzOjE3OiJIYWNrZWQgQnkgRW5ETGVTcyI7aTozNzk7czoxMDoiYW5kZXh8b29nbCI7aTozODA7czoxMDoibmRyb2l8aHRjXyI7aTozODE7czoxMDoiPGRvdD5JcklzVCI7aTozODI7czoyMToiN1AxdGQrTldsaWFJL2hXa1o0Vlg5IjtpOjM4MztzOjE1OiJOaW5qYVZpcnVzIEhlcmUiO2k6Mzg0O3M6MzI6IiRpbT1zdWJzdHIoJHR4LCRwKzIsJHAyLSgkcCsyKSk7IjtpOjM4NTtzOjY6IjN4cDFyMyI7aTozODY7czoyMDoiJG1kNT1tZDUoIiRyYW5kb20iKTsiO2k6Mzg3O3M6Mjg6Im9UYXQ4RDNEc0U4JyZ+aFUwNkNDSDU7JGdZU3EiO2k6Mzg4O3M6MTI6IkdJRjg5QTs8P3BocCI7aTozODk7czoxNToiQ3JlYXRlZCBCeSBFTU1BIjtpOjM5MDtzOjM0OiJQYXNzd29yZDo8cz4iLiRfUE9TVFs8cT5wYXNzd2Q8cT5dIjtpOjM5MTtzOjE1OiJOZXRAZGRyZXNzIE1haWwiO2k6MzkyO3M6MjQ6IiRpc2V2YWxmdW5jdGlvbmF2YWlsYWJsZSI7aTozOTM7czoxMToiQmFieV9EcmFrb24iO2k6Mzk0O3M6MzA6ImZ3cml0ZShmb3BlbihkaXJuYW1lKF9fRklMRV9fKSI7aTozOTU7czoxMzoiXV0pKTt9fWV2YWwoJCI7aTozOTY7czoyNzoiZXJlZ19yZXBsYWNlKDxxPiZlbWFpbCY8cT4sIjtpOjM5NztzOjE5OiIpOyAkaSsrKSRyZXQuPWNocigkIjtpOjM5ODtzOjU3OiIkcGFyYW0ybWFzay4iKVw9W1w8cXE+XCJdKC4qPykoPz1bXDxxcT5cIl0gKVtcPHFxPlwiXS9zaWUiO2k6Mzk5O3M6OToiLy9yYXN0YS8vIjtpOjQwMDtzOjIwOiI8IS0tQ09PS0lFIFVQREFURS0tPiI7aTo0MDE7czoxMzoicHJvZmV4b3IuaGVsbCI7aTo0MDI7czoxMzoiTWFnZWxhbmdDeWJlciI7aTo0MDM7czo4OiJaT0JVR1RFTCI7aTo0MDQ7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjQwNTtzOjg6IlNfXUBfXlVeIjtpOjQwNjtzOjEzOiJAJF9QT1NUWyhjaHIoIjtpOjQwNztzOjEyOiJaZXJvRGF5RXhpbGUiO2k6NDA4O3M6MTI6IlN1bHRhbkhhaWthbCI7aTo0MDk7czoxMToiQ291cGRlZ3JhY2UiO2k6NDEwO3M6OToiYXJ0aWNrbGVAIjtpOjQxMTtzOjE1OiJnbml0cm9wZXJfcm9ycmUiO2k6NDEyO3M6MjM6ImN1dHRlclthdF1yZWFsLnhha2VwLnJ1IjtpOjQxMztzOjI5OiJpZigkd3BfX3dwPUBnemluZmxhdGUoJHdwX193cCI7aTo0MTQ7czo2OiJyMDBuaXgiO2k6NDE1O3M6MjE6IiRmdWxsX3BhdGhfdG9fZG9vcndheSI7aTo0MTY7czozMDoiPGI+RG9uZSA9PT4gJHVzZXJmaWxlX25hbWU8L2I+IjtpOjQxNztzOjEyOiI+RGFyayBTaGVsbDwiO2k6NDE4O3M6MTU6Ii8uLi8qL2luZGV4LnBocCI7aTo0MTk7czozMjoiaWYoaXNfdXBsb2FkZWRfZmlsZS8qOyovKCRfRklMRVMiO2k6NDIwO3M6MjM6ImV4ZWMoJGNvbW1hbmQsICRvdXRwdXQpIjtpOjQyMTtzOjIwOiJAaW5jbHVkZV9vbmNlKCcvdG1wLyI7aTo0MjI7czo4MToidHJpbSgnaHR0cDovLycuJHNjLjxxcT4/Q29tbWFuZD1HZXRGb2xkZXJzQW5kRmlsZXMmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9JTJGJTAwIjtpOjQyMztzOjU5OiIkc2NyaXB0X2ZpbmQgPSBzdHJfcmVwbGFjZSgibG9hZGVyIiwgImZpbmQiLCAkc2NyaXB0X2xvYWRlciI7aTo0MjQ7czoxODoiPHRpdGxlPi4vSGFja2VkIEJ5Ijt9"));
$gX_DBShe = unserialize(base64_decode("YTo2Mzp7aTowO3M6ODoiRmlsZXNNYW4iO2k6MTtzOjc6ImRlZmFjZXIiO2k6MjtzOjI0OiJZb3UgY2FuIHB1dCBhIG1kNSBzdHJpbmciO2k6MztzOjg6InBocHNoZWxsIjtpOjQ7czo2MjoiPGRpdiBjbGFzcz0iYmxvY2sgYnR5cGUxIj48ZGl2IGNsYXNzPSJkdG9wIj48ZGl2IGNsYXNzPSJkYnRtIj4iO2k6NTtzOjg6ImM5OXNoZWxsIjtpOjY7czo4OiJyNTdzaGVsbCI7aTo3O3M6NzoiTlREYWRkeSI7aTo4O3M6ODoiY2loc2hlbGwiO2k6OTtzOjc6IkZ4Yzk5c2giO2k6MTA7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjExO3M6MTE6ImRldmlselNoZWxsIjtpOjEyO3M6MjU6IkhhY2tlZCBieSBBbGZhYmV0b1ZpcnR1YWwiO2k6MTM7czo4OiJOM3RzaGVsbCI7aToxNDtzOjExOiJTdG9ybTdTaGVsbCI7aToxNTtzOjExOiJMb2N1czdTaGVsbCI7aToxNjtzOjEyOiJyNTdzaGVsbC5waHAiO2k6MTc7czo5OiJhbnRpc2hlbGwiO2k6MTg7czo5OiJyb290c2hlbGwiO2k6MTk7czoxMToibXlzaGVsbGV4ZWMiO2k6MjA7czo4OiJTaGVsbCBPayI7aToyMTtzOjE0OiJleGVjKCJybSAtciAtZiI7aToyMjtzOjE4OiJOZSB1ZGFsb3MgemFncnV6aXQiO2k6MjM7czo1MToiJG1lc3NhZ2UgPSBlcmVnX3JlcGxhY2UoIiU1QyUyMiIsICIlMjIiLCAkbWVzc2FnZSk7IjtpOjI0O3M6MTk6InByaW50ICJTcGFtZWQnPjxicj4iO2k6MjU7czo0MDoic2V0Y29va2llKCAibXlzcWxfd2ViX2FkbWluX3VzZXJuYW1lIiApOyI7aToyNjtzOjM3OiJlbHNlaWYoZnVuY3Rpb25fZXhpc3RzKCJzaGVsbF9leGVjIikpIjtpOjI3O3M6NTk6ImlmIChpc19jYWxsYWJsZSgiZXhlYyIpIGFuZCAhaW5fYXJyYXkoImV4ZWMiLCRkaXNhYmxlZnVuYykpIjtpOjI4O3M6MzQ6ImlmICgoJHBlcm1zICYgMHhDMDAwKSA9PSAweEMwMDApIHsiO2k6Mjk7czoxMDoiZGlyIC9PRyAvWCI7aTozMDtzOjM2OiJpbmNsdWRlKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSkiO2k6MzE7czo3OiJicjB3czNyIjtpOjMyO3M6NDk6IidodHRwZC5jb25mJywndmhvc3RzLmNvbmYnLCdjZmcucGhwJywnY29uZmlnLnBocCciO2k6MzM7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aTozNDtzOjIzOiJldmFsKGZpbGVfZ2V0X2NvbnRlbnRzKCI7aTozNTtzOjE4OiJpc193cml0YWJsZSgiL3Zhci8iO2k6MzY7czoxNDoiJEdMT0JBTFNbJ19fX18iO2k6Mzc7czo1NToiaXNfY2FsbGFibGUoJ2V4ZWMnKSBhbmQgIWluX2FycmF5KCdleGVjJywgJGRpc2FibGVmdW5jcyI7aTozODtzOjY6ImswZC5jYyI7aTozOTtzOjI2OiJnbWFpbC1zbXRwLWluLmwuZ29vZ2xlLmNvbSI7aTo0MDtzOjc6IndlYnIwMHQiO2k6NDE7czoxMToiRGV2aWxIYWNrZXIiO2k6NDI7czo3OiJEZWZhY2VyIjtpOjQzO3M6MTE6IlsgUGhwcm94eSBdIjtpOjQ0O3M6ODoiW2NvZGVyel0iO2k6NDU7czozMjoiPCEtLSNleGVjIGNtZD0iJEhUVFBfQUNDRVBUIiAtLT4iO2k6NDY7czoxMjoiXVtyb3VuZCgwKV0oIjtpOjQ3O3M6MTE6IlNpbUF0dGFja2VyIjtpOjQ4O3M6MTU6IkRhcmtDcmV3RnJpZW5kcyI7aTo0OTtzOjc6ImsybGwzM2QiO2k6NTA7czo3OiJLa0sxMzM3IjtpOjUxO3M6MTU6IkhBQ0tFRCBCWSBTVE9STSI7aTo1MjtzOjE0OiJNZXhpY2FuSGFja2VycyI7aTo1MztzOjE1OiJNci5TaGluY2hhblgxOTYiO2k6NTQ7czo5OiJEZWlkYXJhflgiO2k6NTU7czoxMDoiSmlucGFudG9teiI7aTo1NjtzOjk6IjFuNzNjdDEwbiI7aTo1NztzOjE0OiJLaW5nU2tydXBlbGxvcyI7aTo1ODtzOjEwOiJKaW5wYW50b216IjtpOjU5O3M6OToiQ2VuZ2l6SGFuIjtpOjYwO3M6OToicjN2M25nNG5zIjtpOjYxO3M6OToiQkxBQ0tVTklYIjtpOjYyO3M6OToiYXJ0aWNrbGVAIjt9"));
$g_FlexDBShe = unserialize(base64_decode("YTozMDQ6e2k6MDtzOjEwMDoiSU86OlNvY2tldDo6SU5FVC0+bmV3XChQcm90b1xzKj0+XHMqInRjcCJccyosXHMqTG9jYWxQb3J0XHMqPT5ccyozNjAwMFxzKixccypMaXN0ZW5ccyo9PlxzKlNPTUFYQ09OTiI7aToxO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjM7czoxMToiYnlccytHcmluYXkiO2k6NDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjU7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjY7czozNToiZGVmYXVsdF9hY3Rpb25ccyo9XHMqXFxbJyJdRmlsZXNNYW4iO2k6NztzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6ODtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6OTtzOjc0OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX0hPU1RbJyJdXHMqXF1ccypcKSI7aToxMDtzOjEwNzoid3NvRXhccypcKFxzKlxcWyciXVxzKnRhclxzKmNmenZccypcXFsnIl1ccypcLlxzKmVzY2FwZXNoZWxsYXJnXHMqXChccypcJF9QT1NUXFtccypcXFsnIl1wMlxcWyciXVxzKlxdXHMqXCkiO2k6MTE7czo0MDoiZXZhbFxzKlwoKlxzKmJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyI7aToxMjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MTM7czo3NDoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXWZpbGVwYXRoWyciXVxzKlxdXHMqXCkiO2k6MTQ7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MTU7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToxNjtzOjg3OiJTRUxFQ1RccysxXHMrRlJPTVxzK215c3FsXC51c2VyXHMrV0hFUkVccytjb25jYXRcKFxzKmB1c2VyYFxzKixccyonQCdccyosXHMqYGhvc3RgXHMqXCkiO2k6MTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTg7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxOTtzOjU1OiJ7XHMqXCRccyp7XHMqcGFzc3RocnVccypcKCpccypcJGNtZFxzKlwpXHMqfVxzKn1ccyo8YnI+IjtpOjIwO3M6ODI6InJ1bmNvbW1hbmRccypcKFxzKlsnIl1zaGVsbGhlbHBbJyJdXHMqLFxzKlsnIl0oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl0iO2k6MjE7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyMjtzOjM3OiJcJGxvZ2luXHMqPVxzKkAqcG9zaXhfZ2V0dWlkXCgqXHMqXCkqIjtpOjIzO3M6NDk6IiFAKlwkX1JFUVVFU1RccypcW1xzKlsnIl1jOTlzaF9zdXJsWyciXVxzKlxdXHMqXCkiO2k6MjQ7czo1Mzoic2V0Y29va2llXCgqXHMqWyciXW15c3FsX3dlYl9hZG1pbl91c2VybmFtZVsnIl1ccypcKSoiO2k6MjU7czoxNDM6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1cJGNtZFxzKzE+XHMqL3RtcC9jbWR0ZW1wXHMrMj4mMTtccypjYXRccysvdG1wL2NtZHRlbXA7XHMqcm1ccysvdG1wL2NtZHRlbXBbJyJdXCk7IjtpOjI2O3M6Mjg6IlwkZmVcKFsnIl1cJGNtZFxzKzI+JjFbJyJdXCkiO2k6Mjc7czo5NjoiXCRmdW5jdGlvblxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfWNtZFsnIl17MCwxfVxzKlxdXHMqXCkqIjtpOjI4O3M6OTM6IlwkY21kXHMqPVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccypcKSI7aToyOTtzOjIwOiJldmExW2EtekEtWjAtOV9dK1NpciI7aTozMDtzOjg4OiJcJGluaVxzKlxbXHMqWyciXXswLDF9dXNlcnNbJyJdezAsMX1ccypcXVxzKj1ccyphcnJheVxzKlwoXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKj0+IjtpOjMxO3M6MzM6InByb2Nfb3BlblxzKlwoXHMqWyciXXswLDF9SUhTdGVhbSI7aTozMjtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjMzO3M6ODE6IlxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKlxdXHMqfSI7aTozNDtzOjQ2OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdezAsMX0vXC5cKi9lWyciXXswLDF9IjtpOjM1O3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aTozNjtzOjc0OiJAKnNldGNvb2tpZVxzKlwoKlxzKlsnIl17MCwxfWhpdFsnIl17MCwxfSxccyoxXHMqLFxzKnRpbWVccypcKCpccypcKSpccypcKyI7aTozNztzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aTozODtzOjU5OiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BccypcKCpccypAKlwkXyI7aTozOTtzOjQzOiJmb3BlblxzKlwoKlxzKlsnIl17MCwxfS9ldGMvcGFzc3dkWyciXXswLDF9IjtpOjQwO3M6MjQ6IlwkR0xPQkFMU1xbWyciXXswLDF9X19fXyI7aTo0MTtzOjIxNzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XCkqXHMrYW5kXHMrIWluX2FycmF5XHMqXCgqXHMqWyciXXswLDF9XGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKixccypcJGRpc2FibGVmdW5jcyI7aTo0MjtzOjExMjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccyp0cmltXHMqXChccypcJC4rP1xbXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfS4rP1snIl17MCwxfVxdXF1cKVwpOyI7aTo0MztzOjEzNjoid3BfcG9zdHNccytXSEVSRVxzK3Bvc3RfdHlwZVxzKj1ccypbJyJdezAsMX1wb3N0WyciXXswLDF9XHMrQU5EXHMrcG9zdF9zdGF0dXNccyo9XHMqWyciXXswLDF9cHVibGlzaFsnIl17MCwxfVxzK09SREVSXHMrQllccytgSURgXHMrREVTQyI7aTo0NDtzOjIwOiJleGVjXHMqXChccypbJyJdaXBmdyI7aTo0NTtzOjQyOiJzdHJyZXZcKCpccypbJyJdezAsMX10cmVzc2FbJyJdezAsMX1ccypcKSoiO2k6NDY7czo0OToic3RycmV2XCgqXHMqWyciXXswLDF9ZWRvY2VkXzQ2ZXNhYlsnIl17MCwxfVxzKlwpKiI7aTo0NztzOjcwOiJmdW5jdGlvblxzK3VybEdldENvbnRlbnRzXHMqXCgqXHMqXCR1cmxccyosXHMqXCR0aW1lb3V0XHMqPVxzKlxkK1xzKlwpIjtpOjQ4O3M6NzE6ImZ3cml0ZVxzKlwoKlxzKlwkZnBzZXR2XHMqLFxzKmdldGVudlxzKlwoXHMqWyciXUhUVFBfQ09PS0lFWyciXVxzKlwpXHMqIjtpOjQ5O3M6NjY6Imlzc2V0XHMqXCgqXHMqXCRfUE9TVFxzKlxbXHMqWyciXXswLDF9ZXhlY2dhdGVbJyJdezAsMX1ccypcXVxzKlwpKiI7aTo1MDtzOjIwMDoiVU5JT05ccytTRUxFQ1RccytbJyJdezAsMX0wWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfTxcPyBzeXN0ZW1cKFxcXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW2NwY1xdXCk7ZXhpdDtccypcPz5bJyJdezAsMX1ccyosXHMqMFxzKiwwXHMqLFxzKjBccyosXHMqMFxzK0lOVE9ccytPVVRGSUxFXHMrWyciXXswLDF9XCRbJyJdezAsMX0iO2k6NTE7czoxNDk6IlwkR0xPQkFMU1xbWyciXXswLDF9Lis/WyciXXswLDF9XF09QXJyYXlccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlwpXHMqLFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlwpIjtpOjUyO3M6NzM6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqXFsuKz9cXVw/L2VbJyJdezAsMX1ccyosXHMqc3RyX3JlcGxhY2UiO2k6NTM7czoxMDE6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1cW1xzKlxkK1xzKlxdXChccypcJF9cZCtccyosXHMqX1xkK1xzKlwoXHMqXGQrXHMqXClccypcKVxzKlwpIjtpOjU0O3M6MTE1OiJcJGJlZWNvZGVccyo9QCpmaWxlX2dldF9jb250ZW50c1xzKlwoKlsnIl17MCwxfVxzKlwkdXJscHVyc1xzKlsnIl17MCwxfVwpKlxzKjtccyplY2hvXHMrWyciXXswLDF9XCRiZWVjb2RlWyciXXswLDF9IjtpOjU1O3M6Nzk6IlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0iO2k6NTY7czo0MzoiPFw/cGhwXHMrXCRfRlxzKj1ccypfX0ZJTEVfX1xzKjtccypcJF9YXHMqPSI7aTo1NztzOjY4OiJpZlxzK1woKlxzKm1haWxccypcKFxzKlwkcmVjcFxzKixccypcJHN1YmpccyosXHMqXCRzdHVudFxzKixccypcJGZybSI7aTo1ODtzOjEzOToiaWZccytcKFxzKnN0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL21vb3Rvb2xzXC5qc1snIl1ccypcKVxzKj09PVxzKmZhbHNlXHMrJiZccytzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9jYXB0aW9uXC5qc1snIl17MCwxfSI7aTo1OTtzOjgxOiJldmFsXHMqXCgqXHMqc3RyaXBzbGFzaGVzXHMqXCgqXHMqYXJyYXlfcG9wXCgqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NjA7czoyMjE6ImlmXHMqXCgqXHMqaXNzZXRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF1ccypcKSpccypcKVxzKntccypcJFx3K1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9XHcrWyciXXswLDF9XHMqXF07XHMqZXZhbFxzKlwoKlxzKlwkXHcrXHMqXCkqIjtpOjYxO3M6MTIzOiJwcmVnX3JlcGxhY2VccypcKFxzKlsnIl0vXF5cKHd3d1x8ZnRwXClcXFwuL2lbJyJdXHMqLFxzKlsnIl1bJyJdLFxzKkBcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxzKlxdXHMqXCkiO2k6NjI7czoxMDE6ImlmXHMqXCghZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdcG9zaXhfZ2V0cHd1aWRbJyJdXHMqXClccyomJlxzKiFpbl9hcnJheVxzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkIjtpOjYzO3M6ODg6Ij1ccypwcmVnX3NwbGl0XHMqXChccypbJyJdL1xcLFwoXFwgXCtcKVw/L1snIl0sXHMqQCppbmlfZ2V0XHMqXChccypbJyJdZGlzYWJsZV9mdW5jdGlvbnMiO2k6NjQ7czo0NzoiXCRiXHMqXC5ccypcJHBccypcLlxzKlwkaFxzKlwuXHMqXCRrXHMqXC5ccypcJHYiO2k6NjU7czoyMzoiXChccypbJyJdSU5TSEVMTFsnIl1ccyoiO2k6NjY7czo1NDoiKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl1fX19bJyJdXHMqIjtpOjY3O3M6OTQ6ImFycmF5X3BvcFxzKlwoKlxzKlwkd29ya1JlcGxhY2VccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccyosXHMqXCRjb3VudEtleXNOZXciO2k6Njg7czozNToiaWZccypcKCpccypAKnByZWdfbWF0Y2hccypcKCpccypzdHIiO2k6Njk7czo0MzoiQFwkX0NPT0tJRVxbWyciXXswLDF9c3RhdENvdW50ZXJbJyJdezAsMX1cXSI7aTo3MDtzOjEwNToiZm9wZW5ccypcKCpccypbJyJdaHR0cDovL1snIl1ccypcLlxzKlwkY2hlY2tfZG9tYWluXHMqXC5ccypbJyJdOjgwWyciXVxzKlwuXHMqXCRjaGVja19kb2NccyosXHMqWyciXXJbJyJdIjtpOjcxO3M6NTU6IkAqZ3ppbmZsYXRlXHMqXChccypAKmJhc2U2NF9kZWNvZGVccypcKFxzKkAqc3RyX3JlcGxhY2UiO2k6NzI7czoyODoiZmlsZV9wdXRfY29udGVudHpccypcKCpccypcJCI7aTo3MztzOjg3OiImJlxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoKlxzKlsnIl17MCwxfWdldG14cnJbJyJdezAsMX1cKVxzKlwpXHMqe1xzKkBnZXRteHJyXHMqXCgqXHMqXCQiO2k6NzQ7czo0MToiXCRwb3N0UmVzdWx0XHMqPVxzKmN1cmxfZXhlY1xzKlwoKlxzKlwkY2giO2k6NzU7czoyNToiZnVuY3Rpb25ccytzcWwyX3NhZmVccypcKCI7aTo3NjtzOjg1OiJleGl0XHMqXChccypbJyJdezAsMX08c2NyaXB0PlxzKnNldFRpbWVvdXRccypcKFxzKlxcWyciXXswLDF9ZG9jdW1lbnRcLmxvY2F0aW9uXC5ocmVmIjtpOjc3O3M6Mzg6ImV2YWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXFxcJF9SRVFVRVNUIjtpOjc4O3M6MzY6IiF0b3VjaFwoWyciXXswLDF9XC5cLi9cLlwuL2xhbmd1YWdlLyI7aTo3OTtzOjEwOiJEYzBSSGFbJyJdIjtpOjgwO3M6NjA6ImhlYWRlclxzKlwoWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlwkdG9ccypcLlxzKnVybGRlY29kZSI7aTo4MTtzOjE1NjoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XF1ccyosXHMqWyciXXswLDF9QW5kcm9pZFsnIl17MCwxfVwpXHMqIT09ZmFsc2VccyomJlxzKiFcJF9DT09LSUVcW1snIl17MCwxfWRsZV91c2VyX2lkIjtpOjgyO3M6Mzg6ImVjaG9ccytAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkZ2V0IjtpOjgzO3M6NDc6ImRlZmF1bHRfYWN0aW9uXHMqPVxzKlsnIl17MCwxfUZpbGVzTWFuWyciXXswLDF9IjtpOjg0O3M6MzM6ImRlZmluZVxzKlwoXHMqWyciXURFRkNBTExCQUNLTUFJTCI7aTo4NTtzOjE3OiJNeXN0ZXJpb3VzXHMrV2lyZSI7aTo4NjtzOjM0OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdL1wuXCsvZXNpIjtpOjg3O3M6NDU6ImRlZmluZVxzKlwoKlxzKlsnIl1TQkNJRF9SRVFVRVNUX0ZJTEVbJyJdXHMqLCI7aTo4ODtzOjYwOiJcJHRsZFxzKj1ccyphcnJheVxzKlwoXHMqWyciXWNvbVsnIl0sWyciXW9yZ1snIl0sWyciXW5ldFsnIl0iO2k6ODk7czoxNzoiQnJhemlsXHMrSGFja1RlYW0iO2k6OTA7czoxNDU6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpXHMrQU5EXHMrXChtZDVcKFwkX1BPU1RcW1snIl17MCwxfW5pY2tbJyJdezAsMX1cXVwpXHMqPT1ccypbJyJdezAsMX0iO2k6OTE7czo3NToidGltZVwoXClccypcK1xzKjEwMDAwXHMqLFxzKlsnIl0vWyciXVwpO1xzKmVjaG9ccytcJG1feno7XHMqZXZhbFxzKlwoXCRtX3p6IjtpOjkyO3M6MTA2OiJyZXR1cm5ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidlY2hvJ1xzKlwpXHMqPT1ccypmYWxzZVxzKlw/XHMqXChccypzdHJzdHJccypcKFxzKlwkc1xzKixccyoncHJpbnQnIjtpOjkzO3M6Njc6InNldF90aW1lX2xpbWl0XHMqXChccyowXHMqXCk7XHMqaWZccypcKCFTZWNyZXRQYWdlSGFuZGxlcjo6Y2hlY2tLZXkiO2k6OTQ7czo3MzoiQGhlYWRlclwoWyciXUxvY2F0aW9uOlxzKlsnIl1cLlsnIl1oWyciXVwuWyciXXRbJyJdXC5bJyJddFsnIl1cLlsnIl1wWyciXSI7aTo5NTtzOjk6IklyU2VjVGVhbSI7aTo5NjtzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjk3O3M6NzQ6ImNsZWFyc3RhdGNhY2hlXChccypcKTtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRmbGRccypcKVxzKlwpXHMqcmV0dXJuIjtpOjk4O3M6OTc6ImNvbnRlbnQ9WyciXXswLDF9bm8tY2FjaGVbJyJdezAsMX07XHMqXCRjb25maWdcW1snIl17MCwxfWRlc2NyaXB0aW9uWyciXXswLDF9XF1ccypcLj1ccypbJyJdezAsMX0iO2k6OTk7czoxMjoidG1oYXBiemNlcmZmIjtpOjEwMDtzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjEwMTtzOjg3OiJpZlxzKlwoXHMqXCRpXHMqPFxzKlwoXHMqY291bnRccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXFbJyJdezAsMX1ccypcXVxzKlwpXHMqLVxzKjEiO2k6MTAyO3M6MjMyOiJpc3NldFxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmlzX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccypjb3B5XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdIjtpOjEwMztzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjEwNDtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjEwNTtzOjM5OiJldmFsXHMqXCgqXHMqc3RycmV2XHMqXCgqXHMqc3RyX3JlcGxhY2UiO2k6MTA2O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxMDc7czo3MjoiXF5kb3dubG9hZHMvXChcWzAtOVxdXCpcKS9cKFxbMC05XF1cKlwpL1wkXHMrZG93bmxvYWRzXC5waHBcP2M9XCQxJnA9XCQyIjtpOjEwODtzOjkyOiJwcmVnX3JlcGxhY2VccypcKFxzKlwkZXhpZlxbXHMqXFxbJyJdTWFrZVxcWyciXVxzKlxdXHMqLFxzKlwkZXhpZlxbXHMqXFxbJyJdTW9kZWxcXFsnIl1ccypcXSI7aToxMDk7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTEwO3M6NDE6ImZ1bmN0aW9uXHMraW5qZWN0XChcJGZpbGUsXHMqXCRpbmplY3Rpb249IjtpOjExMTtzOjcxOiJleGVjbFwoWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0vYmluL3NoWyciXVxzKixccypbJyJdLWlbJyJdXHMqLFxzKjBcKSI7aToxMTI7czo0MzoiZmluZFxzKy9ccystdHlwZVxzK2ZccystcGVybVxzKy0wNDAwMFxzKy1scyI7aToxMTM7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTE0O3M6NjU6InVybGVuY29kZVwocHJpbnRfclwoYXJyYXlcKFwpLDFcKVwpLDUsMVwpXC5jXCksXCRjXCk7fWV2YWxcKFwkZFwpIjtpOjExNTtzOjg5OiJhcnJheV9rZXlfZXhpc3RzXHMqXChccypcJGZpbGVSYXNccyosXHMqXCRmaWxlVHlwZVwpXHMqXD9ccypcJGZpbGVUeXBlXFtccypcJGZpbGVSYXNccypcXSI7aToxMTY7czo5OToiaWZccypcKFxzKmZ3cml0ZVxzKlwoXHMqXCRoYW5kbGVccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjExNztzOjE3ODoiaWZccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXBhdGhbJyJdezAsMX1ccypcXVxzKj09XHMqWyciXXswLDF9WyciXXswLDF9XHMqXClccyp7XHMqXCR1cGxvYWRmaWxlXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aToxMTg7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTE5O3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMjA7czo1MToiXClccypcLlxzKnN1YnN0clxzKlwoXHMqbWQ1XHMqXChccypzdHJyZXZccypcKFxzKlwkIjtpOjEyMTtzOjI4OiJhc3NlcnRccypcKFxzKkAqc3RyaXBzbGFzaGVzIjtpOjEyMjtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTIzO3M6NTI6ImVjaG9bJyJdezAsMX08Y2VudGVyPjxiPkRvbmVccyo9PT5ccypcJHVzZXJmaWxlX25hbWUiO2k6MTI0O3M6MTM0OiJpZlxzKlwoXCRrZXlccyohPVxzKlsnIl17MCwxfW1haWxfdG9bJyJdezAsMX1ccyomJlxzKlwka2V5XHMqIT1ccypbJyJdezAsMX1zbXRwX3NlcnZlclsnIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfcG9ydCI7aToxMjU7czo1OToic3RycG9zXChcJHVhLFxzKlsnIl17MCwxfXlhbmRleGJvdFsnIl17MCwxfVwpXHMqIT09XHMqZmFsc2UiO2k6MTI2O3M6NDU6ImlmXChDaGVja0lQT3BlcmF0b3JcKFwpXHMqJiZccyohaXNNb2RlbVwoXClcKSI7aToxMjc7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMjg7czoyNzoiZWNob1xzKlsnIl1hbnN3ZXI9ZXJyb3JbJyJdIjtpOjEyOTtzOjMyOiJcJHBvc3Rccyo9XHMqWyciXVxceDc3XFx4NjdcXHg2NSI7aToxMzA7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMzE7czo5OiJJcklzVFwuSXIiO2k6MTMyO3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjEzMztzOjkyOiJjcmVhdGVfZnVuY3Rpb25ccypcKFxzKlsnIl1cJG1bJyJdXHMqLFxzKlsnIl1pZlxzKlwoXHMqXCRtXHMqXFtccyoweDAxXHMqXF1ccyo9PVxzKlsnIl1MWyciXSI7aToxMzQ7czo3MjoiXCRwXHMqPVxzKnN0cnBvc1woXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjEzNTtzOjExMjoiXCR1c2VyX2FnZW50XHMqPVxzKnByZWdfcmVwbGFjZVxzKlwoXHMqWyciXVx8VXNlclxcXC5BZ2VudFxcOlxbXFxzIFxdXD9cfGlbJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkdXNlcl9hZ2VudCI7aToxMzY7czozMToicHJpbnRcKCJcI1xzK2luZm9ccytPS1xcblxcbiJcKSI7aToxMzc7czo1MToiXF1ccyp9XHMqPVxzKnRyaW1ccypcKFxzKmFycmF5X3BvcFxzKlwoXHMqXCR7XHMqXCR7IjtpOjEzODtzOjY0OiJcXT1bJyJdezAsMX1pcFsnIl17MCwxfVxzKjtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkX1NFUlZFUlxbIjtpOjEzOTtzOjM0OiJwcmludFxzKlwkc29jayAiUFJJVk1TRyAiXC5cJG93bmVyIjtpOjE0MDtzOjYzOiJpZlwoL1xeXFw6XCRvd25lciFcLlwqXFxAXC5cKlBSSVZNU0dcLlwqOlwubXNnZmxvb2RcKFwuXCpcKS9cKXsiO2k6MTQxO3M6MjY6IlxbLVxdXHMrQ29ubmVjdGlvblxzK2ZhaWxkIjtpOjE0MjtzOjU0OiI8IS0tXCNleGVjXHMrY21kPVsnIl17MCwxfVwkSFRUUF9BQ0NFUFRbJyJdezAsMX1ccyotLT4iO2k6MTQzO3M6MTY3OiJbJyJdezAsMX1Gcm9tOlxzKlsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9cmVhbG5hbWVbJyJdezAsMX1cXVwuWyciXXswLDF9IFsnIl17MCwxfVwuWyciXXswLDF9IDxbJyJdezAsMX1cLlwkX1BPU1RcW1snIl17MCwxfWZyb21bJyJdezAsMX1cXVwuWyciXXswLDF9PlxcblsnIl17MCwxfSI7aToxNDQ7czo5OToiaWZccypcKFxzKmlzX2RpclxzKlwoXHMqXCRGdWxsUGF0aFxzKlwpXHMqXClccypBbGxEaXJccypcKFxzKlwkRnVsbFBhdGhccyosXHMqXCRGaWxlc1xzKlwpO1xzKn1ccyp9IjtpOjE0NTtzOjc4OiJcJHBccyo9XHMqc3RycG9zXHMqXChccypcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTQ2O3M6MTIzOiJwcmVnX21hdGNoX2FsbFwoWyciXXswLDF9LzxhIGhyZWY9IlxcL3VybFxcXD9xPVwoXC5cK1w/XClcWyZcfCJcXVwrL2lzWyciXXswLDF9LCBcJHBhZ2VcW1snIl17MCwxfWV4ZVsnIl17MCwxfVxdLCBcJGxpbmtzXCkiO2k6MTQ3O3M6ODA6IlwkdXJsXHMqPVxzKlwkdXJsXHMqXC5ccypbJyJdezAsMX1cP1snIl17MCwxfVxzKlwuXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRxdWVyeVwpIjtpOjE0ODtzOjgzOiJwcmludFxzK1wkc29ja1xzK1snIl17MCwxfU5JQ0sgWyciXXswLDF9XHMrXC5ccytcJG5pY2tccytcLlxzK1snIl17MCwxfVxcblsnIl17MCwxfSI7aToxNDk7czozMjoiUFJJVk1TR1wuXCo6XC5vd25lclxcc1wrXChcLlwqXCkiO2k6MTUwO3M6NzU6IlwkcmVzdWx0RlVMXHMqPVxzKnN0cmlwY3NsYXNoZXNccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfXJlc3VsdEZVTFsnIl17MCwxfSI7aToxNTE7czoxNTA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1ccypcKSI7aToxNTI7czo2MDoiaWZccypcKFxzKkAqbWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE1MztzOjk0OiJlY2hvXHMrZmlsZV9nZXRfY29udGVudHNccypcKFxzKmJhc2U2NF91cmxfZGVjb2RlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE1NDtzOjg0OiJmd3JpdGVccypcKFxzKlwkZmhccyosXHMqc3RyaXBzbGFzaGVzXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTU1O3M6ODM6ImlmXHMqXChccyptYWlsXHMqXChccypcJG1haWxzXFtcJGlcXVxzKixccypcJHRlbWFccyosXHMqYmFzZTY0X2VuY29kZVxzKlwoXHMqXCR0ZXh0IjtpOjE1NjtzOjYyOiJcJGd6aXBccyo9XHMqQCpnemluZmxhdGVccypcKFxzKkAqc3Vic3RyXHMqXChccypcJGd6ZW5jb2RlX2FyZyI7aToxNTc7czo3MzoibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyciXXswLDF9ZWxpZlsnIl17MCwxfVxdXFtbJyJdezAsMX10bXBfbmFtZSI7aToxNTg7czo4MDoiaGVhZGVyXChbJyJdezAsMX1zOlxzKlsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXHMqXChccypbJyJdezAsMX1uWyciXXswLDF9XHMqXCkiO2k6MTU5O3M6MTI6IkJ5XHMrV2ViUm9vVCI7aToxNjA7czo1NzoiXCRPT08wTzBPMDA9X19GSUxFX187XHMqXCRPTzAwTzAwMDBccyo9XHMqMHgxYjU0MDtccypldmFsIjtpOjE2MTtzOjUyOiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxdIjtpOjE2MjtzOjc3OiJwcmVnX21hdGNoXChbJyJdL1woeWFuZGV4XHxnb29nbGVcfGJvdFwpL2lbJyJdLFxzKmdldGVudlwoWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxNjM7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6MTY0O3M6NDI6ImZzb2Nrb3BlblxzKlwoXHMqXCRDb25uZWN0QWRkcmVzc1xzKixccyoyNSI7aToxNjU7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aToxNjY7czo2MzoiXCR1cmxbJyJdezAsMX1ccypcLlxzKlwkc2Vzc2lvbl9pZFxzKlwuXHMqWyciXXswLDF9L2xvZ2luXC5odG1sIjtpOjE2NztzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aToxNjg7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNjk7czozMzoiZGllXHMqXChccypQSFBfT1NccypcLlxzKmNoclxzKlwoIjtpOjE3MDtzOjE5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChbJyJdWyciXVxzKixccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpIjtpOjE3MTtzOjgwOiJcJGhlYWRlcnNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWhlYWRlcnNbJyJdezAsMX1cXSI7aToxNzI7czo4NjoiZmlsZV9wdXRfY29udGVudHNccypcKFsnIl17MCwxfTFcLnR4dFsnIl17MCwxfVxzKixccypwcmludF9yXHMqXChccypcJF9QT1NUXHMqLFxzKnRydWUiO2k6MTczO3M6MzU6ImZ3cml0ZVxzKlwoXHMqXCRmbHdccyosXHMqXCRmbFxzKlwpIjtpOjE3NDtzOjM4OiJcJHN5c19wYXJhbXNccyo9XHMqQCpmaWxlX2dldF9jb250ZW50cyI7aToxNzU7czo1MToiXCRhbGxlbWFpbHNccyo9XHMqQHNwbGl0XCgiXFxuIlxzKixccypcJGVtYWlsbGlzdFwpIjtpOjE3NjtzOjUwOiJmaWxlX3B1dF9jb250ZW50c1woU1ZDX1NFTEZccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aToxNzc7czo1NzoiY3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxccypcJG9wdFxbMVxdXHMqXC5ccypcJG9wdFxbNFxdIjtpOjE3ODtzOjk1OiI8c2NyaXB0XHMrdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccytzcmM9WyciXXswLDF9anF1ZXJ5LXVcLmpzWyciXXswLDF9Pjwvc2NyaXB0PiI7aToxNzk7czoyODoiVVJMPTxcP2VjaG9ccytcJGluZGV4O1xzK1w/PiI7aToxODA7czoyMzoiXCNccypzZWN1cml0eXNwYWNlXC5jb20iO2k6MTgxO3M6MTg6IlwjXHMqc3RlYWx0aFxzKmJvdCI7aToxODI7czoyMToiQXBwbGVccytTcEFtXHMrUmVadWxUIjtpOjE4MztzOjUyOiJpc193cml0YWJsZVwoXCRkaXJcLlsnIl13cC1pbmNsdWRlcy92ZXJzaW9uXC5waHBbJyJdIjtpOjE4NDtzOjQyOiJpZlwoZW1wdHlcKFwkX0NPT0tJRVxbWyciXXhbJyJdXF1cKVwpe2VjaG8iO2k6MTg1O3M6Mjk6IlwpXF07fWlmXChpc3NldFwoXCRfU0VSVkVSXFtfIjtpOjE4NjtzOjY2OiJpZlwoQFwkdmFyc1woZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXHMqXD9ccypzdHJpcHNsYXNoZXNcKFwkdXJpXCkiO2k6MTg3O3M6MzM6ImJhc2VbJyJdezAsMX1cLlwoXGQrXHMqXCpccypcZCtcKSI7aToxODg7czo3NToiXCRwYXJhbVxzKj1ccypcJHBhcmFtXHMqeFxzKlwkblwuc3Vic3RyXHMqXChcJHBhcmFtXHMqLFxzKmxlbmd0aFwoXCRwYXJhbVwpIjtpOjE4OTtzOjUzOiJyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblwoXHMqWyciXXswLDF9cmVhZF9hbnNfY29kZSI7aToxOTA7czozNToiYmFzZTY0X2RlY29kZVwoXCRfUE9TVFxbWyciXXswLDF9Xy0iO2k6MTkxO3M6NTQ6ImlmXChpc3NldFwoXCRfUE9TVFxbWyciXXswLDF9bXNnc3ViamVjdFsnIl17MCwxfVxdXClcKSI7aToxOTI7czoxMzM6Im1haWxcKFwkYXJyXFtbJyJdezAsMX10b1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1zdWJqWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfW1zZ1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1oZWFkWyciXXswLDF9XF1cKTsiO2k6MTkzO3M6Mzg6ImZpbGVfZ2V0X2NvbnRlbnRzXCh0cmltXChcJGZcW1wkX0dFVFxbIjtpOjE5NDtzOjYwOiJpbmlfZ2V0XChbJyJdezAsMX1maWx0ZXJcLmRlZmF1bHRfZmxhZ3NbJyJdezAsMX1cKVwpe2ZvcmVhY2giO2k6MTk1O3M6NTA6ImNodW5rX3NwbGl0XChiYXNlNjRfZW5jb2RlXChmcmVhZFwoXCR7XCR7WyciXXswLDF9IjtpOjE5NjtzOjUyOiJcJHN0cj1bJyJdezAsMX08aDE+NDAzXHMrRm9yYmlkZGVuPC9oMT48IS0tXHMqdG9rZW46IjtpOjE5NztzOjMzOiI8XD9waHBccytyZW5hbWVcKFsnIl13c29cLnBocFsnIl0iO2k6MTk4O3M6NjQ6IlwkW2EtekEtWjAtOV9dKy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKy9cKi57MSwxMH1cKi8iO2k6MTk5O3M6NTE6IkAqbWFpbFwoXCRtb3NDb25maWdfbWFpbGZyb20sIFwkbW9zQ29uZmlnX2xpdmVfc2l0ZSI7aToyMDA7czo5NToiXCR0PVwkcztccypcJG9ccyo9XHMqWyciXVsnIl07XHMqZm9yXChcJGk9MDtcJGk8c3RybGVuXChcJHRcKTtcJGlcK1wrXCl7XHMqXCRvXHMqXC49XHMqXCR0e1wkaX0iO2k6MjAxO3M6NDc6Im1tY3J5cHRcKFwkZGF0YSwgXCRrZXksIFwkaXYsIFwkZGVjcnlwdCA9IEZBTFNFIjtpOjIwMjtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MjAzO3M6OToidHNvaF9wdHRoIjtpOjIwNDtzOjEyOiJSRVJFRkVSX1BUVEgiO2k6MjA1O3M6MzE6IndlYmlcLnJ1L3dlYmlfZmlsZXMvcGhwX2xpYm1haWwiO2k6MjA2O3M6NDA6InN1YnN0cl9jb3VudFwoZ2V0ZW52XChcXFsnIl1IVFRQX1JFRkVSRVIiO2k6MjA3O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6MjA4O3M6MjU6ImltZyBzcmM9WyciXW9wZXJhMDAwXC5wbmciO2k6MjA5O3M6NDY6ImVjaG9ccyptZDVcKFwkX1BPU1RcW1snIl17MCwxfWNoZWNrWyciXXswLDF9XF0iO2k6MjEwO3M6MzM6ImVWYUxcKFxzKnRyaW1cKFxzKmJhU2U2NF9kZUNvRGVcKCI7aToyMTE7czo0MjoiZnNvY2tvcGVuXChcJG1cWzBcXSxcJG1cWzEwXF0sXCRfLFwkX18sXCRtIjtpOjIxMjtzOjE5OiJbJyJdPT5cJHtcJHtbJyJdXFx4IjtpOjIxMztzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMTQ7czozMDoiOjpbJyJdXC5waHB2ZXJzaW9uXChcKVwuWyciXTo6IjtpOjIxNTtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIxNjtzOjE4OiI9PTBcKXtqc29uUXVpdFwoXCQiO2k6MjE3O3M6NDY6ImxvY1xzKj1ccypbJyJdezAsMX08XD9lY2hvXHMrXCRyZWRpcmVjdDtccypcPz4iO2k6MjE4O3M6Mjg6ImFycmF5XChcJGVuLFwkZXMsXCRlZixcJGVsXCkiO2k6MjE5O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MjIwO3M6MTg6ImZ1Y2tccyt5b3VyXHMrbWFtYSI7aToyMjE7czo3ODoiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl1hY3Rpb25bJyJdXHMqXC5ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjIyMjtzOjU5OiJzdHJfcmVwbGFjZVwoXCRmaW5kXHMqLFxzKlwkZmluZFxzKlwuXHMqXCRodG1sXHMqLFxzKlwkdGV4dCI7aToyMjM7czozMzoiZmlsZV9leGlzdHNccypcKCpccypbJyJdL3Zhci90bXAvIjtpOjIyNDtzOjQxOiImJlxzKiFlbXB0eVwoXHMqXCRfQ09PS0lFXFtbJyJdZmlsbFsnIl1cXSI7aToyMjU7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjIyNjtzOjM1OiJtYWtlX2Rpcl9hbmRfZmlsZVwoXHMqXCRwYXRoX2pvb21sYSI7aToyMjc7czo0MToibGlzdGluZ19wYWdlXChccypub3RpY2VcKFxzKlsnIl1zeW1saW5rZWQiO2k6MjI4O3M6NjI6Imxpc3RccypcKFxzKlwkaG9zdFxzKixccypcJHBvcnRccyosXHMqXCRzaXplXHMqLFxzKlwkZXhlY190aW1lIjtpOjIyOTtzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjIzMDtzOjU4OiJmdW5jdGlvblxzK3JlYWRfcGljXChccypcJEFccypcKVxzKntccypcJGFccyo9XHMqXCRfU0VSVkVSIjtpOjIzMTtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjIzMjtzOjM5OiJcXVxzKlwpe2V2YWxcKFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXCQiO2k6MjMzO3M6NTQ6IkxvY2F0aW9uOjppc0ZpbGVXcml0YWJsZVwoXHMqRW5jb2RlRXhwbG9yZXI6OmdldENvbmZpZyI7aToyMzQ7czoxMzoiYnlccytTaHVuY2VuZyI7aToyMzU7czoxNDoie2V2YWxcKFwke1wkczIiO2k6MjM2O3M6MTg6ImV2YWxcKFwkczIxXChcJHtcJCI7aToyMzc7czoyMToiUmFtWmtpRVxzKy1ccytleHBsb2l0IjtpOjIzODtzOjQ3OiJbJyJdcmVtb3ZlX3NjcmlwdHNbJyJdXHMqPT5ccyphcnJheVwoWyciXVJlbW92ZSI7aToyMzk7czoyODoiXCRiYWNrX2Nvbm5lY3RfcGxccyo9XHMqWyciXSI7aToyNDA7czo0MDoiXCRzaXRlX3Jvb3RcLlwkZmlsZXVucF9kaXJcLlwkZmlsZXVucF9mbiI7aToyNDE7czoyNDoiQHByZWdfcmVwbGFjZVwoWyciXS9hZC9lIjtpOjI0MjtzOjI2OiI8Yj5cJHVpZFxzKlwoXCR1bmFtZVwpPC9iPiI7aToyNDM7czoxMToiRngyOUdvb2dsZXIiO2k6MjQ0O3M6ODoiZW52aXIwbm4iO2k6MjQ1O3M6NDY6ImFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqWyciXVwpLGJhc2U2NF9kZWNvZGUiO2k6MjQ2O3M6Mjg6IjxcPz1ccypAcGhwX3VuYW1lXChcKTtccypcPz4iO2k6MjQ3O3M6MTE6InNVeENyZXdccytWIjtpOjI0ODtzOjE2OiJXYXJCb3RccytzVXhDcmV3IjtpOjI0OTtzOjQzOiJleGVjXChbJyJdY2RccysvdG1wO2N1cmxccystT1xzK1snIl1cLlwkdXJsIjtpOjI1MDtzOjE1OiJCYXRhdmk0XHMrU2hlbGwiO2k6MjUxO3M6MzY6IkBleHRyYWN0XChcJF9SRVFVRVNUXFtbJyJdZngyOXNoY29vayI7aToyNTI7czoxMDoiVHVYX1NoYWRvdyI7aToyNTM7czo0MDoiPUBmb3BlblxzKlwoWyciXXBocFwuaW5pWyciXVxzKixccypbJyJddyI7aToyNTQ7czo5OiJMZWJheUNyZXciO2k6MjU1O3M6Nzk6IlwkaGVhZGVyc1xzKlwuPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZU1haWxBZGRbJyJdXHMqXF0iO2k6MjU2O3M6MTk6ImJvZ2VsXHMqLVxzKmV4cGxvaXQiO2k6MjU3O3M6NTk6IlxbdW5hbWVcXVsnIl1ccypcLlxzKnBocF91bmFtZVwoXHMqXClccypcLlxzKlsnIl1cWy91bmFtZVxdIjtpOjI1ODtzOjMyOiJcXVwoXCRfMSxcJF8xXClcKTtlbHNle1wkR0xPQkFMUyI7aToyNTk7czoxNDoiZmlsZTpmaWxlOi8vLy8iO2k6MjYwO3M6MzI6ImZ1bmN0aW9uXHMrTUNMb2dpblwoXClccyp7XHMqZGllIjtpOjI2MTtzOjU1OiJ7ZWNobyBbJyJdeWVzWyciXTsgZXhpdDt9ZWxzZXtlY2hvIFsnIl1ub1snIl07IGV4aXQ7fX19IjtpOjI2MjtzOjM5OiI7XD8+PFw/PVwke1snIl1fWyciXVwuXCRffVxbWyciXV9bJyJdXF0iO2k6MjYzO3M6NDE6IlwkYVxbMVxdPT1bJyJdYnlwYXNzaXBbJyJdXCk7XCRjPXNlbGY6OmMxIjtpOjI2NDtzOjQyOiJcJGRpclwuWyciXS9bJyJdXC5cJGZcLlsnIl0vd3AtY29uZmlnXC5waHAiO2k6MjY1O3M6MjM6ImV2YWxcKFsnIl1yZXR1cm5ccytldmFsIjtpOjI2NjtzOjkwOiJmd3JpdGVcKFwkW2EtekEtWjAtOV9dKywiXFx4RUZcXHhCQlxceEJGIlwuaWNvbnZcKFsnIl1nYmtbJyJdLFsnIl11dGYtOC8vSUdOT1JFWyciXSxcJGJvZHkiO2k6MjY3O3M6NzI6ImVjaG9ccytbJyJdX19zdWNjZXNzX19bJyJdXHMqXC5ccypcJE5vd1N1YkZvbGRlcnNccypcLlxzKlsnIl1fX3N1Y2Nlc3NfXyI7aToyNjg7czo3Nzoib2Jfc3RhcnRcKFwpO1xzKnZhcl9kdW1wXChcJF9QT1NUXHMqLFxzKlwkX0dFVFxzKixccypcJF9DT09LSUVccyosXHMqXCRfRklMRVMiO2k6MjY5O3M6MzQ6ImdldGVudlwoIkhUVFBfSE9TVCJcKVwuJyB+IFNoZWxsIEkiO2k6MjcwO3M6NDM6ImV2YWwvXCpcKi9cKCJldmFsXChnemluZmxhdGVcKGJhc2U2NF9kZWNvZGUiO2k6MjcxO3M6MjU6ImFzc2VydFwoXCRbYS16QS1aMC05X10rXCgiO2k6MjcyO3M6MTg6IlwkZGVmYWNlcj0nUmVaSzJMTCI7aToyNzM7czoxOToiPCVccypldmFsXHMrcmVxdWVzdCI7aToyNzQ7czozMToibmV3X3RpbWVcKFwkcGF0aDJmaWxlLFwkR0xPQkFMUyI7aToyNzU7czo1MzoiXCRzdHI9c3RyX3JlcGxhY2VcKCJcW3RcZCtcXSJccyosXHMqIjxcPyIsXHMqXCRyZXNcKTsiO2k6Mjc2O3M6OTY6IlwkX19hPSJbYS16QS1aMC05X10rIjtccypcJF9fYVxzKj1ccypzdHJfcmVwbGFjZVwoIlthLXpBLVowLTlfXSsiLFxzKiJbYS16QS1aMC05X10rIixccypcJF9fYVwpOyI7aToyNzc7czo0NDoiPCEtLVx3ezMyfS0tPjxcP3BocFxzKkBvYl9zdGFydFwoXCk7QGluaV9zZXQiO2k6Mjc4O3M6NDI6ImlmXChpc3NldFwoXCRfR0VUXFtwaHBcXVwpXClccyp7XCRmdW5jdGlvbiI7aToyNzk7czoyODoiXCRzXCgiflxbZGlzY3V6XF1+ZSIsXCRfUE9TVCI7aToyODA7czo0MToiUGxnU3lzdGVtWGNhbGVuZGFySGVscGVyOjpnZXRJbnN0YW5jZVwoXCkiO2k6MjgxO3M6NjI6ImlzX2Rpcl9lbXB0eVwoXCRfUE9TVFxbWyciXWRpcmVjdG9yeVsnIl1cXVwpXClccyp7XHMqZWNob1xzKzE7IjtpOjI4MjtzOjEyNjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKkAqXCRfUE9TVFxzKlxbXHMqWyciXS4rP1snIl1ccypcXVxzKlwuXHMqIlxzKjJccyo+XHMqJjFccypbJyJdIjtpOjI4MztzOjg4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXVuYW1lXHMrLWFbJyJdXHMqXCkqIjtpOjI4NDtzOjg5OiJAKmFzc2VydFxzKlwoKlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcXVxzKiI7aToyODU7czoyODoicGhwXHMrWyciXVxzKlwuXHMqXCR3c29fcGF0aCI7aToyODY7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyODc7czo0NToic3lzdGVtXHMqXCgqXHMqWyciXXswLDF9d2hvYW1pWyciXXswLDF9XHMqXCkqIjtpOjI4ODtzOjg4OiJjdXJsX3NldG9wdFxzKlwoXHMqXCRjaFxzKixccypDVVJMT1BUX1VSTFxzKixccypbJyJdezAsMX1odHRwOi8vXCRob3N0OlxkK1snIl17MCwxfVxzKlwpIjtpOjI4OTtzOjQzOiJAXCRzdHJpbmdzXChzdHJfcm90MTNcKCdyaW55XChvbmZyNjRfcXJwYnFyIjtpOjI5MDtzOjY3OiJcJHRoaXMtPnNlcnZlclxzKj1ccypbJyJdaHR0cDovL1snIl1cLlwkdGhpcy0+c2VydmVyXC5bJyJdL2ltZy9cP3E9IjtpOjI5MTtzOjQ3OiJlY2hvXHMqIjxjZW50ZXI+PGI+RG9uZVxzKj09PlxzKlwkdXNlcmZpbGVfbmFtZSI7aToyOTI7czo5NDoiZmlsZV9nZXRfY29udGVudHNcKFwkW2EtekEtWjAtOV9dK1wpO1xzKlthLXpBLVowLTlfXStcKFsnIl1odHRwczovL2RsXC5kcm9wYm94dXNlcmNvbnRlbnRcLmNvbSI7aToyOTM7czo2MDoiaWZcKGZpbGVfZXhpc3RzXChcJG5ld1BhdGhcKVwpXHMqe1xzKmVjaG9ccyoicHVibGlzaCBzdWNjZXNzIjtpOjI5NDtzOjUzOiJmdW5jdGlvblxzK0tpbGxNZVwoXClccyp7XHMqdW5saW5rXChccypNeUZpbGVOYW1lXChcKSI7aToyOTU7czo2MToiPFw/cGhwXHMqZXJyb3JfcmVwb3J0aW5nXChFX0VSUk9SXCk7XHMqXCRyZW1vdGVfcGF0aD0iaHR0cDovLyI7aToyOTY7czo0NDoiZWNob1xzK3BocF91bmFtZVwoXCk7XHMqQHVubGlua1woX19GSUxFX19cKTsiO2k6Mjk3O3M6NTE6Ijx0aXRsZT48XD9waHBccytlY2hvXHMrXCRzaGVsbF90aXRsZTtccytcPz48L3RpdGxlPiI7aToyOTg7czo1NjoiY2hyXChvcmRcKFwkc3RyXFtcJGlcXVwpXHMqXF5ccypcJGtleVwpO1xzKmV2YWxcKFwkZXZcKTsiO2k6Mjk5O3M6MzA6Ilwkd3BfX3dwPVwkd3BfX3dwXChzdHJfcmVwbGFjZSI7aTozMDA7czoxODoiPFw/cGhwXHMqXCR3cF9fd3A9IjtpOjMwMTtzOjI0OiI8XD9waHBccypldmFsXChbJyJdXFx4NjUiO2k6MzAyO3M6NTI6IkBwcmVnX3JlcGxhY2VcKFsnIl0vXChcLlwqXCkvZVsnIl1ccyosXHMqQFwkX1JFUVVFU1QiO2k6MzAzO3M6MjI6Ijx0aXRsZT5XM0xjb21lPC90aXRsZT4iO30="));
$gX_FlexDBShe = unserialize(base64_decode("YTozMDk6e2k6MDtzOjY4OiJmaWxlX2dldF9jb250ZW50c1woU1JWX05BTUVccypcLlxzKlsnIl1cP2FjdGlvbj1nZXRfc2l0ZXMmbm9kYV9uYW1lPSI7aToxO3M6NDA6IkxvY2F0aW9uOlxzKlthLXpBLVowLTlfXStcLmRvY3VtZW50XC5leGUiO2k6MjtzOjQwOiJpZlwoIXByZWdfbWF0Y2hcKFsnIl0vSGFja2VkIGJ5L2lbJyJdLFwkIjtpOjM7czo5OiJCeVxzK0FtIXIiO2k6NDtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjtpOjU7czo0MDoiZXZhbFxzKlwoKlxzKmd6aW5mbGF0ZVxzKlwoKlxzKnN0cl9yb3QxMyI7aTo2O3M6MTA5OiJpZlxzKlwoXHMqaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXCkqIjtpOjc7czoyOToiZXZhbFxzKlwoKlxzKmdldF9vcHRpb25ccypcKCoiO2k6ODtzOjk1OiJhZGRfZmlsdGVyXHMqXCgqXHMqWyciXXswLDF9dGhlX2NvbnRlbnRbJyJdezAsMX1ccyosXHMqWyciXXswLDF9X2Jsb2dpbmZvWyciXXswLDF9XHMqLFxzKi4rP1wpKiI7aTo5O3M6MzI6ImlzX3dyaXRhYmxlXHMqXCgqXHMqWyciXS92YXIvdG1wIjtpOjEwO3M6MjY6InN5bWxpbmtccypcKCpccypbJyJdL2hvbWUvIjtpOjExO3M6OTQ6Imlzc2V0XChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXHMqb3JccypkaWVcKCouKz9cKSoiO2k6MTI7czo0OToiZ3p1bmNvbXByZXNzXHMqXCgqXHMqc3Vic3RyXHMqXCgqXHMqYmFzZTY0X2RlY29kZSI7aToxMztzOjk6IlwkX19fXHMqPSI7aToxNDtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjE1O3M6NzE6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dK1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjE2O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MTc7czozMzoic3ltYmlhblx8bWlkcFx8d2FwXHxwaG9uZVx8cG9ja2V0IjtpOjE4O3M6NDg6ImZ1bmN0aW9uXHMqY2htb2RfUlxzKlwoXHMqXCRwYXRoXHMqLFxzKlwkcGVybVxzKiI7aToxOTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyMDtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6MjE7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjIyO3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjM7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI0O3M6MzU6ImVjaG9ccytbJyJdezAsMX1pbnN0YWxsX29rWyciXXswLDF9IjtpOjI1O3M6MTY6IlNwYW1ccytjb21wbGV0ZWQiO2k6MjY7czo0NDoiYXJyYXlcKFxzKlsnIl1Hb29nbGVbJyJdXHMqLFxzKlsnIl1TbHVycFsnIl0iO2k6Mjc7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6Mjg7czoyMDoiL2VbJyJdXHMqLFxzKlsnIl1cXHgiO2k6Mjk7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6MzA7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MzE7czozNjoicHJlZ19yZXBsYWNlXChccypbJyJdZVsnIl0sWyciXXswLDF9IjtpOjMyO3M6NTM6ImZvcGVuXChbJyJdezAsMX1cLlwuL1wuXC4vXC5cLi9bJyJdezAsMX1cLlwkZmlsZXBhdGhzIjtpOjMzO3M6NTE6IlwkZGF0YVxzKj1ccyphcnJheVwoWyciXXswLDF9dGVybWluYWxbJyJdezAsMX1ccyo9PiI7aTozNDtzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aTozNTtzOjMzOiJwb3J0bGV0cy9mcmFtZXdvcmsvc2VjdXJpdHkvbG9naW4iO2k6MzY7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aTozNztzOjEwNDoic2l0ZV9mcm9tPVsnIl17MCwxfVwuXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1cXVwuWyciXXswLDF9JnNpdGVfZm9sZGVyPVsnIl17MCwxfVwuXCRmXFsxXF0iO2k6Mzg7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6Mzk7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aTo0MDtzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aTo0MTtzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjQyO3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjQzO3M6NDc6ImlmIFwoZGF0ZVwoWyciXXswLDF9alsnIl17MCwxfVwpXHMqLVxzKlwkbmV3c2lkIjtpOjQ0O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo0NTtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjQ2O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NDc7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo0ODtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjQ5O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjUwO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjUxO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjUyO3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo1MztzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjU0O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjU1O3M6MTA0OiJmb3JcKFwkW2EtekEtWjAtOV9dKz1cZCs7XCRbYS16QS1aMC05X10rPFxkKztcJFthLXpBLVowLTlfXSstPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSshPVxkK1wpXHMqYnJlYWs7fSI7aTo1NjtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6NTc7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAKlwkX0NPT0tJRVxbIjtpOjU4O3M6Mzg6InByZWdfcmVwbGFjZVwoXCl7cmV0dXJuXHMrX19GVU5DVElPTl9fIjtpOjU5O3M6Mzk6ImlmXHMqXChjaGVja19hY2NcKFwkbG9naW4sXCRwYXNzLFwkc2VydiI7aTo2MDtzOjM2OiJwcmludFxzK1snIl17MCwxfWRsZV9udWxsZWRbJyJdezAsMX0iO2k6NjE7czo2MzoiaWZcKG1haWxcKFwkZW1haWxcW1wkaVxdLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjYyO3M6MTI6IlRlYU1ccytNb3NUYSI7aTo2MztzOjE0OiJbJyJdezAsMX1EWmUxciI7aTo2NDtzOjE1OiJwYWNrXHMrIlNuQTR4OCIiO2k6NjU7czozMjoiXCRfUG9zdFxbWyciXXswLDF9U1NOWyciXXswLDF9XF0iO2k6NjY7czoyNzoiRXRobmljXHMrQWxiYW5pYW5ccytIYWNrZXJzIjtpOjY3O3M6OToiQnlccytEWjI3IjtpOjY4O3M6NzQ6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWNtZFwuZXhlIjtpOjY5O3M6MTU6IkF1dG9ccypYcGxvaXRlciI7aTo3MDtzOjk6ImJ5XHMrZzAwbiI7aTo3MTtzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjcyO3M6OTQ6ImlmXChpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWNvbnRlbnRbJyJdezAsMX1cKVxzK0FORFxzK2lzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtYWRtaW4iO2k6NzM7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjc0O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aTo3NTtzOjQwOiJzdHJfcmVwbGFjZVxzKlwoXHMqWyciXXswLDF9L3B1YmxpY19odG1sIjtpOjc2O3M6NDE6ImlmXChccyppc3NldFwoXHMqXCRfUkVRVUVTVFxbWyciXXswLDF9Y2lkIjtpOjc3O3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aTo3ODtzOjg1OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9qY2UmdGFzaz1wbHVnaW4mcGx1Z2luPWltZ21hbmFnZXImZmlsZT1pbWdtYW5hZ2VyJnZlcnNpb249XGQrIjtpOjc5O3M6Mzc6InNldGNvb2tpZVwoXHMqXCR6XFswXF1ccyosXHMqXCR6XFsxXF0iO2k6ODA7czozMjoiXCRTXFtcJGlcK1wrXF1cKFwkU1xbXCRpXCtcK1xdXCgiO2k6ODE7czozMjoiXFtcJG9cXVwpO1wkb1wrXCtcKXtpZlwoXCRvPDE2XCkiO2k6ODI7czo4MToidHlwZW9mXHMqXChkbGVfYWRtaW5cKVxzKj09XHMqWyciXXswLDF9dW5kZWZpbmVkWyciXXswLDF9XHMqXHxcfFxzKmRsZV9hZG1pblxzKj09IjtpOjgzO3M6MzY6ImNyZWF0ZV9mdW5jdGlvblwoc3Vic3RyXCgyLDFcKSxcJHNcKSI7aTo4NDtzOjYwOiJwbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwJTNBJTJGJTJGd3d3XC5nb29nbGUiO2k6ODU7czozNjoicmV0dXJuXHMrYmFzZTY0X2RlY29kZVwoXCRhXFtcJGlcXVwpIjtpOjg2O3M6NDU6IlwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo4NztzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6ODg7czozMjoiZXZhbFwoWyciXVw/PlsnIl1cLmJhc2U2NF9kZWNvZGUiO2k6ODk7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6OTA7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aTo5MTtzOjE5OiJncmVwXHMrLXZccytjcm9udGFiIjtpOjkyO3M6MzQ6ImNyYzMyXChccypcJF9QT1NUXFtccypbJyJdezAsMX1jbWQiO2k6OTM7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aTo5NDtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6OTU7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjk2O3M6NDg6IlxzKlsnIl17MCwxfXNsdXJwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfW1zbmJvdCI7aTo5NztzOjIwOiJldmFsXHMqXChccypUUExfRklMRSI7aTo5ODtzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjk5O3M6MTA1OiJcJHBhdGhccyo9XHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF1ccypcLlxzKlsnIl17MCwxfS9pbWFnZXMvc3Rvcmllcy9bJyJdezAsMX0iO2k6MTAwO3M6ODk6Ilwkc2FwZV9vcHRpb25cW1xzKlsnIl17MCwxfWZldGNoX3JlbW90ZV90eXBlWyciXXswLDF9XHMqXF1ccyo9XHMqWyciXXswLDF9c29ja2V0WyciXXswLDF9IjtpOjEwMTtzOjg4OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRuYW1lXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEwMjtzOjgyOiJlcmVnX3JlcGxhY2VcKFsnIl17MCwxfSU1QyUyMlsnIl17MCwxfVxzKixccypbJyJdezAsMX0lMjJbJyJdezAsMX1ccyosXHMqXCRtZXNzYWdlIjtpOjEwMztzOjg1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9dXJbJyJdezAsMX1cXVwpXClccypcJG1vZGVccypcfD1ccyowNDAwIjtpOjEwNDtzOjQxOiIvcGx1Z2lucy9zZWFyY2gvcXVlcnlcLnBocFw/X19fX3BnZmE9aHR0cCI7aToxMDU7czo0OToiQCpmaWxlX3B1dF9jb250ZW50c1woXHMqXCR0aGlzLT5maWxlXHMqLFxzKnN0cnJldiI7aToxMDY7czo0ODoicHJlZ19tYXRjaF9hbGxcKFxzKlsnIl1cfFwoXC5cKlwpPFxcIS0tIGpzLXRvb2xzIjtpOjEwNztzOjMwOiJoZWFkZXJcKFsnIl17MCwxfXI6XHMqbm9ccytjb20iO2k6MTA4O3M6NzU6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1sc1xzKy92YXIvbWFpbCI7aToxMDk7czoyNjoiXCRkb3JfY29udGVudD1wcmVnX3JlcGxhY2UiO2k6MTEwO3M6MjM6Il9fdXJsX2dldF9jb250ZW50c1woXCRsIjtpOjExMTtzOjUzOiJcJEdMT0JBTFNcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwoXHMqTlVMTCI7aToxMTI7czo2MjoidW5hbWVcXVsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXChcKVxzKlwuXHMqWyciXXswLDF9XFsvdW5hbWUiO2k6MTEzO3M6MzM6IkBcJGZ1bmNcKFwkY2ZpbGUsIFwkY2RpclwuXCRjbmFtZSI7aToxMTQ7czozNToiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rXChccypcJDxhbWMiO2k6MTE1O3M6NzE6IlwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrXHMqXF1cKFwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrIjtpOjExNjtzOjI5OiJlcmVnaVwoXHMqc3FsX3JlZ2Nhc2VcKFxzKlwkXyI7aToxMTc7czo0MDoiXCNVc2VbJyJdezAsMX1ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKCI7aToxMTg7czoyMDoibWtkaXJcKFxzKlsnIl0vaG9tZS8iO2k6MTE5O3M6MjA6ImZvcGVuXChccypbJyJdL2hvbWUvIjtpOjEyMDtzOjM2OiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XCgiO2k6MTIxO3M6NDQ6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdezAsMX1cLi9saWJ3b3JrZXJcLnNvIjtpOjEyMjtzOjY0OiJcIyEvYmluL3NobmNkXHMrWyciXXswLDF9WyciXXswLDF9XC5cJFNDUFwuWyciXXswLDF9WyciXXswLDF9bmlmIjtpOjEyMztzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdezAsMX1hdFxzK25vd1xzKy1mIjtpOjEyNDtzOjMzOiJjcm9udGFiXHMrLWxcfGdyZXBccystdlxzK2Nyb250YWIiO2k6MTI1O3M6MTQ6IkRhdmlkXHMqQmxhaW5lIjtpOjEyNjtzOjIzOiJleHBsb2l0LWRiXC5jb20vc2VhcmNoLyI7aToxMjc7czozNjoiZmlsZV9wdXRfY29udGVudHNcKFxzKlsnIl17MCwxfS9ob21lIjtpOjEyODtzOjYwOiJtYWlsXChccypcJE1haWxUb1xzKixccypcJE1lc3NhZ2VTdWJqZWN0XHMqLFxzKlwkTWVzc2FnZUJvZHkiO2k6MTI5O3M6MTE3OiJcJGNvbnRlbnRccyo9XHMqaHR0cF9yZXF1ZXN0XChbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XHMqXC5ccypcJF9TRVJWRVJcW1snIl17MCwxfVNFUlZFUl9OQU1FWyciXXswLDF9XF1cLlsnIl17MCwxfS8iO2k6MTMwO3M6Nzg6IiFmaWxlX3B1dF9jb250ZW50c1woXHMqXCRkYm5hbWVccyosXHMqXCR0aGlzLT5nZXRJbWFnZUVuY29kZWRUZXh0XChccypcJGRibmFtZSI7aToxMzE7czo0NDoic2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTMyO3M6NzI6InNlbmRfc210cFwoXHMqXCRlbWFpbFxbWyciXXswLDF9YWRyWyciXXswLDF9XF1ccyosXHMqXCRzdWJqXHMqLFxzKlwkdGV4dCI7aToxMzM7czo0NjoiPVwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMzQ7czo1MjoidG91Y2hcKFxzKlsnIl17MCwxfVwkYmFzZXBhdGgvY29tcG9uZW50cy9jb21fY29udGVudCI7aToxMzU7czoyNzoiXChbJyJdXCR0bXBkaXIvc2Vzc19mY1wubG9nIjtpOjEzNjtzOjM1OiJmaWxlX2V4aXN0c1woXHMqWyciXS90bXAvdG1wLXNlcnZlciI7aToxMzc7czo0OToibWFpbFwoXHMqXCRyZXRvcm5vXHMqLFxzKlwkYXN1bnRvXHMqLFxzKlwkbWVuc2FqZSI7aToxMzg7czo4MjoiXCRVUkxccyo9XHMqXCR1cmxzXFtccypyYW5kXChccyowXHMqLFxzKmNvdW50XChccypcJHVybHNccypcKVxzKi1ccyoxXClccypcXVwucmFuZCI7aToxMzk7czo0MDoiX19maWxlX2dldF91cmxfY29udGVudHNcKFxzKlwkcmVtb3RlX3VybCI7aToxNDA7czoxMzoiPWJ5XHMrRFJBR09OPSI7aToxNDE7czo5ODoic3Vic3RyXChccypcJHN0cmluZzJccyosXHMqc3RybGVuXChccypcJHN0cmluZzJccypcKVxzKi1ccyo5XHMqLFxzKjlcKVxzKj09XHMqWyciXXswLDF9XFtsLHI9MzAyXF0iO2k6MTQyO3M6MzM6IlxbXF1ccyo9XHMqWyciXVJld3JpdGVFbmdpbmVccytvbiI7aToxNDM7czo3NToiZndyaXRlXChccypcJGZccyosXHMqZ2V0X2Rvd25sb2FkXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE0NDtzOjQ3OiJ0YXJccystY3pmXHMrIlxzKlwuXHMqXCRGT1JNe3Rhcn1ccypcLlxzKiJcLnRhciI7aToxNDU7czoxMToic2NvcGJpblsnIl0iO2k6MTQ2O3M6NjY6IjxkaXZccytpZD1bJyJdbGluazFbJyJdPjxidXR0b24gb25jbGljaz1bJyJdcHJvY2Vzc1RpbWVyXChcKTtbJyJdPiI7aToxNDc7czozNToiPGd1aWQ+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmwiO2k6MTQ4O3M6NjI6ImludDMyXChcKFwoXCR6XHMqPj5ccyo1XHMqJlxzKjB4MDdmZmZmZmZcKVxzKlxeXHMqXCR5XHMqPDxccyoyIjtpOjE0OTtzOjQzOiJmb3BlblwoXHMqXCRyb290X2RpclxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE1MDtzOjIzOiJcJGluX1Blcm1zXHMrJlxzKzB4NDAwMCI7aToxNTE7czozNDoiZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0vdmFyL3RtcCI7aToxNTI7czo5OiIvcG10L3Jhdi8iO2k6MTUzO3M6NDk6ImZ3cml0ZVwoXCRmcFxzKixccypzdHJyZXZcKFxzKlwkY29udGV4dFxzKlwpXHMqXCkiO2k6MTU0O3M6MjA6Ik1hc3JpXHMrQ3liZXJccytUZWFtIjtpOjE1NTtzOjE4OiJVczNccytZMHVyXHMrYnI0MW4iO2k6MTU2O3M6MjA6Ik1hc3IxXHMrQ3liM3JccytUZTRtIjtpOjE1NztzOjIwOiJ0SEFOS3Nccyt0T1xzK1Nub3BweSI7aToxNTg7czo2NjoiLFxzKlsnIl0vaW5kZXhcXFwuXChwaHBcfGh0bWxcKS9pWyciXVxzKixccypSZWN1cnNpdmVSZWdleEl0ZXJhdG9yIjtpOjE1OTtzOjQ3OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aToxNjA7czo1NToiZ2V0cHJvdG9ieW5hbWVcKFxzKlsnIl10Y3BbJyJdXHMqXClccytcfFx8XHMrZGllXHMrc2hpdCI7aToxNjE7czo3ODoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXWNkXHMrL3RtcDt3Z2V0IjtpOjE2MjtzOjIyOiI8YVxzK2hyZWY9WyciXW9zaGlia2EtIjtpOjE2MztzOjg1OiJpZlwoXHMqXCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0hPVxzKlsnIl1bJyJdXHMqXClccypcJGlkPVwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIjtpOjE2NDtzOjgzOiJpZlwoWyciXXN1YnN0cl9jb3VudFwoWyciXVwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXHMqLFxzKlsnIl1xdWVyeVwucGhwWyciXSI7aToxNjU7czozODoiXCRmaWxsID0gXCRfQ09PS0lFXFtcXFsnIl1maWxsXFxbJyJdXF0iO2k6MTY2O3M6NjI6IlwkcmVzdWx0PXNtYXJ0Q29weVwoXHMqXCRzb3VyY2VccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRmaWxlIjtpOjE2NztzOjQwOiJcJGJhbm5lZElQXHMqPVxzKmFycmF5XChccypbJyJdXF42NlwuMTAyIjtpOjE2ODtzOjM1OiI8bG9jPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsOyI7aToxNjk7czoyODoiXCRzZXRjb29rXCk7c2V0Y29va2llXChcJHNldCI7aToxNzA7czoyODoiXCk7ZnVuY3Rpb25ccytzdHJpbmdfY3B0XChcJCI7aToxNzE7czo1MDoiWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl0iO2k6MTcyO3M6NTM6ImlmXChwcmVnX21hdGNoXChbJyJdXCN3b3JkcHJlc3NfbG9nZ2VkX2luXHxhZG1pblx8cHdkIjtpOjE3MztzOjQxOiJnX2RlbGV0ZV9vbl9leGl0XHMqPVxzKm5ld1xzK0RlbGV0ZU9uRXhpdCI7aToxNzQ7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjE3NTtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6MTc2O3M6Nzc6InZhbHVlPVsnIl08XD9ccytcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdIjtpOjE3NztzOjI3OiJcZCsmQHByZWdfbWF0Y2hcKFxzKnN0cnRyXCgiO2k6MTc4O3M6Mzg6ImNoclwoXHMqaGV4ZGVjXChccypzdWJzdHJcKFxzKlwkbWFrZXVwIjtpOjE3OTtzOjMwOiJyZWFkX2ZpbGVfbmV3XzJcKFwkcmVzdWx0X3BhdGgiO2k6MTgwO3M6MjM6IlwkaW5kZXhfcGF0aFxzKixccyowNDA0IjtpOjE4MTtzOjY3OiJcJGZpbGVfZm9yX3RvdWNoXHMqPVxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdIjtpOjE4MjtzOjYxOiJcJF9TRVJWRVJcW1snIl17MCwxfVJFTU9URV9BRERSWyciXXswLDF9XF07aWZcKFwocHJlZ19tYXRjaFwoIjtpOjE4MztzOjE5OiI9PVxzKlsnIl1jc2hlbGxbJyJdIjtpOjE4NDtzOjI5OiJmaWxlX2V4aXN0c1woXHMqXCRGaWxlQmF6YVRYVCI7aToxODU7czoxODoicmVzdWx0c2lnbl93YXJuaW5nIjtpOjE4NjtzOjI0OiJmdW5jdGlvblxzK2dldGZpcnN0c2h0YWciO2k6MTg3O3M6OTA6ImZpbGVfZ2V0X2NvbnRlbnRzXChST09UX0RJUlwuWyciXS90ZW1wbGF0ZXMvWyciXVwuXCRjb25maWdcW1snIl1za2luWyciXVxdXC5bJyJdL21haW5cLnRwbCI7aToxODg7czoyNToibmV3XHMrY29uZWN0QmFzZVwoWyciXWFIUiI7aToxODk7czo4MzoiXCRpZFxzKlwuXHMqWyciXVw/ZD1bJyJdXHMqXC5ccypiYXNlNjRfZW5jb2RlXChccypcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6MTkwO3M6Mjk6ImRvX3dvcmtcKFxzKlwkaW5kZXhfZmlsZVxzKlwpIjtpOjE5MTtzOjIwOiJoZWFkZXJccypcKFxzKl9cZCtcKCI7aToxOTI7czoxMjoiQnlccytXZWJSb29UIjtpOjE5MztzOjE2OiJDb2RlZFxzK2J5XHMrRVhFIjtpOjE5NDtzOjcxOiJ0cmltXChccypcJGhlYWRlcnNccypcKVxzKlwpXHMqYXNccypcJGhlYWRlclxzKlwpXHMqaGVhZGVyXChccypcJGhlYWRlciI7aToxOTU7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6MTk2O3M6ODE6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aToxOTc7czo2OToidG91Y2hcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjE5ODtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjE5OTtzOjI1OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXStgIjtpOjIwMDtzOjIxOiImX1NFU1NJT05cW3BheWxvYWRcXT0iO2k6MjAxO3M6NDc6Imd6dW5jb21wcmVzc1woXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl1odHRwIjtpOjIwMjtzOjg0OiJpZlwoXHMqIWVtcHR5XChccypcJF9QT1NUXFtccypbJyJdezAsMX10cDJbJyJdezAsMX1ccypcXVwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MjAzO3M6NDk6ImlmXChccyp0cnVlXHMqJlxzKkBwcmVnX21hdGNoXChccypzdHJ0clwoXHMqWyciXS8iO2k6MjA0O3M6Mzg6Ij09XHMqMFwpXHMqe1xzKmVjaG9ccypQSFBfT1NccypcLlxzKlwkIjtpOjIwNTtzOjEwNzoiaXNzZXRcKFxzKlwkX1NFUlZFUlxbXHMqX1xkK1woXHMqXGQrXHMqXClccypcXVxzKlwpXHMqXD9ccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxkK1wpXHMqXF1ccyo6XHMqX1xkK1woXGQrXCkiO2k6MjA2O3M6OTk6IlwkaW5kZXhccyo9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl08XD9waHBccypvYl9lbmRfZmx1c2hcKFwpO1xzKlw/PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRpbmRleCI7aToyMDc7czozMzoiXCRzdGF0dXNfbG9jX3NoXHMqPVxzKmZpbGVfZXhpc3RzIjtpOjIwODtzOjQ4OiJcJFBPU1RfU1RSXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgicGhwOi8vaW5wdXQiO2k6MjA5O3M6NDg6ImdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXW1lcyI7aToyMTA7czo2NjoiXCR0YWJsZVxbXCRzdHJpbmdcW1wkaVxdXF1ccypcKlxzKnBvd1woNjRccyosXHMqMlwpXHMqXCtccypcJHRhYmxlIjtpOjIxMTtzOjMzOiJpZlwoXHMqc3RyaXBvc1woXHMqWyciXVwqXCpcKlwkdWEiO2k6MjEyO3M6NDk6ImZsdXNoX2VuZF9maWxlXChccypcJGZpbGVuYW1lXHMqLFxzKlwkZmlsZWNvbnRlbnQiO2k6MjEzO3M6NTY6InByZWdfbWF0Y2hcKFxzKlsnIl17MCwxfX5Mb2NhdGlvbjpcKFwuXCpcP1wpXChcPzpcXG5cfFwkIjtpOjIxNDtzOjI4OiJ0b3VjaFwoXHMqXCR0aGlzLT5jb25mLT5yb290IjtpOjIxNTtzOjM2OiJldmFsXChccypcJHtccypcJFthLXpBLVowLTlfXStccyp9XFsiO2k6MjE2O3M6NDM6ImlmXHMqXChccypAZmlsZXR5cGVcKFwkbGVhZG9uXHMqXC5ccypcJGZpbGUiO2k6MjE3O3M6NTk6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRpclxzKlwuXHMqXCRmaWxlXHMqXC5ccypbJyJdL2luZGV4IjtpOjIxODtzOjI2OiJmaWxlc2l6ZVwoXHMqXCRwdXRfa19mYWlsdSI7aToyMTk7czo2MDoiYWdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXXswLDF9bWVzWyciXVxdIjtpOjIyMDtzOjQzOiJmdW5jdGlvblxzK2ZpbmRIZWFkZXJMaW5lXHMqXChccypcJHRlbXBsYXRlIjtpOjIyMTtzOjQzOiJcJHN0YXR1c19jcmVhdGVfZ2xvYl9maWxlXHMqPVxzKmNyZWF0ZV9maWxlIjtpOjIyMjtzOjM4OiJlY2hvXHMrc2hvd19xdWVyeV9mb3JtXChccypcJHNxbHN0cmluZyI7aToyMjM7czozNToiPT1ccypGQUxTRVxzKlw/XHMqXGQrXHMqOlxzKmlwMmxvbmciO2k6MjI0O3M6MjI6ImZ1bmN0aW9uXHMrbWFpbGVyX3NwYW0iO2k6MjI1O3M6MzQ6IkVkaXRIdGFjY2Vzc1woXHMqWyciXVJld3JpdGVFbmdpbmUiO2k6MjI2O3M6MTE6IlwkcGF0aFRvRG9yIjtpOjIyNztzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjIyODtzOjk3OiJAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVwoXHMqQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqXF1ccypcKVxzKlwpIjtpOjIyOTtzOjQwOiJoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vXCRwcFwub3JnIjtpOjIzMDtzOjQ3OiJyZXR1cm5ccytbJyJdL2hvbWUvW2EtekEtWjAtOV9dKy9bYS16QS1aMC05X10rLyI7aToyMzE7czozOToiWyciXXdwLVsnIl1ccypcLlxzKmdlbmVyYXRlUmFuZG9tU3RyaW5nIjtpOjIzMjtzOjY3OiJcJFthLXpBLVowLTlfXSs9PVsnIl1mZWF0dXJlZFsnIl1ccypcKVxzKlwpe1xzKmVjaG9ccytiYXNlNjRfZGVjb2RlIjtpOjIzMztzOjEwNjoiXCRbYS16QS1aMC05X10rXHMqPVxzKlwkanFccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyMzQ7czoyMjoiZXhwbG9pdFxzKjo6XC48L3RpdGxlPiI7aToyMzU7czo0MDoiXCRbYS16QS1aMC05X10rPXN0cl9yZXBsYWNlXChbJyJdXCphXCRcKiI7aToyMzY7czo2MDoiY2hyXChccypcJFthLXpBLVowLTlfXStccypcKTtccyp9XHMqZXZhbFwoXHMqXCRbYS16QS1aMC05X10rIjtpOjIzNztzOjQ3OiJpZlwoXHMqaXNJblN0cmluZzEqXChcJFthLXpBLVowLTlfXSssWyciXWdvb2dsZSI7aToyMzg7czo5MzoiXCRwcFxzKj1ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdIjtpOjIzOTtzOjQ5OiJmaWxlX3B1dF9jb250ZW50c1woRElSXC5bJyJdL1snIl1cLlsnIl1pbmRleFwucGhwIjtpOjI0MDtzOjI5OiJAZ2V0X2hlYWRlcnNcKFxzKlwkZnVsbHBhdGhcKSI7aToyNDE7czoyMToiQFwkX0dFVFxbWyciXXB3WyciXVxdIjtpOjI0MjtzOjI1OiJqc29uX2VuY29kZVwoYWxleHVzTWFpbGVyIjtpOjI0MztzOjE2ODoiZXZhbFwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjI0NDtzOjE5OiI9WyciXVwpXCk7WyciXVwpXCk7IjtpOjI0NTtzOjE4MDoiPVxzKlwkW2EtekEtWjAtOV9dK1woXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjI0NjtzOjU1OiJcXVxzKn1ccypcKFxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjI0NztzOjc3OiJyZXF1ZXN0XC5zZXJ2ZXJ2YXJpYWJsZXNcKFxzKlsnIl1IVFRQX1VTRVJfQUdFTlRbJyJdXHMqXClccyosXHMqWyciXUdvb2dsZWJvdCI7aToyNDg7czo0ODoiZXZhbFwoWyciXVw/PlsnIl1ccypcLlxzKmpvaW5cKFsnIl1bJyJdLGZpbGVcKFwkIjtpOjI0OTtzOjY4OiJzZXRvcHRcKFwkY2hccyosXHMqQ1VSTE9QVF9QT1NURklFTERTXHMqLFxzKmh0dHBfYnVpbGRfcXVlcnlcKFwkZGF0YSI7aToyNTA7czoxMTc6Im15c3FsX2Nvbm5lY3RcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNTE7czo2NDoicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpLFsnIl1haWR1WyciXSI7aToyNTI7czozNjoiXF1ccypcKVxzKlwpXHMqe1xzKmV2YWxccypcKFxzKlwke1wkIjtpOjI1MztzOjE2OiJieVxzK0Vycm9yXHMrN3JCIjtpOjI1NDtzOjMzOiJAaXJjc2VydmVyc1xbcmFuZFxzK0BpcmNzZXJ2ZXJzXF0iO2k6MjU1O3M6NTk6InNldF90aW1lX2xpbWl0XChpbnR2YWxcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI1NjtzOjI0OiJuaWNrXHMrWyciXWNoYW5zZXJ2WyciXTsiO2k6MjU3O3M6MjM6Ik1hZ2ljXHMrSW5jbHVkZVxzK1NoZWxsIjtpOjI1ODtzOjk3OiJcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXSs9Y3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXStcKFwpIjtpOjI1OTtzOjM4OiJjdXJsT3BlblwoXCRyZW1vdGVfcGF0aFwuXCRwYXJhbV92YWx1ZSI7aToyNjA7czo0NzoiZndyaXRlXChcJGZwLFsnIl1cXHhFRlxceEJCXFx4QkZbJyJdXC5cJGJvZHlcKTsiO2k6MjYxO3M6MTMzOiJcJFthLXpBLVowLTlfXStcK1wrXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmFycmF5X3VuaXF1ZVwoYXJyYXlfbWVyZ2VcKFwkW2EtekEtWjAtOV9dK1xzKixccypbYS16QS1aMC05X10rXChbJyJdXCRbYS16QS1aMC05X10rIjtpOjI2MjtzOjQyOiJhbmRccypcKCFccypzdHJzdHJcKFwkdWEsWyciXXJ2OjExWyciXVwpXCkiO2k6MjYzO3M6MzU6ImVjaG9ccytcJG9rXHMrXD9ccytbJyJdU0hFTExfT0tbJyJdIjtpOjI2NDtzOjI3OiI7ZXZhbFwoXCR0b2RvY29udGVudFxbMFxdXCkiO2k6MjY1O3M6NDA6Im9yXHMrc3RydG9sb3dlclwoQGluaV9nZXRcKFsnIl1zYWZlX21vZGUiO2k6MjY2O3M6Mjk6ImlmXCghaXNzZXRcKFwkX1JFUVVFU1RcW2NoclwoIjtpOjI2NztzOjQ0OiJcJHByb2Nlc3NvXHMqPVxzKlwkcHNcW3JhbmRccytzY2FsYXJccytAcHNcXSI7aToyNjg7czozMjoiZWNob1xzK1snIl11bmFtZVxzKy1hO1xzKlwkdW5hbWUiO2k6MjY5O3M6MjE6IlwudGNwZmxvb2Rccys8dGFyZ2V0PiI7aToyNzA7czo1MDoiXCRib3RcW1snIl1zZXJ2ZXJbJyJdXF09XCRzZXJ2YmFuXFtyYW5kXCgwLGNvdW50XCgiO2k6MjcxO3M6MTY6IlwuOlxzK3czM2Rccys6XC4iO2k6MjcyO3M6MTY6IkJMQUNLVU5JWFxzK0NSRVciO2k6MjczO3M6MTE4OiI7XCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcW1snIl1bYS16QS1aMC05X10rWyciXVxdXFtcZCtcXVwuXCRbYS16QS1aMC05X10rXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXGQrXF1cLlwkIjtpOjI3NDtzOjMwOiJjYXNlXHMqWyciXWNyZWF0ZV9zeW1saW5rWyciXToiO2k6Mjc1O3M6OTY6InNvY2tldF9jb25uZWN0XChcJFthLXpBLVowLTlfXSssXHMqWyciXWdtYWlsLXNtdHAtaW5cLmxcLmdvb2dsZVwuY29tWyciXVxzKixccyoyNVwpXHMqPT1ccypGQUxTRSI7aToyNzY7czo0NjoiY2FsbF91c2VyX2Z1bmNcKEB1bmhleFwoMHhbYS16QS1aMC05X10rXClcKFwkXyI7aToyNzc7czo2MjoiXCRfPUBcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXC5AXCRfXChcJF9SRVFVRVNUXFsiO2k6Mjc4O3M6NjU6IlwkR0xPQkFMU1xbXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXGQrXF1cLlwkR0xPQkFMU1xbIjtpOjI3OTtzOjYzOiJcLlwkW2EtekEtWjAtOV9dK1xbXCRbYS16QS1aMC05X10rXF1cLlsnIl17WyciXVwpXCk7fTt1bnNldFwoXCQiO2k6MjgwO3M6ODY6Imh0dHBfYnVpbGRfcXVlcnlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXClcLlsnIl0maXA9WyciXVxzKlwuXHMqXCRfU0VSVkVSIjtpOjI4MTtzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdL3NiaW4vaWZjb25maWdbJyJdIjtpOjI4MjtzOjg5OiI8XD9waHBccytpZlxzKlwoaXNzZXRccypcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdaW1hZ2VzWyciXVxdXClcKVxzKntcJCI7aToyODM7czoxNzoiPHRpdGxlPkdPUkRPXHMrMjAiO2k6Mjg0O3M6MTM4OiJjb3B5XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXCkiO2k6Mjg1O3M6Njg6InNwcmludGZcKFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStcKVxzKlwpIjtpOjI4NjtzOjY4OiI9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl1cfFx8XHxbYS16QS1aMC05X10rXHxcfFx8WyciXVxzKixccypbJyJdWyciXSI7aToyODc7czoxMzI6IlwkW2EtekEtWjAtOV9dK1xbMFxdPXBhY2tcKFsnIl1IXCpbJyJdLFsnIl1bYS16QS1aMC05X10rWyciXVwpO2FycmF5X2ZpbHRlclwoXCRbYS16QS1aMC05X10rLHBhY2tcKFsnIl1IXCpbJyJdLFsnIl1bYS16QS1aMC05X10rWyciXSI7aToyODg7czo2MToiaWZccypcKHdpbmRvd1wucGx1c29cKVxzKmlmXHMqXCh0eXBlb2Zccyp3aW5kb3dcLnBsdXNvXC5zdGFydCI7aToyODk7czoxMzoiZXZhbFwoXCR7XCR7IiI7aToyOTA7czoxODoiLS12aXNpdG9yVHJhY2tlci0tIjtpOjI5MTtzOjUwOiJldmFsXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyOTI7czo1MjoiYXNzZXJ0XHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyOTM7czoxMDY6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFsiO2k6Mjk0O3M6MTc3OiI8Yj5ldmFsXHMqXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6Mjk1O3M6NzI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypbJyJdd2dldCI7aToyOTY7czoyMToiPT1bJyJdXClcKTtyZXR1cm47XD8+IjtpOjI5NztzOjc6InVnZ2M6Ly8iO2k6Mjk4O3M6NzM6IlwkX19hXHMqPVxzKnN0cl9yZXBsYWNlXCgiLiIsXHMqIi4iLFxzKlwkX18uXCk7XHMqXCRfXy5ccyo9XHMqc3RyX3JlcGxhY2UiO2k6Mjk5O3M6MzA6ImVjaG9ccypleGVjXChbJyJdd2hvYW1pWyciXVwpOyI7aTozMDA7czo5MzoiZmlsZV9wdXRfY29udGVudHNcKFsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdLFwkX1BPU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdLEZJTEVfQVBQRU5EXCk7IjtpOjMwMTtzOjU4OiJcJGRpcnBhdGhcLlsnIl0vWyciXVwuXCR2YWx1ZVwuWyciXS93cC1jb25maWdcLnBocFsnIl1cKVwuIjtpOjMwMjtzOjEwMzoiXCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcXT1jaHJcKFwkW2EtekEtWjAtOV9dK1xbb3JkXChcJFthLXpBLVowLTlfXStcW1wkW2EtekEtWjAtOV9dK1xdXClcXVwpOyI7aTozMDM7czo0NjoiXCRbYS16QS1aMC05X10rXFtjaHJcKFxkK1wpXF1cKFthLXpBLVowLTlfXStcKCI7aTozMDQ7czoxNDI6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXCkiO2k6MzA1O3M6MTA0OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIiI7aTozMDY7czo5NDoiXCRbYS16QS1aMC05X10rPWFycmF5XChbJyJdXCRbYS16QS1aMC05X10rXFtccypcXT1hcnJheV9wb3BcKFwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dKyI7aTozMDc7czoxMDc6IlwkW2EtekEtWjAtOV9dKz1wYWNrXChbJyJdSFwqWyciXSxzdWJzdHJcKFwkW2EtekEtWjAtOV9dKyxccyotXGQrXClcKTtccypyZXR1cm5ccytcJFthLXpBLVowLTlfXStcKHN1YnN0clwoIjtpOjMwODtzOjEzNjoiXCRbYS16QS1aMC05X10rXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwoXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcWyI7fQ=="));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NzY6e2k6MDtzOjU0OiJcJFthLXpBLVowLTlfXSs9WyciXS9ob21lL1thLXpBLVowLTlfXSsvW2EtekEtWjAtOV9dKy8iO2k6MTtzOjQ0OiJccyo9XHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXSI7aToyO3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjM7czo0MToiWyciXWZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDIwMDAiO2k6NDtzOjQ1OiJbJyJdZmluZFxzKy9ccystdHlwZVxzK2ZccystbmFtZVxzK1wuaHRwYXNzd2QiO2k6NTtzOjI4OiJhbmRyb2lkXHxhdmFudGdvXHxibGFja2JlcnJ5IjtpOjY7czozNzoiaW5pX3NldFwoXHMqWyciXXswLDF9bWFnaWNfcXVvdGVzX2dwYyI7aTo3O3M6MTI6IlsnIl1sc1xzKy1sYSI7aTo4O3M6MTk6InJvdW5kXHMqXChccyowXHMqXCsiO2k6OTtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMDtzOjEyOiJbJyJdcm1ccystcmYiO2k6MTE7czoxMjoiWyciXXJtXHMrLWZyIjtpOjEyO3M6MTY6IlsnIl1ybVxzKy1yXHMrLWYiO2k6MTM7czoxNjoiWyciXXJtXHMrLWZccystciI7aToxNDtzOjEwOiJbJyJdYUhSMGNEIjtpOjE1O3M6OToia2lsbFxzKy05IjtpOjE2O3M6NTE6IkNVUkxPUFRfUkVGRVJFUixccypbJyJdezAsMX1odHRwczovL3d3d1wuZ29vZ2xlXC5jbyI7aToxNztzOjQzOiIoXFxbMC05XVswLTldWzAtOV18XFx4WzAtOWEtZl1bMC05YS1mXSl7Nyx9IjtpOjE4O3M6NDA6IihbXlw/XHNdKVwoezAsMX1cLltcK1wqXVwpezAsMX1cMlthLXpdKmUiO2k6MTk7czoxMzoiQGV4dHJhY3RccypcKCI7aToyMDtzOjEzOiJAZXh0cmFjdFxzKlwkIjtpOjIxO3M6MzE6IlwkYlxzKj1ccypjcmVhdGVfZnVuY3Rpb25cKFsnIl0iO2k6MjI7czo0MjoiPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXXswLDF9XCRhWyciXXswLDF9IjtpOjIzO3M6NzA6Im1haWxcKFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF0iO2k6MjQ7czoyMToiZGlzYWJsZV9mdW5jdGlvbnNccyo9IjtpOjI1O3M6NzM6IlxibWFpbFwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccyoiO2k6MjY7czoyOToiZm9wZW5cKFxzKlsnIl1cLlwuL1wuaHRhY2Nlc3MiO2k6Mjc7czoxNDoiIS91c3IvYmluL3BlcmwiO2k6Mjg7czo0NjoiQGVycm9yX3JlcG9ydGluZ1woMFwpO1xzKkBzZXRfdGltZV9saW1pdFwoMFwpOyI7aToyOTtzOjIyOiJydW5raXRfZnVuY3Rpb25fcmVuYW1lIjtpOjMwO3M6MTg0OiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkIjtpOjMxO3M6NTc6IiRbYS16QS1aMC05X11ce1xkK1x9XHMqXC4kXHcrXHtcZCtcfVxzKlwuJFx3K1x7XGQrXH1ccypcLiI7aTozMjtzOjIzOiJcYmV2YWxcKFthLXpBLVowLTlfXStcKCI7aTozMztzOjI4OiJkaXNrX2ZyZWVfc3BhY2VcKFxzKlsnIl0vdG1wIjtpOjM0O3M6OToiUm9vdFNoZWxsIjtpOjM1O3M6MjQ6ImV2YWxcKFxzKlwkW2EtekEtWjAtOV9dKyI7aTozNjtzOjE0OiJCT1RORVRccytQQU5FTCI7aTozNztzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6Mzg7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjM5O3M6NToiSlRlcm0iO2k6NDA7czo1OiJPbmV0NyI7aTo0MTtzOjk6IlwkcGFzc191cCI7aTo0MjtzOjU6InhDZWR6IjtpOjQzO3M6MTE2OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXClccypcKSI7aTo0NDtzOjI3OiJcJE9PTy4rPz1ccyp1cmxkZWNvZGVccypcKCoiO2k6NDU7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6NDY7czoxNToicGNudGxfZXhlY1xzKlwoIjtpOjQ3O3M6MzE6Ij1ccyphcnJheV9tYXBccypcKCpccypzdHJyZXZccyoiO2k6NDg7czozMjoic3RyX2lyZXBsYWNlXHMqXCgqXHMqWyciXTwvaGVhZD4iO2k6NDk7czoyMzoiY29weVxzKlwoXHMqWyciXWh0dHA6Ly8iO2k6NTA7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoKlxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6NTE7czoyODoiZWNob1xzKlwoKlxzKlsnIl1OTyBGSUxFWyciXSI7aTo1MjtzOjE1OiJbJyJdL1wuXCovZVsnIl0iO2k6NTM7czo0ODc6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6NTQ7czo2NDoiZWNob1xzK3N0cmlwc2xhc2hlc1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo1NTtzOjE1OiIvdXNyL3NiaW4vaHR0cGQiO2k6NTY7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aTo1NztzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6NTg7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6NTk7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aTo2MDtzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo2MTtzOjgzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbWyciXXRtcF9uYW1lWyciXVxdXHMqLCI7aTo2MjtzOjgxOiJtYWlsXChcJF9QT1NUXFtbJyJdezAsMX1lbWFpbFsnIl17MCwxfVxdLFxzKlwkX1BPU1RcW1snIl17MCwxfXN1YmplY3RbJyJdezAsMX1cXSwiO2k6NjM7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6NjQ7czo2MzoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXStccypcXVwoIjtpOjY1O3M6MTk6IlsnIl0vXGQrL1xbYS16XF1cKmUiO2k6NjY7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6Njc7czo1NjoiQCpmaWxlX3B1dF9jb250ZW50c1woXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6Njg7czozNjoiWC1NYWlsZXI6XHMqTWljcm9zb2Z0IE9mZmljZSBPdXRsb29rIjtpOjY5O3M6OTE6Im1haWxcKFxzKnN0cmlwc2xhc2hlc1woXCR0b1wpXHMqLFxzKnN0cmlwc2xhc2hlc1woXCRzdWJqZWN0XClccyosXHMqc3RyaXBzbGFzaGVzXChcJG1lc3NhZ2UiO2k6NzA7czo2MzoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1woIjtpOjcxO3M6MjM6ImlzX3dyaXRhYmxlPWlzX3dyaXRhYmxlIjtpOjcyO3M6Mzg6IkBtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkdXNlcmZpbGVfdG1wIjtpOjczO3M6MjY6ImV4aXRcKFwpOmV4aXRcKFwpOmV4aXRcKFwpIjtpOjc0O3M6Njc6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6NzU7czoxNzoiPVxzKlsnIl0vdmFyL3RtcC8iO2k6NzY7czo1OToiXChccypcJHNlbmRccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZVxzKixccypcJGhlYWRlcnMiO2k6Nzc7czo4MzoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWx3cC1kb3dubG9hZFxzK2h0dHA6Ly8iO2k6Nzg7czoxMDE6InN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlXChbJyJdLlsnIl1ccyosXHMqWyciXS5bJyJdXHMqLFxzKnN0cl9yZXBsYWNlIjtpOjc5O3M6MzY6Ii9hZG1pbi9jb25maWd1cmF0aW9uXC5waHAvbG9naW5cLnBocCI7aTo4MDtzOjcxOiJzZWxlY3Rccypjb25maWd1cmF0aW9uX2lkLFxzK2NvbmZpZ3VyYXRpb25fdGl0bGUsXHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aTo4MTtzOjUwOiJ1cGRhdGVccypjb25maWd1cmF0aW9uXHMrc2V0XHMrY29uZmlndXJhdGlvbl92YWx1ZSI7aTo4MjtzOjM3OiJzZWxlY3RccypsYW5ndWFnZXNfaWQsXHMrbmFtZSxccytjb2RlIjtpOjgzO3M6NTI6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypcXFsnIl1cXFsnIl07fWlmXCghZ2V0Q29va2llXCgiO2k6ODQ7czo0NToiaWZcKGZpbGVfcHV0X2NvbnRlbnRzXChcJGluZGV4X3BhdGgsXHMqXCRjb2RlIjtpOjg1O3M6MzY6ImV4ZWNccyt7WyciXS9iaW4vc2hbJyJdfVxzK1snIl0tYmFzaCI7aTo4NjtzOjUwOiI8aWZyYW1lXHMrc3JjPVsnIl1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tL2Zvcm1zLyI7aTo4NztzOjIyOiIsWyciXTxcP3BocFxcblsnIl1cLlwkIjtpOjg4O3M6NzI6IjxcP3BocFxzK1xiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqWyciXS9ob21lLyI7aTo4OTtzOjIyOiJ4cnVtZXJfc3BhbV9saW5rc1wudHh0IjtpOjkwO3M6MzM6IkNvbWZpcm1ccytUcmFuc2FjdGlvblxzK1Bhc3N3b3JkOiI7aTo5MTtzOjc3OiJhcnJheV9tZXJnZVwoXCRleHRccyosXHMqYXJyYXlcKFsnIl13ZWJzdGF0WyciXSxbJyJdYXdzdGF0c1snIl0sWyciXXRlbXBvcmFyeSI7aTo5MjtzOjkyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbXlzcWxkdW1wXHMrLWhccytsb2NhbGhvc3RccystdSI7aTo5MztzOjI4OiJNb3RoZXJbJyJdc1xzK01haWRlblxzK05hbWU6IjtpOjk0O3M6Mzk6ImxvY2F0aW9uXC5yZXBsYWNlXChcXFsnIl1cJHVybF9yZWRpcmVjdCI7aTo5NTtzOjM2OiJjaG1vZFwoZGlybmFtZVwoX19GSUxFX19cKSxccyowNTExXCkiO2k6OTY7czo4NToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9Y3VybFxzKy1PXHMraHR0cDovLyI7aTo5NztzOjI5OiJcKVwpLFBIUF9WRVJTSU9OLG1kNV9maWxlXChcJCI7aTo5ODtzOjc1OiJcJFthLXpBLVowLTlfXStcW1wkW2EtekEtWjAtOV9dK1xdXFtcJFthLXpBLVowLTlfXStcW1xkK1xdXC5cJFthLXpBLVowLTlfXSsiO2k6OTk7czozNDoiXCRxdWVyeVxzKyxccytbJyJdZnJvbSUyMGpvc191c2VycyI7aToxMDA7czoxNToiZXZhbFwoWyciXVxzKi8vIjtpOjEwMTtzOjE2OiJldmFsXChbJyJdXHMqL1wqIjtpOjEwMjtzOjEwNDoiXCRbYS16QS1aMC05X10rXHMqPVwkW2EtekEtWjAtOV9dK1xzKlwoXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1xzKlwoWyciXVxzKntcJFthLXpBLVowLTlfXSsiO2k6MTAzO3M6MzE6IiFlcmVnXChbJyJdXF5cKHVuc2FmZV9yYXdcKVw/XCQiO2k6MTA0O3M6MzU6IlwkYmFzZV9kb21haW5ccyo9XHMqZ2V0X2Jhc2VfZG9tYWluIjtpOjEwNTtzOjk6InNleHNleHNleCI7aToxMDY7czoyMzoiXCt1bmlvblwrc2VsZWN0XCswLDAsMCwiO2k6MTA3O3M6Mzc6ImNvbmNhdFwoMHgyMTdlLHBhc3N3b3JkLDB4M2EsdXNlcm5hbWUiO2k6MTA4O3M6MzQ6Imdyb3VwX2NvbmNhdFwoMHgyMTdlLHBhc3N3b3JkLDB4M2EiO2k6MTA5O3M6NTc6IlwqL1xzKlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aToxMTA7czo4OiJhYmFrby9BTyI7aToxMTE7czo0ODoiaWZcKFxzKnN0cnBvc1woXHMqXCR2YWx1ZVxzKixccypcJG1hc2tccypcKVxzKlwpIjtpOjExMjtzOjEwNjoidW5saW5rXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXXswLDF9L2Fzc2V0cy9jYWNoZS90ZW1wL0ZpbGVTZXR0aW5ncyI7aToxMTM7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MTE0O3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MTE1O3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjExNjtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aToxMTc7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjExODtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MTE5O3M6Mjc6InN0cmxlblwoXHMqXCRwYXRoVG9Eb3JccypcKSI7aToxMjA7czo2NDoiaXNzZXRcKFxzKlwkX0NPT0tJRVxbXHMqbWQ1XChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfSE9TVCI7aToxMjE7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjEyMjtzOjg0OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD1bJyJdXC5cJHBvc3RcW1snIl17MCwxfWlkWyciXXswLDF9XF0iO2k6MTIzO3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6MTI0O3M6OToiTDNaaGNpOTNkIjtpOjEyNTtzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aToxMjY7czo0NDoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL1x3XSs/XHMqLFxzKjA0MDQiO2k6MTI3O3M6NDQ6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9cd10rP1xzKixccyowNzU1IjtpOjEyODtzOjQyOiJAdW1hc2tcKFxzKjA3NzdccyomXHMqflxzKlwkZmlsZXBlcm1pc3Npb24iO2k6MTI5O3M6MjM6IlsnIl1ccypcfFxzKi9iaW4vc2hbJyJdIjtpOjEzMDtzOjE2OiI7XHMqL2Jpbi9zaFxzKi1pIjtpOjEzMTtzOjQxOiJpZlxzKlwoZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aToxMzI7czoyNjoiPVxzKlsnIl1zZW5kbWFpbFxzKi10XHMqLWYiO2k6MTMzO3M6MTU6Ii90bXAvdG1wLXNlcnZlciI7aToxMzQ7czoxNToiL3RtcC9cLklDRS11bml4IjtpOjEzNTtzOjI5OiJleGVjXChccypbJyJdL2Jpbi9zaFsnIl1ccypcKSI7aToxMzY7czoyNzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzIjtpOjEzNztzOjMzOiJ0b3VjaFxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6MTM4O3M6NDk6IkB0b3VjaFxzKlwoXHMqXCRjdXJmaWxlXHMqLFxzKlwkdGltZVxzKixccypcJHRpbWUiO2k6MTM5O3M6MTg6Ii1cKi1ccypjb25mXHMqLVwqLSI7aToxNDA7czo0NDoib3BlblxzKlwoXHMqTVlGSUxFXHMqLFxzKlsnIl1ccyo+XHMqdGFyXC50bXAiO2k6MTQxO3M6NzQ6IlwkcmV0ID0gXCR0aGlzLT5fZGItPnVwZGF0ZU9iamVjdFwoIFwkdGhpcy0+X3RibCwgXCR0aGlzLCBcJHRoaXMtPl90Ymxfa2V5IjtpOjE0MjtzOjE5OiJkaWVcKFxzKlsnIl1ubyBjdXJsIjtpOjE0MztzOjU0OiJzdWJzdHJcKFxzKlwkcmVzcG9uc2VccyosXHMqXCRpbmZvXFtccypbJyJdaGVhZGVyX3NpemUiO2k6MTQ0O3M6MTA4OiJpZlwoXHMqIXNvY2tldF9zZW5kdG9cKFxzKlwkc29ja2V0XHMqLFxzKlwkZGF0YVxzKixccypzdHJsZW5cKFxzKlwkZGF0YVxzKlwpXHMqLFxzKjBccyosXHMqXCRpcFxzKixccypcJHBvcnQiO2k6MTQ1O3M6NTA6IjxpbnB1dFxzK3R5cGU9c3VibWl0XHMrdmFsdWU9VXBsb2FkXHMqLz5ccyo8L2Zvcm0+IjtpOjE0NjtzOjU4OiJyb3VuZFxzKlwoXHMqXChccypcJHBhY2tldHNccypcKlxzKjY1XClccyovXHMqMTAyNFxzKixccyoyIjtpOjE0NztzOjU3OiJAZXJyb3JfcmVwb3J0aW5nXChccyowXHMqXCk7XHMqaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCQiO2k6MTQ4O3M6MzA6ImVsc2Vccyp7XHMqZWNob1xzKlsnIl1mYWlsWyciXSI7aToxNDk7czo1MToidHlwZT1bJyJdc3VibWl0WyciXVxzKnZhbHVlPVsnIl1VcGxvYWQgZmlsZVsnIl1ccyo+IjtpOjE1MDtzOjM3OiJoZWFkZXJcKFxzKlsnIl1Mb2NhdGlvbjpccypcJGxpbmtbJyJdIjtpOjE1MTtzOjMxOiJlY2hvXHMqWyciXTxiPlVwbG9hZDxzcz5TdWNjZXNzIjtpOjE1MjtzOjQzOiJuYW1lPVsnIl11cGxvYWRlclsnIl1ccytpZD1bJyJddXBsb2FkZXJbJyJdIjtpOjE1MztzOjIxOiItSS91c3IvbG9jYWwvYmFuZG1haW4iO2k6MTU0O3M6MjQ6InVubGlua1woXHMqX19GSUxFX19ccypcKSI7aToxNTU7czo1NjoibWFpbFwoXHMqXCRhcnJcW1snIl10b1snIl1cXVxzKixccypcJGFyclxbWyciXXN1YmpbJyJdXF0iO2k6MTU2O3M6MTI3OiJpZlwoaXNzZXRcKFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXStbJyJdXF07XHMqZXhpdFwoXCk7IjtpOjE1NztzOjEzOiJudWxsX2V4cGxvaXRzIjtpOjE1ODtzOjQ2OiI8XD9ccypcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpIjtpOjE1OTtzOjk6InRtdmFzeW5nciI7aToxNjA7czoxMjoidG1oYXBiemNlcmZmIjtpOjE2MTtzOjEzOiJvbmZyNjRfcXJwYnFyIjtpOjE2MjtzOjE0OiJbJyJdbmZmcmVnWyciXSI7aToxNjM7czo5OiJmZ2VfZWJnMTMiO2k6MTY0O3M6NzoiY3VjdmFzYiI7aToxNjU7czoxNDoiWyciXWZsZmdyelsnIl0iO2k6MTY2O3M6MTI6IlsnIl1yaW55WyciXSI7aToxNjc7czo5OiJldGFsZm5pemciO2k6MTY4O3M6MTI6InNzZXJwbW9jbnV6ZyI7aToxNjk7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToxNzA7czoxNDoiWyciXXRyZXNzYVsnIl0iO2k6MTcxO3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjE3MjtzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MTczO3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjE3NDtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTc1O3M6NDI6IkBcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpOyI7aToxNzY7czo0ODoicGFyc2VfcXVlcnlfc3RyaW5nXChccypcJEVOVntccypbJyJdUVVFUllfU1RSSU5HIjtpOjE3NztzOjMxOiJldmFsXHMqXChccyptYl9jb252ZXJ0X2VuY29kaW5nIjtpOjE3ODtzOjI0OiJcKVxzKntccypwYXNzdGhydVwoXHMqXCQiO2k6MTc5O3M6MTU6IkhUVFBfQUNDRVBUX0FTRSI7aToxODA7czoyMToiZnVuY3Rpb25ccypDdXJsQXR0YWNrIjtpOjE4MTtzOjE4OiJAc3lzdGVtXChccypbJyJdXCQiO2k6MTgyO3M6MjM6ImVjaG9cKFxzKmh0bWxcKFxzKmFycmF5IjtpOjE4MztzOjU2OiJcJGNvZGU9WyciXSUxc2NyaXB0XHMqdHlwZT1cXFsnIl10ZXh0L2phdmFzY3JpcHRcXFsnIl0lMyI7aToxODQ7czoyMjoiYXJyYXlcKFxzKlsnIl0lMWh0bWwlMyI7aToxODU7czoxOToiYnVkYWtccyotXHMqZXhwbG9pdCI7aToxODY7czo5MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoXHMqWyciXVwkW2EtekEtWjAtOV9dK1snIl1ccypcKSI7aToxODc7czo5OiJHQUdBTDwvYj4iO2k6MTg4O3M6Mzg6ImV4aXRcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE4OTtzOjM3OiJkaWVcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE5MDtzOjM2OiJzZXRfdGltZV9saW1pdFwoXHMqaW50dmFsXChccypcJGFyZ3YiO2k6MTkxO3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToxOTI7czo0MjoiY29ublxzKj1ccypodHRwbGliXC5IVFRQQ29ubmVjdGlvblwoXHMqdXJpIjtpOjE5MztzOjM2OiJpZlxzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9Y2htb2Q3NzciO2k6MTk0O3M6MjY6IjxcP1xzKmVjaG9ccypcJGNvbnRlbnQ7XD8+IjtpOjE5NTtzOjg0OiJcJHVybFxzKlwuPVxzKlsnIl1cP1thLXpBLVowLTlfXSs9WyciXVxzKlwuXHMqXCRfR0VUXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXTsiO2k6MTk2O3M6MTA4OiJjb3B5XChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX1BPU1QiO2k6MTk3O3M6MTE1OiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqXF1cW1snIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XF1cW1xzKlwkaVxzKlxdIjtpOjE5ODtzOjMyOiJkbnNfZ2V0X3JlY29yZFwoXHMqXCRkb21haW5ccypcLiI7aToxOTk7czozNDoiZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdZ2V0bXhyciI7aToyMDA7czoyNDoibnNsb29rdXBcLmV4ZVxzKi10eXBlPU1YIjtpOjIwMTtzOjEyOiJuZXdccypNQ3VybDsiO2k6MjAyO3M6NDQ6IlwkZmlsZV9kYXRhXHMqPVxzKlsnIl08c2NyaXB0XHMqc3JjPVsnIl1odHRwIjtpOjIwMztzOjQwOiJmcHV0c1woXCRmcCxccypbJyJdSVA6XHMqXCRpcFxzKi1ccypEQVRFIjtpOjIwNDtzOjI4OiJjaG1vZFwoXHMqX19ESVJfX1xzKixccyowNDAwIjtpOjIwNTtzOjQwOiJDb2RlTWlycm9yXC5kZWZpbmVNSU1FXChccypbJyJddGV4dC9taXJjIjtpOjIwNjtzOjQzOiJcXVxzKlwpXHMqXC5ccypbJyJdXFxuXD8+WyciXVxzKlwpXHMqXClccyp7IjtpOjIwNztzOjY3OiJcJGd6cFxzKj1ccypcJGJnekV4aXN0XHMqXD9ccypAZ3pvcGVuXChcJHRtcGZpbGUsXHMqWyciXXJiWyciXVxzKlwpIjtpOjIwODtzOjc1OiJmdW5jdGlvbjxzcz5zbXRwX21haWxcKFwkdG9ccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZVxzKixccypcJGhlYWRlcnMiO2k6MjA5O3M6NjQ6IlwkX1BPU1RcW1snIl17MCwxfWFjdGlvblsnIl17MCwxfVxdXHMqPT1ccypbJyJdZ2V0X2FsbF9saW5rc1snIl0iO2k6MjEwO3M6Mzg6Ij1ccypnemluZmxhdGVcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkIjtpOjIxMTtzOjQxOiJjaG1vZFwoXCRmaWxlLT5nZXRQYXRobmFtZVwoXClccyosXHMqMDc3NyI7aToyMTI7czo2MzoiXCRfUE9TVFxbWyciXXswLDF9dHAyWyciXXswLDF9XF1ccypcKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjIxMztzOjEwOToiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFxzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKlwpO1xzKmV4aXRcKFxzKlwpOyI7aToyMTQ7czozMToiPT5ccypAXCRmMlwoX19GSUxFX19ccyosXHMqXCRmMSI7aToyMTU7czo4MToiZXZhbFwoXHMqW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpXHMqXCk7XHMqXD8+IjtpOjIxNjtzOjM3OiJpZlxzKlwoXHMqaXNfY3Jhd2xlcjFcKFxzKlwpXHMqXClccyp7IjtpOjIxNztzOjQ4OiJcJGVjaG9fMVwuXCRlY2hvXzJcLlwkZWNob18zXC5cJGVjaG9fNFwuXCRlY2hvXzUiO2k6MjE4O3M6MzU6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypfX0ZJTEVfX1xzKlwpIjtpOjIxOTtzOjgzOiJAXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqQHVybGVuY29kZVwoXHMqXCRfUE9TVCI7aToyMjA7czo5NToiXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXGQrXF1cKHJvdW5kXChcZCtcKVwpXF0iO2k6MjIxO3M6MjU6ImZ1bmN0aW9uXHMrZXJyb3JfNDA0XChcKXsiO2k6MjIyO3M6Njg6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1wZXJsIjtpOjIyMztzOjcwOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcHl0aG9uIjtpOjIyNDtzOjczOiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVwpXHMqe1xzKmVjaG9ccypbJyJdb2tbJyJdIjtpOjIyNTtzOjM5OiJyZWxwYXRodG9hYnNwYXRoXChccypcJF9HRVRcW1xzKlsnIl1jcHkiO2k6MjI2O3M6NDU6Imh0dHA6Ly8uKz8vLis/XC5waHBcP2E9XGQrJmM9W2EtekEtWjAtOV9dKyZzPSI7aToyMjc7czoxNjoiZnVuY3Rpb25ccyt3c29FeCI7aToyMjg7czo1MToiZm9yZWFjaFwoXHMqXCR0b3Nccyphc1xzKlwkdG9cKVxzKntccyptYWlsXChccypcJHRvIjtpOjIyOTtzOjEwMjoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFsnIl1odHRwOi8vLis/XC5qcGdbJyJdXCk7XHMqZXhpdFwoXCk7IjtpOjIzMDtzOjEyOiI8XD89XCRjbGFzczsiO2k6MjMxO3M6NTA6IjxpbnB1dFxzKnR5cGU9ImZpbGUiXHMqc2l6ZT0iXGQrIlxzKm5hbWU9InVwbG9hZCI+IjtpOjIzMjtzOjExMDoiXCRtZXNzYWdlc1xbXF1ccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXVzZXJmaWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXVxbXHMqXCRpXHMqXF0iO2k6MjMzO3M6NTU6IjxpbnB1dFxzKnR5cGU9WyciXWZpbGVbJyJdXHMqbmFtZT1bJyJddXNlcmZpbGVbJyJdXHMqLz4iO2k6MjM0O3M6MTM6IkRldmFydFxzK0hUVFAiO2k6MjM1O3M6ODc6IkBcJHtccypbYS16QS1aMC05X10rXHMqfVwoXHMqWyciXVsnIl1ccyosXHMqXCR7XHMqW2EtekEtWjAtOV9dK1xzKn1cKFxzKlwkW2EtekEtWjAtOV9dKyI7aToyMzY7czo5MjoiXCRHTE9CQUxTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqXF1cKFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXCRbYS16QS1aMC05X10rXF0iO2k6MjM3O3M6NTM6ImVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjIzODtzOjU4OiJcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKi5ccypcZCtccypcXVwoXHMqW2EtekEtWjAtOV9dK1woIjtpOjIzOTtzOjEyMDoiXCRbYS16QS1aMC05X10rPVsnIl1odHRwOi8vLis/WyciXTtccypcJFthLXpBLVowLTlfXSs9Zm9wZW5cKFwkW2EtekEtWjAtOV9dKyxbJyJdclsnIl1cKTtccypyZWFkZmlsZVwoXCRbYS16QS1aMC05X10rXCk7IjtpOjI0MDtzOjc1OiJhcnJheVwoXHMqWyciXTwhLS1bJyJdXHMqXC5ccyptZDVcKFxzKlwkcmVxdWVzdF91cmxccypcLlxzKnJhbmRcKFxkKyxccypcZCsiO2k6MjQxO3M6MTQ6Indzb0hlYWRlclxzKlwoIjtpOjI0MjtzOjY5OiJlY2hvXChbJyJdPGZvcm0gbWV0aG9kPVsnIl1wb3N0WyciXVxzKmVuY3R5cGU9WyciXW11bHRpcGFydC9mb3JtLWRhdGEiO2k6MjQzO3M6NDM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8iO2k6MjQ0O3M6NTg6InJlbHBhdGh0b2Fic3BhdGhcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjQ1O3M6NDA6Im1haWxcKFwkdG9ccyosXHMqWyciXS4rP1snIl1ccyosXHMqXCR1cmwiO2k6MjQ2O3M6NTE6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccypbJyJdc3lzX2dldF90ZW1wX2RpciI7aToyNDc7czoxNzoiPHRpdGxlPlxzKlZhUlZhUmEiO2k6MjQ4O3M6Mzg6ImVsc2VpZlwoXHMqXCRzcWx0eXBlXHMqPT1ccypbJyJdc3FsaXRlIjtpOjI0OTtzOjE5OiI9WyciXVwpXHMqXCk7XHMqXD8+IjtpOjI1MDtzOjI0OiJlY2hvXHMrYmFzZTY0X2RlY29kZVwoXCQiO2k6MjUxO3M6NTA6IlwjW2EtekEtWjAtOV9dK1wjLis/PC9zY3JpcHQ+Lis/XCMvW2EtekEtWjAtOV9dK1wjIjtpOjI1MjtzOjM0OiJmdW5jdGlvblxzK19fZmlsZV9nZXRfdXJsX2NvbnRlbnRzIjtpOjI1MztzOjU0OiJcJGZccyo9XHMqXCRmXGQrXChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSsiO2k6MjU0O3M6MzI6ImV2YWxcKFwkY29udGVudFwpO1xzKmVjaG9ccypbJyJdIjtpOjI1NTtzOjI5OiJDVVJMT1BUX1VSTFxzKixccypbJyJdc210cDovLyI7aToyNTY7czo3NzoiPGhlYWQ+XHMqPHNjcmlwdD5ccyp3aW5kb3dcLnRvcFwubG9jYXRpb25cLmhyZWY9WyciXS4rP1xzKjwvc2NyaXB0PlxzKjwvaGVhZD4iO2k6MjU3O3M6NzA6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypmb3BlblwoXHMqWyciXVthLXpBLVowLTlfXStcLnBocFsnIl1ccyosXHMqWyciXXciO2k6MjU4O3M6MTY6IkBhc3NlcnRcKFxzKlsnIl0iO2k6MjU5O3M6ODI6IlwkW2EtekEtWjAtOV9dKz1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWRvWyciXVxzKlxdO1xzKmluY2x1ZGUiO2k6MjYwO3M6Nzc6ImVjaG9ccytcJFthLXpBLVowLTlfXSs7bWtkaXJcKFxzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKlwpO2ZpbGVfcHV0X2NvbnRlbnRzIjtpOjI2MTtzOjYxOiJcJGZyb21ccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1mcm9tIjtpOjI2MjtzOjE5OiI9XHMqeGRpclwoXHMqXCRwYXRoIjtpOjI2MztzOjMwOiJcJF9bYS16QS1aMC05X10rXChccypcKTtccypcPz4iO2k6MjY0O3M6MTA6InRhclxzKy16Y0MiO2k6MjY1O3M6ODM6ImVjaG9ccytzdHJfcmVwbGFjZVwoXHMqWyciXVxbUEhQX1NFTEZcXVsnIl1ccyosXHMqYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXVBIUF9TRUxGIjtpOjI2NjtzOjQwOiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1mXCRbYS16QS1aMC05X10rIjtpOjI2NztzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjI2ODtzOjM1OiJocmVmPVsnIl08XD9waHBccytlY2hvXHMrXCRjdXJfcGF0aCI7aToyNjk7czozMzoiPVxzKmVzY191cmxcKFxzKnNpdGVfdXJsXChccypbJyJdIjtpOjI3MDtzOjg1OiJeXHMqPFw/cGhwXHMqaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqWyciXVxzKlwuXHMqWyciXVxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI3MTtzOjE0OiI8dGl0bGU+XHMqaXZueiI7aToyNzI7czo2MzoiXlxzKjxcP3BocFxzKmhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI3MztzOjYxOiJnZXRfdXNlcnNcKFxzKmFycmF5XChccypbJyJdcm9sZVsnIl1ccyo9PlxzKlsnIl1hZG1pbmlzdHJhdG9yIjtpOjI3NDtzOjY1OiJcJHRvXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJddG9fYWRkcmVzcyI7aToyNzU7czoxOToiaW1hcF9oZWFkZXJpbmZvXChcJCI7aToyNzY7czo1NjoiXCRbYS16QS1aMC05X10rXFtccypfW2EtekEtWjAtOV9dK1woXHMqXGQrXHMqXClccypcXVxzKj0iO2k6Mjc3O3M6MzQ6ImV2YWxcKFxzKlsnIl1cPz5bJyJdXHMqXC5ccypqb2luXCgiO2k6Mjc4O3M6MzU6ImJlZ2luXHMrbW9kOlxzK1RoYW5rc1xzK2ZvclxzK3Bvc3RzIjtpOjI3OTtzOjMxOiJbJyJdXHMqXF5ccypcJFthLXpBLVowLTlfXStccyo7IjtpOjI4MDtzOjY1OiJcJFthLXpBLVowLTlfXStccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlxeXHMqXCRbYS16QS1aMC05X10rXHMqOyI7aToyODE7czoxMjA6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKVxzKj09XHMqWyciXSI7aToyODI7czoxMjoiXC53d3cvLzpwdHRoIjtpOjI4MztzOjYzOiIlNjMlNzIlNjklNzAlNzQlMkUlNzMlNzIlNjMlM0QlMjclNjglNzQlNzQlNzAlM0ElMkYlMkYlNzMlNkYlNjEiO2k6Mjg0O3M6Mjc6IndwLW9wdGlvbnNcLnBocFxzKj5ccypFcnJvciI7aToyODU7czo4OToic3RyX3JlcGxhY2VcKGFycmF5XChbJyJdZmlsdGVyU3RhcnRbJyJdLFsnIl1maWx0ZXJFbmRbJyJdXCksXHMqYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCoiO2k6Mjg2O3M6Mzc6ImZpbGVfZ2V0X2NvbnRlbnRzXChfX0ZJTEVfX1wpLFwkbWF0Y2giO2k6Mjg3O3M6MzA6InRvdWNoXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aToyODg7czoyMToiXHxib3RcfHNwaWRlclx8d2dldC9pIjtpOjI4OTtzOjYyOiJzdHJfcmVwbGFjZVwoWyciXTwvYm9keT5bJyJdLFthLXpBLVowLTlfXStcLlsnIl08L2JvZHk+WyciXSxcJCI7aToyOTA7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aToyOTE7czo5MDoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXStccypcKVxzKixccypzdHJpcHNsYXNoZXNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpIjtpOjI5MjtzOjIwODoiPVxzKm1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKVxzKixccypzdHJpcHNsYXNoZXNcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyOTM7czoxNTM6Ij1ccyptYWlsXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXHMqLFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyOTQ7czoxNDoiTGliWG1sMklzQnVnZ3kiO2k6Mjk1O3M6OToibWFhZlxzK3lhIjtpOjI5NjtzOjM0OiJlY2hvIFthLXpBLVowLTlfXStccypcKFsnIl1odHRwOi8vIjtpOjI5NztzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6Mjk4O3M6MTI6ImBjaGVja3N1ZXhlYyI7aToyOTk7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjMwMDtzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6MzAxO3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aTozMDI7czozNzoiPVxzKlsnIl1waHBfdmFsdWVccythdXRvX3ByZXBlbmRfZmlsZSI7aTozMDM7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MzA0O3M6NDY6ImZvcGVuXChccypcJFthLXpBLVowLTlfXStccypcLlxzKlsnIl0vd3AtYWRtaW4iO2k6MzA1O3M6MjI6InJldHVyblxzKlsnIl0vdmFyL3d3dy8iO2k6MzA2O3M6MTg2OiJcJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC4iO2k6MzA3O3M6MTY6InRhZ3MvXCQ2L1wkNC9cJDciO2k6MzA4O3M6MzA6InN0cl9yZXBsYWNlXChccypbJyJdXC5odGFjY2VzcyI7aTozMDk7czo0MzoiZnVuY3Rpb25ccytfXGQrXChccypcJFthLXpBLVowLTlfXStccypcKXtcJCI7aTozMTA7czoyMToiZXhwbG9kZVwoXFxbJyJdO3RleHQ7IjtpOjMxMTtzOjEyMzoic3Vic3RyXChccypcJFthLXpBLVowLTlfXStccyosXHMqXGQrXHMqLFxzKlxkK1xzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypwcmVnX3JlcGxhY2VcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypzdHJ0clwoIjtpOjMxMjtzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6MzEzO3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aTozMTQ7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aTozMTU7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6MzE2O3M6MTU6Ik11c3RAZkBccytTaGVsbCI7aTozMTc7czo2NDoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dKyI7aTozMTg7czozNDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aTozMTk7czo0MDoic3RyX3JlcGxhY2VcKFsnIl1cLmh0YWNjZXNzWyciXVxzKixccypcJCI7aTozMjA7czozMzoiPVxzKkAqZ3ppbmZsYXRlXChccypzdHJyZXZcKFxzKlwkIjtpOjMyMTtzOjIyOiJnXChccypbJyJdRmlsZXNNYW5bJyJdIjtpOjMyMjtzOjI4OiJzdHJfcmVwbGFjZVwoWyciXS9cP2FuZHJbJyJdIjtpOjMyMztzOjIwNDoiXCRbYS16QS1aMC05X10rXHMqPVxzKlwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXTtccypcJFthLXpBLVowLTlfXStccyo9XHMqYXJyYXlcKFxzKlwkX1JFUVVFU1RcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccyphcnJheV9maWx0ZXJcKFxzKlwkIjtpOjMyNDtzOjEyODoiXCRbYS16QS1aMC05X10rXHMqXC49XHMqXCRbYS16QS1aMC05X10re1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dK3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSt7XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10re1xkK30iO2k6MzI1O3M6NzQ6InN0cnBvc1woXCRsLFsnIl1Mb2NhdGlvblsnIl1cKSE9PWZhbHNlXHxcfHN0cnBvc1woXCRsLFsnIl1TZXQtQ29va2llWyciXVwpIjtpOjMyNjtzOjk3OiJhZG1pbi9bJyJdLFsnIl1hZG1pbmlzdHJhdG9yL1snIl0sWyciXWFkbWluMS9bJyJdLFsnIl1hZG1pbjIvWyciXSxbJyJdYWRtaW4zL1snIl0sWyciXWFkbWluNC9bJyJdIjtpOjMyNztzOjE1OiJbJyJdY2hlY2tzdWV4ZWMiO2k6MzI4O3M6NTU6ImlmXHMqXChccypcJHRoaXMtPml0ZW0tPmhpdHNccyo+PVsnIl1cZCtbJyJdXClccyp7XHMqXCQiO2k6MzI5O3M6NDc6ImV4cGxvZGVcKFsnIl1cXG5bJyJdLFxzKlwkX1BPU1RcW1snIl11cmxzWyciXVxdIjtpOjMzMDtzOjExNDoiaWZcKGluaV9nZXRcKFsnIl1hbGxvd191cmxfZm9wZW5bJyJdXClccyo9PVxzKjFcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqZmlsZV9nZXRfY29udGVudHNcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjMzMTtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6MzMyO3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjMzMztzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6MzM0O3M6MjE6ImluY2x1ZGVcKFxzKlsnIl0vdG1wLyI7aTozMzU7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTozMzY7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjMzNztzOjEwOiJkZWtjYWhbJyJdIjtpOjMzODtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTozMzk7czoxMzoiPT1bJyJdXClccypcLiI7aTozNDA7czoxMDM6ImlmXHMqXChccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypzdHJycG9zXChcJFthLXpBLVowLTlfXStccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6MzQxO3M6MTUzOiJcJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKywiO2k6MzQyO3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTozNDM7czo0OToiQCpmaWxlX2dldF9jb250ZW50c1woQCpiYXNlNjRfZGVjb2RlXChAKnVybGRlY29kZSI7aTozNDQ7czoyNToiXCR7W2EtekEtWjAtOV9dK31cKFxzKlwpOyI7aTozNDU7czo2MDoic3Vic3RyXChzcHJpbnRmXChbJyJdJW9bJyJdLFxzKmZpbGVwZXJtc1woXCRmaWxlXClcKSxccyotNFwpIjtpOjM0NjtzOjU1OiJcJFthLXpBLVowLTlfXStcKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjM0NztzOjE2OiJ3c29TZWNQYXJhbVxzKlwoIjtpOjM0ODtzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6MzQ5O3M6Njc6ImNvcHlcKFxzKlsnIl1odHRwOi8vLis/XC50eHRbJyJdXHMqLFxzKlsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdXCkiO2k6MzUwO3M6Mjg6Ilwkc2V0Y29va1xzKlwpO3NldGNvb2tpZVwoXCQiO2k6MzUxO3M6NDkyOiJAKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEAqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoQCpcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6MzUyO3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjM1MztzOjM5OiIoY2hyXChbXHNcd1wkXF5cK1wtXCovXStcKVxzKlwuXHMqKXs0LH0iO2k6MzU0O3M6NDI6Ij1ccypAKmZzb2Nrb3BlblwoXHMqXCRhcmd2XFtcZCtcXVxzKixccyo4MCI7aTozNTU7czozNToiXC5cLi9cLlwuL2VuZ2luZS9kYXRhL2RiY29uZmlnXC5waHAiO2k6MzU2O3M6ODU6InJlY3Vyc2VfY29weVwoXHMqXCRzcmNccyosXHMqXCRkc3RccypcKTtccypoZWFkZXJcKFxzKlsnIl1sb2NhdGlvbjpccypcJGRzdFsnIl1ccypcKTsiO2k6MzU3O3M6MTc6IkdhbnRlbmdlcnNccytDcmV3IjtpOjM1ODtzOjE0MzoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVxzKlthLXpBLVowLTlfXStccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSsiO2k6MzU5O3M6NDA6ImZ3cml0ZVwoXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl08XD9waHAiO2k6MzYwO3M6NTY6IkAqY3JlYXRlX2Z1bmN0aW9uXChccypbJyJdWyciXVxzKixccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjM2MTtzOjk4OiJcXVwoWyciXVwkX1snIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXSI7aTozNjI7czozOToiaWZccypcKFxzKmlzc2V0XChccypcJF9HRVRcW1xzKlsnIl1waW5nIjtpOjM2MztzOjMwOiJyZWFkX2ZpbGVcKFxzKlsnIl1kb21haW5zXC50eHQiO2k6MzY0O3M6MzY6ImV2YWxcKFxzKlsnIl17XHMqXCRbYS16QS1aMC05X10rXHMqfSI7aTozNjU7czoxMDg6ImlmXHMqXChccypmaWxlX2V4aXN0c1woXHMqXCRbYS16QS1aMC05X10rXHMqXClccypcKVxzKntccypjaG1vZFwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aTozNjY7czoxMToiPT1bJyJdXClcKTsiO2k6MzY3O3M6NTU6IlwkW2EtekEtWjAtOV9dKz11cmxkZWNvZGVcKFsnIl0uKz9bJyJdXCk7aWZcKHByZWdfbWF0Y2giO2k6MzY4O3M6ODA6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypkZWNyeXB0X1NPXChccypcJFthLXpBLVowLTlfXStccyosXHMqWyciXVthLXpBLVowLTlfXStbJyJdIjtpOjM2OTtzOjEwNToiPVxzKm1haWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dK1xbXGQrXF1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXStcW1xkK1xdIjtpOjM3MDtzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTozNzE7czo5NDoiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpO1xzKmhlYWRlciI7aTozNzI7czoxMDc6IkBpbmlfc2V0XChbJyJdZXJyb3JfbG9nWyciXSxOVUxMXCk7XHMqQGluaV9zZXRcKFsnIl1sb2dfZXJyb3JzWyciXSwwXCk7XHMqZnVuY3Rpb25ccytyZWFkX2ZpbGVcKFwkZmlsZV9uYW1lIjtpOjM3MztzOjM3OiJcJHRleHRccyo9XHMqaHR0cF9nZXRcKFxzKlsnIl1odHRwOi8vIjtpOjM3NDtzOjE0MzoiXCRbYS16QS1aMC05X10rXHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rXCk7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9odG1sPlsnIl0iO2k6Mzc1O3M6MTU4OiJcI1thLXpBLVowLTlfXStcI1xzKmlmXChlbXB0eVwoXCRbYS16QS1aMC05X10rXClcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqWyciXTxzY3JpcHQuKz88L3NjcmlwdD5bJyJdO1xzKmVjaG9ccytcJFthLXpBLVowLTlfXSs7XHMqfVxzKlwjL1thLXpBLVowLTlfXStcIyI7aTozNzY7czo2NjoiXC5cJF9SRVFVRVNUXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVxzKixccyp0cnVlXHMqLFxzKjMwMlwpIjtpOjM3NztzOjEwNDoiPVxzKmNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqbnVsbFxzKixccypbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1woXCkiO2k6Mzc4O3M6NTQ6Ij1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHBzKjovL1xkK1wuXGQrXC5cZCtcLlxkKyI7aTozNzk7czo1NzoiQ29udGVudC10eXBlOlxzKmFwcGxpY2F0aW9uL3ZuZFwuYW5kcm9pZFwucGFja2FnZS1hcmNoaXZlIjtpOjM4MDtzOjIwOiJzbHVycFx8bXNuYm90XHx0ZW9tYSI7aTozODE7czoyNzoiXCRHTE9CQUxTXFtuZXh0XF1cW1snIl1uZXh0IjtpOjM4MjtzOjE3OToiO0AqXCRbYS16QS1aMC05X10rXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MzgzO3M6Mjk6ImhlYWRlclwoX1thLXpBLVowLTlfXStcKFxkK1wpIjtpOjM4NDtzOjE4MzoiaWZccypcKGlzc2V0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKj09PVxzKlsnIl1bYS16QS1aMC05X10rWyciXVwpIjtpOjM4NTtzOjkwOiJcLj1ccypjaHJcKFwkW2EtekEtWjAtOV9dK1xzKj4+XHMqXChcZCtccypcKlxzKlwoXGQrXHMqLVxzKlwkW2EtekEtWjAtOV9dK1wpXClccyomXHMqXGQrXCkiO2k6Mzg2O3M6MzE6Ii0+cHJlcGFyZVwoWyciXVNIT1dccytEQVRBQkFTRVMiO2k6Mzg3O3M6MjM6InNvY2tzX3N5c3JlYWRcKFwkY2xpZW50IjtpOjM4ODtzOjI0OiI8JWV2YWxcKFxzKlJlcXVlc3RcLkl0ZW0iO2k6Mzg5O3M6OTk6IlwkX1BPU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypmb3BlblwoXHMqXCRfR0VUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXSI7aTozOTA7czo0MDoidXJsPVsnIl1odHRwOi8vc2NhbjR5b3VcLm5ldC9yZW1vdGVcLnBocCI7aTozOTE7czo2MDoiY2FsbF91c2VyX2Z1bmNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStcKTt9IjtpOjM5MjtzOjczOiJwcmVnX3JlcGxhY2VcKFxzKlsnIl0vLis/L2VbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjM5MztzOjEwNjoiPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdLis/WyciXVwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypmb3BlblwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl13WyciXSI7aTozOTQ7czo1OToiaWZcKFxzKlwkW2EtekEtWjAtOV9dK1wpXHMqe1xzKmV2YWxcKFwkW2EtekEtWjAtOV9dK1wpO1xzKn0iO2k6Mzk1O3M6MTc5OiJhcnJheV9tYXBcKFxzKlsnIl1cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXSI7aTozOTY7czoxODE6Ij1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF07XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmZpbGVfcHV0X2NvbnRlbnRzXChccypcJFthLXpBLVowLTlfXStccyosXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpXHMqXCkiO2k6Mzk3O3M6NjE6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz1bJyJdLis/WyciXTtccypoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjoiO2k6Mzk4O3M6MjU6IjwhLS1cI2V4ZWNccytjbWRccyo9XHMqXCQiO2k6Mzk5O3M6ODE6ImlmXChccypzdHJpcG9zXChccypcJFthLXpBLVowLTlfXStccyosXHMqWyciXWFuZHJvaWRbJyJdXHMqXClccyohPT1ccypmYWxzZVwpXHMqeyI7aTo0MDA7czo5MDoiXC49XHMqWyciXTxkaXZccytzdHlsZT1bJyJdZGlzcGxheTpub25lO1snIl0+WyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdPC9kaXY+IjtpOjQwMTtzOjExNDoiPWZpbGVfZXhpc3RzXChcJFthLXpBLVowLTlfXStcKVw/QGZpbGVtdGltZVwoXCRbYS16QS1aMC05X10rXCk6XCRbYS16QS1aMC05X10rO0BmaWxlX3B1dF9jb250ZW50c1woXCRbYS16QS1aMC05X10rIjtpOjQwMjtzOjg5OiJcJFthLXpBLVowLTlfXStccypcW1xzKlthLXpBLVowLTlfXStccypcXVwoXHMqXCRbYS16QS1aMC05X10rXFtccypbYS16QS1aMC05X10rXHMqXF1ccypcKSI7aTo0MDM7czo5NjoiXCRbYS16QS1aMC05X10rLFsnIl1zbHVycFsnIl1cKVxzKiE9PVxzKmZhbHNlXHMqXHxcfFxzKnN0cnBvc1woXHMqXCRbYS16QS1aMC05X10rLFsnIl1zZWFyY2hbJyJdIjtpOjQwNDtzOjYzOiJcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXClccypcKTsiO2k6NDA1O3M6MTc6ImNsYXNzXHMrTUN1cmxccyp7IjtpOjQwNjtzOjU2OiJAaW5pX3NldFwoWyciXWRpc3BsYXlfZXJyb3JzWyciXSwwXCk7XHMqQGVycm9yX3JlcG9ydGluZyI7aTo0MDc7czo2OToiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJGZpbGVwYXRoXHMqXClccypcKVxzKntccyplY2hvXHMrWyciXXVwbG9hZGVkIjtpOjQwODtzOjMwOiJyZXR1cm5ccytSQzQ6OkVuY3J5cHRcKFwkYSxcJGIiO2k6NDA5O3M6MzI6ImZ1bmN0aW9uXHMrZ2V0SFRUUFBhZ2VcKFxzKlwkdXJsIjtpOjQxMDtzOjIxOiI9XHMqcmVxdWVzdFwoXHMqY2hyXCgiO2k6NDExO3M6NTU6IjtccyphcnJheV9maWx0ZXJcKFwkW2EtekEtWjAtOV9dK1xzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6NDEyO3M6MjI4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDEzO3M6MjQxOiJjYWxsX3VzZXJfZnVuY19hcnJheVwoXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKmFycmF5XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjQxNDtzOjg3OiJpZiBcKCEqXCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdXHMqT1JccypcKHN1YnN0clwoXCRfU0VSVkVSXFtbJyJdUkVNT1RFX0FERFIiO2k6NDE1O3M6NTM6InJlbHBhdGh0b2Fic3BhdGhcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQxNjtzOjY4OiJcJGRhdGFcW1snIl1jY19leHBfbW9udGhbJyJdXF1ccyosXHMqc3Vic3RyXChcJGRhdGFcW1snIl1jY19leHBfeWVhciI7aTo0MTc7czo0MDoiXCRbYS16QS1aMC05X10rXHMqKFxbLnsxLDQwfVxdKXsxLH1ccypcKCI7aTo0MTg7czozMzoiY2FsbF91c2VyX2Z1bmNcKFxzKkAqdW5oZXhcKFxzKjB4IjtpOjQxOTtzOjI5OiJcLlwuOjpcW1xzKnBocHJveHlccypcXTo6XC5cLiI7aTo0MjA7czo0NDoiWyciXVxzKlwuXHMqY2hyXChccypcZCsuXGQrXHMqXClccypcLlxzKlsnIl0iO2k6NDIxO3M6MzI6InByZWdfcmVwbGFjZS4qPy9lWyciXVxzKixccypbJyJdIjtpOjQyMjtzOjg1OiJcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjQyMztzOjIzOiJ9ZXZhbFwoYnpkZWNvbXByZXNzXChcJCI7aTo0MjQ7czo1ODoiL3Vzci9sb2NhbC9wc2EvYXBhY2hlL2Jpbi9odHRwZFxzKy1ERlJPTlRQQUdFXHMrLURIQVZFX1NTTCI7aTo0MjU7czo1NzoiaWNvbnZcKGJhc2U2NF9kZWNvZGVcKFsnIl0uKz9bJyJdXClccyosXHMqYmFzZTY0X2RlY29kZVwoIjtpOjQyNjtzOjMzOiI8YnI+WyciXVwucGhwX3VuYW1lXChcKVwuWyciXTxicj4iO2k6NDI3O3M6NjY6IlwpO0BcJFthLXpBLVowLTlfXStcW2NoclwoXGQrXClcXVwoXCRbYS16QS1aMC05X10rXFtjaHJcKFxkK1wpXF1cKCI7aTo0Mjg7czoxMDk6IlxiKGZvcGVufGZpbGVfZ2V0X2NvbnRlbnRzfGZpbGVfcHV0X2NvbnRlbnRzfHN0YXR8Y2htb2R8ZmlsZXxzeW1saW5rKVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDI5O3M6OTU6IlxiKGZvcGVufGZpbGVfZ2V0X2NvbnRlbnRzfGZpbGVfcHV0X2NvbnRlbnRzfHN0YXR8Y2htb2R8ZmlsZXxzeW1saW5rKVwoWyciXWh0dHA6Ly9wYXN0ZWJpblwuY29tIjtpOjQzMDtzOjE1OiJbJyJdL2V0Yy9wYXNzd2QiO2k6NDMxO3M6MTU6IlsnIl0vdmFyL2NwYW5lbCI7aTo0MzI7czoxNDoiWyciXS9ldGMvaHR0cGQiO2k6NDMzO3M6MjA6IlsnIl0vZXRjL25hbWVkXC5jb25mIjtpOjQzNDtzOjEzOiI4OVwuMjQ5XC4yMVwuIjtpOjQzNTtzOjE1OiIxMDlcLjIzOFwuMjQyXC4iO2k6NDM2O3M6OTE6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDM3O3M6NjU6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1pbWFnZXMvIjtpOjQzODtzOjcxOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXChAKnVybGVuY29kZSI7aTo0Mzk7czo3MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoKlsnIl1jZFxzKy90bXAiO2k6NDQwO3M6MzI3OiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6NDQxO3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjtpOjQ0MjtzOjUxOiJcJFthLXpBLVowLTlfXSsgPSBcJFthLXpBLVowLTlfXStcKFsnIl17MCwxfWh0dHA6Ly8iO2k6NDQzO3M6MTM2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rP1wuanBnIjtpOjQ0NDtzOjEzNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz9cLmdpZiI7aTo0NDU7czoxMzY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5wbmciO2k6NDQ2O3M6MTA2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/L1tccyVcLkBcLVwrXChcKS9cd10rP1wucG5nIjtpOjQ0NztzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLmpwZyI7aTo0NDg7czoxMDY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz8vW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5naWYiO2k6NDQ5O3M6MTA2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/L1tccyVcLkBcLVwrXChcKS9cd10rP1wuaWNvIjtpOjQ1MDtzOjEwODoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypkaXJuYW1lXChccypfX0ZJTEVfX1xzKlwpXHMqXC5ccypbJyJdL3dwLWNvbnRlbnQvdXBsb2FkIjtpOjQ1MTtzOjY3OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci93d3cvIjtpOjQ1MjtzOjY0OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL2hvbWUvIjtpOjQ1MztzOjE4OToiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwOi8vIjtpOjQ1NDtzOjIzMToiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwpIjtpOjQ1NTtzOjE1OiJbJyJdXClcKVwpOyJcKTsiO2k6NDU2O3M6OTI6IlwkW2EtekEtWjAtOV9dKz1bJyJdW2EtekEtWjAtOS9cK1w9X10rWyciXTtccyplY2hvXHMrYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rXCk7XHMqXD8+IjtpOjQ1NztzOjYyOiJcJFthLXpBLVowLTlfXSstPl9zY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aTo0NTg7czozNDoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1ldmFsWyciXSI7aTo0NTk7czo0MzoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1iYXNlNjRfZGVjb2RlWyciXSI7aTo0NjA7czo0NToiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1jcmVhdGVfZnVuY3Rpb25bJyJdIjtpOjQ2MTtzOjM2OiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXWFzc2VydFsnIl0iO2k6NDYyO3M6NDI6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdcHJlZ19yZXBsYWNlWyciXSI7aTo0NjM7czoyMTY6IlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKiI7aTo0NjQ7czoxNTA6IlwkW2EtekEtWjAtOV9dK1xbXHMqXCRbYS16QS1aMC05X10rXHMqXF1cW1xzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcLiI7aTo0NjU7czo0MzoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcWyI7aTo0NjY7czo2MzoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1xbIjtpOjQ2NztzOjUwOiJcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqWyciXSI7aTo0Njg7czo3MDoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpXHMqLCI7aTo0Njk7czo2OToiXCRbYS16QS1aMC05X10rXHMqXChccypbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXStccypcKVxzKlwpIjtpOjQ3MDtzOjIzNjoiXCRbYS16QS1aMC05X10rXHMqPVxzKlwkW2EtekEtWjAtOV9dK1woWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStcKFxzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXStccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpXHMqXCkiO2k6NDcxO3M6MTQzOiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXVwkW2EtekEtWjAtOV9dKz1AW2EtekEtWjAtOV9dK1woWyciXS4rP1snIl1cKTtbYS16QS1aMC05X10rXCghXCRbYS16QS1aMC05X10rXCl7XCRbYS16QS1aMC05X10rPUBbYS16QS1aMC05X10rXChccypcKSI7aTo0NzI7czoxMTQ6IlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1cKFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1cKFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXGQrXHMqXF1ccypcKSI7aTo0NzM7czozMjoiXCRbYS16QS1aMC05X10rXChccypAXCRfQ09PS0lFXFsiO2k6NDc0O3M6Mjk6IlwkW2EtekEtWjAtOV9dK1woWyciXS4uZVsnIl0sIjtpOjQ3NTtzOjcwOiJAXCRbYS16QS1aMC05X10rJiZAXCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXSssXCRbYS16QS1aMC05X10rXCk7Ijt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxNDM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7aToxMjE7czozNjoiXCRlbGVtZW50XFtiXF1cKDBcKSx0aGlzXC50cmFuc2l0aW9uIjtpOjEyMjtzOjMxOiJcJG1ldGhvZFwoXCRyZWxhdGlvblxbJ2l0ZW1OYW1lIjtpOjEyMztzOjM2OiJcJHZlcnNpb25cWzFcXVwpO31lbHNlaWZcKHByZWdfbWF0Y2giO2k6MTI0O3M6MzQ6IlwkY29tbWFuZFwoXCRjb21tYW5kc1xbXCRpZGVudGlmaWUiO2k6MTI1O3M6NDI6IlwkY2FsbGFibGVcKFwkcmF3XFsnY2FsbGJhY2snXF1cKFwkY1wpLFwkYyI7aToxMjY7czo0MjoiXCRlbFxbdmFsXF1cKFwpXCkgXCRlbFxbdmFsXF1cKGRhdGFcW3N0YXRlIjtpOjEyNztzOjQ3OiJcJGVsZW1lbnRcW3RcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb25cKCJhZGRDbGFzcyI7aToxMjg7czozMToiXCk7XCNtaXMnLCcgJyxcJGlucHV0XCk7XCRpbnB1dCI7aToxMjk7czozMToia2lsbCAtOSAnXC5cJHBpZFwpO1wkdGhpcy0+Y2xvcyI7aToxMzA7czozMjoiY2FsbF91c2VyX2Z1bmNcKFwkZmlsdGVyLFwkdmFsdWUiO2k6MTMxO3M6MzM6ImNhbGxfdXNlcl9mdW5jXChcJG9wdGlvbnMsXCRlcnJvciI7aToxMzI7czozNjoiY2FsbF91c2VyX2Z1bmNcKFwkbGlzdGVuZXIsXCRldmVudFwpIjtpOjEzMztzOjY1OiJpZlwoc3RyaXBvc1woXCR1c2VyQWdlbnQsJ0FuZHJvaWQnXCkhPT1mYWxzZVwpe1wkdGhpcy0+bW9iaWxlPXRydSI7aToxMzQ7czo1MzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJGZpbGVcKVwpPT0naW5kZXhcLnBocCdcKXsiO2k6MTM1O3M6NjA6InVybGRlY29kZVwoYmFzZTY0X2RlY29kZVwoXCRpbnB1dFwpXCk7XCRleHBsb2RlQXJyYXk9ZXhwbG9kZSI7aToxMzY7czozNzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJHJldHVyblVyaSI7aToxMzc7czo0NzoidXJsZGVjb2RlXCh1cmxkZWNvZGVcKHN0cmlwY3NsYXNoZXNcKFwkc2VnbWVudHMiO2k6MTM4O3M6NTM6Im1haWxcKFwkdG8sXCRzdWJqZWN0LFwkYm9keSxcJGhlYWRlclwpO31lbHNle1wkcmVzdWx0IjtpOjEzOTtzOjM4OiI9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpO1wkdGhpcyI7aToxNDA7czo0MjoiPWluaV9nZXRcKCdkaXNhYmxlX2Z1bmN0aW9ucydcKTtpZlwoIWVtcHR5IjtpOjE0MTtzOjM5OiJldmFsXChcJHBocENvZGVcKTt9ZWxzZXtjbGFzc19hbGlhc1woXCQiO2k6MTQyO3M6NDg6ImV2YWxcKFwkc3RyXCk7fXB1YmxpYyBmdW5jdGlvbiBjb3VudE1lbnVDaGlsZHJlbiI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxNTQ6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfUkVGRVJFUlsnIl1ccypcXVxzKixccypbJyJddHJ1c3RsaW5rXC5ydSI7aToxNjtzOjQyOiJcJFthLXpBLVowLTlfXStccyo9XHMqbmV3XHMqQlNcKFwpO1xzKmVjaG8iO2k6MTc7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxODtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE5O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MjA7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MjE7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIyO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjM7czoxNjY6Imlzc2V0XHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjQ7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCgqXHMqXCRsaWJfcGF0aCI7aToyNTtzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoKlxzKiI7aToyNjtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKSpccyo7XHMqXD8+IjtpOjI3O3M6NzoibGV2aXRyYSI7aToyODtzOjEwOiJkYXBveGV0aW5lIjtpOjI5O3M6NjoidmlhZ3JhIjtpOjMwO3M6NjoiY2lhbGlzIjtpOjMxO3M6ODoicHJvdmlnaWwiO2k6MzI7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMztzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzQ7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjM1O3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzY7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM3O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM4O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM5O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTo0MDtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTo0MTtzOjEwOiJfX0xJTktfXzxhIjtpOjQyO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MztzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQ0O3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDU7czoxNToiX19MSU5LX19fX0VORF9fIjtpOjQ2O3M6MjI6Im5ld1xzK1RSVVNUTElOS19jbGllbnQiO2k6NDc7czo3NDoiclwucGhwXD9pZD1bYS16QS1aMC05X10rJnJlZmVyZXI9JXtIVFRQX0hPU1R9LyV7UkVRVUVTVF9VUkl9XHMrXFtSPTMwMixMXF0iO2k6NDg7czozOToiVXNlci1hZ2VudDpccypHb29nbGVib3RccypEaXNhbGxvdzpccyovIjtpOjQ5O3M6MTg6Im5ld1xzK0xMTV9jbGllbnRcKCI7aTo1MDtzOjM2OiImcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX0iO2k6NTE7czoyOToiXC5waHBcP2lkPVwkMSYle1FVRVJZX1NUUklOR30iO2k6NTI7czozMzoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjUzO3M6MjM6IkFkZEhhbmRsZXJccytwaHAtc2NyaXB0IjtpOjU0O3M6MjM6IkFkZEhhbmRsZXJccytjZ2ktc2NyaXB0IjtpOjU1O3M6NTI6IlJld3JpdGVSdWxlXHMrXC5cKlxzK2luZGV4XC5waHBcP3VybD1cJDBccytcW0wsUVNBXF0iO2k6NTY7czoxMjoicGhwaW5mb1woXCk7IjtpOjU3O3M6MTU6IlwobXNpZVx8b3BlcmFcKSI7aTo1ODtzOjIyOiI8aDE+TG9hZGluZ1wuXC5cLjwvaDE+IjtpOjU5O3M6Mjk6IkVycm9yRG9jdW1lbnRccys1MDBccytodHRwOi8vIjtpOjYwO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDBccytodHRwOi8vIjtpOjYxO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwOi8vIjtpOjYyO3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6NjM7czoxMDE6IjxzY3JpcHRccytsYW5ndWFnZT1bJyJdezAsMX1KYXZhU2NyaXB0WyciXXswLDF9PlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vIjtpOjY0O3M6OTk6ImNoclxzKlwoXHMqMTAxXHMqXClccypcLlxzKmNoclxzKlwoXHMqMTE4XHMqXClccypcLlxzKmNoclxzKlwoXHMqOTdccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMDhccypcKSI7aTo2NTtzOjMwOiJjdXJsXC5oYXh4XC5zZS9yZmMvY29va2llX3NwZWMiO2k6NjY7czoxODoiSm9vbWxhX2JydXRlX0ZvcmNlIjtpOjY3O3M6MzQ6IlJld3JpdGVDb25kXHMqJXtIVFRQOngtd2FwLXByb2ZpbGUiO2k6Njg7czo0MjoiUmV3cml0ZUNvbmRccyole0hUVFA6eC1vcGVyYW1pbmktcGhvbmUtdWF9IjtpOjY5O3M6NjY6IlJld3JpdGVDb25kXHMqJXtIVFRQOkFjY2VwdC1MYW5ndWFnZX1ccypcKHJ1XHxydS1ydVx8dWtcKVxzKlxbTkNcXSI7aTo3MDtzOjI2OiJzbGVzaFwrc2xlc2hcK2RvbWVuXCtwb2ludCI7aTo3MTtzOjE3OiJ0ZWxlZm9ubmF5YS1iYXphLSI7aTo3MjtzOjE4OiJpY3EtZGx5YS10ZWxlZm9uYS0iO2k6NzM7czoyNDoicGFnZV9maWxlcy9zdHlsZTAwMFwuY3NzIjtpOjc0O3M6MjA6InNwcmF2b2NobmlrLW5vbWVyb3YtIjtpOjc1O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjc2O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjc3O3M6MjY6ImluZGV4XC5waHBcP2lkPVwkMSYle1FVRVJZIjtpOjc4O3M6MjA6IlZvbGdvZ3JhZGluZGV4XC5odG1sIjtpOjc5O3M6Mzg6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLWNnaVxzK1wuIjtpOjgwO3M6MTk6Ii1rbHljaC1rLWlncmVcLmh0bWwiO2k6ODE7czoxOToibG1wX2NsaWVudFwoc3RyY29kZSI7aTo4MjtzOjE3OiIvXD9kbz1rYWstdWRhbGl0LSI7aTo4MztzOjE0OiIvXD9kbz1vc2hpYmthLSI7aTo4NDtzOjE5OiIvaW5zdHJ1a3RzaXlhLWRseWEtIjtpOjg1O3M6NDM6ImNvbnRlbnQ9IlxkKztVUkw9aHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS8iO2k6ODY7czo1OToiJTwhLS1cXHNcKlwkbWFya2VyXFxzXCotLT5cLlwrXD88IS0tXFxzXCovXCRtYXJrZXJcXHNcKi0tPiUiO2k6ODc7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aTo4ODtzOjQyOiJSZXdyaXRlUnVsZVxzKlwoXC5cK1wpXHMqaW5kZXhcLnBocFw/cz1cJDAiO2k6ODk7czoxODoiUmVkaXJlY3RccypodHRwOi8vIjtpOjkwO3M6NDU6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP2lkPVwkMSI7aTo5MTtzOjQ0OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9tPVwkMSI7aTo5MjtzOjE5ODoiXGIocGVyY29jZXR8YWRkZXJhbGx8dmlhZ3JhfGNpYWxpc3xsZXZpdHJhfGthdWZlbnxhbWJpZW58Ymx1ZVxzK3BpbGx8Y29jYWluZXxtYXJpanVhbmF8bGlwaXRvcnxwaGVudGVybWlufHByb1tzel1hY3xzYW5keWF1ZXJ8dHJhbWFkb2x8dHJveWhhbWJ5dWx0cmFtfHVuaWNhdWNhfHZhbGl1bXx2aWNvZGlufHhhbmF4fHlweGFpZW8pXHMrb25saW5lIjtpOjkzO3M6NDk6IlJld3JpdGVSdWxlXHMqXC5cKi9cLlwqXHMqW2EtekEtWjAtOV9dK1wucGhwXD9cJDAiO2k6OTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjk1O3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk2O3M6NTI6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/W2EtekEtWjAtOV9dKz0iO2k6OTc7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6OTg7czo1MToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXCRccytodHRwOi8vXGQrXC5cZCtcLlxkK1wuIjtpOjk5O3M6Njc6IjwhLS1jaGVjazpbJyJdXHMqXC5ccyptZDVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTAwO3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aToxMDE7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEwMjtzOjQyOiIle0hUVFBfVVNFUl9BR0VOVH1ccyshd2luZG93cy1tZWRpYS1wbGF5ZXIiO2k6MTAzO3M6ODI6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1ZYW5kZXhCb3QiO2k6MTA0O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX15YW5kZXgiO2k6MTA1O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1nb29nbGUiO2k6MTA2O3M6ODoiL2tyeWFraS8iO2k6MTA3O3M6MTA6IlwucGhwXD9cJDAiO2k6MTA4O3M6NzE6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjEwOTtzOjgwOiJpbmRleFwucGhwXD9tYWluX3BhZ2U9cHJvZHVjdF9pbmZvJnByb2R1Y3RzX2lkPVsnIl1ccypcLlxzKnN0cl9yZXBsYWNlXChbJyJdbGlzdCI7aToxMTA7czozMToiZnNvY2tvcGVuXChccypbJyJdc2hhZHlraXRcLmNvbSI7aToxMTE7czoxMDoiZW9qaWV1XC5jbiI7aToxMTI7czoyMjoiPlxzKjwvaWZyYW1lPlxzKjxcP3BocCI7aToxMTM7czo4MToiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfXJlZnJlc2hbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfVxkKztccyp1cmw9PFw/cGhwIjtpOjExNDtzOjgyOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9UmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKlVSTD1odHRwOi8vIjtpOjExNTtzOjY3OiJcJGZsXHMqPVxzKiI8bWV0YSBodHRwLWVxdWl2PVxcIlJlZnJlc2hcXCJccytjb250ZW50PVxcIlxkKztccypVUkw9IjtpOjExNjtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKnlhbmRleCI7aToxMTc7czozODoiUmV3cml0ZUNvbmRccyole0hUVFBfUkVGRVJFUn1ccypnb29nbGUiO2k6MTE4O3M6NTc6Ik9wdGlvbnNccytGb2xsb3dTeW1MaW5rc1xzK011bHRpVmlld3NccytJbmRleGVzXHMrRXhlY0NHSSI7aToxMTk7czoyODoiZ29vZ2xlXHx5YW5kZXhcfGJvdFx8cmFtYmxlciI7aToxMjA7czo0MToiY29udGVudD1bJyJdezAsMX0xO1VSTD1jZ2ktYmluXC5odG1sXD9jbWQiO2k6MTIxO3M6MTI6ImFuZGV4XHxvb2dsZSI7aToxMjI7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MTIzO3M6NDU6Ik1vemlsbGEvNVwuMFxzKlwoY29tcGF0aWJsZTtccypHb29nbGVib3QvMlwuMSI7aToxMjQ7czo1MDoiaHR0cDovL3d3d1wuYmluZ1wuY29tL3NlYXJjaFw/cT1cJHF1ZXJ5JnBxPVwkcXVlcnkiO2k6MTI1O3M6NDM6Imh0dHA6Ly9nb1wubWFpbFwucnUvc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnkiO2k6MTI2O3M6NjM6Imh0dHA6Ly93d3dcLmdvb2dsZVwuY29tL3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5XC5bJyJdJmhsPVwkbGFuZyI7aToxMjc7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEyODtzOjQ5OiJpZlwoc3RyaXBvc1woXCR1YSxbJyJdYW5kcm9pZFsnIl1cKVxzKiE9PVxzKmZhbHNlIjtpOjEyOTtzOjE1MjoiKHNleHlccytsZXNiaWFuc3xjdW1ccyt2aWRlb3xzZXhccyt2aWRlb3xBbmFsXHMrRnVja3x0ZWVuXHMrc2V4fGZ1Y2tccyt2aWRlb3xCZWFjaFxzK051ZGV8d29tYW5ccytwdXNzeXxzZXhccytwaG90b3xuYWtlZFxzK3RlZW58eHh4XHMrdmlkZW98dGVlblxzK3BpYykiO2k6MTMwO3M6NTY6Imh0dHAtZXF1aXY9WyciXUNvbnRlbnQtTGFuZ3VhZ2VbJyJdXHMrY29udGVudD1bJyJdamFbJyJdIjtpOjEzMTtzOjU2OiJodHRwLWVxdWl2PVsnIl1Db250ZW50LUxhbmd1YWdlWyciXVxzK2NvbnRlbnQ9WyciXWNoWyciXSI7aToxMzI7czoxMToiS0FQUFVTVE9CT1QiO2k6MTMzO3M6Mzg6ImNsYXNzXHMrbFRyYW5zbWl0ZXJ7XHMqdmFyXHMqXCR2ZXJzaW9uIjtpOjEzNDtzOjM3OiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXS90bXAvc3Nlc3NfIjtpOjEzNTtzOjkxOiJmaWxlX2dldF9jb250ZW50c1woYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rXClcLlsnIl1cP1snIl1cLmh0dHBfYnVpbGRfcXVlcnlcKFwkX0dFVFwpIjtpOjEzNjtzOjUwOiJpbmlfc2V0XChbJyJdezAsMX11c2VyX2FnZW50WyciXVxzKixccypbJyJdSlNMSU5LUyI7aToxMzc7czo2MzoiXCRkYi0+cXVlcnlcKFsnIl1TRUxFQ1QgXCogRlJPTSBhcnRpY2xlIFdIRVJFIHVybD1bJyJdXCRyZXF1ZXN0IjtpOjEzODtzOjI0OiI8aHRtbFxzK2xhbmc9WyciXWphWyciXT4iO2k6MTM5O3M6Mzc6InhtbDpsYW5nPVsnIl1qYVsnIl1ccytsYW5nPVsnIl1qYVsnIl0iO2k6MTQwO3M6MTY6Imxhbmc9WyciXWphWyciXT4iO2k6MTQxO3M6MzM6InN0cnBvc1woXCRpbSxbJyJdXFsvVVBEX0NPTlRFTlRcXSI7aToxNDI7czo1OToiPT1ccypbJyJdaW5kZXhcLnBocFsnIl1cKVxzKntccypwcmludFxzK2ZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTQzO3M6MTU6ImNsYXNzXHMrRmF0bGluayI7aToxNDQ7czo0MDoiXCRmPWZpbGVfZ2V0X2NvbnRlbnRzXCgia2V5cy8iXC5cJGtleWZcKSI7aToxNDU7czo1NjoiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXFxcLmh0bWxcJFxzK2luZGV4XC5waHBccytcW25jXF0iO2k6MTQ2O3M6NDU6Im1rZGlyXChbJyJdcGFnZS9bJyJdXC5tYl9zdWJzdHJcKG1kNVwoXCRrZXlcKSI7aToxNDc7czo0NzoiZWxzZWlmIFwoQFwkX0dFVFxbWyciXXBbJyJdXF0gPT0gWyciXWh0bWxbJyJdXCkiO2k6MTQ4O3M6ODg6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVxcL1wkXHMraW5kZXhcLnBocFxzK1Jld3JpdGVSdWxlXHMrXF5yb2JvdHNcLnR4dFwkXHMrcm9ib3RzXC5waHAiO2k6MTQ5O3M6MTE1OiJpZlwoc3RyaXBvc1woXCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdLFxzKlsnIl1Hb29nbGVib3RbJyJdXClccyohPT1ccypmYWxzZVwpe1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjE1MDtzOjIxOiJcJHBhdGhfdG9fZG9yXHMqPVxzKiIiO2k6MTUxO3M6Mzk6InN0cnJldlwoc3RydG91cHBlclwoWyciXXRuZWdhX3Jlc3VfcHR0aCI7aToxNTI7czo2MjoiZmlsZV9wdXRfY29udGVudHNcKFsnIl1jb25mXC5waHBbJyJdXHMqLFxzKlsnIl1cXG5cXFwkc3RvcHBhZ2UiO2k6MTUzO3M6MzM6InNlc3Npb25fbmFtZVwoWyciXXVzZXJvaW50ZXJmZWlzbyI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YTo5MTp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6NTk6IkxvY2F0aW9uOlxzKmh0dHBzOi8vc2VjdXJpdHlcLmdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5IjtpOjcyO3M6NjU6IlwkaXBccyo9XHMqZ2V0ZW52XChccypbJyJdUkVNT1RFX0FERFJbJyJdXHMqXCk7XHMqXCRtZXNzYWdlXHMqXC49IjtpOjczO3M6MTc6ImxvZ2luXC5lYzIxXC5jb20vIjtpOjc0O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTo3NTtzOjM0OiJcJGFkZGRhdGU9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjc2O3M6MzY6IlwkZGF0YW1hc2lpPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NztzOjI3OiJodHRwczovL2FwcGxlaWRcLmFwcGxlXC5jb20iO2k6Nzg7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjgxO3M6NDA6ImJhc2VccytocmVmPVsnIl1odHRwczovL2xvZ2luXC5saXZlXC5jb20iO2k6ODI7czoyNDoiPHRpdGxlPkhvdG1haWxccytBY2NvdW50IjtpOjgzO3M6NDE6IjwhLS1ccytzYXZlZFxzK2Zyb21ccyt1cmw9XChcZCtcKWh0dHBzOi8vIjtpOjg0O3M6MjA6IkJhbmtccytvZlxzK01vbnRyZWFsIjtpOjg1O3M6MjE6InNlY3VyZVwudGFuZ2VyaW5lXC5jYSI7aTo4NjtzOjIyOiJibW9cLmNvbS9vbmxpbmViYW5raW5nIjtpOjg3O3M6NDE6InBtX2ZwPXZlcnNpb24mc3RhdGU9MSZzYXZlRkJDPSZGQkNfTnVtYmVyIjtpOjg4O3M6MjE6ImNpYmNvbmxpbmVcLmNpYmNcLmNvbSI7aTo4OTtzOjMxOiJodHRwczovL3d3d1wudGRjYW5hZGF0cnVzdFwuY29tIjtpOjkwO3M6MjY6IlZpc2l0ZWQgVEQgQkFOSzpccyoiXC5cJGlwIjt9"));
$g_JSVirSig = unserialize(base64_decode("YToxMzg6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czoyMjoiXC5wcm90b3R5cGVcLmF9Y2F0Y2hcKCI7aTo1O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6NjtzOjM0OiJpZlwoUmVmXC5pbmRleE9mXCgnXC5nb29nbGVcLidcKSE9IjtpOjc7czo4NjoiaW5kZXhPZlx8aWZcfHJjXHxsZW5ndGhcfG1zblx8eWFob29cfHJlZmVycmVyXHxhbHRhdmlzdGFcfG9nb1x8YmlcfGhwXHx2YXJcfGFvbFx8cXVlcnkiO2k6ODtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6OTtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjEwO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTE7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTI7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxMztzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNDtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE1O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNjtzOjc6IlxceDY1QXQiO2k6MTc7czo5OiJcXHg2MXJDb2QiO2k6MTg7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToxOTtzOjExOiI9ImV2IlwrImFsIiI7aToyMDtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjE7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIyO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjIzO3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI0O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI1O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MjY7czo5OiJ2YXJccytfMHgiO2k6Mjc7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjg7czoxMDoia20wYWU5Z3I2bSI7aToyOTtzOjY6ImMzMjg0ZCI7aTozMDtzOjg6IlxceDY4YXJDIjtpOjMxO3M6ODoiXFx4NmRDaGEiO2k6MzI7czo3OiJcXHg2ZmRlIjtpOjMzO3M6NzoiXFx4NmZkZSI7aTozNDtzOjg6IlxceDQzb2RlIjtpOjM1O3M6NzoiXFx4NzJvbSI7aTozNjtzOjc6IlxceDQzaGEiO2k6Mzc7czo3OiJcXHg3MkNvIjtpOjM4O3M6ODoiXFx4NDNvZGUiO2k6Mzk7czoxMDoiXC5keW5kbnNcLiI7aTo0MDtzOjk6IlwuZHluZG5zLSI7aTo0MTtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQyO3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0MztzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDQ7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDU7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDY7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjQ3O3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NDg7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjQ5O3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MDtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjUxO3M6Mjk6IjwhLS1bYS16QS1aMC05X10rXHxcfHN0YXQgLS0+IjtpOjUyO3M6ODU6IiZwYXJhbWV0ZXI9XCRrZXl3b3JkJnNlPVwkc2UmdXI9MSZIVFRQX1JFRkVSRVI9J1wrZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwuVVJMXCkiO2k6NTM7czo0ODoid2luZG93c1x8c2VyaWVzXHw2MFx8c3ltYm9zXHxjZVx8bW9iaWxlXHxzeW1iaWFuIjtpOjU0O3M6MzU6IlxbWyciXWV2YWxbJyJdXF1cKHNcKTt9fX19PC9zY3JpcHQ+IjtpOjU1O3M6NTk6ImtDNzBGTWJseUprRldab2RDS2wxV1lPZFdZVWxuUXpSbmJsMVdac1ZFZGxkbUwwNVdadFYzWXZSR0k5IjtpOjU2O3M6NTU6IntrPWk7cz1zXC5jb25jYXRcKHNzXChldmFsXChhc3FcKFwpXCktMVwpXCk7fXo9cztldmFsXCgiO2k6NTc7czoxMzA6ImRvY3VtZW50XC5jb29raWVcLm1hdGNoXChuZXdccytSZWdFeHBcKFxzKiJcKFw/OlxeXHw7IFwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NTg7czo4Njoic2V0Q29va2llXHMqXCgqXHMqImFyeF90dCJccyosXHMqMVxzKixccypkdFwudG9HTVRTdHJpbmdcKFwpXHMqLFxzKlsnIl17MCwxfS9bJyJdezAsMX0iO2k6NTk7czoxNDQ6ImRvY3VtZW50XC5jb29raWVcLm1hdGNoXHMqXChccypuZXdccytSZWdFeHBccypcKFxzKiJcKFw/OlxeXHw7XHMqXCkiXHMqXCtccypuYW1lXC5yZXBsYWNlXHMqXCgvXChcW1xcXC5cJFw/XCpcfHt9XFxcKFxcXClcXFxbXFxcXVxcL1xcXCtcXlxdXCkvZyI7aTo2MDtzOjk4OiJ2YXJccytkdFxzKz1ccytuZXdccytEYXRlXChcKSxccytleHBpcnlUaW1lXHMrPVxzK2R0XC5zZXRUaW1lXChccytkdFwuZ2V0VGltZVwoXClccytcK1xzKzkwMDAwMDAwMCI7aTo2MTtzOjEwNToiaWZccypcKFxzKm51bVxzKj09PVxzKjBccypcKVxzKntccypyZXR1cm5ccyoxO1xzKn1ccyplbHNlXHMqe1xzKnJldHVyblxzK251bVxzKlwqXHMqckZhY3RcKFxzKm51bVxzKi1ccyoxIjtpOjYyO3M6NDE6IlwrPVN0cmluZ1wuZnJvbUNoYXJDb2RlXChwYXJzZUludFwoMFwrJ3gnIjtpOjYzO3M6ODM6IjxzY3JpcHRccytsYW5ndWFnZT0iSmF2YVNjcmlwdCI+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb249Imh0dHA6Ly92a1wuY29tIjtpOjY0O3M6NDQ6ImxvY2F0aW9uXC5yZXBsYWNlXChbJyJdezAsMX1odHRwOi8vdjVrNDVcLnJ1IjtpOjY1O3M6MTI5OiI7dHJ5e1wrXCtkb2N1bWVudFwuYm9keX1jYXRjaFwocVwpe2FhPWZ1bmN0aW9uXChmZlwpe2ZvclwoaT0wO2k8elwubGVuZ3RoO2lcK1wrXCl7emFcKz1TdHJpbmdcW2ZmXF1cKGVcKHZcK1woelxbaVxdXClcKS0xMlwpO319O30iO2k6NjY7czoxNDI6ImRvY3VtZW50XC53cml0ZVxzKlwoWyciXXswLDF9PFsnIl17MCwxfVxzKlwrXHMqeFxbMFxdXHMqXCtccypbJyJdezAsMX0gWyciXXswLDF9XHMqXCtccyp4XFs0XF1ccypcK1xzKlsnIl17MCwxfT5cLlsnIl17MCwxfVxzKlwreFxzKlxbMlxdXHMqXCsiO2k6Njc7czo2MDoiaWZcKHRcLmxlbmd0aD09Mlwpe3pcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKHRcKVwrIjtpOjY4O3M6NzQ6IndpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntccyppZlxzKlwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoIjtpOjY5O3M6OTc6Ilwuc3R5bGVcLmhlaWdodFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07d2luZG93XC5vbmxvYWRccyo9XHMqZnVuY3Rpb25cKFwpXHMqe2RvY3VtZW50XC5jb29raWUiO2k6NzA7czoxMjI6Ilwuc3JjPVwoWyciXXswLDF9aHRwczpbJyJdezAsMX09PWRvY3VtZW50XC5sb2NhdGlvblwucHJvdG9jb2xcP1snIl17MCwxfWh0dHBzOi8vc3NsWyciXXswLDF9OlsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1cKVwrIjtpOjcxO3M6MzA6IjQwNFwucGhwWyciXXswLDF9PlxzKjwvc2NyaXB0PiI7aTo3MjtzOjc2OiJwcmVnX21hdGNoXChbJyJdezAsMX0vc2FwZS9pWyciXXswLDF9XHMqLFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSIjtpOjczO3M6NzQ6ImRpdlwuaW5uZXJIVE1MXHMqXCs9XHMqWyciXXswLDF9PGVtYmVkXHMraWQ9ImR1bW15MiJccytuYW1lPSJkdW1teTIiXHMrc3JjIjtpOjc0O3M6NzM6InNldFRpbWVvdXRcKFsnIl17MCwxfWFkZE5ld09iamVjdFwoXClbJyJdezAsMX0sXGQrXCk7fX19O2FkZE5ld09iamVjdFwoXCkiO2k6NzU7czo1MToiXChiPWRvY3VtZW50XClcLmhlYWRcLmFwcGVuZENoaWxkXChiXC5jcmVhdGVFbGVtZW50IjtpOjc2O3M6MzA6IkNocm9tZVx8aVBhZFx8aVBob25lXHxJRU1vYmlsZSI7aTo3NztzOjE5OiJcJDpcKHt9XCsiIlwpXFtcJFxdIjtpOjc4O3M6NDk6IjwvaWZyYW1lPlsnIl1cKTtccyp2YXJccytqPW5ld1xzK0RhdGVcKG5ld1xzK0RhdGUiO2k6Nzk7czo1Mzoie3Bvc2l0aW9uOmFic29sdXRlO3RvcDotOTk5OXB4O308L3N0eWxlPjxkaXZccytjbGFzcz0iO2k6ODA7czoxMjg6ImlmXHMqXChcKHVhXC5pbmRleE9mXChbJyJdezAsMX1jaHJvbWVbJyJdezAsMX1cKVxzKj09XHMqLTFccyomJlxzKnVhXC5pbmRleE9mXCgid2luIlwpXHMqIT1ccyotMVwpXHMqJiZccypuYXZpZ2F0b3JcLmphdmFFbmFibGVkIjtpOjgxO3M6NTg6InBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPVsnIl17MCwxfWh0dHA6Ly92a1wuY29tXC4iO2k6ODI7czo0MToiXF1cLnN1YnN0clwoMCwxXClcKTt9fXJldHVybiB0aGlzO30sXFx1MDAiO2k6ODM7czo2ODoiamF2YXNjcmlwdFx8aGVhZFx8dG9Mb3dlckNhc2VcfGNocm9tZVx8d2luXHxqYXZhRW5hYmxlZFx8YXBwZW5kQ2hpbGQiO2k6ODQ7czoyMToibG9hZFBOR0RhdGFcKHN0ckZpbGUsIjtpOjg1O3M6MjA6IlwpO2lmXCghflwoWyciXXswLDF9IjtpOjg2O3M6MjM6Ii8vXHMqU29tZVwuZGV2aWNlc1wuYXJlIjtpOjg3O3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjg4O3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6ODk7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5MDtzOjQ4OiJzdHJpcG9zXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKixccypsaXN0X2RhdGFcW2kiO2k6OTE7czoyNjoiaWZccypcKCFzZWVfdXNlcl9hZ2VudFwoXCkiO2k6OTI7czo0NjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlsnIl1bJyJdO31pZlwoIWdldENvb2tpZSI7aTo5MztzOjcwOiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9ZnRwOi8vIjtpOjk0O3M6NDg6ImlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXChbJyJdezAsMX1zYWJyaSI7aTo5NTtzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6OTY7czoxMTQ6IlwpO1xzKmlmXChccypbYS16QS1aMC05X10rXC50ZXN0XChccypkb2N1bWVudFwucmVmZXJyZXJccypcKVxzKiYmXHMqW2EtekEtWjAtOV9dK1wpXHMqe1xzKmRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo5NztzOjUyOiJpZlwoL0FuZHJvaWQvaVxbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwobmF2aWdhdG9yIjtpOjk4O3M6Njk6ImZ1bmN0aW9uXChhXCl7aWZcKGEmJlsnIl1kYXRhWyciXWluXGQrYSYmYVwuZGF0YVwuYVxkKyYmYVwuZGF0YVwuYVxkKyI7aTo5OTtzOjU4OiJzXChvXCl9XCl9LGY9ZnVuY3Rpb25cKFwpe3ZhciB0LGk9SlNPTlwuc3RyaW5naWZ5XChlXCk7b1woIjtpOjEwMDtzOjEwNjoiPFxkK1xzK1xkKz1bJyJdXGQrL1xkK1xcWyciXVwrXFxbJyJdLlxcWyciXVwrXFxbJyJdLlsnIl1ccysuPVsnIl0uOi8vXGQrXFxbJyJdXCtcXFsnIl0uXC5cZCtcXFsnIl1cK1xcWyciXSI7aToxMDE7czoxMDc6InNldFRpbWVvdXRcKFxkK1wpO1xzKnZhclxzK2RlZmF1bHRfa2V5d29yZFxzKj1ccyplbmNvZGVVUklDb21wb25lbnRcKGRvY3VtZW50XC50aXRsZVwpO1xzKnZhclxzK3NlX3JlZmVycmVyIjtpOjEwMjtzOjk4OiI9ZG9jdW1lbnRcLnJlZmVycmVyO2lmXChSZWZcLmluZGV4T2ZcKFsnIl1cLmdvb2dsZVwuWyciXVwpIT0tMVx8XHxSZWZcLmluZGV4T2ZcKFsnIl1cLmJpbmdcLlsnIl1cKSI7aToxMDM7czoyMDoidmlzaXRvclRyYWNrZXJfaXNNb2IiO2k6MTA0O3M6NDE6Ii9cKlx3ezMyfVwqL3ZhclxzK18weFthLXpBLVowLTlfXSs9XFsiXFx4IjtpOjEwNTtzOjcxOiIvXCpcd3szMn1cKi87d2luZG93XFtbJyJdZG9jdW1lbnRbJyJdXF1cW1snIl1bYS16QS1aMC05X10rWyciXVxdPVxbWyciXSI7aToxMDY7czo0ODoiXF1cXVwuam9pblwoXFxbJyJdXFxbJyJdXCk7WyciXVwpXCk7L1wqXHd7MzJ9XCovIjtpOjEwNztzOjEzNDoiO3ZhclxzK1thLXpBLVowLTlfXSs9W2EtekEtWjAtOV9dK1wuY2hhckNvZGVBdFwoXGQrXClcXlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKFthLXpBLVowLTlfXStcKTtbYS16QS1aMC05X10rPVN0cmluZ1wuZnJvbUNoYXJDb2RlXCgiO2k6MTA4O3M6Mzg6ImV2YWxcKGV2YWxcKFsnIl1TdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjEwOTtzOjEwMDoiY2xlbjtpXCtcK1wpe2JcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoYVwuY2hhckNvZGVBdFwoaVwpXF4yXCl9Yz11bmVzY2FwZVwoYlwpO2RvY3VtZW50XC53cml0ZVwoY1wpOyI7aToxMTA7czoxNzoic2V4ZnJvbWluZGlhXC5jb20iO2k6MTExO3M6MTE6ImZpbGVreFwuY29tIjtpOjExMjtzOjEzOiJzdHVtbWFublwubmV0IjtpOjExMztzOjE0OiJ0b3BsYXlnYW1lXC5ydSI7aToxMTQ7czoxNDoiaHR0cDovL3h6eFwucG0iO2k6MTE1O3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aToxMTY7czoxMToibW9iaS1nb1wuaW4iO2k6MTE3O3M6MTg6ImJhbmtvZmFtZXJpY2FcLmNvbSI7aToxMTg7czoxNjoibXlmaWxlc3RvcmVcLmNvbSI7aToxMTk7czoxNzoiZmlsZXN0b3JlNzJcLmluZm8iO2k6MTIwO3M6MTY6ImZpbGUyc3RvcmVcLmluZm8iO2k6MTIxO3M6MTU6InVybDJzaG9ydFwuaW5mbyI7aToxMjI7czoxODoiZmlsZXN0b3JlMTIzXC5pbmZvIjtpOjEyMztzOjEyOiJ1cmwxMjNcLmluZm8iO2k6MTI0O3M6MTQ6ImRvbGxhcmFkZVwuY29tIjtpOjEyNTtzOjExOiJzZWNjbGlrXC5ydSI7aToxMjY7czoxMToibW9ieS1hYVwucnUiO2k6MTI3O3M6MTI6InNlcnZsb2FkXC5ydSI7aToxMjg7czo3OiJubm5cLnBtIjtpOjEyOTtzOjc6Im5ubVwucG0iO2k6MTMwO3M6MTY6Im1vYi1yZWRpcmVjdFwucnUiO2k6MTMxO3M6MTY6IndlYi1yZWRpcmVjdFwucnUiO2k6MTMyO3M6MTY6InRvcC13ZWJwaWxsXC5jb20iO2k6MTMzO3M6MTk6Imdvb2RwaWxsc2VydmljZVwucnUiO2k6MTM0O3M6MTQ6InlvdXR1aWJlc1wuY29tIjtpOjEzNTtzOjE0OiJ1bnNjcmV3aW5nXC5ydSI7aToxMzY7czoyNjoibG9hZG1lXC5jaGlja2Vua2lsbGVyXC5jb20iO2k6MTM3O3M6MzE6InNoYXJlXC5wbHVzb1wucnUvcGx1c28tbGlrZVwuanMiO30="));
$gX_JSVirSig = unserialize(base64_decode("YTo3MDp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjg1OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs9dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXStccypcKTtccyp2YXJccytFeHBEYXRlIjtpOjE1O3M6NzI6IjwhLS1ccypbYS16QS1aMC05X10rXHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqW2EtekEtWjAtOV9dK1xzKi0tPiI7aToxNjtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToxNztzOjcxOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rXCtbJyJddGVbJyJdXHMqXF1cKFN0cmluZyI7aToxODtzOjc4OiJzZXRDb29raWVcKFxzKl8weFthLXpBLVowLTlfXStccyosXHMqXzB4W2EtekEtWjAtOV9dK1xzKixccypfMHhbYS16QS1aMC05X10rXCkiO2k6MTk7czoyOToiXF1cKFxzKnZcK1wrXHMqXCktMVxzKlwpXHMqXCkiO2k6MjA7czo0MzoiZG9jdW1lbnRcW1xzKl8weFthLXpBLVowLTlfXStcW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjEyMzoiaVxbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dK1xbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoXGQrLFxkK1wpXClcKXt3aW5kb3dcW18weFthLXpBLVowLTlfXStcW1xkK1xdXF09bG9jIjtpOjI1O3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MjY7czo1MDoiWyciXVxdXChbYS16QS1aMC05X10rXCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6Mjc7czo2NDoiO3doaWxlXChbYS16QS1aMC05X10rPFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aToyODtzOjEwODoiaWZccypcKFthLXpBLVowLTlfXStcLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjI5O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzA7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzE7czoxMzA6ImZhbHNlfTtbYS16QS1aMC05X10rPVthLXpBLVowLTlfXStcKFsnIl1bYS16QS1aMC05X10rWyciXVwpXHxbYS16QS1aMC05X10rXChbJyJdW2EtekEtWjAtOV9dK1snIl1cKTtbYS16QS1aMC05X10rXHw9W2EtekEtWjAtOV9dKzsiO2k6MzI7czo2NDoiU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NTc6IlxbWyciXWNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rXHMqXCtccypbJyJdQXRbJyJdXF1cKCI7aTozNTtzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjM2O3M6NTU6IlN0cmluZ1xbXHMqWyciXWZyb21DaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dK1xzKlxdXCgiO2k6Mzc7czoyODoiLj1bJyJdLjovLy5cLi5cLi5cLi4vLlwuLlwuLiI7aTozODtzOjM5OiI8L3NjcmlwdD5bJyJdXCk7XHMqL1wqL1thLXpBLVowLTlfXStcKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo5NzoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChbYS16QS1aMC05X10rXCk7XHMqc1wuc3JjXHMqPSI7aTo0MztzOjE5OiIuOi8vLlwuLlwuLi8uXC4uXD8vIjtpOjQ0O3M6Mzk6IlxkK1xzKj5ccypcZCtccypcP1xzKlsnIl1cXHhcZCtbJyJdXHMqOiI7aTo0NTtzOjQ1OiJbJyJdXFtccypbJyJdY2hhckNvZGVBdFsnIl1ccypcXVwoXHMqXGQrXHMqXCkiO2k6NDY7czoxNzoiPC9ib2R5PlxzKjxzY3JpcHQiO2k6NDc7czoxNzoiPC9odG1sPlxzKjxzY3JpcHQiO2k6NDg7czoxNzoiPC9odG1sPlxzKjxpZnJhbWUiO2k6NDk7czo0MjoiZG9jdW1lbnRcLndyaXRlXChccypTdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjUwO3M6MjI6InNyYz0iZmlsZXNfc2l0ZS9qc1wuanMiO2k6NTE7czo5NDoid2luZG93XC5wb3N0TWVzc2FnZVwoe1xzKnpvcnN5c3RlbTpccyoxLFxzKnR5cGU6XHMqWyciXXVwZGF0ZVsnIl0sXHMqcGFyYW1zOlxzKntccypbJyJddXJsWyciXSI7aTo1MjtzOjk4OiJcLmF0dGFjaEV2ZW50XChbJyJdb25sb2FkWyciXSxhXCk6W2EtekEtWjAtOV9dK1wuYWRkRXZlbnRMaXN0ZW5lclwoWyciXWxvYWRbJyJdLGEsITFcKTtsb2FkTWF0Y2hlciI7aTo1MztzOjc4OiJpZlwoXChhPWVcLmdldEVsZW1lbnRzQnlUYWdOYW1lXChbJyJdYVsnIl1cKVwpJiZhXFswXF0mJmFcWzBcXVwuaHJlZlwpZm9yXCh2YXIiO2k6NTQ7czo4MToiO1xzKmVsZW1lbnRcLmlubmVySFRNTFxzKj1ccypbJyJdPGlmcmFtZVxzK3NyYz1bJyJdXHMqXCtccyp4aHJcLnJlc3BvbnNlVGV4dFxzKlwrIjtpOjU1O3M6MTk6IlhIRkVSMVxzKj1ccypYSEZFUjEiO2k6NTY7czo1MToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZVxzKlwoXHMqWyciXXswLDF9JTNDIjtpOjU3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aTo1ODtzOjU1OiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vXGQrXC5cZCtcLlxkK1wuXGQrL1w/IjtpOjU5O3M6NjY6InNldFRpbWVvdXRcKGZ1bmN0aW9uXChcKXt2YXJccytwYXR0ZXJuXHMqPVxzKm5ld1xzKlJlZ0V4cFwoL2dvb2dsZSI7aTo2MDtzOjY2OiJ3bz1bJyJdXCshIVwoWyciXW9udG91Y2hzdGFydFsnIl1ccytpblxzK3dpbmRvd1wpXCtbJyJdJnN0PTEmdGl0bGUiO2k6NjE7czo1NjoicmVmZXJyZXJccyohPT1ccypbJyJdWyciXVwpe2RvY3VtZW50XC53cml0ZVwoWyciXTxzY3JpcHQiO2k6NjI7czozNzoiaWZcKGEmJlsnIl1kYXRhWyciXWluXHMqYSYmYVwuZGF0YVwuYSI7aTo2MztzOjYwOiJqcXVlcnlcLm1pblwucGhwWyciXTsgdmFyIG5fdXJsID0gYmFzZSBcKyAiXD9kZWZhdWx0X2tleXdvcmQiO2k6NjQ7czo4NjoiZG9jdW1lbnRcW1thLXpBLVowLTlfXStcKFthLXpBLVowLTlfXStcW1xkK1xdXClcXVwoW2EtekEtWjAtOV9dK1woW2EtekEtWjAtOV9dK1xbXGQrXF0iO2k6NjU7czo1ODoiaFwuZlwoXFxbJyJdPDMgNz1bJyJdOC85XFxbJyJdXCtcXFsnIl1hXFxbJyJdXCtcXFsnIl1iWyciXSI7aTo2NjtzOjI1OiJcKFwpfX0sXGQrXCk7L1wqXHd7MzJ9XCovIjtpOjY3O3M6NDk6ImV2YWxbJyJdXC5zcGxpdFwoWyciXVx8WyciXVwpLDAse31cKVwpO1xzKn1cKFwpXCkiO2k6Njg7czoxNToiXC50cnlteWZpbmdlclwuIjtpOjY5O3M6MTk6Ilwub25lc3RlcHRvd2luXC5jb20iO30="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqWyciXChcJF0iO2k6MTIyO3M6MTE6IlxibWFpbFxzKlwoIjtpOjEyMztzOjQ2OiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKlsnIl17MCwxfXBocDovL2lucHV0IjtpOjEyNDtzOjExODoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfUNvbnRlbnQtdHlwZVsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9dGV4dC9odG1sO1xzKmNoYXJzZXQ9d2luZG93cy0xMjUxWyciXXswLDF9Pjxib2R5PiI7aToxMjU7czo2MjoiPVxzKmRvY3VtZW50XC5jcmVhdGVFbGVtZW50XChccypbJyJdezAsMX1zY3JpcHRbJyJdezAsMX1ccypcKTsiO2k6MTI2O3M6Njk6ImRvY3VtZW50XC5ib2R5XC5pbnNlcnRCZWZvcmVcKGRpdixccypkb2N1bWVudFwuYm9keVwuY2hpbGRyZW5cWzBcXVwpOyI7aToxMjc7czo3NjoiPHNjcmlwdFxzK3R5cGU9InRleHQvamF2YXNjcmlwdCJccytzcmM9Imh0dHA6Ly9bYS16QS1aMC05X10rXC5waHAiPjwvc2NyaXB0PiI7aToxMjg7czoyNzoiZWNob1xzK1snIl17MCwxfW9rWyciXXswLDF9IjtpOjEyOTtzOjE4OiIvdXNyL3NiaW4vc2VuZG1haWwiO2k6MTMwO3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjt9"));
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
                              
define('AI_VERSION', '20160227');

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
		'scan:',
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
  -x, --mode=INT       Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
      --scan=php,...   Scan only specific extensions. E.g. --skip=php,htaccess,js
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

	if (isset($options['scan']))
	{
		$ext_list = strtolower(trim($options['scan'], " ,\t\n\r\0\x0B"));
		if ($ext_list != '')
		{
			$l_FastCli = true;
			$g_SensitiveFiles = explode(",", $ext_list);
			stdOut("Scan extensions: " . $ext_list);
		}
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
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['crc'][$l_Pos] . '</div></td>';
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
		   if (SHORT_PHP_TAG) {
//                      $l_Content = preg_replace('|<\?\s|smiS', '<?php ', $l_Content); 
                   }

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

				$g_CRC = _hash_($l_Unwrapped);


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

//   if (pcre_error($l_FN, $l_Index)) {  }

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

//   if (pcre_error($l_FN, $l_Index)) {  }

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

//   if (pcre_error($l_FN, $l_Index)) {  }

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

//   if (pcre_error($l_FN, $l_Index)) {  }
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

//   if (pcre_error($l_FN, $l_Index)) {  }
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
/*
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
*/

QCR_Debug();

// Load custom signatures

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

// whitelist

$snum = 0;
$list = check_whitelist($g_Structure['crc'], $snum);

foreach (array('g_CriticalPHP', 'g_CriticalJS', 'g_Iframer', 'g_Base64', 'g_Phishing', 'g_AdwareList', 'g_Redirect') as $p) {
	if (empty($$p)) continue;
	
	$p_Fragment = $p . "Fragment";
	$p_Sig = $p . "Sig";

	$count = count($$p);
	for ($i = 0; $i < $count; $i++) {
		$id = "{${$p}[$i]}";
		if (in_array($g_Structure['crc'][$id], $list)) {
			unset($GLOBALS[$p][$i]);
			unset($GLOBALS[$p_Sig][$i]);
			unset($GLOBALS[$p_Fragment][$i]);
		}
	}

	$$p = array_values($$p);
	$$p_Fragment = array_values($$p_Fragment);
	if (!empty($$p_Sig)) $$p_Sig = array_values($$p_Sig);
}


////////////////////////////////////////////////////////////////////////////
 if ($BOOL_RESULT) {
  if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR  (count($g_Iframer) > 0) OR  (count($g_UnixExec) > 0))
  {
  echo "1\n";
  exit(0);
  }
 }
////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@SERVICE_INFO@@", htmlspecialchars("[" . $int_enc . "][" . $snum . "]"), $l_Template);

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
		if ($g_FlexDBShe[$i] == '[a-zA-Z0-9_]+?\(\s*[a-zA-Z0-9_]+?=\s*\)') $g_FlexDBShe[$i] = '\((?<=[a-zA-Z0-9_].)\s*[a-zA-Z0-9_]++=\s*\)';
		if ($g_FlexDBShe[$i] == '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e') $g_FlexDBShe[$i] = '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e';
		if ($g_FlexDBShe[$i] == '$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.') $g_FlexDBShe[$i] = '\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.';

		$g_FlexDBShe[$i] = str_replace('http://.+?/.+?\.php\?a', 'http://[^?\s]++(?<=\.php)\?a', $g_FlexDBShe[$i]);
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
        //optSig($g_SusDBPrio);
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

	$tmp = array();
	foreach ($sigs as $i => $s) {
		if (strpos($s, '.+') !== false || strpos($s, '.*') !== false) {
			unset($sigs[$i]);
			$tmp[] = $s;
		}
	}
	
	usort($sigs, 'strcasecmp');
	$txt = implode("\n", $sigs);

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i-=4 : --$i) {
		$txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|)){' . $i . ',}).*(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
	}

	$sigs = array_merge(explode("\n", $txt), $tmp);
	
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


function _hash_($text)
{
	static $r;
	
	if (empty($r)) {
		for ($i = 0; $i < 256; $i++) {
			if ($i < 33 OR $i > 127 ) $r[chr($i)] = '';
		}
	}

	return sha1(strtr($text, $r));
}

function check_whitelist($list, &$snum) 
{
	if (empty($list)) return array();
	
	$file = dirname(__FILE__) . '/AIBOLIT-WHITELIST.db';

	$snum = @filesize($file) / 8;
	echo "\nLoaded $snum known files\n";
	
	sort($list);

	$hash = reset($list);
	
	$fp = @fopen($file, 'rb');
	
	if (false === $fp) return array();
	
	$header = unpack('V256', fread($fp, 1024));
	
	$result = array();
	
	foreach ($header as $chunk_id => $chunk_size) {
		if ($chunk_size > 0) {
			$str = fread($fp, $chunk_size);
			
			do {
				$raw = pack("H*", $hash);
				$id = ord($raw[0]) + 1;
				
				if ($chunk_id == $id AND binarySearch($str, $raw)) {
					$result[] = $hash;
				}
				
			} while ($chunk_id >= $id AND $hash = next($list));
			
			if ($hash === false) break;
		}
	}
	
	fclose($fp);

	return $result;
}


function binarySearch($str, $item)
{
	$item_size = strlen($item);
	
	if ( $item_size == 0 ) return false;
	
	$first = 0;

	$last = floor(strlen($str)/$item_size);
	
	/* Если просматриваемый участок непустой, first < last */
	while ($first < $last) {
		$mid = $first + (($last - $first) >> 1);
		$b = substr($str, $mid * $item_size, $item_size);
		if (strcmp($item, $b) <= 0)
			$last = $mid;
		else
			$first = $mid + 1;
	}

	$b = substr($str, $last * $item_size, $item_size);
	if ($b == $item) {
        /* Искомый элемент найден. last - искомый индекс */
		return true;
	} else {
        /* Искомый элемент не найден. Но если вам вдруг надо его
         * вставить со сдвигом, то его место - last.
         */
		return false;
	}
}
