<?php /* Smarty version 2.6.26, created on 2013-05-31 04:39:37
         compiled from cabecera.tpl */
?>
<div class="cabecera">

    <div>
        <h1><a href="index.php"> MathGraf </a></abbr></h1>
        <b>El mejor sitio de gráficos en Cuba</b>
    </div>

    <div class="menu">
        <ul>
            <?php $_from = $this->_tpl_vars['menu'];
            if (!is_array($_from) && !is_object($_from)) {
                settype($_from, 'array');
            }
            if (count($_from)):
                foreach ($_from as $this->_tpl_vars['m']):
                    ?>
                    <li>
                        <a <?php if ($this->_tpl_vars['m']['select'] == $this->_tpl_vars['select']): ?>class="select"<?php endif; ?>
                           href="<?php echo $this->_tpl_vars['m']['url']; ?>
"><?php echo $this->_tpl_vars['m']['texto']; ?>
                        </a></li>
                <?php endforeach; endif;
            unset($_from); ?>
        </ul>
    </div>

</div>

<div class="sepcabecera"></div>