<?php
/**
 * Technooze_Tnav extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Tnav
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Technooze
 * @package    Technooze_Tnav
 * @author     Damodar Bashyal (http://dltr.org/)
 */
class Technooze_Tnav_Adminhtml_TnavController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('tnav/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Categories Manager'), Mage::helper('adminhtml')->__('Category Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('tnav/tnav')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('tnav_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('tnav/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Category Manager'), Mage::helper('adminhtml')->__('Category Manager'));
            /*$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));*/

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('tnav/adminhtml_tnav_edit'))
                ->_addLeft($this->getLayout()->createBlock('tnav/adminhtml_tnav_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tnav')->__('Category does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {

        if ($data = $this->getRequest()->getPost()) {
            $delete = array();
            $id = $this->getRequest()->getParam('id');

            if (isset($data['thumbnail']['delete'])) {
                $delete[] = 'thumbnail';
                unset($data['thumbnail']);
            }
            if (isset($data['thumbnail']['value'])) {
                $data['thumbnail'] = $data['thumbnail']['value'];
            }
            if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != '') {
                try {
                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('thumbnail');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(true);

                    // We set media as the upload dir
                    $path = Mage::getBaseDir('media') . DS . 'tnav' . DS;
                    $result = $uploader->save($path, $_FILES['thumbnail']['name']);

                    //this way the name is saved in DB
                    $data['thumbnail'] = 'tnav' . $result['file']; //$_FILES['thumbnail']['name'];

                } catch (Exception $e) {}
            }

            /*Remove previous data, if delete is selected*/
            $model = Mage::getModel('tnav/tnav');
            $model->load($id);
            foreach ($delete as $f)
            {
                $model->setData($f, '');
            }
            $model->save();

            /*Save new data*/
            $model = Mage::getModel('tnav/tnav');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('tnav')->__('Category was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tnav')->__('Unable to find category to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('tnav/tnav');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Category was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $tnavIds = $this->getRequest()->getParam('tnav');
        if (!is_array($tnavIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select category(s)'));
        } else {
            try {
                foreach ($tnavIds as $tnavId) {
                    $tnav = Mage::getModel('tnav/tnav')->load($tnavId);
                    $tnav->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($tnavIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $tnavIds = $this->getRequest()->getParam('tnav');
        if (!is_array($tnavIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($tnavIds as $tnavId) {
                    $tnav = Mage::getSingleton('tnav/tnav')
                        ->load($tnavId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($tnavIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName = 'tnav.csv';
        $content = $this->getLayout()->createBlock('tnav/adminhtml_tnav_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName = 'tnav.xml';
        $content = $this->getLayout()->createBlock('tnav/adminhtml_tnav_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}