<?php

namespace asm\core;

use asm\core\lang\Language;
use asm\core\lang\StringID;
use asm\utils\Filesystem;

final class ReloadManifests extends DataScript
{
	protected function body ()
	{
		$plugins = Repositories::getRepository(Repositories::Plugin)->findAll();
		$errors = [];
		foreach ($plugins as $plugin) {
			/** @var $plugin \Plugin */
			$dbArguments =
			$dbPhpFile = $plugin->getMainfile();
			$dbDescription = $plugin->getDescription();
			$dbArguments = explode(';', $plugin->getConfig());
			$pluginDirectory = $this->getMainDirectory($dbPhpFile);
			if ($pluginDirectory === false) { $errors[] = $plugin->getName(). ": " . Language::get(StringID::ReloadManifests_InvalidFolder); continue; }
			$manifestFile = Filesystem::combinePaths(
				Config::get('paths', 'plugins'),
				$pluginDirectory,
				"manifest.xml");
			$xml = new \DOMDocument();
			$success = $xml->load(realpath($manifestFile));
			if ($success === false) { $errors[] = $plugin->getName() . ": " . Language::get(StringID::ReloadManifests_MalformedXmlOrFileMissing); continue; }

			$fileDescription = $xml->getElementsByTagName('description')->item(0);
			$fileArguments = $xml->getElementsByTagName('argument');
			$fileArgumentsArray = [];
			for($i = 0; $i < $fileArguments->length; $i++) {
				$fileArgumentsArray[] = trim($fileArguments->item($i)->nodeValue);
			}
			$fileArgumentsString = implode(';', $fileArgumentsArray);
			if ($dbDescription !== trim($fileDescription->nodeValue)) {
				$errors[] = $plugin->getName() . ": " . Language::get(StringID::ReloadManifests_DescriptionMismatch);
				$plugin->setDescription(trim($fileDescription->nodeValue));
				Repositories::persist($plugin);
			}
			if ($plugin->getConfig() !== $fileArgumentsString) {
				$errors[] = $plugin->getName() . ": " . Language::get(StringID::ReloadManifests_ArgumentsMismatch);
				$plugin->setConfig($fileArgumentsString);
				Repositories::persist($plugin);
			}
		}
		Repositories::flushAll();

		if (count($errors) === 0) {
			$this->addOutput("text", Language::get(StringID::ReloadManifests_DatabaseCorrespondsToManifests));
		}
		else {
			$this->addOutput("text", implode('<br>', $errors));
		}
	}
	private function getMainDirectory($path)
	{
		$fragments = explode('/', $path);
		if (count($fragments) > 1 && strpos($fragments[0], "\\") === false)
		{
			return $fragments[0];
		}
		$fragments = explode("\\", $path);
		if (count($fragments) > 1 && strpos($fragments[0], "/") === false)
		{
			return $fragments[0];
		}
		return false;
	}
}

