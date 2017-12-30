<?php
include_once 'setting.inc.php';

$_lang['tcbillboard'] = 'tcBillboard';
$_lang['tcbillboard_menu_desc'] = 'Управление заказами.';
$_lang['tcbillboard_active'] = 'Активно';
$_lang['tcbillboard_enabled'] = 'Включено';
$_lang['tcbillboard_enable'] = 'Включить';
$_lang['tcbillboard_disable'] = 'Отключить';
$_lang['tcbillboard_remove'] = 'Удалить';
$_lang['tcbillboard_actions'] = 'Действия';
$_lang['tcbillboard_create'] = 'Создать';
$_lang['tcbillboard_settings'] = 'Einstellungen';
$_lang['tcbillboard_settings_desc'] = 'Настройки Доски Объявлений.';
$_lang['tcbillboard_name'] = 'Имя';
$_lang['tcbillboard_update'] = 'Изменить';
$_lang['tcbillboard_reset'] = 'Очистить';
$_lang['tcbillboard_download'] = 'Скачать';
$_lang['tcbillboard_download_all'] = 'Скачать всё';
$_lang['tcbillboard_download_csv'] = 'Скачать CSV';
$_lang['tcbillboard_description'] = 'Описание';
$_lang['tcbillboard_all'] = 'Все';
$_lang['tcbillboard_select_one_field'] = 'Выберите хотя бы одно поле';
$_lang['tcbillboard_days'] = 'Дней';
$_lang['tcbillboard_formula'] = 'Формула';
$_lang['tcbillboard_email_chunk'] = 'Чанк письма';
$_lang['tcbillboard_percent'] = 'Процент';
$_lang['tcbillboard_fine'] = 'Штраф';
$_lang['tcbillboard_formed'] = 'Сформирован';
$_lang['tcbillboard_notice'] = 'Предупреждений';
$_lang['tcbillboard_num_invoice'] = 'Номер инвойса';
$_lang['tcbillboard_sum_order'] = 'Сумма к оплате';
$_lang['tcbillboard_bank'] = 'Банковские реквизиты';
$_lang['tcbillboard_bank_success'] = "Ваш заказ успешно размещён.<br />Спасибо, что пользуетесь нашим сайтом!";
$_lang['tcbillboard_open'] = 'Открыть акцию';
$_lang['tcbillboard_success'] = 'Успех';
$_lang['tcbillboard_failed'] = 'Нет данных';
$_lang['tcbillboard_importing'] = 'Импортирую';

$_lang['tcbillboard_multiple_remove'] = 'Удалить выбранное';

$_lang['tcbillboard_price'] = 'Прайс';
$_lang['tcbillboard_price_intro'] = "Можно указать сколько угодно периодов с индивидуальными ценами для каждого периода, 
    кроме этого, для каждого льготного периода можно установить свою цену. <br />
    В случае, если для льготного периода цена не установлена, то в этот период плата не начисляется.<br />
    В колонке \"Период (дней)\" указывается количество дней, а в колонке \"Цена за единицу\" - 
    цена, которая действует, начиная с указанного дня, например: если указать \"11\", 
    то установленная цена будет действовать начиная с одиннадцатого дня. Если 
    <strong>tcBillboard</strong> не встретит большее число, то эта цена будет 
    действовать на любой период, начиная от одиннадцати дней заказа. 
    Иначе подхватит следующую цену, начиная от указанного дня.";
