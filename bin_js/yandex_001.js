// прокручиваем страницу для загрузки картинок
var list = [1000, 2000, 3000, 5000, 8000];

for (var i in list) {
    if (typeof(list[i]) !== "undefined") {
        $(window).scrollTop(list[i]);
    }
}

$('.more__button').click();

var list = [9000, 10000, 12000, 15000, 17000];

for (var i in list) {
    if (typeof(list[i]) !== "undefined") {
        $(window).scrollTop(list[i]);
    }
}

// разбираем полученный результат
var result = [];

$('.serp-item[data-bem]').each(function(){
    var data = $(this).attr('data-bem');

    if (typeof(data) === "string") {
        var json = JSON.parse(data);

        if (typeof(json["serp-item"]) === "object") {
            var obj = json["serp-item"];
            console.log();


            result.push({
                "url": obj.preview[0].url,
                "size": obj.preview[0].fileSizeInBytes * 1,
                "width": obj.preview[0].width * 1,
                "height": obj.preview[0].height * 1,

                "title": obj.snippet.title.replace(/<\/?[^>]+>/gi, ''),
                "text": obj.snippet.text.replace(/<\/?[^>]+>/gi, ''),
                "dub": obj.snippet.url,
            });
        }
    }
});

// выводим в браузер результат
result.forEach(function(item){
    document.write(JSON.stringify(item));
});