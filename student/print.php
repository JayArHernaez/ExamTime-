<?php
    require('phpToPDF.php');

    //Your HTML in a variable
    $my_html="<HTML><h2>PDF from HTML using phpToPDF</h2></HTML>";

    //Set Your Options -- we are saving the PDF as 'my_filename.pdf' to a 'my_pdfs' folder
    $pdf_options = array(
      "source_type" => 'html',
      "source" => $my_html,
      "action" => 'save',
      "save_directory" => 'my_pdfs',
      "file_name" => 'my_filename.pdf');

    //Code to generate PDF file from options above
    phptopdf($pdf_options);
?>