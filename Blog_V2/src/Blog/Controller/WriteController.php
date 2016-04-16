<?php
 namespace Blog\Controller;

 use Blog\Service\PostServiceInterface;
 use Zend\Form\FormInterface;
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class WriteController extends AbstractActionController
 {
     protected $postService;

     protected $postForm;

     public function __construct(
         PostServiceInterface $postService,
         FormInterface $postForm
     ) {
         $this->postService = $postService;
         $this->postForm    = $postForm;
     }

     public function addAction()
     {
       $request = $this->getRequest();

         if ($request->isPost()) {
             $this->postForm->setData($request->getPost());

             if ($this->postForm->isValid()) {
                 try {
                     \Zend\Debug\Debug::dump($this->postForm->getData());die();
                     $this->postService->savePost($this->postForm->getData());

                     return $this->redirect()->toRoute('blog');
                 } catch (\Exception $e) {
                     // Some DB Error happened, log it and let the user know
                 }
             }
         }

       return new ViewModel(array(
             'form' => $this->postForm
         ));
     }
 }
 ?>