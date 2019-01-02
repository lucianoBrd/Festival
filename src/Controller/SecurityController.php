<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function registration(User $user = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        
        if(!$user){
            $user = new User();
        }

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        $editMode = $user->getId() != null;

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            
            if(!$editMode){
                return $this->redirectToRoute('security_login');
            } 
            return $this->redirectToRoute('user_all');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'editMode' => $editMode
        ]);
    }

    /**
     * @Route("/user/{id}/delete", name="user_delete")
     */
    public function delete(User $user = null, ObjectManager $manager){
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('user_all');
    }

    /**
     * @Route("/user", name="user_all")
     */
    public function allUser(UserRepository $repo, PaginatorInterface $paginator, Request $request){
        
        $users = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('security/all.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/motdepasse", name="forgotten_password")
     */
    public function forgottenPassword(UserRepository $repo, Request $request, ObjectManager $manager, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator){
       
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = $form->getData();
            $user = $repo->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                //return $this->redirectToRoute('security_login');
            }
            $token = $tokenGenerator->generateToken();
            $user->setResetToken($token);
            $manager->persist($user);
            $manager->flush();

            $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Mot de passe oublie'))
                ->setFrom('support@festival.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour, <br><br>Cliquer sur le lien suivant afin de reinitialiser votre mot de passe : <br><a href=".$url.'>lien</a><br><br>Cordialement,<br>Le festival.',
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('notice', 'Mail envoyé');

            //return $this->redirectToRoute('security_login');
        }

        return $this->render('security/forgotten_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset_password/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('homepage');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');

            return $this->redirectToRoute('homepage');
        }else {

            return $this->render('security/reset_password.html.twig', [
                'token' => $token
            ]);
        }

    }
    
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(){

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
