<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Masterminds\HTML5;
use PHPHtmlParser\Dom;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SearchController extends Controller
{
	public function getSearch(ServerRequestInterface $request, ResponseInterface $response, Client $client)
	{
		$validator = new \Validator\Validator($request->getQueryParams());
		$validator->required('query');
		$validator->notEmpty('query');
		if ($validator->isValid()) {
			try {
				$duckduckgoResponse = $client->get("https://duckduckgo.com/html/?q={$validator->getValue('query')}");
			} catch (\Exception $exception) {

				return $response->withJson([
					'success' => false,
					'errors' => [
						'Error while requesting duckduckgo api'
					]
				]);
			}

			$html = str_replace("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">", "<!DOCTYPE html>", $duckduckgoResponse->getBody()->getContents());
			$dom = new HTML5();
			$dom = $dom->loadHTML($html);
			$results = [];
			if ($dom->documentURI != null){
				foreach ($dom->getElementById('links')->childNodes as $element) {
					if ($element->nodeName != "#text" && $element->childNodes->length == 3 && $element->childNodes[1]->nodeName == 'div') {
						$title = str_replace("\n          \n          ", "",
							str_replace("\n          \n            ", "", $element->childNodes[1]->childNodes[3]->textContent));
						if (!empty($title)) {
							$description = $element->childNodes[1]->childNodes[5]->textContent;
							$url = urldecode(str_replace("/l/?kh=-1&uddg=", "", $element->childNodes[1]->childNodes[5]->getAttribute('href')));
							$urlFormated = urldecode(str_replace("\n                  ", "", $element->childNodes[1]->childNodes[7]->childNodes[1]->childNodes[3]->textContent));
							$icon = str_replace('//', 'https://', $element->childNodes[1]->childNodes[7]->childNodes[1]->childNodes[1]->childNodes[1]->childNodes[1]->getAttribute('src'));
							array_push($results, [
								'title' => $title,
								'description' => $description,
								'url' => $url,
								'url_truncated' => $urlFormated,
								'icon' => $icon
							]);
						}
					}
				}
			}

			try{
				$instantAnswersResponse = $client->get("https://api.duckduckgo.com/?q={$validator->getValue('query')}&format=json&no_redirect=1");
				$instantAnswers = json_decode($instantAnswersResponse->getBody()->getContents(), 1);
			}catch (\Exception $e){
				return $response->withJson([
					'success' => false,
					'errors' => [
						'Error while requesting duckduckgo instant answers api'
					]
				]);
			}

			return $response->withJson([
				'success' => true,
				'data' => [
					'results' => $results,
					'instant_answers' => $instantAnswers,
					'query' => $validator->getValue('query')
				]
			]);
		} else {

			return $response->withJson([
				'success' => false,
				'error' => $validator->getErrors()
			]);
		}
	}
}