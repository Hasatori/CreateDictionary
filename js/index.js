var BASE = $('base').attr("href");

/******************************************************************************************
 ************************************* FROM EXTERNAL  *************************************
 ******************************************************************************************/

localStorage.setItem('count', -1);
localStorage.setItem("result", []);

function startFromExternal() {
    $('.loaderWrapper').attr("style", "display:block;");

    var resultLanguageSelect = document.getElementById("resultLanguage");
    var resultLanguage = resultLanguageSelect.options[resultLanguageSelect.selectedIndex].value;

        $.post(BASE + "/index.php", {

                'start': true,
                'resultLanguage': resultLanguage
            }, function (data, textStatus, jqXHR) {

            }
        ).done(function (data) {
            /**  var data = JSON.parse(data);
             delayedLoop(50, data, 0, resultLanguage);
             */

            $('.loaderWrapper').attr("style", "display:none;");
            $('#result').val(data);
        });

}

function processVocabulary(row, j, resultLanguage) {
    try {
        var json = $.getJSON("https://dictionary.yandex.net/dicservice.json/lookupMultiple?ui=en&srv=tr-text&sid=b85e299c.5b0c66ee.b4b73bca&text=" + row[j][0] + "&dict=en-" + resultLanguage + ".regular&flags=103").done(function (json) {

                try {
                    var source = json["en-" + resultLanguage]["regular"];
                    /**   var firstValue = source["text"];
                     var secondValue = source["tr"][0]["text"];
                     var partOfSpeech = source["pos"]["tooltip"];*/

                } catch (e) {
                    var firstValue = '';
                    /** var secondValue = '';
                     var partOfSpeech = '';*/

                }
                /** try {
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

                 */
                if (firstValue === '') {

                } else {

                    $.post(BASE + "index.php", {

                            'result': source,
                            'resultLanguage': resultLanguage


                        }, function (data, textStatus, jqXHR) {

                        }
                    ).done(function (data) {
                        $('#result').val(firstValue);
                    });
                }


            }
        );
    } catch (e) {
        var firstValue = '';
        /** var secondValue = '';
         var partOfSpeech = '';*/

    }

}

function delayedLoop(delay, data, i, resultLanguage) {

    setTimeout(function () {
        var count = 0;
        var length = data.length;
        var durationOffset = 50;
        var progress = (i / length) * 100;

        $("#progressBar").css('width', progress + '%').attr('aria-valuenow', progress);
        $("#progressNumber").text(Math.round(progress * 100) / 100 + "%");
        //  while (count < 10) {
        processVocabulary(data, i, resultLanguage);
        i++;
        /*   count++;
       }*/
        if (i % durationOffset === 0) {
            var stop = performance.now();
            var start = localStorage.getItem('startFromExternal');

            var difference = Math.round(((stop - start) / durationOffset) * 100) / 100;
            var expectedDuration = (((length - i) * (difference)) / 1000) / 60;
            setDuration(expectedDuration);

            localStorage.setItem('startFromExternal', performance.now());

        }
        if (i < length) {
            delayedLoop($('#delay').val(), data, i, resultLanguage);
        }


    }, delay);


}

function setDuration(expectedDutation) {
    let hours, minutes, seconds, rest;

    if (expectedDutation < 1) {
        expectedDutation = Math.round(60 * expectedDutation * 100) / 100 + 'sekund';

    } else if (expectedDutation > 60) {
        hours = expectedDutation / 60;
        rest = hours % 1;
        hours = hours - rest + 'hodin';
        minutes = Math.round((rest) * 60 * 100) / 100 + " minut";
        expectedDutation = hours + ' ' + minutes;
    } else {
        minutes = Math.round(expectedDutation * 100) / 100;
        rest = minutes % 1;
        minutes = minutes - rest;
        seconds = Math.ceil(Math.round((rest) * 60 * 100) / 100);
        expectedDutation = minutes + ' minut a ' + seconds + ' sekund';
    }
    $("#estimatedDuration").text("Předpokládáná doba trvání: " + expectedDutation);

}

/*********************************************************************************************/

/*******************************************************************************************
 *************************************** FROM LOCAL  ***************************************
 ******************************************************************************************/
function uploadGroupFromLocal() {
    $('.loaderWrapper').attr("style", "display:block;");
    var categoriesList = document.getElementById("categoriesList");
    var caregory = categoriesList.options[categoriesList.selectedIndex].text;
    var separator = document.getElementById('separator').value;
    $.post(BASE + "/local.php", {
            'type': 'group',
            'category': caregory,
            'separator': separator


        }, function (data, textStatus, jqXHR) {

        }
    ).done(function (data) {
            $('.loaderWrapper').attr("style", "display:none;");
            $('#result').val(data);
        }
    );
}

function startLocalUpload(type) {
    $('.loaderWrapper').attr("style", "display:block;");
    $.post(BASE + "/local.php", {


            type: type,


        }, function (data, textStatus, jqXHR) {

        }
    ).done(function (data) {
        $('.loaderWrapper').attr("style", "display:none;");
        $('#result').val(data);
    });

}

/*******************************************************************************************
 *************************************** OXFORD API  ***************************************
 ******************************************************************************************/
function uploadOxfordApiWordLists() {
    $('.loaderWrapper').attr("style", "display:block;");
    $.post(BASE + "/oxfordDicApi.php", {


            'type': "topicWordList",


        }, function (data, textStatus, jqXHR) {

        }
    ).done(function (data) {
        $('.loaderWrapper').attr("style", "display:none;");
        $('#result').val(data);
    });
}

/*******************************************************************************************
 ************************************ TRANSLATION API  *************************************
 ******************************************************************************************/

/*******************************************************************************************
 ************************************** DATAMUSE API  **************************************
 ******************************************************************************************/
function datamuseApiAction(type) {
    $('.loaderWrapper').attr("style", "display:block;");
    $.post(BASE + "/DatamuseApi.php", {


            'type': type,


        }, function (data, textStatus, jqXHR) {

        }
    ).done(function (data) {
        $('.loaderWrapper').attr("style", "display:none;");
        $('#result').val(data);

    });
}

/******************************************************************************************
 ***************************************** UPLOAD  *****************************************
 ******************************************************************************************/
function uploadExternalResults() {
    $('.loaderWrapper').attr("style", "display:block;");
    var sourceFileSelect = document.getElementById('sourceFile');
    var sourceFile = sourceFileSelect.options[sourceFileSelect.selectedIndex].value;

    $.post(BASE + "upload.php", {

            'sourceFile': sourceFile


        }, function (data, textStatus, jqXHR) {

        }
    ).done(function (data) {
        $('.loaderWrapper').attr("style", "display:none;");
        $('#result').val(data);
    });


}