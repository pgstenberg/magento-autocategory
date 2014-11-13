<?php
class Stonepath_AutoCategory_Model_Mysql4_Rule extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("autocategory/rule", "rule_id");
    }
}