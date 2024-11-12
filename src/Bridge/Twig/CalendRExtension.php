<?php

namespace CalendR\Bridge\Twig;

use CalendR\Calendar;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Extension for using periods and events from Twig
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class CalendRExtension extends AbstractExtension
{
    /**
     * @var Calendar
     */
    protected $factory;

    /**
     * @param Calendar $factory
     */
    public function __construct(Calendar $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return array<TwigFunction>
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('calendr_year', [$this, 'getYear']),
            new TwigFunction('calendr_month', [$this, 'getMonth']),
            new TwigFunction('calendr_week', [$this, 'getWeek']),
            new TwigFunction('calendr_day', [$this, 'getDay']),
            new TwigFunction('calendr_events', [$this, 'getEvents']),
        ];
    }

    public function getYear(): mixed
    {
        return call_user_func_array([$this->factory, 'getYear'], func_get_args());
    }

    public function getMonth(): mixed
    {
        return call_user_func_array([$this->factory, 'getMonth'], func_get_args());
    }

    public function getWeek(): mixed
    {
        return call_user_func_array([$this->factory, 'getWeek'], func_get_args());
    }

    public function getDay(): mixed
    {
        return call_user_func_array([$this->factory, 'getDay'], func_get_args());
    }

    public function getEvents(): mixed
    {
        return call_user_func_array([$this->factory, 'getEvents'], func_get_args());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::class;
    }
}
