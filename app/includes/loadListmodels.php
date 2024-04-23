<?php include 'session.php';?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../assets/css/spinner.css" rel="stylesheet">
        <script src="../assets/vendor/jquery/jquery.min.js"></script>
        <script>
            $(document).ready(function(){

                $('#loader2').hide();
                $('#loadercont2').hide();
                $('#shownumber').hide();                
            });

            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    </head>
    <body>    
    <?php



                        $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/manageModels.py --listTMmodels --path_TMmodels '. $_SESSION['path_TMmodels'] . ' 2>&1');
                        $data = json_decode ( $data, true);                        


                        $listkeys = array_keys(reset ($data));

                        
                        $table = '
                                <table class="table table-striped">                                    
                                        <thead>
                                            <tr>                                    
                                ';
                        foreach ($listkeys as $value) {
                            $table = $table . '<th scope="col">' . $value . '</th>';
                        }



                        $table = $table . '
                                </tr>
                            </thead>
                            <tbody>';

                        foreach ($data as $value) {
                            $table = $table . '<tr>';
                            foreach ($listkeys as $key){
                                if ($key == 'TrDtSet') {
                                    $lastNCharacters = substr($value[$key], -20);
                                    $table = $table . '<td><p data-toggle="tooltip" data-placement="top" 
                                                            title=' . $value[$key] . '><u style="text-decoration-color: blue">' 
                                                     . $lastNCharacters . '</u></p></td>';
                                } else {
                                    $table = $table . '<td>' . $value[$key] . '</td>';
                                }                                
                            } 
                            $form = '<form action="viewModel.php" method="post">
                                        <input type="hidden" name="model" value="'. $value['name']  .'">
                                        <input type="hidden" name="description" value="'. $value['description']  .'">
                                        <input type="hidden" name="creation_date" value="'. $value['creation_date']  .'">
                                        <input type="hidden" name="trdtset" value="'. $value['TrDtSet']  .'">
                                        <button type="submit" class="btn btn-link" name="submit" value="View" >View</button>
                                    </form>
                                    ';
                            
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        
                        $table = $table . ' 
                                    </tbody>
                            </table>';

                        echo $table;


    ?>







    </body>
</html>