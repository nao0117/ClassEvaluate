<?php
$title="Teacher Evaluate";
$dsn = 'mysql:host=localhost:8889;dbname=teacher_evaluate;charset=utf8;';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}

$sql = 'SELECT count(*) FROM evaluate2';
$stmt = $pdo->query($sql);
$row_cnt = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<header>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
</header>
<body>
<h1><?php echo $title; ?></h1>
<h2>データ受け取り完了</h2>

<?php
$class = $_POST['kougi'];
$evaluation = $_POST['evaluation'];
$name = $_POST['name'];
$comment = $_POST['comment'];
/*入力フォームでmethodをpostに指定しているため＄＿POSTによって受け取る。入力したテキストはnameという名前で送信されているので＄_POST['name']となる*/

print ("次の新規データを追加しました<br />");
print ("$class<br />");
print ("$name<br />");
print ("$evaluation<br />");
print ("$comment<br />");

// SQL文を作成
//$sql = "UPDATE evaluate2 SET evaluation=:evaluation WHERE class=:class";
$sql = "INSERT INTO evaluate2 (num,class,name,evaluation,comment) VALUES (:num,:class,:name,:evaluation,:comment)";
$stmt = $pdo->prepare($sql);
// 更新する値と該当のIDを配列に格納する
$num = $row_cnt + 1;
$params = array(':evaluation' => $evaluation, ':class' => $class, ':name' =>$name, ':num' => $num, ':comment' => $comment);
// クエリ実行（データを取得）
$stmt->execute($params);


//一覧表示
$sql = "SELECT * FROM evaluate2";
$res = $pdo->query($sql);
?>

<h3>授業一覧</h3>
<p>授業総数</p>
<table>
  <tr>
    <th>登録番号</th>
    <th>講義名</th>
    <th>評価点</th>
    <th>教師名</th>
    <th>コメント</th>
  </tr>
<?php
foreach( $res as $value ) {
  echo "<tr>";
  echo "<td>$value[num]</td>";
  echo "<td>$value[class]</td>";
  echo "<td>$value[evaluation]</td>";
  echo "<td>$value[name]</td>";
  echo "<td>$value[comment]</td>";
  echo "</tr>";
}
?>

</table>

<p><a href="index.php">トップへ戻る</a></p>
</body>
