<?php include 'session.php';?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../assets/css/spinner.css" rel="stylesheet">
        <script>
            $(document).ready(function(){

                $('#loader2').hide();
                $('#loadercont2').hide();
                $('#shownumber').hide();                

                $('#listModels').DataTable( {
                    ordering: true,
                    pageLength: 10
                } );

            });

            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    </head>
    <body>    

    <div class="container-fluid">
                <div class="row">
                    <div class="col-sm">
                        <h3 style="color:#f03c02;text-align:left !important;">View models:</h3>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    <a href="trainNewModel.php" class="btn  btn-secondary" role="button">Train new model</a>

                    </div>
                </div>        
            </div>
            <hr></hr> 
            
            <?php



                        $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/manageModels.py --listTMmodels --path_TMmodels '. $_SESSION['path_TMmodels'] . ' 2>&1');
                        $data = json_decode ( $data, true);                        

                        $listkeys = array_keys(reset ($data));


                        /*borramos dos columnas que no aportan información al usuario*/
                        if (($key = array_search('htm-version', $listkeys)) !== false) {
                            unset($listkeys[$key]);
                        }
                        if (($key = array_search('hierarchy-level', $listkeys)) !== false) {
                            unset($listkeys[$key]);
                        }


                        
                        $table = '
                                <table id="listModels" class="table table-fit table-striped ">                                    
                                        <thead>
                                            <tr>                                    
                                ';
                        foreach ($listkeys as $value) {
                            $table = $table . '<th scope="col">' . $value . '</th>';
                        }



                        $table = $table . '<th>View</th>
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
                            #$table = $table . '<td><input type="radio" name="dtset" checked class="check nameset" id="' . $value['name'] . '"  value="'. $value['name'] .'"></td>';
                            $table = $table . '</tr>';
                        }
                        
                        $table = $table . ' 
                                    </tbody>
                            </table>
                            <hr></hr> ';                            

                        echo $table;


    ?>








    </body>
</html>