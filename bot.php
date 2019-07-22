<?php
require("conf.php");
require("jdf.php");
$update = json_decode(file_get_contents("php://input"));
include('Telegram.php');
$telegram = new Telegram($bot_token);
$result = $telegram->getData();
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$user_id = $telegram->UserID();
if(!isset($update->callback_query)){
	$content = ['chat_id' =>$chat_id, 'action' => 'typing'];
	$telegram->sendChatAction($content);
	//$content = ['chat_id' =>"277721677", 'action' => 'record_video'];$telegram->sendChatAction($content);
}
try {
	$conn = "mysql:host=$dburl;dbname=$dbname";
	$con = new PDO($conn, $dbuser, $dbpass);
	$con->exec("SET NAMES 'UTF8'");
	$sql = "SELECT `id` FROM `bot_users` WHERE `userid`=?";
	$ins = array($user_id);
	$user = $con->prepare($sql);
	$user->execute($ins);
	$data = $user->fetchAll();
	foreach ($data as $value) {
		$useid = $value['id'];
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
}
//main
function main($user_id,$chat_id){
	
	require("conf.php");
	$telegram = new Telegram($bot_token);

  	try {
		$conn = "mysql:host=$dburl;dbname=$dbname";
		$con = new PDO($conn, $dbuser, $dbpass);
		$con->exec("SET NAMES 'UTF8'");
		$sql = "SELECT * FROM `bot_users` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
		$data = $user->fetchAll();
    	foreach ($data as $value) {
				$id = $value['id'];
				$phone = $value['phone'];
				$name = $value['name'];
				$sex = $value['sex'];
    	}
		$sql = "DELETE FROM `bot_cach` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	$sex2 = "";
	if ($sex == "1"){$sex2 = "جناب آقای";}
	if ($sex == "2"){$sex2 = "سرکار خانم";}
	$option = array( 
    	array($telegram->buildKeyboardButton('تعیین یا تغییر رمز عبور سایت')),
   		array($telegram->buildKeyboardButton('🏆شرکت در مسابقه'),),
   		array($telegram->buildKeyboardButton('🎖شانس های قرعه کشی'),),
		array($telegram->buildKeyboardButton('درباره ماℹ️'),),
		);
		$keyb = $telegram->buildKeyBoard($option,false,true);
		$content = ['chat_id' => $chat_id, 'text' => $sex2." ".$name."\n".'با عرض سلام

ورود شما را به ربات کانون موعود دانشگاه علوم پزشکی رفسنجان خیر مقدم میگوییم.
🌺🌸🌺🌸🌺🌸', 'reply_markup' => $keyb];
		$telegram->sendMessage($content);
}
function register($user_id,$chat_id){
	require("conf.php");
	$telegram = new Telegram($bot_token);
	try {
		$conn = "mysql:host=$dburl;dbname=$dbname";
		$con = new PDO($conn, $dbuser, $dbpass);
		$con->exec("SET NAMES 'UTF8'");
		$sql = "SELECT * FROM `bot_users` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
		$data = $user->fetchAll();
		foreach ($data as $value) {
			$id = $value['userid'];
			$phone = $value['phone'];
			$name = $value['name'];
			$sex = $value['sex'];
			$mnum = $value['mnum'];
			$snum = $value['snum'];
			$uni = $value['uni'];
			$major = $value['major'];
			$maqta = $value['maqta'];
			$province = $value['province'];
			$city = $value['city'];
			$birth = $value['birth'];
		}
		$sql = "SELECT * FROM `bot_users` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
		$data = $user->fetchAll();
		foreach ($data as $value) {
			$id = $value['id'];
			$phone = $value['phone'];
			$name = $value['name'];
			$sex = $value['sex'];
			$mnum = $value['mnum'];
			$snum = $value['snum'];
			$uni = $value['uni'];
			$major = $value['major'];
			$maqta = $value['maqta'];
			$province = $value['province'];
			$city = $value['city'];
			$birth = $value['birth'];
		}
		$sql = "DELETE FROM `bot_cach` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	$cp = 0;
	if (! isset($phone)){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getphone");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('دریافت شماره شما',true, false)));
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'text' => 'با عرض سلام

ورود شما را به ربات کانون موعود دانشگاه علوم پزشکی رفسنجان خیر مقدم میگوییم.
🌺🌸🌺🌸🌺🌸
⬇️لطفا جهت ادامه شماره موبایل خود را از طریق دکمه زیر به اشتراک بگذارید⬇️', 'reply_markup' => $keyb, 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
}
	if (! isset($name) ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getname");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$content = ['chat_id' => $chat_id, 'text' => "لطفا نام و نام خانوادگی خود را به فارسی ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($mnum) ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getmnum");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$content = ['chat_id' => $chat_id, 'text' => "لطفا کد ملی خود را ارسال کنید \n توجه: حتما از اعداد انگلیسی استفاده کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($snum) ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getsnum");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$content = ['chat_id' => $chat_id, 'text' => "لطفا شماره دانشجویی خود را ارسال کنید \n توجه: حتما از اعداد انگلیسی استفاده کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($uni) ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getuni");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('دانشگاه علوم پزشکی رفسنجان',false, false)),
			array($telegram->buildKeyboardButton('دانشگاه علوم پزشکی کرمان',false, false)));
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا دانشگاه خود را از منوی زیر انتخاب کنید⬇️
در صورتی که دانشگاه شما در منوی زیر وجود ندارد نام دانشگاه خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($major)  ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getmajor");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('علوم آزمایشگاهی',false, false)),
			array($telegram->buildKeyboardButton('اتاق عمل',false, false)),
			array($telegram->buildKeyboardButton('رادیولوژی',false, false)),
			array($telegram->buildKeyboardButton('هوشبری',false, false)),
			array($telegram->buildKeyboardButton('پرستاری',false, false)),
			array($telegram->buildKeyboardButton('مامایی',false, false)),
			array($telegram->buildKeyboardButton('فوریت های پزشکی',false, false)),
			array($telegram->buildKeyboardButton('پزشکی',false, false)),
			array($telegram->buildKeyboardButton('دندانپزشکی',false, false)),
			array($telegram->buildKeyboardButton('داروسازی',false, false)));
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا رشته تحصیلی خود را از منوی زیر انتخاب کنید⬇️
در صورتی که رشته شما در منوی زیر وجود ندارد نام رشته خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($maqta)  ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getmaqta");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('کاردانی',false, false)),
			array($telegram->buildKeyboardButton('کارشناسی',false, false)),
			array($telegram->buildKeyboardButton('کارشناسی ارشد',false, false)),
			array($telegram->buildKeyboardButton('دکتری',false, false)),
			);
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا مقطع تحصیلی خود را از منوی زیر انتخاب کنید⬇️
در صورتی که مقطع تحصیلی شما در منوی زیر وجود ندارد مقطع تحصیلی خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($province)  ){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getprovince");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('کرمان',false, false)),
			array($telegram->buildKeyboardButton('یزد',false, false)),
			array($telegram->buildKeyboardButton('اصفهان',false, false)),
			array($telegram->buildKeyboardButton('شیراز',false, false)),
			);
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا استان محل سکونت خود را از منوی زیر انتخاب کنید⬇️
در صورتی که استان شما در منوی زیر وجود ندارد استان خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	if (! isset($city)  && $cp==0){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getcity");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('کرمان',false, false)),
			array($telegram->buildKeyboardButton('رفسنجان',false, false)),
			array($telegram->buildKeyboardButton('یزد',false, false)),
			);
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا شهر محل سکونت خود را از منوی زیر انتخاب کنید⬇️
در صورتی که شهر شما در منوی زیر وجود ندارد شهر خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}		
	if (! isset($birth)  OR ! isset($sex)){
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"getyear");
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$option = array( 
			array($telegram->buildKeyboardButton('1371',false, false),$telegram->buildKeyboardButton('1372',false, false),$telegram->buildKeyboardButton('1373',false, false),$telegram->buildKeyboardButton('1374',false, false),$telegram->buildKeyboardButton('1375',false, false)),
			array($telegram->buildKeyboardButton('1376',false, false),$telegram->buildKeyboardButton('1377',false, false),$telegram->buildKeyboardButton('1378',false, false),$telegram->buildKeyboardButton('1379',false, false),$telegram->buildKeyboardButton('1380',false, false)),
			);
		$keyb = $telegram->buildKeyBoard($option,true,true);
		$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "⬇️لطفا سال تولد خود را از منوی زیر انتخاب کنید⬇️
در صورتی که سال تولد شما در منوی زیر وجود ندارد سال تولد خود را ارسال کنید", 'reply_to_message_id' => $telegram->MessageID()];
		$telegram->sendMessage($content);
		die();
	}
	main($user_id,$chat_id);
}
////

