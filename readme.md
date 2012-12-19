# Fuel\\Alias

[![Build Status](https://travis-ci.org/fuelphp/alias.png?branch=master)](https://travis-ci.org/fuelphp/alias)

Package for lazy class aliasing.

## Synopsys

Within FuelPHP class aliases are used to provide easy access to namespaced classes and facilitate
class inheritance injection.

The package exposes an alias manager which lets you create 3 types of aliases:

* __Literal__<br/>A one-to-one translation. Class "Namespaced\\Classname" translates to "Another\\Classname".
* __Replacement__<br/>A pattern is matched an through replacements a new class is generated. "Namespace\\*" maps to "Alias\\$1".
* __Computed__<br/>A callback (Closure or any other callable) computes the new class name. The callback is provides with an array containing the fully namespaced class name segments.

When registering the alias manager append or prepends itself to the autoload stack to act as a pre-processor or fallback. Depending on the amount of aliases and it could be beneficial to alternate between pre- or appending.

By default the manager will prepend itself to the autoloader stack.


## Basic Usage

```
// Create a new alias manager
$manager = new Fuel\Alias\Manager();

// Register the manager
$manager->register();

// Alias one class
$manager->alias('Alias\Me', 'To\This');

// Or alias many
$manager->alias(array(
	'Alias\This' => 'To\Me',
	'AndAlias\This' => 'To\SomethingElse',
));

// 
```

## Caching

In order to get blazing fast aliasing you can enable caching. There are three types of caching: alias, class and unwind. They're each helpful in different situations. The default is `alias` because this is what the package does originally and reduces the most processing.

All cache is file based and loaded when available when the caching is added to the manager. You can add caching to in the following manner:

```
$manager = new Fuel\Alias\Manager();

$manager->cache(new Fuel\Alias\Cache('/path/to/cache.php'));
/**
 * Via direct cache object injection. This is handy when you want
 * To implement your own caching method.
 */

$manager->cache('/path/to/cache', 'unwind');
// Note the optional .php
```

Caching doesn't contain garbage collection as aliases are meant to never expire. It should however be part of your deploy routine to delete the cache files. If you do want a cache routine, feel free to use the `Fuel\Alias\Cache::delete` method to remove the cache manually or implemented in your own garbage collection:

```
$cache = new Fuel\Alias\Cache('/path/to/cache');

// Remove the cache
$cache->delete();
```

It's important to think about what type of caching you use. Let's look at them.

### Alias Caching

Alias cashing generated a file that contains `class_alias` calls:

```
class_alias('ThisClass', 'ToThisClass`);
```

### Class Caching

Class caching will create a file with actual class extensions:

```
namespace Something { class Nested extends \Some\Other\Class {} }
```

### Unwind Caching

Unwind caching resolves all the computed aliases and loads them into the manager as plain aliases:

```
$manager->alias(array(
	'Something' => 'Something\ElseCLass',
));
```
