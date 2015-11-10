<?php

$my_site_path = "http://localhost:8888/furrows";

function middleware($cb_or_path = null) {

  static $cb_map = array();

  if ($cb_or_path == null || is_string($cb_or_path)) {
    foreach ($cb_map as $cb) {
      call_user_func($cb, $cb_or_path);
    }
  } else {
    array_push($cb_map, $cb_or_path);
  }
}

function route_to_regex($route) {
  $route = preg_replace_callback('@:[\w]+@i', function ($matches) {
    $token = str_replace(':', '', $matches[0]);
    return '(?P<'.$token.'>[a-z0-9_\0-\.]+)';
  }, $route);
  return '@^'.rtrim($route, '/').'$@i';
}

function route($method, $pattern, $callback = null) {

  // callback map by request type
  static $route_map = array(
    'GET' => array(),
    'POST' => array()
  );

  $method = strtoupper($method);

  if (!in_array($method, array('GET', 'POST')))
    error(500, 'Only GET and POST are supported');

  // a callback was passed, so we create a route defiition
  if ($callback !== null) {

    // create a route entry for this pattern
    $route_map[$method][$pattern] = array(
      'xp' => route_to_regex($pattern),
      'cb' => $callback
    );

  } else {


    // callback is null, so this is a route invokation. look up the callback.
    foreach ($route_map[$method] as $pat => $obj) {

      // if the requested uri ($pat) has a matching route, let's invoke the cb
      if (!preg_match($obj['xp'], $pattern, $vals))
        continue;

      // call middleware
      middleware($pattern);

      // construct the params for the callback
      array_shift($vals);
      preg_match_all('@:([\w]+)@', $pat, $keys, PREG_PATTERN_ORDER);
      $keys = array_shift($keys);
      $argv = array();

      foreach ($keys as $index => $id) {
        $id = substr($id, 1);
        if (isset($vals[$id])) {
          array_push($argv, trim(urldecode($vals[$id])));
        }
      }

      // call filters if we have symbols
      if (count($keys)) {
        filter(array_values($keys), $vals);
      }

      // if cb found, invoke it
      if (is_callable($obj['cb'])) {
        call_user_func_array($obj['cb'], $argv);
      }

      // leave after first match
      break;

    }
  }


}

function get($path, $cb) {
  route('GET', $path, $cb);
}

function post($path, $cb) {
  route('POST', $path, $cb);
}

function dispatch() {

  $path = $_SERVER['REQUEST_URI'];
  
  //if (config('site.url') !== null)
    $path = preg_replace('@^'.preg_quote(site_path()).'@', '', $path);

  $parts = preg_split('/\?/', $path, -1, PREG_SPLIT_NO_EMPTY);

  $uri = trim($parts[0], '/');

  if($uri == 'index.php' || $uri == ''){
    $uri = 'index';
  }

  route(method(), "/{$uri}");
}

function method($verb = null) {

  if ($verb == null || (strtoupper($verb) == strtoupper($_SERVER['REQUEST_METHOD'])))
    return strtoupper($_SERVER['REQUEST_METHOD']);

  error(400, 'bad request');
}


function error($code, $message) {
  @header("HTTP/1.0 {$code} {$message}", true, $code);
  die($message);
}

function site_path(){
  static $_path;
var_dump($my_site_path);exit;
  if ($my_site_path == null)
      error(500, '[site.url] is not set');
  
  if (!$_path)
    $_path = rtrim(parse_url($my_site_path, PHP_URL_PATH),'/');
  
  return $_path;
}

?>