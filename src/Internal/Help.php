<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBay\Internal;

/**
 * Inspired by but NOT 1:1-copy of the Rust compile-time error helps.
 * @internal Used by {@link JunkBayRegisterException}.
 */
final class Help implements \Stringable {
    public function __construct(
        private string $message,
        private string $before,
        private string $after
    ) {

    }

    public function __toString() : string {
        $multilines = str_contains($this->before, $needle = "\n") || str_contains($this->after, $needle)
        $codeBlockStart = $multilines ? "```\n" : "`";
        $codeBlockEnd = $multilines ? "\n```" : "`";
        $arrow = $multilines ? "=>" : "\n=>\n";
        [$before, $after] = array_map(
            static fn(string $code) : string => $codeBlockStart . $code . $codeBlockEnd,
            [$this->before, $this->after]
        );

        return <<<EOT
        Help: $this->message
        Consider to change:
        EOT . ($multilines ? "\n" : "") $before . $arrow . $after;
    }
}