//چک و ثبت نام
$lcm="";
switch ($text){
	case 'درباره ماℹ️':
				$option = array( 
    				array($telegram->buildInlineKeyboardButton('وبسایت',"http://besoyezohor.ir/")),
    				array($telegram->buildInlineKeyboardButton('اینستاگرام',"https://www.instagram.com/mta_rums/")),
    				array($telegram->buildInlineKeyboardButton('کانال تلگرام',"https://t.me/besoyezohor_rums")),
				);
				$keyb = $telegram->buildInlineKeyBoard($option);
				$content = ['chat_id' => $chat_id, 'text' => "🌺کانون موعود دانشگاه علوم پزشکی رفسنجان🌺
🌸دبیر: معین مرادی
🌸نایب دبیر: 
\nbot_programmer: @saeedbahrampour", 'reply_markup' => $keyb];
				$telegram->sendMessage($content);
	break;
	case '🎖شانس های قرعه کشی':
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `mcode` WHERE `userid`=?";
			$ins = array($useid);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			$x=0;
			$y=0;
			foreach ($data as $value) {
				if ($x==0){$t="کد های طلایی قرعه کشی:";}
				if ($x<6){$t=$t."\n".$value['id'];}
				if ($x==6){$t=$t."\n...";$y=1;}
				$x=$x+1;
			}
			$sql = "SELECT * FROM `qcode` WHERE `userid`=?";
			$ins = array($useid);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			$x=0;

			foreach ($data as $value) {
				if ($x==0){$t=$t."\nکد های معمولی قرعه کشی:";}
				if ($x<10){$t=$t."\n".$value['id'];}
				if ($x==10){$t=$t."\n...";$y=1;}	
				$x=$x+1;
			}
		}

		catch(PDOException $e) {
			echo $e->getMessage();
		}
		if (!isset($t)){$t="هیچ کد قرعه کشی یافت نشد.";}
		$option = array();
		if ($y==1){
			$option = array( 
				array($telegram->buildInlineKeyboardButton('مشاهده تمام کد های قرعه کشی',"http://site")),
			);
		}
			$keyb = $telegram->buildInlineKeyBoard($option);
			$content = ['chat_id' => $chat_id, 'text' => $t, 'reply_markup' => $keyb];
			$telegram->sendMessage($content);
	break;
	case '🏆شرکت در مسابقه':
		$content = array('chat_id' => '@testbot99', 'user_id' => $user_id);
		$join_info = $telegram->getChatMember($content);
		$join_check = $join_info['ok'];
		$join_status = $join_info['result']['status'];
		if(!$join_check || $join_status == 'left'){
			$option = array( 
    				array($telegram->buildInlineKeyboardButton('کانال تلگرام',"https://t.me/testbot99")),
				);
			$keyb = $telegram->buildInlineKeyBoard($option);
			$content = ['chat_id' => $chat_id, 'text' => "ابتدا در کانال تلگرام کانون موعود عضو شده و سپس دوباره تلاش کنید.\n@testbot99", 'reply_markup' => $keyb];
			$telegram->sendMessage($content);
			die();
		}
  		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `match` where ".time().">`start` AND ".time()."<`end` ORDER BY `id` DESC";
			$ins = array();
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			$option = array();
			$tedad=0;
    		foreach ($data as $value) {
				array_push($option, array($telegram->buildInlineKeyboardButton($value['name'],false,"match".$value['id'])));
				$tedad=$tedad+1;
    		}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$keyb = $telegram->buildInlineKeyBoard($option);
		if ($tedad==0){$matn="مسابقه فعالی یافت نشد";}else{$matn="لیست مسابقات فعال👇 (انتخاب کنید)";}
		$content = ['chat_id' => $chat_id, 'text' => $matn, 'reply_markup' => $keyb];
		$telegram->sendMessage($content);
	break;
	case 'تعیین یا تغییر رمز عبور سایت':
  		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "DELETE FROM `bot_cach` WHERE `userid`=?";
			$ins = array($user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$sql = "INSERT INTO `bot_cach`(`userid`, `lcm`) VALUES (?,?)";
			$ins = array($user_id,"setpass");
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		$content = ['chat_id' => $chat_id, 'text' => "رمز عبور مدنظر خود را ارسال کنید."];
		$telegram->sendMessage($content);
	break;
	case 'اتمام':
  		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `bot_cach` WHERE `userid`=?";
			$ins = array($user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$lcm = $value['lcm'];
    		}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		if ($lcm == "getfinal"){
  			try {
				$conn = "mysql:host=$dburl;dbname=$dbname";
				$con = new PDO($conn, $dbuser, $dbpass);
				$con->exec("SET NAMES 'UTF8'");
				$sql = "SELECT * FROM `bot_users` WHERE `userid`=?";
				$ins = array($user_id);
				$user = $con->prepare($sql);
				$user->execute($ins);
				$data = $user->fetchAll();
    			foreach ($data as $value) {
					$sex = $value['sex'];
					$name = $value['name'];
					$phone = $value['phone'];
					$uni = $value['uni'];
					$major = $value['major'];
					$mnum = $value['mnum'];
					$snum = $value['snum'];
					$maqta = $value['maqta'];
					$province = $value['province'];
					$city = $value['city'];
					$birth = $value['birth'];
    			}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
			if (isset($sex) && isset($name) && isset($phone) && isset($uni) && isset($major) && isset($mnum) && isset($snum) && isset($maqta) && isset($province) && isset($city) && isset($birth)){
				$content = ['chat_id' => $chat_id, 'text' => "ثبت اطلاعات با موفقیت انجام شد✅"];
				$telegram->sendMessage($content);
				main($user_id,$chat_id);
			}else{
				$content = ['chat_id' => $chat_id, 'text' => "اطلاعات ناقص است❌"];
				$telegram->sendMessage($content);
			}
		}else{
			$content = ['chat_id' => $chat_id, 'text' => "🔴خطا. پیام نامعتبر🔴"];
			$telegram->sendMessage($content);
		}
	break;
	case '/start':
		register($user_id,$chat_id);
		//اطلاعات کامل
		break;
		default:
			try {
				$conn = "mysql:host=$dburl;dbname=$dbname";
				$con = new PDO($conn, $dbuser, $dbpass);
				$con->exec("SET NAMES 'UTF8'");
				$sql = "SELECT * FROM `bot_cach` WHERE `userid`=?";
				$ins = array($user_id);
				$user = $con->prepare($sql);
				$user->execute($ins);
				$data = $user->fetchAll();
    			foreach ($data as $value) {
					$lcm = $value['lcm'];
    			}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
			switch($lcm){
				case 'setpass':
 					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `pass`=? WHERE `userid`=?";
						$ins = array(md5(trim($text)),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
						$sql = "DELETE FROM `bot_cach` WHERE `userid`=?";
						$ins = array($user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					$content = ['chat_id' => $chat_id, 'text' => "رمز عبور شما با موفقیت ذخیره شد.", 'reply_to_message_id' => $telegram->MessageID()];
					$telegram->sendMessage($content);
				break;
				case 'getname':
					if (preg_match('/^[0-9A-Za-z_.?،\|*+()&%$#@!۱۲۳۴۵۶۷۸۹۰؛"!؟،×÷=€£₩:`~<>{}♧◇♡♤■□●○•°☆▪️¤《》¡¿]*$/', $text)){
						$content = ['chat_id' => $chat_id, 'text' => "برای ارسال نام فقط استفاده از کاراکتر های فارسی مجاز است.", 'reply_to_message_id' => $telegram->MessageID()];
						$telegram->sendMessage($content);
						die();
					}
 					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `name`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getmnum':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "SELECT * FROM `bot_users` WHERE `mnum`=?";
						$ins = array(trim($text));
						$user = $con->prepare($sql);
						$user->execute($ins);
						$data = $user->fetchAll();
						$userid="";
						foreach ($data as $value) {
							$usid = $value['userid'];
							$pho = substr($value['phone'], -4, 7)."****".substr($value['phone'], 0, -7);
						}
						if(isset($usid) && $usid<>$user_id){
							$content = ['chat_id' => $chat_id, 'text' => "کد ملی شما قبلا برای شماره ". $pho." ثبت شده است. \nدر صورتی که فکر می کنید خطایی رخ داده است این پیام را برای آیدی زیر فوروارد کنید. \n@saeedbahrampour \n er: ".$user_id, 'reply_to_message_id' => $telegram->MessageID()];
							$telegram->sendMessage($content);
							die();
						}
						if(!is_numeric(trim($text))){
							$content = ['chat_id' => $chat_id, 'text' => "کد ملی فقط باید اعداد انگلیسی باشد.\nℹ️لطفا دوباره تلاش کنید", 'reply_to_message_id' => $telegram->MessageID()];
							$telegram->sendMessage($content);
							die();
						}
						if(strlen(trim($text))<>10){
							$content = ['chat_id' => $chat_id, 'text' => "کد ملی باید 10 رقمی باشد\n درصورتی که کد ملی شما کمتر از 10 رقم است صفر های ابتدای آن را قرار دهید\nℹ️لطفا دوباره تلاش کنید", 'reply_to_message_id' => $telegram->MessageID()];
							$telegram->sendMessage($content);
							die();
						}
						$sql = "UPDATE `bot_users` SET `mnum`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getsnum':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "SELECT * FROM `bot_users` WHERE `snum`=?";
						$ins = array(trim($text));
						$user = $con->prepare($sql);
						$user->execute($ins);
						$data = $user->fetchAll();
						$userid="";
						foreach ($data as $value) {
							$usid = $value['userid'];
							$pho = substr($value['phone'], -4, 7)."****".substr($value['phone'], 0, -7);
						}
						if(isset($usid) && $usid<>$user_id){
							$content = ['chat_id' => $chat_id, 'text' => "شماره دانشجویی شما قبلا برای شماره ". $pho." ثبت شده است. \nدر صورتی که فکر می کنید خطایی رخ داده است این پیام را برای آیدی زیر فوروارد کنید. \n@saeedbahrampour \n er: ".$user_id, 'reply_to_message_id' => $telegram->MessageID()];
							$telegram->sendMessage($content);
							die();
						}
						if(!is_numeric(trim($text))){
							$content = ['chat_id' => $chat_id, 'text' => "شماره دانشجویی فقط باید اعداد انگلیسی باشد."];
							$telegram->sendMessage($content);
							die();
						}
						$sql = "UPDATE `bot_users` SET `snum`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					$option = array( 
						array($telegram->buildKeyboardButton('دانشگاه علوم پزشکی رفسنجان',false, false)),
						array($telegram->buildKeyboardButton('دانشگاه علوم پزشکی کرمان',false, false)));
					register($user_id,$chat_id);
				break;
				case 'getuni':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `uni`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getmajor':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `major`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getmaqta':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `maqta`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getprovince':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `province`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getcity':
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_users` SET `city`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					register($user_id,$chat_id);
				break;
				case 'getyear':
					if(!is_numeric(trim($text))){
						$content = ['chat_id' => $chat_id, 'text' => "برای سال تولد فقط اعداد انگلیسی مجاز است"];
						$telegram->sendMessage($content);
						die();
					}
					if(strlen(trim($text))<>4){
						$content = ['chat_id' => $chat_id, 'text' => "سال تولد باید 4 رقمی باشد"];
						$telegram->sendMessage($content);
						die();
					}
					try {
						$conn = "mysql:host=$dburl;dbname=$dbname";
						$con = new PDO($conn, $dbuser, $dbpass);
						$con->exec("SET NAMES 'UTF8'");
						$sql = "UPDATE `bot_cach` SET `lcm`=? WHERE `userid`=?";
						$ins = array("getfinal",$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
						$sql = "UPDATE `bot_cach` SET `data`=? WHERE `userid`=?";
						$ins = array(trim($text),$user_id);
						$user = $con->prepare($sql);
						$user->execute($ins);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					$content = ['chat_id' => $chat_id, 'text' => "⬇️لطفا به سوالات زیر پاسخ دهید⬇️"];
					$telegram->sendMessage($content);
					$content = ['chat_id' =>$chat_id, 'action' => 'typing'];
					$telegram->sendChatAction($content);
					//جنسیت
					$option = array( 
						array($telegram->buildInlineKeyBoardButton('🙍🏻‍♂️آقا',false,"sex1"),$telegram->buildInlineKeyBoardButton('🙎🏻‍♀️خانم',false, "sex2")),
						);
					$keyb = $telegram->buildInlineKeyBoard($option);
					$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "لطفا جنسیت خود را انتخاب کنید"];
					$telegram->sendMessage($content);
					$content = ['chat_id' =>$chat_id, 'action' => 'typing'];
					$telegram->sendChatAction($content);
					//ماه تولد
					$option = array( 
						array($telegram->buildInlineKeyBoardButton('خرداد',false, "month03"),$telegram->buildInlineKeyBoardButton('اردیبهشت',false, "month02"),$telegram->buildInlineKeyBoardButton('فروردین',false, "month01")),
						array($telegram->buildInlineKeyBoardButton('شهریور',false, "month06"),$telegram->buildInlineKeyBoardButton('مرداد',false, "month05"),$telegram->buildInlineKeyBoardButton('تیر',false, "month04")),
						array($telegram->buildInlineKeyBoardButton('آذر',false, "month09"),$telegram->buildInlineKeyBoardButton('آبان',false, "month08"),$telegram->buildInlineKeyBoardButton('مهر',false, "month07")),
						array($telegram->buildInlineKeyBoardButton('اسفند',false, "month12"),$telegram->buildInlineKeyBoardButton('بهمن',false, "month11"),$telegram->buildInlineKeyBoardButton('دی',false, "month10")),
						);
					$keyb = $telegram->buildInlineKeyBoard($option);
					$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "لطفا ماه تولد خود را انتخاب کنید \n تاریخ تولد: --/--/".trim($text)];
					$telegram->sendMessage($content);
					$content = ['chat_id' =>$chat_id, 'action' => 'typing'];
					$telegram->sendChatAction($content);
					//اتمام ثبت نام
					$option = array( 
						array($telegram->buildKeyboardButton('اتمام',false, false)),
						);
					$keyb = $telegram->buildKeyBoard($option,true,true);
					$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "لطفا پس از پاسخ به سوالات بالا از منوی زیر 'اتمام' را انتخاب کنید"];
					$telegram->sendMessage($content);
				break;
			}
		break;
}

if(isset($update->message->contact)){
	//دریافت شماره
	try {
		$conn = "mysql:host=$dburl;dbname=$dbname";
		$con = new PDO($conn, $dbuser, $dbpass);
		$con->exec("SET NAMES 'UTF8'");
		$sql = "SELECT * FROM `bot_cach` WHERE `userid`=?";
		$ins = array($user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
		$data = $user->fetchAll();
    	foreach ($data as $value) {
			$lcm = $value['lcm'];
    	}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	//شماره یافت شد
	if($lcm == "getphone" && isset($update->message->contact->user_id) && $update->message->contact->user_id == $update->message->from->id){
		if (strlen($update->message->contact->phone_number)==13){
			if(substr($update->message->contact->phone_number,0,3)<>"+98"){
				$content = ['chat_id' => $chat_id, 'text' => "فعلا امکان ثبت نام با شماره های خارج از ایران مقدور نیست"];
				$telegram->sendMessage($content);
				die();
			}
			$phon = substr($update->message->contact->phone_number,3,11);
		}else{
			if(substr($update->message->contact->phone_number,0,2)<>"98"){
				$content = ['chat_id' => $chat_id, 'text' => "فعلا امکان ثبت نام با شماره های خارج از ایران مقدور نیست"];
				$telegram->sendMessage($content);
				die();
			}
			$phon = substr($update->message->contact->phone_number,2,11);
		}
		try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = 'SELECT * FROM `bot_users` WHERE `phone` LIKE ?';
			$ins = array('%'.$phon.'%');
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			if($data){
				$sql = 'UPDATE `bot_users` SET `userid`=?,`username`=? WHERE `phone` LIKE ?';
				$ins = array($user_id,$telegram->Username(),'%'.$phon.'%');
				$user = $con->prepare($sql);
				$user->execute($ins);
			}else{
				$sql = 'SELECT * FROM `bot_users` WHERE `userid` LIKE ?';
				$ins = array('%'.$user_id.'%');
				$user = $con->prepare($sql);
				$user->execute($ins);
				$data = $user->fetchAll();
				if ($data){
					$sql = 'UPDATE `bot_users` SET `phone`=?,`username`=? WHERE `userid` LIKE ?';
					$ins = array("+98".$phon,$telegram->Username(),'%'.$user_id.'%');
					$user = $con->prepare($sql);
					$user->execute($ins);
				}else{
					$tt="10";
					do {
						$sql = 'INSERT INTO `bot_users`(`id`, `userid`, `phone`, `username`) VALUES (?,?,?,?)';
						$ins = array(rand(100001,999999),$user_id,$phon,$telegram->Username());
						$user = $con->prepare($sql);
						if($user->execute($ins)){$tt="12"; }
					}while( $tt=="10");
				}
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		register($user_id,$chat_id);
	}else{
		$content = ['chat_id' => $chat_id, 'text' => "🔴خطا. پیام نامعتبر🔴"];
		$telegram->sendMessage($content);
	}
}

if(isset($update->callback_query) && $update->callback_query->data == 'sex1'){
	try {
		$conn = "mysql:host=$dburl;dbname=$dbname";
		$con = new PDO($conn, $dbuser, $dbpass);
		$con->exec("SET NAMES 'UTF8'");
		$sql = "UPDATE `bot_users` SET `sex`=? WHERE `userid`=?";
		$ins = array("1",$user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "جنسیت ثبت شد
آقا🙎🏻‍♂️"];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && $update->callback_query->data == 'sex2'){
	try {
		$conn = "mysql:host=$dburl;dbname=$dbname";
		$con = new PDO($conn, $dbuser, $dbpass);
		$con->exec("SET NAMES 'UTF8'");
		$sql = "UPDATE `bot_users` SET `sex`=? WHERE `userid`=?";
		$ins = array("2",$user_id);
		$user = $con->prepare($sql);
		$user->execute($ins);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "جنسیت ثبت شد
خانم🙎🏻‍♀️"];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,5) == 'month'){
  	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `bot_cach` WHERE `userid`=?";
			$ins = array($user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$data = $value['data'];
    			}
			$sql = 'UPDATE `bot_cach` SET `data`=? WHERE `userid`=?';
			$ins = array($data."/".substr($update->callback_query->data,5,2),$user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	$option = array( 
		array($telegram->buildInlineKeyBoardButton('1',false, "day01"),$telegram->buildInlineKeyBoardButton('2',false, "day02"),$telegram->buildInlineKeyBoardButton('3',false, "day03"),$telegram->buildInlineKeyBoardButton('4',false, "day04"),$telegram->buildInlineKeyBoardButton('5',false, "day05")),
		array($telegram->buildInlineKeyBoardButton('6',false, "day06"),$telegram->buildInlineKeyBoardButton('7',false, "day07"),$telegram->buildInlineKeyBoardButton('8',false, "day08"),$telegram->buildInlineKeyBoardButton('9',false, "day09"),$telegram->buildInlineKeyBoardButton('10',false, "day10")),
		array($telegram->buildInlineKeyBoardButton('11',false, "day11"),$telegram->buildInlineKeyBoardButton('12',false, "day12"),$telegram->buildInlineKeyBoardButton('13',false, "day13"),$telegram->buildInlineKeyBoardButton('14',false, "day14"),$telegram->buildInlineKeyBoardButton('15',false, "day15")),
		array($telegram->buildInlineKeyBoardButton('16',false, "day16"),$telegram->buildInlineKeyBoardButton('17',false, "day17"),$telegram->buildInlineKeyBoardButton('18',false, "day18"),$telegram->buildInlineKeyBoardButton('19',false, "day19"),$telegram->buildInlineKeyBoardButton('20',false, "day20")),
		array($telegram->buildInlineKeyBoardButton('21',false, "day21"),$telegram->buildInlineKeyBoardButton('22',false, "day22"),$telegram->buildInlineKeyBoardButton('23',false, "day23"),$telegram->buildInlineKeyBoardButton('24',false, "day24"),$telegram->buildInlineKeyBoardButton('25',false, "day25")),
		array($telegram->buildInlineKeyBoardButton('26',false, "day26"),$telegram->buildInlineKeyBoardButton('27',false, "day27"),$telegram->buildInlineKeyBoardButton('28',false, "day28"),$telegram->buildInlineKeyBoardButton('29',false, "day29"),$telegram->buildInlineKeyBoardButton('30',false, "day30"),$telegram->buildInlineKeyBoardButton('31',false, "day31")),
	);
	$keyb = $telegram->buildInlineKeyBoard($option);
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'reply_markup' => $keyb, 'text' => "لطفا روز تولد خود را انتخاب کنید \n تاریخ تولد: --/".$data."/".substr($update->callback_query->data,5,2)];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,3) == 'day'){
  	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `bot_cach` WHERE `userid`=?";
			$ins = array($user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$data = $value['data'];
    			}
			$sql = 'UPDATE `bot_users` SET `birth`=? WHERE `userid`=?';
			$ins = array($data."/".substr($update->callback_query->data,3,2),$user_id);
			$user = $con->prepare($sql);
			$user->execute($ins);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "تاریخ تولد ثبت شد \n تاریخ تولد: ".$data."/".substr($update->callback_query->data,3,2)];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,8) == 'register'){
  	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT `id`, `name`, `pay`, `desc`, `start`, `end`, `group`, `capacity` FROM `plan` WHERE `id`=?";
			$ins = array(substr($update->callback_query->data,8,8));
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$pid = $value['id'];
				$pname = $value['name'];
				$ppay = $value['pay'];
				$pdesc = $value['desc'];
				$pstart = $value['start'];
				$pend = $value['end'];
				$pgroup = $value['group'];
				$pcapacity = $value['capacity'];
    		}
			if($pend<time()){
				$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "پایان مهلت زمانی"];
    			$telegram->editMessageText($content);
				die();
			}
			$sql = "SELECT `id` FROM `registred` WHERE `pid`=?";
			$ins = array(substr($update->callback_query->data,8,8));
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			$ted = 0;
    		foreach ($data as $value) {
				$ted = $ted+1;
    			}
			if($ted>=$pcapacity){
				$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "تکمیل ظرفیت"];
    			$telegram->editMessageText($content);
				die();
			}
			$sql = "SELECT `mnum` FROM `bot_users` WHERE `userid`=?";
			$ins = array(substr($update->callback_query->data,8,8));
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
			$ted = 0;
    		foreach ($data as $value) {
				$mnum = $value['mnum'];
    			}
			$sql = "SELECT `id` FROM `registred` WHERE `pid`=? AND `mnum`=?";
			$ins = array(substr($update->callback_query->data,8,8),$mnum);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$rid = $value['id'];	
			}
			if($data){
				$option = array( 
    				array($telegram->buildInlineKeyboardButton('انصراف',false,"cancelreg$rid")),
				);
				$keyb = $telegram->buildInlineKeyBoard($option);
    			$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "شما قبلا ثبت نام کرده اید. جهت انصراف از دکمه زیر استفاده کنید.", 'reply_markup' => $keyb];
    			$telegram->editMessageText($content);
				die();
			}
			$sql = "SELECT `id` FROM `registred` WHERE `pid`=? AND `mnum`=?";
			$ins = array(substr($update->callback_query->data,8,8),$mnum);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				$rid = $value['id'];	
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "تاریخ تولد ثبت شد \n تاریخ تولد: ".$data."/".substr($update->callback_query->data,3,2)];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,5) == 'match'){
  	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `match` WHERE `id`=?";
			$ins = array(substr($update->callback_query->data,5,8));
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				if ($value['start']<time() && $value['end']>time()){
					$matchinfo = $value['name']."\n".$value['info']."\nزمان شروع: ".jdate('Y/n/j,H:i:s',$value['start'])."\nزمان پایان: ".jdate('Y/n/j,H:i:s',$value['end'])."\nهنگامی که آماده بودید بر روی 'شروع مسابقه' کلیک کنید";
    			}else{
					$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "پایان مهلت زمانی"];
    				$telegram->editMessageText($content);
					die();
				}
			}

		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	$option = array( 
    				array($telegram->buildInlineKeyboardButton("شروع مسابقه",false,"smatch".substr($update->callback_query->data,5,8))),
				);
	$keyb = $telegram->buildInlineKeyBoard($option);
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => $matchinfo, 'reply_markup' => $keyb];
    $telegram->editMessageText($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,6) == 'smatch'){
	$content = ['chat_id' =>$chat_id, 'action' => 'typing'];
	$telegram->sendChatAction($content);

  	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `match` WHERE `id`=?";
			$ins = array(substr($update->callback_query->data,6,8));
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				if ($value['end']<time()){
					$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "پایان مهلت زمانی"];
    				$telegram->editMessageText($content);
					die();
    			}else{
					$sql = "SELECT * FROM `participant` WHERE `matchid`=? AND `userid`=?";
					$ins = array(substr($update->callback_query->data,6,8),$useid);
					$user = $con->prepare($sql);
					$user->execute($ins);
					$data = $user->fetchAll();
					foreach ($data as $value) {
						if (isset($value['end'])){
							$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "پاسخ شما به سوالات این آزمون قبلا ثبت شده است"];
							$telegram->editMessageText($content);
							die();
						}else{
							$sql = "SELECT * FROM `question` WHERE `matchid`=?";
							$ins = array(substr($update->callback_query->data,6,8));
							$user = $con->prepare($sql);
							$user->execute($ins);
							$data = $user->fetchAll();
							foreach ($data as $value) {
								$sql1 = "SELECT `selected` FROM `answers` WHERE `matchid`=? AND `qid`=? AND `userid`=?";
								$ins1 = array(substr($update->callback_query->data,6,8),$value['id'],$useid);
								$user1 = $con->prepare($sql1);
								$user1->execute($ins1);
								$data1 = $user1->fetchAll();
								$selected="";
								foreach ($data1 as $value1) {
									if (isset($value1['selected'])) {$selected="\n\nپاسخ انتخابی شما: گزینه ".$value1['selected'];}
								}
								$option = array( 
									array($telegram->buildInlineKeyBoardButton('گزینه 2',false, "pasokh2Q".$value['id']."M".substr($update->callback_query->data,6,8)),$telegram->buildInlineKeyBoardButton('گزینه 1',false, "pasokh1Q".$value['id']."M".substr($update->callback_query->data,6,8))),
									array($telegram->buildInlineKeyBoardButton('گزینه 4',false, "pasokh4Q".$value['id']."M".substr($update->callback_query->data,6,8)),$telegram->buildInlineKeyBoardButton('گزینه 3',false, "pasokh3Q".$value['id']."M".substr($update->callback_query->data,6,8))),
								);
								$keyb = $telegram->buildInlineKeyBoard($option);
								$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $value['q']."\n1) ".$value['item1']."\n2) ".$value['item2']."\n3) ".$value['item3']."\n4) ".$value['item4'].$selected];
								$telegram->sendMessage($content);
							}
						}
					}
					if (!$data){
						$sql = "INSERT INTO `participant`( `matchid`, `userid`, `start`) VALUES (?,?,?)";
						$ins = array(substr($update->callback_query->data,6,8),$useid,time());
						$user = $con->prepare($sql);
						$user->execute($ins);
						$sql = "SELECT * FROM `question` WHERE `matchid`=?";
						$ins = array(substr($update->callback_query->data,6,8));
						$user = $con->prepare($sql);
						$user->execute($ins);
						$data = $user->fetchAll();
						foreach ($data as $value) {
							$sql = "INSERT INTO `answers`(`matchid`, `qid`, `userid`,`time`) VALUES (?,?,?,?)";
							$ins = array(substr($update->callback_query->data,6,8),$value["id"],$useid,time());
							$user = $con->prepare($sql);
							$user->execute($ins);
							$option = array( 
								array($telegram->buildInlineKeyBoardButton('گزینه 2',false, "pasokh2Q".$value['id']."M".substr($update->callback_query->data,6,8)),$telegram->buildInlineKeyBoardButton('گزینه 1',false, "pasokh1Q".$value['id']."M".substr($update->callback_query->data,6,8))),
								array($telegram->buildInlineKeyBoardButton('گزینه 4',false, "pasokh4Q".$value['id']."M".substr($update->callback_query->data,6,8)),$telegram->buildInlineKeyBoardButton('گزینه 3',false, "pasokh3Q".$value['id']."M".substr($update->callback_query->data,6,8))),
							);
							$keyb = $telegram->buildInlineKeyBoard($option);
							$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $value['q']."\n1) ".$value['item1']."\n2) ".$value['item2']."\n3) ".$value['item3']."\n4) ".$value['item4']];
							$telegram->sendMessage($content);
						}
					}
				}
			}

		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id']];
    $telegram->deleteMessage($content);
	$option = array( 
		array($telegram->buildInlineKeyBoardButton('اتمام',false, "end".substr($update->callback_query->data,6,8))),
	);
	$keyb = $telegram->buildInlineKeyBoard($option);
	$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "لطفا پس از پاسخ گویی به همه سوالات و تا قبل از مهلت اتمام مسابقه با انتخاب 'اتمام' پاسخ های خود را ثبت نهایی کنید.\n پس از اتمام مسابقه امکان ویرایش پاسخ ها وجود ندارد"];
	$telegram->sendMessage($content);
}
if(isset($update->callback_query) && substr($update->callback_query->data,0,6) == 'pasokh'){
	$matchid = substr($update->callback_query->data,strpos($update->callback_query->data,"M")+1,6);
//$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "11", 'show_alert' => "true"];$telegram->answerCallbackQuery($content);
	$qid = substr($update->callback_query->data,strpos($update->callback_query->data,"Q")+1,strpos($update->callback_query->data,"M")-1-strpos($update->callback_query->data,"Q"));
	$si = substr($update->callback_query->data,6,1);

 	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `match` WHERE `id`=?";
			$ins = array($matchid);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				if ($value['end']<time()){
					$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id']];
					$telegram->deleteMessage($content);
					
					$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "پایان مهلت زمانی آزمون", 'show_alert' => "true"];
					$telegram->answerCallbackQuery($content);
					die();
    			}
				$sql = "SELECT * FROM `participant` WHERE `matchid`=? AND `userid`=?";
				$ins = array($matchid,$useid);
				$user = $con->prepare($sql);
				$user->execute($ins);
				$data = $user->fetchAll();
				foreach ($data as $value) {
					if (isset($value['end'])){
						$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id']];
						$telegram->deleteMessage($content);

						$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "پاسخ شما به سوالات این آزمون قبلا ثبت شده است", 'show_alert' => "true"];
						$telegram->answerCallbackQuery($content);
						die();
						}

					$sql = "SELECT * FROM `question` WHERE `matchid`=? AND `id`=?";
					$ins = array($matchid,$qid);
					$user = $con->prepare($sql);
					$user->execute($ins);
					$data = $user->fetchAll();
					foreach ($data as $value) {
						$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "گزینه $si ثبت شد", 'show_alert' => "false"];
						$telegram->answerCallbackQuery($content);

						$status="0";
						if ($si==$value['answer']){$status="1";}
						$sql1 = "UPDATE `answers` SET `selected`=?,`answer`=?,`status`=?,`time`=? WHERE `matchid`=? AND `qid`=? AND `userid`=?";
						$ins1 = array($si,$value['answer'],$status,time(),$matchid,$qid,$useid);
						$user1 = $con->prepare($sql1);
						$user1->execute($ins1);
						$data1 = $user1->fetchAll();
						$selected="\n\nپاسخ انتخابی شما: گزینه ".$si;

						$option = array( 
							array($telegram->buildInlineKeyBoardButton('گزینه 2',false, "pasokh2Q".$qid."M".$matchid),$telegram->buildInlineKeyBoardButton('گزینه 1',false, "pasokh1Q".$qid."M".$matchid)),
							array($telegram->buildInlineKeyBoardButton('گزینه 4',false, "pasokh4Q".$qid."M".$matchid),$telegram->buildInlineKeyBoardButton('گزینه 3',false, "pasokh3Q".$qid."M".$matchid)),
						);
						$keyb = $telegram->buildInlineKeyBoard($option);
						$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => $value['q']."\n1) ".$value['item1']."\n2) ".$value['item2']."\n3) ".$value['item3']."\n4) ".$value['item4'].$selected, 'reply_markup' => $keyb];
						$telegram->editMessageText($content);
					}
				}
			}
	}
		catch(PDOException $e) {
			echo $e->getMessage();
		}

}
if(isset($update->callback_query) && substr($update->callback_query->data,0,3) == 'end'){
	$matchid = substr($update->callback_query->data,3,6);

 	try {
			$conn = "mysql:host=$dburl;dbname=$dbname";
			$con = new PDO($conn, $dbuser, $dbpass);
			$con->exec("SET NAMES 'UTF8'");
			$sql = "SELECT * FROM `match` WHERE `id`=?";
			$ins = array($matchid);
			$user = $con->prepare($sql);
			$user->execute($ins);
			$data = $user->fetchAll();
    		foreach ($data as $value) {
				if ($value['end']<time()){
					$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id']];
					$telegram->deleteMessage($content);
					
					$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "پایان مهلت زمانی آزمون", 'show_alert' => "true"];
					$telegram->answerCallbackQuery($content);
					die();
    			}
				$sql = "SELECT * FROM `participant` WHERE `matchid`=? AND `userid`=?";
				$ins = array($matchid,$useid);
				$user = $con->prepare($sql);
				$user->execute($ins);
				$data = $user->fetchAll();
				foreach ($data as $value) {
					if (isset($value['end'])){
						$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id']];
						$telegram->deleteMessage($content);

						$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "پاسخ شما به سوالات این آزمون قبلا ثبت شده است", 'show_alert' => "true"];
						$telegram->answerCallbackQuery($content);
						die();
						}

					$sql = "SELECT * FROM `answers` WHERE `matchid`=? AND `userid`=?";
					$ins = array($matchid,$useid);
					$user = $con->prepare($sql);
					$user->execute($ins);
					$data = $user->fetchAll();
					$score=0;
					if (!$data){
						$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "خطا".$matchid, 'show_alert' => "true"];
						$telegram->answerCallbackQuery($content);
						die();
					}
					foreach ($data as $value) {
						if ($value['selected']==""){
							$content = ['callback_query_id' => $result['callback_query']['id'], 'text' => "شما به همه سوالات پاسخ نداده اید", 'show_alert' => "true"];
							$telegram->answerCallbackQuery($content);
							die();
						}
						if ($value['status']==1){
							$score = $score + 1;
						}
					}
					$sql1 = "UPDATE `participant` SET `score`=?,`end`=? WHERE `matchid`=? AND `userid`=?";
					$ins1 = array($score,time(),$matchid,$useid);
					$user1 = $con->prepare($sql1);
					$user1->execute($ins1);
					$data1 = $user1->fetchAll();
					
					$option = array();
					$keyb = $telegram->buildInlineKeyBoard($option);
					$content = ['chat_id' => $telegram->Callback_ChatID(), 'message_id' => $result['callback_query']['message']['message_id'], 'text' => "پاسخ شما به سوالات با موفقیت ثبت نهایی شد.\nزمان پایان : ".jdate('Y/n/j,H:i:s',time()), 'reply_markup' => $keyb];
					$telegram->editMessageText($content);
					}
				}
			}
		catch(PDOException $e) {
			echo $e->getMessage();
		}

}


?>