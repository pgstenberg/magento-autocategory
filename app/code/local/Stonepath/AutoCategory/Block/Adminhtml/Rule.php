<?php


class Stonepath_AutoCategory_Block_Adminhtml_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_rule";
	$this->_blockGroup = "autocategory";
	$this->_headerText = Mage::helper("autocategory")->__("Rule Manager");
	
	$this->_addButton('adminhtml_rule', array(
        'label' => $this->__('Apply All Rules'),
        'onclick' => "setLocation('{$this->getUrl('*/*/apply')}')",
        'class' => "save"
    ));
	
	$this->_addButtonLabel = Mage::helper("autocategory")->__("Add New Item");
	parent::__construct();
	
	
	
	
	}

}