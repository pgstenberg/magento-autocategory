<?php
class Stonepath_AutoCategory_Block_Adminhtml_Rule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("rule_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("autocategory")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("autocategory")->__("Item Information"),
				"title" => Mage::helper("autocategory")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("autocategory/adminhtml_rule_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
