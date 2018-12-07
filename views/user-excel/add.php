<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'score');
echo $form->field($model,'class');
echo $form->field($model,'grade');
echo \yii\bootstrap\Html::submitButton('提出',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>