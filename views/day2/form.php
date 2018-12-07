<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'password')->passwordInput();
//radiolist 一個選択
echo $form->field($model,'sex',['inline'=>1])->radiolist([1=>'男性',2=>'女性',3=>'非公開']);

echo $form->field($model,'city')->dropDownList(['1'=>'東京','2'=>'大阪市','3'=>'那覇']);
echo $form->field($model,'hobby')->checkboxList(['散歩','ゲーム','何でもしない']);
echo $form->field($model,'intro')->textarea(['rowa'=>5]);
echo \yii\bootstrap\Html::submitButton('提出',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

