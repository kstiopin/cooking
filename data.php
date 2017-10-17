<?php
setlocale ("LC_TIME", "ru_RU");
// DB connection

$connection = @mysql_connect($db_host, $db_user, $db_password) or die("DB error connecting");
mysql_select_db($db_name, $connection);
mysql_query("SET NAMES utf8");

$resp = [];
$recipes = mysql_query("SELECT * FROM cousine");
while ($f = mysql_fetch_assoc($recipes)) {
    $recipe = $f;
    $ingredients = mysql_query("SELECT * FROM cousine_ingredients LEFT JOIN ingredients ON cousine_ingredients.id_ingredients = ingredients.id WHERE id_cousine = ".$f['id']." ORDER BY `order`");
    $recipe['ingredients'] = [];
    while ($f = mysql_fetch_assoc($ingredients)) {
        $recipe['ingredients'][] = $f;
    }
    $recipe['photos'] = [];
    $i = 1;
    while (file_exists('./photos/'.$recipe['id'].'-'.$i.'.jpg')) {
        $recipe['photos'][] = $recipe['id'].'-'.$i++.'.jpg';
    }
    $resp[] = $recipe;
}

die(json_encode($resp));