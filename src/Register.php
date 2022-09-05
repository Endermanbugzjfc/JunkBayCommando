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
		$paramContext = $paramFirst->getType() ?? throw $errInfo->untypedContextParam($paramFirst)->getThrowable();
		$typeFirst = $paramsFirst->getType();
		$returnType = $method->getReturnType() ?? throw $errInfo->untypedReturn($paramFirst);

		foreach ([
			match (true) { // Verfy context param.
				$typeFirst instanceof \ReflectionUnionType => $errInfo->wrongContextParam($paramFirst, ...Utils::getTypeNames(...$typeFirst)),
				!$typeFirst instanceof ReflectionNamedType => $errInfo->unsupportedParamTypesFormat($paramFirst, $typeFirst),
				!is_subclass_of($typeFirst->getName(), CommandContext::class) => $errInfo->wrongContextParam($paramFirst, $typeFirst->getName())
			},

			match (true) { // Verify return type.
				$returnType instanceof \ReflectionUnionType => $errInfo->wrongReturnType(...Utils::getTypeNames(...$returnType)),
				!$returnType instanceof ReflectionNamedType => $errInfo->unsupportedReturnTypesFormat($returnType),
				$returnType->getName() !== "Generator" && $returnType->getName() !== "void" => $errInfo->wrongReturnType($paramFirst, $returnType->getName())
			},
		] as $throwable) {
			if ($throwable !== null) {
				throw $throwable;
			}
		}
	}
}