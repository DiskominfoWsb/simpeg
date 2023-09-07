<?php
Excel::create('Filename', function($excel) {

    // Set the title
    $excel->setTitle('Our new awesome title');

    // Chain the setters
    $excel->setCreator('Maatwebsite')
          ->setCompany('Maatwebsite');

    // Call them separately
    $excel->setDescription('A demonstration to change the file properties');
    $excel->sheet('Sheetname', function($sheet) {

        // Sheet manipulation
        // Manipulate first row
        $sheet->row(1, array(
             'test1', 'test2'
        ));

        // Manipulate 2nd row
        $sheet->row(2, array(
            'test3', 'test4'
        ));
    });
})->download('xls');