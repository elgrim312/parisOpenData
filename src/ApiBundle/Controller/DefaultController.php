<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
      $defaultData = ['message' => 'default  value data'];
      $form = $this->createFormBuilder($defaultData)
        ->add('apiDatas', ChoiceType::class, [
          'choices' => [
            'os' => 'os',
            'browser' => 'browser',
            'device' => 'device',
            'langue' => 'langue',
            'site' => 'site'
          ],
          'multiple' => TRUE
        ])
        ->add('send', SubmitType::class)
        ->getForm();

      $form->handleRequest($request);
      $arrayParse = [0 => 'os', 1 => 'browser'];

      if ($form->isSubmitted() && $form->isValid()) {

        $formValue = $form->getData();
        $datas = $formValue['apiDatas'];
        $arrayParse = [];

        foreach ($datas as $keyData => $valueData) {
            $arrayParse[$keyData] = $valueData;
        }
      }
      // insert value get in  api data
        $datas = $this->get('api.service.get_data_service')->RequestOpenData(1, $arrayParse);
        $parser = $this->get('api.service.parse_data');

        // parsed individualie data
        $dataParsed = [];
        foreach ($arrayParse as $array) {
          $dataParsed[$array] = $parser->parseFacet($datas, $array, 0.02);
        }
        $renderData = [
          'datasets' => $dataParsed,
          'form' => $form->createView()
        ];
        // return data to the view
        return $this->render('@Api/Default/index.html.twig',$renderData);
    }
}
