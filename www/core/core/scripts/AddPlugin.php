<?php

namespace asm\core;
use asm\utils\Filesystem, asm\utils\Compression;

/**
 * @ingroup requests
 * Stores uploaded plugin file and adds new plugin entry to database.
 * @n @b Requirements: User::addPlugins privilege
 * @n @b Arguments:
 * @li @c name plugin name
 * @li @c plugin ZIP archive with plugin files and manifest
 */
final class AddPlugin extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::pluginsAdd))
			return;

		$inputs = array(
			'name' => array(
				'isName',
				'hasLength' => array(
					'min_length' => 5,
					'max_length' => 20,
				),
			),
		);
		if (!$this->isInputValid($inputs))
			return;

		$name = $this->getParams('name');

		if (Core::sendDbRequest('getPluginByName', $name))
			return $this->stop(ErrorCode::dbNameDuplicate);

		$pluginFile = $this->getUploadedFile('plugin');
		if (!$pluginFile)
			return;

		$pluginFolder = Config::get('paths', 'plugins') . $name;
		if (file_exists($pluginFolder))
			return $this->stop('plugin folder with requested name already exists', 'cannot create plugin folder');

		if (!Filesystem::createDir($pluginFolder))
			return $this->stop(ErrorCode::createFolder, 'cannot create plugin folder');

		if (!Compression::unzip($pluginFile, $pluginFolder))
		{
			$this->stop(ErrorCode::zip, 'cannot extract plugin files from archive');
			goto cleanup_error;
		}

		$manifestFile = $pluginFolder . DIRECTORY_SEPARATOR . 'manifest.xml';
		$manifest = null;
		if (!($manifest = $this->parsePluginManifest($manifestFile)))
		{
			$this->stop('plugin manifest missing or corrupted', 'cannot retrieve plugin properties');
			goto cleanup_error;
		}

		if (!file_exists($pluginFolder . DIRECTORY_SEPARATOR . $manifest['mainFile']))
		{
			$this->stop('plugin main file missing', 'plugin cannot be configured properly');
			goto cleanup_error;
		}

		if (!Core::sendDbRequest('addPlugin', $name, $manifest['type'],
				$manifest['description'], $name . '/' . $manifest['mainFile'],
				$manifest['arguments']))
		{
			$this->stopDb(false, ErrorEffect::dbAdd('plugin'));
			goto cleanup_error;
		}

		goto cleanup_success;

cleanup_error:

		Filesystem::removeDir($pluginFolder);
	
cleanup_success:
	
		Filesystem::removeFile($pluginFile);
	}

	protected function parsePluginManifest ($manifestFile)
	{
		$manifestString = file_get_contents($manifestFile);
		$manifestXml = @simplexml_load_string($manifestString);
		if (!$manifestXml)
		{
			return false;
		}

		$manifest = array(
			'type' => trim($manifestXml->type),
			'description' => trim($manifestXml->description),
			'mainFile' => trim($manifestXml->mainFile),
		);
		$arguments = array();
		foreach ($manifestXml->arguments->children() as $argument)
		{
			$arguments[] = trim($argument);
		}

		$manifest['arguments'] = implode(';', $arguments);

		return $manifest;
	}
}

