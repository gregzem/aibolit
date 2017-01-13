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
define('AI_EXPERT_MODE', 1); 

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 
define('PASS', '????????????????'); 

//define('LANG', 'EN');
define('LANG', 'RU');

define('REPORT_MASK_PHPSIGN', 1);
define('REPORT_MASK_SPAMLINKS', 2);
define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_SUSP', 8);
define('REPORT_MASK_CANDI', 16);
define('REPORT_MASK_WRIT', 32);
define('REPORT_MASK_FULL', 0 // REPORT_MASK_PHPSIGN | REPORT_MASK_DOORWAYS | REPORT_MASK_SUSP
/* <-- remove this line to enable "recommendations"  

| REPORT_MASK_SPAMLINKS 

 remove this line to enable "recommendations" --> */
);

define('AI_HOSTER', 0); 
define('SMART_SCAN', 1);

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '600K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
    	'skip_ext' => '',
        'skip_cache' => false,
	'report_mask' => REPORT_MASK_FULL
);


define('DEBUG_MODE', 0);

define('DIR_SEPARATOR', '/');

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)/* && stripos('CygWin', $_SERVER['OS']) === false)*/) {
   define('DIR_SEPARATOR', '\\');
}

$g_SuspiciousFiles = array('cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'shtml', 'susp', 'suspected');
$g_SensitiveFiles = array_merge(array('php', 'js', 'htaccess', 'html', 'htm', 'tpl', 'inc', 'css', 'txt', 'sql'), $g_SuspiciousFiles);
$g_CriticalFiles = array('php', 'htaccess', 'cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'shtml', 'susp', 'suspected', 'infected', 'vir');
$g_CriticalEntries = '<\?php|<\?=|#!/usr|#!/bin|eval|assert|base64_decode|system|create_function|exec|popen|fwrite|fputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|move|copy|array_|reg_replace|mysql_|chr|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles = array('js', 'html', 'htm', 'suspicious');
$g_VirusEntries = '<\s*script|<\s*iframe|<\s*object|<\s*embed|fromCharCode|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles = array('js', 'html', 'htm', 'suspected', 'php', 'pht', 'php7');
$g_PhishEntries = '<\s*title|<\s*html|<\s*form|<\s*body|bank|account';
$g_ShortListExt = array('php', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'html', 'htm', 'phtml', 'shtml', 'khtml');

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
define('AI_STR_010', "Сканер AI-Bolit запускается с паролем. Если это первый запуск сканера, вам нужно придумать сложный пароль и вписать его в файле ai-bolit.php в строке №34. <p>Например, <b>define('PASS', '%s');</b><p>
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
	   <p><hr size=1></p>
	   Также выполните дополнительный анализ новым <b><a href="http://rescan.pro/?utm=aibolit" target=_blank>веб-сканером ReScan.Pro</a></b>.
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
		     <p>Contact us via email if you have any questions regarding the scanner or need report analysis: <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
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
 <div class="crit" style="font-size: 17px;"><b>Attention! The scanner has detected malicious files.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/contacts/" target=_blank>contact website security experts</a> or experienced webmaster as soon as possible to check the report or remove the malware from files.
 <p><hr size=1></p>
 Also, online website analysis is available using our new <b><a href="http://rescan.pro/?utm=aibo" target=_blank>ReScan.Pro Web Scanner</a></b>.
</div>
<br/>
<div>
   <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="https://revisium.com/en/contacts/">https://revisium.com/en/home/</a>
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

//BEGIN_SIG 10/01/2017 03:11:41
$g_DBShe = unserialize(base64_decode("YTo0MzI6e2k6MDtzOjE1OiJ3NGwzWHpZMyBNYWlsZXIiO2k6MTtzOjEwOiJDb2RlZF9ieV9WIjtpOjI7czozNToibW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbPHFxPkYxbDMiO2k6MztzOjEzOiJCeTxzMT5LeW1Mam5rIjtpOjQ7czoxMzoiQnk8czE+U2g0TGluayI7aTo1O3M6MTY6IkJ5PHMxPkFub25Db2RlcnMiO2k6NjtzOjQ2OiIkdXNlckFnZW50cyA9IGFycmF5KCJHb29nbGUiLCAiU2x1cnAiLCAiTVNOQm90IjtpOjc7czo2OiJbM3Jhbl0iO2k6ODtzOjEwOiJEYXduX2FuZ2VsIjtpOjk7czo4OiJSM0RUVVhFUyI7aToxMDtzOjIwOiJ2aXNpdG9yVHJhY2tlcl9pc01vYiI7aToxMTtzOjI0OiJjb21fY29udGVudC9hcnRpY2xlZC5waHAiO2k6MTI7czoxNzoiPHRpdGxlPkVtc1Byb3h5IHYiO2k6MTM7czoxMzoiYW5kcm9pZC1pZ3JhLSI7aToxNDtzOjE1OiI9PT06OjptYWQ6Ojo9PT0iO2k6MTU7czo1OiJINHhPciI7aToxNjtzOjg6IlI0cEg0eDByIjtpOjE3O3M6ODoiTkc2ODlTa3ciO2k6MTg7czoxMToiZm9wby5jb20uYXIiO2k6MTk7czo5OiI2NC42OC44MC4iO2k6MjA7czo4OiJIYXJjaGFMaSI7aToyMTtzOjE1OiJ4eFI5OW11c3ZpZWkweDAiO2k6MjI7czoxMToiUC5oLnAuUy5wLnkiO2k6MjM7czoxNDoiX3NoZWxsX2F0aWxkaV8iO2k6MjQ7czo5OiJ+IFNoZWxsIEkiO2k6MjU7czo2OiIweGRkODIiO2k6MjY7czoxNDoiQW50aWNoYXQgc2hlbGwiO2k6Mjc7czoxMjoiQUxFTWlOIEtSQUxpIjtpOjI4O3M6MTY6IkFTUFggU2hlbGwgYnkgTFQiO2k6Mjk7czo5OiJhWlJhaUxQaFAiO2k6MzA7czoyMjoiQ29kZWQgQnkgQ2hhcmxpY2hhcGxpbiI7aTozMTtzOjc6IkJsMG9kM3IiO2k6MzI7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjMzO3M6MTE6ImRldmlselNoZWxsIjtpOjM0O3M6MzA6IldyaXR0ZW4gYnkgQ2FwdGFpbiBDcnVuY2ggVGVhbSI7aTozNTtzOjk6ImMyMDA3LnBocCI7aTozNjtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjM3O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjM4O3M6OToiQzk5IFNoZWxsIjtpOjM5O3M6MjI6ImNvb2tpZW5hbWUgPSAid2llZWVlZSIiO2k6NDA7czozODoiQ29kZWQgYnkgOiBTdXBlci1DcnlzdGFsIGFuZCBNb2hhamVyMjIiO2k6NDE7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjQyO3M6MjM6IlRFQU0gU0NSSVBUSU5HIC0gUk9ETk9DIjtpOjQzO3M6MTE6IkN5YmVyIFNoZWxsIjtpOjQ0O3M6NzoiZDBtYWlucyI7aTo0NTtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjQ2O3M6MjQ6IlNoZWxsIHdyaXR0ZW4gYnkgQmwwb2QzciI7aTo0NztzOjMzOiJEaXZlIFNoZWxsIC0gRW1wZXJvciBIYWNraW5nIFRlYW0iO2k6NDg7czoxNToiRGV2ci1pIE1lZnNlZGV0IjtpOjQ5O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjUwO3M6MjA6IkVtcGVyb3IgSGFja2luZyBURUFNIjtpOjUxO3M6MjA6IkZpeGVkIGJ5IEFydCBPZiBIYWNrIjtpOjUyO3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aTo1MztzOjI3OiJMdXRmZW4gRG9zeWF5aSBBZGxhbmRpcmluaXoiO2k6NTQ7czoyMjoidGhpcyBpcyBhIHByaXYzIHNlcnZlciI7aTo1NTtzOjEzOiJHRlMgV2ViLVNoZWxsIjtpOjU2O3M6MTE6IkdIQyBNYW5hZ2VyIjtpOjU3O3M6MTQ6Ikdvb2cxZV9hbmFsaXN0IjtpOjU4O3M6MTM6IkdyaW5heSBHbzBvJEUiO2k6NTk7czoyOToiaDRudHUgc2hlbGwgW3Bvd2VyZWQgYnkgdHNvaV0iO2k6NjA7czoyNToiSGFja2VkIEJ5IERldnItaSBNZWZzZWRldCI7aTo2MTtzOjE3OiJIQUNLRUQgQlkgUkVBTFdBUiI7aTo2MjtzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTo2MztzOjExOiJpTUhhQmlSTGlHaSI7aTo2NDtzOjk6IktBX3VTaGVsbCI7aTo2NTtzOjc6IkxpejB6aU0iO2k6NjY7czoxMToiTG9jdXM3U2hlbGwiO2k6Njc7czozNjoiTW9yb2NjYW4gU3BhbWVycyBNYS1FZGl0aW9OIEJ5IEdoT3NUIjtpOjY4O3M6MTA6Ik1hdGFtdSBNYXQiO2k6Njk7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6NzA7czo2OiJtMHJ0aXgiO2k6NzE7czo1OiJtMGh6ZSI7aTo3MjtzOjEwOiJNYXRhbXUgTWF0IjtpOjczO3M6MTY6Ik1vcm9jY2FuIFNwYW1lcnMiO2k6NzQ7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjc1O3M6OToiTXlTUUwgUlNUIjtpOjc2O3M6MTk6Ik15U1FMIFdlYiBJbnRlcmZhY2UiO2k6Nzc7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjc4O3M6MTQ6Ik15U1FMIFdlYnNoZWxsIjtpOjc5O3M6ODoiTjN0c2hlbGwiO2k6ODA7czoxNjoiSGFja2VkIGJ5IFNpbHZlciI7aTo4MTtzOjE2OiJIYUNrZUQgQnkgRmFsbGFnIjtpOjgyO3M6NzoiTmVvSGFjayI7aTo4MztzOjEwOiJCeSBLeW1Mam5rIjtpOjg0O3M6MTA6IkJpZyBSM3p1bHQiO2k6ODU7czoyMToiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIjtpOjg2O3M6MjA6Ik5JWCBSRU1PVEUgV0VCLVNIRUxMIjtpOjg3O3M6MjY6Ik8gQmlSIEtSQUwgVEFLTGlUIEVEaWxFTUVaIjtpOjg4O3M6MTg6IlBIQU5UQVNNQS0gTmVXIENtRCI7aTo4OTtzOjIxOiJQSVJBVEVTIENSRVcgV0FTIEhFUkUiO2k6OTA7czoyMToiYSBzaW1wbGUgcGhwIGJhY2tkb29yIjtpOjkxO3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjkyO3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6OTM7czo5OiJQSFBKYWNrYWwiO2k6OTQ7czoyMDoiUEhQIEhWQSBTaGVsbCBTY3JpcHQiO2k6OTU7czoxMzoicGhwUmVtb3RlVmlldyI7aTo5NjtzOjM1OiJQSFAgU2hlbGwgaXMgYW5pbnRlcmFjdGl2ZSBQSFAtcGFnZSI7aTo5NztzOjY6IlBIVmF5diI7aTo5ODtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTo5OTtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjEwMDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjEwMTtzOjU6InIwbmluIjtpOjEwMjtzOjY6IlI1N1NxbCI7aToxMDM7czoxMzoicjU3c2hlbGxcLnBocCI7aToxMDQ7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjEwNTtzOjIwOiJyZWFsYXV0aD1TdkJEODVkSU51MyI7aToxMDY7czoxNjoiUnUyNFBvc3RXZWJTaGVsbCI7aToxMDc7czoyMToiS0Fkb3QgVW5pdmVyc2FsIFNoZWxsIjtpOjEwODtzOjEwOiJDckB6eV9LaW5nIjtpOjEwOTtzOjIwOiJTYWZlX01vZGUgQnlwYXNzIFBIUCI7aToxMTA7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MTExO3M6MjU6IlNpbXBsZSBQSFAgYmFja2Rvb3IgYnkgREsiO2k6MTEyO3M6MTk6IkctU2VjdXJpdHkgV2Vic2hlbGwiO2k6MTEzO3M6MjU6IlNpbW9yZ2ggU2VjdXJpdHkgTWFnYXppbmUiO2k6MTE0O3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjExNTtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjExNjtzOjExOiJTdG9ybTdTaGVsbCI7aToxMTc7czo5OiJUaGVfQmVLaVIiO2k6MTE4O3M6OToiVzNEIFNoZWxsIjtpOjExOTtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjEyMDtzOjI4OiJkZXZlbG9wZWQgYnkgRGlnaXRhbCBPdXRjYXN0IjtpOjEyMTtzOjMyOiJXYXRjaCBZb3VyIHN5c3RlbSBTaGFueSB3YXMgaGVyZSI7aToxMjI7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjEyMztzOjEzOiJXU08yIFdlYnNoZWxsIjtpOjEyNDtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MTI1O3M6Mjc6IlNtYWxsIFBIUCBXZWIgU2hlbGwgYnkgWmFDbyI7aToxMjY7czoxMDoiTXJsb29sLmV4ZSI7aToxMjc7czo2OiJTRW9ET1IiO2k6MTI4O3M6OToiTXIuSGlUbWFuIjtpOjEyOTtzOjU6ImQzYn5YIjtpOjEzMDtzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjEzMTtzOjEwOiJCWSBNTU5CT0JaIjtpOjEzMjtzOjI2OiJPTEI6UFJPRFVDVDpPTkxJTkVfQkFOS0lORyI7aToxMzM7czoxMDoiQzBkZXJ6LmNvbSI7aToxMzQ7czo3OiJNckhhemVtIjtpOjEzNTtzOjk6InYwbGQzbTBydCI7aToxMzY7czo2OiJLIUxMM3IiO2k6MTM3O3M6MTA6IkRyLmFib2xhbGgiO2k6MTM4O3M6MzA6IiRyYW5kX3dyaXRhYmxlX2ZvbGRlcl9mdWxscGF0aCI7aToxMzk7czo4NDoiPHRleHRhcmVhIG5hbWU9XCJwaHBldlwiIHJvd3M9XCI1XCIgY29scz1cIjE1MFwiPiIuQCRfUE9TVFsncGhwZXYnXS4iPC90ZXh0YXJlYT48YnI+IjtpOjE0MDtzOjE2OiJjOTlmdHBicnV0ZWNoZWNrIjtpOjE0MTtzOjk6IkJ5IFBzeWNoMCI7aToxNDI7czoxNzoiJGM5OXNoX3VwZGF0ZWZ1cmwiO2k6MTQzO3M6MTQ6InRlbXBfcjU3X3RhYmxlIjtpOjE0NDtzOjE3OiJhZG1pbkBzcHlncnVwLm9yZyI7aToxNDU7czo3OiJjYXN1czE1IjtpOjE0NjtzOjEzOiJXU0NSSVBULlNIRUxMIjtpOjE0NztzOjQ3OiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj0jZGNkY2RjPlskY21kXSI7aToxNDg7czoxMToiY3RzaGVsbC5waHAiO2k6MTQ5O3M6MTU6IkRYX0hlYWRlcl9kcmF3biI7aToxNTA7czo4NjoiY3JsZi4ndW5saW5rKCRuYW1lKTsnLiRjcmxmLidyZW5hbWUoIn4iLiRuYW1lLCAkbmFtZSk7Jy4kY3JsZi4ndW5saW5rKCJncnBfcmVwYWlyLnBocCIiO2k6MTUxO3M6MTA1OiIvMHRWU0cvU3V2MFVyL2hhVVlBZG4zak1Rd2Jib2NHZmZBZUMyOUJOOXRtQmlKZFYxbGsrallEVTkyQzk0amR0RGlmK3hPWWpHNkNMaHgzMVVvOXg5L2VBV2dzQks2MGtLMm1Md3F6cWQiO2k6MTUyO3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjE1MztzOjM3OiJrbGFzdmF5di5hc3A/eWVuaWRvc3lhPTwlPWFrdGlma2xhcyU+IjtpOjE1NDtzOjEyMjoibnQpKGRpc2tfdG90YWxfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiAiIC4gIkZyZWUgc3BhY2UgIiAuIChpbnQpKGRpc2tfZnJlZV9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iIDwiO2k6MTU1O3M6NzY6ImEgaHJlZj0iPD9lY2hvICIkZmlzdGlrLnBocD9kaXppbj0kZGl6aW4vLi4vIj8+IiBzdHlsZT0idGV4dC1kZWNvcmF0aW9uOiBub24iO2k6MTU2O3M6Mzg6IlJvb3RTaGVsbCEnKTtzZWxmLmxvY2F0aW9uLmhyZWY9J2h0dHA6IjtpOjE1NztzOjkwOiI8JT1SZXF1ZXN0LlNlcnZlclZhcmlhYmxlcygic2NyaXB0X25hbWUiKSU+P0ZvbGRlclBhdGg9PCU9U2VydmVyLlVSTFBhdGhFbmNvZGUoRm9sZGVyLkRyaXYiO2k6MTU4O3M6MTYwOiJwcmludCgoaXNfcmVhZGFibGUoJGYpICYmIGlzX3dyaXRlYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIi53KDEpLmZvbnQoJ3JlZCcsJ1JXJywzKSkudygxKTooKChpc19yZWFkYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIikudyg0KToiIikuKChpc193cml0YWJsIjtpOjE1OTtzOjE2MToiKCciJywnJnF1b3Q7JywkZm4pKS4nIjtkb2N1bWVudC5saXN0LnN1Ym1pdCgpO1wnPicuaHRtbHNwZWNpYWxjaGFycyhzdHJsZW4oJGZuKT5mb3JtYXQ/c3Vic3RyKCRmbiwwLGZvcm1hdC0zKS4nLi4uJzokZm4pLic8L2E+Jy5zdHJfcmVwZWF0KCcgJyxmb3JtYXQtc3RybGVuKCRmbikiO2k6MTYwO3M6MTE6InplaGlyaGFja2VyIjtpOjE2MTtzOjM5OiJKQCFWckAqJlJIUnd+Skx3Lkd8eGxobkxKfj8xLmJ3T2J4YlB8IVYiO2k6MTYyO3M6Mzk6IldTT3NldGNvb2tpZShtZDUoJF9TRVJWRVJbJ0hUVFBfSE9TVCddKSI7aToxNjM7czoxNDE6IjwvdGQ+PHRkIGlkPWZhPlsgPGEgdGl0bGU9XCJIb21lOiAnIi5odG1sc3BlY2lhbGNoYXJzKHN0cl9yZXBsYWNlKCJcIiwgJHNlcCwgZ2V0Y3dkKCkpKS4iJy5cIiBpZD1mYSBocmVmPVwiamF2YXNjcmlwdDpWaWV3RGlyKCciLnJhd3VybGVuY29kZSI7aToxNjQ7czoxNjoiQ29udGVudC1UeXBlOiAkXyI7aToxNjU7czo4NjoiPG5vYnI+PGI+JGNkaXIkY2ZpbGU8L2I+ICgiLiRmaWxlWyJzaXplX3N0ciJdLiIpPC9ub2JyPjwvdGQ+PC90cj48Zm9ybSBuYW1lPWN1cnJfZmlsZT4iO2k6MTY2O3M6NDg6Indzb0V4KCd0YXIgY2Z6diAnIC4gZXNjYXBlc2hlbGxhcmcoJF9QT1NUWydwMiddKSI7aToxNjc7czoxNDI6IjVqYjIwaUtXOXlJSE4wY21semRISW9KSEpsWm1WeVpYSXNJbUZ3YjNKMElpa2diM0lnYzNSeWFYTjBjaWdrY21WbVpYSmxjaXdpYm1sbmJXRWlLU0J2Y2lCemRISnBjM1J5S0NSeVpXWmxjbVZ5TENKM1pXSmhiSFJoSWlrZ2IzSWdjM1J5YVhOMGNpZ2siO2k6MTY4O3M6NzY6IkxTMGdSSFZ0Y0ROa0lHSjVJRkJwY25Wc2FXNHVVRWhRSUZkbFluTm9NMnhzSUhZeExqQWdZekJrWldRZ1lua2djakJrY2pFZ09rdz0iO2k6MTY5O3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjE3MDtzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjE3MTtzOjEyOiJQSFBTSEVMTC5QSFAiO2k6MTcyO3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjE3MztzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjE3NDtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjE3NTtzOjIxOiJGYVRhTGlzVGlDel9GeCBGeDI5U2giO2k6MTc2O3M6NDI6Ildvcmtlcl9HZXRSZXBseUNvZGUoJG9wRGF0YVsncmVjdkJ1ZmZlciddKSI7aToxNzc7czo0MDoiJGZpbGVwYXRoPUByZWFscGF0aCgkX1BPU1RbJ2ZpbGVwYXRoJ10pOyI7aToxNzg7czo4ODoiJHJlZGlyZWN0VVJMPSdodHRwOi8vJy4kclNpdGUuJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ107aWYoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddKSI7aToxNzk7czoxNzoicmVuYW1lKCJ3c28ucGhwIiwiO2k6MTgwO3M6NTQ6IiRNZXNzYWdlU3ViamVjdCA9IGJhc2U2NF9kZWNvZGUoJF9QT1NUWyJtc2dzdWJqZWN0Il0pOyI7aToxODE7czo0NDoiY29weSgkX0ZJTEVTW3hdW3RtcF9uYW1lXSwkX0ZJTEVTW3hdW25hbWVdKSkiO2k6MTgyO3M6NTg6IlNFTEVDVCAxIEZST00gbXlzcWwudXNlciBXSEVSRSBjb25jYXQoYHVzZXJgLCAnQCcsIGBob3N0YCkiO2k6MTgzO3M6MjE6IiFAJF9DT09LSUVbJHNlc3NkdF9rXSI7aToxODQ7czo0ODoiJGE9KHN1YnN0cih1cmxlbmNvZGUocHJpbnRfcihhcnJheSgpLDEpKSw1LDEpLmMpIjtpOjE4NTtzOjU2OiJ4aCAtcyAiL3Vzci9sb2NhbC9hcGFjaGUvc2Jpbi9odHRwZCAtRFNTTCIgLi9odHRwZCAtbSAkMSI7aToxODY7czoxODoicHdkID4gR2VuZXJhc2kuZGlyIjtpOjE4NztzOjEyOiJCUlVURUZPUkNJTkciO2k6MTg4O3M6MzE6IkNhdXRhbSBmaXNpZXJlbGUgZGUgY29uZmlndXJhcmUiO2k6MTg5O3M6MzI6IiRrYT0nPD8vL0JSRSc7JGtha2E9JGthLidBQ0svLz8+IjtpOjE5MDtzOjg1OiIkc3Viaj11cmxkZWNvZGUoJF9HRVRbJ3N1J10pOyRib2R5PXVybGRlY29kZSgkX0dFVFsnYm8nXSk7JHNkcz11cmxkZWNvZGUoJF9HRVRbJ3NkJ10pIjtpOjE5MTtzOjM5OiIkX19fXz1AZ3ppbmZsYXRlKCRfX19fKSl7aWYoaXNzZXQoJF9QT1MiO2k6MTkyO3M6Mzc6InBhc3N0aHJ1KGdldGVudigiSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTkzO3M6ODoiQXNtb2RldXMiO2k6MTk0O3M6NTA6ImZvcig7JHBhZGRyPWFjY2VwdChDTElFTlQsIFNFUlZFUik7Y2xvc2UgQ0xJRU5UKSB7IjtpOjE5NTtzOjU5OiIkaXppbmxlcjI9c3Vic3RyKGJhc2VfY29udmVydChAZmlsZXBlcm1zKCRmbmFtZSksMTAsOCksLTQpOyI7aToxOTY7czo0MjoiJGJhY2tkb29yLT5jY29weSgkY2ZpY2hpZXIsJGNkZXN0aW5hdGlvbik7IjtpOjE5NztzOjIzOiJ7JHtwYXNzdGhydSgkY21kKX19PGJyPiI7aToxOTg7czoyOToiJGFbaGl0c10nKTsgXHJcbiNlbmRxdWVyeVxyXG4iO2k6MTk5O3M6MjY6Im5jZnRwcHV0IC11ICRmdHBfdXNlcl9uYW1lIjtpOjIwMDtzOjM2OiJleGVjbCgiL2Jpbi9zaCIsInNoIiwiLWkiLChjaGFyKikwKTsiO2k6MjAxO3M6MzE6IjxIVE1MPjxIRUFEPjxUSVRMRT5jZ2ktc2hlbGwucHkiO2k6MjAyO3M6Mzg6InN5c3RlbSgidW5zZXQgSElTVEZJTEU7IHVuc2V0IFNBVkVISVNUIjtpOjIwMztzOjIzOiIkbG9naW49QHBvc2l4X2dldHVpZCgpOyI7aToyMDQ7czo2MDoiKGVyZWcoJ15bWzpibGFuazpdXSpjZFtbOmJsYW5rOl1dKiQnLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSkpIjtpOjIwNTtzOjI1OiIhJF9SRVFVRVNUWyJjOTlzaF9zdXJsIl0pIjtpOjIwNjtzOjUzOiJQblZsa1dNNjMhQCNAJmRLeH5uTURXTX5Efy9Fc25+eH82REAjQCZQfn4sP25ZLFdQe1BvaiI7aToyMDc7czozNjoic2hlbGxfZXhlYygkX1BPU1RbJ2NtZCddIC4gIiAyPiYxIik7IjtpOjIwODtzOjM1OiJpZighJHdob2FtaSkkd2hvYW1pPWV4ZWMoIndob2FtaSIpOyI7aToyMDk7czo2MToiUHlTeXN0ZW1TdGF0ZS5pbml0aWFsaXplKFN5c3RlbS5nZXRQcm9wZXJ0aWVzKCksIG51bGwsIGFyZ3YpOyI7aToyMTA7czozNjoiPCU9ZW52LnF1ZXJ5SGFzaHRhYmxlKCJ1c2VyLm5hbWUiKSU+IjtpOjIxMTtzOjgzOiJpZiAoZW1wdHkoJF9QT1NUWyd3c2VyJ10pKSB7JHdzZXIgPSAid2hvaXMucmlwZS5uZXQiO30gZWxzZSAkd3NlciA9ICRfUE9TVFsnd3NlciddOyI7aToyMTI7czo5MToiaWYgKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWydmaWxhJ11bJ3RtcF9uYW1lJ10sICRjdXJkaXIuIi8iLiRfRklMRVNbJ2ZpbGEnXVsnbmFtZSddKSkgeyI7aToyMTM7czoyMzoic2hlbGxfZXhlYygndW5hbWUgLWEnKTsiO2k6MjE0O3M6NDc6ImlmICghZGVmaW5lZCRwYXJhbXtjbWR9KXskcGFyYW17Y21kfT0ibHMgLWxhIn07IjtpOjIxNTtzOjYwOiJpZihnZXRfbWFnaWNfcXVvdGVzX2dwYygpKSRzaGVsbE91dD1zdHJpcHNsYXNoZXMoJHNoZWxsT3V0KTsiO2k6MjE2O3M6ODQ6IjxhIGhyZWY9JyRQSFBfU0VMRj9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9JGRibmFtZSZ0YWJsZW5hbWU9JHRhYmxlbmFtZSc+U2NoZW1hPC9hPiI7aToyMTc7czo2NjoicGFzc3RocnUoICRiaW5kaXIuIm15c3FsZHVtcCAtLXVzZXI9JFVTRVJOQU1FIC0tcGFzc3dvcmQ9JFBBU1NXT1JEIjtpOjIxODtzOjY2OiJteXNxbF9xdWVyeSgiQ1JFQVRFIFRBQkxFIGB4cGxvaXRgIChgeHBsb2l0YCBMT05HQkxPQiBOT1QgTlVMTCkiKTsiO2k6MjE5O3M6ODc6IiRyYTQ0ICA9IHJhbmQoMSw5OTk5OSk7JHNqOTggPSAic2gtJHJhNDQiOyRtbCA9ICIkc2Q5OCI7JGE1ID0gJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOyI7aToyMjA7czo1MjoiJF9GSUxFU1sncHJvYmUnXVsnc2l6ZSddLCAkX0ZJTEVTWydwcm9iZSddWyd0eXBlJ10pOyI7aToyMjE7czo3MToic3lzdGVtKCIkY21kIDE+IC90bXAvY21kdGVtcCAyPiYxOyBjYXQgL3RtcC9jbWR0ZW1wOyBybSAvdG1wL2NtZHRlbXAiKTsiO2k6MjIyO3M6Njk6In0gZWxzaWYgKCRzZXJ2YXJnID1+IC9eXDooLis/KVwhKC4rPylcQCguKz8pIFBSSVZNU0cgKC4rPykgXDooLispLykgeyI7aToyMjM7czo2OToic2VuZChTT0NLNSwgJG1zZywgMCwgc29ja2FkZHJfaW4oJHBvcnRhLCAkaWFkZHIpKSBhbmQgJHBhY290ZXN7b30rKzs7IjtpOjIyNDtzOjE4OiIkZmUoIiRjbWQgIDI+JjEiKTsiO2k6MjI1O3M6Njg6IndoaWxlICgkcm93ID0gbXlzcWxfZmV0Y2hfYXJyYXkoJHJlc3VsdCxNWVNRTF9BU1NPQykpIHByaW50X3IoJHJvdyk7IjtpOjIyNjtzOjUyOiJlbHNlaWYoQGlzX3dyaXRhYmxlKCRGTikgJiYgQGlzX2ZpbGUoJEZOKSkgJHRtcE91dE1GIjtpOjIyNztzOjcyOiJjb25uZWN0KFNPQ0tFVCwgc29ja2FkZHJfaW4oJEFSR1ZbMV0sIGluZXRfYXRvbigkQVJHVlswXSkpKSBvciBkaWUgcHJpbnQiO2k6MjI4O3M6ODk6ImlmKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWyJmaWMiXVsidG1wX25hbWUiXSxnb29kX2xpbmsoIi4vIi4kX0ZJTEVTWyJmaWMiXVsibmFtZSJdKSkpIjtpOjIyOTtzOjg3OiJVTklPTiBTRUxFQ1QgJzAnICwgJzw/IHN5c3RlbShcJF9HRVRbY3BjXSk7ZXhpdDsgPz4nICwwICwwICwwICwwIElOVE8gT1VURklMRSAnJG91dGZpbGUiO2k6MjMwO3M6Njg6ImlmICghQGlzX2xpbmsoJGZpbGUpICYmICgkciA9IHJlYWxwYXRoKCRmaWxlKSkgIT0gRkFMU0UpICRmaWxlID0gJHI7IjtpOjIzMTtzOjI5OiJlY2hvICJGSUxFIFVQTE9BREVEIFRPICRkZXoiOyI7aToyMzI7czoyNDoiJGZ1bmN0aW9uKCRfUE9TVFsnY21kJ10pIjtpOjIzMztzOjM4OiIkZmlsZW5hbWUgPSAkYmFja3Vwc3RyaW5nLiIkZmlsZW5hbWUiOyI7aToyMzQ7czo0ODoiaWYoJyc9PSgkZGY9QGluaV9nZXQoJ2Rpc2FibGVfZnVuY3Rpb25zJykpKXtlY2hvIjtpOjIzNTtzOjQ2OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3QuU2VydmVyVmFyaWFibGVzICU+IjtpOjIzNjtzOjMzOiJpZiAoJGZ1bmNhcmcgPX4gL15wb3J0c2NhbiAoLiopLykiO2k6MjM3O3M6NTU6IiR1cGxvYWRmaWxlID0gJHJwYXRoLiIvIiAuICRfRklMRVNbJ3VzZXJmaWxlJ11bJ25hbWUnXTsiO2k6MjM4O3M6MjY6IiRjbWQgPSAoJF9SRVFVRVNUWydjbWQnXSk7IjtpOjIzOTtzOjM4OiJpZigkY21kICE9ICIiKSBwcmludCBTaGVsbF9FeGVjKCRjbWQpOyI7aToyNDA7czoyOToiaWYgKGlzX2ZpbGUoIi90bXAvJGVraW5jaSIpKXsiO2k6MjQxO3M6Njk6Il9fYWxsX18gPSBbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXSI7aToyNDI7czo1OToiZ2xvYmFsICRteXNxbEhhbmRsZSwgJGRibmFtZSwgJHRhYmxlbmFtZSwgJG9sZF9uYW1lLCAkbmFtZSwiO2k6MjQzO3M6Mjc6IjI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOyI7aToyNDQ7czo1MjoibWFwIHsgcmVhZF9zaGVsbCgkXykgfSAoJHNlbF9zaGVsbC0+Y2FuX3JlYWQoMC4wMSkpOyI7aToyNDU7czoyMjoiZndyaXRlICgkZnAsICIkeWF6aSIpOyI7aToyNDY7czo1MToiU2VuZCB0aGlzIGZpbGU6IDxJTlBVVCBOQU1FPSJ1c2VyZmlsZSIgVFlQRT0iZmlsZSI+IjtpOjI0NztzOjQyOiIkZGJfZCA9IEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlLCRjb24xKTsiO2k6MjQ4O3M6Njc6ImZvciAoJHZhbHVlKSB7IHMvJi8mYW1wOy9nOyBzLzwvJmx0Oy9nOyBzLz4vJmd0Oy9nOyBzLyIvJnF1b3Q7L2c7IH0iO2k6MjQ5O3M6NzQ6ImNvcHkoJF9GSUxFU1sndXBrayddWyd0bXBfbmFtZSddLCJray8iLmJhc2VuYW1lKCRfRklMRVNbJ3Vwa2snXVsnbmFtZSddKSk7IjtpOjI1MDtzOjg2OiJmdW5jdGlvbiBnb29nbGVfYm90KCkgeyRzVXNlckFnZW50ID0gc3RydG9sb3dlcigkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pO2lmKCEoc3RycCI7aToyNTE7czo3NToiY3JlYXRlX2Z1bmN0aW9uKCImJCIuImZ1bmN0aW9uIiwiJCIuImZ1bmN0aW9uID0gY2hyKG9yZCgkIi4iZnVuY3Rpb24pLTMpOyIpIjtpOjI1MjtzOjQ2OiJsb25nIGludDp0KDAsMyk9cigwLDMpOy0yMTQ3NDgzNjQ4OzIxNDc0ODM2NDc7IjtpOjI1MztzOjQ2OiI/dXJsPScuJF9TRVJWRVJbJ0hUVFBfSE9TVCddKS51bmxpbmsoUk9PVF9ESVIuIjtpOjI1NDtzOjM2OiJjYXQgJHtibGtsb2dbMl19IHwgZ3JlcCAicm9vdDp4OjA6MCIiO2k6MjU1O3M6OTc6IkBwYXRoMT0oJ2FkbWluLycsJ2FkbWluaXN0cmF0b3IvJywnbW9kZXJhdG9yLycsJ3dlYmFkbWluLycsJ2FkbWluYXJlYS8nLCdiYi1hZG1pbi8nLCdhZG1pbkxvZ2luLyciO2k6MjU2O3M6ODc6IiJhZG1pbjEucGhwIiwgImFkbWluMS5odG1sIiwgImFkbWluMi5waHAiLCAiYWRtaW4yLmh0bWwiLCAieW9uZXRpbS5waHAiLCAieW9uZXRpbS5odG1sIiI7aToyNTc7czo2ODoiUE9TVCB7JHBhdGh9eyRjb25uZWN0b3J9P0NvbW1hbmQ9RmlsZVVwbG9hZCZUeXBlPUZpbGUmQ3VycmVudEZvbGRlcj0iO2k6MjU4O3M6MzA6IkBhc3NlcnQoJF9SRVFVRVNUWydQSFBTRVNTSUQnXSI7aToyNTk7czo2MToiJHByb2Q9InN5Ii4icyIuInRlbSI7JGlkPSRwcm9kKCRfUkVRVUVTVFsncHJvZHVjdCddKTskeydpZCd9OyI7aToyNjA7czoxNToicGhwICIuJHdzb19wYXRoIjtpOjI2MTtzOjc3OiIkRmNobW9kLCRGZGF0YSwkT3B0aW9ucywkQWN0aW9uLCRoZGRhbGwsJGhkZGZyZWUsJGhkZHByb2MsJHVuYW1lLCRpZGQpOnNoYXJlZCI7aToyNjI7czo1MToic2VydmVyLjwvcD5cclxuPC9ib2R5PjwvaHRtbD4iO2V4aXQ7fWlmKHByZWdfbWF0Y2goIjtpOjI2MztzOjk1OiIkZmlsZSA9ICRfRklMRVNbImZpbGVuYW1lIl1bIm5hbWUiXTsgZWNobyAiPGEgaHJlZj1cIiRmaWxlXCI+JGZpbGU8L2E+Ijt9IGVsc2Uge2VjaG8oImVtcHR5Iik7fSI7aToyNjQ7czo2MDoiRlNfY2hrX2Z1bmNfbGliYz0oICQocmVhZGVsZiAtcyAkRlNfbGliYyB8IGdyZXAgX2Noa0BAIHwgYXdrIjtpOjI2NTtzOjQwOiJmaW5kIC8gLW5hbWUgLnNzaCA+ICRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjI2NjtzOjMzOiJyZS5maW5kYWxsKGRpcnQrJyguKiknLHByb2dubSlbMF0iO2k6MjY3O3M6NjA6Im91dHN0ciArPSBzdHJpbmcuRm9ybWF0KCI8YSBocmVmPSc/ZmRpcj17MH0nPnsxfS88L2E+Jm5ic3A7IiI7aToyNjg7czo4MzoiPCU9UmVxdWVzdC5TZXJ2ZXJ2YXJpYWJsZXMoIlNDUklQVF9OQU1FIiklPj90eHRwYXRoPTwlPVJlcXVlc3QuUXVlcnlTdHJpbmcoInR4dHBhdGgiO2k6MjY5O3M6NzE6IlJlc3BvbnNlLldyaXRlKFNlcnZlci5IdG1sRW5jb2RlKHRoaXMuRXhlY3V0ZUNvbW1hbmQodHh0Q29tbWFuZC5UZXh0KSkpIjtpOjI3MDtzOjExMToibmV3IEZpbGVTdHJlYW0oUGF0aC5Db21iaW5lKGZpbGVJbmZvLkRpcmVjdG9yeU5hbWUsIFBhdGguR2V0RmlsZU5hbWUoaHR0cFBvc3RlZEZpbGUuRmlsZU5hbWUpKSwgRmlsZU1vZGUuQ3JlYXRlIjtpOjI3MTtzOjkwOiJSZXNwb25zZS5Xcml0ZSgiPGJyPiggKSA8YSBocmVmPT90eXBlPTEmZmlsZT0iICYgc2VydmVyLlVSTGVuY29kZShpdGVtLnBhdGgpICYgIlw+IiAmIGl0ZW0iO2k6MjcyO3M6MTA0OiJzcWxDb21tYW5kLlBhcmFtZXRlcnMuQWRkKCgoVGFibGVDZWxsKWRhdGFHcmlkSXRlbS5Db250cm9sc1swXSkuVGV4dCwgU3FsRGJUeXBlLkRlY2ltYWwpLlZhbHVlID0gZGVjaW1hbCI7aToyNzM7czo2NDoiPCU9ICJcIiAmIG9TY3JpcHROZXQuQ29tcHV0ZXJOYW1lICYgIlwiICYgb1NjcmlwdE5ldC5Vc2VyTmFtZSAlPiI7aToyNzQ7czo1MDoiY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgImh0dHA6Ly8kaG9zdDoyMDgyIikiO2k6Mjc1O3M6NTg6IkhKM0hqdXRja29SZnBYZjlBMXpRTzJBd0RSclJleTl1R3ZUZWV6NzlxQWFvMWEwcmd1ZGtaa1I4UmEiO2k6Mjc2O3M6MzE6IiRpbmlbJ3VzZXJzJ10gPSBhcnJheSgncm9vdCcgPT4iO2k6Mjc3O3M6MzE6ImZ3cml0ZSgkZnAsIlx4RUZceEJCXHhCRiIuJGJvZHkiO2k6Mjc4O3M6MTg6InByb2Nfb3BlbignSUhTdGVhbSI7aToyNzk7czoyNDoiJGJhc2xpaz0kX1BPU1RbJ2Jhc2xpayddIjtpOjI4MDtzOjMwOiJmcmVhZCgkZnAsIGZpbGVzaXplKCRmaWNoZXJvKSkiO2k6MjgxO3M6Mzk6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kKzMrOHF2cXFTMUswK0FYWSI7aToyODI7czoxNjoieyRfUE9TVFsncm9vdCddfSI7aToyODM7czoyOToifWVsc2VpZigkX0dFVFsncGFnZSddPT0nZGRvcyciO2k6Mjg0O3M6MTQ6IlRoZSBEYXJrIFJhdmVyIjtpOjI4NTtzOjM5OiIkdmFsdWUgPX4gcy8lKC4uKS9wYWNrKCdjJyxoZXgoJDEpKS9lZzsiO2k6Mjg2O3M6MTE6Ind3dy50MHMub3JnIjtpOjI4NztzOjMwOiJ1bmxlc3Mob3BlbihQRkQsJGdfdXBsb2FkX2RiKSkiO2k6Mjg4O3M6MTI6ImF6ODhwaXgwMHE5OCI7aToyODk7czoxMToic2ggZ28gJDEuJHgiO2k6MjkwO3M6MjY6InN5c3RlbSgicGhwIC1mIHhwbCAkaG9zdCIpIjtpOjI5MTtzOjEzOiJleHBsb2l0Y29va2llIjtpOjI5MjtzOjIxOiI4MCAtYiAkMSAtaSBldGgwIC1zIDgiO2k6MjkzO3M6MjU6IkhUVFAgZmxvb2QgY29tcGxldGUgYWZ0ZXIiO2k6Mjk0O3M6MTU6Ik5JR0dFUlMuTklHR0VSUyI7aToyOTU7czo0NzoiaWYoaXNzZXQoJF9HRVRbJ2hvc3QnXSkmJmlzc2V0KCRfR0VUWyd0aW1lJ10pKXsiO2k6Mjk2O3M6ODM6InN1YnByb2Nlc3MuUG9wZW4oY21kLCBzaGVsbCA9IFRydWUsIHN0ZG91dD1zdWJwcm9jZXNzLlBJUEUsIHN0ZGVycj1zdWJwcm9jZXNzLlNURE9VIjtpOjI5NztzOjY5OiJkZWYgZGFlbW9uKHN0ZGluPScvZGV2L251bGwnLCBzdGRvdXQ9Jy9kZXYvbnVsbCcsIHN0ZGVycj0nL2Rldi9udWxsJykiO2k6Mjk4O3M6Njc6InByaW50KCJbIV0gSG9zdDogIiArIGhvc3RuYW1lICsgIiBtaWdodCBiZSBkb3duIVxuWyFdIFJlc3BvbnNlIENvZGUiO2k6Mjk5O3M6NDI6ImNvbm5lY3Rpb24uc2VuZCgic2hlbGwgIitzdHIob3MuZ2V0Y3dkKCkpKyI7aTozMDA7czo1MDoib3Muc3lzdGVtKCdlY2hvIGFsaWFzIGxzPSIubHMuYmFzaCIgPj4gfi8uYmFzaHJjJykiO2k6MzAxO3M6MzI6InJ1bGVfcmVxID0gcmF3X2lucHV0KCJTb3VyY2VGaXJlIjtpOjMwMjtzOjU3OiJhcmdwYXJzZS5Bcmd1bWVudFBhcnNlcihkZXNjcmlwdGlvbj1oZWxwLCBwcm9nPSJzY3R1bm5lbCIiO2k6MzAzO3M6NTc6InN1YnByb2Nlc3MuUG9wZW4oJyVzZ2RiIC1wICVkIC1iYXRjaCAlcycgJSAoZ2RiX3ByZWZpeCwgcCI7aTozMDQ7czo1OToiJGZyYW1ld29yay5wbHVnaW5zLmxvYWQoIiN7cnBjdHlwZS5kb3duY2FzZX1ycGMiLCBvcHRzKS5ydW4iO2k6MzA1O3M6Mjg6ImlmIHNlbGYuaGFzaF90eXBlID09ICdwd2R1bXAiO2k6MzA2O3M6MTc6Iml0c29rbm9wcm9ibGVtYnJvIjtpOjMwNztzOjQ1OiJhZGRfZmlsdGVyKCd0aGVfY29udGVudCcsICdfYmxvZ2luZm8nLCAxMDAwMSkiO2k6MzA4O3M6OToiPHN0ZGxpYi5oIjtpOjMwOTtzOjU5OiJlY2hvIHkgOyBzbGVlcCAxIDsgfSB8IHsgd2hpbGUgcmVhZCA7IGRvIGVjaG8geiRSRVBMWTsgZG9uZSI7aTozMTA7czoxMToiVk9CUkEgR0FOR08iO2k6MzExO3M6NzY6ImludDMyKCgoJHogPj4gNSAmIDB4MDdmZmZmZmYpIF4gJHkgPDwgMikgKyAoKCR5ID4+IDMgJiAweDFmZmZmZmZmKSBeICR6IDw8IDQiO2k6MzEyO3M6Njk6IkBjb3B5KCRfRklMRVNbZmlsZU1hc3NdW3RtcF9uYW1lXSwkX1BPU1RbcGF0aF0uJF9GSUxFU1tmaWxlTWFzc11bbmFtZSI7aTozMTM7czo0NjoiZmluZF9kaXJzKCRncmFuZHBhcmVudF9kaXIsICRsZXZlbCwgMSwgJGRpcnMpOyI7aTozMTQ7czoyODoiQHNldGNvb2tpZSgiaGl0IiwgMSwgdGltZSgpKyI7aTozMTU7czo1OiJlLyouLyI7aTozMTY7czozNzoiSkhacGMybDBZMjkxYm5RZ1BTQWtTRlJVVUY5RFQwOUxTVVZmViI7aTozMTc7czozNToiMGQwYTBkMGE2NzZjNmY2MjYxNmMyMDI0NmQ3OTVmNzM2ZDciO2k6MzE4O3M6MTk6ImZvcGVuKCcvZXRjL3Bhc3N3ZCciO2k6MzE5O3M6NzY6IiR0c3UyW3JhbmQoMCxjb3VudCgkdHN1MikgLSAxKV0uJHRzdTFbcmFuZCgwLGNvdW50KCR0c3UxKSAtIDEpXS4kdHN1MltyYW5kKDAiO2k6MzIwO3M6MzM6Ii91c3IvbG9jYWwvYXBhY2hlL2Jpbi9odHRwZCAtRFNTTCI7aTozMjE7czoyMDoic2V0IHByb3RlY3QtdGVsbmV0IDAiO2k6MzIyO3M6Mjc6ImF5dSBwcjEgcHIyIHByMyBwcjQgcHI1IHByNiI7aTozMjM7czozMDoiYmluZCBmaWx0IC0gIlwwMDFBQ1RJT04gKlwwMDEiIjtpOjMyNDtzOjUwOiJyZWdzdWIgLWFsbCAtLSAsIFtzdHJpbmcgdG9sb3dlciAkb3duZXJdICIiIG93bmVycyI7aTozMjU7czozNToia2lsbCAtQ0hMRCBcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6MzI2O3M6MTA6ImJpbmQgZGNjIC0iO2k6MzI3O3M6MjQ6InI0YVRjLmRQbnRFL2Z6dFNGMWJIM1JIMCI7aTozMjg7czoxMzoicHJpdm1zZyAkY2hhbiI7aTozMjk7czoyMjoiYmluZCBqb2luIC0gKiBnb3Bfam9pbiI7aTozMzA7czo0Mzoic2V0IGdvb2dsZShkYXRhKSBbaHR0cDo6ZGF0YSAkZ29vZ2xlKHBhZ2UpXSI7aTozMzE7czoyNjoicHJvYyBodHRwOjpDb25uZWN0IHt0b2tlbn0iO2k6MzMyO3M6MTM6InByaXZtc2cgJG5pY2siO2k6MzMzO3M6MTE6InB1dGJvdCAkYm90IjtpOjMzNDtzOjEyOiJ1bmJpbmQgUkFXIC0iO2k6MzM1O3M6Mjk6Ii0tRENDRElSIFtsaW5kZXggJFVzZXIoJGkpIDJdIjtpOjMzNjtzOjEwOiJDeWJlc3RlcjkwIjtpOjMzNztzOjQxOiJmaWxlX2dldF9jb250ZW50cyh0cmltKCRmWyRfR0VUWydpZCddXSkpOyI7aTozMzg7czoyMToidW5saW5rKCR3cml0YWJsZV9kaXJzIjtpOjMzOTtzOjI3OiJiYXNlNjRfZGVjb2RlKCRjb2RlX3NjcmlwdCkiO2k6MzQwO3M6MjE6Imx1Y2lmZmVyQGx1Y2lmZmVyLm9yZyI7aTozNDE7czo0ODoiJHRoaXMtPkYtPkdldENvbnRyb2xsZXIoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjM0MjtzOjQ3OiIkdGltZV9zdGFydGVkLiRzZWN1cmVfc2Vzc2lvbl91c2VyLnNlc3Npb25faWQoKSI7aTozNDM7czo3NDoiJHBhcmFtIHggJG4uc3Vic3RyICgkcGFyYW0sIGxlbmd0aCgkcGFyYW0pIC0gbGVuZ3RoKCRjb2RlKSVsZW5ndGgoJHBhcmFtKSkiO2k6MzQ0O3M6MzY6ImZ3cml0ZSgkZixnZXRfZG93bmxvYWQoJF9HRVRbJ3VybCddKSI7aTozNDU7czo2NToiaHR0cDovLycuJF9TRVJWRVJbJ0hUVFBfSE9TVCddLnVybGRlY29kZSgkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6MzQ2O3M6ODA6IndwX3Bvc3RzIFdIRVJFIHBvc3RfdHlwZSA9ICdwb3N0JyBBTkQgcG9zdF9zdGF0dXMgPSAncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjM0NztzOjM3OiIkdXJsID0gJHVybHNbcmFuZCgwLCBjb3VudCgkdXJscyktMSldIjtpOjM0ODtzOjQ3OiJwcmVnX21hdGNoKCcvKD88PVJld3JpdGVSdWxlKS4qKD89XFtMXCxSXD0zMDJcXSI7aTozNDk7czo0NToicHJlZ19tYXRjaCgnIU1JRFB8V0FQfFdpbmRvd3MuQ0V8UFBDfFNlcmllczYwIjtpOjM1MDtzOjYwOiJSMGxHT0RsaEV3QVFBTE1BQUFBQUFQLy8vNXljQU03T1kvLy9uUC8venYvT25QZjM5Ly8vL3dBQUFBQUEiO2k6MzUxO3M6NjU6InN0cl9yb3QxMygkYmFzZWFbKCRkaW1lbnNpb24qJGRpbWVuc2lvbi0xKSAtICgkaSokZGltZW5zaW9uKyRqKV0pIjtpOjM1MjtzOjc1OiJpZihlbXB0eSgkX0dFVFsnemlwJ10pIGFuZCBlbXB0eSgkX0dFVFsnZG93bmxvYWQnXSkgJiBlbXB0eSgkX0dFVFsnaW1nJ10pKXsiO2k6MzUzO3M6MTY6Ik1hZGUgYnkgRGVsb3JlYW4iO2k6MzU0O3M6NDY6Im92ZXJmbG93LXk6c2Nyb2xsO1wiPiIuJGxpbmtzLiRodG1sX21mWydib2R5J10iO2k6MzU1O3M6NDM6ImZ1bmN0aW9uIHVybEdldENvbnRlbnRzKCR1cmwsICR0aW1lb3V0ID0gNSkiO2k6MzU2O3M6NjoiZDNsZXRlIjtpOjM1NztzOjE1OiJsZXRha3Nla2FyYW5nKCkiO2k6MzU4O3M6ODoiWUVOSTNFUkkiO2k6MzU5O3M6MjE6IiRPT08wMDAwMDA9dXJsZGVjb2RlKCI7aTozNjA7czoyMDoiLUkvdXNyL2xvY2FsL2JhbmRtaW4iO2k6MzYxO3M6Mzc6ImZ3cml0ZSgkZnBzZXR2LCBnZXRlbnYoIkhUVFBfQ09PS0lFIikiO2k6MzYyO3M6MjU6Imlzc2V0KCRfUE9TVFsnZXhlY2dhdGUnXSkiO2k6MzYzO3M6MTU6IldlYmNvbW1hbmRlciBhdCI7aTozNjQ7czoxNDoiPT0gImJpbmRzaGVsbCIiO2k6MzY1O3M6ODoiUGFzaGtlbGEiO2k6MzY2O3M6MjU6ImNyZWF0ZUZpbGVzRm9ySW5wdXRPdXRwdXQiO2k6MzY3O3M6NjoiTTRsbDNyIjtpOjM2ODtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTozNjk7czo3OiJPb05fQm95IjtpOjM3MDtzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM3MTtzOjg6ImRhcmttaW56IjtpOjM3MjtzOjU6IlplZDB4IjtpOjM3MztzOjQwOiJhYmFjaG98YWJpemRpcmVjdG9yeXxhYm91dHxhY29vbnxhbGV4YW5hIjtpOjM3NDtzOjM2OiJwcGN8bWlkcHx3aW5kb3dzIGNlfG10a3xqMm1lfHN5bWJpYW4iO2k6Mzc1O3M6NDc6IkBjaHIoKCRoWyRlWyRvXV08PDQpKygkaFskZVsrKyRvXV0pKTt9fWV2YWwoJGQpIjtpOjM3NjtzOjExOiIkc2gzbGxDb2xvciI7aTozNzc7czoxMDoiUHVua2VyMkJvdCI7aTozNzg7czoxODoiPD9waHAgZWNobyAiIyEhIyI7IjtpOjM3OTtzOjc1OiIkaW09c3Vic3RyKCRpbSwwLCRpKS5zdWJzdHIoJGltLCRpMisxLCRpNC0oJGkyKzEpKS5zdWJzdHIoJGltLCRpNCsxMixzdHJsZW4iO2k6MzgwO3M6NTU6IigkaW5kYXRhLCRiNjQ9MSl7aWYoJGI2ND09MSl7JGNkPWJhc2U2NF9kZWNvZGUoJGluZGF0YSkiO2k6MzgxO3M6MTc6IigkX1BPU1RbImRpciJdKSk7IjtpOjM4MjtzOjE3OiJIYWNrZWQgQnkgRW5ETGVTcyI7aTozODM7czoxMDoiYW5kZXh8b29nbCI7aTozODQ7czoxMDoibmRyb2l8aHRjXyI7aTozODU7czoxMDoiPGRvdD5JcklzVCI7aTozODY7czoyMToiN1AxdGQrTldsaWFJL2hXa1o0Vlg5IjtpOjM4NztzOjE1OiJOaW5qYVZpcnVzIEhlcmUiO2k6Mzg4O3M6MzI6IiRpbT1zdWJzdHIoJHR4LCRwKzIsJHAyLSgkcCsyKSk7IjtpOjM4OTtzOjY6IjN4cDFyMyI7aTozOTA7czoyMDoiJG1kNT1tZDUoIiRyYW5kb20iKTsiO2k6MzkxO3M6Mjg6Im9UYXQ4RDNEc0U4JyZ+aFUwNkNDSDU7JGdZU3EiO2k6MzkyO3M6MTI6IkdJRjg5QTs8P3BocCI7aTozOTM7czoxNToiQ3JlYXRlZCBCeSBFTU1BIjtpOjM5NDtzOjM0OiJQYXNzd29yZDo8cz4iLiRfUE9TVFs8cT5wYXNzd2Q8cT5dIjtpOjM5NTtzOjE1OiJOZXRAZGRyZXNzIE1haWwiO2k6Mzk2O3M6MjQ6IiRpc2V2YWxmdW5jdGlvbmF2YWlsYWJsZSI7aTozOTc7czoxMToiQmFieV9EcmFrb24iO2k6Mzk4O3M6MzA6ImZ3cml0ZShmb3BlbihkaXJuYW1lKF9fRklMRV9fKSI7aTozOTk7czoxMzoiXV0pKTt9fWV2YWwoJCI7aTo0MDA7czoyNzoiZXJlZ19yZXBsYWNlKDxxPiZlbWFpbCY8cT4sIjtpOjQwMTtzOjE5OiIpOyAkaSsrKSRyZXQuPWNocigkIjtpOjQwMjtzOjU3OiIkcGFyYW0ybWFzay4iKVw9W1w8cXE+XCJdKC4qPykoPz1bXDxxcT5cIl0gKVtcPHFxPlwiXS9zaWUiO2k6NDAzO3M6OToiLy9yYXN0YS8vIjtpOjQwNDtzOjIwOiI8IS0tQ09PS0lFIFVQREFURS0tPiI7aTo0MDU7czoxMzoicHJvZmV4b3IuaGVsbCI7aTo0MDY7czoxMzoiTWFnZWxhbmdDeWJlciI7aTo0MDc7czo4OiJaT0JVR1RFTCI7aTo0MDg7czoxMzoiRmFrZVNlbmRlciBieSI7aTo0MDk7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjQxMDtzOjg6IlNfXUBfXlVeIjtpOjQxMTtzOjEzOiJAJF9QT1NUWyhjaHIoIjtpOjQxMjtzOjEyOiJaZXJvRGF5RXhpbGUiO2k6NDEzO3M6MTI6IlN1bHRhbkhhaWthbCI7aTo0MTQ7czoxMToiQ291cGRlZ3JhY2UiO2k6NDE1O3M6OToiYXJ0aWNrbGVAIjtpOjQxNjtzOjE1OiJnbml0cm9wZXJfcm9ycmUiO2k6NDE3O3M6MjM6ImN1dHRlclthdF1yZWFsLnhha2VwLnJ1IjtpOjQxODtzOjI5OiJpZigkd3BfX3dwPUBnemluZmxhdGUoJHdwX193cCI7aTo0MTk7czo2OiJyMDBuaXgiO2k6NDIwO3M6MjE6IiRmdWxsX3BhdGhfdG9fZG9vcndheSI7aTo0MjE7czozMDoiPGI+RG9uZSA9PT4gJHVzZXJmaWxlX25hbWU8L2I+IjtpOjQyMjtzOjEyOiI+RGFyayBTaGVsbDwiO2k6NDIzO3M6MTU6Ii8uLi8qL2luZGV4LnBocCI7aTo0MjQ7czozMjoiaWYoaXNfdXBsb2FkZWRfZmlsZS8qOyovKCRfRklMRVMiO2k6NDI1O3M6MjM6ImV4ZWMoJGNvbW1hbmQsICRvdXRwdXQpIjtpOjQyNjtzOjIwOiJAaW5jbHVkZV9vbmNlKCcvdG1wLyI7aTo0Mjc7czo4MToidHJpbSgnaHR0cDovLycuJHNjLjxxcT4/Q29tbWFuZD1HZXRGb2xkZXJzQW5kRmlsZXMmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9JTJGJTAwIjtpOjQyODtzOjU5OiIkc2NyaXB0X2ZpbmQgPSBzdHJfcmVwbGFjZSgibG9hZGVyIiwgImZpbmQiLCAkc2NyaXB0X2xvYWRlciI7aTo0Mjk7czoxODoiPHRpdGxlPi4vSGFja2VkIEJ5IjtpOjQzMDtzOjg6IkJ5IFRhM2VzIjtpOjQzMTtzOjE0OiIkbmV3X21vdXN0YWNoZSI7fQ=="));
$gX_DBShe = unserialize(base64_decode("YTo2Mjp7aTowO3M6NzoiZGVmYWNlciI7aToxO3M6MjQ6IllvdSBjYW4gcHV0IGEgbWQ1IHN0cmluZyI7aToyO3M6ODoicGhwc2hlbGwiO2k6MztzOjYyOiI8ZGl2IGNsYXNzPSJibG9jayBidHlwZTEiPjxkaXYgY2xhc3M9ImR0b3AiPjxkaXYgY2xhc3M9ImRidG0iPiI7aTo0O3M6ODoiYzk5c2hlbGwiO2k6NTtzOjg6InI1N3NoZWxsIjtpOjY7czo3OiJOVERhZGR5IjtpOjc7czo4OiJjaWhzaGVsbCI7aTo4O3M6NzoiRnhjOTlzaCI7aTo5O3M6MTI6IldlYiBTaGVsbCBieSI7aToxMDtzOjExOiJkZXZpbHpTaGVsbCI7aToxMTtzOjI1OiJIYWNrZWQgYnkgQWxmYWJldG9WaXJ0dWFsIjtpOjEyO3M6ODoiTjN0c2hlbGwiO2k6MTM7czoxMToiU3Rvcm03U2hlbGwiO2k6MTQ7czoxMToiTG9jdXM3U2hlbGwiO2k6MTU7czoxMjoicjU3c2hlbGwucGhwIjtpOjE2O3M6OToiYW50aXNoZWxsIjtpOjE3O3M6OToicm9vdHNoZWxsIjtpOjE4O3M6MTE6Im15c2hlbGxleGVjIjtpOjE5O3M6ODoiU2hlbGwgT2siO2k6MjA7czoxNDoiZXhlYygicm0gLXIgLWYiO2k6MjE7czoxODoiTmUgdWRhbG9zIHphZ3J1eml0IjtpOjIyO3M6NTE6IiRtZXNzYWdlID0gZXJlZ19yZXBsYWNlKCIlNUMlMjIiLCAiJTIyIiwgJG1lc3NhZ2UpOyI7aToyMztzOjE5OiJwcmludCAiU3BhbWVkJz48YnI+IjtpOjI0O3M6NDA6InNldGNvb2tpZSggIm15c3FsX3dlYl9hZG1pbl91c2VybmFtZSIgKTsiO2k6MjU7czozNzoiZWxzZWlmKGZ1bmN0aW9uX2V4aXN0cygic2hlbGxfZXhlYyIpKSI7aToyNjtzOjU5OiJpZiAoaXNfY2FsbGFibGUoImV4ZWMiKSBhbmQgIWluX2FycmF5KCJleGVjIiwkZGlzYWJsZWZ1bmMpKSI7aToyNztzOjM0OiJpZiAoKCRwZXJtcyAmIDB4QzAwMCkgPT0gMHhDMDAwKSB7IjtpOjI4O3M6MTA6ImRpciAvT0cgL1giO2k6Mjk7czozNjoiaW5jbHVkZSgkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pIjtpOjMwO3M6NzoiYnIwd3MzciI7aTozMTtzOjQ5OiInaHR0cGQuY29uZicsJ3Zob3N0cy5jb25mJywnY2ZnLnBocCcsJ2NvbmZpZy5waHAnIjtpOjMyO3M6MzQ6Ii9wcm9jL3N5cy9rZXJuZWwveWFtYS9wdHJhY2Vfc2NvcGUiO2k6MzM7czoyMzoiZXZhbChmaWxlX2dldF9jb250ZW50cygiO2k6MzQ7czoxODoiaXNfd3JpdGFibGUoIi92YXIvIjtpOjM1O3M6MTQ6IiRHTE9CQUxTWydfX19fIjtpOjM2O3M6NTU6ImlzX2NhbGxhYmxlKCdleGVjJykgYW5kICFpbl9hcnJheSgnZXhlYycsICRkaXNhYmxlZnVuY3MiO2k6Mzc7czo2OiJrMGQuY2MiO2k6Mzg7czoyNjoiZ21haWwtc210cC1pbi5sLmdvb2dsZS5jb20iO2k6Mzk7czo3OiJ3ZWJyMDB0IjtpOjQwO3M6MTE6IkRldmlsSGFja2VyIjtpOjQxO3M6NzoiRGVmYWNlciI7aTo0MjtzOjExOiJbIFBocHJveHkgXSI7aTo0MztzOjg6Iltjb2RlcnpdIjtpOjQ0O3M6MzI6IjwhLS0jZXhlYyBjbWQ9IiRIVFRQX0FDQ0VQVCIgLS0+IjtpOjQ1O3M6MTI6Il1bcm91bmQoMCldKCI7aTo0NjtzOjExOiJTaW1BdHRhY2tlciI7aTo0NztzOjE1OiJEYXJrQ3Jld0ZyaWVuZHMiO2k6NDg7czo3OiJrMmxsMzNkIjtpOjQ5O3M6NzoiS2tLMTMzNyI7aTo1MDtzOjE1OiJIQUNLRUQgQlkgU1RPUk0iO2k6NTE7czoxNDoiTWV4aWNhbkhhY2tlcnMiO2k6NTI7czoxNToiTXIuU2hpbmNoYW5YMTk2IjtpOjUzO3M6OToiRGVpZGFyYX5YIjtpOjU0O3M6MTA6IkppbnBhbnRvbXoiO2k6NTU7czo5OiIxbjczY3QxMG4iO2k6NTY7czoxNDoiS2luZ1NrcnVwZWxsb3MiO2k6NTc7czoxMDoiSmlucGFudG9teiI7aTo1ODtzOjk6IkNlbmdpekhhbiI7aTo1OTtzOjk6InIzdjNuZzRucyI7aTo2MDtzOjk6IkJMQUNLVU5JWCI7aTo2MTtzOjk6ImFydGlja2xlQCI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YTozNDY6e2k6MDtzOjM4OiJcJFxzKig/Olx7W157fV0rXH1ccyopK1woW14oKV0qXCRccypceyI7aToxO3M6MTAxOiJhcnJheV9maWx0ZXJcKFxzKigvXCouKz9cKi8pP1xzKkB7MCx9YXJyYXlcKFxzKigvXCouKz9cKi8pP0B7MCx9XCR7Il8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKSI7aToyO3M6NTc6IlwkXHcrXHMqPVxzKlwkXHcrXHMqXChccypcJFx3K1xzKixccypcJFx3K1xzKixccyonJ1xzKlwpOyI7aTozO3M6MTA2OiIoXCRcdytccyo9XHMqKFsnIl1cdypbJyJdfFxkKyk7XHMqKXsyLH1cJFx3K1xzKj1ccyphcnJheVxzKlwoKFsiJ11bYS16QS1aMC05Lys9X117Mix9WyInXVxzKigsXHMqKT8pezEwLH0/IjtpOjQ7czo1MjoiXCR7XHMqXHcrXHMqXChccypbIic6XVteJzoiXStbIiddXClccyp9XHMqXChcdytccypcKCI7aTo1O3M6MTU0OiJpZlxzKlwoXHMqZmlsZV9wdXRfY29udGVudHNccypcKFxzKl9fRklMRV9fXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtccypbJyJdXHcrWyciXVxzKlxdXHMqXClccypcKVxzKlwpXHMqZWNob1xzKidPSyc7IjtpOjY7czoxNjU6IlxiKChwaWNzfGhvdHxvbmxpbmUpfChjdW1zaG90fGJsb3dqb2J8dW5jZW5zb3JlZHx2aWFncmF8Y2lhbGlzfGxldml0cmF8dHJhbWFkb2x8bnVkZXxjZWxlYnJpdHl8cG9ybm8/fGdheXx0ZWVucz98c3F1aXJ0fHNleGllc3R8c2V4fGZ1Y2t8dGl0cz98bGVzYmlhbilcYltcc1wtXSspezIsfSI7aTo3O3M6MzU6ImRlZmF1bHRfYWN0aW9uXHMqPVxzKlxcWyciXUZpbGVzTWFuIjtpOjg7czozMzoiZGVmYXVsdF9hY3Rpb25ccyo9XHMqWyciXUZpbGVzTWFuIjtpOjk7czoxMDA6IklPOjpTb2NrZXQ6OklORVQtPm5ld1woUHJvdG9ccyo9PlxzKiJ0Y3AiXHMqLFxzKkxvY2FsUG9ydFxzKj0+XHMqMzYwMDBccyosXHMqTGlzdGVuXHMqPT5ccypTT01BWENPTk4iO2k6MTA7czo5NjoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfXAyWyciXXswLDF9XHMqXF1ccyo9PVxzKlsnIl17MCwxfWNobW9kWyciXXswLDF9IjtpOjExO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjEyO3M6MTE6ImJ5XHMrR3JpbmF5IjtpOjEzO3M6MTk6ImhhY2tlZFxzK2J5XHMrSG1laTciO2k6MTQ7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjE1O3M6MTcwOiJcJGluZm8gXC49IFwoXChcJHBlcm1zXHMqJlxzKjB4MDA0MFwpXHMqXD9cKFwoXCRwZXJtc1xzKiZccyoweDA4MDBcKVxzKlw/XHMqXFxbJyJdc1xcWyciXVxzKjpccypcXFsnIl14XFxbJyJdXHMqXClccyo6XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKidTJ1xzKjpccyonLSdccypcKSI7aToxNjtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQD9cJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6MTc7czo3NDoiV1NPc2V0Y29va2llXHMqXChccyptZDVccypcKFxzKkA/XCRfU0VSVkVSXFtccypbJyJdSFRUUF9IT1NUWyciXVxzKlxdXHMqXCkiO2k6MTg7czoxMDc6Indzb0V4XHMqXChccypcXFsnIl1ccyp0YXJccypjZnp2XHMqXFxbJyJdXHMqXC5ccyplc2NhcGVzaGVsbGFyZ1xzKlwoXHMqXCRfUE9TVFxbXHMqXFxbJyJdcDJcXFsnIl1ccypcXVxzKlwpIjtpOjE5O3M6NDA6ImV2YWxccypcKD9ccypiYXNlNjRfZGVjb2RlXHMqXCg/XHMqQD9cJF8iO2k6MjA7czo3ODoiZmlsZXBhdGhccyo9XHMqQD9yZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqXFxbJyJdZmlsZXBhdGhcXFsnIl1ccypcXVxzKlwpIjtpOjIxO3M6NzQ6ImZpbGVwYXRoXHMqPVxzKkA/cmVhbHBhdGhccypcKFxzKlwkX1BPU1RccypcW1xzKlsnIl1maWxlcGF0aFsnIl1ccypcXVxzKlwpIjtpOjIyO3M6NDc6InJlbmFtZVxzKlwoXHMqXHMqWyciXXswLDF9d3NvXC5waHBbJyJdezAsMX1ccyosIjtpOjIzO3M6OTc6IlwkTWVzc2FnZVN1YmplY3Rccyo9XHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXXswLDF9bXNnc3ViamVjdFsnIl17MCwxfVxzKlxdXHMqXCkiO2k6MjQ7czo4NzoiU0VMRUNUXHMrMVxzK0ZST01ccytteXNxbFwudXNlclxzK1dIRVJFXHMrY29uY2F0XChccypgdXNlcmBccyosXHMqJ0AnXHMqLFxzKmBob3N0YFxzKlwpIjtpOjI1O3M6NTY6InBhc3N0aHJ1XHMqXCg/XHMqZ2V0ZW52XHMqXCg/XHMqWyciXUhUVFBfQUNDRVBUX0xBTkdVQUdFIjtpOjI2O3M6NTg6InBhc3N0aHJ1XHMqXCg/XHMqZ2V0ZW52XHMqXCg/XHMqXFxbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6Mjc7czo1NToie1xzKlwkXHMqe1xzKnBhc3N0aHJ1XHMqXCg/XHMqXCRjbWRccypcKVxzKn1ccyp9XHMqPGJyPiI7aToyODtzOjgyOiJydW5jb21tYW5kXHMqXChccypbJyJdc2hlbGxoZWxwWyciXVxzKixccypbJyJdKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdIjtpOjI5O3M6MzE6Im5jZnRwcHV0XHMqLXVccypcJGZ0cF91c2VyX25hbWUiO2k6MzA7czozNzoiXCRsb2dpblxzKj1ccypAP3Bvc2l4X2dldHVpZFwoP1xzKlwpPyI7aTozMTtzOjQ5OiIhQD9cJF9SRVFVRVNUXHMqXFtccypbJyJdYzk5c2hfc3VybFsnIl1ccypcXVxzKlwpIjtpOjMyO3M6NTM6InNldGNvb2tpZVwoP1xzKlsnIl1teXNxbF93ZWJfYWRtaW5fdXNlcm5hbWVbJyJdXHMqXCk/IjtpOjMzO3M6MTQzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aTozNDtzOjI4OiJcJGZlXChbJyJdXCRjbWRccysyPiYxWyciXVwpIjtpOjM1O3M6OTY6IlwkZnVuY3Rpb25ccypcKD9ccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1jbWRbJyJdezAsMX1ccypcXVxzKlwpPyI7aTozNjtzOjkzOiJcJGNtZFxzKj1ccypcKFxzKkA/XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqXCkiO2k6Mzc7czoyMDoiZXZhMVthLXpBLVowLTlfXStTaXIiO2k6Mzg7czo4ODoiXCRpbmlccypcW1xzKlsnIl17MCwxfXVzZXJzWyciXXswLDF9XHMqXF1ccyo9XHMqYXJyYXlccypcKFxzKlsnIl17MCwxfXJvb3RbJyJdezAsMX1ccyo9PiI7aTozOTtzOjMzOiJwcm9jX29wZW5ccypcKFxzKlsnIl17MCwxfUlIU3RlYW0iO2k6NDA7czoxMzU6IlsnIl17MCwxfWh0dHBkXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXZob3N0c1wuY29uZlsnIl17MCwxfVxzKixccypbJyJdezAsMX1jZmdcLnBocFsnIl17MCwxfVxzKixccypbJyJdezAsMX1jb25maWdcLnBocFsnIl17MCwxfSI7aTo0MTtzOjgxOiJccyp7XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfXJvb3RbJyJdezAsMX1ccypcXVxzKn0iO2k6NDI7czo0NjoicHJlZ19yZXBsYWNlXHMqXCg/XHMqWyciXXswLDF9L1wuXCovZVsnIl17MCwxfSI7aTo0MztzOjM2OiJldmFsXHMqXCg/XHMqZmlsZV9nZXRfY29udGVudHNccypcKD8iO2k6NDQ7czo3NDoiQD9zZXRjb29raWVccypcKD9ccypbJyJdezAsMX1oaXRbJyJdezAsMX0sXHMqMVxzKixccyp0aW1lXHMqXCg/XHMqXCk/XHMqXCsiO2k6NDU7czo0MToiZXZhbFxzKlwoP0A/XHMqc3RyaXBzbGFzaGVzXHMqXCg/XHMqQD9cJF8iO2k6NDY7czo1OToiZXZhbFxzKlwoP0A/XHMqc3RyaXBzbGFzaGVzXHMqXCg/XHMqYXJyYXlfcG9wXHMqXCg/XHMqQD9cJF8iO2k6NDc7czo0MzoiZm9wZW5ccypcKD9ccypbJyJdezAsMX0vZXRjL3Bhc3N3ZFsnIl17MCwxfSI7aTo0ODtzOjI0OiJcJEdMT0JBTFNcW1snIl17MCwxfV9fX18iO2k6NDk7czoyMTc6ImlzX2NhbGxhYmxlXHMqXCg/XHMqWyciXXswLDF9XGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpP1xzK2FuZFxzKyFpbl9hcnJheVxzKlwoP1xzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccyosXHMqXCRkaXNhYmxlZnVuY3MiO2k6NTA7czoxMTI6ImZpbGVfZ2V0X2NvbnRlbnRzXHMqXCg/XHMqdHJpbVxzKlwoXHMqXCQuKz9cW1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX0uKz9bJyJdezAsMX1cXVxdXClcKTsiO2k6NTE7czoxMzY6IndwX3Bvc3RzXHMrV0hFUkVccytwb3N0X3R5cGVccyo9XHMqWyciXXswLDF9cG9zdFsnIl17MCwxfVxzK0FORFxzK3Bvc3Rfc3RhdHVzXHMqPVxzKlsnIl17MCwxfXB1Ymxpc2hbJyJdezAsMX1ccytPUkRFUlxzK0JZXHMrYElEYFxzK0RFU0MiO2k6NTI7czoyMDoiZXhlY1xzKlwoXHMqWyciXWlwZnciO2k6NTM7czo0Mjoic3RycmV2XCg/XHMqWyciXXswLDF9dHJlc3NhWyciXXswLDF9XHMqXCk/IjtpOjU0O3M6NDk6InN0cnJldlwoP1xzKlsnIl17MCwxfWVkb2NlZF80NmVzYWJbJyJdezAsMX1ccypcKT8iO2k6NTU7czo3MDoiZnVuY3Rpb25ccyt1cmxHZXRDb250ZW50c1xzKlwoP1xzKlwkdXJsXHMqLFxzKlwkdGltZW91dFxzKj1ccypcZCtccypcKSI7aTo1NjtzOjcxOiJmd3JpdGVccypcKD9ccypcJGZwc2V0dlxzKixccypnZXRlbnZccypcKFxzKlsnIl1IVFRQX0NPT0tJRVsnIl1ccypcKVxzKiI7aTo1NztzOjY2OiJpc3NldFxzKlwoP1xzKlwkX1BPU1RccypcW1xzKlsnIl17MCwxfWV4ZWNnYXRlWyciXXswLDF9XHMqXF1ccypcKT8iO2k6NTg7czoyMDA6IlVOSU9OXHMrU0VMRUNUXHMrWyciXXswLDF9MFsnIl17MCwxfVxzKixccypbJyJdezAsMX08XD8gc3lzdGVtXChcXFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtjcGNcXVwpO2V4aXQ7XHMqXD8+WyciXXswLDF9XHMqLFxzKjBccyosMFxzKixccyowXHMqLFxzKjBccytJTlRPXHMrT1VURklMRVxzK1snIl17MCwxfVwkWyciXXswLDF9IjtpOjU5O3M6MTQ5OiJcJEdMT0JBTFNcW1snIl17MCwxfS4rP1snIl17MCwxfVxdPUFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKSI7aTo2MDtzOjczOiJwcmVnX3JlcGxhY2VccypcKD9ccypbJyJdezAsMX0vXC5cKlxbLis/XF1cPy9lWyciXXswLDF9XHMqLFxzKnN0cl9yZXBsYWNlIjtpOjYxO3M6MTAxOiJcJEdMT0JBTFNcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXFtccypcZCtccypcXVwoXHMqXCRfXGQrXHMqLFxzKl9cZCtccypcKFxzKlxkK1xzKlwpXHMqXClccypcKSI7aTo2MjtzOjExNToiXCRiZWVjb2RlXHMqPUA/ZmlsZV9nZXRfY29udGVudHNccypcKD9bJyJdezAsMX1ccypcJHVybHB1cnNccypbJyJdezAsMX1cKT9ccyo7XHMqZWNob1xzK1snIl17MCwxfVwkYmVlY29kZVsnIl17MCwxfSI7aTo2MztzOjc5OiJcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0uKz9bJyJdXHMqO1xzKlwkeFxkK1xzKj1ccypbJyJdIjtpOjY0O3M6NDM6IjxcP3BocFxzK1wkX0Zccyo9XHMqX19GSUxFX19ccyo7XHMqXCRfWFxzKj0iO2k6NjU7czo2ODoiaWZccytcKD9ccyptYWlsXHMqXChccypcJHJlY3BccyosXHMqXCRzdWJqXHMqLFxzKlwkc3R1bnRccyosXHMqXCRmcm0iO2k6NjY7czoxMzk6ImlmXHMrXChccypzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9tb290b29sc1wuanNbJyJdXHMqXClccyo9PT1ccypmYWxzZVxzKyYmXHMrc3RycG9zXHMqXChccypcJHVybFxzKixccypbJyJdanMvY2FwdGlvblwuanNbJyJdezAsMX0iO2k6Njc7czo4MToiZXZhbFxzKlwoP1xzKnN0cmlwc2xhc2hlc1xzKlwoP1xzKmFycmF5X3BvcFwoP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjY4O3M6MjIxOiJpZlxzKlwoP1xzKmlzc2V0XHMqXCg/XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVx3K1snIl17MCwxfVxzKlxdXHMqXCk/XHMqXClccyp7XHMqXCRcdytccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVx3K1snIl17MCwxfVxzKlxdO1xzKmV2YWxccypcKD9ccypcJFx3K1xzKlwpPyI7aTo2OTtzOjEyMzoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1xeXCh3d3dcfGZ0cFwpXFxcLi9pWyciXVxzKixccypbJyJdWyciXSxccypAXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1ccypcXVxzKlwpIjtpOjcwO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aTo3MTtzOjg4OiI9XHMqcHJlZ19zcGxpdFxzKlwoXHMqWyciXS9cXCxcKFxcIFwrXClcPy9bJyJdLFxzKkA/aW5pX2dldFxzKlwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zIjtpOjcyO3M6NDc6IlwkYlxzKlwuXHMqXCRwXHMqXC5ccypcJGhccypcLlxzKlwka1xzKlwuXHMqXCR2IjtpOjczO3M6MjM6IlwoXHMqWyciXUlOU0hFTExbJyJdXHMqIjtpOjc0O3M6NTQ6IihHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdX19fWyciXVxzKiI7aTo3NTtzOjk0OiJhcnJheV9wb3BccypcKD9ccypcJHdvcmtSZXBsYWNlXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqLFxzKlwkY291bnRLZXlzTmV3IjtpOjc2O3M6MzU6ImlmXHMqXCg/XHMqQD9wcmVnX21hdGNoXHMqXCg/XHMqc3RyIjtpOjc3O3M6NDM6IkBcJF9DT09LSUVcW1snIl17MCwxfXN0YXRDb3VudGVyWyciXXswLDF9XF0iO2k6Nzg7czoxMDU6ImZvcGVuXHMqXCg/XHMqWyciXWh0dHA6Ly9bJyJdXHMqXC5ccypcJGNoZWNrX2RvbWFpblxzKlwuXHMqWyciXTo4MFsnIl1ccypcLlxzKlwkY2hlY2tfZG9jXHMqLFxzKlsnIl1yWyciXSI7aTo3OTtzOjU1OiJAP2d6aW5mbGF0ZVxzKlwoXHMqQD9iYXNlNjRfZGVjb2RlXHMqXChccypAP3N0cl9yZXBsYWNlIjtpOjgwO3M6Mjg6ImZpbGVfcHV0X2NvbnRlbnR6XHMqXCg/XHMqXCQiO2k6ODE7czo4NzoiJiZccypmdW5jdGlvbl9leGlzdHNccypcKD9ccypbJyJdezAsMX1nZXRteHJyWyciXXswLDF9XClccypcKVxzKntccypAZ2V0bXhyclxzKlwoP1xzKlwkIjtpOjgyO3M6NDE6IlwkcG9zdFJlc3VsdFxzKj1ccypjdXJsX2V4ZWNccypcKD9ccypcJGNoIjtpOjgzO3M6MjU6ImZ1bmN0aW9uXHMrc3FsMl9zYWZlXHMqXCgiO2k6ODQ7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo4NTtzOjM4OiJldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlxcXCRfUkVRVUVTVCI7aTo4NjtzOjM2OiIhdG91Y2hcKFsnIl17MCwxfVwuXC4vXC5cLi9sYW5ndWFnZS8iO2k6ODc7czoxMDoiRGMwUkhhWyciXSI7aTo4ODtzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6ODk7czoxNTY6ImlmXHMqXChccypzdHJpcG9zXHMqXChccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqLFxzKlsnIl17MCwxfUFuZHJvaWRbJyJdezAsMX1cKVxzKiE9PWZhbHNlXHMqJiZccyohXCRfQ09PS0lFXFtbJyJdezAsMX1kbGVfdXNlcl9pZCI7aTo5MDtzOjM4OiJlY2hvXHMrQGZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypcJGdldCI7aTo5MTtzOjQ3OiJkZWZhdWx0X2FjdGlvblxzKj1ccypbJyJdezAsMX1GaWxlc01hblsnIl17MCwxfSI7aTo5MjtzOjMzOiJkZWZpbmVccypcKFxzKlsnIl1ERUZDQUxMQkFDS01BSUwiO2k6OTM7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6OTQ7czozNDoicHJlZ19yZXBsYWNlXHMqXCg/XHMqWyciXS9cLlwrL2VzaSI7aTo5NTtzOjQ1OiJkZWZpbmVccypcKD9ccypbJyJdU0JDSURfUkVRVUVTVF9GSUxFWyciXVxzKiwiO2k6OTY7czo2MDoiXCR0bGRccyo9XHMqYXJyYXlccypcKFxzKlsnIl1jb21bJyJdLFsnIl1vcmdbJyJdLFsnIl1uZXRbJyJdIjtpOjk3O3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjk4O3M6MTQ1OiJpZlwoIWVtcHR5XChcJF9GSUxFU1xbWyciXXswLDF9bWVzc2FnZVsnIl17MCwxfVxdXFtbJyJdezAsMX1uYW1lWyciXXswLDF9XF1cKVxzK0FORFxzK1wobWQ1XChcJF9QT1NUXFtbJyJdezAsMX1uaWNrWyciXXswLDF9XF1cKVxzKj09XHMqWyciXXswLDF9IjtpOjk5O3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxMDA7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTAxO3M6Njc6InNldF90aW1lX2xpbWl0XHMqXChccyowXHMqXCk7XHMqaWZccypcKCFTZWNyZXRQYWdlSGFuZGxlcjo6Y2hlY2tLZXkiO2k6MTAyO3M6NzM6IkBoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypbJyJdXC5bJyJdaFsnIl1cLlsnIl10WyciXVwuWyciXXRbJyJdXC5bJyJdcFsnIl0iO2k6MTAzO3M6OToiSXJTZWNUZWFtIjtpOjEwNDtzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjEwNTtzOjc0OiJjbGVhcnN0YXRjYWNoZVwoXHMqXCk7XHMqaWZccypcKFxzKiFpc19kaXJccypcKFxzKlwkZmxkXHMqXClccypcKVxzKnJldHVybiI7aToxMDY7czo5NzoiY29udGVudD1bJyJdezAsMX1uby1jYWNoZVsnIl17MCwxfTtccypcJGNvbmZpZ1xbWyciXXswLDF9ZGVzY3JpcHRpb25bJyJdezAsMX1cXVxzKlwuPVxzKlsnIl17MCwxfSI7aToxMDc7czoxMjoidG1oYXBiemNlcmZmIjtpOjEwODtzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoP1xzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjEwOTtzOjg3OiJpZlxzKlwoXHMqXCRpXHMqPFxzKlwoXHMqY291bnRccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXFbJyJdezAsMX1ccypcXVxzKlwpXHMqLVxzKjEiO2k6MTEwO3M6MjMyOiJpc3NldFxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmlzX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccypjb3B5XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdIjtpOjExMTtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjExMjtzOjIxMzoiQD9tb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjExMztzOjM5OiJldmFsXHMqXCg/XHMqc3RycmV2XHMqXCg/XHMqc3RyX3JlcGxhY2UiO2k6MTE0O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxMTU7czo3MjoiXF5kb3dubG9hZHMvXChcWzAtOVxdXCpcKS9cKFxbMC05XF1cKlwpL1wkXHMrZG93bmxvYWRzXC5waHBcP2M9XCQxJnA9XCQyIjtpOjExNjtzOjkyOiJwcmVnX3JlcGxhY2VccypcKFxzKlwkZXhpZlxbXHMqXFxbJyJdTWFrZVxcWyciXVxzKlxdXHMqLFxzKlwkZXhpZlxbXHMqXFxbJyJdTW9kZWxcXFsnIl1ccypcXSI7aToxMTc7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTE4O3M6NDE6ImZ1bmN0aW9uXHMraW5qZWN0XChcJGZpbGUsXHMqXCRpbmplY3Rpb249IjtpOjExOTtzOjcxOiJleGVjbFwoWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0vYmluL3NoWyciXVxzKixccypbJyJdLWlbJyJdXHMqLFxzKjBcKSI7aToxMjA7czo0MzoiZmluZFxzKy9ccystdHlwZVxzK2ZccystcGVybVxzKy0wNDAwMFxzKy1scyI7aToxMjE7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTIyO3M6NjU6InVybGVuY29kZVwocHJpbnRfclwoYXJyYXlcKFwpLDFcKVwpLDUsMVwpXC5jXCksXCRjXCk7fWV2YWxcKFwkZFwpIjtpOjEyMztzOjg5OiJhcnJheV9rZXlfZXhpc3RzXHMqXChccypcJGZpbGVSYXNccyosXHMqXCRmaWxlVHlwZVwpXHMqXD9ccypcJGZpbGVUeXBlXFtccypcJGZpbGVSYXNccypcXSI7aToxMjQ7czo5OToiaWZccypcKFxzKmZ3cml0ZVxzKlwoXHMqXCRoYW5kbGVccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEyNTtzOjE3ODoiaWZccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXBhdGhbJyJdezAsMX1ccypcXVxzKj09XHMqWyciXXswLDF9WyciXXswLDF9XHMqXClccyp7XHMqXCR1cGxvYWRmaWxlXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aToxMjY7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTI3O3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMjg7czo1MToiXClccypcLlxzKnN1YnN0clxzKlwoXHMqbWQ1XHMqXChccypzdHJyZXZccypcKFxzKlwkIjtpOjEyOTtzOjI4OiJhc3NlcnRccypcKFxzKkA/c3RyaXBzbGFzaGVzIjtpOjEzMDtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTMxO3M6NTI6ImVjaG9bJyJdezAsMX08Y2VudGVyPjxiPkRvbmVccyo9PT5ccypcJHVzZXJmaWxlX25hbWUiO2k6MTMyO3M6MTM0OiJpZlxzKlwoXCRrZXlccyohPVxzKlsnIl17MCwxfW1haWxfdG9bJyJdezAsMX1ccyomJlxzKlwka2V5XHMqIT1ccypbJyJdezAsMX1zbXRwX3NlcnZlclsnIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfcG9ydCI7aToxMzM7czo1OToic3RycG9zXChcJHVhLFxzKlsnIl17MCwxfXlhbmRleGJvdFsnIl17MCwxfVwpXHMqIT09XHMqZmFsc2UiO2k6MTM0O3M6NDU6ImlmXChDaGVja0lQT3BlcmF0b3JcKFwpXHMqJiZccyohaXNNb2RlbVwoXClcKSI7aToxMzU7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMzY7czoyNzoiZWNob1xzKlsnIl1hbnN3ZXI9ZXJyb3JbJyJdIjtpOjEzNztzOjMyOiJcJHBvc3Rccyo9XHMqWyciXVxceDc3XFx4NjdcXHg2NSI7aToxMzg7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMzk7czo5OiJJcklzVFwuSXIiO2k6MTQwO3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjE0MTtzOjkyOiJjcmVhdGVfZnVuY3Rpb25ccypcKFxzKlsnIl1cJG1bJyJdXHMqLFxzKlsnIl1pZlxzKlwoXHMqXCRtXHMqXFtccyoweDAxXHMqXF1ccyo9PVxzKlsnIl1MWyciXSI7aToxNDI7czo3MjoiXCRwXHMqPVxzKnN0cnBvc1woXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjE0MztzOjExMjoiXCR1c2VyX2FnZW50XHMqPVxzKnByZWdfcmVwbGFjZVxzKlwoXHMqWyciXVx8VXNlclxcXC5BZ2VudFxcOlxbXFxzIFxdXD9cfGlbJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkdXNlcl9hZ2VudCI7aToxNDQ7czozMToicHJpbnRcKCJcI1xzK2luZm9ccytPS1xcblxcbiJcKSI7aToxNDU7czo1MToiXF1ccyp9XHMqPVxzKnRyaW1ccypcKFxzKmFycmF5X3BvcFxzKlwoXHMqXCR7XHMqXCR7IjtpOjE0NjtzOjY0OiJcXT1bJyJdezAsMX1pcFsnIl17MCwxfVxzKjtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkX1NFUlZFUlxbIjtpOjE0NztzOjM0OiJwcmludFxzKlwkc29jayAiUFJJVk1TRyAiXC5cJG93bmVyIjtpOjE0ODtzOjYzOiJpZlwoL1xeXFw6XCRvd25lciFcLlwqXFxAXC5cKlBSSVZNU0dcLlwqOlwubXNnZmxvb2RcKFwuXCpcKS9cKXsiO2k6MTQ5O3M6MjY6IlxbLVxdXHMrQ29ubmVjdGlvblxzK2ZhaWxkIjtpOjE1MDtzOjU0OiI8IS0tXCNleGVjXHMrY21kPVsnIl17MCwxfVwkSFRUUF9BQ0NFUFRbJyJdezAsMX1ccyotLT4iO2k6MTUxO3M6MTY3OiJbJyJdezAsMX1Gcm9tOlxzKlsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9cmVhbG5hbWVbJyJdezAsMX1cXVwuWyciXXswLDF9IFsnIl17MCwxfVwuWyciXXswLDF9IDxbJyJdezAsMX1cLlwkX1BPU1RcW1snIl17MCwxfWZyb21bJyJdezAsMX1cXVwuWyciXXswLDF9PlxcblsnIl17MCwxfSI7aToxNTI7czo5OToiaWZccypcKFxzKmlzX2RpclxzKlwoXHMqXCRGdWxsUGF0aFxzKlwpXHMqXClccypBbGxEaXJccypcKFxzKlwkRnVsbFBhdGhccyosXHMqXCRGaWxlc1xzKlwpO1xzKn1ccyp9IjtpOjE1MztzOjc4OiJcJHBccyo9XHMqc3RycG9zXHMqXChccypcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTU0O3M6MTIzOiJwcmVnX21hdGNoX2FsbFwoWyciXXswLDF9LzxhIGhyZWY9IlxcL3VybFxcXD9xPVwoXC5cK1w/XClcWyZcfCJcXVwrL2lzWyciXXswLDF9LCBcJHBhZ2VcW1snIl17MCwxfWV4ZVsnIl17MCwxfVxdLCBcJGxpbmtzXCkiO2k6MTU1O3M6ODA6IlwkdXJsXHMqPVxzKlwkdXJsXHMqXC5ccypbJyJdezAsMX1cP1snIl17MCwxfVxzKlwuXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRxdWVyeVwpIjtpOjE1NjtzOjgzOiJwcmludFxzK1wkc29ja1xzK1snIl17MCwxfU5JQ0sgWyciXXswLDF9XHMrXC5ccytcJG5pY2tccytcLlxzK1snIl17MCwxfVxcblsnIl17MCwxfSI7aToxNTc7czozMjoiUFJJVk1TR1wuXCo6XC5vd25lclxcc1wrXChcLlwqXCkiO2k6MTU4O3M6NzU6IlwkcmVzdWx0RlVMXHMqPVxzKnN0cmlwY3NsYXNoZXNccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfXJlc3VsdEZVTFsnIl17MCwxfSI7aToxNTk7czoxNTA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1ccypcKSI7aToxNjA7czo2MDoiaWZccypcKFxzKkA/bWQ1XHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE2MTtzOjk0OiJlY2hvXHMrZmlsZV9nZXRfY29udGVudHNccypcKFxzKmJhc2U2NF91cmxfZGVjb2RlXHMqXChccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjE2MjtzOjg0OiJmd3JpdGVccypcKFxzKlwkZmhccyosXHMqc3RyaXBzbGFzaGVzXHMqXChccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTYzO3M6ODM6ImlmXHMqXChccyptYWlsXHMqXChccypcJG1haWxzXFtcJGlcXVxzKixccypcJHRlbWFccyosXHMqYmFzZTY0X2VuY29kZVxzKlwoXHMqXCR0ZXh0IjtpOjE2NDtzOjYyOiJcJGd6aXBccyo9XHMqQD9nemluZmxhdGVccypcKFxzKkA/c3Vic3RyXHMqXChccypcJGd6ZW5jb2RlX2FyZyI7aToxNjU7czo3MzoibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyciXXswLDF9ZWxpZlsnIl17MCwxfVxdXFtbJyJdezAsMX10bXBfbmFtZSI7aToxNjY7czo4MDoiaGVhZGVyXChbJyJdezAsMX1zOlxzKlsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXHMqXChccypbJyJdezAsMX1uWyciXXswLDF9XHMqXCkiO2k6MTY3O3M6MTI6IkJ5XHMrV2ViUm9vVCI7aToxNjg7czo1NzoiXCRPT08wTzBPMDA9X19GSUxFX187XHMqXCRPTzAwTzAwMDBccyo9XHMqMHgxYjU0MDtccypldmFsIjtpOjE2OTtzOjUyOiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxdIjtpOjE3MDtzOjc3OiJwcmVnX21hdGNoXChbJyJdL1woeWFuZGV4XHxnb29nbGVcfGJvdFwpL2lbJyJdLFxzKmdldGVudlwoWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxNzE7czo0NzoiZWNob1xzK1wkaWZ1cGxvYWQ9WyciXXswLDF9XHMqSXRzT2tccypbJyJdezAsMX0iO2k6MTcyO3M6NDI6ImZzb2Nrb3BlblxzKlwoXHMqXCRDb25uZWN0QWRkcmVzc1xzKixccyoyNSI7aToxNzM7czo2NDoiXCRfU0VTU0lPTlxbWyciXXswLDF9c2Vzc2lvbl9waW5bJyJdezAsMX1cXVxzKj1ccypbJyJdezAsMX1cJFBJTiI7aToxNzQ7czo2MzoiXCR1cmxbJyJdezAsMX1ccypcLlxzKlwkc2Vzc2lvbl9pZFxzKlwuXHMqWyciXXswLDF9L2xvZ2luXC5odG1sIjtpOjE3NTtzOjQ0OiJmXHMqPVxzKlwkcVxzKlwuXHMqXCRhXHMqXC5ccypcJGJccypcLlxzKlwkeCI7aToxNzY7czo1NToiaWZccypcKG1kNVwodHJpbVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNzc7czozMzoiZGllXHMqXChccypQSFBfT1NccypcLlxzKmNoclxzKlwoIjtpOjE3ODtzOjE5MjoiY3JlYXRlX2Z1bmN0aW9uXHMqXChbJyJdWyciXVxzKixccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpIjtpOjE3OTtzOjgwOiJcJGhlYWRlcnNccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfWhlYWRlcnNbJyJdezAsMX1cXSI7aToxODA7czo4NjoiZmlsZV9wdXRfY29udGVudHNccypcKFsnIl17MCwxfTFcLnR4dFsnIl17MCwxfVxzKixccypwcmludF9yXHMqXChccypcJF9QT1NUXHMqLFxzKnRydWUiO2k6MTgxO3M6MzU6ImZ3cml0ZVxzKlwoXHMqXCRmbHdccyosXHMqXCRmbFxzKlwpIjtpOjE4MjtzOjM4OiJcJHN5c19wYXJhbXNccyo9XHMqQD9maWxlX2dldF9jb250ZW50cyI7aToxODM7czo1MToiXCRhbGxlbWFpbHNccyo9XHMqQHNwbGl0XCgiXFxuIlxzKixccypcJGVtYWlsbGlzdFwpIjtpOjE4NDtzOjUwOiJmaWxlX3B1dF9jb250ZW50c1woU1ZDX1NFTEZccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aToxODU7czo1NzoiY3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxccypcJG9wdFxbMVxdXHMqXC5ccypcJG9wdFxbNFxdIjtpOjE4NjtzOjk1OiI8c2NyaXB0XHMrdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccytzcmM9WyciXXswLDF9anF1ZXJ5LXVcLmpzWyciXXswLDF9Pjwvc2NyaXB0PiI7aToxODc7czoyODoiVVJMPTxcP2VjaG9ccytcJGluZGV4O1xzK1w/PiI7aToxODg7czoyMzoiXCNccypzZWN1cml0eXNwYWNlXC5jb20iO2k6MTg5O3M6MTg6IlwjXHMqc3RlYWx0aFxzKmJvdCI7aToxOTA7czoyMToiQXBwbGVccytTcEFtXHMrUmVadWxUIjtpOjE5MTtzOjUyOiJpc193cml0YWJsZVwoXCRkaXJcLlsnIl13cC1pbmNsdWRlcy92ZXJzaW9uXC5waHBbJyJdIjtpOjE5MjtzOjQyOiJpZlwoZW1wdHlcKFwkX0NPT0tJRVxbWyciXXhbJyJdXF1cKVwpe2VjaG8iO2k6MTkzO3M6Mjk6IlwpXF07fWlmXChpc3NldFwoXCRfU0VSVkVSXFtfIjtpOjE5NDtzOjY2OiJpZlwoQFwkdmFyc1woZ2V0X21hZ2ljX3F1b3Rlc19ncGNcKFwpXHMqXD9ccypzdHJpcHNsYXNoZXNcKFwkdXJpXCkiO2k6MTk1O3M6MzM6ImJhc2VbJyJdezAsMX1cLlwoXGQrXHMqXCpccypcZCtcKSI7aToxOTY7czo3NToiXCRwYXJhbVxzKj1ccypcJHBhcmFtXHMqeFxzKlwkblwuc3Vic3RyXHMqXChcJHBhcmFtXHMqLFxzKmxlbmd0aFwoXCRwYXJhbVwpIjtpOjE5NztzOjUzOiJyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblwoXHMqWyciXXswLDF9cmVhZF9hbnNfY29kZSI7aToxOTg7czozNToiYmFzZTY0X2RlY29kZVwoXCRfUE9TVFxbWyciXXswLDF9Xy0iO2k6MTk5O3M6NTQ6ImlmXChpc3NldFwoXCRfUE9TVFxbWyciXXswLDF9bXNnc3ViamVjdFsnIl17MCwxfVxdXClcKSI7aToyMDA7czoxMzM6Im1haWxcKFwkYXJyXFtbJyJdezAsMX10b1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1zdWJqWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfW1zZ1snIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1oZWFkWyciXXswLDF9XF1cKTsiO2k6MjAxO3M6Mzg6ImZpbGVfZ2V0X2NvbnRlbnRzXCh0cmltXChcJGZcW1wkX0dFVFxbIjtpOjIwMjtzOjYwOiJpbmlfZ2V0XChbJyJdezAsMX1maWx0ZXJcLmRlZmF1bHRfZmxhZ3NbJyJdezAsMX1cKVwpe2ZvcmVhY2giO2k6MjAzO3M6NTA6ImNodW5rX3NwbGl0XChiYXNlNjRfZW5jb2RlXChmcmVhZFwoXCR7XCR7WyciXXswLDF9IjtpOjIwNDtzOjUyOiJcJHN0cj1bJyJdezAsMX08aDE+NDAzXHMrRm9yYmlkZGVuPC9oMT48IS0tXHMqdG9rZW46IjtpOjIwNTtzOjMzOiI8XD9waHBccytyZW5hbWVcKFsnIl13c29cLnBocFsnIl0iO2k6MjA2O3M6NjQ6IlwkW2EtekEtWjAtOV9dKy9cKi57MSwxMH1cKi9ccypcLlxzKlwkW2EtekEtWjAtOV9dKy9cKi57MSwxMH1cKi8iO2k6MjA3O3M6NTE6IkA/bWFpbFwoXCRtb3NDb25maWdfbWFpbGZyb20sIFwkbW9zQ29uZmlnX2xpdmVfc2l0ZSI7aToyMDg7czo5NToiXCR0PVwkcztccypcJG9ccyo9XHMqWyciXVsnIl07XHMqZm9yXChcJGk9MDtcJGk8c3RybGVuXChcJHRcKTtcJGlcK1wrXCl7XHMqXCRvXHMqXC49XHMqXCR0e1wkaX0iO2k6MjA5O3M6NDc6Im1tY3J5cHRcKFwkZGF0YSwgXCRrZXksIFwkaXYsIFwkZGVjcnlwdCA9IEZBTFNFIjtpOjIxMDtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MjExO3M6OToidHNvaF9wdHRoIjtpOjIxMjtzOjEyOiJSRVJFRkVSX1BUVEgiO2k6MjEzO3M6MzE6IndlYmlcLnJ1L3dlYmlfZmlsZXMvcGhwX2xpYm1haWwiO2k6MjE0O3M6NDA6InN1YnN0cl9jb3VudFwoZ2V0ZW52XChcXFsnIl1IVFRQX1JFRkVSRVIiO2k6MjE1O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6MjE2O3M6MjU6ImltZyBzcmM9WyciXW9wZXJhMDAwXC5wbmciO2k6MjE3O3M6NDY6ImVjaG9ccyptZDVcKFwkX1BPU1RcW1snIl17MCwxfWNoZWNrWyciXXswLDF9XF0iO2k6MjE4O3M6MzM6ImVWYUxcKFxzKnRyaW1cKFxzKmJhU2U2NF9kZUNvRGVcKCI7aToyMTk7czo0MjoiZnNvY2tvcGVuXChcJG1cWzBcXSxcJG1cWzEwXF0sXCRfLFwkX18sXCRtIjtpOjIyMDtzOjE5OiJbJyJdPT5cJHtcJHtbJyJdXFx4IjtpOjIyMTtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMjI7czozMDoiOjpbJyJdXC5waHB2ZXJzaW9uXChcKVwuWyciXTo6IjtpOjIyMztzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIyNDtzOjE4OiI9PTBcKXtqc29uUXVpdFwoXCQiO2k6MjI1O3M6NDY6ImxvY1xzKj1ccypbJyJdezAsMX08XD9lY2hvXHMrXCRyZWRpcmVjdDtccypcPz4iO2k6MjI2O3M6Mjg6ImFycmF5XChcJGVuLFwkZXMsXCRlZixcJGVsXCkiO2k6MjI3O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MjI4O3M6MTg6ImZ1Y2tccyt5b3VyXHMrbWFtYSI7aToyMjk7czo3ODoiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl1hY3Rpb25bJyJdXHMqXC5ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjIzMDtzOjU5OiJzdHJfcmVwbGFjZVwoXCRmaW5kXHMqLFxzKlwkZmluZFxzKlwuXHMqXCRodG1sXHMqLFxzKlwkdGV4dCI7aToyMzE7czozMzoiZmlsZV9leGlzdHNccypcKD9ccypbJyJdL3Zhci90bXAvIjtpOjIzMjtzOjQxOiImJlxzKiFlbXB0eVwoXHMqXCRfQ09PS0lFXFtbJyJdZmlsbFsnIl1cXSI7aToyMzM7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjIzNDtzOjM1OiJtYWtlX2Rpcl9hbmRfZmlsZVwoXHMqXCRwYXRoX2pvb21sYSI7aToyMzU7czo0MToibGlzdGluZ19wYWdlXChccypub3RpY2VcKFxzKlsnIl1zeW1saW5rZWQiO2k6MjM2O3M6NjI6Imxpc3RccypcKFxzKlwkaG9zdFxzKixccypcJHBvcnRccyosXHMqXCRzaXplXHMqLFxzKlwkZXhlY190aW1lIjtpOjIzNztzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjIzODtzOjU4OiJmdW5jdGlvblxzK3JlYWRfcGljXChccypcJEFccypcKVxzKntccypcJGFccyo9XHMqXCRfU0VSVkVSIjtpOjIzOTtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjI0MDtzOjM5OiJcXVxzKlwpe2V2YWxcKFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqXCQiO2k6MjQxO3M6NTQ6IkxvY2F0aW9uOjppc0ZpbGVXcml0YWJsZVwoXHMqRW5jb2RlRXhwbG9yZXI6OmdldENvbmZpZyI7aToyNDI7czoxMzoiYnlccytTaHVuY2VuZyI7aToyNDM7czoxNDoie2V2YWxcKFwke1wkczIiO2k6MjQ0O3M6MTg6ImV2YWxcKFwkczIxXChcJHtcJCI7aToyNDU7czoyMToiUmFtWmtpRVxzKy1ccytleHBsb2l0IjtpOjI0NjtzOjQ3OiJbJyJdcmVtb3ZlX3NjcmlwdHNbJyJdXHMqPT5ccyphcnJheVwoWyciXVJlbW92ZSI7aToyNDc7czoyODoiXCRiYWNrX2Nvbm5lY3RfcGxccyo9XHMqWyciXSI7aToyNDg7czo0MDoiXCRzaXRlX3Jvb3RcLlwkZmlsZXVucF9kaXJcLlwkZmlsZXVucF9mbiI7aToyNDk7czoyNDoiQHByZWdfcmVwbGFjZVwoWyciXS9hZC9lIjtpOjI1MDtzOjI2OiI8Yj5cJHVpZFxzKlwoXCR1bmFtZVwpPC9iPiI7aToyNTE7czoxMToiRngyOUdvb2dsZXIiO2k6MjUyO3M6ODoiZW52aXIwbm4iO2k6MjUzO3M6NDY6ImFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqWyciXVwpLGJhc2U2NF9kZWNvZGUiO2k6MjU0O3M6Mjg6IjxcPz1ccypAcGhwX3VuYW1lXChcKTtccypcPz4iO2k6MjU1O3M6MTE6InNVeENyZXdccytWIjtpOjI1NjtzOjE2OiJXYXJCb3RccytzVXhDcmV3IjtpOjI1NztzOjQzOiJleGVjXChbJyJdY2RccysvdG1wO2N1cmxccystT1xzK1snIl1cLlwkdXJsIjtpOjI1ODtzOjE1OiJCYXRhdmk0XHMrU2hlbGwiO2k6MjU5O3M6MzY6IkBleHRyYWN0XChcJF9SRVFVRVNUXFtbJyJdZngyOXNoY29vayI7aToyNjA7czoxMDoiVHVYX1NoYWRvdyI7aToyNjE7czo0MDoiPUBmb3BlblxzKlwoWyciXXBocFwuaW5pWyciXVxzKixccypbJyJddyI7aToyNjI7czo5OiJMZWJheUNyZXciO2k6MjYzO3M6Nzk6IlwkaGVhZGVyc1xzKlwuPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZU1haWxBZGRbJyJdXHMqXF0iO2k6MjY0O3M6MTk6ImJvZ2VsXHMqLVxzKmV4cGxvaXQiO2k6MjY1O3M6NTk6IlxbdW5hbWVcXVsnIl1ccypcLlxzKnBocF91bmFtZVwoXHMqXClccypcLlxzKlsnIl1cWy91bmFtZVxdIjtpOjI2NjtzOjMyOiJcXVwoXCRfMSxcJF8xXClcKTtlbHNle1wkR0xPQkFMUyI7aToyNjc7czoxNDoiZmlsZTpmaWxlOi8vLy8iO2k6MjY4O3M6MzI6ImZ1bmN0aW9uXHMrTUNMb2dpblwoXClccyp7XHMqZGllIjtpOjI2OTtzOjU1OiJ7ZWNobyBbJyJdeWVzWyciXTsgZXhpdDt9ZWxzZXtlY2hvIFsnIl1ub1snIl07IGV4aXQ7fX19IjtpOjI3MDtzOjM5OiI7XD8+PFw/PVwke1snIl1fWyciXVwuXCRffVxbWyciXV9bJyJdXF0iO2k6MjcxO3M6NDE6IlwkYVxbMVxdPT1bJyJdYnlwYXNzaXBbJyJdXCk7XCRjPXNlbGY6OmMxIjtpOjI3MjtzOjQyOiJcJGRpclwuWyciXS9bJyJdXC5cJGZcLlsnIl0vd3AtY29uZmlnXC5waHAiO2k6MjczO3M6MjM6ImV2YWxcKFsnIl1yZXR1cm5ccytldmFsIjtpOjI3NDtzOjkwOiJmd3JpdGVcKFwkW2EtekEtWjAtOV9dKywiXFx4RUZcXHhCQlxceEJGIlwuaWNvbnZcKFsnIl1nYmtbJyJdLFsnIl11dGYtOC8vSUdOT1JFWyciXSxcJGJvZHkiO2k6Mjc1O3M6NzI6ImVjaG9ccytbJyJdX19zdWNjZXNzX19bJyJdXHMqXC5ccypcJE5vd1N1YkZvbGRlcnNccypcLlxzKlsnIl1fX3N1Y2Nlc3NfXyI7aToyNzY7czo3Nzoib2Jfc3RhcnRcKFwpO1xzKnZhcl9kdW1wXChcJF9QT1NUXHMqLFxzKlwkX0dFVFxzKixccypcJF9DT09LSUVccyosXHMqXCRfRklMRVMiO2k6Mjc3O3M6MzQ6ImdldGVudlwoIkhUVFBfSE9TVCJcKVwuJyB+IFNoZWxsIEkiO2k6Mjc4O3M6NDM6ImV2YWwvXCpcKi9cKCJldmFsXChnemluZmxhdGVcKGJhc2U2NF9kZWNvZGUiO2k6Mjc5O3M6MjU6ImFzc2VydFwoXCRbYS16QS1aMC05X10rXCgiO2k6MjgwO3M6MTg6IlwkZGVmYWNlcj0nUmVaSzJMTCI7aToyODE7czoxOToiPCVccypldmFsXHMrcmVxdWVzdCI7aToyODI7czozMToibmV3X3RpbWVcKFwkcGF0aDJmaWxlLFwkR0xPQkFMUyI7aToyODM7czo1MzoiXCRzdHI9c3RyX3JlcGxhY2VcKCJcW3RcZCtcXSJccyosXHMqIjxcPyIsXHMqXCRyZXNcKTsiO2k6Mjg0O3M6OTY6IlwkX19hPSJbYS16QS1aMC05X10rIjtccypcJF9fYVxzKj1ccypzdHJfcmVwbGFjZVwoIlthLXpBLVowLTlfXSsiLFxzKiJbYS16QS1aMC05X10rIixccypcJF9fYVwpOyI7aToyODU7czo0NDoiPCEtLVx3ezMyfS0tPjxcP3BocFxzKkBvYl9zdGFydFwoXCk7QGluaV9zZXQiO2k6Mjg2O3M6NDI6ImlmXChpc3NldFwoXCRfR0VUXFtwaHBcXVwpXClccyp7XCRmdW5jdGlvbiI7aToyODc7czoyODoiXCRzXCgiflxbZGlzY3V6XF1+ZSIsXCRfUE9TVCI7aToyODg7czo0MToiUGxnU3lzdGVtWGNhbGVuZGFySGVscGVyOjpnZXRJbnN0YW5jZVwoXCkiO2k6Mjg5O3M6NjI6ImlzX2Rpcl9lbXB0eVwoXCRfUE9TVFxbWyciXWRpcmVjdG9yeVsnIl1cXVwpXClccyp7XHMqZWNob1xzKzE7IjtpOjI5MDtzOjMyOiJpZlwoaXNzZXRcKFwkX1BPU1RcW1snIl1fX2JzY29kZSI7aToyOTE7czozNToiYmFzZTY0X2VuY29kZVwoY2xlYW5fdXJsXChcJF9TRVJWRVIiO2k6MjkyO3M6MzA6IlwkX0dFVFxbWyciXW1vZFsnIl1cXT09WyciXTBYWCI7aToyOTM7czo0NDoiXCRmb2xkZXJcLlsnIl0vcGxlYXNlX3JlbmFtZV9VTlpJUEZJUlNUXC56aXAiO2k6Mjk0O3M6NDM6IkBcJHN0cmluZ3NcKHN0cl9yb3QxM1woJ3JpbnlcKG9uZnI2NF9xcnBicXIiO2k6Mjk1O3M6Njc6IlwkdGhpcy0+c2VydmVyXHMqPVxzKlsnIl1odHRwOi8vWyciXVwuXCR0aGlzLT5zZXJ2ZXJcLlsnIl0vaW1nL1w/cT0iO2k6Mjk2O3M6NDc6ImVjaG9ccyoiPGNlbnRlcj48Yj5Eb25lXHMqPT0+XHMqXCR1c2VyZmlsZV9uYW1lIjtpOjI5NztzOjk0OiJmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rXCk7XHMqW2EtekEtWjAtOV9dK1woWyciXWh0dHBzOi8vZGxcLmRyb3Bib3h1c2VyY29udGVudFwuY29tIjtpOjI5ODtzOjYwOiJpZlwoZmlsZV9leGlzdHNcKFwkbmV3UGF0aFwpXClccyp7XHMqZWNob1xzKiJwdWJsaXNoIHN1Y2Nlc3MiO2k6Mjk5O3M6NTM6ImZ1bmN0aW9uXHMrS2lsbE1lXChcKVxzKntccyp1bmxpbmtcKFxzKk15RmlsZU5hbWVcKFwpIjtpOjMwMDtzOjYxOiI8XD9waHBccyplcnJvcl9yZXBvcnRpbmdcKEVfRVJST1JcKTtccypcJHJlbW90ZV9wYXRoPSJodHRwOi8vIjtpOjMwMTtzOjQ0OiJlY2hvXHMrcGhwX3VuYW1lXChcKTtccypAdW5saW5rXChfX0ZJTEVfX1wpOyI7aTozMDI7czo1MToiPHRpdGxlPjxcP3BocFxzK2VjaG9ccytcJHNoZWxsX3RpdGxlO1xzK1w/PjwvdGl0bGU+IjtpOjMwMztzOjU2OiJjaHJcKG9yZFwoXCRzdHJcW1wkaVxdXClccypcXlxzKlwka2V5XCk7XHMqZXZhbFwoXCRldlwpOyI7aTozMDQ7czozMDoiXCR3cF9fd3A9XCR3cF9fd3BcKHN0cl9yZXBsYWNlIjtpOjMwNTtzOjE4OiI8XD9waHBccypcJHdwX193cD0iO2k6MzA2O3M6MjQ6IjxcP3BocFxzKmV2YWxcKFsnIl1cXHg2NSI7aTozMDc7czo3NzoiQHByZWdfcmVwbGFjZVwoWyciXS9cKFwuXCpcKS9lWyciXVxzKixccypAXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzA4O3M6MjI6Ijx0aXRsZT5XM0xjb21lPC90aXRsZT4iO2k6MzA5O3M6NzU6ImlmXChzdHJpc3RyXChcJGZpbGVzXFtcJGlcXSxccypbJyJdcGhwWyciXVwpXClccyp7XHMqXCR0aW1lXHMqPVxzKmZpbGVtdGltZSI7aTozMTA7czo3NDoiXClcKXtccyppbmNsdWRlXChnZXRjd2RcKFwpXC5bJyJdL1thLXpBLVowLTlfXStcLnBocFsnIl1cKTtccypleGl0O31ccypcPz4iO2k6MzExO3M6Mjk6Ijx0aXRsZT5bJyJdXC51Y2ZpcnN0XChcJGtleVwpIjtpOjMxMjtzOjE4OiI8XD9waHBccyovXCpccypXU08iO2k6MzEzO3M6MzA6ImZ1bmN0aW9uX2V4aXN0c1woImM5OV9zZXNzX3B1dCI7aTozMTQ7czoyMToiM3hwMXIzXHMqQ3liZXJccypBcm15IjtpOjMxNTtzOjM4OiJmaWxlX2dldF9jb250ZW50c1woflxzKmJhc2U2NF9kZWNvZGVcKCI7aTozMTY7czo0NzoiaGV4ZGVjXChzdWJzdHJcKG1kNVwoXCRfU0VSVkVSXFtbJyJdUkVRVUVTVF9VUkkiO2k6MzE3O3M6ODY6InJvb3RfcGF0aD1zdWJzdHJcKFwkYWJzb2x1dGVwYXRoLDAsc3RycG9zXChcJGFic29sdXRlcGF0aCxcJGxvY2FscGF0aFwpXCk7aW5jbHVkZV9vbmNlIjtpOjMxODtzOjU1OiJcJF9TRVJWRVJcWyJSRU1PVEVfQUREUiJcXTtpZlwoXChwcmVnX21hdGNoXCgiLzY5XC40MlwuIjtpOjMxOTtzOjQxOiI8XD9waHBccyppZlwoaXNzZXRcKFwkX0dFVFxbcGhwXF1cKVwpXHMqeyI7aTozMjA7czo1OToiXClcKXtpZlwoaXNzZXRcKFwkX0ZJTEVTXFtbJyJdaW1bJyJdXF1cKVwpe1wkZGltPWdldGN3ZFwoXCkiO2k6MzIxO3M6MzM6ImNsYXNzXHMrSlNZU09QRVJBVElPTl9TZXRQYXNzd29yZCI7aTozMjI7czo0NzoiXCk7YXJyYXlfZmlsdGVyXChcJG1jZGF0YVxzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6MzIzO3M6NTk6IjxcP3BocCBpZlwoXCRtZXNzYWdlXCkgZWNobyAiPHA+XCRtZXNzYWdlPC9wPiI7IFw/PlxzKjxmb3JtIjtpOjMyNDtzOjgzOiJ0b3VjaFwoZGlybmFtZVwoX19GSUxFX19cKSxccypcJHRpbWVcKTt0b3VjaFwoXCRfU0VSVkVSXFtbJyJdU0NSSVBUX0ZJTEVOQU1FWyciXVxdLCI7aTozMjU7czoxNzoiPHRpdGxlPkZha2VTZW5kZXIiO2k6MzI2O3M6OTQ6IlwkQ29uZlxzKj1ccypAP2ZpbGVfZ2V0X2NvbnRlbnRzXChcJHBnXC5bJyJdL1w/ZD1bJyJdXHMqXC5ccypcJF9TRVJWRVJcW1snIl1IVFRQX0hPU1RbJyJdXF1cKTsiO2k6MzI3O3M6NjA6IjxcP1xzKmluY2x1ZGVcKFsnIl1bJyJdXC5cJGRyb290XC5bJyJdL2JpdHJpeC9pbWFnZXMvaWJsb2NrLyI7aTozMjg7czo2ODoiXCRmaWxlXFtcJGtleVxdXHMqPVxzKlwkZXhcWzBcXVwuXCRsaW5rXC5bJyJdPC9ib2R5PlsnIl1cLlwkZXhcWzFcXTsiO2k6MzI5O3M6MTUyOiJcJFx3ezEsNDV9XFtcJFx3ezEsNDV9XF09Y2hyXChvcmRcKFwkXHd7MSw0NX1cW1wkXHd7MSw0NX1cXVwpXF5vcmRcKFwkXHd7MSw0NX1cW1wkXHd7MSw0NX0lXCRcd3sxLDQ1fVxdXClcKTtyZXR1cm5ccypcJFx3ezEsNDV9O31wcml2YXRlIHN0YXRpYyBmdW5jdGlvbiI7aTozMzA7czo2NjoiaWZccypcKFxzKm1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCRuYXp3YV9wbGlrXHMqLFxzKlwkdXBsb2FkZmlsZVwpIjtpOjMzMTtzOjM2OiJpZlwoc3Ryc3RyXChcJHRlbXBTdHIsWyciXS8vZmlsZSBlbmQiO2k6MzMyO3M6MTI2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCg/XHMqQD9cJF9QT1NUXHMqXFtccypbJyJdLis/WyciXVxzKlxdXHMqXC5ccyoiXHMqMlxzKj5ccyomMVxzKlsnIl0iO2k6MzMzO3M6ODg6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKD9ccypbJyJddW5hbWVccystYVsnIl1ccypcKT8iO2k6MzM0O3M6ODk6IkA/YXNzZXJ0XHMqXCg/XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjMzNTtzOjI4OiJwaHBccytbJyJdXHMqXC5ccypcJHdzb19wYXRoIjtpOjMzNjtzOjUyOiJmaW5kXHMrL1xzKy1uYW1lXHMrXC5zc2hccys+XHMrXCRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjMzNztzOjQ1OiJzeXN0ZW1ccypcKD9ccypbJyJdezAsMX13aG9hbWlbJyJdezAsMX1ccypcKT8iO2k6MzM4O3M6ODg6ImN1cmxfc2V0b3B0XHMqXChccypcJGNoXHMqLFxzKkNVUkxPUFRfVVJMXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly9cJGhvc3Q6XGQrWyciXXswLDF9XHMqXCkiO2k6MzM5O3M6MzM6ImV2YWxcKFxzKlwkXHMqe1xzKlwkW2EtekEtWjAtOV9dKyI7aTozNDA7czoxNTM6ImlmXChccyppbl9hcnJheVwoXHMqXCRfU0VSVkVSXFtbJyJdUkVNT1RFX0FERFJbJyJdXF1ccyosXHMqXCRbYS16QS1aMC05X10rXClcKVxzKlwkW2EtekEtWjAtOV9dKz1cJFthLXpBLVowLTlfXStcW3JhbmRcKDAsY291bnRcKFwkW2EtekEtWjAtOV9dK1wpLTFcKVxdOyI7aTozNDE7czoyMDoiYXJyMmh0bWxcKFwkX1JFUVVFU1QiO2k6MzQyO3M6NjI6IlwkbWRldGFpbHNccypcLj1ccypbJyJdPCEtLURlcmVnaXN0ZXJcKFwpXHMqRGVmYXVsdFxzKldpZGdldHM6IjtpOjM0MztzOjU0OiJ3cF9yZW1vdGVfcmV0cmlldmVfYm9keVwoXHMqd3BfcmVtb3RlX2dldFwoXHMqXCRqcXVlcnkiO2k6MzQ0O3M6MTA2OiJAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxzKlwpXHMqXCk7XHMqWyciXVxzKlwpO1xzKlwkXHd7MSw0NX1cKFxzKlwpIjtpOjM0NTtzOjQ2OiJqc19pbmZlY3Rpb25ccyo9XHMqYXJyYXlfcmV2ZXJzZVwoXHMqc3RyX3NwbGl0Ijt9"));
$gX_FlexDBShe = unserialize(base64_decode("YTozNTY6e2k6MDtzOjYxOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypbJyJdezAsMX16aXA6IjtpOjE7czo2NjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdezAsMX16aXA6IjtpOjI7czo2ODoiZmlsZV9nZXRfY29udGVudHNcKFNSVl9OQU1FXHMqXC5ccypbJyJdXD9hY3Rpb249Z2V0X3NpdGVzJm5vZGFfbmFtZT0iO2k6MztzOjQwOiJMb2NhdGlvbjpccypbYS16QS1aMC05X10rXC5kb2N1bWVudFwuZXhlIjtpOjQ7czo0MDoiaWZcKCFwcmVnX21hdGNoXChbJyJdL0hhY2tlZCBieS9pWyciXSxcJCI7aTo1O3M6OToiQnlccytBbSFyIjtpOjY7czoxOToiQ29udGVudC1UeXBlOlxzKlwkXyI7aTo3O3M6NDA6ImV2YWxccypcKD9ccypnemluZmxhdGVccypcKD9ccypzdHJfcm90MTMiO2k6ODtzOjEwOToiaWZccypcKFxzKmlzX2NhbGxhYmxlXHMqXCg/XHMqWyciXXswLDF9XGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKlwpPyI7aTo5O3M6Mjk6ImV2YWxccypcKD9ccypnZXRfb3B0aW9uXHMqXCg/IjtpOjEwO3M6OTU6ImFkZF9maWx0ZXJccypcKD9ccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCk/IjtpOjExO3M6MzI6ImlzX3dyaXRhYmxlXHMqXCg/XHMqWyciXS92YXIvdG1wIjtpOjEyO3M6MjY6InN5bWxpbmtccypcKD9ccypbJyJdL2hvbWUvIjtpOjEzO3M6OTQ6Imlzc2V0XChccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXHMqb3JccypkaWVcKD8uKz9cKT8iO2k6MTQ7czo0OToiZ3p1bmNvbXByZXNzXHMqXCg/XHMqc3Vic3RyXHMqXCg/XHMqYmFzZTY0X2RlY29kZSI7aToxNTtzOjk6IlwkX19fXHMqPSI7aToxNjtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjE3O3M6NzE6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dK1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjE4O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MTk7czozMzoic3ltYmlhblx8bWlkcFx8d2FwXHxwaG9uZVx8cG9ja2V0IjtpOjIwO3M6NDg6ImZ1bmN0aW9uXHMqY2htb2RfUlxzKlwoXHMqXCRwYXRoXHMqLFxzKlwkcGVybVxzKiI7aToyMTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyMjtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6MjM7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjI0O3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjU7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI2O3M6MzU6ImVjaG9ccytbJyJdezAsMX1pbnN0YWxsX29rWyciXXswLDF9IjtpOjI3O3M6MTY6IlNwYW1ccytjb21wbGV0ZWQiO2k6Mjg7czo0NDoiYXJyYXlcKFxzKlsnIl1Hb29nbGVbJyJdXHMqLFxzKlsnIl1TbHVycFsnIl0iO2k6Mjk7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6MzA7czoyMDoiL2VbJyJdXHMqLFxzKlsnIl1cXHgiO2k6MzE7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6MzI7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MzM7czozNjoicHJlZ19yZXBsYWNlXChccypbJyJdZVsnIl0sWyciXXswLDF9IjtpOjM0O3M6NTM6ImZvcGVuXChbJyJdezAsMX1cLlwuL1wuXC4vXC5cLi9bJyJdezAsMX1cLlwkZmlsZXBhdGhzIjtpOjM1O3M6NTE6IlwkZGF0YVxzKj1ccyphcnJheVwoWyciXXswLDF9dGVybWluYWxbJyJdezAsMX1ccyo9PiI7aTozNjtzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aTozNztzOjMzOiJwb3J0bGV0cy9mcmFtZXdvcmsvc2VjdXJpdHkvbG9naW4iO2k6Mzg7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aTozOTtzOjEwNDoic2l0ZV9mcm9tPVsnIl17MCwxfVwuXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1cXVwuWyciXXswLDF9JnNpdGVfZm9sZGVyPVsnIl17MCwxfVwuXCRmXFsxXF0iO2k6NDA7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6NDE7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aTo0MjtzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aTo0MztzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjQ0O3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjQ1O3M6NDc6ImlmIFwoZGF0ZVwoWyciXXswLDF9alsnIl17MCwxfVwpXHMqLVxzKlwkbmV3c2lkIjtpOjQ2O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo0NztzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjQ4O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NDk7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo1MDtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjUxO3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjUyO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjUzO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjU0O3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo1NTtzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjU2O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjU3O3M6MTA0OiJmb3JcKFwkW2EtekEtWjAtOV9dKz1cZCs7XCRbYS16QS1aMC05X10rPFxkKztcJFthLXpBLVowLTlfXSstPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSshPVxkK1wpXHMqYnJlYWs7fSI7aTo1ODtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6NTk7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAP1wkX0NPT0tJRVxbIjtpOjYwO3M6Mzg6InByZWdfcmVwbGFjZVwoXCl7cmV0dXJuXHMrX19GVU5DVElPTl9fIjtpOjYxO3M6Mzk6ImlmXHMqXChjaGVja19hY2NcKFwkbG9naW4sXCRwYXNzLFwkc2VydiI7aTo2MjtzOjM2OiJwcmludFxzK1snIl17MCwxfWRsZV9udWxsZWRbJyJdezAsMX0iO2k6NjM7czo2MzoiaWZcKG1haWxcKFwkZW1haWxcW1wkaVxdLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjY0O3M6MTI6IlRlYU1ccytNb3NUYSI7aTo2NTtzOjE0OiJbJyJdezAsMX1EWmUxciI7aTo2NjtzOjE1OiJwYWNrXHMrIlNuQTR4OCIiO2k6Njc7czozMjoiXCRfUG9zdFxbWyciXXswLDF9U1NOWyciXXswLDF9XF0iO2k6Njg7czoyNzoiRXRobmljXHMrQWxiYW5pYW5ccytIYWNrZXJzIjtpOjY5O3M6OToiQnlccytEWjI3IjtpOjcwO3M6NzQ6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWNtZFwuZXhlIjtpOjcxO3M6MTU6IkF1dG9ccypYcGxvaXRlciI7aTo3MjtzOjk6ImJ5XHMrZzAwbiI7aTo3MztzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjc0O3M6OTQ6ImlmXChpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWNvbnRlbnRbJyJdezAsMX1cKVxzK0FORFxzK2lzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtYWRtaW4iO2k6NzU7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjc2O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aTo3NztzOjQwOiJzdHJfcmVwbGFjZVxzKlwoXHMqWyciXXswLDF9L3B1YmxpY19odG1sIjtpOjc4O3M6NDE6ImlmXChccyppc3NldFwoXHMqXCRfUkVRVUVTVFxbWyciXXswLDF9Y2lkIjtpOjc5O3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aTo4MDtzOjg1OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9qY2UmdGFzaz1wbHVnaW4mcGx1Z2luPWltZ21hbmFnZXImZmlsZT1pbWdtYW5hZ2VyJnZlcnNpb249XGQrIjtpOjgxO3M6Mzc6InNldGNvb2tpZVwoXHMqXCR6XFswXF1ccyosXHMqXCR6XFsxXF0iO2k6ODI7czozMjoiXCRTXFtcJGlcK1wrXF1cKFwkU1xbXCRpXCtcK1xdXCgiO2k6ODM7czozMjoiXFtcJG9cXVwpO1wkb1wrXCtcKXtpZlwoXCRvPDE2XCkiO2k6ODQ7czo4MToidHlwZW9mXHMqXChkbGVfYWRtaW5cKVxzKj09XHMqWyciXXswLDF9dW5kZWZpbmVkWyciXXswLDF9XHMqXHxcfFxzKmRsZV9hZG1pblxzKj09IjtpOjg1O3M6MzY6ImNyZWF0ZV9mdW5jdGlvblwoc3Vic3RyXCgyLDFcKSxcJHNcKSI7aTo4NjtzOjYwOiJwbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwJTNBJTJGJTJGd3d3XC5nb29nbGUiO2k6ODc7czozNjoicmV0dXJuXHMrYmFzZTY0X2RlY29kZVwoXCRhXFtcJGlcXVwpIjtpOjg4O3M6NDU6IlwkZmlsZVwoQD9cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo4OTtzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6OTA7czozMjoiZXZhbFwoWyciXVw/PlsnIl1cLmJhc2U2NF9kZWNvZGUiO2k6OTE7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6OTI7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aTo5MztzOjE5OiJncmVwXHMrLXZccytjcm9udGFiIjtpOjk0O3M6MzQ6ImNyYzMyXChccypcJF9QT1NUXFtccypbJyJdezAsMX1jbWQiO2k6OTU7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aTo5NjtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6OTc7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjk4O3M6NDg6IlxzKlsnIl17MCwxfXNsdXJwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfW1zbmJvdCI7aTo5OTtzOjIwOiJldmFsXHMqXChccypUUExfRklMRSI7aToxMDA7czo4MjoiQD9hcnJheV9kaWZmX3VrZXlcKFxzKkA/YXJyYXlcKFxzKlwoc3RyaW5nXClccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMDE7czoxMDU6IlwkcGF0aFxzKj1ccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXVxzKlwuXHMqWyciXXswLDF9L2ltYWdlcy9zdG9yaWVzL1snIl17MCwxfSI7aToxMDI7czo4OToiXCRzYXBlX29wdGlvblxbXHMqWyciXXswLDF9ZmV0Y2hfcmVtb3RlX3R5cGVbJyJdezAsMX1ccypcXVxzKj1ccypbJyJdezAsMX1zb2NrZXRbJyJdezAsMX0iO2k6MTAzO3M6ODg6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJG5hbWVccyosXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTA0O3M6ODI6ImVyZWdfcmVwbGFjZVwoWyciXXswLDF9JTVDJTIyWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfSUyMlsnIl17MCwxfVxzKixccypcJG1lc3NhZ2UiO2k6MTA1O3M6ODU6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX11clsnIl17MCwxfVxdXClcKVxzKlwkbW9kZVxzKlx8PVxzKjA0MDAiO2k6MTA2O3M6NDE6Ii9wbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwIjtpOjEwNztzOjQ5OiJAP2ZpbGVfcHV0X2NvbnRlbnRzXChccypcJHRoaXMtPmZpbGVccyosXHMqc3RycmV2IjtpOjEwODtzOjQ4OiJwcmVnX21hdGNoX2FsbFwoXHMqWyciXVx8XChcLlwqXCk8XFwhLS0ganMtdG9vbHMiO2k6MTA5O3M6MzA6ImhlYWRlclwoWyciXXswLDF9cjpccypub1xzK2NvbSI7aToxMTA7czo3NToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXWxzXHMrL3Zhci9tYWlsIjtpOjExMTtzOjI2OiJcJGRvcl9jb250ZW50PXByZWdfcmVwbGFjZSI7aToxMTI7czoyMzoiX191cmxfZ2V0X2NvbnRlbnRzXChcJGwiO2k6MTEzO3M6NTM6IlwkR0xPQkFMU1xbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXChccypOVUxMIjtpOjExNDtzOjYyOiJ1bmFtZVxdWyciXXswLDF9XHMqXC5ccypwaHBfdW5hbWVcKFwpXHMqXC5ccypbJyJdezAsMX1cWy91bmFtZSI7aToxMTU7czozMzoiQFwkZnVuY1woXCRjZmlsZSwgXCRjZGlyXC5cJGNuYW1lIjtpOjExNjtzOjM1OiJldmFsXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkPGFtYyI7aToxMTc7czo3MToiXCRfXFtccypcZCtccypcXVwoXHMqXCRfXFtccypcZCtccypcXVwoXCRfXFtccypcZCtccypcXVwoXHMqXCRfXFtccypcZCsiO2k6MTE4O3M6Mjk6ImVyZWdpXChccypzcWxfcmVnY2FzZVwoXHMqXCRfIjtpOjExOTtzOjQwOiJcI1VzZVsnIl17MCwxfVxzKixccypmaWxlX2dldF9jb250ZW50c1woIjtpOjEyMDtzOjIwOiJta2RpclwoXHMqWyciXS9ob21lLyI7aToxMjE7czoyMDoiZm9wZW5cKFxzKlsnIl0vaG9tZS8iO2k6MTIyO3M6MzY6IlwkdXNlcl9hZ2VudF90b19maWx0ZXJccyo9XHMqYXJyYXlcKCI7aToxMjM7czo0NDoiZmlsZV9wdXRfY29udGVudHNcKFsnIl17MCwxfVwuL2xpYndvcmtlclwuc28iO2k6MTI0O3M6NjQ6IlwjIS9iaW4vc2huY2RccytbJyJdezAsMX1bJyJdezAsMX1cLlwkU0NQXC5bJyJdezAsMX1bJyJdezAsMX1uaWYiO2k6MTI1O3M6ODI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl17MCwxfWF0XHMrbm93XHMrLWYiO2k6MTI2O3M6MzM6ImNyb250YWJccystbFx8Z3JlcFxzKy12XHMrY3JvbnRhYiI7aToxMjc7czoxNDoiRGF2aWRccypCbGFpbmUiO2k6MTI4O3M6MjM6ImV4cGxvaXQtZGJcLmNvbS9zZWFyY2gvIjtpOjEyOTtzOjM2OiJmaWxlX3B1dF9jb250ZW50c1woXHMqWyciXXswLDF9L2hvbWUiO2k6MTMwO3M6NjA6Im1haWxcKFxzKlwkTWFpbFRvXHMqLFxzKlwkTWVzc2FnZVN1YmplY3RccyosXHMqXCRNZXNzYWdlQm9keSI7aToxMzE7czoxMTc6IlwkY29udGVudFxzKj1ccypodHRwX3JlcXVlc3RcKFsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1ccypcLlxzKlwkX1NFUlZFUlxbWyciXXswLDF9U0VSVkVSX05BTUVbJyJdezAsMX1cXVwuWyciXXswLDF9LyI7aToxMzI7czo3ODoiIWZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRibmFtZVxzKixccypcJHRoaXMtPmdldEltYWdlRW5jb2RlZFRleHRcKFxzKlwkZGJuYW1lIjtpOjEzMztzOjQ0OiJzY3JpcHRzXFtccypnenVuY29tcHJlc3NcKFxzKmJhc2U2NF9kZWNvZGVcKCI7aToxMzQ7czo3Mjoic2VuZF9zbXRwXChccypcJGVtYWlsXFtbJyJdezAsMX1hZHJbJyJdezAsMX1cXVxzKixccypcJHN1YmpccyosXHMqXCR0ZXh0IjtpOjEzNTtzOjQ2OiI9XCRmaWxlXChAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEzNjtzOjUyOiJ0b3VjaFwoXHMqWyciXXswLDF9XCRiYXNlcGF0aC9jb21wb25lbnRzL2NvbV9jb250ZW50IjtpOjEzNztzOjI3OiJcKFsnIl1cJHRtcGRpci9zZXNzX2ZjXC5sb2ciO2k6MTM4O3M6MzU6ImZpbGVfZXhpc3RzXChccypbJyJdL3RtcC90bXAtc2VydmVyIjtpOjEzOTtzOjQ5OiJtYWlsXChccypcJHJldG9ybm9ccyosXHMqXCRhc3VudG9ccyosXHMqXCRtZW5zYWplIjtpOjE0MDtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFcKVxzKlxdXC5yYW5kIjtpOjE0MTtzOjQwOiJfX2ZpbGVfZ2V0X3VybF9jb250ZW50c1woXHMqXCRyZW1vdGVfdXJsIjtpOjE0MjtzOjEzOiI9YnlccytEUkFHT049IjtpOjE0MztzOjk4OiJzdWJzdHJcKFxzKlwkc3RyaW5nMlxzKixccypzdHJsZW5cKFxzKlwkc3RyaW5nMlxzKlwpXHMqLVxzKjlccyosXHMqOVwpXHMqPT1ccypbJyJdezAsMX1cW2wscj0zMDJcXSI7aToxNDQ7czozMzoiXFtcXVxzKj1ccypbJyJdUmV3cml0ZUVuZ2luZVxzK29uIjtpOjE0NTtzOjc1OiJmd3JpdGVcKFxzKlwkZlxzKixccypnZXRfZG93bmxvYWRcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTQ2O3M6NDc6InRhclxzKy1jemZccysiXHMqXC5ccypcJEZPUk17dGFyfVxzKlwuXHMqIlwudGFyIjtpOjE0NztzOjExOiJzY29wYmluWyciXSI7aToxNDg7czo2NjoiPGRpdlxzK2lkPVsnIl1saW5rMVsnIl0+PGJ1dHRvbiBvbmNsaWNrPVsnIl1wcm9jZXNzVGltZXJcKFwpO1snIl0+IjtpOjE0OTtzOjM1OiI8Z3VpZD48XD9waHBccytlY2hvXHMrXCRjdXJyZW50X3VybCI7aToxNTA7czo2MjoiaW50MzJcKFwoXChcJHpccyo+PlxzKjVccyomXHMqMHgwN2ZmZmZmZlwpXHMqXF5ccypcJHlccyo8PFxzKjIiO2k6MTUxO3M6NDM6ImZvcGVuXChccypcJHJvb3RfZGlyXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6MTUyO3M6MjM6IlwkaW5fUGVybXNccysmXHMrMHg0MDAwIjtpOjE1MztzOjM0OiJmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS92YXIvdG1wIjtpOjE1NDtzOjk6Ii9wbXQvcmF2LyI7aToxNTU7czo0OToiZndyaXRlXChcJGZwXHMqLFxzKnN0cnJldlwoXHMqXCRjb250ZXh0XHMqXClccypcKSI7aToxNTY7czoyMDoiTWFzcmlccytDeWJlclxzK1RlYW0iO2k6MTU3O3M6MTg6IlVzM1xzK1kwdXJccyticjQxbiI7aToxNTg7czoyMDoiTWFzcjFccytDeWIzclxzK1RlNG0iO2k6MTU5O3M6MjA6InRIQU5Lc1xzK3RPXHMrU25vcHB5IjtpOjE2MDtzOjY2OiIsXHMqWyciXS9pbmRleFxcXC5cKHBocFx8aHRtbFwpL2lbJyJdXHMqLFxzKlJlY3Vyc2l2ZVJlZ2V4SXRlcmF0b3IiO2k6MTYxO3M6NDc6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjE2MjtzOjU1OiJnZXRwcm90b2J5bmFtZVwoXHMqWyciXXRjcFsnIl1ccypcKVxzK1x8XHxccytkaWVccytzaGl0IjtpOjE2MztzOjc4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdY2RccysvdG1wO3dnZXQiO2k6MTY0O3M6MjI6IjxhXHMraHJlZj1bJyJdb3NoaWJrYS0iO2k6MTY1O3M6ODU6ImlmXChccypcJF9HRVRcW1xzKlsnIl1pZFsnIl1ccypcXSE9XHMqWyciXVsnIl1ccypcKVxzKlwkaWQ9XCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0iO2k6MTY2O3M6ODM6ImlmXChbJyJdc3Vic3RyX2NvdW50XChbJyJdXCRfU0VSVkVSXFtbJyJdUkVRVUVTVF9VUklbJyJdXF1ccyosXHMqWyciXXF1ZXJ5XC5waHBbJyJdIjtpOjE2NztzOjM4OiJcJGZpbGwgPSBcJF9DT09LSUVcW1xcWyciXWZpbGxcXFsnIl1cXSI7aToxNjg7czo2MjoiXCRyZXN1bHQ9c21hcnRDb3B5XChccypcJHNvdXJjZVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGZpbGUiO2k6MTY5O3M6NDA6IlwkYmFubmVkSVBccyo9XHMqYXJyYXlcKFxzKlsnIl1cXjY2XC4xMDIiO2k6MTcwO3M6MzU6Ijxsb2M+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmw7IjtpOjE3MTtzOjI4OiJcJHNldGNvb2tcKTtzZXRjb29raWVcKFwkc2V0IjtpOjE3MjtzOjI4OiJcKTtmdW5jdGlvblxzK3N0cmluZ19jcHRcKFwkIjtpOjE3MztzOjUwOiJbJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXSI7aToxNzQ7czo1MzoiaWZcKHByZWdfbWF0Y2hcKFsnIl1cI3dvcmRwcmVzc19sb2dnZWRfaW5cfGFkbWluXHxwd2QiO2k6MTc1O3M6NDE6ImdfZGVsZXRlX29uX2V4aXRccyo9XHMqbmV3XHMrRGVsZXRlT25FeGl0IjtpOjE3NjtzOjMwOiJTRUxFQ1RccytcKlxzK0ZST01ccytkb3JfcGFnZXMiO2k6MTc3O3M6MTg6IkFjYWRlbWljb1xzK1Jlc3VsdCI7aToxNzg7czo3NzoidmFsdWU9WyciXTxcP1xzK1xiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl0iO2k6MTc5O3M6Mjc6IlxkKyZAcHJlZ19tYXRjaFwoXHMqc3RydHJcKCI7aToxODA7czozODoiY2hyXChccypoZXhkZWNcKFxzKnN1YnN0clwoXHMqXCRtYWtldXAiO2k6MTgxO3M6MzA6InJlYWRfZmlsZV9uZXdfMlwoXCRyZXN1bHRfcGF0aCI7aToxODI7czoyMzoiXCRpbmRleF9wYXRoXHMqLFxzKjA0MDQiO2k6MTgzO3M6Njc6IlwkZmlsZV9mb3JfdG91Y2hccyo9XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6MTg0O3M6NjE6IlwkX1NFUlZFUlxbWyciXXswLDF9UkVNT1RFX0FERFJbJyJdezAsMX1cXTtpZlwoXChwcmVnX21hdGNoXCgiO2k6MTg1O3M6MTk6Ij09XHMqWyciXWNzaGVsbFsnIl0iO2k6MTg2O3M6Mjk6ImZpbGVfZXhpc3RzXChccypcJEZpbGVCYXphVFhUIjtpOjE4NztzOjE4OiJyZXN1bHRzaWduX3dhcm5pbmciO2k6MTg4O3M6MjQ6ImZ1bmN0aW9uXHMrZ2V0Zmlyc3RzaHRhZyI7aToxODk7czo5MDoiZmlsZV9nZXRfY29udGVudHNcKFJPT1RfRElSXC5bJyJdL3RlbXBsYXRlcy9bJyJdXC5cJGNvbmZpZ1xbWyciXXNraW5bJyJdXF1cLlsnIl0vbWFpblwudHBsIjtpOjE5MDtzOjI1OiJuZXdccytjb25lY3RCYXNlXChbJyJdYUhSIjtpOjE5MTtzOjgzOiJcJGlkXHMqXC5ccypbJyJdXD9kPVsnIl1ccypcLlxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfVVNFUl9BR0VOVCI7aToxOTI7czoyOToiZG9fd29ya1woXHMqXCRpbmRleF9maWxlXHMqXCkiO2k6MTkzO3M6MjA6ImhlYWRlclxzKlwoXHMqX1xkK1woIjtpOjE5NDtzOjEyOiJCeVxzK1dlYlJvb1QiO2k6MTk1O3M6MTY6IkNvZGVkXHMrYnlccytFWEUiO2k6MTk2O3M6NzE6InRyaW1cKFxzKlwkaGVhZGVyc1xzKlwpXHMqXClccyphc1xzKlwkaGVhZGVyXHMqXClccypoZWFkZXJcKFxzKlwkaGVhZGVyIjtpOjE5NztzOjU2OiJAXCRfU0VSVkVSXFtccypIVFRQX0hPU1RccypcXT5bJyJdXHMqXC5ccypbJyJdXFxyXFxuWyciXSI7aToxOTg7czo4MToiZmlsZV9nZXRfY29udGVudHNcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjE5OTtzOjY5OiJ0b3VjaFwoXHMqXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9lbmdpbmUiO2k6MjAwO3M6MTY6IlBIUFNIRUxMX1ZFUlNJT04iO2k6MjAxO3M6MjU6IjxcP1xzKj1AYFwkW2EtekEtWjAtOV9dK2AiO2k6MjAyO3M6MjE6IiZfU0VTU0lPTlxbcGF5bG9hZFxdPSI7aToyMDM7czo0NzoiZ3p1bmNvbXByZXNzXChccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXWh0dHAiO2k6MjA0O3M6ODQ6ImlmXChccyohZW1wdHlcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXRwMlsnIl17MCwxfVxzKlxdXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToyMDU7czo0OToiaWZcKFxzKnRydWVccyomXHMqQHByZWdfbWF0Y2hcKFxzKnN0cnRyXChccypbJyJdLyI7aToyMDY7czozODoiPT1ccyowXClccyp7XHMqZWNob1xzKlBIUF9PU1xzKlwuXHMqXCQiO2k6MjA3O3M6MTA3OiJpc3NldFwoXHMqXCRfU0VSVkVSXFtccypfXGQrXChccypcZCtccypcKVxzKlxdXHMqXClccypcP1xzKlwkX1NFUlZFUlxbXHMqX1xkK1woXGQrXClccypcXVxzKjpccypfXGQrXChcZCtcKSI7aToyMDg7czo5OToiXCRpbmRleFxzKj1ccypzdHJfcmVwbGFjZVwoXHMqWyciXTxcP3BocFxzKm9iX2VuZF9mbHVzaFwoXCk7XHMqXD8+WyciXVxzKixccypbJyJdWyciXVxzKixccypcJGluZGV4IjtpOjIwOTtzOjMzOiJcJHN0YXR1c19sb2Nfc2hccyo9XHMqZmlsZV9leGlzdHMiO2k6MjEwO3M6NDg6IlwkUE9TVF9TVFJccyo9XHMqZmlsZV9nZXRfY29udGVudHNcKCJwaHA6Ly9pbnB1dCI7aToyMTE7czo0ODoiZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdbWVzIjtpOjIxMjtzOjY2OiJcJHRhYmxlXFtcJHN0cmluZ1xbXCRpXF1cXVxzKlwqXHMqcG93XCg2NFxzKixccyoyXClccypcK1xzKlwkdGFibGUiO2k6MjEzO3M6MzM6ImlmXChccypzdHJpcG9zXChccypbJyJdXCpcKlwqXCR1YSI7aToyMTQ7czo0OToiZmx1c2hfZW5kX2ZpbGVcKFxzKlwkZmlsZW5hbWVccyosXHMqXCRmaWxlY29udGVudCI7aToyMTU7czo1NjoicHJlZ19tYXRjaFwoXHMqWyciXXswLDF9fkxvY2F0aW9uOlwoXC5cKlw/XClcKFw/Olxcblx8XCQiO2k6MjE2O3M6Mjg6InRvdWNoXChccypcJHRoaXMtPmNvbmYtPnJvb3QiO2k6MjE3O3M6MzY6ImV2YWxcKFxzKlwke1xzKlwkW2EtekEtWjAtOV9dK1xzKn1cWyI7aToyMTg7czo0MzoiaWZccypcKFxzKkBmaWxldHlwZVwoXCRsZWFkb25ccypcLlxzKlwkZmlsZSI7aToyMTk7czo1OToiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGlyXHMqXC5ccypcJGZpbGVccypcLlxzKlsnIl0vaW5kZXgiO2k6MjIwO3M6MjY6ImZpbGVzaXplXChccypcJHB1dF9rX2ZhaWx1IjtpOjIyMTtzOjYwOiJhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdezAsMX1tZXNbJyJdXF0iO2k6MjIyO3M6NDM6ImZ1bmN0aW9uXHMrZmluZEhlYWRlckxpbmVccypcKFxzKlwkdGVtcGxhdGUiO2k6MjIzO3M6NDM6Ilwkc3RhdHVzX2NyZWF0ZV9nbG9iX2ZpbGVccyo9XHMqY3JlYXRlX2ZpbGUiO2k6MjI0O3M6Mzg6ImVjaG9ccytzaG93X3F1ZXJ5X2Zvcm1cKFxzKlwkc3Fsc3RyaW5nIjtpOjIyNTtzOjM1OiI9PVxzKkZBTFNFXHMqXD9ccypcZCtccyo6XHMqaXAybG9uZyI7aToyMjY7czoyMjoiZnVuY3Rpb25ccyttYWlsZXJfc3BhbSI7aToyMjc7czozNDoiRWRpdEh0YWNjZXNzXChccypbJyJdUmV3cml0ZUVuZ2luZSI7aToyMjg7czoxMToiXCRwYXRoVG9Eb3IiO2k6MjI5O3M6NDA6IlwkY3VyX2NhdF9pZFxzKj1ccypcKFxzKmlzc2V0XChccypcJF9HRVQiO2k6MjMwO3M6OTc6IkBcJF9DT09LSUVcW1xzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKlxdXChccypAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVxzKlwpXHMqXCkiO2k6MjMxO3M6NDA6ImhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly9cJHBwXC5vcmciO2k6MjMyO3M6NDc6InJldHVyblxzK1snIl0vaG9tZS9bYS16QS1aMC05X10rL1thLXpBLVowLTlfXSsvIjtpOjIzMztzOjM5OiJbJyJdd3AtWyciXVxzKlwuXHMqZ2VuZXJhdGVSYW5kb21TdHJpbmciO2k6MjM0O3M6Njc6IlwkW2EtekEtWjAtOV9dKz09WyciXWZlYXR1cmVkWyciXVxzKlwpXHMqXCl7XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGUiO2k6MjM1O3M6MTA2OiJcJFthLXpBLVowLTlfXStccyo9XHMqXCRqcVxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdIjtpOjIzNjtzOjIyOiJleHBsb2l0XHMqOjpcLjwvdGl0bGU+IjtpOjIzNztzOjQwOiJcJFthLXpBLVowLTlfXSs9c3RyX3JlcGxhY2VcKFsnIl1cKmFcJFwqIjtpOjIzODtzOjYwOiJjaHJcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpO1xzKn1ccypldmFsXChccypcJFthLXpBLVowLTlfXSsiO2k6MjM5O3M6NDc6ImlmXChccyppc0luU3RyaW5nMT9cKFwkW2EtekEtWjAtOV9dKyxbJyJdZ29vZ2xlIjtpOjI0MDtzOjkzOiJcJHBwXHMqPVxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF1ccypcLlxzKlwkcFxbXGQrXF0iO2k6MjQxO3M6NDk6ImZpbGVfcHV0X2NvbnRlbnRzXChESVJcLlsnIl0vWyciXVwuWyciXWluZGV4XC5waHAiO2k6MjQyO3M6Mjk6IkBnZXRfaGVhZGVyc1woXHMqXCRmdWxscGF0aFwpIjtpOjI0MztzOjIxOiJAXCRfR0VUXFtbJyJdcHdbJyJdXF0iO2k6MjQ0O3M6MjU6Impzb25fZW5jb2RlXChhbGV4dXNNYWlsZXIiO2k6MjQ1O3M6MTY4OiJldmFsXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MjQ2O3M6MTk6Ij1bJyJdXClcKTtbJyJdXClcKTsiO2k6MjQ3O3M6MTgwOiI9XHMqXCRbYS16QS1aMC05X10rXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MjQ4O3M6NTU6IlxdXHMqfVxzKlwoXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjQ5O3M6Nzc6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woXHMqWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1ccypcKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjI1MDtzOjQ4OiJldmFsXChbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoWyciXVsnIl0sZmlsZVwoXCQiO2k6MjUxO3M6Njg6InNldG9wdFwoXCRjaFxzKixccypDVVJMT1BUX1BPU1RGSUVMRFNccyosXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRkYXRhIjtpOjI1MjtzOjExNzoibXlzcWxfY29ubmVjdFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI1MztzOjY0OiJyZXF1ZXN0XC5zZXJ2ZXJ2YXJpYWJsZXNcKFsnIl1IVFRQX1VTRVJfQUdFTlRbJyJdXCksWyciXWFpZHVbJyJdIjtpOjI1NDtzOjM2OiJcXVxzKlwpXHMqXClccyp7XHMqZXZhbFxzKlwoXHMqXCR7XCQiO2k6MjU1O3M6MTY6ImJ5XHMrRXJyb3Jccys3ckIiO2k6MjU2O3M6MzM6IkBpcmNzZXJ2ZXJzXFtyYW5kXHMrQGlyY3NlcnZlcnNcXSI7aToyNTc7czo1OToic2V0X3RpbWVfbGltaXRcKGludHZhbFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MjU4O3M6MjQ6Im5pY2tccytbJyJdY2hhbnNlcnZbJyJdOyI7aToyNTk7czoyMzoiTWFnaWNccytJbmNsdWRlXHMrU2hlbGwiO2k6MjYwO3M6OTc6IlwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dKz1jcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dK1woXCkiO2k6MjYxO3M6Mzg6ImN1cmxPcGVuXChcJHJlbW90ZV9wYXRoXC5cJHBhcmFtX3ZhbHVlIjtpOjI2MjtzOjQ3OiJmd3JpdGVcKFwkZnAsWyciXVxceEVGXFx4QkJcXHhCRlsnIl1cLlwkYm9keVwpOyI7aToyNjM7czoxMzM6IlwkW2EtekEtWjAtOV9dK1wrXCtcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqYXJyYXlfdW5pcXVlXChhcnJheV9tZXJnZVwoXCRbYS16QS1aMC05X10rXHMqLFxzKlthLXpBLVowLTlfXStcKFsnIl1cJFthLXpBLVowLTlfXSsiO2k6MjY0O3M6NDI6ImFuZFxzKlwoIVxzKnN0cnN0clwoXCR1YSxbJyJdcnY6MTFbJyJdXClcKSI7aToyNjU7czozNToiZWNob1xzK1wkb2tccytcP1xzK1snIl1TSEVMTF9PS1snIl0iO2k6MjY2O3M6Mjc6IjtldmFsXChcJHRvZG9jb250ZW50XFswXF1cKSI7aToyNjc7czo0MDoib3JccytzdHJ0b2xvd2VyXChAaW5pX2dldFwoWyciXXNhZmVfbW9kZSI7aToyNjg7czoyOToiaWZcKCFpc3NldFwoXCRfUkVRVUVTVFxbY2hyXCgiO2k6MjY5O3M6NDQ6IlwkcHJvY2Vzc29ccyo9XHMqXCRwc1xbcmFuZFxzK3NjYWxhclxzK0Bwc1xdIjtpOjI3MDtzOjMyOiJlY2hvXHMrWyciXXVuYW1lXHMrLWE7XHMqXCR1bmFtZSI7aToyNzE7czoyMToiXC50Y3BmbG9vZFxzKzx0YXJnZXQ+IjtpOjI3MjtzOjUwOiJcJGJvdFxbWyciXXNlcnZlclsnIl1cXT1cJHNlcnZiYW5cW3JhbmRcKDAsY291bnRcKCI7aToyNzM7czoxNjoiXC46XHMrdzMzZFxzKzpcLiI7aToyNzQ7czoxNjoiQkxBQ0tVTklYXHMrQ1JFVyI7aToyNzU7czoxMTg6IjtcJFthLXpBLVowLTlfXStcW1wkW2EtekEtWjAtOV9dK1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cW1xkK1xdXC5cJFthLXpBLVowLTlfXStcW1snIl1bYS16QS1aMC05X10rWyciXVxdXFtcZCtcXVwuXCQiO2k6Mjc2O3M6MzA6ImNhc2VccypbJyJdY3JlYXRlX3N5bWxpbmtbJyJdOiI7aToyNzc7czo5Njoic29ja2V0X2Nvbm5lY3RcKFwkW2EtekEtWjAtOV9dKyxccypbJyJdZ21haWwtc210cC1pblwubFwuZ29vZ2xlXC5jb21bJyJdXHMqLFxzKjI1XClccyo9PVxzKkZBTFNFIjtpOjI3ODtzOjQ2OiJjYWxsX3VzZXJfZnVuY1woQHVuaGV4XCgweFthLXpBLVowLTlfXStcKVwoXCRfIjtpOjI3OTtzOjYyOiJcJF89QFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClcLkBcJF9cKFwkX1JFUVVFU1RcWyI7aToyODA7czo2NToiXCRHTE9CQUxTXFtcJEdMT0JBTFNcW1snIl1bYS16QS1aMC05X10rWyciXVxdXFtcZCtcXVwuXCRHTE9CQUxTXFsiO2k6MjgxO3M6NjM6IlwuXCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcXVwuWyciXXtbJyJdXClcKTt9O3Vuc2V0XChcJCI7aToyODI7czo4NjoiaHR0cF9idWlsZF9xdWVyeVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcKVwuWyciXSZpcD1bJyJdXHMqXC5ccypcJF9TRVJWRVIiO2k6MjgzO3M6ODI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl0vc2Jpbi9pZmNvbmZpZ1snIl0iO2k6Mjg0O3M6ODk6IjxcP3BocFxzK2lmXHMqXChpc3NldFxzKlwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1pbWFnZXNbJyJdXF1cKVwpXHMqe1wkIjtpOjI4NTtzOjE3OiI8dGl0bGU+R09SRE9ccysyMCI7aToyODY7czoxMzg6ImNvcHlcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKSI7aToyODc7czo2ODoic3ByaW50ZlwoW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1wpXHMqXCkiO2k6Mjg4O3M6Njg6Ij1ccypzdHJfcmVwbGFjZVwoXHMqWyciXVx8XHxcfFthLXpBLVowLTlfXStcfFx8XHxbJyJdXHMqLFxzKlsnIl1bJyJdIjtpOjI4OTtzOjEzMjoiXCRbYS16QS1aMC05X10rXFswXF09cGFja1woWyciXUhcKlsnIl0sWyciXVthLXpBLVowLTlfXStbJyJdXCk7YXJyYXlfZmlsdGVyXChcJFthLXpBLVowLTlfXSsscGFja1woWyciXUhcKlsnIl0sWyciXVthLXpBLVowLTlfXStbJyJdIjtpOjI5MDtzOjYxOiJpZlxzKlwod2luZG93XC5wbHVzb1wpXHMqaWZccypcKHR5cGVvZlxzKndpbmRvd1wucGx1c29cLnN0YXJ0IjtpOjI5MTtzOjEzOiJldmFsXChcJHtcJHsiIjtpOjI5MjtzOjE4OiItLXZpc2l0b3JUcmFja2VyLS0iO2k6MjkzO3M6MTM6IjwlLS1TdUV4cC0tJT4iO2k6Mjk0O3M6NzM6IlwkX19hXHMqPVxzKnN0cl9yZXBsYWNlXCgiLiIsXHMqIi4iLFxzKlwkX18uXCk7XHMqXCRfXy5ccyo9XHMqc3RyX3JlcGxhY2UiO2k6Mjk1O3M6MzA6ImVjaG9ccypleGVjXChbJyJdd2hvYW1pWyciXVwpOyI7aToyOTY7czoxMjE6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdW2EtekEtWjAtOV9dK1wucGhwWyciXSxcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF0sRklMRV9BUFBFTkRcKTsiO2k6Mjk3O3M6NTg6IlwkZGlycGF0aFwuWyciXS9bJyJdXC5cJHZhbHVlXC5bJyJdL3dwLWNvbmZpZ1wucGhwWyciXVwpXC4iO2k6Mjk4O3M6NTQ6ImFycmF5X2RpZmZfdWtleVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyOTk7czo2NzoiXCRbYS16QS1aMC05X10rPWZpbGVfZ2V0X2NvbnRlbnRzXChbJyJdaHR0cDovL3d3d1wuYXNrXC5jb20vd2ViXD9xPSI7aTozMDA7czoyNjU6ImlmXCghZW1wdHlcKFxzKlwkX0ZJTEVTXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwpXCl7Y29weVwoXCRfRklMRVNcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdLFwkX0ZJTEVTXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwpO30iO2k6MzAxO3M6MjA3OiJyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblxzKlwoXHMqY3JlYXRlX2Z1bmN0aW9uXChccypAP1wke1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccyp9XHMqLFxzKkA/XCR7XHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccyp9e1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccyp9XHMqXClccypcKTsiO2k6MzAyO3M6Mjc1OiJAP2ZpbHRlcl92YXJccypcKEA/XHMqXCR7WyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl19e1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19XHMqLFxzKkZJTFRFUl9DQUxMQkFDS1xzKixccyphcnJheVxzKlwoXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqPT5ccypcJHtccypbJyJdXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXVxzKn17XHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKn1ccypcKVxzKlwpXHMqOyI7aTozMDM7czoyNDE6ImlmXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdIT1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXCl7ZXh0cmFjdFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcKTtccyp1c29ydFwoXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dK1wpO30iO2k6MzA0O3M6MjM4OiJkZWNsYXJlXChccyp0aWNrcz1cZCtccypcKVxzKjtAP3JlZ2lzdGVyX3RpY2tfZnVuY3Rpb25cKFxzKlwke1snIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdfVxzKntbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9fVxzKixcJHtbJyJdezAsMX1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdezAsMX19XHMqe1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19XCk7IjtpOjMwNTtzOjE0NzoiZGVmaW5lXChbYS16QS1aMC05X10rXHMqLFxzKlwkX1NFUlZFUlxbW2EtekEtWjAtOV9dK1xdXCk7XHMqQD9yZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblwoXHMqY3JlYXRlX2Z1bmN0aW9uXChcJFthLXpBLVowLTlfXSssW2EtekEtWjAtOV9dK1wpXHMqXCk7IjtpOjMwNjtzOjMwODoiXCR7WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX09QD9cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKTtAPyFcKEA/XCR7WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX1cW1xkK1xdJiZAP1wke0A/WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX1cW1xkK1xdXClcP1wke0A/WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX06QD9AP1wke1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19XFtcZCtcXVwoQD9cJHtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9fVxbXGQrXF1cKTsiO2k6MzA3O3M6ODc6InNldGNvb2tpZVwoWyciXVthLXpBLVowLTlfXStbJyJdXHMqLFxzKnNlcmlhbGl6ZVwoQD9cJF88R1BDPlxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKSI7aTozMDg7czoyNToiPC9kaXY+XHMqPCUtLVBvcnRTY2FuLS0lPiI7aTozMDk7czoxNDoiR0lGODkuLi48XD9waHAiO2k6MzEwO3M6MTc4OiJcJFthLXpBLVowLTlfXStccyo9XHMqZm9wZW5cKFsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdXHMqLFxzKlsnIl13XCs/WyciXVwpO1xzKmZwdXRzXChcJFthLXpBLVowLTlfXStccyosXHMqXCRbYS16QS1aMC05X10rXCk7XHMqZmNsb3NlXChcJFthLXpBLVowLTlfXStcKTtccyp1bmxpbmtcKF9fRklMRV9fXCk7IjtpOjMxMTtzOjM0OiJDcmVhdGVKb29tQ29kZVwoXCRbYS16QS1aMC05X10rXCk7IjtpOjMxMjtzOjIzOiJmdW5jdGlvblxzK0NyZWF0ZVdwQ29kZSI7aTozMTM7czozNzoiPGJyPlsnIl1cLnBocF91bmFtZVwoXClcLlsnIl08YnI+PC9iPiI7aTozMTQ7czo3MzoiaWZcKFwkW2EtekEtWjAtOV9dK1xzKj1ccypAP3N0cnBvc1woXCRbYS16QS1aMC05X10rLCJjaGVja19tZXRhXChcKTsiXClcKSI7aTozMTU7czo5NDoiaWZcKGlzc2V0XChcJF9HRVRcW1snIl1pbnN0YWxsWyciXVxdXClcKXtccypcJGRiLT5leGVjXChbJyJdQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYXJ0aWNsZSI7aTozMTY7czo2ODoiYXJyMmh0bWxcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdXHd7MSw0NX1bJyJdXF1cKTsiO2k6MzE3O3M6Mzk6ImZ1bmN0aW9uXHMrZ2V0X3RleHRfZnJfc2VydlwoXHMqXCR1cmxfcyI7aTozMTg7czo1MToiZnVuY3Rpb25ccytjdXJsX2dldF9mcm9tX3dlYnBhZ2Vfb25lX3RpbWVcKFxzKlwkdXJsIjtpOjMxOTtzOjQ3OiJcJGFydGljbGVcZCtccyo9XHMqZXhwbG9kZVwoIlwjXCNcIyIsXCRzdHJcZCtcKSI7aTozMjA7czo1MDoiZXZhbFxzKlwoP1xzKkA/XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzIxO3M6NTI6ImFzc2VydFxzKlwoP1xzKkA/XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzIyO3M6MTA2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCg/XHMqQD9cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbIjtpOjMyMztzOjE3NzoiPGI+ZXZhbFxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjMyNDtzOjcyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCg/XHMqWyciXXdnZXQiO2k6MzI1O3M6MjE6Ij09WyciXVwpXCk7cmV0dXJuO1w/PiI7aTozMjY7czo3OiJ1Z2djOi8vIjtpOjMyNztzOjEwMzoiXCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcXT1jaHJcKFwkW2EtekEtWjAtOV9dK1xbb3JkXChcJFthLXpBLVowLTlfXStcW1wkW2EtekEtWjAtOV9dK1xdXClcXVwpOyI7aTozMjg7czo0NjoiXCRbYS16QS1aMC05X10rXFtjaHJcKFxkK1wpXF1cKFthLXpBLVowLTlfXStcKCI7aTozMjk7czoxNDI6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXCkiO2k6MzMwO3M6MTA0OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1cJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIiI7aTozMzE7czo5NDoiXCRbYS16QS1aMC05X10rPWFycmF5XChbJyJdXCRbYS16QS1aMC05X10rXFtccypcXT1hcnJheV9wb3BcKFwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dKyI7aTozMzI7czoxMDc6IlwkW2EtekEtWjAtOV9dKz1wYWNrXChbJyJdSFwqWyciXSxzdWJzdHJcKFwkW2EtekEtWjAtOV9dKyxccyotXGQrXClcKTtccypyZXR1cm5ccytcJFthLXpBLVowLTlfXStcKHN1YnN0clwoIjtpOjMzMztzOjEzNjoiXCRbYS16QS1aMC05X10rXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwoXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcWyI7aTozMzQ7czoxNDU6IjwvZm9ybT5bJyJdO2lmXChpc3NldFwoXCRfUE9TVFxbWyciXVx3ezEsNDV9WyciXVxdXClcKXtpZlwoaXNfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcW1snIl1cd3sxLDQ1fVsnIl1cXVxbWyciXVx3ezEsNDV9WyciXVxdXClcKXtAY29weVwoXCRfRklMRVMiO2k6MzM1O3M6NDY6IlwuL2hvc3RccytlbmNyeXB0XHMrcHVibGlja2V5XC5wdWJccytbJyJdL2hvbWUiO2k6MzM2O3M6NDQ6IlwkcmVzX2VsXFtbJyJdbGlua1snIl1cXVwuWyciXS1cfFx8LWdvb2RbJyJdIjtpOjMzNztzOjM1OiI9XHMqZXhwbG9kZVwoWyciXV9cfFx8X1snIl0sXCRfUE9TVCI7aTozMzg7czoxMDI6IlwkY3VycmVudFxzKj1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHA6Ly8uKj9cJGlkWyciXVwpO1xzKmZpbGVfcHV0X2NvbnRlbnRzXChcJGlkLFxzKlwkY3VycmVudFwpOyI7aTozMzk7czo2NToiXCRkb21haW5ccyo9XHMqXCRkb21haW5zXFthcnJheV9yYW5kXChcJGRvbWFpbnMsXHMqMVwpXF07XHMqXCR1cmwiO2k6MzQwO3M6MTE1OiJcJFx3ezEsNDV9XHMqPVxzKlwkXHd7MSw0NX1cLlsnIl0vYXBpXC5waHBcP2FjdGlvbj1mdWxsdHh0JmNvbmZpZz1bJyJdXC5cJFx3ezEsNDV9XC5bJyJdJlx3ezEsNDV9PVsnIl1cLlwkXHd7MSw0NX07IjtpOjM0MTtzOjM1OiJcJF9QT1NUXFtbJyJdXHd7MSw0NX1bJyJdXF1cKTtAZXZhbCI7aTozNDI7czo2MzoiZnVuY3Rpb25ccypyczJodG1sXCgmXCRycyxcJHp0YWJodG1sPWZhbHNlLFwkemhlYWRlcmFycmF5PWZhbHNlIjtpOjM0MztzOjE1MDoiaWZcKGlzc2V0XChcJF9HRVRcW1snIl1wWyciXVxdXClcKVxzKntccypoZWFkZXJcKFsnIl1Db250ZW50LVR5cGU6XHMqdGV4dC9odG1sO2NoYXJzZXQ9d2luZG93cy0xMjUxWyciXVwpO1xzKlwkcGF0aD1cJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxdIjtpOjM0NDtzOjU2OiJzZXNzaW9uX3dyaXRlX2Nsb3NlXChcKTtccypMb2NhbFJlZGlyZWN0XChcJGRvd25sb2FkX2RpciI7aTozNDU7czo0NjoiR2V0VGhpc0lwXChcKTtccyppZlwoXCRhY3Rpb25ccyo9PVxzKiJmaWxlaW5mbyI7aTozNDY7czoxMjc6ImlmXHMqXChccypzXC5pbmRleE9mXChbJyJdZ29vZ2xlWyciXVwpXHMqPlxzKjBccypcfFx8XHMqc1wuaW5kZXhPZlwoWyciXWJpbmdbJyJdXClccyo+XHMqMFxzKlx8XHxccypzXC5pbmRleE9mXChbJyJdeWFob29bJyJdXCkiO2k6MzQ3O3M6Njk6IkBjaG1vZFwoWyciXVwuaHRhY2Nlc3NbJyJdLFxkK1wpO1xzKkBjaG1vZFwoWyciXWluZGV4XC5waHBbJyJdLFxkK1wpOyI7aTozNDg7czozNjoicGluZ1xzKy1jXHMrWyciXVxzKlwuXHMqXCRwaW5nX2NvdW50IjtpOjM0OTtzOjE3OiJBbnRpY2hhdFxzK1NvY2tzNSI7aTozNTA7czoyNzoiZnVuY3Rpb25ccytCcmlkZ2VFc3RhYmxpc2gyIjtpOjM1MTtzOjMxOiJmdW5jdGlvblxzKl9fb2JmdXNjYXRlX3JlZGlyZWN0IjtpOjM1MjtzOjQyOiJcJF9QT1NUXFtccypbJyJdcHdkWyciXVxdPVsnIl1XZWFrXHMrTGl2ZXIiO2k6MzUzO3M6NjE6IlxbQklUUklYXF1ccypcW1dvcmRQcmVzc1xdXHMqXFtvc0NvbW1lcmNlXF1ccypcW0pvb21sYVxdPC9oMz4iO2k6MzU0O3M6MTk6Ijx0aXRsZT5ccypLYXp1eWE0MDQiO2k6MzU1O3M6NzE6ImlmIFwoQFwkYXJyYXlcW1xkK1xdID09IFxkK1wpXHMqe1xzKmhlYWRlclxzKlwoXHMqWyciXUxvY2F0aW9uOlxzKlwkdXJsIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo1MTg6e2k6MDtzOjE0OiJCT1RORVRccytQQU5FTCI7aToxO3M6MTg6Ij09XHMqWyciXTQ2XC4yMjlcLiI7aToyO3M6MTg6Ij09XHMqWyciXTkxXC4yNDNcLiI7aTozO3M6NToiSlRlcm0iO2k6NDtzOjU6Ik9uZXQ3IjtpOjU7czo5OiJcJHBhc3NfdXAiO2k6NjtzOjU6InhDZWR6IjtpOjc7czoxMTY6ImlmXHMqXChccypmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKVxzKlwpIjtpOjg7czoyNzoiXCRPT08uKz89XHMqdXJsZGVjb2RlXHMqXCg/IjtpOjk7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6MTA7czoxNToicGNudGxfZXhlY1xzKlwoIjtpOjExO3M6MzE6Ij1ccyphcnJheV9tYXBccypcKD9ccypzdHJyZXZccyoiO2k6MTI7czozMjoic3RyX2lyZXBsYWNlXHMqXCg/XHMqWyciXTwvaGVhZD4iO2k6MTM7czoyMzoiY29weVxzKlwoXHMqWyciXWh0dHA6Ly8iO2k6MTQ7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoP1xzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6MTU7czoyODoiZWNob1xzKlwoP1xzKlsnIl1OTyBGSUxFWyciXSI7aToxNjtzOjE1OiJbJyJdL1wuXCovZVsnIl0iO2k6MTc7czo2NDoiZWNob1xzK3N0cmlwc2xhc2hlc1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxODtzOjE1OiIvdXNyL3NiaW4vaHR0cGQiO2k6MTk7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aToyMDtzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6MjE7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6MjI7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aToyMztzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aToyNDtzOjgzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbWyciXXRtcF9uYW1lWyciXVxdXHMqLCI7aToyNTtzOjgxOiJtYWlsXChcJF9QT1NUXFtbJyJdezAsMX1lbWFpbFsnIl17MCwxfVxdLFxzKlwkX1BPU1RcW1snIl17MCwxfXN1YmplY3RbJyJdezAsMX1cXSwiO2k6MjY7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6Mjc7czo2MzoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXStccypcXVwoIjtpOjI4O3M6MTk6IlsnIl0vXGQrL1xbYS16XF1cKmUiO2k6Mjk7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6MzA7czo1NjoiQD9maWxlX3B1dF9jb250ZW50c1woXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzE7czo5MToibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChcJHRvXClccyosXHMqc3RyaXBzbGFzaGVzXChcJHN1YmplY3RcKVxzKixccypzdHJpcHNsYXNoZXNcKFwkbWVzc2FnZSI7aTozMjtzOjYzOiJcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXCgiO2k6MzM7czoyMzoiaXNfd3JpdGFibGU9aXNfd3JpdGFibGUiO2k6MzQ7czozODoiQG1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCR1c2VyZmlsZV90bXAiO2k6MzU7czoyNjoiZXhpdFwoXCk6ZXhpdFwoXCk6ZXhpdFwoXCkiO2k6MzY7czo2NzoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqWyciXS92YXIvdG1wLyI7aTozNztzOjE3OiI9XHMqWyciXS92YXIvdG1wLyI7aTozODtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTozOTtzOjgzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTo0MDtzOjEwMToic3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2UiO2k6NDE7czozNjoiL2FkbWluL2NvbmZpZ3VyYXRpb25cLnBocC9sb2dpblwucGhwIjtpOjQyO3M6NzE6InNlbGVjdFxzKmNvbmZpZ3VyYXRpb25faWQsXHMrY29uZmlndXJhdGlvbl90aXRsZSxccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjQzO3M6NTA6InVwZGF0ZVxzKmNvbmZpZ3VyYXRpb25ccytzZXRccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjQ0O3M6Mzc6InNlbGVjdFxzKmxhbmd1YWdlc19pZCxccytuYW1lLFxzK2NvZGUiO2k6NDU7czo1MjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlxcWyciXVxcWyciXTt9aWZcKCFnZXRDb29raWVcKCI7aTo0NjtzOjQ1OiJpZlwoZmlsZV9wdXRfY29udGVudHNcKFwkaW5kZXhfcGF0aCxccypcJGNvZGUiO2k6NDc7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjQ4O3M6NTA6IjxpZnJhbWVccytzcmM9WyciXWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vZm9ybXMvIjtpOjQ5O3M6MjI6IixbJyJdPFw/cGhwXFxuWyciXVwuXCQiO2k6NTA7czo3MjoiPFw/cGhwXHMrXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjUxO3M6MjI6InhydW1lcl9zcGFtX2xpbmtzXC50eHQiO2k6NTI7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjUzO3M6Nzc6ImFycmF5X21lcmdlXChcJGV4dFxzKixccyphcnJheVwoWyciXXdlYnN0YXRbJyJdLFsnIl1hd3N0YXRzWyciXSxbJyJddGVtcG9yYXJ5IjtpOjU0O3M6OTI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjU1O3M6Mjg6Ik1vdGhlclsnIl1zXHMrTWFpZGVuXHMrTmFtZToiO2k6NTY7czozOToibG9jYXRpb25cLnJlcGxhY2VcKFxcWyciXVwkdXJsX3JlZGlyZWN0IjtpOjU3O3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aTo1ODtzOjg1OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jdXJsXHMrLU9ccytodHRwOi8vIjtpOjU5O3M6Mjk6IlwpXCksUEhQX1ZFUlNJT04sbWQ1X2ZpbGVcKFwkIjtpOjYwO3M6MzQ6IlwkcXVlcnlccyssXHMrWyciXWZyb20lMjBqb3NfdXNlcnMiO2k6NjE7czoxNToiZXZhbFwoWyciXVxzKi8vIjtpOjYyO3M6MTY6ImV2YWxcKFsnIl1ccyovXCoiO2k6NjM7czoxMDQ6IlwkW2EtekEtWjAtOV9dK1xzKj1cJFthLXpBLVowLTlfXStccypcKFwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccypcKFsnIl1ccyp7XCRbYS16QS1aMC05X10rIjtpOjY0O3M6MzE6IiFlcmVnXChbJyJdXF5cKHVuc2FmZV9yYXdcKVw/XCQiO2k6NjU7czozNToiXCRiYXNlX2RvbWFpblxzKj1ccypnZXRfYmFzZV9kb21haW4iO2k6NjY7czo5OiJzZXhzZXhzZXgiO2k6Njc7czoyMzoiXCt1bmlvblwrc2VsZWN0XCswLDAsMCwiO2k6Njg7czozNzoiY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSx1c2VybmFtZSI7aTo2OTtzOjM0OiJncm91cF9jb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhIjtpOjcwO3M6NTc6IlwqL1xzKlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aTo3MTtzOjg6ImFiYWtvL0FPIjtpOjcyO3M6NDg6ImlmXChccypzdHJwb3NcKFxzKlwkdmFsdWVccyosXHMqXCRtYXNrXHMqXClccypcKSI7aTo3MztzOjEwNjoidW5saW5rXChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXXswLDF9L2Fzc2V0cy9jYWNoZS90ZW1wL0ZpbGVTZXR0aW5ncyI7aTo3NDtzOjM4OiJzZXRUaW1lb3V0XChccypbJyJdbG9jYXRpb25cLnJlcGxhY2VcKCI7aTo3NTtzOjQzOiJzdHJwb3NcKFwkaW1ccyosXHMqWyciXTxcP1snIl1ccyosXHMqXCRpXCsxIjtpOjc2O3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjc3O3M6MjM6IjBccypcKFxzKmd6dW5jb21wcmVzc1woIjtpOjc4O3M6MTU6Imd6aW5mbGF0ZVwoXChcKCI7aTo3OTtzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6ODA7czoyNzoic3RybGVuXChccypcJHBhdGhUb0RvclxzKlwpIjtpOjgxO3M6NjQ6Imlzc2V0XChccypcJF9DT09LSUVcW1xzKm1kNVwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX0hPU1QiO2k6ODI7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjgzO3M6ODQ6Ii9pbmRleFwucGhwXD9vcHRpb249Y29tX2NvbnRlbnQmdmlldz1hcnRpY2xlJmlkPVsnIl1cLlwkcG9zdFxbWyciXXswLDF9aWRbJyJdezAsMX1cXSI7aTo4NDtzOjU1OiJcJG91dFxzKlwuPVxzKlwkdGV4dHtccypcJGlccyp9XHMqXF5ccypcJGtleXtccypcJGpccyp9IjtpOjg1O3M6OToiTDNaaGNpOTNkIjtpOjg2O3M6NDc6InN0cnRvbG93ZXJcKFxzKnN1YnN0clwoXHMqXCR1c2VyX2FnZW50XHMqLFxzKjAsIjtpOjg3O3M6NDQ6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9cd10rP1xzKixccyowNDA0IjtpOjg4O3M6NDQ6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9cd10rP1xzKixccyowNzU1IjtpOjg5O3M6NDI6IkB1bWFza1woXHMqMDc3N1xzKiZccyp+XHMqXCRmaWxlcGVybWlzc2lvbiI7aTo5MDtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aTo5MTtzOjE2OiI7XHMqL2Jpbi9zaFxzKi1pIjtpOjkyO3M6NDE6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjkzO3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjk0O3M6MTU6Ii90bXAvdG1wLXNlcnZlciI7aTo5NTtzOjE1OiIvdG1wL1wuSUNFLXVuaXgiO2k6OTY7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6OTc7czoyNzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzIjtpOjk4O3M6MzM6InRvdWNoXHMqXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aTo5OTtzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjEwMDtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MTAxO3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjEwMjtzOjc0OiJcJHJldCA9IFwkdGhpcy0+X2RiLT51cGRhdGVPYmplY3RcKCBcJHRoaXMtPl90YmwsIFwkdGhpcywgXCR0aGlzLT5fdGJsX2tleSI7aToxMDM7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToxMDQ7czo1NDoic3Vic3RyXChccypcJHJlc3BvbnNlXHMqLFxzKlwkaW5mb1xbXHMqWyciXWhlYWRlcl9zaXplIjtpOjEwNTtzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjEwNjtzOjUwOiI8aW5wdXRccyt0eXBlPXN1Ym1pdFxzK3ZhbHVlPVVwbG9hZFxzKi8+XHMqPC9mb3JtPiI7aToxMDc7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToxMDg7czo1NzoiQGVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKmlmXHMqXChccyohaXNzZXRccypcKFxzKlwkIjtpOjEwOTtzOjMwOiJlbHNlXHMqe1xzKmVjaG9ccypbJyJdZmFpbFsnIl0iO2k6MTEwO3M6NTE6InR5cGU9WyciXXN1Ym1pdFsnIl1ccyp2YWx1ZT1bJyJdVXBsb2FkIGZpbGVbJyJdXHMqPiI7aToxMTE7czozNzoiaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqXCRsaW5rWyciXSI7aToxMTI7czozMToiZWNob1xzKlsnIl08Yj5VcGxvYWQ8c3M+U3VjY2VzcyI7aToxMTM7czo0MzoibmFtZT1bJyJddXBsb2FkZXJbJyJdXHMraWQ9WyciXXVwbG9hZGVyWyciXSI7aToxMTQ7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjExNTtzOjI0OiJ1bmxpbmtcKFxzKl9fRklMRV9fXHMqXCkiO2k6MTE2O3M6NTY6Im1haWxcKFxzKlwkYXJyXFtbJyJddG9bJyJdXF1ccyosXHMqXCRhcnJcW1snIl1zdWJqWyciXVxdIjtpOjExNztzOjEyNzoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKlwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdO1xzKmV4aXRcKFwpOyI7aToxMTg7czoxMzoibnVsbF9leHBsb2l0cyI7aToxMTk7czo0NjoiPFw/XHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKSI7aToxMjA7czo5OiJ0bXZhc3luZ3IiO2k6MTIxO3M6MTI6InRtaGFwYnpjZXJmZiI7aToxMjI7czoxMzoib25mcjY0X3FycGJxciI7aToxMjM7czoxNDoiWyciXW5mZnJlZ1snIl0iO2k6MTI0O3M6OToiZmdlX2ViZzEzIjtpOjEyNTtzOjc6ImN1Y3Zhc2IiO2k6MTI2O3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjEyNztzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTI4O3M6OToiZXRhbGZuaXpnIjtpOjEyOTtzOjEyOiJzc2VycG1vY251emciO2k6MTMwO3M6MTM6ImVkb2NlZF80NmVzYWIiO2k6MTMxO3M6MTQ6IlsnIl10cmVzc2FbJyJdIjtpOjEzMjtzOjE3OiJbJyJdMzF0b3JfcnRzWyciXSI7aToxMzM7czoxNToiWyciXW9mbmlwaHBbJyJdIjtpOjEzNDtzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToxMzU7czoxMjoiWyciXXJpbnlbJyJdIjtpOjEzNjtzOjQyOiJAXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKTsiO2k6MTM3O3M6NDg6InBhcnNlX3F1ZXJ5X3N0cmluZ1woXHMqXCRFTlZ7XHMqWyciXVFVRVJZX1NUUklORyI7aToxMzg7czozMToiZXZhbFxzKlwoXHMqbWJfY29udmVydF9lbmNvZGluZyI7aToxMzk7czoyNDoiXClccyp7XHMqcGFzc3RocnVcKFxzKlwkIjtpOjE0MDtzOjE1OiJIVFRQX0FDQ0VQVF9BU0UiO2k6MTQxO3M6MjE6ImZ1bmN0aW9uXHMqQ3VybEF0dGFjayI7aToxNDI7czoxODoiQHN5c3RlbVwoXHMqWyciXVwkIjtpOjE0MztzOjIzOiJlY2hvXChccypodG1sXChccyphcnJheSI7aToxNDQ7czo1NjoiXCRjb2RlPVsnIl0lMXNjcmlwdFxzKnR5cGU9XFxbJyJddGV4dC9qYXZhc2NyaXB0XFxbJyJdJTMiO2k6MTQ1O3M6MjI6ImFycmF5XChccypbJyJdJTFodG1sJTMiO2k6MTQ2O3M6MTk6ImJ1ZGFrXHMqLVxzKmV4cGxvaXQiO2k6MTQ3O3M6OTE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKFxzKlsnIl1cJFthLXpBLVowLTlfXStbJyJdXHMqXCkiO2k6MTQ4O3M6OToiR0FHQUw8L2I+IjtpOjE0OTtzOjM4OiJleGl0XChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToxNTA7czozNzoiZGllXChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToxNTE7czozNjoic2V0X3RpbWVfbGltaXRcKFxzKmludHZhbFwoXHMqXCRhcmd2IjtpOjE1MjtzOjMzOiJlY2hvXHMqXCRwcmV3dWVcLlwkbG9nXC5cJHBvc3R3dWUiO2k6MTUzO3M6NDI6ImNvbm5ccyo9XHMqaHR0cGxpYlwuSFRUUENvbm5lY3Rpb25cKFxzKnVyaSI7aToxNTQ7czozNjoiaWZccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfWNobW9kNzc3IjtpOjE1NTtzOjI2OiI8XD9ccyplY2hvXHMqXCRjb250ZW50O1w/PiI7aToxNTY7czo4NDoiXCR1cmxccypcLj1ccypbJyJdXD9bYS16QS1aMC05X10rPVsnIl1ccypcLlxzKlwkX0dFVFxbXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqXF07IjtpOjE1NztzOjEwODoiY29weVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9QT1NUIjtpOjE1ODtzOjExNToibW92ZV91cGxvYWRlZF9maWxlXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKlxdXFtbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxdXFtccypcJGlccypcXSI7aToxNTk7czozMjoiZG5zX2dldF9yZWNvcmRcKFxzKlwkZG9tYWluXHMqXC4iO2k6MTYwO3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MTYxO3M6MjQ6Im5zbG9va3VwXC5leGVccyotdHlwZT1NWCI7aToxNjI7czoxMjoibmV3XHMqTUN1cmw7IjtpOjE2MztzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToxNjQ7czo0MDoiZnB1dHNcKFwkZnAsXHMqWyciXUlQOlxzKlwkaXBccyotXHMqREFURSI7aToxNjU7czoyODoiY2htb2RcKFxzKl9fRElSX19ccyosXHMqMDQwMCI7aToxNjY7czo0MDoiQ29kZU1pcnJvclwuZGVmaW5lTUlNRVwoXHMqWyciXXRleHQvbWlyYyI7aToxNjc7czo0MzoiXF1ccypcKVxzKlwuXHMqWyciXVxcblw/PlsnIl1ccypcKVxzKlwpXHMqeyI7aToxNjg7czo2NzoiXCRnenBccyo9XHMqXCRiZ3pFeGlzdFxzKlw/XHMqQGd6b3BlblwoXCR0bXBmaWxlLFxzKlsnIl1yYlsnIl1ccypcKSI7aToxNjk7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjE3MDtzOjY0OiJcJF9QT1NUXFtbJyJdezAsMX1hY3Rpb25bJyJdezAsMX1cXVxzKj09XHMqWyciXWdldF9hbGxfbGlua3NbJyJdIjtpOjE3MTtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToxNzI7czo0MToiY2htb2RcKFwkZmlsZS0+Z2V0UGF0aG5hbWVcKFwpXHMqLFxzKjA3NzciO2k6MTczO3M6NjM6IlwkX1BPU1RcW1snIl17MCwxfXRwMlsnIl17MCwxfVxdXHMqXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToxNzQ7czoxMDk6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcKTtccypleGl0XChccypcKTsiO2k6MTc1O3M6MzE6Ij0+XHMqQFwkZjJcKF9fRklMRV9fXHMqLFxzKlwkZjEiO2k6MTc2O3M6ODE6ImV2YWxcKFxzKlthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpO1xzKlw/PiI7aToxNzc7czozNzoiaWZccypcKFxzKmlzX2NyYXdsZXIxXChccypcKVxzKlwpXHMqeyI7aToxNzg7czo0ODoiXCRlY2hvXzFcLlwkZWNob18yXC5cJGVjaG9fM1wuXCRlY2hvXzRcLlwkZWNob181IjtpOjE3OTtzOjM1OiJmaWxlX2dldF9jb250ZW50c1woXHMqX19GSUxFX19ccypcKSI7aToxODA7czo4MzoiQFxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKkB1cmxlbmNvZGVcKFxzKlwkX1BPU1QiO2k6MTgxO3M6OTU6IlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cW1xkK1xdXChyb3VuZFwoXGQrXClcKVxdIjtpOjE4MjtzOjI1OiJmdW5jdGlvblxzK2Vycm9yXzQwNFwoXCl7IjtpOjE4MztzOjY4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcGVybCI7aToxODQ7czo3MDoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXXB5dGhvbiI7aToxODU7czo3MzoiaWZccypcKGlzc2V0XChcJF9HRVRcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClcKVxzKntccyplY2hvXHMqWyciXW9rWyciXSI7aToxODY7czozOToicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfR0VUXFtccypbJyJdY3B5IjtpOjE4NztzOjQ1OiJodHRwOi8vLis/Ly4rP1wucGhwXD9hPVxkKyZjPVthLXpBLVowLTlfXSsmcz0iO2k6MTg4O3M6MTY6ImZ1bmN0aW9uXHMrd3NvRXgiO2k6MTg5O3M6NTE6ImZvcmVhY2hcKFxzKlwkdG9zXHMqYXNccypcJHRvXClccyp7XHMqbWFpbFwoXHMqXCR0byI7aToxOTA7czoxMDI6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChbJyJdaHR0cDovLy4rP1wuanBnWyciXVwpO1xzKmV4aXRcKFwpOyI7aToxOTE7czoxMjoiPFw/PVwkY2xhc3M7IjtpOjE5MjtzOjUwOiI8aW5wdXRccyp0eXBlPSJmaWxlIlxzKnNpemU9IlxkKyJccypuYW1lPSJ1cGxvYWQiPiI7aToxOTM7czoxMTA6IlwkbWVzc2FnZXNcW1xdXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX11c2VyZmlsZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF1cW1xzKlwkaVxzKlxdIjtpOjE5NDtzOjU1OiI8aW5wdXRccyp0eXBlPVsnIl1maWxlWyciXVxzKm5hbWU9WyciXXVzZXJmaWxlWyciXVxzKi8+IjtpOjE5NTtzOjEzOiJEZXZhcnRccytIVFRQIjtpOjE5NjtzOjg3OiJAXCR7XHMqW2EtekEtWjAtOV9dK1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXStccyp9XChccypcJFthLXpBLVowLTlfXSsiO2k6MTk3O3M6OTI6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXStcW1xzKlwkW2EtekEtWjAtOV9dK1xdIjtpOjE5ODtzOjUzOiJlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccypcJHVybFxzKj1ccypbJyJdaHR0cDovLyI7aToxOTk7czoxMjA6IlwkW2EtekEtWjAtOV9dKz1bJyJdaHR0cDovLy4rP1snIl07XHMqXCRbYS16QS1aMC05X10rPWZvcGVuXChcJFthLXpBLVowLTlfXSssWyciXXJbJyJdXCk7XHMqcmVhZGZpbGVcKFwkW2EtekEtWjAtOV9dK1wpOyI7aToyMDA7czo3NToiYXJyYXlcKFxzKlsnIl08IS0tWyciXVxzKlwuXHMqbWQ1XChccypcJHJlcXVlc3RfdXJsXHMqXC5ccypyYW5kXChcZCssXHMqXGQrIjtpOjIwMTtzOjE0OiJ3c29IZWFkZXJccypcKCI7aToyMDI7czo2OToiZWNob1woWyciXTxmb3JtIG1ldGhvZD1bJyJdcG9zdFsnIl1ccyplbmN0eXBlPVsnIl1tdWx0aXBhcnQvZm9ybS1kYXRhIjtpOjIwMztzOjQzOiJmaWxlX2dldF9jb250ZW50c1woXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRfIjtpOjIwNDtzOjU4OiJyZWxwYXRodG9hYnNwYXRoXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjIwNTtzOjQwOiJtYWlsXChcJHRvXHMqLFxzKlsnIl0uKz9bJyJdXHMqLFxzKlwkdXJsIjtpOjIwNjtzOjUxOiJpZlxzKlwoXHMqIWZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXN5c19nZXRfdGVtcF9kaXIiO2k6MjA3O3M6MTc6Ijx0aXRsZT5ccypWYVJWYVJhIjtpOjIwODtzOjM4OiJlbHNlaWZcKFxzKlwkc3FsdHlwZVxzKj09XHMqWyciXXNxbGl0ZSI7aToyMDk7czoxOToiPVsnIl1cKVxzKlwpO1xzKlw/PiI7aToyMTA7czoyNDoiZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkIjtpOjIxMTtzOjUwOiJcI1thLXpBLVowLTlfXStcIy4rPzwvc2NyaXB0Pi4rP1wjL1thLXpBLVowLTlfXStcIyI7aToyMTI7czozNDoiZnVuY3Rpb25ccytfX2ZpbGVfZ2V0X3VybF9jb250ZW50cyI7aToyMTM7czo1NDoiXCRmXHMqPVxzKlwkZlxkK1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rIjtpOjIxNDtzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToyMTU7czoyOToiQ1VSTE9QVF9VUkxccyosXHMqWyciXXNtdHA6Ly8iO2k6MjE2O3M6Nzc6IjxoZWFkPlxzKjxzY3JpcHQ+XHMqd2luZG93XC50b3BcLmxvY2F0aW9uXC5ocmVmPVsnIl0uKz9ccyo8L3NjcmlwdD5ccyo8L2hlYWQ+IjtpOjIxNztzOjcwOiJcJFthLXpBLVowLTlfXStccyo9XHMqZm9wZW5cKFxzKlsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdXHMqLFxzKlsnIl13IjtpOjIxODtzOjE2OiJAYXNzZXJ0XChccypbJyJdIjtpOjIxOTtzOjgyOiJcJFthLXpBLVowLTlfXSs9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1kb1snIl1ccypcXTtccyppbmNsdWRlIjtpOjIyMDtzOjc3OiJlY2hvXHMrXCRbYS16QS1aMC05X10rO21rZGlyXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcKTtmaWxlX3B1dF9jb250ZW50cyI7aToyMjE7czo2MToiXCRmcm9tXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZnJvbSI7aToyMjI7czoxOToiPVxzKnhkaXJcKFxzKlwkcGF0aCI7aToyMjM7czozMDoiXCRfW2EtekEtWjAtOV9dK1woXHMqXCk7XHMqXD8+IjtpOjIyNDtzOjEwOiJ0YXJccystemNDIjtpOjIyNTtzOjgzOiJlY2hvXHMrc3RyX3JlcGxhY2VcKFxzKlsnIl1cW1BIUF9TRUxGXF1bJyJdXHMqLFxzKmJhc2VuYW1lXChcJF9TRVJWRVJcW1snIl1QSFBfU0VMRiI7aToyMjY7czo0MDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkW2EtekEtWjAtOV9dKyI7aToyMjc7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aToyMjg7czozNToiaHJlZj1bJyJdPFw/cGhwXHMrZWNob1xzK1wkY3VyX3BhdGgiO2k6MjI5O3M6MzM6Ij1ccyplc2NfdXJsXChccypzaXRlX3VybFwoXHMqWyciXSI7aToyMzA7czo4NToiXlxzKjxcP3BocFxzKmhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlsnIl1ccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToyMzE7czoxNDoiPHRpdGxlPlxzKml2bnoiO2k6MjMyO3M6NjM6Il5ccyo8XD9waHBccypoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToyMzM7czo2MToiZ2V0X3VzZXJzXChccyphcnJheVwoXHMqWyciXXJvbGVbJyJdXHMqPT5ccypbJyJdYWRtaW5pc3RyYXRvciI7aToyMzQ7czo2NToiXCR0b1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXRvX2FkZHJlc3MiO2k6MjM1O3M6MTk6ImltYXBfaGVhZGVyaW5mb1woXCQiO2k6MjM2O3M6MzQ6ImV2YWxcKFxzKlsnIl1cPz5bJyJdXHMqXC5ccypqb2luXCgiO2k6MjM3O3M6MzU6ImJlZ2luXHMrbW9kOlxzK1RoYW5rc1xzK2ZvclxzK3Bvc3RzIjtpOjIzODtzOjMxOiJbJyJdXHMqXF5ccypcJFthLXpBLVowLTlfXStccyo7IjtpOjIzOTtzOjY1OiJcJFthLXpBLVowLTlfXStccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlxeXHMqXCRbYS16QS1aMC05X10rXHMqOyI7aToyNDA7czoxMjA6ImlmXChpc3NldFwoXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKVxzKj09XHMqWyciXSI7aToyNDE7czoxMjoiXC53d3cvLzpwdHRoIjtpOjI0MjtzOjYzOiIlNjMlNzIlNjklNzAlNzQlMkUlNzMlNzIlNjMlM0QlMjclNjglNzQlNzQlNzAlM0ElMkYlMkYlNzMlNkYlNjEiO2k6MjQzO3M6Mjc6IndwLW9wdGlvbnNcLnBocFxzKj5ccypFcnJvciI7aToyNDQ7czo4OToic3RyX3JlcGxhY2VcKGFycmF5XChbJyJdZmlsdGVyU3RhcnRbJyJdLFsnIl1maWx0ZXJFbmRbJyJdXCksXHMqYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCoiO2k6MjQ1O3M6Mzc6ImZpbGVfZ2V0X2NvbnRlbnRzXChfX0ZJTEVfX1wpLFwkbWF0Y2giO2k6MjQ2O3M6MzA6InRvdWNoXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aToyNDc7czoyMToiXHxib3RcfHNwaWRlclx8d2dldC9pIjtpOjI0ODtzOjYyOiJzdHJfcmVwbGFjZVwoWyciXTwvYm9keT5bJyJdLFthLXpBLVowLTlfXStcLlsnIl08L2JvZHk+WyciXSxcJCI7aToyNDk7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aToyNTA7czo5MDoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXStccypcKVxzKixccypzdHJpcHNsYXNoZXNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpIjtpOjI1MTtzOjIwODoiPVxzKm1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKVxzKixccypzdHJpcHNsYXNoZXNcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyNTI7czoxNTM6Ij1ccyptYWlsXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXHMqLFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyNTM7czoxNDoiTGliWG1sMklzQnVnZ3kiO2k6MjU0O3M6OToibWFhZlxzK3lhIjtpOjI1NTtzOjM0OiJlY2hvIFthLXpBLVowLTlfXStccypcKFsnIl1odHRwOi8vIjtpOjI1NjtzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6MjU3O3M6MTI6ImBjaGVja3N1ZXhlYyI7aToyNTg7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjI1OTtzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6MjYwO3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aToyNjE7czozNzoiPVxzKlsnIl1waHBfdmFsdWVccythdXRvX3ByZXBlbmRfZmlsZSI7aToyNjI7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MjYzO3M6NDY6ImZvcGVuXChccypcJFthLXpBLVowLTlfXStccypcLlxzKlsnIl0vd3AtYWRtaW4iO2k6MjY0O3M6MjI6InJldHVyblxzKlsnIl0vdmFyL3d3dy8iO2k6MjY1O3M6MjA6IlsnIl07XCRcd3sxLDQ1fTtbJyJdIjtpOjI2NjtzOjE0MToiY2FsbF91c2VyX2Z1bmNfYXJyYXlcKFxzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKixccyphcnJheVwoXHMqWyciXS4qP1snIl1ccyosXHMqZ2V0ZW52XChccypbJyJdLio/WyciXVxzKlwpXHMqLFxzKlsnIl0uKj9bJyJdXHMqXClccypcKTtccyp9IjtpOjI2NztzOjExNDoiXCRbYS16QS1aMC05X10rXHMqPVxzKmNoclwoXGQrXHMqXF5ccypcZCtcKVwuY2hyXChcZCtccypcXlxzKlxkK1wpXC5jaHJcKFxkK1xzKlxeXHMqXGQrXClcLmNoclwoXGQrXHMqXF5ccypcZCtcKVwuIjtpOjI2ODtzOjM2OiI8c2NyaXB0XHMrc3JjPVsnIl0vXD9cJFNFUlZFUl9JUD1cZCsiO2k6MjY5O3M6MTg2OiJcJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC4iO2k6MjcwO3M6MTY6InRhZ3MvXCQ2L1wkNC9cJDciO2k6MjcxO3M6MzA6InN0cl9yZXBsYWNlXChccypbJyJdXC5odGFjY2VzcyI7aToyNzI7czo0MzoiZnVuY3Rpb25ccytfXGQrXChccypcJFthLXpBLVowLTlfXStccypcKXtcJCI7aToyNzM7czoyMToiZXhwbG9kZVwoXFxbJyJdO3RleHQ7IjtpOjI3NDtzOjEyMzoic3Vic3RyXChccypcJFthLXpBLVowLTlfXStccyosXHMqXGQrXHMqLFxzKlxkK1xzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypwcmVnX3JlcGxhY2VcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypzdHJ0clwoIjtpOjI3NTtzOjY2OiJhcnJheV9mbGlwXChccyphcnJheV9tZXJnZVwoXHMqcmFuZ2VcKFxzKlsnIl1BWyciXVxzKixccypbJyJdWlsnIl0iO2k6Mjc2O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vXC5odGFjY2VzcyI7aToyNzc7czozMToiXCRpbnNlcnRfY29kZVxzKj1ccypbJyJdPGlmcmFtZSI7aToyNzg7czo0MToiYXNzZXJ0X29wdGlvbnNcKFxzKkFTU0VSVF9XQVJOSU5HXHMqLFxzKjAiO2k6Mjc5O3M6MTU6Ik11c3RAZkBccytTaGVsbCI7aToyODA7czo2NDoiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dKyI7aToyODE7czozNDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdcGNudGxfZm9yayI7aToyODI7czo0MDoic3RyX3JlcGxhY2VcKFsnIl1cLmh0YWNjZXNzWyciXVxzKixccypcJCI7aToyODM7czozMzoiPVxzKkA/Z3ppbmZsYXRlXChccypzdHJyZXZcKFxzKlwkIjtpOjI4NDtzOjIyOiJnXChccypbJyJdRmlsZXNNYW5bJyJdIjtpOjI4NTtzOjI4OiJzdHJfcmVwbGFjZVwoWyciXS9cP2FuZHJbJyJdIjtpOjI4NjtzOjIwNDoiXCRbYS16QS1aMC05X10rXHMqPVxzKlwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXTtccypcJFthLXpBLVowLTlfXStccyo9XHMqYXJyYXlcKFxzKlwkX1JFUVVFU1RcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccyphcnJheV9maWx0ZXJcKFxzKlwkIjtpOjI4NztzOjEyODoiXCRbYS16QS1aMC05X10rXHMqXC49XHMqXCRbYS16QS1aMC05X10re1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dK3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSt7XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10re1xkK30iO2k6Mjg4O3M6NzQ6InN0cnBvc1woXCRsLFsnIl1Mb2NhdGlvblsnIl1cKSE9PWZhbHNlXHxcfHN0cnBvc1woXCRsLFsnIl1TZXQtQ29va2llWyciXVwpIjtpOjI4OTtzOjk3OiJhZG1pbi9bJyJdLFsnIl1hZG1pbmlzdHJhdG9yL1snIl0sWyciXWFkbWluMS9bJyJdLFsnIl1hZG1pbjIvWyciXSxbJyJdYWRtaW4zL1snIl0sWyciXWFkbWluNC9bJyJdIjtpOjI5MDtzOjE1OiJbJyJdY2hlY2tzdWV4ZWMiO2k6MjkxO3M6NTU6ImlmXHMqXChccypcJHRoaXMtPml0ZW0tPmhpdHNccyo+PVsnIl1cZCtbJyJdXClccyp7XHMqXCQiO2k6MjkyO3M6NDc6ImV4cGxvZGVcKFsnIl1cXG5bJyJdLFxzKlwkX1BPU1RcW1snIl11cmxzWyciXVxdIjtpOjI5MztzOjExNDoiaWZcKGluaV9nZXRcKFsnIl1hbGxvd191cmxfZm9wZW5bJyJdXClccyo9PVxzKjFcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqZmlsZV9nZXRfY29udGVudHNcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjI5NDtzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6Mjk1O3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjI5NjtzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6Mjk3O3M6MjE6ImluY2x1ZGVcKFxzKlsnIl0vdG1wLyI7aToyOTg7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aToyOTk7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjMwMDtzOjEwOiJkZWtjYWhbJyJdIjtpOjMwMTtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTozMDI7czoxMzoiPT1bJyJdXClccypcLiI7aTozMDM7czoxMDM6ImlmXHMqXChccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypzdHJycG9zXChcJFthLXpBLVowLTlfXStccyosXHMqWyciXVw/PlsnIl1ccypcKVxzKlwpXHMqPT09XHMqZmFsc2UiO2k6MzA0O3M6MTUzOiJcJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKywiO2k6MzA1O3M6MzA6ImZvcGVuXHMqXChccypbJyJdYmFkX2xpc3RcLnR4dCI7aTozMDY7czo0OToiQD9maWxlX2dldF9jb250ZW50c1woQD9iYXNlNjRfZGVjb2RlXChAP3VybGRlY29kZSI7aTozMDc7czoyNToiXCR7W2EtekEtWjAtOV9dK31cKFxzKlwpOyI7aTozMDg7czo2MDoic3Vic3RyXChzcHJpbnRmXChbJyJdJW9bJyJdLFxzKmZpbGVwZXJtc1woXCRmaWxlXClcKSxccyotNFwpIjtpOjMwOTtzOjU1OiJcJFthLXpBLVowLTlfXStcKFsnIl1bJyJdXHMqLFxzKmV2YWxcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjMxMDtzOjE2OiJ3c29TZWNQYXJhbVxzKlwoIjtpOjMxMTtzOjE4OiJ3aGljaFxzK3N1cGVyZmV0Y2giO2k6MzEyO3M6Njc6ImNvcHlcKFxzKlsnIl1odHRwOi8vLis/XC50eHRbJyJdXHMqLFxzKlsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdXCkiO2k6MzEzO3M6Mjg6Ilwkc2V0Y29va1xzKlwpO3NldGNvb2tpZVwoXCQiO2k6MzE0O3M6NDkyOiJAP1xiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEA/XGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoQD9cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6MzE1O3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjMxNjtzOjM5OiIoY2hyXChbXHNcd1wkXF5cK1wtXCovXStcKVxzKlwuXHMqKXs0LH0iO2k6MzE3O3M6NDI6Ij1ccypAP2Zzb2Nrb3BlblwoXHMqXCRhcmd2XFtcZCtcXVxzKixccyo4MCI7aTozMTg7czozNToiXC5cLi9cLlwuL2VuZ2luZS9kYXRhL2RiY29uZmlnXC5waHAiO2k6MzE5O3M6ODU6InJlY3Vyc2VfY29weVwoXHMqXCRzcmNccyosXHMqXCRkc3RccypcKTtccypoZWFkZXJcKFxzKlsnIl1sb2NhdGlvbjpccypcJGRzdFsnIl1ccypcKTsiO2k6MzIwO3M6MTc6IkdhbnRlbmdlcnNccytDcmV3IjtpOjMyMTtzOjE0MzoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVxzKlthLXpBLVowLTlfXStccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSsiO2k6MzIyO3M6NDA6ImZ3cml0ZVwoXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl08XD9waHAiO2k6MzIzO3M6NTY6IkA/Y3JlYXRlX2Z1bmN0aW9uXChccypbJyJdWyciXVxzKixccypAP2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjMyNDtzOjk4OiJcXVwoWyciXVwkX1snIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXSI7aTozMjU7czozOToiaWZccypcKFxzKmlzc2V0XChccypcJF9HRVRcW1xzKlsnIl1waW5nIjtpOjMyNjtzOjMwOiJyZWFkX2ZpbGVcKFxzKlsnIl1kb21haW5zXC50eHQiO2k6MzI3O3M6MzY6ImV2YWxcKFxzKlsnIl17XHMqXCRbYS16QS1aMC05X10rXHMqfSI7aTozMjg7czoxMDg6ImlmXHMqXChccypmaWxlX2V4aXN0c1woXHMqXCRbYS16QS1aMC05X10rXHMqXClccypcKVxzKntccypjaG1vZFwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aTozMjk7czoxMToiPT1bJyJdXClcKTsiO2k6MzMwO3M6NTU6IlwkW2EtekEtWjAtOV9dKz11cmxkZWNvZGVcKFsnIl0uKz9bJyJdXCk7aWZcKHByZWdfbWF0Y2giO2k6MzMxO3M6ODA6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypkZWNyeXB0X1NPXChccypcJFthLXpBLVowLTlfXStccyosXHMqWyciXVthLXpBLVowLTlfXStbJyJdIjtpOjMzMjtzOjEwNToiPVxzKm1haWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dK1xbXGQrXF1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXStcW1xkK1xdIjtpOjMzMztzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTozMzQ7czo5NDoiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpO1xzKmhlYWRlciI7aTozMzU7czoxMDc6IkBpbmlfc2V0XChbJyJdZXJyb3JfbG9nWyciXSxOVUxMXCk7XHMqQGluaV9zZXRcKFsnIl1sb2dfZXJyb3JzWyciXSwwXCk7XHMqZnVuY3Rpb25ccytyZWFkX2ZpbGVcKFwkZmlsZV9uYW1lIjtpOjMzNjtzOjM3OiJcJHRleHRccyo9XHMqaHR0cF9nZXRcKFxzKlsnIl1odHRwOi8vIjtpOjMzNztzOjE0MzoiXCRbYS16QS1aMC05X10rXHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rXCk7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKnN0cl9yZXBsYWNlXChbJyJdPC9odG1sPlsnIl0iO2k6MzM4O3M6MTU4OiJcI1thLXpBLVowLTlfXStcI1xzKmlmXChlbXB0eVwoXCRbYS16QS1aMC05X10rXClcKVxzKntccypcJFthLXpBLVowLTlfXStccyo9XHMqWyciXTxzY3JpcHQuKz88L3NjcmlwdD5bJyJdO1xzKmVjaG9ccytcJFthLXpBLVowLTlfXSs7XHMqfVxzKlwjL1thLXpBLVowLTlfXStcIyI7aTozMzk7czo2NjoiXC5cJF9SRVFVRVNUXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVxzKixccyp0cnVlXHMqLFxzKjMwMlwpIjtpOjM0MDtzOjEwNDoiPVxzKmNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqbnVsbFxzKixccypbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dK1woXCkiO2k6MzQxO3M6NTQ6Ij1ccypmaWxlX2dldF9jb250ZW50c1woWyciXWh0dHBzPzovL1xkK1wuXGQrXC5cZCtcLlxkKyI7aTozNDI7czo1NzoiQ29udGVudC10eXBlOlxzKmFwcGxpY2F0aW9uL3ZuZFwuYW5kcm9pZFwucGFja2FnZS1hcmNoaXZlIjtpOjM0MztzOjIwOiJzbHVycFx8bXNuYm90XHx0ZW9tYSI7aTozNDQ7czoyNzoiXCRHTE9CQUxTXFtuZXh0XF1cW1snIl1uZXh0IjtpOjM0NTtzOjE3OToiO0A/XCRbYS16QS1aMC05X10rXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MzQ2O3M6Mjk6ImhlYWRlclwoX1thLXpBLVowLTlfXStcKFxkK1wpIjtpOjM0NztzOjE4MzoiaWZccypcKGlzc2V0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKiYmXHMqbWQ1XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKVxzKj09PVxzKlsnIl1bYS16QS1aMC05X10rWyciXVwpIjtpOjM0ODtzOjkwOiJcLj1ccypjaHJcKFwkW2EtekEtWjAtOV9dK1xzKj4+XHMqXChcZCtccypcKlxzKlwoXGQrXHMqLVxzKlwkW2EtekEtWjAtOV9dK1wpXClccyomXHMqXGQrXCkiO2k6MzQ5O3M6MzE6Ii0+cHJlcGFyZVwoWyciXVNIT1dccytEQVRBQkFTRVMiO2k6MzUwO3M6MjM6InNvY2tzX3N5c3JlYWRcKFwkY2xpZW50IjtpOjM1MTtzOjI0OiI8JWV2YWxcKFxzKlJlcXVlc3RcLkl0ZW0iO2k6MzUyO3M6OTk6IlwkX1BPU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypmb3BlblwoXHMqXCRfR0VUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXSI7aTozNTM7czo0MDoidXJsPVsnIl1odHRwOi8vc2NhbjR5b3VcLm5ldC9yZW1vdGVcLnBocCI7aTozNTQ7czo2MDoiY2FsbF91c2VyX2Z1bmNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStcKTt9IjtpOjM1NTtzOjczOiJwcmVnX3JlcGxhY2VcKFxzKlsnIl0vLis/L2VbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjM1NjtzOjEwNjoiPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdLis/WyciXVwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypmb3BlblwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl13WyciXSI7aTozNTc7czo1OToiaWZcKFxzKlwkW2EtekEtWjAtOV9dK1wpXHMqe1xzKmV2YWxcKFwkW2EtekEtWjAtOV9dK1wpO1xzKn0iO2k6MzU4O3M6MTc5OiJhcnJheV9tYXBcKFxzKlsnIl1cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXSI7aTozNTk7czoxODE6Ij1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF07XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmZpbGVfcHV0X2NvbnRlbnRzXChccypcJFthLXpBLVowLTlfXStccyosXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpXHMqXCkiO2k6MzYwO3M6NjE6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz1bJyJdLis/WyciXTtccypoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjoiO2k6MzYxO3M6MjU6IjwhLS1cI2V4ZWNccytjbWRccyo9XHMqXCQiO2k6MzYyO3M6ODE6ImlmXChccypzdHJpcG9zXChccypcJFthLXpBLVowLTlfXStccyosXHMqWyciXWFuZHJvaWRbJyJdXHMqXClccyohPT1ccypmYWxzZVwpXHMqeyI7aTozNjM7czo5MDoiXC49XHMqWyciXTxkaXZccytzdHlsZT1bJyJdZGlzcGxheTpub25lO1snIl0+WyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdPC9kaXY+IjtpOjM2NDtzOjExNDoiPWZpbGVfZXhpc3RzXChcJFthLXpBLVowLTlfXStcKVw/QGZpbGVtdGltZVwoXCRbYS16QS1aMC05X10rXCk6XCRbYS16QS1aMC05X10rO0BmaWxlX3B1dF9jb250ZW50c1woXCRbYS16QS1aMC05X10rIjtpOjM2NTtzOjg5OiJcJFthLXpBLVowLTlfXStccypcW1xzKlthLXpBLVowLTlfXStccypcXVwoXHMqXCRbYS16QS1aMC05X10rXFtccypbYS16QS1aMC05X10rXHMqXF1ccypcKSI7aTozNjY7czo5NjoiXCRbYS16QS1aMC05X10rLFsnIl1zbHVycFsnIl1cKVxzKiE9PVxzKmZhbHNlXHMqXHxcfFxzKnN0cnBvc1woXHMqXCRbYS16QS1aMC05X10rLFsnIl1zZWFyY2hbJyJdIjtpOjM2NztzOjYzOiJcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXClccypcKTsiO2k6MzY4O3M6MTc6ImNsYXNzXHMrTUN1cmxccyp7IjtpOjM2OTtzOjU2OiJAaW5pX3NldFwoWyciXWRpc3BsYXlfZXJyb3JzWyciXSwwXCk7XHMqQGVycm9yX3JlcG9ydGluZyI7aTozNzA7czo2OToiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJGZpbGVwYXRoXHMqXClccypcKVxzKntccyplY2hvXHMrWyciXXVwbG9hZGVkIjtpOjM3MTtzOjMwOiJyZXR1cm5ccytSQzQ6OkVuY3J5cHRcKFwkYSxcJGIiO2k6MzcyO3M6MzI6ImZ1bmN0aW9uXHMrZ2V0SFRUUFBhZ2VcKFxzKlwkdXJsIjtpOjM3MztzOjIxOiI9XHMqcmVxdWVzdFwoXHMqY2hyXCgiO2k6Mzc0O3M6NTU6IjtccyphcnJheV9maWx0ZXJcKFwkW2EtekEtWjAtOV9dK1xzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6Mzc1O3M6MjI4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6Mzc2O3M6MjQxOiJjYWxsX3VzZXJfZnVuY19hcnJheVwoXHMqWyciXVxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilbJyJdXHMqLFxzKmFycmF5XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjM3NztzOjg3OiJpZiBcKCE/XCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdXHMqT1JccypcKHN1YnN0clwoXCRfU0VSVkVSXFtbJyJdUkVNT1RFX0FERFIiO2k6Mzc4O3M6NTM6InJlbHBhdGh0b2Fic3BhdGhcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjM3OTtzOjY4OiJcJGRhdGFcW1snIl1jY19leHBfbW9udGhbJyJdXF1ccyosXHMqc3Vic3RyXChcJGRhdGFcW1snIl1jY19leHBfeWVhciI7aTozODA7czo0MDoiXCRbYS16QS1aMC05X10rXHMqKFxbLnsxLDQwfVxdKXsxLH1ccypcKCI7aTozODE7czozMzoiY2FsbF91c2VyX2Z1bmNcKFxzKkA/dW5oZXhcKFxzKjB4IjtpOjM4MjtzOjI5OiJcLlwuOjpcW1xzKnBocHJveHlccypcXTo6XC5cLiI7aTozODM7czo0NDoiWyciXVxzKlwuXHMqY2hyXChccypcZCsuXGQrXHMqXClccypcLlxzKlsnIl0iO2k6Mzg0O3M6MzI6InByZWdfcmVwbGFjZS4qPy9lWyciXVxzKixccypbJyJdIjtpOjM4NTtzOjg1OiJcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1wpIjtpOjM4NjtzOjIzOiJ9ZXZhbFwoYnpkZWNvbXByZXNzXChcJCI7aTozODc7czo1ODoiL3Vzci9sb2NhbC9wc2EvYXBhY2hlL2Jpbi9odHRwZFxzKy1ERlJPTlRQQUdFXHMrLURIQVZFX1NTTCI7aTozODg7czo1NzoiaWNvbnZcKGJhc2U2NF9kZWNvZGVcKFsnIl0uKz9bJyJdXClccyosXHMqYmFzZTY0X2RlY29kZVwoIjtpOjM4OTtzOjMzOiI8YnI+WyciXVwucGhwX3VuYW1lXChcKVwuWyciXTxicj4iO2k6MzkwO3M6NjY6IlwpO0BcJFthLXpBLVowLTlfXStcW2NoclwoXGQrXClcXVwoXCRbYS16QS1aMC05X10rXFtjaHJcKFxkK1wpXF1cKCI7aTozOTE7czoxMDk6IlxiKGZvcGVufGZpbGVfZ2V0X2NvbnRlbnRzfGZpbGVfcHV0X2NvbnRlbnRzfHN0YXR8Y2htb2R8ZmlsZXxzeW1saW5rKVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MzkyO3M6OTU6IlxiKGZvcGVufGZpbGVfZ2V0X2NvbnRlbnRzfGZpbGVfcHV0X2NvbnRlbnRzfHN0YXR8Y2htb2R8ZmlsZXxzeW1saW5rKVwoWyciXWh0dHA6Ly9wYXN0ZWJpblwuY29tIjtpOjM5MztzOjEwOToiO1wkW2EtekEtWjAtOV9dKz1cJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1wpO1xzKlw/PiI7aTozOTQ7czo4MzoiXCRfU0VSVkVSXFtbJyJdUkVRVUVTVF9VUklbJyJdXF1cKSxbJyJdW2EtekEtWjAtOV9dK1snIl1cKVwpe1xzKmluY2x1ZGVcKGdldGN3ZFwoXCkiO2k6Mzk1O3M6ODQ6IndwX3NldF9hdXRoX2Nvb2tpZVwoXCR1c2VyX2lkXCk7XHMqZG9fYWN0aW9uXChbJyJdd3BfbG9naW5bJyJdXHMqLFxzKlwkdXNlcl9sb2dpblwpOyI7aTozOTY7czo1MjoiYXJyYXlfZGlmZl91a2V5XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozOTc7czo2MDoiPWZvcGVuXChiYXNlNjRfZGVjb2RlXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjM5ODtzOjE5OiItZXhlYyB0b3VjaCAtYWNtIC1yIjtpOjM5OTtzOjIzNDoiXCRbYS16QS1aMC05X10rXHMqXC49XHMqc3Vic3RyXChcJFthLXpBLVowLTlfXSssXHMqXCRbYS16QS1aMC05X10rXHMqXCtccypcZCssXHMqXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwoXCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcXVwpXCk7XHMqXCRbYS16QS1aMC05X10rXHMqXCs9XHMqXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwoXCRbYS16QS1aMC05X10rIjtpOjQwMDtzOjgwOiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkaW1hZ2UsXHMqZGlybmFtZVwoX19GSUxFX19cKVxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJCI7aTo0MDE7czozOToiXCRzdHI9IjxoMT40MDMgRm9yYmlkZGVuPC9oMT48IS0tIHRva2VuIjtpOjQwMjtzOjY5OiJAP2luY2x1ZGVfb25jZVxzKlwoXHMqZGlybmFtZVwoX19GSUxFX19cKVxzKlwuXHMqJy8nXHMqXC5ccyp1cmxkZWNvZGUiO2k6NDAzO3M6MTEzOiJcJGxvY2FscGF0aD1nZXRlbnZcKCJTQ1JJUFRfTkFNRSJcKTtcJGFic29sdXRlcGF0aD1nZXRlbnZcKCJTQ1JJUFRfRklMRU5BTUUiXCk7XCRyb290X3BhdGg9c3Vic3RyXChcJGFic29sdXRlcGF0aCI7aTo0MDQ7czoxMjU6IlwkdHBsXHMqPVxzKlwkdHBsX3BhdGhcP1xzKkBmaWxlX2dldF9jb250ZW50c1woXCRyb290X3BhdGhcLlwkdHBsX3BhdGhcKTpccypbJyJdWyciXTtccyppZiBcKHN0cnBvc1woXCR0cGwsXHMqWyciXVxbQ09OVEVOVFxdIjtpOjQwNTtzOjE5OiIvLzpwdHRoWyciXXswLDF9XCk7IjtpOjQwNjtzOjk3OiJcJFthLXpBLVowLTlfXStccyo9XHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStcW1xzKlwkW2EtekEtWjAtOV9dK1xbXHMqXCRbYS16QS1aMC05X10rIjtpOjQwNztzOjE0OiJcJGNsb2Frbm9yZWRpciI7aTo0MDg7czoxNToiWyciXS9ldGMvcGFzc3dkIjtpOjQwOTtzOjE1OiJbJyJdL3Zhci9jcGFuZWwiO2k6NDEwO3M6MTQ6IlsnIl0vZXRjL2h0dHBkIjtpOjQxMTtzOjIwOiJbJyJdL2V0Yy9uYW1lZFwuY29uZiI7aTo0MTI7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0MTM7czoxNToiMTA5XC4yMzhcLjI0MlwuIjtpOjQxNDtzOjkxOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKD9ccypAP1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQxNTtzOjY1OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKD9ccypbJyJdaW1hZ2VzLyI7aTo0MTY7czo3MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQD91cmxlbmNvZGUiO2k6NDE3O3M6NzE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKD9bJyJdY2RccysvdG1wIjtpOjQxODtzOjMyNzoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjQxOTtzOjIzOiIvdmFyL3FtYWlsL2Jpbi9zZW5kbWFpbCI7aTo0MjA7czo1MToiXCRbYS16QS1aMC05X10rID0gXCRbYS16QS1aMC05X10rXChbJyJdezAsMX1odHRwOi8vIjtpOjQyMTtzOjEzNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz9cLmpwZyI7aTo0MjI7czoxMzY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoP1xzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5naWYiO2k6NDIzO3M6MTM2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKD9ccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rP1wucG5nIjtpOjQyNDtzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLnBuZyI7aTo0MjU7czoxMDY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoP1xzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz8vW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5qcGciO2k6NDI2O3M6MTA2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKD9ccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/L1tccyVcLkBcLVwrXChcKS9cd10rP1wuZ2lmIjtpOjQyNztzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLmljbyI7aTo0Mjg7czoxMDg6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aTo0Mjk7czo2NzoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqWyciXS92YXIvd3d3LyI7aTo0MzA7czo2NDoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCg/XHMqWyciXS9ob21lLyI7aTo0MzE7czoxODk6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKGZpbGVfZ2V0X2NvbnRlbnRzXChbJyJdaHR0cDovLyI7aTo0MzI7czoyMzE6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKSI7aTo0MzM7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjQzNDtzOjkyOiJcJFthLXpBLVowLTlfXSs9WyciXVthLXpBLVowLTkvXCtcPV9dK1snIl07XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkW2EtekEtWjAtOV9dK1wpO1xzKlw/PiI7aTo0MzU7czo2MjoiXCRbYS16QS1aMC05X10rLT5fc2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6NDM2O3M6MzQ6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdZXZhbFsnIl0iO2k6NDM3O3M6NDM6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdYmFzZTY0X2RlY29kZVsnIl0iO2k6NDM4O3M6NDU6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdY3JlYXRlX2Z1bmN0aW9uWyciXSI7aTo0Mzk7czozNjoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1hc3NlcnRbJyJdIjtpOjQ0MDtzOjQyOiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXXByZWdfcmVwbGFjZVsnIl0iO2k6NDQxO3M6MjE2OiJcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6NDQyO3M6MTUwOiJcJFthLXpBLVowLTlfXStcW1xzKlwkW2EtekEtWjAtOV9dK1xzKlxdXFtccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC4iO2k6NDQzO3M6NDM6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXFsiO2k6NDQ0O3M6NjM6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStcWyI7aTo0NDU7czo1MDoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKFxzKlsnIl0iO2k6NDQ2O3M6NzA6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKVxzKiwiO2k6NDQ3O3M6Njk6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rXHMqXClccypcKSI7aTo0NDg7czoyMzY6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypcJFthLXpBLVowLTlfXStcKFsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXClccypcKVxzKlwpIjtpOjQ0OTtzOjE0MzoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1cJFthLXpBLVowLTlfXSs9QFthLXpBLVowLTlfXStcKFsnIl0uKz9bJyJdXCk7W2EtekEtWjAtOV9dK1woIVwkW2EtekEtWjAtOV9dK1wpe1wkW2EtekEtWjAtOV9dKz1AW2EtekEtWjAtOV9dK1woXHMqXCkiO2k6NDUwO3M6MTE0OiJcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXChccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXCkiO2k6NDUxO3M6MzI6IlwkW2EtekEtWjAtOV9dK1woXHMqQFwkX0NPT0tJRVxbIjtpOjQ1MjtzOjI5OiJcJFthLXpBLVowLTlfXStcKFsnIl0uLmVbJyJdLCI7aTo0NTM7czo3MDoiQFwkW2EtekEtWjAtOV9dKyYmQFwkW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dK1wpOyI7aTo0NTQ7czoyMjg6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKSI7aTo0NTU7czoxODY6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKFxzKlwkW2EtekEtWjAtOV9dK1woXHMqWyciXSI7aTo0NTY7czoyMjc6IkA/XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChbJyJdIjtpOjQ1NztzOjE4MToiXCRbYS16QS1aMC05X10rPVwkW2EtekEtWjAtOV9dK1woWyciXS4rP1snIl0sXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dKz1cJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1wpOyI7aTo0NTg7czoxMzE6IkA/YXJyYXlfbWFwXChAP1wke1xzKlsnIl1cd3sxLDQ1fVsnIl1ccyp9e1xzKlx3ezEsNDV9XHMqfVxzKixccyphcnJheVwoQD9cJFxzKntccypbJyJdXHd7MSw0NX1bJyJdXHMqfXtccypbJyJdXHd7MSw0NX1bJyJdXHMqfVwpXCk7IjtpOjQ1OTtzOjY1OiJAP1wke0A/WyciXVx3ezEsNDV9WyciXX1cW1xkK1xdXChAP1wke1snIl1cd3sxLDQ1fVsnIl19XFtcZCtcXVwpOiI7aTo0NjA7czo4NToiXCR7WyciXVx3ezEsNDV9WyciXX1cW1snIl1cd3sxLDQ1fVsnIl1cXVwoXCR7WyciXVx3ezEsNDV9WyciXX1cW1snIl1cd3sxLDQ1fVsnIl1cXVwpOyI7aTo0NjE7czo3NzoiQD9cJHtbJyJdXHd7MSw0NX1bJyJdfT1AP1wke1snIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdfTtAP1woXCgiO2k6NDYyO3M6Nzg6IkA/cmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25cKEA/XCR7QD9bJyJdXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXSI7aTo0NjM7czo0NzoiXCRcd3sxLDQ1fXtcZCt9XChcJFx3ezEsNDV9e1xkK31cKTpAP1wkXHd7MSw0NX0iO2k6NDY0O3M6NDg6IjtcJHtbJyJdR0xPQkFMU1snIl19XFtbJyJdXHd7MSw0NX1bJyJdXF1cKFwpO1w/PiI7aTo0NjU7czo3NDoiaWZcKGlzc2V0XChcJF9DT09LSUVcW1snIl1cd3sxLDQ1fVsnIl1cXVwpXCl7XHMqXCRjaD1jdXJsX2luaXRcKFsnIl1odHRwOi8iO2k6NDY2O3M6MTIyOiJpZlwoXCRwYWdlXHMqPVxzKlwkX0dFVFxbWyciXXBbJyJdXF1cKVxzKntccypcJGV4dHNccyo9XHMqYXJyYXlcKCJcLmh0bWwiLFxzKiJcLmh0bSIsXHMqIlwucGhwIlwpO1xzKmVycm9yX3JlcG9ydGluZ1woMFwpOyI7aTo0Njc7czo5NDoiaWZccypcKHN0cmxlblwoXCRsaW5rXClccyo+XHMqXGQrXClccyp7XHMqXCRmcFxzKj1ccypAP2ZvcGVuXHMqXChccypcJGNhY2hlXHMqLFxzKlsnIl13WyciXVwpOyI7aTo0Njg7czo2ODoiXCRsaW5rZXJccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08cmVwbGFjZT5bJyJdLFxzKlwkcGFyYW0sXHMqXCRsaW5rZXIiO2k6NDY5O3M6ODQ6ImdldFwoWyciXWh0dHA6Ly9bJyJdXC5cJF9DT09LSUVcW1snIl1cd3sxLDQ1fVsnIl1cXVwuWyciXS9cP1x3ezEsNDV9PVsnIl1cLlwkX0NPT0tJRSI7aTo0NzA7czo3NToiaWZccypcKGNvcHlcKFwkX0ZJTEVTXFtbJyJdXHd7MSw0NX1bJyJdXF1cW1snIl1cd3sxLDQ1fVsnIl1cXSxccypcJFx3ezEsNDV9IjtpOjQ3MTtzOjY5OiJlcnJvcl9yZXBvcnRpbmdcKFxkK1wpO1xzKmRlZmluZVwoWyciXVBBU1NXT1JEWyciXVxzKixccypbJyJdXHd7MSw0NX0iO2k6NDcyO3M6Nzc6ImV4dHJhY3RcKFwkX1NFUlZFUlwpO1xzKmFycmF5X2ZpbHRlclwoXChhcnJheVwpXCRcd3sxLDQ1fVxzKixccypcJFx3ezEsNDV9XCk7IjtpOjQ3MztzOjY2OiJyZWdpc3Rlcl9zaHV0ZG93bl9mdW5jdGlvblxzKlwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDc0O3M6NzY6Ilwke1x3ezEsNDV9XChbJyJdLio/WyciXVwpfVxzKj1ccypcJHtcd3sxLDQ1fVwoWyciXS4qP1snIl1cKX1cKFwke1x3ezEsNDV9XCgiO2k6NDc1O3M6NTE6IlwkXHd7MSw0NX1cW1xzKmNoclwoXHMqXGQrXHMqXClccypcXVwoXHMqXHd7MSw0NX1cKCI7aTo0NzY7czoxMTg6IlwkcGF0aD1cJF9TRVJWRVJcW1snIl1ET0NVTUVOVF9ST09UWyciXVxdXC5bJyJdW2EtekEtWjAtOV9dK1snIl07XFxzXCppbmNsdWRlXChcJHBhdGhcLlwkX0dFVFxbWyciXXBbJyJdXF1cKTtcXHNcKmRpZTsiO2k6NDc3O3M6NDI6ImZ1bmN0aW9uIENyZWF0ZUxpbmtcKFwkZGlyLFwkcmVwbGFjZXN0cjFcKSI7aTo0Nzg7czoxMDQ6IlwkZnBccyo9XHMqZnNvY2tvcGVuXChbJyJddWRwOi8vXCRob3N0WyciXVxzKixccypcJHBvcnQsXHMqXCRlcnJubyxccypcJGVycnN0cixccypcZCtccypcKTtccyppZlwoXCRmcFwpIjtpOjQ3OTtzOjU4OiI7XHMqaW5jbHVkZV9vbmNlXChccypzeXNfZ2V0X3RlbXBfZGlyXChcKVxzKlwuXHMqWyciXS9TRVNTIjtpOjQ4MDtzOjc4OiJcJHVybFxzKj1ccypbJyJdcmVmZXJlcjpbJyJdXC5zdHJ0b2xvd2VyXChcJF9TRVJWRVJcW1snIl1IVFRQX1JFRkVSRVJbJyJdXF1cKTsiO2k6NDgxO3M6OTU6IlwkaXBccyo9XHMqXCRfU0VSVkVSXFtbJyJdUkVNT1RFX0FERFJbJyJdXF07XHMqXCR1cmxccyo9XHMqXCRfR0VUXFtbJyJdaWRbJyJdXF07XHMqXCR0YXJnZXRccyo9IjtpOjQ4MjtzOjgyOiJSZXdyaXRlUnVsZVxzKlxeXChcW0EtWmEtejAtOS1cXVwrXClcLmh0bWxcJFxzKlx3ezEsNDV9XC5waHBcP1x3ezEsNDV9PVwkMVxzKlxbTFxdIjtpOjQ4MztzOjgxOiJmaWxlX3B1dF9jb250ZW50c1woXCRkaXJcLlsnIl0vWyciXVwuXCRmaWxlLFxzKlwkdGVtcHN0clwpO1xzKmVjaG9ccypbJyJdbGlua2J5bWUiO2k6NDg0O3M6NTc6ImlmXChzdHJwb3NcKFwkcXVlcnlTdHIsWyciXWFjdGlvbj1zaXRlbWFwWyciXVwpIT09ZmFsc2VcKSI7aTo0ODU7czozOToiRW5jb2RlXHMrYnlccytodHRwOi8vV3d3XC5QSFBKaWFNaVwuQ29tIjtpOjQ4NjtzOjgxOiJcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypcJFthLXpBLVowLTlfXSsiO2k6NDg3O3M6NTc6ImVjaG9ccypbJyJdZ29vZ2xlLXNpdGUtdmVyaWZpY2F0aW9uOlxzKmdvb2dsZVsnIl1cLlwkX0dFVCI7aTo0ODg7czoyNzoiZmlsdGVyX3ZhclxzKlwoXHMqXCRfU0VSVkVSIjtpOjQ4OTtzOjI0OiJQbHVnaW4gTmFtZTpccypXUENvcmVTeXMiO2k6NDkwO3M6Nzc6Ii0+QXV0aG9yaXplXHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVx3ezEsNDV9WyciXVxdXCk7IjtpOjQ5MTtzOjQ1OiItPkF1dGhvcml6ZVxzKlwoXHMqWyciXXswLDF9XGQrWyciXXswLDF9XHMqXCkiO2k6NDkyO3M6Mzc6IlwkVVNFUi0+QXV0aG9yaXplXChccypcJFx3ezEsNDV9XHMqXCkiO2k6NDkzO3M6MjY6IkNyZWRpdFxzKkNhcmRccyo8XHd7MSw0NX1AIjtpOjQ5NDtzOjgyOiJcJFx3ezEsNDV9XHMqPVxzKlwkXHd7MSw0NX1cKFsnIl1bJyJdXHMqLFxzKlwkXHd7MSw0NX1ccypcKTtccypAXCRcd3sxLDQ1fVwoXHMqXCk7IjtpOjQ5NTtzOjU0OiJjYWxsX3VzZXJfZnVuY1woXHMqY3JlYXRlX2Z1bmN0aW9uXChccypudWxsXHMqLFxzKnBhY2siO2k6NDk2O3M6NTM6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypwYWNrXChccypbJyJdSFwqWyciXVxzKixccypqb2luIjtpOjQ5NztzOjQ3OiJwYWNrXChbJyJdSDEzMFsnIl0sXCRoZWFkZXJccypcLlxzKlsnIl1cd3sxLDQ1fSI7aTo0OTg7czo3NDoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdcGhwOi8vaW5wdXRbJyJdXCkiO2k6NDk5O3M6NzE6IlwkXHd7MSw0NX1cKFxzKlwkXHMqe1xzKlsnIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdfVxzKlxbIjtpOjUwMDtzOjExNDoiXCRfXHd7MSw0NX1ccyo9XHMqXCRfXHd7MSw0NX1cKFxzKlxkK1xzKlwpXHMqXC5ccypcJF9cd3sxLDQ1fVwoXHMqXGQrXHMqXClccypcLlxzKlwkX1x3ezEsNDV9XChccypcZCtccypcKVxzKlwuXHMqIjtpOjUwMTtzOjE3OiI9WyciXVwpXCk7WyciXVwpOyI7aTo1MDI7czo0ODoiQGFzc2VydF9vcHRpb25zXChccypBU1NFUlRfUVVJRVRfRVZBTFxzKixccyoxXCk7IjtpOjUwMztzOjYyOiJhcnJheV9maWx0ZXJcKFxzKmFycmF5XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo1MDQ7czoxMDA6ImZpbHRlcl92YXJcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1Qpe1xzKlx3ezEsNDV9XHMqfVxzKixccypGSUxURVJfQ0FMTEJBQ0tccyosXHMqYXJyYXkiO2k6NTA1O3M6NDY6InByZWdfbWF0Y2hfYWxsXCgiLzxJZk1vZHVsZVxcc1wrbW9kX3Jld3JpdGVcLmMiO2k6NTA2O3M6MjM6Ijx0aXRsZT5TaGVsbFxzK1VwbG9hZGVyIjtpOjUwNztzOjc0OiJcP29wdGlvbj1jb21fY29uZmlnJnZpZXc9Y29tcG9uZW50JmNvbXBvbmVudD1jb21fbWVkaWEmcGF0aCZ0bXBsPWNvbXBvbmVudCI7aTo1MDg7czozMDoiPHRpdGxlPndob2lzdG9yeVwuY29tXHMrcGFyc2VyIjtpOjUwOTtzOjI5OiJteWVjaG9cKFxzKlsnIl1TaGVsbFxzK3VwbG9hZCI7aTo1MTA7czo3NzoiYXJyYXlfbWFwXChccypjcmVhdGVfZnVuY3Rpb25cKFxzKlsnIl1bJyJdXHMqLFwkXHd7MSw0NX1cKSxhcnJheVwoXHMqWyciXVsnIl0iO2k6NTExO3M6NDM6InRyaWdnZXJfZXJyb3JccypcKFwkPHNwPlxzKixccypFX1VTRVJfRVJST1IiO2k6NTEyO3M6ODQ6Iml0ZXJhdG9yX2FwcGx5XHMqXChccypcJFx3ezEsNDV9XHMqLFxzKlwkXHd7MSw0NX1ccyosXHMqYXJyYXlccypcKFxzKlwkXHd7MSw0NX1ccypcKSI7aTo1MTM7czo3MzoiYXJyYXlfbWFwXHMqXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXTx3cFsnIl1ccypcXSI7aTo1MTQ7czo5MzoiY3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXVxzKixccypcJFx3ezEsNDV9e1xkK31ccypcLlxzKlwkXHd7MSw0NX17XGQrfVxzKlwuXHMqXCRcd3sxLDQ1fXtcZCt9IjtpOjUxNTtzOjU0OiJhZGRfYWN0aW9uXChbJyJdd3BfZm9vdGVyWyciXVxzKixccypbJyJdd3BfZnVuY19qcXVlcnkiO2k6NTE2O3M6NjM6ImZvcGVuXChccypiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo1MTc7czo2NjoiPVxbIidcXVwuezEsMTB9XD9cWyciXF1cW1xcXF4mXHxcXVxbJyJcXVwuezEsMTB9XD9cWyciXF1cWztcXFwuL1xdIjt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxNDI6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKD9ccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoP1xzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoP1xzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCg/XHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoxOToid2l0aCAwLzAvMCBpZlwoMVwpeyI7aTo1ODtzOjQ2OiJcJHgyPVwkcGFyYW1cW1snIl17MCwxfXhbJyJdezAsMX1cXSBcKyBcJHdpZHRoIjtpOjU5O3M6OToic3BlY2lhbGlzIjtpOjYwO3M6ODoiY29weVwoXCkiO2k6NjE7czoxOToid3BfZ2V0X2N1cnJlbnRfdXNlciI7aTo2MjtzOjc6Ii0+Y2htb2QiO2k6NjM7czo3OiJfbWFpbFwoIjtpOjY0O3M6NzoiX2NvcHlcKCI7aTo2NTtzOjc6IiZjb3B5XCgiO2k6NjY7czo0NToic3RycG9zXChcJF9TRVJWRVJcWydIVFRQX1VTRVJfQUdFTlQnXF0sJ0RydXBhIjtpOjY3O3M6MTY6ImV2YWxcKGNsYXNzU3RyXCkiO2k6Njg7czozMToiZnVuY3Rpb25fZXhpc3RzXCgnYmFzZTY0X2RlY29kZSI7aTo2OTtzOjQ0OiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnIlwuSlRleHQ6Ol9cKCdWQUxJRF9FTSI7aTo3MDtzOjQzOiJcJHgxPVwkbWluX3g7XCR4Mj1cJG1heF94O1wkeTE9XCRtaW5feTtcJHkyIjtpOjcxO3M6NDg6IlwkY3RtXFsnYSdcXVwpXCl7XCR4PVwkeCBcKiBcJHRoaXMtPms7XCR5PVwoXCR0aCI7aTo3MjtzOjU5OiJbJyJdezAsMX1jcmVhdGVfZnVuY3Rpb25bJyJdezAsMX0sWyciXXswLDF9Z2V0X3Jlc291cmNlX3R5cCI7aTo3MztzOjQ4OiJbJyJdezAsMX1jcmVhdGVfZnVuY3Rpb25bJyJdezAsMX0sWyciXXswLDF9Y3J5cHQiO2k6NzQ7czo2ODoic3RycG9zXChcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdLFsnIl17MCwxfUx5bngiO2k6NzU7czo2Nzoic3Ryc3RyXChcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdLFsnIl17MCwxfU1TSSI7aTo3NjtzOjI1OiJzb3J0XChcJERpc3RyaWJ1dGlvblxbXCRrIjtpOjc3O3M6MjU6InNvcnRcKGZ1bmN0aW9uXChhLGJcKXtyZXQiO2k6Nzg7czoyNToiaHR0cDovL3d3d1wuZmFjZWJvb2tcLmNvbSI7aTo3OTtzOjI1OiJodHRwOi8vbWFwc1wuZ29vZ2xlXC5jb20vIjtpOjgwO3M6NDg6InVkcDovLydcLnNlbGY6OlwkY19hZGRyLDgwLFwkZXJybm8sXCRlcnJzdHIsMTUwMCI7aTo4MTtzOjIwOiJcKFwuXCpcKHZpZXdcKVw/XC5cKiI7aTo4MjtzOjQ0OiJlY2hvIFsnIl17MCwxfTxzY3JpcHQ+YWxlcnRcKFsnIl17MCwxfVwkdGV4dCI7aTo4MztzOjE3OiJzb3J0XChcJHZfbGlzdFwpOyI7aTo4NDtzOjc1OiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFsndXBsb2FkZWRfcGFja2FnZSdcXVxbJ3RtcF9uYW1lJ1xdLFwkbW9zQ29uZmkiO2k6ODU7czoxMjoiZmFsc2VcKVwpO1wjIjtpOjg2O3M6NDY6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdNYWMgT1MiO2k6ODc7czo1MDoiZG9jdW1lbnRcLndyaXRlXCh1bmVzY2FwZVwoIiUzQ3NjcmlwdCBzcmM9Jy9iaXRyaXgiO2k6ODg7czoyNToiXCRfU0VSVkVSIFxbIlJFTU9URV9BRERSIiI7aTo4OTtzOjE3OiJhSFIwY0RvdkwyTnliRE11WiI7aTo5MDtzOjU0OiJKUmVzcG9uc2U6OnNldEJvZHlcKHByZWdfcmVwbGFjZVwoXCRwYXR0ZXJucyxcJHJlcGxhY2UiO2k6OTE7czo4OiIfiwgAAAAAACI7aTo5MjtzOjg6IlBLBQYAAAAAIjtpOjkzO3M6MTQ6IgkKCwwNIC8+XF1cW1xeIjtpOjk0O3M6ODoiiVBORw0KGgoiO2k6OTU7czoxMDoiXCk7XCNpJywnJiI7aTo5NjtzOjE1OiJcKTtcI21pcycsJycsXCQiO2k6OTc7czoxOToiXCk7XCNpJyxcJGRhdGEsXCRtYSI7aTo5ODtzOjM0OiJcJGZ1bmNcKFwkcGFyYW1zXFtcJHR5cGVcXS0+cGFyYW1zIjtpOjk5O3M6ODoiH4sIAAAAAAAiO2k6MTAwO3M6OToiAAECAwQFBgcIIjtpOjEwMTtzOjEyOiIhXCNcJCUmJ1wqXCsiO2k6MTAyO3M6Nzoig4uNm56foSI7aToxMDM7czo2OiIJCgsMDSAiO2k6MTA0O3M6MzM6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcy9tb2RfbSI7aToxMDU7czozMDoiXCRkZWNvcmF0b3JcKFwkbWF0Y2hlc1xbMVxdXFswIjtpOjEwNjtzOjIxOiJcJGRlY29kZWZ1bmNcKFwkZFxbXCQiO2k6MTA3O3M6MTc6Il9cLlwrX2FiYnJldmlhdGlvIjtpOjEwODtzOjQ1OiJzdHJlYW1fc29ja2V0X2NsaWVudFwoJ3RjcDovLydcLlwkcHJveHktPmhvc3QiO2k6MTA5O3M6MjU6ImV2YWxcKGZ1bmN0aW9uXChwLGEsYyxrLGUiO2k6MTEwO3M6MjU6IidydW5raXRfZnVuY3Rpb25fcmVuYW1lJywiO2k6MTExO3M6NjoigIGCg4SFIjtpOjExMjtzOjY6IgECAwQFBiI7aToxMTM7czo2OiIAAAAAAAAiO2k6MTE0O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTU7czoyMToiXCRtZXRob2RcKFwkYXJnc1xbMFxdIjtpOjExNjtzOjI0OiJcJG5hbWVcKFwkYXJndW1lbnRzXFswXF0iO2k6MTE3O3M6MzE6InN1YnN0clwobWQ1XChzdWJzdHJcKFwkdG9rZW4sMCwiO2k6MTE4O3M6MjQ6InN0cnJldlwoc3Vic3RyXChzdHJyZXZcKCI7aToxMTk7czozOToic3RyZWFtX3NvY2tldF9jbGllbnRcKCd0Y3A6Ly8nXC5cJHByb3h5IjtpOjEyMDtzOjM2OiJcJGVsZW1lbnRcW2JcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb24iO2k6MTIxO3M6MzE6IlwkbWV0aG9kXChcJHJlbGF0aW9uXFsnaXRlbU5hbWUiO2k6MTIyO3M6MzY6IlwkdmVyc2lvblxbMVxdXCk7fWVsc2VpZlwocHJlZ19tYXRjaCI7aToxMjM7czozNDoiXCRjb21tYW5kXChcJGNvbW1hbmRzXFtcJGlkZW50aWZpZSI7aToxMjQ7czo0MjoiXCRjYWxsYWJsZVwoXCRyYXdcWydjYWxsYmFjaydcXVwoXCRjXCksXCRjIjtpOjEyNTtzOjQyOiJcJGVsXFt2YWxcXVwoXClcKSBcJGVsXFt2YWxcXVwoZGF0YVxbc3RhdGUiO2k6MTI2O3M6NDc6IlwkZWxlbWVudFxbdFxdXCgwXCksdGhpc1wudHJhbnNpdGlvblwoImFkZENsYXNzIjtpOjEyNztzOjMxOiJcKTtcI21pcycsJyAnLFwkaW5wdXRcKTtcJGlucHV0IjtpOjEyODtzOjMxOiJraWxsIC05ICdcLlwkcGlkXCk7XCR0aGlzLT5jbG9zIjtpOjEyOTtzOjMyOiJjYWxsX3VzZXJfZnVuY1woXCRmaWx0ZXIsXCR2YWx1ZSI7aToxMzA7czozMzoiY2FsbF91c2VyX2Z1bmNcKFwkb3B0aW9ucyxcJGVycm9yIjtpOjEzMTtzOjM2OiJjYWxsX3VzZXJfZnVuY1woXCRsaXN0ZW5lcixcJGV2ZW50XCkiO2k6MTMyO3M6NjU6ImlmXChzdHJpcG9zXChcJHVzZXJBZ2VudCwnQW5kcm9pZCdcKSE9PWZhbHNlXCl7XCR0aGlzLT5tb2JpbGU9dHJ1IjtpOjEzMztzOjUzOiJiYXNlNjRfZGVjb2RlXCh1cmxkZWNvZGVcKFwkZmlsZVwpXCk9PSdpbmRleFwucGhwJ1wpeyI7aToxMzQ7czo2MDoidXJsZGVjb2RlXChiYXNlNjRfZGVjb2RlXChcJGlucHV0XClcKTtcJGV4cGxvZGVBcnJheT1leHBsb2RlIjtpOjEzNTtzOjM3OiJiYXNlNjRfZGVjb2RlXCh1cmxkZWNvZGVcKFwkcmV0dXJuVXJpIjtpOjEzNjtzOjQ3OiJ1cmxkZWNvZGVcKHVybGRlY29kZVwoc3RyaXBjc2xhc2hlc1woXCRzZWdtZW50cyI7aToxMzc7czo1MzoibWFpbFwoXCR0byxcJHN1YmplY3QsXCRib2R5LFwkaGVhZGVyXCk7fWVsc2V7XCRyZXN1bHQiO2k6MTM4O3M6Mzg6Ij1pbmlfZ2V0XCgnZGlzYWJsZV9mdW5jdGlvbnMnXCk7XCR0aGlzIjtpOjEzOTtzOjQyOiI9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpO2lmXCghZW1wdHkiO2k6MTQwO3M6Mzk6ImV2YWxcKFwkcGhwQ29kZVwpO31lbHNle2NsYXNzX2FsaWFzXChcJCI7aToxNDE7czo0ODoiZXZhbFwoXCRzdHJcKTt9cHVibGljIGZ1bmN0aW9uIGNvdW50TWVudUNoaWxkcmVuIjt9"));
$g_AdwareSig = unserialize(base64_decode("YToxNTk6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfUkVGRVJFUlsnIl1ccypcXVxzKixccypbJyJddHJ1c3RsaW5rXC5ydSI7aToxNjtzOjQyOiJcJFthLXpBLVowLTlfXStccyo9XHMqbmV3XHMqQlNcKFwpO1xzKmVjaG8iO2k6MTc7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxODtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE5O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MjA7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MjE7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIyO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjM7czoxNjY6Imlzc2V0XHMqXCg/XHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKD9ccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjQ7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCg/XHMqXCRsaWJfcGF0aCI7aToyNTtzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoP1xzKiI7aToyNjtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKT9ccyo7XHMqXD8+IjtpOjI3O3M6NzoibGV2aXRyYSI7aToyODtzOjEwOiJkYXBveGV0aW5lIjtpOjI5O3M6NjoidmlhZ3JhIjtpOjMwO3M6NjoiY2lhbGlzIjtpOjMxO3M6ODoicHJvdmlnaWwiO2k6MzI7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMztzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzQ7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjM1O3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzY7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM3O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM4O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM5O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTo0MDtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTo0MTtzOjEwOiJfX0xJTktfXzxhIjtpOjQyO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MztzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQ0O3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDU7czoxNToiX19MSU5LX19fX0VORF9fIjtpOjQ2O3M6MjI6Im5ld1xzK1RSVVNUTElOS19jbGllbnQiO2k6NDc7czo3NDoiclwucGhwXD9pZD1bYS16QS1aMC05X10rJnJlZmVyZXI9JXtIVFRQX0hPU1R9LyV7UkVRVUVTVF9VUkl9XHMrXFtSPTMwMixMXF0iO2k6NDg7czozOToiVXNlci1hZ2VudDpccypHb29nbGVib3RccypEaXNhbGxvdzpccyovIjtpOjQ5O3M6MTg6Im5ld1xzK0xMTV9jbGllbnRcKCI7aTo1MDtzOjM2OiImcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX0iO2k6NTE7czoyOToiXC5waHBcP2lkPVwkMSYle1FVRVJZX1NUUklOR30iO2k6NTI7czozMzoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjUzO3M6MjM6IkFkZEhhbmRsZXJccytwaHAtc2NyaXB0IjtpOjU0O3M6MjM6IkFkZEhhbmRsZXJccytjZ2ktc2NyaXB0IjtpOjU1O3M6NTI6IlJld3JpdGVSdWxlXHMrXC5cKlxzK2luZGV4XC5waHBcP3VybD1cJDBccytcW0wsUVNBXF0iO2k6NTY7czoxMjoicGhwaW5mb1woXCk7IjtpOjU3O3M6MTU6IlwobXNpZVx8b3BlcmFcKSI7aTo1ODtzOjIyOiI8aDE+TG9hZGluZ1wuXC5cLjwvaDE+IjtpOjU5O3M6Mjk6IkVycm9yRG9jdW1lbnRccys1MDBccytodHRwOi8vIjtpOjYwO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDBccytodHRwOi8vIjtpOjYxO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwOi8vIjtpOjYyO3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6NjM7czoxMDE6IjxzY3JpcHRccytsYW5ndWFnZT1bJyJdezAsMX1KYXZhU2NyaXB0WyciXXswLDF9PlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vIjtpOjY0O3M6OTk6ImNoclxzKlwoXHMqMTAxXHMqXClccypcLlxzKmNoclxzKlwoXHMqMTE4XHMqXClccypcLlxzKmNoclxzKlwoXHMqOTdccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMDhccypcKSI7aTo2NTtzOjMwOiJjdXJsXC5oYXh4XC5zZS9yZmMvY29va2llX3NwZWMiO2k6NjY7czoxODoiSm9vbWxhX2JydXRlX0ZvcmNlIjtpOjY3O3M6MzQ6IlJld3JpdGVDb25kXHMqJXtIVFRQOngtd2FwLXByb2ZpbGUiO2k6Njg7czo0MjoiUmV3cml0ZUNvbmRccyole0hUVFA6eC1vcGVyYW1pbmktcGhvbmUtdWF9IjtpOjY5O3M6NjY6IlJld3JpdGVDb25kXHMqJXtIVFRQOkFjY2VwdC1MYW5ndWFnZX1ccypcKHJ1XHxydS1ydVx8dWtcKVxzKlxbTkNcXSI7aTo3MDtzOjI2OiJzbGVzaFwrc2xlc2hcK2RvbWVuXCtwb2ludCI7aTo3MTtzOjE3OiJ0ZWxlZm9ubmF5YS1iYXphLSI7aTo3MjtzOjE4OiJpY3EtZGx5YS10ZWxlZm9uYS0iO2k6NzM7czoyNDoicGFnZV9maWxlcy9zdHlsZTAwMFwuY3NzIjtpOjc0O3M6MjA6InNwcmF2b2NobmlrLW5vbWVyb3YtIjtpOjc1O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjc2O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjc3O3M6MjY6ImluZGV4XC5waHBcP2lkPVwkMSYle1FVRVJZIjtpOjc4O3M6MjA6IlZvbGdvZ3JhZGluZGV4XC5odG1sIjtpOjc5O3M6Mzg6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLWNnaVxzK1wuIjtpOjgwO3M6MTk6Ii1rbHljaC1rLWlncmVcLmh0bWwiO2k6ODE7czoxOToibG1wX2NsaWVudFwoc3RyY29kZSI7aTo4MjtzOjE3OiIvXD9kbz1rYWstdWRhbGl0LSI7aTo4MztzOjE0OiIvXD9kbz1vc2hpYmthLSI7aTo4NDtzOjE5OiIvaW5zdHJ1a3RzaXlhLWRseWEtIjtpOjg1O3M6NDM6ImNvbnRlbnQ9IlxkKztVUkw9aHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS8iO2k6ODY7czo1OToiJTwhLS1cXHNcKlwkbWFya2VyXFxzXCotLT5cLlwrXD88IS0tXFxzXCovXCRtYXJrZXJcXHNcKi0tPiUiO2k6ODc7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aTo4ODtzOjQyOiJSZXdyaXRlUnVsZVxzKlwoXC5cK1wpXHMqaW5kZXhcLnBocFw/cz1cJDAiO2k6ODk7czoxODoiUmVkaXJlY3RccypodHRwOi8vIjtpOjkwO3M6NDU6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP2lkPVwkMSI7aTo5MTtzOjQ0OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9tPVwkMSI7aTo5MjtzOjE5ODoiXGIocGVyY29jZXR8YWRkZXJhbGx8dmlhZ3JhfGNpYWxpc3xsZXZpdHJhfGthdWZlbnxhbWJpZW58Ymx1ZVxzK3BpbGx8Y29jYWluZXxtYXJpanVhbmF8bGlwaXRvcnxwaGVudGVybWlufHByb1tzel1hY3xzYW5keWF1ZXJ8dHJhbWFkb2x8dHJveWhhbWJ5dWx0cmFtfHVuaWNhdWNhfHZhbGl1bXx2aWNvZGlufHhhbmF4fHlweGFpZW8pXHMrb25saW5lIjtpOjkzO3M6NDk6IlJld3JpdGVSdWxlXHMqXC5cKi9cLlwqXHMqW2EtekEtWjAtOV9dK1wucGhwXD9cJDAiO2k6OTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjk1O3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk2O3M6NTI6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/W2EtekEtWjAtOV9dKz0iO2k6OTc7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6OTg7czo1MToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXCRccytodHRwOi8vXGQrXC5cZCtcLlxkK1wuIjtpOjk5O3M6Njc6IjwhLS1jaGVjazpbJyJdXHMqXC5ccyptZDVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTAwO3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aToxMDE7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEwMjtzOjQyOiIle0hUVFBfVVNFUl9BR0VOVH1ccyshd2luZG93cy1tZWRpYS1wbGF5ZXIiO2k6MTAzO3M6ODI6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1ZYW5kZXhCb3QiO2k6MTA0O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX15YW5kZXgiO2k6MTA1O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1nb29nbGUiO2k6MTA2O3M6ODoiL2tyeWFraS8iO2k6MTA3O3M6MTA6IlwucGhwXD9cJDAiO2k6MTA4O3M6NzE6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjEwOTtzOjgwOiJpbmRleFwucGhwXD9tYWluX3BhZ2U9cHJvZHVjdF9pbmZvJnByb2R1Y3RzX2lkPVsnIl1ccypcLlxzKnN0cl9yZXBsYWNlXChbJyJdbGlzdCI7aToxMTA7czozMToiZnNvY2tvcGVuXChccypbJyJdc2hhZHlraXRcLmNvbSI7aToxMTE7czoxMDoiZW9qaWV1XC5jbiI7aToxMTI7czoyMjoiPlxzKjwvaWZyYW1lPlxzKjxcP3BocCI7aToxMTM7czo4MToiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfXJlZnJlc2hbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfVxkKztccyp1cmw9PFw/cGhwIjtpOjExNDtzOjgyOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9UmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKlVSTD1odHRwOi8vIjtpOjExNTtzOjY3OiJcJGZsXHMqPVxzKiI8bWV0YSBodHRwLWVxdWl2PVxcIlJlZnJlc2hcXCJccytjb250ZW50PVxcIlxkKztccypVUkw9IjtpOjExNjtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKnlhbmRleCI7aToxMTc7czozODoiUmV3cml0ZUNvbmRccyole0hUVFBfUkVGRVJFUn1ccypnb29nbGUiO2k6MTE4O3M6NTc6Ik9wdGlvbnNccytGb2xsb3dTeW1MaW5rc1xzK011bHRpVmlld3NccytJbmRleGVzXHMrRXhlY0NHSSI7aToxMTk7czoyODoiZ29vZ2xlXHx5YW5kZXhcfGJvdFx8cmFtYmxlciI7aToxMjA7czo0MToiY29udGVudD1bJyJdezAsMX0xO1VSTD1jZ2ktYmluXC5odG1sXD9jbWQiO2k6MTIxO3M6MTI6ImFuZGV4XHxvb2dsZSI7aToxMjI7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MTIzO3M6NDU6Ik1vemlsbGEvNVwuMFxzKlwoY29tcGF0aWJsZTtccypHb29nbGVib3QvMlwuMSI7aToxMjQ7czo1MDoiaHR0cDovL3d3d1wuYmluZ1wuY29tL3NlYXJjaFw/cT1cJHF1ZXJ5JnBxPVwkcXVlcnkiO2k6MTI1O3M6NDM6Imh0dHA6Ly9nb1wubWFpbFwucnUvc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnkiO2k6MTI2O3M6NjM6Imh0dHA6Ly93d3dcLmdvb2dsZVwuY29tL3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5XC5bJyJdJmhsPVwkbGFuZyI7aToxMjc7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEyODtzOjQ5OiJpZlwoc3RyaXBvc1woXCR1YSxbJyJdYW5kcm9pZFsnIl1cKVxzKiE9PVxzKmZhbHNlIjtpOjEyOTtzOjE1MjoiKHNleHlccytsZXNiaWFuc3xjdW1ccyt2aWRlb3xzZXhccyt2aWRlb3xBbmFsXHMrRnVja3x0ZWVuXHMrc2V4fGZ1Y2tccyt2aWRlb3xCZWFjaFxzK051ZGV8d29tYW5ccytwdXNzeXxzZXhccytwaG90b3xuYWtlZFxzK3RlZW58eHh4XHMrdmlkZW98dGVlblxzK3BpYykiO2k6MTMwO3M6NTY6Imh0dHAtZXF1aXY9WyciXUNvbnRlbnQtTGFuZ3VhZ2VbJyJdXHMrY29udGVudD1bJyJdamFbJyJdIjtpOjEzMTtzOjU2OiJodHRwLWVxdWl2PVsnIl1Db250ZW50LUxhbmd1YWdlWyciXVxzK2NvbnRlbnQ9WyciXWNoWyciXSI7aToxMzI7czoxMToiS0FQUFVTVE9CT1QiO2k6MTMzO3M6Mzg6ImNsYXNzXHMrbFRyYW5zbWl0ZXJ7XHMqdmFyXHMqXCR2ZXJzaW9uIjtpOjEzNDtzOjM3OiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXS90bXAvc3Nlc3NfIjtpOjEzNTtzOjkxOiJmaWxlX2dldF9jb250ZW50c1woYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rXClcLlsnIl1cP1snIl1cLmh0dHBfYnVpbGRfcXVlcnlcKFwkX0dFVFwpIjtpOjEzNjtzOjUwOiJpbmlfc2V0XChbJyJdezAsMX11c2VyX2FnZW50WyciXVxzKixccypbJyJdSlNMSU5LUyI7aToxMzc7czo2MzoiXCRkYi0+cXVlcnlcKFsnIl1TRUxFQ1QgXCogRlJPTSBhcnRpY2xlIFdIRVJFIHVybD1bJyJdXCRyZXF1ZXN0IjtpOjEzODtzOjI0OiI8aHRtbFxzK2xhbmc9WyciXWphWyciXT4iO2k6MTM5O3M6Mzc6InhtbDpsYW5nPVsnIl1qYVsnIl1ccytsYW5nPVsnIl1qYVsnIl0iO2k6MTQwO3M6MTY6Imxhbmc9WyciXWphWyciXT4iO2k6MTQxO3M6MzM6InN0cnBvc1woXCRpbSxbJyJdXFsvVVBEX0NPTlRFTlRcXSI7aToxNDI7czo1OToiPT1ccypbJyJdaW5kZXhcLnBocFsnIl1cKVxzKntccypwcmludFxzK2ZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTQzO3M6MTU6ImNsYXNzXHMrRmF0bGluayI7aToxNDQ7czo0MDoiXCRmPWZpbGVfZ2V0X2NvbnRlbnRzXCgia2V5cy8iXC5cJGtleWZcKSI7aToxNDU7czo1NjoiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXFxcLmh0bWxcJFxzK2luZGV4XC5waHBccytcW25jXF0iO2k6MTQ2O3M6NDU6Im1rZGlyXChbJyJdcGFnZS9bJyJdXC5tYl9zdWJzdHJcKG1kNVwoXCRrZXlcKSI7aToxNDc7czo0NzoiZWxzZWlmIFwoQFwkX0dFVFxbWyciXXBbJyJdXF0gPT0gWyciXWh0bWxbJyJdXCkiO2k6MTQ4O3M6ODg6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVxcL1wkXHMraW5kZXhcLnBocFxzK1Jld3JpdGVSdWxlXHMrXF5yb2JvdHNcLnR4dFwkXHMrcm9ib3RzXC5waHAiO2k6MTQ5O3M6MTE1OiJpZlwoc3RyaXBvc1woXCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdLFxzKlsnIl1Hb29nbGVib3RbJyJdXClccyohPT1ccypmYWxzZVwpe1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjE1MDtzOjIxOiJcJHBhdGhfdG9fZG9yXHMqPVxzKiIiO2k6MTUxO3M6Mzk6InN0cnJldlwoc3RydG91cHBlclwoWyciXXRuZWdhX3Jlc3VfcHR0aCI7aToxNTI7czo2MjoiZmlsZV9wdXRfY29udGVudHNcKFsnIl1jb25mXC5waHBbJyJdXHMqLFxzKlsnIl1cXG5cXFwkc3RvcHBhZ2UiO2k6MTUzO3M6MzM6InNlc3Npb25fbmFtZVwoWyciXXVzZXJvaW50ZXJmZWlzbyI7aToxNTQ7czo4MToiUmV3cml0ZVJ1bGVccypcXlwoXFtBLVphLXowLTktXF1cK1wpXC5odG1sXCRccypbYS16QS1aMC05X10rXC5waHBcP2hsPVwkMVxzKlxbTFxdIjtpOjE1NTtzOjc5OiJcJGlkXHMqPVxzKlwkX1JFUVVFU1RcW1snIl1pZFsnIl1cXTtccypcJGNoXHMqPVxzKmN1cmxfaW5pdFwoXCk7XHMqXCR1cmxfc3RyaW5nIjtpOjE1NjtzOjYwOiJcJHBhZ2VwYXJzZT1maWxlX2dldF9jb250ZW50c1woImh0dHA6Ly93d3dcLmFza1wuY29tL3dlYlw/cT0iO2k6MTU3O3M6NjQ6IjxNRVRBXHMqSFRUUC1FUVVJVj1bJyJdcmVmcmVzaFsnIl1ccypDT05URU5UPVsnIl0wXC5cZCs7VVJMPWh0dHAiO2k6MTU4O3M6NTE6ImZ1bmN0aW9uXHMrcmVkaXJUaW1lclwoXHMqXClccyp7XHMqc2VsZlwuc2V0VGltZW91dCI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YToxMDM6e2k6MDtzOjExOiJDVlY6XHMqXCRjdiI7aToxO3M6MTM6IkludmFsaWRccytUVk4iO2k6MjtzOjExOiJJbnZhbGlkIFJWTiI7aTozO3M6NDA6ImRlZmF1bHRTdGF0dXNccyo9XHMqWyciXUludGVybmV0IEJhbmtpbmciO2k6NDtzOjI4OiI8dGl0bGU+XHMqQ2FwaXRlY1xzK0ludGVybmV0IjtpOjU7czoyNzoiPHRpdGxlPlxzKkludmVzdGVjXHMrT25saW5lIjtpOjY7czozOToiaW50ZXJuZXRccytQSU5ccytudW1iZXJccytpc1xzK3JlcXVpcmVkIjtpOjc7czoxMToiPHRpdGxlPlNhcnMiO2k6ODtzOjEzOiI8YnI+QVRNXHMrUElOIjtpOjk7czoxODoiQ29uZmlybWF0aW9uXHMrT1RQIjtpOjEwO3M6MjU6Ijx0aXRsZT5ccypBYnNhXHMrSW50ZXJuZXQiO2k6MTE7czoyMToiLVxzKlBheVBhbFxzKjwvdGl0bGU+IjtpOjEyO3M6MTk6Ijx0aXRsZT5ccypQYXlccypQYWwiO2k6MTM7czoyMjoiLVxzKlByaXZhdGlccyo8L3RpdGxlPiI7aToxNDtzOjE5OiI8dGl0bGU+XHMqVW5pQ3JlZGl0IjtpOjE1O3M6MTk6IkJhbmtccytvZlxzK0FtZXJpY2EiO2k6MTY7czoyNToiQWxpYmFiYSZuYnNwO01hbnVmYWN0dXJlciI7aToxNztzOjIwOiJWZXJpZmllZFxzK2J5XHMrVmlzYSI7aToxODtzOjIxOiJIb25nXHMrTGVvbmdccytPbmxpbmUiO2k6MTk7czozMDoiWW91clxzK2FjY291bnRccytcfFxzK0xvZ1xzK2luIjtpOjIwO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUgQmFua2luZyI7aToyMTtzOjI0OiI8dGl0bGU+XHMqT25saW5lLUJhbmtpbmciO2k6MjI7czoyMjoiU2lnblxzK2luXHMrdG9ccytZYWhvbyI7aToyMztzOjE2OiJZYWhvb1xzKjwvdGl0bGU+IjtpOjI0O3M6MTE6IkJBTkNPTE9NQklBIjtpOjI1O3M6MTY6Ijx0aXRsZT5ccypBbWF6b24iO2k6MjY7czoxNToiPHRpdGxlPlxzKkFwcGxlIjtpOjI3O3M6MTU6Ijx0aXRsZT5ccypHbWFpbCI7aToyODtzOjI4OiJHb29nbGVccytBY2NvdW50c1xzKjwvdGl0bGU+IjtpOjI5O3M6MjU6Ijx0aXRsZT5ccypHb29nbGVccytTZWN1cmUiO2k6MzA7czozMToiPHRpdGxlPlxzKk1lcmFrXHMrTWFpbFxzK1NlcnZlciI7aTozMTtzOjI2OiI8dGl0bGU+XHMqU29ja2V0XHMrV2VibWFpbCI7aTozMjtzOjIxOiI8dGl0bGU+XHMqXFtMX1FVRVJZXF0iO2k6MzM7czozNDoiPHRpdGxlPlxzKkFOWlxzK0ludGVybmV0XHMrQmFua2luZyI7aTozNDtzOjMzOiJjb21cLndlYnN0ZXJiYW5rXC5zZXJ2bGV0c1wuTG9naW4iO2k6MzU7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjM2O3M6MTg6Ijx0aXRsZT5ccypGYWNlYm9vayI7aTozNztzOjM2OiJcZCs7VVJMPWh0dHBzOi8vd3d3XC53ZWxsc2ZhcmdvXC5jb20iO2k6Mzg7czoyMzoiPHRpdGxlPlxzKldlbGxzXHMqRmFyZ28iO2k6Mzk7czo0OToicHJvcGVydHk9Im9nOnNpdGVfbmFtZSJccypjb250ZW50PSJGYWNlYm9vayJccyovPiI7aTo0MDtzOjIyOiJBZXNcLkN0clwuZGVjcnlwdFxzKlwoIjtpOjQxO3M6MTc6Ijx0aXRsZT5ccypBbGliYWJhIjtpOjQyO3M6MTk6IlJhYm9iYW5rXHMqPC90aXRsZT4iO2k6NDM7czozNToiXCRtZXNzYWdlXHMqXC49XHMqWyciXXswLDF9UGFzc3dvcmQiO2k6NDQ7czo2MzoiXCRDVlYyQ1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXUNWVjJDIjtpOjQ1O3M6MTQ6IkNWVjI6XHMqXCRDVlYyIjtpOjQ2O3M6MTg6IlwuaHRtbFw/Y21kPWxvZ2luPSI7aTo0NztzOjE4OiJXZWJtYWlsXHMqPC90aXRsZT4iO2k6NDg7czoyMzoiPHRpdGxlPlxzKlVQQ1xzK1dlYm1haWwiO2k6NDk7czoxNzoiXC5waHBcP2NtZD1sb2dpbj0iO2k6NTA7czoxNzoiXC5odG1cP2NtZD1sb2dpbj0iO2k6NTE7czoyMzoiXC5zd2VkYmFua1wuc2UvbWRwYXlhY3MiO2k6NTI7czoyNDoiXC5ccypcJF9QT1NUXFtccypbJyJdY3Z2IjtpOjUzO3M6MjA6Ijx0aXRsZT5ccypMQU5ERVNCQU5LIjtpOjU0O3M6MTA6IkJZLVNQMU4wWkEiO2k6NTU7czo0NToiU2VjdXJpdHlccytxdWVzdGlvblxzKzpccytbJyJdXHMqXC5ccypcJF9QT1NUIjtpOjU2O3M6NDA6ImlmXChccypmaWxlX2V4aXN0c1woXHMqXCRzY2FtXHMqXC5ccypcJGkiO2k6NTc7czoyMDoiPHRpdGxlPlxzKkJlc3QudGlnZW4iO2k6NTg7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTk7czo1Mjoid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaW5kZXhcZCs/XC5waHBcP2NtZD1sb2dpbiI7aTo2MDtzOjU0OiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKz9cLmh0bWw/XD9jbWQ9bG9naW4iO2k6NjE7czoyNToiPHRpdGxlPlxzKk1haWxccyo8L3RpdGxlPiI7aTo2MjtzOjI4OiJTaWVccytJaHJccytLb250b1xzKjwvdGl0bGU+IjtpOjYzO3M6Mjk6IlBheXBhbFxzK0tvbnRvXHMrdmVyaWZpemllcmVuIjtpOjY0O3M6MzA6IlwkX0dFVFxbXHMqWyciXWNjX2NvdW50cnlfY29kZSI7aTo2NTtzOjI5OiI8dGl0bGU+T3V0bG9va1xzK1dlYlxzK0FjY2VzcyI7aTo2NjtzOjk6Il9DQVJUQVNJXyI7aTo2NztzOjc2OiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXJlZnJlc2hbJyJdXHMqY29udGVudD0iXGQrO1xzKnVybD1kYXRhOnRleHQvaHRtbDtodHRwIjtpOjY4O3M6MzA6ImNhblxzKnNpZ25ccyppblxzKnRvXHMqZHJvcGJveCI7aTo2OTtzOjM1OiJcZCs7XHMqVVJMPWh0dHBzOi8vd3d3XC5nb29nbGVcLmNvbSI7aTo3MDtzOjI2OiJtYWlsXC5ydS9zZXR0aW5ncy9zZWN1cml0eSI7aTo3MTtzOjU5OiJMb2NhdGlvbjpccypodHRwczovL3NlY3VyaXR5XC5nb29nbGVcLmNvbS9zZXR0aW5ncy9zZWN1cml0eSI7aTo3MjtzOjY1OiJcJGlwXHMqPVxzKmdldGVudlwoXHMqWyciXVJFTU9URV9BRERSWyciXVxzKlwpO1xzKlwkbWVzc2FnZVxzKlwuPSI7aTo3MztzOjE3OiJsb2dpblwuZWMyMVwuY29tLyI7aTo3NDtzOjYwOiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9Y3Z2WyciXXswLDF9XF0iO2k6NzU7czozNDoiXCRhZGRkYXRlPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NjtzOjM2OiJcJGRhdGFtYXNpaT1kYXRlXCgiRCBNIGQsIFkgZzppIGEiXCkiO2k6Nzc7czoyNzoiaHR0cHM6Ly9hcHBsZWlkXC5hcHBsZVwuY29tIjtpOjc4O3M6MTQ6Ii1BcHBsZV9SZXN1bHQtIjtpOjc5O3M6MTM6IkFPTFxzK0RldGFpbHMiO2k6ODA7czo0MzoiXCRfUE9TVFxbXHMqWyciXXswLDF9ZU1haWxBZGRbJyJdezAsMX1ccypcXSI7aTo4MTtzOjQwOiJiYXNlXHMraHJlZj1bJyJdaHR0cHM6Ly9sb2dpblwubGl2ZVwuY29tIjtpOjgyO3M6MjQ6Ijx0aXRsZT5Ib3RtYWlsXHMrQWNjb3VudCI7aTo4MztzOjQxOiI8IS0tXHMrc2F2ZWRccytmcm9tXHMrdXJsPVwoXGQrXClodHRwczovLyI7aTo4NDtzOjIwOiJCYW5rXHMrb2ZccytNb250cmVhbCI7aTo4NTtzOjIxOiJzZWN1cmVcLnRhbmdlcmluZVwuY2EiO2k6ODY7czoyMjoiYm1vXC5jb20vb25saW5lYmFua2luZyI7aTo4NztzOjQxOiJwbV9mcD12ZXJzaW9uJnN0YXRlPTEmc2F2ZUZCQz0mRkJDX051bWJlciI7aTo4ODtzOjIxOiJjaWJjb25saW5lXC5jaWJjXC5jb20iO2k6ODk7czozMToiaHR0cHM6Ly93d3dcLnRkY2FuYWRhdHJ1c3RcLmNvbSI7aTo5MDtzOjI2OiJWaXNpdGVkIFREIEJBTks6XHMqIlwuXCRpcCI7aTo5MTtzOjYyOiJ3aW5kb3dcLmxvY2F0aW9uPSJpbmRleFwuaHRtbFw/Y21kPWxvZ2luPXVzbWFpbD1jaGVjaz12YWxpZGF0ZSI7aTo5MjtzOjIwOiI8VElUTEU+QU9MXHMqQmlsbGluZyI7aTo5MztzOjMzOiI8dGl0bGU+RG93bmxvYWQgWW91ciBGaWxlPC90aXRsZT4iO2k6OTQ7czoyMToiPHRpdGxlPkFjZXNzXHMrUGF5UGFsIjtpOjk1O3M6NDg6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqJ2h0dHBzOi8vd3d3XC5wYXlwYWxcLmNvbSI7aTo5NjtzOjIwOiJzeXN0ZW0vc2VuZF9jY3ZcLnBocCI7aTo5NztzOjI2OiJcLnBocFw/d2Vic3JjPSJccypcLlxzKm1kNSI7aTo5ODtzOjMzOiI8dGl0bGU+TG9nZ2luZ1xzK2luXHMrLVxzKyZSaG87YXkiO2k6OTk7czo0MToiXCRibG9ja2VkX3dvcmRzXHMqPVxzKmFycmF5XChccypbJyJdZHJ3ZWIiO2k6MTAwO3M6MzI6IkFsbFxzKmZvclxzKnlvdVxzKiFccypHb29kXHMqQm95IjtpOjEwMTtzOjMzOiJZb3VyIHNlY3VyaXR5IGlzIG91ciB0b3AgcHJpb3JpdHkiO2k6MTAyO3M6MTM6InRhbmdlcmluZVwuY2EiO30="));
$g_JSVirSig = unserialize(base64_decode("YTozMDk6e2k6MDtzOjk1OiI8c2NyaXB0PnZhciBcdz0nJztccypzZXRUaW1lb3V0XChcZCtcKTsuKz9kZWZhdWx0X2tleS4rP3NlX3JlLis/ZGVmYXVsdF9rZXkuKz9mX3VybC4rPzwvc2NyaXB0PiI7aToxO3M6MTE0OiI8c2NyaXB0W14+XSs+dmFyIGE9Lis/U3RyaW5nXC5mcm9tQ2hhckNvZGVcKGFcLmNoYXJDb2RlQXRcKGlcKVxeMlwpfWM9dW5lc2NhcGVcKGJcKTtkb2N1bWVudFwud3JpdGVcKGNcKTs8L3NjcmlwdD4iO2k6MjtzOjI1MDoidmFyIFx3Kz1cWyJcZCsiLC4rPyJcZCsiXF07ZnVuY3Rpb24gXHcrXChcdytcKXt2YXIgXHcrPWRvY3VtZW50XFtcdytcKFx3K1xbXGQrXF1cKVxdXChcdytcKFx3K1xbXGQrXF1cKVwrXHcrXChcdytcW1xkK1xdXCkuKz9TdHJpbmdcLmZyb21DaGFyQ29kZVwoXHcrXC5zbGljZVwoXHcrLC4rP2Vsc2UgXHcrXCtcKzt9cmV0dXJuXChcdytcKTt9KGZ1bmN0aW9uIFx3K1woXHcrXCl7cmV0dXJuIFx3K1woXHcrXChcdytcKSwnXHcrJ1wpO30pPyI7aTozO3M6Mjg0OiJmdW5jdGlvblxzXHcrXChcdyssXHNcdytcKVxze3ZhclxzXHcrPScnO3ZhclxzXHcrPTA7dmFyXHNcdys9MDtmb3JcKFx3Kz0wO1x3KzxcdytcLmxlbmd0aDtcdytcK1wrXCl7dmFyXHNcdys9XHcrXC5jaGFyQXRcKFx3K1wpO3ZhclxzXHcrPVx3K1wuY2hhckNvZGVBdFwoMFwpXF5cdytcLmNoYXJDb2RlQXRcKFx3K1wpO1x3Kz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoXHcrXCk7XHcrXCs9XHcrO2lmXChcdys9PVx3K1wubGVuZ3RoLTFcKVx3Kz0wO2Vsc2Vcc1x3K1wrXCs7fXJldHVyblwoXHcrXCk7fSI7aTo0O3M6MTE4OiIvXCpcd3szMn1cKi9ccyp2YXJccytfMHhcdys9XFsuKz9dXT1mdW5jdGlvblwoXCl7ZnVuY3Rpb24uKz9cKX1lbHNlIHtyZXR1cm4gZmFsc2V9O3JldHVybiBfMHguKz9cKTt9O307XHMqL1wqXHd7MzJ9XCovIjtpOjU7czo0OToiL1wqXHd7MzJ9XCovXHMqO1xzKndpbmRvd1xbIlx4XGR7Mn0uKi9cKlx3ezMyfVwqLyI7aTo2O3M6OTI6Ii9cKlx3ezMyfVwqLztcKGZ1bmN0aW9uXChcKXt2YXJccypcdys9IiI7dmFyXHMqXHcrPSJcdysiO2Zvci4rP1wpXCk7fVwpXChcKTsvXCpcd3szMn1cKi9ccyokIjtpOjc7czoyNzM6IjxzY3JpcHQ+ZnVuY3Rpb24gXHcrXChcdytcKXt2YXIgXHcrPVxkKyxcdys9XGQrO3ZhciBcdys9J1xkKy1cZCssXGQrLVxkKy4rP2Z1bmN0aW9uIFx3K1woXHcrXCl7XHMqd2luZG93XC5ldmFsXChcKTtccyp9Lis/PHNjcmlwdD5mdW5jdGlvbiBcdytcKFwpe2lmIFwobmF2aWdhdG9yXC51c2VyQWdlbnRcLmluZGV4T2ZcKCJNU0lFLis/ZnJvbUNoYXJDb2RlXChccypcKFx3K1wuY2hhckNvZGVBdFwoXHcrXCtcZCtcKS1cZCtcKVxzKlxeXHMqXHcrXClccypcKTt9fTwvc2NyaXB0PiI7aTo4O3M6MjMxOiJcKGZ1bmN0aW9uXChcKXt2YXJccy49IlwoXHcrXChcdytcKWZcLlx3Kyw9XHcrXC9cKVx3K1wpJ1x3K1wvXClcdytcKScuXClcdytcKCc9XClcdytcL1xbO1woXHcrXD9cITE9XHcrJ1wpXF1cdytcKFx3Kz1cdyssPVx3K1wuXHcrJz1cdytcKFx3K1woXHcrXCtcKVx3KycuPVx3K1wrXHcrXCEnXHcrIVx3KyZcdytcKFx3K1wpLVx7XHcrXChcdytcKFx3K1wuXHcrXC4uKz9ldmFsXChcdytcKTtcfVwoXClcKTsiO2k6OTtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxMDtzOjIzOiJBdFsnIl1cXVwodlwrXCtcKS0xXClcKSI7aToxMTtzOjMyOiJDbGlja1VuZGVyY29va2llXHMqPVxzKkdldENvb2tpZSI7aToxMjtzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjEzO3M6MjI6IlwucHJvdG90eXBlXC5hfWNhdGNoXCgiO2k6MTQ7czozNzoidHJ5e0Jvb2xlYW5cKFwpXC5wcm90b3R5cGVcLnF9Y2F0Y2hcKCI7aToxNTtzOjg2OiJpbmRleE9mXHxpZlx8cmNcfGxlbmd0aFx8bXNuXHx5YWhvb1x8cmVmZXJyZXJcfGFsdGF2aXN0YVx8b2dvXHxiaVx8aHBcfHZhclx8YW9sXHxxdWVyeSI7aToxNjtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6MTc7czo4MjoicT1kb2N1bWVudFwuY3JlYXRlRWxlbWVudFwoImQiXCsiaSJcKyJ2IlwpO3FcLmFwcGVuZENoaWxkXChxXCsiIlwpO31jYXRjaFwocXdcKXtoPSI7aToxODtzOjc5OiJcK3p6O3NzPVxbXF07Zj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7dz10aGlzO2U9d1xbZlxbInN1YnN0ciJcXVwoIjtpOjE5O3M6MTE1OiJzNVwocTVcKXtyZXR1cm4gXCtcK3E1O31mdW5jdGlvbiB5Zlwoc2Ysd2VcKXtyZXR1cm4gc2ZcLnN1YnN0clwod2UsMVwpO31mdW5jdGlvbiB5MVwod2JcKXtpZlwod2I9PTE2OFwpd2I9MTAyNTtlbHNlIjtpOjIwO3M6NjQ6ImlmXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFwubWF0Y2hcKC9cKGFuZHJvaWRcfG1pZHBcfGoybWVcfHN5bWJpYW4iO2k6MjE7czoxMDY6ImRvY3VtZW50XC53cml0ZVwoJzxzY3JpcHQgbGFuZ3VhZ2U9IkphdmFTY3JpcHQiIHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSInXCtkb21haW5cKyciPjwvc2NyJ1wrJ2lwdD4nXCkiO2k6MjI7czozMDoiaHR0cDovL1x3K1wucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjIzO3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToyNDtzOjIyOiIiZnIiXCsib21DIlwrImhhckNvZGUiIjtpOjI1O3M6MTE6Ij0iZXYiXCsiYWwiIjtpOjI2O3M6Nzg6IlxbXChcKGVcKVw/InMiOiIiXClcKyJwIlwrImxpdCJcXVwoImFcJCJcW1woXChlXClcPyJzdSI6IiJcKVwrImJzdHIiXF1cKDFcKVwpOyI7aToyNztzOjM5OiJmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzsiO2k6Mjg7czoyMDoiZlwrPVwoaFwpXD8nb2RlJzoiIjsiO2k6Mjk7czo0MToiZj0nZidcKydyJ1wrJ28nXCsnbSdcKydDaCdcKydhckMnXCsnb2RlJzsiO2k6MzA7czo1MDoiZj0nZnJvbUNoJztmXCs9J2FyQyc7ZlwrPSdxZ29kZSdcWyJzdWJzdHIiXF1cKDJcKTsiO2k6MzE7czoxNjoidmFyXHMrZGl2X2NvbG9ycyI7aTozMjtzOjIwOiJDb3JlTGlicmFyaWVzSGFuZGxlciI7aTozMztzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjM0O3M6MTg6IlwuYml0Y29pbnBsdXNcLmNvbSI7aTozNTtzOjQxOiJcLnNwbGl0XCgiJiYiXCk7aD0yO3M9IiI7aWZcKG1cKWZvclwoaT0wOyI7aTozNjtzOjQ1OiIzQmZvclx8ZnJvbUNoYXJDb2RlXHwyQzI3XHwzRFx8MkM4OFx8dW5lc2NhcGUiO2k6Mzc7czo1ODoiO1xzKmRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PGlmcmFtZVxzKnNyYz0iaHR0cDovL3lhXC5ydSI7aTozODtzOjExMDoiaWZcKCFnXChcKSYmd2luZG93XC5uYXZpZ2F0b3JcLmNvb2tpZUVuYWJsZWRcKXtkb2N1bWVudFwuY29va2llPSIxPTE7ZXhwaXJlcz0iXCtlXC50b0dNVFN0cmluZ1woXClcKyI7cGF0aD0vIjsiO2k6Mzk7czo3MDoibm5fcGFyYW1fcHJlbG9hZGVyX2NvbnRhaW5lclx8NTAwMVx8aGlkZGVuXHxpbm5lckhUTUxcfGluamVjdFx8dmlzaWJsZSI7aTo0MDtzOjI5OiI8IS0tW2EtekEtWjAtOV9dK1x8XHxzdGF0IC0tPiI7aTo0MTtzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjQyO3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo0MztzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo0NDtzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo0NTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjQ2O3M6MTIzOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFwuXCRcP1wqXHx7fVxcKFxcKVxcW1xcXVwvXFwrXF5cXVwpL2ciO2k6NDc7czo4Njoic2V0Q29va2llXHMqXCgqXHMqImFyeF90dCJccyosXHMqMVxzKixccypkdFwudG9HTVRTdHJpbmdcKFwpXHMqLFxzKlsnIl17MCwxfS9bJyJdezAsMX0iO2k6NDg7czoxMzc6ImRvY3VtZW50XC5jb29raWVcLm1hdGNoXHMqXChccypuZXdccytSZWdFeHBccypcKFxzKiJcKFw/OlxeXHw7XHMqXCkiXHMqXCtccypuYW1lXC5yZXBsYWNlXHMqXCgvXChcW1xcLlwkXD9cKlx8e31cXChcXClcXFtcXF1cL1xcK1xeXF1cKS9nIjtpOjQ5O3M6OTg6InZhclxzK2R0XHMrPVxzK25ld1xzK0RhdGVcKFwpLFxzK2V4cGlyeVRpbWVccys9XHMrZHRcLnNldFRpbWVcKFxzK2R0XC5nZXRUaW1lXChcKVxzK1wrXHMrOTAwMDAwMDAwIjtpOjUwO3M6MTA1OiJpZlxzKlwoXHMqbnVtXHMqPT09XHMqMFxzKlwpXHMqe1xzKnJldHVyblxzKjE7XHMqfVxzKmVsc2Vccyp7XHMqcmV0dXJuXHMrbnVtXHMqXCpccypyRmFjdFwoXHMqbnVtXHMqLVxzKjEiO2k6NTE7czo0MToiXCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCgwXCsneCciO2k6NTI7czo4MzoiPHNjcmlwdFxzK2xhbmd1YWdlPSJKYXZhU2NyaXB0Ij5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj0iaHR0cDovL3ZrXC5jb20iO2k6NTM7czo0NDoibG9jYXRpb25cLnJlcGxhY2VcKFsnIl17MCwxfWh0dHA6Ly92NWs0NVwucnUiO2k6NTQ7czoxMjk6Ijt0cnl7XCtcK2RvY3VtZW50XC5ib2R5fWNhdGNoXChxXCl7YWE9ZnVuY3Rpb25cKGZmXCl7Zm9yXChpPTA7aTx6XC5sZW5ndGg7aVwrXCtcKXt6YVwrPVN0cmluZ1xbZmZcXVwoZVwodlwrXCh6XFtpXF1cKVwpLTEyXCk7fX07fSI7aTo1NTtzOjE0MjoiZG9jdW1lbnRcLndyaXRlXHMqXChbJyJdezAsMX08WyciXXswLDF9XHMqXCtccyp4XFswXF1ccypcK1xzKlsnIl17MCwxfSBbJyJdezAsMX1ccypcK1xzKnhcWzRcXVxzKlwrXHMqWyciXXswLDF9PlwuWyciXXswLDF9XHMqXCt4XHMqXFsyXF1ccypcKyI7aTo1NjtzOjYwOiJpZlwodFwubGVuZ3RoPT0yXCl7elwrPVN0cmluZ1wuZnJvbUNoYXJDb2RlXChwYXJzZUludFwodFwpXCsiO2k6NTc7czo3NDoid2luZG93XC5vbmxvYWRccyo9XHMqZnVuY3Rpb25cKFwpXHMqe1xzKmlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXCgiO2k6NTg7czo5NzoiXC5zdHlsZVwuaGVpZ2h0XHMqPVxzKlsnIl17MCwxfTBweFsnIl17MCwxfTt3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7ZG9jdW1lbnRcLmNvb2tpZSI7aTo1OTtzOjEyMjoiXC5zcmM9XChbJyJdezAsMX1odHBzOlsnIl17MCwxfT09ZG9jdW1lbnRcLmxvY2F0aW9uXC5wcm90b2NvbFw/WyciXXswLDF9aHR0cHM6Ly9zc2xbJyJdezAsMX06WyciXXswLDF9aHR0cDovL1snIl17MCwxfVwpXCsiO2k6NjA7czozMDoiNDA0XC5waHBbJyJdezAsMX0+XHMqPC9zY3JpcHQ+IjtpOjYxO3M6NzY6InByZWdfbWF0Y2hcKFsnIl17MCwxfS9zYXBlL2lbJyJdezAsMX1ccyosXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1JFRkVSRVIiO2k6NjI7czo3NDoiZGl2XC5pbm5lckhUTUxccypcKz1ccypbJyJdezAsMX08ZW1iZWRccytpZD0iZHVtbXkyIlxzK25hbWU9ImR1bW15MiJccytzcmMiO2k6NjM7czo3Mzoic2V0VGltZW91dFwoWyciXXswLDF9YWRkTmV3T2JqZWN0XChcKVsnIl17MCwxfSxcZCtcKTt9fX07YWRkTmV3T2JqZWN0XChcKSI7aTo2NDtzOjUxOiJcKGI9ZG9jdW1lbnRcKVwuaGVhZFwuYXBwZW5kQ2hpbGRcKGJcLmNyZWF0ZUVsZW1lbnQiO2k6NjU7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo2NjtzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjY3O3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjY4O3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo2OTtzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjcwO3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjcxO3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo3MjtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo3MztzOjEwNToiY2hlY2tfdXNlcl9hZ2VudD1cW1xzKlsnIl17MCwxfUx1bmFzY2FwZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1pUGhvbmVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9TWFjaW50b3NoIjtpOjc0O3M6MTUzOiJkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxbJyJdezAsMX1cK1snIl17MCwxfWlbJyJdezAsMX1cK1snIl17MCwxfWZbJyJdezAsMX1cK1snIl17MCwxfXJbJyJdezAsMX1cK1snIl17MCwxfWFbJyJdezAsMX1cK1snIl17MCwxfW1bJyJdezAsMX1cK1snIl17MCwxfWUiO2k6NzU7czo0ODoic3RyaXBvc1wobmF2aWdhdG9yXC51c2VyQWdlbnRccyosXHMqbGlzdF9kYXRhXFtpIjtpOjc2O3M6MjY6ImlmXHMqXCghc2VlX3VzZXJfYWdlbnRcKFwpIjtpOjc3O3M6NzA6IjxzY3JpcHRccyp0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzKnNyYz1bJyJdezAsMX1mdHA6Ly8iO2k6Nzg7czo0ODoiaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKFsnIl17MCwxfXNhYnJpIjtpOjc5O3M6MTE0OiJcKTtccyppZlwoXHMqW2EtekEtWjAtOV9dK1wudGVzdFwoXHMqZG9jdW1lbnRcLnJlZmVycmVyXHMqXClccyomJlxzKlthLXpBLVowLTlfXStcKVxzKntccypkb2N1bWVudFwubG9jYXRpb25cLmhyZWYiO2k6ODA7czo1MjoiaWZcKC9BbmRyb2lkL2lcW18weFthLXpBLVowLTlfXStcW1xkK1xdXF1cKG5hdmlnYXRvciI7aTo4MTtzOjY5OiJmdW5jdGlvblwoYVwpe2lmXChhJiZbJyJdZGF0YVsnIl1pblxkK2EmJmFcLmRhdGFcLmFcZCsmJmFcLmRhdGFcLmFcZCsiO2k6ODI7czo5ODoiPFxkK1xzK1xkKz1bJyJdXGQrL1xkK1xbJyJdXCtcWyciXS5cWyciXVwrXFsnIl0uWyciXVxzKy49WyciXS46Ly9cZCtcWyciXVwrXFsnIl0uXC5cZCtcWyciXVwrXFsnIl0iO2k6ODM7czo5ODoiPWRvY3VtZW50XC5yZWZlcnJlcjtpZlwoUmVmXC5pbmRleE9mXChbJyJdXC5nb29nbGVcLlsnIl1cKSE9LTFcfFx8UmVmXC5pbmRleE9mXChbJyJdXC5iaW5nXC5bJyJdXCkiO2k6ODQ7czoyMDoidmlzaXRvclRyYWNrZXJfaXNNb2IiO2k6ODU7czo0MDoiL1wqXHd7MzJ9XCovdmFyXHMrXzB4W2EtekEtWjAtOV9dKz1cWyJceCI7aTo4NjtzOjcxOiIvXCpcd3szMn1cKi87d2luZG93XFtbJyJdZG9jdW1lbnRbJyJdXF1cW1snIl1bYS16QS1aMC05X10rWyciXVxdPVxbWyciXSI7aTo4NztzOjQ2OiJcXVxdXC5qb2luXChcWyciXVxbJyJdXCk7WyciXVwpXCk7L1wqXHd7MzJ9XCovIjtpOjg4O3M6MTM0OiI7dmFyXHMrW2EtekEtWjAtOV9dKz1bYS16QS1aMC05X10rXC5jaGFyQ29kZUF0XChcZCtcKVxeW2EtekEtWjAtOV9dK1wuY2hhckNvZGVBdFwoW2EtekEtWjAtOV9dK1wpO1thLXpBLVowLTlfXSs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKCI7aTo4OTtzOjM4OiJldmFsXChldmFsXChbJyJdU3RyaW5nXC5mcm9tQ2hhckNvZGVcKCI7aTo5MDtzOjEwMDoiY2xlbjtpXCtcK1wpe2JcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoYVwuY2hhckNvZGVBdFwoaVwpXF4yXCl9Yz11bmVzY2FwZVwoYlwpO2RvY3VtZW50XC53cml0ZVwoY1wpOyI7aTo5MTtzOjc4OiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9aHR0cDovL2dvb1wuZ2wiO2k6OTI7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aTo5MztzOjg1OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs9dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXStccypcKTtccyp2YXJccytFeHBEYXRlIjtpOjk0O3M6NzE6IndoaWxlXChccypmPFxkK1xzKlwpZG9jdW1lbnRcW1xzKlthLXpBLVowLTlfXStcK1snIl10ZVsnIl1ccypcXVwoU3RyaW5nIjtpOjk1O3M6Mjk6IlxdXChccyp2XCtcK1xzKlwpLTFccypcKVxzKlwpIjtpOjk2O3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6OTc7czo1MDoiWyciXVxdXChbYS16QS1aMC05X10rXCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6OTg7czo2NDoiO3doaWxlXChbYS16QS1aMC05X10rPFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aTo5OTtzOjEwODoiaWZccypcKFthLXpBLVowLTlfXStcLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjEwMDtzOjM4OiJwcmVnX21hdGNoXChbJyJdQFwoeWFuZGV4XHxnb29nbGVcfGJvdCI7aToxMDE7czo2NDoiU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aToxMDI7czo1NzoiXFtbJyJdY2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXStccypcK1xzKlsnIl1BdFsnIl1cXVwoIjtpOjEwMztzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjEwNDtzOjU1OiJTdHJpbmdcW1xzKlsnIl1mcm9tQ2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXStccypcXVwoIjtpOjEwNTtzOjI4OiIuPVsnIl0uOi8vLlwuLlwuLlwuLi8uXC4uXC4uIjtpOjEwNjtzOjM5OiI8L3NjcmlwdD5bJyJdXCk7XHMqL1wqL1thLXpBLVowLTlfXStcKi8iO2k6MTA3O3M6NzM6ImRvY3VtZW50XFtfMHhcZCtcW1xkK1xdXF1cKF8weFxkK1xbXGQrXF1cK18weFxkK1xbXGQrXF1cK18weFxkK1xbXGQrXF1cKTsiO2k6MTA4O3M6OToiJmFkdWx0PTEmIjtpOjEwOTtzOjk3OiJkb2N1bWVudFwucmVhZHlTdGF0ZVxzKz09XHMrWyciXWNvbXBsZXRlWyciXVwpXHMqe1xzKmNsZWFySW50ZXJ2YWxcKFthLXpBLVowLTlfXStcKTtccypzXC5zcmNccyo9IjtpOjExMDtzOjE5OiIuOi8vLlwuLlwuLi8uXC4uXD8vIjtpOjExMTtzOjIyOiJzcmM9ImZpbGVzX3NpdGUvanNcLmpzIjtpOjExMjtzOjk0OiJ3aW5kb3dcLnBvc3RNZXNzYWdlXCh7XHMqem9yc3lzdGVtOlxzKjEsXHMqdHlwZTpccypbJyJddXBkYXRlWyciXSxccypwYXJhbXM6XHMqe1xzKlsnIl11cmxbJyJdIjtpOjExMztzOjk4OiJcLmF0dGFjaEV2ZW50XChbJyJdb25sb2FkWyciXSxhXCk6W2EtekEtWjAtOV9dK1wuYWRkRXZlbnRMaXN0ZW5lclwoWyciXWxvYWRbJyJdLGEsITFcKTtsb2FkTWF0Y2hlciI7aToxMTQ7czo3ODoiaWZcKFwoYT1lXC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWFbJyJdXClcKSYmYVxbMFxdJiZhXFswXF1cLmhyZWZcKWZvclwodmFyIjtpOjExNTtzOjgxOiI7XHMqZWxlbWVudFwuaW5uZXJIVE1MXHMqPVxzKlsnIl08aWZyYW1lXHMrc3JjPVsnIl1ccypcK1xzKnhoclwucmVzcG9uc2VUZXh0XHMqXCsiO2k6MTE2O3M6MTk6IlhIRkVSMVxzKj1ccypYSEZFUjEiO2k6MTE3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aToxMTg7czo1NToid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovL1xkK1wuXGQrXC5cZCtcLlxkKy9cPyI7aToxMTk7czo2Njoic2V0VGltZW91dFwoZnVuY3Rpb25cKFwpe3ZhclxzK3BhdHRlcm5ccyo9XHMqbmV3XHMqUmVnRXhwXCgvZ29vZ2xlIjtpOjEyMDtzOjY2OiJ3bz1bJyJdXCshIVwoWyciXW9udG91Y2hzdGFydFsnIl1ccytpblxzK3dpbmRvd1wpXCtbJyJdJnN0PTEmdGl0bGUiO2k6MTIxO3M6Mzc6ImlmXChhJiZbJyJdZGF0YVsnIl1pblxzKmEmJmFcLmRhdGFcLmEiO2k6MTIyO3M6ODY6ImRvY3VtZW50XFtbYS16QS1aMC05X10rXChbYS16QS1aMC05X10rXFtcZCtcXVwpXF1cKFthLXpBLVowLTlfXStcKFthLXpBLVowLTlfXStcW1xkK1xdIjtpOjEyMztzOjUzOiIuXC4uXChcWyciXTwuIC49WyciXS4vLlxbJyJdXCtcWyciXS5cWyciXVwrXFsnIl0uWyciXSI7aToxMjQ7czoyNToiXChcKX19LFxkK1wpOy9cKlx3ezMyfVwqLyI7aToxMjU7czo0OToiZXZhbFsnIl1cLnNwbGl0XChbJyJdXHxbJyJdXCksMCx7fVwpXCk7XHMqfVwoXClcKSI7aToxMjY7czo3OToiaWZcKGlzXHcrXClccyp7XHMqd2luZG93XC5sb2NhdGlvblxzKj1ccyonaHR0cDovL1xkK1wuXGQrXC5cZCtcLlxkKy9cP1x3Kyc7XHMqfSI7aToxMjc7czo0MToiZXZhbFwoU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFtcZCssXHNdK1wpXCkiO2k6MTI4O3M6Nzc6IndpbmRvd1wudG5TZXRQYXJhbXNcKFxkK1xzKixccyp7KCJcdysiOlxkKywpezMsfS4rPzt3aW5kb3dcLnRuTG9hZEJsb2Nrc1woXCk7IjtpOjEyOTtzOjg1OiIuXC5nZXRTaG93ZWRUZWFzZXJzQ291bnRcKC5cLnNpdGVJZCxcZCtcKVwrMX0sYj1mdW5jdGlvblwoXCl7Llwuc2V0U2hvd2VkVGVhc2Vyc0NvdW50IjtpOjEzMDtzOjExNToiPGJvZHk+XHMqPGRpdiBpZD0idGJsb2NrIj5ccyo8Y2VudGVyPlxzKjwvY2VudGVyPlxzKjwvZGl2PlxzKjxzY3JpcHQ+c2V0VGltZW91dFwoImluaXRcKFwpIiwwXCk7PC9zY3JpcHQ+XHMqPC9ib2R5PiI7aToxMzE7czoxMTM6IjwhXFtDREFUQVxbXHMqd2luZG93XC5hXGQrXHMqPVxzKlxkKzshZnVuY3Rpb25cKFwpe3ZhclxzK1x3Kz1KU09OXC5wYXJzZVwoJ1xbIlx3KyIsIlx3KyIsIlx3KyIsIlx3KyJcXSdcKSx0PSJcZCsiIjtpOjEzMjtzOjExMDoiL2lcW1x3K1xbXGQrXF1cXVwoXHcrXFtcdytcW1xkK1xdXF1cKFxkKyxcZCtcKVwpXD8hXGQrOiFcZCs7fVx3K1woXCk9PT0hXGQrJiZcKFx3K1xbXHcrXFtcZCtcXVxdPVx3K1xbXGQrXF1cKTsiO2k6MTMzO3M6MjEyOiI6dW5kZWZpbmVkfXJlc3VsdD1jaGVja19vc1woXCk7Y29vaz1udWxsO2Nvb2s9Z2V0Q29va2llXChfMHhcdytcW1xkK1xdXCk7aWZcKGNvb2s9PW51bGxcfFx8Y29vaz09XzB4XHcrXFtcZCtcXVwpe2lmXChyZXN1bHQ9PV8weFx3K1xbXGQrXF1cfFx8cmVzdWx0PT1fMHhcdytcW1xkK1xdXCl7aWZcKHJlc3VsdD09XzB4XHcrXFtcZCtcXVwpe3ZhclxzK2Rpdj1kb2N1bWVudCI7aToxMzQ7czozNjk6IiFmdW5jdGlvblwoXCl7ZnVuY3Rpb25ccyt0XChcKXtyZXR1cm4hIWxvY2FsU3RvcmFnZVwuZ2V0SXRlbVwoYVwpfWZ1bmN0aW9uXHMrZVwoXCl7b1woXCksXHMqcGFyZW50XC50b3BcLndpbmRvd1wubG9jYXRpb25cLmhyZWY9Y31mdW5jdGlvblxzK29cKFwpe3ZhclxzK3Q9clwraTtsb2NhbFN0b3JhZ2VcLnNldEl0ZW1cKGEsdFwpfVxzKmZ1bmN0aW9uXHMrblwoXCl7aWZcKHRcKFwpXCl7dmFyXHMrbz1sb2NhbFN0b3JhZ2VcLmdldEl0ZW1cKGFcKTtyPm8mJmVcKFwpfWVsc2VccytlXChcKX12YXJccythPSJcdysiLFxzKnI9TWF0aFwuZmxvb3JcKFwobmV3IERhdGVcKVwuZ2V0VGltZVwoXCkvXHcrXCksYz0iLis/IixpPVxkKztuXChcKX1cKFwpOyI7aToxMzU7czo1MjoiPHNjcmlwdFxzK3NyYz0nL1w/XGQrX1xkK19cZCtfXGQrPTEnXHMqPlxzKjwvc2NyaXB0PiI7aToxMzY7czoxMDY6ImlmXCghZ2V0Q29va2llXCgiKFx4XHcrKSsiXClcKXt2YXJccypcdys9IihceFx3KykrIjt2YXJccypcdytccyo9XHMqbmV3IERhdGVcKFwpLFx3Kz1ccypuZXcgRGF0ZVwoXCk7XHcrXFsiO2k6MTM3O3M6MTI5OiJ3aW5kb3dcLm9ubG9hZD1mdW5jdGlvblwoXClccyp7XHMqdmFyXHMrXHcrXHMqPVxzKm5ld1xzK1JlZ0V4cFwoL1tcLVx3K1wuXStcfC4rPy9pXCk7XHMqdmFyIFx3K1xzKj1ccypcKGxvY2F0aW9uXC5ocmVmXClcLnJlcGxhY2UiO2k6MTM4O3M6MjYyOiJmXCghd2luZG93XC5hXHcrXCl7dmFyXHMrYVx3Kz1mdW5jdGlvblwoXCRcKXtyZXR1cm5ccytcJFw/ZG9jdW1lbnRcLmdldEVsZW1lbnRCeUlkXChcJFwpOiExfSxhXHcrPWZ1bmN0aW9uXChcJFwpe3JldHVyblxzK1wkXD9kb2N1bWVudFwuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZVwoXCRcKTohMX0sYVx3Kz1mdW5jdGlvblwoXCRcKXtyZXR1cm5ccytcJFw/ZG9jdW1lbnRcLnF1ZXJ5U2VsZWN0b3JcKFwkXCk6ITF9LGFcdys9ZnVuY3Rpb25cKFwkXCl7cmV0dXJuIjtpOjEzOTtzOjE0ODoiXChmdW5jdGlvblwoYSxiXCl7aWZcKC8uKz8vaVwudGVzdFwoYVwuc3Vic3RyXCgwLDRcKVwpXCl3aW5kb3dcLmxvY2F0aW9uPWJ9XClcKG5hdmlnYXRvclwudXNlckFnZW50XHxcfG5hdmlnYXRvclwudmVuZG9yXHxcfHdpbmRvd1wub3BlcmEsJ1teJ10rJ1wpOyI7aToxNDA7czo1MzoiaWZccypcKCFWaXNpdFdlYlwuQ2xpY2t1bmRlclwpXHMqVmlzaXRXZWJcLkNsaWNrdW5kZXIiO2k6MTQxO3M6MTE5OiJpZlwoL1woZ29vZ2xlXHx5YWhvb1x8YmluZ1x8YW9sXCkvaVwudGVzdFwoZG9jdW1lbnRcLnJlZmVycmVyXClcKXt3aW5kb3dcLnNldFRpbWVvdXRcKGZ1bmN0aW9uXChcKXt0b3BcLmxvY2F0aW9uXC5ocmVmPSI7aToxNDI7czo1MDoidD13aW5kb3csbj0idGVhc2VybmV0X2Jsb2NraWQiLGU9InRlYXNlcm5ldF9wYWRpZCIiO2k6MTQzO3M6MzI5OiJ2YXJccytzY3JpcHQ9ZG9jdW1lbnRcLmNyZWF0ZUVsZW1lbnRcKCdzY3JpcHQnXCk7c2NyaXB0XC5zcmM9Jy4rPyc7YmluZEV2ZW50XChmdW5jdGlvblwoXCl7aWZcKFwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoJy4rPydcKT09LTFcKSYmXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFwuaW5kZXhPZlwoJ1x3KydcKSE9LTFcKSYmXChkb2N1bWVudFwubG9jYXRpb25cLnBhdGhuYW1lXC5sZW5ndGg+MVwpJiZcKFwobmF2aWdhdG9yXC51c2VyQWdlbnRcLmluZGV4T2ZcKCdcdysnXCkhPS0xXClcfFx8XChuYXZpZ2F0b3JcLnVzZXJBZ2VudFwuaW5kZXhPZlwoJ1x3KydcKSE9LTFcKSI7aToxNDQ7czo3NjoiXHcrPVxkKztkb2N1bWVudFwud3JpdGVcKFx3K1xbIltmcm9tQ2hhckNvZGVceDAtOWEtZl0rIlxdXChcdytcKVwpO2NvbnRpbnVlOyI7aToxNDU7czo5ODoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woKFtcdytcc1wuXStcfD8pK1wpL2lcKSE9PW51bGxcKXt3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKicuKz8nO30iO2k6MTQ2O3M6MTcwOiJcKGZ1bmN0aW9uLisoKHRvU3RyaW5nfG5ld3xSZWdFeHB8U3RyaW5nfGV2YWx8dmFyfGRvY3VtZW50fHNjcmlwdHxpbnNlcnRCZWZvcmV8c3JjfGh0dHB8anN8Y3JlYXRlRWxlbWVudHxnZXRFbGVtZW50c0J5VGFnTmFtZXxwYXJlbnROb2RlfHNwbGl0KVx8KXs1LH0uK3NwbGl0XCgnXHwnXCksMCx7fSI7aToxNDc7czo4MDoiIlxdO2Z1bmN0aW9uIFx3K1woXHcrXCl7cmV0dXJuIFx3K1woXHcrXChcdytcKSwuXHcrLlwpO31cdytcKFx3K1woXHcrXFtcZCtdXClcKTsiO2k6MTQ4O3M6ODU6Im5hdmlnYXRvclxbX1x3K1xbXGQrXF1cXVx8XHxuYXZpZ2F0b3JcW19cdytcW1xkK1xdXF1cfFx8d2luZG93XFtfXHcrXFtcZCtcXVxdO3JldHVybi8iO2k6MTQ5O3M6MTQxOiJwYXJlbnRcLnRvcFwud2luZG93XC5sb2NhdGlvblwuaHJlZj1cdyt9ZnVuY3Rpb24gXHcrXChcKXt2YXIgXHcrPVx3K1wrXHcrO2xvY2FsU3RvcmFnZVwuc2V0SXRlbVwoXHcrLFx3K1wpfVxzKmZ1bmN0aW9uIFx3K1woXCl7aWZcKFx3K1woXClcKXsiO2k6MTUwO3M6OTI6Im5hdmlnYXRvclxbX1x3K1xbXGQrXF1cXVx8XHxuYXZpZ2F0b3JcW19cdytcW1xkK1xdXF1cfFx8d2luZG93XFtfXHcrXFtcZCtcXVxdO3JldHVybi9hbmRyb2lkIjtpOjE1MTtzOjM4OiIvanMvanF1ZXJ5XC5taW5cLnBocFw/Y191dHQ9XHcrJmNfdXRtPSI7aToxNTI7czo1ODoiL2pzL2pxdWVyeVwubWluXC5waHBcP2tleT1cdysmdXRtX2NhbXBhaWduPVx3KyZ1dG1fc291cmNlPSI7aToxNTM7czoxMDY6IjxzY3JpcHRccytsYW5ndWFnZT1KYXZhU2NyaXB0XHMraWQ9c2NyaXB0RGF0YVxzKj48L3NjcmlwdD5ccyo8c2NyaXB0XHMrbGFuZ3VhZ2U9SmF2YVNjcmlwdFxzK3NyYz0vbW9kdWxlcy8iO2k6MTU0O3M6MTU1OiJcL1wqXHcuKz9cLmpzLis/XCpcLztccypcKFxzKmZ1bmN0aW9uXChcKVxzKnt2YXJcc1x3ezh9XD0uKz9mb3JccypcKFxzKnZhclxzKlx3ezh9XHMqPS4rP1N0cmluZ1wuZnJvbUNoYXJDb2RlXCgnXCtcd3s4fVwrJ1wpJ1wpXClcO1x9XClccypcKFwpXDtcL1wqLis/XCpcLyI7aToxNTU7czoxMDA6ImVsXC5zcmNccyo9XHMqIi9taXNjL2pxdWVyeVwuYW5pbWF0ZVwuanNcP189Lis/dHJ5XHMqe1xzKnBcLnBhcmVudE5vZGVcLmluc2VydEJlZm9yZVwoZWxccyosXHMqcFwpOyAiO2k6MTU2O3M6NTE6IkNyZWF0ZU9iamVjdFwoIlNoZWxsXC5BcHBsaWNhdGlvbiJcKS4rP1NoZWxsRXhlY3V0ZSI7aToxNTc7czo5ODoiPCEtLShcd3s1LDMyfSktLT48c2NyaXB0XHMrdHlwZT0idGV4dC9qYXZhc2NyaXB0IlxzK3NyYz0iaHR0cHM/Oi8vLis/XD9pZD1cZCsiPjwvc2NyaXB0PjwhLS0vXDEtLT4iO2k6MTU4O3M6MTQyOiIoXHcrKT13aW5kb3dcLmxvY2F0aW9uO2lmXChuZXcgUmVnRXhwXChbIiddKFthLXpBLVpffFwtMC05XSspPyhjaGVja291dHxvbmVzdGVwfG9uZXBhZ2UpKFthLXpBLVpffFwtMC05XSspP1snIl1cKVwudGVzdFwoXDFcKS4rP1hNTEh0dHBSZXF1ZXN0IjtpOjE1OTtzOjEzMDoiWE1MSHR0cFJlcXVlc3QuKz9SZWdFeHBcKFsiJ10oW2EtekEtWl98XC0wLTldKyk/KGNoZWNrb3V0fG9uZXN0ZXB8b25lcGFnZSkoW2EtekEtWl98XC0wLTldKyk/WyciXSwnZ2knXClcKVwudGVzdFwod2luZG93XC5sb2NhdGlvbiI7aToxNjA7czoxMzk6IjwhLS1cd3szMn0tLT48c3R5bGU+I1x3K1xzKntjb2xvcjpcdys7cGFkZGluZzpcZCtweDttYXJnaW46XGQrcHg7fVxzKlwuXHcrLFxzKlwuXHcrXHMqYVxzKnt0ZXh0LWRlY29yYXRpb246bm9uZS4rPzwvZGl2PjwvZGl2PjwhLS1cd3szMn0tLT4iO2k6MTYxO3M6MjU1OiIoKGZyYW1lYm9yZGVyPSJubyJ8c2Nyb2xsaW5nPSJubyJ8YWxsb3d0cmFuc3BhcmVuY3kpXHMrKXszLH1zdHlsZT0iKHBvc2l0aW9uOmZpeGVkO3x0b3A6MHB4O3xsZWZ0OjBweDt8Ym90dG9tOjBweDt8cmlnaHQ6MHB4O3x3aWR0aDoxMDAlO3xoZWlnaHQ6MTAwJTt8Ym9yZGVyOm5vbmU7fG1hcmdpbjowO3xwYWRkaW5nOjA7fGZpbHRlcjphbHBoYVwob3BhY2l0eT0wXCk7fG9wYWNpdHk6MDt8Y3Vyc29yOnBvaW50ZXI7fHotaW5kZXg6XGQrKXs1LH0iO2k6MTYyO3M6NjE6Il9wb3B3bmRccyo9XHMqd2luZG93XC5vcGVuXCgnaHR0cDovL3F1aWNrZG9tYWluZndkXC5jb20vXD9kbj0iO2k6MTYzO3M6MTQ6InY9MDt2eD1bJyJdQ29kIjtpOjE2NDtzOjIzOiJBdFsnIl1cXVwodlwrXCtcKS0xXClcKSI7aToxNjU7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MTY2O3M6NzA6InVzZXJBZ2VudFx8cHBcfGh0dHBcfGRhemFseXpbJyJdezAsMX1cLnNwbGl0XChbJyJdezAsMX1cfFsnIl17MCwxfVwpLDAiO2k6MTY3O3M6MjI6IlwucHJvdG90eXBlXC5hfWNhdGNoXCgiO2k6MTY4O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6MTY5O3M6MzQ6ImlmXChSZWZcLmluZGV4T2ZcKCdcLmdvb2dsZVwuJ1wpIT0iO2k6MTcwO3M6ODY6ImluZGV4T2ZcfGlmXHxyY1x8bGVuZ3RoXHxtc25cfHlhaG9vXHxyZWZlcnJlclx8YWx0YXZpc3RhXHxvZ29cfGJpXHxocFx8dmFyXHxhb2xcfHF1ZXJ5IjtpOjE3MTtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6MTcyO3M6ODI6InE9ZG9jdW1lbnRcLmNyZWF0ZUVsZW1lbnRcKCJkIlwrImkiXCsidiJcKTtxXC5hcHBlbmRDaGlsZFwocVwrIiJcKTt9Y2F0Y2hcKHF3XCl7aD0iO2k6MTczO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTc0O3M6MTE1OiJzNVwocTVcKXtyZXR1cm4gXCtcK3E1O31mdW5jdGlvbiB5Zlwoc2Ysd2VcKXtyZXR1cm4gc2ZcLnN1YnN0clwod2UsMVwpO31mdW5jdGlvbiB5MVwod2JcKXtpZlwod2I9PTE2OFwpd2I9MTAyNTtlbHNlIjtpOjE3NTtzOjY0OiJpZlwobmF2aWdhdG9yXC51c2VyQWdlbnRcLm1hdGNoXCgvXChhbmRyb2lkXHxtaWRwXHxqMm1lXHxzeW1iaWFuIjtpOjE3NjtzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNzc7czozMToiaHR0cDovL3Boc3BcLnJ1L18vZ29cLnBocFw/c2lkPSI7aToxNzg7czo2NjoiPW5hdmlnYXRvclxbYXBwVmVyc2lvbl92YXJcXVwuaW5kZXhPZlwoIk1TSUUiXCkhPS0xXD8nPGlmcmFtZSBuYW1lIjtpOjE3OTtzOjc6IlxceDY1QXQiO2k6MTgwO3M6OToiXFx4NjFyQ29kIjtpOjE4MTtzOjIyOiIiZnIiXCsib21DIlwrImhhckNvZGUiIjtpOjE4MjtzOjExOiI9ImV2IlwrImFsIiI7aToxODM7czo3ODoiXFtcKFwoZVwpXD8icyI6IiJcKVwrInAiXCsibGl0IlxdXCgiYVwkIlxbXChcKGVcKVw/InN1IjoiIlwpXCsiYnN0ciJcXVwoMVwpXCk7IjtpOjE4NDtzOjM5OiJmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzsiO2k6MTg1O3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjE4NjtzOjQxOiJmPSdmJ1wrJ3InXCsnbydcKydtJ1wrJ0NoJ1wrJ2FyQydcKydvZGUnOyI7aToxODc7czo1MDoiZj0nZnJvbUNoJztmXCs9J2FyQyc7ZlwrPSdxZ29kZSdcWyJzdWJzdHIiXF1cKDJcKTsiO2k6MTg4O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MTg5O3M6OToidmFyXHMrXzB4IjtpOjE5MDtzOjIwOiJDb3JlTGlicmFyaWVzSGFuZGxlciI7aToxOTE7czoxMDoia20wYWU5Z3I2bSI7aToxOTI7czo2OiJjMzI4NGQiO2k6MTkzO3M6ODoiXFx4NjhhckMiO2k6MTk0O3M6ODoiXFx4NmRDaGEiO2k6MTk1O3M6NzoiXFx4NmZkZSI7aToxOTY7czo3OiJcXHg2ZmRlIjtpOjE5NztzOjg6IlxceDQzb2RlIjtpOjE5ODtzOjc6IlxceDcyb20iO2k6MTk5O3M6NzoiXFx4NDNoYSI7aToyMDA7czo3OiJcXHg3MkNvIjtpOjIwMTtzOjg6IlxceDQzb2RlIjtpOjIwMjtzOjEwOiJcLmR5bmRuc1wuIjtpOjIwMztzOjk6IlwuZHluZG5zLSI7aToyMDQ7czo3OToifVxzKmVsc2Vccyp7XHMqZG9jdW1lbnRcLndyaXRlXHMqXChccypbJyJdezAsMX1cLlsnIl17MCwxfVwpXHMqfVxzKn1ccypSXChccypcKSI7aToyMDU7czo0NToiZG9jdW1lbnRcLndyaXRlXCh1bmVzY2FwZVwoJyUzQ2RpdiUyMGlkJTNEJTIyIjtpOjIwNjtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6MjA3O3M6NDE6Ilwuc3BsaXRcKCImJiJcKTtoPTI7cz0iIjtpZlwobVwpZm9yXChpPTA7IjtpOjIwODtzOjQxOiI8aWZyYW1lXHMrc3JjPSJodHRwOi8vZGVsdXhlc2NsaWNrc1wucHJvLyI7aToyMDk7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjIxMDtzOjU4OiI7XHMqZG9jdW1lbnRcLndyaXRlXChbJyJdezAsMX08aWZyYW1lXHMqc3JjPSJodHRwOi8veWFcLnJ1IjtpOjIxMTtzOjExMDoid1wuZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXChzY3JpcHRcKTtccypjbGVhckludGVydmFsXChpXCk7XHMqfVxzKn1ccyosXHMqXGQrXHMqXClccyo7XHMqfVxzKlwpXChccyp3aW5kb3ciO2k6MjEyO3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aToyMTM7czo3MDoibm5fcGFyYW1fcHJlbG9hZGVyX2NvbnRhaW5lclx8NTAwMVx8aGlkZGVuXHxpbm5lckhUTUxcfGluamVjdFx8dmlzaWJsZSI7aToyMTQ7czoyOToiPCEtLVthLXpBLVowLTlfXStcfFx8c3RhdCAtLT4iO2k6MjE1O3M6ODU6IiZwYXJhbWV0ZXI9XCRrZXl3b3JkJnNlPVwkc2UmdXI9MSZIVFRQX1JFRkVSRVI9J1wrZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwuVVJMXCkiO2k6MjE2O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aToyMTc7czozNToiXFtbJyJdZXZhbFsnIl1cXVwoc1wpO319fX08L3NjcmlwdD4iO2k6MjE4O3M6NTk6ImtDNzBGTWJseUprRldab2RDS2wxV1lPZFdZVWxuUXpSbmJsMVdac1ZFZGxkbUwwNVdadFYzWXZSR0k5IjtpOjIxOTtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjIyMDtzOjEzMDoiZG9jdW1lbnRcLmNvb2tpZVwubWF0Y2hcKG5ld1xzK1JlZ0V4cFwoXHMqIlwoXD86XF5cfDsgXCkiXHMqXCtccypuYW1lXC5yZXBsYWNlXCgvXChcW1xcXC5cJFw/XCpcfHt9XFxcKFxcXClcXFxbXFxcXVxcL1xcXCtcXlxdXCkvZyI7aToyMjE7czo4Njoic2V0Q29va2llXHMqXCg/XHMqImFyeF90dCJccyosXHMqMVxzKixccypkdFwudG9HTVRTdHJpbmdcKFwpXHMqLFxzKlsnIl17MCwxfS9bJyJdezAsMX0iO2k6MjIyO3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6MjIzO3M6OTg6InZhclxzK2R0XHMrPVxzK25ld1xzK0RhdGVcKFwpLFxzK2V4cGlyeVRpbWVccys9XHMrZHRcLnNldFRpbWVcKFxzK2R0XC5nZXRUaW1lXChcKVxzK1wrXHMrOTAwMDAwMDAwIjtpOjIyNDtzOjEwNToiaWZccypcKFxzKm51bVxzKj09PVxzKjBccypcKVxzKntccypyZXR1cm5ccyoxO1xzKn1ccyplbHNlXHMqe1xzKnJldHVyblxzK251bVxzKlwqXHMqckZhY3RcKFxzKm51bVxzKi1ccyoxIjtpOjIyNTtzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aToyMjY7czo4MzoiPHNjcmlwdFxzK2xhbmd1YWdlPSJKYXZhU2NyaXB0Ij5ccypwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj0iaHR0cDovL3ZrXC5jb20iO2k6MjI3O3M6NDQ6ImxvY2F0aW9uXC5yZXBsYWNlXChbJyJdezAsMX1odHRwOi8vdjVrNDVcLnJ1IjtpOjIyODtzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjIyOTtzOjE0MjoiZG9jdW1lbnRcLndyaXRlXHMqXChbJyJdezAsMX08WyciXXswLDF9XHMqXCtccyp4XFswXF1ccypcK1xzKlsnIl17MCwxfSBbJyJdezAsMX1ccypcK1xzKnhcWzRcXVxzKlwrXHMqWyciXXswLDF9PlwuWyciXXswLDF9XHMqXCt4XHMqXFsyXF1ccypcKyI7aToyMzA7czo2MDoiaWZcKHRcLmxlbmd0aD09Mlwpe3pcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKHRcKVwrIjtpOjIzMTtzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aToyMzI7czo5NzoiXC5zdHlsZVwuaGVpZ2h0XHMqPVxzKlsnIl17MCwxfTBweFsnIl17MCwxfTt3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7ZG9jdW1lbnRcLmNvb2tpZSI7aToyMzM7czoxMjI6Ilwuc3JjPVwoWyciXXswLDF9aHRwczpbJyJdezAsMX09PWRvY3VtZW50XC5sb2NhdGlvblwucHJvdG9jb2xcP1snIl17MCwxfWh0dHBzOi8vc3NsWyciXXswLDF9OlsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1cKVwrIjtpOjIzNDtzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6MjM1O3M6NzY6InByZWdfbWF0Y2hcKFsnIl17MCwxfS9zYXBlL2lbJyJdezAsMX1ccyosXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1JFRkVSRVIiO2k6MjM2O3M6NzQ6ImRpdlwuaW5uZXJIVE1MXHMqXCs9XHMqWyciXXswLDF9PGVtYmVkXHMraWQ9ImR1bW15MiJccytuYW1lPSJkdW1teTIiXHMrc3JjIjtpOjIzNztzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjIzODtzOjUxOiJcKGI9ZG9jdW1lbnRcKVwuaGVhZFwuYXBwZW5kQ2hpbGRcKGJcLmNyZWF0ZUVsZW1lbnQiO2k6MjM5O3M6MzA6IkNocm9tZVx8aVBhZFx8aVBob25lXHxJRU1vYmlsZSI7aToyNDA7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aToyNDE7czo0OToiPC9pZnJhbWU+WyciXVwpO1xzKnZhclxzK2o9bmV3XHMrRGF0ZVwobmV3XHMrRGF0ZSI7aToyNDI7czo1Mzoie3Bvc2l0aW9uOmFic29sdXRlO3RvcDotOTk5OXB4O308L3N0eWxlPjxkaXZccytjbGFzcz0iO2k6MjQzO3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aToyNDQ7czo1ODoicGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb249WyciXXswLDF9aHR0cDovL3ZrXC5jb21cLiI7aToyNDU7czo2ODoiamF2YXNjcmlwdFx8aGVhZFx8dG9Mb3dlckNhc2VcfGNocm9tZVx8d2luXHxqYXZhRW5hYmxlZFx8YXBwZW5kQ2hpbGQiO2k6MjQ2O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aToyNDc7czoyMDoiXCk7aWZcKCF+XChbJyJdezAsMX0iO2k6MjQ4O3M6MjM6Ii8vXHMqU29tZVwuZGV2aWNlc1wuYXJlIjtpOjI0OTtzOjMyOiJ3aW5kb3dcLm9uZXJyb3Jccyo9XHMqa2lsbGVycm9ycyI7aToyNTA7czoxMDU6ImNoZWNrX3VzZXJfYWdlbnQ9XFtccypbJyJdezAsMX1MdW5hc2NhcGVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9aVBob25lWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfU1hY2ludG9zaCI7aToyNTE7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aToyNTI7czo0ODoic3RyaXBvc1wobmF2aWdhdG9yXC51c2VyQWdlbnRccyosXHMqbGlzdF9kYXRhXFtpIjtpOjI1MztzOjI2OiJpZlxzKlwoIXNlZV91c2VyX2FnZW50XChcKSI7aToyNTQ7czo0NjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlsnIl1bJyJdO31pZlwoIWdldENvb2tpZSI7aToyNTU7czo3MDoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWZ0cDovLyI7aToyNTY7czo0ODoiaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKFsnIl17MCwxfXNhYnJpIjtpOjI1NztzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6MjU4O3M6MTE0OiJcKTtccyppZlwoXHMqW2EtekEtWjAtOV9dK1wudGVzdFwoXHMqZG9jdW1lbnRcLnJlZmVycmVyXHMqXClccyomJlxzKlthLXpBLVowLTlfXStcKVxzKntccypkb2N1bWVudFwubG9jYXRpb25cLmhyZWYiO2k6MjU5O3M6NTI6ImlmXCgvQW5kcm9pZC9pXFtfMHhbYS16QS1aMC05X10rXFtcZCtcXVxdXChuYXZpZ2F0b3IiO2k6MjYwO3M6Njk6ImZ1bmN0aW9uXChhXCl7aWZcKGEmJlsnIl1kYXRhWyciXWluXGQrYSYmYVwuZGF0YVwuYVxkKyYmYVwuZGF0YVwuYVxkKyI7aToyNjE7czo1ODoic1wob1wpfVwpfSxmPWZ1bmN0aW9uXChcKXt2YXIgdCxpPUpTT05cLnN0cmluZ2lmeVwoZVwpO29cKCI7aToyNjI7czoxMDY6IjxcZCtccytcZCs9WyciXVxkKy9cZCtcXFsnIl1cK1xcWyciXS5cXFsnIl1cK1xcWyciXS5bJyJdXHMrLj1bJyJdLjovL1xkK1xcWyciXVwrXFxbJyJdLlwuXGQrXFxbJyJdXCtcXFsnIl0iO2k6MjYzO3M6MTA3OiJzZXRUaW1lb3V0XChcZCtcKTtccyp2YXJccytkZWZhdWx0X2tleXdvcmRccyo9XHMqZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwudGl0bGVcKTtccyp2YXJccytzZV9yZWZlcnJlciI7aToyNjQ7czo5ODoiPWRvY3VtZW50XC5yZWZlcnJlcjtpZlwoUmVmXC5pbmRleE9mXChbJyJdXC5nb29nbGVcLlsnIl1cKSE9LTFcfFx8UmVmXC5pbmRleE9mXChbJyJdXC5iaW5nXC5bJyJdXCkiO2k6MjY1O3M6MjA6InZpc2l0b3JUcmFja2VyX2lzTW9iIjtpOjI2NjtzOjQxOiIvXCpcd3szMn1cKi92YXJccytfMHhbYS16QS1aMC05X10rPVxbIlxceCI7aToyNjc7czo3MToiL1wqXHd7MzJ9XCovO3dpbmRvd1xbWyciXWRvY3VtZW50WyciXVxdXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXT1cW1snIl0iO2k6MjY4O3M6NDg6IlxdXF1cLmpvaW5cKFxcWyciXVxcWyciXVwpO1snIl1cKVwpOy9cKlx3ezMyfVwqLyI7aToyNjk7czoxMzQ6Ijt2YXJccytbYS16QS1aMC05X10rPVthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKFxkK1wpXF5bYS16QS1aMC05X10rXC5jaGFyQ29kZUF0XChbYS16QS1aMC05X10rXCk7W2EtekEtWjAtOV9dKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjI3MDtzOjM4OiJldmFsXChldmFsXChbJyJdU3RyaW5nXC5mcm9tQ2hhckNvZGVcKCI7aToyNzE7czoxMDA6ImNsZW47aVwrXCtcKXtiXCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKGFcLmNoYXJDb2RlQXRcKGlcKVxeMlwpfWM9dW5lc2NhcGVcKGJcKTtkb2N1bWVudFwud3JpdGVcKGNcKTsiO2k6MjcyO3M6Njg6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly9cZCtcLlxkK1wuXGQrXC5cZCsvXD9bYS16QS1aMC05X10rIjtpOjI3MztzOjMzOiIuIiAuPSIuOi8vLlwuLlwuLi8uLS4vLi8uLy5cLi5cLi4iO2k6Mjc0O3M6MzY6IjtldmFsXChTdHJpbmdcLmZyb21DaGFyQ29kZVwoXGQrXHMqLCI7aToyNzU7czo5Nzoic2V0VGltZW91dFwoXGQrXCk7aWZcKGRvY3VtZW50XC5yZWZlcnJlclwuaW5kZXhPZlwobG9jYXRpb25cLnByb3RvY29sXCsiLy8iXCtsb2NhdGlvblwuaG9zdFwpIT09MCI7aToyNzY7czoxMjg6Ii9pXFtcd3sxLDQ1fVxbXGQrXF1cXVwoaVxbXHd7MSw0NX1cW1xkK1xdXF1cKDAsXGQrXClcKVw/ITA6ITE7fVx3ezEsNDV9XChcKT09PSEwJiZcKHdpbmRvd1xbXHd7MSw0NX1cW1xkK1xdXF09XHd7MSw0NX1cW1xkK1xdXCk7IjtpOjI3NztzOjEzMjoiOnVuZGVmaW5lZH1yZXN1bHQ9Y2hlY2tfb3NcKFwpO2Nvb2s9bnVsbDtjb29rPWdldENvb2tpZVwoXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cKTtpZlwoY29vaz09bnVsbFx8XHxjb29rPT1fMHhbYS16QS1aMC05X10rXFtcZCtcXVwpIjtpOjI3ODtzOjExNDoiZG9jdW1lbnRcLndyaXRlXChbJyJdPHNjcmlwdFxzK3R5cGU9WyciXXRleHQvamF2YXNjcmlwdFsnIl1ccytzcmM9WyciXWh0dHA6Ly9nb29cLmdsL1x3ezEsNDV9WyciXT48L3NjcmlwdD5bJyJdXCk7IjtpOjI3OTtzOjEyNDoiXChsb2NhdGlvblwuaHJlZlwpXC5yZXBsYWNlXChbJyJdaHR0cDovL1snIl1cK2xvY2F0aW9uXC5ob3N0XCtbJyJdL1snIl0sWyciXVsnIl1cKTtpZlwocGF0dGVyblwudGVzdFwoZG9jdW1lbnRcLnJlZmVycmVyXClcKSI7aToyODA7czoxNzoic2V4ZnJvbWluZGlhXC5jb20iO2k6MjgxO3M6MTE6ImZpbGVreFwuY29tIjtpOjI4MjtzOjEzOiJzdHVtbWFublwubmV0IjtpOjI4MztzOjE0OiJ0b3BsYXlnYW1lXC5ydSI7aToyODQ7czoxNDoiaHR0cDovL3h6eFwucG0iO2k6Mjg1O3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aToyODY7czoxMToibW9iaS1nb1wuaW4iO2k6Mjg3O3M6MTY6Im15ZmlsZXN0b3JlXC5jb20iO2k6Mjg4O3M6MTc6ImZpbGVzdG9yZTcyXC5pbmZvIjtpOjI4OTtzOjE2OiJmaWxlMnN0b3JlXC5pbmZvIjtpOjI5MDtzOjE1OiJ1cmwyc2hvcnRcLmluZm8iO2k6MjkxO3M6MTg6ImZpbGVzdG9yZTEyM1wuaW5mbyI7aToyOTI7czoxMjoidXJsMTIzXC5pbmZvIjtpOjI5MztzOjE0OiJkb2xsYXJhZGVcLmNvbSI7aToyOTQ7czoxMToic2VjY2xpa1wucnUiO2k6Mjk1O3M6MTE6Im1vYnktYWFcLnJ1IjtpOjI5NjtzOjEyOiJzZXJ2bG9hZFwucnUiO2k6Mjk3O3M6Nzoibm5uXC5wbSI7aToyOTg7czo3OiJubm1cLnBtIjtpOjI5OTtzOjE2OiJtb2ItcmVkaXJlY3RcLnJ1IjtpOjMwMDtzOjE2OiJ3ZWItcmVkaXJlY3RcLnJ1IjtpOjMwMTtzOjE2OiJ0b3Atd2VicGlsbFwuY29tIjtpOjMwMjtzOjE5OiJnb29kcGlsbHNlcnZpY2VcLnJ1IjtpOjMwMztzOjE0OiJ5b3V0dWliZXNcLmNvbSI7aTozMDQ7czoxNDoidW5zY3Jld2luZ1wucnUiO2k6MzA1O3M6MjY6ImxvYWRtZVwuY2hpY2tlbmtpbGxlclwuY29tIjtpOjMwNjtzOjMxOiJzaGFyZVwucGx1c29cLnJ1L3BsdXNvLWxpa2VcLmpzIjtpOjMwNztzOjg6Ii8vdmtcLmNjIjtpOjMwODtzOjI2OiJ3ZWJzaG9wLXRvb2wtbWFuYWdlclwuaW5mbyI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTo3ODp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjg1OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs9dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXStccypcKTtccyp2YXJccytFeHBEYXRlIjtpOjE1O3M6NzI6IjwhLS1ccypbYS16QS1aMC05X10rXHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqW2EtekEtWjAtOV9dK1xzKi0tPiI7aToxNjtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToxNztzOjcxOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rXCtbJyJddGVbJyJdXHMqXF1cKFN0cmluZyI7aToxODtzOjc4OiJzZXRDb29raWVcKFxzKl8weFthLXpBLVowLTlfXStccyosXHMqXzB4W2EtekEtWjAtOV9dK1xzKixccypfMHhbYS16QS1aMC05X10rXCkiO2k6MTk7czoyOToiXF1cKFxzKnZcK1wrXHMqXCktMVxzKlwpXHMqXCkiO2k6MjA7czo0MzoiZG9jdW1lbnRcW1xzKl8weFthLXpBLVowLTlfXStcW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjEyMzoiaVxbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dK1xbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoXGQrLFxkK1wpXClcKXt3aW5kb3dcW18weFthLXpBLVowLTlfXStcW1xkK1xdXF09bG9jIjtpOjI1O3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MjY7czo1MDoiWyciXVxdXChbYS16QS1aMC05X10rXCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6Mjc7czo2NDoiO3doaWxlXChbYS16QS1aMC05X10rPFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aToyODtzOjEwODoiaWZccypcKFthLXpBLVowLTlfXStcLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjI5O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzA7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzE7czoxMzA6ImZhbHNlfTtbYS16QS1aMC05X10rPVthLXpBLVowLTlfXStcKFsnIl1bYS16QS1aMC05X10rWyciXVwpXHxbYS16QS1aMC05X10rXChbJyJdW2EtekEtWjAtOV9dK1snIl1cKTtbYS16QS1aMC05X10rXHw9W2EtekEtWjAtOV9dKzsiO2k6MzI7czo2NDoiU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NTc6IlxbWyciXWNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rXHMqXCtccypbJyJdQXRbJyJdXF1cKCI7aTozNTtzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjM2O3M6NTU6IlN0cmluZ1xbXHMqWyciXWZyb21DaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dK1xzKlxdXCgiO2k6Mzc7czoyODoiLj1bJyJdLjovLy5cLi5cLi5cLi4vLlwuLlwuLiI7aTozODtzOjM5OiI8L3NjcmlwdD5bJyJdXCk7XHMqL1wqL1thLXpBLVowLTlfXStcKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo5NzoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChbYS16QS1aMC05X10rXCk7XHMqc1wuc3JjXHMqPSI7aTo0MztzOjE5OiIuOi8vLlwuLlwuLi8uXC4uXD8vIjtpOjQ0O3M6Mzk6IlxkK1xzKj5ccypcZCtccypcP1xzKlsnIl1cXHhcZCtbJyJdXHMqOiI7aTo0NTtzOjQ1OiJbJyJdXFtccypbJyJdY2hhckNvZGVBdFsnIl1ccypcXVwoXHMqXGQrXHMqXCkiO2k6NDY7czoxNzoiPC9ib2R5PlxzKjxzY3JpcHQiO2k6NDc7czoxNzoiPC9odG1sPlxzKjxzY3JpcHQiO2k6NDg7czoxNzoiPC9odG1sPlxzKjxpZnJhbWUiO2k6NDk7czo0MjoiZG9jdW1lbnRcLndyaXRlXChccypTdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjUwO3M6MjI6InNyYz0iZmlsZXNfc2l0ZS9qc1wuanMiO2k6NTE7czo5NDoid2luZG93XC5wb3N0TWVzc2FnZVwoe1xzKnpvcnN5c3RlbTpccyoxLFxzKnR5cGU6XHMqWyciXXVwZGF0ZVsnIl0sXHMqcGFyYW1zOlxzKntccypbJyJddXJsWyciXSI7aTo1MjtzOjk4OiJcLmF0dGFjaEV2ZW50XChbJyJdb25sb2FkWyciXSxhXCk6W2EtekEtWjAtOV9dK1wuYWRkRXZlbnRMaXN0ZW5lclwoWyciXWxvYWRbJyJdLGEsITFcKTtsb2FkTWF0Y2hlciI7aTo1MztzOjc4OiJpZlwoXChhPWVcLmdldEVsZW1lbnRzQnlUYWdOYW1lXChbJyJdYVsnIl1cKVwpJiZhXFswXF0mJmFcWzBcXVwuaHJlZlwpZm9yXCh2YXIiO2k6NTQ7czo4MToiO1xzKmVsZW1lbnRcLmlubmVySFRNTFxzKj1ccypbJyJdPGlmcmFtZVxzK3NyYz1bJyJdXHMqXCtccyp4aHJcLnJlc3BvbnNlVGV4dFxzKlwrIjtpOjU1O3M6MTk6IlhIRkVSMVxzKj1ccypYSEZFUjEiO2k6NTY7czo1MToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZVxzKlwoXHMqWyciXXswLDF9JTNDIjtpOjU3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aTo1ODtzOjU1OiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vXGQrXC5cZCtcLlxkK1wuXGQrL1w/IjtpOjU5O3M6NjY6InNldFRpbWVvdXRcKGZ1bmN0aW9uXChcKXt2YXJccytwYXR0ZXJuXHMqPVxzKm5ld1xzKlJlZ0V4cFwoL2dvb2dsZSI7aTo2MDtzOjY2OiJ3bz1bJyJdXCshIVwoWyciXW9udG91Y2hzdGFydFsnIl1ccytpblxzK3dpbmRvd1wpXCtbJyJdJnN0PTEmdGl0bGUiO2k6NjE7czo1NjoicmVmZXJyZXJccyohPT1ccypbJyJdWyciXVwpe2RvY3VtZW50XC53cml0ZVwoWyciXTxzY3JpcHQiO2k6NjI7czozNzoiaWZcKGEmJlsnIl1kYXRhWyciXWluXHMqYSYmYVwuZGF0YVwuYSI7aTo2MztzOjE2OiJqcXVlcnlcLm1pblwucGhwIjtpOjY0O3M6ODY6ImRvY3VtZW50XFtbYS16QS1aMC05X10rXChbYS16QS1aMC05X10rXFtcZCtcXVwpXF1cKFthLXpBLVowLTlfXStcKFthLXpBLVowLTlfXStcW1xkK1xdIjtpOjY1O3M6NTg6ImhcLmZcKFxcWyciXTwzIDc9WyciXTgvOVxcWyciXVwrXFxbJyJdYVxcWyciXVwrXFxbJyJdYlsnIl0iO2k6NjY7czoyNToiXChcKX19LFxkK1wpOy9cKlx3ezMyfVwqLyI7aTo2NztzOjQ5OiJldmFsWyciXVwuc3BsaXRcKFsnIl1cfFsnIl1cKSwwLHt9XClcKTtccyp9XChcKVwpIjtpOjY4O3M6NjU6Ii5cLmNoYXJBdFwoaVwpXCsuXC5jaGFyQXRcKGlcKVwrLlwuY2hhckF0XChpXCk7ZXZhbFwoLlwpO31cKFwpXCk7IjtpOjY5O3M6ODg6IjxzY3JpcHRccyt0eXBlPVsnIl10ZXh0L2phdmFzY3JpcHRbJyJdXHMrc3JjPSJkYXRhOnRleHQvamF2YXNjcmlwdDtjaGFyc2V0PXV0Zi04O2Jhc2U2NCwiO2k6NzA7czo2MzoiXCk7aWZcKGRvY3VtZW50XC5nZXRFbGVtZW50QnlJZFwoWyciXVx3ezEsNDV9WyciXVwpXCl7fWVsc2V7dmFyIjtpOjcxO3M6ODc6InJldHVyblxzKnB9XChbJyJdLlwuLlwuLlwuLj1bJyJdPC5ccyouPVxcWyciXS4lXFxbJyJdLi4rP3NwbGl0XChbJyJdXHxbJyJdXCksXGQrLHt9XClcKSI7aTo3MjtzOjE3ODoiLFx3ezEsNDV9XChcd3sxLDQ1fVwuXHd7MSw0NX1cKFx3ezEsNDV9e1x3ezEsNDV9XClcd3sxLDQ1fVwoXHd7MSw0NX0gXHd7MSw0NX17XHd7MSw0NX1cKVx3ezEsNDV9XChcd3sxLDQ1fVwoWyciXSxcd3sxLDQ1fT1bJyJdWyciXTtmb3JcKHZhciBcd3sxLDQ1fT1cd3sxLDQ1fVwubGVuZ3RoLTE7XHd7MSw0NX0+MCI7aTo3MztzOjU2OiJzcmNccyo9XHMqWyciXWRhdGE6dGV4dC9qYXZhc2NyaXB0O2NoYXJzZXQ9dXRmLTg7YmFzZTY0LCI7aTo3NDtzOjYzOiJzcmNccyo9XHMqWyciXWRhdGE6dGV4dC9qYXZhc2NyaXB0O2NoYXJzZXQ9d2luZG93cy0xMjUxO2Jhc2U2NCwiO2k6NzU7czo4NjoiPVxzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXChccypcZCtccyotXHMqXGQrXHMqLFxzKlxkK1xzKi1ccypcZCtccyosXHMqXGQrXHMqLVxzKlxkK1xzKiwiO2k6NzY7czoxNToiXC50cnlteWZpbmdlclwuIjtpOjc3O3M6MTk6Ilwub25lc3RlcHRvd2luXC5jb20iO30="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAP2V4dHJhY3RccypcKCI7aToxO3M6MTQ6IkA/ZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKD9ccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKD9ccyowXHMqXCk/IjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCg/XHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCg/XHMqYmFzZTY0X2RlY29kZVxzKlwoPyI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCg/WyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKD9bJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoP1xzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCg/XHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKD9ccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKD9ccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKT9ccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKD9ccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoP1xzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCg/WyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKD9ccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKD9bJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCg/XHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoP1xzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoP1xzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqWyciXChcJF0iO2k6MTIyO3M6MTE6IlxibWFpbFxzKlwoIjtpOjEyMztzOjQ2OiJmaWxlX2dldF9jb250ZW50c1xzKlwoP1xzKlsnIl17MCwxfXBocDovL2lucHV0IjtpOjEyNDtzOjExODoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfUNvbnRlbnQtdHlwZVsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9dGV4dC9odG1sO1xzKmNoYXJzZXQ9d2luZG93cy0xMjUxWyciXXswLDF9Pjxib2R5PiI7aToxMjU7czo2MjoiPVxzKmRvY3VtZW50XC5jcmVhdGVFbGVtZW50XChccypbJyJdezAsMX1zY3JpcHRbJyJdezAsMX1ccypcKTsiO2k6MTI2O3M6Njk6ImRvY3VtZW50XC5ib2R5XC5pbnNlcnRCZWZvcmVcKGRpdixccypkb2N1bWVudFwuYm9keVwuY2hpbGRyZW5cWzBcXVwpOyI7aToxMjc7czo3NjoiPHNjcmlwdFxzK3R5cGU9InRleHQvamF2YXNjcmlwdCJccytzcmM9Imh0dHA6Ly9bYS16QS1aMC05X10rXC5waHAiPjwvc2NyaXB0PiI7aToxMjg7czoyNzoiZWNob1xzK1snIl17MCwxfW9rWyciXXswLDF9IjtpOjEyOTtzOjE4OiIvdXNyL3NiaW4vc2VuZG1haWwiO2k6MTMwO3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjt9"));
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
                              
define('AI_VERSION', '20170110_BEGET');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter = 0;
$g_SpecificExt = false;

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
ini_set('pcre.backtrack_limit','1000000');
ini_set('pcre.recursion_limit','200000');
ini_set('pcre.jit','1');

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
   return hash('crc32b', $str);
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
		'n' => 'sc',
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
		'skip-cache',
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
      --scan=php,...   Scan only specific extensions. E.g. --scan=php,htaccess,js
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

	if (isset($options['n']) OR isset($options['skip-cache']))
	{
		$defaults['skip_cache'] = true;
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
			$g_SpecificExt = true;
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

      			// if folder in ignore list
      			$l_Skip = false;
      			for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
      			    if (($g_DirIgnoreList[$dr] != '') &&
      			       preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
      			       $l_Skip = true;
		               $l_NeedToScan = false;
      			    }
      			}


			if ($l_IsDir)
			{
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
  $par_Content = preg_replace('/\s+/', ' ', $par_Content);

  $l_Res = '__AI_LINE1__' . $l_LineNo . "__AI_LINE2__  " . ($l_MinPos > 0 ? '…' : '') . substr($par_Content, $l_MinPos, $par_Pos - $l_MinPos) . 
           '__AI_MARKER__' . 
           substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);

  $l_Res = preg_replace('/<\?php/smi', '<?php ', $l_Res);
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
  $par_Content = preg_replace('/[\'"]\s*?\++\s*?[\'"]/smi', '', $par_Content);

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

	if (strpos($par_Filename, 'wp-content/plugins/wp-mobile-detector/resize.php') !== false) {		
		if (strpos($par_Content, 'file_put_contents($path, file_get_contents($_REQUEST[\'src\']));') !== false) {
			$l_Vuln['id'] = 'AFU : https://www.pluginvulnerabilities.com/2016/05/31/aribitrary-file-upload-vulnerability-in-wp-mobile-detector/';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'phpmailer.php') !== false) {		
		if (strpos($par_Content, 'PHPMailer') !== false) {
                        $l_Found = preg_match('~Version:\s*(\d+)\.(\d+)\.(\d+)~', $par_Content, $l_Match);
                        if ($l_Found) {
                           $l_Version = $l_Match[1] * 1000 + $l_Match[2] * 100 + $l_Match[3];
                           if ($l_Version < 2520) {
                              $l_Found = false;
                           }
                        }

		        if (!$l_Found) {
	   		   $l_Vuln['id'] = 'RCE : CVE-2016-10045, CVE-2016-10031';
			   $l_Vuln['ndx'] = $par_Index;
			   $g_Vulnerable[] = $l_Vuln;
			   return true;
                        }
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
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, 
           $g_KnownList,$g_Vulnerable, $g_CriticalFiles;

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

		                $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
                                if ((!AI_HOSTER) && in_array($l_Ext, $g_CriticalFiles)) {
				    $g_CriticalPHP[] = $i;
				    $g_CriticalPHPFragment[] = "BIG FILE. SKIPPED.";
				    $g_CriticalPHPSig[] = "big_1";
                                }
			}
			else
			{
				$g_TotalFiles++;

			$l_TSStartScan = microtime(true);

		$l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
		if (filetype($l_Filename) == 'file') {
                   $l_Content = @file_get_contents($l_Filename);
		   if (SHORT_PHP_TAG) {
//                      $l_Content = preg_replace('|<\?\s|smiS', '<?php ', $l_Content); 
                   }

                   $l_Unwrapped = @php_strip_whitespace($l_Filename);
                }

		
                if ((($l_Content == '') || ($l_Unwrapped == '')) && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult('[io] ' . $l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, '264215fae8356a91afdd3514567f7f50') !== false) {
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
					if ($l_Pos === false) {
                                            $l_Pos = Phishing($l_Filename, $i, $l_Content, $l_SigId);
                                        }

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
           	 	//$l_SigId = myCheckSum($l_Item);
           	 	$l_SigId = getSigId($l_Found);
           	 	return true;
       	 	}
    	}
  	}
  }

  if (AI_EXPERT < 2) {
    	foreach ($gXX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
           	    //$l_SigId = myCheckSum($l_Item);
           	    $l_SigId = getSigId($l_Found);
        	    return true;
	  		}
    	}

	}

    if (AI_EXPERT < 1) {
    	foreach ($gX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
           	 	//$l_SigId = myCheckSum($l_Item);
           	 	$l_SigId = getSigId($l_Found);
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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           return true;
       }

       $offset = $l_Found[0][1] + 1;
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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
//           $l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "Phis: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
       $offset = $l_Found[0][1] + 1;

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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
//           $l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "JS: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }

       $offset = $l_Found[0][1] + 1;

    }

//   if (pcre_error($l_FN, $l_Index)) {  }

  }

if (AI_EXPERT > 1) {
  foreach ($gX_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

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

     return false;
  }

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index, $l_Content, &$l_Pos, &$l_SigId)
{

  global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment,
  $g_CriticalFiles, $g_CriticalEntries;

  // 264215fae8356a91afdd3514567f7f50 H24LKHGHCGHFHGKJHGKJHGGGHJ

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

  if ($l_SkipCheck) {
	  foreach($g_CriticalFiles as $l_Ext) {
  	  	if ((strpos($l_FN, $l_Ext) !== false) && (strpos($l_FN, '.js') === false)) {
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

  foreach ($g_FlexDBShe as $l_Item) {
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 1: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }

       $offset = $l_Found[0][1] + 1;

    }

//   if (pcre_error($l_FN, $l_Index)) {  }

  }

if (AI_EXPERT > 0) {
  foreach ($gX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 3: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }

//   if (pcre_error($l_FN, $l_Index)) {  }
  }
}

if (AI_EXPERT > 1) {
  foreach ($gXX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 2: $l_FN matched [$l_Item] in $l_Pos\n";
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
}

if (AI_HOSTER) return false;

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


$g_DirIgnoreList = array();
$g_IgnoreList = array();
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


$l_SkipMask = array(
            '/template_\w{32}.css',
            '/cache/templates/.{1,150}\.tpl\.php',
            '/cache/minify/minify_\w{32}',
            '/cache/page/\w{32}\.php',
            '/cache/page/\w{32}\.php_expire',
            '/bitrix/cache/\w{32}\.php',
            '/bitrix/cache/.*/\w{32}\.php',
            '/bitrix/managed\_cache/.*/\.\w{32}\.php',
            '/core/cache/mgr/smarty/default/.{1,100}\.tpl\.php',
            '/core/cache/resource/web/resources/[0-9]{1,50}\.cache\.php',
            '/smarty/compiled/SC/.*/%%.*\.php',
            '/smarty/.{1,150}\.tpl\.php',
            '/smarty/compile/.{1,150}\.tpl\.cache\.php',
            '/files/templates_c/.{1,150}\.html\.php',
            '/uploads/javascript_global/.{1,150}\.js',
            '/assets/cache/rss/\w{32}',
            '/t3-assets/dev/t3/.*-cache-\w{1,20}-.{1,150}\.php',
            '/temp/cache/SC/.*/\.cache\..*\.php',
            '/tmp/sess\_\w{32}$',
            '/assets/cache/docid\_.*\.pageCache\.php',
            '/stat/usage\_\w+\.html',
            '/stat/site\_\w+\.html',
            '/gallery/item/list/\w+\.cache\.php',
            '/core/cache/registry/.*/ext-.*\.php',
            '/core/cache/resource/shk\_/\w+\.cache\.php',
            '/awstats/awstats.*\.txt',
            '/awstats/.{1,80}\.pl',
            '/awstats/.{1,80}\.html',
            '/inc/min/styles_\w+\.min\.css',
            '/inc/min/styles_\w+\.min\.js',
            '/logs/error\_log\..*',
            '/logs/xferlog\..*',
            '/logs/access_log\..*',
            '/logs/cron\..*',
);

if (SMART_SCAN) {
   $g_DirIgnoreList = array_merge($g_DirIgnoreList, $l_SkipMask);
}

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

if (true) {
   $g_HeuristicDetected = array();
   $g_Iframer = array();
   $g_Base64 = array();
}


// whitelist

$snum = 0;
$list = check_whitelist($g_Structure['crc'], $snum);

foreach (array('g_CriticalPHP', 'g_CriticalJS', 'g_Iframer', 'g_Base64', 'g_Phishing', 'g_AdwareList', 'g_Redirect') as $p) {
	if (empty($$p)) continue;
	
	$p_Fragment = $p . "Fragment";
	$p_Sig = $p . "Sig";
	if ($p == 'g_Redirect') $p_Fragment = $p . "PHPFragment";
	if ($p == 'g_Phishing') $p_Sig = $p . "SigFragment";

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
if (AI_HOSTER) {
   $g_IframerFragment = array();
   $g_Iframer = array();
   $g_Redirect = array();
   $g_Doorway = array();
   $g_EmptyLink = array();
   $g_HeuristicType = array();
   $g_HeuristicDetected = array();
   $g_WarningPHP = array();
   $g_AdwareList = array();
   $g_Phishing = array(); 
   $g_PHPCodeInside = array();
   $g_PHPCodeInsideFragment = array();
   $g_NotRead = array();
   $g_WarningPHPFragment = array();
   $g_WarningPHPSig = array();
   $g_BigFiles = array();
   $g_RedirectPHPFragment = array();
   $g_EmptyLinkSrc = array();
   $g_Base64Fragment = array();
   $g_UnixExec = array();
   $g_PhishingSigFragment = array();
   $g_PhishingFragment = array();
   $g_PhishingSig = array();
   $g_IframerFragment = array();
   $g_CMS = array();
   $g_AdwareListFragment = array(); 
   $g_Vulnerable = array();
}


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
stdOut("\nLoaded signatures: " . count($g_FlexDBShe) . " / " . count($g_JSVirSig) . "\n");

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

 $l_Summary .= "</table>";

$l_ArraySummary = array();
$l_ArraySummary["redirect"] = count($g_Redirect);
$l_ArraySummary["critical_php"] = count($g_CriticalPHP);
$l_ArraySummary["critical_js"] = count($g_CriticalJS);
$l_ArraySummary["phishing"] = count($g_Phishing);
$l_ArraySummary["unix_exec"] = count($g_UnixExec);
$l_ArraySummary["iframes"] = count($g_Iframer);
$l_ArraySummary["not_read"] = count($g_NotRead);
$l_ArraySummary["base64"] = count($g_Base64);
$l_ArraySummary["heuristics"] = count($g_HeuristicDetected);
$l_ArraySummary["symlinks"] = count($g_SymLinks);
$l_ArraySummary["big_files_skipped"] = count($g_BigFiles);

 $l_Summary .= "<!--[json]" . json_encode($l_ArraySummary) . "[/json]-->";

 $l_Summary .= "<div class=details style=\"margin: 20px 20px 20px 0\">" . AI_STR_080 . "</div>\n";

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

if (!AI_HOSTER) {
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

if (!AI_HOSTER) {
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
     $l_PlainResult .= '[SCAN ERROR / SKIPPED]' . "\n" . printPlainList($g_NotRead) . "\n\n";
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
}

////////////////////////////////////
if (false) {
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

$l_Template = str_replace('@@WARN_QUICK@@', ((SCAN_ALL_FILES || $g_SpecificExt) ? '' : AI_STR_045), $l_Template);

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

      			// if folder in ignore list
      			$l_Skip = false;
      			for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
      				if (($g_DirIgnoreList[$dr] != '') &&
      				   preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
      				   $l_Skip = true;
                                   $l_NeedToScan = false;
      				}
      			}
      					
			if (getRelativePath($l_FileName) == "./" . INTEGRITY_DB_FILE) $l_NeedToScan = false;

			if ($l_IsDir)
			{
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
	$sigs = array_unique($sigs);

	// Add SigId
	foreach ($sigs as &$s) {
		$s .= '(?<X' . myCheckSum($s) . '>)';
	}
	unset($s);
	
	$fix = array(
		'([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e' => '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e',
		'http://.+?/.+?\.php\?a' => 'http://[^?\s]++(?<=\.php)\?a',
		'\s*[\'"]{0,1}.+?[\'"]{0,1}\s*' => '.+?',
		'[\'"]{0,1}.+?[\'"]{0,1}' => '.+?'
	);
	$sigs = str_replace(array_keys($fix), array_values($fix), $sigs);
	
	$fix = array(
		'~^\\\\[d]\+&@~' => '&@(?<=\d..)',
		'~^((\[\'"\]|\\\\s|@)(\{0,1\}\.?|[?*]))+~' => ''
	);
	$sigs = preg_replace(array_keys($fix), array_values($fix), $sigs);

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

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i -= 4 : --$i) {
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
                if (trim($sig) == "") {
                   if (DEBUG_MODE) {
                      echo("************>>>>> EMPTY\n     pattern: " . $sig . "\n");
                   }
	           unset($sigs[$k]);
		   $result = false;
                }

		if (@preg_match('#(' . $sig . ')#smiS', '') === false) {
			$error = error_get_last();
                        if (DEBUG_MODE) {
			   echo("************>>>>> " . $error['message'] . "\n     pattern: " . $sig . "\n");
                        }
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

	$snum = max(0, @filesize($file) - 1024) / 20;
	echo "\nLoaded " . ceil($snum) . " known files\n";
	
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

	$last = floor(strlen($str) / $item_size);
	
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
		return true;
	} else {
		return false;
	}
}

function getSigId($l_Found)
{
	foreach ($l_Found as $key => &$v) {
		if (is_string($key) AND $v[1] != -1 AND strlen($key) == 9) {
			return substr($key, 1);
		}
	}
	
	return null;
}