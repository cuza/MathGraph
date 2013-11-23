<?php /* Smarty version 2.6.26, created on 2013-05-31 07:31:55
         compiled from funcAlumno.tpl */
?>


<div class="panelpasos">
    <div class="da-panel">

        <div class="da-panel-header">
            <span class="da-panel-title">
                Escoja una función...
            </span>
        </div>

        <div class="da-panel-content">

            <form class="da-form" id="func-form">
                <div class="da-form-row">
                    <?php if (count($this->_tpl_vars['funciones']) == 0): ?>
                        El Profesor no ha insertado ninguna funcion.
                    <?php endif; ?>
                    <?php $_from = $this->_tpl_vars['funciones'];
                    if (!is_array($_from) && !is_object($_from)) {
                        settype($_from, 'array');
                    }
                    if (count($_from)):
                        foreach ($_from as $this->_tpl_vars['f']):
                            ?>
                            <a class="da-button gray small button-funcion" item="normal" href="#"
                               onclick='GraficarFuncEstudiante("<?php echo $this->_tpl_vars['f']['funcion']; ?>
                                   ")'><?php echo $this->_tpl_vars['f']['desc']; ?>
                            </a>
                        <?php endforeach; endif;
                    unset($_from); ?>
                </div>

                <div class="da-form-row" id="escala-row">
                    <label>Escala: </label>

                    <div class="escala">
                        <b>x1: </b> <input type="text" value="" id="escx1" onchange="ValidarX1($(this))"/>
                        <b>x2: </b> <input type="text" value="" id="escx2" onchange="ValidarX2($(this))"/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>