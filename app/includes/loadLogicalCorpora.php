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

                $('#logicalCorpora').DataTable( {
                    ordering: true,
                    pageLength: 10
                } );                
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

                    try {
                        require_once ('class/class.TrDtsets.php');
                        $tl = new trdList();
                        $data = $tl ->getTrDtsets();
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
            ?>


            <div class="container-fluid">
                    <h3 style="color:#f03c02;text-align:left !important;">Train corpora: <button type="button" class="btn btn-primary btn-secondary" data-bs-toggle="modal" data-bs-target="#createmodal2">
                        Create new corpus
                    </button> </h3>
                    <hr></hr> 
            </div>
    
    <?php
    


                        
                        $table = '

                                <table id="logicalCorpora" class="table table-fit table-striped">       
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
                        
                        /*$table = $table . '<tr><td colspan="8"> 
                                                <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary"
                                                     data-toggle="modal" data-target="#mymodal" id="btncheck" value="Train selected models"  
                                                />
                                           </td></tr>
                                        ';
                        */
                        $table = $table . '                                
                                </tbody>
                            </table>
                                                          
                            <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary"
                            data-toggle="modal" data-target="#mymodal" id="btncheck" value="Train selected models"  
                       /><hr></hr> ';
                            ;

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
