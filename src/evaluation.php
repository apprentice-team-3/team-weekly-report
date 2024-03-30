<!-- $content = __DIR__ . '/views/evaluation.php';
include __DIR__ . '/views/evaluation_layout.php'; -->
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>評価一覧画面</title>
<style>
  /* ここにCSSを記述 */
  .container {
    display: flex;
    justify-content: space-around;
  }
  .card {
    border: 1px solid #ccc;
    padding: 20px;
    margin: 10px;
  }
  /* その他のスタイリング */
</style>
</head>
<body>
<div class="container">
  <?php
  // データの配列
  $reports = [
    ["title" => "3月1週目", "progress" => 35, "goal" => 20, "remainder" => 10],
    ["title" => "今後のプロジェクト 50% 完了", "progress" => 35, "goal" => 20, "remainder" => 10]
    // その他のデータ...
  ];

  // データをループしてカードを表示
  foreach ($reports as $report) {
    echo '<div class="card">';
    echo '<h2>' . htmlspecialchars($report["title"], ENT_QUOTES, 'UTF-8') . '</h2>';
    // プログレスバーやその他のコンテンツをここに表示
    echo '</div>';
  }
  ?>
</div>
</body>
</html>
