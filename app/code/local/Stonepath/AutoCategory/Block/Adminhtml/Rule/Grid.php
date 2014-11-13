<?php

class Stonepath_AutoCategory_Block_Adminhtml_Rule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("rulegrid");
				$this->setDefaultSort("rule_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("autocategory/rule")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				
				$this->addColumn("description", array(
				"header" => Mage::helper("autocategory")->__("Description"),
				"index" => "description",
				));
						
						$this->addColumn('category_id', array(
						'header' => Mage::helper('autocategory')->__('Category'),
						'index' => 'category_id',
						'type' => 'options',
						'options'=> Mage::helper("autocategory")->listCategories(),				
						));
						
				

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}

		

}