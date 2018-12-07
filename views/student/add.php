<form method="post">
 名前:<input type='text' name='name'><br>
 年齢:<input type='text' name='age'><br>
 <input type='submit' value='提出'>
 <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
</form>
