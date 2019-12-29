### Usage
```
git clone https://github.com/vdmkbu/geolocator.git
```

##### Простое использование
```php
 require 'vendor/autoload.php';
 
 // используем библиотеку GuzzleHttp и PSR-совместимый адаптер 
 use GuzzleHttp\Client as GuzzleClient;
 use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
 use App\Geolocator\Providers\IpGeoLocationLocators;
 use App\Geolocator\Types\Ip;
 
 // готовим http-клиент
 $config = [];
 $guzzle = new GuzzleClient($config);
 $adapter = new GuzzleAdapter($guzzle);
 
 // передаем http-клиент в провайдер данных
 $locator = new IpGeoLocationLocators($adapter, 'e81b3531074e45cc830a7058da6e1620');
 $location = $locator->locate(new Ip('8.8.8.8'));
 
 echo $location->getCountry();
 echo $location->getRegion();
 echo $location->getCity();
```
##### Цепочка провайдеров
```php
use App\Geolocator\ChainLocator;
use App\Geolocator\Providers\IpGeoLocationLocators;
use App\Geolocator\Providers\IpInfoLocator;
use App\Geolocator\Types\Ip;
 
$locator = new ChainLocator(
    new IpGeoLocationLocators($adapter, 'e81b3531074e45cc830a7058da6e1620'),
    new IpInfoLocator($adapter, 'jfewjoi374e45cc830a7058da6e1620')
);
$location = $locator->locate(new Ip('8.8.8.8'));
 
echo $location->getCountry();
echo $location->getRegion();
echo $location->getCity();
```

##### Кеширование
```php
use App\Geolocator\ChainLocator;
use App\Geolocator\CacheLocator;
use App\Geolocator\MuteChainLocator;
use App\Geolocator\Providers\IpGeoLocationLocators;
use App\Geolocator\Providers\IpInfoLocator;
use App\Geolocator\Types\Ip;
use App\Exceptions\PsrLogErrorHandler;

$handler = new PsrLogErrorHandler();
$cache = new Cache(); // impl. CacheInterface

$locator = new ChainLocator(
            new CacheLocator(
                new MuteChainLocator(
                    new IpGeoLocationLocators($adapter, 'e81b3531074e45cc830a7058da6e1620'), 
                    $handler),
                $cache,
                'cache_1',
                3600),
            new CacheLocator(
                new MuteChainLocator(
                    IpInfoLocator($adapter, 'jfewjoi374e45cc830a7058da6e1620'), 
                    $handler),
                $cache,
                'cache_2',
                3600)
        );
        
$location = $locator->locate(new Ip('8.8.8.8'));        

echo $location->getCountry();
echo $location->getRegion();
echo $location->getCity();
```

##### Для добавления новых провайдеров 
Имплементируем интерфейс Locator в каталоге src/Providers