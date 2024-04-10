<?php
    include_once "./conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        switch ($action) {

            case "add":
                $query = "INSERT INTO events (title, color, start, end) VALUES (:title, :color, :start, :end)";
                $add_event = $conn->prepare($query);

                $add_event->bindParam(':title', $dados['add_title']);
                $add_event->bindParam(':color', $dados['add_color']);
                $add_event->bindParam(':start', $dados['add_start']);
                $add_event->bindParam(':end', $dados['add_end']);

                if($add_event->execute()){
                    $return = [
                        'status' => true,
                        'msg' => 'Evento cadastrado com sucesso',
                        'id' => $conn->lastInsertId(),
                        'title' => $dados['add_title'],
                        'color' => $dados['add_color'],
                        'start' => $dados['add_start'],
                        'end' => $dados['add_end']
                    ];
                } else {
                    $return = [
                        'status' => false,
                        'msg' => 'Error: evento não adicionado'
                    ];
                }
                break;

            case "edit":
                $query = "UPDATE events SET title=:title, color=:color, start=:start, end=:end WHERE id=:id";
                $edit_event = $conn->prepare($query);

                $edit_event->bindParam(':id', $dados['edit_id']);
                $edit_event->bindParam(':title', $dados['edit_title']);
                $edit_event->bindParam(':color', $dados['edit_color']);
                $edit_event->bindParam(':start', $dados['edit_start']);
                $edit_event->bindParam(':end', $dados['edit_end']);

                if($edit_event->execute()){
                    $return = [
                        'status' => true,
                        'msg' => 'Evento editado com sucesso',
                        'id' => $dados['edit_id'],
                        'title' => $dados['edit_title'],
                        'color' => $dados['edit_color'],
                        'start' => $dados['edit_start'],
                        'end' => $dados['edit_end']
                    ];
                } else {
                    $return = [
                        'status' => false,
                        'msg' => 'Error: evento não editado corretamente.'
                    ];
                }
                break;

            case "remove":
                if(!empty($dados['id'])){
                    $query = "DELETE FROM events WHERE id=:id";
                    $remove_event = $conn->prepare($query);

                    $remove_event->bindParam(':id', $dados['id']);

                    if($remove_event->execute()) {
                        $return = [
                            'status' => true,
                            'msg' => 'Evento apagado.'
                        ];
                    } else {
                        $return = [
                            'status' => false,
                            'msg' => 'Error: não apagado.'
                        ];
                    }
                } else {
                    $return = [
                        'status' => false,
                        'msg' => 'Error: ID do evento incorreto.'
                    ];
                }
                break;

            default:
                $return = [
                    'status' => false,
                    'msg' => 'Error nas opções.'
                ];
        }
        echo json_encode($return);

    }
}
