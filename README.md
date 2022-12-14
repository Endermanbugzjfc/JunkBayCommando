# Junk Bay 將軍澳
Command argument-by-type library for PocketMine-MP.
## What to do with junk!??
將軍澳 (Junk Bay), pronounced as Tseung Kwan O,
which that the first two syllables refer to the word General in Cantonese.

Being the name of a sub-city in Hong Kong,
it always shows up in my mind whenever I think of Commando.

Otherwise, another war among [Lazuli Commando](https://youtu.be/cDdRFj3MBIs) and [Hyundai Commando](https://github.com/keopiwauyu/HyundaiCommando) would begin... 
*By the way, the Commando in current repository name is just for publicity.*

I picked the name TseungKwano at the outset,
then my anxious told me to avoid the same ending as Hyun...
something something by going with a more recallable name.
Although the current one is yet crappy, not gonna lie.

命名是個技術活！

## PHPStan analysis
This repository shows an example setup for standalone local analysis of a plugin using [PHPStan](https://phpstan.org).

It uses [Composer](https://getcomposer.org) for autoloading, allowing you to install PHPStan extensions such as [phpstan-strict-rules](https://github.com/phpstan/phpstan-strict-rules). The configuration for this can be seen in [`phpstan/composer.json`](/phpstan/composer.json).

### Setting up PHPStan
Assuming you have Composer and a compatible PHP binary available in your PATH, run:
```
cd phpstan
composer install
```

Then you can run PHPStan exactly as you would with any other project:
```
vendor/bin/phpstan analyze
```

### Updating the dependencies
```
composer update
```

### GitHub Actions
You can find a workflow suitable for analysing most plugins using this system in [`.github/workflows/main.yml`](/.github/workflows/main.yml).
