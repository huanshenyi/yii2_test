<?php
$form=\yii\bootstrap\ActiveForm::begin();
   echo $form->field($model,'name');
   echo $form->field($model,'sn');
   echo $form->field($model,'price');
   echo $form->field($model,'category_id')->dropDownList(\app\models\Goods::getCategoryOptions(),['prompt'=>'カテゴリの選んでください']);
   echo $form->field($model,'total');
   echo $form->field($model,'detail')->textarea();
echo \yii\bootstrap\Html::submitButton('提出',['class'=>'btn btn-info']);
 \yii\bootstrap\ActiveForm::end();
?>
