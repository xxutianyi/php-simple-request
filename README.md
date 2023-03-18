# SimpleRequest
Packaged Http Json Request Library use Guzzlehttp

### Install
```
composer require xxutianyi/php-simple-request
```

### Use 
```
use SimpleRequest\Request

$resquest = Request::get('url','query','headers');
$resquest = Request::post('url','query','params','form','headers');
$resquest = Request::put('url','query','params','headers');
$resquest = Request::delete('url','query','headers');

$content = $request->getContent();

```
