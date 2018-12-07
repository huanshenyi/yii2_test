<div class="container">
<?=\yii\bootstrap\Html::a('Excel出力',['user-excel/excel'],['class'=>'btn btn-sm btn-info'])?>

<?=\yii\bootstrap\Html::a('クラス学年分類してExcel出力',['user-excel/excel1'],['class'=>'btn btn-sm btn-success'])?>

    <?= \yii\bootstrap\Html::a('Excel画像やスタールテキスト出力',['user-excel/excel-img'],['class'=>'btn btn-sm btn-primary'])?>
    <?= \yii\bootstrap\Html::a('グラフExcel出力',['user-excel/graph'],['class'=>'btn btn-sm btn-info'])?>
    <table class="table">
    <tr>
        <th>名前</th>
        <th>点数</th>
        <th>クラス</th>
        <th>学年</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <th><?= $model->username?></th>
        <th><?= $model->score?></th>
        <th><?= $model->class?></th>
        <th><?= $model->grade?></th>
        <td><?=\yii\bootstrap\Html::a('修正',['user-excel/edit','id'=>$model->id],['class'=>'btn btn-sm btn-warning'])?></td>
    </tr>
    <?php endforeach;?>
</table>
    </div>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pages,
])?>


