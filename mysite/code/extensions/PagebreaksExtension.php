<?php
/**
 * Parses content to add Pagebreaks to content.
 *
 * Usage in the templates:
 *		$Content.Pagebreaks
 *
 * Note: will only work with content produced by HtmlEditorField.
 */
class PagebreaksExtension extends Extension {

	private static $casting = array(
		'Pagebreaks' => 'HTMLText'
	);

	public function Pagebreaks() {

		$content = '<div class="main">' . $this->owner->value . '</div>';

		preg_match_all('/(<.*[^>]*>)?\\<\!--break-->(\<\\/.*>)?/i', $content, $matches);


		// Attach the file type and size to each of the links.
		for ($i = 0; $i < count($matches[0]); $i++) {

				$pagebreak = substr($matches[0][$i], 0, strlen($matches[0][$i]) - 4) . '</div> <div class="main mtm">';
				$content = str_replace($matches[0][$i], $pagebreak, $content);

		}

		return $content;
	}

}
