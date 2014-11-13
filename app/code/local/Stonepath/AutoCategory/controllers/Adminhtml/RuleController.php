<?php

class Stonepath_AutoCategory_Adminhtml_RuleController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
		
				$this->loadLayout()->_setActiveMenu("autocategory/rule")->_addBreadcrumb(Mage::helper("adminhtml")->__("Rule  Manager"),Mage::helper("adminhtml")->__("Rule Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("AutoCategory"));
			    $this->_title($this->__("Manager Rule"));
			    
				
				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("AutoCategory"));
				$this->_title($this->__("Rule"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("autocategory/rule")->load($id);
				if ($model->getId()) {
					Mage::register("rule_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("autocategory/rule");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Rule Manager"), Mage::helper("adminhtml")->__("Rule Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Rule Description"), Mage::helper("adminhtml")->__("Rule Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("autocategory/adminhtml_rule_edit"))->_addLeft($this->getLayout()->createBlock("autocategory/adminhtml_rule_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("autocategory")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}
		
		
		public function applyAction(){
			Mage::helper("autocategory")->applyRule();
			Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Rules was successfully applied."));
			$this->_redirect("*/*/");
		}

		public function newAction()
		{

		$this->_title($this->__("AutoCategory"));
		$this->_title($this->__("Rule"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("autocategory/rule")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("rule_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("autocategory/rule");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Rule Manager"), Mage::helper("adminhtml")->__("Rule Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Rule Description"), Mage::helper("adminhtml")->__("Rule Description"));


		$this->_addContent($this->getLayout()->createBlock("autocategory/adminhtml_rule_edit"))->_addLeft($this->getLayout()->createBlock("autocategory/adminhtml_rule_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {


						$model = Mage::getModel("autocategory/rule")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();
						
						if($this->getRequest()->getParam("apply")){
							Mage::helper("autocategory")->applyRule($this->getRequest()->getParam("id"));
							Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Rule was successfully applied and saved."));
						}else{
							Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Rule was successfully saved"));
						}

						
						Mage::getSingleton("adminhtml/session")->setRuleData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setRuleData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("autocategory/rule");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
}
