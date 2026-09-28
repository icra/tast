<?php

$db = new PDO('sqlite:db/db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->query(
    'SELECT id, created, json FROM participacions ORDER BY id'
);

$rows = [];
$columns = ['id', 'created'];

function displayValue($value){
    if (is_array($value)){
        return implode(
            '; ',
            array_map(
                fn($v) => is_scalar($v) ? (string)$v : json_encode($v, JSON_UNESCAPED_UNICODE),
                $value
            )
        );
    }

    if (is_bool($value)){
        return $value ? 'Yes' : 'No';
    }

    return $value ?? '';
}

while($record = $stmt->fetch(PDO::FETCH_ASSOC)){
    $data = json_decode($record['json'], true);
    if (!is_array($data)) {
        continue;
    }
    $row = [
        'id' => $record['id'],
        'created' => $record['created']
    ];

    /*
     * Questions
     */
    foreach($data['preguntes'] ?? [] as $question){
        $name = trim(
            strip_tags(
                html_entity_decode($question['text'] ?? '')
            )
        );

        if ($name === '') {
            continue;
        }

        $row[$name] = displayValue(
            $question['resposta'] ?? ''
        );

        // Municipality
        if ($name === 'On vius habitualment?') {
            $row['municipi'] =
                $question['resposta_municipi'] ?? '';
        }
    }

    /*
     * Tasting
     */
    foreach ($data['tast'] ?? [] as $key => $value) {
        $row["tast_$key"] = displayValue($value);
    }

    /*
     * Thumbs
     */
    foreach ($data['tast_thumb'] ?? [] as $key => $value) {
        $row["tast_thumb_$key"] = displayValue($value);
    }

    /*
     * Correct answers
     */
    foreach ($data['tast_respostes_correctes'] ?? [] as $key => $value) {
        $row["tast_correcte_$key"] = displayValue($value);
    }

    /*
     * Final questions
     */
    foreach ($data['preguntes_rapides_per_acabar'] ?? [] as $key => $value) {
        $row["final_$key"] = displayValue($value);
    }

    /*
     * Other fields
     */
    $row['explicans_que_en_penses_opcional'] =
        $data['explicans_que_en_penses_opcional'] ?? '';

    $row['lloc'] = $data['lloc'] ?? '';

    /*
     * Keep track of all columns
     */
    foreach ($row as $column => $value) {
        if (!in_array($column, $columns, true)) {
            $columns[] = $column;
        }
    }

    $rows[] = $row;
}

?>
<!doctype html>
<html lang="ca"><head>
  <meta charset="UTF-8">
  <title>Participacions</title>
  <style>
      body {
          font-family: Arial, sans-serif;
      }

      table {
          border-collapse: collapse;
      }

      th,
      td {
          border: 1px solid #ccc;
          text-align: left;
      }

      th {
          background: #eee;
          position: sticky;
          top: 0;
      }

      tr:nth-child(even) {
          background: #f8f8f8;
      }

      td{
        white-space:nowrap;
      }
  </style>
</head><body>
<h1>Participacions (taula plana)</h1>
<p>
  <?= count($rows) ?> registres · <?= count($columns) ?> columnes
</p>

<table border=1>
    <thead>
      <tr>
        <?php foreach ($columns as $column): ?>
          <th>
            <?= htmlspecialchars($column, ENT_QUOTES, 'UTF-8') ?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row): ?>
        <tr>
          <?php foreach ($columns as $column): ?>
            <td>
              <?= htmlspecialchars(
                  (string)($row[$column] ?? ''),
                  ENT_QUOTES,
                  'UTF-8'
              ) ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
</table>
