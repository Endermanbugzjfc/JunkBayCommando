<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBayCommando\Internal;

/**
 * Similar to compiler errors. 
 * This class is not an exception itself. But a factory of {@link \RuntimeException}.
 *
 * @internal Direct modifications to code should be made. (Do not catch this exception!)
 */
final class JunkBayRegisterExceptionInfo {

    public function __construct(private \ReflectionFunctionAbstract $f) {
    }

    private function commandFunction(\ReflectionFunctionAbstract $f) : string {
        return $f->getDeclaringClass()->getName() . "::" . $f->getName() . "()";
    }

    public function badContextParam(string ...$types) : self {
        $typesList = self::implodeTypes(...$types);
        $this->message = "First param of " . $this->commandFunction() . " should have the type of " . CommandContext::class . " but got $typesList";

        return $this;
    }

    public const SPACED_CONTEXT_PARAM = ' $ctx';

    public function noContextParam() : self {
        return $this->badContextParam("0 params")->help = new Help(
            "Reserve a context param",
            $this->f->getName() . "()",
            $this->f->getName() . "(" . CommandContext::class . self::SPACED_CONTEXT_PARAM . ")"
        );
    }

    public function wrongContextParam(\ReflectionParameter $param, bool $missingContextParam, string ...$redundants) : self {
        $redundantsClone = $redundants; // Because array_shift() is going to mutate the variable.
        $this->badContextParam("redundantly " . array_shift($redundants) . self::implodeTypes(...$redundants))->help = new Help(
            !$missingContextParam
                ? "Extract the types to another param if you meant to have them as a command argument"
                : "Prepend a context param",
            self::implodeTypes(
                !$missingContextParam
                    ? [CommandContext::class, ...$redundantsClone]
                    : $redundantsClone
            ) . ' $' . $param->getName(),
            CommandContext::class . self::SPACED_CONTEXT_PARAM . ', ' . self::implodeTypes($redundantsClone) . ' $' . $param->getName()
        );

        return $this;
    }

    private static function implodeTypes(string ...$types) : string {
        return "'" . implode("|", $types) . "'";
    }

    public function unsupportedType(string ...$types) : self {
        $this->message = "Unsupported command argument type(s) " . self::implodeTypes($types);
        // TODO: Help for unsupported type.

        return $this;
    }

    public ?string $help = null;

    public function getHelp() : string {
        return $this->help;
    }
}