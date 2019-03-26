<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Calendrier as Calendrier;



class SchedulerController extends AbstractController
{

    public function indexAction()
    {
        // Retrieve entity manager
        $em = $this->getDoctrine()->getManager();

        // Get repository of appointments
        $repositoryCalendriers = $em->getRepository("App:Calendrier");

        // Note that you may want to filter the appointments that you want to send
        // by dates or something, otherwise you will send all the calendriers to render
        $calendriers = $repositoryCalendriers->findAll();

        // Generate JSON structure from the calendriers to render in the start scheduler.
        $formatedCalendriers = $this->formatCalendriersToJson($calendriers);




        // Render scheduler
        return $this->render("scheduler.html.twig", [
            'calendrier' => $formatedCalendriers
        ]);
    }

    /**
     * Handle the creation of an calendrier.
     *
     */
    public function createAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryCalendriers = $em->getRepository("App:Calendrier");

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Create appointment entity and set fields values
        $calendriers = new Calendrier();
        $calendriers->setTitle($request->request->get("title"));
        $calendriers->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $calendriers->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );


        // Create appointment
        $em->persist($calendriers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     * Handle the update of the calendriers.
     *
     */
    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryCalendriers = $em->getRepository("App:Calendrier");

        $calendrierId = $request->request->get("id");

        $calendriers = $repositoryCalendriers->find($calendrierId);

        if(!$calendriers){
            return new JsonResponse(array(
                "status" => "erreur",
                "message" => "Le rendez-vous pour mettre à jour $calendrierId n'existe pas."
            ));
        }

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Update fields of the appointment
        $calendriers->setTitle($request->request->get("title"));
        $calendriers->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $calendriers->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );


        // Update appointment
        $em->persist($calendriers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     * Deletes an calendrier from the database
     *
     */
    public function deleteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryCalendriers = $em->getRepository("App:Calendrier");

        $calendrierId = $request->request->get("id");

        $calendriers = $repositoryCalendriers->find($calendrierId);

        if(!$calendriers){
            return new JsonResponse(array(
                "status" => "error",
                "message" => "Le rendez-vous donné $calendrierId n'existe pas."
            ));
        }

        // Remove appointment from database !
        $em->remove($calendriers);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     *
     *
     * @param $calendrier
     */

    private function formatCalendriersToJson($calendriers){
        $formatedCalendriers = array();

        foreach($calendriers as $calendrier){
            array_push($formatedCalendriers, array(
                "id" => $calendrier->getId(),
                // Is important to keep the start_date, end_date and text with the same key
                // for the JavaScript area
                // altough the getter could be different e.g:
                // "start_date" => $calendrier->getBeginDate();
                "text" => $calendrier->getTitle(),
                "start_date" => $calendrier->getStartDate()->format("Y-m-d H:i"),
                "end_date" => $calendrier->getEndDate()->format("Y-m-d H:i")
            ));
        }

        return json_encode($formatedCalendriers);
    }


}