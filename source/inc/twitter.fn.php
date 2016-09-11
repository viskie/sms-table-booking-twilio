<?php
/**
 * twitter.fn.php
 *
 * Author: pixelcave
 *
 * Twitter configuration, update status & user's tweets retrieval
 *
 */
 
// Enter your Twitter username & your twitter app keys
// You can get the keys by creating an application at http://dev.twitter.com/apps/new
// Save the file and you are set! :)

$username = '';

$consumer_key = '';
$consumer_secret = '';

$oAuth_token = '';
$oAuth_secret = '';

//////////////// You don't have to edit anything below for the Twitter widget to work ////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ( $username == '' || $consumer_key == '' || $consumer_secret == '' || $oAuth_token == '' || $oAuth_secret == '')
{
    echo '<div class="msg-alert mar-none">Please enter your Twitter credentials in the inc/twitter.fn.php file!</div>';
    exit();
}

// Include the twitter class
require('twitter.class.php');

// Create an object of the Twitter class
$twitter = new Twitter($consumer_key, $consumer_secret);
$twitter->setOAuthToken($oAuth_token);
$twitter->setOAuthTokenSecret($oAuth_secret);

if ($_POST['tweet']) // Update status on Twitter if we have the ajax call with the post variable tweet
{
    $tweet = $_POST['tweet'];

    update_status($twitter, $tweet);
}
else if ($_POST['get_tweets']) // Retrieve tweets from Twitter if we have the ajax call with the post variable get_tweets
{
    $count = $_POST['get_tweets'];

    get_tweets($twitter, $username, $count);
}

/** 
 * update_status($twitter, $tweet)
 *
 * Update status on twitter
 *
 * @par: $twitter, An object of Twitter class
 * @par: $tweet, The message to be posted to twitter
 *
 */
function update_status($twitter, $tweet)
{
        $result = $twitter->statusesUpdate($tweet);

        if ($result)
            echo '<div class="msg-ok">Status updated!</div>';
        else
            echo '<div class="msg-error">There was a problem and the status could not be updated!</div>';
}

/**
 * get_tweets($twitter, $username, $count)
 *
 * Get and echo tweets from user
 *
 * @par: $twitter, An object of Twitter class
 * @par: $username, The twitter username
 * @par: $count, The number of tweets to be retrieved
 *
 */
function get_tweets($twitter, $username, $count)
{

    $tweets = $twitter->statusesUserTimeline(null, null, null, null, $count);
    $image = $twitter->usersProfileImage($username);

    if ($tweets) {
        foreach ($tweets as $t) { ?>

            <div class="t-tweet clearfix">
                <img src="<?php echo $image; ?>" alt="avatar" />
                <p class="t-info"><strong><?php echo $username; ?></strong>, <?php echo date( "M d H:i", strtotime( $t['created_at'] ) ); ?></p>
                <p class="t-status"><?php echo $t['text']; ?></p>
            </div>

        <?php }
    }
    else
    {
        echo '<div class="msg-info mar-none">There are no tweets!</div>';
    }
}

?>