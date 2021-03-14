<?php

namespace App\Controller;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/custom_api/company/{id}", methods={"GET"}, name="company_index")
     */
    public function show(int $id): Response
	{
		$company = $this->getDoctrine()->getRepository(Company::class)->find($id);
		
		if ($company!==null ){
		$options = $company->getOptions();
		foreach ($options as $option){
			$option_to_array[$option->getName()][] = $option->getValue();
		}
		return new Response(json_encode([
			 'id'=>$company->getId(),
			 'name'=>$company->getName(),
			 'responsible'=>$company->getResponsible(),
			 'options'=>[$option_to_array]
			 ]));
		}
		else {
		return new Response(json_encode([
			 'error'=>'the company does not exist'
			 ]));
		}
	}
}
