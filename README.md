# laravel-jsend

[![Latest Stable Version](https://poser.pugx.org/shalvah/laravel-jsend/v/stable)](https://packagist.org/packages/shalvah/laravel-jsend) [![Total Downloads](https://poser.pugx.org/shalvah/laravel-jsend/downloads)](https://packagist.org/packages/shalvah/laravel-jsend)

Simple helpers to generate [JSend-compliant](https://labs.omniti.com/labs/jsend) responses for your Laravel app

The [JSend specification](https://labs.omniti.com/labs/jsend) lays down some rules for how JSON responses from web servers should be formatted. JSend is especially suited for REST-style applications and APIs.

## Usage
In your controller:
```php
public function create(Request $request)
{
  $userData = $request->input('data');
  if (!isset($userData['email']))
      return jsend_fail(['email' => 'Email is required']);
  
  try {
      $user = new User($userData):
      return jsend_success($user);
  } catch (Exception $e) {
      return jsend_error('Unable to create user: '.$e->getMessage());
  }
}
```

## Available helpers
### `jsend_success`
The `jsend_success` function creates a JSend **success** response instance.
```php
jsend_success(["post" => [
  "id" => 2,
  "title" => "New life",
  "body" => "Trust me, this is great!"]]);
```

Generates a response:
```json
{
  "status": "success",
  "data": {
    "post": {
      "id": 2,
      "title": "New life",
      "body": "Trust me, this is great!"
    }
  }
}
```
You may pass an Eloquent model instead of an array as the "data" object:

```php
$post = Post::create([
    "title" => "New life",
    "body" => "Trust me, this is great!"]);
jsend_success(["post" => $post]);
```

### `jsend_fail`
The `jsend_fail` function creates a JSend **fail** response instance.
```php
jsend_fail([
    "title" => "title is required",
    "body" => "body must be 50 - 10000 words"]);
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
jsend_error("Unable to connect to database");
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
jsend_error("Unable to connect to database", 'E0001', ['type' => 'database errpr']);
```

Generates a response:
```json
{
  "status": "error",
  "message":"Unable to connect to database",
  "code": "E001",
  "type": "database error"
}
```

> Note: for each helper, you may also specify a custom http status code and additional headers

## Installation
```bash
composer require shalvah/laravel-jsend
```

## License
MIT