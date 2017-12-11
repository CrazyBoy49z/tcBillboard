<?php

$_lang['area_tcbillboard_main'] = 'Основные';

$_lang['setting_tcbillboard_source_default'] = 'Источник файлов';
$_lang['setting_tcbillboard_source_default_desc'] = 'Источник файлов для титульной картинки.';
$_lang['setting_tcbillboard_limit_introtext'] = 'Максимальное количество символов';
$_lang['setting_tcbillboard_limit_introtext_desc'] = 'Максимальное количество символов для записи в поле introtext.';
$_lang['setting_tcbillboard_date_formate'] = 'Формат даты';
$_lang['setting_tcbillboard_date_formate_desc'] = 'Строка в фрмате PHP date(). Определяет формат даты в открытой части сайта.
    Для определения в менеджере, измените системную настройку "<strong>manager_date_format</strong>"';
$_lang['setting_tcbillboard_number_template'] = 'Шаблон к номеру счёта';
$_lang['setting_tcbillboard_number_template_desc'] = 'Вы можете указать шаблон для номера счёта в произвольной форме. 
    Но шаблон должен заканчиваться строкой в формате PHP date(), помещённой в фигурные скобки.';
$_lang['setting_tcbillboard_to_zero'] = 'Обнулять номер счёта';
$_lang['setting_tcbillboard_to_zero_desc'] = 'С наступлением Нового Года счётчик будет обнуляться.';
$_lang['setting_tcbillboard_delete_day'] = 'Хранить неопубликованные заказы';
$_lang['setting_tcbillboard_delete_day_desc'] = 'Сколько дней будут храниться неопубликованные заказы перед удалением. 
    Укажите ноль "0", чтобы не удалять';
$_lang['setting_tcbillboard_admin_logout_time'] = 'Автовыход из менеджера MODX';
$_lang['setting_tcbillboard_admin_logout_time_desc'] = 'Через сколько минут произойдёт автовыход из менеджера MODX. 
    Установите ноль "0", чтобы отключить автовыход.';
$_lang['setting_tcbillboard_files_limit'] = 'Разрешено загружать файлов';
$_lang['setting_tcbillboard_files_limit_desc'] = 'Максимальное количество файлов к загрузке.';
$_lang['setting_tcbillboard_penalty_activate'] = 'Запустить систему штрафов';
$_lang['setting_tcbillboard_penalty_activate_desc'] = 'Запускает систему штрафов, которую необходимо настроить 
    в настройках компонента, таб Неустойка.';
$_lang['setting_tcbillboard_resource_form'] = 'ID ресурса с формой';
$_lang['setting_tcbillboard_resource_form_desc'] = 'Ресурс, где размещена форма для создания акции';

$_lang['area_tcbillboard_google_map'] = 'Карта Google Map';

$_lang['setting_tcbillboard_google_api_key'] = 'Ключ API Google Maps';
$_lang['setting_tcbillboard_google_api_key_desc'] = "Ключ нужен для использования 
    карт Google Maps, перейдя по ссылке, ты узнаешь как его получить: 
    <a href=\"https://developers.google.com/maps/documentation/javascript/get-api-key\" target=\"_blank\">Google API Console</a>.";
$_lang['setting_tcbillboard_google_map_zoom'] = 'Масштаб карты';
$_lang['setting_tcbillboard_google_map_zoom_desc'] = 'Чем больше число, тем крупнее карта.';
$_lang['setting_tcbillboard_google_map_latitude'] = 'Широта';
$_lang['setting_tcbillboard_google_map_latitude_desc'] = 'При указании широты и долготы, 
    если нет адреса, карта будет открываться в этой точке.';
$_lang['setting_tcbillboard_google_map_longitude'] = 'Долгота';
$_lang['setting_tcbillboard_google_map_longitude_desc'] = 'При указании широты и долготы, 
    если нет адреса, карта будет открываться в этой точке.';

$_lang['area_tcbillboard_bank_transfer'] = 'Банковский перевод';

$_lang['setting_tcbillboard_bank_transfer_name'] = 'Название банка';
$_lang['setting_tcbillboard_bank_transfer_name_desc'] = 'Название банка для для оплаты банковским переводом.';
$_lang['setting_tcbillboard_bank_transfer_iban'] = 'IBAN банка';
$_lang['setting_tcbillboard_bank_transfer_ibandesc'] = 'Международный номер банковского счета.';
$_lang['setting_tcbillboard_bank_transfer_bic'] = 'БИК банка';
$_lang['setting_tcbillboard_bank_transfer_ibandesc'] = 'Код банка.';

$_lang['area_tcbillboard_paypal'] = 'PayPal';

$_lang['setting_tcbillboard_paypal_currency'] = 'Валюта PayPal';
$_lang['setting_tcbillboard_paypal_key_sandbox'] = 'Идентификатор клиента PayPal sandbox';
$_lang['setting_tcbillboard_paypal_key_sandbox_desc'] = 'Идентификатор sandbox для теста PayPal';
$_lang['setting_tcbillboard_paypal_key_production'] = 'Идентификатор клиента PayPal production';
$_lang['setting_tcbillboard_paypal_key_production_desc'] = 'Идентификатор PayPal production';

$_lang['area_tcbillboard_email'] = 'Почта';

$_lang['setting_tcbillboard_email_sender'] = 'Адрес отправителя';
$_lang['setting_tcbillboard_email_sender_desc'] = 'Адрес электронной почты, от имени которого 
    будут отправляться письма пользователям';
$_lang['setting_tcbillboard_email_subject'] = 'Тема письма';
$_lang['setting_tcbillboard_email_to_manager'] = 'ID менеджеров';
$_lang['setting_tcbillboard_email_to_manager_desc'] = 'ID менеджеров, через запятую, которым 
    будут приходить уведомления на почту';
