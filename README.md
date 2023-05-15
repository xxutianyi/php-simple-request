# SimpleRequest
Packaged Http Json Request Library use Guzzlehttp

### Install
```
composer require xxutianyi/php-simple-request
```

### Use 
```
use SimpleRequest\Request

$content = Request::get('url','query','headers');
$content = Request::post('url','query','params','form','headers');
$content = Request::put('url','query','params','headers');
$content = Request::delete('url','query','headers');

```
