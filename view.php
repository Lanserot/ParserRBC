<? require_once 'templates/header.php'; ?>
<div class="content">
    <a href="/">Назад</a>

    <h2 class="title__news">

    </h2>
    <img src="" class="img__news" alt="">
    <div class="description__news">

    </div>
</div>


<script>
//    Скрипт должен срабатывать при загрузке этой стр
$(document).ready(function () {
    var id_RBC = '<?= $_GET['id'] ?>';
    $.post(
        "/parser/index.php",
        {
            form : 'get_long_news',
            id : id_RBC
        },
        onAjaxSuccess
    );
    function onAjaxSuccess(data) {
        getNewsContent(data, id_RBC);
    }
})
</script>
<?
require_once 'templates/footer.php';
?>