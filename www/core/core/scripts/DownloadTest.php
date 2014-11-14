<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * Downloads test for printing.
 */
final class DownloadTest extends DirectOutputScript
{
	protected final function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($genTests = Core::sendDbRequest('getGenTestById', $id)))
			return $this->stopDb($genTests, ErrorEffect::dbGet('test'));

		$test = $genTests[0];
		list($description, $questions, $lectureId) = array(
			$test[DbLayout::fieldGenTestDescription],
			$test[DbLayout::fieldGenTestGenerated],
			$test[DbLayout::fieldLectureId],
		);

		if (!($lectures = Core::sendDbRequest('getLectureById', $lectureId)))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll)
				&& (!$user->hasPrivileges(User::lecturesManageOwn)
					|| ($lectures[0][DbLayout::fieldUserId] != $user->getId())))
			return $this->stop(ErrorCode::lowPrivileges);

		if (!$questions)
			return $this->stop('the test has not been generated yet', 'cannot create test');

		$questions = explode(',', $questions);
		$selectedQuestions = array();
		$attachmentIds = array();
		foreach ($questions as $questionId)
		{
			if (!($qData = Core::sendDbRequest('getQuestionById', $questionId)))
				return $this->stopDb($qData, ErrorEffect::dbGet ('question'));

			$qData = $qData[0];
			$options = $qData[DbLayout::fieldQuestionOptions];
			$options = $options ? explode($options[0], substr($options, 1)) : array();

			$qAtt = $qData[DbLayout::fieldQuestionAttachments];
			$qAtt = $qAtt ? explode(';', $qAtt) : array();
			
			array_push($selectedQuestions, array(
				'text' => $qData[DbLayout::fieldQuestionText],
				'type' => $qData[DbLayout::fieldQuestionType],
				'options' => $options,
				'attachments' => $qAtt,
			));

			$attachmentIds = array_merge($attachmentIds, $qAtt);
		}

		$attachmentIds = array_unique($attachmentIds);
		$reverseIndex = array_flip($attachmentIds);
		foreach ($selectedQuestions as &$selQ)
		{
			$translated = array();
			foreach ($selQ['attachments'] as $selA)
			{
				array_push($translated, $reverseIndex[$selA] + 1);
			}
			$selQ['attachments'] = $translated;
		}

		$attachments = array();
		$folder = Config::get('paths', 'attachments');
		foreach ($attachmentIds as $attachmentId)
		{
			if (!($aData = Core::sendDbRequest('getAttachmentById', $attachmentId)))
				return $this->stopDb($aData, ErrorEffect::dbGet ('attachment'));

			$aData = $aData[0];
			array_push($attachments, array(
				'id' => $aData[DbLayout::fieldAttachmentId],
				'type' => $aData[DbLayout::fieldAttachmentType],
				'file' => $folder . $aData[DbLayout::fieldAttachmentFile],
			));
		}

		$this->setContentType('text/html');
		$this->generateTestHtml($description, $selectedQuestions, $attachments);
	}

	protected function generateTestHtml ($title, $questions, $attachments)
	{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<style type="text/css" media="all">

body {
	font-family: Georgia, serif;
	font-size: 12px;
	line-height: 1.5em;
}

h1 {
	margin-bottom: 1.5em;
	padding-top: 1.5em;
	page-break-before: always;
}
h1:first-child {
	page-break-before: auto;
}

ul, ol {
	padding-left: 2em;
}

.questions>li {
	font-size: 16px;
	font-weight: bold;
	list-style-position: outside;
	margin-bottom: 1em;
}

.questions>li>div {
	font-size: 12px;
	font-weight: normal;
}

.questionLabel {
	display: none;
}

.answerLabels {
	font-weight: bold;
	font-size: 11px;
}

.options {
	margin-top: 0.5em;
	padding-left: 2em;
}

.options>li {
	font-weight: bold;
	list-style-position: outside;
	list-style-type: upper-alpha;
}

.options>li>span {
	font-weight: normal;
}

.attachments>li {
	font-size: 16px;
	font-weight: bold;
	list-style-position: outside;
	margin-bottom: 1em;
}

.attachments>li>div {
	font-size: 12px;
	font-weight: normal;
}

.attachmentLabel {
	font-weight: bold;
}

pre.attachment {
	white-space: pre-wrap;
}

img.attachment {
	display: block;
}

span.attachment {
	display: block;
	white-space: pre-line;
}

		</style>
	</head>
	<body>
<?php
		$this->generateHeading($title);
?>
		<ol class="questions">
<?php
		foreach ($questions as $question)
		{
			echo "<li><div>\n";
			$this->generateQuestionHtml($question);
			echo "</div></li>\n";
		}
?>
		</ol>
<?php
		if (!empty($attachments))
		{
			$this->generateHeading('Attachments');
		}
?>
		<ol class="attachments">
<?php
		foreach ($attachments as $attachment)
		{
			echo "<li><div>\n";
			$this->generateAttachmentHtml($attachment);
			echo "</div></li>\n";
		}
?>
		</ol>
	</body>
</html>

<?php
	}

	protected function generateHeading ($title)
	{
		echo '<h1>', $title, '</h1>', "\n";
	}

	protected function generateQuestionHtml ($question)
	{

		echo '<span class="questionLabel">Question:</span>', "\n";
		echo $question['text'], "\n";

		$labels = array();
		switch ($question['type'])
		{
			case 'choice':
				$labels[] = 'single choice';
				break;
			case 'multi':
				$labels[] = 'multiple choice';
				break;
		}
		if (!empty($question['attachments']))
		{
			$plural = (count($question['attachments']) > 1);
			$labels[] = '<span class="attachmentRefs">see attachment' . ($plural ? 's' : '') .
					' ' .  implode(', ', $question['attachments']) . '</span>';
		}
		if (!empty($labels))
		{
			echo '<span class="answerLabels">(', implode('; ', $labels), ')</span>', "\n";
		}

		switch ($question['type'])
		{
			case 'choice':
				// continue
			case 'multi':
				echo '<ol class="options">', "\n";
				foreach ($question['options'] as $option)
				{
					echo "<li><span>$option</span></li>", "\n";
				}
				echo '</ol>', "\n";
				break;
		}
	}

	protected function generateAttachmentHtml ($data)
	{
		echo '<span class="attachmentLabel">[attachment: ', $data['type'], ']</span>';

		switch ($data['type'])
		{
			case 'code':
				echo '<pre class="attachment">',
						htmlspecialchars($this->getAttachmentContents($data['file'])),
					  '</pre>';
				break;
			case 'image':
				echo '<img class="attachment" src="./', '?action=DownloadAttachment&id=',
						$data['id'], '"/>';
				break;
			default:
				echo '<span class="attachment">',
						$this->getAttachmentContents($data['file']), '</span>';
		}
	}

	protected function getAttachmentContents ($filename)
	{
		$contents = file_get_contents($filename);
		return mb_convert_encoding($contents, 'UTF-8',
				mb_detect_encoding($content, 'UTF-8, ISO-8859-2', true));
	}
}

