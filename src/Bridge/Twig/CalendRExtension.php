<?php

namespace CalendR\Bridge\Twig;

use CalendR\Calendar;

/**
 * Extension for using periods and events from Twig
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class CalendRExtension extends \Twig_Extension
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
     * @return array<\Twig_Function>
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('calendr_year', [$this, 'getYear']),
            new \Twig_SimpleFunction('calendr_month', [$this, 'getMonth']),
            new \Twig_SimpleFunction('calendr_week', [$this, 'getWeek']),
            new \Twig_SimpleFunction('calendr_day', [$this, 'getDay']),
            new \Twig_SimpleFunction('calendr_events', [$this, 'getEvents']),
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
