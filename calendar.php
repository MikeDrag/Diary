<style type="text/css">
	body {
		background: radial-gradient(#fff, slategray);
	}

	* {
		box-sizing: border-box;
		/*text-align: center;*/
	}

	ul {
		list-style-type: none;
	}

	li {
		color: mediumslateblue;
	}

	#intro-heading {
		color: black;
		margin: 0;
	}

	td:hover {
		background: white;
		cursor: pointer;
	}

	table {
		border: 2px black solid;
		border-radius: 15px;
		margin: 0 auto;
		padding: 3em;
		/* background: #eee; */
		color: black;
	}

	table td {
		margin-top: 3px;
		padding: 1.2em;
		font-weight: bold;
	}

	#calendar-wrapper {
		color: white;
		display: block;
		margin: 0 auto;
	}

	#intro-header {
		margin-bottom: 10px;
		color: black;
	}

	#note-added-message {
		display: none;
	}
	a {
		text-decoration: none;
		color: black;
	}
</style>

<div class="container" id="header-container">
<?php
	$month = cal_days_in_month(CAL_GREGORIAN, 2, date('y'));
	$weeks = ['8', '15', '22', '29'];
	$days = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];
	$february = '02';
?>
<div id="calendar-wrapper">
	<h2 id='intro-heading'>
		<?php echo "<div id='intro-header'>Date: " . date('Y/m/d') . "</p>";
		echo '<span style="color: black;text-align:center;">Day: ' . date('l') . '</span>';
		echo '<p>Month: ' . date('M') . '</p>'; ?>
	</h2>
	<table>
		<thead>
		<?php foreach ($days as $day) {
			echo '<th>' . $day . '</th>';
		}
		?>
		</thead>
		<tbody>
		<?php
			$day_of_the_month = date('j');
			$month_of_the_year = date('n');
			$current_day = date('l');
			$day_of_the_week = date('w');
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
			$last_day_of_month_last_count = intVal(date('j', strtotime($last_day_previous_month)));

			for ($count_days_of_month = 1; $count_days_of_month < date('t'); $count_days_of_month++) {
				if ($count_days_of_month <= $last_week_previous_month) {
					for ($count_previous_month_days = 0; $count_previous_month_days < $last_day_of_month_last_count; $count_previous_month_days++) {
						$days_diff_previous_month++;
						echo '<td style="opacity:0.4" data-toggle="modal" data-target="#myModal" data-id="' . ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) . '">' . '<a href="diary.php/d='. ($last_day_of_month_last_count - $month_start + $days_diff_previous_month) .  '&m=' . date('m') . '"/>'
						 .($last_day_of_month_last_count - $month_start + $days_diff_previous_month) . '</a></td>';
						break;
					}
					// echo '<td>' . date('j', strtotime($last_day_previous_month)) . '</td>';
					$days_removed++;
				} else {
					$count_days++;
					if ($day_of_the_month == $count_days) {
						echo '<td data-id="' . $count_days . '"style="background:brown;">' . '<a href="d='. $count_days . '&m=' . date('m') . '"/>' . $count_days . '</a></td>';
					} else {
						echo '<td data-toggle="modal" data-target="#myModal" data-id="' . $count_days . '">' . '<a href="diary.php/d='. $count_days . '&m=' . date('m') . '"/>'. $count_days . '</a></td>';
					}
				}
				if (in_array($count_days_of_month, $seq)) {
					echo '<tr>';
				}
			}
			for ($remaining_days = 0; $remaining_days < $days_removed; $remaining_days++) {
				$count_days = $count_days + 1;

				echo '<td data-toggle="modal" data-target="#myModal data-id="' . $count_days . '">'. '<a href="d='. $count_days . '&m=' . date('m') . '"/>'. $count_days . '</a></td>';
			}
			echo '<td style="opacity:0.5" data-toggle="modal" data-target="#myModal">'. '<a href="diary.php/d='. 1 . '&m=' . $date = date('m', strtotime('+1 month')) . '"/>'. 1 . '</a></td>';
		?>
		<?php echo '</tr>';
		?>
		</tbody>
	</table>
</div>
</div>