# PHP Enumeration

This is a native PHP implementation to add enumeration support to PHP >= 5.3.
It's an abstract class that needs to be extended to use it.

# Usage

## Basics

    use Dkd\Enumeration;

    class MyEnumeration extends Enumeration
    {
        // this is optional. The value will be used as default value if no value
        // is given.
        const __DEFAULT = self::INTEGER_VALUE;

        // all scalar datatypes are supported
        const INTEGER_VALUE = 1;
        const FLOAT_VALUE = 0.123;
        const STRING_VALUE = 'foo';
        const BOOLEAN_VALUE = true;
    }

    // Use the ```__DEFAULT``` value if defined. If not defined an exception
    // is thrown.
    $myEnumeration = MyEnumeration();

    $myEnumeration = new MyEnumeration(MyEnumeration::INTEGER_VALUE);

    // cast does automatically cast the given value to the enumeration value.
    $myEnumeration = MyEnumeration::cast(MyEnumeration::INTEGER_VALUE);
    $myEnumeration = MyEnumeration::cast($myEnumeration);
    $myEnumeration = MyEnumeration::cast($databaseResult['my_column']);

    // get all possible values of the enumeration.
    $possibleValues = MyEnumeration::getConstants();

    $myEnumeration = new MyEnumeration(MyEnumeration::INTEGER_VALUE);
    $myEnumeration->equals(1); // TRUE
    $myEnumeration->equals($myEnumeration); // TRUE
    $myEnumeration->equals(0.123); // FALSE
    $myEnumeration->equals('foo'); // FALSE
    $myEnumeration->equals(new MyEnumeration('foo')); // FALSE

# Why not ```SplEnum```

* ```SplEnum``` is not build-in into PHP and requires pecl extension installed.

# Install

## Composer

Add ```dkd/enumeration``` to the project's composer.json dependencies and run
```php composer.phar install```

## GIT

```git clone git://github.com/dkd/enumeration.git```

## ZIP / TAR

Download the last version from [Github](https://github.com/dkd/enumeration/tags)
and extract it.

# License

This code is also part of the TYPO3 CMS project and has been extracted to this
package.
See LICENSE for details.
