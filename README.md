# SimpleRequest
Packaged Http Json Request Library use Guzzlehttp

## Install
```shell
composer require xxutianyi/simple-request
```
## Use
```php
use SimpleRequest\Request

$content = Request::get('url','query','headers');
$content = Request::post('url','query','json','headers');
$content = Request::put('url','query','json','headers');
$content = Request::delete('url','query','headers');
```