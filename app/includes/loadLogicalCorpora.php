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

            /*$('.check').change(function() {
                    $('#btncheck').prop("disabled", !this.checked);
            });*/

            /*$("#btncheck").click(function () { 
                let check_array = []; 
                $("input:checkbox[name=model]:checked").each(function() { 
                    check_array.push($(this).val()); 
                }); 

                $("#model-list").html (check_array.map(i => `<li style="list-style: none">${i}</li>`).join(''));
            }); */
            $("#btncheck").click(function () {

                //$("#labelModelName").html ($("input:checkbox:checked").attr("id"));   
                $("#labelModelName").html ($('.nameset:checked').val());
                $("#labelModelNameh").val ($('.nameset:checked').val());      
                
            });

        </script>
    </head>
    <body>    
    <?php

                        require_once ('class/class.TrDtsets.php');
                        $tl = new trdList();
                        $data = $tl ->getTrDtsets();
                        $listkeys = array_keys(reset ($data));
                        
                        $table = '
                                <table class="table table-striped">
                                   <form action="trainLogicalCorpora.php" method="post"
                                       <thead>
                                          <tr>                                    
                                ';
                        foreach ($listkeys as $value) {
                            if ($value <> 'Dtsets') {     
                                $table = $table . '<th scope="col">' . $value . '</th>';
                            }
                        }
                        $table = $table . '<th scope="col">' .'train' . '</th>';


                        $table = $table . '
                                </tr>
                            </thead>
                            <tbody>';
                        
                        $count = 0;

                        foreach ($data as $value) {
                            
                            $table = $table . '<tr>';
                            foreach ($listkeys as $key){
                                if ($key <> 'Dtsets') {                                    
                                    $table = $table . '<td>' . $value[$key] . '</td>';
                                }
                            } 

                            if ($count == 0){
                                $form = '                                
                                <input type="radio" name="dtset" checked class="check nameset" id="' . $value['name'] . '"  value="'. $value['name'] .'">
                                ';
                            }else{
                                $form = '                                
                                <input type="radio" name="dtset"  class="check nameset" id="' . $value['name'] . '"  value="'. $value['name'] .'">
                                ';                                
                            }
                            $count++;
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        $table = $table . '</tr>';
                        #$table = $table . '<tr><td colspan="8"> <a href="#" onclick="this.parentNode.submit();"> Entrenar</a></td></tr>';
                        
                        $table = $table . '<tr><td colspan="8"> 
                                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary"
                                                     data-toggle="modal" data-target="#mymodal" id="btncheck" value="Train selected models"  
                                                />
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Train parameters</h5>

                </div>
                    <form action="trainLogicalCorpora.php" method="post">
                        <div class="form-group">                            
                            <div class="modal-body" id="modal-data">
                                <div class="row">
                                    <div class="col">
                                        <label for="inputState">Model:</label>
                                    </div>
                                    <div class="col">
                                        <label  id="labelModelName" for="inputState">Model:</label>                                        
                                        <input id="labelModelNameh" name="modelName" type="hidden"  value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="inputState">Description:</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="description" id="description" value="Example" required>
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col">
                                            <label for="inputState">Visibility:</label>
                                        </div>
                                        <div class="col">
                                            <select name="visibility" id="inputState" class="form-control">
                                                                            <option selected>Public</option>
                                                                            <option>Private</option>
                                            </select>

                                </div>


                                <div class="row">
                                        <div class="col">
                                            <label for="inputState">Algorithm type:</label>
                                        </div>
                                        <div class="col">
                                            <select name="AlgType" id="inputState" class="form-control">
                                                                            <option selected>mallet</option>
                                                                            <option>prodlda</option>
                                                                            <option>ctm</option>
                                                                            <option>bertopic</option>
                                            </select>

                                </div>

                                <div class="row">
                                        <div class="col">
                                        <label for="inputState">Number of topics:</label>
                                        </div>
                                        <div class="col">
                                            <input name="numTopics" type="range" value="50" min="1" max="500" oninput="this.nextElementSibling.value = this.value">
                                            <output  >50</output>
                                        </div>
                                </div>      
                                
                                
                                <div class="row">
                                        <div class="col">
                                            <label for="inputState">Wordlist:</label>
                                        </div>
                                        <div class="col">
                                            <?php
                                                    require_once ('class/class.wordLists.php');
                                                    $wl = new wordList();
                                                    $wordlist = $wl ->getWordList();
                                                    #echo ('<select id="wordList" class="form-control">');
                                                    echo ('<div id="listwl"  class="form-check wlcheck">');
                                                    $count = 0;
                                                    foreach ($wordlist as $value) {                                                        
                                                        if ($count==0) {
                                                            echo ('<input name="wordlist[]" class="form-check-input"  type="checkbox" checked id="'. $value['path'] .'" name ="' . $value['path']. '" value="' .$value['path'] . '">' );
                                                            $count = 1;
                                                        } else{
                                                            echo ('<input name="wordlist[]"  class="form-check-input"  type="checkbox" id="'. $value['path'] .'" name ="' . $value['path']. '" value="' .$value['path'] . '">' );
                                                        }
                                                        echo ('<label class="form-check-label"  for="flexCheckChecked" >' . $value['name'] . '</label><br>');
                                                    }
                                                    echo ('</div>');                                                
                                            ?>
                                        </div>
                                </div>

                                <div class="row">
                                        <div class="col">
                                            <label for="inputState">Equivalences:</label>
                                        </div>
                                        <div class="col">
                                            <?php

                                                    $wordlist = $wl ->getEquivalnces();
                                                    #echo ('<select id="wordList" class="form-control">');
                                                    echo ('<div id"listeq" class="form-check">');
                                                    $count = 0;
                                                    foreach ($wordlist as $value) {
                                                        if ($count ==0 ) {
                                                            echo ('<input name="eqlist[]" class="form-check-input" checked type="checkbox"  id="'. $value['path'] .'" name ="' . $value['path']. '" value="' .$value['path'] . '">' );
                                                            $count = 1;
                                                        }else {
                                                            echo ('<input name="eqlist[]" class="form-check-input"  type="checkbox"  id="'. $value['path'] .'" name ="' . $value['path']. '" value="' .$value['path'] . '">' );
                                                        }
                                                        echo ('<label class="form-check-label"  for="flexCheckChecked" >' . $value['name'] . '</label><br>');
                                                    }
                                                    echo ('</div>');                                                
                                            ?>
                                        </div>
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
