<?php
// ApiSearch 


header('Content-type: application/json');

$post = array();
$post[] = $_POST['Test'];
$post[] = $_POST['Test2'];



echo json_encode( $post, JSON_PRETTY_PRINT );
exit;




























$array = array(
    
    'Status'    => 200,
    'Total'     => 200,
    'Results'   => array(
            array(
                'ID' => 200,
                'Title' => 'Test',
                'Etc' => 'Test',
                'MainThumb' => 'https://domain.com/uploads/image/2.jpg',                        
            )
    )        
);
header('Content-type: application/json');
echo json_encode( $array, JSON_PRETTY_PRINT );