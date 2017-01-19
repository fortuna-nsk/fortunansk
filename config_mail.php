<?php
/*

Имя сервера — smtp.mail.ru;
Порт — 465;
SSL — SSL/TLS;
Аутентификация — Обычный пароль.


$__smtp = array(
    "host" => "smtp.mail.ru", //smtp сервер
    "debug" => 2,                   //отображение информации дебаггера (0 - нет вообще)
    "auth" => true,                 //сервер требует авторизации
    "port" => 465,                    //порт (по-умолчанию - 25)
    "username" => "podborka-arenda",//имя пользователя на сервере
    "password" => "khyuiop12",//пароль
    "addreply" => "podborka-arenda@mail.ru",//ваш е-mail
    "replyto" => "podborka-arenda@mail.ru"      //e-mail ответа
);

*/

// Настройки для MY site

// Настройки Email
$site['from_name'] = 'podborka-arenda'; // from (от) имя
$site['from_email'] = 'podborka-arenda@mail.ru'; // from (от) email адрес
// На всякий случай указываем настройки
// для дополнительного (внешнего) SMTP сервера.
$site['smtp_mode'] = 'enabled'; // enabled or disabled (включен или выключен)
$site['smtp_host'] = 'smtp.mail.ru';
$site['smtp_port'] = '465';
$site['smtp_username'] = 'podborka-arenda';


?>