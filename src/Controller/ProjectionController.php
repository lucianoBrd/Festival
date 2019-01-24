<?php

namespace App\Controller;

use App\Entity\Projection;
use App\Form\ProjectionType;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProjectionRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProjectionRoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectionController extends AbstractController
{
    /**
     * @Route("/projection", name="projection")
     */
    public function index(Request $request, PaginatorInterface $paginator, ProjectionRepository $repo)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $projections = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('projection/index.html.twig', [
            'projections' => $projections
        ]);
    }

    /**
     * @Route("/projection/planning", name="projection_planning")
     */
    public function planning(CategoryRepository $repoCate, ProjectionRoomRepository $repoRoom, MovieRepository $repoMovie, ProjectionRepository $repoProjection, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $projections = $repoProjection->findAll();
        foreach($projections as $projection){
            $manager->remove($projection);
        }
        $salleLms = array();
        $salleCms = array();
        $salleUcrs = array();
        $salleHcs = array();
        
        $salles = $repoRoom->findAll();
        foreach($salles as $salle){
            foreach($salle->getIdCategory() as $cate){
                switch($cate->getName()){
                    case 'Longs Métrages': 
                        $salleLms[] = $salle;
                        break;
                    case 'Courts Métrages': 
                        $salleCms[] = $salle;
                        break;
                    case 'Un Certain Regard': 
                        $salleUcrs[] = $salle;
                        break;
                    case 'Hors Catégorie': 
                        $salleHcs[] = $salle;
                        break;
                }
            }
        }
        $lms = $repoMovie->findBy(['idCategory' => $repoCate->findOneBy(['name' => 'Longs Métrages'])->getId()]);
        $cms = $repoMovie->findBy(['idCategory' => $repoCate->findOneBy(['name' => 'Courts Métrages'])->getId()]);
        $ucrs = $repoMovie->findByIdCategory(['idCategory' => $repoCate->findOneBy(['name' => 'Un Certain Regard'])->getId()]);
        $hcs = $repoMovie->findByIdCategory(['idCategory' => $repoCate->findOneBy(['name' => 'Hors Catégorie'])->getId()]);
        $h = 8;
        $m = 00;

        $start = 13;
        $d= $start;
        $exitLm = false;
        $exitUcr = false; 
        $exitCm = false;
        $exitHc = false;
        $i = 0;
            while($d < $start+15){
                // lm
                if($d < $start + 11 && sizeof($lms)>$i){
                    $projection = new Projection();            
                    $time = '2019-05-'.$d.'T'.$h.':'.$m.':00';
                    $projection->setDate(new \DateTime($time))
                            ->setIdProjectionRoom($salleLms[mt_rand(0, sizeof($salleLms)-1)])
                            ->setIdMovie($lms[$i]);
                    foreach($lms[$i]->getIdDirector() as $dir){
                        $projection->addIdVip($dir);
                    }
                    $manager->persist($projection);
                    $h += floor($lms[$i]->getLength() / 60);
                    $m += ($lms[$i]->getLength() % 60);
                    if($m>=60){
                        $h += floor($m / 60);
                        $m = ($m % 60);
                    }
                    if($h >= 24){
                        $h = 8;
                        $m = 00;
                        $d++;
                        if($d>$start+15){
                            break;
                        }
                    }
                    
                } else{
                    $exitLm = true;
                }
                // ucr
                if($d < $start + 9 && sizeof($ucrs)>$i){
                    $projection = new Projection();            
                    $time = '2019-05-'.$d.'T'.$h.':'.$m.':00';
                    $projection->setDate(new \DateTime($time))
                            ->setIdProjectionRoom($salleUcrs[mt_rand(0, sizeof($salleUcrs)-1)])
                            ->setIdMovie($ucrs[$i]);
                    foreach($ucrs[$i]->getIdDirector() as $dir){
                        $projection->addIdVip($dir);
                    }
                    $manager->persist($projection);
                    $h += floor($ucrs[$i]->getLength() / 60);
                    $m += ($ucrs[$i]->getLength() % 60);
                    if($m>=60){
                        $h += floor($m / 60);
                        $m = ($m % 60);
                    }
                    if($h >= 24){
                        $h = 8;
                        $m = 00;
                        $d++;
                        if($d>$start+15){
                            break;
                        }
                    }
                    
                } else{
                    $exitUcr = true;
                }
                // cm
                if($d < $start + 1 && sizeof($cms)>$i){
                    $projection = new Projection();            
                    $time = '2019-05-'.$d.'T'.$h.':'.$m.':00';
                    $projection->setDate(new \DateTime($time))
                            ->setIdProjectionRoom($salleCms[mt_rand(0, sizeof($salleCms)-1)])
                            ->setIdMovie($cms[$i]);
                    foreach($cms[$i]->getIdDirector() as $dir){
                        $projection->addIdVip($dir);
                    }
                    $manager->persist($projection);
                    $h += floor($cms[$i]->getLength() / 60);
                    $m += ($cms[$i]->getLength() % 60);
                    if($m>=60){
                        $h += floor($m / 60);
                        $m = ($m % 60);
                    }
                    if($h >= 24){
                        $h = 8;
                        $m = 00;
                        $d++;
                        if($d>$start+15){
                            break;
                        }
                    }
                    
                } else {
                    $exitCm = true;
                }
                // hc
                if($d < $start + 12 && sizeof($hcs)>$i){
                    $projection = new Projection();            
                    $time = '2019-05-'.$d.'T'.$h.':'.$m.':00';
                    $projection->setDate(new \DateTime($time))
                            ->setIdProjectionRoom($salleHcs[mt_rand(0, sizeof($salleHcs)-1)])
                            ->setIdMovie($hcs[$i]);
                    foreach($hcs[$i]->getIdDirector() as $dir){
                        $projection->addIdVip($dir);
                    }
                    $manager->persist($projection);
                    $h += floor($hcs[$i]->getLength() / 60);
                    $m += ($hcs[$i]->getLength() % 60);
                    if($m>=60){
                        $h += floor($m / 60);
                        $m = ($m % 60);
                    }
                    if($h >= 24){
                        $h = 8;
                        $m = 00;
                        $d++;
                        if($d>$start+15){
                            break;
                        }
                    }
                    
                } else{
                    $exitHc = true;
                }
                if($exitLm && $exitUcr && $exitCm && $exitHc){
                    break;
                }
                $i++;
            }       
        
        
        $manager->flush();
        $this->addFlash('success', 'Planning créé');
        return $this->redirectToRoute('projection');
    }

    private function checkConstraint(Projection $projection, ProjectionRepository $repoProjection){
        $date = $projection->getDate();
        $check = $repoProjection->findBy(['date' => $date]);
        if($check){
            return false;
        }
        $projections = $repoProjection->findBy(['idProjectionRoom' => $projection->getIdProjectionRoom()->getId()]);
        foreach($projections as $p){
            $h = $p->getdate()->format('H');
            $m = $p->getdate()->format('i');
            $afterH =  $h + floor($p->getIdMovie()->getLength() / 60);
            $afterM= $m + ($p->getIdMovie()->getLength() % 60);
            if($afterM>=60){
                $afterH += floor($afterM / 60);
                $afterM = ($afterM % 60);
            }
            if($afterH >= 24){
                $afterH = 8;
                $afterM = 00;
            }
            if($date->format('H') > $h && $date->format('i') > $m && $date->format('H') < $afterH && $date->format('i') < $afterM){
                return false;
            } 
        }
        return true;
    }

    /**
     * @Route("/projection/new", name="projection_create")
     * @Route("/projection/{id}/edit", name="projection_edit")
     */
    public function manage(Request $request, ObjectManager $manager, Projection $projection = null, ProjectionRepository $repoProjection)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        if (!$projection) {
            $projection = new Projection();
        } 

        $editMode = $projection->getId() != null;

        $form = $this->createForm(ProjectionType::class, $projection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($this->checkConstraint($projection, $repoProjection)){
                $manager->persist($projection);
                $manager->flush();

                if (!$editMode) {
                    $this->addFlash('success', 'Projection créée');
                } else {
                    $this->addFlash('success', 'Projection modifiée');
                }

                return $this->redirectToRoute('projection');
            } else {
                $this->addFlash('danger', 'L\'heure est incorrecte');
                if (!$editMode) {
                    return $this->redirectToRoute('projection_create');
                } else {
                    return $this->redirectToRoute('projection_edit');
                }
            }
        }

        return $this->render('projection/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode,
            'projection' => $projection
        ]);
    }

    /**
     * @Route("/projection/{id}/delete", name="projection_delete")
     */
    public function delete(Projection $projection, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $manager->remove($projection);
        $manager->flush();
        $this->addFlash('success', 'Projection supprimée');
        return $this->redirectToRoute('projection');
    }

}
