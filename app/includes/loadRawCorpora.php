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

                /*let table = new DataTable('#rawCorpora') {
                    ordering: false
                };*/

                $('#rawCorpora').DataTable( {
                    ordering: true,
                    pageLength: 10,
                    responsive: true,
                    columnDefs: [
                            { responsivePriority: 1, targets: -1 },
                            { responsivePriority: 2, targets: 0 }
                    ]      
                } );

            });


            $('.check').change(function() {
                    $('#btncheck').prop("disabled", !this.checked);
            });

            $("#btncheck").click(function () { 
                let check_array = []; 
                $("input:checkbox[name=model]:checked").each(function() { 
                    check_array.push($(this).val()); 
                }); 
                $("#model-list").html (check_array.map(i => `<li style="list-style: none">${i}</li>`).join(''));
            }); 

        </script>
    </head>
    <body>    

    <?php

                        try {
                            require_once ('class/class.rawCorpora.php');
                            $rc = new rawCorpora ();
                            $data = $rc ->getrawCorpora();
                            $listkeys = array_keys(reset ($data));

                        } catch (TypeError $ex) {
                            echo '
                                    <div class="alert alert-danger" role="alert">
                                            Error loading Corpora. Please contact the administrator.<br>
                                            '  . $ex -> getMessage() . '
                                    </div>
                            ';
                            $data = array();
                            $listkeys = array();
                            exit();
                        }


                        


                        if (isset ($_SESSION['rcname'])) {
                            echo '
                                <div class="alert alert-success" role="alert">
                                    Let\'s create a corpus with the name "'. $_SESSION['rcname'] .  '". Select the corpus to be included.
                            </div>
                            ';
                        }

                        if (isset ($_SESSION['rcname'])) {
                                $table = '
                                <form action="../createLogicalCorpora.php" method="post">
                                    <div style="display:none;" class="container-fluid">
                                            <h3 style="color:#f03c02;text-align:left !important;">Corpora data:</h3>
                                            <hr></hr> 
                                            <div class="row">
                                            <div class="col-md-auto"><label>Name</label></div>
                                            <div class="col col-lg2"><input type="text" class="form-control" id="NameLbl" placeholder="Name" name="name" value="' . $_SESSION['rcname'] .  ' " required></div>
                                            <div class="col-md-auto"><label for>Description</label></div>
                                                <div class="col col-lg6"><textarea class="form-control" name="description" rows="3" cols="50" required>'. $_SESSION['rcdescription']. '</textarea></div>
                                            <div class="col-md-auto"><label>Private</label></div>
                                ';

                                if (  ($_SESSION['rcprivate'])==1 ) {
                                    $table = $table . '
                                            <div class="col-md-auto"><input type="checkbox"  name="private" checked></div>
                                            </div>
                                        </div>';
                                }else {
                                    $table = $table . '
                                            <div class="col-md-auto"><input type="checkbox" name="private"></div>
                                            </div>
                                        </div>';
                                }

                                /*unset ($_SESSION['rcprivate']);
                                unset ($_SESSION['rcname']);
                                unset ($_SESSION['rcdescription']);*/
                        }else {
                            $table = '';
                        }

                        $table = $table . '
                          <div class="container-fluid">
                                <h3 style="color:#f03c02; text-align:left !important;">Corpus to be included:</h3>
                                <hr></hr>                         
                                <table id="rawCorpora" class="table-striped table table-bordered table-hover nowrap" style="width:100%">                             
                                       <thead>
                                          <tr>                                    
                        ';
                        foreach ($listkeys as $value) {
                            $table = $table . '<th scope="col">' . $value . '</th>';
                        }
                        
                        $table = $table . '<th scope="col">' .'' . '</th>';


                        $table = $table . '
                                </tr>
                            </thead>
                            <tbody>';

                        foreach ($data as $value) {
                            $table = $table . '<tr>';
                            foreach ($listkeys as $key){
                                if ($key == 'schema') {
                                    $table = $table . '<td>' . implode( ',',$value[$key]) . '</td>';
                                }else {
                                    $table = $table . '<td>' . $value[$key] . '</td>';
                                }
                            } 
                            if (isset ($_SESSION['rcname'])) {
                                $form = '
                                            
                                            <input type="checkbox" class="check" name="model[]" value="'. $value['name'] .'">
                                        ';
                            }else {
                                $form = '';
                            }
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        $table = $table . '</tr>';
                        #$table = $table . '<tr><td colspan="8"> <a href="#" onclick="this.parentNode.submit();"> Entrenar</a></td></tr>';
                        
                       /* $table = $table . '<tr><td colspan="8">                                                 
                                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary" id="btncheck" value="Create logical corpus" disabled />

                                           </td></tr>
                                        ';
                        */
                        $table = $table . '                                
                                </tbody>

                            </table>';
                        if (isset ($_SESSION['rcname'])) {
                            $table = $table . '
                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary" id="btncheck" value="Create logical corpus" disabled />
                                </form></div>';
                        }else{
                            $table = $table . '</div>';
                        }

                        echo $table;                        
                        unset ($_SESSION['rcname']);


    ?>

                
    </body>
</html>