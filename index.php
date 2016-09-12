<?php

define('BOT_TOKEN','TOKEN');


function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".BOT_TOKEN."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res,true);
}


function getupdates($up_id){
  $get = bot('getupdates',[
    'offset'=>$up_id
  ]);
  return end($get['result']);
}


function run($up){
  $msg = $up['message'];
  if($msg){
    bot('sendMessage',[
      'chat_id'=>$msg['chat']['id'],
      'text'=>"Test"
    ]);
  }
}
while(true){
  $last_up = $last_up or 0;
  $get_up = getupdates($last_up+1);
  $last_up = $get_up['update_id'];
  run($get_up);
  sleep(0.1);
}
