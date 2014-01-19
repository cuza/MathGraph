<div class="editor">

    {if $men}
        {$men.texto}
    {/if}

    <div class="da-panel">

        <div class="da-panel-header">
            <span class="da-panel-title">
                Funciones
            </span>
        </div>


        <div class="da-panel-toolbar top">
            <ul>
                <li><a href="#" onclick="AddFuncion()">Agregar</a></li>
                <li><a href="#" onclick="EliminarSel('delFunciones')">Eliminar</a></li>
            </ul>
        </div>

        <div class="da-panel-content">

            <form id="check-form" action="index.php" method="post">
                <input type="hidden" name="action" id="check-form-action"/>

                <table id="da-ex-datatable" class="da-table">

                    <thead>
                    <tr>
                        <th class="no_sort"><input type="checkbox" id="check_all_item"/></th>
                        <th>Funcion</th>
                        <th>Descripción</th>

                        <th class="no_sort center">Opciones</th>
                    </tr>

                    </thead>
                    <tbody>

                    {foreach from=$funciones item=f}
                        <tr>

                            <td class="peque"><input type="checkbox" name="check_item[]" class="check_item"
                                                     value="{$f.id}"/></td>
                            <td>{$f.funcion}</td>
                            <td>{$f.desc}</td>

                            <td class="center peque">
                                <a onclick="Ver('Funcion','{$f.funcion}')" href="#" class="da-button gray"> Ver </a>
                                <a onclick="EditFuncion('{$f.id}','{$f.funcion}','{$f.desc}')" href="#"
                                   class="da-button gray"> Editar</a>
                                <br>
                                <a onclick="Eliminar('Funcion','{$f.id}')" href="#" class="da-button gray">
                                    Eliminar </a>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>