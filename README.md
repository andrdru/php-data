# php-data
simple php abstract data class

## Usage
Simply extends AbstractData
```php
class MyClass extents AbstractData{};
$obj = new MyClass();
```

## Features

- store properties
```php
$obj->myvar="mydata";
var_dump($obj->myvar); //string(6) "mydata"
```

- store arrays
```php
$obj->myarr[0] = 123;
$obj->myarr[1] = 456;
var_dump($obj->myarr); //array(2) { [0] =>int(123) [1] =>int(456) }
```
- store multi-dimensional arrays 
```php
$obj->myarr['param']['subparam']['subsub']='value';

/* 
array (size=1)
  'param' => 
    array (size=1)
      'subparam' => 
        array (size=1)
          'subsub' => string 'value' (length=5)
*/
var_dump($obj->myarr);

```

- init properties from associative array
```php
$obj = new MyClass(['myvar'=>'mydata']);
var_dump($obj->myvar); //string(6) "mydata"
```
```php
$obj = new MyClass();
$obj->setArray(['myvar'=>'mydata']);
var_dump($obj->myvar); //string(6) "mydata"
```

- get properties into array
```php
$obj->getArray();
$obj->getArray('mydata');
```

- use `current()`, `key()`, `reset()`, `end()`, `next()`, `prev()` on private `$data` array:
```php
$obj->current();
```

## Install via Composer

```
composer require andrdru/data
```
