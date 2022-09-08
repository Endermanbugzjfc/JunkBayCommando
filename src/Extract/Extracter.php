<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBay\Extract;

final class Extracter {

	/**
	 * @return []string Key = command name. Value = subcommand name. 
	 */
	public static function groupSubCommands(string ...$names) : array {
		// Credit: https://stackoverflow.com/a/838239
		// Sort by name length **ascendingly** (opposite from above).
		usort(
			$names,
			static fn(string $a, string $b) : int => strlen($a)-strlen($b)
		);

		$groups = $groupNames = [];
		foreach ($names as $name) {
			$command = true;
			foreach ($groupNames as $groupName) {
				if (strpos($name, $groupName) === 0) {
					// This name should be a subcommand of $groupName.
					$groups[$groupName][] = substr($name, strlen($groupName));
					$command = false;
					break;
				}
			}

			if ($command) {
				$groups[$name] = [];
				$groupNames[] = $name;
			}
		}

		return $groups;
	}
}