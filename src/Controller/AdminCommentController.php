<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PaginationService;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comment_index")
     */
    public function index(CommentRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Comment::class)
            ->setLimit(5)
            ->setPage($page);
        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'éditer un commentaire
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     * @param Comment $comment
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire <strong>{$comment->getId()}</strong> a bien été enregistré."
            );
        }
        return $this->render('admin/comment/edit.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }

    /**
     * Permet de supprimer un commentaire
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le commentaire de {$comment->getAuthor()->getFullName()} a bien été supprimé."
        );
        return $this->redirectToRoute('admin_comments_index');
    }
}
