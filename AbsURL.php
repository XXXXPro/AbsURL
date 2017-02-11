<?php

/** ================================
 *  @package AbsURL
 *  @author 4X_Pro <admin@openproj.ru>
 *  @version 1.0
 *  @copyright 2017 4X_Pro, INTBPRO.RU
 *  Simple class for building absolute URL from relative and base URL.
 *  ================================ */

class AbsURL {
  /** @var string $default_scheme The scheme to be added to result URL if none specified neither is base URL nor in relative URL  **/
  public static $default_scheme = 'http';

/** Builds absolute URL from specified relative URL and base URL.
 *  The base URL must contain host name. Other components are optional.
 *  If scheme not specified neither in relative URL nor in base URL, $default_scheme class variable will be used.
 *  @param string $rel Relative URL
 *  @param string $base Base URL
 *  @return string Absolute URL, built by combining base and relative urls
 * **/
  public static function build($rel,$base) {
    $relp = parse_url($rel); // parts of relative url
    $basep = parse_url($base); // parts of base url
    $result = '';
    $prev_changed = false; // indicator whether the preious part of url was changed, if true, no latter parts of base will be used

    if (empty($basep['scheme'])) $basep['scheme']=$default_scheme;
    $scheme = !empty($relp['scheme']) ? $relp['scheme'] :  $basep['scheme'];
    if ($scheme)  $result.=$scheme.':';
    if (!empty($relp['host'])) {
      $host = $relp['host'];
      $prev_changed = true;
    }
    else $host=$basep['host'];
    if ($host) $result.='//';

    if (!empty($relp['user']) || !empty($basep['user'])) {
      $user = !empty($relp['user']) ? $relp['user'] : $basep['user'];
      $password = !empty($relp['password']) ? $relp['password'] :  $basep['password'];
      $result.=urlencode($user);
      if ($password) $result.=':'.urlencode($password);
      $result.='@';
    }

    $result.=$host;
    if (!empty($relp['port']) || !empty($basep['port'])) {
      $port = !empty($relp['port']) ? $relp['port'] :  $basep['port'];
      $result.=':'.$port;
    }

    if (!$prev_changed) {
      if (empty($basep['path'])) $basep['path']='/';
      if (empty($relp['path'])) $path=$basep['path'];
      elseif ($relp['path'][0]==='/') {
        $path=$relp['path'];
        $prev_changed = true;
      }
      else {
        $path=dirname($basep['path'].'.');
        if ($path!=='/' && $path!=='\\') $path.='/';
        $path.=$relp['path'];
        $prev_changed = true;
      }
      $result.=$path;
    }
    elseif (!empty($relp['path'])) $result.=$relp['path'];

    if (!empty($relp['query'])) {
      $result.='?'.$relp['query'];
      $prev_changed = true;
    }
    elseif (!$prev_changed && !empty($basep['query'])) $result.='?'.$basep['query'];

    if (!empty($relp['fragment'])) $result.='#'.$relp['fragment'];
    elseif (!$prev_changed && !empty($basep['fragment'])) $result.='#'.$basep['fragment'];

    return $result;
  }
}

AbsURL::build('all.min.css','http://xpro.su:83/skins/4xpro/');
