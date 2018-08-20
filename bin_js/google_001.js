// подключаем jQuery
var script   = document.createElement("script");
script.type  = "text/javascript";
script.src   = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js";
document.body.appendChild(script);

// находим нужные элементы
var result = [];

$('div.rg_meta').each(function(){
    //console.log($(this).text());

    var text =  $(this).text().toString().trim();

    if (text.length > 0) {
        var json = JSON.parse(text);

        if (typeof(json.pt) === "string" && typeof(json.s) === "string") {
            result.push({
                "url": json.ou,
                "size": 0,
                "width": json.ow * 1,
                "height": json.oh * 1,

                "title": json.pt.replace(/<\/?[^>]+>/gi, ''),
                "text": json.s.replace(/<\/?[^>]+>/gi, ''),
                "dub": json.ru
            });
        }
    }
});

// выводим в браузер результат
result.forEach(function(item){
    document.write(JSON.stringify(item));
});



document.write($("lang=ru-x-mtfrom-en").html());