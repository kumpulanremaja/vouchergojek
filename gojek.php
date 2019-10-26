<?php
echo "====== ( GOJEK AUTO REGIST AND REDEEM ) ======";
include 'curl.php';
define('Uniqueid', string(16));
function regis() {
        $nam = nama();
        $nama = explode(" ", $nam);
        $namadepan = $nama[0];
        $namabelakang = $nama[1];
        $rand = rand(0000,9999);
        $user = $namadepan.$rand;
        $email = $user."@gmail.com";
        awal:
        echo "\n(?) Nomor HP: ";
        $number1 = trim(fgets(STDIN));
        $number = "+".$number1;
	$headers1 = array(
        'X-Session-ID: 346527b1-73ee-4e8a-bf2b-97b6f18ab9e4',
	'X-Platform: Android',
	'X-UniqueId: '.Uniqueid,
	'X-AppVersion: 3.34.1',
	'X-AppId: com.gojek.app',
	'Accept: application/json',
	'X-PhoneModel: Android,Custom',
	'X-PushTokenType: FCM',
	'X-DeviceOS: Android,6.0', 
	'Authorization: Bearer',
	'Accept-Language: id-ID',
	'X-User-Locale: id_ID',
	'Content-Type: application/json; charset=UTF-8',
	'User-Agent: okhttp/3.12.1'
	);

	$sendotp = curl('https://api.gojekapi.com/v5/customers', '{"email":"'.$email.'","name":"'.$namadepan.' '.$namabelakang.'","phone":"'.$number.'","signed_up_country":"ID"}', $headers1);
        if(strpos($sendotp, '"success":true')){
        echo "(+) Kode verifikasi sudah dikirim";
        $otptoken = fetch_value($sendotp,'"otp_token":"','"');
        echo "\n(?) Kode Verifikasi : ";
        $otp = trim(fgets(STDIN));
        $verifotp = curl('https://api.gojekapi.com/v5/customers/phone/verify', '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp.'","otp_token":"'.$otptoken.'"}}', $headers1);
        if(strpos($verifotp, '"access_token"')){
                echo "(+) Kode verifikasi benar";
                sleep(5);
        $result1 = fetch_value($verifotp, '"access_token":"','"');
        $headers2 = array(
        'X-Session-ID: 346527b1-73ee-4e8a-bf2b-97b6f18ab9e4',
	'X-Platform: Android',
	'X-UniqueId: '.Uniqueid,
	'X-AppVersion: 3.34.1',
	'X-AppId: com.gojek.app',
	'Accept: application/json',
	'X-PhoneModel: Android,Custom',
	'X-PushTokenType: FCM',
	'X-DeviceOS: Android,6.0',
	'Authorization: Bearer '.$result1,
	'Accept-Language: id-ID',
	'X-User-Locale: id_ID',
	'Content-Type: application/json; charset=UTF-8',
	'User-Agent: okhttp/3.12.1',
	);
        $cek = curl('https://api.gojekapi.com/v2/customer/cards/home?filters=', null, $headers2);
        $code = fetch_value($cek,'code=GOFOOD','"');
        $code2 = fetch_value($cek,'code=COBAINGOJEK','"');
        $code1 = "GOFOOD".$code;
        $code3 = "COBAINGOJEK".$code2;
        echo "\n======# DAFTAR KODE VOUCHER GOJEK #======";
        echo "\n[1] GOFOOD";
        echo "\n[2] GORIDE";
        echo "\n[3] GOFOOD FIXED";
        echo "\n[4] INFO VOUCHER GOFOOD\n";
        pilih:
        echo "\n(?) Pilih Kode Voucher : ";
        $pilihan = trim(fgets(STDIN));
        sleep(1);
        if($pilihan == "1"){
        $promo = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"'.$code1.'"}', $headers2);
        $meassage = fetch_value($promo,'{"message":"','"');
        echo "(+) ".$meassage;
        sleep(1);
        echo "\n(?) Apakah Anda Ingin Me-Redeem Voucher Lagi?? (y/n): ";
        $pilih = trim(fgets(STDIN));
        if($pilih == "y"){
        goto pilih;
        }else{                
        die();
        }
        }else if($pilihan == "2"){
        $promo1 = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"'.$code3.'"}', $headers2);
        $message1 = fetch_value($promo1,'{"message":"','"');
        echo "(+) ".$message1;
        echo "\n(?) Apakah Anda Ingin Me-Redeem Voucher Lagi?? (y/n): ";
        $pilih = trim(fgets(STDIN));
        if($pilih == "y"){
        goto pilih;
        }else{                
        die();
        }
        }else if($pilihan == "3"){
        $promo2 = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"GOFOODBOBA07"}', $headers2);
        $message2 = fetch_value($promo2,'{"message":"','"');
        if(strpos($message2, 'cobain!')){
        echo "(+) ".$message2;
        echo "\n(?) Apakah Anda Ingin Me-Redeem Voucher Lagi?? (y/n): ";
        $pilih = trim(fgets(STDIN));
        if($pilih == "y"){
        goto pilih;
        }else{               
        die();
        }
        }else{
        echo "[-] Kode promo sudah tidak aktif";
        echo "\n(?) Apakah Anda Ingin Me-Redeem Voucher Lagi?? (y/n): ";
        $pilih = trim(fgets(STDIN));
        if($pilih == "y"){
        goto pilih;
        }else{
        die();
        }
        }
        }else if($pilihan == "4"){
                echo "JIKA VOUCHER GOFOOD 1 GABISA DIPAKAI, SILAHKAN REDEEM ULANG, KEMUDIAN PILIH KODE VOUCHER 3\n";
                echo "\n(?) Apakah Anda Ingin Me-Redeem Voucher Lagi?? (y/n): ";
                $pilih = trim(fgets(STDIN));
                if($pilih == "y"){
                goto pilih;
                }else{                
                die();
                }
                }else{
        echo "[-] Pilihan tidak ada,silahkan pilih lgi\n";
        sleep(4);
        goto pilih;
        }
    }
  }else if(strpos($sendotp, '"message":"Nomor HP-mu sudah terdaftar')){
  echo "[-] Nomor Hp mu sudah terdaftar";
  echo "\n======-# Silahkan coba ulang #======-\n";
  goto awal;
  }else if(strpos($sendotp, 'Email-mu sudah terdaftar')){
  echo "[-] Email sudah terdaftar";
  echo "\n======-# Silahkan coba ulang #======-\n";
  goto awal;
  }
 }
function start(){
echo regis();
echo "\n";
}
start();
echo "(?) Ingin Mendaftar Lagi ?(y/n):";
$WTF = trim(fgets(STDIN));
if($WTF == "y"){
start();
}else{
die();
}

