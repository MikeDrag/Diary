<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>A static webpage</title>
<style type="text/css">
	body{
		background: url(https://images.unsplash.com/photo-1530305408560-82d13781b33a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2552&q=80);
	}
	#loginPop {
		display: block;
		text-align: center;
	}
	label {
		display: block;
		font-weight: 700;
	}
	input {
		display: block;
		border-radius: 5%;
		margin: 0 auto;
	}
	.modal-header {
		background: darkred;
		color: white;
	}
	.modal-footer {
		background: darkred;
	}
	.modal-dialog {
		margin-top: 5em;
	}
</style>

</head>
<body>
<div class="text-center">
	<button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#loginPop">
  	Login
	</button>
</div>

<!-- The Modal -->
<div class="modal" id="loginPop">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Please log in...</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
    	<form id="loginPop">
			<label>Username</label>
			<input type="text" name="username">
			<label>Password</label>
			<input type="password" name="password">
			<button type="submit" class="log-in-btn btn btn btn-primary m-2">Log in</button>
		</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#loginPop').modal('show');
    });
</script>
</body>
</html>
<!-- 
<?php
?>

include_once ('style.css');
class FreshDesk
{
	public $dir;
	public $users = [];
	public $all_words = [];

	public function getUsers()
	{
		$this->dir = glob("tickets/*xml");
		foreach ($this->dir as $ticket => $file) {
			$date_previous_year = date('Y-m-d', strtotime("-12 months"));
			$xml = simplexml_load_file($file);

			{
				foreach ($xml->{'helpdesk-ticket'} as $xml_file => $value) {
					$date_created = $value->{'created-at'};
					$date_created = substr($date_created, 0, 10);

					if ($date_created >= $date_previous_year) {
						$user_id = $value->{'requester-id'}->__toString();
						if (!isset($users[$user_id])) {
							$users[$user_id] = 0;
						}
						$users[$user_id]++;
					}

					$subject = $value->{'subject'}->__toString();
					$words = explode(' ', strtolower($subject));
					$superfluos_words = ['de', ':)', 're:', ':', 'at', '--', 'in', 'on', 'the', 'to', 'for', 'why', 'thank', '-', '', ' ', 'of', 'up', ')'];
					foreach ($words as $word)
					{
						if(in_array($word, $superfluos_words))
							continue;
						if (!isset($all_words[$word]))
						{
							$all_words[$word] = 0;
						}
						$all_words[$word]++;
					}
				}
			}
		}
//		arsort($all_words);
//		arsort($users);
//		$file = fopen("users.csv", "w");
//		foreach ($users as $line => $v) {
//			fputcsv($file, $users);
//		}
//		fclose($file);

		//Average messages per person
		arsort($users);
		$avg = array_sum($users) / count($users);
		var_dump(round($avg, 2));
	}
	public function agentStatistics()
	{
		$customer_agent = ['Anders Sjölin', 'Steffi', 'Janne Wallgren', 'Soraya Anderson', 'Christoffer Lindberg'];
		$agents = [];
		$notes = [];
		$note_per_ticket = [];
		$ticket_per_agent = [];
		$this->dir = glob("tickets/*xml");
		foreach ($this->dir as $ticket => $file) {
			$xml = simplexml_load_file($file);
			{
				foreach ($xml->{'helpdesk-ticket'} as $xml_file => $value)
				{

					// TOTAL NOTES-RESPONSES PER AGENT
					foreach ($value->{'notes'}->{'helpdesk-note'} as $note)
					{
						$ticket_id = $value->{'display-id'}->__toString();
						$user_id = $note->{'user-id'}->__toString();
						if ($note->{'source'} == '4' || $note->{'incoming'} == 'true')
							continue;
						#if (!array_key_exists($user_id, $note_per_ticket))
						if (!isset($note_per_ticket[$user_id]))
							$note_per_ticket[$user_id] = [];

						$note_per_ticket[$user_id][$ticket_id] = TRUE;
//						[
//								6000 => [
//										22 => TRUE,
//										24 => TRUE,
//								],
//								6005 => [
//										25 => TRUE,
//								]
//						]
						#$note_per_ticket[$user_id][] = $ticket_id;
//						[
//							6000 => [22,23],
//							6000 => [0 => 22, 1 => 23]
//							6005 => [
//								25
//							]
//						]

//						if (!isset($agents[$user_id])) {
//							$agents[$user_id] = 1;
//						} else {
//							$agents[$user_id]++;
//						}
					}

				}


//					if ($value->{'notes'}->{'helpdesk-note'}->{'user-id'})
//						$responder_id = $value->{'notes'}->{'helpdesk-note'}->{'user-id'}->__toString();
//					if (array_key_exists($responder_id, $customer_agents))
//					{
//
//						$notes[$responder_id]++;
////						$customer_agents[$responder_id]++;
//					}
//					else {
//						if (!isset($notes[$responder_id])){
//							$notes[$responder_id] = count($value->{'notes'}->{'helpdesk-note'}->{'notes'});
//						}
////						$customer_agents[$responder_id] = 1;
//					}
				}
				foreach ($note_per_ticket as $user => $ticket)
				{
					if (!isset($ticket_per_agent[$user]))
					{
						$ticket_per_agent[$user] = count($ticket);
					}
					else
					{
						$ticket_per_agent[$user] = count($ticket);
					}
				}
			}
		arsort($ticket_per_agent);
		var_dump($ticket_per_agent);
// Prints out total notes.
//		arsort($agents);
//		var_dump($agents);
//		var_dump($notes);
?>
<h3 style="text-align: center;">Tickets assigned to Customer Agent (2019-09-30)</h3>-->
<!--<table>-->
<!--	--><?php //foreach($customer_agents as $agent => $value): ?>
<!--		<tr><th>--><?php //echo $agent ?><!--</th></tr>-->
<!--		<tr><td style="text-align: center;color: red;">--><?php //echo $value; ?><!--</td></tr>-->
<!--	--><?php //endforeach; ?>
<!--<tr>-->
<?php //foreach($customer_agents as $agent => $value): ?>
<!--		<td>--><?php //echo $value; ?><!-- </td>-->
<?php //endforeach; ?>
<!--</tr>-->
<!--</table>-->
<!--<h3 style="text-align: center;">Notes created by / for Customer Agent (2019-09-30)</h3>-->
<!--		<table>-->
<!--	--><?php //foreach($notes as $note => $value): ?>
<!--		<tr><th>--><?php //echo $note ?><!--</th></tr>-->
<!--		<tr><td style="text-align: center;color: red;">--><?php //echo $value; ?><!--</td></tr>-->
<!--	--><?php //endforeach; ?>
<!--	<tr>-->
<!--		--><?php //foreach($customer_agents as $agent => $value): ?>
<!--				<td>--><?php //echo $value; ?><!-- </td>-->
<!--		--><?php //endforeach; ?>
<!--	</tr>-->
<!--</table>-->
<!-- 
