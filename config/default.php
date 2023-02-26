<?php
return array (
  'debug' => true,
  'plugins' => 
  array (
    'Bake' => '/home/coull/Sites/rhino/vendor/cakephp/bake/',
    'Cake/TwigView' => '/home/coull/Sites/rhino/vendor/cakephp/twig-view/',
    'DebugKit' => '/home/coull/Sites/rhino/vendor/cakephp/debug_kit/',
    'Migrations' => '/home/coull/Sites/rhino/vendor/cakephp/migrations/',
  ),
  'App' => 
  array (
    'namespace' => 'App',
    'encoding' => 'UTF-8',
    'defaultLocale' => 'en_US',
    'defaultTimezone' => 'UTC',
    'base' => false,
    'dir' => 'src',
    'webroot' => 'webroot',
    'wwwRoot' => '/home/coull/Sites/rhino/webroot/',
    'fullBaseUrl' => 'http://rhino.localhost',
    'imageBaseUrl' => 'img/',
    'cssBaseUrl' => 'css/',
    'jsBaseUrl' => 'js/',
    'paths' => 
    array (
      'plugins' => 
      array (
        0 => '/home/coull/Sites/rhino/plugins/',
      ),
      'templates' => 
      array (
        0 => '/home/coull/Sites/rhino/templates/',
      ),
      'locales' => 
      array (
        0 => '/home/coull/Sites/rhino/resources/locales/',
      ),
    ),
  ),
  'Security' => 
  array (
  ),
  'Asset' => 
  array (
  ),
  'Error' => 
  array (
    'errorLevel' => 32767,
    'skipLog' => 
    array (
    ),
    'log' => true,
    'trace' => true,
    'ignoredDeprecationPaths' => 
    array (
    ),
  ),
  'Debugger' => 
  array (
    'editor' => 'phpstorm',
  ),
  'Session' => 
  array (
    'defaults' => 'php',
  ),
);