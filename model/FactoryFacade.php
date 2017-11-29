<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FactoryFacade
 *
 * @author CirSisDGR
 */
class FactoryFacade {

    public static $TBAREAFACADE = 'flujo-caja/TbareaFacade.php';
    public static $TBACTIVIDAFACADE = 'flujo-caja/TbactividaFacade.php';
    public static $TBCONCEPTOFACADE = 'flujo-caja/TbconceptoFacade.php';
    public static $TBITEMFACADE = 'flujo-caja/TbitemFacade.php';

    public static function getFacade($facade){

        require_once $facade;

        $facadeName = basename($facade, '.php');

        $newFacade = new $facadeName();

        return $newFacade;
    }

}
?>
