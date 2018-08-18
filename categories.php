<?php
require_once 'backend/Libraries.php';
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $voc = getVocForCategory($category);
}
buildHeader("Yandex API");
buildNavBar("Yandex API");
?>
    <div class="row localSection">
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" id="searchField" placeholder="Hledat kategorii.." value=""
                       oninput="searchCategory()">
            </div>
            <ul class="list-group" id="caregoriesList">
                <?php
                foreach (getCategories() as $category) {
                    echo ' <li class="list-group-item category"><a href="' . BASE . '/categories.php?category=' . $category["topic"] . '">' . $category["topic"] . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="result">Výsledek</label>
                <textarea class="form-control rounded-0" id="result" rows="100"><?php if (isset($voc)) {
                        foreach ($voc as $value) {
                            $translation = @translate("en", "cs", $value["english_value"])[0];
                            if ($translation != null) {
                                $translation = "    => " . $translation;
                            }
                            echo $value["english_value"] . $translation . "\n";
                        }
                    } ?></textarea>
            </div>
        </div>
    </div>
    <script>

        function searchCategory() {
            var searchField = document.getElementById("searchField");
            var searchFieldValue = searchField.value;
            localStorage.setItem("searchVal", searchFieldValue);

            $(".category").each(function (i) {
                if (!$(this).children("a").text().toLowerCase().match(searchFieldValue.toLowerCase())) {
                    $(this).css("display", "none");
                } else {
                    $(this).css("display", "block");
                }
            });
        }
    </script>
<?php

buildFooter();