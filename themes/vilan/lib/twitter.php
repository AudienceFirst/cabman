<?php
require_once 'twitteroauth/twitteroauth/twitteroauth.php';
 
function encode_tweet($text) {
    $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
    return $text;
}
function hyperlinks($text) {
    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
    // match name@address
    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
        //mach #trendingtopics. Props to Michael Voigt
    $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
    return $text;
}
function twitter_users($text) {
   $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
   return $text;
}	

function gg_get_tweets( $username, $limit ) {
  
  $consumerkey       = "nLTImx4SsZAersA4wO5wYy4LP";
  $consumersecret    = "9hfCKTPaEED0fTMxe2pPsBI10Dx9BSEEJuunMOunK2iD0dMbKp";
  $accesstoken       = "1453414070-Vuf0Rm8lvQv99rfCvNmlznLJeeQ8ieUPEYui0Dy";
  $accesstokensecret = "IHa6j7EmCqSXbuJAoSuei4X4WqhYC9KswFuTdDkskBnB8";
	
	$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$limit);
  $username_follow = '<a class="pull-left" href="https://twitter.com/intent/user?screen_name='.$username.'"><i class="social_twitter"></i>'.$username.'</a>';
	
	$i=0;
	$hyperlinks = true;
	$encode_utf8 = true;
	$twitter_users = true;
	$update = true; 
	
	$result = '<ul>';

    foreach($tweets as $item){
        $msg = $item->text;
        $permalink = 'http://twitter.com/#!/'. $username .'/status/'. $item->id_str;
        $msg = encode_tweet($msg);
        $link = $permalink;
        $result .= '<li>';
         
        if ($hyperlinks)
          $msg = hyperlinks($msg);
        if ($twitter_users)
          $msg = twitter_users($msg);

        if($update) {
          $time = strtotime($item->created_at);
          if ( ( abs( time() - $time) ) < 86400 )
            $h_time = sprintf( __('%s ago','okthemes'), human_time_diff( $time ) );
          else
            $h_time = date(__('Y/m/d','okthemes'), $time);
          $result .= sprintf( __('%s', 'okthemes'),' <span class="post-date">'.$username_follow.' <abbr title="' . date(__('Y/m/d H:i:s','okthemes'), $time) . '">' . $h_time . '</abbr></span>' );
        }

        $result .= '<span class="twitter-text">'.$msg.'</span>';
        
        $result .= '</li>';
        $i++;
        if ( $i >= $limit ) break;
    }
	$result .= '</ul>';
	// Display everything
	return $result;

}

?>