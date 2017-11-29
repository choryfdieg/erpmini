<div>
    <p>Crear entidad desde una tabla</p>

    <form action="<?php echo Utilidades::getBaseUrl().'builder/WorkEntityBuilder/createEntity';?>" method="POST">

        <input type="hidden" name="build"/>

        <table>
            <tr>
                <td>
                    Motor de Bases:
                </td>
                <td colspan="2">
                    <select name="motor">
                        <option value="mysql">MYSQL</option>
                        <option value="as400">AS400</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Nombre del esquema:
                </td>
                <td>
                    <input type="text" value="" name="esquema"/>
                </td>
                <td>
                    Nombre de tabla:
                </td>
                <td>
                    <input type="text" value="" name="tabla"/>
                </td>
                <td>
                    Nombre del modulo:
                </td>
                <td>
                    <input type="text" value="" name="modulo"/>
                </td>
            </tr>        
            <tr>
                <td colspan="5"/>
                <td align="right">
                    <input type="submit" value="Generar"/>
                </td>
            </tr>
        </table>

    </form>
    
</div>

<div>

    <p>Crear registros de ejemplo</p>

    <form action="<?php echo Utilidades::getBaseUrl().'builder/WorkEntityBuilder/createFixtures';?>" method="POST">

        <input type="hidden" name="build"/>

        <table>
            <tr>                
                <td>
                    Nombre de tabla:
                </td>
                <td>
                    <input type="text" value="" name="tabla"/>
                </td>
                <td>
                    Nombre del modulo:
                </td>
                <td>
                    <input type="text" value="" name="modulo"/>
                </td>
                <td>
                    Cantidad:
                </td>
                <td>
                    <input type="text" value="" name="cantidad"/>
                </td>
            </tr>        
            <tr>
                <td colspan="5"/>
                <td align="right">
                    <input type="submit" value="Generar"/>
                </td>
            </tr>
        </table>

    </form>

</div>

<div>

    <p>Lista de Apis y rutas</p>
    
    
    <ul>
        <?php foreach ($rutas as $modulo => $controles) :?>
            <li><?php echo $modulo?></li>
            <ul>
                <?php foreach ($controles as $control => $acciones) :?>
                    <li><?php echo $control?></li>
                    <ul>
                        <?php foreach ($acciones as $accion) :?>
                            <li>
                                <a href="index.php/<?php echo "$modulo/" . str_replace('Control', '', $control) . "/$accion"?>"><?php echo $accion?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endforeach;?>
            </ul>
        <?php endforeach;?>
    </ul>
</div>