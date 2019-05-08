# Domino game

## Requirements
- PHP > 7.1

## Install
- Clone this repo and enter it

- Install dependencies
```
composer install
```

## Usage

```bash
php domino.php
```

## Testing

```
$ vendor/bin/phpunit
$ vendor/bin/phpunit --coverage-html coverage/
$ vendor/bin/phpunit --testdox

Docker
$ docker run --rm --volume $PWD:/app -it wod vendor/bin/phpunit
```

## Example output

```
Game starting with first tile: <0:5>
Mark (6) played <0:2>
Board is now: <0:2>(0)<0:5>()
Bob (6) played <2:6>
Board is now: <2:6>(2)<0:2>(0)<0:5>()
Mark (5) played <3:5>
Board is now: <2:6>(2)<0:2>(0)<0:5>()<3:5>(5)
Bob (5) played <3:6>
Board is now: <3:6>(6)<2:6>(2)<0:2>(0)<0:5>()<3:5>(5)
Bob (2) played <1:5>
...
Player Mark has won!
```
