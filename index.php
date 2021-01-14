<? require_once 'php/constructor_News.php';
require_once 'templates/header.php';
$constructor_News = new constructor_News();
?>
<div class="content">
<?= $constructor_News->constructShortNewsList()?>
    <div class="block-parser">
        <button class="start-parser">Загрузить новости</button>
    </div>
</div>
<?
require_once 'templates/footer.php';
?>

