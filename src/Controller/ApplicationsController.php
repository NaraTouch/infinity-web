<?php
namespace App\Controller;

class ApplicationsController extends AppController
{

	public function initialize(): void
	{
		$this->loadComponent('Setting');
		$this->loadComponent('User');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
	}

	public function app()
	{
		$check_layout = $this->checkFile(DIR_PROPERTIES, FILE_LAYOUT);
		if (!$check_layout) {
			return $this->goingToUrl('Setting', 'auth');
		} else {
			$tag_link = strtolower($this->request->getUri()->getPath());
			$layout = $this->readFile(DIR_PROPERTIES, FILE_LAYOUT);
			$_layout = $this->layout($layout, $tag_link);
			$_component = $this->component($_layout['component']);
			$this->set([
				'layout' => $_layout['data_layout'],
				'component' => $_component,
			]);
		}
	}

	public function layout($layout = null, $tag_link = null)
	{
		$component = '';
		if ($tag_link == '/') {
			$component = $layout[0]->name.'-'.$layout[0]->subpages[0]->tag_links;
		} else {
			$link = explode('/', $tag_link);
			foreach($link as $ar => $av) {
				if(empty($av))
					unset($link[$ar]);
			}
			$component = $this->componentFileName($link, $layout);
		}
		return [
			'data_layout' => (array) $layout,
			'component' => $component,
		];
	}

	public function component($file_name = null)
	{
		if (!$file_name) {
			return [];
		}
		$component = $this->readFile(DIR_PROPERTIES, $file_name.'.json');
		if ($component) {
			$component = (array) $component;
		}
		return $component;
	}

	public function componentFileName($link = null, $layout = null)
	{
		$count = count($link);
		$component = '';
		switch (strtolower($count)) {
			case 1:
				foreach ($layout as $key => $value) {
					$component = $layout[0]->name.'-'.$layout[0]->subpages[0]->tag_links;
				}
				break;
			case 2:
				foreach ($layout as $key => $value) {
					if ($value->tag_links == $link[1]) {
						if (!empty($value->subpages)) {
							$subpage = $value->subpages;
							foreach ($subpage as $k => $sub) {
								if ($sub->tag_links == $link[2]) {
									$component = $value->name.'-'.$sub->tag_links;
								}
							}
						}
					}
				}
				break;
			case 3:
					dump($link);
					//start with search data 
					// example url : http://localhost/infinity-web/home/about/test-test
					// test-test with become key search.
				break;
			default :
				$component = 'not found';
				break;
		}
		return $component;
	}
}
