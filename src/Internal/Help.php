<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBayCommando\Internal;

/**
 * Inspired by but NOT 1:1-copy of the Rust compile-time error helps.
 * @internal Used by {@link JunkBayRegisterException}.
 */
final class Help {
    public function __construct(
        private string $message,
        private string $before,
        private string $after
    ) {

    }
}