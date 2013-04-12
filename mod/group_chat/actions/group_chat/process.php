<?php
$function = $_GET['function'];
$profilePic = $_GET['profilePic'];
$log = array();

// Connect to database to retrieve dataroot
global $CONFIG;

$smiley_url = $CONFIG->url.'mod/group_chat/graphics/smiley/';

// Define smiley array
$smiley = array(':)' => '<img src="'.$smiley_url.'smile.gif">',
    ':(' => '<img src="'.$smiley_url.'frown.gif">',
    ':0' => '<img src="'.$smiley_url.'gasp.gif">',
    'O:-)' => '<img src="'.$smiley_url.'angel.gif">',
    ':3' => '<img src="'.$smiley_url.'colonthree.gif">',

    'o.O' => '<img src="'.$smiley_url.'confused.gif">',
    ":'(" => '<img src="'.$smiley_url.'cry.gif">',
    '3:-)' => '<img src="'.$smiley_url.'devil.gif">',
    ':o' => '<img src="'.$smiley_url.'gasp.gif">',
    'B-)' => '<img src="'.$smiley_url.'glasses.gif">',

    ':D' => '<img src="'.$smiley_url.'grin.gif">',
    '-.-' => '<img src="'.$smiley_url.'grumpy.gif">',
    '^_^' => '<img src="'.$smiley_url.'kiki.gif">',
    ':-*' => '<img src="'.$smiley_url.'kiss.gif">',
    ':v' => '<img src="'.$smiley_url.'pacman.gif">',

    '-_-' => '<img src="'.$smiley_url.'squint.gif">',
    '8|' => '<img src="'.$smiley_url.'sunglasses.gif">',
    ':p' => '<img src="'.$smiley_url.'tongue.gif">',
    ':-/' => '<img src="'.$smiley_url.'unsure.gif">',
    '-_-' => '<img src="'.$smiley_url.'upset.gif">',


    'heart' => '<img src="'.$smiley_url.'heart.gif">',
    'HEART' => '<img src="'.$smiley_url.'heart.gif">',
    'LOVE' => '<img src="'.$smiley_url.'heart.gif">',
    'love' => '<img src="'.$smiley_url.'heart.gif">',
    'X)' => '<img src="'.$smiley_url.'devil.gif">'          
  );

// Check group chat directory. if not exist then create else use it
$dataroot = $CONFIG->dataroot;
if(!is_dir($dataroot.'group_chat')){
  mkdir($dataroot.'group_chat', 0777);
  chmod($dataroot.'group_chat', 0777);
}
$groupEntityId =  get_input('groupEntityId');
if(!is_dir($dataroot.'group_chat'.'/'.$groupEntityId)){
  mkdir($dataroot.'group_chat'.'/'.$groupEntityId, 0777);
  chmod($dataroot.'group_chat'.'/'.$groupEntityId, 0777);
}
    
$chatLogDir = $dataroot.'group_chat'.'/'.$groupEntityId.'/';
$dayWiseChatLog = date('mdY').'.txt';
$filePath = $chatLogDir.$dayWiseChatLog;//'chat.txt';

switch($function) {
  case('getState'):
    if (file_exists($filePath)) { $lines = file($filePath); }
    $log['state'] = count($lines); 
    break;
    
  case('update'):
    $state = $_GET['state'];
    if (file_exists($filePath)) { $lines = file($filePath); }
    $log['count_lines'] = $state.'_'.count($lines);
    $count =  count($lines);
    if ($state == $count) {
       $log['state'] = $state;
       $log['text'] = false;
     } else {
       $text= array();
       $log['state'] = $state + count($lines) - $state;
       foreach ($lines as $line_num => $line) {
         if ($line_num >= $state) {
           $text[] =  $line = str_replace("\n", "", $line);
         }
       }
      $log['text'] = $text; 
     }
     break;
     
  case('send'):
    $nickname = htmlentities(strip_tags($_GET['nickname']));
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $message = htmlentities(strip_tags($_GET['message']), ENT_QUOTES | ENT_IGNORE, "UTF-8");
    if (($message) != "\n") {
      if(preg_match($reg_exUrl, $message, $url)) {
        $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
      }
      
      // Replace smily with image                  
      foreach($smiley as $key => $value){
        $message = str_replace($key, $value, $message);
      }
      
      $profileUrl = $CONFIG->url.'profile/'.$nickname;
      $messageStr = str_replace("\n", " ", $message);
      if (trim($messageStr) != '') {
        $message = "<li class='chatTxt' id='chat' onmouseover='chatCall(this);'><div class='chatTime'>"
          //.date('h:i a')
          .date('H:i') // 24 hours format
          ."</div><div class='clear padTop5'><div style='float:left'><a href='".$profileUrl."'><img src='".$profilePic."' title='title' width='25' height='25' /></a></div><div class='floatLeft txtDiv'><a href='".$profileUrl."'><strong>".ucfirst($nickname).":</strong></a>&nbsp;<span style='color:#666666'>".$messageStr."</span></div></div><div class='clear'></div></li>";
        fwrite(fopen($filePath, 'a'), $message. "\n");
      }
    }
    break;
  
}
$log['dataroot'] = $dataroot;
echo json_encode($log);


