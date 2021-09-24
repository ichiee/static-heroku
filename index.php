<?php 

/**
 * Testing env for any header send back to the client and also show what has been done on the HTML
 **/

/**
 * Functions
 **/

function html_header($title) {
  $output  = '';
  $output .= '<html>';
  $output .= '<head>';
  $output .= '<title>Title | '. $title .'</title>';
  $output .= '</head>';
  $output .= '<body>';
  return $output;
}
function html_footer() {
  $output  = '';
  $output .= '</body>';
  $output .= '</html>';
  return $output;
}

function contents($title) {
  $output  = '';
  $output .= '<h1>'. $title .'</h1>';
  $output .= '<p>Lorem ipsum</p>';
  return $output;
}

/**
 * Main
 */
 
// add url to locall variable
$url = $_SERVER['REQUEST_URI'];

//
if ('/' == $url) {
  // adding response header https://www.php.net/manual/en/function.header.php
  header("x-header-name: header-value");
  print html_header('Welcome');
  print contents('Main page');
  print html_footer();
}
else if (preg_match("@^/page/([^/]*)@", $url, $matches)) {
  // showing the page directory
  $page = $matches[1];
  header("x-header-name: header-value");
  print html_header('Page: '.$page);
  print contents('Page '. $page);
  print html_footer();
}
else if (preg_match("@^/status-check/([^/]*)@", $url, $matches)) {
  $page = $matches[1];

  if ($page < 100) {
    // Status != 200: FULL
    header("HTTP/1.1 403 Forbidden");
  }
  else if ($page == 503) {
     header("HTTP/1.1 503 Service Unavailable");
  }
  else {
    // Status 200
    header("HTTP/1.1 200 OK");
    header("x-200-status: another-value");
    header("x-paywall-location: /secret/db/$page");
  }
  header("x-page: $page");
}

// add anything else

?>
