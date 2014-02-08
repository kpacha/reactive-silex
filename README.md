reactive-silex
==============

Mixup silex and react (with a little help from espresso)

#Instal

The recommended way to install kpacha/reactive-silex is through composer.

    {
        "require": {
            "kpacha/reactive-silex": "~0.1.0"
        }
    }

#Usage

Check out the `bin/reactive.php` example and run it with

    $ php bin/reactive.php

There is a built-in console-based script

    $ bin/run reactive --help
    Usage:
     reactive [port]

    Arguments:
     port                   (default: 1337)

    Options:
     --help (-h)           Display this help message.
     --quiet (-q)          Do not output any message.
     --verbose (-v|vv|vvv) Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
     --version (-V)        Display this application version.
     --ansi                Force ANSI output.
     --no-ansi             Disable ANSI output.
     --no-interaction (-n) Do not ask any interactive question.

    $ bin/run reactive -vv 8080
    Server running at http://127.0.0.1:8080
    Memory: 1280 KiB
    Memory: 1280 KiB

#Scalability

React launches a single-process share-nothing server, so you can instance several stacks in a single 
machine, depending on the number of avilable cores, before scale-out adding more hardware. The cpu 
and memory consumption will remain almost lineal. Balance your load between your stacks and everything 
will be run like a charm!

Also, remember to bind every stack to a different port or you will face some nice port collision messages!

#Documentation

* [silex](http://silex.sensiolabs.org/documentation)
* [react](http://reactphp.org/)

#TODO

* improve error handling
* improve request & response parsing

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/kpacha/reactive-silex/trend.png)](https://bitdeli.com/free "Bitdeli Badge")