$_lang['tcbillboard_price_create'] = 'Добавить цену';
$_lang['tcbillboard_price_update'] = 'Изменить цену';
$_lang['tcbillboard_price_period'] = 'Период (дней)';
$_lang['tcbillboard_price_price'] = 'Цена за единицу';
$_lang['tcbillboard_price_price_unit'] = 'Цена';
$_lang['tcbillboard_price_period_unit'] = 'Укажите период';
$_lang['tcbillboard_price_graceperiod'] = 'Льготный период (по)';
$_lang['tcbillboard_price_graceperiod_start'] = 'Льготный период (от)';
$_lang['tcbillboard_price_graceperiodprice'] = 'Цена в льготный период';
$_lang['tcbillboard_price_formula'] = 'Формула';
$_lang['tcbillboard_price_remove'] = 'Удалить Цену';
$_lang['tcbillboard_prices_remove'] = 'Удалить все цены';
$_lang['tcbillboard_price_remove_confirm'] = 'Вы уверены, что хотите удалить эту цену?';
$_lang['tcbillboard_prices_remove_confirm'] = 'Вы уверены, что хотите удалить все эти цены?';
$_lang['tcbillboard_price_disable'] = 'Отключить Цену';
$_lang['tcbillboard_prices_disable'] = 'Отключить все цены';
$_lang['tcbillboard_price_enable'] = 'Включить Цену';
$_lang['tcbillboard_prices_enable'] = 'Включить все цены';
$_lang['tcbillboard_price_graceperiod_price'] = 'Цена в льготный период';
$_lang['tcbillboard_price_formula'] = 'Формула';

$_lang['tcbillboard_status'] = 'Статус';
$_lang['tcbillboard_statuses'] = 'Статусы';
$_lang['tcbillboard_statuses_intro'] = 'Заполнить..........';
$_lang['tcbillboard_status_email_user'] = 'Письмо клиенту';
$_lang['tcbillboard_status_email_manager'] = 'Письмо менеджеру';
$_lang['tcbillboard_status_final'] = 'Итоговый';
$_lang['tcbillboard_status_final_help'] = 'Если статус является итоговым, его нельзя переключить на другой.';
$_lang['tcbillboard_status_fixed'] = 'Фиксирует';
$_lang['tcbillboard_status_fixed_help'] = 'Запрещает переключение на статусы, которые в таблице идут раньше него.';
$_lang['tcbillboard_status_rank'] = 'Ранг';
$_lang['tcbillboard_status_create'] = 'Добавить статус';
$_lang['tcbillboard_status_select'] = 'Выберите статус';
$_lang['tcbillboard_status_color'] = 'Цвет';
$_lang['tcbillboard_status_subject_user'] = 'Тема письма покупателю';
$_lang['tcbillboard_status_subject_manager'] = 'Тема письма менеджеру';
$_lang['tcbillboard_status_chunk_user'] = 'Чанк письма покупателю';
$_lang['tcbillboard_status_chunk_manager'] = 'Чанк письма менеджеру';
$_lang['tcbillboard_status_remove'] = 'Удалить статус';
$_lang['tcbillboard_statuses_remove'] = 'Удалить все статусы';
$_lang['tcbillboard_status_remove_confirm'] = 'Вы уверены, что хотите удалить этот статус?';
$_lang['tcbillboard_statuses_remove_confirm'] = 'Вы уверены, что хотите удалить все эти статусы?';

$_lang['tcbillboard_payment'] = 'Оплата';
$_lang['tcbillboard_payment_intro'] = 'Заполнить..........';
$_lang['tcbillboard_payment_name'] = 'Zahlungsmethode';
$_lang['tcbillboard_payment_create'] = 'Добавить способ оплаты';
//$_lang['tcbillboard_payment_name'] = 'Способ оплаты';
//$_lang['tcbillboard_payment_create'] = 'Добавить способ оплаты';

$_lang['tcbillboard_penalty'] = 'Неустойка';
$_lang['tcbillboard_penalty_intro'] = "Если это первая установка, то по умолчанию эта настройка выключена. 
    Для включения необходимо активировать системную настройку <strong>tcbillboard_penalty_activate</strong>.<br />
    Ну и конечно же настроить систему штрафов/неустойки. Пример настроек:<br />
    Во второй колонке указывается количество дней, по истечении которых, к клиенту применяется неустойка. 
    Неустойка высчитывается по формуле из колонки <strong>\"Формула\"</strong>, которая должна содержать законченное математическое 
    выражение, которое, в свою очередь, будет подставлено к сумме ордера для получения итоговой стоимости 
    заказа.<br />Формула формируется автоматически из колонок <strong>\"Процент\"</strong> и 
    <strong>\"Штраф\"</strong>. Если в этих колонках указать \"0\" <strong>ноль</strong> - 
    будет означать <strong>\"incasso\"</strong>, после достижения укзанного дня, 
    объявление снимается с публикации и считается, что клиент отказался от оплаты.";
