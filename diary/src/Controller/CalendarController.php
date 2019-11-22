<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index()
    {
        $month = cal_days_in_month(CAL_GREGORIAN, 2, date('y'));
        $weeks = ['8', '15', '22', '29'];
        $days = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
        $february = '02';
        $begin = 0;
        $end = 30;
        $step = 7;
        $seq = range($begin, $end, $step);
        $month_start = strtotime('first day of this month', time());
        $month_start = date('w', $month_start);
        $week_start = strtotime('sunday', time());
        $week_end = strtotime('next Sunday', time());
        $days_removed = 1;
        $count_days = 0;
        $last_day_previous_month = date("Y-m-d", strtotime("last day of previous month"));
        $last_week_previous_month = date('w', strtotime($last_day_previous_month));
        $days_diff_previous_month = 1;

        for ($count_days_of_month = 1; $count_days_of_month < date('t'); $count_days_of_month++) {
            if ($count_days_of_month <= $last_week_previous_month) {
                for ($count_previous_month_days = 0; $count_previous_month_days < $last_day_of_month_last_count; $count_previous_month_days++) {
                    $days_diff_previous_month++;
                    echo '<td style="opacity:0.4" data-toggle="modal" data-target="#myModal" data-id="' . ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) . '">' . '<a href="diary.php/d=' . ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) .  '&m=' . date('m') . '"/>'
                        . ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) . '</a></td>';
                    break;
                }
                // echo '<td>' . date('j', strtotime($last_day_previous_month)) . '</td>';
                $days_removed++;
            } else {
                $count_days++;
                if ($day_of_the_month == $count_days) {
                    echo '<td data-id="' . $count_days . '"style="background:brown;">' . '<a href="d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
                } else {
                    echo '<td data-toggle="modal" data-target="#myModal" data-id="' . $count_days . '">' . '<a href="diary.php/d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
                }
            }
            if (in_array($count_days_of_month, $seq)) {
                echo '<tr>';
            }
        }
        dump($count_days_of_month);die;

        return $this->render('calendar/calendar.html.twig', ['month' => $month, 'weeks' => $weeks, 'days' => $days, 'seq' => $seq, 'month_start' => $month_start
        , 'week_start' => $week_start, 'week_end' => $week_end, 'days_removed' => $days_removed, 'count_days' => $count_days, 'last_day_previous_month' => $last_day_previous_month
        , 'last_week_previous_month' => $last_week_previous_month, 'days_diff_previous_month' => $days_diff_previous_month
        ]);
    }
}
