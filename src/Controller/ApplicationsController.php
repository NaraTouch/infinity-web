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
			$component = $layout[0]->subpages[0]->name.'-'.$layout[0]->subpages[0]->tag_links;
		} else {
			$tag_link = explode('/', $tag_link);
			foreach ($layout as $key => $value) {
				foreach ($value->subpages as $k => $v) {
					if ($v->tag_links == $tag_link['1']) {
						$component = $v->name.'-'.$v->tag_links;
					}
				}
			}
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
}
