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




                        require_once ('class/class.wordLists.php');
                        $wl = new wordList();
                        $data = $wl ->getRawData();

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
                                if ($key == 'wordlist') {
                                    $table = $table . '<td>' . implode( ',',array_slice($value[$key], 0, 3)) . '... </td>';
                                }else {
                                    $table = $table . '<td>' . $value[$key] . '</td>';
                                }
                            } 
                            
                            $form = '
                                        <input type="hidden" id="model" name="model" value="'. $value['name']  .'">
                                        <input type="checkbox" class="check" id="train" name="model" value="'. '' .'">
                                    ';
                            
                            
                            $table = $table . '<td>'. $form. '</td>';
                            $table = $table . '</tr>';
                        }
                        $table = $table . '</tr>';
                        #$table = $table . '<tr><td colspan="8"> <a href="#" onclick="this.parentNode.submit();"> Entrenar</a></td></tr>';
                        
                        $table = $table . '<tr><td colspan="8"> 
                                                <input type="submit" name="anmelden" class="button" id="btncheck" value="Train selected models" disabled />
                                           </td></tr>
                                        ';

                        $table = $table . '                                
                                </tbody>
                              </form>
                            </table>';

                        echo $table;


    ?>
                
    </body>
</html>