<ul>
    <?php foreach(WorkSecurityUI::wModulosUsuario() as $modulo ){ ?>
        <li>
            <a href="<?php echo Utilidades::getBaseUrl().$modulo['modruta'];?>" >
                <span><?php echo $modulo['modnombre'];?></span>
            </a>
        </li>
    <?php } ?>
</ul>