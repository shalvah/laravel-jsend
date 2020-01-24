# laravel-jsend

[![Latest Stable Version](https://poser.pugx.org/shalvah/laravel-jsend/v/stable)](https://packagist.org/packages/shalvah/laravel-jsend) [![Total Downloads](https://poser.pugx.org/shalvah/laravel-jsend/downloads)](https://packagist.org/packages/shalvah/laravel-jsend)
[![Build Status](https://travis-ci.com/shalvah/laravel-jsend.svg?branch=master)](https://travis-ci.com/shalvah/laravel-jsend)

Simple helpers to generate [JSend-compliant](https://labs.omniti.com/labs/jsend) responses for your Laravel app

The [JSend specification](https://labs.omniti.com/labs/jsend) lays down some rules for how JSON responses from web servers should be formatted. JSend is especially suited for REST-style applications and APIs.

## Usage
In your controller:

```php
public function create(Request $request)
{
  $userData = $request->input('data');
  if (empty($userData['email']))
      return jsend_fail(['email' => 'Email is required']);
  
  try {
      $user = User::create($userData):
      return jsend_success($user);
  } catch (Exception $e) {
      return jsend_error('Unable to create user: '.$e->getMessage());
  }
}
```

You can also add the `JsendExceptionFormatter` trait in `App\Exceptions\Handler` to format JSON responses for unhandled exceptions and Laravel validation errors as JSend:
```php
class Handler extends ExceptionHandler
{
    use Shalvah\LaravelJsend\JsendExceptionFormatter;
    
    // ...
}
```

## Available helpers
### `jsend_success`
The `jsend_success` function creates a JSend **success** response instance.
```php
return jsend_success([
  "id" => 2,
  "title" => "New life",
  "body" => "Trust me, this is great!"
]);
```

Generates a response:
```json
{
  "status": "success",
  "data": {
    "id": 2,
    "title": "New life",
    "body": "Trust me, this is great!"
  }
}
```
You may pass an Eloquent model instead of an array as the "data" object:

```php
$post = Post::find($id);
return jsend_success($post);
```

### `jsend_fail`
The `jsend_fail` function creates a JSend **fail** response instance.
```php
return jsend_fail([
    "title" => "title is required",
    "body" => "body must be 50 - 10000 words"
]);
```

Generates a response:
```json
{
  "status": "fail",
  "data": {
    "title": "title is required",
    "body": "body must be 50 - 10000 words"
  }
}
```

### `jsend_error`
The `jsend_error` function creates a JSend **error** response instance.
```php
return jsend_error("Unable to connect to database");
```

Generates a response:
```json
{
  "status": "error",
  "message":"Unable to connect to database"
}
```
You may also pass optional `code` and `data` objects.
```php
return jsend_error("Unable to connect to database", 'E0001', ['type' => 'database error']);
```

Generates a response:
```json
{
  "status": "error",
  "message":"Unable to connect to database",
  "code": "E001",
  "data": {
    "type": "database error"
  }
}
```

> Note: for each helper, the HTTP status codes are set automatically (to 200, 400, and 500 for `success`, `fail`, and `error` respectively), and the header `Content-type: application/json` is set. If you wish, you may specify a HTTP status code and additional headers as the last two parameters.
```php
return jsend_success($post, 201, ["X-My-Header" => "header value"]);
return jsend_fail(["location_id" => "Location not found"], 404);
return jsend_error("Unable to connect to database", 'E0001', [], 503, ["X-My-Header" => "header value"]);
```

## Installation

```bash
composer require shalvah/laravel-jsend
```

## License
MIT
