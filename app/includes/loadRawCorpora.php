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



                        $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/manageCorpus/manageCorpus.py --listDownloaded --path_downloaded '. $_SESSION['path_downloaded'] . ' 2>&1');
                        
                        $data = json_decode ( $data, true);

                        $listkeys = array_keys(reset ($data));
                        
                        $table = '
                                <table class="table table-striped">
                                   <form action="trainRawCorpora.php" method="post"
                                       <thead>
                                          <tr>                                    
                                ';
                        foreach ($listkeys as $value) {
                            $table = $table . '<th scope="col">' . $value . '</th>';
                        }
                        $table = $table . '<th scope="col">' .'train' . '</th>';


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
                                        <input type="hidden" id="model" name="model" value="'. $value['name']  .'">
                                        <input type="checkbox" class="check" id="train" name="model" value="'. $value['name'] .'">
                                    ';
                            
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        $table = $table . '</tr>';
                        #$table = $table . '<tr><td colspan="8"> <a href="#" onclick="this.parentNode.submit();"> Entrenar</a></td></tr>';
                        
                        $table = $table . '<tr><td colspan="8">                                                 
                                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary" data-toggle="modal" data-target="#mymodal" id="btncheck" value="Train selected models" disabled />
                                           </td></tr>
                                        ';

                        $table = $table . '                                
                                </tbody>
                              </form>
                            </table>';

                        echo $table;


    ?>

            <!-- Modal -->
            <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Train models</h5>

                </div>
                    <form action="trainRawCorpora.php" method="post">
                        <div class="form-group">                            
                            <div class="modal-body" id="modal-data">
                                <h3 class="modal-title" id="exampleModalLongTitle">Selected models:</h5>
                                <hr>
                                <ul class="list-group modal-list" id="model-list"></ul>
                                <hr>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Algorithm type:</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>mallet</option>
                                        <option>prodlda</option>
                                        <option>ctm</option>
                                        <option>bertopic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Train</button>
                            </div>
                    </form>
                </div>
            </div>
            </div>
                
    </body>
</html>