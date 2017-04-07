<?php
// ATrophy/Bundle/MeatBundle/Controller/FeedbackController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use ATrophy\Entity\Meat\Feedback,
    ATrophy\Bundle\MeatBundle\Form\Type\FeedbackType;

class FeedbackController extends Controller
{
    public function sendAction(Request $request)
    {
        $feedback = new Feedback;

        $form = $this->createForm(new FeedbackType, $feedback);

        $form->handleRequest($request);

        if( !$form->isValid() )
        {
            $errors = $this->getErrorMessages($form);

            return new Response(implode("", $errors), 200);
        }

        $last_id = $this->saveFeedbackMessage($feedback);

        if( !$this->sendFeedbackMessage($feedback, $last_id) ) {
            $message = "<p class='success'>Извините, при отправке сообщения возникла ошибка. Попробуйте отправить еще раз через некоторое время</p>";
        } else {
            $message = "<p class='success'>Ваше сообщение отправлено и будет рассмотрено в ближайшее время!</p>";
        }

        return new Response($message, 200);
    }

    private function saveFeedbackMessage($feedback)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($feedback);

        $em->flush();

        return $feedback->getId();
    }

    private function sendFeedbackMessage($feedback, $last_id)
    {
        $messageAdmin = \Swift_Message::newInstance()

            ->setSubject("Новое сообщение обратной связи! (#{$last_id})")
            ->setFrom(
                [$this->container->getParameter('atrophy_meat.emails.no-reply') => "Интернет-магазин A-Trophy"]
            )
            ->setTo(
                $this->container->getParameter('atrophy_meat.emails.office')
            )
            ->setBody(
                $this->renderView('ATrophyMeatBundle:Email:feedback.html.twig', [
                    'addressee' => 'ADMIN',
                    'feedback'  => $feedback
                ]),
                'text/html'
            );

        $messageUser = \Swift_Message::newInstance()
            ->setSubject("Вы оставили сообщение обратной связи!")
            ->setFrom(
                [$this->container->getParameter('atrophy_meat.emails.no-reply') => "Интернет-магазин A-Trophy"]
            )
            ->setTo(
                $feedback->getEmail()
            )
            ->setBody(
                $this->renderView('ATrophyMeatBundle:Email:feedback.html.twig', [
                    'addressee' => 'USER',
                    'feedback'  => $feedback
                ]),
                'text/html'
            );

        return ( $this->get('mailer')->send($messageAdmin) && $this->get('mailer')->send($messageUser) ) ? TRUE : FALSE;
    }

    private function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        if ($form->count() > 0)
        {
            foreach ($form->all() as $child)
            {
                if (!$child->isValid()) {
                    $errors[] = "<p class='success'>" . implode("</p><p class='success'>", $this->getErrorMessages($child)) . "</p>";
                }
            }
        } else {
            foreach ($form->getErrors() as $key => $error) {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }
}