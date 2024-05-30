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

            $('.check').change(function() {
                    $('#btncheck').prop("disabled", !this.checked);
            });
        </script>
    </head>
    <body>

   
    <?php

                        function printTable ($data) {
                            $listkeys = array_keys(reset ($data));
                        
                            $table = '                                    
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
                                    if ($key == 'wordlist') {
                                        $table = $table . '<td>' . implode( ',',array_slice($value[$key], 0, 3)) . '... </td>';
                                    }else {
                                        $table = $table . '<td>' . $value[$key] . '</td>';
                                    }
                                } 
                                
                                
                                $form = '
                                        <form action="viewWordList.php" method="post">
                                            <input type="hidden" id="wl" name="wlist" value="'. $value['name']  .'">
                                            <!-- Button trigger modal -->
                                            <input class="btn btn-link" type="submit" value="View/Edit">
                                        </form>
                                        ';
                                

                    
                                #$form = '';
                                $table = $table . '<td>'. $form. '</td>';
                                $table = $table . '</tr>';
                            }
                            $table = $table . '</tr>';
                            
                            
    
                            $table = $table . '                                
                                    </tbody>                                  
                                </table>';
    
                            return $table;                            

                        }
                        require_once ('class/class.wordLists.php');
                        $wl = new wordList();
                        #$data = $wl ->getRawData();
                        $data = $wl ->getWordListComplete();
                        echo ('
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Wordlists (' . count($data) . 'items) :
                                        </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">'
                        );
                        echo printTable ($data);
                                                
                        echo ('
                                            </div>
                                        </div>
                                    </div>');
                        $data = $wl ->getEquivalncesComplete();

                            echo ('
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo ">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Equivalences (' . count($data) . 'items) :
                                    </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">'
                            );     
                            echo printTable ($data);                       
                            echo ('
                            </div>
                        </div>
                    </div>
                    </div>');

    ?>




    </body>
</html>