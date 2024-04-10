<?php
    include_once "./functions.php";
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-icons/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="css/toastr/toastr.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Agenda</title>
    </head>
    <body>

        <div id='calendar'></div>

        <!-- Modal View dados -->
        <div class="modal fade" tabindex="-1" role="dialog" id="viewModal" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewModalTitle">Informações</h1>
                        <h1 class="modal-title fs-5" id="viewEditModalTitle" style="display: none;">Editando...</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
<!--                        Ver o evento com opção de editar-->
                        <div id="viewEvent">
                             <dl class="row">
                                 <dt class="col-sm-3">ID: </dt>
                                 <dt class="col-sm-9" id="view_id"></dt>

                                 <dt class="col-sm-3">Titulo: </dt>
                                 <dt class="col-sm-9" id="view_title"></dt>

                                 <dt class="col-sm-3">Início: </dt>
                                 <dt class="col-sm-9" id="view_start"></dt>

                                 <dt class="col-sm-3">Fim: </dt>
                                 <dt class="col-sm-9" id="view_end"></dt>
                             </dl>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-danger" name="btnViewRemove" id="btnViewRemove">Apagar</button>
                                <button type="submit" class="btn btn-warning btn-primary" name="btnViewEdit" id="btnViewEdit">Editar</button>
                            </div>
                        </div>
                        <!-- Ver as informações do evento para editar -->
                        <div id="viewEventEdit" style="display: none;">
                            <form method="POST" id="formEditEvent">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="edit_id" id="edit_id" value="">
                                <div class="row mb-3">
                                    <label for="add_title" class="col-sm-2 col-form-label">Título</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="edit_title" id="edit_title" placeholder="Título do Evento">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="edit_color" class="col-sm-2 col-form-label">Cor</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="edit_color" id="edit_color">
                                            <?php imprimirOpcoes(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="edit_start" class="col-sm-2 col-form-label">Inicio</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control" id="edit_start" name="edit_start" >
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="edit_end" class="col-sm-2 col-form-label">Fim</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control" id="edit_end" name="edit_end">
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-info" name="btnEditEventCancel" id="btnEditEventCancel">Cancelar</button>
                                    <button type="submit" class="btn btn-success" name="btnEditEvent" id="btnEditEvent">Salvar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cadastro -->
        <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Cadastrar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="formAddEvent">
                            <input type="hidden" name="action" value="add">
                            <div class="row mb-3">
                                <label for="add_title" class="col-sm-2 col-form-label">Título</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="add_title" id="add_title" placeholder="Título do Evento">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="add_color" class="col-sm-2 col-form-label">Cor</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="add_color" id="add_color">
                                        <?php imprimirOpcoes(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="add_start" class="col-sm-2 col-form-label">Inicio</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="add_start" name="add_start" >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="add_end" class="col-sm-2 col-form-label">Fim</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="add_end" name="add_end">
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success btn-primary" name="btnAddEvent" id="btnAddEvent">Cadastrar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="js/jquery-3.7.1.min.js"></script>
        <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="js/fullcalendar/dist/index.global.js"></script>
        <script src="js/fullcalendar/packages/bootstrap5/index.global.min.js"></script>
        <script src="js/fullcalendar/packages/core/locales-all.global.min.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/calendar.js"></script>
    </body>
</html>
