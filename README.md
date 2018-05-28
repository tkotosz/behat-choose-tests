Behat-ChooseTestsExtension
=========================
[![License](https://poser.pugx.org/bex/behat-choose-tests/license)](https://packagist.org/packages/bex/behat-choose-tests)
[![Latest Stable Version](https://poser.pugx.org/bex/behat-choose-tests/version)](https://packagist.org/packages/bex/behat-choose-tests)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tkotosz/behat-choose-tests/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tkotosz/behat-choose-tests/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tkotosz/behat-choose-tests/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tkotosz/behat-choose-tests/build-status/master)
[![Build Status](https://travis-ci.org/tkotosz/behat-choose-tests.svg?branch=master)](https://travis-ci.org/tkotosz/behat-choose-tests)

Behat-ChooseTestsExtension allows you to interactively choose tests to run.

Installation
------------

Install by adding to your `composer.json`:

```bash
composer require --dev bex/behat-choose-tests
```

Configuration
-------------

Enable the extension in `behat.yml` like this:

```yml
default:
  extensions:
    Bex\Behat\ChooseTestsExtension: ~
```

Usage
-----

### Choose Suite

Run behat with `--choose-suite` option to interactively choose a suite to run:

1. it will not show the suite-chooser
    - if you are running behat with `--no-interaction` option
    - if you already specified the suite with the `--suite` option
    - if you have only 1 suite

2. it will allow you to choose `All` suite or a specific suite. Multiple choice is not allowed yet.

Example output:
```console
tkotosz ~/behat-test-project $ bin/behat --choose-suite

 Choose suite:

  [0] All
  [1] First Suite
  [2] Second Suite
 > 
```

### Choose Feature

Run behat with `--choose-feature` option to interactively choose a feature to run:

1. it will not show the feature-chooser
    - if you are running behat with `--no-interaction` option
    - if you already specified the feature with passing the `<paths>` argument (e.g. `bin/behat features/my_awesome.feature`)
    - if you have only 1 feature

2. it will allow you to choose `All` feature or a specific feature. Multiple choice is not allowed yet.

3. it list all features or the features in the given suite if you already selected a suite with `--suite` or `--choose-suite`.

Example output:
```console
tkotosz ~/behat-test-project $ bin/behat --choose-feature

 Choose feature:

  [0] All
  [1] First feature (features/first.feature)
  [2] Second feature (features/second.feature)
  [3] Third feature (features/third.feature)
  [4] Forth feature (features/forth.feature)
 >  
```

```console
tkotosz ~/behat-test-project $ bin/behat --suite="firstsuite" --choose-feature

 Choose feature:

  [0] All
  [1] First feature (features/first.feature)
  [2] Second feature (features/second.feature)
 > 
```

### Choose Scenario

Run behat with `--choose-scenario` option to interactively choose a scenario to run:

1. it will not show the scenario-chooser
    - if you are running behat with `--no-interaction` option
    - if you already specified the scenario with passing the `<paths>` argument and specifying a line number (e.g. `bin/behat features/my_awesome.feature:3`)
    - if you have only 1 scenario

2. it will allow you to choose `All` scenario or a specific scenario. Multiple choice is not allowed yet.

3. it list all scenarios or the scenarios in the given suite and feature if you already specified those. (Note that you can specify the suite with `--suite` or `--chose-suite` and you can specify the feature by passing the `<paths>` argument or using the `--choose-feature` option)

Example output:
```console
tkotosz ~/behat-test-project $ bin/behat --suite="firstsuite" --choose-scenario

 Choose scenario:

  [0] All
  [1] First scenario (features/first.feature:3)
  [2] Second scenario (features/first.feature:8)
  [3] Third scenario (features/first.feature:13)
  [4] First scenario (features/second.feature:3)
  [5] Second scenario (features/second.feature:8)
  [6] Third scenario (features/second.feature:13)
 > 
```

```console
tkotosz ~/behat-test-project $ bin/behat features/first.feature --choose-scenario

 Choose scenario:

  [0] All
  [1] First scenario (features/first.feature:3)
  [2] Second scenario (features/first.feature:8)
  [3] Third scenario (features/first.feature:13)
 > 
```

### Choose Tests

Run behat with `--choose-tests` option to interactively choose tests to run. It will simply enable all above choosers so `--choose-tests` is equivalent to `--choose-suite --choose--feature --choose-scenario`.

Example output:
```console
tkotosz ~/behat-test-project $ bin/behat --choose-tests

 Choose suite:

  [0] All
  [1] firstsuite
  [2] secondsuite
 > 1

 Choose feature:

  [0] All
  [1] First feature (features/first.feature)
  [2] Second feature (features/second.feature)
 > 1

 Choose scenario:

  [0] All
  [1] First scenario (features/first.feature:3)
  [2] Second scenario (features/first.feature:8)
  [3] Third scenario (features/first.feature:13)
 > 1

Feature: First feature

  Scenario: First scenario      # features/first.feature:3
    Given I have a few things   # FeatureContext::iHaveAFewThings()
    When I do whatever          # FeatureContext::iDoWhatever()
    Then I should see something # FeatureContext::iShouldSeeSomething()

1 scenario (1 passed)
3 steps (3 passed)
0m0.03s (7.85Mb)
 ```