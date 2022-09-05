<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBay;

use Endermanbugzjfc\JunkBay\Internal\JunkBayRegisterException;

final class Register {

	public static function junkBay(JunkBay $junkBay) : void {
		$ref = new \ReflectionClass($junkBay);
		return static::reflectionClass($ref);
	}

	/**
	 * @param \ReflectionClass<JunkBay>
	 */
	public static function reflectionClass(\ReflectionClass $ref) : void {
	}

	public static function reflectionMethod(\ReflectionMethod $method) : void {
		$errInfo = new JunkBayRegisterExceptionInfo($method);
		$paramsK = $method->getParameters();
		$params = array_values($paramsK);
		$paramFirst = $params[0] ?? throw $errInfo->noContextParam()->getThrowable();
		$paramContext = $paramFirst->getType() ?? throw $errInfo->wrongContextParam($paramFirst "mixed")->getThrowable();
		$typeFirst = $paramsFirst->getType();

		if ($typeFirst instanceof \ReflectionUnionType) {
			$typesListFirst = array_map(
				static fn(\ReflectionNamedType $type) : string => $type->getName(),
				$typeFirst->getTypes()
			);
			throw $errInfo->wrongContextParam($paramFirst, $typesListFirst)->getThrowable();
		} elseif (!$typeFirst instanceof ReflectionNamedType) {
			throw $errInfo->unsupportedTypesFormat($paramFirst, $typeFirst)->getThrowable();
		} elseif (!is_subclass_of($typeFirst->getName(), CommandContext::class)) {
			throw $errInfo->wrongContextParam($paramFirst, [$typeFirst->getName()])->getThrowable();
		}
	}
}