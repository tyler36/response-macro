# Introduction
These macros help to standardize **api json response** returns throughout the application.
Inspired by [Laravel Response Macros for APIs](https://blog.jadjoubran.io/2016/03/27/laravel-response-macros-api/)

## Installation
- Install package
```
composer require tyler36/response-macro
```


### Success
Returns payload ($data) with an optional [HTTP status code](https://httpstatuses.com/) ($statusCode) [Default: [HTTP status code 200]
```
response()->success($data);
```

EG.
```
response()->success(['earth' => 3, 'sun' => 'yellow'])
```
Returns **HTTP status 200** with the following:
```
{"errors":false,"data":{"earth":3,"sun":"yellow"}}
```


### noContent
Returns empty content with a [HTTP status code 402](https://httpstatuses.com/204)
```
response()->noContent()
```


### Error
Returns message ($message) content with an optional [HTTP status code](https://httpstatuses.com/) ($statusCode) [Default: [HTTP status code 400](https://httpstatuses.com/400)]
```
response()->error($message);
```

Eg.
```
response()->error('There was an error.');
```
Returns **HTTP status 400** with the following:
```
{"errors":true,"message":"There was an error."}
```

Eg.
```
response()->error('Not authorized!', 403);
```

Returns **HTTP status 403** with the following:
```
{"errors":true,"message":"Not authorized!"}
```
