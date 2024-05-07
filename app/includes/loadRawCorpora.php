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



                        require_once ('class/class.rawCorpora.php');
                        $rc = new rawCorpora ();
                        $data = $rc ->getrawCorpora();
                        $listkeys = array_keys(reset ($data));

                        $table = '
                        <form action="../createLogicalCorpora.php" method="post">
                            <div class="container-fluid">
                                    <h3 style="color:#f03c02;text-align:left !important;">Corpora data:</h3>
                                    <hr></hr> 
                                    <div class="row">
                                    <div class="col-md-auto"><label>Name</label></div>
                                    <div class="col col-lg2"><input type="text" class="form-control" id="NameLbl" placeholder="Name" name="name" value="Name" required></div>
                                    <div class="col-md-auto"><label for>Description</label></div>
                                        <div class="col col-lg6"><textarea class="form-control" name="description" rows="3" cols="50" required></textarea></div>
                                    <div class="col-md-auto"><label>Private</label></div>
                                    <div class="col-md-auto"><input type="checkbox" class="check" name="private"></div>
                                    </div>
                          </div>
                          <div class="container-fluid">
                                <h3 style="color:#f03c02; text-align:left !important;">Corpus to be included:</h3>
                                <hr></hr>                         
                                <table class="table table-striped">                                   
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
                            
                            $form = '
                                        <input type="checkbox" class="check" name="model[]" value="'. $value['name'] .'">
                                    ';
                            
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        $table = $table . '</tr>';
                        #$table = $table . '<tr><td colspan="8"> <a href="#" onclick="this.parentNode.submit();"> Entrenar</a></td></tr>';
                        
                        $table = $table . '<tr><td colspan="8">                                                 
                                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary" id="btncheck" value="Create logical corpus" disabled />

                                           </td></tr>
                                        ';

                        $table = $table . '                                
                                </tbody>

                            </table></form></div>';

                        echo $table;                        


    ?>

                
    </body>
</html>