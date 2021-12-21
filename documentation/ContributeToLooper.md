# Create new content

---

## Create a new controller

1) Create in `app/controllers/` ExampleController.php file.
2) Create the controller class as follows

```PHP
<?php

namespace App\Controllers;

class ExampleController extends Controller
{
    // This page will return the view: yourPhpView
    // in the sub directory: yourDirectory
    function exampleOne(){
        return $this->view('example.exampleOne');
    }
    
    // This one will send variables (array or simple type) to your view
    function exampleTwo($getParameter){
        $myVar = [];
        return $this->view('example.exampleTwo', compact('myVar'));
    }
}
```

## Create your URL

1Create your view in `resources/views` in existing sub directory or your own one. 2Create your route
in `public/index.php`

```PHP
// Simple URL
$router->get('/your/url/one', 'App\Controllers\ExampleController@exampleOne');
// With GET variable
$router->get('/your/url/two/:yourGetVariable', 'App\Controllers\ExampleController@exampleTwo');
// Post content (with get variable for a complete example, it's optionnal)
$router->post('/your/url/two/:yourGetVariable', 'App\Controllers\ExampleController@exampleTwo');
```

## Create a new Model

```PHP
<?php

namespace App\Models;

use App\Database\QueryBuilder; // optionnal, it's an assistant for query string writing

class yourModel extends Model
{
    // your attributes
    
    // Defined by the parent Model
    static public function get(int $id): yourModel |null{//...}
    public function edit(): void {// ..}
    public function remove(): void {// ..}
    public function create(): int|false {// ..}
    public static function toObject(array $params): yourModel|null {// ..}
    public static function toObjectMany(array $params): array {// ..}
    
    // Your setters...
}

```

## Choose header style

Header variables are set in `resources/views/layout.php`. From your own view, you have 4 possibilities of css styles and
2 possibilities to write these headers.

```php
$cssClass  =  "dashboard"; // If you don't set this variable from your view, it will pick dashboard class.
$cssClass  = "heading answering";
$cssClass  = "heading results";
$cssClass  = "heading managing";
```

Create header with simple text:

```PHP
$text = "Your header's text";   // Optionnal, can be empty
```

If you want to use url with Links

```PHP
$useLink = true;
$textLink = "Your url's text";
$urlLink  = "/your/path";
```
