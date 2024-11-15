<?php

namespace CalendR\Test\Period;

use CalendR\Calendar;
use CalendR\Period\Day;
use CalendR\Period\Exception\NotAYear;
use CalendR\Period\Factory;
use CalendR\Period\FactoryInterface;
use CalendR\Period\Year;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class YearTest extends TestCase
{
    use ProphecyTrait;

    public static function providerConstructInvalid()
    {
        return array(
            array(new \DateTime('2012-01-03')),
            array(new \DateTime('2014-12-10')),
            array(new \DateTime('2014-01-01 00:00:01')),
        );
    }

    public static function providerConstructValid()
    {
        return array(
            array(new \DateTime('2012-01-01')),
            array(new \DateTime('2011-01-01')),
            array(new \DateTime('2013-01-01')),
            array(new \DateTime('2014-01-01 00:00'))
        );
    }

    public static function providerContains()
    {
        return array(
            array(new \DateTime('2012-01-01'), new \DateTime('2012-01-04'), new \DateTime('2013-02-09')),
            array(new \DateTime('2011-01-01'), new \DateTime('2011-01-01'), new \DateTime('2012-03-19')),
            array(new \DateTime('2013-01-01'), new \DateTime('2013-09-09'), new \DateTime('2011-10-09')),
            array(new \DateTime('2013-01-01'), new \DateTime('2013-12-31'), new \DateTime('2014-01-01')),
            array(new \DateTime('2013-01-01'), new \DateTime('2013-12-31'), new \DateTime('2014-01-01')),
            array(new \DateTime('2013-01-01'), new \DateTime('2013-01-01'), new \DateTime('2014-01-01')),
        );
    }

    /**
     * @dataProvider providerContains
     */
    public function testContains($start, $contain, $notContain)
    {
        $year = new Year($start, $this->prophesize(FactoryInterface::class)->reveal());

        $this->assertTrue($year->contains($contain));
        $this->assertFalse($year->contains($notContain));
    }

    /**
     * @dataProvider providerContains
     */
    public function testIncludes($start, $contain, $notContain)
    {
        $year = new Year($start, $this->prophesize(FactoryInterface::class)->reveal());

        $this->assertTrue($year->includes(new Day($contain, $this->prophesize(FactoryInterface::class)->reveal())));
        $this->assertFalse($year->includes(new Day($notContain, $this->prophesize(FactoryInterface::class)->reveal())));
    }

    /**
     * @dataProvider providerConstructInvalid
     */
    public function testConstructInvalid($start)
    {
        $this->expectException(NotAYear::class);

        new Year($start, $this->prophesize(FactoryInterface::class)->reveal());
    }

    /**
     * @dataProvider providerConstructValid
     */
    public function testConstructValid($start)
    {
        $year = new Year($start, $this->prophesize(FactoryInterface::class)->reveal());

        $this->assertInstanceOf(Year::class, $year);
    }

    public function testToString()
    {
        $year = new Year(new \DateTime('2014-01-01'), $this->prophesize(FactoryInterface::class)->reveal());
        $this->assertSame('2014', (string) $year);
    }

    public function testIteration()
    {
        $start = new \DateTime('2012-01');
        $year = new Year($start, new Factory);

        $i = 0;

        foreach ($year as $monthKey => $month) {
            $this->assertTrue(is_numeric($monthKey) && $monthKey > 0 && $monthKey <= 12);
            $this->assertInstanceOf('CalendR\\Period\\Month', $month);
            $this->assertSame($start->format('d-m-Y'), $month->getBegin()->format('d-m-Y'));
            $start->add(new \DateInterval('P1M'));
            $i++;
        }

        $this->assertEquals($i, 12);
    }

    public function testGetNext()
    {
        $year = new Year(new \DateTime('2012-01-01'), $this->prophesize(FactoryInterface::class)->reveal());
        $this->assertEquals('2013-01-01', $year->getNext()->getBegin()->format('Y-m-d'));
    }

    public function testGetPrevious()
    {
        $year = new Year(new \DateTime('2012-01-01'), $this->prophesize(FactoryInterface::class)->reveal());
        $this->assertEquals('2011-01-01', $year->getPrevious()->getBegin()->format('Y-m-d'));
    }

    public function testGetDatePeriod()
    {
        $date = new \DateTime('2012-01-01');
        $year = new Year($date, $this->prophesize(FactoryInterface::class)->reveal());
        foreach ($year->getDatePeriod() as $dateTime) {
            $this->assertEquals($date->format('Y-m-d'), $dateTime->format('Y-m-d'));
            $date->add(new \DateInterval('P1D'));
        }
    }
}