$_lang['tcbillboard_penalty_create'] = 'Добавить формулу неустойки';
$_lang['tcbillboard_penalty_many_days_to'] = 'Через сколько дней';
$_lang['tcbillboard_penalty_formula'] = 'Формула';
$_lang['tcbillboard_penalty_update'] = 'Изменить неустойку';
$_lang['tcbillboard_penalty_remove'] = 'Удалить неустойку';
$_lang['tcbillboard_penalties_remove'] = 'Удалить все неустойки';
$_lang['tcbillboard_penalty_remove_confirm'] = 'Вы уверены, что хотите удалить эту неустойку?';
$_lang['tcbillboard_penalties_remove_confirm'] = 'Вы уверены, что хотите удалить эти неустойки?';
$_lang['tcbillboard_penalty_chunk'] = 'Чанк писма для этой неустойки';

$_lang['tcbillboard_orders'] = 'Заказы';
$_lang['tcbillboard_order'] = 'Ордер';
$_lang['tcbillboard_order_management'] = 'Управление заказами';
$_lang['tcbillboard_createdon'] = 'Bestellungsdatum';
$_lang['tcbillboard_user_id'] = 'Kunde';
$_lang['tcbillboard_pubdatedon'] = 'Дата публикации';
$_lang['tcbillboard_unpubdatedon'] = 'Zurückziehen am';
$_lang['tcbillboard_account'] = 'Стоимость';
$_lang['tcbillboard_paymentdate'] = 'Дата оплаты';
$_lang['tcbillboard_orders_after'] = 'Выбрать заказы с';
$_lang['tcbillboard_orders_before'] = 'Выбрать заказы по';
$_lang['tcbillboard_order_update'] = 'Изменить ордер';
$_lang['tcbillboard_order_ad'] = 'Объявление';
$_lang['tcbillboard_stock_name'] = 'Aktion';
$_lang['tcbillboard_order_createdon'] = 'Дата создания';
$_lang['tcbillboard_order_paymentdate'] = 'Дата оплаты';
$_lang['tcbillbord_order_cost'] = 'Стоимость заказа';
$_lang['tcbillboard_order_details'] = 'Детали заказа';
$_lang['tcbillboard_order_pay'] = 'К оплате';
$_lang['tcbillboard_orders_remove'] = 'Удалить ордера';
$_lang['tcbillboard_order_remove'] = 'Удалить ордер';
$_lang['tcbillboard_orders_remove_confirm'] = 'Вы уверены, что хотите удалить эти ордера';
$_lang['tcbillboard_order_remove_confirm'] = 'Вы уверены, что хотите удалить этот ордер';

$_lang['tcbillboard_invoice'] = 'Rechnung';
$_lang['tcbillboard_invoice_downloaded'] = 'Скачан';
$_lang['tcbillboard_invoice_file'] = 'Файл';
$_lang['tcbillboard_invoice_msg'] = "Счета-фактуры, выписанные при размещении заказа.<br /> 
    Файлы хранятся в стандартной папке MODX: <strong>/core/export/</strong>, по принципу: 
    <strong>/год/месяц/день/пользователь/invoice/файл</strong>";

$_lang['tcbillboard_warning'] = 'Mahnungen';
$_lang['tcbillboard_warning_msg'] = 'Заполнить.....';

