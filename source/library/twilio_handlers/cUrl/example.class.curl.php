<?php

include_once("class.curl.php") ;

//
// Create a new instance of the curl class and point it
// at the page to be fetched.
//

$c = new curl("http://www.csworks.com/resume/cv.shtml") ;

//
// By default, curl doesn't follow redirections and this
// page may or may not be available via redirection.
//

$c->setopt(CURLOPT_FOLLOWLOCATION, true) ;

//
// By default, the curl class expects to return data to
// the caller.
//

echo $c->exec() ;

//
// Check to see if there was an error and, if so, print
// the associated error message.
//

if ($theError = $c->hasError())
{
  echo $theError ;
}
//
// Done with the cURL, so get rid of the cURL related resources.
//

$c->close() ;
?>