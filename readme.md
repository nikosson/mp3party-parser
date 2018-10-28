# Парсер сайта mp3party.net

## Установка

  * ```composer install```
  * ```cp .env.example .env```
  * ```php artisan key:generate```
  * ```php artisan migrate```
  * ```php artisan storage:link```
  * Сконфигурируйте настройки базы в .env файле
 
## Консольные команды
Спарсить сайт http://m3party.net и записать необходимую информацию в базу.

При отсутствии аргумента ``` artistId ``` будет выбран список тестовых ```artistId```. 

```php artisan mp3party:parse-artists-tracks {?artistId}```

Загрузить ранее спарсеные треки. 

```php artisan mp3party:download-parsed-tracks```

## Доступные роуты
```http://yourapp.test``` - показывает список всех ранее спарсеных артистов.

```http://yourapp.test/{artistId}``` - показывает страницу конкретного артиста и скачанные для него треки.

## Примечание
Так как операция загрузки треков есть достаточно трудоемкой(команда ```php artisan mp3party:download-parsed-tracks```), 
есть возможность использовать очереди. 

По дефолту есть возможность использовать драйвер ```database``` - для этого в файле .env задайте свойству ```QUEUE_CONNECTION=database``` значение.

Так же можно использовать другие драйверы очередей, которые поддерживает Laravel: [список доступных драйверов](https://laravel.com/docs/5.7/queues#driver-prerequisites). 


