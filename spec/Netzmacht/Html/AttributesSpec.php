<?php

declare(strict_types=1);

namespace spec\Netzmacht\Html;

use IteratorAggregate;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Traversable;

use function array_filter;
use function array_keys;
use function implode;

final class AttributesSpec extends ObjectBehavior
{
    private const EXCEPTION = InvalidArgumentException::class;

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Attributes::class);
    }

    public function it_can_be_constructed_with_attributes(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->getAttributes()->shouldBeLike($attributes);
    }

    public function it_sets_attribute_by_name(): void
    {
        $this->setAttribute('test', 'value')->shouldReturn($this);
        $this->getAttribute('test')->shouldReturn('value');
        $this->hasAttribute('test')->shouldReturn(true);
    }

    public function it_gets_attribute_by_name(): void
    {
        $this->beConstructedWith(['id' => 'test']);
        $this->getAttribute('id')->shouldReturn('test');
    }

    public function it_gets_default_for_non_existing_attribute(): void
    {
        $this->getAttribute('test', 'val')->shouldReturn('val');
    }

    public function it_gets_null_for_non_existing_attribute(): void
    {
        $this->getAttribute('test')->shouldReturn(null);
    }

    public function its_rendered_by___toString(): void
    {
        $this->shouldHaveType(CastsToString::class);
        $this->__toString()->shouldReturn($this->generate());
    }

    public function it_renders_key_value_string(): void
    {
        $this->beConstructedWith(['id' => 'my_id', 'class' => ['a', 'b']]);

        $this->generate()->shouldReturn('class="a b" id="my_id"');
    }

    public function it_encodes_html_entities(): void
    {
        $this->setAttribute('name', '""');
        $this->generate()->shouldReturn('name="&quot;&quot;"');
    }

    public function it_throws_when_invalid_attribute_name_is_given(): void
    {
        $this
            ->shouldThrow(self::EXCEPTION)
            ->during('setAttribute', ['test"', 'val']);
    }

    public function it_throws_when_constructed_with_invalid_attribute_name(): void
    {
        $this
            ->shouldThrow(self::EXCEPTION)
            ->during('__construct', [['test"' => 'val']]);
    }

    public function it_handles_html5_boolean_attributes(): void
    {
        $attributes = [
            'compact'        => true,
            'declare'        => true,
            'defer'          => true,
            'disabled'       => true,
            'formnovalidate' => true,
            'multiple'       => true,
            'nowrap'         => true,
            'novalidate'     => true,
            'ismap'          => true,
            'readonly'       => true,
            'required'       => true,
            'selected'       => true,
        ];

        $this->beConstructedWith($attributes);

        $this->generate()->shouldReturn(implode(' ', array_keys($attributes)));
    }

    public function it_ignores_false_html5_boolean_attributes(): void
    {
        $attributes = [
            'compact'        => false,
            'declare'        => true,
            'defer'          => true,
            'disabled'       => true,
            'formnovalidate' => true,
            'multiple'       => false,
            'nowrap'         => true,
            'novalidate'     => true,
            'ismap'          => false,
            'readonly'       => true,
            'required'       => true,
            'selected'       => true,
        ];

        $this->beConstructedWith($attributes);

        $this->generate()->shouldReturn(implode(' ', array_keys(array_filter($attributes))));
    }

    public function it_iterates_through_attributes(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->shouldHaveType(IteratorAggregate::class);
        $this->getIterator()->shouldBeAnInstanceOf(Traversable::class);
        $this->getIterator()->getArrayCopy()->shouldBeLike($attributes);
    }

    public function it_adds_multiple_attributes(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];

        $this->addAttributes($attributes)->shouldReturn($this);
        $this->getAttributes()->shouldBeLike($attributes);
    }

    public function it_removes_attribute(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->hasAttribute('id')->shouldBe(true);
        $this->removeAttribute('id')->shouldReturn($this);
        $this->hasAttribute('id')->shouldBe(false);
    }

    public function it_stores_classes_as_array(): void
    {
        $this->getAttribute('class')->shouldBeArray();
    }

    public function it_keeps_empty_attributes_array_when_removed(): void
    {
        $this->removeAttribute('class');
        $this->getAttribute('class')->shouldBeArray();
        $this->getAttribute('class')->shouldHaveCount(0);
    }

    public function it_throws_when_class_is_a_string(): void
    {
        $this
            ->shouldThrow(self::EXCEPTION)
            ->during('setAttribute', ['class', 'foo']);
    }

    public function it_adds_a_class(): void
    {
        $this->addClass('foo')->shouldReturn($this);
        $this->getAttribute('class')->shouldBeLike(['foo']);
    }

    public function it_splits_multiple_classes(): void
    {
        $this->addClass('foo bar')->shouldReturn($this);
        $this->getAttribute('class')->shouldBeLike(['foo', 'bar']);
    }

    public function it_accepts_a_valid_css_class(): void
    {
        $this->addClass('-moz-padding-foo');
        $this->addClass('foo');
        $this->addClass('_foo_bar');
        $this->addClass('-_foo_bar');
    }

    public function it_ignores_empty_css_class(): void
    {
        $this->addClass('test');
        $this->getAttribute('class')->shouldReturn(['test']);
        $this->addClass('');
        $this->getAttribute('class')->shouldReturn(['test']);
    }

    public function it_removes_class(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->hasClass('a')->shouldBe(true);
        $this->removeClass('a')->shouldReturn($this);
        $this->hasClass('a')->shouldBe(false);
    }

    public function it_gets_id(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->getId()->shouldBe('my_id');
    }

    public function it_sets_id(): void
    {
        $this->setId('foo')->shouldReturn($this);
        $this->getId()->shouldBe('foo');
    }

    public function it_has_array_access(): void
    {
        $attributes = ['id' => 'my_id', 'class' => ['a', 'b']];
        $this->beConstructedWith($attributes);

        $this->shouldHaveType('ArrayAccess');

        $this['id']->shouldBe('my_id');
        $this['id'] = 'foo';
        $this['id']->shouldBe('foo');
    }

    public function it_validates_array_access_value(): void
    {
        $this->shouldThrow(self::EXCEPTION)->during('offsetSet', ['class', ':hide']);
    }

    public function it_validates_array_access_key(): void
    {
        $this->shouldThrow(self::EXCEPTION)->during('offsetSet', ['"class', 'hans']);
    }
}
