$(document).ready(function () {

    var currentPage = window.location.href.toString().replace(/(.*)\/(.*)/, "$2");
    currentPage = currentPage.split('?')[0].split(".")[0];
    var activeElement = document.getElementById(currentPage);
    activeElement.className = activeElement.className + " active";


});
var BASE = $('base').attr("href");


var json = $.getJSON(BASE+"sources/languages.json").done(function (json) {
    ;
    var i = 0;
    var resultSelected, language;

    for (i; i < json.length; i++) {
        language = json[i][1];
        resultSelected = language === "cs" ? "selected" : "";
        $("#resultLanguage").append("<option " + resultSelected + ">" + language + "</option>");
    }


});
localStorage.setItem('count', -1);
localStorage.setItem("result", []);
function start() {

    var sourceFile;
    var resultFile;

    var sourceLanguageSelect = document.getElementById("sourceLanguage");
    var sourceLanguage = sourceLanguageSelect.options[sourceLanguageSelect.selectedIndex].text;
    var reultLanguageSelect = document.getElementById("resultLanguage");
    var resultLanguage = reultLanguageSelect.options[reultLanguageSelect.selectedIndex].text;
    var delay = $("#delay").val();
    try {
        sourceFile = document.getElementById("sourceFile").files[0].name;
    } catch (e) {
        sourceFile = '';
    }

    try {
        resultFile = document.getElementById("resultFile").files[0].name;
    } catch (e) {
        resultFile = '';
    }
    $.post(BASE+"/index.php", {

        'start': true,
        'resultFile': resultFile,
        'sourceFile': sourceFile

    }, function (data, textStatus, jqXHR) {

    }
    ).done(function (data) {
        data = JSON.parse(data);

        $("#error").attr("style", "display:none;");
        if (data[0] === false) {
            $('#error').text(data[1]);
            $("#error").attr("style", "display:block;");
        } else if (data === true) {
            console.log("Source file:" + sourceFile + "\nResult file:" + resultFile);
            jQuery.get('sources/' + sourceFile, function (data) {
                var data = data.split("\n");

                localStorage.setItem('start', performance.now());
                delayedLoop(delay, data, 0, sourceLanguage, resultLanguage, resultFile);

            });
        }
    });


}
function processVocabulary(row, j, sourceLanguage, resultLanguage, resultFile) {

    var json = $.getJSON("https://dictionary.yandex.net/dicservice.json/lookupMultiple?ui=en&srv=tr-text&sid=b85e299c.5b0c66ee.b4b73bca&text=" + row[j] + "&dict=" + sourceLanguage + "-" + resultLanguage + ".regular&flags=103").done(function (json) {

        try {
            var source = json["en-" + resultLanguage]["regular"][0];
            var firstValue = source["text"];
            var secondValue = source["tr"][0]["text"];
            var partOfSpeech = source["pos"]["tooltip"];

        } catch (e) {
            var firstValue = '';
            var secondValue = '';
            var partOfSpeech = '';
        }
        try {
            var synonymsSource = source["tr"][0]['syn'];
            var synonyms = null;
            var synonymsArray = [];
            for (var i = 0; i < synonymsSource.length; i++) {

                synonymsArray.push(synonymsSource[i]["text"]);
            }

        } catch (e) {
            synonymsArray = [""];
        }
        var vocabulary = [];
        vocabulary.push(firstValue);
        vocabulary.push(secondValue);
        vocabulary.push(partOfSpeech);
        vocabulary.push(synonymsArray.join());

        if (firstValue === '') {

        } else {



            $.post(BASE+"index.php", {

                'result': vocabulary,
                'resultFile': resultFile


            }, function (data, textStatus, jqXHR) {

            }
            ).done(function (data) {

            });
        }



    });


}
function delayedLoop(delay, data, i, sourceLanguage, resultLanguage, resultFile) {

    setTimeout(function () {
        var count = 0;
        var length = data.length;
        var durationOffset = 200;
        var progress = (i / length) * 100;

        $("#progressBar").css('width', progress + '%').attr('aria-valuenow', progress);
        $("#progressNumber").text(Math.round(progress * 100) / 100 + "%");
        while (count < 200) {
            processVocabulary(data, i, sourceLanguage, resultLanguage, resultFile);
            i++;
            count++;
        }
        if (i % durationOffset === 0) {
            var stop = performance.now();
            var start = localStorage.getItem('start');

            var difference = Math.round(((stop - start) / durationOffset) * 100) / 100;
            var expectedDuration = (((length - i) * (difference)) / 1000) / 60;
            setDuration(expectedDuration);

            localStorage.setItem('start', performance.now());

        }
        if (i < length) {
            delayedLoop($('#delay').val(), data, i, sourceLanguage, resultLanguage, resultFile);
        }


    }, delay);



}

function setDuration(expectedDutation) {

    if (expectedDutation < 1) {
        expectedDutation = Math.round(60 * expectedDutation * 100) / 100 + 'sekund';

    } else
    if (expectedDutation > 60) {
        var hours = expectedDutation / 60;
        var rest = hours % 1;
        hours = hours - rest + 'hodin';
        var minutes = Math.round((rest) * 60 * 100) / 100 + " minut";
        expectedDutation = hours + ' ' + minutes;
    } else {
        expectedDutation = Math.round(expectedDutation * 100) / 100 + 'minut';
    }
    $("#estimatedDuration").text("Předpokládáná doba trvání: " + expectedDutation);

}

function loadToDatabase() {

    var uploadFile;
    try {
        uploadFile = document.getElementById("uploadFile").files[0].name;
    } catch (e) {
        loadFile = '';
    }
    $.post(BASE+"upload.php", {

        'uploadFile': uploadFile


    }, function (data, textStatus, jqXHR) {

    }
    ).done(function (data) {

    });


}