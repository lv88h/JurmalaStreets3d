 
<?php
include_once 'db.php'; 
ob_start();

$lietotajs3 = $user_data['username'];
$querychatroom = $db->prepare ('SELECT * FROM groupchatroom WHERE fromuser = ? ORDER BY id DESC LIMIT 1');
$querychatroom ->execute(array($lietotajs3));

  while($row = $querychatroom ->fetch(PDO::FETCH_ASSOC)) {
  $togroup = $row['togroup']; 
  

if($lang == 'lv'){
if (empty($_POST) === false) {
	$required_fields = array('message','groupid');
	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Lauki ar asterisku - * ir jaaizpilda!';
			break 1;
		}
	}
}
}
if($lang == 'en'){
if (empty($_POST) === false) {
	$required_fields = array('message','groupid');
	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields with asterisk - * must be filled!';
			break 1;
		}
	}
}
}


if (isset($_GET['success']) && empty($_GET['success'])) {
	if($lang == 'lv'){ 
	echo 'Ziņa ir nosūtīta!';
	}
	if($lang == 'en'){ 
	echo 'Message has been sent!';
	}
	
} else {	
	if (empty($_POST) === false && empty($errors) === true) {
		$register_data = array(
			'message' => $_POST['textarea'],
			'groupid' => $_POST['groupid']
	);	






	 $datenow = date("Y/m/d/H/i/s");	
$pst = new DateTimeZone('America/Los_Angeles');
$pacdate2 = new DateTime('-3 hours', $pst); // first argument uses strtotime parsing
$pacdate = $pacdate2->format('YmdHis'); // 
echo $pacdate;

	//dati tiek sūtīti uz db pirmo reizi

	
	 $query = "INSERT INTO `groupchat` (
				  `fromuser`,
                  `togroup`,   
                  `message`,
                  `groupid`,
                  `date`,
                  `pacdate`
              ) VALUES(
				 :fromuser,
                 :togroup,
                 :message,
                 :groupid,
                 :date,
                 :pacdate
              )
    "; 
     $stmt = $db->prepare($query);
        $stmt->bindValue(':fromuser', $lietotajs3, PDO::PARAM_STR);

    $stmt->bindValue(':togroup', $togroup, PDO::PARAM_STR);
    $stmt->bindValue(':message', $register_data['message'], PDO::PARAM_STR);
    $stmt->bindValue(':groupid', $register_data['groupid'], PDO::PARAM_STR);
    $stmt->bindValue(':date', $datenow, PDO::PARAM_STR);
    $stmt->bindValue(':pacdate', $pacdate, PDO::PARAM_STR);
	  $stmt->execute();
	
	
		exit();
	
	} else if (empty($errors) === false) {
		echo output_errors($errors);
	}
}
}
?> 
