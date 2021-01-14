<?php
require_once 'Parser.php';

$parser = new Parser();

// Типа контроллер, который решает куда посылать данные из AJAX
if ($_POST['form'] == 'get_main_content') {
    echo $parser->getContent();
} elseif ($_POST['form'] == 'add_short_news') {
    echo $parser->shortLinks($_POST['content']);
} elseif ($_POST['form'] == 'get_long_news') {
    echo $parser->getContent($parser->getLinkLongNews());
} elseif ($_POST['form'] == 'content_news') {
    echo $parser->longNews();
}