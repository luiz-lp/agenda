<?php
/*
 *                                             <option value="#FFD700" style="color:#FFD700;">Amarelo</option>
                                            <option value="#FF0000" style="color:#FF0000;">Vermelho</option>
                                            <option value="#00FF00" style="color:#00FF00;">Verde</option>
                                            <option value="#0000FF" style="color:#0000FF;">Azul</option>
                                            <option value="#FF00FF" style="color:#FF00FF;">Magenta</option>
                                            <option value="#FFFF00" style="color:#FFFF00;">Ciano</option>
                                            <option value="#FFA500" style="color:#FFA500;">Laranja</option>
                                            <option value="#008000" style="color:#008000;">Verde Escuro</option>
                                            <option value="#800080" style="color:#800080;">Roxo</option>
                                            <option value="#FFC0CB" style="color:#FFC0CB;">Rosa Claro</option>
                                            <option value="#000000" style="color:#000000;">Preto</option>
                                            <option value="#FFFFFF" style="color:#FFFFFF;">Branco</option>
                                            <option value="#00CED1" style="color:#00CED1;">Azul Claro</option>
                                            <option value="#800000" style="color:#800000;">Marrom</option>
                                            <option value="#4682B4" style="color:#4682B4;">Aço Azul</option>
                                            <option value="#2E8B57" style="color:#2E8B57;">Verde Marinho</option>
                                            <option value="#FF6347" style="color:#FF6347;">Vermelho Coral</option>
                                            <option value="#4B0082" style="color:#4B0082;">Índigo</option>
                                            <option value="#DC143C" style="color:#DC143C;">Carmesim</option>
                                            <option value="#808000" style="color:#808000;">Oliva</option>
                                            <option value="#778899" style="color:#778899;">Cinza Ardósia</option>
                                            <option value="#BA55D3" style="color:#BA55D3;">Orquídea</option>
 */
function imprimirOpcoes($selecionado = null) {
    $opcoes = [
        ['cor' => 'Amarelo', 'rgb' => '#FFD700'],
        ['cor' => 'Vermelho', 'rgb' => '#FF0000'],
        ['cor' => 'Verde', 'rgb' => '#00FF00'],
        ['cor' => 'Azul', 'rgb' => '#0000FF'],
        ['cor' => 'Magenta', 'rgb' => '#FF00FF'],
        ['cor' => 'Ciano', 'rgb' => '#FFFF00'],
        ['cor' => 'Laranja', 'rgb' => '#FFA500'],
        ['cor' => 'Verde Escuro', 'rgb' => '#008000'],
        ['cor' => 'Roxo', 'rgb' => '#800080'],
        ['cor' => 'Rosa Claro', 'rgb' => '#FFC0CB'],
        ['cor' => 'Preto', 'rgb' => '#000000'],
        ['cor' => 'Branco', 'rgb' => '#FFFFFF'],
        ['cor' => 'Azul Claro', 'rgb' => '#00CED1'],
        ['cor' => 'Marrom', 'rgb' => '#800000'],
        ['cor' => 'Aço Azul', 'rgb' => '#4682B4'],
        ['cor' => 'Verde Marinho', 'rgb' => '#2E8B57'],
        ['cor' => 'Vermelho Coral', 'rgb' => '#FF6347'],
        ['cor' => 'Índigo', 'rgb' => '#4B0082'],
        ['cor' => 'Carmesim', 'rgb' => '#DC143C'],
        ['cor' => 'Oliva', 'rgb' => '#808000'],
        ['cor' => 'Cinza Ardósia', 'rgb' => '#778899'],
        ['cor' => 'Orquídea', 'rgb' => '#BA55D3'],
    ];
    echo "<option value='' selected>Selecione</option>";
    foreach ($opcoes as $opcao) {
        $selected = ($opcao['rgb'] == $selecionado) ? 'selected' : '';
        echo "<option value='{$opcao['rgb']}' style='color:{$opcao['rgb']};' $selected>{$opcao['cor']}</option>";
    }
}
