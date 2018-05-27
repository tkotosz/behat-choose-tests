<?php

namespace Bex\Behat\ChooseTestsExtension\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class AvailableSuitesRegistered extends Event
{
    const BEFORE = 'bex.available_suites_registered.before';
    const AFTER = 'bex.available_suites_registered.after';
}
