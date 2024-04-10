<?php
    include_once './conexao.php';

    $query = "SELECT * FROM events";

    $results = $conn->prepare($query);
    $results->execute();

    $eventos = [];

    while($rows = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($rows);
        $eventos[] = [
          'id' => $id,
          'title' => $title,
          'color' => $color,
          'start' => $start,
          'end' => $end
        ];
    }
echo json_encode($eventos);
