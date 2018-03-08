#!/bin/bash

./vendor/bin/phpmd ./app/ text codesize,unusedcode
./vendor/bin/phpcs ./app/ --standard=PSR2
./vendor/bin/codecept run functional --coverage --coverage-html
