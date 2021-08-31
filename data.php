<?php
require_once './config/config_public.php';

$resp = [];
$recipes = $mysqli->query("SELECT * FROM cousine");
while ($f = $recipes->fetch_assoc()) {
    $recipe = $f;
    $ingredients = $mysqli->query("
        SELECT * FROM cousine_ingredients
        LEFT JOIN ingredients ON cousine_ingredients.id_ingredients = ingredients.id 
        WHERE id_cousine = ".$f['id']."
        ORDER BY `order`");
    $recipe['ingredients'] = [];
    while ($f = $ingredients->fetch_assoc()) {
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