# tagadvance\gilligan\session
== Example
```php
use tagadvance\gilligan\session\APCSessionHandler;
use tagadvance\gilligan\session\CascadeSessionHandler;
use tagadvance\gilligan\session\SessionSaveHandler;

$defaultHandler = new \SessionHandler();
$apcHandler = new APCSessionHandler();
$cascadeHandler = new CascadeSessionHandler($apcHandler, $defaultHandler);
SessionSaveHandler::register($cascadeHandler);
session_start();
```