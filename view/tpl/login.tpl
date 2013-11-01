<div class="panellogin">

{if $men}
    {$men.texto}
{/if}

    <div id="efecto">

        <div class="da-panel">

            <div class="da-panel-header">

    <span class="da-panel-title">
        Entrada al Sistema
    </span>

            </div>

            <div class="da-panel-content">
                <form class="da-form" id="login-form" method="post" action="index.php">

                    <input type="hidden" name="action" value="login"/>

                    <div class="da-form-row">
                        <label>Usuario</label>

                        <div class="da-form-item default">
                            <input type="text" name="nick"/>
                        </div>
                    </div>

                    <div class="da-form-row">
                        <label>Contraseña</label>

                        <div class="da-form-item default">
                            <input type="password" name="pass"/>
                        </div>
                    </div>

                    <div class="da-form-row">
                        <div class="small">
                            <input type="submit" value="Entrar" class="da-button blue"/>
                        </div>
                    </div>

                </form>
            </div>


        </div>


    </div>

</div>

{if $men}
<script type="text/javascript"> $("#efecto").effect("shake", 100); </script>
{/if}