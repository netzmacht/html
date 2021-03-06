HTML helper library
===================

[![Build Status](http://img.shields.io/travis/netzmacht/html/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/html)
[![Version](http://img.shields.io/packagist/v/netzmacht/html.svg?style=flat-square)](http://packagist.org/packages/netzmacht/html)
[![License](http://img.shields.io/packagist/l/netzmacht/html.svg?style=flat-square)](http://packagist.org/packages/netzmacht/html)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/html.svg?style=flat-square)](http://packagist.org/packages/netzmacht/html)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

This library is a PHP 7.1 helper library for creating HTML output.

Install
--------------

This extension can be installed using Composer

`composer require netzmacht/html:~2.0`

Basic Usage
--------------

Define the attributes in the View:


### Attributes

```php

$attributes = new Netzmacht\Html\Attributes();
$attributes
    ->setId('a_id')
    ->addClass('a_class')
    ->setAttribute('data-target', '#some');

```

This library uses the magic `__toString` to converts the helper objects to string. Outputting is really simple now:

```php

<div <?= $attributes; ?>><span class="label">Label</span> This is a paragraph.</div>

```

Of course you can change the attributes before generating

```php

<div <?= $attributes->setId('second')->removeClass('a_class')->addClass('new_class'); ?>>the content</div>

```


### Elements

Of course you can create the whole element as well. The library knows about *standalone* html elements which can't
have any children and *nodes* which have children. Notice that the css classes are passed as array.

```php

$factory   = new Netzmacht\Html\Factory\ElementFactory();
$paragraph = $factory->create('p', array('id' => 'a_id', 'class' => array('description'));
$label     = $factory->create('span');

$label
    ->addClass('label')
    ->addChild('Label this');

$paragraph
    ->addChild('This is a paragraph.')
    ->addChild(' '); // add space between both elements
    ->addChild($label, Netzmacht\Html\Element\Node::POSITION_FIRST); // add at first position    

```

Now you can output the whole element:

```php

<article>
    <?= $paragraph; ?>
</article>

```

Integrations
------------

This library provides a [Symfony Bundle](https://www.symfony.com) and [Contao Manager Plugin](https://contao.org) as integration.

### Symfony 

```php
<?php 

// Register your bundle in the AppKernel
public function getBundles()
{
    return [
        // ...
        new Netzmacht\Html\Infrastructure\SymfonyBundle\NetzmachtHtmlBundle()
    ];
}

// Use the factory
$factory = $container->get('netzmacht.html.factory');
$element = $factory->create('p');

```
