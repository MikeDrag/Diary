<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Form\EventType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index()
    {
	    $weeks = ['8', '15', '22', '29'];
	    $days = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
		$day_of_the_month = date('j');
		$begin = 0;
		$end = 30;
		$step = 7;
		$seq = range($begin, $end, $step);
		$month_start = strtotime('first day of this month', time());
		$month_start = date('w', $month_start);
		$days_removed = 1;
		$count_days = 0;
		$last_day_previous_month = date("Y-m-d", strtotime("last day of previous month"));
		$last_week_previous_month = date('w', strtotime($last_day_previous_month));
	    $last_week_next_month = date("Y-m-d", strtotime("first day of next month"));
	    $last_week_next_month = date('w', strtotime($last_week_next_month));
		$days_diff_previous_month = 1;
		$last_day_of_month_last_count = intVal(date('j', strtotime($last_day_previous_month)));
		$month = date('M');
		$diary = '';
	    $last_week_days = [];
	    $count_next_month_last_week_days = 0;


	    for ($count_days_of_month = 1; $count_days_of_month < date('t'); $count_days_of_month++) {
            if ($count_days_of_month <= $last_week_previous_month) {
                for ($count_previous_month_days = 0; $count_previous_month_days < $last_day_of_month_last_count; $count_previous_month_days++) {
                    $days_diff_previous_month++;
                    // last day of the week - the number of the last day of last week in last month + the loop + increment by 1 and remove 1 because it starts at position 1.
                    $first_week_days = $last_day_of_month_last_count - $last_week_previous_month + $count_previous_month_days + $days_diff_previous_month -1 ;
                    $diary .= '<td style="opacity:0.4" data-toggle="modal" data-target="#myModal" data-id="' . ($last_day_of_month_last_count - $last_week_previous_month + $count_previous_month_days) . '">' .
	                    '<a href="event/d=' . ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) .  '&m=' . date('m') . '"/>'
                        . ($first_week_days) . '</a></td>';
                    $last_week_days[$count_days_of_month] = $last_day_of_month_last_count -  $count_days_of_month + 1;
                    break;
                }
                  $days_removed++;
            } else {
                $count_days++;
                if ($day_of_the_month == $count_days) {
                    $diary .= '<td data-id="' . $count_days . '"style="background:brown;">' . '<a href="event/d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
                } else {
                    $diary .= '<td data-toggle="modal" data-target="#myModal" data-id="' . $count_days . '">' . '<a href="event/d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
                }
            }
            if (in_array($count_days_of_month, $seq)) {
                $diary .= '<tr>';
            }
        }

	    for ($remaining_days = 0; $remaining_days < $days_removed; $remaining_days++) {
		    $count_days++;
		    // Begin with a new row if sunday
		    if (date('l', strtotime($count_days . date('-m-Y'))) === 'Sunday') {
			    $diary .= '<td data-toggle="modal" data-target="#myModal data-id="' . $count_days . '">' . '<a href="event/d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>' . '<tr>';
		    } else {
			    $diary .= '<td data-toggle="modal" data-target="#myModal data-id="' . $count_days . '">' . '<a href="event/d=' . $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
		    }
	    }
	    // Check last week of the next month and increment to fill the last week of the current month
	    for ($last_week_next_month; $last_week_next_month <= 7; $last_week_next_month++){
	    	$count_next_month_last_week_days++;
		    $diary .= '<td style="opacity:0.5" data-toggle="modal" data-target="#myModal">' . '<a href="event/d=' . 1 . '&m=' . $date = date('m', strtotime('+1 month')) . '"/>' . '0' . $count_next_month_last_week_days. '</a></td>';
	    }
        return $this->render('calendar/calendar.html.twig', ['month' => $month, 'weeks' => $weeks, 'days' => $days, 'diary' => $diary
        ]);
    }

    /**
     * @Route("/event/{slug}", name="event_day")
     */
    public function event_day(Request $request, TranslatorInterface $translator) {
    	// Translation
//	    $translated = $translator->trans('Symfony is great');
	    $category = new Category();
	    $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
    	$event = new Event();
    	$form = $this->createForm(EventType::class, $event);
	    return $this->render('calendar/event.html.twig', ['categories' => $categories, 'form' => $form->createView()]);
    }
}