$_lang['tcbillboard_front_select_category'] = 'W&auml;hlen Sie eine Kategorie aus';
$_lang['tcbillboard_front_titular_text'] = 'Wenn Sie kein Titelbild zur Ihrer Aktion ausw&auml;hlen, wird dann Ihr Firmenlogo ausgestellt';
$_lang['tcbillboard_front_change'] = '&Auml;ndern';
$_lang['tcbillboard_front_remove'] = 'L&ouml;schen';
$_lang['tcbillboard_describe_your_action'] = "Beschreiben Sie <span style=\"color: red;\">kurz</span> Ihre Aktion";
$_lang['tcbillboard_front_expand'] = 'Weiter';
$_lang['tcbillboard_front_duration_of_promotion'] = 'Aktion gültig vom';
$_lang['tcbillboard_front_duration_of_action'] = 'Aktionsdauer';
$_lang['tcbillboard_front_with'] = 'von';
$_lang['tcbillboard_front_by'] = 'bis';
$_lang['tcbillboard_front_promotion_displayed'] = 'Ausstellungsdauer der Werbung';
$_lang['tcbillboard_front_payment_method'] = 'Zahlungsmethode';
$_lang['tcbillboard_front_bank_transfer'] = 'Banküberweisung';
$_lang['tcbillboard_front_paypal'] = 'PayPal';
$_lang['tcbillboard_front_price_day'] = 'Цена в день';
$_lang['tcbillboard_front_price_grace_period'] = 'Цена в льготный период';
$_lang['tcbillboard_front_grace_day'] = 'Льготных дней';
$_lang['tcbillboard_front_just_day'] = 'Всего дней';
$_lang['tcbillboard_front_amount_grace_period'] = 'Сумма за льготный период';
$_lang['tcbillboard_front_total'] = 'Итого';
$_lang['tcbillboard_front_complete_payment'] = 'Завершить оплату';
$_lang['tcbillboard_front_success_payment'] = 'Ваш платёж успешно обработан. Спасибо!';
$_lang['tcbillboard_front_select_payment'] = 'Осталось оплатить заказ, выбрав один из способов оплаты.';
$_lang['tcbillboard_front_data_order'] = 'Данные заказа';

$_lang['tcbillboard_email_subject_new_manager'] = 'На сайте новая публикация';
$_lang['tcbillboard_email_subject_paid_user'] = 'Произведена оплата';
$_lang['tcbillboard_email_subject_paid_manager'] = 'Поступила оплата';
$_lang['tcBillboard_email_subject_cancelled_user'] = 'Ваш заказ отменён';

$_lang['tcbillboard_import_csv'] = 'Импорт CSV';
$_lang['tcbillboard_import_csv_msg'] = 'Для правильной работы импорта, необходимо в системных настройках указать 
    названия колонок';
$_lang['tcbillboard_import_csv_file'] = 'Загрузить CSV файл';
$_lang['tcbillboard_import'] = 'Импортировать';
$_lang['tcbillboard_import_failed'] = 'Нет данных для импорта. Проверьте файл.';
$_lang['tcbillboard_import_success'] = 'Импорт завершён успешно!';

$_lang['tcbillboard_err_empty_payment'] = 'Не смог записать метод оплаты.';
$_lang['tcbillboard_err_access_denied'] = 'Доступ запрещен.';
$_lang['tcbillboard_err_get_object'] = 'Ошибка получения объекта.';
$_lang['tcbillboard_err_period'] = 'Вы должны указать период.';
$_lang['tcbillboard_err_period_ae'] = 'Такой период уже существует.';
$_lang['tcbillboard_err_price'] = 'Вы должны указать цену.';
$_lang['tcbillboard_err_price_ns'] = 'Прайс не указан.';
$_lang['tcbillboard_err_price_nf'] = 'Прайс не найден.';
$_lang['tcbillboard_err_unpub_pub'] = 'Дата отмены публикации не может быть меньше, или равным, даты начала публикации.';
$_lang['tcbillboard_err_endstock_end'] = 'Дата окончания акции не может быть меньше, или равным, даты начала акции.';
$_lang['tcbillboard_err_graceperiod_start'] = 'Дата начала льготного периода не может быть больше  
    даты окончания льготного периода.';
