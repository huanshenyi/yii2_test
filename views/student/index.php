<table class="table table-bordered table-condensed">
  <tr>
    <th>Id</th>
    <th>名前</th>
    <th>年齢</th>
    <th>操作</th>
  </tr>
  <?php foreach($students as $student):?>
    <tr>
      <td><?=$student->id ?></td>
      <td><?=$student->name ?></td>
      <td><?=$student->age ?></td>
      <td>修正　削除</td>
    </tr>
  <?php endforeach; ?>
</table>
