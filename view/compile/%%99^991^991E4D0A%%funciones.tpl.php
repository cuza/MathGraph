<?php /* Smarty version 2.6.26, created on 2013-06-05 09:32:53
         compiled from funciones.tpl */
?>
<div class="editor">

    <?php if ($this->_tpl_vars['men']): ?>
    <?php echo $this->_tpl_vars['men']['texto']; ?>

    <?php endif; ?>

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

                    <?php $_from = $this->_tpl_vars['funciones']; if (!is_array($_from) && !is_object($_from)) {
                        settype($_from, 'array');
                    }if (count($_from)):
                        foreach ($_from as $this->_tpl_vars['f']):
                            ?>
                        <tr>

                            <td class="peque"><input type="checkbox" name="check_item[]" class="check_item"
                                                     value="<?php echo $this->_tpl_vars['f']['id']; ?>
"/></td>
                            <td><?php echo $this->_tpl_vars['f']['funcion']; ?>
                            </td>
                            <td><?php echo $this->_tpl_vars['f']['desc']; ?>
                            </td>

                            <td class="center peque">

                                <a onclick="EditFuncion('<?php echo $this->_tpl_vars['f']['id']; ?>
                                        ','<?php echo $this->_tpl_vars['f']['funcion']; ?>
                                        ','<?php echo $this->_tpl_vars['f']['desc']; ?>
                                        ')" href="#" class="da-button gray"> Editar</a>
                                <br>
                                <a onclick="Eliminar('Funcion','<?php echo $this->_tpl_vars['f']['id']; ?>
                                        ')" href="#" class="da-button gray"> Eliminar </a>

                            </td>
                        </tr>
                            <?php endforeach; endif; unset($_from); ?>

                    </tbody>
                </table>

            </form>

        </div>


    </div>


</div>