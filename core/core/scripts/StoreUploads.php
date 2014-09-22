<?php

namespace asm\core;

/**
 * @ingroup requests
 * Stores pre-uploaded files and returns their storage IDs.
 * @n @b Requirements: user has to be logged in
 * @n @b Arguments: any number of uploaded files
 * @see UploadManager
 */
class StoreUploads extends UploadScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs())
			return;

		$uploadManager = UploadManager::instance();
		foreach ($this->getParams() as $name => $file)
		{
			$id = $uploadManager->store($file, $error);
			if ($id === false)
			{
				switch ($error)
				{
					case UploadManager::invalidFileData:
						return $this->stop(ErrorCode::corruptedData);
					case UploadManager::fileUploadError:
						return $this->stop(ErrorCode::upload);
					case UploadManager::fileMoveError:
						return $this->stop('could not move uploaded file');
				}
			}

			$this->addUploadedFileId($name, $id);
		}
	}
}

?>