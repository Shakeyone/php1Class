<?php

function displayFormElements(array $questions, array $results = array()){
    $elements = array();
    $j =0;
    foreach($questions as $questionNumber => $questionProperties):?>
        <div class="form-group m-3">
            <p class="<?=empty($results[$j])&&!empty($results)?'text-danger':'';?>"><?=$questionProperties['question'];?></p>
            <?php if($questionProperties['type'] == 'checkbox'):?>
                <?php $i = 0;
                foreach ($questionProperties['choices'] as $value => $label): ?>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?=$value ?>" name="<?=$questionNumber?>[]" id="<?=$questionNumber?><?=$value?>"
                        <?=(isset($_POST[$questionNumber])&& in_array($value, $_POST[$questionNumber])) ? "checked": "";?>>
                        <label class="form-check-label" for="<?=$questionNumber;echo$value;?>"><?=$label?></label>
                    </div>
                <?php $i++;
                endforeach;
            elseif($questionProperties['type'] == 'radio'): 
                foreach ($questionProperties['choices'] as $value => $label):?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="<?=$value?>" name="<?=$questionNumber?>" id="<?=$questionNumber?><?=$value?>"
                        <?=(isset($_POST[$questionNumber]) && $_POST[$questionNumber] == $value) ? "checked": "";?>>
                        <label class="form-check-label" for="<?=$questionNumber;echo$value;?>"><?=$label?></label>
                    </div>
                <?php endforeach;
            endif;?>
        </div>
    <?php $j++; endforeach;
    return $elements;
}

function calcResults(array $questions){
    $results = array();
    if(!empty($_POST)){
        $i = 0;
        foreach($_POST as $index =>$answer){
            if(gettype($answer) == 'array'){
                // echo $index. ' => ';
                $theAnswer = implode(', ', $answer);
            }else{
                // echo $index. ' => ';
                $theAnswer = $answer;
            }
            // echo ' => ';
            $answerGiven = ((gettype($questions[$i]['answer'])=='array') ? (implode($questions[$i]['answer'], ', ')) : ($questions[$i]['answer']));
            // echo  '<br>';
            $results[$i] = $theAnswer == $answerGiven;
            $i++;
        }
    }
    return $results;
}
