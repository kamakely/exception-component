Create handler class for each exception that you throw in your application.
## 1 - Installation 
```bash
composer require tounaf/exception-handler
```

### 2 - Features

this package allows to separate the handler class by exception to avoid code coupling :
    - One classe handler is responsible for exception
    - Render response throught different output (html, json, xml)
    - Decorate classe handler for other needs (Write to log file, send exception to mail, to sentry)

## 3 - Create Exception Handler class

Create an class and implement the ExceptionHandlerInteface interface. It contains two methods:

#### ** handleException: This method have Throwble as argument and returns a Symfony Response 
#### ** supportsException: This method have Throwble as argument and return boolean.

Example:

First create Exception to handle through the app.

```php
<?php

namespace App\Handler\Exception;

class MyException extends \Exception 
{
}

```
Then create the handler that handle this exception

```php
<?php

namespace App\Handler\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tounaf\Exception\ExceptionHandlerInterface;

class MyExceptionHandler implements ExceptionHandlerInterface 
{
    // return an JsonResponse
    public function handleException(\Throwable $throwable): Response
    {
        // your logic
        return new JsonResponse(['message' => $throwable->getMessage(), 'code' => 12]);
    }

    // 
    public function supportsException(\Throwable $throwable): Response
    {
        return $throwable instanceof MyException;
    }
}

```

When MyException is thrown, the MyExceptionHandler class is called by the system .
For example:


```php

namespace App\Service;

use App\Handler\Exception\MyException;

class MyService
{
    public function someFunction()
    {
        // your logic
        throw new MyException();
    }
}

```