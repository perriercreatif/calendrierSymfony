<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\PlanningRecurrent as PlanningRecurrent;

class PlanningRecurrentController extends AbstractController
{
    public function indexActionAdmin(){
        // Retrieve entity manager
        $em = $this->getDoctrine()->getManager();

        // Get repository of appointments
        $repositoryAteliers = $em->getRepository("App:PlanningRecurrent");

        // Note that you may want to filter the appointments that you want to send
        // by dates or something, otherwise you will send all the calendriers to render
        $ateliers = $repositoryAteliers->findAll();

        // Generate JSON structure from the calendriers to render in the start scheduler.
        $formatedAteliers = $this->formatAteliersToJson($ateliers);

        // Render scheduler
        return $this->render("calendrier/planningRecurrentAdmin.html.twig", [
            'planningRecurrent' => $formatedAteliers
        ]);
    }

    public function indexAction(){
        // Retrieve entity manager
        $em = $this->getDoctrine()->getManager();

        // Get repository of appointments
        $repositoryAteliers = $em->getRepository("App:PlanningRecurrent");

        // Note that you may want to filter the appointments that you want to send
        // by dates or something, otherwise you will send all the calendriers to render
        $ateliers = $repositoryAteliers->findAll();

        // Generate JSON structure from the calendriers to render in the start scheduler.
        $formatedAteliers = $this->formatAteliersToJson($ateliers);

        // Render scheduler
        return $this->render("calendrier/planningRecurrent.html.twig", [
            'planningRecurrent' => $formatedAteliers
        ]);
    }


    public function createAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAteliers = $em->getRepository("App:PlanningRecurrent");

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        $ateliers = new PlanningRecurrent();
        $ateliers->setTitre($request->request->get("titre"));
        $ateliers->setEventLength($request->request->get("event_length"));
        $ateliers->setRecType($request->request->get("rec_type"));
        //$ateliers->setEventPid($request->request->get("event_pid"));
        $ateliers->setDescription($request->request->get("description"));
        $ateliers->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $ateliers->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );



        // Create appointment
        $em->persist($ateliers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }


    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryAteliers = $em->getRepository("App:PlanningRecurrent");

        $atelierId = $request->request->get("id");

        $ateliers = $repositoryAteliers->find($atelierId);

        if(!$ateliers){
            return new JsonResponse(array(
                "status" => "erreur",
                "message" => "Le rendez-vous pour mettre à jour $atelierId n'existe pas."
            ));
        }

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Update fields of the appointment
        $ateliers->setTitre($request->request->get("titre"));
        $ateliers->setDescription($request->request->get("description"));
        $ateliers->setEventLength($request->request->get("event_length"));
        $ateliers->setRecType($request->request->get("rec_type"));
        //$ateliers->setEventPid($request->request->get("event_pid"));
        $ateliers->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $ateliers->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );


        // Update appointment
        $em->persist($ateliers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    public function deleteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAteliers = $em->getRepository("App:PlanningRecurrent");

        $atelierId = $request->request->get("id");

        $ateliers = $repositoryAteliers->find($atelierId);

        if (!$ateliers) {
            return new JsonResponse(array(
                "status" => "erreur",
                "message" => "Le rendez-vous pour mettre à jour $atelierId n'existe pas."
            ));
        }
        // Remove appointment from database !
        $em->remove($ateliers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     *
     *
     * @param $atelier
     */


    private function formatAteliersToJson($ateliers){
        $formatedAteliers = array();

        foreach($ateliers as $atelier){
            array_push($formatedAteliers, array(
                "id" => $atelier->getId(),
                "titre" => $atelier->getTitre(),
                "description" => $atelier->getDescription(),
                "start_date" => $atelier->getStartDate()->format("Y-m-d H:i"),
                "end_date" => $atelier->getEndDate()->format("Y-m-d H:i"),
                "event_length" => $atelier->getEventLength(),
                "rec_type" => $atelier->getRecType()
                //"event_pid" => $atelier->getEventPid()
            ));
        }
        return json_encode($formatedAteliers);

    }

}
