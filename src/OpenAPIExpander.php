<?php

declare(strict_types=1);

namespace PavelJanda\OpenAPIExpander;

final class OpenAPIExpander
{

	/**
	 * @var array
	 */
	private $components = [];

	/**
	 * @var array
	 */
	private $parameters = [];


	public function expand(array $specData): array
	{
		foreach ($specData['components']['schemas'] as $componentName => $component) {
			$this->components['#/components/schemas/' . $componentName] = $component;
		}

		foreach ($specData['components']['parameters'] as $parametersName => $parameters) {
			$this->parameters['#/components/parameters/' . $parametersName] = $parameters;
		}

		$this->diveAndReplace($specData);

		return $specData;
	}


	public function diveAndReplace(array &$refNode): void
	{
		foreach ($refNode as $key => $node) {
			if (is_array($refNode[$key])) {
				$this->diveAndReplace($refNode[$key]);
			} elseif ($key === '$ref' && is_string($node)) {
				if (strpos($node, '#/components/schemas/') !== false) {
					$name = str_replace('#/components/schemas/', '', $node);

					$refNode[$name] = $this->getComponent($node);

					unset($refNode['$ref']);

					$this->diveAndReplace($refNode[$name]);
				} else {
					$name = str_replace('#/components/parameters/', '', $node);

					$refNode[$name] = $this->getParameter($node);

					unset($refNode['$ref']);

					$this->diveAndReplace($refNode[$name]);
				}
			}
		}
	}


	private function getComponent(string $name): array
	{
		if (!isset($this->components[$name])) {
			throw new \RuntimeException(sprintf('Component %s not found', $name));
		}

		return $this->components[$name];
	}


	private function getParameter(string $name): array
	{
		if (!isset($this->parameters[$name])) {
			throw new \RuntimeException(sprintf('Parameter %s not found', $name));
		}

		return $this->parameters[$name];
	}
}