$_lang['tcbillboard_err_empty_snippet'] = 'tcBillboard. Указанный сниппет не найден. Возможно не установлен Ticket - требуется ';
$_lang['tcbillboard_err_empty_action'] = 'tcBillboard. Получен пустой запрос.';
$_lang['tcbillboard_err_get_price'] = 'tcBillboard. Не смог получить прайс.';
$_lang['tcbillboard_err_order_save'] = 'tcBillboard. Ошибка во время записи ордера.';
$_lang['tcbillboard_err_status_name'] = 'Вы должны указать статус.';
$_lang['tcbillboard_err_status_ae'] = 'Такой статус уже существует.';
$_lang['tcbillboard_err_status_ns'] = 'Статус не указан.';
$_lang['tcbillboard_err_status_nf'] = 'Статус не найден.';
$_lang['tcbillboard_err_status_get'] = 'tcBillboard. Указанный ID статуса в базе данных не найден или не активирован';

$_lang['tcbillboard_err_order_ns'] = 'Ордер не указан.';
$_lang['tcbillboard_err_order_nf'] = 'Ордер не найден.';

$_lang['tcbillboard_err_payment_name'] = 'Вы должны указать способ оплаты.';
$_lang['tcbillboard_err_payment_ns'] = 'Способ оплаты не указан.';
$_lang['tcbillboard_err_payment_nf'] = 'Способ оплаты не найден.';
$_lang['tcbillboard_err_payment_ae'] = 'Такой способ оплаты уже существует.';

$_lang['tcbillboard_err_penalty_ns'] = 'Неустойка не указана.';
$_lang['tcbillboard_err_penalty_nf'] = 'Неустойка не найдена.';
$_lang['tcbillboard_err_penalty_table'] = 'tcBillboard. Не заполнена таблица Неустойка';
$_lang['tcbillboard_err_request_penalty'] = 'tcBillboard. Ошибка создания файла предупреждения.';

$_lang['tcbillboard_err_ae'] = 'Это поле должно быть уникально';
$_lang['tcbillboard_err_email_send'] = 'tcBillboard. При попытке отправить письмо произошла ошибка:';
$_lang['tcbillboard_err_service'] = 'tcBillboard. Ошибка инициализации класса';
$_lang['tcbillboard_err_delete_resource'] = 'tcBillboard. Ошибка удаления ресурса';
$_lang['tcbillboard_err_file_upload'] = 'Вы пытаесь загрузить файлов больше, чем разрешено! Разрешено: ';
$_lang['tcbillboard_err_to_export_files'] = 'Ошибка при попытке экспорта файла или файлов';
$_lang['tcbillboard_err_amount_days'] = 'Вы должны указать количество дней';
$_lang['tcbillboard_err_amount_days_ae'] = 'Такое количество дней уже существует';
$_lang['tcbillboard_err_email_to_manager'] = 'tcBillboard. Вы забыли в системных настройках 
    указать ID менеджеров, которым будут приходить email-уведомления';
$_lang['tcbillboard_err_email_chunk_user'] = 'tcBillboard. Чанк уведомления пользователя не найден ID = ';
$_lang['tcbillboard_err_email_chunk_manager'] = 'tcBillboard. Чанк уведомления менеджеров не найден ID = ';

$_lang['tcbillboard_err_user_not'] = 'Вы пытаетесь оплатить публикацию, которая вам не принадлежит. 
    Просьба связаться с администрацией сайта.';
$_lang['tcbillboard_err_order_not'] = 'Публикация, которую Вы пытаетесь оплатить, не найдена';
$_lang['tcbillboard_err_text_amount'] = 'tcBillboard. Не смог получить названия колонок. Проверьте системные настройки';