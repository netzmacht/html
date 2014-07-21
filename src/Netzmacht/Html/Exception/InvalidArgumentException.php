<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Exception;

class InvalidArgumentException extends \Exception
{
	private $propertyPath;
	private $value;
	private $constraints;

	public function __construct($message, $code, $propertyPath = null, $value, array $constraints = array())
	{
		parent::__construct($message, $code);

		$this->propertyPath = $propertyPath;
		$this->value = $value;
		$this->constraints = $constraints;
	}

	/**
	 * User controlled way to define a sub-property causing
	 * the failure of a currently asserted objects.
	 *
	 * Useful to transport information about the nature of the error
	 * back to higher layers.
	 *
	 * @return string
	 */
	public function getPropertyPath()
	{
		return $this->propertyPath;
	}

	/**
	 * Get the value that caused the assertion to fail.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Get the constraints that applied to the failed assertion.
	 *
	 * @return array
	 */
	public function getConstraints()
	{
		return $this->constraints;
	}
} 