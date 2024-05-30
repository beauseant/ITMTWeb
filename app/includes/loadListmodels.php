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
                    <h3 style="color:#f03c02;text-align:left !important;">View models: <button type="button" class="btn btn-primary btn-secondary" data-bs-toggle="modal" data-bs-target="#createmodal2">
                        Create new model
                    </button> </h3>
                    <hr></hr> 
            </div>
            
            
    <?php



                        $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/manageModels.py --listTMmodels --path_TMmodels '. $_SESSION['path_TMmodels'] . ' 2>&1');
                        $data = json_decode ( $data, true);                        


                        $listkeys = array_keys(reset ($data));

                        
                        $table = '
                                <table id="listModels" class="table table-striped">                                    
                                        <thead>
                                            <tr>                                    
                                ';
                        foreach ($listkeys as $value) {
                            $table = $table . '<th scope="col">' . $value . '</th>';
                        }



                        $table = $table . '<th>View</th>
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


          <!-- Modal -->
          <div class="modal fade" id="createmodal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create corpora</h5>
                </div>
                <form action="../listRawCorpora.php" method="post">
                <div class="modal-body">
                            <h3 style="color:#f03c02;text-align:left !important;">Corpora data:</h3>
                            <hr></hr> 
                            <div class="container">
                                <div class="row">
                                    <div class="col"><label>Name:</label></div>
                                    <div class="col col-lg6"><input type="text" class="form-control" id="NameLbl" placeholder="Name" name="name" value="Name" required></div>
                                </div>
                                <div class="row">
                                    <div class="col"><label for>Description:</label></div>
                                    <div class="col col-lg6"><textarea class="form-control" name="description" rows="3" cols="50" required></textarea></div>
                                </div>
                                <div class="row">
                                    <div class="col"><label>Private:</label></div>
                                    <div class="col col-lg6"><input type="checkbox" class="check" name="private"></div>
                                </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
                </form>
                </div>
            </div>
            </div>






    </body>
</html>