<?php
  
  interface iCodeDesign {
    public static function Run();
    public static function Content($context);
  }

  interface iFile {
    public static function Create($file, $content, $cached);
    public static function HtmlTag($files, $options);
    public static function Cache($file, $switch);
    public static function Concat($files, $path, $cached);
    public static function Minify($file, $path, $cached);
  }
  
  interface iMoo {
    public static function Log($content, $console);
    public static function Debug($crazy_stuff, $die);
    public static function Message($path);
    public static function SandBox($sand);
    public static function DomainCheck($domain);
  }
  
  interface iLibrary {
    public static function Less($path);
    public static function CoffeeScript($path);
    public static function Markdown($path);
  }
  
?>