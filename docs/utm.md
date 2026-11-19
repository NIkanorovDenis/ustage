# UTM-метки и CRM

## Проблема

Метки приходят только в URL первого захода. К моменту отправки формы или оформления заказа в URL их уже нет, поэтому сайт отправлял в CRM только `UTM_SOURCE` — со значением из свойства инфоблока/заказа (название формы: «Корзина», «Обратный звонок» и т.д.). Остальные поля оставались пустыми.

## Как работает

1. `local/php_interface/utm.php` подключается в `bitrix/php_interface/init.php`.
2. На каждом хите `ustageUtmCapture()` проверяет `utm_source`, `utm_medium`, `utm_campaign`, `utm_content`, `utm_term`:
   - сначала в query string;
   - если query пустой (например, редирект потерял параметры) — в `HTTP_REFERER`.
3. Найденные значения объединяются с уже сохранёнными и пишутся в cookie `USTAGE_UTM` (JSON, `HttpOnly`, `SameSite=Lax`, срок 90 дней, домен без `www`).
4. Перед отправкой данных в CRM вызывается `ustageUtmApplyToCrmFields()`:
   - формы — в `crmDeals()` (`bitrix/php_interface/crm.php`);
   - заказы — в `OnSaleOrderSavedHandler()` (`bitrix/php_interface/crm.php`).

## Что уходит в CRM

`UTM_SOURCE` не перезаписывается — в нём остаётся название формы. Дополнительно в payload добавляются:

- `utm_source`, `utm_medium`, `utm_campaign`, `utm_content`, `utm_term` — реальные метки;
- `UTM_MEDIUM`, `UTM_CAMPAIGN`, `UTM_CONTENT`, `UTM_TERM` — стандартные поля сделки Битрикс24;
- `UF_CRM_...` — коды пользовательских полей сделки из `local/php_interface/utm_fields.php`.

## Коды полей `UF_CRM_*`

Пользовательские поля Битрикс24 заполняются только по коду (`UF_CRM_...`),
название поля роли не играет. Поэтому одних ключей `utm_source` недостаточно:
сайт дополнительно отправляет значения под кодами из
`local/php_interface/utm_fields.php`.

По умолчанию там читаемые коды (`UF_CRM_UTM_SOURCE` и т.д.) — они подходят,
если поля создавались через REST с такими кодами. Если в CRM коды числовые
(например, `UF_CRM_1698765432`), их нужно вписать в этот файл:

```php
return [
    'utm_source'   => 'UF_CRM_1698765432',
    'utm_medium'   => 'UF_CRM_1698765433',
    'utm_campaign' => 'UF_CRM_1698765434',
    'utm_content'  => 'UF_CRM_1698765435',
    'utm_term'     => 'UF_CRM_1698765436',
];
```

Код поля виден в Битрикс24: CRM → Сделки → Настройки полей → выбрать поле
(код отображается в адресной строке/параметрах поля).

Приёмник `https://b24rest.ustage-group.ru/app/ustage_v1/form_site.php`
(компонент `ustage_v1:form_site` на портале `b24.ustage-group.ru`) передаёт
полученные ключи в `crm.deal.add`, поэтому коды `UF_CRM_*` попадают в поля
сделки. Если компонент фильтрует ключи, правка нужна на стороне портала.

## Проверка

```bash
curl -s -c /tmp/utm.jar -o /dev/null \
  'https://ustage-group.ru/?utm_source=yandex&utm_medium=cpc&utm_campaign=led'
grep USTAGE_UTM /tmp/utm.jar
```

В cookie должен появиться JSON с метками. После отправки формы/заказа
значения попадают в `_orderData.log` в корне сайта (поле `$arFields`).
