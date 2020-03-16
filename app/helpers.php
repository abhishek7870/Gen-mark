<?php
use App\Code;
function sendSMS($user) {
  $code = new Code();
  $code->code = rand(pow(10, 3), pow(10, 4)-1);
  $user->codes()->save($code);
  
	$username = 'himanshu.sukhwani@gmail.com'; 
	$hash = env('TEXTLOCAL_HASH');
	$sender = urlencode('TXTLCL');
	$message = rawurlencode('this is verification code '.$code->code);
	$data = array('username' => $username, 'hash' => $hash, 'numbers' => $user->mobile_no, "sender" => $sender, "message" => $message);
	$ch = curl_init('http://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	Log::info('sent message: ' . $response);
  return;
}
function downloadImageAndSave($request)
{ 
  
       // $uploadedfile = StaffBasicDetails::find($id);
       $file = $request['image']->getClientOriginalName();
       $extension = $request['image']->getClientOriginalExtension(); 
       $filename = pathinfo($file, PATHINFO_FILENAME);
       $originalName = $filename.'.'.$extension; 
       // $cover = $request->file('image');
       Storage::disk('public')->put($originalName,File::get($request['image']));
       $request['image_name'] = $originalName;
       $request['image_url'] = Storage::disk('public')->url($originalName);
       return $request;
}
?>