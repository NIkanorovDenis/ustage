<?
namespace Alexkova\Market2;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class CatalogMarkersComponent extends \CBitrixComponent{

    private $loadMode = array(
        'lazy', 'single', 'standart'
    );

    public function getPage() {
        $this->arResult['PAGE'] = 'standart';

        if (isset($this->arParams['LOAD_MODE'])
            && in_array($this->arParams['LOAD_MODE'], $this->loadMode)
        ) {
            $this->arResult['PAGE'] = $this->arParams['LOAD_MODE'];
        }
    }

}