<div id="efecto">
    <div class="editor">

        {if $men}
            {$men.texto}
        {/if}


        <div class="da-panel">

            <div class="da-panel-header">
            <span class="da-panel-title">
                Alumnos
            </span>
            </div>

            <div class="da-panel-toolbar top">
                <ul>
                    <li><a href="#" onclick="AddAlumno()">Agregar</a></li>
                    <li><a href="#" onclick="EliminarSel('delAlumnos')">Eliminar</a></li>
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

                            <th class="no_sort center">Opciones</th>
                        </tr>

                        </thead>
                        <tbody>

                        {foreach from=$alumnos item=a}
                            <tr>

                                <td class="peque"><input type="checkbox" name="check_item[]" class="check_item"
                                                         value="{$a.id}"/></td>
                                <td>{$a.nick}</td>
                                <td>{$a.name}</td>

                                <td class="center peque">

                                    <a onclick="EditAlumno('{$a.id}','{$a.name}','{$a.nick}','{$a.pass}')" href="#"
                                       class="da-button gray"> Editar</a>
                                    <br>
                                    <a onclick="Eliminar('Alumno','{$a.id}')" href="#" class="da-button gray">
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