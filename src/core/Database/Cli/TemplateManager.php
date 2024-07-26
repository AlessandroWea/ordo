<?php

namespace Ordo\Database\Cli;

class TemplateManager
{
	private string $propertie_template =
	"    #[ORM\Column]\n    private {type} $[name];\n\n";

	private string $setter_template =
	"    public function set{Name}\n    {\n        " . '$this->{name} = {name};' ."\n    }\n\n";

	private string $entity_template_path = ROOT . '/Cli/templates/entity.template.php';
	private string $entity_output_path = ROOT . '/../../app/models/';

	private string $repository_template_path = ROOT . '/Cli/templates/repository.template.php';
	private string $repository_output_path = ROOT . '/../../app/repositories/';

	public function makeEntity($className, $parameters)
	{
		//create a new entity
		$template = file_get_contents($this->entity_template_path);

		foreach($parameters as $parameter){
			$prop_templates[] = str_replace(['{type}','[name]'], [$parameter['type'], $parameter['name']], $this->propertie_template);

			$setter_templates[] = str_replace(['{Name}', '{name}'], [ucfirst($parameter['name']), $parameter['name']], $this->setter_template);

		}

		$tableName = lcfirst($className) . 's';

		$template = str_replace(
			['{CLASS}','{TABLE}',	'{PROPERTIES}',				'{METHODS}'],
			[$className, $tableName, implode('', $prop_templates), implode('', $setter_templates)],
			$template);

		$outputPath = $this->entity_output_path . $className . '.php';
		
		return file_put_contents($outputPath, $template);
	}

	public function makeRepository($className)
	{
		$template = file_get_contents($this->repository_template_path);
		$template = str_replace('{class}', $className, $template);

		$outputPath = $this->repository_output_path . $className . 'Repository.php';
		return file_put_contents($outputPath, $template);
	}
}