<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\Type\ContactFormType;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        //dump($request);
//
//        $form = $this->createFormBuilder()
//            ->add('from', EmailType::class)
//            ->add('message', TextareaType::class)
//            ->add('send', SubmitType::class)
//            ->getForm();

//        $form->handleRequest($request);

//        if($form->isSubmitted() && $form->isValid())
//        {
//            $message = \Swift_Message::newInstance()
//                ->setSubject('Contact Form Submission')
//                ->setFrom($form->getData()['from'])
//                ->setTo('figlerrenata85@gmail.com')
//                ->setBody($form->getData()['message'],
//                    'text/plain');
//
//            $this->get('mailer')->send($message);
//             $ourFormData = $form->getData();
        //dump($ourFormData);
//            $from = $ourFormData['from'];
//            $message = $ourFormData['message'];
        //dump($from, $message);
//        }

        $form = $this->createForm(ContactFormType::class, null,
            ['action' => $this->generateUrl('handle_form_submission')]);

        return $this->render('support/index.html.twig',
            ['our_form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @Route("/form-submission", name="handle_form_submission")
     * @Method("POST")
     * @return
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->redirectToRoute('homepage');
        }
        $message = \Swift_Message::newInstance()
            ->setSubject('Contact Form Submission')
            ->setFrom($form->getData()['from'])
            ->setTo('figlerrenata85@gmail.com')
            ->setBody($form->getData()['message'],
                'text/plain');

        $this->get('mailer')->send($message);

        $this->addFlash('success', 'Your message was sent!');

        return $this->redirectToRoute('homepage');
    }
}
