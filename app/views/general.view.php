<?php

/******************************************************************************************/
/***                                    PANTALLAS                                       ***/
/******************************************************************************************/
class GeneralView{

    public function showError($error) { // muestro una pantalla con mensaje de error
        require 'templates/error.phtml';
    } //showError

} //GeneralView