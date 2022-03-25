<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\User;
use App\Entity\CategorySearch;
use App\Form\CategorySearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\BookRepository;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    /*public function index(): Response
    {$data=$this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render('book/index.html.twig', [
            'list' => $data,
            
        ]);
    }*/
   
    public function index(Request $request) {
        $categorySearch = new CategorySearch();
        $form = $this->createForm(CategorySearchType::class,$categorySearch);
        $form->handleRequest($request);
  
        $books= [];
        $books= $this->getDoctrine()->getRepository(Book::class)->findAll();
        if($form->isSubmitted() && $form->isValid()) {
          $category = $categorySearch->getCategory();
         
          if ($category!="") 
          {
            
            $books= $category->getBooks();
           // or
           //$books= $this->getDoctrine()->getRepository(Book::class)->findBy(['category' => $category] );
          }
            
            
          }
        
          return $this->renderForm('book/index.html.twig', [
            'form' => $form,
            'list' => $books,
        ]);
            
    }
    // this route represent the book added by a specified user
    /**
     * @Route("/byme", name="byme")
     */
    public function byme(): Response
    {   $us=$this->getUser();
        $data=$this->getDoctrine()->getRepository(Book::class)->findAll();
        if($us){
        return $this->render('book/byme.html.twig', [
            'list' => $data,
            
        ]);}
        else{
            return $this->render('book/erreur.html.twig');
        }
    }
      /**
     * @Route("/create", name="create")
     */
    public function create(Request $request , SluggerInterface $slugger){ 
        $isauth=$this->getUser();//To check if there is a user or not (loged in or not)
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $imageFile = $form->get('book_img')->getData();
            $bookFile = $form->get('book_content')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $book->setBookImg($newFilename);}
                if ($bookFile) {
                    $originalFilename = pathinfo($bookFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$bookFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $bookFile->move(
                            $this->getParameter('book_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $book->setBookContent($newFilename);}
        // the next 2 lines permit to get the current user
           $us=$this->getUser();
           $book->setUser($us);
           $em=$this->getDoctrine()->getManager();
           $em->persist($book);
           $em->flush();
        $this->addFlash('notice','Book added');
           return $this->redirectToRoute('book');
        }
        if($isauth){
        return $this->renderForm('book/create.html.twig', [
            'form' => $form,
        ]);}
        else{
            return $this->render('book/erreur.html.twig');
        }
        }
         /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request , SluggerInterface $slugger , int $id): Response
    { 
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $imageFile = $form->get('book_img')->getData();
            $bookFile = $form->get('book_content')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $book->setBookImg($newFilename);}
                if ($bookFile) {
                    $originalFilename = pathinfo($bookFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$bookFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $bookFile->move(
                            $this->getParameter('book_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $book->setBookContent($newFilename);}
         // the next 2 lines permit to get the current user
           $us=$this->getUser();
           $book->setUser($us);
           $em=$this->getDoctrine()->getManager();
           $em->persist($book);
           $em->flush();
        $this->addFlash('notice','Book updated');
           return $this->redirectToRoute('book');
        }
        
        return $this->renderForm('book/update.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
     $this->addFlash('notice','Book deleted');
        return $this->redirectToRoute('book');
    }
     /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id){
      $data=$this->getDoctrine()->getRepository(Book::class)->find($id);
      $data1=$this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render('book/details.html.twig', [
            'list' => $data,
            'list1'=>$data1,
        ]);
    }
    
   
}
