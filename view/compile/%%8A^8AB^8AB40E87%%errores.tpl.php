<?php /* Smarty version 2.6.26, created on 2013-06-05 09:33:36
         compiled from errores.tpl */
?>
<div class="editor">

    <?php if ($this->_tpl_vars['men']): ?>
        <?php echo $this->_tpl_vars['men']['texto']; ?>

    <?php endif; ?>

    <div class="da-panel">

        <div class="da-panel-header">
            <span class="da-panel-title">
                Errores
            </span>
        </div>


        <div class="da-panel-content">

            <form action="index.php" method="post" class="da-form">
                <input type="hidden" name="action" value="buscar-errores"/>


                <div class="da-form-row">

                    Desde
                    <input type="text" id="from" name="from" class="peque"
                           value="<?php echo $this->_tpl_vars['from']; ?>
"/>
                    Hasta
                    <input type="text" id="to" name="to" class="peque" value="<?php echo $this->_tpl_vars['to']; ?>
"/>

                    <input type="submit" value="Buscar" class="da-button gray"/>

                </div>

                <div class="da-form-row">
                    <?php $_from = $this->_tpl_vars['errores'];
                    if (!is_array($_from) && !is_object($_from)) {
                        settype($_from, 'array');
                    }
                    if (count($_from)):
                        foreach ($_from as $this->_tpl_vars['e']):
                            ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 2): ?>
                            <div class="da-form-row">
                                <label>Dominio: </label><label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 3): ?>
                            <div class="da-form-row">
                                <label>Interceptos:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 4): ?>
                            <div class="da-form-row">
                                <label>Signos:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 5): ?>
                            <div class="da-form-row">
                                <label>Asíntotas:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 6): ?>
                            <div class="da-form-row">
                                <label>Extremos:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 7): ?>
                            <div class="da-form-row">
                                <label>Monotonía:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 8): ?>
                            <div class="da-form-row">
                                <label>Inflexión:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 9): ?>
                            <div class="da-form-row">
                                <label>Concavidad y Convexidad:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                            <?php if ($this->_tpl_vars['e']['ind'] == 1): ?>
                            <div class="da-form-row">
                                <label>Gráfico a la función:</label> <label
                                    style="padding-left: 0px"><?php echo $this->_tpl_vars['e']['value']; ?>
                                </label>
                            </div>
                        <?php endif; ?>


                        <?php endforeach; endif;
                    unset($_from); ?>
                </div>


            </form>

        </div>


    </div>


</div>