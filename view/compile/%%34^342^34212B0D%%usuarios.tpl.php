<?php /* Smarty version 2.6.26, created on 2013-06-11 04:10:20
         compiled from usuarios.tpl */
?>
    <div id="efecto">
        <div class="editor">

            <?php if ($this->_tpl_vars['men']): ?>
                <?php echo $this->_tpl_vars['men']['texto']; ?>

            <?php endif; ?>

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

                            <?php $_from = $this->_tpl_vars['users'];
                            if (!is_array($_from) && !is_object($_from)) {
                                settype($_from, 'array');
                            }
                            if (count($_from)):
                                foreach ($_from as $this->_tpl_vars['u']):
                                    ?>
                                    <tr>

                                        <td class="peque"><input type="checkbox" name="check_item[]" class="check_item"
                                                                 value="<?php echo $this->_tpl_vars['u']['id']; ?>
"/></td>
                                        <td><?php echo $this->_tpl_vars['u']['nick']; ?>
                                        </td>
                                        <td><?php echo $this->_tpl_vars['u']['name']; ?>
                                        </td>
                                        <td><?php echo $this->_tpl_vars['u']['role']; ?>
                                        </td>

                                        <td class="center peque">

                                            <a onclick="EditUsuario('<?php echo $this->_tpl_vars['u']['id']; ?>
                                                ','<?php echo $this->_tpl_vars['u']['name']; ?>
                                                ','<?php echo $this->_tpl_vars['u']['nick']; ?>
                                                ','<?php echo $this->_tpl_vars['u']['pass']; ?>
                                                ','<?php echo $this->_tpl_vars['u']['role']; ?>
                                                ')" href="#" class="da-button gray"> Editar</a>
                                            <br>
                                            <a onclick="Eliminar('Usuario','<?php echo $this->_tpl_vars['u']['id']; ?>
                                                ')" href="#" class="da-button gray"> Eliminar </a>

                                        </td>
                                    </tr>
                                <?php endforeach; endif;
                            unset($_from); ?>

                            </tbody>
                        </table>

                    </form>

                </div>


            </div>


        </div>
    </div>
<?php if ($this->_tpl_vars['error'] == 'si'): ?>
    <script type="text/javascript"> $("#efecto").effect("shake", 100); </script>
<?php endif; ?>