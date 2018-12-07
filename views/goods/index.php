<?=\yii\bootstrap\Html::a('商品挿入',['goods/add'],['class'=>'btn btn-sm btn-success'])?>
<?=\yii\bootstrap\Html::a('Excel出力',['goods/test2'],['class'=>'btn btn-sm btn-info'])?>
<table class="table">
  <tr>
    <th>ID</th>
    <th>名前</th>
    <th>sn</th>
    <th>値段</th>
    <th>商品分類</th>
    <th>在庫</th>
    <th>挿入時間</th>
    <th>修正</th>
  </tr>
  <?php foreach ($models as $model): ?>
    <tr>
      <td><?=$model->id?></td>
      <td><?=$model->name?></td>
      <td><?=$model->sn?></td>
      <td><?=$model->price?></td>
      <td><?=$model->category->name?></td>
      <td><?=$model->total?></td>
      <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
      <td><?=\yii\bootstrap\Html::a('修正',['goods/edit','id'=>$model->id],['class'=>'btn btn-sm btn-success'])?></td>
    </tr>
  <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pages,
])?>
