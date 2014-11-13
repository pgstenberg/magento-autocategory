<?php
class Stonepath_AutoCategory_Model_Observer
{

			public function automizeCategory(Varien_Event_Observer $observer)
			{		
				/*
				
					UNCOMMENT FOR AUTOSAVE
				
				if(Mage::getStoreConfig('autocategory/settings/auto_on_save')){
					$product = $observer->getProduct();
					Mage::helper("autocategory")->applyRule(null,$product->getId());
				}
				*/
				
			}
			
			

		
}
