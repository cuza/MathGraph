<div id="efecto">
    <div class="editor">

        {if $men}
            {$men.texto}
        {/if}

        <div class="da-panel">

            <div class="da-panel-header">
            <span class="da-panel-title">
                Usuarios
            </span>
            </div>


            <div class="da-panel-toolbar top">
                <ul>
                    <li><a href="#" onclick="AddUsuario()">Agregar</a></li>
                    <li><a href="#" onclick="EliminarSel('delUsuarios')">Eliminar</a></li>
                </ul>
            </div>

            <div class="da-panel-content">

                <form id="check-form" action="index.php" method="post">
                    <input type="hidden" name="action" id="check-form-action"/>

                    <table id="da-ex-datatable" class="da-table">

                        <thead>
                        <tr>
                            <th class="no_sort"><input type="checkbox" id="check_all_item"/></th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Rol</th>

                            <th class="no_sort center">Opciones</th>
                        </tr>

                        </thead>
                        <tbody>

                        {foreach from=$users item=u}
                            <tr>

                                <td class="peque"><input type="checkbox" name="check_item[]" class="check_item"
                                                         value="{$u.id}"/></td>
                                <td>{$u.nick}</td>
                                <td>{$u.name}</td>
                                <td>{$u.role}</td>

                                <td class="center peque">

                                    <a onclick="EditUsuario('{$u.id}','{$u.name}','{$u.nick}','{$u.pass}','{$u.role}')"
                                       href="#" class="da-button gray"> Editar</a>
                                    <br>
                                    <a onclick="Eliminar('Usuario','{$u.id}')" href="#" class="da-button gray">
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
</div>
{if $error=="si"}
    <script type="text/javascript"> $("#efecto").effect("shake", 100); </script>
{/if}