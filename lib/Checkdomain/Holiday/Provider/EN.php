<?php


namespace Checkdomain\Holiday\Provider;


/**
 * Class EN
 * @package Checkdomain\Holiday\Provider
 *
 * Holiday provider for England, Wales and Northern Ireland (note: Scotland is not included as public holidays are
 * generally determined by local authorities)
 *
 * @see https://en.wikipedia.org/wiki/Public_holidays_in_the_United_Kingdom
 */
class EN extends AbstractEaster
{

    const STATE_EN_WA = "England and Wales";
    const STATE_NI = "Northern Ireland";

    /**
     * @param int $year
     *
     * @return mixed
     */
    public function getHolidaysByYear($year)
    {
        $easter = $this->getEasterDates($year);
        $christmas = $this->getChristmasDates($year);

        // Compile known dates
        $holidays = array(
            '01_01' => $this->createData("New Year's Day"),
            $this->nextWeekday($year, 1, 1)->format(self::DATE_FORMAT) => $this->createData("New Year's Day"),

            '03_17' => $this->createData("St. Patrick's Day", array(EN::STATE_NI)),
            $this->nextWeekday($year, 3, 17)->format(self::DATE_FORMAT) => $this->createData("St. Patrick's Day", array(EN::STATE_NI)),

            // Easter bank holidays
            $easter['goodFriday']->format(self::DATE_FORMAT) => $this->createData("Good Friday"),
            $easter['easterMonday']->format(self::DATE_FORMAT) => $this->createData("Easter Monday"),

            date(self::DATE_FORMAT, strtotime("first Monday $year-5")) => $this->createData("May Day Bank Holiday"),
            date(self::DATE_FORMAT, strtotime("last Monday $year-5")) => $this->createData("Spring Bank Holiday"),

            '07_12' => $this->createData("Battle of the Boyne (Orangeman's Day)", array(EN::STATE_NI)),
            $this->nextWeekday($year, 7, 12)->format(self::DATE_FORMAT) => $this->createData("Battle of the Boyne (Orangeman's Day)", array(EN::STATE_NI)),

            date(self::DATE_FORMAT, strtotime("last Monday $year-8")) => $this->createData("Late Summer Bank Holiday"),

            // Christmas
            '12_25' => $this->createData("Christmas Day"),
            $christmas['christmasDay']->format(self::DATE_FORMAT) => $this->createData("Christmas Day"),
            '12_26' => $this->createData("Boxing Day"),
            $christmas['boxingDay']->format(self::DATE_FORMAT) => $this->createData("Boxing Day"),
        );

        return $holidays;
    }

    /**
     * @param $year
     *
     * @return \DateTime[]
     */
    protected function getChristmasDates($year)
    {
        // todo Calculate actual Christmas bank holiday dates

        return array(
            'christmasDay' => \DateTime::createFromFormat('Y-m-d', "$year-12-25"),
            'boxingDay' => \DateTime::createFromFormat('Y-m-d', "$year-12-26"),
        );
    }
}