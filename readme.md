HTML helper library
===================

[![Build Status](https://travis-ci.org/netzmacht/html.svg?branch=master)](https://travis-ci.org/netzmacht/html)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/netzmacht/html/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/netzmacht/html/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/netzmacht/html/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/netzmacht/html/?branch=master)

This library can be used as a helper library for creating HTML output.

Install
--------------

This extension can be installed using Composer

`composer require netzmacht/html:dev-master`

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

This library uses the magic `__toString` to convert the helper objects to string. Outputting is really simple now:

```php

<div <?= $attributes; ?>><span class="label">Label</span> This is a paragraph.</div>

```

One can obviously change the attributes before generating

```php

<div <?= $attributes->setId('second')->removeClass('a_class')->addClass('new_class'); ?>>the content</div>

```


### Elements

One can create the whole element as well. The library knows about *standalone* html elements which can't
have any children and *nodes* which have children. [Notice that the css classes are passed as array.]

```php

$paragraph = Netzmacht\Html\Element::create('p', array('id' => 'a_id', 'class' => array('description'));
$label     = $paragraph->create('span');

$label
    ->addClass('label')
    ->addChild('Label this');

$paragraph
    ->addChild('This is a paragraph.')
    ->addChild($label, Netzmacht\Html\Element\Node::POSITION_FIRST); // add at first position
    ->addChild(' ', 1); // add space between both elements

```

Now one can output the whole element:

```php

<article>
    <?= $paragraph; ?>
</article>

```

Custom factory
==============

By default this library works with a simple factory which can decide between standalone and node elements. If one
wants to support own components he/she can use another factory. He/She can implement their own by implementing
the `Netzmacht\Html\Factory` interface.

Or can use the `EventBasedFactory` which uses the symfony event dispatcher for creating an element.

```php

$factory = new Netzmacht\Html\Factory\EventBasedFactory($symfonyEventDispatcher);
Netzmacht\Html\Element::setFactory($factory);

```

If one uses the event based factory, he/she has to take care of building the elements for themselves. He/She have to assign their 
event handler to the dispatcher by listening to the `Netzmacht\Html\Event\CreateElementEvent::NAME` which passes a
`Netzmacht\Html\Event\CreateElementEvent` event object.

```php

class MySubscriber
{
    private $simpleFactory;

    public function __construct(Netzmacht\Html\Factory\Factory $simpleFactory)
    {
        $this->simpleFactory = $simpleFactory;
    }

    public function handle(Netzmacht\Html\Event\CreateElementEvent $event)
    {
        if($event->getTag() == 'custom') {
            $element = new MyCustomElement($event->getAttributes());
        }
        else {
            $element = $this->simpleFactory->createElement($event->getTag(), $event->getAttributes());
        }

        $event->setElement($element);
    }
}

$subscriber = new MySubscriber(new Netzmacht\Html\Factory\SimpleFactory());
$symfonyEventDispatcher->addListener(Netzmacht\Html\Event\Events::CREATE_ELEMENT, array($subscriber, 'handle'));

```
