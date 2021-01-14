
    function getNewsContent(data, id = '') {
        var header__title = $(data).find('.article__header__title>h1').text();
        var text = $(data).find('.article__text');
        var img = $(text).find('.article__main-image__wrap>img').attr('src');
        var description = $(text).find('p');
        var d_list = [];
        $(description).each(function(i) {
            d_list.push({description: $(description[i]).text()});
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url:  "/parser/index.php",
            data: {
                form : 'content_news',
                title : header__title,
                img : img,
                id : id,
                description : d_list
            },
            success: function (data) {
                if(data == '0'){
                    document.location.href = "/";
                }else{
                    $('.title__news').text(data.title);
                    $('.img__news').attr('src', data.img);
                    $(data.description).each(function(i) {
                        $('.description__news').append('<p>'+data.description[i]['description']+'</p>');
                    });
                }

            },
        });
    }









//Отправляю парсеру, чтобы он взял данные с стр и вернул
    $('.start-parser').on('click', function () {
        $.post(
            "/parser/index.php",
            {
                form : 'get_main_content'
            },
            onAjaxSuccess
        );
        function onAjaxSuccess(data) {
            getLinks(data);
        }
    });
//Обрабатыва и отправляю данные с парсера, после вношу их в бд
    function getLinks(data) {
        var links = $(data).find('a[data-yandex-name="from_news_feed"]');
        var linksList = [];
        //Перебераю ссылки с сайдбара
        $(links).each(function(link) {
            linksList.push({link: $(links[link]).attr('href'),
                id: $(links[link]).attr('id'),
                title: $(links[link]).find('.news-feed__item__title').text()});
        });
        $.post(
            "/parser/index.php",
            {
                form : 'add_short_news',
                content : linksList
            },
            onAjaxSuccess
        );
        function onAjaxSuccess(data) {
            window.location.reload();
        }
    }
