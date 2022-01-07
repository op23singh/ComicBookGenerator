<?php
$apiUrl = "https://xkcd.com/info.0.json";
$comic_data = json_decode(file_get_contents($apiUrl));
// echo $comic_data->link;
$api_Url_First_part = "https://xkcd.com/";
$api_Url_Second_part = rand(1, (int)$comic_data->num);
$api_Url_third_part = "/info.0.json";
$complete_apiUrl = "$api_Url_First_part$api_Url_Second_part$api_Url_third_part";
$Comic_data = json_decode(file_get_contents($complete_apiUrl));
$img_url = $Comic_data->img;
$img_new = file_put_contents("image.png", file_get_contents($img_url));
$img_full_url = base64_encode(file_get_contents("image.png"));
// echo "<img src=http://localhost/vscode_php/sendgrid/image.png>";