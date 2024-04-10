document.addEventListener('DOMContentLoaded', function() {

    toastr.options = {
        // Configuração do toastr
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var calendarEl = document.getElementById('calendar');
    const addModal = new bootstrap.Modal(document.getElementById('addModal'));
    const viewModal= new bootstrap.Modal(document.getElementById('viewModal'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Configuração do calendario
        themeSystem: 'bootstrap5',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'pt-br',
        navLinks: true,
        selectable: true,
        selectMirror: true,
        editable: true,
        dayMaxEvents: true,
        events: 'eventos.php',
        //Clique em cima de algo marcado na agenda
        eventClick: function (arg){
            // força o modal view ficar correto
            toggleDisplay("viewEvent", "block");
            toggleDisplay("viewModalTitle", "block");

            toggleDisplay("viewEventEdit", "none");
            toggleDisplay("viewEditModalTitle", "none");

            // resgata os valores para mostrar no modal
            document.getElementById("view_id").innerText = arg.event.id;
            document.getElementById("view_title").innerText = arg.event.title;
            document.getElementById("view_start").innerText = arg.event.start.toLocaleString();
            document.getElementById("view_end").innerText = arg.event.end !== null ? arg.event.end.toLocaleString() : arg.event.start.toLocaleString();

            document.getElementById("edit_id").value = arg.event.id;
            document.getElementById("edit_title").value = arg.event.title;
            document.getElementById("edit_color").value = arg.event.backgroundColor;
            document.getElementById("edit_start").value = convertDate(arg.event.start,"sql");
            document.getElementById("edit_end").value = arg.event.end !== null ? convertDate(arg.event.end,"sql") : convertDate(arg.event.start,"sql");

            // mostra o modal
            viewModal.show();
        },
        //Clique diretamente na agenda
        select: function (arg){
            //log das variaveis
            //console.log(arg);

            document.getElementById('add_title').value = "";
            document.getElementById('add_color').value = "";
            document.getElementById('add_start').value = convertDate(arg.start,'sql');
            document.getElementById('add_end').value = convertDate(arg.start,'sql');

            addModal.show();
        },
        // Evento para quando a pessoa aumenta ou diminui um evento
        eventResize: async function (arg) {

            // Coleta as informações do evento que alterou
            const editReForm = new FormData();

            editReForm.append('action', 'edit');
            editReForm.append('edit_id', arg.event.id);
            editReForm.append('edit_title', arg.event.title);
            editReForm.append('edit_color', arg.event.backgroundColor);
            editReForm.append('edit_start', convertDate(arg.event.start,"sql"));
            editReForm.append('edit_end', convertDate(arg.event.end.toISOString(),"sql"));

            // Envia para editar o evento
            const dadosReEdit = await fetch(events_manager,{
                method: "POST",
                body: editReForm
            });
            const responseReEdit = await dadosReEdit.json();

            //Verifica o status da resposta
            if(!responseReEdit['status']){
                toastr["error"](responseReEdit['msg']);
            } else {
                toastr["success"](responseReEdit['msg']);
            }

        },
        // Evento para quando movimentar algum evento
        eventDrop: async function (arg) {
            // Coleta as informações do evento que alterou
            const editReForm = new FormData();

            editReForm.append('action', 'edit');
            editReForm.append('edit_id', arg.event.id);
            editReForm.append('edit_title', arg.event.title);
            editReForm.append('edit_color', arg.event.backgroundColor);
            editReForm.append('edit_start', convertDate(arg.event.start,"sql"));
            editReForm.append('edit_end', convertDate(arg.event.end.toISOString(),"sql"));

            // Envia para editar o evento
            const dadosReEdit = await fetch(events_manager,{
                method: "POST",
                body: editReForm
            });
            const responseReEdit = await dadosReEdit.json();

            //Verifica o status da resposta
            if(!responseReEdit['status']){
                toastr["error"](responseReEdit['msg']);
            } else {
                toastr["success"](responseReEdit['msg']);
            }
        }
    });
    // Criar calendario
    calendar.render();

    // Arquivo principal com todas as escolhas no php
    const events_manager = "events_manager.php";

    // Função para adicionar um evento
    const formAddEvent = document.getElementById('formAddEvent');
    const btnAddEvent = document.getElementById('btnAddEvent');
    if(formAddEvent){
        formAddEvent.addEventListener('submit', async (e) => {
           e.preventDefault();

           btnAddEvent.value = "Salvando...";

           const dataForm= new FormData(formAddEvent);
            // console.log(dataForm);
           const dadosAdd= await fetch(events_manager,{
               method: "POST",
               body: dataForm
           });
            const responseAdd = await dadosAdd.json();

            //Verifica o status da resposta
            if(!responseAdd['status']){
                toastr["error"](responseAdd['msg']);
            } else {
                toastr["success"](responseAdd['msg']);

                //Reseta o formulario
                formAddEvent.reset();
                //cria um evento
                const newEvent = {
                    id: responseAdd['id'],
                    title: responseAdd['title'],
                    color: responseAdd['color'],
                    start: responseAdd['start'],
                    end: responseAdd['end']
                };
                //adiciona o evento criado no calendario
                calendar.addEvent(newEvent);
                //fecha o modal
                addModal.hide();
            }
            btnAddEvent.value = "Cadastrar";
        });
    }

    //Evento para mostrar o formulario para editar
    const btnViewEdit = document.getElementById('btnViewEdit');
    if(btnViewEdit){
        btnViewEdit.addEventListener("click",()=>{
            toggleDisplay("viewEvent");
            toggleDisplay("viewModalTitle");

            toggleDisplay("viewEventEdit");
            toggleDisplay("viewEditModalTitle");
        });
    }
    // Evento para voltar a aparencia de visualizar o evento
    const btnEditEventCancel = document.getElementById('btnEditEventCancel');
    if(btnEditEventCancel){
        btnEditEventCancel.addEventListener("click",()=>{
            toggleDisplay("viewEvent");
            toggleDisplay("viewModalTitle");

            toggleDisplay("viewEventEdit");
            toggleDisplay("viewEditModalTitle");
        });
    }

    // Função para editar um evento
    const btnEditEvent = document.getElementById("btnEditEvent");
    const formEditEvent = document.getElementById("formEditEvent");

    if(formEditEvent){
        formEditEvent.addEventListener("submit",async (e)=>{
            e.preventDefault();

            btnEditEvent.value = "Salvando...";

            const editForm = new FormData(formEditEvent);
            const dadosEdit = await fetch(events_manager,{
                method: "POST",
                body: editForm
            });

            const responseEdit = await dadosEdit.json();

            //Verifica o status da resposta
            if(!responseEdit['status']){
                toastr["error"](responseEdit['msg']);
            } else {
                toastr["success"](responseEdit['msg']);

                //Reseta o formulario
                formEditEvent.reset();
                //verifica se existe um evento
                const existEvent= calendar.getEventById(responseEdit['id']);
                if(existEvent){
                    //altera o evento existente
                    existEvent.setProp('title', responseEdit['title']);
                    existEvent.setProp('color', responseEdit['color']);
                    existEvent.setStart(responseEdit['start']);
                    existEvent.setEnd(responseEdit['end']);
                }
                //fecha o modal
                viewModal.hide();
            }

            btnEditEvent.value = "Salvar";
        });
    }

    // Função para remover um evento
    const btnViewRemove = document.getElementById("btnViewRemove");
    if(btnViewRemove){
        btnViewRemove.addEventListener("click", async ()=>{
            const removeConfim = window.confirm("Deseja apagar o evento?");
            if(removeConfim){
                const idEvent = document.getElementById("view_id").textContent;
                const removeForm = new FormData();

                removeForm.append('action', 'remove');
                removeForm.append('id', idEvent);

                const dadosRemove= await fetch(events_manager,{
                   method: "POST",
                   body: removeForm
                });

                const responseRemove = await dadosRemove.json();

                //Verifica o status da resposta
                if(!responseRemove['status']){
                    toastr["error"](responseRemove['msg']);
                } else {
                    toastr["success"](responseRemove['msg']);
                }
                // Se existir o evento com o id recuperado, deleta o evento
                const eventExistRemove = calendar.getEventById(idEvent);
                if(eventExistRemove){
                    eventExistRemove.remove();
                }

                viewModal.hide();
            }
        });
    }

    //===============================================
    // FUNÇÕES                                     ||
    //===============================================
    function convertDate(data, formato = 'br') {
        const dataObj = new Date(data);
        const ano = dataObj.getFullYear();
        const mes = String(dataObj.getMonth() + 1).padStart(2, '0');
        const dia = String(dataObj.getDate()).padStart(2, '0');
        const hora = String(dataObj.getHours()).padStart(2, '0');
        const minuto = String(dataObj.getMinutes()).padStart(2, '0');

        let dataFormatada;

        if (formato === 'br') {
            dataFormatada = `${dia}-${mes}-${ano} ${hora}:${minuto}`;
        } else if (formato === 'usa') {
            dataFormatada = `${mes}-${dia}-${ano} ${hora}:${minuto}`;
        } else if (formato === 'sql') {
            dataFormatada = `${ano}-${mes}-${dia} ${hora}:${minuto}`;
        } else {
            throw new Error('Formato inválido. Use "br"/"usa"/"sql".');
        }

        return dataFormatada;
    }

    function toggleDisplay(elementId, forceDisplay = null) {
        var element = document.getElementById(elementId);
        if (forceDisplay !== null) {
            element.style.display = forceDisplay;
        } else {
            element.style.display = element.style.display === "none" ? "block" : "none";
        }
    }
});
