<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\external_calendar\tests\codeception\unit;

use external_calendar\ExternalCalendarTest;
use humhub\modules\external_calendar\models\ExternalCalendarEntry;
use humhub\modules\external_calendar\models\ExternalCalendarEntryQuery;
use DateTime;
use humhub\modules\external_calendar\models\ICalSync;
use humhub\modules\space\models\Space;
use PHP_Timer;
use Yii;

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 17.09.2017
 * Time: 20:25
 */
class ImportPerformanceTest extends ExternalCalendarTest
{

    public function testExpandRecurrence1OneYear()
    {
        $externalCalendar = $this->initCalendar('@external_calendar/tests/codeception/data/recurrence1.ics');

        PHP_Timer::start();
        /** @var $events ExternalCalendarEntry[] * */
        $events = ExternalCalendarEntryQuery::findForFilter(
            DateTime::createFromFormat('!Ymd', '20190801', new \DateTimeZone('Europe/Berlin')),
            DateTime::createFromFormat('!Ymd', '20200801', new \DateTimeZone('Europe/Berlin')),
            Space::findOne(1));
        print_r('Expand '.PHP_Timer::secondsToTimeString(PHP_Timer::stop()).' ('.count($events).")\n");
    }

    public function testExpandRecurrence2OneYear()
    {
        $externalCalendar = $this->initCalendar('@external_calendar/tests/codeception/data/recurrence1Split.ics');

        PHP_Timer::start();
        /** @var $events ExternalCalendarEntry[] * */
        $events = ExternalCalendarEntryQuery::findForFilter(
            DateTime::createFromFormat('!Ymd', '20220801', new \DateTimeZone('Europe/Berlin')),
            DateTime::createFromFormat('!Ymd', '20230801', new \DateTimeZone('Europe/Berlin')),
            Space::findOne(1));
        print_r('Expand '.PHP_Timer::secondsToTimeString(PHP_Timer::stop()).' ('.count($events).")\n");

    }

}