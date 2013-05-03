<?php
  
//  CodeDesign( array(
//    'output' => 'styles/application.css',
//    'list'   => array(
//      'styles/application.scss'
//    )
//  ));

  function CodeDesign( $array ) {
    $output = '';
      if ( array_values( $array ) === $array ) {
        foreach ( $array as $key ) {
          $output .= ( new File( $key['output'], $key['list'], Settings::get() ) );
        }
      } else {
        $output = ( new File( $array['output'], $array['list'], Settings::get() ) );
      }
    echo $output;
  }
?> 