<?php 

  function Content() {
    $args = func_get_args();
    $output = "";
    
      if (!empty(CodeDesign::$content_folder)) {
        foreach ($args as $key => $value) {
          Moo::Sandbox(
            $output .= Library::Markdown(CodeDesign::$content_folder.$value)
          );
        }
      } else {
        $output = "Missing Content Folder.";
      }
      
    echo $output;
  }
?>