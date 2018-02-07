<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body style="display:block;width: 415px; height:100px; margin:0 auto; padding-top:250px;/* background-color:#eee; */font: 20px/24px Arial;text-align: center;">
	<div style="margin:0 auto;/* background-color: #43C7A1; */padding:  25px;/* border-radius: 5px; *//* border: 1px solid #efefef; *//* box-shadow: 4px 6px 11px #eee; */">

<?php
		
	if(	!empty($_POST['honey_x'])||
		!empty($_POST['honey_y'])||
		!empty($_POST['honey_z']) ) 
	{
		//var_dump($_POST['honey_x'],$_POST['honey_y'],$_POST['honey_z']);
		die;
	} else {
		
	if(	empty($_POST['firstname'])||
		empty($_POST['lastname'])||
		empty($_POST['dateofbirth'])||
		empty($_POST['job'])||
		empty($_POST['email'])||
		empty($_POST['worktitle'])||
		empty($_POST['summary']))
	{
		print_r ('<script>alert("Заполните обязательные поля!");</script>');
	}	else	{
			
		$name1 = trim($_POST['firstname']);
		$name1 = strip_tags($name1);
		$name1 = htmlspecialchars($name1,ENT_QUOTES);
		$name1 = preg_replace("/[^А-Яа-яЁёA-Za-z]/iu", "", $name1);
		
		if (isset($_POST['middlename'])){
			$name2 = trim($_POST['middlename']);
			$name2 = strip_tags($name2);
			$name2 = htmlspecialchars($name2,ENT_QUOTES);
			$name2 = preg_replace("/[^А-Яа-яЁёA-Za-z]/iu", "", $name2);
			}
		
		$name3 = trim($_POST['lastname']);
		$name3 = strip_tags($name3);
		$name3 = htmlspecialchars($name3,ENT_QUOTES);
		$name3 = preg_replace("/[^А-Яа-яЁёA-Za-z\-]/iu", "", $name3);
			
		$bday = trim($_POST['dateofbirth']);
		$bday = strip_tags($bday);
		$bday = htmlspecialchars($bday,ENT_QUOTES);	
		$bday = preg_replace("/[^0-9\-\.]/iu", "", $bday);
			
		$job = trim($_POST['job']);
		$job = strip_tags($job);
		$job = htmlspecialchars($job,ENT_QUOTES);	
		$job = preg_replace("/[^А-Яа-яЁёA-Za-z\s\-]/iu", "", $job);
			
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email,ENT_QUOTES);
		$email = preg_replace("/[^a-z@.\-0-9]/iu", "", $email);
			
		$worktitle = trim($_POST['worktitle']);
		$worktitle = strip_tags($worktitle);
		$worktitle = preg_replace("/[^А-Яа-яЁёA-Za-z\s\.\,\:\-\+()0-9\'\"]/iu", "", $worktitle);
			
		$coauthors = trim($_POST['coauthors']);
		$coauthors = strip_tags($coauthors);
		$coauthors = htmlspecialchars($coauthors,ENT_QUOTES);	
		$coauthors = preg_replace("/[^А-Яа-яЁёA-Za-z\-\s\.\,]/iu", "", $coauthors);
		
		$summary = trim($_POST['summary']);
		$summary = strip_tags($summary);
		$summary = preg_replace("/[^А-Яа-яЁёA-Za-z\s\.\,\:\%\;\!\?\-\+()0-9\'\"]/iu", "", $summary);
		$summary = preg_replace("/[\r\n]/", " ", $summary);
			
			if(isset($_POST['hostel'])&&$_POST['hostel']=="1"){
				$hostel = 'Нужна гостиница';		
			} else {
				$hostel= 'Не нужна гостиница';
			}
			
			if(isset($_POST['section'])){
				$section = preg_replace("/[^А-Яа-яЁёA-Za-z\s]/iu", "", $_POST['section']);				
			}
			
			if(isset($_POST['report'])){
				$report = preg_replace("/[^А-Яа-яЁёA-Za-z]/iu", "", $_POST['report']);
			}
			
			$fdate = date("d.m.Y\tH.i.s");
		
			$msg = "$fdate\t$name3\t$name1\t$name2\t$bday\t$job\t$email\t$hostel\t$section\t$report\t$worktitle\t$coauthors\t$summary";
			
			//echo $msg;
			
			$f = fopen("dbmpp_2016.txt", "a+"); 
			//fwrite($f," \n $date $time Сообщение от $name"); 
			while (!flock($f, LOCK_EX | LOCK_NB))
				{
					sleep(1);
				}
			$fwrite = fwrite($f,"$msg \r\n");
			if($fwrite) {
				$fw = true;
					}
					
			//var_dump($fw);
			$fclose = fclose($f);
			
			$to = "mpp2016@ifanbel.bas-net.by";
			$subject = 'Новый участник';
			
			// $message = $msg;
			$message = '<!doctype html><html><head></head><body><table>'
			.'<tr><td><b>Дата регистрации:<b/></td><td>'.$fdate."</td></tr>"
			.'<tr><td><b>Фамилия:<b/></td><td>'.$name3."</td></tr>"
			.'<tr><td><b>Имя:<b/></td><td>'.$name1."</td></tr>"
			.'<tr><td><b>Отчество:<b/></td><td>'.$name2."</td></tr>"
			.'<tr><td><b>Дата рождения:<b/></td><td>'.$bday."</td></tr>"
			.'<tr><td><b>Место работы/учебы:<b/></td><td>'.$job."</td></tr>"
			.'<tr><td><b>E-mail:<b/></td><td><a href=\"mailto:'.$email.'\">'.$email.'</a></td></tr>'
			.'<tr><td><b>Бронь гостиницы:<b/></td><td>'.$hostel."</td></tr>"
			.'<tr><td><b>Предпочтительная секция:<b/></td><td>'.$section."</td></tr>"
			.'<tr><td><b>Форма представления доклада:<b/></td><td>'.$report."</td></tr>"
			.'<tr><td><b>Название работы:<b/></td><td>'.$worktitle."</td></tr>"
			.'<tr><td><b>Соавторы:<b/></td><td>'.$coauthors."</td></tr>"
			.'<tr><td><b>Аннотация:<b/></td><td>'.$summary."</td></tr>"
			.'</table></body></html>';
			
			$headers = 'From: ' . $email . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$x = mail($to, $subject, $message, $headers);
			if($x){ 
				$_x = true;
				}
			//var_dump($_x);
			if($fw==true&&$_x==true){
				print_r ('<p><strong>Ваши данные успешно отправлены!</strong><br /><br /><span style="font-size:12px !important;">Сейчас Вы будете перенаправлены на главную страницу</span></p>');
					} else {
				print_r ('<p><strong>Ошибка регистрации! Попробуйте еще раз!</strong></p>');		
					}
				}
		}
?>
	<script>
		setTimeout('location="http://ifanbel.bas-net.by/mpp/index.html";', 4000);
	</script>
	</div>
</body>
</html>